@extends('layouts.app')

@section('content')
<h2 class="text-3xl font-bold text-slate-800 mb-8 pl-5">Executive Dashboard</h2>

<section class="mb-10 pl-5">
    <h3 class="text-2xl font-semibold text-slate-800 mb-5">Key Performance Indicators</h3>
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-6">

        <div class="pro-card p-6 bg-white rounded-xl shadow-md flex flex-col justify-between h-36">
            <div>
                <p class="text-sm font-medium text-slate-500">Total Bookings</p>
                <p class="text-xl font-bold text-slate-900 mt-1">4,281</p>
            </div>
            <div class="flex items-center justify-between">
                <span class="text-sm text-green-600 font-semibold">+18.5%</span>
                <div class="p-2 rounded-full bg-blue-100 text-blue-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="pro-card p-6 bg-white rounded-xl shadow-md flex flex-col justify-between h-36">
            <div>
                <p class="text-sm font-medium text-slate-500">Gross Revenue (GTV)</p>
                <p class="text-xl font-bold text-slate-900 mt-1">$45,390</p>
            </div>
            <div class="flex items-center justify-between">
                <span class="text-sm text-green-600 font-semibold">+12.1%</span>
                <div class="p-2 rounded-full bg-green-100 text-green-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                        </path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="pro-card p-6 bg-white rounded-xl shadow-md flex flex-col justify-between h-36">
            <div>
                <p class="text-sm font-medium text-slate-500">Inbound Requests</p>
                <p class="text-xl font-bold text-slate-900 mt-1">5,120</p>
            </div>
            <div class="flex items-center justify-between">
                <span class="text-sm text-red-600 font-semibold">-1.2%</span>
                <div class="p-2 rounded-full bg-indigo-100 text-indigo-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2">
                        </path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="pro-card p-6 bg-white rounded-xl shadow-md flex flex-col justify-between h-36">
            <div>
                <p class="text-sm font-medium text-slate-500">Registered Customers</p>
                <p class="text-xl font-bold text-slate-900 mt-1">18,340</p>
            </div>
            <div class="flex items-center justify-between">
                <span class="text-sm text-green-600 font-semibold">+5.5%</span>
                <div class="p-2 rounded-full bg-purple-100 text-purple-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                        </path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="pro-card p-6 bg-white rounded-xl shadow-md flex flex-col justify-between h-36">
            <div>
                <p class="text-sm font-medium text-slate-500">Service Partners</p>
                <p class="text-xl font-bold text-slate-900 mt-1">1,120</p>
            </div>
            <div class="flex items-center justify-between">
                <span class="text-sm text-yellow-600 font-semibold">0.0%</span>
                <div class="p-2 rounded-full bg-yellow-100 text-yellow-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                        </path>
                    </svg>
                </div>
            </div>
        </div>

        <div
            class="pro-card p-6 bg-white rounded-xl shadow-md flex flex-col justify-between h-36 border-l-4 border-red-500">
            <div>
                <p class="text-sm font-medium text-slate-500">Pending Verification</p>
                <p class="text-xl font-bold text-red-600 mt-1">45</p>
            </div>
            <div class="flex items-center justify-between">
                <span class="text-sm text-red-600 font-semibold">+3.1%</span>
                <div class="p-2 rounded-full bg-red-100 text-red-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2">
                        </path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="pro-card p-6 bg-white rounded-xl shadow-md flex flex-col justify-between h-36">
            <div>
                <p class="text-sm font-medium text-slate-500">Active Jobs</p>
                <p class="text-xl font-bold text-slate-900 mt-1">15</p>
            </div>
            <div class="flex items-center justify-between">
                <span class="text-sm text-slate-500 font-semibold">Real-time</span>
                <div class="p-2 rounded-full bg-orange-100 text-orange-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="pro-card p-6 bg-white rounded-xl shadow-md flex flex-col justify-between h-36">
            <div>
                <p class="text-sm font-medium text-slate-500">Online Fleet</p>
                <p class="text-xl font-bold text-slate-900 mt-1">210</p>
            </div>
            <div class="flex items-center justify-between">
                <span class="text-sm text-green-600 font-semibold">Available</span>
                <div class="p-2 rounded-full bg-lime-100 text-lime-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1">
                        </path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="pro-card p-6 bg-white rounded-xl shadow-md flex flex-col justify-between h-36">
            <div>
                <p class="text-sm font-medium text-slate-500">Payout Requests</p>
                <p class="text-xl font-bold mt-1">12</p>
            </div>
            <div class="flex items-center justify-between">
                <span class="text-sm text-slate-500 font-semibold">Processing</span>
                <div class="p-2 rounded-full bg-amber-100 text-amber-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z">
                        </path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="pro-card p-6 bg-white rounded-xl shadow-md flex flex-col justify-between h-36">
            <div>
                <p class="text-sm font-medium text-slate-500">Dispute & Refunds</p>
                <p class="text-3xl font-bold mt-1">8</p>
            </div>
            <div class="flex items-center justify-between">
                <span class="text-sm text-slate-500 font-semibold">Under Review</span>
                <div class="p-2 rounded-full bg-pink-100 text-pink-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M16 15v-1a4 4 0 00-4-4H8m0 0l3 3m-3-3l3-3m9 14V5a2 2 0 00-2-2H6a2 2 0 00-2 2v16l4-2 4 2 4-2 4 2z">
                        </path>
                    </svg>
                </div>
            </div>
        </div>

        <div
            class="pro-card p-6 bg-white rounded-xl shadow-md flex flex-col justify-between h-36 border-l-4 border-red-500">
            <div>
                <p class="text-sm font-medium text-slate-500">SLA Breaches</p>
                <p class="text-xl font-bold mt-1">3</p>
            </div>
            <div class="flex items-center justify-between">
                <span class="text-sm text-red-600 font-semibold">Critical</span>
                <div class="p-2 rounded-full bg-red-100 text-red-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9">
                        </path>
                    </svg>
                </div>
            </div>
        </div>

    </div>
</section>
<section class="mb-10 pl-5">
    <h3 class="text-2xl font-semibold text-slate-800 mb-5">Analytics & Trends</h3>

    <div class="grid grid-cols-1 gap-6 mb-8">
        <div class="pro-card p-6 bg-white rounded-xl shadow-md">
            <h4 class="text-xl font-semibold text-slate-800 mb-4">Monthly Revenue Trends</h4>
            <div id="monthly-revenue-bar-chart" class="h-80"></div>
        </div>
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <div class="pro-card p-6 bg-white rounded-xl shadow-md">
                <h4 class="text-xl font-semibold text-slate-800 mb-4">Yearly Growth Overview</h4>
                <div id="yearly-revenue-overview-chart" class="h-80"></div>
            </div>
            <div class="pro-card p-6 bg-white rounded-xl shadow-md">
                <h4 class="text-xl font-semibold text-slate-800 mb-4">Revenue Per Service Category</h4>
                <div id="revenue-per-category-chart" class="h-80"></div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 gap-6 mb-8">
        <div class="pro-card p-6 bg-white rounded-xl shadow-md">
            <h4 class="text-xl font-semibold text-slate-800 mb-4">Fleet Logistics Efficiency</h4>
            <div id="rider-delivery-performance-chart" class="h-80"></div>
        </div>
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <div class="pro-card p-6 bg-white rounded-xl shadow-md">
                <h4 class="text-xl font-semibold text-slate-800 mb-4">Successful vs Failed Deliveries</h4>
                <div id="successful-failed-deliveries-chart" class="h-80"></div>
            </div>
            <div class="pro-card p-6 bg-white rounded-xl shadow-md">
                <h4 class="text-xl font-semibold text-slate-800 mb-4">Geospatial Demand Heatmap</h4>
                <div id="rider-activity-heatmap" class="h-80">
                     
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 gap-6 mb-8">
        <div class="pro-card p-6 bg-white rounded-xl shadow-md">
            <h4 class="text-xl font-semibold text-slate-800 mb-4">Monthly Service Volume</h4>
            <div id="monthly-service-volume-chart" class="h-80"></div>
        </div>
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <div class="pro-card p-6 bg-white rounded-xl shadow-md">
                <h4 class="text-xl font-semibold text-slate-800 mb-4">Category Performance Comparison</h4>
                <div id="category-performance-comparison-chart" class="h-80"></div>
            </div>
            <div class="pro-card p-6 bg-white rounded-xl shadow-md">
                <h4 class="text-xl font-semibold text-slate-800 mb-4">Job Status Distribution</h4>
                <div id="orders-status-chart" class="h-80"></div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
        <div class="pro-card p-6 bg-white rounded-xl shadow-md">
            <h4 class="text-xl font-semibold text-slate-800 mb-4">Partner Onboarding Funnel</h4>
            <div id="provider-conversion-funnel-chart" class="h-80"></div>
        </div>
        <div class="pro-card p-6 bg-white rounded-xl shadow-md">
            <h4 class="text-xl font-semibold text-slate-800 mb-4">Top Performing Partners</h4>
            <div id="top-providers-chart" class="h-80"></div>
        </div>
        <div class="pro-card p-6 bg-white rounded-xl shadow-md">
            <h4 class="text-xl font-semibold text-slate-800 mb-4">Service Coverage by Category</h4>
            <div id="provider-category-coverage-chart" class="h-80"></div>
        </div>
    </div>

</section>



<section class="mb-10 pl-5">
    <h3 class="text-2xl font-semibold text-slate-800 mb-5">Operational Activity & Queues</h3>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

        <div class="pro-card p-6 bg-white rounded-xl shadow-md">
            <div class="flex justify-between items-center mb-4">
                <h4 class="text-xl font-semibold text-slate-800">Active Jobs (15)</h4>
                <a href="#" class="text-sm text-blue-600 hover:text-blue-700 font-medium">View Dispatch</a>
            </div>
            <div class="h-96 overflow-y-auto space-y-3 pr-2">
                <div class="border-b border-l-4 border-indigo-500 pl-3 py-2">
                    <p class="text-sm text-slate-900 font-medium truncate">Order #ORD-2940 - HVAC Maintenance</p>
                    <p class="text-xs text-slate-500">Client: Metro Plaza HQ | Tech: John S.</p>
                    <span class="text-xs text-orange-500 font-semibold">En Route (Est. 15m)</span>
                </div>
                <div class="border-b border-l-4 border-indigo-500 pl-3 py-2">
                    <p class="text-sm text-slate-900 font-medium truncate">Order #ORD-2941 - Emergency Plumbing</p>
                    <p class="text-xs text-slate-500">Client: Sunset Villas | Provider: ProFix Corp</p>
                    <span class="text-xs text-green-500 font-semibold">In Progress (08:15 AM)</span>
                </div>
                <div class="border-b border-l-4 border-indigo-500 pl-3 py-2">
                    <p class="text-sm text-slate-900 font-medium truncate">Order #ORD-2942 - Sanitization Service</p>
                    <p class="text-xs text-slate-500">Client: Apex Gym | Rider: Pending</p>
                    <span class="text-xs text-blue-500 font-semibold">Assigning Partner...</span>
                </div>
                <div class="text-center pt-4 text-slate-400 text-sm">... 12 more active jobs ...</div>
            </div>
        </div>

        <div class="pro-card p-6 bg-white rounded-xl shadow-md">
            <div class="flex justify-between items-center mb-4">
                <h4 class="text-xl font-semibold text-slate-800">Pending Verification (45)</h4>
                <a href="#" class="text-sm text-blue-600 hover:text-blue-700 font-medium">Review All</a>
            </div>
            <div class="h-96 overflow-y-auto space-y-3 pr-2">
                <div class="border-b border-l-4 border-red-500 pl-3 py-2">
                    <p class="text-sm text-slate-900 font-medium truncate">Partner: Urban Electricians Ltd</p>
                    <p class="text-xs text-slate-500">Doc: Business License & Tax ID</p>
                    <span class="text-xs text-red-500 font-semibold">Action Required - 3 Days</span>
                </div>
                <div class="border-b border-l-4 border-yellow-500 pl-3 py-2">
                    <p class="text-sm text-slate-900 font-medium truncate">Rider: Alex Johnson (Fleet)</p>
                    <p class="text-xs text-slate-500">Doc: Background Check Report</p>
                    <span class="text-xs text-yellow-600 font-semibold">In Queue - 4 Hours</span>
                </div>
                <div class="border-b border-l-4 border-red-500 pl-3 py-2">
                    <p class="text-sm text-slate-900 font-medium truncate">Provider: ProFix Services</p>
                    <p class="text-xs text-slate-500">Doc: Liability Insurance</p>
                    <span class="text-xs text-red-500 font-semibold">Expired - Reupload</span>
                </div>
                <div class="text-center pt-4 text-slate-400 text-sm">... 42 more pending verifications ...</div>
            </div>
        </div>

        <div class="pro-card p-6 bg-white rounded-xl shadow-md">
            <div class="flex justify-between items-center mb-4">
                <h4 class="text-xl font-semibold text-slate-800">Payout Requests (12)</h4>
                <a href="#" class="text-sm text-blue-600 hover:text-blue-700 font-medium">Process Batch</a>
            </div>
            <div class="h-96 overflow-y-auto space-y-3 pr-2">
                <div class="border-b border-l-4 border-amber-500 pl-3 py-2">
                    <p class="text-sm text-slate-900 font-medium truncate">Vendor: GreenThumb Inc - **$500**</p>
                    <p class="text-xs text-slate-500">Ledger: $1,200 | Method: Direct Deposit</p>
                    <span class="text-xs text-amber-600 font-semibold">2 Days Pending</span>
                </div>
                <div class="border-b border-l-4 border-amber-500 pl-3 py-2">
                    <p class="text-sm text-slate-900 font-medium truncate">Rider: Michael A. - **$50**</p>
                    <p class="text-xs text-slate-500">Ledger: $80 | Method: Instant Pay</p>
                    <span class="text-xs text-amber-600 font-semibold">Requested Today</span>
                </div>
                <div class="text-center pt-4 text-slate-400 text-sm">... 10 more payouts pending ...</div>
            </div>
        </div>

        <div class="pro-card p-6 bg-white rounded-xl shadow-md">
            <div class="flex justify-between items-center mb-4">
                <h4 class="text-xl font-semibold text-slate-800">Dispute & Refunds (8)</h4>
                <a href="#" class="text-sm text-blue-600 hover:text-blue-700 font-medium">Resolution Center</a>
            </div>
            <div class="h-96 overflow-y-auto space-y-3 pr-2">
                <div class="border-b border-l-4 border-pink-500 pl-3 py-2">
                    <p class="text-sm text-slate-900 font-medium truncate">Order #ORD-2930 - **$45.00**</p>
                    <p class="text-xs text-slate-500">Reason: Provider No-Show | Status: Pending</p>
                    <span class="text-xs text-pink-600 font-semibold">User: Sarah K.</span>
                </div>
                <div class="border-b border-l-4 border-pink-500 pl-3 py-2">
                    <p class="text-sm text-slate-900 font-medium truncate">Order #ORD-2935 - **$100.00**</p>
                    <p class="text-xs text-slate-500">Reason: Damage Claim | Status: Investigation</p>
                    <span class="text-xs text-pink-600 font-semibold">Provider: ProFix Corp</span>
                </div>
                <div class="text-center pt-4 text-slate-400 text-sm">... 6 more open disputes ...</div>
            </div>
        </div>

        <div class="pro-card p-6 bg-white rounded-xl shadow-md">
            <div class="flex justify-between items-center mb-4">
                <h4 class="text-xl font-semibold text-slate-800">SLA Breaches (3)</h4>
                <a href="#" class="text-sm text-blue-600 hover:text-blue-700 font-medium">Acknowledge All</a>
            </div>
            <div class="h-96 overflow-y-auto space-y-3 pr-2">
                <div class="border-b border-l-4 border-red-600 pl-3 py-2">
                    <p class="text-sm text-red-600 font-medium truncate">**CRITICAL**: Order #ORD-2938</p>
                    <p class="text-xs text-slate-500">Issue: Max Dispatch Time Exceeded</p>
                    <span class="text-xs text-red-600 font-semibold">15 mins overdue</span>
                </div>
                <div class="border-b border-l-4 border-orange-500 pl-3 py-2">
                    <p class="text-sm text-orange-600 font-medium truncate">**HIGH**: Support Ticket #SR-120</p>
                    <p class="text-xs text-slate-500">Issue: Resolution Time Limit Near</p>
                    <span class="text-xs text-orange-600 font-semibold">Breach in 10 mins</span>
                </div>
                <div class="text-center pt-4 text-slate-400 text-sm">... 1 more SLA alert ...</div>
            </div>
        </div>

        <div class="pro-card p-6 bg-white rounded-xl shadow-md">
            <div class="flex justify-between items-center mb-4">
                <h4 class="text-xl font-semibold text-slate-800">Online Fleet (210)</h4>
                <a href="#" class="text-sm text-blue-600 hover:text-blue-700 font-medium">Live Map</a>
            </div>
            <div class="h-96 overflow-y-auto space-y-3 pr-2">
                <div class="border-b border-l-4 border-lime-500 pl-3 py-2">
                    <p class="text-sm text-slate-900 font-medium truncate">Rider: J. Smith (ID: R-001)</p>
                    <p class="text-xs text-slate-500">Ping: 10s ago | Zone: North Downtown</p>
                    <span class="text-xs text-green-600 font-semibold">Idle</span>
                </div>
                <div class="border-b border-l-4 border-lime-500 pl-3 py-2">
                    <p class="text-sm text-slate-900 font-medium truncate">Rider: K. Doe (ID: R-002)</p>
                    <p class="text-xs text-slate-500">Ping: 5m ago | Status: Delivering</p>
                    <span class="text-xs text-blue-600 font-semibold">Arriving at Order #2940</span>
                </div>
                <div class="text-center pt-4 text-slate-400 text-sm">... 208 more riders online ...</div>
            </div>
        </div>

    </div>
</section>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script src="{{ asset('charts/dashboard-charts.js')}}"></script>
@endpush

@push('styles')
<style>
    #orders-status-chart {
        text-align: -webkit-center;
    }
</style>
@endpush