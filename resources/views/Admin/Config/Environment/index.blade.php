@extends('layouts.app')
@section('title', 'Environment Configuration')
@section('content')
<div class="p-4 sm:p-6 lg:p-8 bg-bg-primary min-h-screen">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-h3 font-bold text-text-primary">14.3 Environment Configuration</h1>
            <p class="text-body-sm text-text-secondary mt-1">Manage specific environment variables and endpoints.</p>
        </div>
        <select class="form-input bg-bg-secondary w-48">
            <option>Production</option>
            <option>Staging</option>
            <option>Development</option>
            <option>Sandbox</option>
        </select>
    </div>

    <div class="card p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="form-group mb-0">
            <label class="form-label">Public API Endpoint</label>
            <input type="text" value="https://api.sahorone.com/v1" class="form-input w-full font-mono">
        </div>
        <div class="form-group mb-0">
            <label class="form-label">Webhook Ingestion URL</label>
            <input type="text" value="https://webhooks.sahorone.com/ingest" class="form-input w-full font-mono">
        </div>
        <div class="form-group mb-0">
            <label class="form-label">Credential Scopes</label>
            <select class="form-input w-full">
                <option>Live Data Only (Strict)</option>
                <option>Mixed Mode</option>
            </select>
        </div>
        <div class="form-group mb-0">
            <label class="form-label">Debug & Logging Level</label>
            <select class="form-input w-full">
                <option value="error">Error Only</option>
                <option value="warn">Warn & Error</option>
                <option value="debug">Verbose / Debug</option>
            </select>
        </div>
    </div>
</div>
@endsection