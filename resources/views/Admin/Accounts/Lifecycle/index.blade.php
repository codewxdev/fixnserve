@extends('layouts.app')

@section('title', 'Business Lifecycle Management')

@section('content')
<div class="p-4 sm:p-6 lg:p-8 bg-bg-primary min-h-screen flex flex-col w-full" x-data="lifecycleManagement()">

    <div x-show="toast.show" x-transition class="fixed top-6 right-6 z-[100] bg-bg-secondary border-l-4 shadow-xl flex items-center gap-3 min-w-[300px] p-4 rounded-lg"
         :class="toast.type === 'error' ? 'border-semantic-error' : 'border-semantic-success'" style="display: none;" x-cloak>
        <i data-lucide="info" class="w-5 h-5" :class="toast.type === 'error' ? 'text-semantic-error' : 'text-semantic-success'"></i>
        <span x-text="toast.message" class="text-body-sm font-semibold text-text-primary"></span>
    </div>

    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 sm:mb-8 gap-4 shrink-0">
        <div class="min-w-0 flex-1">
            <h1 class="text-h3 sm:text-h2 font-bold tracking-tight text-text-primary flex items-center gap-3">
                <span class="p-2 bg-brand-primary/10 rounded-lg text-brand-primary border border-brand-primary/20 shrink-0">
                    <i data-lucide="git-merge" class="w-5 h-5 sm:w-6 sm:h-6"></i>
                </span>
                Lifecycle Management
            </h1>
            <p class="text-text-secondary text-body-sm mt-2">Manage business states, enforce transitions, and monitor AI churn predictions.</p>
        </div>

        <div class="flex flex-wrap items-center gap-3 w-full md:w-auto shrink-0">
            <button @click="fetchData()" class="btn btn-secondary p-2 flex-1 md:flex-none flex items-center justify-center gap-2">
                <i data-lucide="refresh-cw" class="w-4 h-4" :class="isLoading ? 'animate-spin' : ''"></i> 
                <span class="whitespace-nowrap">Sync States</span>
            </button>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 sm:gap-6 mb-6 sm:mb-8 shrink-0">
        
        <div class="card p-4 sm:p-5 border-semantic-error/30 bg-semantic-error-bg/10 relative overflow-hidden group">
            <div class="flex justify-between items-start mb-2">
                <p class="text-caption font-bold text-semantic-error uppercase tracking-wider flex items-center gap-1.5">
                    <i data-lucide="sparkles" class="w-3.5 h-3.5"></i> High Churn Risk
                </p>
                <i data-lucide="trending-down" class="w-4 h-4 text-semantic-error"></i>
            </div>
            <h3 class="text-h2 font-bold text-text-primary" x-text="metrics.highChurnRisk"></h3>
            <p class="text-caption text-text-secondary mt-1">Businesses predicted to cancel within 30 days.</p>
        </div>

        <div class="card p-4 sm:p-5 border-semantic-info/30 bg-semantic-info-bg/10 relative overflow-hidden group">
            <div class="flex justify-between items-start mb-2">
                <p class="text-caption font-bold text-semantic-info uppercase tracking-wider flex items-center gap-1.5">
                    <i data-lucide="sparkles" class="w-3.5 h-3.5"></i> Upgrade Ready
                </p>
                <i data-lucide="trending-up" class="w-4 h-4 text-semantic-info"></i>
            </div>
            <h3 class="text-h2 font-bold text-text-primary" x-text="metrics.upgradeReady"></h3>
            <p class="text-caption text-text-secondary mt-1">Hitting 85%+ usage limits consistently.</p>
        </div>

        <div class="card p-4 sm:p-5 border-semantic-warning/30 bg-semantic-warning-bg/10 relative overflow-hidden group">
            <div class="flex justify-between items-start mb-2">
                <p class="text-caption font-bold text-semantic-warning uppercase tracking-wider flex items-center gap-1.5">
                    <i data-lucide="sparkles" class="w-3.5 h-3.5"></i> Downgrade Risk
                </p>
                <i data-lucide="minus-circle" class="w-4 h-4 text-semantic-warning"></i>
            </div>
            <h3 class="text-h2 font-bold text-text-primary" x-text="metrics.downgradeRisk"></h3>
            <p class="text-caption text-text-secondary mt-1">Low feature adoption and login frequency.</p>
        </div>

    </div>

    <div class="mb-4 flex items-center gap-2 overflow-x-auto custom-scrollbar pb-2 w-full">
        <button @click="selectedState = 'All'" class="px-4 py-2 rounded-full text-body-sm font-bold whitespace-nowrap transition-all border"
                :class="selectedState === 'All' ? 'bg-bg-primary text-text-primary border-border-strong shadow-sm' : 'bg-bg-secondary text-text-secondary border-border-default hover:text-text-primary'">
            All States
        </button>

        <div class="w-px h-6 bg-border-strong mx-1 shrink-0"></div>

        <template x-for="state in states" :key="state">
            <button @click="selectedState = state" class="px-4 py-2 rounded-full text-body-sm font-bold whitespace-nowrap transition-all border flex items-center gap-2"
                    :class="selectedState === state ? 'bg-bg-primary text-text-primary border-border-strong shadow-sm' : 'bg-bg-secondary text-text-secondary border-border-default hover:text-text-primary'">
                <span class="w-2 h-2 rounded-full" :class="getStateDotClass(state)"></span>
                <span x-text="state"></span>
                <span class="text-[10px] px-1.5 py-0.5 rounded-full bg-bg-muted text-text-tertiary" x-text="businesses.filter(b => b.state === state).length"></span>
            </button>
        </template>
    </div>

    <div class="card p-0 flex flex-col flex-1 min-h-[500px] border-border-default shadow-sm overflow-hidden relative">
        
        <div class="px-4 sm:px-5 py-3 border-b border-border-default bg-bg-tertiary flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 shrink-0 z-10">
            <h3 class="text-body font-bold text-text-primary">Pipeline & Transitions</h3>
            <div class="relative w-full sm:w-80 shrink-0">
                <i data-lucide="search" class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-text-tertiary"></i>
                <input type="text" x-model="searchQuery" placeholder="Search businesses..." class="form-input w-full pl-9 h-10 text-body-sm bg-bg-primary">
            </div>
        </div>

        <div class="flex-1 overflow-auto custom-scrollbar relative w-full bg-bg-primary">
            
            <div x-show="isLoading" class="absolute inset-0 z-50 bg-bg-primary/90 backdrop-blur-sm flex flex-col items-center justify-center" x-cloak>
                <i data-lucide="loader-2" class="w-8 h-8 animate-spin text-brand-primary mb-4"></i>
                <span class="text-body font-bold text-text-primary">Loading Pipeline...</span>
            </div>

            <table class="w-full text-left border-collapse min-w-[1000px]">
                <thead class="text-caption uppercase text-text-secondary font-semibold bg-bg-secondary sticky top-0 z-30 shadow-[0_1px_0_0_rgb(var(--border-strong))]">
                    <tr>
                        <th class="px-5 py-4 border-b border-r border-border-default w-[300px]">Business Identity</th>
                        <th class="px-4 py-4 border-b border-r border-border-default w-[180px]">Current State</th>
                        <th class="px-4 py-4 border-b border-r border-border-default">Duration Context</th>
                        <th class="px-4 py-4 border-b border-r border-border-default">AI Lifecycle Intel</th>
                        <th class="px-4 py-4 border-b text-right">Manual Transition</th>
                    </tr>
                </thead>
                <tbody class="bg-bg-primary divide-y divide-border-default">
                    
                    <tr x-show="!isLoading && filteredBusinesses.length === 0" x-cloak>
                        <td colspan="5" class="px-6 py-16 text-center text-text-tertiary">
                            <i data-lucide="filter" class="w-8 h-8 mx-auto mb-2 opacity-50"></i>
                            <p class="text-body-sm">No businesses found in this state.</p>
                        </td>
                    </tr>

                    <template x-for="biz in filteredBusinesses" :key="biz.id">
                        <tr class="hover:bg-bg-tertiary/50 transition-colors group">
                            
                            <td class="px-5 py-4 border-r border-border-default align-top">
                                <div class="font-bold text-text-primary text-body-sm truncate" x-text="biz.name"></div>
                                <div class="text-[10px] text-text-secondary mt-0.5 uppercase tracking-wider font-bold font-mono" x-text="'ID: ' + biz.id"></div>
                                <div class="mt-2 text-caption text-text-tertiary" x-text="'MRR: $' + biz.mrr"></div>
                            </td>

                            <td class="px-4 py-4 border-r border-border-default align-top">
                                <span class="inline-flex items-center gap-1.5 px-2 py-1 rounded text-[10px] font-bold uppercase tracking-wider border w-fit"
                                      :class="getStateBadgeClass(biz.state)">
                                    <div class="w-1.5 h-1.5 rounded-full" :class="getStateDotClass(biz.state)"></div>
                                    <span x-text="biz.state"></span>
                                </span>
                            </td>

                            <td class="px-4 py-4 border-r border-border-default align-top">
                                <div class="text-body-sm font-medium text-text-primary" x-text="biz.timeInState"></div>
                                <div class="text-[10px] text-text-secondary mt-1 max-w-[200px]" x-text="biz.context"></div>
                                
                                <div x-show="biz.state === 'Trial' || biz.state === 'Grace Period'" class="w-full max-w-[150px] bg-bg-muted rounded-full h-1 mt-2 overflow-hidden" x-cloak>
                                    <div class="h-1 rounded-full" :class="biz.state === 'Trial' ? 'bg-brand-primary' : 'bg-semantic-warning'" :style="`width: ${biz.progressPct}%`"></div>
                                </div>
                            </td>

                            <td class="px-4 py-4 border-r border-border-default align-top">
                                <div x-show="!biz.aiInsight" class="text-caption text-text-tertiary italic">No active predictions.</div>
                                
                                <div x-show="biz.aiInsight" class="p-2 rounded border flex items-start gap-2 bg-bg-primary" :class="getAiIntelBorderClass(biz.aiType)" x-cloak>
                                    <i data-lucide="sparkles" class="w-3.5 h-3.5 mt-0.5 shrink-0" :class="getAiIntelTextClass(biz.aiType)"></i>
                                    <div>
                                        <p class="text-[10px] font-bold uppercase tracking-wider" :class="getAiIntelTextClass(biz.aiType)" x-text="biz.aiType"></p>
                                        <p class="text-caption text-text-secondary mt-0.5 leading-snug" x-text="biz.aiInsight"></p>
                                    </div>
                                </div>
                            </td>

                            <td class="px-4 py-4 text-right align-middle">
                                <button @click="openTransitionModal(biz)" class="btn btn-secondary btn-sm bg-bg-primary hover:bg-bg-tertiary shadow-sm flex items-center justify-center gap-2 ml-auto">
                                    Override <i data-lucide="arrow-right-circle" class="w-4 h-4 text-text-secondary"></i>
                                </button>
                            </td>

                        </tr>
                    </template>
                </tbody>
            </table>
        </div>
    </div>

    <div x-show="modals.transition" class="fixed inset-0 z-[60] flex items-center justify-center bg-brand-secondary/80 backdrop-blur-sm p-4" x-cloak>
        <div class="card w-full max-w-lg p-0 shadow-2xl border-border-default" @click.away="closeTransitionModal()">
            
            <div class="p-5 border-b border-border-default bg-bg-tertiary flex justify-between items-center rounded-t-xl">
                <div>
                    <h3 class="text-h4 font-bold text-text-primary flex items-center gap-2">
                        <i data-lucide="git-commit" class="w-5 h-5 text-brand-primary"></i> Manual State Transition
                    </h3>
                    <p class="text-[10px] text-text-secondary uppercase tracking-wider font-bold mt-1" x-text="transitionData.biz?.name"></p>
                </div>
                <button @click="closeTransitionModal()" class="text-text-tertiary hover:text-text-primary"><i data-lucide="x" class="w-5 h-5"></i></button>
            </div>
            
            <form @submit.prevent="executeTransition">
                <div class="p-6 space-y-5">
                    
                    <div class="flex items-center justify-between p-3 bg-bg-secondary rounded-lg border border-border-default">
                        <span class="text-caption text-text-secondary">Current State</span>
                        <span class="px-2 py-0.5 rounded text-[10px] font-bold border uppercase" :class="getStateBadgeClass(transitionData.biz?.state)" x-text="transitionData.biz?.state"></span>
                    </div>

                    <div class="form-group mb-0">
                        <label class="form-label">Target State (Override)</label>
                        <select x-model="transitionData.targetState" class="form-input w-full text-body-sm" required>
                            <option value="" disabled selected>Select new state...</option>
                            <template x-for="state in getAvailableTransitions(transitionData.biz?.state)" :key="state">
                                <option :value="state" x-text="state"></option>
                            </template>
                        </select>
                    </div>

                    <div x-show="isDestructiveState(transitionData.targetState)" class="p-4 bg-semantic-error-bg border border-semantic-error/30 rounded-lg flex items-start gap-3" x-cloak>
                        <i data-lucide="shield-alert" class="w-5 h-5 text-semantic-error shrink-0 mt-0.5"></i>
                        <div>
                            <p class="text-body-sm font-bold text-semantic-error">Dual Approval Required</p>
                            <p class="text-caption text-text-primary mt-1">Transitions to <strong x-text="transitionData.targetState"></strong> are destructive. This action will be queued for secondary authorization and logged immutably.</p>
                        </div>
                    </div>

                    <div class="form-group mb-0">
                        <label class="form-label">Audit Justification</label>
                        <textarea x-model="transitionData.justification" required rows="3" class="form-input w-full text-body-sm rounded-xl" placeholder="Mandatory reason for manual override..."></textarea>
                    </div>

                </div>
                
                <div class="p-5 border-t border-border-default flex justify-end gap-3 rounded-b-xl bg-bg-tertiary">
                    <button type="button" @click="closeTransitionModal()" class="btn btn-tertiary">Cancel</button>
                    <button type="submit" class="btn" :class="isDestructiveState(transitionData.targetState) ? 'btn-destructive' : 'btn-primary'" :disabled="!transitionData.targetState || !transitionData.justification || isSaving">
                        <i data-lucide="loader-2" class="w-4 h-4 mr-2 animate-spin" x-show="isSaving"></i>
                        <span x-text="isDestructiveState(transitionData.targetState) ? 'Submit for Approval' : 'Force Transition'"></span>
                    </button>
                </div>
            </form>

        </div>
    </div>

</div>

@push('scripts')
<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('lifecycleManagement', () => ({
        isLoading: true,
        isSaving: false,
        searchQuery: '',
        selectedState: 'All',
        toast: { show: false, message: '', type: 'success' },
        
        modals: { transition: false },
        
        states: ['Pending', 'Active', 'Trial', 'Past Due', 'Grace Period', 'Suspended', 'Cancelled', 'Archived'],
        businesses: [],
        
        transitionData: { biz: null, targetState: '', justification: '' },
        
        metrics: { highChurnRisk: 0, upgradeReady: 0, downgradeRisk: 0 },

        init() {
            this.fetchData();
        },

        get filteredBusinesses() {
            let result = this.businesses;
            if (this.selectedState !== 'All') {
                result = result.filter(b => b.state === this.selectedState);
            }
            if (this.searchQuery) {
                const q = this.searchQuery.toLowerCase();
                result = result.filter(b => b.name.toLowerCase().includes(q) || b.id.toLowerCase().includes(q));
            }
            return result;
        },

        async fetchData() {
            this.isLoading = true;
            await new Promise(r => setTimeout(r, 600)); // Simulate API
            
            this.businesses = [
                { id: 'B-101', name: 'Elevate Digital', state: 'Active', mrr: 249, timeInState: '4 months', context: 'Standard operational state.', aiType: 'Upgrade Ready', aiInsight: 'Sustained 92% utilization of active jobs limit.', progressPct: 0 },
                { id: 'B-102', name: 'Dubai Cool AC', state: 'Trial', mrr: 129, timeInState: 'Day 12 of 14', context: 'Card not yet on file.', aiType: 'High Churn Risk', aiInsight: 'Zero logins in past 5 days. Low conversion probability.', progressPct: 85 },
                { id: 'B-103', name: 'CleanSweep UAE', state: 'Grace Period', mrr: 499, timeInState: 'Day 3 of 5', context: 'Payment failed (Insufficient Funds). Auto-suspension in 2 days.', aiType: null, aiInsight: null, progressPct: 60 },
                { id: 'B-104', name: 'Al Noor Consulting', state: 'Suspended', mrr: 49, timeInState: '12 Days', context: 'Auto-suspended due to unpaid invoices.', aiType: 'High Churn Risk', aiInsight: 'Historically unresponsive to billing emails.', progressPct: 0 },
                { id: 'B-105', name: 'Nexus Marketing', state: 'Pending', mrr: 0, timeInState: '2 Hours', context: 'Awaiting manual KYC review.', aiType: null, aiInsight: null, progressPct: 0 },
                { id: 'B-106', name: 'Apex Legal', state: 'Active', mrr: 899, timeInState: '1 year', context: 'Annual contract.', aiType: 'Downgrade Risk', aiInsight: 'Team size reduced by 40% this quarter.', progressPct: 0 },
            ];

            // Calculate Metrics
            this.metrics.highChurnRisk = this.businesses.filter(b => b.aiType === 'High Churn Risk').length;
            this.metrics.upgradeReady = this.businesses.filter(b => b.aiType === 'Upgrade Ready').length;
            this.metrics.downgradeRisk = this.businesses.filter(b => b.aiType === 'Downgrade Risk').length;

            this.isLoading = false;
            this.$nextTick(() => lucide.createIcons());
        },

        showToast(msg, type = 'success') {
            this.toast = { show: true, message: msg, type: type };
            setTimeout(() => this.toast.show = false, 3000);
        },

        // --- Modals & Transitions ---
        openTransitionModal(biz) {
            this.transitionData = { biz: biz, targetState: '', justification: '' };
            this.modals.transition = true;
        },

        closeTransitionModal() {
            this.modals.transition = false;
            this.transitionData = { biz: null, targetState: '', justification: '' };
        },

        getAvailableTransitions(currentState) {
             return this.states.filter(s => s !== currentState);
        },

        isDestructiveState(state) {
            return ['Suspended', 'Cancelled', 'Archived'].includes(state);
        },

        async executeTransition() {
            this.isSaving = true;
            await new Promise(r => setTimeout(r, 800)); // Simulate API

            const isDestructive = this.isDestructiveState(this.transitionData.targetState);
            
            if (isDestructive) {
                this.showToast(`Transition to ${this.transitionData.targetState} queued for Dual Approval.`, 'success');
            } else {
                // Optimistic UI update
                const b = this.businesses.find(x => x.id === this.transitionData.biz.id);
                if(b) {
                    b.state = this.transitionData.targetState;
                    b.timeInState = 'Just now';
                    b.context = 'Manually transitioned by admin.';
                    b.progressPct = 0;
                }
                this.showToast(`Business successfully transitioned to ${this.transitionData.targetState}.`);
            }

            this.isSaving = false;
            this.closeTransitionModal();
            this.$nextTick(() => lucide.createIcons());
        },

        // --- Badging Helpers ---
        getStateBadgeClass(state) {
            const map = {
                'Pending': 'bg-semantic-info-bg text-semantic-info border-semantic-info/30',
                'Active': 'bg-semantic-success-bg text-semantic-success border-semantic-success/30',
                'Trial': 'bg-brand-primary/10 text-brand-primary border-brand-primary/30',
                'Past Due': 'bg-semantic-error-bg text-semantic-error border-semantic-error/30',
                'Grace Period': 'bg-semantic-warning-bg text-semantic-warning border-semantic-warning/30',
                'Suspended': 'bg-bg-primary text-semantic-error border-semantic-error/50',
                'Cancelled': 'bg-bg-tertiary text-text-secondary border-border-strong',
                'Archived': 'bg-bg-primary text-text-tertiary border-border-default line-through'
            };
            return map[state] || 'bg-bg-secondary text-text-primary border-border-default';
        },

        getStateDotClass(state) {
            const map = {
                'Pending': 'bg-semantic-info',
                'Active': 'bg-semantic-success',
                'Trial': 'bg-brand-primary',
                'Past Due': 'bg-semantic-error',
                'Grace Period': 'bg-semantic-warning',
                'Suspended': 'bg-semantic-error',
                'Cancelled': 'bg-text-secondary',
                'Archived': 'bg-border-strong'
            };
            return map[state] || 'bg-text-primary';
        },

        getAiIntelBorderClass(type) {
            if(type === 'High Churn Risk') return 'border-semantic-error/30';
            if(type === 'Upgrade Ready') return 'border-semantic-info/30';
            if(type === 'Downgrade Risk') return 'border-semantic-warning/30';
            return 'border-border-default';
        },

        getAiIntelTextClass(type) {
            if(type === 'High Churn Risk') return 'text-semantic-error';
            if(type === 'Upgrade Ready') return 'text-semantic-info';
            if(type === 'Downgrade Risk') return 'text-semantic-warning';
            return 'text-text-tertiary';
        }
    }));
});
</script>
@endpush
@endsection