@extends('layouts.app')

@section('content')

<div class="min-h-screen bg-[rgb(var(--bg-body))] font-sans transition-colors duration-300">
    <div class="container mx-auto px-4 py-8">

        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 border-b border-[rgb(var(--border-color))] pb-4">
            <div>
                <h1 class="text-3xl font-bold text-[rgb(var(--text-main))] transition-colors">Collusion & Network Fraud</h1>
                <p class="text-sm text-[rgb(var(--text-muted))] mt-1 transition-colors">Graph-based modeling to identify coordinated abuse across multiple actors</p>
            </div>
            
            <div class="mt-4 md:mt-0 flex space-x-4">
                <div class="bg-purple-50 p-3 rounded-lg border border-purple-200 shadow-sm flex items-center">
                    <div class="mr-3 text-right">
                        <span class="block text-[10px] uppercase text-purple-800 font-bold tracking-wider">Active Fraud Rings</span>
                        <span class="text-lg font-bold text-purple-700">8 Detected</span>
                    </div>
                    <div class="w-10 h-10 rounded-full bg-purple-100 flex items-center justify-center text-purple-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path></svg>
                    </div>
                </div>
                <button class="bg-[rgb(var(--brand-primary))] text-white px-4 py-2 rounded text-sm font-semibold hover:bg-[rgb(var(--brand-secondary))] transition-colors shadow-sm">
                    Open Graph Explorer
                </button>
            </div>
        </div>

        {{-- <div class="mb-6">
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
                <a href="#" class="border-b-2 border-[rgb(var(--brand-primary))] text-[rgb(var(--brand-primary))] py-3 px-4 font-semibold text-sm transition-colors whitespace-nowrap">
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

        <div class="grid grid-cols-1 xl:grid-cols-4 gap-6">
            
            <div class="xl:col-span-1 space-y-6">
                
                <div class="bg-[rgb(var(--bg-card))] p-5 rounded-lg shadow-sm border border-[rgb(var(--border-color))] transition-colors duration-300">
                    <h3 class="text-md font-semibold text-[rgb(var(--text-main))] mb-4">Network Relationship Modeler</h3>
                    
                    <div class="space-y-4">
                        <div class="p-3 bg-[rgb(var(--item-active-bg))] rounded border border-[rgb(var(--border-color))]">
                            <span class="text-xs font-bold text-[rgb(var(--text-main))] block mb-2">Repeated Interaction Anomaly</span>
                            <div class="flex items-center space-x-2 text-[10px] text-[rgb(var(--text-muted))]">
                                <div class="w-8 h-8 rounded bg-blue-100 flex items-center justify-center text-blue-700 font-bold border border-blue-200">C</div>
                                <div class="flex-1 border-t-2 border-dashed border-gray-400 relative">
                                    <span class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 bg-[rgb(var(--item-active-bg))] px-1 font-bold text-red-500">12 Jobs</span>
                                </div>
                                <div class="w-8 h-8 rounded bg-green-100 flex items-center justify-center text-green-700 font-bold border border-green-200">P</div>
                            </div>
                            <p class="text-[9px] mt-2 text-[rgb(var(--text-muted))]">Detects when a customer exclusively hires the same provider repeatedly in a short timeframe.</p>
                        </div>

                        <div class="p-3 bg-[rgb(var(--item-active-bg))] rounded border border-[rgb(var(--border-color))]">
                            <span class="text-xs font-bold text-[rgb(var(--text-main))] block mb-2">Time-Pattern Correlation</span>
                            <div class="h-10 flex items-end space-x-1">
                                <div class="w-1/6 bg-gray-300 h-2 rounded-t"></div>
                                <div class="w-1/6 bg-gray-300 h-3 rounded-t"></div>
                                <div class="w-1/6 bg-red-400 h-full rounded-t relative group">
                                    <span class="hidden group-hover:block absolute -top-5 left-1/2 transform -translate-x-1/2 bg-gray-800 text-white text-[8px] px-1 rounded">Surge</span>
                                </div>
                                <div class="w-1/6 bg-red-500 h-4/5 rounded-t"></div>
                                <div class="w-1/6 bg-gray-300 h-2 rounded-t"></div>
                                <div class="w-1/6 bg-gray-300 h-1 rounded-t"></div>
                            </div>
                            <p class="text-[9px] mt-2 text-[rgb(var(--text-muted))]">Spikes in reviews or job completions across specific sub-networks usually indicate a coordinated fake rating ring.</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="xl:col-span-3">
                <div class="bg-[rgb(var(--bg-card))] rounded-lg shadow-sm border border-[rgb(var(--border-color))] overflow-hidden transition-colors duration-300">
                    <div class="px-6 py-4 border-b border-[rgb(var(--border-color))] bg-[rgb(var(--item-active-bg))] flex justify-between items-center">
                        <div>
                            <h3 class="text-lg font-semibold text-[rgb(var(--text-main))]">Live Detected Collusion Rings</h3>
                            <p class="text-xs text-[rgb(var(--text-muted))]">Multi-actor abuse scenarios identified by the graph engine.</p>
                        </div>
                        <div class="flex space-x-2">
                            <button class="bg-[rgb(var(--bg-card))] border border-[rgb(var(--border-color))] text-[rgb(var(--text-main))] px-3 py-1.5 rounded text-xs font-semibold hover:bg-[rgb(var(--item-active-bg))] transition-colors">
                                Bulk Ban
                            </button>
                        </div>
                    </div>
                    
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-[rgb(var(--border-color))]">
                            <thead class="bg-[rgb(var(--bg-card))]">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-[rgb(var(--text-muted))] uppercase tracking-wider">Ring ID & Type</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-[rgb(var(--text-muted))] uppercase tracking-wider">Actors Involved</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-[rgb(var(--text-muted))] uppercase tracking-wider">Fraud Pattern & Confidence</th>
                                    <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-[rgb(var(--text-muted))] uppercase tracking-wider">System Enforcement</th>
                                </tr>
                            </thead>
                            <tbody class="bg-[rgb(var(--bg-card))] divide-y divide-[rgb(var(--border-color))]">
                                
                                <tr class="hover:bg-[rgb(var(--item-active-bg))] transition-colors bg-purple-50/20">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-bold text-[rgb(var(--brand-primary))]">RING-2291</div>
                                        <div class="text-[10px] text-[rgb(var(--text-muted))] mt-1 uppercase font-bold text-purple-700">Provider-Customer Collusion</div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center space-x-1">
                                            <span class="text-[10px] font-mono bg-blue-100 text-blue-800 px-1.5 py-0.5 rounded">C-882</span>
                                            <span class="text-gray-400">↔</span>
                                            <span class="text-[10px] font-mono bg-green-100 text-green-800 px-1.5 py-0.5 rounded">P-104</span>
                                        </div>
                                        <div class="text-[10px] text-[rgb(var(--text-muted))] mt-1">2 Nodes Identified</div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-[10px] text-[rgb(var(--text-main))] font-bold mb-1">Fake Job Completion Loop</div>
                                        <div class="text-[10px] text-[rgb(var(--text-muted))] mb-1">8 jobs booked and marked complete in 4 hours. No chat/location history.</div>
                                        <div class="flex items-center space-x-2">
                                            <span class="w-16 bg-gray-200 rounded-full h-1"><span class="bg-red-500 h-1 rounded-full block" style="width: 95%"></span></span>
                                            <span class="text-[9px] text-red-600 font-bold">95% Conf</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right">
                                        <span class="px-2 py-1 bg-gray-800 text-white rounded text-xs font-bold shadow-sm inline-block mb-1">
                                            Ranking Suppressed
                                        </span>
                                        <div class="flex justify-end space-x-1 mt-1">
                                            <button class="text-[10px] bg-red-50 text-red-600 border border-red-200 px-2 py-0.5 rounded hover:bg-red-100">Shadow Ban</button>
                                        </div>
                                    </td>
                                </tr>

                                <tr class="hover:bg-[rgb(var(--item-active-bg))] transition-colors">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-bold text-[rgb(var(--brand-primary))]">RING-2292</div>
                                        <div class="text-[10px] text-[rgb(var(--text-muted))] mt-1 uppercase font-bold text-orange-700">Rider-Vendor Collusion</div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center space-x-1">
                                            <span class="text-[10px] font-mono bg-yellow-100 text-yellow-800 px-1.5 py-0.5 rounded">V-312</span>
                                            <span class="text-gray-400">↔</span>
                                            <span class="text-[10px] font-mono bg-purple-100 text-purple-800 px-1.5 py-0.5 rounded">R-99</span>
                                        </div>
                                        <div class="text-[10px] text-[rgb(var(--text-muted))] mt-1">Shared GPS Coordinates</div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-[10px] text-[rgb(var(--text-main))] font-bold mb-1">Farming Delivery Fees</div>
                                        <div class="text-[10px] text-[rgb(var(--text-muted))] mb-1">Rider exclusively picking orders from this Vendor at impossibly high speeds.</div>
                                        <div class="flex items-center space-x-2">
                                            <span class="w-16 bg-gray-200 rounded-full h-1"><span class="bg-orange-500 h-1 rounded-full block" style="width: 88%"></span></span>
                                            <span class="text-[9px] text-orange-600 font-bold">88% Conf</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right">
                                        <span class="px-2 py-1 bg-yellow-100 text-yellow-800 border border-yellow-200 rounded text-xs font-bold inline-block mb-1">
                                            Investigation Opened
                                        </span>
                                        <p class="text-[10px] text-[rgb(var(--text-muted))]">Payouts Frozen Temporarily</p>
                                    </td>
                                </tr>

                                <tr class="hover:bg-[rgb(var(--item-active-bg))] transition-colors">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-bold text-[rgb(var(--brand-primary))]">RING-2293</div>
                                        <div class="text-[10px] text-[rgb(var(--text-muted))] mt-1 uppercase font-bold text-blue-700">Review Manipulation</div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center space-x-1">
                                            <span class="text-[10px] font-mono bg-blue-100 text-blue-800 px-1.5 py-0.5 rounded">+14 Customers</span>
                                        </div>
                                        <div class="text-[10px] text-[rgb(var(--text-muted))] mt-1">Targeting: 3 Providers</div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-[10px] text-[rgb(var(--text-main))] font-bold mb-1">5-Star Swapping / Farm</div>
                                        <div class="text-[10px] text-[rgb(var(--text-muted))] mb-1">Sudden burst of 5-star ratings without significant payment processing.</div>
                                        <div class="flex items-center space-x-2">
                                            <span class="w-16 bg-gray-200 rounded-full h-1"><span class="bg-yellow-500 h-1 rounded-full block" style="width: 72%"></span></span>
                                            <span class="text-[9px] text-yellow-600 font-bold">72% Conf</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right">
                                        <span class="px-2 py-1 bg-gray-100 text-gray-800 border border-gray-300 rounded text-xs font-bold inline-block mb-1">
                                            Reviews Quarantined
                                        </span>
                                        <p class="text-[10px] text-[rgb(var(--text-muted))]">Ratings excluded from score</p>
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