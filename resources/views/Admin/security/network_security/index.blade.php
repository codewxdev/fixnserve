@extends('layouts.app')

@section('title', 'Network Security')

@section('content')
    <div class="min-h-screen theme-bg-body theme-text-main max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
            <div>
                <h1 class="text-2xl font-bold theme-text-main">Network Defense Layer</h1>
                <p class="theme-text-muted mt-1">Configure IP firewalls, geo-blocking, and impossible travel detection.</p>
            </div>
            
            <button onclick="togglePanicMode()" 
                class="flex items-center gap-2 px-4 py-2 rounded-lg text-sm font-bold transition-colors border shadow-sm"
                style="background-color: rgba(225, 29, 72, 0.1); color: rgb(225, 29, 72); border-color: rgba(225, 29, 72, 0.2);">
                <i data-lucide="siren" class="w-4 h-4"></i> 
                <span>Block All Non-Domestic Traffic</span>
            </button>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <div class="lg:col-span-2 space-y-6">
                
                {{-- IP ACCESS RULES --}}
                <div class="theme-bg-card rounded-xl shadow-sm border theme-border overflow-hidden">
                    <div class="px-6 py-4 border-b theme-border flex justify-between items-center" style="background-color: rgba(var(--bg-body), 0.5);">
                        <h3 class="font-semibold theme-text-main flex items-center gap-2">
                            <i data-lucide="network" class="w-4 h-4" style="color: rgb(var(--brand-primary));"></i> IP Access Rules
                        </h3>
                        <button onclick="openIpModal()" 
                            class="text-xs font-bold text-white px-3 py-1.5 rounded hover:opacity-90 transition"
                            style="background-color: rgb(var(--brand-primary));">
                            + ADD RULE
                        </button>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-sm theme-text-muted">
                            <thead class="theme-text-main font-semibold uppercase text-xs" style="background-color: rgba(var(--bg-body), 0.5);">
                                <tr>
                                    <th class="px-6 py-3">IP / CIDR</th>
                                    <th class="px-6 py-3">Type</th>
                                    <th class="px-6 py-3">Applies To</th>
                                    <th class="px-6 py-3">Comment</th>
                                    <th class="px-6 py-3 text-right">Action</th>
                                </tr>
                            </thead>
                            <tbody id="ip-rules-tbody" class="divide-y theme-border" style="border-color: rgb(var(--border-color));">
                                <tr><td colspan="5" class="px-6 py-4 text-center">Loading rules...</td></tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- AI DETECTION (Static for now as no API provided for this) --}}
                {{-- <div class="theme-bg-card rounded-xl shadow-sm border theme-border p-6">
                    <h3 class="font-semibold theme-text-main mb-4 flex items-center gap-2">
                        <i data-lucide="zap" class="w-4 h-4 text-amber-500"></i> AI Detection: Impossible Travel
                    </h3>
                    
                    <div class="space-y-4">
                        <div class="flex items-start gap-4 p-3 rounded-lg border theme-border" style="background-color: rgba(245, 158, 11, 0.05); border-color: rgba(245, 158, 11, 0.2);">
                            <div class="mt-1">
                                <i data-lucide="alert-triangle" class="w-5 h-5 text-amber-500"></i>
                            </div>
                            <div class="flex-1">
                                <p class="text-sm font-bold theme-text-main">Anomaly Detected: User #41 (Sarah)</p>
                                <p class="text-xs theme-text-muted mt-1">
                                    Login from <span class="font-bold theme-text-main">London, UK</span> at 10:00 AM.<br>
                                    Login from <span class="font-bold theme-text-main">New York, USA</span> at 10:15 AM.<br>
                                    <span class="italic text-amber-500">Distance: 5,500km in 15 mins (Impossible Speed)</span>
                                </p>
                            </div>
                            <button class="text-xs font-bold theme-bg-card border theme-border text-amber-500 px-3 py-1 rounded shadow-sm hover:bg-white/5 transition">
                                FREEZE ACCOUNT
                            </button>
                        </div>
                    </div>
                </div> --}}

            </div>

            <div class="space-y-6">
                
                {{-- GEO BLOCKING --}}
                <div class="theme-bg-card rounded-xl shadow-sm border theme-border overflow-hidden">
                    <div class="px-6 py-4 border-b theme-border" style="background-color: rgba(var(--bg-body), 0.5);">
                        <h3 class="font-semibold theme-text-main flex items-center gap-2">
                            <i data-lucide="globe" class="w-4 h-4" style="color: rgb(var(--brand-primary));"></i> Geo-Blocking
                        </h3>
                    </div>
                    
                    <div class="p-4 border-b theme-border">
                        <div class="relative">
                            <i data-lucide="search" class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 theme-text-muted"></i>
                            <input type="text" placeholder="Search Country..." 
                                class="pl-10 w-full theme-bg-body border theme-border rounded-lg text-sm theme-text-main focus:ring-2 focus:ring-blue-500 placeholder-gray-500">
                        </div>
                    </div>

                    <div id="geo-rules-list" class="max-h-[400px] overflow-y-auto p-2 space-y-1 custom-scrollbar">
                        <p class="text-center text-sm py-4">Loading geo rules...</p>
                    </div>
                    
                    <div class="p-4 border-t theme-border text-center" style="background-color: rgba(var(--bg-body), 0.5);">
                        <p class="text-xs theme-text-muted mb-2">Default Global Policy</p>
                        <div class="inline-flex theme-bg-body rounded-lg border theme-border p-1">
                            <button onclick="updateDefaultPolicy('allow_all')" id="btn-allow-all" class="px-3 py-1 text-xs font-bold rounded shadow-sm transition theme-text-muted">ALLOW ALL</button>
                            <button onclick="updateDefaultPolicy('deny_all')" id="btn-deny-all" class="px-3 py-1 text-xs font-bold rounded shadow-sm transition theme-text-muted">DENY ALL</button>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    {{-- ADD RULE MODAL --}}
    <div id="ip-modal" class="hidden fixed inset-0 bg-black/80 backdrop-blur-sm z-50 flex items-center justify-center p-4">
        <div class="theme-bg-card rounded-xl shadow-2xl max-w-md w-full p-6 border theme-border">
            <h3 class="text-lg font-bold theme-text-main mb-4">Add IP Access Rule</h3>
            
            <form id="ip-rule-form" onsubmit="submitIpRule(event)">
                <div class="space-y-4">
                    
                    <div>
                        <label class="block text-sm font-medium theme-text-muted mb-1">IP Address or CIDR</label>
                        <input type="text" id="ip_cidr" required placeholder="e.g. 192.168.1.5 or 10.0.0.0/24" 
                            class="w-full theme-bg-body border theme-border rounded-lg theme-text-main focus:ring-2 focus:ring-blue-500 p-2.5">
                    </div>

                    <div>
                        <label class="block text-sm font-medium theme-text-muted mb-1">Rule Type</label>
                        <div class="flex gap-4">
                            <label class="flex items-center gap-2">
                                <input type="radio" name="rule_type" value="allow" class="text-green-500 focus:ring-green-500" checked>
                                <span class="text-sm theme-text-main">Allow (Whitelist)</span>
                            </label>
                            <label class="flex items-center gap-2">
                                <input type="radio" name="rule_type" value="deny" class="text-red-500 focus:ring-red-500">
                                <span class="text-sm theme-text-main">Block (Blacklist)</span>
                            </label>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium theme-text-muted mb-1">Applies To</label>
                        <select id="ip_applies_to" class="w-full theme-bg-body border theme-border rounded-lg theme-text-main focus:ring-2 focus:ring-blue-500 p-2.5">
                            <option value="all">Global (Everyone)</option>
                            <option value="admin">Admins Only</option>
                            <option value="api">API Clients Only</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium theme-text-muted mb-1">Comment / Reason</label>
                        <input type="text" id="ip_comment" placeholder="e.g. Finance Team Office IP" 
                            class="w-full theme-bg-body border theme-border rounded-lg theme-text-main focus:ring-2 focus:ring-blue-500 p-2.5">
                    </div>

                </div>

                <div class="mt-6 flex justify-end gap-3">
                    <button type="button" onclick="closeIpModal()" 
                        class="px-4 py-2 theme-text-muted hover:bg-white/5 rounded-lg transition">Cancel</button>
                    <button type="submit" 
                        class="px-4 py-2 text-white rounded-lg font-medium shadow-sm transition hover:opacity-90"
                        style="background-color: rgb(var(--brand-primary));">Save Rule</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://unpkg.com/lucide@latest"></script>
    <script>
        // API Base URL aur Token setup
        const BASE_URL = 'http://127.0.0.1:8000/api/admin/security/network';
        const getHeaders = () => {
            return {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'Authorization': `Bearer ${localStorage.getItem('token')}`,
                'X-Device-Fingerprint': localStorage.getItem('device_fingerprint') || 'unknown'
            };
        };
    
        document.addEventListener("DOMContentLoaded", () => {
            lucide.createIcons();
            fetchIpRules();
            fetchGeoRules();
        });

        // --- IP RULES LOGIC ---
        
        async function fetchIpRules() {
            try {
                const response = await fetch(`${BASE_URL}/ip-rules`, { headers: getHeaders() });
                const rules = await response.json();
                
                const tbody = document.getElementById('ip-rules-tbody');
                tbody.innerHTML = ''; // clear table
                
                if (rules.length === 0) {
                    tbody.innerHTML = '<tr><td colspan="5" class="px-6 py-4 text-center">No rules found.</td></tr>';
                    return;
                }

                rules.forEach(rule => {
                    const typeBadge = rule.type === 'allow' 
                        ? `<span class="inline-flex items-center gap-1 px-2 py-0.5 rounded text-xs font-bold bg-green-500/10 text-green-500 border border-green-500/20">ALLOW</span>`
                        : `<span class="inline-flex items-center gap-1 px-2 py-0.5 rounded text-xs font-bold bg-red-500/10 text-red-500 border border-red-500/20">DENY</span>`;
                    
                    const rowClass = rule.type === 'deny' ? `style="background-color: rgba(239, 68, 68, 0.05);"` : '';

                    tbody.innerHTML += `
                        <tr class="hover:bg-white/5 transition-colors" ${rowClass}>
                            <td class="px-6 py-3 font-mono theme-text-main">${rule.cidr}</td>
                            <td class="px-6 py-3">${typeBadge}</td>
                            <td class="px-6 py-3">
                                <span class="px-2 py-0.5 rounded theme-bg-body theme-text-muted text-xs border theme-border">${rule.applies_to || 'all'}</span>
                            </td>
                            <td class="px-6 py-3 theme-text-muted text-xs">${rule.comment || '-'}</td>
                            <td class="px-6 py-3 text-right">
                                <button onclick="deleteIpRule(${rule.id})" class="theme-text-muted hover:text-red-500"><i data-lucide="trash-2" class="w-4 h-4"></i></button>
                            </td>
                        </tr>
                    `;
                });
                lucide.createIcons(); // re-init icons for dynamic content
            } catch (error) {
                console.error("Error fetching IP rules:", error);
            }
        }

        async function submitIpRule(event) {
            event.preventDefault();
            
            const payload = {
                cidr: document.getElementById('ip_cidr').value,
                type: document.querySelector('input[name="rule_type"]:checked').value,
                applies_to: document.getElementById('ip_applies_to').value,
                comment: document.getElementById('ip_comment').value,
            };

            try {
                const response = await fetch(`${BASE_URL}/ip-rules`, {
                    method: 'POST',
                    headers: getHeaders(),
                    body: JSON.stringify(payload)
                });

                if (response.ok) {
                    closeIpModal();
                    document.getElementById('ip-rule-form').reset();
                    fetchIpRules(); // Refresh list
                } else {
                    alert("Error saving rule.");
                }
            } catch (error) {
                console.error("Error submitting IP rule:", error);
            }
        }

        async function deleteIpRule(id) {
            if(!confirm("Are you sure you want to delete this rule?")) return;

            try {
                const response = await fetch(`${BASE_URL}/ip-rules/${id}`, {
                    method: 'DELETE',
                    headers: getHeaders()
                });

                if(response.ok) fetchIpRules(); // Refresh list
            } catch(error) {
                console.error("Error deleting rule:", error);
            }
        }


        // --- GEO RULES LOGIC ---

        function getFlagEmoji(countryCode) {
            if(!countryCode || countryCode === '*') return '🌍';
            const codePoints = countryCode.toUpperCase().split('').map(char =>  127397 + char.charCodeAt());
            return String.fromCodePoint(...codePoints);
        }

        async function fetchGeoRules() {
            try {
                const response = await fetch(`${BASE_URL}/geo-rules`, { headers: getHeaders() });
                const rules = await response.json();
                
                const listContainer = document.getElementById('geo-rules-list');
                listContainer.innerHTML = ''; 

                let defaultRule = rules.find(r => r.is_default);
                updateDefaultUI(defaultRule ? defaultRule.status : 'allowed');

                rules.filter(r => r.country_code !== '*').forEach(rule => {
                    const isAllowed = rule.status === 'allowed';
                    
                    // Design based on status
                    const bgStyle = isAllowed ? '' : `style="background-color: rgba(239, 68, 68, 0.05); border-color: rgba(239, 68, 68, 0.2);"`;
                    const borderClass = isAllowed ? '' : 'border theme-border';
                    const buttonAction = isAllowed ? 'blocked' : 'allowed';
                    const buttonHtml = isAllowed 
                        ? `<button onclick="updateCountryStatus('${rule.country_code}', '${buttonAction}')" class="text-[10px] text-red-500 theme-bg-card border theme-border px-2 py-0.5 rounded font-bold hover:bg-white/10 transition">BLOCK</button>`
                        : `<button onclick="updateCountryStatus('${rule.country_code}', '${buttonAction}')" class="text-[10px] text-green-500 theme-bg-card border theme-border px-2 py-0.5 rounded font-bold hover:bg-white/10 transition">UNBLOCK</button>`;
                    
                    const badgeHtml = isAllowed 
                        ? `<span class="text-[10px] text-green-500 bg-green-500/10 px-1.5 py-0.5 rounded font-bold border border-green-500/20">ALLOWED</span>`
                        : `<span class="text-[10px] text-red-500 bg-red-500/10 px-1.5 py-0.5 rounded font-bold border border-red-500/20">BLOCKED</span>`;

                    listContainer.innerHTML += `
                        <div class="flex items-center justify-between p-2 hover:bg-white/5 rounded-lg group transition-colors ${borderClass}" ${bgStyle}>
                            <div class="flex items-center gap-3">
                                <span class="text-xl">${getFlagEmoji(rule.country_code)}</span>
                                <span class="text-sm font-medium theme-text-main">${rule.country_code}</span>
                            </div>
                            <div class="flex items-center gap-2">
                                ${badgeHtml}
                                ${buttonHtml}
                            </div>
                        </div>
                    `;
                });

            } catch(error) {
                console.error("Error fetching geo rules:", error);
            }
        }

        async function updateCountryStatus(countryCode, status) {
            try {
                const response = await fetch(`${BASE_URL}/geo-rules/country`, {
                    method: 'POST',
                    headers: getHeaders(),
                    body: JSON.stringify({ country_code: countryCode, status: status })
                });

                if(response.ok) fetchGeoRules();
            } catch(error) {
                console.error("Error updating country:", error);
            }
        }

        async function updateDefaultPolicy(policy) {
            try {
                const response = await fetch(`${BASE_URL}/geo-rules/default-policy`, {
                    method: 'PATCH',
                    headers: getHeaders(),
                    body: JSON.stringify({ policy: policy })
                });

                if(response.ok) fetchGeoRules();
            } catch(error) {
                console.error("Error updating default policy:", error);
            }
        }

        function updateDefaultUI(status) {
            const btnAllow = document.getElementById('btn-allow-all');
            const btnDeny = document.getElementById('btn-deny-all');
            
            btnAllow.style = ""; btnDeny.style = "";
            btnAllow.className = "px-3 py-1 text-xs font-bold rounded shadow-sm transition theme-text-muted hover:theme-text-main";
            btnDeny.className = "px-3 py-1 text-xs font-bold rounded shadow-sm transition theme-text-muted hover:theme-text-main";

            if (status === 'allowed') {
                btnAllow.style.backgroundColor = "rgb(var(--status-success))";
                btnAllow.style.color = "white";
            } else {
                btnDeny.style.backgroundColor = "rgb(var(--status-danger, 225, 29, 72))";
                btnDeny.style.color = "white";
            }
        }

        // --- UTILS ---

        function openIpModal() {
            document.getElementById('ip-modal').classList.remove('hidden');
        }

        function closeIpModal() {
            document.getElementById('ip-modal').classList.add('hidden');
        }

        function togglePanicMode() {
            if(confirm("DANGER: This will immediately block all IP addresses outside your country. Are you sure?")) {
                // Panic mode acts as Deny All default policy
                updateDefaultPolicy('deny_all').then(() => {
                    alert("Panic Mode Activated. Foreign traffic dropped.");
                });
            }
        }
    </script>
@endpush