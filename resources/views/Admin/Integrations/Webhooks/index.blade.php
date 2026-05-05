@extends('Layouts.app')
@section('title', 'Webhook Governance | External Integrations')
@section('content')
<div class="p-4 sm:p-6 lg:p-8 bg-bg-primary min-h-screen">
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-h3 font-bold text-text-primary">Global Webhook Governance</h1>
            <p class="text-body-sm text-text-secondary mt-1">Cross-vendor endpoint registry, signature verification, and dead-letter queues.</p>
        </div>
    </div>

    <!-- Webhook Architecture -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="card p-5 bg-brand-primary/5">
            <h3 class="text-body-sm font-bold text-text-primary">Signature Verification</h3>
            <p class="text-caption text-text-secondary mt-2">All incoming payloads are cryptographically verified against provider secrets.</p>
            <p class="text-[10px] uppercase font-bold text-semantic-success mt-4 tracking-wider"><i data-lucide="check" class="w-3 h-3 inline"></i> Strict Mode Enforced</p>
        </div>
        <div class="card p-5 bg-purple-500/5">
            <h3 class="text-body-sm font-bold text-text-primary">Exponential Backoff</h3>
            <p class="text-caption text-text-secondary mt-2">Failing external deliveries are retried at increasing intervals (min 3 attempts).</p>
            <p class="text-[10px] uppercase font-bold text-purple-500 mt-4 tracking-wider"><i data-lucide="refresh-ccw" class="w-3 h-3 inline"></i> Logic Active</p>
        </div>
        <div class="card p-5 bg-semantic-error-bg/10">
            <h3 class="text-body-sm font-bold text-text-primary">Dead Letter Queue (DLQ)</h3>
            <p class="text-caption text-text-secondary mt-2">Permanently failed payloads are retained here for manual review and replay.</p>
            <p class="text-[10px] uppercase font-bold text-semantic-error mt-4 tracking-wider"><i data-lucide="archive" class="w-3 h-3 inline"></i> 2 Items Pending</p>
        </div>
    </div>

    <!-- DLQ & Replay Queue -->
    <div class="card p-0 shadow-sm border-border-default">
        <div class="p-5 border-b border-border-default bg-bg-tertiary">
            <h3 class="text-h4 font-bold text-text-primary">Dead Letter Queue</h3>
        </div>
        <table class="w-full text-left whitespace-nowrap">
            <thead class="text-caption uppercase text-text-secondary font-semibold border-b border-border-strong bg-bg-primary">
                <tr>
                    <th class="px-6 py-4">Source Provider</th>
                    <th class="px-6 py-4">Event Type</th>
                    <th class="px-6 py-4">Failure Reason</th>
                    <th class="px-6 py-4 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-border-default">
                <tr class="hover:bg-bg-secondary transition-colors">
                    <td class="px-6 py-4">
                        <p class="text-body-sm font-bold text-text-primary">Twilio SendGrid</p>
                        <p class="text-[10px] text-text-secondary font-mono mt-0.5">evt_77A9Z</p>
                    </td>
                    <td class="px-6 py-4 text-body-sm text-text-primary">message.bounced</td>
                    <td class="px-6 py-4 text-caption text-semantic-error font-mono">500 Internal Server Error (3/3 Retries)</td>
                    <td class="px-6 py-4 text-right space-x-2">
                        <button class="text-brand-primary hover:underline text-caption font-bold mr-2">Inspect Payload</button>
                        <button class="btn btn-sm btn-secondary py-1.5 px-3"><i data-lucide="play" class="w-3 h-3 mr-1"></i> Force Replay</button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection