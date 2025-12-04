    <!-- Sidebar -->
    <div x-bind:class="{ 'w-64': sidebarOpen, 'w-20': !sidebarOpen }"
        class="sidebar fixed top-0 left-0 h-full z-30 flex flex-col text-white">

        <!-- Logo -->
        <div class="flex items-center justify-center h-16 border-b border-slate-700">
            <span x-show="sidebarOpen"
                class="text-xl font-extrabold tracking-wider text-blue-400 transition-opacity duration-300"
                x-cloak>FixnServe</span>
            <span x-show="!sidebarOpen" class="text-2xl font-extrabold text-blue-400 transition-opacity duration-300"
                x-cloak>FS</span>
        </div>

        <!-- Navigation Links -->
        <nav class="flex-1 overflow-y-auto py-4">
            <ul class="space-y-2 px-3">

                <!-- Helper Component Structure for Collapsible Menu Item -->
                <!-- The structure is repeated below for all required tabs -->

                <!-- Dashboard Link (Non-collapsible, Active Example) -->
                <li>
                    <a href="/dashboard"
                        class="flex items-center py-2 px-3 rounded-lg text-slate-300 hover:bg-slate-700 nav-active transition duration-150">
                        <svg class="w-6 h-6 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 3h8v8H3V3zm10 0h8v5h-8V3zM3 13h5v8H3v-8zm7 0h11v8H10v-8z" />
                        </svg>
                        <span x-show="sidebarOpen" class="ml-3 font-medium transition-opacity duration-300"
                            x-cloak>Dashboard</span>
                    </a>
                </li>


                <!-- === COLLAPSIBLE MENU ITEMS START HERE === -->

                <!-- 1. Customers -->
                <li x-data="{ open: false }">
                    <button @click="open = !open"
                        class="w-full flex items-center py-2 px-3 rounded-lg text-slate-300 hover:bg-slate-700 transition duration-150">
                        <!-- Icon -->
                        <svg class="w-6 h-6 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 21v-2a4 4 0 00-3-3.87m-7 0A4 4 0 004 19v2m8-10a4 4 0 110-8 4 4 0 010 8z" />
                        </svg>

                        <!-- Name -->
                        <span x-show="sidebarOpen" class="ml-3 font-medium transition-opacity duration-300 text-left flex-1"
                            x-cloak>Customers</span>

                        <!-- Arrow Icon (Only show when sidebar is open) -->
                        <svg x-show="sidebarOpen" :class="{ 'rotate-90': open }"
                            class="w-4 h-4 ml-auto icon-rotate flex-shrink-0" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" x-cloak>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7">
                            </path>
                        </svg>
                    </button>

                    <!-- Subcategories -->
                    <ul x-show="open" x-cloak
                        x-transition:enter="transition-all ease-in-out duration-300 overflow-hidden"
                        x-transition:enter-start="max-h-0 opacity-0" x-transition:enter-end="max-h-96 opacity-100"
                        x-transition:leave="transition-all ease-in-out duration-300 overflow-hidden"
                        x-transition:leave-start="max-h-96 opacity-100" x-transition:leave-end="max-h-0 opacity-0"
                        class="ml-10 space-y-1 mt-1 border-l border-slate-600">
                        <li><a href="#" class="block py-1.5 px-3 text-sm rounded-lg text-slate-400 hover:text-white hover:bg-slate-800">Customer Details</a></li>
                        <li><a href="#" class="block py-1.5 px-3 text-sm rounded-lg text-slate-400 hover:text-white hover:bg-slate-800"> Order History</a></li>
                        <li><a href="#" class="block py-1.5 px-3 text-sm rounded-lg text-slate-400 hover:text-white hover:bg-slate-800">Payment History</a></li>
                        <li><a href="#" class="block py-1.5 px-3 text-sm rounded-lg text-slate-400 hover:text-white hover:bg-slate-800">Wallet Transactions</a></li>
                        <li><a href="#" class="block py-1.5 px-3 text-sm rounded-lg text-slate-400 hover:text-white hover:bg-slate-800">Saved Providers</a></li>
                        <li><a href="#" class="block py-1.5 px-3 text-sm rounded-lg text-slate-400 hover:text-white hover:bg-slate-800">Complaints / Support Tickets</a></li>
                        <li><a href="#" class="block py-1.5 px-3 text-sm rounded-lg text-slate-400 hover:text-white hover:bg-slate-800">Refund Requests</a></li>
                        <li><a href="#" class="block py-1.5 px-3 text-sm rounded-lg text-slate-400 hover:text-white hover:bg-slate-800">Ban / Suspend User</a></li>
                        <li><a href="#" class="block py-1.5 px-3 text-sm rounded-lg text-slate-400 hover:text-white hover:bg-slate-800">Login History</a></li>
                        <li><a href="#" class="block py-1.5 px-3 text-sm rounded-lg text-slate-400 hover:text-white hover:bg-slate-800">Device & Sessions</a></li>
                    </ul>
                </li>

                <!-- 2. Service Providers -->
                <li x-data="{ open: false }">
                    <button @click="open = !open"
                        class="w-full flex items-center py-2 px-3 rounded-lg text-slate-300 hover:bg-slate-700 transition duration-150">
                        <!-- Icon -->
                        <svg class="w-6 h-6 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 7h18v10H3V7zm5-4h8v4H8V3z" />
                        </svg>
                        <!-- Name -->
                        <span x-show="sidebarOpen" class="ml-3 font-medium transition-opacity duration-300 text-left flex-1"
                            x-cloak>Service Providers</span>
                        <!-- Arrow Icon -->
                        <svg x-show="sidebarOpen" :class="{ 'rotate-90': open }"
                            class="w-4 h-4 ml-auto icon-rotate flex-shrink-0" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" x-cloak>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7">
                            </path>
                        </svg>
                    </button>
                    <!-- Subcategories -->
                    <ul x-show="open" x-cloak
                        x-transition:enter="transition-all ease-in-out duration-300 overflow-hidden"
                        x-transition:enter-start="max-h-0 opacity-0" x-transition:enter-end="max-h-96 opacity-100"
                        x-transition:leave="transition-all ease-in-out duration-300 overflow-hidden"
                        x-transition:leave-start="max-h-96 opacity-100" x-transition:leave-end="max-h-0 opacity-0"
                        class="ml-10 space-y-1 mt-1 border-l border-slate-600">
                        <li><a href="#" class="block py-1.5 px-3 text-sm rounded-lg text-slate-400 hover:text-white hover:bg-slate-800">All Providers</a></li>
                        <li><a href="#" class="block py-1.5 px-3 text-sm rounded-lg text-slate-400 hover:text-white hover:bg-slate-800">Service Categories</a></li>
                        <li><a href="#" class="block py-1.5 px-3 text-sm rounded-lg text-slate-400 hover:text-white hover:bg-slate-800">Commissions</a></li>
                    </ul>
                </li>

                <!-- 3. Professional Experts -->
                <li x-data="{ open: false }">
                    <button @click="open = !open"
                        class="w-full flex items-center py-2 px-3 rounded-lg text-slate-300 hover:bg-slate-700 transition duration-150">
                        <!-- Icon -->
                        <svg class="w-6 h-6 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8a4 4 0 110 8 4 4 0 010-8zm0-6l2 4h4l-3 3 1 4-4-2-4 2 1-4-3-3h4l2-4z" />
                        </svg>
                        <!-- Name -->
                        <span x-show="sidebarOpen" class="ml-3 font-medium transition-opacity duration-300 text-left flex-1"
                            x-cloak>Professional Experts</span>
                        <!-- Arrow Icon -->
                        <svg x-show="sidebarOpen" :class="{ 'rotate-90': open }"
                            class="w-4 h-4 ml-auto icon-rotate flex-shrink-0" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" x-cloak>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7">
                            </path>
                        </svg>
                    </button>
                    <!-- Subcategories -->
                    <ul x-show="open" x-cloak
                        x-transition:enter="transition-all ease-in-out duration-300 overflow-hidden"
                        x-transition:enter-start="max-h-0 opacity-0" x-transition:enter-end="max-h-96 opacity-100"
                        x-transition:leave="transition-all ease-in-out duration-300 overflow-hidden"
                        x-transition:leave-start="max-h-96 opacity-100" x-transition:leave-end="max-h-0 opacity-0"
                        class="ml-10 space-y-1 mt-1 border-l border-slate-600">
                        <li><a href="#" class="block py-1.5 px-3 text-sm rounded-lg text-slate-400 hover:text-white hover:bg-slate-800">Expert List</a></li>
                        <li><a href="#" class="block py-1.5 px-3 text-sm rounded-lg text-slate-400 hover:text-white hover:bg-slate-800">Approvals</a></li>
                        <li><a href="#" class="block py-1.5 px-3 text-sm rounded-lg text-slate-400 hover:text-white hover:bg-slate-800">Skill Sets</a></li>
                    </ul>
                </li>

                <!-- 4. Consultants -->
                <li x-data="{ open: false }">
                    <button @click="open = !open"
                        class="w-full flex items-center py-2 px-3 rounded-lg text-slate-300 hover:bg-slate-700 transition duration-150">
                        <!-- Icon -->
                        <svg class="w-6 h-6 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 15a2 2 0 01-2 2H7l-4 4V5a2 2 0 012-2h14a2 2 0 012 2v10z" />
                        </svg>
                        <!-- Name -->
                        <span x-show="sidebarOpen" class="ml-3 font-medium transition-opacity duration-300 text-left flex-1"
                            x-cloak>Consultants</span>
                        <!-- Arrow Icon -->
                        <svg x-show="sidebarOpen" :class="{ 'rotate-90': open }"
                            class="w-4 h-4 ml-auto icon-rotate flex-shrink-0" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" x-cloak>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7">
                            </path>
                        </svg>
                    </button>
                    <!-- Subcategories -->
                    <ul x-show="open" x-cloak
                        x-transition:enter="transition-all ease-in-out duration-300 overflow-hidden"
                        x-transition:enter-start="max-h-0 opacity-0" x-transition:enter-end="max-h-96 opacity-100"
                        x-transition:leave="transition-all ease-in-out duration-300 overflow-hidden"
                        x-transition:leave-start="max-h-96 opacity-100" x-transition:leave-end="max-h-0 opacity-0"
                        class="ml-10 space-y-1 mt-1 border-l border-slate-600">
                        <li><a href="#" class="block py-1.5 px-3 text-sm rounded-lg text-slate-400 hover:text-white hover:bg-slate-800">All Consults</a></li>
                        <li><a href="#" class="block py-1.5 px-3 text-sm rounded-lg text-slate-400 hover:text-white hover:bg-slate-800">Pending Requests</a></li>
                        <li><a href="#" class="block py-1.5 px-3 text-sm rounded-lg text-slate-400 hover:text-white hover:bg-slate-800">Earnings</a></li>
                    </ul>
                </li>

                <!-- 5. Mart Vendors -->
                <li x-data="{ open: false }">
                    <button @click="open = !open"
                        class="w-full flex items-center py-2 px-3 rounded-lg text-slate-300 hover:bg-slate-700 transition duration-150">
                        <!-- Icon -->
                        <svg class="w-6 h-6 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 9l1-5h16l1 5M4 9v11h16V9M9 22V12h6v10" />
                        </svg>
                        <!-- Name -->
                        <span x-show="sidebarOpen" class="ml-3 font-medium transition-opacity duration-300 text-left flex-1"
                            x-cloak>Mart Vendors</span>
                        <!-- Arrow Icon -->
                        <svg x-show="sidebarOpen" :class="{ 'rotate-90': open }"
                            class="w-4 h-4 ml-auto icon-rotate flex-shrink-0" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" x-cloak>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7">
                            </path>
                        </svg>
                    </button>
                    <!-- Subcategories -->
                    <ul x-show="open" x-cloak
                        x-transition:enter="transition-all ease-in-out duration-300 overflow-hidden"
                        x-transition:enter-start="max-h-0 opacity-0" x-transition:enter-end="max-h-96 opacity-100"
                        x-transition:leave="transition-all ease-in-out duration-300 overflow-hidden"
                        x-transition:leave-start="max-h-96 opacity-100" x-transition:leave-end="max-h-0 opacity-0"
                        class="ml-10 space-y-1 mt-1 border-l border-slate-600">
                        <li><a href="#" class="block py-1.5 px-3 text-sm rounded-lg text-slate-400 hover:text-white hover:bg-slate-800">All Vendors</a></li>
                        <li><a href="#" class="block py-1.5 px-3 text-sm rounded-lg text-slate-400 hover:text-white hover:bg-slate-800">Product Management</a></li>
                        <li><a href="#" class="block py-1.5 px-3 text-sm rounded-lg text-slate-400 hover:text-white hover:bg-slate-800">Inventory</a></li>
                    </ul>
                </li>

                <!-- 6. Riders -->
                <li x-data="{ open: false }">
                    <button @click="open = !open"
                        class="w-full flex items-center py-2 px-3 rounded-lg text-slate-300 hover:bg-slate-700 transition duration-150">
                        <!-- Icon -->
                        <svg class="w-6 h-6 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M5 18a3 3 0 110-6 3 3 0 010 6zm14 0a3 3 0 110-6 3 3 0 010 6zM5 15h6l3-6h4" />
                        </svg>
                        <!-- Name -->
                        <span x-show="sidebarOpen" class="ml-3 font-medium transition-opacity duration-300 text-left flex-1"
                            x-cloak>Riders</span>
                        <!-- Arrow Icon -->
                        <svg x-show="sidebarOpen" :class="{ 'rotate-90': open }"
                            class="w-4 h-4 ml-auto icon-rotate flex-shrink-0" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" x-cloak>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7">
                            </path>
                        </svg>
                    </button>
                    <!-- Subcategories -->
                    <ul x-show="open" x-cloak
                        x-transition:enter="transition-all ease-in-out duration-300 overflow-hidden"
                        x-transition:enter-start="max-h-0 opacity-0" x-transition:enter-end="max-h-96 opacity-100"
                        x-transition:leave="transition-all ease-in-out duration-300 overflow-hidden"
                        x-transition:leave-start="max-h-96 opacity-100" x-transition:leave-end="max-h-0 opacity-0"
                        class="ml-10 space-y-1 mt-1 border-l border-slate-600">
                        <li><a href="#" class="block py-1.5 px-3 text-sm rounded-lg text-slate-400 hover:text-white hover:bg-slate-800">All Riders</a></li>
                        <li><a href="#" class="block py-1.5 px-3 text-sm rounded-lg text-slate-400 hover:text-white hover:bg-slate-800">Rider Tracking</a></li>
                        <li><a href="#" class="block py-1.5 px-3 text-sm rounded-lg text-slate-400 hover:text-white hover:bg-slate-800">Payouts</a></li>
                    </ul>
                </li>

                <!-- 7. Admin Management -->
                <li x-data="{ open: false }">
                    <button @click="open = !open"
                        class="w-full flex items-center py-2 px-3 rounded-lg text-slate-300 hover:bg-slate-700 transition duration-150">
                        <!-- Icon -->
                        <svg class="w-6 h-6 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 2l7 4v4c0 5-3.5 9.5-7 10-3.5-.5-7-5-7-10V6l7-4zm0 8a3 3 0 110 6 3 3 0 010-6z" />
                        </svg>
                        <!-- Name -->
                        <span x-show="sidebarOpen" class="ml-3 font-medium transition-opacity duration-300 text-left flex-1"
                            x-cloak>Admin Management</span>
                        <!-- Arrow Icon -->
                        <svg x-show="sidebarOpen" :class="{ 'rotate-90': open }"
                            class="w-4 h-4 ml-auto icon-rotate flex-shrink-0" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" x-cloak>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7">
                            </path>
                        </svg>
                    </button>
                    <!-- Subcategories -->
                    <ul x-show="open" x-cloak
                        x-transition:enter="transition-all ease-in-out duration-300 overflow-hidden"
                        x-transition:enter-start="max-h-0 opacity-0" x-transition:enter-end="max-h-96 opacity-100"
                        x-transition:leave="transition-all ease-in-out duration-300 overflow-hidden"
                        x-transition:leave-start="max-h-96 opacity-100" x-transition:leave-end="max-h-0 opacity-0"
                        class="ml-10 space-y-1 mt-1 border-l border-slate-600">
                        <li><a href="#" class="block py-1.5 px-3 text-sm rounded-lg text-slate-400 hover:text-white hover:bg-slate-800">Admin Users</a></li>
                        <li><a href="#" class="block py-1.5 px-3 text-sm rounded-lg text-slate-400 hover:text-white hover:bg-slate-800">Roles & Permissions</a></li>
                        <li><a href="#" class="block py-1.5 px-3 text-sm rounded-lg text-slate-400 hover:text-white hover:bg-slate-800">Activity Logs</a></li>
                    </ul>
                </li>

                <!-- 8. Financial System -->
                <li x-data="{ open: false }">
                    <button @click="open = !open"
                        class="w-full flex items-center py-2 px-3 rounded-lg text-slate-300 hover:bg-slate-700 transition duration-150">
                        <!-- Icon -->
                        <svg class="w-6 h-6 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 7h18v10H3V7zm13 3h3v4h-3v-4z" />
                        </svg>
                        <!-- Name -->
                        <span x-show="sidebarOpen" class="ml-3 font-medium transition-opacity duration-300 text-left flex-1"
                            x-cloak>Financial System</span>
                        <!-- Arrow Icon -->
                        <svg x-show="sidebarOpen" :class="{ 'rotate-90': open }"
                            class="w-4 h-4 ml-auto icon-rotate flex-shrink-0" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" x-cloak>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7">
                            </path>
                        </svg>
                    </button>
                    <!-- Subcategories -->
                    <ul x-show="open" x-cloak
                        x-transition:enter="transition-all ease-in-out duration-300 overflow-hidden"
                        x-transition:enter-start="max-h-0 opacity-0" x-transition:enter-end="max-h-96 opacity-100"
                        x-transition:leave="transition-all ease-in-out duration-300 overflow-hidden"
                        x-transition:leave-start="max-h-96 opacity-100" x-transition:leave-end="max-h-0 opacity-0"
                        class="ml-10 space-y-1 mt-1 border-l border-slate-600">
                        <li><a href="#" class="block py-1.5 px-3 text-sm rounded-lg text-slate-400 hover:text-white hover:bg-slate-800">Transactions</a></li>
                        <li><a href="#" class="block py-1.5 px-3 text-sm rounded-lg text-slate-400 hover:text-white hover:bg-slate-800">Payouts</a></li>
                        <li><a href="#" class="block py-1.5 px-3 text-sm rounded-lg text-slate-400 hover:text-white hover:bg-slate-800">Invoices</a></li>
                        <li><a href="#" class="block py-1.5 px-3 text-sm rounded-lg text-slate-400 hover:text-white hover:bg-slate-800">Tax Reports</a></li>
                    </ul>
                </li>

                <!-- 9. Complaint & Refund System -->
                <li x-data="{ open: false }">
                    <button @click="open = !open"
                        class="w-full flex items-center py-2 px-3 rounded-lg text-slate-300 hover:bg-slate-700 transition duration-150">
                        <!-- Icon -->
                        <svg class="w-6 h-6 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 9v4m0 4h.01M12 2a10 10 0 110 20 10 10 0 010-20z" />
                        </svg>
                        <!-- Name -->
                        <span x-show="sidebarOpen" class="ml-3 font-medium transition-opacity duration-300 text-left flex-1"
                            x-cloak>Complaint & Refund System</span>
                        <!-- Arrow Icon -->
                        <svg x-show="sidebarOpen" :class="{ 'rotate-90': open }"
                            class="w-4 h-4 ml-auto icon-rotate flex-shrink-0" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" x-cloak>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7">
                            </path>
                        </svg>
                    </button>
                    <!-- Subcategories -->
                    <ul x-show="open" x-cloak
                        x-transition:enter="transition-all ease-in-out duration-300 overflow-hidden"
                        x-transition:enter-start="max-h-0 opacity-0" x-transition:enter-end="max-h-96 opacity-100"
                        x-transition:leave="transition-all ease-in-out duration-300 overflow-hidden"
                        x-transition:leave-start="max-h-96 opacity-100" x-transition:leave-end="max-h-0 opacity-0"
                        class="ml-10 space-y-1 mt-1 border-l border-slate-600">
                        <li><a href="#" class="block py-1.5 px-3 text-sm rounded-lg text-slate-400 hover:text-white hover:bg-slate-800">New Complaints</a></li>
                        <li><a href="#" class="block py-1.5 px-3 text-sm rounded-lg text-slate-400 hover:text-white hover:bg-slate-800">Pending Refunds</a></li>
                        <li><a href="#" class="block py-1.5 px-3 text-sm rounded-lg text-slate-400 hover:text-white hover:bg-slate-800">Resolution History</a></li>
                    </ul>
                </li>

                <!-- 10. Reports and Analytics -->
                <li x-data="{ open: false }">
                    <button @click="open = !open"
                        class="w-full flex items-center py-2 px-3 rounded-lg text-slate-300 hover:bg-slate-700 transition duration-150">
                        <!-- Icon -->
                        <svg class="w-6 h-6 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M5 12h2v6H5v-6zm6-4h2v10h-2V8zm6 2h2v8h-2v-8z" />
                        </svg>
                        <!-- Name -->
                        <span x-show="sidebarOpen" class="ml-3 font-medium transition-opacity duration-300 text-left flex-1"
                            x-cloak>Reports and Analytics</span>
                        <!-- Arrow Icon -->
                        <svg x-show="sidebarOpen" :class="{ 'rotate-90': open }"
                            class="w-4 h-4 ml-auto icon-rotate flex-shrink-0" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" x-cloak>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7">
                            </path>
                        </svg>
                    </button>
                    
                    <!-- Subcategories -->
                    <ul x-show="open" x-cloak
                        x-transition:enter="transition-all ease-in-out duration-300 overflow-hidden"
                        x-transition:enter-start="max-h-0 opacity-0" x-transition:enter-end="max-h-96 opacity-100"
                        x-transition:leave="transition-all ease-in-out duration-300 overflow-hidden"
                        x-transition:leave-start="max-h-96 opacity-100" x-transition:leave-end="max-h-0 opacity-0"
                        class="ml-10 space-y-1 mt-1 border-l border-slate-600">
                        <li><a href="#" class="block py-1.5 px-3 text-sm rounded-lg text-slate-400 hover:text-white hover:bg-slate-800">Sales Reports</a></li>
                        <li><a href="#" class="block py-1.5 px-3 text-sm rounded-lg text-slate-400 hover:text-white hover:bg-slate-800">User Activity</a></li>
                        <li><a href="#" class="block py-1.5 px-3 text-sm rounded-lg text-slate-400 hover:text-white hover:bg-slate-800">Service Metrics</a></li>
                    </ul>
                </li>

                <!-- 11. CMS & Settings -->
                <li x-data="{ open: false }">
                    <button @click="open = !open"
                        class="w-full flex items-center py-2 px-3 rounded-lg text-slate-300 hover:bg-slate-700 transition duration-150">
                        <!-- Icon -->
                        <svg class="w-6 h-6 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 15a3 3 0 110-6 3 3 0 010 6zm8.94-2a1 1 0 000-2l-2.1-.35a6.99 6.99 0 00-.78-1.88l1.26-1.78a1 1 0 00-1.42-1.42l-1.78 1.26a7 7 0 00-1.88-.78L14 3.06a1 1 0 00-2 0l-.35 2.1a7 7 0 00-1.88.78L8 4.68a1 1 0 00-1.42 1.42l1.26 1.78a6.99 6.99 0 00-.78 1.88L4.06 10a1 1 0 000 2l2.1.35c.14.66.38 1.29.78 1.88l-1.26 1.78a1 1 0 001.42 1.42l1.78-1.26c.59.4 1.22.64 1.88.78l.35 2.1a1 1 0 002 0l.35-2.1c.66-.14 1.29-.38 1.88-.78l1.78 1.26a1 1 0 001.42-1.42l-1.26-1.78c.4-.59.64-1.22.78-1.88l2.1-.35z" />
                        </svg>
                        <!-- Name -->
                        <span x-show="sidebarOpen" class="ml-3 font-medium transition-opacity duration-300 text-left flex-1"
                            x-cloak>CMS & Settings</span>
                        <!-- Arrow Icon -->
                        <svg x-show="sidebarOpen" :class="{ 'rotate-90': open }"
                            class="w-4 h-4 ml-auto icon-rotate flex-shrink-0" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" x-cloak>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7">
                            </path>
                        </svg>
                    </button>

                    <!-- Subcategories -->
                    <ul x-show="open" x-cloak
                        x-transition:enter="transition-all ease-in-out duration-300 overflow-hidden"
                        x-transition:enter-start="max-h-0 opacity-0" x-transition:enter-end="max-h-96 opacity-100"
                        x-transition:leave="transition-all ease-in-out duration-300 overflow-hidden"
                        x-transition:leave-start="max-h-96 opacity-100" x-transition:leave-end="max-h-0 opacity-0"
                        class="ml-10 space-y-1 mt-1 border-l border-slate-600">
                        <li><a href="#" class="block py-1.5 px-3 text-sm rounded-lg text-slate-400 hover:text-white hover:bg-slate-800">CMS Pages</a></li>
                        <li><a href="#" class="block py-1.5 px-3 text-sm rounded-lg text-slate-400 hover:text-white hover:bg-slate-800">General Settings</a></li>
                        <li><a href="#" class="block py-1.5 px-3 text-sm rounded-lg text-slate-400 hover:text-white hover:bg-slate-800">Email Templates</a></li>
                    </ul>
                </li>


                <!-- 12. Notifications Engine -->
                <li x-data="{ open: false }">
                    <button @click="open = !open"
                        class="w-full flex items-center py-2 px-3 rounded-lg text-slate-300 hover:bg-slate-700 transition duration-150">
                        <!-- Icon -->
                        <svg class="w-6 h-6 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 22a2 2 0 002-2H10a2 2 0 002 2zm7-6V11a7 7 0 10-14 0v5l-2 2h18l-2-2z" />
                        </svg>
                        <!-- Name -->
                        <span x-show="sidebarOpen" class="ml-3 font-medium transition-opacity duration-300 text-left flex-1"
                            x-cloak>Notifications Engine</span>
                        <!-- Arrow Icon -->
                        <svg x-show="sidebarOpen" :class="{ 'rotate-90': open }"
                            class="w-4 h-4 ml-auto icon-rotate flex-shrink-0" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" x-cloak>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7">
                            </path>
                        </svg>
                    </button>

                    <!-- Subcategories -->
                    <ul x-show="open" x-cloak
                        x-transition:enter="transition-all ease-in-out duration-300 overflow-hidden"
                        x-transition:enter-start="max-h-0 opacity-0" x-transition:enter-end="max-h-96 opacity-100"
                        x-transition:leave="transition-all ease-in-out duration-300 overflow-hidden"
                        x-transition:leave-start="max-h-96 opacity-100" x-transition:leave-end="max-h-0 opacity-0"
                        class="ml-10 space-y-1 mt-1 border-l border-slate-600">
                        <li><a href="#" class="block py-1.5 px-3 text-sm rounded-lg text-slate-400 hover:text-white hover:bg-slate-800">Templates</a></li>
                        <li><a href="#" class="block py-1.5 px-3 text-sm rounded-lg text-slate-400 hover:text-white hover:bg-slate-800">Send Notification</a></li>
                        <li><a href="#" class="block py-1.5 px-3 text-sm rounded-lg text-slate-400 hover:text-white hover:bg-slate-800">Logs</a></li>
                    </ul>
                </li>

                <!-- === COLLAPSIBLE MENU ITEMS END HERE === -->

            </ul>
        </nav>
    </div>

    