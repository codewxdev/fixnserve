@extends('layouts.app')

@section('title', 'Token Management')

@section('content')
    <div class="min-h-screen theme-bg-body theme-text-main max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
            <div>
                <h1 class="text-2xl font-bold theme-text-main">API Access Tokens</h1>
                <p class="theme-text-muted mt-1">Manage machine-level access, personal access tokens (PATs), and OAuth
                    clients.</p>
            </div>
            {{-- <button onclick="openCreateModal()"
                class="flex items-center gap-2 px-4 py-2 text-white rounded-lg text-sm font-medium hover:opacity-90 shadow-sm transition-colors"
                style="background-color: rgb(var(--brand-primary)); box-shadow: 0 4px 10px rgba(var(--brand-primary), 0.3);">
                <i data-lucide="plus" class="w-4 h-4"></i>
                <span>Issue New Token</span>
            </button> --}}
        </div>

        {{-- GLOBAL POLICY CARD --}}
        <div class="theme-bg-card rounded-xl shadow-sm border theme-border mb-8 overflow-hidden">
            <div class="px-6 py-4 border-b theme-border flex justify-between items-center"
                style="background-color: rgba(var(--bg-body), 0.5);">
                <h3 class="font-semibold theme-text-main flex items-center gap-2">
                    <i data-lucide="settings-2" class="w-4 h-4 theme-text-muted"></i> Global Token Policy
                </h3>
                <button class="text-xs font-bold hover:underline" style="color: rgb(var(--brand-primary));">UPDATE
                    POLICY</button>
            </div>
            {{-- Update these IDs in your HTML for Policy inputs --}}
            <div class="p-6 grid grid-cols-1 md:grid-cols-3 gap-6" id="policy-form">
                <div>
                    <label class="block text-xs font-medium theme-text-muted uppercase tracking-wider mb-2">Access Token
                        TTL</label>
                    <div class="relative">
                        <input type="number" id="policy-access-ttl"
                            class="w-full pl-3 pr-12 py-2 theme-bg-body border theme-border rounded-lg text-sm theme-text-main focus:ring-2 focus:ring-blue-500">
                        <span class="absolute right-3 top-2 theme-text-muted text-sm">min</span>
                    </div>
                </div>
                <div>
                    <label class="block text-xs font-medium theme-text-muted uppercase tracking-wider mb-2">Refresh Token
                        TTL</label>
                    <div class="relative">
                        <input type="number" id="policy-refresh-ttl"
                            class="w-full pl-3 pr-12 py-2 theme-bg-body border theme-border rounded-lg text-sm theme-text-main focus:ring-2 focus:ring-blue-500">
                        <span class="absolute right-3 top-2 theme-text-muted text-sm">days</span>
                    </div>
                </div>
                <div>
                    <label class="block text-xs font-medium theme-text-muted uppercase tracking-wider mb-2">Rotation
                        Logic</label>
                    <label class="flex items-center space-x-3 mt-2">
                        <input type="checkbox" id="policy-rotate"
                            class="w-4 h-4 rounded border-gray-300 focus:ring-2 checkbox-brand">
                        <span class="text-sm theme-text-main">Rotate Refresh Token on Use</span>
                    </label>
                </div>
                <div class="md:col-span-3 text-right">
                    <button onclick="updatePolicy()" id="btn-update-policy"
                        class="text-xs font-bold px-4 py-2 rounded bg-blue-600/10 hover:bg-blue-600/20 text-blue-500 transition">SAVE
                        POLICY CHANGES</button>
                </div>
            </div>
        </div>

        {{-- ACTIVE TOKENS TABLE --}}
        <div class="theme-bg-card rounded-xl shadow-sm border theme-border overflow-hidden">
            <div class="px-6 py-4 border-b theme-border flex justify-between items-center"
                style="background-color: rgba(var(--bg-body), 0.5);">
                <h3 class="font-semibold theme-text-main">Active Access Tokens</h3>

                <div class="flex items-center gap-2">
                    <span class="text-xs theme-text-muted">Filter:</span>
                    <select
                        class="text-xs theme-bg-body theme-border border rounded-lg theme-text-main focus:ring-2 focus:ring-blue-500">
                        <option>All Types</option>
                        <option>Personal Access Tokens</option>
                        <option>OAuth Clients</option>
                    </select>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm theme-text-muted">
                    <thead class="theme-text-main font-semibold uppercase text-xs"
                        style="background-color: rgba(var(--bg-body), 0.5);">
                        <tr>
                            <th class="px-6 py-3">Token Name / ID</th>
                            <th class="px-6 py-3">Scopes (Permissions)</th>
                            <th class="px-6 py-3">Created / Expires</th>
                            <th class="px-6 py-3">Last Used</th>
                            <th class="px-6 py-3 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="tokens-table-body" class="divide-y theme-border"
                        style="border-color: rgb(var(--border-color));">
                        <tr class="hover:bg-white/5 transition-colors">
                            <td class="px-6 py-4">
                                <div class="font-medium theme-text-main">Mobile App V2 (iOS)</div>
                                <div class="font-mono text-xs theme-text-muted mt-1 flex items-center gap-1">
                                    <span class="theme-bg-body border theme-border px-1 rounded">ID: 8a7f...9c21</span>
                                    <span
                                        class="px-1.5 py-0.5 rounded bg-blue-500/10 text-blue-500 border border-blue-500/20 text-[10px] font-bold">OAUTH</span>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex flex-wrap gap-1">
                                    <span
                                        class="px-2 py-0.5 rounded-full theme-bg-body theme-text-muted text-xs border theme-border">read:profile</span>
                                    <span
                                        class="px-2 py-0.5 rounded-full theme-bg-body theme-text-muted text-xs border theme-border">write:orders</span>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="theme-text-main">Feb 10, 2026</div>
                                <div class="text-xs theme-text-muted">Expires in 28 days</div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-1.5 text-green-500">
                                    <div class="w-1.5 h-1.5 rounded-full bg-green-500"></div>
                                    <span class="text-xs font-medium">Just now</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <button
                                    class="text-red-500 hover:text-red-400 text-sm font-medium hover:underline">Revoke</button>
                            </td>
                        </tr>

                        <tr class="hover:bg-white/5 transition-colors">
                            <td class="px-6 py-4">
                                <div class="font-medium theme-text-main">CI/CD Deploy Bot</div>
                                <div class="font-mono text-xs theme-text-muted mt-1 flex items-center gap-1">
                                    <span class="theme-bg-body border theme-border px-1 rounded">ID: 3b2x...1z99</span>
                                    <span
                                        class="px-1.5 py-0.5 rounded bg-purple-500/10 text-purple-500 border border-purple-500/20 text-[10px] font-bold">PAT</span>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex flex-wrap gap-1">
                                    <span
                                        class="px-2 py-0.5 rounded-full bg-red-500/10 text-red-500 text-xs border border-red-500/20">admin:deploy</span>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="theme-text-main">Jan 15, 2026</div>
                                <div class="text-xs text-orange-500 font-bold">Expires tomorrow</div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-xs theme-text-muted">2 days ago</div>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex justify-end gap-3">
                                    <button class="text-sm font-medium hover:underline"
                                        style="color: rgb(var(--brand-primary));">Rotate</button>
                                    <button
                                        class="text-red-500 hover:text-red-400 text-sm font-medium hover:underline">Revoke</button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script src="https://unpkg.com/lucide@latest"></script>
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            lucide.createIcons();
            fetchPolicies();
            fetchTokens();
        });

        // --- API Helper ---
        async function apiRequest(endpoint, method = 'GET', body = null) {
            const token = localStorage.getItem('token');

            const fingerprint = localStorage.getItem('device_fingerprint') || 'unknown';

            const options = {
                method: method,
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'Authorization': `Bearer ${token}`,
                    'X-Device-Fingerprint': fingerprint
                }
            };
            if (body) options.body = JSON.stringify(body);

            try {
                const response = await fetch(endpoint, options);
                const result = await response.json();
                if (!response.ok) throw new Error(result.message || 'Something went wrong');
                return result;
            } catch (error) {
                console.error('API Error:', error);
                alert(error.message);
                return null;
            }
        }

        // --- 1. Fetch & Update Token Policies ---
        async function fetchPolicies() {
            const res = await apiRequest('/api/token-policy');
            if (res && res.data) {
                // Assuming first policy is the current one
                const policy = res.data[0];
                document.getElementById('policy-access-ttl').value = policy.access_token_ttl_minutes;
                document.getElementById('policy-refresh-ttl').value = policy.refresh_token_ttl_days;
                document.getElementById('policy-rotate').checked = !!policy.rotate_refresh_on_use;
            }
        }

        async function updatePolicy() {
            const btn = document.getElementById('btn-update-policy');
            btn.innerText = 'SAVING...';

            const payload = {
                access_token_ttl_minutes: document.getElementById('policy-access-ttl').value,
                refresh_token_ttl_days: document.getElementById('policy-refresh-ttl').value,
                rotate_refresh_on_use: document.getElementById('policy-rotate').checked ? 1 : 0
            };

            // As per your API: PUT /api/tokens
            const res = await apiRequest('/api/token-policy', 'PUT', payload);
            if (res) alert('Policy updated successfully');
            btn.innerText = 'SAVE POLICY CHANGES';
        }

        // --- 2. List Active Tokens ---
        async function fetchTokens() {
            const container = document.getElementById('tokens-table-body');
            container.innerHTML = '<tr><td colspan="5" class="p-6 text-center">Loading tokens...</td></tr>';

            const tokens = await apiRequest('/api/tokens'); // Mapping to your listTokens method
            if (!tokens) return;

            container.innerHTML = '';
            tokens.forEach(token => {
                const row = `
                <tr class="hover:bg-white/5 transition-colors">
                    <td class="px-6 py-4">
                        <div class="font-medium theme-text-main">${token.device || 'Unknown Device'}</div>
                        <div class="font-mono text-xs theme-text-muted mt-1 flex items-center gap-1">
                            <span class="theme-bg-body border theme-border px-1 rounded">ID: ${token.id.substring(0,8)}...</span>
                            <span class="px-1.5 py-0.5 rounded ${token.is_expired ? 'bg-red-500/10 text-red-500' : 'bg-blue-500/10 text-blue-500'} border border-blue-500/20 text-[10px] font-bold">
                                ${token.is_expired ? 'EXPIRED' : 'ACTIVE'}
                            </span>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex flex-wrap gap-1">
                            <span class="px-2 py-0.5 rounded-full theme-bg-body theme-text-muted text-xs border theme-border">standard:access</span>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="theme-text-main">${new Date(token.created_at).toLocaleDateString()}</div>
                        <div class="text-xs ${token.is_expired ? 'text-red-500' : 'theme-text-muted'}">
                            Exp: ${token.expires_at ? new Date(token.expires_at).toLocaleDateString() : 'Never'}
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <span class="text-xs font-medium ${token.last_used ? 'text-green-500' : 'text-gray-500'}">
                            ${token.last_used ? 'Active: ' + new Date(token.last_used).toLocaleTimeString() : 'Never used'}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-right">
                        <div class="flex justify-end gap-3">
                            <button onclick="rotateToken('${token.id}')" class="text-sm font-medium hover:underline text-blue-500">Rotate</button>
                            <button onclick="revokeToken('${token.id}')" class="text-red-500 hover:text-red-400 text-sm font-medium hover:underline">Revoke</button>
                        </div>
                    </td>
                </tr>
            `;
                container.insertAdjacentHTML('beforeend', row);
            });
        }

        
        // --- 3. Actions: Rotate & Revoke ---
        async function rotateToken(id) {
            if (!confirm('Are you sure? Old tokens will be invalidated.')) return;

            // LocalStorage se real fingerprint uthayen
            const realFingerprint = localStorage.getItem('device_fingerprint') || 'unknown';

            const deviceData = {
                device_name: "Web Browser", // Aap navigation.userAgent se bhi nikal sakte hain
                fingerprint: realFingerprint, // <-- Fake ki jagah Real fingerprint use karein
                os_version: navigator.platform,
                app_version: '1.0.0'
            };

            const res = await apiRequest(`/api/tokens/${id}/rotate`, 'POST', deviceData);
            if (res) {
                alert('Token rotated successfully!');
                fetchTokens();
            }
        }

        async function revokeToken(id) {
            if (!confirm('This will immediately terminate the session. Continue?')) return;

            const res = await apiRequest(`/api/auth/token/revoke/${id}`, 'DELETE');
            if (res) {
                alert('Token revoked successfully');
                fetchTokens();
            }
        }

        // Modal UI Logic
        // function openCreateModal() {
        //     document.getElementById('create-token-modal').classList.remove('hidden');
        // }

        function closeCreateModal() {
            document.getElementById('create-token-modal').classList.add('hidden');
        }
    </script>
@endpush

@push('styles')
    <style>
        /* Ensure checkbox matches theme brand color */
        .checkbox-brand:checked {
            background-color: rgb(var(--brand-primary));
            border-color: rgb(var(--brand-primary));
            color: white;
            background-image: url("data:image/svg+xml,%3csvg viewBox='0 0 16 16' fill='white' xmlns='http://www.w3.org/2000/svg'%3e%3cpath d='M12.207 4.793a1 1 0 010 1.414l-5 5a1 1 0 01-1.414 0l-2-2a1 1 0 011.414-1.414L6.5 9.086l4.293-4.293a1 1 0 011.414 0z'/%3e%3c/svg%3e");
        }
    </style>
@endpush
