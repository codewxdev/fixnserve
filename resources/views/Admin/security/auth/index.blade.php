@extends('layouts.app')

@section('title', 'Authentication Governance')

@section('content')
    <div class="min-h-screen theme-bg-body theme-text-main max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
            <div>
                <h1 class="text-2xl font-bold theme-text-main">Authentication Governance</h1>
                <p class="theme-text-muted mt-1">Define how users identify themselves and access SahorOne.</p>
            </div>
            <div class="flex gap-3">
                {{-- <button type="button" class="flex items-center gap-2 px-4 py-2 theme-bg-card border theme-border rounded-lg text-sm font-medium hover:bg-white/5 theme-text-muted transition-colors">
                    <i data-lucide="play-circle" class="w-4 h-4"></i> 
                    <span>Simulate Policy</span>
                </button> --}}
                
                {{-- SAVE BUTTON: Calls JS function --}}
                <button type="button" onclick="saveSettings()" id="save-btn"
                    class="flex items-center gap-2 px-4 py-2 text-white rounded-lg text-sm font-medium hover:opacity-90 shadow-sm transition-colors"
                    style="background-color: rgb(var(--brand-primary)); box-shadow: 0 4px 10px rgba(var(--brand-primary), 0.3);">
                    <i data-lucide="save" class="w-4 h-4"></i> 
                    <span>Save Changes</span>
                </button>
            </div>
        </div>

        <form id="auth-settings-form" onsubmit="event.preventDefault(); saveSettings();">
            
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                <div class="lg:col-span-2 space-y-6">
                    
                    {{-- 1. LOGIN METHODS --}}
                    <div class="theme-bg-card rounded-xl shadow-sm border theme-border overflow-hidden">
                        <div class="px-6 py-4 border-b theme-border flex justify-between items-center" style="background-color: rgba(var(--bg-body), 0.5);">
                            <h3 class="font-semibold theme-text-main flex items-center gap-2">
                                <i data-lucide="log-in" class="w-4 h-4" style="color: rgb(var(--brand-primary));"></i> Login Methods
                            </h3>
                            <span class="px-2 py-1 bg-green-500/10 text-green-500 border border-green-500/20 text-xs font-bold rounded">ACTIVE</span>
                        </div>
                        <div class="p-6 space-y-6">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="font-medium theme-text-main">Email + Password</p>
                                    <p class="text-sm theme-text-muted">Standard authentication flow</p>
                                </div>
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" id="lm_email" checked class="sr-only peer toggle-checkbox">
                                    <div class="toggle-bg w-11 h-6 bg-gray-600/30 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all"></div>
                                </label>
                            </div>

                            <div class="flex items-center justify-between border-t theme-border pt-4">
                                <div>
                                    <p class="font-medium theme-text-main">Phone + OTP</p>
                                    <p class="text-sm theme-text-muted">Secure passwordless entry</p>
                                </div>
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" id="lm_phone" class="sr-only peer toggle-checkbox">
                                    <div class="toggle-bg w-11 h-6 bg-gray-600/30 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all"></div>
                                </label>
                            </div>

                            <div class="flex items-center justify-between border-t theme-border pt-4">
                                <div>
                                    <p class="font-medium theme-text-main">OAuth (Google/Apple)</p>
                                    <p class="text-sm theme-text-muted">Third-party identity providers</p>
                                </div>
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" id="lm_oauth" class="sr-only peer toggle-checkbox">
                                    <div class="toggle-bg w-11 h-6 bg-gray-600/30 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all"></div>
                                </label>
                            </div>

                            <div class="mt-6 p-4 rounded-lg border theme-border theme-bg-body">
                                <h4 class="text-sm font-semibold theme-text-main mb-3">Login Restrictions</h4>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-xs font-medium theme-text-muted mb-1">Restricted Roles</label>
                                        <select id="lr_role" class="w-full theme-bg-card border theme-border theme-text-main text-sm rounded-lg focus:ring-2 focus:ring-blue-500 block p-2.5">
                                            <option value="Super Admin">Super Admin</option>
                                            <option value="Admin">Admin</option>
                                            <option value="User">User</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label class="block text-xs font-medium theme-text-muted mb-1">Time Window Enforcement</label>
                                        <div class="flex gap-2">
                                            <input type="time" id="lr_start" value="00:00" class="w-full theme-bg-card border theme-border theme-text-main text-sm rounded-lg p-2.5">
                                            <span class="self-center theme-text-muted">-</span>
                                            <input type="time" id="lr_end" value="23:59" class="w-full theme-bg-card border theme-border theme-text-main text-sm rounded-lg p-2.5">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- 2. PASSWORD RULES --}}
                    <div class="theme-bg-card rounded-xl shadow-sm border theme-border overflow-hidden">
                        <div class="px-6 py-4 border-b theme-border" style="background-color: rgba(var(--bg-body), 0.5);">
                            <h3 class="font-semibold theme-text-main flex items-center gap-2">
                                <i data-lucide="lock" class="w-4 h-4" style="color: rgb(var(--brand-primary));"></i> Password Rules
                            </h3>
                        </div>
                        <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                            
                            <div class="col-span-1 md:col-span-2">
                                <label class="block text-sm font-medium theme-text-main mb-2">
                                    Minimum Length: <span id="len-val" class="font-bold" style="color: rgb(var(--brand-primary));">12</span> characters
                                </label>
                                <input type="range" id="pr_min_len" min="8" max="32" value="12" 
                                    class="w-full h-2 bg-gray-600/30 rounded-lg appearance-none cursor-pointer accent-brand"
                                    oninput="document.getElementById('len-val').innerText = this.value">
                                <div class="flex justify-between text-xs theme-text-muted mt-1">
                                    <span>8 (Weak)</span>
                                    <span>32 (Paranoid)</span>
                                </div>
                            </div>

                            <div class="space-y-3">
                                <label class="flex items-center space-x-3">
                                    <input type="checkbox" id="pr_uppercase" checked class="w-4 h-4 rounded border-gray-300 focus:ring-2 checkbox-brand">
                                    <span class="text-sm theme-text-main">Require Uppercase & Symbols</span>
                                </label>
                                <label class="flex items-center space-x-3">
                                    <input type="checkbox" id="pr_symbols" checked class="w-4 h-4 rounded border-gray-300 focus:ring-2 checkbox-brand">
                                    <span class="text-sm theme-text-main">Require Symbols</span>
                                </label>
                            </div>

                            <div class="space-y-3">
                                <label class="flex items-center space-x-3">
                                    <input type="checkbox" id="pr_reuse" checked class="w-4 h-4 rounded border-gray-300 focus:ring-2 checkbox-brand">
                                    <span class="text-sm theme-text-main">Prevent Password Reuse</span>
                                </label>
                                <label class="flex items-center space-x-3">
                                    <input type="checkbox" id="pr_breach" checked class="w-4 h-4 rounded border-gray-300 focus:ring-2 checkbox-brand">
                                    <span class="text-sm theme-text-main">Check against Leaked DB (HIBP)</span>
                                </label>
                                <label class="flex items-center space-x-3">
                                    <input type="checkbox" id="pr_rotation" class="w-4 h-4 rounded border-gray-300 focus:ring-2 checkbox-brand">
                                    <span class="text-sm theme-text-main">Force Rotation every 90 days</span>
                                </label>
                            </div>
                            
                            {{-- <div class="col-span-1 md:col-span-2 border-t theme-border pt-4 mt-2">
                                <button type="button" class="text-sm text-red-500 hover:text-red-400 font-medium flex items-center gap-1 transition-colors">
                                    <i data-lucide="alert-triangle" class="w-3 h-3"></i> 
                                    <span>Force Password Reset for All Users</span>
                                </button>
                            </div> --}}
                        </div>
                    </div>

                </div>

                <div class="space-y-6">
                    
                    {{-- 3. MFA SETTINGS --}}
                    <div class="theme-bg-card rounded-xl shadow-sm border theme-border overflow-hidden">
                        <div class="px-6 py-4 border-b theme-border" style="background-color: rgba(var(--brand-primary), 0.1);">
                            <h3 class="font-semibold flex items-center gap-2" style="color: rgb(var(--brand-primary));">
                                <i data-lucide="shield-check" class="w-4 h-4"></i> Multi-Factor Auth (MFA)
                            </h3>
                        </div>
                        <div class="p-6 space-y-4">
                            
                            <div>
                                <label class="block text-sm font-medium theme-text-main mb-2">Enforcement Policy</label>
                                <select id="mfa_policy" class="w-full theme-bg-body border theme-border theme-text-main text-sm rounded-lg p-2.5 focus:ring-2 focus:ring-blue-500">
                                    <option value="optional">Optional (User Choice)</option>
                                    <option value="admins_only" selected>Mandatory for Admin Roles</option>
                                    <option value="all_mandatory">Mandatory for ALL Users</option>
                                    <option value="adaptive">Adaptive (Risk Based)</option>
                                </select>
                            </div>

                            <hr class="theme-border">

                            <div>
                                <p class="text-xs font-bold theme-text-muted uppercase tracking-wider mb-3">Allowed Methods</p>
                                
                                <div class="flex items-center justify-between mb-3">
                                    <span class="text-sm theme-text-main">Authenticator App (TOTP)</span>
                                    {{-- NOTE: Disabled inputs dont send value, but we handle it in JS --}}
                                    <input type="checkbox" id="mfa_totp" checked disabled class="w-4 h-4 rounded bg-gray-500/30 border-gray-500 cursor-not-allowed checked:bg-gray-500">
                                </div>
                                
                                <div class="flex items-center justify-between mb-3">
                                    <span class="text-sm theme-text-main">Email OTP</span>
                                    <input type="checkbox" id="mfa_email" checked class="w-4 h-4 rounded border-gray-300 focus:ring-2 checkbox-brand">
                                </div>

                                <div class="flex items-center justify-between mb-3">
                                    <span class="text-sm theme-text-main">SMS OTP</span>
                                    <input type="checkbox" id="mfa_sms" class="w-4 h-4 rounded border-gray-300 focus:ring-2 checkbox-brand">
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- IMPACT SIMULATION --}}
                    {{-- <div class="rounded-xl shadow-lg p-6 theme-text-main border theme-border" style="background-color: rgba(var(--bg-body), 0.95);">
                        <h3 class="font-semibold flex items-center gap-2 mb-4">
                            <i data-lucide="activity" class="w-4 h-4 text-green-500"></i> Impact Simulation
                        </h3>
                        <div class="space-y-3 text-sm">
                            <div class="flex justify-between">
                                <span class="theme-text-muted">Policy Strength:</span>
                                <span class="text-green-500 font-bold">High</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="theme-text-muted">User Friction:</span>
                                <span class="text-yellow-500 font-bold">Medium</span>
                            </div>
                            
                            <div class="h-1 w-full bg-gray-600/30 rounded-full mt-2">
                                <div class="h-1 bg-green-500 rounded-full transition-all duration-500" style="width: 75%"></div>
                            </div>
                            
                            <p class="text-xs theme-text-muted mt-2 leading-relaxed">
                                Estimated: <span class="theme-text-main font-medium">99.2%</span> of bots blocked. <span class="theme-text-main font-medium">0.5%</span> user drop-off expected.
                            </p>
                        </div>
                    </div> --}}

                </div>

            </div>
        </form>
    </div>
@endsection

@push('scripts')
    <script src="https://unpkg.com/lucide@latest"></script>
    <script>
        // ==============================
        // 1. CONFIGURATION
        // ==============================
        const API_BASE = "{{ url('/api') }}";
        
        function getHeaders() {
            const token = localStorage.getItem('token');
            return {
                'Content-Type': 'application/json',
                'Authorization': 'Bearer ' + token,
                'Accept': 'application/json'
            };
        }

        document.addEventListener("DOMContentLoaded", () => {
            lucide.createIcons();
        });

        // ==============================
        // 2. SAVE SETTINGS (POST ONLY)
        // ==============================
        async function saveSettings() {
            const saveBtn = document.getElementById('save-btn');
            
            // UI Loading State
            const originalBtnText = saveBtn.innerHTML;
            saveBtn.disabled = true;
            saveBtn.innerHTML = `<i data-lucide="loader-2" class="w-4 h-4 animate-spin"></i> <span>Saving...</span>`;
            lucide.createIcons();

            try {
                // --- A. Login Methods Payload ---
                const roleKey = document.getElementById('lr_role').value; // e.g. "Super Admin"
                const loginPayload = {
                    email_password: document.getElementById('lm_email').checked ? 1 : 0,
                    phone_otp: document.getElementById('lm_phone').checked ? 1 : 0,
                    oauth: document.getElementById('lm_oauth').checked ? 1 : 0,
                    login_rules: {
                        [roleKey]: {
                            allowed: true,
                            time: {
                                from: document.getElementById('lr_start').value,
                                to: document.getElementById('lr_end').value
                            }
                        }
                    }
                };

                // --- B. MFA Payload ---
                // Creating array of strings ["totp", "email"]
                let mfaMethods = [];
                if(document.getElementById('mfa_totp').checked) mfaMethods.push("totp");
                if(document.getElementById('mfa_email').checked) mfaMethods.push("email");
                if(document.getElementById('mfa_sms').checked) mfaMethods.push("sms");

                const mfaPayload = {
                    enforcement: document.getElementById('mfa_policy').value,
                    methods: mfaMethods
                };

                // --- C. Password Rules Payload ---
                const passwordPayload = {
                    min_length: parseInt(document.getElementById('pr_min_len').value),
                    uppercase: document.getElementById('pr_uppercase').checked ? 1 : 0,
                    symbols: document.getElementById('pr_symbols').checked ? 1 : 0,
                    prevent_reuse: document.getElementById('pr_reuse').checked ? 1 : 0,
                    check_breached: document.getElementById('pr_breach').checked ? 1 : 0,
                    rotation_after_90days: document.getElementById('pr_rotation').checked ? 1 : 0
                };

                // --- SEND PARALLEL REQUESTS ---
                // Hum teeno requests ek saath bhej rahay hain
                const [res1, res2, res3] = await Promise.all([
                    fetch(`${API_BASE}/auth/governance/login-methods`, {
                        method: 'POST',
                        headers: getHeaders(),
                        body: JSON.stringify(loginPayload)
                    }),
                    fetch(`${API_BASE}/auth/governance/mfa`, {
                        method: 'POST',
                        headers: getHeaders(),
                        body: JSON.stringify(mfaPayload)
                    }),
                    fetch(`${API_BASE}/auth/governance/password-rules`, {
                        method: 'POST',
                        headers: getHeaders(),
                        body: JSON.stringify(passwordPayload)
                    })
                ]);

                // Check Responses
                if(res1.ok && res2.ok && res3.ok) {
                    alert("✅ All policies updated successfully!");
                } else {
                    console.error("Errors:", res1.status, res2.status, res3.status);
                    alert("⚠️ Some settings failed to save. Please check console.");
                }

            } catch (error) {
                console.error("Save Error:", error);
                alert("❌ Network Error: Failed to connect to server.");
            } finally {
                // Restore Button
                saveBtn.disabled = false;
                saveBtn.innerHTML = originalBtnText;
                lucide.createIcons();
            }
        }
    </script>
@endpush

@push('styles')
<style>
    .toggle-checkbox:checked + .toggle-bg {
        background-color: rgb(var(--brand-primary));
    }
    .accent-brand {
        accent-color: rgb(var(--brand-primary));
    }
    .checkbox-brand:checked {
        background-color: rgb(var(--brand-primary));
        border-color: rgb(var(--brand-primary));
        color: white;
        background-image: url("data:image/svg+xml,%3csvg viewBox='0 0 16 16' fill='white' xmlns='http://www.w3.org/2000/svg'%3e%3cpath d='M12.207 4.793a1 1 0 010 1.414l-5 5a1 1 0 01-1.414 0l-2-2a1 1 0 011.414-1.414L6.5 9.086l4.293-4.293a1 1 0 011.414 0z'/%3e%3c/svg%3e");
    }
</style>
@endpush