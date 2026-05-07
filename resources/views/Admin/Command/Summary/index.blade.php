@extends('Layouts.app')

@section('content')
    <div class="p-4 sm:p-6 lg:p-8 bg-bg-primary min-h-screen" x-data="executiveDashboard()">

        <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center mb-8 gap-5">
            <div class="w-full lg:w-auto">
                <h1 class="text-h2 sm:text-h1 font-bold text-text-primary flex flex-wrap items-center gap-3">
                    Executive Dashboard
                    <span
                        class="px-1.5 sm:px-2 py-0.5 bg-brand-primary/10 text-brand-primary text-[8px] sm:text-[10px] font-bold uppercase rounded-md border border-brand-primary/20 tracking-wider whitespace-nowrap shadow-sm">
                        Live Sync
                    </span>
                </h1>
                <p class="text-body-sm text-text-secondary mt-1">Real-time platform performance, AI forecasts, and business
                    health.</p>
            </div>

            <div class="flex flex-col sm:flex-row flex-wrap items-start sm:items-center gap-3 w-full lg:w-auto">
                <div
                    class="flex items-center justify-between w-full sm:w-auto bg-bg-secondary p-1 rounded-lg border border-border-default shadow-sm">
                    <button @click="setRange('today')"
                        :class="selectedRange === 'today' ? 'text-white bg-brand-primary shadow-sm' :
                            'text-text-secondary hover:bg-bg-tertiary'"
                        class="flex-1 sm:flex-none px-3 py-1.5 text-caption font-medium rounded-md transition-colors">Today</button>
                    <button @click="setRange('7d')"
                        :class="selectedRange === '7d' ? 'text-white bg-brand-primary shadow-sm' :
                            'text-text-secondary hover:bg-bg-tertiary'"
                        class="flex-1 sm:flex-none px-3 py-1.5 text-caption font-medium rounded-md transition-colors">7d</button>
                    <button @click="setRange('30d')"
                        :class="selectedRange === '30d' ? 'text-white bg-brand-primary shadow-sm' :
                            'text-text-secondary hover:bg-bg-tertiary'"
                        class="flex-1 sm:flex-none px-3 py-1.5 text-caption font-medium rounded-md transition-colors">30d</button>
                    <button @click="setRange('ytd')"
                        :class="selectedRange === 'ytd' ? 'text-white bg-brand-primary shadow-sm' :
                            'text-text-secondary hover:bg-bg-tertiary'"
                        class="flex-1 sm:flex-none px-3 py-1.5 text-caption font-medium rounded-md transition-colors">YTD</button>
                </div>

                <div class="flex items-center gap-2 w-full sm:w-auto">
                    <button @click="shareDashboard()"
                        class="btn btn-sm flex-1 sm:flex-none flex items-center justify-center gap-2 transition-all duration-300
           /* Light Mode */
           bg-bg-secondary text-text-primary border border-border-default
           hover:!border-[#1169FB] hover:!text-[#1169FB] hover:!bg-[#1169FB]/5
           /* Dark Mode */
           dark:bg-bg-tertiary dark:text-text-secondary dark:border-border-strong
           dark:hover:!border-[#1169FB] dark:hover:!text-[#1169FB] dark:hover:!bg-[#1169FB]/10">
                        <i data-lucide="share-2" class="w-4 h-4 transition-colors"></i>
                        <span class="font-bold">Share</span>
                    </button>
                    <button @click="exportSnapshot()"
                        class="btn btn-primary btn-sm flex-1 sm:flex-none flex items-center justify-center gap-2">
                        <i data-lucide="download" class="w-4 h-4"></i> Export PDF
                    </button>
                </div>
            </div>
        </div>

        <div class="mb-2">
            <h3 class="text-label text-text-secondary mb-4 flex items-center gap-2">
                <i data-lucide="landmark" class="w-4 h-4"></i> Revenue & Platform Financials
            </h3>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4 sm:gap-5 mb-8">

            <div class="card p-5 relative overflow-visible group">
                <div class="flex justify-between items-start mb-2">
                    <div class="relative flex items-center gap-2 cursor-help group/tooltip">
                        <span class="text-caption font-bold text-text-tertiary uppercase tracking-wider">MRR</span>
                        <i data-lucide="info" class="w-3 h-3 text-text-tertiary hidden sm:block"></i>
                        <div
                            class="absolute bottom-full left-0 mb-2 w-max max-w-[200px] p-2 bg-bg-tertiary border border-border-strong text-text-primary text-[10px] rounded shadow-lg opacity-0 invisible group-hover/tooltip:opacity-100 group-hover/tooltip:visible transition-all z-50 whitespace-normal">
                            Formula: SUM(Active Subscriptions) + Expansion - Churn
                        </div>
                    </div>
                    <div class="dropdown relative" x-data="{ open: false }" @click.away="open = false">
                        <button @click="open = !open" class="text-text-tertiary hover:text-text-primary"><i
                                data-lucide="more-horizontal" class="w-4 h-4"></i></button>
                        <div x-show="open"
                            class="absolute right-0 mt-1 w-32 bg-bg-secondary border border-border-default rounded-md shadow-lg z-10 py-1"
                            style="display: none;">
                            <a href="#"
                                class="block px-3 py-1.5 text-caption text-text-primary hover:bg-bg-tertiary">Pin to
                                Personal</a>
                            <a href="#"
                                class="block px-3 py-1.5 text-caption text-text-primary hover:bg-bg-tertiary">Set Alert</a>
                        </div>
                    </div>
                </div>
                <h4 class="text-h2 sm:text-h1 font-bold text-text-primary truncate" x-text="currentMetrics.mrr"></h4>
                <div class="flex items-center justify-between mt-2">
                    <div class="flex items-center gap-2 text-caption">
                        <span class="font-bold px-1.5 py-0.5 rounded flex items-center"
                            :class="currentMetrics.mrrTrend.includes('↑') ?
                                'text-semantic-success bg-semantic-success-bg border border-semantic-success/20' :
                                'text-semantic-error bg-semantic-error-bg border border-semantic-error/20'"
                            x-text="currentMetrics.mrrTrend"></span>
                        <span class="text-text-tertiary truncate"
                            x-text="`vs ${selectedRange === 'today' ? 'Yesterday' : 'Prev.'}`"></span>
                    </div>
                </div>
                <div class="mt-4 h-12 w-full" x-ref="sparklineMrr"></div>
            </div>

            <div class="card p-5 relative overflow-visible group">
                <div class="flex justify-between items-start mb-2">
                    <div class="relative flex items-center gap-2 cursor-help group/tooltip">
                        <span class="text-caption font-bold text-text-tertiary uppercase tracking-wider">ARR</span>
                        <i data-lucide="info" class="w-3 h-3 text-text-tertiary hidden sm:block"></i>
                        <div
                            class="absolute bottom-full left-0 mb-2 w-max max-w-[200px] p-2 bg-bg-tertiary border border-border-strong text-text-primary text-[10px] rounded shadow-lg opacity-0 invisible group-hover/tooltip:opacity-100 group-hover/tooltip:visible transition-all z-50 whitespace-normal">
                            Formula: MRR * 12
                        </div>
                    </div>
                </div>
                <h4 class="text-h2 sm:text-h1 font-bold text-text-primary truncate" x-text="currentMetrics.arr"></h4>
                <div class="flex items-center justify-between mt-2">
                    <div class="flex items-center gap-2 text-caption">
                        <span class="font-bold px-1.5 py-0.5 rounded flex items-center"
                            :class="currentMetrics.arrTrend.includes('↑') ?
                                'text-semantic-success bg-semantic-success-bg border border-semantic-success/20' :
                                'text-semantic-error bg-semantic-error-bg border border-semantic-error/20'"
                            x-text="currentMetrics.arrTrend"></span>
                        <span class="text-text-tertiary truncate"
                            x-text="`vs ${selectedRange === 'today' ? 'Yesterday' : 'Prev.'}`"></span>
                    </div>
                </div>
                <div class="mt-4 h-12 w-full" x-ref="sparklineArr"></div>
            </div>

            <div class="card p-5 pb-8 relative overflow-visible group z-10 hover:z-20">
                <div class="flex justify-between items-start mb-2">
                    <div class="relative flex items-center gap-2 cursor-help group/tooltip">
                        <span class="text-caption font-bold text-text-tertiary uppercase tracking-wider">GMV
                            Processed</span>
                        <i data-lucide="info" class="w-3 h-3 text-text-tertiary hidden sm:block"></i>
                        <!-- Tooltip -->
                        <div
                            class="absolute bottom-full left-0 mb-2 w-max max-w-[220px] p-2 bg-bg-tertiary border border-border-strong text-text-primary text-[10px] rounded shadow-lg opacity-0 invisible group-hover/tooltip:opacity-100 group-hover/tooltip:visible transition-all z-50 whitespace-normal">
                            Total dollar value of all jobs processed through platform
                        </div>
                    </div>
                </div>
                <h4 class="text-h2 sm:text-h1 font-bold text-text-primary truncate" x-text="currentMetrics.gmv"></h4>
                <div class="flex items-center justify-between mt-2">
                    <div class="flex items-center gap-2 text-caption">
                        <span class="font-bold px-1.5 py-0.5 rounded flex items-center"
                            :class="currentMetrics.gmvTrend.includes('↑') ?
                                'text-semantic-success bg-semantic-success-bg border border-semantic-success/20' :
                                'text-semantic-error bg-semantic-error-bg border border-semantic-error/20'"
                            x-text="currentMetrics.gmvTrend"></span>
                        <span class="text-text-tertiary truncate"
                            x-text="`vs ${selectedRange === 'today' ? 'Yesterday' : 'Prev.'}`"></span>
                    </div>
                </div>
                <div class="mt-4 h-12 w-full" x-ref="sparklineGmv"></div>

                <!-- FIX: Added 'rounded-b-lg' (ya rounded-b-xl) yahan -->
                <div
                    class="absolute bottom-0 left-0 w-full rounded-b-xl bg-semantic-warning/10 border-t border-semantic-warning/20 p-1.5 text-center flex items-center justify-center gap-1">
                    <i data-lucide="sparkles" class="w-3 h-3 text-semantic-error"></i>
                    <span class="text-[9px] font-bold text-semantic-error uppercase truncate">AI: Forecast Deviation
                        Detected</span>
                </div>
            </div>
            <div class="card p-5 relative overflow-visible group">
                <div class="flex justify-between items-start mb-2">
                    <div class="relative flex items-center gap-2 cursor-help group/tooltip">
                        <span class="text-caption font-bold text-text-tertiary uppercase tracking-wider truncate">Platform
                            Commission</span>
                        <i data-lucide="info" class="w-3 h-3 text-text-tertiary hidden sm:block"></i>
                        <div
                            class="absolute bottom-full left-0 mb-2 w-max max-w-[200px] p-2 bg-bg-tertiary border border-border-strong text-text-primary text-[10px] rounded shadow-lg opacity-0 invisible group-hover/tooltip:opacity-100 group-hover/tooltip:visible transition-all z-50 whitespace-normal">
                            Formula: GMV * Blended Commission Rate
                        </div>
                    </div>
                </div>
                <h4 class="text-h2 sm:text-h1 font-bold text-text-primary truncate" x-text="currentMetrics.commission">
                </h4>
                <div class="flex items-center justify-between mt-2">
                    <div class="flex items-center gap-2 text-caption">
                        <span class="font-bold px-1.5 py-0.5 rounded flex items-center"
                            :class="currentMetrics.commissionTrend.includes('↑') ?
                                'text-semantic-success bg-semantic-success-bg border border-semantic-success/20' :
                                'text-semantic-error bg-semantic-error-bg border border-semantic-error/20'"
                            x-text="currentMetrics.commissionTrend"></span>
                        <span class="text-text-tertiary truncate">Blended 2.9%</span>
                    </div>
                </div>
                <div class="mt-4 h-12 w-full" x-ref="sparklineCommission"></div>
            </div>

        </div>

        <div class="mb-2 mt-8">
            <h3 class="text-label text-text-secondary mb-4 flex items-center gap-2">
                <i data-lucide="pie-chart" class="w-4 h-4"></i> Unit Economics & Acquisition
            </h3>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-5 gap-4 sm:gap-5 mb-8">
            <div class="card p-4 overflow-visible">
                <div class="flex justify-between items-center mb-1">
                    <div class="relative flex items-center gap-1 cursor-help group/tooltip">
                        <span class="text-caption font-bold text-text-tertiary uppercase tracking-wider">NRR</span>
                        <i data-lucide="info" class="w-3 h-3 text-text-tertiary"></i>
                        <div
                            class="absolute bottom-full left-0 mb-2 w-max max-w-[220px] p-2 bg-bg-tertiary border border-border-strong text-text-primary text-[10px] rounded shadow-lg opacity-0 invisible group-hover/tooltip:opacity-100 group-hover/tooltip:visible transition-all z-50 whitespace-normal">
                            Formula: (Starting MRR + Expansion - Contraction - Churn) / Starting MRR
                        </div>
                    </div>
                </div>
                <h4 class="text-h2 sm:text-h3 font-bold text-text-primary">112%</h4>
                <span class="text-caption text-semantic-success truncate">Healthy Expansion</span>
            </div>

            <div class="card p-4 overflow-visible">
                <div class="flex justify-between items-center mb-1">
                    <div class="relative flex items-center gap-1 cursor-help group/tooltip">
                        <span class="text-caption font-bold text-text-tertiary uppercase tracking-wider">CAC</span>
                        <i data-lucide="info" class="w-3 h-3 text-text-tertiary"></i>
                        <div
                            class="absolute bottom-full left-0 mb-2 w-max max-w-[200px] p-2 bg-bg-tertiary border border-border-strong text-text-primary text-[10px] rounded shadow-lg opacity-0 invisible group-hover/tooltip:opacity-100 group-hover/tooltip:visible transition-all z-50 whitespace-normal">
                            Formula: Total Sales & Mktg Spend / New Businesses
                        </div>
                    </div>
                </div>
                <h4 class="text-h2 sm:text-h3 font-bold text-text-primary">$340</h4>
                <span class="text-caption text-semantic-error truncate">↑ 12% vs Prev</span>
            </div>

            <div class="card p-4 overflow-visible">
                <div class="flex justify-between items-center mb-1">
                    <div class="relative flex items-center gap-1 cursor-help group/tooltip">
                        <span class="text-caption font-bold text-text-tertiary uppercase tracking-wider">LTV</span>
                        <i data-lucide="info" class="w-3 h-3 text-text-tertiary"></i>
                        <div
                            class="absolute bottom-full left-0 mb-2 w-max max-w-[200px] p-2 bg-bg-tertiary border border-border-strong text-text-primary text-[10px] rounded shadow-lg opacity-0 invisible group-hover/tooltip:opacity-100 group-hover/tooltip:visible transition-all z-50 whitespace-normal">
                            Formula: ARPA / User Churn Rate
                        </div>
                    </div>
                </div>
                <h4 class="text-h2 sm:text-h3 font-bold text-text-primary">$4,250</h4>
                <span class="text-caption text-semantic-success truncate">↑ 2.1% vs Prev</span>
            </div>

            <div class="card p-4 bg-brand-primary/5 border-brand-primary/20 overflow-visible">
                <div class="flex justify-between items-center mb-1">
                    <div class="relative flex items-center gap-1 cursor-help group/tooltip">
                        <span class="text-caption font-bold text-text-tertiary uppercase tracking-wider">LTV:CAC
                            Ratio</span>
                        <i data-lucide="info" class="w-3 h-3 text-brand-primary"></i>
                        <div
                            class="absolute bottom-full left-0 mb-2 w-max max-w-[200px] p-2 bg-bg-tertiary border border-border-strong text-text-primary text-[10px] rounded shadow-lg opacity-0 invisible group-hover/tooltip:opacity-100 group-hover/tooltip:visible transition-all z-50 whitespace-normal">
                            Ideal ratio is > 3.0
                        </div>
                    </div>
                    {{-- <i data-lucide="target" class="w-4 h-4 text-brand-primary"></i> --}}
                </div>
                <h4 class="text-h2 sm:text-h3 font-bold">12.5 : 1</h4>
                <span class="text-caption text-semantic-success truncate">Highly Efficient</span>
            </div>

            <div class="card p-4 sm:col-span-2 xl:col-span-1">
                <div class="flex justify-between items-center mb-1">
                    <span class="text-caption font-bold text-text-tertiary uppercase tracking-wider"
                        x-text="`New Signups (${selectedRange})`"></span>
                </div>
                <div class="flex items-center justify-between">
                    <h4 class="text-h2 sm:text-h3 font-bold text-text-primary" x-text="currentMetrics.signups"></h4>
                    <div class="flex -space-x-1 mt-1">
                        <div class="w-5 h-5 sm:w-4 sm:h-4 rounded-full bg-blue-500 border border-bg-primary"
                            title="Agencies"></div>
                        <div class="w-5 h-5 sm:w-4 sm:h-4 rounded-full bg-teal-500 border border-bg-primary"
                            title="Home Services"></div>
                        <div class="w-5 h-5 sm:w-4 sm:h-4 rounded-full bg-amber-500 border border-bg-primary"
                            title="Consultants"></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="mb-2 mt-8">
            <h3 class="text-label text-text-secondary mb-4 flex items-center gap-2">
                <i data-lucide="shield-alert" class="w-4 h-4"></i> Operations & Risk
            </h3>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-5 mb-10">
            <div class="card p-5 md:col-span-2 lg:col-span-1">
                <span class="text-caption font-bold text-text-tertiary uppercase tracking-wider block mb-4">Total Active
                    Businesses</span>
                <div class="flex items-end gap-3 mb-4">
                    <h4 class="text-h1 font-bold text-text-primary">1,240</h4>
                    <span class="text-body-sm text-text-tertiary mb-1">Platform Wide</span>
                </div>
                <div class="space-y-4 sm:space-y-3">
                    <div>
                        <div class="flex justify-between text-caption mb-1">
                            <span class="text-text-secondary flex items-center gap-1"><span
                                    class="w-2 h-2 rounded-full bg-[#3B82F6]"></span> Digital Agencies</span>
                            <span class="font-mono text-text-primary">520</span>
                        </div>
                        <div class="w-full bg-bg-muted rounded-full h-1.5">
                            <div class="bg-[#3B82F6] h-1.5 rounded-full" style="width: 42%"></div>
                        </div>
                    </div>
                    <div>
                        <div class="flex justify-between text-caption mb-1">
                            <span class="text-text-secondary flex items-center gap-1"><span
                                    class="w-2 h-2 rounded-full bg-[#14B8A6]"></span> Home Services</span>
                            <span class="font-mono text-text-primary">410</span>
                        </div>
                        <div class="w-full bg-bg-muted rounded-full h-1.5">
                            <div class="bg-[#14B8A6] h-1.5 rounded-full" style="width: 33%"></div>
                        </div>
                    </div>
                    <div>
                        <div class="flex justify-between text-caption mb-1">
                            <span class="text-text-secondary flex items-center gap-1"><span
                                    class="w-2 h-2 rounded-full bg-[#F59E0B]"></span> Consultants</span>
                            <span class="font-mono text-text-primary">310</span>
                        </div>
                        <div class="w-full bg-bg-muted rounded-full h-1.5">
                            <div class="bg-[#F59E0B] h-1.5 rounded-full" style="width: 25%"></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card p-5 flex flex-col justify-between">
                <div>
                    <span class="text-caption font-bold text-text-tertiary uppercase tracking-wider">Active Jobs
                        (Platform)</span>
                    <h4 class="text-display-lg font-bold text-text-primary mt-2 truncate">14,892</h4>
                    <p class="text-caption text-text-secondary mt-1">Jobs currently in 'In Progress' or 'Scheduled' states.
                    </p>
                </div>
                <div class="mt-6 p-3 bg-bg-tertiary border border-border-default rounded-lg flex items-start gap-3">
                    <i data-lucide="activity" class="w-5 h-5 text-text-secondary shrink-0"></i>
                    <div>
                        <p class="text-body-sm font-semibold text-text-primary">Healthy Volume</p>
                        <p class="text-caption text-text-tertiary">Platform processing normally.</p>
                    </div>
                </div>
            </div>

            <div class="flex flex-col gap-4 sm:gap-5">
                <div class="card p-4 flex items-center justify-between   flex-1">
                    <div class="min-w-0 pr-4">
                        <span
                            class="text-caption font-bold text-text-tertiary uppercase tracking-wider block mb-1 truncate"
                            x-text="`Failed Payments (${selectedRange})`"></span>
                        <h4 class="text-h2 font-bold text-text-primary" x-text="currentMetrics.failedPayments"></h4>
                    </div>
                    <div
                        class="w-12 h-12 sm:w-10 sm:h-10 rounded-full bg-semantic-error-bg text-semantic-error flex items-center justify-center shrink-0">
                        <i data-lucide="credit-card" class="w-5 h-5"></i>
                    </div>
                </div>

                <div class="card p-4 flex items-center justify-between   flex-1">
                    <div class="min-w-0 pr-4">
                        <span
                            class="text-caption font-bold text-text-tertiary uppercase tracking-wider block mb-1 truncate">Pending
                            Payouts</span>
                        <h4 class="text-h2 font-bold text-text-primary truncate" x-text="currentMetrics.pendingPayouts">
                        </h4>
                    </div>
                    <div
                        class="w-12 h-12 sm:w-10 sm:h-10 rounded-full bg-semantic-warning-bg text-semantic-warning flex items-center justify-center shrink-0">
                        <i data-lucide="clock" class="w-5 h-5"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-12 mb-4 flex flex-col lg:flex-row justify-between items-start lg:items-end gap-4">
            <div class="w-full lg:w-auto">
                <h3 class="text-h3 font-bold text-text-primary flex flex-wrap items-center gap-2">
                    Business Health Map
                    <span
                        class="px-2 py-0.5 bg-brand-primary/10 text-brand-primary text-[10px] font-bold uppercase rounded border border-brand-primary/20 flex items-center gap-1 whitespace-nowrap">
                        <i data-lucide="sparkles" class="w-3 h-3"></i> AI Scored
                    </span>
                </h3>
                <p class="text-body-sm text-text-secondary mt-1">Real-time observability of individual business performance
                    and churn risk.</p>
            </div>

            <div class="flex flex-col sm:flex-row items-center gap-3 w-full lg:w-auto">
                <select class="form-input text-caption h-10 sm:h-9 py-0 w-full sm:w-36 bg-bg-secondary"
                    x-model="filters.type">
                    <option value="all">All Types</option>
                    <option value="agency">Digital Agency</option>
                    <option value="home">Home Services</option>
                    <option value="consultant">Consultant</option>
                </select>
                <select class="form-input text-caption h-10 sm:h-9 py-0 w-full sm:w-36 bg-bg-secondary"
                    x-model="filters.health">
                    <option value="all">All Health</option>
                    <option value="critical">Critical Risk</option>
                    <option value="upgrade">Upgrade Ready</option>
                </select>
                <button @click="openModal('Export Data', 'Health Map CSV export started. Please wait...')"
                    class="btn btn-sm w-full sm:w-auto px-4 h-10 sm:h-9 flex items-center justify-center gap-2 transition-all duration-300
           /* Light Mode */
           bg-bg-secondary text-text-primary border border-border-default
           hover:!border-[#1169FB] hover:!text-[#1169FB] hover:!bg-[#1169FB]/5
           /* Dark Mode */
           dark:bg-bg-tertiary dark:text-text-secondary dark:border-border-strong
           dark:hover:!border-[#1169FB] dark:hover:!text-[#1169FB] dark:hover:!bg-[#1169FB]/10">
                    <i data-lucide="download" class="w-3.5 h-3.5 transition-colors"></i>
                    <span class="text-caption font-bold">Export</span>
                </button>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4 sm:gap-5">
            <template x-for="biz in filteredBusinesses" :key="biz.id">
                <div class="card p-4 sm:p-5 flex flex-col hover:border-border-strong transition-colors relative group">

                    <div class="flex items-start gap-3 mb-4">
                        <img :src="biz.logo"
                            class="w-12 h-12 sm:w-10 sm:h-10 rounded-md border border-border-default object-cover shrink-0">
                        <div class="flex-1 min-w-0">
                            <h4 class="text-body-sm font-bold text-text-primary truncate" x-text="biz.name"></h4>
                            <div class="flex items-center gap-2 mt-1 sm:mt-0.5 flex-wrap">
                                <span class="text-[10px] uppercase font-bold tracking-wide whitespace-nowrap"
                                    :style="`color: ${biz.typeColor}`" x-text="biz.type"></span>
                                <span class="hidden sm:inline-block w-1 h-1 rounded-full bg-border-strong"></span>
                                <span class="text-[10px] text-text-secondary uppercase whitespace-nowrap"
                                    x-text="biz.tier + ' Tier'"></span>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-2 sm:gap-3 mb-4">
                        <div class="bg-bg-tertiary p-2 rounded border border-border-default">
                            <span class="block text-[10px] text-text-tertiary uppercase mb-0.5 truncate">Job Volume</span>
                            <span class="text-body-sm font-bold text-text-primary font-mono truncate"
                                x-text="biz.jobVolume"></span>
                        </div>
                        <div class="bg-bg-tertiary p-2 rounded border border-border-default">
                            <span class="block text-[10px] text-text-tertiary uppercase mb-0.5 truncate">Processed</span>
                            <span class="text-body-sm font-bold text-text-primary font-mono truncate"
                                x-text="biz.paymentVolume"></span>
                        </div>
                    </div>

                    <div class="mb-4">
                        <div class="flex justify-between text-caption mb-1">
                            <span class="text-text-secondary">Usage vs Limits</span>
                            <span class="font-mono text-text-primary" x-text="`${biz.usagePct}%`"></span>
                        </div>
                        <div class="w-full bg-bg-muted rounded-full h-1.5 overflow-hidden">
                            <div class="h-1.5 rounded-full"
                                :class="biz.usagePct > 90 ? 'bg-semantic-error' : 'bg-brand-primary'"
                                :style="`width: ${biz.usagePct}%`"></div>
                        </div>
                    </div>

                    <div class="mt-auto pt-4 border-t border-border-default flex items-center justify-between">
                        <div class="flex items-center gap-2" :title="`AI Health Score: ${biz.healthScore}/100`">
                            <div class="relative w-8 h-8 flex items-center justify-center shrink-0">
                                <svg class="w-full h-full transform -rotate-90" viewBox="0 0 36 36">
                                    <path class="text-bg-muted"
                                        d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831"
                                        fill="none" stroke="currentColor" stroke-width="3" />
                                    <path :class="biz.healthColor" :stroke-dasharray="`${biz.healthScore}, 100`"
                                        d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831"
                                        fill="none" stroke="currentColor" stroke-width="3" />
                                </svg>
                                <span class="absolute text-[9px] font-bold text-text-primary"
                                    x-text="biz.healthScore"></span>
                            </div>

                            <span x-show="biz.healthScore < 40"
                                class="text-[10px] text-semantic-error font-bold leading-tight">Churn
                                Risk<br>Detected</span>
                            <span x-show="biz.healthScore >= 40 && biz.usagePct > 85"
                                class="text-[10px] text-semantic-info font-bold leading-tight">Upgrade<br>Opportunity</span>
                            <span x-show="biz.healthScore >= 70 && biz.usagePct <= 85"
                                class="text-[10px] text-semantic-success font-bold leading-tight">Healthy<br>Account</span>
                        </div>

                        <div class="flex gap-1 sm:opacity-0 group-hover:opacity-100 transition-opacity">
                            <button
                                class="p-2 sm:p-1.5 text-text-tertiary hover:text-brand-primary hover:bg-bg-tertiary rounded"
                                title="Send Proactive Message"><i data-lucide="message-square"
                                    class="w-4 h-4"></i></button>
                            <button
                                class="p-2 sm:p-1.5 text-text-tertiary hover:text-semantic-warning hover:bg-bg-tertiary rounded"
                                title="Flag for Review"><i data-lucide="flag" class="w-4 h-4"></i></button>
                            <button
                                class="p-2 sm:p-1.5 text-text-tertiary hover:text-text-primary hover:bg-bg-tertiary rounded"
                                title="View Full Profile"><i data-lucide="arrow-right" class="w-4 h-4"></i></button>
                        </div>
                    </div>
                </div>
            </template>
        </div>

        <div x-show="showModal" style="display: none;"
            class="fixed inset-0 z-50 flex items-center justify-center bg-bg-primary/80 backdrop-blur-sm px-4">
            <div @click.away="showModal = false"
                class="bg-bg-secondary border border-border-default rounded-xl shadow-xl p-6 max-w-sm w-full transform transition-all">
                <div class="flex flex-col items-center text-center">
                    <div
                        class="w-12 h-12 rounded-full bg-brand-primary/10 flex items-center justify-center text-brand-primary mb-4">
                        <i data-lucide="info" class="w-6 h-6"></i>
                    </div>
                    <h3 class="text-h4 font-bold text-text-primary mb-2" x-text="modalTitle"></h3>
                    <p class="text-body-sm text-text-secondary mb-6" x-text="modalMessage"></p>
                    <button @click="showModal = false" class="btn btn-primary w-full py-2">Close</button>
                </div>
            </div>
        </div>

    </div>

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
        <script>
            document.addEventListener('alpine:init', () => {
                Alpine.data('executiveDashboard', () => ({
                    selectedRange: '7d',
                    showModal: false,
                    modalTitle: '',
                    modalMessage: '',
                    chartInstances: {},

                    // Dummy data structured by time range
                    dummyData: {
                        'today': {
                            metrics: {
                                mrr: '$142,500',
                                mrrTrend: '↑ 0.1%',
                                arr: '$1.71M',
                                arrTrend: '↑ 0.1%',
                                gmv: '$18K',
                                gmvTrend: '↓ 0.5%',
                                commission: '$520',
                                commissionTrend: '↑ 1.2%',
                                signups: '5',
                                failedPayments: '12',
                                pendingPayouts: '$1.2K'
                            },
                            charts: {
                                mrr: [142.1, 142.2, 142.2, 142.3, 142.4, 142.5],
                                arr: [1.70, 1.70, 1.70, 1.71, 1.71, 1.71],
                                gmv: [2.1, 2.5, 2.8, 3.2, 3.9, 3.5],
                                commission: [60, 75, 80, 95, 110, 100]
                            }
                        },
                        '7d': {
                            metrics: {
                                mrr: '$142,500',
                                mrrTrend: '↑ 8.4%',
                                arr: '$1.71M',
                                arrTrend: '↑ 12.1%',
                                gmv: '$4.85M',
                                gmvTrend: '↓ 1.2%',
                                commission: '$142.5K',
                                commissionTrend: '↑ 5.2%',
                                signups: '84',
                                failedPayments: '142',
                                pendingPayouts: '$45.2K'
                            },
                            charts: {
                                mrr: [42, 45, 48, 52, 59, 64, 68],
                                arr: [500, 540, 580, 620, 710, 780, 840],
                                gmv: [120, 140, 110, 160, 130, 150, 125],
                                commission: [3.5, 4.1, 3.8, 4.5, 4.2, 4.8, 4.9]
                            }
                        },
                        '30d': {
                            metrics: {
                                mrr: '$138,200',
                                mrrTrend: '↑ 15.2%',
                                arr: '$1.65M',
                                arrTrend: '↑ 18.5%',
                                gmv: '$21.4M',
                                gmvTrend: '↑ 4.5%',
                                commission: '$615K',
                                commissionTrend: '↑ 8.1%',
                                signups: '312',
                                failedPayments: '610',
                                pendingPayouts: '$180.5K'
                            },
                            charts: {
                                mrr: [110, 115, 120, 125, 132, 135, 138],
                                arr: [1.2, 1.3, 1.4, 1.5, 1.6, 1.62, 1.65],
                                gmv: [400, 420, 410, 450, 480, 500, 510],
                                commission: [12, 13, 12.5, 14, 15, 16, 17]
                            }
                        },
                        'ytd': {
                            metrics: {
                                mrr: '$105,000',
                                mrrTrend: '↑ 45.0%',
                                arr: '$1.26M',
                                arrTrend: '↑ 52.0%',
                                gmv: '$95.2M',
                                gmvTrend: '↑ 22.4%',
                                commission: '$2.8M',
                                commissionTrend: '↑ 28.5%',
                                signups: '1,450',
                                failedPayments: '2,800',
                                pendingPayouts: '$520K'
                            },
                            charts: {
                                mrr: [50, 60, 75, 85, 95, 100, 105],
                                arr: [0.6, 0.7, 0.9, 1.0, 1.1, 1.2, 1.26],
                                gmv: [10, 25, 40, 55, 70, 85, 95],
                                commission: [0.3, 0.8, 1.2, 1.6, 2.1, 2.5, 2.8]
                            }
                        }
                    },

                    filters: {
                        type: 'all',
                        health: 'all'
                    },

                    businesses: [{
                            id: 1,
                            name: 'Elevate Digital',
                            type: 'Agency',
                            typeColor: '#3B82F6',
                            logo: 'https://ui-avatars.com/api/?name=ED&background=F1F5F9&color=0F1729',
                            tier: 'Scale',
                            jobVolume: '142',
                            paymentVolume: '$42k',
                            usagePct: 92,
                            healthScore: 88,
                            healthColor: 'text-semantic-success'
                        },
                        {
                            id: 2,
                            name: 'Dubai Cool AC Repair',
                            type: 'Home Services',
                            typeColor: '#14B8A6',
                            logo: 'https://ui-avatars.com/api/?name=DC&background=F1F5F9&color=0F1729',
                            tier: 'Growth',
                            jobVolume: '210',
                            paymentVolume: '$18k',
                            usagePct: 45,
                            healthScore: 32,
                            healthColor: 'text-semantic-error'
                        },
                        {
                            id: 3,
                            name: 'Apex Legal Consultants',
                            type: 'Consultant',
                            typeColor: '#F59E0B',
                            logo: 'https://ui-avatars.com/api/?name=AL&background=F1F5F9&color=0F1729',
                            tier: 'Starter',
                            jobVolume: '12',
                            paymentVolume: '$8k',
                            usagePct: 98,
                            healthScore: 75,
                            healthColor: 'text-semantic-info'
                        },
                        {
                            id: 4,
                            name: 'CleanSweep UAE',
                            type: 'Home Services',
                            typeColor: '#14B8A6',
                            logo: 'https://ui-avatars.com/api/?name=CS&background=F1F5F9&color=0F1729',
                            tier: 'Enterprise',
                            jobVolume: '1,204',
                            paymentVolume: '$112k',
                            usagePct: 65,
                            healthScore: 94,
                            healthColor: 'text-semantic-success'
                        },
                        {
                            id: 5,
                            name: 'Nexus Marketing',
                            type: 'Agency',
                            typeColor: '#3B82F6',
                            logo: 'https://ui-avatars.com/api/?name=NM&background=F1F5F9&color=0F1729',
                            tier: 'Starter',
                            jobVolume: '4',
                            paymentVolume: '$1.2k',
                            usagePct: 15,
                            healthScore: 28,
                            healthColor: 'text-semantic-error'
                        },
                    ],

                    get currentMetrics() {
                        return this.dummyData[this.selectedRange].metrics;
                    },

                    get filteredBusinesses() {
                        return this.businesses.filter(b => {
                            let matchType = this.filters.type === 'all' || b.type.toLowerCase()
                                .includes(this.filters.type);
                            let matchHealth = true;
                            if (this.filters.health === 'critical') matchHealth = b
                                .healthScore < 40;
                            if (this.filters.health === 'upgrade') matchHealth = b.usagePct >
                                85;
                            return matchType && matchHealth;
                        });
                    },

                    init() {
                        this.$nextTick(() => {
                            const chartsData = this.dummyData[this.selectedRange].charts;
                            this.chartInstances.mrr = this.renderSparkline(this.$refs.sparklineMrr,
                                chartsData.mrr, '#5B6AF0');
                            this.chartInstances.arr = this.renderSparkline(this.$refs.sparklineArr,
                                chartsData.arr, '#5B6AF0');
                            this.chartInstances.gmv = this.renderSparkline(this.$refs.sparklineGmv,
                                chartsData.gmv, '#F87171');
                            this.chartInstances.commission = this.renderSparkline(this.$refs
                                .sparklineCommission, chartsData.commission, '#10B981');
                        });
                    },

                    setRange(range) {
                        this.selectedRange = range;
                        const newChartsData = this.dummyData[range].charts;

                        // Update charts smoothly
                        this.chartInstances.mrr.updateSeries([{
                            data: newChartsData.mrr
                        }]);
                        this.chartInstances.arr.updateSeries([{
                            data: newChartsData.arr
                        }]);
                        this.chartInstances.gmv.updateSeries([{
                            data: newChartsData.gmv
                        }]);
                        this.chartInstances.commission.updateSeries([{
                            data: newChartsData.commission
                        }]);
                    },

                    renderSparkline(element, data, color) {
                        const chart = new ApexCharts(element, {
                            series: [{
                                data: data
                            }],
                            chart: {
                                type: 'area',
                                width: '100%',
                                height: 48,
                                sparkline: {
                                    enabled: true
                                }
                            },
                            stroke: {
                                curve: 'smooth',
                                width: 2
                            },
                            fill: {
                                type: 'gradient',
                                gradient: {
                                    shadeIntensity: 1,
                                    opacityFrom: 0.4,
                                    opacityTo: 0,
                                    stops: [0, 100]
                                }
                            },
                            colors: [color],
                            tooltip: {
                                fixed: {
                                    enabled: false
                                },
                                x: {
                                    show: false
                                },
                                y: {
                                    title: {
                                        formatter: function() {
                                            return ''
                                        }
                                    }
                                },
                                marker: {
                                    show: false
                                }
                            }
                        });
                        chart.render();
                        return chart; // Return instance so we can update it later
                    },

                    openModal(title, message) {
                        this.modalTitle = title;
                        this.modalMessage = message;
                        this.showModal = true;
                        // Ensure icons render inside the modal
                        setTimeout(() => {
                            if (window.lucide) lucide.createIcons();
                        }, 50);
                    },

                    shareDashboard() {
                        this.openModal('Share Dashboard',
                            'A secure sharing link has been copied to your clipboard. Anyone with the link can view this snapshot.'
                        );
                    },
                    exportSnapshot() {
                        this.openModal('Export Started',
                            'Your PDF snapshot is being generated. It will be downloaded automatically once complete.'
                        );
                    }
                }));
            });
        </script>
    @endpush
@endsection
