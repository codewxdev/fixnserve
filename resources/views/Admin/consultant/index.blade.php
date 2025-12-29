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
        <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4 xl:grid-cols-8">
            @php
            $widgets = [
                ['title' => 'Total Consultants', 'value' => '124', 'icon' => 'users', 'color' => 'indigo'],
                ['title' => 'Active Now', 'value' => '18', 'icon' => 'user-check', 'color' => 'green'],
                ['title' => "Today's Sessions", 'value' => '42', 'icon' => 'calendar-check', 'color' => 'blue'],
                ['title' => 'Completed (YTD)', 'value' => '3,850', 'icon' => 'check-circle', 'color' => 'teal'],
                ['title' => 'Billable Hours', 'value' => '845.5', 'icon' => 'clock', 'color' => 'cyan'],
                ['title' => 'Disputes/No-show', 'value' => '3', 'icon' => 'exclamation-triangle', 'color' => 'orange'],
                ['title' => 'Pending Refunds', 'value' => '$450', 'icon' => 'undo', 'color' => 'red'],
                ['title' => 'Verified (KYC)', 'value' => '118', 'icon' => 'shield-alt', 'color' => 'purple'],
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
        <form method="GET" action="{{ url()->current() }}"
            class="flex space-x-4 p-4 bg-white rounded-lg border border-gray-100 shadow-sm">
            <div class="relative flex-grow">
                <i class="fa-solid fa-search w-4 h-4 absolute top-1/2 left-3 transform -translate-y-1/2 text-gray-400"></i>
                <input type="text" name="search" placeholder="Search Jacky, Mike, etc..."
                    value="{{ request('search') }}"
                    class="pl-10 pr-4 py-2 w-full rounded-lg border border-gray-300 focus:ring-indigo-500 focus:border-indigo-500 transition duration-150 text-sm">
            </div>
            <select name="expertise"
                class="rounded-lg px-3 border border-gray-300 text-sm focus:ring-indigo-500 focus:border-indigo-500">
                <option value="">All Expertise</option>
                <option value="Finance" {{ request('expertise') == 'Finance' ? 'selected' : '' }}>Finance</option>
                <option value="Technology" {{ request('expertise') == 'Technology' ? 'selected' : '' }}>Technology</option>
                <option value="Legal" {{ request('expertise') == 'Legal' ? 'selected' : '' }}>Legal</option>
                <option value="Health" {{ request('expertise') == 'Health' ? 'selected' : '' }}>Health</option>
            </select>
            <select name="rating"
                class="rounded-lg px-3 border border-gray-300 text-sm focus:ring-indigo-500 focus:border-indigo-500">
                <option value="">All Ratings</option>
                <option value="4.5" {{ request('rating') == '4.5' ? 'selected' : '' }}>Top Rated (4.5+)</option>
            </select>

            <button type="button"
                class="flex items-center rounded-lg border border-gray-300 px-3 py-2 text-sm text-gray-700 hover:bg-gray-50 transition duration-150">
                <i class="fa-solid fa-clock w-4 h-4 mr-1"></i> Availability
            </button>

            <button type="submit"
                class="flex items-center rounded-lg border border-transparent bg-indigo-600 px-3 py-2 text-sm text-white shadow-sm hover:bg-indigo-700 transition duration-150">
                <i class="fa-solid fa-filter w-4 h-4 mr-2"></i> Apply
            </button>

            @if (request()->hasAny(['search', 'expertise', 'rating']))
            <a href="{{ url()->current() }}"
                class="flex items-center rounded-lg border border-gray-300 bg-gray-50 px-3 py-2 text-sm text-gray-600 hover:bg-gray-100 transition duration-150">
                <i class="fa-solid fa-trash w-4 h-4"></i>
            </a>
            @endif
        </form>
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
                        <tbody class="divide-y divide-gray-200 bg-white">
                            {{-- CHANGED: Added PHP Logic to actually FILTER the static data --}}
                            @php
                                // 1. Define the raw data
                                $allConsultants = [
                                    ['name' => 'Jacky Smith', 'expertise' => 'Finance', 'rating' => '4.9'],
                                    ['name' => 'Mike Ross', 'expertise' => 'Legal', 'rating' => '4.8'],
                                    ['name' => 'Jessica Chen', 'expertise' => 'Technology', 'rating' => '5.0'],
                                    ['name' => 'Dr. Alex House', 'expertise' => 'Health', 'rating' => '4.7'],
                                    ['name' => 'Sarah Connor', 'expertise' => 'Technology', 'rating' => '4.6'],
                                ];

                                // 2. Filter the data based on Request parameters
                                $filteredConsultants = collect($allConsultants)->filter(function ($item) {
                                    // Search Filter (Case insensitive)
                                    if (request('search')) {
                                        $search = strtolower(request('search'));
                                        $name = strtolower($item['name']);
                                        $expert = strtolower($item['expertise']);
                                        if (!str_contains($name, $search) && !str_contains($expert, $search)) {
                                            return false; 
                                        }
                                    }

                                    // Expertise Filter
                                    if (request('expertise') && $item['expertise'] !== request('expertise')) {
                                        return false;
                                    }

                                    // Rating Filter (>= selected)
                                    if (request('rating') && $item['rating'] < request('rating')) {
                                        return false;
                                    }

                                    return true;
                                });
                            @endphp

                            {{-- 3. Loop through the FILTERED results --}}
                            @forelse ($filteredConsultants as $consultant)
                            <tr class="hover:bg-indigo-50/50 transition duration-150 group">
                                {{-- 1. Basic Info --}}
                                <td class="whitespace-nowrap py-4 pl-6 pr-3 text-sm">
                                    <div class="flex items-center">
                                        <img class="h-10 w-10 rounded-full object-cover border border-gray-200"
                                            src="https://ui-avatars.com/api/?name={{ urlencode($consultant['name']) }}&background=random&color=fff&size=128"
                                            alt="">
                                        <div class="ml-4">
                                            <div class="font-medium text-gray-900">{{ $consultant['name'] }}</div>
                                            <div class="text-gray-500 text-xs mt-1">Specialty:
                                                <span class="font-semibold">{{ $consultant['expertise'] }}</span>
                                            </div>
                                            <div class="flex space-x-1 mt-1">
                                                <span class="inline-flex items-center rounded-full bg-blue-100 px-2 py-0.5 text-xs font-medium text-blue-800">
                                                    {{ $consultant['expertise'] }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </td>

                                {{-- 2. Consultation Controls --}}
                                <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                    <div class="space-y-1">
                                        <div class="font-medium text-gray-900 flex items-center">
                                            <i class="fa-solid fa-calendar-days w-4 h-4 mr-1 text-indigo-500"></i>
                                            Next: <strong class="ml-1">Today, 2:00 PM</strong>
                                        </div>
                                        <div class="text-gray-500">Rate: <strong>$150/hr</strong></div>
                                        <span class="inline-flex items-center rounded-full bg-green-100 px-2 py-0.5 text-xs font-medium text-green-800">
                                            <i class="fa-solid fa-check w-3 h-3 mr-1"></i> Available
                                        </span>
                                    </div>
                                </td>

                                {{-- 3. Performance --}}
                                <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                    <div class="space-y-1">
                                        <div class="font-medium text-gray-900 flex items-center">
                                            <i class="fa-solid fa-star w-4 h-4 mr-1 text-yellow-400"></i>
                                            <strong class="ml-1">{{ $consultant['rating'] }}</strong>
                                            <span class="text-gray-400 font-normal ml-1">(120 Reviews)</span>
                                        </div>
                                        <div>Total Sessions: <strong>340</strong></div>
                                        <div class="text-xs text-red-500 flex items-center">
                                            <i class="fa-solid fa-ban w-3 h-3 mr-1"></i> No-shows: <strong>0</strong>
                                        </div>
                                    </div>
                                </td>

                                {{-- 4. Media/Recordings --}}
                                <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                    <div class="space-y-2">
                                        <div class="flex items-center text-gray-700">
                                            <i class="fa-solid fa-microphone-lines w-4 h-4 mr-2 text-gray-400"></i>
                                            <span>Audio Logs: <strong>12</strong></span>
                                        </div>
                                        <div class="flex items-center text-gray-700">
                                            <i class="fa-solid fa-video w-4 h-4 mr-2 text-gray-400"></i>
                                            <span>Video Sessions: <strong>5</strong></span>
                                        </div>
                                    </div>
                                </td>

                                {{-- 5. Actions --}}
                                <td class="relative whitespace-nowrap py-4 pl-3 pr-6 text-right text-sm font-medium">
                                    <div class="flex items-center justify-end space-x-3">
                                        <button onclick="openSlideOver('{{ $consultant['name'] }}')" class="text-indigo-600 hover:text-indigo-900 transition-colors bg-indigo-50 p-2 rounded-full" title="View Details">
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
                                        <p class="text-sm">Try adjusting your filters or search terms.</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
</div>

{{-- ========================================== --}}
{{-- DETAIL SLIDE-OVER (Restored Content + Animations) --}}
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
                                <h2 class="text-2xl font-bold text-gray-900" id="slide-over-title">Jacky Smith</h2>
                                <div class="ml-3 flex h-7 items-center">
                                    <button type="button" class="rounded-md bg-white text-gray-400 hover:text-gray-500" onclick="closeSlideOver()">
                                        <i class="fa-solid fa-times h-6 w-6"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="mt-2 flex items-center space-x-2">
                                <span class="inline-flex items-center rounded-full bg-green-100 px-3 py-0.5 text-sm font-medium text-green-800">
                                    <i class="fa-solid fa-shield-alt w-4 h-4 mr-1"></i> Verified Expert
                                </span>
                                <span class="text-sm text-gray-500">ID: CNTR-9921</span>
                            </div>
                        </div>

                        {{-- Restored Detailed Content --}}
                        <div class="relative flex-1 px-6 py-6">
                            <div class="space-y-8">

                                <section>
                                    <h3 class="text-lg font-semibold text-gray-900 border-b pb-2 mb-4 flex items-center">
                                        <i class="fa-solid fa-user w-5 h-5 mr-2 text-indigo-500"></i> Profile Overview
                                    </h3>
                                    <p class="text-sm text-gray-600 mb-4">"A senior Financial Analyst with 12+ years experience in Corporate Law and FinTech integration. Specialized in blockchain compliance and cross-border payments."</p>
                                    <div class="grid grid-cols-2 gap-4">
                                        <div>
                                            <div class="text-sm font-medium text-gray-500">Specialty</div>
                                            <div class="font-bold text-gray-900">Finance & Compliance</div>
                                        </div>
                                        <div>
                                            <div class="text-sm font-medium text-gray-500">Rating</div>
                                            <div class="font-bold text-gray-900 flex items-center">
                                                <i class="fa-solid fa-star w-4 h-4 mr-1 text-yellow-400 fill-yellow-400"></i>
                                                4.9
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
                                        <div class="grid grid-cols-3 gap-2 text-center text-xs mb-3">
                                            <div class="bg-white border p-2 rounded shadow-sm">Mon: 10am-2pm</div>
                                            <div class="bg-white border p-2 rounded shadow-sm">Tue: 9am-5pm</div>
                                            <div class="bg-white border p-2 rounded shadow-sm">Wed: 1pm-4pm</div>
                                        </div>
                                        <button class="text-sm text-indigo-600 hover:text-indigo-800 font-medium flex items-center">
                                            <i class="fa-solid fa-plus w-4 h-4 mr-1"></i> Add/Edit Slots
                                        </button>
                                    </div>
                                    <p class="text-xs text-orange-500 mt-2 flex items-center">
                                        <i class="fa-solid fa-exclamation-triangle w-4 h-4 mr-1"></i> **Warning:** Slot conflict detected on Tuesday, 3 PM.
                                    </p>
                                </section>

                                <section>
                                    <h3 class="text-lg font-semibold text-gray-900 border-b pb-2 mb-4 flex items-center">
                                        <i class="fa-solid fa-video w-5 h-5 mr-2 text-indigo-500"></i> Session Recordings
                                    </h3>
                                    <div class="space-y-3">
                                        <div class="flex items-center justify-between bg-gray-50 p-3 rounded-lg border">
                                            <div class="flex items-center space-x-3">
                                                <i class="fa-solid fa-film w-6 h-6 text-gray-500"></i>
                                                <span class="text-sm font-medium text-gray-800">2024-12-23 - Compliance Audit</span>
                                            </div>
                                            <div class="flex items-center space-x-2">
                                                <button class="text-indigo-600 hover:text-indigo-800 text-sm"><i class="fa-solid fa-play-circle w-5 h-5"></i></button>
                                                <button class="text-green-600 hover:text-green-800 text-sm"><i class="fa-solid fa-download w-5 h-5"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                </section>

                                <section>
                                    <h3 class="text-lg font-semibold text-gray-900 border-b pb-2 mb-4 flex items-center">
                                        <i class="fa-solid fa-slash w-5 h-5 mr-2 text-orange-500"></i> No-Show & Refund Rules
                                    </h3>
                                    <div class="bg-yellow-50 p-4 rounded-lg mb-4">
                                        <p class="font-medium text-sm text-yellow-800">No-Show Log Timeline (Last 5)</p>
                                        <ul class="text-xs text-gray-600 mt-2 list-disc list-inside space-y-1">
                                            <li>2025-11-15: Client NS. Penalty Applied: $50.</li>
                                            <li>2025-10-01: Consultant NS. Refund Triggered.</li>
                                        </ul>
                                    </div>
                                    <div class="flex items-center justify-between p-3 bg-white border rounded-lg shadow-sm">
                                        <div class="space-y-1">
                                            <p class="font-medium text-gray-900 flex items-center">
                                                <i class="fa-solid fa-undo w-4 h-4 mr-2 text-red-600"></i> **Auto-Refund Rule**
                                            </p>
                                            <p class="text-xs text-gray-500">Trigger 50% refund if session duration < 10 mins.</p>
                                        </div>
                                        <label for="refund-toggle" class="relative inline-flex cursor-pointer items-center">
                                            <input type="checkbox" id="refund-toggle" class="sr-only peer" checked>
                                            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-green-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-green-600"></div>
                                        </label>
                                    </div>
                                </section>

                                <section>
                                    <h3 class="text-lg font-semibold text-gray-900 border-b pb-2 mb-4 flex items-center">
                                        <i class="fa-solid fa-wallet w-5 h-5 mr-2 text-indigo-500"></i> Earnings & Wallet
                                    </h3>
                                    <div class="grid grid-cols-3 gap-4 text-center mb-4">
                                        <div class="bg-indigo-50 p-3 rounded-lg">
                                            <div class="text-xs text-gray-500">Revenue</div>
                                            <div class="font-bold">$24,500</div>
                                        </div>
                                        <div class="bg-indigo-50 p-3 rounded-lg">
                                            <div class="text-xs text-gray-500">Pending</div>
                                            <div class="font-bold">$450</div>
                                        </div>
                                        <div class="bg-indigo-50 p-3 rounded-lg">
                                            <div class="text-xs text-gray-500">Wallet</div>
                                            <div class="font-bold">$1,200</div>
                                        </div>
                                    </div>
                                </section>

                                <section>
                                    <h3 class="text-lg font-semibold text-gray-900 border-b pb-2 mb-4 flex items-center">
                                        <i class="fa-solid fa-gavel w-5 h-5 mr-2 text-red-500"></i> Admin Tools
                                    </h3>
                                    <div class="space-y-3">
                                        <button class="w-full justify-center flex items-center rounded-md bg-red-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-red-500 transition">
                                            <i class="fa-solid fa-ban w-4 h-4 mr-2"></i> Suspend Consultant Account
                                        </button>
                                        <button class="w-full justify-center flex items-center rounded-md bg-yellow-500 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-yellow-400 transition">
                                            <i class="fa-solid fa-lock w-4 h-4 mr-2"></i> Require Re-verification (KYC)
                                        </button>
                                    </div>
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
{{-- ADD CONSULTANT MODAL - MODERN & ANIMATED   --}}
{{-- ========================================== --}}
<div id="add-consultant-modal" class="relative z-50 invisible" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    {{-- Backdrop with Fade --}}
    <div id="modal-backdrop" class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity duration-300 ease-out opacity-0 backdrop-blur-sm" onclick="closeAddModal()"></div>

    <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
        <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
            
            {{-- Modal Panel with Scale & Fade --}}
            <div id="modal-panel" class="relative transform overflow-hidden rounded-xl bg-white text-left shadow-2xl transition-all duration-300 ease-out scale-95 opacity-0 sm:my-8 sm:w-full sm:max-w-lg">
                
                {{-- Modern Header --}}
                <div class="bg-indigo-600 px-4 py-4 sm:px-6 flex justify-between items-center">
                    <h3 class="text-lg font-bold leading-6 text-white flex items-center" id="modal-title">
                        <i class="fa-solid fa-user-plus mr-2"></i> Onboard Consultant
                    </h3>
                    <button onclick="closeAddModal()" class="text-indigo-100 hover:text-white transition">
                        <i class="fa-solid fa-times text-lg"></i>
                    </button>
                </div>

                <form action="#" method="POST"> @csrf
                    <div class="px-4 py-6 sm:p-6">
                        <div class="space-y-5">
                            
                            {{-- Modern Input: Name --}}
                            <div>
                                <label for="name" class="block text-sm font-semibold leading-6 text-gray-900">Full Name</label>
                                <div class="relative mt-2 rounded-md shadow-sm">
                                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                        <i class="fa-solid fa-user text-gray-400"></i>
                                    </div>
                                    <input type="text" name="name" id="name" class="block w-full rounded-md border-0 py-2.5 pl-10 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6 transition-shadow" placeholder="e.g. Jacky Smith">
                                </div>
                            </div>

                            {{-- Modern Input: Email --}}
                            <div>
                                <label for="email" class="block text-sm font-semibold leading-6 text-gray-900">Email Address</label>
                                <div class="relative mt-2 rounded-md shadow-sm">
                                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                        <i class="fa-solid fa-envelope text-gray-400"></i>
                                    </div>
                                    <input type="email" name="email" id="email" class="block w-full rounded-md border-0 py-2.5 pl-10 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6 transition-shadow" placeholder="jacky@example.com">
                                </div>
                            </div>

                            {{-- Grid for Select/Rate --}}
                            <div class="grid grid-cols-1 gap-x-6 gap-y-4 sm:grid-cols-2">
                                <div>
                                    <label for="expertise" class="block text-sm font-semibold leading-6 text-gray-900">Expertise</label>
                                    <div class="relative mt-2">
                                        <select id="expertise" name="expertise" class="block w-full rounded-md border-0 py-2.5 pl-3 pr-10 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                            <option>Finance</option>
                                            <option>Technology</option>
                                            <option>Legal</option>
                                            <option>Health</option>
                                        </select>
                                    </div>
                                </div>
                                <div>
                                    <label for="rate" class="block text-sm font-semibold leading-6 text-gray-900">Hourly Rate</label>
                                    <div class="relative mt-2 rounded-md shadow-sm">
                                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                            <span class="text-gray-500 sm:text-sm">$</span>
                                        </div>
                                        <input type="number" name="rate" id="rate" class="block w-full rounded-md border-0 py-2.5 pl-7 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" placeholder="0.00">
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    
                    {{-- Footer --}}
                    <div class="bg-gray-50 px-4 py-4 sm:flex sm:flex-row-reverse sm:px-6 border-t border-gray-100">
                        <button type="submit" class="inline-flex w-full justify-center rounded-lg bg-indigo-600 px-5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 transition-colors sm:ml-3 sm:w-auto">Save Consultant</button>
                        <button type="button" class="mt-3 inline-flex w-full justify-center rounded-lg bg-white px-5 py-2.5 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 transition-colors sm:mt-0 sm:w-auto" onclick="closeAddModal()">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    // ==========================================
    // SIDEBAR LOGIC WITH TRANSITIONS
    // ==========================================
    const slideOver = document.getElementById('consultant-detail-slideover');
    const slideOverBackdrop = document.getElementById('slideover-backdrop');
    const slideOverPanel = document.getElementById('slideover-panel');
    const slideOverTitle = document.getElementById('slide-over-title');

    function openSlideOver(name = null) {
        if(name) slideOverTitle.textContent = name;

        // Remove invisible first
        slideOver.classList.remove('invisible');

        // Add transitions after a tiny delay to allow DOM to render the block
        setTimeout(() => {
            slideOverBackdrop.classList.remove('opacity-0');
            slideOverBackdrop.classList.add('opacity-100');
            
            slideOverPanel.classList.remove('translate-x-full');
            slideOverPanel.classList.add('translate-x-0');
        }, 10);
    }

    function closeSlideOver() {
        // Reverse transitions
        slideOverBackdrop.classList.remove('opacity-100');
        slideOverBackdrop.classList.add('opacity-0');
        
        slideOverPanel.classList.remove('translate-x-0');
        slideOverPanel.classList.add('translate-x-full');

        // Wait for CSS transition (500ms) then hide element
        setTimeout(() => {
            slideOver.classList.add('invisible');
        }, 500);
    }

    // ==========================================
    // MODAL LOGIC WITH TRANSITIONS
    // ==========================================
    const addModal = document.getElementById('add-consultant-modal');
    const modalBackdrop = document.getElementById('modal-backdrop');
    const modalPanel = document.getElementById('modal-panel');

    function openAddModal() {
        addModal.classList.remove('invisible');
        
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
</script>
@endpush