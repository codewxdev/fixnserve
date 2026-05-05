@extends('Layouts.app')
@section('title', 'Financial Reports | Analytics')
@section('content')
<div class="p-4 sm:p-6 lg:p-8 bg-bg-primary min-h-screen">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
        <div>
            <h1 class="text-h3 font-bold text-text-primary">Financial & Compliance Reports</h1>
            <p class="text-body-sm text-text-secondary mt-1">Platform P&L, GMV, fee analysis, and regulatory tax documentation.</p>
        </div>
        <select class="form-input text-sm"><option>October 2026</option><option>Q3 2026</option></select>
    </div>

    <!-- Financial Summary -->
    <div class="card p-0 shadow-sm border-border-default mb-8 overflow-hidden">
        <div class="p-5 border-b border-border-default bg-bg-tertiary flex justify-between items-center">
            <h3 class="text-h4 font-bold text-text-primary">Platform P&L Summary</h3>
            <span class="text-caption text-text-secondary">Base Currency: AED</span>
        </div>
        <div class="p-6 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 border-b border-border-default">
            <div><p class="text-caption text-text-secondary mb-1">Gross Merchandise Volume (GMV)</p><p class="text-h3 font-black text-text-primary">AED 4.2M</p></div>
            <div><p class="text-caption text-text-secondary mb-1">Commission Earned</p><p class="text-h3 font-black text-semantic-success">AED 126K</p></div>
            <div><p class="text-caption text-text-secondary mb-1">Subscription Revenue</p><p class="text-h3 font-black text-semantic-success">AED 84K</p></div>
            <div><p class="text-caption text-text-secondary mb-1">Stripe Fees Paid</p><p class="text-h3 font-black text-semantic-error">AED -12K</p></div>
        </div>
        <div class="p-6 bg-brand-primary/5 flex justify-between items-center">
            <p class="text-body font-bold text-text-primary">Net Platform Revenue</p>
            <p class="text-h2 font-black text-brand-primary">AED 198,000.00</p>
        </div>
    </div>

    <!-- Operations & Compliance -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        
        <!-- Money Movement -->
        <div class="card p-0 shadow-sm border-border-default">
            <div class="p-5 border-b border-border-default bg-bg-tertiary">
                <h3 class="text-h4 font-bold text-text-primary">Money Movement Logs</h3>
            </div>
            <div class="p-6 space-y-4">
                <div class="flex justify-between items-center pb-3 border-b border-border-default">
                    <p class="text-body-sm font-bold text-text-primary">Total Business Payouts</p>
                    <p class="text-body-sm font-mono text-text-secondary">AED 3.8M</p>
                </div>
                <div class="flex justify-between items-center pb-3 border-b border-border-default">
                    <p class="text-body-sm font-bold text-text-primary">Refund Volume</p>
                    <p class="text-body-sm font-mono text-text-secondary">AED 42K</p>
                </div>
                <div class="flex justify-between items-center pb-3 border-b border-border-default">
                    <p class="text-body-sm font-bold text-text-primary">Financial Adjustments</p>
                    <p class="text-body-sm font-mono text-semantic-error">- AED 2K</p>
                </div>
                <button class="btn btn-secondary w-full py-2 text-sm"><i data-lucide="external-link" class="w-4 h-4 mr-2"></i> View Full Ledger</button>
            </div>
        </div>

        <!-- Compliance Outputs -->
        <div class="card p-0 shadow-sm border-purple-500/30">
            <div class="p-5 border-b border-border-default bg-purple-500/5">
                <h3 class="text-h4 font-bold text-text-primary flex items-center gap-2"><i data-lucide="landmark" class="w-4 h-4 text-purple-500"></i> Compliance & Tax Outputs</h3>
            </div>
            <div class="p-6 space-y-4">
                <div class="flex justify-between items-center bg-bg-primary p-3 rounded border border-border-default">
                    <div>
                        <p class="text-body-sm font-bold text-text-primary">UAE VAT Filing Report</p>
                        <p class="text-caption text-text-secondary mt-0.5">VAT Collected: AED 32,450.00</p>
                    </div>
                    <button class="btn btn-sm btn-secondary text-brand-primary px-3 py-1.5 border-brand-primary/30"><i data-lucide="download" class="w-3 h-3 mr-1"></i> PDF</button>
                </div>
                <div class="flex justify-between items-center bg-bg-primary p-3 rounded border border-border-default">
                    <div>
                        <p class="text-body-sm font-bold text-text-primary">Annual Financial Statement</p>
                        <p class="text-caption text-text-secondary mt-0.5">Prepared for Auditing</p>
                    </div>
                    <button class="btn btn-sm btn-secondary text-brand-primary px-3 py-1.5 border-brand-primary/30"><i data-lucide="download" class="w-3 h-3 mr-1"></i> XLS</button>
                </div>
                <div class="flex justify-between items-center bg-bg-primary p-3 rounded border border-border-default">
                    <div>
                        <p class="text-body-sm font-bold text-text-primary">Investor Report (Q3)</p>
                        <p class="text-caption text-text-secondary mt-0.5">High-level growth & cash flow</p>
                    </div>
                    <button class="btn btn-sm btn-secondary text-brand-primary px-3 py-1.5 border-brand-primary/30"><i data-lucide="download" class="w-3 h-3 mr-1"></i> PPT</button>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection