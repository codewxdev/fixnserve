@extends('layouts.app')

@section('title', 'Access Matrix & Governance')

@section('content')
<div class="p-4 sm:p-6 lg:p-8 bg-bg-primary min-h-screen flex flex-col w-full" x-data="accessMatrix()">

    <div x-show="toast.show" x-transition class="fixed top-6 right-6 z-[100] bg-bg-secondary border-l-4 shadow-xl flex items-center gap-3 min-w-[300px] p-4 rounded-lg"
         :class="toast.type === 'error' ? 'border-semantic-error' : 'border-semantic-success'" style="display: none;" x-cloak>
        <i data-lucide="info" class="w-5 h-5" :class="toast.type === 'error' ? 'text-semantic-error' : 'text-semantic-success'"></i>
        <span x-text="toast.message" class="text-body-sm font-semibold text-text-primary"></span>
    </div>

    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 sm:mb-8 gap-4 shrink-0">
        <div class="min-w-0 flex-1">
            <h1 class="text-h3 sm:text-h2 font-bold tracking-tight text-text-primary flex items-center gap-3">
                <span class="p-2 bg-brand-primary/10 rounded-lg text-brand-primary border border-brand-primary/20 shrink-0">
                    <i data-lucide="grid" class="w-5 h-5 sm:w-6 sm:h-6"></i>
                </span>
                Access Matrix
            </h1>
            <p class="text-text-secondary text-body-sm mt-2">Map roles to atomic permissions using the authorization grid.</p>
        </div>

        <div class="flex flex-wrap items-center gap-3 w-full md:w-auto shrink-0">
            <button @click="modals.compare = true" class="btn btn-secondary px-4 py-2 flex-1 md:flex-none flex items-center justify-center gap-2 rounded-lg">
                <i data-lucide="git-compare" class="w-4 h-4"></i> <span class="whitespace-nowrap">Compare</span>
            </button>
            <button @click="exportMatrix()" class="btn btn-primary px-4 py-2 flex-1 md:flex-none flex items-center justify-center gap-2 rounded-lg shadow-lg">
                <i data-lucide="download" class="w-4 h-4"></i> <span class="whitespace-nowrap">Export</span>
            </button>
        </div>
    </div>

    <div class="card p-0 flex flex-col flex-1 border-border-default shadow-sm overflow-hidden relative min-h-[600px]">
        
        <div class="p-4 border-b border-border-default bg-bg-tertiary flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 shrink-0">
            <h3 class="text-body font-bold text-text-primary">Role vs Permission Mapping</h3>
            <div class="relative w-full sm:w-80 shrink-0">
                <i data-lucide="search" class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-text-tertiary"></i>
                <input type="text" x-model="searchQuery" placeholder="Search permissions..." class="form-input w-full pl-9 h-10 text-body-sm bg-bg-primary rounded-lg border-border-default">
            </div>
        </div>

        <div class="flex-1 overflow-auto custom-scrollbar relative bg-bg-primary w-full max-h-[70vh]">
            
            <div x-show="isLoading" class="absolute inset-0 z-50 bg-bg-primary/90 backdrop-blur-sm flex flex-col items-center justify-center">
                <i data-lucide="loader-2" class="w-8 h-8 animate-spin text-brand-primary mb-3"></i>
                <span class="text-body font-bold text-text-primary">Loading Matrix...</span>
            </div>

            <table class="w-full text-left border-separate border-spacing-0 min-w-max">
                
                <thead>
                    <tr>
                        <th class="px-5 py-4 bg-bg-secondary sticky top-0 left-0 z-40 border-b border-r border-border-default min-w-[300px] w-[350px] shadow-[2px_2px_5px_rgba(0,0,0,0.02)]">
                            <span class="text-caption uppercase text-text-secondary font-bold tracking-wider">Permissions</span>
                        </th>
                        
                        <template x-for="role in roles" :key="role.id">
                            <th class="px-4 py-4 bg-bg-secondary sticky top-0 z-30 text-center border-b border-r border-border-default min-w-[140px] w-[140px]">
                                <div class="flex flex-col items-center justify-center gap-1 w-full">
                                    <span class="text-body-sm font-bold text-text-primary truncate w-full" :title="role.name" x-text="role.name"></span>
                                    <span x-show="role.isSystem" class="text-[9px] text-semantic-error bg-semantic-error-bg border border-semantic-error/20 px-2 py-0.5 rounded uppercase font-bold flex items-center justify-center gap-1 w-max"><i data-lucide="lock" class="w-2.5 h-2.5 shrink-0"></i> Immutable</span>
                                    <span x-show="!role.isSystem" class="text-[9px] text-text-secondary bg-bg-muted border border-border-strong px-2 py-0.5 rounded uppercase font-bold w-max">Custom</span>
                                </div>
                            </th>
                        </template>
                    </tr>
                </thead>

                <tbody class="bg-bg-primary">
                    
                    <tr x-show="!isLoading && filteredModules.length === 0" x-cloak>
                        <td :colspan="roles.length + 1" class="px-6 py-12 text-center text-text-tertiary">
                            <p class="text-body-sm">No permissions found matching search.</p>
                        </td>
                    </tr>

                    <template x-for="mod in filteredModules" :key="mod">
                        <React.Fragment>
                            
                            <tr class="bg-brand-primary/5">
                                <td class="px-5 py-3 sticky left-0 z-20 bg-brand-primary/5 shadow-[2px_0_5px_rgba(0,0,0,0.02)] border-b border-r border-border-default">
                                    <div class="flex items-center gap-2">
                                        <i data-lucide="folder-tree" class="w-4 h-4 text-brand-primary"></i> 
                                        <span class="font-bold text-brand-primary text-xs uppercase tracking-wider truncate" x-text="mod"></span>
                                    </div>
                                </td>
                                
                                <template x-for="role in roles" :key="role.id">
                                    <td class="p-2 text-center border-b border-r border-border-default align-middle bg-brand-primary/5">
                                        <div x-show="role.isSystem" class="text-[10px] text-brand-primary/50 uppercase font-bold w-full">System</div>
                                        <button x-show="!role.isSystem" 
                                                @click="bulkToggleModule(role, mod)" 
                                                class="text-[9px] font-bold uppercase tracking-wider px-2 py-1 rounded transition-colors"
                                                :class="hasAllModulePerms(role.id, mod) ? 'bg-semantic-error/10 text-semantic-error hover:bg-semantic-error/20' : 'bg-brand-primary/10 text-brand-primary hover:bg-brand-primary/20'">
                                            <span x-text="hasAllModulePerms(role.id, mod) ? 'Revoke All' : 'Grant All'"></span>
                                        </button>
                                    </td>
                                </template>
                            </tr>

                            <template x-for="perm in getPermissionsForModule(mod)" :key="perm.id">
                                <tr class="hover:bg-bg-secondary transition-colors group">
                                    
                                    <td class="px-5 py-4 sticky left-0 z-10 bg-bg-primary group-hover:bg-bg-secondary shadow-[2px_0_5px_rgba(0,0,0,0.02)] border-b border-r border-border-default transition-colors w-[300px]">
                                        <div class="flex flex-col gap-1 w-[260px] sm:w-[310px] whitespace-normal">
                                            <span class="font-mono text-body-sm font-bold text-text-primary break-words leading-tight" x-text="perm.name"></span>
                                            <span class="text-[11px] text-text-secondary leading-snug break-words" x-text="perm.description"></span>
                                        </div>
                                    </td>

                                    <template x-for="role in roles" :key="role.id">
                                        <td class="p-0 text-center border-b border-r border-border-default align-middle bg-inherit min-w-[140px] w-[140px]">
                                            
                                            <label class="cursor-pointer flex items-center justify-center w-full h-full min-h-[70px] m-0 transition-colors"
                                                   :class="role.isSystem ? 'bg-bg-tertiary/50 opacity-60 cursor-not-allowed' : 'hover:bg-brand-primary/5'">
                                                
                                                <input type="checkbox" class="sr-only peer" 
                                                       :checked="hasPermission(role.id, perm.id)"
                                                       :disabled="role.isSystem"
                                                       @change="requestToggle(role, perm, $event.target.checked)">
                                                
                                                <div class="w-6 h-6 rounded border-2 flex items-center justify-center transition-all shadow-sm"
                                                     :class="{
                                                         'border-brand-primary bg-brand-primary text-white scale-110': hasPermission(role.id, perm.id) && !role.isSystem,
                                                         'border-border-strong bg-bg-primary peer-hover:border-brand-primary/50': !hasPermission(role.id, perm.id) && !role.isSystem,
                                                         'border-semantic-error bg-semantic-error-bg text-semantic-error': role.isSystem && hasPermission(role.id, perm.id),
                                                         'border-border-default bg-bg-muted': role.isSystem && !hasPermission(role.id, perm.id),
                                                     }">
                                                     <i data-lucide="check" class="w-4 h-4" x-show="hasPermission(role.id, perm.id)"></i>
                                                </div>
                                            </label>

                                        </td>
                                    </template>
                                </tr>
                            </template>

                        </React.Fragment>
                    </template>
                </tbody>
            </table>
        </div>
    </div>

    <div x-show="modals.confirm" class="fixed inset-0 z-[70] flex items-center justify-center bg-brand-secondary/80 backdrop-blur-sm p-4" x-cloak>
        <div class="card w-full max-w-lg p-0 shadow-2xl border-semantic-warning" @click.away="cancelAction()">
            <div class="p-5 border-b border-border-default bg-bg-tertiary flex items-center gap-4 rounded-t-xl">
                <div class="w-12 h-12 rounded-full bg-semantic-warning-bg text-semantic-warning flex items-center justify-center shrink-0">
                    <i data-lucide="alert-triangle" class="w-6 h-6"></i>
                </div>
                <div>
                    <h3 class="text-h4 font-bold text-text-primary">Confirm Access Modification</h3>
                    <p class="text-[10px] text-semantic-warning mt-1 uppercase tracking-wider font-bold">Immutable Audit Entry Required</p>
                </div>
            </div>
            
            <form @submit.prevent="executeAction">
                <div class="p-6 space-y-6">
                    <div class="bg-semantic-info-bg border border-semantic-info/30 rounded-xl p-5">
                        <h4 class="text-caption font-bold text-semantic-info uppercase tracking-wide mb-2 flex items-center gap-2">
                            <i data-lucide="users" class="w-4 h-4"></i> Impact Preview
                        </h4>
                        <p class="text-body-sm text-text-primary">
                            This change instantly affects <strong class="text-brand-primary" x-text="pendingAction?.usersAffected"></strong> active users assigned to the <strong x-text="pendingAction?.roleName"></strong> role.
                        </p>
                        <div class="mt-3 p-3 bg-bg-primary border border-border-strong rounded-lg">
                            <p class="text-caption font-mono text-text-primary" x-text="pendingAction?.description"></p>
                        </div>
                    </div>

                    <div class="form-group mb-0">
                        <label class="form-label">Action Justification</label>
                        <textarea x-model="pendingAction.justification" required rows="3" class="form-input w-full text-body-sm rounded-xl" placeholder="Mandatory reason for modifying access rights..."></textarea>
                    </div>
                </div>
                
                <div class="p-5 border-t border-border-default flex flex-col sm:flex-row justify-end gap-3 rounded-b-xl bg-bg-tertiary">
                    <button type="button" @click="cancelAction()" class="btn btn-tertiary w-full sm:w-auto order-2 sm:order-1 px-6">Cancel</button>
                    <button type="submit" class="btn btn-primary bg-semantic-warning border-none hover:bg-orange-500 text-white shadow-lg w-full sm:w-auto order-1 sm:order-2 px-6" :disabled="!pendingAction.justification">Confirm & Execute</button>
                </div>
            </form>
        </div>
    </div>

</div>

@push('scripts')
<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('accessMatrix', () => ({
        isLoading: true,
        searchQuery: '',
        toast: { show: false, message: '', type: 'success' },
        modals: { confirm: false, compare: false },
        
        roles: [],
        modules: ['Finance Operations', 'Business Management', 'KYC Operations', 'System Controls'],
        permissions: [],
        matrix: {},       
        
        pendingAction: { roleId: null, roleName: null, type: '', description: '', justification: '', usersAffected: 0, payload: null },
        compare: { roleA: 1, roleB: 2 },

        init() {
            this.fetchData();
        },

        get filteredModules() {
            let mods = this.modules;
            if(this.searchQuery) {
                const q = this.searchQuery.toLowerCase();
                mods = mods.filter(m => m.toLowerCase().includes(q) || this.permissions.some(p => p.module === m && p.name.toLowerCase().includes(q)));
            }
            return mods;
        },

        async fetchData() {
            this.isLoading = true;
            await new Promise(r => setTimeout(r, 600)); // Simulate API Fetch
            
            this.roles = [
                { id: 1, name: 'Super Admin', isSystem: true, usersAffected: 2 },
                { id: 2, name: 'Finance Admin', isSystem: false, usersAffected: 8 },
                { id: 3, name: 'Support Manager', isSystem: false, usersAffected: 15 },
                { id: 4, name: 'Compliance Officer', isSystem: false, usersAffected: 4 },
            ];

            this.permissions = [
                { id: 101, name: 'refund_approve_partial', module: 'Finance Operations', description: 'Approve refunds under predefined threshold' },
                { id: 102, name: 'refund_approve_full', module: 'Finance Operations', description: 'Override and approve any magnitude refund' },
                { id: 103, name: 'payout_release', module: 'Finance Operations', description: 'Execute business settlement to bank' },
                { id: 201, name: 'business_suspend', module: 'Business Management', description: 'Suspend business account and operations' },
                { id: 202, name: 'business_view_all', module: 'Business Management', description: 'View full registry and profile data' },
                { id: 301, name: 'kyc_document_approve', module: 'KYC Operations', description: 'Review and approve KYC identification files' },
                { id: 401, name: 'sys_kill_switch', module: 'System Controls', description: 'Trigger emergency stop on network' },
            ];

            // Initial mapping
            this.matrix = {
                1: [101, 102, 103, 201, 202, 301, 401], 
                2: [101, 102, 103, 202],                
                3: [202, 301],                          
                4: [202]                                
            };

            this.isLoading = false;
            this.$nextTick(() => lucide.createIcons());
        },

        showToast(msg, type = 'success') {
            this.toast = { show: true, message: msg, type: type };
            setTimeout(() => this.toast.show = false, 3000);
        },

        getPermissionsForModule(mod) {
            const q = this.searchQuery.toLowerCase();
            return this.permissions.filter(p => p.module === mod && (q === '' || p.name.toLowerCase().includes(q)));
        },

        hasPermission(roleId, permId) {
            return this.matrix[roleId]?.includes(permId);
        },

        hasAllModulePerms(roleId, modName) {
            const modPerms = this.getPermissionsForModule(modName);
            if(modPerms.length === 0) return false;
            return modPerms.every(p => this.hasPermission(roleId, p.id));
        },

        // --- Core Interactions ---
        requestToggle(role, perm, isChecked) {
            event.target.checked = !isChecked;  
            this.pendingAction = {
                roleId: role.id, roleName: role.name, usersAffected: role.usersAffected, justification: '', type: 'toggle',
                description: `${isChecked ? 'GRANT' : 'REVOKE'} capability [${perm.name}] for [${role.name}].`,
                payload: { permId: perm.id, state: isChecked }
            };
            this.modals.confirm = true;
        },

        bulkToggleModule(role, modName) {
            const isRevoking = this.hasAllModulePerms(role.id, modName);
            this.pendingAction = {
                roleId: role.id, roleName: role.name, usersAffected: role.usersAffected, justification: '', type: 'bulk',
                description: `${isRevoking ? 'REVOKE' : 'GRANT'} ALL capabilities in [${modName}] for [${role.name}].`,
                payload: { module: modName, state: !isRevoking }
            };
            this.modals.confirm = true;
        },

        cancelAction() {
            this.modals.confirm = false;
            this.pendingAction = { roleId: null, roleName: null, type: '', description: '', justification: '', usersAffected: 0, payload: null };
        },

        executeAction() {
            const { roleId, type, payload } = this.pendingAction;
            if(!this.matrix[roleId]) this.matrix[roleId] = [];

            if(type === 'toggle') {
                if(payload.state) {
                    if(!this.matrix[roleId].includes(payload.permId)) this.matrix[roleId].push(payload.permId);
                } else {
                    this.matrix[roleId] = this.matrix[roleId].filter(id => id !== payload.permId);
                }
            } else if (type === 'bulk') {
                const modPerms = this.getPermissionsForModule(payload.module).map(p => p.id);
                if (payload.state) {
                    modPerms.forEach(pid => { if(!this.matrix[roleId].includes(pid)) this.matrix[roleId].push(pid); });
                } else {
                    this.matrix[roleId] = this.matrix[roleId].filter(id => !modPerms.includes(id));
                }
            }

            this.showToast('Access policy updated and recorded in audit ledger.');
            this.cancelAction();
        },

        exportMatrix() { alert('Exporting Security Matrix to CSV...'); }
    }));
});
</script>
@endpush
@endsection