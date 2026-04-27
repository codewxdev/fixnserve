@extends('layouts.app')

@section('title', 'Business Registry')

@section('content')
<div class="p-4 sm:p-6 lg:p-8 bg-bg-primary min-h-screen flex flex-col w-full" x-data="businessRegistry()">

    <div x-show="toast.show" x-transition class="fixed top-6 right-6 z-[100] bg-bg-secondary border-l-4 shadow-xl flex items-center gap-3 min-w-[300px] p-4 rounded-lg"
         :class="toast.type === 'error' ? 'border-semantic-error' : 'border-semantic-success'" style="display: none;" x-cloak>
        <i data-lucide="info" class="w-5 h-5" :class="toast.type === 'error' ? 'text-semantic-error' : 'text-semantic-success'"></i>
        <span x-text="toast.message" class="text-body-sm font-semibold text-text-primary"></span>
    </div>

    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 sm:mb-8 gap-4 shrink-0">
        <div class="min-w-0 flex-1">
            <h1 class="text-h3 sm:text-h2 font-bold tracking-tight text-text-primary flex items-center gap-3">
                <span class="p-2 bg-brand-primary/10 rounded-lg text-brand-primary border border-brand-primary/20 shrink-0">
                    <i data-lucide="building-2" class="w-5 h-5 sm:w-6 sm:h-6"></i>
                </span>
                Business Registry
            </h1>
            <p class="text-text-secondary text-body-sm mt-2">Manage all B2B clients, lifecycles, health scores, and subscriptions.</p>
        </div>

        <div class="flex flex-wrap items-center gap-3 w-full md:w-auto shrink-0">
            <button @click="exportCSV()" class="btn btn-secondary p-2 flex-1 md:flex-none flex items-center justify-center gap-2">
                <i data-lucide="download" class="w-4 h-4"></i> <span class="whitespace-nowrap">Export CSV</span>
            </button>
            <button class="btn btn-primary p-2 flex-1 md:flex-none flex items-center justify-center gap-2 shadow-lg">
                <i data-lucide="plus" class="w-4 h-4"></i> <span class="whitespace-nowrap">Add Business</span>
            </button>
        </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6 mb-6 sm:mb-8 shrink-0">
        <div class="card p-4 sm:p-5 flex items-center gap-4">
            <div class="w-12 h-12 rounded-full bg-brand-primary/10 text-brand-primary border border-brand-primary/20 flex items-center justify-center shrink-0">
                <i data-lucide="briefcase" class="w-6 h-6"></i>
            </div>
            <div>
                <p class="text-caption font-bold text-text-tertiary uppercase tracking-wider">Total Active</p>
                <h3 class="text-h2 font-bold text-text-primary" x-text="stats.active"></h3>
            </div>
        </div>

        <div class="card p-4 sm:p-5 flex items-center gap-4">
            <div class="w-12 h-12 rounded-full bg-semantic-success-bg text-semantic-success border border-semantic-success/20 flex items-center justify-center shrink-0">
                <i data-lucide="dollar-sign" class="w-6 h-6"></i>
            </div>
            <div>
                <p class="text-caption font-bold text-text-tertiary uppercase tracking-wider">Total MRR</p>
                <h3 class="text-h2 font-bold text-text-primary" x-text="'$' + stats.totalMrr"></h3>
            </div>
        </div>

        <div class="card p-4 sm:p-5 flex items-center gap-4">
            <div class="w-12 h-12 rounded-full bg-semantic-info-bg text-semantic-info border border-semantic-info/20 flex items-center justify-center shrink-0">
                <i data-lucide="activity" class="w-6 h-6"></i>
            </div>
            <div>
                <p class="text-caption font-bold text-text-tertiary uppercase tracking-wider">Avg Health Score</p>
                <h3 class="text-h2 font-bold text-text-primary" x-text="stats.avgHealth + '/100'"></h3>
            </div>
        </div>

        <div class="card p-4 sm:p-5 flex items-center gap-4">
            <div class="w-12 h-12 rounded-full bg-semantic-warning-bg text-semantic-warning border border-semantic-warning/20 flex items-center justify-center shrink-0">
                <i data-lucide="file-clock" class="w-6 h-6"></i>
            </div>
            <div>
                <p class="text-caption font-bold text-text-tertiary uppercase tracking-wider">Pending KYC</p>
                <h3 class="text-h2 font-bold text-text-primary" x-text="stats.pendingKyc"></h3>
            </div>
        </div>
    </div>

    <div class="card p-0 flex flex-col flex-1 min-h-[600px] border-border-default shadow-sm overflow-hidden relative">
        
        <div x-show="selected.length > 0" x-transition.opacity class="absolute top-0 left-0 w-full h-[68px] bg-brand-primary z-30 flex items-center justify-between px-6 shadow-md" x-cloak>
            <div class="flex items-center gap-4 text-white">
                <span class="bg-white/20 px-2.5 py-1 rounded-md text-sm font-bold" x-text="selected.length + ' Selected'"></span>
                <span class="text-sm hidden sm:inline-block">Choose bulk action to apply across selected businesses.</span>
            </div>
            <div class="flex items-center gap-2">
                <button @click="bulkAction('message')" class="btn btn-sm bg-white text-brand-primary hover:bg-bg-muted flex items-center gap-2"><i data-lucide="message-square" class="w-4 h-4"></i> Message</button>
                <button @click="bulkAction('export')" class="btn btn-sm bg-white/20 text-white hover:bg-white/30 border-none flex items-center gap-2"><i data-lucide="download" class="w-4 h-4"></i> Export</button>
                <button @click="bulkAction('suspend')" class="btn btn-sm bg-semantic-error text-white hover:bg-red-600 border-none flex items-center gap-2 shadow-sm"><i data-lucide="ban" class="w-4 h-4"></i> Suspend</button>
                <button @click="selected = []" class="p-1.5 ml-2 text-white/70 hover:text-white transition-colors"><i data-lucide="x" class="w-5 h-5"></i></button>
            </div>
        </div>

        <div class="px-5 py-4 border-b border-border-default bg-bg-tertiary flex flex-col xl:flex-row justify-between items-start xl:items-center gap-4 shrink-0">
            
            <div class="flex flex-wrap items-center gap-3 w-full xl:w-auto">
                <div class="relative w-full sm:w-64">
                    <i data-lucide="search" class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-text-tertiary"></i>
                    <input type="text" x-model="filters.search" placeholder="Search businesses..." class="form-input w-full pl-9 h-10 text-body-sm bg-bg-primary">
                </div>

                <select x-model="filters.type" class="form-input h-10 text-body-sm bg-bg-secondary border-border-default w-full sm:w-auto">
                    <option value="">All Business Types</option>
                    <option value="Digital Agency">Digital Agency</option>
                    <option value="Home Services">Home Services</option>
                    <option value="Professional Firm">Professional Firm</option>
                    <option value="Consultant">Consultant</option>
                    <option value="Hybrid">Hybrid</option>
                </select>

                <select x-model="filters.tier" class="form-input h-10 text-body-sm bg-bg-secondary border-border-default w-full sm:w-auto">
                    <option value="">All Tiers</option>
                    <option value="Starter">Starter</option>
                    <option value="Growth">Growth</option>
                    <option value="Scale">Scale</option>
                    <option value="Enterprise">Enterprise</option>
                </select>
                
                <select x-model="filters.status" class="form-input h-10 text-body-sm bg-bg-secondary border-border-default w-full sm:w-auto">
                    <option value="">All Statuses</option>
                    <option value="Active">Active</option>
                    <option value="Pending">Pending (KYC)</option>
                    <option value="Suspended">Suspended</option>
                    <option value="Archived">Archived</option>
                </select>
            </div>

            <div class="w-full xl:w-auto flex justify-end">
                <button @click="modals.advancedFilters = true" class="btn p-2 btn-secondary h-10 w-full xl:w-auto flex items-center justify-center gap-2 relative">
                    <i data-lucide="sliders-horizontal" class="w-4 h-4"></i> Advanced Filters
                    <span x-show="hasAdvancedFilters" class="absolute top-2 right-2 w-2 h-2 rounded-full bg-semantic-error"></span>
                </button>
            </div>
        </div>

        <div class="flex-1 overflow-auto custom-scrollbar bg-bg-primary">
            
            <div x-show="isLoading" class="absolute inset-0 z-20 bg-bg-primary/90 backdrop-blur-sm flex flex-col items-center justify-center">
                <i data-lucide="loader-2" class="w-8 h-8 animate-spin text-brand-primary mb-3"></i>
                <span class="text-body-sm font-bold text-text-primary animate-pulse">Syncing Directory...</span>
            </div>

            <table class="w-full text-left border-separate border-spacing-0 min-w-[1200px]">
                <thead class="text-caption uppercase text-text-secondary font-semibold bg-bg-secondary sticky top-0 z-10 shadow-[0_1px_0_0_rgb(var(--border-strong))]">
                    <tr>
                        <th class="px-4 py-4 w-10 border-r border-border-default text-center">
                            <input type="checkbox" @click="toggleSelectAll()" :checked="selected.length === filteredBusinesses.length && filteredBusinesses.length > 0" class="rounded border-border-strong text-brand-primary focus:ring-brand-primary/20 bg-bg-primary cursor-pointer w-4 h-4">
                        </th>
                        <th class="px-5 py-4 border-r border-border-default cursor-pointer hover:bg-bg-tertiary transition-colors" @click="sortBy('name')">
                            <div class="flex items-center gap-2">Business Identity <i data-lucide="arrow-up-down" class="w-3 h-3 opacity-50"></i></div>
                        </th>
                        <th class="px-5 py-4 border-r border-border-default cursor-pointer hover:bg-bg-tertiary transition-colors" @click="sortBy('tier')">
                            <div class="flex items-center gap-2">Tier & Finances <i data-lucide="arrow-up-down" class="w-3 h-3 opacity-50"></i></div>
                        </th>
                        <th class="px-5 py-4 border-r border-border-default cursor-pointer hover:bg-bg-tertiary transition-colors" @click="sortBy('region')">
                            <div class="flex items-center gap-2">Operations <i data-lucide="arrow-up-down" class="w-3 h-3 opacity-50"></i></div>
                        </th>
                        <th class="px-5 py-4 border-r border-border-default text-center cursor-pointer hover:bg-bg-tertiary transition-colors" @click="sortBy('health')">
                            <div class="flex items-center justify-center gap-2">AI Health <i data-lucide="arrow-up-down" class="w-3 h-3 opacity-50"></i></div>
                        </th>
                        <th class="px-5 py-4 border-r border-border-default cursor-pointer hover:bg-bg-tertiary transition-colors" @click="sortBy('status')">
                            <div class="flex items-center gap-2">Status <i data-lucide="arrow-up-down" class="w-3 h-3 opacity-50"></i></div>
                        </th>
                        <th class="px-5 py-4 border-r border-border-default">Timeline</th>
                        <th class="px-4 py-4 text-center">Actions</th>
                    </tr>
                </thead>

                <tbody class="bg-bg-primary divide-y divide-border-default">
                    
                    <tr x-show="!isLoading && filteredBusinesses.length === 0" x-cloak>
                        <td colspan="8" class="px-6 py-16 text-center text-text-tertiary">
                            <i data-lucide="search-x" class="w-10 h-10 mx-auto mb-3 opacity-30"></i>
                            <p class="text-body-sm font-medium">No businesses match your directory filters.</p>
                        </td>
                    </tr>

                    <template x-for="biz in filteredBusinesses" :key="biz.id">
                        <tr class="hover:bg-bg-tertiary/50 transition-colors group" :class="selected.includes(biz.id) ? 'bg-brand-primary/5' : ''">
                            
                            <td class="px-4 py-4 text-center border-r border-border-default">
                                <input type="checkbox" :value="biz.id" x-model="selected" class="rounded border-border-strong text-brand-primary focus:ring-brand-primary/20 bg-bg-primary cursor-pointer w-4 h-4">
                            </td>

                            <td class="px-5 py-4 border-r border-border-default align-top max-w-[250px]">
                                <div class="flex items-start gap-3">
                                    <img :src="biz.logo" class="w-10 h-10 rounded-lg border border-border-strong object-cover shrink-0">
                                    <div class="min-w-0">
                                        <div class="font-bold text-text-primary text-body-sm truncate" x-text="biz.name"></div>
                                        <div class="text-[10px] text-text-secondary mt-0.5 uppercase tracking-wider font-bold" x-text="biz.type"></div>
                                        <div class="mt-1.5 flex items-center gap-2 text-caption text-text-tertiary font-mono">
                                            <span x-text="'ID: ' + biz.id"></span>
                                        </div>
                                    </div>
                                </div>
                            </td>

                            <td class="px-5 py-4 border-r border-border-default align-top">
                                <div class="flex flex-col items-start gap-1">
                                    <span class="px-2 py-0.5 rounded text-[10px] font-bold border uppercase tracking-wider"
                                          :class="getTierBadgeClass(biz.tier)" x-text="biz.tier"></span>
                                    <div class="text-body-sm font-bold text-text-primary mt-1" x-text="'$' + biz.mrr + ' MRR'"></div>
                                </div>
                            </td>

                            <td class="px-5 py-4 border-r border-border-default align-top">
                                <div class="flex items-center gap-2 mb-1.5">
                                    <i data-lucide="map-pin" class="w-3.5 h-3.5 text-text-tertiary shrink-0"></i>
                                    <span class="text-body-sm text-text-primary" x-text="biz.region"></span>
                                </div>
                                <div class="flex items-center gap-2">
                                    <i data-lucide="users" class="w-3.5 h-3.5 text-text-tertiary shrink-0"></i>
                                    <span class="text-caption text-text-secondary" x-text="biz.teamSize + ' Team Members'"></span>
                                </div>
                            </td>

                            <td class="px-5 py-4 border-r border-border-default text-center align-top">
                                <div class="inline-flex items-center justify-center w-10 h-10 rounded-full border-[3px] font-bold text-body-sm relative"
                                     :class="getHealthClass(biz.health)" :title="`AI Health Score: ${biz.health}`">
                                     <span x-text="biz.health"></span>
                                </div>
                            </td>

                            <td class="px-5 py-4 border-r border-border-default align-top">
                                <span class="inline-flex items-center gap-1.5 px-2 py-1 rounded text-[10px] font-bold uppercase tracking-wider border"
                                      :class="getStatusBadgeClass(biz.status)">
                                    <i :data-lucide="getStatusIcon(biz.status)" class="w-3 h-3"></i> <span x-text="biz.status"></span>
                                </span>
                            </td>

                            <td class="px-5 py-4 border-r border-border-default align-top">
                                <div class="text-caption text-text-primary mb-1"><span class="text-text-tertiary">Signed up:</span> <span x-text="biz.signupDate"></span></div>
                                <div class="text-caption text-text-primary"><span class="text-text-tertiary">Active:</span> <span x-text="biz.lastActivity"></span></div>
                            </td>

                            <td class="px-4 py-4 text-center align-middle">
                                <div class="relative inline-block text-left" x-data="{ dropOpen: false }" @click.away="dropOpen = false">
                                    <button @click="dropOpen = !dropOpen" class="p-1.5 text-text-tertiary hover:text-text-primary rounded-md hover:bg-bg-tertiary transition-colors">
                                        <i data-lucide="more-vertical" class="w-5 h-5"></i>
                                    </button>
                                    
                                    <div x-show="dropOpen" x-transition.opacity class="absolute right-0 mt-2 w-48 rounded-md shadow-lg bg-bg-secondary border border-border-default z-50 py-1" x-cloak>
                                        <a :href="`/cp-x9f7a2/v1/businesses/view/${biz.id}`" class="w-full text-left px-4 py-2 text-body-sm text-text-primary hover:bg-bg-tertiary flex items-center gap-2">
                                            <i data-lucide="eye" class="w-4 h-4 text-text-secondary"></i> View Details
                                        </a>
                                        <button @click="messageBusiness(biz); dropOpen = false" class="w-full text-left px-4 py-2 text-body-sm text-text-primary hover:bg-bg-tertiary flex items-center gap-2">
                                            <i data-lucide="message-square" class="w-4 h-4 text-text-secondary"></i> Send Message
                                        </button>
                                        <button @click="flagBusiness(biz); dropOpen = false" class="w-full text-left px-4 py-2 text-body-sm text-text-primary hover:bg-bg-tertiary flex items-center gap-2">
                                            <i data-lucide="flag" class="w-4 h-4 text-semantic-info"></i> Flag for Review
                                        </button>
                                        
                                        <div x-show="biz.status === 'Pending'" class="h-px bg-border-default my-1"></div>
                                        <button x-show="biz.status === 'Pending'" @click="overrideKyc(biz); dropOpen = false" class="w-full text-left px-4 py-2 text-body-sm text-purple-500 hover:bg-purple-500/10 flex items-center gap-2 font-bold">
                                            <i data-lucide="check-square" class="w-4 h-4"></i> Manual KYC Override
                                        </button>

                                        <div class="h-px bg-border-default my-1"></div>

                                        <button x-show="biz.status !== 'Suspended'" @click="toggleSuspend(biz); dropOpen = false" class="w-full text-left px-4 py-2 text-body-sm text-semantic-error hover:bg-semantic-error-bg flex items-center gap-2">
                                            <i data-lucide="ban" class="w-4 h-4"></i> Suspend Account
                                        </button>
                                        <button x-show="biz.status === 'Suspended'" @click="toggleSuspend(biz); dropOpen = false" class="w-full text-left px-4 py-2 text-body-sm text-semantic-success hover:bg-semantic-success-bg flex items-center gap-2">
                                            <i data-lucide="power" class="w-4 h-4"></i> Unsuspend Account
                                        </button>
                                    </div>
                                </div>
                            </td>

                        </tr>
                    </template>
                </tbody>
            </table>
        </div>
        
        <div class="p-4 border-t border-border-default bg-bg-tertiary flex items-center justify-between text-body-sm text-text-secondary shrink-0">
            <span x-text="`Showing 1 to ${filteredBusinesses.length} of ${filteredBusinesses.length} entries`"></span>
            <div class="flex items-center gap-2">
                <button class="px-3 py-1.5 rounded border border-border-default bg-bg-primary opacity-50 cursor-not-allowed">Previous</button>
                <button class="px-3 py-1.5 rounded border border-border-default bg-bg-primary opacity-50 cursor-not-allowed">Next</button>
            </div>
        </div>
    </div>

    <div x-show="modals.advancedFilters" class="fixed inset-0 z-50 flex justify-end" x-cloak>
        <div class="absolute inset-0 bg-brand-secondary/80 backdrop-blur-sm" @click="modals.advancedFilters = false"></div>
        <div class="w-full max-w-md bg-bg-primary h-full shadow-2xl relative z-10 flex flex-col border-l border-border-default transform transition-transform"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="translate-x-full"
             x-transition:enter-end="translate-x-0"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="translate-x-0"
             x-transition:leave-end="translate-x-full">
            
            <div class="px-6 py-5 border-b border-border-default bg-bg-tertiary flex justify-between items-center shrink-0">
                <h3 class="text-h4 font-bold text-text-primary flex items-center gap-2"><i data-lucide="sliders-horizontal" class="w-5 h-5 text-brand-primary"></i> Advanced Filters</h3>
                <button @click="modals.advancedFilters = false" class="text-text-tertiary hover:text-text-primary"><i data-lucide="x" class="w-5 h-5"></i></button>
            </div>

            <div class="p-6 flex-1 overflow-y-auto custom-scrollbar space-y-6">
                
                <div class="form-group mb-0">
                    <label class="form-label">Emirate / Region</label>
                    <select x-model="filters.region" class="form-input w-full">
                        <option value="">All Regions</option>
                        <option value="Dubai">Dubai</option>
                        <option value="Abu Dhabi">Abu Dhabi</option>
                        <option value="Sharjah">Sharjah</option>
                        <option value="Ajman">Ajman</option>
                    </select>
                </div>

                <div class="h-px w-full bg-border-default"></div>

                <div>
                    <label class="form-label mb-3">MRR Range ($)</label>
                    <div class="flex items-center gap-3">
                        <input type="number" x-model="filters.mrrMin" placeholder="Min" class="form-input w-full">
                        <span class="text-text-tertiary">-</span>
                        <input type="number" x-model="filters.mrrMax" placeholder="Max" class="form-input w-full">
                    </div>
                </div>

                <div class="h-px w-full bg-border-default"></div>

                <div>
                    <label class="form-label mb-3">AI Health Score Range (0-100)</label>
                    <div class="flex items-center gap-3">
                        <input type="number" x-model="filters.healthMin" placeholder="Min (e.g. 0)" class="form-input w-full" min="0" max="100">
                        <span class="text-text-tertiary">-</span>
                        <input type="number" x-model="filters.healthMax" placeholder="Max (e.g. 100)" class="form-input w-full" min="0" max="100">
                    </div>
                </div>

                <div class="h-px w-full bg-border-default"></div>

                <div>
                    <label class="form-label mb-3">Signup Date Range</label>
                    <div class="grid grid-cols-1 gap-3">
                        <input type="date" x-model="filters.dateFrom" class="form-input w-full">
                        <input type="date" x-model="filters.dateTo" class="form-input w-full">
                    </div>
                </div>

            </div>

            <div class="p-5 border-t border-border-default bg-bg-tertiary flex gap-3 shrink-0">
                <button @click="clearAdvancedFilters()" class="btn btn-tertiary flex-1">Clear Form</button>
                <button @click="modals.advancedFilters = false" class="btn btn-primary flex-1">Apply Filters</button>
            </div>
        </div>
    </div>

</div>

@push('scripts')
<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('businessRegistry', () => ({
        isLoading: true,
        toast: { show: false, message: '', type: 'success' },
        modals: { advancedFilters: false },
        
        selected: [],
        sortCol: 'name',
        sortAsc: true,
        
        filters: { 
            search: '', type: '', tier: '', status: '', region: '',
            mrrMin: '', mrrMax: '', healthMin: '', healthMax: '', dateFrom: '', dateTo: '' 
        },

        businesses: [],

        init() {
            this.fetchData();
        },

        get stats() {
            return {
                active: this.businesses.filter(b => b.status === 'Active').length,
                totalMrr: this.businesses.reduce((sum, b) => sum + (b.status === 'Active' ? b.mrr : 0), 0).toLocaleString(),
                avgHealth: Math.round(this.businesses.reduce((sum, b) => sum + b.health, 0) / (this.businesses.length || 1)),
                pendingKyc: this.businesses.filter(b => b.status === 'Pending').length
            };
        },

        get hasAdvancedFilters() {
            return this.filters.region !== '' || this.filters.mrrMin !== '' || this.filters.mrrMax !== '' || 
                   this.filters.healthMin !== '' || this.filters.healthMax !== '' || this.filters.dateFrom !== '' || this.filters.dateTo !== '';
        },

        get filteredBusinesses() {
            let result = this.businesses;

            // Apply Filters
            if(this.filters.search) {
                const q = this.filters.search.toLowerCase();
                result = result.filter(b => b.name.toLowerCase().includes(q) || b.id.toLowerCase().includes(q));
            }
            if(this.filters.type) result = result.filter(b => b.type === this.filters.type);
            if(this.filters.tier) result = result.filter(b => b.tier === this.filters.tier);
            if(this.filters.status) result = result.filter(b => b.status === this.filters.status);
            if(this.filters.region) result = result.filter(b => b.region === this.filters.region);
            
            if(this.filters.mrrMin) result = result.filter(b => b.mrr >= parseInt(this.filters.mrrMin));
            if(this.filters.mrrMax) result = result.filter(b => b.mrr <= parseInt(this.filters.mrrMax));
            
            if(this.filters.healthMin) result = result.filter(b => b.health >= parseInt(this.filters.healthMin));
            if(this.filters.healthMax) result = result.filter(b => b.health <= parseInt(this.filters.healthMax));

 
            // Sorting
            result = result.sort((a, b) => {
                let valA = a[this.sortCol];
                let valB = b[this.sortCol];
                
                if (typeof valA === 'string') { valA = valA.toLowerCase(); valB = valB.toLowerCase(); }
                
                if (valA < valB) return this.sortAsc ? -1 : 1;
                if (valA > valB) return this.sortAsc ? 1 : -1;
                return 0;
            });

            return result;
        },

        async fetchData() {
            this.isLoading = true;
            await new Promise(r => setTimeout(r, 600)); // Simulate API Delay
            
             this.businesses = [
                { id: 'B-10024', name: 'Elevate Digital', type: 'Digital Agency', teamSize: 14, region: 'Dubai', tier: 'Scale', signupDate: '12-Jan-2026', lastActivity: '2 hours ago', health: 92, status: 'Active', mrr: 249, logo: 'https://ui-avatars.com/api/?name=ED&background=F1F5F9&color=0F1729' },
                { id: 'B-10025', name: 'Dubai Cool AC Repair', type: 'Home Services', teamSize: 45, region: 'Dubai', tier: 'Enterprise', signupDate: '05-Feb-2026', lastActivity: '15 mins ago', health: 78, status: 'Active', mrr: 899, logo: 'https://ui-avatars.com/api/?name=DC&background=F1F5F9&color=0F1729' },
                { id: 'B-10026', name: 'Apex Legal Consultants', type: 'Professional Firm', teamSize: 6, region: 'Abu Dhabi', tier: 'Growth', signupDate: '18-Mar-2026', lastActivity: 'Yesterday', health: 45, status: 'Active', mrr: 129, logo: 'https://ui-avatars.com/api/?name=AL&background=F1F5F9&color=0F1729' },
                { id: 'B-10027', name: 'CleanSweep UAE', type: 'Home Services', teamSize: 120, region: 'Sharjah', tier: 'Enterprise', signupDate: '01-Nov-2025', lastActivity: 'Just now', health: 22, status: 'Suspended', mrr: 0, logo: 'https://ui-avatars.com/api/?name=CS&background=F1F5F9&color=0F1729' },
                { id: 'B-10028', name: 'Nexus Marketing', type: 'Digital Agency', teamSize: 2, region: 'Dubai', tier: 'Starter', signupDate: '22-Apr-2026', lastActivity: 'Never', health: 50, status: 'Pending', mrr: 49, logo: 'https://ui-avatars.com/api/?name=NM&background=F1F5F9&color=0F1729' },
                { id: 'B-10029', name: 'Al Noor Consulting', type: 'Consultant', teamSize: 1, region: 'Ajman', tier: 'Starter', signupDate: '20-Apr-2026', lastActivity: '1 day ago', health: 88, status: 'Active', mrr: 49, logo: 'https://ui-avatars.com/api/?name=AN&background=F1F5F9&color=0F1729' },
            ];

            this.isLoading = false;
            this.$nextTick(() => lucide.createIcons());
        },

        showToast(msg, type = 'success') {
            this.toast = { show: true, message: msg, type: type };
            setTimeout(() => this.toast.show = false, 3000);
        },

        sortBy(col) {
            if(this.sortCol === col) {
                this.sortAsc = !this.sortAsc;
            } else {
                this.sortCol = col;
                this.sortAsc = true;
            }
        },

        toggleSelectAll() {
            if(this.selected.length === this.filteredBusinesses.length) {
                this.selected = [];
            } else {
                this.selected = this.filteredBusinesses.map(b => b.id);
            }
        },

        clearAdvancedFilters() {
            this.filters.region = '';
            this.filters.mrrMin = ''; this.filters.mrrMax = '';
            this.filters.healthMin = ''; this.filters.healthMax = '';
            this.filters.dateFrom = ''; this.filters.dateTo = '';
        },

        // --- Actions ---
        exportCSV() {
            alert('Initiating background CSV export. You will receive an email shortly.');
        },

        bulkAction(action) {
            alert(`Executing Bulk Action: [${action.toUpperCase()}] on ${this.selected.length} records.`);
            this.selected = []; // Reset after action
        },

        messageBusiness(biz) {
            alert(`Opening messaging interface for: ${biz.name}`);
        },

        flagBusiness(biz) {
            alert(`Business [${biz.id}] flagged for internal review.`);
        },

        overrideKyc(biz) {
            if(confirm(`WARNING: Manually overriding KYC for ${biz.name} bypasses standard verification. Proceed?`)) {
                biz.status = 'Active';
                this.showToast('KYC Overridden. Business Activated.');
            }
        },

        toggleSuspend(biz) {
            if(biz.status === 'Suspended') {
                if(confirm('Unsuspend this business?')) { biz.status = 'Active'; this.showToast('Account Unsuspended.'); }
            } else {
                if(confirm('Suspend this business? This will lock out all their users.')) { biz.status = 'Suspended'; this.showToast('Account Suspended.', 'error'); }
            }
        },

        // --- UI Badging Helpers ---
        getTierBadgeClass(tier) {
            const map = {
                'Starter': 'bg-bg-tertiary text-text-secondary border-border-strong',
                'Growth': 'bg-semantic-info-bg text-semantic-info border-semantic-info/20',
                'Scale': 'bg-brand-primary/10 text-brand-primary border-brand-primary/20',
                'Enterprise': 'bg-purple-500/10 text-purple-500 border-purple-500/20 shadow-sm'
            };
            return map[tier] || map['Starter'];
        },

        getHealthClass(score) {
            if(score >= 80) return 'border-semantic-success text-semantic-success bg-semantic-success-bg';
            if(score >= 40) return 'border-semantic-warning text-semantic-warning bg-semantic-warning-bg';
            return 'border-semantic-error text-semantic-error bg-semantic-error-bg animate-pulse';
        },

        getStatusBadgeClass(status) {
            const map = {
                'Active': 'bg-semantic-success-bg text-semantic-success border-semantic-success/20',
                'Pending': 'bg-semantic-warning-bg text-semantic-warning border-semantic-warning/20',
                'Suspended': 'bg-semantic-error-bg text-semantic-error border-semantic-error/20',
                'Archived': 'bg-bg-tertiary text-text-tertiary border-border-strong'
            };
            return map[status] || map['Active'];
        },

        getStatusIcon(status) {
            if(status === 'Active') return 'check-circle-2';
            if(status === 'Pending') return 'clock';
            if(status === 'Suspended') return 'ban';
            return 'archive';
        }
    }));
});
</script>
@endpush
@endsection