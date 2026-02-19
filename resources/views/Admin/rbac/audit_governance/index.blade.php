@extends('layouts.app')

@section('content')
    <div id="app" class="min-h-screen theme-bg-body theme-text-main space-y-8 p-6 lg:p-10 font-sans">

        {{-- A. Header Section --}}
        <header class="flex flex-col md:flex-row md:items-end md:justify-between space-y-4 md:space-y-0">
            <div>
                {{-- Breadcrumb --}}
                <nav class="text-xs font-semibold uppercase tracking-wider theme-text-muted mb-2">
                    <ol class="inline-flex items-center space-x-1 md:space-x-2">
                        <li><a href="#" class="hover:underline transition-colors" style="color: rgb(var(--brand-primary));">Dashboard</a></li>
                        <li><span class="theme-text-muted">/</span></li>
                        <li><span class="theme-text-muted">Governance</span></li>
                        <li><span class="theme-text-muted">/</span></li>
                        <li style="color: rgb(var(--brand-primary));">Audit & Governance</li>
                    </ol>
                </nav>

                {{-- Title --}}
                <h1 class="text-3xl md:text-4xl font-extrabold theme-text-main tracking-tight">
                    Audit & Governance
                </h1>
                <p class="text-base theme-text-muted mt-2 max-w-2xl">
                    Ensure every access decision is traceable. Monitor permission changes, role assignments, and AI risk alerts.
                </p>
            </div>

            <div class="flex gap-3">
                <button onclick="window.loadAuditData()"
                    class="inline-flex items-center px-4 py-2 theme-bg-card border theme-border theme-text-main font-semibold rounded-xl shadow-sm hover:bg-white/5 transition-all duration-300">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                    </svg>
                    Refresh Logs
                </button>
                <button class="inline-flex items-center px-4 py-2 text-white font-semibold rounded-xl shadow-lg transition-all duration-300 hover:opacity-90"
                    style="background-color: rgb(var(--brand-primary)); box-shadow: 0 4px 14px rgba(var(--brand-primary), 0.4);">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    Export CSV
                </button>
            </div>
        </header>

        {{-- B. AI Intelligence & Risk Exposure --}}
        <section class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            {{-- Risk Score Card --}}
            <div class="theme-bg-card p-6 rounded-2xl shadow-sm border theme-border flex flex-col justify-between relative overflow-hidden">
                <div class="absolute -right-6 -top-6 w-32 h-32 bg-orange-500/10 rounded-full blur-2xl pointer-events-none"></div>
                <div>
                    <h3 class="text-sm font-bold uppercase tracking-wider theme-text-muted mb-1">System Risk Score</h3>
                    <div class="flex items-end gap-2">
                        <span class="text-5xl font-black text-orange-500">B-</span>
                        <span class="text-sm theme-text-muted pb-1 mb-1">Moderate Exposure</span>
                    </div>
                </div>
                <div class="mt-4 text-sm theme-text-muted">
                    <p>Based on unused permissions and excessive admin assignments.</p>
                </div>
            </div>

            {{-- AI Recommendations --}}
            <div class="lg:col-span-2 theme-bg-card rounded-2xl shadow-sm border theme-border p-6 border-l-4" style="border-left-color: rgb(var(--brand-primary));">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-base font-bold theme-text-main flex items-center gap-2">
                        <svg class="w-5 h-5" style="color: rgb(var(--brand-primary));" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                        AI Intelligence Layer Alerts
                    </h3>
                    <span class="text-xs font-semibold px-2.5 py-1 bg-red-500/10 text-red-500 rounded-lg">2 Actionable Items</span>
                </div>
                
                <div class="space-y-3">
                    {{-- Alert 1 --}}
                    <div class="flex items-start gap-4 p-3 rounded-xl bg-orange-500/5 border border-orange-500/20">
                        <div class="p-2 bg-orange-500/20 text-orange-500 rounded-lg shrink-0">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                        </div>
                        <div>
                            <h4 class="text-sm font-bold theme-text-main">Privilege Creep Detected</h4>
                            <p class="text-xs theme-text-muted mt-0.5">Role <span class="font-mono text-orange-500">Support Admin</span> has accumulated 14 new permissions in the last 30 days without review.</p>
                        </div>
                        <button class="ml-auto text-xs font-bold text-orange-500 hover:underline shrink-0">Review Role</button>
                    </div>

                    {{-- Alert 2 --}}
                    <div class="flex items-start gap-4 p-3 rounded-xl bg-blue-500/5 border border-blue-500/20">
                        <div class="p-2 bg-blue-500/20 text-blue-500 rounded-lg shrink-0">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <div>
                            <h4 class="text-sm font-bold theme-text-main">Unused Permissions Optimization</h4>
                            <p class="text-xs theme-text-muted mt-0.5">3 users in <span class="font-mono text-blue-500">Finance Auditor</span> haven't used `export_ledger_full` in 90 days.</p>
                        </div>
                        <button class="ml-auto text-xs font-bold text-blue-500 hover:underline shrink-0">Auto-Restrict</button>
                    </div>
                </div>
            </div>
        </section>

        {{-- C. Audit Log Viewer --}}
        <section class="theme-bg-card rounded-2xl shadow-sm border theme-border overflow-hidden">
            {{-- Toolbar --}}
            <div class="p-4 border-b theme-border flex flex-col md:flex-row md:items-center justify-between gap-4" style="background-color: rgba(var(--bg-body), 0.5);">
                <div class="flex items-center gap-3">
                    <select id="filter-event-type" onchange="window.filterLogs()" class="text-sm theme-bg-card border theme-border rounded-xl px-3 py-2 theme-text-main outline-none focus:ring-1" style="--tw-ring-color: rgb(var(--brand-primary));">
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
                        style="--tw-ring-color: rgb(var(--brand-primary));"
                        onkeyup="window.filterLogs()">
                    <svg class="w-4 h-4 theme-text-muted absolute left-3 top-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
            </div>

            {{-- Table --}}
            <div class="overflow-x-auto custom-scrollbar relative min-h-[400px]">
                <div id="audit-loading" class="absolute inset-0 bg-black/50 backdrop-blur-sm z-30 flex flex-col items-center justify-center hidden">
                    <div class="animate-spin rounded-full h-10 w-10 border-b-2 mb-4" style="border-color: rgb(var(--brand-primary));"></div>
                    <span class="font-semibold animate-pulse" style="color: rgb(var(--brand-primary));">Fetching Immutable Logs...</span>
                </div>

                <table class="w-full text-sm text-left border-collapse">
                    <thead class="theme-text-muted border-b theme-border" style="background-color: rgba(var(--bg-body), 0.5);">
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
            <div class="p-4 border-t theme-border flex items-center justify-between text-sm theme-text-muted" style="background-color: rgba(var(--bg-body), 0.5);">
                <span>Showing <span class="font-semibold theme-text-main">1</span> to <span class="font-semibold theme-text-main" id="log-count">0</span> of <span class="font-semibold theme-text-main" id="log-total">0</span> entries</span>
                <div class="flex gap-2">
                    <button class="px-3 py-1 rounded border theme-border hover:bg-white/5 disabled:opacity-50" disabled>Prev</button>
                    <button class="px-3 py-1 rounded border theme-border hover:bg-white/5">Next</button>
                </div>
            </div>
        </section>
    </div>

    {{-- MODAL: Change Diff Viewer --}}
    <div id="diffViewerModal" class="hidden fixed inset-0 z-[60] overflow-y-auto">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-black/80 backdrop-blur-sm transition-opacity" onclick="window.closeDiffViewer()"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>
            <div class="inline-block align-bottom theme-bg-card border theme-border rounded-2xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl w-full">
                
                {{-- Header --}}
                <div class="px-6 py-4 border-b theme-border flex justify-between items-center" style="background-color: rgba(var(--bg-body), 0.5);">
                    <h3 class="text-lg font-bold theme-text-main flex items-center gap-2">
                        <svg class="w-5 h-5 theme-text-muted" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                        Event Record Details
                    </h3>
                    <button onclick="window.closeDiffViewer()" class="theme-text-muted hover:text-white transition-colors">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
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
                        <span class="block theme-text-muted text-xs uppercase tracking-wider mb-2">Change Payload (Diff)</span>
                        <div class="rounded-lg border theme-border overflow-hidden font-mono text-xs">
                            <div class="bg-red-500/10 text-red-400 p-3 border-b border-red-500/20" id="modal-diff-removed">
                                - No permissions removed
                            </div>
                            <div class="bg-green-500/10 text-green-400 p-3" id="modal-diff-added">
                                + No permissions added
                            </div>
                        </div>
                    </div>
                    
                    <div class="bg-blue-500/10 border border-blue-500/20 rounded-lg p-3">
                        <span class="block text-blue-400 text-xs font-bold uppercase tracking-wider mb-1">Approval Chain</span>
                        <span class="text-sm theme-text-main">Approved by Policy Engine (Auto)</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .custom-scrollbar::-webkit-scrollbar { height: 6px; width: 6px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background-color: rgb(var(--border-color)); border-radius: 20px; }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover { background-color: rgb(var(--text-muted)); }
    </style>
@endpush

@push('scripts')
    <script>
        const AUTH_TOKEN = localStorage.getItem('token');
        const BASE_URL = 'http://127.0.0.1:8000/api';
        const CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]')?.content || '';

        let auditLogs = [];

        // --- Mock Data Generator (In case backend API isn't ready yet) ---
        function generateMockLogs() {
            const events = ['permission_assigned', 'permission_removed', 'role_created', 'role_modified'];
            const roles = ['Support Admin', 'Finance Admin', 'Super Admin', 'Read-Only Auditor'];
            const perms = ['view_users', 'export_ledger', 'refund_execute', 'bypass_kyc'];
            const actors = ['john.doe@admin.com', 'system_policy_engine', 'sarah.k@admin.com'];
            
            let logs = [];
            for(let i=0; i<15; i++) {
                const isAdd = Math.random() > 0.5;
                logs.push({
                    id: `log_${Math.random().toString(36).substr(2, 9)}`,
                    timestamp: new Date(Date.now() - Math.floor(Math.random() * 10000000000)).toISOString(),
                    actor: actors[Math.floor(Math.random() * actors.length)],
                    event_type: events[Math.floor(Math.random() * events.length)],
                    target_role: roles[Math.floor(Math.random() * roles.length)],
                    justification: Math.random() > 0.3 ? 'JIRA-4922 Security Request' : 'Standard onboarding protocol',
                    payload: {
                        added: isAdd ? [perms[Math.floor(Math.random() * perms.length)]] : [],
                        removed: !isAdd ? [perms[Math.floor(Math.random() * perms.length)]] : []
                    }
                });
            }
            return logs.sort((a,b) => new Date(b.timestamp) - new Date(a.timestamp));
        }

        // --- Fetch Logic ---
        async function loadAuditData() {
            const loader = document.getElementById('audit-loading');
            loader.classList.remove('hidden');

            try {
                // Try fetching from the API endpoint if it exists
                const response = await fetch(`${BASE_URL}/audit-logs`, {
                    headers: { 'Authorization': `Bearer ${AUTH_TOKEN}`, 'Accept': 'application/json' }
                });
                
                if (response.ok) {
                    const data = await response.json();
                    auditLogs = data.data || data;
                } else {
                    // Fallback to mock data if endpoint doesn't exist yet
                    console.warn("Audit API not found, using simulated intelligence data.");
                    auditLogs = generateMockLogs();
                }

                document.getElementById('log-total').innerText = auditLogs.length;
                window.filterLogs(); // Renders the table

            } catch (e) {
                console.error(e);
                auditLogs = generateMockLogs(); // Fallback
                window.filterLogs();
            } finally {
                setTimeout(() => loader.classList.add('hidden'), 500); // Visual delay
            }
        }

        // --- Rendering & Filtering ---
        window.filterLogs = function() {
            const eventFilter = document.getElementById('filter-event-type').value;
            const search = document.getElementById('log-search').value.toLowerCase();
            const body = document.getElementById('audit-body');
            body.innerHTML = '';

            let filtered = auditLogs.filter(log => {
                const matchEvent = eventFilter === 'All' || log.event_type === eventFilter;
                const matchSearch = log.actor.toLowerCase().includes(search) || 
                                    log.target_role.toLowerCase().includes(search) ||
                                    log.justification.toLowerCase().includes(search);
                return matchEvent && matchSearch;
            });

            document.getElementById('log-count').innerText = filtered.length;

            if (filtered.length === 0) {
                body.innerHTML = `<tr><td colspan="6" class="px-6 py-10 text-center theme-text-muted">No audit records found matching criteria.</td></tr>`;
                return;
            }

            filtered.forEach(log => {
                // Format Badge
                let eventBadge = '';
                if(log.event_type.includes('assign') || log.event_type.includes('create')) {
                    eventBadge = `<span class="px-2 py-0.5 rounded text-[10px] font-bold uppercase tracking-wider bg-green-500/10 text-green-500 border border-green-500/20">Grant / Create</span>`;
                } else if (log.event_type.includes('remove') || log.event_type.includes('revoke')) {
                    eventBadge = `<span class="px-2 py-0.5 rounded text-[10px] font-bold uppercase tracking-wider bg-red-500/10 text-red-500 border border-red-500/20">Revoke / Delete</span>`;
                } else {
                    eventBadge = `<span class="px-2 py-0.5 rounded text-[10px] font-bold uppercase tracking-wider bg-blue-500/10 text-blue-500 border border-blue-500/20">Modify</span>`;
                }

                // Format Date
                const dateObj = new Date(log.timestamp);
                const timeStr = `${dateObj.toLocaleDateString()} ${dateObj.toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'})}`;

                const row = `
                <tr class="hover:bg-white/5 transition-colors group">
                    <td class="px-6 py-4 font-mono text-xs theme-text-muted whitespace-nowrap">${timeStr}</td>
                    <td class="px-6 py-4 theme-text-main font-medium">${log.actor}</td>
                    <td class="px-6 py-4">${eventBadge}</td>
                    <td class="px-6 py-4 font-mono text-xs theme-text-muted">@${log.target_role.replace(/\s+/g, '_').toLowerCase()}</td>
                    <td class="px-6 py-4 text-xs theme-text-muted truncate max-w-xs">${log.justification || 'N/A'}</td>
                    <td class="px-6 py-4 text-right">
                        <button onclick="window.viewDiff('${log.id}')" class="px-3 py-1.5 theme-bg-body border theme-border rounded text-xs font-semibold theme-text-main hover:bg-white/10 transition-colors">
                            View Diff
                        </button>
                    </td>
                </tr>`;
                body.innerHTML += row;
            });
        };

        // --- Diff Viewer Modal ---
        window.viewDiff = function(id) {
            const log = auditLogs.find(l => l.id === id);
            if(!log) return;

            document.getElementById('modal-actor').innerText = log.actor;
            document.getElementById('modal-time').innerText = new Date(log.timestamp).toLocaleString();

            const addedBox = document.getElementById('modal-diff-added');
            const removedBox = document.getElementById('modal-diff-removed');

            if(log.payload && log.payload.added && log.payload.added.length > 0) {
                addedBox.innerHTML = log.payload.added.map(p => `+ Assigned: <b>${p}</b>`).join('<br>');
                addedBox.classList.remove('hidden');
            } else {
                addedBox.classList.add('hidden');
            }

            if(log.payload && log.payload.removed && log.payload.removed.length > 0) {
                removedBox.innerHTML = log.payload.removed.map(p => `- Revoked: <b>${p}</b>`).join('<br>');
                removedBox.classList.remove('hidden');
            } else {
                removedBox.classList.add('hidden');
            }

            document.getElementById('diffViewerModal').classList.remove('hidden');
        };

        window.closeDiffViewer = function() {
            document.getElementById('diffViewerModal').classList.add('hidden');
        };

        // Initialize
        document.addEventListener('DOMContentLoaded', loadAuditData);
    </script>
@endpush