@extends('layouts.app')
@section('title', 'Admin Overrides | Billing')
@section('content')
<div class="p-4 sm:p-6 lg:p-8 bg-bg-primary min-h-screen">
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-h3 font-bold text-text-primary">Admin Overrides & Exceptions</h1>
            <p class="text-body-sm text-text-secondary mt-1">Manage courtesy extensions, manual plan changes, and pilot pricing. Requires dual approval.</p>
        </div>
        <button class="btn btn-primary px-4 py-2.5 shadow-sm transition-colors"><i data-lucide="plus" class="w-4 h-4 mr-2"></i> Request Override</button>
    </div>

    <div class="card p-0 overflow-hidden shadow-sm mb-8">
        <div class="p-5 bg-bg-tertiary border-b border-border-default flex justify-between items-center">
            <h3 class="text-body font-bold text-text-primary flex items-center gap-2"><i data-lucide="shield-alert" class="w-4 h-4 text-semantic-warning"></i> Active Temporary Overrides</h3>
        </div>
        <table class="w-full text-left">
            <thead class="text-caption uppercase text-text-secondary font-semibold border-b border-border-strong bg-bg-primary">
                <tr>
                    <th class="px-6 py-4">Target Business</th>
                    <th class="px-6 py-4">Override Type</th>
                    <th class="px-6 py-4">Auto-Expiry (Max 30 Days)</th>
                    <th class="px-6 py-4 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-border-default">
                <tr class="hover:bg-bg-secondary transition-colors">
                    <td class="px-6 py-4 text-body-sm font-bold text-text-primary">Elevate Digital (B-1024)</td>
                    <td class="px-6 py-4 text-body-sm text-text-secondary">Courtesy Grace Period Extension</td>
                    <td class="px-6 py-4"><span class="text-semantic-warning font-bold text-caption">Expires in 2 Days</span></td>
                    <td class="px-6 py-4 text-right"><button class="btn btn-sm btn-destructive py-1.5 px-3">Revoke</button></td>
                </tr>
                <tr class="hover:bg-bg-secondary transition-colors">
                    <td class="px-6 py-4 text-body-sm font-bold text-text-primary">Apex Legal (B-1026)</td>
                    <td class="px-6 py-4 text-body-sm text-text-secondary">Special Pilot Pricing ($0/mo)</td>
                    <td class="px-6 py-4"><span class="text-text-primary font-bold text-caption">Expires in 14 Days</span></td>
                    <td class="px-6 py-4 text-right"><button class="btn btn-sm btn-destructive py-1.5 px-3">Revoke</button></td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="card p-0 overflow-hidden shadow-sm">
        <div class="p-5 bg-bg-tertiary border-b border-border-default flex justify-between items-center">
            <h3 class="text-body font-bold text-text-primary flex items-center gap-2"><i data-lucide="file-text" class="w-4 h-4 text-text-secondary"></i> Override Audit Log</h3>
        </div>
        <div class="p-6">
            <div class="flex items-start gap-4 mb-6 relative before:absolute before:inset-y-0 before:left-2 before:w-0.5 before:bg-border-default">
                <div class="w-4 h-4 rounded-full bg-semantic-success relative z-10 mt-1 outline outline-4 outline-bg-primary"></div>
                <div>
                    <p class="text-body-sm font-bold text-text-primary">Courtesy Extension Approved for B-1024</p>
                    <p class="text-caption text-text-secondary mt-1">Requested by: Sarah Jenkins. Approved by: Admin Root. Justification: Client awaiting wire transfer clearance.</p>
                    <p class="text-[10px] text-text-tertiary font-mono mt-1">Today, 09:15 AM</p>
                </div>
            </div>
            <div class="flex items-start gap-4 relative before:absolute before:inset-y-0 before:left-2 before:w-0.5 before:bg-border-default">
                <div class="w-4 h-4 rounded-full bg-semantic-error relative z-10 mt-1 outline outline-4 outline-bg-primary"></div>
                <div>
                    <p class="text-body-sm font-bold text-text-primary">Feature Unlock Request Denied for B-1088</p>
                    <p class="text-caption text-text-secondary mt-1">Requested by: Support Agent. Denied by: Finance Admin. Justification: Does not meet pilot program criteria.</p>
                    <p class="text-[10px] text-text-tertiary font-mono mt-1">Yesterday, 14:30 PM</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection