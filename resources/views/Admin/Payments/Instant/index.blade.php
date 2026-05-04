@extends('layouts.app')
@section('title', 'Instant Payouts | Payments')
@section('content')
<div class="p-4 sm:p-6 lg:p-8 bg-bg-primary min-h-screen">
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-h3 font-bold text-text-primary">Instant Payouts</h1>
            <p class="text-body-sm text-text-secondary mt-1">Manage 30-minute expedited transfers and tier-based limits.</p>
        </div>
    </div>

    <!-- Config & Revenue -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
        <div class="card p-5 border-border-default bg-bg-tertiary lg:col-span-2">
            <h3 class="text-body font-bold text-text-primary mb-3">Tier Daily Limits</h3>
            <div class="grid grid-cols-4 gap-4 text-center">
                <div class="p-3 border border-border-default rounded bg-bg-primary"><p class="text-caption text-text-secondary">Starter</p><p class="font-bold text-semantic-error mt-1 text-sm">Not Avail.</p></div>
                <div class="p-3 border border-border-default rounded bg-bg-primary"><p class="text-caption text-text-secondary">Growth</p><p class="font-bold text-text-primary mt-1 text-sm">$5,000</p></div>
                <div class="p-3 border border-border-default rounded bg-bg-primary"><p class="text-caption text-text-secondary">Scale</p><p class="font-bold text-text-primary mt-1 text-sm">$25,000</p></div>
                <div class="p-3 border border-border-default rounded bg-bg-primary"><p class="text-caption text-text-secondary">Enterprise</p><p class="font-bold text-brand-primary mt-1 text-sm">Custom</p></div>
            </div>
        </div>
        <div class="card p-5 flex flex-col justify-center text-center">
            <p class="text-caption font-bold text-text-tertiary uppercase tracking-wider mb-2">Revenue from Payout Fees (0.5%)</p>
            <h2 class="text-h2 font-black text-semantic-success">AED 14,200</h2>
            <p class="text-caption text-text-secondary mt-1">This Month</p>
        </div>
    </div>

    <!-- Payout Requests -->
    <div class="card p-0 shadow-sm border-border-default">
        <div class="p-5 border-b border-border-default bg-bg-primary">
            <h3 class="text-h4 font-bold text-text-primary">Instant Payout Ledger</h3>
        </div>
        <table class="w-full text-left whitespace-nowrap">
            <thead class="text-caption uppercase text-text-secondary font-semibold border-b border-border-strong bg-bg-tertiary">
                <tr>
                    <th class="px-6 py-4">Business</th>
                    <th class="px-6 py-4">Amount Requested</th>
                    <th class="px-6 py-4">Platform Fee (0.5%)</th>
                    <th class="px-6 py-4">Status</th>
                    <th class="px-6 py-4 text-right">Timestamp</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-border-default">
                <tr class="hover:bg-bg-secondary transition-colors">
                    <td class="px-6 py-4">
                        <p class="text-body-sm font-bold text-text-primary">Apex Legal (B-1026)</p>
                        <p class="text-[10px] text-brand-primary uppercase font-bold mt-0.5">Scale Tier</p>
                    </td>
                    <td class="px-6 py-4 text-body-sm font-bold text-text-primary">AED 12,000.00</td>
                    <td class="px-6 py-4 text-body-sm text-semantic-success font-bold">+ AED 60.00</td>
                    <td class="px-6 py-4"><span class="px-2 py-1 text-[10px] font-bold uppercase bg-semantic-success-bg text-semantic-success rounded border border-semantic-success/20">Transferred</span></td>
                    <td class="px-6 py-4 text-right text-caption text-text-secondary font-mono">10:45 AM (12 mins ago)</td>
                </tr>
                <tr class="hover:bg-bg-secondary transition-colors">
                    <td class="px-6 py-4">
                        <p class="text-body-sm font-bold text-text-primary">Elevate Digital (B-1024)</p>
                        <p class="text-[10px] text-text-secondary uppercase font-bold mt-0.5">Growth Tier</p>
                    </td>
                    <td class="px-6 py-4 text-body-sm font-bold text-semantic-error">AED 8,000.00</td>
                    <td class="px-6 py-4 text-body-sm text-text-tertiary">-</td>
                    <td class="px-6 py-4"><span class="px-2 py-1 text-[10px] font-bold uppercase bg-semantic-error-bg text-semantic-error rounded border border-semantic-error/20">Declined (Limit Exceeded)</span></td>
                    <td class="px-6 py-4 text-right text-caption text-text-secondary font-mono">09:12 AM</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection