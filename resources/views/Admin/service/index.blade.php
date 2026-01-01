@extends('layouts.app')

@section('content')
    <div id="service-management-page" class="space-y-6 p-4 md:p-8 bg-gray-50 min-h-screen" 
         x-data="{ 
            currentModule: 'services', // 'services' or 'promos'
            openServiceId: null, 
            isEditing: false,
            serviceModalTab: 'details', // details, pricing
            
            // Mock Data for Services
            services: [
                { id: 101, name: 'AC Repair & Service', category: 'Home Repair', price: 50.00, active: true, image: 'https://via.placeholder.com/40', pricingType: 'Fixed' },
                { id: 102, name: 'Full House Cleaning', category: 'Cleaning', price: 120.00, active: true, image: 'https://via.placeholder.com/40', pricingType: 'Dynamic' },
                { id: 103, name: 'Plumbing Check', category: 'Plumbing', price: 30.00, active: false, image: 'https://via.placeholder.com/40', pricingType: 'Fixed' },
            ],

            // Mock Data for Promo Codes
            promos: [
                { code: 'WELCOME20', type: 'Percentage', value: 20, usage: '50/100', status: 'Active', expiry: '2025-12-31' },
                { code: 'FIX50OFF', type: 'Flat Amount', value: 50, usage: '12/500', status: 'Active', expiry: '2026-01-15' },
                { code: 'SUMMER_DEAL', type: 'Percentage', value: 15, usage: 'Expired', status: 'Inactive', expiry: '2024-08-30' },
            ],

            // Actions
            toggleServiceStatus(id) {
                // Logic to call API
                console.log('Toggled service ' + id);
            },
            openAddService() {
                this.openServiceId = 'new';
                this.isEditing = false;
                this.serviceModalTab = 'details';
            },
            openEditService(id) {
                this.openServiceId = id;
                this.isEditing = true;
                this.serviceModalTab = 'details';
            }
         }" x-cloak>

        {{-- 1. Header & Module Switcher --}}
        <header class="flex flex-col md:flex-row justify-between items-center pb-4 border-b border-gray-200 gap-4">
            <div>
                <h1 class="text-2xl md:text-3xl font-bold text-gray-900 flex items-center">
                    <svg class="w-8 h-8 mr-3 text-cyan-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path>
                    </svg>
                    Service Management
                </h1>
                <p class="text-sm text-gray-500 mt-1">Manage service catalog, pricing engines, and promotional campaigns.</p>
            </div>

            {{-- Top Level Navigation --}}
            <div class="bg-gray-100 p-1 rounded-lg flex space-x-1">
                <button @click="currentModule = 'services'" 
                    :class="currentModule === 'services' ? 'bg-white text-gray-900 shadow-sm' : 'text-gray-500 hover:text-gray-700'"
                    class="px-4 py-2 text-sm font-medium rounded-md transition-all">
                    Services Catalog
                </button>
                <button @click="currentModule = 'promos'"
                    :class="currentModule === 'promos' ? 'bg-white text-gray-900 shadow-sm' : 'text-gray-500 hover:text-gray-700'"
                    class="px-4 py-2 text-sm font-medium rounded-md transition-all">
                    Promotions & Codes
                </button>
            </div>
            
            <div>
                 <button x-show="currentModule === 'services'" @click="openAddService()"
                    class="flex items-center px-4 py-2 text-sm font-medium text-white bg-cyan-600 rounded-lg hover:bg-cyan-700 shadow-md transition">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                    Add Service
                </button>
                 <button x-show="currentModule === 'promos'"
                    class="flex items-center px-4 py-2 text-sm font-medium text-white bg-pink-600 rounded-lg hover:bg-pink-700 shadow-md transition">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"></path></svg>
                    Create Promo Code
                </button>
            </div>
        </header>

        {{-- MODULE 1: SERVICE CATALOG --}}
        <div x-show="currentModule === 'services'" x-transition.opacity>
            
            {{-- KPI Cards --}}
            <section class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
                <div class="bg-white p-4 rounded-xl shadow border border-gray-100">
                    <p class="text-xs text-gray-500 uppercase">Total Services</p>
                    <p class="text-2xl font-bold text-gray-800">124</p>
                </div>
                <div class="bg-white p-4 rounded-xl shadow border border-gray-100">
                    <p class="text-xs text-gray-500 uppercase">Active Categories</p>
                    <p class="text-2xl font-bold text-gray-800">12</p>
                </div>
                <div class="bg-white p-4 rounded-xl shadow border border-gray-100">
                    <p class="text-xs text-gray-500 uppercase">Avg Service Price</p>
                    <p class="text-2xl font-bold text-green-600">$45.00</p>
                </div>
                <div class="bg-white p-4 rounded-xl shadow border border-gray-100">
                    <p class="text-xs text-gray-500 uppercase">Surge Active</p>
                    <p class="text-2xl font-bold text-orange-500">3 Areas</p>
                </div>
            </section>

            {{-- Service List Table --}}
            <div class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden">
                <div class="p-4 border-b border-gray-100 flex gap-4">
                    <input type="text" placeholder="Search services..." class="flex-1 rounded-lg border-gray-300 text-sm focus:ring-cyan-500">
                    <select class="rounded-lg border-gray-300 text-sm focus:ring-cyan-500 bg-gray-50">
                        <option>All Categories</option>
                        <option>Plumbing</option>
                        <option>Cleaning</option>
                    </select>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Service Info</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pricing</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-100">
                            <template x-for="service in services" :key="service.id">
                                <tr class="hover:bg-cyan-50/30 transition">
                                    <td class="px-6 py-4 whitespace-nowrap flex items-center">
                                        <div class="h-10 w-10 flex-shrink-0 bg-gray-100 rounded-lg flex items-center justify-center text-gray-400">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path></svg>
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900" x-text="service.name"></div>
                                            <div class="text-xs text-gray-500" x-text="service.category"></div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-bold text-gray-900" x-text="'$' + service.price.toFixed(2)"></div>
                                        <div class="text-xs text-gray-500" x-text="service.pricingType"></div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <button @click="service.active = !service.active" 
                                            class="relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none"
                                            :class="service.active ? 'bg-cyan-600' : 'bg-gray-200'">
                                            <span class="pointer-events-none inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out"
                                                :class="service.active ? 'translate-x-5' : 'translate-x-0'"></span>
                                        </button>
                                        <span class="ml-2 text-xs font-medium" :class="service.active ? 'text-cyan-700' : 'text-gray-500'" x-text="service.active ? 'Active' : 'Inactive'"></span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <button @click="openEditService(service.id)" class="text-cyan-600 hover:text-cyan-900 mr-3">Edit</button>
                                    </td>
                                </tr>
                            </template>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- MODULE 2: PROMO CODES --}}
        <div x-show="currentModule === 'promos'" x-transition.opacity style="display: none;">
            <div class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden">
                <div class="p-6 border-b border-gray-200 bg-pink-50">
                    <h3 class="text-lg font-bold text-pink-800">Active Promotions</h3>
                    <p class="text-sm text-pink-600">Manage discount codes and marketing campaigns.</p>
                </div>
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Promo Code</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Discount</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Usage / Limit</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Expiry</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-100">
                        <template x-for="promo in promos" :key="promo.code">
                            <tr>
                                <td class="px-6 py-4">
                                    <span class="px-3 py-1 rounded bg-gray-100 font-mono text-gray-800 font-bold tracking-wider" x-text="promo.code"></span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm font-bold text-gray-900" x-text="promo.type === 'Percentage' ? promo.value + '%' : '$' + promo.value"></div>
                                    <div class="text-xs text-gray-500" x-text="promo.type"></div>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-600" x-text="promo.usage"></td>
                                <td class="px-6 py-4 text-sm text-gray-600" x-text="promo.expiry"></td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium" 
                                          :class="promo.status === 'Active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'"
                                          x-text="promo.status"></span>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <button class="text-gray-400 hover:text-red-600">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </td>
                            </tr>
                        </template>
                    </tbody>
                </table>
            </div>
        </div>

        {{-- SLIDE-OVER: ADD / EDIT SERVICE & PRICING CONTROL --}}
        <div x-show="openServiceId !== null" class="fixed inset-0 overflow-hidden z-50" style="display: none;">
            <div class="absolute inset-0 overflow-hidden">
                <div class="absolute inset-0 bg-gray-500 bg-opacity-75 transition-opacity" @click="openServiceId = null"></div>

                <div class="fixed inset-y-0 right-0 max-w-full flex">
                    <div class="w-screen max-w-xl bg-white shadow-2xl flex flex-col h-full transform transition ease-in-out duration-300">
                        
                        {{-- Header --}}
                        <div class="bg-cyan-700 px-4 py-6 sm:px-6">
                            <div class="flex items-start justify-between">
                                <h2 class="text-lg font-medium text-white" x-text="isEditing ? 'Edit Service Details' : 'Add New Service'"></h2>
                                <button @click="openServiceId = null" class="text-cyan-200 hover:text-white">
                                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                                </button>
                            </div>
                        </div>

                        {{-- Tabs --}}
                        <div class="border-b border-gray-200">
                            <nav class="-mb-px flex" aria-label="Tabs">
                                <button @click="serviceModalTab = 'details'" 
                                    class="w-1/2 py-4 px-1 text-center border-b-2 text-sm font-medium"
                                    :class="serviceModalTab === 'details' ? 'border-cyan-500 text-cyan-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'">
                                    Basic Info & Media
                                </button>
                                <button @click="serviceModalTab = 'pricing'" 
                                    class="w-1/2 py-4 px-1 text-center border-b-2 text-sm font-medium"
                                    :class="serviceModalTab === 'pricing' ? 'border-cyan-500 text-cyan-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'">
                                    Pricing Control
                                </button>
                            </nav>
                        </div>

                        {{-- Content --}}
                        <div class="flex-1 overflow-y-auto p-6">
                            
                            {{-- TAB 1: DETAILS --}}
                            <div x-show="serviceModalTab === 'details'" class="space-y-6">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Service Name</label>
                                    <input type="text" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-cyan-500 focus:ring-cyan-500 sm:text-sm" placeholder="e.g. AC Deep Cleaning">
                                </div>
                                
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Category</label>
                                        <select class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-cyan-500 focus:ring-cyan-500 sm:text-sm">
                                            <option>Home Repair</option>
                                            <option>Cleaning</option>
                                            <option>Plumbing</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Status</label>
                                        <select class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-cyan-500 focus:ring-cyan-500 sm:text-sm">
                                            <option>Active</option>
                                            <option>Inactive</option>
                                        </select>
                                    </div>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Description</label>
                                    <textarea rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-cyan-500 focus:ring-cyan-500 sm:text-sm"></textarea>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Service Icons / Images</label>
                                    <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md">
                                        <div class="space-y-1 text-center">
                                            <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48"><path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" /></svg>
                                            <div class="flex text-sm text-gray-600">
                                                <label class="relative cursor-pointer bg-white rounded-md font-medium text-cyan-600 hover:text-cyan-500">
                                                    <span>Upload a file</span>
                                                    <input type="file" class="sr-only">
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- TAB 2: PRICING CONTROL --}}
                            <div x-show="serviceModalTab === 'pricing'" class="space-y-6">
                                <div class="bg-blue-50 p-4 rounded-md border border-blue-200">
                                    <h3 class="text-blue-800 font-medium text-sm">Default Pricing</h3>
                                    <div class="mt-3">
                                        <label class="block text-sm font-medium text-gray-700">Base Price (PKR)</label>
                                        <div class="mt-1 relative rounded-md shadow-sm">
                                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                <span class="text-gray-500 sm:text-sm">$</span>
                                            </div>
                                            <input type="number" class="focus:ring-cyan-500 focus:border-cyan-500 block w-full pl-7 pr-12 sm:text-sm border-gray-300 rounded-md" placeholder="0.00" value="50.00">
                                        </div>
                                    </div>
                                </div>

                                <div>
                                    <h3 class="text-gray-900 font-medium">Surge Pricing Logic</h3>
                                    <p class="text-xs text-gray-500 mb-3">Automatically adjust price based on demand.</p>
                                    <div class="flex items-center justify-between mb-4">
                                        <span class="text-sm text-gray-700">Enable Surge Pricing?</span>
                                        <button type="button" class="bg-gray-200 relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none" role="switch" aria-checked="false">
                                            <span aria-hidden="true" class="translate-x-0 pointer-events-none inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out"></span>
                                        </button>
                                    </div>
                                    <div class="grid grid-cols-2 gap-4">
                                        <div>
                                            <label class="block text-xs font-medium text-gray-500">Multiplier (High Demand)</label>
                                            <input type="text" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm sm:text-sm" value="1.5x">
                                        </div>
                                        <div>
                                            <label class="block text-xs font-medium text-gray-500">Multiplier (Rain/Storm)</label>
                                            <input type="text" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm sm:text-sm" value="2.0x">
                                        </div>
                                    </div>
                                </div>

                                <hr>

                                <div>
                                    <h3 class="text-gray-900 font-medium">Service-Specific Discount</h3>
                                    <div class="mt-2">
                                        <label class="block text-sm font-medium text-gray-700">Discount Amount</label>
                                        <input type="text" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm sm:text-sm" placeholder="e.g. 10%">
                                    </div>
                                </div>
                            </div>

                        </div>

                        {{-- Footer Actions --}}
                        <div class="border-t border-gray-200 px-4 py-6 sm:px-6 bg-gray-50 flex justify-end gap-3">
                            <button @click="openServiceId = null" class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50">Cancel</button>
                            <button @click="openServiceId = null" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-cyan-600 hover:bg-cyan-700">Save Changes</button>
                        </div>

                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection