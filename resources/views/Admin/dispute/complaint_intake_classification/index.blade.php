@extends('layouts.app')

@section('content')

<div class="min-h-screen bg-[rgb(var(--bg-body))] font-sans transition-colors duration-300">
    <div class="container mx-auto px-4 py-8">

        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 border-b border-[rgb(var(--border-color))] pb-4">
            <div>
                <h1 class="text-3xl font-bold text-[rgb(var(--text-main))] transition-colors">Disputes, Refunds & Appeals</h1>
                <p class="text-sm text-[rgb(var(--text-muted))] mt-1 transition-colors">AI-Assisted Resolution, Financial Protection & Legal Governance</p>
            </div>
            
            <div class="mt-4 md:mt-0 flex space-x-3">
                <div class="bg-red-50 p-2 px-4 rounded-lg border border-red-200 shadow-sm flex items-center">
                    <div class="mr-3 text-right">
                        <span class="block text-[10px] uppercase text-red-800 font-bold tracking-wider">SLA Risk</span>
                        <span class="text-lg font-bold text-red-600">12 Breaching Soon</span>
                    </div>
                </div>
                <div class="bg-[rgb(var(--bg-card))] p-2 px-4 rounded-lg border border-[rgb(var(--border-color))] shadow-sm flex items-center">
                    <div class="mr-3 text-right">
                        <span class="block text-[10px] uppercase text-[rgb(var(--text-muted))] font-bold tracking-wider">Unassigned Intake</span>
                        <span class="text-lg font-bold text-[rgb(var(--brand-primary))]">45 New</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="mb-6">
            <nav class="flex space-x-4 border-b border-[rgb(var(--border-color))] overflow-x-auto pb-1">
                <a href="#" class="border-b-2 border-[rgb(var(--brand-primary))] text-[rgb(var(--brand-primary))] py-3 px-4 font-semibold text-sm transition-colors whitespace-nowrap">
                    14.1 Intake & Classification
                </a>
                <a href="#" class="border-b-2 border-transparent text-[rgb(var(--text-muted))] hover:text-[rgb(var(--text-main))] py-3 px-4 font-medium text-sm transition-colors whitespace-nowrap">
                    14.2 Evidence Context
                </a>
                <a href="#" class="border-b-2 border-transparent text-[rgb(var(--text-muted))] hover:text-[rgb(var(--text-main))] py-3 px-4 font-medium text-sm transition-colors whitespace-nowrap">
                    14.3 AI Triage
                </a>
                <a href="#" class="border-b-2 border-transparent text-[rgb(var(--text-muted))] hover:text-[rgb(var(--text-main))] py-3 px-4 font-medium text-sm transition-colors whitespace-nowrap">
                    14.4 Refund Engine
                </a>
                <a href="#" class="border-b-2 border-transparent text-[rgb(var(--text-muted))] hover:text-[rgb(var(--text-main))] py-3 px-4 font-medium text-sm transition-colors whitespace-nowrap">
                    14.5 Appeals
                </a>
                <a href="#" class="border-b-2 border-transparent text-[rgb(var(--text-muted))] hover:text-[rgb(var(--text-main))] py-3 px-4 font-medium text-sm transition-colors whitespace-nowrap">
                    14.6 SLA & Escalation
                </a>
                <a href="#" class="border-b-2 border-transparent text-[rgb(var(--text-muted))] hover:text-[rgb(var(--text-main))] py-3 px-4 font-medium text-sm transition-colors whitespace-nowrap">
                    14.7 Abuse Policy
                </a>
                <a href="#" class="border-b-2 border-transparent text-[rgb(var(--text-muted))] hover:text-[rgb(var(--text-main))] py-3 px-4 font-medium text-sm transition-colors whitespace-nowrap">
                    14.8 Legal & Compliance
                </a>
            </nav>
        </div>

        <div class="grid grid-cols-1 xl:grid-cols-4 gap-6">
            
            <div class="xl:col-span-1 space-y-6">
                
                <div class="bg-[rgb(var(--bg-card))] p-5 rounded-lg shadow-sm border border-[rgb(var(--border-color))] transition-colors duration-300">
                    <h3 class="text-md font-semibold text-[rgb(var(--text-main))] mb-1">Manual Complaint Intake</h3>
                    <p class="text-[10px] text-[rgb(var(--text-muted))] mb-4">Log a dispute on behalf of a user via phone or email channel.</p>
                    
                    <form action="#" method="POST">
                        <div class="space-y-4">
                            <div>
                                <label class="block text-xs font-bold text-[rgb(var(--text-main))] mb-1">Source / Reporter</label>
                                <select class="w-full text-sm border-[rgb(var(--border-color))] bg-[rgb(var(--bg-card))] text-[rgb(var(--text-main))] rounded-md py-2 px-3 focus:ring-[rgb(var(--brand-primary))]">
                                    <option>Customer (Phone)</option>
                                    <option>Provider / Vendor</option>
                                    <option>Rider</option>
                                </select>
                            </div>
                            
                            <div>
                                <label class="block text-xs font-bold text-[rgb(var(--text-main))] mb-1">Related Entity ID (Order/Job)</label>
                                <input type="text" placeholder="e.g. ORD-1092" class="w-full text-sm border-[rgb(var(--border-color))] bg-[rgb(var(--bg-card))] text-[rgb(var(--text-main))] rounded-md py-2 px-3 focus:ring-[rgb(var(--brand-primary))]">
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-[rgb(var(--text-main))] mb-1">Manual Classification</label>
                                <select class="w-full text-sm border-[rgb(var(--border-color))] bg-[rgb(var(--bg-card))] text-[rgb(var(--text-main))] rounded-md py-2 px-3 focus:ring-[rgb(var(--brand-primary))]">
                                    <option>Service Quality</option>
                                    <option>Delivery Issues</option>
                                    <option>Payment Issues</option>
                                    <option>Fraud Allegations</option>
                                    <option>Behavior / Misconduct</option>
                                    <option>System Failure</option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-[rgb(var(--text-main))] mb-1">Initial Notes</label>
                                <textarea rows="3" placeholder="Brief description of the issue..." class="w-full text-sm border-[rgb(var(--border-color))] bg-[rgb(var(--bg-card))] text-[rgb(var(--text-main))] rounded-md py-2 px-3 focus:ring-[rgb(var(--brand-primary))]"></textarea>
                            </div>

                            <button type="submit" class="w-full bg-[rgb(var(--brand-primary))] text-white font-semibold py-2 px-4 rounded text-sm hover:bg-[rgb(var(--brand-secondary))] transition-colors">
                                Generate Case ID
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="xl:col-span-3">
                <div class="bg-[rgb(var(--bg-card))] rounded-lg shadow-sm border border-[rgb(var(--border-color))] overflow-hidden transition-colors duration-300">
                    <div class="px-6 py-4 border-b border-[rgb(var(--border-color))] bg-[rgb(var(--item-active-bg))] flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                        <div>
                            <h3 class="text-lg font-semibold text-[rgb(var(--text-main))]">Auto-Classification Priority Queue</h3>
                            <p class="text-xs text-[rgb(var(--text-muted))]">Incoming disputes normalized and prioritized by AI severity rules.</p>
                        </div>
                        <div class="flex space-x-2">
                            <select class="text-xs border-[rgb(var(--border-color))] bg-[rgb(var(--bg-card))] text-[rgb(var(--text-main))] rounded-md py-1.5 px-2 focus:ring-[rgb(var(--brand-primary))]">
                                <option>Sort: SLA Urgency</option>
                                <option>Sort: Severity (High to Low)</option>
                                <option>Sort: Newest</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-[rgb(var(--border-color))]">
                            <thead class="bg-[rgb(var(--bg-card))]">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-[rgb(var(--text-muted))] uppercase tracking-wider">Source & Intake Time</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-[rgb(var(--text-muted))] uppercase tracking-wider">Auto-Classification</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-[rgb(var(--text-muted))] uppercase tracking-wider">Severity & SLA</th>
                                    <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-[rgb(var(--text-muted))] uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-[rgb(var(--bg-card))] divide-y divide-[rgb(var(--border-color))]">
                                
                                <tr class="hover:bg-[rgb(var(--item-active-bg))] transition-colors bg-red-50/10">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="mr-3 text-red-500">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg> </div>
                                            <div>
                                                <div class="text-sm font-bold text-[rgb(var(--text-main))]">Auto-Generated</div>
                                                <div class="text-[10px] text-[rgb(var(--text-muted))] mt-0.5">10 mins ago • System Event</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="text-xs font-bold text-red-700 bg-red-100 px-2 py-0.5 rounded border border-red-200">Fraud Allegations</span>
                                        <p class="text-[10px] text-[rgb(var(--text-muted))] mt-1">Dispute Reason: Unrecognized Charge (Module 13 Sync)</p>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-xs font-black text-red-600 uppercase mb-1">Critical</div>
                                        <div class="text-[10px] font-bold text-[rgb(var(--text-main))] flex items-center">
                                            <svg class="w-3 h-3 mr-1 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                            SLA: 30 mins left
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right">
                                        <button class="bg-[rgb(var(--brand-primary))] text-white px-3 py-1.5 rounded text-xs font-bold shadow-sm hover:bg-[rgb(var(--brand-secondary))]">
                                            Create Case
                                        </button>
                                    </td>
                                </tr>

                                <tr class="hover:bg-[rgb(var(--item-active-bg))] transition-colors">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="mr-3 text-[rgb(var(--brand-primary))]">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg> </div>
                                            <div>
                                                <div class="text-sm font-bold text-[rgb(var(--text-main))]">Customer App</div>
                                                <div class="text-[10px] text-[rgb(var(--text-muted))] mt-0.5">25 mins ago • User: C-199</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="text-xs font-bold text-orange-700 bg-orange-100 px-2 py-0.5 rounded border border-orange-200">Delivery Issues</span>
                                        <p class="text-[10px] text-[rgb(var(--text-muted))] mt-1">Dispute Reason: "Order marked delivered but not received."</p>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-xs font-bold text-orange-600 uppercase mb-1">High</div>
                                        <div class="text-[10px] font-bold text-[rgb(var(--text-main))] flex items-center">
                                            <svg class="w-3 h-3 mr-1 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                            SLA: 1h 45m left
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right">
                                        <button class="bg-[rgb(var(--bg-card))] border border-[rgb(var(--border-color))] text-[rgb(var(--text-main))] px-3 py-1.5 rounded text-xs font-bold shadow-sm hover:bg-[rgb(var(--item-active-bg))]">
                                            Create Case
                                        </button>
                                    </td>
                                </tr>

                                <tr class="hover:bg-[rgb(var(--item-active-bg))] transition-colors">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="mr-3 text-blue-500">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg> </div>
                                            <div>
                                                <div class="text-sm font-bold text-[rgb(var(--text-main))]">Provider App</div>
                                                <div class="text-[10px] text-[rgb(var(--text-muted))] mt-0.5">1 hr ago • User: P-44</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="text-xs font-bold text-blue-700 bg-blue-100 px-2 py-0.5 rounded border border-blue-200">Behavior / Misconduct</span>
                                        <p class="text-[10px] text-[rgb(var(--text-muted))] mt-1">Dispute Reason: Customer refused to pay post-service.</p>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-xs font-bold text-yellow-600 uppercase mb-1">Medium</div>
                                        <div class="text-[10px] font-bold text-[rgb(var(--text-main))] flex items-center">
                                            <svg class="w-3 h-3 mr-1 text-[rgb(var(--text-muted))]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                            SLA: 22h left
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right">
                                        <button class="bg-[rgb(var(--bg-card))] border border-[rgb(var(--border-color))] text-[rgb(var(--text-main))] px-3 py-1.5 rounded text-xs font-bold shadow-sm hover:bg-[rgb(var(--item-active-bg))]">
                                            Create Case
                                        </button>
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