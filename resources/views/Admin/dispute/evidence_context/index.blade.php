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
                <div class="bg-gray-800 p-2 px-4 rounded-lg border border-gray-700 shadow-sm flex items-center">
                    <div class="mr-3 text-right">
                        <span class="block text-[10px] uppercase text-gray-400 font-bold tracking-wider">Active Workspace</span>
                        <span class="text-sm font-bold text-white">Case #DISP-9921</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="mb-6">
            <nav class="flex space-x-4 border-b border-[rgb(var(--border-color))] overflow-x-auto pb-1">
                <a href="#" class="border-b-2 border-transparent text-[rgb(var(--text-muted))] hover:text-[rgb(var(--text-main))] py-3 px-4 font-medium text-sm transition-colors whitespace-nowrap">
                    14.1 Intake & Classification
                </a>
                <a href="#" class="border-b-2 border-[rgb(var(--brand-primary))] text-[rgb(var(--brand-primary))] py-3 px-4 font-semibold text-sm transition-colors whitespace-nowrap">
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

        <div class="bg-[rgb(var(--bg-card))] p-4 rounded-lg shadow-sm border border-[rgb(var(--border-color))] mb-6 flex flex-col md:flex-row justify-between items-start md:items-center transition-colors duration-300">
            <div>
                <div class="flex items-center space-x-3 mb-1">
                    <h2 class="text-xl font-bold text-[rgb(var(--text-main))]">Delivery Never Received</h2>
                    <span class="px-2 py-0.5 bg-orange-100 text-orange-800 text-xs font-bold rounded">High Severity</span>
                </div>
                <p class="text-xs text-[rgb(var(--text-muted))]">Dispute raised by Customer <strong>#C-199</strong> • Assigned to: <strong>Agent M.</strong></p>
            </div>
            <div class="mt-4 md:mt-0 flex space-x-2">
                <button class="bg-[rgb(var(--item-active-bg))] text-[rgb(var(--text-main))] border border-[rgb(var(--border-color))] px-3 py-1.5 rounded text-sm font-semibold hover:bg-[rgb(var(--bg-body))] transition-colors">
                    Share Internally
                </button>
                <button class="bg-[rgb(var(--brand-primary))] text-white px-3 py-1.5 rounded text-sm font-semibold hover:bg-[rgb(var(--brand-secondary))] transition-colors">
                    Proceed to Resolution
                </button>
            </div>
        </div>

        <div class="grid grid-cols-1 xl:grid-cols-4 gap-6">
            
            <div class="xl:col-span-1 space-y-6">
                <div class="bg-[rgb(var(--bg-card))] p-5 rounded-lg shadow-sm border border-[rgb(var(--border-color))] transition-colors duration-300">
                    <h3 class="text-md font-semibold text-[rgb(var(--text-main))] mb-4 border-b border-[rgb(var(--border-color))] pb-2">Contextual Links</h3>
                    
                    <div class="space-y-4">
                        <div>
                            <span class="text-[10px] uppercase text-[rgb(var(--text-muted))] font-bold tracking-wider">Related Order</span>
                            <div class="mt-1 flex justify-between items-center p-2 bg-[rgb(var(--item-active-bg))] border border-[rgb(var(--border-color))] rounded">
                                <span class="text-sm font-bold text-[rgb(var(--brand-primary))] hover:underline cursor-pointer">#ORD-5011</span>
                                <span class="text-xs font-semibold text-green-600">Marked Delivered</span>
                            </div>
                        </div>

                        <div>
                            <span class="text-[10px] uppercase text-[rgb(var(--text-muted))] font-bold tracking-wider">Complainant (Customer)</span>
                            <div class="mt-1 p-2 bg-[rgb(var(--item-active-bg))] border border-[rgb(var(--border-color))] rounded">
                                <div class="flex items-center space-x-2">
                                    <div class="w-6 h-6 rounded-full bg-gray-300 flex items-center justify-center text-[10px] font-bold">AK</div>
                                    <div>
                                        <p class="text-sm font-bold text-[rgb(var(--text-main))]">Ali Khan</p>
                                        <p class="text-[10px] text-[rgb(var(--text-muted))]">Dispute History: 1 in last 6 months</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div>
                            <span class="text-[10px] uppercase text-[rgb(var(--text-muted))] font-bold tracking-wider">Accused (Rider)</span>
                            <div class="mt-1 p-2 bg-[rgb(var(--item-active-bg))] border border-[rgb(var(--border-color))] rounded">
                                <div class="flex items-center space-x-2">
                                    <div class="w-6 h-6 rounded-full bg-blue-200 text-blue-800 flex items-center justify-center text-[10px] font-bold">R</div>
                                    <div>
                                        <p class="text-sm font-bold text-[rgb(var(--text-main))]">Zain (R-992)</p>
                                        <p class="text-[10px] text-red-500 font-semibold">Risk Score: 68 (High)</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="xl:col-span-2">
                <div class="bg-[rgb(var(--bg-card))] rounded-lg shadow-sm border border-[rgb(var(--border-color))] overflow-hidden transition-colors duration-300 h-full">
                    <div class="px-6 py-4 border-b border-[rgb(var(--border-color))] bg-[rgb(var(--item-active-bg))] flex justify-between items-center">
                        <h3 class="text-md font-semibold text-[rgb(var(--text-main))]">Timeline Reconstruction</h3>
                        <span class="text-xs text-[rgb(var(--text-muted))]">Auto-compiled from system logs</span>
                    </div>
                    
                    <div class="p-6">
                        <div class="relative border-l-2 border-gray-200 ml-3 space-y-8">
                            
                            <div class="relative pl-6">
                                <span class="absolute -left-[9px] top-1 w-4 h-4 rounded-full bg-gray-300 ring-4 ring-[rgb(var(--bg-card))]"></span>
                                <div class="flex justify-between items-start">
                                    <h4 class="text-sm font-bold text-[rgb(var(--text-main))]">Order Placed</h4>
                                    <span class="text-[10px] text-[rgb(var(--text-muted))] font-mono">18:42 PM</span>
                                </div>
                                <p class="text-xs text-[rgb(var(--text-muted))] mt-1">Payment method: Credit Card (Authorized)</p>
                            </div>

                            <div class="relative pl-6">
                                <span class="absolute -left-[9px] top-1 w-4 h-4 rounded-full bg-blue-400 ring-4 ring-[rgb(var(--bg-card))]"></span>
                                <div class="flex justify-between items-start">
                                    <h4 class="text-sm font-bold text-[rgb(var(--text-main))]">In-App Chat (Customer & Rider)</h4>
                                    <span class="text-[10px] text-[rgb(var(--text-muted))] font-mono">19:15 PM</span>
                                </div>
                                <div class="mt-2 p-3 bg-blue-50 border border-blue-100 rounded text-xs space-y-2">
                                    <div class="flex flex-col">
                                        <span class="font-bold text-blue-800">Rider:</span>
                                        <span class="text-gray-700">Main gate pe khara hu, location same nahi hai.</span>
                                    </div>
                                    <div class="flex flex-col">
                                        <span class="font-bold text-gray-800">Customer:</span>
                                        <span class="text-gray-700">Bhai location exactly pin par hai, main bahar aa raha hu.</span>
                                    </div>
                                </div>
                            </div>

                            <div class="relative pl-6">
                                <span class="absolute -left-[9px] top-1 w-4 h-4 rounded-full bg-orange-500 ring-4 ring-[rgb(var(--bg-card))]"></span>
                                <div class="flex justify-between items-start">
                                    <h4 class="text-sm font-bold text-orange-600">GPS Trace Anomaly Flagged</h4>
                                    <span class="text-[10px] text-[rgb(var(--text-muted))] font-mono">19:20 PM</span>
                                </div>
                                <p class="text-xs text-[rgb(var(--text-main))] mt-1 font-medium bg-orange-50 p-2 rounded border border-orange-200">
                                    System detected Rider marked order as "Delivered" while 1.2 KM away from the customer's pinned location.
                                </p>
                            </div>

                            <div class="relative pl-6">
                                <span class="absolute -left-[9px] top-1 w-4 h-4 rounded-full bg-red-500 ring-4 ring-[rgb(var(--bg-card))]"></span>
                                <div class="flex justify-between items-start">
                                    <h4 class="text-sm font-bold text-[rgb(var(--text-main))]">Customer Raised Dispute</h4>
                                    <span class="text-[10px] text-[rgb(var(--text-muted))] font-mono">19:25 PM</span>
                                </div>
                                <p class="text-xs text-[rgb(var(--text-muted))] mt-1">Via Customer App. Claim: "Rider never showed up, marked delivered."</p>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            <div class="xl:col-span-1 space-y-6">
                <div class="bg-[rgb(var(--bg-card))] p-5 rounded-lg shadow-sm border border-[rgb(var(--border-color))] transition-colors duration-300 h-full flex flex-col">
                    <div class="flex justify-between items-center mb-4 border-b border-[rgb(var(--border-color))] pb-2">
                        <h3 class="text-md font-semibold text-[rgb(var(--text-main))]">Evidence Locker</h3>
                        <button class="text-[10px] bg-[rgb(var(--item-active-bg))] border border-[rgb(var(--border-color))] px-2 py-1 rounded text-[rgb(var(--text-main))] font-bold hover:bg-[rgb(var(--bg-body))] transition-colors">
                            + Upload
                        </button>
                    </div>
                    
                    <div class="flex-1 space-y-4">
                        
                        <div class="border border-[rgb(var(--border-color))] rounded-lg overflow-hidden">
                            <div class="bg-gray-200 h-24 flex items-center justify-center relative group">
                                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                <div class="absolute inset-0 bg-black bg-opacity-50 hidden group-hover:flex items-center justify-center transition-all">
                                    <span class="text-white text-xs font-bold">View Full Photo</span>
                                </div>
                            </div>
                            <div class="p-2 bg-[rgb(var(--bg-card))]">
                                <span class="text-[10px] font-bold text-[rgb(var(--text-main))] block">Delivery Proof (Rider)</span>
                                <div class="flex justify-between items-center mt-1">
                                    <span class="text-[9px] text-[rgb(var(--text-muted))]">IMG_8812.jpg</span>
                                    <span class="text-[9px] bg-red-100 text-red-700 px-1 py-0.5 rounded font-bold" title="AI detected EXIF data missing or modified">Tamper Warning</span>
                                </div>
                            </div>
                        </div>

                        <div class="border border-[rgb(var(--border-color))] rounded-lg p-3 bg-[rgb(var(--item-active-bg))]">
                            <div class="flex items-center space-x-2 mb-2">
                                <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                                <span class="text-xs font-bold text-[rgb(var(--text-main))]">OTP Validation Log</span>
                            </div>
                            <p class="text-[10px] text-[rgb(var(--text-muted))]">System Log: <span class="text-red-600 font-semibold">OTP was BYPASSED by Rider.</span> Valid PIN was not entered.</p>
                        </div>
                    </div>

                    <div class="mt-4 pt-4 border-t border-[rgb(var(--border-color))] space-y-2">
                        <button class="w-full text-xs flex justify-center items-center bg-[rgb(var(--bg-card))] border border-red-300 text-red-600 py-1.5 rounded font-semibold hover:bg-red-50 transition-colors">
                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 21v-4m0 0V5a2 2 0 012-2h6.5l1 1H21l-3 6 3 6h-8.5l-1-1H5a2 2 0 00-2 2zm9-13.5V9"></path></svg>
                            Flag Tampering Manually
                        </button>
                        <button class="w-full text-xs flex justify-center items-center bg-gray-800 text-white py-1.5 rounded font-semibold hover:bg-black transition-colors">
                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                            Lock Evidence Bundle
                        </button>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection