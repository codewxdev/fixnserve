
<div class="flex flex-wrap items-center justify-between gap-4">
    <div class="flex-shrink w-full sm:w-auto">
        <div class="relative">
            <input type="text" placeholder="Search by name, phone, or email..." class="w-full sm:w-80 pl-10 pr-4 py-2.5 border border-gray-300 rounded-xl focus:ring-blue-500 focus:border-blue-500 text-sm transition duration-150" />
            <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
        </div>
    </div>

    <div class="flex flex-wrap items-center gap-3">
        <select class="p-2.5 border border-gray-300 rounded-xl text-sm text-gray-600 focus:ring-blue-500 focus:border-blue-500">
            <option disabled selected>Category</option>
            <option>Electrician</option>
            <option>Plumber</option>
            <option>AC Technician</option>
        </select>
        <select class="p-2.5 border border-gray-300 rounded-xl text-sm text-gray-600 focus:ring-blue-500 focus:border-blue-500">
            <option disabled selected>KYC Status</option>
            <option>Verified</option>
            <option>Pending</option>
            <option>Rejected</option>
        </select>
        <select class="p-2.5 border border-gray-300 rounded-xl text-sm text-gray-600 focus:ring-blue-500 focus:border-blue-500">
            <option disabled selected>Availability</option>
            <option>Online</option>
            <option>Offline</option>
            <option>Busy</option>
        </select>
        <input type="date" class="p-2.5 border border-gray-300 rounded-xl text-sm text-gray-600 focus:ring-blue-500 focus:border-blue-500" placeholder="Date Registered" />
        <button class="flex items-center gap-1 px-4 py-2.5 bg-gray-50 text-gray-600 rounded-xl text-sm font-medium hover:bg-gray-100 transition duration-150 border border-gray-200">
            <i class="fas fa-redo text-xs"></i>
            Reset
        </button>
    </div>
</div>
