@extends('layouts.app')

@section('title', 'Compliance Monitoring & Alerts')

@push('styles')
<style>
    .theme-bg-body { background-color: rgb(var(--bg-body)); }
    .theme-bg-card { background-color: rgb(var(--bg-card)); }
    .theme-border { border-color: rgb(var(--border-color)); }
    .theme-text-main { color: rgb(var(--text-main)); }
    .theme-text-muted { color: rgb(var(--text-muted)); }
    .theme-brand-text { color: rgb(var(--brand-primary)); }

    /* Custom Toggle Switch for Dark Theme */
    .switch { position: relative; display: inline-block; width: 44px; height: 22px; }
    .switch input { opacity: 0; width: 0; height: 0; }
    .slider { position: absolute; cursor: pointer; top: 0; left: 0; right: 0; bottom: 0; background-color: #334155; transition: .4s; border-radius: 34px; }
    .slider:before { position: absolute; content: ""; height: 16px; width: 16px; left: 3px; bottom: 3px; background-color: white; transition: .4s; border-radius: 50%; }
    input:checked + .slider { background-color: rgb(var(--brand-primary)); }
    input:checked + .slider:before { transform: translateX(22px); }

    /* Alert Severity Indicators */
    .severity-p0 { border-left: 4px solid #ef4444; } /* Critical */
    .severity-p1 { border-left: 4px solid #f59e0b; } /* Warning */
</style>
@endpush

@section('content')
<div class="min-h-screen theme-bg-body theme-text-main max-w-[1400px] mx-auto px-4 sm:px-6 lg:px-8 py-8">

    {{-- HEADER --}}
    <div class="mb-8 flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold flex items-center gap-3">
                <i data-lucide="bell-ring" class="w-7 h-7 theme-brand-text"></i>
                Compliance Monitoring & Alerts
            </h1>
            <p class="theme-text-muted mt-1 text-sm">Configure automated triggers for policy violations and anomalous behavior.</p>
        </div>
        <div class="flex gap-2">
            <span class="flex items-center gap-2 px-3 py-1 bg-emerald-500/10 text-emerald-400 border border-emerald-500/20 rounded-full text-xs font-bold">
                <span class="w-2 h-2 bg-emerald-500 rounded-full animate-pulse"></span> SYSTEM HEALTH: OPTIMAL
            </span>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        {{-- LEFT: ALERT RULES CONFIGURATOR --}}
        <div class="lg:col-span-2 space-y-6">
            <div class="theme-bg-card border theme-border rounded-xl shadow-sm overflow-hidden">
                <div class="p-4 bg-white/5 border-b theme-border font-bold text-sm uppercase tracking-widest flex items-center gap-2">
                    <i data-lucide="shield-check" class="w-4 h-4"></i> Active Monitoring Rules
                </div>
                
                <div class="divide-y theme-border">
                    <div class="p-6 flex items-start justify-between gap-4">
                        <div class="flex gap-4">
                            <div class="p-3 theme-bg-body rounded-lg border theme-border">
                                <i data-lucide="users-2" class="w-5 h-5 theme-text-muted"></i>
                            </div>
                            <div>
                                <h4 class="font-bold text-sm">Mass Entity Deletion</h4>
                                <p class="text-xs theme-text-muted mt-1">Trigger alert if > 10 users are deleted within 5 minutes by a single admin.</p>
                                <div class="mt-2 flex items-center gap-3">
                                    <span class="text-[10px] font-bold text-red-400 uppercase">Severity: Critical (P0)</span>
                                    <span class="text-[10px] theme-text-muted">Channel: Email, Slack</span>
                                </div>
                            </div>
                        </div>
                        <label class="switch">
                            <input type="checkbox" checked>
                            <span class="slider"></span>
                        </label>
                    </div>

                    <div class="p-6 flex items-start justify-between gap-4">
                        <div class="flex gap-4">
                            <div class="p-3 theme-bg-body rounded-lg border theme-border">
                                <i data-lucide="map" class="w-5 h-5 theme-text-muted"></i>
                            </div>
                            <div>
                                <h4 class="font-bold text-sm">Geo-Velocity Violation</h4>
                                <p class="text-xs theme-text-muted mt-1">Detect logins from two different countries within a 1-hour window.</p>
                                <div class="mt-2 flex items-center gap-3">
                                    <span class="text-[10px] font-bold text-orange-400 uppercase">Severity: Warning (P1)</span>
                                    <span class="text-[10px] theme-text-muted">Channel: Push Notification</span>
                                </div>
                            </div>
                        </div>
                        <label class="switch">
                            <input type="checkbox" checked>
                            <span class="slider"></span>
                        </label>
                    </div>
                </div>
                
                <div class="p-4 bg-white/5 text-center">
                    <button class="text-xs font-bold theme-brand-text hover:underline flex items-center gap-1 mx-auto">
                        <i data-lucide="plus" class="w-3 h-3"></i> ADD CUSTOM MONITORING RULE
                    </button>
                </div>
            </div>
        </div>

        {{-- RIGHT: RECENT INCIDENT LOG --}}
        <div class="space-y-6">
            <div class="theme-bg-card border theme-border rounded-xl shadow-sm">
                <div class="p-4 bg-white/5 border-b theme-border font-bold text-sm uppercase tracking-widest flex items-center gap-2">
                    <i data-lucide="history" class="w-4 h-4"></i> Triggered Incidents
                </div>
                <div class="p-4 space-y-4">
                    <div class="p-3 theme-bg-body border theme-border rounded-lg severity-p0">
                        <div class="flex justify-between items-start mb-1">
                            <span class="text-[10px] font-bold text-red-400">CRITICAL</span>
                            <span class="text-[9px] theme-text-muted font-mono">10m ago</span>
                        </div>
                        <p class="text-xs font-bold">Failed MFA Threshold</p>
                        <p class="text-[11px] theme-text-muted mt-1">Admin 'kashif_p' failed 5 MFA attempts.</p>
                        <div class="mt-2 flex gap-2">
                            <button class="px-2 py-1 bg-red-500/10 text-red-400 border border-red-500/20 text-[9px] font-bold rounded">LOCK ACCOUNT</button>
                            <button class="px-2 py-1 theme-bg-card border theme-border text-[9px] font-bold rounded">DISMISS</button>
                        </div>
                    </div>

                    <div class="p-3 theme-bg-body border theme-border rounded-lg severity-p1">
                        <div class="flex justify-between items-start mb-1">
                            <span class="text-[10px] font-bold text-orange-400">WARNING</span>
                            <span class="text-[9px] theme-text-muted font-mono">2h ago</span>
                        </div>
                        <p class="text-xs font-bold">Off-Hours Admin Login</p>
                        <p class="text-[11px] theme-text-muted mt-1">Admin access at 03:00 AM PKT.</p>
                    </div>
                </div>
            </div>

            {{-- NOTIFICATION SETTINGS --}}
            <div class="theme-bg-card border theme-border rounded-xl p-5">
                <h3 class="text-xs font-bold theme-text-muted uppercase tracking-widest mb-4">Escalation Channels</h3>
                <div class="space-y-3">
                    <div class="flex items-center justify-between text-xs">
                        <span class="flex items-center gap-2"><i data-lucide="mail" class="w-3.5 h-3.5"></i> Email (SOC Team)</span>
                        <span class="text-emerald-500 font-bold">ACTIVE</span>
                    </div>
                    <div class="flex items-center justify-between text-xs">
                        <span class="flex items-center gap-2"><i data-lucide="slack" class="w-3.5 h-3.5"></i> Slack #security-ops</span>
                        <span class="text-emerald-500 font-bold">ACTIVE</span>
                    </div>
                    <div class="flex items-center justify-between text-xs opacity-50">
                        <span class="flex items-center gap-2"><i data-lucide="phone-call" class="w-3.5 h-3.5"></i> SMS Alert</span>
                        <span class="theme-text-muted">DISABLED</span>
                    </div>
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