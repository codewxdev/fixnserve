@extends('Layouts.app')
@section('title', 'Executive Dashboard | Analytics')
@section('content')
<div class="p-4 sm:p-6 lg:p-8 bg-bg-primary min-h-screen">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
        <div>
            <h1 class="text-h3 font-bold text-text-primary">Executive Dashboard</h1>
            <p class="text-body-sm text-text-secondary mt-1">High-level growth metrics, acquisition funnels, and churn analysis.</p>
        </div>
        <div class="flex items-center gap-3">
            <select class="form-input text-sm"><option>This Quarter</option><option>Last Month</option><option>YTD</option></select>
            <div class="flex gap-1">
                <button class="btn btn-secondary px-3 py-2 text-text-secondary" title="Export PDF"><i data-lucide="file-text" class="w-4 h-4"></i></button>
                <button class="btn btn-secondary px-3 py-2 text-text-secondary" title="Export CSV"><i data-lucide="file-spreadsheet" class="w-4 h-4"></i></button>
                <button class="btn btn-primary px-4 py-2 shadow-sm transition-colors"><i data-lucide="calendar-clock" class="w-4 h-4 mr-2"></i> Schedule</button>
            </div>
        </div>
    </div>

    <!-- AI Insights Feed -->
    <div class="mb-8 p-4 bg-brand-primary/5 border border-brand-primary/20 rounded-lg flex items-start gap-3">
        <i data-lucide="sparkles" class="w-5 h-5 text-brand-primary shrink-0 mt-0.5"></i>
        <div>
            <p class="text-body-sm font-bold text-brand-primary">AI Daily Insights Feed</p>
            <ul class="text-caption text-text-secondary mt-2 space-y-1">
                <li><strong class="text-text-primary">Trend Detection:</strong> 15% increase in MRR from the Home Services segment in UAE.</li>
                <li><strong class="text-text-primary">Forecasting:</strong> Projected to hit $1.2M ARR by end of Q3 based on current acquisition velocity.</li>
                <li><strong class="text-semantic-warning">Early Warning:</strong> Slight uptick (2%) in churn for the 'Starter' tier after month 3.</li>
            </ul>
        </div>
    </div>

    <!-- North Star Metrics -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="card p-5 border-border-default">
            <p class="text-caption font-bold text-text-tertiary uppercase mb-1">Total MRR</p>
            <h2 class="text-h2 font-black text-text-primary">$84,500</h2>
            <div class="mt-2 flex justify-between items-center text-caption">
                <span class="text-semantic-success flex items-center gap-1"><i data-lucide="trending-up" class="w-3 h-3"></i> 8.4%</span>
                <span class="text-text-tertiary">vs last period</span>
            </div>
        </div>
        <div class="card p-5 border-border-default">
            <p class="text-caption font-bold text-text-tertiary uppercase mb-1">Active Businesses</p>
            <h2 class="text-h2 font-black text-text-primary">1,420</h2>
            <div class="mt-2 flex justify-between items-center text-caption">
                <span class="text-semantic-success flex items-center gap-1"><i data-lucide="trending-up" class="w-3 h-3"></i> 4.1%</span>
                <span class="text-text-tertiary">vs last period</span>
            </div>
        </div>
        <div class="card p-5 border-border-default">
            <p class="text-caption font-bold text-text-tertiary uppercase mb-1">Net Churn Rate</p>
            <h2 class="text-h2 font-black text-text-primary">2.4%</h2>
            <div class="mt-2 flex justify-between items-center text-caption">
                <span class="text-semantic-error flex items-center gap-1"><i data-lucide="trending-up" class="w-3 h-3"></i> 0.2%</span>
                <span class="text-text-tertiary">vs last period</span>
            </div>
        </div>
        <div class="card p-5 border-border-default">
            <p class="text-caption font-bold text-text-tertiary uppercase mb-1">LTV:CAC Ratio</p>
            <h2 class="text-h2 font-black text-brand-primary">4.2 : 1</h2>
            <div class="mt-2 text-caption text-text-secondary">Healthy segment efficiency</div>
        </div>
    </div>

    <!-- Charts Placeholder Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="card p-6 border-border-default h-80 flex flex-col">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-body font-bold text-text-primary">MRR/ARR Growth</h3>
                <button class="text-caption text-brand-primary font-bold hover:underline">Compare</button>
            </div>
            <div class="flex-1 bg-bg-tertiary rounded border border-border-strong flex items-center justify-center text-text-tertiary text-caption italic">[ Line Chart Rendered Here ]</div>
        </div>
        <div class="card p-6 border-border-default h-80 flex flex-col">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-body font-bold text-text-primary">Acquisition Funnel</h3>
                <select class="form-input text-xs py-1"><option>By Channel</option></select>
            </div>
            <div class="flex-1 bg-bg-tertiary rounded border border-border-strong flex items-center justify-center text-text-tertiary text-caption italic">[ Funnel Chart Rendered Here ]</div>
        </div>
        <div class="card p-6 border-border-default h-80 flex flex-col">
            <h3 class="text-body font-bold text-text-primary mb-4">Revenue by Business Type</h3>
            <div class="flex-1 bg-bg-tertiary rounded border border-border-strong flex items-center justify-center text-text-tertiary text-caption italic">[ Donut Chart Rendered Here ]</div>
        </div>
        <div class="card p-6 border-border-default h-80 flex flex-col">
            <h3 class="text-body font-bold text-text-primary mb-4">Feature Adoption Rates</h3>
            <div class="flex-1 bg-bg-tertiary rounded border border-border-strong flex items-center justify-center text-text-tertiary text-caption italic">[ Bar Chart Rendered Here ]</div>
        </div>
    </div>
</div>
@endsection