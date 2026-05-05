@extends('Layouts.app')
@section('title', 'AI Support Assistant | Support')
@section('content')
<div class="p-4 sm:p-6 lg:p-8 bg-bg-primary min-h-screen">
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-h3 font-bold text-text-primary">AI Assistant Controls</h1>
            <p class="text-body-sm text-text-secondary mt-1">Manage AI reply generation, sentiment thresholds, and override tracking.</p>
        </div>
        <div class="flex items-center gap-2">
            <span class="text-caption font-bold text-text-secondary">Global AI Status:</span>
            <div class="w-10 h-5 bg-semantic-success rounded-full relative cursor-pointer"><div class="w-4 h-4 bg-white rounded-full absolute right-0.5 top-0.5"></div></div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- AI Capabilities Config -->
        <div class="card p-0 shadow-sm border-border-default">
            <div class="p-5 border-b border-border-default bg-bg-tertiary">
                <h3 class="text-h4 font-bold text-text-primary flex items-center gap-2"><i data-lucide="bot" class="w-5 h-5 text-brand-primary"></i> Assistant Capabilities</h3>
            </div>
            <div class="p-6 space-y-4">
                <label class="flex items-start gap-3 p-3 border border-border-default rounded-lg cursor-pointer hover:bg-bg-secondary transition-colors">
                    <input type="checkbox" checked class="mt-1 w-4 h-4 text-brand-primary border-border-strong rounded focus:ring-brand-primary">
                    <div>
                        <p class="text-body-sm font-bold text-text-primary">Auto-Suggest Replies</p>
                        <p class="text-caption text-text-secondary mt-0.5">Generate draft responses based on KB and past tickets. (Requires Human Approval)</p>
                    </div>
                </label>
                <label class="flex items-start gap-3 p-3 border border-border-default rounded-lg cursor-pointer hover:bg-bg-secondary transition-colors">
                    <input type="checkbox" checked class="mt-1 w-4 h-4 text-brand-primary border-border-strong rounded focus:ring-brand-primary">
                    <div>
                        <p class="text-body-sm font-bold text-text-primary">Sentiment Analysis & Priority Escalation</p>
                        <p class="text-caption text-text-secondary mt-0.5">Automatically upgrade ticket priority if client language becomes hostile or urgent.</p>
                    </div>
                </label>
                <label class="flex items-start gap-3 p-3 border border-border-default rounded-lg cursor-pointer hover:bg-bg-secondary transition-colors">
                    <input type="checkbox" checked class="mt-1 w-4 h-4 text-brand-primary border-border-strong rounded focus:ring-brand-primary">
                    <div>
                        <p class="text-body-sm font-bold text-text-primary">SLA Breach Prediction</p>
                        <p class="text-caption text-text-secondary mt-0.5">Flag tickets likely to miss SLA based on complexity and agent workload.</p>
                    </div>
                </label>
            </div>
        </div>

        <!-- AI Performance & Overrides -->
        <div class="space-y-6">
            <div class="card p-5 border-border-default flex items-center justify-between">
                <div>
                    <p class="text-caption font-bold text-text-tertiary uppercase">AI Reply Acceptance Rate</p>
                    <p class="text-h2 font-black text-text-primary mt-1">78.4%</p>
                    <p class="text-[10px] text-text-secondary mt-1">Replies sent without agent edits.</p>
                </div>
                <div class="w-16 h-16 rounded-full border-4 border-semantic-success border-l-bg-muted"></div>
            </div>

            <div class="card p-0 shadow-sm border-border-default">
                <div class="p-5 border-b border-border-default bg-bg-tertiary">
                    <h3 class="text-body font-bold text-text-primary">Recent Agent Overrides (Audit)</h3>
                </div>
                <div class="p-4 space-y-3">
                    <div class="text-caption border-b border-border-default pb-3">
                        <p class="font-bold text-text-primary">Agent 'Sarah' completely rewrote AI suggestion for #4492.</p>
                        <p class="text-text-secondary mt-1">AI Confidence was 45%. Triggered model retraining loop.</p>
                    </div>
                    <div class="text-caption">
                        <p class="font-bold text-text-primary">Agent 'Mark' rejected AI priority escalation for #4410.</p>
                        <p class="text-text-secondary mt-1">Downgraded from P1 to P3.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection