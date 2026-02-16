@extends('layouts.app')

@section('content')

{{-- Load Chart.js from CDN --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<div class="min-h-screen theme-bg-body theme-text-main p-6 font-sans">
    
    {{-- HEADER --}}
    <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
        <div>
            <h1 class="text-2xl font-bold tracking-tight theme-text-main">System Health Monitor</h1>
            <p class="theme-text-muted text-sm mt-1">Real-time observability and queue management</p>
        </div>

        <div class="flex items-center gap-6">
            <div id="system-status-indicator" class="flex items-center gap-2 px-4 py-2 bg-green-500/10 border border-green-500/20 rounded-full transition-colors">
                <span class="relative flex h-3 w-3">
                  <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                  <span class="relative inline-flex rounded-full h-3 w-3 bg-green-500"></span>
                </span>
                <span class="text-sm font-semibold text-green-400">System Live</span>
            </div>
            
            <div class="text-xs theme-text-muted">
                Last updated: <span id="last-updated-time">--:--:--</span>
            </div>
        </div>
    </div>

    {{-- METRICS GRID --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="theme-bg-card rounded-xl p-5 theme-border border shadow-lg relative overflow-hidden">
            <p class="text-sm font-medium theme-text-muted uppercase tracking-wider">P95 Latency</p>
            <h3 class="text-3xl font-bold theme-text-main mt-2">
                <span id="metric-latency">--</span> <span class="text-lg theme-text-muted font-normal">ms</span>
            </h3>
        </div>
        
        <div class="theme-bg-card rounded-xl p-5 theme-border border shadow-lg relative overflow-hidden">
            <p class="text-sm font-medium theme-text-muted uppercase tracking-wider">Error Rate</p>
            <h3 class="text-3xl font-bold theme-text-main mt-2">
                <span id="metric-error">--</span> <span class="text-lg theme-text-muted font-normal">%</span>
            </h3>
        </div>

        <div class="theme-bg-card rounded-xl p-5 theme-border border shadow-lg relative overflow-hidden">
            <p class="text-sm font-medium theme-text-muted uppercase tracking-wider">Throughput</p>
            <h3 class="text-3xl font-bold theme-text-main mt-2">
                <span id="metric-throughput">--</span> <span class="text-lg theme-text-muted font-normal">RPS</span>
            </h3>
        </div>

        <div class="theme-bg-card rounded-xl p-5 theme-border border shadow-lg relative overflow-hidden">
            <p class="text-sm font-medium theme-text-muted uppercase tracking-wider">Dependency Failures</p>
            <h3 class="text-3xl font-bold theme-text-main mt-2">
                <span id="metric-failures">--</span> <span class="text-lg theme-text-muted font-normal">Events</span>
            </h3>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
        {{-- LATENCY CHART --}}
        <div class="lg:col-span-2 theme-bg-card rounded-xl theme-border border p-6 shadow-lg">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-lg font-semibold theme-text-main">Response Latency (P95)</h3>
            </div>
            <div class="relative h-64 w-full">
                <canvas id="latencyChart"></canvas>
            </div>
        </div>

        {{-- DEPENDENCIES & INCIDENTS --}}
        <div class="flex flex-col gap-6">
            <div class="theme-bg-card rounded-xl theme-border border p-6 shadow-lg flex-1">
                <h3 class="text-lg font-semibold theme-text-main mb-4">Service Dependencies</h3>
                <div id="dependencies-list" class="space-y-3">
                    {{-- Content injected via JS --}}
                    <div class="theme-text-muted text-sm animate-pulse">Loading dependencies...</div>
                </div>
            </div>

            <div class="theme-bg-card rounded-xl theme-border border p-6 shadow-lg flex-1">
                <h3 class="text-lg font-semibold theme-text-main mb-4">Incident Timeline</h3>
                <div id="incidents-list" class="space-y-4">
                     {{-- Content injected via JS --}}
                     <div class="theme-text-muted text-sm">No recent incidents.</div>
                </div>
            </div>
        </div>
    </div>

    {{-- QUEUE MANAGEMENT --}}
    <div class="theme-bg-card rounded-xl theme-border border overflow-hidden shadow-lg">
        <div class="p-6 border-b theme-border flex justify-between items-center">
            <h3 class="text-lg font-semibold theme-text-main">Queue Health & Control</h3>
            <button onclick="fetchDashboardData()" class="text-xs bg-gray-700 hover:bg-gray-600 text-white px-3 py-1 rounded transition">
                Force Refresh
            </button>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="text-xs uppercase theme-text-muted font-semibold" style="background-color: rgba(var(--bg-body), 0.5);">
                    <tr>
                        <th class="px-6 py-4">Queue Name</th>
                        <th class="px-6 py-4">Pending</th>
                        <th class="px-6 py-4">Wait Time</th>
                        <th class="px-6 py-4">Failure Rate</th>
                        <th class="px-6 py-4">Status</th>
                    </tr>
                </thead>
                <tbody id="queue-table-body" class="divide-y" style="border-color: rgb(var(--border-color));">
                     {{-- Content injected via JS --}}
                </tbody>
            </table>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Configuration
    const API_BASE = "{{ url('/api') }}"; 
    let latencyChartInstance = null;

    document.addEventListener('DOMContentLoaded', function() {
        initChart();
        fetchDashboardData();
        
        // Auto-refresh every 5 seconds
        setInterval(fetchDashboardData, 5000);
    });

    /**
     * Initialize Chart.js Instance
     */
    function initChart() {
        const ctx = document.getElementById('latencyChart').getContext('2d');
        const gradient = ctx.createLinearGradient(0, 0, 0, 400);
        
        // Using semi-transparent brand color for chart
        gradient.addColorStop(0, 'rgba(59, 130, 246, 0.5)'); 
        gradient.addColorStop(1, 'rgba(59, 130, 246, 0.0)');

        latencyChartInstance = new Chart(ctx, {
            type: 'line',
            data: {
                labels: [],
                datasets: [{
                    label: 'Latency (ms)',
                    data: [],
                    borderColor: '#3B82F6', // Brand Primary Hex
                    backgroundColor: gradient,
                    borderWidth: 2,
                    tension: 0.4,
                    fill: true,
                    pointRadius: 0,
                    pointHoverRadius: 6
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: {
                    x: { grid: { color: 'rgba(148, 163, 184, 0.1)' }, ticks: { color: '#94a3b8' } },
                    y: { grid: { color: 'rgba(148, 163, 184, 0.1)' }, ticks: { color: '#94a3b8' } }
                },
                interaction: { mode: 'nearest', axis: 'x', intersect: false }
            }
        });
    }

    /**
     * Main Data Fetching Logic
     */
    async function fetchDashboardData() {
        try {
            // Using Promise.all to fetch distinct endpoints in parallel for speed
            const [summaryRes, chartRes, depsRes, queuesRes] = await Promise.all([
                fetch(`${API_BASE}/metrics/summary`),
                fetch(`${API_BASE}/metrics/latency/timeseries?minutes=60`),
                fetch(`${API_BASE}/metrics/dependencies`),
                fetch(`${API_BASE}/queues/health`),
                // fetch(`${API_BASE}/incidents`) // Uncomment when incidents API is ready
            ]);

            if(summaryRes.ok) updateSummaryCards(await summaryRes.json());
            if(chartRes.ok) updateChart(await chartRes.json());
            if(depsRes.ok) updateDependencies(await depsRes.json());
            if(queuesRes.ok) updateQueues(await queuesRes.json());

            // Update timestamp
            const now = new Date();
            document.getElementById('last-updated-time').innerText = now.toLocaleTimeString();

        } catch (error) {
            console.error("Dashboard Sync Failed:", error);
        }
    }

    // 1. Update Top Metrics Cards
    function updateSummaryCards(data) {
        document.getElementById('metric-latency').innerText = data.p95_latency_ms ?? 0;
        document.getElementById('metric-error').innerText = data.error_rate ?? 0;
        document.getElementById('metric-throughput').innerText = data.throughput_rps ?? 0;
        document.getElementById('metric-failures').innerText = data.dependency_failures ?? 0;
    }

    // 2. Update Chart.js
    function updateChart(data) {
        if (!data || !data.data) return;

        const labels = data.data.map(point => point.time);
        const values = data.data.map(point => point.value);

        latencyChartInstance.data.labels = labels;
        latencyChartInstance.data.datasets[0].data = values;
        latencyChartInstance.update('none');
    }

    // 3. Update Dependencies List
    function updateDependencies(services) {
        const container = document.getElementById('dependencies-list');
        container.innerHTML = ''; // Clear current

        const nameMap = {
            'mysql': 'Primary Database (MySQL)',
            'redis': 'Cache Store (Redis)',
            'search': 'Search Engine (MeiliSearch)',
            'storage': 'Object Storage (S3)'
        };

        Object.entries(services).forEach(([key, metrics]) => {
            const displayName = nameMap[key] || key.toUpperCase();
            const statusColor = metrics.status === 'healthy' ? 'bg-green-500' : 'bg-red-500';
            
            // Updated HTML to use theme styles (bg-white/5 for items)
            const html = `
                <div class="flex items-center justify-between p-2.5 rounded-lg border hover:bg-white/5 transition-colors" style="background-color: rgba(255,255,255,0.02); border-color: rgb(var(--border-color));">
                    <div class="flex items-center gap-3">
                        <span class="h-2.5 w-2.5 rounded-full ${statusColor}"></span>
                        <div>
                            <p class="text-sm font-medium theme-text-main">${displayName}</p>
                            <p class="text-xs theme-text-muted">Latency: ${metrics.latency_ms}ms | Err: ${metrics.error_rate}%</p>
                        </div>
                    </div>
                </div>
            `;
            container.insertAdjacentHTML('beforeend', html);
        });
    }

    // 4. Update Queue Table
    function updateQueues(queues) {
        const tbody = document.getElementById('queue-table-body');
        tbody.innerHTML = '';

        queues.forEach(q => {
            const displayName = q.queue.split('_')
                .map(word => word.charAt(0).toUpperCase() + word.slice(1))
                .join(' ');

            const statusBadge = q.status === 'active' 
                ? `<span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-green-500/10 text-green-400 border border-green-500/20">Active</span>`
                : `<span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-yellow-500/10 text-yellow-400 border border-yellow-500/20">Paused</span>`;

            const failureClass = q.failure_rate > 1.0 ? 'text-red-400 font-bold' : 'text-green-400';

            // Updated row styling for theme compatibility
            const row = `
                <tr class="hover:bg-white/5 transition-colors" style="border-color: rgb(var(--border-color));">
                    <td class="px-6 py-4 font-mono text-blue-400">${displayName}</td>
                    <td class="px-6 py-4 font-semibold theme-text-main">${q.pending}</td>
                    <td class="px-6 py-4 theme-text-muted">${q.wait_time}</td>
                    <td class="px-6 py-4 ${failureClass}">${q.failure_rate}%</td>
                    <td class="px-6 py-4">${statusBadge}</td>
                </tr>
            `;
            tbody.insertAdjacentHTML('beforeend', row);
        });
    }
</script> 
@endpush
@endsection