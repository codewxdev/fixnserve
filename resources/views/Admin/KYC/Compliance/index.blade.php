@extends('layouts.app')

@section('title', 'KYC Compliance & Governance')

@section('content')
<div class="p-4 sm:p-6 lg:p-8 bg-bg-primary min-h-screen flex flex-col w-full" x-data="kycGovernance()">

    <div x-show="toast.show" x-transition class="fixed top-6 right-6 z-[100] bg-bg-secondary border-l-4 shadow-xl flex items-center gap-3 min-w-[300px] p-4 rounded-lg"
         :class="toast.type === 'error' ? 'border-semantic-error' : 'border-semantic-success'" style="display: none;" x-cloak>
        <i data-lucide="info" class="w-5 h-5" :class="toast.type === 'error' ? 'text-semantic-error' : 'text-semantic-success'"></i>
        <span x-text="toast.message" class="text-body-sm font-semibold text-text-primary"></span>
    </div>

    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 sm:mb-8 gap-4 shrink-0">
        <div class="min-w-0 flex-1">
            <h1 class="text-h3 sm:text-h2 font-bold tracking-tight text-text-primary flex items-center gap-3">
                <span class="p-2 bg-brand-primary/10 rounded-lg text-brand-primary border border-brand-primary/20 shrink-0">
                    <i data-lucide="scale" class="w-5 h-5 sm:w-6 sm:h-6"></i>
                </span>
                Compliance & Governance
            </h1>
            <p class="text-text-secondary text-body-sm mt-2">Enforce business compliance, manage re-verification schedules, and audit KYC decisions.</p>
        </div>

        <div class="flex flex-wrap items-center gap-3 w-full md:w-auto shrink-0">
            <button @click="exportAuditLedger()" class="btn btn-secondary p-2 flex-1 md:flex-none flex items-center justify-center gap-2">
                <i data-lucide="download" class="w-4 h-4"></i> <span class="whitespace-nowrap">Export Ledger</span>
            </button>
            <button @click="runComplianceSync()" class="btn btn-primary p-2 flex-1 md:flex-none flex items-center justify-center gap-2 shadow-lg">
                <i data-lucide="shield-check" class="w-4 h-4" :class="isSyncing ? 'animate-pulse' : ''"></i> 
                <span class="whitespace-nowrap" x-text="isSyncing ? 'Syncing...' : 'Run Compliance Sync'"></span>
            </button>
        </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6 mb-6 sm:mb-8 shrink-0">
        
        <div class="card p-4 sm:p-5 flex items-center gap-4">
            <div class="w-12 h-12 rounded-full bg-semantic-success-bg text-semantic-success border border-semantic-success/20 flex items-center justify-center shrink-0">
                <i data-lucide="shield-check" class="w-6 h-6"></i>
            </div>
            <div>
                <p class="text-caption font-bold text-text-tertiary uppercase tracking-wider">Fully Compliant</p>
                <h3 class="text-h2 font-bold text-text-primary" x-text="roster.filter(b => b.status === 'Compliant').length"></h3>
            </div>
        </div>

        <div class="card p-4 sm:p-5 flex items-center gap-4 border-semantic-warning/30 bg-semantic-warning-bg/10">
            <div class="w-12 h-12 rounded-full bg-semantic-warning/20 text-semantic-warning flex items-center justify-center shrink-0">
                <i data-lucide="calendar-clock" class="w-6 h-6"></i>
            </div>
            <div>
                <p class="text-caption font-bold text-semantic-warning uppercase tracking-wider">Upcoming Renewals</p>
                <h3 class="text-h2 font-bold text-text-primary" x-text="roster.filter(b => b.status === 'Renewal Due').length"></h3>
            </div>
        </div>

        <div class="card p-4 sm:p-5 flex items-center gap-4 border-semantic-info/30 bg-semantic-info-bg/10">
            <div class="w-12 h-12 rounded-full bg-semantic-info/20 text-semantic-info flex items-center justify-center shrink-0">
                <i data-lucide="alert-circle" class="w-6 h-6"></i>
            </div>
            <div>
                <p class="text-caption font-bold text-semantic-info uppercase tracking-wider">Escalated Cases</p>
                <h3 class="text-h2 font-bold text-text-primary" x-text="roster.filter(b => b.escalated).length"></h3>
            </div>
        </div>

        <div class="card p-4 sm:p-5 flex items-center gap-4 border-semantic-error/30 bg-semantic-error-bg/10">
            <div class="w-12 h-12 rounded-full bg-semantic-error/20 text-semantic-error flex items-center justify-center shrink-0">
                <i data-lucide="lock" class="w-6 h-6"></i>
            </div>
            <div>
                <p class="text-caption font-bold text-semantic-error uppercase tracking-wider">Locked Entities</p>
                <h3 class="text-h2 font-bold text-text-primary" x-text="roster.filter(b => b.status === 'Locked').length"></h3>
            </div>
        </div>

    </div>

    <div class="flex border-b border-border-default mb-6 overflow-x-auto custom-scrollbar w-full shrink-0">
        <button @click="activeTab = 'roster'" :class="activeTab === 'roster' ? 'border-brand-primary text-brand-primary' : 'border-transparent text-text-secondary hover:text-text-primary hover:border-border-strong'" class="pb-3 px-5 text-body-sm font-bold uppercase tracking-wider border-b-2 transition-colors whitespace-nowrap flex items-center gap-2">
            <i data-lucide="building" class="w-4 h-4"></i> Compliance Roster
        </button>
        <button @click="activeTab = 'audit'" :class="activeTab === 'audit' ? 'border-semantic-warning text-semantic-warning' : 'border-transparent text-text-secondary hover:text-text-primary hover:border-border-strong'" class="pb-3 px-5 text-body-sm font-bold uppercase tracking-wider border-b-2 transition-colors whitespace-nowrap flex items-center gap-2">
            <i data-lucide="file-text" class="w-4 h-4"></i> Immutable KYC Audit
        </button>
    </div>

    <div x-show="activeTab === 'roster'" class="flex-1 flex flex-col min-h-[500px]" x-transition.opacity>
        
        <div class="card p-0 flex flex-col h-full border-border-default shadow-sm overflow-hidden relative">
            
            <div class="px-5 py-4 border-b border-border-default bg-bg-tertiary flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 shrink-0">
                <div class="flex items-center gap-3 w-full sm:w-auto">
                    <select x-model="rosterFilters.status" class="form-input h-9 text-body-sm bg-bg-primary border-border-default w-full sm:w-auto">
                        <option value="All">All Statuses</option>
                        <option value="Compliant">Compliant</option>
                        <option value="Renewal Due">Renewal Due (<30d)</option>
                        <option value="Non-Compliant">Non-Compliant</option>
                        <option value="Locked">Locked / Suspended</option>
                    </select>
                </div>
                <div class="relative w-full sm:w-72 shrink-0">
                    <i data-lucide="search" class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-text-tertiary"></i>
                    <input type="text" x-model="rosterFilters.search" placeholder="Search business identity..." class="form-input w-full pl-9 h-9 text-body-sm bg-bg-primary">
                </div>
            </div>

            <div class="flex-1 overflow-auto custom-scrollbar bg-bg-primary">
                <table class="w-full text-left min-w-[1000px]">
                    <thead class="text-caption uppercase text-text-secondary font-semibold bg-bg-secondary sticky top-0 z-10 shadow-[0_1px_0_0_rgb(var(--border-strong))]">
                        <tr>
                            <th class="px-5 py-3 border-r border-border-default">Business Entity</th>
                            <th class="px-5 py-3 border-r border-border-default">Overall Status</th>
                            <th class="px-5 py-3 border-r border-border-default">Re-verification Schedule</th>
                            <th class="px-5 py-3 border-r border-border-default">Escalation Status</th>
                            <th class="px-5 py-3 text-right">Enforcement Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-border-default bg-bg-primary">
                        
                        <tr x-show="filteredRoster.length === 0" x-cloak>
                            <td colspan="5" class="px-6 py-12 text-center text-text-tertiary">
                                <i data-lucide="shield-check" class="w-8 h-8 mx-auto mb-3 opacity-30"></i>
                                <p class="text-body-sm">No businesses match your compliance filters.</p>
                            </td>
                        </tr>

                        <template x-for="biz in filteredRoster" :key="biz.id">
                            <tr class="hover:bg-bg-secondary transition-colors group">
                                
                                <td class="px-5 py-4 border-r border-border-default align-top">
                                    <div class="font-bold text-text-primary text-body-sm truncate" x-text="biz.name"></div>
                                    <div class="text-[10px] text-text-secondary mt-0.5 font-mono" x-text="'ID: ' + biz.id"></div>
                                </td>

                                <td class="px-5 py-4 border-r border-border-default align-top">
                                    <span class="inline-flex items-center gap-1.5 px-2 py-1 rounded text-[10px] font-bold uppercase tracking-wider border w-fit"
                                          :class="getStatusBadgeClass(biz.status)">
                                        <i :data-lucide="getStatusIcon(biz.status)" class="w-3 h-3"></i> <span x-text="biz.status"></span>
                                    </span>
                                </td>

                                <td class="px-5 py-4 border-r border-border-default align-top">
                                    <div class="flex items-center justify-between gap-4">
                                        <div>
                                            <p class="text-[10px] text-text-secondary uppercase font-bold tracking-wider mb-1">Trade License Expiry</p>
                                            <p class="text-body-sm text-text-primary font-mono" :class="isExpiringSoon(biz.expiry) ? 'text-semantic-error font-bold' : ''" x-text="biz.expiry"></p>
                                        </div>
                                        <div class="text-right">
                                            <p class="text-[10px] text-text-secondary uppercase font-bold tracking-wider mb-1">Next Annual Audit</p>
                                            <p class="text-body-sm text-text-primary font-mono" x-text="biz.nextReview"></p>
                                        </div>
                                    </div>
                                </td>

                                <td class="px-5 py-4 border-r border-border-default align-middle">
                                    <span x-show="biz.escalated" class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded text-[10px] font-bold bg-semantic-info-bg text-semantic-info border border-semantic-info/20 uppercase tracking-wider">
                                        <i data-lucide="alert-circle" class="w-3 h-3"></i> Under Review
                                    </span>
                                    <span x-show="!biz.escalated" class="text-text-tertiary text-xs italic">Normal</span>
                                </td>

                                <td class="px-5 py-4 text-right align-middle">
                                    <div class="flex justify-end gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                        <button @click="openOverrideModal(biz)" class="btn btn-sm btn-secondary text-brand-primary border-brand-primary/30 hover:bg-brand-primary hover:text-white text-[10px]">Override Status</button>
                                        
                                        <button x-show="!biz.escalated" @click="escalateBusiness(biz)" class="btn btn-sm btn-secondary text-semantic-info border-semantic-info/30 hover:bg-semantic-info hover:text-white text-[10px]">Escalate</button>
                                        
                                        <button x-show="biz.status !== 'Locked'" @click="openLockModal(biz)" class="btn btn-sm btn-destructive text-[10px]">Lock Entity</button>
                                        <button x-show="biz.status === 'Locked'" @click="unlockEntity(biz)" class="btn btn-sm btn-secondary text-semantic-success border-semantic-success/30 hover:bg-semantic-success hover:text-white text-[10px]">Unlock</button>
                                    </div>
                                </td>

                            </tr>
                        </template>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div x-show="activeTab === 'audit'" class="flex-1 flex flex-col min-h-[500px]" x-transition.opacity x-cloak>
        
        <div class="card p-0 flex flex-col h-full border-semantic-warning/30 shadow-lg overflow-hidden relative">
            
            <div class="px-5 py-4 border-b border-border-default bg-semantic-warning/5 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 shrink-0">
                <div class="flex items-center gap-3">
                    <i data-lucide="lock" class="w-4 h-4 text-text-tertiary" title="Write-only Ledger"></i>
                    <select x-model="auditFilters.action" class="form-input h-9 text-body-sm bg-bg-primary border-border-default w-full sm:w-auto">
                        <option value="All">All Actions</option>
                        <option value="Approved">Approved</option>
                        <option value="Rejected">Rejected</option>
                        <option value="Requested Re-upload">Requested Re-upload</option>
                        <option value="Manual Override">Manual Override</option>
                        <option value="Account Locked">Account Locked</option>
                    </select>
                </div>
                <div class="relative w-full sm:w-72 shrink-0">
                    <i data-lucide="search" class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-text-tertiary"></i>
                    <input type="text" x-model="auditFilters.search" placeholder="Search rationale or reviewer..." class="form-input w-full pl-9 h-9 text-body-sm bg-bg-primary">
                </div>
            </div>

            <div class="flex-1 overflow-auto custom-scrollbar bg-bg-primary">
                <table class="w-full text-left min-w-[1200px]">
                    <thead class="text-caption uppercase text-text-secondary font-semibold bg-bg-secondary sticky top-0 z-10 shadow-[0_1px_0_0_rgb(var(--border-strong))]">
                        <tr>
                            <th class="px-5 py-3 border-r border-border-default">Timestamp</th>
                            <th class="px-5 py-3 border-r border-border-default">Reviewer Identity</th>
                            <th class="px-5 py-3 border-r border-border-default">Action Taken</th>
                            <th class="px-5 py-3 border-r border-border-default">Target & Document</th>
                            <th class="px-5 py-3 border-r border-border-default w-1/4">Decision Rationale</th>
                            <th class="px-5 py-3 text-center">Evidence</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-border-default bg-bg-primary">
                        
                        <tr x-show="filteredAudit.length === 0" x-cloak>
                            <td colspan="6" class="px-6 py-12 text-center text-text-tertiary">
                                <p class="text-body-sm">No audit records found.</p>
                            </td>
                        </tr>

                        <template x-for="log in filteredAudit" :key="log.id">
                            <tr class="hover:bg-bg-tertiary/50 transition-colors group">
                                
                                <td class="px-5 py-4 border-r border-border-default align-top">
                                    <div class="font-mono text-body-sm text-text-primary" x-text="log.date"></div>
                                    <div class="font-mono text-caption text-text-secondary" x-text="log.time"></div>
                                </td>

                                <td class="px-5 py-4 border-r border-border-default align-top">
                                    <div class="flex items-center gap-2.5">
                                        <div class="w-7 h-7 rounded-full bg-brand-primary/10 text-brand-primary flex items-center justify-center font-bold text-[10px] shrink-0" x-text="log.reviewer.charAt(0)"></div>
                                        <div class="min-w-0">
                                            <div class="font-bold text-text-primary text-body-sm truncate" x-text="log.reviewer"></div>
                                            <div class="text-[9px] uppercase tracking-wider text-text-secondary truncate mt-0.5" x-text="log.role"></div>
                                        </div>
                                    </div>
                                </td>

                                <td class="px-5 py-4 border-r border-border-default align-top">
                                    <span class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded text-[10px] font-bold uppercase tracking-wider border w-fit"
                                          :class="getAuditActionClass(log.action)">
                                        <i :data-lucide="getAuditActionIcon(log.action)" class="w-3 h-3"></i> <span x-text="log.action"></span>
                                    </span>
                                </td>

                                <td class="px-5 py-4 border-r border-border-default align-top">
                                    <div class="text-body-sm font-bold text-text-primary truncate" x-text="log.targetBiz"></div>
                                    <div class="text-caption text-text-secondary mt-1 flex items-center gap-1.5">
                                        <i data-lucide="file-text" class="w-3 h-3"></i> <span x-text="log.document"></span>
                                    </div>
                                </td>

                                <td class="px-5 py-4 border-r border-border-default align-top">
                                    <div class="text-body-sm text-text-primary italic border-l-2 border-border-strong pl-3 py-0.5" x-text="log.rationale"></div>
                                </td>

                                <td class="px-5 py-4 text-center align-middle">
                                    <button x-show="log.hasSnapshot" @click="openEvidenceModal(log)" class="btn btn-secondary btn-sm flex items-center justify-center gap-2 w-full mx-auto max-w-[120px] transition-colors">
                                        <i data-lucide="camera" class="w-4 h-4"></i> Snapshot
                                    </button>
                                    <span x-show="!log.hasSnapshot" class="text-caption text-text-tertiary">No File</span>
                                </td>

                            </tr>
                        </template>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div x-show="modals.override" class="fixed inset-0 z-[60] flex items-center justify-center bg-brand-secondary/80 backdrop-blur-sm p-4" x-cloak>
        <div class="card w-full max-w-md p-0 shadow-2xl border-semantic-warning" @click.away="modals.override = false">
            <div class="p-5 border-b border-border-default bg-bg-tertiary flex items-center gap-3 rounded-t-xl">
                <div class="w-10 h-10 rounded-full bg-semantic-warning-bg text-semantic-warning flex items-center justify-center shrink-0">
                    <i data-lucide="alert-triangle" class="w-5 h-5"></i>
                </div>
                <div>
                    <h3 class="text-h4 font-bold text-text-primary">Manual Compliance Override</h3>
                    <p class="text-[10px] text-text-secondary mt-0.5 font-bold uppercase tracking-wider" x-text="pendingAction.biz?.name"></p>
                </div>
            </div>
            
            <form @submit.prevent="executeOverride">
                <div class="p-6 space-y-5">
                    <div class="form-group mb-0">
                        <label class="form-label">New Compliance Status</label>
                        <select x-model="pendingAction.targetStatus" required class="form-input w-full text-body-sm">
                            <option value="Compliant">Force Compliant</option>
                            <option value="Non-Compliant">Force Non-Compliant</option>
                            <option value="Renewal Due">Set Renewal Due</option>
                        </select>
                    </div>

                    <div class="form-group mb-0">
                        <label class="form-label">Audit Justification (Mandatory)</label>
                        <textarea x-model="pendingAction.justification" required rows="3" class="form-input w-full text-body-sm rounded-xl" placeholder="Detailed reason for manual override..."></textarea>
                    </div>
                </div>
                
                <div class="p-4 border-t border-border-default flex justify-end gap-3 rounded-b-xl bg-bg-tertiary">
                    <button type="button" @click="modals.override = false" class="btn btn-tertiary">Cancel</button>
                    <button type="submit" class="btn btn-primary bg-semantic-warning border-none hover:bg-orange-500 text-white shadow-lg" :disabled="!pendingAction.justification">Execute Override</button>
                </div>
            </form>
        </div>
    </div>

    <div x-show="modals.lock" class="fixed inset-0 z-[60] flex items-center justify-center bg-brand-secondary/80 backdrop-blur-sm p-4" x-cloak>
        <div class="card w-full max-w-md p-0 shadow-2xl border-semantic-error" @click.away="modals.lock = false">
            <div class="p-5 border-b border-border-default bg-bg-tertiary flex justify-between items-center rounded-t-xl">
                <h3 class="text-h4 font-bold text-semantic-error flex items-center gap-2"><i data-lucide="lock" class="w-5 h-5"></i> Enforce Entity Lock</h3>
                <button @click="modals.lock = false" class="text-text-tertiary hover:text-text-primary"><i data-lucide="x" class="w-5 h-5"></i></button>
            </div>
            
            <form @submit.prevent="executeLock">
                <div class="p-6 space-y-4">
                    <p class="text-body-sm text-text-primary">Locking <strong x-text="pendingAction.biz?.name"></strong> will immediately suspend all platform access and halt processing.</p>
                    
                    <div class="form-group mb-0 mt-4">
                        <label class="form-label">Lock Reason Code</label>
                        <select required class="form-input w-full text-body-sm">
                            <option value="kyc_expired">KYC Documents Expired</option>
                            <option value="fraud_suspicion">Fraud / Suspicious Activity</option>
                            <option value="regulatory_request">Regulatory Request</option>
                            <option value="other">Other Violation</option>
                        </select>
                    </div>

                    <div class="form-group mb-0">
                        <label class="form-label">Audit Rationale</label>
                        <textarea x-model="pendingAction.justification" required rows="3" class="form-input w-full text-body-sm rounded-xl" placeholder="Internal notes for compliance team..."></textarea>
                    </div>
                </div>
                
                <div class="p-4 border-t border-border-default flex justify-end gap-3 rounded-b-xl bg-bg-tertiary">
                    <button type="button" @click="modals.lock = false" class="btn btn-tertiary">Cancel</button>
                    <button type="submit" class="btn btn-destructive shadow-lg" :disabled="!pendingAction.justification">Enforce Lock</button>
                </div>
            </form>
        </div>
    </div>

    <div x-show="modals.evidence" class="fixed inset-0 z-[70] flex items-center justify-center bg-brand-secondary/90 backdrop-blur-sm p-4" x-cloak>
        <div class="card w-full max-w-4xl p-0 shadow-2xl flex flex-col h-[85vh]" @click.away="modals.evidence = false">
            
            <div class="p-5 border-b border-border-default bg-bg-tertiary flex justify-between items-center rounded-t-xl shrink-0">
                <div>
                    <h3 class="text-h4 font-bold text-text-primary flex items-center gap-2"><i data-lucide="camera" class="w-5 h-5 text-brand-primary"></i> Evidence Snapshot</h3>
                    <p class="text-[10px] font-mono text-text-secondary mt-0.5" x-text="'Log Reference: ' + selectedLog?.id"></p>
                </div>
                <button @click="modals.evidence = false" class="text-text-tertiary hover:text-text-primary"><i data-lucide="x" class="w-5 h-5"></i></button>
            </div>
            
            <div class="flex-1 p-6 bg-bg-secondary flex flex-col items-center justify-center relative overflow-hidden">
                <div class="absolute inset-0 pointer-events-none flex items-center justify-center opacity-5">
                    <span class="text-6xl font-black uppercase transform -rotate-45 whitespace-nowrap text-text-primary">AUDIT SNAPSHOT</span>
                </div>
                <i data-lucide="file-image" class="w-24 h-24 text-border-strong mb-4 relative z-10"></i>
                <p class="text-body font-mono text-text-secondary relative z-10">[ Historical S3 Artifact Rendered ]</p>
                <div class="mt-6 bg-bg-primary border border-border-default p-4 rounded-lg w-full max-w-md relative z-10 shadow-sm">
                    <p class="text-caption font-bold text-text-tertiary uppercase mb-2">Decision Context</p>
                    <div class="flex justify-between items-center mb-1">
                        <span class="text-body-sm font-bold text-text-primary" x-text="selectedLog?.action"></span>
                        <span class="text-body-sm text-text-secondary" x-text="selectedLog?.date"></span>
                    </div>
                    <p class="text-body-sm text-text-primary italic" x-text="'&quot;' + selectedLog?.rationale + '&quot;'"></p>
                </div>
            </div>
        </div>
    </div>

</div>

@push('scripts')
<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('kycGovernance', () => ({
        activeTab: 'roster', // 'roster' or 'audit'
        isSyncing: false,
        toast: { show: false, message: '', type: 'success' },
        
        modals: { override: false, lock: false, evidence: false },
        
        rosterFilters: { status: 'All', search: '' },
        auditFilters: { action: 'All', search: '' },

        roster: [],
        auditLogs: [],
        
        pendingAction: { biz: null, targetStatus: '', justification: '' },
        selectedLog: null,

        init() {
            this.fetchData();
        },

        get filteredRoster() {
            let result = this.roster;
            if (this.rosterFilters.status !== 'All') result = result.filter(b => b.status === this.rosterFilters.status);
            if (this.rosterFilters.search) {
                const q = this.rosterFilters.search.toLowerCase();
                result = result.filter(b => b.name.toLowerCase().includes(q) || b.id.toLowerCase().includes(q));
            }
            return result;
        },

        get filteredAudit() {
            let result = this.auditLogs;
            if (this.auditFilters.action !== 'All') result = result.filter(l => l.action === this.auditFilters.action);
            if (this.auditFilters.search) {
                const q = this.auditFilters.search.toLowerCase();
                result = result.filter(l => l.rationale.toLowerCase().includes(q) || l.reviewer.toLowerCase().includes(q) || l.targetBiz.toLowerCase().includes(q));
            }
            return result;
        },

        async fetchData() {
             this.roster = [
                { id: 'B-101', name: 'Elevate Digital', status: 'Compliant', expiry: '12-Oct-2027', nextReview: '12-Sep-2027', escalated: false },
                { id: 'B-102', name: 'Dubai Cool AC', status: 'Renewal Due', expiry: '05-Nov-2026', nextReview: '05-Oct-2026', escalated: false },
                { id: 'B-103', name: 'CleanSweep UAE', status: 'Non-Compliant', expiry: '01-Jan-2026', nextReview: 'Overdue', escalated: true },
                { id: 'B-104', name: 'Apex Legal', status: 'Locked', expiry: 'Unknown', nextReview: 'Halted', escalated: true },
            ];

            this.auditLogs = [
                { id: 'AL-771', date: 'Oct 24, 2026', time: '14:32:01', reviewer: 'Sarah Jenkins', role: 'Compliance Officer', action: 'Approved', targetBiz: 'Elevate Digital', document: 'Trade License', rationale: 'Verified against Chamber API.', hasSnapshot: true },
                { id: 'AL-772', date: 'Oct 24, 2026', time: '11:15:22', reviewer: 'Tariq Al Fasi', role: 'Platform Ops', action: 'Requested Re-upload', targetBiz: 'Dubai Cool AC', document: 'Owner Emirates ID', rationale: 'Image blurry. Cannot read ID number.', hasSnapshot: true },
                { id: 'AL-773', date: 'Oct 23, 2026', time: '09:00:00', reviewer: 'System Auto', role: 'Cron', action: 'Account Locked', targetBiz: 'CleanSweep UAE', document: 'All Files', rationale: 'Grace period for renewal expired.', hasSnapshot: false },
                { id: 'AL-774', date: 'Oct 22, 2026', time: '16:45:11', reviewer: 'John Doe', role: 'Super Admin', action: 'Manual Override', targetBiz: 'Nexus Marketing', document: 'Profile Status', rationale: 'Extending trial compliance period due to legal delays on their end.', hasSnapshot: false },
            ];

            this.$nextTick(() => lucide.createIcons());
        },

        showToast(msg, type = 'success') {
            this.toast = { show: true, message: msg, type: type };
            setTimeout(() => this.toast.show = false, 3000);
        },

        // --- Actions ---
        runComplianceSync() {
            this.isSyncing = true;
            setTimeout(() => {
                this.isSyncing = false;
                this.showToast('Compliance checks and scheduling synced successfully.');
            }, 1000);
        },

        exportAuditLedger() {
            alert('Initiating secure CSV export of Immutable KYC Ledger...');
        },

        escalateBusiness(biz) {
            if(confirm(`Escalate ${biz.name} for enhanced verification?`)) {
                biz.escalated = true;
                this.showToast('Entity escalated to senior compliance team.');
            }
        },

        unlockEntity(biz) {
            if(confirm(`Unlock platform access for ${biz.name}? Ensure compliance is met.`)) {
                biz.status = 'Non-Compliant'; // Moves out of locked
                biz.escalated = false;
                this.showToast('Entity unlocked.');
            }
        },

        // --- Modals ---
        openOverrideModal(biz) {
            this.pendingAction = { biz: biz, targetStatus: 'Compliant', justification: '' };
            this.modals.override = true;
        },

        executeOverride() {
            const { biz, targetStatus, justification } = this.pendingAction;
            biz.status = targetStatus;
            
            // Add to audit log
            this.addAuditLog('Manual Override', biz.name, 'Status Update', justification);
            
            this.modals.override = false;
            this.showToast('Manual override applied and audited.');
        },

        openLockModal(biz) {
            this.pendingAction = { biz: biz, targetStatus: 'Locked', justification: '' };
            this.modals.lock = true;
        },

        executeLock() {
            const { biz, justification } = this.pendingAction;
            biz.status = 'Locked';
            
            this.addAuditLog('Account Locked', biz.name, 'Enforcement Action', justification);
            
            this.modals.lock = false;
            this.showToast('Entity locked. Platform access suspended.', 'error');
        },

        openEvidenceModal(log) {
            this.selectedLog = log;
            this.modals.evidence = true;
        },

        // --- Helpers ---
        addAuditLog(action, target, doc, rationale) {
            this.auditLogs.unshift({
                id: 'AL-' + Math.floor(Math.random() * 10000),
                date: new Date().toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' }),
                time: new Date().toLocaleTimeString([], { hour: '2-digit', minute: '2-digit', second: '2-digit' }),
                reviewer: 'John Doe (You)',
                role: 'Super Admin',
                action: action,
                targetBiz: target,
                document: doc,
                rationale: rationale,
                hasSnapshot: false
            });
            this.$nextTick(() => lucide.createIcons());
        },

        isExpiringSoon(dateStr) {
            if(dateStr === 'Unknown' || dateStr === 'Overdue') return true;
            const exp = new Date(dateStr);
            const now = new Date();
            return ((exp - now) / (1000 * 60 * 60 * 24)) <= 30;
        },

        getStatusBadgeClass(status) {
            const map = {
                'Compliant': 'bg-semantic-success-bg text-semantic-success border-semantic-success/20',
                'Renewal Due': 'bg-semantic-warning-bg text-semantic-warning border-semantic-warning/20',
                'Non-Compliant': 'bg-bg-tertiary text-text-secondary border-border-strong',
                'Locked': 'bg-semantic-error-bg text-semantic-error border-semantic-error/30 shadow-sm'
            };
            return map[status] || 'bg-bg-primary text-text-primary border-border-default';
        },

        getStatusIcon(status) {
            if(status === 'Compliant') return 'shield-check';
            if(status === 'Renewal Due') return 'calendar-clock';
            if(status === 'Locked') return 'lock';
            return 'alert-circle';
        },

        getAuditActionClass(action) {
            if(action === 'Approved') return 'bg-semantic-success-bg text-semantic-success border-semantic-success/20';
            if(action === 'Rejected' || action.includes('Locked')) return 'bg-semantic-error-bg text-semantic-error border-semantic-error/20';
            if(action === 'Manual Override') return 'bg-purple-500/10 text-purple-500 border-purple-500/20';
            return 'bg-semantic-info-bg text-semantic-info border-semantic-info/20'; // Re-upload
        },

        getAuditActionIcon(action) {
            if(action === 'Approved') return 'check-circle-2';
            if(action === 'Rejected') return 'x-circle';
            if(action.includes('Locked')) return 'lock';
            if(action === 'Manual Override') return 'sliders';
            return 'refresh-ccw'; // Re-upload
        }
    }));
});
</script>
@endpush
@endsection