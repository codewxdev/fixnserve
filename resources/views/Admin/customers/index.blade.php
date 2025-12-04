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
        ],
    ];
@endphp

@section('content')
    <div class="p-6 sm:p-10 min-h-screen bg-gray-50">
        <header class="mb-8">
            <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight">Customer Management</h1>
            <p class="mt-1 text-lg text-gray-500">Overview and management of all registered users.</p>
        </header>

        {{-- Search, Filter, and Action Bar --}}
        <div class="flex flex-col md:flex-row gap-4 mb-8">
            {{-- Search Input --}}
            <div class="relative flex-grow">
                <input type="text" id="customer-search" placeholder="Search by name, email, or ID..."
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
                            Contact / Verification
                        </th>
                        <th class="py-3 px-6 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider cursor-pointer sortable"
                            data-sort="wallet_balance">
                            Wallet / Rewards
                            <span class="sort-icon ml-1 hidden"></span>
                        </th>
                        <th class="py-3 px-6 text-center text-xs font-semibold text-gray-500 uppercase tracking-wider">
                            Quick Actions
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
                                <div class="text-xs text-gray-500 mt-1 flex space-x-2">
                                    <span
                                        class="flex items-center space-x-1 @if ($customer['email_verified']) text-green-600 @else text-red-500 @endif">
                                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z">
                                            </path>
                                            <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"></path>
                                        </svg>
                                        <span>Email</span>
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
                                    ${{ number_format($customer['wallet_balance'], 2) }}
                                    <span class="text-xs text-gray-500 block">Wallet Balance</span>
                                </div>
                                <div class="text-xs text-indigo-600 font-semibold mt-1">
                                    {{ $customer['rewards'] }} pts
                                    <span class="text-xs text-gray-500">Earned Rewards</span>
                                </div>
                            </td>

                            {{-- 4. Quick Actions (UPDATED SECTION: Added Dropdown Menu) --}}
                            <td class="py-4 px-6 text-center whitespace-nowrap space-x-2">
                                {{-- View Details Button --}}
                                <button onclick="showCustomerDetails({{ json_encode($customer) }})"
                                    class="view-btn text-indigo-600 hover:text-indigo-900 font-medium p-1 rounded-full hover:bg-indigo-100 transition duration-150"
                                    title="View Full Details">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                        </path>
                                    </svg>
                                </button>

                                {{-- Ban Customer Button --}}
                                <button
                                    class="action-btn text-red-600 hover:text-red-900 font-medium p-1 rounded-full hover:bg-red-100 transition duration-150"
                                    title="Ban Customer">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636">
                                        </path>
                                    </svg>
                                </button>

                                {{-- Dropdown Container for More Actions (The Three Dots) --}}
                                <div class="relative inline-block text-left">
                                    <button onclick="toggleDropdown({{ $customer['id'] }})"
                                        id="options-menu-button-{{ $customer['id'] }}"
                                        class="action-btn hover:text-gray-900 p-1 rounded-full hover:bg-gray-100 transition duration-150"
                                        title="More Actions" aria-expanded="false" aria-haspopup="true">
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                                            xmlns="http://www.w3.org/2000/svg">
                                            {{-- Vertical Dots SVG --}}
                                            <path d="M10 6a2 2 0 110-4 2 2 0 010 4zm0 6a2 2 0 110-4 2 2 0 010 4zm0 6a2 2 0 110-4 2 2 0 010 4z">
                                            </path>
                                        </svg>
                                    </button>

                                    {{-- Dropdown Menu (Hidden by default) --}}
                                    <div id="dropdown-menu-{{ $customer['id'] }}"
                                        class="origin-top-right absolute right-0 mt-2 w-40 rounded-xl shadow-xl bg-white ring-1 ring-black ring-opacity-5 z-20 hidden action-dropdown">
                                        <div class="py-1" role="none">
                                            <button onclick="handleAction('Suspend', {{ $customer['id'] }})"
                                                class="text-yellow-600 block w-full text-left px-4 py-2 text-sm hover:bg-yellow-50 rounded-lg transition">
                                                Suspend
                                            </button>
                                            <button onclick="handleAction('Delete', {{ $customer['id'] }})"
                                                class="text-red-600 block w-full text-left px-4 py-2 text-sm hover:bg-red-50 rounded-lg transition">
                                                Delete
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

        {{-- Customer Details Modal (Off-Canvas/Drawer Simulation) --}}
        <div id="customer-details-modal" class="fixed inset-0 z-50 overflow-y-auto hidden" aria-labelledby="modal-title"
            role="dialog" aria-modal="true">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                {{-- Background overlay --}}
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"
                    onclick="hideCustomerDetails()"></div>

                {{-- Modal content (Drawer style for a modern look) --}}
                <div class="fixed inset-y-0 right-0 max-w-full flex">
                    <div class="w-screen max-w-lg">
                        <div class="h-full flex flex-col bg-white shadow-xl overflow-y-auto">
                            <div class="flex items-start justify-between p-6 border-b border-gray-200">
                                <h3 class="text-xl font-bold text-gray-900" id="modal-title">Customer Details</h3>
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

                            <div class="p-6 space-y-8 flex-grow">
                                {{-- Section: Personal Information --}}
                                <div class="bg-gray-50 p-4 rounded-xl">
                                    <h4 class="text-lg font-semibold text-gray-800 mb-3">Personal Information</h4>
                                    <dl class="space-y-1 text-sm text-gray-600">
                                        <div class="flex justify-between">
                                            <dt class="font-medium">Full Name:</dt>
                                            <dd id="detail-name"></dd>
                                        </div>
                                        <div class="flex justify-between">
                                            <dt class="font-medium">Email:</dt>
                                            <dd id="detail-email"></dd>
                                        </div>
                                        <div class="flex justify-between">
                                            <dt class="font-medium">Phone:</dt>
                                            <dd id="detail-phone"></dd>
                                        </div>
                                    </dl>
                                </div>

                                {{-- Section: Verification Statuses --}}
                                <div class="bg-indigo-50 p-4 rounded-xl">
                                    <h4 class="text-lg font-semibold text-indigo-800 mb-3">Verification Status</h4>
                                    <dl class="space-y-2 text-sm text-indigo-700">
                                        <div class="flex justify-between items-center">
                                            <dt class="font-medium">Email Verification:</dt>
                                            <dd id="detail-email-verified" class="font-bold"></dd>
                                        </div>
                                        <div class="flex justify-between items-center">
                                            <dt class="font-medium">KYC Status:</dt>
                                            <dd id="detail-kyc" class="font-bold"></dd>
                                        </div>
                                    </dl>
                                </div>

                                {{-- Section: Wallet & Rewards --}}
                                <div class="bg-green-50 p-4 rounded-xl">
                                    <h4 class="text-lg font-semibold text-green-800 mb-3">Wallet & Rewards</h4>
                                    <dl class="space-y-1 text-sm text-green-700">
                                        <div class="flex justify-between">
                                            <dt class="font-medium">Wallet Balance:</dt>
                                            <dd id="detail-balance" class="font-bold"></dd>
                                        </div>
                                        <div class="flex justify-between">
                                            <dt class="font-medium">Earned Rewards:</dt>
                                            <dd id="detail-rewards" class="font-bold"></dd>
                                        </div>
                                    </dl>
                                </div>

                                {{-- Section: Addresses --}}
                                <div class="bg-yellow-50 p-4 rounded-xl">
                                    <h4 class="text-lg font-semibold text-yellow-800 mb-3">Default Address</h4>
                                    <p id="detail-address" class="text-sm text-yellow-700"></p>
                                    <button class="mt-3 text-xs font-medium text-yellow-600 hover:underline">View All
                                        Addresses</button>
                                </div>
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
        /* Custom Styles for Professional Look */
        .table-container {
            /* Deeper, more noticeable shadow for the main card */
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.15), 0 0 0 1px rgba(0, 0, 0, 0.05);
        }

        .customer-table th,
        .customer-table td {
            /* Subtle padding adjustments for a cleaner look */
            padding-left: 1.5rem;
            padding-right: 1.5rem;
        }

        /* Table Row Hover Effect */
        .customer-table tbody tr {
            transition: all 0.2s ease-in-out;
        }

        /* Action Buttons Hover & Focus Effect */
        .action-btn,
        .view-btn {
            outline: none !important;
        }

        .action-btn:hover,
        .view-btn:hover {
            transform: translateY(-1px);
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        /* Sortable Header Icon Styling */
        .sortable {
            transition: color 0.15s ease-in-out;
        }

        .sortable:hover {
            color: #3182CE;
            /* Blue on hover */
        }
    </style>
@endpush


@push('scripts')
    <script>
        // JS for handling the details modal/drawer
        const modal = document.getElementById('customer-details-modal');

        function showCustomerDetails(customer) {
            // Update the content of the modal
            document.getElementById('detail-name').textContent = customer.name;
            document.getElementById('detail-email').textContent = customer.email;
            document.getElementById('detail-phone').textContent = customer.phone;

            // Verification status formatting
            const emailVerifiedEl = document.getElementById('detail-email-verified');
            emailVerifiedEl.textContent = customer.email_verified ? 'Verified' : 'Unverified';
            emailVerifiedEl.className = customer.email_verified ? 'text-green-600 font-bold' : 'text-red-500 font-bold';

            // Mock KYC status if missing (for demo purposes)
            customer.kyc = customer.status === 'verified' ? 'Verified' : (customer.status === 'pending' ? 'Pending' : 'Unverified');
            
            const kycEl = document.getElementById('detail-kyc');
            kycEl.textContent = customer.kyc;
            if (customer.kyc === 'Verified') {
                kycEl.className = 'text-green-600 font-bold';
            } else if (customer.kyc === 'Pending') {
                kycEl.className = 'text-yellow-600 font-bold';
            } else {
                kycEl.className = 'text-red-600 font-bold';
            }

            // Wallet/Rewards
            document.getElementById('detail-balance').textContent = `$${customer.wallet_balance.toFixed(2)}`;
            document.getElementById('detail-rewards').textContent = `${customer.rewards} pts`;

            // Address
            document.getElementById('detail-address').textContent = customer.default_address;


            // Show the modal/drawer
            modal.classList.remove('hidden');
        }

        function hideCustomerDetails() {
            modal.classList.add('hidden');
        }

        // --- START OF NEW DROPDOWN LOGIC ---

        function hideAllDropdowns() {
            document.querySelectorAll('.action-dropdown').forEach(dropdown => {
                dropdown.classList.add('hidden');
            });
        }

        function toggleDropdown(customerId) {
            const dropdown = document.getElementById(`dropdown-menu-${customerId}`);

            // Hide all other dropdowns first
            hideAllDropdowns();

            // Toggle the target dropdown
            if (dropdown) {
                dropdown.classList.toggle('hidden');
            }
        }

        function handleAction(action, customerId) {
            // In a real application, this would dispatch an API call 
            // (e.g., Axios.post('/api/customer/suspend/1001'))
            console.log(`${action} action triggered for Customer ID: ${customerId}`);
            // Hide the dropdown after clicking an action
            hideAllDropdowns();

            // Mock custom alert function since standard alert() is forbidden
            // In a real app, replace console.log with a toast notification.
            if (action === 'Suspend') {
                console.log(`[INFO] Customer #${customerId} has been marked as suspended (mock action).`);
            } else if (action === 'Delete') {
                console.log(`[WARNING] Customer #${customerId} has been marked for deletion (mock action).`);
                // Optional: Visually remove the row
                document.querySelector(`.row-${customerId}`)?.remove();
            }
        }

        // Global click listener to close dropdowns when clicking outside
        document.addEventListener('click', function(event) {
            const isClickInsideDropdown = event.target.closest('.relative.inline-block.text-left');
            
            // If the click is not inside any dropdown container, hide all
            if (!isClickInsideDropdown) {
                hideAllDropdowns();
            }
        }, true);
        
        // --- END OF NEW DROPDOWN LOGIC ---


        // Simple client-side sorting (Mockup)
        document.querySelectorAll('.sortable').forEach(header => {
            header.addEventListener('click', (e) => {
                // In a real application, this would trigger an API call to re-fetch/re-sort
                console.log(`Sorting by: ${header.dataset.sort}`);

                // Mock visual update
                document.querySelectorAll('.sortable .sort-icon').forEach(icon => icon.classList.add(
                    'hidden'));
                const icon = header.querySelector('.sort-icon');
                if (icon) {
                    icon.textContent = (icon.textContent === '↓' ? '↑' : '↓'); // Toggle icon
                    icon.classList.remove('hidden');
                }
            });
        });

        // Basic Search Mockup
        document.getElementById('customer-search').addEventListener('input', (e) => {
            const query = e.target.value.toLowerCase();
            const rows = document.querySelectorAll('.customer-table tbody tr');

            rows.forEach(row => {
                const name = row.querySelector('.text-sm.font-medium').textContent.toLowerCase();
                const email = row.querySelector('.text-sm.text-gray-900').textContent.toLowerCase();
                const id = row.querySelector('.text-xs.text-gray-500').textContent.toLowerCase();

                if (name.includes(query) || email.includes(query) || id.includes(query)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    </script>
@endpush