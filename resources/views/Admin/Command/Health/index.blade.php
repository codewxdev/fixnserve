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
            <button @click="triggerIncidentMode()" class="btn btn-sm btn-destructive flex items-center gap-2">
                <i data-lucide="alert-triangle" class="w-4 h-4"></i> Declare Incident
            </button>
            <div class="flex items-center gap-2 px-3 sm:px-4 py-1.5 sm:py-2 bg-semantic-success-bg border border-semantic-success/20 rounded-full">
                <span class="relative flex h-2.5 w-2.5 sm:h-3 sm:w-3">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-semantic-success opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-2.5 w-2.5 sm:h-3 sm:w-3 bg-semantic-success"></span>
                </span>
                <span class="text-[10px] sm:text-caption font-semibold text-semantic-success uppercase tracking-wider">System Live</span>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-3 lg:grid-cols-5 gap-4 sm:gap-6 mb-6 sm:mb-8">
        <div class="card p-4 sm:p-5 relative overflow-hidden">
            <p class="text-caption font-semibold text-text-tertiary uppercase tracking-wider truncate">Platform Uptime (30d)</p>
            <h3 class="text-h2 font-bold text-text-primary mt-1 sm:mt-2 truncate">
                <span x-text="metrics.uptime">--</span> <span class="text-h4 text-semantic-success font-normal">%</span>
            </h3>
        </div>
        <div class="card p-4 sm:p-5 relative overflow-hidden">
            <p class="text-caption font-semibold text-text-tertiary uppercase tracking-wider truncate">P95 Latency</p>
            <h3 class="text-h2 font-bold text-text-primary mt-1 sm:mt-2 truncate">
                <span x-text="metrics.latency">--</span> <span class="text-h4 text-text-tertiary font-normal">ms</span>
            </h3>
        </div>
        <div class="card p-4 sm:p-5 relative overflow-hidden">
            <p class="text-caption font-semibold text-text-tertiary uppercase tracking-wider truncate">Error Rate</p>
            <h3 class="text-h2 font-bold text-text-primary mt-1 sm:mt-2 truncate">
                <span x-text="metrics.errorRate">--</span> <span class="text-h4 text-text-tertiary font-normal">%</span>
            </h3>
        </div>
        <div class="card p-4 sm:p-5 relative overflow-hidden">
            <p class="text-caption font-semibold text-text-tertiary uppercase tracking-wider truncate">MTTR</p>
            <h3 class="text-h2 font-bold text-text-primary mt-1 sm:mt-2 truncate">
                <span x-text="metrics.mttr">--</span> <span class="text-h4 text-text-tertiary font-normal">mins</span>
            </h3>
        </div>
        <div class="card p-4 sm:p-5 relative overflow-hidden">
            <p class="text-caption font-semibold text-text-tertiary uppercase tracking-wider truncate">Dependency Failures</p>
            <h3 class="text-h2 font-bold text-text-primary mt-1 sm:mt-2 truncate">
                <span x-text="metrics.failures">--</span>
            </h3>
        </div>
    </div>

    <div class="card p-0 overflow-hidden mt-8">
        <div class="p-4 sm:p-6 border-b border-border-default flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3 bg-bg-tertiary">
            <h3 class="text-h4 font-semibold text-text-primary">Background Job Queues</h3>
            <span class="text-caption text-text-secondary font-mono">Auto-refreshes every 10s</span>
        </div>
        <div class="overflow-x-auto custom-scrollbar">
            <table class="w-full text-left border-collapse min-w-[800px]">
                <thead class="text-caption uppercase text-text-secondary font-semibold bg-bg-primary border-b border-border-strong">
                    <tr>
                        <th class="px-4 sm:px-6 py-3 whitespace-nowrap">Queue Name</th>
                        <th class="px-4 sm:px-6 py-3 whitespace-nowrap">Pending / Wait</th>
                        <th class="px-4 sm:px-6 py-3 whitespace-nowrap">Dead Letter Queue (DLQ)</th>
                        <th class="px-4 sm:px-6 py-3 whitespace-nowrap">Status</th>
                        <th class="px-4 sm:px-6 py-3 whitespace-nowrap text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-border-default bg-bg-secondary">
                    <template x-for="queue in queues" :key="queue.name">
                        <tr class="hover:bg-bg-tertiary transition-colors">
                            <td class="px-4 sm:px-6 py-4 font-mono text-body-sm text-brand-primary whitespace-nowrap" x-text="queue.name"></td>
                            <td class="px-4 sm:px-6 py-4 whitespace-nowrap">
                                <span class="font-semibold text-text-primary" x-text="queue.pending"></span>
                                <span class="text-text-secondary text-xs ml-2" x-text="'~' + queue.waitTime"></span>
                            </td>
                            <td class="px-4 sm:px-6 py-4 whitespace-nowrap">
                                <span class="text-body-sm font-bold" :class="queue.dlq > 0 ? 'text-semantic-error' : 'text-text-secondary'" x-text="queue.dlq + ' Failed'"></span>
                            </td>
                            <td class="px-4 sm:px-6 py-4 whitespace-nowrap">
                                <span x-show="queue.status === 'active'" class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-bold bg-semantic-success-bg text-semantic-success border border-semantic-success/20 uppercase">Active</span>
                                <span x-show="queue.status === 'throttled'" class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-bold bg-semantic-warning-bg text-semantic-warning border border-semantic-warning/20 uppercase">Throttled</span>
                            </td>
                            <td class="px-4 sm:px-6 py-4 text-right">
                                <div class="flex justify-end gap-2">
                                    <button @click="throttleQueue(queue)" class="btn btn-sm btn-secondary text-xs">Throttle Intake</button>
                                    <button @click="replayDLQ(queue)" :disabled="queue.dlq === 0" class="btn btn-sm btn-primary text-xs disabled:opacity-50">Replay DLQ</button>
                                </div>
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
            metrics: { uptime: 99.99, latency: 124, errorRate: 0.02, mttr: 14, failures: 0 },
            queues: [],

            init() {
                this.fetchData();
            },

            async fetchData() {
                this.queues = [
                    { name: 'payment_processing', pending: 12, waitTime: '2s', dlq: 0, status: 'active' },
                    { name: 'webhook_delivery', pending: 450, waitTime: '4s', dlq: 23, status: 'throttled' },
                    { name: 'kyc_verification', pending: 45, waitTime: '12m', dlq: 2, status: 'active' },
                    { name: 'report_generation', pending: 5, waitTime: '1m', dlq: 0, status: 'active' }
                ];
            },

            throttleQueue(queue) {
                alert(`Throttling intake for ${queue.name}. Background workers will prioritize clearing the backlog.`);
                queue.status = 'throttled';
            },

            replayDLQ(queue) {
                alert(`Replaying ${queue.dlq} failed jobs in ${queue.name} Dead Letter Queue.`);
                queue.dlq = 0;
            },

            triggerIncidentMode() {
                alert('CRITICAL: Initializing Incident Mode. PagerDuty alerted. Audit logging heightened.');
            }
        }));
    });
</script>
@endpush
@endsection