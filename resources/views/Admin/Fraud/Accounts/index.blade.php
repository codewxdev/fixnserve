@extends('layouts.app')
@section('title', 'Business Account Risk | Fraud')
@section('content')
<div class="p-4 sm:p-6 lg:p-8 bg-bg-primary min-h-screen">
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-h3 font-bold text-text-primary">Business Account Risk</h1>
            <p class="text-body-sm text-text-secondary mt-1">Detect account takeovers, unauthorized team additions, and operational anomalies.</p>
        </div>
    </div>

    <!-- Active Threat Alerts -->
    <div class="mb-8 p-5 rounded-lg border border-semantic-error/40 bg-semantic-error-bg/30">
        <h3 class="text-body font-bold text-semantic-error mb-3 flex items-center gap-2"><i data-lucide="shield-alert" class="w-5 h-5"></i> Active Account Takeover Indicators</h3>
        <div class="space-y-3">
            <div class="flex justify-between items-center bg-bg-primary p-3 rounded border border-semantic-error/20">
                <div>
                    <p class="text-body-sm font-bold text-text-primary">Elevate Digital (B-1024)</p>
                    <p class="text-caption text-text-secondary mt-0.5">Threat Pattern: <span class="font-mono">Unusual login geo + Admin password reset.</span></p>
                </div>
                <div class="flex gap-2">
                    <button class="btn btn-sm btn-secondary text-brand-primary border-brand-primary/30 hover:bg-brand-primary/10 transition-colors">Trigger Step-Up MFA</button>
                    <button class="btn btn-sm btn-destructive py-1.5 px-3"><i data-lucide="lock" class="w-4 h-4 mr-1"></i> Freeze Account</button>
                </div>
            </div>
            <div class="flex justify-between items-center bg-bg-primary p-3 rounded border border-semantic-warning/30">
                <div>
                    <p class="text-body-sm font-bold text-text-primary">Apex Cleaners (B-992)</p>
                    <p class="text-caption text-text-secondary mt-0.5">Threat Pattern: <span class="font-mono">Rapid team member additions (5 in 1hr).</span></p>
                </div>
                <div class="flex gap-2">
                    <button class="btn btn-sm btn-secondary text-semantic-warning border-semantic-warning/30 hover:bg-semantic-warning/10 transition-colors">Temp Restrict Features</button>
                    <button class="btn btn-sm btn-secondary py-1.5 px-3">Flag Manual Review</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Pattern Detection Controls -->
    <div class="card p-0 shadow-sm border-border-default">
        <div class="p-5 border-b border-border-default bg-bg-tertiary flex justify-between items-center">
            <h3 class="text-h4 font-bold text-text-primary">Threat Pattern Sensitivities</h3>
        </div>
        <div class="p-6 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <div class="form-group mb-0">
                <label class="form-label text-caption font-bold uppercase">Rapid Team Additions</label>
                <div class="flex items-center gap-2">
                    <input type="number" value="3" class="form-input w-20 text-center text-sm">
                    <span class="text-body-sm text-text-secondary">members per hour</span>
                </div>
            </div>
            <div class="form-group mb-0">
                <label class="form-label text-caption font-bold uppercase">Txn Volume Spikes</label>
                <div class="flex items-center gap-2">
                    <span class="text-body-sm text-text-secondary">></span>
                    <input type="number" value="200" class="form-input w-20 text-center text-sm">
                    <span class="text-body-sm text-text-secondary">% increase vs 30d avg</span>
                </div>
            </div>
            <div class="form-group mb-0">
                <label class="form-label text-caption font-bold uppercase">Failed Payment Threshold</label>
                <div class="flex items-center gap-2">
                    <input type="number" value="5" class="form-input w-20 text-center text-sm">
                    <span class="text-body-sm text-text-secondary">attempts per 15 mins</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection