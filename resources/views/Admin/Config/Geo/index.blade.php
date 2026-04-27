@extends('layouts.app')
@section('title', 'Geo Configuration')
@section('content')
<div class="p-4 sm:p-6 lg:p-8 bg-bg-primary min-h-screen">
    <div class="mb-6">
        <h1 class="text-h3 font-bold text-text-primary">14.5 Geo Configuration</h1>
        <p class="text-body-sm text-text-secondary mt-1">Maps, routing engines, and service boundaries.</p>
    </div>

    <div class="card p-6 space-y-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="form-group mb-0">
                <label class="form-label">Map Provider</label>
                <select class="form-input w-full">
                    <option>Google Maps Enterprise</option>
                    <option>Mapbox</option>
                </select>
            </div>
            <div class="form-group mb-0">
                <label class="form-label">Distance Calculation Mode</label>
                <select class="form-input w-full">
                    <option>Driving Routing (High Accuracy)</option>
                    <option>Haversine (Straight Line)</option>
                </select>
            </div>
        </div>

        <div class="pt-6 border-t border-border-default space-y-4">
            <h3 class="text-body-sm font-bold text-text-primary">Geo-Fencing Rules</h3>
            <div class="form-group mb-0 max-w-sm">
                <label class="form-label">Max Service Radius Limit (KM)</label>
                <input type="number" value="100" class="form-input w-full">
            </div>
            <label class="flex items-center gap-3 pt-2">
                <input type="checkbox" checked class="w-4 h-4 rounded text-brand-primary">
                <span class="text-body-sm font-bold text-text-primary">Enforce Strict Restricted Zones Validation</span>
            </label>
        </div>
    </div>
</div>
@endsection