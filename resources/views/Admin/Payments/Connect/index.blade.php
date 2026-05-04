@extends('layouts.app')
@section('title', 'Stripe Connect | Payments')
@section('content')
<div class="p-4 sm:p-6 lg:p-8 bg-bg-primary min-h-screen">
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-h3 font-bold text-text-primary">Stripe Connect Integration</h1>
            <p class="text-body-sm text-text-secondary mt-1">Manage connected Express accounts, onboarding status, and platform application fees.</p>
        </div>
        <button class="btn btn-secondary py-2.5 px-4 text-brand-primary border-brand-primary/30 hover:bg-brand-primary/10 transition-colors"><i data-lucide="settings" class="w-4 h-4 mr-2"></i> Platform Rates Config</button>
    </div>

    <!-- Platform Rate Config Overview -->
    <div class="card p-6 border-border-default mb-8 bg-bg-tertiary">
        <h3 class="text-body font-bold text-text-primary mb-4 flex items-center gap-2"><i data-lucide="percent" class="w-5 h-5 text-text-secondary"></i> Platform Rate & Policy Configuration</h3>
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 text-body-sm">
            <div><p class="text-text-secondary">Application Fee (Starter)</p><p class="font-bold text-text-primary mt-1">3.0% + $0.30</p></div>
            <div><p class="text-text-secondary">Application Fee (Growth)</p><p class="font-bold text-text-primary mt-1">2.5% + $0.30</p></div>
            <div><p class="text-text-secondary">Dispute Responsibility</p><p class="font-bold text-text-primary mt-1">Connected Account</p></div>
            <div><p class="text-text-secondary">Refund Fee Return</p><p class="font-bold text-semantic-error mt-1">Fees Not Returned</p></div>
        </div>
    </div>

    <!-- Connected Accounts Registry -->
    <div class="card p-0 shadow-sm border-border-default">
        <div class="p-5 border-b border-border-default bg-bg-primary flex justify-between items-center">
            <h3 class="text-h4 font-bold text-text-primary">Connected Businesses (Express)</h3>
            <input type="text" placeholder="Search Account ID..." class="form-input w-64 text-body-sm">
        </div>
        <table class="w-full text-left whitespace-nowrap">
            <thead class="text-caption uppercase text-text-secondary font-semibold border-b border-border-strong bg-bg-tertiary">
                <tr>
                    <th class="px-6 py-4">Business & Stripe ID</th>
                    <th class="px-6 py-4">Verification Status</th>
                    <th class="px-6 py-4">Capabilities</th>
                    <th class="px-6 py-4 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-border-default">
                <tr class="hover:bg-bg-secondary transition-colors">
                    <td class="px-6 py-4">
                        <p class="text-body-sm font-bold text-text-primary">Elevate Digital (B-1024)</p>
                        <p class="text-caption text-text-secondary font-mono mt-1">acct_1NXY2jABCD123</p>
                    </td>
                    <td class="px-6 py-4"><span class="px-2 py-1 text-[10px] font-bold uppercase bg-semantic-success-bg text-semantic-success rounded border border-semantic-success/20">Verified</span></td>
                    <td class="px-6 py-4 text-body-sm">
                        <span class="flex items-center gap-1 text-semantic-success"><i data-lucide="check-circle" class="w-3 h-3"></i> Transfers Active</span>
                        <span class="flex items-center gap-1 text-semantic-success mt-1"><i data-lucide="check-circle" class="w-3 h-3"></i> Payouts Active</span>
                    </td>
                    <td class="px-6 py-4 text-right space-x-2">
                        <button class="btn btn-sm btn-secondary py-2 px-3 hover:bg-bg-tertiary transition-colors" title="View in Stripe"><i data-lucide="external-link" class="w-4 h-4"></i></button>
                        <button class="btn btn-sm btn-destructive py-2 px-3" title="Unlink Account (Dual Approval)"><i data-lucide="unlink" class="w-4 h-4"></i></button>
                    </td>
                </tr>
                <tr class="hover:bg-bg-secondary transition-colors">
                    <td class="px-6 py-4">
                        <p class="text-body-sm font-bold text-text-primary">CleanSweep UAE (B-1025)</p>
                        <p class="text-caption text-text-secondary font-mono mt-1">acct_8ZXP9kLKJH789</p>
                    </td>
                    <td class="px-6 py-4"><span class="px-2 py-1 text-[10px] font-bold uppercase bg-semantic-warning-bg text-semantic-warning rounded border border-semantic-warning/20">Restricted (KYC)</span></td>
                    <td class="px-6 py-4 text-body-sm">
                        <span class="flex items-center gap-1 text-semantic-success"><i data-lucide="check-circle" class="w-3 h-3"></i> Transfers Active</span>
                        <span class="flex items-center gap-1 text-semantic-error mt-1"><i data-lucide="x-circle" class="w-3 h-3"></i> Payouts Blocked</span>
                    </td>
                    <td class="px-6 py-4 text-right space-x-2">
                        <button class="btn btn-sm btn-secondary py-2 px-3 text-brand-primary border-brand-primary/30 hover:bg-brand-primary/10 transition-colors">Resend Onboarding</button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection