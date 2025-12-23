@extends('layouts.app')

@section('content')
    <div class="px-6 py-8 md:px-10 lg:px-12">
        <h1 class="text-3xl font-bold  text-gray-900 mb-8">
            Professional Experts Management
        </h1>

        <div id="analytics-summary" class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4 xl:grid-cols-7 mb-8 sticky top-0 z-10 bg-gray-50 pt-2 pb-4 -mx-6 md:-mx-10 lg:-mx-12 px-6 md:px-10 lg:px-12 shadow-sm">
            {{-- @include('experts.partials.analytics-cards') --}}
            <x-partials.experts.analytics-cards/>
        </div>

        <div id="filter-panel" class="bg-white p-6 rounded-xl shadow-lg mb-8 sticky top-4 z-20">
            {{-- @include('experts.partials.filter-panel') --}}
            <x-partials.experts.filter-panel />
        
        </div>

        <div class="bg-white p-6 rounded-xl shadow-lg">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">All Experts</h2>
            <div class="overflow-x-auto">
                {{-- @include('experts.partials.experts-table') --}}
                <x-partials.experts.experts-table/>
            </div>
        </div>
    </div>

    {{-- @include('experts.partials.expert-details-slideover') --}}
    <x-partials.experts.expert-details-slideover/>

@endsection

@push('styles')
    <style>
        /* Custom scrollbar for a more professional look */
        .overflow-y-auto::-webkit-scrollbar {
            width: 8px;
        }

        .overflow-y-auto::-webkit-scrollbar-thumb {
            background-color: #d1d5db; /* gray-300 */
            border-radius: 4px;
        }
    </style>
@endpush

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Placeholder JS for demonstration. In a real app, this would use Alpine.js/Vue.js.

            // Slide-Over behavior
            window.openExpertDetails = function(expertId) {
                document.getElementById('expert-details-slideover').classList.remove('hidden');
                document.getElementById('slideover-backdrop').classList.remove('hidden');
                document.getElementById('slideover-panel').classList.remove('translate-x-full');
                // In a real app, fetch expert data here and populate the panel.
                console.log('Opening details for Expert ID:', expertId);
            };

            window.closeExpertDetails = function() {
                document.getElementById('slideover-panel').classList.add('translate-x-full');
                setTimeout(() => {
                    document.getElementById('expert-details-slideover').classList.add('hidden');
                    document.getElementById('slideover-backdrop').classList.add('hidden');
                }, 300); // Wait for transition
            };
        });

        // Filter behavior placeholder (e.g., AJAX submission or state management)
        document.getElementById('reset-filters').addEventListener('click', function() {
            document.getElementById('filter-form').reset();
            // Trigger filter update logic
        });
    </script>
@endpush