@extends('layouts.app')

@section('content')

<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

<div x-data="riskDashboard()" x-init="initDashboard()" class="min-h-screen bg-[rgb(var(--bg-body))] font-sans transition-colors duration-300">
    <div class="container mx-auto px-4 py-8">

        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 border-b border-[rgb(var(--border-color))] pb-4">
            <div>
                <h1 class="text-3xl font-bold text-[rgb(var(--text-main))] transition-colors">Fraud, Risk & Abuse Management</h1>
                <p class="text-sm text-[rgb(var(--text-muted))] mt-1 transition-colors">Real-Time Risk Intelligence & Loss Prevention System</p>
            </div>
            
            <div class="mt-4 md:mt-0 flex items-center bg-[rgb(var(--bg-card))] p-3 rounded-lg border border-red-200 shadow-sm">
                <div class="mr-4 text-right">
                    <span class="block text-xs uppercase text-[rgb(var(--text-muted))] font-bold tracking-wider">Critical Entities</span>
                    <span class="text-lg font-bold text-red-600" x-text="`${criticalCount} Active Threats`">Loading...</span>
                </div>
                <div class="w-12 h-12 rounded-full flex items-center justify-center bg-red-100 text-red-700 font-bold">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
            <div class="bg-[rgb(var(--bg-card))] p-4 rounded-lg shadow-sm border border-[rgb(var(--border-color))] border-l-4 border-l-green-500">
                <p class="text-xs text-[rgb(var(--text-muted))] font-bold uppercase tracking-wide">Low Risk (0-30)</p>
                <h3 class="text-2xl font-bold text-[rgb(var(--text-main))] mt-1" x-text="stats.low.count">0</h3>
                <p class="text-xs text-green-600 mt-1" x-text="`${stats.low.percentage}% of network`">0%</p>
            </div>
            <div class="bg-[rgb(var(--bg-card))] p-4 rounded-lg shadow-sm border border-[rgb(var(--border-color))] border-l-4 border-l-yellow-400">
                <p class="text-xs text-[rgb(var(--text-muted))] font-bold uppercase tracking-wide">Medium Risk (31-65)</p>
                <h3 class="text-2xl font-bold text-[rgb(var(--text-main))] mt-1" x-text="stats.medium.count">0</h3>
                <p class="text-xs text-yellow-600 mt-1" x-text="stats.medium.message">Monitoring active</p>
            </div>
            <div class="bg-[rgb(var(--bg-card))] p-4 rounded-lg shadow-sm border border-[rgb(var(--border-color))] border-l-4 border-l-orange-500">
                <p class="text-xs text-[rgb(var(--text-muted))] font-bold uppercase tracking-wide">High Risk (66-89)</p>
                <h3 class="text-2xl font-bold text-[rgb(var(--text-main))] mt-1" x-text="stats.high.count">0</h3>
                <p class="text-xs text-orange-600 mt-1" x-text="stats.high.message">Restricted features</p>
            </div>
            <div class="bg-[rgb(var(--bg-card))] p-4 rounded-lg shadow-sm border border-[rgb(var(--border-color))] border-l-4 border-l-red-600">
                <p class="text-xs text-[rgb(var(--text-muted))] font-bold uppercase tracking-wide">Critical (90-100)</p>
                <h3 class="text-2xl font-bold text-[rgb(var(--text-main))] mt-1" x-text="stats.critical.count">0</h3>
                <p class="text-xs text-red-600 mt-1" x-text="stats.critical.message">Pending suspension</p>
            </div>
        </div>

        <div class="grid grid-cols-1 xl:grid-cols-4 gap-6">
            
            <div class="xl:col-span-1 space-y-6">
                <div class="bg-[rgb(var(--bg-card))] p-5 rounded-lg shadow-sm border border-[rgb(var(--border-color))] transition-colors duration-300">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-md font-semibold text-[rgb(var(--text-main))]">Risk Signal Impact</h3>
                        <button class="text-xs text-[rgb(var(--brand-primary))] hover:underline">Edit Weights</button>
                    </div>
                    <p class="text-xs text-[rgb(var(--text-muted))] mb-4">Current model weights affecting the dynamic risk score.</p>
                    
                    <div class="space-y-4">
                        <template x-for="signal in signalWeights" :key="signal.key">
                            <div>
                                <div class="flex justify-between text-xs mb-1">
                                    <span class="text-[rgb(var(--text-main))] font-medium" x-text="signal.label"></span>
                                    <span class="font-bold capitalize" 
                                          :class="{
                                            'text-red-600': signal.impact === 'high',
                                            'text-orange-500': signal.impact === 'medium',
                                            'text-yellow-600': signal.impact === 'low'
                                          }" 
                                          x-text="`${signal.impact} Impact`"></span>
                                </div>
                                <div class="w-full bg-[rgb(var(--item-active-bg))] rounded-full h-1.5">
                                    <div class="h-1.5 rounded-full" 
                                         :class="{
                                            'bg-red-500': signal.impact === 'high',
                                            'bg-orange-500': signal.impact === 'medium',
                                            'bg-yellow-500': signal.impact === 'low'
                                         }" 
                                         :style="`width: ${signal.weight}%`"></div>
                                </div>
                            </div>
                        </template>
                    </div>
                </div>
            </div>

            <div class="xl:col-span-3">
                <div class="bg-[rgb(var(--bg-card))] rounded-lg shadow-sm border border-[rgb(var(--border-color))] overflow-hidden transition-colors duration-300">
                    <div class="px-6 py-4 border-b border-[rgb(var(--border-color))] bg-[rgb(var(--item-active-bg))] flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3">
                        <div>
                            <h3 class="text-lg font-semibold text-[rgb(var(--text-main))]">Live Risk Engine Feed</h3>
                            <p class="text-xs text-[rgb(var(--text-muted))]">Real-time scoring of entities triggering risk thresholds.</p>
                        </div>
                        <div class="flex space-x-2 w-full sm:w-auto">
                            <input type="text" x-model.debounce.500ms="searchQuery" placeholder="Search Entity ID..." class="w-full sm:w-48 text-sm border-[rgb(var(--border-color))] bg-[rgb(var(--bg-card))] text-[rgb(var(--text-main))] rounded-md py-1.5 px-3 focus:ring-[rgb(var(--brand-primary))] focus:border-[rgb(var(--brand-primary))]">
                            <select x-model="tierFilter" @change="fetchLiveFeed()" class="text-sm border-[rgb(var(--border-color))] bg-[rgb(var(--bg-card))] text-[rgb(var(--text-main))] rounded-md py-1.5 px-3 focus:ring-[rgb(var(--brand-primary))] focus:border-[rgb(var(--brand-primary))]">
                                <option value="">All Tiers</option>
                                <option value="critical">Critical</option>
                                <option value="high">High</option>
                                <option value="medium">Medium</option>
                                <option value="low">Low</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-[rgb(var(--border-color))]">
                            <thead class="bg-[rgb(var(--bg-card))]">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-[rgb(var(--text-muted))] uppercase tracking-wider">Entity</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-[rgb(var(--text-muted))] uppercase tracking-wider">Risk Score</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-[rgb(var(--text-muted))] uppercase tracking-wider">Signals / Reason Codes</th>
                                    <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-[rgb(var(--text-muted))] uppercase tracking-wider">Enforcement</th>
                                </tr>
                            </thead>
                            <tbody class="bg-[rgb(var(--bg-card))] divide-y divide-[rgb(var(--border-color))]">
                                
                                <tr x-show="isLoading" class="animate-pulse">
                                    <td colspan="4" class="px-6 py-4 text-center text-sm text-[rgb(var(--text-muted))]">Fetching live risk data...</td>
                                </tr>

                                <template x-for="entity in liveFeed" :key="entity.entity_id">
                                    <tr class="hover:bg-[rgb(var(--item-active-bg))] transition-colors" :class="{'bg-red-50/10': entity.tier === 'critical'}">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-bold text-[rgb(var(--text-main))] capitalize">
                                                <span x-text="entity.entity_type"></span> #<span x-text="entity.entity_id"></span>
                                            </div>
                                            <div class="text-[10px] text-[rgb(var(--text-muted))] mt-1" x-text="`Last event: ${entity.last_event_at || 'Just now'}`"></div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center space-x-2">
                                                <span class="text-xl font-black"
                                                      :class="{
                                                        'text-red-600': entity.tier === 'critical',
                                                        'text-orange-500': entity.tier === 'high',
                                                        'text-yellow-500': entity.tier === 'medium',
                                                        'text-green-500': entity.tier === 'low'
                                                      }" x-text="entity.score"></span>
                                                <span class="px-2 py-0.5 rounded text-[10px] font-bold uppercase"
                                                      :class="{
                                                        'bg-red-100 text-red-800': entity.tier === 'critical',
                                                        'bg-orange-100 text-orange-800': entity.tier === 'high',
                                                        'bg-yellow-100 text-yellow-800': entity.tier === 'medium',
                                                        'bg-green-100 text-green-800': entity.tier === 'low'
                                                      }" x-text="entity.tier"></span>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="flex flex-wrap gap-1">
                                                <template x-for="code in entity.reason_codes" :key="code">
                                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-medium border"
                                                          :class="{
                                                            'bg-red-50 text-red-700 border-red-200': entity.tier === 'critical',
                                                            'bg-yellow-50 text-yellow-700 border-yellow-200': entity.tier === 'high' || entity.tier === 'medium',
                                                            'bg-gray-50 text-gray-700 border-gray-200': entity.tier === 'low'
                                                          }" x-text="code"></span>
                                                </template>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right">
                                            <span class="text-xs font-bold flex justify-end items-center"
                                                  :class="{
                                                    'text-red-600': entity.tier === 'critical' && entity.enforcement,
                                                    'text-orange-600': entity.tier === 'high' && entity.enforcement,
                                                    'text-[rgb(var(--text-muted))]': !entity.enforcement
                                                  }">
                                                <svg x-show="entity.tier === 'critical'" class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                                                <span x-text="entity.enforcement ? entity.enforcement.replace('_', ' ').toUpperCase() : 'Monitoring'"></span>
                                            </span>
                                            <button class="text-[10px] text-[rgb(var(--brand-primary))] hover:underline mt-1">Investigate</button>
                                        </td>
                                    </tr>
                                </template>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('riskDashboard', () => ({
            // State
            isLoading: true,
            searchQuery: '',
            tierFilter: '',
            
            // Dashboard Data
            criticalCount: 0,
            stats: {
                low: { count: 0, percentage: 0 },
                medium: { count: 0, message: '' },
                high: { count: 0, message: '' },
                critical: { count: 0, message: '' }
            },
            signalWeights: [],
            
            // Feed Data
            liveFeed: [],

            // Initialization
            initDashboard() {
                this.fetchDashboardStats();
                this.fetchLiveFeed();

                // Setup watcher for search debounce (already using x-model.debounce in HTML)
                this.$watch('searchQuery', () => {
                    this.fetchLiveFeed();
                });
            },

            // Call /api/risk/dashboard
            async fetchDashboardStats() {
                try {
                    // Agar route prefix /api/ hai tumhare baseApiController mein, tab yahan adjust kar lena
                    let response = await fetch('/api/risk/dashboard'); 
                    let json = await response.json();

                    if(json.data) {
                        this.stats = json.data.stats;
                        this.criticalCount = json.data.critical_count;
                        this.signalWeights = json.data.signal_weights;
                    }
                } catch (error) {
                    console.error("Dashboard stats load karne mein error aagaya:", error);
                }
            },

            // Call /api/risk/entities (Live feed)
            async fetchLiveFeed() {
                this.isLoading = true;
                try {
                    let url = new URL(window.location.origin + '/api/risk/entities');
                    if (this.tierFilter) url.searchParams.append('tier', this.tierFilter);
                    if (this.searchQuery) url.searchParams.append('search', this.searchQuery);

                    let response = await fetch(url);
                    let json = await response.json();
                    
                    // Kyun ke tumne Laravel ka paginate() function use kiya hai API mein:
                    // Data usually json.data.data mein array ke format mein return hota hai
                    if(json.data && Array.isArray(json.data.data)) {
                        this.liveFeed = json.data.data;
                    } else if (Array.isArray(json.data)) {
                        this.liveFeed = json.data;
                    }
                } catch (error) {
                    console.error("Live feed fetch nahi ho saki:", error);
                } finally {
                    this.isLoading = false;
                }
            }
        }));
    });
</script>

@endsection