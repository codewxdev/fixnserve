@extends('layouts.app')

@section('title', 'Data Retention & Legal Holds')

@section('content')
<div class="min-h-screen theme-bg-body theme-text-main max-w-[1400px] mx-auto px-4 sm:px-6 lg:px-8 py-8">

    {{-- HEADER --}}
    <div class="mb-8 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
        <div>
            <h1 class="text-2xl font-bold flex items-center gap-3">
                <i data-lucide="snowflake" class="w-7 h-7 theme-brand-text"></i>
                Data Retention & Legal Holds
            </h1>
            <p class="theme-text-muted mt-1 text-sm">Define automated data lifecycles and freeze critical evidence for litigation.</p>
        </div>
        <div class="flex gap-3">
            <button class="px-4 py-2 theme-bg-card border border-blue-500/50 text-blue-400 rounded-lg text-sm font-bold hover:bg-blue-500/10 transition-all flex items-center gap-2">
                <i data-lucide="plus-square" class="w-4 h-4"></i> Create New Legal Hold
            </button>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        {{-- LEFT: RETENTION POLICIES --}}
        <div class="lg:col-span-1 space-y-6">
            <div class="theme-bg-card border theme-border rounded-xl p-5 shadow-sm">
                <h3 class="font-bold text-sm uppercase tracking-widest mb-4 flex items-center gap-2">
                    <i data-lucide="settings" class="w-4 h-4"></i> Global Policies
                </h3>
                <div class="space-y-4">
                    <div class="p-4 theme-bg-body border theme-border rounded-lg">
                        <div class="flex justify-between items-start mb-2">
                            <span class="text-xs font-bold theme-text-main">Financial Records</span>
                            <span class="text-[10px] bg-slate-800 px-2 py-0.5 rounded text-blue-400 border theme-border">7 YEARS</span>
                        </div>
                        <p class="text-[11px] theme-text-muted leading-relaxed">Required for tax compliance and SBP audits. Auto-archived after 5 years.</p>
                        <div class="mt-3 flex justify-end">
                            <button class="text-[10px] theme-brand-text font-bold hover:underline">Edit Policy</button>
                        </div>
                    </div>

                    <div class="p-4 theme-bg-body border theme-border rounded-lg">
                        <div class="flex justify-between items-start mb-2">
                            <span class="text-xs font-bold theme-text-main">Admin Activity Logs</span>
                            <span class="text-[10px] bg-slate-800 px-2 py-0.5 rounded text-blue-400 border theme-border">12 MONTHS</span>
                        </div>
                        <p class="text-[11px] theme-text-muted leading-relaxed">Internal audit trail. Purged after 1 year unless under legal hold.</p>
                        <div class="mt-3 flex justify-end">
                            <button class="text-[10px] theme-brand-text font-bold hover:underline">Edit Policy</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- RIGHT: ACTIVE LEGAL HOLDS --}}
        <div class="lg:col-span-2 space-y-6">
            <div class="theme-bg-card border theme-border rounded-xl overflow-hidden shadow-sm">
                <div class="p-4 bg-white/5 border-b theme-border flex justify-between items-center">
                    <h3 class="font-bold text-sm uppercase tracking-widest flex items-center gap-2">
                        <i data-lucide="shield-alert" class="w-4 h-4"></i> Active Legal Holds (Frozen Data)
                    </h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm">
                        <thead class="theme-text-muted font-semibold text-[10px] uppercase bg-black/20">
                            <tr>
                                <th class="px-6 py-4">Hold Reference</th>
                                <th class="px-6 py-4">Data Subjects / Scope</th>
                                <th class="px-6 py-4 text-center">Date Applied</th>
                                <th class="px-6 py-4 text-right">Status</th>
                            </tr>
                        </thead>
                        <tbody id="holds-table-body" class="divide-y theme-border">
                            <tr class="hover:bg-white/5 transition-colors group">
                                <td class="px-6 py-4">
                                    <div class="font-bold theme-text-main">LIT-2026-004</div>
                                    <div class="text-[10px] theme-text-muted italic">Fraud Investigation: Order-772x</div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex flex-wrap gap-1">
                                        <span class="bg-blue-500/10 text-blue-400 border border-blue-500/20 text-[9px] px-1.5 py-0.5 rounded">Financials</span>
                                        <span class="bg-blue-500/10 text-blue-400 border border-blue-500/20 text-[9px] px-1.5 py-0.5 rounded">IP Logs</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-center theme-text-muted text-xs">Feb 10, 2026</td>
                                <td class="px-6 py-4 text-right">
                                    <span class="hold-badge status-frozen px-2.5 py-1 rounded text-[10px] font-bold uppercase border">
                                        FROZEN
                                    </span>
                                </td>
                            </tr>

                            <tr class="hover:bg-white/5 transition-colors group">
                                <td class="px-6 py-4">
                                    <div class="font-bold theme-text-main">SEC-9921-DISP</div>
                                    <div class="text-[10px] theme-text-muted italic">Merchant Dispute: Ali_Mart_PK</div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex flex-wrap gap-1">
                                        <span class="bg-blue-500/10 text-blue-400 border border-blue-500/20 text-[9px] px-1.5 py-0.5 rounded">KYC Docs</span>
                                        <span class="bg-blue-500/10 text-blue-400 border border-blue-500/20 text-[9px] px-1.5 py-0.5 rounded">Payouts</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-center theme-text-muted text-xs">Jan 15, 2026</td>
                                <td class="px-6 py-4 text-right">
                                    <span class="status-frozen px-2.5 py-1 rounded text-[10px] font-bold uppercase border">
                                        FROZEN
                                    </span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- AUTOMATION ALERT --}}
            <div class="p-4 border border-yellow-500/20 bg-yellow-500/5 rounded-xl flex items-start gap-4">
                <i data-lucide="info" class="w-5 h-5 text-yellow-500 shrink-0"></i>
                <div>
                    <p class="text-sm font-bold text-yellow-500">Scheduled Data Purge</p>
                    <p class="text-xs text-yellow-600/80 leading-relaxed">The next automated cleanup is scheduled for <strong>Sunday, March 1st (00:00 UTC)</strong>. Approximately 1.2M expired log entries will be purged. Frozen data will be excluded.</p>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection

@push('scripts')
<script src="https://unpkg.com/lucide@latest"></script>
<script>
    document.addEventListener("DOMContentLoaded", () => {
        lucide.createIcons();
    });
</script>
@endpush