@extends('layouts.app')
@section('title', 'Human In The Loop | AI & Automation')
@section('content')
<div class="p-4 sm:p-6 lg:p-8 bg-bg-primary min-h-screen">
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-h3 font-bold text-text-primary">Human-in-the-Loop (HITL) Queue</h1>
            <p class="text-body-sm text-text-secondary mt-1">Mandatory approvals for sensitive AI actions (bans, pricing, overrides).</p>
        </div>
    </div>

    <!-- Review Queue -->
    <div class="card p-0 shadow-sm border-border-default">
        <div class="p-5 border-b border-border-default bg-bg-tertiary flex justify-between items-center">
            <h3 class="text-h4 font-bold text-text-primary">Pending Reviews</h3>
            <span class="text-caption text-text-secondary font-mono">SLA Timers Active</span>
        </div>
        <table class="w-full text-left whitespace-nowrap">
            <thead class="text-caption uppercase text-text-secondary font-semibold border-b border-border-strong bg-bg-primary">
                <tr>
                    <th class="px-6 py-4">AI Recommendation</th>
                    <th class="px-6 py-4">Target Entity</th>
                    <th class="px-6 py-4">Confidence / SLA</th>
                    <th class="px-6 py-4">Controls</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-border-default">
                <tr class="hover:bg-bg-secondary transition-colors">
                    <td class="px-6 py-4">
                        <p class="text-body-sm font-bold text-semantic-error">Execute Account Ban</p>
                        <p class="text-caption text-text-secondary mt-0.5">Reason: Synthetic ID Confirmed</p>
                    </td>
                    <td class="px-6 py-4 text-body-sm text-text-primary">B-1088</td>
                    <td class="px-6 py-4">
                        <p class="text-body-sm font-bold text-text-primary">99.1%</p>
                        <p class="text-[10px] text-semantic-warning font-mono mt-0.5">SLA: 2h left</p>
                    </td>
                    <td class="px-6 py-4 space-x-2">
                        <div class="flex items-center gap-2">
                            <input type="text" placeholder="Justification (Required)" class="form-input text-xs w-48 py-1.5">
                            <button class="btn btn-sm btn-secondary text-semantic-success border-semantic-success/30">Approve</button>
                            <button class="btn btn-sm btn-secondary text-semantic-error border-semantic-error/30">Reject</button>
                        </div>
                    </td>
                </tr>
                <tr class="hover:bg-bg-secondary transition-colors">
                    <td class="px-6 py-4">
                        <p class="text-body-sm font-bold text-text-primary">Refund > $5,000 Threshold</p>
                        <p class="text-caption text-text-secondary mt-0.5">Reason: Support Rule Engine Escalation</p>
                    </td>
                    <td class="px-6 py-4 text-body-sm text-text-primary">TXN-991A</td>
                    <td class="px-6 py-4">
                        <p class="text-[10px] font-bold uppercase bg-brand-primary/10 text-brand-primary px-2 py-0.5 rounded border border-brand-primary/20 inline-block">Dual Approval</p>
                        <p class="text-[10px] text-text-tertiary font-mono mt-0.5">SLA: 14h left</p>
                    </td>
                    <td class="px-6 py-4 space-x-2">
                        <div class="flex items-center gap-2">
                            <input type="text" placeholder="Justification (Required)" class="form-input text-xs w-48 py-1.5">
                            <button class="btn btn-sm btn-secondary text-brand-primary border-brand-primary/30">Sign (1/2)</button>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection