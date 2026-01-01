@extends('layouts.app')

{{-- Assume 'app' layout includes necessary Tailwind CSS and Alpine.js setup --}}

@section('content')
    {{-- Alpine.js state for managing the slide-over panel --}}
    <div id="rider-management-page" class="space-y-6 p-4 md:p-8 bg-gray-50 min-h-screen" 
         x-data="{ 
            openRiderId: null, 
            currentTab: 'profile',
            
            // Function to simulate approving a doc
            approveDoc(docType) {
                alert(docType + ' has been approved for this rider.');
            }
         }" x-cloak>

        {{-- 1. Header and Actions --}}
        <header class="flex flex-col sm:flex-row justify-between items-start sm:items-center pb-4 border-b border-gray-200">
            <div class="mb-4 sm:mb-0">
                <h1 class="text-2xl md:text-3xl font-bold text-gray-900 flex items-center">
                    <svg class="w-6 h-6 md:w-8 md:h-8 mr-3 text-red-600" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.828 0l-4.243-4.243a8 8 0 1111.314 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                    FixnServe Rider Management
                </h1>
                <p class="text-xs sm:text-sm text-gray-500 mt-1">Manage delivery fleet, verification, and Fixora Wallet payouts.</p>
            </div>
            <div class="flex flex-wrap gap-2">
                <button
                    class="flex items-center px-3 py-2 text-sm font-medium text-white bg-red-600 rounded-lg hover:bg-red-700 shadow-md transition duration-150 ease-in-out">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                    </svg>
                    Add New Rider
                </button>
            </div>
        </header>

        {{-- 2. Dashboard Summary Cards (KPIs from Document) --}}
        <section class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-4 gap-4">
            @php
                $cards = [
                    ['title' => 'Total Riders', 'value' => '4,100', 'color' => 'red', 'trend' => '+5%'],
                    ['title' => 'Active Online', 'value' => '1,850', 'color' => 'green', 'trend' => 'Now'],
                    ['title' => 'Pending Verification', 'value' => '55', 'color' => 'orange', 'trend' => 'Action Req'],
                    ['title' => 'Avg Rating', 'value' => '4.7 ★', 'color' => 'yellow', 'trend' => 'High'],
                    ['title' => 'Deliveries Today', 'value' => '9,800', 'color' => 'blue', 'trend' => 'Live'],
                    ['title' => 'Wallet Balance', 'value' => '$45,200', 'color' => 'teal', 'trend' => 'Liability'],
                    ['title' => 'Pending Withdrawals', 'value' => '$15,400', 'color' => 'pink', 'trend' => 'High'],
                    ['title' => 'Top Vehicle', 'value' => 'Bike (70%)', 'color' => 'indigo', 'trend' => 'Type'],
                ];
            @endphp

            @foreach ($cards as $card)
                <div class="bg-white p-3 sm:p-4 rounded-xl shadow-lg border border-gray-100 hover:border-red-100 transition duration-300">
                    <div class="flex items-center justify-between">
                        <p class="text-xs font-medium text-gray-500 truncate uppercase tracking-wider">{{ $card['title'] }}</p>
                        <span class="text-[10px] font-semibold text-{{ $card['color'] }}-600 bg-{{ $card['color'] }}-50 px-2 py-0.5 rounded-full">{{ $card['trend'] }}</span>
                    </div>
                    <div class="mt-2">
                        <p class="text-xl sm:text-2xl font-bold text-gray-900">{{ $card['value'] }}</p>
                    </div>
                </div>
            @endforeach
        </section>

        {{-- Main Content Area: Filters and Table --}}
        <div x-data="{
            searchText: '',
            availabilityFilter: 'Availability',
            kycFilter: 'Document Status',
            
            // Mock Data aligned with FixnServe Requirements
            riders: [
                { 
                    id: 201, 
                    name: 'Javed Ali', 
                    tag: 'FX-201', 
                    vehicleType: 'Bike', 
                    regNo: 'RIM-456', 
                    contact: '+92 300 1234567', 
                    kyc: 'Verified', 
                    availability: 'Online', 
                    currentOrder: 'Picking up at G-10', 
                    rating: 4.8, 
                    walletBalance: 15400, 
                    withdrawalStatus: 'Pending', 
                    img: 'https://ui-avatars.com/api/?name=Javed+Ali&background=EF4444&color=fff' 
                },
                { 
                    id: 202, 
                    name: 'Sarah Khan', 
                    tag: 'FX-202', 
                    vehicleType: 'Car', 
                    regNo: 'ISL-901', 
                    contact: '+92 333 9876543', 
                    kyc: 'Pending', 
                    availability: 'Offline', 
                    currentOrder: '-', 
                    rating: 4.9, 
                    walletBalance: 3200, 
                    withdrawalStatus: 'None', 
                    img: 'https://ui-avatars.com/api/?name=Sarah+Khan&background=10B981&color=fff' 
                },
            ],
        
            filteredRiders() {
                return this.riders.filter(rider => {
                    const searchMatch = this.searchText === '' ||
                        rider.name.toLowerCase().includes(this.searchText.toLowerCase()) ||
                        rider.tag.toLowerCase().includes(this.searchText.toLowerCase());
                    return searchMatch;
                });
            },
            
            getKYCColor(status) {
                return { 'Verified': 'bg-green-100 text-green-800', 'Pending': 'bg-orange-100 text-orange-800' }[status] || 'bg-gray-100';
            }
        }" class="mt-8 bg-white rounded-xl shadow-2xl border border-gray-100 overflow-hidden">

            {{-- Filter Bar --}}
            <div class="p-4 sm:p-6 border-b border-gray-100 bg-gray-50/50">
                <div class="flex flex-col sm:flex-row gap-4 justify-between items-center">
                    <div class="relative w-full sm:w-96">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                             <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        </span>
                        <input type="text" x-model="searchText" placeholder="Search by Name, Vehicle Reg, or ID..." 
                               class="w-full pl-10 pr-4 py-2 border-gray-300 rounded-lg focus:ring-red-500 focus:border-red-500 shadow-sm text-sm">
                    </div>
                    
                    <div class="flex gap-2 w-full sm:w-auto">
                        <select class="form-select rounded-lg border-gray-300 text-sm focus:ring-red-500">
                            <option>All Statuses</option>
                            <option>Online</option>
                            <option>Offline</option>
                        </select>
                        <select class="form-select rounded-lg border-gray-300 text-sm focus:ring-red-500">
                            <option>All Vehicles</option>
                            <option>Bike</option>
                            <option>Car</option>
                            <option>Loader</option>
                        </select>
                    </div>
                </div>
            </div>

            {{-- Table --}}
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Rider Profile</th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Status & Stats</th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Fixora Wallet</th>
                            <th class="px-6 py-3 text-right text-xs font-bold text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-100">
                        <template x-for="rider in filteredRiders()" :key="rider.id">
                            <tr class="hover:bg-red-50/30 transition duration-150 group cursor-pointer" @click="openRiderId = rider.id; currentTab = 'profile'">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <img class="h-10 w-10 rounded-full object-cover border border-gray-200" :src="rider.img" :alt="rider.name">
                                        <div class="ml-4">
                                            <div class="text-sm font-bold text-gray-900" x-text="rider.name"></div>
                                            <div class="text-xs text-gray-500" x-text="rider.contact"></div>
                                            <div class="mt-1 flex gap-1">
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800" x-text="rider.vehicleType + ' | ' + rider.regNo"></span>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium" 
                                              :class="rider.availability === 'Online' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800'">
                                            <span class="w-2 h-2 mr-1.5 rounded-full" :class="rider.availability === 'Online' ? 'bg-green-400' : 'bg-gray-400'"></span>
                                            <span x-text="rider.availability"></span>
                                        </span>
                                    </div>
                                    <div class="text-xs text-gray-500 mt-1" x-text="rider.currentOrder"></div>
                                    <div class="flex items-center mt-1">
                                        <svg class="w-4 h-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.012 8.73c-.783-.57-.381-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                                        <span class="text-xs font-semibold ml-1" x-text="rider.rating"></span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-bold text-gray-900" x-text="'PKR ' + rider.walletBalance.toLocaleString()"></div>
                                    <template x-if="rider.withdrawalStatus === 'Pending'">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-pink-100 text-pink-800">
                                            Payout Requested
                                        </span>
                                    </template>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <button class="text-red-600 hover:text-red-900 font-semibold">Manage</button>
                                </td>
                            </tr>
                        </template>
                    </tbody>
                </table>
            </div>
        </div>

        {{-- 4. Rider Details Slide-Over Panel (Updated for FixnServe Flow) --}}
        <div x-show="openRiderId !== null" 
             class="fixed inset-0 overflow-hidden z-50" style="display: none;">
            
            <div class="absolute inset-0 overflow-hidden">
                <div class="absolute inset-0 bg-gray-500 bg-opacity-75 transition-opacity" @click="openRiderId = null"></div>

                <div class="fixed inset-y-0 right-0 max-w-full flex">
                    <div class="w-screen max-w-2xl bg-white shadow-2xl flex flex-col h-full transform transition ease-in-out duration-300">
                        
                        {{-- Slide-over Header --}}
                        <div class="px-4 sm:px-6 py-6 bg-red-700 text-white shadow-md z-10">
                            <div class="flex items-start justify-between">
                                <div>
                                    <h2 class="text-lg font-bold">Rider Details</h2>
                                    <p class="text-red-100 text-sm" x-text="'ID: FX-' + openRiderId"></p>
                                </div>
                                <button @click="openRiderId = null" class="text-red-200 hover:text-white">
                                    <span class="sr-only">Close panel</span>
                                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                                </button>
                            </div>
                        </div>

                        {{-- Slide-over Tabs --}}
                        <div class="border-b border-gray-200 bg-gray-50 px-6">
                            <nav class="-mb-px flex space-x-6" aria-label="Tabs">
                                <button @click="currentTab = 'profile'" :class="currentTab === 'profile' ? 'border-red-500 text-red-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'" class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                                    Profile
                                </button>
                                <button @click="currentTab = 'kyc'" :class="currentTab === 'kyc' ? 'border-red-500 text-red-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'" class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                                    Documents (KYC)
                                </button>
                                <button @click="currentTab = 'wallet'" :class="currentTab === 'wallet' ? 'border-red-500 text-red-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'" class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                                    Fixora Wallet
                                </button>
                                <button @click="currentTab = 'history'" :class="currentTab === 'history' ? 'border-red-500 text-red-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'" class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                                    Trip History
                                </button>
                            </nav>
                        </div>

                        {{-- Slide-over Content --}}
                        <div class="flex-1 overflow-y-auto p-6 bg-white">
                            
                            {{-- TAB 1: Profile --}}
                            <div x-show="currentTab === 'profile'" class="space-y-6">
                                <h3 class="text-lg font-medium leading-6 text-gray-900">Account Information</h3>
                                <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-2">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-500">Full Name</label>
                                        <div class="mt-1 text-sm text-gray-900 font-semibold">Javed Ali</div>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-500">Email Address</label>
                                        <div class="mt-1 text-sm text-gray-900">javed.ali@example.com</div>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-500">Phone Number</label>
                                        <div class="mt-1 text-sm text-gray-900">+92 300 1234567</div>
                                    </div>
                                </div>
                                <hr>
                                <h3 class="text-lg font-medium leading-6 text-gray-900">Vehicle Details</h3>
                                <div class="bg-gray-50 p-4 rounded-lg border border-gray-200 grid grid-cols-1 gap-y-4 sm:grid-cols-2">
                                    <div>
                                        <label class="block text-xs font-medium text-gray-500 uppercase">Vehicle Type</label>
                                        <div class="mt-1 text-sm text-gray-900 font-bold">Motorbike</div>
                                    </div>
                                    <div>
                                        <label class="block text-xs font-medium text-gray-500 uppercase">Registration Number</label>
                                        <div class="mt-1 text-sm text-gray-900 font-bold">RIM-456</div>
                                    </div>
                                </div>
                            </div>

                            {{-- TAB 2: Documents / KYC (Matches Doc Phase 1) --}}
                            <div x-show="currentTab === 'kyc'" class="space-y-6">
                                <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4">
                                    <div class="flex">
                                        <div class="ml-3">
                                            <p class="text-sm text-yellow-700">
                                                Review uploaded documents carefully before approving. These are required for trust & compliance.
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                <div class="space-y-4">
                                    {{-- Doc Item 1 --}}
                                    <div class="border border-gray-200 rounded-lg p-4 flex justify-between items-center">
                                        <div>
                                            <h4 class="text-sm font-bold text-gray-900">CNIC / Passport</h4>
                                            <p class="text-xs text-gray-500">Uploaded: 2 hours ago</p>
                                        </div>
                                        <div class="flex gap-2">
                                            <button class="text-xs bg-gray-100 px-3 py-1 rounded hover:bg-gray-200">View</button>
                                            <button @click="approveDoc('CNIC')" class="text-xs bg-green-600 text-white px-3 py-1 rounded hover:bg-green-700">Approve</button>
                                        </div>
                                    </div>

                                    {{-- Doc Item 2 --}}
                                    <div class="border border-gray-200 rounded-lg p-4 flex justify-between items-center">
                                        <div>
                                            <h4 class="text-sm font-bold text-gray-900">Driving License</h4>
                                            <p class="text-xs text-gray-500">Uploaded: 2 hours ago</p>
                                        </div>
                                        <div class="flex gap-2">
                                            <button class="text-xs bg-gray-100 px-3 py-1 rounded hover:bg-gray-200">View</button>
                                            <button @click="approveDoc('License')" class="text-xs bg-green-600 text-white px-3 py-1 rounded hover:bg-green-700">Approve</button>
                                        </div>
                                    </div>

                                    {{-- Doc Item 3 --}}
                                    <div class="border border-gray-200 rounded-lg p-4 flex justify-between items-center">
                                        <div>
                                            <h4 class="text-sm font-bold text-gray-900">Vehicle Registration Book</h4>
                                            <p class="text-xs text-gray-500">Uploaded: 2 hours ago</p>
                                        </div>
                                        <div class="flex gap-2">
                                            <button class="text-xs bg-gray-100 px-3 py-1 rounded hover:bg-gray-200">View</button>
                                            <button @click="approveDoc('Vehicle Docs')" class="text-xs bg-green-600 text-white px-3 py-1 rounded hover:bg-green-700">Approve</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- TAB 3: Fixora Wallet (Matches Doc Phase 4) --}}
                            <div x-show="currentTab === 'wallet'" class="space-y-6">
                                <div class="bg-gradient-to-r from-gray-900 to-gray-800 rounded-xl p-6 text-white shadow-lg">
                                    <p class="text-sm text-gray-400">Current Wallet Balance</p>
                                    <h2 class="text-3xl font-bold mt-1">PKR 15,400</h2>
                                    <div class="mt-4 flex justify-between items-center border-t border-gray-700 pt-4">
                                        <div class="text-xs">
                                            <p class="text-gray-400">Total Earnings</p>
                                            <p class="font-semibold">PKR 45,000</p>
                                        </div>
                                        <div class="text-xs text-right">
                                            <p class="text-gray-400">Withdrawn</p>
                                            <p class="font-semibold">PKR 29,600</p>
                                        </div>
                                    </div>
                                </div>

                                <h4 class="font-bold text-gray-900 mt-4">Withdrawal Requests</h4>
                                <div class="bg-white border border-gray-200 rounded-lg overflow-hidden">
                                    <table class="min-w-full divide-y divide-gray-200">
                                        <thead class="bg-gray-50">
                                            <tr>
                                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500">Date</th>
                                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500">Amount</th>
                                                <th class="px-4 py-2 text-right text-xs font-medium text-gray-500">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody class="divide-y divide-gray-200">
                                            <tr>
                                                <td class="px-4 py-2 text-sm text-gray-900">Dec 30, 2025</td>
                                                <td class="px-4 py-2 text-sm font-bold text-gray-900">PKR 5,000</td>
                                                <td class="px-4 py-2 text-right">
                                                    <button class="text-xs bg-red-600 text-white px-2 py-1 rounded hover:bg-red-700">Pay Now</button>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            {{-- TAB 4: Trip History & Proofs --}}
                            <div x-show="currentTab === 'history'" class="space-y-6">
                                <h3 class="text-lg font-medium text-gray-900">Completed Deliveries</h3>
                                <div class="space-y-4">
                                    {{-- History Item --}}
                                    <div class="bg-white border border-gray-200 rounded-lg p-4 shadow-sm">
                                        <div class="flex justify-between items-start">
                                            <div>
                                                <p class="text-xs font-bold text-red-600">ORDER #9081</p>
                                                <p class="text-sm font-semibold mt-1">Pickup: Blue Area</p>
                                                <p class="text-sm font-semibold">Dropoff: F-10 Markaz</p>
                                            </div>
                                            <div class="text-right">
                                                <span class="bg-green-100 text-green-800 text-xs px-2 py-0.5 rounded-full">Completed</span>
                                                <p class="text-xs text-gray-500 mt-1">Dec 31, 10:30 AM</p>
                                            </div>
                                        </div>
                                        <div class="mt-3 pt-3 border-t border-gray-100 flex justify-between items-center">
                                            <div class="text-xs">
                                                <span class="text-gray-500">Earning:</span> <span class="font-bold">PKR 450</span>
                                            </div>
                                            <button class="text-xs text-blue-600 hover:underline">View Delivery Proof (Sign/Photo)</button>
                                        </div>
                                    </div>
                                    
                                     {{-- History Item --}}
                                     <div class="bg-white border border-gray-200 rounded-lg p-4 shadow-sm">
                                        <div class="flex justify-between items-start">
                                            <div>
                                                <p class="text-xs font-bold text-red-600">ORDER #9075</p>
                                                <p class="text-sm font-semibold mt-1">Pickup: Saddar</p>
                                                <p class="text-sm font-semibold">Dropoff: Westridge</p>
                                            </div>
                                            <div class="text-right">
                                                <span class="bg-green-100 text-green-800 text-xs px-2 py-0.5 rounded-full">Completed</span>
                                                <p class="text-xs text-gray-500 mt-1">Dec 30, 04:15 PM</p>
                                            </div>
                                        </div>
                                        <div class="mt-3 pt-3 border-t border-gray-100 flex justify-between items-center">
                                            <div class="text-xs">
                                                <span class="text-gray-500">Earning:</span> <span class="font-bold">PKR 320</span>
                                            </div>
                                            <button class="text-xs text-blue-600 hover:underline">View Delivery Proof (Sign/Photo)</button>
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
@endsection