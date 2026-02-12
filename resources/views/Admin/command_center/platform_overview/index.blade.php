{{-- modules/platform/overview.blade.php --}}
@extends('layouts.app')

@section('content')
    <div class="p-6">
        
        {{-- Header & Global Controls --}}
        <div class="flex flex-col md:flex-row md:items-center justify-between mb-8 gap-4">
            <div>
                <h2 class="text-2xl font-bold theme-text-main">Platform Overview</h2>
                <p class="text-sm theme-text-muted">Real-time snapshot of platform performance across all verticals.</p>
            </div>
            
            <div class="flex items-center gap-2 theme-bg-card p-1 rounded-lg border theme-border shadow-sm">
                <button class="px-4 py-2 text-sm font-medium theme-text-muted hover:bg-white/5 rounded-md transition-colors">7d</button>
                <button class="px-4 py-2 text-sm font-medium text-white rounded-md shadow-sm" 
                        style="background-color: rgb(var(--brand-primary));">30d</button>
                <button class="px-4 py-2 text-sm font-medium theme-text-muted hover:bg-white/5 rounded-md transition-colors">90d</button>
                <div class="h-6 w-px mx-1" style="background-color: rgb(var(--border-color));"></div>
                <button class="px-4 py-2 text-sm font-medium theme-text-muted hover:text-blue-500 flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                    Export
                </button>
            </div>
        </div>

        {{-- FEATURE: KPI SUMMARY --}}
        <section class="mb-10">
            <h3 class="text-lg font-bold theme-text-main mb-4 flex items-center gap-2">
                KPI Summary
                <span class="theme-text-muted cursor-help" title=" aggregated metrics from all verticals">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </span>
            </h3>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">

                <div class="theme-bg-card p-5 rounded-2xl shadow-sm border theme-border hover:shadow-lg transition-all duration-300 group relative">
                    <div class="flex justify-between items-start mb-4">
                        <div class="p-2.5 rounded-xl bg-teal-500/10 text-teal-400">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <svg class="w-20 h-10 text-teal-500 opacity-50" viewBox="0 0 100 40" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M0 35 Q 25 35, 50 10 T 100 5" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </div>
                    <div class="mb-1">
                        <span class="text-sm font-medium theme-text-muted">Gross Merchandise Value</span>
                    </div>
                    <h4 class="text-3xl font-bold theme-text-main">$4.85M</h4>
                    <div class="flex items-center mt-2 gap-2 text-sm">
                        <span class="text-emerald-400 font-bold bg-emerald-500/10 px-2 py-0.5 rounded-full flex items-center">
                            ↑ 15.8%
                        </span>
                        <span class="theme-text-muted opacity-70">vs last period</span>
                    </div>
                </div>

                <div class="theme-bg-card p-5 rounded-2xl shadow-sm border theme-border hover:shadow-lg transition-all duration-300 group">
                    <div class="flex justify-between items-start mb-4">
                        <div class="p-2.5 rounded-xl bg-indigo-500/10 text-indigo-400">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                        </div>
                        <svg class="w-20 h-10 text-indigo-500 opacity-50" viewBox="0 0 100 40" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M0 30 L 20 25 L 40 32 L 60 15 L 80 20 L 100 5" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </div>
                    <div class="mb-1">
                        <span class="text-sm font-medium theme-text-muted">Net Platform Revenue</span>
                    </div>
                    <h4 class="text-3xl font-bold theme-text-main">$612K</h4>
                    <div class="flex items-center mt-2 gap-2 text-sm">
                        <span class="text-emerald-400 font-bold bg-emerald-500/10 px-2 py-0.5 rounded-full flex items-center">
                            ↑ 18.2%
                        </span>
                        <span class="theme-text-muted opacity-70">vs last period</span>
                    </div>
                </div>

                <div class="theme-bg-card p-5 rounded-2xl shadow-sm border theme-border hover:shadow-lg transition-all duration-300 group">
                    <div class="flex justify-between items-start mb-4">
                        <div class="p-2.5 rounded-xl bg-purple-500/10 text-purple-400">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                        </div>
                        <div class="flex -space-x-2">
                            <div class="w-6 h-6 rounded-full bg-blue-900 border-2 border-slate-700 flex items-center justify-center text-[10px] text-blue-300 font-bold" title="Consultants">C</div>
                            <div class="w-6 h-6 rounded-full bg-orange-900 border-2 border-slate-700 flex items-center justify-center text-[10px] text-orange-300 font-bold" title="Vendors">V</div>
                            <div class="w-6 h-6 rounded-full bg-rose-900 border-2 border-slate-700 flex items-center justify-center text-[10px] text-rose-300 font-bold" title="Riders">R</div>
                        </div>
                    </div>
                    <div class="mb-1">
                        <span class="text-sm font-medium theme-text-muted">Active Supply Base</span>
                    </div>
                    <h4 class="text-3xl font-bold theme-text-main">8,900</h4>
                    <div class="flex items-center mt-2 gap-2 text-sm">
                        <span class="text-emerald-400 font-bold bg-emerald-500/10 px-2 py-0.5 rounded-full flex items-center">
                            ↑ 9.1%
                        </span>
                        <span class="theme-text-muted opacity-70">Total Active</span>
                    </div>
                </div>

                <div class="theme-bg-card p-5 rounded-2xl shadow-sm border theme-border hover:shadow-lg transition-all duration-300 group">
                    <div class="flex justify-between items-start mb-4">
                        <div class="p-2.5 rounded-xl bg-blue-500/10 text-blue-400">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                        </div>
                        <svg class="w-20 h-10 text-blue-500 opacity-50" viewBox="0 0 100 40" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M0 35 L 20 20 L 40 25 L 60 10 L 80 15 L 100 5" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </div>
                    <div class="mb-1">
                        <span class="text-sm font-medium theme-text-muted">Total Orders</span>
                    </div>
                    <h4 class="text-3xl font-bold theme-text-main">24,592</h4>
                    <div class="flex items-center mt-2 gap-2 text-sm">
                        <span class="text-emerald-400 font-bold bg-emerald-500/10 px-2 py-0.5 rounded-full flex items-center">
                            ↑ 5.4%
                        </span>
                        <span class="theme-text-muted opacity-70">New bookings</span>
                    </div>
                </div>

                <div class="theme-bg-card p-5 rounded-2xl shadow-sm border theme-border hover:shadow-lg transition-all duration-300 group">
                    <div class="flex justify-between items-start mb-4">
                        <div class="p-2.5 rounded-xl bg-cyan-500/10 text-cyan-400">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                        </div>
                        <span class="text-xs font-bold theme-text-muted uppercase tracking-wide">MAU</span>
                    </div>
                    <div class="mb-1">
                        <span class="text-sm font-medium theme-text-muted">Active Users</span>
                    </div>
                    <h4 class="text-3xl font-bold theme-text-main">128,450</h4>
                    <div class="flex items-center mt-2 gap-2 text-sm">
                        <span class="text-emerald-400 font-bold bg-emerald-500/10 px-2 py-0.5 rounded-full flex items-center">
                            ↑ 12.4%
                        </span>
                        <span class="theme-text-muted opacity-70">vs last month</span>
                    </div>
                </div>

                <div class="theme-bg-card p-5 rounded-2xl shadow-sm border theme-border hover:shadow-lg transition-all duration-300 group">
                    <div class="flex justify-between items-start mb-4">
                        <div class="p-2.5 rounded-xl bg-rose-500/10 text-rose-400">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                        </div>
                        <span class="flex h-3 w-3 relative">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-rose-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-3 w-3 bg-rose-500"></span>
                        </span>
                    </div>
                    <div class="mb-1">
                        <span class="text-sm font-medium theme-text-muted">Failed Transactions</span>
                    </div>
                    <h4 class="text-3xl font-bold theme-text-main">142</h4>
                    <div class="flex items-center mt-2 gap-2 text-sm">
                        <span class="text-rose-400 font-bold bg-rose-500/10 px-2 py-0.5 rounded-full flex items-center">
                            ↑ 2.1%
                        </span>
                        <span class="theme-text-muted opacity-70">Action Needed</span>
                    </div>
                </div>

                <div class="theme-bg-card p-5 rounded-2xl shadow-sm border theme-border hover:shadow-lg transition-all duration-300 group">
                    <div class="flex justify-between items-start mb-4">
                        <div class="p-2.5 rounded-xl bg-amber-500/10 text-amber-400">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                         <span class="text-xs font-bold text-amber-400 bg-amber-500/10 border border-amber-500/20 px-2 py-0.5 rounded">
                            Requires Approval
                        </span>
                    </div>
                    <div class="mb-1">
                        <span class="text-sm font-medium theme-text-muted">Pending Payouts</span>
                    </div>
                    <h4 class="text-3xl font-bold theme-text-main">$18,240</h4>
                    <div class="flex items-center mt-2 gap-2 text-sm">
                        <span class="theme-text-muted">
                            <span class="font-bold theme-text-main">12</span> Requests
                        </span>
                    </div>
                </div>

                <div class="theme-bg-card p-5 rounded-2xl shadow-sm border theme-border hover:shadow-lg transition-all duration-300 group">
                    <div class="flex justify-between items-start mb-4">
                        <div class="p-2.5 rounded-xl bg-green-500/10 text-green-400">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                         <span class="text-xs font-bold text-purple-400 bg-purple-500/10 px-2 py-0.5 rounded border border-purple-500/20">
                            AI Monitored
                        </span>
                    </div>
                    <div class="mb-1">
                        <span class="text-sm font-medium theme-text-muted">System Status</span>
                    </div>
                    <h4 class="text-xl font-bold text-emerald-400 mt-1">Operational</h4>
                    <div class="flex items-center mt-3 gap-2 text-xs">
                        <span class="theme-text-muted opacity-70">No anomalies detected</span>
                    </div>
                </div>

            </div>
        </section>

        {{-- FEATURE: GROWTH INDICATORS --}}
        <section class="mb-10">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-2xl font-semibold theme-text-main">Growth Indicators</h3>
                <div class="flex items-center gap-2">
                     <span class="text-sm theme-text-muted mr-2">Compare:</span>
                     <label class="inline-flex items-center cursor-pointer">
                        <input type="checkbox" value="" class="sr-only peer">
                        <div class="relative w-11 h-6 bg-slate-700 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all" style="background-color: rgb(var(--border-color));" :style="checked ? 'background-color: rgb(var(--brand-primary));' : ''"></div>
                        <span class="ms-3 text-sm font-medium theme-text-main">Previous Period</span>
                    </label>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
                
                <div class="pro-card p-6 theme-bg-card rounded-xl shadow-md border theme-border">
                    <div class="flex justify-between items-center mb-2">
                        <h4 class="text-xl font-semibold theme-text-main">GMV Growth (MoM)</h4>
                         <span class="text-xs text-green-400 bg-green-500/10 px-2 py-1 rounded-full font-bold">+12% Predicted</span>
                    </div>
                    <p class="text-sm theme-text-muted mb-4">Consistent month-over-month transaction growth (Last 6 Months).</p>
                    <div id="gmv-growth-trend-chart" class="h-80"></div>
                </div>

                <div class="pro-card p-6 theme-bg-card rounded-xl shadow-md border theme-border">
                    <div class="flex justify-between items-center mb-2">
                        <h4 class="text-xl font-semibold theme-text-main">Yearly Revenue Overview (QoQ)</h4>
                        <button class="theme-text-muted hover:text-blue-500"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg></button>
                    </div>
                    <p class="text-sm theme-text-muted mb-4">Quarter over Quarter revenue performance comparison.</p>
                    <div id="yearly-revenue-overview-chart" class="h-80"></div>
                </div>

                <div class="pro-card p-6 theme-bg-card rounded-xl shadow-md border theme-border">
                    <div class="flex justify-between items-center mb-2">
                        <h4 class="text-xl font-semibold theme-text-main">Supply Growth & Conversion</h4>
                    </div>
                     <p class="text-sm theme-text-muted mb-4">Partner Onboarding Funnel efficiency.</p>
                    <div id="provider-conversion-funnel-chart" class="h-80"></div>
                </div>

                <div class="pro-card p-6 theme-bg-card rounded-xl shadow-md border theme-border">
                    <div class="flex justify-between items-center mb-2">
                        <h4 class="text-xl font-semibold theme-text-main">Cohort Retention %</h4>
                         <span class="text-xs text-blue-400 bg-blue-500/10 px-2 py-1 rounded-full font-bold">New Metric</span>
                    </div>
                     <p class="text-sm theme-text-muted mb-4">User retention over 12-week periods.</p>
                    <div id="monthly-service-volume-chart" class="h-80"></div> 
                </div>

            </div>
        </section>

    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script src="{{ asset('charts/dashboard-charts.js') }}"></script>
@endpush