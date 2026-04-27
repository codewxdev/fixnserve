@extends('layouts.app')

@section('title', 'Privileged Access (JIT) & Approvals')

@section('content')
<div class="p-4 sm:p-6 lg:p-8 bg-bg-primary min-h-screen flex flex-col" x-data="privilegedGovernance()">

    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 sm:mb-8 gap-4 shrink-0">
        <div>
            <h1 class="text-h3 sm:text-h2 font-bold tracking-tight text-text-primary flex items-center gap-3">
                <span class="p-2 bg-brand-primary/10 rounded-lg text-brand-primary border border-brand-primary/20">
                    <i data-lucide="key" class="w-5 h-5 sm:w-6 sm:h-6"></i>
                </span>
                Privileged Access Governance
            </h1>
            <p class="text-text-secondary text-body-sm mt-2">Manage Just-In-Time (JIT) elevation and Four-Eyes dual approvals.</p>
        </div>

        <button @click="modals.requestJit = true" 
                class="btn btn-primary w-full p-2 md:w-auto flex items-center justify-center gap-2 shadow-lg">
            <i data-lucide="unlock" class="w-4 h-4"></i>
            <span>Request Elevation</span>
        </button>
    </div>

    <div class="grid grid-cols-1 xl:grid-cols-3 gap-6 sm:gap-8">

        <div class="xl:col-span-2 space-y-6 sm:space-y-8">

            <div class="card p-0 overflow-hidden flex flex-col">
                <div class="px-5 sm:px-6 py-4 border-b border-border-default bg-bg-tertiary flex justify-between items-center">
                    <h3 class="text-h4 font-bold text-text-primary flex items-center gap-2">
                        <i data-lucide="timer" class="w-5 h-5 text-brand-primary"></i> Active JIT Sessions
                    </h3>
                </div>

                <div class="overflow-x-auto custom-scrollbar">
                    <table class="w-full text-left min-w-[700px]">
                        <thead class="text-caption uppercase text-text-secondary font-semibold bg-bg-primary border-b border-border-strong">
                            <tr>
                                <th class="px-5 py-3">Identity</th>
                                <th class="px-5 py-3">Granted Scope</th>
                                <th class="px-5 py-3 w-1/3">Time Remaining (Auto-Revokes)</th>
                                <th class="px-5 py-3 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-border-default bg-bg-secondary">
                            
                            <tr x-show="isLoading">
                                <td colspan="4" class="px-6 py-8 text-center text-text-tertiary">
                                    <i data-lucide="loader-2" class="w-6 h-6 animate-spin mx-auto mb-2 opacity-50"></i>
                                    <p class="text-body-sm">Loading active sessions...</p>
                                </td>
                            </tr>

                            <tr x-show="!isLoading && activeElevations.length === 0" x-cloak>
                                <td colspan="4" class="px-6 py-8 text-center text-text-tertiary">
                                    <i data-lucide="shield-check" class="w-6 h-6 mx-auto mb-2 opacity-30"></i>
                                    No active elevated sessions.
                                </td>
                            </tr>

                            <template x-for="session in activeElevations" :key="session.id">
                                <tr class="hover:bg-bg-tertiary transition-colors group">
                                    <td class="px-5 py-4">
                                        <div class="font-bold text-text-primary text-body-sm" x-text="session.user"></div>
                                        <div class="text-caption text-text-secondary truncate mt-0.5" x-text="'Reason: ' + session.justification" :title="session.justification"></div>
                                    </td>
                                    <td class="px-5 py-4">
                                        <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-blue-500/10 text-blue-500 border border-blue-500/20 uppercase tracking-wider" x-text="session.role"></span>
                                    </td>
                                    <td class="px-5 py-4">
                                        <div class="flex items-center justify-between mb-1.5">
                                            <span class="text-[10px] font-bold flex items-center gap-1" :class="session.minsLeft < 15 ? 'text-semantic-error' : 'text-semantic-warning'">
                                                <i data-lucide="clock" class="w-3 h-3"></i> <span x-text="session.minsLeft + 'm left'"></span>
                                            </span>
                                            <span class="text-[10px] text-text-tertiary" x-text="'Max: ' + session.totalMins + 'm'"></span>
                                        </div>
                                        <div class="w-full bg-bg-muted rounded-full h-1.5 overflow-hidden">
                                            <div class="h-1.5 rounded-full transition-all duration-1000" 
                                                 :class="session.minsLeft < 15 ? 'bg-semantic-error' : 'bg-semantic-warning'" 
                                                 :style="`width: ${(session.minsLeft / session.totalMins) * 100}%`"></div>
                                        </div>
                                    </td>
                                    <td class="px-5 py-4 text-right">
                                        <button @click="terminateSession(session.id)" class="btn btn-sm btn-destructive text-xs py-1 opacity-0 group-hover:opacity-100 transition-opacity">Terminate Early</button>
                                    </td>
                                </tr>
                            </template>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="card p-0 overflow-hidden">
                
                <div class="flex border-b border-border-default bg-bg-tertiary px-2 pt-2">
                    <button @click="pipelineTab = 'dual'" :class="pipelineTab === 'dual' ? 'border-semantic-warning text-semantic-warning bg-bg-secondary rounded-t-md' : 'border-transparent text-text-secondary hover:text-text-primary'" class="px-5 py-3 text-body-sm font-bold uppercase tracking-wider border-b-2 transition-colors flex items-center gap-2">
                        Four-Eyes Approvals
                        <span class="px-1.5 py-0.5 rounded text-[9px] bg-semantic-warning/20 text-semantic-warning" x-text="dualApprovals.length"></span>
                    </button>
                    <button @click="pipelineTab = 'jit'" :class="pipelineTab === 'jit' ? 'border-brand-primary text-brand-primary bg-bg-secondary rounded-t-md' : 'border-transparent text-text-secondary hover:text-text-primary'" class="px-5 py-3 text-body-sm font-bold uppercase tracking-wider border-b-2 transition-colors flex items-center gap-2">
                        JIT Elevation Requests
                        <span class="px-1.5 py-0.5 rounded text-[9px] bg-brand-primary/20 text-brand-primary" x-text="jitRequests.length"></span>
                    </button>
                </div>

                <div class="p-5 sm:p-6 bg-bg-secondary min-h-[300px]">
                    
                    <div x-show="pipelineTab === 'dual'" class="space-y-4" x-cloak>
                        <div x-show="dualApprovals.length === 0" class="text-center py-8">
                            <i data-lucide="check-circle-2" class="w-8 h-8 text-semantic-success mx-auto mb-2 opacity-50"></i>
                            <p class="text-body-sm text-text-tertiary">All high-risk actions are cleared.</p>
                        </div>

                        <template x-for="req in dualApprovals" :key="req.id">
                            <div class="bg-bg-primary border border-border-default rounded-lg p-4 sm:p-5 flex flex-col md:flex-row gap-4 justify-between items-start md:items-center">
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center gap-2 mb-1.5">
                                        <span class="px-1.5 py-0.5 bg-semantic-error-bg text-semantic-error border border-semantic-error/20 text-[9px] font-bold rounded uppercase tracking-wider" x-text="req.category"></span>
                                        <span class="text-caption text-text-tertiary font-mono" x-text="'ACT-' + req.id"></span>
                                    </div>
                                    <h4 class="text-body-sm font-bold text-text-primary truncate" x-text="req.description"></h4>
                                    <p class="text-caption text-text-secondary mt-1">Requested by <strong class="text-text-primary" x-text="req.requester"></strong> • <span x-text="req.timeAgo"></span></p>
                                    
                                    <div class="flex items-center gap-2 mt-3">
                                        <div class="flex items-center gap-1.5 px-2 py-1 rounded bg-bg-tertiary border border-border-strong text-[10px] font-bold" :class="req.l1_signer ? 'text-semantic-success' : 'text-text-tertiary'">
                                            <i :data-lucide="req.l1_signer ? 'check-circle-2' : 'circle'" class="w-3 h-3"></i> 
                                            <span x-text="req.l1_signer ? req.l1_signer : 'L1 Signature Pending'"></span>
                                        </div>
                                        <i data-lucide="arrow-right" class="w-3 h-3 text-text-tertiary"></i>
                                        <div class="flex items-center gap-1.5 px-2 py-1 rounded bg-bg-tertiary border border-border-strong text-[10px] font-bold" :class="req.l2_signer ? 'text-semantic-success' : 'text-text-tertiary'">
                                            <i :data-lucide="req.l2_signer ? 'check-circle-2' : 'circle'" class="w-3 h-3"></i>
                                            <span x-text="req.l2_signer ? req.l2_signer : 'L2 Signature Pending'"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="w-full md:w-auto shrink-0 mt-2 md:mt-0">
                                    <button @click="openReviewModal(req)" class="btn btn-sm btn-primary w-full bg-semantic-warning border-none hover:bg-orange-500 text-white shadow-lg shadow-semantic-warning/20">Review & Sign</button>
                                </div>
                            </div>
                        </template>
                    </div>

                    <div x-show="pipelineTab === 'jit'" class="space-y-4" x-cloak>
                        <div x-show="jitRequests.length === 0" class="text-center py-8">
                            <i data-lucide="shield" class="w-8 h-8 text-text-tertiary mx-auto mb-2 opacity-50"></i>
                            <p class="text-body-sm text-text-tertiary">No JIT elevation requests pending.</p>
                        </div>

                        <template x-for="req in jitRequests" :key="req.id">
                            <div class="bg-bg-primary border border-border-default rounded-lg p-4 sm:p-5 flex flex-col md:flex-row gap-4 justify-between items-start md:items-center">
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center gap-3 mb-1">
                                        <h4 class="text-body-sm font-bold text-text-primary" x-text="req.requester"></h4>
                                        <span class="text-caption text-text-secondary">requests</span>
                                        <span class="px-1.5 py-0.5 bg-brand-primary/10 text-brand-primary border border-brand-primary/20 text-[9px] font-bold rounded uppercase tracking-wider" x-text="req.requestedRole"></span>
                                    </div>
                                    <p class="text-caption text-text-secondary mt-1">Duration: <strong class="text-text-primary" x-text="req.duration + ' Minutes'"></strong></p>
                                    <p class="text-caption text-text-secondary mt-1 italic break-words border-l-2 border-border-strong pl-2 py-0.5" x-text="'&quot;' + req.justification + '&quot;'"></p>
                                </div>
                                <div class="flex flex-row md:flex-col gap-2 w-full md:w-auto shrink-0">
                                    <button @click="approveJit(req.id)" class="btn btn-sm btn-secondary text-semantic-success border-semantic-success/30 hover:bg-semantic-success hover:text-white flex-1 md:flex-none justify-center">Approve</button>
                                    <button @click="denyJit(req.id)" class="btn btn-sm btn-destructive flex-1 md:flex-none justify-center">Deny</button>
                                </div>
                            </div>
                        </template>
                    </div>

                </div>
            </div>

        </div>

        <div class="space-y-6 sm:space-y-8">
            
            <div class="card p-0 overflow-hidden shadow-sm">
                <div class="px-5 py-4 border-b border-border-default bg-bg-tertiary">
                    <h3 class="text-body font-bold text-text-primary flex items-center gap-2">
                        <i data-lucide="settings-2" class="w-4 h-4 text-brand-primary"></i> Access Policies
                    </h3>
                </div>
                <div class="p-5 space-y-4 bg-bg-secondary">
                    <div class="flex items-center justify-between pb-3 border-b border-border-default">
                        <div>
                            <p class="text-body-sm font-bold text-text-primary">Default Elevation Limit</p>
                            <p class="text-caption text-text-secondary">Time-boxed auto-revoke</p>
                        </div>
                        <span class="text-caption font-bold bg-bg-primary border border-border-strong px-2 py-1 rounded text-text-primary font-mono">1 Hour</span>
                    </div>
                    <div class="flex items-center justify-between pb-3 border-b border-border-default">
                        <div>
                            <p class="text-body-sm font-bold text-text-primary">Elevation Extension</p>
                            <p class="text-caption text-text-secondary">Extend active session</p>
                        </div>
                        <span class="text-caption font-bold bg-semantic-error-bg border border-semantic-error/30 px-2 py-1 rounded text-semantic-error">Disabled</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-body-sm font-bold text-text-primary">Four-Eyes Scope</p>
                            <p class="text-[10px] text-text-secondary leading-tight mt-1">Payouts, Refunds > Threshold,<br>Kill Switches, Suspend Account.</p>
                        </div>
                        <span class="text-caption font-bold bg-semantic-warning-bg border border-semantic-warning/30 px-2 py-1 rounded text-semantic-warning">Active</span>
                    </div>
                </div>
            </div>

            <div class="card p-0 overflow-hidden border-brand-primary/30 shadow-lg">
                <div class="px-5 py-4 border-b border-border-default bg-brand-primary/5 flex justify-between items-center">
                    <h3 class="text-body font-bold text-brand-primary flex items-center gap-2">
                        <i data-lucide="file-text" class="w-4 h-4"></i> Immutable Audit
                    </h3>
                    <i data-lucide="lock" class="w-3.5 h-3.5 text-text-tertiary" title="Write-only Ledger"></i>
                </div>
                
                <div class="p-4 space-y-4 max-h-[350px] overflow-y-auto custom-scrollbar bg-bg-primary">
                    <template x-for="log in auditLogs" :key="log.id">
                        <div class="flex gap-3 items-start relative before:absolute before:inset-y-0 before:left-1 before:w-0.5 before:bg-border-default last:before:hidden">
                            <div class="w-2.5 h-2.5 rounded-full mt-1.5 relative z-10 outline outline-4 outline-bg-primary"
                                 :class="{
                                     'bg-semantic-success': log.type === 'executed' || log.type === 'approved',
                                     'bg-semantic-error': log.type === 'denied' || log.type === 'revoked',
                                     'bg-semantic-warning': log.type === 'signed',
                                     'bg-brand-primary': log.type === 'requested',
                                     'bg-text-tertiary': log.type === 'expired'
                                 }"></div>
                            <div class="flex-1 pb-4">
                                <div class="flex justify-between items-start mb-0.5">
                                    <p class="text-[10px] font-bold uppercase tracking-wider"
                                       :class="{
                                         'text-semantic-success': log.type === 'executed' || log.type === 'approved',
                                         'text-semantic-error': log.type === 'denied' || log.type === 'revoked',
                                         'text-semantic-warning': log.type === 'signed',
                                         'text-brand-primary': log.type === 'requested',
                                         'text-text-tertiary': log.type === 'expired'
                                       }" x-text="log.action"></p>
                                    <p class="text-[9px] text-text-tertiary font-mono" x-text="log.time"></p>
                                </div>
                                <p class="text-caption text-text-primary" x-text="log.details"></p>
                                <div x-show="log.signatures" class="mt-1 flex items-center gap-1 text-[9px] text-text-secondary font-mono border border-border-default bg-bg-tertiary px-1.5 py-0.5 rounded w-fit" x-cloak>
                                    <i data-lucide="pen-tool" class="w-2.5 h-2.5"></i>
                                    <span x-text="log.signatures"></span>
                                </div>
                            </div>
                        </div>
                    </template>
                </div>
            </div>

        </div>
    </div>

    <div x-show="modals.requestJit" class="fixed inset-0 z-50 flex items-center justify-center bg-brand-secondary/80 backdrop-blur-sm p-4" x-cloak>
        <div class="card w-full max-w-md p-0 shadow-2xl" @click.away="modals.requestJit = false">
            <div class="p-5 border-b border-border-default bg-bg-tertiary flex justify-between items-center rounded-t-lg">
                <h3 class="text-h4 font-bold text-text-primary">Request JIT Elevation</h3>
                <button @click="modals.requestJit = false" class="text-text-tertiary hover:text-text-primary"><i data-lucide="x" class="w-5 h-5"></i></button>
            </div>
            
            <form @submit.prevent="submitJitRequest">
                <div class="p-6 space-y-4">
                    <div class="form-group mb-0">
                        <label class="form-label">Role / Scope Needed</label>
                        <select x-model="jitForm.role" required class="form-input w-full text-body-sm">
                            <option value="Super Admin">Super Admin (Full Platform)</option>
                            <option value="Finance Admin">Finance Admin (Ledger/Payouts)</option>
                            <option value="Security Admin">Security Admin (Tokens/Firewall)</option>
                        </select>
                    </div>

                    <div class="form-group mb-0">
                        <label class="form-label">Time-Boxed Duration</label>
                        <select x-model="jitForm.duration" required class="form-input w-full text-body-sm">
                            <option value="15">15 Minutes</option>
                            <option value="30">30 Minutes</option>
                            <option value="60">1 Hour (Default)</option>
                        </select>
                        <p class="text-[9px] text-text-tertiary mt-1">Extensions require a new approval request.</p>
                    </div>

                    <div class="form-group mb-0">
                        <label class="form-label">Justification (Audited)</label>
                        <textarea x-model="jitForm.justification" required rows="3" class="form-input w-full text-body-sm" placeholder="Detailed reason for accessing high-privilege scopes..."></textarea>
                    </div>
                </div>
                <div class="p-4 border-t border-border-default flex justify-end gap-3 rounded-b-lg bg-bg-tertiary">
                    <button type="button" @click="modals.requestJit = false" class="btn btn-tertiary">Cancel</button>
                    <button type="submit" class="btn btn-primary">Submit Request</button>
                </div>
            </form>
        </div>
    </div>

    <div x-show="modals.reviewDual" class="fixed inset-0 z-50 flex items-center justify-center bg-brand-secondary/90 backdrop-blur-sm p-4" x-cloak>
        <div class="card w-full max-w-2xl p-0 shadow-2xl border-semantic-warning" @click.away="modals.reviewDual = false">
            <div class="p-5 border-b border-border-default bg-bg-tertiary flex justify-between items-center rounded-t-lg">
                <h3 class="text-h4 font-bold text-text-primary flex items-center gap-2">
                    <i data-lucide="shield-alert" class="w-5 h-5 text-semantic-warning"></i> Review & Sign Action
                </h3>
                <button @click="modals.reviewDual = false" class="text-text-tertiary hover:text-text-primary"><i data-lucide="x" class="w-5 h-5"></i></button>
            </div>
            
            <div class="p-6 overflow-y-auto max-h-[70vh] custom-scrollbar space-y-6" x-show="reviewData">
                
                <div>
                    <h4 class="text-caption font-bold text-text-tertiary uppercase tracking-wider mb-2">Action Summary</h4>
                    <div class="bg-bg-secondary border border-border-default rounded-lg p-4">
                        <p class="text-body-sm font-bold text-text-primary mb-1" x-text="reviewData?.description"></p>
                        <p class="text-caption text-text-secondary" x-text="'Category: ' + reviewData?.category"></p>
                        <p class="text-caption text-text-secondary mt-2 border-l-2 border-border-strong pl-2 py-0.5" x-text="'Justification: ' + reviewData?.justification"></p>
                    </div>
                </div>

                <div>
                    <h4 class="text-caption font-bold text-text-tertiary uppercase tracking-wider mb-2">State Diff Preview</h4>
                    <div class="grid grid-cols-2 gap-4">
                        <div class="bg-bg-primary border border-border-default rounded p-3">
                            <span class="text-[10px] text-text-tertiary uppercase font-bold block mb-2">Before State</span>
                            <pre class="text-[10px] font-mono text-semantic-error whitespace-pre-wrap" x-text="JSON.stringify(reviewData?.beforeState, null, 2)"></pre>
                        </div>
                        <div class="bg-bg-primary border border-border-default rounded p-3">
                            <span class="text-[10px] text-text-tertiary uppercase font-bold block mb-2">After State (Proposed)</span>
                            <pre class="text-[10px] font-mono text-semantic-success whitespace-pre-wrap" x-text="JSON.stringify(reviewData?.afterState, null, 2)"></pre>
                        </div>
                    </div>
                </div>

            </div>

            <div class="p-4 border-t border-border-default flex justify-between items-center rounded-b-lg bg-bg-tertiary">
                <button @click="denyDualAction()" class="btn btn-destructive btn-sm">Deny & Abort</button>
                <div class="flex gap-3">
                    <button @click="modals.reviewDual = false" class="btn btn-tertiary btn-sm">Cancel</button>
                    <button @click="signDualAction()" class="btn btn-primary bg-semantic-warning border-none hover:bg-orange-500 text-white shadow-lg btn-sm flex items-center gap-2">
                        <i data-lucide="pen-tool" class="w-4 h-4"></i> Apply Digital Signature
                    </button>
                </div>
            </div>
        </div>
    </div>

</div>

@push('scripts')
<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('privilegedGovernance', () => ({
        isLoading: true,
        pipelineTab: 'dual',  
        
        modals: { requestJit: false, reviewDual: false },
        jitForm: { role: 'Super Admin', duration: 60, justification: '' },
        reviewData: null,

        activeElevations: [],
        jitRequests: [],
        dualApprovals: [],
        auditLogs: [],

        init() {
            this.fetchData();
            setInterval(() => this.tickTimers(), 60000);
        },

        async fetchData() {
            this.isLoading = true;
            await new Promise(r => setTimeout(r, 600)); // Simulate API
            
            this.activeElevations = [
                { id: 1, user: 'John Doe (You)', role: 'Finance Admin', justification: 'Processing delayed settlements for vendor.', minsLeft: 42, totalMins: 60 },
            ];

            this.jitRequests = [
                { id: 401, requester: 'Sarah Jenkins', requestedRole: 'Security Admin', duration: 60, justification: 'Rotating compromised API key for Zapier integration.', timeAgo: '10 mins ago' }
            ];

            this.dualApprovals = [
                { 
                    id: 901, category: 'Business Payout', description: 'Release $45,200 payout to "CleanSweep UAE"', requester: 'Tariq Al Fasi', justification: 'Standard weekly volume settlement.', timeAgo: '5 mins ago', 
                    l1_signer: 'Sarah Jenkins', l2_signer: null,
                    beforeState: { "wallet_status": "locked", "balance": "$45,200" },
                    afterState: { "wallet_status": "transferred", "balance": "$0" }
                },
                { 
                    id: 902, category: 'Kill Switch', description: 'Hard Disable Network Region (Russia)', requester: 'Security Bot', justification: 'Anomaly detected. Mass IP spoofing attempt.', timeAgo: '12 mins ago', 
                    l1_signer: null, l2_signer: null,
                    beforeState: { "geo_rule_RU": "allowed" },
                    afterState: { "geo_rule_RU": "denied" }
                }
            ];

            this.auditLogs = [
                { id: 1, type: 'executed', action: 'Four-Eyes Executed', time: '10:42 AM', details: 'Refund of $1,200 processed for Business ID #412.', signatures: 'Signed by Sarah Jenkins & Admin Root' },
                { id: 2, type: 'expired', action: 'JIT Auto-Revoked', time: '09:15 AM', details: 'Temporary Super Admin role for Tariq Al Fasi expired after 60m.', signatures: null },
                { id: 3, type: 'requested', action: 'JIT Requested', time: '08:00 AM', details: 'John Doe requested [Finance Admin] for 60m.', signatures: null },
            ];

            this.isLoading = false;
            this.$nextTick(() => lucide.createIcons());
        },

        tickTimers() {
            this.activeElevations.forEach(session => {
                if(session.minsLeft > 0) session.minsLeft--;
                if(session.minsLeft === 0) {
                    this.activeElevations = this.activeElevations.filter(s => s.id !== session.id);
                    this.addLog('expired', 'JIT Auto-Revoked', `Session #${session.id} automatically revoked due to time-box limit.`);
                }
            });
        },

        // --- JIT Elevation Logic ---
        submitJitRequest() {
            this.modals.requestJit = false;
            this.addLog('requested', 'JIT Requested', `You requested [${this.jitForm.role}] for ${this.jitForm.duration}m. Justification: ${this.jitForm.justification}`);
            alert('Elevation request submitted to senior administrators.');
            this.jitForm = { role: 'Super Admin', duration: 60, justification: '' };
        },

        approveJit(id) {
            if(!confirm('Grant elevated access? It will automatically revoke after the requested duration.')) return;
            const req = this.jitRequests.find(r => r.id === id);
            this.jitRequests = this.jitRequests.filter(r => r.id !== id);
            
            // Move to active
            this.activeElevations.push({
                id: Date.now(), user: req.requester, role: req.requestedRole, justification: req.justification, minsLeft: req.duration, totalMins: req.duration
            });

            this.addLog('approved', 'JIT Granted', `Granted [${req.requestedRole}] to ${req.requester} for ${req.duration}m.`);
            this.$nextTick(() => lucide.createIcons());
        },

        denyJit(id) {
            const reason = prompt("Reason for denial:");
            if(!reason) return;
            const req = this.jitRequests.find(r => r.id === id);
            this.jitRequests = this.jitRequests.filter(r => r.id !== id);
            this.addLog('denied', 'JIT Denied', `Denied elevation for ${req.requester}. Reason: ${reason}`);
        },

        terminateSession(id) {
            if(confirm('Revoke this elevation immediately?')) {
                this.activeElevations = this.activeElevations.filter(s => s.id !== id);
                this.addLog('revoked', 'JIT Terminated Early', `Session manually terminated before expiry limit.`);
            }
        },

        // --- Dual Approval (Four-Eyes) Logic ---
        openReviewModal(req) {
            this.reviewData = req;
            this.modals.reviewDual = true;
        },

        signDualAction() {
            const req = this.reviewData;
            
             if(!req.l1_signer) {
                req.l1_signer = "John Doe (You)";
                this.addLog('signed', 'L1 Signature Applied', `Action ACT-${req.id} signed by Level 1.`);
                alert("Level 1 signature applied. Awaiting Level 2.");
            } else if (!req.l2_signer) {
                req.l2_signer = "John Doe (You)";
                this.addLog('executed', 'Four-Eyes Executed', `Action ACT-${req.id} executed successfully.`, `Signed by ${req.l1_signer} & ${req.l2_signer}`);
                alert("Level 2 signature applied. Action Executed.");
                this.dualApprovals = this.dualApprovals.filter(p => p.id !== req.id);
            }
            
            this.modals.reviewDual = false;
        },

        denyDualAction() {
            const reason = prompt("Enter abort/denial reason for Audit Log:");
            if(!reason) return;
            const req = this.reviewData;
            this.dualApprovals = this.dualApprovals.filter(p => p.id !== req.id);
            this.addLog('denied', 'Action Aborted', `Action ACT-${req.id} aborted/denied. Reason: ${reason}`);
            this.modals.reviewDual = false;
        },

        addLog(type, action, details, signatures = null) {
            const now = new Date();
            this.auditLogs.unshift({
                id: Date.now(),
                type: type,
                action: action,
                time: now.toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'}),
                details: details,
                signatures: signatures
            });
            this.$nextTick(() => lucide.createIcons());
        }
    }));
});
</script>
@endpush
@endsection