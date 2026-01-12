@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-gray-50/50 px-6 py-8 md:px-10 lg:px-12">
        
        {{-- 1. HEADER --}}
        <div class="mb-8 flex flex-col md:flex-row md:items-center md:justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 tracking-tight">Expert Management</h1>
                <p class="text-gray-500 mt-1">Manage KYC, validations, and platform performance.</p>
            </div>
            <div class="mt-4 md:mt-0">
                <button onclick="openCreateExpertModal()" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg text-sm font-medium shadow-sm transition-colors">
                    + Add Professional
                </button>
            </div>
        </div>

        {{-- 2. ANALYTICS CARDS (Dynamic Loop using provided design) --}}
        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4 mb-8">
            @php
                $stats = [
                    [
                        'label' => 'Total Experts',
                        'value' => $professionals->count(),
                        'icon_bg' => 'bg-indigo-100',
                        'icon_text' => 'text-indigo-600',
                        'icon_path' => 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M5 10a5.002 5.002 0 0110 0v-1h-10v1zm0 0l-2 10h14l-2-10H5zM17 4h3m-3 3h3M4 4h3m-3 3h3'
                    ],
                    [
                        'label' => 'Active Now',
                        'value' => $professionals->where('status', 'active')->count(),
                        'icon_bg' => 'bg-green-100',
                        'icon_text' => 'text-green-600',
                        'icon_path' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z'
                    ],
                    [
                        'label' => 'Pending KYC',
                        'value' => $professionals->where('kyc_status', 'pending')->count(), // Assuming column exists, else 0
                        'icon_bg' => 'bg-yellow-100',
                        'icon_text' => 'text-yellow-600',
                        'icon_path' => 'M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z'
                    ],
                    [
                        'label' => 'Suspended',
                        'value' => $professionals->where('status', 'suspend')->count(),
                        'icon_bg' => 'bg-red-100',
                        'icon_text' => 'text-red-600',
                        'icon_path' => 'M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636'
                    ],
                ];
            @endphp

            @foreach($stats as $stat)
                <div class="bg-white p-5 rounded-xl shadow-lg flex items-center justify-between transition duration-150 hover:shadow-xl hover:scale-[1.01]">
                    <div>
                        <p class="text-sm font-medium text-gray-500 truncate">{{ $stat['label'] }}</p>
                        <p class="text-xl font-bold text-gray-900 mt-1">{{ number_format($stat['value']) }}</p>
                    </div>
                    <div class="p-3 rounded-full {{ $stat['icon_bg'] }} {{ $stat['icon_text'] }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $stat['icon_path'] }}"></path>
                        </svg>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- 3. FILTER PANEL --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5 transition-all duration-300 mb-8">
            <form id="filter-form">
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-4 items-center">
                    
                    <div class="lg:col-span-5 relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                        </div>
                        <input type="text" id="filter-search" class="block w-full pl-10 pr-3 py-2.5 border border-gray-200 rounded-lg leading-5 bg-gray-50 placeholder-gray-400 focus:outline-none focus:bg-white focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm transition duration-150 ease-in-out" placeholder="Search by name or ID...">
                    </div>

                    <div class="lg:col-span-2">
                        <select id="filter-category" class="block w-full py-2.5 pl-3 pr-10 border border-gray-200 bg-white rounded-lg text-gray-600 sm:text-sm focus:ring-indigo-500 focus:border-indigo-500">
                            <option value="">All Categories</option>
                            <option value="legal">Legal</option>
                            <option value="finance">Finance</option>
                            <option value="architecture">Architecture</option>
                            <option value="technology">Technology</option>
                        </select>
                    </div>

                    <div class="lg:col-span-2">
                        <select id="filter-region" class="block w-full py-2.5 pl-3 pr-10 border border-gray-200 bg-white rounded-lg text-gray-600 sm:text-sm focus:ring-indigo-500 focus:border-indigo-500">
                            <option value="">All Regions</option>
                            <option value="north america">North America</option>
                            <option value="europe">Europe</option>
                            <option value="asia">Asia Pacific</option>
                        </select>
                    </div>

                    <div class="lg:col-span-3 flex justify-end gap-2">
                        <button type="button" id="reset-filters" class="px-4 py-2 border border-gray-200 rounded-lg text-sm font-medium text-gray-600 hover:bg-gray-50 transition">
                            Reset
                        </button>
                        {{-- Added type button to prevent form submit --}}
                        <button type="button" class="px-4 py-2 bg-indigo-600 border border-transparent rounded-lg text-sm font-medium text-white hover:bg-indigo-700 shadow-sm transition">
                            Apply Filters
                        </button>
                    </div>
                </div>

                <div class="mt-4 pt-4 border-t border-gray-100 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-2">Availability</label>
                        <div class="flex gap-2">
                            <label class="cursor-pointer">
                                <input type="radio" name="status" value="all" class="peer sr-only status-radio" checked>
                                <span class="px-3 py-1.5 rounded-full text-xs font-medium bg-gray-100 text-gray-600 peer-checked:bg-indigo-100 peer-checked:text-indigo-700 transition">All</span>
                            </label>
                            <label class="cursor-pointer">
                                <input type="radio" name="status" value="active" class="peer sr-only status-radio">
                                <span class="px-3 py-1.5 rounded-full text-xs font-medium bg-gray-100 text-gray-600 peer-checked:bg-green-100 peer-checked:text-green-700 transition">Active</span>
                            </label>
                            <label class="cursor-pointer">
                                <input type="radio" name="status" value="suspend" class="peer sr-only status-radio">
                                <span class="px-3 py-1.5 rounded-full text-xs font-medium bg-gray-100 text-gray-600 peer-checked:bg-gray-200 peer-checked:text-gray-800 transition">Suspended</span>
                            </label>
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-2">Verification</label>
                        <select id="filter-kyc" class="block w-full py-1.5 border-none bg-gray-50 rounded text-sm text-gray-600 focus:ring-0">
                            <option value="">Any Status</option>
                            <option value="verified">Verified Only</option>
                            <option value="pending">Pending KYC</option>
                            <option value="rejected">Rejected</option>
                        </select>
                    </div>

                    <div class="lg:col-span-2">
                        <div class="flex justify-between items-center mb-1">
                            <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide">Max Hourly Rate</label>
                            <span class="text-xs text-indigo-600 font-bold">$<span id="rate-display">300</span>/hr</span>
                        </div>
                        <input type="range" id="filter-rate" min="25" max="1000" value="1000" class="w-full h-1 bg-gray-200 rounded-lg appearance-none cursor-pointer">
                    </div>
                </div>
            </form>
        </div>

        {{-- 4. EXPERTS TABLE --}}
        <div class="bg-white border border-gray-100 rounded-xl shadow-sm mt-8 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
                <h2 class="text-lg font-semibold text-gray-800">Expert Registry</h2>
                <span id="result-count" class="text-xs font-medium text-gray-500 bg-white border border-gray-200 px-2 py-1 rounded">Total: {{ $professionals->count() }}</span>
            </div>
            
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Expert Profile</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Category & Rate</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Compliance</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Performance</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="experts-table-body" class="bg-white divide-y divide-gray-200">
                        @forelse($professionals as $expert)
                            @php
                                $category = $expert->specialization ?? 'General';
                                $rate = $expert->hourly_rate ?? 0;
                                // Map DB status to UI classes
                                $statusClasses = match($expert->status) {
                                    'active' => 'bg-green-50 text-green-700 ring-green-600/20',
                                    'busy' => 'bg-yellow-50 text-yellow-800 ring-yellow-600/20',
                                    'offline' => 'bg-gray-100 text-gray-600 ring-gray-600/20',
                                    'suspend' => 'bg-red-50 text-red-700 ring-red-600/20',
                                    default => 'bg-gray-50 text-gray-700 ring-gray-600/20'
                                };
                                $image = $expert->image ? asset($expert->image) : 'https://ui-avatars.com/api/?name='.urlencode($expert->name).'&background=0D8ABC&color=fff';
                                
                                // Mock Data for Slide Over
                                $jsData = [
                                    'id' => $expert->id,
                                    'name' => $expert->name,
                                    'image' => $image,
                                    'category' => $category,
                                    'rate' => $rate,
                                    'join_date' => $expert->created_at->format('M Y'),
                                    'kyc_status' => 'verified', // Mocking as verified for visual
                                    'region' => $expert->city ?? 'Remote',
                                    'email' => $expert->email,
                                    'phone' => $expert->phone ?? 'N/A'
                                ];
                            @endphp

                            <tr class="expert-row hover:bg-gray-50 transition duration-150"
                                data-name="{{ strtolower($expert->name) }}"
                                data-id="{{ $expert->id }}"
                                data-category="{{ strtolower($category) }}"
                                data-rate="{{ $rate }}"
                                data-status="{{ strtolower($expert->status) }}"
                                data-kyc="verified" 
                                data-region="{{ strtolower($expert->city ?? '') }}">

                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="h-10 w-10 flex-shrink-0">
                                            <img class="h-10 w-10 rounded-full object-cover"
                                                src="{{ $image }}"
                                                alt="{{ $expert->name }}">
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">{{ $expert->name }}</div>
                                            <div class="text-xs text-gray-500">ID: EXP-{{ $expert->id }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $category }}</div>
                                    <div class="text-xs text-gray-500">${{ $rate }}/hr</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    <span class="inline-flex items-center rounded-full px-2 py-1 text-xs font-medium ring-1 ring-inset {{ $statusClasses }}">
                                        {{ ucfirst($expert->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex flex-col gap-1">
                                        <span class="inline-flex items-center gap-1 text-xs text-gray-600">
                                            <svg class="w-3 h-3 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                            </svg>
                                            Identity Verified
                                        </span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm text-gray-500">
                                    <span class="font-bold text-gray-900">4.9 ★</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <button onclick="openExpertDetails({{ json_encode($jsData) }})" class="text-indigo-600 hover:text-indigo-900 bg-indigo-50 hover:bg-indigo-100 px-3 py-1.5 rounded-md transition-colors">Details</button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-10 text-center text-gray-500 italic">
                                    No professionals found in the registry.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <div class="px-6 py-4 border-t border-gray-100 flex justify-center">
                <span id="showing-text" class="text-sm text-gray-500">Showing {{ $professionals->count() }} results</span>
            </div>
        </div>
    </div>

    {{-- 5. SLIDE OVER (Dynamic Content Injection) --}}
    <div id="expert-details-slideover" class="relative z-50 hidden" aria-labelledby="slide-over-title" role="dialog" aria-modal="true">
        <div id="slideover-backdrop" class="fixed inset-0 bg-gray-900/60 opacity-0 transition-opacity ease-in-out duration-500 backdrop-blur-sm"></div>

        <div class="fixed inset-0 overflow-hidden">
            <div class="absolute inset-0 overflow-hidden">
                <div class="pointer-events-none fixed inset-y-0 right-0 flex max-w-full pl-10">
                    <div id="slideover-panel" class="pointer-events-auto w-screen max-w-2xl transform translate-x-full transition-transform ease-in-out duration-500 sm:duration-500">
                        <div class="flex h-full flex-col bg-white shadow-2xl">
                            {{-- Header --}}
                            <div class="bg-indigo-900 px-4 py-6 sm:px-6">
                                <div class="flex items-center justify-between">
                                    <h2 class="text-lg font-medium text-white" id="slide-over-title">Expert Profile</h2>
                                    <div class="ml-3 flex h-7 items-center">
                                        <button type="button" class="rounded-md bg-indigo-900 text-indigo-200 hover:text-white focus:outline-none focus:ring-2 focus:ring-white" onclick="closeExpertDetails()">
                                            <span class="sr-only">Close panel</span>
                                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                                <div class="mt-6 flex items-center">
                                    <div class="flex-shrink-0">
                                        <img id="so-image" class="h-15 w-15 rounded-full object-cover" src="" alt="">
                                    </div>
                                    <div class="ml-4">
                                        <h3 id="so-name" class="text-xl font-bold text-white"></h3>
                                        <p id="so-meta" class="text-indigo-200 text-sm"></p>
                                        <div class="mt-2 flex items-center gap-2">
                                            <span class="inline-flex items-center rounded-md bg-green-400/10 px-2 py-1 text-xs font-medium text-green-400 ring-1 ring-inset ring-green-400/20">Verified Identity</span>
                                            <span class="inline-flex items-center rounded-md bg-indigo-400/10 px-2 py-1 text-xs font-medium text-indigo-300 ring-1 ring-inset ring-indigo-400/20">Top Rated</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Actions Toolbar --}}
                            <div class="border-b border-gray-200 bg-gray-50 px-4 py-3 flex gap-3 overflow-x-auto">
                                <button class="flex-1 inline-flex justify-center items-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50">
                                    <svg class="mr-1.5 h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M10 12.5a2.5 2.5 0 100-5 2.5 2.5 0 000 5z" />
                                        <path fill-rule="evenodd" d="M.664 10.59a1.651 1.651 0 010-1.186A10.004 10.004 0 0110 3c4.257 0 7.893 2.66 9.336 6.41.147.381.146.804 0 1.186A10.004 10.004 0 0110 17c-4.257 0-7.893-2.66-9.336-6.41zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" />
                                    </svg>
                                    Log in as User
                                </button>
                                <button class="flex-1 inline-flex justify-center items-center rounded-md bg-green-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-green-500">
                                    Approve KYC
                                </button>
                                <button class="flex-1 inline-flex justify-center items-center rounded-md bg-red-50 px-3 py-2 text-sm font-semibold text-red-600 shadow-sm ring-1 ring-inset ring-red-300 hover:bg-red-100">
                                    Suspend
                                </button>
                            </div>

                            {{-- Scrollable Content --}}
                            <div class="flex-1 overflow-y-auto custom-scrollbar bg-white px-4 py-6 sm:px-6">
                                <section class="mb-8">
                                    <h4 class="text-sm font-bold text-gray-500 uppercase tracking-wide mb-4">Professional Overview</h4>
                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                        <div class="bg-gray-50 p-3 rounded-lg border border-gray-100">
                                            <p class="text-xs text-gray-500">Hourly Rate</p>
                                            <p class="text-lg font-semibold text-gray-900">$<span id="so-rate"></span> <span class="text-xs font-normal text-gray-400">/hr</span></p>
                                        </div>
                                        <div class="bg-gray-50 p-3 rounded-lg border border-gray-100">
                                            <p class="text-xs text-gray-500">Region</p>
                                            <p id="so-region" class="text-lg font-semibold text-gray-900 capitalize"></p>
                                        </div>
                                        <div class="col-span-1 sm:col-span-2 bg-gray-50 p-3 rounded-lg border border-gray-100">
                                            <p class="text-xs text-gray-500">Contact Info</p>
                                            <div class="mt-1 text-sm text-gray-800">
                                                <div id="so-email"></div>
                                                <div id="so-phone"></div>
                                            </div>
                                        </div>
                                    </div>
                                </section>

                                {{-- Static Sections to keep design intact --}}
                                <section class="mb-8">
                                    <h4 class="text-sm font-bold text-gray-500 uppercase tracking-wide mb-4">Verification Documents</h4>
                                    <ul role="list" class="divide-y divide-gray-100 rounded-md border border-gray-200">
                                        <li class="flex items-center justify-between py-3 pl-3 pr-4 text-sm hover:bg-gray-50">
                                            <div class="flex w-0 flex-1 items-center">
                                                <svg class="h-5 w-5 flex-shrink-0 text-gray-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                                                </svg>
                                                <span class="ml-2 w-0 flex-1 truncate">government_id_front.pdf</span>
                                            </div>
                                            <div class="ml-4 flex-shrink-0 flex gap-3">
                                                <a href="#" class="font-medium text-indigo-600 hover:text-indigo-500">View</a>
                                                <span class="text-green-600 text-xs flex items-center font-bold">✓ Approved</span>
                                            </div>
                                        </li>
                                    </ul>
                                </section>

                                <section>
                                    <h4 class="text-sm font-bold text-gray-500 uppercase tracking-wide mb-4">Financial Overview (YTD)</h4>
                                    <div class="bg-white border border-gray-200 rounded-lg overflow-hidden">
                                        <div class="px-4 py-5 sm:p-6 grid grid-cols-3 divide-x divide-gray-200 text-center">
                                            <div>
                                                <dt class="text-xs font-normal text-gray-500">Earnings</dt>
                                                <dd class="mt-1 text-xl font-semibold tracking-tight text-gray-900">$0</dd>
                                            </div>
                                            <div>
                                                <dt class="text-xs font-normal text-gray-500">Pending</dt>
                                                <dd class="mt-1 text-xl font-semibold tracking-tight text-gray-900">$0</dd>
                                            </div>
                                            <div>
                                                <dt class="text-xs font-normal text-gray-500">Refunds</dt>
                                                <dd class="mt-1 text-xl font-semibold tracking-tight text-red-600">$0</dd>
                                            </div>
                                        </div>
                                    </div>
                                </section>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- 6. CREATE EXPERT MODAL --}}
    <div id="create-expert-modal" class="fixed inset-0 z-50 hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-gray-900 bg-opacity-75 transition-opacity backdrop-blur-sm" onclick="closeCreateExpertModal()"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg w-full">
                <div class="bg-white px-6 py-6 border-b border-gray-100 flex justify-between items-center">
                    <h3 class="text-xl font-bold text-gray-900">Add Professional</h3>
                    <button onclick="closeCreateExpertModal()" class="text-gray-400 hover:text-gray-600 focus:outline-none">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>

                <form id="createExpertForm" class="p-6 space-y-5">
                    @csrf
                    <div id="createErrorMessage" class="hidden bg-red-50 text-red-600 p-3 rounded-lg text-sm"></div>
                    <div id="createSuccessMessage" class="hidden bg-green-50 text-green-600 p-3 rounded-lg text-sm"></div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Full Name</label>
                        <input type="text" name="name" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm p-2.5 border">
                        <span class="text-xs text-red-500 error-text name_error"></span>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
                        <input type="email" name="email" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm p-2.5 border">
                        <span class="text-xs text-red-500 error-text email_error"></span>
                    </div>

                    {{-- <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Phone</label>
                        <input type="text" name="phone" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm p-2.5 border">
                        <span class="text-xs text-red-500 error-text phone_error"></span>
                    </div> --}}

                    {{-- <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Specialization</label>
                            <select name="specialization" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm p-2.5 border">
                                <option value="Legal">Legal</option>
                                <option value="Finance">Finance</option>
                                <option value="Architecture">Architecture</option>
                                <option value="Technology">Technology</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Experience (Yrs)</label>
                            <input type="number" name="experience_years" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm p-2.5 border">
                        </div>
                    </div> --}}
                </form>

                <div class="p-6 border-t border-gray-100 flex justify-end bg-gray-50">
                    <button type="button" onclick="closeCreateExpertModal()" class="mr-3 px-4 py-2 text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition shadow-sm font-medium">Cancel</button>
                    <button type="button" id="submitExpertBtn" class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 shadow-md flex items-center transition font-medium">
                        <svg id="expertLoadingIcon" class="hidden animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        Add Professional
                    </button>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('styles')
    <style>
        .custom-scrollbar::-webkit-scrollbar { width: 6px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: #f1f1f1; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #c7c7c7; border-radius: 3px; }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: #a0a0a0; }
        
        input[type=range]::-webkit-slider-thumb {
            -webkit-appearance: none;
            height: 16px;
            width: 16px;
            border-radius: 50%;
            background: #4f46e5;
            cursor: pointer;
            margin-top: -6px; 
        }
        input[type=range]::-webkit-slider-runnable-track {
            width: 100%;
            height: 4px;
            background: #e5e7eb;
            border-radius: 2px;
        }
    </style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        
        /* -------------------------------------------------------------------------- */
        /* 1. SLIDE OVER LOGIC (Updated to be Dynamic) */
        /* -------------------------------------------------------------------------- */
        const slideover = document.getElementById('expert-details-slideover');
        const backdrop = document.getElementById('slideover-backdrop');
        const panel = document.getElementById('slideover-panel');

        // Populate Slide Over Data
        window.openExpertDetails = function(data) {
            // Update Elements
            document.getElementById('so-image').src = data.image;
            document.getElementById('so-name').innerText = data.name;
            document.getElementById('so-meta').innerText = `${data.category} • Joined ${data.join_date}`;
            document.getElementById('so-rate').innerText = data.rate;
            document.getElementById('so-region').innerText = data.region;
            document.getElementById('so-email').innerText = data.email;
            document.getElementById('so-phone').innerText = data.phone;

            // Show Panel
            slideover.classList.remove('hidden');
            setTimeout(() => {
                backdrop.classList.remove('opacity-0');
                backdrop.classList.add('opacity-100');
                panel.classList.remove('translate-x-full');
                panel.classList.add('translate-x-0');
            }, 10);
        };

        window.closeExpertDetails = function() {
            backdrop.classList.remove('opacity-100');
            backdrop.classList.add('opacity-0');
            panel.classList.remove('translate-x-0');
            panel.classList.add('translate-x-full');
            setTimeout(() => {
                slideover.classList.add('hidden');
            }, 500); 
        };

        /* -------------------------------------------------------------------------- */
        /* 2. FILTER SYSTEM LOGIC                     */
        /* -------------------------------------------------------------------------- */
        
        const searchInput = document.getElementById('filter-search');
        const categorySelect = document.getElementById('filter-category');
        const regionSelect = document.getElementById('filter-region');
        const kycSelect = document.getElementById('filter-kyc');
        const rateInput = document.getElementById('filter-rate');
        const rateDisplay = document.getElementById('rate-display');
        const statusRadios = document.querySelectorAll('.status-radio');
        const resetButton = document.getElementById('reset-filters');
        
        const tableRows = document.querySelectorAll('.expert-row');
        const showingText = document.getElementById('showing-text');
        const totalCountBadge = document.getElementById('result-count');

        function filterExperts() {
            const searchValue = searchInput.value.toLowerCase();
            const categoryValue = categorySelect.value.toLowerCase();
            const regionValue = regionSelect.value.toLowerCase();
            const kycValue = kycSelect.value.toLowerCase();
            const maxRate = parseInt(rateInput.value);
            
            let statusValue = 'all';
            document.querySelectorAll('input[name="status"]').forEach(radio => {
                if(radio.checked) statusValue = radio.value;
            });

            let visibleCount = 0;

            tableRows.forEach(row => {
                const name = row.dataset.name.toLowerCase();
                const id = row.dataset.id.toString().toLowerCase();
                const category = row.dataset.category.toLowerCase();
                const region = row.dataset.region ? row.dataset.region.toLowerCase() : '';
                const kyc = row.dataset.kyc.toLowerCase();
                const rate = parseInt(row.dataset.rate);
                const status = row.dataset.status.toLowerCase();

                const matchesSearch = name.includes(searchValue) || id.includes(searchValue);
                const matchesCategory = categoryValue === '' || category === categoryValue;
                const matchesRegion = regionValue === '' || region === regionValue;
                const matchesKyc = kycValue === '' || kyc === kycValue;
                const matchesRate = rate <= maxRate;
                const matchesStatus = statusValue === 'all' || status === statusValue;

                if (matchesSearch && matchesCategory && matchesRegion && matchesKyc && matchesRate && matchesStatus) {
                    row.classList.remove('hidden');
                    visibleCount++;
                } else {
                    row.classList.add('hidden');
                }
            });

            if(showingText) showingText.innerText = `Showing ${visibleCount} results`;
            if(totalCountBadge) totalCountBadge.innerText = `Total: ${visibleCount}`;
        }

        searchInput.addEventListener('input', filterExperts);
        rateInput.addEventListener('input', function() {
            rateDisplay.innerText = this.value; 
            filterExperts();
        });

        categorySelect.addEventListener('change', filterExperts);
        regionSelect.addEventListener('change', filterExperts);
        kycSelect.addEventListener('change', filterExperts);
        statusRadios.forEach(radio => radio.addEventListener('change', filterExperts));

        resetButton.addEventListener('click', () => {
            document.getElementById('filter-form').reset();
            rateDisplay.innerText = "300";
            filterExperts();
        });

        filterExperts();

        /* -------------------------------------------------------------------------- */
        /* 3. AJAX CREATE EXPERT LOGIC                */
        /* -------------------------------------------------------------------------- */
        const submitBtn = document.getElementById('submitExpertBtn');
        const form = document.getElementById('createExpertForm');
        const errorDiv = document.getElementById('createErrorMessage');
        const successDiv = document.getElementById('createSuccessMessage');
        const loader = document.getElementById('expertLoadingIcon');

        submitBtn.addEventListener('click', function(e) {
            e.preventDefault();

            submitBtn.disabled = true;
            loader.classList.remove('hidden');
            errorDiv.classList.add('hidden');
            successDiv.classList.add('hidden');
            document.querySelectorAll('.error-text').forEach(el => el.innerText = '');

            let formData = new FormData(form);

            axios.post("{{ route('store.professional') }}", formData, {
                headers: { 'Accept': 'application/json' }
            })
            .then(response => {
                successDiv.innerText = response.data.message || 'Expert invited successfully!';
                successDiv.classList.remove('hidden');
                form.reset();
                setTimeout(() => { window.location.reload(); }, 1000);
            })
            .catch(error => {
                submitBtn.disabled = false;
                loader.classList.add('hidden');
                if (error.response && error.response.status === 422) {
                    let errors = error.response.data.errors;
                    for (const [key, value] of Object.entries(errors)) {
                        let errorSpan = document.querySelector(`.${key}_error`);
                        if (errorSpan) errorSpan.innerText = value[0];
                    }
                } else {
                    errorDiv.innerText = "Something went wrong. Please try again.";
                    errorDiv.classList.remove('hidden');
                }
            });
        });
    });

    // Modal Helpers
    function openCreateExpertModal() {
        document.getElementById('createExpertForm').reset();
        document.getElementById('createErrorMessage').classList.add('hidden');
        document.getElementById('createSuccessMessage').classList.add('hidden');
        document.querySelectorAll('.error-text').forEach(el => el.innerText = '');
        document.getElementById('create-expert-modal').classList.remove('hidden');
    }

    function closeCreateExpertModal() {
        document.getElementById('create-expert-modal').classList.add('hidden');
    }
</script>
@endpush