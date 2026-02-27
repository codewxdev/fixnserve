@extends('layouts.app')

@section('content')
    <div id="app" class="min-h-screen theme-bg-body theme-text-main space-y-8 p-6 lg:p-10 font-sans">

        {{-- A. Header Section --}}
        <header class="flex flex-col md:flex-row md:items-end md:justify-between space-y-4 md:space-y-0">
            <div>
                <h1 class="text-3xl md:text-4xl font-extrabold theme-text-main tracking-tight">Access Matrix</h1>
                <p class="text-base theme-text-muted mt-2 max-w-2xl">
                    Map organizational roles to atomic platform capabilities and manage module-level locks.
                </p>
            </div>

            <div class="flex items-center gap-3">
                <button onclick="window.loadMatrixData()"
                    class="inline-flex items-center px-4 py-2 theme-bg-card border theme-border theme-text-main font-semibold rounded-xl shadow-sm hover:bg-white/5 transition-all">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15">
                        </path>
                    </svg>
                    Refresh Matrix
                </button>
            </div>
        </header>

        {{-- B. Matrix Interface --}}
        <section class="space-y-4">
            {{-- Toolbar --}}
            <div
                class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 theme-bg-card p-4 rounded-2xl border theme-border shadow-sm">
                <div class="flex items-center gap-6">
                    <div>
                        <h2 class="text-lg font-bold theme-text-main">Role vs Permission Mapping</h2>
                        <span class="text-xs theme-text-muted" id="matrix-stats">Initializing...</span>
                    </div>
                    {{-- Legend --}}
                    <div class="hidden lg:flex items-center gap-4 border-l theme-border pl-6">
                        <div class="flex items-center gap-2"><span class="w-3 h-3 rounded-full bg-blue-500"></span><span
                                class="text-xs">Read/Write</span></div>
                        <div class="flex items-center gap-2"><span class="w-3 h-3 rounded-full bg-red-500"></span><span
                                class="text-xs">System Lock</span></div>
                    </div>
                </div>

                <div class="relative">
                    <input type="text" id="matrix-search" placeholder="Search permissions or modules..."
                        class="pl-10 pr-4 py-2 theme-bg-body border theme-border rounded-xl text-sm theme-text-main focus:ring-2 w-72 outline-none"
                        onkeyup="window.renderMatrixView()">
                    <svg class="w-4 h-4 theme-text-muted absolute left-3 top-3" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
            </div>

            {{-- The Grid --}}
            <div class="theme-bg-card rounded-2xl shadow-sm border theme-border overflow-hidden relative min-h-[500px]">
                {{-- Loader --}}
                <div id="matrix-loading"
                    class="absolute inset-0 bg-black/50 backdrop-blur-sm z-30 flex flex-col items-center justify-center">
                    <div class="animate-spin rounded-full h-10 w-10 border-b-2 mb-4 border-blue-500"></div>
                    <span class="font-semibold text-blue-400 animate-pulse">Syncing Policies...</span>
                </div>

                <div class="overflow-x-auto overflow-y-auto max-h-[75vh] custom-scrollbar relative">
                    <table class="w-full text-sm text-left border-collapse">
                        <thead id="matrix-header"
                            class="theme-text-main sticky top-0 z-20 shadow-sm backdrop-blur-md bg-opacity-95 bg-inherit">
                            {{-- JS Injected --}}
                        </thead>
                        <tbody id="matrix-body" class="divide-y theme-border">
                            {{-- JS Injected --}}
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
    </div>

    {{-- Safety Confirmation Modal --}}
    <div id="confirm-modal"
        class="fixed inset-0 z-[100] hidden flex items-center justify-center p-4 bg-black/60 backdrop-blur-sm">
        <div class="theme-bg-card border theme-border w-full max-w-md rounded-2xl p-6 shadow-2xl scale-95 transition-transform duration-200"
            id="modal-content">
            <div class="flex items-center gap-4 mb-4 text-red-500">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
                <h3 class="text-xl font-bold">Confirm Access Change</h3>
            </div>
            <p class="theme-text-muted text-sm mb-6" id="modal-text">Are you sure you want to modify these permissions? This
                will impact active user sessions.</p>
            <div class="flex justify-end gap-3">
                <button onclick="closeModal()" class="px-4 py-2 theme-text-muted font-semibold">Cancel</button>
                <button id="modal-confirm-btn"
                    class="px-6 py-2 bg-red-600 text-white rounded-xl font-bold shadow-lg shadow-red-900/20 hover:bg-red-700 transition-all">Confirm
                    Update</button>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        /* Premium Scrollbar */
        .custom-scrollbar::-webkit-scrollbar {
            height: 8px;
            width: 8px;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb {
            background-color: rgb(var(--border-color));
            border-radius: 20px;
        }

        /* Toggle Switches */
        .toggle-track {
            width: 2.5rem;
            height: 1.25rem;
            background-color: rgba(var(--border-color), 0.8);
            border-radius: 9999px;
            transition: all 0.2s;
            cursor: pointer;
        }

        .toggle-dot {
            width: 0.9rem;
            height: 0.9rem;
            background-color: white;
            border-radius: 50%;
            position: absolute;
            top: 0.17rem;
            left: 0.2rem;
            transition: transform 0.2s;
        }

        input:checked+.toggle-track {
            background-color: #3b82f6 !important;
        }

        input:checked~.toggle-dot {
            transform: translateX(1.2rem);
        }

        input:disabled+.toggle-track {
            opacity: 0.4;
            cursor: not-allowed;
        }

        .permission-cell {
            min-width: 300px;
            position: sticky;
            left: 0;
            z-index: 10;
            background-color: rgb(var(--bg-card));
            border-right: 1px solid rgb(var(--border-color));
        }

        .module-header {
            background-color: rgba(59, 130, 246, 0.08);
        }
    </style>
@endpush

@push('scripts')
    <script>
        let roles = [];
        let permissions = [];
        let modules = {};
        let pendingAction = null;

        const API = {
            fetch: async (url, method = 'GET', body = null) => {
                try {
                    const res = await fetch(`http://127.0.0.1:8000/api${url}`, {
                        method,
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json', // Yeh server ko batata hai ke humein sirf JSON chahiye
                            'Authorization': `Bearer ${localStorage.getItem('token')}`
                        },
                        body: body ? JSON.stringify(body) : null
                    });

                    // Check karein agar response JSON hai
                    const contentType = res.headers.get("content-type");
                    if (contentType && contentType.indexOf("application/json") !== -1) {
                        const data = await res.json();
                        if (!res.ok) throw new Error(data.message || `Error ${res.status}`);
                        return data;
                    } else {
                        // Agar server ne HTML bhej di (Error page)
                        const text = await res.text();
                        console.error("Server returned non-JSON response:", text);
                        throw new Error(`Server Error: Received HTML instead of JSON (Status: ${res.status})`);
                    }
                } catch (error) {
                    console.error("Fetch Error:", error);
                    throw error;
                }
            }
        };

        // --- Data Management ---

        window.loadMatrixData = async function() {
            try {
                document.getElementById('matrix-loading').classList.remove('hidden');

                const [roleRes, permRes] = await Promise.all([
                    API.fetch('/roles'),
                    API.fetch('/permissions')
                ]);

                // --- DEBUGGING: Console mein check karein ke data kis shakal mein aa raha hai ---
                console.log("Roles Response:", roleRes);
                console.log("Permissions Response:", permRes);

                // Roles ko safely nikaalein
                const rawRoles = roleRes.data || roleRes;
                roles = Array.isArray(rawRoles) ? rawRoles : (rawRoles.data ? rawRoles.data : []);

                // Permissions ko safely nikaalein (Yehi masla kar raha tha)
                const rawPerms = permRes.data || permRes;
                // Agar Laravel pagination use ho rahi hai to data.data mein array hota hai
                permissions = Array.isArray(rawPerms) ? rawPerms : (rawPerms.data ? rawPerms.data : []);

                if (!Array.isArray(permissions)) {
                    throw new Error("Permissions data is not an array. Check API structure.");
                }

                // Roles sorting (Super Admin ko hamesha pehle rakhein)
                roles.sort((a, b) => {
                    if (a.name.toLowerCase().includes('super')) return -1;
                    return a.name.localeCompare(b.name);
                });

                // Group by category (Module)
                modules = permissions.reduce((acc, p) => {
                    const cat = p.category || 'General Operations';
                    if (!acc[cat]) acc[cat] = [];
                    acc[cat].push(p);
                    return acc;
                }, {});

                document.getElementById('matrix-stats').textContent =
                    `${roles.length} Roles | ${permissions.length} Permissions`;
                renderMatrixView();

            } catch (e) {
                console.error("Matrix Load Error:", e);
                showToaster(e.message || 'Failed to initialize matrix', 'error');
            } finally {
                document.getElementById('matrix-loading').classList.add('hidden');
            }
        };

        window.renderMatrixView = function() {
            const header = document.getElementById('matrix-header');
            const body = document.getElementById('matrix-body');
            const query = document.getElementById('matrix-search').value.toLowerCase();

            // 1. Render Header
            let hHtml =
                `<tr><th class="permission-cell px-6 py-5 text-xs font-black uppercase theme-bg-card">Module & Capabilities</th>`;
            roles.forEach(r => {
                hHtml += `<th class="px-4 py-5 text-center min-w-[120px] border-l theme-border">
                <span class="text-sm font-bold block">${r.name}</span>
                ${r.name.toLowerCase().includes('super') ? '<span class="text-[9px] text-red-500 font-bold uppercase">Locked</span>' : ''}
            </th>`;
            });
            header.innerHTML = hHtml + '</tr>';

            // 2. Render Body
            body.innerHTML = '';
            Object.keys(modules).sort().forEach(modName => {
                const perms = modules[modName].filter(p => p.name.toLowerCase().includes(query) || modName
                    .toLowerCase().includes(query));
                if (perms.length === 0) return;

                // Module Row (Bulk Control)
                let mHtml = `<tr class="module-header border-y theme-border">
                <td class="permission-cell px-6 py-3 font-bold text-blue-500 uppercase tracking-tighter text-xs flex items-center justify-between">
                    <span>📁 ${modName}</span>
                </td>`;

                roles.forEach(r => {
                    const isSuper = r.name.toLowerCase().includes('super');
                    mHtml += `<td class="text-center px-4 py-3 border-l theme-border">
                    <button onclick="window.confirmModuleToggle('${r.name}', '${modName}')" 
                        ${isSuper ? 'disabled' : ''}
                        class="text-[10px] font-bold px-2 py-1 rounded border border-blue-500/30 text-blue-500 hover:bg-blue-500 hover:text-white transition-all">
                        BULK
                    </button>
                </td>`;
                });
                body.innerHTML += mHtml + '</tr>';

                // Permission Rows
                perms.forEach(p => {
                    let row = `<tr><td class="permission-cell px-8 py-3 theme-text-main border-b theme-border">
                    <div class="flex items-center gap-2">
                        <span class="w-1.5 h-1.5 rounded-full bg-blue-500/50"></span>
                        <span class="font-medium">${p.name}</span>
                    </div>
                </td>`;

                    roles.forEach(r => {
                        const hasPerm = (r.permissions || []).some(rp => rp.name === p.name);
                        const isSuper = r.name.toLowerCase().includes('super');

                        row += `<td class="px-4 py-3 text-center border-l theme-border align-middle">
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" class="sr-only peer" 
                                ${hasPerm ? 'checked' : ''} 
                                ${isSuper ? 'disabled' : ''}
                                onchange="window.confirmPermissionToggle(this, '${r.name}', '${p.name}')">
                            <div class="toggle-track"></div>
                            <div class="toggle-dot"></div>
                        </label>
                    </td>`;
                    });
                    body.innerHTML += row + '</tr>';
                });
            });
        };

        // --- Actions ---

        // 1. Individual Permission Toggle
        window.confirmPermissionToggle = function(checkbox, roleName, permName) {
            const isChecked = checkbox.checked;
            // Immediate UI feedback for better UX
            pendingAction = async () => {
                try {
                    const role = roles.find(r => r.name === roleName);
                    let currentPerms = role.permissions.map(p => p.name);

                    if (isChecked) currentPerms.push(permName);
                    else currentPerms = currentPerms.filter(n => n !== permName);

                    await API.fetch('/role-permission', 'POST', {
                        role: roleName,
                        permissions: currentPerms
                    });

                    showToaster(`Updated ${permName} for ${roleName}`);
                    loadMatrixData(); // Refresh to ensure sync
                } catch (e) {
                    checkbox.checked = !isChecked; // Revert
                    showToaster(e.message || 'Update failed', 'error');
                }
            };

            // Open Modal for safety if removing access
            if (!isChecked) {
                openModal(`Warning: Removing <b>${permName}</b> might restrict ${roleName} from essential features.`);
            } else {
                pendingAction(); // Direct update for adding access
            }
        };

        // 2. Module Level Toggle (Bulk)
        window.confirmModuleToggle = function(roleName, moduleName) {
            openModal(
                `Action: Modify entire <b>${moduleName}</b> module for <b>${roleName}</b>? This will synchronize all related sub-permissions.`
            );
            pendingAction = async () => {
                try {
                    await API.fetch('/role-permission/module', 'POST', {
                        role: roleName,
                        module: moduleName.toLowerCase()
                    });
                    showToaster(`Module ${moduleName} updated for ${roleName}`);
                    loadMatrixData();
                } catch (e) {
                    showToaster(e.message || 'Module update failed', 'error');
                }
            };
        };

        // --- UI Helpers ---

        function openModal(text) {
            document.getElementById('modal-text').innerHTML = text;
            document.getElementById('confirm-modal').classList.remove('hidden');
        }

        window.closeModal = function() {
            document.getElementById('confirm-modal').classList.add('hidden');
            pendingAction = null;
        };

        document.getElementById('modal-confirm-btn').onclick = () => {
            if (pendingAction) pendingAction();
            closeModal();
        };

        function showToaster(msg, type = 'success') {
            const toast = document.createElement('div');
            toast.className =
                `fixed bottom-10 right-10 px-6 py-4 rounded-2xl shadow-2xl z-[200] border transition-all duration-300 transform translate-y-20 ${type === 'success' ? 'bg-zinc-900 border-green-500/50 text-white' : 'bg-red-900 border-red-500 text-white'}`;
            toast.innerHTML =
                `<div class="flex items-center gap-3"><span>${type === 'success' ? '✅' : '❌'}</span> ${msg}</div>`;
            document.body.appendChild(toast);
            setTimeout(() => toast.classList.remove('translate-y-20'), 10);
            setTimeout(() => {
                toast.classList.add('opacity-0');
                setTimeout(() => toast.remove(), 500);
            }, 3000);
        }

        document.addEventListener('DOMContentLoaded', loadMatrixData);
    </script>
@endpush
