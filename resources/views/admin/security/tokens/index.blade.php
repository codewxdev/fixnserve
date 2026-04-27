@extends('layouts.app')

@section('title', 'Token & API Management')

@section('content')
<div class="p-4 sm:p-6 lg:p-8 bg-bg-primary min-h-screen flex flex-col" x-data="tokenManagement()">

    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 sm:mb-8 gap-4 shrink-0">
        <div>
            <h1 class="text-h3 sm:text-h2 font-bold tracking-tight text-text-primary flex items-center gap-3">
                <span class="p-2 bg-brand-primary/10 rounded-lg text-brand-primary border border-brand-primary/20">
                    <i data-lucide="key" class="w-5 h-5 sm:w-6 sm:h-6"></i>
                </span>
                Token Management
            </h1>
            <p class="text-text-secondary text-body-sm mt-2">Manage session tokens, device binding, and external API integrations.</p>
        </div>
        
        <div class="flex items-center gap-3 w-full md:w-auto">
            <button x-show="activeTab === 'apikeys'" @click="modals.generateKey = true" class="btn btn-primary w-full md:w-auto flex justify-center items-center gap-2" x-cloak>
                <i data-lucide="plus" class="w-4 h-4"></i> Generate API Key
            </button>
            <button x-show="activeTab === 'tokens'" @click="savePolicy()" class="btn btn-primary w-full md:w-auto p-2 flex justify-center items-center gap-2" :disabled="isSaving">
                <i data-lucide="save" class="w-4 h-4" x-show="!isSaving"></i>
                <i data-lucide="loader-2" class="w-4 h-4 animate-spin" x-show="isSaving" x-cloak></i>
                <span x-text="isSaving ? 'Saving...' : 'Update Policy'"></span>
            </button>
        </div>
    </div>

    <div class="flex border-b border-border-default mb-6">
        <button @click="activeTab = 'tokens'" :class="activeTab === 'tokens' ? 'border-brand-primary text-brand-primary' : 'border-transparent text-text-secondary hover:text-text-primary hover:border-border-strong'" class="pb-3 px-4 text-body-sm font-bold uppercase tracking-wider border-b-2 transition-colors">
            Access & Refresh Tokens
        </button>
        <button @click="activeTab = 'apikeys'" :class="activeTab === 'apikeys' ? 'border-brand-primary text-brand-primary' : 'border-transparent text-text-secondary hover:text-text-primary hover:border-border-strong'" class="pb-3 px-4 text-body-sm font-bold uppercase tracking-wider border-b-2 transition-colors">
            Integration API Keys
        </button>
    </div>

    <div x-show="activeTab === 'tokens'" class="space-y-6" x-transition.opacity>
        
        <div class="card p-0 overflow-hidden">
            <div class="px-5 sm:px-6 py-4 border-b border-border-default bg-bg-tertiary flex justify-between items-center">
                <h3 class="text-body font-bold text-text-primary flex items-center gap-2">
                    <i data-lucide="shield" class="w-4 h-4 text-brand-primary"></i> Global Session Policy
                </h3>
            </div>
            <div class="p-5 sm:p-6 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                
                <div class="form-group mb-0">
                    <label class="form-label">Access Token TTL</label>
                    <div class="relative">
                        <input type="number" x-model="policy.accessTtl" class="form-input w-full pl-3 pr-12">
                        <span class="absolute right-3 top-2 text-text-tertiary text-body-sm">min</span>
                    </div>
                </div>

                <div class="form-group mb-0">
                    <label class="form-label">Refresh Token TTL</label>
                    <div class="relative">
                        <input type="number" x-model="policy.refreshTtl" class="form-input w-full pl-3 pr-12">
                        <span class="absolute right-3 top-2 text-text-tertiary text-body-sm">days</span>
                    </div>
                </div>

                <div class="space-y-3 lg:col-span-2">
                    <label class="flex items-center gap-3 cursor-pointer group">
                        <input type="checkbox" x-model="config.deviceBinding" class="w-4 h-4 rounded border-border-strong text-brand-primary focus:ring-brand-primary/20 bg-bg-primary transition-colors">
                        <div>
                            <span class="block text-body-sm font-bold text-text-primary group-hover:text-brand-primary transition-colors">Enforce Device Binding</span>
                            <span class="block text-caption text-text-secondary mt-0.5">Tokens are invalidated if device fingerprint changes.</span>
                        </div>
                    </label>
                    
                    <label class="flex items-center gap-3 cursor-pointer group">
                        <input type="checkbox" x-model="config.roleBinding" class="w-4 h-4 rounded border-border-strong text-brand-primary focus:ring-brand-primary/20 bg-bg-primary transition-colors">
                        <div>
                            <span class="block text-body-sm font-bold text-text-primary group-hover:text-brand-primary transition-colors">Strict Role Binding</span>
                            <span class="block text-caption text-text-secondary mt-0.5">Tokens auto-revoke immediately if RBAC roles are modified.</span>
                        </div>
                    </label>
                </div>
            </div>
        </div>

        <div class="card p-0 overflow-hidden flex flex-col">
            <div class="px-5 sm:px-6 py-4 border-b border-border-default bg-bg-tertiary flex justify-between items-center">
                <h3 class="text-body font-bold text-text-primary">Active Refresh Tokens</h3>
            </div>
            <div class="overflow-x-auto custom-scrollbar">
                <table class="w-full text-left min-w-[800px]">
                    <thead class="text-caption uppercase text-text-secondary font-semibold bg-bg-primary border-b border-border-strong">
                        <tr>
                            <th class="px-5 py-3">Identity / Device</th>
                            <th class="px-5 py-3">Scopes & Binding</th>
                            <th class="px-5 py-3">Lifecycle</th>
                            <th class="px-5 py-3 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-border-default bg-bg-secondary">
                        <template x-for="token in accessTokens" :key="token.id">
                            <tr class="hover:bg-bg-tertiary transition-colors">
                                <td class="px-5 py-4">
                                    <div class="font-bold text-text-primary text-body-sm" x-text="token.user"></div>
                                    <div class="font-mono text-[10px] text-text-secondary mt-1 flex items-center gap-2">
                                        <span class="bg-bg-primary border border-border-strong px-1.5 py-0.5 rounded" x-text="'ID: ' + token.id"></span>
                                        <span class="text-text-tertiary" x-text="token.device"></span>
                                    </div>
                                </td>
                                <td class="px-5 py-4">
                                    <div class="flex flex-wrap gap-1.5">
                                        <span class="px-2 py-0.5 rounded bg-bg-primary text-text-secondary text-[10px] border border-border-default font-mono" x-text="'Role: ' + token.role"></span>
                                        <span x-show="token.deviceBound" class="px-2 py-0.5 rounded bg-blue-500/10 text-blue-500 border border-blue-500/20 text-[10px] font-bold"><i data-lucide="lock" class="w-3 h-3 inline"></i> Bound</span>
                                    </div>
                                </td>
                                <td class="px-5 py-4">
                                    <div class="text-body-sm text-text-primary" x-text="token.expires"></div>
                                    <div class="text-caption" :class="token.isExpiring ? 'text-semantic-error font-bold' : 'text-text-tertiary'" x-text="token.timeUntil"></div>
                                </td>
                                <td class="px-5 py-4 text-right">
                                    <div class="flex justify-end gap-2">
                                        <button @click="viewMetadata(token)" class="btn btn-sm btn-secondary text-xs" title="Metadata"><i data-lucide="eye" class="w-4 h-4"></i></button>
                                        <button @click="rotateToken(token.id)" class="btn btn-sm btn-secondary text-brand-primary border-brand-primary/30 hover:bg-brand-primary hover:text-white text-xs" title="Rotate">Rotate</button>
                                        <button @click="openExtendModal(token)" class="btn btn-sm btn-secondary text-semantic-info border-semantic-info/30 hover:bg-semantic-info hover:text-white text-xs" title="Extend TTL">Extend</button>
                                        <button @click="revokeToken(token.id)" class="btn btn-sm btn-destructive text-xs" title="Revoke"><i data-lucide="trash-2" class="w-4 h-4"></i></button>
                                    </div>
                                </td>
                            </tr>
                        </template>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div x-show="activeTab === 'apikeys'" class="space-y-6" x-transition.opacity x-cloak>
        <div class="card p-0 overflow-hidden flex flex-col">
            <div class="px-5 sm:px-6 py-4 border-b border-border-default bg-bg-tertiary flex justify-between items-center">
                <h3 class="text-body font-bold text-text-primary">Integration API Keys</h3>
            </div>
            <div class="overflow-x-auto custom-scrollbar">
                <table class="w-full text-left min-w-[900px]">
                    <thead class="text-caption uppercase text-text-secondary font-semibold bg-bg-primary border-b border-border-strong">
                        <tr>
                            <th class="px-5 py-3">Key Name / Env</th>
                            <th class="px-5 py-3">Prefix / Identifier</th>
                            <th class="px-5 py-3">Permissions & Limits</th>
                            <th class="px-5 py-3">Expiration</th>
                            <th class="px-5 py-3 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-border-default bg-bg-secondary">
                        <template x-for="key in apiKeys" :key="key.id">
                            <tr class="hover:bg-bg-tertiary transition-colors">
                                <td class="px-5 py-4">
                                    <div class="font-bold text-text-primary text-body-sm" x-text="key.name"></div>
                                    <span class="inline-block mt-1 px-1.5 py-0.5 rounded text-[9px] font-bold uppercase tracking-wider border"
                                          :class="key.env === 'live' ? 'bg-semantic-success-bg text-semantic-success border-semantic-success/20' : 'bg-semantic-warning-bg text-semantic-warning border-semantic-warning/20'"
                                          x-text="key.env"></span>
                                </td>
                                <td class="px-5 py-4 font-mono text-xs text-text-secondary" x-text="key.prefix"></td>
                                <td class="px-5 py-4">
                                    <div class="flex flex-wrap gap-1 mb-1.5">
                                        <template x-for="scope in key.scopes">
                                            <span class="px-2 py-0.5 rounded-full bg-bg-primary border border-border-default text-text-secondary text-[10px]" x-text="scope"></span>
                                        </template>
                                    </div>
                                    <div class="text-[10px] text-text-tertiary" x-text="'Rate Limit: ' + key.rateLimit + ' req/min'"></div>
                                </td>
                                <td class="px-5 py-4 text-body-sm text-text-primary" x-text="key.expiry || 'Never'"></td>
                                <td class="px-5 py-4 text-right">
                                    <div class="flex justify-end gap-2">
                                        <button @click="viewLogs(key.id)" class="btn btn-sm btn-secondary text-xs" title="Usage Logs"><i data-lucide="activity" class="w-4 h-4"></i></button>
                                        <button @click="rotateApiKey(key.id)" class="btn btn-sm btn-secondary text-brand-primary border-brand-primary/30 hover:bg-brand-primary hover:text-white text-xs">Rotate</button>
                                        <button @click="revokeApiKey(key.id)" class="btn btn-sm btn-destructive text-xs"><i data-lucide="trash-2" class="w-4 h-4"></i></button>
                                    </div>
                                </td>
                            </tr>
                        </template>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div x-show="modals.metadata" class="fixed inset-0 z-50 flex items-center justify-center bg-brand-secondary/80 backdrop-blur-sm p-4" x-cloak>
        <div class="card w-full max-w-md p-0 shadow-2xl" @click.away="modals.metadata = false">
            <div class="p-5 border-b border-border-default bg-bg-tertiary flex justify-between items-center rounded-t-lg">
                <h3 class="text-h4 font-bold text-text-primary">Token Metadata</h3>
                <button @click="modals.metadata = false" class="text-text-tertiary"><i data-lucide="x" class="w-5 h-5"></i></button>
            </div>
            <div class="p-6 space-y-4">
                <div class="bg-bg-secondary p-3 rounded border border-border-default">
                    <span class="text-caption text-text-secondary block">Bound Device Hash</span>
                    <span class="font-mono text-body-sm text-text-primary break-all" x-text="selectedToken?.fingerprint || 'N/A'"></span>
                </div>
                <div class="bg-bg-secondary p-3 rounded border border-border-default">
                    <span class="text-caption text-text-secondary block">IP Address</span>
                    <span class="font-mono text-body-sm text-text-primary" x-text="selectedToken?.ip || 'N/A'"></span>
                </div>
            </div>
        </div>
    </div>

    <div x-show="modals.extendTtl" class="fixed inset-0 z-50 flex items-center justify-center bg-brand-secondary/80 backdrop-blur-sm p-4" x-cloak>
        <div class="card w-full max-w-md p-0 shadow-2xl" @click.away="modals.extendTtl = false">
            <div class="p-5 border-b border-border-default bg-bg-tertiary flex justify-between items-center rounded-t-lg">
                <h3 class="text-h4 font-bold text-text-primary">Extend Token TTL</h3>
                <button @click="modals.extendTtl = false" class="text-text-tertiary"><i data-lucide="x" class="w-5 h-5"></i></button>
            </div>
            <div class="p-6 space-y-4">
                <div class="p-3 bg-semantic-warning-bg border border-semantic-warning/30 rounded text-caption text-text-primary">
                    <i data-lucide="shield-alert" class="w-4 h-4 text-semantic-warning inline mr-1"></i> Extending session TTL bypasses standard security rotation. This action requires approval.
                </div>
                <div class="form-group mb-0">
                    <label class="form-label">Extension Duration (Days)</label>
                    <input type="number" class="form-input w-full" x-model="extendData.days" min="1" max="30">
                </div>
                <div class="form-group mb-0">
                    <label class="form-label">Justification</label>
                    <textarea class="form-input w-full h-20" x-model="extendData.reason" placeholder="Reason for extension..."></textarea>
                </div>
            </div>
            <div class="p-4 border-t border-border-default flex justify-end gap-3 rounded-b-lg bg-bg-tertiary">
                <button @click="modals.extendTtl = false" class="btn btn-tertiary">Cancel</button>
                <button @click="submitExtendRequest()" class="btn btn-primary" :disabled="!extendData.reason">Request Approval</button>
            </div>
        </div>
    </div>

    <div x-show="modals.generateKey" class="fixed inset-0 z-50 flex items-center justify-center bg-brand-secondary/80 backdrop-blur-sm p-4" x-cloak>
        <div class="card w-full max-w-lg p-0 shadow-2xl" @click.away="modals.generateKey = false">
            <div class="p-5 border-b border-border-default bg-bg-tertiary flex justify-between items-center rounded-t-lg">
                <h3 class="text-h4 font-bold text-text-primary">Generate API Key</h3>
                <button @click="modals.generateKey = false" class="text-text-tertiary"><i data-lucide="x" class="w-5 h-5"></i></button>
            </div>
            <div class="p-6 space-y-4 max-h-[70vh] overflow-y-auto custom-scrollbar">
                
                <div class="grid grid-cols-2 gap-4">
                    <div class="form-group mb-0">
                        <label class="form-label">Key Name</label>
                        <input type="text" class="form-input w-full" x-model="newKey.name" placeholder="e.g., Zapier Integration">
                    </div>
                    <div class="form-group mb-0">
                        <label class="form-label">Environment</label>
                        <select class="form-input w-full" x-model="newKey.env">
                            <option value="test">Test (Sandbox)</option>
                            <option value="live">Live (Production)</option>
                        </select>
                    </div>
                </div>

                <div class="form-group mb-0">
                    <label class="form-label">Expiration</label>
                    <select class="form-input w-full" x-model="newKey.expiry">
                        <option value="30">30 Days</option>
                        <option value="90">90 Days</option>
                        <option value="365">1 Year</option>
                        <option value="never">Never Expire</option>
                    </select>
                </div>

                <div class="form-group mb-0">
                    <label class="form-label">Scopes / Permissions</label>
                    <div class="space-y-2 p-3 border border-border-default rounded-lg bg-bg-secondary">
                        <label class="flex items-center gap-2 cursor-pointer"><input type="checkbox" class="rounded border-border-strong text-brand-primary focus:ring-brand-primary/20 bg-bg-primary"> <span class="text-body-sm text-text-primary">jobs:read</span></label>
                        <label class="flex items-center gap-2 cursor-pointer"><input type="checkbox" class="rounded border-border-strong text-brand-primary focus:ring-brand-primary/20 bg-bg-primary"> <span class="text-body-sm text-text-primary">jobs:write</span></label>
                        <label class="flex items-center gap-2 cursor-pointer"><input type="checkbox" class="rounded border-border-strong text-brand-primary focus:ring-brand-primary/20 bg-bg-primary"> <span class="text-body-sm text-text-primary">businesses:read</span></label>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div class="form-group mb-0">
                        <label class="form-label">Rate Limit (req/min)</label>
                        <input type="number" class="form-input w-full" x-model="newKey.rateLimit">
                    </div>
                    <div class="form-group mb-0">
                        <label class="form-label">IP Whitelist (Optional)</label>
                        <input type="text" class="form-input w-full" placeholder="e.g., 192.168.1.1">
                    </div>
                </div>
            </div>
            <div class="p-4 border-t border-border-default flex justify-end gap-3 rounded-b-lg bg-bg-tertiary">
                <button @click="modals.generateKey = false" class="btn btn-tertiary">Cancel</button>
                <button @click="createApiKey()" class="btn btn-primary" :disabled="!newKey.name">Generate Secret</button>
            </div>
        </div>
    </div>

    <div x-show="modals.showSecret" class="fixed inset-0 z-[60] flex items-center justify-center bg-brand-secondary/90 backdrop-blur-sm p-4" x-cloak>
        <div class="card w-full max-w-lg p-0 shadow-2xl border-semantic-success">
            <div class="p-6 text-center space-y-4">
                <div class="w-12 h-12 rounded-full bg-semantic-success-bg text-semantic-success flex items-center justify-center mx-auto mb-2">
                    <i data-lucide="check-circle" class="w-6 h-6"></i>
                </div>
                <h3 class="text-h3 font-bold text-text-primary">API Key Generated</h3>
                <p class="text-body-sm text-text-secondary">Copy this secret key now. <strong class="text-semantic-error">It will never be shown again.</strong></p>
                
                <div class="flex items-center gap-2 bg-bg-tertiary border border-border-strong p-2 rounded-lg">
                    <input type="text" readonly :value="generatedSecret" class="bg-transparent border-none text-text-primary font-mono text-sm w-full focus:ring-0" id="secretKeyInput">
                    <button @click="copySecret()" class="btn btn-sm btn-secondary shrink-0"><i data-lucide="copy" class="w-4 h-4"></i> Copy</button>
                </div>
            </div>
            <div class="p-4 border-t border-border-default flex justify-center rounded-b-lg bg-bg-tertiary">
                <button @click="modals.showSecret = false" class="btn btn-primary w-full">I have copied it securely</button>
            </div>
        </div>
    </div>

</div>

@push('scripts')
<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('tokenManagement', () => ({
        activeTab: 'tokens',
        isSaving: false,
        
        // Configs
        policy: { accessTtl: 15, refreshTtl: 7 },
        config: { deviceBinding: true, roleBinding: true },

        // Modals & State
        modals: { metadata: false, extendTtl: false, generateKey: false, showSecret: false },
        selectedToken: null,
        extendData: { days: 7, reason: '' },
        newKey: { name: '', env: 'test', expiry: '30', rateLimit: 60 },
        generatedSecret: '',

        // Mock Data
        accessTokens: [
            { id: '8a7f9c21', user: 'Sarah Jenkins', role: 'Finance Admin', device: 'iOS App v2.1', fingerprint: 'fx92_88a', deviceBound: true, ip: '194.23.11.9', expires: 'Feb 10, 2026', timeUntil: 'Expires in 28 days', isExpiring: false },
            { id: '3b2x1z99', user: 'Tariq Al Fasi', role: 'Operations', device: 'Chrome / macOS', fingerprint: 'm_44b99', deviceBound: true, ip: '82.11.44.2', expires: 'Jan 22, 2026', timeUntil: 'Expires tomorrow', isExpiring: true }
        ],

        apiKeys: [
            { id: 'k1', name: 'Stripe Webhook Sync', env: 'live', prefix: 'sk_live_9a8B...', scopes: ['payments:write'], rateLimit: 1000, expiry: null },
            { id: 'k2', name: 'Zapier Integration', env: 'test', prefix: 'sk_test_4m2X...', scopes: ['jobs:read', 'businesses:read'], rateLimit: 60, expiry: 'Mar 01, 2026' }
        ],

        // --- Methods ---
        async savePolicy() {
            this.isSaving = true;
            setTimeout(() => lucide.createIcons(), 10);
            await new Promise(r => setTimeout(r, 800)); // Simulate API
            this.isSaving = false;
            alert("✅ Policy updated.");
        },

        viewMetadata(token) {
            this.selectedToken = token;
            this.modals.metadata = true;
        },

        openExtendModal(token) {
            this.selectedToken = token;
            this.extendData = { days: 7, reason: '' };
            this.modals.extendTtl = true;
        },

        submitExtendRequest() {
            this.modals.extendTtl = false;
            alert("Extension request submitted for dual approval.");
        },

        rotateToken(id) {
            if(confirm('Rotate token? The existing token will be invalidated immediately.')) {
                alert(`Token ${id} rotated.`);
            }
        },

        revokeToken(id) {
            if(confirm('Revoke token? This will end the session immediately.')) {
                alert(`Token ${id} revoked.`);
            }
        },

        createApiKey() {
            this.modals.generateKey = false;
            // Simulate generation
            this.generatedSecret = this.newKey.env === 'live' 
                ? 'sk_live_' + Math.random().toString(36).substr(2, 24) 
                : 'sk_test_' + Math.random().toString(36).substr(2, 24);
            
            this.modals.showSecret = true;
            this.newKey = { name: '', env: 'test', expiry: '30', rateLimit: 60 }; // reset
        },

        copySecret() {
            const input = document.getElementById('secretKeyInput');
            input.select();
            document.execCommand('copy');
            alert('Copied to clipboard!');
        },

        rotateApiKey(id) {
            if(confirm('Rotate API Key? Any integrations using the old key will break instantly.')) {
                alert(`Key rotated. Please update your integrations.`);
            }
        },

        revokeApiKey(id) {
            if(confirm('Revoke API Key? This action cannot be undone.')) {
                alert(`Key ${id} revoked.`);
            }
        },

        viewLogs(id) {
            alert(`Opening API usage logs for key ${id}...`);
        }
    }));
});
</script>
@endpush
@endsection