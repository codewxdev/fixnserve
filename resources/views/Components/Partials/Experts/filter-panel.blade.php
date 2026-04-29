<div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5 transition-all duration-300">
    <form id="filter-form">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-4 items-center">
            
            <div class="lg:col-span-5 relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </div>
                <input type="text" id="filter-search" class="block w-full pl-10 pr-3 py-2.5 border border-gray-200 rounded-lg leading-5 bg-gray-50 placeholder-gray-400 focus:outline-none focus:bg-white focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm transition duration-150 ease-in-out" placeholder="Search by name or ID...">
            </div>

            <div class="lg:col-span-2">
                <select id="filter-category" class="block w-full py-2.5 pl-3 pr-10 border border-gray-200 bg-white rounded-lg text-gray-600 sm:text-sm focus:ring-indigo-500 focus:border-indigo-500">
                    <option value="">All Categories</option>
                    <option value="legal">Legal</option>
                    <option value="finance">Finance</option>
                    <option value="architecture">Architecture</option>
                    <option value="technology">Technology</option>
                </select>
            </div>

            <div class="lg:col-span-2">
                <select id="filter-region" class="block w-full py-2.5 pl-3 pr-10 border border-gray-200 bg-white rounded-lg text-gray-600 sm:text-sm focus:ring-indigo-500 focus:border-indigo-500">
                    <option value="">All Regions</option>
                    <option value="north america">North America</option>
                    <option value="europe">Europe</option>
                    <option value="asia">Asia Pacific</option>
                </select>
            </div>

            <div class="lg:col-span-3 flex justify-end gap-2">
                <button type="button" id="reset-filters" class="px-4 py-2 border border-gray-200 rounded-lg text-sm font-medium text-gray-600 hover:bg-gray-50 transition">
                    Reset
                </button>
                <button type="button" id="apply-filters" class="px-4 py-2 bg-indigo-600 border border-transparent rounded-lg text-sm font-medium text-white hover:bg-indigo-700 shadow-sm transition">
                    Apply Filters
                </button>
            </div>
        </div>

        <div class="mt-4 pt-4 border-t border-gray-100 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            
            <div>
                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-2">Availability</label>
                <div class="flex gap-2">
                    <label class="cursor-pointer">
                        <input type="radio" name="status" value="all" class="peer sr-only status-radio" checked>
                        <span class="px-3 py-1.5 rounded-full text-xs font-medium bg-gray-100 text-gray-600 peer-checked:bg-indigo-100 peer-checked:text-indigo-700 transition">All</span>
                    </label>
                    <label class="cursor-pointer">
                        <input type="radio" name="status" value="online" class="peer sr-only status-radio">
                        <span class="px-3 py-1.5 rounded-full text-xs font-medium bg-gray-100 text-gray-600 peer-checked:bg-green-100 peer-checked:text-green-700 transition">Online</span>
                    </label>
                    <label class="cursor-pointer">
                        <input type="radio" name="status" value="offline" class="peer sr-only status-radio">
                        <span class="px-3 py-1.5 rounded-full text-xs font-medium bg-gray-100 text-gray-600 peer-checked:bg-gray-200 peer-checked:text-gray-800 transition">Offline</span>
                    </label>
                </div>
            </div>

            <div>
                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-2">Verification</label>
                <select id="filter-kyc" class="block w-full py-1.5 border-none bg-gray-50 rounded text-sm text-gray-600 focus:ring-0">
                    <option value="">Any Status</option>
                    <option value="verified">Verified Only</option>
                    <option value="pending">Pending KYC</option>
                    <option value="rejected">Rejected</option>
                </select>
            </div>

            <div class="lg:col-span-2">
                <div class="flex justify-between items-center mb-1">
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide">Max Hourly Rate</label>
                    <span class="text-xs text-indigo-600 font-bold">$<span id="rate-display">300</span>/hr</span>
                </div>
                <input type="range" id="filter-rate" min="25" max="300" value="300" class="w-full h-1 bg-gray-200 rounded-lg appearance-none cursor-pointer">
            </div>
        </div>
    </form>
</div>