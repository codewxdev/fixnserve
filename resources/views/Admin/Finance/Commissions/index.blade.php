@extends('layouts.app')
@section('title', 'Commissions & Tax | Finance')
@section('content')
<div class="p-4 sm:p-6 lg:p-8 bg-bg-primary min-h-screen">
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-h3 font-bold text-text-primary">Commissions & Tax Engine</h1>
            <p class="text-body-sm text-text-secondary mt-1">Configure processing fees, volume bonuses, and regional tax compliance.</p>
        </div>
        <button class="btn btn-primary py-2.5 px-4 transition-colors"><i data-lucide="save" class="w-4 h-4 mr-2"></i> Deploy Rules</button>
    </div>

    <div class="grid grid-cols-1 xl:grid-cols-2 gap-8">
        
        <div class="card p-0 shadow-sm border-border-default">
            <div class="p-5 border-b border-border-default bg-bg-tertiary">
                <h3 class="text-h4 font-bold text-text-primary">Commission Rule Engine</h3>
            </div>
            <div class="p-6 space-y-6">
                <h4 class="text-caption font-bold text-text-tertiary uppercase">Tier-Based Default Rates</h4>
                <div class="space-y-3">
                    <div class="flex justify-between items-center p-3 border border-border-default rounded-lg">
                        <span class="text-body-sm font-bold text-text-primary">Starter Tier</span>
                        <input type="number" step="0.1" value="3.0" class="form-input w-24 text-center">
                    </div>
                    <div class="flex justify-between items-center p-3 border border-border-default rounded-lg">
                        <span class="text-body-sm font-bold text-text-primary">Growth Tier</span>
                        <input type="number" step="0.1" value="2.5" class="form-input w-24 text-center">
                    </div>
                    <div class="flex justify-between items-center p-3 border border-border-default rounded-lg">
                        <span class="text-body-sm font-bold text-text-primary">Scale Tier</span>
                        <input type="number" step="0.1" value="2.2" class="form-input w-24 text-center">
                    </div>
                </div>

                <h4 class="text-caption font-bold text-text-tertiary uppercase pt-4 border-t border-border-default">High-Volume Bonuses</h4>
                <div class="p-4 bg-brand-primary/5 border border-brand-primary/20 rounded-lg flex items-center justify-between">
                    <div>
                        <p class="text-body-sm font-bold text-text-primary">Volume Discount (> $100K/mo)</p>
                        <p class="text-caption text-text-secondary mt-1">Automatically reduces commission rate.</p>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="text-body-sm text-text-secondary">-</span>
                        <input type="number" step="0.1" value="0.2" class="form-input w-20 text-center">
                        <span class="text-body-sm text-text-secondary">%</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="card p-0 shadow-sm border-border-default">
            <div class="p-5 border-b border-border-default bg-bg-tertiary">
                <h3 class="text-h4 font-bold text-text-primary">Tax Configuration (FTA Compliant)</h3>
            </div>
            <div class="p-6 space-y-6">
                <div class="form-group mb-0">
                    <label class="form-label">UAE VAT Standard Rate</label>
                    <div class="flex items-center gap-3">
                        <input type="number" value="5" class="form-input w-full md:w-1/2">
                        <span class="text-body-sm text-text-secondary">%</span>
                    </div>
                </div>

                <div class="space-y-3">
                    <label class="flex items-center gap-3 cursor-pointer">
                        <input type="checkbox" checked class="w-4 h-4 rounded border-border-strong text-brand-primary bg-bg-primary">
                        <div>
                            <span class="block text-body-sm font-bold text-text-primary">Invoice-Level Calculation</span>
                            <span class="block text-caption text-text-secondary">Calculate and separate VAT line items on invoice generation.</span>
                        </div>
                    </label>
                    <label class="flex items-center gap-3 cursor-pointer">
                        <input type="checkbox" checked class="w-4 h-4 rounded border-border-strong text-brand-primary bg-bg-primary">
                        <div>
                            <span class="block text-body-sm font-bold text-text-primary">Support Zero-Rated Services</span>
                            <span class="block text-caption text-text-secondary">Allow specific businesses to apply 0% tax per FTA rules.</span>
                        </div>
                    </label>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection