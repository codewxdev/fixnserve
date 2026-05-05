@extends('Layouts.app')
@section('title', 'Incident Management | Support')
@section('content')
<div class="p-4 sm:p-6 lg:p-8 bg-bg-primary min-h-screen">
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-h3 font-bold text-text-primary">Incident Management</h1>
            <p class="text-body-sm text-text-secondary mt-1">Declare outages, assign commanders, and update public status page.</p>
        </div>
        <button class="btn btn-destructive py-2.5 px-4 shadow-sm shadow-semantic-error/20 transition-colors"><i data-lucide="alert-triangle" class="w-4 h-4 mr-2"></i> Declare Incident</button>
    </div>

    <!-- Active Incident (Conditional UI) -->
    <div class="mb-8 card p-0 shadow-lg border-semantic-error shadow-semantic-error/10">
        <div class="p-5 border-b border-semantic-error/20 bg-semantic-error-bg/30 flex justify-between items-center">
            <div class="flex items-center gap-3">
                <div class="w-3 h-3 rounded-full bg-semantic-error animate-ping"></div>
                <h3 class="text-h4 font-bold text-semantic-error">ACTIVE INCIDENT: Partial Stripe Outage</h3>
            </div>
            <span class="text-caption font-bold text-text-tertiary font-mono">Started: 42 mins ago</span>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div>
                    <p class="text-caption font-bold text-text-tertiary uppercase mb-1">Impact</p>
                    <p class="text-body-sm font-bold text-text-primary">Payment processing failing for 15% of businesses.</p>
                </div>
                <div>
                    <p class="text-caption font-bold text-text-tertiary uppercase mb-1">Incident Commander</p>
                    <p class="text-body-sm font-bold text-text-primary flex items-center gap-2"><i data-lucide="user" class="w-4 h-4"></i> Ali (Ops Lead)</p>
                </div>
                <div>
                    <p class="text-caption font-bold text-text-tertiary uppercase mb-1">Status Page Link</p>
                    <a href="#" class="text-body-sm font-bold text-brand-primary hover:underline flex items-center gap-1">status.sahorone.com <i data-lucide="external-link" class="w-3 h-3"></i></a>
                </div>
            </div>
            <div class="mt-6 pt-6 border-t border-border-default flex gap-3">
                <button class="btn btn-secondary text-brand-primary border-brand-primary/30 py-2 transition-colors">Update Public Status</button>
                <button class="btn btn-secondary text-semantic-success border-semantic-success/30 py-2 transition-colors">Mark Mitigated</button>
            </div>
        </div>
    </div>

    <!-- Past Incidents / Postmortems -->
    <div class="card p-0 shadow-sm border-border-default">
        <div class="p-5 border-b border-border-default bg-bg-tertiary">
            <h3 class="text-h4 font-bold text-text-primary">Recent Postmortems</h3>
        </div>
        <table class="w-full text-left whitespace-nowrap">
            <thead class="text-caption uppercase text-text-secondary font-semibold border-b border-border-strong bg-bg-primary">
                <tr>
                    <th class="px-6 py-4">Incident Date</th>
                    <th class="px-6 py-4">Title</th>
                    <th class="px-6 py-4">Duration</th>
                    <th class="px-6 py-4 text-right">Action</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-border-default">
                <tr class="hover:bg-bg-secondary transition-colors">
                    <td class="px-6 py-4 text-caption text-text-secondary font-mono">Oct 12, 2026</td>
                    <td class="px-6 py-4 text-body-sm font-bold text-text-primary">Database connection pool exhaustion</td>
                    <td class="px-6 py-4 text-body-sm text-text-secondary">1h 14m</td>
                    <td class="px-6 py-4 text-right"><button class="btn btn-sm btn-secondary py-1.5 px-3">View Report</button></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection