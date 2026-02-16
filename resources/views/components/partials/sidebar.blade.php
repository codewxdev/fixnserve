<div x-data="{
    activeDropdown: null,
    toggle(key) {
        this.activeDropdown = (this.activeDropdown === key) ? null : key;
    }
}" x-bind:class="{ 'w-72': sidebarOpen, 'w-20': !sidebarOpen }"
    class="sidebar fixed top-0 left-0 h-full z-30 flex flex-col transition-all duration-300 ease-in-out shadow-2xl custom-scrollbar"
    style="background-color: rgb(var(--sidebar-bg)); border-right: 1px solid rgb(var(--sidebar-border)); color: rgb(var(--text-main));">

    <div class="flex items-center pl-6 h-20 shrink-0 border-b sidebar" style="border-color: rgb(var(--sidebar-border));">
        <div x-show="sidebarOpen" class="flex items-center gap-3 transition-opacity duration-300" x-cloak>
            <div class="w-8 h-8 rounded-lg flex items-center justify-center shadow-lg"
                style="background: linear-gradient(135deg, rgb(var(--brand-primary)), rgb(var(--brand-secondary)));">
                <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                    stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z" />
                </svg>
            </div>
            <span class="text-xl font-bold tracking-wide nav-text" style="color: rgb(var(--text-main));">
                SahorOne
            </span>
        </div>

        <div x-show="!sidebarOpen" class="transition-opacity duration-300 -ml-1" x-cloak>
            <div class="w-10 h-10 rounded-xl flex items-center justify-center shadow-lg"
                style="background: linear-gradient(135deg, rgb(var(--brand-primary)), rgb(var(--brand-secondary)));">
                <span class="text-white font-extrabold text-lg">S1</span>
            </div>
        </div>
    </div>

    <nav class="flex-1 overflow-y-auto py-6 custom-scrollbar px-3 sidebar">
        <ul class="space-y-1">

            <li x-show="sidebarOpen" class="px-3 mt-2 mb-2" x-cloak>
                <span class="text-[10px] font-bold uppercase tracking-wider opacity-60 nav-text"
                    style="color: rgb(var(--text-muted));">Platform Control & Governance</span>
            </li>

            <li>
                <button @click="toggle('command_centre')"
                    class="w-full group flex items-center justify-between py-3 px-3 rounded-lg transition-all duration-200 ease-in-out hover:bg-white/5"
                    :style="activeDropdown === 'command_centre' ?
                        'background-color: rgb(var(--item-active-bg)); color: rgb(var(--text-main));' : 'color: rgb(var(--text-muted));'">
                    <div class="flex items-center overflow-hidden">
                        <svg class="w-5 h-5 flex-shrink-0 transition-colors"
                            :style="activeDropdown === 'command_centre' ? 'color: rgb(var(--brand-primary))' : ''"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                        </svg>
                        <span x-show="sidebarOpen"
                            class="ml-3 text-sm font-medium tracking-wide nav-text transition-opacity duration-300"
                            x-cloak>
                            Command centre
                        </span>
                    </div>
                    <svg x-show="sidebarOpen" :class="activeDropdown === 'command_centre' ? 'rotate-180' : ''"
                        class="w-4 h-4 transition-transform duration-200 flex-shrink-0" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
                <ul x-show="activeDropdown === 'command_centre' && sidebarOpen" x-collapse class="mt-1 space-y-1 px-1"
                    x-cloak>
                    <li><a href="{{route('platform_overview.index')}}" class="block py-2 pl-11 pr-2 rounded-lg text-sm hover:text-white nav-text"
                            style="color: rgb(var(--text-muted));">Platform Overview</a></li>
                    <li><a href="{{ route('system_health.index') }}" class="block py-2 pl-11 pr-2 rounded-lg text-sm hover:text-white nav-text"
                            style="color: rgb(var(--text-muted));">System Health</a></li>
                    <li><a href="{{route('regional_controle.index')}}" class="block py-2 pl-11 pr-2 rounded-lg text-sm hover:text-white nav-text"
                            style="color: rgb(var(--text-muted));">Regional controle</a></li>
                    <li><a href="{{route('maintainance_emergency.index')}}" class="block py-2 pl-11 pr-2 rounded-lg text-sm hover:text-white nav-text"
                            style="color: rgb(var(--text-muted));">Maintainace & Emergency</a></li>
                </ul>
            </li>

            <li>
                <button @click="toggle('security')"
                    class="w-full group flex items-center justify-between py-3 px-3 rounded-lg transition-all duration-200 ease-in-out hover:bg-white/5"
                    :style="activeDropdown === 'security' ? 'background-color: rgb(var(--item-active-bg)); color: rgb(var(--text-main));' :
                        'color: rgb(var(--text-muted));'">
                    <div class="flex items-center overflow-hidden">
                        <svg class="w-5 h-5 flex-shrink-0 transition-colors"
                            :style="activeDropdown === 'security' ? 'color: rgb(var(--brand-primary))' : ''"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                        <span x-show="sidebarOpen"
                            class="ml-3 text-sm font-medium tracking-wide nav-text transition-opacity duration-300"
                            x-cloak>
                            Security and access controls
                        </span>
                    </div>
                    <svg x-show="sidebarOpen" :class="activeDropdown === 'security' ? 'rotate-180' : ''"
                        class="w-4 h-4 transition-transform duration-200 flex-shrink-0" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
                <ul x-show="activeDropdown === 'security' && sidebarOpen" x-collapse class="mt-1 space-y-1 px-1"
                    x-cloak>
                    <li><a href="#" class="block py-2 pl-11 pr-2 rounded-lg text-sm hover:text-white nav-text"
                            style="color: rgb(var(--text-muted));">Authentication</a></li>
                    <li><a href="#" class="block py-2 pl-11 pr-2 rounded-lg text-sm hover:text-white nav-text"
                            style="color: rgb(var(--text-muted));">Sessions</a></li>
                    <li><a href="#" class="block py-2 pl-11 pr-2 rounded-lg text-sm hover:text-white nav-text"
                            style="color: rgb(var(--text-muted));">Tokens</a></li>
                    <li><a href="#" class="block py-2 pl-11 pr-2 rounded-lg text-sm hover:text-white nav-text"
                            style="color: rgb(var(--text-muted));">Devices</a></li>
                    <li><a href="#" class="block py-2 pl-11 pr-2 rounded-lg text-sm hover:text-white nav-text"
                            style="color: rgb(var(--text-muted));">Network Security</a></li>
                    <li><a href="#" class="block py-2 pl-11 pr-2 rounded-lg text-sm hover:text-white nav-text"
                            style="color: rgb(var(--text-muted));">Previleged Access</a></li>
                </ul>
            </li>

            <li>
                <button @click="toggle('rbac')"
                    class="w-full group flex items-center justify-between py-3 px-3 rounded-lg transition-all duration-200 ease-in-out hover:bg-white/5"
                    :style="activeDropdown === 'rbac' ? 'background-color: rgb(var(--item-active-bg)); color: rgb(var(--text-main));' :
                        'color: rgb(var(--text-muted));'">
                    <div class="flex items-center overflow-hidden">
                        <svg class="w-5 h-5 flex-shrink-0 transition-colors"
                            :style="activeDropdown === 'rbac' ? 'color: rgb(var(--brand-primary))' : ''"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                        <span x-show="sidebarOpen"
                            class="ml-3 text-sm font-medium tracking-wide nav-text transition-opacity duration-300"
                            x-cloak>
                            Roles & permissions(RBAC)
                        </span>
                    </div>
                    <svg x-show="sidebarOpen" :class="activeDropdown === 'rbac' ? 'rotate-180' : ''"
                        class="w-4 h-4 transition-transform duration-200 flex-shrink-0" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
                <ul x-show="activeDropdown === 'rbac' && sidebarOpen" x-collapse class="mt-1 space-y-1 px-1" x-cloak>
                    <li><a href="#" class="block py-2 pl-11 pr-2 rounded-lg text-sm hover:text-white nav-text"
                            style="color: rgb(var(--text-muted));">Roles</a></li>
                    <li><a href="#" class="block py-2 pl-11 pr-2 rounded-lg text-sm hover:text-white nav-text"
                            style="color: rgb(var(--text-muted));">Permissions</a></li>
                    <li><a href="#" class="block py-2 pl-11 pr-2 rounded-lg text-sm hover:text-white nav-text"
                            style="color: rgb(var(--text-muted));">Access Matrix</a></li>
                    <li><a href="#" class="block py-2 pl-11 pr-2 rounded-lg text-sm hover:text-white nav-text"
                            style="color: rgb(var(--text-muted));">Audit & Governance</a></li>
                </ul>
            </li>

            <li>
                <button @click="toggle('audit')"
                    class="w-full group flex items-center justify-between py-3 px-3 rounded-lg transition-all duration-200 ease-in-out hover:bg-white/5"
                    :style="activeDropdown === 'audit' ? 'background-color: rgb(var(--item-active-bg)); color: rgb(var(--text-main));' :
                        'color: rgb(var(--text-muted));'">
                    <div class="flex items-center overflow-hidden">
                        <svg class="w-5 h-5 flex-shrink-0 transition-colors"
                            :style="activeDropdown === 'audit' ? 'color: rgb(var(--brand-primary))' : ''"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        <span x-show="sidebarOpen"
                            class="ml-3 text-sm font-medium tracking-wide nav-text transition-opacity duration-300"
                            x-cloak>
                            Audit Compliance & Regulatory
                        </span>
                    </div>
                    <svg x-show="sidebarOpen" :class="activeDropdown === 'audit' ? 'rotate-180' : ''"
                        class="w-4 h-4 transition-transform duration-200 flex-shrink-0" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
                <ul x-show="activeDropdown === 'audit' && sidebarOpen" x-collapse class="mt-1 space-y-1 px-1" x-cloak>
                    <li><a href="#" class="block py-2 pl-11 pr-2 rounded-lg text-sm hover:text-white nav-text"
                            style="color: rgb(var(--text-muted));">Admin Action Audit Logs</a></li>
                    <li><a href="#" class="block py-2 pl-11 pr-2 rounded-lg text-sm hover:text-white nav-text"
                            style="color: rgb(var(--text-muted));">Financial & Transaction Audit</a></li>
                    <li><a href="#" class="block py-2 pl-11 pr-2 rounded-lg text-sm hover:text-white nav-text"
                            style="color: rgb(var(--text-muted));">Security & Access Audit</a></li>
                    <li><a href="#" class="block py-2 pl-11 pr-2 rounded-lg text-sm hover:text-white nav-text"
                            style="color: rgb(var(--text-muted));">Data Access & Privacy Compliance</a></li>
                    <li><a href="#" class="block py-2 pl-11 pr-2 rounded-lg text-sm hover:text-white nav-text"
                            style="color: rgb(var(--text-muted));">Regulatory Reporting & Exports</a></li>
                    <li><a href="#" class="block py-2 pl-11 pr-2 rounded-lg text-sm hover:text-white nav-text"
                            style="color: rgb(var(--text-muted));">Data Retention & Legal Holds</a></li>
                    <li><a href="#" class="block py-2 pl-11 pr-2 rounded-lg text-sm hover:text-white nav-text"
                            style="color: rgb(var(--text-muted));">Audit Search, Replay & Forensics</a></li>
                    <li><a href="#" class="block py-2 pl-11 pr-2 rounded-lg text-sm hover:text-white nav-text"
                            style="color: rgb(var(--text-muted));">Compliance Monitoring & Alerts</a></li>
                </ul>
            </li>

            <li>
                <button @click="toggle('settings')"
                    class="w-full group flex items-center justify-between py-3 px-3 rounded-lg transition-all duration-200 ease-in-out hover:bg-white/5"
                    :style="activeDropdown === 'settings' ? 'background-color: rgb(var(--item-active-bg)); color: rgb(var(--text-main));' :
                        'color: rgb(var(--text-muted));'">
                    <div class="flex items-center overflow-hidden">
                        <svg class="w-5 h-5 flex-shrink-0 transition-colors"
                            :style="activeDropdown === 'settings' ? 'color: rgb(var(--brand-primary))' : ''"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        <span x-show="sidebarOpen"
                            class="ml-3 text-sm font-medium tracking-wide nav-text transition-opacity duration-300"
                            x-cloak>
                            System Setting & Configuration
                        </span>
                    </div>
                    <svg x-show="sidebarOpen" :class="activeDropdown === 'settings' ? 'rotate-180' : ''"
                        class="w-4 h-4 transition-transform duration-200 flex-shrink-0" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
                <ul x-show="activeDropdown === 'settings' && sidebarOpen" x-collapse class="mt-1 space-y-1 px-1"
                    x-cloak>
                    <li><a href="#" class="block py-2 pl-11 pr-2 rounded-lg text-sm hover:text-white nav-text"
                            style="color: rgb(var(--text-muted));">Global Platform Preferences</a></li>
                    <li><a href="#" class="block py-2 pl-11 pr-2 rounded-lg text-sm hover:text-white nav-text"
                            style="color: rgb(var(--text-muted));">Feature Flag & Release Control</a></li>
                    <li><a href="#" class="block py-2 pl-11 pr-2 rounded-lg text-sm hover:text-white nav-text"
                            style="color: rgb(var(--text-muted));">Environment & Deployment Config</a></li>
                    <li><a href="#" class="block py-2 pl-11 pr-2 rounded-lg text-sm hover:text-white nav-text"
                            style="color: rgb(var(--text-muted));">Localization & Internationalization</a></li>
                    <li><a href="#" class="block py-2 pl-11 pr-2 rounded-lg text-sm hover:text-white nav-text"
                            style="color: rgb(var(--text-muted));">Geo & Map Configuration</a></li>
                    <li><a href="#" class="block py-2 pl-11 pr-2 rounded-lg text-sm hover:text-white nav-text"
                            style="color: rgb(var(--text-muted));">Rate Limits & Throttling</a></li>
                    <li><a href="#" class="block py-2 pl-11 pr-2 rounded-lg text-sm hover:text-white nav-text"
                            style="color: rgb(var(--text-muted));">Configuration Versioning & Rollback</a></li>
                    <li><a href="#" class="block py-2 pl-11 pr-2 rounded-lg text-sm hover:text-white nav-text"
                            style="color: rgb(var(--text-muted));">Configuration Impact Analysis</a></li>
                    <li><a href="#" class="block py-2 pl-11 pr-2 rounded-lg text-sm hover:text-white nav-text"
                            style="color: rgb(var(--text-muted));">Access Control & Governance</a></li>
                </ul>
            </li>

            <li x-show="sidebarOpen" class="px-3 mt-6 mb-2" x-cloak>
                <span class="text-[10px] font-bold uppercase tracking-wider opacity-60 nav-text"
                    style="color: rgb(var(--text-muted));">Identity trust & compliance</span>
            </li>

            <li>
                <button @click="toggle('accounts')"
                    class="w-full group flex items-center justify-between py-3 px-3 rounded-lg transition-all duration-200 ease-in-out hover:bg-white/5"
                    :style="activeDropdown === 'accounts' ? 'background-color: rgb(var(--item-active-bg)); color: rgb(var(--text-main));' :
                        'color: rgb(var(--text-muted));'">
                    <div class="flex items-center overflow-hidden">
                        <svg class="w-5 h-5 flex-shrink-0 transition-colors"
                            :style="activeDropdown === 'accounts' ? 'color: rgb(var(--brand-primary))' : ''"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        <span x-show="sidebarOpen"
                            class="ml-3 text-sm font-medium tracking-wide nav-text transition-opacity duration-300"
                            x-cloak>
                            Account & Entities
                        </span>
                    </div>
                    <svg x-show="sidebarOpen" :class="activeDropdown === 'accounts' ? 'rotate-180' : ''"
                        class="w-4 h-4 transition-transform duration-200 flex-shrink-0" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
                <ul x-show="activeDropdown === 'accounts' && sidebarOpen" x-collapse class="mt-1 space-y-1 px-1"
                    x-cloak>
                    <li><a href="{{ route('customer.index') }}" class="block py-2 pl-11 pr-2 rounded-lg text-sm hover:text-white nav-text"
                            style="color: rgb(var(--text-muted));">Customers (Users)</a></li>
                    <li><a href="{{ route('provider.index') }}" class="block py-2 pl-11 pr-2 rounded-lg text-sm hover:text-white nav-text"
                            style="color: rgb(var(--text-muted));">Service Providers</a></li>
                    <li><a href="{{ route('professional.index') }}" class="block py-2 pl-11 pr-2 rounded-lg text-sm hover:text-white nav-text"
                            style="color: rgb(var(--text-muted));">Professional Experts</a></li>
                    <li><a href="{{ route('consultant.index') }}" class="block py-2 pl-11 pr-2 rounded-lg text-sm hover:text-white nav-text"
                            style="color: rgb(var(--text-muted));">Consultants</a></li>
                    <li><a href="{{ route('mart.index') }}" class="block py-2 pl-11 pr-2 rounded-lg text-sm hover:text-white nav-text"
                            style="color: rgb(var(--text-muted));">Mart Vendors</a></li>
                    <li><a href="{{ route('rider.index') }}" class="block py-2 pl-11 pr-2 rounded-lg text-sm hover:text-white nav-text"
                            style="color: rgb(var(--text-muted));">Riders</a></li>
                    <li><a href="#" class="block py-2 pl-11 pr-2 rounded-lg text-sm hover:text-white nav-text"
                            style="color: rgb(var(--text-muted));">Future Verticals</a></li>
                </ul>
            </li>

            <li>
                <button @click="toggle('kyc')"
                    class="w-full group flex items-center justify-between py-3 px-3 rounded-lg transition-all duration-200 ease-in-out hover:bg-white/5"
                    :style="activeDropdown === 'kyc' ? 'background-color: rgb(var(--item-active-bg)); color: rgb(var(--text-main));' :
                        'color: rgb(var(--text-muted));'">
                    <div class="flex items-center overflow-hidden">
                        <svg class="w-5 h-5 flex-shrink-0 transition-colors"
                            :style="activeDropdown === 'kyc' ? 'color: rgb(var(--brand-primary))' : ''"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0c0 .6.4 1 1 1s1-.4 1-1m0 0H9" />
                        </svg>
                        <span x-show="sidebarOpen"
                            class="ml-3 text-sm font-medium tracking-wide nav-text transition-opacity duration-300"
                            x-cloak>
                            KYC, Identity & Document verifications
                        </span>
                    </div>
                    <svg x-show="sidebarOpen" :class="activeDropdown === 'kyc' ? 'rotate-180' : ''"
                        class="w-4 h-4 transition-transform duration-200 flex-shrink-0" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
                <ul x-show="activeDropdown === 'kyc' && sidebarOpen" x-collapse class="mt-1 space-y-1 px-1" x-cloak>
                    <li><a href="#" class="block py-2 pl-11 pr-2 rounded-lg text-sm hover:text-white nav-text"
                            style="color: rgb(var(--text-muted));">Document Management</a></li>
                    <li><a href="#" class="block py-2 pl-11 pr-2 rounded-lg text-sm hover:text-white nav-text"
                            style="color: rgb(var(--text-muted));">AI Verification Pipeline</a></li>
                    <li><a href="#" class="block py-2 pl-11 pr-2 rounded-lg text-sm hover:text-white nav-text"
                            style="color: rgb(var(--text-muted));">KYC Orchestration Engine</a></li>
                    <li><a href="#" class="block py-2 pl-11 pr-2 rounded-lg text-sm hover:text-white nav-text"
                            style="color: rgb(var(--text-muted));">Entity-Specific KYC Controls</a></li>
                    <li><a href="#" class="block py-2 pl-11 pr-2 rounded-lg text-sm hover:text-white nav-text"
                            style="color: rgb(var(--text-muted));">Compliance & Governance</a></li>
                </ul>
            </li>

            <li x-show="sidebarOpen" class="px-3 mt-6 mb-2" x-cloak>
                <span class="text-[10px] font-bold uppercase tracking-wider opacity-60 nav-text"
                    style="color: rgb(var(--text-muted));">Marketplace Configuration & Monetization</span>
            </li>

            <li>
                <button @click="toggle('catalog')"
                    class="w-full group flex items-center justify-between py-3 px-3 rounded-lg transition-all duration-200 ease-in-out hover:bg-white/5"
                    :style="activeDropdown === 'catalog' ? 'background-color: rgb(var(--item-active-bg)); color: rgb(var(--text-main));' :
                        'color: rgb(var(--text-muted));'">
                    <div class="flex items-center overflow-hidden">
                        <svg class="w-5 h-5 flex-shrink-0 transition-colors"
                            :style="activeDropdown === 'catalog' ? 'color: rgb(var(--brand-primary))' : ''"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                        </svg>
                        <span x-show="sidebarOpen"
                            class="ml-3 text-sm font-medium tracking-wide nav-text transition-opacity duration-300"
                            x-cloak>
                            Services & Mart Catalog
                        </span>
                    </div>
                    <svg x-show="sidebarOpen" :class="activeDropdown === 'catalog' ? 'rotate-180' : ''"
                        class="w-4 h-4 transition-transform duration-200 flex-shrink-0" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
                <ul x-show="activeDropdown === 'catalog' && sidebarOpen" x-collapse class="mt-1 space-y-1 px-1"
                    x-cloak>
                    <li><a href="#" class="block py-2 pl-11 pr-2 rounded-lg text-sm hover:text-white nav-text"
                            style="color: rgb(var(--text-muted));">Services Catalog</a></li>
                    <li><a href="#" class="block py-2 pl-11 pr-2 rounded-lg text-sm hover:text-white nav-text"
                            style="color: rgb(var(--text-muted));">Professional & Consultation Offerings</a></li>
                    <li><a href="#" class="block py-2 pl-11 pr-2 rounded-lg text-sm hover:text-white nav-text"
                            style="color: rgb(var(--text-muted));">Mart Catalog</a></li>
                    <li><a href="#" class="block py-2 pl-11 pr-2 rounded-lg text-sm hover:text-white nav-text"
                            style="color: rgb(var(--text-muted));">Rules & Availability Engine</a></li>
                    <li><a href="#" class="block py-2 pl-11 pr-2 rounded-lg text-sm hover:text-white nav-text"
                            style="color: rgb(var(--text-muted));">Entity Mapping</a></li>
                </ul>
            </li>

            <li>
                <button @click="toggle('subscriptions')"
                    class="w-full group flex items-center justify-between py-3 px-3 rounded-lg transition-all duration-200 ease-in-out hover:bg-white/5"
                    :style="activeDropdown === 'subscriptions' ?
                        'background-color: rgb(var(--item-active-bg)); color: rgb(var(--text-main));' : 'color: rgb(var(--text-muted));'">
                    <div class="flex items-center overflow-hidden">
                        <svg class="w-5 h-5 flex-shrink-0 transition-colors"
                            :style="activeDropdown === 'subscriptions' ? 'color: rgb(var(--brand-primary))' : ''"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z" />
                        </svg>
                        <span x-show="sidebarOpen"
                            class="ml-3 text-sm font-medium tracking-wide nav-text transition-opacity duration-300"
                            x-cloak>
                            Subscriptions & Entitlements
                        </span>
                    </div>
                    <svg x-show="sidebarOpen" :class="activeDropdown === 'subscriptions' ? 'rotate-180' : ''"
                        class="w-4 h-4 transition-transform duration-200 flex-shrink-0" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
                <ul x-show="activeDropdown === 'subscriptions' && sidebarOpen" x-collapse class="mt-1 space-y-1 px-1"
                    x-cloak>
                    <li><a href="#" class="block py-2 pl-11 pr-2 rounded-lg text-sm hover:text-white nav-text"
                            style="color: rgb(var(--text-muted));">Plan Management</a></li>
                    <li><a href="#" class="block py-2 pl-11 pr-2 rounded-lg text-sm hover:text-white nav-text"
                            style="color: rgb(var(--text-muted));">Entitlement & Feature Keys</a></li>
                    <li><a href="#" class="block py-2 pl-11 pr-2 rounded-lg text-sm hover:text-white nav-text"
                            style="color: rgb(var(--text-muted));">Subscription Lifecycle</a></li>
                    <li><a href="#" class="block py-2 pl-11 pr-2 rounded-lg text-sm hover:text-white nav-text"
                            style="color: rgb(var(--text-muted));">Enforcement Engine</a></li>
                    <li><a href="#" class="block py-2 pl-11 pr-2 rounded-lg text-sm hover:text-white nav-text"
                            style="color: rgb(var(--text-muted));">Admin Overrides & Governance</a></li>
                </ul>
            </li>

            <li>
                <button @click="toggle('monetization')"
                    class="w-full group flex items-center justify-between py-3 px-3 rounded-lg transition-all duration-200 ease-in-out hover:bg-white/5"
                    :style="activeDropdown === 'monetization' ? 'background-color: rgb(var(--item-active-bg)); color: rgb(var(--text-main));' :
                        'color: rgb(var(--text-muted));'">
                    <div class="flex items-center overflow-hidden">
                        <svg class="w-5 h-5 flex-shrink-0 transition-colors"
                            :style="activeDropdown === 'monetization' ? 'color: rgb(var(--brand-primary))' : ''"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span x-show="sidebarOpen"
                            class="ml-3 text-sm font-medium tracking-wide nav-text transition-opacity duration-300"
                            x-cloak>
                            Monitizations & Promotions
                        </span>
                    </div>
                    <svg x-show="sidebarOpen" :class="activeDropdown === 'monetization' ? 'rotate-180' : ''"
                        class="w-4 h-4 transition-transform duration-200 flex-shrink-0" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
                <ul x-show="activeDropdown === 'monetization' && sidebarOpen" x-collapse class="mt-1 space-y-1 px-1"
                    x-cloak>
                    <li><a href="#" class="block py-2 pl-11 pr-2 rounded-lg text-sm hover:text-white nav-text"
                            style="color: rgb(var(--text-muted));">Featured Listings</a></li>
                    <li><a href="#" class="block py-2 pl-11 pr-2 rounded-lg text-sm hover:text-white nav-text"
                            style="color: rgb(var(--text-muted));">Visibility Boosts (Add-ons)</a></li>
                    <li><a href="#" class="block py-2 pl-11 pr-2 rounded-lg text-sm hover:text-white nav-text"
                            style="color: rgb(var(--text-muted));">Inventory & Conflict Management</a></li>
                    <li><a href="#" class="block py-2 pl-11 pr-2 rounded-lg text-sm hover:text-white nav-text"
                            style="color: rgb(var(--text-muted));">Pricing & Revenue Control</a></li>
                    <li><a href="#" class="block py-2 pl-11 pr-2 rounded-lg text-sm hover:text-white nav-text"
                            style="color: rgb(var(--text-muted));">Performance & Analytics</a></li>
                    <li><a href="#" class="block py-2 pl-11 pr-2 rounded-lg text-sm hover:text-white nav-text"
                            style="color: rgb(var(--text-muted));">Enforcement & Governance</a></li>
                </ul>
            </li>

            <li x-show="sidebarOpen" class="px-3 mt-6 mb-2" x-cloak>
                <span class="text-[10px] font-bold uppercase tracking-wider opacity-60 nav-text"
                    style="color: rgb(var(--text-muted));">Orders, Logistics & Financial operations</span>
            </li>

            <li>
                <button @click="toggle('orders')"
                    class="w-full group flex items-center justify-between py-3 px-3 rounded-lg transition-all duration-200 ease-in-out hover:bg-white/5"
                    :style="activeDropdown === 'orders' ? 'background-color: rgb(var(--item-active-bg)); color: rgb(var(--text-main));' :
                        'color: rgb(var(--text-muted));'">
                    <div class="flex items-center overflow-hidden">
                        <svg class="w-5 h-5 flex-shrink-0 transition-colors"
                            :style="activeDropdown === 'orders' ? 'color: rgb(var(--brand-primary))' : ''"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                        <span x-show="sidebarOpen"
                            class="ml-3 text-sm font-medium tracking-wide nav-text transition-opacity duration-300"
                            x-cloak>
                            Orders & Bookings
                        </span>
                    </div>
                    <svg x-show="sidebarOpen" :class="activeDropdown === 'orders' ? 'rotate-180' : ''"
                        class="w-4 h-4 transition-transform duration-200 flex-shrink-0" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
                <ul x-show="activeDropdown === 'orders' && sidebarOpen" x-collapse class="mt-1 space-y-1 px-1"
                    x-cloak>
                    <li><a href="#" class="block py-2 pl-11 pr-2 rounded-lg text-sm hover:text-white nav-text"
                            style="color: rgb(var(--text-muted));">Order Ledger</a></li>
                    <li><a href="#" class="block py-2 pl-11 pr-2 rounded-lg text-sm hover:text-white nav-text"
                            style="color: rgb(var(--text-muted));">Order Lifecycle Management</a></li>
                    <li><a href="#" class="block py-2 pl-11 pr-2 rounded-lg text-sm hover:text-white nav-text"
                            style="color: rgb(var(--text-muted));">Assignment & Routing</a></li>
                    <li><a href="#" class="block py-2 pl-11 pr-2 rounded-lg text-sm hover:text-white nav-text"
                            style="color: rgb(var(--text-muted));">Admin Intervention & Notes</a></li>
                </ul>
            </li>

            <li>
                <button @click="toggle('logistics')"
                    class="w-full group flex items-center justify-between py-3 px-3 rounded-lg transition-all duration-200 ease-in-out hover:bg-white/5"
                    :style="activeDropdown === 'logistics' ? 'background-color: rgb(var(--item-active-bg)); color: rgb(var(--text-main));' :
                        'color: rgb(var(--text-muted));'">
                    <div class="flex items-center overflow-hidden">
                        <svg class="w-5 h-5 flex-shrink-0 transition-colors"
                            :style="activeDropdown === 'logistics' ? 'color: rgb(var(--brand-primary))' : ''"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 02-1-1H9m5 9v2m0 4H9m5 0h6m-6-4v4m6-4v4m-6-4h6" />
                        </svg>
                        <span x-show="sidebarOpen"
                            class="ml-3 text-sm font-medium tracking-wide nav-text transition-opacity duration-300"
                            x-cloak>
                            Delivery & Logistics
                        </span>
                    </div>
                    <svg x-show="sidebarOpen" :class="activeDropdown === 'logistics' ? 'rotate-180' : ''"
                        class="w-4 h-4 transition-transform duration-200 flex-shrink-0" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
                <ul x-show="activeDropdown === 'logistics' && sidebarOpen" x-collapse class="mt-1 space-y-1 px-1"
                    x-cloak>
                    <li><a href="#" class="block py-2 pl-11 pr-2 rounded-lg text-sm hover:text-white nav-text"
                            style="color: rgb(var(--text-muted));">Rider Management</a></li>
                    <li><a href="#" class="block py-2 pl-11 pr-2 rounded-lg text-sm hover:text-white nav-text"
                            style="color: rgb(var(--text-muted));">Courier Integration</a></li>
                    <li><a href="#" class="block py-2 pl-11 pr-2 rounded-lg text-sm hover:text-white nav-text"
                            style="color: rgb(var(--text-muted));">Live Tracking & Navigation</a></li>
                    <li><a href="#" class="block py-2 pl-11 pr-2 rounded-lg text-sm hover:text-white nav-text"
                            style="color: rgb(var(--text-muted));">Proof of Delivery (POD)</a></li>
                    <li><a href="#" class="block py-2 pl-11 pr-2 rounded-lg text-sm hover:text-white nav-text"
                            style="color: rgb(var(--text-muted));">Cash on Delivery (COD)</a></li>
                    <li><a href="#" class="block py-2 pl-11 pr-2 rounded-lg text-sm hover:text-white nav-text"
                            style="color: rgb(var(--text-muted));">Failure & Return Management</a></li>
                </ul>
            </li>

            <li>
                <button @click="toggle('finance')"
                    class="w-full group flex items-center justify-between py-3 px-3 rounded-lg transition-all duration-200 ease-in-out hover:bg-white/5"
                    :style="activeDropdown === 'finance' ? 'background-color: rgb(var(--item-active-bg)); color: rgb(var(--text-main));' :
                        'color: rgb(var(--text-muted));'">
                    <div class="flex items-center overflow-hidden">
                        <svg class="w-5 h-5 flex-shrink-0 transition-colors"
                            :style="activeDropdown === 'finance' ? 'color: rgb(var(--brand-primary))' : ''"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                        </svg>
                        <span x-show="sidebarOpen"
                            class="ml-3 text-sm font-medium tracking-wide nav-text transition-opacity duration-300"
                            x-cloak>
                            Finance & Payments
                        </span>
                    </div>
                    <svg x-show="sidebarOpen" :class="activeDropdown === 'finance' ? 'rotate-180' : ''"
                        class="w-4 h-4 transition-transform duration-200 flex-shrink-0" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
                <ul x-show="activeDropdown === 'finance' && sidebarOpen" x-collapse class="mt-1 space-y-1 px-1"
                    x-cloak>
                    <li><a href="#" class="block py-2 pl-11 pr-2 rounded-lg text-sm hover:text-white nav-text"
                            style="color: rgb(var(--text-muted));">Revenue & Ledger</a></li>
                    <li><a href="#" class="block py-2 pl-11 pr-2 rounded-lg text-sm hover:text-white nav-text"
                            style="color: rgb(var(--text-muted));">Wallets</a></li>
                    <li><a href="#" class="block py-2 pl-11 pr-2 rounded-lg text-sm hover:text-white nav-text"
                            style="color: rgb(var(--text-muted));">Commissions & Tax</a></li>
                    <li><a href="#" class="block py-2 pl-11 pr-2 rounded-lg text-sm hover:text-white nav-text"
                            style="color: rgb(var(--text-muted));">Payouts</a></li>
                    <li><a href="#" class="block py-2 pl-11 pr-2 rounded-lg text-sm hover:text-white nav-text"
                            style="color: rgb(var(--text-muted));">Cash on Delivery (COD) Settlement</a></li>
                    <li><a href="#" class="block py-2 pl-11 pr-2 rounded-lg text-sm hover:text-white nav-text"
                            style="color: rgb(var(--text-muted));">Financial Adjustments</a></li>
                </ul>
            </li>

            <li>
                <button @click="toggle('payment_gateways')"
                    class="w-full group flex items-center justify-between py-3 px-3 rounded-lg transition-all duration-200 ease-in-out hover:bg-white/5"
                    :style="activeDropdown === 'payment_gateways' ?
                        'background-color: rgb(var(--item-active-bg)); color: rgb(var(--text-main));' : 'color: rgb(var(--text-muted));'">
                    <div class="flex items-center overflow-hidden">
                        <svg class="w-5 h-5 flex-shrink-0 transition-colors"
                            :style="activeDropdown === 'payment_gateways' ? 'color: rgb(var(--brand-primary))' : ''"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" />
                        </svg>
                        <span x-show="sidebarOpen"
                            class="ml-3 text-sm font-medium tracking-wide nav-text transition-opacity duration-300"
                            x-cloak>
                            Payment Gateways & PSP Management
                        </span>
                    </div>
                    <svg x-show="sidebarOpen" :class="activeDropdown === 'payment_gateways' ? 'rotate-180' : ''"
                        class="w-4 h-4 transition-transform duration-200 flex-shrink-0" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
                <ul x-show="activeDropdown === 'payment_gateways' && sidebarOpen" x-collapse
                    class="mt-1 space-y-1 px-1" x-cloak>
                    <li><a href="#" class="block py-2 pl-11 pr-2 rounded-lg text-sm hover:text-white nav-text"
                            style="color: rgb(var(--text-muted));">PSP Registry & Management</a></li>
                    <li><a href="#" class="block py-2 pl-11 pr-2 rounded-lg text-sm hover:text-white nav-text"
                            style="color: rgb(var(--text-muted));">Payment Routing Engine</a></li>
                    <li><a href="#" class="block py-2 pl-11 pr-2 rounded-lg text-sm hover:text-white nav-text"
                            style="color: rgb(var(--text-muted));">Key Management & Security</a></li>
                    <li><a href="#" class="block py-2 pl-11 pr-2 rounded-lg text-sm hover:text-white nav-text"
                            style="color: rgb(var(--text-muted));">Transaction Monitoring & Webhooks</a></li>
                    <li><a href="#" class="block py-2 pl-11 pr-2 rounded-lg text-sm hover:text-white nav-text"
                            style="color: rgb(var(--text-muted));">Failure Handling & Fallback</a></li>
                </ul>
            </li>

            <li x-show="sidebarOpen" class="px-3 mt-6 mb-2" x-cloak>
                <span class="text-[10px] font-bold uppercase tracking-wider opacity-60 nav-text"
                    style="color: rgb(var(--text-muted));">Risk, Fraud & Dispute Protection</span>
            </li>

            <li>
                <button @click="toggle('fraud')"
                    class="w-full group flex items-center justify-between py-3 px-3 rounded-lg transition-all duration-200 ease-in-out hover:bg-white/5"
                    :style="activeDropdown === 'fraud' ? 'background-color: rgb(var(--item-active-bg)); color: rgb(var(--text-main));' :
                        'color: rgb(var(--text-muted));'">
                    <div class="flex items-center overflow-hidden">
                        <svg class="w-5 h-5 flex-shrink-0 transition-colors"
                            :style="activeDropdown === 'fraud' ? 'color: rgb(var(--brand-primary))' : ''"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.368 17c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                        <span x-show="sidebarOpen"
                            class="ml-3 text-sm font-medium tracking-wide nav-text transition-opacity duration-300"
                            x-cloak>
                            Fraud, Risks & Abuse Management
                        </span>
                    </div>
                    <svg x-show="sidebarOpen" :class="activeDropdown === 'fraud' ? 'rotate-180' : ''"
                        class="w-4 h-4 transition-transform duration-200 flex-shrink-0" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
                <ul x-show="activeDropdown === 'fraud' && sidebarOpen" x-collapse class="mt-1 space-y-1 px-1" x-cloak>
                    <li><a href="#" class="block py-2 pl-11 pr-2 rounded-lg text-sm hover:text-white nav-text"
                            style="color: rgb(var(--text-muted));">Risk Scoring Engine</a></li>
                    <li><a href="#" class="block py-2 pl-11 pr-2 rounded-lg text-sm hover:text-white nav-text"
                            style="color: rgb(var(--text-muted));">Session & Identity Risk</a></li>
                    <li><a href="#" class="block py-2 pl-11 pr-2 rounded-lg text-sm hover:text-white nav-text"
                            style="color: rgb(var(--text-muted));">Payment & Wallet Abuse Detection</a></li>
                    <li><a href="#" class="block py-2 pl-11 pr-2 rounded-lg text-sm hover:text-white nav-text"
                            style="color: rgb(var(--text-muted));">Promotion & Incentive Abuse</a></li>
                    <li><a href="#" class="block py-2 pl-11 pr-2 rounded-lg text-sm hover:text-white nav-text"
                            style="color: rgb(var(--text-muted));">Collusion & Network Fraud Detection</a></li>
                    <li><a href="#" class="block py-2 pl-11 pr-2 rounded-lg text-sm hover:text-white nav-text"
                            style="color: rgb(var(--text-muted));">Automated Enforcement Engine</a></li>
                    <li><a href="#" class="block py-2 pl-11 pr-2 rounded-lg text-sm hover:text-white nav-text"
                            style="color: rgb(var(--text-muted));">Manual Overrides & Governance</a></li>
                </ul>
            </li>

            <li>
                <button @click="toggle('disputes')"
                    class="w-full group flex items-center justify-between py-3 px-3 rounded-lg transition-all duration-200 ease-in-out hover:bg-white/5"
                    :style="activeDropdown === 'disputes' ? 'background-color: rgb(var(--item-active-bg)); color: rgb(var(--text-main));' :
                        'color: rgb(var(--text-muted));'">
                    <div class="flex items-center overflow-hidden">
                        <svg class="w-5 h-5 flex-shrink-0 transition-colors"
                            :style="activeDropdown === 'disputes' ? 'color: rgb(var(--brand-primary))' : ''"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3" />
                        </svg>
                        <span x-show="sidebarOpen"
                            class="ml-3 text-sm font-medium tracking-wide nav-text transition-opacity duration-300"
                            x-cloak>
                            Disputes, Refunds & Appeals
                        </span>
                    </div>
                    <svg x-show="sidebarOpen" :class="activeDropdown === 'disputes' ? 'rotate-180' : ''"
                        class="w-4 h-4 transition-transform duration-200 flex-shrink-0" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
                <ul x-show="activeDropdown === 'disputes' && sidebarOpen" x-collapse class="mt-1 space-y-1 px-1"
                    x-cloak>
                    <li><a href="#" class="block py-2 pl-11 pr-2 rounded-lg text-sm hover:text-white nav-text"
                            style="color: rgb(var(--text-muted));">Complaint Intake & Classification</a></li>
                    <li><a href="#" class="block py-2 pl-11 pr-2 rounded-lg text-sm hover:text-white nav-text"
                            style="color: rgb(var(--text-muted));">Evidence & Context Management</a></li>
                    <li><a href="#" class="block py-2 pl-11 pr-2 rounded-lg text-sm hover:text-white nav-text"
                            style="color: rgb(var(--text-muted));">AI Dispute Triage & Recommendations</a></li>
                    <li><a href="#" class="block py-2 pl-11 pr-2 rounded-lg text-sm hover:text-white nav-text"
                            style="color: rgb(var(--text-muted));">Refund Engine</a></li>
                    <li><a href="#" class="block py-2 pl-11 pr-2 rounded-lg text-sm hover:text-white nav-text"
                            style="color: rgb(var(--text-muted));">Appeals Management</a></li>
                    <li><a href="#" class="block py-2 pl-11 pr-2 rounded-lg text-sm hover:text-white nav-text"
                            style="color: rgb(var(--text-muted));">SLA, Escalation & Governance</a></li>
                    <li><a href="#" class="block py-2 pl-11 pr-2 rounded-lg text-sm hover:text-white nav-text"
                            style="color: rgb(var(--text-muted));">Abuse & Policy Enforcement</a></li>
                    <li><a href="#" class="block py-2 pl-11 pr-2 rounded-lg text-sm hover:text-white nav-text"
                            style="color: rgb(var(--text-muted));">Legal & Compliance Handling</a></li>
                </ul>
            </li>

            <li x-show="sidebarOpen" class="px-3 mt-6 mb-2" x-cloak>
                <span class="text-[10px] font-bold uppercase tracking-wider opacity-60 nav-text"
                    style="color: rgb(var(--text-muted));">Performance & Analytics</span>
            </li>

            <li>
                <button @click="toggle('analytics')"
                    class="w-full group flex items-center justify-between py-3 px-3 rounded-lg transition-all duration-200 ease-in-out hover:bg-white/5"
                    :style="activeDropdown === 'analytics' ? 'background-color: rgb(var(--item-active-bg)); color: rgb(var(--text-main));' :
                        'color: rgb(var(--text-muted));'">
                    <div class="flex items-center overflow-hidden">
                        <svg class="w-5 h-5 flex-shrink-0 transition-colors"
                            :style="activeDropdown === 'analytics' ? 'color: rgb(var(--brand-primary))' : ''"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                        </svg>
                        <span x-show="sidebarOpen"
                            class="ml-3 text-sm font-medium tracking-wide nav-text transition-opacity duration-300"
                            x-cloak>
                            Reports & Analytics
                        </span>
                    </div>
                    <svg x-show="sidebarOpen" :class="activeDropdown === 'analytics' ? 'rotate-180' : ''"
                        class="w-4 h-4 transition-transform duration-200 flex-shrink-0" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
                <ul x-show="activeDropdown === 'analytics' && sidebarOpen" x-collapse class="mt-1 space-y-1 px-1"
                    x-cloak>
                    <li><a href="#" class="block py-2 pl-11 pr-2 rounded-lg text-sm hover:text-white nav-text"
                            style="color: rgb(var(--text-muted));">Financial Reporting</a></li>
                    <li><a href="#" class="block py-2 pl-11 pr-2 rounded-lg text-sm hover:text-white nav-text"
                            style="color: rgb(var(--text-muted));">Growth & User Analytics</a></li>
                    <li><a href="#" class="block py-2 pl-11 pr-2 rounded-lg text-sm hover:text-white nav-text"
                            style="color: rgb(var(--text-muted));">Supply & Performance Analytics</a></li>
                    <li><a href="#" class="block py-2 pl-11 pr-2 rounded-lg text-sm hover:text-white nav-text"
                            style="color: rgb(var(--text-muted));">Operational Efficiency Reports</a></li>
                    <li><a href="#" class="block py-2 pl-11 pr-2 rounded-lg text-sm hover:text-white nav-text"
                            style="color: rgb(var(--text-muted));">Risk, Fraud & Compliance Reports</a></li>
                    <li><a href="#" class="block py-2 pl-11 pr-2 rounded-lg text-sm hover:text-white nav-text"
                            style="color: rgb(var(--text-muted));">Subscription & Monetization Analytics</a></li>
                    <li><a href="#" class="block py-2 pl-11 pr-2 rounded-lg text-sm hover:text-white nav-text"
                            style="color: rgb(var(--text-muted));">Custom Report Builder</a></li>
                    <li><a href="#" class="block py-2 pl-11 pr-2 rounded-lg text-sm hover:text-white nav-text"
                            style="color: rgb(var(--text-muted));">Scheduled & Automated Reporting</a></li>
                </ul>
            </li>

            <li x-show="sidebarOpen" class="px-3 mt-6 mb-2" x-cloak>
                <span class="text-[10px] font-bold uppercase tracking-wider opacity-60 nav-text"
                    style="color: rgb(var(--text-muted));">Marketing & Communications</span>
            </li>

            <li>
                <button @click="toggle('marketing')"
                    class="w-full group flex items-center justify-between py-3 px-3 rounded-lg transition-all duration-200 ease-in-out hover:bg-white/5"
                    :style="activeDropdown === 'marketing' ? 'background-color: rgb(var(--item-active-bg)); color: rgb(var(--text-main));' :
                        'color: rgb(var(--text-muted));'">
                    <div class="flex items-center overflow-hidden">
                        <svg class="w-5 h-5 flex-shrink-0 transition-colors"
                            :style="activeDropdown === 'marketing' ? 'color: rgb(var(--brand-primary))' : ''"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                        </svg>
                        <span x-show="sidebarOpen"
                            class="ml-3 text-sm font-medium tracking-wide nav-text transition-opacity duration-300"
                            x-cloak>
                            Marketing & Growths
                        </span>
                    </div>
                    <svg x-show="sidebarOpen" :class="activeDropdown === 'marketing' ? 'rotate-180' : ''"
                        class="w-4 h-4 transition-transform duration-200 flex-shrink-0" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
                <ul x-show="activeDropdown === 'marketing' && sidebarOpen" x-collapse class="mt-1 space-y-1 px-1"
                    x-cloak>
                    <li><a href="#" class="block py-2 pl-11 pr-2 rounded-lg text-sm hover:text-white nav-text"
                            style="color: rgb(var(--text-muted));">Promo Code Management</a></li>
                    <li><a href="#" class="block py-2 pl-11 pr-2 rounded-lg text-sm hover:text-white nav-text"
                            style="color: rgb(var(--text-muted));">Campaign Management</a></li>
                    <li><a href="#" class="block py-2 pl-11 pr-2 rounded-lg text-sm hover:text-white nav-text"
                            style="color: rgb(var(--text-muted));">Audience Segmentation Engine</a></li>
                    <li><a href="#" class="block py-2 pl-11 pr-2 rounded-lg text-sm hover:text-white nav-text"
                            style="color: rgb(var(--text-muted));">Loyalty & Rewards Engine</a></li>
                    <li><a href="#" class="block py-2 pl-11 pr-2 rounded-lg text-sm hover:text-white nav-text"
                            style="color: rgb(var(--text-muted));">Membership & Tier Programs</a></li>
                    <li><a href="#" class="block py-2 pl-11 pr-2 rounded-lg text-sm hover:text-white nav-text"
                            style="color: rgb(var(--text-muted));">A/B Testing & Experimentation</a></li>
                    <li><a href="#" class="block py-2 pl-11 pr-2 rounded-lg text-sm hover:text-white nav-text"
                            style="color: rgb(var(--text-muted));">Abuse & Safety Controls</a></li>
                </ul>
            </li>

            <li>
                <button @click="toggle('cms')"
                    class="w-full group flex items-center justify-between py-3 px-3 rounded-lg transition-all duration-200 ease-in-out hover:bg-white/5"
                    :style="activeDropdown === 'cms' ? 'background-color: rgb(var(--item-active-bg)); color: rgb(var(--text-main));' :
                        'color: rgb(var(--text-muted));'">
                    <div class="flex items-center overflow-hidden">
                        <svg class="w-5 h-5 flex-shrink-0 transition-colors"
                            :style="activeDropdown === 'cms' ? 'color: rgb(var(--brand-primary))' : ''"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>
                        <span x-show="sidebarOpen"
                            class="ml-3 text-sm font-medium tracking-wide nav-text transition-opacity duration-300"
                            x-cloak>
                            CMS & Content Management
                        </span>
                    </div>
                    <svg x-show="sidebarOpen" :class="activeDropdown === 'cms' ? 'rotate-180' : ''"
                        class="w-4 h-4 transition-transform duration-200 flex-shrink-0" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
                <ul x-show="activeDropdown === 'cms' && sidebarOpen" x-collapse class="mt-1 space-y-1 px-1" x-cloak>
                    <li><a href="#" class="block py-2 pl-11 pr-2 rounded-lg text-sm hover:text-white nav-text"
                            style="color: rgb(var(--text-muted));">Homepage & UI Layout Manager</a></li>
                    <li><a href="#" class="block py-2 pl-11 pr-2 rounded-lg text-sm hover:text-white nav-text"
                            style="color: rgb(var(--text-muted));">Banner & Promotional Content</a></li>
                    <li><a href="#" class="block py-2 pl-11 pr-2 rounded-lg text-sm hover:text-white nav-text"
                            style="color: rgb(var(--text-muted));">Content Blocks & Micro-Copy</a></li>
                    <li><a href="#" class="block py-2 pl-11 pr-2 rounded-lg text-sm hover:text-white nav-text"
                            style="color: rgb(var(--text-muted));">Notification & Message Templates</a></li>
                    <li><a href="#" class="block py-2 pl-11 pr-2 rounded-lg text-sm hover:text-white nav-text"
                            style="color: rgb(var(--text-muted));">Static Pages & Legal Content</a></li>
                    <li><a href="#" class="block py-2 pl-11 pr-2 rounded-lg text-sm hover:text-white nav-text"
                            style="color: rgb(var(--text-muted));">Blog & Educational Content</a></li>
                    <li><a href="#" class="block py-2 pl-11 pr-2 rounded-lg text-sm hover:text-white nav-text"
                            style="color: rgb(var(--text-muted));">Localization & Translations</a></li>
                    <li><a href="#" class="block py-2 pl-11 pr-2 rounded-lg text-sm hover:text-white nav-text"
                            style="color: rgb(var(--text-muted));">AI Content Moderation</a></li>
                    <li><a href="#" class="block py-2 pl-11 pr-2 rounded-lg text-sm hover:text-white nav-text"
                            style="color: rgb(var(--text-muted));">Content Performance & Analytics</a></li>
                </ul>
            </li>

            <li>
                <button @click="toggle('notifications')"
                    class="w-full group flex items-center justify-between py-3 px-3 rounded-lg transition-all duration-200 ease-in-out hover:bg-white/5"
                    :style="activeDropdown === 'notifications' ?
                        'background-color: rgb(var(--item-active-bg)); color: rgb(var(--text-main));' : 'color: rgb(var(--text-muted));'">
                    <div class="flex items-center overflow-hidden">
                        <svg class="w-5 h-5 flex-shrink-0 transition-colors"
                            :style="activeDropdown === 'notifications' ? 'color: rgb(var(--brand-primary))' : ''"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                        </svg>
                        <span x-show="sidebarOpen"
                            class="ml-3 text-sm font-medium tracking-wide nav-text transition-opacity duration-300"
                            x-cloak>
                            Notifications & Communications
                        </span>
                    </div>
                    <svg x-show="sidebarOpen" :class="activeDropdown === 'notifications' ? 'rotate-180' : ''"
                        class="w-4 h-4 transition-transform duration-200 flex-shrink-0" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
                <ul x-show="activeDropdown === 'notifications' && sidebarOpen" x-collapse class="mt-1 space-y-1 px-1"
                    x-cloak>
                    <li><a href="#" class="block py-2 pl-11 pr-2 rounded-lg text-sm hover:text-white nav-text"
                            style="color: rgb(var(--text-muted));">Channel Management</a></li>
                    <li><a href="#" class="block py-2 pl-11 pr-2 rounded-lg text-sm hover:text-white nav-text"
                            style="color: rgb(var(--text-muted));">Event-Driven Notification Engine</a></li>
                    <li><a href="#" class="block py-2 pl-11 pr-2 rounded-lg text-sm hover:text-white nav-text"
                            style="color: rgb(var(--text-muted));">Template Rendering & Personalization</a></li>
                    <li><a href="#" class="block py-2 pl-11 pr-2 rounded-lg text-sm hover:text-white nav-text"
                            style="color: rgb(var(--text-muted));">Delivery Orchestration & Reliability</a></li>
                    <li><a href="#" class="block py-2 pl-11 pr-2 rounded-lg text-sm hover:text-white nav-text"
                            style="color: rgb(var(--text-muted));">Bulk & Campaign Messaging</a></li>
                    <li><a href="#" class="block py-2 pl-11 pr-2 rounded-lg text-sm hover:text-white nav-text"
                            style="color: rgb(var(--text-muted));">User Preferences & Consent Management</a></li>
                    <li><a href="#" class="block py-2 pl-11 pr-2 rounded-lg text-sm hover:text-white nav-text"
                            style="color: rgb(var(--text-muted));">Delivery Logs & Traceability</a></li>
                    <li><a href="#" class="block py-2 pl-11 pr-2 rounded-lg text-sm hover:text-white nav-text"
                            style="color: rgb(var(--text-muted));">Rate Limiting & Anti-Spam Controls</a></li>
                    <li><a href="#" class="block py-2 pl-11 pr-2 rounded-lg text-sm hover:text-white nav-text"
                            style="color: rgb(var(--text-muted));">Escalation & Acknowledgment Tracking</a></li>
                </ul>
            </li>

            <li x-show="sidebarOpen" class="px-3 mt-6 mb-2" x-cloak>
                <span class="text-[10px] font-bold uppercase tracking-wider opacity-60 nav-text"
                    style="color: rgb(var(--text-muted));">Support & Operations Management</span>
            </li>

            <li>
                <button @click="toggle('support')"
                    class="w-full group flex items-center justify-between py-3 px-3 rounded-lg transition-all duration-200 ease-in-out hover:bg-white/5"
                    :style="activeDropdown === 'support' ? 'background-color: rgb(var(--item-active-bg)); color: rgb(var(--text-main));' :
                        'color: rgb(var(--text-muted));'">
                    <div class="flex items-center overflow-hidden">
                        <svg class="w-5 h-5 flex-shrink-0 transition-colors"
                            :style="activeDropdown === 'support' ? 'color: rgb(var(--brand-primary))' : ''"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                        <span x-show="sidebarOpen"
                            class="ml-3 text-sm font-medium tracking-wide nav-text transition-opacity duration-300"
                            x-cloak>
                            Support & Operations
                        </span>
                    </div>
                    <svg x-show="sidebarOpen" :class="activeDropdown === 'support' ? 'rotate-180' : ''"
                        class="w-4 h-4 transition-transform duration-200 flex-shrink-0" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
                <ul x-show="activeDropdown === 'support' && sidebarOpen" x-collapse class="mt-1 space-y-1 px-1"
                    x-cloak>
                    <li><a href="#" class="block py-2 pl-11 pr-2 rounded-lg text-sm hover:text-white nav-text"
                            style="color: rgb(var(--text-muted));">Ticket Intake & Queue Management</a></li>
                    <li><a href="#" class="block py-2 pl-11 pr-2 rounded-lg text-sm hover:text-white nav-text"
                            style="color: rgb(var(--text-muted));">SLA Management & Escalation</a></li>
                    <li><a href="#" class="block py-2 pl-11 pr-2 rounded-lg text-sm hover:text-white nav-text"
                            style="color: rgb(var(--text-muted));">Agent Workspace & Case Context</a></li>
                    <li><a href="#" class="block py-2 pl-11 pr-2 rounded-lg text-sm hover:text-white nav-text"
                            style="color: rgb(var(--text-muted));">Incident Management</a></li>
                    <li><a href="#" class="block py-2 pl-11 pr-2 rounded-lg text-sm hover:text-white nav-text"
                            style="color: rgb(var(--text-muted));">Root Cause Analysis & Postmortems</a></li>
                    <li><a href="#" class="block py-2 pl-11 pr-2 rounded-lg text-sm hover:text-white nav-text"
                            style="color: rgb(var(--text-muted));">Knowledge Base & Self-Service</a></li>
                    <li><a href="#" class="block py-2 pl-11 pr-2 rounded-lg text-sm hover:text-white nav-text"
                            style="color: rgb(var(--text-muted));">AI Support Assistant</a></li>
                    <li><a href="#" class="block py-2 pl-11 pr-2 rounded-lg text-sm hover:text-white nav-text"
                            style="color: rgb(var(--text-muted));">Operations Monitoring & Alerting</a></li>
                    <li><a href="#" class="block py-2 pl-11 pr-2 rounded-lg text-sm hover:text-white nav-text"
                            style="color: rgb(var(--text-muted));">Quality Assurance & Performance</a></li>
                </ul>
            </li>

            <li x-show="sidebarOpen" class="px-3 mt-6 mb-2" x-cloak>
                <span class="text-[10px] font-bold uppercase tracking-wider opacity-60 nav-text"
                    style="color: rgb(var(--text-muted));">AI & Automation Engine</span>
            </li>

            <li>
                <button @click="toggle('ai')"
                    class="w-full group flex items-center justify-between py-3 px-3 rounded-lg transition-all duration-200 ease-in-out hover:bg-white/5"
                    :style="activeDropdown === 'ai' ? 'background-color: rgb(var(--item-active-bg)); color: rgb(var(--text-main));' :
                        'color: rgb(var(--text-muted));'">
                    <div class="flex items-center overflow-hidden">
                        <svg class="w-5 h-5 flex-shrink-0 transition-colors"
                            :style="activeDropdown === 'ai' ? 'color: rgb(var(--brand-primary))' : ''"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                        <span x-show="sidebarOpen"
                            class="ml-3 text-sm font-medium tracking-wide nav-text transition-opacity duration-300"
                            x-cloak>
                            AI & Automation Engine
                        </span>
                    </div>
                    <svg x-show="sidebarOpen" :class="activeDropdown === 'ai' ? 'rotate-180' : ''"
                        class="w-4 h-4 transition-transform duration-200 flex-shrink-0" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
                <ul x-show="activeDropdown === 'ai' && sidebarOpen" x-collapse class="mt-1 space-y-1 px-1" x-cloak>
                    <li><a href="#" class="block py-2 pl-11 pr-2 rounded-lg text-sm hover:text-white nav-text"
                            style="color: rgb(var(--text-muted));">AI Decision Orchestrator</a></li>
                    <li><a href="#" class="block py-2 pl-11 pr-2 rounded-lg text-sm hover:text-white nav-text"
                            style="color: rgb(var(--text-muted));">Recommendation Engines</a></li>
                    <li><a href="#" class="block py-2 pl-11 pr-2 rounded-lg text-sm hover:text-white nav-text"
                            style="color: rgb(var(--text-muted));">Pricing & Revenue Intelligence</a></li>
                    <li><a href="#" class="block py-2 pl-11 pr-2 rounded-lg text-sm hover:text-white nav-text"
                            style="color: rgb(var(--text-muted));">Fraud, Risk & Abuse AI</a></li>
                    <li><a href="#" class="block py-2 pl-11 pr-2 rounded-lg text-sm hover:text-white nav-text"
                            style="color: rgb(var(--text-muted));">Operations & Failure Prediction</a></li>
                    <li><a href="#" class="block py-2 pl-11 pr-2 rounded-lg text-sm hover:text-white nav-text"
                            style="color: rgb(var(--text-muted));">Support & Dispute Intelligence</a></li>
                    <li><a href="#" class="block py-2 pl-11 pr-2 rounded-lg text-sm hover:text-white nav-text"
                            style="color: rgb(var(--text-muted));">Marketing & Growth AI</a></li>
                    <li><a href="#" class="block py-2 pl-11 pr-2 rounded-lg text-sm hover:text-white nav-text"
                            style="color: rgb(var(--text-muted));">Automation Rule Engine</a></li>
                    <li><a href="#" class="block py-2 pl-11 pr-2 rounded-lg text-sm hover:text-white nav-text"
                            style="color: rgb(var(--text-muted));">Approval & Human-in-the-Loop Flows</a></li>
                    <li><a href="#" class="block py-2 pl-11 pr-2 rounded-lg text-sm hover:text-white nav-text"
                            style="color: rgb(var(--text-muted));">Model Governance & Explainability</a></li>
                </ul>
            </li>

            <li x-show="sidebarOpen" class="px-3 mt-6 mb-2" x-cloak>
                <span class="text-[10px] font-bold uppercase tracking-wider opacity-60 nav-text"
                    style="color: rgb(var(--text-muted));">Integrations & Third Party Controls</span>
            </li>

            <li>
                <button @click="toggle('integrations')"
                    class="w-full group flex items-center justify-between py-3 px-3 rounded-lg transition-all duration-200 ease-in-out hover:bg-white/5"
                    :style="activeDropdown === 'integrations' ? 'background-color: rgb(var(--item-active-bg)); color: rgb(var(--text-main));' :
                        'color: rgb(var(--text-muted));'">
                    <div class="flex items-center overflow-hidden">
                        <svg class="w-5 h-5 flex-shrink-0 transition-colors"
                            :style="activeDropdown === 'integrations' ? 'color: rgb(var(--brand-primary))' : ''"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M11 4a2 2 0 114 0v1a1 1 0 001 1h3a1 1 0 011 1v3a1 1 0 01-1 1h-1a2 2 0 100 4h1a1 1 0 011 1v3a1 1 0 01-1 1h-3a1 1 0 01-1-1v-1a2 2 0 10-4 0v1a1 1 0 01-1 1H7a1 1 0 01-1-1v-3a1 1 0 00-1-1H4a2 2 0 110-4h1a1 1 0 001-1V7a1 1 0 011-1h3a1 1 0 001-1V4z" />
                        </svg>
                        <span x-show="sidebarOpen"
                            class="ml-3 text-sm font-medium tracking-wide nav-text transition-opacity duration-300"
                            x-cloak>
                            Third Party & Integration Managements
                        </span>
                    </div>
                    <svg x-show="sidebarOpen" :class="activeDropdown === 'integrations' ? 'rotate-180' : ''"
                        class="w-4 h-4 transition-transform duration-200 flex-shrink-0" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
                <ul x-show="activeDropdown === 'integrations' && sidebarOpen" x-collapse class="mt-1 space-y-1 px-1"
                    x-cloak>
                    <li><a href="#" class="block py-2 pl-11 pr-2 rounded-lg text-sm hover:text-white nav-text"
                            style="color: rgb(var(--text-muted));">Integration Registry & Catalog</a></li>
                    <li><a href="#" class="block py-2 pl-11 pr-2 rounded-lg text-sm hover:text-white nav-text"
                            style="color: rgb(var(--text-muted));">Credential & Secret Management</a></li>
                    <li><a href="#" class="block py-2 pl-11 pr-2 rounded-lg text-sm hover:text-white nav-text"
                            style="color: rgb(var(--text-muted));">Connection & Health Monitoring</a></li>
                    <li><a href="#" class="block py-2 pl-11 pr-2 rounded-lg text-sm hover:text-white nav-text"
                            style="color: rgb(var(--text-muted));">Routing & Failover Management</a></li>
                    <li><a href="#" class="block py-2 pl-11 pr-2 rounded-lg text-sm hover:text-white nav-text"
                            style="color: rgb(var(--text-muted));">Webhook & Event Management</a></li>
                    <li><a href="#" class="block py-2 pl-11 pr-2 rounded-lg text-sm hover:text-white nav-text"
                            style="color: rgb(var(--text-muted));">Data Contracts & Schema Governance</a></li>
                    <li><a href="#" class="block py-2 pl-11 pr-2 rounded-lg text-sm hover:text-white nav-text"
                            style="color: rgb(var(--text-muted));">Security & Risk Controls</a></li>
                    <li><a href="#" class="block py-2 pl-11 pr-2 rounded-lg text-sm hover:text-white nav-text"
                            style="color: rgb(var(--text-muted));">Compliance & Data Residency</a></li>
                    <li><a href="#" class="block py-2 pl-11 pr-2 rounded-lg text-sm hover:text-white nav-text"
                            style="color: rgb(var(--text-muted));">Change Management & Versioning</a></li>
                    <li><a href="#" class="block py-2 pl-11 pr-2 rounded-lg text-sm hover:text-white nav-text"
                            style="color: rgb(var(--text-muted));">Analytics, Cost & Vendor Performance</a></li>
                </ul>
            </li>

        </ul>
        <div class="h-10"></div>
    </nav>
</div>