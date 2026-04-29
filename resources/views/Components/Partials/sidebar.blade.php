<div x-data="{
    activeDropdown: '{{ request()->routeIs('cp.dashboard', 'cp.system-health', 'cp.regional', 'cp.maintenance')
        ? 'command_center'
        : (request()->routeIs('cp.security.*')
            ? 'security'
            : (request()->routeIs('cp.rbac.*')
                ? 'rbac'
                : (request()->routeIs('cp.configurations.*')
                    ? 'config'
                    : (request()->routeIs('cp.businesses.*')
                        ? 'businesses'
                        : (request()->routeIs('cp.kyc.*')
                            ? 'kyc'
                            : (request()->routeIs('cp.subscriptions.*')
                                ? 'subs'
                                : (request()->routeIs('cp.finance.*')
                                    ? 'finance'
                                    : (request()->routeIs('cp.payments.*')
                                        ? 'payments'
                                        : (request()->routeIs('cp.fraud-risk.*')
                                            ? 'fraud'
                                            : (request()->routeIs('cp.disputes.*')
                                                ? 'disputes'
                                                : (request()->routeIs('cp.audit-logs.*')
                                                    ? 'audit'
                                                    : (request()->routeIs('cp.analytics.*')
                                                        ? 'analytics'
                                                        : (request()->routeIs('cp.support.*')
                                                            ? 'support'
                                                            : (request()->routeIs('cp.ai-ops.*')
                                                                ? 'ai'
                                                                : (request()->routeIs('cp.integrations.*')
                                                                    ? 'integrations'
                                                                    : 'null'))))))))))))))) }}',
    toggle(key) {
        this.activeDropdown = (this.activeDropdown === key) ? null : key;
    }
}"
    class="fixed lg:relative top-0 left-0 h-full z-40 flex flex-col transition-all duration-300 ease-in-out border-r border-border-default bg-bg-secondary flex-shrink-0"
    x-bind:class="sidebarOpen ? 'w-[240px] translate-x-0' : '-translate-x-full lg:translate-x-0 lg:w-[64px]'"
    style="color: rgb(var(--text-primary));">

    <div
        class="flex items-center pl-4 h-16 flex-shrink-0 border-b border-border-default overflow-hidden whitespace-nowrap">
        <div
            class="flex items-center justify-center w-8 h-8 rounded border border-border-strong bg-bg-primary flex-shrink-0">
            <img src="{{ asset('favicon.png') }}" alt="S1" class="w-6 h-6">
        </div>
        <span x-show="sidebarOpen" x-transition.opacity.duration.300ms
            class="ml-3 text-body-lg font-semibold tracking-tight text-text-primary" x-cloak>
            SahorOne
        </span>
    </div>

    <nav class="flex-1 overflow-y-auto overflow-x-hidden py-4 custom-scrollbar px-3">
        <ul class="space-y-1 w-full">

            <li x-show="sidebarOpen" class="px-3 mt-2 mb-1 whitespace-nowrap" x-cloak>
                <span class="text-[10px] font-bold uppercase tracking-widest text-text-tertiary">Platform Control & Security</span>
            </li>

            <li>
                <button @click="toggle('command_center')"
                    class="w-full group flex items-center justify-between py-2 px-3 rounded-md transition-colors duration-150 outline-none whitespace-nowrap"
                    :class="activeDropdown === 'command_center' ? 'bg-bg-tertiary text-brand-primary' : 'text-text-secondary hover:bg-bg-tertiary hover:text-text-primary'">
                    <div class="flex items-center overflow-hidden">
                        <i data-lucide="activity" class="w-5 h-5 flex-shrink-0 transition-colors"
                            :class="activeDropdown === 'command_center' ? 'text-brand-primary' : 'text-text-tertiary group-hover:text-text-secondary'"></i>
                        <span x-show="sidebarOpen" class="ml-3 text-body-sm font-medium" x-cloak>Command Center</span>
                    </div>
                    <i data-lucide="chevron-down" x-show="sidebarOpen"
                        :class="activeDropdown === 'command_center' ? 'rotate-180' : ''"
                        class="w-4 h-4 transition-transform duration-200 flex-shrink-0 text-text-tertiary"></i>
                </button>
                <ul x-show="activeDropdown === 'command_center' && sidebarOpen" x-collapse
                    class="mt-1 space-y-0.5 px-2 whitespace-nowrap" x-cloak>
                    <li><a href="{{ route('cp.dashboard') }}" class="block py-1.5 pl-9 pr-3 rounded-md text-caption transition-colors {{ request()->routeIs('cp.dashboard') ? 'font-semibold text-brand-primary bg-brand-primary/5' : 'text-text-secondary hover:text-text-primary hover:bg-bg-tertiary' }}">Executive Dashboard</a></li>
                    <li><a href="{{ route('cp.system-health.index') }}" class="block py-1.5 pl-9 pr-3 rounded-md text-caption transition-colors {{ request()->routeIs('cp.system-health.*') ? 'font-semibold text-brand-primary bg-brand-primary/5' : 'text-text-secondary hover:text-text-primary hover:bg-bg-tertiary' }}">System Health</a></li>
                    <li><a href="{{ route('cp.regional.index') }}" class="block py-1.5 pl-9 pr-3 rounded-md text-caption transition-colors {{ request()->routeIs('cp.regional.*') ? 'font-semibold text-brand-primary bg-brand-primary/5' : 'text-text-secondary hover:text-text-primary hover:bg-bg-tertiary' }}">Regional Control</a></li>
                    <li><a href="{{ route('cp.maintenance.index') }}" class="block py-1.5 pl-9 pr-3 rounded-md text-caption transition-colors {{ request()->routeIs('cp.maintenance.*') ? 'font-semibold text-brand-primary bg-brand-primary/5' : 'text-text-secondary hover:text-text-primary hover:bg-bg-tertiary' }}">Maintenance & Emergency</a></li>
                </ul>
            </li>

            <li>
                <button @click="toggle('security')"
                    class="w-full group flex items-center justify-between py-2 px-3 rounded-md transition-colors duration-150 outline-none whitespace-nowrap"
                    :class="activeDropdown === 'security' ? 'bg-bg-tertiary text-brand-primary' : 'text-text-secondary hover:bg-bg-tertiary hover:text-text-primary'">
                    <div class="flex items-center overflow-hidden">
                        <i data-lucide="shield" class="w-5 h-5 flex-shrink-0 transition-colors"
                            :class="activeDropdown === 'security' ? 'text-brand-primary' : 'text-text-tertiary group-hover:text-text-secondary'"></i>
                        <span x-show="sidebarOpen" class="ml-3 text-body-sm font-medium" x-cloak>Security & Access Control</span>
                    </div>
                    <i data-lucide="chevron-down" x-show="sidebarOpen"
                        :class="activeDropdown === 'security' ? 'rotate-180' : ''"
                        class="w-4 h-4 transition-transform duration-200 flex-shrink-0 text-text-tertiary"></i>
                </button>
                <ul x-show="activeDropdown === 'security' && sidebarOpen" x-collapse
                    class="mt-1 space-y-0.5 px-2 whitespace-nowrap" x-cloak>
                    <li><a href="{{ route('cp.security.policies') }}" class="block py-1.5 pl-9 pr-3 rounded-md text-caption transition-colors {{ request()->routeIs('cp.security.policies') ? 'font-semibold text-brand-primary bg-brand-primary/5' : 'text-text-secondary hover:text-text-primary hover:bg-bg-tertiary' }}">Authentication</a></li>
                    <li><a href="{{ route('cp.security.sessions') }}" class="block py-1.5 pl-9 pr-3 rounded-md text-caption transition-colors {{ request()->routeIs('cp.security.sessions') ? 'font-semibold text-brand-primary bg-brand-primary/5' : 'text-text-secondary hover:text-text-primary hover:bg-bg-tertiary' }}">Session Management</a></li>
                    <li><a href="{{ route('cp.security.tokens') }}" class="block py-1.5 pl-9 pr-3 rounded-md text-caption transition-colors {{ request()->routeIs('cp.security.tokens') ? 'font-semibold text-brand-primary bg-brand-primary/5' : 'text-text-secondary hover:text-text-primary hover:bg-bg-tertiary' }}">Token Management</a></li>
                    <li><a href="{{ route('cp.security.devices') }}" class="block py-1.5 pl-9 pr-3 rounded-md text-caption transition-colors {{ request()->routeIs('cp.security.devices') ? 'font-semibold text-brand-primary bg-brand-primary/5' : 'text-text-secondary hover:text-text-primary hover:bg-bg-tertiary' }}">Device Trust</a></li>
                    <li><a href="{{ route('cp.security.network') }}" class="block py-1.5 pl-9 pr-3 rounded-md text-caption transition-colors {{ request()->routeIs('cp.security.network') ? 'font-semibold text-brand-primary bg-brand-primary/5' : 'text-text-secondary hover:text-text-primary hover:bg-bg-tertiary' }}">Network Security</a></li>
                    <li><a href="{{ route('cp.security.jit') }}" class="block py-1.5 pl-9 pr-3 rounded-md text-caption transition-colors {{ request()->routeIs('cp.security.jit') ? 'font-semibold text-brand-primary bg-brand-primary/5' : 'text-text-secondary hover:text-text-primary hover:bg-bg-tertiary' }}">Privileged Access</a></li>
                </ul>
            </li>

            <li>
                <button @click="toggle('rbac')"
                    class="w-full group flex items-center justify-between py-2 px-3 rounded-md transition-colors duration-150 outline-none whitespace-nowrap"
                    :class="activeDropdown === 'rbac' ? 'bg-bg-tertiary text-brand-primary' : 'text-text-secondary hover:bg-bg-tertiary hover:text-text-primary'">
                    <div class="flex items-center overflow-hidden">
                        <i data-lucide="users" class="w-5 h-5 flex-shrink-0 transition-colors"
                            :class="activeDropdown === 'rbac' ? 'text-brand-primary' : 'text-text-tertiary group-hover:text-text-secondary'"></i>
                        <span x-show="sidebarOpen" class="ml-3 text-body-sm font-medium" x-cloak>Roles & Permissions (RBAC)</span>
                    </div>
                    <i data-lucide="chevron-down" x-show="sidebarOpen"
                        :class="activeDropdown === 'rbac' ? 'rotate-180' : ''"
                        class="w-4 h-4 transition-transform duration-200 flex-shrink-0 text-text-tertiary"></i>
                </button>
                <ul x-show="activeDropdown === 'rbac' && sidebarOpen" x-collapse
                    class="mt-1 space-y-0.5 px-2 whitespace-nowrap" x-cloak>
                    <li><a href="{{ route('cp.rbac.roles.index') }}" class="block py-1.5 pl-9 pr-3 rounded-md text-caption transition-colors {{ request()->routeIs('cp.rbac.roles.*') ? 'font-semibold text-brand-primary bg-brand-primary/5' : 'text-text-secondary hover:text-text-primary hover:bg-bg-tertiary' }}">Role Lifecycle</a></li>
                    <li><a href="{{ route('cp.rbac.permissions.index') }}" class="block py-1.5 pl-9 pr-3 rounded-md text-caption transition-colors {{ request()->routeIs('cp.rbac.permissions.index') ? 'font-semibold text-brand-primary bg-brand-primary/5' : 'text-text-secondary hover:text-text-primary hover:bg-bg-tertiary' }}">Permission Catalog</a></li>
                    <li><a href="{{ route('cp.rbac.matrix') }}" class="block py-1.5 pl-9 pr-3 rounded-md text-caption transition-colors {{ request()->routeIs('cp.rbac.matrix') ? 'font-semibold text-brand-primary bg-brand-primary/5' : 'text-text-secondary hover:text-text-primary hover:bg-bg-tertiary' }}">Access Matrix</a></li>
                    <li><a href="{{ route('cp.rbac.governance') }}" class="block py-1.5 pl-9 pr-3 rounded-md text-caption transition-colors {{ request()->routeIs('cp.rbac.governance') ? 'font-semibold text-brand-primary bg-brand-primary/5' : 'text-text-secondary hover:text-text-primary hover:bg-bg-tertiary' }}">Audit & Governance</a></li>
                </ul>
            </li>

            <li>
                <button @click="toggle('config')"
                    class="w-full group flex items-center justify-between py-2 px-3 rounded-md transition-colors duration-150 outline-none whitespace-nowrap"
                    :class="activeDropdown === 'config' ? 'bg-bg-tertiary text-brand-primary' : 'text-text-secondary hover:bg-bg-tertiary hover:text-text-primary'">
                    <div class="flex items-center overflow-hidden">
                        <i data-lucide="sliders" class="w-5 h-5 flex-shrink-0 transition-colors"
                            :class="activeDropdown === 'config' ? 'text-brand-primary' : 'text-text-tertiary group-hover:text-text-secondary'"></i>
                        <span x-show="sidebarOpen" class="ml-3 text-body-sm font-medium" x-cloak>System Configuration</span>
                    </div>
                    <i data-lucide="chevron-down" x-show="sidebarOpen"
                        :class="activeDropdown === 'config' ? 'rotate-180' : ''"
                        class="w-4 h-4 transition-transform duration-200 flex-shrink-0 text-text-tertiary"></i>
                </button>
                <ul x-show="activeDropdown === 'config' && sidebarOpen" x-collapse
                    class="mt-1 space-y-0.5 px-2 whitespace-nowrap" x-cloak>
                    <li><a href="{{ route('cp.configuration.global') }}" class="block py-1.5 pl-9 pr-3 rounded-md text-caption transition-colors {{ request()->routeIs('cp.configuration.global') ? 'font-semibold text-brand-primary bg-brand-primary/5' : 'text-text-secondary hover:text-text-primary hover:bg-bg-tertiary' }}">Global Settings</a></li>
                    <li><a href="{{ route('cp.configuration.flags') }}" class="block py-1.5 pl-9 pr-3 rounded-md text-caption transition-colors {{ request()->routeIs('cp.configuration.flags') ? 'font-semibold text-brand-primary bg-brand-primary/5' : 'text-text-secondary hover:text-text-primary hover:bg-bg-tertiary' }}">Feature Flags</a></li>
                    <li><a href="{{ route('cp.configuration.environment') }}" class="block py-1.5 pl-9 pr-3 rounded-md text-caption transition-colors text-text-secondary hover:text-text-primary hover:bg-bg-tertiary">Environment Configuration</a></li>
                    <li><a href="{{ route('cp.configuration.localization') }}" class="block py-1.5 pl-9 pr-3 rounded-md text-caption transition-colors text-text-secondary hover:text-text-primary hover:bg-bg-tertiary">Localization</a></li>
                    <li><a href="{{ route('cp.configuration.geo') }}" class="block py-1.5 pl-9 pr-3 rounded-md text-caption transition-colors text-text-secondary hover:text-text-primary hover:bg-bg-tertiary">Geo Configuration</a></li>
                    <li><a href="{{ route('cp.configuration.rate_limits') }}" class="block py-1.5 pl-9 pr-3 rounded-md text-caption transition-colors text-text-secondary hover:text-text-primary hover:bg-bg-tertiary">Rate Limits</a></li>
                    <li><a href="{{ route('cp.configuration.versioning') }}" class="block py-1.5 pl-9 pr-3 rounded-md text-caption transition-colors text-text-secondary hover:text-text-primary hover:bg-bg-tertiary">Versioning & Rollback</a></li>
                    <li><a href="{{ route('cp.configuration.ai_impact') }}" class="block py-1.5 pl-9 pr-3 rounded-md text-caption transition-colors text-text-secondary hover:text-text-primary hover:bg-bg-tertiary">AI Impact Analysis</a></li>
                </ul>
            </li>

            <li x-show="sidebarOpen" class="px-3 mt-6 mb-1 whitespace-nowrap" x-cloak>
                <span class="text-[10px] font-bold uppercase tracking-widest text-text-tertiary">Business Ecosystem</span>
            </li>

            <li>
                <button @click="toggle('businesses')"
                    class="w-full group flex items-center justify-between py-2 px-3 rounded-md transition-colors duration-150 outline-none whitespace-nowrap"
                    :class="activeDropdown === 'businesses' ? 'bg-bg-tertiary text-brand-primary' : 'text-text-secondary hover:bg-bg-tertiary hover:text-text-primary'">
                    <div class="flex items-center overflow-hidden">
                        <i data-lucide="building-2" class="w-5 h-5 flex-shrink-0 transition-colors"
                            :class="activeDropdown === 'businesses' ? 'text-brand-primary' : 'text-text-tertiary group-hover:text-text-secondary'"></i>
                        <span x-show="sidebarOpen" class="ml-3 text-body-sm font-medium" x-cloak>Business Accounts</span>
                    </div>
                    <i data-lucide="chevron-down" x-show="sidebarOpen"
                        :class="activeDropdown === 'businesses' ? 'rotate-180' : ''"
                        class="w-4 h-4 transition-transform duration-200 flex-shrink-0 text-text-tertiary"></i>
                </button>
                <ul x-show="activeDropdown === 'businesses' && sidebarOpen" x-collapse
                    class="mt-1 space-y-0.5 px-2 whitespace-nowrap" x-cloak>
                    <li><a href="{{ route('cp.businesses.index') }}" class="block py-1.5 pl-9 pr-3 rounded-md text-caption transition-colors {{ request()->routeIs('cp.businesses.index') ? 'font-semibold text-brand-primary bg-brand-primary/5' : 'text-text-secondary hover:text-text-primary hover:bg-bg-tertiary' }}">Business Registry</a></li>
                    <li><a href="{{ route('cp.businesses.lifecycle') }}" class="block py-1.5 pl-9 pr-3 rounded-md text-caption transition-colors {{ request()->routeIs('cp.businesses.lifecycle') ? 'font-semibold text-brand-primary bg-brand-primary/5' : 'text-text-secondary hover:text-text-primary hover:bg-bg-tertiary' }}">Business Lifecycle</a></li>
                    <li><a href="{{ route('cp.businesses.intelligence') }}" class="block py-1.5 pl-9 pr-3 rounded-md text-caption transition-colors {{ request()->routeIs('cp.businesses.intelligence') ? 'font-semibold text-brand-primary bg-brand-primary/5' : 'text-text-secondary hover:text-text-primary hover:bg-bg-tertiary' }}">Business Intelligence</a></li>
                </ul>
            </li>

            <li>
                <button @click="toggle('kyc')"
                    class="w-full group flex items-center justify-between py-2 px-3 rounded-md transition-colors duration-150 outline-none whitespace-nowrap"
                    :class="activeDropdown === 'kyc' ? 'bg-bg-tertiary text-brand-primary' : 'text-text-secondary hover:bg-bg-tertiary hover:text-text-primary'">
                    <div class="flex items-center overflow-hidden">
                        <i data-lucide="file-check-2" class="w-5 h-5 flex-shrink-0 transition-colors"
                            :class="activeDropdown === 'kyc' ? 'text-brand-primary' : 'text-text-tertiary group-hover:text-text-secondary'"></i>
                        <span x-show="sidebarOpen" class="ml-3 text-body-sm font-medium" x-cloak>Business KYC & Verification</span>
                    </div>
                    <i data-lucide="chevron-down" x-show="sidebarOpen"
                        :class="activeDropdown === 'kyc' ? 'rotate-180' : ''"
                        class="w-4 h-4 transition-transform duration-200 flex-shrink-0 text-text-tertiary"></i>
                </button>
                <ul x-show="activeDropdown === 'kyc' && sidebarOpen" x-collapse
                    class="mt-1 space-y-0.5 px-2 whitespace-nowrap" x-cloak>
                    <li><a href="{{ route('cp.kyc.document_management') }}" class="block py-1.5 pl-9 pr-3 rounded-md text-caption transition-colors {{ request()->routeIs('cp.kyc.document_management') ? 'font-semibold text-brand-primary bg-brand-primary/5' : 'text-text-secondary hover:text-text-primary hover:bg-bg-tertiary' }}">Document Management</a></li>
                    <li><a href="{{ route('cp.kyc.verification') }}" class="block py-1.5 pl-9 pr-3 rounded-md text-caption transition-colors {{ request()->routeIs('cp.kyc.verification') ? 'font-semibold text-brand-primary bg-brand-primary/5' : 'text-text-secondary hover:text-text-primary hover:bg-bg-tertiary' }}">Verification Pipeline</a></li>
                    <li><a href="{{ route('cp.kyc.governance') }}" class="block py-1.5 pl-9 pr-3 rounded-md text-caption transition-colors {{ request()->routeIs('cp.kyc.governance') ? 'font-semibold text-brand-primary bg-brand-primary/5' : 'text-text-secondary hover:text-text-primary hover:bg-bg-tertiary' }}">Compliance & Governance</a></li>
                </ul>
            </li>

            <li x-show="sidebarOpen" class="px-3 mt-6 mb-1 whitespace-nowrap" x-cloak>
                <span class="text-[10px] font-bold uppercase tracking-widest text-text-tertiary">Finance & Monetization</span>
            </li>

            <li>
                <button @click="toggle('subs')"
                    class="w-full group flex items-center justify-between py-2 px-3 rounded-md transition-colors duration-150 outline-none whitespace-nowrap"
                    :class="activeDropdown === 'subs' ? 'bg-bg-tertiary text-brand-primary' : 'text-text-secondary hover:bg-bg-tertiary hover:text-text-primary'">
                    <div class="flex items-center overflow-hidden">
                        <i data-lucide="credit-card" class="w-5 h-5 flex-shrink-0 transition-colors"
                            :class="activeDropdown === 'subs' ? 'text-brand-primary' : 'text-text-tertiary group-hover:text-text-secondary'"></i>
                        <span x-show="sidebarOpen" class="ml-3 text-body-sm font-medium" x-cloak>Subscriptions & Entitlements</span>
                    </div>
                    <i data-lucide="chevron-down" x-show="sidebarOpen"
                        :class="activeDropdown === 'subs' ? 'rotate-180' : ''"
                        class="w-4 h-4 transition-transform duration-200 flex-shrink-0 text-text-tertiary"></i>
                </button>
                <ul x-show="activeDropdown === 'subs' && sidebarOpen" x-collapse
                    class="mt-1 space-y-0.5 px-2 whitespace-nowrap" x-cloak>
                     <li><a href="{{ route('cp.billing.plans') }}" class="block py-1.5 pl-9 pr-3 rounded-md text-caption transition-colors {{ request()->routeIs('cp.billing.plans') ? 'font-semibold text-brand-primary bg-brand-primary/5' : 'text-text-secondary hover:text-text-primary hover:bg-bg-tertiary' }}">Plan Management</a></li>
                     <li><a href="{{ route('cp.billing.entitlements') }}" class="block py-1.5 pl-9 pr-3 rounded-md text-caption transition-colors {{ request()->routeIs('cp.billing.entitlements') ? 'font-semibold text-brand-primary bg-brand-primary/5' : 'text-text-secondary hover:text-text-primary hover:bg-bg-tertiary' }}">Entitlement Keys</a></li>
                     <li><a href="{{ route('cp.billing.lifecycle') }}" class="block py-1.5 pl-9 pr-3 rounded-md text-caption transition-colors {{ request()->routeIs('cp.billing.lifecycle') ? 'font-semibold text-brand-primary bg-brand-primary/5' : 'text-text-secondary hover:text-text-primary hover:bg-bg-tertiary' }}">Subscription Lifecycle</a></li>
                     <li><a href="{{ route('cp.billing.enforcement') }}" class="block py-1.5 pl-9 pr-3 rounded-md text-caption transition-colors {{ request()->routeIs('cp.billing.enforcement') ? 'font-semibold text-brand-primary bg-brand-primary/5' : 'text-text-secondary hover:text-text-primary hover:bg-bg-tertiary' }}">Enforcement Engine</a></li>
                     <li><a href="{{ route('cp.billing.overrides') }}" class="block py-1.5 pl-9 pr-3 rounded-md text-caption transition-colors {{ request()->routeIs('cp.billing.overrides') ? 'font-semibold text-brand-primary bg-brand-primary/5' : 'text-text-secondary hover:text-text-primary hover:bg-bg-tertiary' }}">Admin Overrides</a></li>
                </ul>
            </li>

            <li>
                <button @click="toggle('finance')"
                    class="w-full group flex items-center justify-between py-2 px-3 rounded-md transition-colors duration-150 outline-none whitespace-nowrap"
                    :class="activeDropdown === 'finance' ? 'bg-bg-tertiary text-brand-primary' : 'text-text-secondary hover:bg-bg-tertiary hover:text-text-primary'">
                    <div class="flex items-center overflow-hidden">
                        <i data-lucide="landmark" class="w-5 h-5 flex-shrink-0 transition-colors"
                            :class="activeDropdown === 'finance' ? 'text-brand-primary' : 'text-text-tertiary group-hover:text-text-secondary'"></i>
                        <span x-show="sidebarOpen" class="ml-3 text-body-sm font-medium" x-cloak>Finance & Platform Revenue</span>
                    </div>
                    <i data-lucide="chevron-down" x-show="sidebarOpen"
                        :class="activeDropdown === 'finance' ? 'rotate-180' : ''"
                        class="w-4 h-4 transition-transform duration-200 flex-shrink-0 text-text-tertiary"></i>
                </button>
                <ul x-show="activeDropdown === 'finance' && sidebarOpen" x-collapse
                    class="mt-1 space-y-0.5 px-2 whitespace-nowrap" x-cloak>
                    <li><a href="{{ route('cp.finance.ledger') }}" class="block py-1.5 pl-9 pr-3 rounded-md text-caption transition-colors text-text-secondary hover:text-text-primary hover:bg-bg-tertiary">Revenue Ledger</a></li>
                    <li><a href="{{ route('cp.finance.wallets') }}" class="block py-1.5 pl-9 pr-3 rounded-md text-caption transition-colors text-text-secondary hover:text-text-primary hover:bg-bg-tertiary">Platform Wallets</a></li>
                    <li><a href="{{ route('cp.finance.commissions') }}" class="block py-1.5 pl-9 pr-3 rounded-md text-caption transition-colors text-text-secondary hover:text-text-primary hover:bg-bg-tertiary">Commissions & Tax</a></li>
                    <li><a href="{{ route('cp.finance.payouts') }}" class="block py-1.5 pl-9 pr-3 rounded-md text-caption transition-colors text-text-secondary hover:text-text-primary hover:bg-bg-tertiary">Platform Payouts</a></li>
                    <li><a href="{{ route('cp.finance.refunds') }}" class="block py-1.5 pl-9 pr-3 rounded-md text-caption transition-colors text-text-secondary hover:text-text-primary hover:bg-bg-tertiary">Refunds & Adjustments</a></li>
                </ul>
            </li>

            <li>
                <button @click="toggle('payments')"
                    class="w-full group flex items-center justify-between py-2 px-3 rounded-md transition-colors duration-150 outline-none whitespace-nowrap"
                    :class="activeDropdown === 'payments' ? 'bg-bg-tertiary text-brand-primary' : 'text-text-secondary hover:bg-bg-tertiary hover:text-text-primary'">
                    <div class="flex items-center overflow-hidden">
                        <i data-lucide="wallet" class="w-5 h-5 flex-shrink-0 transition-colors"
                            :class="activeDropdown === 'payments' ? 'text-brand-primary' : 'text-text-tertiary group-hover:text-text-secondary'"></i>
                        <span x-show="sidebarOpen" class="ml-3 text-body-sm font-medium" x-cloak>Payment Infrastructure</span>
                    </div>
                    <i data-lucide="chevron-down" x-show="sidebarOpen"
                        :class="activeDropdown === 'payments' ? 'rotate-180' : ''"
                        class="w-4 h-4 transition-transform duration-200 flex-shrink-0 text-text-tertiary"></i>
                </button>
                <ul x-show="activeDropdown === 'payments' && sidebarOpen" x-collapse
                    class="mt-1 space-y-0.5 px-2 whitespace-nowrap" x-cloak>
                    <li><a href="#" class="block py-1.5 pl-9 pr-3 rounded-md text-caption transition-colors text-text-secondary hover:text-text-primary hover:bg-bg-tertiary">Stripe Connect Configuration</a></li>
                    <li><a href="#" class="block py-1.5 pl-9 pr-3 rounded-md text-caption transition-colors text-text-secondary hover:text-text-primary hover:bg-bg-tertiary">Transaction Monitoring</a></li>
                    <li><a href="#" class="block py-1.5 pl-9 pr-3 rounded-md text-caption transition-colors text-text-secondary hover:text-text-primary hover:bg-bg-tertiary">Webhook Management</a></li>
                    <li><a href="#" class="block py-1.5 pl-9 pr-3 rounded-md text-caption transition-colors text-text-secondary hover:text-text-primary hover:bg-bg-tertiary">Key Management</a></li>
                    <li><a href="#" class="block py-1.5 pl-9 pr-3 rounded-md text-caption transition-colors text-text-secondary hover:text-text-primary hover:bg-bg-tertiary">Failure & Fallback</a></li>
                    <li><a href="#" class="block py-1.5 pl-9 pr-3 rounded-md text-caption transition-colors text-text-secondary hover:text-text-primary hover:bg-bg-tertiary">Instant Payouts</a></li>
                </ul>
            </li>

            <li x-show="sidebarOpen" class="px-3 mt-6 mb-1 whitespace-nowrap" x-cloak>
                <span class="text-[10px] font-bold uppercase tracking-widest text-text-tertiary">Risk, Audit & Compliance</span>
            </li>

            <li>
                <button @click="toggle('fraud')"
                    class="w-full group flex items-center justify-between py-2 px-3 rounded-md transition-colors duration-150 outline-none whitespace-nowrap"
                    :class="activeDropdown === 'fraud' ? 'bg-bg-tertiary text-brand-primary' : 'text-text-secondary hover:bg-bg-tertiary hover:text-text-primary'">
                    <div class="flex items-center overflow-hidden">
                        <i data-lucide="alert-triangle" class="w-5 h-5 flex-shrink-0 transition-colors"
                            :class="activeDropdown === 'fraud' ? 'text-brand-primary' : 'text-text-tertiary group-hover:text-text-secondary'"></i>
                        <span x-show="sidebarOpen" class="ml-3 text-body-sm font-medium" x-cloak>Fraud, Risk & Abuse</span>
                    </div>
                    <i data-lucide="chevron-down" x-show="sidebarOpen"
                        :class="activeDropdown === 'fraud' ? 'rotate-180' : ''"
                        class="w-4 h-4 transition-transform duration-200 flex-shrink-0 text-text-tertiary"></i>
                </button>
                <ul x-show="activeDropdown === 'fraud' && sidebarOpen" x-collapse
                    class="mt-1 space-y-0.5 px-2 whitespace-nowrap" x-cloak>
                    <li><a href="{{ route('cp.fraud-risk.scoring') }}" class="block py-1.5 pl-9 pr-3 rounded-md text-caption transition-colors {{ request()->routeIs('cp.fraud-risk.scoring') ? 'font-semibold text-brand-primary bg-brand-primary/5' : 'text-text-secondary hover:text-text-primary hover:bg-bg-tertiary' }}">Risk Scoring</a></li>
                    <li><a href="#" class="block py-1.5 pl-9 pr-3 rounded-md text-caption transition-colors text-text-secondary hover:text-text-primary hover:bg-bg-tertiary">Business Account Risk</a></li>
                    <li><a href="#" class="block py-1.5 pl-9 pr-3 rounded-md text-caption transition-colors text-text-secondary hover:text-text-primary hover:bg-bg-tertiary">Transaction Fraud</a></li>
                    <li><a href="{{ route('cp.fraud-risk.enforcement') }}" class="block py-1.5 pl-9 pr-3 rounded-md text-caption transition-colors {{ request()->routeIs('cp.fraud-risk.enforcement') ? 'font-semibold text-brand-primary bg-brand-primary/5' : 'text-text-secondary hover:text-text-primary hover:bg-bg-tertiary' }}">Enforcement</a></li>
                    <li><a href="#" class="block py-1.5 pl-9 pr-3 rounded-md text-caption transition-colors text-text-secondary hover:text-text-primary hover:bg-bg-tertiary">Manual Overrides</a></li>
                </ul>
            </li>

            <li>
                <button @click="toggle('disputes')"
                    class="w-full group flex items-center justify-between py-2 px-3 rounded-md transition-colors duration-150 outline-none whitespace-nowrap"
                    :class="activeDropdown === 'disputes' ? 'bg-bg-tertiary text-brand-primary' : 'text-text-secondary hover:bg-bg-tertiary hover:text-text-primary'">
                    <div class="flex items-center overflow-hidden">
                        <i data-lucide="gavel" class="w-5 h-5 flex-shrink-0 transition-colors"
                            :class="activeDropdown === 'disputes' ? 'text-brand-primary' : 'text-text-tertiary group-hover:text-text-secondary'"></i>
                        <span x-show="sidebarOpen" class="ml-3 text-body-sm font-medium" x-cloak>Platform Disputes</span>
                    </div>
                    <i data-lucide="chevron-down" x-show="sidebarOpen"
                        :class="activeDropdown === 'disputes' ? 'rotate-180' : ''"
                        class="w-4 h-4 transition-transform duration-200 flex-shrink-0 text-text-tertiary"></i>
                </button>
                <ul x-show="activeDropdown === 'disputes' && sidebarOpen" x-collapse
                    class="mt-1 space-y-0.5 px-2 whitespace-nowrap" x-cloak>
                    <li><a href="#" class="block py-1.5 pl-9 pr-3 rounded-md text-caption transition-colors text-text-secondary hover:text-text-primary hover:bg-bg-tertiary">Dispute Types</a></li>
                    <li><a href="#" class="block py-1.5 pl-9 pr-3 rounded-md text-caption transition-colors text-text-secondary hover:text-text-primary hover:bg-bg-tertiary">Dispute Workflow</a></li>
                    <li><a href="#" class="block py-1.5 pl-9 pr-3 rounded-md text-caption transition-colors text-text-secondary hover:text-text-primary hover:bg-bg-tertiary">Evidence Management</a></li>
                    <li><a href="#" class="block py-1.5 pl-9 pr-3 rounded-md text-caption transition-colors text-text-secondary hover:text-text-primary hover:bg-bg-tertiary">AI-Assisted Triage</a></li>
                    <li><a href="#" class="block py-1.5 pl-9 pr-3 rounded-md text-caption transition-colors text-text-secondary hover:text-text-primary hover:bg-bg-tertiary">Legal Escalation</a></li>
                </ul>
            </li>

            <li>
                <button @click="toggle('audit')"
                    class="w-full group flex items-center justify-between py-2 px-3 rounded-md transition-colors duration-150 outline-none whitespace-nowrap"
                    :class="activeDropdown === 'audit' ? 'bg-bg-tertiary text-brand-primary' : 'text-text-secondary hover:bg-bg-tertiary hover:text-text-primary'">
                    <div class="flex items-center overflow-hidden">
                        <i data-lucide="clipboard-check" class="w-5 h-5 flex-shrink-0 transition-colors"
                            :class="activeDropdown === 'audit' ? 'text-brand-primary' : 'text-text-tertiary group-hover:text-text-secondary'"></i>
                        <span x-show="sidebarOpen" class="ml-3 text-body-sm font-medium" x-cloak>Audit, Compliance & Regulatory</span>
                    </div>
                    <i data-lucide="chevron-down" x-show="sidebarOpen"
                        :class="activeDropdown === 'audit' ? 'rotate-180' : ''"
                        class="w-4 h-4 transition-transform duration-200 flex-shrink-0 text-text-tertiary"></i>
                </button>
                <ul x-show="activeDropdown === 'audit' && sidebarOpen" x-collapse
                    class="mt-1 space-y-0.5 px-2 whitespace-nowrap" x-cloak>
                    <li><a href="{{ route('cp.audit-logs.actions') }}" class="block py-1.5 pl-9 pr-3 rounded-md text-caption transition-colors {{ request()->routeIs('cp.audit-logs.actions') ? 'font-semibold text-brand-primary bg-brand-primary/5' : 'text-text-secondary hover:text-text-primary hover:bg-bg-tertiary' }}">Admin Action Audit</a></li>
                    <li><a href="#" class="block py-1.5 pl-9 pr-3 rounded-md text-caption transition-colors text-text-secondary hover:text-text-primary hover:bg-bg-tertiary">Financial Audit</a></li>
                    <li><a href="#" class="block py-1.5 pl-9 pr-3 rounded-md text-caption transition-colors text-text-secondary hover:text-text-primary hover:bg-bg-tertiary">Security Audit</a></li>
                    <li><a href="#" class="block py-1.5 pl-9 pr-3 rounded-md text-caption transition-colors text-text-secondary hover:text-text-primary hover:bg-bg-tertiary">Data Access Audit</a></li>
                    <li><a href="#" class="block py-1.5 pl-9 pr-3 rounded-md text-caption transition-colors text-text-secondary hover:text-text-primary hover:bg-bg-tertiary">Regulatory Reporting</a></li>
                    <li><a href="#" class="block py-1.5 pl-9 pr-3 rounded-md text-caption transition-colors text-text-secondary hover:text-text-primary hover:bg-bg-tertiary">Data Retention</a></li>
                    <li><a href="{{ route('cp.audit-logs.forensics') }}" class="block py-1.5 pl-9 pr-3 rounded-md text-caption transition-colors {{ request()->routeIs('cp.audit-logs.forensics') ? 'font-semibold text-brand-primary bg-brand-primary/5' : 'text-text-secondary hover:text-text-primary hover:bg-bg-tertiary' }}">Forensic Replay</a></li>
                </ul>
            </li>

            <li x-show="sidebarOpen" class="px-3 mt-6 mb-1 whitespace-nowrap" x-cloak>
                <span class="text-[10px] font-bold uppercase tracking-widest text-text-tertiary">Operations & Intelligence</span>
            </li>

            <li>
                <button @click="toggle('analytics')"
                    class="w-full group flex items-center justify-between py-2 px-3 rounded-md transition-colors duration-150 outline-none whitespace-nowrap"
                    :class="activeDropdown === 'analytics' ? 'bg-bg-tertiary text-brand-primary' : 'text-text-secondary hover:bg-bg-tertiary hover:text-text-primary'">
                    <div class="flex items-center overflow-hidden">
                        <i data-lucide="pie-chart" class="w-5 h-5 flex-shrink-0 transition-colors"
                            :class="activeDropdown === 'analytics' ? 'text-brand-primary' : 'text-text-tertiary group-hover:text-text-secondary'"></i>
                        <span x-show="sidebarOpen" class="ml-3 text-body-sm font-medium" x-cloak>Platform Analytics & Reporting</span>
                    </div>
                    <i data-lucide="chevron-down" x-show="sidebarOpen"
                        :class="activeDropdown === 'analytics' ? 'rotate-180' : ''"
                        class="w-4 h-4 transition-transform duration-200 flex-shrink-0 text-text-tertiary"></i>
                </button>
                <ul x-show="activeDropdown === 'analytics' && sidebarOpen" x-collapse
                    class="mt-1 space-y-0.5 px-2 whitespace-nowrap" x-cloak>
                    <li><a href="#" class="block py-1.5 pl-9 pr-3 rounded-md text-caption transition-colors text-text-secondary hover:text-text-primary hover:bg-bg-tertiary">Executive Reports</a></li>
                    <li><a href="#" class="block py-1.5 pl-9 pr-3 rounded-md text-caption transition-colors text-text-secondary hover:text-text-primary hover:bg-bg-tertiary">Financial Reports</a></li>
                    <li><a href="#" class="block py-1.5 pl-9 pr-3 rounded-md text-caption transition-colors text-text-secondary hover:text-text-primary hover:bg-bg-tertiary">Operational Reports</a></li>
                    <li><a href="#" class="block py-1.5 pl-9 pr-3 rounded-md text-caption transition-colors text-text-secondary hover:text-text-primary hover:bg-bg-tertiary">Custom Report Builder</a></li>
                    <li><a href="#" class="block py-1.5 pl-9 pr-3 rounded-md text-caption transition-colors text-text-secondary hover:text-text-primary hover:bg-bg-tertiary">Scheduled Reports</a></li>
                </ul>
            </li>

            <li>
                <button @click="toggle('support')"
                    class="w-full group flex items-center justify-between py-2 px-3 rounded-md transition-colors duration-150 outline-none whitespace-nowrap"
                    :class="activeDropdown === 'support' ? 'bg-bg-tertiary text-brand-primary' : 'text-text-secondary hover:bg-bg-tertiary hover:text-text-primary'">
                    <div class="flex items-center overflow-hidden">
                        <i data-lucide="life-buoy" class="w-5 h-5 flex-shrink-0 transition-colors"
                            :class="activeDropdown === 'support' ? 'text-brand-primary' : 'text-text-tertiary group-hover:text-text-secondary'"></i>
                        <span x-show="sidebarOpen" class="ml-3 text-body-sm font-medium" x-cloak>Support & Operations</span>
                    </div>
                    <i data-lucide="chevron-down" x-show="sidebarOpen"
                        :class="activeDropdown === 'support' ? 'rotate-180' : ''"
                        class="w-4 h-4 transition-transform duration-200 flex-shrink-0 text-text-tertiary"></i>
                </button>
                <ul x-show="activeDropdown === 'support' && sidebarOpen" x-collapse
                    class="mt-1 space-y-0.5 px-2 whitespace-nowrap" x-cloak>
                    <li><a href="#" class="block py-1.5 pl-9 pr-3 rounded-md text-caption transition-colors text-text-secondary hover:text-text-primary hover:bg-bg-tertiary">Ticket System</a></li>
                    <li><a href="#" class="block py-1.5 pl-9 pr-3 rounded-md text-caption transition-colors text-text-secondary hover:text-text-primary hover:bg-bg-tertiary">SLA Management</a></li>
                    <li><a href="#" class="block py-1.5 pl-9 pr-3 rounded-md text-caption transition-colors text-text-secondary hover:text-text-primary hover:bg-bg-tertiary">Agent Workspace</a></li>
                    <li><a href="#" class="block py-1.5 pl-9 pr-3 rounded-md text-caption transition-colors text-text-secondary hover:text-text-primary hover:bg-bg-tertiary">Incident Management</a></li>
                    <li><a href="#" class="block py-1.5 pl-9 pr-3 rounded-md text-caption transition-colors text-text-secondary hover:text-text-primary hover:bg-bg-tertiary">Knowledge Base</a></li>
                    <li><a href="#" class="block py-1.5 pl-9 pr-3 rounded-md text-caption transition-colors text-text-secondary hover:text-text-primary hover:bg-bg-tertiary">AI Support Assistant</a></li>
                </ul>
            </li>

            <li>
                <button @click="toggle('ai')"
                    class="w-full group flex items-center justify-between py-2 px-3 rounded-md transition-colors duration-150 outline-none whitespace-nowrap"
                    :class="activeDropdown === 'ai' ? 'bg-bg-tertiary text-brand-primary' : 'text-text-secondary hover:bg-bg-tertiary hover:text-text-primary'">
                    <div class="flex items-center overflow-hidden">
                        <i data-lucide="bot" class="w-5 h-5 flex-shrink-0 transition-colors"
                            :class="activeDropdown === 'ai' ? 'text-brand-primary' : 'text-text-tertiary group-hover:text-text-secondary'"></i>
                        <span x-show="sidebarOpen" class="ml-3 text-body-sm font-medium" x-cloak>AI & Automation</span>
                    </div>
                    <i data-lucide="chevron-down" x-show="sidebarOpen"
                        :class="activeDropdown === 'ai' ? 'rotate-180' : ''"
                        class="w-4 h-4 transition-transform duration-200 flex-shrink-0 text-text-tertiary"></i>
                </button>
                <ul x-show="activeDropdown === 'ai' && sidebarOpen" x-collapse
                    class="mt-1 space-y-0.5 px-2 whitespace-nowrap" x-cloak>
                    <li><a href="#" class="block py-1.5 pl-9 pr-3 rounded-md text-caption transition-colors text-text-secondary hover:text-text-primary hover:bg-bg-tertiary">Decision Orchestrator</a></li>
                    <li><a href="#" class="block py-1.5 pl-9 pr-3 rounded-md text-caption transition-colors text-text-secondary hover:text-text-primary hover:bg-bg-tertiary">Business Intelligence</a></li>
                    <li><a href="#" class="block py-1.5 pl-9 pr-3 rounded-md text-caption transition-colors text-text-secondary hover:text-text-primary hover:bg-bg-tertiary">Fraud AI</a></li>
                    <li><a href="#" class="block py-1.5 pl-9 pr-3 rounded-md text-caption transition-colors text-text-secondary hover:text-text-primary hover:bg-bg-tertiary">Operations AI</a></li>
                    <li><a href="#" class="block py-1.5 pl-9 pr-3 rounded-md text-caption transition-colors text-text-secondary hover:text-text-primary hover:bg-bg-tertiary">Automation Rule Engine</a></li>
                    <li><a href="#" class="block py-1.5 pl-9 pr-3 rounded-md text-caption transition-colors text-text-secondary hover:text-text-primary hover:bg-bg-tertiary">Human-In-The-Loop</a></li>
                    <li><a href="#" class="block py-1.5 pl-9 pr-3 rounded-md text-caption transition-colors text-text-secondary hover:text-text-primary hover:bg-bg-tertiary">Model Governance</a></li>
                </ul>
            </li>

            <li>
                <button @click="toggle('integrations')"
                    class="w-full group flex items-center justify-between py-2 px-3 rounded-md transition-colors duration-150 outline-none whitespace-nowrap"
                    :class="activeDropdown === 'integrations' ? 'bg-bg-tertiary text-brand-primary' : 'text-text-secondary hover:bg-bg-tertiary hover:text-text-primary'">
                    <div class="flex items-center overflow-hidden">
                        <i data-lucide="plug" class="w-5 h-5 flex-shrink-0 transition-colors"
                            :class="activeDropdown === 'integrations' ? 'text-brand-primary' : 'text-text-tertiary group-hover:text-text-secondary'"></i>
                        <span x-show="sidebarOpen" class="ml-3 text-body-sm font-medium" x-cloak>External Integrations</span>
                    </div>
                    <i data-lucide="chevron-down" x-show="sidebarOpen"
                        :class="activeDropdown === 'integrations' ? 'rotate-180' : ''"
                        class="w-4 h-4 transition-transform duration-200 flex-shrink-0 text-text-tertiary"></i>
                </button>
                <ul x-show="activeDropdown === 'integrations' && sidebarOpen" x-collapse
                    class="mt-1 space-y-0.5 px-2 whitespace-nowrap" x-cloak>
                    <li><a href="#" class="block py-1.5 pl-9 pr-3 rounded-md text-caption transition-colors text-text-secondary hover:text-text-primary hover:bg-bg-tertiary">Integration Registry</a></li>
                    <li><a href="#" class="block py-1.5 pl-9 pr-3 rounded-md text-caption transition-colors text-text-secondary hover:text-text-primary hover:bg-bg-tertiary">Credential Management</a></li>
                    <li><a href="#" class="block py-1.5 pl-9 pr-3 rounded-md text-caption transition-colors text-text-secondary hover:text-text-primary hover:bg-bg-tertiary">Health Monitoring</a></li>
                    <li><a href="#" class="block py-1.5 pl-9 pr-3 rounded-md text-caption transition-colors text-text-secondary hover:text-text-primary hover:bg-bg-tertiary">Webhook Governance</a></li>
                    <li><a href="#" class="block py-1.5 pl-9 pr-3 rounded-md text-caption transition-colors text-text-secondary hover:text-text-primary hover:bg-bg-tertiary">Vendor Performance</a></li>
                </ul>
            </li>

        </ul>
        <div class="h-10"></div>
    </nav>
</div>