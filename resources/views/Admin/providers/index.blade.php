@extends('layouts.app')

@section('content')
    {{-- CSS for hiding scrollbar in tabs --}}
    <style>
        .scrollbar-hide::-webkit-scrollbar { display: none; }
        .scrollbar-hide { -ms-overflow-style: none; scrollbar-width: none; }
    </style>

    <div class="min-h-screen bg-gray-50/50 p-6 space-y-8">
        {{-- Header --}}
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-gray-900 tracking-tight">Service Provider Management</h1>
                <p class="text-sm text-gray-500">Manage providers, skills, logistics, and KYC.</p>
            </div>
            {{-- Button triggers the modal function --}}
            <button onclick="openCreateProviderModal()"
                class="inline-flex items-center justify-center px-4 py-2 bg-indigo-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:outline-none focus:border-indigo-700 focus:ring focus:ring-indigo-200 active:bg-indigo-600 disabled:opacity-25 transition shadow-lg shadow-indigo-200">
                <i class="fas fa-plus mr-2"></i> Add Provider
            </button>
        </div>

        {{-- Stats --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            {{-- Card 1 --}}
            <div
                class="relative bg-white p-6 rounded-2xl shadow-sm border border-gray-100 overflow-hidden group hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                <div
                    class="absolute top-0 right-0 -mt-4 -mr-4 w-24 h-24 rounded-full bg-blue-50/50 group-hover:bg-blue-100 transition-colors duration-300">
                </div>
                <div class="relative flex justify-between items-start z-10">
                    <div>
                        <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Total Providers</p>
                        <h3 class="text-3xl font-extrabold text-gray-900 mt-2 group-hover:text-blue-600 transition-colors">
                            {{ $providers->count() }}</h3>
                    </div>
                    <div
                        class="p-3 bg-blue-50 text-blue-600 rounded-xl shadow-inner group-hover:scale-110 transition-transform duration-300">
                        <i class="fas fa-users text-xl"></i>
                    </div>
                </div>
                <div class="mt-4 flex items-center text-xs text-gray-400">
                    <span class="text-blue-600 font-bold bg-blue-50 px-1.5 py-0.5 rounded mr-2"><i
                            class="fas fa-arrow-up"></i> New</span>
                    <span>Registrations</span>
                </div>
                <div
                    class="absolute bottom-0 left-0 w-full h-1 bg-gradient-to-r from-blue-400 to-indigo-500 transform scale-x-0 group-hover:scale-x-100 transition-transform duration-500 origin-left">
                </div>
            </div>

            {{-- Card 2 --}}
            <div
                class="relative bg-white p-6 rounded-2xl shadow-sm border border-gray-100 overflow-hidden group hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                <div
                    class="absolute top-0 right-0 -mt-4 -mr-4 w-24 h-24 rounded-full bg-emerald-50/50 group-hover:bg-emerald-100 transition-colors duration-300">
                </div>
                <div class="relative flex justify-between items-start z-10">
                    <div>
                        <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Active</p>
                        <h3
                            class="text-3xl font-extrabold text-gray-900 mt-2 group-hover:text-emerald-600 transition-colors">
                            {{ $providers->where('status', 'active')->count() }}</h3>
                    </div>
                    <div
                        class="p-3 bg-emerald-50 text-emerald-600 rounded-xl shadow-inner group-hover:scale-110 transition-transform duration-300">
                        <i class="fas fa-user-check text-xl"></i>
                    </div>
                </div>
                <div class="mt-4 flex items-center text-xs text-gray-400">
                    <span class="text-emerald-600 font-bold bg-emerald-50 px-1.5 py-0.5 rounded mr-2"><i
                            class="fas fa-check-circle"></i> Good</span>
                    <span>Performance</span>
                </div>
                <div
                    class="absolute bottom-0 left-0 w-full h-1 bg-gradient-to-r from-emerald-400 to-teal-500 transform scale-x-0 group-hover:scale-x-100 transition-transform duration-500 origin-left">
                </div>
            </div>

            {{-- Card 3 --}}
            <div
                class="relative bg-white p-6 rounded-2xl shadow-sm border border-gray-100 overflow-hidden group hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                <div
                    class="absolute top-0 right-0 -mt-4 -mr-4 w-24 h-24 rounded-full bg-rose-50/50 group-hover:bg-rose-100 transition-colors duration-300">
                </div>
                <div class="relative flex justify-between items-start z-10">
                    <div>
                        <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Suspended</p>
                        <h3 class="text-3xl font-extrabold text-gray-900 mt-2 group-hover:text-rose-600 transition-colors">
                            {{ $providers->where('status', 'suspend')->count() }}</h3>
                    </div>
                    <div
                        class="p-3 bg-rose-50 text-rose-600 rounded-xl shadow-inner group-hover:scale-110 transition-transform duration-300">
                        <i class="fas fa-gavel text-xl"></i>
                    </div>
                </div>
                <div class="mt-4 flex items-center text-xs text-gray-400">
                    <span class="text-rose-600 font-bold bg-rose-50 px-1.5 py-0.5 rounded mr-2"><i
                            class="fas fa-exclamation-triangle"></i> Action</span>
                    <span>Required</span>
                </div>
                <div
                    class="absolute bottom-0 left-0 w-full h-1 bg-gradient-to-r from-rose-400 to-red-500 transform scale-x-0 group-hover:scale-x-100 transition-transform duration-500 origin-left">
                </div>
            </div>

            {{-- Card 4 --}}
            <div
                class="relative bg-white p-6 rounded-2xl shadow-sm border border-gray-100 overflow-hidden group hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                <div
                    class="absolute top-0 right-0 -mt-4 -mr-4 w-24 h-24 rounded-full bg-amber-50/50 group-hover:bg-amber-100 transition-colors duration-300">
                </div>
                <div class="relative flex justify-between items-start z-10">
                    <div>
                        <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Pending KYC</p>
                        <h3 class="text-3xl font-extrabold text-gray-900 mt-2 group-hover:text-amber-600 transition-colors">
                            NaN</h3>
                    </div>
                    <div
                        class="p-3 bg-amber-50 text-amber-600 rounded-xl shadow-inner group-hover:scale-110 transition-transform duration-300">
                        <i class="fas fa-hourglass-half text-xl"></i>
                    </div>
                </div>
                <div class="mt-4 flex items-center text-xs text-gray-400">
                    <span class="text-amber-600 font-bold bg-amber-50 px-1.5 py-0.5 rounded mr-2"><i
                            class="fas fa-clock"></i> Wait</span>
                    <span>For Review</span>
                </div>
                <div
                    class="absolute bottom-0 left-0 w-full h-1 bg-gradient-to-r from-amber-400 to-orange-500 transform scale-x-0 group-hover:scale-x-100 transition-transform duration-500 origin-left">
                </div>
            </div>
        </div>

        {{-- Main Content --}}
        <div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden">
            {{-- Filter Bar --}}
            <div class="p-4 border-b border-gray-100 bg-gray-50 flex flex-wrap gap-4 items-center justify-between">
                <div class="relative flex-1 max-w-md">
                    <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
                    <input type="text" id="searchInput" placeholder="Search by name, email, phone..."
                        class="w-full pl-10 pr-4 py-2 text-sm border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500">
                </div>
                <div class="flex gap-2">
                    <select id="subscriptionFilter" class="text-sm border-gray-300 rounded-lg focus:ring-indigo-500">
                        <option value="all">All Plans</option>
                        <option value="subscribed">Premium</option>
                        <option value="free">Free</option>
                    </select>
                    <select id="kycFilter" class="text-sm border-gray-300 rounded-lg focus:ring-indigo-500">
                        <option value="">All Status</option>
                        <option value="active">Active</option>
                        <option value="suspend">Suspended</option>
                    </select>
                </div>
            </div>

            {{-- Table --}}
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Provider</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Service/Pricing</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Status</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Earnings</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200" id="providersTableBody">
                        @forelse ($providers as $provider)
                            @php
                                $hasSub = $provider->id % 2 != 0;
                                $planName = $hasSub ? 'Gold Pro' : 'Free';
                                $subStatus = $hasSub ? 'subscribed' : 'free';
                                $statusColor = match ($provider->status) {
                                    'active' => 'bg-green-100 text-green-800',
                                    'suspend' => 'bg-red-100 text-red-800',
                                    'Ban' => 'bg-red-100 text-red-800',
                                    default => 'bg-gray-100 text-gray-800',
                                };
                                $image = $provider->image
                                    ? asset($provider->image)
                                    : 'https://ui-avatars.com/api/?name=' .
                                        urlencode($provider->name) .
                                        '&background=EBF4FF&color=7F9CF5';

                                // Full Data Object for JS
                                $jsData = [
                                    'id' => $provider->id,
                                    'name' => $provider->name ?? 'N/A',
                                    'image' => $image,
                                    'email' => $provider->email ?? 'N/A',
                                    'phone' => $provider->phone ?? 'N/A',
                                    'gender' => $provider->gender ?? 'N/A',
                                    'dob' => $provider->dob ?? 'N/A',
                                    'status' => $provider->status,
                                    'join_date' => $provider->created_at
                                        ? $provider->created_at->format('M d, Y')
                                        : 'N/A',
                                    'main_category' => 'General Service',
                                    'hourly_rate' => 'NaN',
                                    'total_earnings' => 'NaN',
                                    'description' => 'No description provided.',
                                    'transportation' => 'N/A',
                                    'wallet' => [
                                        'balance' => rand(100, 5000) . '.00',
                                        'pending' => rand(0, 500) . '.00',
                                        'withdrawn' => rand(1000, 10000) . '.00',
                                    ],
                                    // Dummy Order History Data
                                    'orders' => [
                                        [
                                            'id' => '#ORD-' . rand(1000, 9999),
                                            'service' => 'AC Repair',
                                            'customer' => 'Alice Smith',
                                            'date' => 'Oct 24, 2023',
                                            'status' => 'Completed',
                                            'amount' => '45.00'
                                        ],
                                        [
                                            'id' => '#ORD-' . rand(1000, 9999),
                                            'service' => 'House Cleaning',
                                            'customer' => 'Bob Jones',
                                            'date' => 'Oct 22, 2023',
                                            'status' => 'Pending',
                                            'amount' => '30.00'
                                        ],
                                        [
                                            'id' => '#ORD-' . rand(1000, 9999),
                                            'service' => 'Plumbing',
                                            'customer' => 'Charlie Day',
                                            'date' => 'Oct 15, 2023',
                                            'status' => 'Completed',
                                            'amount' => '80.00'
                                        ],
                                    ],
                                    'subscription' => [
                                        'has_plan' => $hasSub,
                                        'plan_name' => $planName,
                                        'progress' => 65,
                                        'expires_at' => now()->addDays(30)->format('M d, Y'),
                                    ],
                                    'skills' => [],
                                    'languages' => [],
                                    'payment_methods' => ['Visa **** 4242', 'Bank of America'],
                                    'address' => [
                                        'current' => $provider->current_address ?? 'N/A',
                                        'permanent' => $provider->address ?? 'N/A',
                                        'city' => $provider->city ?? 'N/A',
                                        'state' => $provider->state ?? 'N/A',
                                        'zip' => $provider->zipcode ?? 'N/A',
                                    ],
                                    'kyc_documents' => [
                                        ['name' => 'National ID Card', 'type' => 'Image', 'url' => '#'],
                                        ['name' => 'Driving License', 'type' => 'PDF', 'url' => '#'],
                                    ],
                                ];
                            @endphp
                            <tr class="hover:bg-indigo-50/30 transition duration-150 group provider-row"
                                data-subscription="{{ $subStatus }}" data-status="{{ $provider->status }}"
                                data-search="{{ strtolower(($provider->name ?? '') . ' ' . ($provider->email ?? '') . ' ' . ($provider->phone ?? '')) }}">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="relative">
                                            <img class="h-10 w-10 rounded-full object-cover border border-gray-200"
                                                src="{{ $image }}">
                                            @if ($hasSub)
                                                <div class="absolute -top-1 -right-1 bg-yellow-400 text-white p-0.5 rounded-full border border-white"
                                                    title="Premium">
                                                    <i class="fas fa-star text-[8px]"></i>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900 search-name">{{ $provider->name }}
                                            </div>
                                            <div class="text-xs text-gray-500">{{ $provider->email }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span
                                        class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $hasSub ? 'bg-indigo-100 text-indigo-800' : 'bg-gray-100 text-gray-800' }}">{{ $planName }}</span>
                                    <div class="text-xs text-gray-500 mt-1">$NaN/hr</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    <span
                                        class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $statusColor }}">{{ ucfirst($provider->status) }}</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium text-gray-900">
                                    $NaN
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <div class="flex justify-end items-center gap-2">
                                        <button onclick="openProviderDetails({{ json_encode($jsData) }})"
                                            class="text-indigo-600 hover:text-indigo-900 bg-indigo-50 p-2 rounded hover:bg-indigo-100 transition"
                                            title="View Details">
                                            View Details
                                        </button>
                                        {{-- Actions Dropdown --}}
                                        <div class="relative" x-data="{ open: false }">
                                            <button @click="open = !open" @click.away="open = false"
                                                class="text-gray-400 hover:text-gray-600 p-2 rounded-full hover:bg-gray-100">
                                                <i class="fas fa-ellipsis-v"></i>
                                            </button>
                                            <div x-show="open"
                                                class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-50 border border-gray-100"
                                                style="display: none;">
                                                <a href="#"
                                                    class="block px-4 py-2 text-sm text-green-600 hover:bg-green-50"><i
                                                        class="fas fa-check-circle mr-2"></i> Approve KYC</a>
                                                <a href="#"
                                                    class="block px-4 py-2 text-sm text-red-600 hover:bg-red-50"><i
                                                        class="fas fa-ban mr-2"></i> Suspend</a>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr id="no-providers-row">
                                <td colspan="5" class="px-6 py-10 text-center text-gray-500">No providers found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="p-4 border-t border-gray-100">
                @if ($providers instanceof \Illuminate\Pagination\LengthAwarePaginator)
                    {{ $providers->links() }}
                @endif
            </div>
        </div>
    </div>

    {{-- Unified Slide-Over (Details) --}}
    <div id="details-slide-over" class="fixed inset-0 overflow-hidden z-50 hidden">
        <div class="absolute inset-0 bg-gray-900 bg-opacity-75 transition-opacity backdrop-blur-sm"
            onclick="closeProviderDetails()"></div>
        <div class="fixed inset-y-0 right-0 max-w-2xl w-full flex pointer-events-none">
            <div class="w-full h-full bg-white shadow-2xl pointer-events-auto flex flex-col transform transition-transform duration-300 translate-x-full"
                id="slide-over-panel">

                {{-- Slide Header --}}
                <div class="bg-indigo-900 px-6 py-6 text-white shrink-0">
                    <div class="flex justify-between items-start">
                        <div class="flex items-center space-x-4">
                            <img id="so-image" src=""
                                class="h-16 w-16 rounded-full border-2 border-white/50 object-cover">
                            <div>
                                <h2 class="text-xl font-bold" id="so-name"></h2>
                                <p class="text-indigo-200 text-sm flex items-center gap-2">
                                    <span id="so-email"></span>
                                    <span class="w-1 h-1 bg-white rounded-full"></span>
                                    <span id="so-status"
                                        class="uppercase text-xs font-bold bg-white/20 px-2 py-0.5 rounded"></span>
                                </p>
                            </div>
                        </div>
                        <button onclick="closeProviderDetails()" class="text-white hover:text-indigo-200 transition"><i
                                class="fas fa-times text-xl"></i></button>
                    </div>
                    {{-- Tabs --}}
                    <div class="flex space-x-6 mt-8 text-sm font-medium overflow-x-auto scrollbar-hide">
                        <button onclick="switchTab('overview')"
                            class="tab-btn border-b-2 border-white pb-3 text-white transition whitespace-nowrap"
                            id="tab-overview">Overview</button>
                        <button onclick="switchTab('orders')"
                            class="tab-btn border-b-2 border-transparent pb-3 text-indigo-300 hover:text-white transition whitespace-nowrap"
                            id="tab-orders">Orders</button>
                        <button onclick="switchTab('wallet')"
                            class="tab-btn border-b-2 border-transparent pb-3 text-indigo-300 hover:text-white transition whitespace-nowrap"
                            id="tab-wallet">Wallet</button>
                        <button onclick="switchTab('portfolio')"
                            class="tab-btn border-b-2 border-transparent pb-3 text-indigo-300 hover:text-white transition whitespace-nowrap"
                            id="tab-portfolio">Portfolio</button>
                        <button onclick="switchTab('payment-methods')"
                            class="tab-btn border-b-2 border-transparent pb-3 text-indigo-300 hover:text-white transition whitespace-nowrap"
                            id="tab-payment-methods">Payment Methods</button>
                        <button onclick="switchTab('documents')"
                            class="tab-btn border-b-2 border-transparent pb-3 text-indigo-300 hover:text-white transition whitespace-nowrap"
                            id="tab-documents">Documents</button>
                        <button onclick="switchTab('subscription')"
                            class="tab-btn border-b-2 border-transparent pb-3 text-indigo-300 hover:text-white transition whitespace-nowrap"
                            id="tab-subscription">Subscription</button>
                    </div>
                </div>

                {{-- Slide Content --}}
                <div class="flex-1 overflow-y-auto p-6 bg-gray-50 scroll-smooth">
                    {{-- TAB: OVERVIEW --}}
                    <div id="content-overview" class="tab-content space-y-6">
                        <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-100">
                            <h3 class="font-bold text-gray-900 mb-4 flex items-center"><i
                                    class="fas fa-user-circle mr-2 text-indigo-500"></i> Basic Information</h3>
                            <div class="grid grid-cols-2 gap-y-4 gap-x-6 text-sm">
                                <div>
                                    <p class="text-gray-500 text-xs uppercase">Phone</p>
                                    <p class="font-medium text-gray-900" id="so-phone"></p>
                                </div>
                                <div>
                                    <p class="text-gray-500 text-xs uppercase">Gender / DOB</p>
                                    <p class="font-medium text-gray-900" id="so-gender-dob"></p>
                                </div>
                                <div>
                                    <p class="text-gray-500 text-xs uppercase">Joined Date</p>
                                    <p class="font-medium text-gray-900" id="so-joined"></p>
                                </div>
                                <div>
                                    <p class="text-gray-500 text-xs uppercase">Hourly Rate</p>
                                    <p class="font-medium text-green-600" id="so-rate"></p>
                                </div>
                            </div>
                            <div class="mt-4 pt-4 border-t border-gray-100">
                                <p class="text-gray-500 text-xs uppercase mb-1">About</p>
                                <p class="text-gray-700 text-sm leading-relaxed" id="so-desc"></p>
                            </div>
                        </div>
                        {{-- Logistics & Address --}}
                        <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-100">
                            <h3 class="font-bold text-gray-900 mb-4 flex items-center"><i
                                    class="fas fa-map-marker-alt mr-2 text-indigo-500"></i> Location & Logistics</h3>
                            <div class="space-y-4 text-sm">
                                <div>
                                    <p class="text-xs text-gray-500 uppercase">Transportation</p>
                                    <p class="font-medium text-gray-900 flex items-center mt-1"><i
                                            class="fas fa-motorcycle mr-2 text-gray-400"></i> <span
                                            id="so-transport"></span></p>
                                </div>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <p class="text-xs text-gray-500 uppercase">Current Address</p>
                                        <p class="font-medium text-gray-900 mt-1" id="so-addr-current"></p>
                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-500 uppercase">Permanent Address</p>
                                        <p class="font-medium text-gray-900 mt-1" id="so-addr-perm"></p>
                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-500 uppercase">City/State</p>
                                        <p class="font-medium text-gray-900 mt-1" id="so-addr-city"></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-100">
                            <h3 class="font-bold text-gray-900 mb-4 flex items-center"><i
                                    class="fas fa-tools mr-2 text-indigo-500"></i> Skills & Capabilities</h3>
                            <div class="mb-4">
                                <p class="text-xs text-gray-500 mb-2 uppercase">Skills</p>
                                <div id="so-skills" class="flex flex-wrap gap-2"></div>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500 mb-2 uppercase">Languages</p>
                                <ul id="so-languages"
                                    class="list-disc list-inside text-sm text-gray-700 grid grid-cols-2"></ul>
                            </div>
                        </div>
                    </div>

                    {{-- TAB: ORDERS (NEW) --}}
                    <div id="content-orders" class="tab-content hidden space-y-4">
                        <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-100">
                            <h3 class="font-bold text-gray-900 mb-4">Work History</h3>
                            <div id="so-orders-list" class="space-y-3">
                                {{-- Populated by JS --}}
                            </div>
                        </div>
                    </div>

                    {{-- TAB: WALLET (NEW) --}}
                    <div id="content-wallet" class="tab-content hidden space-y-6">
                        {{-- Balance Card --}}
                        <div class="bg-gradient-to-r from-emerald-500 to-teal-600 rounded-2xl p-6 text-white shadow-lg">
                            <div class="flex justify-between items-start">
                                <div>
                                    <p class="text-emerald-100 text-xs font-bold uppercase tracking-wider">Total Balance
                                    </p>
                                    <h2 class="text-3xl font-bold mt-1" id="so-wallet-balance">$0.00</h2>
                                </div>
                                <div class="p-2 bg-white/20 rounded-lg backdrop-blur-sm">
                                    <i class="fas fa-wallet text-2xl"></i>
                                </div>
                            </div>
                            <div class="mt-6 flex gap-4">
                                <div class="bg-black/10 rounded-lg p-3 flex-1">
                                    <p class="text-xs text-emerald-100 mb-1">Pending</p>
                                    <p class="font-semibold" id="so-wallet-pending">$0.00</p>
                                </div>
                                <div class="bg-black/10 rounded-lg p-3 flex-1">
                                    <p class="text-xs text-emerald-100 mb-1">Withdrawn</p>
                                    <p class="font-semibold" id="so-wallet-withdrawn">$0.00</p>
                                </div>
                            </div>
                        </div>

                        {{-- Transactions List (Dummy) --}}
                        <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-100">
                            <h3 class="font-bold text-gray-900 mb-4">Recent Transactions</h3>
                            <div class="space-y-4">
                                {{-- Fake Transactions --}}
                                <div class="flex justify-between items-center border-b border-gray-50 pb-3 last:border-0">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="h-8 w-8 rounded-full bg-green-100 text-green-600 flex items-center justify-center text-xs">
                                            <i class="fas fa-arrow-down"></i>
                                        </div>
                                        <div>
                                            <p class="text-sm font-medium text-gray-900">Job Completion</p>
                                            <p class="text-xs text-gray-500">Service Fee Earned</p>
                                        </div>
                                    </div>
                                    <span class="text-sm font-bold text-green-600">+$45.00</span>
                                </div>
                                <div class="flex justify-between items-center border-b border-gray-50 pb-3 last:border-0">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="h-8 w-8 rounded-full bg-red-100 text-red-600 flex items-center justify-center text-xs">
                                            <i class="fas fa-arrow-up"></i>
                                        </div>
                                        <div>
                                            <p class="text-sm font-medium text-gray-900">Withdrawal</p>
                                            <p class="text-xs text-gray-500">Bank Transfer</p>
                                        </div>
                                    </div>
                                    <span class="text-sm font-bold text-gray-900">-$150.00</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- TAB: PORTFOLIO (NEW - BLANK) --}}
                    <div id="content-portfolio" class="tab-content hidden h-full">
                        <div
                            class="flex flex-col items-center justify-center h-64 border-2 border-dashed border-gray-200 rounded-xl bg-gray-50">
                            <div class="h-12 w-12 bg-gray-200 rounded-full flex items-center justify-center text-gray-400 mb-3">
                                <i class="fas fa-images"></i>
                            </div>
                            <p class="text-gray-500 text-sm font-medium">Portfolio Section</p>
                            <p class="text-gray-400 text-xs mt-1">No portfolio items available.</p>
                        </div>
                    </div>

                    {{-- TAB: PAYMENT METHODS (NEW) --}}
                    <div id="content-payment-methods" class="tab-content hidden space-y-4">
                        <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-100">
                            <h3 class="font-bold text-gray-900 mb-4">Linked Payment Methods</h3>
                            <div id="so-payment-methods-list" class="space-y-3">
                                {{-- Populated by JS --}}
                            </div>
                        </div>
                    </div>

                    {{-- TAB: KYC --}}
                    <div id="content-documents" class="tab-content hidden space-y-4">
                        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                            <div class="flex justify-between items-center mb-6">
                                <h3 class="font-bold text-gray-900">Submitted Documents</h3>
                                <span class="bg-yellow-100 text-yellow-800 text-xs font-bold px-2 py-1 rounded">Pending
                                    Review</span>
                            </div>
                            <div id="so-kyc-list" class="space-y-3"></div>
                        </div>
                    </div>

                    {{-- TAB: SUBSCRIPTION --}}
                    <div id="content-subscription" class="tab-content hidden space-y-4">
                        <div id="so-subscription-container"></div>
                    </div>
                </div>

                {{-- Footer Actions --}}
                <div class="p-4 bg-white border-t border-gray-200 flex justify-end gap-3 shrink-0">
                    <button
                        class="px-5 py-2.5 rounded-lg border border-gray-300 text-gray-700 font-medium hover:bg-gray-50 transition">Suspend
                        Provider</button>
                    <button
                        class="px-5 py-2.5 rounded-lg bg-indigo-600 text-white font-medium hover:bg-indigo-700 shadow-md transition">Approve
                        Provider</button>
                </div>
            </div>
        </div>
    </div>


    {{-- ADD PROVIDER MODAL --}}
    <div id="create-provider-modal" class="fixed inset-0 z-50 hidden" aria-labelledby="modal-title" role="dialog"
        aria-modal="true">
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            {{-- Backdrop --}}
            <div class="fixed inset-0 bg-gray-900 bg-opacity-75 transition-opacity backdrop-blur-sm"
                onclick="closeCreateProviderModal()"></div>

            <div
                class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg w-full">
                <div class="bg-white px-6 py-6 border-b border-gray-100 flex justify-between items-center">
                    <h3 class="text-xl font-bold text-gray-900"><i class="fas fa-user-plus mr-2 text-indigo-500"></i>
                        Onboard Provider</h3>
                    <button onclick="closeCreateProviderModal()"
                        class="text-gray-400 hover:text-gray-600 focus:outline-none"><i class="fas fa-times"></i></button>
                </div>

                {{-- NOTICE: onsubmit="submitProvider(event)" is added here --}}
                <form id="providerForm" action="{{ route('store.provider') }}" method="POST"
                    enctype="multipart/form-data" onsubmit="submitProvider(event)">
                    @csrf
                    <div class="p-6 space-y-4 max-h-[60vh] overflow-y-auto">

                        {{-- Error Display Box --}}
                        <div id="error-message-box"
                            class="hidden bg-red-50 text-red-700 p-3 rounded-lg text-sm border border-red-200"></div>
                        <div id="success-message-box"
                            class="hidden bg-green-50 text-green-700 p-3 rounded-lg text-sm border border-green-200"></div>

                        <div class="grid grid-cols-1 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Full Name</label>
                                <input type="text" name="name" required placeholder="John Doe"
                                    class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm p-2.5 border">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
                                <input type="email" name="email" required placeholder="john@example.com"
                                    class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm p-2.5 border">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Phone Number</label>
                                <input type="text" name="phone" required placeholder="+1 234 567 890"
                                    class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm p-2.5 border">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                                <input type="password" name="password" required placeholder="********"
                                    class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm p-2.5 border">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Service Category</label>
                                <select name="category_id"
                                    class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm p-2.5 border bg-white">
                                    <option value="">Select Category</option>
                                    <option value="1">General Service</option>
                                    {{-- Add logic to populate categories from backend if needed --}}
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="p-6 border-t border-gray-100 flex justify-end bg-gray-50">
                        <button type="button" onclick="closeCreateProviderModal()"
                            class="mr-3 px-4 py-2 text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition shadow-sm font-medium">Cancel</button>
                        <button type="submit" id="submitBtn"
                            class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 shadow-md flex items-center transition font-medium">
                            <i id="loading-icon" class="fas fa-spinner fa-spin mr-2 hidden"></i> Save Provider
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // --- Modal Logic ---
        function openCreateProviderModal() {
            document.getElementById('create-provider-modal').classList.remove('hidden');
            // Clear previous errors/success messages when opening
            document.getElementById('error-message-box').classList.add('hidden');
            document.getElementById('success-message-box').classList.add('hidden');
            document.getElementById('providerForm').reset();
        }

        function closeCreateProviderModal() {
            document.getElementById('create-provider-modal').classList.add('hidden');
        }

        // --- AJAX Submission Logic ---
        async function submitProvider(e) {
            e.preventDefault();

            const form = document.getElementById('providerForm');
            const submitBtn = document.getElementById('submitBtn');
            const loadingIcon = document.getElementById('loading-icon');
            const errorBox = document.getElementById('error-message-box');
            const successBox = document.getElementById('success-message-box');

            // UI States
            submitBtn.disabled = true;
            loadingIcon.classList.remove('hidden');
            errorBox.classList.add('hidden');
            successBox.classList.add('hidden');

            const formData = new FormData(form);

            try {
                const response = await fetch(form.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                    }
                });

                const data = await response.json();

                if (response.ok) {
                    successBox.innerText = "Provider added successfully! Reloading...";
                    successBox.classList.remove('hidden');

                    setTimeout(() => {
                        location.reload();
                    }, 1000);
                } else {
                    submitBtn.disabled = false;
                    loadingIcon.classList.add('hidden');

                    let errorMessage = data.message || "Something went wrong.";
                    if (data.errors) {
                        errorMessage = Object.values(data.errors).flat().join('<br>');
                    }

                    errorBox.innerHTML = errorMessage;
                    errorBox.classList.remove('hidden');
                }
            } catch (error) {
                console.error('Error:', error);
                submitBtn.disabled = false;
                loadingIcon.classList.add('hidden');
                errorBox.innerText = "Network error. Please check your connection.";
                errorBox.classList.remove('hidden');
            }
        }

        // --- Slide Over Logic ---
        function openProviderDetails(data) {
            document.getElementById('details-slide-over').classList.remove('hidden');
            document.getElementById('slide-over-panel').classList.remove('translate-x-full');

            // Basic Info
            document.getElementById('so-image').src = data.image;
            document.getElementById('so-name').innerText = data.name;
            document.getElementById('so-email').innerText = data.email;
            document.getElementById('so-status').innerText = data.status;
            document.getElementById('so-phone').innerText = data.phone;
            document.getElementById('so-gender-dob').innerText = `${data.gender} | ${data.dob}`;
            document.getElementById('so-joined').innerText = data.join_date;
            document.getElementById('so-rate').innerText = `$${data.hourly_rate}/hr`;
            document.getElementById('so-desc').innerText = data.description;
            document.getElementById('so-transport').innerText = data.transportation;
            document.getElementById('so-addr-current').innerText = data.address.current;
            document.getElementById('so-addr-perm').innerText = data.address.permanent;
            document.getElementById('so-addr-city').innerText = `${data.address.city}, ${data.address.state}`;

            // Wallet Data (New)
            document.getElementById('so-wallet-balance').innerText = `$${data.wallet.balance}`;
            document.getElementById('so-wallet-pending').innerText = `$${data.wallet.pending}`;
            document.getElementById('so-wallet-withdrawn').innerText = `$${data.wallet.withdrawn}`;

            // Payment Methods (New Tab Population)
            const payMethodList = document.getElementById('so-payment-methods-list');
            if (data.payment_methods && data.payment_methods.length > 0) {
                payMethodList.innerHTML = data.payment_methods.map(pm => `
                <div class="flex items-center p-3 border border-gray-200 rounded-lg hover:bg-gray-50 transition">
                    <div class="h-10 w-10 bg-indigo-50 text-indigo-600 rounded-full flex items-center justify-center mr-3">
                         <i class="fas fa-credit-card"></i>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-900">${pm}</p>
                        <p class="text-xs text-gray-500">Verified</p>
                    </div>
                </div>
            `).join('');
            } else {
                payMethodList.innerHTML =
                    '<div class="text-center py-4 text-gray-500 italic">No payment methods linked.</div>';
            }

            // Orders (New Tab Population)
            const ordersList = document.getElementById('so-orders-list');
            if (data.orders && data.orders.length > 0) {
                ordersList.innerHTML = data.orders.map(order => `
                <div class="flex items-center justify-between p-3 border border-gray-200 rounded-lg hover:bg-gray-50 transition">
                    <div class="flex items-center gap-3">
                        <div class="h-10 w-10 bg-blue-100 text-blue-600 rounded-lg flex items-center justify-center text-sm font-bold">
                             <i class="fas fa-clipboard-list"></i>
                        </div>
                        <div>
                            <p class="text-sm font-bold text-gray-900">${order.service}</p>
                            <p class="text-xs text-gray-500">${order.id} • ${order.customer}</p>
                        </div>
                    </div>
                    <div class="text-right">
                        <p class="text-sm font-bold text-gray-900">$${order.amount}</p>
                        <span class="text-[10px] uppercase font-bold px-2 py-0.5 rounded ${order.status === 'Completed' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700'}">${order.status}</span>
                    </div>
                </div>
            `).join('');
            } else {
                ordersList.innerHTML =
                    '<div class="text-center py-4 text-gray-500 italic">No order history available.</div>';
            }

            // Skills
            const skillsContainer = document.getElementById('so-skills');
            if (data.skills && data.skills.length > 0) {
                skillsContainer.innerHTML = data.skills.map(skill =>
                    `<span class="px-2 py-1 bg-indigo-50 text-indigo-700 text-xs rounded border border-indigo-100">${skill}</span>`
                    ).join('');
            } else {
                skillsContainer.innerHTML = '<span class="text-gray-400 text-xs italic">No skills listed</span>';
            }

            // Languages
            const langContainer = document.getElementById('so-languages');
            if (data.languages && data.languages.length > 0) {
                langContainer.innerHTML = data.languages.map(l => `<li>${l}</li>`).join('');
            } else {
                langContainer.innerHTML = '<li class="text-gray-400 italic">N/A</li>';
            }

            // KYC Tab
            const kycContainer = document.getElementById('so-kyc-list');
            if (data.kyc_documents && data.kyc_documents.length > 0) {
                kycContainer.innerHTML = data.kyc_documents.map(doc => `
                <div class="flex items-center justify-between p-3 bg-white border border-gray-200 rounded-lg hover:shadow-sm transition">
                    <div class="flex items-center space-x-3">
                        <div class="h-10 w-10 bg-indigo-50 text-indigo-600 rounded-lg flex items-center justify-center text-lg"><i class="fas fa-file-alt"></i></div>
                        <div>
                            <p class="text-sm font-semibold text-gray-800">${doc.name}</p>
                            <span class="text-[10px] text-gray-500 uppercase">${doc.type}</span>
                        </div>
                    </div>
                    <button class="px-3 py-1.5 bg-gray-50 hover:bg-indigo-50 text-indigo-600 text-xs font-bold rounded transition">View</button>
                </div>
            `).join('');
            } else {
                kycContainer.innerHTML =
                    '<div class="text-center py-4 text-gray-500 italic">No documents submitted.</div>';
            }

            // Subscription Tab
            const subContainer = document.getElementById('so-subscription-container');
            if (data.subscription.has_plan) {
                subContainer.innerHTML = `
            <div class="relative overflow-hidden bg-gray-900 p-6 rounded-2xl shadow-xl text-white">
                <div class="absolute top-0 right-0 -mt-4 -mr-4 w-32 h-32 bg-indigo-500 rounded-full opacity-20 blur-2xl"></div>
                <div class="relative z-10">
                    <p class="text-indigo-300 text-xs font-bold uppercase tracking-wider mb-1">Current Plan</p>
                    <h2 class="text-2xl font-extrabold text-white tracking-tight">${data.subscription.plan_name}</h2>
                    <div class="mt-6 space-y-3">
                        <div class="flex justify-between text-sm"><span class="text-gray-400">Validity</span><span class="text-white font-medium">${data.subscription.progress}%</span></div>
                        <div class="w-full bg-gray-700 rounded-full h-2"><div class="bg-gradient-to-r from-indigo-500 to-purple-500 h-2 rounded-full" style="width: ${data.subscription.progress}%"></div></div>
                        <div class="flex justify-between text-xs mt-1"><span class="text-gray-500">Expires</span><span class="text-indigo-300 font-medium">${data.subscription.expires_at}</span></div>
                    </div>
                </div>
            </div>`;
            } else {
                subContainer.innerHTML =
                    '<div class="p-6 text-center border-dashed border-2 border-gray-300 rounded-xl text-gray-500">No active subscription</div>';
            }

            switchTab('overview');
        }

        function closeProviderDetails() {
            document.getElementById('slide-over-panel').classList.add('translate-x-full');
            setTimeout(() => {
                document.getElementById('details-slide-over').classList.add('hidden');
            }, 300);
        }

        function switchTab(tabName) {
            document.querySelectorAll('.tab-btn').forEach(btn => {
                btn.classList.remove('border-white', 'text-white');
                btn.classList.add('border-transparent', 'text-indigo-300');
            });
            document.querySelectorAll('.tab-content').forEach(content => content.classList.add('hidden'));

            document.getElementById('tab-' + tabName).classList.add('border-white', 'text-white');
            document.getElementById('tab-' + tabName).classList.remove('border-transparent', 'text-indigo-300');
            document.getElementById('content-' + tabName).classList.remove('hidden');
        }

        // --- Filter Logic ---
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('searchInput');
            const subFilter = document.getElementById('subscriptionFilter');
            const kycFilter = document.getElementById('kycFilter');
            const tableRows = document.querySelectorAll('.provider-row');

            function filterProviders() {
                const searchValue = searchInput.value.toLowerCase();
                const subValue = subFilter.value;
                const kycValue = kycFilter.value;

                tableRows.forEach(row => {
                    const searchData = row.getAttribute('data-search') || '';
                    const rowSub = row.getAttribute('data-subscription');
                    const rowStatus = row.getAttribute('data-status');

                    const matchesSearch = searchData.includes(searchValue);
                    const matchesSub = (subValue === 'all') || (subValue === rowSub);
                    const matchesKyc = (kycValue === '') || (rowStatus === kycValue);

                    if (matchesSearch && matchesSub && matchesKyc) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                });
            }

            searchInput.addEventListener('keyup', filterProviders);
            subFilter.addEventListener('change', filterProviders);
            kycFilter.addEventListener('change', filterProviders);
        });
    </script>
@endpush