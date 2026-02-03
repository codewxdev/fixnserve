@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50/50 p-6 space-y-8">
    {{-- 1. HEADER --}}
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 tracking-tight">Expert Management</h1>
            <p class="text-sm text-gray-500">Manage professionals, validations, performance, and KYC.</p>
        </div>
        <button onclick="openCreateExpertModal()" class="inline-flex items-center justify-center px-4 py-2 bg-indigo-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:outline-none focus:border-indigo-700 focus:ring focus:ring-indigo-200 active:bg-indigo-600 disabled:opacity-25 transition shadow-lg shadow-indigo-200">
            <i class="fas fa-plus mr-2"></i> Add Professional
        </button>
    </div>

    {{-- 2. STATS CARDS --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        
        <div class="relative bg-white p-6 rounded-2xl shadow-sm border border-gray-100 overflow-hidden group hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
            <div class="absolute top-0 right-0 -mt-4 -mr-4 w-24 h-24 rounded-full bg-indigo-50/50 group-hover:bg-indigo-100 transition-colors duration-300"></div>
            <div class="relative flex justify-between items-start z-10">
                <div>
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Total Experts</p>
                    <h3 class="text-3xl font-extrabold text-gray-900 mt-2 group-hover:text-indigo-600 transition-colors">{{ $professionals->count() }}</h3>
                </div>
                <div class="p-3 bg-indigo-50 text-indigo-600 rounded-xl shadow-inner group-hover:scale-110 transition-transform duration-300">
                    <i class="fas fa-user-tie text-xl"></i>
                </div>
            </div>
            <div class="mt-4 flex items-center text-xs text-gray-400">
                <span class="text-indigo-600 font-bold bg-indigo-50 px-1.5 py-0.5 rounded mr-2"><i class="fas fa-arrow-up"></i> New</span>
                <span>Registrations</span>
            </div>
            <div class="absolute bottom-0 left-0 w-full h-1 bg-gradient-to-r from-indigo-400 to-purple-500 transform scale-x-0 group-hover:scale-x-100 transition-transform duration-500 origin-left"></div>
        </div>

        <div class="relative bg-white p-6 rounded-2xl shadow-sm border border-gray-100 overflow-hidden group hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
            <div class="absolute top-0 right-0 -mt-4 -mr-4 w-24 h-24 rounded-full bg-emerald-50/50 group-hover:bg-emerald-100 transition-colors duration-300"></div>
            <div class="relative flex justify-between items-start z-10">
                <div>
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Active Now</p>
                    <h3 class="text-3xl font-extrabold text-gray-900 mt-2 group-hover:text-emerald-600 transition-colors">{{ $professionals->where('status', 'active')->count() }}</h3>
                </div>
                <div class="p-3 bg-emerald-50 text-emerald-600 rounded-xl shadow-inner group-hover:scale-110 transition-transform duration-300">
                    <i class="fas fa-check-circle text-xl"></i>
                </div>
            </div>
            <div class="mt-4 flex items-center text-xs text-gray-400">
                <span class="text-emerald-600 font-bold bg-emerald-50 px-1.5 py-0.5 rounded mr-2"><i class="fas fa-wifi"></i> Online</span>
                <span>Ready for work</span>
            </div>
            <div class="absolute bottom-0 left-0 w-full h-1 bg-gradient-to-r from-emerald-400 to-teal-500 transform scale-x-0 group-hover:scale-x-100 transition-transform duration-500 origin-left"></div>
        </div>

        <div class="relative bg-white p-6 rounded-2xl shadow-sm border border-gray-100 overflow-hidden group hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
            <div class="absolute top-0 right-0 -mt-4 -mr-4 w-24 h-24 rounded-full bg-rose-50/50 group-hover:bg-rose-100 transition-colors duration-300"></div>
            <div class="relative flex justify-between items-start z-10">
                <div>
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Suspended</p>
                    <h3 class="text-3xl font-extrabold text-gray-900 mt-2 group-hover:text-rose-600 transition-colors">{{ $professionals->where('status', 'suspend')->count() }}</h3>
                </div>
                <div class="p-3 bg-rose-50 text-rose-600 rounded-xl shadow-inner group-hover:scale-110 transition-transform duration-300">
                    <i class="fas fa-ban text-xl"></i>
                </div>
            </div>
            <div class="mt-4 flex items-center text-xs text-gray-400">
                <span class="text-rose-600 font-bold bg-rose-50 px-1.5 py-0.5 rounded mr-2"><i class="fas fa-exclamation-circle"></i> Flagged</span>
                <span>Accounts</span>
            </div>
            <div class="absolute bottom-0 left-0 w-full h-1 bg-gradient-to-r from-rose-400 to-red-500 transform scale-x-0 group-hover:scale-x-100 transition-transform duration-500 origin-left"></div>
        </div>

        <div class="relative bg-white p-6 rounded-2xl shadow-sm border border-gray-100 overflow-hidden group hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
            <div class="absolute top-0 right-0 -mt-4 -mr-4 w-24 h-24 rounded-full bg-amber-50/50 group-hover:bg-amber-100 transition-colors duration-300"></div>
            <div class="relative flex justify-between items-start z-10">
                <div>
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Pending KYC</p>
                    <h3 class="text-3xl font-extrabold text-gray-900 mt-2 group-hover:text-amber-600 transition-colors">{{ $professionals->where('kyc_status', 'pending')->count() }}</h3>
                </div>
                <div class="p-3 bg-amber-50 text-amber-600 rounded-xl shadow-inner group-hover:scale-110 transition-transform duration-300">
                    <i class="fas fa-file-contract text-xl"></i>
                </div>
            </div>
            <div class="mt-4 flex items-center text-xs text-gray-400">
                <span class="text-amber-600 font-bold bg-amber-50 px-1.5 py-0.5 rounded mr-2"><i class="fas fa-clock"></i> Queue</span>
                <span>Needs Verification</span>
            </div>
            <div class="absolute bottom-0 left-0 w-full h-1 bg-gradient-to-r from-amber-400 to-orange-500 transform scale-x-0 group-hover:scale-x-100 transition-transform duration-500 origin-left"></div>
        </div>

    </div>

    {{-- 3. MAIN CONTENT (Filter & Table) --}}
    <div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden">
        {{-- Filter Bar --}}
        <form id="filter-form" class="p-4 border-b border-gray-100 bg-gray-50 flex flex-wrap gap-4 items-center justify-between">
            {{-- Search --}}
            <div class="relative flex-1 max-w-md min-w-[200px]">
                <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
                <input type="text" id="filter-search" placeholder="Search by name, ID, email..." class="w-full pl-10 pr-4 py-2 text-sm border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500">
            </div>

            {{-- Dropdowns --}}
            <div class="flex flex-wrap gap-2">
                <select id="filter-category" class="text-sm border-gray-300 rounded-lg focus:ring-indigo-500 bg-white">
                    <option value="">All Categories</option>
                    <option value="legal">Legal</option>
                    <option value="finance">Finance</option>
                    <option value="architecture">Architecture</option>
                    <option value="technology">Technology</option>
                </select>
                <select id="filter-region" class="text-sm border-gray-300 rounded-lg focus:ring-indigo-500 bg-white">
                    <option value="">All Regions</option>
                    <option value="north america">North America</option>
                    <option value="europe">Europe</option>
                    <option value="asia">Asia</option>
                </select>
                <select id="filter-subscription" class="text-sm border-gray-300 rounded-lg focus:ring-indigo-500 bg-white">
                    <option value="all">All Plans</option>
                    <option value="subscribed">Premium</option>
                    <option value="free">Standard</option>
                </select>
                <select id="filter-kyc" class="text-sm border-gray-300 rounded-lg focus:ring-indigo-500 bg-white">
                    <option value="">KYC Status</option>
                    <option value="verified">Verified</option>
                    <option value="pending">Pending</option>
                    <option value="rejected">Rejected</option>
                </select>
            </div>
            
            {{-- Reset & Count --}}
            <div class="flex items-center gap-3">
                <span id="result-count" class="text-xs font-semibold text-gray-500 uppercase hidden md:inline-block">Total: {{ $professionals->count() }}</span>
                <button type="button" id="reset-filters" class="text-xs text-indigo-600 hover:text-indigo-800 font-medium">Reset</button>
            </div>
        </form>

        {{-- Table --}}
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Expert Profile</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Category & Rate</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Performance</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200" id="experts-table-body">
                    @forelse ($professionals as $expert)
                        @php
                            $hasSub = ($expert->id % 2 != 0); 
                            $planName = $hasSub ? 'Diamond Expert' : 'Standard';
                            $subStatus = $hasSub ? 'subscribed' : 'free';
                            $category = $expert->specialization ?? 'General';
                            $rate = $expert->hourly_rate ?? 0;
                            
                            $statusClasses = match($expert->status) {
                                'active' => 'bg-green-100 text-green-800',
                                'busy' => 'bg-yellow-100 text-yellow-800',
                                'offline' => 'bg-gray-100 text-gray-800',
                                'suspend' => 'bg-red-100 text-red-800',
                                default => 'bg-gray-100 text-gray-800'
                            };
                            
                            $image = $expert->image ? asset($expert->image) : 'https://ui-avatars.com/api/?name='.urlencode($expert->name).'&background=0D8ABC&color=fff';
                            
                            // JS Data Payload - UPDATED
                            $jsData = [
                                'id' => $expert->id,
                                'name' => $expert->name,
                                'image' => $image,
                                'email' => $expert->email,
                                'phone' => $expert->phone ?? '+1 234 567 8900',
                                'status' => ucfirst($expert->status),
                                'category' => $category,
                                'rate' => $rate,
                                'region' => $expert->city ?? 'Remote',
                                'join_date' => $expert->created_at->format('M d, Y'),
                                'description' => 'Experienced professional specialized in ' . $category . '.', 
                                'kyc_status' => 'verified',
                                'address' => [
                                    'current' => $expert->current_address ?? '123 Tech Street, Suite 400',
                                    'permanent' => $expert->permanent_address ?? '456 Home Avenue',
                                    'city' => $expert->city ?? 'New York',
                                    'state' => $expert->state ?? 'NY'
                                ],
                                'wallet' => [
                                    'balance' => rand(500, 15000) . '.00',
                                    'pending' => rand(0, 1000) . '.00',
                                    'withdrawn' => rand(2000, 25000) . '.00',
                                ],
                                'orders' => [
                                    [
                                        'id' => '#EXP-' . rand(1000, 9999),
                                        'client' => 'Acme Corp',
                                        'task' => 'website development',
                                        'date' => 'Oct 25, 2023',
                                        'amount' => '150.00',
                                        'status' => 'Completed'
                                    ],
                                    [
                                        'id' => '#EXP-' . rand(1000, 9999),
                                        'client' => 'John Smith',
                                        'task' => 'App development',
                                        'date' => 'Oct 20, 2023',
                                        'amount' => '300.00',
                                        'status' => 'Pending'
                                    ],
                                ],
                                'payment_methods' => ['Visa **** 4242', 'Payoneer ID-445'],
                                'documents' => [
                                    ['name' => 'Govt ID Front', 'type' => 'PDF', 'status' => 'Approved'],
                                    ['name' => 'Professional License', 'type' => 'Image', 'status' => 'Pending']
                                ],
                                'subscription' => [
                                    'has_plan' => $hasSub,
                                    'plan_name' => $planName,
                                    'expires_at' => now()->addDays(30)->format('M d, Y'),
                                    'progress' => 80
                                ],
                                // NEW SERVICES DATA
                                'services' => [
                                    [
                                        'title' => 'Full Website Audit',
                                        'price' => rand(100, 300),
                                        'delivery' => '2 Days',
                                        'status' => 'Active'
                                    ],
                                    [
                                        'title' => '1-on-1 Consultation',
                                        'price' => rand(50, 150),
                                        'delivery' => '1 Hour',
                                        'status' => 'Active'
                                    ],
                                    [
                                        'title' => 'Custom Development',
                                        'price' => rand(500, 1000),
                                        'delivery' => '1 Week',
                                        'status' => 'Inactive'
                                    ]
                                ]
                            ];
                        @endphp
                        
                        <tr class="expert-row hover:bg-indigo-50/30 transition duration-150 group" 
                            data-name="{{ strtolower($expert->name) }}"
                            data-id="{{ $expert->id }}"
                            data-category="{{ strtolower($category) }}"
                            data-rate="{{ $rate }}"
                            data-status="{{ strtolower($expert->status) }}"
                            data-kyc="verified"
                            data-region="{{ strtolower($expert->city ?? '') }}"
                            data-subscription="{{ $subStatus }}">
                            
                            {{-- Profile --}}
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="relative">
                                        <img class="h-10 w-10 rounded-full object-cover border border-gray-200" src="{{ $image }}">
                                        @if ($hasSub)
                                            <div class="absolute -top-1 -right-1 bg-indigo-600 text-white p-0.5 rounded-full border border-white" title="Diamond Expert">
                                                <i class="fas fa-gem text-[8px]"></i>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900">{{ $expert->name }}</div>
                                        <div class="text-xs text-gray-500">{{ $expert->email }}</div>
                                    </div>
                                </div>
                            </td>

                            {{-- Category/Rate --}}
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $hasSub ? 'bg-indigo-100 text-indigo-800' : 'bg-gray-100 text-gray-800' }}">{{ $category }}</span>
                                <div class="text-xs text-gray-500 mt-1 font-medium">${{ $rate }}/hr</div>
                            </td>

                            {{-- Status --}}
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $statusClasses }}">{{ ucfirst($expert->status) }}</span>
                            </td>

                            {{-- Performance --}}
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium text-gray-900">
                                4.9 <span class="text-yellow-400 text-xs"><i class="fas fa-star"></i></span>
                            </td>

                            {{-- Actions --}}
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <div class="flex justify-end items-center gap-2">
                                    <button onclick="openExpertDetails({{ json_encode($jsData) }})" class="text-indigo-600 hover:text-indigo-900 bg-indigo-50 p-2 rounded hover:bg-indigo-100 transition" title="View Details">
                                        View Details
                                    </button>
                                    <div class="relative" x-data="{ open: false }">
                                        <button @click="open = !open" @click.away="open = false" class="text-gray-400 hover:text-gray-600 p-2 rounded-full hover:bg-gray-100">
                                            <i class="fas fa-ellipsis-v"></i>
                                        </button>
                                        <div x-show="open" class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-50 border border-gray-100" style="display: none;">
                                            {{-- CHANGED: Only Suspend Account is shown here --}}
                                            <a href="#" class="block px-4 py-2 text-sm text-red-600 hover:bg-red-50"><i class="fas fa-ban mr-2"></i> Suspend Account</a>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="px-6 py-10 text-center text-gray-500">No professionals found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-4 border-t border-gray-100">
            @if ($professionals instanceof \Illuminate\Pagination\LengthAwarePaginator) {{ $professionals->links() }} @endif
        </div>
    </div>
</div>

{{-- 4. UNIFIED SLIDE-OVER --}}
<div id="expert-slide-over" class="fixed inset-0 overflow-hidden z-50 hidden">
    <div class="absolute inset-0 bg-gray-900 bg-opacity-75 transition-opacity backdrop-blur-sm" onclick="closeExpertDetails()"></div>
    <div class="fixed inset-y-0 right-0 max-w-2xl w-full flex pointer-events-none">
        <div class="w-full h-full bg-white shadow-2xl pointer-events-auto flex flex-col transform transition-transform duration-300 translate-x-full" id="so-panel">
            
            {{-- Slide Header --}}
            <div class="bg-indigo-900 px-6 py-6 text-white shrink-0">
                <div class="flex justify-between items-start">
                    <div class="flex items-center space-x-4">
                        <img id="so-image" src="" class="h-16 w-16 rounded-full border-2 border-white/50 object-cover">
                        <div>
                            <h2 class="text-xl font-bold" id="so-name"></h2>
                            <p class="text-indigo-200 text-sm flex items-center gap-2">
                                <span id="so-email"></span>
                                <span class="w-1 h-1 bg-white rounded-full"></span>
                                <span id="so-status-badge" class="uppercase text-xs font-bold bg-white/20 px-2 py-0.5 rounded"></span>
                            </p>
                        </div>
                    </div>
                    <button onclick="closeExpertDetails()" class="text-white hover:text-indigo-200 transition"><i class="fas fa-times text-xl"></i></button>
                </div>
                {{-- Tabs --}}
                <div class="flex space-x-6 mt-8 text-sm font-medium overflow-x-auto scrollbar-hide">
                    <button onclick="switchTab('overview')" class="tab-btn border-b-2 border-white pb-3 text-white transition whitespace-nowrap" id="tab-overview">Overview</button>
                    <button onclick="switchTab('orders')" class="tab-btn border-b-2 border-transparent pb-3 text-indigo-300 hover:text-white transition whitespace-nowrap" id="tab-orders">Orders</button>
                    <button onclick="switchTab('services')" class="tab-btn border-b-2 border-transparent pb-3 text-indigo-300 hover:text-white transition whitespace-nowrap" id="tab-services">Services</button>
                    <button onclick="switchTab('wallet')" class="tab-btn border-b-2 border-transparent pb-3 text-indigo-300 hover:text-white transition whitespace-nowrap" id="tab-wallet">Wallet</button>
                    <button onclick="switchTab('portfolio')" class="tab-btn border-b-2 border-transparent pb-3 text-indigo-300 hover:text-white transition whitespace-nowrap" id="tab-portfolio">Portfolio</button>
                    <button onclick="switchTab('payment-methods')" class="tab-btn border-b-2 border-transparent pb-3 text-indigo-300 hover:text-white transition whitespace-nowrap" id="tab-payment-methods">Payment Methods</button>
                    <button onclick="switchTab('documents')" class="tab-btn border-b-2 border-transparent pb-3 text-indigo-300 hover:text-white transition whitespace-nowrap" id="tab-documents">Kyc Documents</button>
                    <button onclick="switchTab('subscription')" class="tab-btn border-b-2 border-transparent pb-3 text-indigo-300 hover:text-white transition whitespace-nowrap" id="tab-subscription">Subscription</button>
                </div>
            </div>

            {{-- Slide Content --}}
            <div class="flex-1 overflow-y-auto p-6 bg-gray-50 scroll-smooth">
                
                {{-- TAB: OVERVIEW --}}
                <div id="content-overview" class="tab-content space-y-6">
                    {{-- Basic Info --}}
                    <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-100">
                        <h3 class="font-bold text-gray-900 mb-4 flex items-center"><i class="fas fa-id-card mr-2 text-indigo-500"></i> Professional Details</h3>
                        <div class="grid grid-cols-2 gap-y-4 gap-x-6 text-sm">
                            <div><p class="text-gray-500 text-xs uppercase">Category</p><p class="font-medium text-gray-900" id="so-category"></p></div>
                            <div><p class="text-gray-500 text-xs uppercase">Hourly Rate</p><p class="font-medium text-green-600" id="so-rate"></p></div>
                            <div><p class="text-gray-500 text-xs uppercase">Location</p><p class="font-medium text-gray-900" id="so-region"></p></div>
                            <div><p class="text-gray-500 text-xs uppercase">Joined</p><p class="font-medium text-gray-900" id="so-joined"></p></div>
                        </div>
                        <div class="mt-4 pt-4 border-t border-gray-100">
                            <p class="text-gray-500 text-xs uppercase mb-1">Contact</p>
                            <p class="text-gray-900 font-medium text-sm" id="so-phone"></p>
                        </div>
                    </div>

                    {{-- Address Section --}}
                    <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-100">
                        <h3 class="font-bold text-gray-900 mb-4 flex items-center"><i class="fas fa-map-marker-alt mr-2 text-indigo-500"></i> Address Details</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                            <div class="col-span-2">
                                <p class="text-xs text-gray-500 uppercase">Current Address</p>
                                <p class="font-medium text-gray-900 mt-1" id="so-addr-current"></p>
                            </div>
                            <div class="col-span-2">
                                <p class="text-xs text-gray-500 uppercase">Permanent Address</p>
                                <p class="font-medium text-gray-900 mt-1" id="so-addr-perm"></p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500 uppercase">City / State</p>
                                <p class="font-medium text-gray-900 mt-1" id="so-addr-city"></p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- TAB: ORDERS --}}
                <div id="content-orders" class="tab-content hidden space-y-4">
                    <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-100">
                        <h3 class="font-bold text-gray-900 mb-4">Order History</h3>
                        <div id="so-orders-list" class="space-y-3">
                            {{-- Populated by JS --}}
                        </div>
                    </div>
                </div>

                {{-- TAB: SERVICES --}}
                <div id="content-services" class="tab-content hidden space-y-4">
                    <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-100">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="font-bold text-gray-900">Offered Services</h3>
                            <span class="text-xs text-indigo-600 bg-indigo-50 px-2 py-1 rounded font-medium">Gigs</span>
                        </div>
                        <div id="so-services-list" class="space-y-3">
                            {{-- Populated by JS --}}
                        </div>
                    </div>
                </div>

                {{-- TAB: WALLET --}}
                <div id="content-wallet" class="tab-content hidden space-y-6">
                    <div class="bg-gradient-to-r from-emerald-500 to-teal-600 rounded-2xl p-6 text-white shadow-lg">
                        <div class="flex justify-between items-start">
                            <div>
                                <p class="text-emerald-100 text-xs font-bold uppercase tracking-wider">Total Balance</p>
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

                    <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-100">
                        <h3 class="font-bold text-gray-900 mb-4">Recent Transactions</h3>
                        <div class="space-y-4">
                            <div class="flex justify-between items-center border-b border-gray-50 pb-3 last:border-0">
                                <div class="flex items-center gap-3">
                                    <div class="h-8 w-8 rounded-full bg-green-100 text-green-600 flex items-center justify-center text-xs">
                                        <i class="fas fa-arrow-down"></i>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-900">Job Completion</p>
                                        <p class="text-xs text-gray-500">Service Fee Earned</p>
                                    </div>
                                </div>
                                <span class="text-sm font-bold text-green-600">+$120.00</span>
                            </div>
                            <div class="flex justify-between items-center border-b border-gray-50 pb-3 last:border-0">
                                <div class="flex items-center gap-3">
                                    <div class="h-8 w-8 rounded-full bg-red-100 text-red-600 flex items-center justify-center text-xs">
                                        <i class="fas fa-arrow-up"></i>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-900">Withdrawal</p>
                                        <p class="text-xs text-gray-500">Bank Transfer</p>
                                    </div>
                                </div>
                                <span class="text-sm font-bold text-gray-900">-$500.00</span>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- TAB: PORTFOLIO --}}
                <div id="content-portfolio" class="tab-content hidden h-full">
                    <div class="flex flex-col items-center justify-center h-64 border-2 border-dashed border-gray-200 rounded-xl bg-gray-50">
                        <div class="h-12 w-12 bg-gray-200 rounded-full flex items-center justify-center text-gray-400 mb-3">
                            <i class="fas fa-images"></i>
                        </div>
                        <p class="text-gray-500 text-sm font-medium">Portfolio Section</p>
                        <p class="text-gray-400 text-xs mt-1">No portfolio items available.</p>
                    </div>
                </div>

                {{-- TAB: PAYMENT METHODS --}}
                <div id="content-payment-methods" class="tab-content hidden space-y-4">
                    <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-100">
                        <h3 class="font-bold text-gray-900 mb-4">Linked Payment Methods</h3>
                        <div id="so-payment-methods-list" class="space-y-3">
                            {{-- Populated by JS --}}
                        </div>
                    </div>
                </div>

                {{-- TAB: DOCUMENTS --}}
                <div id="content-documents" class="tab-content hidden space-y-4">
                     <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                        <div class="flex justify-between items-center mb-6">
                            <h3 class="font-bold text-gray-900">Submitted Compliance Docs</h3>
                            <span class="bg-green-100 text-green-800 text-xs font-bold px-2 py-1 rounded">Verified</span>
                        </div>
                        <div id="so-doc-list" class="space-y-3">
                            {{-- Populated via JS --}}
                        </div>
                        {{-- NEW: KYC Action Buttons inside Documents Tab --}}
                        <div class="mt-8 pt-6 border-t border-gray-100 flex gap-3">
                            <button class="flex-1 px-4 py-2.5 bg-red-50 text-red-700 hover:bg-red-100 border border-red-200 rounded-lg font-medium transition shadow-sm">
                                <i class="fas fa-times-circle mr-2"></i> Reject KYC
                            </button>
                            <button class="flex-1 px-4 py-2.5 bg-green-600 text-white hover:bg-green-700 rounded-lg font-medium transition shadow-md">
                                <i class="fas fa-check-circle mr-2"></i> Approve KYC
                            </button>
                        </div>
                     </div>
                </div>

                {{-- TAB: SUBSCRIPTION --}}
                <div id="content-subscription" class="tab-content hidden space-y-4">
                    <div id="so-subscription-container">
                        {{-- Populated via JS --}}
                    </div>
                </div>
            </div>

            {{-- Footer Actions REMOVED as requested --}}
        </div>
    </div>
</div>

{{-- 5. CREATE MODAL --}}
<div id="create-expert-modal" class="fixed inset-0 z-50 hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-gray-900 bg-opacity-75 transition-opacity backdrop-blur-sm" onclick="closeCreateExpertModal()"></div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        <div class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg w-full">
            <div class="bg-white px-6 py-6 border-b border-gray-100 flex justify-between items-center">
                <h3 class="text-xl font-bold text-gray-900">Add Professional</h3>
                <button onclick="closeCreateExpertModal()" class="text-gray-400 hover:text-gray-600 focus:outline-none"><i class="fas fa-times"></i></button>
            </div>
            
            <form id="createExpertForm" class="p-6 space-y-5">
                @csrf
                <div id="createErrorMessage" class="hidden bg-red-50 text-red-600 p-3 rounded-lg text-sm"></div>
                <div id="createSuccessMessage" class="hidden bg-green-50 text-green-600 p-3 rounded-lg text-sm"></div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Full Name</label>
                    <input type="text" name="name" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm p-2.5 border" placeholder="e.g. Dr. John Doe">
                    <span class="text-xs text-red-500 error-text name_error"></span>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
                    <input type="email" name="email" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm p-2.5 border" placeholder="john@example.com">
                    <span class="text-xs text-red-500 error-text email_error"></span>
                </div>
            </form>

            <div class="p-6 border-t border-gray-100 flex justify-end bg-gray-50">
                <button type="button" onclick="closeCreateExpertModal()" class="mr-3 px-4 py-2 text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition shadow-sm font-medium">Cancel</button>
                <button type="button" id="submitExpertBtn" class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 shadow-md flex items-center transition font-medium">
                    <span id="btnText">Add Professional</span>
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        
        // --- Slide Over Logic ---
        window.openExpertDetails = function(data) {
            document.getElementById('expert-slide-over').classList.remove('hidden');
            document.getElementById('so-panel').classList.remove('translate-x-full');

            // 1. Header
            document.getElementById('so-image').src = data.image;
            document.getElementById('so-name').innerText = data.name;
            document.getElementById('so-email').innerText = data.email;
            document.getElementById('so-status-badge').innerText = data.status;

            // 2. Overview Tab
            document.getElementById('so-category').innerText = data.category;
            document.getElementById('so-rate').innerText = `$${data.rate}/hr`;
            document.getElementById('so-region').innerText = data.region;
            document.getElementById('so-joined').innerText = data.join_date;
            document.getElementById('so-phone').innerText = data.phone;
            
            // Address Fields
            document.getElementById('so-addr-current').innerText = data.address.current;
            document.getElementById('so-addr-perm').innerText = data.address.permanent;
            document.getElementById('so-addr-city').innerText = `${data.address.city}, ${data.address.state}`;

            // 3. Wallet Tab
            document.getElementById('so-wallet-balance').innerText = `$${data.wallet.balance}`;
            document.getElementById('so-wallet-pending').innerText = `$${data.wallet.pending}`;
            document.getElementById('so-wallet-withdrawn').innerText = `$${data.wallet.withdrawn}`;

            // 4. Payment Methods Tab
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
                payMethodList.innerHTML = '<div class="text-center py-4 text-gray-500 italic">No payment methods linked.</div>';
            }

            // 5. Orders Tab
            const ordersList = document.getElementById('so-orders-list');
            if (data.orders && data.orders.length > 0) {
                ordersList.innerHTML = data.orders.map(order => `
                <div class="flex items-center justify-between p-3 border border-gray-200 rounded-lg hover:bg-gray-50 transition">
                    <div class="flex items-center gap-3">
                        <div class="h-10 w-10 bg-blue-100 text-blue-600 rounded-lg flex items-center justify-center text-sm font-bold">
                             <i class="fas fa-briefcase"></i>
                        </div>
                        <div>
                            <p class="text-sm font-bold text-gray-900">${order.task}</p>
                            <p class="text-xs text-gray-500">${order.id} • ${order.client}</p>
                        </div>
                    </div>
                    <div class="text-right">
                        <p class="text-sm font-bold text-gray-900">$${order.amount}</p>
                        <span class="text-[10px] uppercase font-bold px-2 py-0.5 rounded ${order.status === 'Completed' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700'}">${order.status}</span>
                    </div>
                </div>
                `).join('');
            } else {
                ordersList.innerHTML = '<div class="text-center py-4 text-gray-500 italic">No work history available.</div>';
            }

            // 6. Documents Tab
            const docList = document.getElementById('so-doc-list');
            if(data.documents && data.documents.length > 0) {
                docList.innerHTML = data.documents.map(doc => `
                    <div class="flex items-center justify-between p-3 bg-white border border-gray-200 rounded-lg hover:shadow-sm transition">
                        <div class="flex items-center space-x-3">
                            <div class="h-10 w-10 bg-indigo-50 text-indigo-600 rounded-lg flex items-center justify-center text-lg"><i class="fas fa-file-contract"></i></div>
                            <div>
                                <p class="text-sm font-semibold text-gray-800">${doc.name}</p>
                                <span class="text-[10px] text-gray-500 uppercase">${doc.type}</span>
                            </div>
                        </div>
                        <span class="text-xs font-bold text-green-600 bg-green-50 px-2 py-1 rounded">${doc.status}</span>
                    </div>
                `).join('');
            } else {
                docList.innerHTML = '<p class="text-gray-500 italic text-center">No documents found.</p>';
            }

            // 7. Subscription Tab
            const subContainer = document.getElementById('so-subscription-container');
            if (data.subscription && data.subscription.has_plan) {
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
                subContainer.innerHTML = '<div class="p-6 text-center border-dashed border-2 border-gray-300 rounded-xl text-gray-500">No active subscription (Standard Plan)</div>';
            }

            // 8. Services Tab
            const servicesList = document.getElementById('so-services-list');
            if (data.services && data.services.length > 0) {
                servicesList.innerHTML = data.services.map(service => {
                    const statusColor = service.status === 'Active' ? 'text-green-600 bg-green-50' : 'text-gray-500 bg-gray-100';
                    return `
                    <div class="group flex flex-col md:flex-row md:items-center justify-between p-4 border border-gray-200 rounded-xl hover:border-indigo-300 hover:shadow-md transition-all duration-200 bg-white">
                        <div class="flex items-start gap-4">
                            <div class="h-12 w-12 shrink-0 bg-indigo-50 text-indigo-600 rounded-lg flex items-center justify-center text-lg">
                                <i class="fas fa-layer-group"></i>
                            </div>
                            <div>
                                <h4 class="text-sm font-bold text-gray-900 group-hover:text-indigo-600 transition-colors">${service.title}</h4>
                                <div class="flex items-center gap-3 mt-1">
                                    <span class="text-xs text-gray-500"><i class="far fa-clock mr-1"></i> ${service.delivery}</span>
                                    <span class="text-[10px] font-bold uppercase px-2 py-0.5 rounded ${statusColor}">${service.status}</span>
                                </div>
                            </div>
                        </div>
                        <div class="mt-3 md:mt-0 text-right">
                            <p class="text-lg font-bold text-gray-900">$${service.price}</p>
                            <p class="text-xs text-gray-400">Starting at</p>
                        </div>
                    </div>
                    `;
                }).join('');
            } else {
                servicesList.innerHTML = `
                    <div class="text-center py-8">
                        <div class="inline-flex items-center justify-center w-12 h-12 rounded-full bg-gray-100 mb-3">
                            <i class="fas fa-box-open text-gray-400"></i>
                        </div>
                        <p class="text-gray-500 text-sm">No active services found for this professional.</p>
                    </div>`;
            }

            switchTab('overview');
        };

        window.closeExpertDetails = function() {
            document.getElementById('so-panel').classList.add('translate-x-full');
            setTimeout(() => { document.getElementById('expert-slide-over').classList.add('hidden'); }, 300);
        };

        window.switchTab = function(tabName) {
            document.querySelectorAll('.tab-btn').forEach(btn => {
                btn.classList.remove('border-white', 'text-white');
                btn.classList.add('border-transparent', 'text-indigo-300');
            });
            document.querySelectorAll('.tab-content').forEach(content => content.classList.add('hidden'));

            document.getElementById('tab-' + tabName).classList.add('border-white', 'text-white');
            document.getElementById('tab-' + tabName).classList.remove('border-transparent', 'text-indigo-300');
            document.getElementById('content-' + tabName).classList.remove('hidden');
        };

        // --- Filter Logic ---
        const searchInput = document.getElementById('filter-search');
        const categorySelect = document.getElementById('filter-category');
        const regionSelect = document.getElementById('filter-region');
        const kycSelect = document.getElementById('filter-kyc');
        const subSelect = document.getElementById('filter-subscription');
        const resetButton = document.getElementById('reset-filters');
        
        function filterTable() {
            const search = searchInput.value.toLowerCase();
            const cat = categorySelect.value.toLowerCase();
            const reg = regionSelect.value.toLowerCase();
            const kyc = kycSelect.value.toLowerCase();
            const sub = subSelect.value.toLowerCase();
            let count = 0;

            document.querySelectorAll('.expert-row').forEach(row => {
                const name = row.dataset.name;
                const rCat = row.dataset.category;
                const rReg = row.dataset.region;
                const rKyc = row.dataset.kyc;
                const rSub = row.dataset.subscription;

                const matchSearch = name.includes(search);
                const matchCat = cat === '' || rCat === cat;
                const matchReg = reg === '' || rReg === reg;
                const matchKyc = kyc === '' || rKyc === kyc;
                const matchSub = sub === 'all' || rSub === sub;

                if (matchSearch && matchCat && matchReg && matchKyc && matchSub) {
                    row.classList.remove('hidden');
                    count++;
                } else {
                    row.classList.add('hidden');
                }
            });
            document.getElementById('result-count').innerText = `Total: ${count}`;
        }

        [searchInput, categorySelect, regionSelect, kycSelect, subSelect].forEach(el => el.addEventListener('input', filterTable));
        
        resetButton.addEventListener('click', () => {
            document.getElementById('filter-form').reset();
            filterTable();
        });

        // --- Modal & AJAX Logic ---
        window.openCreateExpertModal = function() {
            document.getElementById('createExpertForm').reset();
            document.getElementById('createErrorMessage').classList.add('hidden');
            document.getElementById('createSuccessMessage').classList.add('hidden');
            document.querySelectorAll('.error-text').forEach(el => el.innerText = '');
            document.getElementById('create-expert-modal').classList.remove('hidden');
        };

        window.closeCreateExpertModal = function() {
            document.getElementById('create-expert-modal').classList.add('hidden');
        };

        const submitBtn = document.getElementById('submitExpertBtn');
        const form = document.getElementById('createExpertForm');

        if(submitBtn) {
            submitBtn.addEventListener('click', function(e) {
                e.preventDefault();
                submitBtn.disabled = true;
                
                let formData = new FormData(form);
                axios.post("{{ route('store.professional') }}", formData)
                .then(response => {
                    document.getElementById('createSuccessMessage').classList.remove('hidden');
                    document.getElementById('createSuccessMessage').innerText = "Expert added successfully!";
                    setTimeout(() => { location.reload(); }, 1000);
                })
                .catch(error => {
                    submitBtn.disabled = false;
                    document.getElementById('createErrorMessage').classList.remove('hidden');
                    if (error.response && error.response.data && error.response.data.errors) {
                         let errors = error.response.data.errors;
                         for (const [key, value] of Object.entries(errors)) {
                             let errorSpan = document.querySelector(`.${key}_error`);
                             if (errorSpan) errorSpan.innerText = value[0];
                         }
                    } else {
                        document.getElementById('createErrorMessage').innerText = "Error creating expert. Please try again.";
                    }
                });
            });
        }
    });
</script>
@endpush