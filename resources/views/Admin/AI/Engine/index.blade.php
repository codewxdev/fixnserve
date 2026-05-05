@extends('layouts.app')
@section('title', 'Automation Rule Engine | AI & Automation')
@section('content')
<div class="p-4 sm:p-6 lg:p-8 bg-bg-primary min-h-screen">
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-h3 font-bold text-text-primary">Automation Rule Engine</h1>
            <p class="text-body-sm text-text-secondary mt-1">Configure If/Then, threshold, and event-based composite rules for auto-remediation.</p>
        </div>
        <button class="btn btn-primary py-2.5 px-4 shadow-sm transition-colors"><i data-lucide="plus" class="w-4 h-4 mr-2"></i> Create Rule</button>
    </div>

    <!-- Active Rules -->
    <div class="card p-0 shadow-sm border-border-default">
        <div class="p-5 border-b border-border-default bg-bg-tertiary">
            <h3 class="text-h4 font-bold text-text-primary">Configured Rules</h3>
        </div>
        <table class="w-full text-left whitespace-nowrap">
            <thead class="text-caption uppercase text-text-secondary font-semibold border-b border-border-strong bg-bg-primary">
                <tr>
                    <th class="px-6 py-4">Rule Logic</th>
                    <th class="px-6 py-4">Rule Type</th>
                    <th class="px-6 py-4">Action Taken</th>
                    <th class="px-6 py-4 text-right">Status</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-border-default">
                <tr class="hover:bg-bg-secondary transition-colors">
                    <td class="px-6 py-4">
                        <p class="text-body-sm font-bold text-text-primary"><span class="text-brand-primary">IF</span> Failed Txns > 10 <span class="text-brand-primary">IN</span> 5 Mins</p>
                    </td>
                    <td class="px-6 py-4"><span class="px-2 py-0.5 bg-bg-muted border border-border-strong rounded text-caption">Threshold-based</span></td>
                    <td class="px-6 py-4 text-caption text-text-secondary">Auto-Block & Escalate</td>
                    <td class="px-6 py-4 text-right">
                        <div class="w-8 h-4 bg-brand-primary rounded-full relative inline-block cursor-pointer"><div class="w-3 h-3 bg-white rounded-full absolute right-0.5 top-0.5"></div></div>
                    </td>
                </tr>
                <tr class="hover:bg-bg-secondary transition-colors">
                    <td class="px-6 py-4">
                        <p class="text-body-sm font-bold text-text-primary"><span class="text-brand-primary">IF</span> Support Agent Impersonates <span class="text-brand-primary">THEN</span></p>
                    </td>
                    <td class="px-6 py-4"><span class="px-2 py-0.5 bg-bg-muted border border-border-strong rounded text-caption">Event-based</span></td>
                    <td class="px-6 py-4 text-caption text-text-secondary">Notify Ops Lead (Slack)</td>
                    <td class="px-6 py-4 text-right">
                        <div class="w-8 h-4 bg-brand-primary rounded-full relative inline-block cursor-pointer"><div class="w-3 h-3 bg-white rounded-full absolute right-0.5 top-0.5"></div></div>
                    </td>
                </tr>
                <tr class="hover:bg-bg-secondary transition-colors">
                    <td class="px-6 py-4">
                        <p class="text-body-sm font-bold text-text-primary"><span class="text-brand-primary">IF</span> AI Fraud Score > 90 <span class="text-brand-primary">AND</span> Weekend</p>
                    </td>
                    <td class="px-6 py-4"><span class="px-2 py-0.5 bg-bg-muted border border-border-strong rounded text-caption">Composite</span></td>
                    <td class="px-6 py-4 text-caption text-text-secondary">Wallet Freeze (Auto-remediate)</td>
                    <td class="px-6 py-4 text-right">
                        <div class="w-8 h-4 bg-brand-primary rounded-full relative inline-block cursor-pointer"><div class="w-3 h-3 bg-white rounded-full absolute right-0.5 top-0.5"></div></div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection