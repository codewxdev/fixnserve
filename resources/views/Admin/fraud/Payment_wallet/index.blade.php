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
                        <span class="text-lg font-bold text-red-600">Rs. 450,000</span>
                    </div>
                    <div class="w-10 h-10 rounded-full bg-red-100 flex items-center justify-center text-red-500">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                    </div>
                </div>
                <div class="bg-yellow-50 p-3 rounded-lg border border-yellow-200 shadow-sm flex items-center">
                    <div class="mr-3 text-right">
                        <span class="block text-[10px] uppercase text-yellow-800 font-bold tracking-wider">Frozen Wallets</span>
                        <span class="text-lg font-bold text-yellow-700">18 Active</span>
                    </div>
                </div>
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
                <a href="#" class="border-b-2 border-[rgb(var(--brand-primary))] text-[rgb(var(--brand-primary))] py-3 px-4 font-semibold text-sm transition-colors whitespace-nowrap">
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
                    <h3 class="text-md font-semibold text-[rgb(var(--text-main))] mb-4">Active Threat Patterns</h3>
                    
                    <div class="space-y-4">
                        <div class="border-l-2 border-red-500 pl-3">
                            <div class="flex justify-between items-center">
                                <span class="text-xs font-bold text-[rgb(var(--text-main))]">Refund-Wallet Loops</span>
                                <span class="bg-red-100 text-red-700 px-1.5 py-0.5 rounded text-[10px] font-bold">Critical</span>
                            </div>
                            <p class="text-[10px] text-[rgb(var(--text-muted))] mt-1">Detects rapid order placement and immediate refund to wallet for cashing out.</p>
                            <div class="mt-2 text-[10px] font-semibold text-[rgb(var(--brand-primary))]">Auto-Action: Freeze Wallet</div>
                        </div>

                        <div class="border-l-2 border-orange-500 pl-3">
                            <div class="flex justify-between items-center">
                                <span class="text-xs font-bold text-[rgb(var(--text-main))]">COD Manipulation</span>
                                <span class="bg-orange-100 text-orange-700 px-1.5 py-0.5 rounded text-[10px] font-bold">High</span>
                            </div>
                            <p class="text-[10px] text-[rgb(var(--text-muted))] mt-1">Rider marks COD collected but delays deposit, or customer rejects high-value COD repeatedly.</p>
                            <div class="mt-2 text-[10px] font-semibold text-[rgb(var(--brand-primary))]">Auto-Action: Block COD Option</div>
                        </div>

                        <div class="border-l-2 border-yellow-500 pl-3">
                            <div class="flex justify-between items-center">
                                <span class="text-xs font-bold text-[rgb(var(--text-main))]">Chargeback Clustering</span>
                                <span class="bg-yellow-100 text-yellow-700 px-1.5 py-0.5 rounded text-[10px] font-bold">Medium</span>
                            </div>
                            <p class="text-[10px] text-[rgb(var(--text-muted))] mt-1">Multiple chargebacks originating from the same device or IP block.</p>
                            <div class="mt-2 text-[10px] font-semibold text-[rgb(var(--brand-primary))]">Auto-Action: Delay Payouts</div>
                        </div>
                    </div>
                </div>

                <div class="bg-[rgb(var(--bg-card))] p-5 rounded-lg shadow-sm border border-[rgb(var(--border-color))] transition-colors duration-300">
                    <h3 class="text-md font-semibold text-[rgb(var(--text-main))] mb-3">Velocity Limits</h3>
                    <div class="space-y-3">
                        <div>
                            <div class="flex justify-between text-xs mb-1">
                                <span class="text-[rgb(var(--text-muted))]">Top-ups / 24h</span>
                                <span class="text-[rgb(var(--text-main))] font-bold">Max 5</span>
                            </div>
                            <div class="w-full bg-[rgb(var(--item-active-bg))] rounded-full h-1.5">
                                <div class="bg-blue-500 h-1.5 rounded-full" style="width: 100%"></div>
                            </div>
                        </div>
                        <div>
                            <div class="flex justify-between text-xs mb-1">
                                <span class="text-[rgb(var(--text-muted))]">Withdrawals / 24h</span>
                                <span class="text-[rgb(var(--text-main))] font-bold">Max 2</span>
                            </div>
                            <div class="w-full bg-[rgb(var(--item-active-bg))] rounded-full h-1.5">
                                <div class="bg-blue-500 h-1.5 rounded-full" style="width: 100%"></div>
                            </div>
                        </div>
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
                        <button class="bg-[rgb(var(--bg-card))] border border-[rgb(var(--border-color))] text-[rgb(var(--text-main))] px-3 py-1.5 rounded text-xs font-semibold hover:bg-[rgb(var(--item-active-bg))] transition-colors">
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
                                    <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-[rgb(var(--text-muted))] uppercase tracking-wider">Enforcement Engine</th>
                                </tr>
                            </thead>
                            <tbody class="bg-[rgb(var(--bg-card))] divide-y divide-[rgb(var(--border-color))]">
                                
                                <tr class="hover:bg-[rgb(var(--item-active-bg))] transition-colors bg-red-50/10">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="mr-3 p-2 bg-red-100 text-red-600 rounded">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                            </div>
                                            <div>
                                                <div class="text-sm font-bold text-[rgb(var(--text-main))]">Customer #C-8821</div>
                                                <div class="text-[10px] text-[rgb(var(--text-muted))] mt-1">Withdrawal Attempt: Rs. 15,000</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm font-medium text-[rgb(var(--text-main))]">Refund-Wallet Loop</div>
                                        <div class="text-[10px] text-red-500 mt-1">3 cancelled orders within 1 hour. Funds moved to wallet.</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="w-full bg-gray-200 rounded-full h-1.5 mb-1 max-w-[80px]">
                                            <div class="bg-red-600 h-1.5 rounded-full" style="width: 98%"></div>
                                        </div>
                                        <span class="text-[10px] font-bold text-red-600">98% Match</span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right">
                                        <span class="px-2 py-1 bg-red-600 text-white rounded text-xs font-bold shadow-sm inline-block mb-1">
                                            Wallet Freeze
                                        </span>
                                        <p class="text-[10px] text-[rgb(var(--text-muted))]">Finance Module Updated</p>
                                    </td>
                                </tr>

                                <tr class="hover:bg-[rgb(var(--item-active-bg))] transition-colors">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="mr-3 p-2 bg-orange-100 text-orange-600 rounded">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                            </div>
                                            <div>
                                                <div class="text-sm font-bold text-[rgb(var(--text-main))]">Rider #R-109</div>
                                                <div class="text-[10px] text-[rgb(var(--text-muted))] mt-1">Pending Deposit: Rs. 42,000</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm font-medium text-[rgb(var(--text-main))]">COD Deposit Delay</div>
                                        <div class="text-[10px] text-orange-600 mt-1">Threshold exceeded (48h). High risk of absconding.</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="w-full bg-gray-200 rounded-full h-1.5 mb-1 max-w-[80px]">
                                            <div class="bg-orange-500 h-1.5 rounded-full" style="width: 85%"></div>
                                        </div>
                                        <span class="text-[10px] font-bold text-orange-600">85% Match</span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right">
                                        <span class="px-2 py-1 bg-orange-100 text-orange-800 border border-orange-200 rounded text-xs font-bold inline-block mb-1">
                                            Manual Review Trigger
                                        </span>
                                        <div class="flex justify-end space-x-1 mt-1">
                                            <button class="text-[10px] bg-[rgb(var(--brand-primary))] text-white px-2 py-0.5 rounded">Suspend Dispatch</button>
                                        </div>
                                    </td>
                                </tr>

                                <tr class="hover:bg-[rgb(var(--item-active-bg))] transition-colors">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="mr-3 p-2 bg-yellow-100 text-yellow-600 rounded">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg>
                                            </div>
                                            <div>
                                                <div class="text-sm font-bold text-[rgb(var(--text-main))]">Provider #P-334</div>
                                                <div class="text-[10px] text-[rgb(var(--text-muted))] mt-1">Payout Request: Rs. 8,500</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm font-medium text-[rgb(var(--text-main))]">Chargeback Risk Flag</div>
                                        <div class="text-[10px] text-[rgb(var(--text-muted))] mt-1">Recent payments from high-risk BINs (Credit Cards).</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="w-full bg-gray-200 rounded-full h-1.5 mb-1 max-w-[80px]">
                                            <div class="bg-yellow-500 h-1.5 rounded-full" style="width: 60%"></div>
                                        </div>
                                        <span class="text-[10px] font-bold text-yellow-600">60% Match</span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right">
                                        <span class="px-2 py-1 bg-yellow-100 text-yellow-800 border border-yellow-200 rounded text-xs font-bold inline-block mb-1">
                                            Payout Delay (T+3)
                                        </span>
                                        <p class="text-[10px] text-[rgb(var(--text-muted))]">Escalated to Finance</p>
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