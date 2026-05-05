@extends('Layouts.app')
@section('title', 'Dispute Categories | Disputes')
@section('content')
<div class="p-4 sm:p-6 lg:p-8 bg-bg-primary min-h-screen">
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-h3 font-bold text-text-primary">Dispute Categories (B2B)</h1>
            <p class="text-body-sm text-text-secondary mt-1">Configure dispute classification and routing rules for business conflicts.</p>
        </div>
        <button class="btn btn-primary py-2.5 px-4 shadow-sm transition-colors"><i data-lucide="plus" class="w-4 h-4 mr-2"></i> Add Category</button>
    </div>

    <!-- Category Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        
        <div class="card p-6">
            <div class="flex justify-between items-start mb-3">
                <h3 class="text-body-sm font-bold text-text-primary">Subscription Billing</h3>
                <span class="px-2 py-0.5 text-[10px] uppercase font-bold bg-semantic-success-bg text-semantic-success rounded">Active</span>
            </div>
            <p class="text-caption text-text-secondary mb-4">Disputes regarding monthly/annual tier charges or prorated billing.</p>
            <div class="flex items-center gap-2 text-caption font-bold text-text-tertiary">
                <i data-lucide="corner-down-right" class="w-3 h-3"></i> Routed to: Billing Support
            </div>
        </div>

        <div class="card p-6">
            <div class="flex justify-between items-start mb-3">
                <h3 class="text-body-sm font-bold text-text-primary">Chargeback Allocation</h3>
                <span class="px-2 py-0.5 text-[10px] uppercase font-bold bg-semantic-success-bg text-semantic-success rounded">Active</span>
            </div>
            <p class="text-caption text-text-secondary mb-4">Stripe disputes flowing through to the business connected account.</p>
            <div class="flex items-center gap-2 text-caption font-bold text-text-tertiary">
                <i data-lucide="corner-down-right" class="w-3 h-3"></i> Routed to: Finance Team
            </div>
        </div>

        <div class="card p-6">
            <div class="flex justify-between items-start mb-3">
                <h3 class="text-body-sm font-bold text-text-primary">Data Access (GDPR)</h3>
                <span class="px-2 py-0.5 text-[10px] uppercase font-bold bg-semantic-warning-bg text-semantic-warning rounded">Priority</span>
            </div>
            <p class="text-caption text-text-secondary mb-4">SAR (Subject Access Requests) or right-to-be-forgotten disputes.</p>
            <div class="flex items-center gap-2 text-caption font-bold text-text-tertiary">
                <i data-lucide="corner-down-right" class="w-3 h-3"></i> Routed to: Legal / Compliance
            </div>
        </div>

        <div class="card p-6">
            <div class="flex justify-between items-start mb-3">
                <h3 class="text-body-sm font-bold text-text-primary">Commission Calculation</h3>
                <span class="px-2 py-0.5 text-[10px] uppercase font-bold bg-semantic-success-bg text-semantic-success rounded">Active</span>
            </div>
            <p class="text-caption text-text-secondary mb-4">Disputes regarding the 3% platform fee application.</p>
            <div class="flex items-center gap-2 text-caption font-bold text-text-tertiary">
                <i data-lucide="corner-down-right" class="w-3 h-3"></i> Routed to: Finance Team
            </div>
        </div>

    </div>
</div>
@endsection