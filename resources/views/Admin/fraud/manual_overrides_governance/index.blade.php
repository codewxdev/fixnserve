@extends('layouts.app')

@section('content')

<div class="min-h-screen bg-[rgb(var(--bg-body))] font-sans transition-colors duration-300">
    <div class="container mx-auto px-4 py-8">

        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 border-b border-[rgb(var(--border-color))] pb-4">
            <div>
                <h1 class="text-3xl font-bold text-[rgb(var(--text-main))] transition-colors">Manual Overrides & Governance</h1>
                <p class="text-sm text-[rgb(var(--text-muted))] mt-1 transition-colors">Human intervention controls with dual approval and immutable accountability</p>
            </div>
            
            <div class="mt-4 md:mt-0 flex space-x-3">
                <button class="bg-[rgb(var(--bg-card))] border border-[rgb(var(--border-color))] text-[rgb(var(--text-main))] px-4 py-2 rounded text-sm font-semibold hover:bg-[rgb(var(--item-active-bg))] transition-colors flex items-center shadow-sm">
                    <svg class="w-4 h-4 mr-2 text-[rgb(var(--text-muted))]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    Export Immutable Log
                </button>
                <button class="bg-[rgb(var(--brand-primary))] text-white px-4 py-2 rounded text-sm font-semibold hover:bg-[rgb(var(--brand-secondary))] transition-colors shadow-sm">
                    Initiate Override Request
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
                <a href="#" class="border-b-2 border-transparent text-[rgb(var(--text-muted))] hover:text-[rgb(var(--text-main))] py-3 px-4 font-medium text-sm transition-colors whitespace-nowrap">
                    13.5 Collusion Networks
                </a>
                <a href="#" class="border-b-2 border-transparent text-[rgb(var(--text-muted))] hover:text-[rgb(var(--text-main))] py-3 px-4 font-medium text-sm transition-colors whitespace-nowrap">
                    13.6 Enforcement
                </a>
                <a href="#" class="border-b-2 border-[rgb(var(--brand-primary))] text-[rgb(var(--brand-primary))] py-3 px-4 font-semibold text-sm transition-colors whitespace-nowrap">
                    13.7 Overrides
                </a>
            </nav>
        </div> --}}

        <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">
            
            <div class="xl:col-span-1 space-y-6">
                
                <div class="bg-[rgb(var(--bg-card))] p-5 rounded-lg shadow-sm border border-[rgb(var(--border-color))] border-l-4 border-l-yellow-500 transition-colors duration-300">
                    <h3 class="text-md font-semibold text-[rgb(var(--text-main))] mb-1">Pending Dual Approvals</h3>
                    <p class="text-[10px] text-[rgb(var(--text-muted))] mb-4">High-risk overrides requiring secondary senior sign-off.</p>
                    
                    <div class="space-y-4">
                        <div class="p-3 bg-yellow-50 rounded border border-yellow-200">
                            <div class="flex justify-between items-start mb-2">
                                <div>
                                    <span class="text-xs font-bold text-yellow-800">Wallet Unfreeze</span>
                                    <div class="text-[10px] text-[rgb(var(--text-main))] mt-0.5">Target: <span class="font-bold font-mono">V-110</span></div>
                                </div>
                                <span class="text-[10px] text-[rgb(var(--text-muted))] font-mono">14 mins ago</span>
                            </div>
                            <div class="text-[10px] text-yellow-700 bg-[rgb(var(--bg-card))] p-1.5 border border-yellow-200 rounded mb-2">
                                <strong>Reason Code:</strong> EXCP-04 (False Positive)<br>
                                <strong>Requested By:</strong> Agent J. (ID: 412)
                            </div>
                            <div class="flex space-x-2">
                                <button class="flex-1 bg-green-600 text-white text-[10px] py-1 rounded font-bold hover:bg-green-700">Approve</button>
                                <button class="flex-1 bg-red-50 text-red-600 border border-red-200 text-[10px] py-1 rounded font-bold hover:bg-red-100">Reject</button>
                            </div>
                        </div>

                        <div class="p-3 bg-yellow-50 rounded border border-yellow-200">
                            <div class="flex justify-between items-start mb-2">
                                <div>
                                    <span class="text-xs font-bold text-yellow-800">Suspension Rollback</span>
                                    <div class="text-[10px] text-[rgb(var(--text-main))] mt-0.5">Target: <span class="font-bold font-mono">C-4091</span></div>
                                </div>
                                <span class="text-[10px] text-[rgb(var(--text-muted))] font-mono">1 hr ago</span>
                            </div>
                            <div class="text-[10px] text-yellow-700 bg-[rgb(var(--bg-card))] p-1.5 border border-yellow-200 rounded mb-2">
                                <strong>Reason Code:</strong> COMP-01 (Compliance Cleared)<br>
                                <strong>Requested By:</strong> Agent A. (ID: 991)
                            </div>
                            <div class="flex space-x-2">
                                <button class="flex-1 bg-green-600 text-white text-[10px] py-1 rounded font-bold hover:bg-green-700">Approve</button>
                                <button class="flex-1 bg-red-50 text-red-600 border border-red-200 text-[10px] py-1 rounded font-bold hover:bg-red-100">Reject</button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-[rgb(var(--bg-card))] p-5 rounded-lg shadow-sm border border-[rgb(var(--border-color))] transition-colors duration-300">
                    <h3 class="text-md font-semibold text-[rgb(var(--text-main))] mb-3">Override Metrics (24h)</h3>
                    <div class="space-y-3 text-sm">
                        <div class="flex justify-between items-center">
                            <span class="text-[rgb(var(--text-muted))] text-xs">Total Human Overrides</span>
                            <span class="font-bold text-[rgb(var(--text-main))]">12</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-[rgb(var(--text-muted))] text-xs">AI Decisions Retained</span>
                            <span class="font-bold text-green-600">99.1%</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-[rgb(var(--text-muted))] text-xs">Most Common Reason</span>
                            <span class="text-xs font-mono bg-[rgb(var(--item-active-bg))] px-1 rounded text-[rgb(var(--text-main))]">EXCP-04</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="xl:col-span-2 space-y-6">
                
                <div class="bg-[rgb(var(--bg-card))] rounded-lg shadow-sm border border-[rgb(var(--border-color))] overflow-hidden transition-colors duration-300">
                    <div class="px-6 py-4 border-b border-[rgb(var(--border-color))] bg-[rgb(var(--item-active-bg))]">
                        <h3 class="text-lg font-semibold text-[rgb(var(--text-main))]">Execute Action / Override</h3>
                        <p class="text-xs text-[rgb(var(--text-muted))] mt-1">All inputs are logged immutably. High-risk actions will be routed to the dual-approval queue.</p>
                    </div>
                    
                    <div class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                            <div>
                                <label class="block text-xs font-bold text-[rgb(var(--text-main))] mb-1">Target Entity ID</label>
                                <input type="text" placeholder="e.g. C-8812, V-110" class="w-full text-sm border-[rgb(var(--border-color))] bg-[rgb(var(--bg-card))] text-[rgb(var(--text-main))] rounded-md py-2 px-3 focus:ring-[rgb(var(--brand-primary))]">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-[rgb(var(--text-main))] mb-1">Action Type</label>
                                <select class="w-full text-sm border-[rgb(var(--border-color))] bg-[rgb(var(--bg-card))] text-[rgb(var(--text-main))] rounded-md py-2 px-3 focus:ring-[rgb(var(--brand-primary))]">
                                    <option>Select Action...</option>
                                    <option>Manual Unfreeze (Wallet)</option>
                                    <option>Enforcement Rollback (Unsuspend)</option>
                                    <option>Force Allow (Bypass Rules)</option>
                                </select>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                            <div>
                                <label class="block text-xs font-bold text-[rgb(var(--text-main))] mb-1">Mandatory Reason Code</label>
                                <select class="w-full text-sm border-[rgb(var(--border-color))] bg-[rgb(var(--bg-card))] text-[rgb(var(--text-main))] rounded-md py-2 px-3 focus:ring-[rgb(var(--brand-primary))]">
                                    <option>Select Code...</option>
                                    <option>EXCP-04 (Known False Positive)</option>
                                    <option>COMP-01 (Compliance Cleared off-system)</option>
                                    <option>EXEC-99 (Executive Override)</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-[rgb(var(--text-main))] mb-1">Time-Limited Override</label>
                                <select class="w-full text-sm border-[rgb(var(--border-color))] bg-[rgb(var(--bg-card))] text-[rgb(var(--text-main))] rounded-md py-2 px-3 focus:ring-[rgb(var(--brand-primary))]">
                                    <option>Permanent (Requires Dual Approval)</option>
                                    <option>24 Hours</option>
                                    <option>7 Days</option>
                                </select>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="block text-xs font-bold text-[rgb(var(--text-main))] mb-1">Detailed Justification</label>
                            <textarea rows="2" placeholder="Provide detailed operational or legal rationale..." class="w-full text-sm border-[rgb(var(--border-color))] bg-[rgb(var(--bg-card))] text-[rgb(var(--text-main))] rounded-md py-2 px-3 focus:ring-[rgb(var(--brand-primary))]"></textarea>
                        </div>

                        <div class="flex justify-end">
                            <button class="bg-[rgb(var(--brand-primary))] text-white px-6 py-2 rounded text-sm font-semibold hover:bg-[rgb(var(--brand-secondary))] transition-colors shadow-sm">
                                Submit Override Logic
                            </button>
                        </div>
                    </div>
                </div>

                <div class="bg-[rgb(var(--bg-card))] rounded-lg shadow-sm border border-[rgb(var(--border-color))] overflow-hidden transition-colors duration-300">
                    <div class="px-6 py-4 border-b border-[rgb(var(--border-color))] bg-[rgb(var(--item-active-bg))]">
                        <h3 class="text-lg font-semibold text-[rgb(var(--text-main))]">Governance & Override Audit Log</h3>
                        <p class="text-[10px] text-[rgb(var(--text-muted))] mt-1 uppercase tracking-widest">Immutable Records</p>
                    </div>
                    
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-[rgb(var(--border-color))]">
                            <thead class="bg-[rgb(var(--bg-card))]">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-[rgb(var(--text-muted))] uppercase tracking-wider">Time / Actor</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-[rgb(var(--text-muted))] uppercase tracking-wider">Action & Target</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-[rgb(var(--text-muted))] uppercase tracking-wider">Justification</th>
                                    <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-[rgb(var(--text-muted))] uppercase tracking-wider">Sign-off Status</th>
                                </tr>
                            </thead>
                            <tbody class="bg-[rgb(var(--bg-card))] divide-y divide-[rgb(var(--border-color))]">
                                
                                <tr class="hover:bg-[rgb(var(--item-active-bg))] transition-colors">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-[10px] text-[rgb(var(--text-muted))] font-mono mb-1">Today, 09:14 AM</div>
                                        <div class="text-sm font-bold text-[rgb(var(--text-main))]">Sarah J.</div>
                                        <div class="text-[10px] text-[rgb(var(--brand-primary))] mt-1">Role: Comp Lead</div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-xs text-[rgb(var(--text-main))] font-bold mb-1">Force Allow (24h)</div>
                                        <div class="text-[10px] font-mono text-[rgb(var(--text-muted))]">Target: C-8822</div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="text-[10px] bg-gray-200 text-gray-800 px-1 rounded font-mono border border-gray-300">EXCP-04</span>
                                        <p class="text-[10px] text-[rgb(var(--text-muted))] mt-1 line-clamp-2" title="Customer verified physically at head office. Bypassing velocity rules for next 24 hours to allow pending transactions.">Customer verified physically at head office. Bypassing velocity rules...</p>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right">
                                        <span class="px-2 py-1 bg-green-100 text-green-800 rounded text-[10px] font-bold inline-block border border-green-200">
                                            Executed
                                        </span>
                                        <p class="text-[9px] text-[rgb(var(--text-muted))] mt-1">Single Approval Allowed</p>
                                    </td>
                                </tr>

                                <tr class="hover:bg-[rgb(var(--item-active-bg))] transition-colors">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-[10px] text-[rgb(var(--text-muted))] font-mono mb-1">Yesterday, 14:30</div>
                                        <div class="text-sm font-bold text-[rgb(var(--text-main))]">Ali R.</div>
                                        <div class="text-[10px] text-[rgb(var(--text-muted))] mt-1">Role: Risk Agent</div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-xs text-[rgb(var(--text-main))] font-bold mb-1">Wallet Unfreeze</div>
                                        <div class="text-[10px] font-mono text-[rgb(var(--text-muted))]">Target: V-90</div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="text-[10px] bg-gray-200 text-gray-800 px-1 rounded font-mono border border-gray-300">COMP-01</span>
                                        <p class="text-[10px] text-[rgb(var(--text-muted))] mt-1 line-clamp-2">Vendor provided valid trade license and bank statement clearing the AML flag.</p>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right">
                                        <span class="px-2 py-1 bg-green-600 text-white rounded text-[10px] font-bold inline-block shadow-sm">
                                            Dual Approved
                                        </span>
                                        <p class="text-[9px] text-[rgb(var(--text-muted))] mt-1">Co-signed: Manager K.</p>
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