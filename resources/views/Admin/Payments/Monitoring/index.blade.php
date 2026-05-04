@extends('layouts.app')
@section('title', 'Transaction Monitoring | Payments')
@section('content')
<div class="p-4 sm:p-6 lg:p-8 bg-bg-primary min-h-screen">
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-h3 font-bold text-text-primary">Transaction Monitoring</h1>
            <p class="text-body-sm text-text-secondary mt-1">Real-time PSP health, volume metrics, and decline rate anomaly alerts.</p>
        </div>
        <select class="form-input w-40 text-body-sm"><option>Last 24 Hours</option><option>Last 7 Days</option></select>
    </div>

    <!-- Active Alerts -->
    <div class="mb-8 space-y-3">
        <div class="bg-semantic-error-bg/30 border border-semantic-error/30 p-4 rounded-lg flex items-start gap-3">
            <i data-lucide="alert-triangle" class="w-5 h-5 text-semantic-error shrink-0 mt-0.5"></i>
            <div>
                <p class="text-body-sm font-bold text-semantic-error">Success Rate Dropped Below 95%</p>
                <p class="text-caption text-text-primary mt-1">Current success rate is 92.4%. Unusual spike in 'insufficient_funds' declines detected in the last hour.</p>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-4 gap-6 mb-8">
        <div class="card p-5">
            <p class="text-caption font-bold text-text-tertiary uppercase">Txn Volume (24h)</p>
            <h2 class="text-h2 font-black text-text-primary mt-1">AED 452k</h2>
            <p class="text-[10px] text-semantic-success mt-2 flex items-center"><i data-lucide="trending-up" class="w-3 h-3 mr-1"></i> +12% vs yesterday</p>
        </div>
        <div class="card p-5">
            <p class="text-caption font-bold text-text-tertiary uppercase">Success Rate</p>
            <h2 class="text-h2 font-black text-semantic-error mt-1">92.4%</h2>
            <p class="text-[10px] text-semantic-error mt-2">Target: >95.0%</p>
        </div>
        <div class="card p-5">
            <p class="text-caption font-bold text-text-tertiary uppercase">Avg Txn Value (AOV)</p>
            <h2 class="text-h2 font-black text-text-primary mt-1">AED 1,240</h2>
            <p class="text-[10px] text-text-secondary mt-2">Stable across regions</p>
        </div>
        <div class="card p-5">
            <p class="text-caption font-bold text-text-tertiary uppercase">Stripe PSP Health</p>
            <h2 class="text-h2 font-black text-semantic-success mt-1">Operational</h2>
            <p class="text-[10px] text-text-secondary mt-2">API Latency: 142ms</p>
        </div>
    </div>

    <!-- Distributions -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="card p-6 border-border-default">
            <h3 class="text-body font-bold text-text-primary mb-4">Decline Rate by Reason</h3>
            <div class="space-y-4">
                <div>
                    <div class="flex justify-between text-caption mb-1"><span class="font-mono text-text-secondary">insufficient_funds</span><span class="font-bold text-text-primary">62%</span></div>
                    <div class="w-full bg-bg-muted h-1.5 rounded-full"><div class="bg-semantic-warning h-1.5 rounded-full" style="width: 62%"></div></div>
                </div>
                <div>
                    <div class="flex justify-between text-caption mb-1"><span class="font-mono text-text-secondary">do_not_honor</span><span class="font-bold text-text-primary">24%</span></div>
                    <div class="w-full bg-bg-muted h-1.5 rounded-full"><div class="bg-semantic-error h-1.5 rounded-full" style="width: 24%"></div></div>
                </div>
                <div>
                    <div class="flex justify-between text-caption mb-1"><span class="font-mono text-text-secondary">fraudulent</span><span class="font-bold text-text-primary">14%</span></div>
                    <div class="w-full bg-bg-muted h-1.5 rounded-full"><div class="bg-purple-500 h-1.5 rounded-full" style="width: 14%"></div></div>
                </div>
            </div>
        </div>
        <div class="card p-6 border-border-default">
            <h3 class="text-body font-bold text-text-primary mb-4">Payment Method Distribution</h3>
            <div class="flex items-center gap-4">
                <!-- Circular Chart Placeholder -->
                <div class="w-24 h-24 rounded-full border-4 border-brand-primary border-t-semantic-success border-l-semantic-warning border-r-purple-500"></div>
                <div class="space-y-2 text-caption flex-1">
                    <div class="flex justify-between"><span class="flex items-center gap-2"><div class="w-2 h-2 rounded-full bg-brand-primary"></div> Visa/Mastercard</span><span class="font-bold">68%</span></div>
                    <div class="flex justify-between"><span class="flex items-center gap-2"><div class="w-2 h-2 rounded-full bg-semantic-success"></div> Apple Pay</span><span class="font-bold">20%</span></div>
                    <div class="flex justify-between"><span class="flex items-center gap-2"><div class="w-2 h-2 rounded-full bg-semantic-warning"></div> Google Pay</span><span class="font-bold">10%</span></div>
                    <div class="flex justify-between"><span class="flex items-center gap-2"><div class="w-2 h-2 rounded-full bg-purple-500"></div> Amex</span><span class="font-bold">2%</span></div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection