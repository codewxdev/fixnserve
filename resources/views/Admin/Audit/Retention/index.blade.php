@extends('Layouts.app')
@section('title', 'Data Retention | Compliance')
@section('content')
<div class="p-4 sm:p-6 lg:p-8 bg-bg-primary min-h-screen">
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-h3 font-bold text-text-primary">Data Retention & Legal Holds</h1>
            <p class="text-body-sm text-text-secondary mt-1">Automated compliance cycles and active litigation data preservation.</p>
        </div>
        <button class="btn btn-destructive py-2.5 px-4 shadow-sm shadow-semantic-error/20 transition-colors"><i data-lucide="shield-alert" class="w-4 h-4 mr-2"></i> Add Legal Hold</button>
    </div>

    <!-- Active Legal Holds -->
    <div class="mb-8 card p-0 shadow-lg border-semantic-error shadow-semantic-error/10">
        <div class="p-5 border-b border-semantic-error/20 bg-semantic-error-bg/30 flex justify-between items-center">
            <h3 class="text-h4 font-bold text-semantic-error flex items-center gap-2"><i data-lucide="lock" class="w-4 h-4"></i> Active Legal Holds (Overrides Deletion)</h3>
            <span class="text-[10px] uppercase font-bold text-semantic-error tracking-wider">Requires Dual Approval for Removal</span>
        </div>
        <table class="w-full text-left whitespace-nowrap text-body-sm">
            <tbody class="divide-y divide-semantic-error/10 bg-semantic-error-bg/10">
                <tr class="hover:bg-semantic-error-bg/20 transition-colors">
                    <td class="px-6 py-4 font-bold text-semantic-error">Case: UAE-2026-LIT-88</td>
                    <td class="px-6 py-4 text-semantic-error">Target: Business B-1024</td>
                    <td class="px-6 py-4 text-semantic-error">Until: Pending Court Order</td>
                    <td class="px-6 py-4 text-right"><button class="text-caption font-bold underline hover:no-underline">View Chain of Custody</button></td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- Retention Policy Matrix -->
    <div class="card p-0 shadow-sm border-border-default">
        <div class="p-5 border-b border-border-default bg-bg-tertiary">
            <h3 class="text-h4 font-bold text-text-primary">System Retention Policies</h3>
        </div>
        <table class="w-full text-left whitespace-nowrap text-body-sm">
            <thead class="text-caption uppercase text-text-secondary font-semibold border-b border-border-strong bg-bg-primary">
                <tr>
                    <th class="px-6 py-4">Data Category</th>
                    <th class="px-6 py-4">Retention Period</th>
                    <th class="px-6 py-4">Trigger / Compliance Law</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-border-default">
                <tr class="hover:bg-bg-secondary transition-colors">
                    <td class="px-6 py-4 font-bold text-text-primary">Financial Records & Ledger</td>
                    <td class="px-6 py-4 font-mono text-brand-primary font-bold">7 Years</td>
                    <td class="px-6 py-4 text-caption text-text-secondary">UAE Financial Law Mandatory</td>
                </tr>
                <tr class="hover:bg-bg-secondary transition-colors">
                    <td class="px-6 py-4 font-bold text-text-primary">Transaction Logs (Stripe)</td>
                    <td class="px-6 py-4 font-mono text-brand-primary font-bold">7 Years</td>
                    <td class="px-6 py-4 text-caption text-text-secondary">Financial Audit Requirement</td>
                </tr>
                <tr class="hover:bg-bg-secondary transition-colors">
                    <td class="px-6 py-4 font-bold text-text-primary">KYC / AML Documents</td>
                    <td class="px-6 py-4 font-mono">5 Years</td>
                    <td class="px-6 py-4 text-caption text-text-secondary">Post-Account Closure SLA</td>
                </tr>
                <tr class="hover:bg-bg-secondary transition-colors">
                    <td class="px-6 py-4 font-bold text-text-primary">Admin Audit Logs</td>
                    <td class="px-6 py-4 font-mono text-semantic-success font-bold">10 Years</td>
                    <td class="px-6 py-4 text-caption text-text-secondary">Platform Security Standard</td>
                </tr>
                <tr class="hover:bg-bg-secondary transition-colors text-text-secondary">
                    <td class="px-6 py-4 font-bold">Support Tickets</td>
                    <td class="px-6 py-4 font-mono">3 Years</td>
                    <td class="px-6 py-4 text-caption">Operational Default</td>
                </tr>
                <tr class="hover:bg-bg-secondary transition-colors text-text-secondary">
                    <td class="px-6 py-4 font-bold">Chat Logs</td>
                    <td class="px-6 py-4 font-mono">2 Years</td>
                    <td class="px-6 py-4 text-caption">GDPR minimization standard</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection