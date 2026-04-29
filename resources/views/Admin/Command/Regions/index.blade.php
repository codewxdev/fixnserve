@extends('layouts.app')

@section('content')
<div class="p-4 sm:p-6 lg:p-8 bg-bg-primary min-h-screen flex flex-col" x-data="regionalControl()">

    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4 shrink-0">
        <div>
            <h1 class="text-h3 sm:text-h2 font-bold tracking-tight text-text-primary flex items-center gap-3">
                <span class="p-2 bg-brand-primary/10 rounded-lg text-brand-primary border border-brand-primary/20">
                    <i data-lucide="globe-2" class="w-5 h-5 sm:w-6 sm:h-6"></i>
                </span>
                Regional Operations
            </h1>
            <p class="text-text-secondary text-body-sm mt-2">Control platform availability and signups by Country/Region.</p>
        </div>
    </div>

    <div class="flex flex-col lg:flex-row gap-4 sm:gap-6 flex-1 lg:h-[calc(100vh-200px)] lg:min-h-[600px]">

        <div class="w-full lg:w-1/3 card p-0 flex flex-col overflow-hidden h-[400px] lg:h-full shrink-0 border-border-default">
            <div class="p-3 sm:p-4 border-b border-border-default bg-bg-tertiary">
                <div class="relative">
                    <input type="text" x-model="search" placeholder="Search Region..."
                        class="form-input w-full pl-9 bg-bg-primary text-body-sm h-10">
                    <i data-lucide="search" class="w-4 h-4 text-text-tertiary absolute left-3 top-3"></i>
                </div>
            </div>

            <div class="flex-1 overflow-y-auto p-2 sm:p-3 space-y-2 custom-scrollbar bg-bg-secondary">
                <template x-for="region in filteredRegions" :key="region.id">
                    <div class="p-3 rounded-lg border border-border-default hover:bg-bg-tertiary transition group relative cursor-pointer" @click="openModal(region)">
                        <div class="flex justify-between items-start gap-2">
                            <div class="min-w-0 flex-1">
                                <h4 class="font-semibold text-text-primary text-body-sm truncate" x-text="region.name"></h4>
                                <span class="inline-block mt-1 text-[10px] font-mono text-text-secondary border border-border-strong px-1.5 rounded bg-bg-primary" x-text="'ISO: ' + region.iso2"></span>
                            </div>
                            <span x-show="region.status === 'active'" class="shrink-0 text-semantic-success bg-semantic-success-bg border border-semantic-success/20 text-[10px] px-2 py-0.5 rounded font-bold uppercase whitespace-nowrap">Enabled</span>
                            <span x-show="region.status === 'soft_disable'" class="shrink-0 text-semantic-warning bg-semantic-warning-bg border border-semantic-warning/20 text-[10px] px-2 py-0.5 rounded font-bold uppercase whitespace-nowrap">Soft Disable</span>
                            <span x-show="region.status === 'hard_disable'" class="shrink-0 text-semantic-error bg-semantic-error-bg border border-semantic-error/20 text-[10px] px-2 py-0.5 rounded font-bold uppercase whitespace-nowrap">Hard Disable</span>
                        </div>
                    </div>
                </template>
                <div x-show="filteredRegions.length === 0" class="text-center text-text-tertiary text-body-sm mt-10">No regions found.</div>
            </div>
        </div>

        <div class="w-full lg:w-2/3 card p-0 overflow-hidden relative h-[400px] lg:h-full border-border-default">
            <div class="absolute top-3 left-3 right-3 sm:right-auto z-10 backdrop-blur px-3 py-2 rounded-md border border-border-default text-caption text-text-primary bg-bg-primary/90 shadow-sm flex flex-col sm:flex-row flex-wrap gap-x-4 gap-y-1.5">
                <div class="flex items-center gap-2 whitespace-nowrap"><span class="w-2 h-2 rounded-full bg-semantic-success shrink-0"></span> Enabled (Normal Ops)</div>
                <div class="flex items-center gap-2 whitespace-nowrap"><span class="w-2 h-2 rounded-full bg-semantic-warning shrink-0"></span> Soft Disable (No Signups)</div>
                <div class="flex items-center gap-2 whitespace-nowrap"><span class="w-2 h-2 rounded-full bg-semantic-error shrink-0"></span> Hard Disable (Emergency)</div>
            </div>
            <div class="w-full h-full bg-bg-tertiary flex items-center justify-center p-4 text-center">
                <span class="text-text-tertiary font-mono text-sm">[Map Visualization Engine]</span>
            </div>
        </div>
    </div>

    <div x-show="modal.open" class="fixed inset-0 z-50 flex items-center justify-center bg-brand-secondary/80 backdrop-blur-sm p-4 sm:p-6" x-cloak>
        <div class="card w-full max-w-lg shadow-2xl p-0 max-h-[90vh] flex flex-col" @click.away="modal.open = false">
            
            <div class="p-4 sm:p-5 border-b border-border-default bg-bg-tertiary rounded-t-lg flex justify-between items-start sm:items-center shrink-0">
                <div class="pr-4">
                    <h3 class="text-h4 font-bold text-text-primary flex items-center gap-2">
                        <span x-text="modal.region?.name"></span>
                    </h3>
                    <p class="text-caption text-text-secondary mt-1">Modify B2B availability status</p>
                </div>
                <button @click="modal.open = false" class="text-text-tertiary hover:text-text-primary shrink-0 p-1"><i data-lucide="x" class="w-5 h-5"></i></button>
            </div>

            <div class="p-4 sm:p-6 overflow-y-auto custom-scrollbar">
                
                <div class="bg-semantic-info-bg border border-semantic-info/30 rounded-lg p-4 mb-5 sm:mb-6" x-show="modal.selectedStatus !== 'active'">
                    <h4 class="text-caption font-bold text-semantic-info uppercase tracking-wide mb-2 flex items-center gap-2">
                        <i data-lucide="alert-circle" class="w-4 h-4"></i> Impact Preview
                    </h4>
                    <div class="grid grid-cols-2 gap-3 sm:gap-4 text-body-sm">
                        <div>
                            <span class="text-text-secondary block text-caption">Affected Businesses</span>
                            <span class="text-text-primary font-mono font-bold" x-text="modal.region?.businesses || 0"></span>
                        </div>
                        <div>
                            <span class="text-text-secondary block text-caption">Active Jobs (Risk)</span>
                            <span class="text-text-primary font-mono font-bold" x-text="modal.region?.active_jobs || 0"></span>
                        </div>
                    </div>
                </div>

                <label class="text-label text-text-secondary block mb-3">Select New Status</label>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 mb-5 sm:mb-6">
                    <label class="cursor-pointer">
                        <input type="radio" x-model="modal.selectedStatus" value="active" class="peer sr-only">
                        <div class="p-3 text-center rounded-lg border border-border-default hover:bg-bg-tertiary transition peer-checked:bg-semantic-success-bg peer-checked:border-semantic-success peer-checked:text-semantic-success text-text-secondary h-full flex flex-col justify-center items-center">
                            <div class="text-body-sm font-bold">Enabled</div>
                            <div class="text-[10px] opacity-80 mt-1">Normal Ops</div>
                        </div>
                    </label>

                    <label class="cursor-pointer">
                        <input type="radio" x-model="modal.selectedStatus" value="soft_disable" class="peer sr-only">
                        <div class="p-3 text-center rounded-lg border border-border-default hover:bg-bg-tertiary transition peer-checked:bg-semantic-warning-bg peer-checked:border-semantic-warning peer-checked:text-semantic-warning text-text-secondary h-full flex flex-col justify-center items-center">
                            <div class="text-body-sm font-bold">Soft Disable</div>
                            <div class="text-[10px] opacity-80 mt-1">Block Signups</div>
                        </div>
                    </label>

                    <label class="cursor-pointer">
                        <input type="radio" x-model="modal.selectedStatus" value="hard_disable" class="peer sr-only">
                        <div class="p-3 text-center rounded-lg border border-border-default hover:bg-bg-tertiary transition peer-checked:bg-semantic-error-bg peer-checked:border-semantic-error peer-checked:text-semantic-error text-text-secondary h-full flex flex-col justify-center items-center">
                            <div class="text-body-sm font-bold">Hard Disable</div>
                            <div class="text-[10px] opacity-80 mt-1">Emergency Stop</div>
                        </div>
                    </label>
                </div>

                <div x-show="modal.selectedStatus === 'hard_disable'" class="p-3 bg-semantic-error-bg border border-semantic-error/30 rounded-md flex gap-3 items-start">
                    <i data-lucide="shield-alert" class="w-5 h-5 text-semantic-error mt-0.5 shrink-0"></i>
                    <p class="text-caption text-text-primary"><strong class="text-semantic-error">Dual Approval Required:</strong> Hard disabling a region will block all business API access and client portals. An alert will be sent to the primary operational approver.</p>
                </div>
            </div>

            <div class="p-4 border-t border-border-default rounded-b-lg bg-bg-tertiary flex flex-col sm:flex-row justify-end gap-3 shrink-0">
                <button @click="modal.open = false" class="btn btn-tertiary w-full sm:w-auto order-2 sm:order-1">Cancel</button>
                <button @click="saveStatus()" class="btn p-2 btn-primary w-full sm:w-auto order-1 sm:order-2 justify-center" :disabled="isSaving">
                    <i data-lucide="loader-2" class="w-4 h-4 mr-2 animate-spin" x-show="isSaving" x-cloak></i>
                    <span x-text="isSaving ? 'Updating...' : 'Update Status'"></span>
                </button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('regionalControl', () => ({
            search: '',
            regions: [],
            isSaving: false,
            modal: { open: false, region: null, selectedStatus: 'active' },

            init() {
                this.fetchRegions();
            },

            get filteredRegions() {
                if (this.search === '') return this.regions;
                return this.regions.filter(r => r.name.toLowerCase().includes(this.search.toLowerCase()));
            },

            async fetchRegions() {
                // Mock Data for UI. Replace with API call.
                this.regions = [
                    { id: 1, name: 'United Arab Emirates', iso2: 'AE', status: 'active', businesses: 1240, active_jobs: 4500 },
                    { id: 2, name: 'Saudi Arabia', iso2: 'SA', status: 'soft_disable', businesses: 0, active_jobs: 0 },
                    { id: 3, name: 'Qatar', iso2: 'QA', status: 'hard_disable', businesses: 0, active_jobs: 0 }
                ];
            },

            openModal(region) {
                this.modal.region = region;
                this.modal.selectedStatus = region.status;
                this.modal.open = true;
            },

            async saveStatus() {
                this.isSaving = true;
                
                
                setTimeout(() => lucide.createIcons(), 10);
                
                try {
                    const token = localStorage.getItem('token');
                    const csrf = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
                    
                    // Simulate API Delay
                    await new Promise(r => setTimeout(r, 800));

                    // Update UI locally
                    const idx = this.regions.findIndex(r => r.id === this.modal.region.id);
                    if(idx !== -1) this.regions[idx].status = this.modal.selectedStatus;
                    
                    this.modal.open = false;
                } catch (e) {
                    alert('Update failed');
                } finally {
                    this.isSaving = false;
                }
            }
        }));
    });
</script>
@endpush
@endsection