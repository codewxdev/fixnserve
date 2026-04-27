@extends('layouts.app')
@section('title', 'Localization')
@section('content')
<div class="p-4 sm:p-6 lg:p-8 bg-bg-primary min-h-screen">
    <div class="mb-6">
        <h1 class="text-h3 font-bold text-text-primary">14.4 Localization</h1>
        <p class="text-body-sm text-text-secondary mt-1">Language packs, currency formatting, and RTL configurations.</p>
    </div>

    <div class="card p-6 space-y-6">
        <div>
            <h3 class="text-body-sm font-bold text-text-primary mb-3">Active Language Packs</h3>
            <div class="grid grid-cols-2 md:grid-cols-3 gap-3">
                <label class="flex items-center gap-2 p-3 border border-brand-primary rounded bg-brand-primary/5">
                    <input type="checkbox" checked disabled class="rounded text-brand-primary"> English (Primary)
                </label>
                <label class="flex items-center gap-2 p-3 border border-border-default rounded">
                    <input type="checkbox" checked class="rounded text-brand-primary"> Arabic (UAE)
                </label>
                <label class="flex items-center gap-2 p-3 border border-border-default rounded">
                    <input type="checkbox" checked class="rounded text-brand-primary"> Urdu (Pakistan)
                </label>
                <label class="flex items-center gap-2 p-3 border border-border-default rounded">
                    <input type="checkbox" checked class="rounded text-brand-primary"> Hindi (India)
                </label>
                <label class="flex items-center gap-2 p-3 border border-border-default rounded">
                    <input type="checkbox" checked class="rounded text-brand-primary"> Filipino (Philippines)
                </label>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 pt-4 border-t border-border-default">
            <div class="form-group mb-0">
                <label class="form-label">Date/Time Format</label>
                <select class="form-input w-full font-mono">
                    <option>DD/MM/YYYY HH:mm</option>
                    <option>YYYY-MM-DD HH:mm</option>
                </select>
            </div>
            <div class="pt-6">
                <label class="flex items-center gap-3">
                    <input type="checkbox" checked class="w-4 h-4 rounded text-brand-primary">
                    <span class="text-body-sm font-bold text-text-primary">Enforce RTL Layout for Arabic</span>
                </label>
            </div>
        </div>
    </div>
</div>
@endsection