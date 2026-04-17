@extends('layouts.app')

@section('content')

<div class="min-h-screen bg-[rgb(var(--bg-body))] font-sans transition-colors duration-300">
    <div class="container mx-auto px-4 py-8">

        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 border-b border-[rgb(var(--border-color))] pb-4">
            <div>
                <h1 class="text-3xl font-bold text-[rgb(var(--text-main))] transition-colors">Promotion & Incentive Abuse</h1>
                <p class="text-sm text-[rgb(var(--text-muted))] mt-1 transition-colors">Prevent promo exploitation, referral loops, and protect marketing budgets</p>
            </div>
            
            <div class="mt-4 md:mt-0 flex space-x-4">
                <div class="bg-green-50 p-3 rounded-lg border border-green-200 shadow-sm flex items-center">
                    <div class="mr-3 text-right">
                        <span class="block text-[10px] uppercase text-green-800 font-bold tracking-wider">Fraud Savings (30d)</span>
                        <span class="text-lg font-bold text-green-600">Rs. 1.2M</span>
                    </div>
                    <div class="w-10 h-10 rounded-full bg-green-100 flex items-center justify-center text-green-500">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                </div>
                <button class="bg-[rgb(var(--brand-primary))] text-white px-4 py-2 rounded text-sm font-semibold hover:bg-[rgb(var(--brand-secondary))] transition-colors shadow-sm">
                    Configure Promo Rules
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
                <a href="#" class="border-b-2 border-[rgb(var(--brand-primary))] text-[rgb(var(--brand-primary))] py-3 px-4 font-semibold text-sm transition-colors whitespace-nowrap">
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

        <div class="grid grid-cols-1 xl:grid-cols-4 gap-6">
            
            <div class="xl:col-span-1 space-y-6">
                
                <div class="bg-[rgb(var(--bg-card))] p-5 rounded-lg shadow-sm border border-[rgb(var(--border-color))] transition-colors duration-300">
                    <h3 class="text-md font-semibold text-[rgb(var(--text-main))] mb-4">Referral Graph Analysis</h3>
                    
                    <div class="flex items-center justify-center p-4 bg-[rgb(var(--item-active-bg))] border border-[rgb(var(--border-color))] rounded-lg mb-4">
                        <div class="relative w-full h-24 flex items-center justify-between">
                            <div class="w-10 h-10 rounded-full bg-[rgb(var(--brand-primary))] text-white flex items-center justify-center text-xs font-bold z-10">A</div>
                            <div class="absolute w-full h-0.5 bg-red-400 top-1/2 left-0 transform -translate-y-1/2"></div>
                            <div class="w-10 h-10 rounded-full bg-[rgb(var(--bg-card))] border-2 border-red-500 text-red-600 flex items-center justify-center text-xs font-bold z-10">B</div>
                            <div class="w-10 h-10 rounded-full bg-[rgb(var(--bg-card))] border-2 border-red-500 text-red-600 flex items-center justify-center text-xs font-bold z-10">C</div>
                            <span class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-6 bg-red-100 text-red-700 px-2 py-0.5 rounded text-[8px] font-bold uppercase">Same Device ID</span>
                        </div>
                    </div>
                    
                    <p class="text-[10px] text-[rgb(var(--text-muted))] mb-2">Automated mapping of referral networks to detect self-referral rings and fake account generation.</p>
                    <button class="w-full text-xs bg-[rgb(var(--item-active-bg))] border border-[rgb(var(--border-color))] text-[rgb(var(--text-main))] py-1.5 rounded hover:bg-[rgb(var(--bg-body))] transition-colors">
                        View Full Graph Explorer
                    </button>
                </div>

                <div class="bg-[rgb(var(--bg-card))] p-5 rounded-lg shadow-sm border border-[rgb(var(--border-color))] transition-colors duration-300">
                    <h3 class="text-md font-semibold text-[rgb(var(--text-main))] mb-3">Promo Abuse Signals</h3>
                    <ul class="space-y-3">
                        <li class="flex justify-between items-center text-xs">
                            <span class="text-[rgb(var(--text-main))]">Multiple Accs per Device</span>
                            <span class="px-2 py-0.5 bg-red-100 text-red-700 rounded font-bold">Block</span>
                        </li>
                        <li class="flex justify-between items-center text-xs">
                            <span class="text-[rgb(var(--text-main))]">Promo Stacking Attempt</span>
                            <span class="px-2 py-0.5 bg-orange-100 text-orange-700 rounded font-bold">Invalidate</span>
                        </li>
                        <li class="flex justify-between items-center text-xs">
                            <span class="text-[rgb(var(--text-main))]">New User Promo (Old Card)</span>
                            <span class="px-2 py-0.5 bg-red-100 text-red-700 rounded font-bold">Reject</span>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="xl:col-span-3">
                <div class="bg-[rgb(var(--bg-card))] rounded-lg shadow-sm border border-[rgb(var(--border-color))] overflow-hidden transition-colors duration-300">
                    <div class="px-6 py-4 border-b border-[rgb(var(--border-color))] bg-[rgb(var(--item-active-bg))] flex justify-between items-center">
                        <div>
                            <h3 class="text-lg font-semibold text-[rgb(var(--text-main))]">Live Incentive Abuse Monitor</h3>
                            <p class="text-xs text-[rgb(var(--text-muted))]">Real-time evaluation of promo code applications and referral bonuses.</p>
                        </div>
                        <select class="text-sm border-[rgb(var(--border-color))] bg-[rgb(var(--bg-card))] text-[rgb(var(--text-main))] rounded-md py-1.5 px-3 focus:ring-[rgb(var(--brand-primary))]">
                            <option>Filter: Blocked Attempts</option>
                            <option>Filter: Clawbacks</option>
                            <option>Filter: All</option>
                        </select>
                    </div>
                    
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-[rgb(var(--border-color))]">
                            <thead class="bg-[rgb(var(--bg-card))]">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-[rgb(var(--text-muted))] uppercase tracking-wider">Entity & Action</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-[rgb(var(--text-muted))] uppercase tracking-wider">Promo / Incentive Details</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-[rgb(var(--text-muted))] uppercase tracking-wider">Risk Evaluation</th>
                                    <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-[rgb(var(--text-muted))] uppercase tracking-wider">System Action</th>
                                </tr>
                            </thead>
                            <tbody class="bg-[rgb(var(--bg-card))] divide-y divide-[rgb(var(--border-color))]">
                                
                                <tr class="hover:bg-[rgb(var(--item-active-bg))] transition-colors bg-red-50/10">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-bold text-[rgb(var(--text-main))]">Customer #C-9921</div>
                                        <div class="text-[10px] text-[rgb(var(--text-muted))] mt-1">Target: Customer #C-9922</div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center">
                                            <span class="text-xs font-mono bg-blue-50 text-blue-700 px-2 py-0.5 rounded border border-blue-200">REF-ALI-123</span>
                                        </div>
                                        <div class="text-[10px] text-[rgb(var(--text-main))] mt-1">Referral Bonus (Rs. 500)</div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-[10px] text-red-600 font-bold uppercase mb-1">Self-Referral Detected</div>
                                        <div class="text-[10px] text-[rgb(var(--text-muted))]">Inviter and Invitee share the exact same Device Hash & IP Address.</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right">
                                        <span class="px-2 py-1 bg-red-600 text-white rounded text-xs font-bold shadow-sm inline-block mb-1">
                                            Promo Invalidated
                                        </span>
                                        <div class="flex justify-end space-x-1 mt-1">
                                            <button class="text-[10px] text-[rgb(var(--brand-primary))] hover:underline">Restrict Acc</button>
                                        </div>
                                    </td>
                                </tr>

                                <tr class="hover:bg-[rgb(var(--item-active-bg))] transition-colors">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-bold text-[rgb(var(--text-main))]">Provider #P-105</div>
                                        <div class="text-[10px] text-[rgb(var(--text-muted))] mt-1">Job ID: #JOB-5541</div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center">
                                            <span class="text-xs font-mono bg-green-50 text-green-700 px-2 py-0.5 rounded border border-green-200">FIRST-JOB-BONUS</span>
                                        </div>
                                        <div class="text-[10px] text-[rgb(var(--text-main))] mt-1">Onboarding Incentive (Rs. 1000)</div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-[10px] text-orange-600 font-bold uppercase mb-1">Fake Interaction</div>
                                        <div class="text-[10px] text-[rgb(var(--text-muted))]">Job completed in 2 minutes. Customer & Provider geo-locations matched perfectly before booking.</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right">
                                        <span class="px-2 py-1 bg-orange-100 text-orange-800 border border-orange-200 rounded text-xs font-bold inline-block mb-1">
                                            Reward Clawback
                                        </span>
                                        <p class="text-[10px] text-[rgb(var(--text-muted))]">Wallet Deducted (-Rs. 1000)</p>
                                    </td>
                                </tr>

                                <tr class="hover:bg-[rgb(var(--item-active-bg))] transition-colors">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-bold text-[rgb(var(--text-main))]">Customer #C-554</div>
                                        <div class="text-[10px] text-[rgb(var(--text-muted))] mt-1">Checkout Event</div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex flex-col gap-1 items-start">
                                            <span class="text-xs font-mono bg-gray-100 text-gray-700 px-2 py-0.5 rounded border border-gray-300">WELCOME50</span>
                                            <span class="text-xs font-mono bg-gray-100 text-gray-700 px-2 py-0.5 rounded border border-gray-300">FREE-DEL</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-[10px] text-yellow-600 font-bold uppercase mb-1">Promo Stacking</div>
                                        <div class="text-[10px] text-[rgb(var(--text-muted))]">Attempted to apply multiple mutually exclusive discount codes via API manipulation.</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right">
                                        <span class="px-2 py-1 bg-gray-200 text-gray-800 border border-gray-300 rounded text-xs font-bold inline-block mb-1">
                                            Promo Dropped
                                        </span>
                                        <p class="text-[10px] text-[rgb(var(--text-muted))]">Checkout Reset to Standard</p>
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