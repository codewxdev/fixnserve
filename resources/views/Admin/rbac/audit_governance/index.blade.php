@extends('layouts.app')

@section('content')
    <div id="app" class="min-h-screen theme-bg-body theme-text-main space-y-8 p-6 lg:p-10 font-sans">

        {{-- A. Header Section --}}
        <header class="flex flex-col md:flex-row md:items-end md:justify-between space-y-4 md:space-y-0">
            <div>
                {{-- Title --}}
                <h1 class="text-3xl md:text-4xl font-extrabold theme-text-main tracking-tight">
                    Audit & Governance
                </h1>
                <p class="text-base theme-text-muted mt-2 max-w-2xl">
                    Ensure every access decision is traceable. Monitor permission changes, role assignments, and AI risk
                    alerts.
                </p>
            </div>

            <div class="flex gap-3">
                <button onclick="window.loadAuditData()"
                    class="inline-flex items-center px-4 py-2 theme-bg-card border theme-border theme-text-main font-semibold rounded-xl shadow-sm hover:bg-white/5 transition-all duration-300">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15">
                        </path>
                    </svg>
                    Refresh Logs
                </button>

            </div>
        </header>

        {{-- C. Audit Log Viewer --}}
        <section class="theme-bg-card rounded-2xl shadow-sm border theme-border overflow-hidden">
            {{-- Toolbar --}}
            <div class="p-4 border-b theme-border flex flex-col md:flex-row md:items-center justify-between gap-4"
                style="background-color: rgba(var(--bg-body), 0.5);">
                <div class="flex items-center gap-3">
                    <select id="filter-event-type" onchange="window.filterLogs()"
                        class="text-sm theme-bg-card border theme-border rounded-xl px-3 py-2 theme-text-main outline-none focus:ring-1"
                        style="--tw-ring-color: rgb(var(--brand-primary));">
                        <option value="All">All Events</option>
                        <option value="permission_assigned">Permission Assigned</option>
                        <option value="permission_removed">Permission Removed</option>
                        <option value="role_created">Role Created</option>
                        <option value="role_modified">Role Modified</option>
                    </select>
                </div>

                <div class="relative">
                    <input type="text" id="log-search" placeholder="Search actor, target, or justification..."
                        class="pl-10 pr-4 py-2 theme-bg-body border theme-border rounded-xl text-sm theme-text-main focus:ring-2 placeholder-gray-500 w-full md:w-80 outline-none"
                        style="--tw-ring-color: rgb(var(--brand-primary));" onkeyup="window.filterLogs()">
                    <svg class="w-4 h-4 theme-text-muted absolute left-3 top-3" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
            </div>

            {{-- Table --}}
            <div class="overflow-x-auto custom-scrollbar relative min-h-[400px]">
                <div id="audit-loading"
                    class="absolute inset-0 bg-black/50 backdrop-blur-sm z-30 flex flex-col items-center justify-center hidden">
                    <div class="animate-spin rounded-full h-10 w-10 border-b-2 mb-4"
                        style="border-color: rgb(var(--brand-primary));"></div>
                    <span class="font-semibold animate-pulse" style="color: rgb(var(--brand-primary));">Fetching Immutable
                        Logs...</span>
                </div>

                <table class="w-full text-sm text-left border-collapse">
                    <thead class="theme-text-muted border-b theme-border"
                        style="background-color: rgba(var(--bg-body), 0.5);">
                        <tr>
                            <th class="px-6 py-4 font-bold uppercase tracking-wider text-xs">Timestamp</th>
                            <th class="px-6 py-4 font-bold uppercase tracking-wider text-xs">Actor</th>
                            <th class="px-6 py-4 font-bold uppercase tracking-wider text-xs">Event Type</th>
                            <th class="px-6 py-4 font-bold uppercase tracking-wider text-xs">Target Role</th>
                            <th class="px-6 py-4 font-bold uppercase tracking-wider text-xs">Justification</th>
                            <th class="px-6 py-4 font-bold uppercase tracking-wider text-xs text-right">Details</th>
                        </tr>
                    </thead>
                    <tbody id="audit-body" class="divide-y theme-border" style="border-color: rgb(var(--border-color));">
                        {{-- Injected via JS --}}
                    </tbody>
                </table>
            </div>

            {{-- Pagination Mock --}}
            <div class="p-4 border-t theme-border flex items-center justify-between text-sm theme-text-muted"
                style="background-color: rgba(var(--bg-body), 0.5);">
                <span>Showing <span class="font-semibold theme-text-main">1</span> to <span
                        class="font-semibold theme-text-main" id="log-count">0</span> of <span
                        class="font-semibold theme-text-main" id="log-total">0</span> entries</span>
                <div class="flex gap-2">
                    <button class="px-3 py-1 rounded border theme-border hover:bg-white/5 disabled:opacity-50"
                        disabled>Prev</button>
                    <button class="px-3 py-1 rounded border theme-border hover:bg-white/5">Next</button>
                </div>
            </div>
        </section>
    </div>

    {{-- MODAL: Change Diff Viewer --}}
    <div id="diffViewerModal" class="hidden fixed inset-0 z-[60] overflow-y-auto">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-black/80 backdrop-blur-sm transition-opacity" onclick="window.closeDiffViewer()">
            </div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>
            <div
                class="inline-block align-bottom theme-bg-card border theme-border rounded-2xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl w-full">

                {{-- Header --}}
                <div class="px-6 py-4 border-b theme-border flex justify-between items-center"
                    style="background-color: rgba(var(--bg-body), 0.5);">
                    <h3 class="text-lg font-bold theme-text-main flex items-center gap-2">
                        <svg class="w-5 h-5 theme-text-muted" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2">
                            </path>
                        </svg>
                        Event Record Details
                    </h3>
                    <button onclick="window.closeDiffViewer()" class="theme-text-muted hover:text-white transition-colors">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                {{-- Body --}}
                <div class="p-6 space-y-6">
                    <div class="grid grid-cols-2 gap-4 text-sm">
                        <div>
                            <span class="block theme-text-muted text-xs uppercase tracking-wider mb-1">Actor</span>
                            <span class="font-semibold theme-text-main" id="modal-actor">...</span>
                        </div>
                        <div>
                            <span class="block theme-text-muted text-xs uppercase tracking-wider mb-1">Timestamp</span>
                            <span class="font-mono theme-text-main" id="modal-time">...</span>
                        </div>
                    </div>

                    <div>
                        <span class="block theme-text-muted text-xs uppercase tracking-wider mb-2">Change Payload
                            (Diff)</span>
                        <div class="rounded-lg border theme-border overflow-hidden font-mono text-xs">
                            <div class="bg-red-500/10 text-red-400 p-3 border-b border-red-500/20"
                                id="modal-diff-removed">
                                - No permissions removed
                            </div>
                            <div class="bg-green-500/10 text-green-400 p-3" id="modal-diff-added">
                                + No permissions added
                            </div>
                        </div>
                    </div>

                    <div class="bg-blue-500/10 border border-blue-500/20 rounded-lg p-3">
                        <span class="block text-blue-400 text-xs font-bold uppercase tracking-wider mb-1">Approval
                            Chain</span>
                        <span class="text-sm theme-text-main">Approved by Policy Engine (Auto)</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .custom-scrollbar::-webkit-scrollbar {
            height: 6px;
            width: 6px;
        }

        .custom-scrollbar::-webkit-scrollbar-track {
            background: transparent;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb {
            background-color: rgb(var(--border-color));
            border-radius: 20px;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background-color: rgb(var(--text-muted));
        }
    </style>
@endpush

@push('scripts')
    <script>
        window.auditLogs = [];
        const AUTH_TOKEN = localStorage.getItem('token');
        const BASE_URL = 'http://127.0.0.1:8000/api';

        async function loadAuditData() {
            const loader = document.getElementById('audit-loading');
            if (loader) loader.classList.remove('hidden');

            try {
                const response = await fetch(`${BASE_URL}/permission-audit`, {
                    headers: {
                        'Authorization': `Bearer ${AUTH_TOKEN}`,
                        'Accept': 'application/json'
                    }
                });

                const result = await response.json();
                // Laravel usually returns data in result.data or result directly
                window.auditLogs = result.data || result;

                document.getElementById('log-total').innerText = window.auditLogs.length;
                window.filterLogs();

            } catch (e) {
                console.error("Fetch Error:", e);
            } finally {
                if (loader) setTimeout(() => loader.classList.add('hidden'), 500);
            }
        }

        window.filterLogs = function() {
            const eventFilter = document.getElementById('filter-event-type').value;
            const search = document.getElementById('log-search').value.toLowerCase();
            const body = document.getElementById('audit-body');

            if (!body) return;
            body.innerHTML = '';

            let filtered = window.auditLogs.filter(log => {
                // Hum actor name handle kar rahe hain (assuming API returns actor object with name)
                const actorName = log.actor?.name || `User ID: ${log.actor_id}`;
                const targetRole = log.target_role || '';
                const justification = log.justification || '';

                const matchEvent = eventFilter === 'All' || log.event_type === eventFilter;
                const matchSearch = actorName.toLowerCase().includes(search) ||
                    targetRole.toLowerCase().includes(search) ||
                    justification.toLowerCase().includes(search);

                return matchEvent && matchSearch;
            });

            document.getElementById('log-count').innerText = filtered.length;

            filtered.forEach(log => {
                // Helper for Badge Color
                const badgeClass = getBadgeStyle(log.event_type);
                const dateStr = new Date(log.created_at).toLocaleString();

                const row = `
                <tr class="hover:bg-white/5 transition-colors">
                    <td class="px-6 py-4 font-mono text-xs theme-text-muted whitespace-nowrap">${dateStr}</td>
                    <td class="px-6 py-4 theme-text-main font-medium">${log.actor?.name || 'System ID: '+log.actor_id}</td>
                    <td class="px-6 py-4">
                        <span class="px-2 py-0.5 rounded text-[10px] font-bold uppercase ${badgeClass}">
                            ${log.event_type.replace(/_/g, ' ')}
                        </span>
                    </td>
                    <td class="px-6 py-4 font-mono text-xs theme-text-muted">
                        ${log.target_role ? '@' + log.target_role.toLowerCase() : 'N/A'}
                    </td>
                    <td class="px-6 py-4 text-xs theme-text-muted truncate max-w-xs" title="${log.justification}">
                        ${log.justification || 'No justification provided'}
                    </td>
                    <td class="px-6 py-4 text-right">
                        <button onclick="window.viewDiff(${log.id})" class="px-3 py-1.5 theme-bg-body border theme-border rounded text-xs font-semibold theme-text-main hover:bg-white/10">
                            View Diff
                        </button>
                    </td>
                </tr>`;
                body.innerHTML += row;
            });
        };

        // Helper to style badges based on event_type
        function getBadgeStyle(type) {
            if (type.includes('assigned') || type.includes('granted') || type.includes('created'))
                return 'bg-green-500/10 text-green-500 border border-green-500/20';
            if (type.includes('removed') || type.includes('deactivated'))
                return 'bg-red-500/10 text-red-500 border border-red-500/20';
            return 'bg-blue-500/10 text-blue-500 border border-blue-500/20';
        }

        window.viewDiff = function(id) {
            const log = window.auditLogs.find(l => l.id == id);
            if (!log) return;

            document.getElementById('modal-actor').innerText = log.actor?.name || `ID: ${log.actor_id}`;
            document.getElementById('modal-time').innerText = new Date(log.created_at).toLocaleString();

            const addedBox = document.getElementById('modal-diff-added');
            const removedBox = document.getElementById('modal-diff-removed');

            // Helper function to format JSON into a clean list
            const formatData = (data, prefix) => {
                if (!data) return `No data available`;

                // Agar data string hai to parse karein, warna object use karein
                let obj = typeof data === 'string' ? JSON.parse(data) : data;

                return Object.entries(obj).map(([key, value]) => {
                    return `<div class="flex justify-between py-1 border-b border-white/5 last:border-0">
                        <span class="font-bold opacity-70">${key}:</span>
                        <span class="font-mono">${value}</span>
                    </div>`;
                }).join('');
            };

            // UI update karein
            if (log.new_value) {
                addedBox.innerHTML = `<div class="mb-2 font-bold text-xs uppercase underline">New State (+)</div>` +
                    formatData(log.new_value);
                addedBox.classList.remove('hidden');
            } else {
                addedBox.classList.add('hidden');
            }

            if (log.old_value) {
                removedBox.innerHTML = `<div class="mb-2 font-bold text-xs uppercase underline">Old State (-)</div>` +
                    formatData(log.old_value);
                removedBox.classList.remove('hidden');
            } else {
                removedBox.classList.add('hidden');
            }

            document.getElementById('diffViewerModal').classList.remove('hidden');
        };

        window.closeDiffViewer = function() {
            document.getElementById('diffViewerModal').classList.add('hidden');
        };

        document.addEventListener('DOMContentLoaded', loadAuditData);
    </script>
@endpush
