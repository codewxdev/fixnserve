@extends('layouts.app')

@section('title', 'Session Management')

@section('content')
    <div class="min-h-screen theme-bg-body theme-text-main max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        {{-- HEADER SECTION --}}
        <div class="flex flex-col md:flex-row justify-between items-start md:items-end mb-8 gap-4">
            <div>
                <h1 class="text-2xl font-bold theme-text-main">Active Sessions</h1>
                <p class="theme-text-muted mt-1">Monitor and control user access in real-time.</p>
            </div>

            <div class="flex gap-3">
                {{-- Revoke By Role --}}
                <button onclick="openRevokeRoleModal()"
                    class="flex items-center gap-2 px-4 py-2 theme-bg-card border theme-border rounded-lg text-sm font-medium hover:bg-white/5 theme-text-main transition-colors shadow-sm">
                    <i data-lucide="shield-alert" class="w-4 h-4 theme-text-muted"></i>
                    <span>Revoke by Role</span>
                </button>
            </div>
        </div>

        {{-- FILTERS --}}
        <div
            class="theme-bg-card p-4 rounded-xl border theme-border shadow-sm mb-6 flex flex-wrap gap-4 items-center justify-between">
            <div class="flex gap-4 flex-1">
                <div class="relative w-full max-w-sm">
                    <i data-lucide="search" class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 theme-text-muted"></i>
                    <input type="text" id="search-input" placeholder="Search user, IP, or Device..."
                        class="pl-10 w-full theme-bg-body border theme-border rounded-lg text-sm theme-text-main focus:ring-2 focus:ring-blue-500 placeholder-gray-500">
                </div>

                {{-- NEW: Status Filter --}}
                <select id="status-filter"
                    class="theme-bg-body border theme-border theme-text-main rounded-lg text-sm focus:ring-2 focus:ring-blue-500">
                    <option value="all">All Status</option>
                    <option value="active" selected>Active Only</option>
                    <option value="inactive">Inactive / Revoked</option>
                </select>

                <select id="risk-filter"
                    class="theme-bg-body border theme-border theme-text-main rounded-lg text-sm focus:ring-2 focus:ring-blue-500">
                    <option value="all">All Risk Levels</option>
                    <option value="high">High Risk (>50)</option>
                    <option value="medium">Medium Risk (10-50)</option>
                    <option value="low">Low Risk (<10)< /option>
                </select>
            </div>
            <div class="text-sm theme-text-muted">
                Showing <span class="font-bold theme-text-main" id="session-count">0</span> sessions
            </div>
        </div>

        {{-- TABLE --}}
        <div class="theme-bg-card rounded-xl shadow-sm border theme-border overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm theme-text-muted">
                    <thead class="theme-text-main font-semibold uppercase text-xs border-b theme-border"
                        style="background-color: rgba(var(--bg-body), 0.5);">
                        <tr>
                            <th class="px-6 py-4">User Details</th>
                            <th class="px-6 py-4">Device / IP</th>
                            <th class="px-6 py-4">Location</th>
                            <th class="px-6 py-4">Risk Score</th>
                            <th class="px-6 py-4">Status</th> {{-- NEW COLUMN --}}
                            <th class="px-6 py-4">Last Active</th>
                            <th class="px-6 py-4 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="sessions-table-body" class="divide-y theme-border"
                        style="border-color: rgb(var(--border-color));">
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center theme-text-muted">
                                <i data-lucide="loader-2" class="w-8 h-8 animate-spin mx-auto mb-2 opacity-50"></i>
                                Loading sessions...
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

    </div>

    {{-- ROLE REVOKE MODAL --}}
    <div id="role-modal"
        class="hidden fixed inset-0 bg-black/80 backdrop-blur-sm z-50 flex items-center justify-center p-4">
        <div class="theme-bg-card rounded-xl shadow-2xl max-w-md w-full p-6 border theme-border">
            <h3 class="text-lg font-bold theme-text-main mb-2">Force Logout by Role</h3>
            <p class="text-sm theme-text-muted mb-4">This will log out ALL users with the selected role.</p>

            <select id="role-select"
                class="w-full mb-6 theme-bg-body border theme-border theme-text-main rounded-lg focus:ring-2 focus:ring-red-500">
                <option value="" disabled selected>Loading roles...</option>
            </select>

            <div class="flex justify-end gap-3">
                <button onclick="document.getElementById('role-modal').classList.add('hidden')"
                    class="px-4 py-2 theme-text-muted hover:bg-white/5 rounded-lg border theme-border transition">Cancel</button>

                <button id="confirm-revoke-btn" onclick="revokeByRole()"
                    class="px-4 py-2 text-white rounded-lg font-medium shadow-sm transition hover:opacity-90"
                    style="background-color: #ef4444;">Confirm Logout</button>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://unpkg.com/lucide@latest"></script>

    <script>
        // ==============================
        // 1. CONFIGURATION
        // ==============================
        const API_BASE = "{{ url('/api') }}";

        function getHeaders() {
            return {
                'Content-Type': 'application/json',
                'Authorization': 'Bearer ' + localStorage.getItem('token'),
                'Accept': 'application/json',
                'X-Device-Fingerprint': localStorage.getItem('device_fingerprint') || 'unknown'
            };
        }

        document.addEventListener("DOMContentLoaded", () => {
            fetchSessions();
            fetchRoles();
        });

        // ==============================
        // 2. CORE FUNCTIONS
        // ==============================

        async function fetchRoles() {
            const select = document.getElementById('role-select');
            if(!select) return;
            
            try {
                const response = await fetch(`${API_BASE}/roles`, { headers: getHeaders() });
                const data = await response.json();
                const roles = Array.isArray(data) ? data : (data.data || []);
                
                select.innerHTML = roles.map(role => {
                    const name = (typeof role === 'object') ? role.name : role;
                    return `<option value="${name}">${name.charAt(0).toUpperCase() + name.slice(1)}</option>`;
                }).join('');
            } catch (error) {
                console.error("Role fetch error:", error);
            }
        }

        async function fetchSessions() {
            const tbody = document.getElementById('sessions-table-body');
            tbody.innerHTML = `<tr><td colspan="7" class="text-center py-8"><i data-lucide="loader-2" class="animate-spin w-6 h-6 mx-auto"></i></td></tr>`;
            lucide.createIcons();

            try {
                const response = await fetch(`${API_BASE}/sessions`, { headers: getHeaders() });
                const data = await response.json();
                // Controller directly returns the array
                renderTable(Array.isArray(data) ? data : []);
            } catch (error) {
                tbody.innerHTML = `<tr><td colspan="7" class="text-center text-red-500 py-4">Failed to load sessions.</td></tr>`;
            }
        }

        async function handleAction(url, method = 'POST', body = null) {
            try {
                const response = await fetch(url, {
                    method: method,
                    headers: getHeaders(),
                    body: body ? JSON.stringify(body) : null
                });

                const result = await response.json();

                if (response.ok) {
                    showToast("Success", result.message);
                    fetchSessions();
                } else {
                    // Agar SQL error aaye to yahan alert dikhayega
                    alert("Error: " + (result.message || "Server Side Error (Check database constraints)"));
                }
            } catch (error) {
                alert("Network error. Please try again.");
            }
        }

        function revokeSession(id) {
            if (confirm('Revoke this specific session?')) {
                handleAction(`${API_BASE}/sessions/${id}/revoke`);
            }
        }

        function revokeUserAllSessions(userId, userName) {
            if (confirm(`Log out ${userName} from ALL devices?`)) {
                handleAction(`${API_BASE}/sessions/revoke-all`, 'POST', { user_id: userId });
            }
        }

        function flagSession(id) {
            const score = prompt("Enter Risk Score (0-100):", "99");
            if (score !== null) {
                handleAction(`${API_BASE}/sessions/${id}/flag`, 'POST', { risk_score: score });
            }
        }

        // ==============================
        // 3. RENDER TABLE
        // ==============================

        function renderTable(sessions) {
            const tbody = document.getElementById('sessions-table-body');
            const searchTerm = document.getElementById('search-input').value.toLowerCase();
            const riskFilter = document.getElementById('risk-filter').value;
            const statusFilter = document.getElementById('status-filter').value;

            const filtered = sessions.filter(s => {
                const isActive = !s.is_revoked && !s.logout_at;
                const name = s.user?.name?.toLowerCase() || '';
                const email = s.user?.email?.toLowerCase() || '';
                const ip = s.ip_address?.toLowerCase() || '';

                const matchesSearch = name.includes(searchTerm) || email.includes(searchTerm) || ip.includes(searchTerm);
                const matchesRisk = riskFilter === 'all' || 
                    (riskFilter === 'high' && s.risk_score > 50) ||
                    (riskFilter === 'medium' && s.risk_score >= 10 && s.risk_score <= 50) ||
                    (riskFilter === 'low' && s.risk_score < 10);
                const matchesStatus = statusFilter === 'all' || 
                    (statusFilter === 'active' && isActive) || 
                    (statusFilter === 'inactive' && !isActive);

                return matchesSearch && matchesRisk && matchesStatus;
            });

            document.getElementById('session-count').innerText = filtered.length;

            if (filtered.length === 0) {
                tbody.innerHTML = `<tr><td colspan="7" class="px-6 py-8 text-center theme-text-muted">No sessions found.</td></tr>`;
                return;
            }

            tbody.innerHTML = filtered.map(s => {
                const isActive = !s.is_revoked && !s.logout_at;
                const riskColor = s.risk_score > 50 ? 'text-red-500 bg-red-500/10 border-red-500/20' : 
                                 s.risk_score > 10 ? 'text-yellow-500 bg-yellow-500/10 border-yellow-500/20' : 
                                 'text-green-500 bg-green-500/10 border-green-500/20';

                return `
                    <tr class="hover:bg-white/5 transition-colors group">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full flex items-center justify-center bg-primary/10 text-primary font-bold text-xs">
                                    ${(s.user?.name || 'U')[0]}
                                </div>
                                <div>
                                    <div class="font-medium theme-text-main">${s.user?.name || 'Unknown'}</div>
                                    <div class="text-xs theme-text-muted">${s.user?.email || ''}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-2 theme-text-main">
                                <i data-lucide="monitor" class="w-4 h-4 opacity-50"></i> ${s.device || 'Unknown'}
                            </div>
                            <div class="text-xs theme-text-muted mt-1 font-mono">${s.ip_address || ''}</div>
                        </td>
                        <td class="px-6 py-4 text-xs theme-text-main">${s.location || 'Unknown'}</td>
                        <td class="px-6 py-4">
                            <span class="px-2.5 py-0.5 rounded-full text-xs font-medium border ${riskColor}">
                                ${s.risk_score}%
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            ${isActive ? 
                                `<span class="inline-flex items-center gap-1.5 text-green-500 text-xs font-bold"><div class="w-1.5 h-1.5 rounded-full bg-green-500"></div> Active</span>` : 
                                `<span class="text-gray-500 text-xs font-bold">Inactive</span>`}
                        </td>
                        <td class="px-6 py-4 theme-text-muted text-xs">
                            ${s.last_activity_at ? new Date(s.last_activity_at).toLocaleTimeString() : 'N/A'}
                        </td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex items-center justify-end gap-2 ${!isActive ? 'opacity-40 grayscale pointer-events-none' : ''}">
                                <button onclick="flagSession(${s.id})" class="p-1.5 hover:bg-yellow-500/10 text-yellow-500 rounded transition"><i data-lucide="flag" class="w-4 h-4"></i></button>
                                <button onclick="revokeSession(${s.id})" class="p-1.5 hover:bg-orange-500/10 text-orange-500 rounded transition"><i data-lucide="x-circle" class="w-4 h-4"></i></button>
                                <button onclick="revokeUserAllSessions(${s.user_id}, '${s.user?.name}')" class="p-1.5 hover:bg-red-500/10 text-red-500 rounded transition"><i data-lucide="trash-2" class="w-4 h-4"></i></button>
                            </div>
                        </td>
                    </tr>
                `;
            }).join('');
            
            lucide.createIcons();
        }

        // --- Event Listeners ---
        document.getElementById('search-input').addEventListener('input', () => renderTable(window.lastSessions || []));
        document.getElementById('risk-filter').addEventListener('change', () => renderTable(window.lastSessions || []));
        document.getElementById('status-filter').addEventListener('change', () => renderTable(window.lastSessions || []));

        // Override fetchSessions to cache data for filtering
        const originalFetch = fetchSessions;
        fetchSessions = async function() {
            const response = await fetch(`${API_BASE}/sessions`, { headers: getHeaders() });
            const data = await response.json();
            window.lastSessions = Array.isArray(data) ? data : [];
            renderTable(window.lastSessions);
        };

        function showToast(title, message) {
            console.log(`[${title}] ${message}`);
            // Agar aapke paas toast library hai to yahan call karein
        }
    </script>
@endpush
