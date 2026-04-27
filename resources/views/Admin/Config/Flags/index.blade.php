@extends('layouts.app')
@section('title', 'Feature Flags | Configuration')
@section('content')
<div class="p-4 sm:p-6 lg:p-8 bg-bg-primary min-h-screen" x-data="{ flags: [
    { id: 1, key: 'new_dashboard_ui', type: 'Percentage Rollout', status: 'Active', value: '25%' },
    { id: 2, key: 'video_consultations', type: 'User Segment', status: 'Active', value: 'Consultant Tier' },
    { id: 3, key: 'whatsapp_integration', type: 'Region Based', status: 'Paused', value: 'UAE Only' }
]}">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-h3 font-bold text-text-primary">14.2 Feature Flags</h1>
            <p class="text-body-sm text-text-secondary mt-1">Manage canary releases and feature rollouts.</p>
        </div>
        <button class="btn btn-primary p-2"><i data-lucide="plus" class="w-4 h-4 mr-2"></i> Create Flag</button>
    </div>

    <div class="space-y-4">
        <template x-for="flag in flags" :key="flag.id">
            <div class="card p-5 flex flex-col md:flex-row justify-between gap-4">
                <div>
                    <div class="flex items-center gap-2 mb-1">
                        <span class="font-mono text-body-sm font-bold text-text-primary" x-text="flag.key"></span>
                        <span class="px-2 py-0.5 rounded text-[10px] font-bold border bg-bg-tertiary text-text-secondary border-border-strong uppercase" x-text="flag.type"></span>
                    </div>
                    <p class="text-caption text-text-secondary mt-2">Current Rule: <strong class="text-text-primary" x-text="flag.value"></strong></p>
                </div>
                <div class="flex items-center gap-3 shrink-0">
                    <button class="btn btn-sm btn-secondary" title="Gradual Rollout Controls"><i data-lucide="sliders" class="w-4 h-4"></i></button>
                    <button class="btn btn-sm btn-destructive" title="Instant Kill Switch"><i data-lucide="power-off" class="w-4 h-4 mr-2"></i> Kill Switch</button>
                </div>
            </div>
        </template>
    </div>
</div>
@endsection