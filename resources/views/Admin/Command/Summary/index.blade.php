@extends('layouts.app')

@section('content')
<div class="p-4 sm:p-6 lg:p-8 bg-bg-primary min-h-screen" x-data="executiveDashboard()">

    <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center mb-8 gap-5">
        <div class="w-full lg:w-auto">
            <h1 class="text-h2 sm:text-h1 font-bold text-text-primary flex flex-wrap items-center gap-3">
                Executive Dashboard
                <span class="px-2 py-1 bg-brand-primary/10 text-brand-primary text-[10px] font-bold uppercase rounded-md border border-brand-primary/20 tracking-wider whitespace-nowrap">Live Sync</span>
            </h1>
            <p class="text-body-sm text-text-secondary mt-1">Real-time platform performance, AI forecasts, and business health.</p>
        </div>

        <div class="flex flex-col sm:flex-row flex-wrap items-start sm:items-center gap-3 w-full lg:w-auto">
            <div class="flex items-center justify-between w-full sm:w-auto bg-bg-secondary p-1 rounded-lg border border-border-default shadow-sm">
                <button class="flex-1 sm:flex-none px-3 py-1.5 text-caption font-medium text-text-secondary hover:bg-bg-tertiary rounded-md transition-colors">Today</button>
                <button class="flex-1 sm:flex-none px-3 py-1.5 text-caption font-medium text-white bg-brand-primary rounded-md shadow-sm">7d</button>
                <button class="flex-1 sm:flex-none px-3 py-1.5 text-caption font-medium text-text-secondary hover:bg-bg-tertiary rounded-md transition-colors">30d</button>
                <button class="flex-1 sm:flex-none px-3 py-1.5 text-caption font-medium text-text-secondary hover:bg-bg-tertiary rounded-md transition-colors">YTD</button>
            </div>

            <div class="flex items-center gap-2 w-full sm:w-auto">
                <button @click="shareDashboard()" class="btn btn-secondary btn-sm flex-1 sm:flex-none flex items-center justify-center gap-2">
                    <i data-lucide="share-2" class="w-4 h-4"></i> Share
                </button>
                <button @click="exportSnapshot()" class="btn btn-primary btn-sm flex-1 sm:flex-none flex items-center justify-center gap-2">
                    <i data-lucide="download" class="w-4 h-4"></i> Export PDF
                </button>
            </div>
        </div>
    </div>

    <div class="mb-2">
        <h3 class="text-label text-text-secondary mb-4 flex items-center gap-2">
            <i data-lucide="landmark" class="w-4 h-4"></i> Revenue & Platform Financials
        </h3>
    </div>
    
    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4 sm:gap-5 mb-8">
        
        <div class="card p-5 relative overflow-hidden group">
            <div class="flex justify-between items-start mb-2">
                <div class="flex items-center gap-2 cursor-help" title="Formula: SUM(Active Subscriptions) + Expansion - Churn">
                    <span class="text-caption font-bold text-text-tertiary uppercase tracking-wider">MRR</span>
                    <i data-lucide="info" class="w-3 h-3 text-text-tertiary hidden sm:block"></i>
                </div>
                <div class="dropdown relative" x-data="{ open: false }" @click.away="open = false">
                    <button @click="open = !open" class="text-text-tertiary hover:text-text-primary"><i data-lucide="more-horizontal" class="w-4 h-4"></i></button>
                    <div x-show="open" class="absolute right-0 mt-1 w-32 bg-bg-secondary border border-border-default rounded-md shadow-lg z-10 py-1" x-cloak>
                        <a href="#" class="block px-3 py-1.5 text-caption text-text-primary hover:bg-bg-tertiary">Pin to Personal</a>
                        <a href="#" class="block px-3 py-1.5 text-caption text-text-primary hover:bg-bg-tertiary">Set Alert</a>
                    </div>
                </div>
            </div>
            <h4 class="text-h2 sm:text-h1 font-bold text-text-primary truncate">$142,500</h4>
            <div class="flex items-center justify-between mt-2">
                <div class="flex items-center gap-2 text-caption">
                    <span class="text-semantic-success font-bold bg-semantic-success-bg border border-semantic-success/20 px-1.5 py-0.5 rounded flex items-center">↑ 8.4%</span>
                    <span class="text-text-tertiary truncate">vs 7d</span>
                </div>
            </div>
            <div class="mt-4 h-12 w-full" x-ref="sparklineMrr"></div>
        </div>

        <div class="card p-5 relative overflow-hidden group">
            <div class="flex justify-between items-start mb-2">
                <div class="flex items-center gap-2 cursor-help" title="Formula: MRR * 12">
                    <span class="text-caption font-bold text-text-tertiary uppercase tracking-wider">ARR</span>
                    <i data-lucide="info" class="w-3 h-3 text-text-tertiary hidden sm:block"></i>
                </div>
            </div>
            <h4 class="text-h2 sm:text-h1 font-bold text-text-primary truncate">$1.71M</h4>
            <div class="flex items-center justify-between mt-2">
                <div class="flex items-center gap-2 text-caption">
                    <span class="text-semantic-success font-bold bg-semantic-success-bg border border-semantic-success/20 px-1.5 py-0.5 rounded flex items-center">↑ 12.1%</span>
                    <span class="text-text-tertiary truncate">vs Prev.</span>
                </div>
            </div>
            <div class="mt-4 h-12 w-full" x-ref="sparklineArr"></div>
        </div>

        <div class="card p-5 pb-8 relative overflow-hidden group">
            <div class="flex justify-between items-start mb-2">
                <div class="flex items-center gap-2 cursor-help" title="Total dollar value of all jobs processed through platform">
                    <span class="text-caption font-bold text-text-tertiary uppercase tracking-wider">GMV Processed</span>
                    <i data-lucide="info" class="w-3 h-3 text-text-tertiary hidden sm:block"></i>
                </div>
            </div>
            <h4 class="text-h2 sm:text-h1 font-bold text-text-primary truncate">$4.85M</h4>
            <div class="flex items-center justify-between mt-2">
                <div class="flex items-center gap-2 text-caption">
                    <span class="text-semantic-warning font-bold bg-semantic-warning-bg border border-semantic-warning/20 px-1.5 py-0.5 rounded flex items-center">↓ 1.2%</span>
                    <span class="text-text-tertiary truncate">vs 7d</span>
                </div>
            </div>
            <div class="mt-4 h-12 w-full" x-ref="sparklineGmv"></div>
            <div class="absolute bottom-0 left-0 w-full bg-semantic-warning/10 border-t border-semantic-warning/20 p-1.5 text-center flex items-center justify-center gap-1">
                <i data-lucide="sparkles" class="w-3 h-3 text-semantic-warning"></i>
                <span class="text-[9px] font-bold text-semantic-warning uppercase truncate">AI: Forecast Deviation Detected</span>
            </div>
        </div>

        <div class="card p-5 relative overflow-hidden group">
            <div class="flex justify-between items-start mb-2">
                <div class="flex items-center gap-2 cursor-help" title="Formula: GMV * Blended Commission Rate">
                    <span class="text-caption font-bold text-text-tertiary uppercase tracking-wider truncate">Platform Commission</span>
                </div>
            </div>
            <h4 class="text-h2 sm:text-h1 font-bold text-text-primary truncate">$142.5K</h4>
            <div class="flex items-center justify-between mt-2">
                <div class="flex items-center gap-2 text-caption">
                    <span class="text-semantic-success font-bold bg-semantic-success-bg border border-semantic-success/20 px-1.5 py-0.5 rounded flex items-center">↑ 5.2%</span>
                    <span class="text-text-tertiary truncate">Blended 2.9%</span>
                </div>
            </div>
            <div class="mt-4 h-12 w-full" x-ref="sparklineCommission"></div>
        </div>

    </div>

    <div class="mb-2 mt-8">
        <h3 class="text-label text-text-secondary mb-4 flex items-center gap-2">
            <i data-lucide="pie-chart" class="w-4 h-4"></i> Unit Economics & Acquisition
        </h3>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-5 gap-4 sm:gap-5 mb-8">
        <div class="card p-4">
            <div class="flex justify-between items-center mb-1">
                <span class="text-caption font-bold text-text-tertiary uppercase tracking-wider cursor-help" title="Formula: (Starting MRR + Expansion - Contraction - Churn) / Starting MRR">NRR</span>
            </div>
            <h4 class="text-h2 sm:text-h3 font-bold text-text-primary">112%</h4>
            <span class="text-caption text-semantic-success truncate">Healthy Expansion</span>
        </div>

        <div class="card p-4">
            <div class="flex justify-between items-center mb-1">
                <span class="text-caption font-bold text-text-tertiary uppercase tracking-wider cursor-help" title="Formula: Total Sales & Mktg Spend / New Businesses">CAC</span>
            </div>
            <h4 class="text-h2 sm:text-h3 font-bold text-text-primary">$340</h4>
            <span class="text-caption text-semantic-error truncate">↑ 12% vs Prev</span>
        </div>

        <div class="card p-4">
            <div class="flex justify-between items-center mb-1">
                <span class="text-caption font-bold text-text-tertiary uppercase tracking-wider cursor-help" title="Formula: ARPA / User Churn Rate">LTV</span>
            </div>
            <h4 class="text-h2 sm:text-h3 font-bold text-text-primary">$4,250</h4>
            <span class="text-caption text-semantic-success truncate">↑ 2.1% vs Prev</span>
        </div>

        <div class="card p-4 bg-brand-primary/5 border-brand-primary/20">
            <div class="flex justify-between items-center mb-1">
                <span class="text-caption font-bold text-brand-primary uppercase tracking-wider cursor-help" title="Ideal ratio is > 3.0">LTV:CAC Ratio</span>
                <i data-lucide="target" class="w-4 h-4 text-brand-primary"></i>
            </div>
            <h4 class="text-h2 sm:text-h3 font-bold text-brand-primary">12.5 : 1</h4>
            <span class="text-caption text-text-secondary truncate">Highly Efficient</span>
        </div>

        <div class="card p-4 sm:col-span-2 xl:col-span-1">
            <div class="flex justify-between items-center mb-1">
                <span class="text-caption font-bold text-text-tertiary uppercase tracking-wider">New Signups (7d)</span>
            </div>
            <div class="flex items-center justify-between">
                <h4 class="text-h2 sm:text-h3 font-bold text-text-primary">84</h4>
                <div class="flex -space-x-1 mt-1">
                    <div class="w-5 h-5 sm:w-4 sm:h-4 rounded-full bg-blue-500 border border-bg-primary" title="Agencies: 40"></div>
                    <div class="w-5 h-5 sm:w-4 sm:h-4 rounded-full bg-teal-500 border border-bg-primary" title="Home Services: 24"></div>
                    <div class="w-5 h-5 sm:w-4 sm:h-4 rounded-full bg-amber-500 border border-bg-primary" title="Consultants: 20"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="mb-2 mt-8">
        <h3 class="text-label text-text-secondary mb-4 flex items-center gap-2">
            <i data-lucide="shield-alert" class="w-4 h-4"></i> Operations & Risk
        </h3>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-5 mb-10">
        <div class="card p-5 md:col-span-2 lg:col-span-1">
            <span class="text-caption font-bold text-text-tertiary uppercase tracking-wider block mb-4">Total Active Businesses</span>
            <div class="flex items-end gap-3 mb-4">
                <h4 class="text-h1 font-bold text-text-primary">1,240</h4>
                <span class="text-body-sm text-text-tertiary mb-1">Platform Wide</span>
            </div>
            <div class="space-y-4 sm:space-y-3">
                <div>
                    <div class="flex justify-between text-caption mb-1">
                        <span class="text-text-secondary flex items-center gap-1"><span class="w-2 h-2 rounded-full bg-[#3B82F6]"></span> Digital Agencies</span>
                        <span class="font-mono text-text-primary">520</span>
                    </div>
                    <div class="w-full bg-bg-muted rounded-full h-1.5"><div class="bg-[#3B82F6] h-1.5 rounded-full" style="width: 42%"></div></div>
                </div>
                <div>
                    <div class="flex justify-between text-caption mb-1">
                        <span class="text-text-secondary flex items-center gap-1"><span class="w-2 h-2 rounded-full bg-[#14B8A6]"></span> Home Services</span>
                        <span class="font-mono text-text-primary">410</span>
                    </div>
                    <div class="w-full bg-bg-muted rounded-full h-1.5"><div class="bg-[#14B8A6] h-1.5 rounded-full" style="width: 33%"></div></div>
                </div>
                <div>
                    <div class="flex justify-between text-caption mb-1">
                        <span class="text-text-secondary flex items-center gap-1"><span class="w-2 h-2 rounded-full bg-[#F59E0B]"></span> Consultants</span>
                        <span class="font-mono text-text-primary">310</span>
                    </div>
                    <div class="w-full bg-bg-muted rounded-full h-1.5"><div class="bg-[#F59E0B] h-1.5 rounded-full" style="width: 25%"></div></div>
                </div>
            </div>
        </div>

        <div class="card p-5 flex flex-col justify-between">
            <div>
                <span class="text-caption font-bold text-text-tertiary uppercase tracking-wider">Active Jobs (Platform)</span>
                <h4 class="text-display-lg font-bold text-text-primary mt-2 truncate">14,892</h4>
                <p class="text-caption text-text-secondary mt-1">Jobs currently in 'In Progress' or 'Scheduled' states.</p>
            </div>
            <div class="mt-6 p-3 bg-bg-tertiary border border-border-default rounded-lg flex items-start gap-3">
                <i data-lucide="activity" class="w-5 h-5 text-text-secondary shrink-0"></i>
                <div>
                    <p class="text-body-sm font-semibold text-text-primary">Healthy Volume</p>
                    <p class="text-caption text-text-tertiary">Platform processing normally.</p>
                </div>
            </div>
        </div>

        <div class="flex flex-col gap-4 sm:gap-5">
            <div class="card p-4 flex items-center justify-between   flex-1">
                <div class="min-w-0 pr-4">
                    <span class="text-caption font-bold text-text-tertiary uppercase tracking-wider block mb-1 truncate">Failed Payments (7d)</span>
                    <h4 class="text-h2 font-bold text-text-primary">142</h4>
                </div>
                <div class="w-12 h-12 sm:w-10 sm:h-10 rounded-full bg-semantic-error-bg text-semantic-error flex items-center justify-center shrink-0">
                    <i data-lucide="credit-card" class="w-5 h-5"></i>
                </div>
            </div>
            
            <div class="card p-4 flex items-center justify-between   flex-1">
                <div class="min-w-0 pr-4">
                    <span class="text-caption font-bold text-text-tertiary uppercase tracking-wider block mb-1 truncate">Pending Payouts</span>
                    <h4 class="text-h2 font-bold text-text-primary truncate">$45.2K</h4>
                </div>
                <div class="w-12 h-12 sm:w-10 sm:h-10 rounded-full bg-semantic-warning-bg text-semantic-warning flex items-center justify-center shrink-0">
                    <i data-lucide="clock" class="w-5 h-5"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="mt-12 mb-4 flex flex-col lg:flex-row justify-between items-start lg:items-end gap-4">
        <div class="w-full lg:w-auto">
            <h3 class="text-h3 font-bold text-text-primary flex flex-wrap items-center gap-2">
                Business Health Map
                <span class="px-2 py-0.5 bg-purple-500/10 text-purple-500 text-[10px] font-bold uppercase rounded border border-purple-500/20 flex items-center gap-1 whitespace-nowrap">
                    <i data-lucide="sparkles" class="w-3 h-3"></i> AI Scored
                </span>
            </h3>
            <p class="text-body-sm text-text-secondary mt-1">Real-time observability of individual business performance and churn risk.</p>
        </div>

        <div class="flex flex-col sm:flex-row items-center gap-3 w-full lg:w-auto">
            <select class="form-input text-caption h-10 sm:h-9 py-0 w-full sm:w-36 bg-bg-secondary" x-model="filters.type">
                <option value="all">All Types</option>
                <option value="agency">Digital Agency</option>
                <option value="home">Home Services</option>
                <option value="consultant">Consultant</option>
            </select>
            <select class="form-input text-caption h-10 sm:h-9 py-0 w-full sm:w-36 bg-bg-secondary" x-model="filters.health">
                <option value="all">All Health</option>
                <option value="critical">Critical Risk</option>
                <option value="upgrade">Upgrade Ready</option>
            </select>
            <button class="btn btn-secondary h-10 sm:h-9 w-full sm:w-auto px-3 text-caption flex items-center justify-center gap-2">
                <i data-lucide="download" class="w-3 h-3"></i> Export
            </button>
        </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4 sm:gap-5">
        <template x-for="biz in filteredBusinesses" :key="biz.id">
            <div class="card p-4 sm:p-5 flex flex-col hover:border-border-strong transition-colors relative group">
                
                <div class="flex items-start gap-3 mb-4">
                    <img :src="biz.logo" class="w-12 h-12 sm:w-10 sm:h-10 rounded-md border border-border-default object-cover shrink-0">
                    <div class="flex-1 min-w-0">
                        <h4 class="text-body-sm font-bold text-text-primary truncate" x-text="biz.name"></h4>
                        <div class="flex items-center gap-2 mt-1 sm:mt-0.5 flex-wrap">
                            <span class="text-[10px] uppercase font-bold tracking-wide whitespace-nowrap" :style="`color: ${biz.typeColor}`" x-text="biz.type"></span>
                            <span class="hidden sm:inline-block w-1 h-1 rounded-full bg-border-strong"></span>
                            <span class="text-[10px] text-text-secondary uppercase whitespace-nowrap" x-text="biz.tier + ' Tier'"></span>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-2 sm:gap-3 mb-4">
                    <div class="bg-bg-tertiary p-2 rounded border border-border-default">
                        <span class="block text-[10px] text-text-tertiary uppercase mb-0.5 truncate">Job Volume</span>
                        <span class="text-body-sm font-bold text-text-primary font-mono truncate" x-text="biz.jobVolume"></span>
                    </div>
                    <div class="bg-bg-tertiary p-2 rounded border border-border-default">
                        <span class="block text-[10px] text-text-tertiary uppercase mb-0.5 truncate">Processed</span>
                        <span class="text-body-sm font-bold text-text-primary font-mono truncate" x-text="biz.paymentVolume"></span>
                    </div>
                </div>

                <div class="mb-4">
                    <div class="flex justify-between text-caption mb-1">
                        <span class="text-text-secondary">Usage vs Limits</span>
                        <span class="font-mono text-text-primary" x-text="`${biz.usagePct}%`"></span>
                    </div>
                    <div class="w-full bg-bg-muted rounded-full h-1.5 overflow-hidden">
                        <div class="h-1.5 rounded-full" :class="biz.usagePct > 90 ? 'bg-semantic-error' : 'bg-brand-primary'" :style="`width: ${biz.usagePct}%`"></div>
                    </div>
                </div>

                <div class="mt-auto pt-4 border-t border-border-default flex items-center justify-between">
                    <div class="flex items-center gap-2" :title="`AI Health Score: ${biz.healthScore}/100`">
                        <div class="relative w-8 h-8 flex items-center justify-center shrink-0">
                            <svg class="w-full h-full transform -rotate-90" viewBox="0 0 36 36">
                                <path class="text-bg-muted" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" fill="none" stroke="currentColor" stroke-width="3" />
                                <path :class="biz.healthColor" :stroke-dasharray="`${biz.healthScore}, 100`" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" fill="none" stroke="currentColor" stroke-width="3" />
                            </svg>
                            <span class="absolute text-[9px] font-bold text-text-primary" x-text="biz.healthScore"></span>
                        </div>
                        
                        <span x-show="biz.healthScore < 40" class="text-[10px] text-semantic-error font-bold leading-tight">Churn Risk<br>Detected</span>
                        <span x-show="biz.healthScore >= 40 && biz.usagePct > 85" class="text-[10px] text-semantic-info font-bold leading-tight">Upgrade<br>Opportunity</span>
                        <span x-show="biz.healthScore >= 70 && biz.usagePct <= 85" class="text-[10px] text-semantic-success font-bold leading-tight">Healthy<br>Account</span>
                    </div>

                    <div class="flex gap-1 sm:opacity-0 group-hover:opacity-100 transition-opacity">
                        <button class="p-2 sm:p-1.5 text-text-tertiary hover:text-brand-primary hover:bg-bg-tertiary rounded" title="Send Proactive Message"><i data-lucide="message-square" class="w-4 h-4"></i></button>
                        <button class="p-2 sm:p-1.5 text-text-tertiary hover:text-semantic-warning hover:bg-bg-tertiary rounded" title="Flag for Review"><i data-lucide="flag" class="w-4 h-4"></i></button>
                        <button class="p-2 sm:p-1.5 text-text-tertiary hover:text-text-primary hover:bg-bg-tertiary rounded" title="View Full Profile"><i data-lucide="arrow-right" class="w-4 h-4"></i></button>
                    </div>
                </div>
            </div>
        </template>
    </div>

</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('executiveDashboard', () => ({
        filters: { type: 'all', health: 'all' },
        
        businesses: [
            { id: 1, name: 'Elevate Digital', type: 'Agency', typeColor: '#3B82F6', logo: 'https://ui-avatars.com/api/?name=ED&background=F1F5F9&color=0F1729', tier: 'Scale', jobVolume: '142', paymentVolume: '$42k', usagePct: 92, healthScore: 88, healthColor: 'text-semantic-success' },
            { id: 2, name: 'Dubai Cool AC Repair', type: 'Home Services', typeColor: '#14B8A6', logo: 'https://ui-avatars.com/api/?name=DC&background=F1F5F9&color=0F1729', tier: 'Growth', jobVolume: '210', paymentVolume: '$18k', usagePct: 45, healthScore: 32, healthColor: 'text-semantic-error' },
            { id: 3, name: 'Apex Legal Consultants', type: 'Consultant', typeColor: '#F59E0B', logo: 'https://ui-avatars.com/api/?name=AL&background=F1F5F9&color=0F1729', tier: 'Starter', jobVolume: '12', paymentVolume: '$8k', usagePct: 98, healthScore: 75, healthColor: 'text-semantic-info' },
            { id: 4, name: 'CleanSweep UAE', type: 'Home Services', typeColor: '#14B8A6', logo: 'https://ui-avatars.com/api/?name=CS&background=F1F5F9&color=0F1729', tier: 'Enterprise', jobVolume: '1,204', paymentVolume: '$112k', usagePct: 65, healthScore: 94, healthColor: 'text-semantic-success' },
            { id: 5, name: 'Nexus Marketing', type: 'Agency', typeColor: '#3B82F6', logo: 'https://ui-avatars.com/api/?name=NM&background=F1F5F9&color=0F1729', tier: 'Starter', jobVolume: '4', paymentVolume: '$1.2k', usagePct: 15, healthScore: 28, healthColor: 'text-semantic-error' },
        ],

        get filteredBusinesses() {
            return this.businesses.filter(b => {
                let matchType = this.filters.type === 'all' || b.type.toLowerCase().includes(this.filters.type);
                let matchHealth = true;
                if (this.filters.health === 'critical') matchHealth = b.healthScore < 40;
                if (this.filters.health === 'upgrade') matchHealth = b.usagePct > 85;
                return matchType && matchHealth;
            });
        },

        init() {
            this.$nextTick(() => {
                this.renderSparkline(this.$refs.sparklineMrr, [42, 45, 48, 52, 59, 64, 68], '#5B6AF0');
                this.renderSparkline(this.$refs.sparklineArr, [500, 540, 580, 620, 710, 780, 840], '#5B6AF0');
                this.renderSparkline(this.$refs.sparklineGmv, [120, 140, 110, 160, 130, 150, 125], '#F59E0B');
                this.renderSparkline(this.$refs.sparklineCommission, [3.5, 4.1, 3.8, 4.5, 4.2, 4.8, 4.9], '#10B981');
            });
        },

        renderSparkline(element, data, color) {
            new ApexCharts(element, {
                series: [{ data: data }],
                chart: { type: 'area', width: '100%', height: 48, sparkline: { enabled: true } },
                stroke: { curve: 'smooth', width: 2 },
                fill: { type: 'gradient', gradient: { shadeIntensity: 1, opacityFrom: 0.4, opacityTo: 0, stops: [0, 100] } },
                colors: [color],
                tooltip: { fixed: { enabled: false }, x: { show: false }, y: { title: { formatter: function () { return '' } } }, marker: { show: false } }
            }).render();
        },

        shareDashboard() { alert('Share link copied to clipboard.'); },
        exportSnapshot() { alert('Generating PDF snapshot...'); }
    }));
});
</script>
@endpush
@endsection