@extends('layouts.app')
@section('title', 'Immutable Revenue Ledger | Finance')
@section('content')
<div class="p-4 sm:p-6 lg:p-8 bg-bg-primary min-h-screen" x-data="revenueLedger()">
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-h3 font-bold text-text-primary flex items-center gap-2">
                <i data-lucide="book-open" class="w-6 h-6 text-brand-primary"></i> Immutable Revenue Ledger
            </h1>
            <p class="text-body-sm text-text-secondary mt-1">Double-entry accounting, append-only records, 7-year retention enforced.</p>
        </div>
        <button class="btn btn-secondary py-2.5 px-4 transition-colors"><i data-lucide="download" class="w-4 h-4 mr-2"></i> Export Audit Bundle</button>
    </div>

    <div class="mb-6 bg-semantic-warning-bg/40 border border-semantic-warning/30 rounded-lg p-4 flex items-start gap-3">
        <i data-lucide="activity" class="w-5 h-5 text-semantic-warning shrink-0 mt-0.5"></i>
        <div>
            <p class="text-body-sm font-bold text-text-primary">AI Revenue Anomaly Detected</p>
            <p class="text-caption text-text-secondary mt-1">Subscription revenue shows a 14% drop in the last 24 hours compared to the 30-day moving average. Investigating failed renewals.</p>
        </div>
    </div>

    <div class="card p-0 overflow-hidden shadow-sm">
        <div class="p-5 bg-bg-tertiary border-b border-border-default flex justify-between items-center">
            <div class="flex items-center gap-4 w-full max-w-2xl">
                <input type="text" placeholder="Search Transaction ID, Business ID, Job ID..." class="form-input w-full text-body-sm bg-bg-primary">
                <select class="form-input w-48 text-body-sm bg-bg-primary"><option>All Events</option><option>Subscription</option><option>Job Completion</option></select>
            </div>
        </div>
        <div class="overflow-x-auto custom-scrollbar">
            <table class="w-full text-left whitespace-nowrap min-w-[1000px]">
                <thead class="text-caption uppercase text-text-secondary font-semibold border-b border-border-strong bg-bg-primary">
                    <tr>
                        <th class="px-6 py-4">Transaction Details</th>
                        <th class="px-6 py-4">Debit Account</th>
                        <th class="px-6 py-4">Credit Account</th>
                        <th class="px-6 py-4 text-right">Amount (AED)</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-border-default font-mono text-[11px]">
                    <tr class="hover:bg-bg-secondary transition-colors">
                        <td class="px-6 py-4">
                            <p class="text-text-primary font-bold">TXN-998A2B1C</p>
                            <p class="text-text-secondary">Source: Subscription Payment (B-1024)</p>
                            <p class="text-text-tertiary">Oct 26, 2026 14:32:11</p>
                        </td>
                        <td class="px-6 py-4 text-semantic-error">Business Stripe Account (B-1024)</td>
                        <td class="px-6 py-4 text-semantic-success">Sahor One Revenue Account</td>
                        <td class="px-6 py-4 text-right font-bold text-text-primary">129.00</td>
                    </tr>
                    <tr class="hover:bg-bg-secondary transition-colors">
                        <td class="px-6 py-4">
                            <p class="text-text-primary font-bold">TXN-442X9Z8Y</p>
                            <p class="text-text-secondary">Source: Job Completion (J-5092, B-1088)</p>
                            <p class="text-text-tertiary">Oct 26, 2026 14:30:05</p>
                        </td>
                        <td class="px-6 py-4 text-semantic-error">Client (External Card)</td>
                        <td class="px-6 py-4">
                            <p class="text-semantic-success">Business Account (97%)</p>
                            <p class="text-semantic-success mt-1">Sahor One Commission (3%)</p>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <p class="font-bold text-text-primary">485.00</p>
                            <p class="text-brand-primary mt-1">15.00</p>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection