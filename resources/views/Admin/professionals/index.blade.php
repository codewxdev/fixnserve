@extends('layouts.app')

@section('content')
<div class="min-h-screen theme-bg-body theme-text-main p-6 space-y-8">
    
    {{-- 1. HEADER --}}
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold theme-text-main tracking-tight">Expert Management</h1>
            <p class="text-sm theme-text-muted">Manage professionals, validations, performance, and KYC.</p>
        </div>
        <button onclick="openCreateExpertModal()" 
            class="inline-flex items-center justify-center px-4 py-2 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:opacity-90 focus:outline-none transition shadow-lg"
            style="background-color: rgb(var(--brand-primary)); box-shadow: 0 4px 10px rgba(var(--brand-primary), 0.3);">
            <i class="fas fa-plus mr-2"></i> Add Professional
        </button>
    </div>

    {{-- 2. STATS CARDS --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        
        {{-- Card 1: Total Experts --}}
        <div class="relative theme-bg-card p-6 rounded-2xl shadow-sm border theme-border overflow-hidden group hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
            <div class="absolute top-0 right-0 -mt-4 -mr-4 w-24 h-24 rounded-full bg-indigo-500/10 group-hover:bg-indigo-500/20 transition-colors duration-300"></div>
            <div class="relative flex justify-between items-start z-10">
                <div>
                    <p class="text-xs font-bold theme-text-muted uppercase tracking-wider">Total Experts</p>
                    <h3 class="text-3xl font-extrabold theme-text-main mt-2 group-hover:text-indigo-500 transition-colors">{{ $professionals->count() }}</h3>
                </div>
                <div class="p-3 bg-indigo-500/10 text-indigo-500 rounded-xl shadow-inner group-hover:scale-110 transition-transform duration-300">
                    <i class="fas fa-user-tie text-xl"></i>
                </div>
            </div>
            <div class="mt-4 flex items-center text-xs theme-text-muted">
                <span class="text-indigo-500 font-bold bg-indigo-500/10 px-1.5 py-0.5 rounded mr-2 border border-indigo-500/20"><i class="fas fa-arrow-up"></i> New</span>
                <span>Registrations</span>
            </div>
            <div class="absolute bottom-0 left-0 w-full h-1 bg-gradient-to-r from-indigo-400 to-purple-500 transform scale-x-0 group-hover:scale-x-100 transition-transform duration-500 origin-left"></div>
        </div>

        {{-- Card 2: Active --}}
        <div class="relative theme-bg-card p-6 rounded-2xl shadow-sm border theme-border overflow-hidden group hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
            <div class="absolute top-0 right-0 -mt-4 -mr-4 w-24 h-24 rounded-full bg-emerald-500/10 group-hover:bg-emerald-500/20 transition-colors duration-300"></div>
            <div class="relative flex justify-between items-start z-10">
                <div>
                    <p class="text-xs font-bold theme-text-muted uppercase tracking-wider">Active Now</p>
                    <h3 class="text-3xl font-extrabold theme-text-main mt-2 group-hover:text-emerald-500 transition-colors">{{ $professionals->where('status', 'active')->count() }}</h3>
                </div>
                <div class="p-3 bg-emerald-500/10 text-emerald-500 rounded-xl shadow-inner group-hover:scale-110 transition-transform duration-300">
                    <i class="fas fa-check-circle text-xl"></i>
                </div>
            </div>
            <div class="mt-4 flex items-center text-xs theme-text-muted">
                <span class="text-emerald-500 font-bold bg-emerald-500/10 px-1.5 py-0.5 rounded mr-2 border border-emerald-500/20"><i class="fas fa-wifi"></i> Online</span>
                <span>Ready for work</span>
            </div>
            <div class="absolute bottom-0 left-0 w-full h-1 bg-gradient-to-r from-emerald-400 to-teal-500 transform scale-x-0 group-hover:scale-x-100 transition-transform duration-500 origin-left"></div>
        </div>

        {{-- Card 3: Suspended --}}
        <div class="relative theme-bg-card p-6 rounded-2xl shadow-sm border theme-border overflow-hidden group hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
            <div class="absolute top-0 right-0 -mt-4 -mr-4 w-24 h-24 rounded-full bg-rose-500/10 group-hover:bg-rose-500/20 transition-colors duration-300"></div>
            <div class="relative flex justify-between items-start z-10">
                <div>
                    <p class="text-xs font-bold theme-text-muted uppercase tracking-wider">Suspended</p>
                    <h3 class="text-3xl font-extrabold theme-text-main mt-2 group-hover:text-rose-500 transition-colors">{{ $professionals->where('status', 'suspend')->count() }}</h3>
                </div>
                <div class="p-3 bg-rose-500/10 text-rose-500 rounded-xl shadow-inner group-hover:scale-110 transition-transform duration-300">
                    <i class="fas fa-ban text-xl"></i>
                </div>
            </div>
            <div class="mt-4 flex items-center text-xs theme-text-muted">
                <span class="text-rose-500 font-bold bg-rose-500/10 px-1.5 py-0.5 rounded mr-2 border border-rose-500/20"><i class="fas fa-exclamation-circle"></i> Flagged</span>
                <span>Accounts</span>
            </div>
            <div class="absolute bottom-0 left-0 w-full h-1 bg-gradient-to-r from-rose-400 to-red-500 transform scale-x-0 group-hover:scale-x-100 transition-transform duration-500 origin-left"></div>
        </div>

        {{-- Card 4: Pending KYC --}}
        <div class="relative theme-bg-card p-6 rounded-2xl shadow-sm border theme-border overflow-hidden group hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
            <div class="absolute top-0 right-0 -mt-4 -mr-4 w-24 h-24 rounded-full bg-amber-500/10 group-hover:bg-amber-500/20 transition-colors duration-300"></div>
            <div class="relative flex justify-between items-start z-10">
                <div>
                    <p class="text-xs font-bold theme-text-muted uppercase tracking-wider">Pending KYC</p>
                    <h3 class="text-3xl font-extrabold theme-text-main mt-2 group-hover:text-amber-500 transition-colors">{{ $professionals->where('kyc_status', 'pending')->count() }}</h3>
                </div>
                <div class="p-3 bg-amber-500/10 text-amber-500 rounded-xl shadow-inner group-hover:scale-110 transition-transform duration-300">
                    <i class="fas fa-file-contract text-xl"></i>
                </div>
            </div>
            <div class="mt-4 flex items-center text-xs theme-text-muted">
                <span class="text-amber-500 font-bold bg-amber-500/10 px-1.5 py-0.5 rounded mr-2 border border-amber-500/20"><i class="fas fa-clock"></i> Queue</span>
                <span>Needs Verification</span>
            </div>
            <div class="absolute bottom-0 left-0 w-full h-1 bg-gradient-to-r from-amber-400 to-orange-500 transform scale-x-0 group-hover:scale-x-100 transition-transform duration-500 origin-left"></div>
        </div>

    </div>

    {{-- 3. MAIN CONTENT (Filter & Table) --}}
    <div class="theme-bg-card border theme-border rounded-xl shadow-sm overflow-hidden">
        {{-- Filter Bar --}}
        <form id="filter-form" class="p-4 border-b theme-border flex flex-wrap gap-4 items-center justify-between" style="background-color: rgba(var(--bg-body), 0.5);">
            {{-- Search --}}
            <div class="relative flex-1 max-w-md min-w-[200px]">
                <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 theme-text-muted"></i>
                <input type="text" id="filter-search" placeholder="Search by name, ID, email..." class="w-full pl-10 pr-4 py-2 text-sm theme-bg-body theme-border border rounded-lg focus:ring-2 focus:ring-blue-500 theme-text-main placeholder-gray-500">
            </div>

            {{-- Dropdowns --}}
            <div class="flex flex-wrap gap-2">
                <select id="filter-category" class="text-sm theme-bg-body border theme-border theme-text-main rounded-lg focus:ring-2 focus:ring-blue-500">
                    <option value="">All Categories</option>
                    <option value="legal">Legal</option>
                    <option value="finance">Finance</option>
                    <option value="architecture">Architecture</option>
                    <option value="technology">Technology</option>
                </select>
                <select id="filter-region" class="text-sm theme-bg-body border theme-border theme-text-main rounded-lg focus:ring-2 focus:ring-blue-500">
                    <option value="">All Regions</option>
                    <option value="north america">North America</option>
                    <option value="europe">Europe</option>
                    <option value="asia">Asia</option>
                </select>
                <select id="filter-subscription" class="text-sm theme-bg-body border theme-border theme-text-main rounded-lg focus:ring-2 focus:ring-blue-500">
                    <option value="all">All Plans</option>
                    <option value="subscribed">Premium</option>
                    <option value="free">Standard</option>
                </select>
                <select id="filter-kyc" class="text-sm theme-bg-body border theme-border theme-text-main rounded-lg focus:ring-2 focus:ring-blue-500">
                    <option value="">KYC Status</option>
                    <option value="verified">Verified</option>
                    <option value="pending">Pending</option>
                    <option value="rejected">Rejected</option>
                </select>
            </div>
            
            {{-- Reset & Count --}}
            <div class="flex items-center gap-3">
                <span id="result-count" class="text-xs font-semibold theme-text-muted uppercase hidden md:inline-block">Total: {{ $professionals->count() }}</span>
                <button type="button" id="reset-filters" class="text-xs font-medium px-2" style="color: rgb(var(--brand-primary));">Reset</button>
            </div>
        </form>

        {{-- Table --}}
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y theme-border" style="border-color: rgb(var(--border-color));">
                <thead class="theme-bg-body">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium theme-text-muted uppercase tracking-wider">Expert Profile</th>
                        <th class="px-6 py-3 text-left text-xs font-medium theme-text-muted uppercase tracking-wider">Category & Rate</th>
                        <th class="px-6 py-3 text-center text-xs font-medium theme-text-muted uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-right text-xs font-medium theme-text-muted uppercase tracking-wider">Performance</th>
                        <th class="px-6 py-3 text-right text-xs font-medium theme-text-muted uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="theme-bg-card divide-y theme-border" id="experts-table-body" style="border-color: rgb(var(--border-color));">
                    @forelse ($professionals as $expert)
                        @php
                            $hasSub = ($expert->id % 2 != 0); 
                            $planName = $hasSub ? 'Diamond Expert' : 'Standard';
                            $subStatus = $hasSub ? 'subscribed' : 'free';
                            $category = $expert->specialization ?? 'General';
                            $rate = $expert->hourly_rate ?? 0;
                            
                            $statusClasses = match($expert->status) {
                                'active' => 'bg-green-500/10 text-green-500 border border-green-500/20',
                                'busy' => 'bg-yellow-500/10 text-yellow-500 border border-yellow-500/20',
                                'offline' => 'bg-gray-500/10 text-gray-500 border border-gray-500/20',
                                'suspend' => 'bg-red-500/10 text-red-500 border border-red-500/20',
                                default => 'bg-gray-500/10 text-gray-500 border border-gray-500/20'
                            };
                            
                            $image = $expert->image ? asset($expert->image) : 'https://ui-avatars.com/api/?name='.urlencode($expert->name).'&background=0D8ABC&color=fff';
                            
                            // JS Data Payload
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
                                ],
                                'payment_methods' => ['Visa **** 4242', 'Payoneer ID-445'],
                                'documents' => [
                                    ['name' => 'Govt ID Front', 'type' => 'PDF', 'status' => 'Approved'],
                                ],
                                'subscription' => [
                                    'has_plan' => $hasSub,
                                    'plan_name' => $planName,
                                    'expires_at' => now()->addDays(30)->format('M d, Y'),
                                    'progress' => 80
                                ],
                                'services' => [
                                    [
                                        'title' => 'Full Website Audit',
                                        'price' => rand(100, 300),
                                        'delivery' => '2 Days',
                                        'status' => 'Active'
                                    ],
                                ]
                            ];
                        @endphp
                        
                        <tr class="expert-row hover:bg-white/5 transition duration-150 group" 
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
                                        <img class="h-10 w-10 rounded-full object-cover border theme-border" src="{{ $image }}">
                                        @if ($hasSub)
                                            <div class="absolute -top-1 -right-1 text-white p-0.5 rounded-full border border-white" style="background-color: rgb(var(--brand-primary));" title="Diamond Expert">
                                                <i class="fas fa-gem text-[8px]"></i>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium theme-text-main">{{ $expert->name }}</div>
                                        <div class="text-xs theme-text-muted">{{ $expert->email }}</div>
                                    </div>
                                </div>
                            </td>

                            {{-- Category/Rate --}}
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full theme-bg-body theme-text-muted border theme-border">{{ $category }}</span>
                                <div class="text-xs theme-text-muted mt-1 font-medium">${{ $rate }}/hr</div>
                            </td>

                            {{-- Status --}}
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $statusClasses }}">{{ ucfirst($expert->status) }}</span>
                            </td>

                            {{-- Performance --}}
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium theme-text-main">
                                4.9 <span class="text-yellow-400 text-xs"><i class="fas fa-star"></i></span>
                            </td>

                            {{-- Actions --}}
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <div class="flex justify-end items-center gap-2">
                                    <button onclick="openExpertDetails({{ json_encode($jsData) }})" 
                                        class="p-2 rounded transition hover:opacity-80 text-white"
                                        style="background-color: rgba(var(--brand-primary), 0.1); color: rgb(var(--brand-primary));"
                                        title="View Details">
                                        View Details
                                    </button>
                                    <div class="relative" x-data="{ open: false }">
                                        <button @click="open = !open" @click.away="open = false" class="theme-text-muted hover:text-white p-2 rounded-full hover:bg-white/10">
                                            <i class="fas fa-ellipsis-v"></i>
                                        </button>
                                        <div x-show="open" class="absolute right-0 mt-2 w-48 theme-bg-card border theme-border rounded-md shadow-lg py-1 z-50" style="display: none;">
                                            <a href="#" class="block px-4 py-2 text-sm text-red-500 hover:bg-white/5"><i class="fas fa-ban mr-2"></i> Suspend Account</a>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="px-6 py-10 text-center theme-text-muted">No professionals found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-4 border-t theme-border theme-bg-body">
            @if ($professionals instanceof \Illuminate\Pagination\LengthAwarePaginator) {{ $professionals->links() }} @endif
        </div>
    </div>
</div>

{{-- 4. UNIFIED SLIDE-OVER --}}
<div id="expert-slide-over" class="fixed inset-0 overflow-hidden z-50 hidden">
    <div class="absolute inset-0 bg-black/80 transition-opacity backdrop-blur-sm" onclick="closeExpertDetails()"></div>
    <div class="fixed inset-y-0 right-0 max-w-2xl w-full flex pointer-events-none">
        <div class="w-full h-full theme-bg-card shadow-2xl pointer-events-auto flex flex-col transform transition-transform duration-300 translate-x-full" id="so-panel">
            
            {{-- Slide Header --}}
            <div class="theme-bg-card px-6 py-6 border-b theme-border shrink-0">
                <div class="flex justify-between items-start">
                    <div class="flex items-center space-x-4">
                        <img id="so-image" src="" class="h-16 w-16 rounded-full border-2 border-white/50 object-cover">
                        <div>
                            <h2 class="text-xl font-bold theme-text-main" id="so-name"></h2>
                            <p class="theme-text-muted text-sm flex items-center gap-2">
                                <span id="so-email"></span>
                                <span class="w-1 h-1 bg-gray-500 rounded-full"></span>
                                <span id="so-status-badge" class="uppercase text-xs font-bold theme-bg-body px-2 py-0.5 rounded border theme-border"></span>
                            </p>
                        </div>
                    </div>
                    <button onclick="closeExpertDetails()" class="theme-text-muted hover:text-white transition"><i class="fas fa-times text-xl"></i></button>
                </div>
                {{-- Tabs --}}
                <div class="flex space-x-6 mt-8 text-sm font-medium overflow-x-auto scrollbar-hide border-b theme-border">
                    <button onclick="switchTab('overview')" class="tab-btn border-b-2 font-bold pb-3 theme-text-main transition whitespace-nowrap" style="border-color: rgb(var(--brand-primary));" id="tab-overview">Overview</button>
                    <button onclick="switchTab('orders')" class="tab-btn border-b-2 border-transparent pb-3 theme-text-muted hover:text-white transition whitespace-nowrap" id="tab-orders">Orders</button>
                    <button onclick="switchTab('services')" class="tab-btn border-b-2 border-transparent pb-3 theme-text-muted hover:text-white transition whitespace-nowrap" id="tab-services">Services</button>
                    <button onclick="switchTab('wallet')" class="tab-btn border-b-2 border-transparent pb-3 theme-text-muted hover:text-white transition whitespace-nowrap" id="tab-wallet">Wallet</button>
                    <button onclick="switchTab('portfolio')" class="tab-btn border-b-2 border-transparent pb-3 theme-text-muted hover:text-white transition whitespace-nowrap" id="tab-portfolio">Portfolio</button>
                    <button onclick="switchTab('payment-methods')" class="tab-btn border-b-2 border-transparent pb-3 theme-text-muted hover:text-white transition whitespace-nowrap" id="tab-payment-methods">Payment Methods</button>
                    <button onclick="switchTab('documents')" class="tab-btn border-b-2 border-transparent pb-3 theme-text-muted hover:text-white transition whitespace-nowrap" id="tab-documents">Kyc Documents</button>
                    <button onclick="switchTab('subscription')" class="tab-btn border-b-2 border-transparent pb-3 theme-text-muted hover:text-white transition whitespace-nowrap" id="tab-subscription">Subscription</button>
                </div>
            </div>

            {{-- Slide Content --}}
            <div class="flex-1 overflow-y-auto p-6 theme-bg-body scroll-smooth">
                
                {{-- TAB: OVERVIEW --}}
                <div id="content-overview" class="tab-content space-y-6">
                    {{-- Basic Info --}}
                    <div class="theme-bg-card p-5 rounded-xl shadow-sm border theme-border">
                        <h3 class="font-bold theme-text-main mb-4 flex items-center"><i class="fas fa-id-card mr-2" style="color: rgb(var(--brand-primary));"></i> Professional Details</h3>
                        <div class="grid grid-cols-2 gap-y-4 gap-x-6 text-sm">
                            <div><p class="theme-text-muted text-xs uppercase">Category</p><p class="font-medium theme-text-main" id="so-category"></p></div>
                            <div><p class="theme-text-muted text-xs uppercase">Hourly Rate</p><p class="font-medium text-green-500" id="so-rate"></p></div>
                            <div><p class="theme-text-muted text-xs uppercase">Location</p><p class="font-medium theme-text-main" id="so-region"></p></div>
                            <div><p class="theme-text-muted text-xs uppercase">Joined</p><p class="font-medium theme-text-main" id="so-joined"></p></div>
                        </div>
                        <div class="mt-4 pt-4 border-t theme-border">
                            <p class="theme-text-muted text-xs uppercase mb-1">Contact</p>
                            <p class="theme-text-main font-medium text-sm" id="so-phone"></p>
                        </div>
                    </div>

                    {{-- Address Section --}}
                    <div class="theme-bg-card p-5 rounded-xl shadow-sm border theme-border">
                        <h3 class="font-bold theme-text-main mb-4 flex items-center"><i class="fas fa-map-marker-alt mr-2" style="color: rgb(var(--brand-primary));"></i> Address Details</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                            <div class="col-span-2">
                                <p class="text-xs theme-text-muted uppercase">Current Address</p>
                                <p class="font-medium theme-text-main mt-1" id="so-addr-current"></p>
                            </div>
                            <div class="col-span-2">
                                <p class="text-xs theme-text-muted uppercase">Permanent Address</p>
                                <p class="font-medium theme-text-main mt-1" id="so-addr-perm"></p>
                            </div>
                            <div>
                                <p class="text-xs theme-text-muted uppercase">City / State</p>
                                <p class="font-medium theme-text-main mt-1" id="so-addr-city"></p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- TAB: ORDERS --}}
                <div id="content-orders" class="tab-content hidden space-y-4">
                    <div class="theme-bg-card p-5 rounded-xl shadow-sm border theme-border">
                        <h3 class="font-bold theme-text-main mb-4">Order History</h3>
                        <div id="so-orders-list" class="space-y-3">
                            {{-- Populated by JS --}}
                        </div>
                    </div>
                </div>

                {{-- TAB: SERVICES --}}
                <div id="content-services" class="tab-content hidden space-y-4">
                    <div class="theme-bg-card p-5 rounded-xl shadow-sm border theme-border">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="font-bold theme-text-main">Offered Services</h3>
                            <span class="text-xs px-2 py-1 rounded font-medium theme-bg-body border theme-border theme-text-main">Gigs</span>
                        </div>
                        <div id="so-services-list" class="space-y-3">
                            {{-- Populated by JS --}}
                        </div>
                    </div>
                </div>

                {{-- TAB: WALLET --}}
                <div id="content-wallet" class="tab-content hidden space-y-6">
                    <div class="rounded-2xl p-6 text-white shadow-lg" style="background: linear-gradient(135deg, rgb(var(--brand-primary)), rgb(var(--brand-secondary)));">
                        <div class="flex justify-between items-start">
                            <div>
                                <p class="text-white/80 text-xs font-bold uppercase tracking-wider">Total Balance</p>
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

                    <div class="theme-bg-card p-5 rounded-xl shadow-sm border theme-border">
                        <h3 class="font-bold theme-text-main mb-4">Recent Transactions</h3>
                        <div class="space-y-4">
                            <div class="flex justify-between items-center border-b theme-border pb-3 last:border-0">
                                <div class="flex items-center gap-3">
                                    <div class="h-8 w-8 rounded-full bg-green-500/10 text-green-500 flex items-center justify-center text-xs">
                                        <i class="fas fa-arrow-down"></i>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium theme-text-main">Job Completion</p>
                                        <p class="text-xs theme-text-muted">Service Fee Earned</p>
                                    </div>
                                </div>
                                <span class="text-sm font-bold text-green-500">+$120.00</span>
                            </div>
                            <div class="flex justify-between items-center border-b theme-border pb-3 last:border-0">
                                <div class="flex items-center gap-3">
                                    <div class="h-8 w-8 rounded-full bg-red-500/10 text-red-500 flex items-center justify-center text-xs">
                                        <i class="fas fa-arrow-up"></i>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium theme-text-main">Withdrawal</p>
                                        <p class="text-xs theme-text-muted">Bank Transfer</p>
                                    </div>
                                </div>
                                <span class="text-sm font-bold theme-text-main">-$500.00</span>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- TAB: PORTFOLIO --}}
                <div id="content-portfolio" class="tab-content hidden h-full">
                    <div class="flex flex-col items-center justify-center h-64 border-2 border-dashed theme-border rounded-xl theme-bg-card">
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
                        <div id="so-payment-methods-list" class="space-y-3">
                            {{-- Populated by JS --}}
                        </div>
                    </div>
                </div>

                {{-- TAB: DOCUMENTS --}}
                <div id="content-documents" class="tab-content hidden space-y-4">
                     <div class="theme-bg-card p-6 rounded-xl shadow-sm border theme-border">
                        <div class="flex justify-between items-center mb-6">
                            <h3 class="font-bold theme-text-main">Submitted Compliance Docs</h3>
                            <span class="bg-green-500/10 text-green-500 text-xs font-bold px-2 py-1 rounded border border-green-500/20">Verified</span>
                        </div>
                        <div id="so-doc-list" class="space-y-3">
                            {{-- Populated via JS --}}
                        </div>
                        {{-- KYC Action Buttons --}}
                        <div class="mt-8 pt-6 border-t theme-border flex gap-3">
                            <button class="flex-1 px-4 py-2.5 bg-red-500/10 text-red-500 hover:bg-red-500/20 border border-red-500/20 rounded-lg font-medium transition shadow-sm">
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
        </div>
    </div>
</div>

{{-- 5. CREATE MODAL --}}
<div id="create-expert-modal" class="fixed inset-0 z-50 hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-black/80 transition-opacity backdrop-blur-sm" onclick="closeCreateExpertModal()"></div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        <div class="inline-block align-bottom theme-bg-card border theme-border rounded-2xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg w-full">
            <div class="px-6 py-6 border-b theme-border flex justify-between items-center">
                <h3 class="text-xl font-bold theme-text-main">Add Professional</h3>
                <button onclick="closeCreateExpertModal()" class="theme-text-muted hover:text-white focus:outline-none"><i class="fas fa-times"></i></button>
            </div>
            
            <form id="createExpertForm" class="p-6 space-y-5">
                @csrf
                <div id="createErrorMessage" class="hidden bg-red-500/10 text-red-500 p-3 rounded-lg text-sm border border-red-500/20"></div>
                <div id="createSuccessMessage" class="hidden bg-green-500/10 text-green-500 p-3 rounded-lg text-sm border border-green-500/20"></div>

                <div>
                    <label class="block text-sm font-medium theme-text-muted mb-1">Full Name</label>
                    <input type="text" name="name" class="w-full theme-bg-body border theme-border rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 sm:text-sm p-2.5 theme-text-main" placeholder="e.g. Dr. John Doe">
                    <span class="text-xs text-red-500 error-text name_error"></span>
                </div>

                <div>
                    <label class="block text-sm font-medium theme-text-muted mb-1">Email Address</label>
                    <input type="email" name="email" class="w-full theme-bg-body border theme-border rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 sm:text-sm p-2.5 theme-text-main" placeholder="john@example.com">
                    <span class="text-xs text-red-500 error-text email_error"></span>
                </div>
            </form>

            <div class="p-6 border-t theme-border flex justify-end theme-bg-body">
                <button type="button" onclick="closeCreateExpertModal()" class="mr-3 px-4 py-2 theme-text-muted theme-bg-card border theme-border rounded-lg hover:bg-white/5 transition shadow-sm font-medium">Cancel</button>
                <button type="button" id="submitExpertBtn" class="px-4 py-2 text-white rounded-lg shadow-md flex items-center transition font-medium hover:opacity-90"
                    style="background-color: rgb(var(--brand-primary));">
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

            // 5. Orders Tab
            const ordersList = document.getElementById('so-orders-list');
            if (data.orders && data.orders.length > 0) {
                ordersList.innerHTML = data.orders.map(order => `
                <div class="flex items-center justify-between p-3 border theme-border rounded-lg hover:bg-white/5 transition">
                    <div class="flex items-center gap-3">
                        <div class="h-10 w-10 bg-blue-500/10 text-blue-500 rounded-lg flex items-center justify-center text-sm font-bold">
                             <i class="fas fa-briefcase"></i>
                        </div>
                        <div>
                            <p class="text-sm font-bold theme-text-main">${order.task}</p>
                            <p class="text-xs theme-text-muted">${order.id} • ${order.client}</p>
                        </div>
                    </div>
                    <div class="text-right">
                        <p class="text-sm font-bold theme-text-main">$${order.amount}</p>
                        <span class="text-[10px] uppercase font-bold px-2 py-0.5 rounded ${order.status === 'Completed' ? 'bg-green-500/10 text-green-500' : 'bg-yellow-500/10 text-yellow-500'}">${order.status}</span>
                    </div>
                </div>
                `).join('');
            } else {
                ordersList.innerHTML = '<div class="text-center py-4 theme-text-muted italic">No work history available.</div>';
            }

            // 6. Documents Tab
            const docList = document.getElementById('so-doc-list');
            if(data.documents && data.documents.length > 0) {
                docList.innerHTML = data.documents.map(doc => `
                    <div class="flex items-center justify-between p-3 theme-bg-card border theme-border rounded-lg hover:shadow-sm transition">
                        <div class="flex items-center space-x-3">
                            <div class="h-10 w-10 bg-indigo-500/10 text-indigo-500 rounded-lg flex items-center justify-center text-lg"><i class="fas fa-file-contract"></i></div>
                            <div>
                                <p class="text-sm font-semibold theme-text-main">${doc.name}</p>
                                <span class="text-[10px] theme-text-muted uppercase">${doc.type}</span>
                            </div>
                        </div>
                        <span class="text-xs font-bold text-green-500 bg-green-500/10 px-2 py-1 rounded">${doc.status}</span>
                    </div>
                `).join('');
            } else {
                docList.innerHTML = '<p class="theme-text-muted italic text-center">No documents found.</p>';
            }

            // 7. Subscription Tab
            const subContainer = document.getElementById('so-subscription-container');
            if (data.subscription && data.subscription.has_plan) {
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
                subContainer.innerHTML = '<div class="p-6 text-center border-dashed border-2 theme-border rounded-xl theme-text-muted">No active subscription (Standard Plan)</div>';
            }

            // 8. Services Tab
            const servicesList = document.getElementById('so-services-list');
            if (data.services && data.services.length > 0) {
                servicesList.innerHTML = data.services.map(service => {
                    const statusColor = service.status === 'Active' ? 'text-green-500 bg-green-500/10' : 'theme-text-muted theme-bg-body';
                    return `
                    <div class="group flex flex-col md:flex-row md:items-center justify-between p-4 border theme-border rounded-xl hover:border-indigo-300 hover:shadow-md transition-all duration-200 theme-bg-card">
                        <div class="flex items-start gap-4">
                            <div class="h-12 w-12 shrink-0 bg-indigo-500/10 text-indigo-500 rounded-lg flex items-center justify-center text-lg">
                                <i class="fas fa-layer-group"></i>
                            </div>
                            <div>
                                <h4 class="text-sm font-bold theme-text-main group-hover:text-indigo-500 transition-colors">${service.title}</h4>
                                <div class="flex items-center gap-3 mt-1">
                                    <span class="text-xs theme-text-muted"><i class="far fa-clock mr-1"></i> ${service.delivery}</span>
                                    <span class="text-[10px] font-bold uppercase px-2 py-0.5 rounded ${statusColor}">${service.status}</span>
                                </div>
                            </div>
                        </div>
                        <div class="mt-3 md:mt-0 text-right">
                            <p class="text-lg font-bold theme-text-main">$${service.price}</p>
                            <p class="text-xs theme-text-muted">Starting at</p>
                        </div>
                    </div>
                    `;
                }).join('');
            } else {
                servicesList.innerHTML = `
                    <div class="text-center py-8">
                        <div class="inline-flex items-center justify-center w-12 h-12 rounded-full theme-bg-body mb-3">
                            <i class="fas fa-box-open theme-text-muted"></i>
                        </div>
                        <p class="theme-text-muted text-sm">No active services found for this professional.</p>
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
                btn.classList.remove('border-white', 'text-white'); // Removed hardcoded text-white
                btn.classList.add('border-transparent', 'theme-text-muted');
                btn.style.borderColor = 'transparent'; // Reset Inline
                btn.style.color = ''; // Reset Inline
            });
            document.querySelectorAll('.tab-content').forEach(content => content.classList.add('hidden'));

            const activeBtn = document.getElementById('tab-' + tabName);
            activeBtn.classList.remove('border-transparent', 'theme-text-muted');
            // Using inline styling to apply brand variable color
            activeBtn.style.borderColor = 'rgb(var(--brand-primary))';
            activeBtn.style.color = 'rgb(var(--brand-primary))';
            
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