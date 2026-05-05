@extends('Layouts.app')
@section('title', 'Legal Escalation | Disputes')
@section('content')
<div class="p-4 sm:p-6 lg:p-8 bg-bg-primary min-h-screen">
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-h3 font-bold text-text-primary">Legal & Compliance Escalations</h1>
            <p class="text-body-sm text-text-secondary mt-1">Manage >$10K disputes, GDPR holds, and external counsel coordination.</p>
        </div>
        <button class="btn btn-destructive py-2.5 px-4 shadow-sm shadow-semantic-error/20 transition-colors"><i data-lucide="lock" class="w-4 h-4 mr-2"></i> Trigger Emergency Data Hold</button>
    </div>

    <!-- Active Legal Holds -->
    <div class="card p-0 shadow-sm border-semantic-error/40 mb-8">
        <div class="p-5 border-b border-border-default bg-semantic-error-bg/10 flex justify-between items-center">
            <h3 class="text-h4 font-bold text-semantic-error flex items-center gap-2"><i data-lucide="shield-alert" class="w-4 h-4"></i> Active Legal Holds</h3>
        </div>
        <table class="w-full text-left whitespace-nowrap">
            <thead class="text-caption uppercase text-text-secondary font-semibold border-b border-border-strong bg-bg-primary">
                <tr>
                    <th class="px-6 py-4">Dispute / Business</th>
                    <th class="px-6 py-4">Trigger Reason</th>
                    <th class="px-6 py-4">Assigned Case Manager</th>
                    <th class="px-6 py-4 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-border-default">
                <tr class="hover:bg-bg-secondary transition-colors">
                    <td class="px-6 py-4">
                        <p class="text-body-sm font-bold text-text-primary font-mono">DSP-8841</p>
                        <p class="text-caption text-text-secondary mt-0.5">BigBox Retailers (B-050)</p>
                    </td>
                    <td class="px-6 py-4 text-body-sm text-text-primary"><span class="text-semantic-error font-bold">Dispute > $10K</span> (Chargeback mass allocation)</td>
                    <td class="px-6 py-4 text-body-sm text-text-secondary">Z. Ahmed (External Counsel)</td>
                    <td class="px-6 py-4 text-right space-x-2">
                        <button class="btn btn-sm btn-secondary py-1.5 px-3 hover:bg-bg-tertiary">Access Bundle</button>
                        <button class="btn btn-sm btn-secondary text-brand-primary border-brand-primary/30 hover:bg-brand-primary/10 transition-colors py-1.5 px-3">Message Manager</button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- Workflow Escalation Board -->
    <div class="card p-6 border-border-default shadow-sm bg-bg-tertiary">
        <h3 class="text-body font-bold text-text-primary mb-4">Escalation Playbooks</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="p-4 border border-border-default bg-bg-primary rounded-lg">
                <p class="text-body-sm font-bold text-text-primary mb-1">Standard Legal Flow</p>
                <p class="text-caption text-text-secondary mb-3">Triggered automatically when financial threshold exceeded or explicit legal threat detected.</p>
                <div class="text-[10px] text-text-tertiary uppercase font-mono space-y-1">
                    <p>1. Lock Data (Legal Hold)</p>
                    <p>2. Notify Case Manager</p>
                    <p>3. Generate Export Bundle</p>
                </div>
            </div>
            <div class="p-4 border border-border-default bg-bg-primary rounded-lg">
                <p class="text-body-sm font-bold text-text-primary mb-1">GDPR Compliance Flow</p>
                <p class="text-caption text-text-secondary mb-3">Triggered on explicit PII deletion or extraction disputes to meet 30-day regulatory SLA.</p>
                <div class="text-[10px] text-text-tertiary uppercase font-mono space-y-1">
                    <p>1. Alert Data Protection Officer (DPO)</p>
                    <p>2. Pause Auto-Deletions</p>
                    <p>3. Await DPO Verification</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection