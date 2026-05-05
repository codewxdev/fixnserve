@extends('Layouts.app')
@section('title', 'Business Intelligence AI | AI & Automation')
@section('content')
<div class="p-4 sm:p-6 lg:p-8 bg-bg-primary min-h-screen">
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-h3 font-bold text-text-primary">Business Intelligence Models</h1>
            <p class="text-body-sm text-text-secondary mt-1">Predictive health scoring, churn alerts, and upgrade opportunities.</p>
        </div>
    </div>

    <!-- BI Model Capabilities -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="card p-6 bg-bg-tertiary">
            <div class="flex justify-between items-start">
                <h3 class="text-body font-bold text-text-primary">Churn Prediction</h3>
                <i data-lucide="user-minus" class="w-5 h-5 text-semantic-error"></i>
            </div>
            <p class="text-caption text-text-secondary mt-2">Identifies at-risk businesses based on login decay and volume drop.</p>
            <div class="mt-4 pt-4 border-t border-border-default">
                <p class="text-h3 font-black text-semantic-error">14</p>
                <p class="text-[10px] uppercase font-bold text-text-tertiary mt-1">High Risk Accounts</p>
            </div>
        </div>
        <div class="card p-6 bg-bg-tertiary">
            <div class="flex justify-between items-start">
                <h3 class="text-body font-bold text-text-primary">Upgrade Detection</h3>
                <i data-lucide="trending-up" class="w-5 h-5 text-semantic-success"></i>
            </div>
            <p class="text-caption text-text-secondary mt-2">Highlights businesses hitting tier limits who are ready to scale.</p>
            <div class="mt-4 pt-4 border-t border-border-default">
                <p class="text-h3 font-black text-semantic-success">82</p>
                <p class="text-[10px] uppercase font-bold text-text-tertiary mt-1">Upsell Opportunities</p>
            </div>
        </div>
        <div class="card p-6 bg-bg-tertiary">
            <div class="flex justify-between items-start">
                <h3 class="text-body font-bold text-text-primary">Revenue Forecast</h3>
                <i data-lucide="bar-chart" class="w-5 h-5 text-brand-primary"></i>
            </div>
            <p class="text-caption text-text-secondary mt-2">Predicts EOM/EOY subscription and commission GMV.</p>
            <div class="mt-4 pt-4 border-t border-border-default">
                <p class="text-h3 font-black text-text-primary">AED 1.4M</p>
                <p class="text-[10px] uppercase font-bold text-text-tertiary mt-1">Projected Q3 Exit</p>
            </div>
        </div>
    </div>

    <!-- Actionable Insights Table -->
    <div class="card p-0 shadow-sm border-border-default">
        <div class="p-5 border-b border-border-default bg-bg-primary flex justify-between items-center">
            <h3 class="text-h4 font-bold text-text-primary">AI Target List</h3>
            <select class="form-input text-sm w-48"><option>At-Risk (Churn)</option><option>Upgrade Candidates</option></select>
        </div>
        <table class="w-full text-left whitespace-nowrap">
            <thead class="text-caption uppercase text-text-secondary font-semibold border-b border-border-strong bg-bg-tertiary">
                <tr>
                    <th class="px-6 py-4">Business</th>
                    <th class="px-6 py-4">Health Score</th>
                    <th class="px-6 py-4">AI Prediction Reason</th>
                    <th class="px-6 py-4 text-right">Action</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-border-default">
                <tr class="hover:bg-bg-secondary transition-colors">
                    <td class="px-6 py-4 font-bold text-text-primary">AutoFix Garage (B-099)</td>
                    <td class="px-6 py-4"><span class="px-2 py-1 text-[10px] font-bold bg-semantic-error-bg text-semantic-error rounded border border-semantic-error/20">32/100 (Poor)</span></td>
                    <td class="px-6 py-4 text-caption text-text-secondary">40% drop in active jobs, 0 logins in 14 days.</td>
                    <td class="px-6 py-4 text-right"><button class="btn btn-sm btn-secondary py-1.5 px-3">Assign to Retention Team</button></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection