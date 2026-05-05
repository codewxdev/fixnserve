@extends('layouts.app')
@section('title', 'Ticket System | Support')
@section('content')
<div class="p-4 sm:p-6 lg:p-8 bg-bg-primary min-h-screen">
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-h3 font-bold text-text-primary">Ticket System (B2B)</h1>
            <p class="text-body-sm text-text-secondary mt-1">Centralized routing for in-app, email, and WhatsApp channels.</p>
        </div>
        <button class="btn btn-primary py-2.5 px-4 shadow-sm transition-colors"><i data-lucide="plus" class="w-4 h-4 mr-2"></i> Create Ticket</button>
    </div>

    <!-- Priority Queue Overview -->
    <div class="grid grid-cols-2 md:grid-cols-5 gap-4 mb-8">
        <div class="card p-4   bg-semantic-error-bg/30 text-center"><p class="text-h3 font-black text-semantic-error">1</p><p class="text-[10px] font-bold text-semantic-error uppercase mt-1">P0 (Emergency)</p></div>
        <div class="card p-4  bg-semantic-warning/10 text-center"><p class="text-h3 font-black text-semantic-warning">8</p><p class="text-[10px] font-bold text-semantic-warning uppercase mt-1">P1 (Urgent)</p></div>
        <div class="card p-4 border-border-default text-center"><p class="text-h3 font-black text-text-primary">24</p><p class="text-[10px] font-bold text-text-tertiary uppercase mt-1">P2 (High)</p></div>
        <div class="card p-4 border-border-default text-center"><p class="text-h3 font-black text-text-secondary">42</p><p class="text-[10px] font-bold text-text-tertiary uppercase mt-1">P3 (Medium)</p></div>
        <div class="card p-4 border-border-default text-center bg-bg-tertiary"><p class="text-h3 font-black text-text-secondary">85</p><p class="text-[10px] font-bold text-text-tertiary uppercase mt-1">P4 (Low)</p></div>
    </div>

    <!-- Unassigned / Active Tickets -->
    <div class="card p-0 shadow-sm border-border-default">
        <div class="p-5 border-b border-border-default bg-bg-tertiary flex justify-between items-center">
            <h3 class="text-h4 font-bold text-text-primary">Active Queue</h3>
            <div class="flex gap-2">
                <select class="form-input text-sm w-32"><option>All Channels</option><option>WhatsApp</option></select>
                <select class="form-input text-sm w-32"><option>Unassigned</option><option>My Tickets</option></select>
            </div>
        </div>
        <table class="w-full text-left whitespace-nowrap">
            <thead class="text-caption uppercase text-text-secondary font-semibold border-b border-border-strong bg-bg-primary">
                <tr>
                    <th class="px-6 py-4">Ticket Details</th>
                    <th class="px-6 py-4">Priority & Type</th>
                    <th class="px-6 py-4">SLA Status</th>
                    <th class="px-6 py-4 text-right">Action</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-border-default">
                <tr class="hover:bg-bg-secondary transition-colors">
                    <td class="px-6 py-4">
                        <p class="text-body-sm font-bold text-text-primary">API Endpoint Latency</p>
                        <p class="text-caption text-text-secondary mt-0.5">Elevate Digital (B-1024) via <i data-lucide="monitor" class="w-3 h-3 inline"></i> In-App</p>
                    </td>
                    <td class="px-6 py-4">
                        <span class="px-2 py-0.5 text-[10px] font-bold uppercase bg-semantic-warning text-white rounded shadow-sm mr-2">P1 Urgent</span>
                        <span class="text-caption text-text-secondary">Tech Issue</span>
                    </td>
                    <td class="px-6 py-4"><span class="text-caption font-bold text-semantic-warning">Due in 2h 15m</span></td>
                    <td class="px-6 py-4 text-right"><button class="btn btn-sm btn-secondary py-1.5 px-3">Assign to Me</button></td>
                </tr>
                <tr class="hover:bg-bg-secondary transition-colors bg-semantic-error-bg/10">
                    <td class="px-6 py-4">
                        <p class="text-body-sm font-bold text-semantic-error">Account Compromise Reported</p>
                        <p class="text-caption text-text-secondary mt-0.5">Apex Legal (B-1026) via <i data-lucide="message-circle" class="w-3 h-3 inline text-semantic-success"></i> WhatsApp</p>
                    </td>
                    <td class="px-6 py-4">
                        <span class="px-2 py-0.5 text-[10px] font-bold uppercase bg-semantic-error text-white rounded shadow-sm mr-2 animate-pulse">P0 Emergency</span>
                        <span class="text-caption text-text-secondary">Security</span>
                    </td>
                    <td class="px-6 py-4"><span class="text-caption font-bold text-semantic-error">Breach imminent (14m)</span></td>
                    <td class="px-6 py-4 text-right"><button class="btn btn-sm btn-destructive py-1.5 px-3">Take Over</button></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection