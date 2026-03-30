@extends('layouts.app')

@section('title', 'Privileged Access Governance')

@section('content')
    <div class="min-h-screen theme-bg-body theme-text-main max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
            <div>
                <h1 class="text-2xl font-bold theme-text-main">Privileged Access & Approvals</h1>
                <p class="theme-text-muted mt-1">Manage Just-In-Time (JIT) access requests and enforce multi-party
                    authorization.</p>
            </div>

            <button onclick="openRequestModal()"
                class="flex items-center gap-2 px-4 py-2 text-white rounded-lg text-sm font-medium hover:opacity-90 shadow-sm transition-colors"
                style="background-color: rgb(var(--brand-primary)); box-shadow: 0 4px 10px rgba(var(--brand-primary), 0.3);">
                <i data-lucide="key" class="w-4 h-4"></i>
                <span>Request Elevation</span>
            </button>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

            <div class="lg:col-span-2 space-y-8">

                {{-- ACTIVE ELEVATIONS TABLE --}}
                <div class="theme-bg-card rounded-xl shadow-sm border theme-border overflow-hidden">
                    <div class="px-6 py-4 border-b theme-border flex justify-between items-center"
                        style="background-color: rgba(var(--bg-body), 0.5);">
                        <h3 class="font-semibold theme-text-main flex items-center gap-2">
                            <i data-lucide="timer" class="w-4 h-4" style="color: rgb(var(--brand-primary));"></i> Active
                            Elevations
                        </h3>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-sm theme-text-muted">
                            <thead class="theme-bg-body theme-text-muted font-medium border-b theme-border">
                                <tr>
                                    <th class="px-6 py-3">User</th>
                                    <th class="px-6 py-3">Role / Scope</th>
                                    <th class="px-6 py-3">Justification</th>
                                    <th class="px-6 py-3">Time Remaining</th>
                                    <th class="px-6 py-3 text-right">Action</th>
                                </tr>
                            </thead>
                            {{-- DYNAMIC LIST FOR ACTIVE ELEVATIONS --}}
                            <tbody id="active-elevations-list" class="divide-y theme-border"
                                style="border-color: rgb(var(--border-color));">
                                <tr>
                                    <td colspan="5" class="px-6 py-4 text-center">Loading active elevations...</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- PENDING APPROVALS --}}
                <div class="theme-bg-card rounded-xl shadow-sm border theme-border">
                    <div class="px-6 py-4 border-b theme-border flex justify-between items-center"
                        style="background-color: rgba(var(--bg-body), 0.5);">
                        <h3 class="font-semibold theme-text-main flex items-center gap-2">
                            <i data-lucide="users" class="w-4 h-4 text-amber-500"></i> Pending Dual Approvals
                        </h3>
                    </div>

                    {{-- DYNAMIC LIST FOR PENDING APPROVALS --}}
                    <div id="pending-approvals-list" class="p-6 space-y-4">
                        <p class="text-sm theme-text-muted text-center">Loading pending approvals...</p>
                    </div>
                </div>

            </div>

            <div class="space-y-6">

                {{-- GOVERNANCE RULES --}}
                <div class="theme-bg-card rounded-xl shadow-sm border theme-border overflow-hidden">
                    <div class="px-6 py-4 border-b theme-border" style="background-color: rgba(var(--bg-body), 0.5);">
                        <h3 class="font-semibold theme-text-main flex items-center gap-2">
                            <i data-lucide="shield" class="w-4 h-4" style="color: rgb(var(--brand-primary));"></i>
                            Governance Rules
                        </h3>
                    </div>
                    <div class="p-4 space-y-4">
                        <div class="flex items-center justify-between pb-3 border-b theme-border">
                            <div>
                                <p class="text-sm font-medium theme-text-main">Max Elevation Time</p>
                                <p class="text-xs theme-text-muted">Auto-revoke after duration</p>
                            </div>
                            <span
                                class="text-xs font-bold theme-bg-body border theme-border px-2 py-1 rounded theme-text-muted">2
                                Hours</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium theme-text-main">Dual Approval</p>
                                <p class="text-xs theme-text-muted">Requires Level 1 & Level 2</p>
                            </div>
                            <span
                                class="text-xs font-bold theme-bg-body border theme-border px-2 py-1 rounded text-amber-500">Strict</span>
                        </div>
                    </div>
                </div>

                {{-- RECENT AUDIT --}}
                <div class="rounded-xl shadow-lg p-6 border theme-border" style="background-color: rgba(15, 23, 42, 0.95);">
                    <h3 class="font-semibold flex items-center gap-2 mb-4 text-white">
                        <i data-lucide="file-text" class="w-4 h-4 text-gray-400"></i> Recent Audit
                    </h3>

                    {{-- DYNAMIC LIST FOR AUDIT LOGS --}}
                    <div id="audit-logs-list" class="space-y-4 text-xs font-mono max-h-[300px] overflow-y-auto pr-2">
                        <p class="text-gray-400">Loading logs...</p>
                    </div>

                    <button onclick="loadAuditLogs()"
                        class="w-full mt-4 py-2 bg-white/10 text-gray-300 text-xs rounded hover:bg-white/20 transition">Refresh
                        Logs</button>
                </div>

            </div>
        </div>
    </div>

    {{-- REQUEST MODAL --}}
    <div id="access-modal"
        class="hidden fixed inset-0 bg-black/80 backdrop-blur-sm z-50 flex items-center justify-center p-4">
        <div class="theme-bg-card rounded-xl shadow-2xl max-w-md w-full p-6 border theme-border">
            <h3 class="text-lg font-bold theme-text-main mb-4">Request Temporary Access</h3>

            <form id="request-elevation-form" onsubmit="submitElevationRequest(event)">
                <div class="space-y-4">

                    <div>
                        <label class="block text-sm font-medium theme-text-muted mb-1">Role / Permission</label>
                        <select id="req_requested_role" required
                            class="w-full theme-bg-body border theme-border rounded-lg theme-text-main focus:ring-2 focus:ring-blue-500 p-2.5">
                            <option value="Super Admin">Super Admin (Full Access)</option>
                            <option value="Finance Manager">Finance Manager (Payouts)</option>
                            <option value="Vendor Manager">Vendor Manager (Support)</option>
                            <option value="Support Staff">Support Staff(Support)</option>
                            <option value="Quality Control">Quality Control (Support)</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium theme-text-muted mb-1">Duration Needed</label>
                        <select id="req_duration_minutes" required
                            class="w-full theme-bg-body border theme-border rounded-lg theme-text-main focus:ring-2 focus:ring-blue-500 p-2.5">
                            <option value="15">15 Minutes</option>
                            <option value="30">30 Minutes</option>
                            <option value="60">1 Hour</option>
                            <option value="120">2 Hours (Max)</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium theme-text-muted mb-1">Justification</label>
                        <textarea id="req_justification" required rows="3"
                            placeholder="Why do you need this access? e.g. 'Resolving Payout Bug #123'"
                            class="w-full theme-bg-body border theme-border rounded-lg theme-text-main focus:ring-2 focus:ring-blue-500 p-2.5"></textarea>
                    </div>

                </div>

                <div class="mt-6 flex justify-end gap-3">
                    <button type="button" onclick="closeRequestModal()"
                        class="px-4 py-2 theme-text-muted hover:bg-white/5 rounded-lg transition">Cancel</button>
                    <button type="submit" id="submit-btn"
                        class="px-4 py-2 text-white rounded-lg font-medium shadow-sm hover:opacity-90 transition"
                        style="background-color: rgb(var(--brand-primary));">Submit Request</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://unpkg.com/lucide@latest"></script>
    <script>
        const API_BASE = '/api'; // Assuming routes are inside api.php

        document.addEventListener("DOMContentLoaded", () => {
            lucide.createIcons();
            loadActiveElevations();
            loadPendingApprovals();
            loadAuditLogs();
        });

        // --- API Helper ---
        async function apiRequest(endpoint, method = 'GET', body = null) {
            const token = localStorage.getItem('token');
            const fingerprint = localStorage.getItem('device_fingerprint') || 'unknown';

            const options = {
                method: method,
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'Authorization': `Bearer ${token}`,
                    'X-Device-Fingerprint': fingerprint
                }
            };
            if (body) options.body = JSON.stringify(body);

            try {
                const response = await fetch(endpoint, options);
                const result = await response.json();
                
                if (!response.ok) throw result;
                return result;
            } catch (error) {
                console.error('API Error:', error);
                if (error.errors) {
                    const msg = Object.values(error.errors).flat().join('\n');
                    alert("Validation Error:\n" + msg);
                } else if (error.message) {
                    alert(error.message);
                } else {
                    alert('Action completed or server error occurred. Check console.');
                }
                return null;
            }
        }

        // --- 1. Fetch & Render Lists (Requires GET endpoints on backend) ---
        
        async function loadActiveElevations() {
            const container = document.getElementById('active-elevations-list');
            container.innerHTML = '<tr><td colspan="5" class="px-6 py-4 text-center theme-text-muted">Loading active elevations...</td></tr>';

            // NOTE: Replace '/privileges' with your actual GET route if different
            const res = await apiRequest(`${API_BASE}/privileges`); 
            const privileges = res?.data?.privileges || res?.privileges || [];
            
            const active = privileges.filter(p => p.status === 'approved' && new Date(p.expires_at) > new Date());
            
            container.innerHTML = '';
            if (active.length === 0) {
                container.innerHTML = '<tr><td colspan="5" class="px-6 py-4 text-center theme-text-muted">No active elevations.</td></tr>';
                return;
            }

            active.forEach(item => {
                const expireDate = new Date(item.expires_at);
                const minsLeft = Math.max(0, Math.floor((expireDate - new Date()) / 60000));

                container.innerHTML += `
                    <tr class="hover:bg-white/5 transition-colors">
                        <td class="px-6 py-4">
                            <div class="font-medium theme-text-main">${item.user?.name || 'User #' + item.user_id}</div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-2 py-0.5 rounded-full bg-blue-500/10 text-blue-500 text-xs font-bold border border-blue-500/20 uppercase">
                                ${item.requested_role.replace('_', ' ')}
                            </span>
                        </td>
                        <td class="px-6 py-4 theme-text-muted text-xs">${item.justification}</td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-2 ${minsLeft < 15 ? 'text-red-500 font-bold' : 'text-amber-500'}">
                                <i data-lucide="clock" class="w-4 h-4"></i> ${minsLeft} mins
                            </div>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex justify-end gap-3">
                                <button onclick="extendPrivilege(${item.id})" class="text-xs font-bold text-blue-500 hover:underline">EXTEND (+15m)</button>
                                <button onclick="terminatePrivilege(${item.id})" class="text-xs font-bold text-red-500 hover:underline">TERMINATE</button>
                            </div>
                        </td>
                    </tr>
                `;
            });
            lucide.createIcons();
        }

        async function loadPendingApprovals() {
            const container = document.getElementById('pending-approvals-list');
            container.innerHTML = '<p class="text-sm theme-text-muted text-center">Loading pending approvals...</p>';

            // NOTE: Replace this with your actual GET route for pending requests
            const res = await apiRequest(`${API_BASE}/privileges`); 
            const privileges = res?.data?.privileges || res?.privileges || [];
            
            const pending = privileges.filter(p => p.status === 'pending');

            container.innerHTML = '';
            if (pending.length === 0) {
                container.innerHTML = '<p class="text-sm theme-text-muted text-center py-4">No pending requests.</p>';
                return;
            }

            pending.forEach(item => {
                container.innerHTML += `
                    <div class="flex items-start gap-4 p-4 rounded-lg border theme-border" style="background-color: rgba(var(--bg-body), 0.3);">
                        <div class="w-10 h-10 rounded-full theme-bg-card border theme-border flex items-center justify-center flex-shrink-0">
                            <i data-lucide="user" class="w-5 h-5 theme-text-muted"></i>
                        </div>
                        <div class="flex-1">
                            <h4 class="text-sm font-bold theme-text-main">${item.user?.name || 'User #' + item.user_id} <span class="text-xs font-normal theme-text-muted">requests</span> <span class="uppercase text-blue-500">${item.requested_role.replace('_', ' ')}</span></h4>
                            <p class="text-xs theme-text-muted mt-1 break-words">"${item.justification}"</p>
                        </div>
                        <div class="flex flex-col gap-2">
                            <button onclick="approvePrivilege(${item.id})" class="px-3 py-1.5 text-xs font-bold bg-green-500/10 text-green-500 border border-green-500/20 rounded hover:bg-green-500/20 transition">APPROVE</button>
                            <button onclick="denyPrivilege(${item.id})" class="px-3 py-1.5 text-xs font-bold bg-red-500/10 text-red-500 border border-red-500/20 rounded hover:bg-red-500/20 transition">DENY</button>
                        </div>
                    </div>
                `;
            });
            lucide.createIcons();
        }

        // --- 2. Action Endpoints (Mapped exactly to provided routes) ---

        async function submitElevationRequest(event) {
            event.preventDefault();
            const btn = document.getElementById('submit-btn');
            const originalText = btn.innerText;
            btn.innerText = 'Submitting...'; 
            btn.disabled = true;

            const payload = {
                requested_role: document.getElementById('req_requested_role').value,
                duration_minutes: parseInt(document.getElementById('req_duration_minutes').value),
                justification: document.getElementById('req_justification').value
            };

            const res = await apiRequest(`${API_BASE}/privileges/request`, 'POST', payload);
            if (res) {
                alert('Elevation requested successfully!');
                closeRequestModal();
                document.getElementById('request-elevation-form').reset();
                loadPendingApprovals(); // Refresh pending list
                loadAuditLogs();
            }

            btn.innerText = originalText; 
            btn.disabled = false;
        }

        async function approvePrivilege(id) {
            if (!confirm(`Are you sure you want to approve this request?`)) return;
            const res = await apiRequest(`${API_BASE}/privileges/approve/${id}`, 'POST');
            if (res) {
                loadPendingApprovals();
                loadActiveElevations();
                loadAuditLogs();
            }
        }

        async function denyPrivilege(id) {
            if (!confirm(`Are you sure you want to deny this request?`)) return;
            const res = await apiRequest(`${API_BASE}/privileges/deny/${id}`, 'POST');
            if (res) {
                loadPendingApprovals();
                loadAuditLogs();
            }
        }

        async function terminatePrivilege(id) {
            if (!confirm('Are you sure you want to terminate this access immediately?')) return;
            const res = await apiRequest(`${API_BASE}/privileges/terminate/${id}`, 'POST');
            if (res) {
                loadActiveElevations();
                loadAuditLogs();
            }
        }

        async function extendPrivilege(id) {
            const extra = prompt("Enter extra minutes to extend (e.g. 15):", "15");
            if (!extra || isNaN(extra)) return;

            const res = await apiRequest(`${API_BASE}/privileges/extend/${id}`, 'POST', { extra_minutes: parseInt(extra) });
            if (res) {
                loadActiveElevations();
                loadAuditLogs();
            }
        }

        // Dual Approval Specific Actions (If used in UI later)
        async function handleDualApproval(id, level) {
            // level can be 'level1', 'level2', or 'execute'
            let endpoint = '';
            if (level === 'level1') endpoint = `/dual-approval/approve-level1/${id}`;
            else if (level === 'level2') endpoint = `/dual-approval/approve-level2/${id}`;
            else if (level === 'execute') endpoint = `/dual-approval/execute/${id}`;

            const res = await apiRequest(`${API_BASE}${endpoint}`, 'POST');
            if (res) {
                alert(`Dual approval action completed.`);
                loadAuditLogs();
            }
        }

        // --- 3. Fetch Audit Logs (Exact route matched) ---
        async function loadAuditLogs() {
            const container = document.getElementById('audit-logs-list');
            container.innerHTML = '<p class="text-gray-400">Loading logs...</p>';

            const res = await apiRequest(`${API_BASE}/dual-approval/audit-logs`, 'GET');
            
            if (!res) return;

            // Extract logs based on your backend response structure
            const logs = res?.data?.logs || res?.logs || res || [];
            
            container.innerHTML = '';
            
            if (logs.length === 0) {
                container.innerHTML = '<p class="text-gray-400">No recent activity.</p>';
                return;
            }

            logs.forEach(log => {
                let colorClass = 'text-gray-400';
                let dotClass = 'bg-gray-500';
                
                if (log.event?.includes('approved')) { colorClass = 'text-green-400'; dotClass = 'bg-green-500'; }
                else if (log.event?.includes('denied') || log.event?.includes('terminated')) { colorClass = 'text-red-400'; dotClass = 'bg-red-500'; }
                else if (log.event?.includes('requested')) { colorClass = 'text-indigo-400'; dotClass = 'bg-indigo-500'; }

                const date = log.created_at ? new Date(log.created_at).toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'}) : 'Now';
                const eventName = log.event ? log.event.toUpperCase() : 'ACTION';

                container.innerHTML += `
                    <div class="flex gap-3 items-center mt-2 border-b border-gray-800 pb-2">
                        <div class="w-1.5 h-1.5 ${dotClass} rounded-full"></div>
                        <div>
                            <p class="text-[10px] text-gray-500">${date}</p>
                            <p class="text-white text-xs">User #${log.actor_id || 'System'} <span class="${colorClass}">${eventName}</span> Request #${log.id || ''}</p>
                        </div>
                    </div>
                `;
            });
        }

        // --- 4. Modal Controls ---
        function openRequestModal() { document.getElementById('access-modal').classList.remove('hidden'); }
        function closeRequestModal() { document.getElementById('access-modal').classList.add('hidden'); }
    </script>
@endpush

@push('styles')
    <style>
        .theme-ring {
            --tw-ring-color: rgb(var(--bg-card));
        }
    </style>
@endpush
