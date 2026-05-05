@extends('layouts.app')
@section('title', 'Credential Management | External Integrations')
@section('content')
<div class="p-4 sm:p-6 lg:p-8 bg-bg-primary min-h-screen">
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-h3 font-bold text-text-primary">Credential Management</h1>
            <p class="text-body-sm text-text-secondary mt-1">Encrypted secret storage, scoped environments, and automated rotation.</p>
        </div>
    </div>

    <!-- AWS Secrets Manager Sync -->
    <div class="mb-8 p-4 bg-purple-500/10 border border-purple-500/30 rounded-lg flex justify-between items-center">
        <div class="flex items-center gap-3">
            <i data-lucide="cloud-lightning" class="w-6 h-6 text-purple-500"></i>
            <div>
                <p class="text-body-sm font-bold text-text-primary">AWS Secrets Manager: Synchronized</p>
                <p class="text-caption text-text-secondary mt-0.5">No plaintext keys exist in the codebase. All secrets injected at runtime.</p>
            </div>
        </div>
        <button class="btn btn-sm btn-secondary text-purple-500 border-purple-500/30 transition-colors py-1.5 px-3">Force Sync</button>
    </div>

    <div class="card p-0 shadow-sm border-border-default">
        <div class="p-5 border-b border-border-default bg-bg-tertiary flex justify-between items-center">
            <h3 class="text-h4 font-bold text-text-primary">Managed API Keys & Credentials</h3>
            <select class="form-input text-sm w-40"><option>Production Env</option><option>Staging Env</option></select>
        </div>
        <table class="w-full text-left whitespace-nowrap">
            <thead class="text-caption uppercase text-text-secondary font-semibold border-b border-border-strong bg-bg-primary">
                <tr>
                    <th class="px-6 py-4">Service & Key Alias</th>
                    <th class="px-6 py-4">Environment & Scope</th>
                    <th class="px-6 py-4">Rotation Schedule</th>
                    <th class="px-6 py-4 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-border-default">
                <tr class="hover:bg-bg-secondary transition-colors">
                    <td class="px-6 py-4">
                        <p class="text-body-sm font-bold text-text-primary">SendGrid API Key</p>
                        <p class="text-caption text-text-secondary font-mono mt-0.5">SG.prod_main_v4</p>
                    </td>
                    <td class="px-6 py-4">
                        <span class="px-2 py-0.5 text-[10px] bg-semantic-error-bg text-semantic-error rounded border border-semantic-error/20 uppercase font-bold mr-2">Production</span>
                        <span class="text-caption text-text-secondary">Scope: Mail.Send</span>
                    </td>
                    <td class="px-6 py-4">
                        <p class="text-body-sm font-bold text-text-primary">Every 90 Days</p>
                        <p class="text-[10px] font-mono text-text-tertiary mt-0.5">Next: in 14 days</p>
                    </td>
                    <td class="px-6 py-4 text-right">
                        <button class="btn btn-sm btn-secondary py-1.5 px-3">Rotate Now</button>
                    </td>
                </tr>
                <tr class="hover:bg-bg-secondary transition-colors">
                    <td class="px-6 py-4">
                        <p class="text-body-sm font-bold text-text-primary">Google Maps API</p>
                        <p class="text-caption text-text-secondary font-mono mt-0.5">GCP_MAPS_PROD_1</p>
                    </td>
                    <td class="px-6 py-4">
                        <span class="px-2 py-0.5 text-[10px] bg-semantic-error-bg text-semantic-error rounded border border-semantic-error/20 uppercase font-bold mr-2">Production</span>
                        <span class="text-caption text-text-secondary">Scope: Places, Geocoding</span>
                    </td>
                    <td class="px-6 py-4">
                        <p class="text-body-sm font-bold text-text-primary">Every 180 Days</p>
                        <p class="text-[10px] font-mono text-text-tertiary mt-0.5">Next: in 110 days</p>
                    </td>
                    <td class="px-6 py-4 text-right">
                        <button class="btn btn-sm btn-secondary py-1.5 px-3">Rotate Now</button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection