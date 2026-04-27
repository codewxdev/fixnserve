@extends('layouts.app')
@section('title', 'Global Settings | Configuration')
@section('content')
<div class="p-4 sm:p-6 lg:p-8 bg-bg-primary min-h-screen" x-data="{ isSaving: false }">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-h3 font-bold text-text-primary">14.1 Global Settings</h1>
            <p class="text-body-sm text-text-secondary mt-1">Platform branding and global defaults.</p>
        </div>
        <button class="btn btn-primary p-2" :disabled="isSaving" @click="isSaving = true; setTimeout(() => { isSaving = false; alert('Saved successfully') }, 1000)">
            <span x-text="isSaving ? 'Saving...' : 'Save Settings'"></span>
        </button>
    </div>

    <div class="card p-6 space-y-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="form-group mb-0">
                <label class="form-label">Platform Branding Name</label>
                <input type="text" value="Sahor One Platform" class="form-input w-full">
            </div>
            <div class="form-group mb-0">
                <label class="form-label">Support Contact Details</label>
                <input type="email" value="support@sahorone.com" class="form-input w-full">
            </div>
            <div class="form-group mb-0">
                <label class="form-label">Default Currency</label>
                <select class="form-input w-full">
                    <option value="AED" selected>AED - UAE Dirham</option>
                    <option value="USD">USD - US Dollar</option>
                </select>
            </div>
            <div class="form-group mb-0">
                <label class="form-label">Default Timezone</label>
                <select class="form-input w-full">
                    <option value="Asia/Dubai" selected>Asia/Dubai (GST)</option>
                    <option value="UTC">UTC</option>
                </select>
            </div>
        </div>

        <div class="pt-6 border-t border-border-default">
            <h3 class="text-body-sm font-bold text-text-primary mb-3">Platform-wide Toggles</h3>
            <label class="flex items-center gap-3 cursor-pointer">
                <input type="checkbox" class="w-4 h-4 rounded border-border-strong text-semantic-error focus:ring-semantic-error/20 bg-bg-primary">
                <div>
                    <span class="block text-body-sm font-bold text-text-primary">Enable Global Maintenance Mode</span>
                    <span class="block text-caption text-text-secondary mt-0.5">Forces all clients to a maintenance screen.</span>
                </div>
            </label>
        </div>
    </div>
</div>
@endsection