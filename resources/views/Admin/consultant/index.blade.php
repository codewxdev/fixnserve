@extends('layouts.app')

@section('head')
{{-- Font Awesome CDN Link for Icons --}}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
    integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
@endsection

@section('content')
<div class="space-y-6 px-4 sm:px-6 lg:px-8">
    <header class="flex items-center justify-between pt-4">
        <div class="flex flex-col">
            <nav class="flex" aria-label="Breadcrumb">
                <ol role="list" class="flex items-center space-x-2 text-sm text-gray-500">
                    <li><a href="#" class="hover:text-gray-700 flex items-center"><i
                                class="fa-solid fa-tachometer-alt w-4 h-4 mr-1"></i> Dashboard</a></li>
                    <li class="text-gray-400">/</li>
                    <li><span class="text-indigo-600 font-medium flex items-center"><i
                                class="fa-solid fa-user-check w-4 h-4 mr-1"></i> Consultant Management</span></li>
                </ol>
            </nav>
            <h1 class="text-3xl font-bold tracking-tight text-gray-900 mt-2">Consultant Management</h1>
            <p class="text-lg text-gray-500">Manage expert consultants, schedules, sessions, and recordings.</p>
        </div>
        <div>
            {{-- Button with hover animation --}}
            <button type="button" onclick="openAddModal()"
                class="inline-flex items-center rounded-lg bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow-md hover:bg-indigo-700 hover:shadow-lg transition-all duration-200 transform hover:-translate-y-0.5">
                <i class="fa-solid fa-user-plus w-4 h-4 mr-2"></i> Add Consultant
            </button>
        </div>
    </header>

    <section id="analytics-summary">
        <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4 xl:grid-cols-4">
            @php
            // Static Analytics
            $widgets = [
                ['title' => 'Total Consultants', 'value' => $consultants->count(), 'icon' => 'users', 'color' => 'indigo'],
                ['title' => 'Active Now', 'value' => 'NaN', 'icon' => 'user-check', 'color' => 'green'],
                ['title' => "Today's Sessions", 'value' => 'NaN', 'icon' => 'calendar-check', 'color' => 'blue'],
                ['title' => 'Completed (YTD)', 'value' => 'NaN', 'icon' => 'check-circle', 'color' => 'teal'],
                ['title' => 'Billable Hours', 'value' => 'NaN', 'icon' => 'clock', 'color' => 'cyan'],
                ['title' => 'Disputes/No-show', 'value' => 'NaN', 'icon' => 'exclamation-triangle', 'color' => 'orange'],
                ['title' => 'Pending Refunds', 'value' => 'NaN', 'icon' => 'undo', 'color' => 'red'],
                ['title' => 'Verified (KYC)', 'value' => 'NaN', 'icon' => 'shield-alt', 'color' => 'purple'],
            ];
            @endphp
            @foreach ($widgets as $widget)
            <div
                class="bg-white p-5 rounded-xl shadow-lg border-t-4 border-{{ $widget['color'] }}-500 transition duration-300 hover:shadow-xl transform hover:-translate-y-0.5">
                <div class="flex items-center justify-between">
                    <p class="text-sm font-medium text-gray-500 truncate">{{ $widget['title'] }}</p>
                    <i class="fa-solid fa-{{ $widget['icon'] }} w-5 h-5 text-{{ $widget['color'] }}-500"></i>
                </div>
                <div class="mt-1">
                    <p class="text-2xl font-bold text-gray-900">{{ $widget['value'] }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </section>

    <section id="sticky-filters" class="sticky top-0 z-10 bg-white pt-4 -mt-4 shadow-sm rounded-lg">
        {{-- Functional Filter Bar --}}
        <div class="flex flex-col md:flex-row space-y-4 md:space-y-0 md:space-x-4 p-4 bg-white rounded-lg border border-gray-100 shadow-sm">
            <div class="relative flex-grow">
                <i class="fa-solid fa-search w-4 h-4 absolute top-1/2 left-3 transform -translate-y-1/2 text-gray-400"></i>
                <input type="text" id="searchInput" placeholder="Search consultants..."
                    class="pl-10 pr-4 py-2 w-full rounded-lg border border-gray-300 focus:ring-indigo-500 focus:border-indigo-500 transition duration-150 text-sm">
            </div>
            
            {{-- NEW: Subscription Filter --}}
            <select id="subscriptionFilter"
                class="rounded-lg px-3 py-2 border border-gray-300 text-sm focus:ring-indigo-500 focus:border-indigo-500">
                <option value="all">All Plans</option>
                <option value="subscribed">Premium (Subscribed)</option>
                <option value="free">Standard (Free)</option>
            </select>

            <select id="statusFilter"
                class="rounded-lg px-3 py-2 border border-gray-300 text-sm focus:ring-indigo-500 focus:border-indigo-500">
                <option value="all">All Status</option>
                <option value="active">Active</option>
                <option value="suspend">Suspended</option>
            </select>
            
            <button type="button" id="resetFilters"
                class="flex items-center justify-center rounded-lg border border-gray-300 px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 transition duration-150">
                <i class="fa-solid fa-rotate-right w-4 h-4 mr-2"></i> Reset
            </button>
        </div>
    </section>

   <section id="consultant-list">
        <div class="flow-root mt-6">
            <div class="rounded-xl shadow-lg ring-1 ring-black ring-opacity-5 overflow-hidden">
                <div class="min-w-full">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50 sticky z-5">
                            <tr>
                                <th scope="col" class="py-3.5 pl-6 pr-3 text-left text-sm font-semibold text-gray-900">Basic Info</th>
                                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Consultation Controls</th>
                                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Performance</th>
                                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Media/Recordings</th>
                                <th scope="col" class="relative py-3.5 pl-3 pr-6 text-right"><span class="">Actions</span></th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 bg-white" id="consultants-table-body">
                            @forelse ($consultants as $consultant)
                            @php
                                // --- SUBSCRIPTION LOGIC (Deterministic) ---
                                $hasSub = ($consultant->id % 2 != 0); 
                                $planName = $hasSub ? 'Executive Partner' : 'Standard';
                                $subStatus = $hasSub ? 'subscribed' : 'free';

                                // Data Preparation for JS SlideOver
                                $jsData = [
                                    'id' => $consultant->id,
                                    'name' => $consultant->name,
                                    'email' => $consultant->email,
                                    'status' => $consultant->status,
                                    // Missing fields in DB -> set to NaN/N/A
                                    'expertise' => 'NaN', 
                                    'rate' => 'NaN',
                                    'rating' => 'NaN',
                                    'sessions' => 'NaN',
                                    'wallet' => 'NaN',
                                    'recordings' => 0,
                                    'phone' => $consultant->phone ?? 'N/A',
                                    // Subscription Data
                                    'subscription' => [
                                        'has_plan' => $hasSub,
                                        'plan_name' => $planName,
                                        'expires_at' => now()->addDays(30)->format('M d, Y'),
                                        'progress' => 75
                                    ],
                                ];
                                
                                // Status styling
                                $statusClass = match($consultant->status) {
                                    'active' => 'bg-green-100 text-green-800',
                                    'suspend' => 'bg-red-100 text-red-800',
                                    default => 'bg-gray-100 text-gray-800',
                                };
                            @endphp
                            <tr class="consultant-row hover:bg-indigo-50/50 transition duration-150 group"
                                data-name="{{ strtolower($consultant->name) }}"
                                data-status="{{ strtolower($consultant->status) }}"
                                data-subscription="{{ $subStatus }}"> {{-- Added Data Attribute --}}

                                {{-- 1. Basic Info --}}
                                <td class="whitespace-nowrap py-4 pl-6 pr-3 text-sm">
                                    <div class="flex items-center">
                                        <div class="h-10 w-10 flex-shrink-0 relative">
                                            @if($consultant->image)
                                                <img class="h-10 w-10 rounded-full object-cover border border-gray-200" src="{{ asset($consultant->image) }}" alt="">
                                            @else
                                                <div class="h-10 w-10 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-700 font-bold">
                                                    {{ substr($consultant->name, 0, 1) }}
                                                </div>
                                            @endif
                                            
                                            {{-- STAR ICON for Subscribers --}}
                                            @if($hasSub)
                                            <div class="absolute -top-1 -right-1 h-4 w-4 bg-yellow-400 text-white rounded-full border-2 border-white shadow-sm flex items-center justify-center" title="Premium Consultant">
                                                <i class="fa-solid fa-star text-[8px]"></i>
                                            </div>
                                            @endif
                                        </div>
                                        <div class="ml-4">
                                            <div class="font-medium text-gray-900 search-name">{{ $consultant->name }}</div>
                                            <div class="text-gray-500 text-xs mt-1">Specialty:
                                                <span class="font-semibold">NaN</span>
                                            </div>
                                        </div>
                                    </div>
                                </td>

                                {{-- 2. Consultation Controls --}}
                                <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                    <div class="space-y-1">
                                        <div class="font-medium text-gray-900 flex items-center">
                                            <i class="fa-solid fa-calendar-days w-4 h-4 mr-1 text-indigo-500"></i>
                                            Next: <strong class="ml-1">NaN</strong>
                                        </div>
                                        <div class="text-gray-500">Rate: <strong>$NaN/hr</strong></div>
                                        <span class="inline-flex items-center rounded-full px-2 py-0.5 text-xs font-medium {{ $statusClass }}">
                                            {{ ucfirst($consultant->status) }}
                                        </span>
                                    </div>
                                </td>

                                {{-- 3. Performance --}}
                                <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                    <div class="space-y-1">
                                        <div class="font-medium text-gray-900 flex items-center">
                                            <i class="fa-solid fa-star w-4 h-4 mr-1 text-yellow-400"></i>
                                            <strong class="ml-1">NaN</strong>
                                            <span class="text-gray-400 font-normal ml-1">(NaN Reviews)</span>
                                        </div>
                                        <div>Total Sessions: <strong>NaN</strong></div>
                                    </div>
                                </td>

                                {{-- 4. Media/Recordings --}}
                                <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                    <div class="space-y-2">
                                        <div class="flex items-center text-gray-700">
                                            <i class="fa-solid fa-microphone-lines w-4 h-4 mr-2 text-gray-400"></i>
                                            <span>Audio Logs: <strong>NaN</strong></span>
                                        </div>
                                        <div class="flex items-center text-gray-700">
                                            <i class="fa-solid fa-video w-4 h-4 mr-2 text-gray-400"></i>
                                            <span>Video Sessions: <strong>NaN</strong></span>
                                        </div>
                                    </div>
                                </td>

                                {{-- 5. Actions --}}
                                <td class="relative whitespace-nowrap py-4 pl-3 pr-6 text-right text-sm font-medium">
                                    <div class="flex items-center justify-end space-x-3">
                                        <button onclick="openSlideOver({{ json_encode($jsData) }})" class="text-indigo-600 hover:text-indigo-900 transition-colors bg-indigo-50 p-2 rounded-full" title="View Details">
                                            <i class="fa-solid fa-eye text-lg"></i>
                                        </button>
                                        <button class="text-gray-400 hover:text-indigo-600 transition-colors" title="Edit">
                                            <i class="fa-regular fa-pen-to-square text-lg"></i>
                                        </button>
                                        <button class="text-gray-400 hover:text-red-600 transition-colors" title="Delete">
                                            <i class="fa-regular fa-trash-can text-lg"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            {{-- Empty State --}}
                            <tr>
                                <td colspan="5" class="px-6 py-10 text-center text-gray-500">
                                    <div class="flex flex-col items-center justify-center">
                                        <i class="fa-solid fa-magnifying-glass text-4xl text-gray-300 mb-3"></i>
                                        <p class="text-lg font-medium text-gray-900">No consultants found</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            {{-- Count Display --}}
            <div class="mt-4 text-sm text-gray-500 text-center">
                 Showing <span id="showing-count">{{ $consultants->count() }}</span> consultants
            </div>
        </div>
    </section>
</div>

{{-- ========================================== --}}
{{-- DETAIL SLIDE-OVER (Dynamic Content) --}}
{{-- ========================================== --}}
<div id="consultant-detail-slideover" class="relative z-50 invisible" aria-labelledby="slide-over-title" role="dialog" aria-modal="true">
    
    {{-- Backdrop with fade transition --}}
    <div id="slideover-backdrop" class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity duration-500 ease-in-out opacity-0 backdrop-blur-sm" onclick="closeSlideOver()"></div>

    <div class="fixed inset-0 overflow-hidden pointer-events-none">
        <div class="absolute inset-0 overflow-hidden">
            <div class="pointer-events-none fixed inset-y-0 right-0 flex max-w-full pl-10">
                
                {{-- Panel with Slide transition --}}
                <div id="slideover-panel" class="pointer-events-auto w-screen max-w-2xl transform transition ease-in-out duration-500 translate-x-full">
                    <div class="flex h-full flex-col overflow-y-scroll bg-white shadow-2xl">

                        {{-- Header --}}
                        <div class="sticky top-0 bg-white border-b border-gray-200 px-6 py-6 z-10">
                            <div class="flex items-start justify-between">
                                <h2 class="text-2xl font-bold text-gray-900" id="slide-over-title">...</h2>
                                <div class="ml-3 flex h-7 items-center">
                                    <button type="button" class="rounded-md bg-white text-gray-400 hover:text-gray-500" onclick="closeSlideOver()">
                                        <i class="fa-solid fa-times h-6 w-6"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="mt-2 flex items-center space-x-2">
                                <span class="inline-flex items-center rounded-full bg-green-100 px-3 py-0.5 text-sm font-medium text-green-800">
                                    <i class="fa-solid fa-shield-alt w-4 h-4 mr-1"></i> <span id="slide-over-status">Verified Expert</span>
                                </span>
                                <span class="text-sm text-gray-500">ID: <span id="slide-over-id">...</span></span>
                            </div>
                        </div>

                        {{-- Detailed Content --}}
                        <div class="relative flex-1 px-6 py-6">
                            <div class="space-y-8">

                                <section>
                                    <h3 class="text-lg font-semibold text-gray-900 border-b pb-2 mb-4 flex items-center">
                                        <i class="fa-solid fa-user w-5 h-5 mr-2 text-indigo-500"></i> Profile Overview
                                    </h3>
                                    <p class="text-sm text-gray-600 mb-4">"No bio available (NaN)."</p>
                                    <div class="grid grid-cols-2 gap-4">
                                        <div>
                                            <div class="text-sm font-medium text-gray-500">Email</div>
                                            <div class="font-bold text-gray-900" id="slide-over-email">...</div>
                                        </div>
                                        <div>
                                            <div class="text-sm font-medium text-gray-500">Rating</div>
                                            <div class="font-bold text-gray-900 flex items-center">
                                                <i class="fa-solid fa-star w-4 h-4 mr-1 text-yellow-400 fill-yellow-400"></i>
                                                NaN
                                            </div>
                                        </div>
                                    </div>
                                </section>

                                <section>
                                    <h3 class="text-lg font-semibold text-gray-900 border-b pb-2 mb-4 flex items-center">
                                        <i class="fa-solid fa-calendar-alt w-5 h-5 mr-2 text-indigo-500"></i> Schedule Management
                                    </h3>
                                    <div class="bg-gray-50 p-4 rounded-lg">
                                        <p class="text-sm font-medium text-gray-700 mb-2">Weekly Availability Calendar</p>
                                        <p class="text-xs text-gray-500 italic">No schedule data available (NaN).</p>
                                    </div>
                                </section>

                                <section>
                                    <h3 class="text-lg font-semibold text-gray-900 border-b pb-2 mb-4 flex items-center">
                                        <i class="fa-solid fa-wallet w-5 h-5 mr-2 text-indigo-500"></i> Earnings & Wallet
                                    </h3>
                                    <div class="grid grid-cols-3 gap-4 text-center mb-4">
                                        <div class="bg-indigo-50 p-3 rounded-lg">
                                            <div class="text-xs text-gray-500">Revenue</div>
                                            <div class="font-bold">$NaN</div>
                                        </div>
                                        <div class="bg-indigo-50 p-3 rounded-lg">
                                            <div class="text-xs text-gray-500">Pending</div>
                                            <div class="font-bold">$NaN</div>
                                        </div>
                                        <div class="bg-indigo-50 p-3 rounded-lg">
                                            <div class="text-xs text-gray-500">Wallet</div>
                                            <div class="font-bold">$NaN</div>
                                        </div>
                                    </div>
                                </section>

                                {{-- SUBSCRIPTION SECTION (Bottom) --}}
                                <section id="so-subscription-section" class="pt-6 border-t border-gray-100">
                                    <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                                        <i class="fa-solid fa-crown w-5 h-5 mr-2 text-yellow-500"></i> Subscription Status
                                    </h3>
                                    <div id="so-subscription-container"></div>
                                </section>

                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- ========================================== --}}
{{-- ADD CONSULTANT MODAL (Unchanged) --}}
{{-- ========================================== --}}
<div id="add-consultant-modal" class="relative z-50 invisible" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    {{-- Backdrop with Fade --}}
    <div id="modal-backdrop" class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity duration-300 ease-out opacity-0 backdrop-blur-sm" onclick="closeAddModal()"></div>

    <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
        <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
            <div id="modal-panel" class="relative transform overflow-hidden rounded-xl bg-white text-left shadow-2xl transition-all duration-300 ease-out scale-95 opacity-0 sm:my-8 sm:w-full sm:max-w-lg">
                <div class="bg-indigo-600 px-4 py-4 sm:px-6 flex justify-between items-center">
                    <h3 class="text-lg font-bold leading-6 text-white flex items-center" id="modal-title">
                        <i class="fa-solid fa-user-plus mr-2"></i> Onboard Consultant
                    </h3>
                    <button onclick="closeAddModal()" class="text-indigo-100 hover:text-white transition">
                        <i class="fa-solid fa-times text-lg"></i>
                    </button>
                </div>

                <form id="createConsultantForm"> @csrf
                    <div class="px-4 py-6 sm:p-6">
                        <div id="successMessage" class="hidden mb-4 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded relative"></div>
                        <div id="errorMessage" class="hidden mb-4 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded relative"></div>

                        <div class="space-y-5">
                            <div>
                                <label for="name" class="block text-sm font-semibold leading-6 text-gray-900">Full Name</label>
                                <div class="relative mt-2 rounded-md shadow-sm">
                                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                        <i class="fa-solid fa-user text-gray-400"></i>
                                    </div>
                                    <input type="text" name="name" id="name" class="block w-full rounded-md border-0 py-2.5 pl-10 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6 transition-shadow" placeholder="e.g. Jacky Smith">
                                </div>
                                <span class="text-xs text-red-500 error-text name_error"></span>
                            </div>
                            <div>
                                <label for="email" class="block text-sm font-semibold leading-6 text-gray-900">Email Address</label>
                                <div class="relative mt-2 rounded-md shadow-sm">
                                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                        <i class="fa-solid fa-envelope text-gray-400"></i>
                                    </div>
                                    <input type="email" name="email" id="email" class="block w-full rounded-md border-0 py-2.5 pl-10 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6 transition-shadow" placeholder="jacky@example.com">
                                </div>
                                <span class="text-xs text-red-500 error-text email_error"></span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="bg-gray-50 px-4 py-4 sm:flex sm:flex-row-reverse sm:px-6 border-t border-gray-100">
                        <button type="button" id="submitBtn" class="inline-flex w-full justify-center rounded-lg bg-indigo-600 px-5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 transition-colors sm:ml-3 sm:w-auto">
                            <i class="fa-solid fa-spinner fa-spin hidden mr-2" id="loadingIcon"></i>
                            Save Consultant
                        </button>
                        <button type="button" class="mt-3 inline-flex w-full justify-center rounded-lg bg-white px-5 py-2.5 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 transition-colors sm:mt-0 sm:w-auto" onclick="closeAddModal()">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        
        // ==========================================
        // 1. FILTER LOGIC
        // ==========================================
        const searchInput = document.getElementById('searchInput');
        const subscriptionFilter = document.getElementById('subscriptionFilter');
        const statusFilter = document.getElementById('statusFilter');
        const resetBtn = document.getElementById('resetFilters');
        const tableRows = document.querySelectorAll('.consultant-row');
        const showingCount = document.getElementById('showing-count');

        function applyFilters() {
            const search = searchInput.value.toLowerCase();
            const sub = subscriptionFilter.value.toLowerCase();
            const status = statusFilter.value.toLowerCase();
            let visible = 0;

            tableRows.forEach(row => {
                const name = row.dataset.name.toLowerCase();
                const rowSub = row.dataset.subscription;
                const rowStatus = row.dataset.status.toLowerCase();

                const matchesSearch = name.includes(search);
                const matchesSub = sub === 'all' || rowSub === sub;
                const matchesStatus = status === 'all' || rowStatus === status;

                if(matchesSearch && matchesSub && matchesStatus) {
                    row.classList.remove('hidden');
                    visible++;
                } else {
                    row.classList.add('hidden');
                }
            });

            if(showingCount) showingCount.innerText = visible;
        }

        searchInput.addEventListener('input', applyFilters);
        subscriptionFilter.addEventListener('change', applyFilters);
        statusFilter.addEventListener('change', applyFilters);
        
        resetBtn.addEventListener('click', function() {
            searchInput.value = '';
            subscriptionFilter.value = 'all';
            statusFilter.value = 'all';
            applyFilters();
        });
    });

    // ==========================================
    // 2. SLIDE OVER LOGIC (DYNAMIC DATA)
    // ==========================================
    const slideOver = document.getElementById('consultant-detail-slideover');
    const slideOverBackdrop = document.getElementById('slideover-backdrop');
    const slideOverPanel = document.getElementById('slideover-panel');
    const slideOverTitle = document.getElementById('slide-over-title');
    const slideOverStatus = document.getElementById('slide-over-status');
    const slideOverId = document.getElementById('slide-over-id');
    const slideOverEmail = document.getElementById('slide-over-email');
    const subContainer = document.getElementById('so-subscription-container');

    function openSlideOver(data) {
        // Populate Basic Data
        slideOverTitle.textContent = data.name;
        slideOverStatus.textContent = data.status.charAt(0).toUpperCase() + data.status.slice(1);
        slideOverId.textContent = 'CNTR-' + data.id;
        slideOverEmail.textContent = data.email;

        // Populate Subscription Card
        if (data.subscription && data.subscription.has_plan) {
            subContainer.innerHTML = `
            <div class="relative overflow-hidden bg-gray-900 p-6 rounded-2xl shadow-xl text-white">
                <div class="absolute top-0 right-0 -mt-4 -mr-4 w-32 h-32 bg-indigo-500 rounded-full opacity-20 blur-2xl"></div>
                <div class="flex justify-between items-start relative z-10">
                    <div>
                        <p class="text-indigo-300 text-xs font-bold uppercase tracking-wider mb-1">Current Plan</p>
                        <h2 class="text-2xl font-extrabold text-white tracking-tight">${data.subscription.plan_name}</h2>
                    </div>
                    <div class="bg-indigo-500/20 border border-indigo-400/30 p-2 rounded-lg">
                        <i class="fa-solid fa-crown text-indigo-300 text-lg"></i>
                    </div>
                </div>
                <div class="mt-6 space-y-3">
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-400">Validity</span>
                        <span class="text-white font-medium">${data.subscription.progress}% Remaining</span>
                    </div>
                    <div class="w-full bg-gray-700 rounded-full h-2">
                        <div class="bg-gradient-to-r from-indigo-500 to-purple-500 h-2 rounded-full" style="width: ${data.subscription.progress}%"></div>
                    </div>
                    <div class="flex justify-between text-xs mt-1">
                        <span class="text-gray-500">Auto-renews</span>
                        <span class="text-indigo-300 font-medium">Expires: ${data.subscription.expires_at}</span>
                    </div>
                </div>
            </div>`;
        } else {
            subContainer.innerHTML = `
            <div class="flex flex-col items-center justify-center p-6 bg-gray-50 border border-dashed border-gray-300 rounded-xl text-center">
                <div class="h-12 w-12 bg-white rounded-full flex items-center justify-center mb-3 shadow-sm text-gray-400">
                    <i class="fa-solid fa-crown text-xl"></i>
                </div>
                <h3 class="text-sm font-bold text-gray-800">No Active Plan</h3>
                <p class="text-gray-500 text-xs mt-1">On Free Tier.</p>
            </div>`;
        }

        // Transitions
        slideOver.classList.remove('invisible');
        setTimeout(() => {
            slideOverBackdrop.classList.remove('opacity-0');
            slideOverBackdrop.classList.add('opacity-100');
            slideOverPanel.classList.remove('translate-x-full');
            slideOverPanel.classList.add('translate-x-0');
        }, 10);
    }

    function closeSlideOver() {
        slideOverBackdrop.classList.remove('opacity-100');
        slideOverBackdrop.classList.add('opacity-0');
        slideOverPanel.classList.remove('translate-x-0');
        slideOverPanel.classList.add('translate-x-full');
        setTimeout(() => {
            slideOver.classList.add('invisible');
        }, 500);
    }

    // ==========================================
    // 3. MODAL & AJAX LOGIC
    // ==========================================
    const addModal = document.getElementById('add-consultant-modal');
    const modalBackdrop = document.getElementById('modal-backdrop');
    const modalPanel = document.getElementById('modal-panel');
    const submitBtn = document.getElementById('submitBtn');
    const loadingIcon = document.getElementById('loadingIcon');
    const successMessage = document.getElementById('successMessage');
    const errorMessage = document.getElementById('errorMessage');

    function openAddModal() {
        addModal.classList.remove('invisible');
        document.getElementById('createConsultantForm').reset();
        successMessage.classList.add('hidden');
        errorMessage.classList.add('hidden');
        document.querySelectorAll('.error-text').forEach(el => el.textContent = '');

        setTimeout(() => {
            modalBackdrop.classList.remove('opacity-0');
            modalBackdrop.classList.add('opacity-100');
            modalPanel.classList.remove('opacity-0', 'scale-95');
            modalPanel.classList.add('opacity-100', 'scale-100');
        }, 10);
    }

    function closeAddModal() {
        modalBackdrop.classList.remove('opacity-100');
        modalBackdrop.classList.add('opacity-0');
        modalPanel.classList.remove('opacity-100', 'scale-100');
        modalPanel.classList.add('opacity-0', 'scale-95');
        setTimeout(() => {
            addModal.classList.add('invisible');
        }, 300);
    }

    submitBtn.addEventListener('click', function(e) {
        e.preventDefault();
        
        submitBtn.disabled = true;
        loadingIcon.classList.remove('hidden');
        successMessage.classList.add('hidden');
        errorMessage.classList.add('hidden');
        document.querySelectorAll('.error-text').forEach(el => el.textContent = '');

        const formData = new FormData(document.getElementById('createConsultantForm'));

        axios.post("{{ route('store.consultant') }}", formData)
            .then(response => {
                successMessage.textContent = response.data.message;
                successMessage.classList.remove('hidden');
                document.getElementById('createConsultantForm').reset();
                setTimeout(() => {
                    window.location.reload();
                }, 1000);
            })
            .catch(error => {
                submitBtn.disabled = false;
                loadingIcon.classList.add('hidden');
                
                if (error.response && error.response.status === 422) {
                    const errors = error.response.data.errors;
                    Object.keys(errors).forEach(key => {
                        const errorSpan = document.querySelector(`.${key}_error`);
                        if(errorSpan) errorSpan.textContent = errors[key][0];
                    });
                } else {
                    errorMessage.textContent = error.response?.data?.message || 'Something went wrong.';
                    errorMessage.classList.remove('hidden');
                }
            });
    });
</script>
@endpush