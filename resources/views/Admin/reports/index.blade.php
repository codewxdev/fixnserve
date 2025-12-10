@extends('layouts.app')

{{-- Assume 'app' layout includes necessary Tailwind CSS and Alpine.js setup --}}

@section('content')

{{-- Alpine.js state for managing report selection and filtering --}}
<div id="analytics-page" 
     class="space-y-8 p-4 md:p-8 bg-gray-50 min-h-screen" 
     x-data="{ activeReport: 'revenue', showFilter: false }" 
     x-cloak>
    
    {{-- 1. Header and Global Controls --}}
    <header class="flex flex-col sm:flex-row justify-between items-start sm:items-center pb-4 border-b border-gray-200">
        <div class="mb-4 sm:mb-0">
            <h1 class="text-2xl md:text-3xl font-bold text-gray-900 flex items-center">
                <svg class="w-6 h-6 md:w-8 md:h-8 mr-3 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1110.945 20.945M11 3.055a9.001 9.001 0 109.945 9.945"></path></svg>
                Reports & Analytics
            </h1>
            <p class="text-xs sm:text-sm text-gray-500 mt-1">Generate key reports and visualize platform performance metrics.</p>
        </div>
        <div class="flex flex-wrap gap-2"> 
            <button @click="showFilter = !showFilter" class="flex items-center px-3 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-100 transition duration-150 ease-in-out shadow-sm">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path></svg>
                Advanced Filters
            </button>
            <button class="flex items-center px-3 py-2 text-sm font-medium text-white bg-green-600 rounded-lg hover:bg-green-700 shadow-md transition duration-150 ease-in-out">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                Export Report
            </button>
        </div>
    </header>

    {{-- Global Filter Panel (Collapsible) --}}
    <div x-show="showFilter" x-collapse.duration.500ms class="p-4 bg-white rounded-xl shadow border border-gray-200">
        <h3 class="text-md font-semibold text-gray-800 mb-3">Report Scope</h3>
        <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4">
            <select class="form-select rounded-lg text-sm border-gray-300 shadow-sm">
                <option>Date Range: Last 30 Days</option>
                <option>Last 7 Days</option>
                <option>Last Quarter</option>
            </select>
            <select class="form-select rounded-lg text-sm border-gray-300 shadow-sm">
                <option>Region: All Regions</option>
                <option>UAE</option>
                <option>KSA</option>
            </select>
             <select class="form-select rounded-lg text-sm border-gray-300 shadow-sm">
                <option>Service Category: All</option>
                <option>Groceries</option>
                <option>Home Repair</option>
            </select>
        </div>
    </div>

    {{-- 2. Report Navigation Sidebar (Desktop) / Dropdown (Mobile) --}}
    <div class="lg:grid lg:grid-cols-12 lg:gap-8">
        
        {{-- Sidebar (Desktop) --}}
        <nav class="hidden lg:block lg:col-span-3 space-y-2">
            <h3 class="text-sm font-bold text-gray-700 uppercase mb-3">Core Reports</h3>
            @php
                $reports = [
                    'revenue' => 'Revenue & Financial Summary',
                    'provider' => 'Provider Performance',
                    'rider' => 'Rider Performance',
                    'category' => 'Category Performance',
                    'heatmap' => 'Region Heat Map',
                ];
            @endphp

            @foreach($reports as $key => $label)
                <button @click="activeReport = '{{ $key }}'"
                        :class="{'bg-indigo-600 text-white shadow-lg': activeReport === '{{ $key }}', 'bg-white text-gray-700 hover:bg-gray-100': activeReport !== '{{ $key }}'}"
                        class="w-full text-left px-4 py-3 rounded-xl text-sm font-medium transition duration-150 ease-in-out">
                    {{ $label }}
                </button>
            @endforeach
        </nav>

        {{-- Dropdown (Mobile) --}}
        <div class="lg:hidden mb-4">
            <select @change="activeReport = $event.target.value" class="block w-full rounded-xl border-gray-300 text-sm shadow-md focus:ring-indigo-500 focus:border-indigo-500">
                @foreach($reports as $key => $label)
                    <option value="{{ $key }}" :selected="activeReport === '{{ $key }}'">{{ $label }}</option>
                @endforeach
            </select>
        </div>
        
        {{-- 3. Main Report View (Dynamic Content) --}}
        <main class="lg:col-span-9">
            
            {{-- Revenue Report View --}}
            <div x-show="activeReport === 'revenue'" class="space-y-6">
                <h2 class="text-2xl font-bold text-indigo-700">Revenue Report: Last 30 Days</h2>
                <p class="text-gray-500 text-sm">Detailed breakdown of gross merchandise value (GMV), net revenue, commissions, and refunds.</p>

                {{-- Key Financial Metrics (4 Cards) --}}
                <div class="grid grid-cols-2 lg:grid-cols-4 gap-6">
                    @php
                        $rev_metrics = [
                            ['label' => 'Gross Merchandise Value (GMV)', 'value' => '$4.2M', 'change' => '+12.5%'],
                            ['label' => 'Net Platform Revenue', 'value' => '$580K', 'change' => '+18.0%'],
                            ['label' => 'Commission Earned', 'value' => '$450K', 'change' => '+15.2%'],
                            ['label' => 'Refunds Processed', 'value' => '$15K', 'change' => '-5.1%', 'color' => 'red'],
                        ];
                    @endphp
                    @foreach($rev_metrics as $metric)
                        <div class="bg-white p-5 rounded-xl shadow-lg border border-gray-100">
                            <p class="text-sm font-medium text-gray-500 truncate">{{ $metric['label'] }}</p>
                            <p class="text-3xl font-bold text-gray-900 mt-1">{{ $metric['value'] }}</p>
                            <div class="flex items-center mt-2 text-xs font-semibold text-{{ $metric['color'] ?? 'green' }}-600">
                                {{ $metric['change'] }} vs Prior Period
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- Main Visualization (Placeholder for a Line Chart) --}}
                <div class="bg-gray-800 p-6 rounded-xl shadow-2xl text-white h-96 flex items-center justify-center">
                    <p class="text-lg opacity-70">[Line Chart Placeholder: Daily GMV vs Net Revenue]</p>
                </div>

                {{-- Commission Breakdown Table --}}
                <h3 class="text-xl font-semibold text-gray-800 mt-6">Commission Breakdown by Service Type</h3>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 bg-white rounded-xl shadow">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Service</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">GMV Share</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total Commission</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">Groceries Delivery</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">45%</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-indigo-700">$202,500</td>
                            </tr>
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">Home Repair Services</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">30%</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-indigo-700">$135,000</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            
            {{-- Provider Performance View --}}
            <div x-show="activeReport === 'provider'" class="space-y-6">
                <h2 class="text-2xl font-bold text-indigo-700">Provider Performance Report</h2>
                 <div class="bg-gray-800 p-6 rounded-xl shadow-2xl text-white h-96 flex items-center justify-center">
                    <p class="text-lg opacity-70">[Bar Chart Placeholder: Top 10 Providers by GMV / Average Rating]</p>
                </div>
                <h3 class="text-xl font-semibold text-gray-800 mt-6">Low Performing Providers (Action Required)</h3>
                <p class="text-sm text-gray-500">Providers with low ratings (below 4.0) or high cancellation rates (above 10%).</p>
                {{-- Table Placeholder --}}
            </div>

            {{-- Rider Performance View --}}
            <div x-show="activeReport === 'rider'" class="space-y-6">
                <h2 class="text-2xl font-bold text-indigo-700">Rider Performance Report</h2>
                 <div class="bg-gray-800 p-6 rounded-xl shadow-2xl text-white h-96 flex items-center justify-center">
                    <p class="text-lg opacity-70">[Scatter Plot Placeholder: Efficiency (Time) vs. Customer Ratings]</p>
                </div>
                <h3 class="text-xl font-semibold text-gray-800 mt-6">Rider Efficiency Leaderboard</h3>
                <p class="text-sm text-gray-500">Top 5 Riders by average delivery time and successful assignments.</p>
                {{-- Table Placeholder --}}
            </div>
            
            {{-- Category Performance View --}}
            <div x-show="activeReport === 'category'" class="space-y-6">
                <h2 class="text-2xl font-bold text-indigo-700">Category Performance Report</h2>
                <div class="bg-gray-800 p-6 rounded-xl shadow-2xl text-white h-96 flex items-center justify-center">
                    <p class="text-lg opacity-70">[Pie Chart Placeholder: GMV Share by Service Category]</p>
                </div>
                <h3 class="text-xl font-semibold text-gray-800 mt-6">Growth Rate by Subcategory</h3>
                <p class="text-sm text-gray-500">Identify fast-growing or stagnant subcategories for strategic investment.</p>
                {{-- Table Placeholder --}}
            </div>

            {{-- Region Heat Map View --}}
            <div x-show="activeReport === 'heatmap'" class="space-y-6">
                <h2 class="text-2xl font-bold text-indigo-700">Region Heat Map Analysis</h2>
                 <p class="text-gray-500 text-sm">Visualization of demand concentration and service provider density across active regions.</p>
                <div class="bg-gray-800 p-6 rounded-xl shadow-2xl text-white h-[600px] flex items-center justify-center">
                    <p class="text-lg opacity-70">[Interactive Map Placeholder: Demand Heatmap and Supply Pinpoints]</p>
                </div>
            </div>

        </main>
    </div>

</div>

@endsection

@push('styles')
    <style>
        .shadow-lg { box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05); }
        .shadow-2xl { box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25); }
        [x-cloak] { display: none !important; }
    </style>
@endpush