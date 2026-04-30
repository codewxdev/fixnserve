@extends('layouts.app')
@section('title', 'Platform Wallets | Finance')
@section('content')
<div class="p-4 sm:p-6 lg:p-8 bg-bg-primary min-h-screen">
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-h3 font-bold text-text-primary">Platform Wallets</h1>
            <p class="text-body-sm text-text-secondary mt-1">Live balances across operational, revenue, and reserve holdings.</p>
        </div>
        <select class="form-input w-32 font-bold text-brand-primary border-brand-primary/30">
            <option value="AED">AED (Base)</option>
            <option value="USD">USD</option>
            <option value="GBP">GBP</option>
            <option value="EUR">EUR</option>
        </select>
    </div>

    <div class="mb-8 p-4 bg-brand-primary/5 border border-brand-primary/20 rounded-lg flex items-center justify-between">
        <div class="flex items-center gap-3">
            <i data-lucide="trending-up" class="w-5 h-5 text-brand-primary"></i>
            <div>
                <p class="text-body-sm font-bold text-text-primary">AI Cash Flow Forecast (30 Days)</p>
                <p class="text-caption text-text-secondary">Predicted Net Platform Revenue: <strong class="text-brand-primary">AED 142,500</strong> based on active subscriptions and historical GMV.</p>
            </div>
        </div>
        <button class="btn btn-sm btn-secondary text-brand-primary hover:bg-brand-primary/10 border-brand-primary/30 transition-colors">View Projection</button>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
        
        <div class="card p-6 flex flex-col justify-between">
            <div>
                <p class="text-caption font-bold text-text-tertiary uppercase tracking-wider mb-1">Platform Revenue Wallet</p>
                <h2 class="text-h2 font-black text-text-primary">AED 450,210.00</h2>
            </div>
            <div class="mt-4 space-y-2 text-caption">
                <div class="flex justify-between"><span class="text-text-secondary">Available</span><span class="font-bold text-semantic-success">AED 420,000.00</span></div>
                <div class="flex justify-between"><span class="text-text-secondary">Pending (Transit)</span><span class="font-bold text-text-tertiary">AED 30,210.00</span></div>
            </div>
        </div>

        <div class="card p-6 flex flex-col justify-between">
            <div>
                <p class="text-caption font-bold text-text-tertiary uppercase tracking-wider mb-1">Platform Operations Wallet</p>
                <h2 class="text-h2 font-black text-text-primary">AED 85,000.00</h2>
            </div>
            <div class="mt-4 text-caption text-text-secondary">Allocated for AWS, infrastructure, and team salaries.</div>
        </div>

        <div class="card p-6 flex flex-col justify-between">
            <div>
                <p class="text-caption font-bold text-text-tertiary uppercase tracking-wider mb-1">Business Payout Holdings</p>
                <h2 class="text-h2 font-black text-text-primary">AED 1.24M</h2>
            </div>
            <div class="mt-4 space-y-2 text-caption">
                <div class="flex justify-between"><span class="text-text-secondary">Locked (Pending Settlement)</span><span class="font-bold text-semantic-warning">AED 1.1M</span></div>
                <div class="flex justify-between"><span class="text-text-secondary">Available for Transfer</span><span class="font-bold text-text-primary">AED 140K</span></div>
            </div>
        </div>

        <div class="card p-6  flex flex-col justify-between">
            <div>
                <p class="text-caption font-bold text-text-tertiary uppercase tracking-wider mb-1">Refund Reserve</p>
                <h2 class="text-h2 font-black text-text-primary">AED 50,000.00</h2>
            </div>
            <div class="mt-4 text-caption text-text-secondary">Mandatory minimum reserve to cover chargebacks and automated refunds.</div>
        </div>

        <div class="card p-6   flex flex-col justify-between">
            <div>
                <p class="text-caption font-bold text-text-tertiary uppercase tracking-wider mb-1">Tax Collected (VAT to Remit)</p>
                <h2 class="text-h2 font-black text-text-primary">AED 32,450.00</h2>
            </div>
            <div class="mt-4 text-caption text-text-secondary">FTA Compliant. Pending quarterly remittance.</div>
        </div>

    </div>
</div>
@endsection