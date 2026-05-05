@extends('layouts.app')
@section('title', 'SLA Management | Support')
@section('content')
<div class="p-4 sm:p-6 lg:p-8 bg-bg-primary min-h-screen">
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-h3 font-bold text-text-primary">SLA Management</h1>
            <p class="text-body-sm text-text-secondary mt-1">Tier-based service level agreements, escalation rules, and compliance tracking.</p>
        </div>
    </div>

    <!-- SLA Matrix -->
    <div class="card p-0 shadow-sm border-border-default mb-8">
        <div class="p-5 border-b border-border-default bg-bg-tertiary">
            <h3 class="text-h4 font-bold text-text-primary">Enforced SLA Matrix</h3>
        </div>
        <table class="w-full text-left whitespace-nowrap text-body-sm">
            <thead class="text-caption uppercase text-text-secondary font-semibold border-b border-border-strong bg-bg-primary">
                <tr>
                    <th class="px-6 py-4">Subscription Tier</th>
                    <th class="px-6 py-4">First Response Time</th>
                    <th class="px-6 py-4">Resolution Time</th>
                    <th class="px-6 py-4">Breach Penalty (Internal)</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-border-default">
                <tr class="hover:bg-bg-secondary transition-colors">
                    <td class="px-6 py-4 font-bold text-text-primary">Starter</td>
                    <td class="px-6 py-4">48 Hours</td>
                    <td class="px-6 py-4">5 Business Days</td>
                    <td class="px-6 py-4 text-caption text-text-secondary">Standard Escalation</td>
                </tr>
                <tr class="hover:bg-bg-secondary transition-colors">
                    <td class="px-6 py-4 font-bold text-text-primary">Growth</td>
                    <td class="px-6 py-4">24 Hours</td>
                    <td class="px-6 py-4">3 Business Days</td>
                    <td class="px-6 py-4 text-caption text-text-secondary">Supervisor Alert</td>
                </tr>
                <tr class="hover:bg-bg-secondary transition-colors border-l-4 border-l-brand-primary bg-brand-primary/5">
                    <td class="px-6 py-4 font-bold text-brand-primary">Scale</td>
                    <td class="px-6 py-4 font-bold">4 Hours</td>
                    <td class="px-6 py-4">1 Business Day</td>
                    <td class="px-6 py-4 text-caption text-semantic-warning">Account Manager Alert + 10% Credit</td>
                </tr>
                <tr class="hover:bg-bg-secondary transition-colors border-l-4 border-l-purple-500 bg-purple-500/5">
                    <td class="px-6 py-4 font-bold text-purple-500">Enterprise</td>
                    <td class="px-6 py-4 font-bold">1 Hour</td>
                    <td class="px-6 py-4 font-bold">4 Hours</td>
                    <td class="px-6 py-4 text-caption text-semantic-error">Executive Escalation + SLA Compensation</td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- Active Warnings -->
    <div class="mb-8 p-5 rounded-lg border border-semantic-warning/40 bg-semantic-warning/10">
        <h3 class="text-body font-bold text-semantic-warning mb-3 flex items-center gap-2"><i data-lucide="alert-circle" class="w-5 h-5"></i> 75% SLA Warning Threshold Reached</h3>
        <div class="space-y-2">
            <div class="flex justify-between items-center bg-bg-primary p-3 rounded border border-border-default">
                <div>
                    <p class="text-body-sm font-bold text-text-primary">Ticket #4492 - API Issue (Scale Tier)</p>
                    <p class="text-caption text-text-secondary mt-0.5">Assigned: Mark D. | Remaining: 45 Mins</p>
                </div>
                <button class="btn btn-sm btn-secondary text-brand-primary border-brand-primary/30 hover:bg-brand-primary/10 transition-colors">Reassign & Escalate</button>
            </div>
        </div>
    </div>
</div>
@endsection