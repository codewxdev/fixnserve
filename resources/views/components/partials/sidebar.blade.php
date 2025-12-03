<div x-bind:class="{ 'w-64': sidebarOpen, 'w-20': !sidebarOpen }"
     class="sidebar fixed top-0 left-0 h-full z-30 flex flex-col bg-slate-800 text-white transition-all duration-300 ease-in-out">

    <div class="flex items-center justify-center h-16 border-b border-slate-700 p-4">
        <span x-show="sidebarOpen" class="text-xl font-extrabold tracking-wider text-blue-400 whitespace-nowrap overflow-hidden">FixnServe</span>
        <span x-show="!sidebarOpen" class="text-2xl font-extrabold text-blue-400 transition-opacity duration-300">FS</span>
    </div>

    <nav class="flex-1 overflow-y-auto py-4">
        <ul class="space-y-1 px-3">

            <li>
                <a href="/dashboard"
                   class="flex items-center py-2 px-3 rounded-lg text-white font-semibold bg-slate-700 hover:bg-slate-700/80 transition-colors duration-150">
                    <svg class="w-6 h-6 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0h6"></path>
                    </svg>
                    <span x-show="sidebarOpen"
                          class="ml-3 transition-opacity duration-300 whitespace-nowrap overflow-hidden">Dashboard</span>
                </a>
            </li>

            <li x-data="{ open: false }">
                <button @click="open = !open"
                        class="flex items-center w-full py-2 px-3 rounded-lg text-slate-300 hover:bg-slate-700 transition-colors duration-150">
                    <svg class="w-6 h-6 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m0 0v-2a3 3 0 00-5.356-1.857M7 20h10m0 0a3 3 0 00-5.356-1.857M7 20H2m18 0h-5.356M4 12V6m0 0h6m-6 0l-2 2"></path>
                    </svg>
                    <span x-show="sidebarOpen"
                          class="ml-3 font-medium transition-opacity duration-300 flex-1 text-left whitespace-nowrap overflow-hidden">User Management</span>
                    <svg x-show="sidebarOpen" :class="{ 'rotate-90': open }" class="w-4 h-4 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </button>
                <ul x-show="open" x-collapse.duration.300ms class="pl-8 pt-1 space-y-1" x-cloak>
                    <li><a href="/users/customers" class="flex items-center py-2 px-3 rounded-lg text-slate-400 hover:bg-slate-700/60 transition-colors duration-150">Customers</a></li>
                    <li><a href="/users/service-providers" class="flex items-center py-2 px-3 rounded-lg text-slate-400 hover:bg-slate-700/60 transition-colors duration-150">Service Providers</a></li>
                    <li><a href="/users/experts" class="flex items-center py-2 px-3 rounded-lg text-slate-400 hover:bg-slate-700/60 transition-colors duration-150">Professional Experts</a></li>
                    <li><a href="/users/consultants" class="flex items-center py-2 px-3 rounded-lg text-slate-400 hover:bg-slate-700/60 transition-colors duration-150">Consultants</a></li>
                    <li><a href="/users/mart-vendors" class="flex items-center py-2 px-3 rounded-lg text-slate-400 hover:bg-slate-700/60 transition-colors duration-150">Mart Vendors</a></li>
                    <li><a href="/users/riders" class="flex items-center py-2 px-3 rounded-lg text-slate-400 hover:bg-slate-700/60 transition-colors duration-150">Riders</a></li>
                    <li><a href="/users/admins" class="flex items-center py-2 px-3 rounded-lg text-slate-400 hover:bg-slate-700/60 transition-colors duration-150">Admin Management</a></li>
                </ul>
            </li>

            <li>
                <a href="/finance"
                   class="flex items-center py-2 px-3 rounded-lg text-slate-300 hover:bg-slate-700 transition-colors duration-150">
                    <svg class="w-6 h-6 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m4 2h2a2 2 0 002-2v-6m-4-2H9m7-2h2a2 2 0 012 2v6a2 2 0 01-2 2h-2"></path>
                    </svg>
                    <span x-show="sidebarOpen"
                          class="ml-3 font-medium transition-opacity duration-300 whitespace-nowrap overflow-hidden">Financial System</span>
                </a>
            </li>

            <li x-data="{ open: false }">
                <button @click="open = !open"
                        class="flex items-center w-full py-2 px-3 rounded-lg text-slate-300 hover:bg-slate-700 transition-colors duration-150">
                    <svg class="w-6 h-6 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 15l-2 5L9 9l11 4-5 2zm0 0l5 5"></path>
                    </svg>
                    <span x-show="sidebarOpen"
                          class="ml-3 font-medium transition-opacity duration-300 flex-1 text-left whitespace-nowrap overflow-hidden">C. & R. System</span>
                    <svg x-show="sidebarOpen" :class="{ 'rotate-90': open }" class="w-4 h-4 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </button>
                <ul x-show="open" x-collapse.duration.300ms class="pl-8 pt-1 space-y-1" x-cloak>
                    <li><a href="/complaints" class="flex items-center py-2 px-3 rounded-lg text-slate-400 hover:bg-slate-700/60 transition-colors duration-150">Complaints</a></li>
                    <li><a href="/refunds" class="flex items-center py-2 px-3 rounded-lg text-slate-400 hover:bg-slate-700/60 transition-colors duration-150">Refund Requests</a></li>
                </ul>
            </li>

            <li>
                <a href="/reports"
                   class="flex items-center py-2 px-3 rounded-lg text-slate-300 hover:bg-slate-700 transition-colors duration-150">
                    <svg class="w-6 h-6 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 8v8m-4-5v5m-4-2v2m-2 4h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    <span x-show="sidebarOpen"
                          class="ml-3 font-medium transition-opacity duration-300 whitespace-nowrap overflow-hidden">Reports & Analytics</span>
                </a>
            </li>

            <li x-data="{ open: false }">
                <button @click="open = !open"
                        class="flex items-center w-full py-2 px-3 rounded-lg text-slate-300 hover:bg-slate-700 transition-colors duration-150">
                    <svg class="w-6 h-6 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.525.322 1.012.35 1.573.181"></path>
                    </svg>
                    <span x-show="sidebarOpen"
                          class="ml-3 font-medium transition-opacity duration-300 flex-1 text-left whitespace-nowrap overflow-hidden">CMS & Settings</span>
                    <svg x-show="sidebarOpen" :class="{ 'rotate-90': open }" class="w-4 h-4 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </button>
                <ul x-show="open" x-collapse.duration.300ms class="pl-8 pt-1 space-y-1" x-cloak>
                    <li><a href="/cms" class="flex items-center py-2 px-3 rounded-lg text-slate-400 hover:bg-slate-700/60 transition-colors duration-150">Content Management</a></li>
                    <li><a href="/settings" class="flex items-center py-2 px-3 rounded-lg text-slate-400 hover:bg-slate-700/60 transition-colors duration-150">General Settings</a></li>
                </ul>
            </li>
            
            <li>
                <a href="/notifications"
                   class="flex items-center py-2 px-3 rounded-lg text-slate-300 hover:bg-slate-700 transition-colors duration-150">
                    <svg class="w-6 h-6 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1"></path>
                    </svg>
                    <span x-show="sidebarOpen"
                          class="ml-3 font-medium transition-opacity duration-300 whitespace-nowrap overflow-hidden">Notifications Engine</span>
                </a>
            </li>

        </ul>
    </nav>
</div>