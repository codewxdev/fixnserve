@extends('layouts.app')

@section('content')
    <div class="min-h-screen theme-bg-body theme-text-main p-4 md:p-8 font-sans" onclick="closeAllDropdowns(event)">

        {{-- Page Header --}}
        <header class="mb-8 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h1 class="text-3xl font-bold theme-text-main tracking-tight">Customer Management</h1>
                <p class="mt-1 theme-text-muted">Manage profiles, orders, and service history.</p>
            </div>

            <button onclick="openCreateModal()"
                class="flex items-center justify-center space-x-2 px-5 py-2.5 text-white rounded-lg shadow-md hover:shadow-lg transition-all transform hover:-translate-y-0.5 focus:ring-2 focus:ring-offset-2"
                style="background-color: rgb(var(--brand-primary));">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6">
                    </path>
                </svg>
                <span class="font-medium">Add New Customer</span>
            </button>
        </header>

        {{-- Search & Filters --}}
        <div
            class="theme-bg-card p-4 rounded-xl shadow-sm border theme-border mb-6 flex flex-col lg:flex-row gap-4 items-center">
            <div class="relative flex-grow w-full lg:w-auto">
                <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                    <svg class="w-5 h-5 theme-text-muted" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </span>
                <input type="text" id="customerSearchInput"
                    class="w-full pl-10 pr-4 py-2.5 theme-bg-body border theme-border rounded-lg focus:ring-2 theme-text-main text-sm transition-colors placeholder-gray-500"
                    style="background-color: rgba(var(--bg-body), 0.5);"
                    placeholder="Search by name, ID, email...">
            </div>

            <div class="flex flex-col sm:flex-row gap-3 w-full lg:w-auto">
                {{-- Status Filter --}}
                <select id="statusFilter"
                    class="form-select block w-full pl-3 pr-10 py-2.5 text-base theme-bg-body theme-border theme-text-main focus:outline-none focus:ring-2 sm:text-sm rounded-lg"
                    style="background-color: rgba(var(--bg-body), 0.5);">
                    <option value="all">All Status</option>
                    <option value="active">Active</option>
                    <option value="suspend">Suspended</option>
                </select>
            </div>
        </div>

        {{-- Main Table --}}
        <div class="theme-bg-card rounded-xl shadow-lg border theme-border overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y theme-border" id="customerTable" style="border-color: rgb(var(--border-color));">
                    <thead class="theme-bg-body">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-semibold theme-text-muted uppercase tracking-wider">
                                Customer</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold theme-text-muted uppercase tracking-wider">
                                Contact & Status</th>
                            <th class="px-6 py-4 text-right text-xs font-semibold theme-text-muted uppercase tracking-wider">
                                Wallet</th>
                            <th class="px-6 py-4 text-center text-xs font-semibold theme-text-muted uppercase tracking-wider">
                                Actions</th>
                        </tr>
                    </thead>
                    <tbody class="theme-bg-card divide-y theme-border" style="border-color: rgb(var(--border-color));">
                        @forelse ($users as $customer)
                            @php
                                // Updated Status Colors for Theme Compatibility
                                $statusClass = match ($customer->status) {
                                    'active' => 'bg-green-500/10 text-green-500 border border-green-500/20',
                                    'Ban', 'suspend' => 'bg-red-500/10 text-red-500 border border-red-500/20',
                                    default => 'bg-yellow-500/10 text-yellow-500 border border-yellow-500/20',
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

                            <tr class="hover:bg-white/5 transition-colors duration-200 customer-row"
                                data-status="{{ strtolower($customer->status) }}">

                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10 relative">
                                            @if ($customer->image)
                                                <img class="h-10 w-10 rounded-full object-cover shadow-md"
                                                    src="{{ asset($customer->image) }}" alt="{{ $customer->name }}">
                                            @else
                                                <div
                                                    class="h-10 w-10 rounded-full flex items-center justify-center text-white font-bold text-sm shadow-md"
                                                    style="background: linear-gradient(135deg, rgb(var(--brand-primary)), rgb(var(--brand-secondary)));">
                                                    {{ substr($customer->name, 0, 1) }}
                                                </div>
                                            @endif
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-semibold theme-text-main search-name">
                                                {{ $customer->name }}</div>
                                            <div class="text-xs theme-text-muted search-id">ID: #{{ $customer->id }}</div>
                                        </div>
                                    </div>
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm theme-text-main search-email">{{ $customer->email }}</div>
                                    <div class="mt-1 flex items-center space-x-2">
                                        <span
                                            class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium {{ $statusClass }}">
                                            {{ ucfirst($customer->status) }}
                                        </span>
                                        <span class="text-xs theme-text-muted">|</span>
                                        <span class="text-xs theme-text-muted">{{ $customer->phone ?? 'N/A' }}</span>
                                    </div>
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap text-right">
                                    <div class="text-sm font-bold theme-text-main">
                                        ${{ $customer->wallet->balance }}
                                    </div>
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap text-center relative">
                                    <div class="flex justify-center items-center space-x-1">

                                        {{-- View Details Button --}}
                                        <button onclick="showCustomerDetails({{ json_encode($jsData) }})"
                                            class="p-2 theme-text-muted hover:text-blue-500 hover:bg-white/10 rounded-full transition-colors focus:outline-none"
                                            title="View Details">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                        </button>

                                        {{-- Dropdown Toggle --}}
                                        <button onclick="toggleDropdown(event, {{ $customer->id }})"
                                            class="p-2 theme-text-muted hover:text-blue-500 hover:bg-white/10 rounded-full transition-colors focus:outline-none">
                                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                                <path
                                                    d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z" />
                                            </svg>
                                        </button>
                                    </div>

                                    {{-- Dropdown Menu --}}
                                    <div id="dropdown-{{ $customer->id }}"
                                        class="dropdown-menu hidden absolute right-10 top-8 z-50 w-48 theme-bg-card rounded-md shadow-lg border theme-border focus:outline-none text-left">
                                        <div class="py-1">

                                            <button onclick="openEditModal({{ json_encode($jsData) }})"
                                                class="flex w-full items-center px-4 py-2 text-sm theme-text-main hover:bg-white/5">
                                                <svg class="mr-3 h-4 w-4 theme-text-muted" fill="none"
                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                </svg>
                                                Edit Profile
                                            </button>

                                            <div class="border-t theme-border my-1"></div>

                                            <button onclick="updateStatus({{ $customer->id }}, 'active')"
                                                class="flex w-full items-center px-4 py-2 text-sm text-green-500 hover:bg-white/5">
                                                <svg class="mr-3 h-4 w-4 text-green-500" fill="none"
                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                                Activate
                                            </button>

                                            <button onclick="updateStatus({{ $customer->id }}, 'suspend')"
                                                class="flex w-full items-center px-4 py-2 text-sm text-yellow-500 hover:bg-white/5">
                                                <svg class="mr-3 h-4 w-4 text-yellow-500" fill="none"
                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                                Suspend
                                            </button>

                                            <div class="border-t theme-border my-1"></div>

                                            <button onclick="deleteCustomer({{ $customer->id }})"
                                                class="flex w-full items-center px-4 py-2 text-sm text-red-500 hover:bg-white/5">
                                                <svg class="mr-3 h-4 w-4 text-red-500" fill="none"
                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                                Delete
                                            </button>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-10 text-center theme-text-muted">No customers found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                <div id="noResults" class="hidden p-8 text-center theme-text-muted text-sm">
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
                <div class="fixed inset-0 bg-black/80 transition-opacity backdrop-blur-sm"
                    onclick="closeCreateModal()"></div>
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                <div
                    class="inline-block align-bottom theme-bg-card rounded-2xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl w-full border theme-border">

                    {{-- Header --}}
                    <div class="px-6 py-6 border-b theme-border flex justify-between items-center">
                        <h3 class="text-xl font-bold theme-text-main">Add New Customer</h3>
                        <button onclick="closeCreateModal()" class="theme-text-muted hover:text-white">
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
                        <div id="createErrorMessage" class="hidden bg-red-500/10 text-red-500 border border-red-500/20 p-3 rounded-lg text-sm mb-4">
                        </div>
                        <div id="createSuccessMessage"
                            class="hidden bg-green-500/10 text-green-500 border border-green-500/20 p-3 rounded-lg text-sm mb-4"></div>

                        <div>
                            <h4 class="text-sm uppercase tracking-wide theme-text-muted font-semibold mb-3">Account Details
                            </h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium theme-text-muted">Full Name</label>
                                    <input type="text" name="name" id="create_name"
                                        class="mt-1 block w-full theme-bg-body border theme-border rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 sm:text-sm p-2.5 theme-text-main"
                                        placeholder="John Doe">
                                    <span class="text-xs text-red-500 error-text name_error"></span>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium theme-text-muted">Email</label>
                                    <input type="email" name="email" id="create_email"
                                        class="mt-1 block w-full theme-bg-body border theme-border rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 sm:text-sm p-2.5 theme-text-main"
                                        placeholder="john@example.com">
                                    <span class="text-xs text-red-500 error-text email_error"></span>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium theme-text-muted">Password</label>
                                    <input type="password" name="password" id="create_password"
                                        class="mt-1 block w-full theme-bg-body border theme-border rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 sm:text-sm p-2.5 theme-text-main"
                                        placeholder="********">
                                    <span class="text-xs text-red-500 error-text password_error"></span>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium theme-text-muted">Date of Birth</label>
                                    <input type="date" name="dob" id="create_dob"
                                        class="mt-1 block w-full theme-bg-body border theme-border rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 sm:text-sm p-2.5 theme-text-main">
                                </div>

                                <div>
                                    <label class="block text-sm font-medium theme-text-muted">Gender</label>
                                    <select name="gender" id="create_gender"
                                        class="mt-1 block w-full theme-bg-body border theme-border rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 sm:text-sm p-2.5 theme-text-main">
                                        <option value="male">Male</option>
                                        <option value="female">Female</option>
                                        <option value="other">Other</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </form>

                    {{-- Footer --}}
                    <div class="p-6 border-t theme-border flex justify-end">
                        <button type="button" onclick="closeCreateModal()"
                            class="mr-3 px-4 py-2 theme-text-muted hover:text-white">Cancel</button>

                        <button type="button" id="createSubmitBtn"
                            class="px-4 py-2 text-white rounded-lg flex items-center shadow-lg"
                            style="background-color: rgb(var(--brand-primary));">
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
                <div class="fixed inset-0 bg-black/80 transition-opacity backdrop-blur-sm"
                    onclick="closeEditModal()"></div>
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                <div
                    class="inline-block align-bottom theme-bg-card rounded-2xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl w-full border theme-border">

                    {{-- Header --}}
                    <div class="px-6 py-6 border-b theme-border flex justify-between items-center">
                        <h3 class="text-xl font-bold theme-text-main">Edit Customer</h3>
                        <button onclick="closeEditModal()" class="theme-text-muted hover:text-white">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>

                    {{-- Edit Form --}}
                    <form id="editCustomerForm" class="p-6 space-y-6">
                        @csrf
                        <input type="hidden" name="customer_id" id="edit_customer_id">
                        <div id="editErrorMessage" class="hidden bg-red-500/10 text-red-500 border border-red-500/20 p-3 rounded-lg text-sm mb-4">
                        </div>
                        <div id="editSuccessMessage"
                            class="hidden bg-green-500/10 text-green-500 border border-green-500/20 p-3 rounded-lg text-sm mb-4"></div>

                        <div>
                            <h4 class="text-sm uppercase tracking-wide theme-text-muted font-semibold mb-3">Update
                                Information</h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium theme-text-muted">Full Name</label>
                                    <input type="text" name="name" id="edit_name"
                                        class="mt-1 block w-full theme-bg-body border theme-border rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 sm:text-sm p-2.5 theme-text-main">
                                    <span class="text-xs text-red-500 error-text name_error"></span>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium theme-text-muted">Email</label>
                                    <input type="email" name="email" id="edit_email"
                                        class="mt-1 block w-full theme-bg-body border theme-border rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 sm:text-sm p-2.5 theme-text-main">
                                    <span class="text-xs text-red-500 error-text email_error"></span>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium theme-text-muted">Date of Birth</label>
                                    <input type="date" name="dob" id="edit_dob"
                                        class="mt-1 block w-full theme-bg-body border theme-border rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 sm:text-sm p-2.5 theme-text-main">
                                </div>

                                <div>
                                    <label class="block text-sm font-medium theme-text-muted">Gender</label>
                                    <select name="gender" id="edit_gender"
                                        class="mt-1 block w-full theme-bg-body border theme-border rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 sm:text-sm p-2.5 theme-text-main">
                                        <option value="male">Male</option>
                                        <option value="female">Female</option>
                                        <option value="other">Other</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </form>

                    {{-- Footer --}}
                    <div class="p-6 border-t theme-border flex justify-end">
                        <button type="button" onclick="closeEditModal()"
                            class="mr-3 px-4 py-2 theme-text-muted hover:text-white">Cancel</button>

                        <button type="button" id="editSubmitBtn"
                            class="px-4 py-2 text-white rounded-lg flex items-center shadow-lg"
                            style="background-color: rgb(var(--brand-primary));">
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
                    class="absolute inset-0 bg-black/80 backdrop-blur-sm opacity-0 transition-opacity duration-300 ease-linear"
                    onclick="hideCustomerDetails()"></div>
                <div class="fixed inset-y-0 right-0 max-w-full flex pointer-events-none">
                    <div id="drawer-panel"
                        class="w-screen max-w-md md:max-w-2xl pointer-events-auto transform translate-x-full transition-transform duration-300 ease-in-out">
                        <div class="h-full flex flex-col theme-bg-body shadow-2xl overflow-y-scroll">
                            <div class="theme-bg-card px-6 py-6 border-b theme-border sticky top-0 z-20 shadow-sm">
                                <div class="flex items-start justify-between">
                                    <div class="flex items-center space-x-4">
                                        <div class="h-14 w-14 rounded-full flex items-center justify-center text-white text-xl font-bold shadow-inner"
                                            id="drawer-avatar" style="background-color: rgb(var(--brand-primary));">A</div>
                                        <div>
                                            <h2 class="text-xl font-bold theme-text-main" id="drawer-name">User Name</h2>
                                            <p class="text-sm theme-text-muted" id="drawer-id">ID: #0000</p>
                                        </div>
                                    </div>
                                    <div class="ml-3 h-7 flex items-center">
                                        <button type="button"
                                            class="theme-bg-body rounded-full p-1 theme-text-muted hover:text-white focus:outline-none"
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
                            <div class="relative flex-1 py-8 px-6 theme-bg-body" id="drawer-content"></div>
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
            border-bottom: 2px solid rgb(var(--brand-primary));
            color: rgb(var(--brand-primary));
            font-weight: 600;
        }

        .tab-inactive {
            border-bottom: 2px solid transparent;
            color: rgb(var(--text-muted));
        }

        .tab-inactive:hover {
            color: rgb(var(--text-main));
            border-bottom-color: rgb(var(--border-color));
        }
    </style>
@endpush

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script>
        // ==========================================
        // 1. GLOBAL VARIABLES & CRUD OPERATIONS (Unchanged)
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
            const dropdown = document.getElementById(`dropdown-${data.id}`);
            if (dropdown) dropdown.classList.add('hidden');

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

        function clearErrors(prefix) {
            document.querySelectorAll(`#${prefix}CustomerForm .error-text`).forEach(el => el.innerText = '');
            document.getElementById(`${prefix}ErrorMessage`).classList.add('hidden');
            document.getElementById(`${prefix}SuccessMessage`).classList.add('hidden');
        }

        function toggleDropdown(event, id) {
            event.stopPropagation();
            document.querySelectorAll('.dropdown-menu').forEach(menu => {
                if (menu.id !== `dropdown-${id}`) menu.classList.add('hidden');
            });
            const menu = document.getElementById(`dropdown-${id}`);
            menu.classList.toggle('hidden');
        }

        function closeAllDropdowns(event) {
            document.querySelectorAll('.dropdown-menu').forEach(menu => {
                if (!menu.classList.contains('hidden')) {
                    menu.classList.add('hidden');
                }
            });
        }

        function updateStatus(id, status) {
            if (confirm(`Are you sure you want to change status to ${status}?`)) {
                let url = `${customersUrl}/${id}/status`;
                axios.post(url, { _method: 'PUT', status: status })
                    .then(response => {
                        alert("Status updated successfully!");
                        window.location.reload();
                    })
                    .catch(error => {
                        console.error(error);
                        alert("Failed to update status.");
                    });
            }
        }

        function deleteCustomer(id) {
            if (confirm("Are you sure you want to delete this customer?")) {
                let url = `${customersUrl}/${id}`;
                axios.delete(url, { headers: { 'Accept': 'application/json' } })
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

        document.addEventListener("DOMContentLoaded", function() {
            const createBtn = document.getElementById('createSubmitBtn');
            if (createBtn) {
                createBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    submitForm('create', customerBaseUrl, 'POST');
                });
            }

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

                axios.post(url, formData, { headers: { 'Accept': 'application/json' } })
                    .then(response => {
                        document.getElementById(`${type}SuccessMessage`).innerText = response.data.message;
                        document.getElementById(`${type}SuccessMessage`).classList.remove('hidden');
                        form.reset();
                        setTimeout(() => { window.location.reload(); }, 1000);
                    })
                    .catch(error => {
                        btn.disabled = false;
                        loader.classList.add('hidden');
                        if (error.response && error.response.status === 422) {
                            let errors = error.response.data.errors;
                            for (const [key, value] of Object.entries(errors)) {
                                let specificSpan = form.querySelector(`.${key}_error`) || form.querySelector(`.name_error`);
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
        // 2. SEARCH, FILTERS & DRAWER LOGIC (With CSS Variables Injected)
        // ==========================================

        const getMockHistory = (type) => {
            const statuses = ['In Progress', 'Delivered', 'Cancelled', 'Completed'];
            const items = [];
            for (let i = 1; i <= 5; i++) {
                const day = String(Math.floor(Math.random() * 28) + 1).padStart(2, '0');
                const dateStr = `2026-01-${day}`;
                items.push({
                    id: `${type === 'Transaction' ? 'TXN' : type.charAt(0).toUpperCase()}${10000+i}`,
                    name: `${type} Item #${i}`,
                    price: (Math.random() * 200).toFixed(2),
                    date: dateStr,
                    status: type === 'Transaction' ? (Math.random() > 0.5 ? 'Credit' : 'Debit') : statuses[Math.floor(Math.random() * statuses.length)],
                    image: ''
                });
            }
            return items;
        };

        const tabs = [
            { id: 'personal', label: 'Personal Info' },
            { id: 'wallet', label: 'Wallet' },
            { id: 'orders', label: 'Mart Orders' },
            { id: 'bookings', label: 'Bookings History' },
            { id: 'provider_history', label: 'Provider History' },
            { id: 'professional_history', label: 'Professional History' },
            { id: 'transactions', label: 'Transaction History' },
            { id: 'payments', label: 'Payment Methods' },
        ];

        let currentCustomer = null;
        let currentTabData = [];

        document.addEventListener("DOMContentLoaded", function() {
            const searchInput = document.getElementById("customerSearchInput");
            const statusFilter = document.getElementById("statusFilter");
            const tableRows = document.querySelectorAll("#customerTable tbody tr");
            const noResults = document.getElementById("noResults");

            function filterMainTable() {
                const query = searchInput.value.toLowerCase();
                const status = statusFilter.value.toLowerCase();
                let hasVisibleRow = false;

                tableRows.forEach(row => {
                    const name = row.querySelector(".search-name").innerText.toLowerCase();
                    const id = row.querySelector(".search-id").innerText.toLowerCase();
                    const email = row.querySelector(".search-email").innerText.toLowerCase();
                    const rowStatus = row.getAttribute("data-status");

                    const matchesSearch = name.includes(query) || id.includes(query) || email.includes(query);
                    const matchesStatus = status === "all" || rowStatus === status;

                    if (matchesSearch && matchesStatus) {
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
        });

        function showCustomerDetails(customer) {
            const dropdown = document.getElementById(`dropdown-${customer.id}`);
            if (dropdown) dropdown.classList.add('hidden');

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

            if (['orders', 'bookings', 'transactions', 'provider_history', 'rider_history', 'professional_history'].includes(tabId)) {
                initHistoryTab(tabId);
            }
        }

        function renderContent(tabId) {
            const c = currentCustomer;

            // Updated Templates with CSS Variables
            if (tabId === 'personal') {
                const addr = c.address || {};
                return `
                <div class="space-y-6">
                    <div class="theme-bg-card p-6 rounded-xl shadow-sm border theme-border space-y-6">
                        <h3 class="text-lg font-bold theme-text-main flex items-center">
                            <svg class="w-5 h-5 mr-2" style="color: rgb(var(--brand-primary));" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                            Personal Details
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div><label class="text-xs font-semibold theme-text-muted uppercase">Full Name</label><p class="theme-text-main font-medium">${c.name}</p></div>
                            <div><label class="text-xs font-semibold theme-text-muted uppercase">Gender</label><p class="theme-text-main font-medium capitalize">${c.gender}</p></div>
                            <div><label class="text-xs font-semibold theme-text-muted uppercase">DOB</label><p class="theme-text-main font-medium">${c.dob}</p></div>
                            <div><label class="text-xs font-semibold theme-text-muted uppercase">Email</label><p class="theme-text-main font-medium break-all">${c.email}</p></div>
                            <div class="md:col-span-2"><label class="text-xs font-semibold theme-text-muted uppercase">Phone</label><p class="theme-text-main font-medium">${c.phone}</p></div>
                        </div>
                    </div>
                    <div class="theme-bg-card p-6 rounded-xl shadow-sm border theme-border space-y-6">
                         <h3 class="text-lg font-bold theme-text-main flex items-center">
                            <svg class="w-5 h-5 mr-2" style="color: rgb(var(--brand-primary));" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.828 0l-4.243-4.243a2 2 0 01-.586-1.414V15.5H5a2 2 0 01-2-2v-4a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2h-1.586a2 2 0 01-1.414.586z"></path></svg>
                            Address
                        </h3>
                        <div class="p-4 theme-bg-body rounded-lg border theme-border">
                             <div class="grid grid-cols-1 gap-4">
                                <div><label class="text-xs font-semibold theme-text-muted uppercase">Street</label><p class="theme-text-main font-medium">${addr.current}</p></div>
                                <div class="grid grid-cols-2 gap-4">
                                     <div><label class="text-xs font-semibold theme-text-muted uppercase">City</label><p class="theme-text-main font-medium">${addr.city}</p></div>
                                     <div><label class="text-xs font-semibold theme-text-muted uppercase">Zip</label><p class="theme-text-main font-medium">${addr.zip}</p></div>
                                </div>
                             </div>
                        </div>
                    </div>
                </div>`;
            }

            if (tabId === 'wallet') {
                return `
                <div class="space-y-6">
                    <div class="p-6 rounded-2xl shadow-lg text-white" style="background: linear-gradient(135deg, rgb(var(--brand-primary)), rgb(var(--brand-secondary)));">
                        <div class="flex justify-between items-start">
                            <div><p class="text-white/80 text-sm font-medium mb-1">Total Balance</p><h2 class="text-4xl font-extrabold tracking-tight">$${c.wallet_balance.toFixed(2)}</h2></div>
                            <div class="bg-white/20 p-2 rounded-lg backdrop-blur-sm"><svg class="w-8 h-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg></div>
                        </div>
                        <div class="mt-6 flex items-center justify-between">
                            <div class="flex items-center space-x-2"><span class="bg-yellow-400 text-yellow-900 text-xs font-bold px-2 py-1 rounded-full flex items-center">⭐ ${c.rewards} Points</span></div>
                        </div>
                    </div>
                </div>`;
            }

            if (tabId === 'payments') {
                const methods = c.payment_methods || [];
                return `<div class="theme-bg-card p-6 rounded-xl shadow-sm border theme-border"><h3 class="text-lg font-bold theme-text-main mb-4">Payment Methods</h3>${methods.length > 0 ? '' : '<p class="theme-text-muted italic text-sm">No saved payment methods (N/A).</p>'}</div>`;
            }

            const typeMap = { 'orders': 'Order', 'bookings': 'Booking', 'transactions': 'Transaction', 'provider_history': 'Provider Service', 'rider_history': 'Ride', 'professional_history': 'Professional Service' };
            const title = typeMap[tabId];
            return `
                <div class="space-y-4">
                    <div id="list-container-${tabId}" class="space-y-3 min-h-[200px]"></div>
                    <div class="pt-4 text-center border-t theme-border"><button class="inline-flex items-center px-4 py-2 theme-bg-card border theme-border rounded-md font-semibold text-xs theme-text-main uppercase tracking-widest shadow-sm hover:bg-white/5">View All ${title}s</button></div>
                </div>`;
        }

        function initHistoryTab(tabId) {
            const typeMap = { 'orders': 'Order', 'bookings': 'Booking', 'transactions': 'Transaction', 'provider_history': 'Provider Service', 'rider_history': 'Ride', 'professional_history': 'Professional Service' };
            currentTabData = getMockHistory(typeMap[tabId]);
            renderHistoryList(tabId, currentTabData);
        }

        function renderHistoryList(tabId, data) {
            const container = document.getElementById(`list-container-${tabId}`);
            if (data.length === 0) {
                container.innerHTML = `<div class="text-center py-8 theme-text-muted text-sm italic">No records found.</div>`;
                return;
            }
            container.innerHTML = data.map(item => {
                if (tabId === 'transactions') {
                    const isCredit = item.status === 'Credit';
                    return `<div class="theme-bg-card p-3 rounded-lg border theme-border flex items-center justify-between shadow-sm"><div class="flex items-center gap-3"><div class="h-10 w-10 rounded-full ${isCredit ? 'bg-green-500/10' : 'bg-red-500/10'} flex items-center justify-center"><span class="font-bold ${isCredit ? 'text-green-500' : 'text-red-500'}">${isCredit ? '↓' : '↑'}</span></div><div><p class="text-sm font-bold theme-text-main">${item.name}</p><p class="text-xs theme-text-muted">${item.date} &bull; ${item.id}</p></div></div><div class="text-right"><p class="text-sm font-bold ${isCredit?'text-green-500':'theme-text-main'}">${isCredit?'+':'-'}$${item.price}</p><p class="text-xs theme-text-muted capitalize">${item.status}</p></div></div>`;
                }
                return `<div class="theme-bg-card p-4 rounded-xl border theme-border shadow-sm hover:shadow-md transition-shadow flex flex-col sm:flex-row sm:items-center justify-between gap-4"><div class="flex items-center gap-4"><div class="h-12 w-12 rounded-lg theme-bg-body flex items-center justify-center theme-text-muted text-xs font-bold">IMG</div><div><h4 class="text-sm font-bold theme-text-main">${item.name}</h4><p class="text-xs theme-text-muted">ID: #${item.id} &bull; ${item.date}</p></div></div><div class="text-right flex items-center justify-between sm:block w-full sm:w-auto"><div><p class="text-sm font-bold theme-text-main">$${item.price}</p><span class="inline-block px-2 py-0.5 rounded text-[10px] font-bold uppercase tracking-wide bg-blue-500/10 text-blue-500">${item.status}</span></div></div></div>`;
            }).join('');
        }
    </script>
@endpush