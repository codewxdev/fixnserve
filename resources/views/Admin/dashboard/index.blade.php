@extends('layouts.app')

@section('content')
    <h2 class="text-3xl font-bold text-slate-800 mb-8">Dashboard</h2>

    <section class="mb-10">
        <h3 class="text-2xl font-semibold text-slate-800 mb-5">Key Performance Indicators</h3>
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-6">

            <div class="pro-card p-6 bg-white rounded-xl shadow-md flex flex-col justify-between h-36">
                <div>
                    <p class="text-sm font-medium text-slate-500">Total Orders</p>
                    <p class="text-xl font-bold text-slate-900 mt-1">4,281</p>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-sm text-green-600 font-semibold">+18.5%</span>
                    <div class="p-2 rounded-full bg-blue-100 text-blue-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2">
                            </path>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="pro-card p-6 bg-white rounded-xl shadow-md flex flex-col justify-between h-36">
                <div>
                    <p class="text-sm font-medium text-slate-500">Total Revenue</p>
                    <p class="text-xl font-bold text-slate-900 mt-1">$45,390</p>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-sm text-green-600 font-semibold">+12.1%</span>
                    <div class="p-2 rounded-full bg-green-100 text-green-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8V4m0 16v-2.5"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="pro-card p-6 bg-white rounded-xl shadow-md flex flex-col justify-between h-36">
                <div>
                    <p class="text-sm font-medium text-slate-500">Service Requests</p>
                    <p class="text-xl font-bold text-slate-900 mt-1">5,120</p>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-sm text-red-600 font-semibold">-1.2%</span>
                    <div class="p-2 rounded-full bg-indigo-100 text-indigo-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                            </path>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="pro-card p-6 bg-white rounded-xl shadow-md flex flex-col justify-between h-36">
                <div>
                    <p class="text-sm font-medium text-slate-500">Total Users</p>
                    <p class="text-xl font-bold text-slate-900 mt-1">18,340</p>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-sm text-green-600 font-semibold">+5.5%</span>
                    <div class="p-2 rounded-full bg-purple-100 text-purple-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 4.354a4 4 0 110 5.292M20 10a8 8 0 10-16 0 8 8 0 0016 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="pro-card p-6 bg-white rounded-xl shadow-md flex flex-col justify-between h-36">
                <div>
                    <p class="text-sm font-medium text-slate-500">Total Providers</p>
                    <p class="text-xl font-bold text-slate-900 mt-1">1,120</p>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-sm text-yellow-600 font-semibold">0.0%</span>
                    <div class="p-2 rounded-full bg-yellow-100 text-yellow-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 13.255A23.564 23.564 0 0112 15c-3.185 0-6.223-.82-8.941-2.075M1 10l9.746 5.865a2 2 0 002.508 0L23 10">
                            </path>
                        </svg>
                    </div>
                </div>
            </div>

            <div
                class="pro-card p-6 bg-white rounded-xl shadow-md flex flex-col justify-between h-36 border-l-4 border-red-500">
                <div>
                    <p class="text-sm font-medium text-slate-500">Pending KYC</p>
                    <p class="text-xl font-bold text-red-600 mt-1">45</p>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-sm text-red-600 font-semibold">+3.1%</span>
                    <div class="p-2 rounded-full bg-red-100 text-red-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.398 16c-.77 1.333.192 3 1.732 3z">
                            </path>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="pro-card p-6 bg-white rounded-xl shadow-md flex flex-col justify-between h-36">
                <div>
                    <p class="text-sm font-medium text-slate-500">Live Orders</p>
                    <p class="text-xl font-bold text-slate-900 mt-1">15</p>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-sm text-slate-500 font-semibold">Today</span>
                    <div class="p-2 rounded-full bg-orange-100 text-orange-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="pro-card p-6 bg-white rounded-xl shadow-md flex flex-col justify-between h-36">
                <div>
                    <p class="text-sm font-medium text-slate-500">Active Riders</p>
                    <p class="text-xl font-bold text-slate-900 mt-1">210</p>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-sm text-green-600 font-semibold">Online</span>
                    <div class="p-2 rounded-full bg-lime-100 text-lime-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0h6">
                            </path>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="pro-card p-6 bg-white rounded-xl shadow-md flex flex-col justify-between h-36">
                <div>
                    <p class="text-sm font-medium text-slate-500">Withdraw Requests</p>
                    <p class="text-xl font-bold   mt-1">12</p>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-sm text-slate-500 font-semibold">Pending</span>
                    <div class="p-2 rounded-full bg-amber-100 text-amber-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-2h2m4-4H9m6 4h4m-4 0v-2m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6-4h4">
                            </path>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="pro-card p-6 bg-white rounded-xl shadow-md flex flex-col justify-between h-36">
                <div>
                    <p class="text-sm font-medium text-slate-500">Refund Requests</p>
                    <p class="text-3xl font-bold   mt-1">8</p>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-sm text-slate-500 font-semibold">In Review</span>
                    <div class="p-2 rounded-full bg-pink-100 text-pink-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <div
                class="pro-card p-6 bg-white rounded-xl shadow-md flex flex-col justify-between h-36 border-l-4 border-red-500">
                <div>
                    <p class="text-sm font-medium text-slate-500">SLA Alerts</p>
                    <p class="text-xl font-bold  mt-1">3</p>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-sm text-red-600 font-semibold">Critical</span>
                    <div class="p-2 rounded-full bg-red-100 text-red-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>

        </div>
    </section>
    <section class="mb-10">
        <h3 class="text-2xl font-semibold text-slate-800 mb-5">Performance Charts</h3>

        <div class="grid grid-cols-1 gap-6 mb-8">
            <div class="pro-card p-6 bg-white rounded-xl shadow-md">
                <h4 class="text-xl font-semibold text-slate-800 mb-4">Monthly Revenue Bar Chart</h4>
                <div id="monthly-revenue-bar-chart" class="h-80"></div>
            </div>
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <div class="pro-card p-6 bg-white rounded-xl shadow-md">
                    <h4 class="text-xl font-semibold text-slate-800 mb-4">Yearly Revenue Overview (Area)</h4>
                    <div id="yearly-revenue-overview-chart" class="h-80"></div>
                </div>
                <div class="pro-card p-6 bg-white rounded-xl shadow-md">
                    <h4 class="text-xl font-semibold text-slate-800 mb-4">Revenue Per Category (Donut)</h4>
                    <div id="revenue-per-category-chart" class="h-80"></div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 gap-6 mb-8">
            <div class="pro-card p-6 bg-white rounded-xl shadow-md">
                <h4 class="text-xl font-semibold text-slate-800 mb-4">Rider Delivery Performance (Line)</h4>
                <div id="rider-delivery-performance-chart" class="h-80"></div>
            </div>
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <div class="pro-card p-6 bg-white rounded-xl shadow-md">
                    <h4 class="text-xl font-semibold text-slate-800 mb-4">Successful vs Failed Deliveries (Bar)</h4>
                    <div id="successful-failed-deliveries-chart" class="h-80"></div>
                </div>
                <div class="pro-card p-6 bg-white rounded-xl shadow-md">
                    <h4 class="text-xl font-semibold text-slate-800 mb-4">Rider Activity Heatmap (Placeholder)</h4>
                    <div id="rider-activity-heatmap" class="h-80">
                        <div class="text-center py-20 text-slate-400">Heatmap visualization requires specialized libraries or a geographical data source.<br>This is a visual placeholder.</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 gap-6 mb-8">
            <div class="pro-card p-6 bg-white rounded-xl shadow-md">
                <h4 class="text-xl font-semibold text-slate-800 mb-4">Monthly Service Volume (Line)</h4>
                <div id="monthly-service-volume-chart" class="h-80"></div>
            </div>
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <div class="pro-card p-6 bg-white rounded-xl shadow-md">
                    <h4 class="text-xl font-semibold text-slate-800 mb-4">Category Performance Comparison (Bar)</h4>
                    <div id="category-performance-comparison-chart" class="h-80"></div>
                </div>
                <div class="pro-card p-6 bg-white rounded-xl shadow-md">
                    <h4 class="text-xl font-semibold text-slate-800 mb-4">Live vs Pending vs Completed Orders (Pie)</h4>
                    <div id="orders-status-chart" class="h-80"></div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
            <div class="pro-card p-6 bg-white rounded-xl shadow-md">
                <h4 class="text-xl font-semibold text-slate-800 mb-4">Provider Conversion Funnel (Bar)</h4>
                <div id="provider-conversion-funnel-chart" class="h-80"></div>
            </div>
            <div class="pro-card p-6 bg-white rounded-xl shadow-md">
                <h4 class="text-xl font-semibold text-slate-800 mb-4">Top Performing Providers (Bar)</h4>
                <div id="top-providers-chart" class="h-80"></div>
            </div>
            <div class="pro-card p-6 bg-white rounded-xl shadow-md">
                <h4 class="text-xl font-semibold text-slate-800 mb-4">Provider Category Coverage (Bar/Table)</h4>
                <div id="provider-category-coverage-chart" class="h-80"></div>
            </div>
        </div>

    </section>

  

    <section class="mb-10">
        <h3 class="text-2xl font-semibold text-slate-800 mb-5">Key Activity & Queues</h3>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

            <div class="pro-card p-6 bg-white rounded-xl shadow-md">
                <div class="flex justify-between items-center mb-4">
                    <h4 class="text-xl font-semibold text-slate-800">Live Orders (15)</h4>
                    <a href="#" class="text-sm text-blue-600 hover:text-blue-700 font-medium">View All</a>
                </div>
                <div class="h-96 overflow-y-auto space-y-3 pr-2">
                    <div class="border-b border-l-4 border-indigo-500 pl-3 py-2">
                        <p class="text-sm text-slate-900 font-medium truncate">Order #ORD-2940 - AC Repair</p>
                        <p class="text-xs text-slate-500">User: Jane Doe | Rider: John S.</p>
                        <span class="text-xs text-orange-500 font-semibold">En Route (Est. 15m)</span>
                    </div>
                    <div class="border-b border-l-4 border-indigo-500 pl-3 py-2">
                        <p class="text-sm text-slate-900 font-medium truncate">Order #ORD-2941 - Plumbing</p>
                        <p class="text-xs text-slate-500">User: Mike T. | Provider: ProFix</p>
                        <span class="text-xs text-green-500 font-semibold">Started (08:15 AM)</span>
                    </div>
                    <div class="border-b border-l-4 border-indigo-500 pl-3 py-2">
                        <p class="text-sm text-slate-900 font-medium truncate">Order #ORD-2942 - Cleaning</p>
                        <p class="text-xs text-slate-500">User: Sarah K. | Rider: Pending</p>
                        <span class="text-xs text-blue-500 font-semibold">Searching Rider</span>
                    </div>
                    <div class="text-center pt-4 text-slate-400 text-sm">... 12 more orders live ...</div>
                </div>
            </div>

            <div class="pro-card p-6 bg-white rounded-xl shadow-md">
                <div class="flex justify-between items-center mb-4">
                    <h4 class="text-xl font-semibold text-slate-800">Pending KYC (45)</h4>
                    <a href="#" class="text-sm text-blue-600 hover:text-blue-700 font-medium">Review All</a>
                </div>
                <div class="h-96 overflow-y-auto space-y-3 pr-2">
                    <div class="border-b border-l-4 border-red-500 pl-3 py-2">
                        <p class="text-sm text-slate-900 font-medium truncate">Provider: Jane Doe</p>
                        <p class="text-xs text-slate-500">Document: ID & License</p>
                        <span class="text-xs text-red-500 font-semibold">Urgent - 3 Days Pending</span>
                    </div>
                    <div class="border-b border-l-4 border-yellow-500 pl-3 py-2">
                        <p class="text-sm text-slate-900 font-medium truncate">Rider: Alex Johnson</p>
                        <p class="text-xs text-slate-500">Document: Background Check</p>
                        <span class="text-xs text-yellow-600 font-semibold">4 Hours Pending</span>
                    </div>
                    <div class="border-b border-l-4 border-red-500 pl-3 py-2">
                        <p class="text-sm text-slate-900 font-medium truncate">Provider: ProFix Services</p>
                        <p class="text-xs text-slate-500">Document: Business Permit</p>
                        <span class="text-xs text-red-500 font-semibold">Urgent - 5 Days Pending</span>
                    </div>
                    <div class="text-center pt-4 text-slate-400 text-sm">... 42 more KYC pending ...</div>
                </div>
            </div>

            <div class="pro-card p-6 bg-white rounded-xl shadow-md">
                <div class="flex justify-between items-center mb-4">
                    <h4 class="text-xl font-semibold text-slate-800">Withdraw Requests (12)</h4>
                    <a href="#" class="text-sm text-blue-600 hover:text-blue-700 font-medium">Process All</a>
                </div>
                <div class="h-96 overflow-y-auto space-y-3 pr-2">
                    <div class="border-b border-l-4 border-amber-500 pl-3 py-2">
                        <p class="text-sm text-slate-900 font-medium truncate">Provider: John Smith - **$500**</p>
                        <p class="text-xs text-slate-500">Wallet Balance: $1,200 | Method: Bank</p>
                        <span class="text-xs text-amber-600 font-semibold">2 Days Pending</span>
                    </div>
                    <div class="border-b border-l-4 border-amber-500 pl-3 py-2">
                        <p class="text-sm text-slate-900 font-medium truncate">Rider: Michael A. - **$50**</p>
                        <p class="text-xs text-slate-500">Wallet Balance: $80 | Method: Wallet</p>
                        <span class="text-xs text-amber-600 font-semibold">Today</span>
                    </div>
                    <div class="text-center pt-4 text-slate-400 text-sm">... 10 more withdraws pending ...</div>
                </div>
            </div>

            <div class="pro-card p-6 bg-white rounded-xl shadow-md">
                <div class="flex justify-between items-center mb-4">
                    <h4 class="text-xl font-semibold text-slate-800">Refund Requests (8)</h4>
                    <a href="#" class="text-sm text-blue-600 hover:text-blue-700 font-medium">Review All</a>
                </div>
                <div class="h-96 overflow-y-auto space-y-3 pr-2">
                    <div class="border-b border-l-4 border-pink-500 pl-3 py-2">
                        <p class="text-sm text-slate-900 font-medium truncate">Order #ORD-2930 - **$45.00**</p>
                        <p class="text-xs text-slate-500">Reason: Service Cancellation | Status: Pending</p>
                        <span class="text-xs text-pink-600 font-semibold">User: Sarah K.</span>
                    </div>
                    <div class="border-b border-l-4 border-pink-500 pl-3 py-2">
                        <p class="text-sm text-slate-900 font-medium truncate">Order #ORD-2935 - **$100.00**</p>
                        <p class="text-xs text-slate-500">Reason: Quality Issue | Status: Investigation</p>
                        <span class="text-xs text-pink-600 font-semibold">Provider: ProFix</span>
                    </div>
                    <div class="text-center pt-4 text-slate-400 text-sm">... 6 more refund requests ...</div>
                </div>
            </div>

            <div class="pro-card p-6 bg-white rounded-xl shadow-md">
                <div class="flex justify-between items-center mb-4">
                    <h4 class="text-xl font-semibold text-slate-800">SLA Alerts (3)</h4>
                    <a href="#" class="text-sm text-blue-600 hover:text-blue-700 font-medium">Acknowledge All</a>
                </div>
                <div class="h-96 overflow-y-auto space-y-3 pr-2">
                    <div class="border-b border-l-4 border-red-600 pl-3 py-2">
                        <p class="text-sm text-red-600 font-medium truncate">**CRITICAL**: Order #ORD-2938</p>
                        <p class="text-xs text-slate-500">Breach: Dispatch time > 30 mins</p>
                        <span class="text-xs text-red-600 font-semibold">15 mins ago</span>
                    </div>
                    <div class="border-b border-l-4 border-orange-500 pl-3 py-2">
                        <p class="text-sm text-orange-600 font-medium truncate">**HIGH**: Service Request #SR-120</p>
                        <p class="text-xs text-slate-500">Breach: Resolution time approaching limit</p>
                        <span class="text-xs text-orange-600 font-semibold">3 hours ago</span>
                    </div>
                    <div class="text-center pt-4 text-slate-400 text-sm">... 1 more SLA alert ...</div>
                </div>
            </div>

            <div class="pro-card p-6 bg-white rounded-xl shadow-md">
                <div class="flex justify-between items-center mb-4">
                    <h4 class="text-xl font-semibold text-slate-800">Active Riders (210)</h4>
                    <a href="#" class="text-sm text-blue-600 hover:text-blue-700 font-medium">View Map</a>
                </div>
                <div class="h-96 overflow-y-auto space-y-3 pr-2">
                    <div class="border-b border-l-4 border-lime-500 pl-3 py-2">
                        <p class="text-sm text-slate-900 font-medium truncate">Rider: John Smith (ID: R-001)</p>
                        <p class="text-xs text-slate-500">Last Ping: 1 min ago | Status: Available</p>
                        <span class="text-xs text-green-600 font-semibold">3.2km from center</span>
                    </div>
                    <div class="border-b border-l-4 border-lime-500 pl-3 py-2">
                        <p class="text-sm text-slate-900 font-medium truncate">Rider: Jane Doe (ID: R-002)</p>
                        <p class="text-xs text-slate-500">Last Ping: 5 mins ago | Status: On Delivery</p>
                        <span class="text-xs text-blue-600 font-semibold">Near Order #2940</span>
                    </div>
                    <div class="text-center pt-4 text-slate-400 text-sm">... 208 more riders active ...</div>
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
        #orders-status-chart{
            text-align: -webkit-center;
        }
    </style>
@endpush