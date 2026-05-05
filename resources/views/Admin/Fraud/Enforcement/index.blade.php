@extends('Layouts.app')
@section('title', 'Enforcement Engine | Fraud')
@section('content')
<div class="p-4 sm:p-6 lg:p-8 bg-bg-primary min-h-screen">
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-h3 font-bold text-text-primary">Enforcement Engine</h1>
            <p class="text-body-sm text-text-secondary mt-1">Automated actions based on thresholds, patterns, and AI confidence.</p>
        </div>
    </div>

    <!-- Flow Visual -->
    <div class="card p-6 bg-bg-tertiary border-border-default mb-8 flex flex-col md:flex-row items-center justify-between gap-4 text-center md:text-left text-body-sm">
        <div class="flex items-center gap-2"><span class="px-3 py-1.5 rounded-lg bg-bg-primary border border-border-strong font-bold text-semantic-warning">Risk Event</span></div>
        <i data-lucide="arrow-right" class="w-4 h-4 text-text-tertiary hidden md:block"></i>
        <div class="flex items-center gap-2"><span class="px-3 py-1.5 rounded-lg bg-bg-primary border border-border-strong font-bold text-brand-primary">Rule Engine</span></div>
        <i data-lucide="arrow-right" class="w-4 h-4 text-text-tertiary hidden md:block"></i>
        <div class="flex items-center gap-2"><span class="px-3 py-1.5 rounded-lg bg-semantic-error text-white font-bold shadow-md shadow-semantic-error/20">Enforcement</span></div>
        <i data-lucide="arrow-right" class="w-4 h-4 text-text-tertiary hidden md:block"></i>
        <div class="flex items-center gap-2"><span class="px-3 py-1.5 rounded-lg bg-bg-primary border border-border-strong font-bold text-text-secondary">Audit & Notify</span></div>
    </div>

    <div class="grid grid-cols-1 xl:grid-cols-2 gap-8">
        
        <!-- Automated Actions Config -->
        <div class="card p-0 shadow-sm border-border-default">
            <div class="p-5 border-b border-border-default bg-bg-tertiary flex justify-between items-center">
                <h3 class="text-h4 font-bold text-text-primary">Rule Engine Mapping</h3>
            </div>
            <div class="p-6 space-y-5">
                <div class="flex justify-between items-center pb-4 border-b border-border-default">
                    <div>
                        <p class="text-body-sm font-bold text-text-primary">If AI Confidence > 95% on Account Takeover</p>
                        <p class="text-caption text-text-secondary mt-1">Rule Type: AI Confidence-based</p>
                    </div>
                    <select class="form-input w-48 text-sm border-semantic-error/50 text-semantic-error"><option>Account Suspension</option><option>Wallet Freeze</option></select>
                </div>
                <div class="flex justify-between items-center pb-4 border-b border-border-default">
                    <div>
                        <p class="text-body-sm font-bold text-text-primary">If Chargebacks > 5 in 30 Days</p>
                        <p class="text-caption text-text-secondary mt-1">Rule Type: Threshold-based</p>
                    </div>
                    <select class="form-input w-48 text-sm"><option>Feature Restriction</option><option>Subscription Downgrade</option></select>
                </div>
                <div class="flex justify-between items-center pb-4 border-b border-border-default">
                    <div>
                        <p class="text-body-sm font-bold text-text-primary">If 10+ Failed Txns in 5 Mins</p>
                        <p class="text-caption text-text-secondary mt-1">Rule Type: Pattern-based</p>
                    </div>
                    <select class="form-input w-48 text-sm"><option>Transaction Blocking</option><option>Time-bound Restriction</option></select>
                </div>
            </div>
        </div>

        <!-- Recent Enforcements -->
        <div class="card p-0 shadow-sm border-border-default">
            <div class="p-5 border-b border-border-default bg-bg-tertiary">
                <h3 class="text-h4 font-bold text-text-primary">Recent Automated Executions</h3>
            </div>
            <div class="p-6 space-y-4 text-body-sm">
                <div class="flex items-start gap-3 relative before:absolute before:inset-y-0 before:left-[7px] before:w-px before:bg-border-default">
                    <div class="w-4 h-4 rounded-full bg-semantic-error relative z-10 mt-1 outline outline-4 outline-bg-primary flex items-center justify-center"><i data-lucide="lock" class="w-2 h-2 text-white"></i></div>
                    <div>
                        <p class="font-bold text-text-primary">Account Suspended (B-902)</p>
                        <p class="text-caption text-text-secondary mt-0.5">Triggered by AI Rule: Synthetic Identity Confidence 98%.</p>
                        <p class="text-[10px] text-text-tertiary font-mono mt-1">10:14 AM (Logged & Notified)</p>
                    </div>
                </div>
                <div class="flex items-start gap-3 relative before:absolute before:inset-y-0 before:left-[7px] before:w-px before:bg-border-default">
                    <div class="w-4 h-4 rounded-full bg-semantic-warning relative z-10 mt-1 outline outline-4 outline-bg-primary flex items-center justify-center"><i data-lucide="minus-circle" class="w-2 h-2 text-white"></i></div>
                    <div>
                        <p class="font-bold text-text-primary">Payouts Frozen (B-144)</p>
                        <p class="text-caption text-text-secondary mt-0.5">Triggered by Threshold: Chargeback limit exceeded.</p>
                        <p class="text-[10px] text-text-tertiary font-mono mt-1">Yesterday, 18:30 PM (Logged)</p>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection