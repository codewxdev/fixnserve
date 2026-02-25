@extends('layouts.app')

@section('title', 'Financial & Transaction Audit')

{{-- @push('styles')
<style>
    .theme-bg-body { background-color: rgb(var(--bg-body)); }
    .theme-bg-card { background-color: rgb(var(--bg-card)); }
    .theme-border { border-color: rgb(var(--border-color)); }
    .theme-text-main { color: rgb(var(--text-main)); }
    .theme-text-muted { color: rgb(var(--text-muted)); }
    .theme-brand-text { color: rgb(var(--brand-primary)); }
    
    /* Financial Specific colors */
    .amount-credit { color: #10b981; } /* Emerald */
    .amount-debit { color: #ef4444; }  /* Red */
    .ledger-hash { font-family: 'JetBrains Mono', monospace; font-size: 10px; opacity: 0.6; }
</style>
@endpush --}}

@section('content')
<div class="min-h-screen theme-bg-body theme-text-main max-w-[1400px] mx-auto px-4 sm:px-6 lg:px-8 py-8">

    {{-- HEADER --}}
    <div class="mb-8 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
        <div>
            <h1 class="text-2xl font-bold flex items-center gap-3">
                <i data-lucide="landmark" class="w-7 h-7 theme-brand-text"></i>
                Financial Audit Ledger
            </h1>
            <p class="theme-text-muted mt-1 text-sm">Full financial traceability with cryptographic snapshot linking.</p>
        </div>
        {{-- <div class="flex gap-3">
            <button class="px-4 py-2 theme-bg-card border theme-border rounded-lg text-sm font-medium hover:bg-white/5 transition-colors flex items-center gap-2">
                <i data-lucide="file-check" class="w-4 h-4"></i> Reconciliation Report
            </button>
        </div> --}}
    </div>

    {{-- FINANCIAL METRICS SNAPSHOT --}}
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
        <div class="theme-bg-card border theme-border p-4 rounded-xl">
            <p class="text-xs theme-text-muted uppercase font-bold tracking-wider">Total Audited Volume</p>
            <p class="text-2xl font-bold mt-1">$4,289,500.00</p>
        </div>
        <div class="theme-bg-card border theme-border p-4 rounded-xl">
            <p class="text-xs theme-text-muted uppercase font-bold tracking-wider">Unreconciled COD</p>
            <p class="text-2xl font-bold mt-1 text-yellow-500">$12,450.20</p>
        </div>
        <div class="theme-bg-card border theme-border p-4 rounded-xl">
            <p class="text-xs theme-text-muted uppercase font-bold tracking-wider">Refunded (30d)</p>
            <p class="text-2xl font-bold mt-1 text-red-400">$8,120.00</p>
        </div>
        <div class="theme-bg-card border theme-border p-4 rounded-xl">
            <p class="text-xs theme-text-muted uppercase font-bold tracking-wider">Ledger Integrity</p>
            <p class="text-2xl font-bold mt-1 text-emerald-400">100% VALID</p>
        </div>
    </div>

    {{-- LEDGER TABLE --}}
    <div class="theme-bg-card rounded-xl shadow-sm border theme-border overflow-hidden">
        <div class="p-4 border-b theme-border flex flex-col md:flex-row justify-between items-center gap-4 bg-white/5">
            <h3 class="font-semibold flex items-center gap-2 text-sm uppercase tracking-widest">
                <i data-lucide="list" class="w-4 h-4"></i> Immutable Ledger Entries
            </h3>
            <div class="flex gap-2">
                <input type="text" placeholder="Search Txn ID, Order ID..." class="theme-bg-body border theme-border rounded-lg px-4 py-1.5 text-sm outline-none focus:ring-1 focus:ring-blue-500">
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="theme-text-muted font-semibold text-xs uppercase" style="background-color: rgba(var(--bg-body), 0.8);">
                    <tr>
                        <th class="px-6 py-4">Event & Trace ID</th>
                        <th class="px-6 py-4">User / Entity</th>
                        <th class="px-6 py-4 text-right">Debit (-)</th>
                        <th class="px-6 py-4 text-right">Credit (+)</th>
                        <th class="px-6 py-4 text-center">Status</th>
                        <th class="px-6 py-4">Snapshot Link</th>
                    </tr>
                </thead>
                <tbody id="financial-ledger-body" class="divide-y theme-border">
                    </tbody>
            </table>
        </div>
    </div>

</div>

{{-- SNAPSHOT MODAL --}}
<div id="snapshot-modal" class="fixed inset-0 bg-black/70 backdrop-blur-sm hidden z-50 flex items-center justify-center p-4">
    <div class="theme-bg-card border theme-border rounded-xl w-full max-w-2xl overflow-hidden shadow-2xl">
        <div class="p-4 border-b theme-border flex justify-between items-center">
            <h3 class="font-bold text-lg flex items-center gap-2">
                <i data-lucide="shield-check" class="w-5 h-5 text-emerald-500"></i> Audit Snapshot Data
            </h3>
            <button onclick="closeModal()" class="theme-text-muted hover:text-white"><i data-lucide="x"></i></button>
        </div>
        <div class="p-6">
            <div class="bg-black/30 rounded-lg p-4 font-mono text-xs text-emerald-400 border border-emerald-500/20 mb-4">
                <p class="mb-2">// CRYPTOGRAPHIC PROOF</p>
                <p class="break-all" id="snapshot-hash">HASH: 8f2d3e...9a1b</p>
            </div>
            <div id="snapshot-content" class="space-y-4">
                </div>
        </div>
        <div class="p-4 border-t theme-border bg-white/5 text-right">
            <button onclick="closeModal()" class="px-4 py-2 bg-slate-700 rounded-lg text-sm">Dismiss</button>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://unpkg.com/lucide@latest"></script>
<script>
    const financialLogs = [
        {
            id: "TXN-882910",
            timestamp: "2026-02-23 12:10:05",
            event: "Wallet Payout",
            user: "Ahmed Raza (Vendor)",
            type: "debit",
            amount: 1250.00,
            status: "reconciled",
            hash: "SHA256:77a...2f1",
            details: { order_id: "ORD-5521", method: "Bank Transfer", bank: "HBL" }
        },
        {
            id: "TXN-882911",
            timestamp: "2026-02-23 12:15:30",
            event: "Order Payment",
            user: "Maria Khan (Customer)",
            type: "credit",
            amount: 450.50,
            status: "pending",
            hash: "SHA256:88b...9c3",
            details: { order_id: "ORD-9901", method: "Stripe", card: "**** 4242" }
        },
        {
            id: "TXN-882912",
            timestamp: "2026-02-23 12:45:12",
            event: "Refund Processed",
            user: "Zeeshan Ali (Customer)",
            type: "debit",
            amount: 75.00,
            status: "reconciled",
            hash: "SHA256:12e...0f9",
            details: { order_id: "ORD-7712", reason: "Damaged Item", ticket_id: "TKT-441" }
        }
    ];

    document.addEventListener("DOMContentLoaded", () => {
        renderLedger(financialLogs);
        lucide.createIcons();
    });

    function renderLedger(logs) {
        const tbody = document.getElementById('financial-ledger-body');
        tbody.innerHTML = '';

        logs.forEach(log => {
            const isDebit = log.type === 'debit';
            const row = `
                <tr class="hover:bg-white/5 transition-colors">
                    <td class="px-6 py-4">
                        <div class="font-bold theme-text-main">${log.event}</div>
                        <div class="text-[10px] theme-text-muted font-mono uppercase">${log.id}</div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="theme-text-main">${log.user}</div>
                        <div class="text-xs theme-text-muted">${log.timestamp}</div>
                    </td>
                    <td class="px-6 py-4 text-right font-mono ${isDebit ? 'amount-debit' : 'theme-text-muted'}">
                        ${isDebit ? '-' + log.amount.toFixed(2) : '--'}
                    </td>
                    <td class="px-6 py-4 text-right font-mono ${!isDebit ? 'amount-credit' : 'theme-text-muted'}">
                        ${!isDebit ? '+' + log.amount.toFixed(2) : '--'}
                    </td>
                    <td class="px-6 py-4 text-center">
                        <span class="px-2 py-1 rounded-full text-[10px] font-bold uppercase border ${log.status === 'reconciled' ? 'bg-emerald-500/10 text-emerald-400 border-emerald-500/20' : 'bg-yellow-500/10 text-yellow-400 border-yellow-500/20'}">
                            ${log.status}
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        <button onclick='openSnapshot(${JSON.stringify(log)})' class="flex items-center gap-2 theme-text-muted hover:theme-brand-text transition-colors">
                            <i data-lucide="database" class="w-4 h-4"></i>
                            <span class="ledger-hash">${log.hash}</span>
                        </button>
                    </td>
                </tr>
            `;
            tbody.insertAdjacentHTML('beforeend', row);
        });
        lucide.createIcons();
    }

    function openSnapshot(log) {
        document.getElementById('snapshot-hash').innerText = `LEDGER_NODE_ID: ${log.id} | HASH: ${log.hash}`;
        const content = document.getElementById('snapshot-content');
        content.innerHTML = `
            <div class="grid grid-cols-2 gap-4 text-sm">
                <div class="p-3 theme-bg-body border theme-border rounded">
                    <p class="theme-text-muted text-xs">Entity Type</p>
                    <p class="font-bold">Wallet_Transaction</p>
                </div>
                <div class="p-3 theme-bg-body border theme-border rounded">
                    <p class="theme-text-muted text-xs">Auth Reference</p>
                    <p class="font-bold">AUTH_TOKEN_77X</p>
                </div>
            </div>
            <div class="p-4 theme-bg-body border theme-border rounded">
                <p class="theme-text-muted text-xs mb-2">Metadata Attachment</p>
                <pre class="text-xs text-blue-400">${JSON.stringify(log.details, null, 2)}</pre>
            </div>
        `;
        document.getElementById('snapshot-modal').classList.remove('hidden');
    }

    function closeModal() {
        document.getElementById('snapshot-modal').classList.add('hidden');
    }
</script>
@endpush