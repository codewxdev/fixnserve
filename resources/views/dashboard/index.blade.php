@extends('layouts.app')

@section('content')
    <h2 class="text-3xl font-bold text-slate-800 mb-6">Dashboard Overview</h2>

    <!-- 1. Key Performance Indicators (KPIs) -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        
        <!-- Total Bookings KPI -->
        <div class="pro-card p-6 bg-white flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-slate-500">Total Bookings</p>
                <p class="text-3xl font-extrabold text-slate-900 mt-1">4,281</p>
                <span class="text-sm text-green-600 font-semibold">+18.5% <span class="text-slate-500 font-normal">vs last month</span></span>
            </div>
            <div class="p-3 rounded-full bg-blue-100 text-blue-600">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
            </div>
        </div>

        <!-- Total Revenue KPI -->
        <div class="pro-card p-6 bg-white flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-slate-500">Total Revenue</p>
                <p class="text-3xl font-extrabold text-slate-900 mt-1">$45,390</p>
                <span class="text-sm text-green-600 font-semibold">+12.1% <span class="text-slate-500 font-normal">vs last month</span></span>
            </div>
            <div class="p-3 rounded-full bg-green-100 text-green-600">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8V4m0 16v-2.5"></path></svg>
            </div>
        </div>
        
        <!-- Active Providers KPI -->
        <div class="pro-card p-6 bg-white flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-slate-500">Active Providers</p>
                <p class="text-3xl font-extrabold text-slate-900 mt-1">1,120</p>
                <span class="text-sm text-yellow-600 font-semibold">-0.5% <span class="text-slate-500 font-normal">vs last month</span></span>
            </div>
            <div class="p-3 rounded-full bg-yellow-100 text-yellow-600">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.564 23.564 0 0112 15c-3.185 0-6.223-.82-8.941-2.075M1 10l9.746 5.865a2 2 0 002.508 0L23 10"></path></svg>
            </div>
        </div>

        <!-- Open Complaints KPI -->
        <div class="pro-card p-6 bg-white flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-slate-500">Open Complaints</p>
                <p class="text-3xl font-extrabold text-slate-900 mt-1">45</p>
                <span class="text-sm text-red-600 font-semibold">+3.1% <span class="text-slate-500 font-normal">vs last month</span></span>
            </div>
            <div class="p-3 rounded-full bg-red-100 text-red-600">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.398 16c-.77 1.333.192 3 1.732 3z"></path></svg>
            </div>
        </div>

    </div>

    <!-- 2. Main Content (Chart and Activity Logs) -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <!-- Monthly Performance Chart (2/3 width) -->
        <div class="lg:col-span-2">
            <h3 class="text-xl font-semibold text-slate-800 mb-4">Monthly Platform Performance</h3>
            <div id="dashboard-chart" class="h-96">
                <!-- ApexChart will render here -->
                <div class="text-center py-20 text-slate-400">Loading Performance Data...</div>
            </div>
        </div>

        <!-- Recent Activity Logs (1/3 width) -->
        <div class="lg:col-span-1">
            <h3 class="text-xl font-semibold text-slate-800 mb-4">Recent Audit Logs</h3>
            <div class="pro-card bg-white p-6 h-96 overflow-y-auto">
                <ul class="space-y-4">
                    
                    <!-- Log Item Example 1 (Provider Verification) -->
                    <li class="border-l-4 border-green-500 pl-4 py-1">
                        <p class="text-sm text-slate-900 font-medium">Provider **Jane Doe** verified.</p>
                        <p class="text-xs text-slate-500">System updated service category listing.</p>
                        <span class="text-xs text-slate-400">5 minutes ago by Super Admin</span>
                    </li>

                    <!-- Log Item Example 2 (Wallet Adjustment) -->
                    <li class="border-l-4 border-blue-500 pl-4 py-1">
                        <p class="text-sm text-slate-900 font-medium">Wallet credit applied to **User #A7F**.</p>
                        <p class="text-xs text-slate-500">Adjustment of $50 for refund processing.</p>
                        <span class="text-xs text-slate-400">1 hour ago by Finance Manager</span>
                    </li>

                    <!-- Log Item Example 3 (System Settings Change) -->
                    <li class="border-l-4 border-yellow-500 pl-4 py-1">
                        <p class="text-sm text-slate-900 font-medium">Gateway setting **Stripe** updated.</p>
                        <p class="text-xs text-slate-500">API Key rotated due to security audit.</p>
                        <span class="text-xs text-slate-400">Yesterday by Super Admin</span>
                    </li>

                    <!-- Log Item Example 4 (New Order) -->
                    <li class="border-l-4 border-indigo-500 pl-4 py-1">
                        <p class="text-sm text-slate-900 font-medium">New Order **#ORD-2940** created.</p>
                        <p class="text-xs text-slate-500">Home Repair service booked in London.</p>
                        <span class="text-xs text-slate-400">2 days ago (Automated)</span>
                    </li>

                    <!-- Repeat log items for visual effect -->
                    <li class="border-l-4 border-red-500 pl-4 py-1"><p class="text-sm text-slate-900 font-medium">Vendor **Mart 1** suspended.</p><p class="text-xs text-slate-500">Failed product quality check.</p><span class="text-xs text-slate-400">3 days ago by Vendor Manager</span></li>
                    <li class="border-l-4 border-green-500 pl-4 py-1"><p class="text-sm text-slate-900 font-medium">Provider **John Smith** verified.</p><p class="text-xs text-slate-500">System updated service category listing.</p><span class="text-xs text-slate-400">5 days ago by Super Admin</span></li>

                </ul>
            </div>
        </div>

    </div>
@endsection

@section('scripts')
    <!-- Include the chart logic -->
    <script src="/js/charts/dashboard-charts.js"></script>
    <!-- Note: In a real Laravel project, you would use: <script src=" }"></script> -->
@endsection