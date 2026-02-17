@extends('layouts.app')

@section('title', 'Token Management')

@section('content')
    <div class="min-h-screen theme-bg-body theme-text-main max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
            <div>
                <h1 class="text-2xl font-bold theme-text-main">API Access Tokens</h1>
                <p class="theme-text-muted mt-1">Manage machine-level access, personal access tokens (PATs), and OAuth clients.</p>
            </div>
            <button onclick="openCreateModal()" 
                class="flex items-center gap-2 px-4 py-2 text-white rounded-lg text-sm font-medium hover:opacity-90 shadow-sm transition-colors"
                style="background-color: rgb(var(--brand-primary)); box-shadow: 0 4px 10px rgba(var(--brand-primary), 0.3);">
                <i data-lucide="plus" class="w-4 h-4"></i> 
                <span>Issue New Token</span>
            </button>
        </div>

        {{-- GLOBAL POLICY CARD --}}
        <div class="theme-bg-card rounded-xl shadow-sm border theme-border mb-8 overflow-hidden">
            <div class="px-6 py-4 border-b theme-border flex justify-between items-center" style="background-color: rgba(var(--bg-body), 0.5);">
                <h3 class="font-semibold theme-text-main flex items-center gap-2">
                    <i data-lucide="settings-2" class="w-4 h-4 theme-text-muted"></i> Global Token Policy
                </h3>
                <button class="text-xs font-bold hover:underline" style="color: rgb(var(--brand-primary));">UPDATE POLICY</button>
            </div>
            <div class="p-6 grid grid-cols-1 md:grid-cols-3 gap-6">
                
                <div>
                    <label class="block text-xs font-medium theme-text-muted uppercase tracking-wider mb-2">Access Token TTL</label>
                    <div class="relative">
                        <input type="number" value="60" class="w-full pl-3 pr-12 py-2 theme-bg-body border theme-border rounded-lg text-sm theme-text-main focus:ring-2 focus:ring-blue-500">
                        <span class="absolute right-3 top-2 theme-text-muted text-sm">min</span>
                    </div>
                    <p class="text-xs theme-text-muted mt-1">Short-lived for security.</p>
                </div>

                <div>
                    <label class="block text-xs font-medium theme-text-muted uppercase tracking-wider mb-2">Refresh Token TTL</label>
                    <div class="relative">
                        <input type="number" value="30" class="w-full pl-3 pr-12 py-2 theme-bg-body border theme-border rounded-lg text-sm theme-text-main focus:ring-2 focus:ring-blue-500">
                        <span class="absolute right-3 top-2 theme-text-muted text-sm">days</span>
                    </div>
                    <p class="text-xs theme-text-muted mt-1">Long-lived for UX.</p>
                </div>

                <div>
                    <label class="block text-xs font-medium theme-text-muted uppercase tracking-wider mb-2">Rotation Logic</label>
                    <label class="flex items-center space-x-3 mt-2">
                        <input type="checkbox" checked class="w-4 h-4 rounded border-gray-300 focus:ring-2 checkbox-brand">
                        <span class="text-sm theme-text-main">Rotate Refresh Token on Use</span>
                    </label>
                    <p class="text-xs theme-text-muted mt-1">Prevents replay attacks.</p>
                </div>
            </div>
        </div>

        {{-- ACTIVE TOKENS TABLE --}}
        <div class="theme-bg-card rounded-xl shadow-sm border theme-border overflow-hidden">
            <div class="px-6 py-4 border-b theme-border flex justify-between items-center" style="background-color: rgba(var(--bg-body), 0.5);">
                <h3 class="font-semibold theme-text-main">Active Access Tokens</h3>
                
                <div class="flex items-center gap-2">
                    <span class="text-xs theme-text-muted">Filter:</span>
                    <select class="text-xs theme-bg-body theme-border border rounded-lg theme-text-main focus:ring-2 focus:ring-blue-500">
                        <option>All Types</option>
                        <option>Personal Access Tokens</option>
                        <option>OAuth Clients</option>
                    </select>
                </div>
            </div>
            
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm theme-text-muted">
                    <thead class="theme-text-main font-semibold uppercase text-xs" style="background-color: rgba(var(--bg-body), 0.5);">
                        <tr>
                            <th class="px-6 py-3">Token Name / ID</th>
                            <th class="px-6 py-3">Scopes (Permissions)</th>
                            <th class="px-6 py-3">Created / Expires</th>
                            <th class="px-6 py-3">Last Used</th>
                            <th class="px-6 py-3 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="tokens-table-body" class="divide-y theme-border" style="border-color: rgb(var(--border-color));">
                        <tr class="hover:bg-white/5 transition-colors">
                            <td class="px-6 py-4">
                                <div class="font-medium theme-text-main">Mobile App V2 (iOS)</div>
                                <div class="font-mono text-xs theme-text-muted mt-1 flex items-center gap-1">
                                    <span class="theme-bg-body border theme-border px-1 rounded">ID: 8a7f...9c21</span>
                                    <span class="px-1.5 py-0.5 rounded bg-blue-500/10 text-blue-500 border border-blue-500/20 text-[10px] font-bold">OAUTH</span>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex flex-wrap gap-1">
                                    <span class="px-2 py-0.5 rounded-full theme-bg-body theme-text-muted text-xs border theme-border">read:profile</span>
                                    <span class="px-2 py-0.5 rounded-full theme-bg-body theme-text-muted text-xs border theme-border">write:orders</span>
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
                                <button class="text-red-500 hover:text-red-400 text-sm font-medium hover:underline">Revoke</button>
                            </td>
                        </tr>

                        <tr class="hover:bg-white/5 transition-colors">
                            <td class="px-6 py-4">
                                <div class="font-medium theme-text-main">CI/CD Deploy Bot</div>
                                <div class="font-mono text-xs theme-text-muted mt-1 flex items-center gap-1">
                                    <span class="theme-bg-body border theme-border px-1 rounded">ID: 3b2x...1z99</span>
                                    <span class="px-1.5 py-0.5 rounded bg-purple-500/10 text-purple-500 border border-purple-500/20 text-[10px] font-bold">PAT</span>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex flex-wrap gap-1">
                                    <span class="px-2 py-0.5 rounded-full bg-red-500/10 text-red-500 text-xs border border-red-500/20">admin:deploy</span>
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
                                    <button class="text-sm font-medium hover:underline" style="color: rgb(var(--brand-primary));">Rotate</button>
                                    <button class="text-red-500 hover:text-red-400 text-sm font-medium hover:underline">Revoke</button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- CREATE TOKEN MODAL --}}
    <div id="create-token-modal" class="hidden fixed inset-0 bg-black/80 backdrop-blur-sm z-50 flex items-center justify-center p-4">
        <div class="theme-bg-card rounded-xl shadow-2xl max-w-lg w-full p-6 border theme-border">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-bold theme-text-main">Issue New Access Token</h3>
                <button onclick="closeCreateModal()" class="theme-text-muted hover:text-white">
                    <i data-lucide="x" class="w-5 h-5"></i>
                </button>
            </div>
            
            <form id="create-token-form" onsubmit="handleTokenCreate(event)">
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium theme-text-muted mb-1">Token Name</label>
                        <input type="text" placeholder="e.g., Payment Service Worker" 
                            class="w-full theme-bg-body border theme-border rounded-lg theme-text-main focus:ring-2 focus:ring-blue-500 p-2.5" required>
                    </div>

                    <div>
                        <label class="block text-sm font-medium theme-text-muted mb-2">Capabilities (Scopes)</label>
                        <div class="grid grid-cols-2 gap-2 theme-bg-body p-3 rounded-lg border theme-border">
                            <label class="flex items-center space-x-2">
                                <input type="checkbox" class="rounded border-gray-300 focus:ring-2 checkbox-brand">
                                <span class="text-sm theme-text-main">read:users</span>
                            </label>
                            <label class="flex items-center space-x-2">
                                <input type="checkbox" class="rounded border-gray-300 focus:ring-2 checkbox-brand">
                                <span class="text-sm theme-text-main">write:users</span>
                            </label>
                            <label class="flex items-center space-x-2">
                                <input type="checkbox" class="rounded border-gray-300 focus:ring-2 checkbox-brand">
                                <span class="text-sm theme-text-main">read:finance</span>
                            </label>
                            <label class="flex items-center space-x-2">
                                <input type="checkbox" class="rounded text-red-500 focus:ring-red-500 border-red-500/50">
                                <span class="text-sm text-red-500 font-medium">admin:full</span>
                            </label>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium theme-text-muted mb-1">Expiration</label>
                        <select class="w-full theme-bg-body border theme-border rounded-lg theme-text-main focus:ring-2 focus:ring-blue-500 p-2.5">
                            <option value="30">30 Days</option>
                            <option value="60">60 Days</option>
                            <option value="365">1 Year</option>
                            <option value="0" class="text-red-500 font-bold">Never (Dangerous)</option>
                        </select>
                    </div>
                </div>

                <div class="mt-6 flex justify-end gap-3">
                    <button type="button" onclick="closeCreateModal()" class="px-4 py-2 theme-text-muted hover:bg-white/5 rounded-lg border theme-border transition">Cancel</button>
                    <button type="submit" 
                        class="px-4 py-2 text-white rounded-lg font-medium shadow-sm hover:opacity-90 transition"
                        style="background-color: rgb(var(--brand-primary));">Generate Token</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://unpkg.com/lucide@latest"></script>
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            lucide.createIcons();
        });

        // Modal Logic
        function openCreateModal() {
            document.getElementById('create-token-modal').classList.remove('hidden');
        }

        function closeCreateModal() {
            document.getElementById('create-token-modal').classList.add('hidden');
        }

        function handleTokenCreate(e) {
            e.preventDefault();
            // API Call logic goes here
            // POST /api/tokens
            
            closeCreateModal();
            alert("Token Generated! Copy it now: sh1_83... (Shown only once)");
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