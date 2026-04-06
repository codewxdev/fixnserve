@extends('layouts.app')

@section('content')

<div class="min-h-screen bg-[rgb(var(--bg-body))] font-sans transition-colors duration-300">
    <div class="container mx-auto px-4 py-8">

        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 border-b border-[rgb(var(--border-color))] pb-4">
            <div>
                <h1 class="text-3xl font-bold text-[rgb(var(--text-main))] transition-colors">Fraud, Risk & Abuse Management</h1>
                <p class="text-sm text-[rgb(var(--text-muted))] mt-1 transition-colors">Real-Time Risk Intelligence & Loss Prevention System</p>
            </div>
            
            <div class="mt-4 md:mt-0 flex items-center bg-[rgb(var(--bg-card))] p-3 rounded-lg border border-red-200 shadow-sm">
                <div class="mr-4 text-right">
                    <span class="block text-xs uppercase text-[rgb(var(--text-muted))] font-bold tracking-wider">Critical Entities</span>
                    <span class="text-lg font-bold text-red-600">24 Active Threats</span>
                </div>
                <div class="w-12 h-12 rounded-full flex items-center justify-center bg-red-100 text-red-700 font-bold">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                </div>
            </div>
        </div>

        {{-- <div class="mb-6">
            <nav class="flex space-x-4 border-b border-[rgb(var(--border-color))] overflow-x-auto pb-1">
                <a href="#" class="border-b-2 border-[rgb(var(--brand-primary))] text-[rgb(var(--brand-primary))] py-3 px-4 font-semibold text-sm transition-colors whitespace-nowrap">
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
                <a href="#" class="border-b-2 border-transparent text-[rgb(var(--text-muted))] hover:text-[rgb(var(--text-main))] py-3 px-4 font-medium text-sm transition-colors whitespace-nowrap">
                    13.6 Enforcement
                </a>
                <a href="#" class="border-b-2 border-transparent text-[rgb(var(--text-muted))] hover:text-[rgb(var(--text-main))] py-3 px-4 font-medium text-sm transition-colors whitespace-nowrap">
                    13.7 Overrides
                </a>
            </nav>
        </div> --}}

        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
            <div class="bg-[rgb(var(--bg-card))] p-4 rounded-lg shadow-sm border border-[rgb(var(--border-color))] border-l-4 border-l-green-500">
                <p class="text-xs text-[rgb(var(--text-muted))] font-bold uppercase tracking-wide">Low Risk (0-30)</p>
                <h3 class="text-2xl font-bold text-[rgb(var(--text-main))] mt-1">142,593</h3>
                <p class="text-xs text-green-600 mt-1">92% of network</p>
            </div>
            <div class="bg-[rgb(var(--bg-card))] p-4 rounded-lg shadow-sm border border-[rgb(var(--border-color))] border-l-4 border-l-yellow-400">
                <p class="text-xs text-[rgb(var(--text-muted))] font-bold uppercase tracking-wide">Medium Risk (31-65)</p>
                <h3 class="text-2xl font-bold text-[rgb(var(--text-main))] mt-1">10,241</h3>
                <p class="text-xs text-yellow-600 mt-1">Monitoring active</p>
            </div>
            <div class="bg-[rgb(var(--bg-card))] p-4 rounded-lg shadow-sm border border-[rgb(var(--border-color))] border-l-4 border-l-orange-500">
                <p class="text-xs text-[rgb(var(--text-muted))] font-bold uppercase tracking-wide">High Risk (66-89)</p>
                <h3 class="text-2xl font-bold text-[rgb(var(--text-main))] mt-1">842</h3>
                <p class="text-xs text-orange-600 mt-1">Restricted features</p>
            </div>
            <div class="bg-[rgb(var(--bg-card))] p-4 rounded-lg shadow-sm border border-[rgb(var(--border-color))] border-l-4 border-l-red-600">
                <p class="text-xs text-[rgb(var(--text-muted))] font-bold uppercase tracking-wide">Critical (90-100)</p>
                <h3 class="text-2xl font-bold text-[rgb(var(--text-main))] mt-1">24</h3>
                <p class="text-xs text-red-600 mt-1">Pending suspension</p>
            </div>
        </div>

        <div class="grid grid-cols-1 xl:grid-cols-4 gap-6">
            
            <div class="xl:col-span-1 space-y-6">
                <div class="bg-[rgb(var(--bg-card))] p-5 rounded-lg shadow-sm border border-[rgb(var(--border-color))] transition-colors duration-300">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-md font-semibold text-[rgb(var(--text-main))]">Risk Signal Impact</h3>
                        <button class="text-xs text-[rgb(var(--brand-primary))] hover:underline">Edit Weights</button>
                    </div>
                    <p class="text-xs text-[rgb(var(--text-muted))] mb-4">Current model weights affecting the dynamic risk score.</p>
                    
                    <div class="space-y-4">
                        <div>
                            <div class="flex justify-between text-xs mb-1">
                                <span class="text-[rgb(var(--text-main))] font-medium">Device Reuse (Multi-acc)</span>
                                <span class="text-red-600 font-bold">High Impact</span>
                            </div>
                            <div class="w-full bg-[rgb(var(--item-active-bg))] rounded-full h-1.5">
                                <div class="bg-red-500 h-1.5 rounded-full" style="width: 85%"></div>
                            </div>
                        </div>
                        <div>
                            <div class="flex justify-between text-xs mb-1">
                                <span class="text-[rgb(var(--text-main))] font-medium">Payment Failures</span>
                                <span class="text-orange-500 font-bold">Medium Impact</span>
                            </div>
                            <div class="w-full bg-[rgb(var(--item-active-bg))] rounded-full h-1.5">
                                <div class="bg-orange-500 h-1.5 rounded-full" style="width: 60%"></div>
                            </div>
                        </div>
                        <div>
                            <div class="flex justify-between text-xs mb-1">
                                <span class="text-[rgb(var(--text-main))] font-medium">Velocity Patterns (Wallet)</span>
                                <span class="text-red-600 font-bold">High Impact</span>
                            </div>
                            <div class="w-full bg-[rgb(var(--item-active-bg))] rounded-full h-1.5">
                                <div class="bg-red-500 h-1.5 rounded-full" style="width: 75%"></div>
                            </div>
                        </div>
                        <div>
                            <div class="flex justify-between text-xs mb-1">
                                <span class="text-[rgb(var(--text-main))] font-medium">Geo Inconsistencies</span>
                                <span class="text-yellow-600 font-bold">Low Impact</span>
                            </div>
                            <div class="w-full bg-[rgb(var(--item-active-bg))] rounded-full h-1.5">
                                <div class="bg-yellow-500 h-1.5 rounded-full" style="width: 35%"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="xl:col-span-3">
                <div class="bg-[rgb(var(--bg-card))] rounded-lg shadow-sm border border-[rgb(var(--border-color))] overflow-hidden transition-colors duration-300">
                    <div class="px-6 py-4 border-b border-[rgb(var(--border-color))] bg-[rgb(var(--item-active-bg))] flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3">
                        <div>
                            <h3 class="text-lg font-semibold text-[rgb(var(--text-main))]">Live Risk Engine Feed</h3>
                            <p class="text-xs text-[rgb(var(--text-muted))]">Real-time scoring of entities triggering risk thresholds.</p>
                        </div>
                        <div class="flex space-x-2 w-full sm:w-auto">
                            <input type="text" placeholder="Search Entity ID..." class="w-full sm:w-48 text-sm border-[rgb(var(--border-color))] bg-[rgb(var(--bg-card))] text-[rgb(var(--text-main))] rounded-md py-1.5 px-3 focus:ring-[rgb(var(--brand-primary))] focus:border-[rgb(var(--brand-primary))]">
                            <select class="text-sm border-[rgb(var(--border-color))] bg-[rgb(var(--bg-card))] text-[rgb(var(--text-main))] rounded-md py-1.5 px-3 focus:ring-[rgb(var(--brand-primary))] focus:border-[rgb(var(--brand-primary))]">
                                <option>All Tiers</option>
                                <option>Critical & High</option>
                                <option>Medium</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-[rgb(var(--border-color))]">
                            <thead class="bg-[rgb(var(--bg-card))]">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-[rgb(var(--text-muted))] uppercase tracking-wider">Entity</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-[rgb(var(--text-muted))] uppercase tracking-wider">Risk Score (0-100)</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-[rgb(var(--text-muted))] uppercase tracking-wider">Signals / Reason Codes</th>
                                    <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-[rgb(var(--text-muted))] uppercase tracking-wider">Enforcement</th>
                                </tr>
                            </thead>
                            <tbody class="bg-[rgb(var(--bg-card))] divide-y divide-[rgb(var(--border-color))]">
                                
                                <tr class="hover:bg-[rgb(var(--item-active-bg))] transition-colors bg-red-50/10">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-bold text-[rgb(var(--text-main))]">Customer #CUS-9912</div>
                                        <div class="text-[10px] text-[rgb(var(--text-muted))] mt-1">Last event: 2 mins ago</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center space-x-2">
                                            <span class="text-xl font-black text-red-600">94</span>
                                            <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-red-100 text-red-800 uppercase">Critical</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex flex-wrap gap-1">
                                            <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-medium bg-red-50 text-red-700 border border-red-200">Device Reuse (5x)</span>
                                            <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-medium bg-red-50 text-red-700 border border-red-200">Chargeback Cluster</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right">
                                        <span class="text-xs font-bold text-red-600 flex justify-end items-center">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                                            Account Suspended
                                        </span>
                                        <button class="text-[10px] text-[rgb(var(--brand-primary))] hover:underline mt-1">Investigate</button>
                                    </td>
                                </tr>

                                <tr class="hover:bg-[rgb(var(--item-active-bg))] transition-colors">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-bold text-[rgb(var(--text-main))]">Rider #RID-442</div>
                                        <div class="text-[10px] text-[rgb(var(--text-muted))] mt-1">Last event: 15 mins ago</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center space-x-2">
                                            <span class="text-xl font-black text-orange-500">78</span>
                                            <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-orange-100 text-orange-800 uppercase">High</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex flex-wrap gap-1">
                                            <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-medium bg-yellow-50 text-yellow-700 border border-yellow-200">Velocity Pattern (COD)</span>
                                            <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-medium bg-gray-100 text-gray-700 border border-gray-200">Geo Mismatch</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right">
                                        <span class="text-xs font-bold text-orange-600">Wallet Freeze Active</span>
                                        <div class="mt-1">
                                            <button class="text-[10px] bg-[rgb(var(--item-active-bg))] border border-[rgb(var(--border-color))] px-2 py-1 rounded text-[rgb(var(--text-main))] hover:bg-[rgb(var(--bg-body))] transition-colors">Review Docs</button>
                                        </div>
                                    </td>
                                </tr>

                                <tr class="hover:bg-[rgb(var(--item-active-bg))] transition-colors">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-bold text-[rgb(var(--text-main))]">Mart Vendor #V-1029</div>
                                        <div class="text-[10px] text-[rgb(var(--text-muted))] mt-1">Last event: 1 hour ago</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center space-x-2">
                                            <span class="text-xl font-black text-yellow-500">45</span>
                                            <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-yellow-100 text-yellow-800 uppercase">Medium</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex flex-wrap gap-1">
                                            <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-medium bg-gray-100 text-gray-700 border border-gray-200">Dispute Frequency Jump</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right">
                                        <span class="text-xs font-medium text-[rgb(var(--text-muted))]">Monitoring</span>
                                        <div class="mt-1">
                                            <button class="text-[10px] text-[rgb(var(--brand-primary))] hover:underline">View History</button>
                                        </div>
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