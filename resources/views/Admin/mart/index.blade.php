@extends('layouts.app')

@section('head')
{{-- Font Awesome CDN --}}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
<style>
    /* Hide scrollbar for Chrome, Safari and Opera */
    .scrollbar-hide::-webkit-scrollbar {
        display: none;
    }
    /* Hide scrollbar for IE, Edge and Firefox */
    .scrollbar-hide {
        -ms-overflow-style: none;  /* IE and Edge */
        scrollbar-width: none;  /* Firefox */
    }
</style>
@endsection

@section('content')
<div class="min-h-screen bg-gray-50/50 p-6 space-y-8" x-data="{
    openVendorId: null,
    isAddVendorModalOpen: false,
    currentTab: 'overview',
    searchTerm: '',
    categoryFilter: '',
    statusFilter: '',
    isSubmitting: false,
    vendors: {{ $vendors->toJson() }}, 

    get filteredVendors() {
        return this.vendors.filter(v => {
            const search = this.searchTerm.toLowerCase();
            const nameMatch = v.name ? v.name.toLowerCase().includes(search) : false;
            const ownerMatch = v.owner ? v.owner.toLowerCase().includes(search) : false;

            const matchesSearch = nameMatch || ownerMatch;
            const matchesCategory = this.categoryFilter === '' || v.category === this.categoryFilter;
            const matchesStatus = this.statusFilter === '' || v.status === this.statusFilter;

            return matchesSearch && matchesCategory && matchesStatus;
        });
    },

    get activeVendor() {
        const v = this.vendors.find(v => v.id === this.openVendorId) || {};
        // Merging Dummy Data for UI Consistency
        return {
            ...v,
            address: v.address || { 
                current: 'Shop #42, Main Market, Sector G-11', 
                warehouse: 'Plot 55, Industrial Area', 
                city: v.city || 'Islamabad' 
            },
            wallet: v.wallet || { 
                balance: 154000, 
                pending: 12500, 
                withdrawn: 450000 
            },
            // --- NEW: Dummy Products Data ---
            products: v.products || [
                { id: 101, name: 'Super Basmati Rice 5kg', category: 'Grains', price: 3450, stock: 45, sold: 1240, rating: 4.8, image: '🍚' },
                { id: 102, name: 'Pure Organic Honey', category: 'Groceries', price: 1200, stock: 12, sold: 85, rating: 4.5, image: '🍯' },
                { id: 103, name: 'Dairy Milk Chocolate', category: 'Snacks', price: 250, stock: 0, sold: 5000, rating: 4.9, image: '🍫' },
                { id: 104, name: 'Shan Biryani Masala', category: 'Spices', price: 180, stock: 200, sold: 3200, rating: 4.7, image: '🌶️' },
            ],
            // --------------------------------
            payment_methods: v.payment_methods || ['Meezan Bank **** 1234', 'JazzCash Merchant'],
            portfolio_items: v.portfolio_items || []
        };
    },

    formatMoney(amount) {
        if (!amount) return 'PKR 0';
        return 'PKR ' + Number(amount).toLocaleString();
    },

    async submitForm(e) {
        // ... (existing submit logic) ...
        this.isSubmitting = true;
        const formData = new FormData(e.target);
        const actionUrl = e.target.action;

        try {
            const response = await fetch(actionUrl, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            });
            const result = await response.json();

            if (response.ok) {
                alert('Vendor Onboarded Successfully!');
                this.isAddVendorModalOpen = false;
                location.reload();
            } else {
                let errorMsg = result.message || 'Validation failed';
                if (result.errors) {
                    errorMsg = Object.values(result.errors).flat().join('\n');
                }
                alert(errorMsg);
            }
        } catch (error) {
            console.error('Error:', error);
            alert('Server connection failed. Please try again.');
        } finally {
            this.isSubmitting = false;
        }
    }
}" x-cloak>

    {{-- 1. HEADER (Unchanged) --}}
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 tracking-tight">Mart Vendors</h1>
            <p class="text-sm text-gray-500">Manage Section 4.0: Inventory, Orders, and Payouts</p>
        </div>
        <div class="flex gap-3">
             <button class="inline-flex items-center justify-center px-4 py-2 bg-white border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 transition shadow-sm">
                <i class="fa-solid fa-download mr-2"></i> Export
            </button>
            <button @click="isAddVendorModalOpen = true" class="inline-flex items-center justify-center px-4 py-2 bg-indigo-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:outline-none transition shadow-lg shadow-indigo-200">
                <i class="fa-solid fa-store mr-2"></i> Onboard Vendor
            </button>
        </div>
    </div>

    {{-- 2. ANALYTICS GRID (Unchanged) --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        {{-- Card 1 --}}
        <div class="relative bg-white p-6 rounded-2xl shadow-sm border border-gray-100 overflow-hidden group hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
            <div class="absolute top-0 right-0 -mt-4 -mr-4 w-24 h-24 rounded-full bg-indigo-50/50 group-hover:bg-indigo-100 transition-colors duration-300"></div>
            <div class="relative flex justify-between items-start z-10">
                <div>
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Total Active Marts</p>
                    <h3 class="text-3xl font-extrabold text-gray-900 mt-2 group-hover:text-indigo-600 transition-colors" x-text="vendors.length"></h3>
                </div>
                <div class="p-3 bg-indigo-50 text-indigo-600 rounded-xl shadow-inner group-hover:scale-110 transition-transform duration-300">
                    <i class="fa-solid fa-shop text-xl"></i>
                </div>
            </div>
            <div class="mt-4 flex items-center text-xs text-gray-400">
                <span class="text-indigo-600 font-bold bg-indigo-50 px-1.5 py-0.5 rounded mr-2"><i class="fa-solid fa-arrow-up"></i> Live</span>
                <span>Vendor Stores</span>
            </div>
            <div class="absolute bottom-0 left-0 w-full h-1 bg-gradient-to-r from-indigo-400 to-purple-500 transform scale-x-0 group-hover:scale-x-100 transition-transform duration-500 origin-left"></div>
        </div>

        {{-- Card 2 --}}
        <div class="relative bg-white p-6 rounded-2xl shadow-sm border border-gray-100 overflow-hidden group hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
            <div class="absolute top-0 right-0 -mt-4 -mr-4 w-24 h-24 rounded-full bg-emerald-50/50 group-hover:bg-emerald-100 transition-colors duration-300"></div>
            <div class="relative flex justify-between items-start z-10">
                <div>
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Total GMV (Sales)</p>
                    <h3 class="text-3xl font-extrabold text-gray-900 mt-2 group-hover:text-emerald-600 transition-colors">NaN</h3>
                </div>
                <div class="p-3 bg-emerald-50 text-emerald-600 rounded-xl shadow-inner group-hover:scale-110 transition-transform duration-300">
                    <i class="fa-solid fa-chart-line text-xl"></i>
                </div>
            </div>
            <div class="mt-4 flex items-center text-xs text-gray-400">
                <span class="text-emerald-600 font-bold bg-emerald-50 px-1.5 py-0.5 rounded mr-2"><i class="fa-solid fa-coins"></i> Revenue</span>
                <span>Gross Merchandise Value</span>
            </div>
            <div class="absolute bottom-0 left-0 w-full h-1 bg-gradient-to-r from-emerald-400 to-teal-500 transform scale-x-0 group-hover:scale-x-100 transition-transform duration-500 origin-left"></div>
        </div>

        {{-- Card 3 --}}
        <div class="relative bg-white p-6 rounded-2xl shadow-sm border border-gray-100 overflow-hidden group hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
            <div class="absolute top-0 right-0 -mt-4 -mr-4 w-24 h-24 rounded-full bg-amber-50/50 group-hover:bg-amber-100 transition-colors duration-300"></div>
            <div class="relative flex justify-between items-start z-10">
                <div>
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Pending Approvals</p>
                    <h3 class="text-3xl font-extrabold text-gray-900 mt-2 group-hover:text-amber-600 transition-colors">NaN</h3>
                </div>
                <div class="p-3 bg-amber-50 text-amber-600 rounded-xl shadow-inner group-hover:scale-110 transition-transform duration-300">
                    <i class="fa-solid fa-clock text-xl"></i>
                </div>
            </div>
            <div class="mt-4 flex items-center text-xs text-gray-400">
                <span class="text-amber-600 font-bold bg-amber-50 px-1.5 py-0.5 rounded mr-2"><i class="fa-solid fa-hourglass-half"></i> Action</span>
                <span>Applications Review</span>
            </div>
            <div class="absolute bottom-0 left-0 w-full h-1 bg-gradient-to-r from-amber-400 to-orange-500 transform scale-x-0 group-hover:scale-x-100 transition-transform duration-500 origin-left"></div>
        </div>

        {{-- Card 4 --}}
        <div class="relative bg-white p-6 rounded-2xl shadow-sm border border-gray-100 overflow-hidden group hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
            <div class="absolute top-0 right-0 -mt-4 -mr-4 w-24 h-24 rounded-full bg-rose-50/50 group-hover:bg-rose-100 transition-colors duration-300"></div>
            <div class="relative flex justify-between items-start z-10">
                <div>
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Admin Commission</p>
                    <h3 class="text-3xl font-extrabold text-gray-900 mt-2 group-hover:text-rose-600 transition-colors">NaN</h3>
                </div>
                <div class="p-3 bg-rose-50 text-rose-600 rounded-xl shadow-inner group-hover:scale-110 transition-transform duration-300">
                    <i class="fa-solid fa-hand-holding-dollar text-xl"></i>
                </div>
            </div>
            <div class="mt-4 flex items-center text-xs text-gray-400">
                <span class="text-rose-600 font-bold bg-rose-50 px-1.5 py-0.5 rounded mr-2"><i class="fa-solid fa-percentage"></i> Earnings</span>
                <span>Net Platform Profit</span>
            </div>
            <div class="absolute bottom-0 left-0 w-full h-1 bg-gradient-to-r from-rose-400 to-red-500 transform scale-x-0 group-hover:scale-x-100 transition-transform duration-500 origin-left"></div>
        </div>
    </div>

    {{-- 3. MAIN CONTENT (Unchanged) --}}
    <div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden">
        
        {{-- Filter Bar --}}
        <div class="p-4 border-b border-gray-100 bg-gray-50 flex flex-wrap gap-4 items-center justify-between">
            <div class="relative flex-1 max-w-md min-w-[200px]">
                <i class="fa-solid fa-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
                <input type="text" x-model="searchTerm" placeholder="Search Vendor, Owner..." class="w-full pl-10 pr-4 py-2 text-sm border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500">
            </div>
            
            <div class="flex flex-wrap gap-2">
                <select x-model="categoryFilter" class="text-sm border-gray-300 rounded-lg focus:ring-indigo-500 bg-white">
                    <option value="">All Categories</option>
                    <option value="NaN">Uncategorized</option>
                </select>

                <select x-model="statusFilter" class="text-sm border-gray-300 rounded-lg focus:ring-indigo-500 bg-white">
                    <option value="">All Statuses</option>
                    <option value="Active">Active</option>
                    <option value="Deactive">Deactive</option>
                    <option value="Suspend">Suspend</option>
                </select>
                
                <button @click="searchTerm=''; categoryFilter=''; statusFilter=''" class="text-xs text-indigo-600 hover:text-indigo-800 font-medium px-2">
                    Reset
                </button>
            </div>
        </div>

        {{-- Table --}}
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Vendor Business</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Operational Stats</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Assigned Rider</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Wallet & Status</th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 bg-white">
                    <template x-for="vendor in filteredVendors" :key="vendor.id">
                        <tr class="hover:bg-indigo-50/30 transition duration-150 group" >
                            {{-- ... (same table rows) ... --}}
                            {{-- Vendor Info --}}
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="relative flex-shrink-0 h-10 w-10">
                                        <div class="h-10 w-10 rounded-lg flex items-center justify-center text-white font-bold text-xs shadow-sm"
                                             :class="`bg-${vendor.color}-500`" 
                                             x-text="vendor.logo"></div>
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900" x-text="vendor.name"></div>
                                        <div class="text-xs text-gray-500" x-text="vendor.owner"></div>
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-medium bg-gray-100 text-gray-800 mt-1 border border-gray-200" x-text="vendor.category"></span>
                                    </div>
                                </div>
                            </td>
                            {{-- Operational Stats --}}
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900 font-semibold" x-text="vendor.stats.orders + ' Orders'"></div>
                                <div class="text-xs text-gray-500 mt-1"><i class="fa-solid fa-box-open mr-1"></i> <span x-text="vendor.stats.products"></span> Items</div>
                            </td>
                            {{-- Assigned Rider --}}
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-md bg-gray-50 text-gray-600 border border-gray-200">
                                    <i class="fa-solid fa-motorcycle mr-1"></i> rider xyz
                                </span>
                            </td>
                            {{-- Wallet & Status --}}
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900 font-bold" x-text="formatMoney(vendor.stats.revenue)"></div>
                                <div class="mt-1">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full"
                                        :class="{
                                            'bg-green-100 text-green-800': vendor.status === 'Active',
                                            'bg-red-100 text-red-800': vendor.status === 'Deactive' || vendor.status === 'Ban',
                                            'bg-yellow-100 text-yellow-800': vendor.status === 'Suspend' || vendor.status === 'Pending'
                                        }"
                                        x-text="vendor.status">
                                    </span>
                                </div>
                            </td>
                            {{-- Actions --}}
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <div class="flex justify-end items-center gap-2">
                                    <button @click="openVendorId = vendor.id" class="text-indigo-600 hover:text-indigo-900 bg-indigo-50 p-2 rounded hover:bg-indigo-100 transition" title="View Details">
                                        View Details
                                    </button>
                                    <div class="relative" x-data="{ open: false }">
                                        <button @click="open = !open" @click.away="open = false" class="text-gray-400 hover:text-gray-600 p-2 rounded-full hover:bg-gray-100">
                                            <i class="fa-solid fa-ellipsis-v"></i>
                                        </button>
                                        <div x-show="open" class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-50 border border-gray-100" style="display: none;">
                                            <button class="w-full text-left px-4 py-2 text-sm text-green-600 hover:bg-green-50 flex items-center">
                                                <i class="fa-solid fa-check-circle mr-2"></i> Approve
                                            </button>
                                            <button class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50 flex items-center">
                                                <i class="fa-solid fa-ban mr-2"></i> Reject
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    </template>
                </tbody>
            </table>
            {{-- Empty State --}}
            <div x-show="filteredVendors.length === 0" class="p-10 text-center text-gray-500">
                <i class="fa-solid fa-store-slash text-4xl mb-3 text-gray-300"></i>
                <h3 class="text-sm font-medium text-gray-900">No vendors found</h3>
            </div>
        </div>
        
        {{-- Footer --}}
        <div class="px-6 py-4 border-t border-gray-100 flex justify-center bg-gray-50">
            <span class="text-xs font-medium text-gray-500">Showing <span x-text="filteredVendors.length"></span> vendors</span>
        </div>
    </div>

    {{-- 4. UNIFIED SLIDE-OVER --}}
    {{-- Main Container (Fixed) --}}
    <div x-show="openVendorId !== null" 
         class="fixed inset-0 z-50 overflow-hidden" 
         style="display: none;"
         x-transition:enter="transition-opacity ease-linear duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition-opacity ease-linear duration-300"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0">
        
        {{-- Backdrop --}}
        <div class="absolute inset-0 bg-gray-900 bg-opacity-75 backdrop-blur-sm" 
             @click="openVendorId = null"></div>

        {{-- Panel Container --}}
        <div class="fixed inset-y-0 right-0 max-w-2xl w-full flex pointer-events-none">
            
            {{-- Sliding Panel --}}
            <div class="w-full h-full bg-white shadow-2xl pointer-events-auto flex flex-col"
                 x-show="openVendorId !== null"
                 x-transition:enter="transform transition ease-in-out duration-500 sm:duration-700"
                 x-transition:enter-start="translate-x-full"
                 x-transition:enter-end="translate-x-0"
                 x-transition:leave="transform transition ease-in-out duration-500 sm:duration-700"
                 x-transition:leave-start="translate-x-0"
                 x-transition:leave-end="translate-x-full">
                
                {{-- Header --}}
                <div class="bg-indigo-900 px-6 py-6 text-white shrink-0">
                    <div class="flex justify-between items-start">
                        <div class="flex items-center space-x-4">
                            <div class="h-16 w-16 rounded-xl bg-white/20 flex items-center justify-center text-white text-3xl font-bold border border-white/30" x-text="activeVendor.logo"></div>
                            <div>
                                <h2 class="text-xl font-bold" x-text="activeVendor.name"></h2>
                                <p class="text-indigo-200 text-sm flex items-center gap-2">
                                    <i class="fa-solid fa-location-dot"></i> <span x-text="activeVendor.city"></span>
                                </p>
                            </div>
                        </div>
                        <button @click="openVendorId = null" class="text-white hover:text-indigo-200 transition"><i class="fa-solid fa-times text-xl"></i></button>
                    </div>
                    
                    {{-- Tabs (UPDATED) --}}
                    <div class="flex space-x-6 mt-8 text-sm font-medium overflow-x-auto scrollbar-hide">
                        <button @click="currentTab = 'overview'" 
                            :class="currentTab === 'overview' ? 'border-white text-white' : 'border-transparent text-indigo-300 hover:text-white'"
                            class="pb-3 border-b-2 transition whitespace-nowrap">Overview</button>
                        
                        {{-- NEW TAB: PRODUCTS --}}
                        <button @click="currentTab = 'products'" 
                            :class="currentTab === 'products' ? 'border-white text-white' : 'border-transparent text-indigo-300 hover:text-white'"
                            class="pb-3 border-b-2 transition whitespace-nowrap">Products</button>
                        
                        <button @click="currentTab = 'wallet'" 
                            :class="currentTab === 'wallet' ? 'border-white text-white' : 'border-transparent text-indigo-300 hover:text-white'"
                            class="pb-3 border-b-2 transition whitespace-nowrap">Wallet</button>
                        
                        <button @click="currentTab = 'payment-methods'" 
                            :class="currentTab === 'payment-methods' ? 'border-white text-white' : 'border-transparent text-indigo-300 hover:text-white'"
                            class="pb-3 border-b-2 transition whitespace-nowrap">Payment Methods</button>
                        
                        <button @click="currentTab = 'documents'" 
                            :class="currentTab === 'documents' ? 'border-white text-white' : 'border-transparent text-indigo-300 hover:text-white'"
                            class="pb-3 border-b-2 transition whitespace-nowrap">KYC Documents</button>
                        
                        <button @click="currentTab = 'orders'" 
                            :class="currentTab === 'orders' ? 'border-white text-white' : 'border-transparent text-indigo-300 hover:text-white'"
                            class="pb-3 border-b-2 transition whitespace-nowrap">Order History</button>
                    </div>
                </div>

                {{-- Content --}}
                <div class="flex-1 overflow-y-auto p-6 bg-gray-50 scroll-smooth">
                    
                    {{-- TAB: OVERVIEW (Existing) --}}
                    <div x-show="currentTab === 'overview'" class="space-y-6">
                        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                            <h3 class="font-bold text-gray-900 mb-5 flex items-center border-b border-gray-50 pb-3">
                                <i class="fa-solid fa-store mr-2 text-indigo-500"></i> Business Snapshot
                            </h3>
                            <div class="grid grid-cols-2 md:grid-cols-3 gap-y-6 gap-x-4 text-sm">
                                <div class="col-span-2 md:col-span-3">
                                    <p class="text-gray-400 text-[10px] uppercase font-bold tracking-wider">Mart / Store Name</p>
                                    <p class="font-bold text-gray-900 text-lg mt-1" x-text="activeVendor.name"></p>
                                </div>
                                <div>
                                    <p class="text-gray-400 text-[10px] uppercase font-bold tracking-wider">Category</p>
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-medium bg-indigo-50 text-indigo-700 mt-1 border border-indigo-100" x-text="activeVendor.category"></span>
                                </div>
                                <div>
                                    <p class="text-gray-400 text-[10px] uppercase font-bold tracking-wider">Total Products</p>
                                    <div class="flex items-center mt-1">
                                        <i class="fa-solid fa-cubes text-gray-300 mr-2 text-xs"></i>
                                        <p class="font-semibold text-gray-900" x-text="(activeVendor.stats?.products || 0) + ' Items'"></p>
                                    </div>
                                </div>
                                <div>
                                    <p class="text-gray-400 text-[10px] uppercase font-bold tracking-wider">Current Status</p>
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-bold mt-1"
                                        :class="{
                                            'bg-green-100 text-green-800': activeVendor.status === 'Active',
                                            'bg-red-100 text-red-800': activeVendor.status === 'Deactive' || activeVendor.status === 'Ban',
                                            'bg-yellow-100 text-yellow-800': activeVendor.status === 'Suspend' || activeVendor.status === 'Pending'
                                        }"
                                        x-text="activeVendor.status">
                                    </span>
                                </div>
                                <div>
                                    <p class="text-gray-400 text-[10px] uppercase font-bold tracking-wider">Owner Name</p>
                                    <p class="font-medium text-gray-900 mt-1" x-text="activeVendor.owner"></p>
                                </div>
                                <div>
                                    <p class="text-gray-400 text-[10px] uppercase font-bold tracking-wider">Contact Number</p>
                                    <p class="font-medium text-gray-900 mt-1" x-text="activeVendor.phone"></p>
                                </div>
                                 <div>
                                    <p class="text-gray-400 text-[10px] uppercase font-bold tracking-wider">Lifetime Orders</p>
                                    <p class="font-medium text-gray-900 mt-1" x-text="(activeVendor.stats?.orders || 0) + ' Orders'"></p>
                                </div>
                            </div>
                        </div>

                        <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-100">
                            <h3 class="font-bold text-gray-900 mb-4 flex items-center"><i class="fa-solid fa-map-marker-alt mr-2 text-indigo-500"></i> Address Details</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                                <div class="col-span-2">
                                    <p class="text-xs text-gray-500 uppercase">Shop Address</p>
                                    <p class="font-medium text-gray-900 mt-1" x-text="activeVendor.address.current"></p>
                                </div>
                                <div class="col-span-2">
                                    <p class="text-xs text-gray-500 uppercase">Warehouse Address</p>
                                    <p class="font-medium text-gray-900 mt-1" x-text="activeVendor.address.warehouse"></p>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500 uppercase">City / State</p>
                                    <p class="font-medium text-gray-900 mt-1" x-text="activeVendor.address.city"></p>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- TAB: PRODUCTS (NEW) --}}
                    <div x-show="currentTab === 'products'" class="space-y-4">
                        <div class="flex justify-between items-center px-1">
                            <h3 class="font-bold text-gray-900">Store Inventory</h3>
                            <span class="text-xs bg-indigo-100 text-indigo-700 px-2 py-1 rounded-full font-bold" x-text="activeVendor.products.length + ' Products Found'"></span>
                        </div>

                        <div class="space-y-3">
                            <template x-if="activeVendor.products.length === 0">
                                <div class="text-center py-10 bg-white rounded-xl border border-gray-100 border-dashed">
                                    <p class="text-gray-400 text-sm">No products uploaded yet.</p>
                                </div>
                            </template>
                            
                            <template x-for="product in activeVendor.products" :key="product.id">
                                <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100 flex flex-col sm:flex-row sm:items-center gap-4 hover:shadow-md transition duration-200">
                                    {{-- Product Image & Name --}}
                                    <div class="flex items-center gap-4 flex-1">
                                        <div class="h-14 w-14 rounded-lg bg-gray-50 border border-gray-100 flex items-center justify-center text-3xl" x-text="product.image"></div>
                                        <div>
                                            <h4 class="text-sm font-bold text-gray-900" x-text="product.name"></h4>
                                            <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-medium bg-gray-100 text-gray-600 mt-1" x-text="product.category"></span>
                                        </div>
                                    </div>

                                    {{-- Product Stats --}}
                                    <div class="flex items-center justify-between sm:justify-end gap-6 w-full sm:w-auto mt-2 sm:mt-0 border-t sm:border-t-0 border-gray-50 pt-3 sm:pt-0">
                                        <div class="text-center sm:text-right">
                                            <p class="text-[10px] text-gray-400 uppercase tracking-wider font-bold">Price</p>
                                            <p class="text-sm font-bold text-gray-900" x-text="'PKR ' + product.price"></p>
                                        </div>
                                        
                                        <div class="text-center sm:text-right">
                                            <p class="text-[10px] text-gray-400 uppercase tracking-wider font-bold">Sold</p>
                                            <p class="text-sm font-semibold text-gray-700"><i class="fa-solid fa-arrow-trend-up text-green-500 mr-1 text-xs"></i><span x-text="product.sold"></span></p>
                                        </div>

                                        <div class="text-center sm:text-right">
                                            <p class="text-[10px] text-gray-400 uppercase tracking-wider font-bold">Rating</p>
                                            <div class="flex items-center justify-end text-sm font-bold text-amber-500">
                                                <span x-text="product.rating"></span> <i class="fa-solid fa-star ml-1 text-xs"></i>
                                            </div>
                                        </div>
                                        
                                        <div class="hidden sm:block">
                                            <div x-show="product.stock > 0" class="h-2 w-2 rounded-full bg-green-500" title="In Stock"></div>
                                            <div x-show="product.stock <= 0" class="h-2 w-2 rounded-full bg-red-500" title="Out of Stock"></div>
                                        </div>
                                    </div>
                                </div>
                            </template>
                        </div>
                    </div>

                    {{-- TAB: WALLET (Existing) --}}
                    <div x-show="currentTab === 'wallet'" class="space-y-6">
                         {{-- Balance Card --}}
                         <div class="bg-gradient-to-r from-emerald-500 to-teal-600 rounded-2xl p-6 text-white shadow-lg">
                            <div class="flex justify-between items-start">
                                <div>
                                    <p class="text-emerald-100 text-xs font-bold uppercase tracking-wider">Total Balance</p>
                                    <h2 class="text-3xl font-bold mt-1" x-text="formatMoney(activeVendor.wallet.balance)"></h2>
                                </div>
                                <div class="p-2 bg-white/20 rounded-lg backdrop-blur-sm">
                                    <i class="fa-solid fa-wallet text-2xl"></i>
                                </div>
                            </div>
                            <div class="mt-6 flex gap-4">
                                <div class="bg-black/10 rounded-lg p-3 flex-1">
                                    <p class="text-xs text-emerald-100 mb-1">Pending</p>
                                    <p class="font-semibold" x-text="formatMoney(activeVendor.wallet.pending)"></p>
                                </div>
                                <div class="bg-black/10 rounded-lg p-3 flex-1">
                                    <p class="text-xs text-emerald-100 mb-1">Withdrawn</p>
                                    <p class="font-semibold" x-text="formatMoney(activeVendor.wallet.withdrawn)"></p>
                                </div>
                            </div>
                        </div>

                        {{-- Transactions List (Dummy) --}}
                        <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-100">
                            <h3 class="font-bold text-gray-900 mb-4">Recent Transactions</h3>
                            <div class="space-y-4">
                                <div class="flex justify-between items-center border-b border-gray-50 pb-3 last:border-0">
                                    <div class="flex items-center gap-3">
                                        <div class="h-8 w-8 rounded-full bg-green-100 text-green-600 flex items-center justify-center text-xs">
                                            <i class="fa-solid fa-arrow-down"></i>
                                        </div>
                                        <div>
                                            <p class="text-sm font-medium text-gray-900">Order Payout</p>
                                            <p class="text-xs text-gray-500">Order #ORD-9921</p>
                                        </div>
                                    </div>
                                    <span class="text-sm font-bold text-green-600">+PKR 4,500</span>
                                </div>
                                <div class="flex justify-between items-center border-b border-gray-50 pb-3 last:border-0">
                                    <div class="flex items-center gap-3">
                                        <div class="h-8 w-8 rounded-full bg-red-100 text-red-600 flex items-center justify-center text-xs">
                                            <i class="fa-solid fa-arrow-up"></i>
                                        </div>
                                        <div>
                                            <p class="text-sm font-medium text-gray-900">Weekly Payout</p>
                                            <p class="text-xs text-gray-500">Bank Transfer</p>
                                        </div>
                                    </div>
                                    <span class="text-sm font-bold text-gray-900">-PKR 25,000</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- TAB: PAYMENT METHODS (Existing) --}}
                    <div x-show="currentTab === 'payment-methods'" class="space-y-4">
                        <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-100">
                            <h3 class="font-bold text-gray-900 mb-4">Linked Payment Methods</h3>
                            <div class="space-y-3">
                                <template x-if="activeVendor.payment_methods.length > 0">
                                    <template x-for="method in activeVendor.payment_methods">
                                        <div class="flex items-center p-3 border border-gray-200 rounded-lg hover:bg-gray-50 transition">
                                            <div class="h-10 w-10 bg-indigo-50 text-indigo-600 rounded-full flex items-center justify-center mr-3">
                                                <i class="fa-solid fa-credit-card"></i>
                                            </div>
                                            <div>
                                                <p class="text-sm font-medium text-gray-900" x-text="method"></p>
                                                <p class="text-xs text-gray-500">Verified</p>
                                            </div>
                                        </div>
                                    </template>
                                </template>
                                <template x-if="activeVendor.payment_methods.length === 0">
                                    <div class="text-center py-4 text-gray-500 italic">No payment methods linked.</div>
                                </template>
                            </div>
                        </div>
                    </div>

                    {{-- TAB: KYC DOCUMENTS (Existing) --}}
                    <div x-show="currentTab === 'documents'" class="space-y-4">
                        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                            <div class="flex justify-between items-center mb-6">
                                <h3 class="font-bold text-gray-900">Submitted Compliance Docs</h3>
                                <span class="bg-yellow-100 text-yellow-800 text-xs font-bold px-2 py-1 rounded">Review Needed</span>
                            </div>
                            
                            {{-- Static Doc List --}}
                            <div class="space-y-3">
                                <div class="flex items-center justify-between p-3 bg-white border border-gray-200 rounded-lg hover:shadow-sm transition">
                                    <div class="flex items-center space-x-3">
                                        <div class="h-10 w-10 bg-indigo-50 text-indigo-600 rounded-lg flex items-center justify-center text-lg"><i class="fa-solid fa-id-card"></i></div>
                                        <div>
                                            <p class="text-sm font-semibold text-gray-800">Business License / NTN</p>
                                            <span class="text-[10px] text-gray-500 uppercase">PDF</span>
                                        </div>
                                    </div>
                                    <button class="px-3 py-1.5 bg-gray-50 hover:bg-indigo-50 text-indigo-600 text-xs font-bold rounded transition">View</button>
                                </div>
                                <div class="flex items-center justify-between p-3 bg-white border border-gray-200 rounded-lg hover:shadow-sm transition">
                                    <div class="flex items-center space-x-3">
                                        <div class="h-10 w-10 bg-indigo-50 text-indigo-600 rounded-lg flex items-center justify-center text-lg"><i class="fa-solid fa-image"></i></div>
                                        <div>
                                            <p class="text-sm font-semibold text-gray-800">Shop Front Image</p>
                                            <span class="text-[10px] text-gray-500 uppercase">JPG</span>
                                        </div>
                                    </div>
                                    <button class="px-3 py-1.5 bg-gray-50 hover:bg-indigo-50 text-indigo-600 text-xs font-bold rounded transition">View</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- TAB: ORDERS (Existing) --}}
                    <div x-show="currentTab === 'orders'" class="space-y-4">
                         <div class="bg-white p-10 rounded-xl border border-gray-100 text-center">
                            <i class="fa-solid fa-receipt text-4xl text-gray-200 mb-3"></i>
                            <p class="text-gray-500">Order history not available.</p>
                        </div>
                    </div>

                </div>

                {{-- Footer --}}
                <div class="p-4 bg-white border-t border-gray-200 flex justify-end gap-3 shrink-0">
                    <button class="px-5 py-2.5 rounded-lg border border-gray-300 text-red-600 font-medium hover:bg-red-50 transition">Reject</button>
                    <button class="px-5 py-2.5 rounded-lg bg-green-600 text-white font-medium hover:bg-green-700 shadow-md transition">Approve</button>
                </div>
            </div>
        </div>
    </div>

    {{-- 5. ADD VENDOR MODAL (Unchanged) --}}
    <div x-show="isAddVendorModalOpen" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
        <div class="fixed inset-0 bg-gray-900 bg-opacity-75 transition-opacity backdrop-blur-sm" @click="!isSubmitting && (isAddVendorModalOpen = false)"></div>
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="relative bg-white rounded-2xl shadow-2xl max-w-2xl w-full transform transition-all">

                <div class="p-6 border-b border-gray-100 flex justify-between items-center">
                    <h3 class="text-xl font-bold text-gray-900"><i class="fa-solid fa-store mr-2 text-indigo-500"></i> Add New Mart Vendor</h3>
                    <button @click="isAddVendorModalOpen = false" :disabled="isSubmitting" class="text-gray-400 hover:text-gray-600">
                        <i class="fa-solid fa-times text-lg"></i>
                    </button>
                </div>

                <form action="{{ route('store.mart') }}" @submit.prevent="submitForm($event)">
                    @csrf
                    <div class="p-6 space-y-4 max-h-[60vh] overflow-y-auto" :class="isSubmitting ? 'opacity-50 pointer-events-none' : ''">
                        <div class="grid grid-cols-2 gap-4">
                            <div class="col-span-2">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Mart Name</label>
                                <input type="text" name="business_name" required class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm p-2.5 border">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Category</label>
                                <select name="category_id" required class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm p-2.5 border bg-white">
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Location</label>
                                <input type="text" name="location" required class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm p-2.5 border">
                            </div>
                            <div class="col-span-2">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Owner Name</label>
                                <input type="text" name="owner_name" required class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm p-2.5 border">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                                <input type="email" name="email" required class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm p-2.5 border">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Phone</label>
                                <input type="text" name="phone" required class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm p-2.5 border">
                            </div>
                            <div class="col-span-2">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                                <input type="password" name="password" required class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm p-2.5 border">
                            </div>
                        </div>
                    </div>

                    <div class="p-6 border-t border-gray-100 flex justify-end gap-3 bg-gray-50 rounded-b-2xl">
                        <button type="button" @click="isAddVendorModalOpen = false" :disabled="isSubmitting" class="px-4 py-2 bg-white border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 font-medium">Cancel</button>
                        <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 font-medium flex items-center shadow-md disabled:bg-indigo-400" :disabled="isSubmitting">
                            <i x-show="isSubmitting" class="fa-solid fa-spinner fa-spin mr-2"></i>
                            <span x-text="isSubmitting ? 'Saving...' : 'Save Vendor'"></span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection