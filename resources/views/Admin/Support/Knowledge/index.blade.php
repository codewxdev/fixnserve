@extends('layouts.app')
@section('title', 'Knowledge Base | Support')
@section('content')
<div class="p-4 sm:p-6 lg:p-8 bg-bg-primary min-h-screen">
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-h3 font-bold text-text-primary">Knowledge Base Management</h1>
            <p class="text-body-sm text-text-secondary mt-1">Manage FAQs, internal guides, and API documentation.</p>
        </div>
        <button class="btn btn-primary py-2.5 px-4 shadow-sm transition-colors"><i data-lucide="plus" class="w-4 h-4 mr-2"></i> Create Article</button>
    </div>

    <div class="flex gap-4 mb-6">
        <input type="text" placeholder="Search articles (AI Assisted)..." class="form-input w-full max-w-md text-sm">
        <select class="form-input text-sm w-40"><option>External (Public)</option><option>Internal Only</option></select>
    </div>

    <!-- Article List -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <div class="card p-6 border-border-default flex flex-col">
            <div class="flex justify-between items-start mb-3">
                <span class="px-2 py-0.5 text-[10px] uppercase font-bold bg-semantic-success-bg text-semantic-success rounded">Public</span>
                <span class="text-caption text-text-secondary flex items-center gap-1"><i data-lucide="thumbs-up" class="w-3 h-3 text-brand-primary"></i> 98%</span>
            </div>
            <h3 class="text-body font-bold text-text-primary mb-2">How to handle a Chargeback</h3>
            <p class="text-caption text-text-secondary mb-4 line-clamp-2">Step by step guide on submitting evidence to Stripe via your connected Sahor One dashboard.</p>
            <div class="mt-auto pt-4 border-t border-border-default flex justify-between items-center">
                <span class="text-[10px] text-text-tertiary">v2.1 • Updated 3d ago</span>
                <button class="text-brand-primary hover:underline text-caption font-bold">Edit</button>
            </div>
        </div>

        <div class="card p-6 bg-semantic-warning/5 flex flex-col">
            <div class="flex justify-between items-start mb-3">
                <span class="px-2 py-0.5 text-[10px] uppercase font-bold bg-semantic-warning text-white rounded shadow-sm">Internal Only</span>
            </div>
            <h3 class="text-body font-bold text-text-primary mb-2">Troubleshooting Redis Latency</h3>
            <p class="text-caption text-text-secondary mb-4 line-clamp-2">Agent guide for diagnosing cache misses and Predis NOAUTH errors for Scale tier clients.</p>
            <div class="mt-auto pt-4 border-t border-border-default flex justify-between items-center">
                <span class="text-[10px] text-text-tertiary">v1.0 • Updated 1mo ago</span>
                <button class="text-brand-primary hover:underline text-caption font-bold">Edit</button>
            </div>
        </div>
    </div>
</div>
@endsection