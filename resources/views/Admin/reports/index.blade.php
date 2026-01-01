@extends('layouts.app')

@section('content')
    {{-- Alpine.js State: Manages Tab switching and Filter visibility --}}
    <div id="reports-analytics-page" class="space-y-6 p-4 md:p-8 bg-gray-50 min-h-screen"
         x-data="{ 
            currentTab: 'earnings', // Options: earnings, operations, growth, performance
            dateRange: 'This Month',
            showFilters: false,
            
            // Mock Data for specific interactions
            performanceCategory: 'All Services',
         }" x-cloak>

        {{-- 1. Header & Global Actions --}}
        <header class="flex flex-col md:flex-row justify-between items-start md:items-center pb-4 border-b border-gray-200 gap-4">
            <div>
                <h1 class="text-2xl md:text-3xl font-bold text-gray-900 flex items-center">
                    <svg class="w-8 h-8 mr-3 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                    Reports & Analytics
                </h1>
                <p class="text-sm text-gray-500 mt-1">Platform performance, revenue tracking, and operational insights.</p>
            </div>
            
            <div class="flex flex-wrap gap-2">
                {{-- Date Range Dropdown --}}
                <div class="relative">
                    <button @click="showFilters = !showFilters" class="flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 shadow-sm">
                        <svg class="w-4 h-4 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        <span x-text="dateRange"></span>
                        <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    {{-- Dropdown Menu (Simulated) --}}
                    <div x-show="showFilters" @click.away="showFilters = false" class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-20 border border-gray-100">
                        <a href="#" @click.prevent="dateRange = 'Today'; showFilters = false" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Today</a>
                        <a href="#" @click.prevent="dateRange = 'This Week'; showFilters = false" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">This Week</a>
                        <a href="#" @click.prevent="dateRange = 'This Month'; showFilters = false" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">This Month</a>
                        <a href="#" @click.prevent="dateRange = 'Last Quarter'; showFilters = false" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Last Quarter</a>
                    </div>
                </div>

                <button class="flex items-center px-4 py-2 text-sm font-medium text-white bg-indigo-600 rounded-lg hover:bg-indigo-700 shadow-md transition">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                    Export CSV
                </button>
            </div>
        </header>

        {{-- 2. Report Navigation Tabs --}}
        <div class="bg-white p-1 rounded-xl shadow-sm border border-gray-200 inline-flex w-full md:w-auto overflow-x-auto">
            <button @click="currentTab = 'earnings'" 
                :class="currentTab === 'earnings' ? 'bg-indigo-50 text-indigo-700 shadow-sm ring-1 ring-indigo-200' : 'text-gray-500 hover:text-gray-700'"
                class="flex-1 md:flex-none px-6 py-2.5 text-sm font-medium rounded-lg transition-all whitespace-nowrap">
                Revenue & Earnings
            </button>
            <button @click="currentTab = 'operations'" 
                :class="currentTab === 'operations' ? 'bg-indigo-50 text-indigo-700 shadow-sm ring-1 ring-indigo-200' : 'text-gray-500 hover:text-gray-700'"
                class="flex-1 md:flex-none px-6 py-2.5 text-sm font-medium rounded-lg transition-all whitespace-nowrap">
                Daily Analytics
            </button>
            <button @click="currentTab = 'growth'" 
                :class="currentTab === 'growth' ? 'bg-indigo-50 text-indigo-700 shadow-sm ring-1 ring-indigo-200' : 'text-gray-500 hover:text-gray-700'"
                class="flex-1 md:flex-none px-6 py-2.5 text-sm font-medium rounded-lg transition-all whitespace-nowrap">
                User Growth
            </button>
            <button @click="currentTab = 'performance'" 
                :class="currentTab === 'performance' ? 'bg-indigo-50 text-indigo-700 shadow-sm ring-1 ring-indigo-200' : 'text-gray-500 hover:text-gray-700'"
                class="flex-1 md:flex-none px-6 py-2.5 text-sm font-medium rounded-lg transition-all whitespace-nowrap">
                Provider Performance
            </button>
        </div>

        {{-- ========================================================== --}}
        {{-- SCREEN 1: EARNINGS REPORT --}}
        {{-- ========================================================== --}}
        <div x-show="currentTab === 'earnings'" x-transition.opacity class="space-y-6">
            
            {{-- Filter Bar --}}
            <div class="flex items-center gap-4 bg-white p-4 rounded-xl shadow-sm border border-gray-100">
                <span class="text-sm font-bold text-gray-700 uppercase">Filter By Module:</span>
                <label class="flex items-center space-x-2 text-sm text-gray-600 cursor-pointer">
                    <input type="checkbox" checked class="rounded text-indigo-600 focus:ring-indigo-500"> <span>Provider</span>
                </label>
                <label class="flex items-center space-x-2 text-sm text-gray-600 cursor-pointer">
                    <input type="checkbox" checked class="rounded text-indigo-600 focus:ring-indigo-500"> <span>Expert</span>
                </label>
                <label class="flex items-center space-x-2 text-sm text-gray-600 cursor-pointer">
                    <input type="checkbox" checked class="rounded text-indigo-600 focus:ring-indigo-500"> <span>Vendor</span>
                </label>
                <label class="flex items-center space-x-2 text-sm text-gray-600 cursor-pointer">
                    <input type="checkbox" checked class="rounded text-indigo-600 focus:ring-indigo-500"> <span>Delivery</span>
                </label>
            </div>

            {{-- Financial KPI Cards --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-white p-6 rounded-xl shadow-lg border-l-4 border-green-500">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-sm font-medium text-gray-500 uppercase tracking-wider">Total Revenue (GMV)</p>
                            <h3 class="text-3xl font-bold text-gray-900 mt-2">$124,500.00</h3>
                        </div>
                        <span class="p-2 bg-green-100 text-green-600 rounded-lg">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </span>
                    </div>
                    <div class="mt-4 flex items-center text-sm">
                        <span class="text-green-600 font-bold flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                            +12.5%
                        </span>
                        <span class="text-gray-400 ml-2">vs last month</span>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-xl shadow-lg border-l-4 border-indigo-500">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-sm font-medium text-gray-500 uppercase tracking-wider">Net Commission</p>
                            <h3 class="text-3xl font-bold text-gray-900 mt-2">$18,675.00</h3>
                        </div>
                        <span class="p-2 bg-indigo-100 text-indigo-600 rounded-lg">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                        </span>
                    </div>
                    <div class="mt-4 flex items-center text-sm">
                        <span class="text-green-600 font-bold flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                            +8.2%
                        </span>
                        <span class="text-gray-400 ml-2">Average 15% rate</span>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-xl shadow-lg border-l-4 border-orange-500">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-sm font-medium text-gray-500 uppercase tracking-wider">Pending Payouts</p>
                            <h3 class="text-3xl font-bold text-gray-900 mt-2">$4,200.00</h3>
                        </div>
                        <span class="p-2 bg-orange-100 text-orange-600 rounded-lg">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </span>
                    </div>
                    <div class="mt-4 flex items-center text-sm">
                        <button class="text-orange-600 hover:text-orange-800 font-semibold underline">Process Payouts &rarr;</button>
                    </div>
                </div>
            </div>

            {{-- CSS Bar Chart (Simulated) --}}
            <div class="bg-white p-6 rounded-xl shadow-lg border border-gray-100">
                <h3 class="text-lg font-bold text-gray-800 mb-6">Revenue Trend (Last 7 Days)</h3>
                <div class="flex items-end justify-between h-48 space-x-2">
                    @foreach([45, 60, 35, 80, 55, 90, 75] as $percentage)
                        <div class="w-full flex flex-col items-center group">
                            <div class="relative w-full bg-indigo-50 rounded-t-md hover:bg-indigo-100 transition duration-300 flex items-end justify-center" style="height: 100%;">
                                <div class="w-3/4 bg-indigo-500 rounded-t-md shadow-lg group-hover:bg-indigo-600 transition" style="height: {{ $percentage }}%;"></div>
                                {{-- Tooltip --}}
                                <div class="absolute -top-8 bg-gray-800 text-white text-xs rounded py-1 px-2 opacity-0 group-hover:opacity-100 transition">
                                    ${{ $percentage * 100 }}
                                </div>
                            </div>
                            <span class="text-xs text-gray-500 mt-2">Day {{ $loop->iteration }}</span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- ========================================================== --}}
        {{-- SCREEN 2: OPERATIONS (DAILY/WEEKLY ANALYTICS) --}}
        {{-- ========================================================== --}}
        <div x-show="currentTab === 'operations'" x-transition.opacity class="space-y-6">
            <h2 class="text-xl font-bold text-gray-800">Operational Dashboard</h2>
            
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <div class="bg-white p-4 rounded-lg shadow border border-gray-100 text-center">
                    <p class="text-xs text-gray-500 uppercase">Active Users (Today)</p>
                    <p class="text-2xl font-bold text-blue-600">1,240</p>
                </div>
                <div class="bg-white p-4 rounded-lg shadow border border-gray-100 text-center">
                    <p class="text-xs text-gray-500 uppercase">Orders Created</p>
                    <p class="text-2xl font-bold text-indigo-600">350</p>
                </div>
                <div class="bg-white p-4 rounded-lg shadow border border-gray-100 text-center">
                    <p class="text-xs text-gray-500 uppercase">Completed</p>
                    <p class="text-2xl font-bold text-green-600">310</p>
                </div>
                <div class="bg-white p-4 rounded-lg shadow border border-gray-100 text-center">
                    <p class="text-xs text-gray-500 uppercase">Cancelled</p>
                    <p class="text-2xl font-bold text-red-600">40</p>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="font-bold text-gray-800">Latest Completed Orders (Live Feed)</h3>
                </div>
                <table class="min-w-full divide-y divide-gray-200">
                    <tbody class="bg-white divide-y divide-gray-100">
                        @for ($i = 0; $i < 5; $i++)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                10:4{{ $i }} AM
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="text-sm font-bold text-gray-900">#ORD-99{{ $i }}</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                Customer <strong>A. Khan</strong> booked <strong>AC Repair</strong>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                    Completed
                                </span>
                            </td>
                        </tr>
                        @endfor
                    </tbody>
                </table>
            </div>
        </div>

        {{-- ========================================================== --}}
        {{-- SCREEN 3: USER GROWTH REPORT --}}
        {{-- ========================================================== --}}
        <div x-show="currentTab === 'growth'" x-transition.opacity class="space-y-6">
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- New Registrations Card --}}
                <div class="bg-white p-6 rounded-xl shadow-lg border border-gray-100">
                    <h3 class="text-lg font-bold text-gray-800 mb-4">New Registrations Breakdown</h3>
                    <div class="space-y-4">
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-600">Customers</span>
                            <div class="w-1/2 bg-gray-200 rounded-full h-2.5">
                                <div class="bg-blue-600 h-2.5 rounded-full" style="width: 70%"></div>
                            </div>
                            <span class="text-sm font-bold text-gray-900">70% (140)</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-600">Service Providers</span>
                            <div class="w-1/2 bg-gray-200 rounded-full h-2.5">
                                <div class="bg-purple-600 h-2.5 rounded-full" style="width: 20%"></div>
                            </div>
                            <span class="text-sm font-bold text-gray-900">20% (40)</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-600">Riders</span>
                            <div class="w-1/2 bg-gray-200 rounded-full h-2.5">
                                <div class="bg-red-600 h-2.5 rounded-full" style="width: 10%"></div>
                            </div>
                            <span class="text-sm font-bold text-gray-900">10% (20)</span>
                        </div>
                    </div>
                </div>

                {{-- Retention Card --}}
                <div class="bg-white p-6 rounded-xl shadow-lg border border-gray-100 flex flex-col justify-center items-center text-center">
                    <h3 class="text-lg font-bold text-gray-800 mb-2">Platform Retention Rate</h3>
                    <p class="text-sm text-gray-500 mb-4">Users returning within 30 days</p>
                    <div class="relative h-32 w-32">
                        <svg class="h-full w-full" viewBox="0 0 36 36">
                            <path class="text-gray-200" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" fill="none" stroke="currentColor" stroke-width="4" />
                            <path class="text-blue-500" stroke-dasharray="85, 100" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" fill="none" stroke="currentColor" stroke-width="4" />
                        </svg>
                        <div class="absolute inset-0 flex items-center justify-center flex-col">
                            <span class="text-3xl font-bold text-gray-900">85%</span>
                            <span class="text-xs text-gray-500">High</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- ========================================================== --}}
        {{-- SCREEN 4: PROVIDER PERFORMANCE REPORT --}}
        {{-- ========================================================== --}}
        <div x-show="currentTab === 'performance'" x-transition.opacity class="space-y-6">
            
            <div class="flex justify-between items-center bg-white p-4 rounded-xl shadow-sm border border-gray-100">
                <h3 class="font-bold text-gray-800">Top Performing Providers</h3>
                <select x-model="performanceCategory" class="rounded-md border-gray-300 text-sm focus:ring-indigo-500 focus:border-indigo-500 shadow-sm">
                    <option>All Services</option>
                    <option>Home Repair</option>
                    <option>Cleaning</option>
                    <option>IT Support</option>
                </select>
            </div>

            <div class="bg-white shadow-xl rounded-xl overflow-hidden border border-gray-100">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Provider Name</th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Category</th>
                            <th class="px-6 py-3 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Jobs Completed</th>
                            <th class="px-6 py-3 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Avg Rating</th>
                            <th class="px-6 py-3 text-right text-xs font-bold text-gray-500 uppercase tracking-wider">Response Time</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-100">
                        {{-- Mock Row 1 --}}
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap flex items-center">
                                <div class="h-8 w-8 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 font-bold text-xs mr-3">AS</div>
                                <span class="text-sm font-medium text-gray-900">Ahmed Services</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Home Repair</td>
                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-bold text-gray-900">142</td>
                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm text-yellow-500 font-bold">4.9 ★</td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm text-gray-500">15 mins</td>
                        </tr>
                        {{-- Mock Row 2 --}}
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap flex items-center">
                                <div class="h-8 w-8 rounded-full bg-pink-100 flex items-center justify-center text-pink-600 font-bold text-xs mr-3">FC</div>
                                <span class="text-sm font-medium text-gray-900">Fast Cleaners</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Cleaning</td>
                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-bold text-gray-900">98</td>
                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm text-yellow-500 font-bold">4.7 ★</td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm text-gray-500">22 mins</td>
                        </tr>
                         {{-- Mock Row 3 --}}
                         <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap flex items-center">
                                <div class="h-8 w-8 rounded-full bg-green-100 flex items-center justify-center text-green-600 font-bold text-xs mr-3">GS</div>
                                <span class="text-sm font-medium text-gray-900">Green Scape</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Gardening</td>
                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-bold text-gray-900">56</td>
                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm text-yellow-500 font-bold">4.5 ★</td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm text-gray-500">45 mins</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
@endsection