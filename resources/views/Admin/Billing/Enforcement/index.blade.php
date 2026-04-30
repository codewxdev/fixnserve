@extends('layouts.app')
@section('title', 'Enforcement Engine | Billing')
@section('content')
<div class="p-4 sm:p-6 lg:p-8 bg-bg-primary min-h-screen">
    <div class="mb-8 flex justify-between items-center">
        <div>
            <h1 class="text-h3 font-bold text-text-primary">Enforcement Engine</h1>
            <p class="text-body-sm text-text-secondary mt-1">Middleware capability enforcement, caching architecture, and rejection logs.</p>
        </div>
        <button class="btn btn-destructive px-4 py-2.5 shadow-sm transition-colors"><i data-lucide="refresh-cw" class="w-4 h-4 mr-2"></i> Flush Entitlement Cache</button>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
        <div class="card p-5 border-border-default">
            <p class="text-caption font-bold text-text-tertiary uppercase tracking-wider mb-2">Cache Status (Redis)</p>
            <h2 class="text-h2 font-black text-semantic-success">Healthy</h2>
            <p class="text-caption text-text-secondary mt-2">TTL: 5 Minutes (Fail-closed behavior active)</p>
        </div>
        <div class="card p-5 border-border-default">
            <p class="text-caption font-bold text-text-tertiary uppercase tracking-wider mb-2">Enforcement Points</p>
            <h2 class="text-h2 font-black text-text-primary">5 Active</h2>
            <p class="text-caption text-text-secondary mt-2">API Gateway, Job Creation, Auth Middleware...</p>
        </div>
        <div class="card p-5 border-border-default">
            <p class="text-caption font-bold text-text-tertiary uppercase tracking-wider mb-2">Blocks (Last 1hr)</p>
            <h2 class="text-h2 font-black text-semantic-warning">142</h2>
            <p class="text-caption text-text-secondary mt-2">Total capability access rejections.</p>
        </div>
    </div>

    <div class="card p-0 overflow-hidden shadow-sm">
        <div class="p-5 bg-bg-tertiary border-b border-border-default flex justify-between items-center">
            <h3 class="text-body font-bold text-text-primary">Recent Capability Rejections</h3>
        </div>
        <table class="w-full text-left">
            <thead class="text-caption uppercase text-text-secondary font-semibold border-b border-border-strong bg-bg-primary">
                <tr>
                    <th class="px-6 py-4">Timestamp</th>
                    <th class="px-6 py-4">Business ID</th>
                    <th class="px-6 py-4">Attempted Action</th>
                    <th class="px-6 py-4">Blocked Key</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-border-default">
                <tr class="hover:bg-bg-secondary transition-colors">
                    <td class="px-6 py-4 text-caption text-text-secondary font-mono">10:42:15 AM</td>
                    <td class="px-6 py-4 text-body-sm font-bold text-text-primary">B-1024</td>
                    <td class="px-6 py-4 text-body-sm text-text-secondary">Generate Custom Report</td>
                    <td class="px-6 py-4"><span class="px-2 py-0.5 rounded text-[10px] font-bold bg-semantic-error-bg text-semantic-error border border-semantic-error/20 font-mono">analytics_tier</span></td>
                </tr>
                <tr class="hover:bg-bg-secondary transition-colors">
                    <td class="px-6 py-4 text-caption text-text-secondary font-mono">10:41:02 AM</td>
                    <td class="px-6 py-4 text-body-sm font-bold text-text-primary">B-1088</td>
                    <td class="px-6 py-4 text-body-sm text-text-secondary">Add Team Member (6th)</td>
                    <td class="px-6 py-4"><span class="px-2 py-0.5 rounded text-[10px] font-bold bg-semantic-error-bg text-semantic-error border border-semantic-error/20 font-mono">max_team_members</span></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection