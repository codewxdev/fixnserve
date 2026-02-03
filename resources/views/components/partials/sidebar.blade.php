<div x-bind:class="{ 'w-72': sidebarOpen, 'w-20': !sidebarOpen }"
    class="sidebar fixed top-0 left-0 h-full z-30 flex flex-col bg-slate-900 border-r border-slate-800 text-white transition-all duration-300 ease-in-out shadow-2xl">

    <div class="flex items-center pl-5 h-20 border-b border-slate-800/50 bg-slate-900/50 backdrop-blur-sm">
        <div x-show="sidebarOpen" class="flex items-center gap-2 transition-opacity duration-300" x-cloak>
            <div
                class="w-8 h-8 rounded-lg bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center shadow-lg shadow-blue-500/20">
                <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z" />
                </svg>
            </div>
            <span
                class="text-xl font-bold tracking-wide bg-gradient-to-r from-white to-slate-400 bg-clip-text text-transparent">
                SahorOne
            </span>
        </div>

        <div x-show="!sidebarOpen" class="transition-opacity duration-300" x-cloak>
            <div
                class="w-10 h-10 rounded-xl bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center shadow-lg shadow-blue-500/20">
                <span class="text-white font-extrabold text-lg">FS</span>
            </div>
        </div>
    </div>

    <nav class="flex-1 overflow-y-auto py-6 custom-scrollbar">
        <ul class="space-y-1.5 px-3">

            <li>
                <a href="{{ route('dashboard.index') }}"
                    class="group flex items-center py-3 px-3.5 rounded-xl transition-all duration-200 ease-in-out {{ request()->routeIs('dashboard.index') ? 'bg-blue-600/10 text-blue-400 shadow-inner' : 'text-slate-400 hover:bg-slate-800/50 hover:text-slate-100' }}">
                    <svg class="w-5 h-5 flex-shrink-0 transition-colors {{ request()->routeIs('dashboard.index') ? 'text-blue-400' : 'text-slate-500 group-hover:text-slate-300' }}"
                        fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                    </svg>
                    <span x-show="sidebarOpen"
                        class="ml-3 text-sm font-medium tracking-wide transition-opacity duration-300"
                        x-cloak>Dashboard</span>
                </a>
            </li>

            <li x-show="sidebarOpen" class="px-4 mt-6 mb-2" x-cloak>
                <span class="text-[10px] font-bold uppercase tracking-wider text-slate-600">User Management</span>
            </li>

            <li>
                <a href="{{ route('customer.index') }}"
                    class="group flex items-center py-3 px-3.5 rounded-xl transition-all duration-200 ease-in-out {{ request()->routeIs('customer.index') ? 'bg-blue-600/10 text-blue-400 shadow-inner' : 'text-slate-400 hover:bg-slate-800/50 hover:text-slate-100' }}">
                    <svg class="w-5 h-5 flex-shrink-0 transition-colors {{ request()->routeIs('customer.index') ? 'text-blue-400' : 'text-slate-500 group-hover:text-slate-300' }}"
                        fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                    <span x-show="sidebarOpen"
                        class="ml-3 text-sm font-medium tracking-wide transition-opacity duration-300"
                        x-cloak>Customers</span>
                </a>
            </li>

            <li>
                <a href="{{ route('provider.index') }}"
                    class="group flex items-center py-3 px-3.5 rounded-xl transition-all duration-200 ease-in-out {{ request()->routeIs('provider.index') ? 'bg-blue-600/10 text-blue-400 shadow-inner' : 'text-slate-400 hover:bg-slate-800/50 hover:text-slate-100' }}">
                    <svg class="w-5 h-5 flex-shrink-0 transition-colors {{ request()->routeIs('provider.index') ? 'text-blue-400' : 'text-slate-500 group-hover:text-slate-300' }}"
                        fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                    </svg>
                    <span x-show="sidebarOpen"
                        class="ml-3 text-sm font-medium tracking-wide transition-opacity duration-300"
                        x-cloak>Providers</span>
                </a>
            </li>

            <li>
                <a href="{{ route('professional.index') }}"
                    class="group flex items-center py-3 px-3.5 rounded-xl transition-all duration-200 ease-in-out {{ request()->routeIs('professional.index') ? 'bg-blue-600/10 text-blue-400 shadow-inner' : 'text-slate-400 hover:bg-slate-800/50 hover:text-slate-100' }}">
                    <svg class="w-5 h-5 flex-shrink-0 transition-colors {{ request()->routeIs('professional.index') ? 'text-blue-400' : 'text-slate-500 group-hover:text-slate-300' }}"
                        fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                    <span x-show="sidebarOpen"
                        class="ml-3 text-sm font-medium tracking-wide transition-opacity duration-300"
                        x-cloak>Professionals</span>
                </a>
            </li>

            <li>
                <a href="{{ route('consultant.index') }}"
                    class="group flex items-center py-3 px-3.5 rounded-xl transition-all duration-200 ease-in-out {{ request()->routeIs('consultant.index') ? 'bg-blue-600/10 text-blue-400 shadow-inner' : 'text-slate-400 hover:bg-slate-800/50 hover:text-slate-100' }}">
                    <svg class="w-5 h-5 flex-shrink-0 transition-colors {{ request()->routeIs('consultant.index') ? 'text-blue-400' : 'text-slate-500 group-hover:text-slate-300' }}"
                        fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L11 14h4a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2v4l.586-.586z" />
                    </svg>
                    <span x-show="sidebarOpen"
                        class="ml-3 text-sm font-medium tracking-wide transition-opacity duration-300"
                        x-cloak>Consultants</span>
                </a>
            </li>

            <li>
                <a href="{{ route('mart.index') }}"
                    class="group flex items-center py-3 px-3.5 rounded-xl transition-all duration-200 ease-in-out {{ request()->routeIs('mart.index') ? 'bg-blue-600/10 text-blue-400 shadow-inner' : 'text-slate-400 hover:bg-slate-800/50 hover:text-slate-100' }}">
                    <svg class="w-5 h-5 flex-shrink-0 transition-colors {{ request()->routeIs('mart.index') ? 'text-blue-400' : 'text-slate-500 group-hover:text-slate-300' }}"
                        fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                    </svg>
                    <span x-show="sidebarOpen"
                        class="ml-3 text-sm font-medium tracking-wide transition-opacity duration-300" x-cloak>Mart
                        Vendors</span>
                </a>
            </li>

            <li>
                <a href="{{ route('rider.index') }}"
                    class="group flex items-center py-3 px-3.5 rounded-xl transition-all duration-200 ease-in-out {{ request()->routeIs('rider.index') ? 'bg-blue-600/10 text-blue-400 shadow-inner' : 'text-slate-400 hover:bg-slate-800/50 hover:text-slate-100' }}">
                    <svg class="w-5 h-5 flex-shrink-0 transition-colors {{ request()->routeIs('cooperation.index') ? 'text-blue-400' : 'text-slate-500 group-hover:text-slate-300' }}"
                        fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M7 11.5V14m0-2.5v-6a1.5 1.5 0 113 0V12m-3 .5a3 3 0 006 0v-1a1.5 1.5 0 013 0V12a5 5 0 01-10 0v-1.5" />
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M18 12.25l1.25 1.25a1.5 1.5 0 11-2.12 2.12L15 13.5M5 18h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                    </svg>
                    <span x-show="sidebarOpen"
                        class="ml-3 text-sm font-medium tracking-wide transition-opacity duration-300"
                        x-cloak>Riders</span>
                </a>
            </li>

            <li x-show="sidebarOpen" class="px-4 mt-6 mb-2" x-cloak>
                <span class="text-[10px] font-bold uppercase tracking-wider text-slate-600">Operations</span>
            </li>

            <li>
                <a href="{{ route('service.index') }}"
                    class="group flex items-center py-3 px-3.5 rounded-xl transition-all duration-200 ease-in-out {{ request()->routeIs('service.index') ? 'bg-blue-600/10 text-blue-400 shadow-inner' : 'text-slate-400 hover:bg-slate-800/50 hover:text-slate-100' }}">
                    <svg class="w-5 h-5 flex-shrink-0 transition-colors {{ request()->routeIs('staff.index') ? 'text-blue-400' : 'text-slate-500 group-hover:text-slate-300' }}"
                        fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M18.364 18.364l1.414 1.414m-1.414-1.414A9 9 0 0112 21M12 3v1m0 16v1m9-9h-1M4 12H3m15.364-6.364l-.707.707M6.343 17.657l-.707.707m0-12.728l.707.707m11.314 11.314l.707-.707" />
                    </svg>
                    <span x-show="sidebarOpen"
                        class="ml-3 text-sm font-medium tracking-wide transition-opacity duration-300" x-cloak>Service
                        Management</span>
                </a>
            </li>

            <li>
                <a href="{{ route('finance.index') }}"
                    class="group flex items-center py-3 px-3.5 rounded-xl transition-all duration-200 ease-in-out {{ request()->routeIs('finance.index') ? 'bg-blue-600/10 text-blue-400 shadow-inner' : 'text-slate-400 hover:bg-slate-800/50 hover:text-slate-100' }}">
                    <svg class="w-5 h-5 flex-shrink-0 transition-colors {{ request()->routeIs('finance.index') ? 'text-blue-400' : 'text-slate-500 group-hover:text-slate-300' }}"
                        fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span x-show="sidebarOpen"
                        class="ml-3 text-sm font-medium tracking-wide transition-opacity duration-300" x-cloak>Finance
                        Managment</span>
                </a>
            </li>

            <li>
                <a href="{{ route('car.index') }}"
                    class="group flex items-center py-3 px-3.5 rounded-xl transition-all duration-200 ease-in-out {{ request()->routeIs('car.index') ? 'bg-blue-600/10 text-blue-400 shadow-inner' : 'text-slate-400 hover:bg-slate-800/50 hover:text-slate-100' }}">
                    <svg class="w-5 h-5 flex-shrink-0 transition-colors {{ request()->routeIs('car.index') ? 'text-blue-400' : 'text-slate-500 group-hover:text-slate-300' }}"
                        fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.368 17c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                    <span x-show="sidebarOpen"
                        class="ml-3 text-sm font-medium tracking-wide transition-opacity duration-300"
                        x-cloak>Complaints & Refunds</span>
                </a>
            </li>

            <li>
                <a href="{{ route('report.index') }}"
                    class="group flex items-center py-3 px-3.5 rounded-xl transition-all duration-200 ease-in-out {{ request()->routeIs('report.index') ? 'bg-blue-600/10 text-blue-400 shadow-inner' : 'text-slate-400 hover:bg-slate-800/50 hover:text-slate-100' }}">
                    <svg class="w-5 h-5 flex-shrink-0 transition-colors {{ request()->routeIs('report.index') ? 'text-blue-400' : 'text-slate-500 group-hover:text-slate-300' }}"
                        fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                    </svg>
                    <span x-show="sidebarOpen"
                        class="ml-3 text-sm font-medium tracking-wide transition-opacity duration-300" x-cloak>Reports
                        & Analytics</span>
                </a>
            </li>

            <li x-show="sidebarOpen" class="px-4 mt-6 mb-2" x-cloak>
                <span class="text-[10px] font-bold uppercase tracking-wider text-slate-600">Configuration</span>
            </li>

            <li x-data="{ open: {{ request()->routeIs('marketing.*') ? 'true' : 'false' }} }">
                <button @click="open = !open"
                    class="w-full group flex items-center justify-between py-3 px-3.5 rounded-xl transition-all duration-200 ease-in-out {{ request()->routeIs('marketing.*') ? 'bg-slate-800/50 text-white' : 'text-slate-400 hover:bg-slate-800/50 hover:text-slate-100' }}">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 flex-shrink-0 transition-colors {{ request()->routeIs('marketing.*') ? 'text-blue-400' : 'text-slate-500 group-hover:text-pink-400' }}"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z" />
                        </svg>
                        <span x-show="sidebarOpen"
                            class="ml-3 text-sm font-medium tracking-wide transition-opacity duration-300"
                            x-cloak>Marketing Engine</span>
                    </div>
                    <svg x-show="sidebarOpen" :class="open ? 'rotate-180' : ''"
                        class="w-4 h-4 text-slate-500 transition-transform duration-200" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>

                <ul x-show="open && sidebarOpen" x-collapse class="mt-1 space-y-1 px-2" x-cloak>
                    <li>
                        <a href="{{ route('marketing.coupons') }}"
                            class="flex items-center py-2 px-3.5 rounded-lg text-sm transition-colors {{ request()->routeIs('marketing.coupons') ? 'bg-blue-600/20 text-blue-400' : 'text-slate-400 hover:text-white hover:bg-slate-800' }}">
                            <span
                                class="w-1.5 h-1.5 rounded-full mr-3 {{ request()->routeIs('marketing.coupons') ? 'bg-blue-400' : 'bg-slate-600' }}"></span>
                            Promo Codes
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('marketing.campaigns') }}"
                            class="flex items-center py-2 px-3.5 rounded-lg text-sm transition-colors {{ request()->routeIs('marketing.campaigns') ? 'bg-blue-600/20 text-blue-400' : 'text-slate-400 hover:text-white hover:bg-slate-800' }}">
                            <span
                                class="w-1.5 h-1.5 rounded-full mr-3 {{ request()->routeIs('marketing.campaigns') ? 'bg-blue-400' : 'bg-slate-600' }}"></span>
                            Campaign Manager
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('marketing.loyalty') }}"
                            class="flex items-center py-2 px-3.5 rounded-lg text-sm transition-colors {{ request()->routeIs('marketing.loyalty') ? 'bg-blue-600/20 text-blue-400' : 'text-slate-400 hover:text-white hover:bg-slate-800' }}">
                            <span
                                class="w-1.5 h-1.5 rounded-full mr-3 {{ request()->routeIs('marketing.loyalty') ? 'bg-blue-400' : 'bg-slate-600' }}"></span>
                            Loyalty & Rewards
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('marketing.featured') }}"
                            class="flex items-center py-2 px-3.5 rounded-lg text-sm transition-colors {{ request()->routeIs('marketing.featured') ? 'bg-blue-600/20 text-blue-400' : 'text-slate-400 hover:text-white hover:bg-slate-800' }}">
                            <span
                                class="w-1.5 h-1.5 rounded-full mr-3 {{ request()->routeIs('marketing.featured') ? 'bg-blue-400' : 'bg-slate-600' }}"></span>
                            Featured Requests
                        </a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="{{ route('cms.index') }}"
                    class="group flex items-center py-3 px-3.5 rounded-xl transition-all duration-200 ease-in-out {{ request()->routeIs('cms.index') ? 'bg-blue-600/10 text-blue-400 shadow-inner' : 'text-slate-400 hover:bg-slate-800/50 hover:text-slate-100' }}">
                    <svg class="w-5 h-5 flex-shrink-0 transition-colors {{ request()->routeIs('cms.index') ? 'text-blue-400' : 'text-slate-500 group-hover:text-slate-300' }}"
                        fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9" />
                    </svg>
                    <span x-show="sidebarOpen"
                        class="ml-3 text-sm font-medium tracking-wide transition-opacity duration-300" x-cloak>CMS &
                        Settings</span>
                </a>
            </li>

            <li>
                <a href="{{ route('notification.index') }}"
                    class="group flex items-center py-3 px-3.5 rounded-xl transition-all duration-200 ease-in-out {{ request()->routeIs('notification.index') ? 'bg-blue-600/10 text-blue-400 shadow-inner' : 'text-slate-400 hover:bg-slate-800/50 hover:text-slate-100' }}">
                    <svg class="w-5 h-5 flex-shrink-0 transition-colors {{ request()->routeIs('notification.index') ? 'text-blue-400' : 'text-slate-500 group-hover:text-slate-300' }}"
                        fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                    </svg>
                    <span x-show="sidebarOpen"
                        class="ml-3 text-sm font-medium tracking-wide transition-opacity duration-300"
                        x-cloak>Notifications</span>
                </a>
            </li>

            <li>
                <a href="{{ route('role.permission.index') }}"
                    class="group flex items-center py-3 px-3.5 rounded-xl transition-all duration-200 ease-in-out {{ request()->routeIs('role.permission.index') ? 'bg-blue-600/10 text-blue-400 shadow-inner' : 'text-slate-400 hover:bg-slate-800/50 hover:text-slate-100' }}">
                    <svg class="w-5 h-5 flex-shrink-0 transition-colors {{ request()->routeIs('role.permission.index') ? 'text-blue-400' : 'text-slate-500 group-hover:text-slate-300' }}"
                        fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>
                    <span x-show="sidebarOpen"
                        class="ml-3 text-sm font-medium tracking-wide transition-opacity duration-300" x-cloak>Roles &
                        Permissions</span>
                </a>
            </li>
            <li>
                <a href="{{ route('cooperation.index') }}"
                    class="group flex items-center py-3 px-3.5 rounded-xl transition-all duration-200 ease-in-out {{ request()->routeIs('cooperation.index') ? 'bg-blue-600/10 text-blue-400 shadow-inner' : 'text-slate-400 hover:bg-slate-800/50 hover:text-slate-100' }}">
                    <svg class="w-5 h-5 flex-shrink-0 transition-colors {{ request()->routeIs('your.route.name') ? 'text-blue-400' : 'text-slate-500 group-hover:text-slate-300' }}"
                        fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M14.7 12.5l.8 2a.5.5 0 01-.3.6l-2.5.8a.5.5 0 01-.6-.3l-.8-2" />
                    </svg>
                    <span x-show="sidebarOpen"
                        class="ml-3 text-sm font-medium tracking-wide transition-opacity duration-300"
                        x-cloak>Cooperation Requests</span>
                </a>
            </li>
            <li>
                <a href="{{ route('codashboard.index') }}"
                    class="group flex items-center py-3 px-3.5 rounded-xl transition-all duration-200 ease-in-out {{ request()->routeIs('codashboard.index') ? 'bg-blue-600/10 text-blue-400 shadow-inner' : 'text-slate-400 hover:bg-slate-800/50 hover:text-slate-100' }}">
                    <svg class="w-5 h-5 flex-shrink-0 transition-colors {{ request()->routeIs('stats.index') ? 'text-blue-400' : 'text-slate-500 group-hover:text-slate-300' }}"
                        fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <rect x="2" y="3" width="20" height="14" rx="2" stroke-linecap="round"
                            stroke-linejoin="round" />
                        <path d="M8 21h8m-4-4v4" stroke-linecap="round" stroke-linejoin="round" />
                        <path d="M16 13V9m-4 4V7m-4 4v-2" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                    <span x-show="sidebarOpen"
                        class="ml-3 text-sm font-medium tracking-wide transition-opacity duration-300" x-cloak>Mini
                        Dashboard</span>
                </a>
                <a href="{{ route('subscription.index') }}"
                    class="group flex items-center py-3 px-3.5 rounded-xl transition-all duration-200 ease-in-out {{ request()->routeIs('subscription.index') ? 'bg-blue-600/10 text-blue-400 shadow-inner' : 'text-slate-400 hover:bg-slate-800/50 hover:text-slate-100' }}">
                    <svg class="w-5 h-5 flex-shrink-0 transition-colors {{ request()->routeIs('stats.index') ? 'text-blue-400' : 'text-slate-500 group-hover:text-slate-300' }}"
                        fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <rect x="2" y="3" width="20" height="14" rx="2" stroke-linecap="round"
                            stroke-linejoin="round" />
                        <path d="M8 21h8m-4-4v4" stroke-linecap="round" stroke-linejoin="round" />
                        <path d="M16 13V9m-4 4V7m-4 4v-2" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                    <span x-show="sidebarOpen"
                        class="ml-3 text-sm font-medium tracking-wide transition-opacity duration-300"
                        x-cloak>Subscription</span>
                </a>
            </li>

        </ul>
    </nav>
</div>

<style>
    .custom-scrollbar::-webkit-scrollbar {
        width: 4px;
    }

    .custom-scrollbar::-webkit-scrollbar-track {
        background: transparent;
    }

    .custom-scrollbar::-webkit-scrollbar-thumb {
        background-color: #334155;
        /* slate-700 */
        border-radius: 20px;
    }

    .custom-scrollbar:hover::-webkit-scrollbar-thumb {
        background-color: #475569;
        /* slate-600 */
    }
</style>
