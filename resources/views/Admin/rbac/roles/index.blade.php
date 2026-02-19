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
                        <li style="color: rgb(var(--brand-primary));">Role Registry</li>
                    </ol>
                </nav>

                {{-- Title --}}
                <h1 class="text-3xl md:text-4xl font-extrabold theme-text-main tracking-tight">
                    Role Management
                </h1>
                <p class="text-base theme-text-muted mt-2 max-w-2xl">
                    Define organizational authority units. Manage role lifecycles, scope, and metadata.
                </p>
            </div>

            <div class="flex flex-wrap gap-3">
                <button onclick="document.getElementById('addRoleModal').classList.remove('hidden')"
                    class="inline-flex items-center px-5 py-2.5 text-white font-semibold rounded-xl shadow-lg transition-all duration-300 transform hover:-translate-y-0.5"
                    style="background-color: rgb(var(--brand-primary)); box-shadow: 0 4px 14px rgba(var(--brand-primary), 0.4);">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20v-2c0-.656-.126-1.283-.356-1.857M9 20H7a4 4 0 01-4-4v-2.586a1 1 0 01.293-.707l3.95-3.95a1 1 0 01.707-.293h2.586M7 20v-2c0-.656.126-1.283.356-1.857M11 5a2 2 0 11-4 0 2 2 0 014 0zM12 12a4 4 0 100-8 4 4 0 000 8z">
                        </path>
                    </svg>
                    Create New Role
                </button>
            </div>
        </header>

        {{-- B. Stats Overview (Scoped to Roles) --}}
        <section id="stats-section" class="grid grid-cols-1 sm:grid-cols-3 gap-6">
            <div
                class="group theme-bg-card p-6 rounded-2xl shadow-sm border theme-border hover:shadow-md transition-all duration-300">
                <div class="flex items-center justify-between mb-4">
                    <div class="p-3 rounded-xl transition-colors duration-300" 
                         style="background-color: rgba(var(--brand-primary), 0.1); color: rgb(var(--brand-primary));">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z">
                            </path>
                        </svg>
                    </div>
                    <span class="text-xs font-bold text-green-500 bg-green-500/10 px-2 py-1 rounded-lg border border-green-500/20">Active</span>
                </div>
                <p class="theme-text-muted text-sm font-medium">Total Defined Roles</p>
                <h3 class="text-3xl font-bold theme-text-main" id="stat-total-roles">...</h3>
            </div>

            <div
                class="group theme-bg-card p-6 rounded-2xl shadow-sm border theme-border hover:shadow-md transition-all duration-300">
                <div class="flex items-center justify-between mb-4">
                    <div class="p-3 rounded-xl bg-red-500/10 text-red-500 transition-colors duration-300">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z">
                            </path>
                        </svg>
                    </div>
                </div>
                <p class="theme-text-muted text-sm font-medium">System Protected</p>
                <h3 class="text-3xl font-bold theme-text-main" id="stat-system-roles">...</h3>
            </div>

            <div
                class="group theme-bg-card p-6 rounded-2xl shadow-sm border theme-border hover:shadow-md transition-all duration-300">
                <div class="flex items-center justify-between mb-4">
                    <div class="p-3 rounded-xl bg-blue-500/10 text-blue-500 transition-colors duration-300">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                            </path>
                        </svg>
                    </div>
                </div>
                <p class="theme-text-muted text-sm font-medium">Custom Roles</p>
                <h3 class="text-3xl font-bold theme-text-main" id="stat-custom-roles">...</h3>
            </div>
        </section>

        {{-- C. Role Directory --}}
        <section class="space-y-6">
            <div class="flex items-center justify-between">
                <h2 class="text-lg font-bold theme-text-main">Role Directory</h2>
                <div class="relative">
                    <input type="text" id="role-search" placeholder="Search roles..."
                        class="pl-10 pr-4 py-2 theme-bg-body border theme-border rounded-xl text-sm theme-text-main focus:ring-2 placeholder-gray-500"
                        style="--tw-ring-color: rgb(var(--brand-primary));"
                        onkeyup="window.filterRoles()">
                    <svg class="w-4 h-4 theme-text-muted absolute left-3 top-3" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
            </div>

            <div id="role-list-container" class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
                <div id="roles-loading" class="col-span-full flex flex-col items-center justify-center py-20">
                    <div class="animate-spin rounded-full h-10 w-10 border-b-2 mb-4" style="border-color: rgb(var(--brand-primary));"></div>
                    <span class="font-semibold" style="color: rgb(var(--brand-primary));">Loading Directory...</span>
                </div>
                {{-- Roles Injected via JS --}}
            </div>
        </section>
    </div>

    {{-- MODAL: Create Role --}}
    <div id="addRoleModal" class="hidden fixed inset-0 z-[60] overflow-y-auto" aria-labelledby="modal-title"
        role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-black/80 backdrop-blur-sm transition-opacity" aria-hidden="true"
                onclick="document.getElementById('addRoleModal').classList.add('hidden')"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

            <div class="inline-block align-bottom theme-bg-card border theme-border rounded-2xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg w-full">
                <div class="px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full sm:mx-0 sm:h-10 sm:w-10"
                            style="background-color: rgba(var(--brand-primary), 0.1); color: rgb(var(--brand-primary));">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                            </svg>
                        </div>
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                            <h3 class="text-lg leading-6 font-bold theme-text-main" id="modal-title">Create New Role</h3>
                            <div class="mt-4">
                                <form id="addRoleForm" class="space-y-4">
                                    <div>
                                        <label class="block text-sm font-medium theme-text-muted mb-1">Role Name</label>
                                        <input type="text" id="role_name" name="name"
                                            placeholder="e.g. Finance Auditor"
                                            class="w-full px-4 py-2 theme-bg-body border theme-border rounded-xl focus:ring-2 outline-none transition-all theme-text-main"
                                            style="--tw-ring-color: rgb(var(--brand-primary));">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium theme-text-muted mb-1">Description</label>
                                        <textarea id="role_description" rows="3" placeholder="Brief description of responsibilities..."
                                            class="w-full px-4 py-2 theme-bg-body border theme-border rounded-xl focus:ring-2 outline-none transition-all theme-text-main"
                                            style="--tw-ring-color: rgb(var(--brand-primary));"></textarea>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse border-t theme-border theme-bg-body">
                    <button id="submitRoleBtn" type="button"
                        onclick="document.getElementById('addRoleForm').dispatchEvent(new Event('submit'))"
                        class="w-full inline-flex justify-center rounded-xl border border-transparent shadow-sm px-4 py-2 text-base font-medium text-white focus:outline-none sm:ml-3 sm:w-auto sm:text-sm hover:opacity-90"
                        style="background-color: rgb(var(--brand-primary));">
                        Create Role
                    </button>
                    <button type="button" onclick="document.getElementById('addRoleModal').classList.add('hidden')"
                        class="mt-3 w-full inline-flex justify-center rounded-xl border theme-border shadow-sm px-4 py-2 theme-bg-card text-base font-medium theme-text-main hover:bg-white/5 focus:outline-none sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                        Cancel
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- MODAL: Edit Role --}}
    <div id="editRoleModal" class="hidden fixed inset-0 z-[60] overflow-y-auto" aria-labelledby="modal-title"
        role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-black/80 backdrop-blur-sm transition-opacity" aria-hidden="true"
                onclick="window.closeEditRoleModal()"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

            <div class="inline-block align-bottom theme-bg-card border theme-border rounded-2xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg w-full">
                <div class="px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-blue-500/10 sm:mx-0 sm:h-10 sm:w-10">
                            <svg class="h-6 w-6 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                        </div>
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                            <h3 class="text-lg leading-6 font-bold theme-text-main">Edit Role Metadata</h3>
                            <div class="mt-4">
                                <form id="editRoleForm" class="space-y-4">
                                    <input type="hidden" id="edit_role_id">
                                    <div>
                                        <label class="block text-sm font-medium theme-text-muted mb-1">Role Name</label>
                                        <input type="text" id="edit_role_name" name="name"
                                            class="w-full px-4 py-2 theme-bg-body border theme-border rounded-xl focus:ring-2 outline-none transition-all theme-text-main"
                                            style="--tw-ring-color: rgb(var(--brand-primary));">
                                    </div>
                                    {{-- Lock status visualization --}}
                                    <div id="edit_lock_warning"
                                        class="hidden bg-red-500/10 border border-red-500/20 rounded-lg p-3 flex items-start space-x-2">
                                        <svg class="w-5 h-5 text-red-500 flex-shrink-0" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                        </svg>
                                        <p class="text-xs text-red-500">This is a System Protected Role. Critical permissions
                                            cannot be removed.</p>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse border-t theme-border theme-bg-body">
                    <button id="submitEditRoleBtn" type="button"
                        class="w-full inline-flex justify-center rounded-xl border border-transparent shadow-sm px-4 py-2 text-base font-medium text-white focus:outline-none sm:ml-3 sm:w-auto sm:text-sm hover:opacity-90"
                        style="background-color: rgb(var(--brand-primary));">
                        Save Changes
                    </button>
                    <button type="button" onclick="window.closeEditRoleModal()"
                        class="mt-3 w-full inline-flex justify-center rounded-xl border theme-border shadow-sm px-4 py-2 theme-bg-card text-base font-medium theme-text-main hover:bg-white/5 focus:outline-none sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                        Cancel
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        /* Premium Scrollbar */
        .custom-scrollbar::-webkit-scrollbar {
            height: 6px;
            width: 6px;
        }

        .custom-scrollbar::-webkit-scrollbar-track {
            background: transparent;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb {
            background-color: rgb(var(--border-color));
            border-radius: 20px;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background-color: rgb(var(--text-muted));
        }
    </style>
@endpush

@push('scripts')
    <script>
        const AUTH_TOKEN = localStorage.getItem('token');
        const BASE_URL = 'http://127.0.0.1:8000/api';
        const CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]')?.content || '';

        let roles = [];

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
            toast.className =
                `${bgColor} theme-text-main px-6 py-4 rounded-xl shadow-2xl flex items-center gap-3 transform translate-y-10 opacity-0 transition-all duration-300`;

            const icon = type === 'success' ?
                '<svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>' :
                '<svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>';

            toast.innerHTML = `${icon}<span class="font-medium text-sm">${message}</span>`;
            container.appendChild(toast);

            requestAnimationFrame(() => {
                toast.classList.remove('translate-y-10', 'opacity-0');
            });

            setTimeout(() => {
                toast.classList.add('opacity-0', 'translate-y-2');
                setTimeout(() => toast.remove(), 300);
            }, 3000);
        }

        // --- 2. API Handler (FIXED) ---
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
                
                // Read as text first to handle empty 204 No Content responses safely
                const text = await response.text();
                let data = {};
                if (text) {
                    try {
                        data = JSON.parse(text);
                    } catch(e) {
                        data = { message: text };
                    }
                }

                if (!response.ok) throw {
                    status: response.status,
                    data
                };
                return data;
            } catch (error) {
                console.error(`API Error (${method} ${endpoint}):`, error);
                throw error;
            }
        }

        // --- 3. Initial Loader (FIXED ARRAY EXTRACTION) ---
        async function loadRoles() {
            try {
                document.getElementById('roles-loading').classList.remove('hidden');

                const roleRes = await fetchData('/roles');
                
                // Handle different backend array formats safely
                const rolesData = Array.isArray(roleRes.data) ? roleRes.data : (Array.isArray(roleRes) ? roleRes : []);

                // Sort: Super Admin first, then alphabetical
                roles = rolesData.map(r => ({
                    ...r,
                    is_system: ['super admin', 'sub-admin'].includes(r.name.toLowerCase())
                })).sort((a, b) => {
                    if (a.name.toLowerCase() === 'super admin') return -1;
                    if (b.name.toLowerCase() === 'super admin') return 1;
                    return a.name.localeCompare(b.name);
                });

                updateStats();
                renderRoleDirectory();

            } catch (e) {
                showToaster(e.data?.message || 'Failed to load roles', 'error');
            } finally {
                document.getElementById('roles-loading').classList.add('hidden');
            }
        }

        function updateStats() {
            document.getElementById('stat-total-roles').textContent = roles.length;
            document.getElementById('stat-system-roles').textContent = roles.filter(r => r.is_system).length;
            document.getElementById('stat-custom-roles').textContent = roles.filter(r => !r.is_system).length;
        }

        // --- 4. Render Logic (Directory/Cards) ---
        function renderRoleDirectory() {
            const container = document.getElementById('role-list-container');
            const searchTerm = document.getElementById('role-search').value.toLowerCase();
            container.innerHTML = '';

            const filteredRoles = roles.filter(r => r.name.toLowerCase().includes(searchTerm));

            if (filteredRoles.length === 0) {
                container.innerHTML =
                    `<div class="col-span-full text-center py-10 theme-text-muted">No roles found matching "${searchTerm}"</div>`;
                return;
            }

            filteredRoles.forEach(role => {
                const isSystem = role.is_system;
                const permissionsCount = role.permissions ? role.permissions.length : 0;

                // Buttons
                const editBtn =
                    `<button onclick="window.openEditRoleModal('${role.id}', '${role.name}', ${isSystem})" class="p-2 theme-text-muted hover:text-blue-500 hover:bg-white/10 rounded-lg transition" title="Edit Metadata"><svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg></button>`;

                // Super Admin cannot be deleted
                const deleteBtn = isSystem && role.name.toLowerCase() === 'super admin' ?
                    `<button disabled class="p-2 text-gray-500 cursor-not-allowed opacity-50" title="System Locked"><svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg></button>` :
                    `<button onclick="window.deleteRole('${role.id}')" class="p-2 theme-text-muted hover:text-red-500 hover:bg-white/10 rounded-lg transition" title="Delete Role"><svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg></button>`;

                // Badge Logic
                const badgeClass = isSystem ?
                    'bg-red-500/10 text-red-500 border-red-500/20' :
                    'bg-emerald-500/10 text-emerald-500 border-emerald-500/20';
                const badgeText = isSystem ? 'System Protected' : 'Custom Defined';

                // Description mock
                const desc = isSystem ?
                    "High-level administrative access with immutable core permissions." :
                    "User-defined role with specific access scopes.";

                const html = `
                <div class="theme-bg-card rounded-2xl p-6 border theme-border shadow-sm hover:shadow-md transition-all duration-300 flex flex-col h-full relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-24 h-24 bg-gradient-to-br from-white/5 to-transparent rounded-bl-full -mr-4 -mt-4 pointer-events-none"></div>
                    
                    <div class="flex justify-between items-start mb-4 z-10">
                        <div class="p-2.5 rounded-lg" style="${isSystem ? 'background-color: rgba(239, 68, 68, 0.1); color: rgb(239, 68, 68);' : 'background-color: rgba(var(--brand-primary), 0.1); color: rgb(var(--brand-primary));'}">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20v-2c0-.656-.126-1.283-.356-1.857M9 20H7a4 4 0 01-4-4v-2.586a1 1 0 01.293-.707l3.95-3.95a1 1 0 01.707-.293h2.586M7 20v-2c0-.656.126-1.283.356-1.857M11 5a2 2 0 11-4 0 2 2 0 014 0zM12 12a4 4 0 100-8 4 4 0 000 8z"></path>
                            </svg>
                        </div>
                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] uppercase font-bold tracking-wider border ${badgeClass}">${badgeText}</span>
                    </div>

                    <h3 class="text-xl font-bold theme-text-main mb-2">${role.name}</h3>
                    <p class="text-sm theme-text-muted mb-6 flex-grow leading-relaxed">${desc}</p>
                    
                    <div class="flex items-center justify-between pt-4 border-t theme-border mt-auto">
                        <div class="flex flex-col">
                            <span class="text-xs theme-text-muted font-semibold uppercase tracking-wider">Permissions</span>
                            <span class="text-sm font-bold theme-text-main">${permissionsCount} Assigned</span>
                        </div>
                        <div class="flex items-center gap-1 theme-bg-body p-1 rounded-lg border theme-border">
                            ${editBtn}
                            ${deleteBtn}
                        </div>
                    </div>
                </div>`;
                container.innerHTML += html;
            });
        }

        window.filterRoles = renderRoleDirectory;

        // --- 5. Actions: Create ---
        document.getElementById('addRoleForm').addEventListener('submit', async (e) => {
            e.preventDefault();
            const btn = document.getElementById('submitRoleBtn');
            const name = document.getElementById('role_name').value.trim();

            if (!name) {
                showToaster('Role Name is required', 'error');
                return;
            }

            btn.disabled = true;
            btn.innerHTML =
                '<svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white inline" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> Creating...';

            try {
                await fetchData('/roles', 'POST', {
                    name
                });
                showToaster('Role created successfully!');
                e.target.reset();
                document.getElementById('addRoleModal').classList.add('hidden');
                await loadRoles();
            } catch (err) {
                showToaster(err.data?.message || 'Creation failed', 'error');
            } finally {
                btn.disabled = false;
                btn.innerText = 'Create Role';
            }
        });

        // --- 6. Actions: Delete ---
        window.deleteRole = async function(id) {
            const role = roles.find(r => r.id == id);
            if (!role) return;

            if (!confirm(
                    `Are you sure you want to delete "${role.name}"?\n\nThis will revoke access for all users currently assigned to this role.`
                )) return;

            try {
                await fetchData(`/roles/${id}`, 'DELETE');
                showToaster(`Role "${role.name}" deleted`);
                await loadRoles();
            } catch (e) {
                showToaster(e.data?.message || 'Failed to delete role', 'error');
            }
        };

        // --- 7. Actions: Edit ---
        window.openEditRoleModal = function(id, name, isSystem) {
            document.getElementById('edit_role_id').value = id;
            document.getElementById('edit_role_name').value = name;

            const lockWarning = document.getElementById('edit_lock_warning');
            const nameInput = document.getElementById('edit_role_name');

            if (isSystem && name.toLowerCase() === 'super admin') {
                lockWarning.classList.remove('hidden');
                nameInput.disabled = true;
                nameInput.classList.add('bg-gray-500/10', 'text-gray-500');
            } else {
                lockWarning.classList.add('hidden');
                nameInput.disabled = false;
                nameInput.classList.remove('bg-gray-500/10', 'text-gray-500');
            }

            document.getElementById('editRoleModal').classList.remove('hidden');
        };

        window.closeEditRoleModal = function() {
            document.getElementById('editRoleModal').classList.add('hidden');
        };

        document.getElementById('submitEditRoleBtn').addEventListener('click', async function() {
            const id = document.getElementById('edit_role_id').value;
            const name = document.getElementById('edit_role_name').value.trim();
            const btn = this;

            if (!name) {
                showToaster('Role name is required', 'error');
                return;
            }

            btn.disabled = true;
            btn.innerText = 'Saving...';

            try {
                await fetchData(`/roles/${id}`, 'PUT', {
                    name: name
                });
                showToaster('Role updated successfully');
                closeEditRoleModal();
                await loadRoles();
            } catch (e) {
                showToaster(e.data?.message || 'Update failed', 'error');
            } finally {
                btn.disabled = false;
                btn.innerText = 'Save Changes';
            }
        });

        // Initialize
        document.addEventListener('DOMContentLoaded', loadRoles);
    </script>
@endpush