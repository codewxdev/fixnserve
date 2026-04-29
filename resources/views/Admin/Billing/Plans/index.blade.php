@extends('layouts.app')
@section('title', 'Plan Management | Billing')
@section('content')
<div class="p-4 sm:p-6 lg:p-8 bg-bg-primary min-h-screen" x-data="{ configModal: false }">
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-h3 font-bold text-text-primary">Plan Management</h1>
            <p class="text-body-sm text-text-secondary mt-1">Manage subscription tiers, pricing, and global billing rules.</p>
        </div>
        <div class="flex gap-3">
            <button @click="configModal = true" class="btn btn-secondary px-4 py-2.5 transition-colors"><i data-lucide="settings" class="w-4 h-4 mr-2"></i> Global Config</button>
            <button class="btn btn-primary px-4 py-2.5 shadow-sm transition-colors"><i data-lucide="plus" class="w-4 h-4 mr-2"></i> Create Plan</button>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6 mb-8">
        <div class="card p-6 border-border-default hover:border-border-strong transition-all flex flex-col h-full relative">
            <div class="flex justify-between items-start mb-4">
                <div>
                    <h3 class="text-h4 font-bold text-text-primary">Starter</h3>
                    <p class="text-h2 font-black text-text-primary mt-2">$49<span class="text-body-sm text-text-secondary font-normal">/mo</span></p>
                </div>
                <span class="px-2 py-1 bg-semantic-success-bg text-semantic-success border border-semantic-success/20 text-[10px] uppercase font-bold rounded">Active</span>
            </div>
            <div class="space-y-3 mb-6 flex-1">
                <p class="text-body-sm text-text-secondary flex items-center gap-2"><i data-lucide="users" class="w-4 h-4 text-text-tertiary"></i> Up to 5 team members</p>
                <p class="text-body-sm text-text-secondary flex items-center gap-2"><i data-lucide="briefcase" class="w-4 h-4 text-text-tertiary"></i> 50 active jobs/mo</p>
                <p class="text-body-sm text-text-secondary flex items-center gap-2"><i data-lucide="credit-card" class="w-4 h-4 text-text-tertiary"></i> 3% Processing Fee</p>
            </div>
            <div class="pt-4 border-t border-border-default flex justify-between items-center">
                <div class="text-caption font-bold text-text-primary">450 <span class="text-text-secondary font-normal">Subscribers</span></div>
                <div class="flex gap-2">
                    <button class="text-text-tertiary hover:text-brand-primary p-1 transition-colors" title="Edit"><i data-lucide="edit-2" class="w-4 h-4"></i></button>
                    <button class="text-text-tertiary hover:text-semantic-warning p-1 transition-colors" title="Schedule Price Change"><i data-lucide="clock" class="w-4 h-4"></i></button>
                </div>
            </div>
        </div>

        <div class="card p-6 border-brand-primary/30 bg-brand-primary/5 hover:border-brand-primary transition-all flex flex-col h-full relative">
            <div class="absolute -top-3 left-1/2 -translate-x-1/2 bg-brand-primary text-white text-[10px] font-bold uppercase tracking-wider px-3 py-1 rounded-full">Most Popular</div>
            <div class="flex justify-between items-start mb-4">
                <div>
                    <h3 class="text-h4 font-bold text-brand-primary">Growth</h3>
                    <p class="text-h2 font-black text-text-primary mt-2">$129<span class="text-body-sm text-text-secondary font-normal">/mo</span></p>
                </div>
                <span class="px-2 py-1 bg-semantic-success-bg text-semantic-success border border-semantic-success/20 text-[10px] uppercase font-bold rounded">Active</span>
            </div>
            <div class="space-y-3 mb-6 flex-1">
                <p class="text-body-sm text-text-secondary flex items-center gap-2"><i data-lucide="users" class="w-4 h-4 text-text-tertiary"></i> Up to 20 team members</p>
                <p class="text-body-sm text-text-secondary flex items-center gap-2"><i data-lucide="briefcase" class="w-4 h-4 text-text-tertiary"></i> 250 active jobs/mo</p>
                <p class="text-body-sm text-text-secondary flex items-center gap-2"><i data-lucide="credit-card" class="w-4 h-4 text-text-tertiary"></i> 2.5% Processing Fee</p>
                <p class="text-body-sm text-text-secondary flex items-center gap-2"><i data-lucide="check" class="w-4 h-4 text-brand-primary"></i> API Access & Branding</p>
            </div>
            <div class="pt-4 border-t border-border-default flex justify-between items-center">
                <div class="text-caption font-bold text-text-primary">820 <span class="text-text-secondary font-normal">Subscribers</span></div>
                <div class="flex gap-2">
                    <button class="text-text-tertiary hover:text-brand-primary p-1 transition-colors" title="Edit"><i data-lucide="edit-2" class="w-4 h-4"></i></button>
                    <button class="text-text-tertiary hover:text-semantic-warning p-1 transition-colors" title="Schedule Price Change"><i data-lucide="clock" class="w-4 h-4"></i></button>
                </div>
            </div>
        </div>

        <div class="card p-6 border-border-default hover:border-border-strong transition-all flex flex-col h-full relative">
            <div class="flex justify-between items-start mb-4">
                <div>
                    <h3 class="text-h4 font-bold text-text-primary">Scale</h3>
                    <p class="text-h2 font-black text-text-primary mt-2">$249<span class="text-body-sm text-text-secondary font-normal">/mo</span></p>
                </div>
                <span class="px-2 py-1 bg-semantic-success-bg text-semantic-success border border-semantic-success/20 text-[10px] uppercase font-bold rounded">Active</span>
            </div>
            <div class="space-y-3 mb-6 flex-1">
                <p class="text-body-sm text-text-secondary flex items-center gap-2"><i data-lucide="users" class="w-4 h-4 text-text-tertiary"></i> Up to 50 team members</p>
                <p class="text-body-sm text-text-secondary flex items-center gap-2"><i data-lucide="briefcase" class="w-4 h-4 text-text-tertiary"></i> 1000 active jobs/mo</p>
                <p class="text-body-sm text-text-secondary flex items-center gap-2"><i data-lucide="credit-card" class="w-4 h-4 text-text-tertiary"></i> 2.2% Processing Fee</p>
                <p class="text-body-sm text-text-secondary flex items-center gap-2"><i data-lucide="check" class="w-4 h-4 text-brand-primary"></i> SSO & White-label</p>
            </div>
            <div class="pt-4 border-t border-border-default flex justify-between items-center">
                <div class="text-caption font-bold text-text-primary">145 <span class="text-text-secondary font-normal">Subscribers</span></div>
                <div class="flex gap-2">
                    <button class="text-text-tertiary hover:text-brand-primary p-1 transition-colors"><i data-lucide="edit-2" class="w-4 h-4"></i></button>
                </div>
            </div>
        </div>

        <div class="card p-6 border-border-default bg-bg-tertiary flex flex-col h-full relative">
            <div class="flex justify-between items-start mb-4">
                <div>
                    <h3 class="text-h4 font-bold text-text-primary">Enterprise</h3>
                    <p class="text-h3 font-black text-text-primary mt-3">Custom</p>
                </div>
                <span class="px-2 py-1 bg-bg-primary border border-border-strong text-text-secondary text-[10px] uppercase font-bold rounded">Contract</span>
            </div>
            <div class="space-y-3 mb-6 flex-1">
                <p class="text-body-sm text-text-secondary flex items-center gap-2"><i data-lucide="infinity" class="w-4 h-4 text-text-tertiary"></i> Unlimited everything</p>
                <p class="text-body-sm text-text-secondary flex items-center gap-2"><i data-lucide="server" class="w-4 h-4 text-text-tertiary"></i> On-premise option</p>
                <p class="text-body-sm text-text-secondary flex items-center gap-2"><i data-lucide="file-signature" class="w-4 h-4 text-text-tertiary"></i> Custom SLA</p>
            </div>
            <div class="pt-4 border-t border-border-default flex justify-between items-center">
                <div class="text-caption font-bold text-text-primary">12 <span class="text-text-secondary font-normal">Contracts</span></div>
                <button class="text-text-tertiary hover:text-brand-primary p-1 transition-colors"><i data-lucide="settings" class="w-4 h-4"></i></button>
            </div>
        </div>
    </div>

    <div x-show="configModal" class="fixed inset-0 z-50 flex items-center justify-center bg-brand-secondary/80 backdrop-blur-sm p-4" x-cloak>
        <div class="card w-full max-w-lg p-0 shadow-2xl" @click.away="configModal = false">
            <div class="p-5 border-b border-border-default bg-bg-tertiary flex justify-between items-center rounded-t-lg">
                <h3 class="text-h4 font-bold text-text-primary">Global Billing Configuration</h3>
                <button @click="configModal = false" class="text-text-tertiary"><i data-lucide="x" class="w-5 h-5"></i></button>
            </div>
            <div class="p-6 grid grid-cols-2 gap-6">
                <div class="form-group mb-0">
                    <label class="form-label">Base Currency</label>
                    <select class="form-input w-full"><option>AED</option><option>USD</option><option>GBP</option></select>
                </div>
                <div class="form-group mb-0">
                    <label class="form-label">Tax Handling (VAT %)</label>
                    <input type="number" value="5" class="form-input w-full">
                </div>
                <div class="form-group mb-0">
                    <label class="form-label">Trial Duration (Days)</label>
                    <select class="form-input w-full"><option>14 Days</option><option>0 Days (No Trial)</option></select>
                </div>
                <div class="form-group mb-0">
                    <label class="form-label">Grace Period (Days)</label>
                    <input type="number" value="5" class="form-input w-full">
                </div>
            </div>
            <div class="p-5 border-t border-border-default flex justify-end gap-3 rounded-b-lg bg-bg-tertiary">
                <button @click="configModal = false" class="btn btn-tertiary px-4 py-2">Cancel</button>
                <button @click="configModal = false" class="btn btn-primary px-4 py-2">Save Rules</button>
            </div>
        </div>
    </div>
</div>
@endsection