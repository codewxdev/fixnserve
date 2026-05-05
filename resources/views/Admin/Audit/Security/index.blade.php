@extends('layouts.app')
@section('title', 'Security Audit | Compliance')
@section('content')
<div class="p-4 sm:p-6 lg:p-8 bg-bg-primary min-h-screen">
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-h3 font-bold text-text-primary">Security Event Audit</h1>
            <p class="text-body-sm text-text-secondary mt-1">Monitor authentication anomalies, token rotations, and privilege escalations.</p>
        </div>
    </div>

    <!-- Active Indicators -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
        <div class="p-4 border border-semantic-error/30 bg-semantic-error-bg/20 rounded-lg text-center">
            <p class="text-h3 font-black text-semantic-error">12</p>
            <p class="text-[10px] font-bold text-text-secondary uppercase mt-1">Failed Logins (24h)</p>
        </div>
        <div class="p-4 border border-border-default bg-bg-tertiary rounded-lg text-center">
            <p class="text-h3 font-black text-text-primary">45</p>
            <p class="text-[10px] font-bold text-text-secondary uppercase mt-1">MFA Challenges</p>
        </div>
        <div class="p-4 border border-border-default bg-bg-tertiary rounded-lg text-center">
            <p class="text-h3 font-black text-text-primary">8</p>
            <p class="text-[10px] font-bold text-text-secondary uppercase mt-1">Token Rotations</p>
        </div>
        <div class="p-4 border border-semantic-warning/30 bg-semantic-warning-bg/20 rounded-lg text-center">
            <p class="text-h3 font-black text-semantic-warning">2</p>
            <p class="text-[10px] font-bold text-text-secondary uppercase mt-1">Device Blocks</p>
        </div>
    </div>

    <!-- Security Feed -->
    <div class="card p-0 shadow-sm border-border-default">
        <div class="p-5 border-b border-border-default bg-bg-tertiary">
            <h3 class="text-h4 font-bold text-text-primary">Live Security Feed</h3>
        </div>
        <table class="w-full text-left whitespace-nowrap font-mono text-[11px]">
            <thead class="text-caption uppercase text-text-secondary font-semibold border-b border-border-strong bg-bg-primary">
                <tr>
                    <th class="px-6 py-4">Timestamp</th>
                    <th class="px-6 py-4">Event Type</th>
                    <th class="px-6 py-4">Actor / Target</th>
                    <th class="px-6 py-4">IP Address / Geo</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-border-default">
                <tr class="hover:bg-bg-secondary transition-colors bg-semantic-error-bg/10">
                    <td class="px-6 py-4 text-text-secondary">Today, 12:20:10</td>
                    <td class="px-6 py-4"><span class="text-semantic-error font-bold"><i data-lucide="shield-alert" class="w-3 h-3 inline mr-1"></i> PRIVILEGE_ESCALATION</span></td>
                    <td class="px-6 py-4 text-text-primary">Admin_Ali granted 'Super Admin'</td>
                    <td class="px-6 py-4 text-text-secondary">192.168.1.1 (UAE)</td>
                </tr>
                <tr class="hover:bg-bg-secondary transition-colors">
                    <td class="px-6 py-4 text-text-secondary">Today, 11:45:00</td>
                    <td class="px-6 py-4"><span class="text-semantic-warning font-bold"><i data-lucide="smartphone" class="w-3 h-3 inline mr-1"></i> DEVICE_BLOCKED</span></td>
                    <td class="px-6 py-4 text-text-primary">fp_a8b9...xyz (Unknown Device)</td>
                    <td class="px-6 py-4 text-text-secondary">45.22.1.99 (Russia)</td>
                </tr>
                <tr class="hover:bg-bg-secondary transition-colors">
                    <td class="px-6 py-4 text-text-secondary">Today, 10:15:33</td>
                    <td class="px-6 py-4"><span class="text-brand-primary font-bold"><i data-lucide="key" class="w-3 h-3 inline mr-1"></i> TOKEN_ROTATED</span></td>
                    <td class="px-6 py-4 text-text-primary">API Key (System_Integration)</td>
                    <td class="px-6 py-4 text-text-secondary">Internal</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection