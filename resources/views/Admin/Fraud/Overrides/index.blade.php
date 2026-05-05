@extends('layouts.app')
@section('title', 'Manual Overrides | Fraud')
@section('content')
    <div class="p-4 sm:p-6 lg:p-8 bg-bg-primary min-h-screen">
        <div class="flex justify-between items-center mb-8">
            <div>
                <h1 class="text-h3 font-bold text-text-primary">Manual Overrides & Exceptions</h1>
                <p class="text-body-sm text-text-secondary mt-1">Unfreeze accounts, override scores, and manage whitelists.
                    Enforces dual approval.</p>
            </div>
            <button class="btn btn-primary py-2.5 px-4 shadow-sm transition-colors"><i data-lucide="shield"
                    class="w-4 h-4 mr-2"></i> Request Override</button>
        </div>

        <!-- Active Exceptions / Whitelists -->
        <div class="mb-8 card p-0 shadow-sm border-semantic-info/30">
            <div class="p-5 border-b border-border-default bg-semantic-info/5 flex justify-between items-center">
                <h3 class="text-body font-bold text-text-primary flex items-center gap-2"><i data-lucide="check-circle"
                        class="w-4 h-4 text-semantic-info"></i> Active Whitelists & Overrides</h3>
            </div>
            <table class="w-full text-left whitespace-nowrap">
                <thead
                    class="text-caption uppercase text-text-secondary font-semibold border-b border-border-strong bg-bg-primary">
                    <tr>
                        <th class="px-6 py-4">Subject</th>
                        <th class="px-6 py-4">Override Type</th>
                        <th class="px-6 py-4">Justification</th>
                        <th class="px-6 py-4">Expiry (Max 30d)</th>
                        <th class="px-6 py-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-border-default">
                    <tr class="hover:bg-bg-secondary transition-colors">
                        <td class="px-6 py-4 text-body-sm font-bold text-text-primary">GlobalCorp (B-001)</td>
                        <td class="px-6 py-4 text-caption"><span
                                class="px-2 py-0.5 bg-bg-muted border border-border-strong rounded text-text-secondary">Velocity
                                Whitelist</span></td>
                        <td class="px-6 py-4 text-caption text-text-secondary truncate max-w-xs">Approved high-volume
                            seasonal sale weekend.</td>
                        <td class="px-6 py-4 text-caption text-semantic-warning font-bold">2 Days Left</td>
                        <td class="px-6 py-4 text-right"><button
                                class="text-semantic-error hover:underline text-caption font-bold">Revoke</button></td>
                    </tr>
                    <tr class="hover:bg-bg-secondary transition-colors">
                        <td class="px-6 py-4 text-body-sm font-bold text-text-primary">Admin_Tariq (ID: 45)</td>
                        <td class="px-6 py-4 text-caption"><span
                                class="px-2 py-0.5 bg-bg-muted border border-border-strong rounded text-text-secondary">Geo
                                Exception</span></td>
                        <td class="px-6 py-4 text-caption text-text-secondary truncate max-w-xs">Traveling for regional
                            conference.</td>
                        <td class="px-6 py-4 text-caption text-text-primary font-bold">14 Days Left</td>
                        <td class="px-6 py-4 text-right"><button
                                class="text-semantic-error hover:underline text-caption font-bold">Revoke</button></td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Dual Approval Queue -->
        <div class="card p-0 shadow-sm border-border-default">
            <div class="p-5 border-b border-border-default bg-bg-tertiary flex justify-between items-center">
                <h3 class="text-h4 font-bold text-text-primary">Pending Dual Approvals</h3>
                <span
                    class="px-2 py-1 text-[10px] uppercase font-bold bg-semantic-warning-bg text-semantic-warning rounded border border-semantic-warning/20">Requires
                    Risk Officer</span>
            </div>
            <div class="p-6">
                <div
                    class="p-4 border border-semantic-warning/30 rounded-lg bg-bg-primary flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                    <div>
                        <h4 class="text-body-sm font-bold text-text-primary flex items-center gap-2"><i data-lucide="unlock"
                                class="w-4 h-4 text-semantic-warning"></i> Unfreeze Account Request</h4>
                        <p class="text-caption text-text-secondary mt-1">Target: <strong
                                class="text-text-primary">B-902</strong> | Requested By: <strong
                                class="text-text-primary">Support Agent 12</strong></p>
                        <div
                            class="mt-3 p-3 bg-bg-muted rounded text-caption italic text-text-secondary border-l-2 border-l-border-strong">
                            "Client provided extensive KYC documentation proving synthetic identity flag was a false
                            positive due to system glitch. All docs verified."
                        </div>
                    </div>
                    <div class="flex gap-2 w-full md:w-auto shrink-0">
                        <button
                            class="btn btn-secondary p-2 text-semantic-error border-semantic-error/30 hover:bg-semantic-error/10 transition-colors w-full md:w-auto">Reject</button>
                        <button
                            class="btn btn-secondary p-2 text-semantic-success border-semantic-success/30 hover:bg-semantic-success/10 transition-colors w-full md:w-auto">Approve
                            & Unfreeze</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
