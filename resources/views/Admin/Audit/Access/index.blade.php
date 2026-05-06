@extends('Layouts.app')
@section('title', 'Data Access Audit | Compliance')
@section('content')
<div class="p-4 sm:p-6 lg:p-8 bg-bg-primary min-h-screen">
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-h3 font-bold text-text-primary">Data Access & Privacy Audit</h1>
            <p class="text-body-sm text-text-secondary mt-1">PII access tracking and GDPR/UAE privacy request workflows.</p>
        </div>
    </div>

    <!-- Privacy Workflows -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
        <div class="card p-6 border-purple-500/30 bg-purple-500/5">
            <h3 class="text-body font-bold text-text-primary mb-2 flex items-center gap-2"><i data-lucide="file-check" class="w-5 h-5 text-purple-500"></i> Subject Access Requests (SAR)</h3>
            <p class="text-caption text-text-secondary mb-4">Export raw data requested by data subjects within SLA.</p>
            <button class="btn btn-secondary p-2 w-full text-purple-500 border-purple-500/30 hover:bg-purple-500/10">Process Pending SARs (2)</button>
        </div>
        <div class="card p-6 border-semantic-error/30 bg-semantic-error-bg/20">
            <h3 class="text-body font-bold text-text-primary mb-2 flex items-center gap-2"><i data-lucide="trash-2" class="w-5 h-5 text-semantic-error"></i> Right to be Forgotten (RTBF)</h3>
            <p class="text-caption text-text-secondary mb-4">Process permanent data erasure requests (excl. financial logs).</p>
            <button class="btn btn-secondary p-2 w-full text-semantic-error border-semantic-error/30 hover:bg-semantic-error/10">Process Pending Ernsures (0)</button>
        </div>
    </div>

    <!-- Data Access Logs -->
    <div class="card p-0 shadow-sm border-border-default">
        <div class="p-5 border-b border-border-default bg-bg-tertiary flex justify-between items-center">
            <h3 class="text-h4 font-bold text-text-primary">PII Access Ledger</h3>
            <span class="text-[10px] text-text-tertiary font-mono">Strict Auditing Enabled</span>
        </div>
        <table class="w-full text-left whitespace-nowrap font-mono text-[11px]">
            <thead class="text-caption uppercase text-text-secondary font-semibold border-b border-border-strong bg-bg-primary">
                <tr>
                    <th class="px-6 py-4">Timestamp</th>
                    <th class="px-6 py-4">Accessor (Staff ID)</th>
                    <th class="px-6 py-4">Target PII</th>
                    <th class="px-6 py-4">Action Context</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-border-default">
                <tr class="hover:bg-bg-secondary transition-colors border-l-2 border-l-semantic-warning">
                    <td class="px-6 py-4 text-text-secondary">10 Mins Ago</td>
                    <td class="px-6 py-4 font-bold text-text-primary">Support_Agent_12</td>
                    <td class="px-6 py-4"><span class="px-2 py-0.5 bg-semantic-warning-bg text-semantic-warning border border-semantic-warning/20 rounded font-bold uppercase tracking-wider text-[9px]">PII Flagged</span> (Client Email, Phone)</td>
                    <td class="px-6 py-4 text-text-secondary">Viewed during Support Ticket #4492</td>
                </tr>
                <tr class="hover:bg-bg-secondary transition-colors">
                    <td class="px-6 py-4 text-text-secondary">1 Hour Ago</td>
                    <td class="px-6 py-4 font-bold text-text-primary">Finance_Sarah</td>
                    <td class="px-6 py-4">Business KYC Document</td>
                    <td class="px-6 py-4 text-text-secondary">Downloaded for Identity Verification</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection