@extends('Layouts.app')
@section('title', 'Financial Audit | Compliance')
@section('content')
<div class="p-4 sm:p-6 lg:p-8 bg-bg-primary min-h-screen">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
        <div>
            <h1 class="text-h3 font-bold text-text-primary">Financial Audit & Reconciliation</h1>
            <p class="text-body-sm text-text-secondary mt-1">Court-grade evidence tracking across ledger entries, wallets, and taxes.</p>
        </div>
        <button class="btn btn-primary py-2.5 px-4 shadow-sm transition-colors"><i data-lucide="scale" class="w-4 h-4 mr-2"></i> Generate Court-Grade Export</button>
    </div>

    <!-- Snapshot Control -->
    <div class="card p-6 border-border-default mb-8 bg-bg-tertiary flex flex-col md:flex-row justify-between items-center gap-4">
        <div>
            <h3 class="text-body-sm font-bold text-text-primary">Reconciliation Snapshots</h3>
            <p class="text-caption text-text-secondary mt-1">Daily, weekly, and monthly states for cross-module linking.</p>
        </div>
        <div class="flex gap-2">
            <select class="form-input text-sm"><option>May 2026</option><option>April 2026</option></select>
            <button class="btn btn-secondary py-2 px-4 text-brand-primary border-brand-primary/30">View Snapshot</button>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="card p-5">
            <h3 class="text-body-sm font-bold text-text-primary flex items-center gap-2"><i data-lucide="book-open" class="w-4 h-4 text-semantic-success"></i> Ledger Immutability</h3>
            <p class="text-caption text-text-secondary mt-2">Zero modified or deleted records detected in financial ledger.</p>
            <p class="text-[10px] font-mono text-text-tertiary mt-3">Last Verified: 10 mins ago</p>
        </div>
        <div class="card p-5">
            <h3 class="text-body-sm font-bold text-text-primary flex items-center gap-2"><i data-lucide="link" class="w-4 h-4 text-brand-primary"></i> Cross-Module Links</h3>
            <p class="text-caption text-text-secondary mt-2">100% of ledger entries map perfectly to Stripe transaction IDs.</p>
            <p class="text-[10px] font-mono text-text-tertiary mt-3">Sync Status: Healthy</p>
        </div>
        <div class="card p-5">
            <h3 class="text-body-sm font-bold text-text-primary flex items-center gap-2"><i data-lucide="file-check-2" class="w-4 h-4 text-purple-500"></i> Tax Collection (VAT)</h3>
            <p class="text-caption text-text-secondary mt-2">All VAT records match invoice generation timestamps securely.</p>
            <p class="text-[10px] font-mono text-text-tertiary mt-3">FTA Format Ready</p>
        </div>
    </div>
</div>
@endsection