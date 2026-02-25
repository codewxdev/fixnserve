@extends('layouts.app')

@section('title', 'Audit Search & Forensics')

@section('content')
<div class="min-h-screen theme-bg-body theme-text-main max-w-[1400px] mx-auto px-4 sm:px-6 lg:px-8 py-8">

    {{-- SEARCH & FILTERS --}}
    <div class="theme-bg-card border theme-border rounded-xl p-6 mb-8 shadow-lg">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-6">
            <div>
                <h1 class="text-2xl font-bold flex items-center gap-3">
                    <i data-lucide="microscope" class="w-7 h-7 theme-brand-text"></i>
                    Forensic Replay Hub
                </h1>
                <p class="theme-text-muted mt-1 text-sm">Reconstruct actor timelines and system states for deep-dive investigations.</p>
            </div>
            {{-- <button class="px-4 py-2 theme-brand-bg text-white rounded-lg text-sm font-bold flex items-center gap-2" style="background-color: rgb(var(--brand-primary));">
                <i data-lucide="file-archive" class="w-4 h-4"></i> Export Forensic Bundle
            </button> --}}
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="relative">
                <label class="text-[10px] font-bold theme-text-muted uppercase mb-1 block">Actor or Entity ID</label>
                <input type="text" placeholder="e.g. ADM-001 or USR-9921" class="w-full theme-bg-body border theme-border rounded-lg px-4 py-2 text-sm outline-none focus:ring-1 focus:ring-blue-500">
            </div>
            <div>
                <label class="text-[10px] font-bold theme-text-muted uppercase mb-1 block">Investigation Window</label>
                <select class="w-full theme-bg-body border theme-border rounded-lg px-4 py-2 text-sm outline-none">
                    <option>Last 24 Hours</option>
                    <option>Last 7 Days</option>
                    <option>Custom Range...</option>
                </select>
            </div>
            <div class="flex items-end">
                <button class="w-full py-2 bg-white/5 border theme-border rounded-lg text-sm font-bold hover:bg-white/10 transition-all">
                    START RECONSTRUCTION
                </button>
            </div>
        </div>
    </div>

    {{-- TIMELINE REPLAY --}}
    <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
        
        {{-- CASE SUMMARY --}}
        <div class="lg:col-span-1 space-y-6">
            <div class="theme-bg-card border theme-border rounded-xl p-5">
                <h3 class="text-xs font-bold theme-text-muted uppercase tracking-widest mb-4">Reconstruction Metadata</h3>
                <div class="space-y-4 text-sm">
                    <div>
                        <p class="theme-text-muted text-[10px] uppercase">Primary Actor</p>
                        <p class="font-bold">Sarah Connor (Admin)</p>
                    </div>
                    <div>
                        <p class="theme-text-muted text-[10px] uppercase">Total Events Found</p>
                        <p class="font-bold">42 Actions</p>
                    </div>
                    <div>
                        <p class="theme-text-muted text-[10px] uppercase">Risk Correlation</p>
                        <p class="text-orange-400 font-bold italic">Anomaly Detected (IP Shift)</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- VERTICAL TIMELINE --}}
        <div class="lg:col-span-3">
            <div class="timeline-container space-y-8">
                
                <div class="relative group">
                    <div class="timeline-dot mt-1"></div>
                    <div class="theme-bg-card border theme-border p-5 rounded-xl forensic-marker transition-all group-hover:border-blue-500/50">
                        <div class="flex justify-between items-start mb-2">
                            <span class="text-xs font-mono theme-text-muted">2026-02-24 09:15:02 UTC</span>
                            <span class="px-2 py-0.5 rounded bg-blue-500/10 text-blue-400 text-[10px] font-bold border border-blue-500/20">AUTH_LOGIN</span>
                        </div>
                        <h4 class="font-bold text-sm mb-1">Admin Session Initiated</h4>
                        <p class="text-xs theme-text-muted">Logged in from <span class="theme-text-main">192.168.1.45</span> via Chrome 122.0.0 (Windows).</p>
                    </div>
                </div>

                <div class="relative group">
                    <div class="timeline-dot mt-1"></div>
                    <div class="theme-bg-card border theme-border p-5 rounded-xl transition-all group-hover:border-blue-500/50">
                        <div class="flex justify-between items-start mb-2">
                            <span class="text-xs font-mono theme-text-muted">2026-02-24 09:22:15 UTC</span>
                            <span class="px-2 py-0.5 rounded bg-orange-500/10 text-orange-400 text-[10px] font-bold border border-orange-500/20">CONFIG_CHANGE</span>
                        </div>
                        <h4 class="font-bold text-sm mb-1">Emergency Feature Flag Override</h4>
                        <p class="text-xs theme-text-muted">Modified property <code class="bg-black/30 px-1 rounded">payout_bypass_limit</code> from <span class="text-red-400">false</span> to <span class="text-emerald-400">true</span>.</p>
                        <div class="mt-3 p-3 theme-bg-body border theme-border rounded text-[10px] font-mono text-slate-400">
                            Reason: "Investigating delay in merchant payouts - TKT-882"
                        </div>
                    </div>
                </div>

                <div class="relative group">
                    <div class="timeline-dot mt-1" style="border-color: #ef4444;"></div>
                    <div class="theme-bg-card border-2 border-red-500/30 p-5 rounded-xl bg-red-500/5">
                        <div class="flex justify-between items-start mb-2">
                            <span class="text-xs font-mono text-red-400">2026-02-24 09:45:00 UTC</span>
                            <span class="px-2 py-0.5 rounded bg-red-500/20 text-red-400 text-[10px] font-bold border border-red-500/40">RISK_ALERT</span>
                        </div>
                        <h4 class="font-bold text-sm text-red-400 mb-1">Unusual Payout Pattern Detected</h4>
                        <p class="text-xs theme-text-main">Bulk payout of <span class="font-bold">$12,000</span> triggered immediately after config change.</p>
                    </div>
                </div>

            </div>

            {{-- END OF TIMELINE --}}
            <div class="mt-8 text-center">
                <p class="text-xs theme-text-muted italic flex items-center justify-center gap-2">
                    <i data-lucide="anchor" class="w-3 h-3"></i> End of recorded activity for this window.
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