@extends('layouts.app')

@section('content')

<div class="min-h-screen bg-[rgb(var(--bg-body))] font-sans transition-colors duration-300">
    <div class="container mx-auto px-4 py-8">

        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 border-b border-[rgb(var(--border-color))] pb-4">
            <div>
                <h1 class="text-3xl font-bold text-[rgb(var(--text-main))] transition-colors">Automated Enforcement Engine</h1>
                <p class="text-sm text-[rgb(var(--text-muted))] mt-1 transition-colors">Real-time, rule-based, and AI-driven restriction and penalty application</p>
            </div>
            
            <div class="mt-4 md:mt-0 flex space-x-4">
                <div class="bg-blue-50 p-3 rounded-lg border border-blue-200 shadow-sm flex items-center">
                    <div class="mr-3 text-right">
                        <span class="block text-[10px] uppercase text-blue-800 font-bold tracking-wider">Auto-Actions (24h)</span>
                        <span class="text-lg font-bold text-blue-700">1,204</span>
                    </div>
                    <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center text-blue-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                    </div>
                </div>
                <button class="bg-[rgb(var(--brand-primary))] text-white px-4 py-2 rounded text-sm font-semibold hover:bg-[rgb(var(--brand-secondary))] transition-colors shadow-sm">
                    + Create New Rule
                </button>
            </div>
        </div>

        <div class="mb-6">
            <nav class="flex space-x-4 border-b border-[rgb(var(--border-color))] overflow-x-auto pb-1">
                <a href="#" class="border-b-2 border-transparent text-[rgb(var(--text-muted))] hover:text-[rgb(var(--text-main))] py-3 px-4 font-medium text-sm transition-colors whitespace-nowrap">
                    13.1 Risk Scoring Engine
                </a>
                <a href="#" class="border-b-2 border-transparent text-[rgb(var(--text-muted))] hover:text-[rgb(var(--text-main))] py-3 px-4 font-medium text-sm transition-colors whitespace-nowrap">
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
                <a href="#" class="border-b-2 border-[rgb(var(--brand-primary))] text-[rgb(var(--brand-primary))] py-3 px-4 font-semibold text-sm transition-colors whitespace-nowrap">
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
                    <h3 class="text-md font-semibold text-[rgb(var(--text-main))] mb-4">Active Enforcement Rules</h3>
                    
                    <div class="space-y-4">
                        <div class="p-3 bg-[rgb(var(--item-active-bg))] rounded border border-[rgb(var(--border-color))] relative">
                            <div class="absolute top-2 right-2 w-2 h-2 rounded-full bg-green-500"></div>
                            <span class="text-xs font-bold text-[rgb(var(--text-main))] block mb-1">Critical Risk Score (>90)</span>
                            <span class="text-[10px] bg-gray-200 text-gray-700 px-1.5 py-0.5 rounded font-mono mb-2 inline-block">Threshold-based</span>
                            <div class="text-[10px] text-[rgb(var(--text-muted))]">
                                <strong>Action:</strong> <span class="text-red-600 font-semibold">Account Suspension</span><br>
                                <strong>Target:</strong> All Entities
                            </div>
                            <button class="text-[10px] text-[rgb(var(--brand-primary))] mt-2 hover:underline">Edit Policy</button>
                        </div>

                        <div class="p-3 bg-[rgb(var(--item-active-bg))] rounded border border-[rgb(var(--border-color))] relative">
                            <div class="absolute top-2 right-2 w-2 h-2 rounded-full bg-green-500"></div>
                            <span class="text-xs font-bold text-[rgb(var(--text-main))] block mb-1">Fraud Classification (High)</span>
                            <span class="text-[10px] bg-purple-100 text-purple-700 px-1.5 py-0.5 rounded font-mono mb-2 inline-block">AI-confidence-based</span>
                            <div class="text-[10px] text-[rgb(var(--text-muted))]">
                                <strong>Condition:</strong> AI Conf > 85%<br>
                                <strong>Action:</strong> <span class="text-orange-600 font-semibold">Wallet Freeze & Payout Hold</span>
                            </div>
                        </div>

                        <div class="p-3 bg-[rgb(var(--item-active-bg))] rounded border border-[rgb(var(--border-color))] relative">
                            <div class="absolute top-2 right-2 w-2 h-2 rounded-full bg-green-500"></div>
                            <span class="text-xs font-bold text-[rgb(var(--text-main))] block mb-1">Repeated Rejections</span>
                            <span class="text-[10px] bg-blue-100 text-blue-700 px-1.5 py-0.5 rounded font-mono mb-2 inline-block">Pattern/Time-bound</span>
                            <div class="text-[10px] text-[rgb(var(--text-muted))]">
                                <strong>Condition:</strong> 3+ cancelled jobs in 1hr<br>
                                <strong>Action:</strong> <span class="text-yellow-600 font-semibold">Visibility Downgrade (24h)</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-[rgb(var(--bg-card))] p-5 rounded-lg shadow-sm border border-[rgb(var(--border-color))] transition-colors duration-300">
                    <h3 class="text-md font-semibold text-[rgb(var(--text-main))] mb-3">Notification Hooks</h3>
                    <p class="text-[10px] text-[rgb(var(--text-muted))] mb-3">Ensure no "silent enforcement". Users are notified when restrictions apply.</p>
                    <label class="flex items-center space-x-2 text-xs text-[rgb(var(--text-main))] mb-2">
                        <input type="checkbox" checked class="rounded text-[rgb(var(--brand-primary))] focus:ring-[rgb(var(--brand-primary))]">
                        <span>Send Email on Suspension</span>
                    </label>
                    <label class="flex items-center space-x-2 text-xs text-[rgb(var(--text-main))] mb-2">
                        <input type="checkbox" checked class="rounded text-[rgb(var(--brand-primary))] focus:ring-[rgb(var(--brand-primary))]">
                        <span>In-App Graceful Restriction UI</span>
                    </label>
                    <label class="flex items-center space-x-2 text-xs text-[rgb(var(--text-main))]">
                        <input type="checkbox" checked class="rounded text-[rgb(var(--brand-primary))] focus:ring-[rgb(var(--brand-primary))]">
                        <span>Log to Audit Trail (Mandatory)</span>
                    </label>
                </div>
            </div>

            <div class="xl:col-span-3">
                <div class="bg-[rgb(var(--bg-card))] rounded-lg shadow-sm border border-[rgb(var(--border-color))] overflow-hidden transition-colors duration-300">
                    <div class="px-6 py-4 border-b border-[rgb(var(--border-color))] bg-[rgb(var(--item-active-bg))] flex justify-between items-center">
                        <div>
                            <h3 class="text-lg font-semibold text-[rgb(var(--text-main))]">Enforcement Execution Log</h3>
                            <p class="text-xs text-[rgb(var(--text-muted))]">Live stream of automated restrictions applied by the Engine.</p>
                        </div>
                        <div class="flex space-x-2">
                            <select class="text-xs border-[rgb(var(--border-color))] bg-[rgb(var(--bg-card))] text-[rgb(var(--text-main))] rounded-md py-1.5 px-2 focus:ring-[rgb(var(--brand-primary))]">
                                <option>All Actions</option>
                                <option>Suspensions</option>
                                <option>Wallet Freezes</option>
                                <option>Downgrades</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-[rgb(var(--border-color))]">
                            <thead class="bg-[rgb(var(--bg-card))]">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-[rgb(var(--text-muted))] uppercase tracking-wider">Timestamp / Entity</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-[rgb(var(--text-muted))] uppercase tracking-wider">Trigger Event & Rule</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-[rgb(var(--text-muted))] uppercase tracking-wider">Applied Action</th>
                                    <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-[rgb(var(--text-muted))] uppercase tracking-wider">Status / Comm</th>
                                </tr>
                            </thead>
                            <tbody class="bg-[rgb(var(--bg-card))] divide-y divide-[rgb(var(--border-color))]">
                                
                                <tr class="hover:bg-[rgb(var(--item-active-bg))] transition-colors bg-red-50/10">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-[10px] text-[rgb(var(--text-muted))] font-mono mb-1">Just now</div>
                                        <div class="text-sm font-bold text-[rgb(var(--text-main))]">Customer #C-4091</div>
                                        <div class="text-[10px] text-red-600 font-semibold mt-1">Risk Score: 95 (Critical)</div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-xs text-[rgb(var(--text-main))] font-bold mb-1">Event: Multiple Chargebacks</div>
                                        <div class="text-[10px] text-[rgb(var(--text-muted))]">
                                            <span class="bg-[rgb(var(--item-active-bg))] px-1 border border-[rgb(var(--border-color))] rounded">Rule: Critical Risk Score (>90)</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 py-1 bg-red-600 text-white rounded text-xs font-bold shadow-sm inline-flex items-center">
                                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                                            Account Suspended
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right">
                                        <span class="text-[10px] text-green-600 font-bold flex justify-end items-center">
                                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                            Logged & Emailed
                                        </span>
                                        <p class="text-[9px] text-[rgb(var(--text-muted))] mt-1">Sess Terminated</p>
                                    </td>
                                </tr>

                                <tr class="hover:bg-[rgb(var(--item-active-bg))] transition-colors">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-[10px] text-[rgb(var(--text-muted))] font-mono mb-1">2 mins ago</div>
                                        <div class="text-sm font-bold text-[rgb(var(--text-main))]">Provider #P-881</div>
                                        <div class="text-[10px] text-yellow-600 font-semibold mt-1">Tier: Gold</div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-xs text-[rgb(var(--text-main))] font-bold mb-1">Event: Repeated Cancellations</div>
                                        <div class="text-[10px] text-[rgb(var(--text-muted))]">
                                            <span class="bg-[rgb(var(--item-active-bg))] px-1 border border-[rgb(var(--border-color))] rounded">Rule: Repeated Rejections (Pattern)</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 py-1 bg-yellow-100 text-yellow-800 border border-yellow-200 rounded text-xs font-bold inline-flex items-center">
                                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 17h8m0 0V9m0 8l-8-8-4 4-6-6"></path></svg>
                                            Visibility Downgrade (24h)
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right">
                                        <span class="text-[10px] text-green-600 font-bold flex justify-end items-center">
                                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                            In-App Notice Sent
                                        </span>
                                        <p class="text-[9px] text-[rgb(var(--text-muted))] mt-1">Search Rank Dropped</p>
                                    </td>
                                </tr>

                                <tr class="hover:bg-[rgb(var(--item-active-bg))] transition-colors">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-[10px] text-[rgb(var(--text-muted))] font-mono mb-1">15 mins ago</div>
                                        <div class="text-sm font-bold text-[rgb(var(--text-main))]">Mart Vendor #V-110</div>
                                        <div class="text-[10px] text-orange-600 font-semibold mt-1">AI Conf: 89%</div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-xs text-[rgb(var(--text-main))] font-bold mb-1">Event: Refund/COD Anomaly</div>
                                        <div class="text-[10px] text-[rgb(var(--text-muted))]">
                                            <span class="bg-[rgb(var(--item-active-bg))] px-1 border border-[rgb(var(--border-color))] rounded">Rule: Fraud Classification (High)</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 py-1 bg-orange-100 text-orange-800 border border-orange-200 rounded text-xs font-bold inline-flex items-center">
                                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                                            Wallet Freeze
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right">
                                        <span class="text-[10px] text-green-600 font-bold flex justify-end items-center">
                                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                            Finance API Updated
                                        </span>
                                        <p class="text-[9px] text-[rgb(var(--text-muted))] mt-1">Awaiting Manual Rev</p>
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