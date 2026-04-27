@extends('layouts.app')

@section('title', 'Role Management & Governance')

@section('content')
<div class="p-4 sm:p-6 lg:p-8 bg-bg-primary min-h-screen flex flex-col" x-data="roleManagement()">

    <div x-show="toast.show" x-transition class="fixed top-6 right-6 z-[100] bg-bg-secondary border-l-4 shadow-xl flex items-center gap-3 min-w-[300px] p-4 rounded-lg"
         :class="toast.type === 'error' ? 'border-semantic-error' : 'border-semantic-success'" style="display: none;" x-cloak>
        <i data-lucide="info" class="w-5 h-5" :class="toast.type === 'error' ? 'text-semantic-error' : 'text-semantic-success'"></i>
        <span x-text="toast.message" class="text-body-sm font-semibold text-text-primary"></span>
    </div>

    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 sm:mb-8 gap-4 shrink-0">
        <div>
            <h1 class="text-h3 sm:text-h2 font-bold tracking-tight text-text-primary flex items-center gap-3">
                <span class="p-2 bg-brand-primary/10 rounded-lg text-brand-primary border border-brand-primary/20">
                    <i data-lucide="users-2" class="w-5 h-5 sm:w-6 sm:h-6"></i>
                </span>
                Role Management
            </h1>
            <p class="text-text-secondary text-body-sm mt-2">Define organizational authority, lifecycles, and context-aware scopes.</p>
        </div>

        <button @click="openCreateModal()" class="btn btn-primary p-2 w-full md:w-auto flex items-center justify-center gap-2 shadow-lg">
            <i data-lucide="plus-circle" class="w-4 h-4"></i>
            <span>Create Custom Role</span>
        </button>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-4 gap-4 sm:gap-6 mb-6 sm:mb-8">
        
        <div class="card p-4 sm:p-5 flex items-center gap-4">
            <div class="w-12 h-12 rounded-full bg-brand-primary/10 text-brand-primary flex items-center justify-center shrink-0">
                <i data-lucide="shield" class="w-6 h-6"></i>
            </div>
            <div>
                <p class="text-caption font-bold text-text-tertiary uppercase tracking-wider">Total Roles</p>
                <h3 class="text-h2 font-bold text-text-primary" x-text="roles.length"></h3>
            </div>
        </div>

        <div class="card p-4 sm:p-5 flex items-center gap-4">
            <div class="w-12 h-12 rounded-full bg-semantic-error-bg text-semantic-error border border-semantic-error/20 flex items-center justify-center shrink-0">
                <i data-lucide="lock" class="w-6 h-6"></i>
            </div>
            <div>
                <p class="text-caption font-bold text-text-tertiary uppercase tracking-wider">System Protected</p>
                <h3 class="text-h2 font-bold text-text-primary" x-text="roles.filter(r => r.isSystem).length"></h3>
            </div>
        </div>

        <div class="lg:col-span-2 card p-0 border-semantic-warning/30 overflow-hidden flex flex-col justify-center relative group">
            <div class="absolute inset-0 bg-gradient-to-r from-semantic-warning/5 to-transparent z-0 pointer-events-none"></div>
            <div class="p-4 sm:p-5 relative z-10 flex items-center justify-between">
                <div class="flex items-start gap-3">
                    <i data-lucide="sparkles" class="w-5 h-5 text-semantic-warning shrink-0 mt-0.5"></i>
                    <div>
                        <h4 class="text-body-sm font-bold text-text-primary">AI Privilege Analysis</h4>
                        <p class="text-caption text-text-secondary mt-0.5">2 roles detected with over-privileged scopes. 14 unused permissions flagged across custom roles.</p>
                    </div>
                </div>
                <button class="btn btn-sm btn-secondary text-semantic-warning border-semantic-warning/30 bg-bg-primary hover:bg-semantic-warning hover:text-white whitespace-nowrap">View Recommendations</button>
            </div>
        </div>

    </div>

    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-4 gap-4">
        <h2 class="text-h4 font-bold text-text-primary">Role Directory</h2>
        <div class="relative w-full sm:w-64">
            <i data-lucide="search" class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-text-tertiary"></i>
            <input type="text" x-model="search" placeholder="Search roles..." class="form-input w-full pl-9 h-10 bg-bg-secondary text-body-sm">
        </div>
    </div>

    <div x-show="isLoading" class="py-20 text-center text-text-tertiary">
        <i data-lucide="loader-2" class="w-8 h-8 animate-spin mx-auto mb-3 opacity-50"></i>
        <p class="text-body font-medium">Loading Role Directory...</p>
    </div>

    <div x-show="!isLoading" class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-5 sm:gap-6" x-cloak>
        <template x-for="role in filteredRoles" :key="role.id">
            <div class="card p-5 flex flex-col relative group transition-colors" :class="!role.isActive ? 'opacity-75 border-dashed' : 'hover:border-border-strong'">
                
                <div x-show="!role.isActive" class="absolute inset-0 bg-bg-primary/50 backdrop-blur-[1px] z-10 rounded-xl pointer-events-none"></div>

                <div class="flex justify-between items-start mb-4 relative z-20">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-lg flex items-center justify-center shrink-0 border"
                             :class="role.isImmutable ? 'bg-semantic-error-bg text-semantic-error border-semantic-error/20' : (role.isSystem ? 'bg-brand-primary/10 text-brand-primary border-brand-primary/20' : 'bg-bg-secondary text-text-secondary border-border-default')">
                            <i :data-lucide="role.isImmutable ? 'shield-alert' : 'users'" class="w-5 h-5"></i>
                        </div>
                        <div>
                            <h3 class="text-body font-bold text-text-primary flex items-center gap-2" :class="!role.isActive && 'line-through'">
                                <span x-text="role.name"></span>
                                <i x-show="role.aiFlag" data-lucide="alert-triangle" class="w-3.5 h-3.5 text-semantic-warning cursor-help" title="AI Alert: Over-privileged scope detected"></i>
                            </h3>
                            <span class="inline-block mt-1 px-1.5 py-0.5 rounded text-[9px] font-bold uppercase tracking-wider border"
                                  :class="role.isSystem ? 'bg-bg-tertiary text-text-tertiary border-border-strong' : 'bg-semantic-info-bg text-semantic-info border-semantic-info/20'"
                                  x-text="role.isSystem ? 'System Protected' : 'Custom Defined'"></span>
                        </div>
                    </div>
                </div>

                <p class="text-caption text-text-secondary mb-5 flex-grow" x-text="role.description"></p>

                <div class="space-y-2 mb-5 relative z-20">
                    <div class="flex flex-wrap gap-1.5">
                        <span class="px-2 py-0.5 rounded bg-bg-tertiary border border-border-default text-text-primary text-[10px] flex items-center gap-1">
                            <i data-lucide="layers" class="w-3 h-3 text-text-tertiary"></i> <span x-text="role.scope.module"></span>
                        </span>
                        <span class="px-2 py-0.5 rounded bg-bg-tertiary border border-border-default text-text-primary text-[10px] flex items-center gap-1">
                            <i data-lucide="globe" class="w-3 h-3 text-text-tertiary"></i> <span x-text="role.scope.region"></span>
                        </span>
                        <span class="px-2 py-0.5 rounded bg-bg-tertiary border border-border-default text-text-primary text-[10px] flex items-center gap-1">
                            <i data-lucide="clock" class="w-3 h-3 text-text-tertiary"></i> <span x-text="role.scope.time"></span>
                        </span>
                    </div>
                </div>

                <div class="pt-4 border-t border-border-default flex items-center justify-between mt-auto relative z-20">
                    <div class="flex flex-col">
                        <span class="text-[10px] text-text-tertiary uppercase font-bold tracking-wider mb-0.5">Permissions</span>
                        <span class="text-body-sm font-bold text-text-primary font-mono" x-text="role.permissionsCount + ' Active'"></span>
                    </div>

                    <div class="flex items-center gap-1 bg-bg-secondary p-1 rounded-md border border-border-default">
                        
                        <button @click="cloneRole(role)" class="p-1.5 text-text-tertiary hover:text-brand-primary hover:bg-bg-tertiary rounded transition-colors" title="Clone Role">
                            <i data-lucide="copy" class="w-4 h-4"></i>
                        </button>

                        <button @click="openEditModal(role)" :disabled="role.isImmutable" class="p-1.5 text-text-tertiary hover:text-brand-primary hover:bg-bg-tertiary rounded transition-colors disabled:opacity-30 disabled:cursor-not-allowed" title="Edit Metadata">
                            <i data-lucide="edit-2" class="w-4 h-4"></i>
                        </button>
                        
                        <button @click="toggleRoleStatus(role.id)" :disabled="role.isImmutable" class="p-1.5 text-text-tertiary hover:bg-bg-tertiary rounded transition-colors disabled:opacity-30 disabled:cursor-not-allowed" :class="role.isActive ? 'hover:text-semantic-warning' : 'hover:text-semantic-success'" :title="role.isActive ? 'Deactivate (Revokes Sessions)' : 'Activate'">
                            <i :data-lucide="role.isActive ? 'power-off' : 'power'" class="w-4 h-4"></i>
                        </button>

                        <button @click="deleteRole(role.id)" :disabled="role.isSystem" class="p-1.5 text-text-tertiary hover:text-semantic-error hover:bg-bg-tertiary rounded transition-colors disabled:opacity-30 disabled:cursor-not-allowed" title="Delete Custom Role">
                            <i data-lucide="trash-2" class="w-4 h-4"></i>
                        </button>

                        <div x-show="role.isImmutable" class="p-1.5 text-semantic-error opacity-50" title="Immutable Root Role" x-cloak>
                            <i data-lucide="lock" class="w-4 h-4"></i>
                        </div>
                    </div>
                </div>

            </div>
        </template>
    </div>

    <div x-show="modals.form" class="fixed inset-0 z-50 flex items-center justify-center bg-brand-secondary/80 backdrop-blur-sm p-4" x-cloak>
        <div class="card w-full max-w-lg p-0 shadow-2xl flex flex-col max-h-[90vh]" @click.away="closeFormModal()">
            <div class="p-5 border-b border-border-default bg-bg-tertiary flex justify-between items-center rounded-t-lg shrink-0">
                <h3 class="text-h4 font-bold text-text-primary" x-text="form.id ? 'Edit Role Metadata' : 'Create New Role'"></h3>
                <button @click="closeFormModal()" class="text-text-tertiary hover:text-text-primary"><i data-lucide="x" class="w-5 h-5"></i></button>
            </div>
            
            <form @submit.prevent="submitRoleForm" class="flex flex-col flex-1 overflow-hidden">
                <div class="p-6 space-y-5 overflow-y-auto custom-scrollbar">
                    
                    <div class="bg-semantic-warning-bg border border-semantic-warning/30 p-3 rounded-lg flex items-start gap-2" x-show="form.isSystem && form.id">
                        <i data-lucide="shield-alert" class="w-4 h-4 text-semantic-warning shrink-0 mt-0.5"></i>
                        <p class="text-caption text-text-primary"><strong class="text-semantic-warning">System Protected Role:</strong> Core permissions cannot be reduced. You may only edit the description and add new permissions.</p>
                    </div>

                    <div class="form-group mb-0">
                        <label class="form-label">Role Name</label>
                        <input type="text" x-model="form.name" required placeholder="e.g. Regional Support Lead" class="form-input w-full text-body-sm" :disabled="form.isSystem && form.id" :class="(form.isSystem && form.id) && 'opacity-50 cursor-not-allowed'">
                    </div>

                    <div class="form-group mb-0">
                        <label class="form-label">Description</label>
                        <textarea x-model="form.description" required rows="2" class="form-input w-full text-body-sm" placeholder="Briefly describe the responsibilities of this role..."></textarea>
                    </div>

                    <div class="h-px bg-border-default w-full my-2"></div>
                    <h4 class="text-body-sm font-bold text-text-primary">Scope Dimensions & Context</h4>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div class="form-group mb-0">
                            <label class="form-label">Module Scope</label>
                            <select x-model="form.scope.module" class="form-input w-full text-caption">
                                <option value="Global">Global (All Modules)</option>
                                <option value="Finance & Monetization">Finance & Monetization</option>
                                <option value="Fraud & Risk">Fraud & Risk</option>
                                <option value="Support & Operations">Support & Operations</option>
                            </select>
                        </div>
                        
                        <div class="form-group mb-0">
                            <label class="form-label">Region Scope</label>
                            <select x-model="form.scope.region" class="form-input w-full text-caption">
                                <option value="Global">Global</option>
                                <option value="GCC Region">GCC Region</option>
                                <option value="UAE Only">UAE Only</option>
                            </select>
                        </div>

                        <div class="form-group mb-0">
                            <label class="form-label">Time Scope</label>
                            <select x-model="form.scope.time" class="form-input w-full text-caption">
                                <option value="Always">24/7 Access (Always)</option>
                                <option value="Business Hours (GST)">Business Hours (GST)</option>
                            </select>
                        </div>

                        <div class="form-group mb-0">
                            <label class="form-label">Action Level Limit</label>
                            <select x-model="form.scope.action" class="form-input w-full text-caption">
                                <option value="Read/Write/Execute">Full Control (R/W/X)</option>
                                <option value="Read/Write">Read & Write Only</option>
                                <option value="Read-Only">Read-Only View</option>
                            </select>
                        </div>
                    </div>

                </div>
                
                <div class="p-4 border-t border-border-default flex justify-end gap-3 rounded-b-lg bg-bg-tertiary shrink-0">
                    <button type="button" @click="closeFormModal()" class="btn btn-tertiary">Cancel</button>
                    <button type="submit" class="btn btn-primary" :disabled="isSubmitting">
                        <i data-lucide="loader-2" class="w-4 h-4 mr-2 animate-spin" x-show="isSubmitting" x-cloak></i>
                        <span x-text="isSubmitting ? 'Saving...' : (form.id ? 'Save Changes' : 'Create Role')"></span>
                    </button>
                </div>
            </form>
        </div>
    </div>

</div>

@push('scripts')
<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('roleManagement', () => ({
        isLoading: true,
        isSubmitting: false,
        search: '',
        
        toast: { show: false, message: '', type: 'success' },
        modals: { form: false },
        
        form: { 
            id: null, name: '', description: '', isSystem: false,
            scope: { module: 'Global', region: 'Global', time: 'Always', action: 'Read/Write/Execute' }
        },

        roles: [],

        init() {
            this.fetchRoles();
        },

        get filteredRoles() {
            if (!this.search) return this.roles;
            const q = this.search.toLowerCase();
            return this.roles.filter(r => r.name.toLowerCase().includes(q) || r.description.toLowerCase().includes(q));
        },

        async fetchRoles() {
            this.isLoading = true;
            
             await new Promise(r => setTimeout(r, 600)); 
            
            this.roles = [
                { id: 1, name: 'Super Admin', description: 'Unrestricted access. Founder-level platform control.', isSystem: true, isImmutable: true, isActive: true, aiFlag: false, permissionsCount: 142, scope: { module: 'Global', region: 'Global', time: 'Always', action: 'Read/Write/Execute' } },
                { id: 2, name: 'Platform Operations Admin', description: 'Manage businesses, KYC pipelines, and region toggles.', isSystem: true, isImmutable: false, isActive: true, aiFlag: false, permissionsCount: 84, scope: { module: 'Global', region: 'Global', time: 'Always', action: 'Read/Write/Execute' } },
                { id: 3, name: 'Finance Admin', description: 'Handle subscriptions, refunds, payouts, and ledgers.', isSystem: true, isImmutable: false, isActive: true, aiFlag: true, permissionsCount: 56, scope: { module: 'Finance & Monetization', region: 'Global', time: 'Business Hours (GST)', action: 'Read/Write/Execute' } },
                { id: 4, name: 'Fraud & Risk Admin', description: 'Monitor anomalies, manage risk scoring, and enforce blocks.', isSystem: true, isImmutable: false, isActive: true, aiFlag: false, permissionsCount: 48, scope: { module: 'Fraud & Risk', region: 'Global', time: 'Always', action: 'Read/Write' } },
                { id: 5, name: 'Support Manager', description: 'Manage ticket queues, SLAs, and support agent assignments.', isSystem: true, isImmutable: false, isActive: true, aiFlag: false, permissionsCount: 32, scope: { module: 'Support & Operations', region: 'Global', time: 'Business Hours (GST)', action: 'Read/Write' } },
                { id: 6, name: 'Support Agent', description: 'Frontline ticket handling and basic business profile viewing.', isSystem: true, isImmutable: false, isActive: true, aiFlag: false, permissionsCount: 14, scope: { module: 'Support & Operations', region: 'Global', time: 'Business Hours (GST)', action: 'Read/Write' } },
                { id: 7, name: 'Compliance Officer', description: 'Read-only access to audit logs, KYC histories, and financial ledgers.', isSystem: true, isImmutable: false, isActive: true, aiFlag: false, permissionsCount: 22, scope: { module: 'Global', region: 'Global', time: 'Always', action: 'Read-Only' } },
                { id: 8, name: 'Custom: UAE Onboarding Team', description: 'Assist with UAE-specific business onboarding and document verification.', isSystem: false, isImmutable: false, isActive: false, aiFlag: false, permissionsCount: 12, scope: { module: 'Global', region: 'UAE Only', time: 'Business Hours (GST)', action: 'Read/Write' } },
            ];

            this.isLoading = false;
            this.$nextTick(() => lucide.createIcons());
        },

        showToast(msg, type = 'success') {
            this.toast = { show: true, message: msg, type: type };
            setTimeout(() => this.toast.show = false, 3000);
        },

        openCreateModal() {
            this.form = { id: null, name: '', description: '', isSystem: false, scope: { module: 'Global', region: 'Global', time: 'Always', action: 'Read/Write/Execute' } };
            this.modals.form = true;
        },

        openEditModal(role) {
             this.form = JSON.parse(JSON.stringify(role));
            this.modals.form = true;
        },

        closeFormModal() {
            this.modals.form = false;
        },

        cloneRole(role) {
            const cloned = JSON.parse(JSON.stringify(role));
            cloned.id = null;
            cloned.name = cloned.name + ' (Copy)';
            cloned.isSystem = false;  
            cloned.isImmutable = false;
            this.form = cloned;
            this.modals.form = true;
        },

        submitRoleForm() {
            this.isSubmitting = true;
            setTimeout(() => {
                if (this.form.id) {
                    // Update
                    const idx = this.roles.findIndex(r => r.id === this.form.id);
                    if (idx !== -1) {
                         this.roles[idx].description = this.form.description;
                        this.roles[idx].scope = this.form.scope;
                        if(!this.roles[idx].isSystem) this.roles[idx].name = this.form.name;
                    }
                    this.showToast('Role updated successfully.');
                } else {
                    // Create
                    this.form.id = Date.now();
                    this.form.isActive = true;
                    this.form.permissionsCount = 0;
                    this.roles.push(JSON.parse(JSON.stringify(this.form)));
                    this.showToast('Custom role created.');
                }
                
                this.isSubmitting = false;
                this.closeFormModal();
                this.$nextTick(() => lucide.createIcons());
            }, 600);
        },

        toggleRoleStatus(id) {
            const role = this.roles.find(r => r.id === id);
            if(!role || role.isImmutable) return;

            if (role.isActive) {
                if(confirm(`Deactivate ${role.name}? This will auto-revoke ALL active sessions for users assigned to this role.`)) {
                    role.isActive = false;
                    this.showToast(`Role deactivated. Sessions revoked.`, 'error');
                }
            } else {
                role.isActive = true;
                this.showToast(`Role activated.`);
            }
        },

        deleteRole(id) {
            const role = this.roles.find(r => r.id === id);
            if(!role || role.isSystem) return;

            if(confirm(`Permanently soft-delete "${role.name}"? This cannot be undone.`)) {
                this.roles = this.roles.filter(r => r.id !== id);
                this.showToast(`Role deleted successfully.`);
            }
        }
    }));
});
</script>
@endpush
@endsection