@extends('layouts.app')

@section('content')
<div class="p-4 sm:p-6 lg:p-8 bg-bg-primary min-h-screen flex flex-col" x-data="authGovernance()">

    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 sm:mb-8 gap-4 shrink-0">
        <div>
            <h1 class="text-h3 sm:text-h2 font-bold tracking-tight text-text-primary flex items-center gap-3">
                <span class="p-2 bg-brand-primary/10 rounded-lg text-brand-primary border border-brand-primary/20">
                    <i data-lucide="shield-check" class="w-5 h-5 sm:w-6 sm:h-6"></i>
                </span>
                Authentication Governance
            </h1>
            <p class="text-text-secondary text-body-sm mt-2">Zero-Trust Identity, Context-Aware Access, and MFA Policies.</p>
        </div>
        <div class="flex gap-3 w-full md:w-auto">
            <button @click="saveSettings()" 
                    :disabled="isSaving"
                    class="btn btn-primary w-full p-2 md:w-auto shadow-sm flex items-center justify-center gap-2 min-w-[140px] disabled:opacity-70">
                <i data-lucide="save" class="w-4 h-4" x-show="!isSaving"></i>
                <i data-lucide="loader-2" class="w-4 h-4 animate-spin" x-show="isSaving" x-cloak></i>
                <span x-text="isSaving ? 'Saving Policies...' : 'Deploy Policies'"></span>
            </button>
        </div>
    </div>

    <div class="grid grid-cols-1 xl:grid-cols-3 gap-6 sm:gap-8">

        <div class="xl:col-span-2 space-y-6 sm:space-y-8">

            <div class="card p-0 overflow-hidden">
                <div class="px-5 sm:px-6 py-4 border-b border-border-default bg-bg-tertiary flex justify-between items-center">
                    <h3 class="text-h4 font-bold text-text-primary flex items-center gap-2">
                        <i data-lucide="key" class="w-5 h-5 text-brand-primary"></i> Identity Providers & Methods
                    </h3>
                </div>
                <div class="p-5 sm:p-6 space-y-5">
                    
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-body-sm font-bold text-text-primary">Email + Password + MFA</p>
                            <p class="text-caption text-text-secondary mt-0.5">Standard secure authentication flow.</p>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer shrink-0">
                            <input type="checkbox" x-model="config.methods.email" class="sr-only peer">
                            <div class="w-11 h-6 bg-bg-muted peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-border-strong after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-brand-primary"></div>
                        </label>
                    </div>

                    <div class="flex items-center justify-between border-t border-border-default pt-4">
                        <div>
                            <p class="text-body-sm font-bold text-text-primary">Phone + OTP + MFA</p>
                            <p class="text-caption text-text-secondary mt-0.5">Passwordless entry for field teams.</p>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer shrink-0">
                            <input type="checkbox" x-model="config.methods.phone" class="sr-only peer">
                            <div class="w-11 h-6 bg-bg-muted peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-border-strong after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-brand-primary"></div>
                        </label>
                    </div>

                    <div class="flex items-center justify-between border-t border-border-default pt-4">
                        <div>
                            <p class="text-body-sm font-bold text-text-primary flex items-center gap-2">Enterprise SSO (SAML/OAuth) <span class="px-1.5 py-0.5 bg-brand-primary/10 text-brand-primary text-[9px] rounded uppercase font-bold">Scale+</span></p>
                            <p class="text-caption text-text-secondary mt-0.5">Azure AD, Okta, Google Workspace.</p>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer shrink-0">
                            <input type="checkbox" x-model="config.methods.sso" class="sr-only peer">
                            <div class="w-11 h-6 bg-bg-muted peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-border-strong after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-brand-primary"></div>
                        </label>
                    </div>

                    <div class="flex items-center justify-between border-t border-border-default pt-4">
                        <div>
                            <p class="text-body-sm font-bold text-text-primary flex items-center gap-2">Hardware Security Keys <span class="px-1.5 py-0.5 bg-semantic-error-bg text-semantic-error border border-semantic-error/20 text-[9px] rounded uppercase font-bold">Internal Admin</span></p>
                            <p class="text-caption text-text-secondary mt-0.5">FIDO2/WebAuthn via YubiKey or biometric enclave.</p>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer shrink-0">
                            <input type="checkbox" x-model="config.methods.hardware" class="sr-only peer">
                            <div class="w-11 h-6 bg-bg-muted peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-border-strong after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-brand-primary"></div>
                        </label>
                    </div>
                </div>
            </div>

            <div class="card p-0 overflow-hidden">
                <div class="px-5 sm:px-6 py-4 border-b border-border-default bg-bg-tertiary flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3">
                    <div>
                        <h3 class="text-h4 font-bold text-text-primary flex items-center gap-2">
                            <i data-lucide="network" class="w-5 h-5 text-brand-primary"></i> Context-Aware Access Matrix
                        </h3>
                        <p class="text-caption text-text-secondary mt-1">Role × Region × Time × Device</p>
                    </div>
                    <button class="btn btn-secondary btn-sm whitespace-nowrap"><i data-lucide="plus" class="w-4 h-4 mr-1"></i> New Policy</button>
                </div>
                
                <div class="overflow-x-auto custom-scrollbar">
                    <table class="w-full text-left border-collapse min-w-[700px]">
                        <thead class="text-caption uppercase text-text-secondary font-semibold bg-bg-primary border-b border-border-strong">
                            <tr>
                                <th class="px-4 py-3">Policy Name</th>
                                <th class="px-4 py-3">Target Role</th>
                                <th class="px-4 py-3">Conditions</th>
                                <th class="px-4 py-3">Status</th>
                                <th class="px-4 py-3 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-border-default bg-bg-secondary">
                            <template x-for="policy in policies" :key="policy.id">
                                <tr class="hover:bg-bg-tertiary transition-colors">
                                    <td class="px-4 py-3 text-body-sm font-bold text-text-primary" x-text="policy.name"></td>
                                    <td class="px-4 py-3"><span class="px-2 py-1 bg-bg-muted border border-border-strong rounded text-[10px] font-mono text-text-primary" x-text="policy.role"></span></td>
                                    <td class="px-4 py-3 text-caption text-text-secondary">
                                        <div class="flex flex-wrap gap-1">
                                            <span class="px-1.5 bg-bg-primary border border-border-default rounded" x-text="'Geo: ' + policy.region"></span>
                                            <span class="px-1.5 bg-bg-primary border border-border-default rounded" x-text="'Time: ' + policy.time"></span>
                                            <span class="px-1.5 bg-bg-primary border border-border-default rounded" x-text="'Dev: ' + policy.device"></span>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3">
                                        <span x-show="policy.active" class="text-semantic-success text-[10px] font-bold uppercase">Active</span>
                                        <span x-show="!policy.active" class="text-text-tertiary text-[10px] font-bold uppercase">Inactive</span>
                                    </td>
                                    <td class="px-4 py-3 text-right">
                                        <button class="text-text-tertiary hover:text-brand-primary p-1"><i data-lucide="edit-2" class="w-4 h-4"></i></button>
                                        <button class="text-text-tertiary hover:text-semantic-error p-1"><i data-lucide="trash-2" class="w-4 h-4"></i></button>
                                    </td>
                                </tr>
                            </template>
                        </tbody>
                    </table>
                </div>

                <div class="p-5 border-t border-border-default bg-bg-primary">
                    <h4 class="text-body-sm font-bold text-text-primary mb-3 flex items-center gap-2"><i data-lucide="play-circle" class="w-4 h-4 text-semantic-info"></i> Policy Simulation Tool</h4>
                    <div class="flex flex-col sm:flex-row items-center gap-3">
                        <select class="form-input text-caption h-9 w-full sm:w-1/3">
                            <option>Finance Admin (UAE, Corp Device)</option>
                            <option>Support Agent (Remote, 2AM)</option>
                        </select>
                        <button @click="simulatePolicy()" class="btn btn-secondary h-9 w-full sm:w-auto px-4 whitespace-nowrap">Run Impact Preview</button>
                        
                        <div x-show="simulation.run" class="flex-1 px-4 py-2 bg-semantic-error-bg border border-semantic-error/30 rounded-md flex items-center gap-2" x-cloak>
                            <i data-lucide="x-circle" class="w-4 h-4 text-semantic-error shrink-0"></i>
                            <span class="text-caption text-semantic-error font-medium" x-text="simulation.result"></span>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <div class="space-y-6 sm:space-y-8">

            <div class="card p-0 overflow-hidden">
                <div class="px-5 py-4 border-b border-border-default bg-bg-tertiary">
                    <h3 class="text-h4 font-bold text-text-primary flex items-center gap-2">
                        <i data-lucide="lock" class="w-5 h-5 text-brand-primary"></i> Password Rules
                    </h3>
                </div>
                <div class="p-5 space-y-5">

                    <div>
                        <label class="block text-body-sm font-bold text-text-primary mb-2">
                            Minimum Length: <span x-text="config.password.length" class="text-brand-primary"></span>
                        </label>
                        <input type="range" x-model="config.password.length" min="8" max="32" 
                               class="w-full h-2 bg-bg-muted rounded-lg appearance-none cursor-pointer accent-brand-primary">
                        <div class="flex justify-between text-[10px] text-text-tertiary mt-1 uppercase font-bold tracking-wider">
                            <span>8 (Weak)</span>
                            <span>16 (Admins)</span>
                            <span>32 (Max)</span>
                        </div>
                    </div>

                    <div class="space-y-3 pt-2">
                        <label class="flex items-start gap-3 cursor-pointer group">
                            <input type="checkbox" x-model="config.password.complexity" class="mt-1 w-4 h-4 rounded border-border-strong text-brand-primary focus:ring-brand-primary/20 bg-transparent transition-colors">
                            <div>
                                <span class="block text-body-sm font-bold text-text-primary group-hover:text-brand-primary transition-colors">Enforce Complexity</span>
                                <span class="block text-caption text-text-secondary mt-0.5">Require upper, lower, number, symbol.</span>
                            </div>
                        </label>

                        <label class="flex items-start gap-3 cursor-pointer group">
                            <input type="checkbox" x-model="config.password.breachCheck" class="mt-1 w-4 h-4 rounded border-border-strong text-brand-primary focus:ring-brand-primary/20 bg-transparent transition-colors">
                            <div>
                                <span class="block text-body-sm font-bold text-text-primary group-hover:text-brand-primary transition-colors">Pwned Database Check</span>
                                <span class="block text-caption text-text-secondary mt-0.5">Block passwords exposed in public breaches.</span>
                            </div>
                        </label>
                        
                        <label class="flex items-start gap-3 cursor-pointer group">
                            <input type="checkbox" x-model="config.password.rotation" class="mt-1 w-4 h-4 rounded border-border-strong text-brand-primary focus:ring-brand-primary/20 bg-transparent transition-colors">
                            <div>
                                <span class="block text-body-sm font-bold text-text-primary group-hover:text-brand-primary transition-colors">Force Rotation (90 Days)</span>
                                <span class="block text-caption text-text-secondary mt-0.5">Mandatory for all Admin roles.</span>
                            </div>
                        </label>
                    </div>

                    <div class="form-group mb-0 border-t border-border-default pt-4">
                        <label class="form-label">Password History Prevention</label>
                        <select x-model="config.password.history" class="form-input w-full text-caption">
                            <option value="0">Do not restrict reuse</option>
                            <option value="5">Remember last 5 passwords</option>
                            <option value="12">Remember last 12 passwords</option>
                        </select>
                    </div>

                    <div class="pt-4 border-t border-border-default space-y-2">
                        <button class="btn btn-secondary text-text-primary w-full text-xs flex justify-center"><i data-lucide="file-text" class="w-3.5 h-3.5 mr-2"></i> Export Compliance Report</button>
                        <button class="btn btn-secondary text-semantic-error border-semantic-error/30 hover:bg-semantic-error hover:text-white w-full text-xs flex justify-center transition-colors"><i data-lucide="alert-triangle" class="w-3.5 h-3.5 mr-2"></i> Enforce Global Reset</button>
                    </div>
                </div>
            </div>

            <div class="card p-0 overflow-hidden border-brand-primary/20">
                <div class="px-5 py-4 border-b border-border-default bg-brand-primary/5">
                    <h3 class="text-h4 font-bold text-brand-primary flex items-center gap-2">
                        <i data-lucide="shield-alert" class="w-5 h-5"></i> MFA & AI Shield
                    </h3>
                </div>
                <div class="p-5 space-y-6">

                    <label class="flex items-start gap-3 cursor-pointer p-3 bg-bg-tertiary border border-border-default rounded-lg group">
                        <input type="checkbox" x-model="config.mfa.aiStepUp" class="mt-1 w-4 h-4 rounded border-border-strong text-brand-primary focus:ring-brand-primary/20 bg-bg-primary transition-colors">
                        <div>
                            <span class="block text-body-sm font-bold text-text-primary flex items-center gap-1">AI Step-Up MFA <i data-lucide="sparkles" class="w-3 h-3 text-purple-500"></i></span>
                            <span class="block text-caption text-text-secondary mt-0.5">Trigger extra MFA challenge on anomalous behavior or high risk score.</span>
                        </div>
                    </label>

                    <div class="form-group mb-0">
                        <label class="form-label">Global Enforcement</label>
                        <select x-model="config.mfa.enforcement" class="form-input w-full">
                            <option value="admins_only">Strict (Admins Only)</option>
                            <option value="all">Strict (All Platform Users)</option>
                            <option value="adaptive">Adaptive (Risk-Based)</option>
                        </select>
                    </div>

                    <div>
                        <p class="text-label text-text-secondary mb-3">Allowed Factors</p>
                        <div class="space-y-3">
                            <div class="flex items-center justify-between">
                                <span class="text-body-sm font-semibold text-text-primary flex items-center gap-2"><i data-lucide="smartphone" class="w-4 h-4 text-text-tertiary"></i> Authenticator (TOTP)</span>
                                <span class="text-[10px] font-bold text-text-tertiary uppercase bg-bg-muted px-2 py-0.5 rounded">Required</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-body-sm font-semibold text-text-primary flex items-center gap-2"><i data-lucide="usb" class="w-4 h-4 text-text-tertiary"></i> Hardware Keys (FIDO2)</span>
                                <input type="checkbox" x-model="config.mfa.methods.hardware" class="w-4 h-4 rounded border-border-strong text-brand-primary focus:ring-brand-primary/20 bg-bg-primary cursor-pointer">
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-body-sm font-semibold text-text-primary flex items-center gap-2"><i data-lucide="mail" class="w-4 h-4 text-text-tertiary"></i> Email OTP</span>
                                <input type="checkbox" x-model="config.mfa.methods.email" class="w-4 h-4 rounded border-border-strong text-brand-primary focus:ring-brand-primary/20 bg-bg-primary cursor-pointer">
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-body-sm font-semibold text-text-primary flex items-center gap-2"><i data-lucide="message-square" class="w-4 h-4 text-text-tertiary"></i> SMS OTP (Backup)</span>
                                <input type="checkbox" x-model="config.mfa.methods.sms" class="w-4 h-4 rounded border-border-strong text-brand-primary focus:ring-brand-primary/20 bg-bg-primary cursor-pointer">
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-body-sm font-semibold text-text-primary flex items-center gap-2"><i data-lucide="files" class="w-4 h-4 text-text-tertiary"></i> Static Backup Codes</span>
                                <input type="checkbox" x-model="config.mfa.methods.backupCodes" class="w-4 h-4 rounded border-border-strong text-brand-primary focus:ring-brand-primary/20 bg-bg-primary cursor-pointer">
                            </div>
                        </div>
                    </div>

                    <div class="pt-4 border-t border-border-default">
                        <label class="flex items-start gap-3 cursor-pointer group">
                            <input type="checkbox" x-model="config.mfa.actionBased" class="mt-1 w-4 h-4 rounded border-border-strong text-brand-primary focus:ring-brand-primary/20 bg-transparent transition-colors">
                            <div>
                                <span class="block text-body-sm font-bold text-text-primary group-hover:text-brand-primary transition-colors">Action-Based MFA</span>
                                <span class="block text-caption text-text-secondary mt-0.5">Require re-authentication for high-risk actions (Refunds, API Keys, Payouts).</span>
                            </div>
                        </label>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('authGovernance', () => ({
            isSaving: false,
            
             
            simulation: { run: false, result: '' },
            
             
            policies: [
                { id: 1, name: 'Strict Finance Access', role: 'Finance Admin', region: 'UAE Only', time: '9AM - 6PM', device: 'Corp Managed', active: true },
                { id: 2, name: 'Support Remote Access', role: 'Support Agent', region: 'Global', time: 'Any', device: 'Verified', active: true },
                { id: 3, name: 'Offshore Dev Lock', role: 'Developer', region: 'VPN Only', time: 'Any', device: 'Any', active: false },
            ],

             
            config: {
                methods: { email: true, phone: true, sso: false, hardware: true },
                password: {
                    length: 16,
                    complexity: true,
                    breachCheck: true,
                    rotation: true,
                    history: '12'
                },
                mfa: {
                    enforcement: 'admins_only',
                    aiStepUp: true,
                    actionBased: true,
                    methods: {
                        totp: true,  
                        hardware: true,
                        email: false,
                        sms: false,
                        backupCodes: true
                    }
                }
            },

            simulatePolicy() {
                this.simulation.run = false;
                setTimeout(() => {
                    this.simulation.result = 'DENIED: Context mismatch (Time restriction)';
                    this.simulation.run = true;
                    setTimeout(() => lucide.createIcons(), 10);
                }, 400);
            },

            async saveSettings() {
                this.isSaving = true;
                setTimeout(() => lucide.createIcons(), 10);  
                
                try {
                     
                    await new Promise(r => setTimeout(r, 1200));

                    alert("Enterprise Authentication Policies deployed successfully.");
                } catch (error) {
                    console.error("Save Error:", error);
                    alert("Failed to deploy policies. Check API logs.");
                } finally {
                    this.isSaving = false;
                    setTimeout(() => lucide.createIcons(), 50); 
                }
            }
        }));
    });
</script>
@endpush
@endsection