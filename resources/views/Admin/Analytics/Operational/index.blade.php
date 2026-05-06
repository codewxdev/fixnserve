@extends('Layouts.app')
@section('title', 'Operational Reports | Analytics')
@section('content')
<div class="p-4 sm:p-6 lg:p-8 bg-bg-primary min-h-screen">
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-h3 font-bold text-text-primary">Operational Health Analytics</h1>
            <p class="text-body-sm text-text-secondary mt-1">Platform stability, support metrics, KYC processing, and regional activity.</p>
        </div>
        <select class="form-input text-sm"><option>Last 30 Days</option></select>
    </div>

    <!-- Core Metrics -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-6 mb-8">
        <div class="card p-5 text-center">
            <p class="text-caption font-bold text-text-tertiary uppercase">System Uptime</p>
            <h2 class="text-h2 font-black text-text-primary mt-1">99.98%</h2>
            <p class="text-caption text-text-secondary mt-1">0 Incidents</p>
        </div>
        <div class="card p-5 text-center">
            <p class="text-caption font-bold text-text-tertiary uppercase">Avg Ticket Resolution</p>
            <h2 class="text-h2 font-black text-text-primary mt-1">4h 12m</h2>
            <p class="text-caption text-text-secondary mt-1">Volume: 1,420</p>
        </div>
        <div class="card p-5 text-center">
            <p class="text-caption font-bold text-text-tertiary uppercase">Avg KYC Processing</p>
            <h2 class="text-h2 font-black text-text-primary mt-1">12 Mins</h2>
            <p class="text-caption text-text-secondary mt-1">Auto-approval: 88%</p>
        </div>
        <div class="card p-5 text-center">
            <p class="text-caption font-bold text-text-tertiary uppercase">Payment Success</p>
            <h2 class="text-h2 font-black text-text-primary mt-1">94.5%</h2>
            <p class="text-caption text-text-secondary mt-1">Stripe Network</p>
        </div>
    </div>

    <!-- Detailed Analytics -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="card p-6 border-border-default h-80 flex flex-col">
            <h3 class="text-body font-bold text-text-primary mb-4">Business Health Distribution</h3>
            <p class="text-caption text-text-secondary mb-4">Cohort analysis based on usage metrics and engagement.</p>
            <div class="flex-1 bg-bg-tertiary rounded border border-border-strong flex items-center justify-center text-text-tertiary text-caption italic">[ Heatmap / Distribution Chart ]</div>
        </div>
        <div class="card p-6 border-border-default h-80 flex flex-col">
            <h3 class="text-body font-bold text-text-primary mb-4">Regional Activity (Geo-Map)</h3>
            <p class="text-caption text-text-secondary mb-4">Transaction and active business heatmaps across service areas.</p>
            <div class="flex-1 bg-bg-tertiary rounded border border-border-strong flex items-center justify-center text-text-tertiary text-caption italic">[ Interactive Map Rendered Here ]</div>
        </div>
    </div>
</div>
@endsection