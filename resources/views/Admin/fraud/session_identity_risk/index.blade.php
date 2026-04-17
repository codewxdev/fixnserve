@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-[rgb(var(--bg-body))] font-sans transition-colors duration-300">
    <div class="container mx-auto px-4 py-8">

        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 border-b border-[rgb(var(--border-color))] pb-4">
            <div>
                <h1 class="text-3xl font-bold text-[rgb(var(--text-main))] transition-colors">Session & Identity Risk</h1>
                <p class="text-sm text-[rgb(var(--text-muted))] mt-1 transition-colors">Detect Account Takeovers, Bots, and Device Impersonation</p>
            </div>
            
            <div class="mt-4 md:mt-0 flex space-x-4">
                <div class="bg-red-50 p-3 rounded-lg border border-red-200 shadow-sm flex items-center">
                    <div class="mr-3">
                        <span class="block text-[10px] uppercase text-red-800 font-bold tracking-wider">Active Bot Threats</span>
                        <span id="bot-threats-count" class="text-lg font-bold text-red-600">Loading...</span>
                    </div>
                    <svg class="w-8 h-8 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 xl:grid-cols-4 gap-6">
            
            <div class="xl:col-span-1 space-y-6">
                
                <div class="bg-[rgb(var(--bg-card))] p-5 rounded-lg shadow-sm border border-[rgb(var(--border-color))] transition-colors duration-300">
                    <h3 class="text-md font-semibold text-[rgb(var(--text-main))] mb-3 flex items-center">
                        <svg class="w-4 h-4 mr-2 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        Geo-Velocity Alerts
                    </h3>
                    <p class="text-xs text-[rgb(var(--text-muted))] mb-4">Logins from distant locations in impossible timeframes.</p>
                    
                    <div id="geo-alerts-container" class="space-y-3">
                        <div class="text-xs text-gray-500 text-center py-2">Loading alerts...</div>
                    </div>
                </div>

                <div class="bg-[rgb(var(--bg-card))] p-5 rounded-lg shadow-sm border border-[rgb(var(--border-color))] transition-colors duration-300">
                    <h3 class="text-md font-semibold text-[rgb(var(--text-main))] mb-3">IP Reputation Check</h3>
                    <div class="space-y-2 text-sm">
                        <div class="flex justify-between items-center p-2 bg-[rgb(var(--item-active-bg))] rounded">
                            <span class="text-[rgb(var(--text-muted))]">Known VPN/Proxies</span>
                            <span id="vpn-proxy-count" class="font-bold text-red-600">--</span>
                        </div>
                        <div class="flex justify-between items-center p-2 bg-[rgb(var(--item-active-bg))] rounded">
                            <span class="text-[rgb(var(--text-muted))]">TOR Exit Nodes</span>
                            <span id="tor-node-count" class="font-bold text-[rgb(var(--text-main))]">--</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="xl:col-span-3">
                <div class="bg-[rgb(var(--bg-card))] rounded-lg shadow-sm border border-[rgb(var(--border-color))] overflow-hidden transition-colors duration-300">
                    <div class="px-6 py-4 border-b border-[rgb(var(--border-color))] bg-[rgb(var(--item-active-bg))] flex justify-between items-center">
                        <div>
                            <h3 class="text-lg font-semibold text-[rgb(var(--text-main))]">Live Suspicious Sessions</h3>
                            <p class="text-xs text-[rgb(var(--text-muted))]">Real-time monitoring of device fingerprints and session anomalies.</p>
                        </div>
                        <button onclick="purgeBots()" class="bg-[rgb(var(--bg-card))] border border-[rgb(var(--border-color))] text-[rgb(var(--text-main))] px-3 py-1.5 rounded text-xs font-semibold hover:bg-[rgb(var(--item-active-bg))] transition-colors">
                            Purge All Bot Sessions
                        </button>
                    </div>
                    
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-[rgb(var(--border-color))]">
                            <thead class="bg-[rgb(var(--bg-card))]">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-[rgb(var(--text-muted))] uppercase tracking-wider">Entity & Session</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-[rgb(var(--text-muted))] uppercase tracking-wider">Device Fingerprint</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-[rgb(var(--text-muted))] uppercase tracking-wider">Risk Indicators</th>
                                    <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-[rgb(var(--text-muted))] uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody id="live-sessions-tbody" class="bg-[rgb(var(--bg-card))] divide-y divide-[rgb(var(--border-color))]">
                                <tr>
                                    <td colspan="4" class="px-6 py-8 text-center text-sm text-[rgb(var(--text-muted))]">Loading live sessions...</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        
        // Define API Base URL (adjust prefixes as needed for your routes)
        const apiBase = "{{ url('/api') }}"; 

        // Add authentication headers (assuming Laravel Sanctum or default API token setup)
        const getHeaders = () => ({
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'Authorization': 'Bearer ' + localStorage.getItem('token')
        });

        // 1. Fetch Dashboard & IP Blocks Stats
        async function fetchDashboardStats() {
            try {
                // Fetch IP Blocks for Reputation Check
                const ipRes = await fetch(`${apiBase}/session-risk/ip-blocks`, { headers: getHeaders() });
                const ipData = await ipRes.json();
                
                if (ipData.success && ipData.data) {
                    const blocks = ipData.data.data || [];
                    const vpnCount = blocks.filter(b => b.type === 'vpn' || b.type === 'proxy').length;
                    const torCount = blocks.filter(b => b.type === 'tor').length;
                    const botCount = blocks.filter(b => b.type === 'bot').length;
                    
                    document.getElementById('vpn-proxy-count').textContent = `${vpnCount} Blocks`;
                    document.getElementById('tor-node-count').textContent = `${torCount} Detected`;
                    document.getElementById('bot-threats-count').textContent = `${botCount} IP Blocks`;
                }
            } catch (error) {
                console.error("Error fetching dashboard stats:", error);
            }
        }

        // 2. Fetch Geo Velocity Alerts
        async function fetchGeoAlerts() {
            try {
                const res = await fetch(`${apiBase}/session-risk/geo-velocity-alerts?status=open`, { headers: getHeaders() });
                const json = await res.json();
                const container = document.getElementById('geo-alerts-container');
                
                if (json.success && json.data.data.length > 0) {
                    container.innerHTML = json.data.data.map(alert => `
                        <div class="p-3 bg-[rgb(var(--item-active-bg))] rounded border border-orange-200">
                            <div class="flex justify-between items-center mb-1">
                                <span class="text-xs font-bold text-[rgb(var(--text-main))]">${alert.user ? alert.user.name : 'Unknown'}</span>
                                <span class="text-[10px] text-orange-600 font-bold bg-orange-100 px-1 rounded">${alert.risk_level.toUpperCase()}</span>
                            </div>
                            <div class="flex items-center justify-between text-xs text-[rgb(var(--text-muted))] mt-2">
                                <div class="text-center font-bold">${alert.origin_country || 'N/A'}</div>
                                <div class="flex-1 px-2 text-center relative">
                                    <div class="border-t-2 border-dashed border-gray-300 w-full absolute top-1/2 left-0"></div>
                                    <span class="bg-[rgb(var(--item-active-bg))] relative px-1 text-[10px] text-red-500 font-bold">${alert.time_delta_mins} mins</span>
                                </div>
                                <div class="text-center font-bold">${alert.destination_country || 'N/A'}</div>
                            </div>
                            <div class="mt-3 flex gap-2">
                                <button onclick="handleGeoAction(${alert.id}, 'dismiss')" class="flex-1 bg-gray-200 text-gray-700 text-[10px] py-1 rounded hover:bg-gray-300 transition">Dismiss</button>
                                <button onclick="handleGeoAction(${alert.id}, 'review')" class="flex-1 bg-orange-100 text-orange-700 border border-orange-300 text-[10px] py-1 rounded hover:bg-orange-200 transition">Review</button>
                            </div>
                        </div>
                    `).join('');
                } else {
                    container.innerHTML = `<div class="text-xs text-gray-500 py-2">No active alerts.</div>`;
                }
            } catch (error) {
                console.error("Error fetching geo alerts:", error);
            }
        }

        // 3. Fetch Live Sessions
        async function fetchLiveSessions() {
            try {
                const res = await fetch(`${apiBase}/session-risk/sessions?risk_level=all`, { headers: getHeaders() });
                const json = await res.json();
                const tbody = document.getElementById('live-sessions-tbody');
                
                if (json.success && json.data.data.length > 0) {
                    tbody.innerHTML = json.data.data.map(session => {
                        const isHighRisk = session.risk_score >= 70;
                        const rowClass = isHighRisk ? 'bg-red-50/10 hover:bg-[rgb(var(--item-active-bg))]' : 'hover:bg-[rgb(var(--item-active-bg))]';
                        
                        return `
                        <tr class="${rowClass} transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-bold text-[rgb(var(--text-main))]">${session.user_name || 'Unauthenticated'}</div>
                                <div class="text-[10px] text-[rgb(var(--text-muted))] mt-1">IP: ${session.ip_address} (${session.country || 'Unknown'})</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center text-sm text-[rgb(var(--text-main))]">
                                    ${session.device || 'Unknown Device'}
                                </div>
                                ${isHighRisk ? `<div class="text-[10px] text-red-500 font-bold mt-1">HIGH RISK (${session.risk_score})</div>` : `<div class="text-[10px] text-[rgb(var(--text-muted))] mt-1">Score: ${session.risk_score}</div>`}
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex flex-wrap gap-1">
                                    ${isHighRisk ? `<span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-medium bg-red-100 text-red-800 border border-red-200">Suspicious Activity</span>` : `<span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-medium bg-gray-100 text-gray-800 border border-gray-200">Standard</span>`}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right space-x-1">
                                <button onclick="sessionAction(${session.id}, 'lock')" class="px-2 py-1 bg-red-600 text-white rounded text-xs font-bold shadow-sm hover:bg-red-700">Lock</button>
                                <button onclick="sessionAction(${session.id}, 'stepup-auth')" class="px-2 py-1 bg-blue-100 text-blue-800 border border-blue-200 rounded text-xs font-bold hover:bg-blue-200">2FA</button>
                                <button onclick="sessionAction(${session.id}, 'notify')" class="px-2 py-1 bg-gray-800 text-white rounded text-xs font-bold shadow-sm hover:bg-gray-900">Notify</button>
                            </td>
                        </tr>
                        `;
                    }).join('');
                } else {
                    tbody.innerHTML = `<tr><td colspan="4" class="px-6 py-8 text-center text-sm text-[rgb(var(--text-muted))]">No active sessions found.</td></tr>`;
                }
            } catch (error) {
                console.error("Error fetching sessions:", error);
            }
        }

        // --- Action Handlers ---

        window.purgeBots = async function() {
            if(!confirm("Are you sure you want to terminate all high-risk bot sessions?")) return;
            try {
                const res = await fetch(`${apiBase}/session-risk/purge-bots`, { 
                    method: 'DELETE', 
                    headers: getHeaders() 
                });
                const data = await res.json();
                if(data.success) {
                    alert(data.message);
                    fetchLiveSessions(); // Refresh table
                }
            } catch (error) {
                alert("Error purging bots.");
            }
        };

        window.sessionAction = async function(sessionId, action) {
            try {
                const res = await fetch(`${apiBase}/session-risk/sessions/${sessionId}/${action}`, { 
                    method: 'POST', 
                    headers: getHeaders(),
                    
                });
                const data = await res.json();
                if(data.success) {
                    // Optional: Show toast notification
                    console.log(`Action ${action} successful on session ${sessionId}`);
                    fetchLiveSessions(); 
                }
            } catch (error) {
                console.error(`Error performing ${action}:`, error);
            }
        };

        window.handleGeoAction = async function(alertId, action) {
            try {
                // Action is either 'dismiss' or 'review' -> PATCH request
                const res = await fetch(`${apiBase}/session-risk/geo-velocity-alerts/${alertId}/${action}`, { 
                    method: 'PATCH', 
                    headers: getHeaders() 
                });
                const data = await res.json();
                if(data.success) {
                    fetchGeoAlerts(); // Refresh alerts list
                }
            } catch (error) {
                console.error(`Error on geo alert ${action}:`, error);
            }
        };

        // Initialize App Data
        fetchDashboardStats();
        fetchGeoAlerts();
        fetchLiveSessions();

        // Set interval to poll for live sessions every 30 seconds
        setInterval(fetchLiveSessions, 30000);
    });
</script>
@endpush
@endsection