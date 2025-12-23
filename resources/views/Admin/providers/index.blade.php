@extends('layouts.app')

@section('content')
    <div class="space-y-6 pl-5">
        <h1 class="text-3xl font-bold text-gray-900 tracking-tight">
            Service Provider Management
        </h1>

        {{-- 1. Provider Analytics Summary (Top Widgets) --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-6 gap-5">
            @php
                $stats = [
                    ['title' => 'Total Providers', 'value' => '12,450', 'icon' => 'fas fa-users', 'color' => 'blue'],
                    ['title' => 'Active Providers', 'value' => '9,870', 'icon' => 'fas fa-user-check', 'color' => 'green'],
                    ['title' => 'Pending KYC', 'value' => '45', 'icon' => 'fas fa-hourglass-half', 'color' => 'yellow'],
                    ['title' => 'Suspended', 'value' => '12', 'icon' => 'fas fa-gavel', 'color' => 'red'],
                    ['title' => 'Online Now', 'value' => '3,100', 'icon' => 'fas fa-circle', 'color' => 'teal'],
                    ['title' => "Today's Earnings", 'value' => '$45,120', 'icon' => 'fas fa-dollar-sign', 'color' => 'purple'],
                ];
            @endphp
            @foreach ($stats as $stat)
                <div class="col-span-1">
                    <div
                        class="bg-white p-5 rounded-xl shadow-md border border-gray-100 hover:shadow-lg transition duration-200 ease-in-out transform hover:scale-[1.02]">
                        <div class="flex items-center justify-between">
                            <p class="text-sm font-medium text-gray-500">{{ $stat['title'] }}</p>
                            <i class="{{ $stat['icon'] }} text-2xl text-{{ $stat['color'] }}-500 opacity-70"></i>
                        </div>
                        <p class="text-xl font-bold text-gray-900 mt-1">{{ $stat['value'] }}</p>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- 2. Main Content Area --}}
        <div class="bg-white shadow-xl rounded-xl overflow-hidden">

            {{-- 3. Filters & Search (Sticky Bar) --}}
            <div id="sticky-filter-bar"
                class="p-5 border-b border-gray-100 bg-white sticky top-0 z-10 transition duration-300 ease-in-out">
                <div class="flex flex-wrap items-center justify-between gap-4">
                    <div class="flex-shrink w-full sm:w-auto">
                        <div class="relative">
                            <input type="text" id="searchInput" placeholder="Search by name, phone, or email..."
                                class="w-full sm:w-80 pl-10 pr-4 py-2.5 border border-gray-300 rounded-xl focus:ring-blue-500 focus:border-blue-500 text-sm transition duration-150" />
                            <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                        </div>
                    </div>

                    <div class="flex flex-wrap items-center gap-3">
                        <select id="categoryFilter"
                            class="p-2.5 border border-gray-300 rounded-xl text-sm text-gray-600 focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Category</option>
                            <option>Electrician</option>
                            <option>Plumber</option>
                            <option>AC Technician</option>
                        </select>
                        <select id="kycFilter"
                            class="p-2.5 border border-gray-300 rounded-xl text-sm text-gray-600 focus:ring-blue-500 focus:border-blue-500">
                            <option value="">KYC Status</option>
                            <option>Verified</option>
                            <option>Pending</option>
                            <option>Rejected</option>
                        </select>
                        <select id="availabilityFilter"
                            class="p-2.5 border border-gray-300 rounded-xl text-sm text-gray-600 focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Availability</option>
                            <option>Online</option>
                            <option>Offline</option>
                            <option>Busy</option>
                        </select>
                        <input type="date" id="dateFilter"
                            class="p-2.5 border border-gray-300 rounded-xl text-sm text-gray-600 focus:ring-blue-500 focus:border-blue-500"
                            placeholder="Date Registered" />
                        <button id="resetFilters"
                            class="flex items-center gap-1 px-4 py-2.5 bg-gray-50 text-gray-600 rounded-xl text-sm font-medium hover:bg-gray-100 transition duration-150 border border-gray-200">
                            <i class="fas fa-redo text-xs"></i>
                            Reset
                        </button>
                    </div>
                </div>
            </div>

            {{-- 4. Provider List Table --}}
            <div class="p-0"> {{-- Removed padding to make table flush --}}
                <div class="flex justify-between items-center p-5">
                    <h2 class="text-xl font-semibold text-gray-800">Current Providers</h2>
                    <button
                        class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg shadow-md transition duration-150">
                        <i class="fas fa-plus mr-1"></i> Add New Provider
                    </button>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th
                                    class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    Provider</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    Service/Pricing</th>
                                <th
                                    class="px-6 py-3 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    Status</th>
                                <th
                                    class="px-6 py-3 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    Performance</th>
                                <th
                                    class="px-6 py-3 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    Wallet/Violations</th>
                                <th
                                    class="px-6 py-3 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-100">

                            @for ($i = 1; $i <= 10; $i++)
                                <tr class="hover:bg-blue-50/50 transition duration-150 ease-in-out">

                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <img class="h-10 w-10 rounded-full object-cover shadow-sm ring-1 ring-gray-100"
                                                src="https://i.pravatar.cc/150?img={{ $i }}"
                                                alt="Profile Photo">
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900">John Doe #{{ $i }}
                                                </div>
                                                <div class="text-xs text-gray-500">ID: PRV-{{ 1000 + $i }}</div>
                                            </div>
                                        </div>
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span
                                            class="px-3 py-1 inline-flex text-xs leading-5 font-medium rounded-full bg-blue-100 text-blue-800">
                                            Plumber
                                        </span>
                                        <div class="text-xs text-gray-500 mt-1">
                                            Rate: <span class="font-semibold text-gray-700">$25/hr</span>
                                        </div>
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap text-center text-sm">
                                        <div class="mb-1">
                                            <span
                                                class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                Verified
                                            </span>
                                            <span title="KYC Status" class="text-xs text-gray-400">KYC</span>
                                        </div>
                                        <div>
                                            <span class="inline-flex items-center text-xs font-medium text-gray-700">
                                                <i class="fas fa-circle text-green-500 text-[8px] mr-1"></i> Online
                                            </span>
                                        </div>
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap text-center text-sm">
                                        <div class="text-yellow-500 flex items-center justify-center">
                                            <i class="fas fa-star text-xs mr-1"></i> 4.{{ 8 - ($i % 3) }}
                                        </div>
                                        <div class="text-xs text-gray-500 mt-1">
                                            <i class="fas fa-check-circle text-blue-500 text-xs"></i>
                                            **{{ 200 + $i * 10 }}** Orders
                                        </div>
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <div class="text-gray-900">
                                            **${{ 1000 + $i * 50 }}.00** <span
                                                class="text-xs text-gray-500">(Bal)</span>
                                        </div>
                                        <div class="text-red-500 mt-1">
                                            <i class="fas fa-exclamation-triangle text-xs"></i> **{{ $i % 3 }}**
                                            Violations
                                        </div>
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <div class="flex justify-end items-center space-x-2">
                                            <button onclick="openProviderDetails('{{ $i }}')"
                                                class="px-3 py-1 text-blue-600 bg-blue-50 rounded-md hover:bg-blue-100 transition duration-150 text-xs font-semibold"
                                                title="View Full Details">
                                                View
                                            </button>

                                            <div class="relative inline-block text-left" x-data="{ open: false }">
                                                <button @click="open = !open"
                                                    class="action-dropdown-btn inline-flex justify-center rounded-full text-gray-400 hover:text-gray-600 p-1 focus:outline-none transition duration-150"
                                                    title="More Actions">
                                                    <i class="fas fa-ellipsis-v text-sm"></i>
                                                </button>

                                                <div class="action-dropdown-menu hidden origin-top-right absolute right-0 mt-2 w-56 rounded-lg shadow-2xl bg-white ring-1 ring-black ring-opacity-5 divide-y divide-gray-100 z-20"
                                                    role="menu">
                                                    <div class="py-1">
                                                        <a href="#"
                                                            class="flex items-center px-4 py-2 text-sm text-green-700 hover:bg-green-50"><i
                                                                class="fas fa-check-circle mr-3 w-4"></i> Approve KYC</a>
                                                        <a href="#"
                                                            class="flex items-center px-4 py-2 text-sm text-red-700 hover:bg-red-50"><i
                                                                class="fas fa-times-circle mr-3 w-4"></i> Reject KYC</a>
                                                    </div>
                                                    <div class="py-1">
                                                        <a href="#"
                                                            class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-50"><i
                                                                class="fas fa-gavel mr-3 w-4"></i> Suspend/Ban</a>
                                                        <a href="#"
                                                            class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-50"><i
                                                                class="fas fa-key mr-3 w-4"></i> Reset Password</a>
                                                        <a href="#"
                                                            class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-50"><i
                                                                class="fas fa-clipboard-list mr-3 w-4"></i> Assign Orders</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endfor
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- 5. Pagination --}}
            <div class="p-5 border-t border-gray-100 flex justify-between items-center text-sm text-gray-600">
                <div class="text-xs text-gray-500">
                    Showing <span class="font-medium">1</span> to <span class="font-medium">10</span> of <span
                        class="font-medium">4,520</span> results
                </div>
                <nav class="flex items-center space-x-1">
                    <a href="#"
                        class="px-3 py-1 border border-gray-300 rounded-lg text-gray-600 hover:bg-blue-50 hover:border-blue-500 transition duration-150">&laquo;
                        Previous</a>
                    <span class="px-3 py-1 bg-blue-600 text-white rounded-lg font-semibold shadow-md">1</span>
                    <a href="#"
                        class="px-3 py-1 border border-gray-300 rounded-lg text-gray-600 hover:bg-blue-50 hover:border-blue-500">2</a>
                    <a href="#"
                        class="px-3 py-1 border border-gray-300 rounded-lg text-gray-600 hover:bg-blue-50 hover:border-blue-500">3</a>
                    <a href="#"
                        class="px-3 py-1 border border-gray-300 rounded-lg text-gray-600 hover:bg-blue-50 hover:border-blue-500">Next
                        &raquo;</a>
                </nav>
            </div>

        </div>

    </div>

    {{-- 6. Side Panel for Provider Full Details --}}
    <div id="slide-over-overlay"
        class="fixed inset-0 bg-gray-900 bg-opacity-70 z-40 hidden transition-opacity duration-300 ease-in-out"></div>
    <div id="details-slide-over"
        class="slide-over-panel fixed top-0 right-0 h-full w-full sm:w-4/5 lg:w-3/5 xl:w-2/5 bg-white shadow-2xl z-50 overflow-y-auto font-sans">
        <div class="flex flex-col h-full">
            <div class="sticky top-0 bg-white p-6 border-b border-gray-200 flex justify-between items-center shadow-sm z-10">
                <h3 id="slide-over-title" class="text-xl font-bold text-gray-900 truncate">Provider Details</h3>
                <button id="slide-over-close"
                    class="text-gray-400 hover:text-gray-600 p-2 rounded-full hover:bg-gray-50 transition duration-150">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>

            <div id="slide-over-content" class="p-0 flex-grow bg-gray-50">
                <div class="text-center py-10 text-gray-500">
                    Click a "View" button to load provider details.
                </div>
            </div>

            <div class="sticky bottom-0 bg-white p-4 border-t border-gray-200 flex justify-end space-x-3 z-10">
                <button
                    class="px-4 py-2 bg-red-600 text-white rounded-lg shadow-md hover:bg-red-700 transition duration-150">
                    <i class="fas fa-ban mr-1"></i> Block
                </button>
                <button
                    class="px-4 py-2 border border-blue-500 text-blue-600 rounded-lg shadow-sm hover:bg-blue-50 transition duration-150">
                    <i class="fas fa-history mr-1"></i> History
                </button>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <style>
        .shadow-xl {
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.05), 0 10px 10px -5px rgba(0, 0, 0, 0.02);
        }

        .slide-over-panel {
            transform: translateX(100%);
            transition: transform 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .slide-over-panel.open {
            transform: translateX(0);
        }

        #sticky-filter-bar {
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.04);
        }

        /* Custom scrollbar for slide-over */
        #details-slide-over::-webkit-scrollbar {
            width: 8px;
        }

        #details-slide-over::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        #details-slide-over::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 4px;
        }

        #details-slide-over::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }
    </style>
@endpush

@push('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", function() {

            const rows = document.querySelectorAll("tbody tr");

            function applyFilters() {

                const search = document.getElementById("searchInput").value.toLowerCase().trim();
                const category = document.getElementById("categoryFilter").value.toLowerCase().trim();
                const kyc = document.getElementById("kycFilter").value.toLowerCase().trim();
                const availability = document.getElementById("availabilityFilter").value.toLowerCase().trim();
                const dateFilter = document.getElementById("dateFilter").value;

                rows.forEach(row => {

                    const text = row.innerText.toLowerCase();

                    // Extract values from row
                    const rowCategory = row.querySelector("td:nth-child(2) .font-medium")?.innerText
                        .toLowerCase().trim() || "";
                    const rowAvailability = row.querySelector(".fa-circle")?.parentNode.innerText
                        .toLowerCase().trim() || "";
                    const rowKyc = row.querySelector(".bg-green-100")?.innerText.toLowerCase().trim() || "";

                    const rowDate = row.getAttribute("data-joined") || "";

                    let show = true;

                    if (search && !text.includes(search)) show = false;
                    if (category && !rowCategory.includes(category)) show = false;
                    if (kyc && !rowKyc.includes(kyc)) show = false;
                    if (availability && !rowAvailability.includes(availability)) show = false;
                    if (dateFilter && rowDate !== dateFilter) show = false;

                    row.style.display = show ? "" : "none";
                });
            }

            document.querySelectorAll("#searchInput, #categoryFilter, #kycFilter, #availabilityFilter, #dateFilter")
                .forEach(el => {
                    el.addEventListener("input", applyFilters);
                    el.addEventListener("change", applyFilters);
                });

            document.getElementById("resetFilters").addEventListener("click", function() {
                document.getElementById("searchInput").value = "";
                document.getElementById("categoryFilter").value = "";
                document.getElementById("kycFilter").value = "";
                document.getElementById("availabilityFilter").value = "";
                document.getElementById("dateFilter").value = "";
                applyFilters();
            });

            applyFilters();
        });

        let currentProviderData = {};

        // --- Slide-Over Panel Logic ---
        const slideOver = document.getElementById('details-slide-over');
        const slideOverOverlay = document.getElementById('slide-over-overlay');
        const slideOverContent = document.getElementById('slide-over-content');
        const slideOverTitle = document.getElementById('slide-over-title');

        window.openProviderDetails = function(providerId) {
            slideOverTitle.textContent = 'Loading Details...';
            slideOverContent.innerHTML =
                '<div class="flex flex-col items-center justify-center h-64 text-gray-500"><i class="fas fa-circle-notch fa-spin text-3xl text-blue-500 mb-3"></i><p>Fetching Provider Profile...</p></div>';

            slideOver.classList.add('open');
            slideOverOverlay.classList.remove('hidden');
            document.body.classList.add('overflow-hidden');

            // Simulate API call
            setTimeout(() => {
                const dummyData = getProviderData(providerId);
                currentProviderData = dummyData;
                slideOverTitle.textContent = dummyData.name; // Set Title to Name
                slideOverContent.innerHTML = generateSlideOverContent(dummyData);
            }, 600);
        }

        window.closeProviderDetails = function() {
            slideOver.classList.remove('open');
            slideOverOverlay.classList.add('hidden');
            document.body.classList.remove('overflow-hidden');
            setTimeout(() => {
                slideOverTitle.textContent = '';
                slideOverContent.innerHTML = '';
            }, 300);
        }

        document.getElementById('slide-over-close').addEventListener('click', window.closeProviderDetails);
        slideOverOverlay.addEventListener('click', window.closeProviderDetails);

        document.addEventListener('click', (e) => {
            const isButton = e.target.closest('.action-dropdown-btn');
            document.querySelectorAll('.action-dropdown-menu').forEach(menu => {
                if (!isButton || menu.parentNode !== isButton.closest('.relative')) {
                    menu.classList.add('hidden');
                }
            });
            if (isButton) {
                const dropdown = isButton.closest('.relative').querySelector('.action-dropdown-menu');
                dropdown.classList.toggle('hidden');
                e.stopPropagation();
            }
        });

        // --- EXTENDED Dummy Data ---
        function getProviderData(id) {
            return {
                id: id,
                name: 'John Doe ' + id,
                image: 'https://i.pravatar.cc/150?img=' + id,
                email: 'john.doe' + id + '@fixnserve.com',
                phone: '+1 (555) 123-456' + id,
                
                // Main Categories
                mainCategory: 'Home Maintenance',
                subCategories: ['Plumbing', 'Pipe Fitting', 'Sanitary Installation', 'Leak Detection'],
                
                // Stats
                earnings: '45,800.00',
                totalJobs: '342',
                totalHours: '1,240',
                pricePerHour: '25.00',
                rating: '4.8',
                
                // Description / Bio
                description: 'Certified master plumber with over 10 years of experience in residential and commercial plumbing systems. Specializing in emergency repairs, high-efficiency fixture installation, and complex pipe fitting. I ensure clean, reliable, and code-compliant work.',
                skills: ['Pipe Fitting', 'Drain Cleaning', 'Water Heater Repair', 'Blueprint Reading', 'Soldering'],
                
                // Detailed Address
                address: {
                    current: 'Apt 4B, Blue Ridge Complex',
                    permanent: '452 Pine Street, West Wing',
                    city: 'New York',
                    state: 'NY',
                    country: 'USA',
                    zip: '10012'
                },

                // Portfolio
                portfolio: [
                    {
                        name: 'Downtown Office Renovation',
                        desc: 'Complete bathroom overhaul for a 5-story office building.',
                        role: 'Lead Plumber',
                        skills: 'Industrial Plumbing, Pipe Layout',
                        deliverable: 'Installed 20 units within 2 weeks.',
                        image: 'https://images.unsplash.com/photo-1584622650111-993a426fbf0a?auto=format&fit=crop&q=80&w=200'
                    },
                    {
                        name: 'Luxury Villa Kitchen',
                        desc: 'High-end fixture installation for a private residence.',
                        role: 'Contractor',
                        skills: 'Precision Fitting, Luxury Fixtures',
                        deliverable: 'Leak-free high pressure system.',
                        image: 'https://images.unsplash.com/photo-1556911220-e15b29be8c8f?auto=format&fit=crop&q=80&w=200'
                    }
                ],

                // Work History
                workHistory: [
                    { company: 'FixNServe Inc.', role: 'Senior Provider', duration: '2020 - Present' },
                    { company: 'City Plumbers Ltd.', role: 'Junior Plumber', duration: '2015 - 2020' }
                ],

                // Languages
                languages: [
                    { name: 'English', proficiency: 'Native' },
                    { name: 'Spanish', proficiency: 'Conversational' }
                ],

                // Education
                education: [
                    { degree: 'Certified Plumbing Technician', school: 'NY Technical Institute', year: '2014' },
                    { degree: 'High School Diploma', school: 'Lincoln High', year: '2012' }
                ],

                // Logistics
                paymentMethods: ['Bank Transfer', 'PayPal', 'Cash'],
                transportation: 'Own Van (Ford Transit)',

                // Bookings Pipeline
                bookings: [
                    { id: 'ORD-9921', type: 'Pipe Leakage Repair', date: '2023-10-25', status: 'Pending', rate: '$50.00' },
                    { id: 'ORD-9922', type: 'Faucet Installation', date: '2023-10-26', status: 'Confirmed', rate: '$35.00' },
                    { id: 'ORD-9923', type: 'Water Heater Check', date: '2023-10-28', status: 'In Progress', rate: '$80.00' }
                ]
            };
        }

        // --- EXTENDED HTML Generator ---
        function generateSlideOverContent(data) {
            return `
                <div class="space-y-2">
                    
                    <div class="bg-white p-6 shadow-sm border-b border-gray-100">
                        <div class="flex items-start justify-between">
                            <div class="flex gap-4">
                                <img src="${data.image}" class="w-20 h-20 rounded-full border-4 border-white shadow-lg object-cover">
                                <div>
                                    <h2 class="text-xl font-bold text-gray-900">${data.name}</h2>
                                    <p class="text-blue-600 font-medium">${data.mainCategory}</p>
                                    <div class="flex flex-wrap gap-1 mt-2">
                                        ${data.subCategories.map(sub => `<span class="px-2 py-0.5 bg-gray-100 text-gray-600 text-xs rounded-md border border-gray-200">${sub}</span>`).join('')}
                                    </div>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="text-xs text-gray-500 uppercase tracking-wide">Hourly Rate</p>
                                <p class="text-2xl font-bold text-gray-900">$${data.pricePerHour}</p>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-3 gap-px bg-gray-200 border-b border-gray-200">
                        <div class="bg-white p-4 text-center">
                            <p class="text-xs text-gray-500 uppercase">Total Earnings</p>
                            <p class="text-lg font-bold text-green-600">$${data.earnings}</p>
                        </div>
                        <div class="bg-white p-4 text-center">
                            <p class="text-xs text-gray-500 uppercase">Total Jobs</p>
                            <p class="text-lg font-bold text-blue-600">${data.totalJobs}</p>
                        </div>
                        <div class="bg-white p-4 text-center">
                            <p class="text-xs text-gray-500 uppercase">Total Hours</p>
                            <p class="text-lg font-bold text-purple-600">${data.totalHours}</p>
                        </div>
                    </div>

                    <div class="p-6 space-y-8 bg-white min-h-screen">
                        
                        <section>
                            <h4 class="text-sm font-bold text-gray-900 uppercase tracking-wider mb-3 border-b pb-2">About & Skills</h4>
                            <p class="text-gray-600 text-sm leading-relaxed mb-4">${data.description}</p>
                            <div class="flex flex-wrap gap-2">
                                ${data.skills.map(skill => `<span class="px-3 py-1 bg-indigo-50 text-indigo-700 text-xs font-semibold rounded-full border border-indigo-100">${skill}</span>`).join('')}
                            </div>
                        </section>

                        <section>
                            <h4 class="text-sm font-bold text-gray-900 uppercase tracking-wider mb-3 border-b pb-2">Contact & Location</h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                                <div class="p-3 bg-gray-50 rounded-lg border border-gray-100">
                                    <p class="text-xs text-gray-400 uppercase mb-1">Current Address</p>
                                    <p class="font-medium text-gray-800">${data.address.current}</p>
                                    <p class="text-gray-600">${data.address.city}, ${data.address.state} ${data.address.zip}</p>
                                </div>
                                <div class="p-3 bg-gray-50 rounded-lg border border-gray-100">
                                    <p class="text-xs text-gray-400 uppercase mb-1">Permanent Address</p>
                                    <p class="font-medium text-gray-800">${data.address.permanent}</p>
                                    <p class="text-gray-600">${data.address.country}</p>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-400 uppercase">Email</p>
                                    <p class="font-medium text-gray-800">${data.email}</p>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-400 uppercase">Phone</p>
                                    <p class="font-medium text-gray-800">${data.phone}</p>
                                </div>
                            </div>
                        </section>

                        <section>
                            <h4 class="text-sm font-bold text-gray-900 uppercase tracking-wider mb-3 border-b pb-2 flex justify-between items-center">
                                <span>Upcoming Pipeline</span>
                                <span class="text-xs bg-blue-100 text-blue-700 px-2 py-0.5 rounded-full">${data.bookings.length} New</span>
                            </h4>
                            <div class="overflow-hidden border border-gray-200 rounded-lg">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase">Order ID</th>
                                            <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase">Job</th>
                                            <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200 text-sm">
                                        ${data.bookings.map(book => `
                                            <tr>
                                                <td class="px-3 py-2 text-gray-900 font-medium">${book.id} <div class="text-xs text-gray-400">${book.date}</div></td>
                                                <td class="px-3 py-2 text-gray-600">${book.type} <div class="text-xs text-gray-500">Rate: ${book.rate}</div></td>
                                                <td class="px-3 py-2">
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full ${book.status === 'Confirmed' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800'}">
                                                        ${book.status}
                                                    </span>
                                                </td>
                                            </tr>
                                        `).join('')}
                                    </tbody>
                                </table>
                            </div>
                        </section>

                        <section>
                            <h4 class="text-sm font-bold text-gray-900 uppercase tracking-wider mb-3 border-b pb-2">Portfolio Projects</h4>
                            <div class="space-y-4">
                                ${data.portfolio.map(proj => `
                                    <div class="flex gap-4 p-3 border border-gray-100 rounded-lg hover:shadow-md transition bg-white">
                                        <div class="flex-shrink-0">
                                            <img src="${proj.image}" class="w-20 h-20 rounded-md object-cover bg-gray-100">
                                        </div>
                                        <div class="flex-grow">
                                            <h5 class="font-bold text-gray-800 text-sm">${proj.name}</h5>
                                            <p class="text-xs text-gray-500 mb-1">${proj.role} • ${proj.deliverable}</p>
                                            <p class="text-xs text-gray-600 line-clamp-2">${proj.desc}</p>
                                            <p class="text-xs text-blue-500 mt-1 italic">${proj.skills}</p>
                                        </div>
                                    </div>
                                `).join('')}
                            </div>
                        </section>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <section>
                                <h4 class="text-sm font-bold text-gray-900 uppercase tracking-wider mb-3 border-b pb-2">Work History</h4>
                                <ul class="space-y-3 relative border-l border-gray-200 ml-2">
                                    ${data.workHistory.map(work => `
                                        <li class="ml-4">
                                            <div class="absolute w-3 h-3 bg-gray-200 rounded-full -left-1.5 border border-white"></div>
                                            <p class="text-sm font-bold text-gray-800">${work.company}</p>
                                            <p class="text-xs text-gray-600">${work.role}</p>
                                            <p class="text-xs text-gray-400">${work.duration}</p>
                                        </li>
                                    `).join('')}
                                </ul>
                            </section>

                            <section>
                                <h4 class="text-sm font-bold text-gray-900 uppercase tracking-wider mb-3 border-b pb-2">Education</h4>
                                <ul class="space-y-2">
                                    ${data.education.map(edu => `
                                        <li class="bg-gray-50 p-2 rounded border border-gray-100">
                                            <p class="text-sm font-bold text-gray-800">${edu.degree}</p>
                                            <p class="text-xs text-gray-600">${edu.school}, ${edu.year}</p>
                                        </li>
                                    `).join('')}
                                </ul>
                            </section>
                        </div>

                        <section class="bg-gray-50 p-4 rounded-xl border border-gray-100">
                            <h4 class="text-sm font-bold text-gray-900 uppercase tracking-wider mb-3 border-b pb-2">Logistics</h4>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <p class="text-xs text-gray-400 uppercase mb-1">Languages</p>
                                    <div class="space-y-1">
                                        ${data.languages.map(lang => `<div class="text-sm text-gray-700 flex justify-between"><span>${lang.name}</span> <span class="text-xs text-gray-400">${lang.proficiency}</span></div>`).join('')}
                                    </div>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-400 uppercase mb-1">Transport</p>
                                    <p class="text-sm text-gray-800 font-medium"><i class="fas fa-car mr-1 text-gray-400"></i> ${data.transportation}</p>
                                    
                                    <p class="text-xs text-gray-400 uppercase mt-2 mb-1">Payments</p>
                                    <div class="flex gap-2">
                                        ${data.paymentMethods.map(pay => `<span class="text-xs bg-white border border-gray-200 px-1.5 rounded text-gray-600">${pay}</span>`).join('')}
                                    </div>
                                </div>
                            </div>
                        </section>

                    </div>
                </div>
            `;
        }
    </script>
@endpush