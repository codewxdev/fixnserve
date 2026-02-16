@extends('layouts.app')

@section('content')
    {{-- 
    ==========================================================================
    REGIONAL CONTROL CENTER
    ==========================================================================
    --}}

    <div class="min-h-screen theme-bg-body theme-text-main p-6 font-sans">

        {{-- HEADER & GLOBAL STATS --}}
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
            <div>
                <h1 class="text-2xl font-bold tracking-tight theme-text-main flex items-center gap-2">
                    <span class="p-2 bg-blue-600/20 rounded-lg text-blue-400">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                            </path>
                        </svg>
                    </span>
                    Regional Operations
                </h1>
                <p class="theme-text-muted text-sm mt-1 ml-12">Control service availability by Country.</p>
            </div>

            {{-- Filter Tabs --}}
            <div class="flex items-center gap-2 theme-bg-card p-1 rounded-lg border theme-border">
                <button onclick="filterView('country')"
                    class="filter-btn px-4 py-1.5 text-xs font-medium rounded transition bg-gray-700 text-white"
                    id="btn-country">Countries</button>
                <button disabled
                    class="filter-btn px-4 py-1.5 text-xs font-medium theme-text-muted cursor-not-allowed rounded transition hover:bg-white/5">Provinces</button>
            </div>
        </div>

        {{-- AI ALERTS SECTION --}}
        <div id="ai-alerts-container" class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 h-[calc(100vh-250px)]">

            {{-- LEFT PANEL: REGION LIST --}}
            <div class="theme-bg-card rounded-xl border theme-border flex flex-col shadow-lg overflow-hidden">
                <div class="p-4 border-b theme-border rounded-t-xl shrink-0" style="background-color: rgba(var(--bg-body), 0.5);">
                    <div class="relative">
                        <input type="text" id="search-input" onkeyup="filterList()" placeholder="Search Country..."
                            class="w-full theme-bg-body border theme-border theme-text-main text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5 pl-9">
                        <svg class="w-4 h-4 theme-text-muted absolute left-3 top-3" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                </div>

                <div id="regions-list" class="flex-1 overflow-y-auto p-2 space-y-2 custom-scrollbar">
                    <div class="text-center theme-text-muted mt-10">Loading Regions...</div>
                </div>
            </div>

            {{-- RIGHT PANEL: INTERACTIVE MAP --}}
            <div class="lg:col-span-2 theme-bg-card rounded-xl border theme-border overflow-hidden shadow-lg relative group">
                <div class="absolute top-4 left-4 z-10 backdrop-blur px-3 py-1 rounded border theme-border text-xs theme-text-main" 
                     style="background-color: rgba(var(--bg-body), 0.8);">
                    <span class="w-2 h-2 rounded-full bg-green-500 inline-block mr-1"></span> Enabled
                    <span class="w-2 h-2 rounded-full bg-yellow-500 inline-block mx-1"></span> Soft Disabled
                    <span class="w-2 h-2 rounded-full bg-red-500 inline-block mx-1"></span> Hard Disabled
                </div>

                <div class="w-full h-full relative theme-bg-body">
                    <div class="absolute inset-0 opacity-40 bg-[url('https://upload.wikimedia.org/wikipedia/commons/thumb/e/ec/World_map_blank_without_borders.svg/2000px-World_map_blank_without_borders.svg.png')] bg-cover bg-center grayscale">
                    </div>

                    <div id="map-markers"></div>
                </div>
            </div>
        </div>
    </div>

    {{-- MODAL --}}
    <div id="control-modal"
        class="fixed inset-0 z-50 hidden bg-black/80 backdrop-blur-sm flex items-center justify-center p-4 transition-opacity duration-300">
        
        <div class="theme-bg-card rounded-xl shadow-2xl w-full max-w-lg border theme-border transform transition-all scale-95"
            id="modal-content">

            <div class="p-5 border-b theme-border flex justify-between items-center rounded-t-xl" style="background-color: rgba(var(--bg-body), 0.5);">
                <div>
                    <h3 class="text-lg font-bold theme-text-main flex items-center gap-2">
                        <span id="modal-region-name">Region Name</span>
                        <span id="modal-current-badge"
                            class="text-[10px] uppercase px-2 py-0.5 rounded border theme-border" style="background-color: rgba(255,255,255,0.1);">Loading...</span>
                    </h3>
                    <p class="text-xs theme-text-muted">Modify availability status</p>
                </div>
                <button onclick="closeModal()" class="theme-text-muted hover:text-white"><svg class="w-6 h-6" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                        </path>
                    </svg></button>
            </div>

            <div class="p-6">
                <div id="impact-preview-box" class="bg-blue-900/20 border border-blue-500/30 rounded-lg p-4 mb-6 hidden">
                    <h4 class="text-xs font-bold text-blue-400 uppercase tracking-wide mb-2 flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Impact Preview
                    </h4>
                    <div class="grid grid-cols-2 gap-4 text-sm">
                        <div>
                            <span class="theme-text-muted block text-xs">Active Users (Est)</span>
                            <span class="theme-text-main font-mono font-bold" id="impact-users">--</span>
                        </div>
                        <div>
                            <span class="theme-text-muted block text-xs">Orders (Est)</span>
                            <span class="theme-text-main font-mono font-bold" id="impact-orders">--</span>
                        </div>
                    </div>
                </div>

                <label class="text-xs font-semibold theme-text-muted uppercase mb-3 block">Select New Status</label>
                <div class="grid grid-cols-3 gap-3 mb-6">
                    <label class="cursor-pointer group">
                        <input type="radio" name="status" value="active" class="peer sr-only"
                            onchange="updateImpactPreview('active')">
                        <div
                            class="p-3 text-center rounded-lg border theme-border hover:bg-white/5 transition peer-checked:bg-green-500/20 peer-checked:border-green-500 peer-checked:text-green-400 theme-text-muted h-full flex flex-col justify-center">
                            <div class="text-sm font-bold">Enabled</div>
                            <div class="text-[10px] opacity-70">Normal Ops</div>
                        </div>
                    </label>

                    <label class="cursor-pointer group">
                        <input type="radio" name="status" value="soft_disable" class="peer sr-only"
                            onchange="updateImpactPreview('soft')">
                        <div
                            class="p-3 text-center rounded-lg border theme-border hover:bg-white/5 transition peer-checked:bg-yellow-500/20 peer-checked:border-yellow-500 peer-checked:text-yellow-400 theme-text-muted h-full flex flex-col justify-center">
                            <div class="text-sm font-bold">Soft Disable</div>
                            <div class="text-[10px] opacity-70">No New Orders</div>
                        </div>
                    </label>

                    <label class="cursor-pointer group">
                        <input type="radio" name="status" value="hard_disable" class="peer sr-only"
                            onchange="updateImpactPreview('hard')">
                        <div
                            class="p-3 text-center rounded-lg border theme-border hover:bg-white/5 transition peer-checked:bg-red-600/20 peer-checked:border-red-500 peer-checked:text-red-400 theme-text-muted h-full flex flex-col justify-center">
                            <div class="text-sm font-bold">Hard Disable</div>
                            <div class="text-[10px] opacity-70">Emergency Stop</div>
                        </div>
                    </label>
                </div>

                <div class="mt-4 pt-4 border-t theme-border" id="rollback-container">
                    <div class="flex items-center gap-3">
                        <input type="checkbox" id="auto-rollback"
                            class="rounded bg-gray-700 border-gray-600 text-blue-600 focus:ring-blue-500">
                        <label for="auto-rollback" class="text-sm theme-text-muted">
                            Auto-revert to 'Enabled' after
                            <input type="number" value="60"
                                class="w-16 theme-bg-body border theme-border rounded text-center text-xs py-1 px-1 mx-1 focus:border-blue-500 theme-text-main">
                            minutes
                        </label>
                    </div>
                </div>
            </div>

            <div class="p-4 border-t theme-border rounded-b-xl flex justify-end gap-3" style="background-color: rgba(var(--bg-body), 0.5);">
                <button onclick="closeModal()"
                    class="px-4 py-2 text-sm theme-text-muted hover:text-white transition">Cancel</button>
                <button onclick="saveStatus()" id="save-btn"
                    class="px-6 py-2 text-sm bg-white text-gray-900 hover:bg-gray-200 font-bold rounded-lg shadow-lg transition flex items-center gap-2">
                    Update Status
                </button>
            </div>
        </div>
    </div>

    {{-- 
    ==========================================================================
    JAVASCRIPT LOGIC
    ==========================================================================
    --}}
    @push('scripts')
        <script>
            // ------------------------------------------------------------------
            // CONFIGURATION & STATE
            // ------------------------------------------------------------------
            let regionsData = [];
            let currentFilter = 'country';
            let selectedRegionId = null;

            const statusMap = {
                'enabled': 'active',
                'soft_disabled': 'soft_disable',
                'hard_disabled': 'hard_disable'
            };

            const reverseStatusMap = {
                'active': 'enabled',
                'soft_disable': 'soft_disabled',
                'hard_disable': 'hard_disabled'
            };

            // ------------------------------------------------------------------
            // 1. INITIALIZATION
            // ------------------------------------------------------------------
            document.addEventListener('DOMContentLoaded', () => {
                if (document.getElementById('regions-list')) {
                    fetchCountries();
                }
                if (document.getElementById('ai-alerts-container')) {
                    renderInsights();
                }
            });

            async function fetchCountries() {
                const listContainer = document.getElementById('regions-list');
                if (!listContainer) return;

                listContainer.innerHTML = '<div class="text-center theme-text-muted mt-10">Fetching live data...</div>';

                try {
                    const response = await fetch('/api/countries', {
                        headers: {
                            'Accept': 'application/json'
                        }
                    });

                    const result = await response.json();
                    
                    let countriesArray = [];
                    if (result.data && Array.isArray(result.data)) {
                        countriesArray = result.data;
                    } else if (Array.isArray(result)) {
                        countriesArray = result;
                    }

                    // Map Backend Data
                    regionsData = countriesArray.map(country => ({
                        id: country.id,
                        name: country.name,
                        iso2: country.iso2,
                        type: 'country',
                        status: statusMap[country.status] || 'active',
                        active_users: Math.floor(Math.random() * 50000) + 1000,
                        pending_orders: Math.floor(Math.random() * 500),
                        coordinates: getRandomCoordinates()
                    }));

                    filterView('country');

                } catch (error) {
                    console.error('Error fetching countries:', error);
                    listContainer.innerHTML =
                        '<div class="text-red-500 text-sm p-4 text-center">Failed to load data.</div>';
                }
            }

            function getRandomCoordinates() {
                return {
                    top: Math.floor(Math.random() * 60 + 20) + '%',
                    left: Math.floor(Math.random() * 80 + 10) + '%'
                };
            }

            // ------------------------------------------------------------------
            // 2. RENDER FUNCTIONS
            // ------------------------------------------------------------------
            function filterView(type) {
                currentFilter = type;
                const filtered = regionsData.filter(r => r.type === type);
                renderList(filtered);
                renderMapMarkers(filtered);
            }

            function renderList(data) {
                const container = document.getElementById('regions-list');
                if (!container) return;

                container.innerHTML = '';

                if (data.length === 0) {
                    container.innerHTML = '<div class="theme-text-muted text-sm p-4 text-center">No regions found.</div>';
                    return;
                }

                data.forEach(region => {
                    let statusColor = region.status === 'active' ?
                        'text-green-400 bg-green-500/10 border-green-500/20' :
                        region.status === 'soft_disable' ? 'text-yellow-400 bg-yellow-500/10 border-yellow-500/20' :
                        'text-red-400 bg-red-500/10 border-red-500/20';

                    let statusLabel = region.status.replace('_', ' ').toUpperCase();
                    let isoCode = region.iso2 ? region.iso2.toUpperCase() : 'N/A';

                    // Using CSS Variables in Inline Styles for Background
                    const html = `
                <div class="p-3 rounded-lg border hover:bg-white/5 transition group relative overflow-hidden" 
                     style="background-color: rgba(255,255,255,0.02); border-color: rgb(var(--border-color));">
                    
                    <div class="flex justify-between items-start">
                        <div>
                            <h4 class="font-semibold theme-text-main text-sm">${region.name}</h4>
                            <span class="inline-block mt-1 text-[10px] font-mono theme-text-muted border theme-border px-1.5 rounded" style="background-color: rgba(var(--bg-body), 0.5);">
                                ISO: ${isoCode}
                            </span>
                        </div>
                        <span class="${statusColor} text-[10px] px-2 py-0.5 rounded border font-medium">${statusLabel}</span>
                    </div>
                    
                    <div class="mt-3 flex items-center justify-end">
                        <button onclick="openModal(${region.id})" class="text-xs theme-text-main hover:bg-white/10 px-3 py-1.5 rounded border theme-border transition">Manage</button>
                    </div>
                </div>
            `;
                    container.insertAdjacentHTML('beforeend', html);
                });
            }

            function renderMapMarkers(data) {
                const container = document.getElementById('map-markers');
                if (!container) return;
                container.innerHTML = '';

                data.forEach(region => {
                    let color = region.status === 'active' ? 'bg-green-500' :
                        region.status === 'soft_disable' ? 'bg-yellow-500' : 'bg-red-500';
                    let animation = region.status === 'hard_disable' ? 'animate-ping' : '';

                    const marker = `
                <div class="absolute cursor-pointer group" style="top: ${region.coordinates.top}; left: ${region.coordinates.left}" onclick="openModal(${region.id})">
                    <div class="absolute -inset-2 ${color} opacity-30 rounded-full blur-sm ${animation}"></div>
                    <div class="w-3 h-3 ${color} rounded-full border-2 border-white shadow-lg relative z-10"></div>
                    <div class="absolute bottom-5 left-1/2 -translate-x-1/2 theme-bg-body theme-text-main text-xs px-2 py-1 rounded border theme-border opacity-0 group-hover:opacity-100 transition pointer-events-none whitespace-nowrap z-20">
                        ${region.name}
                    </div>
                </div>
            `;
                    container.insertAdjacentHTML('beforeend', marker);
                });
            }

            function renderInsights() {
                const container = document.getElementById('ai-alerts-container');
                if (!container) return;

                // Static Insight using Theme Colors
                const html = `
            <div class="bg-gradient-to-r from-purple-900/40 border-purple-500/30 to-transparent border rounded-xl p-4 flex items-start gap-3" style="border-color: rgba(168, 85, 247, 0.3);">
                <div class="p-2 text-purple-400 bg-purple-500/20 rounded-lg shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                </div>
                <div>
                    <h4 class="text-sm font-bold theme-text-main">System Online</h4>
                    <p class="text-xs theme-text-muted mt-1">Real-time country restrictions are active.</p>
                </div>
            </div>
        `;
                container.innerHTML = html;
            }

            // ------------------------------------------------------------------
            // 3. ACTIONS
            // ------------------------------------------------------------------
            function filterList() {
                const search = document.getElementById('search-input').value.toLowerCase();
                const filtered = regionsData.filter(r => r.name.toLowerCase().includes(search));
                renderList(filtered);
            }

            function openModal(id) {
                selectedRegionId = id;
                const region = regionsData.find(r => r.id === id);
                if (!region) return;

                document.getElementById('modal-region-name').innerText = region.name;
                document.getElementById('modal-current-badge').innerText = region.status.replace('_', ' ');
                document.getElementById('impact-users').innerText = region.active_users.toLocaleString();
                document.getElementById('impact-orders').innerText = region.pending_orders;

                const radios = document.getElementsByName('status');
                radios.forEach(r => r.checked = (r.value === region.status));

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
                    box.classList.remove('hidden');
                    box.classList.add('bg-red-900/20', 'border-red-500/30');
                    box.classList.remove('bg-blue-900/20', 'border-blue-500/30');
                    rollback.classList.remove('hidden');
                } else if (status === 'soft' || status === 'soft_disable') {
                    box.classList.remove('hidden');
                    box.classList.add('bg-blue-900/20', 'border-blue-500/30');
                    box.classList.remove('bg-red-900/20', 'border-red-500/30');
                    rollback.classList.remove('hidden');
                } else {
                    box.classList.add('hidden');
                    rollback.classList.add('hidden');
                }
            }

            async function saveStatus() {
                const btn = document.getElementById('save-btn');
                const originalText = btn.innerHTML;
                const selectedFrontendStatus = document.querySelector('input[name="status"]:checked').value;
                const dbStatus = reverseStatusMap[selectedFrontendStatus];

                btn.disabled = true;
                btn.innerHTML = 'Saving...';

                try {
                    const response = await fetch(`/api/countries/${selectedRegionId}`, {
                        method: 'PATCH',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                                'content')
                        },
                        body: JSON.stringify({
                            status: dbStatus
                        })
                    });

                    if (!response.ok) throw new Error('Update failed');

                    const region = regionsData.find(r => r.id === selectedRegionId);
                    if (region) region.status = selectedFrontendStatus;

                    filterView(currentFilter);
                    closeModal();
                    alert(`Success! ${region.name} status updated.`);

                } catch (error) {
                    console.error(error);
                    alert('Failed to update status.');
                } finally {
                    btn.disabled = false;
                    btn.innerHTML = originalText;
                }
            }
        </script>
    @endpush
@endsection