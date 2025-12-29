@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-gray-50/50 px-6 py-8 md:px-10 lg:px-12">
        
        <div class="mb-8 flex flex-col md:flex-row md:items-center md:justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 tracking-tight">Expert Management</h1>
                <p class="text-gray-500 mt-1">Manage KYC, validations, and platform performance.</p>
            </div>
            <div class="mt-4 md:mt-0">
                <button class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg text-sm font-medium shadow-sm transition-colors">
                    + Invite New Expert
                </button>
            </div>
        </div>

        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4 xl:grid-cols-5 mb-8">
            <x-partials.experts.analytics-cards/> 
        </div>

        <x-partials.experts.filter-panel />

        <div class="bg-white border border-gray-100 rounded-xl shadow-sm mt-8 overflow-hidden">
             
            <div class="overflow-x-auto">
                <x-partials.experts.experts-table/>
            </div>
             <div class="px-6 py-4 border-t border-gray-100 flex justify-center">
                 <span class="text-sm text-gray-500">Showing 1-10 of 1,450 results</span>
            </div>
        </div>
    </div>

    <x-partials.experts.expert-details-slideover/>

@endsection

@push('styles')
    <style>
        /* Smooth Scrollbar */
        .custom-scrollbar::-webkit-scrollbar { width: 6px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: #f1f1f1; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #c7c7c7; border-radius: 3px; }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: #a0a0a0; }
        
        /* Range Slider Customization */
        input[type=range]::-webkit-slider-thumb {
            -webkit-appearance: none;
            height: 16px;
            width: 16px;
            border-radius: 50%;
            background: #4f46e5;
            cursor: pointer;
            margin-top: -6px; 
        }
        input[type=range]::-webkit-slider-runnable-track {
            width: 100%;
            height: 4px;
            background: #e5e7eb;
            border-radius: 2px;
        }
    </style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        
        /* -------------------------------------------------------------------------- */
        /* 1. SLIDE OVER LOGIC                        */
        /* -------------------------------------------------------------------------- */
        const slideover = document.getElementById('expert-details-slideover');
        const backdrop = document.getElementById('slideover-backdrop');
        const panel = document.getElementById('slideover-panel');

        window.openExpertDetails = function(expertId) {
            slideover.classList.remove('hidden');
            setTimeout(() => {
                backdrop.classList.remove('opacity-0');
                backdrop.classList.add('opacity-100');
                panel.classList.remove('translate-x-full');
                panel.classList.add('translate-x-0');
            }, 10);
        };

        window.closeExpertDetails = function() {
            backdrop.classList.remove('opacity-100');
            backdrop.classList.add('opacity-0');
            panel.classList.remove('translate-x-0');
            panel.classList.add('translate-x-full');
            setTimeout(() => {
                slideover.classList.add('hidden');
            }, 500); 
        };

        /* -------------------------------------------------------------------------- */
        /* 2. FILTER SYSTEM LOGIC                     */
        /* -------------------------------------------------------------------------- */
        
        // Input Elements
        const searchInput = document.getElementById('filter-search');
        const categorySelect = document.getElementById('filter-category');
        const regionSelect = document.getElementById('filter-region');
        const kycSelect = document.getElementById('filter-kyc');
        const rateInput = document.getElementById('filter-rate');
        const rateDisplay = document.getElementById('rate-display');
        const statusRadios = document.querySelectorAll('.status-radio');
        const resetButton = document.getElementById('reset-filters');
        
        // Table Elements
        const tableRows = document.querySelectorAll('.expert-row');
        const showingText = document.getElementById('showing-text');
        const totalCountBadge = document.getElementById('result-count');

        // Function to run the filter
        function filterExperts() {
            const searchValue = searchInput.value.toLowerCase();
            const categoryValue = categorySelect.value.toLowerCase();
            const regionValue = regionSelect.value.toLowerCase();
            const kycValue = kycSelect.value.toLowerCase();
            const maxRate = parseInt(rateInput.value);
            
            // Get checked radio value
            let statusValue = 'all';
            document.querySelectorAll('input[name="status"]').forEach(radio => {
                if(radio.checked) statusValue = radio.value;
            });

            let visibleCount = 0;

            tableRows.forEach(row => {
                // Get data from data-attributes
                const name = row.dataset.name.toLowerCase();
                const id = row.dataset.id.toLowerCase();
                const category = row.dataset.category.toLowerCase();
                const region = row.dataset.region ? row.dataset.region.toLowerCase() : '';
                const kyc = row.dataset.kyc.toLowerCase();
                const rate = parseInt(row.dataset.rate);
                const status = row.dataset.status.toLowerCase();

                // Logic Checks
                const matchesSearch = name.includes(searchValue) || id.includes(searchValue);
                const matchesCategory = categoryValue === '' || category === categoryValue;
                const matchesRegion = regionValue === '' || region === regionValue;
                const matchesKyc = kycValue === '' || kyc === kycValue;
                const matchesRate = rate <= maxRate;
                const matchesStatus = statusValue === 'all' || status === statusValue;

                // Toggle Visibility
                if (matchesSearch && matchesCategory && matchesRegion && matchesKyc && matchesRate && matchesStatus) {
                    row.classList.remove('hidden');
                    visibleCount++;
                } else {
                    row.classList.add('hidden');
                }
            });

            // Update UI Counters
            showingText.innerText = `Showing ${visibleCount} results`;
            totalCountBadge.innerText = `Total: ${visibleCount}`;
        }

        // Add Event Listeners to inputs
        // Real-time filtering for text and slider
        searchInput.addEventListener('input', filterExperts);
        rateInput.addEventListener('input', function() {
            rateDisplay.innerText = this.value; // Update number display
            filterExperts();
        });

        // Change filtering for selects and radios
        categorySelect.addEventListener('change', filterExperts);
        regionSelect.addEventListener('change', filterExperts);
        kycSelect.addEventListener('change', filterExperts);
        statusRadios.forEach(radio => radio.addEventListener('change', filterExperts));

        // Reset Button
        resetButton.addEventListener('click', () => {
            document.getElementById('filter-form').reset();
            rateDisplay.innerText = "300"; // Reset slider text
            filterExperts(); // Re-run filter to show all
        });

        // Initial Run (in case browser caches values)
        filterExperts();
    });
</script>
@endpush