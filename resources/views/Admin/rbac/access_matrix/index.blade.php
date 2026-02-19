@extends('layouts.app')

@section('content')
    <div id="app" class="min-h-screen theme-bg-body theme-text-main space-y-8 p-6 lg:p-10 font-sans">

        {{-- A. Header Section --}}
        <header class="flex flex-col md:flex-row md:items-end md:justify-between space-y-4 md:space-y-0">
            <div>
                {{-- Breadcrumb --}}
                <nav class="text-xs font-semibold uppercase tracking-wider theme-text-muted mb-2">
                    <ol class="inline-flex items-center space-x-1 md:space-x-2">
                        <li><a href="#" class="hover:underline transition-colors" style="color: rgb(var(--brand-primary));">Dashboard</a></li>
                        <li><span class="theme-text-muted">/</span></li>
                        <li><span class="theme-text-muted">Governance</span></li>
                        <li><span class="theme-text-muted">/</span></li>
                        <li style="color: rgb(var(--brand-primary));">Access Matrix</li>
                    </ol>
                </nav>

                {{-- Title --}}
                <h1 class="text-3xl md:text-4xl font-extrabold theme-text-main tracking-tight">
                    Access Matrix
                </h1>
                <p class="text-base theme-text-muted mt-2 max-w-2xl">
                    Provide a single, visual truth of access. Map organizational roles to atomic platform capabilities.
                </p>
            </div>
            
            <div class="flex items-center gap-3">
                 <button onclick="window.loadMatrixData()"
                    class="inline-flex items-center px-4 py-2 theme-bg-card border theme-border theme-text-main font-semibold rounded-xl shadow-sm hover:bg-white/5 transition-all duration-300">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                    </svg>
                    Sync Data
                </button>
            </div>
        </header>

        {{-- B. Matrix Interface --}}
        <section class="space-y-4">
            {{-- Toolbar --}}
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 theme-bg-card p-4 rounded-2xl border theme-border shadow-sm">
                <div class="flex items-center gap-4">
                    <h2 class="text-lg font-bold theme-text-main">Role vs Permission Mapping</h2>
                    <span class="px-2.5 py-1 rounded-md text-xs font-medium theme-bg-body theme-text-muted border theme-border" id="matrix-stats">Loading stats...</span>
                </div>

                <div class="relative">
                    <input type="text" id="matrix-search" placeholder="Filter permissions..."
                        class="pl-10 pr-4 py-2 theme-bg-body border theme-border rounded-xl text-sm theme-text-main focus:ring-2 placeholder-gray-500 w-64 outline-none"
                        style="--tw-ring-color: rgb(var(--brand-primary));"
                        onkeyup="window.renderMatrixView()">
                    <svg class="w-4 h-4 theme-text-muted absolute left-3 top-3" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
            </div>

            {{-- The Grid --}}
            <div class="theme-bg-card rounded-2xl shadow-sm border theme-border overflow-hidden relative min-h-[500px]">
                
                {{-- Loader --}}
                <div id="matrix-loading" class="absolute inset-0 bg-black/50 backdrop-blur-sm z-30 flex flex-col items-center justify-center">
                    <div class="animate-spin rounded-full h-10 w-10 border-b-2 mb-4" style="border-color: rgb(var(--brand-primary));"></div>
                    <span class="font-semibold animate-pulse" style="color: rgb(var(--brand-primary));">Constructing Matrix...</span>
                </div>

                <div class="overflow-x-auto overflow-y-auto max-h-[70vh] custom-scrollbar pb-4 relative">
                    <table class="w-full text-sm text-left border-collapse">
                        <thead id="matrix-header" class="theme-text-main sticky top-0 z-20 shadow-sm backdrop-blur-md" style="background-color: rgba(var(--bg-card), 0.95);">
                            {{-- Headers Injected via JS --}}
                        </thead>
                        <tbody id="matrix-body" class="divide-y theme-border" style="border-color: rgb(var(--border-color));">
                            {{-- Body Injected via JS --}}
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('styles')
    <style>
        /* Premium Scrollbar */
        .custom-scrollbar::-webkit-scrollbar { height: 8px; width: 8px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background-color: rgb(var(--border-color)); border-radius: 20px; }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover { background-color: rgb(var(--text-muted)); }

        /* --- PERMISSION TOGGLE SWITCHES --- */
        .toggle-track {
            width: 2.75rem;
            height: 1.5rem;
            background-color: rgba(var(--border-color), 0.8);
            border-radius: 9999px;
            transition: background-color 0.2s ease-in-out;
            cursor: pointer;
            border: 1px solid rgba(var(--border-color), 1);
        }

        .toggle-dot {
            width: 1.1rem;
            height: 1.1rem;
            background-color: white;
            border-radius: 50%;
            position: absolute;
            top: 0.2rem;
            left: 0.2rem;
            transition: transform 0.2s ease-in-out;
            box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
            pointer-events: none;
        }

        /* Checked State */
        input:checked + .toggle-track {
            background-color: rgb(var(--brand-primary)) !important;
            border-color: rgb(var(--brand-primary));
        }

        input:checked ~ .toggle-dot {
            transform: translateX(1.25rem);
        }

        /* Disabled State (For Super Admin) */
        input:disabled + .toggle-track {
            opacity: 0.5;
            cursor: not-allowed;
            background-color: rgb(var(--brand-primary)) !important;
        }

        /* Table Styling Requirements for Matrix */
        .role-cell {
            min-width: 140px;
            border-left: 1px solid rgb(var(--border-color));
        }

        .permission-cell {
            min-width: 280px;
            /* Sticky Left Column */
            position: sticky;
            left: 0;
            z-index: 10;
            background-color: rgb(var(--bg-card));
            border-right: 1px solid rgb(var(--border-color));
        }

        /* Ensure sticky headers intersecting sticky columns stay on top */
        thead th.permission-cell {
            z-index: 25; 
        }

        tbody tr:hover td:not(.permission-cell) { 
            background-color: rgba(255,255,255,0.02); 
        }
    </style>
@endpush

@push('scripts')
    <script>
        const AUTH_TOKEN = localStorage.getItem('token');
        const BASE_URL = 'http://127.0.0.1:8000/api';
        const CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]')?.content || '';

        let roles = [];
        let permissions = [];
        let permissionsByCategory = {};

        // --- 1. Notification Toast ---
        function showToaster(message, type = 'success') {
            let container = document.getElementById('toast-container');
            if (!container) {
                container = document.createElement('div');
                container.id = 'toast-container';
                container.className = 'fixed bottom-5 right-5 space-y-3 z-[100]';
                document.body.appendChild(container);
            }

            const toast = document.createElement('div');
            const bgColor = type === 'success' ? 'theme-bg-card border theme-border' : 'bg-red-500/20 border border-red-500/50';
            toast.className = `${bgColor} theme-text-main px-6 py-4 rounded-xl shadow-2xl flex items-center gap-3 transform translate-y-10 opacity-0 transition-all duration-300`;
            const icon = type === 'success' ?
                '<svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>' :
                '<svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>';

            toast.innerHTML = `${icon}<span class="font-medium text-sm">${message}</span>`;
            container.appendChild(toast);

            requestAnimationFrame(() => toast.classList.remove('translate-y-10', 'opacity-0'));
            setTimeout(() => {
                toast.classList.add('opacity-0', 'translate-y-2');
                setTimeout(() => toast.remove(), 300);
            }, 3000);
        }

        // --- 2. API Handler ---
        async function fetchData(endpoint, method = 'GET', body = null) {
            const headers = {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': CSRF_TOKEN,
            };
            if (AUTH_TOKEN) headers['Authorization'] = `Bearer ${AUTH_TOKEN}`;

            try {
                const response = await fetch(`${BASE_URL}${endpoint}`, {
                    method,
                    headers,
                    body: body ? JSON.stringify(body) : null
                });
                
                const text = await response.text();
                let data = {};
                if (text) {
                    try { data = JSON.parse(text); } catch(e) { data = { message: text }; }
                }

                if (!response.ok) throw { status: response.status, data };
                return data;
            } catch (error) {
                console.error(`API Error:`, error);
                throw error;
            }
        }

        // --- 3. Initial Loader ---
        window.loadMatrixData = async function() {
            try {
                document.getElementById('matrix-loading').classList.remove('hidden');

                // Fetch Roles and Permissions concurrently
                const [roleRes, permRes] = await Promise.all([
                    fetchData('/roles'),
                    fetchData('/permissions')
                ]);

                // Parse Roles (Assuming response contains a 'data' array or is an array directly)
                const rawRoles = Array.isArray(roleRes.data) ? roleRes.data : (Array.isArray(roleRes) ? roleRes : []);
                roles = rawRoles.map(r => ({
                    ...r,
                    // Map inner permissions to a simple array of names for easy checking
                    permissions_list: (r.permissions || []).map(p => p.name)
                })).sort((a, b) => {
                    // Force Super Admin to the first column
                    if (a.name.toLowerCase() === 'super admin') return -1;
                    if (b.name.toLowerCase() === 'super admin') return 1;
                    return a.name.localeCompare(b.name);
                });

                // Parse Permissions
                const rawPerms = Array.isArray(permRes.data) ? permRes.data : (Array.isArray(permRes) ? permRes : []);
                permissions = rawPerms.map(p => ({
                    ...p,
                    category: p.category || getFallbackCategory(p.name)
                }));

                // Group Permissions by Category
                permissionsByCategory = permissions.reduce((acc, p) => {
                    if (!acc[p.category]) acc[p.category] = [];
                    acc[p.category].push(p);
                    return acc;
                }, {});

                // Update Stats text
                document.getElementById('matrix-stats').textContent = `${roles.length} Roles • ${permissions.length} Permissions`;

                renderMatrixView();

            } catch (e) {
                showToaster(e.data?.message || 'Failed to sync matrix data', 'error');
            } finally {
                document.getElementById('matrix-loading').classList.add('hidden');
            }
        };

        function getFallbackCategory(name) {
            const n = name.toLowerCase();
            if (n.includes('finance') || n.includes('refund')) return 'Finance Operations';
            if (n.includes('user') || n.includes('ban')) return 'User Management';
            return 'System Controls';
        }

        // --- 4. Render Logic ---
        window.renderMatrixView = function() {
            const header = document.getElementById('matrix-header');
            const body = document.getElementById('matrix-body');
            const searchTerm = document.getElementById('matrix-search').value.toLowerCase();

            // Render Header (Roles)
            let hHtml = `<tr><th class="permission-cell px-6 py-4 text-xs font-bold uppercase tracking-wider theme-bg-card">Capabilities</th>`;
            roles.forEach(r => {
                const isSuper = r.name.toLowerCase() === 'super admin';
                hHtml += `
                <th class="role-cell px-4 py-4 text-center">
                    <div class="flex flex-col items-center">
                        <span class="text-sm font-bold theme-text-main">${r.name}</span>
                        ${isSuper ? '<span class="text-[10px] uppercase font-bold text-red-500 bg-red-500/10 border border-red-500/20 px-1.5 py-0.5 rounded mt-1">Locked</span>' : ''}
                    </div>
                </th>`;
            });
            header.innerHTML = hHtml + '</tr>';

            // Render Body (Permissions grouped by Category)
            body.innerHTML = '';
            const categories = Object.keys(permissionsByCategory).sort();

            categories.forEach(cat => {
                // Filter permissions in this category based on search
                const filteredPerms = permissionsByCategory[cat].filter(p => p.name.toLowerCase().includes(searchTerm));
                
                if (filteredPerms.length === 0) return; // Skip category if empty due to search

                // Category Header Row
                body.innerHTML += `
                    <tr style="background-color: rgba(var(--brand-primary), 0.05);">
                        <td colspan="${roles.length + 1}" class="px-6 py-2 text-xs font-bold uppercase tracking-widest sticky left-0 z-10" style="color: rgb(var(--brand-primary)); border-bottom: 1px solid rgb(var(--border-color));">
                            ${cat}
                        </td>
                    </tr>`;

                // Permission Rows
                filteredPerms.sort((a, b) => a.name.localeCompare(b.name)).forEach(p => {
                    let row = `
                        <tr>
                            <td class="permission-cell px-6 py-3 text-sm font-medium theme-text-main group">
                                <div class="flex items-center justify-between">
                                    <span>${p.name}</span>
                                </div>
                            </td>`;
                            
                    roles.forEach(r => {
                        const hasPermission = r.permissions_list.includes(p.name);
                        const isSuper = r.name.toLowerCase() === 'super admin';
                        
                        row += `
                            <td class="role-cell px-4 py-3 text-center align-middle transition-colors">
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" class="sr-only peer"
                                        ${hasPermission ? 'checked' : ''} 
                                        ${isSuper ? 'disabled' : ''}
                                        data-role-id="${r.id}" 
                                        data-perm-name="${p.name}"
                                        onchange="window.togglePermission(this)">
                                    <div class="toggle-track"></div>
                                    <div class="toggle-dot"></div>
                                </label>
                            </td>`;
                    });
                    body.innerHTML += row + '</tr>';
                });
            });
            
            if (body.innerHTML === '') {
                 body.innerHTML = `<tr><td colspan="${roles.length + 1}" class="px-6 py-10 text-center theme-text-muted">No permissions match your search.</td></tr>`;
            }
        };

        // --- 5. Action: Toggle Permission ---
        window.togglePermission = async function(checkbox) {
            const roleId = checkbox.dataset.roleId;
            const permName = checkbox.dataset.permName;
            const role = roles.find(r => r.id == roleId);

            // Safety check for Super Admin
            if (role.name.toLowerCase() === 'super admin') {
                checkbox.checked = true;
                showToaster('System Protected: Cannot modify Super Admin', 'error');
                return;
            }

            // 1. Optimistic UI Update (Update local state)
            const oldList = [...role.permissions_list]; 

            if (checkbox.checked) {
                if (!role.permissions_list.includes(permName)) {
                    role.permissions_list.push(permName);
                }
            } else {
                role.permissions_list = role.permissions_list.filter(n => n !== permName);
            }

            // 2. Sync to API
            try {
                // The monolithic code payload: { role: 'Admin', permissions: ['perm1', 'perm2'] }
                await fetchData('/role-permission', 'POST', {
                    role: role.name,
                    permissions: role.permissions_list
                });

                showToaster(`Access updated for ${role.name}`);

            } catch (e) {
                // Revert UI on failure
                role.permissions_list = oldList;
                checkbox.checked = !checkbox.checked;
                showToaster(e.data?.message || 'Access synchronization failed', 'error');
            }
        };

        // Initialize
        document.addEventListener('DOMContentLoaded', loadMatrixData);
    </script>
@endpush