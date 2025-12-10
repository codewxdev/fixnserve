@extends('layouts.app')

@section('content')
    <div class="space-y-6">
        <h1 class="text-3xl font-bold text-gray-900 tracking-tight">
            Service Provider Management 
        </h1>

        {{-- 1. Provider Analytics Summary (Top Widgets) --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-6 gap-5">
            <x-partials.providers.analytics-cards />
        </div>

        {{-- 2. Main Content Area --}}
        <div class="bg-white shadow-xl rounded-xl overflow-hidden">

            {{-- 3. Filters & Search (Sticky Bar) --}}
            <div id="sticky-filter-bar"
                class="p-5 border-b border-gray-100 bg-white sticky top-0 z-10 transition duration-300 ease-in-out">
                <x-partials.providers.filter-bar />
            </div>

            {{-- 4. Provider List Table --}}
            <div class="p-5">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-xl font-semibold text-gray-800">Current Providers</h2>
                    <button class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg shadow-md transition duration-150">
                        <i class="fas fa-plus mr-1"></i> Add New Provider
                    </button>
                </div>
                <x-partials.providers.provider-table />
            </div>

            {{-- 5. Pagination --}}
            <div class="p-5 border-t border-gray-100 flex justify-between items-center text-sm text-gray-600">
                <div class="text-xs text-gray-500">
                    Showing <span class="font-medium">1</span> to <span class="font-medium">10</span> of <span class="font-medium">4,520</span> results
                </div>
                <nav class="flex items-center space-x-1">
                    <a href="#" class="px-3 py-1 border border-gray-300 rounded-lg text-gray-600 hover:bg-blue-50 hover:border-blue-500 transition duration-150">&laquo; Previous</a>
                    <span class="px-3 py-1 bg-blue-600 text-white rounded-lg font-semibold shadow-md">1</span>
                    <a href="#" class="px-3 py-1 border border-gray-300 rounded-lg text-gray-600 hover:bg-blue-50 hover:border-blue-500">2</a>
                    <a href="#" class="px-3 py-1 border border-gray-300 rounded-lg text-gray-600 hover:bg-blue-50 hover:border-blue-500">3</a>
                    <a href="#" class="px-3 py-1 border border-gray-300 rounded-lg text-gray-600 hover:bg-blue-50 hover:border-blue-500">Next &raquo;</a>
                </nav>
            </div>

        </div>

    </div>
    
    {{-- 6. Side Panel for Provider Full Details --}}
    <x-partials.providers.details-slide-over />
@endsection

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        /* Custom styles for premium shadow and typography */
        .shadow-xl {
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.05), 0 10px 10px -5px rgba(0, 0, 0, 0.02); /* Deeper but softer shadow */
        }

        .slide-over-panel {
            transform: translateX(100%);
            transition: transform 0.4s cubic-bezier(0.4, 0, 0.2, 1); /* Beautiful animation */
        }

        .slide-over-panel.open {
            transform: translateX(0);
        }

        /* Sticky Filter Bar Visual Enhancement */
        #sticky-filter-bar {
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.04);
        }
    </style>
@endpush

@push('scripts')
    <script>
        // Global state for selected provider data (simulating reactive framework)
        let currentProviderData = {};

        // --- Slide-Over Panel Logic ---
        const slideOver = document.getElementById('details-slide-over');
        const slideOverOverlay = document.getElementById('slide-over-overlay');
        const slideOverContent = document.getElementById('slide-over-content');
        const slideOverTitle = document.getElementById('slide-over-title');

        /**
         * Simulates fetching and loading data into the side panel
         * @param {string} providerId - The ID of the provider to load.
         */
        window.openProviderDetails = function(providerId) {
            // 1. Show Loading State (Optional, but professional)
            slideOverTitle.textContent = 'Loading...';
            slideOverContent.innerHTML = '<div class="text-center py-10 text-gray-500"><i class="fas fa-sync-alt fa-spin mr-2"></i> Fetching Provider Data...</div>';
            
            // 2. Open Panel
            slideOver.classList.add('open');
            slideOverOverlay.classList.remove('hidden');
            document.body.classList.add('overflow-hidden');

            // 3. Simulate API Call (Replace this with actual Axios/Fetch call)
            setTimeout(() => {
                const dummyData = getProviderData(providerId); // Function below simulates fetching data
                currentProviderData = dummyData;

                slideOverTitle.textContent = 'Provider Details: ' + dummyData.name;
                slideOverContent.innerHTML = generateSlideOverContent(dummyData); // Function below generates content
                
            }, 500); // 500ms delay for fetching simulation
        }

        window.closeProviderDetails = function() {
            slideOver.classList.remove('open');
            slideOverOverlay.classList.add('hidden');
            document.body.classList.remove('overflow-hidden');
            // Clear content after closing for next load
            slideOverTitle.textContent = ''; 
            slideOverContent.innerHTML = '';
        }

        // Attach close handlers
        document.getElementById('slide-over-close').addEventListener('click', window.closeProviderDetails);
        slideOverOverlay.addEventListener('click', window.closeProviderDetails);


        // --- Action Menu Dropdown Logic (Pure JS) ---
        // This makes the dropdown logic more robust for multiple instances
        document.addEventListener('click', (e) => {
            const isButton = e.target.closest('.action-dropdown-btn');
            
            // Close all dropdowns
            document.querySelectorAll('.action-dropdown-menu').forEach(menu => {
                if (!isButton || menu.parentNode !== isButton.closest('.relative')) {
                    menu.classList.add('hidden');
                }
            });

            // Open the clicked one
            if (isButton) {
                const dropdown = isButton.closest('.relative').querySelector('.action-dropdown-menu');
                dropdown.classList.toggle('hidden');
                e.stopPropagation(); // Prevent the close-all listener from immediately closing it
            }
        });

        // --- Dummy Data and Content Generator (for demo) ---
        function getProviderData(id) {
            // Placeholder for data fetching logic
            return {
                id: id,
                name: 'Jane Doe ' + id,
                email: 'jane.doe' + id + '@fixnserve.com',
                phone: '+92 312 9876543',
                category: 'Plumber',
                rating: '4.9',
                kycStatus: 'Verified',
                earnings: '45,800.00',
                violations: 0,
                kyc: [
                    { doc: 'National ID', status: 'Verified', date: '2023-01-20' },
                    { doc: 'Background Check', status: 'Verified', date: '2023-01-25' },
                    { doc: 'Proof of Address', status: 'Pending', date: null }
                ],
                skills: ['Pipe Fitting', 'Drain Cleaning', 'Water Heater Repair'],
                location: '24.8607° N, 66.9905° E (Karachi Zone A)',
                lastLogin: '2 minutes ago'
            };
        }

        function generateSlideOverContent(data) {
            return `
                <div class="mt-4 space-y-6">
                    <div class="p-4 border border-blue-100 rounded-xl shadow-sm bg-blue-50">
                        <h4 class="font-semibold text-blue-700 flex items-center mb-2"><i class="fas fa-info-circle mr-2"></i> Basic Information</h4>
                        <p class="text-sm text-gray-700">Phone: <strong>${data.phone}</strong></p>
                        <p class="text-sm text-gray-700">Email: <strong>${data.email}</strong></p>
                        <p class="text-sm text-gray-700">Category: <span class="font-semibold text-blue-600">${data.category}</span></p>
                    </div>

                    <div class="p-4 border rounded-xl shadow-sm">
                        <h4 class="font-semibold text-gray-800 flex items-center mb-3"><i class="fas fa-file-contract mr-2 text-yellow-600"></i> KYC & Document Status</h4>
                        <ul class="space-y-2">
                            ${data.kyc.map(doc => `
                                <li class="flex justify-between text-sm">
                                    <span>${doc.doc}:</span>
                                    <span class="font-medium ${doc.status === 'Verified' ? 'text-green-600' : 'text-yellow-600'} flex items-center">
                                        <i class="fas ${doc.status === 'Verified' ? 'fa-check-circle' : 'fa-hourglass-half'} mr-1"></i> ${doc.status}
                                    </span>
                                </li>
                            `).join('')}
                        </ul>
                        <button class="mt-4 text-xs font-medium text-blue-500 hover:text-blue-700">Review Documents</button>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div class="p-4 border rounded-xl shadow-sm bg-green-50">
                            <h4 class="font-semibold text-green-700 flex items-center mb-2"><i class="fas fa-star mr-2"></i> Rating</h4>
                            <p class="text-3xl font-bold text-green-800">${data.rating}</p>
                            <p class="text-xs text-gray-500">Avg. from 500+ orders</p>
                        </div>
                        <div class="p-4 border rounded-xl shadow-sm bg-indigo-50">
                            <h4 class="font-semibold text-indigo-700 flex items-center mb-2"><i class="fas fa-wallet mr-2"></i> Lifetime Earnings</h4>
                            <p class="text-3xl font-bold text-indigo-800">$${data.earnings}</p>
                            <p class="text-xs text-gray-500">Wallet Balance: $1,500.00</p>
                        </div>
                    </div>
                    
                    <div class="p-4 border rounded-xl shadow-sm">
                        <h4 class="font-semibold text-gray-800 flex items-center mb-3"><i class="fas fa-tools mr-2 text-gray-600"></i> Skills & Service Zones</h4>
                        <div class="flex flex-wrap gap-2 mb-3">
                            ${data.skills.map(skill => `<span class="px-3 py-1 bg-gray-200 text-gray-700 text-xs rounded-full">${skill}</span>`).join('')}
                        </div>
                        <p class="text-sm text-gray-700">Service Zone: **Karachi Zone A**</p>
                        <button class="mt-3 text-xs font-medium text-blue-500 hover:text-blue-700">View Availability Calendar</button>
                    </div>

                    <div class="p-4 border rounded-xl shadow-sm">
                        <h4 class="font-semibold text-gray-800 flex items-center mb-2"><i class="fas fa-map-marker-alt mr-2 text-red-500"></i> Live Location</h4>
                        <div class="h-48 bg-gray-100 rounded-lg flex items-center justify-center text-gray-500">
                             
                        </div>
                        <p class="text-xs text-gray-500 mt-2">Current Location: ${data.location}</p>
                        <p class="text-xs text-gray-500">Last Active: ${data.lastLogin}</p>
                    </div>

                </div>
            `;
        }
    </script>
@endpush

 
 
 