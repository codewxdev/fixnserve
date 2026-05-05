@extends('layouts.app')
@section('title', 'Evidence Vault | Disputes')
@section('content')
<div class="p-4 sm:p-6 lg:p-8 bg-bg-primary min-h-screen">
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-h3 font-bold text-text-primary">Evidence Vault & Reconstruction</h1>
            <p class="text-body-sm text-text-secondary mt-1">Tamper-evident logs, communication history, and legal export bundling.</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <!-- Search & Filter -->
        <div class="card p-6 border-border-default h-fit">
            <h3 class="text-body font-bold text-text-primary mb-4 border-b border-border-default pb-2">Retrieve Evidence</h3>
            <div class="space-y-4">
                <div class="form-group mb-0">
                    <label class="form-label">Dispute ID</label>
                    <input type="text" placeholder="DSP-..." value="DSP-9985" class="form-input w-full font-mono text-sm">
                </div>
                <div class="form-group mb-0">
                    <label class="form-label">Evidence Type</label>
                    <select class="form-input w-full text-sm">
                        <option>All Types</option>
                        <option>Transaction Logs</option>
                        <option>Communication History</option>
                        <option>Audit Logs</option>
                    </select>
                </div>
                <button class="btn btn-primary w-full py-2.5 transition-colors">Reconstruct Timeline</button>
            </div>
        </div>

        <!-- Timeline & Export -->
        <div class="card p-0 shadow-sm border-border-default lg:col-span-2">
            <div class="p-5 border-b border-border-default bg-bg-tertiary flex justify-between items-center">
                <h3 class="text-h4 font-bold text-text-primary">Timeline: DSP-9985</h3>
                <div class="flex gap-2">
                    <span class="flex items-center gap-1 text-[10px] uppercase font-bold text-semantic-success px-2 py-1 bg-semantic-success-bg rounded border border-semantic-success/20"><i data-lucide="shield-check" class="w-3 h-3"></i> Integrity Verified</span>
                    <button class="btn btn-sm btn-secondary transition-colors py-1.5 px-3 hover:bg-bg-tertiary"><i data-lucide="download" class="w-4 h-4 mr-2"></i> Export Legal Bundle</button>
                </div>
            </div>
            <div class="p-6">
                <!-- Timeline UI -->
                <div class="relative border-l-2 border-border-strong ml-3 space-y-6">
                    <div class="relative pl-6">
                        <div class="absolute w-4 h-4 bg-brand-primary rounded-full -left-[9px] top-1 outline outline-4 outline-bg-primary"></div>
                        <p class="text-caption text-text-secondary font-mono mb-1">Oct 26, 2026 - 10:14 AM</p>
                        <p class="text-body-sm font-bold text-text-primary">Business Submitted GDPR Request</p>
                        <p class="text-caption text-text-secondary mt-1">Requested full export of PII data.</p>
                        <div class="mt-2 text-[10px] text-text-tertiary flex items-center gap-1"><i data-lucide="file-text" class="w-3 h-3"></i> Communication Log</div>
                    </div>
                    <div class="relative pl-6">
                        <div class="absolute w-4 h-4 bg-bg-muted border border-border-strong rounded-full -left-[9px] top-1 outline outline-4 outline-bg-primary"></div>
                        <p class="text-caption text-text-secondary font-mono mb-1">Oct 26, 2026 - 11:30 AM</p>
                        <p class="text-body-sm font-bold text-text-primary">System Executed Data Export</p>
                        <p class="text-caption text-text-secondary mt-1">Automated script compiled requested data bundle.</p>
                        <div class="mt-2 text-[10px] text-text-tertiary flex items-center gap-1"><i data-lucide="activity" class="w-3 h-3"></i> System Audit Log (Immutable)</div>
                    </div>
                    <div class="relative pl-6">
                        <div class="absolute w-4 h-4 bg-semantic-error rounded-full -left-[9px] top-1 outline outline-4 outline-bg-primary"></div>
                        <p class="text-caption text-text-secondary font-mono mb-1">Oct 28, 2026 - 09:00 AM</p>
                        <p class="text-body-sm font-bold text-semantic-error">Business Appealed Resolution</p>
                        <p class="text-caption text-text-primary mt-1">"Data bundle is incomplete, missing 2025 records."</p>
                        <div class="mt-2 text-[10px] text-text-tertiary flex items-center gap-1"><i data-lucide="message-square" class="w-3 h-3"></i> Support Ticket Reply</div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection