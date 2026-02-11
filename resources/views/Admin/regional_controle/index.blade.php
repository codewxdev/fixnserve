@extends('layouts.app')

@section('content')

{{-- 
    ==========================================================================
    REGIONAL CONTROL CENTER (Mockup v2)
    Objective: Safe Geo-Fencing & Service Availability Control
    ==========================================================================
--}}

<div class="min-h-screen bg-gray-900 text-gray-100 p-6 font-sans">

    {{-- HEADER & GLOBAL STATS --}}
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-white flex items-center gap-2">
                <span class="p-2 bg-blue-600/20 rounded-lg text-blue-400">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </span>
                Regional Operations
            </h1>
            <p class="text-gray-400 text-sm mt-1 ml-12">Control service availability by Country, Province, or City.</p>
        </div>

        {{-- Filter Tabs --}}
        <div class="flex items-center gap-2 bg-gray-800 p-1 rounded-lg border border-gray-700">
            <button onclick="filterView('country')" class="filter-btn px-4 py-1.5 text-xs font-medium bg-gray-700 text-white rounded transition" id="btn-country">Countries</button>
            <button onclick="filterView('state')" class="filter-btn px-4 py-1.5 text-xs font-medium text-gray-400 hover:text-white hover:bg-gray-700 rounded transition" id="btn-state">Provinces</button>
            <button onclick="filterView('city')" class="filter-btn px-4 py-1.5 text-xs font-medium text-gray-400 hover:text-white hover:bg-gray-700 rounded transition" id="btn-city">Cities / Zones</button>
        </div>
    </div>

    {{-- AI ALERTS SECTION (Dynamic) --}}
    <div id="ai-alerts-container" class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
        </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 h-[calc(100vh-250px)]">
        
        {{-- LEFT PANEL: REGION LIST --}}
        <div class="bg-gray-800 rounded-xl border border-gray-700 flex flex-col shadow-lg">
            <div class="p-4 border-b border-gray-700 bg-gray-800/50 rounded-t-xl">
                <div class="relative">
                    <input type="text" id="search-input" onkeyup="filterList()" placeholder="Search (e.g., Lahore)..." class="w-full bg-gray-900 border border-gray-600 text-gray-300 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5 pl-9">
                    <svg class="w-4 h-4 text-gray-500 absolute left-3 top-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </div>
            </div>

            <div id="regions-list" class="flex-1 overflow-y-auto custom-scrollbar p-2 space-y-2">
                <div class="text-center text-gray-500 mt-10">Loading Regions...</div>
            </div>
        </div>

        {{-- RIGHT PANEL: INTERACTIVE MAP (Visual Representation) --}}
        <div class="lg:col-span-2 bg-gray-800 rounded-xl border border-gray-700 overflow-hidden shadow-lg relative group">
            <div class="absolute top-4 left-4 z-10 bg-gray-900/80 backdrop-blur px-3 py-1 rounded border border-gray-700 text-xs text-gray-300">
                <span class="w-2 h-2 rounded-full bg-green-500 inline-block mr-1"></span> Active
                <span class="w-2 h-2 rounded-full bg-yellow-500 inline-block mx-1"></span> Soft Disable
                <span class="w-2 h-2 rounded-full bg-red-500 inline-block mx-1"></span> Hard Disable
            </div>

            <div class="w-full h-full bg-gray-900 relative">
                <div class="absolute inset-0 opacity-40 bg-[url('https://upload.wikimedia.org/wikipedia/commons/thumb/e/ec/World_map_blank_without_borders.svg/2000px-World_map_blank_without_borders.svg.png')] bg-cover bg-center grayscale"></div>
                
                <div id="map-markers">
                    </div>
            </div>
        </div>
    </div>
</div>

{{-- 
    ==========================================================================
    MODAL: SAFETY & IMPACT CONTROL
    ==========================================================================
--}}
<div id="control-modal" class="fixed inset-0 z-50 hidden bg-black/80 backdrop-blur-sm flex items-center justify-center p-4 transition-opacity duration-300">
    <div class="bg-gray-800 rounded-xl shadow-2xl w-full max-w-lg border border-gray-600 transform transition-all scale-95" id="modal-content">
        
        <div class="p-5 border-b border-gray-700 flex justify-between items-center bg-gray-800 rounded-t-xl">
            <div>
                <h3 class="text-lg font-bold text-white flex items-center gap-2">
                    <span id="modal-region-name">Region Name</span>
                    <span id="modal-current-badge" class="text-[10px] uppercase px-2 py-0.5 rounded bg-gray-700 border border-gray-600">Loading...</span>
                </h3>
                <p class="text-xs text-gray-400">Modify availability status</p>
            </div>
            <button onclick="closeModal()" class="text-gray-400 hover:text-white"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg></button>
        </div>

        <div class="p-6">
            
            <div id="impact-preview-box" class="bg-blue-900/20 border border-blue-500/30 rounded-lg p-4 mb-6 hidden">
                <h4 class="text-xs font-bold text-blue-400 uppercase tracking-wide mb-2 flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    Impact Preview
                </h4>
                <div class="grid grid-cols-2 gap-4 text-sm">
                    <div>
                        <span class="text-gray-400 block text-xs">Active Users</span>
                        <span class="text-white font-mono font-bold" id="impact-users">--</span>
                    </div>
                    <div>
                        <span class="text-gray-400 block text-xs">Pending Orders</span>
                        <span class="text-white font-mono font-bold" id="impact-orders">--</span>
                    </div>
                </div>
            </div>

            <label class="text-xs font-semibold text-gray-400 uppercase mb-3 block">Select New Status</label>
            <div class="grid grid-cols-3 gap-3 mb-6">
                <label class="cursor-pointer group">
                    <input type="radio" name="status" value="active" class="peer sr-only" onchange="updateImpactPreview('active')">
                    <div class="p-3 text-center rounded-lg border border-gray-600 bg-gray-700/30 peer-checked:bg-green-600/20 peer-checked:border-green-500 peer-checked:text-green-400 text-gray-400 transition hover:bg-gray-700 h-full flex flex-col justify-center">
                        <div class="text-sm font-bold">Active</div>
                        <div class="text-[10px] opacity-70">Normal Ops</div>
                    </div>
                </label>

                <label class="cursor-pointer group">
                    <input type="radio" name="status" value="soft_disable" class="peer sr-only" onchange="updateImpactPreview('soft')">
                    <div class="p-3 text-center rounded-lg border border-gray-600 bg-gray-700/30 peer-checked:bg-yellow-600/20 peer-checked:border-yellow-500 peer-checked:text-yellow-400 text-gray-400 transition hover:bg-gray-700 h-full flex flex-col justify-center">
                        <div class="text-sm font-bold">Soft Disable</div>
                        <div class="text-[10px] opacity-70">No New Orders</div>
                    </div>
                </label>

                <label class="cursor-pointer group">
                    <input type="radio" name="status" value="hard_disable" class="peer sr-only" onchange="updateImpactPreview('hard')">
                    <div class="p-3 text-center rounded-lg border border-gray-600 bg-gray-700/30 peer-checked:bg-red-600/20 peer-checked:border-red-500 peer-checked:text-red-400 text-gray-400 transition hover:bg-gray-700 h-full flex flex-col justify-center">
                        <div class="text-sm font-bold">Hard Disable</div>
                        <div class="text-[10px] opacity-70">Emergency Stop</div>
                    </div>
                </label>
            </div>

            <div class="mt-4 pt-4 border-t border-gray-700" id="rollback-container">
                <div class="flex items-center gap-3">
                    <input type="checkbox" id="auto-rollback" class="rounded bg-gray-700 border-gray-600 text-blue-600 focus:ring-blue-500">
                    <label for="auto-rollback" class="text-sm text-gray-300">
                        Auto-revert to 'Active' after 
                        <input type="number" value="60" class="w-16 bg-gray-900 border border-gray-600 rounded text-center text-xs py-1 px-1 mx-1 focus:border-blue-500"> 
                        minutes
                    </label>
                </div>
            </div>
        </div>

        <div class="p-4 border-t border-gray-700 bg-gray-800/50 rounded-b-xl flex justify-end gap-3">
            <button onclick="closeModal()" class="px-4 py-2 text-sm text-gray-300 hover:text-white transition">Cancel</button>
            <button onclick="saveStatus()" id="save-btn" class="px-6 py-2 text-sm bg-white text-gray-900 hover:bg-gray-200 font-bold rounded-lg shadow-lg transition flex items-center gap-2">
                Update Status
            </button>
        </div>
    </div>
</div>

{{-- 
    ==========================================================================
    JAVASCRIPT LOGIC (Simulates API & Interaction)
    ==========================================================================
--}}
@push('scripts')
<script>
    // ------------------------------------------------------------------
    // 1. MOCK DATA (Is format mein backend se data aana chahiye)
    // ------------------------------------------------------------------
    const regionsData = [
        {
            id: 1, name: "Pakistan", type: "country", status: "active", 
            active_users: 45000, pending_orders: 1200, risk_score: 10,
            coordinates: { top: "40%", left: "60%" }, // Mock coords for map
            has_warning: false
        },
        {
            id: 2, name: "Punjab", type: "state", status: "active", 
            active_users: 25000, pending_orders: 800, risk_score: 15,
            coordinates: { top: "42%", left: "62%" },
            has_warning: false
        },
        {
            id: 3, name: "Sindh", type: "state", status: "soft_disable", 
            active_users: 12000, pending_orders: 400, risk_score: 45,
            coordinates: { top: "48%", left: "60%" },
            has_warning: true, warning_msg: "Logistics Partner API Down"
        },
        {
            id: 4, name: "Lahore", type: "city", status: "active", 
            active_users: 15000, pending_orders: 650, risk_score: 20,
            coordinates: { top: "41%", left: "63%" },
            has_warning: false
        },
        {
            id: 5, name: "Karachi South", type: "city", status: "hard_disable", 
            active_users: 500, pending_orders: 0, risk_score: 92,
            coordinates: { top: "50%", left: "59%" },
            has_warning: true, warning_msg: "High Fraud Activity Detected"
        }
    ];

    const aiInsights = [
        { type: 'demand', title: 'Demand Surge: Lahore', msg: 'Order volume +40%. Suggest Soft Disable to clear backlog.' },
        { type: 'risk', title: 'Critical Risk: Karachi South', msg: 'Fraud score 92/100. Auto-lock recommended.' }
    ];

    let currentFilter = 'state'; // Default view
    let selectedRegionId = null;

    // ------------------------------------------------------------------
    // 2. INITIALIZATION
    // ------------------------------------------------------------------
    document.addEventListener('DOMContentLoaded', () => {
        renderInsights();
        filterView('state'); // Initial Load
    });

    // ------------------------------------------------------------------
    // 3. RENDER FUNCTIONS
    // ------------------------------------------------------------------
    function filterView(type) {
        currentFilter = type;
        
        // Update Tabs UI
        document.querySelectorAll('.filter-btn').forEach(btn => {
            btn.classList.remove('bg-gray-700', 'text-white');
            btn.classList.add('text-gray-400');
        });
        document.getElementById(`btn-${type}`).classList.add('bg-gray-700', 'text-white');
        document.getElementById(`btn-${type}`).classList.remove('text-gray-400');

        // Filter Data
        const filtered = regionsData.filter(r => r.type === type);
        renderList(filtered);
        renderMapMarkers(filtered);
    }

    function renderList(data) {
        const container = document.getElementById('regions-list');
        container.innerHTML = '';

        if(data.length === 0) {
            container.innerHTML = '<div class="text-gray-500 text-sm p-4 text-center">No regions found.</div>';
            return;
        }

        data.forEach(region => {
            // Status Styling
            let statusColor = region.status === 'active' ? 'text-green-400 bg-green-500/10 border-green-500/20' 
                            : region.status === 'soft_disable' ? 'text-yellow-400 bg-yellow-500/10 border-yellow-500/20'
                            : 'text-red-400 bg-red-500/10 border-red-500/20';
            
            let statusLabel = region.status.replace('_', ' ').toUpperCase();

            // Warning Icon
            let warningIcon = region.has_warning 
                ? `<div class="mt-2 text-[10px] flex items-center gap-1 text-yellow-500">
                     <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg> 
                     ${region.warning_msg}
                   </div>` 
                : '';

            const html = `
                <div class="p-3 bg-gray-700/30 rounded-lg border border-gray-700 hover:border-gray-500 transition group relative overflow-hidden">
                    <div class="flex justify-between items-start">
                        <div>
                            <h4 class="font-semibold text-white text-sm">${region.name}</h4>
                            <p class="text-[10px] text-gray-400 mt-0.5">Users: ${region.active_users.toLocaleString()}</p>
                        </div>
                        <span class="${statusColor} text-[10px] px-2 py-0.5 rounded border font-medium">${statusLabel}</span>
                    </div>
                    ${warningIcon}
                    <div class="mt-3 flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <span class="text-[10px] text-gray-500 uppercase font-bold">Risk</span>
                            <div class="h-1 w-16 bg-gray-700 rounded-full overflow-hidden">
                                <div class="h-full ${region.risk_score > 50 ? 'bg-red-500' : 'bg-green-500'}" style="width: ${region.risk_score}%"></div>
                            </div>
                        </div>
                        <button onclick="openModal(${region.id})" class="text-xs bg-gray-700 hover:bg-gray-600 text-white px-3 py-1.5 rounded border border-gray-600 transition">Manage</button>
                    </div>
                </div>
            `;
            container.insertAdjacentHTML('beforeend', html);
        });
    }

    function renderMapMarkers(data) {
        const container = document.getElementById('map-markers');
        container.innerHTML = '';

        data.forEach(region => {
            let color = region.status === 'active' ? 'bg-green-500' 
                      : region.status === 'soft_disable' ? 'bg-yellow-500' : 'bg-red-500';
            
            // Pulse animation for critical issues
            let animation = region.status === 'hard_disable' || region.has_warning ? 'animate-ping' : '';

            const marker = `
                <div class="absolute cursor-pointer group" style="top: ${region.coordinates.top}; left: ${region.coordinates.left}" onclick="openModal(${region.id})">
                    <div class="absolute -inset-2 ${color} opacity-30 rounded-full blur-sm ${animation}"></div>
                    <div class="w-3 h-3 ${color} rounded-full border-2 border-white shadow-lg relative z-10"></div>
                    
                    <div class="absolute bottom-5 left-1/2 -translate-x-1/2 bg-gray-900 text-white text-xs px-2 py-1 rounded border border-gray-600 opacity-0 group-hover:opacity-100 transition pointer-events-none whitespace-nowrap z-20">
                        ${region.name} (${region.status})
                    </div>
                </div>
            `;
            container.insertAdjacentHTML('beforeend', marker);
        });
    }

    function renderInsights() {
        const container = document.getElementById('ai-alerts-container');
        aiInsights.forEach(insight => {
            const colorClass = insight.type === 'demand' ? 'from-purple-900/40 border-purple-500/30' : 'from-red-900/40 border-red-500/30';
            const iconColor = insight.type === 'demand' ? 'text-purple-400 bg-purple-500/20' : 'text-red-400 bg-red-500/20';
            
            const html = `
                <div class="bg-gradient-to-r ${colorClass} to-gray-800 border rounded-xl p-4 flex items-start gap-3">
                    <div class="p-2 ${iconColor} rounded-lg shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                    </div>
                    <div>
                        <h4 class="text-sm font-bold text-white">${insight.title}</h4>
                        <p class="text-xs text-gray-300 mt-1">${insight.msg}</p>
                    </div>
                </div>
            `;
            container.insertAdjacentHTML('beforeend', html);
        });
    }

    // ------------------------------------------------------------------
    // 4. MODAL & ACTIONS
    // ------------------------------------------------------------------
    function openModal(id) {
        selectedRegionId = id;
        const region = regionsData.find(r => r.id === id);
        
        // Populate Header
        document.getElementById('modal-region-name').innerText = region.name;
        document.getElementById('modal-current-badge').innerText = region.status.replace('_', ' ');

        // Populate Impact (Simulating Impact API)
        document.getElementById('impact-users').innerText = region.active_users.toLocaleString();
        document.getElementById('impact-orders').innerText = region.pending_orders;
        
        // Select current radio
        const radios = document.getElementsByName('status');
        radios.forEach(r => r.checked = (r.value === region.status));

        // Show Modal
        document.getElementById('control-modal').classList.remove('hidden');
        document.getElementById('modal-content').classList.remove('scale-95');
        document.getElementById('modal-content').classList.add('scale-100');

        updateImpactPreview(region.status === 'active' ? 'active' : 'hard');
    }

    function closeModal() {
        document.getElementById('control-modal').classList.add('hidden');
    }

    function updateImpactPreview(status) {
        const box = document.getElementById('impact-preview-box');
        const rollback = document.getElementById('rollback-container');

        if (status === 'hard' || status === 'hard_disable') {
            box.classList.remove('hidden'); // Show Impact Warning
            box.classList.add('bg-red-900/20', 'border-red-500/30');
            box.classList.remove('bg-blue-900/20', 'border-blue-500/30');
            rollback.classList.remove('hidden');
        } else if (status === 'soft' || status === 'soft_disable') {
            box.classList.remove('hidden');
            box.classList.add('bg-blue-900/20', 'border-blue-500/30');
            box.classList.remove('bg-red-900/20', 'border-red-500/30');
            rollback.classList.remove('hidden');
        } else {
            box.classList.add('hidden'); // Hide for Active
            rollback.classList.add('hidden');
        }
    }

    function saveStatus() {
        const btn = document.getElementById('save-btn');
        const originalText = btn.innerHTML;
        const selectedStatus = document.querySelector('input[name="status"]:checked').value;
        const rollbackTime = document.querySelector('#auto-rollback').checked 
            ? document.querySelector('input[type="number"]').value 
            : null;

        // Simulate API Loading
        btn.disabled = true;
        btn.innerHTML = 'Updating...';

        setTimeout(() => {
            // Update Mock Data
            const region = regionsData.find(r => r.id === selectedRegionId);
            region.status = selectedStatus;

            // Refresh UI
            filterView(currentFilter);
            closeModal();
            
            btn.disabled = false;
            btn.innerHTML = originalText;
            
            alert(`Success! ${region.name} status updated to ${selectedStatus}.`);
            // In Real App: fetch POST /api/regions/${id}/status
        }, 800);
    }
</script>
@endpush
@endsection