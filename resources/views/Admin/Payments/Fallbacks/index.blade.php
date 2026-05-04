@extends('layouts.app')
@section('title', 'Failure & Fallback | Payments')
@section('content')
<div class="p-4 sm:p-6 lg:p-8 bg-bg-primary min-h-screen">
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-h3 font-bold text-text-primary">Failure & Fallback Engine</h1>
            <p class="text-body-sm text-text-secondary mt-1">Manage network retries, outage recovery, and secondary PSP routing.</p>
        </div>
    </div>

    <!-- Strategy Status -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
        <div class="card p-6 border-brand-primary border shadow-sm shadow-brand-primary/10 relative overflow-hidden">
            <div class="absolute top-0 right-0 p-4"> </div>
            <p class="text-caption font-bold text-text-tertiary uppercase tracking-wider mb-2">Primary Infrastructure</p>
            <h2 class="text-h2 font-black text-text-primary">Stripe Connect</h2>
            <p class="text-body-sm text-semantic-success font-bold mt-2 flex items-center gap-1"><i data-lucide="check-circle" class="w-4 h-4"></i> 100% Traffic Routing</p>
        </div>
        <div class="card p-6 border-border-default bg-bg-tertiary relative overflow-hidden">
            <p class="text-caption font-bold text-text-tertiary uppercase tracking-wider mb-2">Fallback PSP (Phase 2)</p>
            <h2 class="text-h2 font-black text-text-secondary">PayTabs UAE</h2>
            <div class="mt-4 flex items-center justify-between">
                <span class="px-2 py-1 text-[10px] uppercase font-bold bg-bg-muted text-text-secondary rounded border border-border-strong">Disabled / Standby</span>
                <label class="flex items-center gap-2 cursor-not-allowed opacity-50">
                    <span class="text-caption font-bold">Manual Failover</span>
                    <div class="w-10 h-5 bg-border-strong rounded-full relative"><div class="w-4 h-4 bg-bg-primary rounded-full absolute left-0.5 top-0.5"></div></div>
                </label>
            </div>
        </div>
    </div>

    <!-- Retry Queue -->
    <div class="card p-0 shadow-sm border-border-default">
        <div class="p-5 border-b border-border-default bg-bg-primary flex justify-between items-center">
            <div>
                <h3 class="text-h4 font-bold text-text-primary">Active Retry Queue</h3>
                <p class="text-caption text-text-secondary mt-1">Automatic retries (up to 3 attempts) for network errors and timeouts.</p>
            </div>
        </div>
        <table class="w-full text-left whitespace-nowrap">
            <thead class="text-caption uppercase text-text-secondary font-semibold border-b border-border-strong bg-bg-tertiary">
                <tr>
                    <th class="px-6 py-4">Intent ID</th>
                    <th class="px-6 py-4">Failure Reason</th>
                    <th class="px-6 py-4">Attempt</th>
                    <th class="px-6 py-4 text-right">Next Retry</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-border-default">
                <tr class="hover:bg-bg-secondary transition-colors">
                    <td class="px-6 py-4 font-mono text-body-sm text-brand-primary font-bold">pi_3NxG...</td>
                    <td class="px-6 py-4 text-body-sm"><span class="text-semantic-warning"><i data-lucide="wifi-off" class="w-3 h-3 inline"></i> Network Timeout</span></td>
                    <td class="px-6 py-4 text-body-sm font-bold text-text-primary">2 / 3</td>
                    <td class="px-6 py-4 text-right text-caption text-text-secondary">In 14 mins</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection