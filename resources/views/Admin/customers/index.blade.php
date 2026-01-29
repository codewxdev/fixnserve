@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-slate-50 p-4 md:p-8 font-sans">

        {{-- Page Header --}}
        <header class="mb-8 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h1 class="text-3xl font-bold text-slate-800 tracking-tight">Customer Management</h1>
                <p class="mt-1 text-slate-500">Manage profiles, orders, and service history.</p>
            </div>

            <button onclick="openCreateModal()"
                class="flex items-center justify-center space-x-2 px-5 py-2.5 bg-indigo-600 text-white rounded-lg shadow-md hover:bg-indigo-700 hover:shadow-lg transition-all transform hover:-translate-y-0.5 focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6">
                    </path>
                </svg>
                <span class="font-medium">Add New Customer</span>
            </button>
        </header>

        {{-- Search & Filters --}}
        <div
            class="bg-white p-4 rounded-xl shadow-sm border border-slate-200 mb-6 flex flex-col lg:flex-row gap-4 items-center">
            <div class="relative flex-grow w-full lg:w-auto">
                <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                    <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </span>
                <input type="text" id="customerSearchInput"
                    class="w-full pl-10 pr-4 py-2.5 border border-slate-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 text-sm transition-colors"
                    placeholder="Search by name, ID, email...">
            </div>

            <div class="flex flex-col sm:flex-row gap-3 w-full lg:w-auto">
                {{-- Subscription Filter (Kept in main view as requested "nothing else") --}}
                <select id="subscriptionFilter"
                    class="form-select block w-full pl-3 pr-10 py-2.5 text-base border-slate-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-lg bg-white">
                    <option value="all">All Plans</option>
                    <option value="subscribed">Has Subscription</option>
                    <option value="free">Free / None</option>
                </select>

                {{-- Status Filter --}}
                <select id="statusFilter"
                    class="form-select block w-full pl-3 pr-10 py-2.5 text-base border-slate-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-lg bg-white">
                    <option value="all">All Status</option>
                    <option value="active">Active</option>
                    <option value="suspend">Suspended</option>
                    <option value="Ban">Banned</option>
                    <option value="deactive">Deactive</option>
                </select>
            </div>
        </div>
        {{-- Main Table --}}
        <div class="bg-white rounded-xl shadow-lg border border-slate-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-200" id="customerTable">
                    <thead class="bg-slate-50">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">
                                Customer</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">
                                Current Plan</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">
                                Contact & Status</th>
                            <th class="px-6 py-4 text-right text-xs font-semibold text-slate-500 uppercase tracking-wider">
                                Wallet</th>
                            <th class="px-6 py-4 text-center text-xs font-semibold text-slate-500 uppercase tracking-wider">
                                Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-slate-100">
                        @forelse ($users as $customer)
                            @php
                                $hasSub = (bool) rand(0, 1);
                                $planName = $hasSub ? (rand(0, 1) ? 'Gold Pro' : 'Silver Starter') : 'Free Tier';
                                $subStatus = $hasSub ? 'subscribed' : 'free';

                                $statusClass = match ($customer->status) {
                                    'active' => 'bg-green-100 text-green-800',
                                    'Ban', 'suspend' => 'bg-red-100 text-red-800',
                                    'deactive' => 'bg-gray-100 text-gray-800',
                                    default => 'bg-yellow-100 text-yellow-800',
                                };

                                $jsData = [
                                    'id' => $customer->id,
                                    'name' => $customer->name,
                                    'gender' => $customer->gender ?? 'N/A',
                                    'dob' => $customer->dob ?? 'N/A',
                                    'email' => $customer->email,
                                    'phone' => $customer->phone ?? 'N/A',
                                    'status' => $customer->status,
                                    'wallet_balance' => 0,
                                    'rewards' => 0,
                                    // Subscription data kept for table logic, but won't be shown in sidebar
                                    'subscription' => [
                                        'has_plan' => $hasSub,
                                        'plan_name' => $planName,
                                        'expires_at' => now()->addDays(rand(5, 30))->format('M d, Y'),
                                        'progress' => rand(20, 90),
                                    ],
                                    'address' => [
                                        'current' => $customer->current_address ?? ($customer->address ?? 'N/A'),
                                        'city' => $customer->city ?? 'N/A',
                                        'state' => $customer->state ?? 'N/A',
                                        'country' => 'N/A',
                                        'zip' => $customer->zipcode ?? 'N/A',
                                    ],
                                    'payment_methods' => [],
                                ];
                            @endphp

                            <tr class="hover:bg-slate-50 transition-colors duration-200 customer-row"
                                data-status="{{ strtolower($customer->status) }}" data-subscription="{{ $subStatus }}">

                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10 relative">
                                            @if ($customer->image)
                                                <img class="h-10 w-10 rounded-full object-cover shadow-md"
                                                    src="{{ asset($customer->image) }}" alt="{{ $customer->name }}">
                                            @else
                                                <div
                                                    class="h-10 w-10 rounded-full bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center text-white font-bold text-sm shadow-md">
                                                    {{ substr($customer->name, 0, 1) }}
                                                </div>
                                            @endif

                                            @if ($hasSub)
                                                <div class="absolute -top-1 -right-1 bg-yellow-400 text-white rounded-full p-0.5 border-2 border-white shadow-sm"
                                                    title="Premium Subscriber">
                                                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                                        <path
                                                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                                    </svg>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-semibold text-slate-900 search-name">
                                                {{ $customer->name }}</div>
                                            <div class="text-xs text-slate-500 search-id">ID: #{{ $customer->id }}</div>
                                        </div>
                                    </div>
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if ($hasSub)
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-50 text-indigo-700 border border-indigo-100">
                                            <svg class="mr-1.5 h-2 w-2 text-indigo-400" fill="currentColor"
                                                viewBox="0 0 8 8">
                                                <circle cx="4" cy="4" r="3" />
                                            </svg>
                                            {{ $planName }}
                                        </span>
                                    @else
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-slate-100 text-slate-600">
                                            Free Tier
                                        </span>
                                    @endif
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-slate-700 search-email">{{ $customer->email }}</div>
                                    <div class="mt-1 flex items-center space-x-2">
                                        <span
                                            class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium {{ $statusClass }}">
                                            {{ ucfirst($customer->status) }}
                                        </span>
                                        <span class="text-xs text-slate-400">|</span>
                                        <span class="text-xs text-slate-500">{{ $customer->phone ?? 'N/A' }}</span>
                                    </div>
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap text-right">
                                    <div class="text-sm font-bold text-slate-900">
                                        ${{ $customer->wallet->balance }}
                                    </div>
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    <div class="flex items-center justify-center gap-2">
                                        <button onclick="openEditModal({{ json_encode($jsData) }})"
                                            class="p-2 text-blue-600 hover:text-blue-900 bg-blue-50 hover:bg-blue-100 rounded-lg transition-colors"
                                            title="Edit">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                                </path>
                                            </svg>
                                        </button>
                                        <button onclick="deleteCustomer({{ $customer->id }})"
                                            class="p-2 text-red-600 hover:text-red-900 bg-red-50 hover:bg-red-100 rounded-lg transition-colors"
                                            title="Delete">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                </path>
                                            </svg>
                                        </button>
                                        <button onclick="showCustomerDetails({{ json_encode($jsData) }})"
                                            class="p-2 text-indigo-600 hover:text-indigo-900 bg-indigo-50 hover:bg-indigo-100 rounded-lg transition-colors"
                                            title="View Details">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-10 text-center text-slate-500">No customers found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                <div id="noResults" class="hidden p-8 text-center text-slate-500 text-sm">
                    No customers found matching your criteria.
                </div>
            </div>
        </div>

        {{-- ======================= --}}
        {{-- MODAL 1: CREATE CUSTOMER --}}
        {{-- ======================= --}}
        <div id="create-customer-modal" class="fixed inset-0 z-50 hidden" aria-labelledby="modal-title" role="dialog"
            aria-modal="true">
            <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 bg-slate-900 bg-opacity-75 transition-opacity backdrop-blur-sm"
                    onclick="closeCreateModal()"></div>
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                <div
                    class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl w-full">

                    {{-- Header --}}
                    <div class="bg-white px-6 py-6 border-b border-slate-100 flex justify-between items-center">
                        <h3 class="text-xl font-bold text-slate-800">Add New Customer</h3>
                        <button onclick="closeCreateModal()" class="text-slate-400 hover:text-slate-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>

                    {{-- Create Form --}}
                    <form id="createCustomerForm" class="p-6 space-y-6">
                        @csrf
                        {{-- Messages --}}
                        <div id="createErrorMessage" class="hidden bg-red-50 text-red-600 p-3 rounded-lg text-sm mb-4">
                        </div>
                        <div id="createSuccessMessage"
                            class="hidden bg-green-50 text-green-600 p-3 rounded-lg text-sm mb-4"></div>

                        <div>
                            <h4 class="text-sm uppercase tracking-wide text-slate-500 font-semibold mb-3">Personal
                                Information</h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-slate-700">Full Name</label>
                                    <input type="text" name="name" id="create_name"
                                        class="mt-1 block w-full border-slate-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm p-2.5 border"
                                        placeholder="John Doe">
                                    <span class="text-xs text-red-500 error-text name_error"></span>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-slate-700">Email</label>
                                    <input type="email" name="email" id="create_email"
                                        class="mt-1 block w-full border-slate-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm p-2.5 border"
                                        placeholder="john@example.com">
                                    <span class="text-xs text-red-500 error-text email_error"></span>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-slate-700">Gender</label>
                                    <select name="gender" id="create_gender"
                                        class="mt-1 block w-full border-slate-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm p-2.5 border">
                                        <option value="male">Male</option>
                                        <option value="female">Female</option>
                                        <option value="other">Other</option>
                                    </select>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-slate-700">Date of Birth</label>
                                    <input type="date" name="dob" id="create_dob"
                                        class="mt-1 block w-full border-slate-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm p-2.5 border">
                                </div>
                            </div>
                        </div>
                    </form>

                    {{-- Footer --}}
                    <div class="p-6 border-t border-slate-200 flex justify-end">
                        <button type="button" onclick="closeCreateModal()"
                            class="mr-3 px-4 py-2 text-slate-500 hover:text-slate-700">Cancel</button>

                        <button type="button" id="createSubmitBtn"
                            class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 flex items-center">
                            <svg id="createLoadingIcon" class="hidden animate-spin -ml-1 mr-3 h-5 w-5 text-white"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                    stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor"
                                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                </path>
                            </svg>
                            Save Customer
                        </button>
                    </div>

                </div>
            </div>
        </div>

        {{-- ===================== --}}
        {{-- MODAL 2: EDIT CUSTOMER --}}
        {{-- ===================== --}}
        <div id="edit-customer-modal" class="fixed inset-0 z-50 hidden" aria-labelledby="modal-title" role="dialog"
            aria-modal="true">
            <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 bg-slate-900 bg-opacity-75 transition-opacity backdrop-blur-sm"
                    onclick="closeEditModal()"></div>
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                <div
                    class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl w-full">

                    {{-- Header --}}
                    <div class="bg-white px-6 py-6 border-b border-slate-100 flex justify-between items-center">
                        <h3 class="text-xl font-bold text-slate-800">Edit Customer</h3>
                        <button onclick="closeEditModal()" class="text-slate-400 hover:text-slate-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>

                    {{-- Edit Form --}}
                    <form id="editCustomerForm" class="p-6 space-y-6">
                        @csrf
                        {{-- Hidden ID for Update --}}
                        <input type="hidden" name="customer_id" id="edit_customer_id">
                        {{-- Messages --}}
                        <div id="editErrorMessage" class="hidden bg-red-50 text-red-600 p-3 rounded-lg text-sm mb-4">
                        </div>
                        <div id="editSuccessMessage"
                            class="hidden bg-green-50 text-green-600 p-3 rounded-lg text-sm mb-4"></div>

                        <div>
                            <h4 class="text-sm uppercase tracking-wide text-slate-500 font-semibold mb-3">Update
                                Information</h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-slate-700">Full Name</label>
                                    <input type="text" name="name" id="edit_name"
                                        class="mt-1 block w-full border-slate-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm p-2.5 border">
                                    <span class="text-xs text-red-500 error-text name_error"></span>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-slate-700">Email</label>
                                    <input type="email" name="email" id="edit_email"
                                        class="mt-1 block w-full border-slate-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm p-2.5 border">
                                    <span class="text-xs text-red-500 error-text email_error"></span>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-slate-700">Gender</label>
                                    <select name="gender" id="edit_gender"
                                        class="mt-1 block w-full border-slate-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm p-2.5 border">
                                        <option value="male">Male</option>
                                        <option value="female">Female</option>
                                        <option value="other">Other</option>
                                    </select>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-slate-700">Date of Birth</label>
                                    <input type="date" name="dob" id="edit_dob"
                                        class="mt-1 block w-full border-slate-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm p-2.5 border">
                                </div>
                            </div>
                        </div>
                    </form>

                    {{-- Footer --}}
                    <div class="p-6 border-t border-slate-200 flex justify-end">
                        <button type="button" onclick="closeEditModal()"
                            class="mr-3 px-4 py-2 text-slate-500 hover:text-slate-700">Cancel</button>

                        <button type="button" id="editSubmitBtn"
                            class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 flex items-center">
                            <svg id="editLoadingIcon" class="hidden animate-spin -ml-1 mr-3 h-5 w-5 text-white"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                    stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor"
                                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                </path>
                            </svg>
                            Update Customer
                        </button>
                    </div>

                </div>
            </div>
        </div>

        {{-- CUSTOMER DETAILS DRAWER --}}
        <div id="customer-details-drawer" class="fixed inset-0 overflow-hidden z-[60] hidden"
            aria-labelledby="slide-over-title" role="dialog" aria-modal="true">
            <div class="absolute inset-0 overflow-hidden">
                <div id="drawer-backdrop"
                    class="absolute inset-0 bg-slate-900 bg-opacity-75 backdrop-blur-sm opacity-0 transition-opacity duration-300 ease-linear"
                    onclick="hideCustomerDetails()"></div>
                <div class="fixed inset-y-0 right-0 max-w-full flex pointer-events-none">
                    <div id="drawer-panel"
                        class="w-screen max-w-md md:max-w-2xl pointer-events-auto transform translate-x-full transition-transform duration-300 ease-in-out">
                        <div class="h-full flex flex-col bg-slate-50 shadow-2xl overflow-y-scroll">
                            <div class="bg-white px-6 py-6 border-b border-slate-200 sticky top-0 z-20 shadow-sm">
                                <div class="flex items-start justify-between">
                                    <div class="flex items-center space-x-4">
                                        <div class="h-14 w-14 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-700 text-xl font-bold shadow-inner"
                                            id="drawer-avatar">A</div>
                                        <div>
                                            <h2 class="text-xl font-bold text-slate-900" id="drawer-name">User Name</h2>
                                            <p class="text-sm text-slate-500" id="drawer-id">ID: #0000</p>
                                        </div>
                                    </div>
                                    <div class="ml-3 h-7 flex items-center">
                                        <button type="button"
                                            class="bg-white rounded-full p-1 text-slate-400 hover:text-slate-600 focus:outline-none"
                                            onclick="hideCustomerDetails()">
                                            <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M6 18L18 6M6 6l12 12" />
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                                <div class="mt-6 -mb-6">
                                    <nav class="-mb-px flex space-x-6 overflow-x-auto no-scrollbar" id="drawer-tabs">
                                    </nav>
                                </div>
                            </div>
                            <div class="relative flex-1 py-8 px-6 bg-slate-50" id="drawer-content"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }

        .no-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }

        .tab-active {
            border-bottom: 2px solid #4f46e5;
            color: #4f46e5;
            font-weight: 600;
        }

        .tab-inactive {
            border-bottom: 2px solid transparent;
            color: #64748b;
        }

        .tab-inactive:hover {
            color: #334155;
            border-bottom-color: #cbd5e1;
        }
    </style>
@endpush

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script>
        // ==========================================
        // 1. GLOBAL VARIABLES & CRUD OPERATIONS
        // ==========================================
        const customerBaseUrl = "{{ route('customers.store') }}";
        const customersUrl = "{{ url('customers') }}";

        // --- CREATE MODAL ---
        function openCreateModal() {
            document.getElementById('createCustomerForm').reset();
            clearErrors('create');
            document.getElementById('create-customer-modal').classList.remove('hidden');
        }

        function closeCreateModal() {
            document.getElementById('create-customer-modal').classList.add('hidden');
        }

        // --- EDIT MODAL ---
        function openEditModal(data) {
            document.getElementById('edit_customer_id').value = data.id;
            document.getElementById('edit_name').value = data.name;
            document.getElementById('edit_email').value = data.email;
            if (data.gender) document.getElementById('edit_gender').value = data.gender.toLowerCase();
            document.getElementById('edit_dob').value = data.dob;

            clearErrors('edit');
            document.getElementById('edit-customer-modal').classList.remove('hidden');
        }

        function closeEditModal() {
            document.getElementById('edit-customer-modal').classList.add('hidden');
        }

        // --- HELPER: Clear Errors ---
        function clearErrors(prefix) {
            document.querySelectorAll(`#${prefix}CustomerForm .error-text`).forEach(el => el.innerText = '');
            document.getElementById(`${prefix}ErrorMessage`).classList.add('hidden');
            document.getElementById(`${prefix}SuccessMessage`).classList.add('hidden');
        }

        // --- DELETE CUSTOMER ---
        function deleteCustomer(id) {
            if (confirm("Are you sure you want to delete this customer?")) {
                let url = `${customersUrl}/${id}`;
                axios.delete(url, {
                        headers: {
                            'Accept': 'application/json'
                        }
                    })
                    .then(response => {
                        alert("Customer deleted successfully!");
                        window.location.reload();
                    })
                    .catch(error => {
                        console.error(error);
                        alert("Failed to delete customer.");
                    });
            }
        }

        // --- FORM SUBMISSION LOGIC ---
        document.addEventListener("DOMContentLoaded", function() {
            // Create Submit
            const createBtn = document.getElementById('createSubmitBtn');
            if (createBtn) {
                createBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    submitForm('create', customerBaseUrl, 'POST');
                });
            }

            // Edit Submit
            const editBtn = document.getElementById('editSubmitBtn');
            if (editBtn) {
                editBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    let id = document.getElementById('edit_customer_id').value;
                    let url = `${customersUrl}/${id}`;
                    submitForm('edit', url, 'PUT');
                });
            }

            function submitForm(type, url, method) {
                let form = document.getElementById(`${type}CustomerForm`);
                let formData = new FormData(form);
                let btn = document.getElementById(`${type}SubmitBtn`);
                let loader = document.getElementById(`${type}LoadingIcon`);

                if (method === 'PUT') formData.append('_method', 'PUT');

                btn.disabled = true;
                loader.classList.remove('hidden');
                clearErrors(type);

                axios.post(url, formData, {
                        headers: {
                            'Accept': 'application/json'
                        }
                    })
                    .then(response => {
                        document.getElementById(`${type}SuccessMessage`).innerText = response.data.message;
                        document.getElementById(`${type}SuccessMessage`).classList.remove('hidden');
                        form.reset();
                        setTimeout(() => {
                            window.location.reload();
                        }, 1000);
                    })
                    .catch(error => {
                        btn.disabled = false;
                        loader.classList.add('hidden');
                        if (error.response && error.response.status === 422) {
                            let errors = error.response.data.errors;
                            for (const [key, value] of Object.entries(errors)) {
                                let specificSpan = form.querySelector(`.${key}_error`) || form.querySelector(
                                    `.name_error`);
                                if (specificSpan) specificSpan.innerText = value[0];
                            }
                        } else {
                            document.getElementById(`${type}ErrorMessage`).innerText = "Something went wrong.";
                            document.getElementById(`${type}ErrorMessage`).classList.remove('hidden');
                        }
                    });
            }
        });
    </script>

    <script>
        // ==========================================
        // 2. SEARCH, FILTERS & DRAWER LOGIC
        // ==========================================

        // --- Mock History Generator ---
        const getMockHistory = (type) => {
            const statuses = ['In Progress', 'Delivered', 'Cancelled', 'Completed'];
            const items = [];
            for (let i = 1; i <= 5; i++) {
                const day = String(Math.floor(Math.random() * 28) + 1).padStart(2, '0');
                const dateStr = `2026-01-${day}`;
                if (type === 'Transaction') {
                    const isCredit = Math.random() > 0.5;
                    items.push({
                        id: `TXN${10000+i}`,
                        name: isCredit ? 'Wallet Top-up' : 'Subscription Renewal',
                        price: (Math.random() * 100).toFixed(2),
                        date: dateStr,
                        status: isCredit ? 'Credit' : 'Debit',
                        image: ''
                    });
                } else {
                    items.push({
                        id: `${type.charAt(0).toUpperCase()}${1000+i}`,
                        name: `${type} Item #${i}`,
                        price: (Math.random() * 200).toFixed(2),
                        date: dateStr,
                        status: statuses[Math.floor(Math.random() * statuses.length)],
                        image: 'https://via.placeholder.com/50?text=IMG'
                    });
                }
            }
            return items;
        };

        // --- Tabs Configuration (REMOVED SUBSCRIPTION) ---
        const tabs = [{
                id: 'personal',
                label: 'Personal Info'
            },
            {
                id: 'wallet',
                label: 'Wallet'
            },
            {
                id: 'orders',
                label: 'Orders'
            },
            {
                id: 'bookings',
                label: 'Bookings'
            },
            {
                id: 'transactions',
                label: 'History'
            },
            {
                id: 'payments',
                label: 'Payment Methods'
            },
        ];

        let currentCustomer = null;
        let currentTabData = [];

        // --- FILTER LOGIC ---
        document.addEventListener("DOMContentLoaded", function() {
            const searchInput = document.getElementById("customerSearchInput");
            const statusFilter = document.getElementById("statusFilter");
            const subscriptionFilter = document.getElementById("subscriptionFilter");
            const tableRows = document.querySelectorAll("#customerTable tbody tr");
            const noResults = document.getElementById("noResults");

            function filterMainTable() {
                const query = searchInput.value.toLowerCase();
                const status = statusFilter.value.toLowerCase();
                const subStatus = subscriptionFilter ? subscriptionFilter.value.toLowerCase() : 'all';

                let hasVisibleRow = false;

                tableRows.forEach(row => {
                    const name = row.querySelector(".search-name").innerText.toLowerCase();
                    const id = row.querySelector(".search-id").innerText.toLowerCase();
                    const email = row.querySelector(".search-email").innerText.toLowerCase();
                    const rowStatus = row.getAttribute("data-status");
                    const rowSub = row.getAttribute("data-subscription");

                    const matchesSearch = name.includes(query) || id.includes(query) || email.includes(
                        query);
                    const matchesStatus = status === "all" || rowStatus === status;
                    const matchesSub = subStatus === "all" || rowSub === subStatus;

                    if (matchesSearch && matchesStatus && matchesSub) {
                        row.style.display = "";
                        hasVisibleRow = true;
                    } else {
                        row.style.display = "none";
                    }
                });
                if (noResults) noResults.style.display = hasVisibleRow ? "none" : "block";
            }

            if (searchInput) searchInput.addEventListener("keyup", filterMainTable);
            if (statusFilter) statusFilter.addEventListener("change", filterMainTable);
            if (subscriptionFilter) subscriptionFilter.addEventListener("change", filterMainTable);
        });

        // --- DRAWER FUNCTIONS ---
        function showCustomerDetails(customer) {
            currentCustomer = customer;
            document.getElementById('drawer-name').innerText = customer.name;
            document.getElementById('drawer-id').innerText = `ID: #${customer.id}`;
            document.getElementById('drawer-avatar').innerText = customer.name.charAt(0);

            const tabContainer = document.getElementById('drawer-tabs');
            tabContainer.innerHTML = tabs.map(tab => `
                <button onclick="switchTab('${tab.id}')" id="tab-${tab.id}" class="whitespace-nowrap pb-4 px-1 text-sm font-medium transition-colors duration-200 tab-inactive">${tab.label}</button>
            `).join('');

            const drawer = document.getElementById('customer-details-drawer');
            const backdrop = document.getElementById('drawer-backdrop');
            const panel = document.getElementById('drawer-panel');
            drawer.classList.remove('hidden');
            document.body.style.overflow = 'hidden';

            // Always Default to Personal since Subscription is gone
            switchTab('personal');

            setTimeout(() => {
                backdrop.classList.remove('opacity-0');
                panel.classList.remove('translate-x-full');
            }, 20);
        }

        function hideCustomerDetails() {
            const drawer = document.getElementById('customer-details-drawer');
            const backdrop = document.getElementById('drawer-backdrop');
            const panel = document.getElementById('drawer-panel');
            backdrop.classList.add('opacity-0');
            panel.classList.add('translate-x-full');
            setTimeout(() => {
                drawer.classList.add('hidden');
                document.body.style.overflow = '';
            }, 300);
        }

        function switchTab(tabId) {
            tabs.forEach(t => {
                const el = document.getElementById(`tab-${t.id}`);
                if (t.id === tabId) {
                    el.classList.remove('tab-inactive');
                    el.classList.add('tab-active');
                } else {
                    el.classList.add('tab-inactive');
                    el.classList.remove('tab-active');
                }
            });
            document.getElementById('drawer-content').innerHTML = renderContent(tabId);
            if (['orders', 'bookings', 'transactions'].includes(tabId)) {
                initHistoryTab(tabId);
            }
        }

        // --- RENDER CONTENT (SUBSCRIPTION REMOVED) ---
        function renderContent(tabId) {
            const c = currentCustomer;

            // 1. PERSONAL TAB
            if (tabId === 'personal') {
                const addr = c.address || {};
                return `
                <div class="space-y-6">
                    <div class="bg-white p-6 rounded-xl shadow-sm border border-slate-100 space-y-6">
                        <h3 class="text-lg font-bold text-slate-800 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                            Personal Details
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div><label class="text-xs font-semibold text-slate-400 uppercase">Full Name</label><p class="text-slate-900 font-medium">${c.name}</p></div>
                            <div><label class="text-xs font-semibold text-slate-400 uppercase">Gender</label><p class="text-slate-900 font-medium capitalize">${c.gender}</p></div>
                            <div><label class="text-xs font-semibold text-slate-400 uppercase">DOB</label><p class="text-slate-900 font-medium">${c.dob}</p></div>
                            <div><label class="text-xs font-semibold text-slate-400 uppercase">Email</label><p class="text-slate-900 font-medium break-all">${c.email}</p></div>
                            <div class="md:col-span-2"><label class="text-xs font-semibold text-slate-400 uppercase">Phone</label><p class="text-slate-900 font-medium">${c.phone}</p></div>
                        </div>
                    </div>
                    <div class="bg-white p-6 rounded-xl shadow-sm border border-slate-100 space-y-6">
                         <h3 class="text-lg font-bold text-slate-800 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.828 0l-4.243-4.243a2 2 0 01-.586-1.414V15.5H5a2 2 0 01-2-2v-4a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2h-1.586a2 2 0 01-1.414.586z"></path></svg>
                            Address
                        </h3>
                        <div class="p-4 bg-slate-50 rounded-lg border border-slate-200">
                             <div class="grid grid-cols-1 gap-4">
                                <div><label class="text-xs font-semibold text-slate-400 uppercase">Street</label><p class="text-slate-900 font-medium">${addr.current}</p></div>
                                <div class="grid grid-cols-2 gap-4">
                                     <div><label class="text-xs font-semibold text-slate-400 uppercase">City</label><p class="text-slate-900 font-medium">${addr.city}</p></div>
                                     <div><label class="text-xs font-semibold text-slate-400 uppercase">Zip</label><p class="text-slate-900 font-medium">${addr.zip}</p></div>
                                </div>
                             </div>
                        </div>
                    </div>
                </div>`;
            }

            // 2. WALLET TAB
            if (tabId === 'wallet') {
                return `
                <div class="space-y-6">
                    <div class="bg-gradient-to-r from-indigo-600 to-purple-700 p-6 rounded-2xl shadow-lg text-white">
                        <div class="flex justify-between items-start">
                            <div><p class="text-indigo-100 text-sm font-medium mb-1">Total Balance</p><h2 class="text-4xl font-extrabold tracking-tight">$${c.wallet_balance.toFixed(2)}</h2></div>
                            <div class="bg-white/20 p-2 rounded-lg backdrop-blur-sm"><svg class="w-8 h-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg></div>
                        </div>
                        <div class="mt-6 flex items-center justify-between">
                            <div class="flex items-center space-x-2"><span class="bg-yellow-400 text-yellow-900 text-xs font-bold px-2 py-1 rounded-full flex items-center">⭐ ${c.rewards} Points</span></div>
                        </div>
                    </div>
                </div>`;
            }

            // 3. PAYMENTS TAB
            if (tabId === 'payments') {
                const methods = c.payment_methods || [];
                return `<div class="bg-white p-6 rounded-xl shadow-sm border border-slate-100"><h3 class="text-lg font-bold text-slate-800 mb-4">Payment Methods</h3>${methods.length > 0 ? '' : '<p class="text-slate-500 italic text-sm">No saved payment methods (N/A).</p>'}</div>`;
            }

            // 4. HISTORY TABS (Orders, Bookings, Transactions)
            const typeMap = {
                'orders': 'Order',
                'bookings': 'Booking',
                'transactions': 'Transaction'
            };
            const title = typeMap[tabId];
            return `
                <div class="space-y-4">
                    <div id="list-container-${tabId}" class="space-y-3 min-h-[200px]"></div>
                    <div class="pt-4 text-center border-t border-slate-200"><button class="inline-flex items-center px-4 py-2 bg-white border border-slate-300 rounded-md font-semibold text-xs text-slate-700 uppercase tracking-widest shadow-sm hover:bg-slate-50">View All ${title}s</button></div>
                </div>`;
        }

        function initHistoryTab(tabId) {
            const typeMap = {
                'orders': 'Order',
                'bookings': 'Booking',
                'transactions': 'Transaction'
            };
            currentTabData = getMockHistory(typeMap[tabId]);
            renderHistoryList(tabId, currentTabData);
        }

        function renderHistoryList(tabId, data) {
            const container = document.getElementById(`list-container-${tabId}`);
            if (data.length === 0) {
                container.innerHTML = `<div class="text-center py-8 text-slate-500 text-sm italic">No records found.</div>`;
                return;
            }
            container.innerHTML = data.map(item => {
                if (tabId === 'transactions') {
                    const isCredit = item.status === 'Credit';
                    return `<div class="bg-white p-3 rounded-lg border border-slate-100 flex items-center justify-between shadow-sm"><div class="flex items-center gap-3"><div class="h-10 w-10 rounded-full ${isCredit ? 'bg-green-100' : 'bg-red-100'} flex items-center justify-center"><span class="font-bold ${isCredit ? 'text-green-700' : 'text-red-700'}">${isCredit ? '↓' : '↑'}</span></div><div><p class="text-sm font-bold text-slate-900">${item.name}</p><p class="text-xs text-slate-500">${item.date} &bull; ${item.id}</p></div></div><div class="text-right"><p class="text-sm font-bold ${isCredit?'text-green-600':'text-slate-900'}">${isCredit?'+':'-'}$${item.price}</p><p class="text-xs text-slate-400 capitalize">${item.status}</p></div></div>`;
                }
                return `<div class="bg-white p-4 rounded-xl border border-slate-100 shadow-sm hover:shadow-md transition-shadow flex flex-col sm:flex-row sm:items-center justify-between gap-4"><div class="flex items-center gap-4"><div class="h-12 w-12 rounded-lg bg-slate-100 flex items-center justify-center text-slate-400 text-xs font-bold">IMG</div><div><h4 class="text-sm font-bold text-slate-900">${item.name}</h4><p class="text-xs text-slate-500">ID: #${item.id} &bull; ${item.date}</p></div></div><div class="text-right flex items-center justify-between sm:block w-full sm:w-auto"><div><p class="text-sm font-bold text-slate-900">$${item.price}</p><span class="inline-block px-2 py-0.5 rounded text-[10px] font-bold uppercase tracking-wide bg-blue-100 text-blue-800">${item.status}</span></div></div></div>`;
            }).join('');
        }
    </script>
@endpush