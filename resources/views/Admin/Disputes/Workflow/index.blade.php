@extends('layouts.app')
@section('title', 'Active Workflow | Disputes')
@section('content')
<div class="p-4 sm:p-6 lg:p-8 bg-bg-primary min-h-screen">
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-h3 font-bold text-text-primary">Active Dispute Workflow</h1>
            <p class="text-body-sm text-text-secondary mt-1">Manage ticket states from submission to closure.</p>
        </div>
        <div class="flex gap-2">
            <select class="form-input text-body-sm w-40"><option>All Agents</option><option>My Tickets</option></select>
        </div>
    </div>

    <!-- State Metrics -->
    <div class="grid grid-cols-2 md:grid-cols-6 gap-4 mb-8">
        <div class="card p-4 border-border-default text-center"><p class="text-h3 font-black text-text-primary">12</p><p class="text-[10px] font-bold text-text-tertiary uppercase mt-1">Submitted</p></div>
        <div class="card p-4 border-brand-primary/30 bg-brand-primary/5 text-center"><p class="text-h3 font-black text-brand-primary">8</p><p class="text-[10px] font-bold text-brand-primary uppercase mt-1">Under Review</p></div>
        <div class="card p-4 border-semantic-warning/30 bg-semantic-warning/5 text-center"><p class="text-h3 font-black text-semantic-warning">4</p><p class="text-[10px] font-bold text-semantic-warning uppercase mt-1">Awaiting Info</p></div>
        <div class="card p-4 border-semantic-success/30 bg-semantic-success/5 text-center"><p class="text-h3 font-black text-semantic-success">45</p><p class="text-[10px] font-bold text-semantic-success uppercase mt-1">Resolved</p></div>
        <div class="card p-4 border-semantic-error/30 bg-semantic-error-bg/30 text-center"><p class="text-h3 font-black text-semantic-error">2</p><p class="text-[10px] font-bold text-semantic-error uppercase mt-1">Appealed</p></div>
        <div class="card p-4 border-border-default bg-bg-tertiary text-center"><p class="text-h3 font-black text-text-secondary">142</p><p class="text-[10px] font-bold text-text-secondary uppercase mt-1">Closed</p></div>
    </div>

    <!-- Active Tickets Queue -->
    <div class="card p-0 shadow-sm border-border-default">
        <div class="p-5 border-b border-border-default bg-bg-tertiary">
            <h3 class="text-h4 font-bold text-text-primary">Action Required</h3>
        </div>
        <table class="w-full text-left whitespace-nowrap">
            <thead class="text-caption uppercase text-text-secondary font-semibold border-b border-border-strong bg-bg-primary">
                <tr>
                    <th class="px-6 py-4">Dispute ID & Business</th>
                    <th class="px-6 py-4">Category</th>
                    <th class="px-6 py-4">State</th>
                    <th class="px-6 py-4">Assigned To</th>
                    <th class="px-6 py-4 text-right">Action</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-border-default">
                <tr class="hover:bg-bg-secondary transition-colors">
                    <td class="px-6 py-4">
                        <p class="text-body-sm font-bold text-text-primary font-mono">DSP-9982</p>
                        <p class="text-caption text-text-secondary mt-0.5">Elevate Digital (B-1024)</p>
                    </td>
                    <td class="px-6 py-4 text-body-sm text-text-primary">Commission Calculation</td>
                    <td class="px-6 py-4"><span class="px-2 py-0.5 text-[10px] uppercase font-bold bg-brand-primary/10 text-brand-primary rounded border border-brand-primary/20">Under Review</span></td>
                    <td class="px-6 py-4 text-body-sm text-text-secondary">Sarah (Finance)</td>
                    <td class="px-6 py-4 text-right"><button class="btn btn-sm btn-secondary py-1.5 px-3">Open Ticket</button></td>
                </tr>
                <tr class="hover:bg-bg-secondary transition-colors">
                    <td class="px-6 py-4">
                        <p class="text-body-sm font-bold text-text-primary font-mono">DSP-9985</p>
                        <p class="text-caption text-text-secondary mt-0.5">Apex Legal (B-1026)</p>
                    </td>
                    <td class="px-6 py-4 text-body-sm text-text-primary">Data Access (GDPR)</td>
                    <td class="px-6 py-4"><span class="px-2 py-0.5 text-[10px] uppercase font-bold bg-semantic-error-bg text-semantic-error rounded border border-semantic-error/20">Appealed</span></td>
                    <td class="px-6 py-4 text-body-sm text-text-secondary">Tariq (Legal)</td>
                    <td class="px-6 py-4 text-right"><button class="btn btn-sm btn-secondary py-1.5 px-3">Review Appeal</button></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection