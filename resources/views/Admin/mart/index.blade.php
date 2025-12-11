@extends('layouts.app')

{{-- Assume 'app' layout includes necessary Tailwind CSS and Alpine.js setup --}}

@section('content')
    {{-- 
    1. x-data for the slide-over is at the top. 
    2. openVendorId holds the ID of the vendor to show. 
    3. currentTab manages the active tab in the slide-over. 
--}}
    <div id="vendor-management-page" class="space-y-8 p-2 md:p-4 bg-gray-100 min-h-screen" x-data="{ openVendorId: null, currentTab: 'profile' }" x-cloak>

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
                <p class="text-sm text-gray-500 mt-1 pl-10">Manage stores, inventory, pricing, and operations in a unified
                    view.</p>
            </div>
            <div class="flex flex-wrap gap-3"> {{-- Use flex-wrap and gap for responsive buttons --}}
                <button
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



        {{-- 🎨 2. Dashboard Summary Cards (Slightly more compact, eight-column grid) --}}
        <section class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-4 gap-2">
            @php
                $cards = [
                    [
                        'title' => 'Total Vendors',
                        'value' => '2,450',
                        'icon' => 'users',
                        'color' => 'indigo',
                        'trend' => '+12% MoM',
                    ],
                    [
                        'title' => 'Active Vendors',
                        'value' => '1,980',
                        'icon' => 'check-circle',
                        'color' => 'green',
                        'trend' => '85% Rate',
                    ],
                    [
                        'title' => 'Out-of-Stock Alerts',
                        'value' => '45',
                        'icon' => 'exclamation-triangle',
                        'color' => 'red',
                        'trend' => 'Urgent Action',
                    ],
                    [
                        'title' => 'Auto-Accept Enabled',
                        'value' => '1,500',
                        'icon' => 'cursor-click',
                        'color' => 'blue',
                        'trend' => '60% Coverage',
                    ],
                    [
                        'title' => 'Today’s Orders',
                        'value' => '3,120',
                        'icon' => 'shopping-bag',
                        'color' => 'yellow',
                        'trend' => '+5% YoY',
                    ],
                    [
                        'title' => 'Earnings Today',
                        'value' => '$15,400',
                        'icon' => 'cash',
                        'color' => 'teal',
                        'trend' => 'Stable',
                    ],
                    [
                        'title' => 'Top Category',
                        'value' => 'Grocery',
                        'icon' => 'store',
                        'color' => 'pink',
                        'trend' => 'High Demand',
                    ],
                    [
                        'title' => 'Pending Verifications',
                        'value' => '12',
                        'icon' => 'document-text',
                        'color' => 'orange',
                        'trend' => 'New Leads',
                    ],
                ];
            @endphp

            @foreach ($cards as $card)
                <div
                    class="bg-white p-3 sm:p-4 rounded-xl shadow-lg hover:shadow-2xl transform hover:scale-[1.03] transition duration-300 ease-in-out border border-gray-100">
                    <div class="flex items-center justify-between">
                        <p class="text-xs font-semibold text-gray-500 truncate uppercase tracking-wider">
                            {{ $card['title'] }}</p>
                        <span
                            class="text-[10px] font-bold text-{{ $card['color'] }}-500 hidden sm:block">{{ $card['trend'] }}</span>
                    </div>
                    <div class="flex items-end justify-between mt-1">
                        <p class="text-xl sm:text-2xl font-bold text-gray-900">{{ $card['value'] }}</p>
                        {{-- Placeholder for a dynamic icon based on $card['icon'] --}}
                        <svg class="w-6 h-6 text-{{ $card['color'] }}-400 opacity-70 hidden sm:block" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20v-2c0-.523-.086-1.056-.27-1.558L15 14l6-5m-6.702 1.48C14.18 10.59 15 11.135 15 12a3 3 0 11-6 0c0-.865.82-1.41 1.702-1.92l4.63-2.915a1 1 0 00.106-1.636l-.372-.25c-.27-.184-.633-.11-.82.16L12 9.45l-1.39-2.086a1 1 0 00-1.606-.098l-3 4c-.18.24-.28.52-.28.806a2 2 0 100 4v2c0 1.1.9 2 2 2h4.5a2 2 0 100-4h-4a.5.5 0 01-.5-.5v-1a.5.5 0 01.5-.5h2c.55 0 1-.45 1-1v-2c0-1.1-.9-2-2-2z">
                            </path>
                        </svg>
                    </div>
                </div>
            @endforeach
        </section>


        {{-- 🎨 3. Main Content Area: Filters and Table --}}
        <div class="bg-white p-4 sm:p-6 rounded-2xl shadow-2xl border border-gray-100" x-data="{
            // 1. Filter State
            searchTerm: '',
            categoryFilter: '',
            statusFilter: '',
            stockAlertFilter: '',
            dateAddedFilter: '2025-12-01', // Initial value from your HTML
            openVendorId: null, // For view details button
        
            // 2. Data Storage (Will be populated by x-init)
            vendors: [],
        
            // 3. Filter/Search Logic
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
        
                    // For date filtering (simple example: only show vendors added before the selected date)
                    const dateMatch = new Date(vendor.dateAdded) <= new Date(this.dateAddedFilter);
        
        
                    return searchMatch && categoryMatch && statusMatch && stockMatch && dateMatch;
                });
            },
        
            // 4. Reset Function
            resetFilters() {
                this.searchTerm = '';
                this.categoryFilter = '';
                this.statusFilter = '';
                this.stockAlertFilter = '';
                this.dateAddedFilter = '2025-12-01'; // Reset to initial date
            }
        }"
            x-init="// 5. Initial Data Load (Simulate data fetch)
            vendors = [
                { id: 1001, name: 'SuperMart Groceries', category: 'Grocery', status: 'Active', rating: 4.8, reviews: '1.2k', orders: 45000, prepTime: 15, products: 1500, alerts: { oos: 12, low: 45 }, earnings: '120,500', pending: '1,200', contact: 'john.doe@email.com', dateAdded: '2025-11-20' },
                { id: 1002, name: 'Electro Tech', category: 'Electronics', status: 'Inactive', rating: 4.5, reviews: '800', orders: 20000, prepTime: 30, products: 500, alerts: { oos: 0, low: 10 }, earnings: '80,000', pending: '500', contact: 'jane.smith@email.com', dateAdded: '2025-12-05' },
                { id: 1003, name: 'Fashion Hub', category: 'Fashion', status: 'Active', rating: 4.9, reviews: '2.5k', orders: 60000, prepTime: 10, products: 3000, alerts: { oos: 0, low: 0 }, earnings: '250,000', pending: '0', contact: 'alex@fashion.com', dateAdded: '2025-12-10' },
                { id: 1004, name: 'Quick Supplies', category: 'Grocery', status: 'Pending', rating: 4.1, reviews: '150', orders: 1000, prepTime: 45, products: 100, alerts: { oos: 25, low: 0 }, earnings: '5,000', pending: '100', contact: 'supplier@quick.com', dateAdded: '2025-11-15' },
            ];">

            {{-- 🎨 3.1. Filters / Search Bar (Improved Responsiveness) --}}
            <div
                class="sticky top-0 z-20 bg-white pt-1 pb-4 -mx-4 sm:-mx-6 px-4 sm:px-4 border-b border-gray-100 shadow-sm rounded-t-xl">
                <h2 class="text-xl font-bold text-gray-800 mb-4">Vendor Directory</h2>
                <div class="grid grid-cols-2 sm:grid-cols-4 lg:grid-cols-4 gap-3 items-center">

                    {{-- Search (Col-span 3 for prominence) --}}
                    <div class="col-span-2 sm:col-span-2 lg:col-span-3 relative shadow-sm shadow-black/70">
                        <input type="text" placeholder="Search vendor name, ID, or contact..."
                            class="block w-full text-sm pl-10 pr-4 py-2 border-gray-300 rounded-xl focus:ring-indigo-500 focus:border-indigo-500 shadow-sm transition duration-150"
                            x-model.debounce.300ms="searchTerm" {{-- ** Alpine.js Binding ** --}} />
                        <svg class="absolute left-3 top-1/2 transform -translate-y-1/2 h-4 w-4 text-gray-400" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>

                    {{-- Filters (More standardized look) --}}
                    <select
                        class="col-span-2 form-select rounded-xl border-gray-300 shadow-sm shadow-black/50 py-2 px-3 focus:ring-indigo-500 focus:border-indigo-500"
                        x-model="categoryFilter" {{-- ** Alpine.js Binding ** --}}>
                        <option value="">All Categories</option>
                        <option value="Grocery">Grocery</option>
                        <option value="Electronics">Electronics</option>
                        <option value="Fashion">Fashion</option>
                    </select>
                    <select
                        class="col-span-2 form-select rounded-xl border-gray-300 shadow-sm shadow-black/50 py-2 px-3 focus:ring-indigo-500 focus:border-indigo-500"
                        x-model="statusFilter" {{-- ** Alpine.js Binding ** --}}>
                        <option value="">All Statuses</option>
                        <option value="Active">Active</option>
                        <option value="Inactive">Inactive</option>
                        <option value="Pending">Pending</option>
                    </select>
                    <select
                        class="col-span-1 form-select rounded-xl border-gray-300 shadow-sm shadow-black/50 py-2 px-4 focus:ring-indigo-500 focus:border-indigo-500"
                        x-model="stockAlertFilter" {{-- ** Alpine.js Binding ** --}}>
                        <option value="">Stock Alert</option>
                        <option value="OOS Only">OOS Only</option>
                        <option value="Low Stock">Low Stock</option>
                    </select>

                    {{-- Date Added (Hidden on smaller screens to save space) --}}
                    <div class="col-span-2 hidden lg:block rounded-xl shadow-sm shadow-black/50 border-gray-300">
                        <input type="date"
                            class="form-input w-full rounded-xl text-sm border-gray-300 shadow-sm py-2 px-3 focus:ring-indigo-500 focus:border-indigo-500"
                            x-model="dateAddedFilter" {{-- ** Alpine.js Binding ** --}}>
                    </div>

                    {{-- Reset Button (Right-aligned) --}}
                    <div class="col-span-2 sm:col-span-1 flex justify-end">
                        <button @click="resetFilters" {{-- ** Alpine.js Action ** --}}
                            class="px-4 py-2 text-sm font-semibold text-gray-600 bg-gray-100 rounded-xl hover:bg-gray-200 transition duration-150 ease-in-out">
                            <span class="hidden sm:inline">Reset</span>
                            <svg class="w-4 h-4 sm:ml-1 inline-block" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.582a8.001 8.001 0 01-15.356-2m0 0H15">
                                </path>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            {{-- 🎨 3.2. Vendor List Table (Optimized Visibility/Scrolling) --}}
            <div class="overflow-x-auto mt-4 rounded-xl border border-gray-200 shadow-md">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            {{-- Col 1: Vendor & Category (Sticky Left) --}}
                            <th
                                class="px-4 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider min-w-[280px] sticky left-0 bg-gray-50 z-10 border-r border-gray-200">
                                Vendor & Status
                            </th>

                            {{-- Col 2: Key Metrics (Responsive) --}}
                            <th
                                class="px-4 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider min-w-[250px] lg:min-w-[450px]">
                                Performance & Finance
                            </th>

                            {{-- Col 3: Actions (Sticky Right) --}}
                            <th
                                class="px-4 sm:px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider sticky right-0 bg-gray-50 z-10 border-l border-gray-200 min-w-[120px]">
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-100">

                        {{-- ** Alpine.js Loop & Filter ** --}}
                        <template x-for="vendor in filteredVendors" :key="vendor.id">
                            <tr class="hover:bg-indigo-50/50 transition duration-150 ease-in-out group">

                                {{-- COL 1: Vendor Info & Status (Sticky Left) --}}
                                <td
                                    class="px-4 sm:px-6 py-4 whitespace-nowrap sticky left-0 bg-white group-hover:bg-indigo-50/50 border-r border-gray-200 z-10">
                                    <div class="flex items-center">
                                        <img class="h-10 w-10 rounded-lg object-cover shadow-md ring-1 ring-gray-200 mr-3 flex-shrink-0"
                                            :src="`https://via.placeholder.com/150/4f46e5/ffffff?text=${vendor.name.charAt(0)}${vendor.name.split(' ')[1] ? vendor.name.split(' ')[1].charAt(0) : ''}`"
                                            :alt="`${vendor.name} Logo`">
                                        <div>
                                            <div class="text-sm font-semibold text-gray-900 group-hover:text-indigo-600 truncate"
                                                x-text="vendor.name">
                                            </div>
                                            <div class="flex items-center text-xs space-x-2 mt-1">
                                                <span
                                                    class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium"
                                                    :class="{
                                                        'bg-pink-100 text-pink-800': vendor.category === 'Grocery',
                                                        'bg-blue-100 text-blue-800': vendor.category === 'Electronics',
                                                        'bg-purple-100 text-purple-800': vendor.category === 'Fashion'
                                                    }"
                                                    x-text="vendor.category">
                                                </span>
                                                <span
                                                    class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold"
                                                    :class="{
                                                        'bg-green-100 text-green-800': vendor.status === 'Active',
                                                        'bg-red-100 text-red-800': vendor.status === 'Inactive',
                                                        'bg-yellow-100 text-yellow-800': vendor.status === 'Pending'
                                                    }"
                                                    x-text="vendor.status">
                                                </span>
                                            </div>
                                            <div class="flex items-center mt-1 text-xs text-gray-600">
                                                <svg class="w-3 h-3 text-yellow-500 mr-1" fill="currentColor"
                                                    viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                    <path
                                                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.012 8.73c-.783-.57-.381-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                                                    </path>
                                                </svg>
                                                <span x-text="`${vendor.rating} (${vendor.reviews} Reviews)`"></span>
                                            </div>
                                        </div>
                                    </div>
                                </td>

                                {{-- COL 2: Key Metrics & Financials (Stacked) --}}
                                <td class="px-4 sm:px-6 py-4 text-sm text-gray-500">
                                    <div class="grid grid-cols-2 gap-y-2 gap-x-4 w-full">
                                        {{-- Orders/Packing --}}
                                        <div>
                                            <p class="text-xs font-medium text-gray-400 uppercase">Orders / Prep Time</p>
                                            <p class="font-bold text-gray-700 text-sm"
                                                x-text="`${vendor.orders.toLocaleString()} Total`"></p>
                                            <p class="text-xs text-green-600" x-text="`Avg ${vendor.prepTime} mins`"></p>
                                        </div>
                                        {{-- Inventory --}}
                                        <div>
                                            <p class="text-xs font-medium text-gray-400 uppercase">Inventory / Alerts</p>
                                            <p class="font-bold text-gray-700 text-sm"
                                                x-text="`${vendor.products.toLocaleString()} Products`"></p>
                                            <p class="text-xs"
                                                :class="{
                                                    'text-red-500': vendor.alerts.oos > 0 || vendor.alerts.low >
                                                        0,
                                                    'text-gray-500': vendor.alerts.oos === 0 && vendor.alerts.low ===
                                                        0
                                                }"
                                                x-text="`${vendor.alerts.oos} OOS / ${vendor.alerts.low} Low`">
                                            </p>
                                        </div>
                                        {{-- Finance (Full width) --}}
                                        <div class="col-span-2 border-t border-gray-100 pt-2">
                                            <p class="text-xs font-medium text-gray-400 uppercase">Total Earnings / Pending
                                            </p>
                                            <p class="font-extrabold text-lg text-indigo-700"
                                                x-text="`$${vendor.earnings}`"></p>
                                            <p class="text-xs text-red-500"
                                                x-text="`Pending Withdrawal: $${vendor.pending}`"></p>
                                        </div>
                                    </div>
                                </td>

                                {{-- COL 3: Actions (Sticky Right) --}}
                                <td
                                    class="px-4 sm:px-6 py-4 whitespace-nowrap text-right text-sm font-medium sticky right-0 bg-white border-l border-gray-200 group-hover:bg-indigo-50/50 z-10">
                                    <div class="flex justify-end space-x-2">
                                        {{-- View Details Button is the primary action --}}
                                        <button @click.stop="openVendorId = vendor.id; currentTab = 'profile'"
                                            class="p-2 rounded-full text-white bg-indigo-600 hover:bg-indigo-700 shadow-lg shadow-indigo-500/50 transition duration-150 ease-in-out transform hover:scale-105"
                                            title="View Full Details">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                                </path>
                                            </svg>
                                        </button>
                                        {{-- Edit Button (Less prominent) --}}
                                        <button
                                            class="p-2 rounded-full text-gray-500 hover:bg-gray-100 transition duration-150 ease-in-out hidden sm:block"
                                            title="Edit Store">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z">
                                                </path>
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        </template>
                        {{-- ** End Alpine.js Loop & Filter ** --}}

                    </tbody>
                </table>

                {{-- No Results Message --}}
                <div x-show="filteredVendors.length === 0" class="text-center py-10 text-gray-500 italic">
                    No vendors match your current filter criteria. Try adjusting your search or filters.
                </div>
            </div>
        </div>

        {{-- 🎨 4. Vendor Details Slide-Over Panel (Perfected Animations and State) --}}
        <div x-show="openVendorId !== null" x-transition:enter="ease-in-out duration-500"
            x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
            x-transition:leave="ease-in-out duration-500" x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0" class="fixed inset-0 overflow-hidden z-50" {{-- Increased Z-index to 50 --}}
            aria-labelledby="slide-over-title" role="dialog" aria-modal="true">

            <div class="absolute inset-0 overflow-hidden">
                {{-- Background overlay --}}
                <div x-show="openVendorId !== null" @click="openVendorId = null"
                    class="absolute inset-0 bg-gray-900 bg-opacity-75 transition-opacity"></div>

                <div class="fixed inset-y-0 right-0 max-w-full flex">
                    {{-- Slide-over panel (Wider on Lg/Xl screens) --}}
                    <div x-show="openVendorId !== null"
                        x-transition:enter="transform transition ease-in-out duration-500 sm:duration-700"
                        x-transition:enter-start="translate-x-full" x-transition:enter-end="translate-x-0"
                        x-transition:leave="transform transition ease-in-out duration-500 sm:duration-700"
                        x-transition:leave-start="translate-x-0" x-transition:leave-end="translate-x-full"
                        class="w-screen max-w-md md:max-w-xl lg:max-w-3xl xl:max-w-4xl">

                        <div class="h-full flex flex-col bg-white shadow-xl overflow-y-scroll">
                            <div class="p-4 sm:p-6 bg-indigo-600 sticky top-0 z-20"> {{-- Sticky header for the panel --}}
                                {{-- Header and Close Button --}}
                                <div class="flex items-start justify-between">
                                    <h2 id="slide-over-title" class="text-lg sm:text-xl font-bold text-white">
                                        Full Vendor Details (ID: <span x-text="openVendorId"></span>)
                                    </h2>
                                    <button type="button"
                                        class="rounded-md text-indigo-200 hover:text-white transition duration-150"
                                        @click="openVendorId = null">
                                        <span class="sr-only">Close panel</span>
                                        <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </button>
                                </div>
                            </div>

                            {{-- Tabbed Navigation for Details --}}
                            <nav
                                class="flex space-x-4 px-6 pt-4 border-b border-gray-200 sticky top-[68px] bg-white z-10 overflow-x-auto">
                                {{-- Adjusted top for sticky header --}}
                                @php
                                    $tabs = [
                                        'Profile',
                                        'Inventory',
                                        'Pricing & Offers',
                                        'Orders',
                                        'Earnings',
                                        'Admin Tools',
                                    ];
                                @endphp
                                @foreach ($tabs as $tab)
                                    <button @click="currentTab = '{{ strtolower(str_replace(' ', '-', $tab)) }}'"
                                        :class="{ 'border-indigo-600 text-indigo-700 font-semibold': currentTab === '{{ strtolower(str_replace(' ', '-', $tab)) }}', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': currentTab !== '{{ strtolower(str_replace(' ', '-', $tab)) }}' }"
                                        class="whitespace-nowrap pb-3 px-1 border-b-2 text-sm transition duration-150 ease-in-out">
                                        {{ $tab }}
                                    </button>
                                @endforeach
                            </nav>

                            <div class="p-6 flex-1 overflow-y-auto">
                                {{-- Tab Content Containers --}}
                                <div x-show="currentTab === 'profile'" class="space-y-6">
                                    <h3 class="text-xl font-bold text-gray-900">Vendor Profile</h3>
                                    <p class="text-gray-600">This section would contain vendor contact info, registration
                                        details, KYC/business documents, and general status settings.</p>
                                    {{-- Add more detailed content here --}}
                                </div>
                                <div x-show="currentTab === 'inventory'" class="space-y-6">
                                    <h3 class="text-xl font-bold text-gray-900">Inventory Overview</h3>
                                    <p class="text-gray-600">A high-level view of product counts, stock alerts, last sync
                                        time, and options for bulk inventory actions.</p>
                                </div>
                                <div x-show="currentTab === 'pricing-&-offers'" class="space-y-6">
                                    <h3 class="text-xl font-bold text-gray-900">Pricing & Promotions</h3>
                                    <p class="text-gray-600">Management interface for vendor-set prices, active discounts,
                                        flash sale eligibility, and commission structure details.</p>
                                </div>
                                <div x-show="currentTab === 'orders'" class="space-y-6">
                                    <h3 class="text-xl font-bold text-gray-900">Order History</h3>
                                    <p class="text-gray-600">A dedicated view of all recent and historical orders,
                                        cancellation rates, and fulfilment statistics.</p>
                                </div>
                                <div x-show="currentTab === 'earnings'" class="space-y-6">
                                    <h3 class="text-xl font-bold text-gray-900">Financial Ledger</h3>
                                    <p class="text-gray-600">Detailed breakdown of gross sales, commission deductions, net
                                        earnings, and withdrawal history/status.</p>
                                </div>
                                <div x-show="currentTab === 'admin-tools'" class="space-y-6">
                                    <h3 class="text-xl font-bold text-gray-900">Administrative Actions</h3>
                                    <p class="text-gray-600">Buttons and forms for high-privilege actions like suspending
                                        account, resetting password, forcing inventory sync, or updating delivery zones.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection

@push('styles')
    <style>
        /* Modernized shadows */
        .shadow-lg {
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.05), 0 4px 6px -2px rgba(0, 0, 0, 0.02);
        }

        .shadow-2xl {
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.15);
        }

        /* Alpine cloak for smooth transitions */
        [x-cloak] {
            display: none !important;
        }
    </style>
@endpush

@push('scripts')
    {{-- Alpine.js is assumed to be included globally --}}
@endpush
