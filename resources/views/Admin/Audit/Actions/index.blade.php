@extends('layouts.app')
@section('title', 'Admin Action Audit | Compliance')
@section('content')
<div class="p-4 sm:p-6 lg:p-8 bg-bg-primary min-h-screen">
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-h3 font-bold text-text-primary">Admin Action Audit Ledger</h1>
            <p class="text-body-sm text-text-secondary mt-1">Immutable, write-once event logs with cryptographical hash chain verification.</p>
        </div>
        <div class="flex items-center gap-3">
            <span class="px-3 py-1 bg-semantic-success-bg border border-semantic-success/20 text-semantic-success text-[10px] uppercase font-bold rounded flex items-center gap-1"><i data-lucide="shield-check" class="w-3 h-3"></i> Hash Chain Intact</span>
            <button class="btn btn-secondary py-2.5 px-4"><i data-lucide="download" class="w-4 h-4 mr-2"></i> Export Log</button>
        </div>
    </div>

    <!-- Active Filters -->
    <div class="mb-6 flex gap-4">
        <input type="text" placeholder="Search Actor ID, Action..." class="form-input w-64 text-sm font-mono">
        <select class="form-input text-sm w-48"><option>All Event Types</option><option>Role Changes</option><option>Business Suspensions</option><option>Emergency Overrides</option></select>
    </div>

    <!-- Immutable Ledger -->
    <div class="card p-0 shadow-sm border-border-default overflow-x-auto custom-scrollbar">
        <table class="w-full text-left whitespace-nowrap min-w-[1200px]">
            <thead class="text-caption uppercase text-text-secondary font-semibold border-b border-border-strong bg-bg-tertiary">
                <tr>
                    <th class="px-6 py-4">Timestamp (ms)</th>
                    <th class="px-6 py-4">Actor & Role</th>
                    <th class="px-6 py-4">Action Type</th>
                    <th class="px-6 py-4">Target Entity</th>
                    <th class="px-6 py-4">Device / IP</th>
                    <th class="px-6 py-4 text-right">Details & Payload</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-border-default font-mono text-[11px]">
                <tr class="hover:bg-bg-secondary transition-colors">
                    <td class="px-6 py-4 text-text-secondary">2026-05-04 12:28:22.451</td>
                    <td class="px-6 py-4">
                        <p class="font-bold text-text-primary">Admin_Tariq (ID: 45)</p>
                        <p class="text-text-tertiary mt-0.5">Super Admin</p>
                    </td>
                    <td class="px-6 py-4"><span class="px-2 py-0.5 bg-semantic-warning-bg text-semantic-warning border border-semantic-warning/20 rounded">EMERGENCY_OVERRIDE</span></td>
                    <td class="px-6 py-4 text-text-primary">Business: B-1024</td>
                    <td class="px-6 py-4 text-text-secondary">
                        <p>192.168.1.45</p>
                        <p class="text-[9px] text-text-tertiary mt-0.5 truncate w-32" title="fp_9x8z...4j2">fp_9x8z...4j2</p>
                    </td>
                    <td class="px-6 py-4 text-right">
                        <button class="text-brand-primary hover:underline font-bold text-caption">View State Diff</button>
                    </td>
                </tr>
                <tr class="hover:bg-bg-secondary transition-colors">
                    <td class="px-6 py-4 text-text-secondary">2026-05-04 12:15:10.892</td>
                    <td class="px-6 py-4">
                        <p class="font-bold text-text-primary">System_Auto</p>
                        <p class="text-text-tertiary mt-0.5">System</p>
                    </td>
                    <td class="px-6 py-4"><span class="px-2 py-0.5 bg-brand-primary/10 text-brand-primary border border-brand-primary/20 rounded">FEATURE_FLAG_TOGGLE</span></td>
                    <td class="px-6 py-4 text-text-primary">Flag: instant_payouts</td>
                    <td class="px-6 py-4 text-text-secondary">-</td>
                    <td class="px-6 py-4 text-right">
                        <button class="text-brand-primary hover:underline font-bold text-caption">View State Diff</button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection