@extends('layouts.app')

@section('title', 'Network Security')

@section('content')
<div class="p-4 sm:p-6 lg:p-8 bg-bg-primary min-h-screen flex flex-col" x-data="networkSecurity()">

    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 sm:mb-8 gap-4 shrink-0">
        <div>
            <h1 class="text-h3 sm:text-h2 font-bold tracking-tight text-text-primary flex items-center gap-3">
                <span class="p-2 bg-brand-primary/10 rounded-lg text-brand-primary border border-brand-primary/20">
                    <i data-lucide="network" class="w-5 h-5 sm:w-6 sm:h-6"></i>
                </span>
                Network Defense Layer
            </h1>
            <p class="text-text-secondary text-body-sm mt-2">Configure IP firewalls, geo-blocking, and AI travel detection.</p>
        </div>

        <button @click="togglePanicMode()" 
                class="btn w-full md:w-auto bg-semantic-error-bg text-semantic-error border border-semantic-error/30 hover:bg-semantic-error hover:text-white flex items-center justify-center gap-2 shadow-lg transition-colors p-2">
            <i data-lucide="siren" class="w-4 h-4"></i>
            <span>Panic Mode: Block Non-Domestic</span>
        </button>
    </div>

    <div class="grid grid-cols-1 xl:grid-cols-3 gap-6 sm:gap-8">

        <div class="xl:col-span-2 space-y-6 sm:space-y-8">

            <div class="card p-0 overflow-hidden flex flex-col">
                <div class="px-5 sm:px-6 py-4 border-b border-border-default bg-bg-tertiary flex justify-between items-center">
                    <h3 class="text-h4 font-bold text-text-primary flex items-center gap-2">
                        <i data-lucide="list-check" class="w-5 h-5 text-brand-primary"></i> IP Access Rules
                    </h3>
                    <button @click="modals.addIpRule = true" class="btn btn-primary btn-sm flex items-center gap-2">
                        <i data-lucide="plus" class="w-4 h-4"></i> Add Rule
                    </button>
                </div>

                <div class="overflow-x-auto custom-scrollbar">
                    <table class="w-full text-left min-w-[700px]">
                        <thead class="text-caption uppercase text-text-secondary font-semibold bg-bg-primary border-b border-border-strong">
                            <tr>
                                <th class="px-5 py-3">IP / CIDR Block</th>
                                <th class="px-5 py-3">Type</th>
                                <th class="px-5 py-3">Applies To (Role)</th>
                                <th class="px-5 py-3">Expiration</th>
                                <th class="px-5 py-3 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-border-default bg-bg-secondary">
                            
                            <tr x-show="isLoading">
                                <td colspan="5" class="px-6 py-8 text-center text-text-tertiary">
                                    <i data-lucide="loader-2" class="w-6 h-6 animate-spin mx-auto mb-2 opacity-50"></i>
                                    <p class="text-body-sm">Loading network rules...</p>
                                </td>
                            </tr>

                            <tr x-show="!isLoading && ipRules.length === 0" x-cloak>
                                <td colspan="5" class="px-6 py-8 text-center text-text-tertiary">No IP rules configured.</td>
                            </tr>

                            <template x-for="rule in ipRules" :key="rule.id">
                                <tr class="hover:bg-bg-tertiary transition-colors" :class="rule.type === 'deny' ? 'bg-semantic-error-bg/30' : ''">
                                    <td class="px-5 py-4">
                                        <div class="font-mono text-body-sm text-text-primary font-bold" x-text="rule.cidr"></div>
                                        <div class="text-caption text-text-secondary mt-0.5 truncate" x-text="rule.comment"></div>
                                    </td>
                                    <td class="px-5 py-4">
                                        <span x-show="rule.type === 'allow'" class="px-2 py-0.5 rounded text-[10px] font-bold bg-semantic-success-bg text-semantic-success border border-semantic-success/20 uppercase tracking-wider">Allow</span>
                                        <span x-show="rule.type === 'deny'" class="px-2 py-0.5 rounded text-[10px] font-bold bg-semantic-error-bg text-semantic-error border border-semantic-error/20 uppercase tracking-wider">Block</span>
                                    </td>
                                    <td class="px-5 py-4">
                                        <span class="px-2 py-1 rounded bg-bg-primary text-text-primary text-[10px] border border-border-default font-mono uppercase" x-text="rule.appliesTo"></span>
                                    </td>
                                    <td class="px-5 py-4">
                                        <span x-show="!rule.expiry" class="text-text-secondary text-xs">Permanent</span>
                                        <span x-show="rule.expiry" class="text-semantic-warning font-bold text-xs" x-text="'Expires: ' + rule.expiry"></span>
                                    </td>
                                    <td class="px-5 py-4 text-right">
                                        <button @click="deleteIpRule(rule.id)" class="p-1.5 text-text-tertiary hover:text-semantic-error rounded transition-colors" title="Remove Rule">
                                            <i data-lucide="trash-2" class="w-4 h-4"></i>
                                        </button>
                                    </td>
                                </tr>
                            </template>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="card p-0 overflow-hidden">
                <div class="px-5 sm:px-6 py-4 border-b border-border-default bg-bg-tertiary flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                    <h3 class="text-h4 font-bold text-text-primary flex items-center gap-2">
                        <i data-lucide="globe" class="w-5 h-5 text-brand-primary"></i> Geo-Blocking & Regions
                    </h3>
                    
                    <div class="flex items-center gap-2 bg-bg-primary p-1 rounded-md border border-border-default w-full sm:w-auto">
                        <span class="text-caption text-text-secondary pl-2 pr-1 uppercase font-bold tracking-wider">Default:</span>
                        <button @click="updateGlobalGeo('allow_all')" :class="globalGeo === 'allow_all' ? 'bg-semantic-success text-white shadow-sm' : 'text-text-tertiary hover:text-text-primary'" class="px-3 py-1 text-xs font-bold rounded transition-colors uppercase">Allow All</button>
                        <button @click="updateGlobalGeo('deny_all')" :class="globalGeo === 'deny_all' ? 'bg-semantic-error text-white shadow-sm' : 'text-text-tertiary hover:text-text-primary'" class="px-3 py-1 text-xs font-bold rounded transition-colors uppercase">Deny All</button>
                    </div>
                </div>

                <div class="p-4 border-b border-border-default bg-bg-primary">
                    <div class="relative">
                        <i data-lucide="search" class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-text-tertiary"></i>
                        <input type="text" x-model="geoSearch" placeholder="Search specific country overrides..." class="form-input w-full pl-9 h-10 text-body-sm bg-bg-secondary">
                    </div>
                </div>

                <div class="p-3 max-h-[350px] overflow-y-auto custom-scrollbar bg-bg-secondary space-y-1.5">
                    <template x-for="country in filteredGeo" :key="country.code">
                        <div class="flex items-center justify-between p-3 rounded-lg border border-border-default hover:bg-bg-tertiary transition-colors" :class="country.status === 'denied' ? 'bg-semantic-error-bg/30 border-semantic-error/20' : 'bg-bg-primary'">
                            <div class="flex items-center gap-3">
                                <span class="text-xl" x-text="country.flag"></span>
                                <span class="text-body-sm font-semibold text-text-primary" x-text="country.name"></span>
                                <span class="text-[10px] font-mono text-text-secondary" x-text="country.code"></span>
                            </div>
                            <div class="flex items-center gap-3">
                                <span x-show="country.status === 'allowed'" class="px-2 py-0.5 rounded text-[10px] font-bold bg-semantic-success-bg text-semantic-success border border-semantic-success/20 uppercase tracking-wider">Allowed</span>
                                <span x-show="country.status === 'denied'" class="px-2 py-0.5 rounded text-[10px] font-bold bg-semantic-error-bg text-semantic-error border border-semantic-error/20 uppercase tracking-wider">Blocked</span>
                                
                                <button x-show="country.status === 'allowed'" @click="toggleGeo(country.code, 'denied')" class="btn btn-sm btn-secondary text-semantic-error border-semantic-error/30 hover:bg-semantic-error hover:text-white text-xs py-1">Block</button>
                                <button x-show="country.status === 'denied'" @click="toggleGeo(country.code, 'allowed')" class="btn btn-sm btn-secondary text-semantic-success border-semantic-success/30 hover:bg-semantic-success hover:text-white text-xs py-1">Allow</button>
                            </div>
                        </div>
                    </template>
                </div>
            </div>

        </div>

        <div class="space-y-6 sm:space-y-8">
            
            <div class="card p-0 overflow-hidden border-brand-primary/20 shadow-lg">
                <div class="px-5 py-4 border-b border-border-default bg-brand-primary/5 flex items-center gap-2">
                    <i data-lucide="zap" class="w-5 h-5 text-brand-primary"></i>
                    <h3 class="text-h4 font-bold text-brand-primary">AI Threat Intelligence</h3>
                </div>

                <div class="p-5 space-y-6">
                    <div class="flex items-start justify-between gap-4">
                        <div>
                            <p class="text-body-sm font-bold text-text-primary">Strict VPN/Proxy Blocking</p>
                            <p class="text-caption text-text-secondary mt-0.5">Use AI heuristic scoring to block known datacenter IPs, Tor exit nodes, and anonymous VPNs.</p>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer shrink-0 mt-1">
                            <input type="checkbox" x-model="aiThreats.blockVpn" class="sr-only peer">
                            <div class="w-11 h-6 bg-bg-muted peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-border-strong after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-brand-primary"></div>
                        </label>
                    </div>

                    <div class="h-px bg-border-default w-full"></div>

                    <div>
                        <div class="flex items-center justify-between mb-4">
                            <p class="text-body-sm font-bold text-text-primary">Impossible Travel Detection</p>
                            <span class="px-2 py-0.5 rounded text-[9px] font-bold bg-semantic-warning-bg text-semantic-warning border border-semantic-warning/20 uppercase tracking-wider" x-text="aiThreats.travelIncidents.length + ' Active'"></span>
                        </div>

                        <div class="space-y-3">
                            <template x-for="incident in aiThreats.travelIncidents" :key="incident.id">
                                <div class="p-3 bg-semantic-warning-bg/40 border border-semantic-warning/30 rounded-lg">
                                    <div class="flex items-start gap-3">
                                        <i data-lucide="alert-triangle" class="w-5 h-5 text-semantic-warning shrink-0 mt-0.5"></i>
                                        <div class="flex-1 min-w-0">
                                            <p class="text-body-sm font-bold text-text-primary truncate" x-text="'User: ' + incident.user"></p>
                                            
                                            <div class="mt-2 space-y-1.5 relative before:absolute before:inset-y-2 before:left-[3px] before:w-0.5 before:bg-border-strong">
                                                <div class="flex items-center gap-2 relative z-10">
                                                    <div class="w-2 h-2 rounded-full bg-border-strong outline outline-2 outline-bg-primary"></div>
                                                    <span class="text-[10px] text-text-secondary truncate" x-text="incident.loc1 + ' @ ' + incident.time1"></span>
                                                </div>
                                                <div class="flex items-center gap-2 relative z-10">
                                                    <div class="w-2 h-2 rounded-full bg-semantic-error outline outline-2 outline-bg-primary"></div>
                                                    <span class="text-[10px] text-text-primary font-bold truncate" x-text="incident.loc2 + ' @ ' + incident.time2"></span>
                                                </div>
                                            </div>
                                            
                                            <p class="text-[10px] font-mono text-semantic-warning mt-2" x-text="`Distance: ${incident.distance}km in ${incident.duration}m`"></p>
                                            
                                            <div class="mt-3 flex gap-2">
                                                <button @click="freezeAccount(incident.user_id)" class="btn btn-sm btn-destructive py-1 px-2 text-[10px]">Freeze Account</button>
                                                <button @click="dismissAlert(incident.id)" class="btn btn-sm btn-secondary text-[10px] py-1 px-2">Dismiss</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </template>
                            
                            <div x-show="aiThreats.travelIncidents.length === 0" class="text-center p-4 border border-border-default border-dashed rounded-lg">
                                <i data-lucide="shield-check" class="w-6 h-6 text-semantic-success mx-auto mb-2"></i>
                                <p class="text-caption text-text-secondary">No travel anomalies detected.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <div x-show="modals.addIpRule" class="fixed inset-0 z-50 flex items-center justify-center bg-brand-secondary/80 backdrop-blur-sm p-4" x-cloak>
        <div class="card w-full max-w-lg p-0 shadow-2xl" @click.away="modals.addIpRule = false">
            <div class="p-5 border-b border-border-default bg-bg-tertiary flex justify-between items-center rounded-t-lg">
                <h3 class="text-h4 font-bold text-text-primary">Add IP Access Rule</h3>
                <button @click="modals.addIpRule = false" class="text-text-tertiary"><i data-lucide="x" class="w-5 h-5"></i></button>
            </div>
            
            <form @submit.prevent="submitIpRule">
                <div class="p-6 space-y-5 max-h-[70vh] overflow-y-auto custom-scrollbar">
                    
                    <div class="form-group mb-0">
                        <label class="form-label">IP Address or CIDR Block</label>
                        <input type="text" x-model="newRule.cidr" required placeholder="e.g. 192.168.1.5 or 10.0.0.0/24" class="form-input w-full font-mono text-sm">
                    </div>

                    <div class="form-group mb-0">
                        <label class="form-label">Rule Type</label>
                        <div class="grid grid-cols-2 gap-3">
                            <label class="cursor-pointer">
                                <input type="radio" x-model="newRule.type" value="allow" class="peer sr-only">
                                <div class="p-3 text-center rounded-lg border border-border-default peer-checked:bg-semantic-success-bg peer-checked:border-semantic-success peer-checked:text-semantic-success text-text-secondary transition-colors">
                                    <div class="text-body-sm font-bold">Allow (Whitelist)</div>
                                </div>
                            </label>
                            <label class="cursor-pointer">
                                <input type="radio" x-model="newRule.type" value="deny" class="peer sr-only">
                                <div class="p-3 text-center rounded-lg border border-border-default peer-checked:bg-semantic-error-bg peer-checked:border-semantic-error peer-checked:text-semantic-error text-text-secondary transition-colors">
                                    <div class="text-body-sm font-bold">Block (Blacklist)</div>
                                </div>
                            </label>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div class="form-group mb-0">
                            <label class="form-label">Applies To (Role Binding)</label>
                            <select x-model="newRule.appliesTo" class="form-input w-full text-sm">
                                <option value="Global">Global (All Traffic)</option>
                                <option value="Admin Panel">Admin Panel Only</option>
                                <option value="API Clients">API Integrations</option>
                                <option value="Finance Role">Finance Role Only</option>
                            </select>
                        </div>
                        <div class="form-group mb-0">
                            <label class="form-label">Temporary Allowance (Expiry)</label>
                            <input type="datetime-local" x-model="newRule.expiry" class="form-input w-full text-sm">
                            <span class="text-[9px] text-text-tertiary mt-1 block">Leave empty for permanent rule.</span>
                        </div>
                    </div>

                    <div class="form-group mb-0">
                        <label class="form-label">Comment / Justification</label>
                        <input type="text" x-model="newRule.comment" required placeholder="e.g. Dubai HQ Office Network" class="form-input w-full text-sm">
                    </div>

                </div>
                
                <div class="p-4 border-t border-border-default flex justify-end gap-3 rounded-b-lg bg-bg-tertiary">
                    <button type="button" @click="modals.addIpRule = false" class="btn btn-tertiary">Cancel</button>
                    <button type="submit" class="btn btn-primary" :disabled="!newRule.cidr">Save Network Rule</button>
                </div>
            </form>
        </div>
    </div>

</div>

@push('scripts')
<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('networkSecurity', () => ({
        isLoading: true,
        globalGeo: 'allow_all',
        geoSearch: '',
        
        modals: { addIpRule: false },
        newRule: { cidr: '', type: 'allow', appliesTo: 'Global', expiry: '', comment: '' },

        ipRules: [],
        geoRules: [],
        aiThreats: { blockVpn: true, travelIncidents: [] },

        init() {
            this.fetchData();
        },

        get filteredGeo() {
            if (!this.geoSearch) return this.geoRules;
            const q = this.geoSearch.toLowerCase();
            return this.geoRules.filter(g => g.name.toLowerCase().includes(q) || g.code.toLowerCase().includes(q));
        },

        async fetchData() {
            this.isLoading = true;
            await new Promise(r => setTimeout(r, 600)); // Simulate API
            
            // Mock IP Rules
            this.ipRules = [
                { id: 1, cidr: '194.23.11.0/24', type: 'allow', appliesTo: 'Admin Panel', expiry: null, comment: 'Dubai Main Office' },
                { id: 2, cidr: '82.11.44.2/32', type: 'allow', appliesTo: 'API Clients', expiry: '2026-05-01 12:00', comment: 'Partner Integration Endpoint (Temp)' },
                { id: 3, cidr: '45.33.22.0/16', type: 'deny', appliesTo: 'Global', expiry: null, comment: 'Known Botnet Range' },
            ];

            // Mock Geo Rules
            this.geoRules = [
                { code: 'AE', name: 'United Arab Emirates', flag: '🇦🇪', status: 'allowed' },
                { code: 'SA', name: 'Saudi Arabia', flag: '🇸🇦', status: 'allowed' },
                { code: 'QA', name: 'Qatar', flag: '🇶🇦', status: 'allowed' },
                { code: 'RU', name: 'Russia', flag: '🇷🇺', status: 'denied' },
                { code: 'KP', name: 'North Korea', flag: '🇰🇵', status: 'denied' },
            ];

            // Mock AI Incidents
            this.aiThreats.travelIncidents = [
                { id: 101, user_id: 42, user: 'Sarah Jenkins', loc1: 'London, UK', time1: '10:00 AM', loc2: 'Dubai, UAE', time2: '10:15 AM', distance: '5,470', duration: 15 }
            ];

            this.isLoading = false;
            this.$nextTick(() => lucide.createIcons());
        },

        // IP Actions
        submitIpRule() {
            // Format expiry for UI
            const formattedExpiry = this.newRule.expiry ? new Date(this.newRule.expiry).toLocaleString() : null;
            
            this.ipRules.unshift({
                id: Date.now(),
                cidr: this.newRule.cidr,
                type: this.newRule.type,
                appliesTo: this.newRule.appliesTo,
                expiry: formattedExpiry,
                comment: this.newRule.comment
            });
            
            this.modals.addIpRule = false;
            this.newRule = { cidr: '', type: 'allow', appliesTo: 'Global', expiry: '', comment: '' };
            this.$nextTick(() => lucide.createIcons());
            alert('IP Rule Added successfully.');
        },

        deleteIpRule(id) {
            if(confirm('Remove this IP rule?')) {
                this.ipRules = this.ipRules.filter(r => r.id !== id);
            }
        },

        // Geo Actions
        updateGlobalGeo(policy) {
            if(confirm(`Change default global routing policy to ${policy.toUpperCase()}?`)) {
                this.globalGeo = policy;
            }
        },

        toggleGeo(code, status) {
            const country = this.geoRules.find(c => c.code === code);
            if(country) {
                country.status = status;
            }
        },

        togglePanicMode() {
            if(confirm("CRITICAL: This will instantly drop all connections originating from outside the UAE. Are you sure?")) {
                this.globalGeo = 'deny_all';
                alert("Panic Mode Activated. Foreign traffic blocked at Gateway.");
            }
        },

        // AI Actions
        freezeAccount(userId) {
            if(confirm('Freeze account and revoke all sessions for this user?')) {
                this.aiThreats.travelIncidents = this.aiThreats.travelIncidents.filter(i => i.user_id !== userId);
                alert('Account frozen. SecOps notified.');
            }
        },

        dismissAlert(id) {
            this.aiThreats.travelIncidents = this.aiThreats.travelIncidents.filter(i => i.id !== id);
        }
    }));
});
</script>
@endpush
@endsection