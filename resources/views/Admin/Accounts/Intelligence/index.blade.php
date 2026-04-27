@extends('layouts.app')

@section('title', 'Business Intelligence & Operations')

@section('content')
    <div class="p-4 sm:p-6 lg:p-8 bg-bg-primary min-h-screen flex flex-col w-full" x-data="businessIntelligence()">

        <div x-show="toast.show" x-transition
            class="fixed top-6 right-6 z-[100] bg-bg-secondary border-l-4 shadow-xl flex items-center gap-3 min-w-[300px] p-4 rounded-lg"
            :class="toast.type === 'error' ? 'border-semantic-error' : 'border-semantic-success'" style="display: none;"
            x-cloak>
            <i data-lucide="info" class="w-5 h-5"
                :class="toast.type === 'error' ? 'text-semantic-error' : 'text-semantic-success'"></i>
            <span x-text="toast.message" class="text-body-sm font-semibold text-text-primary"></span>
        </div>

        <div class="flex flex-col xl:flex-row justify-between items-start xl:items-center mb-6 sm:mb-8 gap-4 shrink-0">
            <div class="min-w-0 flex-1">
                <h1 class="text-h3 sm:text-h2 font-bold tracking-tight text-text-primary flex items-center gap-3">
                    <span
                        class="p-2 bg-brand-primary/10 rounded-lg text-brand-primary border border-brand-primary/20 shrink-0">
                        <i data-lucide="brain-circuit" class="w-6 h-6"></i>
                    </span>
                    Intelligence & Operations
                </h1>
                <p class="text-text-secondary text-body-sm mt-2">Health scoring, risk analysis, and administrative actions
                    for business accounts.</p>
            </div>

            <div
                class="flex flex-col sm:flex-row items-center gap-3 w-full xl:w-auto p-3 bg-bg-secondary border border-border-default rounded-xl shadow-sm">
                <span class="text-caption font-bold text-text-tertiary uppercase tracking-wider whitespace-nowrap">Target
                    Entity:</span>
                <select x-model="selectedBusinessId" @change="loadBusinessData()"
                    class="form-input w-full sm:w-64 text-body-sm font-bold border-border-strong focus:ring-brand-primary">
                    <option value="B-1024">Elevate Digital (B-1024)</option>
                    <option value="B-1025">CleanSweep UAE (B-1025)</option>
                    <option value="B-1026">Apex Legal (B-1026)</option>
                </select>
            </div>
        </div>

        <div x-show="isLoading" class="flex flex-col items-center justify-center py-20" x-cloak>
            <i data-lucide="loader-2" class="w-10 h-10 animate-spin text-brand-primary mb-4"></i>
            <span class="text-body font-bold text-text-primary">Compiling AI Health Matrix...</span>
        </div>

        <div x-show="!isLoading" class="grid grid-cols-1 xl:grid-cols-3 gap-6 sm:gap-8" x-cloak>

            <div class="xl:col-span-2 space-y-6">

                <div class="card p-0 overflow-hidden border-border-default shadow-sm flex flex-col md:flex-row">
                    <div
                        class="p-6 md:w-1/3 bg-bg-secondary border-b md:border-b-0 md:border-r border-border-default flex flex-col items-center justify-center text-center">
                        <h3 class="text-h4 font-bold text-text-primary mb-6">Overall Health</h3>

                        <div class="relative w-32 h-32 flex items-center justify-center mb-4">
                            <svg class="w-full h-full transform -rotate-90" viewBox="0 0 36 36">
                                <path class="text-border-default"
                                    d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831"
                                    fill="none" stroke="currentColor" stroke-width="3" />
                                <path :class="getHealthColor(business.healthScore)"
                                    :stroke-dasharray="`${business.healthScore}, 100`"
                                    d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831"
                                    fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round"
                                    class="transition-all duration-1000" />
                            </svg>
                            <div class="absolute inset-0 flex flex-col items-center justify-center">
                                <span class="text-h1 font-black" :class="getHealthColor(business.healthScore)"
                                    x-text="business.healthScore"></span>
                                <span class="text-[10px] text-text-tertiary font-bold">/100</span>
                            </div>
                        </div>

                        <span
                            class="px-3 py-1 rounded-full text-caption font-bold uppercase tracking-wider border shadow-sm"
                            :class="getTierBadge(business.healthScore)" x-text="getHealthTier(business.healthScore)"></span>
                    </div>

                    <div class="p-6 md:w-2/3 flex flex-col justify-center">
                        <h4 class="text-caption font-bold text-text-tertiary uppercase tracking-wider mb-4">AI Reason Codes
                            & Drivers</h4>
                        <div class="space-y-3">
                            <template x-for="reason in business.reasonCodes" :key="reason.code">
                                <div
                                    class="flex items-start gap-3 p-3 rounded-lg border border-border-default bg-bg-tertiary">
                                    <i :data-lucide="reason.impact > 0 ? 'trending-up' : 'trending-down'"
                                        class="w-5 h-5 shrink-0"
                                        :class="reason.impact > 0 ? 'text-semantic-success' : 'text-semantic-error'"></i>
                                    <div>
                                        <div class="flex items-center gap-2 mb-1">
                                            <span class="font-mono text-[10px] font-bold px-1.5 py-0.5 rounded"
                                                :class="reason.impact > 0 ? 'bg-semantic-success-bg text-semantic-success' :
                                                    'bg-semantic-error-bg text-semantic-error'"
                                                x-text="reason.code"></span>
                                        </div>
                                        <p class="text-body-sm text-text-primary" x-text="reason.description"></p>
                                    </div>
                                </div>
                            </template>
                        </div>
                    </div>
                </div>

                <div>
                    <h3 class="text-h4 font-bold text-text-primary mb-4 flex items-center gap-2">
                        <i data-lucide="bar-chart-2" class="w-5 h-5 text-text-secondary"></i> Health Dimensions
                    </h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                        <template x-for="dim in business.dimensions" :key="dim.name">
                            <div class="card p-4 hover:border-border-strong transition-colors group">
                                <div class="flex justify-between items-start mb-2">
                                    <span class="text-[10px] font-bold text-text-tertiary uppercase tracking-wider"
                                        x-text="dim.name"></span>
                                    <i :data-lucide="dim.icon"
                                        class="w-4 h-4 text-text-secondary group-hover:text-brand-primary transition-colors"></i>
                                </div>
                                <h4 class="text-h3 font-bold text-text-primary truncate" x-text="dim.value"></h4>
                                <div class="mt-2 w-full bg-bg-muted rounded-full h-1 overflow-hidden">
                                    <div class="h-1 rounded-full" :class="getHealthColor(dim.score)"
                                        :style="`width: ${dim.score}%`"></div>
                                </div>
                            </div>
                        </template>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="card p-0 flex flex-col h-full border-border-default">
                        <div class="p-4 border-b border-border-default bg-bg-tertiary flex justify-between items-center">
                            <h3 class="text-body font-bold text-text-primary flex items-center gap-2"><i data-lucide="tags"
                                    class="w-4 h-4"></i> Business Tags</h3>
                            <button @click="modals.addTag = true" class="text-text-tertiary hover:text-brand-primary"><i
                                    data-lucide="plus" class="w-4 h-4"></i></button>
                        </div>
                        <div class="p-4 flex flex-wrap gap-2">
                            <template x-for="(tag, index) in business.tags" :key="index">
                                <span
                                    class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md text-caption font-bold bg-bg-secondary border border-border-strong text-text-primary">
                                    <span x-text="tag"></span>
                                    <button @click="removeTag(index)"
                                        class="text-text-tertiary hover:text-semantic-error"><i data-lucide="x"
                                            class="w-3 h-3"></i></button>
                                </span>
                            </template>
                            <div x-show="business.tags.length === 0" class="text-caption text-text-tertiary">No custom tags
                                applied.</div>
                        </div>
                    </div>

                    <div class="card p-0 flex flex-col h-full border-border-default">
                        <div class="p-4 border-b border-border-default bg-bg-tertiary flex justify-between items-center">
                            <h3 class="text-body font-bold text-text-primary flex items-center gap-2"><i
                                    data-lucide="file-text" class="w-4 h-4"></i> Internal Notes</h3>
                            <button @click="modals.addNote = true" class="text-text-tertiary hover:text-brand-primary"><i
                                    data-lucide="plus-circle" class="w-4 h-4"></i></button>
                        </div>
                        <div class="p-4 space-y-4 max-h-[200px] overflow-y-auto custom-scrollbar bg-bg-secondary flex-1">
                            <template x-for="note in business.notes" :key="note.id">
                                <div class="p-3 bg-bg-primary border border-border-default rounded-lg shadow-sm">
                                    <p class="text-body-sm text-text-primary" x-text="note.content"></p>
                                    <div
                                        class="mt-2 flex justify-between items-center text-[10px] text-text-tertiary font-mono">
                                        <span x-text="note.author"></span>
                                        <span x-text="note.date"></span>
                                    </div>
                                </div>
                            </template>
                            <div x-show="business.notes.length === 0" class="text-caption text-text-tertiary text-center">
                                No internal notes available.</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="xl:col-span-1">
                <div class="card p-0 overflow-hidden shadow-lg border-brand-primary/20 sticky top-6">
                    <div class="p-5 border-b border-border-default bg-brand-primary/5">
                        <h3 class="text-h4 font-bold text-brand-primary flex items-center gap-2">
                            <i data-lucide="command" class="w-5 h-5"></i> Operations Console
                        </h3>
                        <p class="text-caption text-text-secondary mt-1">All actions are subject to RBAC and immutably
                            audited.</p>
                    </div>

                    <div class="p-5 bg-bg-primary space-y-6">

                        <div>
                            <h4 class="text-caption font-bold text-text-tertiary uppercase tracking-wider mb-3">Lifecycle &
                                State</h4>
                            <div class="space-y-3">
                                <button @click="prepareAction('suspend')" x-show="business.status !== 'Suspended'"
                                    class="w-full btn btn-secondary text-semantic-warning border-semantic-warning/30 hover:bg-semantic-warning/10 hover:border-semantic-warning/50 justify-start py-2.5 px-4 transition-colors">
                                    <i data-lucide="pause-circle" class="w-4 h-4 mr-2"></i> Suspend Business
                                </button>
                                <button @click="prepareAction('activate')" x-show="business.status !== 'Active'"
                                    class="w-full btn btn-secondary text-semantic-success border-semantic-success/30 hover:bg-semantic-success/10 hover:border-semantic-success/50 justify-start py-2.5 px-4 transition-colors">
                                    <i data-lucide="play-circle" class="w-4 h-4 mr-2"></i> Activate Business
                                </button>
                                <button @click="prepareAction('archive')"
                                    class="w-full btn btn-secondary text-text-tertiary border-border-default hover:text-text-primary hover:bg-bg-tertiary hover:border-border-strong justify-start py-2.5 px-4 transition-colors">
                                    <i data-lucide="archive" class="w-4 h-4 mr-2"></i> Archive Account
                                </button>
                            </div>
                        </div>

                        <div>
                            <h4 class="text-caption font-bold text-text-tertiary uppercase tracking-wider mb-3">Security &
                                Access</h4>
                            <div class="space-y-3">
                                <button @click="prepareAction('logout')"
                                    class="w-full btn btn-secondary text-semantic-error border-semantic-error/30 hover:bg-semantic-error/10 hover:border-semantic-error/50 justify-start py-2.5 px-4 transition-colors">
                                    <i data-lucide="log-out" class="w-4 h-4 mr-2"></i> Force Team Logout
                                </button>
                                <button @click="prepareAction('reset_pwd')"
                                    class="w-full btn btn-secondary text-text-primary border-border-default hover:bg-bg-tertiary hover:border-border-strong justify-start py-2.5 px-4 transition-colors">
                                    <i data-lucide="key" class="w-4 h-4 mr-2"></i> Reset Admin Password
                                </button>
                            </div>
                        </div>

                        <div>
                            <h4 class="text-caption font-bold text-text-tertiary uppercase tracking-wider mb-3">Compliance
                                & Billing</h4>
                            <div class="space-y-3">
                                <button @click="prepareAction('kyc')"
                                    class="w-full btn btn-secondary text-semantic-info border-semantic-info/30 hover:bg-semantic-info/10 hover:border-semantic-info/50 justify-start py-2.5 px-4 transition-colors">
                                    <i data-lucide="shield-alert" class="w-4 h-4 mr-2"></i> Trigger Manual KYC
                                </button>
                                <button @click="prepareAction('subscription')"
                                    class="w-full btn btn-secondary text-text-primary border-border-default hover:bg-bg-tertiary hover:border-border-strong justify-start py-2.5 px-4 transition-colors">
                                    <i data-lucide="credit-card" class="w-4 h-4 mr-2"></i> Subscription Override
                                </button>
                                <button @click="prepareAction('restrict')"
                                    class="w-full btn btn-secondary text-text-primary border-border-default hover:bg-bg-tertiary hover:border-border-strong justify-start py-2.5 px-4 transition-colors">
                                    <i data-lucide="lock" class="w-4 h-4 mr-2"></i> Restrict Specific Features
                                </button>
                            </div>
                        </div>

                        <div class="pt-5 border-t border-border-default">
                            <div class="space-y-3">
                                <button @click="prepareAction('export')"
                                    class="w-full btn btn-secondary bg-bg-secondary text-text-primary border-border-default hover:bg-bg-tertiary hover:border-border-strong justify-start py-2.5 px-4 transition-colors">
                                    <i data-lucide="download" class="w-4 h-4 mr-2 text-text-secondary"></i> Export
                                    Business Data (GDPR)
                                </button>
                                <button @click="prepareAction('delete')"
                                    class="w-full btn btn-destructive justify-start shadow-sm shadow-semantic-error/20 py-2.5 px-4 transition-colors">
                                    <i data-lucide="trash-2" class="w-4 h-4 mr-2"></i> Delete Business (GDPR)
                                </button>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

        </div>

        <div x-show="modals.action"
            class="fixed inset-0 z-50 flex items-center justify-center bg-brand-secondary/80 backdrop-blur-sm p-4" x-cloak>
            <div class="card w-full max-w-md p-0 shadow-2xl"
                :class="isDestructiveAction() ? 'border-semantic-error' : 'border-semantic-warning'"
                @click.away="modals.action = false">
                <div class="p-5 border-b border-border-default bg-bg-tertiary flex items-center gap-3 rounded-t-xl">
                    <div class="w-10 h-10 rounded-full flex items-center justify-center shrink-0"
                        :class="isDestructiveAction() ? 'bg-semantic-error-bg text-semantic-error' :
                            'bg-semantic-warning-bg text-semantic-warning'">
                        <i data-lucide="shield-alert" class="w-5 h-5"></i>
                    </div>
                    <div>
                        <h3 class="text-h4 font-bold text-text-primary" x-text="actionConfig.title"></h3>
                        <p class="text-[10px] text-text-secondary uppercase tracking-wider font-bold mt-0.5">Audit Log
                            Mandatory</p>
                    </div>
                </div>

                <form @submit.prevent="executeAction">
                    <div class="p-6 space-y-5">
                        <p class="text-body-sm text-text-primary" x-html="actionConfig.description"></p>

                        <div x-show="actionConfig.requiresDualApproval"
                            class="p-3 bg-semantic-error-bg border border-semantic-error/30 rounded-lg flex items-start gap-2"
                            x-cloak>
                            <i data-lucide="lock" class="w-4 h-4 text-semantic-error shrink-0 mt-0.5"></i>
                            <p class="text-caption font-bold text-semantic-error">This action requires dual admin approval.
                                It will be routed to the authorization queue.</p>
                        </div>

                        <div class="form-group mb-0">
                            <label class="form-label">Justification / Reason</label>
                            <textarea x-model="actionReason" required rows="3" class="form-input w-full text-body-sm rounded-xl"
                                placeholder="Provide a detailed reason for the audit log..."></textarea>
                        </div>
                    </div>

                    <div class="p-4 border-t border-border-default flex justify-end gap-3 rounded-b-xl bg-bg-tertiary">
                        <button type="button" @click="modals.action = false" class="btn btn-tertiary">Cancel</button>
                        <button type="submit" class="btn text-white shadow-lg"
                            :class="isDestructiveAction() ? 'btn-destructive' :
                                'btn-primary bg-semantic-warning hover:bg-orange-500 border-none'"
                            :disabled="!actionReason || isProcessing">
                            <i data-lucide="loader-2" class="w-4 h-4 mr-2 animate-spin" x-show="isProcessing"
                                x-cloak></i>
                            <span x-text="isProcessing ? 'Processing...' : 'Confirm Action'"></span>
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <div x-show="modals.addNote"
            class="fixed inset-0 z-50 flex items-center justify-center bg-brand-secondary/80 backdrop-blur-sm p-4" x-cloak>
            <div class="card w-full max-w-md p-0 shadow-2xl border-border-default" @click.away="modals.addNote = false">
                <div
                    class="p-5 border-b border-border-default bg-bg-tertiary flex justify-between items-center rounded-t-xl">
                    <h3 class="text-h4 font-bold text-text-primary">Add Internal Note</h3>
                    <button @click="modals.addNote = false" class="text-text-tertiary"><i data-lucide="x"
                            class="w-5 h-5"></i></button>
                </div>
                <form @submit.prevent="submitNote">
                    <div class="p-6">
                        <textarea x-model="newNote" required rows="4" class="form-input w-full text-body-sm"
                            placeholder="Write internal compliance or context note..."></textarea>
                    </div>
                    <div class="p-4 border-t border-border-default flex justify-end gap-3 rounded-b-xl bg-bg-tertiary">
                        <button type="button" @click="modals.addNote = false" class="btn btn-tertiary">Cancel</button>
                        <button type="submit" class="btn btn-primary" :disabled="!newNote">Save Note</button>
                    </div>
                </form>
            </div>
        </div>

        <div x-show="modals.addTag"
            class="fixed inset-0 z-50 flex items-center justify-center bg-brand-secondary/80 backdrop-blur-sm p-4" x-cloak>
            <div class="card w-full max-w-sm p-0 shadow-2xl border-border-default" @click.away="modals.addTag = false">
                <div
                    class="p-5 border-b border-border-default bg-bg-tertiary flex justify-between items-center rounded-t-xl">
                    <h3 class="text-h4 font-bold text-text-primary">Apply Tag</h3>
                    <button @click="modals.addTag = false" class="text-text-tertiary"><i data-lucide="x"
                            class="w-5 h-5"></i></button>
                </div>
                <form @submit.prevent="submitTag">
                    <div class="p-6">
                        <input type="text" x-model="newTag" required class="form-input w-full text-body-sm"
                            placeholder="e.g. VIP, High Risk, Demo">
                    </div>
                    <div class="p-4 border-t border-border-default flex justify-end gap-3 rounded-b-xl bg-bg-tertiary">
                        <button type="button" @click="modals.addTag = false" class="btn btn-tertiary">Cancel</button>
                        <button type="submit" class="btn btn-primary" :disabled="!newTag">Apply</button>
                    </div>
                </form>
            </div>
        </div>

    </div>

    @push('scripts')
        <script>
            document.addEventListener('alpine:init', () => {
                Alpine.data('businessIntelligence', () => ({
                    isLoading: true,
                    isProcessing: false,
                    selectedBusinessId: 'B-1024',
                    toast: {
                        show: false,
                        message: '',
                        type: 'success'
                    },

                    modals: {
                        action: false,
                        addNote: false,
                        addTag: false
                    },
                    actionType: null,
                    actionReason: '',
                    newNote: '',
                    newTag: '',

                    business: {
                        healthScore: 0,
                        status: '',
                        tags: [],
                        notes: [],
                        dimensions: [],
                        reasonCodes: []
                    },

                    actionConfigs: {
                        'suspend': {
                            title: 'Suspend Business',
                            description: 'This will lock out the entire team and pause all API access.',
                            requiresDualApproval: false
                        },
                        'activate': {
                            title: 'Activate Business',
                            description: 'Restore full operational access for this business.',
                            requiresDualApproval: false
                        },
                        'archive': {
                            title: 'Archive Account',
                            description: 'Move account to cold storage. Requires compliance review.',
                            requiresDualApproval: false
                        },
                        'logout': {
                            title: 'Force Team Logout',
                            description: 'Instantly revoke all active session tokens for the entire team.',
                            requiresDualApproval: false
                        },
                        'reset_pwd': {
                            title: 'Reset Admin Password',
                            description: 'Invalidate current owner password and force reset on next login.',
                            requiresDualApproval: false
                        },
                        'kyc': {
                            title: 'Trigger Manual KYC',
                            description: 'Flag business for mandatory manual compliance review.',
                            requiresDualApproval: false
                        },
                        'subscription': {
                            title: 'Subscription Override',
                            description: 'Manually adjust billing tier or limits.',
                            requiresDualApproval: true
                        },
                        'restrict': {
                            title: 'Restrict Features',
                            description: 'Disable specific platform features for this business.',
                            requiresDualApproval: false
                        },
                        'export': {
                            title: 'Export Data (GDPR)',
                            description: 'Generate a secure archive of all business data.',
                            requiresDualApproval: false
                        },
                        'delete': {
                            title: 'Delete Business',
                            description: '<strong class="text-semantic-error">CRITICAL:</strong> Permanent GDPR erasure. Cannot be undone.',
                            requiresDualApproval: true
                        }
                    },

                    init() {
                        this.loadBusinessData();
                    },

                    get actionConfig() {
                        return this.actionConfigs[this.actionType] || {};
                    },

                    isDestructiveAction() {
                        return ['suspend', 'logout', 'delete', 'restrict'].includes(this.actionType);
                    },

                    async loadBusinessData() {
                        this.isLoading = true;
                        await new Promise(r => setTimeout(r, 800)); // Simulate API Delay

                        // Mock dynamic response based on selection
                        if (this.selectedBusinessId === 'B-1024') {
                            this.business = {
                                healthScore: 88,
                                status: 'Active',
                                tags: ['VIP Client', 'Scale Tier'],
                                notes: [{
                                    id: 1,
                                    author: 'Sarah J.',
                                    date: 'Oct 20, 2026',
                                    content: 'Account manager assigned. Growth trajectory positive.'
                                }],
                                reasonCodes: [{
                                        code: 'H_GROWTH_MRR',
                                        impact: 1,
                                        description: 'Consistent MRR expansion over last 3 quarters.'
                                    },
                                    {
                                        code: 'H_HIGH_ADOPT',
                                        impact: 1,
                                        description: 'Utilizing 85% of Scale tier features.'
                                    },
                                    {
                                        code: 'W_LOW_LOGIN',
                                        impact: -1,
                                        description: 'Owner login frequency dropped by 20% this month.'
                                    }
                                ],
                                dimensions: [{
                                        name: 'Login Activity',
                                        value: 'Stable',
                                        score: 75,
                                        icon: 'log-in'
                                    },
                                    {
                                        name: 'Feature Adoption',
                                        value: 'High',
                                        score: 92,
                                        icon: 'zap'
                                    },
                                    {
                                        name: 'Job Volume',
                                        value: '1.2k/mo',
                                        score: 88,
                                        icon: 'briefcase'
                                    },
                                    {
                                        name: 'Payment Volume',
                                        value: '$42k/mo',
                                        score: 95,
                                        icon: 'credit-card'
                                    },
                                    {
                                        name: 'Team Size',
                                        value: '14/50',
                                        score: 60,
                                        icon: 'users'
                                    },
                                    {
                                        name: 'Support Tickets',
                                        value: 'Low',
                                        score: 90,
                                        icon: 'life-buoy'
                                    },
                                    {
                                        name: 'Payment Time',
                                        value: 'On Time',
                                        score: 100,
                                        icon: 'clock'
                                    },
                                    {
                                        name: 'Growth Trend',
                                        value: '+12%',
                                        score: 85,
                                        icon: 'trending-up'
                                    }
                                ]
                            };
                        } else if (this.selectedBusinessId === 'B-1025') {
                            this.business = {
                                healthScore: 34,
                                status: 'Active',
                                tags: ['Churn Risk'],
                                notes: [],
                                reasonCodes: [{
                                        code: 'C_PAY_FAIL',
                                        impact: -1,
                                        description: 'Multiple payment failures detected recently.'
                                    },
                                    {
                                        code: 'W_LOW_ADOPT',
                                        impact: -1,
                                        description: 'Core features abandoned for >30 days.'
                                    }
                                ],
                                dimensions: [{
                                        name: 'Login Activity',
                                        value: 'Dropping',
                                        score: 20,
                                        icon: 'log-in'
                                    },
                                    {
                                        name: 'Feature Adoption',
                                        value: 'Low',
                                        score: 35,
                                        icon: 'zap'
                                    },
                                    {
                                        name: 'Job Volume',
                                        value: '12/mo',
                                        score: 30,
                                        icon: 'briefcase'
                                    },
                                    {
                                        name: 'Payment Volume',
                                        value: '$800/mo',
                                        score: 40,
                                        icon: 'credit-card'
                                    },
                                    {
                                        name: 'Team Size',
                                        value: '2/5',
                                        score: 50,
                                        icon: 'users'
                                    },
                                    {
                                        name: 'Support Tickets',
                                        value: 'High',
                                        score: 20,
                                        icon: 'life-buoy'
                                    },
                                    {
                                        name: 'Payment Time',
                                        value: 'Late',
                                        score: 10,
                                        icon: 'clock'
                                    },
                                    {
                                        name: 'Growth Trend',
                                        value: '-5%',
                                        score: 30,
                                        icon: 'trending-down'
                                    }
                                ]
                            };
                        } else {
                            this.business = {
                                healthScore: 75,
                                status: 'Active',
                                tags: [],
                                notes: [],
                                reasonCodes: [],
                                dimensions: []
                            };
                        }

                        this.isLoading = false;
                        this.$nextTick(() => lucide.createIcons());
                    },

                    getHealthColor(score) {
                        if (score >= 80) return 'text-semantic-success';
                        if (score >= 40) return 'text-semantic-warning';
                        return 'text-semantic-error';
                    },

                    getTierBadge(score) {
                        if (score >= 80)
                        return 'bg-semantic-success-bg text-semantic-success border-semantic-success/20';
                        if (score >= 40)
                        return 'bg-semantic-warning-bg text-semantic-warning border-semantic-warning/20';
                        return 'bg-semantic-error-bg text-semantic-error border-semantic-error/20 animate-pulse';
                    },

                    getHealthTier(score) {
                        if (score >= 80) return 'Healthy';
                        if (score >= 40) return 'At-Risk';
                        return 'Critical Risk';
                    },

                    showToast(msg, type = 'success') {
                        this.toast = {
                            show: true,
                            message: msg,
                            type: type
                        };
                        setTimeout(() => this.toast.show = false, 3000);
                    },

                    // --- Actions ---
                    prepareAction(type) {
                        this.actionType = type;
                        this.actionReason = '';
                        this.modals.action = true;
                    },

                    executeAction() {
                        this.isProcessing = true;
                        setTimeout(() => {
                            this.isProcessing = false;
                            this.modals.action = false;

                            if (this.actionConfig.requiresDualApproval) {
                                this.showToast(
                                    `Action [${this.actionConfig.title}] submitted for Dual Approval.`,
                                    'success');
                            } else {
                                this.showToast(
                                    `Action [${this.actionConfig.title}] executed successfully.`,
                                    'success');
                                if (this.actionType === 'suspend') this.business.status =
                                    'Suspended';
                                if (this.actionType === 'activate') this.business.status = 'Active';
                            }
                        }, 1000);
                    },

                    submitNote() {
                        this.business.notes.unshift({
                            id: Date.now(),
                            author: 'System Admin',
                            date: 'Just now',
                            content: this.newNote
                        });
                        this.newNote = '';
                        this.modals.addNote = false;
                        this.showToast('Note added to record.');
                    },

                    submitTag() {
                        if (!this.business.tags.includes(this.newTag)) {
                            this.business.tags.push(this.newTag);
                        }
                        this.newTag = '';
                        this.modals.addTag = false;
                    },

                    removeTag(index) {
                        this.business.tags.splice(index, 1);
                    }
                }));
            });
        </script>
    @endpush
@endsection
