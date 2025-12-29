@extends('layouts.app')

@section('content')
{{-- 
    FIX APPLIED: 
    1. Added `isAddVendorModalOpen` to x-data.
    2. Added `selectedVendor` getter to populate the Sidebar with real data.
    3. Added extra dummy data (phone, address) to the vendor objects for the "Pro" sidebar view.
--}}
<div id="vendor-management-page" class="space-y-8 p-2 md:p-4 bg-gray-100 min-h-screen" 
    x-data="{ 
        // 1. Sidebar & Modal State
        openVendorId: null, 
        isAddVendorModalOpen: false, // <--- NEW: Modal State
        currentTab: 'profile',

        // 2. Filter State
        searchTerm: '',
        categoryFilter: '',
        statusFilter: '',
        stockAlertFilter: '',
        dateAddedFilter: '2025-12-01',
    
        // 3. Data Storage (Added phone/address for the Pro Sidebar view)
        vendors: [
            { id: 1001, name: 'SuperMart Groceries', category: 'Grocery', status: 'Active', rating: 4.8, reviews: '1.2k', orders: 45000, prepTime: 15, products: 1500, alerts: { oos: 12, low: 45 }, earnings: '120,500', pending: '1,200', contact: 'john.doe@email.com', phone: '+1 (555) 019-2834', address: '123 Market St, Denver, CO', dateAdded: '2025-11-20' },
            { id: 1002, name: 'Electro Tech', category: 'Electronics', status: 'Inactive', rating: 4.5, reviews: '800', orders: 20000, prepTime: 30, products: 500, alerts: { oos: 0, low: 10 }, earnings: '80,000', pending: '500', contact: 'jane.smith@email.com', phone: '+1 (555) 999-1122', address: '456 Tech Park, Austin, TX', dateAdded: '2025-12-05' },
            { id: 1003, name: 'Fashion Hub', category: 'Fashion', status: 'Active', rating: 4.9, reviews: '2.5k', orders: 60000, prepTime: 10, products: 3000, alerts: { oos: 0, low: 0 }, earnings: '250,000', pending: '0', contact: 'alex@fashion.com', phone: '+1 (555) 777-3344', address: '789 Style Ave, NY, NY', dateAdded: '2025-12-10' },
            { id: 1004, name: 'Quick Supplies', category: 'Grocery', status: 'Pending', rating: 4.1, reviews: '150', orders: 1000, prepTime: 45, products: 100, alerts: { oos: 25, low: 0 }, earnings: '5,000', pending: '100', contact: 'supplier@quick.com', phone: '+1 (555) 555-0000', address: '321 Bulk Rd, Miami, FL', dateAdded: '2025-11-15' },
        ],
    
        // 4. Filter/Search Logic
        get filteredVendors() {
            return this.vendors.filter(vendor => {
                const searchMatch = (
                    vendor.name.toLowerCase().includes(this.searchTerm.toLowerCase()) ||
                    vendor.id.toString().includes(this.searchTerm) ||
                    vendor.contact.toLowerCase().includes(this.searchTerm.toLowerCase())
                );
                const categoryMatch = this.categoryFilter === '' || vendor.category === this.categoryFilter;
                const statusMatch = this.statusFilter === '' || vendor.status === this.statusFilter;
                const stockMatch = (
                    this.stockAlertFilter === '' ||
                    (this.stockAlertFilter === 'OOS Only' && vendor.alerts.oos > 0) ||
                    (this.stockAlertFilter === 'Low Stock' && vendor.alerts.low > 0)
                );
                const dateMatch = new Date(vendor.dateAdded) <= new Date(this.dateAddedFilter);
                return searchMatch && categoryMatch && statusMatch && stockMatch && dateMatch;
            });
        },

        // <--- NEW: Helper to get the currently selected vendor object for the sidebar
        get selectedVendor() {
            return this.vendors.find(v => v.id === this.openVendorId) || {};
        },
        
        // 5. Reset Function
        resetFilters() {
            this.searchTerm = '';
            this.categoryFilter = '';
            this.statusFilter = '';
            this.stockAlertFilter = '';
            this.dateAddedFilter = '2025-12-01'; 
        }
    }" 
    x-cloak>

    {{-- 🎨 1. Header (Responsive) --}}
    <header class="flex flex-col sm:flex-row justify-between items-start sm:items-center pb-4">
        <div class="mb-4 sm:mb-0">
            <h1 class="text-3xl font-bold text-gray-900 flex items-center">
                <svg class="w-7 h-7 mr-3 text-indigo-600 flex-shrink-0" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M16 11V7a4 4 0 00-4-4V1m4 4h10v12c0 2.21-1.79 4-4 4H4a4 4 0 01-4-4V5c0-2.21 1.79-4 4-4h12V11zM7 9h.01M17 9h.01">
                    </path>
                </svg>
                Mart Vendor Management
            </h1>
            <p class="text-sm text-gray-500 mt-1 pl-10">Manage stores, inventory, pricing, and operations in a unified view.</p>
        </div>
        <div class="flex flex-wrap gap-3">
            {{-- CHANGE 1: Added @click to open the modal --}}
            <button @click="isAddVendorModalOpen = true"
                class="flex items-center px-4 py-2 text-sm font-semibold text-white bg-indigo-600 rounded-xl hover:bg-indigo-700 shadow-lg shadow-indigo-500/50 transition duration-300 ease-in-out transform hover:-translate-y-0.5">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                Add New Vendor
            </button>
            <button
                class="flex items-center px-4 py-2 text-sm font-semibold text-gray-700 bg-white border border-gray-300 rounded-xl hover:bg-gray-50 transition duration-150 ease-in-out shadow-sm">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12">
                    </path>
                </svg>
                Bulk Upload
            </button>
        </div>
    </header>

    {{-- 🎨 2. Dashboard Summary Cards (Original Layout Preserved) --}}
    <section class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-4 gap-2">
        @php
        $cards = [
        ['title' => 'Total Vendors', 'value' => '2,450', 'icon' => 'users', 'color' => 'indigo', 'trend' => '+12% MoM'],
        ['title' => 'Active Vendors', 'value' => '1,980', 'icon' => 'check-circle', 'color' => 'green', 'trend' => '85% Rate'],
        ['title' => 'Out-of-Stock Alerts', 'value' => '45', 'icon' => 'exclamation-triangle', 'color' => 'red', 'trend' => 'Urgent Action'],
        ['title' => 'Auto-Accept Enabled', 'value' => '1,500', 'icon' => 'cursor-click', 'color' => 'blue', 'trend' => '60% Coverage'],
        ['title' => 'Today’s Orders', 'value' => '3,120', 'icon' => 'shopping-bag', 'color' => 'yellow', 'trend' => '+5% YoY'],
        ['title' => 'Earnings Today', 'value' => '$15,400', 'icon' => 'cash', 'color' => 'teal', 'trend' => 'Stable'],
        ['title' => 'Top Category', 'value' => 'Grocery', 'icon' => 'store', 'color' => 'pink', 'trend' => 'High Demand'],
        ['title' => 'Pending Verifications', 'value' => '12', 'icon' => 'document-text', 'color' => 'orange', 'trend' => 'New Leads'],
        ];
        @endphp

        @foreach ($cards as $card)
        <div class="bg-white p-3 sm:p-4 rounded-xl shadow-lg hover:shadow-2xl transform hover:scale-[1.03] transition duration-300 ease-in-out border border-gray-100">
            <div class="flex items-center justify-between">
                <p class="text-xs font-semibold text-gray-500 truncate uppercase tracking-wider">{{ $card['title'] }}</p>
                <span class="text-[10px] font-bold text-{{ $card['color'] }}-500 hidden sm:block">{{ $card['trend'] }}</span>
            </div>
            <div class="flex items-end justify-between mt-1">
                <p class="text-xl sm:text-2xl font-bold text-gray-900">{{ $card['value'] }}</p>
                <svg class="w-6 h-6 text-{{ $card['color'] }}-400 opacity-70 hidden sm:block" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20v-2c0-.523-.086-1.056-.27-1.558L15 14l6-5m-6.702 1.48C14.18 10.59 15 11.135 15 12a3 3 0 11-6 0c0-.865.82-1.41 1.702-1.92l4.63-2.915a1 1 0 00.106-1.636l-.372-.25c-.27-.184-.633-.11-.82.16L12 9.45l-1.39-2.086a1 1 0 00-1.606-.098l-3 4c-.18.24-.28.52-.28.806a2 2 0 100 4v2c0 1.1.9 2 2 2h4.5a2 2 0 100-4h-4a.5.5 0 01-.5-.5v-1a.5.5 0 01.5-.5h2c.55 0 1-.45 1-1v-2c0-1.1-.9-2-2-2z"></path>
                </svg>
            </div>
        </div>
        @endforeach
    </section>

    {{-- 🎨 3. Main Content Area: Filters and Table (Original Layout Preserved) --}}
    <div class="bg-white p-4 sm:p-6 rounded-2xl shadow-2xl border border-gray-100">
        {{-- Filters --}}
        <div class="sticky top-0 z-20 bg-white pt-1 pb-4 -mx-4 sm:-mx-6 px-4 sm:px-4 border-b border-gray-100 shadow-sm rounded-t-xl">
            <h2 class="text-xl font-bold text-gray-800 mb-4">Vendor Directory</h2>
            <div class="grid grid-cols-2 sm:grid-cols-4 lg:grid-cols-4 gap-3 items-center">
                <div class="col-span-2 sm:col-span-2 lg:col-span-3 relative shadow-sm shadow-black/70">
                    <input type="text" placeholder="Search vendor name, ID, or contact..." class="block w-full text-sm pl-10 pr-4 py-2 border-gray-300 rounded-xl focus:ring-indigo-500 focus:border-indigo-500 shadow-sm transition duration-150" x-model.debounce.300ms="searchTerm" />
                    <svg class="absolute left-3 top-1/2 transform -translate-y-1/2 h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </div>
                <select class="col-span-2 form-select rounded-xl border-gray-300 shadow-sm shadow-black/50 py-2 px-3 focus:ring-indigo-500 focus:border-indigo-500" x-model="categoryFilter">
                    <option value="">All Categories</option>
                    <option value="Grocery">Grocery</option>
                    <option value="Electronics">Electronics</option>
                    <option value="Fashion">Fashion</option>
                </select>
                <select class="col-span-2 form-select rounded-xl border-gray-300 shadow-sm shadow-black/50 py-2 px-3 focus:ring-indigo-500 focus:border-indigo-500" x-model="statusFilter">
                    <option value="">All Statuses</option>
                    <option value="Active">Active</option>
                    <option value="Inactive">Inactive</option>
                    <option value="Pending">Pending</option>
                </select>
                <select class="col-span-1 form-select rounded-xl border-gray-300 shadow-sm shadow-black/50 py-2 px-4 focus:ring-indigo-500 focus:border-indigo-500" x-model="stockAlertFilter">
                    <option value="">Stock Alert</option>
                    <option value="OOS Only">OOS Only</option>
                    <option value="Low Stock">Low Stock</option>
                </select>
                <div class="col-span-2 hidden lg:block rounded-xl shadow-sm shadow-black/50 border-gray-300">
                    <input type="date" class="form-input w-full rounded-xl text-sm border-gray-300 shadow-sm py-2 px-3 focus:ring-indigo-500 focus:border-indigo-500" x-model="dateAddedFilter">
                </div>
                <div class="col-span-2 sm:col-span-1 flex justify-end">
                    <button @click="resetFilters" class="px-4 py-2 text-sm font-semibold text-gray-600 bg-gray-100 rounded-xl hover:bg-gray-200 transition duration-150 ease-in-out">
                        <span class="hidden sm:inline">Reset</span>
                        <svg class="w-4 h-4 sm:ml-1 inline-block" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.582a8.001 8.001 0 01-15.356-2m0 0H15"></path></svg>
                    </button>
                </div>
            </div>
        </div>

        {{-- Table --}}
        <div class="overflow-x-auto mt-4 rounded-xl border border-gray-200 shadow-md">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider min-w-[280px] sticky left-0 bg-gray-50 z-10 border-r border-gray-200">Vendor & Status</th>
                        <th class="px-4 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider min-w-[250px] lg:min-w-[450px]">Performance & Finance</th>
                        <th class="px-4 sm:px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider sticky right-0 bg-gray-50 z-10 border-l border-gray-200 min-w-[120px]">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-100">
                    <template x-for="vendor in filteredVendors" :key="vendor.id">
                        <tr class="hover:bg-indigo-50/50 transition duration-150 ease-in-out group">
                            <td class="px-4 sm:px-6 py-4 whitespace-nowrap sticky left-0 bg-white group-hover:bg-indigo-50/50 border-r border-gray-200 z-10">
                                <div class="flex items-center">
                                    <img class="h-10 w-10 rounded-lg object-cover shadow-md ring-1 ring-gray-200 mr-3 flex-shrink-0" :src="`https://via.placeholder.com/150/4f46e5/ffffff?text=${vendor.name.charAt(0)}`" :alt="vendor.name">
                                    <div>
                                        <div class="text-sm font-semibold text-gray-900 group-hover:text-indigo-600 truncate" x-text="vendor.name"></div>
                                        <div class="flex items-center text-xs space-x-2 mt-1">
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium" :class="{'bg-pink-100 text-pink-800': vendor.category === 'Grocery', 'bg-blue-100 text-blue-800': vendor.category === 'Electronics', 'bg-purple-100 text-purple-800': vendor.category === 'Fashion'}" x-text="vendor.category"></span>
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold" :class="{'bg-green-100 text-green-800': vendor.status === 'Active', 'bg-red-100 text-red-800': vendor.status === 'Inactive', 'bg-yellow-100 text-yellow-800': vendor.status === 'Pending'}" x-text="vendor.status"></span>
                                        </div>
                                        <div class="flex items-center mt-1 text-xs text-gray-600">
                                            <svg class="w-3 h-3 text-yellow-500 mr-1" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.012 8.73c-.783-.57-.381-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                                            <span x-text="`${vendor.rating} (${vendor.reviews} Reviews)`"></span>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 sm:px-6 py-4 text-sm text-gray-500">
                                <div class="grid grid-cols-2 gap-y-2 gap-x-4 w-full">
                                    <div>
                                        <p class="text-xs font-medium text-gray-400 uppercase">Orders / Prep</p>
                                        <p class="font-bold text-gray-700 text-sm" x-text="`${vendor.orders.toLocaleString()} Total`"></p>
                                        <p class="text-xs text-green-600" x-text="`Avg ${vendor.prepTime} mins`"></p>
                                    </div>
                                    <div>
                                        <p class="text-xs font-medium text-gray-400 uppercase">Inv / Alerts</p>
                                        <p class="font-bold text-gray-700 text-sm" x-text="`${vendor.products.toLocaleString()} Prods`"></p>
                                        <p class="text-xs" :class="{'text-red-500': vendor.alerts.oos > 0 || vendor.alerts.low > 0, 'text-gray-500': vendor.alerts.oos === 0}" x-text="`${vendor.alerts.oos} OOS`"></p>
                                    </div>
                                    <div class="col-span-2 border-t border-gray-100 pt-2">
                                        <p class="text-xs font-medium text-gray-400 uppercase">Earnings / Pending</p>
                                        <p class="font-extrabold text-lg text-indigo-700" x-text="`$${vendor.earnings}`"></p>
                                        <p class="text-xs text-red-500" x-text="`Pending: $${vendor.pending}`"></p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 sm:px-6 py-4 whitespace-nowrap text-right text-sm font-medium sticky right-0 bg-white border-l border-gray-200 group-hover:bg-indigo-50/50 z-10">
                                <div class="flex justify-end space-x-2">
                                    <button @click.stop="openVendorId = vendor.id; currentTab = 'profile'" class="p-2 rounded-full text-white bg-indigo-600 hover:bg-indigo-700 shadow-lg shadow-indigo-500/50 transition duration-150 ease-in-out transform hover:scale-105" title="View Full Details">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    </template>
                </tbody>
            </table>
            <div x-show="filteredVendors.length === 0" class="text-center py-10 text-gray-500 italic">No vendors match your current filter criteria.</div>
        </div>
    </div>

    {{-- 
        CHANGE 2: MODERN & PRO SIDEBAR 
        (Kept original wrapper, updated inner content to be "Pro") 
    --}}
    <div x-show="openVendorId !== null" x-transition:enter="ease-in-out duration-500"
        x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
        x-transition:leave="ease-in-out duration-500" x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0" class="fixed inset-0 overflow-hidden z-50" 
        aria-labelledby="slide-over-title" role="dialog" aria-modal="true" style="display: none;">

        <div class="absolute inset-0 overflow-hidden">
            <div x-show="openVendorId !== null" @click="openVendorId = null"
                class="absolute inset-0 bg-gray-900 bg-opacity-75 transition-opacity backdrop-blur-sm"></div>

            <div class="fixed inset-y-0 right-0 max-w-full flex">
                <div x-show="openVendorId !== null"
                    x-transition:enter="transform transition ease-in-out duration-500 sm:duration-700"
                    x-transition:enter-start="translate-x-full" x-transition:enter-end="translate-x-0"
                    x-transition:leave="transform transition ease-in-out duration-500 sm:duration-700"
                    x-transition:leave-start="translate-x-0" x-transition:leave-end="translate-x-full"
                    class="w-screen max-w-md md:max-w-xl lg:max-w-3xl">

                    <div class="h-full flex flex-col bg-white shadow-xl overflow-y-scroll">
                        
                        {{-- PRO Header --}}
                        <div class="relative bg-gray-900 pb-12 pt-8 px-6">
                            <div class="flex justify-between items-start">
                                <div class="flex items-center space-x-4">
                                    <div class="h-16 w-16 rounded-xl bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center text-white text-2xl font-bold shadow-lg" x-text="selectedVendor.name ? selectedVendor.name.charAt(0) : ''"></div>
                                    <div>
                                        <h2 class="text-2xl font-bold text-white tracking-tight" x-text="selectedVendor.name"></h2>
                                        <div class="flex items-center space-x-3 mt-1 text-gray-400 text-sm">
                                            <span x-text="selectedVendor.category"></span>
                                            <span>•</span>
                                            <span x-text="`Joined: ${selectedVendor.dateAdded}`"></span>
                                        </div>
                                    </div>
                                </div>
                                <button @click="openVendorId = null" class="text-gray-400 hover:text-white transition">
                                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                                </button>
                            </div>
                        </div>

                        {{-- Modern Tabs --}}
                        <div class="px-6 -mt-8 relative z-10">
                            <div class="bg-white rounded-lg shadow-md p-1 flex space-x-1 border border-gray-100">
                                <button @click="currentTab = 'profile'" :class="currentTab === 'profile' ? 'bg-indigo-50 text-indigo-700 shadow-sm' : 'text-gray-500 hover:bg-gray-50'" class="flex-1 py-2.5 rounded-md text-sm font-semibold transition-all">Profile</button>
                                <button @click="currentTab = 'inventory'" :class="currentTab === 'inventory' ? 'bg-indigo-50 text-indigo-700 shadow-sm' : 'text-gray-500 hover:bg-gray-50'" class="flex-1 py-2.5 rounded-md text-sm font-semibold transition-all">Inventory</button>
                                <button @click="currentTab = 'orders'" :class="currentTab === 'orders' ? 'bg-indigo-50 text-indigo-700 shadow-sm' : 'text-gray-500 hover:bg-gray-50'" class="flex-1 py-2.5 rounded-md text-sm font-semibold transition-all">Orders</button>
                                <button @click="currentTab = 'earnings'" :class="currentTab === 'earnings' ? 'bg-indigo-50 text-indigo-700 shadow-sm' : 'text-gray-500 hover:bg-gray-50'" class="flex-1 py-2.5 rounded-md text-sm font-semibold transition-all">Finance</button>
                            </div>
                        </div>

                        {{-- PRO Content Body --}}
                        <div class="p-6 flex-1 bg-gray-50/50 space-y-6">
                            
                            {{-- Tab: Profile --}}
                            <div x-show="currentTab === 'profile'" x-transition.opacity>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div class="bg-white p-5 rounded-xl border border-gray-200 shadow-sm">
                                        <p class="text-xs font-bold text-gray-400 uppercase">Operational Status</p>
                                        <div class="flex items-center mt-2">
                                            <span class="h-3 w-3 rounded-full mr-2" :class="selectedVendor.status === 'Active' ? 'bg-green-500' : 'bg-red-500'"></span>
                                            <span class="text-lg font-bold text-gray-800" x-text="selectedVendor.status"></span>
                                        </div>
                                    </div>
                                    <div class="bg-white p-5 rounded-xl border border-gray-200 shadow-sm">
                                        <p class="text-xs font-bold text-gray-400 uppercase">Customer Rating</p>
                                        <div class="flex items-center mt-2 text-yellow-500">
                                            <svg class="w-6 h-6 mr-1" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.012 8.73c-.783-.57-.381-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                            <span class="text-2xl font-bold text-gray-900 mr-2" x-text="selectedVendor.rating"></span>
                                            <span class="text-sm text-gray-500" x-text="`(${selectedVendor.reviews} reviews)`"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="bg-white rounded-xl border border-gray-200 shadow-sm mt-4 overflow-hidden">
                                    <div class="bg-gray-50 px-5 py-3 border-b border-gray-100">
                                        <h3 class="font-bold text-gray-700">Contact Details</h3>
                                    </div>
                                    <div class="p-5 space-y-4">
                                        <div class="flex items-center">
                                            <div class="w-8 flex-shrink-0 text-gray-400"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg></div>
                                            <span class="text-sm text-gray-700 font-medium" x-text="selectedVendor.contact"></span>
                                        </div>
                                        <div class="flex items-center">
                                            <div class="w-8 flex-shrink-0 text-gray-400"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg></div>
                                            <span class="text-sm text-gray-700" x-text="selectedVendor.phone || 'No phone registered'"></span>
                                        </div>
                                        <div class="flex items-center">
                                            <div class="w-8 flex-shrink-0 text-gray-400"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg></div>
                                            <span class="text-sm text-gray-700" x-text="selectedVendor.address || 'No address registered'"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Tab: Inventory --}}
                            <div x-show="currentTab === 'inventory'" x-transition.opacity>
                                <div class="bg-white p-6 rounded-xl border border-gray-200 shadow-sm">
                                    <div class="flex justify-between items-end mb-4">
                                        <div>
                                            <p class="text-sm text-gray-500">Total Products</p>
                                            <p class="text-3xl font-bold text-gray-900" x-text="selectedVendor.products"></p>
                                        </div>
                                        <div class="text-right">
                                            <span class="inline-block bg-red-100 text-red-800 text-xs px-2 py-1 rounded font-bold" x-text="`${selectedVendor.alerts?.oos || 0} Out of Stock`"></span>
                                        </div>
                                    </div>
                                    <div class="w-full bg-gray-100 rounded-full h-4 mb-2 overflow-hidden flex">
                                        <div class="bg-green-500 h-4" style="width: 85%"></div>
                                        <div class="bg-yellow-400 h-4" style="width: 10%"></div>
                                        <div class="bg-red-500 h-4" style="width: 5%"></div>
                                    </div>
                                    <div class="flex justify-between text-xs text-gray-500 mt-2">
                                        <span class="flex items-center"><span class="w-2 h-2 bg-green-500 rounded-full mr-1"></span> In Stock</span>
                                        <span class="flex items-center"><span class="w-2 h-2 bg-yellow-400 rounded-full mr-1"></span> Low Stock</span>
                                        <span class="flex items-center"><span class="w-2 h-2 bg-red-500 rounded-full mr-1"></span> OOS</span>
                                    </div>
                                </div>
                            </div>

                            {{-- Tab: Orders --}}
                            <div x-show="currentTab === 'orders'" x-transition.opacity>
                                <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-5">
                                    <h4 class="font-bold text-gray-800 mb-6">Recent Activity</h4>
                                    <div class="border-l-2 border-gray-200 ml-3 space-y-8">
                                        <div class="relative pl-8">
                                            <span class="absolute -left-[9px] top-0 h-4 w-4 rounded-full bg-green-500 border-2 border-white shadow"></span>
                                            <p class="text-sm font-bold text-gray-900">Order Completed #9921</p>
                                            <p class="text-xs text-gray-500">2 hours ago • $120.00</p>
                                        </div>
                                        <div class="relative pl-8">
                                            <span class="absolute -left-[9px] top-0 h-4 w-4 rounded-full bg-blue-500 border-2 border-white shadow"></span>
                                            <p class="text-sm font-bold text-gray-900">New Order Received #9922</p>
                                            <p class="text-xs text-gray-500">5 hours ago • $45.50</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                             {{-- Tab: Earnings --}}
                             <div x-show="currentTab === 'earnings'" x-transition.opacity>
                                <div class="bg-gradient-to-r from-gray-900 to-gray-800 rounded-xl p-6 text-white shadow-lg">
                                    <p class="text-gray-400 text-xs uppercase tracking-widest">Total Earnings</p>
                                    <h3 class="text-3xl font-bold mt-1" x-text="`$${selectedVendor.earnings}`"></h3>
                                    <div class="mt-6 pt-6 border-t border-gray-700 flex justify-between items-center">
                                        <div>
                                            <p class="text-xs text-gray-400">Available for Withdrawal</p>
                                            <p class="text-lg font-bold text-green-400" x-text="`$${selectedVendor.pending}`"></p>
                                        </div>
                                        <button class="bg-white text-gray-900 text-xs font-bold px-3 py-2 rounded shadow hover:bg-gray-100">Request Payout</button>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- 
        CHANGE 1: NEW "ADD VENDOR" MODAL 
        (Modern, centered, backdrop blur) 
    --}}
    <div x-show="isAddVendorModalOpen" style="display: none;" 
        class="fixed inset-0 z-[60] overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        
        <div x-show="isAddVendorModalOpen" 
            x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" 
            x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
            class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm transition-opacity" @click="isAddVendorModalOpen = false"></div>

        <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">
            <div x-show="isAddVendorModalOpen"
                x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" 
                x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                class="relative transform overflow-hidden rounded-2xl bg-white text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-xl">
                
                <div class="bg-gray-50 px-4 py-5 sm:px-6 border-b border-gray-100 flex justify-between items-center">
                    <div>
                        <h3 class="text-lg font-bold leading-6 text-gray-900">Add New Vendor</h3>
                        <p class="mt-1 text-sm text-gray-500">Enter details to onboard a new partner.</p>
                    </div>
                    <button @click="isAddVendorModalOpen = false" class="text-gray-400 hover:text-gray-600">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                    </button>
                </div>

                <div class="px-6 py-6 space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Vendor Name</label>
                        <input type="text" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm p-2.5 border" placeholder="e.g. Fresh Foods Ltd.">
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Category</label>
                            <select class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm p-2.5 border">
                                <option>Grocery</option>
                                <option>Electronics</option>
                                <option>Fashion</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Status</label>
                            <select class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm p-2.5 border">
                                <option>Active</option>
                                <option>Pending Verification</option>
                                <option>Inactive</option>
                            </select>
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Email Address</label>
                        <input type="email" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm p-2.5 border" placeholder="contact@vendor.com">
                    </div>
                </div>

                <div class="bg-gray-50 px-6 py-4 flex flex-row-reverse">
                    <button type="button" @click="isAddVendorModalOpen = false" class="inline-flex w-full justify-center rounded-xl bg-indigo-600 px-4 py-2 text-base font-medium text-white shadow-sm hover:bg-indigo-700 sm:ml-3 sm:w-auto sm:text-sm">Create Vendor</button>
                    <button type="button" @click="isAddVendorModalOpen = false" class="mt-3 inline-flex w-full justify-center rounded-xl border border-gray-300 bg-white px-4 py-2 text-base font-medium text-gray-700 shadow-sm hover:bg-gray-50 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">Cancel</button>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection

@push('styles')
<style>
    .shadow-lg { box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.05), 0 4px 6px -2px rgba(0, 0, 0, 0.02); }
    .shadow-2xl { box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.15); }
    [x-cloak] { display: none !important; }
</style>
@endpush