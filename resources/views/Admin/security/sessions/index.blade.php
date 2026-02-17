@extends('layouts.app')

@section('title', 'Session Management')

@section('content')
    <div class="min-h-screen theme-bg-body theme-text-main max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        
        <div class="flex flex-col md:flex-row justify-between items-start md:items-end mb-8 gap-4">
            <div>
                <h1 class="text-2xl font-bold theme-text-main">Active Sessions</h1>
                <p class="theme-text-muted mt-1">Monitor and control user access in real-time.</p>
            </div>
            
            <div class="flex gap-3">
                <button onclick="openRevokeRoleModal()" 
                    class="flex items-center gap-2 px-4 py-2 theme-bg-card border theme-border rounded-lg text-sm font-medium hover:bg-white/5 theme-text-main transition-colors shadow-sm">
                    <i data-lucide="users" class="w-4 h-4 theme-text-muted"></i> 
                    <span>Revoke by Role</span>
                </button>
                <button onclick="revokeAllSessions()" 
                    class="flex items-center gap-2 px-4 py-2 text-white rounded-lg text-sm font-medium shadow-sm transition-colors hover:opacity-90"
                    style="background-color: #ef4444;"> {{-- Red for Danger --}}
                    <i data-lucide="skull" class="w-4 h-4"></i> 
                    <span>Revoke All Sessions</span>
                </button>
            </div>
        </div>

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
            <p class="text-sm theme-text-muted mb-4">This will immediately terminate sessions for all users with the selected role.</p>
            
            <select id="role-select" class="w-full mb-6 theme-bg-body border theme-border theme-text-main rounded-lg focus:ring-2 focus:ring-red-500">
                <option value="admin">Administrators</option>
                <option value="moderator">Moderators</option>
                <option value="user">Standard Users</option>
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
        // 1. CONFIGURATION & STATE
        // ==============================
        const API_BASE = "{{ url('/api') }}";
        
        // Headers with Auth Token (Local Storage se utha raha hun)
        function getHeaders() {
            const token = localStorage.getItem('access_token');
            return {
                'Content-Type': 'application/json',
                'Authorization': 'Bearer ' + token,
                'Accept': 'application/json'
            };
        }

        // ==============================
        // 2. INITIALIZATION
        // ==============================
        document.addEventListener("DOMContentLoaded", () => {
            fetchSessions();
        });

        // ==============================
        // 3. CORE FUNCTIONS (API CALLS)
        // ==============================

        // A. Fetch All Sessions
        async function fetchSessions() {
            const tbody = document.getElementById('sessions-table-body');
            
            // Show Loading State
            tbody.innerHTML = `
                <tr><td colspan="6" class="px-6 py-12 text-center theme-text-muted">
                    <i data-lucide="loader-2" class="w-8 h-8 animate-spin mx-auto mb-2 opacity-50"></i>
                    Fetching latest sessions...
                </td></tr>
            `;
            lucide.createIcons();

            try {
                const response = await fetch(`${API_BASE}/sessions`, { headers: getHeaders() });
                
                if (!response.ok) throw new Error("Unauthorized or Failed");

                let data = await response.json();
                
                // Handle Response Format (Direct array or {data: []})
                const sessions = Array.isArray(data) ? data : (data.data || []);
                
                renderTable(sessions);

            } catch (err) {
                console.error(err);
                tbody.innerHTML = `
                    <tr><td colspan="6" class="text-center py-4 text-red-500 font-bold">
                        Failed to load sessions. Please check if you are logged in.
                        <br><button onclick="fetchSessions()" class="mt-2 underline text-sm">Retry</button>
                    </td></tr>
                `;
            }
        }

        // B. Revoke Single Session (Kill)
        async function revokeSession(id) {
            if(!confirm('Are you sure you want to kill this session? The user will be logged out immediately.')) return;

            try {
                const response = await fetch(`${API_BASE}/sessions/${id}/revoke`, {
                    method: 'POST',
                    headers: getHeaders()
                });

                if(response.ok) {
                    showToast("Success", "Session terminated successfully.");
                    fetchSessions(); // Refresh Table
                } else {
                    alert("Failed to revoke session.");
                }
            } catch (error) {
                console.error(error);
                alert("Network error.");
            }
        }

        // C. Revoke All Sessions (Panic Button)
        async function revokeAllSessions() {
            if(!confirm('DANGER: This will log out EVERYONE (Active Users). Are you sure?')) return;
            
            try {
                const response = await fetch(`${API_BASE}/sessions/revoke-all`, {
                    method: 'POST',
                    headers: getHeaders()
                });

                const result = await response.json();
                alert(result.message || "All sessions revoked.");
                fetchSessions(); // Refresh Table
            } catch (error) {
                alert("Failed to execute command.");
            }
        }

        // D. Revoke By Role
        function openRevokeRoleModal() {
            document.getElementById('role-modal').classList.remove('hidden');
        }

        async function revokeByRole() {
            const role = document.getElementById('role-select').value;
            const btn = document.querySelector('#role-modal button.bg-red-500'); // Button selector
            
            // Disable button
            btn.innerText = "Processing...";
            btn.disabled = true;

            try {
                const response = await fetch(`${API_BASE}/sessions/revoke-role`, {
                    method: 'POST',
                    headers: getHeaders(),
                    body: JSON.stringify({ role: role }) // Sending Role in Body
                });

                const result = await response.json();
                alert(result.message || `Sessions for ${role} revoked.`);
                
                document.getElementById('role-modal').classList.add('hidden');
                fetchSessions();
            } catch (error) {
                alert("Error revoking roles.");
            } finally {
                btn.innerText = "Confirm Logout";
                btn.disabled = false;
            }
        }

        // E. Flag Session (Update Risk Score)
        async function flagSession(id) {
            // API Error showed "risk_score field is required", so we ask for it
            const score = prompt("Enter new Risk Score (0-100) for this session:", "99");
            
            if (score === null) return; // Cancelled

            try {
                const response = await fetch(`${API_BASE}/sessions/${id}/flag`, {
                    method: 'POST',
                    headers: getHeaders(),
                    body: JSON.stringify({ risk_score: score })
                });

                if(response.ok) {
                    showToast("Alert", "Session flagged as High Risk.");
                    fetchSessions();
                } else {
                    const err = await response.json();
                    alert(err.message || "Failed to flag session.");
                }
            } catch (error) {
                console.error(error);
            }
        }

        // ==============================
        // 4. HELPER FUNCTIONS
        // ==============================

        function renderTable(sessions) {
            const tbody = document.getElementById('sessions-table-body');
            const searchInput = document.getElementById('search-input').value.toLowerCase();
            const riskFilter = document.getElementById('risk-filter').value;
            
            tbody.innerHTML = '';

            // Client Side Filtering (Optional, for smoother UX)
            const filtered = sessions.filter(s => {
                const matchSearch = (s.user.name.toLowerCase().includes(searchInput) || 
                                     s.user.email.toLowerCase().includes(searchInput) ||
                                     (s.ip_address && s.ip_address.includes(searchInput)));
                
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
                // Formatting Logic
                let badgeColor = 'bg-green-500/10 text-green-500 border border-green-500/20';
                let riskLabel = 'Low';
                
                if(session.risk_score > 50) {
                    badgeColor = 'bg-red-500/10 text-red-500 border border-red-500/20';
                    riskLabel = 'High';
                } else if(session.risk_score > 10) {
                    badgeColor = 'bg-yellow-500/10 text-yellow-500 border border-yellow-500/20';
                    riskLabel = 'Medium';
                }

                // Null checks for user details
                const userName = session.user ? session.user.name : 'Unknown';
                const userEmail = session.user ? session.user.email : 'No Email';
                const userInitial = userName.charAt(0);
                const lastActive = session.last_activity_at ? new Date(session.last_activity_at).toLocaleTimeString() : 'N/A';
                const location = session.location || 'Unknown Location';
                const device = session.device || 'Unknown Device';

                // HTML Row
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
                                <span class="theme-text-main">${device}</span>
                            </div>
                            <div class="text-xs theme-text-muted mt-1 font-mono">${session.ip_address}</div>
                        </td>

                        <td class="px-6 py-4">
                            <div class="flex items-center gap-1.5">
                                <i data-lucide="map-pin" class="w-3 h-3 theme-text-muted"></i>
                                <span class="theme-text-main">${location}</span>
                            </div>
                        </td>

                        <td class="px-6 py-4">
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-medium ${badgeColor}">
                                ${riskLabel} (${session.risk_score}%)
                            </span>
                        </td>

                        <td class="px-6 py-4 theme-text-muted text-xs">
                            ${lastActive}
                        </td>

                        <td class="px-6 py-4 text-right">
                            <div class="flex items-center justify-end gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                <button onclick="flagSession(${session.id})" class="p-1.5 hover:bg-yellow-500/10 text-yellow-500 rounded" title="Flag as Suspicious">
                                    <i data-lucide="flag" class="w-4 h-4"></i>
                                </button>
                                <button onclick="revokeSession(${session.id})" class="p-1.5 hover:bg-red-500/10 text-red-500 rounded border border-transparent hover:border-red-500/30" title="Revoke Session">
                                    <span class="text-xs font-bold px-1">KILL</span>
                                </button>
                            </div>
                        </td>
                    </tr>
                `;
                tbody.innerHTML += row;
            });
            lucide.createIcons();
        }

        // Search & Filter Listeners
        document.getElementById('search-input').addEventListener('input', fetchSessions);
        document.getElementById('risk-filter').addEventListener('change', fetchSessions);

        // Simple Toast for Feedback
        function showToast(title, message) {
            // You can replace this with a real toast library if you have one
            // alert(`${title}: ${message}`); 
            console.log(title, message);
        }

    </script>
@endpush