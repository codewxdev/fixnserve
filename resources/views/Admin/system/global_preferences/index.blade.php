@extends('layouts.app')

@section('content')
    <div class="w-full px-4 py-8 mx-auto theme-bg-body min-h-screen transition-colors duration-300">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
            <div>
                <h2 class="text-2xl font-bold m-0 theme-text-main">Global Platform Preferences</h2>
                <p class="theme-text-muted mt-1">Manage core behavioral rules and branding.</p>
            </div>
            <div class="flex gap-3">
                <button type="button" onclick="window.location.reload()"
                    class="px-4 py-2 theme-bg-card theme-text-main border rounded-lg hover:opacity-80 transition-all shadow-sm">
                    Reset
                </button>
                <button type="button" id="btnPublish" onclick="confirmPublish()"
                    class="flex items-center px-5 py-2 text-sm font-medium text-white rounded-lg hover:opacity-90 transition-all shadow-md"
                    style="background-color: rgb(var(--brand-primary))">
                    <span id="btnText">Validate & Publish</span>
                </button>
            </div>
        </div>

        <form id="preferencesForm">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <div class="lg:col-span-2 space-y-6">

                    <div class="theme-card theme-bg-card rounded-xl shadow-sm overflow-hidden">
                        <div class="px-6 py-4 border-b theme-border">
                            <h5 class="text-lg font-bold flex items-center theme-text-main">Branding & Identity</h5>
                        </div>
                        <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium mb-2 theme-text-main">Platform Name</label>
                                <input type="text" name="platform_name" id="platform_name"
                                    class="w-full px-4 py-2 bg-transparent border theme-border rounded-lg focus:outline-none focus:ring-2 theme-text-main"
                                    style="--tw-ring-color: rgb(var(--brand-primary))" required>
                            </div>
                            <div>
                                <label class="block text-sm font-medium mb-2 theme-text-main">Company Legal Name</label>
                                <input type="text" name="legal_name" id="legal_name"
                                    class="w-full px-4 py-2 bg-transparent border theme-border rounded-lg focus:outline-none focus:ring-2 theme-text-main"
                                    style="--tw-ring-color: rgb(var(--brand-primary))" required>
                            </div>
                        </div>
                    </div>

                    <div class="theme-card theme-bg-card rounded-xl shadow-sm overflow-hidden">
                        <div class="px-6 py-4 border-b theme-border">
                            <h5 class="text-lg font-bold flex items-center theme-text-main">Regional & Currency</h5>
                        </div>
                        <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium mb-2 theme-text-main">Default Country</label>
                                <select name="country" id="country"
                                    class="w-full px-4 py-2 bg-transparent border theme-border rounded-lg focus:outline-none theme-text-main">
                                    <option value="" class="bg-slate-800">Select Country</option>
                                    <option value="PK" class="bg-slate-800">Pakistan</option>
                                    <option value="US" class="bg-slate-800">United States</option>
                                    <option value="UK" class="bg-slate-800">United Kingdom</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium mb-2 theme-text-main">Default Timezone</label>
                                <select name="timezone" id="timezone"
                                    class="w-full px-4 py-2 bg-transparent border theme-border rounded-lg focus:outline-none theme-text-main">
                                    <option value="" class="bg-slate-800">Select Timezone</option>
                                    <option value="Asia/Karachi" class="bg-slate-800">Asia/Karachi</option>
                                    <option value="UTC" class="bg-slate-800">UTC</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium mb-2 theme-text-main">Global Base Currency</label>
                                <select name="currency" id="currency"
                                    class="w-full px-4 py-2 bg-transparent border theme-border rounded-lg focus:outline-none theme-text-main">
                                    <option value="" class="bg-slate-800">Select Currency</option>
                                    <option value="PKR" class="bg-slate-800">PKR</option>
                                    <option value="USD" class="bg-slate-800">USD</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium mb-2 theme-text-main">Rounding Rules</label>
                                <select name="rounding_rules" id="rounding_rules"
                                    class="w-full px-4 py-2 bg-transparent border theme-border rounded-lg focus:outline-none theme-text-main">
                                    <option value="standard" class="bg-slate-800">Standard (Nearest)</option>
                                    <option value="up" class="bg-slate-800">Always Round Up</option>
                                    <option value="down" class="bg-slate-800">Always Round Down</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="theme-card theme-bg-card rounded-xl shadow-sm overflow-hidden">
                        <div class="px-6 py-4 border-b theme-border">
                            <h5 class="text-lg font-bold flex items-center theme-text-main">Support Contact Details</h5>
                        </div>
                        <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium mb-2 theme-text-main">Support Email</label>
                                <input type="email" name="support_email" id="support_email"
                                    class="w-full px-4 py-2 bg-transparent border theme-border rounded-lg focus:outline-none focus:ring-2 theme-text-main"
                                    style="--tw-ring-color: rgb(var(--brand-primary))" required>
                            </div>
                            <div>
                                <label class="block text-sm font-medium mb-2 theme-text-main">Support Phone</label>
                                <input type="text" name="support_phone" id="support_phone"
                                    class="w-full px-4 py-2 bg-transparent border theme-border rounded-lg focus:outline-none focus:ring-2 theme-text-main"
                                    style="--tw-ring-color: rgb(var(--brand-primary))">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="lg:col-span-1 space-y-6">

                    <div class="theme-card theme-bg-card rounded-xl shadow-sm overflow-hidden border-t-4"
                        style="border-top-color: rgb(var(--brand-secondary))">
                        <div class="px-6 py-4 border-b theme-border">
                            <h5 class="text-lg font-bold flex items-center theme-text-main">⚙️ Master Switches</h5>
                        </div>
                        <div class="p-6 space-y-4">
                            <label class="flex items-start cursor-pointer group">
                                <input type="checkbox" id="flag_onboarding" class="sr-only peer">
                                <div
                                    class="relative w-11 h-6 bg-gray-600 rounded-full peer peer-checked:after:translate-x-full after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-[rgb(var(--brand-primary))]">
                                </div>
                                <div class="ml-3 text-sm">
                                    <span class="font-bold block theme-text-main">Allow New User Onboarding</span>
                                    <span class="theme-text-muted">Disable to stop all new signups.</span>
                                </div>
                            </label>

                            <label class="flex items-start cursor-pointer group mt-4">
                                <input type="checkbox" id="flag_major_flows" class="sr-only peer">
                                <div
                                    class="relative w-11 h-6 bg-gray-600 rounded-full peer peer-checked:after:translate-x-full after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-[rgb(var(--brand-primary))]">
                                </div>
                                <div class="ml-3 text-sm">
                                    <span class="font-bold block theme-text-main">Enable Major Flows</span>
                                    <span class="theme-text-muted">Toggle core platform transactions.</span>
                                </div>
                            </label>
                        </div>
                    </div>

                    <div class="theme-card theme-bg-card rounded-xl shadow-sm overflow-hidden border-t-4"
                        style="border-top-color: rgb(var(--brand-primary))">
                        <div class="px-6 py-4 border-b theme-border">
                            <h5 class="text-lg font-bold theme-text-main">Publishing Configuration</h5>
                        </div>
                        <div class="p-6 space-y-4">
                            <div>
                                <label class="block text-sm font-bold theme-text-main mb-2">Rollout Mode</label>
                                <select id="rollout_mode"
                                    class="w-full px-4 py-2 bg-transparent border theme-border rounded-lg focus:outline-none theme-text-main">
                                    <option value="immediate" class="bg-slate-800">Immediate Rollout</option>
                                    <option value="scheduled" class="bg-slate-800">Scheduled Rollout</option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-sm font-bold theme-text-main mb-2">Reason for Change (Audit) <span
                                        class="text-red-500">*</span></label>
                                <textarea id="change_reason"
                                    class="w-full px-4 py-2 bg-transparent border theme-border rounded-lg focus:outline-none theme-text-main"
                                    rows="3" required></textarea>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </form>
    </div>

    <div id="validationModal" class="fixed inset-0 z-50 hidden" aria-labelledby="modal-title" role="dialog"
        aria-modal="true">
        <div class="fixed inset-0 bg-black/60 backdrop-blur-sm transition-opacity"></div>
        <div class="fixed inset-0 z-10 overflow-y-auto">
            <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">
                <div
                    class="relative transform overflow-hidden rounded-xl theme-bg-card text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-lg border theme-border">
                    <div class="px-6 py-4 border-b theme-border flex justify-between items-center bg-black/5">
                        <h3 class="text-lg font-bold theme-text-main flex items-center" id="modal-title">
                            <span class="mr-2 text-blue-500">🛡️</span> Config Impact Analysis
                        </h3>
                        <button type="button" onclick="closeModal()"
                            class="theme-text-muted hover:theme-text-main transition-colors text-xl">
                            &times;
                        </button>
                    </div>

                    <div class="p-6">
                        <div class="p-4 rounded-lg mb-6 flex items-start"
                            style="background-color: rgba(var(--brand-primary), 0.1); border-left: 4px solid rgb(var(--brand-primary))">
                            <div class="flex-shrink-0 mt-0.5">
                                <svg class="h-5 w-5" style="color: rgb(var(--brand-primary))" fill="currentColor"
                                    viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h4 class="text-sm font-bold theme-text-main">System-wide Change Validation</h4>
                                <p class="text-xs theme-text-muted mt-1 leading-relaxed">
                                    Ye changes publish karne se platform ki core configurations globally update ho jayengi.
                                    Caching refresh hogi aur users ko nayi branding/rules nazar aayenge.
                                </p>
                            </div>
                        </div>

                        <div class="space-y-3">
                            <p class="text-sm theme-text-main font-medium">Confirming this action will:</p>
                            <ul class="text-xs theme-text-muted space-y-2 list-disc pl-5">
                                <li>Update preferences via <span class="font-bold">Immediate/Scheduled</span> Rollout Mode.
                                </li>
                                <li>Sync platform-wide toggles internally.</li>
                                <li>Record an entry in the Platform Audit Log.</li>
                            </ul>
                        </div>
                    </div>

                    <div class="px-6 py-4 border-t theme-border flex justify-end gap-3 bg-black/5">
                        <button type="button" onclick="closeModal()"
                            class="px-4 py-2 text-sm font-medium theme-text-main hover:bg-black/10 rounded-lg transition-all">
                            Cancel
                        </button>
                        <button type="button" id="confirmBtn" onclick="submitChanges()"
                            class="flex items-center justify-center px-6 py-2 text-sm font-bold text-white rounded-lg shadow-lg hover:opacity-90 transition-all min-w-[140px]"
                            style="background-color: rgb(var(--brand-primary))">
                            Confirm & Apply
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    const apiBase = '/api/admin/feature-flags';
    let globalFlags = [];

    // --- API Headers & CSRF ---
    function getApiHeaders(includeContentType = false) {
        const token = localStorage.getItem('token');
        const fingerprint = localStorage.getItem('device_fingerprint');
        const headers = {
            'Accept': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '',
            'X-Device-Fingerprint': fingerprint || 'unknown',
            'Authorization': token ? `Bearer ${token}` : ''
        };
        if (includeContentType) headers['Content-Type'] = 'application/json';
        return headers;
    }

    // --- Toast Notification Logic ---
    function showToast(message, isError = false) {
        const toast = document.getElementById('toastMessage');
        const text = document.getElementById('toastText');
        text.innerText = message;
        
        toast.className = `fixed top-5 right-5 px-6 py-3 rounded shadow-lg transform transition-transform z-[100] flex items-center ${isError ? 'bg-red-500 text-white' : 'bg-green-500 text-white'}`;
        toast.style.transform = "translateX(0)"; 

        setTimeout(() => {
            toast.style.transform = "translateX(150%)"; 
        }, 3000);
    }

    document.addEventListener('DOMContentLoaded', fetchFlags);

    // --- Fetch Data (Bulletproof) ---
    async function fetchFlags() {
        try {
            const res = await fetch(apiBase, { headers: getApiHeaders() });
            const result = await res.json();
            
            // Accurately extract the array regardless of how Laravel wraps it
            let extractedData = result?.data?.flags || result?.flags || result?.data || [];
            if (extractedData.data && Array.isArray(extractedData.data)) {
                extractedData = extractedData.data; // Catch Laravel pagination wrapper
            }

            globalFlags = Array.isArray(extractedData) ? extractedData : [];
            
            renderTable();
            updateStats();
        } catch (error) {
            console.error('Error fetching flags:', error);
            document.getElementById('flagsTableBody').innerHTML = '<tr><td colspan="5" class="text-center py-4 text-red-500 font-bold">Failed to load data. Check console.</td></tr>';
        }
    }

    // --- Render Table & Action Buttons ---
    function renderTable() {
        const tbody = document.getElementById('flagsTableBody');
        tbody.innerHTML = '';

        if (globalFlags.length === 0) {
            tbody.innerHTML = '<tr><td colspan="5" class="text-center py-8 theme-text-muted">No feature flags found. Create your first flag!</td></tr>';
            return;
        }

        let rowsHTML = '';
        globalFlags.forEach(flag => {
            // Safely parse JSON value from DB
            let val = {};
            if (typeof flag.value === 'string') {
                try { val = JSON.parse(flag.value); } catch(e) { console.error("Parse Error:", e); }
            } else if (typeof flag.value === 'object' && flag.value !== null) {
                val = flag.value;
            }

            let key = flag.key || 'N/A';
            let name = val.name || key;
            let type = flag.type || 'boolean';
            let isEnabled = val.enabled == true; 
            let dependencies = val.dependencies || '';

            let typeBadgeColor = type === 'boolean' ? 'bg-blue-500/10 text-blue-500 border-blue-500/20' : 
                                 type === 'percentage' ? 'bg-purple-500/10 text-purple-500 border-purple-500/20' : 'bg-emerald-500/10 text-emerald-500 border-emerald-500/20';
            
            let rolloutDisplay = '<span class="theme-text-main font-semibold">100% Global</span>';
            if (type === 'percentage') {
                let perc = val.rollout || 0;
                rolloutDisplay = `
                    <div class="flex items-center gap-2">
                        <span class="theme-text-main font-bold w-10">${perc}%</span>
                        <div class="w-full bg-gray-200/20 rounded-full h-1.5 border theme-border">
                            <div class="bg-blue-500 h-1.5 rounded-full" style="width: ${perc}%"></div>
                        </div>
                    </div>`;
            } else if(type === 'user_segment') {
                rolloutDisplay = `<span class="theme-text-main font-semibold">${val.scope || 'All Segments'}</span>`;
            }

            // ADDED EDIT BUTTON HERE
            rowsHTML += `
                <tr class="hover:bg-white/5 transition-colors">
                    <td class="px-5 py-4 border-b theme-border text-sm">
                        <p class="theme-text-main font-bold">${name}</p>
                        <p class="theme-text-muted text-xs mt-1 font-mono">Key: ${key} ${dependencies ? '<br>Dep: ' + dependencies : ''}</p>
                    </td>
                    <td class="px-5 py-4 border-b theme-border text-sm">
                        <span class="${typeBadgeColor} border text-[10px] font-bold px-2 py-0.5 rounded uppercase tracking-wider">${type}</span>
                    </td>
                    <td class="px-5 py-4 border-b theme-border text-sm w-1/4">
                        ${rolloutDisplay}
                    </td>
                    <td class="px-5 py-4 border-b theme-border text-sm">
                        <label class="switch">
                            <input type="checkbox" onchange="toggleStatus(${flag.id}, this.checked)" ${isEnabled ? 'checked' : ''}>
                            <span class="slider"></span>
                        </label>
                    </td>
                    <td class="px-5 py-4 border-b theme-border text-sm text-center">
                        <button onclick="editFlag(${flag.id})" class="text-blue-500 hover:text-blue-400 mx-1 p-2 rounded hover:bg-white/5 transition-colors" title="Edit Flag">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button onclick="deleteFlag(${flag.id})" class="text-red-500 hover:text-red-400 mx-1 p-2 rounded hover:bg-white/5 transition-colors" title="Delete Flag">
                            <i class="fas fa-trash"></i>
                        </button>
                    </td>
                </tr>
            `;
        });
        
        tbody.innerHTML = rowsHTML;
    }

    // --- Update Stats ---
    function updateStats() {
        let activeCount = 0;
        let rolloutCount = 0;

        globalFlags.forEach(flag => {
            let val = (typeof flag.value === 'string') ? JSON.parse(flag.value || '{}') : (flag.value || {});
            if (val.enabled) activeCount++;
            if (flag.type === 'percentage') rolloutCount++;
        });

        document.getElementById('stat-total').innerText = globalFlags.length;
        document.getElementById('stat-active').innerText = activeCount;
        document.getElementById('stat-rollout').innerText = rolloutCount;
        document.getElementById('stat-killed').innerText = globalFlags.length - activeCount;
    }

    // --- Modal Configuration ---
    function openModal() {
        document.getElementById('flagForm').reset();
        document.getElementById('flagId').value = '';
        
        const keyInput = document.getElementById('flagKey');
        keyInput.readOnly = false;
        keyInput.classList.remove('opacity-50', 'cursor-not-allowed');
        
        document.getElementById('modalTitle').innerText = 'Create Feature Flag';
        toggleDynamicFields();
        document.getElementById('flagModal').classList.remove('hidden');
    }

    function closeModal() { 
        document.getElementById('flagModal').classList.add('hidden'); 
    }

    // --- Edit Flag Logic ---
    function editFlag(id) {
        const flag = globalFlags.find(f => f.id == id);
        if (!flag) return;

        let val = (typeof flag.value === 'string') ? JSON.parse(flag.value || '{}') : (flag.value || {});

        document.getElementById('flagId').value = flag.id;
        document.getElementById('flagName').value = val.name || flag.key;
        
        // Lock the key so it cannot be changed on edit
        const keyInput = document.getElementById('flagKey');
        keyInput.value = flag.key;
        keyInput.readOnly = true;
        keyInput.classList.add('opacity-50', 'cursor-not-allowed');

        document.getElementById('flagType').value = flag.type;
        document.getElementById('flagDependencies').value = val.dependencies || '';

        if (flag.type === 'percentage') {
            document.getElementById('flagPercentage').value = val.rollout || 50;
            document.getElementById('percValue').innerText = val.rollout || 50;
        } else if (flag.type === 'user_segment') {
            document.getElementById('flagScope').value = val.scope || '';
        }

        document.getElementById('modalTitle').innerText = 'Edit Feature Flag';
        toggleDynamicFields();
        document.getElementById('flagModal').classList.remove('hidden');
    }

    function generateKey() {
        if(document.getElementById('flagId').value === '') {
            let name = document.getElementById('flagName').value;
            document.getElementById('flagKey').value = name.toLowerCase().replace(/[^a-z0-9]+/g, '_').replace(/(^_|_$)/g, '');
        }
    }

    function toggleDynamicFields() {
        const type = document.getElementById('flagType').value;
        document.getElementById('fieldPercentage').classList.add('hidden');
        document.getElementById('fieldScope').classList.add('hidden');

        if (type === 'percentage') document.getElementById('fieldPercentage').classList.remove('hidden');
        else if (type === 'user_segment') document.getElementById('fieldScope').classList.remove('hidden');
    }

    // --- Create/Update Logic ---
    async function saveFlag(e) {
        e.preventDefault();
        const id = document.getElementById('flagId').value;
        const type = document.getElementById('flagType').value;
        
        let valueData = {
            name: document.getElementById('flagName').value.trim(),
            enabled: true, 
            dependencies: document.getElementById('flagDependencies').value.trim()
        };

        if(type === 'percentage') valueData.rollout = parseInt(document.getElementById('flagPercentage').value);
        if(type === 'user_segment') valueData.scope = document.getElementById('flagScope').value.trim();

        const payload = {
            type: type,
            value: valueData
        };

        // Key is only required for creation
        if (!id) {
            payload.key = document.getElementById('flagKey').value.trim();
        }

        const method = id ? 'PUT' : 'POST';
        const url = id ? `${apiBase}/${id}` : apiBase;

        try {
            const res = await fetch(url, {
                method: method,
                headers: getApiHeaders(true),
                body: JSON.stringify(payload)
            });
            
            const result = await res.json();

            if(res.ok) {
                showToast(id ? 'Flag Updated Successfully!' : 'New Flag Created Successfully!');
                closeModal();
                fetchFlags();
            } else {
                const errorMsg = result.errors ? Object.values(result.errors).flat().join('\n') : (result.message || 'Could not save flag');
                showToast(`Validation Error: ${errorMsg}`, true);
            }
        } catch (error) {
            showToast('Network error occurred.', true);
        }
    }

    // --- Toggle Switch Logic (Kill-Switch) ---
    async function toggleStatus(id, isActive) {
        if (!id) return;
        const flag = globalFlags.find(f => f.id == id);
        if (!flag) return;
        
        let currentVal = (typeof flag.value === 'string') ? JSON.parse(flag.value || '{}') : (flag.value || {});
        currentVal.enabled = isActive;

        try {
            const res = await fetch(`${apiBase}/${id}`, {
                method: 'PUT',
                headers: getApiHeaders(true),
                body: JSON.stringify({ type: flag.type, value: currentVal })
            });

            if(res.ok) {
                showToast(isActive ? 'Feature Enabled!' : 'Feature Disabled (Kill-Switched)!');
                fetchFlags(); 
            } else {
                showToast('Failed to change status', true);
            }
        } catch (error) {
            showToast('Network Error', true);
        }
    }

    // --- Delete Logic ---
    async function deleteFlag(id) {
        if(!id) return;
        const flag = globalFlags.find(f => f.id == id);
        
        if(confirm(`DANGER: Are you sure you want to permanently delete the flag "${flag.key}"?`)) {
            try {
                const res = await fetch(`${apiBase}/${id}`, {
                    method: 'DELETE',
                    headers: getApiHeaders()
                });
                
                if(res.ok) {
                    showToast('Flag deleted successfully.');
                    fetchFlags();
                } else {
                    const err = await res.json();
                    showToast(err.message || 'Failed to delete flag.', true);
                }
            } catch (error) {
                showToast('Network Error', true);
            }
        }
    }
</script>
@endpush
