@extends('layouts.app')

@section('content')

{{-- 
    ==========================================================================
    BACKEND MOCK DATA 
    (Matches "Sub-Module 1.2: System Health" Requirements)
    ==========================================================================
--}}
@php
    // API Health Metrics
    $metrics = [
        'latency' => ['label' => 'P95 Latency', 'value' => 124, 'unit' => 'ms', 'trend' => '+12%', 'status' => 'warning'],
        'error_rate' => ['label' => 'Error Rate', 'value' => 0.05, 'unit' => '%', 'trend' => '-0.01%', 'status' => 'healthy'],
        'throughput' => ['label' => 'Throughput', 'value' => 840, 'unit' => 'RPS', 'trend' => '+50', 'status' => 'healthy'],
        'failures' => ['label' => 'Dependency Failures', 'value' => 0, 'unit' => 'Events', 'trend' => 'Stable', 'status' => 'healthy'],
    ];

    // Queue Health (Specific names from requirements)
    $queues = [
        ['name' => 'Payment Processing', 'pending' => 45, 'wait' => '2s', 'failure_rate' => '0.01%', 'status' => 'active'],
        ['name' => 'Notification Dispatch', 'pending' => 1205, 'wait' => '45s', 'failure_rate' => '2.50%', 'status' => 'paused'],
        ['name' => 'Job Assignment', 'pending' => 0, 'wait' => '0s', 'failure_rate' => '0.00%', 'status' => 'active'],
        ['name' => 'KYC Verification', 'pending' => 12, 'wait' => '5s', 'failure_rate' => '0.10%', 'status' => 'active'],
        ['name' => 'Payout Processing', 'pending' => 8, 'wait' => '1s', 'failure_rate' => '0.00%', 'status' => 'active'],
    ];

    // Service Dependencies
    $services = [
        ['name' => 'Primary Database (MySQL)', 'status' => 'operational', 'uptime' => '99.99%'],
        ['name' => 'Cache Store (Redis)', 'status' => 'operational', 'uptime' => '100%'],
        ['name' => 'Search Engine (MeiliSearch)', 'status' => 'degraded', 'uptime' => '98.50%'],
        ['name' => 'Object Storage (S3)', 'status' => 'operational', 'uptime' => '99.99%'],
    ];

    // Incident Timeline Data
    $incidents = [
        ['time' => '10:15 AM', 'msg' => 'High latency detected on Payment Gateway', 'type' => 'warning'],
        ['time' => '09:30 AM', 'msg' => 'Redis connection timeout (Resolved)', 'type' => 'resolved'],
        ['time' => '08:00 AM', 'msg' => 'Daily backup completed successfully', 'type' => 'info'],
    ];
@endphp

{{-- Load Chart.js from CDN --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<div class="min-h-screen bg-gray-900 text-gray-100 p-6 font-sans">
    
    {{-- 
        ==========================================================================
        HEADER SECTION
        ==========================================================================
    --}}
    <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-white">System Health Monitor</h1>
            <p class="text-gray-400 text-sm mt-1">Real-time observability and queue management</p>
        </div>

        <div class="flex items-center gap-6">
            <div class="flex items-center gap-2 px-4 py-2 bg-green-500/10 border border-green-500/20 rounded-full">
                <span class="relative flex h-3 w-3">
                  <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                  <span class="relative inline-flex rounded-full h-3 w-3 bg-green-500"></span>
                </span>
                <span class="text-sm font-semibold text-green-400">System Healthy</span>
            </div>

            <div class="flex items-center gap-3 bg-gray-800 px-4 py-2 rounded-lg border border-gray-700">
                <span class="text-sm text-gray-300 font-medium">Incident Mode</span>
                <label class="relative inline-flex items-center cursor-pointer">
                    <input type="checkbox" value="" class="sr-only peer">
                    <div class="w-11 h-6 bg-gray-700 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-red-600"></div>
                </label>
            </div>
        </div>
    </div>

    {{-- 
        ==========================================================================
        AI INSIGHTS LAYER (Requirement: Backlog prediction & Auto-throttling)
        ==========================================================================
    --}}
    <div class="mb-8 bg-gradient-to-r from-purple-900/40 to-gray-800 border border-purple-500/30 rounded-xl p-4 flex flex-col md:flex-row items-center justify-between gap-4">
        <div class="flex items-center gap-3">
            <div class="p-2 bg-purple-500/20 rounded-lg text-purple-400">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
            </div>
            <div>
                <h4 class="text-sm font-bold text-white flex items-center gap-2">
                    AI Insight: High Load Predicted
                    <span class="text-[10px] bg-purple-600 text-white px-1.5 rounded">BETA</span>
                </h4>
                <p class="text-xs text-gray-300 mt-1">Based on historical patterns, <strong>Notification Dispatch</strong> backlog will peak in 15 mins. Suggested action: <strong>Throttle Intake</strong>.</p>
            </div>
        </div>
        <div class="flex gap-2">
            <button class="text-xs border border-gray-600 hover:bg-gray-700 text-gray-300 px-4 py-2 rounded-lg transition">Dismiss</button>
            <button class="text-xs bg-purple-600 hover:bg-purple-500 text-white px-4 py-2 rounded-lg transition shadow-lg shadow-purple-900/50">
                Apply Auto-Throttle
            </button>
        </div>
    </div>

    {{-- 
        ==========================================================================
        METRICS GRID (Requirement: P95, Error Rate, Throughput)
        ==========================================================================
    --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        @foreach($metrics as $key => $metric)
        <div class="bg-gray-800 rounded-xl p-5 border border-gray-700 shadow-lg relative overflow-hidden group hover:border-gray-600 transition-colors">
            <div class="absolute top-0 right-0 -mt-4 -mr-4 w-24 h-24 bg-blue-500/10 rounded-full blur-2xl group-hover:bg-blue-500/20 transition-all"></div>
            
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-sm font-medium text-gray-400 uppercase tracking-wider">{{ $metric['label'] }}</p>
                    <h3 class="text-3xl font-bold text-white mt-2">
                        <span id="metric-{{ $key }}">{{ $metric['value'] }}</span>
                        <span class="text-lg text-gray-500 font-normal">{{ $metric['unit'] }}</span>
                    </h3>
                </div>
                <div class="p-2 bg-gray-700/50 rounded-lg text-gray-300">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                </div>
            </div>
            <div class="mt-4 flex items-center justify-between">
                <div class="flex items-center text-xs">
                    <span class="{{ str_contains($metric['trend'], '-') ? 'text-green-400' : 'text-red-400' }}">
                        {{ $metric['trend'] }}
                    </span>
                    <span class="text-gray-500 ml-2">vs last hour</span>
                </div>
                @if($key == 'failures')
                    <button class="text-[10px] text-gray-400 hover:text-white underline">Mute Alerts</button>
                @endif
            </div>
        </div>
        @endforeach
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
        {{-- 
            ==========================================================================
            LATENCY CHART
            ==========================================================================
        --}}
        <div class="lg:col-span-2 bg-gray-800 rounded-xl border border-gray-700 p-6 shadow-lg">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-lg font-semibold text-white">Response Latency (P95)</h3>
                <select class="bg-gray-900 border border-gray-700 text-gray-300 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-1.5">
                    <option>Last Hour</option>
                    <option>Last 24 Hours</option>
                    <option>Last 7 Days</option>
                </select>
            </div>
            <div class="relative h-64 w-full">
                <canvas id="latencyChart"></canvas>
            </div>
        </div>

        {{-- 
            ==========================================================================
            INCIDENT TIMELINE & DEPENDENCIES
            ==========================================================================
        --}}
        <div class="flex flex-col gap-6">
            <div class="bg-gray-800 rounded-xl border border-gray-700 p-6 shadow-lg flex-1">
                <h3 class="text-lg font-semibold text-white mb-4">Service Dependencies</h3>
                <div class="space-y-3">
                    @foreach($services as $service)
                    <div class="flex items-center justify-between p-2.5 rounded-lg bg-gray-700/30 border border-gray-700/50 hover:bg-gray-700/50 transition cursor-pointer group">
                        <div class="flex items-center gap-3">
                            <span class="h-2.5 w-2.5 rounded-full {{ $service['status'] === 'operational' ? 'bg-green-500' : 'bg-yellow-500' }}"></span>
                            <div>
                                <p class="text-sm font-medium text-gray-200">{{ $service['name'] }}</p>
                                <p class="text-xs text-gray-500">Uptime: {{ $service['uptime'] }}</p>
                            </div>
                        </div>
                        <span class="opacity-0 group-hover:opacity-100 text-xs text-blue-400">Drill down &rarr;</span>
                    </div>
                    @endforeach
                </div>
            </div>

            <div class="bg-gray-800 rounded-xl border border-gray-700 p-6 shadow-lg flex-1">
                <h3 class="text-lg font-semibold text-white mb-4">Incident Timeline</h3>
                <div class="space-y-4">
                    @foreach($incidents as $incident)
                    <div class="flex gap-3">
                        <div class="flex flex-col items-center">
                            <div class="h-2 w-2 rounded-full {{ $incident['type'] === 'warning' ? 'bg-red-500' : ($incident['type'] === 'resolved' ? 'bg-green-500' : 'bg-blue-500') }}"></div>
                            <div class="w-px h-full bg-gray-700 my-1"></div>
                        </div>
                        <div class="pb-2">
                            <p class="text-xs text-gray-400 font-mono">{{ $incident['time'] }}</p>
                            <p class="text-sm text-gray-300">{{ $incident['msg'] }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    {{-- 
        ==========================================================================
        QUEUE MANAGEMENT (Requirement: Queue Health, Throttle, Failure Rate)
        ==========================================================================
    --}}
    <div class="bg-gray-800 rounded-xl border border-gray-700 overflow-hidden shadow-lg">
        <div class="p-6 border-b border-gray-700 flex justify-between items-center">
            <h3 class="text-lg font-semibold text-white">Queue Health & Control</h3>
            <button class="text-xs bg-gray-700 hover:bg-gray-600 text-white px-3 py-1 rounded transition">
                Refresh Queues
            </button>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-gray-900/50 text-xs uppercase text-gray-400 font-semibold">
                    <tr>
                        <th class="px-6 py-4">Queue Name</th>
                        <th class="px-6 py-4">Pending</th>
                        <th class="px-6 py-4">Wait Time</th>
                        <th class="px-6 py-4">Failure Rate</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-700">
                    @foreach($queues as $queue)
                    <tr class="hover:bg-gray-700/50 transition-colors">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-2">
                                <span class="font-mono text-blue-400">{{ $queue['name'] }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="font-semibold text-white">{{ number_format($queue['pending']) }}</span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="text-gray-300">{{ $queue['wait'] }}</span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="{{ floatval($queue['failure_rate']) > 1 ? 'text-red-400 font-bold' : 'text-green-400' }}">
                                {{ $queue['failure_rate'] }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            @if($queue['status'] === 'active')
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-green-500/10 text-green-400 border border-green-500/20">
                                    <svg class="w-2.5 h-2.5" fill="currentColor" viewBox="0 0 8 8"><circle cx="4" cy="4" r="3" /></svg>
                                    Active
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-yellow-500/10 text-yellow-400 border border-yellow-500/20">
                                    <svg class="w-2.5 h-2.5" fill="currentColor" viewBox="0 0 8 8"><rect x="2" y="2" width="4" height="4" /></svg>
                                    Paused
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-right space-x-2">
                            {{-- Throttle Action (New) --}}
                            <button onclick="toggleQueue('{{ $queue['name'] }}', 'throttle')" class="text-xs bg-blue-500/10 hover:bg-blue-500/20 text-blue-400 border border-blue-500/50 px-3 py-1.5 rounded transition" title="Limit intake">
                                Throttle
                            </button>

                            @if($queue['status'] === 'active')
                                <button onclick="toggleQueue('{{ $queue['name'] }}', 'pause')" class="text-xs bg-yellow-500/10 hover:bg-yellow-500/20 text-yellow-500 border border-yellow-500/50 px-3 py-1.5 rounded transition">
                                    Pause
                                </button>
                            @else
                                <button onclick="toggleQueue('{{ $queue['name'] }}', 'resume')" class="text-xs bg-green-500/10 hover:bg-green-500/20 text-green-500 border border-green-500/50 px-3 py-1.5 rounded transition">
                                    Resume
                                </button>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- 
    ==========================================================================
    INTERACTIVITY & POLLING (VANILLA JS)
    ==========================================================================
--}}
 @push('scripts')
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        
        // 1. Initialize Chart.js
        const ctx = document.getElementById('latencyChart').getContext('2d');
        
        const gradient = ctx.createLinearGradient(0, 0, 0, 400);
        gradient.addColorStop(0, 'rgba(59, 130, 246, 0.5)'); // Blue
        gradient.addColorStop(1, 'rgba(59, 130, 246, 0.0)');

        const latencyChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['10:00', '10:05', '10:10', '10:15', '10:20', '10:25', '10:30', '10:35', '10:40', '10:45'],
                datasets: [{
                    label: 'Latency (ms)',
                    data: [120, 135, 125, 140, 115, 150, 142, 130, 128, 124],
                    borderColor: '#60A5FA', // Tailwind blue-400
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
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        mode: 'index',
                        intersect: false,
                        backgroundColor: 'rgba(17, 24, 39, 0.9)',
                        titleColor: '#fff',
                        bodyColor: '#cbd5e1',
                        borderColor: '#334155',
                        borderWidth: 1
                    }
                },
                scales: {
                    x: {
                        grid: { color: 'rgba(100, 116, 139, 0.1)' },
                        ticks: { color: '#94a3b8' }
                    },
                    y: {
                        grid: { color: 'rgba(100, 116, 139, 0.1)' },
                        ticks: { color: '#94a3b8' },
                        beginAtZero: false
                    }
                },
                interaction: {
                    mode: 'nearest',
                    axis: 'x',
                    intersect: false
                }
            }
        });

        // 2. Mock Polling Function (Simulate Live Data)
        function refreshStats() {
            // Simulate fetching data...
            // Randomize Latency Display
            const currentLatency = 100 + Math.floor(Math.random() * 50);
            document.getElementById('metric-latency').innerText = currentLatency;

            // Randomize Throughput
            const currentRps = 800 + Math.floor(Math.random() * 100);
            document.getElementById('metric-throughput').innerText = currentRps;

            // Update Chart
            const newDataPoint = currentLatency;
            const newLabel = new Date().toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });

            latencyChart.data.labels.shift();
            latencyChart.data.labels.push(newLabel);
            latencyChart.data.datasets[0].data.shift();
            latencyChart.data.datasets[0].data.push(newDataPoint);
            latencyChart.update();
        }

        // Poll every 3 seconds
        setInterval(refreshStats, 3000);
    });

    // 3. Queue Action Handler
    function toggleQueue(queueName, action) {
        if(confirm(`Are you sure you want to ${action} the '${queueName}' queue?`)) {
            // TODO: Make AJAX call to /admin/queues/{name}/{action}
            alert(`Command sent: ${action} ${queueName}`);
        }
    }
</script> 
 @endpush
@endsection