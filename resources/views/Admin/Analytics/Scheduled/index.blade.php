@extends('Layouts.app')
@section('title', 'Scheduled Reports | Analytics')
@section('content')
<div class="p-4 sm:p-6 lg:p-8 bg-bg-primary min-h-screen">
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-h3 font-bold text-text-primary">Scheduled Delivery & Notifications</h1>
            <p class="text-body-sm text-text-secondary mt-1">Manage automated report distribution via Email, Slack, and API.</p>
        </div>
        <button class="btn btn-primary py-2.5 px-4 shadow-sm transition-colors"><i data-lucide="plus" class="w-4 h-4 mr-2"></i> Create Schedule</button>
    </div>

    <div class="card p-0 shadow-sm border-border-default">
        <div class="p-5 border-b border-border-default bg-bg-tertiary">
            <h3 class="text-h4 font-bold text-text-primary">Active Schedules</h3>
        </div>
        <table class="w-full text-left whitespace-nowrap">
            <thead class="text-caption uppercase text-text-secondary font-semibold border-b border-border-strong bg-bg-primary">
                <tr>
                    <th class="px-6 py-4">Report Name</th>
                    <th class="px-6 py-4">Frequency</th>
                    <th class="px-6 py-4">Delivery Method</th>
                    <th class="px-6 py-4">Recipients</th>
                    <th class="px-6 py-4 text-right">Status / Action</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-border-default">
                <tr class="hover:bg-bg-secondary transition-colors">
                    <td class="px-6 py-4">
                        <p class="text-body-sm font-bold text-text-primary">Executive Summary (MRR)</p>
                        <p class="text-[10px] text-brand-primary uppercase mt-0.5">Secure Link (24h Expiry)</p>
                    </td>
                    <td class="px-6 py-4 text-body-sm text-text-secondary">Weekly (Mon, 08:00 AM)</td>
                    <td class="px-6 py-4 text-body-sm flex items-center gap-2"><i data-lucide="mail" class="w-4 h-4 text-text-tertiary"></i> Email (PDF)</td>
                    <td class="px-6 py-4 text-caption">investors@sahorone.com<br>exec@sahorone.com</td>
                    <td class="px-6 py-4 text-right space-x-2">
                        <span class="px-2 py-1 text-[10px] uppercase font-bold bg-semantic-success-bg text-semantic-success rounded border border-semantic-success/20 mr-2">Active</span>
                        <button class="text-text-tertiary hover:text-text-primary" title="Pause"><i data-lucide="pause-circle" class="w-4 h-4"></i></button>
                        <button class="text-text-tertiary hover:text-brand-primary" title="Edit"><i data-lucide="edit-2" class="w-4 h-4"></i></button>
                    </td>
                </tr>
                <tr class="hover:bg-bg-secondary transition-colors">
                    <td class="px-6 py-4">
                        <p class="text-body-sm font-bold text-text-primary">Platform P&L & GMV</p>
                    </td>
                    <td class="px-6 py-4 text-body-sm text-text-secondary">Monthly (1st, 12:00 PM)</td>
                    <td class="px-6 py-4 text-body-sm flex items-center gap-2"><i data-lucide="database" class="w-4 h-4 text-purple-500"></i> API Push (DWH)</td>
                    <td class="px-6 py-4 text-caption font-mono">ep_prod_dwh_sync</td>
                    <td class="px-6 py-4 text-right space-x-2">
                        <span class="px-2 py-1 text-[10px] uppercase font-bold bg-semantic-success-bg text-semantic-success rounded border border-semantic-success/20 mr-2">Active</span>
                        <button class="text-text-tertiary hover:text-text-primary" title="Pause"><i data-lucide="pause-circle" class="w-4 h-4"></i></button>
                        <button class="text-text-tertiary hover:text-brand-primary" title="Edit"><i data-lucide="edit-2" class="w-4 h-4"></i></button>
                    </td>
                </tr>
                <tr class="hover:bg-bg-secondary transition-colors opacity-60">
                    <td class="px-6 py-4">
                        <p class="text-body-sm font-bold text-text-primary">Support Anomaly Alert</p>
                    </td>
                    <td class="px-6 py-4 text-body-sm text-text-secondary">On Event Trigger</td>
                    <td class="px-6 py-4 text-body-sm flex items-center gap-2"><i data-lucide="hash" class="w-4 h-4 text-semantic-warning"></i> Slack Notif</td>
                    <td class="px-6 py-4 text-caption font-mono">#ops-alerts</td>
                    <td class="px-6 py-4 text-right space-x-2">
                        <span class="px-2 py-1 text-[10px] uppercase font-bold bg-bg-muted text-text-secondary rounded border border-border-strong mr-2">Paused</span>
                        <button class="text-text-tertiary hover:text-semantic-success" title="Resume"><i data-lucide="play-circle" class="w-4 h-4"></i></button>
                        <button class="text-text-tertiary hover:text-brand-primary" title="Edit"><i data-lucide="edit-2" class="w-4 h-4"></i></button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection