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
                        <span class="text-lg font-bold text-red-600">12 IP Blocks</span>
                    </div>
                    <svg class="w-8 h-8 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                </div>
            </div>
        </div>

        <div class="mb-6">
            <nav class="flex space-x-4 border-b border-[rgb(var(--border-color))] overflow-x-auto pb-1">
                <a href="#" class="border-b-2 border-transparent text-[rgb(var(--text-muted))] hover:text-[rgb(var(--text-main))] py-3 px-4 font-medium text-sm transition-colors whitespace-nowrap">
                    13.1 Risk Scoring Engine
                </a>
                <a href="#" class="border-b-2 border-[rgb(var(--brand-primary))] text-[rgb(var(--brand-primary))] py-3 px-4 font-semibold text-sm transition-colors whitespace-nowrap">
                    13.2 Session Identity
                </a>
                <a href="#" class="border-b-2 border-transparent text-[rgb(var(--text-muted))] hover:text-[rgb(var(--text-main))] py-3 px-4 font-medium text-sm transition-colors whitespace-nowrap">
                    13.3 Payment Abuse
                </a>
                <a href="#" class="border-b-2 border-transparent text-[rgb(var(--text-muted))] hover:text-[rgb(var(--text-main))] py-3 px-4 font-medium text-sm transition-colors whitespace-nowrap">
                    13.4 Promo Abuse
                </a>
                <a href="#" class="border-b-2 border-transparent text-[rgb(var(--text-muted))] hover:text-[rgb(var(--text-main))] py-3 px-4 font-medium text-sm transition-colors whitespace-nowrap">
                    13.5 Collusion Networks
                </a>
                <a href="#" class="border-b-2 border-transparent text-[rgb(var(--text-muted))] hover:text-[rgb(var(--text-main))] py-3 px-4 font-medium text-sm transition-colors whitespace-nowrap">
                    13.6 Enforcement
                </a>
                <a href="#" class="border-b-2 border-transparent text-[rgb(var(--text-muted))] hover:text-[rgb(var(--text-main))] py-3 px-4 font-medium text-sm transition-colors whitespace-nowrap">
                    13.7 Overrides
                </a>
            </nav>
        </div>

        <div class="grid grid-cols-1 xl:grid-cols-4 gap-6">
            
            <div class="xl:col-span-1 space-y-6">
                
                <div class="bg-[rgb(var(--bg-card))] p-5 rounded-lg shadow-sm border border-[rgb(var(--border-color))] transition-colors duration-300">
                    <h3 class="text-md font-semibold text-[rgb(var(--text-main))] mb-3 flex items-center">
                        <svg class="w-4 h-4 mr-2 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        Geo-Velocity Alerts
                    </h3>
                    <p class="text-xs text-[rgb(var(--text-muted))] mb-4">Logins from distant locations in impossible timeframes.</p>
                    
                    <div class="space-y-3">
                        <div class="p-3 bg-[rgb(var(--item-active-bg))] rounded border border-orange-200">
                            <div class="flex justify-between items-center mb-1">
                                <span class="text-xs font-bold text-[rgb(var(--text-main))]">Provider #P-882</span>
                                <span class="text-[10px] text-orange-600 font-bold bg-orange-100 px-1 rounded">High Risk</span>
                            </div>
                            <div class="flex items-center justify-between text-xs text-[rgb(var(--text-muted))] mt-2">
                                <div class="text-center">
                                    <span class="block text-xl">🇵🇰</span>
                                    <span>LHE</span>
                                </div>
                                <div class="flex-1 px-2 text-center relative">
                                    <div class="border-t-2 border-dashed border-gray-300 w-full absolute top-1/2 left-0"></div>
                                    <span class="bg-[rgb(var(--item-active-bg))] relative px-1 text-[10px] text-red-500 font-bold">15 mins</span>
                                </div>
                                <div class="text-center">
                                    <span class="block text-xl">🇦🇪</span>
                                    <span>DXB</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-[rgb(var(--bg-card))] p-5 rounded-lg shadow-sm border border-[rgb(var(--border-color))] transition-colors duration-300">
                    <h3 class="text-md font-semibold text-[rgb(var(--text-main))] mb-3">IP Reputation Check</h3>
                    <div class="space-y-2 text-sm">
                        <div class="flex justify-between items-center p-2 bg-[rgb(var(--item-active-bg))] rounded">
                            <span class="text-[rgb(var(--text-muted))]">Known VPN/Proxies</span>
                            <span class="font-bold text-red-600">83 Blocks</span>
                        </div>
                        <div class="flex justify-between items-center p-2 bg-[rgb(var(--item-active-bg))] rounded">
                            <span class="text-[rgb(var(--text-muted))]">TOR Exit Nodes</span>
                            <span class="font-bold text-[rgb(var(--text-main))]">0 Detected</span>
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
                        <button class="bg-[rgb(var(--bg-card))] border border-[rgb(var(--border-color))] text-[rgb(var(--text-main))] px-3 py-1.5 rounded text-xs font-semibold hover:bg-[rgb(var(--item-active-bg))] transition-colors">
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
                                    <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-[rgb(var(--text-muted))] uppercase tracking-wider">Auto-Action Applied</th>
                                </tr>
                            </thead>
                            <tbody class="bg-[rgb(var(--bg-card))] divide-y divide-[rgb(var(--border-color))]">
                                
                                <tr class="hover:bg-[rgb(var(--item-active-bg))] transition-colors bg-red-50/10">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-bold text-[rgb(var(--text-main))]">Customer #C-4419</div>
                                        <div class="text-[10px] text-[rgb(var(--text-muted))] mt-1">IP: 192.168.1.1 (VPN)</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center text-sm text-[rgb(var(--text-main))]">
                                            <svg class="w-4 h-4 mr-2 text-[rgb(var(--text-muted))]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                                            Win / Chrome
                                        </div>
                                        <div class="text-[10px] text-red-500 font-bold mt-1">NEW DEVICE DETECTED</div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex flex-wrap gap-1">
                                            <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-medium bg-red-100 text-red-800 border border-red-200">ATO Suspected</span>
                                            <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-medium bg-orange-50 text-orange-700 border border-orange-200">Data Center IP</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right">
                                        <span class="px-2 py-1 bg-red-600 text-white rounded text-xs font-bold shadow-sm">
                                            Temporary Lock
                                        </span>
                                        <p class="text-[10px] text-[rgb(var(--text-muted))] mt-1">User Notified</p>
                                    </td>
                                </tr>

                                <tr class="hover:bg-[rgb(var(--item-active-bg))] transition-colors">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-bold text-[rgb(var(--text-main))]">Unauthenticated</div>
                                        <div class="text-[10px] text-[rgb(var(--text-muted))] mt-1">IP: 45.22.11.x (Russia)</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center text-sm text-[rgb(var(--text-main))]">
                                            <span class="text-[10px] text-[rgb(var(--text-muted))] font-mono bg-[rgb(var(--item-active-bg))] px-1 rounded border border-[rgb(var(--border-color))]">Missing User-Agent</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex flex-wrap gap-1">
                                            <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-medium bg-gray-200 text-gray-800 border border-gray-300">High Request Velocity (API)</span>
                                            <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-medium bg-red-50 text-red-700 border border-red-200">Brute Force Try</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right">
                                        <span class="px-2 py-1 bg-gray-800 text-white rounded text-xs font-bold shadow-sm">
                                            Session Terminated
                                        </span>
                                        <p class="text-[10px] text-[rgb(var(--text-muted))] mt-1">IP Blacklisted</p>
                                    </td>
                                </tr>

                                <tr class="hover:bg-[rgb(var(--item-active-bg))] transition-colors">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-bold text-[rgb(var(--text-main))]">Mart Vendor #V-112</div>
                                        <div class="text-[10px] text-[rgb(var(--text-muted))] mt-1">IP: 103.11.22.x (PK)</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center text-sm text-[rgb(var(--text-main))]">
                                            <svg class="w-4 h-4 mr-2 text-[rgb(var(--text-muted))]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                                            iOS / Safari
                                        </div>
                                        <div class="text-[10px] text-[rgb(var(--text-muted))] mt-1">Known Device</div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex flex-wrap gap-1">
                                            <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-medium bg-yellow-100 text-yellow-800 border border-yellow-200">Payout Action Attempted</span>
                                            <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-medium bg-yellow-50 text-yellow-700 border border-yellow-200">Off-hours Login</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right">
                                        <span class="px-2 py-1 bg-blue-100 text-blue-800 border border-blue-200 rounded text-xs font-bold">
                                            Step-up Auth Triggered
                                        </span>
                                        <p class="text-[10px] text-[rgb(var(--text-muted))] mt-1">Awaiting 2FA OTP</p>
                                    </td>
                                </tr>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection