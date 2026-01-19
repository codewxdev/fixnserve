@extends('layouts.app')

@section('content')
   <div id="mart-vendor-module" 
    class="bg-gray-50 min-h-screen font-sans pl-4 p-4 md:p-8"
    x-data="{ 
        openVendorId: null, 
        isAddVendorModalOpen: false, 
        currentTab: 'overview',
        searchTerm: '',
        categoryFilter: '',
        statusFilter: '',
        isSubmitting: false,
        riders: {{ $riders->toJson() }}, // Data injected from Controller

        get filteredriders() {
            return this.riders.filter(v => {
                const search = this.searchTerm.toLowerCase();
                const nameMatch = v.name ? v.name.toLowerCase().includes(search) : false;
                const ownerMatch = v.owner ? v.owner.toLowerCase().includes(search) : false;
                const contactMatch = v.contact ? v.contact.toLowerCase().includes(search) : false;
                
                const matchesSearch = nameMatch || ownerMatch || contactMatch;
                // Category filter disabled since all are 'Rider', or kept if you categorize riders
                const matchesCategory = this.categoryFilter === '' || this.categoryFilter === 'NaN' || v.category === this.categoryFilter;
                const matchesStatus = this.statusFilter === '' || (v.status && v.status.toLowerCase() === this.statusFilter.toLowerCase());
                                      
                return matchesSearch && matchesStatus;
            });
        },

        get activeVendor() {
            return this.riders.find(v => v.id === this.openVendorId) || {};
        },

        formatMoney(amount) {
            if(!amount || amount === 'NaN') return 'NaN';
            return 'PKR ' + Number(amount).toLocaleString();
        },

        async submitForm(e) {
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
                    alert('Rider Added Successfully!');
                    location.reload(); 
                } else {
                    let errorMsg = result.message || 'Validation failed';
                    if(result.errors) {
                        errorMsg = Object.values(result.errors).flat().join('\n');
                    }
                    alert(errorMsg);
                }
            } catch (error) {
                console.error('Error:', error);
                alert('Server connection failed.');
            } finally {
                this.isSubmitting = false;
            }
        }
    }" 
    x-cloak> 

        {{-- HEADER SECTION --}}
        <div class="flex flex-col md:flex-row md:items-center justify-between mb-8 gap-4">
            <div>
                <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight">Rider Management</h1>
                <p class="text-sm text-gray-500 mt-1">Manage Logistics, Riders, and Payouts</p>
            </div>
            <div class="flex gap-3">
                <button
                    class="px-5 py-2.5 bg-white border border-gray-200 text-gray-700 font-semibold rounded-xl shadow-sm hover:bg-gray-50 transition">
                    Export Report
                </button>
                
                {{-- UPDATED BUTTON: Onboard Rider --}}
                <button @click="isAddVendorModalOpen = true"
                    class="px-5 py-2.5 bg-indigo-600 text-white font-semibold rounded-xl shadow-lg shadow-indigo-200 hover:bg-indigo-700 transition flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Onboard Rider
                </button>
            </div>
        </div>

        {{-- METRICS OVERVIEW --}}
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 relative overflow-hidden group">
                <div class="absolute right-0 top-0 w-24 h-24 bg-indigo-50 rounded-bl-full -mr-4 -mt-4 transition group-hover:bg-indigo-100"></div>
                <p class="text-gray-500 text-xs font-bold uppercase tracking-wider relative z-10">Total Riders</p>
                <h3 class="text-3xl font-bold text-gray-900 mt-2 relative z-10" x-text="riders.length"></h3>
                <p class="text-green-500 text-xs font-bold mt-2 flex items-center relative z-10">Dynamic Data</p>
            </div>

            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 relative overflow-hidden group">
                <div class="absolute right-0 top-0 w-24 h-24 bg-green-50 rounded-bl-full -mr-4 -mt-4 transition group-hover:bg-green-100"></div>
                <p class="text-gray-500 text-xs font-bold uppercase tracking-wider relative z-10">Total Completed Orders</p>
                <h3 class="text-3xl font-bold text-gray-900 mt-2 relative z-10">NaN</h3>
            </div>

            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 relative overflow-hidden group">
                <div class="absolute right-0 top-0 w-24 h-24 bg-red-50 rounded-bl-full -mr-4 -mt-4 transition group-hover:bg-red-100"></div>
                <p class="text-gray-500 text-xs font-bold uppercase tracking-wider relative z-10">Pending Verifications</p>
                <h3 class="text-3xl font-bold text-gray-900 mt-2 relative z-10">NaN</h3>
            </div>

            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 relative overflow-hidden group">
                <div class="absolute right-0 top-0 w-24 h-24 bg-yellow-50 rounded-bl-full -mr-4 -mt-4 transition group-hover:bg-yellow-100"></div>
                <p class="text-gray-500 text-xs font-bold uppercase tracking-wider relative z-10">Rider Earnings</p>
                <h3 class="text-3xl font-bold text-gray-900 mt-2 relative z-10">NaN</h3>
            </div>
        </div>

        {{-- MAIN TABLE CARD --}}
        <div class="bg-white rounded-3xl shadow-xl border border-gray-100 overflow-hidden">
            {{-- Filters Toolbar --}}
            <div class="p-5 border-b border-gray-100 bg-gray-50/50 grid grid-cols-1 sm:grid-cols-12 gap-4 items-center">
                <div class="sm:col-span-5 relative">
                    <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                        </svg>
                    </span>
                    <input type="text" x-model="searchTerm"
                        class="block w-full pl-10 pr-3 py-2.5 border border-gray-200 rounded-xl leading-5 bg-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm transition"
                        placeholder="Search Rider Name, Email...">
                </div>
                <div class="sm:col-span-3">
                    <select x-model="categoryFilter" class="block w-full pl-3 pr-10 py-2.5 text-base border-gray-200 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-xl">
                        <option value="">All Categories</option>
                        <option value="Rider">Rider</option>
                    </select>
                </div>
                <div class="sm:col-span-3">
                    <select x-model="statusFilter" class="block w-full pl-3 pr-10 py-2.5 text-base border-gray-200 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-xl">
                        <option value="">All Statuses</option>
                        <option value="Active">Active</option>
                        <option value="Deactive">Deactive</option>
                        <option value="Ban">Ban</option>
                    </select>
                </div>
                <div class="sm:col-span-1 flex justify-end">
                    <button @click="searchTerm=''; categoryFilter=''; statusFilter=''" class="text-gray-400 hover:text-indigo-600 transition" title="Reset Filters">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.582a8.001 8.001 0 01-15.356-2m0 0H15"></path>
                        </svg>
                    </button>
                </div>
            </div>

            {{-- TABLE --}}
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-100">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Rider Details</th>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Operational Stats</th>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Wallet & Status</th>
                            <th scope="col" class="px-6 py-4 text-right text-xs font-bold text-gray-500 uppercase tracking-wider">Manage</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-100">
                        <template x-for="vendor in filteredriders" :key="vendor.id">
                            <tr class="hover:bg-gray-50 transition duration-200 cursor-pointer" @click="openVendorId = vendor.id">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-12 w-12 rounded-xl flex items-center justify-center text-white font-bold text-lg shadow-md"
                                            :class="`bg-${vendor.color}-500`" x-text="vendor.logo"></div>
                                        <div class="ml-4">
                                            <div class="text-sm font-bold text-gray-900" x-text="vendor.name"></div>
                                            <div class="text-sm text-gray-500" x-text="vendor.contact"></div>
                                            <div class="text-xs text-gray-400" x-text="vendor.city"></div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900 font-semibold" x-text="vendor.stats.orders + ' Delivered'"></div>
                                    <div class="text-xs text-gray-500 mt-1">Status: <span x-text="vendor.stats.revenue"></span></div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900 font-bold" x-text="formatMoney(vendor.wallet.balance)"></div>
                                    <div class="mt-1">
                                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full"
                                            :class="{
                                                'bg-green-100 text-green-800': vendor.status.toLowerCase() === 'active',
                                                'bg-red-100 text-red-800': vendor.status.toLowerCase() === 'deactive' || vendor.status.toLowerCase() === 'ban',
                                                'bg-yellow-100 text-yellow-800': vendor.status.toLowerCase() === 'suspend'
                                            }"
                                            x-text="vendor.status">
                                        </span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <button class="text-indigo-600 hover:text-indigo-900 font-semibold flex items-center justify-end w-full">
                                        Manage
                                        <svg class="ml-1 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                    </button>
                                </td>
                            </tr>
                        </template>
                    </tbody>
                </table>
                <div x-show="filteredriders.length === 0" class="p-10 text-center text-gray-500">
                    <h3 class="mt-2 text-sm font-medium text-gray-900">No riders found</h3>
                </div>
            </div>
        </div>

        {{-- SLIDE-OVER (DETAILS) --}}
        <div x-show="openVendorId !== null" class="fixed inset-0 z-50 overflow-hidden" style="display: none;">
            <div class="absolute inset-0 overflow-hidden">
                <div x-show="openVendorId !== null" class="absolute inset-0 bg-gray-900 bg-opacity-75 backdrop-blur-sm transition-opacity" @click="openVendorId = null"></div>
                <div class="pointer-events-none fixed inset-y-0 right-0 flex max-w-full pl-10">
                    <div x-show="openVendorId !== null" class="pointer-events-auto w-screen max-w-2xl">
                        <div class="flex h-full flex-col bg-white shadow-2xl">
                            <div class="px-6 py-6 bg-gradient-to-r from-gray-900 to-indigo-900">
                                <div class="flex items-start justify-between">
                                    <div class="flex items-center space-x-4">
                                        <div class="h-16 w-16 rounded-xl bg-white/20 flex items-center justify-center text-white text-3xl font-bold" x-text="activeVendor.logo"></div>
                                        <div>
                                            <h2 class="text-2xl font-bold text-white" x-text="activeVendor.name"></h2>
                                            <div class="mt-2 text-indigo-200 text-sm" x-text="activeVendor.city"></div>
                                        </div>
                                    </div>
                                    <button @click="openVendorId = null" class="text-white"><svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M6 18L18 6M6 6l12 12" /></svg></button>
                                </div>
                                {{-- Details tabs --}}
                                <div class="mt-8 flex space-x-1 bg-white/10 p-1 rounded-xl">
                                    <button @click="currentTab = 'overview'" :class="currentTab === 'overview' ? 'bg-white text-gray-900' : 'text-gray-300'" class="flex-1 rounded-lg py-2 text-sm font-medium">Overview</button>
                                    <button @click="currentTab = 'finance'" :class="currentTab === 'finance' ? 'bg-white text-gray-900' : 'text-gray-300'" class="flex-1 rounded-lg py-2 text-sm font-medium">Wallet</button>
                                </div>
                            </div>
                            <div class="flex-1 overflow-y-auto bg-gray-50 p-6">
                                <div x-show="currentTab === 'overview'">
                                    <div class="bg-white p-5 rounded-xl border border-gray-200">
                                        <div class="grid grid-cols-2 gap-4">
                                            <div><p class="text-xs text-gray-500">Email</p><p class="text-sm font-semibold" x-text="activeVendor.contact"></p></div>
                                            <div><p class="text-xs text-gray-500">Phone</p><p class="text-sm font-semibold" x-text="activeVendor.phone"></p></div>
                                            <div><p class="text-xs text-gray-500">City</p><p class="text-sm font-semibold" x-text="activeVendor.city"></p></div>
                                            <div><p class="text-xs text-gray-500">Status</p><p class="text-sm font-semibold" x-text="activeVendor.status"></p></div>
                                        </div>
                                    </div>
                                </div>
                                <div x-show="currentTab === 'finance'">
                                    <div class="bg-black rounded-2xl p-6 text-white shadow-lg">
                                        <p class="text-xs text-gray-400">Wallet Balance</p>
                                        <h3 class="text-3xl font-bold mt-2" x-text="formatMoney(activeVendor.wallet?.balance)"></h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        {{-- ADD RIDER MODAL --}}
        <div x-show="isAddVendorModalOpen" class="fixed inset-0 z-50 overflow-y-auto" x-cloak>
            <div class="fixed inset-0 bg-black bg-opacity-50" @click="!isSubmitting && (isAddVendorModalOpen = false)">
            </div>
            <div class="flex items-center justify-center min-h-screen p-4">
                <div class="relative bg-white rounded-3xl shadow-2xl max-w-2xl w-full"
                    @click.away="!isSubmitting && (isAddVendorModalOpen = false)">

                    <div class="p-6 border-b flex justify-between items-center bg-gray-50">
                        <h3 class="text-xl font-bold">Onboard New Rider</h3>
                        <button @click="isAddVendorModalOpen = false" :disabled="isSubmitting" class="text-gray-400">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>

                    {{-- Updated Form Fields based on User Table --}}
                    <form action="{{ route('store.rider') }}" @submit.prevent="submitForm($event)">
                        @csrf
                        <div class="p-6 space-y-4 max-h-[60vh] overflow-y-auto" :class="isSubmitting ? 'opacity-50 pointer-events-none' : ''">
                            <div class="grid grid-cols-2 gap-4">
                                <div class="col-span-2">
                                    <label class="text-sm font-medium">Full Name</label>
                                    <input type="text" name="name" required placeholder="John Doe"
                                        class="w-full border rounded-xl p-2.5 focus:ring-2 focus:ring-indigo-500 outline-none">
                                </div>
                                
                                <div>
                                    <label class="text-sm font-medium">Email Address</label>
                                    <input type="email" name="email" required placeholder="john@example.com"
                                        class="w-full border rounded-xl p-2.5 focus:ring-2 focus:ring-indigo-500 outline-none">
                                </div>
                                
                                <div>
                                    <label class="text-sm font-medium">Phone Number</label>
                                    <input type="text" name="phone" placeholder="+92 300..."
                                        class="w-full border rounded-xl p-2.5 focus:ring-2 focus:ring-indigo-500 outline-none">
                                </div>

                                <div class="col-span-2">
                                    <label class="text-sm font-medium">Password</label>
                                    <input type="password" name="password" required placeholder="Min 8 characters"
                                        class="w-full border rounded-xl p-2.5 focus:ring-2 focus:ring-indigo-500 outline-none">
                                </div>

                                <div>
                                    <label class="text-sm font-medium">City</label>
                                    <input type="text" name="city" placeholder="Islamabad"
                                        class="w-full border rounded-xl p-2.5 focus:ring-2 focus:ring-indigo-500 outline-none">
                                </div>
                                
                                <div>
                                    <label class="text-sm font-medium">Address</label>
                                    <input type="text" name="address" placeholder="St 1, Sector G-10"
                                        class="w-full border rounded-xl p-2.5 focus:ring-2 focus:ring-indigo-500 outline-none">
                                </div>
                            </div>
                        </div>

                        <div class="p-6 bg-gray-50 border-t flex justify-end gap-3">
                            <button type="button" @click="isAddVendorModalOpen = false" :disabled="isSubmitting"
                                class="px-4 py-2 text-gray-600">Cancel</button>

                            <button type="submit"
                                class="px-6 py-2 bg-indigo-600 text-white rounded-xl font-bold flex items-center disabled:bg-indigo-400"
                                :disabled="isSubmitting">
                                <svg x-show="isSubmitting" class="animate-spin -ml-1 mr-3 h-5 w-5 text-white"
                                    fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                <span x-text="isSubmitting ? 'Saving...' : 'Save Rider'"></span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection