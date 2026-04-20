@extends('layouts.app')

@section('content')

<div class="min-h-screen bg-[rgb(var(--bg-body))] font-sans transition-colors duration-300">
    <div class="container mx-auto px-4 py-8">

        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 border-b border-[rgb(var(--border-color))] pb-4">
            <div>
                <h1 class="text-3xl font-bold text-[rgb(var(--text-main))] transition-colors">Payment & Wallet Abuse Detection</h1>
                <p class="text-sm text-[rgb(var(--text-muted))] mt-1 transition-colors">Protect wallet balances, payouts, COD handling, and PSP relationships</p>
            </div>
            
            <div class="mt-4 md:mt-0 flex space-x-4">
                <div class="bg-red-50 p-3 rounded-lg border border-red-200 shadow-sm flex items-center">
                    <div class="mr-3 text-right">
                        <span class="block text-[10px] uppercase text-red-800 font-bold tracking-wider">Blocked Volume (24h)</span>
                        <span id="blocked-volume" class="text-lg font-bold text-red-600">Loading...</span>
                    </div>
                    <div class="w-10 h-10 rounded-full bg-red-100 flex items-center justify-center text-red-500">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                    </div>
                </div>
                <div class="bg-yellow-50 p-3 rounded-lg border border-yellow-200 shadow-sm flex items-center">
                    <div class="mr-3 text-right">
                        <span class="block text-[10px] uppercase text-yellow-800 font-bold tracking-wider">Frozen Wallets</span>
                        <span id="frozen-wallets-count" class="text-lg font-bold text-yellow-700">--</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 xl:grid-cols-4 gap-6">
            
            <div class="xl:col-span-1 space-y-6">
                
                <div class="bg-[rgb(var(--bg-card))] p-5 rounded-lg shadow-sm border border-[rgb(var(--border-color))] transition-colors duration-300">
                    <h3 class="text-md font-semibold text-[rgb(var(--text-main))] mb-4">Active Threat Patterns</h3>
                    
                    <div id="threat-patterns-container" class="space-y-4">
                        <div class="text-xs text-gray-500 text-center py-2">Loading patterns...</div>
                    </div>
                </div>

                <div class="bg-[rgb(var(--bg-card))] p-5 rounded-lg shadow-sm border border-[rgb(var(--border-color))] transition-colors duration-300">
                    <h3 class="text-md font-semibold text-[rgb(var(--text-main))] mb-3">Velocity Limits</h3>
                    <div id="velocity-limits-container" class="space-y-3">
                         <div class="text-xs text-gray-500 text-center py-2">Loading limits...</div>
                    </div>
                </div>
            </div>

            <div class="xl:col-span-3">
                <div class="bg-[rgb(var(--bg-card))] rounded-lg shadow-sm border border-[rgb(var(--border-color))] overflow-hidden transition-colors duration-300">
                    <div class="px-6 py-4 border-b border-[rgb(var(--border-color))] bg-[rgb(var(--item-active-bg))] flex justify-between items-center">
                        <div>
                            <h3 class="text-lg font-semibold text-[rgb(var(--text-main))]">Transaction Risk Scan Feed</h3>
                            <p class="text-xs text-[rgb(var(--text-muted))]">Monitoring live transactions, top-ups, and COD settlements.</p>
                        </div>
                        <button onclick="exportAbuseLogs()" class="bg-[rgb(var(--bg-card))] border border-[rgb(var(--border-color))] text-[rgb(var(--text-main))] px-3 py-1.5 rounded text-xs font-semibold hover:bg-[rgb(var(--item-active-bg))] transition-colors flex items-center">
                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                            Export Abuse Logs
                        </button>
                    </div>
                    
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-[rgb(var(--border-color))]">
                            <thead class="bg-[rgb(var(--bg-card))]">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-[rgb(var(--text-muted))] uppercase tracking-wider">Transaction / Entity</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-[rgb(var(--text-muted))] uppercase tracking-wider">Abuse Pattern Detected</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-[rgb(var(--text-muted))] uppercase tracking-wider">Confidence</th>
                                    <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-[rgb(var(--text-muted))] uppercase tracking-wider">Enforcement Actions</th>
                                </tr>
                            </thead>
                            <tbody id="transactions-tbody" class="bg-[rgb(var(--bg-card))] divide-y divide-[rgb(var(--border-color))]">
                                <tr>
                                    <td colspan="4" class="px-6 py-8 text-center text-sm text-[rgb(var(--text-muted))]">Loading transactions...</td>
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
        
        const apiBase = "{{ url('/api') }}"; 

        const getHeaders = () => {
            const token = localStorage.getItem('token'); 
            return {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                ...(token ? { 'Authorization': `Bearer ${token}` } : {}) 
            };
        };

        // 1. Fetch Dashboard Stats
        async function fetchDashboardStats() {
            try {
                const res = await fetch(`${apiBase}/payment-abuse/dashboard`, { headers: getHeaders() });
                const json = await res.json();
                if (json.success && json.data) {
                    // Adjust keys based on your actual API response structure
                    document.getElementById('blocked-volume').textContent = json.data.blocked_volume || 'Rs. 0';
                    document.getElementById('frozen-wallets-count').textContent = `${json.data.frozen_wallets || 0} Active`;
                }
            } catch (error) {
                console.error("Error fetching dashboard:", error);
            }
        }

        // 2. Fetch Threat Patterns
        async function fetchThreatPatterns() {
            try {
                const res = await fetch(`${apiBase}/payment-abuse/threat-patterns`, { headers: getHeaders() });
                const json = await res.json();
                const container = document.getElementById('threat-patterns-container');
                
                if (json.success && json.data.length > 0) {
                    container.innerHTML = json.data.map(pattern => {
                        // Map severity to colors
                        let colorStr = pattern.severity === 'critical' ? 'red' : (pattern.severity === 'high' ? 'orange' : 'yellow');
                        return `
                        <div class="border-l-2 border-${colorStr}-500 pl-3">
                            <div class="flex justify-between items-center">
                                <span class="text-xs font-bold text-[rgb(var(--text-main))]">${pattern.name}</span>
                                <span class="bg-${colorStr}-100 text-${colorStr}-700 px-1.5 py-0.5 rounded text-[10px] font-bold capitalize">${pattern.severity}</span>
                            </div>
                            <p class="text-[10px] text-[rgb(var(--text-muted))] mt-1">${pattern.description || 'Monitors for anomalous payment behavior.'}</p>
                            <div class="mt-2 text-[10px] font-semibold text-[rgb(var(--brand-primary))]">Auto-Action: ${pattern.auto_action_name || 'Review'}</div>
                        </div>
                        `;
                    }).join('');
                } else {
                    container.innerHTML = `<div class="text-xs text-gray-500">No active threat patterns.</div>`;
                }
            } catch (error) {
                console.error("Error fetching patterns:", error);
            }
        }

        // 3. Fetch Velocity Limits
        async function fetchVelocityLimits() {
            try {
                const res = await fetch(`${apiBase}/payment-abuse/velocity-limits`, { headers: getHeaders() });
                const json = await res.json();
                const container = document.getElementById('velocity-limits-container');
                
                if (json.success && json.data.length > 0) {
                    container.innerHTML = json.data.map(limit => {
                        // Assuming API returns a current_count and max_count. Defaulting progress width to 100% if current_count is unavailable.
                        let percentage = limit.current_count ? Math.min((limit.current_count / limit.max_count) * 100, 100) : 100;
                        return `
                        <div>
                            <div class="flex justify-between text-xs mb-1">
                                <span class="text-[rgb(var(--text-muted))]">${limit.name || 'Limit'}</span>
                                <span class="text-[rgb(var(--text-main))] font-bold">Max ${limit.max_count}</span>
                            </div>
                            <div class="w-full bg-[rgb(var(--item-active-bg))] rounded-full h-1.5">
                                <div class="bg-blue-500 h-1.5 rounded-full" style="width: ${percentage}%"></div>
                            </div>
                        </div>
                        `;
                    }).join('');
                } else {
                    container.innerHTML = `<div class="text-xs text-gray-500">No velocity limits configured.</div>`;
                }
            } catch (error) {
                console.error("Error fetching limits:", error);
            }
        }

        // 4. Fetch Transaction Feed
        async function fetchTransactions() {
            try {
                const res = await fetch(`${apiBase}/payment-abuse/transactions`, { headers: getHeaders() });
                const json = await res.json();
                const tbody = document.getElementById('transactions-tbody');
                
                if (json.success && json.data.data.length > 0) {
                    tbody.innerHTML = json.data.data.map(txn => {
                        const isCritical = txn.severity === 'critical';
                        const isHigh = txn.severity === 'high';
                        const rowClass = isCritical ? 'bg-red-50/10' : '';
                        
                        let barColor = isCritical ? 'bg-red-600' : (isHigh ? 'bg-orange-500' : 'bg-yellow-500');
                        let badgeColor = isCritical ? 'bg-red-100 text-red-600' : (isHigh ? 'bg-orange-100 text-orange-600' : 'bg-yellow-100 text-yellow-600');
                        
                        // Default Actions based on status
                        let actionButtons = '';
                        if(txn.status !== 'resolved' && txn.status !== 'false_positive') {
                            actionButtons = `
                                <div class="flex justify-end space-x-1 mt-2">
                                    <button onclick="takeAction(${txn.id}, 'freeze-wallet')" title="Freeze Wallet" class="text-[10px] bg-red-600 hover:bg-red-700 text-white px-2 py-1 rounded transition-colors">Freeze</button>
                                    <button onclick="takeAction(${txn.id}, 'delay-payout')" title="Delay Payout" class="text-[10px] bg-yellow-600 hover:bg-yellow-700 text-white px-2 py-1 rounded transition-colors">Delay</button>
                                    <button onclick="takeAction(${txn.id}, 'suspend-dispatch')" title="Suspend Dispatch" class="text-[10px] bg-orange-600 hover:bg-orange-700 text-white px-2 py-1 rounded transition-colors">Suspend</button>
                                </div>
                                <div class="flex justify-end space-x-1 mt-1">
                                    <button onclick="takeAction(${txn.id}, 'resolve')" class="text-[10px] bg-green-100 text-green-800 hover:bg-green-200 px-2 py-0.5 rounded transition-colors">Resolve</button>
                                    <button onclick="takeAction(${txn.id}, 'false-positive')" class="text-[10px] bg-gray-200 text-gray-800 hover:bg-gray-300 px-2 py-0.5 rounded transition-colors">False Positive</button>
                                </div>
                            `;
                        } else {
                            actionButtons = `<span class="px-2 py-1 bg-gray-100 text-gray-600 rounded text-xs font-bold uppercase">${txn.status.replace('_', ' ')}</span>`;
                        }

                        return `
                        <tr class="hover:bg-[rgb(var(--item-active-bg))] transition-colors ${rowClass}">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="mr-3 p-2 ${badgeColor} rounded">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    </div>
                                    <div>
                                        <div class="text-sm font-bold text-[rgb(var(--text-main))]">${txn.entity_ref || 'Unknown Entity'}</div>
                                        <div class="text-[10px] text-[rgb(var(--text-muted))] mt-1">${txn.transaction_type}: Rs. ${txn.amount || '0'}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm font-medium text-[rgb(var(--text-main))]">${txn.abuse_pattern || 'Anomaly Detected'}</div>
                                <div class="text-[10px] text-[rgb(var(--text-muted))] mt-1 line-clamp-2">${txn.notes || 'No notes available.'}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="w-full bg-gray-200 rounded-full h-1.5 mb-1 max-w-[80px]">
                                    <div class="${barColor} h-1.5 rounded-full" style="width: ${txn.confidence_score || 0}%"></div>
                                </div>
                                <span class="text-[10px] font-bold text-[rgb(var(--text-main))]">${txn.confidence_score || 0}% Match</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right">
                                <span class="px-2 py-1 bg-gray-100 text-gray-800 border border-gray-200 rounded text-xs font-bold inline-block mb-1 capitalize">
                                    ${txn.auto_action ? txn.auto_action.replace('_', ' ') : 'No Auto Action'}
                                </span>
                                ${actionButtons}
                            </td>
                        </tr>
                        `;
                    }).join('');
                } else {
                    tbody.innerHTML = `<tr><td colspan="4" class="px-6 py-8 text-center text-sm text-[rgb(var(--text-muted))]">No active transactions detected.</td></tr>`;
                }
            } catch (error) {
                console.error("Error fetching transactions:", error);
            }
        }

        // --- Action Handlers ---

        window.takeAction = async function(id, actionRoute) {
            if(!confirm(`Are you sure you want to trigger: ${actionRoute.replace('-', ' ')}?`)) return;
            
            try {
                const res = await fetch(`${apiBase}/payment-abuse/transactions/${id}/${actionRoute}`, { 
                    method: 'POST', 
                    headers: getHeaders() 
                });
                const data = await res.json();
                
                if(data.success) {
                    fetchTransactions(); // Refresh table immediately 
                    fetchDashboardStats(); // Numbers might have changed
                } else {
                    alert(data.message || 'Action failed.');
                }
            } catch (error) {
                console.error(`Error executing ${actionRoute}:`, error);
                alert('An error occurred while processing your request.');
            }
        };

        window.exportAbuseLogs = async function() {
            try {
                // Fetch blob to pass authorization headers natively
                const res = await fetch(`${apiBase}/payment-abuse/export`, {
                    method: 'GET',
                    headers: getHeaders()
                });
                
                if (!res.ok) throw new Error("Export failed");
                
                const blob = await res.blob();
                const url = window.URL.createObjectURL(blob);
                const a = document.createElement('a');
                a.style.display = 'none';
                a.href = url;
                
                // Set default filename, can be overridden by content-disposition if desired
                const date = new Date().toISOString().split('T')[0];
                a.download = `payment_abuse_log_${date}.csv`;
                
                document.body.appendChild(a);
                a.click();
                
                // Cleanup
                window.URL.revokeObjectURL(url);
                document.body.removeChild(a);

            } catch (error) {
                console.error("Error exporting logs:", error);
                alert("Could not export logs at this time.");
            }
        };

        // Initialize App Data
        fetchDashboardStats();
        fetchThreatPatterns();
        fetchVelocityLimits();
        fetchTransactions();

        // Optional: Set interval to poll for live transactions every 30 seconds
        setInterval(fetchTransactions, 30000);
    });
</script>
@endpush
@endsection