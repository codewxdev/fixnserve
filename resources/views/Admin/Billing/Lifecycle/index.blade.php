@extends('layouts.app')
@section('title', 'Subscription Lifecycle | Billing')
@section('content')
<div class="p-4 sm:p-6 lg:p-8 bg-bg-primary min-h-screen">
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-h3 font-bold text-text-primary">Subscription Lifecycle</h1>
            <p class="text-body-sm text-text-secondary mt-1">Manage state transitions, dunning sequences, and retention metrics.</p>
        </div>
        <button class="btn btn-secondary px-4 py-2.5 transition-colors"><i data-lucide="download" class="w-4 h-4 mr-2"></i> Export Cohort Data</button>
    </div>

    <div class="grid grid-cols-2 lg:grid-cols-5 gap-4 mb-8">
        <div class="card p-4">
            <p class="text-caption font-bold text-text-tertiary uppercase">Trial</p>
            <p class="text-h3 font-bold text-text-primary mt-1">84</p>
        </div>
        <div class="card p-4">
            <p class="text-caption font-bold text-text-tertiary uppercase">Active</p>
            <p class="text-h3 font-bold text-text-primary mt-1">1,240</p>
        </div>
        <div class="card p-4">
            <p class="text-caption font-bold text-text-tertiary uppercase">Grace Period</p>
            <p class="text-h3 font-bold text-text-primary mt-1">22</p>
        </div>
        <div class="card p-4 ">
            <p class="text-caption font-bold text-text-tertiary uppercase">Suspended</p>
            <p class="text-h3 font-bold text-text-primary mt-1">15</p>
        </div>
        <div class="card p-4 bg-bg-tertiary">
            <p class="text-caption font-bold text-text-tertiary uppercase">Cancelled</p>
            <p class="text-h3 font-bold text-text-primary mt-1">45</p>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
        <div class="card p-5 border-semantic-error/20 bg-semantic-error-bg/30">
            <div class="flex items-center gap-2 mb-3">
                <i data-lucide="trending-down" class="w-5 h-5 text-semantic-error"></i>
                <h3 class="text-body font-bold text-semantic-error">AI Churn Risk Prediction</h3>
            </div>
            <p class="text-body-sm text-text-primary mb-4">12 businesses exhibit high probability of cancellation before next billing cycle.</p>
            <button class="btn btn-sm btn-secondary text-semantic-error border-semantic-error/30 hover:bg-semantic-error hover:text-white px-4 py-2 transition-colors">View At-Risk Accounts</button>
        </div>
        <div class="card p-5 border-semantic-success/20 bg-semantic-success-bg/30">
            <div class="flex items-center gap-2 mb-3">
                <i data-lucide="trending-up" class="w-5 h-5 text-semantic-success"></i>
                <h3 class="text-body font-bold text-semantic-success">Upgrade Likelihood Scoring</h3>
            </div>
            <p class="text-body-sm text-text-primary mb-4">45 'Starter' accounts are consistently hitting soft limits. Ready for Growth tier.</p>
            <button class="btn btn-sm btn-secondary text-semantic-success border-semantic-success/30 hover:bg-semantic-success hover:text-white px-4 py-2 transition-colors">Review Upgrade Targets</button>
        </div>
    </div>

    <div class="card p-0 overflow-hidden shadow-sm">
        <div class="p-5 bg-bg-tertiary border-b border-border-default flex justify-between items-center">
            <h3 class="text-body font-bold text-text-primary">Failed Payment Handling (Dunning Sequence)</h3>
        </div>
        <div class="p-6 space-y-4">
            <div class="flex items-center gap-4 text-body-sm"><span class="font-mono font-bold w-16 text-text-tertiary">Day 0</span> <span>Payment fails. Retry immediately. Email business owner.</span></div>
            <div class="flex items-center gap-4 text-body-sm"><span class="font-mono font-bold w-16 text-text-tertiary">Day 1</span> <span>Retry attempt 2.</span></div>
            <div class="flex items-center gap-4 text-body-sm"><span class="font-mono font-bold w-16 text-text-tertiary">Day 3</span> <span>Retry attempt 3.</span></div>
            <div class="flex items-center gap-4 text-body-sm"><span class="font-mono font-bold w-16 text-semantic-warning">Day 5</span> <span class="text-semantic-warning font-bold">Enter Grace Period.</span></div>
            <div class="flex items-center gap-4 text-body-sm"><span class="font-mono font-bold w-16 text-semantic-warning">Day 10</span> <span>Downgrade features automatically.</span></div>
            <div class="flex items-center gap-4 text-body-sm"><span class="font-mono font-bold w-16 text-semantic-error">Day 15</span> <span class="text-semantic-error font-bold">Suspend Account.</span></div>
            <div class="flex items-center gap-4 text-body-sm"><span class="font-mono font-bold w-16 text-text-tertiary">Day 30</span> <span class="text-text-tertiary">Move to Cancelled.</span></div>
        </div>
    </div>
</div>
@endsection