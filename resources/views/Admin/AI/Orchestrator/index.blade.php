@extends('Layouts.app')
@section('title', 'Decision Orchestrator | AI & Automation')
@section('content')
<div class="p-4 sm:p-6 lg:p-8 bg-bg-primary min-h-screen">
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-h3 font-bold text-text-primary">Decision Orchestrator</h1>
            <p class="text-body-sm text-text-secondary mt-1">The central brain routing platform signals to appropriate AI models.</p>
        </div>
        <div class="flex items-center gap-2">
            <span class="relative flex h-3 w-3"><span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-brand-primary opacity-75"></span><span class="relative inline-flex rounded-full h-3 w-3 bg-brand-primary"></span></span>
            <span class="text-caption font-bold text-text-primary uppercase tracking-wider">Orchestrator Active</span>
        </div>
    </div>

    <!-- Orchestrator Flow Visualization -->
    <div class="card p-8 bg-bg-tertiary border-border-default mb-8">
        <div class="flex flex-col lg:flex-row items-center justify-between gap-6">
            
            <!-- 1. Ingestion -->
            <div class="flex-1 w-full p-5 bg-bg-primary border border-border-strong rounded-lg text-center shadow-sm">
                <i data-lucide="satellite" class="w-8 h-8 mx-auto text-text-secondary mb-3"></i>
                <h4 class="text-body-sm font-bold text-text-primary">Signal Ingestion</h4>
                <p class="text-[10px] text-text-secondary mt-1">Streams from all 14 modules.</p>
            </div>
            
            <i data-lucide="arrow-right" class="w-6 h-6 text-brand-primary hidden lg:block"></i>
            <i data-lucide="arrow-down" class="w-6 h-6 text-brand-primary lg:hidden"></i>

            <!-- 2. Enrichment -->
            <div class="flex-1 w-full p-5 bg-bg-primary border border-brand-primary/30 rounded-lg text-center shadow-sm shadow-brand-primary/10">
                <i data-lucide="database" class="w-8 h-8 mx-auto text-brand-primary mb-3"></i>
                <h4 class="text-body-sm font-bold text-text-primary">Context Enrichment</h4>
                <p class="text-[10px] text-text-secondary mt-1">Appending historical & entity data.</p>
            </div>

            <i data-lucide="arrow-right" class="w-6 h-6 text-brand-primary hidden lg:block"></i>
            <i data-lucide="arrow-down" class="w-6 h-6 text-brand-primary lg:hidden"></i>

            <!-- 3. Selection & Scoring -->
            <div class="flex-1 w-full p-5 bg-brand-primary border border-brand-secondary rounded-lg text-center shadow-md">
                <i data-lucide="cpu" class="w-8 h-8 mx-auto text-white mb-3"></i>
                <h4 class="text-body-sm font-bold text-white">Model Selection & Scoring</h4>
                <p class="text-[10px] text-white/80 mt-1">Fraud, BI, or Ops routing.</p>
            </div>

            <i data-lucide="arrow-right" class="w-6 h-6 text-brand-primary hidden lg:block"></i>
            <i data-lucide="arrow-down" class="w-6 h-6 text-brand-primary lg:hidden"></i>

            <!-- 4. Action -->
            <div class="flex-1 w-full p-5 bg-bg-primary border border-semantic-success/30 rounded-lg text-center shadow-sm">
                <i data-lucide="zap" class="w-8 h-8 mx-auto text-semantic-success mb-3"></i>
                <h4 class="text-body-sm font-bold text-text-primary">Action Recommendation</h4>
                <p class="text-[10px] text-text-secondary mt-1">Rule engine or HITL queue.</p>
            </div>

        </div>
    </div>

    <!-- Live Routing Feed -->
    <div class="card p-0 shadow-sm border-border-default">
        <div class="p-5 border-b border-border-default bg-bg-primary">
            <h3 class="text-h4 font-bold text-text-primary">Live Routing Diagnostics</h3>
        </div>
        <table class="w-full text-left whitespace-nowrap font-mono text-[11px]">
            <thead class="text-caption uppercase text-text-secondary font-semibold border-b border-border-strong bg-bg-tertiary">
                <tr>
                    <th class="px-6 py-4">Ingested Signal</th>
                    <th class="px-6 py-4">Selected Model</th>
                    <th class="px-6 py-4">Confidence Score</th>
                    <th class="px-6 py-4 text-right">Recommended Action</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-border-default">
                <tr class="hover:bg-bg-secondary transition-colors">
                    <td class="px-6 py-4 text-text-primary">Stripe Webhook (Refund Volume Spike)</td>
                    <td class="px-6 py-4 text-semantic-error">Fraud: Refund Abuse Predictor</td>
                    <td class="px-6 py-4 text-text-primary">94.2%</td>
                    <td class="px-6 py-4 text-right"><span class="px-2 py-0.5 bg-semantic-warning-bg text-semantic-warning rounded">Queue for HITL</span></td>
                </tr>
                <tr class="hover:bg-bg-secondary transition-colors">
                    <td class="px-6 py-4 text-text-primary">Ticket Created (Billing Keyword)</td>
                    <td class="px-6 py-4 text-brand-primary">BI: Support Ticket Prioritization</td>
                    <td class="px-6 py-4 text-text-primary">88.9%</td>
                    <td class="px-6 py-4 text-right"><span class="px-2 py-0.5 bg-bg-muted text-text-secondary rounded border border-border-strong">Set Priority P2</span></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection