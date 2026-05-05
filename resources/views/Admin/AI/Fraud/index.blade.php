@extends('layouts.app')
@section('title', 'Fraud AI | AI & Automation')
@section('content')
<div class="p-4 sm:p-6 lg:p-8 bg-bg-primary min-h-screen">
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-h3 font-bold text-text-primary">Fraud & Abuse AI</h1>
            <p class="text-body-sm text-text-secondary mt-1">Deep behavioral modeling for collusion, anomaly detection, and wallet abuse.</p>
        </div>
    </div>

    <!-- Fraud Models Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
        <!-- Collusion Graph -->
        <div class="card p-6 border-border-default flex flex-col justify-between">
            <div>
                <div class="flex justify-between items-center mb-2">
                    <h3 class="text-body font-bold text-text-primary flex items-center gap-2"><i data-lucide="git-network" class="w-5 h-5 text-purple-500"></i> Collusion Graphs</h3>
                    <span class="px-2 py-0.5 text-[10px] uppercase font-bold bg-semantic-success-bg text-semantic-success rounded border border-semantic-success/20">Model Active</span>
                </div>
                <p class="text-caption text-text-secondary mb-4">Detects hidden relationships between seemingly independent client and business accounts to catch self-dealing.</p>
            </div>
            <div class="p-4 bg-bg-tertiary rounded-lg border border-border-strong flex items-center justify-center h-32 relative overflow-hidden">
                <div class="absolute inset-0 opacity-20" style="background-image: radial-gradient(circle at 2px 2px, var(--color-border-strong) 1px, transparent 0); background-size: 16px 16px;"></div>
                <p class="text-caption font-bold text-purple-500 relative z-10"><i data-lucide="alert-circle" class="w-4 h-4 inline mr-1"></i> 2 Suspected Collusion Rings Detected</p>
            </div>
        </div>

        <!-- Wallet / Refund Abuse -->
        <div class="card p-6 border-border-default space-y-4">
            <h3 class="text-body font-bold text-text-primary flex items-center gap-2"><i data-lucide="shield-alert" class="w-5 h-5 text-semantic-error"></i> Transaction Level Models</h3>
            
            <div class="p-4 bg-bg-primary border border-border-default rounded flex justify-between items-center">
                <div>
                    <p class="text-body-sm font-bold text-text-primary">Refund Abuse Prediction</p>
                    <p class="text-caption text-text-secondary mt-0.5">Detects serial refunders and friendly fraud patterns.</p>
                </div>
                <span class="text-h3 font-black text-semantic-warning">98%</span>
            </div>
            
            <div class="p-4 bg-bg-primary border border-border-default rounded flex justify-between items-center">
                <div>
                    <p class="text-body-sm font-bold text-text-primary">Wallet Exploitation Detection</p>
                    <p class="text-caption text-text-secondary mt-0.5">Flags circular money movement and laundering topologies.</p>
                </div>
                <span class="text-h3 font-black text-semantic-success">Safe</span>
            </div>
        </div>
    </div>
</div>
@endsection