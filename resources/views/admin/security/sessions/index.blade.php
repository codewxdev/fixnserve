@extends('layouts.app')

@section('title', 'Session Management')

@section('content')
<div class="p-4 sm:p-6 lg:p-8 bg-bg-primary min-h-screen flex flex-col" x-data="sessionManagement()">

    <div class="flex flex-col xl:flex-row justify-between items-start xl:items-center mb-6 sm:mb-8 gap-4 shrink-0">
        <div>
            <h1 class="text-h3 sm:text-h2 font-bold tracking-tight text-text-primary flex items-center gap-3">
                <span class="p-2 bg-brand-primary/10 rounded-lg text-brand-primary border border-brand-primary/20">
                    <i data-lucide="users" class="w-5 h-5 sm:w-6 sm:h-6"></i>
                </span>
                Active Sessions
            </h1>
            <p class="text-text-secondary text-body-sm mt-2">Monitor, audit, and control identity access in real-time.</p>
        </div>

        <div class="flex flex-wrap items-center gap-3 w-full xl:w-auto">
            <button @click="modals.revokeRole = true" class="btn btn-secondary flex-1 p-2 sm:flex-none justify-center gap-2">
                <i data-lucide="shield-minus" class="w-4 h-4"></i> Revoke by Role
            </button>
            <button @click="modals.revokeRegion = true" class="btn btn-secondary flex-1 p-2 sm:flex-none justify-center gap-2">
                <i data-lucide="globe" class="w-4 h-4"></i> Revoke by Region
            </button>
            <button @click="emergencyLogoutAll()" class="btn btn-destructive p-2 flex-1 sm:flex-none justify-center gap-2 shadow-lg shadow-semantic-error/20">
                <i data-lucide="alert-octagon" class="w-4 h-4"></i> Emergency Logout All
            </button>
        </div>
    </div>

    <div class="card p-4 mb-6 flex flex-col lg:flex-row gap-4 items-center justify-between z-10 relative">
        <div class="flex flex-col sm:flex-row gap-3 w-full lg:w-auto flex-1">
            <div class="relative w-full sm:max-w-xs">
                <i data-lucide="search" class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-text-tertiary"></i>
                <input type="text" x-model="filters.search" placeholder="Search user, IP, or device..."
                    class="form-input w-full pl-9 bg-bg-secondary text-body-sm">
            </div>

            <select x-model="filters.status" class="form-input w-full sm:w-40 bg-bg-secondary text-body-sm py-0 h-10">
                <option value="all">All Statuses</option>
                <option value="active">Active Only</option>
                <option value="revoked">Revoked / Inactive</option>
            </select>

            <select x-model="filters.risk" class="form-input w-full sm:w-44 bg-bg-secondary text-body-sm py-0 h-10">
                <option value="all">All Risk Levels</option>
                <option value="critical">Critical Risk (>75)</option>
                <option value="medium">Medium Risk (25-75)</option>
                <option value="low">Low Risk (<25)</option>
            </select>
            
            <select x-model="filters.auth" class="form-input w-full sm:w-44 bg-bg-secondary text-body-sm py-0 h-10">
                <option value="all">All Auth Methods</option>
                <option value="pwd_mfa">Password + MFA</option>
                <option value="sso">Enterprise SSO</option>
                <option value="pwd_only">Password Only</option>
            </select>
        </div>

        <div class="text-caption text-text-secondary w-full lg:w-auto text-right">
            Showing <span class="font-bold text-text-primary" x-text="filteredSessions.length"></span> sessions
        </div>
    </div>

    <div class="card p-0 overflow-hidden flex-1 flex flex-col min-h-[400px]">
        <div class="overflow-x-auto custom-scrollbar flex-1">
            <table class="w-full text-left min-w-[1000px]">
                <thead class="text-caption uppercase text-text-secondary font-semibold bg-bg-tertiary border-b border-border-strong sticky top-0 z-10">
                    <tr>
                        <th class="px-5 py-3 whitespace-nowrap">Identity & Role</th>
                        <th class="px-5 py-3 whitespace-nowrap">Context (IP & Geo)</th>
                        <th class="px-5 py-3 whitespace-nowrap">Device Fingerprint</th>
                        <th class="px-5 py-3 whitespace-nowrap">Auth Method</th>
                        <th class="px-5 py-3 whitespace-nowrap text-center">Risk Score</th>
                        <th class="px-5 py-3 whitespace-nowrap">Status</th>
                        <th class="px-5 py-3 whitespace-nowrap text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-border-default bg-bg-primary">
                    
                    <tr x-show="isLoading">
                        <td colspan="7" class="px-6 py-12 text-center text-text-tertiary">
                            <i data-lucide="loader-2" class="w-8 h-8 animate-spin mx-auto mb-2 opacity-50"></i>
                            <p class="text-body-sm">Loading telemetry...</p>
                        </td>
                    </tr>

                    <tr x-show="!isLoading && filteredSessions.length === 0" x-cloak>
                        <td colspan="7" class="px-6 py-12 text-center text-text-tertiary">
                            <i data-lucide="shield-off" class="w-8 h-8 mx-auto mb-2 opacity-50"></i>
                            <p class="text-body-sm">No sessions match your criteria.</p>
                        </td>
                    </tr>

                    <template x-for="session in filteredSessions" :key="session.id">
                        <tr class="hover:bg-bg-secondary transition-colors group">
                            
                            <td class="px-5 py-3">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-full flex items-center justify-center font-bold text-[10px] shrink-0" 
                                         :style="`background-color: rgba(var(--brand-primary), 0.1); color: rgb(var(--brand-primary));`"
                                         x-text="session.user.name.charAt(0)"></div>
                                    <div class="min-w-0">
                                        <div class="font-bold text-text-primary text-body-sm truncate" x-text="session.user.name"></div>
                                        <div class="flex items-center gap-1.5 mt-0.5">
                                            <span class="text-[9px] uppercase font-mono tracking-wider text-text-secondary border border-border-strong px-1 rounded bg-bg-tertiary" x-text="session.user.role"></span>
                                        </div>
                                    </div>
                                </div>
                            </td>

                            <td class="px-5 py-3">
                                <div class="flex items-center gap-2">
                                    <i data-lucide="map-pin" class="w-3.5 h-3.5 text-text-tertiary shrink-0"></i>
                                    <span class="text-body-sm text-text-primary truncate" x-text="session.location"></span>
                                </div>
                                <div class="text-[10px] text-text-secondary mt-1 font-mono" x-text="session.ip"></div>
                            </td>

                            <td class="px-5 py-3">
                                <div class="flex items-center gap-2">
                                    <i :data-lucide="session.device_type === 'mobile' ? 'smartphone' : 'monitor'" class="w-3.5 h-3.5 text-text-tertiary shrink-0"></i>
                                    <span class="text-body-sm text-text-primary truncate" x-text="session.device_os"></span>
                                </div>
                                <div class="text-[10px] text-text-tertiary mt-1 truncate" title="Fingerprint Hash" x-text="session.fingerprint"></div>
                            </td>

                            <td class="px-5 py-3">
                                <span class="px-2 py-1 rounded-md text-[10px] font-bold border"
                                      :class="{
                                          'bg-blue-500/10 text-blue-500 border-blue-500/20': session.auth_method === 'SSO',
                                          'bg-purple-500/10 text-purple-500 border-purple-500/20': session.auth_method === 'PWD + MFA',
                                          'bg-bg-muted text-text-secondary border-border-strong': session.auth_method === 'PWD Only'
                                      }"
                                      x-text="session.auth_method"></span>
                            </td>

                            <td class="px-5 py-3 text-center">
                                <div class="inline-flex items-center justify-center w-8 h-8 rounded-full border-2 font-bold text-xs"
                                     :class="{
                                         'border-semantic-success text-semantic-success bg-semantic-success-bg': session.risk < 25,
                                         'border-semantic-warning text-semantic-warning bg-semantic-warning-bg': session.risk >= 25 && session.risk < 75,
                                         'border-semantic-error text-semantic-error bg-semantic-error-bg': session.risk >= 75
                                     }"
                                     x-text="session.risk"></div>
                            </td>

                            <td class="px-5 py-3">
                                <span x-show="session.status === 'active'" class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded text-[10px] font-bold bg-semantic-success-bg text-semantic-success border border-semantic-success/20 uppercase tracking-wider">
                                    <div class="w-1.5 h-1.5 rounded-full bg-semantic-success"></div> Active
                                </span>
                                <span x-show="session.status === 'revoked'" class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded text-[10px] font-bold bg-semantic-error-bg text-semantic-error border border-semantic-error/20 uppercase tracking-wider">
                                    <div class="w-1.5 h-1.5 rounded-full bg-semantic-error"></div> Revoked
                                </span>
                                <div class="text-[9px] text-text-tertiary mt-1" x-text="'Last: ' + session.last_active"></div>
                            </td>

                            <td class="px-5 py-3 text-right">
                                <div class="relative inline-block text-left" x-data="{ dropOpen: false }" @click.away="dropOpen = false">
                                    <button @click="dropOpen = !dropOpen" class="p-1.5 text-text-tertiary hover:text-text-primary rounded-md hover:bg-bg-tertiary transition-colors">
                                        <i data-lucide="more-vertical" class="w-4 h-4"></i>
                                    </button>
                                    
                                    <div x-show="dropOpen" x-transition.opacity class="absolute right-0 mt-2 w-48 rounded-md shadow-lg bg-bg-secondary border border-border-default z-50 py-1" x-cloak>
                                        <button @click="openDetails(session); dropOpen = false" class="w-full text-left px-4 py-2 text-body-sm text-text-primary hover:bg-bg-tertiary flex items-center gap-2">
                                            <i data-lucide="eye" class="w-3.5 h-3.5 text-text-secondary"></i> View Details
                                        </button>
                                        
                                        <button @click="forceMfa(session.id); dropOpen = false" :disabled="session.status === 'revoked'" class="w-full text-left px-4 py-2 text-body-sm text-text-primary hover:bg-bg-tertiary flex items-center gap-2 disabled:opacity-50 disabled:cursor-not-allowed">
                                            <i data-lucide="shield-alert" class="w-3.5 h-3.5 text-semantic-warning"></i> Force MFA Re-challenge
                                        </button>
                                        
                                        <button @click="flagSession(session.id); dropOpen = false" class="w-full text-left px-4 py-2 text-body-sm text-text-primary hover:bg-bg-tertiary flex items-center gap-2">
                                            <i data-lucide="flag" class="w-3.5 h-3.5 text-semantic-info"></i> Flag for Review
                                        </button>

                                        <div class="h-px bg-border-default my-1"></div>

                                        <button @click="revokeSingle(session.id); dropOpen = false" :disabled="session.status === 'revoked'" class="w-full text-left px-4 py-2 text-body-sm text-semantic-error hover:bg-semantic-error-bg flex items-center gap-2 disabled:opacity-50 disabled:cursor-not-allowed">
                                            <i data-lucide="x-circle" class="w-3.5 h-3.5"></i> Revoke This Session
                                        </button>

                                        <button @click="revokeUserAll(session.user.id, session.user.name); dropOpen = false" :disabled="session.status === 'revoked'" class="w-full text-left px-4 py-2 text-body-sm text-semantic-error hover:bg-semantic-error-bg flex items-center gap-2 disabled:opacity-50 disabled:cursor-not-allowed font-bold">
                                            <i data-lucide="trash-2" class="w-3.5 h-3.5"></i> Revoke All Devices
                                        </button>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    </template>
                </tbody>
            </table>
        </div>
    </div>

    <div x-show="modals.revokeRole" class="fixed inset-0 bg-brand-secondary/80 backdrop-blur-sm z-50 flex items-center justify-center p-4" x-cloak>
        <div class="card max-w-md w-full p-0 shadow-2xl border-semantic-error" @click.away="modals.revokeRole = false">
            <div class="p-5 border-b border-border-default bg-bg-tertiary rounded-t-lg">
                <h3 class="text-h4 font-bold text-text-primary flex items-center gap-2"><i data-lucide="shield-minus" class="w-5 h-5 text-semantic-error"></i> Revoke by Role</h3>
            </div>
            <div class="p-6">
                <p class="text-body-sm text-text-secondary mb-4">This will instantly terminate all active sessions for users holding the selected role globally.</p>
                <div class="form-group mb-0">
                    <label class="form-label">Select Target Role</label>
                    <select x-model="actionState.targetRole" class="form-input w-full">
                        <template x-for="role in roles" :key="role">
                            <option :value="role" x-text="role"></option>
                        </template>
                    </select>
                </div>
            </div>
            <div class="p-4 border-t border-border-default bg-bg-tertiary flex justify-end gap-3 rounded-b-lg">
                <button @click="modals.revokeRole = false" class="btn p-1.5 btn-tertiary">Cancel</button>
                <button @click="executeRevokeRole()" class="btn p-1.5 btn-destructive">Confirm Logout</button>
            </div>
        </div>
    </div>

    <div x-show="modals.revokeRegion" class="fixed inset-0 bg-brand-secondary/80 backdrop-blur-sm z-50 flex items-center justify-center p-4" x-cloak>
        <div class="card max-w-md w-full p-0 shadow-2xl border-semantic-warning" @click.away="modals.revokeRegion = false">
            <div class="p-5 border-b border-border-default bg-bg-tertiary rounded-t-lg">
                <h3 class="text-h4 font-bold text-text-primary flex items-center gap-2"><i data-lucide="globe" class="w-5 h-5 text-semantic-warning"></i> Revoke by Region</h3>
            </div>
            <div class="p-6">
                <p class="text-body-sm text-text-secondary mb-4">Terminate sessions originating from a specific geographic region based on IP resolution.</p>
                <div class="form-group mb-0">
                    <label class="form-label">Select Target Region (ISO)</label>
                    <select x-model="actionState.targetRegion" class="form-input w-full">
                        <option value="AE">United Arab Emirates (AE)</option>
                        <option value="SA">Saudi Arabia (SA)</option>
                        <option value="QA">Qatar (QA)</option>
                        <option value="UNKNOWN">Unknown / Proxied</option>
                    </select>
                </div>
            </div>
            <div class="p-4 border-t border-border-default bg-bg-tertiary flex justify-end gap-3 rounded-b-lg">
                <button @click="modals.revokeRegion = false" class="btn p-1.5 btn-tertiary">Cancel</button>
                <button @click="executeRevokeRegion()" class="btn p-1.5 btn-primary bg-semantic-warning hover:bg-orange-600 text-white border-none">Execute Purge</button>
            </div>
        </div>
    </div>

    <div x-show="modals.sessionDetails" class="fixed inset-0 bg-brand-secondary/80 backdrop-blur-sm z-50 flex items-center justify-center p-4" x-cloak>
        <div class="card max-w-2xl w-full p-0 shadow-2xl" @click.away="modals.sessionDetails = false">
            <div class="p-5 border-b border-border-default bg-bg-tertiary rounded-t-lg flex justify-between items-center">
                <h3 class="text-h4 font-bold text-text-primary">Session Context</h3>
                <button @click="modals.sessionDetails = false" class="text-text-tertiary hover:text-text-primary"><i data-lucide="x" class="w-5 h-5"></i></button>
            </div>
            <div class="p-6 space-y-6" x-show="modals.selectedSession">
                
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-full bg-brand-primary/10 text-brand-primary flex items-center justify-center text-h4 font-bold" x-text="modals.selectedSession?.user.name.charAt(0)"></div>
                    <div>
                        <h4 class="text-body font-bold text-text-primary" x-text="modals.selectedSession?.user.name"></h4>
                        <p class="text-caption text-text-secondary" x-text="modals.selectedSession?.user.email"></p>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div class="bg-bg-tertiary p-3 rounded-lg border border-border-default">
                        <span class="text-[10px] text-text-tertiary uppercase font-bold block mb-1">IP Address</span>
                        <span class="text-body-sm font-mono text-text-primary" x-text="modals.selectedSession?.ip"></span>
                    </div>
                    <div class="bg-bg-tertiary p-3 rounded-lg border border-border-default">
                        <span class="text-[10px] text-text-tertiary uppercase font-bold block mb-1">Exact Location</span>
                        <span class="text-body-sm text-text-primary" x-text="modals.selectedSession?.location"></span>
                    </div>
                    <div class="bg-bg-tertiary p-3 rounded-lg border border-border-default">
                        <span class="text-[10px] text-text-tertiary uppercase font-bold block mb-1">Device Fingerprint</span>
                        <span class="text-caption font-mono text-text-secondary truncate block" title="modals.selectedSession?.fingerprint" x-text="modals.selectedSession?.fingerprint"></span>
                    </div>
                    <div class="bg-bg-tertiary p-3 rounded-lg border border-border-default">
                        <span class="text-[10px] text-text-tertiary uppercase font-bold block mb-1">Authentication Method</span>
                        <span class="text-body-sm text-text-primary" x-text="modals.selectedSession?.auth_method"></span>
                    </div>
                </div>

                <div class="bg-semantic-warning-bg border border-semantic-warning/30 p-4 rounded-lg flex items-start gap-3" x-show="modals.selectedSession?.risk > 50">
                    <i data-lucide="alert-triangle" class="w-5 h-5 text-semantic-warning shrink-0 mt-0.5"></i>
                    <div>
                        <p class="text-body-sm font-bold text-text-primary">High Risk Signals Detected</p>
                        <p class="text-caption text-text-secondary mt-1">This session originated from an unknown IP address using a new device fingerprint. Consider forcing an MFA re-challenge.</p>
                    </div>
                </div>
            </div>
            <div class="p-4 border-t border-border-default bg-bg-tertiary flex justify-end gap-3 rounded-b-lg">
                <button @click="forceMfa(modals.selectedSession?.id); modals.sessionDetails = false" class="btn btn-secondary text-semantic-warning border-semantic-warning/30">Force MFA</button>
                <button @click="revokeSingle(modals.selectedSession?.id); modals.sessionDetails = false" class="btn btn-destructive">Revoke Session</button>
            </div>
        </div>
    </div>

</div>

@push('scripts')
<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('sessionManagement', () => ({
        isLoading: true,
        sessions: [],
        roles: ['Finance Admin', 'Support Agent', 'Operations Admin', 'Developer'],
        
        filters: { search: '', status: 'active', risk: 'all', auth: 'all' },
        
        modals: { revokeRole: false, revokeRegion: false, sessionDetails: false, selectedSession: null },
        actionState: { targetRole: 'Finance Admin', targetRegion: 'UNKNOWN' },

        init() {
            this.fetchSessions();
        },

        get filteredSessions() {
            return this.sessions.filter(s => {
                // Search
                const q = this.filters.search.toLowerCase();
                const matchSearch = s.user.name.toLowerCase().includes(q) || 
                                    s.user.email.toLowerCase().includes(q) || 
                                    s.ip.includes(q) || 
                                    s.fingerprint.toLowerCase().includes(q);
                
                // Status
                let matchStatus = true;
                if(this.filters.status === 'active') matchStatus = s.status === 'active';
                if(this.filters.status === 'revoked') matchStatus = s.status === 'revoked';

                // Risk
                let matchRisk = true;
                if(this.filters.risk === 'critical') matchRisk = s.risk >= 75;
                if(this.filters.risk === 'medium') matchRisk = s.risk >= 25 && s.risk < 75;
                if(this.filters.risk === 'low') matchRisk = s.risk < 25;

                // Auth
                let matchAuth = true;
                if(this.filters.auth === 'pwd_mfa') matchAuth = s.auth_method === 'PWD + MFA';
                if(this.filters.auth === 'sso') matchAuth = s.auth_method === 'SSO';
                if(this.filters.auth === 'pwd_only') matchAuth = s.auth_method === 'PWD Only';

                return matchSearch && matchStatus && matchRisk && matchAuth;
            });
        },

        async fetchSessions() {
            this.isLoading = true;
            
             await new Promise(r => setTimeout(r, 800));
            
            this.sessions = [
                { id: 101, user: { id: 1, name: 'Sarah Jenkins', email: 'sarah@sahorone.com', role: 'Finance Admin' }, ip: '194.23.11.9', location: 'Dubai, UAE', device_type: 'desktop', device_os: 'macOS / Chrome', fingerprint: 'fx92_88a1b2c', auth_method: 'PWD + MFA', risk: 12, status: 'active', last_active: '2 mins ago' },
                { id: 102, user: { id: 2, name: 'Tariq Al Fasi', email: 'tariq@sahorone.com', role: 'Operations Admin' }, ip: '82.11.44.2', location: 'Abu Dhabi, UAE', device_type: 'mobile', device_os: 'iOS / Safari', fingerprint: 'm_44b99x1', auth_method: 'SSO', risk: 8, status: 'active', last_active: 'Just now' },
                { id: 103, user: { id: 3, name: 'John Doe', email: 'john.d@partner.com', role: 'Developer' }, ip: '188.4.22.10', location: 'London, UK', device_type: 'desktop', device_os: 'Windows / Firefox', fingerprint: 'win_11_zzp', auth_method: 'PWD Only', risk: 82, status: 'active', last_active: '45 mins ago' },
                { id: 104, user: { id: 4, name: 'Aisha Khan', email: 'aisha@sahorone.com', role: 'Support Agent' }, ip: '194.23.11.14', location: 'Dubai, UAE', device_type: 'desktop', device_os: 'macOS / Chrome', fingerprint: 'fx92_11k89', auth_method: 'PWD + MFA', risk: 35, status: 'revoked', last_active: '2 hrs ago' },
                { id: 105, user: { id: 1, name: 'Sarah Jenkins', email: 'sarah@sahorone.com', role: 'Finance Admin' }, ip: '202.14.9.8', location: 'Unknown Proxy', device_type: 'desktop', device_os: 'Linux / Tor', fingerprint: 'unkn_99182', auth_method: 'PWD + MFA', risk: 95, status: 'active', last_active: '1 min ago' },
            ];

            this.isLoading = false;
            this.$nextTick(() => lucide.createIcons());
        },

        // --- ACTIONS ---

        openDetails(session) {
            this.modals.selectedSession = session;
            this.modals.sessionDetails = true;
        },

        forceMfa(id) {
            if(!confirm("Force this session to re-authenticate with MFA immediately?")) return;
            alert(`MFA Challenge pushed via WebSocket to session ${id}`);
        },

        flagSession(id) {
            let score = prompt("Enter manual risk score adjustment (0-100):", "99");
            if(score) {
                const s = this.sessions.find(x => x.id === id);
                if(s) s.risk = parseInt(score);
                alert("Risk score adjusted and flagged for SecOps review.");
            }
        },

        async revokeSingle(id) {
            if(!confirm("Terminate this specific session?")) return;
            const s = this.sessions.find(x => x.id === id);
            if(s) s.status = 'revoked';
            alert("Session revoked and token blacklisted.");
        },

        async revokeUserAll(userId, name) {
            if(!confirm(`DANGER: Terminate ALL active sessions across all devices for ${name}?`)) return;
            this.sessions.forEach(s => {
                if(s.user.id === userId) s.status = 'revoked';
            });
            alert(`All tokens for ${name} blacklisted.`);
        },

        async executeRevokeRole() {
            this.modals.revokeRole = false;
            const role = this.actionState.targetRole;
            this.sessions.forEach(s => {
                if(s.user.role === role) s.status = 'revoked';
            });
            alert(`Purged all active sessions for role: ${role}`);
        },

        async executeRevokeRegion() {
            this.modals.revokeRegion = false;
            const region = this.actionState.targetRegion;
            alert(`Command sent: Revoke all tokens originating from ISO: ${region}`);
        },

        async emergencyLogoutAll() {
            if(!confirm("CRITICAL WARNING: This will instantly log out every single user (including you) and flush the entire Redis session store. Proceed?")) return;
            alert("Executing Platform-Wide Kill Switch. Redirecting to login...");
            
        }
    }));
});
</script>
@endpush
@endsection