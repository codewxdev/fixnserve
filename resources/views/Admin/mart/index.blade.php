@extends('layouts.app')

@section('content')
<div id="mart-vendor-module" class="bg-gray-50 min-h-screen font-sans pl-4" 
    x-data="{ 
        // --- STATE MANAGEMENT ---
        openVendorId: null, 
        isAddVendorModalOpen: false, 
        currentTab: 'overview',
        searchTerm: '',
        categoryFilter: '',
        statusFilter: '',

        // --- REALISTIC DATA (Based on FIXORA Mart Logic) ---
        vendors: [
            { 
                id: 101, 
                name: 'GreenValley Hypermarket', 
                owner: 'Mr. Ahmed Khan',
                category: 'Grocery', 
                status: 'Active', 
                rating: 4.8, 
                reviews: 1240, 
                logo: 'G',
                color: 'emerald',
                joined: '12 Jan, 2024',
                contact: 'ahmed@greenvalley.com',
                phone: '+92 300 1234567',
                address: 'Plot 45, F-10 Markaz, Islamabad',
                commission: 15, // Admin takes 15%
                stats: { orders: 4520, revenue: 1250000, products: 3400 },
                wallet: { balance: 45000, pending: 12000, last_payout: '150,000' },
                inventory: [
                    { name: 'Dawn Bread Large', price: 220, stock: 45, status: 'In Stock' },
                    { name: 'Olpers Milk 1L', price: 280, stock: 12, status: 'Low Stock' },
                    { name: 'K&Ns Nuggets', price: 950, stock: 0, status: 'Out of Stock' },
                ],
                recent_orders: [
                    { id: 'ORD-9921', customer: 'Sarah Ali', total: 4500, status: 'Delivered', time: '2 hrs ago', rider: 'Bilal (Rider)' },
                    { id: 'ORD-9922', customer: 'Usman Ghafoor', total: 1250, status: 'Processing', time: '15 mins ago', rider: 'Pending' },
                ]
            },
            { 
                id: 102, 
                name: 'TechZone Electronics', 
                owner: 'Kamran Akmal',
                category: 'Electronics', 
                status: 'Inactive', 
                rating: 4.2, 
                reviews: 310, 
                logo: 'T',
                color: 'blue',
                joined: '05 Feb, 2024',
                contact: 'info@techzone.pk',
                phone: '+92 321 9876543',
                address: 'Shop 12, Saddar Rawalpindi',
                commission: 10, 
                stats: { orders: 850, revenue: 4500000, products: 120 },
                wallet: { balance: 120000, pending: 0, last_payout: '500,000' },
                inventory: [
                    { name: 'Samsung 55\' UHD TV', price: 125000, stock: 5, status: 'In Stock' },
                    { name: 'Apple iPhone 15 Charger', price: 4500, stock: 0, status: 'Out of Stock' },
                ],
                recent_orders: [
                    { id: 'ORD-8810', customer: 'Faizan Sheikh', total: 125000, status: 'Cancelled', time: '1 day ago', rider: 'N/A' },
                ]
            },
            { 
                id: 103, 
                name: 'Stylo Fashion Hub', 
                owner: 'Sana Mir',
                category: 'Fashion', 
                status: 'Pending', 
                rating: 0, 
                reviews: 0, 
                logo: 'S',
                color: 'pink',
                joined: 'Today',
                contact: 'sana@stylohub.com',
                phone: '+92 333 5555555',
                address: 'Blue Area, Islamabad',
                commission: 20, 
                stats: { orders: 0, revenue: 0, products: 0 },
                wallet: { balance: 0, pending: 0, last_payout: '0' },
                inventory: [],
                recent_orders: []
            },
        ],
    
        // --- LOGIC ---
        get filteredVendors() {
            return this.vendors.filter(v => {
                const search = this.searchTerm.toLowerCase();
                const matchesSearch = v.name.toLowerCase().includes(search) || v.contact.toLowerCase().includes(search);
                const matchesCategory = this.categoryFilter === '' || v.category === this.categoryFilter;
                const matchesStatus = this.statusFilter === '' || v.status === this.statusFilter;
                return matchesSearch && matchesCategory && matchesStatus;
            });
        },

        get activeVendor() {
            return this.vendors.find(v => v.id === this.openVendorId) || {};
        }
    }" 
    x-cloak class="p-4 md:p-8">

    {{-- HEADER SECTION --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between mb-8 gap-4">
        <div>
            <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight">Mart Vendors</h1>
            <p class="text-sm text-gray-500 mt-1">Manage Section 4.0: Inventory, Orders, and Payouts</p>
        </div>
        <div class="flex gap-3">
            <button class="px-5 py-2.5 bg-white border border-gray-200 text-gray-700 font-semibold rounded-xl shadow-sm hover:bg-gray-50 transition">
                Export Report
            </button>
            <button @click="isAddVendorModalOpen = true" class="px-5 py-2.5 bg-indigo-600 text-white font-semibold rounded-xl shadow-lg shadow-indigo-200 hover:bg-indigo-700 transition flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                Onboard Vendor
            </button>
        </div>
    </div>

    {{-- METRICS OVERVIEW (Admin View) --}}
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 relative overflow-hidden group">
            <div class="absolute right-0 top-0 w-24 h-24 bg-indigo-50 rounded-bl-full -mr-4 -mt-4 transition group-hover:bg-indigo-100"></div>
            <p class="text-gray-500 text-xs font-bold uppercase tracking-wider relative z-10">Total Active Marts</p>
            <h3 class="text-3xl font-bold text-gray-900 mt-2 relative z-10">1,240</h3>
            <p class="text-green-500 text-xs font-bold mt-2 flex items-center relative z-10">
                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                +12% this month
            </p>
        </div>
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 relative overflow-hidden group">
            <div class="absolute right-0 top-0 w-24 h-24 bg-green-50 rounded-bl-full -mr-4 -mt-4 transition group-hover:bg-green-100"></div>
            <p class="text-gray-500 text-xs font-bold uppercase tracking-wider relative z-10">Total GMV (Sales)</p>
            <h3 class="text-3xl font-bold text-gray-900 mt-2 relative z-10">PKR 8.5M</h3>
            <p class="text-green-500 text-xs font-bold mt-2 flex items-center relative z-10">
                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                +5.4% vs last week
            </p>
        </div>
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 relative overflow-hidden group">
            <div class="absolute right-0 top-0 w-24 h-24 bg-red-50 rounded-bl-full -mr-4 -mt-4 transition group-hover:bg-red-100"></div>
            <p class="text-gray-500 text-xs font-bold uppercase tracking-wider relative z-10">Pending Approvals</p>
            <h3 class="text-3xl font-bold text-gray-900 mt-2 relative z-10">15</h3>
            <p class="text-red-500 text-xs font-bold mt-2 relative z-10">Action Required</p>
        </div>
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 relative overflow-hidden group">
            <div class="absolute right-0 top-0 w-24 h-24 bg-yellow-50 rounded-bl-full -mr-4 -mt-4 transition group-hover:bg-yellow-100"></div>
            <p class="text-gray-500 text-xs font-bold uppercase tracking-wider relative z-10">Admin Commission</p>
            <h3 class="text-3xl font-bold text-gray-900 mt-2 relative z-10">PKR 1.2M</h3>
            <p class="text-gray-400 text-xs mt-2 relative z-10">Accumulated this month</p>
        </div>
    </div>

    {{-- MAIN TABLE CARD --}}
    <div class="bg-white rounded-3xl shadow-xl border border-gray-100 overflow-hidden">
        {{-- Filters Toolbar --}}
        <div class="p-5 border-b border-gray-100 bg-gray-50/50 grid grid-cols-1 sm:grid-cols-12 gap-4 items-center">
            <div class="sm:col-span-5 relative">
                <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" /></svg>
                </span>
                <input type="text" x-model="searchTerm" class="block w-full pl-10 pr-3 py-2.5 border border-gray-200 rounded-xl leading-5 bg-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm transition" placeholder="Search Vendor, Owner, or ID...">
            </div>
            <div class="sm:col-span-3">
                <select x-model="categoryFilter" class="block w-full pl-3 pr-10 py-2.5 text-base border-gray-200 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-xl">
                    <option value="">All Categories</option>
                    <option value="Grocery">Grocery</option>
                    <option value="Electronics">Electronics</option>
                    <option value="Fashion">Fashion</option>
                </select>
            </div>
            <div class="sm:col-span-3">
                <select x-model="statusFilter" class="block w-full pl-3 pr-10 py-2.5 text-base border-gray-200 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-xl">
                    <option value="">All Statuses</option>
                    <option value="Active">Active</option>
                    <option value="Inactive">Inactive</option>
                    <option value="Pending">Pending</option>
                </select>
            </div>
            <div class="sm:col-span-1 flex justify-end">
                <button @click="searchTerm=''; categoryFilter=''; statusFilter=''" class="text-gray-400 hover:text-indigo-600 transition" title="Reset Filters">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.582a8.001 8.001 0 01-15.356-2m0 0H15"></path></svg>
                </button>
            </div>
        </div>

        {{-- Table --}}
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-100">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Vendor Business</th>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Operational Stats</th>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Wallet & Status</th>
                        <th scope="col" class="px-6 py-4 text-right text-xs font-bold text-gray-500 uppercase tracking-wider">Manage</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-100">
                    <template x-for="vendor in filteredVendors" :key="vendor.id">
                        <tr class="hover:bg-gray-50 transition duration-200 cursor-pointer" @click="openVendorId = vendor.id">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-12 w-12 rounded-xl flex items-center justify-center text-white font-bold text-lg shadow-md" :class="`bg-${vendor.color}-500`" x-text="vendor.logo"></div>
                                    <div class="ml-4">
                                        <div class="text-sm font-bold text-gray-900" x-text="vendor.name"></div>
                                        <div class="text-sm text-gray-500" x-text="vendor.owner"></div>
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800 mt-1" x-text="vendor.category"></span>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900 font-semibold" x-text="vendor.stats.orders + ' Orders'"></div>
                                <div class="text-xs text-gray-500 mt-1">Inv: <span x-text="vendor.stats.products"></span> Items</div>
                                <div class="flex items-center mt-1">
                                    <svg class="w-4 h-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.012 8.73c-.783-.57-.381-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                    <span class="text-sm text-gray-600 ml-1" x-text="vendor.rating"></span>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900 font-bold" x-text="`PKR ${vendor.stats.revenue.toLocaleString()}`"></div>
                                <div class="mt-1">
                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full" 
                                        :class="{
                                            'bg-green-100 text-green-800': vendor.status === 'Active',
                                            'bg-red-100 text-red-800': vendor.status === 'Inactive',
                                            'bg-yellow-100 text-yellow-800': vendor.status === 'Pending'
                                        }" 
                                        x-text="vendor.status">
                                    </span>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <button class="text-indigo-600 hover:text-indigo-900 font-semibold flex items-center justify-end w-full group-hover:underline">
                                    Manage
                                    <svg class="ml-1 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                </button>
                            </td>
                            
                        </tr>
                    </template>
                </tbody>
            </table>
            {{-- Empty State --}}
            <div x-show="filteredVendors.length === 0" class="p-10 text-center text-gray-500">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">No vendors found</h3>
                <p class="mt-1 text-sm text-gray-500">Try adjusting your search or filter options.</p>
            </div>
        </div>
    </div>

    {{-- 
        ========================================
        SLIDE-OVER: DETAILED VENDOR MANAGEMENT 
        (Implements Section 4.3, 4.4, 4.5 of Doc)
        ========================================
    --}}
    <div x-show="openVendorId !== null" class="fixed inset-0 z-50 overflow-hidden" style="display: none;">
        <div class="absolute inset-0 overflow-hidden">
            <div x-show="openVendorId !== null" 
                x-transition:enter="ease-in-out duration-500" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" 
                x-transition:leave="ease-in-out duration-500" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" 
                class="absolute inset-0 bg-gray-900 bg-opacity-75 backdrop-blur-sm transition-opacity" 
                @click="openVendorId = null">
            </div>

            <div class="pointer-events-none fixed inset-y-0 right-0 flex max-w-full pl-10">
                <div x-show="openVendorId !== null" 
                    x-transition:enter="transform transition ease-in-out duration-500 sm:duration-700" x-transition:enter-start="translate-x-full" x-transition:enter-end="translate-x-0" 
                    x-transition:leave="transform transition ease-in-out duration-500 sm:duration-700" x-transition:leave-start="translate-x-0" x-transition:leave-end="translate-x-full" 
                    class="pointer-events-auto w-screen max-w-2xl">
                    
                    <div class="flex h-full flex-col bg-white shadow-2xl">
                        
                        {{-- SLIDER HEADER --}}
                        <div class="px-6 py-6 bg-gradient-to-r from-gray-900 to-indigo-900 sm:px-8">
                            <div class="flex items-start justify-between">
                                <div class="flex items-center space-x-4">
                                    <div class="h-16 w-16 rounded-xl bg-white/20 backdrop-blur-md flex items-center justify-center text-white text-3xl font-bold shadow-inner" x-text="activeVendor.logo"></div>
                                    <div>
                                        <h2 class="text-2xl font-bold text-white leading-6" x-text="activeVendor.name"></h2>
                                        <div class="flex items-center mt-2 space-x-4 text-indigo-200 text-sm">
                                            <span class="flex items-center"><svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg> Islamabad</span>
                                            <span class="flex items-center"><svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg> Verified</span>
                                        </div>
                                    </div>
                                </div>
                                <button type="button" class="rounded-full bg-white/10 p-2 text-white hover:bg-white/20 focus:outline-none" @click="openVendorId = null">
                                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                                </button>
                            </div>

                            {{-- TABS --}}
                            <div class="mt-8 flex space-x-1 bg-white/10 p-1 rounded-xl">
                                <button @click="currentTab = 'overview'" :class="currentTab === 'overview' ? 'bg-white text-gray-900 shadow' : 'text-gray-300 hover:text-white'" class="flex-1 rounded-lg py-2 text-sm font-medium transition">Overview</button>
                                <button @click="currentTab = 'inventory'" :class="currentTab === 'inventory' ? 'bg-white text-gray-900 shadow' : 'text-gray-300 hover:text-white'" class="flex-1 rounded-lg py-2 text-sm font-medium transition">Inventory (4.3)</button>
                                <button @click="currentTab = 'orders'" :class="currentTab === 'orders' ? 'bg-white text-gray-900 shadow' : 'text-gray-300 hover:text-white'" class="flex-1 rounded-lg py-2 text-sm font-medium transition">Orders (4.4)</button>
                                <button @click="currentTab = 'finance'" :class="currentTab === 'finance' ? 'bg-white text-gray-900 shadow' : 'text-gray-300 hover:text-white'" class="flex-1 rounded-lg py-2 text-sm font-medium transition">Wallet (4.5)</button>
                            </div>
                        </div>

                        {{-- SLIDER BODY --}}
                        <div class="flex-1 overflow-y-auto bg-gray-50 p-6">
                            
                            {{-- TAB: OVERVIEW --}}
                            <div x-show="currentTab === 'overview'" class="space-y-6">
                                <div class="bg-white p-5 rounded-xl border border-gray-200 shadow-sm">
                                    <h3 class="text-sm font-bold text-gray-900 uppercase tracking-wide mb-4">Vendor Details</h3>
                                    <div class="grid grid-cols-2 gap-4">
                                        <div><p class="text-xs text-gray-500">Owner Name</p><p class="text-sm font-semibold text-gray-800" x-text="activeVendor.owner"></p></div>
                                        <div><p class="text-xs text-gray-500">Phone</p><p class="text-sm font-semibold text-gray-800" x-text="activeVendor.phone"></p></div>
                                        <div><p class="text-xs text-gray-500">Email</p><p class="text-sm font-semibold text-gray-800" x-text="activeVendor.contact"></p></div>
                                        <div><p class="text-xs text-gray-500">Joining Date</p><p class="text-sm font-semibold text-gray-800" x-text="activeVendor.joined"></p></div>
                                    </div>
                                </div>
                                
                                {{-- Section 4.6 Vendor Settings --}}
                                <div class="bg-white p-5 rounded-xl border border-gray-200 shadow-sm">
                                    <h3 class="text-sm font-bold text-gray-900 uppercase tracking-wide mb-4">Admin Controls</h3>
                                    <div class="flex items-center justify-between py-2 border-b border-gray-100">
                                        <div>
                                            <p class="text-sm font-medium text-gray-900">Vendor Status</p>
                                            <p class="text-xs text-gray-500">Toggle to temporarily disable store.</p>
                                        </div>
                                        <button class="bg-green-500 relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none">
                                            <span class="translate-x-5 pointer-events-none inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out"></span>
                                        </button>
                                    </div>
                                    <div class="flex items-center justify-between py-2 pt-4">
                                        <div>
                                            <p class="text-sm font-medium text-gray-900">Commission Rate (%)</p>
                                            <p class="text-xs text-gray-500">Current platform fee per order.</p>
                                        </div>
                                        <div class="flex items-center">
                                            <input type="number" class="w-16 rounded border-gray-300 text-sm p-1 text-center font-bold" :value="activeVendor.commission">
                                            <span class="ml-2 text-gray-500">%</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- TAB: INVENTORY (Section 4.3) --}}
                            <div x-show="currentTab === 'inventory'" class="space-y-4">
                                <div class="flex justify-between items-center">
                                    <h3 class="font-bold text-gray-800">Product List (4.3)</h3>
                                    <span class="text-xs bg-indigo-100 text-indigo-800 px-2 py-1 rounded" x-text="`${activeVendor.stats?.products} Total Items`"></span>
                                </div>
                                <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
                                    <table class="min-w-full divide-y divide-gray-100">
                                        <thead class="bg-gray-50">
                                            <tr>
                                                <th class="px-4 py-3 text-left text-xs font-bold text-gray-500 uppercase">Item</th>
                                                <th class="px-4 py-3 text-right text-xs font-bold text-gray-500 uppercase">Price</th>
                                                <th class="px-4 py-3 text-right text-xs font-bold text-gray-500 uppercase">Stock</th>
                                            </tr>
                                        </thead>
                                        <tbody class="divide-y divide-gray-100">
                                            <template x-for="item in activeVendor.inventory">
                                                <tr class="hover:bg-gray-50">
                                                    <td class="px-4 py-3 text-sm font-medium text-gray-900" x-text="item.name"></td>
                                                    <td class="px-4 py-3 text-sm text-right text-gray-600" x-text="`PKR ${item.price}`"></td>
                                                    <td class="px-4 py-3 text-right">
                                                        <span class="px-2 py-1 text-xs font-semibold rounded-full" 
                                                            :class="{
                                                                'bg-green-100 text-green-800': item.status === 'In Stock',
                                                                'bg-yellow-100 text-yellow-800': item.status === 'Low Stock',
                                                                'bg-red-100 text-red-800': item.status === 'Out of Stock'
                                                            }" 
                                                            x-text="item.status + ' (' + item.stock + ')'">
                                                        </span>
                                                    </td>
                                                </tr>
                                            </template>
                                            <tr x-show="!activeVendor.inventory || activeVendor.inventory.length === 0">
                                                <td colspan="3" class="px-4 py-8 text-center text-gray-500 text-sm">No inventory data available for this vendor.</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            {{-- TAB: ORDERS (Section 4.4) --}}
                            <div x-show="currentTab === 'orders'" class="space-y-4">
                                <h3 class="font-bold text-gray-800">Order Processing (4.4)</h3>
                                <div class="space-y-3">
                                    <template x-for="order in activeVendor.recent_orders">
                                        <div class="bg-white border border-gray-200 rounded-xl p-4 shadow-sm hover:shadow-md transition">
                                            <div class="flex justify-between items-start">
                                                <div>
                                                    <span class="text-xs font-mono bg-gray-100 text-gray-600 px-2 py-0.5 rounded" x-text="order.id"></span>
                                                    <p class="font-bold text-gray-900 mt-1" x-text="order.customer"></p>
                                                    <p class="text-xs text-gray-500 mt-0.5" x-text="order.time"></p>
                                                </div>
                                                <div class="text-right">
                                                    <p class="font-bold text-indigo-600" x-text="`PKR ${order.total}`"></p>
                                                    <span class="inline-flex mt-1 items-center px-2 py-0.5 rounded text-xs font-medium" 
                                                        :class="{
                                                            'bg-green-100 text-green-800': order.status === 'Delivered',
                                                            'bg-blue-100 text-blue-800': order.status === 'Processing',
                                                            'bg-red-100 text-red-800': order.status === 'Cancelled'
                                                        }" x-text="order.status"></span>
                                                </div>
                                            </div>
                                            <div class="mt-3 pt-3 border-t border-gray-100 flex justify-between items-center">
                                                <div class="text-xs text-gray-500 flex items-center">
                                                    <svg class="w-4 h-4 mr-1 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-4-4V1m4 4h10v12c0 2.21-1.79 4-4 4H4a4 4 0 01-4-4V5c0-2.21 1.79-4 4-4h12V11zM7 9h.01M17 9h.01"></path></svg>
                                                    Assigned Rider: <span class="font-semibold text-gray-700 ml-1" x-text="order.rider"></span>
                                                </div>
                                                <button class="text-xs text-indigo-600 font-semibold hover:underline">View Receipt</button>
                                            </div>
                                        </div>
                                    </template>
                                    <div x-show="!activeVendor.recent_orders || activeVendor.recent_orders.length === 0" class="text-center py-8 text-gray-500 text-sm">
                                        No recent orders found.
                                    </div>
                                </div>
                            </div>

                             {{-- TAB: FINANCE (Section 4.5) --}}
                             <div x-show="currentTab === 'finance'" class="space-y-6">
                                <div class="bg-gradient-to-br from-gray-800 to-black rounded-2xl p-6 text-white shadow-lg relative overflow-hidden">
                                    <div class="absolute top-0 right-0 -mt-4 -mr-4 w-24 h-24 bg-white opacity-10 rounded-full blur-xl"></div>
                                    <p class="text-xs text-gray-400 uppercase tracking-widest font-semibold">Current Wallet Balance</p>
                                    <h3 class="text-3xl font-bold mt-2 font-mono" x-text="`PKR ${activeVendor.wallet?.balance?.toLocaleString()}`"></h3>
                                    
                                    <div class="grid grid-cols-2 gap-4 mt-6 pt-6 border-t border-gray-700">
                                        <div>
                                            <p class="text-xs text-gray-400">Pending Clearance</p>
                                            <p class="text-lg font-bold text-yellow-400" x-text="`PKR ${activeVendor.wallet?.pending?.toLocaleString()}`"></p>
                                        </div>
                                        <div>
                                            <p class="text-xs text-gray-400">Last Payout</p>
                                            <p class="text-lg font-bold text-green-400" x-text="`PKR ${activeVendor.wallet?.last_payout}`"></p>
                                        </div>
                                    </div>
                                </div>

                                <div class="bg-white rounded-xl border border-gray-200 p-5 shadow-sm">
                                    <h4 class="font-bold text-gray-900 mb-4">Payout Actions</h4>
                                    <div class="flex gap-3">
                                        <button class="flex-1 bg-indigo-600 text-white py-2 rounded-lg font-semibold text-sm hover:bg-indigo-700 shadow shadow-indigo-200">Process Payout</button>
                                        <button class="flex-1 bg-white border border-gray-300 text-gray-700 py-2 rounded-lg font-semibold text-sm hover:bg-gray-50">View History</button>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- MODAL: ADD NEW VENDOR (Section 4.1 Concept) --}}
    <div x-show="isAddVendorModalOpen" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
        <div class="flex min-h-screen items-center justify-center p-4 text-center sm:p-0">
            <div class="fixed inset-0 bg-gray-900 bg-opacity-75 transition-opacity" @click="isAddVendorModalOpen = false"></div>

            <div class="relative transform overflow-hidden rounded-2xl bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-indigo-100 sm:mx-0 sm:h-10 sm:w-10">
                            <svg class="h-6 w-6 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        </div>
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                            <h3 class="text-lg font-bold leading-6 text-gray-900">Onboard New Mart Vendor</h3>
                            <div class="mt-4 space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Business Name</label>
                                    <input type="text" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm border p-2" placeholder="e.g. Al-Fatah Grocery">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Category</label>
                                    <select class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm border p-2">
                                        <option>Grocery</option>
                                        <option>Electronics</option>
                                        <option>Mart/Convenience</option>
                                    </select>
                                </div>
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Owner Name</label>
                                        <input type="text" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm border p-2">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Commission %</label>
                                        <input type="number" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm border p-2" placeholder="10">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
                    <button type="button" class="inline-flex w-full justify-center rounded-xl bg-indigo-600 px-4 py-2 text-base font-medium text-white shadow-sm hover:bg-indigo-700 sm:ml-3 sm:w-auto sm:text-sm" @click="isAddVendorModalOpen = false">Create Account</button>
                    <button type="button" class="mt-3 inline-flex w-full justify-center rounded-xl bg-white px-4 py-2 text-base font-medium text-gray-700 shadow-sm hover:bg-gray-50 ring-1 ring-inset ring-gray-300 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm" @click="isAddVendorModalOpen = false">Cancel</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection