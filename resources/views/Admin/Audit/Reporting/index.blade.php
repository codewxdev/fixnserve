@extends('Layouts.app')
@section('title', 'Regulatory Reporting | Compliance')
@section('content')
<div class="p-4 sm:p-6 lg:p-8 bg-bg-primary min-h-screen">
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-h3 font-bold text-text-primary">Regulatory Reporting Engine</h1>
            <p class="text-body-sm text-text-secondary mt-1">Generate compliant export packages with secure chain of custody.</p>
        </div>
    </div>

    <!-- Package Generator -->
    <div class="card p-6 border-border-default mb-8 bg-bg-tertiary">
        <h3 class="text-body font-bold text-text-primary mb-4">Generate Compliance Package</h3>
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
            <div class="form-group mb-0">
                <label class="form-label">Report Type</label>
                <select class="form-input w-full text-sm"><option>Financial Activity</option><option>KYC/AML Compliance</option><option>Dispute Resolutions</option><option>Fraud Incidents</option></select>
            </div>
            <div class="form-group mb-0">
                <label class="form-label">Jurisdiction Template</label>
                <select class="form-input w-full text-sm"><option>UAE Central Bank Format</option><option>FTA (Federal Tax Authority)</option><option>GDPR Standard</option></select>
            </div>
            <div class="form-group mb-0">
                <label class="form-label">Time Range</label>
                <select class="form-input w-full text-sm"><option>Last 30 Days</option><option>Q1 2026</option><option>Custom Range</option></select>
            </div>
            <button class="btn btn-primary py-2.5 w-full shadow-sm"><i data-lucide="package" class="w-4 h-4 mr-2"></i> Compile Package</button>
        </div>
    </div>

    <!-- Generated Reports -->
    <div class="card p-0 shadow-sm border-border-default">
        <div class="p-5 border-b border-border-default bg-bg-primary">
            <h3 class="text-h4 font-bold text-text-primary">Secure Downloads (Chain of Custody)</h3>
        </div>
        <table class="w-full text-left whitespace-nowrap">
            <thead class="text-caption uppercase text-text-secondary font-semibold border-b border-border-strong bg-bg-tertiary">
                <tr>
                    <th class="px-6 py-4">Package ID & Type</th>
                    <th class="px-6 py-4">Jurisdiction</th>
                    <th class="px-6 py-4">Expiry Status</th>
                    <th class="px-6 py-4 text-right">Secure Link</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-border-default">
                <tr class="hover:bg-bg-secondary transition-colors">
                    <td class="px-6 py-4">
                        <p class="text-body-sm font-bold text-text-primary font-mono">PKG-2026-004</p>
                        <p class="text-caption text-text-secondary mt-0.5">UAE VAT Compliance (Q1)</p>
                    </td>
                    <td class="px-6 py-4 text-caption">FTA (Federal Tax Authority)</td>
                    <td class="px-6 py-4"><span class="text-caption font-bold text-semantic-warning">Expires in 12h</span></td>
                    <td class="px-6 py-4 text-right">
                        <button class="btn btn-sm btn-secondary text-brand-primary border-brand-primary/30 py-1.5 px-3"><i data-lucide="link" class="w-3 h-3 mr-1"></i> Copy Secure Link</button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection