@extends('layouts.app')

@section('title', 'Privileged Access Governance')

@section('content')
    <div class="min-h-screen theme-bg-body theme-text-main max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
            <div>
                <h1 class="text-2xl font-bold theme-text-main">Privileged Access & Approvals</h1>
                <p class="theme-text-muted mt-1">Manage Just-In-Time (JIT) access requests and enforce multi-party authorization.</p>
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
                    <div class="px-6 py-4 border-b theme-border flex justify-between items-center" style="background-color: rgba(var(--bg-body), 0.5);">
                        <h3 class="font-semibold theme-text-main flex items-center gap-2">
                            <i data-lucide="timer" class="w-4 h-4" style="color: rgb(var(--brand-primary));"></i> Active Elevations
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
                            <tbody id="active-elevations-list" class="divide-y theme-border" style="border-color: rgb(var(--border-color));">
                                <tr>
                                    <td colspan="5" class="px-6 py-4 text-center">Loading active elevations...</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- PENDING APPROVALS --}}
                <div class="theme-bg-card rounded-xl shadow-sm border theme-border">
                    <div class="px-6 py-4 border-b theme-border flex justify-between items-center" style="background-color: rgba(var(--bg-body), 0.5);">
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
                            <i data-lucide="shield" class="w-4 h-4" style="color: rgb(var(--brand-primary));"></i> Governance Rules
                        </h3>
                    </div>
                    <div class="p-4 space-y-4">
                        <div class="flex items-center justify-between pb-3 border-b theme-border">
                            <div>
                                <p class="text-sm font-medium theme-text-main">Max Elevation Time</p>
                                <p class="text-xs theme-text-muted">Auto-revoke after duration</p>
                            </div>
                            <span class="text-xs font-bold theme-bg-body border theme-border px-2 py-1 rounded theme-text-muted">2 Hours</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium theme-text-main">Dual Approval</p>
                                <p class="text-xs theme-text-muted">Requires Level 1 & Level 2</p>
                            </div>
                            <span class="text-xs font-bold theme-bg-body border theme-border px-2 py-1 rounded text-amber-500">Strict</span>
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
                    
                    <button onclick="loadAuditLogs()" class="w-full mt-4 py-2 bg-white/10 text-gray-300 text-xs rounded hover:bg-white/20 transition">Refresh Logs</button>
                </div>

            </div>
        </div>
    </div>

    {{-- REQUEST MODAL --}}
    <div id="access-modal" class="hidden fixed inset-0 bg-black/80 backdrop-blur-sm z-50 flex items-center justify-center p-4">
        <div class="theme-bg-card rounded-xl shadow-2xl max-w-md w-full p-6 border theme-border">
            <h3 class="text-lg font-bold theme-text-main mb-4">Request Temporary Access</h3>
            
            <form id="request-elevation-form" onsubmit="submitElevationRequest(event)">
                <div class="space-y-4">
                    
                    <div>
                        <label class="block text-sm font-medium theme-text-muted mb-1">Role / Permission</label>
                        <select id="req_requested_role" required class="w-full theme-bg-body border theme-border rounded-lg theme-text-main focus:ring-2 focus:ring-blue-500 p-2.5">
                            <option value="super_admin">Super Admin (Full Access)</option>
                            <option value="finance_manager">Finance Manager (Payouts)</option>
                            <option value="support_impersonate">User Impersonation (Support)</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium theme-text-muted mb-1">Duration Needed</label>
                        <select id="req_duration_minutes" required class="w-full theme-bg-body border theme-border rounded-lg theme-text-main focus:ring-2 focus:ring-blue-500 p-2.5">
                            <option value="15">15 Minutes</option>
                            <option value="30">30 Minutes</option>
                            <option value="60">1 Hour</option>
                            <option value="120">2 Hours (Max)</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium theme-text-muted mb-1">Justification</label>
                        <textarea id="req_justification" required rows="3" placeholder="Why do you need this access? e.g. 'Resolving Payout Bug #123'" 
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
        const API_BASE = 'http://127.0.0.1:8000/api';

        // 1. Authorization Headers Helper
        const getHeaders = () => {
            const token = localStorage.getItem('token');
            if (!token) console.warn("No authentication token found in localStorage.");
            return {
                'Authorization': `Bearer ${token}`,
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-Device-Fingerprint': localStorage.getItem('device_fingerprint') || 'unknown'
            };
        };

        // 2. Modal Controls
        function openRequestModal() { document.getElementById('access-modal').classList.remove('hidden'); }
        function closeRequestModal() { document.getElementById('access-modal').classList.add('hidden'); }

        // 3. Request Elevation
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

            try {
                const response = await fetch(`${API_BASE}/privileges/request`, {
                    method: 'POST',
                    headers: getHeaders(),
                    body: JSON.stringify(payload)
                });

                if (response.ok) {
                    alert('Elevation requested successfully!');
                    closeRequestModal();
                    document.getElementById('request-elevation-form').reset();
                    // loadActiveElevations(); // Refresh list agar aapke paas GET API ho
                } else {
                    const data = await response.json();
                    alert(`Error: ${data.message || 'Validation Failed'}`);
                }
            } catch (error) {
                console.error(error);
                alert('Network error. Failed to communicate with server.');
            } finally {
                btn.innerText = originalText; 
                btn.disabled = false;
            }
        }

        // 4. Terminate Privilege
        async function terminatePrivilege(id) {
            if (!confirm('Are you sure you want to terminate this access immediately?')) return;
            
            try {
                const response = await fetch(`${API_BASE}/privileges/terminate/${id}`, {
                    method: 'POST',
                    headers: getHeaders()
                });

                if (response.ok) {
                    alert('Privilege terminated.');
                    // loadActiveElevations(); // Refresh list
                }
            } catch (error) {
                console.error(error);
            }
        }

        // 5. Dual Approval Actions
        async function handleDualApproval(actionType, id) {
            let endpoint = '';
            
            switch(actionType) {
                case 'approve_l1': endpoint = `/dual-approval/approve-level1/${id}`; break;
                case 'approve_l2': endpoint = `/dual-approval/approve-level2/${id}`; break;
                case 'execute': endpoint = `/dual-approval/execute/${id}`; break;
                // Using standard privileges deny endpoint as per your instructions
                case 'deny': endpoint = `/privileges/deny/${id}`; break; 
            }

            try {
                const response = await fetch(`${API_BASE}${endpoint}`, {
                    method: 'POST',
                    headers: getHeaders()
                });

                const data = await response.json();
                
                if (response.ok) {
                    alert(`Success: ${data.message || 'Action completed'}`);
                    loadAuditLogs(); // Refresh logs to show new event
                    // loadPendingApprovals(); // Refresh pending list
                } else {
                    alert(`Error: ${data.message || 'Action failed'}`);
                }
            } catch (error) {
                console.error(error);
                alert('Server connection failed.');
            }
        }

        // 6. Fetch Audit Logs
        async function loadAuditLogs() {
            const container = document.getElementById('audit-logs-list');
            container.innerHTML = '<p class="text-gray-400">Loading...</p>';

            try {
                // Fetching via GET since controller `auditApprovalLogs` typically maps to a GET request
                const response = await fetch(`${API_BASE}/dual-approval/audit-logs`, {
                    method: 'GET', 
                    headers: getHeaders()
                });

                if (response.ok) {
                    const logs = await response.json();
                    container.innerHTML = '';
                    
                    if (logs.length === 0) {
                        container.innerHTML = '<p class="text-gray-400">No logs found.</p>';
                        return;
                    }

                    logs.forEach(log => {
                        let colorClass = 'text-gray-400';
                        let dotClass = 'bg-gray-500';
                        
                        if (log.event.includes('approved')) { colorClass = 'text-green-400'; dotClass = 'bg-green-500'; }
                        else if (log.event.includes('denied') || log.event.includes('terminated')) { colorClass = 'text-red-400'; dotClass = 'bg-red-500'; }
                        else if (log.event.includes('requested')) { colorClass = 'text-indigo-400'; dotClass = 'bg-indigo-500'; }

                        const date = new Date(log.created_at).toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'});

                        container.innerHTML += `
                            <div class="flex gap-3">
                                <div class="min-w-[4px] ${dotClass} rounded-full"></div>
                                <div>
                                    <p class="text-gray-400">${date}</p>
                                    <p class="text-white">User #${log.actor_id} <span class="${colorClass}">${log.event.toUpperCase()}</span> Dual Approval #${log.dual_approval_id}</p>
                                </div>
                            </div>
                        `;
                    });
                }
            } catch (error) {
                container.innerHTML = '<p class="text-red-400">Failed to load logs.</p>';
                console.error("Audit log error:", error);
            }
        }

        // Initialize Everything
        document.addEventListener("DOMContentLoaded", () => {
            lucide.createIcons();
            loadAuditLogs(); // Load logs automatically on page load

            // TODO: Yahan aap apni Active Elevations aur Pending Approvals GET karne ki JS likh sakte hain
            // Example: loadActiveElevations(); loadPendingApprovals();
        });
    </script>
@endpush

@push('styles')
<style>
    .theme-ring {
        --tw-ring-color: rgb(var(--bg-card));
    }
</style>
@endpush