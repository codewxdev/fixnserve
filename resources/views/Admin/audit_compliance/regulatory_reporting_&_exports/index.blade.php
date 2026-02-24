@extends('layouts.app')

@section('title', 'Regulatory Reporting & Exports')

@section('content')
<div class="min-h-screen theme-bg-body theme-text-main max-w-[1400px] mx-auto px-4 sm:px-6 lg:px-8 py-8">

    {{-- HEADER --}}
    <div class="mb-8">
        <h1 class="text-2xl font-bold flex items-center gap-3">
            <i data-lucide="file-box" class="w-7 h-7 theme-brand-text"></i>
            Regulatory Reporting & Exports
        </h1>
        <p class="theme-text-muted mt-1 text-sm">Assemble and export court-grade compliance packages for legal and regulatory authorities.</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        {{-- LEFT COLUMN: EXPORT CONFIGURATOR --}}
        <div class="lg:col-span-2 space-y-6">
            <div class="theme-bg-card border theme-border rounded-xl p-6 shadow-sm">
                <h3 class="font-bold text-lg mb-4 flex items-center gap-2">
                    <i data-lucide="settings-2" class="w-5 h-5 theme-text-muted"></i> 1. Select Export Scope
                </h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <label class="export-card border theme-border p-4 rounded-lg cursor-pointer hover:bg-white/5 transition-all flex items-start gap-4">
                        <input type="checkbox" class="mt-1 accent-blue-500">
                        <div>
                            <p class="font-bold text-sm">Financial Activity</p>
                            <p class="text-xs theme-text-muted">Wallet logs, payouts, and commission reconciliations.</p>
                        </div>
                    </label>

                    <label class="export-card border theme-border p-4 rounded-lg cursor-pointer hover:bg-white/5 transition-all flex items-start gap-4">
                        <input type="checkbox" class="mt-1 accent-blue-500">
                        <div>
                            <p class="font-bold text-sm">KYC & AML Logs</p>
                            <p class="text-xs theme-text-muted">Identity verification history and sanctions screening.</p>
                        </div>
                    </label>

                    <label class="export-card border theme-border p-4 rounded-lg cursor-pointer hover:bg-white/5 transition-all flex items-start gap-4">
                        <input type="checkbox" class="mt-1 accent-blue-500">
                        <div>
                            <p class="font-bold text-sm">Disputes & Resolutions</p>
                            <p class="text-xs theme-text-muted">Refund tickets and court-ready dispute evidence.</p>
                        </div>
                    </label>

                    <label class="export-card border theme-border p-4 rounded-lg cursor-pointer hover:bg-white/5 transition-all flex items-start gap-4">
                        <input type="checkbox" class="mt-1 accent-blue-500">
                        <div>
                            <p class="font-bold text-sm">Fraud Incidents</p>
                            <p class="text-xs theme-text-muted">Suspicious login patterns and IP blacklist data.</p>
                        </div>
                    </label>
                </div>

                <div class="mt-8 pt-6 border-t theme-border grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-xs font-bold theme-text-muted uppercase mb-2">Time Range Selection</label>
                        <div class="flex gap-2">
                            <input type="date" class="flex-1 theme-bg-body border theme-border rounded px-3 py-2 text-sm outline-none">
                            <input type="date" class="flex-1 theme-bg-body border theme-border rounded px-3 py-2 text-sm outline-none">
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs font-bold theme-text-muted uppercase mb-2">Jurisdiction Template</label>
                        <select class="w-full theme-bg-body border theme-border rounded px-3 py-2 text-sm outline-none">
                            <option>Pakistan (SECP/SBP)</option>
                            <option>EU (GDPR Compliance)</option>
                            <option>USA (FINCEN/AML)</option>
                        </select>
                    </div>
                </div>

                <div class="mt-6">
                    <button class="w-full py-3 theme-brand-bg rounded-lg font-bold text-white shadow-lg hover:opacity-90 transition-all flex items-center justify-center gap-3" style="background-color: rgb(var(--brand-primary));">
                        <i data-lucide="package-plus"></i> GENERATE SECURE PACKAGE
                    </button>
                </div>
            </div>
        </div>

        {{-- RIGHT COLUMN: RECENT EXPORTS (DOWNLOADS) --}}
        <div class="space-y-6">
            <div class="theme-bg-card border theme-border rounded-xl overflow-hidden shadow-sm">
                <div class="p-4 bg-white/5 border-b theme-border font-bold text-sm uppercase tracking-widest flex items-center gap-2">
                    <i data-lucide="history" class="w-4 h-4"></i> Secure Vault
                </div>
                <div class="p-4 space-y-4" id="export-history-list">
                    <div class="p-3 theme-bg-body border theme-border rounded-lg relative overflow-hidden group">
                        <div class="flex justify-between items-start mb-2">
                            <span class="text-[10px] font-bold px-2 py-0.5 rounded-full bg-emerald-500/10 text-emerald-400 border border-emerald-500/20 uppercase">Ready</span>
                            <span class="text-[10px] theme-text-muted font-mono">24-FEB-2026</span>
                        </div>
                        <p class="text-sm font-bold truncate">Q1_Financial_Audit_v2.zip</p>
                        <div class="mt-3 flex items-center justify-between">
                            <span class="text-[10px] theme-text-muted flex items-center gap-1">
                                <i data-lucide="key-round" class="w-3 h-3"></i> AES-256 Encrypted
                            </span>
                            <button class="text-blue-400 hover:text-blue-300 text-xs font-bold flex items-center gap-1">
                                <i data-lucide="download" class="w-3 h-3"></i> DOWNLOAD
                            </button>
                        </div>
                        <div class="mt-2 h-0.5 w-full bg-slate-800 rounded-full">
                            <div class="h-full bg-blue-500 rounded-full" style="width: 40%" title="Expires in 4 hours"></div>
                        </div>
                        <p class="text-[9px] theme-text-muted mt-1 italic text-right">Expires in 4h 12m</p>
                    </div>

                    <div class="p-3 theme-bg-body border theme-border rounded-lg opacity-80">
                        <div class="flex justify-between items-start mb-2">
                            <span class="text-[10px] font-bold px-2 py-0.5 rounded-full bg-blue-500/10 text-blue-400 border border-blue-500/20 uppercase animate-pulse">Assembling</span>
                            <span class="text-[10px] theme-text-muted font-mono">24-FEB-2026</span>
                        </div>
                        <p class="text-sm font-bold truncate">AML_Sanction_Scan_PK.pdf</p>
                        <div class="mt-2 flex items-center gap-2">
                            <div class="flex-1 bg-slate-800 h-1 rounded-full overflow-hidden">
                                <div class="bg-blue-500 h-full w-2/3 animate-progress"></div>
                            </div>
                            <span class="text-[10px] theme-text-muted italic">65%</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- AUDIT NOTE --}}
            <div class="p-4 border border-dashed theme-border rounded-xl">
                <p class="text-[11px] theme-text-muted leading-relaxed">
                    <i data-lucide="info" class="w-3 h-3 inline mr-1"></i> 
                    All exports are logged and watermarked. Access to these files is restricted by role and subject to mandatory <strong>Audit Replay (20.7)</strong>.
                </p>
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