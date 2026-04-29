@extends('layouts.app')
@section('title', 'Entitlement Keys | Billing')
@section('content')
<div class="p-4 sm:p-6 lg:p-8 bg-bg-primary min-h-screen">
    <div class="mb-8">
        <h1 class="text-h3 font-bold text-text-primary">Entitlement Keys & Limits</h1>
        <p class="text-body-sm text-text-secondary mt-1">Configure capability locks evaluated dynamically at runtime.</p>
    </div>

    <div class="card p-0 overflow-hidden shadow-sm">
        <div class="p-5 bg-bg-tertiary border-b border-border-default flex justify-between items-center">
            <h3 class="text-body font-bold text-text-primary">Feature Entitlement Matrix</h3>
            <div class="flex gap-2 text-caption">
                <span class="flex items-center gap-1"><div class="w-2 h-2 rounded-full bg-semantic-error"></div> Hard Limit</span>
                <span class="flex items-center gap-1 ml-2"><div class="w-2 h-2 rounded-full bg-semantic-warning"></div> Soft Limit</span>
            </div>
        </div>
        <table class="w-full text-left">
            <thead class="text-caption uppercase text-text-secondary font-semibold border-b border-border-strong bg-bg-primary">
                <tr>
                    <th class="px-6 py-4">Key Identifier</th>
                    <th class="px-6 py-4">Data Type</th>
                    <th class="px-6 py-4">Enforcement Type</th>
                    <th class="px-6 py-4 text-right">Associated Usage</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-border-default">
                <tr class="hover:bg-bg-secondary transition-colors">
                    <td class="px-6 py-4 font-mono text-body-sm font-bold text-brand-primary">max_team_members</td>
                    <td class="px-6 py-4 text-caption text-text-secondary">Integer</td>
                    <td class="px-6 py-4"><span class="px-2 py-0.5 rounded text-[10px] font-bold bg-semantic-error-bg text-semantic-error border border-semantic-error/20 uppercase tracking-wider">Hard Limit</span></td>
                    <td class="px-6 py-4 text-right text-body-sm">Team Member Count</td>
                </tr>
                <tr class="hover:bg-bg-secondary transition-colors">
                    <td class="px-6 py-4 font-mono text-body-sm font-bold text-brand-primary">max_active_jobs</td>
                    <td class="px-6 py-4 text-caption text-text-secondary">Integer</td>
                    <td class="px-6 py-4"><span class="px-2 py-0.5 rounded text-[10px] font-bold bg-semantic-warning-bg text-semantic-warning border border-semantic-warning/20 uppercase tracking-wider">Soft Limit (Warn)</span></td>
                    <td class="px-6 py-4 text-right text-body-sm">Active Jobs Count</td>
                </tr>
                <tr class="hover:bg-bg-secondary transition-colors">
                    <td class="px-6 py-4 font-mono text-body-sm font-bold text-brand-primary">api_access</td>
                    <td class="px-6 py-4 text-caption text-text-secondary">Boolean</td>
                    <td class="px-6 py-4"><span class="px-2 py-0.5 rounded text-[10px] font-bold bg-semantic-error-bg text-semantic-error border border-semantic-error/20 uppercase tracking-wider">Hard Limit</span></td>
                    <td class="px-6 py-4 text-right text-body-sm">API Gateway</td>
                </tr>
                <tr class="hover:bg-bg-secondary transition-colors">
                    <td class="px-6 py-4 font-mono text-body-sm font-bold text-brand-primary">analytics_tier</td>
                    <td class="px-6 py-4 text-caption text-text-secondary">Enum (basic/full)</td>
                    <td class="px-6 py-4"><span class="px-2 py-0.5 rounded text-[10px] font-bold bg-bg-muted text-text-secondary border border-border-strong uppercase tracking-wider">Feature Toggle</span></td>
                    <td class="px-6 py-4 text-right text-body-sm">Report Generation</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection