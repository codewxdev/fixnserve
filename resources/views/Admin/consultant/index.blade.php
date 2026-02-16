@extends('layouts.app')

@section('head')
{{-- Font Awesome CDN Link --}}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
    integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
@endsection

@section('content')
<div class="min-h-screen theme-bg-body theme-text-main p-6 space-y-8">
    
    {{-- 1. HEADER --}}
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold theme-text-main tracking-tight">Consultant Management</h1>
            <p class="text-sm theme-text-muted">Manage expert consultants, schedules, sessions, and recordings.</p>
        </div>
        <button onclick="openAddModal()" 
            class="inline-flex items-center justify-center px-4 py-2 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:opacity-90 focus:outline-none transition shadow-lg"
            style="background-color: rgb(var(--brand-primary)); box-shadow: 0 4px 10px rgba(var(--brand-primary), 0.3);">
            <i class="fa-solid fa-user-plus mr-2"></i> Add Consultant
        </button>
    </div>

    {{-- 2. ANALYTICS GRID --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        {{-- Card 1 --}}
        <div class="relative theme-bg-card p-6 rounded-2xl shadow-sm border theme-border overflow-hidden group hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
            <div class="absolute top-0 right-0 -mt-4 -mr-4 w-24 h-24 rounded-full bg-indigo-500/10 group-hover:bg-indigo-500/20 transition-colors duration-300"></div>
            <div class="relative flex justify-between items-start z-10">
                <div>
                    <p class="text-xs font-bold theme-text-muted uppercase tracking-wider">Total Consultants</p>
                    <h3 class="text-3xl font-extrabold theme-text-main mt-2 group-hover:text-indigo-500 transition-colors">{{ $consultants->count() }}</h3>
                </div>
                <div class="p-3 bg-indigo-500/10 text-indigo-500 rounded-xl shadow-inner group-hover:scale-110 transition-transform duration-300">
                    <i class="fa-solid fa-users text-xl"></i>
                </div>
            </div>
            <div class="mt-4 flex items-center text-xs theme-text-muted">
                <span class="text-indigo-500 font-bold bg-indigo-500/10 px-1.5 py-0.5 rounded mr-2 border border-indigo-500/20"><i class="fa-solid fa-arrow-up"></i> New</span>
                <span>Onboarded this month</span>
            </div>
            <div class="absolute bottom-0 left-0 w-full h-1 bg-gradient-to-r from-indigo-400 to-purple-500 transform scale-x-0 group-hover:scale-x-100 transition-transform duration-500 origin-left"></div>
        </div>

        {{-- Card 2 --}}
        <div class="relative theme-bg-card p-6 rounded-2xl shadow-sm border theme-border overflow-hidden group hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
            <div class="absolute top-0 right-0 -mt-4 -mr-4 w-24 h-24 rounded-full bg-emerald-500/10 group-hover:bg-emerald-500/20 transition-colors duration-300"></div>
            <div class="relative flex justify-between items-start z-10">
                <div>
                    <p class="text-xs font-bold theme-text-muted uppercase tracking-wider">Active Now</p>
                    <h3 class="text-3xl font-extrabold theme-text-main mt-2 group-hover:text-emerald-500 transition-colors">NaN</h3>
                </div>
                <div class="p-3 bg-emerald-500/10 text-emerald-500 rounded-xl shadow-inner group-hover:scale-110 transition-transform duration-300">
                    <i class="fa-solid fa-user-check text-xl"></i>
                </div>
            </div>
            <div class="mt-4 flex items-center text-xs theme-text-muted">
                <span class="text-emerald-500 font-bold bg-emerald-500/10 px-1.5 py-0.5 rounded mr-2 border border-emerald-500/20"><i class="fa-solid fa-signal"></i> Live</span>
                <span>Available for calls</span>
            </div>
            <div class="absolute bottom-0 left-0 w-full h-1 bg-gradient-to-r from-emerald-400 to-teal-500 transform scale-x-0 group-hover:scale-x-100 transition-transform duration-500 origin-left"></div>
        </div>

        {{-- Card 3 --}}
        <div class="relative theme-bg-card p-6 rounded-2xl shadow-sm border theme-border overflow-hidden group hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
            <div class="absolute top-0 right-0 -mt-4 -mr-4 w-24 h-24 rounded-full bg-blue-500/10 group-hover:bg-blue-500/20 transition-colors duration-300"></div>
            <div class="relative flex justify-between items-start z-10">
                <div>
                    <p class="text-xs font-bold theme-text-muted uppercase tracking-wider">Today's Sessions</p>
                    <h3 class="text-3xl font-extrabold theme-text-main mt-2 group-hover:text-blue-500 transition-colors">NaN</h3>
                </div>
                <div class="p-3 bg-blue-500/10 text-blue-500 rounded-xl shadow-inner group-hover:scale-110 transition-transform duration-300">
                    <i class="fa-solid fa-calendar-check text-xl"></i>
                </div>
            </div>
            <div class="mt-4 flex items-center text-xs theme-text-muted">
                <span class="text-blue-500 font-bold bg-blue-500/10 px-1.5 py-0.5 rounded mr-2 border border-blue-500/20"><i class="fa-solid fa-clock"></i> Upcoming</span>
                <span>Scheduled Today</span>
            </div>
            <div class="absolute bottom-0 left-0 w-full h-1 bg-gradient-to-r from-blue-400 to-cyan-500 transform scale-x-0 group-hover:scale-x-100 transition-transform duration-500 origin-left"></div>
        </div>

        {{-- Card 4 --}}
        <div class="relative theme-bg-card p-6 rounded-2xl shadow-sm border theme-border overflow-hidden group hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
            <div class="absolute top-0 right-0 -mt-4 -mr-4 w-24 h-24 rounded-full bg-amber-500/10 group-hover:bg-amber-500/20 transition-colors duration-300"></div>
            <div class="relative flex justify-between items-start z-10">
                <div>
                    <p class="text-xs font-bold theme-text-muted uppercase tracking-wider">Pending KYC</p>
                    <h3 class="text-3xl font-extrabold theme-text-main mt-2 group-hover:text-amber-500 transition-colors">NaN</h3>
                </div>
                <div class="p-3 bg-amber-500/10 text-amber-500 rounded-xl shadow-inner group-hover:scale-110 transition-transform duration-300">
                    <i class="fa-solid fa-file-contract text-xl"></i>
                </div>
            </div>
            <div class="mt-4 flex items-center text-xs theme-text-muted">
                <span class="text-amber-500 font-bold bg-amber-500/10 px-1.5 py-0.5 rounded mr-2 border border-amber-500/20"><i class="fa-solid fa-hourglass-half"></i> Action</span>
                <span>Documents Needed</span>
            </div>
            <div class="absolute bottom-0 left-0 w-full h-1 bg-gradient-to-r from-amber-400 to-orange-500 transform scale-x-0 group-hover:scale-x-100 transition-transform duration-500 origin-left"></div>
        </div>
    </div>

    {{-- 3. MAIN CONTENT --}}
    <div class="theme-bg-card border theme-border rounded-xl shadow-sm overflow-hidden">
        
        {{-- Filter Bar --}}
        <div class="p-4 border-b theme-border flex flex-wrap gap-4 items-center justify-between" style="background-color: rgba(var(--bg-body), 0.5);">
            <div class="relative flex-1 max-w-md min-w-[200px]">
                <i class="fa-solid fa-search absolute left-3 top-1/2 -translate-y-1/2 theme-text-muted"></i>
                <input type="text" id="searchInput" placeholder="Search consultants..." 
                    class="w-full pl-10 pr-4 py-2 text-sm theme-bg-body border theme-border rounded-lg focus:ring-2 focus:ring-blue-500 theme-text-main placeholder-gray-500">
            </div>
            
            <div class="flex flex-wrap gap-2">
                <select id="subscriptionFilter" class="text-sm theme-bg-body border theme-border rounded-lg focus:ring-2 focus:ring-blue-500 theme-text-main">
                    <option value="all">All Plans</option>
                    <option value="subscribed">Premium</option>
                    <option value="free">Standard</option>
                </select>

                <select id="statusFilter" class="text-sm theme-bg-body border theme-border rounded-lg focus:ring-2 focus:ring-blue-500 theme-text-main">
                    <option value="all">All Status</option>
                    <option value="active">Active</option>
                    <option value="suspend">Suspended</option>
                </select>
                
                <button type="button" id="resetFilters" class="text-xs hover:text-white font-medium px-2" style="color: rgb(var(--brand-primary));">
                    Reset
                </button>
            </div>
        </div>

        {{-- Table --}}
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y theme-border" style="border-color: rgb(var(--border-color));">
                <thead class="theme-bg-body">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium theme-text-muted uppercase tracking-wider">Basic Info</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium theme-text-muted uppercase tracking-wider">Consultation Controls</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium theme-text-muted uppercase tracking-wider">Performance</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium theme-text-muted uppercase tracking-wider">Media/Recordings</th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium theme-text-muted uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="theme-bg-card divide-y theme-border" id="consultants-table-body" style="border-color: rgb(var(--border-color));">
                    @forelse ($consultants as $consultant)
                    @php
                        // Logic & Subscriptions
                        $hasSub = ($consultant->id % 2 != 0); 
                        $planName = $hasSub ? 'Executive Partner' : 'Standard';
                        $subStatus = $hasSub ? 'subscribed' : 'free';
                        $image = $consultant->image ? asset($consultant->image) : null;

                        // Status styling (using transparent backgrounds)
                        $statusClass = match($consultant->status) {
                            'active' => 'bg-green-500/10 text-green-500 border border-green-500/20',
                            'suspend' => 'bg-red-500/10 text-red-500 border border-red-500/20',
                            default => 'bg-gray-500/10 text-gray-500 border border-gray-500/20',
                        };

                        // Data Preparation for SlideOver
                        $jsData = [
                            'id' => $consultant->id,
                            'name' => $consultant->name,
                            'email' => $consultant->email,
                            'image' => $image,
                            'status' => ucfirst($consultant->status),
                            'phone' => $consultant->phone ?? 'N/A',
                            'address' => [
                                'current' => $consultant->current_address ?? '123 Consultant Way, Suite 100',
                                'permanent' => $consultant->permanent_address ?? '456 Home Lane',
                                'city' => $consultant->city ?? 'Los Angeles',
                                'state' => $consultant->state ?? 'CA'
                            ],
                            'wallet' => [
                                'balance' => rand(1000, 20000) . '.00',
                                'pending' => rand(0, 2000) . '.00',
                                'withdrawn' => rand(5000, 50000) . '.00',
                            ],
                            'payment_methods' => ['Visa **** 1234', 'Mastercard **** 5678'],
                            'media' => [
                                ['type' => 'video', 'title' => 'Consultation with John D.', 'date' => 'Oct 24, 2024', 'duration' => '45:00'],
                                ['type' => 'audio', 'title' => 'Session #402 Audio Log', 'date' => 'Oct 20, 2024', 'duration' => '12:30'],
                                ['type' => 'video', 'title' => 'Follow-up Call', 'date' => 'Oct 18, 2024', 'duration' => '30:00'],
                            ],
                            'documents' => [
                                ['name' => 'National ID / Passport', 'type' => 'PDF', 'status' => 'Pending'],
                                ['name' => 'Professional Certification', 'type' => 'IMG', 'status' => 'Verified']
                            ],
                            'subscription' => [
                                'has_plan' => $hasSub,
                                'plan_name' => $planName,
                                'expires_at' => now()->addDays(30)->format('M d, Y'),
                                'progress' => 75
                            ],
                        ];
                    @endphp
                    <tr class="consultant-row hover:bg-white/5 transition duration-150 group"
                        data-name="{{ strtolower($consultant->name) }}"
                        data-status="{{ strtolower($consultant->status) }}"
                        data-subscription="{{ $subStatus }}">

                        {{-- 1. Basic Info --}}
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="relative flex-shrink-0 h-10 w-10">
                                    @if($image)
                                        <img class="h-10 w-10 rounded-full object-cover border theme-border" src="{{ $image }}" alt="">
                                    @else
                                        <div class="h-10 w-10 rounded-full bg-indigo-500/10 flex items-center justify-center text-indigo-500 font-bold border border-indigo-500/20">
                                            {{ substr($consultant->name, 0, 1) }}
                                        </div>
                                    @endif
                                    @if($hasSub)
                                    <div class="absolute -top-1 -right-1 text-white p-0.5 rounded-full border border-white" style="background-color: rgb(var(--brand-primary));" title="Premium">
                                        <i class="fa-solid fa-crown text-[8px]"></i>
                                    </div>
                                    @endif
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium theme-text-main">{{ $consultant->name }}</div>
                                    <div class="text-xs theme-text-muted">Spec: NaN</div>
                                </div>
                            </div>
                        </td>

                        {{-- 2. Consultation Controls --}}
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex flex-col gap-1">
                                <span class="text-xs theme-text-muted flex items-center"><i class="fa-solid fa-calendar-days mr-1 text-indigo-400"></i> Next: <strong class="ml-1 theme-text-main">NaN</strong></span>
                                <span class="text-xs theme-text-muted">Rate: <strong class="theme-text-main">$NaN/hr</strong></span>
                                <span class="inline-flex w-fit items-center rounded-full px-2 py-0.5 text-xs font-semibold border {{ $statusClass }}">
                                    {{ ucfirst($consultant->status) }}
                                </span>
                            </div>
                        </td>

                        {{-- 3. Performance --}}
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm theme-text-main font-medium">NaN <span class="text-yellow-400 text-xs"><i class="fa-solid fa-star"></i></span></div>
                            <div class="text-xs theme-text-muted">NaN Sessions</div>
                        </td>

                        {{-- 4. Media --}}
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex gap-2">
                                <span class="inline-flex items-center px-2 py-1 rounded-md theme-bg-body text-xs theme-text-muted border theme-border" title="Audio Logs">
                                    <i class="fa-solid fa-microphone mr-1"></i> NaN
                                </span>
                                <span class="inline-flex items-center px-2 py-1 rounded-md theme-bg-body text-xs theme-text-muted border theme-border" title="Video Sessions">
                                    <i class="fa-solid fa-video mr-1"></i> NaN
                                </span>
                            </div>
                        </td>

                        {{-- 5. Actions --}}
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <div class="flex justify-end items-center gap-2">
                                <button onclick="openSlideOver({{ json_encode($jsData) }})" 
                                    class="text-white p-2 rounded hover:opacity-80 transition"
                                    style="background-color: rgba(var(--brand-primary), 0.1); color: rgb(var(--brand-primary));"
                                    title="View Details">
                                    View Details
                                </button>
                                
                                <div class="relative" x-data="{ open: false }">
                                    <button @click="open = !open" @click.away="open = false" class="theme-text-muted hover:text-white p-2 rounded-full hover:bg-white/10">
                                        <i class="fa-solid fa-ellipsis-v"></i>
                                    </button>
                                    <div x-show="open" class="absolute right-0 mt-2 w-48 theme-bg-card rounded-md shadow-lg py-1 z-50 border theme-border" style="display: none;">
                                        <button class="w-full text-left px-4 py-2 text-sm text-red-500 hover:bg-white/5 flex items-center">
                                            <i class="fa-solid fa-ban mr-2"></i> Suspend Account
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-10 text-center theme-text-muted italic">No consultants found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        {{-- Footer --}}
        <div class="px-6 py-4 border-t theme-border flex justify-center theme-bg-body">
            <span class="text-xs font-medium theme-text-muted">Showing <span id="showing-count">{{ $consultants->count() }}</span> consultants</span>
        </div>
    </div>
</div>

{{-- 4. UNIFIED SLIDE-OVER --}}
<div id="consultant-slide-over" class="fixed inset-0 overflow-hidden z-50 hidden">
    <div class="absolute inset-0 bg-black/80 transition-opacity backdrop-blur-sm" onclick="closeSlideOver()"></div>
    <div class="fixed inset-y-0 right-0 max-w-2xl w-full flex pointer-events-none">
        <div class="w-full h-full theme-bg-card shadow-2xl pointer-events-auto flex flex-col transform transition-transform duration-300 translate-x-full" id="so-panel">
            
            {{-- Header --}}
            <div class="theme-bg-card px-6 py-6 border-b theme-border shrink-0">
                <div class="flex justify-between items-start">
                    <div class="flex items-center space-x-4">
                        <img id="so-image" src="" class="h-16 w-16 rounded-full border-2 border-white/50 object-cover" style="background-color: rgb(var(--brand-primary));">
                        <div>
                            <h2 class="text-xl font-bold theme-text-main" id="so-name"></h2>
                            <p class="theme-text-muted text-sm flex items-center gap-2">
                                <span id="so-email"></span>
                                <span class="w-1 h-1 bg-gray-500 rounded-full"></span>
                                <span id="so-status" class="uppercase text-xs font-bold theme-bg-body border theme-border px-2 py-0.5 rounded"></span>
                            </p>
                        </div>
                    </div>
                    <button onclick="closeSlideOver()" class="theme-text-muted hover:text-white transition"><i class="fa-solid fa-times text-xl"></i></button>
                </div>

                {{-- Tabs --}}
                <div class="flex flex-nowrap space-x-6 mt-8 text-sm font-medium overflow-x-auto no-scrollbar border-b theme-border">
                    <button onclick="switchTab('overview')" class="tab-btn border-b-2 font-bold pb-3 theme-text-main transition whitespace-nowrap shrink-0" style="border-color: rgb(var(--brand-primary));" id="tab-overview">Overview</button>
                    <button onclick="switchTab('media')" class="tab-btn border-b-2 border-transparent pb-3 theme-text-muted hover:text-white transition whitespace-nowrap shrink-0" id="tab-media">Consultation history</button>
                    <button onclick="switchTab('wallet')" class="tab-btn border-b-2 border-transparent pb-3 theme-text-muted hover:text-white transition whitespace-nowrap shrink-0" id="tab-wallet">Wallet</button>
                    <button onclick="switchTab('portfolio')" class="tab-btn border-b-2 border-transparent pb-3 theme-text-muted hover:text-white transition whitespace-nowrap shrink-0" id="tab-portfolio">Portfolio</button>
                    <button onclick="switchTab('payment-methods')" class="tab-btn border-b-2 border-transparent pb-3 theme-text-muted hover:text-white transition whitespace-nowrap shrink-0" id="tab-payment-methods">Payment Methods</button>
                    <button onclick="switchTab('documents')" class="tab-btn border-b-2 border-transparent pb-3 theme-text-muted hover:text-white transition whitespace-nowrap shrink-0" id="tab-documents">KYC Documents</button>
                    <button onclick="switchTab('subscription')" class="tab-btn border-b-2 border-transparent pb-3 theme-text-muted hover:text-white transition whitespace-nowrap shrink-0" id="tab-subscription">Subscription</button>
                </div>
            </div>

            {{-- Content --}}
            <div class="flex-1 overflow-y-auto p-6 theme-bg-body scroll-smooth">
                
                {{-- TAB: OVERVIEW --}}
                <div id="content-overview" class="tab-content space-y-6">
                    <div class="theme-bg-card p-5 rounded-xl shadow-sm border theme-border">
                        <h3 class="font-bold theme-text-main mb-4 flex items-center"><i class="fa-solid fa-user-circle mr-2" style="color: rgb(var(--brand-primary));"></i> Profile Details</h3>
                        <div class="grid grid-cols-2 gap-y-4 gap-x-6 text-sm">
                            <div><p class="theme-text-muted text-xs uppercase">Consultant ID</p><p class="font-medium theme-text-main" id="so-id"></p></div>
                            <div><p class="theme-text-muted text-xs uppercase">Phone</p><p class="font-medium theme-text-main" id="so-phone"></p></div>
                            <div class="col-span-2"><p class="theme-text-muted text-xs uppercase">Bio</p><p class="theme-text-muted italic mt-1">"No bio available (NaN)."</p></div>
                        </div>
                    </div>

                    {{-- Address Section --}}
                    <div class="theme-bg-card p-5 rounded-xl shadow-sm border theme-border">
                        <h3 class="font-bold theme-text-main mb-4 flex items-center"><i class="fa-solid fa-map-marker-alt mr-2" style="color: rgb(var(--brand-primary));"></i> Address Details</h3>
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

                {{-- TAB: MEDIA --}}
                <div id="content-media" class="tab-content hidden space-y-4">
                    <div class="theme-bg-card p-5 rounded-xl shadow-sm border theme-border">
                        <h3 class="font-bold theme-text-main mb-4">Session Recordings & Media</h3>
                        <div id="so-media-list" class="space-y-3">
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
                                <i class="fa-solid fa-wallet text-2xl"></i>
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
                                        <i class="fa-solid fa-arrow-down"></i>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium theme-text-main">Session Completed</p>
                                        <p class="text-xs theme-text-muted">Service Fee Earned</p>
                                    </div>
                                </div>
                                <span class="text-sm font-bold text-green-500">+$250.00</span>
                            </div>
                            <div class="flex justify-between items-center border-b theme-border pb-3 last:border-0">
                                <div class="flex items-center gap-3">
                                    <div class="h-8 w-8 rounded-full bg-red-500/10 text-red-500 flex items-center justify-center text-xs">
                                        <i class="fa-solid fa-arrow-up"></i>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium theme-text-main">Withdrawal</p>
                                        <p class="text-xs theme-text-muted">Bank Transfer</p>
                                    </div>
                                </div>
                                <span class="text-sm font-bold theme-text-main">-$1500.00</span>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- TAB: PORTFOLIO --}}
                <div id="content-portfolio" class="tab-content hidden h-full">
                    <div class="flex flex-col items-center justify-center h-64 border-2 border-dashed theme-border rounded-xl theme-bg-card">
                        <div class="h-12 w-12 theme-bg-body rounded-full flex items-center justify-center theme-text-muted mb-3">
                            <i class="fa-solid fa-images"></i>
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
                            <span class="bg-yellow-500/10 text-yellow-500 border border-yellow-500/20 text-xs font-bold px-2 py-1 rounded">Review Needed</span>
                        </div>
                        <div id="so-doc-list" class="space-y-3">
                            {{-- Populated via JS --}}
                        </div>
                        
                        <div class="mt-8 pt-6 border-t theme-border flex gap-3">
                            <button class="flex-1 px-4 py-2.5 bg-red-500/10 text-red-500 hover:bg-red-500/20 border border-red-500/20 rounded-lg font-medium transition shadow-sm">
                                <i class="fa-solid fa-ban mr-2"></i> Reject KYC
                            </button>
                            <button class="flex-1 px-4 py-2.5 bg-green-600 text-white hover:bg-green-700 rounded-lg font-medium transition shadow-md">
                                <i class="fa-solid fa-check-circle mr-2"></i> Approve KYC
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

{{-- 5. ADD MODAL --}}
<div id="add-consultant-modal" class="fixed inset-0 z-50 hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-black/80 transition-opacity backdrop-blur-sm" onclick="closeAddModal()"></div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        <div class="inline-block align-bottom theme-bg-card border theme-border rounded-2xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg w-full">
            <div class="px-6 py-6 border-b theme-border flex justify-between items-center">
                <h3 class="text-xl font-bold theme-text-main"><i class="fa-solid fa-user-plus mr-2" style="color: rgb(var(--brand-primary));"></i> Onboard Consultant</h3>
                <button onclick="closeAddModal()" class="theme-text-muted hover:text-white focus:outline-none"><i class="fa-solid fa-times"></i></button>
            </div>

            <form id="createConsultantForm"> @csrf
                <div class="p-6 space-y-5">
                    <div id="successMessage" class="hidden mb-4 bg-green-500/10 border border-green-500/20 text-green-500 px-4 py-3 rounded text-sm"></div>
                    <div id="errorMessage" class="hidden mb-4 bg-red-500/10 border border-red-500/20 text-red-500 px-4 py-3 rounded text-sm"></div>

                    <div>
                        <label class="block text-sm font-medium theme-text-muted mb-1">Full Name</label>
                        <input type="text" name="name" class="w-full theme-bg-body border theme-border rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 sm:text-sm p-2.5 theme-text-main" placeholder="e.g. Dr. Jane Doe">
                        <span class="text-xs text-red-500 error-text name_error"></span>
                    </div>

                    <div>
                        <label class="block text-sm font-medium theme-text-muted mb-1">Email Address</label>
                        <input type="email" name="email" class="w-full theme-bg-body border theme-border rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 sm:text-sm p-2.5 theme-text-main" placeholder="jane@consulting.com">
                        <span class="text-xs text-red-500 error-text email_error"></span>
                    </div>
                </div>
                
                <div class="p-6 border-t theme-border flex justify-end theme-bg-body">
                    <button type="button" onclick="closeAddModal()" class="mr-3 px-4 py-2 theme-text-muted theme-bg-card border theme-border rounded-lg hover:bg-white/5 transition shadow-sm font-medium">Cancel</button>
                    <button type="button" id="submitBtn" class="px-4 py-2 text-white rounded-lg shadow-md flex items-center transition font-medium hover:opacity-90"
                        style="background-color: rgb(var(--brand-primary));">
                        <i class="fa-solid fa-spinner fa-spin hidden mr-2" id="loadingIcon"></i> Save Consultant
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        
        // --- Slide Over Logic ---
        window.openSlideOver = function(data) {
            document.getElementById('consultant-slide-over').classList.remove('hidden');
            document.getElementById('so-panel').classList.remove('translate-x-full');

            // 1. Header
            document.getElementById('so-name').innerText = data.name;
            document.getElementById('so-email').innerText = data.email;
            document.getElementById('so-status').innerText = data.status;
            document.getElementById('so-image').src = data.image ? data.image : `https://ui-avatars.com/api/?name=${encodeURIComponent(data.name)}&background=3730a3&color=fff`;

            // 2. Details
            document.getElementById('so-id').innerText = 'CNTR-' + data.id;
            document.getElementById('so-phone').innerText = data.phone;
            
            // Address Fields
            document.getElementById('so-addr-current').innerText = data.address.current;
            document.getElementById('so-addr-perm').innerText = data.address.permanent;
            document.getElementById('so-addr-city').innerText = `${data.address.city}, ${data.address.state}`;

            // 3. Media Tab
            const mediaList = document.getElementById('so-media-list');
            if (data.media && data.media.length > 0) {
                mediaList.innerHTML = data.media.map(item => `
                <div class="flex items-center justify-between p-3 border theme-border rounded-lg hover:bg-white/5 transition">
                    <div class="flex items-center gap-3">
                        <div class="h-10 w-10 ${item.type == 'video' ? 'bg-indigo-500/10 text-indigo-500' : 'bg-orange-500/10 text-orange-500'} rounded-lg flex items-center justify-center">
                             <i class="fa-solid ${item.type == 'video' ? 'fa-video' : 'fa-microphone'}"></i>
                        </div>
                        <div>
                            <p class="text-sm font-medium theme-text-main">${item.title}</p>
                            <p class="text-xs theme-text-muted">${item.date} • ${item.duration}</p>
                        </div>
                    </div>
                    <button class="text-xs font-semibold hover:underline" style="color: rgb(var(--brand-primary));">Play</button>
                </div>
                `).join('');
            } else {
                mediaList.innerHTML = '<div class="text-center py-4 theme-text-muted italic">No recordings available.</div>';
            }

            // 4. Wallet Tab
            document.getElementById('so-wallet-balance').innerText = `$${data.wallet.balance}`;
            document.getElementById('so-wallet-pending').innerText = `$${data.wallet.pending}`;
            document.getElementById('so-wallet-withdrawn').innerText = `$${data.wallet.withdrawn}`;

            // 5. Payment Methods Tab
            const payMethodList = document.getElementById('so-payment-methods-list');
            if (data.payment_methods && data.payment_methods.length > 0) {
                payMethodList.innerHTML = data.payment_methods.map(pm => `
                <div class="flex items-center p-3 border theme-border rounded-lg hover:bg-white/5 transition">
                    <div class="h-10 w-10 bg-indigo-500/10 text-indigo-500 rounded-full flex items-center justify-center mr-3">
                         <i class="fa-solid fa-credit-card"></i>
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

            // 6. KYC Documents Tab
            const docList = document.getElementById('so-doc-list');
            if(data.documents && data.documents.length > 0) {
                docList.innerHTML = data.documents.map(doc => `
                    <div class="flex items-center justify-between p-3 theme-bg-card border theme-border rounded-lg hover:shadow-sm transition">
                        <div class="flex items-center space-x-3">
                            <div class="h-10 w-10 bg-indigo-500/10 text-indigo-500 rounded-lg flex items-center justify-center text-lg"><i class="fa-solid fa-file-contract"></i></div>
                            <div>
                                <p class="text-sm font-semibold theme-text-main">${doc.name}</p>
                                <span class="text-[10px] theme-text-muted uppercase">${doc.type}</span>
                            </div>
                        </div>
                        <span class="text-xs font-bold ${doc.status === 'Verified' ? 'text-green-500 bg-green-500/10' : 'text-yellow-500 bg-yellow-500/10'} px-2 py-1 rounded">${doc.status}</span>
                    </div>
                `).join('');
            } else {
                docList.innerHTML = '<p class="theme-text-muted italic text-center">No documents found.</p>';
            }

            // 7. Subscription
            const subContainer = document.getElementById('so-subscription-container');
            if (data.subscription && data.subscription.has_plan) {
                subContainer.innerHTML = `
                <div class="relative overflow-hidden theme-bg-body p-6 rounded-2xl shadow-xl text-white">
                    <div class="absolute top-0 right-0 -mt-4 -mr-4 w-32 h-32 bg-indigo-500 rounded-full opacity-20 blur-2xl"></div>
                    <div class="flex justify-between items-start relative z-10">
                        <div>
                            <p class="text-indigo-300 text-xs font-bold uppercase tracking-wider mb-1">Current Plan</p>
                            <h2 class="text-2xl font-extrabold theme-text-main tracking-tight">${data.subscription.plan_name}</h2>
                        </div>
                        <div class="bg-indigo-500/20 border border-indigo-400/30 p-2 rounded-lg"><i class="fa-solid fa-crown text-indigo-300"></i></div>
                    </div>
                    <div class="mt-6 space-y-3">
                        <div class="flex justify-between text-sm"><span class="theme-text-muted">Validity</span><span class="theme-text-main font-medium">${data.subscription.progress}%</span></div>
                        <div class="w-full bg-gray-700 rounded-full h-2"><div class="bg-gradient-to-r from-indigo-500 to-purple-500 h-2 rounded-full" style="width: ${data.subscription.progress}%"></div></div>
                        <div class="flex justify-between text-xs mt-1"><span class="theme-text-muted">Expires</span><span class="text-indigo-300 font-medium">${data.subscription.expires_at}</span></div>
                    </div>
                </div>`;
            } else {
                subContainer.innerHTML = '<div class="p-6 text-center border-dashed border-2 theme-border rounded-xl theme-text-muted"><h3 class="font-bold">No Active Plan</h3><p class="text-xs">Free Tier</p></div>';
            }

            switchTab('overview');
        }

        window.closeSlideOver = function() {
            document.getElementById('so-panel').classList.add('translate-x-full');
            setTimeout(() => { document.getElementById('consultant-slide-over').classList.add('hidden'); }, 300);
        }

        window.switchTab = function(tabName) {
            document.querySelectorAll('.tab-btn').forEach(btn => {
                btn.classList.remove('border-white', 'text-white');
                btn.classList.add('border-transparent', 'theme-text-muted');
                btn.style.borderColor = 'transparent';
                btn.style.color = '';
            });
            document.querySelectorAll('.tab-content').forEach(content => content.classList.add('hidden'));

            const activeBtn = document.getElementById('tab-' + tabName);
            activeBtn.classList.remove('border-transparent', 'theme-text-muted');
            // Apply theme variable via inline style
            activeBtn.style.borderColor = 'rgb(var(--brand-primary))';
            activeBtn.style.color = 'rgb(var(--brand-primary))';
            
            document.getElementById('content-' + tabName).classList.remove('hidden');
        }

        // --- Filter Logic ---
        const searchInput = document.getElementById('searchInput');
        const subscriptionFilter = document.getElementById('subscriptionFilter');
        const statusFilter = document.getElementById('statusFilter');
        const resetBtn = document.getElementById('resetFilters');

        function applyFilters() {
            const search = searchInput.value.toLowerCase();
            const sub = subscriptionFilter.value.toLowerCase();
            const status = statusFilter.value.toLowerCase();
            let visible = 0;

            document.querySelectorAll('.consultant-row').forEach(row => {
                const name = row.dataset.name;
                const rowSub = row.dataset.subscription;
                const rowStatus = row.dataset.status;

                if(name.includes(search) && (sub === 'all' || rowSub === sub) && (status === 'all' || rowStatus === status)) {
                    row.classList.remove('hidden');
                    visible++;
                } else {
                    row.classList.add('hidden');
                }
            });
            document.getElementById('showing-count').innerText = visible;
        }

        [searchInput, subscriptionFilter, statusFilter].forEach(el => el.addEventListener('input', applyFilters));
        resetBtn.addEventListener('click', () => {
            searchInput.value = ''; subscriptionFilter.value = 'all'; statusFilter.value = 'all'; applyFilters();
        });

        // --- Modal & AJAX ---
        window.openAddModal = function() {
            document.getElementById('add-consultant-modal').classList.remove('hidden');
            document.getElementById('createConsultantForm').reset();
            document.getElementById('successMessage').classList.add('hidden');
            document.getElementById('errorMessage').classList.add('hidden');
        }

        window.closeAddModal = function() {
            document.getElementById('add-consultant-modal').classList.add('hidden');
        }

        document.getElementById('submitBtn').addEventListener('click', function(e) {
            e.preventDefault();
            const btn = this;
            btn.disabled = true;
            document.getElementById('loadingIcon').classList.remove('hidden');
            
            const formData = new FormData(document.getElementById('createConsultantForm'));
            axios.post("{{ route('store.consultant') }}", formData)
            .then(response => {
                document.getElementById('successMessage').textContent = response.data.message || 'Saved successfully';
                document.getElementById('successMessage').classList.remove('hidden');
                setTimeout(() => window.location.reload(), 1000);
            })
            .catch(error => {
                btn.disabled = false;
                document.getElementById('loadingIcon').classList.add('hidden');
                document.getElementById('errorMessage').textContent = error.response?.data?.message || 'Error occurred';
                document.getElementById('errorMessage').classList.remove('hidden');
            });
        });
    });
</script>
@endpush

@push('styles') 
<style>
    /* Hide scrollbar completely but allow scrolling */
    .no-scrollbar::-webkit-scrollbar {
        display: none !important;
    }

    .no-scrollbar {
        -ms-overflow-style: none !important;  
        scrollbar-width: none !important;  
        -webkit-overflow-scrolling: touch; 
    }

    .tab-content {
        animation: fadeIn 0.3s ease-in-out;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(5px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>
@endpush