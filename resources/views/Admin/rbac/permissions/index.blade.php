@extends('layouts.app')

 

 

{{-- @push('scripts')
    <script>
        const AUTH_TOKEN = localStorage.getItem('token');
        const BASE_URL = 'http://127.0.0.1:8000/api';
        const CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]')?.content || '';

        let permissions = [];
        let permissionsByCategory = {};
        let currentFilterCategory = 'All';

        const STATIC_MODULES = [
            'Finance',
            'Users',
            'KYC',
            'Vendors',
            'Bookings',
            'System',
            'Security',
            'Support'
        ];

        // --- Notifications ---
        function showToaster(message, type = 'success') {
            let container = document.getElementById('toast-container');
            if (!container) {
                container = document.createElement('div');
                container.id = 'toast-container';
                container.className = 'fixed bottom-5 right-5 space-y-3 z-[100]';
                document.body.appendChild(container);
            }

            const toast = document.createElement('div');
            const bgColor = type === 'success' ? 'theme-bg-card border theme-border' :
                'bg-red-500/20 border border-red-500/50';
            toast.className =
                `${bgColor} theme-text-main px-6 py-4 rounded-xl shadow-2xl flex items-center gap-3 transform translate-y-10 opacity-0 transition-all duration-300`;
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

        async function fetchData(endpoint, method = 'GET', body = null) {
            const fingerprint = localStorage.getItem('device_fingerprint') || 'unknown';

            const headers = {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': CSRF_TOKEN,
                'X-Device-Fingerprint': fingerprint
            };

            if (AUTH_TOKEN) headers['Authorization'] = `Bearer ${AUTH_TOKEN}`;

            try {
                const response = await fetch(`${BASE_URL}${endpoint}`, {
                    method,
                    headers,
                    body: body ? JSON.stringify(body) : null
                });

                // Safe parsing for empty responses (like 204 Delete)
                const text = await response.text();
                let data = {};
                if (text) {
                    try {
                        data = JSON.parse(text);
                    } catch (e) {
                        data = {
                            message: text
                        };
                    }
                }

                if (!response.ok) throw {
                    status: response.status,
                    data
                };
                return data;
            } catch (error) {
                console.error(`API Error:`, error);
                throw error;
            }
        }

        // --- Data Loading ---
        async function loadPermissionsData() {
            try {
                document.getElementById('catalog-loading').classList.remove('hidden');

                const permRes = await fetchData('/permissions');
                console.log('Raw Permissions Response:', permRes);


                let rawData = [];

                if (permRes?.data && Array.isArray(permRes.data[""])) {
                    rawData = permRes.data[""];
                } else if (Array.isArray(permRes.data)) {
                    rawData = permRes.data;
                } else if (Array.isArray(permRes)) {
                    rawData = permRes;
                }


                permissions = rawData.map(p => ({
                    ...p,
                    category: p.module || getFallbackCategory(p.name),
                    risk: p.risk || determineRiskLevel(p.name)
                }));


                updateStats();
                groupPermissions();
                renderCategoriesSidebar();
                renderPermissionTable();

            } catch (e) {
                console.error('Mapping Error:', e);
                showToaster(e.data?.message || 'Failed to load permissions', 'error');
            } finally {
                document.getElementById('catalog-loading').classList.add('hidden');
            }
        }

        function getFallbackCategory(name) {
            const n = name.toLowerCase();
            if (n.includes('finance') || n.includes('refund') || n.includes('payout')) return 'Finance Operations';
            if (n.includes('user') || n.includes('ban')) return 'User Management';
            if (n.includes('kyc')) return 'KYC Operations';
            if (n.includes('security') || n.includes('role')) return 'Security Controls';
            return 'System Controls';
        }

        function determineRiskLevel(name) {
            const n = name.toLowerCase();
            if (n.includes('delete') || n.includes('ban') || n.includes('execute') || n.includes('override') || n.includes(
                    'refund')) return 'High';
            if (n.includes('update') || n.includes('edit') || n.includes('approve')) return 'Medium';
            return 'Low';
        }

        function groupPermissions() {
            permissionsByCategory = permissions.reduce((acc, p) => {
                if (!acc[p.category]) acc[p.category] = [];
                acc[p.category].push(p);
                return acc;
            }, {});
        }

        function updateStats() {
            document.getElementById('stat-total-permissions').textContent = permissions.length;
            document.getElementById('stat-total-groups').textContent = new Set(permissions.map(p => p.category)).size;
            document.getElementById('stat-high-risk').textContent = permissions.filter(p => p.risk === 'High').length;
            document.getElementById('badge-all').textContent = permissions.length;
        }

        // --- Rendering ---
        function renderCategoriesSidebar() {
            const list = document.getElementById('category-list');
            list.innerHTML = '';

            Object.keys(permissionsByCategory).sort().forEach(cat => {
                const count = permissionsByCategory[cat].length;
                const btn = document.createElement('button');
                btn.className =
                    `category-filter-btn w-full text-left flex items-center justify-between px-3 py-2.5 rounded-lg text-sm theme-text-muted transition-colors`;
                btn.id = `btn-filter-${cat.replace(/\s+/g, '-')}`;
                btn.onclick = () => filterPermissions(cat);
                btn.innerHTML =
                    `<span class="truncate font-medium">${cat}</span><span class="text-xs theme-bg-body border theme-border px-2 py-0.5 rounded-full theme-text-muted ml-2">${count}</span>`;
                list.appendChild(btn);
            });
        }

        window.filterPermissions = function(cat) {
            currentFilterCategory = cat;
            document.getElementById('current-category-title').textContent = cat === 'All' ? 'All Permissions' :
                `${cat} Permissions`;


            document.querySelectorAll('.category-filter-btn').forEach(b => {
                b.classList.remove('active-category-btn');
                b.style.backgroundColor = '';
                b.style.color = '';
                b.style.borderRight = '';
            });


            const activeBtnId = cat === 'All' ? 'btn-filter-All' : `btn-filter-${cat.replace(/\s+/g, '-')}`;
            const activeBtn = document.getElementById(activeBtnId);
            if (activeBtn) {
                activeBtn.classList.add('active-category-btn');
                activeBtn.style.backgroundColor = 'rgba(var(--brand-primary), 0.1)';
                activeBtn.style.color = 'rgb(var(--brand-primary))';
                activeBtn.style.borderRight = '3px solid rgb(var(--brand-primary))';
            }

            renderPermissionTable();
        };

        window.renderPermissionTable = function() {
            const body = document.getElementById('permission-body');
            const searchTerm = document.getElementById('permission-search').value.toLowerCase();
            body.innerHTML = '';

            let filtered = permissions;

            if (currentFilterCategory !== 'All') {
                filtered = filtered.filter(p => p.category === currentFilterCategory);
            }

            if (searchTerm) {
                filtered = filtered.filter(p => p.name.toLowerCase().includes(searchTerm) || p.category.toLowerCase()
                    .includes(searchTerm));
            }

            if (filtered.length === 0) {
                body.innerHTML =
                    `<tr><td colspan="4" class="px-6 py-10 text-center theme-text-muted">No permissions found in this category.</td></tr>`;
                return;
            }

            filtered.sort((a, b) => a.name.localeCompare(b.name)).forEach(p => {

                let riskBadge = '';
                if (p.risk === 'High') riskBadge =
                    '<span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-red-500/10 text-red-500 border border-red-500/20">High Risk</span>';
                else if (p.risk === 'Medium') riskBadge =
                    '<span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-amber-500/10 text-amber-500 border border-amber-500/20">Medium</span>';
                else riskBadge =
                    '<span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-green-500/10 text-green-500 border border-green-500/20">Low</span>';

                const row = `
                <tr class="transition-colors duration-200 hover:bg-white/5">
                    <td class="px-6 py-4">
                        <div class="flex items-center">
                            <div class="h-8 w-8 rounded theme-bg-body theme-text-muted flex items-center justify-center mr-3 font-mono text-xs font-bold border theme-border">
                                ${p.name.charAt(0).toUpperCase()}
                            </div>
                            <span class="font-semibold theme-text-main font-mono text-sm">${p.name}</span>
                        </div>
                    </td>
                        <td class="px-6 py-4">
                            <span class="theme-text-muted px-2 py-1 rounded border">
                                ${p.module}
                            </span>
                        </td>
                    <td class="px-6 py-4">${riskBadge}</td>
                    <td class="px-6 py-4 text-right flex justify-end items-center gap-1">
                        <button onclick="window.openEditPermissionModal('${p.id}')" class="theme-text-muted hover:text-blue-500 transition-colors p-1 rounded hover:bg-blue-500/10" title="Edit Permission">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                            </svg>
                        </button>
                        <button onclick="window.deletePermission('${p.id}')" class="theme-text-muted hover:text-red-500 transition-colors p-1 rounded hover:bg-red-500/10" title="Deprecate/Delete">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                        </button>
                    </td>
                </tr>`;
                body.innerHTML += row;
            });
        };

        // --- Actions ---

        // Create
        document.getElementById('editPermissionForm').addEventListener('submit', async (e) => {
            e.preventDefault();

            const btn = document.getElementById('submitEditPermissionBtn');
            const id = document.getElementById('edit_permission_id').value;
            const name = document.getElementById('edit_permission_name').value.trim();
            const module = document.getElementById('edit_permission_module').value;
            const risk = document.getElementById('edit_permission_risk').value;

            if (!name || !module) {
                showToaster('Identifier and Module are required', 'error');
                return;
            }

            btn.disabled = true;
            btn.innerText = 'Updating...';

            try {
                await fetchData(`/permissions/${id}`, 'PUT', {
                    name,
                    module,
                    risk
                });

                showToaster('Permission updated successfully!');
                closeEditPermissionModal();
                await loadPermissionsData();
            } catch (err) {
                showToaster(err.data?.message || 'Failed to update permission', 'error');
            } finally {
                btn.disabled = false;
                btn.innerText = 'Update Catalog';
            }
        });

        window.openEditPermissionModal = function(id) {
            const p = permissions.find(x => x.id == id);
            if (!p) return;

            document.getElementById('edit_permission_id').value = p.id;
            document.getElementById('edit_permission_name').value = p.name;
            document.getElementById('edit_permission_module').value = p.module || '';
            document.getElementById('edit_permission_risk').value = p.risk || 'Low';

            document.getElementById('editPermissionModal').classList.remove('hidden');
        };

        window.closeEditPermissionModal = function() {
            document.getElementById('editPermissionModal').classList.add('hidden');
            document.getElementById('editPermissionForm').reset();
        };

        // Update
        // document.getElementById('editPermissionForm').addEventListener('submit', async (e) => {
        //     e.preventDefault();
        //     const btn = document.getElementById('submitEditPermissionBtn');
        //     const id = document.getElementById('edit_permission_id').value;
        //     const name = document.getElementById('edit_permission_name').value.trim();
        //     const module = document.getElementById('edit_permission_module').value;
        //     const risk = document.getElementById('edit_permission_risk').value;

        //     if (!name || !cat) {
        //         showToaster('Identifier and Group are required', 'error');
        //         return;
        //     }

        //     btn.disabled = true;
        //     btn.innerText = 'Updating...';

        //     try {
        //         await fetchData(`/permissions/${id}`, 'PUT', {
        //             name,
        //             category: cat,
        //             risk
        //         });
        //         showToaster('Permission updated successfully!');
        //         closeEditPermissionModal();
        //         await loadPermissionsData();
        //     } catch (err) {
        //         showToaster(err.data?.message || 'Failed to update permission', 'error');
        //     } finally {
        //         btn.disabled = false;
        //         btn.innerText = 'Update Catalog';
        //     }
        // });


        document.getElementById('addPermissionForm').addEventListener('submit', async (e) => {
            e.preventDefault();

            const name = document.getElementById('permission_name').value.trim();
            const module = document.getElementById('permission_module').value;
            const risk = document.getElementById('permission_risk').value;

            if (!name || !module) {
                showToaster('Identifier and Module are required', 'error');
                return;
            }

            await fetchData('/permissions', 'POST', {
                name,
                module,
                risk
            });

            showToaster('Permission created successfully');
            document.getElementById('addPermissionModal').classList.add('hidden');
            loadPermissionsData();
        });

        // Delete
        window.deletePermission = async function(id) {
            const perm = permissions.find(p => p.id == id);
            if (!perm) return;

            if (!confirm(
                    `DANGER: Deprecating "${perm.name}" may break active roles and system features relying on this identifier.\n\nAre you absolutely sure?`
                )) return;

            try {
                await fetchData(`/permissions/${id}`, 'DELETE');
                showToaster(`Permission ${perm.name} removed`);
                await loadPermissionsData();
            } catch (err) {
                showToaster(err.data?.message || 'Failed to delete permission', 'error');
            }
        }

        // Initialize
        document.addEventListener('DOMContentLoaded', () => {
            STATIC_MODULES.forEach(m => {
                permission_module.append(new Option(m, m));
                edit_permission_module.append(new Option(m, m));
            });

            loadPermissionsData();
        });
    </script>
@endpush --}}



@section('content')
    <div id="app" class="min-h-screen theme-bg-body theme-text-main space-y-8 p-6 lg:p-10 font-sans">

        {{-- A. Header Section --}}
        <header class="flex flex-col md:flex-row md:items-end md:justify-between space-y-4 md:space-y-0">
            <div>
                <h1 class="text-3xl md:text-4xl font-extrabold theme-text-main tracking-tight">
                    Permission Catalog
                </h1>
                <p class="text-base theme-text-muted mt-2 max-w-2xl">
                    Define and categorize atomic, composable capabilities across the platform.
                </p>
            </div>

            <div class="flex flex-wrap gap-3">
                <button onclick="document.getElementById('addPermissionModal').classList.remove('hidden')"
                    class="inline-flex items-center px-5 py-2.5 text-white font-semibold rounded-xl shadow-lg transition-all duration-300 transform hover:-translate-y-0.5 hover:opacity-90"
                    style="background-color: rgb(var(--brand-primary)); box-shadow: 0 4px 14px rgba(var(--brand-primary), 0.4);">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    New Permission
                </button>
            </div>
        </header>

        {{-- B. Stats Overview --}}
        <section id="stats-section" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            <div
                class="group theme-bg-card p-6 rounded-2xl shadow-sm border theme-border hover:shadow-md transition-all duration-300">
                <div class="flex items-center justify-between mb-4">
                    <div class="p-3 rounded-xl bg-emerald-500/10 text-emerald-500">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
                <p class="theme-text-muted text-sm font-medium">Total Atomic Permissions</p>
                <h3 class="text-3xl font-bold theme-text-main" id="stat-total-permissions">0</h3>
            </div>

            <div
                class="group theme-bg-card p-6 rounded-2xl shadow-sm border theme-border hover:shadow-md transition-all duration-300">
                <div class="flex items-center justify-between mb-4">
                    <div class="p-3 rounded-xl bg-blue-500/10 text-blue-500">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z">
                            </path>
                        </svg>
                    </div>
                </div>
                <p class="theme-text-muted text-sm font-medium">Active Modules</p>
                <h3 class="text-3xl font-bold theme-text-main" id="stat-total-groups">0</h3>
            </div>

            <div
                class="group theme-bg-card p-6 rounded-2xl shadow-sm border theme-border hover:shadow-md transition-all duration-300">
                <div class="flex items-center justify-between mb-4">
                    <div class="p-3 rounded-xl bg-orange-500/10 text-orange-500">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
                            </path>
                        </svg>
                    </div>
                </div>
                <p class="theme-text-muted text-sm font-medium">High Risk Actions</p>
                <h3 class="text-3xl font-bold theme-text-main" id="stat-high-risk">0</h3>
            </div>
        </section>

        {{-- C. Main Catalog Interface --}}
        <section class="flex flex-col lg:flex-row gap-6">
            <aside class="w-full lg:w-64 flex-shrink-0">
                <div class="sticky top-6 theme-bg-card rounded-2xl shadow-sm border theme-border overflow-hidden">
                    <div class="p-4 border-b theme-border" style="background-color: rgba(var(--bg-body), 0.5);">
                        <h3 class="text-xs font-bold uppercase tracking-wider theme-text-muted">Module Filter</h3>
                    </div>
                    <div id="category-list" class="p-3 space-y-1 max-h-[70vh] overflow-y-auto custom-scrollbar">
                    </div>
                </div>
            </aside>

            <main class="flex-grow min-w-0">
                <div
                    class="theme-bg-card rounded-2xl shadow-sm border theme-border overflow-hidden relative min-h-[400px]">
                    <div class="px-6 py-4 border-b theme-border flex justify-between items-center"
                        style="background-color: rgba(var(--bg-body), 0.5);">
                        <h2 class="text-lg font-bold theme-text-main" id="current-category-title">Loading...</h2>
                        <div class="relative">
                            <input type="text" id="permission-search" placeholder="Search in this module..."
                                class="pl-10 pr-4 py-2 theme-bg-body border theme-border rounded-xl text-sm theme-text-main focus:ring-2 placeholder-gray-500 w-64 outline-none"
                                style="--tw-ring-color: rgb(var(--brand-primary));"
                                onkeyup="window.renderPermissionTable()">
                            <svg class="w-4 h-4 theme-text-muted absolute left-3 top-3" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                    </div>

                    <div id="catalog-loading"
                        class="absolute inset-0 bg-black/50 backdrop-blur-sm z-30 flex flex-col items-center justify-center">
                        <div class="animate-spin rounded-full h-10 w-10 border-b-2 mb-4"
                            style="border-color: rgb(var(--brand-primary));"></div>
                        <span class="font-semibold animate-pulse" style="color: rgb(var(--brand-primary));">Syncing
                            Permissions...</span>
                    </div>

                    <div class="overflow-x-auto custom-scrollbar">
                        <table class="w-full text-sm text-left border-collapse">
                            <thead class="theme-text-muted border-b theme-border"
                                style="background-color: rgba(var(--bg-body), 0.5);">
                                <tr>
                                    <th class="px-6 py-4 font-bold uppercase tracking-wider text-xs">Identifier</th>
                                    <th class="px-6 py-4 font-bold uppercase tracking-wider text-xs">Module</th>
                                    <th class="px-6 py-4 font-bold uppercase tracking-wider text-xs">Risk Level</th>
                                    <th class="px-6 py-4 font-bold uppercase tracking-wider text-xs text-right">Actions
                                    </th>
                                </tr>
                            </thead>
                            <tbody id="permission-body" class="divide-y theme-border"></tbody>
                        </table>
                    </div>
                </div>
            </main>
        </section>
    </div>


    {{-- MODAL: Create Permission --}}
    <div id="addPermissionModal" class="hidden fixed inset-0 z-[60] overflow-y-auto">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-black/80 backdrop-blur-sm transition-opacity"
                onclick="document.getElementById('addPermissionModal').classList.add('hidden')"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>
            <div
                class="inline-block align-bottom theme-bg-card border theme-border rounded-2xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg w-full">
                <div class="px-4 pt-5 pb-4 sm:p-6">
                    <div class="sm:flex sm:items-start">
                        <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full sm:mx-0 sm:h-10 sm:w-10"
                            style="background-color: rgba(var(--brand-primary), 0.1); color: rgb(var(--brand-primary));">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM12 10a4 4 0 00-4 4v2a2 2 0 002 2h6a2 2 0 002-2v-2a4 4 0 00-4-4h-2z">
                                </path>
                            </svg>
                        </div>
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                            <h3 class="text-lg leading-6 font-bold theme-text-main">Create Permission</h3>
                            <p class="text-xs theme-text-muted mt-1">Define an atomic action for the system.</p>

                            <form id="addPermissionForm" class="mt-4 space-y-4">
                                <div>
                                    <label class="block text-sm font-medium theme-text-muted mb-1">Permission
                                        Identifier</label>
                                    <input type="text" id="permission_name" name="name"
                                        placeholder="e.g. refund_approve_full"
                                        class="w-full px-4 py-2 theme-bg-body border theme-border rounded-xl focus:ring-2 outline-none theme-text-main"
                                        style="--tw-ring-color: rgb(var(--brand-primary));">
                                    <span class="text-[10px] theme-text-muted mt-1 block">Use snake_case for standard
                                        conventions.</span>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium theme-text-muted mb-1">Module</label>
                                    <select id="permission_module"
                                        class="w-full px-4 py-2 theme-bg-body border theme-border rounded-xl focus:ring-2 outline-none theme-text-main"
                                        style="--tw-ring-color: rgb(var(--brand-primary));">
                                        <option value="">Select Module</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium theme-text-muted mb-1">Risk Level</label>
                                    <select id="permission_risk" name="risk"
                                        class="w-full px-4 py-2 theme-bg-body border theme-border rounded-xl focus:ring-2 outline-none theme-text-main"
                                        style="--tw-ring-color: rgb(var(--brand-primary));">
                                        <option value="Low">Low Risk</option>
                                        <option value="Medium">Medium Risk</option>
                                        <option value="High">High Risk (Execute/Destructive)</option>
                                    </select>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse border-t theme-border theme-bg-body">
                    <button id="submitPermissionBtn" type="button"
                        onclick="document.getElementById('addPermissionForm').dispatchEvent(new Event('submit'))"
                        class="w-full inline-flex justify-center rounded-xl border border-transparent shadow-sm px-4 py-2 text-base font-medium text-white hover:opacity-90 transition sm:ml-3 sm:w-auto sm:text-sm"
                        style="background-color: rgb(var(--brand-primary));">
                        Save to Catalog
                    </button>
                    <button type="button" onclick="document.getElementById('addPermissionModal').classList.add('hidden')"
                        class="mt-3 w-full inline-flex justify-center rounded-xl border theme-border shadow-sm px-4 py-2 theme-bg-card text-base font-medium theme-text-muted hover:bg-white/5 transition sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                        Cancel
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- MODAL: Edit Permission --}}
    <div id="editPermissionModal" class="hidden fixed inset-0 z-[60] overflow-y-auto">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-black/80 backdrop-blur-sm transition-opacity"
                onclick="window.closeEditPermissionModal()"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>
            <div
                class="inline-block align-bottom theme-bg-card border theme-border rounded-2xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg w-full">
                <div class="px-4 pt-5 pb-4 sm:p-6">
                    <div class="sm:flex sm:items-start">
                        <div
                            class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-blue-500/10 text-blue-500 sm:mx-0 sm:h-10 sm:w-10">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                </path>
                            </svg>
                        </div>
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                            <h3 class="text-lg leading-6 font-bold theme-text-main">Edit Permission</h3>
                            <p class="text-xs theme-text-muted mt-1">Update the settings for this atomic capability.</p>

                            <form id="editPermissionForm" class="mt-4 space-y-4">
                                <input type="hidden" id="edit_permission_id">
                                <div>
                                    <label class="block text-sm font-medium theme-text-muted mb-1">Permission
                                        Identifier</label>
                                    <input type="text" id="edit_permission_name" name="name"
                                        class="w-full px-4 py-2 theme-bg-body border theme-border rounded-xl focus:ring-2 outline-none theme-text-main"
                                        style="--tw-ring-color: rgb(var(--brand-primary));">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium theme-text-muted mb-1">Module</label>
                                    <select id="edit_permission_module"
                                        class="w-full px-4 py-2 theme-bg-body border theme-border rounded-xl focus:ring-2 outline-none theme-text-main"
                                        style="--tw-ring-color: rgb(var(--brand-primary));"></select>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium theme-text-muted mb-1">Risk Level</label>
                                    <select id="edit_permission_risk" name="risk"
                                        class="w-full px-4 py-2 theme-bg-body border theme-border rounded-xl focus:ring-2 outline-none theme-text-main"
                                        style="--tw-ring-color: rgb(var(--brand-primary));">
                                        <option value="Low">Low Risk</option>
                                        <option value="Medium">Medium Risk</option>
                                        <option value="High">High Risk (Execute/Destructive)</option>
                                    </select>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse border-t theme-border theme-bg-body">
                    <button id="submitEditPermissionBtn" type="button"
                        onclick="document.getElementById('editPermissionForm').dispatchEvent(new Event('submit'))"
                        class="w-full inline-flex justify-center rounded-xl border border-transparent shadow-sm px-4 py-2 text-base font-medium text-white bg-blue-600 hover:bg-blue-700 transition sm:ml-3 sm:w-auto sm:text-sm">
                        Update Catalog
                    </button>
                    <button type="button" onclick="window.closeEditPermissionModal()"
                        class="mt-3 w-full inline-flex justify-center rounded-xl border theme-border shadow-sm px-4 py-2 theme-bg-card text-base font-medium theme-text-muted hover:bg-white/5 transition sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                        Cancel
                    </button>
                </div>
            </div>
        </div>
    </div>

@endsection


@push('scripts')
    <script>
        const AUTH_TOKEN = localStorage.getItem('token');
        const BASE_URL = 'http://127.0.0.1:8000/api';
        const CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]')?.content || '';

        let permissions = [];
        let currentFilterCategory = 'Finance'; // Default starting category

        const STATIC_MODULES = [
            'Finance', 'Users', 'KYC', 'Vendors', 'Bookings', 'System', 'Security', 'Support'
        ];

        // --- Helper: Notifications ---
        function showToaster(message, type = 'success') {
            let container = document.getElementById('toast-container') || Object.assign(document.createElement('div'), {
                id: 'toast-container',
                className: 'fixed bottom-5 right-5 space-y-3 z-[100]'
            });
            if (!container.parentElement) document.body.appendChild(container);

            const toast = document.createElement('div');
            toast.className =
                `${type === 'success' ? 'theme-bg-card border theme-border' : 'bg-red-500/20 border border-red-500/50'} theme-text-main px-6 py-4 rounded-xl shadow-2xl flex items-center gap-3 transform translate-y-10 opacity-0 transition-all duration-300`;
            toast.innerHTML = `<span class="font-medium text-sm">${message}</span>`;
            container.appendChild(toast);
            setTimeout(() => toast.classList.remove('translate-y-10', 'opacity-0'), 10);
            setTimeout(() => {
                toast.classList.add('opacity-0');
                setTimeout(() => toast.remove(), 300);
            }, 3000);
        }

        async function fetchData(endpoint, method = 'GET', body = null) {
            const headers = {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': CSRF_TOKEN,
                'Authorization': `Bearer ${AUTH_TOKEN}`
            };
            try {
                const response = await fetch(`${BASE_URL}${endpoint}`, {
                    method,
                    headers,
                    body: body ? JSON.stringify(body) : null
                });
                const text = await response.text();
                const data = text ? JSON.parse(text) : {};
                if (!response.ok) throw {
                    status: response.status,
                    data
                };
                return data;
            } catch (error) {
                throw error;
            }
        }

        // --- Data Logic ---
        async function loadPermissionsData() {
            try {
                document.getElementById('catalog-loading').classList.remove('hidden');
                const res = await fetchData('/permissions');

                // 1. Flatten the grouped object from API
                let rawData = [];
                if (res?.data && typeof res.data === 'object' && !Array.isArray(res.data)) {
                    rawData = Object.values(res.data).flat();
                } else {
                    rawData = Array.isArray(res.data) ? res.data : (Array.isArray(res) ? res : []);
                }

                // 2. Map & Normalize (Handle null modules as 'System')
                permissions = rawData.map(p => ({
                    ...p,
                    module: p.module || 'System',
                    risk: p.risk || determineRiskLevel(p.name)
                }));

                updateStats();
                renderCategoriesSidebar();
                renderPermissionTable();
            } catch (e) {
                showToaster('Failed to load permissions', 'error');
            } finally {
                document.getElementById('catalog-loading').classList.add('hidden');
            }
        }

        function determineRiskLevel(name) {
            const n = name.toLowerCase();
            if (n.includes('delete') || n.includes('ban') || n.includes('refund')) return 'High';
            if (n.includes('edit') || n.includes('update') || n.includes('approve')) return 'Medium';
            return 'Low';
        }

        function updateStats() {
            document.getElementById('stat-total-permissions').textContent = permissions.length;
            document.getElementById('stat-total-groups').textContent = new Set(permissions.map(p => p.module)).size;
            document.getElementById('stat-high-risk').textContent = permissions.filter(p => p.risk === 'High').length;
        }

        // --- UI Rendering ---
        function renderCategoriesSidebar() {
            const list = document.getElementById('category-list');
            list.innerHTML = '';

            STATIC_MODULES.forEach(mod => {
                const count = permissions.filter(p => p.module === mod).length;
                const isActive = currentFilterCategory === mod;

                const btn = document.createElement('button');
                btn.className =
                    `w-full text-left flex items-center justify-between px-3 py-2.5 rounded-lg text-sm transition-all duration-200 ${isActive ? 'active-mod-btn' : 'theme-text-muted hover:bg-white/5'}`;

                if (isActive) {
                    btn.style.backgroundColor = 'rgba(var(--brand-primary), 0.1)';
                    btn.style.color = 'rgb(var(--brand-primary))';
                    btn.style.borderRight = '3px solid rgb(var(--brand-primary))';
                }

                btn.onclick = () => {
                    currentFilterCategory = mod;
                    renderCategoriesSidebar();
                    renderPermissionTable();
                };

                btn.innerHTML = `
                    <span class="font-medium">${mod}</span>
                    <span class="text-xs theme-bg-body border theme-border px-2 py-0.5 rounded-full">${count}</span>
                `;
                list.appendChild(btn);
            });
        }

        window.renderPermissionTable = function() {
            const body = document.getElementById('permission-body');
            const searchTerm = document.getElementById('permission-search').value.toLowerCase();
            document.getElementById('current-category-title').textContent = `${currentFilterCategory} Module`;

            body.innerHTML = '';

            const filtered = permissions.filter(p =>
                p.module === currentFilterCategory &&
                (p.name.toLowerCase().includes(searchTerm))
            );

            if (filtered.length === 0) {
                body.innerHTML =
                    `<tr><td colspan="4" class="px-6 py-10 text-center theme-text-muted">No permissions found in ${currentFilterCategory}.</td></tr>`;
                return;
            }

            filtered.sort((a, b) => a.name.localeCompare(b.name)).forEach(p => {
                const riskClass = p.risk === 'High' ? 'bg-red-500/10 text-red-500 border-red-500/20' :
                    (p.risk === 'Medium' ? 'bg-amber-500/10 text-amber-500 border-amber-500/20' :
                        'bg-green-500/10 text-green-500 border-green-500/20');

                body.innerHTML += `
                    <tr class="hover:bg-white/5 transition-colors">
                        <td class="px-6 py-4 font-mono text-sm font-semibold theme-text-main">${p.name}</td>
                        <td class="px-6 py-4"><span class="px-2 py-1 rounded border theme-border text-xs">${p.module}</span></td>
                        <td class="px-6 py-4"><span class="px-2 py-0.5 rounded text-xs border ${riskClass}">${p.risk}</span></td>
                        <td class="px-6 py-4 text-right flex justify-end gap-2">
                            <button onclick="openEditModal(${p.id})" class="p-1 hover:text-blue-500 transition-colors"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" stroke-width="2"/></svg></button>
                            <button onclick="deletePermission(${p.id}, '${p.name}')" class="p-1 hover:text-red-500 transition-colors"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" stroke-width="2"/></svg></button>
                        </td>
                    </tr>`;
            });
        };

        // --- Actions ---
        document.getElementById('addPermissionForm').onsubmit = async (e) => {
            e.preventDefault();
            const payload = {
                name: document.getElementById('permission_name').value,
                module: document.getElementById('permission_module').value,
                risk: document.getElementById('permission_risk').value
            };
            try {
                await fetchData('/permissions', 'POST', payload);
                showToaster('Permission Created');
                document.getElementById('addPermissionModal').classList.add('hidden');
                e.target.reset();
                loadPermissionsData();
            } catch (err) {
                showToaster(err.data?.message || 'Error', 'error');
            }
        };

        window.deletePermission = async (id, name) => {
            if (!confirm(`Are you sure you want to delete "${name}"?`)) return;
            try {
                await fetchData(`/permissions/${id}`, 'DELETE');
                showToaster('Deleted successfully');
                loadPermissionsData();
            } catch (err) {
                showToaster('Delete failed', 'error');
            }
        };

        window.openEditModal = (id) => {
            const p = permissions.find(x => x.id == id);
            if (!p) return;
            document.getElementById('edit_permission_id').value = p.id;
            document.getElementById('edit_permission_name').value = p.name;
            document.getElementById('edit_permission_module').value = p.module;
            document.getElementById('edit_permission_risk').value = p.risk;
            document.getElementById('editPermissionModal').classList.remove('hidden');
        };

        window.closeEditPermissionModal = () => document.getElementById('editPermissionModal').classList.add('hidden');

        document.getElementById('editPermissionForm').onsubmit = async (e) => {
            e.preventDefault();
            const id = document.getElementById('edit_permission_id').value;
            const payload = {
                name: document.getElementById('edit_permission_name').value,
                module: document.getElementById('edit_permission_module').value,
                risk: document.getElementById('edit_permission_risk').value
            };
            try {
                await fetchData(`/permissions/${id}`, 'PUT', payload);
                showToaster('Updated');
                closeEditPermissionModal();
                loadPermissionsData();
            } catch (err) {
                showToaster('Update failed', 'error');
            }
        };

        // --- Init ---
        document.addEventListener('DOMContentLoaded', () => {
            // Fill Select Options
            const selects = [document.getElementById('permission_module'), document.getElementById(
                'edit_permission_module')];
            selects.forEach(s => {
                STATIC_MODULES.forEach(m => s.add(new Option(m, m)));
            });
            loadPermissionsData();
        });
    </script>
@endpush


@push('styles')
    <style>
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

        /* Dynamic styles applied via JS for active state */
        .category-filter-btn:hover:not(.active-category-btn) {
            background-color: rgba(255, 255, 255, 0.05);
            color: rgb(var(--text-main));
        }
    </style>
@endpush