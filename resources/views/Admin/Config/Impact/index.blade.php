@extends('layouts.app')
@section('title', 'AI Impact Analysis')
@section('content')
<div class="p-4 sm:p-6 lg:p-8 bg-bg-primary min-h-screen" x-data="{ isAnalyzing: false, results: false }">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-h3 font-bold text-text-primary">14.8 AI Impact Analysis</h1>
            <p class="text-body-sm text-text-secondary mt-1">Predict blast radius and dependencies before deploying config changes.</p>
        </div>
        <button class="btn btn-primary p-2" @click="isAnalyzing = true; setTimeout(() => { isAnalyzing = false; results = true; }, 1500)" :disabled="isAnalyzing">
            <i data-lucide="bot" class="w-4 h-4 mr-2" x-show="!isAnalyzing"></i>
            <i data-lucide="loader-2" class="w-4 h-4 mr-2 animate-spin" x-show="isAnalyzing" x-cloak></i>
            <span x-text="isAnalyzing ? 'Analyzing Dependency Graph...' : 'Run Analysis on Staged Changes'"></span>
        </button>
    </div>

    <div x-show="!results && !isAnalyzing" class="card p-12 flex flex-col items-center justify-center text-center">
        <i data-lucide="git-merge" class="w-12 h-12 text-text-tertiary mb-4"></i>
        <h3 class="text-h4 font-bold text-text-primary">No Analysis Run Yet</h3>
        <p class="text-body-sm text-text-secondary mt-1">Run the AI analyzer to generate a safety score for your staged configuration changes.</p>
    </div>

    <div x-show="results" class="space-y-6" x-cloak>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="card p-6 text-center">
                <p class="text-caption text-text-secondary uppercase font-bold mb-2">Blast Radius Risk Score</p>
                <p class="text-display-md font-black text-semantic-success">12<span class="text-body-sm text-text-tertiary">/100</span></p>
            </div>
            <div class="card p-6 text-center">
                <p class="text-caption text-text-secondary uppercase font-bold mb-2">Affected Modules</p>
                <p class="text-display-sm font-bold text-text-primary mt-1">2</p>
                <p class="text-caption text-text-tertiary mt-1">Analytics, Payments</p>
            </div>
            <div class="card p-6 text-center">
                <p class="text-caption text-text-secondary uppercase font-bold mb-2">Estimated User Impact</p>
                <p class="text-display-sm font-bold text-text-primary mt-1">0 <span class="text-caption font-normal">Users</span></p>
            </div>
        </div>

        <div class="card p-6">
            <h3 class="text-h4 font-bold text-text-primary mb-4 border-b border-border-default pb-3">AI Rollout Recommendation</h3>
            <div class="bg-semantic-success-bg border border-semantic-success/30 p-4 rounded-lg flex gap-3 items-start">
                <i data-lucide="check-circle" class="w-5 h-5 text-semantic-success shrink-0 mt-0.5"></i>
                <div>
                    <h4 class="text-body-sm font-bold text-semantic-success">Safe for Immediate Deployment</h4>
                    <p class="text-body-sm text-text-primary mt-1">The proposed changes to the Rate Limits configuration do not intersect with any active database migrations or feature flags. Dependency graph analysis shows zero impact on core billing systems.</p>
                    <button class="btn btn-sm btn-primary mt-4">Confirm & Deploy to Production</button>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('alpine:init', () => {
        // Alpine data handled inline above for brevity
        setTimeout(() => lucide.createIcons(), 50);
    });
</script>
@endpush
@endsection