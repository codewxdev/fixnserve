@extends('Layouts.app')
@section('title', 'Risk Scoring Engine | Fraud')
@section('content')
<div class="p-4 sm:p-6 lg:p-8 bg-bg-primary min-h-screen">
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-h3 font-bold text-text-primary">Global Risk Scoring Engine</h1>
            <p class="text-body-sm text-text-secondary mt-1">Multi-subject behavioral and velocity analysis across the platform.</p>
        </div>
        <button class="btn btn-secondary py-2.5 px-4 text-brand-primary border-brand-primary/30 hover:bg-brand-primary/10 transition-colors"><i data-lucide="refresh-cw" class="w-4 h-4 mr-2"></i> Recalculate Models</button>
    </div>

    <!-- Overall Risk Posture -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="card p-5 border-border-default flex flex-col justify-between">
            <p class="text-caption font-bold text-text-tertiary uppercase">Low Risk (0-39)</p>
            <h2 class="text-h2 font-black text-semantic-success mt-2">92%</h2>
            <p class="text-caption text-text-secondary mt-1">Platform Entities</p>
        </div>
        <div class="card p-5 border-border-default flex flex-col justify-between">
            <p class="text-caption font-bold text-text-tertiary uppercase">Medium Risk (40-69)</p>
            <h2 class="text-h2 font-black text-semantic-warning mt-2">6%</h2>
            <p class="text-caption text-text-secondary mt-1">Flagged for monitoring</p>
        </div>
        <div class="card p-5 bg-semantic-error-bg/20 flex flex-col justify-between">
            <p class="text-caption font-bold text-semantic-error uppercase">High/Critical Risk (70-100)</p>
            <h2 class="text-h2 font-black text-semantic-error mt-2">2%</h2>
            <p class="text-caption text-text-secondary mt-1">Active mitigations applied</p>
        </div>
        <div class="card p-5 border-border-default bg-bg-tertiary">
            <p class="text-caption font-bold text-text-tertiary uppercase mb-2">Monitored Subjects</p>
            <div class="space-y-1 text-body-sm font-bold text-text-secondary">
                <p>Businesses (Account Takeover)</p>
                <p>Team Members (Credentials)</p>
                <p>Client Txns (Payment Fraud)</p>
                <p>Admin Sessions (Insider Risk)</p>
            </div>
        </div>
    </div>

    <!-- Active Risk Subjects -->
    <div class="card p-0 shadow-sm border-border-default">
        <div class="p-5 border-b border-border-default bg-bg-tertiary flex justify-between items-center">
            <h3 class="text-h4 font-bold text-text-primary">High & Critical Risk Subjects</h3>
            <div class="flex gap-2">
                <select class="form-input w-40 text-body-sm"><option>All Subjects</option><option>Businesses</option><option>Transactions</option><option>Admins</option></select>
            </div>
        </div>
        <table class="w-full text-left whitespace-nowrap">
            <thead class="text-caption uppercase text-text-secondary font-semibold border-b border-border-strong bg-bg-primary">
                <tr>
                    <th class="px-6 py-4">Subject Identifier</th>
                    <th class="px-6 py-4">Subject Type</th>
                    <th class="px-6 py-4">Risk Score (0-100)</th>
                    <th class="px-6 py-4">Anomaly Signals (Reason Codes)</th>
                    <th class="px-6 py-4 text-right">Action</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-border-default">
                <tr class="hover:bg-bg-secondary transition-colors">
                    <td class="px-6 py-4 text-body-sm font-bold text-text-primary">B-1088 (AutoFix Garage)</td>
                    <td class="px-6 py-4 text-caption text-text-secondary">Business Account</td>
                    <td class="px-6 py-4">
                        <span class="px-2 py-1 font-bold text-xs bg-semantic-error text-white rounded shadow-sm">92 / 100</span>
                        <span class="ml-2 text-[10px] text-semantic-error uppercase font-bold tracking-wider">Critical</span>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex flex-wrap gap-1">
                            <span class="px-2 py-0.5 text-[10px] bg-bg-muted border border-border-strong rounded text-text-secondary">VELOCITY_SPIKE</span>
                            <span class="px-2 py-0.5 text-[10px] bg-bg-muted border border-border-strong rounded text-text-secondary">DEVICE_REUSE</span>
                        </div>
                    </td>
                    <td class="px-6 py-4 text-right">
                        <button class="btn btn-sm btn-secondary py-1.5 px-3">Inspect Details</button>
                    </td>
                </tr>
                <tr class="hover:bg-bg-secondary transition-colors">
                    <td class="px-6 py-4 text-body-sm font-bold text-text-primary">Admin_Tariq (ID: 45)</td>
                    <td class="px-6 py-4 text-caption text-text-secondary">Admin Session</td>
                    <td class="px-6 py-4">
                        <span class="px-2 py-1 font-bold text-xs bg-semantic-warning text-white rounded shadow-sm">74 / 100</span>
                        <span class="ml-2 text-[10px] text-semantic-warning uppercase font-bold tracking-wider">High</span>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex flex-wrap gap-1">
                            <span class="px-2 py-0.5 text-[10px] bg-bg-muted border border-border-strong rounded text-text-secondary">GEO_INCONSISTENCY</span>
                        </div>
                    </td>
                    <td class="px-6 py-4 text-right">
                        <button class="btn btn-sm btn-secondary py-1.5 px-3">Inspect Details</button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection