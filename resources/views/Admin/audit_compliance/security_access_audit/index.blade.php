@extends('layouts.app')

@section('title', 'Security & Access Audit')

@section('content')
    <div class="min-h-screen theme-bg-body theme-text-main max-w-[1400px] mx-auto px-4 sm:px-6 lg:px-8 py-8">

        {{-- HEADER --}}
        <div class="mb-8 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div>
                <h1 class="text-2xl font-bold flex items-center gap-3">
                    <i data-lucide="shield-check" class="w-7 h-7 theme-brand-text"></i>
                    Security & Access Audit
                </h1>
                <p class="theme-text-muted mt-1 text-sm">Real-time monitoring of authentication integrity and access
                    patterns.</p>
            </div>
            {{-- <div class="flex gap-3">
            <button class="px-4 py-2 bg-red-500/10 border border-red-500/20 text-red-400 rounded-lg text-sm font-medium hover:bg-red-500/20 transition-colors flex items-center gap-2">
                <i data-lucide="unplug" class="w-4 h-4"></i> Revoke All Global Sessions
            </button>
        </div> --}}
        </div>

        {{-- RISK ANALYTICS CARDS --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="theme-bg-card border theme-border p-5 rounded-xl flex items-center gap-4">
                <div class="w-12 h-12 rounded-full bg-red-500/20 flex items-center justify-center text-red-500 pulse-red">
                    <i data-lucide="alert-triangle"></i>
                </div>
                <div>
                    <p class="text-xs theme-text-muted uppercase font-bold">Failed Logins (24h)</p>
                    <p class="text-2xl font-bold">
                        <span id="stat-failed-count">...</span>
                        <span id="stat-failed-change" class="text-xs font-normal ml-1"></span>
                    </p>
                </div>
            </div>
            <div class="theme-bg-card border theme-border p-5 rounded-xl flex items-center gap-4">
                <div class="w-12 h-12 rounded-full bg-yellow-500/20 flex items-center justify-center text-yellow-500">
                    <i data-lucide="fingerprint"></i>
                </div>
                <div>
                    <p class="text-xs theme-text-muted uppercase font-bold">MFA Challenges</p>
                    <p class="text-2xl font-bold">
                        <span id="stat-mfa-count">...</span>
                        <span id="stat-mfa-rate" class="text-xs text-emerald-400 font-normal ml-1"></span>
                    </p>
                </div>
            </div>
            <div class="theme-bg-card border theme-border p-5 rounded-xl flex items-center gap-4">
                <div class="w-12 h-12 rounded-full bg-blue-500/20 flex items-center justify-center text-blue-500">
                    <i data-lucide="key"></i>
                </div>
                <div>
                    <p class="text-xs theme-text-muted uppercase font-bold">Token Rotations</p>
                    <p class="text-2xl font-bold" id="stat-token-count">...</p>
                </div>
            </div>
        </div>

        {{-- SECURITY EVENT FEED --}}
        <div class="theme-bg-card rounded-xl shadow-sm border theme-border overflow-hidden">
            <div class="p-4 border-b theme-border flex flex-col md:flex-row justify-between items-center bg-white/5">
                <h3 class="font-semibold text-sm uppercase tracking-widest flex items-center gap-2">
                    <i data-lucide="activity" class="w-4 h-4"></i> Access Integrity Feed
                </h3>
                <div class="flex gap-2">
                    <select
                        class="theme-bg-body border theme-border rounded-lg px-3 py-1.5 text-sm theme-text-main outline-none">
                        <option>All Risk Levels</option>
                        <option class="text-red-400">High Risk Only</option>
                        <option class="text-yellow-400">Medium Risk</option>
                    </select>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead class="theme-text-muted font-semibold text-xs uppercase"
                        style="background-color: rgba(var(--bg-body), 0.8);">
                        <tr>
                            <th class="px-6 py-4">Event Type</th>
                            <th class="px-6 py-4">Identity / Actor</th>
                            <th class="px-6 py-4">Geo-Location & IP</th>
                            <th class="px-6 py-4">Risk Level</th>
                            <th class="px-6 py-4">Status</th>
                            <th class="px-6 py-4 text-right">Action</th>
                        </tr>
                    </thead>
                    <tbody id="security-event-body" class="divide-y theme-border">
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script src="https://unpkg.com/lucide@latest"></script>
    <script>
        // Adjust these endpoints if your routes.php uses different paths
        const OVERVIEW_API = '/api/admin/security-audit/overview';
        const LOGS_API = '/api/admin/security-audit';

        document.addEventListener("DOMContentLoaded", () => {
            lucide.createIcons();
            fetchOverviewStats();
            fetchSecurityLogs();
        });

        // --- API Helper ---
        async function apiRequest(endpoint) {
            const token = localStorage.getItem('token');
            const fingerprint = localStorage.getItem('device_fingerprint') || 'unknown';

            try {
                const response = await fetch(endpoint, {
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'Authorization': `Bearer ${token}`,
                        'X-Device-Fingerprint': fingerprint
                    }
                });
                const result = await response.json();
                if (!response.ok) throw result;
                return result;
            } catch (error) {
                console.error('API Error:', error);
                return null;
            }
        }

        // --- 1. Fetch Overview Stats ---
        async function fetchOverviewStats() {
            const res = await apiRequest(OVERVIEW_API);

            // Ensure data exists before updating UI
            const data = res?.data || res;
            if (!data) return;

            // Failed Logins
            const failedCount = data.failed_logins_24h?.count || 0;
            const failedChange = data.failed_logins_24h?.percentage_change || 0;
            document.getElementById('stat-failed-count').innerText = failedCount;

            const changeEl = document.getElementById('stat-failed-change');
            if (failedChange > 0) {
                changeEl.innerHTML = `<span class="text-red-400">+${failedChange}% ↑</span>`;
            } else if (failedChange < 0) {
                changeEl.innerHTML = `<span class="text-emerald-400">${failedChange}% ↓</span>`;
            } else {
                changeEl.innerHTML = `<span class="text-gray-400">0%</span>`;
            }

            // MFA Challenges
            document.getElementById('stat-mfa-count').innerText = data.mfa_challenges_24h?.count || 0;
            document.getElementById('stat-mfa-rate').innerText =
                `${data.mfa_challenges_24h?.success_rate || 0}% Success`;

            // Token Rotations
            document.getElementById('stat-token-count').innerText = data.token_rotations_24h?.count || 0;
        }

        // --- 2. Fetch Security Events ---
        async function fetchSecurityLogs() {
            const tbody = document.getElementById('security-event-body');
            tbody.innerHTML =
                '<tr><td colspan="6" class="px-6 py-8 text-center text-sm theme-text-muted">Loading audit logs...</td></tr>';

            const res = await apiRequest(LOGS_API);
            const logs = res?.data || res || [];

            if (!Array.isArray(logs) || logs.length === 0) {
                tbody.innerHTML =
                    '<tr><td colspan="6" class="px-6 py-8 text-center text-sm theme-text-muted">No recent security events found.</td></tr>';
                return;
            }

            tbody.innerHTML = '';

            logs.forEach(log => {
                const {
                    riskLevel,
                    riskColor,
                    formattedEvent,
                    status,
                    statusColor
                } = parseAuditData(log.event_type);

                // Handle Dates
                const dateObj = new Date(log.occurred_at || log.created_at);
                const timeString = dateObj.toLocaleString([], {
                    month: 'short',
                    day: 'numeric',
                    hour: '2-digit',
                    minute: '2-digit'
                });

                // Actor details
                const actorName = log.user?.name || `User #${log.user_id || 'System'}`;
                const deviceDetails = log.user_agent ? log.user_agent.substring(0, 30) + '...' :
                    'Unknown Device';

                tbody.insertAdjacentHTML('beforeend', `
                <tr class="hover:bg-white/5 transition-colors">
                    <td class="px-6 py-4">
                        <div class="font-bold theme-text-main uppercase text-xs">${formattedEvent}</div>
                        <div class="text-[10px] theme-text-muted mt-1">${timeString}</div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="theme-text-main font-medium">${actorName}</div>
                        <div class="text-[10px] theme-text-muted font-mono" title="${log.user_agent || ''}">${deviceDetails}</div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-1.5 theme-text-main text-xs">
                            <i data-lucide="map-pin" class="w-3.5 h-3.5 text-blue-400"></i>
                            ${log.ip_address || '0.0.0.0'}
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <span class="px-2.5 py-1 rounded text-[10px] font-bold uppercase border bg-${riskColor}-500/10 text-${riskColor}-500 border-${riskColor}-500/20">
                            ${riskLevel}
                        </span>
                    </td>
                    <td class="px-6 py-4 font-medium text-xs text-${statusColor}-400">
                        ${status}
                    </td>
                    <td class="px-6 py-4 text-right">
                        <button class="p-2 theme-bg-body border theme-border rounded hover:bg-white/10 transition-all shadow-sm text-gray-400 hover:text-white" title="View Details">
                            <i data-lucide="info" class="w-4 h-4"></i>
                        </button>
                    </td>
                </tr>
            `);
            });
            lucide.createIcons();
        }

        // --- Helper: Determine UI styling based on Event Type ---
        function parseAuditData(eventType) {
            if (!eventType) return {
                riskLevel: 'Unknown',
                riskColor: 'gray',
                formattedEvent: 'Unknown Event',
                status: 'Logged',
                statusColor: 'gray'
            };

            const str = eventType.toLowerCase();

            // Format string (e.g. login_failed -> Login Failed)
            const formattedEvent = str.replace(/_/g, ' ');

            let riskLevel = 'Low';
            let riskColor = 'emerald'; // Tailwind green equivalent
            let status = 'Logged';
            let statusColor = 'gray';

            if (str.includes('fail') || str.includes('block') || str.includes('unauthorized')) {
                riskLevel = 'High';
                riskColor = 'red';
                status = 'Blocked';
                statusColor = 'red';
            } else if (str.includes('rotate') || str.includes('revoke') || str.includes('challenge')) {
                riskLevel = 'Medium';
                riskColor = 'yellow';
                status = 'Actioned';
                statusColor = 'yellow';
            } else if (str.includes('success') || str.includes('verified')) {
                riskLevel = 'Low';
                riskColor = 'emerald';
                status = 'Verified';
                statusColor = 'emerald';
            }

            return {
                riskLevel,
                riskColor,
                formattedEvent,
                status,
                statusColor
            };
        }
    </script>
@endpush
