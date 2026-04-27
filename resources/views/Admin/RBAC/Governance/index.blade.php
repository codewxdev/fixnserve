@extends('layouts.app')

@section('title', 'Audit & Governance')

@section('content')
<div class="p-4 sm:p-6 lg:p-8 bg-bg-primary min-h-screen flex flex-col w-full" x-data="auditGovernance()">

    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 sm:mb-8 gap-4 shrink-0">
        <div class="min-w-0 flex-1">
            <h1 class="text-h3 sm:text-h2 font-bold tracking-tight text-text-primary flex items-center gap-3">
                <span class="p-2 bg-brand-primary/10 rounded-lg text-brand-primary border border-brand-primary/20 shrink-0">
                    <i data-lucide="file-clock" class="w-5 h-5 sm:w-6 sm:h-6"></i>
                </span>
                Audit & Governance
            </h1>
            <p class="text-text-secondary text-body-sm mt-2">Immutable oversight of permission changes, role lifecycles, and privilege grants.</p>
        </div>

        <div class="flex flex-wrap items-center gap-3 w-full md:w-auto shrink-0">
            <button @click="fetchAuditLogs()" class="btn btn-secondary p-2 flex-1 md:flex-none flex items-center justify-center gap-2">
                <i data-lucide="refresh-cw" class="w-4 h-4" :class="isLoading ? 'animate-spin' : ''"></i> 
                <span class="whitespace-nowrap" x-text="isLoading ? 'Syncing...' : 'Refresh Ledger'"></span>
            </button>
            <button @click="exportAudit()" class="btn btn-primary p-2 flex-1 md:flex-none flex items-center justify-center gap-2 shadow-lg">
                <i data-lucide="download" class="w-4 h-4"></i> <span class="whitespace-nowrap">Export to CSV</span>
            </button>
        </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6 mb-6 sm:mb-8 shrink-0">
        <div class="card p-4 sm:p-5 flex items-center gap-4">
            <div class="w-10 h-10 rounded-full bg-semantic-info-bg text-semantic-info flex items-center justify-center shrink-0">
                <i data-lucide="activity" class="w-5 h-5"></i>
            </div>
            <div>
                <p class="text-caption font-bold text-text-tertiary uppercase tracking-wider">Total Events (7d)</p>
                <h3 class="text-h3 font-bold text-text-primary" x-text="auditLogs.length"></h3>
            </div>
        </div>

        <div class="card p-4 sm:p-5 flex items-center gap-4">
            <div class="w-10 h-10 rounded-full bg-semantic-warning-bg text-semantic-warning flex items-center justify-center shrink-0">
                <i data-lucide="shield-alert" class="w-5 h-5"></i>
            </div>
            <div>
                <p class="text-caption font-bold text-text-tertiary uppercase tracking-wider">Privilege Grants</p>
                <h3 class="text-h3 font-bold text-text-primary" x-text="auditLogs.filter(l => l.event_type === 'Temporary Privilege Grant').length"></h3>
            </div>
        </div>

        <div class="card p-4 sm:p-5 flex items-center gap-4">
            <div class="w-10 h-10 rounded-full bg-brand-primary/10 text-brand-primary flex items-center justify-center shrink-0">
                <i data-lucide="users" class="w-5 h-5"></i>
            </div>
            <div>
                <p class="text-caption font-bold text-text-tertiary uppercase tracking-wider">Role Modifications</p>
                <h3 class="text-h3 font-bold text-text-primary" x-text="auditLogs.filter(l => l.event_type.includes('Role')).length"></h3>
            </div>
        </div>

        <div class="card p-4 sm:p-5 flex items-center gap-4">
            <div class="w-10 h-10 rounded-full bg-semantic-error-bg text-semantic-error flex items-center justify-center shrink-0">
                <i data-lucide="lock" class="w-5 h-5"></i>
            </div>
            <div>
                <p class="text-caption font-bold text-text-tertiary uppercase tracking-wider">System Integrity</p>
                <h3 class="text-body-sm font-bold text-semantic-success mt-1">Immutable</h3>
            </div>
        </div>
    </div>

    <div class="card p-0 flex flex-col flex-1 min-h-[500px] border-border-default shadow-sm overflow-hidden">
        
        <div class="px-4 sm:px-5 py-3 sm:py-4 border-b border-border-default bg-bg-tertiary flex flex-col lg:flex-row justify-between items-start lg:items-center gap-4 shrink-0">
            <div class="flex flex-col sm:flex-row items-center gap-3 w-full lg:w-auto">
                <select x-model="filters.event" class="form-input w-full sm:w-56 h-10 text-body-sm bg-bg-secondary border-border-default">
                    <option value="All">All Event Types</option>
                    <option value="Role Creation">Role Creation</option>
                    <option value="Role Deactivation">Role Deactivation</option>
                    <option value="Permission Assignment">Permission Assignment</option>
                    <option value="Permission Removal">Permission Removal</option>
                    <option value="Bulk Permission Update">Bulk Permission Update</option>
                    <option value="Temporary Privilege Grant">Temporary Privilege Grant</option>
                </select>
                <select x-model="filters.actor" class="form-input w-full sm:w-48 h-10 text-body-sm bg-bg-secondary border-border-default">
                    <option value="All">All Actors</option>
                    <option value="System">System (Auto)</option>
                    </select>
            </div>

            <div class="relative w-full lg:w-72 shrink-0">
                <i data-lucide="search" class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-text-tertiary"></i>
                <input type="text" x-model="filters.search" placeholder="Search justification, target, or actor..." class="form-input w-full pl-9 h-10 text-body-sm bg-bg-primary">
            </div>
        </div>

        <div class="flex-1 overflow-auto custom-scrollbar relative bg-bg-primary w-full">
            
            <div x-show="isLoading" class="absolute inset-0 z-50 bg-bg-primary/90 backdrop-blur-sm flex flex-col items-center justify-center" x-cloak>
                <i data-lucide="loader-2" class="w-8 h-8 animate-spin text-brand-primary mb-3"></i>
                <span class="text-body-sm font-bold text-text-primary animate-pulse">Querying Ledger...</span>
            </div>

            <table class="w-full text-left border-collapse min-w-[1000px]">
                <thead class="text-caption uppercase text-text-secondary font-semibold bg-bg-secondary sticky top-0 z-30 shadow-[0_1px_0_0_rgb(var(--border-strong))]">
                    <tr>
                        <th class="px-5 py-3.5 border-r border-border-default">Timestamp</th>
                        <th class="px-5 py-3.5 border-r border-border-default">Actor Identity</th>
                        <th class="px-5 py-3.5 border-r border-border-default">Event Type & Target</th>
                        <th class="px-5 py-3.5 border-r border-border-default w-1/4">Mandatory Justification</th>
                        <th class="px-5 py-3.5 text-center">State Diff</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-border-default bg-bg-primary">
                    
                    <tr x-show="!isLoading && filteredLogs.length === 0" x-cloak>
                        <td colspan="5" class="px-6 py-16 text-center text-text-tertiary">
                            <i data-lucide="file-search" class="w-10 h-10 mx-auto mb-3 opacity-30"></i>
                            <p class="text-body-sm">No audit records match your query.</p>
                        </td>
                    </tr>

                    <template x-for="log in filteredLogs" :key="log.id">
                        <tr class="hover:bg-bg-tertiary/50 transition-colors group">
                            
                            <td class="px-5 py-4 border-r border-border-default align-top">
                                <div class="font-mono text-body-sm text-text-primary" x-text="log.date"></div>
                                <div class="font-mono text-caption text-text-secondary" x-text="log.time"></div>
                                <div class="text-[9px] text-text-tertiary mt-2 uppercase tracking-wider" x-text="'Log ID: ' + log.id"></div>
                            </td>

                            <td class="px-5 py-4 border-r border-border-default align-top">
                                <div class="flex items-center gap-2.5">
                                    <div class="w-7 h-7 rounded-full bg-brand-primary/10 text-brand-primary flex items-center justify-center font-bold text-[10px] shrink-0" 
                                         x-text="log.actor.name === 'System' ? 'S' : log.actor.name.charAt(0)"></div>
                                    <div class="min-w-0">
                                        <div class="font-bold text-text-primary text-body-sm truncate" x-text="log.actor.name"></div>
                                        <div class="text-[10px] text-text-secondary truncate mt-0.5" x-text="log.actor.email || 'Automated Process'"></div>
                                    </div>
                                </div>
                            </td>

                            <td class="px-5 py-4 border-r border-border-default align-top">
                                <div class="flex items-start gap-2">
                                    <div class="mt-0.5">
                                        <span class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded text-[10px] font-bold uppercase tracking-wider border"
                                              :class="getEventBadgeClass(log.event_type)">
                                            <i :data-lucide="getEventIcon(log.event_type)" class="w-3 h-3"></i> 
                                            <span x-text="log.event_type"></span>
                                        </span>
                                    </div>
                                </div>
                                <div class="mt-2.5 text-body-sm text-text-primary">
                                    <span class="text-text-secondary">Target:</span> 
                                    <span class="font-bold bg-bg-secondary border border-border-strong px-1.5 py-0.5 rounded" x-text="log.target"></span>
                                </div>
                                <div x-show="log.permission_affected" class="mt-1.5 text-caption font-mono text-text-tertiary truncate" x-text="log.permission_affected"></div>
                            </td>

                            <td class="px-5 py-4 border-r border-border-default align-top">
                                <div class="text-body-sm text-text-primary italic border-l-2 border-border-strong pl-3 py-0.5" x-text="log.justification"></div>
                                <div x-show="log.approval_chain" class="mt-3 flex items-center gap-1.5 text-[10px] font-bold text-semantic-success bg-semantic-success-bg border border-semantic-success/20 px-2 py-1 rounded w-fit">
                                    <i data-lucide="check-circle-2" class="w-3 h-3"></i> 
                                    <span x-text="'Approved by: ' + log.approval_chain"></span>
                                </div>
                            </td>

                            <td class="px-5 py-4 text-center align-middle">
                                <button @click="viewDiff(log)" class="btn btn-secondary btn-sm flex items-center justify-center gap-2 w-full mx-auto max-w-[120px] transition-colors" :class="log.has_diff ? 'hover:text-brand-primary hover:border-brand-primary' : 'opacity-50 cursor-not-allowed'" :disabled="!log.has_diff">
                                    <i data-lucide="file-diff" class="w-4 h-4"></i> Diff View
                                </button>
                            </td>

                        </tr>
                    </template>
                </tbody>
            </table>
        </div>
        
        <div class="p-4 border-t border-border-default bg-bg-tertiary flex items-center justify-between text-body-sm text-text-secondary">
            <span x-text="`Showing 1 to ${filteredLogs.length} of ${filteredLogs.length} entries`"></span>
            <div class="flex items-center gap-2">
                <button class="px-3 py-1.5 rounded border border-border-default bg-bg-primary opacity-50 cursor-not-allowed">Previous</button>
                <button class="px-3 py-1.5 rounded border border-border-default bg-bg-primary opacity-50 cursor-not-allowed">Next</button>
            </div>
        </div>
    </div>

    <div x-show="modals.diff" class="fixed inset-0 z-50 flex items-center justify-center bg-brand-secondary/80 backdrop-blur-sm p-4" x-cloak>
        <div class="card w-full max-w-4xl p-0 shadow-2xl flex flex-col max-h-[85vh]" @click.away="modals.diff = false">
            
            <div class="p-5 border-b border-border-default bg-bg-tertiary flex justify-between items-center rounded-t-lg shrink-0">
                <h3 class="text-h4 font-bold text-text-primary flex items-center gap-2"><i data-lucide="file-diff" class="w-5 h-5 text-brand-primary"></i> State Change Diff Viewer</h3>
                <button @click="modals.diff = false" class="text-text-tertiary hover:text-text-primary"><i data-lucide="x" class="w-5 h-5"></i></button>
            </div>
            
            <div class="p-5 flex flex-col md:flex-row items-start md:items-center justify-between gap-4 shrink-0 border-b border-border-default bg-bg-secondary">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-full bg-brand-primary/10 text-brand-primary flex items-center justify-center font-bold text-[10px]" x-text="selectedLog?.actor.name.charAt(0)"></div>
                    <div>
                        <span class="block text-[10px] uppercase font-bold text-text-tertiary tracking-wider">Actor</span>
                        <span class="font-bold text-body-sm text-text-primary" x-text="selectedLog?.actor.name"></span>
                    </div>
                </div>
                
                <div class="w-px h-8 bg-border-default hidden md:block"></div>
                
                <div>
                    <span class="block text-[10px] uppercase font-bold text-text-tertiary tracking-wider">Event</span>
                    <span class="font-bold text-body-sm text-text-primary" x-text="selectedLog?.event_type"></span>
                </div>

                <div class="w-px h-8 bg-border-default hidden md:block"></div>

                <div class="text-right">
                    <span class="block text-[10px] uppercase font-bold text-text-tertiary tracking-wider">Timestamp</span>
                    <span class="font-mono text-body-sm text-text-primary" x-text="selectedLog?.date + ' ' + selectedLog?.time"></span>
                </div>
            </div>

            <div class="p-6 overflow-y-auto custom-scrollbar flex-1 bg-bg-primary">
                
                <div class="mb-6 p-4 rounded-lg bg-bg-tertiary border border-border-default">
                    <span class="block text-[10px] uppercase font-bold text-text-tertiary tracking-wider mb-1">Justification Provided</span>
                    <span class="text-body-sm text-text-primary italic" x-text="selectedLog?.justification"></span>
                </div>

                <h4 class="text-caption font-bold text-text-tertiary uppercase tracking-wider mb-3">Payload Diff</h4>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="rounded-lg border border-semantic-error/30 overflow-hidden flex flex-col h-full">
                        <div class="bg-semantic-error-bg px-4 py-2 border-b border-semantic-error/30 flex items-center gap-2">
                            <i data-lucide="minus-circle" class="w-4 h-4 text-semantic-error"></i>
                            <span class="text-xs font-bold text-semantic-error uppercase tracking-wider">Before State (Removed)</span>
                        </div>
                        <div class="p-4 bg-bg-secondary flex-1">
                            <pre class="text-[10px] sm:text-xs font-mono text-text-primary whitespace-pre-wrap" x-text="formatDiffPayload(selectedLog?.old_state)"></pre>
                        </div>
                    </div>

                    <div class="rounded-lg border border-semantic-success/30 overflow-hidden flex flex-col h-full">
                        <div class="bg-semantic-success-bg px-4 py-2 border-b border-semantic-success/30 flex items-center gap-2">
                            <i data-lucide="plus-circle" class="w-4 h-4 text-semantic-success"></i>
                            <span class="text-xs font-bold text-semantic-success uppercase tracking-wider">After State (Added)</span>
                        </div>
                        <div class="p-4 bg-bg-secondary flex-1">
                            <pre class="text-[10px] sm:text-xs font-mono text-text-primary whitespace-pre-wrap" x-text="formatDiffPayload(selectedLog?.new_state)"></pre>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

</div>

@push('scripts')
<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('auditGovernance', () => ({
        isLoading: true,
        modals: { diff: false },
        selectedLog: null,
        
        filters: { event: 'All', actor: 'All', search: '' },
        
        auditLogs: [],

        init() {
            this.fetchAuditLogs();
        },

        get filteredLogs() {
            let result = this.auditLogs;
            
            if (this.filters.event !== 'All') {
                result = result.filter(l => l.event_type === this.filters.event);
            }

            if (this.filters.actor !== 'All') {
                result = result.filter(l => l.actor.name === this.filters.actor);
            }
            
            if (this.filters.search) {
                const q = this.filters.search.toLowerCase();
                result = result.filter(l => 
                    l.target.toLowerCase().includes(q) || 
                    l.justification.toLowerCase().includes(q) ||
                    l.actor.name.toLowerCase().includes(q) ||
                    (l.permission_affected && l.permission_affected.toLowerCase().includes(q))
                );
            }
            
            return result;
        },

        async fetchAuditLogs() {
            this.isLoading = true;
            await new Promise(r => setTimeout(r, 800));  
            
            this.auditLogs = [
                { 
                    id: 'AL-9041', date: 'Oct 24, 2026', time: '14:32:01.442', 
                    actor: { name: 'Sarah Jenkins', email: 'sarah@sahorone.com' },
                    event_type: 'Permission Assignment', target: 'Role: Finance Admin', permission_affected: '+ refund_approve_full',
                    justification: 'Updating finance role to handle full refunds per new policy.', approval_chain: null, has_diff: true,
                    old_state: { permissions: ['refund_approve_partial', 'payout_release'] },
                    new_state: { permissions: ['refund_approve_partial', 'refund_approve_full', 'payout_release'] }
                },
                { 
                    id: 'AL-9040', date: 'Oct 24, 2026', time: '11:15:22.010', 
                    actor: { name: 'Tariq Al Fasi', email: 'tariq@sahorone.com' },
                    event_type: 'Temporary Privilege Grant', target: 'User: Tariq Al Fasi', permission_affected: 'Scope: Super Admin (60m)',
                    justification: 'Investigating critical deployment failure on production server.', approval_chain: 'Sarah Jenkins', has_diff: true,
                    old_state: { roles: ['Platform Ops'] },
                    new_state: { roles: ['Platform Ops', 'Super Admin (JIT Exp: 12:15)'] }
                },
                { 
                    id: 'AL-9039', date: 'Oct 23, 2026', time: '09:00:00.000', 
                    actor: { name: 'System', email: null },
                    event_type: 'Role Deactivation', target: 'Role: Custom UAE Onboarding', permission_affected: 'REVOKED ALL',
                    justification: 'JIT Elevation expired automatically.', approval_chain: null, has_diff: true,
                    old_state: { is_active: true },
                    new_state: { is_active: false }
                },
                { 
                    id: 'AL-9038', date: 'Oct 22, 2026', time: '16:45:11.901', 
                    actor: { name: 'John Doe', email: 'john@sahorone.com' },
                    event_type: 'Bulk Permission Update', target: 'Module: Fraud & Risk', permission_affected: 'Granted to: Support Manager',
                    justification: 'Support managers need read access to risk scores for ticket context.', approval_chain: null, has_diff: true,
                    old_state: { 'Support Manager': { 'Fraud & Risk': 'disabled' } },
                    new_state: { 'Support Manager': { 'Fraud & Risk': 'read_only' } }
                }
            ];

            this.isLoading = false;
            this.$nextTick(() => lucide.createIcons());
        },

        viewDiff(log) {
            this.selectedLog = log;
            this.modals.diff = true;
            this.$nextTick(() => lucide.createIcons());
        },

        formatDiffPayload(data) {
            if (!data) return "No state data available.";
            return JSON.stringify(data, null, 2);
        },

        exportAudit() {
            alert('Initiating secure CSV export of the Immutable Ledger...');
        },

        // --- UI Helpers ---
        getEventBadgeClass(type) {
            if(type.includes('Assignment') || type.includes('Creation') || type.includes('Grant')) return 'bg-semantic-success-bg text-semantic-success border-semantic-success/20';
            if(type.includes('Removal') || type.includes('Deactivation')) return 'bg-semantic-error-bg text-semantic-error border-semantic-error/20';
            if(type.includes('Bulk')) return 'bg-semantic-warning-bg text-semantic-warning border-semantic-warning/20';
            return 'bg-semantic-info-bg text-semantic-info border-semantic-info/20';
        },

        getEventIcon(type) {
            if(type.includes('Assignment') || type.includes('Creation')) return 'plus-circle';
            if(type.includes('Removal') || type.includes('Deactivation')) return 'minus-circle';
            if(type.includes('Grant')) return 'unlock';
            if(type.includes('Bulk')) return 'layers';
            return 'file-text';
        }
    }));
});
</script>
@endpush
@endsection