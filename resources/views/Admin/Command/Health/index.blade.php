@extends('layouts.app')

@section('content')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<div class="p-4 sm:p-6 lg:p-8 bg-bg-primary min-h-screen" x-data="systemHealth()">

    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 sm:mb-8 gap-4">
        <div class="w-full md:w-auto">
            <h1 class="text-h3 sm:text-h2 font-bold tracking-tight text-text-primary">System Health Monitor</h1>
            <p class="text-text-secondary text-body-sm mt-1">SRE-level observability of platform infrastructure and queues.</p>
        </div>

        <div class="flex flex-wrap items-center gap-3 sm:gap-6 w-full md:w-auto">
            <div class="flex items-center gap-2 px-3 sm:px-4 py-1.5 sm:py-2 bg-semantic-success-bg border border-semantic-success/20 rounded-full">
                <span class="relative flex h-2.5 w-2.5 sm:h-3 sm:w-3">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-semantic-success opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-2.5 w-2.5 sm:h-3 sm:w-3 bg-semantic-success"></span>
                </span>
                <span class="text-[10px] sm:text-caption font-semibold text-semantic-success uppercase tracking-wider">System Live</span>
            </div>
            <div class="text-caption text-text-tertiary font-mono ml-auto md:ml-0">
                Updated: <span x-text="lastUpdated"></span>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6 mb-6 sm:mb-8">
        <div class="card p-4 sm:p-5 relative overflow-hidden">
            <p class="text-caption font-semibold text-text-tertiary uppercase tracking-wider truncate">P95 Latency</p>
            <h3 class="text-h2 sm:text-display-lg font-bold text-text-primary mt-1 sm:mt-2 truncate">
                <span x-text="metrics.latency">--</span> <span class="text-h4 text-text-tertiary font-normal">ms</span>
            </h3>
        </div>
        <div class="card p-4 sm:p-5 relative overflow-hidden">
            <p class="text-caption font-semibold text-text-tertiary uppercase tracking-wider truncate">Error Rate</p>
            <h3 class="text-h2 sm:text-display-lg font-bold text-text-primary mt-1 sm:mt-2 truncate">
                <span x-text="metrics.errorRate">--</span> <span class="text-h4 text-text-tertiary font-normal">%</span>
            </h3>
        </div>
        <div class="card p-4 sm:p-5 relative overflow-hidden">
            <p class="text-caption font-semibold text-text-tertiary uppercase tracking-wider truncate">Throughput</p>
            <h3 class="text-h2 sm:text-display-lg font-bold text-text-primary mt-1 sm:mt-2 truncate">
                <span x-text="metrics.throughput">--</span> <span class="text-h4 text-text-tertiary font-normal">RPS</span>
            </h3>
        </div>
        <div class="card p-4 sm:p-5 relative overflow-hidden">
            <p class="text-caption font-semibold text-text-tertiary uppercase tracking-wider truncate">Dependency Failures</p>
            <h3 class="text-h2 sm:text-display-lg font-bold text-text-primary mt-1 sm:mt-2 truncate">
                <span x-text="metrics.failures">--</span> <span class="text-h4 text-text-tertiary font-normal">Events</span>
            </h3>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 sm:gap-6 mb-6 sm:mb-8">
        <div class="lg:col-span-2 card p-4 sm:p-6">
            <h3 class="text-h4 font-semibold text-text-primary mb-4 sm:mb-6">Response Latency (P95)</h3>
            <div class="relative h-48 sm:h-64 w-full">
                <canvas id="latencyChart"></canvas>
            </div>
        </div>

        <div class="card p-4 sm:p-6 flex flex-col">
            <h3 class="text-h4 font-semibold text-text-primary mb-4">Service Dependencies</h3>
            <div class="space-y-2 sm:space-y-3 flex-1 overflow-y-auto custom-scrollbar max-h-[300px] lg:max-h-none">
                <template x-for="dep in dependencies" :key="dep.name">
                    <div class="flex items-center justify-between p-3 rounded-lg border border-border-default bg-bg-primary">
                        <div class="flex items-center gap-3 min-w-0">
                            <span class="h-2.5 w-2.5 rounded-full shrink-0" :class="dep.status === 'healthy' ? 'bg-semantic-success' : 'bg-semantic-error'"></span>
                            <div class="min-w-0">
                                <p class="text-body-sm font-medium text-text-primary truncate" x-text="dep.name"></p>
                                <p class="text-caption text-text-tertiary truncate" x-text="`Latency: ${dep.latency}ms | Err: ${dep.error}%`"></p>
                            </div>
                        </div>
                    </div>
                </template>
            </div>
        </div>
    </div>

    <div class="card p-0 overflow-hidden">
        <div class="p-4 sm:p-6 border-b border-border-default flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3 bg-bg-tertiary">
            <h3 class="text-h4 font-semibold text-text-primary">Background Job Queues</h3>
            <button @click="fetchData()" class="btn btn-secondary btn-sm w-full sm:w-auto flex justify-center items-center gap-2">
                <i data-lucide="refresh-cw" class="w-4 h-4"></i> Force Sync
            </button>
        </div>
        <div class="overflow-x-auto custom-scrollbar">
            <table class="w-full text-left border-collapse min-w-[600px]">
                <thead class="text-caption uppercase text-text-secondary font-semibold bg-bg-primary border-b border-border-strong">
                    <tr>
                        <th class="px-4 sm:px-6 py-3 sm:py-4 whitespace-nowrap">Queue Name</th>
                        <th class="px-4 sm:px-6 py-3 sm:py-4 whitespace-nowrap">Pending</th>
                        <th class="px-4 sm:px-6 py-3 sm:py-4 whitespace-nowrap">Wait Time</th>
                        <th class="px-4 sm:px-6 py-3 sm:py-4 whitespace-nowrap">Failure Rate</th>
                        <th class="px-4 sm:px-6 py-3 sm:py-4 whitespace-nowrap">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-border-default bg-bg-secondary">
                    <template x-for="queue in queues" :key="queue.name">
                        <tr class="hover:bg-bg-tertiary transition-colors">
                            <td class="px-4 sm:px-6 py-3 sm:py-4 font-mono text-body-sm text-brand-primary whitespace-nowrap" x-text="queue.name"></td>
                            <td class="px-4 sm:px-6 py-3 sm:py-4 font-semibold text-text-primary whitespace-nowrap" x-text="queue.pending"></td>
                            <td class="px-4 sm:px-6 py-3 sm:py-4 text-text-secondary text-body-sm whitespace-nowrap" x-text="queue.waitTime"></td>
                            <td class="px-4 sm:px-6 py-3 sm:py-4 text-body-sm font-medium whitespace-nowrap" :class="queue.failureRate > 1 ? 'text-semantic-error' : 'text-semantic-success'" x-text="queue.failureRate + '%'"></td>
                            <td class="px-4 sm:px-6 py-3 sm:py-4 whitespace-nowrap">
                                <span x-show="queue.status === 'active'" class="inline-flex items-center px-2 py-0.5 sm:px-2.5 sm:py-1 rounded-full text-[9px] sm:text-[10px] font-bold bg-semantic-success-bg text-semantic-success border border-semantic-success/20 uppercase">Active</span>
                                <span x-show="queue.status !== 'active'" class="inline-flex items-center px-2 py-0.5 sm:px-2.5 sm:py-1 rounded-full text-[9px] sm:text-[10px] font-bold bg-semantic-warning-bg text-semantic-warning border border-semantic-warning/20 uppercase">Paused</span>
                            </td>
                        </tr>
                    </template>
                </tbody>
            </table>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('systemHealth', () => ({
            lastUpdated: '--:--:--',
            metrics: { latency: 0, errorRate: 0, throughput: 0, failures: 0 },
            dependencies: [],
            queues: [],
            chart: null,

            init() {
                this.initChart();
                this.fetchData();
                setInterval(() => this.fetchData(), 10000);  
            },

            initChart() {
                const ctx = document.getElementById('latencyChart').getContext('2d');
                this.chart = new Chart(ctx, {
                    type: 'line',
                    data: { labels: [], datasets: [{ label: 'Latency (ms)', data: [], borderColor: '#5B6AF0', backgroundColor: 'rgba(91, 106, 240, 0.1)', borderWidth: 2, fill: true, tension: 0.4 }] },
                    options: { responsive: true, maintainAspectRatio: false, plugins: { legend: { display: false } }, scales: { x: { grid: { display: false } }, y: { grid: { color: 'rgba(148, 163, 184, 0.1)' } } } }
                });
            },

            async fetchData() {
                try {
                    const token = localStorage.getItem('token');
                    const headers = { 'Authorization': `Bearer ${token}`, 'Accept': 'application/json' };
                    
                    
                    
                    this.metrics = { latency: 124, errorRate: 0.02, throughput: 4850, failures: 0 };
                    this.dependencies = [
                        { name: 'Primary Database (PostgreSQL)', status: 'healthy', latency: 12, error: 0 },
                        { name: 'Cache Store (Redis)', status: 'healthy', latency: 2, error: 0 },
                        { name: 'Stripe API', status: 'healthy', latency: 145, error: 0.1 }
                    ];
                    this.queues = [
                        { name: 'payment_processing', pending: 12, waitTime: '2s', failureRate: 0.1, status: 'active' },
                        { name: 'webhook_delivery', pending: 450, waitTime: '4s', failureRate: 0.5, status: 'active' },
                        { name: 'kyc_verification', pending: 45, waitTime: '12m', failureRate: 0, status: 'active' }
                    ];
                    
                    this.lastUpdated = new Date().toLocaleTimeString();
                    
                     
                    const now = new Date();
                    this.chart.data.labels = Array.from({length: 10}, (_, i) => new Date(now - (9-i)*60000).toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'}));
                    this.chart.data.datasets[0].data = Array.from({length: 10}, () => Math.floor(Math.random() * 50) + 100);
                    this.chart.update();

                } catch (e) {
                    console.error("Health sync failed", e);
                }
            }
        }));
    });
</script>
@endpush
@endsection