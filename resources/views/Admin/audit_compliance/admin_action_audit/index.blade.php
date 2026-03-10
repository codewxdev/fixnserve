@extends('layouts.app')

@section('title', 'Admin Action Audit Logs')

@section('content')
    <div class="min-h-screen theme-bg-body theme-text-main max-w-[1400px] mx-auto px-4 sm:px-6 lg:px-8 py-8">

        {{-- HEADER & COMPLIANCE BANNER --}}
        <div class="mb-6">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-4">
                <div>
                    <h1 class="text-2xl font-bold flex items-center gap-2 theme-text-main">
                        <i data-lucide="shield-alert" class="w-6 h-6 theme-brand-text"></i>
                        Admin Action Audit Logs
                    </h1>
                    <p class="theme-text-muted mt-1 text-sm">Immutable oversight of all privileged actions. Data cannot be
                        modified or deleted.</p>
                </div>

            </div>

            {{-- Immutable Status Indicator --}}
            <div class="border rounded-lg p-3 flex items-center justify-between text-sm shadow-sm"
                style="background-color: rgba(var(--brand-primary), 0.1); border-color: rgba(var(--brand-primary), 0.2);">
                <div class="flex items-center gap-2" style="color: rgb(var(--brand-primary));">
                    <i data-lucide="lock" class="w-4 h-4"></i>
                    <span class="font-semibold">Compliance Mode Active:</span> Write-once storage enforced. Legal holds
                    apply.
                </div>
                <div class="theme-text-muted font-mono text-xs">Node: sahor-audit-eu-west-1</div>
            </div>
        </div>

        {{-- FILTER CONTROLS --}}
        <div class="theme-bg-card rounded-xl shadow-sm border theme-border p-4 mb-6">
            <div class="grid grid-cols-1 md:grid-cols-4 lg:grid-cols-5 gap-4">
                <div class="relative lg:col-span-2">
                    <i data-lucide="search" class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 theme-text-muted"></i>
                    <input type="text" id="search-input" placeholder="Search actor, target entity, or IP..."
                        class="w-full pl-9 pr-3 py-2 theme-bg-body border theme-border rounded-lg text-sm theme-text-main focus:ring-2 focus:ring-blue-500 outline-none transition-shadow">
                </div>
                <div>
                    <select id="action-filter"
                        class="w-full px-3 py-2 theme-bg-body border theme-border rounded-lg text-sm theme-text-main focus:ring-2 focus:ring-blue-500 outline-none transition-shadow">
                        <option value="">All Action Types</option>
                        <option value="auth">Authentication</option>
                        <option value="user_management">User Management</option>
                        <option value="financial">Financial / Payouts</option>
                        <option value="system_config">System Configuration</option>
                    </select>
                </div>
                <div>
                    <input type="date" id="date-filter"
                        class="w-full px-3 py-2 theme-bg-body border theme-border rounded-lg text-sm theme-text-muted focus:ring-2 focus:ring-blue-500 outline-none transition-shadow">
                </div>
                <div>
                    <button onclick="applyFilters()"
                        class="w-full px-4 py-2 theme-brand-bg theme-brand-hover text-white rounded-lg text-sm font-medium transition shadow-sm flex items-center justify-center gap-2">
                        <i data-lucide="filter" class="w-4 h-4"></i> Filter
                    </button>
                </div>
            </div>
        </div>

        {{-- DATA TABLE --}}
        <div class="theme-bg-card rounded-xl shadow-sm border theme-border overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead class="border-b theme-border theme-text-muted font-semibold text-xs uppercase tracking-wider"
                        style="background-color: rgba(var(--bg-body), 0.5);">
                        <tr>
                            <th class="px-6 py-4">Timestamp (UTC)</th>
                            <th class="px-6 py-4">Actor</th>
                            <th class="px-6 py-4">Action</th>
                            <th class="px-6 py-4">Target Entity</th>
                            <th class="px-6 py-4">IP & Device</th>
                            <th class="px-6 py-4 text-right">Payload & Reason</th>
                        </tr>
                    </thead>
                    <tbody id="audit-table-body" class="divide-y theme-border theme-text-main">
                    </tbody>
                </table>
            </div>
            <div class="p-4 border-t theme-border flex justify-between items-center text-sm theme-text-muted">
                <span>Showing <span class="font-semibold theme-text-main">1</span> to <span
                        class="font-semibold theme-text-main">10</span> of <span
                        class="font-semibold theme-text-main">12,404</span> logs</span>
                <div class="flex gap-2">
                    <button
                        class="px-3 py-1 border theme-border rounded hover:bg-white/5 disabled:opacity-50 transition-colors">Prev</button>
                    <button class="px-3 py-1 border theme-border rounded hover:bg-white/5 transition-colors">Next</button>
                </div>
            </div>
        </div>

    </div>

    {{-- STATE DIFF MODAL --}}
    <div id="diff-modal"
        class="fixed inset-0 bg-black/60 backdrop-blur-sm hidden z-50 flex items-center justify-center p-4">
        <div
            class="theme-bg-card border theme-border rounded-xl shadow-2xl w-full max-w-3xl max-h-[90vh] flex flex-col overflow-hidden">
            <div class="p-4 border-b theme-border flex justify-between items-center"
                style="background-color: rgba(var(--bg-body), 0.5);">
                <h3 class="font-bold theme-text-main flex items-center gap-2">
                    <i data-lucide="file-json" class="w-5 h-5 theme-brand-text"></i> Action Payload & State Diff
                </h3>
                <button onclick="closeModal()" class="theme-text-muted hover:text-white transition-colors">
                    <i data-lucide="x" class="w-5 h-5"></i>
                </button>
            </div>

            <div class="p-6 overflow-y-auto space-y-6 flex-1 theme-text-main">
                <div>
                    <h4 class="text-xs font-bold theme-text-muted uppercase tracking-wider mb-2">Mandatory Reason Code</h4>
                    <div class="border p-3 rounded-lg text-sm font-medium"
                        style="background-color: rgba(var(--brand-primary), 0.1); border-color: rgba(var(--brand-primary), 0.2); color: rgb(var(--brand-primary));"
                        id="modal-reason">
                        --
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <h4 class="text-xs font-bold theme-text-muted uppercase tracking-wider mb-2 flex justify-between">
                            <span>Before State</span>
                            <span class="opacity-50">JSON</span>
                        </h4>
                        <pre class="theme-bg-body p-4 rounded-lg text-xs font-mono overflow-x-auto diff-removed border theme-border"
                            id="modal-before"></pre>
                    </div>
                    <div>
                        <h4 class="text-xs font-bold theme-text-muted uppercase tracking-wider mb-2 flex justify-between">
                            <span>After State</span>
                            <span class="opacity-50">JSON</span>
                        </h4>
                        <pre class="theme-bg-body p-4 rounded-lg text-xs font-mono overflow-x-auto diff-added border theme-border"
                            id="modal-after"></pre>
                    </div>
                </div>
            </div>

            <div class="p-4 border-t theme-border flex justify-end" style="background-color: rgba(var(--bg-body), 0.5);">
                <button onclick="closeModal()"
                    class="px-4 py-2 theme-bg-body border theme-border hover:bg-white/5 theme-text-main rounded-lg text-sm font-medium transition-colors">Close</button>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://unpkg.com/lucide@latest"></script>
    <script>
        // Initial Load
        document.addEventListener("DOMContentLoaded", () => {
            fetchAuditLogs(); // Page load par data fetch karein
            lucide.createIcons();
        });

        // Mapping badge styles to your action_type
        function getBadgeStyle(type) {
            const styles = {
                'system_config': 'background-color: rgba(249, 115, 22, 0.15); color: #fdba74; border-color: rgba(249, 115, 22, 0.3);',
                'user_management': 'background-color: rgba(59, 130, 246, 0.15); color: #93c5fd; border-color: rgba(59, 130, 246, 0.3);',
                'financial': 'background-color: rgba(16, 185, 129, 0.15); color: #6ee7b7; border-color: rgba(16, 185, 129, 0.3);',
                'auth': 'background-color: rgba(148, 163, 184, 0.15); color: #cbd5e1; border-color: rgba(148, 163, 184, 0.3);'
            };
            return styles[type] || 'background-color: rgba(148, 163, 184, 0.15); color: #cbd5e1; border-color: rgba(148, 163, 184, 0.3);';
        }

        async function fetchAuditLogs(filters = {}) {
            const tbody = document.getElementById('audit-table-body');
            tbody.innerHTML = '<tr><td colspan="6" class="p-8 text-center text-sm theme-text-muted">Loading logs...</td></tr>';

            try {
                const queryString = new URLSearchParams(filters).toString();
                // Base URL use karte hue API call
                const response = await fetch(`{{ url('/api/admin-actions') }}?${queryString}`);
                const data = await response.json();

                // Agar data pagination wrap mein hai (like Laravel default) toh data.data use karein
                const logs = data.data || data; 

                if (logs.length === 0) {
                    tbody.innerHTML = '<tr><td colspan="6" class="p-8 text-center text-sm theme-text-muted">No logs found.</td></tr>';
                } else {
                    renderTable(logs);
                }
            } catch (error) {
                console.error('Error fetching logs:', error);
                tbody.innerHTML = '<tr><td colspan="6" class="p-8 text-center text-red-500">Failed to load logs. Check console for details.</td></tr>';
            }
        }

        function renderTable(logs) {
            const tbody = document.getElementById('audit-table-body');
            tbody.innerHTML = '';

            logs.forEach(log => {
                // Formatting date
                const date = new Date(log.performed_at).toLocaleString();
                
                const row = `
                <tr class="hover:bg-white/5 transition-colors group">
                    <td class="px-6 py-4 whitespace-nowrap border-t theme-border">
                        <div class="font-mono text-xs theme-text-main">${date}</div>
                        <div class="text-[10px] theme-text-muted mt-0.5">ID: #${log.id}</div>
                    </td>
                    <td class="px-6 py-4 border-t theme-border">
                        <div class="font-medium theme-text-main">Admin ID: ${log.admin_id}</div>
                        <div class="text-xs theme-text-muted">${log.admin_role}</div>
                    </td>
                    <td class="px-6 py-4 border-t theme-border">
                        <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium border" style="${getBadgeStyle(log.action_type)}">
                            ${log.action_type.replace('_', ' ').toUpperCase()}
                        </span>
                    </td>
                    <td class="px-6 py-4 border-t theme-border">
                        <div class="font-medium theme-text-main">${log.target_type || 'N/A'}</div>
                        <div class="text-xs font-mono theme-text-muted">${log.target_id || '--'}</div>
                    </td>
                    <td class="px-6 py-4 border-t theme-border">
                        <div class="text-xs font-mono theme-text-main flex items-center gap-1">
                            <i data-lucide="globe" class="w-3 h-3 theme-text-muted"></i> ${log.ip_address}
                        </div>
                        <div class="text-[10px] theme-text-muted mt-0.5 font-mono truncate max-w-[100px]" title="${log.device_fingerprint}">
                            ${log.device_fingerprint || 'No Fingerprint'}
                        </div>
                    </td>
                    <td class="px-6 py-4 text-right border-t theme-border">
                        <button onclick='viewDetails(${JSON.stringify(log)})' class="inline-flex items-center justify-center gap-2 px-3 py-1.5 theme-bg-body border theme-border hover:bg-white/5 theme-text-main rounded text-xs font-bold transition shadow-sm">
                            <i data-lucide="eye" class="w-3 h-3 theme-brand-text"></i> VIEW DIFF
                        </button>
                    </td>
                </tr>
                `;
                tbody.insertAdjacentHTML('beforeend', row);
            });
            lucide.createIcons();
        }

        function viewDetails(log) {
            document.getElementById('modal-reason').innerText = log.reason_code;
            
            // JSON beautify for before/after states
            const beforeState = log.before_state ? JSON.stringify(log.before_state, null, 2) : 'null';
            const afterState = log.after_state ? JSON.stringify(log.after_state, null, 2) : 'null';

            document.getElementById('modal-before').innerText = beforeState;
            document.getElementById('modal-after').innerText = afterState;

            document.getElementById('diff-modal').classList.remove('hidden');
        }

        function closeModal() {
            document.getElementById('diff-modal').classList.add('hidden');
        }

        function applyFilters() {
            const filters = {
                search: document.getElementById('search-input').value,
                action_type: document.getElementById('action-filter').value,
                date: document.getElementById('date-filter').value
            };
            fetchAuditLogs(filters);
        }
    </script>
@endpush
