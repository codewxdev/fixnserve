@extends('layouts.app')

{{-- Assume 'app' layout includes necessary Tailwind CSS and Alpine.js setup --}}

@section('content')
    {{-- Alpine.js state for managing the slide-over panel --}}
    <div id="service-management-page" class="space-y-6 p-4 md:p-8 bg-gray-50 min-h-screen" x-data="{ openServiceId: null, currentTab: 'pricing' }" x-cloak>

        {{-- 1. Header and Actions --}}
        <header class="flex flex-col sm:flex-row justify-between items-start sm:items-center pb-4 border-b border-gray-200">
            <div class="mb-4 sm:mb-0">
                <h1 class="text-2xl md:text-3xl font-bold text-gray-900 flex items-center">
                    <svg class="w-6 h-6 md:w-8 md:h-8 mr-3 text-cyan-600" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.585.355 1.288.465 1.724.066z">
                        </path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                    Service Catalog Management
                </h1>
                <p class="text-xs sm:text-sm text-gray-500 mt-1">Configure service packs, dynamic pricing, regional rules,
                    and skill mappings.</p>
            </div>
            <div class="flex flex-wrap gap-2">
                <button
                    class="flex items-center px-3 py-2 text-sm font-medium text-white bg-cyan-600 rounded-lg hover:bg-cyan-700 shadow-md transition duration-150 ease-in-out">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    Add New Service Pack
                </button>
                <button
                    class="flex items-center px-3 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition duration-150 ease-in-out shadow-sm">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7">
                        </path>
                    </svg>
                    Manage Categories
                </button>
            </div>
        </header>

        <hr class="border-gray-200">

        {{-- 2. Dashboard Summary Cards (High-Level Metrics) --}}
        <section class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-4 gap-4">
            @php
                $cards = [
                    [
                        'title' => 'Total Service Packs',
                        'value' => '120',
                        'icon' => 'list',
                        'color' => 'cyan',
                        'trend' => '3 Categories',
                    ],
                    [
                        'title' => 'Featured Services',
                        'value' => '15',
                        'icon' => 'star',
                        'color' => 'amber',
                        'trend' => 'High Focus',
                    ],
                    [
                        'title' => 'Regions with Pricing',
                        'value' => '12',
                        'icon' => 'globe',
                        'color' => 'blue',
                        'trend' => 'Coverage',
                    ],
                    [
                        'title' => 'Active Discounts',
                        'value' => '25',
                        'icon' => 'tag',
                        'color' => 'pink',
                        'trend' => '+5 New',
                    ],
                    [
                        'title' => 'Services Mapped',
                        'value' => '98%',
                        'icon' => 'code',
                        'color' => 'teal',
                        'trend' => 'Skills Mapping',
                    ],
                    [
                        'title' => 'Avg Base Price',
                        'value' => '$45.00',
                        'icon' => 'cash',
                        'color' => 'green',
                        'trend' => 'Stable',
                    ],
                    [
                        'title' => 'Highest Demand Cat',
                        'value' => 'Home Repair',
                        'icon' => 'home',
                        'color' => 'indigo',
                        'trend' => 'Top',
                    ],
                    [
                        'title' => 'Pending Review',
                        'value' => '5',
                        'icon' => 'document',
                        'color' => 'red',
                        'trend' => 'Urgent',
                    ],
                ];
            @endphp

            @foreach ($cards as $card)
                <div
                    class="bg-white p-3 sm:p-4 rounded-xl shadow-lg hover:shadow-xl transform hover:scale-[1.03] transition duration-300 ease-in-out border border-gray-100">
                    <div class="flex items-center justify-between">
                        <p class="text-xs font-medium text-gray-500 truncate">{{ $card['title'] }}</p>
                        <span
                            class="text-[10px] font-semibold text-{{ $card['color'] }}-500 hidden sm:block">{{ $card['trend'] }}</span>
                    </div>
                    <div class="flex items-center justify-between mt-1">
                        <p class="text-xl sm:text-xl font-bold text-gray-900">{{ $card['value'] }}</p>
                        {{-- Icon placeholder here --}}
                    </div>
                </div>
            @endforeach
        </section>

        <hr class="border-gray-200">

        {{-- Main Content Area: Filters and Table --}}
        <div x-data="{
            // Filter State
            searchText: '',
            mainCategoryFilter: 'Main Category',
            subCategoryFilter: 'Subcategory',
            pricingEngineFilter: 'Pricing Engine',
        
            // Sample Data (Replace with your server-side data fetch)
            services: [
                { id: 1001, name: 'Standard Sink Drain Cleaning', tag: 'SVC-1001', mainCategory: 'Home Repair', subCategory: 'Plumbing', price: 59.99, pricingEngine: 'Dynamic', regions: 5, skills: 'Level 2 Plumbing', featured: true, discounts: 2, iconColor: 'cyan' },
                { id: 1002, name: 'Advanced Electrical Wiring Check', tag: 'SVC-1002', mainCategory: 'Home Repair', subCategory: 'Electrical', price: 99.00, pricingEngine: 'Fixed', regions: 8, skills: 'Level 3 Electrical', featured: false, discounts: 0, iconColor: 'yellow' },
                { id: 2005, name: 'Deep Carpet Cleaning (3 Rooms)', tag: 'SVC-2005', mainCategory: 'Cleaning', subCategory: 'Carpet', price: 150.00, pricingEngine: 'Fixed', regions: 3, skills: 'Standard Cleaning', featured: true, discounts: 1, iconColor: 'green' },
                { id: 3010, name: 'Basic Lawn Mowing & Trim', tag: 'SVC-3010', mainCategory: 'Landscaping', subCategory: 'Lawn Care', price: 45.50, pricingEngine: 'Dynamic', regions: 12, skills: 'Outdoor Work', featured: false, discounts: 0, iconColor: 'indigo' },
                { id: 1003, name: 'Toilet Flush Mechanism Repair', tag: 'SVC-1003', mainCategory: 'Home Repair', subCategory: 'Plumbing', price: 75.00, pricingEngine: 'Fixed', regions: 5, skills: 'Level 2 Plumbing', featured: false, discounts: 0, iconColor: 'cyan' },
            ],
        
            // Filtering Logic
            filteredServices() {
                return this.services.filter(service => {
                    // 1. Search Filter (Search name, ID, or category/subcategory)
                    const searchMatch = this.searchText === '' ||
                        service.name.toLowerCase().includes(this.searchText.toLowerCase()) ||
                        service.tag.toLowerCase().includes(this.searchText.toLowerCase()) ||
                        service.mainCategory.toLowerCase().includes(this.searchText.toLowerCase()) ||
                        service.subCategory.toLowerCase().includes(this.searchText.toLowerCase());
        
                    // 2. Main Category Filter
                    const mainCategoryMatch = this.mainCategoryFilter === 'Main Category' ||
                        service.mainCategory === this.mainCategoryFilter;
        
                    // 3. Subcategory Filter
                    const subCategoryMatch = this.subCategoryFilter === 'Subcategory' ||
                        service.subCategory === this.subCategoryFilter;
        
                    // 4. Pricing Engine Filter
                    const pricingEngineMatch = this.pricingEngineFilter === 'Pricing Engine' ||
                        service.pricingEngine === this.pricingEngineFilter;
        
                    return searchMatch && mainCategoryMatch && subCategoryMatch && pricingEngineMatch;
                });
            },
        
            // Reset Function
            resetFilters() {
                this.searchText = '';
                this.mainCategoryFilter = 'Main Category';
                this.subCategoryFilter = 'Subcategory';
                this.pricingEngineFilter = 'Pricing Engine';
            },
        
            // Utility for dynamic colors
            getIconClasses(color) {
                return {
                    'cyan': 'bg-cyan-100 text-cyan-700',
                    'yellow': 'bg-yellow-100 text-yellow-700',
                    'green': 'bg-green-100 text-green-700',
                    'indigo': 'bg-indigo-100 text-indigo-700',
                } [color] || 'bg-gray-100 text-gray-700';
            },
        
            // Utility to get unique filter options dynamically from data (Best practice)
            getUniqueOptions(key) {
                const options = [...new Set(this.services.map(service => service[key]))];
                return options.sort();
            }
        }" class="mt-8 bg-white p-4 sm:p-6 rounded-xl shadow-2xl border border-gray-100">

            {{-- 5. Filters / Search Bar (Responsive) --}}
            <div
                class="sticky top-0 z-10 bg-white pt-1 pb-4 -mx-4 sm:-mx-6 px-4 sm:px-6 border-b border-gray-100 shadow-sm rounded-t-xl">
                <h2 class="text-lg sm:text-xl font-semibold text-gray-800 mb-4">Service Pack Directory</h2>
                <div class="grid grid-cols-2 sm:grid-cols-4 lg:grid-cols-10 gap-3 items-center">

                    <div class="col-span-2 lg:col-span-3 shadow-sm rounded-xl shadow-black/70 relative">
                        {{-- Search Input (Bind with x-model) --}}
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                            <i class="fa-solid fa-magnifying-glass text-gray-400"></i>
                        </div>
                        <input type="text" placeholder="Search service name, category, or ID..."
                            x-model.debounce.300ms="searchText"
                            class="block w-full text-sm pl-10 pr-4 py-2 border-gray-300 rounded-xl focus:ring-cyan-500 focus:border-cyan-500 shadow-sm" />
                    </div>

                    {{-- Filters (Bind with x-model and populate with x-for) --}}
                    <select x-model="mainCategoryFilter"
                        class="col-span-2 form-select rounded-xl shadow-sm shadow-black/70 border-gray-300 py-2 px-3 text-sm focus:ring-cyan-500 focus:border-cyan-500">
                        <option disabled value="Main Category">Main Category</option>
                        <template x-for="option in getUniqueOptions('mainCategory')" :key="option">
                            <option x-text="option"></option>
                        </template>
                    </select>
                    <select x-model="subCategoryFilter"
                        class="col-span-2 form-select rounded-xl shadow-sm shadow-black/70 border-gray-300 py-2 px-3 text-sm focus:ring-cyan-500 focus:border-cyan-500">
                        <option disabled value="Subcategory">Subcategory</option>
                        <template x-for="option in getUniqueOptions('subCategory')" :key="option">
                            <option x-text="option"></option>
                        </template>
                    </select>
                    <select x-model="pricingEngineFilter"
                        class="col-span-2 form-select rounded-xl shadow-sm shadow-black/70 border-gray-300 py-2 px-3 text-sm focus:ring-cyan-500 focus:border-cyan-500">
                        <option disabled value="Pricing Engine">Pricing Engine</option>
                        <template x-for="option in getUniqueOptions('pricingEngine')" :key="option">
                            <option x-text="option"></option>
                        </template>
                    </select>

                    {{-- Reset Button --}}
                    <div class="col-span-2 sm:col-span-1 flex justify-end">
                        <button @click="resetFilters"
                            class="w-full px-3 py-2 text-sm font-medium text-gray-600 bg-gray-100 rounded-xl hover:bg-gray-200 transition duration-150 ease-in-out">
                            Reset
                        </button>
                    </div>
                </div>
            </div>

            {{-- 3. Service List Table (Dynamic) --}}
            <div class="overflow-x-auto mt-4">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th
                                class="px-3 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider min-w-[280px]">
                                Service Pack / Category
                            </th>
                            <th
                                class="px-3 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider min-w-[300px]">
                                Base Pricing & Regionals
                            </th>
                            <th
                                class="px-3 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider min-w-[200px]">
                                Skills Mapping / Discounts
                            </th>
                            <th
                                class="px-3 sm:px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider sticky right-0 bg-gray-50 border-l border-gray-200 min-w-[150px]">
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-100">

                        <template x-for="service in filteredServices()" :key="service.id">
                            <tr class="hover:bg-cyan-50/50 transition duration-150 ease-in-out group">

                                {{-- COL 1: Service Info / Category --}}
                                <td class="px-3 sm:px-6 py-3 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <span
                                            class="h-10 w-10 rounded-full flex items-center justify-center font-bold text-sm mr-3 flex-shrink-0"
                                            :class="getIconClasses(service.iconColor)"
                                            x-text="service.mainCategory.substring(0, 2).toUpperCase()">
                                        </span>
                                        <div>
                                            <div class="text-sm font-semibold text-gray-900 group-hover:text-cyan-600 truncate"
                                                x-text="service.name">
                                            </div>
                                            <div class="flex items-center text-xs space-x-2 mt-1">
                                                {{-- Main Category Detail --}}
                                                <span
                                                    class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800"
                                                    x-text="service.mainCategory">
                                                </span>
                                                {{-- Subcategory --}}
                                                <span class="text-gray-500" x-text="`| ${service.subCategory}`"></span>
                                            </div>
                                            <p class="text-xs text-gray-400 mt-1" x-text="`Service ID: ${service.tag}`"></p>
                                        </div>
                                    </div>
                                </td>

                                {{-- COL 2: Pricing & Regionals --}}
                                <td class="px-3 sm:px-6 py-3 text-sm text-gray-500">
                                    <p class="text-xs font-medium text-gray-400 uppercase">Base Price / Engine</p>
                                    <p class="font-extrabold text-lg text-green-700"
                                        x-text="`$${service.price.toFixed(2)}`">
                                    </p>
                                    <div class="flex items-center text-xs text-gray-600 mt-1">
                                        <span
                                            class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold"
                                            :class="service.pricingEngine === 'Dynamic' ? 'bg-blue-100 text-blue-800' :
                                                'bg-gray-100 text-gray-800'"
                                            x-text="service.pricingEngine + ' Pricing'">
                                        </span>
                                    </div>
                                    <p class="text-xs text-gray-400 mt-1" x-text="`Active in ${service.regions} Regions`">
                                    </p>
                                </td>

                                {{-- COL 3: Skills & Discounts --}}
                                <td class="px-3 sm:px-6 py-3 text-sm text-gray-500">
                                    <p class="text-xs font-medium text-gray-400 uppercase">Required Skills / Features</p>
                                    <p class="font-bold text-gray-700 text-sm" x-text="service.skills"></p>
                                    <div class="flex items-center text-xs text-gray-600 mt-1">
                                        <span x-show="service.featured"
                                            class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-amber-100 text-amber-800">
                                            Featured Service
                                        </span>
                                    </div>
                                    <p class="text-xs text-pink-600 mt-1"
                                        x-text="`${service.discounts} Active Discount(s)`">
                                    </p>
                                </td>

                                {{-- COL 4: Actions (Sticky) --}}
                                <td
                                    class="px-3 sm:px-6 py-3 whitespace-nowrap text-right text-sm font-medium sticky right-0 bg-white border-l border-gray-200 group-hover:bg-cyan-50/50">
                                    <div class="flex justify-end space-x-2">
                                        {{-- View Details (Primary Action) --}}
                                        <button @click.stop="openServiceId = service.id; currentTab = 'pricing'"
                                            class="p-2 rounded-full text-white bg-cyan-600 hover:bg-cyan-700 shadow-md transition duration-150 ease-in-out"
                                            title="Configure Service">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.585.355 1.288.465 1.724.066z">
                                                </path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            </svg>
                                        </button>
                                        {{-- Toggle Featured (Dynamic Icon Color/Title) --}}
                                        <button
                                            :class="service.featured ? 'text-amber-500 hover:bg-amber-50' :
                                                'text-gray-400 hover:bg-gray-100'"
                                            class="p-2 rounded-full transition duration-150 ease-in-out hidden sm:block"
                                            title="Toggle Featured">
                                            <svg class="w-5 h-5" :fill="service.featured ? 'currentColor' : 'none'"
                                                :stroke="service.featured ? 'none' : 'currentColor'" viewBox="0 0 20 20"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.012 8.73c-.783-.57-.381-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                                                </path>
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        </template>

                        <tr x-show="filteredServices().length === 0">
                            <td colspan="4" class="px-6 py-8 text-center text-gray-500 font-medium">
                                No service packs match your current filters or search query.
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        {{-- 4. Service Details Slide-Over Panel (Configuration Hub) --}}
        <div x-show="openServiceId !== null" x-transition:enter="ease-in-out duration-500"
            x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
            x-transition:leave="ease-in-out duration-500" x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0" class="fixed inset-0 overflow-hidden z-40">

            <div class="absolute inset-0 overflow-hidden">
                <div x-show="openServiceId !== null" @click="openServiceId = null"
                    class="absolute inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>

                <div class="fixed inset-y-0 right-0 max-w-full flex">
                    <div x-show="openServiceId !== null"
                        x-transition:enter="transform transition ease-in-out duration-500 sm:duration-700"
                        x-transition:enter-start="translate-x-full" x-transition:enter-end="translate-x-0"
                        x-transition:leave="transform transition ease-in-out duration-500 sm:duration-700"
                        x-transition:leave-start="translate-x-0" x-transition:leave-end="translate-x-full"
                        class="w-screen max-w-md md:max-w-xl lg:max-w-3xl">

                        <div class="h-full flex flex-col bg-white shadow-xl overflow-y-scroll">
                            <div class="p-4 sm:p-6 bg-cyan-600">
                                {{-- Header and Close Button --}}
                                <div class="flex items-start justify-between">
                                    <h2 id="slide-over-title" class="text-lg sm:text-xl font-bold text-white">
                                        Service Configuration (ID: <span x-text="openServiceId"></span>)
                                    </h2>
                                    <button type="button" class="rounded-md text-cyan-200 hover:text-white"
                                        @click="openServiceId = null">
                                        <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </button>
                                </div>
                                <p class="text-sm text-cyan-200 mt-1">Sink Drain Cleaning (Plumbing)</p>
                            </div>

                            {{-- Tabbed Navigation for Configuration --}}
                            <nav
                                class="flex space-x-4 px-6 pt-4 border-b border-gray-200 sticky top-0 bg-white z-10 overflow-x-auto">
                                @php
                                    $tabs = ['Pricing Engine', 'Regionals', 'Skills Mapping', 'Discounts', 'Featured'];
                                @endphp
                                @foreach ($tabs as $tab)
                                    <button @click="currentTab = '{{ strtolower(str_replace(' ', '-', $tab)) }}'"
                                        :class="{ 'border-cyan-500 text-cyan-600': currentTab === '{{ strtolower(str_replace(' ', '-', $tab)) }}', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': currentTab !== '{{ strtolower(str_replace(' ', '-', $tab)) }}' }"
                                        class="whitespace-nowrap pb-3 px-1 border-b-2 text-sm font-medium transition duration-150 ease-in-out">
                                        {{ $tab }}
                                    </button>
                                @endforeach
                            </nav>

                            <div class="p-6 flex-1 overflow-y-auto space-y-8">

                                {{-- Pricing Engine Tab Content --}}
                                <div x-show="currentTab === 'pricing-engine'">
                                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Base Pricing & Dynamic Rules</h3>
                                    <div class="bg-gray-50 p-4 rounded-xl space-y-3 border">
                                        <div class="flex items-center justify-between">
                                            <label class="font-medium text-gray-700">Base Price ($)</label>
                                            <input type="number" value="59.99"
                                                class="w-24 text-right rounded-lg border-gray-300 text-sm focus:border-cyan-500 focus:ring-cyan-500">
                                        </div>
                                        <div class="flex items-center justify-between border-t pt-3">
                                            <p class="font-medium text-gray-700">Pricing Model</p>
                                            <select
                                                class="rounded-lg border-gray-300 text-sm focus:border-cyan-500 focus:ring-cyan-500">
                                                <option>Dynamic (Surge/Demand)</option>
                                                <option>Fixed Price</option>
                                            </select>
                                        </div>
                                        <div class="pt-2 text-sm text-gray-500">
                                            <p>Current Dynamic Multiplier: **1.2x** (Based on 10 active requests)</p>
                                        </div>
                                    </div>
                                </div>

                                {{-- Regionals Tab Content --}}
                                <div x-show="currentTab === 'regionals'">
                                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Region-Based Pricing Overrides
                                    </h3>
                                    <div class="space-y-3">
                                        <div
                                            class="bg-blue-50 p-3 rounded-lg flex justify-between items-center border border-blue-200">
                                            <p class="font-medium text-blue-700">Region: Metropolitan Area 1</p>
                                            <span class="text-lg font-bold text-blue-700">+ $5.00 Surcharge</span>
                                        </div>
                                        <div
                                            class="bg-green-50 p-3 rounded-lg flex justify-between items-center border border-green-200">
                                            <p class="font-medium text-green-700">Region: Rural Zone C</p>
                                            <span class="text-lg font-bold text-green-700">Default Base Price</span>
                                        </div>
                                        <button
                                            class="text-sm font-medium text-cyan-600 hover:text-cyan-800 flex items-center mt-3">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                            </svg>
                                            Add New Regional Rule
                                        </button>
                                    </div>
                                </div>

                                {{-- Skills Mapping Tab Content --}}
                                <div x-show="currentTab === 'skills-mapping'">
                                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Required Skills and Qualifications
                                    </h3>
                                    <div class="bg-gray-50 p-4 rounded-xl space-y-3 border">
                                        <label class="font-medium text-gray-700">Minimum Skill Level Required</label>
                                        <select
                                            class="w-full rounded-lg border-gray-300 text-sm focus:border-cyan-500 focus:ring-cyan-500">
                                            <option>Plumbing Level 2 (Certified)</option>
                                            <option>Plumbing Level 1 (Trained)</option>
                                        </select>
                                        <div class="pt-2">
                                            <p class="text-sm text-gray-500">Maps service to only eligible vendors/riders.
                                            </p>
                                            <button class="text-xs text-cyan-600 hover:underline mt-1">Manage Skill
                                                Definitions</button>
                                        </div>
                                    </div>
                                </div>

                                {{-- Discounts Tab Content --}}
                                <div x-show="currentTab === 'discounts'">
                                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Active Service Discounts</h3>
                                    <div class="space-y-3">
                                        <div
                                            class="bg-pink-50 p-3 rounded-lg flex justify-between items-center border border-pink-200">
                                            <p class="font-medium text-pink-700">Spring Cleaning Discount</p>
                                            <span class="text-lg font-bold text-pink-700">20% OFF</span>
                                        </div>
                                        <div
                                            class="bg-pink-50 p-3 rounded-lg flex justify-between items-center border border-pink-200">
                                            <p class="font-medium text-pink-700">First-Time User Promo</p>
                                            <span class="text-lg font-bold text-pink-700">$10 Fixed</span>
                                        </div>
                                        <button
                                            class="text-sm font-medium text-cyan-600 hover:text-cyan-800 flex items-center mt-3">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                            </svg>
                                            Create Service-Specific Discount
                                        </button>
                                    </div>
                                </div>

                                {{-- Featured Tab Content --}}
                                <div x-show="currentTab === 'featured'">
                                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Promotion & Visibility</h3>
                                    <div
                                        class="bg-amber-50 p-4 rounded-xl flex justify-between items-center border border-amber-200">
                                        <p class="font-medium text-amber-700">Feature this Service on Homepage Banners?</p>
                                        <label class="relative inline-flex items-center cursor-pointer">
                                            <input type="checkbox" value="" class="sr-only peer" checked>
                                            <div
                                                class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-amber-300 rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-amber-600">
                                            </div>
                                        </label>
                                    </div>
                                    <div class="mt-4">
                                        <label class="font-medium text-gray-700 block mb-2">Service SEO Tagline</label>
                                        <textarea rows="3" class="w-full rounded-lg border-gray-300 text-sm focus:border-cyan-500 focus:ring-cyan-500"
                                            placeholder="e.g., Fast, reliable sink cleaning in under an hour."></textarea>
                                    </div>
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
        .shadow-lg {
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        }

        .shadow-2xl {
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
        }

        [x-cloak] {
            display: none !important;
        }
    </style>
@endpush
