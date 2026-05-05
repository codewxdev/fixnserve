@extends('layouts.app')
@section('title', 'Model Governance | AI & Automation')
@section('content')
<div class="p-4 sm:p-6 lg:p-8 bg-bg-primary min-h-screen">
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-h3 font-bold text-text-primary">Model Governance & Explainability</h1>
            <p class="text-body-sm text-text-secondary mt-1">Monitor drift, bias, training lineage, and execute model rollbacks.</p>
        </div>
    </div>

    <!-- Active Models Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
        
        <!-- Fraud Model Card -->
        <div class="card p-6 border-border-default">
            <div class="flex justify-between items-start mb-4">
                <div>
                    <h3 class="text-body font-bold text-text-primary">Fraud: Transaction Anomaly</h3>
                    <p class="text-caption font-mono text-text-tertiary mt-1">Version 4.2.1-prod</p>
                </div>
                <button class="btn btn-sm btn-destructive py-1.5 px-3 shadow-sm shadow-semantic-error/20 text-xs"><i data-lucide="rotate-ccw" class="w-3 h-3 mr-1"></i> Rollback</button>
            </div>
            
            <div class="space-y-4 text-sm">
                <div class="flex justify-between items-center">
                    <span class="text-text-secondary">Drift Detection</span>
                    <span class="px-2 py-0.5 bg-semantic-success-bg text-semantic-success font-bold text-[10px] rounded uppercase">Stable (0.02)</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-text-secondary">Bias Monitoring (Region)</span>
                    <span class="px-2 py-0.5 bg-semantic-success-bg text-semantic-success font-bold text-[10px] rounded uppercase">Pass</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-text-secondary">Action Confidence Threshold</span>
                    <span class="font-mono font-bold text-text-primary">95.0%</span>
                </div>
            </div>
            <div class="mt-5 pt-5 border-t border-border-default flex justify-between">
                <button class="text-brand-primary hover:underline text-caption font-bold flex items-center gap-1"><i data-lucide="file-text" class="w-3 h-3"></i> Explainability Report</button>
                <button class="text-text-tertiary hover:underline text-caption flex items-center gap-1"><i data-lucide="database" class="w-3 h-3"></i> Training Lineage</button>
            </div>
        </div>

        <!-- BI Model Card -->
        <div class="card p-6 border-border-default">
            <div class="flex justify-between items-start mb-4">
                <div>
                    <h3 class="text-body font-bold text-text-primary">BI: Churn Prediction</h3>
                    <p class="text-caption font-mono text-text-tertiary mt-1">Version 2.0.4-prod</p>
                </div>
                <button class="btn btn-sm btn-destructive py-1.5 px-3 shadow-sm shadow-semantic-error/20 text-xs"><i data-lucide="rotate-ccw" class="w-3 h-3 mr-1"></i> Rollback</button>
            </div>
            
            <div class="space-y-4 text-sm">
                <div class="flex justify-between items-center">
                    <span class="text-text-secondary">Drift Detection</span>
                    <span class="px-2 py-0.5 bg-semantic-warning-bg border border-semantic-warning/20 text-semantic-warning font-bold text-[10px] rounded uppercase">Minor Drift (0.14)</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-text-secondary">Bias Monitoring (Business Type)</span>
                    <span class="px-2 py-0.5 bg-semantic-success-bg text-semantic-success font-bold text-[10px] rounded uppercase">Pass</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-text-secondary">Action Confidence Threshold</span>
                    <span class="font-mono font-bold text-text-primary">85.0%</span>
                </div>
            </div>
            <div class="mt-5 pt-5 border-t border-border-default flex justify-between">
                <button class="text-brand-primary hover:underline text-caption font-bold flex items-center gap-1"><i data-lucide="file-text" class="w-3 h-3"></i> Explainability Report</button>
                <button class="text-text-tertiary hover:underline text-caption flex items-center gap-1"><i data-lucide="database" class="w-3 h-3"></i> Training Lineage</button>
            </div>
        </div>

    </div>
</div>
@endsection