@extends('layouts.app')

@section('title', 'Security & Access Audit')

@section('content')
<div class="min-h-screen theme-bg-body theme-text-main max-w-[1400px] mx-auto px-4 sm:px-6 lg:px-8 py-8">

    {{-- HEADER --}}
    <div class="mb-8 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
        <div>
            <h1 class="text-2xl font-bold flex items-center gap-3">
                <i data-lucide="shield-check" class="w-7 h-7 theme-brand-text"></i>
                Security & Access Audit
            </h1>
            <p class="theme-text-muted mt-1 text-sm">Real-time monitoring of authentication integrity and access patterns.</p>
        </div>
        {{-- <div class="flex gap-3">
            <button class="px-4 py-2 bg-red-500/10 border border-red-500/20 text-red-400 rounded-lg text-sm font-medium hover:bg-red-500/20 transition-colors flex items-center gap-2">
                <i data-lucide="unplug" class="w-4 h-4"></i> Revoke All Global Sessions
            </button>
        </div> --}}
    </div>

    {{-- RISK ANALYTICS CARDS --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="theme-bg-card border theme-border p-5 rounded-xl flex items-center gap-4">
            <div class="w-12 h-12 rounded-full bg-red-500/20 flex items-center justify-center text-red-500 pulse-red">
                <i data-lucide="alert-triangle"></i>
            </div>
            <div>
                <p class="text-xs theme-text-muted uppercase font-bold">Failed Logins (24h)</p>
                <p class="text-2xl font-bold">142 <span class="text-xs text-red-400 font-normal ml-1">+12% ↑</span></p>
            </div>
        </div>
        <div class="theme-bg-card border theme-border p-5 rounded-xl flex items-center gap-4">
            <div class="w-12 h-12 rounded-full bg-yellow-500/20 flex items-center justify-center text-yellow-500">
                <i data-lucide="fingerprint"></i>
            </div>
            <div>
                <p class="text-xs theme-text-muted uppercase font-bold">MFA Challenges</p>
                <p class="text-2xl font-bold">892 <span class="text-xs text-emerald-400 font-normal ml-1">98% Success</span></p>
            </div>
        </div>
        <div class="theme-bg-card border theme-border p-5 rounded-xl flex items-center gap-4">
            <div class="w-12 h-12 rounded-full bg-blue-500/20 flex items-center justify-center text-blue-500">
                <i data-lucide="key"></i>
            </div>
            <div>
                <p class="text-xs theme-text-muted uppercase font-bold">Token Rotations</p>
                <p class="text-2xl font-bold">3,104</p>
            </div>
        </div>
    </div>

    {{-- SECURITY EVENT FEED --}}
    <div class="theme-bg-card rounded-xl shadow-sm border theme-border overflow-hidden">
        <div class="p-4 border-b theme-border flex flex-col md:flex-row justify-between items-center bg-white/5">
            <h3 class="font-semibold text-sm uppercase tracking-widest flex items-center gap-2">
                <i data-lucide="activity" class="w-4 h-4"></i> Access Integrity Feed
            </h3>
            <div class="flex gap-2">
                <select class="theme-bg-body border theme-border rounded-lg px-3 py-1.5 text-sm theme-text-main outline-none">
                    <option>All Risk Levels</option>
                    <option class="text-red-400">High Risk Only</option>
                    <option class="text-yellow-400">Medium Risk</option>
                </select>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="theme-text-muted font-semibold text-xs uppercase" style="background-color: rgba(var(--bg-body), 0.8);">
                    <tr>
                        <th class="px-6 py-4">Event Type</th>
                        <th class="px-6 py-4">Identity / Actor</th>
                        <th class="px-6 py-4">Geo-Location & IP</th>
                        <th class="px-6 py-4">Risk Level</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4 text-right">Action</th>
                    </tr>
                </thead>
                <tbody id="security-event-body" class="divide-y theme-border">
                    </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://unpkg.com/lucide@latest"></script>
<script>
    const securityEvents = [
        {
            event: "Failed Login Attempt",
            actor: "user_9921 (Vendor Portal)",
            location: "Rawalpindi, PK (182.180.x.x)",
            device: "Chrome / Windows 11",
            risk: "High",
            status: "Blocked",
            time: "2 mins ago",
            note: "Brute force pattern detected from same IP subnet."
        },
        {
            event: "MFA Challenge",
            actor: "adm_sarah (Admin Panel)",
            location: "London, UK (81.12.x.x)",
            device: "iPhone 15 / Safari",
            risk: "Low",
            status: "Verified",
            time: "15 mins ago",
            note: "Routine MFA verification on login."
        },
        {
            event: "Session Revocation",
            actor: "system_auto",
            location: "Cloud Node (Internal)",
            device: "API Service",
            risk: "Medium",
            status: "Terminated",
            time: "1 hour ago",
            note: "Admin token rotated due to 24h expiration policy."
        }
    ];

    document.addEventListener("DOMContentLoaded", () => {
        renderEvents(securityEvents);
        lucide.createIcons();
    });

    function renderEvents(events) {
        const tbody = document.getElementById('security-event-body');
        tbody.innerHTML = '';

        events.forEach(ev => {
            const riskClass = `risk-${ev.risk.toLowerCase()}`;
            tbody.insertAdjacentHTML('beforeend', `
                <tr class="hover:bg-white/5 transition-colors">
                    <td class="px-6 py-4">
                        <div class="font-bold theme-text-main">${ev.event}</div>
                        <div class="text-[10px] theme-text-muted">${ev.time}</div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="theme-text-main font-medium">${ev.actor}</div>
                        <div class="text-[10px] theme-text-muted font-mono">${ev.device}</div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-1.5 theme-text-main">
                            <i data-lucide="map-pin" class="w-3.5 h-3.5 text-blue-400"></i>
                            ${ev.location}
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <span class="px-2.5 py-1 rounded text-[10px] font-bold uppercase border ${riskClass}">
                            ${ev.risk}
                        </span>
                    </td>
                    <td class="px-6 py-4 font-medium ${ev.status === 'Blocked' || ev.status === 'Terminated' ? 'text-red-400' : 'text-emerald-400'}">
                        ${ev.status}
                    </td>
                    <td class="px-6 py-4 text-right">
                        <button class="p-2 theme-bg-body border theme-border rounded hover:bg-red-500/10 hover:text-red-400 transition-all shadow-sm" title="Investigate Anomaly">
                            <i data-lucide="search-code" class="w-4 h-4"></i>
                        </button>
                    </td>
                </tr>
            `);
        });
        lucide.createIcons();
    }
</script>
@endpush