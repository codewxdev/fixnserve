@extends('layouts.app')
@section('title', 'Forensic Replay | Compliance')
@section('content')
<div class="p-4 sm:p-6 lg:p-8 bg-bg-primary min-h-screen">
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-h3 font-bold text-text-primary">Forensic Event Replay</h1>
            <p class="text-body-sm text-text-secondary mt-1">Reconstruct visual timelines for security investigations and legal disputes.</p>
        </div>
        <button class="btn btn-secondary py-2.5 px-4 text-brand-primary border-brand-primary/30 transition-colors"><i data-lucide="package" class="w-4 h-4 mr-2"></i> Export Forensic Bundle</button>
    </div>

    <!-- Timeline Reconstructor -->
    <div class="card p-6 border-border-default mb-8 bg-bg-tertiary">
        <h3 class="text-body font-bold text-text-primary mb-4 border-b border-border-default pb-2">Investigation Parameters</h3>
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
            <div class="form-group mb-0">
                <label class="form-label">Target Actor</label>
                <input type="text" placeholder="Admin ID / User ID" class="form-input w-full text-sm">
            </div>
            <div class="form-group mb-0">
                <label class="form-label">Target Entity</label>
                <input type="text" placeholder="Business ID / Txn ID" value="B-1024" class="form-input w-full text-sm">
            </div>
            <div class="form-group mb-0">
                <label class="form-label">Time Window</label>
                <select class="form-input w-full text-sm"><option>Specific Date Range</option><option>Last 24 Hours</option></select>
            </div>
            <button class="btn btn-primary py-2.5 w-full shadow-sm"><i data-lucide="search" class="w-4 h-4 mr-2"></i> Reconstruct</button>
        </div>
    </div>

    <!-- Playback Interface -->
    <div class="card p-0 shadow-sm border-border-default overflow-hidden flex flex-col min-h-[500px]">
        <div class="p-5 border-b border-border-default bg-bg-primary flex justify-between items-center">
            <div class="flex items-center gap-4">
                <button class="w-10 h-10 rounded-full bg-brand-primary text-white flex items-center justify-center hover:bg-brand-secondary transition-colors"><i data-lucide="play" class="w-5 h-5 ml-1"></i></button>
                <div>
                    <h3 class="text-body-sm font-bold text-text-primary">Replay Active: B-1024 Investigation</h3>
                    <p class="text-caption text-text-secondary font-mono mt-0.5">Time: 2026-05-04 12:28:22</p>
                </div>
            </div>
            <span class="px-2 py-1 text-[10px] font-bold uppercase bg-semantic-error-bg text-semantic-error rounded border border-semantic-error/20">Strict Audit Mode</span>
        </div>
        
        <!-- Replay Visual Area -->
        <div class="flex-1 bg-bg-secondary flex relative">
            <!-- Timeline Sidebar -->
            <div class="w-64 border-r border-border-default p-4 space-y-4 overflow-y-auto bg-bg-primary">
                <div class="p-3 border-l-4 border-l-border-strong bg-bg-tertiary rounded opacity-50 cursor-pointer text-xs">
                    <p class="font-mono text-text-tertiary mb-1">12:20:00</p>
                    <p class="font-bold text-text-secondary">Admin Login</p>
                </div>
                <div class="p-3 border-l-4 border-l-brand-primary bg-brand-primary/5 rounded shadow-sm cursor-pointer text-xs">
                    <p class="font-mono text-brand-primary font-bold mb-1">12:28:22 (Current)</p>
                    <p class="font-bold text-text-primary">Emergency Override Triggered</p>
                </div>
                <div class="p-3 border-l-4 border-l-border-strong bg-bg-tertiary rounded opacity-50 cursor-pointer text-xs">
                    <p class="font-mono text-text-tertiary mb-1">12:35:10</p>
                    <p class="font-bold text-text-secondary">Account Suspended</p>
                </div>
            </div>
            
            <!-- Context View -->
            <div class="flex-1 p-6 flex flex-col justify-center items-center">
                <div class="w-full max-w-2xl bg-bg-primary border border-border-default rounded-lg shadow-sm p-6">
                    <div class="flex justify-between items-center border-b border-border-default pb-4 mb-4">
                        <h4 class="text-h4 font-bold text-text-primary">State Comparison</h4>
                        <span class="font-mono text-caption text-text-secondary">Diff View</span>
                    </div>
                    <div class="grid grid-cols-2 gap-4 font-mono text-xs">
                        <div class="p-4 bg-semantic-error-bg/10 border border-semantic-error/20 rounded">
                            <p class="font-bold text-semantic-error mb-2">Before State</p>
                            <p class="text-text-secondary">{ "status": "active", "feature_lock": false }</p>
                        </div>
                        <div class="p-4 bg-semantic-success-bg/10 border border-semantic-success/20 rounded">
                            <p class="font-bold text-semantic-success mb-2">After State</p>
                            <p class="text-text-primary">{ "status": "suspended", "feature_lock": true }</p>
                        </div>
                    </div>
                    <div class="mt-6 p-4 bg-bg-tertiary rounded border border-border-default">
                        <p class="text-caption font-bold text-text-tertiary uppercase">Mandatory Reason Provided</p>
                        <p class="text-body-sm text-text-primary mt-1">"Fraud detection AI flagged account. Emergency freeze applied pending manual investigation."</p>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Timeline Slider -->
        <div class="p-4 border-t border-border-default bg-bg-tertiary">
            <input type="range" class="w-full h-2 bg-border-strong rounded-lg appearance-none cursor-pointer" value="50">
        </div>
    </div>
</div>
@endsection