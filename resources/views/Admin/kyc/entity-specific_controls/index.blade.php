@extends('layouts.app')

@section('content')

<div class="min-h-screen bg-[rgb(var(--bg-body))] font-sans transition-colors duration-300">
    <div class="container mx-auto px-4 py-8">

        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 border-b border-[rgb(var(--border-color))] pb-4">
            <div>
                <h1 class="text-3xl font-bold text-[rgb(var(--text-main))] transition-colors">Entity-Specific KYC Controls</h1>
                <p class="text-sm text-[rgb(var(--text-muted))] mt-1 transition-colors">Configure document requirements and verification rules per entity type</p>
            </div>
            
            <div class="mt-4 md:mt-0">
                <button class="bg-[rgb(var(--brand-primary))] text-white px-4 py-2 rounded text-sm font-semibold hover:bg-[rgb(var(--brand-secondary))] transition-colors shadow-sm">
                    Save Global Configuration
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
                <a href="#" class="border-b-2 border-[rgb(var(--brand-primary))] text-[rgb(var(--brand-primary))] py-3 px-4 font-semibold text-sm transition-colors whitespace-nowrap">
                    5.4 Entities
                </a>
                <a href="#" class="border-b-2 border-transparent text-[rgb(var(--text-muted))] hover:text-[rgb(var(--text-main))] py-3 px-4 font-medium text-sm transition-colors whitespace-nowrap">
                    5.5 Compliance
                </a>
            </nav>
        </div>

        <div class="flex flex-col md:flex-row gap-6">
            
            <div class="w-full md:w-1/4 space-y-2">
                <button class="w-full flex items-center justify-between p-3 rounded-lg border border-[rgb(var(--border-color))] bg-[rgb(var(--bg-card))] text-[rgb(var(--text-main))] hover:bg-[rgb(var(--item-active-bg))] transition-colors text-left font-medium">
                    <span>5.4.1 Service Providers</span>
                </button>
                
                <button class="w-full flex items-center justify-between p-3 rounded-lg border border-[rgb(var(--border-color))] bg-[rgb(var(--bg-card))] text-[rgb(var(--text-main))] hover:bg-[rgb(var(--item-active-bg))] transition-colors text-left font-medium">
                    <span>5.4.2 Professional Experts</span>
                </button>
                
                <button class="w-full flex items-center justify-between p-3 rounded-lg border border-[rgb(var(--border-color))] bg-[rgb(var(--bg-card))] text-[rgb(var(--text-main))] hover:bg-[rgb(var(--item-active-bg))] transition-colors text-left font-medium">
                    <span>5.4.3 Consultants</span>
                </button>
                
                <button class="w-full flex items-center justify-between p-3 rounded-lg border border-[rgb(var(--border-color))] bg-[rgb(var(--bg-card))] text-[rgb(var(--text-main))] hover:bg-[rgb(var(--item-active-bg))] transition-colors text-left font-medium">
                    <span>5.4.4 Mart Vendors</span>
                </button>

                <button class="w-full flex items-center justify-between p-3 rounded-lg border border-[rgb(var(--brand-primary))] bg-[rgb(var(--item-active-bg))] text-[rgb(var(--brand-primary))] transition-colors text-left font-bold shadow-sm">
                    <span>5.4.5 Riders</span>
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                </button>
            </div>

            <div class="w-full md:w-3/4 space-y-6">
                
                <div class="bg-[rgb(var(--bg-card))] p-6 rounded-lg shadow-sm border border-[rgb(var(--border-color))] transition-colors duration-300">
                    <div class="flex justify-between items-start mb-4">
                        <div>
                            <h2 class="text-xl font-bold text-[rgb(var(--text-main))]">Rider KYC Configuration</h2>
                            <p class="text-sm text-[rgb(var(--text-muted))] mt-1">Manage documents and background check rules required for rider dispatch eligibility.</p>
                        </div>
                        <div class="flex items-center space-x-2">
                            <span class="text-sm font-medium text-[rgb(var(--text-muted))]">Status:</span>
                            <span class="px-2 py-1 bg-green-100 text-green-800 text-xs font-bold rounded-full">Active</span>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 pt-4 border-t border-[rgb(var(--border-color))]">
                        <div class="flex items-center justify-between p-3 bg-[rgb(var(--item-active-bg))] rounded border border-[rgb(var(--border-color))]">
                            <div>
                                <h4 class="text-sm font-bold text-[rgb(var(--text-main))]">Periodic Re-verification</h4>
                                <p class="text-xs text-[rgb(var(--text-muted))]">Request fresh selfie every 30 days</p>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" value="" class="sr-only peer" checked>
                                <div class="w-9 h-5 bg-gray-300 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-[rgb(var(--brand-primary))]"></div>
                            </label>
                        </div>

                        <div class="flex items-center justify-between p-3 bg-[rgb(var(--item-active-bg))] rounded border border-[rgb(var(--border-color))]">
                            <div>
                                <h4 class="text-sm font-bold text-[rgb(var(--text-main))]">Background Check Hooks</h4>
                                <p class="text-xs text-[rgb(var(--text-muted))]">Auto-trigger criminal record API</p>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" value="" class="sr-only peer" checked>
                                <div class="w-9 h-5 bg-gray-300 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-[rgb(var(--brand-primary))]"></div>
                            </label>
                        </div>
                    </div>
                </div>

                <div class="bg-[rgb(var(--bg-card))] rounded-lg shadow-sm border border-[rgb(var(--border-color))] overflow-hidden transition-colors duration-300">
                    <div class="px-6 py-4 border-b border-[rgb(var(--border-color))] bg-[rgb(var(--item-active-bg))] flex justify-between items-center">
                        <h3 class="text-lg font-semibold text-[rgb(var(--text-main))]">Required Documents</h3>
                        <button class="text-sm text-[rgb(var(--brand-primary))] font-medium hover:text-[rgb(var(--brand-secondary))] flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                            Add Requirement
                        </button>
                    </div>
                    
                    <ul class="divide-y divide-[rgb(var(--border-color))]">
                        <li class="p-4 hover:bg-[rgb(var(--item-active-bg))] transition-colors flex items-center justify-between">
                            <div class="flex items-center space-x-4">
                                <div class="p-2 bg-blue-50 text-blue-600 rounded-lg">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"></path></svg>
                                </div>
                                <div>
                                    <h4 class="text-sm font-bold text-[rgb(var(--text-main))]">Government ID (Front & Back)</h4>
                                    <p class="text-xs text-[rgb(var(--text-muted))]">Required for identity verification & face match.</p>
                                </div>
                            </div>
                            <div class="flex items-center space-x-4">
                                <span class="px-2 py-1 bg-red-100 text-red-700 text-[10px] font-bold uppercase rounded">Mandatory</span>
                                <button class="text-[rgb(var(--text-muted))] hover:text-[rgb(var(--brand-primary))]">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                </button>
                            </div>
                        </li>

                        <li class="p-4 hover:bg-[rgb(var(--item-active-bg))] transition-colors flex items-center justify-between">
                            <div class="flex items-center space-x-4">
                                <div class="p-2 bg-purple-50 text-purple-600 rounded-lg">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                </div>
                                <div>
                                    <h4 class="text-sm font-bold text-[rgb(var(--text-main))]">Driving License</h4>
                                    <p class="text-xs text-[rgb(var(--text-muted))]">Tracks expiry dates. Must be valid for at least 3 months.</p>
                                </div>
                            </div>
                            <div class="flex items-center space-x-4">
                                <span class="px-2 py-1 bg-red-100 text-red-700 text-[10px] font-bold uppercase rounded">Mandatory</span>
                                <button class="text-[rgb(var(--text-muted))] hover:text-[rgb(var(--brand-primary))]">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                </button>
                            </div>
                        </li>

                        <li class="p-4 hover:bg-[rgb(var(--item-active-bg))] transition-colors flex items-center justify-between">
                            <div class="flex items-center space-x-4">
                                <div class="p-2 bg-yellow-50 text-yellow-600 rounded-lg">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7v8a2 2 0 002 2h6M8 7V5a2 2 0 012-2h4.586a1 1 0 01.707.293l4.414 4.414a1 1 0 01.293.707V15a2 2 0 01-2 2h-2M8 7H6a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2v-2"></path></svg>
                                </div>
                                <div>
                                    <h4 class="text-sm font-bold text-[rgb(var(--text-main))]">Vehicle Registration (Book/Card)</h4>
                                    <p class="text-xs text-[rgb(var(--text-muted))]">Matches rider name to vehicle ownership or authorization.</p>
                                </div>
                            </div>
                            <div class="flex items-center space-x-4">
                                <span class="px-2 py-1 bg-red-100 text-red-700 text-[10px] font-bold uppercase rounded">Mandatory</span>
                                <button class="text-[rgb(var(--text-muted))] hover:text-[rgb(var(--brand-primary))]">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                </button>
                            </div>
                        </li>
                    </ul>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection