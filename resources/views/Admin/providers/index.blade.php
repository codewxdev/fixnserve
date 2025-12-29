@extends('layouts.app')

@section('content')
<div class="space-y-6 pl-5">
    <h1 class="text-3xl font-bold text-gray-900 tracking-tight">
        Service Provider Management
    </h1>

    {{-- ========================================== --}}
    {{-- 1. ANALYTICS WIDGETS (Previously Component) --}}
    {{-- ========================================== --}}
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
            <div class="bg-white p-5 rounded-xl shadow-md border border-gray-100 hover:shadow-lg transition duration-200 ease-in-out transform hover:scale-[1.02]">
                <div class="flex items-center justify-between">
                    <p class="text-sm font-medium text-gray-500">{{ $stat['title'] }}</p>
                    <i class="{{ $stat['icon'] }} text-2xl text-{{ $stat['color'] }}-500 opacity-70"></i>
                </div>
                <p class="text-xl font-bold text-gray-900 mt-1">{{ $stat['value'] }}</p>
            </div>
        </div>
        @endforeach
    </div>

    {{-- ========================================== --}}
    {{-- 2. MAIN CONTENT AREA --}}
    {{-- ========================================== --}}
    <div class="bg-white shadow-xl rounded-xl overflow-hidden">

        {{-- FILTER BAR (Sticky) --}}
        <div id="sticky-filter-bar" class="p-5 border-b border-gray-100 bg-white sticky top-0 z-10 transition duration-300 ease-in-out">
            <div class="flex flex-wrap items-center justify-between gap-4">
                <div class="flex-shrink w-full sm:w-auto">
                    <div class="relative">
                        <input type="text" id="searchInput" placeholder="Search by name, phone, or email..." class="w-full sm:w-80 pl-10 pr-4 py-2.5 border border-gray-300 rounded-xl focus:ring-blue-500 focus:border-blue-500 text-sm transition duration-150" />
                        <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                    </div>
                </div>

                <div class="flex flex-wrap items-center gap-3">
                    <select id="categoryFilter" class="p-2.5 border border-gray-300 rounded-xl text-sm text-gray-600 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Category</option>
                        <option>Electrician</option>
                        <option>Plumber</option>
                        <option>AC Technician</option>
                    </select>
                    <select id="kycFilter" class="p-2.5 border border-gray-300 rounded-xl text-sm text-gray-600 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">KYC Status</option>
                        <option>Verified</option>
                        <option>Pending</option>
                        <option>Rejected</option>
                    </select>
                    <select id="availabilityFilter" class="p-2.5 border border-gray-300 rounded-xl text-sm text-gray-600 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Availability</option>
                        <option>Online</option>
                        <option>Offline</option>
                        <option>Busy</option>
                    </select>
                    <input type="date" id="dateFilter" class="p-2.5 border border-gray-300 rounded-xl text-sm text-gray-600 focus:ring-blue-500 focus:border-blue-500" />
                    <button id="resetFilters" class="flex items-center gap-1 px-4 py-2.5 bg-gray-50 text-gray-600 rounded-xl text-sm font-medium hover:bg-gray-100 transition duration-150 border border-gray-200">
                        <i class="fas fa-redo text-xs"></i> Reset
                    </button>
                </div>
            </div>
        </div>

        {{-- TABLE HEADER & ADD BUTTON --}}
        <div class="p-5">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-semibold text-gray-800">Current Providers</h2>
                <button class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg shadow-md transition duration-150">
                    <i class="fas fa-plus mr-1"></i> Add New Provider
                </button>
            </div>

            {{-- PROVIDER TABLE --}}
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Provider</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Service/Pricing</th>
                            <th class="px-6 py-3 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">Performance</th>
                            <th class="px-6 py-3 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider">Wallet/Violations</th>
                            <th class="px-6 py-3 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-100">
                        {{-- MOCK LOOP FOR DEMO --}}
                        @for ($i = 1; $i <= 10; $i++)
                            <tr class="hover:bg-blue-50/50 transition duration-150 ease-in-out">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <img class="h-10 w-10 rounded-full object-cover shadow-sm ring-1 ring-gray-100" src="https://i.pravatar.cc/150?img={{ $i }}" alt="Profile Photo">
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900">John Doe #{{ $i }}</div>
                                        <div class="text-xs text-gray-500">ID: PRV-{{ 1000 + $i }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-medium rounded-full bg-blue-100 text-blue-800">
                                    Plumber
                                </span>
                                <div class="text-xs text-gray-500 mt-1">
                                    <i class="fas fa-tag text-gray-400 mr-1"></i> $25/hr
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm">
                                <div class="mb-1">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                        Verified
                                    </span>
                                </div>
                                <div>
                                    <span class="inline-flex items-center text-xs font-medium text-gray-700">
                                        <i class="fas fa-circle text-green-500 text-[8px] mr-1"></i> Online
                                    </span>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm">
                                <div class="text-yellow-500 flex items-center justify-center">
                                    <i class="fas fa-star text-xs mr-1"></i> 4.8
                                </div>
                                <div class="text-xs text-gray-500 mt-1">
                                    **{{ 200 + $i * 10 }}** Jobs Done
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <div class="text-gray-900">
                                    **${{ 1000 + $i * 50 }}.00**
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <div class="flex justify-end items-center space-x-2">
                                    <button onclick="openProviderDetails('{{ $i }}')" class="px-3 py-1 text-blue-600 bg-blue-50 rounded-md hover:bg-blue-100 transition duration-150 text-xs font-semibold" title="View Full Details">
                                        View Details
                                    </button>
                                    <div class="relative inline-block text-left" x-data="{ open: false }">
                                        <button @click="open = !open" class="action-dropdown-btn inline-flex justify-center rounded-full text-gray-400 hover:text-gray-600 p-1 focus:outline-none transition duration-150">
                                            <i class="fas fa-ellipsis-v text-sm"></i>
                                        </button>
                                        <div class="action-dropdown-menu hidden origin-top-right absolute right-0 mt-2 w-56 rounded-lg shadow-2xl bg-white ring-1 ring-black ring-opacity-5 divide-y divide-gray-100 z-20" role="menu">
                                            <div class="py-1">
                                                <a href="#" class="flex items-center px-4 py-2 text-sm text-green-700 hover:bg-green-50"><i class="fas fa-check-circle mr-3 w-4"></i> Approve KYC</a>
                                                <a href="#" class="flex items-center px-4 py-2 text-sm text-red-700 hover:bg-red-50"><i class="fas fa-times-circle mr-3 w-4"></i> Reject KYC</a>
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

        {{-- PAGINATION --}}
        <div class="p-5 border-t border-gray-100 flex justify-between items-center text-sm text-gray-600">
            <div class="text-xs text-gray-500">
                Showing <span class="font-medium">1</span> to <span class="font-medium">10</span> of <span class="font-medium">450</span> results
            </div>
            <nav class="flex items-center space-x-1">
                <button class="px-3 py-1 border border-gray-300 rounded-lg text-gray-600 hover:bg-blue-50">&laquo;</button>
                <span class="px-3 py-1 bg-blue-600 text-white rounded-lg font-semibold shadow-md">1</span>
                <button class="px-3 py-1 border border-gray-300 rounded-lg text-gray-600 hover:bg-blue-50">2</button>
                <button class="px-3 py-1 border border-gray-300 rounded-lg text-gray-600 hover:bg-blue-50">&raquo;</button>
            </nav>
        </div>
    </div>
</div>

{{-- ========================================== --}}
{{-- 3. SIDE PANEL (SLIDE OVER) CONTAINER --}}
{{-- ========================================== --}}
<div id="slide-over-overlay" class="fixed inset-0 bg-gray-900 bg-opacity-70 z-40 hidden transition-opacity duration-300 ease-in-out"></div>
<div id="details-slide-over" class="slide-over-panel fixed top-0 right-0 h-full w-full sm:w-4/5 lg:w-3/5 xl:w-2/5 bg-white shadow-2xl z-50 overflow-y-auto">
    <div class="flex flex-col h-full">
        <div class="sticky top-0 bg-white p-6 border-b border-gray-200 flex justify-between items-center shadow-sm z-10">
            <h3 id="slide-over-title" class="text-xl font-bold text-gray-900 truncate">Provider Details</h3>
            <button id="slide-over-close" class="text-gray-400 hover:text-gray-600 p-2 rounded-full hover:bg-gray-50 transition duration-150">
                <i class="fas fa-times text-xl"></i>
            </button>
        </div>

        <div id="slide-over-content" class="p-6 flex-grow space-y-6">
            {{-- Content Injected via JS --}}
        </div>

        <div class="sticky bottom-0 bg-gray-50 p-4 border-t border-gray-200 flex justify-end space-x-3">
            <button class="px-4 py-2 bg-red-600 text-white rounded-lg shadow-md hover:bg-red-700 transition duration-150">
                <i class="fas fa-ban mr-1"></i> Block Provider
            </button>
            <button class="px-4 py-2 border border-blue-500 text-blue-600 rounded-lg shadow-sm hover:bg-blue-50 transition duration-150">
                <i class="fas fa-comments mr-1"></i> Message
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
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function() {
        // --- 1. Filter Logic ---
        const rows = document.querySelectorAll("tbody tr");

        function applyFilters() {
            const search = document.getElementById("searchInput").value.toLowerCase().trim();
            const category = document.getElementById("categoryFilter").value.toLowerCase().trim();
            const kyc = document.getElementById("kycFilter").value.toLowerCase().trim();
            const availability = document.getElementById("availabilityFilter").value.toLowerCase().trim();

            rows.forEach(row => {
                const text = row.innerText.toLowerCase();
                const rowCategory = row.querySelector("td:nth-child(2) span")?.innerText.toLowerCase().trim() || "";
                let show = true;
                if (search && !text.includes(search)) show = false;
                if (category && rowCategory !== category) show = false;
                row.style.display = show ? "" : "none";
            });
        }

        document.querySelectorAll("#searchInput, #categoryFilter, #kycFilter, #availabilityFilter, #dateFilter").forEach(el => {
            el.addEventListener("input", applyFilters);
            el.addEventListener("change", applyFilters);
        });
        document.getElementById("resetFilters").addEventListener("click", function() {
            document.getElementById("searchInput").value = "";
            document.getElementById("categoryFilter").value = "";
            applyFilters();
        });

        // --- 2. Action Menu Dropdown ---
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
    });

    // --- 3. Slide-Over Logic & Data Injection ---
    const slideOver = document.getElementById('details-slide-over');
    const slideOverOverlay = document.getElementById('slide-over-overlay');
    const slideOverContent = document.getElementById('slide-over-content');
    const slideOverTitle = document.getElementById('slide-over-title');

    window.openProviderDetails = function(providerId) {
        slideOverTitle.textContent = 'Loading...';
        slideOverContent.innerHTML = '<div class="text-center py-10 text-gray-500"><i class="fas fa-sync-alt fa-spin mr-2"></i> Fetching Profile...</div>';

        slideOver.classList.add('open');
        slideOverOverlay.classList.remove('hidden');
        document.body.classList.add('overflow-hidden');

        setTimeout(() => {
            const dummyData = getProviderData(providerId);
            slideOverTitle.textContent = dummyData.name;
            slideOverContent.innerHTML = generateSlideOverContent(dummyData);
        }, 300);
    }

    window.closeProviderDetails = function() {
        slideOver.classList.remove('open');
        slideOverOverlay.classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
    }

    document.getElementById('slide-over-close').addEventListener('click', window.closeProviderDetails);
    slideOverOverlay.addEventListener('click', window.closeProviderDetails);

    /**
     * MOCK DATA GENERATOR
     * Includes all requested fields: Portfolio, Work History, Bookings, Addresses, etc.
     */
    function getProviderData(id) {
        return {
            id: id,
            name: 'Jane Doe ' + id,
            image: `https://i.pravatar.cc/150?img=${id}`,
            main_category: 'Home Improvements',
            sub_categories: ['Plumbing', 'Pipe Fitting', 'Water Heater Repair'],
            hourly_rate: '$25.00',
            total_earnings: '$45,800',
            total_jobs: 215,
            total_hours: 1450,
            description: 'Expert plumber with over 10 years of experience in residential and commercial pipe fitting. Dedicated to high-quality workmanship and timely delivery.',
            skills: ['Leak Detection', 'Pipe Installation', 'Heater Repair', 'Drain Cleaning', 'Soldering'],

            address: {
                current: 'House 123, Street 4, Sector G-10',
                permanent: 'Village XYZ, District ABC',
                city: 'Islamabad',
                state: 'Federal Capital',
                country: 'Pakistan',
                zip: '44000'
            },

            languages: ['English (Fluent)', 'Urdu (Native)', 'Punjabi (Conversational)'],
            education: [{
                    degree: 'Diploma in Civil Engineering',
                    institute: 'Polytechnic Institute',
                    year: '2015'
                },
                {
                    degree: 'Certified Plumber',
                    institute: 'Vocational Training Center',
                    year: '2016'
                }
            ],

            payment_methods: ['Bank Transfer', 'JazzCash', 'EasyPaisa', 'Cash'],
            transportation: 'Own Motorcycle (Honda 125)',

            work_history: [{
                    company: 'FixIt Co.',
                    role: 'Senior Plumber',
                    dates: '2018 - Present'
                },
                {
                    company: 'BuildRight Construction',
                    role: 'Apprentice',
                    dates: '2016 - 2018'
                }
            ],

            portfolio: [{
                    name: 'Luxury Bath Renovation',
                    role: 'Lead Plumber',
                    desc: 'Complete overhaul of piping and fixture installation.',
                    skill: 'Fitting',
                    image: 'https://placehold.co/300x200?text=Bath+Reno'
                },
                {
                    name: 'Commercial Building Logic',
                    role: 'Contractor',
                    desc: 'Installed main water lines for a 5-story building.',
                    skill: 'Infrastructure',
                    image: 'https://placehold.co/300x200?text=Commercial'
                }
            ],

            bookings: [{
                    title: 'Kitchen Pipe Leak',
                    date: '2023-12-20',
                    status: 'Pending',
                    order_id: '#ORD-998',
                    rate: '$50'
                },
                {
                    title: 'Water Tank Cleaning',
                    date: '2023-12-18',
                    status: 'Completed',
                    order_id: '#ORD-887',
                    rate: '$30'
                },
                {
                    title: 'Heater Installation',
                    date: '2023-12-15',
                    status: 'Cancelled',
                    order_id: '#ORD-776',
                    rate: '$25'
                }
            ]
        };
    }

    /**
     * CONTENT GENERATOR
     * Renders the HTML based on the data object above.
     */
    function generateSlideOverContent(data) {
        return `
                <div class="space-y-8">
                    <div class="flex items-start space-x-4">
                        <img src="${data.image}" class="w-20 h-20 rounded-full border-4 border-white shadow-lg object-cover">
                        <div class="flex-1">
                            <h2 class="text-2xl font-bold text-gray-900">${data.name}</h2>
                            <p class="text-blue-600 font-medium">${data.main_category}</p>
                            <div class="flex flex-wrap gap-1 mt-1">
                                ${data.sub_categories.map(cat => `<span class="px-2 py-0.5 bg-gray-100 text-gray-600 text-xs rounded-md">${cat}</span>`).join('')}
                            </div>
                        </div>
                        <div class="text-right">
                            <div class="text-2xl font-bold text-gray-900">${data.hourly_rate}<span class="text-sm font-normal text-gray-500">/hr</span></div>
                        </div>
                    </div>

                    <div class="grid grid-cols-3 gap-4 border-t border-b border-gray-100 py-4">
                        <div class="text-center">
                            <p class="text-xs text-gray-500 uppercase tracking-wide">Total Earnings</p>
                            <p class="text-lg font-bold text-green-600">${data.total_earnings}</p>
                        </div>
                        <div class="text-center border-l border-gray-100">
                            <p class="text-xs text-gray-500 uppercase tracking-wide">Total Jobs</p>
                            <p class="text-lg font-bold text-blue-600">${data.total_jobs}</p>
                        </div>
                        <div class="text-center border-l border-gray-100">
                            <p class="text-xs text-gray-500 uppercase tracking-wide">Total Hours</p>
                            <p class="text-lg font-bold text-purple-600">${data.total_hours}</p>
                        </div>
                    </div>

                    <div>
                        <h4 class="text-sm font-bold text-gray-900 uppercase mb-2">About & Skills</h4>
                        <p class="text-gray-600 text-sm leading-relaxed mb-3">${data.description}</p>
                        <div class="flex flex-wrap gap-2">
                            ${data.skills.slice(0, 5).map(skill => `<span class="px-2 py-1 bg-blue-50 text-blue-700 text-xs font-semibold rounded border border-blue-100">${skill}</span>`).join('')}
                        </div>
                    </div>

                    <div class="bg-gray-50 p-4 rounded-lg border border-gray-100">
                        <h4 class="text-sm font-bold text-gray-900 uppercase mb-3">Location Details</h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-y-3 gap-x-4 text-sm">
                            <div><span class="text-gray-500 block text-xs">Current Address</span> <span class="text-gray-800 font-medium">${data.address.current}</span></div>
                            <div><span class="text-gray-500 block text-xs">City/State</span> <span class="text-gray-800 font-medium">${data.address.city}, ${data.address.state}</span></div>
                            <div><span class="text-gray-500 block text-xs">Zip Code</span> <span class="text-gray-800 font-medium">${data.address.zip}</span></div>
                            <div class="col-span-1 md:col-span-2"><span class="text-gray-500 block text-xs">Permanent Address</span> <span class="text-gray-800">${data.address.permanent}</span></div>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-6">
                        <div>
                            <h4 class="text-sm font-bold text-gray-900 uppercase mb-2">Languages</h4>
                            <ul class="list-disc list-inside text-sm text-gray-600 space-y-1">
                                ${data.languages.map(l => `<li>${l}</li>`).join('')}
                            </ul>
                        </div>
                        <div>
                            <h4 class="text-sm font-bold text-gray-900 uppercase mb-2">Logistics</h4>
                            <p class="text-sm text-gray-600 mb-1"><i class="fas fa-wallet mr-2 text-gray-400"></i> ${data.payment_methods.join(', ')}</p>
                            <p class="text-sm text-gray-600"><i class="fas fa-motorcycle mr-2 text-gray-400"></i> ${data.transportation}</p>
                        </div>
                    </div>

                    <div>
                        <h4 class="text-sm font-bold text-gray-900 uppercase mb-3">History & Education</h4>
                        <div class="space-y-3">
                            ${data.work_history.map(work => `
                                <div class="flex justify-between text-sm">
                                    <div><span class="font-bold text-gray-800">${work.role}</span> <span class="text-gray-500">at ${work.company}</span></div>
                                    <span class="text-gray-400 text-xs">${work.dates}</span>
                                </div>
                            `).join('')}
                            <hr class="border-gray-100">
                            ${data.education.map(edu => `
                                <div class="flex justify-between text-sm">
                                    <div><span class="font-bold text-gray-800">${edu.degree}</span> <span class="text-gray-500">, ${edu.institute}</span></div>
                                    <span class="text-gray-400 text-xs">${edu.year}</span>
                                </div>
                            `).join('')}
                        </div>
                    </div>

                    <div>
                        <h4 class="text-sm font-bold text-gray-900 uppercase mb-3">Portfolio Projects</h4>
                        <div class="grid grid-cols-1 gap-4">
                            ${data.portfolio.map(proj => `
                                <div class="flex border border-gray-100 rounded-lg overflow-hidden shadow-sm hover:shadow-md transition">
                                    <img src="${proj.image}" class="w-24 h-24 object-cover">
                                    <div class="p-3 flex-1">
                                        <h5 class="font-bold text-sm text-gray-800">${proj.name}</h5>
                                        <p class="text-xs text-gray-500 mb-1">${proj.role} &bull; ${proj.skill}</p>
                                        <p class="text-xs text-gray-600 line-clamp-2">${proj.desc}</p>
                                    </div>
                                </div>
                            `).join('')}
                        </div>
                    </div>

                    <div>
                        <h4 class="text-sm font-bold text-gray-900 uppercase mb-3">Upcoming & Recent Bookings</h4>
                        <div class="overflow-hidden border border-gray-200 rounded-lg">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase">Order</th>
                                        <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase">Service</th>
                                        <th class="px-3 py-2 text-center text-xs font-medium text-gray-500 uppercase">Status</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    ${data.bookings.map(book => `
                                        <tr>
                                            <td class="px-3 py-2 text-xs text-gray-500">
                                                <div class="font-medium text-gray-900">${book.order_id}</div>
                                                <div>${book.date}</div>
                                            </td>
                                            <td class="px-3 py-2 text-xs text-gray-700">
                                                <div class="font-medium">${book.title}</div>
                                                <div class="text-gray-500">${book.rate}</div>
                                            </td>
                                            <td class="px-3 py-2 text-center">
                                                <span class="px-2 py-0.5 inline-flex text-[10px] leading-4 font-semibold rounded-full ${book.status === 'Completed' ? 'bg-green-100 text-green-800' : (book.status === 'Pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800')}">
                                                    ${book.status}
                                                </span>
                                            </td>
                                        </tr>
                                    `).join('')}
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            `;
    }
</script>
@endpush