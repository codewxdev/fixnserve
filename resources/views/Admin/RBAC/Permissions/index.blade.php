@extends('layouts.app')

@section('title', 'Permission Catalog')

@section('content')
    <div class="p-4 sm:p-6 lg:p-8 bg-bg-primary min-h-screen flex flex-col" x-data="permissionCatalog()">

        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 sm:mb-8 gap-4 shrink-0">
            <div>
                <h1 class="text-h3 sm:text-h2 font-bold tracking-tight text-text-primary flex items-center gap-3">
                    <span class="p-2 bg-brand-primary/10 rounded-lg text-brand-primary border border-brand-primary/20">
                        <i data-lucide="key-round" class="w-5 h-5 sm:w-6 sm:h-6"></i>
                    </span>
                    Permission Catalog
                </h1>
                <p class="text-text-secondary text-body-sm mt-2">Define atomic capabilities, action-level scopes, and risk
                    labels.</p>
            </div>

            <button @click="openModal()"
                class="btn btn-primary w-full md:w-auto p-2 flex items-center justify-center gap-2 shadow-lg">
                <i data-lucide="plus" class="w-4 h-4"></i>
                <span>New Permission</span>
            </button>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 sm:gap-6 mb-6 sm:mb-8">

            <div class="card p-4 sm:p-5 flex items-center gap-4">
                <div
                    class="w-12 h-12 rounded-full bg-semantic-success-bg text-semantic-success border border-semantic-success/20 flex items-center justify-center shrink-0">
                    <i data-lucide="layers" class="w-6 h-6"></i>
                </div>
                <div>
                    <p class="text-caption font-bold text-text-tertiary uppercase tracking-wider">Total Atomic Permissions
                    </p>
                    <h3 class="text-h2 font-bold text-text-primary" x-text="permissions.length"></h3>
                </div>
            </div>

            <div class="card p-4 sm:p-5 flex items-center gap-4">
                <div
                    class="w-12 h-12 rounded-full bg-brand-primary/10 text-brand-primary border border-brand-primary/20 flex items-center justify-center shrink-0">
                    <i data-lucide="folder-tree" class="w-6 h-6"></i>
                </div>
                <div>
                    <p class="text-caption font-bold text-text-tertiary uppercase tracking-wider">Active Module Groups</p>
                    <h3 class="text-h2 font-bold text-text-primary" x-text="modules.length"></h3>
                </div>
            </div>

            <div class="card p-4 sm:p-5 flex items-center gap-4">
                <div
                    class="w-12 h-12 rounded-full bg-semantic-error-bg text-semantic-error border border-semantic-error/20 flex items-center justify-center shrink-0">
                    <i data-lucide="zap" class="w-6 h-6"></i>
                </div>
                <div>
                    <p class="text-caption font-bold text-text-tertiary uppercase tracking-wider">Critical Risk Actions</p>
                    <h3 class="text-h2 font-bold text-text-primary"
                        x-text="permissions.filter(p => p.risk === 'Critical').length"></h3>
                </div>
            </div>

        </div>

        <div class="flex flex-col lg:flex-row gap-6 flex-1 min-h-0">

            <aside class="w-full lg:w-64 shrink-0 flex flex-col">
                <div class="card p-0 overflow-hidden flex flex-col h-full border-border-default">
                    <div class="p-4 border-b border-border-default bg-bg-tertiary shrink-0">
                        <h3 class="text-caption font-bold uppercase tracking-wider text-text-tertiary">Permission Groups
                        </h3>
                    </div>

                    <div class="p-3 space-y-1 overflow-y-auto custom-scrollbar bg-bg-secondary">
                        <button @click="selectedModule = 'All'"
                            :class="selectedModule === 'All' ?
                                'bg-brand-primary/10 text-brand-primary border-r-4 border-brand-primary' :
                                'text-text-secondary hover:bg-bg-tertiary'"
                            class="w-full text-left flex items-center justify-between px-3 py-2.5 rounded text-body-sm transition-colors">
                            <span class="font-bold">All Permissions</span>
                            <span class="text-[10px] bg-bg-primary border border-border-strong px-2 py-0.5 rounded-full"
                                x-text="permissions.length"></span>
                        </button>

                        <div class="h-px bg-border-default my-2"></div>

                        <template x-for="mod in modules" :key="mod">
                            <button @click="selectedModule = mod"
                                :class="selectedModule === mod ?
                                    'bg-brand-primary/10 text-brand-primary border-r-4 border-brand-primary' :
                                    'text-text-secondary hover:bg-bg-tertiary'"
                                class="w-full text-left flex items-center justify-between px-3 py-2.5 rounded text-body-sm transition-colors">
                                <span class="font-medium truncate pr-2" x-text="mod"></span>
                                <span
                                    class="text-[10px] bg-bg-primary border border-border-strong px-2 py-0.5 rounded-full shrink-0"
                                    x-text="permissions.filter(p => p.module === mod).length"></span>
                            </button>
                        </template>
                    </div>
                </div>
            </aside>

            <main class="flex-1 card p-0 overflow-hidden flex flex-col h-[600px] lg:h-auto border-border-default">

                <div
                    class="px-5 py-4 border-b border-border-default bg-bg-tertiary flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 shrink-0">
                    <h2 class="text-h4 font-bold text-text-primary truncate"
                        x-text="selectedModule === 'All' ? 'All Permissions' : selectedModule + ' Module'"></h2>

                    <div class="relative w-full sm:w-64 shrink-0">
                        <i data-lucide="search"
                            class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-text-tertiary"></i>
                        <input type="text" x-model="searchQuery" placeholder="Search identifiers..."
                            class="form-input w-full pl-9 h-9 text-body-sm bg-bg-primary">
                    </div>
                </div>

                <div class="overflow-x-auto overflow-y-auto custom-scrollbar flex-1 bg-bg-secondary relative">

                    <div x-show="isLoading"
                        class="absolute inset-0 z-20 bg-bg-secondary/80 backdrop-blur-sm flex flex-col items-center justify-center">
                        <i data-lucide="loader-2" class="w-8 h-8 animate-spin text-brand-primary mb-3"></i>
                        <span class="text-body-sm font-bold text-text-primary animate-pulse">Syncing Catalog...</span>
                    </div>

                    <table class="w-full text-left min-w-[800px]">
                        <thead
                            class="text-caption uppercase text-text-secondary font-semibold bg-bg-primary border-b border-border-strong sticky top-0 z-10">
                            <tr>
                                <th class="px-5 py-3">Atomic Identifier</th>
                                <th class="px-5 py-3">Type (Action-Level)</th>
                                <th class="px-5 py-3 text-center">Risk Label</th>
                                <th class="px-5 py-3 text-center">Usage Stats</th>
                                <th class="px-5 py-3 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-border-default bg-bg-secondary">

                            <tr x-show="!isLoading && filteredPermissions.length === 0" x-cloak>
                                <td colspan="5" class="px-5 py-12 text-center text-text-tertiary">
                                    <i data-lucide="search-x" class="w-8 h-8 mx-auto mb-2 opacity-50"></i>
                                    <p class="text-body-sm">No permissions found matching your criteria.</p>
                                </td>
                            </tr>

                            <template x-for="perm in filteredPermissions" :key="perm.id">
                                <tr class="hover:bg-bg-tertiary transition-colors group">

                                    <td class="px-5 py-4">
                                        <div class="flex items-center gap-3">
                                            <div class="w-8 h-8 rounded border border-border-strong bg-bg-primary text-text-tertiary flex items-center justify-center shrink-0 font-mono text-[10px] font-bold"
                                                x-text="perm.name.charAt(0).toUpperCase()"></div>
                                            <div>
                                                <span class="font-mono text-body-sm font-bold text-text-primary"
                                                    x-text="perm.name"></span>
                                                <span
                                                    class="block text-caption text-text-secondary mt-0.5 truncate max-w-xs"
                                                    x-text="perm.description"></span>
                                            </div>
                                        </div>
                                    </td>

                                    <td class="px-5 py-4">
                                        <span class="px-2 py-0.5 rounded text-[10px] font-bold border"
                                            :class="getTypeBadgeClass(perm.type)" x-text="perm.type"></span>
                                    </td>

                                    <td class="px-5 py-4 text-center">
                                        <span
                                            class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-bold border uppercase tracking-wider"
                                            :class="getRiskBadgeClass(perm.risk)">
                                            <div class="w-1.5 h-1.5 rounded-full" :class="getRiskDotClass(perm.risk)">
                                            </div>
                                            <span x-text="perm.risk"></span>
                                        </span>
                                    </td>

                                    <td class="px-5 py-4 text-center">
                                        <span
                                            class="text-[10px] text-text-tertiary font-medium bg-bg-primary border border-border-default px-2 py-1 rounded"
                                            x-text="perm.usageCount + ' Roles'"></span>
                                    </td>

                                    <td class="px-5 py-4 text-right">
                                        <div
                                            class="flex justify-end gap-1 opacity-0 group-hover:opacity-100 transition-opacity">
                                            <button @click="openModal(perm)"
                                                class="p-1.5 text-text-tertiary hover:text-brand-primary hover:bg-bg-primary rounded transition-colors"
                                                title="Edit Metadata">
                                                <i data-lucide="edit-2" class="w-4 h-4"></i>
                                            </button>
                                            <button @click="deprecatePermission(perm.id, perm.name)"
                                                class="p-1.5 text-text-tertiary hover:text-semantic-error hover:bg-bg-primary rounded transition-colors"
                                                title="Deprecate / Soft Delete">
                                                <i data-lucide="trash-2" class="w-4 h-4"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            </template>

                        </tbody>
                    </table>
                </div>
            </main>
        </div>

        <div x-show="modals.form"
            class="fixed inset-0 z-50 flex items-center justify-center bg-brand-secondary/80 backdrop-blur-sm p-4" x-cloak>
            <div class="card w-full max-w-md p-0 shadow-2xl flex flex-col max-h-[90vh]" @click.away="modals.form = false">

                <div
                    class="p-5 border-b border-border-default bg-bg-tertiary flex justify-between items-center rounded-t-lg shrink-0">
                    <div class="flex items-center gap-3">
                        <div
                            class="w-8 h-8 rounded-full bg-brand-primary/10 text-brand-primary flex items-center justify-center">
                            <i data-lucide="sliders" class="w-4 h-4"></i>
                        </div>
                        <div>
                            <h3 class="text-h4 font-bold text-text-primary"
                                x-text="form.id ? 'Edit Permission' : 'Create Permission'"></h3>
                            <p class="text-[10px] text-text-secondary mt-0.5">Define an atomic action for the system.</p>
                        </div>
                    </div>
                    <button @click="modals.form = false" class="text-text-tertiary hover:text-text-primary"><i
                            data-lucide="x" class="w-5 h-5"></i></button>
                </div>

                <form @submit.prevent="savePermission" class="flex flex-col flex-1 overflow-hidden">
                    <div class="p-6 space-y-4 overflow-y-auto custom-scrollbar">

                        <div class="form-group mb-0">
                            <label class="form-label">Permission Identifier</label>
                            <input type="text" x-model="form.name" required placeholder="e.g. refund_approve_full"
                                class="form-input w-full font-mono text-sm" :disabled="form.id">
                            <span class="text-[9px] text-text-tertiary mt-1 block">Use snake_case for standard backend
                                conventions. <span x-show="form.id" class="text-semantic-error">Identifier cannot be
                                    changed after creation.</span></span>
                        </div>

                        <div class="form-group mb-0">
                            <label class="form-label">Description</label>
                            <input type="text" x-model="form.description" required
                                placeholder="e.g. Approve refunds up to 100% of order value"
                                class="form-input w-full text-body-sm">
                        </div>

                        <div class="form-group mb-0">
                            <label class="form-label">Module Group</label>
                            <select x-model="form.module" required class="form-input w-full text-body-sm">
                                <template x-for="mod in modules" :key="mod">
                                    <option :value="mod" x-text="mod"></option>
                                </template>
                            </select>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div class="form-group mb-0">
                                <label class="form-label">Action Type</label>
                                <select x-model="form.type" required class="form-input w-full text-body-sm">
                                    <template x-for="t in types" :key="t">
                                        <option :value="t" x-text="t"></option>
                                    </template>
                                </select>
                            </div>

                            <div class="form-group mb-0">
                                <label class="form-label">Risk Level</label>
                                <select x-model="form.risk" required class="form-input w-full text-body-sm"
                                    :class="getRiskInputClass(form.risk)">
                                    <template x-for="r in risks" :key="r">
                                        <option :value="r" x-text="r + ' Risk'"></option>
                                    </template>
                                </select>
                            </div>
                        </div>

                    </div>

                    <div
                        class="p-4 border-t border-border-default flex justify-end gap-3 rounded-b-lg bg-bg-tertiary shrink-0">
                        <button type="button" @click="modals.form = false" class="btn btn-tertiary">Cancel</button>
                        <button type="submit" class="btn btn-primary" :disabled="isSaving">
                            <i data-lucide="loader-2" class="w-4 h-4 mr-2 animate-spin" x-show="isSaving" x-cloak></i>
                            <span
                                x-text="isSaving ? 'Saving...' : (form.id ? 'Update Catalog' : 'Create Permission')"></span>
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </div>

    @push('scripts')
        <script>
            document.addEventListener('alpine:init', () => {
                Alpine.data('permissionCatalog', () => ({
                    isLoading: true,
                    isSaving: false,
                    searchQuery: '',
                    selectedModule: 'All',

                    modals: {
                        form: false
                    },

                    modules: [
                        'Finance Operations', 'Business Management', 'KYC Operations',
                        'Support Operations', 'System Controls', 'Security Controls',
                        'Audit & Compliance'
                    ],
                    types: ['View', 'Create', 'Update', 'Delete (Soft)', 'Approve', 'Override', 'Export',
                        'Execute'
                    ],
                    risks: ['Low', 'Medium', 'High', 'Critical'],

                    form: {
                        id: null,
                        name: '',
                        description: '',
                        module: 'Finance Operations',
                        type: 'View',
                        risk: 'Low'
                    },
                    permissions: [],

                    init() {
                        this.fetchData();
                    },

                    get filteredPermissions() {
                        let result = this.permissions;

                        if (this.selectedModule !== 'All') {
                            result = result.filter(p => p.module === this.selectedModule);
                        }

                        if (this.searchQuery) {
                            const q = this.searchQuery.toLowerCase();
                            result = result.filter(p => p.name.toLowerCase().includes(q) || p
                                .description.toLowerCase().includes(q));
                        }

                         
                        return result.sort((a, b) => a.name.localeCompare(b.name));
                    },

                    async fetchData() {
                        this.isLoading = true;
                        await new Promise(r => setTimeout(r, 600));  

                       
                        this.permissions = [{
                                id: 1,
                                name: 'refund_approve_partial',
                                description: 'Approve refunds up to predefined threshold',
                                module: 'Finance Operations',
                                type: 'Approve',
                                risk: 'Medium',
                                usageCount: 3
                            },
                            {
                                id: 2,
                                name: 'refund_approve_full',
                                description: 'Approve full refunds disregarding threshold',
                                module: 'Finance Operations',
                                type: 'Approve',
                                risk: 'High',
                                usageCount: 1
                            },
                            {
                                id: 3,
                                name: 'business_suspend_temp',
                                description: 'Temporarily freeze a business account',
                                module: 'Business Management',
                                type: 'Update',
                                risk: 'High',
                                usageCount: 2
                            },
                            {
                                id: 4,
                                name: 'business_suspend_perm',
                                description: 'Permanently ban a business account',
                                module: 'Business Management',
                                type: 'Delete (Soft)',
                                risk: 'Critical',
                                usageCount: 1
                            },
                            {
                                id: 5,
                                name: 'sys_kill_switch_exec',
                                description: 'Trigger platform emergency kill switches',
                                module: 'System Controls',
                                type: 'Execute',
                                risk: 'Critical',
                                usageCount: 1
                            },
                            {
                                id: 6,
                                name: 'audit_export_csv',
                                description: 'Download immutable audit logs',
                                module: 'Audit & Compliance',
                                type: 'Export',
                                risk: 'Medium',
                                usageCount: 4
                            },
                            {
                                id: 7,
                                name: 'sub_override_manual',
                                description: 'Manually override subscription tiers',
                                module: 'Business Management',
                                type: 'Override',
                                risk: 'High',
                                usageCount: 2
                            },
                            {
                                id: 8,
                                name: 'kyc_docs_view',
                                description: 'View sensitive KYC documents and PII',
                                module: 'KYC Operations',
                                type: 'View',
                                risk: 'Medium',
                                usageCount: 5
                            },
                        ];

                        this.isLoading = false;
                        this.$nextTick(() => lucide.createIcons());
                    },

                    openModal(perm = null) {
                        if (perm) {
                            // Edit mode
                            this.form = JSON.parse(JSON.stringify(perm));
                        } else {
                            // Create mode
                            this.form = {
                                id: null,
                                name: '',
                                description: '',
                                module: this.selectedModule === 'All' ? this.modules[0] : this
                                    .selectedModule,
                                type: 'View',
                                risk: 'Low'
                            };
                        }
                        this.modals.form = true;
                    },

                    savePermission() {
                        this.isSaving = true;
                        setTimeout(() => {
                            if (this.form.id) {
                                // Update
                                const idx = this.permissions.findIndex(p => p.id === this.form.id);
                                if (idx !== -1) {
                                    this.permissions[idx] = {
                                        ...this.permissions[idx],
                                        ...this.form
                                    };
                                }
                            } else {
                                // Create
                                this.permissions.push({
                                    ...this.form,
                                    id: Date.now(),
                                    usageCount: 0
                                });
                            }
                            this.isSaving = false;
                            this.modals.form = false;
                            this.$nextTick(() => lucide.createIcons());
                        }, 500);
                    },

                    deprecatePermission(id, name) {
                        if (confirm(
                                `DANGER: Deprecating "${name}" will remove it from all active roles and may break backend middleware enforcement.\n\nAre you sure you want to soft delete this capability?`
                                )) {
                            this.permissions = this.permissions.filter(p => p.id !== id);
                        }
                    },

                    // --- UI Badging Helpers ---
                    getTypeBadgeClass(type) {
                        const map = {
                            'View': 'bg-bg-primary text-text-secondary border-border-default',
                            'Create': 'bg-semantic-success-bg text-semantic-success border-semantic-success/20',
                            'Update': 'bg-semantic-info-bg text-semantic-info border-semantic-info/20',
                            'Delete (Soft)': 'bg-semantic-warning-bg text-semantic-warning border-semantic-warning/20',
                            'Approve': 'bg-purple-500/10 text-purple-500 border-purple-500/20',
                            'Override': 'bg-brand-primary/10 text-brand-primary border-brand-primary/20',
                            'Export': 'bg-bg-primary text-text-primary border-border-strong',
                            'Execute': 'bg-semantic-error-bg text-semantic-error border-semantic-error/20'
                        };
                        return map[type] || map['View'];
                    },

                    getRiskBadgeClass(risk) {
                        const map = {
                            'Low': 'bg-semantic-success-bg text-semantic-success border-semantic-success/20',
                            'Medium': 'bg-semantic-info-bg text-semantic-info border-semantic-info/20',
                            'High': 'bg-semantic-warning-bg text-semantic-warning border-semantic-warning/20',
                            'Critical': 'bg-semantic-error-bg text-semantic-error border-semantic-error/30 shadow-sm'
                        };
                        return map[risk] || map['Low'];
                    },

                    getRiskDotClass(risk) {
                        const map = {
                            'Low': 'bg-semantic-success',
                            'Medium': 'bg-semantic-info',
                            'High': 'bg-semantic-warning',
                            'Critical': 'bg-semantic-error animate-pulse'
                        };
                        return map[risk] || map['Low'];
                    },

                    getRiskInputClass(risk) {
                        if (risk === 'Critical')
                        return 'text-semantic-error font-bold border-semantic-error/50 bg-semantic-error-bg/50 focus:ring-semantic-error';
                        if (risk === 'High')
                        return 'text-semantic-warning font-bold border-semantic-warning/50 bg-semantic-warning-bg/50 focus:ring-semantic-warning';
                        return '';
                    }
                }));
            });
        </script>
    @endpush
@endsection
