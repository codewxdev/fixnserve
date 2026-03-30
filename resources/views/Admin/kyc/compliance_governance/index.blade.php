@extends('layouts.app')

@section('content')

<div class="min-h-screen bg-[rgb(var(--bg-body))] font-sans transition-colors duration-300">
    <div class="container mx-auto px-4 py-8">

        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 border-b border-[rgb(var(--border-color))] pb-4">
            <div>
                <h1 class="text-3xl font-bold text-[rgb(var(--text-main))] transition-colors">Compliance & Governance</h1>
                <p class="text-sm text-[rgb(var(--text-muted))] mt-1 transition-colors">Auditability, Legal Defensibility, and Regulatory Readiness</p>
            </div>
            
            <div class="mt-4 md:mt-0 flex space-x-3">
                <button class="bg-[rgb(var(--bg-card))] border border-[rgb(var(--border-color))] text-[rgb(var(--text-main))] px-4 py-2 rounded text-sm font-semibold hover:bg-[rgb(var(--item-active-bg))] transition-colors flex items-center">
                    <svg class="w-4 h-4 mr-2 text-[rgb(var(--text-muted))]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    Export Audit Logs
                </button>
            </div>
        </div>

        <div class="mb-6">
            <nav class="flex space-x-4 border-b border-[rgb(var(--border-color))] overflow-x-auto">
                <a href="#" class="border-b-2 border-transparent text-[rgb(var(--text-muted))] hover:text-[rgb(var(--text-main))] py-3 px-4 font-medium text-sm transition-colors whitespace-nowrap">
                    5.1 Document Management
                </a>
                <a href="#" class="border-b-2 border-transparent text-[rgb(var(--text-muted))] hover:text-[rgb(var(--text-main))] py-3 px-4 font-medium text-sm transition-colors whitespace-nowrap">
                    5.2 AI Verification
                </a>
                <a href="#" class="border-b-2 border-transparent text-[rgb(var(--text-muted))] hover:text-[rgb(var(--text-main))] py-3 px-4 font-medium text-sm transition-colors whitespace-nowrap">
                    5.3 Orchestration Engine
                </a>
                <a href="#" class="border-b-2 border-transparent text-[rgb(var(--text-muted))] hover:text-[rgb(var(--text-main))] py-3 px-4 font-medium text-sm transition-colors whitespace-nowrap">
                    5.4 Entities
                </a>
                <a href="#" class="border-b-2 border-[rgb(var(--brand-primary))] text-[rgb(var(--brand-primary))] py-3 px-4 font-semibold text-sm transition-colors whitespace-nowrap">
                    5.5 Compliance
                </a>
            </nav>
        </div>

        <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">
            
            <div class="xl:col-span-2 space-y-6">
                
                <div class="bg-[rgb(var(--bg-card))] rounded-lg shadow-sm border border-[rgb(var(--border-color))] overflow-hidden transition-colors duration-300">
                    <div class="px-6 py-4 border-b border-[rgb(var(--border-color))] bg-[rgb(var(--item-active-bg))] flex justify-between items-center">
                        <h3 class="text-lg font-semibold text-[rgb(var(--text-main))]">Compliance Action Center</h3>
                        <div class="flex space-x-2">
                            <select class="text-xs border-[rgb(var(--border-color))] bg-[rgb(var(--bg-card))] text-[rgb(var(--text-main))] rounded-md shadow-sm py-1 px-2 focus:ring-[rgb(var(--brand-primary))] focus:border-[rgb(var(--brand-primary))]">
                                <option>All Jurisdictions</option>
                                <option>UAE (High Priority)</option>
                                <option>Pakistan</option>
                                <option>UK</option>
                            </select>
                            <select class="text-xs border-[rgb(var(--border-color))] bg-[rgb(var(--bg-card))] text-[rgb(var(--text-main))] rounded-md shadow-sm py-1 px-2 focus:ring-[rgb(var(--brand-primary))] focus:border-[rgb(var(--brand-primary))]">
                                <option>Filter: Escalated</option>
                                <option>Filter: Non-Compliant</option>
                                <option>Filter: Re-verification Due</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-[rgb(var(--border-color))]">
                            <thead class="bg-[rgb(var(--bg-card))]">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-[rgb(var(--text-muted))] uppercase tracking-wider">Entity Details</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-[rgb(var(--text-muted))] uppercase tracking-wider">Compliance Status</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-[rgb(var(--text-muted))] uppercase tracking-wider">Jurisdiction / Flags</th>
                                    <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-[rgb(var(--text-muted))] uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-[rgb(var(--bg-card))] divide-y divide-[rgb(var(--border-color))]">
                                
                                <tr class="hover:bg-[rgb(var(--item-active-bg))] transition-colors bg-red-50/20">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-[rgb(var(--text-main))]">Global Medics LLC</div>
                                        <div class="text-xs text-[rgb(var(--text-muted))]">Consultant #C-5012</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded bg-red-100 text-red-800">
                                            Non-Compliant
                                        </span>
                                        <div class="text-[10px] text-[rgb(var(--text-muted))] mt-1">License Expired 2 days ago</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center text-sm text-[rgb(var(--text-main))]">
                                            <span class="mr-2">🇦🇪</span> UAE
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-2">
                                        <button class="text-red-600 hover:text-red-900 border border-red-200 bg-red-50 px-3 py-1 rounded text-xs font-bold">Lock Entity</button>
                                        <button class="text-[rgb(var(--brand-primary))] hover:text-[rgb(var(--brand-secondary))] px-3 py-1 text-xs font-bold">Override</button>
                                    </td>
                                </tr>

                                <tr class="hover:bg-[rgb(var(--item-active-bg))] transition-colors">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-[rgb(var(--text-main))]">Ahmed Raza</div>
                                        <div class="text-xs text-[rgb(var(--text-muted))]">Rider #R-342</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded bg-yellow-100 text-yellow-800">
                                            Re-verification Pending
                                        </span>
                                        <div class="text-[10px] text-[rgb(var(--text-muted))] mt-1">Risk score increased</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center text-sm text-[rgb(var(--text-main))]">
                                            <span class="mr-2">🇵🇰</span> Pakistan
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-2">
                                        <button class="text-yellow-600 hover:text-yellow-900 border border-yellow-200 bg-yellow-50 px-3 py-1 rounded text-xs font-bold">Trigger KYC</button>
                                        <button class="text-[rgb(var(--text-main))] hover:text-[rgb(var(--brand-primary))] px-3 py-1 text-xs font-bold">Escalate</button>
                                    </td>
                                </tr>

                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="bg-[rgb(var(--bg-card))] p-6 rounded-lg shadow-sm border border-[rgb(var(--border-color))] transition-colors duration-300">
                    <h3 class="text-lg font-semibold text-[rgb(var(--text-main))] mb-2">Manual Decision Overrides</h3>
                    <p class="text-sm text-[rgb(var(--text-muted))] mb-4">Any override of an AI or Provider decision requires mandatory justification and compliance team approval.</p>
                    
                    <div class="p-4 bg-[rgb(var(--item-active-bg))] border border-[rgb(var(--border-color))] rounded-lg">
                        <label class="block text-sm font-medium text-[rgb(var(--text-main))] mb-1">Justification for overriding "Global Medics LLC"</label>
                        <textarea class="w-full border-[rgb(var(--border-color))] bg-[rgb(var(--bg-card))] text-[rgb(var(--text-main))] rounded-md shadow-sm focus:ring-[rgb(var(--brand-primary))] focus:border-[rgb(var(--brand-primary))] text-sm p-2 mb-3" rows="3" placeholder="Enter legal or operational rationale..."></textarea>
                        <button class="bg-[rgb(var(--text-main))] text-[rgb(var(--bg-card))] px-4 py-2 rounded text-sm font-semibold hover:opacity-90 transition-opacity">
                            Submit Override Log
                        </button>
                    </div>
                </div>
            </div>

            <div class="xl:col-span-1 space-y-6">
                <div class="bg-[rgb(var(--bg-card))] rounded-lg shadow-sm border border-[rgb(var(--border-color))] transition-colors duration-300 h-full">
                    <div class="px-6 py-4 border-b border-[rgb(var(--border-color))]">
                        <h3 class="text-lg font-semibold text-[rgb(var(--text-main))]">KYC Audit Trail</h3>
                        <p class="text-[10px] text-[rgb(var(--text-muted))] uppercase tracking-widest mt-1">Immutable Logs</p>
                    </div>
                    
                    <div class="p-6">
                        <div class="relative border-l border-[rgb(var(--border-color))] ml-3 space-y-6">
                            
                            <div class="mb-6 ml-6 relative">
                                <span class="absolute -left-8 top-1 flex items-center justify-center w-4 h-4 rounded-full bg-red-100 ring-4 ring-[rgb(var(--bg-card))] border border-red-500"></span>
                                <div class="flex justify-between items-start mb-1">
                                    <h4 class="text-sm font-bold text-[rgb(var(--text-main))]">Entity Locked</h4>
                                    <span class="text-[10px] text-[rgb(var(--text-muted))] font-mono">10:14 AM</span>
                                </div>
                                <p class="text-xs text-[rgb(var(--text-muted))] mb-1">Target: <span class="font-semibold text-[rgb(var(--text-main))]">Consultant #C-5012</span></p>
                                <div class="bg-[rgb(var(--item-active-bg))] p-2 rounded border border-[rgb(var(--border-color))] mt-2">
                                    <p class="text-[10px] text-[rgb(var(--text-muted))]"><span class="font-bold text-[rgb(var(--text-main))]">Actor:</span> System (Auto-action)</p>
                                    <p class="text-[10px] text-[rgb(var(--text-muted))] mt-1"><span class="font-bold text-[rgb(var(--text-main))]">Rationale:</span> Non-compliance detected. Professional license expired for >48 hours.</p>
                                </div>
                            </div>

                            <div class="mb-6 ml-6 relative">
                                <span class="absolute -left-8 top-1 flex items-center justify-center w-4 h-4 rounded-full bg-blue-100 ring-4 ring-[rgb(var(--bg-card))] border border-blue-500"></span>
                                <div class="flex justify-between items-start mb-1">
                                    <h4 class="text-sm font-bold text-[rgb(var(--text-main))]">Decision Override</h4>
                                    <span class="text-[10px] text-[rgb(var(--text-muted))] font-mono">Yesterday, 14:30</span>
                                </div>
                                <p class="text-xs text-[rgb(var(--text-muted))] mb-1">Target: <span class="font-semibold text-[rgb(var(--text-main))]">Vendor #V-882</span></p>
                                <div class="bg-[rgb(var(--item-active-bg))] p-2 rounded border border-[rgb(var(--border-color))] mt-2">
                                    <p class="text-[10px] text-[rgb(var(--text-muted))]"><span class="font-bold text-[rgb(var(--text-main))]">Actor:</span> Sarah J. (Compliance Lead ID: 992)</p>
                                    <p class="text-[10px] text-[rgb(var(--text-muted))] mt-1"><span class="font-bold text-[rgb(var(--text-main))]">Rationale:</span> OCR failed due to glare, but document manually verified as authentic against state registry.</p>
                                    <a href="#" class="text-[10px] text-[rgb(var(--brand-primary))] mt-1 inline-block hover:underline">View Evidence Snapshot</a>
                                </div>
                            </div>

                            <div class="mb-6 ml-6 relative">
                                <span class="absolute -left-8 top-1 flex items-center justify-center w-4 h-4 rounded-full bg-green-100 ring-4 ring-[rgb(var(--bg-card))] border border-green-500"></span>
                                <div class="flex justify-between items-start mb-1">
                                    <h4 class="text-sm font-bold text-[rgb(var(--text-main))]">Re-verification Triggered</h4>
                                    <span class="text-[10px] text-[rgb(var(--text-muted))] font-mono">Yesterday, 09:00</span>
                                </div>
                                <p class="text-xs text-[rgb(var(--text-muted))] mb-1">Target: <span class="font-semibold text-[rgb(var(--text-main))]">Rider #R-342</span></p>
                                <div class="bg-[rgb(var(--item-active-bg))] p-2 rounded border border-[rgb(var(--border-color))] mt-2">
                                    <p class="text-[10px] text-[rgb(var(--text-muted))]"><span class="font-bold text-[rgb(var(--text-main))]">Actor:</span> Risk Engine</p>
                                    <p class="text-[10px] text-[rgb(var(--text-muted))] mt-1"><span class="font-bold text-[rgb(var(--text-main))]">Rationale:</span> Behavioral anomaly flag triggered from dispatch module. Requiring new liveness check.</p>
                                </div>
                            </div>
                        </div>
                        <button class="w-full mt-4 text-xs text-[rgb(var(--brand-primary))] font-semibold hover:text-[rgb(var(--brand-secondary))] text-center py-2 border border-transparent hover:border-[rgb(var(--brand-primary))] rounded transition-colors">
                            Load Older Logs
                        </button>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection