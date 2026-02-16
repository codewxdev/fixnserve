@extends('layouts.app')

@section('content')
    {{-- CSS for hiding scrollbar in tabs --}}
    <style>
        .scrollbar-hide::-webkit-scrollbar { display: none; }
        .scrollbar-hide { -ms-overflow-style: none; scrollbar-width: none; }
    </style>

    <div class="min-h-screen theme-bg-body theme-text-main p-6 space-y-8">
        {{-- Header --}}
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold theme-text-main tracking-tight">Service Provider Management</h1>
                <p class="text-sm theme-text-muted">Manage providers, skills, logistics, and KYC.</p>
            </div>
            {{-- Button triggers the modal function --}}
            <button onclick="openCreateProviderModal()"
                class="inline-flex items-center justify-center px-4 py-2 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:opacity-90 focus:outline-none transition shadow-lg"
                style="background-color: rgb(var(--brand-primary)); box-shadow: 0 4px 10px rgba(var(--brand-primary), 0.3);">
                <i class="fas fa-plus mr-2"></i> Add Provider
            </button>
        </div>

        {{-- Stats --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            {{-- Card 1 --}}
            <div class="relative theme-bg-card p-6 rounded-2xl shadow-sm border theme-border overflow-hidden group hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                <div class="absolute top-0 right-0 -mt-4 -mr-4 w-24 h-24 rounded-full bg-blue-500/10 group-hover:bg-blue-500/20 transition-colors duration-300"></div>
                <div class="relative flex justify-between items-start z-10">
                    <div>
                        <p class="text-xs font-bold theme-text-muted uppercase tracking-wider">Total Providers</p>
                        <h3 class="text-3xl font-extrabold theme-text-main mt-2 group-hover:text-blue-500 transition-colors">
                            {{ $providers->count() }}</h3>
                    </div>
                    <div class="p-3 bg-blue-500/10 text-blue-500 rounded-xl shadow-inner group-hover:scale-110 transition-transform duration-300">
                        <i class="fas fa-users text-xl"></i>
                    </div>
                </div>
                <div class="mt-4 flex items-center text-xs theme-text-muted">
                    <span class="text-blue-500 font-bold bg-blue-500/10 px-1.5 py-0.5 rounded mr-2"><i class="fas fa-arrow-up"></i> New</span>
                    <span>Registrations</span>
                </div>
                <div class="absolute bottom-0 left-0 w-full h-1 bg-gradient-to-r from-blue-400 to-indigo-500 transform scale-x-0 group-hover:scale-x-100 transition-transform duration-500 origin-left"></div>
            </div>

            {{-- Card 2 --}}
            <div class="relative theme-bg-card p-6 rounded-2xl shadow-sm border theme-border overflow-hidden group hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                <div class="absolute top-0 right-0 -mt-4 -mr-4 w-24 h-24 rounded-full bg-emerald-500/10 group-hover:bg-emerald-500/20 transition-colors duration-300"></div>
                <div class="relative flex justify-between items-start z-10">
                    <div>
                        <p class="text-xs font-bold theme-text-muted uppercase tracking-wider">Active</p>
                        <h3 class="text-3xl font-extrabold theme-text-main mt-2 group-hover:text-emerald-500 transition-colors">
                            {{ $providers->where('status', 'active')->count() }}</h3>
                    </div>
                    <div class="p-3 bg-emerald-500/10 text-emerald-500 rounded-xl shadow-inner group-hover:scale-110 transition-transform duration-300">
                        <i class="fas fa-user-check text-xl"></i>
                    </div>
                </div>
                <div class="mt-4 flex items-center text-xs theme-text-muted">
                    <span class="text-emerald-500 font-bold bg-emerald-500/10 px-1.5 py-0.5 rounded mr-2"><i class="fas fa-check-circle"></i> Good</span>
                    <span>Performance</span>
                </div>
                <div class="absolute bottom-0 left-0 w-full h-1 bg-gradient-to-r from-emerald-400 to-teal-500 transform scale-x-0 group-hover:scale-x-100 transition-transform duration-500 origin-left"></div>
            </div>

            {{-- Card 3 --}}
            <div class="relative theme-bg-card p-6 rounded-2xl shadow-sm border theme-border overflow-hidden group hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                <div class="absolute top-0 right-0 -mt-4 -mr-4 w-24 h-24 rounded-full bg-rose-500/10 group-hover:bg-rose-500/20 transition-colors duration-300"></div>
                <div class="relative flex justify-between items-start z-10">
                    <div>
                        <p class="text-xs font-bold theme-text-muted uppercase tracking-wider">Suspended</p>
                        <h3 class="text-3xl font-extrabold theme-text-main mt-2 group-hover:text-rose-500 transition-colors">
                            {{ $providers->where('status', 'suspend')->count() }}</h3>
                    </div>
                    <div class="p-3 bg-rose-500/10 text-rose-500 rounded-xl shadow-inner group-hover:scale-110 transition-transform duration-300">
                        <i class="fas fa-gavel text-xl"></i>
                    </div>
                </div>
                <div class="mt-4 flex items-center text-xs theme-text-muted">
                    <span class="text-rose-500 font-bold bg-rose-500/10 px-1.5 py-0.5 rounded mr-2"><i class="fas fa-exclamation-triangle"></i> Action</span>
                    <span>Required</span>
                </div>
                <div class="absolute bottom-0 left-0 w-full h-1 bg-gradient-to-r from-rose-400 to-red-500 transform scale-x-0 group-hover:scale-x-100 transition-transform duration-500 origin-left"></div>
            </div>

            {{-- Card 4 --}}
            <div class="relative theme-bg-card p-6 rounded-2xl shadow-sm border theme-border overflow-hidden group hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                <div class="absolute top-0 right-0 -mt-4 -mr-4 w-24 h-24 rounded-full bg-amber-500/10 group-hover:bg-amber-500/20 transition-colors duration-300"></div>
                <div class="relative flex justify-between items-start z-10">
                    <div>
                        <p class="text-xs font-bold theme-text-muted uppercase tracking-wider">Pending KYC</p>
                        <h3 class="text-3xl font-extrabold theme-text-main mt-2 group-hover:text-amber-500 transition-colors">
                            NaN</h3>
                    </div>
                    <div class="p-3 bg-amber-500/10 text-amber-500 rounded-xl shadow-inner group-hover:scale-110 transition-transform duration-300">
                        <i class="fas fa-hourglass-half text-xl"></i>
                    </div>
                </div>
                <div class="mt-4 flex items-center text-xs theme-text-muted">
                    <span class="text-amber-500 font-bold bg-amber-500/10 px-1.5 py-0.5 rounded mr-2"><i class="fas fa-clock"></i> Wait</span>
                    <span>For Review</span>
                </div>
                <div class="absolute bottom-0 left-0 w-full h-1 bg-gradient-to-r from-amber-400 to-orange-500 transform scale-x-0 group-hover:scale-x-100 transition-transform duration-500 origin-left"></div>
            </div>
        </div>

        {{-- Main Content --}}
        <div class="theme-bg-card border theme-border rounded-xl shadow-sm overflow-hidden">
            {{-- Filter Bar --}}
            <div class="p-4 border-b theme-border flex flex-wrap gap-4 items-center justify-between" style="background-color: rgba(var(--bg-body), 0.5);">
                <div class="relative flex-1 max-w-md">
                    <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 theme-text-muted"></i>
                    <input type="text" id="searchInput" placeholder="Search by name, email, phone..."
                        class="w-full pl-10 pr-4 py-2 text-sm theme-bg-body border theme-border rounded-lg focus:ring-2 focus:ring-blue-500 theme-text-main placeholder-gray-500">
                </div>
                <div class="flex gap-2">
                    <select id="ratingFilter" class="text-sm theme-bg-body theme-border border rounded-lg focus:ring-2 focus:ring-blue-500 theme-text-main">
                        <option value="all">All Ratings</option>
                        <option value="4.5">4.5+ Stars</option>
                        <option value="4.0">4.0+ Stars</option>
                        <option value="3.0">3.0+ Stars</option>
                    </select>

                    <select id="subscriptionFilter" class="text-sm theme-bg-body theme-border border rounded-lg focus:ring-2 focus:ring-blue-500 theme-text-main">
                        <option value="all">All Plans</option>
                        <option value="subscribed">Premium</option>
                        <option value="free">Free</option>
                    </select>
                    <select id="kycFilter" class="text-sm theme-bg-body theme-border border rounded-lg focus:ring-2 focus:ring-blue-500 theme-text-main">
                        <option value="">All Status</option>
                        <option value="active">Active</option>
                        <option value="suspend">Suspended</option>
                    </select>
                </div>
            </div>

            {{-- Table --}}
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y theme-border" style="border-color: rgb(var(--border-color));">
                    <thead class="theme-bg-body">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium theme-text-muted uppercase tracking-wider">
                                Provider</th>
                            <th class="px-6 py-3 text-left text-xs font-medium theme-text-muted uppercase tracking-wider">
                                Service/Pricing</th>
                            
                            <th class="px-6 py-3 text-left text-xs font-medium theme-text-muted uppercase tracking-wider">
                                Performance</th>

                            <th class="px-6 py-3 text-center text-xs font-medium theme-text-muted uppercase tracking-wider">
                                Status</th>
                            <th class="px-6 py-3 text-right text-xs font-medium theme-text-muted uppercase tracking-wider">
                                Earnings</th>
                            <th class="px-6 py-3 text-right text-xs font-medium theme-text-muted uppercase tracking-wider">
                                Actions</th>
                        </tr>
                    </thead>
                    <tbody class="theme-bg-card divide-y theme-border" id="providersTableBody" style="border-color: rgb(var(--border-color));">
                        @forelse ($providers as $provider)
                            @php
                                $hasSub = $provider->id % 2 != 0;
                                $planName = $hasSub ? 'Gold Pro' : 'Free';
                                $subStatus = $hasSub ? 'subscribed' : 'free';
                                // Updated status colors for themes
                                $statusColor = match ($provider->status) {
                                    'active' => 'bg-green-500/10 text-green-500 border border-green-500/20',
                                    'suspend' => 'bg-red-500/10 text-red-500 border border-red-500/20',
                                    'Ban' => 'bg-red-500/10 text-red-500 border border-red-500/20',
                                    default => 'bg-gray-500/10 text-gray-500 border border-gray-500/20',
                                };
                                $image = $provider->image
                                    ? asset($provider->image)
                                    : 'https://ui-avatars.com/api/?name=' .
                                        urlencode($provider->name) .
                                        '&background=EBF4FF&color=7F9CF5';
                                
                                $rating = number_format(rand(35, 50) / 10, 1);

                                $jsData = [
                                    'id' => $provider->id,
                                    'name' => $provider->name ?? 'N/A',
                                    'image' => $image,
                                    'email' => $provider->email ?? 'N/A',
                                    'phone' => $provider->phone ?? 'N/A',
                                    'gender' => $provider->gender ?? 'N/A',
                                    'dob' => $provider->dob ?? 'N/A',
                                    'status' => $provider->status,
                                    'rating' => $rating,
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
                            <tr class="hover:bg-white/5 transition duration-150 group provider-row"
                                data-subscription="{{ $subStatus }}" 
                                data-status="{{ $provider->status }}"
                                data-rating="{{ $rating }}"
                                data-search="{{ strtolower(($provider->name ?? '') . ' ' . ($provider->email ?? '') . ' ' . ($provider->phone ?? '')) }}">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="relative">
                                            <img class="h-10 w-10 rounded-full object-cover border theme-border"
                                                src="{{ $image }}">
                                            @if ($hasSub)
                                                <div class="absolute -top-1 -right-1 bg-yellow-400 text-white p-0.5 rounded-full border border-white"
                                                    title="Premium">
                                                    <i class="fas fa-star text-[8px]"></i>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium theme-text-main search-name">{{ $provider->name }}
                                            </div>
                                            <div class="text-xs theme-text-muted">{{ $provider->email }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span
                                        class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $hasSub ? 'bg-indigo-500/10 text-indigo-500 border border-indigo-500/20' : 'theme-bg-body theme-text-muted border theme-border' }}">{{ $planName }}</span>
                                    <div class="text-xs theme-text-muted mt-1">$NaN/hr</div>
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <span class="text-sm font-bold theme-text-main mr-2">{{ $rating }}</span>
                                        <div class="flex text-yellow-400 text-xs">
                                            @for ($i = 1; $i <= 5; $i++)
                                                @if ($i <= $rating)
                                                    <i class="fas fa-star"></i>
                                                @elseif ($i - 0.5 <= $rating)
                                                    <i class="fas fa-star-half-alt"></i>
                                                @else
                                                    <i class="far fa-star text-gray-300"></i>
                                                @endif
                                            @endfor
                                        </div>
                                    </div>
                                    <div class="text-[10px] theme-text-muted mt-0.5">24 Reviews</div>
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    <span
                                        class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $statusColor }}">{{ ucfirst($provider->status) }}</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium theme-text-main">
                                    $NaN
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <div class="flex justify-end items-center gap-2">
                                        <button onclick="openProviderDetails({{ json_encode($jsData) }})"
                                            class="text-white p-2 rounded hover:opacity-80 transition"
                                            style="background-color: rgba(var(--brand-primary), 0.1); color: rgb(var(--brand-primary));"
                                            title="View Details">
                                            View Details
                                        </button>
                                        {{-- Actions Dropdown --}}
                                        <div class="relative" x-data="{ open: false }">
                                            <button @click="open = !open" @click.away="open = false"
                                                class="theme-text-muted hover:text-white p-2 rounded-full hover:bg-white/10">
                                                <i class="fas fa-ellipsis-v"></i>
                                            </button>
                                            <div x-show="open"
                                                class="absolute right-0 mt-2 w-48 theme-bg-card rounded-md shadow-lg py-1 z-50 border theme-border"
                                                style="display: none;">
                                                <a href="#"
                                                    class="block px-4 py-2 text-sm text-red-500 hover:bg-white/5"><i
                                                        class="fas fa-ban mr-2"></i> Suspend Account</a>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr id="no-providers-row">
                                <td colspan="6" class="px-6 py-10 text-center theme-text-muted">No providers found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="p-4 border-t theme-border theme-bg-body">
                @if ($providers instanceof \Illuminate\Pagination\LengthAwarePaginator)
                    {{ $providers->links() }}
                @endif
            </div>
        </div>
    </div>

    {{-- Unified Slide-Over (Details) --}}
    <div id="details-slide-over" class="fixed inset-0 overflow-hidden z-50 hidden">
        <div class="absolute inset-0 bg-black/80 transition-opacity backdrop-blur-sm"
            onclick="closeProviderDetails()"></div>
        <div class="fixed inset-y-0 right-0 max-w-2xl w-full flex pointer-events-none">
            <div class="w-full h-full theme-bg-card shadow-2xl pointer-events-auto flex flex-col transform transition-transform duration-300 translate-x-full"
                id="slide-over-panel">

                {{-- Slide Header --}}
                <div class="theme-bg-card px-6 py-6 border-b theme-border shrink-0">
                    <div class="flex justify-between items-start">
                        <div class="flex items-center space-x-4">
                            <img id="so-image" src=""
                                class="h-16 w-16 rounded-full border-2 border-white/50 object-cover">
                            <div>
                                <h2 class="text-xl font-bold theme-text-main" id="so-name"></h2>
                                <p class="theme-text-muted text-sm flex items-center gap-2">
                                    <span id="so-email"></span>
                                    <span class="w-1 h-1 bg-gray-500 rounded-full"></span>
                                    <span id="so-status"
                                        class="uppercase text-xs font-bold theme-bg-body px-2 py-0.5 rounded border theme-border"></span>
                                </p>
                            </div>
                        </div>
                        <button onclick="closeProviderDetails()" class="theme-text-muted hover:text-white transition"><i
                                class="fas fa-times text-xl"></i></button>
                    </div>
                    {{-- Tabs --}}
                    <div class="flex space-x-6 mt-8 text-sm font-medium overflow-x-auto scrollbar-hide border-b theme-border">
                        <button onclick="switchTab('overview')"
                            class="tab-btn border-b-2 font-bold pb-3 theme-text-main transition whitespace-nowrap"
                            style="border-color: rgb(var(--brand-primary));"
                            id="tab-overview">Overview</button>
                        <button onclick="switchTab('orders')"
                            class="tab-btn border-b-2 border-transparent pb-3 theme-text-muted hover:text-white transition whitespace-nowrap"
                            id="tab-orders">Orders</button>
                        <button onclick="switchTab('wallet')"
                            class="tab-btn border-b-2 border-transparent pb-3 theme-text-muted hover:text-white transition whitespace-nowrap"
                            id="tab-wallet">Wallet</button>
                        <button onclick="switchTab('portfolio')"
                            class="tab-btn border-b-2 border-transparent pb-3 theme-text-muted hover:text-white transition whitespace-nowrap"
                            id="tab-portfolio">Portfolio</button>
                        <button onclick="switchTab('payment-methods')"
                            class="tab-btn border-b-2 border-transparent pb-3 theme-text-muted hover:text-white transition whitespace-nowrap"
                            id="tab-payment-methods">Payment Methods</button>
                        <button onclick="switchTab('documents')"
                            class="tab-btn border-b-2 border-transparent pb-3 theme-text-muted hover:text-white transition whitespace-nowrap"
                            id="tab-documents">Kyc Documents</button>
                        <button onclick="switchTab('subscription')"
                            class="tab-btn border-b-2 border-transparent pb-3 theme-text-muted hover:text-white transition whitespace-nowrap"
                            id="tab-subscription">Subscription</button>
                    </div>
                </div>

                {{-- Slide Content --}}
                <div class="flex-1 overflow-y-auto p-6 theme-bg-body scroll-smooth">
                    {{-- TAB: OVERVIEW --}}
                    <div id="content-overview" class="tab-content space-y-6">
                        <div class="theme-bg-card p-5 rounded-xl shadow-sm border theme-border">
                            <h3 class="font-bold theme-text-main mb-4 flex items-center"><i
                                    class="fas fa-user-circle mr-2" style="color: rgb(var(--brand-primary));"></i> Basic Information</h3>
                            <div class="grid grid-cols-2 gap-y-4 gap-x-6 text-sm">
                                <div>
                                    <p class="theme-text-muted text-xs uppercase">Phone</p>
                                    <p class="font-medium theme-text-main" id="so-phone"></p>
                                </div>
                                <div>
                                    <p class="theme-text-muted text-xs uppercase">Gender / DOB</p>
                                    <p class="font-medium theme-text-main" id="so-gender-dob"></p>
                                </div>
                                <div>
                                    <p class="theme-text-muted text-xs uppercase">Joined Date</p>
                                    <p class="font-medium theme-text-main" id="so-joined"></p>
                                </div>
                                <div>
                                    <p class="theme-text-muted text-xs uppercase">Hourly Rate</p>
                                    <p class="font-medium text-green-500" id="so-rate"></p>
                                </div>
                            </div>
                            <div class="mt-4 pt-4 border-t theme-border">
                                <p class="theme-text-muted text-xs uppercase mb-1">About</p>
                                <p class="theme-text-main text-sm leading-relaxed" id="so-desc"></p>
                            </div>
                        </div>
                        {{-- Logistics & Address --}}
                        <div class="theme-bg-card p-5 rounded-xl shadow-sm border theme-border">
                            <h3 class="font-bold theme-text-main mb-4 flex items-center"><i
                                    class="fas fa-map-marker-alt mr-2" style="color: rgb(var(--brand-primary));"></i> Location & Logistics</h3>
                            <div class="space-y-4 text-sm">
                                <div>
                                    <p class="text-xs theme-text-muted uppercase">Transportation</p>
                                    <p class="font-medium theme-text-main flex items-center mt-1"><i
                                            class="fas fa-motorcycle mr-2 theme-text-muted"></i> <span
                                            id="so-transport"></span></p>
                                </div>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <p class="text-xs theme-text-muted uppercase">Current Address</p>
                                        <p class="font-medium theme-text-main mt-1" id="so-addr-current"></p>
                                    </div>
                                    <div>
                                        <p class="text-xs theme-text-muted uppercase">Permanent Address</p>
                                        <p class="font-medium theme-text-main mt-1" id="so-addr-perm"></p>
                                    </div>
                                    <div>
                                        <p class="text-xs theme-text-muted uppercase">City/State</p>
                                        <p class="font-medium theme-text-main mt-1" id="so-addr-city"></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="theme-bg-card p-5 rounded-xl shadow-sm border theme-border">
                            <h3 class="font-bold theme-text-main mb-4 flex items-center"><i
                                    class="fas fa-tools mr-2" style="color: rgb(var(--brand-primary));"></i> Skills & Capabilities</h3>
                            <div class="mb-4">
                                <p class="text-xs theme-text-muted mb-2 uppercase">Skills</p>
                                <div id="so-skills" class="flex flex-wrap gap-2"></div>
                            </div>
                            <div>
                                <p class="text-xs theme-text-muted mb-2 uppercase">Languages</p>
                                <ul id="so-languages"
                                    class="list-disc list-inside text-sm theme-text-main grid grid-cols-2"></ul>
                            </div>
                        </div>
                    </div>

                    {{-- TAB: ORDERS --}}
                    <div id="content-orders" class="tab-content hidden space-y-4">
                        <div class="theme-bg-card p-5 rounded-xl shadow-sm border theme-border">
                            <h3 class="font-bold theme-text-main mb-4">Work History</h3>
                            <div id="so-orders-list" class="space-y-3"></div>
                        </div>
                    </div>

                    {{-- TAB: WALLET --}}
                    <div id="content-wallet" class="tab-content hidden space-y-6">
                        {{-- Balance Card --}}
                        <div class="rounded-2xl p-6 text-white shadow-lg" style="background: linear-gradient(135deg, rgb(var(--brand-primary)), rgb(var(--brand-secondary)));">
                            <div class="flex justify-between items-start">
                                <div>
                                    <p class="text-white/80 text-xs font-bold uppercase tracking-wider">Total Balance
                                    </p>
                                    <h2 class="text-3xl font-bold mt-1" id="so-wallet-balance">$0.00</h2>
                                </div>
                                <div class="p-2 bg-white/20 rounded-lg backdrop-blur-sm">
                                    <i class="fas fa-wallet text-2xl"></i>
                                </div>
                            </div>
                            <div class="mt-6 flex gap-4">
                                <div class="bg-black/10 rounded-lg p-3 flex-1">
                                    <p class="text-xs text-white/80 mb-1">Pending</p>
                                    <p class="font-semibold" id="so-wallet-pending">$0.00</p>
                                </div>
                                <div class="bg-black/10 rounded-lg p-3 flex-1">
                                    <p class="text-xs text-white/80 mb-1">Withdrawn</p>
                                    <p class="font-semibold" id="so-wallet-withdrawn">$0.00</p>
                                </div>
                            </div>
                        </div>

                        {{-- Transactions List --}}
                        <div class="theme-bg-card p-5 rounded-xl shadow-sm border theme-border">
                            <h3 class="font-bold theme-text-main mb-4">Recent Transactions</h3>
                            <div class="space-y-4">
                                <div class="flex justify-between items-center border-b theme-border pb-3 last:border-0">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="h-8 w-8 rounded-full bg-green-500/10 text-green-500 flex items-center justify-center text-xs">
                                            <i class="fas fa-arrow-down"></i>
                                        </div>
                                        <div>
                                            <p class="text-sm font-medium theme-text-main">Job Completion</p>
                                            <p class="text-xs theme-text-muted">Service Fee Earned</p>
                                        </div>
                                    </div>
                                    <span class="text-sm font-bold text-green-500">+$45.00</span>
                                </div>
                                <div class="flex justify-between items-center border-b theme-border pb-3 last:border-0">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="h-8 w-8 rounded-full bg-red-500/10 text-red-500 flex items-center justify-center text-xs">
                                            <i class="fas fa-arrow-up"></i>
                                        </div>
                                        <div>
                                            <p class="text-sm font-medium theme-text-main">Withdrawal</p>
                                            <p class="text-xs theme-text-muted">Bank Transfer</p>
                                        </div>
                                    </div>
                                    <span class="text-sm font-bold theme-text-main">-$150.00</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- TAB: PORTFOLIO --}}
                    <div id="content-portfolio" class="tab-content hidden h-full">
                        <div
                            class="flex flex-col items-center justify-center h-64 border-2 border-dashed theme-border rounded-xl theme-bg-card">
                            <div class="h-12 w-12 theme-bg-body rounded-full flex items-center justify-center theme-text-muted mb-3">
                                <i class="fas fa-images"></i>
                            </div>
                            <p class="theme-text-main text-sm font-medium">Portfolio Section</p>
                            <p class="theme-text-muted text-xs mt-1">No portfolio items available.</p>
                        </div>
                    </div>

                    {{-- TAB: PAYMENT METHODS --}}
                    <div id="content-payment-methods" class="tab-content hidden space-y-4">
                        <div class="theme-bg-card p-5 rounded-xl shadow-sm border theme-border">
                            <h3 class="font-bold theme-text-main mb-4">Linked Payment Methods</h3>
                            <div id="so-payment-methods-list" class="space-y-3"></div>
                        </div>
                    </div>

                    {{-- TAB: DOCUMENTS --}}
                    <div id="content-documents" class="tab-content hidden space-y-4">
                        <div class="theme-bg-card p-6 rounded-xl shadow-sm border theme-border">
                            <div class="flex justify-between items-center mb-6">
                                <h3 class="font-bold theme-text-main">Submitted Documents</h3>
                                <span class="bg-yellow-500/10 text-yellow-500 border border-yellow-500/20 text-xs font-bold px-2 py-1 rounded">Pending
                                    Review</span>
                            </div>
                            <div id="so-kyc-list" class="space-y-3"></div>

                            {{-- KYC Action Buttons --}}
                            <div class="mt-8 pt-6 border-t theme-border flex gap-3">
                                <button
                                    class="flex-1 px-4 py-2.5 bg-red-500/10 text-red-500 hover:bg-red-500/20 border border-red-500/20 rounded-lg font-medium transition shadow-sm">
                                    <i class="fas fa-times-circle mr-2"></i> Reject KYC
                                </button>
                                <button
                                    class="flex-1 px-4 py-2.5 bg-green-600 text-white hover:bg-green-700 rounded-lg font-medium transition shadow-md">
                                    <i class="fas fa-check-circle mr-2"></i> Approve KYC
                                </button>
                            </div>
                        </div>
                    </div>

                    {{-- TAB: SUBSCRIPTION --}}
                    <div id="content-subscription" class="tab-content hidden space-y-4">
                        <div id="so-subscription-container"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    {{-- ADD PROVIDER MODAL --}}
    <div id="create-provider-modal" class="fixed inset-0 z-50 hidden" aria-labelledby="modal-title" role="dialog"
        aria-modal="true">
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            {{-- Backdrop --}}
            <div class="fixed inset-0 bg-black/80 transition-opacity backdrop-blur-sm"
                onclick="closeCreateProviderModal()"></div>

            <div
                class="inline-block align-bottom theme-bg-card border theme-border rounded-2xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg w-full">
                <div class="theme-bg-card px-6 py-6 border-b theme-border flex justify-between items-center">
                    <h3 class="text-xl font-bold theme-text-main"><i class="fas fa-user-plus mr-2" style="color: rgb(var(--brand-primary));"></i>
                        Onboard Provider</h3>
                    <button onclick="closeCreateProviderModal()"
                        class="theme-text-muted hover:text-white focus:outline-none"><i class="fas fa-times"></i></button>
                </div>

                <form id="providerForm" action="{{ route('store.provider') }}" method="POST"
                    enctype="multipart/form-data" onsubmit="submitProvider(event)">
                    @csrf
                    <div class="p-6 space-y-4 max-h-[60vh] overflow-y-auto">

                        {{-- Error Display Box --}}
                        <div id="error-message-box"
                            class="hidden bg-red-500/10 text-red-500 p-3 rounded-lg text-sm border border-red-500/20"></div>
                        <div id="success-message-box"
                            class="hidden bg-green-500/10 text-green-500 p-3 rounded-lg text-sm border border-green-500/20"></div>

                        <div class="grid grid-cols-1 gap-4">
                            <div>
                                <label class="block text-sm font-medium theme-text-muted mb-1">Full Name</label>
                                <input type="text" name="name" required placeholder="John Doe"
                                    class="w-full theme-bg-body border theme-border rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 sm:text-sm p-2.5 theme-text-main">
                            </div>
                            <div>
                                <label class="block text-sm font-medium theme-text-muted mb-1">Email Address</label>
                                <input type="email" name="email" required placeholder="john@example.com"
                                    class="w-full theme-bg-body border theme-border rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 sm:text-sm p-2.5 theme-text-main">
                            </div>
                            <div>
                                <label class="block text-sm font-medium theme-text-muted mb-1">Phone Number</label>
                                <input type="text" name="phone" required placeholder="+1 234 567 890"
                                    class="w-full theme-bg-body border theme-border rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 sm:text-sm p-2.5 theme-text-main">
                            </div>
                            <div>
                                <label class="block text-sm font-medium theme-text-muted mb-1">Password</label>
                                <input type="password" name="password" required placeholder="********"
                                    class="w-full theme-bg-body border theme-border rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 sm:text-sm p-2.5 theme-text-main">
                            </div>
                            <div>
                                <label class="block text-sm font-medium theme-text-muted mb-1">Service Category</label>
                                <select name="category_id"
                                    class="w-full theme-bg-body border theme-border rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 sm:text-sm p-2.5 theme-text-main">
                                    <option value="">Select Category</option>
                                    <option value="1">General Service</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="p-6 border-t theme-border flex justify-end theme-bg-card rounded-b-2xl">
                        <button type="button" onclick="closeCreateProviderModal()"
                            class="mr-3 px-4 py-2 theme-text-muted theme-bg-body border theme-border rounded-lg hover:bg-white/5 transition shadow-sm font-medium">Cancel</button>
                        <button type="submit" id="submitBtn"
                            class="px-4 py-2 text-white rounded-lg shadow-md flex items-center transition font-medium hover:opacity-90"
                            style="background-color: rgb(var(--brand-primary));">
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

            submitBtn.disabled = true;
            loadingIcon.classList.remove('hidden');
            errorBox.classList.add('hidden');
            successBox.classList.add('hidden');

            const formData = new FormData(form);

            try {
                const response = await fetch(form.action, {
                    method: 'POST',
                    body: formData,
                    headers: { 'X-Requested-With': 'XMLHttpRequest' }
                });

                const data = await response.json();

                if (response.ok) {
                    successBox.innerText = "Provider added successfully! Reloading...";
                    successBox.classList.remove('hidden');
                    setTimeout(() => { location.reload(); }, 1000);
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

            // Wallet Data
            document.getElementById('so-wallet-balance').innerText = `$${data.wallet.balance}`;
            document.getElementById('so-wallet-pending').innerText = `$${data.wallet.pending}`;
            document.getElementById('so-wallet-withdrawn').innerText = `$${data.wallet.withdrawn}`;

            // Payment Methods
            const payMethodList = document.getElementById('so-payment-methods-list');
            if (data.payment_methods && data.payment_methods.length > 0) {
                payMethodList.innerHTML = data.payment_methods.map(pm => `
                <div class="flex items-center p-3 border theme-border rounded-lg hover:bg-white/5 transition">
                    <div class="h-10 w-10 bg-indigo-500/10 text-indigo-500 rounded-full flex items-center justify-center mr-3">
                         <i class="fas fa-credit-card"></i>
                    </div>
                    <div>
                        <p class="text-sm font-medium theme-text-main">${pm}</p>
                        <p class="text-xs theme-text-muted">Verified</p>
                    </div>
                </div>
            `).join('');
            } else {
                payMethodList.innerHTML = '<div class="text-center py-4 theme-text-muted italic">No payment methods linked.</div>';
            }

            // Orders
            const ordersList = document.getElementById('so-orders-list');
            if (data.orders && data.orders.length > 0) {
                ordersList.innerHTML = data.orders.map(order => `
                <div class="flex items-center justify-between p-3 border theme-border rounded-lg hover:bg-white/5 transition">
                    <div class="flex items-center gap-3">
                        <div class="h-10 w-10 bg-blue-500/10 text-blue-500 rounded-lg flex items-center justify-center text-sm font-bold">
                             <i class="fas fa-clipboard-list"></i>
                        </div>
                        <div>
                            <p class="text-sm font-bold theme-text-main">${order.service}</p>
                            <p class="text-xs theme-text-muted">${order.id} • ${order.customer}</p>
                        </div>
                    </div>
                    <div class="text-right">
                        <p class="text-sm font-bold theme-text-main">$${order.amount}</p>
                        <span class="text-[10px] uppercase font-bold px-2 py-0.5 rounded ${order.status === 'Completed' ? 'bg-green-500/10 text-green-500' : 'bg-yellow-500/10 text-yellow-500'}">${order.status}</span>
                    </div>
                </div>
            `).join('');
            } else {
                ordersList.innerHTML = '<div class="text-center py-4 theme-text-muted italic">No order history available.</div>';
            }

            // Skills
            const skillsContainer = document.getElementById('so-skills');
            if (data.skills && data.skills.length > 0) {
                skillsContainer.innerHTML = data.skills.map(skill =>
                    `<span class="px-2 py-1 bg-indigo-500/10 text-indigo-500 text-xs rounded border border-indigo-500/20">${skill}</span>`
                    ).join('');
            } else {
                skillsContainer.innerHTML = '<span class="theme-text-muted text-xs italic">No skills listed</span>';
            }

            // Languages
            const langContainer = document.getElementById('so-languages');
            if (data.languages && data.languages.length > 0) {
                langContainer.innerHTML = data.languages.map(l => `<li>${l}</li>`).join('');
            } else {
                langContainer.innerHTML = '<li class="theme-text-muted italic">N/A</li>';
            }

            // KYC Tab
            const kycContainer = document.getElementById('so-kyc-list');
            if (data.kyc_documents && data.kyc_documents.length > 0) {
                kycContainer.innerHTML = data.kyc_documents.map(doc => `
                <div class="flex items-center justify-between p-3 theme-bg-card border theme-border rounded-lg hover:shadow-sm transition">
                    <div class="flex items-center space-x-3">
                        <div class="h-10 w-10 bg-indigo-500/10 text-indigo-500 rounded-lg flex items-center justify-center text-lg"><i class="fas fa-file-alt"></i></div>
                        <div>
                            <p class="text-sm font-semibold theme-text-main">${doc.name}</p>
                            <span class="text-[10px] theme-text-muted uppercase">${doc.type}</span>
                        </div>
                    </div>
                    <button class="px-3 py-1.5 theme-bg-body hover:bg-white/10 text-indigo-500 text-xs font-bold rounded transition">View</button>
                </div>
            `).join('');
            } else {
                kycContainer.innerHTML = '<div class="text-center py-4 theme-text-muted italic">No documents submitted.</div>';
            }

            // Subscription Tab
            const subContainer = document.getElementById('so-subscription-container');
            if (data.subscription.has_plan) {
                subContainer.innerHTML = `
            <div class="relative overflow-hidden theme-bg-body p-6 rounded-2xl shadow-xl text-white">
                <div class="absolute top-0 right-0 -mt-4 -mr-4 w-32 h-32 bg-indigo-500 rounded-full opacity-20 blur-2xl"></div>
                <div class="relative z-10">
                    <p class="text-indigo-300 text-xs font-bold uppercase tracking-wider mb-1">Current Plan</p>
                    <h2 class="text-2xl font-extrabold theme-text-main tracking-tight">${data.subscription.plan_name}</h2>
                    <div class="mt-6 space-y-3">
                        <div class="flex justify-between text-sm"><span class="theme-text-muted">Validity</span><span class="theme-text-main font-medium">${data.subscription.progress}%</span></div>
                        <div class="w-full bg-gray-700 rounded-full h-2"><div class="bg-gradient-to-r from-indigo-500 to-purple-500 h-2 rounded-full" style="width: ${data.subscription.progress}%"></div></div>
                        <div class="flex justify-between text-xs mt-1"><span class="theme-text-muted">Expires</span><span class="text-indigo-300 font-medium">${data.subscription.expires_at}</span></div>
                    </div>
                </div>
            </div>`;
            } else {
                subContainer.innerHTML = '<div class="p-6 text-center border-dashed border-2 theme-border rounded-xl theme-text-muted">No active subscription</div>';
            }

            switchTab('overview');
        }

        function closeProviderDetails() {
            document.getElementById('slide-over-panel').classList.add('translate-x-full');
            setTimeout(() => { document.getElementById('details-slide-over').classList.add('hidden'); }, 300);
        }

        function switchTab(tabName) {
            document.querySelectorAll('.tab-btn').forEach(btn => {
                btn.classList.remove('border-white', 'text-white'); // Remove hardcoded white
                btn.classList.add('border-transparent', 'theme-text-muted');
                btn.style.borderColor = 'transparent'; // Reset inline styles
                btn.style.color = ''; 
            });
            document.querySelectorAll('.tab-content').forEach(content => content.classList.add('hidden'));

            const activeBtn = document.getElementById('tab-' + tabName);
            activeBtn.classList.remove('border-transparent', 'theme-text-muted');
            // Apply brand color for active state via inline style to support variables
            activeBtn.style.borderColor = 'rgb(var(--brand-primary))';
            activeBtn.style.color = 'rgb(var(--brand-primary))';
            
            document.getElementById('content-' + tabName).classList.remove('hidden');
        }

        // --- Filter Logic ---
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('searchInput');
            const subFilter = document.getElementById('subscriptionFilter');
            const kycFilter = document.getElementById('kycFilter');
            const ratingFilter = document.getElementById('ratingFilter');
            const tableRows = document.querySelectorAll('.provider-row');

            function filterProviders() {
                const searchValue = searchInput.value.toLowerCase();
                const subValue = subFilter.value;
                const kycValue = kycFilter.value;
                const ratingValue = ratingFilter.value;

                tableRows.forEach(row => {
                    const searchData = row.getAttribute('data-search') || '';
                    const rowSub = row.getAttribute('data-subscription');
                    const rowStatus = row.getAttribute('data-status');
                    const rowRating = parseFloat(row.getAttribute('data-rating'));

                    const matchesSearch = searchData.includes(searchValue);
                    const matchesSub = (subValue === 'all') || (subValue === rowSub);
                    const matchesKyc = (kycValue === '') || (rowStatus === kycValue);
                    let matchesRating = true;
                    if (ratingValue !== 'all') { matchesRating = rowRating >= parseFloat(ratingValue); }

                    if (matchesSearch && matchesSub && matchesKyc && matchesRating) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                });
            }

            searchInput.addEventListener('keyup', filterProviders);
            subFilter.addEventListener('change', filterProviders);
            kycFilter.addEventListener('change', filterProviders);
            ratingFilter.addEventListener('change', filterProviders);
        });
    </script>
@endpush