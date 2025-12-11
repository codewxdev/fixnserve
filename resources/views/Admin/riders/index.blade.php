@extends('layouts.app')

{{-- Assume 'app' layout includes necessary Tailwind CSS and Alpine.js setup --}}

@section('content')
    {{-- Alpine.js state for managing the slide-over panel --}}
    <div id="rider-management-page" class="space-y-6 p-4 md:p-8 bg-gray-50 min-h-screen" x-data="{ openRiderId: null, currentTab: 'profile' }" x-cloak>

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
                    Rider Management
                </h1>
                <p class="text-xs sm:text-sm text-gray-500 mt-1">Manage delivery personnel, track location, assignments, and
                    earnings.</p>
            </div>
            <div class="flex flex-wrap gap-2">
                <button
                    class="flex items-center px-3 py-2 text-sm font-medium text-white bg-red-600 rounded-lg hover:bg-red-700 shadow-md transition duration-150 ease-in-out">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    Onboard New Rider
                </button>
            </div>
        </header>

        <hr class="border-gray-200">

        {{-- 2. Dashboard Summary Cards (Responsive Grid) --}}
        <section class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-4 gap-4">
            @php
                $cards = [
                    [
                        'title' => 'Total Riders',
                        'value' => '4,100',
                        'icon' => 'user',
                        'color' => 'red',
                        'trend' => '+5% MoM',
                    ],
                    [
                        'title' => 'Riders Online',
                        'value' => '1,850',
                        'icon' => 'signal',
                        'color' => 'green',
                        'trend' => '45%',
                    ],
                    [
                        'title' => 'Pending KYC',
                        'value' => '55',
                        'icon' => 'document',
                        'color' => 'orange',
                        'trend' => 'Urgent',
                    ],
                    [
                        'title' => 'Avg Rating',
                        'value' => '4.7 / 5',
                        'icon' => 'star',
                        'color' => 'yellow',
                        'trend' => 'High',
                    ],
                    [
                        'title' => 'Orders Assigned',
                        'value' => '9,800',
                        'icon' => 'deliver',
                        'color' => 'blue',
                        'trend' => 'Today',
                    ],
                    [
                        'title' => 'Total Penalties',
                        'value' => '$1,200',
                        'icon' => 'ban',
                        'color' => 'pink',
                        'trend' => 'Weekly',
                    ],
                    [
                        'title' => 'Pending Withdrawals',
                        'value' => '$15,400',
                        'icon' => 'wallet',
                        'color' => 'teal',
                        'trend' => 'High',
                    ],
                    [
                        'title' => 'Top Vehicle Type',
                        'value' => 'Bike (70%)',
                        'icon' => 'bike',
                        'color' => 'indigo',
                        'trend' => 'Dominant',
                    ],
                ];
            @endphp

            @foreach ($cards as $card)
                <div
                    class="bg-white p-3 sm:p-4 rounded-xl shadow-lg hover:shadow-xl transform hover:scale-[1.03] transition duration-300 ease-in-out border border-gray-100">
                    <div class="flex items-center justify-between">
                        <p class="text-xs font-medium text-gray-500 truncate">{{ $card['title'] }}</p>
                        <span
                            class="text-[10px] font-semibold text-{{ $card['color'] }}-500 hidden sm:block">{{ $card['trend'] }}</span>
                    </div>
                    <div class="flex items-center justify-between mt-1">
                        <p class="text-xl sm:text-2xl font-bold text-gray-900">{{ $card['value'] }}</p>
                        {{-- Icon placeholder here --}}
                    </div>
                </div>
            @endforeach
        </section>

        <hr class="border-gray-200">

        {{-- Main Content Area: Filters and Table --}}
        <div x-data="{
            // Filter State
            searchText: '',
            availabilityFilter: 'Availability',
            kycFilter: 'KYC Status',
            vehicleFilter: 'Vehicle Type',
        
            // Sample Data (Replace with your server-side data fetch)
            riders: [
                { id: 201, name: 'Rider John Doe', tag: 'RDR-201', vehicleType: 'Bike', license: 'ABC-789', contact: '+1 (555) 123-4567', kyc: 'Verified', availability: 'Online', shift: '8h 30m Shift', deliveries: 34, rating: 4.7, earnings: 1540, penalties: 40, withdrawalStatus: 'Pending', img: 'https://via.placeholder.com/150/ef4444/ffffff?text=JD' },
                { id: 202, name: 'Rider Sarah Ahmed', tag: 'RDR-202', vehicleType: 'Car', license: 'XYZ-101', contact: '+1 (555) 987-6543', kyc: 'Pending', availability: 'Offline', shift: 'Last Online: 1h ago', deliveries: 0, rating: 4.9, earnings: 3200, penalties: 10, withdrawalStatus: 'Ready', img: 'https://via.placeholder.com/150/10b981/ffffff?text=SA' },
                { id: 203, name: 'Rider Mike Thompson', tag: 'RDR-203', vehicleType: 'Bike', license: 'TUK-404', contact: '+1 (555) 777-8888', kyc: 'Verified', availability: 'On-Trip', shift: 'Est. complete: 10m', deliveries: 12, rating: 4.5, earnings: 875, penalties: 0, withdrawalStatus: 'Ready', img: 'https://via.placeholder.com/150/f97316/ffffff?text=MT' },
                { id: 204, name: 'Rider Emily Chen', tag: 'RDR-204', vehicleType: 'Car', license: 'UVW-222', contact: '+1 (555) 333-2222', kyc: 'Verified', availability: 'Online', shift: '1h 15m Shift', deliveries: 5, rating: 4.8, earnings: 350, penalties: 0, withdrawalStatus: 'Ready', img: 'https://via.placeholder.com/150/000000/ffffff?text=EC' },
            ],
        
            // Filtering Logic
            filteredRiders() {
                return this.riders.filter(rider => {
                    // 1. Search Filter (Search name, ID, or vehicle/license)
                    const searchMatch = this.searchText === '' ||
                        rider.name.toLowerCase().includes(this.searchText.toLowerCase()) ||
                        rider.tag.toLowerCase().includes(this.searchText.toLowerCase()) ||
                        rider.license.toLowerCase().includes(this.searchText.toLowerCase());
        
                    // 2. Availability Filter
                    const availabilityMatch = this.availabilityFilter === 'Availability' ||
                        rider.availability === this.availabilityFilter;
        
                    // 3. KYC Status Filter
                    const kycMatch = this.kycFilter === 'KYC Status' ||
                        rider.kyc === this.kycFilter.replace('Verified', 'Verified').replace('Pending', 'Pending'); // Clean up option value
        
                    // 4. Vehicle Type Filter
                    const vehicleMatch = this.vehicleFilter === 'Vehicle Type' ||
                        rider.vehicleType === this.vehicleFilter;
        
                    return searchMatch && availabilityMatch && kycMatch && vehicleMatch;
                });
            },
        
            // Reset Function
            resetFilters() {
                this.searchText = '';
                this.availabilityFilter = 'Availability';
                this.kycFilter = 'KYC Status';
                this.vehicleFilter = 'Vehicle Type';
            },
        
            // Utility for status badges
            getAvailabilityColor(status) {
                return {
                    'Online': 'bg-green-500 text-white',
                    'Offline': 'bg-gray-500 text-white',
                    'On-Trip': 'bg-blue-500 text-white',
                } [status];
            },
            getKYCColor(status) {
                return {
                    'Verified': 'bg-green-100 text-green-800',
                    'Pending': 'bg-yellow-100 text-yellow-800',
                } [status];
            },
        }" class="mt-8 bg-white p-4 sm:p-6 rounded-xl shadow-2xl border border-gray-100">

            <div
                class="sticky top-0 z-10 bg-white pt-1 pb-4 -mx-4 sm:-mx-6 px-4 sm:px-6 border-b border-gray-100 shadow-sm rounded-t-xl">
                <h2 class="text-lg sm:text-xl font-semibold text-gray-800 mb-4">Rider Directory</h2>
                <div class="grid grid-cols-2 sm:grid-cols-4 lg:grid-cols-10 gap-3 items-center">

                    <div class="col-span-2 lg:col-span-3 rounded-xl shadow-sm shadow-black/70">
                        <input type="text" placeholder="Search rider name, ID, vehicle..."
                            x-model.debounce.300ms="searchText"
                            class="block w-full text-sm pl-4 pr-4 py-2 border-gray-300 rounded-xl focus:ring-red-500 focus:border-red-500 shadow-sm" />
                    </div>

                    <select x-model="availabilityFilter"
                        class="col-span-2 form-select rounded-xl border-gray-300 shadow-sm shadow-black/70 py-2 px-3 text-sm focus:ring-red-500 focus:border-red-500">
                        <option disabled>Availability</option>
                        <option>Online</option>
                        <option>Offline</option>
                        <option>On-Trip</option>
                    </select>
                    <select x-model="kycFilter"
                        class="col-span-2 form-select rounded-xl border-gray-300 shadow-sm shadow-black/70 py-2 px-3 text-sm focus:ring-red-500 focus:border-red-500">
                        <option disabled>KYC Status</option>
                        <option>Verified</option>
                        <option>Pending</option>
                    </select>
                    <select x-model="vehicleFilter"
                        class="col-span-2 form-select rounded-xl border-gray-300 shadow-sm shadow-black/70 py-2 px-3 text-sm focus:ring-red-500 focus:border-red-500">
                        <option disabled>Vehicle Type</option>
                        <option>Bike</option>
                        <option>Car</option>
                    </select>

                    <div class="col-span-2 sm:col-span-1 flex justify-end">
                        <button @click="resetFilters"
                            class="w-full px-3 py-2 text-sm font-medium text-gray-600 bg-gray-100 rounded-xl hover:bg-gray-200 transition duration-150 ease-in-out">
                            Reset
                        </button>
                    </div>
                </div>
            </div>

            <div class="overflow-x-auto mt-4">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th
                                class="px-3 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider min-w-[280px]">
                                Rider Info / Vehicle
                            </th>
                            <th
                                class="px-3 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider min-w-[300px]">
                                Performance & Status
                            </th>
                            <th
                                class="px-3 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider min-w-[200px]">
                                Finance
                            </th>
                            <th
                                class="px-3 sm:px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider sticky right-0 bg-gray-50 border-l border-gray-200 min-w-[150px]">
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-100">

                        <template x-for="rider in filteredRiders()" :key="rider.id">
                            <tr class="hover:bg-red-50/50 transition duration-150 ease-in-out group">

                                <td class="px-3 sm:px-6 py-3 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <img class="h-10 w-10 rounded-full object-cover shadow-sm mr-3 flex-shrink-0"
                                            :src="rider.img" :alt="rider.name">
                                        <div>
                                            <div class="text-sm font-semibold text-gray-900 group-hover:text-red-600 truncate"
                                                x-text="`${rider.name} (${rider.tag})`">
                                            </div>
                                            <div class="flex items-center text-xs space-x-2 mt-1">
                                                <span class="text-gray-500"
                                                    x-text="`${rider.vehicleType} | ${rider.license}`"></span>
                                                <span
                                                    class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium"
                                                    :class="getKYCColor(rider.kyc)" x-text="`KYC ${rider.kyc}`">
                                                </span>
                                            </div>
                                            <p class="text-xs text-gray-400 mt-1" x-text="`Contact: ${rider.contact}`"></p>
                                        </div>
                                    </div>
                                </td>

                                <td class="px-3 sm:px-6 py-3 text-sm text-gray-500">
                                    <div class="grid grid-cols-2 gap-2 w-full">
                                        <div>
                                            <p class="text-xs font-medium text-gray-400 uppercase">Availability / Shift</p>
                                            <div class="flex items-center space-x-1 mt-1">
                                                <span
                                                    class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold"
                                                    :class="getAvailabilityColor(rider.availability)"
                                                    x-text="rider.availability"></span>
                                                <span class="text-xs text-gray-700" x-text="`| ${rider.shift}`"></span>
                                            </div>
                                        </div>
                                        <div>
                                            <p class="text-xs font-medium text-gray-400 uppercase">Orders / Rating</p>
                                            <p class="font-bold text-gray-700 text-sm"
                                                x-text="`${rider.deliveries} Deliveries (Today)`"></p>
                                            <div class="flex items-center text-xs text-gray-600 mt-1">
                                                <svg class="w-3 h-3 text-yellow-500 mr-1" fill="currentColor"
                                                    viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                    <path
                                                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.012 8.73c-.783-.57-.381-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                                                    </path>
                                                </svg>
                                                <span x-text="`${rider.rating} (Avg)`"></span>
                                            </div>
                                        </div>
                                    </div>
                                </td>

                                <td class="px-3 sm:px-6 py-3 text-sm text-gray-500">
                                    <p class="text-xs font-medium text-gray-400 uppercase">Total Earnings</p>
                                    <p class="font-extrabold text-lg text-red-700"
                                        x-text="`$${rider.earnings.toLocaleString()}`">
                                    </p>
                                    <p class="text-xs text-pink-600 mt-1" x-text="`Penalties: $${rider.penalties}`"></p>
                                    <p class="text-xs mt-1"
                                        :class="{ 'text-orange-500': rider
                                            .withdrawalStatus === 'Pending', 'text-green-500': rider
                                                .withdrawalStatus === 'Ready' }"
                                        x-text="`${rider.withdrawalStatus} Withdrawal`"></p>
                                </td>

                                <td
                                    class="px-3 sm:px-6 py-3 whitespace-nowrap text-right text-sm font-medium sticky right-0 bg-white border-l border-gray-200 group-hover:bg-red-50/50">
                                    <div class="flex justify-end space-x-2">
                                        <button @click.stop="openRiderId = rider.id; currentTab = 'profile'"
                                            class="p-2 rounded-full text-white bg-red-600 hover:bg-red-700 shadow-md transition duration-150 ease-in-out"
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
                                        <button
                                            class="p-2 rounded-full text-blue-500 hover:bg-blue-50 transition duration-150 ease-in-out hidden sm:block"
                                            title="Live Tracking">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.828 0l-4.243-4.243a8 8 0 1111.314 0z">
                                                </path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        </template>

                        <tr x-show="filteredRiders().length === 0">
                            <td colspan="4" class="px-6 py-8 text-center text-gray-500 font-medium">
                                No riders match your current filters or search query.
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        {{-- 4. Rider Details Slide-Over Panel --}}
        <div x-show="openRiderId !== null" x-transition:enter="ease-in-out duration-500"
            x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
            x-transition:leave="ease-in-out duration-500" x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0" class="fixed inset-0 overflow-hidden z-40">

            <div class="absolute inset-0 overflow-hidden">
                {{-- Background overlay --}}
                <div x-show="openRiderId !== null" @click="openRiderId = null"
                    class="absolute inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>

                <div class="fixed inset-y-0 right-0 max-w-full flex">
                    {{-- Slide-over panel (Responsive width) --}}
                    <div x-show="openRiderId !== null"
                        x-transition:enter="transform transition ease-in-out duration-500 sm:duration-700"
                        x-transition:enter-start="translate-x-full" x-transition:enter-end="translate-x-0"
                        x-transition:leave="transform transition ease-in-out duration-500 sm:duration-700"
                        x-transition:leave-start="translate-x-0" x-transition:leave-end="translate-x-full"
                        class="w-screen max-w-md md:max-w-xl lg:max-w-3xl">

                        <div class="h-full flex flex-col bg-white shadow-xl overflow-y-scroll">
                            <div class="p-4 sm:p-6 bg-red-600">
                                {{-- Header and Close Button --}}
                                <div class="flex items-start justify-between">
                                    <h2 id="slide-over-title" class="text-lg sm:text-xl font-bold text-white">
                                        Rider Details (ID: <span x-text="openRiderId"></span>)
                                    </h2>
                                    <button type="button" class="rounded-md text-red-200 hover:text-white"
                                        @click="openRiderId = null">
                                        <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </button>
                                </div>
                            </div>

                            {{-- Tabbed Navigation for Details --}}
                            <nav x-data="{ currentTab: 'profile' }"
                                class="flex space-x-4 px-6 pt-4 border-b border-gray-200 sticky top-0 bg-white z-10 overflow-x-auto">
                                @php
                                    $tabs = [
                                        'Profile',
                                        'KYC & Vehicle',
                                        'Shift & Tracking',
                                        'Orders & History',
                                        'Earnings & Payouts',
                                    ];
                                @endphp
                                @foreach ($tabs as $tab)
                                    <button
                                        @click="currentTab = '{{ strtolower(str_replace([' ', '&'], ['-', ''], $tab)) }}'"
                                        :class="{ 'border-red-500 text-red-600': currentTab === '{{ strtolower(str_replace([' ', '&'], ['-', ''], $tab)) }}', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': currentTab !== '{{ strtolower(str_replace([' ', '&'], ['-', ''], $tab)) }}' }"
                                        class="whitespace-nowrap pb-3 px-1 border-b-2 text-sm font-medium transition duration-150 ease-in-out">
                                        {{ $tab }}
                                    </button>
                                @endforeach
                            </nav>

                            <div class="p-6 flex-1 overflow-y-auto">
                                {{-- Profile Tab Content --}}
                                <div x-show="currentTab === 'profile'" class="space-y-6">
                                    <h3 class="text-lg font-semibold text-gray-900">Personal & Contact Info</h3>
                                    <div class="grid grid-cols-2 gap-4 text-sm">
                                        <div>
                                            <p class="text-gray-500">Full Name</p>
                                            <p class="font-medium">John Doe</p>
                                        </div>
                                        <div>
                                            <p class="text-gray-500">Contact Number</p>
                                            <p class="font-medium">+1 (555) 123-4567</p>
                                        </div>
                                        <div>
                                            <p class="text-gray-500">Email</p>
                                            <p class="font-medium">john.d@delivery.com</p>
                                        </div>
                                        <div>
                                            <p class="text-gray-500">Date Joined</p>
                                            <p class="font-medium">2024-01-15</p>
                                        </div>
                                    </div>

                                    <h3 class="text-lg font-semibold text-gray-900 mt-6">Availability Control</h3>
                                    <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                                        <p class="font-medium text-gray-700">Online Status Toggle</p>
                                        <label class="relative inline-flex items-center cursor-pointer">
                                            <input type="checkbox" value="" class="sr-only peer" checked>
                                            <div
                                                class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-red-300 rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-red-600">
                                            </div>
                                        </label>
                                    </div>
                                </div>

                                {{-- KYC & Vehicle Tab Content --}}
                                <div x-show="currentTab === 'kyc-vehicle'" class="space-y-6">
                                    <h3 class="text-lg font-semibold text-gray-900">KYC & Document Verification</h3>
                                    <div class="bg-red-50 p-4 rounded-xl space-y-3 border border-red-200">
                                        <p class="text-sm font-medium text-red-700">Verification Status: Fully Approved</p>
                                        <ul class="list-disc list-inside text-sm text-gray-600 space-y-1">
                                            <li><span class="font-medium">ID Card:</span> Approved</li>
                                            <li><span class="font-medium">Driving License:</span> Approved (Expires 2028)
                                            </li>
                                            <li><span class="font-medium">Background Check:</span> Cleared</li>
                                        </ul>
                                    </div>
                                    <h3 class="text-lg font-semibold text-gray-900 mt-6">Vehicle Details</h3>
                                    <div class="grid grid-cols-2 gap-4 text-sm">
                                        <div>
                                            <p class="text-gray-500">Vehicle Type</p>
                                            <p class="font-medium">Motorcycle (Bike)</p>
                                        </div>
                                        <div>
                                            <p class="text-gray-500">License Plate</p>
                                            <p class="font-medium">ABC-789</p>
                                        </div>
                                        <div>
                                            <p class="text-gray-500">Model</p>
                                            <p class="font-medium">Honda CG 125</p>
                                        </div>
                                        <div>
                                            <p class="text-gray-500">Registration Docs</p><button
                                                class="text-red-600 hover:underline">View File</button>
                                        </div>
                                    </div>
                                </div>

                                {{-- Shift & Tracking Tab Content --}}
                                <div x-show="currentTab === 'shift-tracking'" class="space-y-6">
                                    <h3 class="text-lg font-semibold text-gray-900">Live Tracking & Shift Management</h3>
                                    <div class="bg-gray-200 p-4 rounded-xl h-64 flex items-center justify-center">
                                        <p class="text-gray-500">Live Map View Placeholder: Current Location, Route, and
                                            Heatmap</p>

                                    </div>
                                    <div class="grid grid-cols-2 gap-4 text-sm">
                                        <div>
                                            <p class="text-gray-500">Current Shift Start</p>
                                            <p class="font-medium">10:00 AM</p>
                                        </div>
                                        <div>
                                            <p class="text-gray-500">Last GPS Update</p>
                                            <p class="font-medium text-green-600">14:42 PM (5 seconds ago)</p>
                                        </div>
                                        <div>
                                            <p class="text-gray-500">Total Shift Hours (W)</p>
                                            <p class="font-medium">45 Hours</p>
                                        </div>
                                        <div>
                                            <p class="text-gray-500">Auto-Assignment</p>
                                            <p class="font-medium text-red-600">Enabled</p>
                                        </div>
                                    </div>
                                </div>

                                {{-- Orders & History Tab Content --}}
                                <div x-show="currentTab === 'orders-history'" class="space-y-6">
                                    <h3 class="text-lg font-semibold text-gray-900">Delivery History & Ratings</h3>
                                    <div
                                        class="flex justify-between items-center p-4 bg-indigo-50 rounded-lg border border-indigo-200">
                                        <div>
                                            <p class="text-sm text-gray-500">Total Orders Completed</p>
                                            <p class="text-2xl font-bold text-indigo-700">12,450</p>
                                        </div>
                                        <div>
                                            <p class="text-sm text-gray-500">Average Customer Rating</p>
                                            <p class="text-2xl font-bold text-yellow-600">4.7 <span
                                                    class="text-base text-gray-500">/ 5.0</span></p>
                                        </div>
                                    </div>
                                    <h4 class="font-medium text-gray-800 mt-4">Recent Order Assignments</h4>
                                    <ul class="space-y-2 text-sm text-gray-700">
                                        <li class="p-2 border rounded-md">#ORD-9012 | Status: Completed | Time: 18 mins
                                        </li>
                                        <li class="p-2 border rounded-md">#ORD-9013 | Status: Completed | Time: 22 mins
                                        </li>
                                        <li class="p-2 border rounded-md">#ORD-9014 | Status: **Cancelled** | Reason: Rider
                                            Too Far</li>
                                    </ul>
                                </div>

                                {{-- Earnings & Payouts Tab Content --}}
                                <div x-show="currentTab === 'earnings-payouts'" class="space-y-6">
                                    <h3 class="text-lg font-semibold text-gray-900">Earnings Summary</h3>
                                    <div class="grid grid-cols-2 gap-4 p-4 bg-green-50 rounded-lg border border-green-200">
                                        <div>
                                            <p class="text-sm text-gray-500">Total YTD Earnings</p>
                                            <p class="text-xl font-bold text-green-700">$15,400</p>
                                        </div>
                                        <div>
                                            <p class="text-sm text-gray-500">Last Withdrawal</p>
                                            <p class="text-xl font-bold text-green-700">$500</p>
                                        </div>
                                    </div>

                                    <h4 class="font-medium text-gray-800 mt-6">Penalties & Deductions</h4>
                                    <ul class="list-disc list-inside text-sm text-gray-600 space-y-1">
                                        <li><span class="font-medium text-red-600">Late Delivery Penalty:</span> $10
                                            (10/01/2025)</li>
                                        <li><span class="font-medium text-red-600">Uniform Violation:</span> $30
                                            (09/15/2025)</li>
                                    </ul>

                                    <h4 class="font-medium text-gray-800 mt-6">Withdrawal Requests</h4>
                                    <p class="text-sm text-gray-500">Pending Request: **$540** (Requested on 10/20/2025)
                                    </p>
                                    <button
                                        class="mt-2 px-4 py-2 text-sm font-medium text-white bg-red-600 rounded-lg hover:bg-red-700">Approve
                                        Withdrawal</button>
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
        .shadow-lg {
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        }

        .shadow-2xl {
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
        }

        [x-cloak] {
            display: none !important;
        }
    </style>
@endpush
