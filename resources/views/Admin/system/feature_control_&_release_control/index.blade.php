@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8 theme-text-main relative">
    
    <div id="toastMessage" class="fixed top-5 right-5 bg-green-500 text-white px-6 py-3 rounded shadow-lg transform transition-transform translate-x-full z-50 flex items-center">
        <i class="fas fa-check-circle mr-2"></i>
        <span id="toastText">Action successful!</span>
    </div>

    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-3xl font-bold theme-text-main">Feature Flags & Release Control</h1>
            <p class="theme-text-muted text-sm mt-1">Manage rollouts, kill-switches, and feature availability without redeploying.</p>
        </div>
        <button onclick="openModal()" class="bg-[rgb(var(--brand-primary))] hover:bg-[rgb(var(--brand-secondary))] text-white font-bold py-2 px-4 rounded shadow transition-colors">
            + Create New Flag
        </button>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
        <div class="theme-bg-card p-4 rounded-lg shadow pro-card border-l-4 border-blue-500">
            <h3 class="theme-text-muted text-sm">Total Flags</h3>
            <p id="stat-total" class="text-2xl font-bold theme-text-main">0</p>
        </div>
        <div class="theme-bg-card p-4 rounded-lg shadow pro-card border-l-4 border-green-500">
            <h3 class="theme-text-muted text-sm">Active Flags</h3>
            <p id="stat-active" class="text-2xl font-bold theme-text-main">0</p>
        </div>
        <div class="theme-bg-card p-4 rounded-lg shadow pro-card border-l-4 border-yellow-500">
            <h3 class="theme-text-muted text-sm">Gradual Rollouts</h3>
            <p id="stat-rollout" class="text-2xl font-bold theme-text-main">0</p>
        </div>
        <div class="theme-bg-card p-4 rounded-lg shadow pro-card border-l-4 border-red-500">
            <h3 class="theme-text-muted text-sm">Disabled (Kill-Switched)</h3>
            <p id="stat-killed" class="text-2xl font-bold theme-text-main">0</p>
        </div>
    </div>

    <div class="theme-bg-card rounded-lg shadow overflow-hidden">
        <table class="min-w-full leading-normal">
            <thead>
                <tr class="bg-[rgb(var(--item-active-bg))] text-left theme-text-muted text-sm uppercase tracking-wider">
                    <th class="px-5 py-3 border-b-2 theme-border">Feature Name</th>
                    <th class="px-5 py-3 border-b-2 theme-border">Type & Scope</th>
                    <th class="px-5 py-3 border-b-2 theme-border">Rollout / Value</th>
                    <th class="px-5 py-3 border-b-2 theme-border">Status (Kill-Switch)</th>
                    <th class="px-5 py-3 border-b-2 theme-border text-center">Actions</th>
                </tr>
            </thead>
            <tbody id="flagsTableBody">
                <tr><td colspan="5" class="text-center py-4 theme-text-muted">Loading data...</td></tr>
            </tbody>
        </table>
    </div>
</div>

<div id="flagModal" class="fixed inset-0 bg-black bg-opacity-60 overflow-y-auto h-full w-full hidden z-50">
    <div class="relative top-20 mx-auto p-5 border theme-border w-full max-w-lg shadow-lg rounded-md theme-bg-card">
        <div class="flex justify-between items-center mb-4">
            <h3 id="modalTitle" class="text-lg font-bold theme-text-main">Configure Feature Flag</h3>
            <button onclick="closeModal()" class="theme-text-muted hover:theme-text-main text-2xl">&times;</button>
        </div>
        
        <form id="flagForm" onsubmit="saveFlag(event)">
            <input type="hidden" id="flagId" value="">
            
            <div class="mb-4">
                <label class="block theme-text-main text-sm font-bold mb-2">Feature Name</label>
                <input type="text" id="flagName" required onkeyup="generateKey()" class="shadow appearance-none border theme-border bg-[rgb(var(--bg-body))] rounded w-full py-2 px-3 theme-text-main focus:outline-none focus:ring-1 focus:ring-[rgb(var(--brand-primary))]" placeholder="e.g. Beta Search UI">
            </div>

            <div class="mb-4">
                <label class="block theme-text-main text-sm font-bold mb-2">System Key (Unique)</label>
                <input type="text" id="flagKey" required class="shadow appearance-none border theme-border bg-[rgb(var(--bg-body))] rounded w-full py-2 px-3 theme-text-main focus:outline-none" placeholder="beta_search_ui">
            </div>

            <div class="mb-4">
                <label class="block theme-text-main text-sm font-bold mb-2">Flag Type</label>
                <select id="flagType" onchange="toggleDynamicFields()" class="shadow border theme-border bg-[rgb(var(--bg-body))] rounded w-full py-2 px-3 theme-text-main focus:outline-none focus:ring-1 focus:ring-[rgb(var(--brand-primary))]">
                    <option value="boolean">Boolean (On/Off)</option>
                    <option value="percentage">Percentage Rollout (Canary/Gradual)</option>
                    <option value="user_segment">User-Segment-Based</option>
                </select>
            </div>

            <div id="fieldPercentage" class="mb-4 hidden">
                <label class="block theme-text-main text-sm font-bold mb-2">Rollout Percentage: <span id="percValue">50</span>%</label>
                <input type="range" id="flagPercentage" min="0" max="100" value="50" oninput="document.getElementById('percValue').innerText = this.value" class="w-full accent-[rgb(var(--brand-primary))]">
            </div>

            <div id="fieldScope" class="mb-4 hidden">
                <label class="block theme-text-main text-sm font-bold mb-2">Target Scope (Users/Segments)</label>
                <input type="text" id="flagScope" class="shadow appearance-none border theme-border bg-[rgb(var(--bg-body))] rounded w-full py-2 px-3 theme-text-main focus:outline-none focus:ring-1 focus:ring-[rgb(var(--brand-primary))]" placeholder="e.g. Premium Users, Beta Testers">
            </div>

            <div class="mb-4">
                <label class="block theme-text-main text-sm font-bold mb-2">Dependencies (Optional)</label>
                <input type="text" id="flagDependencies" class="shadow appearance-none border theme-border bg-[rgb(var(--bg-body))] rounded w-full py-2 px-3 theme-text-main focus:outline-none focus:ring-1 focus:ring-[rgb(var(--brand-primary))]" placeholder="Enter parent flag key...">
            </div>

            <div class="flex justify-end pt-2">
                <button type="button" onclick="closeModal()" class="px-4 bg-[rgb(var(--item-active-bg))] p-3 rounded-lg theme-text-main hover:opacity-80 mr-2 transition-opacity">Cancel</button>
                <button type="submit" class="px-4 bg-[rgb(var(--brand-primary))] p-3 rounded-lg text-white hover:bg-[rgb(var(--brand-secondary))] transition-colors">Save Config</button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('styles')
<script src="https://cdn.tailwindcss.com"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
<style>
    .switch { position: relative; display: inline-block; width: 44px; height: 24px; }
    .switch input { opacity: 0; width: 0; height: 0; }
    .slider { position: absolute; cursor: pointer; top: 0; left: 0; right: 0; bottom: 0; background-color: rgb(var(--item-active-bg)); transition: .4s; border-radius: 34px;}
    .slider:before { position: absolute; content: ""; height: 18px; width: 18px; left: 3px; bottom: 3px; background-color: rgb(var(--text-main)); transition: .4s; border-radius: 50%;}
    input:checked + .slider { background-color: rgb(var(--brand-primary)); }
    input:checked + .slider:before { transform: translateX(20px); }
</style>
@endpush

@push('scripts')
<script>
    const apiBase = '/api/admin/feature-flags';
    let globalFlags = [];

    function getApiHeaders(includeContentType = false) {
        const headers = {
            'Accept': 'application/json',
            'Authorization': `Bearer ${localStorage.getItem('token') || ''}`,
            'X-Device-Fingerprint': localStorage.getItem('device_fingerprint') || ''
        };
        if (includeContentType) headers['Content-Type'] = 'application/json';
        return headers;
    }

    // --- Toast Notification Logic ---
    function showToast(message, isError = false) {
        const toast = document.getElementById('toastMessage');
        const text = document.getElementById('toastText');
        text.innerText = message;
        
        toast.className = `fixed top-5 right-5 px-6 py-3 rounded shadow-lg transform transition-transform z-50 flex items-center ${isError ? 'bg-red-500 text-white' : 'bg-green-500 text-white'}`;
        toast.style.transform = "translateX(0)"; 

        setTimeout(() => {
            toast.style.transform = "translateX(150%)"; 
        }, 3000);
    }

    document.addEventListener('DOMContentLoaded', fetchFlags);

    // --- Fetch Data (BULLETPROOF PARSING) ---
    async function fetchFlags() {
        try {
            const res = await fetch(apiBase, { headers: getApiHeaders(false) });
            const result = await res.json();
            
            
            // 1. Safely extract array regardless of Laravel's response wrapper
            if (Array.isArray(result)) {
                globalFlags = result;
            } else if (result && Array.isArray(result.data)) {
                globalFlags = result.data; // Standard Laravel format
            } else if (result && result.data && Array.isArray(result.data.data)) {
                globalFlags = result.data.data; // Laravel Pagination format
            } else if (result && typeof result === 'object') {
                globalFlags = Object.values(result); // Fallback if it's an object of objects
            } else {
                globalFlags = [];
            }
            
            console.log("Extracted Data for Table:", globalFlags); // For your debugging
            
            renderTable();
            updateStats();
        } catch (error) {
            console.error('Error fetching flags:', error);
            document.getElementById('flagsTableBody').innerHTML = '<tr><td colspan="5" class="text-center py-4 text-red-500 font-bold">Failed to load data. Check console.</td></tr>';
        }
    }

    // --- Render Table ---
    function renderTable() {
        const tbody = document.getElementById('flagsTableBody');
        tbody.innerHTML = '';

        if (!globalFlags || globalFlags.length === 0) {
            tbody.innerHTML = '<tr><td colspan="5" class="text-center py-4 theme-text-muted">No feature flags found.</td></tr>';
            return;
        }

        let rowsHTML = '';
        globalFlags.forEach(flag => {
            // 2. Safely parse JSON value to avoid undefined errors
            let val = {};
            if (typeof flag.value === 'string') {
                try { val = JSON.parse(flag.value); } catch(e) { console.error("Parse error on flag value"); }
            } else if (typeof flag.value === 'object' && flag.value !== null) {
                val = flag.value;
            }

            // Provide fallback values 'N/A' so 'undefined' never prints
            let key = flag.key || 'N/A';
            let name = val.name || key;
            let type = flag.type || 'boolean';
            let isEnabled = val.enabled == true; 
            let dependencies = val.dependencies || '';

            let typeBadgeColor = type === 'boolean' ? 'bg-blue-100 text-blue-800' : 
                                 type === 'percentage' ? 'bg-purple-100 text-purple-800' : 'bg-green-100 text-green-800';
            
            let rolloutDisplay = '<span class="theme-text-main">100% Global</span>';
            if (type === 'percentage') {
                let perc = val.rollout || 0;
                rolloutDisplay = `<div class="flex items-center"><span class="mr-2 theme-text-main">${perc}%</span>
                                  <div class="w-full bg-[rgb(var(--border-color))] rounded-full h-2">
                                  <div class="bg-[rgb(var(--brand-primary))] h-2 rounded-full" style="width: ${perc}%"></div></div></div>`;
            } else if(type === 'user_segment') {
                rolloutDisplay = `<span class="theme-text-main">${val.scope || 'All Segments'}</span>`;
            }

            // Use flag.id fallback in case API returns ID differently
            let id = flag.id || null;

            rowsHTML += `
                <tr>
                    <td class="px-5 py-4 border-b theme-border theme-bg-card text-sm">
                        <p class="theme-text-main font-semibold whitespace-no-wrap">${name}</p>
                        <p class="theme-text-muted text-xs">Key: ${key} ${dependencies ? '| Dep: ' + dependencies : ''}</p>
                    </td>
                    <td class="px-5 py-4 border-b theme-border theme-bg-card text-sm">
                        <span class="${typeBadgeColor} text-xs font-semibold px-2 py-1 rounded uppercase">${type}</span>
                    </td>
                    <td class="px-5 py-4 border-b theme-border theme-bg-card text-sm w-1/4">
                        ${rolloutDisplay}
                    </td>
                    <td class="px-5 py-4 border-b theme-border theme-bg-card text-sm">
                        <label class="switch">
                            <input type="checkbox" onchange="toggleStatus(${id}, this.checked)" ${isEnabled ? 'checked' : ''}>
                            <span class="slider round"></span>
                        </label>
                    </td>
                    <td class="px-5 py-4 border-b theme-border theme-bg-card text-sm text-center">
                        <button onclick="deleteFlag(${id})" class="text-orange-500 hover:text-orange-700 mx-1 font-bold" title="Delete Flag"><i class="fas fa-trash"></i> Delete</button>
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
            let val = {};
            if (typeof flag.value === 'string') {
                try { val = JSON.parse(flag.value); } catch(e) {}
            } else if (typeof flag.value === 'object' && flag.value !== null) {
                val = flag.value;
            }

            if (val.enabled) activeCount++;
            if (flag.type === 'percentage') rolloutCount++;
        });

        document.getElementById('stat-total').innerText = globalFlags.length;
        document.getElementById('stat-active').innerText = activeCount;
        document.getElementById('stat-rollout').innerText = rolloutCount;
        document.getElementById('stat-killed').innerText = globalFlags.length - activeCount;
    }

    // --- Modal Config ---
    function openModal() {
        document.getElementById('flagForm').reset();
        document.getElementById('flagId').value = '';
        document.getElementById('flagKey').disabled = false;
        document.getElementById('modalTitle').innerText = 'Create Feature Flag';
        toggleDynamicFields();
        document.getElementById('flagModal').classList.remove('hidden');
    }

    function closeModal() { document.getElementById('flagModal').classList.add('hidden'); }

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
            name: document.getElementById('flagName').value,
            enabled: true, 
            dependencies: document.getElementById('flagDependencies').value
        };

        if(type === 'percentage') valueData.rollout = document.getElementById('flagPercentage').value;
        if(type === 'user_segment') valueData.scope = document.getElementById('flagScope').value;

        const payload = {
            key: document.getElementById('flagKey').value,
            type: type,
            value: valueData
        };

        const method = id ? 'PUT' : 'POST';
        const url = id ? `${apiBase}/${id}` : apiBase;

        try {
            const res = await fetch(url, {
                method: method,
                headers: getApiHeaders(true),
                body: JSON.stringify(payload)
            });
            
            if(res.ok) {
                showToast(id ? 'Flag Updated Successfully!' : 'New Flag Created Successfully!');
                closeModal();
                fetchFlags();
            } else {
                const err = await res.json();
                showToast(`Error: ${err.message || 'Could not save flag'}`, true);
            }
        } catch (error) {
            showToast('Network error occurred.', true);
        }
    }

    // --- Toggle Switch Logic ---
    async function toggleStatus(id, isActive) {
        if (!id) return;
        const flag = globalFlags.find(f => f.id == id);
        
        let currentVal = {};
        if (typeof flag.value === 'string') {
            try { currentVal = JSON.parse(flag.value); } catch(e) {}
        } else if (typeof flag.value === 'object' && flag.value !== null) {
            currentVal = flag.value;
        }
        
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
        if(confirm("Are you sure you want to completely delete this flag?")) {
            try {
                const res = await fetch(`${apiBase}/${id}`, {
                    method: 'DELETE',
                    headers: getApiHeaders(false)
                });
                
                if(res.ok) {
                    showToast('Flag deleted successfully.');
                    fetchFlags();
                } else {
                    showToast('Failed to delete flag.', true);
                }
            } catch (error) {
                showToast('Network Error', true);
            }
        }
    }
</script>
@endpush