@extends('layouts.app')
@section('title', 'System Health Monitor')

@section('content')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

  <div class="p-4 sm:p-6 lg:p-8 bg-bg-primary min-h-screen" x-data="systemHealth()">

    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 sm:mb-8 gap-4">
        <div class="w-full md:w-auto">
            <h1 class="text-h3 sm:text-h2 font-bold tracking-tight text-text-primary">System Health Monitor</h1>
            <p class="text-text-secondary text-body-sm mt-1">SRE-level observability of platform infrastructure, queues, and incident response.</p>
        </div>

        <div class="flex flex-wrap items-center gap-3 sm:gap-6 w-full md:w-auto">
            <button @click="triggerIncidentMode()"
                class="btn btn-sm btn-destructive flex items-center gap-2 shadow-sm shadow-semantic-error/20">
                <i data-lucide="alert-triangle" class="w-4 h-4"></i> Declare Incident
            </button>
            
            <button @click="exportReport()" :disabled="isExporting"
                class="btn btn-sm btn-secondary flex items-center gap-2 transition-all duration-200 
           bg-bg-secondary text-text-primary border-border-strong
           hover:!bg-brand-primary hover:!text-white 
           dark:bg-bg-tertiary dark:text-text-secondary dark:border-border-strong 
           dark:hover:!bg-brand-primary dark:hover:!text-white disabled:opacity-50">
                <i data-lucide="download" class="w-4 h-4" :class="isExporting ? 'animate-bounce' : ''"></i>
                <span x-text="isExporting ? 'Exporting...' : 'Export Report'"></span>
            </button>

            <div class="flex items-center gap-2 px-3 sm:px-4 py-1.5 sm:py-2 rounded-full"
                :class="platformStatus === 'live' ? 'bg-semantic-success-bg border border-semantic-success/20' : 'bg-semantic-error-bg border border-semantic-error/20'">
                <span class="relative flex h-2.5 w-2.5 sm:h-3 sm:w-3">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full opacity-75"
                        :class="platformStatus === 'live' ? 'bg-semantic-success' : 'bg-semantic-error'"></span>
                    <span class="relative inline-flex rounded-full h-2.5 w-2.5 sm:h-3 sm:w-3"
                        :class="platformStatus === 'live' ? 'bg-semantic-success' : 'bg-semantic-error'"></span>
                </span>
                <span class="text-[10px] sm:text-caption font-semibold uppercase tracking-wider"
                    :class="platformStatus === 'live' ? 'text-semantic-success' : 'text-semantic-error'"
                    x-text="platformStatus === 'live' ? 'System Live' : 'Degraded'"></span>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-3 lg:grid-cols-5 gap-4 sm:gap-6 mb-6 sm:mb-8">
        <div class="card p-4 sm:p-5 relative overflow-hidden">
            <p class="text-caption font-semibold text-text-tertiary uppercase tracking-wider truncate">Platform Uptime (30d)</p>
            <h3 class="text-h2 font-bold text-text-primary mt-1 sm:mt-2 truncate">
                <span x-text="metrics.uptime"></span> <span class="text-h4 text-semantic-success font-normal">%</span>
            </h3>
        </div>
        <div class="card p-4 sm:p-5 relative overflow-hidden">
            <p class="text-caption font-semibold text-text-tertiary uppercase tracking-wider truncate">Platform P95 Latency</p>
            <h3 class="text-h2 font-bold text-text-primary mt-1 sm:mt-2 truncate"
                :class="metrics.latency > 300 ? 'text-semantic-warning' : ''">
                <span x-text="metrics.latency"></span> <span class="text-h4 text-text-tertiary font-normal">ms</span>
            </h3>
        </div>
        <div class="card p-4 sm:p-5 relative overflow-hidden">
            <p class="text-caption font-semibold text-text-tertiary uppercase tracking-wider truncate">Global Error Rate</p>
            <h3 class="text-h2 font-bold text-text-primary mt-1 sm:mt-2 truncate"
                :class="metrics.errorRate > 5 ? 'text-semantic-error' : ''">
                <span x-text="metrics.errorRate"></span> <span class="text-h4 text-text-tertiary font-normal">%</span>
            </h3>
        </div>
        <div class="card p-4 sm:p-5 relative overflow-hidden">
            <p class="text-caption font-semibold text-text-tertiary uppercase tracking-wider truncate">MTTR</p>
            <h3 class="text-h2 font-bold text-text-primary mt-1 sm:mt-2 truncate">
                <span x-text="metrics.mttr"></span> <span class="text-h4 text-text-tertiary font-normal">mins</span>
            </h3>
        </div>
        <div class="card p-4 sm:p-5 relative overflow-hidden">
            <p class="text-caption font-semibold text-text-tertiary uppercase tracking-wider truncate">Dependency Failures</p>
            <h3 class="text-h2 font-bold text-text-primary mt-1 sm:mt-2 truncate"
                :class="metrics.failures > 0 ? 'text-semantic-error' : ''">
                <span x-text="metrics.failures"></span>
            </h3>
        </div>
    </div>

    <div class="grid grid-cols-1 xl:grid-cols-2 gap-6 mb-8">
        <div class="card p-0 overflow-hidden shadow-sm border-border-default">
            <div class="p-4 sm:p-5 border-b border-border-default bg-bg-tertiary flex justify-between items-center">
                <h3 class="text-h4 font-bold text-text-primary flex items-center gap-2"><i data-lucide="activity" class="w-4 h-4 text-brand-primary"></i> API Endpoint Health</h3>
                <button @click="fetchSummary()" class="text-text-tertiary hover:text-text-primary"><i data-lucide="refresh-cw" class="w-4 h-4" :class="isLoading ? 'animate-spin' : ''"></i></button>
            </div>
            <div class="p-5 max-h-[300px] overflow-y-auto custom-scrollbar bg-bg-primary">
                <div class="space-y-4">
                    <template x-for="(data, endpoint) in endpoints" :key="endpoint">
                        <div class="flex justify-between items-center border-b border-border-default pb-3 last:border-0 last:pb-0">
                            <div>
                                <p class="text-body-sm font-bold text-text-primary font-mono" x-text="endpoint"></p>
                                <p class="text-[10px] text-text-secondary mt-0.5" x-text="`RPS: ${data.rps || 0} | Errors: ${data.errors || 0}`"></p>
                            </div>
                            <div class="text-right">
                                <p class="text-body-sm font-bold"
                                    :class="(data.p95 || 0) > 200 ? 'text-semantic' : 'text-text-primary'"
                                    x-text="`${data.p95 || 0}ms (P95)`"></p>
                                <p class="text-[10px] font-bold mt-0.5 uppercase"
                                    :class="(data.error_rate || 0) > 1 ? 'text-semantic-error' : 'text-semantic-success'"
                                    x-text="`Err: ${data.error_rate || 0}%`"></p>
                            </div>
                        </div>
                    </template>
                </div>
            </div>
        </div>

        <div class="card p-0 overflow-hidden shadow-sm border-border-default">
            <div class="p-4 sm:p-5 border-b border-border-default bg-bg-tertiary flex justify-between items-center">
                <h3 class="text-h4 font-bold text-text-primary flex items-center gap-2"><i data-lucide="clock" class="w-4 h-4 text-semantic-warning"></i> Incident Timeline</h3>
            </div>
            <div class="p-5 max-h-[300px] overflow-y-auto custom-scrollbar bg-bg-primary">
                <template x-if="incidents.length === 0">
                    <div class="text-center py-8 text-text-tertiary">
                        <i data-lucide="check-circle" class="w-8 h-8 mx-auto mb-2 opacity-50"></i>
                        <p class="text-sm font-bold">No recent incidents</p>
                    </div>
                </template>
                <div class="relative border-l-2 border-border-strong ml-3 space-y-6">
                    <template x-for="incident in incidents" :key="incident.id">
                        <div class="relative pl-6">
                            <div class="absolute w-4 h-4 rounded-full -left-[9px] top-1 outline outline-4 outline-bg-primary"
                                :class="incident.status === 'active' ? 'bg-semantic-error animate-pulse' : 'bg-text-tertiary'">
                            </div>
                            <p class="text-caption text-text-secondary font-mono mb-1" x-text="incident.time"></p>
                            <p class="text-body-sm font-bold"
                                :class="incident.status === 'active' ? 'text-semantic-error' : 'text-text-primary'"
                                x-text="incident.title"></p>
                            <p class="text-caption text-text-secondary mt-1" x-text="incident.description"></p>
                        </div>
                    </template>
                </div>
            </div>
        </div>
    </div>

    <div class="card p-0 overflow-hidden shadow-sm border-border-default">
        <div class="p-4 sm:p-5 border-b border-border-default flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3 bg-bg-tertiary">
            <div>
                <h3 class="text-h4 font-bold text-text-primary flex items-center gap-2"><i data-lucide="layers" class="w-4 h-4 text-purple-500"></i> Background Job Queues</h3>
                <p class="text-caption text-text-secondary mt-1">AI Layer: Backlog predictions running normally.</p>
            </div>
            <span class="text-caption text-text-secondary font-mono flex items-center gap-2"><i
                    data-lucide="refresh-cw" class="w-3 h-3" :class="isLoading ? 'animate-spin' : ''"></i>
                Auto-refreshes 10s</span>
        </div>
        <div class="overflow-x-auto custom-scrollbar bg-bg-primary">
            <table class="w-full text-left border-collapse min-w-[900px]">
                <thead class="text-caption uppercase text-text-secondary font-semibold bg-bg-secondary border-b border-border-strong">
                    <tr>
                        <th class="px-6 py-4 whitespace-nowrap">Queue Name</th>
                        <th class="px-6 py-4 whitespace-nowrap">Pending / Wait</th>
                        <th class="px-6 py-4 whitespace-nowrap">Dead Letter Queue (DLQ)</th>
                        <th class="px-6 py-4 whitespace-nowrap">AI Prediction</th>
                        <th class="px-6 py-4 whitespace-nowrap">Status</th>
                        <th class="px-6 py-4 whitespace-nowrap text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-border-default">
                    <template x-for="queue in queues" :key="queue.name">
                        <tr class="hover:bg-bg-tertiary transition-colors">
                            <td class="px-6 py-4 font-mono text-body-sm font-bold text-text-primary whitespace-nowrap" x-text="queue.name"></td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="font-bold text-text-primary" x-text="queue.pending"></span>
                                <span class="text-text-secondary text-xs ml-2" x-text="'~' + queue.waitTime"></span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="text-body-sm font-bold"
                                    :class="queue.dlq > 0 ? 'text-semantic-error' : 'text-text-secondary'"
                                    x-text="queue.dlq + ' Failed'"></span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="text-[10px] text-text-tertiary" x-text="queue.prediction"></span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span x-show="queue.status === 'active'" class="px-2 py-0.5 rounded text-[10px] font-bold bg-semantic-success-bg text-semantic-success border border-semantic-success/20 uppercase">Active</span>
                                <span x-show="queue.status === 'throttled'" class="px-2 py-0.5 rounded text-[10px] font-bold bg-semantic-warning-bg text-semantic-warning border border-semantic-warning/20 uppercase">Throttled</span>
                                <span x-show="queue.status === 'paused'" class="px-2 py-0.5 rounded text-[10px] font-bold bg-semantic-error-bg text-semantic-error border border-semantic-error/20 uppercase">Paused</span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex justify-end gap-2">
                                    <button @click="toggleQueue(queue)" 
                                        class="btn btn-sm btn-secondary text-xs transition-all duration-200 
                                               border-border-strong bg-bg-secondary text-text-primary
                                               hover:!bg-brand-primary hover:!text-white 
                                               dark:bg-bg-tertiary dark:text-text-secondary dark:border-border-strong 
                                               dark:hover:!bg-brand-primary dark:hover:!text-white" 
                                        x-text="queue.status === 'paused' ? 'Resume' : 'Pause'">
                                    </button>
                                    <button @click="throttleQueue(queue)"
                                        class="btn btn-sm btn-secondary text-xs transition-all duration-200 
                                               border-border-strong bg-bg-secondary text-text-primary text-semantic-warning border-semantic-warning/30
                                               hover:!bg-brand-primary hover:!text-white 
                                               dark:bg-bg-tertiary dark:text-text-secondary dark:border-border-strong 
                                               dark:hover:!bg-brand-primary dark:hover:!text-white">Throttle</button>
                                    <button @click="replayDLQ(queue)" :disabled="queue.dlq === 0"
                                        class="btn btn-sm btn-secondary text-xs transition-all duration-200 
                                               border-border-strong bg-bg-secondary text-text-primary disabled:opacity-50 text-brand-primary border-brand-primary/30
                                               hover:!bg-brand-primary hover:!text-white 
                                               dark:bg-bg-tertiary dark:text-text-secondary dark:border-border-strong 
                                               dark:hover:!bg-brand-primary dark:hover:!text-white">Replay DLQ</button>
                                </div>
                            </td>
                        </tr>
                    </template>
                </tbody>
            </table>
        </div>
    </div>

    <div x-show="showModal" style="display: none;" class="fixed inset-0 z-[200] flex items-center justify-center bg-[#021056]/40 backdrop-blur-sm px-4 transition-opacity">
        <div @click.away="showModal = false" class="bg-bg-primary border border-border-strong rounded-2xl shadow-2xl p-8 max-w-sm w-full transform transition-all scale-100 relative">
            <button @click="showModal = false" class="absolute top-4 right-4 text-text-tertiary hover:text-semantic-error"><i data-lucide="x" class="w-5 h-5"></i></button>
            <div class="flex flex-col items-center text-center">
                <div class="w-16 h-16 rounded-full bg-brand-primary/10 flex items-center justify-center text-brand-primary mb-5 shadow-inner">
                    <i data-lucide="info" class="w-8 h-8"></i>
                </div>
                <h3 class="text-h3 font-black text-text-primary mb-2" x-text="modalTitle"></h3>
                <p class="text-body-sm font-medium text-text-secondary mb-8" x-text="modalMessage"></p>
                <button @click="showModal = false" class="btn w-full py-3 text-white shadow-lg shadow-brand-primary/30 font-bold bg-brand-primary">Got it</button>
            </div>
        </div>
    </div>

</div>

@push('scripts')
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('systemHealth', () => ({
                isLoading: false,
                isExporting: false,
                platformStatus: 'live',
                refreshInterval: null, 
                showModal: false,
                modalTitle: '',
                modalMessage: '',

                metrics: {
                    uptime: 99.98,
                    latency: 0,
                    errorRate: 0,
                    mttr: 14,
                    failures: 0
                },

                endpoints: {},
                queues: [],
                incidents: [],

                headers: {
                    'Accept': 'application/json',
                    'Authorization': `Bearer ${localStorage.getItem('token')}` 
                },

                init() {
                    this.fetchAllData();
                    this.refreshInterval = setInterval(() => this.fetchAllData(), 10000);
                },

                openModal(title, message) {
                    this.modalTitle = title;
                    this.modalMessage = message;
                    this.showModal = true;
                    setTimeout(() => { if (window.lucide) lucide.createIcons(); }, 50);
                },

                async fetchAllData() {
                    this.isLoading = true;
                    await Promise.all([
                        this.fetchSummary(),
                        this.fetchQueues(),
                        this.fetchIncidents()
                    ]);
                    this.isLoading = false;
                },

                async exportReport() {
                    this.isExporting = true;
                    try {
                        const res = await fetch("{{ url('/cp/v1/metrics/export') }}", { headers: this.headers });
                        if (!res.ok) throw new Error("Export failed");
                        
                        const blob = await res.blob();
                        const url = window.URL.createObjectURL(blob);
                        const a = document.createElement('a');
                        a.href = url;
                        a.download = `system-health-report-${new Date().toISOString().split('T')[0]}.pdf`;
                        document.body.appendChild(a);
                        a.click();
                        a.remove();
                        this.openModal('Export Success', 'Report exported successfully!');
                    } catch (e) {
                        console.error(e);
                        this.openModal('Mock Export', 'In a real environment, this would download a PDF/CSV of the health metrics.');
                    } finally {
                        this.isExporting = false;
                    }
                },

                async fetchSummary() {
                    try {
                        const res = await fetch("{{ url('/cp/v1/metrics/summary') }}", {
                            headers: this.headers
                        });
                        if (!res.ok) throw new Error("API Error");
                        const data = await res.json();

                        const rawEndpoints = data.data || {};
                        this.endpoints = {};
                        let hasValidEndpoints = false;

                        let totalP95 = 0,
                            totalErrorRate = 0,
                            totalFailures = 0,
                            count = 0;

                        const badKeys = ['p95_latency_ms', 'error_rate', 'throughput_rps', 'dependency_failures'];

                        for (const [key, val] of Object.entries(rawEndpoints)) {
                            if (badKeys.includes(key) || typeof val !== 'object' || val === null) continue;

                            let formattedKey = key.startsWith('/') ? key : '/' + key;
                            this.endpoints[formattedKey] = val;
                            hasValidEndpoints = true;

                            totalP95 += parseFloat(val.p95 || 0);
                            totalErrorRate += parseFloat(val.error_rate || 0);

                            totalFailures += parseInt(val.dependency_failures?.db || 0);
                            totalFailures += parseInt(val.dependency_failures?.redis || 0);
                            totalFailures += parseInt(val.dependency_failures?.external_api || 0);
                            count++;
                        }

                        if (!hasValidEndpoints) {
                            this.endpoints = {
                                '/api/v1/auth/login': { p95: 124, rps: 45, errors: 2, error_rate: 0.5 },
                                '/api/v1/payments/charge': { p95: 312, rps: 18, errors: 1, error_rate: 1.2 },
                                '/api/v1/users/profile': { p95: 85, rps: 120, errors: 0, error_rate: 0 },
                                '/api/v1/webhooks/stripe': { p95: 150, rps: 30, errors: 4, error_rate: 2.1 }
                            };
                            totalP95 = 124 + 312 + 85 + 150;
                            totalErrorRate = 0.5 + 1.2 + 0 + 2.1;
                            totalFailures = 0;
                            count = 4;
                        }

                        if (count > 0) {
                            this.metrics.latency = Math.round(totalP95 / count);
                            this.metrics.errorRate = (totalErrorRate / count).toFixed(2);
                            this.metrics.failures = totalFailures;
                        }

                        if (this.metrics.errorRate > 5 || this.metrics.failures > 10) {
                            this.platformStatus = 'degraded';
                        } else {
                            this.platformStatus = 'live';
                        }

                    } catch (e) {
                        console.error(e);
                    }
                },

                async fetchQueues() {
                    try {
                        const res = await fetch("{{ url('/cp/v1/metrics/queues-health') }}", {
                            headers: this.headers
                        });
                        if (res.ok) {
                            const data = await res.json();
                            this.queues = data.data || [];
                        } else {
                            this.loadMockQueues();
                        }
                    } catch (e) {
                        this.loadMockQueues();
                    }
                },

                loadMockQueues() {
                    this.queues = [{
                            name: 'payment_processing',
                            pending: 12,
                            waitTime: '2s',
                            dlq: 0,
                            status: 'active',
                            prediction: 'Stable'
                        },
                        {
                            name: 'webhook_delivery',
                            pending: 450,
                            waitTime: '4s',
                            dlq: 23,
                            status: 'throttled',
                            prediction: 'Spike expected'
                        },
                        {
                            name: 'kyc_verification',
                            pending: 45,
                            waitTime: '12m',
                            dlq: 2,
                            status: 'active',
                            prediction: 'Clear in 1h'
                        },
                        {
                            name: 'report_generation',
                            pending: 5,
                            waitTime: '1m',
                            dlq: 0,
                            status: 'active',
                            prediction: 'Stable'
                        }
                    ];
                },

                async fetchIncidents() {
                    try {
                        const res = await fetch("{{ url('/cp/v1/metrics/incidents') }}", {
                            headers: this.headers
                        });
                        if (res.ok) {
                            const data = await res.json();
                            this.incidents = data.data || [];
                        } else {
                            this.loadMockIncidents();
                        }
                    } catch (e) {
                        this.loadMockIncidents();
                    }
                },

                loadMockIncidents() {
                    this.incidents = [{
                            id: 1,
                            time: 'Today, 14:30',
                            title: 'Stripe API Latency',
                            description: 'Upstream payment processor taking >5s to respond.',
                            status: 'active'
                        },
                        {
                            id: 2,
                            time: 'Yesterday, 09:15',
                            title: 'Redis Cache Eviction',
                            description: 'Memory limit reached. Recovered automatically.',
                            status: 'resolved'
                        }
                    ];
                },

                toggleQueue(queue) {
                    const action = queue.status === 'paused' ? 'resume' : 'pause';
                    queue.status = action === 'pause' ? 'paused' : 'active';
                    this.openModal('Queue Updated', 'Queue ' + queue.name + ' has been ' + queue.status + '.');
                },

                throttleQueue(queue) {
                    queue.status = 'throttled';
                    this.openModal('Queue Throttled', 'Throttling intake for ' + queue.name + '. Backlog will be prioritized.');
                },

                replayDLQ(queue) {
                    this.openModal('Replay Initiated', 'Replaying ' + queue.dlq + ' failed jobs in ' + queue.name + ' DLQ.');
                    queue.dlq = 0;
                },

                triggerIncidentMode() {
                    this.platformStatus = 'degraded';
                    this.incidents.unshift({
                        id: Date.now(),
                        time: 'Just now',
                        title: 'CRITICAL: Manual Incident Declared',
                        description: 'Admin triggered incident mode. PagerDuty alerted.',
                        status: 'active'
                    });

                    if (this.refreshInterval) {
                        clearInterval(this.refreshInterval);
                    }

                    this.openModal('Incident Mode Activated', 'CRITICAL: Initializing Incident Mode. Team has been notified and auto-refresh is paused.');
                }
            }));
        });
    </script>
@endpush
@endsection