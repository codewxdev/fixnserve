@extends('layouts.app')
@section('title', 'Refunds & Adjustments | Finance')
@section('content')
<div class="p-4 sm:p-6 lg:p-8 bg-bg-primary min-h-screen">
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-h3 font-bold text-text-primary">Refunds & Financial Adjustments</h1>
            <p class="text-body-sm text-text-secondary mt-1">Process refunds, fee waivers, wallet credits, and chargebacks. Requires justification and RBAC.</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
        <div class="card p-6 border-border-default shadow-sm">
            <h3 class="text-h4 font-bold text-text-primary mb-4 border-b border-border-default pb-2">Initiate Adjustment</h3>
            <div class="space-y-4">
                <div class="form-group mb-0">
                    <label class="form-label">Type</label>
                    <select class="form-input w-full text-body-sm">
                        <option>Full Refund (Service + Commission)</option>
                        <option>Partial Refund (Pro-rated)</option>
                        <option>Wallet Credit (Alternative to Cash)</option>
                        <option>Manual Fee Waiver (Goodwill)</option>
                    </select>
                </div>
                <div class="form-group mb-0">
                    <label class="form-label">Source Transaction ID</label>
                    <input type="text" placeholder="TXN-..." class="form-input w-full font-mono text-sm">
                </div>
                <div class="form-group mb-0">
                    <label class="form-label">Mandatory Audit Justification</label>
                    <textarea rows="3" class="form-input w-full text-body-sm" placeholder="Reason for adjustment..."></textarea>
                </div>
                <button class="btn btn-primary w-full py-2.5 transition-colors">Submit to Approval Workflow</button>
            </div>
        </div>

        <div class="space-y-6">
            <div class="card p-5 bg-semantic-info-bg/30 border-semantic-info/20 text-text-primary text-body-sm">
                <h4 class="font-bold mb-2 flex items-center gap-2"><i data-lucide="git-merge" class="w-4 h-4 text-semantic-info"></i> Reversal Pipeline Flow</h4>
                <p class="text-caption text-text-secondary">Request &rarr; Policy Check &rarr; Dual Approval (if > Threshold) &rarr; Stripe API &rarr; Ledger Reversal &rarr; Notify Business</p>
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div class="card p-4 border-l-4 border-l-semantic-warning">
                    <p class="text-caption font-bold text-text-tertiary uppercase">Pending Approvals</p>
                    <p class="text-h2 font-black text-text-primary mt-1">4</p>
                </div>
                <div class="card p-4 border-l-4 border-l-semantic-error">
                    <p class="text-caption font-bold text-text-tertiary uppercase">Chargebacks</p>
                    <p class="text-h2 font-black text-semantic-error mt-1">2</p>
                </div>
            </div>
        </div>
    </div>

    <div class="card p-0 shadow-sm border-border-default">
        <div class="p-5 border-b border-border-default bg-bg-tertiary">
            <h3 class="text-h4 font-bold text-text-primary">Awaiting Financial Approval</h3>
        </div>
        <table class="w-full text-left whitespace-nowrap">
            <thead class="text-caption uppercase text-text-secondary font-semibold border-b border-border-strong bg-bg-primary">
                <tr>
                    <th class="px-6 py-4">Request Details</th>
                    <th class="px-6 py-4">Amount</th>
                    <th class="px-6 py-4">Justification</th>
                    <th class="px-6 py-4 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-border-default">
                <tr class="hover:bg-bg-secondary transition-colors">
                    <td class="px-6 py-4">
                        <p class="text-body-sm font-bold text-text-primary">Partial Refund</p>
                        <p class="text-caption text-text-secondary font-mono mt-1">TXN-998A2B1C</p>
                    </td>
                    <td class="px-6 py-4 font-bold text-text-primary">AED 45.00</td>
                    <td class="px-6 py-4 text-caption text-text-secondary truncate max-w-[200px]" title="Service disruption credit">Service disruption credit</td>
                    <td class="px-6 py-4 text-right">
                        <button class="btn btn-sm btn-destructive py-2 px-3 mr-2 hover:bg-semantic-error/10 transition-colors">Reject</button>
                        <button class="btn btn-sm btn-secondary text-semantic-success hover:bg-semantic-success/10 border-semantic-success/30 transition-colors py-2 px-3">Approve</button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection