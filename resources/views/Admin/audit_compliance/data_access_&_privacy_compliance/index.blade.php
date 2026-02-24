@extends('layouts.app')

@section('title', 'Data Privacy & Compliance')


@section('content')
<div class="min-h-screen theme-bg-body theme-text-main max-w-[1400px] mx-auto px-4 sm:px-6 lg:px-8 py-8">

    {{-- HEADER --}}
    <div class="mb-8 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
        <div>
            <h1 class="text-2xl font-bold flex items-center gap-3">
                <i data-lucide="fingerprint" class="w-7 h-7 theme-brand-text"></i>
                Data Access & Privacy (GDPR)
            </h1>
            <p class="theme-text-muted mt-1 text-sm">Managing Subject Access Requests (SAR) and right-to-erasure workflows.</p>
        </div>
        <div class="flex gap-3">
            <button class="px-4 py-2 theme-brand-bg hover:opacity-90 text-white rounded-lg text-sm font-bold transition shadow-lg flex items-center gap-2" style="background-color: rgb(var(--brand-primary));">
                <i data-lucide="plus-circle" class="w-4 h-4"></i> New Privacy Request
            </button>
        </div>
    </div>

    {{-- COMPLIANCE QUEUE OVERVIEW --}}
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
        <div class="theme-bg-card border theme-border p-4 rounded-xl">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-[10px] theme-text-muted uppercase font-bold tracking-widest">Active Requests</p>
                    <p class="text-2xl font-bold mt-1">24</p>
                </div>
                <i data-lucide="clock" class="w-5 h-5 text-blue-400"></i>
            </div>
        </div>
        <div class="theme-bg-card border theme-border p-4 rounded-xl border-l-4 border-l-red-500">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-[10px] theme-text-muted uppercase font-bold tracking-widest text-red-400">Critical SLA</p>
                    <p class="text-2xl font-bold mt-1 text-red-400">03</p>
                </div>
                <i data-lucide="alert-circle" class="w-5 h-5 text-red-500"></i>
            </div>
        </div>
        <div class="theme-bg-card border theme-border p-4 rounded-xl">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-[10px] theme-text-muted uppercase font-bold tracking-widest">Anonymized Users</p>
                    <p class="text-2xl font-bold mt-1">1,204</p>
                </div>
                <i data-lucide="user-minus" class="w-5 h-5 text-slate-400"></i>
            </div>
        </div>
        <div class="theme-bg-card border theme-border p-4 rounded-xl">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-[10px] theme-text-muted uppercase font-bold tracking-widest">Consent Audits</p>
                    <p class="text-2xl font-bold mt-1">PASS</p>
                </div>
                <i data-lucide="check-square" class="w-5 h-5 text-emerald-400"></i>
            </div>
        </div>
    </div>

    {{-- PRIVACY REQUESTS TABLE --}}
    <div class="theme-bg-card rounded-xl shadow-sm border theme-border overflow-hidden">
        <div class="p-4 border-b theme-border flex flex-col md:flex-row justify-between items-center bg-white/5">
            <h3 class="font-semibold text-sm uppercase tracking-widest flex items-center gap-2">
                <i data-lucide="database-backup" class="w-4 h-4"></i> Privacy Action Queue
            </h3>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="theme-text-muted font-semibold text-xs uppercase" style="background-color: rgba(var(--bg-body), 0.8);">
                    <tr>
                        <th class="px-6 py-4">Request Type</th>
                        <th class="px-6 py-4">Subject (User)</th>
                        <th class="px-6 py-4">Status & Progress</th>
                        <th class="px-6 py-4">SLA Deadline</th>
                        <th class="px-6 py-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody id="privacy-queue-body" class="divide-y theme-border">
                    </tbody>
            </table>
        </div>
    </div>
</div>

{{-- DATA COMPILATION DRAWER (Hidden by default) --}}
<div id="compilation-drawer" class="fixed inset-y-0 right-0 w-full max-w-md theme-bg-card border-l theme-border shadow-2xl z-50 transform translate-x-full transition-transform duration-300">
    <div class="p-6 h-full flex flex-col">
        <div class="flex justify-between items-center mb-6">
            <h3 class="font-bold text-lg">Data Compilation</h3>
            <button onclick="closeDrawer()" class="theme-text-muted hover:text-white"><i data-lucide="x"></i></button>
        </div>
        <div class="flex-1 overflow-y-auto space-y-4">
            <div class="p-4 theme-bg-body border theme-border rounded-lg">
                <p class="text-xs theme-text-muted mb-1">Target Identity</p>
                <p class="font-bold" id="drawer-user-name">--</p>
            </div>
            <div class="space-y-2">
                <p class="text-xs font-bold uppercase theme-text-muted">Compilation Progress</p>
                <div class="flex items-center gap-3 text-sm p-2 bg-white/5 rounded border theme-border">
                    <i data-lucide="check-circle-2" class="w-4 h-4 text-emerald-500"></i>
                    <span>Profile & KYC Data</span>
                </div>
                <div class="flex items-center gap-3 text-sm p-2 bg-white/5 rounded border theme-border">
                    <i data-lucide="loader-2" class="w-4 h-4 text-blue-400 animate-spin"></i>
                    <span>Financial Transaction History</span>
                </div>
                <div class="flex items-center gap-3 text-sm p-2 bg-white/5 rounded border theme-border opacity-50">
                    <i data-lucide="circle" class="w-4 h-4"></i>
                    <span>Device & IP Logs</span>
                </div>
            </div>
        </div>
        <div class="mt-auto pt-6 border-t theme-border flex gap-2">
            <button class="flex-1 px-4 py-2 bg-slate-700 rounded-lg text-sm">Cancel</button>
            <button class="flex-1 px-4 py-2 theme-brand-bg rounded-lg text-sm font-bold" style="background-color: rgb(var(--brand-primary));">Approve & Send</button>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://unpkg.com/lucide@latest"></script>
<script>
    const privacyRequests = [
        {
            type: "Right to Portability (Export)",
            subject: { name: "Irfan Malik", email: "irfan@example.com" },
            progress: 65,
            status: "Compiling Data",
            deadline: "Mar 05, 2026",
            slaClass: "sla-safe"
        },
        {
            type: "Right to Erasure (Delete)",
            subject: { name: "Asma Begum", email: "asma.b@example.com" },
            progress: 20,
            status: "Identity Verification",
            deadline: "Feb 25, 2026",
            slaClass: "sla-urgent"
        },
        {
            type: "Data Access Report (SAR)",
            subject: { name: "Kashif Ali", email: "kashif@example.com" },
            progress: 100,
            status: "Completed",
            deadline: "Mar 12, 2026",
            slaClass: "sla-safe"
        }
    ];

    document.addEventListener("DOMContentLoaded", () => {
        renderQueue(privacyRequests);
        lucide.createIcons();
    });

    function renderQueue(requests) {
        const tbody = document.getElementById('privacy-queue-body');
        tbody.innerHTML = '';

        requests.forEach(req => {
            tbody.insertAdjacentHTML('beforeend', `
                <tr class="hover:bg-white/5 transition-colors">
                    <td class="px-6 py-4">
                        <div class="font-bold theme-text-main">${req.type}</div>
                        <div class="text-[10px] theme-text-muted uppercase tracking-tighter">REF: PRIV-${Math.floor(Math.random()*10000)}</div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="theme-text-main font-medium">${req.subject.name}</div>
                        <div class="text-xs theme-text-muted">${req.subject.email}</div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center justify-between mb-1 text-[10px] font-bold uppercase">
                            <span class="theme-text-muted">${req.status}</span>
                            <span>${req.progress}%</span>
                        </div>
                        <div class="w-full bg-slate-800 rounded-full h-1.5 overflow-hidden">
                            <div class="h-full rounded-full transition-all duration-1000 ${req.progress === 100 ? 'bg-emerald-500' : 'bg-blue-500'}" style="width: ${req.progress}%"></div>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-2">
                            <div class="w-2 h-2 rounded-full ${req.slaClass}"></div>
                            <span class="theme-text-main">${req.deadline}</span>
                        </div>
                    </td>
                    <td class="px-6 py-4 text-right">
                        <button onclick="openDrawer('${req.subject.name}')" class="px-3 py-1.5 theme-bg-body border theme-border rounded text-xs font-bold hover:theme-brand-text transition-colors">
                            PROCESS
                        </button>
                    </td>
                </tr>
            `);
        });
        lucide.createIcons();
    }

    function openDrawer(name) {
        document.getElementById('drawer-user-name').innerText = name;
        document.getElementById('compilation-drawer').classList.remove('translate-x-full');
    }

    function closeDrawer() {
        document.getElementById('compilation-drawer').classList.add('translate-x-full');
    }
</script>
@endpush