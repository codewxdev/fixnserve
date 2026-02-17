@extends('layouts.app')

@section('title', 'Token Management')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
            <div>
                <h1 class="text-2xl font-bold text-slate-900">API Access Tokens</h1>
                <p class="text-slate-500 mt-1">Manage machine-level access, personal access tokens (PATs), and OAuth clients.</p>
            </div>
            <button onclick="openCreateModal()" class="flex items-center gap-2 px-4 py-2 bg-indigo-600 rounded-lg text-sm font-medium text-white hover:bg-indigo-700 shadow-sm transition-colors">
                <i data-lucide="plus" class="w-4 h-4"></i> 
                <span>Issue New Token</span>
            </button>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-200 mb-8 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 bg-slate-50 flex justify-between items-center">
                <h3 class="font-semibold text-slate-800 flex items-center gap-2">
                    <i data-lucide="settings-2" class="w-4 h-4 text-slate-500"></i> Global Token Policy
                </h3>
                <button class="text-indigo-600 text-xs font-bold hover:underline">UPDATE POLICY</button>
            </div>
            <div class="p-6 grid grid-cols-1 md:grid-cols-3 gap-6">
                
                <div>
                    <label class="block text-xs font-medium text-slate-500 uppercase tracking-wider mb-2">Access Token TTL</label>
                    <div class="relative">
                        <input type="number" value="60" class="w-full pl-3 pr-12 py-2 border border-gray-300 rounded-lg text-sm focus:ring-indigo-500 focus:border-indigo-500">
                        <span class="absolute right-3 top-2 text-slate-400 text-sm">min</span>
                    </div>
                    <p class="text-xs text-slate-400 mt-1">Short-lived for security.</p>
                </div>

                <div>
                    <label class="block text-xs font-medium text-slate-500 uppercase tracking-wider mb-2">Refresh Token TTL</label>
                    <div class="relative">
                        <input type="number" value="30" class="w-full pl-3 pr-12 py-2 border border-gray-300 rounded-lg text-sm focus:ring-indigo-500 focus:border-indigo-500">
                        <span class="absolute right-3 top-2 text-slate-400 text-sm">days</span>
                    </div>
                    <p class="text-xs text-slate-400 mt-1">Long-lived for UX.</p>
                </div>

                <div>
                    <label class="block text-xs font-medium text-slate-500 uppercase tracking-wider mb-2">Rotation Logic</label>
                    <label class="flex items-center space-x-3 mt-2">
                        <input type="checkbox" checked class="w-4 h-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                        <span class="text-sm text-slate-700">Rotate Refresh Token on Use</span>
                    </label>
                    <p class="text-xs text-slate-400 mt-1">Prevents replay attacks.</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center">
                <h3 class="font-semibold text-slate-800">Active Access Tokens</h3>
                
                <div class="flex items-center gap-2">
                    <span class="text-xs text-slate-500">Filter:</span>
                    <select class="text-xs border-gray-300 rounded-lg focus:ring-indigo-500">
                        <option>All Types</option>
                        <option>Personal Access Tokens</option>
                        <option>OAuth Clients</option>
                    </select>
                </div>
            </div>
            
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-slate-600">
                    <thead class="bg-slate-50 text-slate-700 font-semibold uppercase text-xs">
                        <tr>
                            <th class="px-6 py-3">Token Name / ID</th>
                            <th class="px-6 py-3">Scopes (Permissions)</th>
                            <th class="px-6 py-3">Created / Expires</th>
                            <th class="px-6 py-3">Last Used</th>
                            <th class="px-6 py-3 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="tokens-table-body" class="divide-y divide-gray-100">
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="px-6 py-4">
                                <div class="font-medium text-slate-900">Mobile App V2 (iOS)</div>
                                <div class="font-mono text-xs text-slate-400 mt-1 flex items-center gap-1">
                                    <span class="bg-slate-100 px-1 rounded">ID: 8a7f...9c21</span>
                                    <span class="px-1.5 py-0.5 rounded bg-blue-50 text-blue-600 text-[10px] font-bold">OAUTH</span>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex flex-wrap gap-1">
                                    <span class="px-2 py-0.5 rounded-full bg-gray-100 text-gray-600 text-xs border border-gray-200">read:profile</span>
                                    <span class="px-2 py-0.5 rounded-full bg-gray-100 text-gray-600 text-xs border border-gray-200">write:orders</span>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-slate-900">Feb 10, 2026</div>
                                <div class="text-xs text-slate-400">Expires in 28 days</div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-1.5 text-green-600">
                                    <div class="w-1.5 h-1.5 rounded-full bg-green-500"></div>
                                    <span class="text-xs font-medium">Just now</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <button class="text-red-600 hover:text-red-800 text-sm font-medium hover:underline">Revoke</button>
                            </td>
                        </tr>

                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="px-6 py-4">
                                <div class="font-medium text-slate-900">CI/CD Deploy Bot</div>
                                <div class="font-mono text-xs text-slate-400 mt-1 flex items-center gap-1">
                                    <span class="bg-slate-100 px-1 rounded">ID: 3b2x...1z99</span>
                                    <span class="px-1.5 py-0.5 rounded bg-purple-50 text-purple-600 text-[10px] font-bold">PAT</span>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex flex-wrap gap-1">
                                    <span class="px-2 py-0.5 rounded-full bg-red-50 text-red-600 text-xs border border-red-100">admin:deploy</span>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-slate-900">Jan 15, 2026</div>
                                <div class="text-xs text-orange-500 font-bold">Expires tomorrow</div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-xs text-slate-400">2 days ago</div>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex justify-end gap-3">
                                    <button class="text-indigo-600 hover:text-indigo-800 text-sm font-medium hover:underline">Rotate</button>
                                    <button class="text-red-600 hover:text-red-800 text-sm font-medium hover:underline">Revoke</button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div id="create-token-modal" class="hidden fixed inset-0 bg-slate-900/50 backdrop-blur-sm z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-xl shadow-2xl max-w-lg w-full p-6">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-bold text-slate-900">Issue New Access Token</h3>
                <button onclick="closeCreateModal()" class="text-slate-400 hover:text-slate-600">
                    <i data-lucide="x" class="w-5 h-5"></i>
                </button>
            </div>
            
            <form id="create-token-form" onsubmit="handleTokenCreate(event)">
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Token Name</label>
                        <input type="text" placeholder="e.g., Payment Service Worker" class="w-full border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500" required>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Capabilities (Scopes)</label>
                        <div class="grid grid-cols-2 gap-2 bg-slate-50 p-3 rounded-lg border border-slate-200">
                            <label class="flex items-center space-x-2">
                                <input type="checkbox" class="rounded text-indigo-600 focus:ring-indigo-500">
                                <span class="text-sm text-slate-600">read:users</span>
                            </label>
                            <label class="flex items-center space-x-2">
                                <input type="checkbox" class="rounded text-indigo-600 focus:ring-indigo-500">
                                <span class="text-sm text-slate-600">write:users</span>
                            </label>
                            <label class="flex items-center space-x-2">
                                <input type="checkbox" class="rounded text-indigo-600 focus:ring-indigo-500">
                                <span class="text-sm text-slate-600">read:finance</span>
                            </label>
                            <label class="flex items-center space-x-2">
                                <input type="checkbox" class="rounded text-red-600 focus:ring-red-500">
                                <span class="text-sm text-red-600 font-medium">admin:full</span>
                            </label>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Expiration</label>
                        <select class="w-full border-gray-300 rounded-lg focus:ring-indigo-500">
                            <option value="30">30 Days</option>
                            <option value="60">60 Days</option>
                            <option value="365">1 Year</option>
                            <option value="0" class="text-red-600 font-bold">Never (Dangerous)</option>
                        </select>
                    </div>
                </div>

                <div class="mt-6 flex justify-end gap-3">
                    <button type="button" onclick="closeCreateModal()" class="px-4 py-2 text-slate-700 hover:bg-slate-100 rounded-lg">Cancel</button>
                    <button type="submit" class="px-4 py-2 bg-indigo-600 text-white hover:bg-indigo-700 rounded-lg font-medium shadow-sm">Generate Token</button>
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