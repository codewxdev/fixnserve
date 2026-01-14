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

        // --- DYNAMIC DATA FROM BACKEND ---
        vendors: @json($vendors),
    
        // --- LOGIC ---
        get filteredVendors() {
            return this.vendors.filter(v => {
                const search = this.searchTerm.toLowerCase();
                const vName = v.name ? v.name.toLowerCase() : '';
                const vContact = v.contact ? v.contact.toLowerCase() : '';

                const matchesSearch = vName.includes(search) || vContact.includes(search);
                const matchesCategory = this.categoryFilter === '' || v.category === 'NaN' || v.category === this.categoryFilter;
                
                // Status check (DB lowercase vs Filter Uppercase handle)
                const matchesStatus = this.statusFilter === '' || 
                                      (v.status && v.status.toLowerCase() === this.statusFilter.toLowerCase());
                                      
                return matchesSearch && matchesCategory && matchesStatus;
            });
        },

        get activeVendor() {
            return this.vendors.find(v => v.id === this.openVendorId) || {};
        },

        // Helper: Agar value NaN hai to error na aye
        formatMoney(amount) {
            if(amount === 'NaN') return 'NaN';
            return 'PKR ' + Number(amount).toLocaleString();
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

    {{-- METRICS OVERVIEW (CARDS RESTORED) --}}
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 relative overflow-hidden group">
            <div class="absolute right-0 top-0 w-24 h-24 bg-indigo-50 rounded-bl-full -mr-4 -mt-4 transition group-hover:bg-indigo-100"></div>
            <p class="text-gray-500 text-xs font-bold uppercase tracking-wider relative z-10">Total Active Marts</p>
            <h3 class="text-3xl font-bold text-gray-900 mt-2 relative z-10" x-text="vendors.length"></h3>
            <p class="text-green-500 text-xs font-bold mt-2 flex items-center relative z-10">
                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                Dynamic Data
            </p>
        </div>
        
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 relative overflow-hidden group">
            <div class="absolute right-0 top-0 w-24 h-24 bg-green-50 rounded-bl-full -mr-4 -mt-4 transition group-hover:bg-green-100"></div>
            <p class="text-gray-500 text-xs font-bold uppercase tracking-wider relative z-10">Total GMV (Sales)</p>
            <h3 class="text-3xl font-bold text-gray-900 mt-2 relative z-10">NaN</h3>
            <p class="text-gray-400 text-xs mt-2 relative z-10">Data Unavailable</p>
        </div>

        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 relative overflow-hidden group">
            <div class="absolute right-0 top-0 w-24 h-24 bg-red-50 rounded-bl-full -mr-4 -mt-4 transition group-hover:bg-red-100"></div>
            <p class="text-gray-500 text-xs font-bold uppercase tracking-wider relative z-10">Pending Approvals</p>
            <h3 class="text-3xl font-bold text-gray-900 mt-2 relative z-10">NaN</h3>
            <p class="text-red-500 text-xs font-bold mt-2 relative z-10">Action Required</p>
        </div>

        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 relative overflow-hidden group">
            <div class="absolute right-0 top-0 w-24 h-24 bg-yellow-50 rounded-bl-full -mr-4 -mt-4 transition group-hover:bg-yellow-100"></div>
            <p class="text-gray-500 text-xs font-bold uppercase tracking-wider relative z-10">Admin Commission</p>
            <h3 class="text-3xl font-bold text-gray-900 mt-2 relative z-10">NaN</h3>
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
                <input type="text" x-model="searchTerm" class="block w-full pl-10 pr-3 py-2.5 border border-gray-200 rounded-xl leading-5 bg-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm transition" placeholder="Search Vendor, Owner...">
            </div>
            <div class="sm:col-span-3">
                <select x-model="categoryFilter" class="block w-full pl-3 pr-10 py-2.5 text-base border-gray-200 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-xl">
                    <option value="">All Categories</option>
                    <option value="NaN">Uncategorized</option>
                </select>
            </div>
            <div class="sm:col-span-3">
                <select x-model="statusFilter" class="block w-full pl-3 pr-10 py-2.5 text-base border-gray-200 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-xl">
                    <option value="">All Statuses</option>
                    <option value="Active">Active</option>
                    <option value="Deactive">Deactive</option>
                    <option value="Suspend">Suspend</option>
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
                                <div class="text-sm text-gray-900 font-bold" x-text="formatMoney(vendor.stats.revenue)"></div>
                                <div class="mt-1">
                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full" 
                                        :class="{
                                            'bg-green-100 text-green-800': vendor.status === 'Active',
                                            'bg-red-100 text-red-800': vendor.status === 'Deactive' || vendor.status === 'Ban',
                                            'bg-yellow-100 text-yellow-800': vendor.status === 'Suspend' || vendor.status === 'Pending'
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
            </div>
        </div>
    </div>

    {{-- SLIDE-OVER (SAME DESIGN, DYNAMIC DATA) --}}
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
                                            <span class="flex items-center"><svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg> <span x-text="activeVendor.city || 'NaN'"></span></span>
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
                                <button @click="currentTab = 'inventory'" :class="currentTab === 'inventory' ? 'bg-white text-gray-900 shadow' : 'text-gray-300 hover:text-white'" class="flex-1 rounded-lg py-2 text-sm font-medium transition">Inventory</button>
                                <button @click="currentTab = 'orders'" :class="currentTab === 'orders' ? 'bg-white text-gray-900 shadow' : 'text-gray-300 hover:text-white'" class="flex-1 rounded-lg py-2 text-sm font-medium transition">Orders</button>
                                <button @click="currentTab = 'finance'" :class="currentTab === 'finance' ? 'bg-white text-gray-900 shadow' : 'text-gray-300 hover:text-white'" class="flex-1 rounded-lg py-2 text-sm font-medium transition">Wallet</button>
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
                                            <p class="text-xs text-gray-500">Current status: <span x-text="activeVendor.status"></span></p>
                                        </div>
                                    </div>
                                    <div class="flex items-center justify-between py-2 pt-4">
                                        <div>
                                            <p class="text-sm font-medium text-gray-900">Commission Rate (%)</p>
                                            <p class="text-xs text-gray-500">Current platform fee per order.</p>
                                        </div>
                                        <div class="flex items-center">
                                            <input type="text" class="w-16 rounded border-gray-300 text-sm p-1 text-center font-bold" value="NaN" disabled>
                                            <span class="ml-2 text-gray-500">%</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- TAB: INVENTORY (NaN) --}}
                            <div x-show="currentTab === 'inventory'" class="space-y-4">
                                <div class="flex justify-between items-center">
                                    <h3 class="font-bold text-gray-800">Product List</h3>
                                    <span class="text-xs bg-indigo-100 text-indigo-800 px-2 py-1 rounded">NaN Total Items</span>
                                </div>
                                <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-10 text-center">
                                    <p class="text-gray-400">Inventory data not available (NaN).</p>
                                </div>
                            </div>

                            {{-- TAB: ORDERS (NaN) --}}
                            <div x-show="currentTab === 'orders'" class="space-y-4">
                                <h3 class="font-bold text-gray-800">Order Processing</h3>
                                <div class="bg-white border border-gray-200 rounded-xl p-10 shadow-sm text-center">
                                     <p class="text-gray-400">Order history not available (NaN).</p>
                                </div>
                            </div>

                             {{-- TAB: FINANCE (NaN) --}}
                             <div x-show="currentTab === 'finance'" class="space-y-6">
                                <div class="bg-gradient-to-br from-gray-800 to-black rounded-2xl p-6 text-white shadow-lg relative overflow-hidden">
                                    <div class="absolute top-0 right-0 -mt-4 -mr-4 w-24 h-24 bg-white opacity-10 rounded-full blur-xl"></div>
                                    <p class="text-xs text-gray-400 uppercase tracking-widest font-semibold">Current Wallet Balance</p>
                                    <h3 class="text-3xl font-bold mt-2 font-mono" x-text="formatMoney(activeVendor.wallet?.balance)"></h3>
                                    
                                    <div class="grid grid-cols-2 gap-4 mt-6 pt-6 border-t border-gray-700">
                                        <div>
                                            <p class="text-xs text-gray-400">Pending Clearance</p>
                                            <p class="text-lg font-bold text-yellow-400" x-text="formatMoney(activeVendor.wallet?.pending)"></p>
                                        </div>
                                        <div>
                                            <p class="text-xs text-gray-400">Last Payout</p>
                                            <p class="text-lg font-bold text-green-400" x-text="formatMoney(activeVendor.wallet?.last_payout)"></p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    {{-- MODAL KEPT SAME --}}
    </div>
@endsection