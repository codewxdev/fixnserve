<form id="filter-form" class="space-y-6">
    <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-6 xl:grid-cols-9 items-end">

        <div class="lg:col-span-2 xl:col-span-3">
            <label for="search" class="block text-sm font-medium text-gray-700">Search Name, Email, or Phone</label>
            <div class="mt-1">
                <input type="text" name="search" id="search" placeholder="Enter name, email, or phone number..." class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm p-2.5">
            </div>
        </div>

        <div>
            <label for="category" class="block text-sm font-medium text-gray-700">Expertise Category</label>
            <select id="category" name="category" class="mt-1 block w-full rounded-md border-gray-300 py-2.5 pl-3 pr-10 text-base focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 sm:text-sm">
                <option value="">All Categories</option>
                <option>Lawyer</option>
                <option>Accountant</option>
                <option>Architect</option>
                <option>HR Expert</option>
                </select>
        </div>

        <div>
            <label for="verification" class="block text-sm font-medium text-gray-700">Verification Status</label>
            <select id="verification" name="verification" class="mt-1 block w-full rounded-md border-gray-300 py-2.5 pl-3 pr-10 text-base focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 sm:text-sm">
                <option value="">All</option>
                <option value="verified">Verified</option>
                <option value="pending">Pending KYC</option>
                <option value="rejected">Rejected</option>
            </select>
        </div>

        <div>
            <label for="degree_status" class="block text-sm font-medium text-gray-700"> Degree Validation</label>
            <select id="degree_status" name="degree_status" class="mt-1 block w-full rounded-md border-gray-300 py-2.5 pl-3 pr-10 text-base focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 sm:text-sm">
                <option value="">All</option>
                <option value="validated">Validated</option>
                <option value="pending">Pending Review</option>
                <option value="rejected">Rejected</option>
            </select>
        </div>
        
        <div>
            <label for="availability" class="block text-sm font-medium text-gray-700">Availability Status</label>
            <select id="availability" name="availability" class="mt-1 block w-full rounded-md border-gray-300 py-2.5 pl-3 pr-10 text-base focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 sm:text-sm">
                <option value="">All</option>
                <option value="online">Online</option>
                <option value="offline">Offline</option>
                <option value="busy">Busy</option>
            </select>
        </div>
    </div>

    <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-4 items-end pt-4 border-t border-gray-100">

        <div class="lg:col-span-2">
            <label for="hourly_rate" class="block text-sm font-medium text-gray-700">Hourly Rate Range: $<span id="rate-min">25</span> - $<span id="rate-max">300</span>+</label>
            <div class="mt-3">
                <input type="range" id="rate-slider-min" name="rate_min" min="0" max="500" value="25" class="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer range-sm">
                <input type="range" id="rate-slider-max" name="rate_max" min="0" max="500" value="300" class="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer range-sm mt-1">
            </div>
        </div>

        <div>
            <label for="country" class="block text-sm font-medium text-gray-700">Service Zone</label>
            <select id="country" name="country" class="mt-1 block w-full rounded-md border-gray-300 py-2.5 pl-3 pr-10 text-base focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 sm:text-sm">
                <option value="">All Regions</option>
                <option>USA</option>
                <option>Canada</option>
                <option>UK</option>
                </select>
        </div>

        <div>
            <label for="date_joined" class="block text-sm font-medium text-gray-700">Date Joined (Since)</label>
            <input type="date" name="date_joined" id="date_joined" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm p-2.5">
        </div>
    </div>

    <div class="flex justify-end space-x-3 pt-4 border-t border-gray-100">
        <button type="button" id="reset-filters" class="rounded-md border border-gray-300 bg-white py-2 px-4 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none">
            Reset Filters
        </button>
        <button type="submit" class="rounded-md border border-transparent bg-indigo-600 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none">
            Apply Filters
        </button>
    </div>
</form>