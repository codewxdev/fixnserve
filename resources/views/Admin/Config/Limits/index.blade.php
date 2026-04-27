@extends('layouts.app')
@section('title', 'Rate Limits')
@section('content')
<div class="p-4 sm:p-6 lg:p-8 bg-bg-primary min-h-screen">
    <div class="mb-6">
        <h1 class="text-h3 font-bold text-text-primary">14.6 Rate Limits & Throttling</h1>
        <p class="text-body-sm text-text-secondary mt-1">Control API abuse and webhook dispatch limits.</p>
    </div>

    <div class="card p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="form-group mb-0 border border-border-default p-4 rounded-lg bg-bg-secondary">
            <label class="form-label text-text-primary">Public API Limit</label>
            <div class="flex items-center gap-2">
                <input type="number" value="1000" class="form-input w-24 text-center font-mono">
                <span class="text-caption text-text-secondary">req / hour / token</span>
            </div>
        </div>
        
        <div class="form-group mb-0 border border-border-default p-4 rounded-lg bg-bg-secondary">
            <label class="form-label text-text-primary">Admin CP Limit</label>
            <div class="flex items-center gap-2">
                <input type="number" value="300" class="form-input w-24 text-center font-mono">
                <span class="text-caption text-text-secondary">req / hour / admin (IP)</span>
            </div>
        </div>

        <div class="form-group mb-0 border border-border-default p-4 rounded-lg bg-bg-secondary">
            <label class="form-label text-text-primary">Webhook Dispatch Throttle</label>
            <div class="flex items-center gap-2">
                <input type="number" value="10" class="form-input w-24 text-center font-mono">
                <span class="text-caption text-text-secondary">events / sec / endpoint</span>
            </div>
        </div>

        <div class="form-group mb-0 border border-border-default p-4 rounded-lg bg-bg-secondary">
            <label class="form-label text-text-primary">Burst Limit Allowances</label>
            <select class="form-input w-full">
                <option>+20% tolerance for 60s</option>
                <option>Strict (No Bursting)</option>
            </select>
        </div>
    </div>
</div>
@endsection