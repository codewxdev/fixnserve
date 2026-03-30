@extends('layouts.app')

@section('content')

<div class="min-h-screen bg-[rgb(var(--bg-body))] font-sans transition-colors duration-300">
    <div class="container mx-auto px-4 py-8">

        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 border-b border-[rgb(var(--border-color))] pb-4">
            <div>
                <h1 class="text-3xl font-bold text-[rgb(var(--text-main))] transition-colors">AI Verification Pipeline</h1>
                <p class="text-sm text-[rgb(var(--text-muted))] mt-1 transition-colors">Multi-layer AI Identity & Fraud Detection Engine</p>
            </div>
            
            <div class="mt-4 md:mt-0 flex items-center bg-[rgb(var(--bg-card))] p-3 rounded-lg border border-[rgb(var(--border-color))] shadow-sm">
                <div class="mr-4 text-right">
                    <span class="block text-xs uppercase text-[rgb(var(--text-muted))] font-bold tracking-wider">AI Final Decision</span>
                    <span class="text-lg font-bold text-yellow-600">Manual Review Required</span>
                </div>
                <div class="w-12 h-12 rounded-full flex items-center justify-center bg-yellow-100 text-yellow-800 font-bold text-xl border-4 border-yellow-200">
                    78%
                </div>
            </div>
        </div>

        <div class="mb-6">
            <nav class="flex space-x-4 border-b border-[rgb(var(--border-color))] overflow-x-auto">
                <a href="#" class="border-b-2 border-transparent text-[rgb(var(--text-muted))] hover:text-[rgb(var(--text-main))] py-3 px-4 font-medium text-sm transition-colors whitespace-nowrap">
                    5.1 Document Management
                </a>
                <a href="#" class="border-b-2 border-[rgb(var(--brand-primary))] text-[rgb(var(--brand-primary))] py-3 px-4 font-semibold text-sm transition-colors whitespace-nowrap">
                    5.2 AI Verification
                </a>
                <a href="#" class="border-b-2 border-transparent text-[rgb(var(--text-muted))] hover:text-[rgb(var(--text-main))] py-3 px-4 font-medium text-sm transition-colors whitespace-nowrap">
                    5.3 Orchestration Engine
                </a>
                <a href="#" class="border-b-2 border-transparent text-[rgb(var(--text-muted))] hover:text-[rgb(var(--text-main))] py-3 px-4 font-medium text-sm transition-colors whitespace-nowrap">
                    5.4 Entities
                </a>
                <a href="#" class="border-b-2 border-transparent text-[rgb(var(--text-muted))] hover:text-[rgb(var(--text-main))] py-3 px-4 font-medium text-sm transition-colors whitespace-nowrap">
                    5.5 Compliance
                </a>
            </nav>
        </div>

        <div class="bg-[rgb(var(--bg-card))] p-4 rounded-lg shadow-sm border border-[rgb(var(--border-color))] mb-6 flex justify-between items-center transition-colors duration-300">
            <div class="flex items-center space-x-4">
                <div class="h-10 w-10 rounded-full bg-[rgb(var(--item-active-bg))] flex items-center justify-center text-[rgb(var(--brand-primary))] font-bold text-lg">
                    AK
                </div>
                <div>
                    <h2 class="text-md font-bold text-[rgb(var(--text-main))]">Ali Khan (Rider #R-8922)</h2>
                    <p class="text-xs text-[rgb(var(--text-muted))]">Job ID: KYC-JOB-9921 • Initiated: 10 mins ago</p>
                </div>
            </div>
            <div class="flex space-x-2">
                <button class="bg-[rgb(var(--brand-primary))] text-white px-4 py-2 rounded text-sm font-semibold hover:bg-[rgb(var(--brand-secondary))] transition-colors">
                    Override & Approve
                </button>
                <button class="bg-red-50 text-red-600 border border-red-200 px-4 py-2 rounded text-sm font-semibold hover:bg-red-100 transition-colors">
                    Reject Identity
                </button>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            
            <div class="lg:col-span-1 space-y-6">
                <div class="bg-[rgb(var(--bg-card))] p-6 rounded-lg shadow-sm border border-[rgb(var(--border-color))] transition-colors duration-300">
                    <h3 class="text-lg font-semibold text-[rgb(var(--text-main))] mb-4 border-b border-[rgb(var(--border-color))] pb-2">Face Matching & Liveness</h3>
                    
                    <div class="flex justify-center items-center space-x-4 mb-6">
                        <div class="text-center">
                            <div class="h-24 w-24 bg-[rgb(var(--item-active-bg))] rounded-md border border-[rgb(var(--border-color))] flex items-center justify-center mb-2 overflow-hidden relative group">
                                <span class="text-xs text-[rgb(var(--text-muted))]">ID Photo</span>
                                </div>
                            <span class="text-xs font-medium text-[rgb(var(--text-muted))]">Extracted from ID</span>
                        </div>
                        
                        <div class="text-green-500 flex flex-col items-center">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
                            <span class="text-xs font-bold mt-1 text-green-600">94% Match</span>
                        </div>

                        <div class="text-center">
                            <div class="h-24 w-24 bg-[rgb(var(--item-active-bg))] rounded-md border border-green-300 flex items-center justify-center mb-2 overflow-hidden relative">
                                <span class="text-xs text-[rgb(var(--text-muted))]">Selfie</span>
                            </div>
                            <span class="text-xs font-medium text-[rgb(var(--text-muted))]">Liveness Check</span>
                        </div>
                    </div>

                    <div class="space-y-3">
                        <div>
                            <div class="flex justify-between text-sm mb-1">
                                <span class="text-[rgb(var(--text-main))] font-medium">Anti-Spoofing (Replay check)</span>
                                <span class="text-green-600 font-semibold">Pass</span>
                            </div>
                            <div class="w-full bg-[rgb(var(--item-active-bg))] rounded-full h-2">
                                <div class="bg-green-500 h-2 rounded-full" style="width: 98%"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-[rgb(var(--bg-card))] p-6 rounded-lg shadow-sm border border-[rgb(var(--border-color))] transition-colors duration-300">
                    <h3 class="text-lg font-semibold text-[rgb(var(--text-main))] mb-4 border-b border-[rgb(var(--border-color))] pb-2">Duplicate & Watchlist</h3>
                    <ul class="space-y-3 text-sm">
                        <li class="flex justify-between items-center">
                            <span class="text-[rgb(var(--text-muted))]">Reused Document Check</span>
                            <span class="px-2 py-1 bg-green-100 text-green-700 rounded text-xs font-bold">Clear (0 Matches)</span>
                        </li>
                        <li class="flex justify-between items-center">
                            <span class="text-[rgb(var(--text-muted))]">Blacklisted Identity</span>
                            <span class="px-2 py-1 bg-green-100 text-green-700 rounded text-xs font-bold">Clear</span>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="lg:col-span-2 space-y-6">
                
                <div class="bg-[rgb(var(--bg-card))] p-6 rounded-lg shadow-sm border border-[rgb(var(--border-color))] transition-colors duration-300">
                    <div class="flex justify-between items-center mb-4 border-b border-[rgb(var(--border-color))] pb-2">
                        <h3 class="text-lg font-semibold text-[rgb(var(--text-main))]">Authenticity & Tamper Detection</h3>
                        <span class="px-2 py-1 bg-yellow-100 text-yellow-800 rounded text-xs font-bold flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                            Flagged for Review
                        </span>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="p-4 bg-[rgb(var(--item-active-bg))] rounded border border-[rgb(var(--border-color))]">
                            <p class="text-sm font-semibold text-[rgb(var(--text-main))]">Metadata & EXIF</p>
                            <p class="text-xs text-[rgb(var(--text-muted))] mt-1">No software manipulation detected in file headers.</p>
                            <div class="mt-2 text-green-600 text-sm font-bold">Pass (99%)</div>
                        </div>
                        
                        <div class="p-4 bg-yellow-50 rounded border border-yellow-200">
                            <p class="text-sm font-semibold text-yellow-800">Pixel/Font Analysis</p>
                            <p class="text-xs text-yellow-700 mt-1">Inconsistent noise pattern around "Date of Birth" field. Possible digital alteration.</p>
                            <div class="mt-2 text-yellow-600 text-sm font-bold">Warning (65% Confidence)</div>
                        </div>
                    </div>
                </div>

                <div class="bg-[rgb(var(--bg-card))] rounded-lg shadow-sm border border-[rgb(var(--border-color))] overflow-hidden transition-colors duration-300">
                    <div class="px-6 py-4 border-b border-[rgb(var(--border-color))] bg-[rgb(var(--item-active-bg))]">
                        <h3 class="text-lg font-semibold text-[rgb(var(--text-main))]">OCR Extraction & Cross-Document Consistency</h3>
                    </div>
                    
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-[rgb(var(--border-color))]">
                            <thead class="bg-[rgb(var(--bg-card))]">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-[rgb(var(--text-muted))] uppercase tracking-wider">Field</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-[rgb(var(--text-muted))] uppercase tracking-wider">User Profile (Provided)</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-[rgb(var(--text-muted))] uppercase tracking-wider">OCR Extracted (Document)</th>
                                    <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-[rgb(var(--text-muted))] uppercase tracking-wider">Consistency</th>
                                </tr>
                            </thead>
                            <tbody class="bg-[rgb(var(--bg-card))] divide-y divide-[rgb(var(--border-color))]">
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-[rgb(var(--text-main))]">Full Name</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-[rgb(var(--text-muted))]">Ali Khan</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-[rgb(var(--text-main))] font-mono">ALI KHAN</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                        <span class="inline-flex items-center text-green-600">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                        </span>
                                    </td>
                                </tr>
                                <tr class="bg-yellow-50/50">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-[rgb(var(--text-main))]">Date of Birth</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-[rgb(var(--text-muted))]">1995-04-12</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-yellow-700 font-mono">1996-04-12</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                        <span class="inline-flex items-center text-yellow-600 font-bold text-xs">
                                            MISMATCH
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-[rgb(var(--text-main))]">Doc Number</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-[rgb(var(--text-muted))]">37405-1122334-1</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-[rgb(var(--text-main))] font-mono">37405-1122334-1</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                        <span class="inline-flex items-center text-green-600">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-[rgb(var(--text-main))]">Expiry Date</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-[rgb(var(--text-muted))]">--</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-[rgb(var(--text-main))] font-mono">2032-08-20</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                            Valid
                                        </span>
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