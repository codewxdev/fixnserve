@extends('layouts.app')

@section('content')

{{-- Main Container --}}
<div id="finance-pro-dashboard" 
     class="min-h-screen bg-gray-50/50 pb-12" 
     x-data="{ currentModule: 'overview', openSettings: false }" 
     x-cloak>
    
    {{-- 1. Header (Clean & Pro) --}}
    <header class="bg-white border-b border-gray-200 sticky top-0 z-30">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                <div class="flex items-center gap-4">
                    <div class="p-2 bg-teal-50 rounded-lg border border-teal-100">
                        <svg class="w-6 h-6 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <div>
                        <h1 class="text-xl font-bold text-gray-900 leading-none">Finance & Settlement</h1>
                        <p class="text-xs text-gray-500 mt-1 font-medium">Global Revenue Control Center</p>
                    </div>
                </div>
                
                {{-- Global Actions --}}
                <div class="flex items-center gap-3">
                    <button class="hidden md:flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg shadow-sm hover:bg-gray-50">
                        <svg class="w-4 h-4 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                        Export Report
                    </button>
                    <button @click="openSettings = true" class="p-2 text-gray-400 hover:text-gray-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.585.355 1.288.465 1.724.066z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                    </button>
                </div>
            </div>
            
            {{-- Navigation Tabs --}}
            <nav class="flex space-x-8 -mb-px">
                @foreach(['overview' => 'Overview & Revenue', 'payouts' => 'Payouts & Settlement', 'refunds' => 'Refund Queue', 'wallet' => 'Wallet & Exchange'] as $key => $label)
                    <button @click="currentModule = '{{ $key }}'"
                            :class="{'border-teal-500 text-teal-600 font-bold': currentModule === '{{ $key }}', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': currentModule !== '{{ $key }}'}"
                            class="whitespace-nowrap pb-4 px-1 border-b-2 font-medium text-sm transition-colors duration-200">
                        {{ $label }}
                    </button>
                @endforeach
            </nav>
        </div>
    </header>

    {{-- Content Area --}}
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        
        {{-- VIEW: OVERVIEW --}}
        <div x-show="currentModule === 'overview'" class="space-y-8 animate-fade-in-up">
            
            {{-- Section 1: Revenue by Module (5 Cards) --}}
            <div>
                <h2 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                    Revenue Streams
                    <span class="px-2 py-0.5 rounded-full bg-gray-100 text-gray-500 text-xs font-normal">YTD Performance</span>
                </h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4">
                    
                    {{-- Card 1: Home --}}
                    <div class="bg-white p-5 rounded-xl border border-gray-100 shadow-sm hover:shadow-md transition-shadow">
                        <div class="flex justify-between items-start mb-4">
                            <div class="p-2 bg-blue-50 rounded-lg text-blue-600">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                            </div>
                            <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium bg-blue-100 text-blue-800">12%</span>
                        </div>
                        <p class="text-xs font-medium text-gray-500 uppercase tracking-wide">Home & Maint.</p>
                        <p class="text-2xl font-bold text-gray-900 mt-1">$210,000</p>
                    </div>

                    {{-- Card 2: Professionals --}}
                    <div class="bg-white p-5 rounded-xl border border-gray-100 shadow-sm hover:shadow-md transition-shadow">
                        <div class="flex justify-between items-start mb-4">
                            <div class="p-2 bg-purple-50 rounded-lg text-purple-600">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                            </div>
                            <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium bg-purple-100 text-purple-800">15%</span>
                        </div>
                        <p class="text-xs font-medium text-gray-500 uppercase tracking-wide">Professionals</p>
                        <p class="text-2xl font-bold text-gray-900 mt-1">$132,000</p>
                    </div>

                    {{-- Card 3: Consultants --}}
                    <div class="bg-white p-5 rounded-xl border border-gray-100 shadow-sm hover:shadow-md transition-shadow">
                        <div class="flex justify-between items-start mb-4">
                            <div class="p-2 bg-indigo-50 rounded-lg text-indigo-600">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                            </div>
                            <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium bg-indigo-100 text-indigo-800">Dynamic</span>
                        </div>
                        <p class="text-xs font-medium text-gray-500 uppercase tracking-wide">Consultants</p>
                        <p class="text-2xl font-bold text-gray-900 mt-1">$98,000</p>
                    </div>

                    {{-- Card 4: Mart --}}
                    <div class="bg-white p-5 rounded-xl border border-gray-100 shadow-sm hover:shadow-md transition-shadow">
                        <div class="flex justify-between items-start mb-4">
                            <div class="p-2 bg-orange-50 rounded-lg text-orange-600">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                            </div>
                            <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium bg-orange-100 text-orange-800">10%</span>
                        </div>
                        <p class="text-xs font-medium text-gray-500 uppercase tracking-wide">Mart Vendors</p>
                        <p class="text-2xl font-bold text-gray-900 mt-1">$145,000</p>
                    </div>

                    {{-- Card 5: Delivery --}}
                    <div class="bg-white p-5 rounded-xl border border-gray-100 shadow-sm hover:shadow-md transition-shadow">
                        <div class="flex justify-between items-start mb-4">
                            <div class="p-2 bg-emerald-50 rounded-lg text-emerald-600">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                            </div>
                            <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium bg-emerald-100 text-emerald-800">Fixed</span>
                        </div>
                        <p class="text-xs font-medium text-gray-500 uppercase tracking-wide">Delivery Fees</p>
                        <p class="text-2xl font-bold text-gray-900 mt-1">$27,000</p>
                    </div>
                </div>
            </div>

            {{-- Section 2: Visual Charts --}}
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                
                {{-- Chart 1: Revenue Split (Custom CSS Pie) --}}
                <div class="bg-white p-6 rounded-xl border border-gray-100 shadow-sm">
                    <h3 class="text-gray-900 font-bold mb-1">Revenue Composition</h3>
                    <p class="text-xs text-gray-500 mb-6">Diversified revenue streams reduce risk.</p>
                    
                    <div class="flex items-center gap-8">
                        {{-- CSS Conic Gradient to "Fake" the chart for the screenshot --}}
                        <div class="relative w-40 h-40 rounded-full shadow-inner"
                             style="background: conic-gradient(
                                #3b82f6 0% 34%, 
                                #a855f7 34% 56%, 
                                #f97316 56% 79%, 
                                #6366f1 79% 95%, 
                                #10b981 95% 100%
                             );">
                             <div class="absolute inset-0 m-auto w-24 h-24 bg-white rounded-full flex items-center justify-center">
                                 <span class="text-xs font-bold text-gray-400">Total Mix</span>
                             </div>
                        </div>
                        
                        {{-- Legend --}}
                        <div class="space-y-2 text-xs text-gray-600">
                            <div class="flex items-center gap-2"><span class="w-2 h-2 rounded-full bg-blue-500"></span> Home (34%)</div>
                            <div class="flex items-center gap-2"><span class="w-2 h-2 rounded-full bg-purple-500"></span> Pro (22%)</div>
                            <div class="flex items-center gap-2"><span class="w-2 h-2 rounded-full bg-orange-500"></span> Mart (23%)</div>
                            <div class="flex items-center gap-2"><span class="w-2 h-2 rounded-full bg-indigo-500"></span> Consult (16%)</div>
                            <div class="flex items-center gap-2"><span class="w-2 h-2 rounded-full bg-emerald-500"></span> Delivery (5%)</div>
                        </div>
                    </div>
                </div>

                {{-- Chart 2: Net Revenue Trend (SVG Line) --}}
                <div class="bg-white p-6 rounded-xl border border-gray-100 shadow-sm lg:col-span-2">
                    <div class="flex justify-between items-center mb-6">
                        <div>
                            <h3 class="text-gray-900 font-bold">Net Platform Revenue</h3>
                            <p class="text-xs text-gray-500">Monthly Growth Trajectory</p>
                        </div>
                        <div class="flex gap-2">
                            <span class="px-2 py-1 text-xs font-medium bg-teal-50 text-teal-700 rounded border border-teal-100">+18.4% vs Last Month</span>
                        </div>
                    </div>
                    
                    {{-- Visual Fake Chart Area --}}
                    <div class="relative h-48 w-full border-l border-b border-gray-100">
                        {{-- Grid lines --}}
                        <div class="absolute inset-0 flex flex-col justify-between pointer-events-none">
                            <div class="h-px bg-gray-50 w-full"></div>
                            <div class="h-px bg-gray-50 w-full"></div>
                            <div class="h-px bg-gray-50 w-full"></div>
                            <div class="h-px bg-gray-50 w-full"></div>
                        </div>
                        
                        {{-- The Line --}}
                        <svg class="absolute inset-0 h-full w-full" preserveAspectRatio="none">
                            <path d="M0 150 C 100 140, 150 100, 250 110 S 350 130, 450 90 S 600 50, 800 60 S 1000 20, 1200 10" 
                                  fill="none" 
                                  stroke="#14b8a6" 
                                  stroke-width="3" 
                                  stroke-linecap="round" 
                                  vector-effect="non-scaling-stroke" />
                            {{-- Area fill --}}
                            <path d="M0 150 C 100 140, 150 100, 250 110 S 350 130, 450 90 S 600 50, 800 60 S 1000 20, 1200 10 V 200 H 0 Z" 
                                  fill="url(#gradient)" 
                                  opacity="0.1" />
                            <defs>
                                <linearGradient id="gradient" x1="0%" y1="0%" x2="0%" y2="100%">
                                    <stop offset="0%" style="stop-color:#14b8a6;stop-opacity:1" />
                                    <stop offset="100%" style="stop-color:#14b8a6;stop-opacity:0" />
                                </linearGradient>
                            </defs>
                        </svg>

                        {{-- Tooltip Simulator --}}
                        <div class="absolute top-1/4 left-3/4 transform -translate-x-1/2 -translate-y-1/2">
                            <div class="w-3 h-3 bg-teal-600 rounded-full border-2 border-white shadow"></div>
                            <div class="absolute bottom-4 left-1/2 transform -translate-x-1/2 bg-gray-900 text-white text-xs px-2 py-1 rounded whitespace-nowrap">
                                $192,400 (Dec)
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- VIEW: PAYOUTS --}}
        <div x-show="currentModule === 'payouts'" class="space-y-6">
            
            {{-- Payout Summary Panel --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-gray-800 text-white p-6 rounded-xl shadow-lg">
                    <p class="text-gray-400 text-sm font-medium">Pending Payouts</p>
                    <div class="text-3xl font-bold mt-2 text-white">$186,000</div>
                    <div class="mt-4 text-xs flex items-center text-gray-300">
                        <span class="w-2 h-2 bg-yellow-400 rounded-full mr-2"></span>
                        Requires Approval within 24hrs
                    </div>
                </div>
                 <div class="bg-white p-6 rounded-xl border border-gray-200 shadow-sm">
                    <p class="text-gray-500 text-sm font-medium">Completed (This Month)</p>
                    <div class="text-3xl font-bold mt-2 text-gray-900">$426,000</div>
                    <div class="mt-4 text-xs flex items-center text-green-600">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        All batches processed successfully
                    </div>
                </div>
                 <div class="bg-white p-6 rounded-xl border border-gray-200 shadow-sm">
                    <p class="text-gray-500 text-sm font-medium">Avg Settlement Cycle</p>
                    <div class="text-3xl font-bold mt-2 text-gray-900">3.1 Days</div>
                    <div class="mt-4 w-full bg-gray-100 rounded-full h-1.5">
                        <div class="bg-teal-500 h-1.5 rounded-full" style="width: 70%"></div>
                    </div>
                </div>
            </div>

            {{-- Main Settlement Table Container --}}
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 flex flex-col">
                
                {{-- Toolbar --}}
                <div class="p-5 border-b border-gray-100 flex flex-col md:flex-row justify-between items-center gap-4">
                    <h3 class="text-lg font-bold text-gray-800">Settlement Breakdown</h3>
                    
                    {{-- Admin Actions --}}
                    <div class="flex gap-2">
                         <button class="px-3 py-1.5 text-xs font-medium text-gray-600 bg-gray-50 border border-gray-200 rounded hover:bg-gray-100">
                            Hold Payment
                        </button>
                        <button class="px-3 py-1.5 text-xs font-medium text-gray-600 bg-gray-50 border border-gray-200 rounded hover:bg-gray-100">
                            Adjust Commission
                        </button>
                         <button class="px-3 py-1.5 text-xs font-medium text-white bg-teal-600 border border-teal-600 rounded hover:bg-teal-700 shadow-sm">
                            Release Batch Payout
                        </button>
                    </div>
                </div>

                {{-- Table --}}
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50/50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Payee Category</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Volume</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Net Amount</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider">Cycle</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-100">
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-8 w-8 rounded bg-blue-100 flex items-center justify-center text-blue-600 text-xs font-bold">SP</div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">Service Providers</div>
                                            <div class="text-xs text-gray-500">Cleaning, Maintenance</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">142 Txns</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-900">$64,230.00</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">Processing</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm text-gray-500">Weekly</td>
                            </tr>
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-8 w-8 rounded bg-purple-100 flex items-center justify-center text-purple-600 text-xs font-bold">PRO</div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">Professionals</div>
                                            <div class="text-xs text-gray-500">Designers, Developers</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">89 Txns</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-900">$42,100.50</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Ready</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm text-gray-500">Bi-Weekly</td>
                            </tr>
                             <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-8 w-8 rounded bg-orange-100 flex items-center justify-center text-orange-600 text-xs font-bold">VN</div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">Mart Vendors</div>
                                            <div class="text-xs text-gray-500">Groceries, Retail</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">310 Txns</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-900">$78,450.00</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-600">Scheduled</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm text-gray-500">Monthly</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </main>
</div>
@endsection

@push('styles')
    <style>
        /* Custom Font for Pro Look */
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
        
        body { font-family: 'Inter', sans-serif; }
        
        [x-cloak] { display: none !important; }
        
        .animate-fade-in-up {
            animation: fadeInUp 0.5s ease-out;
        }
        
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
@endpush