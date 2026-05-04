@extends('layouts.app')
@section('title', 'Webhook Management | Payments')
@section('content')
<div class="p-4 sm:p-6 lg:p-8 bg-bg-primary min-h-screen">
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-h3 font-bold text-text-primary">Webhook Management</h1>
            <p class="text-body-sm text-text-secondary mt-1">Dead letter queues, signature verification, and event replay capabilities.</p>
        </div>
        <button class="btn btn-primary py-2.5 px-4 shadow-sm transition-colors"><i data-lucide="plus" class="w-4 h-4 mr-2"></i> Register Endpoint</button>
    </div>

    <!-- Endpoint Registry -->
    <div class="card p-0 shadow-sm border-border-default mb-8">
        <div class="p-5 border-b border-border-default bg-bg-tertiary flex justify-between items-center">
            <h3 class="text-h4 font-bold text-text-primary">Endpoint Registry</h3>
        </div>
        <table class="w-full text-left whitespace-nowrap">
            <tbody class="divide-y divide-border-default">
                <tr class="hover:bg-bg-secondary transition-colors">
                    <td class="px-6 py-4">
                        <p class="text-body-sm font-bold text-text-primary flex items-center gap-2"><i data-lucide="link" class="w-4 h-4 text-brand-primary"></i> Primary Webhook Receiver</p>
                        <p class="text-caption text-text-secondary font-mono mt-1">https://api.sahorone.com/v1/webhooks/stripe</p>
                    </td>
                    <td class="px-6 py-4"><span class="px-2 py-1 text-[10px] font-bold uppercase bg-semantic-success-bg text-semantic-success rounded border border-semantic-success/20">Active</span></td>
                    <td class="px-6 py-4 text-right">
                        <button class="btn btn-sm btn-secondary text-semantic-error border-semantic-error/30 hover:bg-semantic-error/10 transition-colors py-2 px-3">Disable Endpoint</button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- Event Log & DLQ -->
    <div class="card p-0 shadow-sm border-border-default">
        <div class="p-5 border-b border-border-default bg-bg-tertiary flex justify-between items-center">
            <h3 class="text-h4 font-bold text-text-primary">Event Log & Dead Letter Queue</h3>
            <div class="flex gap-2">
                <button class="btn btn-sm btn-secondary py-2 px-3 transition-colors"><i data-lucide="filter" class="w-4 h-4 mr-2"></i> Failed Only</button>
            </div>
        </div>
        <table class="w-full text-left whitespace-nowrap">
            <thead class="text-caption uppercase text-text-secondary font-semibold border-b border-border-strong bg-bg-primary">
                <tr>
                    <th class="px-6 py-4">Event ID / Timestamp</th>
                    <th class="px-6 py-4">Event Type</th>
                    <th class="px-6 py-4">Delivery Status</th>
                    <th class="px-6 py-4 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-border-default">
                <tr class="hover:bg-bg-secondary transition-colors">
                    <td class="px-6 py-4 font-mono text-caption text-text-secondary">evt_3NxT...<br>Today, 10:45 AM</td>
                    <td class="px-6 py-4 text-body-sm font-bold text-text-primary">payment_intent.succeeded</td>
                    <td class="px-6 py-4"><span class="text-semantic-success text-[10px] font-bold uppercase"><i data-lucide="check" class="w-3 h-3 inline"></i> 200 OK</span></td>
                    <td class="px-6 py-4 text-right"><button class="text-brand-primary hover:underline text-caption font-bold">Inspect Payload</button></td>
                </tr>
                <tr class="hover:bg-bg-secondary transition-colors bg-semantic-error-bg/10">
                    <td class="px-6 py-4 font-mono text-caption text-text-secondary">evt_8LmP...<br>Today, 09:12 AM</td>
                    <td class="px-6 py-4 text-body-sm font-bold text-text-primary">payout.failed</td>
                    <td class="px-6 py-4">
                        <span class="text-semantic-error text-[10px] font-bold uppercase"><i data-lucide="x" class="w-3 h-3 inline"></i> 500 ERR</span>
                        <p class="text-[9px] text-text-tertiary mt-1">Retrying... (Attempt 2/3)</p>
                    </td>
                    <td class="px-6 py-4 text-right space-x-3">
                        <button class="text-text-secondary hover:text-text-primary text-caption transition-colors">Inspect Payload</button>
                        <button class="btn btn-sm btn-secondary text-brand-primary border-brand-primary/30 hover:bg-brand-primary/10 transition-colors py-1.5 px-3">Force Replay</button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection