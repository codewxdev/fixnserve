@extends('layouts.app')

{{-- Mock Data for demonstration --}}
@php
    $customers = [
        [
            'id' => 1001,
            'name' => 'Alex Johnson',
            'email' => 'alex.j@example.com',
            'phone' => '+1 (555) 123-4567',
            'email_verified' => true,
            'status' => 'verified',
            'wallet_balance' => 450.75,
            'rewards' => 120,
            'default_address' => '45 River St, Suite 101, New York, NY 10001',
            'secondary_address' => '123 Main St, Apt 2B, Brooklyn, NY 11201', // Added for Addresses tab
            'login_history' => [
                ['date' => '2025-12-03 14:30:00', 'ip' => '192.168.1.1', 'device' => 'Chrome on Windows 10'],
                ['date' => '2025-12-01 09:05:00', 'ip' => '10.0.0.5', 'device' => 'Safari on iPhone 14'],
            ],
            'active_devices' => [ // Added for Login & Devices
                ['id' => 1, 'type' => 'Desktop', 'location' => 'New York, US', 'last_active' => 'Now'],
                ['id' => 2, 'type' => 'Mobile', 'location' => 'New York, US', 'last_active' => '3 hours ago'],
            ],
            'total_orders' => 15,
            'last_login' => '2025-12-03 14:30:00',
        ],
        [
            'id' => 1002,
            'name' => 'Sarah Connor',
            'email' => 's.connor@sky.net',
            'phone' => '+44 20 7946 0998',
            'email_verified' => false,
            'status' => 'pending',
            'wallet_balance' => 12.0,
            'rewards' => 5,
            'default_address' => 'Unit 3, Cyberdine Towers, London SW1A 0AA',
            'secondary_address' => 'N/A',
            'login_history' => [
                ['date' => '2025-11-28 10:15:00', 'ip' => '82.12.34.56', 'device' => 'Firefox on Linux'],
            ],
            'active_devices' => [
                ['id' => 3, 'type' => 'Tablet', 'location' => 'London, UK', 'last_active' => '6 days ago'],
            ],
            'total_orders' => 2,
            'last_login' => '2025-11-28 10:15:00',
        ],
        [
            'id' => 1003,
            'name' => 'Rajesh Sharma',
            'email' => 'rajesh.s@india.in',
            'phone' => '+91 8000 12345',
            'email_verified' => true,
            'status' => 'verified',
            'wallet_balance' => 2000.5,
            'rewards' => 550,
            'default_address' => 'Plot 7, Silicon Valley Rd, Bangalore 560001',
            'secondary_address' => 'Flat 401, Tech Park View, Mumbai 400001',
            'login_history' => [
                ['date' => '2025-12-04 11:05:00', 'ip' => '203.0.113.44', 'device' => 'Chrome on Android 13'],
            ],
            'active_devices' => [
                ['id' => 4, 'type' => 'Mobile', 'location' => 'Bangalore, IN', 'last_active' => 'Now'],
            ],
            'total_orders' => 48,
            'last_login' => '2025-12-04 11:05:00',
        ],
        [
            'id' => 1004,
            'name' => 'Emily White',
            'email' => 'emily.w@mail.com',
            'phone' => '+61 412 345 678',
            'email_verified' => true,
            'status' => 'verified',
            'wallet_balance' => 90.1,
            'rewards' => 30,
            'default_address' => '54 Ocean View Drive, Sydney NSW 2000',
            'secondary_address' => 'N/A',
            'login_history' => [
                ['date' => '2025-12-02 18:55:00', 'ip' => '54.240.197.100', 'device' => 'Edge on MacOS'],
            ],
            'active_devices' => [
                ['id' => 5, 'type' => 'Laptop', 'location' => 'Sydney, AU', 'last_active' => '2 days ago'],
            ],
            'total_orders' => 8,
            'last_login' => '2025-12-02 18:55:00',
        ],
    ];
@endphp

@section('content')
    <div class="p-6 sm:p-4 min-h-screen bg-gray-50">
        <header class="mb-8">
            <h1 class="text-3xl font-extrabold text-gray-900">Customer Management </h1>
            <p class="mt-1 text-lg text-gray-500">Overview and comprehensive management of all registered customers.</p>
        </header>

        {{-- Search, Filter, and Action Bar --}}
        <div class="flex flex-col md:flex-row gap-4 mb-8">
            {{-- Search Input --}}
            <div class="relative flex-grow">
                <input type="text" id="customerSearch" placeholder="Search by name, email, or ID..."
                    class="w-full p-3 pl-10 border border-gray-300 rounded-xl shadow-sm focus:ring-indigo-500 focus:border-indigo-500 transition duration-150 ease-in-out">
                <svg class="absolute left-3 top-1/2 transform -translate-y-1/2 w-5 h-5 text-gray-400" fill="none"
                    stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
            </div>

            {{-- Filters & Add Button --}}
            <div class="flex space-x-3">
                <button
                    class="flex items-center space-x-2 px-4 py-2 bg-white text-gray-700 border border-gray-300 rounded-xl shadow-sm hover:bg-gray-50 transition duration-150 ease-in-out">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z">
                        </path>
                    </svg>
                    <span>Filter</span>
                </button>
                <button
                    class="flex items-center space-x-2 px-4 py-2 bg-indigo-600 text-white rounded-xl shadow-lg shadow-indigo-200 hover:bg-indigo-700 transition duration-150 ease-in-out">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    <span>Add Customer</span>
                </button>
            </div>
        </div>

        {{-- Customer Table Card --}}
        <div class="bg-white rounded-3xl shadow-2xl p-6 table-container overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 customer-table">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="py-3 px-6 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider cursor-pointer sortable"
                            data-sort="name">
                            Customer
                            <span class="sort-icon ml-1">↓</span>
                        </th>
                        <th class="py-3 px-6 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                            Contact / Status
                        </th>
                        <th class="py-3 px-6 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider cursor-pointer sortable"
                            data-sort="wallet_balance">
                            Wallet / Rewards
                            <span class="sort-icon ml-1 hidden"></span>
                        </th>
                         <th class="py-3 px-6 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider cursor-pointer sortable"
                            data-sort="total_orders">
                            Orders
                            <span class="sort-icon ml-1 hidden"></span>
                        </th>
                        <th class="py-3 px-6 text-center text-xs font-semibold text-gray-500 uppercase tracking-wider">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach ($customers as $customer)
                        <tr class="hover:bg-indigo-50/50 transition duration-150 row-{{ $customer['id'] }}">
                            {{-- 1. Customer Info --}}
                            <td class="py-4 px-6 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10">
                                        <span
                                            class="h-10 w-10 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600 font-bold text-sm">{{ $customer['name'][0] }}</span>
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900">{{ $customer['name'] }}</div>
                                        <div class="text-xs text-gray-500">ID: #{{ $customer['id'] }}</div>
                                    </div>
                                </div>
                            </td>

                            {{-- 2. Contact & Verification Statuses --}}
                            <td class="py-4 px-6">
                                <div class="text-sm text-gray-900">{{ $customer['email'] }}</div>
                                <div class="text-xs text-gray-500 mt-1 flex space-x-2 items-center">
                                    <span
                                        class="flex items-center space-x-1 @if ($customer['email_verified']) text-green-600 @else text-red-500 @endif">
                                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z">
                                            </path>
                                            <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"></path>
                                        </svg>
                                        <span>Email: {{ $customer['email_verified'] ? 'V' : 'X' }}</span>
                                    </span>
                                    <span class="text-gray-400">|</span>
                                    <span
                                        class="text-xs font-semibold px-2 py-0.5 rounded-full @if ($customer['status'] == 'verified') bg-green-100 text-green-800 @elseif($customer['status'] == 'pending') bg-yellow-100 text-yellow-800 @else bg-red-100 text-red-800 @endif">
                                        {{ $customer['status'] }}
                                    </span>
                                </div>
                            </td>

                            {{-- 3. Wallet Balance & Rewards --}}
                            <td class="py-4 px-6 text-right whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">
                                    <span class="font-bold">${{ number_format($customer['wallet_balance'], 2) }}</span>
                                    <span class="text-xs text-gray-500 block">Wallet</span>
                                </div>
                                <div class="text-xs text-indigo-600 font-semibold mt-1">
                                    {{ $customer['rewards'] }} pts
                                    <span class="text-xs text-gray-500">Rewards</span>
                                </div>
                            </td>
                            
                             {{-- 4. Order Count --}}
                            <td class="py-4 px-6 text-right whitespace-nowrap">
                                <div class="text-sm font-bold text-gray-900">{{ $customer['total_orders'] }}</div>
                                <div class="text-xs text-gray-500">Total</div>
                            </td>

                            {{-- 5. Quick Actions --}}
                            <td class="py-4 px-6 text-center whitespace-nowrap space-x-2">
                                {{-- View Details Button --}}
                                <button onclick="showCustomerDetails({{ json_encode($customer) }})"
                                    class="view-btn text-indigo-600 hover:text-indigo-900 font-medium p-2 rounded-full hover:bg-indigo-100 transition duration-150"
                                    title="View Full Profile">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 6h16M4 10h16M4 14h16M4 18h16"></path>
                                    </svg>
                                </button>

                                {{-- Dropdown Container for More Actions (The Three Dots) --}}
                                <div class="relative inline-block text-left">
                                    <button onclick="toggleDropdown({{ $customer['id'] }})"
                                        id="options-menu-button-{{ $customer['id'] }}"
                                        class="action-btn hover:text-gray-900 p-2 rounded-full hover:bg-gray-100 transition duration-150"
                                        title="More Actions" aria-expanded="false" aria-haspopup="true">
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                                            xmlns="http://www.w3.org/2000/svg">
                                            {{-- Vertical Dots SVG --}}
                                            <path
                                                d="M10 6a2 2 0 110-4 2 2 0 010 4zm0 6a2 2 0 110-4 2 2 0 010 4zm0 6a2 2 0 110-4 2 2 0 010 4z">
                                            </path>
                                        </svg>
                                    </button>

                                    {{-- Dropdown Menu (Hidden by default) --}}
                                    <div id="dropdown-menu-{{ $customer['id'] }}"
                                        class="origin-top-right absolute right-0 mt-2 w-40 rounded-xl shadow-xl bg-white ring-1 ring-black ring-opacity-5 z-20 hidden action-dropdown">
                                        <div class="py-1" role="none">
                                            <button onclick="handleAction('Ban', {{ $customer['id'] }})"
                                                class="text-red-600 flex items-center w-full text-left px-4 py-2 text-sm hover:bg-red-50 rounded-lg transition">
                                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636">
                                                    </path>
                                                </svg>Ban User
                                            </button>
                                            <button onclick="handleAction('Suspend', {{ $customer['id'] }})"
                                                class="text-yellow-600 flex items-center w-full text-left px-4 py-2 text-sm hover:bg-yellow-50 rounded-lg transition">
                                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.368 17c-.77 1.333.192 3 1.732 3z">
                                                    </path>
                                                </svg>Suspend
                                            </button>
                                            <button onclick="handleAction('Delete', {{ $customer['id'] }})"
                                                class="text-gray-600 flex items-center w-full text-left px-4 py-2 text-sm hover:bg-gray-50 rounded-lg transition">
                                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                        </path>
                                                    </svg>Delete
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Customer Profile Drawer (Modal/Off-Canvas Simulation) --}}
        <div id="customer-details-modal" class="fixed inset-0 z-50 overflow-y-auto hidden" aria-labelledby="modal-title"
            role="dialog" aria-modal="true">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                {{-- Background overlay --}}
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"
                    onclick="hideCustomerDetails()"></div>

                {{-- Drawer Content --}}
                <div class="fixed inset-y-0 right-0 max-w-full flex">
                    {{-- Increased max-w-lg to max-w-xl for more content space --}}
                    <div class="w-screen "> 
                        <div class="h-full flex flex-col bg-white shadow-2xl overflow-y-auto">
                            
                            {{-- Header --}}
                            <div class="flex flex-col p-6 border-b border-gray-200 sticky top-0 bg-white z-10">
                                <div class="flex items-center justify-between">
                                    <h3 class="text-2xl font-bold text-gray-900" id="detail-profile-name"></h3>
                                    <button type="button"
                                        class="ml-3 h-7 w-7 rounded-full text-gray-400 hover:text-gray-500 hover:bg-gray-100 transition"
                                        onclick="hideCustomerDetails()">
                                        <span class="sr-only">Close panel</span>
                                        <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </button>
                                </div>
                                <div class="mt-1 text-sm text-gray-500" id="detail-profile-email"></div>
                            </div>
                            
                            {{-- Tabs Navigation --}}
                            <div class="border-b border-gray-200 sticky top-20 bg-white z-10">
                                <nav class="-mb-px flex space-x-8 px-6" id="profile-tabs">
                                    {{-- Tabs will be rendered here by JS --}}
                                </nav>
                            </div>

                            {{-- Tab Content (Scrollable Area) --}}
                            <div class="p-6 space-y-8 flex-grow overflow-y-auto">
                                <div id="tab-content">
                                    {{-- Content for the selected tab will be loaded here by JS --}}
                                </div>
                            </div>
                            
                             {{-- Sticky Footer Actions --}}
                            <div class="flex justify-end p-4 border-t border-gray-200 sticky bottom-0 bg-white z-10">
                                <button
                                    class="px-4 py-2 bg-red-600 text-white rounded-xl shadow-lg hover:bg-red-700 transition duration-150 ease-in-out"
                                    onclick="handleActionFromDrawer('Ban', currentCustomerId)">Ban Customer</button>
                                <button
                                    class="ml-3 px-4 py-2 bg-yellow-600 text-white rounded-xl shadow-lg hover:bg-yellow-700 transition duration-150 ease-in-out"
                                    onclick="handleActionFromDrawer('Suspend', currentCustomerId)">Suspend Account</button>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


@push('styles')
    <style>
        h1{
            font-family: 'Inter' !important;
        }
        /* Custom Styles for Professional Look */
        .table-container {
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.15), 0 0 0 1px rgba(0, 0, 0, 0.05);
        }
        .max-w-full{
            max-width: 70% !important;
        }
        .customer-table th,
        .customer-table td {
            padding-left: 1.5rem;
            padding-right: 1.5rem;
        }

        /* Active Tab Styling */
        .tab-active {
            border-color: #4f46e5;
            color: #4f46e5;
            font-weight: 600;
        }

        /* Modern card styles for tabs */
        .info-card {
            padding: 1.5rem;
            border-radius: 1rem; /* xl */
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            transition: transform 0.2s;
        }

        .info-card:hover {
            transform: translateY(-2px);
        }
    </style>
@endpush


@push('scripts')
<script>
document.getElementById("customerSearch").addEventListener("keyup", function () {
    const value = this.value.toLowerCase();
    const rows = document.querySelectorAll(".customer-table tbody tr");

    rows.forEach(row => {
        const name = row.querySelector("td .text-sm.font-medium").innerText.toLowerCase();
        const email = row.querySelector("td:nth-child(2) .text-sm").innerText.toLowerCase();
        const anyText = row.innerText.toLowerCase(); // also search total text

        if (name.includes(value) || email.includes(value) || anyText.includes(value)) {
            row.style.display = "";
        } else {
            row.style.display = "none";
        }
    });
});
</script>

    <script>
        let currentCustomerData = null;
        let currentCustomerId = null;
        
        // Tab definitions for the Profile Drawer
        const profileTabs = [
            { id: 'personal-info', name: 'Profile Details ' },
            { id: 'orders', name: 'Order History ' },
            { id: 'wallet-transactions', name: 'Wallet & Finance ' },
            { id: 'addresses', name: 'Addresses' },
            { id: 'security', name: 'Login & Devices' },
            { id: 'support', name: 'Complaints & Refunds' },
            { id: 'saved-providers', name: 'Saved Providers' },
        ];


        // Function to render the content for the selected tab
        function renderTabContent(tabId, customer) {
            const contentDiv = document.getElementById('tab-content');
            let html = '';

            // Helper function for status badge
            const getStatusBadge = (isVerified) => isVerified 
                ? '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800"><svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg> Verified</span>' 
                : '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800"><svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path></svg> Unverified</span>';

            // --- Mock Data for Tabs Content (Modern UI) ---
            const mockOrders = [
                { id: 'O1045', type: 'Service Booking (Plumbing)', amount: 85.00, date: '2025-11-28', status: 'Completed', provider: 'PipeFix Pro' },
                { id: 'O1044', type: 'Mart Order (Groceries)', amount: 120.50, date: '2025-11-25', status: 'Delivered', provider: 'QuickMart' },
                { id: 'O1043', type: 'Consultation (Legal)', amount: 250.00, date: '2025-11-20', status: 'Cancelled', provider: 'Law Associates' },
                { id: 'O1042', type: 'Service Booking (Cleaning)', amount: 55.00, date: '2025-11-18', status: 'Completed', provider: 'Sparkle Clean' },
            ];

            const mockTransactions = [
                { id: 'T205', type: 'Deposit (Card)', amount: 100.00, date: '2025-12-01', status: 'Success' },
                { id: 'T204', type: 'Order Payment (O1045)', amount: -85.00, date: '2025-11-28', status: 'Success' },
                { id: 'T203', type: 'Reward Points Redemption', amount: 5.00, date: '2025-11-25', status: 'Success' },
                { id: 'T202', type: 'Withdrawal', amount: -200.00, date: '2025-11-20', status: 'Success' },
            ];

            const mockComplaints = [
                { title: 'Late Service Arrival', type: 'Complaints Filed', count: 2, color: 'bg-red-500', icon: 'M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z' },
                { title: 'Refund Requests', type: 'Refund Requests', count: 1, color: 'bg-yellow-500', icon: 'M9 8h6m-5 0v4m0 4h.01M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z' },
                { title: 'Appeal Submissions', type: 'Appeals Submitted', count: 0, color: 'bg-blue-500', icon: 'M9 12l2 2 4-4m5.656 8.344A8 8 0 1012 4.344a8 8 0 000 16.924M12 12h.01' },
            ];
            
            const mockProviders = [
                { name: 'Eco-Friendly Cleaners', category: 'Cleaning Service', rating: 4.8, image: '🏡', reviews: 450 },
                { name: 'Dr. Anya Sharma', category: 'Health Consultant', rating: 4.9, image: '⚕️', reviews: 120 },
                { name: 'Tech Repair Hub', category: 'Electronics Repair', rating: 4.2, image: '🔧', reviews: 88 },
                { name: 'The Urban Farmer Mart', category: 'Grocery/Mart', rating: 4.5, image: '🛒', reviews: 300 },
            ];
            // --- End Mock Data ---


            switch (tabId) {
                case 'personal-info':
                    // Profile Details Tab: Remove KYC status entirely. Keep only: Customer ID, Phone, Email Verified.
                    const emailVerifiedText = customer.email_verified ? 'Verified' : 'Unverified';
                    html = `
                        <div class="bg-white info-card shadow-lg border border-gray-100">
                            <h4 class="text-xl font-bold text-gray-900 mb-6 flex items-center"><svg class="w-6 h-6 mr-3 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg> Profile Details</h4>
                            <dl class="grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-4">
                                <div class="border-b border-gray-100 pb-2">
                                    <dt class="font-medium text-gray-500 flex items-center"><svg class="w-4 h-4 mr-1 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-6 0v2m0 0h2m0 0v-2m0 0H7"></path></svg> Customer ID:</dt>
                                    <dd class="text-lg font-semibold text-gray-900 font-mono">#${customer.id}</dd>
                                </div>
                                <div class="border-b border-gray-100 pb-2">
                                    <dt class="font-medium text-gray-500 flex items-center"><svg class="w-4 h-4 mr-1 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-1.55l-3.24 3.24A1 1 0 0113.8 20H10.2a1 1 0 01-.71-.29l-3.24-3.24H5a2 2 0 01-2-2V5z"></path></svg> Phone:</dt>
                                    <dd class="text-lg font-medium text-gray-900">${customer.phone}</dd>
                                </div>
                                <div class="border-b border-gray-100 pb-2">
                                    <dt class="font-medium text-gray-500 flex items-center"><svg class="w-4 h-4 mr-1 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg> Email Verified:</dt>
                                    <dd>${getStatusBadge(customer.email_verified)}</dd>
                                </div>
                            </dl>
                        </div>
                    `;
                    break;

                case 'orders':
                    // Order History Tab: Add modern, clean, professional static order history.
                    html = `
                        <div class="info-card bg-white shadow-lg border border-gray-100">
                            <h4 class="text-2xl font-extrabold text-gray-900 mb-6 flex items-center"><svg class="w-6 h-6 mr-3 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg> Order History</h4>
                            <h5 class="text-lg font-bold text-gray-700 mb-4 border-b pb-2">Latest (Last 1 Month)</h5>
                            
                            <div class="space-y-4">
                                ${mockOrders.slice(0, 4).map(order => `
                                    <div class="p-4 border border-gray-100 rounded-xl flex justify-between items-center hover:bg-gray-50 transition duration-150">
                                        <div>
                                            <p class="text-sm font-semibold text-gray-900">${order.type}</p>
                                            <p class="text-xs text-gray-500">ID: #${order.id} | ${order.date}</p>
                                            <p class="text-xs text-indigo-500">Provider: ${order.provider}</p>
                                        </div>
                                        <div class="text-right">
                                            <p class="text-lg font-bold ${order.amount > 0 ? 'text-green-600' : 'text-red-600'}">\$${order.amount.toFixed(2)}</p>
                                            <span class="text-xs font-semibold px-2 py-0.5 rounded-full ${order.status === 'Completed' || order.status === 'Delivered' ? 'bg-green-100 text-green-800' : (order.status === 'Cancelled' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800')}">${order.status}</span>
                                        </div>
                                    </div>
                                `).join('')}
                            </div>

                            <div class="mt-6 text-center">
                                <button class="px-6 py-2 bg-indigo-600 text-white font-semibold rounded-full shadow-md hover:bg-indigo-700 transition duration-150 ease-in-out">
                                    See Full History
                                </button>
                            </div>
                        </div>
                    `;
                    break;

                case 'wallet-transactions':
                    // Wallet & Finance Tab: Add modern static wallet transaction list for the month. Show Current Wallet Balance and Reward Points at the top.
                    html = `
                        <div class="info-card bg-white shadow-lg border border-gray-100">
                            <h4 class="text-2xl font-extrabold text-gray-900 mb-6 flex items-center"><svg class="w-6 h-6 mr-3 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m4 6h3m-3-6a4 4 0 100-8 4 4 0 000 8zM9 16h6a2 2 0 002-2v-3a2 2 0 00-2-2H9a2 2 0 00-2 2v3a2 2 0 002 2z"></path></svg> Wallet & Finance</h4>
                            
                            <div class="grid grid-cols-2 gap-4 mb-6">
                                <div class="p-4 bg-green-50 rounded-xl flex flex-col justify-center items-center">
                                    <p class="text-sm font-medium text-green-700">Current Wallet Balance</p>
                                    <p class="text-3xl font-extrabold text-green-600 mt-1">$${customer.wallet_balance.toFixed(2)}</p>
                                </div>
                                <div class="p-4 bg-indigo-50 rounded-xl flex flex-col justify-center items-center">
                                    <p class="text-sm font-medium text-indigo-700">Reward Points</p>
                                    <p class="text-3xl font-extrabold text-indigo-600 mt-1">${customer.rewards} pts</p>
                                </div>
                            </div>

                            <h5 class="text-lg font-bold text-gray-700 mb-4 border-b pb-2">Recent Transactions (This Month)</h5>
                            
                            <div class="space-y-3">
                                ${mockTransactions.map(txn => `
                                    <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg">
                                        <div class="flex items-center space-x-3">
                                            <span class="text-xl ${txn.amount > 0 ? 'text-green-500' : 'text-red-500'}">${txn.amount > 0 ? '↑' : '↓'}</span>
                                            <div>
                                                <p class="text-sm font-medium text-gray-900">${txn.type}</p>
                                                <p class="text-xs text-gray-500">${txn.date} | ID: ${txn.id}</p>
                                            </div>
                                        </div>
                                        <p class="text-sm font-bold ${txn.amount > 0 ? 'text-green-600' : 'text-red-600'}">${txn.amount > 0 ? '+' : ''}\$${Math.abs(txn.amount).toFixed(2)}</p>
                                    </div>
                                `).join('')}
                            </div>

                            <div class="mt-6 text-center">
                                <button class="px-6 py-2 bg-green-600 text-white font-semibold rounded-full shadow-md hover:bg-green-700 transition duration-150 ease-in-out">
                                    View Full Transactions
                                </button>
                            </div>
                        </div>
                    `;
                    break;

                case 'addresses':
                    // Addresses Tab: Add 2–3 modern static addresses (card UI, icons).
                    const address2 = customer.secondary_address && customer.secondary_address !== 'N/A' 
                        ? customer.secondary_address 
                        : 'No Secondary Address Saved';
                    
                    html = `
                        <div class="info-card bg-white shadow-lg border border-gray-100">
                            <h4 class="text-2xl font-extrabold text-gray-900 mb-6 flex items-center"><svg class="w-6 h-6 mr-3 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.828 0l-4.243-4.243a2 2 0 01-.586-1.414V15.5H5a2 2 0 01-2-2v-4a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2h-1.586a2 2 0 01-1.414.586z"></path></svg> Addresses</h4>
                            
                            <div class="space-y-6">
                                <div class="p-4 border-2 border-indigo-200 bg-indigo-50 rounded-xl">
                                    <div class="flex items-center justify-between mb-2">
                                        <h5 class="font-bold text-indigo-700 flex items-center"><svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3"></path></svg> Default Address</h5>
                                        <span class="text-xs font-semibold text-white bg-indigo-500 px-3 py-1 rounded-full">Primary</span>
                                    </div>
                                    <p class="text-sm text-gray-700">${customer.default_address}</p>
                                </div>
                                
                                <div class="p-4 border border-gray-200 bg-white rounded-xl">
                                    <div class="flex items-center mb-2">
                                        <h5 class="font-bold text-gray-700 flex items-center"><svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H9a1 1 0 01-1-1v-1a4 4 0 014-4h.01"></path></svg> Secondary Address</h5>
                                    </div>
                                    <p class="text-sm ${address2 === 'No Secondary Address Saved' ? 'text-gray-500 italic' : 'text-gray-700'}">${address2}</p>
                                </div>
                            </div>
                            
                            <div class="mt-6 text-center">
                                <button class="px-6 py-2 bg-gray-200 text-gray-700 font-semibold rounded-full shadow-sm hover:bg-gray-300 transition duration-150 ease-in-out">
                                    View All Stored Addresses
                                </button>
                            </div>
                        </div>
                    `;
                    break;

                case 'security':
                    // Login & Devices Tab: Refine design: Show Login History, Show Devices section.
                    html = `
                        <div class="info-card bg-white shadow-lg border border-gray-100">
                            <h4 class="text-2xl font-extrabold text-gray-900 mb-6 flex items-center"><svg class="w-6 h-6 mr-3 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.24a8 8 0 10-11.236 11.236 8 8 0 0011.236-11.236z"></path></svg> Login & Devices</h4>
                            
                            <h5 class="text-lg font-bold text-gray-700 mb-4 border-b pb-2 flex items-center"><svg class="w-5 h-5 mr-2 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg> Active Devices (${customer.active_devices.length})</h5>
                            <div class="space-y-3 mb-6 p-4 bg-red-50 rounded-xl">
                                ${customer.active_devices.map(device => `
                                    <div class="flex justify-between items-center text-sm">
                                        <div class="font-medium text-gray-900">${device.type} - ${device.location}</div>
                                        <div class="${device.last_active === 'Now' ? 'text-green-600 font-bold' : 'text-gray-500'}">${device.last_active}</div>
                                    </div>
                                `).join('')}
                                <button class="mt-3 w-full text-center text-sm font-semibold text-red-600 hover:text-red-700 transition">Logout All Other Devices</button>
                            </div>

                            <h5 class="text-lg font-bold text-gray-700 mb-4 border-b pb-2 flex items-center"><svg class="w-5 h-5 mr-2 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg> Recent Login History</h5>
                            <ul class="space-y-2">
                                ${customer.login_history.map(login => `
                                    <li class="flex justify-between items-start text-sm p-2 rounded-lg hover:bg-gray-50">
                                        <div>
                                            <p class="font-medium text-gray-900">${login.date}</p>
                                            <p class="text-xs text-gray-500">${login.device}</p>
                                        </div>
                                        <p class="text-xs text-gray-400">${login.ip}</p>
                                    </li>
                                `).join('')}
                            </ul>
                        </div>
                    `;
                    break;
                case 'support':
                    // Complaints & Refunds Tab: Add 3 static blocks: Complaints Filed, Refund Requests, Appeals Submitted.
                    html = `
                        <div class="info-card bg-white shadow-lg border border-gray-100">
                            <h4 class="text-2xl font-extrabold text-gray-900 mb-6 flex items-center"><svg class="w-6 h-6 mr-3 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.22 0 4 1.28 4 3s-1.78 3-4 3c-.22 0-.44-.022-.656-.065M15 12a4.9 4.9 0 01-1.28 3.344M18.8 16.5A8.963 8.963 0 0012 21a9 9 0 01-9-9 8.963 8.963 0 002.8-6.5"></path></svg> Complaints & Refunds</h4>
                            
                            <div class="grid grid-cols-3 gap-4">
                                ${mockComplaints.map(block => `
                                    <div class="info-card p-4 text-center ${block.color.replace('bg-', 'bg-')}-50 border border-${block.color.replace('bg-', 'bg-')}-200">
                                        <div class="text-2xl font-bold text-gray-900">${block.count}</div>
                                        <p class="text-sm font-medium ${block.color.replace('bg-', 'text-')}-700 mt-1">${block.title}</p>
                                        <div class="mt-2">
                                            <svg class="w-6 h-6 mx-auto ${block.color.replace('bg-', 'text-')}-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="${block.icon}"></path></svg>
                                        </div>
                                    </div>
                                `).join('')}
                            </div>
                            
                            <div class="mt-6 text-center">
                                <button class="px-6 py-2 bg-blue-600 text-white font-semibold rounded-full shadow-md hover:bg-blue-700 transition duration-150 ease-in-out">
                                    View Support Tickets
                                </button>
                            </div>
                        </div>
                    `;
                    break;
                case 'saved-providers':
                    // Saved Providers Tab: Add 3–4 static saved providers with card UI, provider image/icon, rating, category.
                    html = `
                        <div class="info-card bg-white shadow-lg border border-gray-100">
                            <h4 class="text-2xl font-extrabold text-gray-900 mb-6 flex items-center"><svg class="w-6 h-6 mr-3 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg> Saved Providers</h4>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                ${mockProviders.map(provider => `
                                    <div class="p-4 bg-purple-50 rounded-xl flex items-center space-x-4 border border-purple-200 hover:shadow-lg transition">
                                        <div class="flex-shrink-0 text-3xl h-12 w-12 flex items-center justify-center rounded-full bg-white shadow-sm">${provider.image}</div>
                                        <div class="flex-grow">
                                            <p class="text-lg font-bold text-purple-800">${provider.name}</p>
                                            <p class="text-xs text-gray-500">${provider.category}</p>
                                        </div>
                                        <div class="text-right">
                                            <p class="text-sm font-bold text-yellow-500 flex items-center">
                                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.638-.921 1.94 0l1.246 3.823a1 1 0 00.95.691h4.024c.969 0 1.371 1.243.588 1.81l-3.25 2.365a1 1 0 00-.364 1.118l1.246 3.823c.3.921-.755 1.688-1.54 1.118L10 15.352l-3.25 2.365c-.783.57-1.841-.197-1.54-1.118l1.246-3.823a1 1 0 00-.364-1.118L2.093 9.251c-.783-.567-.381-1.81.588-1.81h4.024a1 1 0 00.95-.691l1.246-3.823z"></path></svg>
                                                ${provider.rating}
                                            </p>
                                            <p class="text-xs text-gray-500">(${provider.reviews} reviews)</p>
                                        </div>
                                    </div>
                                `).join('')}
                            </div>

                            <div class="mt-6 text-center">
                                <button class="px-6 py-2 bg-purple-600 text-white font-semibold rounded-full shadow-md hover:bg-purple-700 transition duration-150 ease-in-out">
                                    Manage Favorites
                                </button>
                            </div>
                        </div>
                    `;
                    break;
            }

            contentDiv.innerHTML = html;
        }

        // Function to handle tab clicks
        function activateTab(tabId, customer) {
            // Remove active classes from all tabs
            document.querySelectorAll('#profile-tabs button').forEach(btn => {
                btn.classList.remove('tab-active', 'border-indigo-500', 'text-indigo-600');
                btn.classList.add('border-transparent', 'text-gray-500', 'hover:text-gray-700', 'hover:border-gray-300');
            });

            // Add active classes to the clicked tab
            const activeTab = document.querySelector(`#profile-tabs button[data-tab-id="${tabId}"]`);
            if (activeTab) {
                activeTab.classList.add('tab-active', 'border-indigo-500', 'text-indigo-600');
                activeTab.classList.remove('border-transparent', 'text-gray-500', 'hover:text-gray-700', 'hover:border-gray-300');
            }

            // Render the content
            renderTabContent(tabId, customer);
        }
        
        // Main function to show the drawer
        function showCustomerDetails(customer) {
            currentCustomerData = customer;
            currentCustomerId = customer.id;
            const modal = document.getElementById('customer-details-modal');
            const tabsContainer = document.getElementById('profile-tabs');

            // Set main profile header details
            document.getElementById('detail-profile-name').textContent = `Profile: ${customer.name}`;
            document.getElementById('detail-profile-email').textContent = customer.email;

            // Clear old tabs and render new ones
            tabsContainer.innerHTML = profileTabs.map(tab => ` 
                <button
                    class="tab-btn whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition duration-150 ease-in-out"
                    data-tab-id="${tab.id}"
                    onclick="activateTab('${tab.id}', currentCustomerData)">
                    ${tab.name}
                </button>
            `).join('');

            // Show the modal and activate the first tab
            modal.classList.remove('hidden');
            document.body.classList.add('overflow-hidden'); // Prevent background scroll
            activateTab(profileTabs[0].id, customer);
        }

        // Function to hide the drawer
        function hideCustomerDetails() {
            document.getElementById('customer-details-modal').classList.add('hidden');
            document.body.classList.remove('overflow-hidden');
        }

        // Action Handlers (for buttons inside and outside the drawer)
        function handleAction(action, customerId) {
            alert(`${action} action triggered for Customer ID: #${customerId}`);
            // In a real application, you would make an AJAX call here
        }

        function handleActionFromDrawer(action, customerId) {
            hideCustomerDetails();
            // Give a slight delay so the UI transition is visible before the alert
            setTimeout(() => {
                handleAction(action, customerId);
            }, 300);
        }

        // Dropdown toggle logic
        function toggleDropdown(customerId) {
            const dropdown = document.getElementById(`dropdown-menu-${customerId}`);
            const isHidden = dropdown.classList.contains('hidden');

            // Close all other dropdowns
            document.querySelectorAll('.action-dropdown').forEach(d => {
                d.classList.add('hidden');
            });

            // Toggle the clicked one
            if (isHidden) {
                dropdown.classList.remove('hidden');
                dropdown.setAttribute('aria-expanded', 'true');
            } else {
                dropdown.classList.add('hidden');
                dropdown.setAttribute('aria-expanded', 'false');
            }
        }

        // Close dropdown on click outside
        window.onclick = function(event) {
            if (!event.target.matches('.action-btn, .action-btn *')) {
                document.querySelectorAll('.action-dropdown').forEach(dropdown => {
                    if (!dropdown.classList.contains('hidden')) {
                        dropdown.classList.add('hidden');
                        dropdown.setAttribute('aria-expanded', 'false');
                    }
                });
            }
        }

        // Simple client-side sorting (for demonstration purposes)
        document.addEventListener('DOMContentLoaded', () => {
            const table = document.querySelector('.customer-table');
            const headers = table.querySelectorAll('th.sortable');
            const tbody = table.querySelector('tbody');
            const rows = Array.from(tbody.querySelectorAll('tr'));
            
            headers.forEach(header => {
                header.addEventListener('click', () => {
                    const sortKey = header.dataset.sort;
                    const isAscending = header.classList.contains('asc');
                    const direction = isAscending ? -1 : 1;

                    // Reset all header icons/classes
                    headers.forEach(h => {
                        h.classList.remove('asc', 'desc');
                        h.querySelector('.sort-icon').textContent = '';
                    });

                    // Update clicked header
                    header.classList.add(isAscending ? 'desc' : 'asc');
                    header.querySelector('.sort-icon').textContent = isAscending ? '↑' : '↓';

                    // Find the data index for sorting
                    const sortIndex = headers.indexOf(header);

                    rows.sort((a, b) => {
                        let aVal, bVal;
                        
                        // Extract relevant cell data based on sortKey
                        if (sortKey === 'name') {
                            aVal = a.cells[0].querySelector('.text-sm.font-medium').textContent.trim();
                            bVal = b.cells[0].querySelector('.text-sm.font-medium').textContent.trim();
                        } else if (sortKey === 'wallet_balance') {
                             // Use the full JSON object from the showCustomerDetails function, this is a simplified client-side mock
                             const aId = parseInt(a.querySelector('[class*="row-"]').className.match(/row-(\d+)/)[1]);
                             const bId = parseInt(b.querySelector('[class*="row-"]').className.match(/row-(\d+)/)[1]);
                             
                             const aCustomer = {{ Js::from($customers) }}.find(c => c.id === aId);
                             const bCustomer = {{ Js::from($customers) }}.find(c => c.id === bId);

                             aVal = parseFloat(aCustomer ? aCustomer.wallet_balance : 0);
                             bVal = parseFloat(bCustomer ? bCustomer.wallet_balance : 0);

                        } else if (sortKey === 'total_orders') {
                             // Same logic for total_orders
                             const aId = parseInt(a.querySelector('[class*="row-"]').className.match(/row-(\d+)/)[1]);
                             const bId = parseInt(b.querySelector('[class*="row-"]').className.match(/row-(\d+)/)[1]);
                             
                             const aCustomer = {{ Js::from($customers) }}.find(c => c.id === aId);
                             const bCustomer = {{ Js::from($customers) }}.find(c => c.id === bId);
                             
                             aVal = parseInt(aCustomer ? aCustomer.total_orders : 0);
                             bVal = parseInt(bCustomer ? bCustomer.total_orders : 0);
                        } else {
                            aVal = a.cells[sortIndex].textContent.trim();
                            bVal = b.cells[sortIndex].textContent.trim();
                        }

                        if (typeof aVal === 'string') {
                            return direction * aVal.localeCompare(bVal);
                        } else {
                            return direction * (aVal - bVal);
                        }
                    });

                    // Re-append sorted rows
                    rows.forEach(row => tbody.appendChild(row));
                });
            });
        });
    </script>
@endpush