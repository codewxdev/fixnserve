@extends('layouts.app')
@section('title', 'Platform Payouts | Finance')
@section('content')
<div class="p-4 sm:p-6 lg:p-8 bg-bg-primary min-h-screen">
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-h3 font-bold text-text-primary">Platform Payouts</h1>
            <p class="text-body-sm text-text-secondary mt-1">Stripe Connect settlement routing and operations disbursements.</p>
        </div>
        <button class="btn btn-primary py-2.5 px-4 transition-colors shadow-sm"><i data-lucide="send" class="w-4 h-4 mr-2"></i> Trigger Manual Payout</button>
    </div>

    <div class="card p-6 bg-bg-tertiary border-border-default mb-8 flex flex-col md:flex-row items-center justify-between gap-4 text-center md:text-left">
        <div class="flex items-center gap-3"><i data-lucide="credit-card" class="w-6 h-6 text-text-tertiary"></i><span class="text-body-sm font-bold text-text-primary">Client Pays 100%</span></div>
        <i data-lucide="arrow-right" class="w-4 h-4 text-text-tertiary hidden md:block"></i>
        <div class="flex items-center gap-3"><i data-lucide="server" class="w-6 h-6 text-brand-primary"></i><span class="text-body-sm font-bold text-text-primary">Stripe Processes</span></div>
        <i data-lucide="arrow-right" class="w-4 h-4 text-text-tertiary hidden md:block"></i>
        <div class="flex items-center gap-3"><i data-lucide="store" class="w-6 h-6 text-semantic-success"></i><span class="text-body-sm font-bold text-text-primary">Business Connected Acct (97%)</span></div>
        <i data-lucide="arrow-right" class="w-4 h-4 text-text-tertiary hidden md:block"></i>
        <div class="flex items-center gap-3"><i data-lucide="landmark" class="w-6 h-6 text-purple-500"></i><span class="text-body-sm font-bold text-text-primary">Sahor One Stripe (3%)</span></div>
    </div>

    <div class="card p-0 shadow-sm border-border-default">
        <div class="p-5 border-b border-border-default bg-bg-tertiary flex justify-between items-center">
            <h3 class="text-h4 font-bold text-text-primary">Payout Queue</h3>
            <div class="flex gap-2">
                <span class="px-2 py-1 text-[10px] uppercase font-bold bg-semantic-warning-bg text-semantic-warning border border-semantic-warning/20 rounded">Dual Approval Required > $10K</span>
            </div>
        </div>
        <table class="w-full text-left whitespace-nowrap">
            <thead class="text-caption uppercase text-text-secondary font-semibold border-b border-border-strong bg-bg-primary">
                <tr>
                    <th class="px-6 py-4">Destination</th>
                    <th class="px-6 py-4">Amount</th>
                    <th class="px-6 py-4">Type</th>
                    <th class="px-6 py-4">Status & AI Risk</th>
                    <th class="px-6 py-4 text-right">Action</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-border-default">
                <tr class="hover:bg-bg-secondary transition-colors">
                    <td class="px-6 py-4 text-body-sm font-bold text-text-primary">CleanSweep UAE (Connected Acct)</td>
                    <td class="px-6 py-4 text-body-sm font-bold text-text-primary">AED 12,450.00</td>
                    <td class="px-6 py-4 text-caption text-text-secondary">Scheduled (Weekly)</td>
                    <td class="px-6 py-4">
                        <span class="flex items-center gap-1.5 text-semantic-warning text-[10px] font-bold uppercase"><i data-lucide="lock" class="w-3 h-3"></i> Awaiting Dual Approval</span>
                    </td>
                    <td class="px-6 py-4 text-right">
                        <button class="btn btn-sm btn-secondary text-brand-primary hover:bg-brand-primary/10 border-brand-primary/30 transition-colors py-2 px-3">Review & Sign</button>
                    </td>
                </tr>
                <tr class="hover:bg-bg-secondary transition-colors">
                    <td class="px-6 py-4 text-body-sm font-bold text-text-primary">FakeBiz Agency (B-998)</td>
                    <td class="px-6 py-4 text-body-sm font-bold text-text-primary">AED 8,000.00</td>
                    <td class="px-6 py-4 text-caption text-text-secondary">On-Demand Request</td>
                    <td class="px-6 py-4">
                        <span class="flex items-center gap-1.5 text-semantic-error text-[10px] font-bold uppercase"><i data-lucide="shield-alert" class="w-3 h-3"></i> AI Hold (Fraud Risk)</span>
                    </td>
                    <td class="px-6 py-4 text-right">
                        <button class="btn btn-sm btn-destructive py-2 px-3">Investigate</button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection