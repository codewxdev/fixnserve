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
                {{-- Revoke By Role (Backend Supports this) --}}
                <button onclick="openRevokeRoleModal()" 
                    class="flex items-center gap-2 px-4 py-2 theme-bg-card border theme-border rounded-lg text-sm font-medium hover:bg-white/5 theme-text-main transition-colors shadow-sm">
                    <i data-lucide="shield-alert" class="w-4 h-4 theme-text-muted"></i> 
                    <span>Revoke by Role</span>
                </button>
                
                {{-- NOTE: "Revoke All System" button removed because backend requires user_id. 
                     Functionality moved to table rows per user. --}}
            </div>
        </div>

        {{-- FILTERS --}}
        <div class="theme-bg-card p-4 rounded-xl border theme-border shadow-sm mb-6 flex flex-wrap gap-4 items-center justify-between">
            <div class="flex gap-4 flex-1">
                <div class="relative w-full max-w-sm">
                    <i data-lucide="search" class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 theme-text-muted"></i>
                    <input type="text" id="search-input" placeholder="Search user, IP, or Device..." 
                        class="pl-10 w-full theme-bg-body border theme-border rounded-lg text-sm theme-text-main focus:ring-2 focus:ring-blue-500 placeholder-gray-500">
                </div>
                <select id="risk-filter" class="theme-bg-body border theme-border theme-text-main rounded-lg text-sm focus:ring-2 focus:ring-blue-500">
                    <option value="all">All Risk Levels</option>
                    <option value="high">High Risk (>50)</option>
                    <option value="medium">Medium Risk (10-50)</option>
                    <option value="low">Low Risk (<10)</option>
                </select>
            </div>
            <div class="text-sm theme-text-muted">
                Showing <span class="font-bold theme-text-main" id="session-count">0</span> active sessions
            </div>
        </div>

        {{-- TABLE --}}
        <div class="theme-bg-card rounded-xl shadow-sm border theme-border overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm theme-text-muted">
                    <thead class="theme-text-main font-semibold uppercase text-xs border-b theme-border" style="background-color: rgba(var(--bg-body), 0.5);">
                        <tr>
                            <th class="px-6 py-4">User Details</th>
                            <th class="px-6 py-4">Device / IP</th>
                            <th class="px-6 py-4">Location</th>
                            <th class="px-6 py-4">Risk Score</th>
                            <th class="px-6 py-4">Last Active</th>
                            <th class="px-6 py-4 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="sessions-table-body" class="divide-y theme-border" style="border-color: rgb(var(--border-color));">
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center theme-text-muted">
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
    <div id="role-modal" class="hidden fixed inset-0 bg-black/80 backdrop-blur-sm z-50 flex items-center justify-center p-4">
        <div class="theme-bg-card rounded-xl shadow-2xl max-w-md w-full p-6 border theme-border">
            <h3 class="text-lg font-bold theme-text-main mb-2">Force Logout by Role</h3>
            <p class="text-sm theme-text-muted mb-4">This will log out ALL users with the selected role.</p>
            
            <select id="role-select" class="w-full mb-6 theme-bg-body border theme-border theme-text-main rounded-lg focus:ring-2 focus:ring-red-500">
                <option value="Admin">Administrators</option>
                <option value="Moderator">Moderators</option>
                <option value="User">Standard Users</option>
            </select>

            <div class="flex justify-end gap-3">
                <button onclick="document.getElementById('role-modal').classList.add('hidden')" 
                    class="px-4 py-2 theme-text-muted hover:bg-white/5 rounded-lg border theme-border transition">Cancel</button>
                <button onclick="revokeByRole()" 
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
            const token = localStorage.getItem('token');
            return {
                'Content-Type': 'application/json',
                'Authorization': 'Bearer ' + token,
                'Accept': 'application/json'
            };
        }

        document.addEventListener("DOMContentLoaded", () => {
            fetchSessions();
        });

        // ==============================
        // 2. CORE FUNCTIONS
        // ==============================

        // A. Fetch Sessions
        async function fetchSessions() {
            const tbody = document.getElementById('sessions-table-body');
            tbody.innerHTML = `<tr><td colspan="6" class="text-center py-8"><i data-lucide="loader-2" class="animate-spin w-6 h-6 mx-auto"></i></td></tr>`;
            lucide.createIcons();

            try {
                const response = await fetch(`${API_BASE}/sessions`, { headers: getHeaders() });
                const data = await response.json();
                const sessions = Array.isArray(data) ? data : (data.data || []);
                renderTable(sessions);
            } catch (error) {
                console.error(error);
                tbody.innerHTML = `<tr><td colspan="6" class="text-center text-red-500 py-4">Error loading sessions</td></tr>`;
            }
        }

        // B. Revoke SINGLE Session (Logout ONLY this device)
        async function revokeSession(id) {
            if(!confirm('Are you sure? This will log the user out from THIS device only.')) return;

            try {
                // Backend: Route::post('/sessions/{id}/revoke')
                const response = await fetch(`${API_BASE}/sessions/${id}/revoke`, {
                    method: 'POST',
                    headers: getHeaders()
                });

                if(response.ok) {
                    showToast("Success", "Single session terminated.");
                    fetchSessions();
                } else {
                    alert("Failed to revoke session.");
                }
            } catch (error) {
                alert("Network error.");
            }
        }

        // C. Revoke ALL Sessions for User (Logout User from EVERYWHERE)
        async function revokeUserAllSessions(userId, userName) {
            if(!confirm(`DANGER: Are you sure you want to log out ${userName} from ALL devices?`)) return;

            try {
                // Backend: Route::post('/sessions/revoke-all') requiring 'user_id'
                const response = await fetch(`${API_BASE}/sessions/revoke-all`, {
                    method: 'POST',
                    headers: getHeaders(),
                    body: JSON.stringify({ user_id: userId }) // Passing user_id as required
                });

                if(response.ok) {
                    const result = await response.json();
                    showToast("Success", result.message || "User logged out from all devices.");
                    fetchSessions();
                } else {
                    alert("Failed to revoke user sessions.");
                }
            } catch (error) {
                console.error(error);
                alert("Network error.");
            }
        }

        // D. Revoke By Role (Existing)
        async function revokeByRole() {
            const role = document.getElementById('role-select').value;
            const btn = document.querySelector('#role-modal button.bg-red-500');
            
            btn.innerText = "Processing...";
            btn.disabled = true;

            try {
                const response = await fetch(`${API_BASE}/sessions/revoke-role`, {
                    method: 'POST',
                    headers: getHeaders(),
                    body: JSON.stringify({ role: role })
                });

                const result = await response.json();
                alert(result.message);
                document.getElementById('role-modal').classList.add('hidden');
                fetchSessions();
            } catch (error) {
                alert("Error revoking roles.");
            } finally {
                btn.innerText = "Confirm Logout";
                btn.disabled = false;
            }
        }

        // E. Flag Session
        async function flagSession(id) {
            const score = prompt("Enter new Risk Score (0-100):", "99");
            if (score === null) return;

            try {
                const response = await fetch(`${API_BASE}/sessions/${id}/flag`, {
                    method: 'POST',
                    headers: getHeaders(),
                    body: JSON.stringify({ risk_score: score })
                });

                if(response.ok) {
                    showToast("Alert", "Risk score updated.");
                    fetchSessions();
                }
            } catch (error) {
                console.error(error);
            }
        }

        // ==============================
        // 3. RENDER TABLE
        // ==============================

        function renderTable(sessions) {
            const tbody = document.getElementById('sessions-table-body');
            const searchInput = document.getElementById('search-input').value.toLowerCase();
            const riskFilter = document.getElementById('risk-filter').value;
            
            tbody.innerHTML = '';

            const filtered = sessions.filter(s => {
                // Safety check if user is null (deleted user)
                const uName = s.user ? s.user.name.toLowerCase() : '';
                const uEmail = s.user ? s.user.email.toLowerCase() : '';
                
                const matchSearch = (uName.includes(searchInput) || uEmail.includes(searchInput) || (s.ip_address && s.ip_address.includes(searchInput)));
                
                let matchRisk = true;
                if(riskFilter === 'high') matchRisk = s.risk_score > 50;
                if(riskFilter === 'medium') matchRisk = s.risk_score >= 10 && s.risk_score <= 50;
                if(riskFilter === 'low') matchRisk = s.risk_score < 10;

                return matchSearch && matchRisk;
            });

            document.getElementById('session-count').innerText = filtered.length;

            if(filtered.length === 0) {
                tbody.innerHTML = `<tr><td colspan="6" class="px-6 py-8 text-center theme-text-muted">No active sessions found.</td></tr>`;
                return;
            }

            filtered.forEach(session => {
                // Safety Vars
                const userId = session.user ? session.user.id : null;
                const userName = session.user ? session.user.name : 'Unknown';
                const userEmail = session.user ? session.user.email : 'No Email';
                const userInitial = userName.charAt(0);
                const lastActive = session.last_activity_at ? new Date(session.last_activity_at).toLocaleTimeString() : 'N/A';
                
                // Badge Logic
                let badgeColor = 'bg-green-500/10 text-green-500 border border-green-500/20';
                if(session.risk_score > 50) badgeColor = 'bg-red-500/10 text-red-500 border border-red-500/20';
                else if(session.risk_score > 10) badgeColor = 'bg-yellow-500/10 text-yellow-500 border border-yellow-500/20';

                // --- ACTION BUTTONS LOGIC ---
                // 1. Flag Button
                // 2. Kill Single Session (Using session.id)
                // 3. Kill ALL User Sessions (Using user.id) - Only if user exists
                
                let actionsHtml = `
                    <button onclick="flagSession(${session.id})" class="p-1.5 hover:bg-yellow-500/10 text-yellow-500 rounded transition" title="Flag Risk">
                        <i data-lucide="flag" class="w-4 h-4"></i>
                    </button>
                    
                    <button onclick="revokeSession(${session.id})" class="p-1.5 hover:bg-orange-500/10 text-orange-500 rounded transition" title="Kill This Session Only">
                        <i data-lucide="x-circle" class="w-4 h-4"></i>
                    </button>
                `;

                // Add "Revoke All for User" button only if we have a valid user ID
                if(userId) {
                    actionsHtml += `
                        <button onclick="revokeUserAllSessions(${userId}, '${userName}')" class="p-1.5 hover:bg-red-500/10 text-red-500 rounded transition border border-transparent hover:border-red-500/30" title="Log Out ${userName} from ALL Devices">
                            <i data-lucide="trash-2" class="w-4 h-4"></i>
                        </button>
                    `;
                }

                const row = `
                    <tr class="hover:bg-white/5 transition-colors group">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full flex items-center justify-center font-bold text-xs" style="background-color: rgba(var(--brand-primary), 0.1); color: rgb(var(--brand-primary));">
                                    ${userInitial}
                                </div>
                                <div>
                                    <div class="font-medium theme-text-main">${userName}</div>
                                    <div class="text-xs theme-text-muted">${userEmail}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-2">
                                <i data-lucide="monitor" class="w-4 h-4 theme-text-muted"></i>
                                <span class="theme-text-main">${session.device || 'Unknown'}</span>
                            </div>
                            <div class="text-xs theme-text-muted mt-1 font-mono">${session.ip_address || ''}</div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="theme-text-main text-xs">${session.location || 'Unknown'}</span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-medium ${badgeColor}">
                                ${session.risk_score}%
                            </span>
                        </td>
                        <td class="px-6 py-4 theme-text-muted text-xs">${lastActive}</td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex items-center justify-end gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                ${actionsHtml}
                            </div>
                        </td>
                    </tr>
                `;
                tbody.innerHTML += row;
            });
            lucide.createIcons();
        }

        // --- UTILS ---
        document.getElementById('search-input').addEventListener('input', fetchSessions);
        document.getElementById('risk-filter').addEventListener('change', fetchSessions);

        function showToast(title, message) {
            console.log(title, message);
            // Optional: Implement a real toast here
        }
    </script>
@endpush