@extends('Layouts.app')
@section('title', 'Transaction Fraud | Fraud')
@section('content')
<div class="p-4 sm:p-6 lg:p-8 bg-bg-primary min-h-screen">
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-h3 font-bold text-text-primary">Transaction Fraud Monitoring</h1>
            <p class="text-body-sm text-text-secondary mt-1">Identify card testing, chargeback clusters, and synthetic identity attempts.</p>
        </div>
        <button class="btn btn-secondary py-2.5 px-4"><i data-lucide="download" class="w-4 h-4 mr-2"></i> Export Fraud Report</button>
    </div>

    <!-- Active Patterns -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="card p-5 bg-bg-tertiary">
            <h3 class="text-body-sm font-bold text-text-primary flex items-center gap-2"><i data-lucide="credit-card" class="w-4 h-4 text-semantic-error"></i> Card Testing Drops</h3>
            <p class="text-caption text-text-secondary mt-2">Multiple small amounts ($1-$2) failing rapidly.</p>
            <div class="mt-4 flex justify-between items-end">
                <span class="text-h3 font-black text-semantic-error">12</span>
                <span class="text-[10px] uppercase font-bold text-text-tertiary">Live Attempts</span>
            </div>
        </div>
        <div class="card p-5 bg-bg-tertiary">
            <h3 class="text-body-sm font-bold text-text-primary flex items-center gap-2"><i data-lucide="corner-up-left" class="w-4 h-4 text-semantic-warning"></i> Chargeback Clusters</h3>
            <p class="text-caption text-text-secondary mt-2">Multiple disputes filed against a single business.</p>
            <div class="mt-4 flex justify-between items-end">
                <span class="text-h3 font-black text-semantic-warning">3</span>
                <span class="text-[10px] uppercase font-bold text-text-tertiary">Businesses Flagged</span>
            </div>
        </div>
        <div class="card p-5 bg-bg-tertiary">
            <h3 class="text-body-sm font-bold text-text-primary flex items-center gap-2"><i data-lucide="users" class="w-4 h-4 text-purple-500"></i> Synthetic Identities</h3>
            <p class="text-caption text-text-secondary mt-2">Mismatched billing info across multiple accounts.</p>
            <div class="mt-4 flex justify-between items-end">
                <span class="text-h3 font-black text-purple-500">1</span>
                <span class="text-[10px] uppercase font-bold text-text-tertiary">Review Needed</span>
            </div>
        </div>
    </div>

    <!-- Live Transaction Queue -->
    <div class="card p-0 shadow-sm border-border-default">
        <div class="p-5 border-b border-border-default bg-bg-primary">
            <h3 class="text-h4 font-bold text-text-primary">Flagged Transactions (Awaiting Review)</h3>
        </div>
        <table class="w-full text-left whitespace-nowrap">
            <thead class="text-caption uppercase text-text-secondary font-semibold border-b border-border-strong bg-bg-tertiary">
                <tr>
                    <th class="px-6 py-4">Transaction ID</th>
                    <th class="px-6 py-4">Business</th>
                    <th class="px-6 py-4">Pattern Detected</th>
                    <th class="px-6 py-4 text-right">Recommended Action</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-border-default">
                <tr class="hover:bg-bg-secondary transition-colors">
                    <td class="px-6 py-4 font-mono text-body-sm font-bold text-text-primary">TXN-49X8...</td>
                    <td class="px-6 py-4 text-body-sm text-text-secondary">FakeServices (B-199)</td>
                    <td class="px-6 py-4 text-caption"><span class="text-semantic-error font-bold">Stolen Card Indicator</span> (BIN mismatch)</td>
                    <td class="px-6 py-4 text-right space-x-2">
                        <button class="btn btn-sm btn-secondary text-brand-primary border-brand-primary/30 hover:bg-brand-primary/10 transition-colors py-1.5">Verify Further</button>
                        <button class="btn btn-sm btn-destructive py-1.5 px-3">Block Processing</button>
                    </td>
                </tr>
                <tr class="hover:bg-bg-secondary transition-colors">
                    <td class="px-6 py-4 font-mono text-body-sm font-bold text-text-primary">TXN-882P...</td>
                    <td class="px-6 py-4 text-body-sm text-text-secondary">HomeCleaners (B-402)</td>
                    <td class="px-6 py-4 text-caption"><span class="text-semantic-warning font-bold">Friendly Fraud</span> (3rd repeat purchase after chargeback)</td>
                    <td class="px-6 py-4 text-right space-x-2">
                        <button class="btn btn-sm btn-secondary text-semantic-warning border-semantic-warning/30 hover:bg-semantic-warning/10 transition-colors py-1.5">Temp Limit</button>
                        <button class="btn btn-sm btn-secondary py-1.5 px-3 hover:bg-bg-tertiary">Flag for Manual</button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection