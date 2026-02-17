@extends('layouts.app')

@section('title', 'Session Management')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        
        <div class="flex flex-col md:flex-row justify-between items-start md:items-end mb-8 gap-4">
            <div>
                <h1 class="text-2xl font-bold text-slate-900">Active Sessions</h1>
                <p class="text-slate-500 mt-1">Monitor and control user access in real-time.</p>
            </div>
            
            <div class="flex gap-3">
                <button onclick="openRevokeRoleModal()" class="flex items-center gap-2 px-4 py-2 bg-white border border-gray-300 rounded-lg text-sm font-medium hover:bg-gray-50 text-slate-700 transition-colors shadow-sm">
                    <i data-lucide="users" class="w-4 h-4 text-slate-500"></i> 
                    <span>Revoke by Role</span>
                </button>
                <button onclick="revokeAllSessions()" class="flex items-center gap-2 px-4 py-2 bg-red-600 rounded-lg text-sm font-medium text-white hover:bg-red-700 shadow-sm transition-colors">
                    <i data-lucide="skull" class="w-4 h-4"></i> 
                    <span>Revoke All Sessions</span>
                </button>
            </div>
        </div>

        <div class="bg-white p-4 rounded-xl border border-gray-200 shadow-sm mb-6 flex flex-wrap gap-4 items-center justify-between">
            <div class="flex gap-4 flex-1">
                <div class="relative w-full max-w-sm">
                    <i data-lucide="search" class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400"></i>
                    <input type="text" id="search-input" placeholder="Search user, IP, or Device..." class="pl-10 w-full border-gray-300 rounded-lg text-sm focus:ring-indigo-500 focus:border-indigo-500">
                </div>
                <select id="risk-filter" class="border-gray-300 rounded-lg text-sm focus:ring-indigo-500 focus:border-indigo-500">
                    <option value="all">All Risk Levels</option>
                    <option value="high">High Risk (>50)</option>
                    <option value="medium">Medium Risk (10-50)</option>
                    <option value="low">Low Risk (<10)</option>
                </select>
            </div>
            <div class="text-sm text-slate-500">
                Showing <span class="font-bold text-slate-900" id="session-count">0</span> active sessions
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-slate-600">
                    <thead class="bg-slate-50 text-slate-700 font-semibold uppercase text-xs border-b border-gray-200">
                        <tr>
                            <th class="px-6 py-4">User Details</th>
                            <th class="px-6 py-4">Device / IP</th>
                            <th class="px-6 py-4">Location</th>
                            <th class="px-6 py-4">Risk Score</th>
                            <th class="px-6 py-4">Last Active</th>
                            <th class="px-6 py-4 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="sessions-table-body" class="divide-y divide-gray-100">
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-slate-400">
                                <i data-lucide="loader-2" class="w-8 h-8 animate-spin mx-auto mb-2"></i>
                                Loading sessions...
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

    </div>

    <div id="role-modal" class="hidden fixed inset-0 bg-slate-900/50 backdrop-blur-sm z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-xl shadow-2xl max-w-md w-full p-6">
            <h3 class="text-lg font-bold text-slate-900 mb-2">Force Logout by Role</h3>
            <p class="text-sm text-slate-500 mb-4">This will immediately terminate sessions for all users with the selected role.</p>
            
            <select id="role-select" class="w-full mb-6 border-gray-300 rounded-lg focus:ring-red-500 focus:border-red-500">
                <option value="admin">Administrators</option>
                <option value="moderator">Moderators</option>
                <option value="user">Standard Users</option>
            </select>

            <div class="flex justify-end gap-3">
                <button onclick="document.getElementById('role-modal').classList.add('hidden')" class="px-4 py-2 text-slate-700 hover:bg-slate-100 rounded-lg">Cancel</button>
                <button onclick="revokeByRole()" class="px-4 py-2 bg-red-600 text-white hover:bg-red-700 rounded-lg font-medium">Confirm Logout</button>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://unpkg.com/lucide@latest"></script>
    
    <script>
        // API Configuration
        const API_SESSIONS = "{{ url('/api/sessions') }}";
        const API_REVOKE_ALL = "{{ url('/api/sessions/revoke-all') }}";
        const API_REVOKE_ROLE = "{{ url('/api/sessions/revoke-role') }}";
        
        // Use the Token from your auth system (example)
        const AUTH_HEADERS = {
            'Content-Type': 'application/json',
            'Authorization': 'Bearer ' + localStorage.getItem('access_token'),
            'Accept': 'application/json'
        };

        document.addEventListener("DOMContentLoaded", () => {
            fetchSessions();
        });

        // 1. Fetch & Render Sessions
        async function fetchSessions() {
            try {
                // Real API Call
                // const res = await fetch(API_SESSIONS, { headers: AUTH_HEADERS });
                // const data = await res.json();
                
                // ⚠️ MOCK DATA (Based on your API Response example)
                // Using array to simulate list, your API gave single object example, assuming it returns array
                const mockSessions = [
                    {
                        "id": 22,
                        "user": { "name": "Javed Baloch", "email": "javedbaloch@gmail.com", "image": null },
                        "device": "MacBook Pro (Chrome)",
                        "ip_address": "127.0.0.1",
                        "location": "Rawalpindi, PK",
                        "risk_score": 0,
                        "last_activity_at": "2026-02-17T06:04:49.000000Z"
                    },
                    {
                        "id": 25,
                        "user": { "name": "Admin User", "email": "admin@sahorone.com", "image": null },
                        "device": "Unknown Mobile",
                        "ip_address": "192.168.1.5",
                        "location": "Lahore, PK",
                        "risk_score": 75, // High Risk Example
                        "last_activity_at": "2026-02-17T05:30:00.000000Z"
                    }
                ];

                renderTable(mockSessions); // Replace with `data` when API is live
                
            } catch (err) {
                console.error(err);
                document.getElementById('sessions-table-body').innerHTML = `
                    <tr><td colspan="6" class="text-center py-4 text-red-500">Failed to load sessions</td></tr>
                `;
            }
        }

        // 2. Render Table Logic
        function renderTable(sessions) {
            const tbody = document.getElementById('sessions-table-body');
            tbody.innerHTML = '';
            
            document.getElementById('session-count').innerText = sessions.length;

            sessions.forEach(session => {
                // Risk Badge Logic
                let badgeColor = 'bg-green-100 text-green-700';
                let riskLabel = 'Low';
                if(session.risk_score > 50) {
                    badgeColor = 'bg-red-100 text-red-700';
                    riskLabel = 'High';
                } else if(session.risk_score > 10) {
                    badgeColor = 'bg-yellow-100 text-yellow-700';
                    riskLabel = 'Medium';
                }

                // Time Formatting
                const timeAgo = new Date(session.last_activity_at).toLocaleTimeString();

                const row = `
                    <tr class="hover:bg-slate-50 transition-colors group">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600 font-bold text-xs">
                                    ${session.user.name.charAt(0)}
                                </div>
                                <div>
                                    <div class="font-medium text-slate-900">${session.user.name}</div>
                                    <div class="text-xs text-slate-500">${session.user.email}</div>
                                </div>
                            </div>
                        </td>
                        
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-2">
                                <i data-lucide="monitor" class="w-4 h-4 text-slate-400"></i>
                                <span>${session.device || 'Unknown'}</span>
                            </div>
                            <div class="text-xs text-slate-500 mt-1 font-mono">${session.ip_address}</div>
                        </td>

                        <td class="px-6 py-4">
                            <div class="flex items-center gap-1.5">
                                <i data-lucide="map-pin" class="w-3 h-3 text-slate-400"></i>
                                <span>${session.location || 'Local Network'}</span>
                            </div>
                        </td>

                        <td class="px-6 py-4">
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-medium ${badgeColor}">
                                ${riskLabel} (${session.risk_score}%)
                            </span>
                        </td>

                        <td class="px-6 py-4 text-slate-500 text-xs">
                            ${timeAgo}
                        </td>

                        <td class="px-6 py-4 text-right">
                            <div class="flex items-center justify-end gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                <button onclick="flagSession(${session.id})" class="p-1.5 hover:bg-yellow-50 text-yellow-600 rounded" title="Flag as Suspicious">
                                    <i data-lucide="flag" class="w-4 h-4"></i>
                                </button>
                                <button onclick="revokeSession(${session.id})" class="p-1.5 hover:bg-red-50 text-red-600 rounded border border-transparent hover:border-red-100" title="Revoke Session">
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

        // 3. Action: Revoke Single Session
        async function revokeSession(id) {
            if(!confirm('Are you sure you want to kill this session? The user will be logged out immediately.')) return;

            try {
                // API Call: POST /api/sessions/{id}/revoke
                const res = await fetch(`${API_SESSIONS}/${id}/revoke`, {
                    method: 'POST',
                    headers: AUTH_HEADERS
                });
                
                // For demo, we just remove row
                alert('Session Revoked Successfully');
                fetchSessions(); // Reload table

            } catch (err) {
                alert('Error revoking session');
            }
        }

        // 4. Action: Revoke All
        async function revokeAllSessions() {
            if(!confirm('DANGER: This will log out EVERYONE (including you?). Proceed?')) return;
            
            // Call API: /api/sessions/revoke-all
            console.log("Calling " + API_REVOKE_ALL);
            alert("All sessions revoked.");
            fetchSessions();
        }

        // 5. Action: Revoke by Role
        function openRevokeRoleModal() {
            document.getElementById('role-modal').classList.remove('hidden');
        }

        async function revokeByRole() {
            const role = document.getElementById('role-select').value;
            // Call API: /api/sessions/revoke-role
            // Body: { role: role }
            console.log("Revoking role: " + role);
            document.getElementById('role-modal').classList.add('hidden');
            alert(`All ${role} sessions terminated.`);
            fetchSessions();
        }

        // 6. Action: Flag Session
        async function flagSession(id) {
            // Logic to increase risk score
            // API: /api/sessions/{id}/flag
            alert("Session flagged for review.");
        }

    </script>
@endpush