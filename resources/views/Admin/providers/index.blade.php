@extends('layouts.app')

@section('content')
<div class="space-y-6 pl-5">
    <h1 class="text-3xl font-bold text-gray-900 tracking-tight">
        Service Provider Management
    </h1>

    {{-- ========================================== --}}
    {{-- 1. ANALYTICS WIDGETS --}}
    {{-- ========================================== --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-6 gap-5">
        {{-- Note: In a real scenario, calculate these counts from the backend --}}
        @php
        $stats = [
            ['title' => 'Total Providers', 'value' => $providers->count() ?? 0, 'icon' => 'fas fa-users', 'color' => 'blue'],
            ['title' => 'Active Providers', 'value' => $providers->where('status', 'active')->count() ?? 0, 'icon' => 'fas fa-user-check', 'color' => 'green'],
            ['title' => 'Pending KYC', 'value' => 'NaN', 'icon' => 'fas fa-hourglass-half', 'color' => 'yellow'], // Not in DB
            ['title' => 'Suspended', 'value' => $providers->where('status', 'suspend')->count() ?? 0, 'icon' => 'fas fa-gavel', 'color' => 'red'],
            ['title' => 'Online Now', 'value' => 'NaN', 'icon' => 'fas fa-circle', 'color' => 'teal'], // Not in DB
            ['title' => "Today's Earnings", 'value' => 'NaN', 'icon' => 'fas fa-dollar-sign', 'color' => 'purple'], // Not in DB
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
                        {{-- Static for now as Categories are not in DB --}}
                        <option>N/A</option>
                    </select>
                    <select id="kycFilter" class="p-2.5 border border-gray-300 rounded-xl text-sm text-gray-600 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Status</option>
                        <option value="active">Active</option>
                        <option value="suspend">Suspended</option>
                        <option value="Ban">Banned</option>
                        <option value="deactive">Deactive</option>
                    </select>
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
                <button onclick="openCreateProviderModal()" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg shadow-md transition duration-150">
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
                        @forelse ($providers as $provider)
                        @php
                            // Determine Status Color
                            $statusColor = match ($provider->status) {
                                'active' => 'bg-green-100 text-green-800',
                                'suspend' => 'bg-yellow-100 text-yellow-800',
                                'Ban' => 'bg-red-100 text-red-800',
                                'deactive' => 'bg-gray-100 text-gray-800',
                                default => 'bg-gray-100 text-gray-800',
                            };
                            
                            // Image Handling
                            $image = $provider->image ? asset($provider->image) : 'https://ui-avatars.com/api/?name=' . urlencode($provider->name) . '&color=7F9CF5&background=EBF4FF';

                            // Construct JSON Object for Slide Over
                            $jsData = [
                                'id' => $provider->id,
                                'name' => $provider->name ?? 'N/A',
                                'image' => $image,
                                'email' => $provider->email ?? 'N/A',
                                'phone' => $provider->phone ?? 'N/A',
                                'gender' => $provider->gender ?? 'N/A',
                                'dob' => $provider->dob ?? 'N/A',
                                'status' => $provider->status,
                                'join_date' => $provider->created_at ? $provider->created_at->format('M d, Y') : 'N/A',
                                // Data not in DB set to NaN/N/A
                                'main_category' => 'N/A',
                                'sub_categories' => [],
                                'hourly_rate' => 'NaN',
                                'total_earnings' => 'NaN',
                                'total_jobs' => 'NaN',
                                'total_hours' => 'NaN',
                                'description' => 'N/A',
                                'skills' => [],
                                'address' => [
                                    'current' => $provider->current_address ?? 'N/A',
                                    'permanent' => $provider->address ?? 'N/A',
                                    'city' => $provider->city ?? 'N/A',
                                    'state' => $provider->state ?? 'N/A',
                                    'zip' => $provider->zipcode ?? 'N/A',
                                    'country' => 'N/A'
                                ],
                                'languages' => [], 
                                'education' => [],
                                'payment_methods' => [],
                                'transportation' => 'N/A',
                                'work_history' => [],
                                'portfolio' => [],
                                'bookings' => []
                            ];
                        @endphp

                        <tr class="hover:bg-blue-50/50 transition duration-150 ease-in-out">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <img class="h-10 w-10 rounded-full object-cover shadow-sm ring-1 ring-gray-100" src="{{ $image }}" alt="{{ $provider->name }}">
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900 search-name">{{ $provider->name }}</div>
                                        <div class="text-xs text-gray-500">ID: #{{ $provider->id }}</div>
                                        <div class="text-xs text-gray-400">{{ $provider->email }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-medium rounded-full bg-blue-100 text-blue-800">
                                    N/A {{-- Category Missing --}}
                                </span>
                                <div class="text-xs text-gray-500 mt-1">
                                    <i class="fas fa-tag text-gray-400 mr-1"></i> $NaN/hr
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm">
                                <div class="mb-1">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $statusColor }}">
                                        {{ ucfirst($provider->status) }}
                                    </span>
                                </div>
                                <div>
                                    <span class="inline-flex items-center text-xs font-medium text-gray-700">
                                        {{-- Mode not in DB, assuming N/A --}}
                                        <i class="fas fa-circle text-gray-300 text-[8px] mr-1"></i> N/A
                                    </span>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm">
                                <div class="text-yellow-500 flex items-center justify-center">
                                    <i class="fas fa-star text-xs mr-1"></i> NaN
                                </div>
                                <div class="text-xs text-gray-500 mt-1">
                                    **NaN** Jobs Done
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <div class="text-gray-900">
                                    **$NaN**
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <div class="flex justify-end items-center space-x-2">
                                    <button onclick="openProviderDetails({{ json_encode($jsData) }})" class="px-3 py-1 text-blue-600 bg-blue-50 rounded-md hover:bg-blue-100 transition duration-150 text-xs font-semibold" title="View Full Details">
                                        View Details
                                    </button>
                                    <div class="relative inline-block text-left" x-data="{ open: false }">
                                        <button @click="open = !open" class="action-dropdown-btn inline-flex justify-center rounded-full text-gray-400 hover:text-gray-600 p-1 focus:outline-none transition duration-150">
                                            <i class="fas fa-ellipsis-v text-sm"></i>
                                        </button>
                                        <div class="action-dropdown-menu hidden origin-top-right absolute right-0 mt-2 w-56 rounded-lg shadow-2xl bg-white ring-1 ring-black ring-opacity-5 divide-y divide-gray-100 z-20" role="menu">
                                            <div class="py-1">
                                                <a href="#" class="flex items-center px-4 py-2 text-sm text-green-700 hover:bg-green-50"><i class="fas fa-check-circle mr-3 w-4"></i> Approve</a>
                                                <a href="#" class="flex items-center px-4 py-2 text-sm text-red-700 hover:bg-red-50"><i class="fas fa-times-circle mr-3 w-4"></i> Suspend</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="px-6 py-10 text-center text-gray-500">
                                No service providers found.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- PAGINATION (Assuming $providers is a paginated collection) --}}
        <div class="p-5 border-t border-gray-100">
            {{-- Check if $providers is instance of Paginator --}}
            @if($providers instanceof \Illuminate\Pagination\LengthAwarePaginator)
                {{ $providers->links() }} 
            @else
                <div class="text-sm text-gray-500 text-center">
                    Showing {{ $providers->count() }} records.
                </div>
            @endif
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

{{-- ========================================== --}}
{{-- 4. CREATE PROVIDER MODAL --}}
{{-- ========================================== --}}
<div id="create-provider-modal" class="fixed inset-0 z-50 hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-gray-900 bg-opacity-75 transition-opacity backdrop-blur-sm" onclick="closeCreateProviderModal()"></div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        <div class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg w-full">
            <div class="bg-white px-6 py-6 border-b border-gray-100 flex justify-between items-center">
                <h3 class="text-xl font-bold text-gray-800">Create New Provider</h3>
                <button onclick="closeCreateProviderModal()" class="text-gray-400 hover:text-gray-600 focus:outline-none">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            <form id="createProviderForm" class="p-6 space-y-5">
                @csrf
                <div id="createErrorMessage" class="hidden bg-red-50 text-red-600 p-3 rounded-lg text-sm"></div>
                <div id="createSuccessMessage" class="hidden bg-green-50 text-green-600 p-3 rounded-lg text-sm"></div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Full Name</label>
                    <input type="text" name="name" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm p-2.5 border" placeholder="e.g. John Doe">
                    <span class="text-xs text-red-500 error-text name_error"></span>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
                    <input type="email" name="email" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm p-2.5 border" placeholder="e.g. john@example.com">
                    <span class="text-xs text-red-500 error-text email_error"></span>
                </div>

                 {{-- <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Category</label>
                        <select name="category" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm p-2.5 border">
                            <option value="">Select Category</option>
                            <option value="plumber">Plumber</option>
                            <option value="electrician">Electrician</option>
                            <option value="technician">Technician</option>
                        </select>
                        <span class="text-xs text-red-500 error-text category_error"></span>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Hourly Rate ($)</label>
                        <input type="number" name="hourly_rate" step="0.01" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm p-2.5 border" placeholder="0.00">
                        <span class="text-xs text-red-500 error-text hourly_rate_error"></span>
                    </div>
                </div>  --}}
            </form>

            <div class="p-6 border-t border-gray-200 flex justify-end bg-gray-50">
                <button type="button" onclick="closeCreateProviderModal()" class="mr-3 px-4 py-2 text-gray-600 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 shadow-sm transition">Cancel</button>

                <button type="button" id="submitProviderBtn" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 shadow-md flex items-center transition">
                    <svg id="providerLoadingIcon" class="hidden animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    Save Provider
                </button>
            </div>
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
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        // --- 1. Filter Logic ---
        const rows = document.querySelectorAll("tbody tr");

        function applyFilters() {
            const search = document.getElementById("searchInput").value.toLowerCase().trim();
            const category = document.getElementById("categoryFilter").value.toLowerCase().trim();
            const status = document.getElementById("kycFilter").value.toLowerCase().trim();

            rows.forEach(row => {
                const name = row.querySelector(".search-name").innerText.toLowerCase();
                // Status is in the 3rd column (index 2)
                const rowStatus = row.querySelector("td:nth-child(3) span").innerText.toLowerCase();
                
                let show = true;
                if (search && !name.includes(search)) show = false;
                if (status && !rowStatus.includes(status)) show = false;
                
                row.style.display = show ? "" : "none";
            });
        }

        document.querySelectorAll("#searchInput, #categoryFilter, #kycFilter").forEach(el => {
            el.addEventListener("input", applyFilters);
            el.addEventListener("change", applyFilters);
        });
        document.getElementById("resetFilters").addEventListener("click", function() {
            document.getElementById("searchInput").value = "";
            document.getElementById("categoryFilter").value = "";
            document.getElementById("kycFilter").value = "";
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

        // --- 3. AJAX Logic for Create Provider ---
        const submitBtn = document.getElementById('submitProviderBtn');
        const form = document.getElementById('createProviderForm');
        const errorDiv = document.getElementById('createErrorMessage');
        const successDiv = document.getElementById('createSuccessMessage');
        const loader = document.getElementById('providerLoadingIcon');

        submitBtn.addEventListener('click', function(e) {
            e.preventDefault();

            submitBtn.disabled = true;
            loader.classList.remove('hidden');
            errorDiv.classList.add('hidden');
            successDiv.classList.add('hidden');
            document.querySelectorAll('.error-text').forEach(el => el.innerText = '');

            let formData = new FormData(form);

            axios.post("{{ route('store.provider') }}", formData, {
                    headers: { 'Accept': 'application/json' }
                })
                .then(response => {
                    successDiv.innerText = response.data.message || 'Provider created successfully!';
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

    // --- 4. Modal Logic ---
    function openCreateProviderModal() {
        document.getElementById('createProviderForm').reset();
        document.getElementById('createErrorMessage').classList.add('hidden');
        document.getElementById('createSuccessMessage').classList.add('hidden');
        document.querySelectorAll('.error-text').forEach(el => el.innerText = '');
        document.getElementById('create-provider-modal').classList.remove('hidden');
    }

    function closeCreateProviderModal() {
        document.getElementById('create-provider-modal').classList.add('hidden');
    }

    // --- 5. Slide-Over Logic (DYNAMIC) ---
    const slideOver = document.getElementById('details-slide-over');
    const slideOverOverlay = document.getElementById('slide-over-overlay');
    const slideOverContent = document.getElementById('slide-over-content');
    const slideOverTitle = document.getElementById('slide-over-title');

    // Updated to accept data object directly
    window.openProviderDetails = function(data) {
        slideOverTitle.textContent = data.name;
        slideOverContent.innerHTML = generateSlideOverContent(data);

        slideOver.classList.add('open');
        slideOverOverlay.classList.remove('hidden');
        document.body.classList.add('overflow-hidden');
    }

    window.closeProviderDetails = function() {
        slideOver.classList.remove('open');
        slideOverOverlay.classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
    }

    document.getElementById('slide-over-close').addEventListener('click', window.closeProviderDetails);
    slideOverOverlay.addEventListener('click', window.closeProviderDetails);

    /**
     * CONTENT GENERATOR (Updated to handle NaN/N/A)
     */
    function generateSlideOverContent(data) {
        // Safe helpers for array mapping
        const skillsHtml = data.skills.length > 0 
            ? data.skills.slice(0, 5).map(skill => `<span class="px-2 py-1 bg-blue-50 text-blue-700 text-xs font-semibold rounded border border-blue-100">${skill}</span>`).join('')
            : '<span class="text-xs text-gray-500 italic">No skills listed (N/A)</span>';

        const languagesHtml = data.languages.length > 0
            ? data.languages.map(l => `<li>${l}</li>`).join('')
            : '<li class="italic text-gray-400">N/A</li>';

        const paymentHtml = data.payment_methods.length > 0
            ? data.payment_methods.map(pm => `<span class="inline-flex items-center px-2 py-1 rounded-md text-[10px] font-medium bg-white text-gray-700 border border-gray-200 shadow-sm"><i class="fas fa-credit-card mr-1.5 text-gray-400"></i> ${pm}</span>`).join('')
            : '<span class="text-xs text-gray-500 italic">N/A</span>';

        return `
                <div class="space-y-8">
                    {{-- Header --}}
                    <div class="flex items-start space-x-4">
                        <img src="${data.image}" class="w-20 h-20 rounded-full border-4 border-white shadow-lg object-cover">
                        <div class="flex-1">
                            <h2 class="text-2xl font-bold text-gray-900">${data.name}</h2>
                            <p class="text-blue-600 font-medium">${data.main_category}</p>
                            <p class="text-xs text-gray-400 mt-1">Joined: ${data.join_date}</p>
                            <p class="text-xs text-gray-500">Gender: ${data.gender} | DOB: ${data.dob}</p>
                        </div>
                        <div class="text-right">
                            <div class="text-2xl font-bold text-gray-900">$${data.hourly_rate}<span class="text-sm font-normal text-gray-500">/hr</span></div>
                            <span class="inline-block mt-2 px-2 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-800 uppercase tracking-wide">${data.status}</span>
                        </div>
                    </div>

                    {{-- Stats --}}
                    <div class="grid grid-cols-3 gap-4 border-t border-b border-gray-100 py-4">
                        <div class="text-center">
                            <p class="text-xs text-gray-500 uppercase tracking-wide">Total Earnings</p>
                            <p class="text-lg font-bold text-green-600">$${data.total_earnings}</p>
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

                    {{-- About --}}
                    <div>
                        <h4 class="text-sm font-bold text-gray-900 uppercase mb-2">About & Skills</h4>
                        <p class="text-gray-600 text-sm leading-relaxed mb-3">${data.description}</p>
                        <div class="flex flex-wrap gap-2">
                            ${skillsHtml}
                        </div>
                    </div>

                    {{-- Address --}}
                    <div class="bg-gray-50 p-4 rounded-lg border border-gray-100">
                        <h4 class="text-sm font-bold text-gray-900 uppercase mb-3">Location Details</h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-y-3 gap-x-4 text-sm">
                            <div><span class="text-gray-500 block text-xs">Current Address</span> <span class="text-gray-800 font-medium">${data.address.current}</span></div>
                            <div><span class="text-gray-500 block text-xs">City/State</span> <span class="text-gray-800 font-medium">${data.address.city}, ${data.address.state}</span></div>
                            <div><span class="text-gray-500 block text-xs">Zip Code</span> <span class="text-gray-800 font-medium">${data.address.zip}</span></div>
                            <div class="col-span-1 md:col-span-2"><span class="text-gray-500 block text-xs">Permanent Address</span> <span class="text-gray-800">${data.address.permanent}</span></div>
                        </div>
                    </div>

                    {{-- Details Grid --}}
                    <div class="grid grid-cols-2 gap-6">
                        <div>
                            <h4 class="text-sm font-bold text-gray-900 uppercase mb-2">Languages</h4>
                            <ul class="list-disc list-inside text-sm text-gray-600 space-y-1">
                                ${languagesHtml}
                            </ul>
                        </div>
                        <div>
                            <h4 class="text-sm font-bold text-gray-900 uppercase mb-2">Logistics & Payment</h4>
                             <p class="text-sm text-gray-600 mb-3"><i class="fas fa-motorcycle mr-2 text-gray-400"></i> ${data.transportation}</p>
                             
                             <div class="bg-gray-50 rounded-lg p-3 border border-gray-100">
                                 <div class="flex justify-between items-center mb-2">
                                     <span class="text-xs font-semibold text-gray-500 uppercase">Payment Methods</span>
                                 </div>
                                 <div class="flex flex-wrap gap-2">
                                    ${paymentHtml}
                                 </div>
                             </div>
                        </div>
                    </div>

                    {{-- Missing Data Sections (Visual Placeholders) --}}
                    <div>
                        <h4 class="text-sm font-bold text-gray-900 uppercase mb-3">Portfolio Projects</h4>
                        <p class="text-sm text-gray-500 italic border p-4 rounded text-center bg-gray-50">No portfolio projects available (N/A)</p>
                    </div>

                    <div>
                        <h4 class="text-sm font-bold text-gray-900 uppercase mb-3">Recent Bookings</h4>
                         <p class="text-sm text-gray-500 italic border p-4 rounded text-center bg-gray-50">No booking history available (N/A)</p>
                    </div>
                </div>
            `;
    }
</script>
@endpush