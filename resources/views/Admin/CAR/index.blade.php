@extends('layouts.app')

{{-- Assume 'app' layout includes necessary Tailwind CSS and Alpine.js setup --}}
{{-- NOTE: This also assumes Font Awesome is included in your project (e.g., via a CDN or local package). --}}

@section('content')
    {{-- Alpine.js state for tab navigation and the dispute detail panel --}}
    <div id="dispute-management-page" class="space-y-6 p-4 md:p-8 bg-gray-50 min-h-screen" x-data="{ currentView: 'queue', openDisputeId: null }" x-cloak>

        {{-- 1. Header and Global Actions --}}
        <header class="flex flex-col sm:flex-row justify-between items-start sm:items-center pb-4 border-b border-gray-200">
            <div class="mb-4 sm:mb-0">
                <h1 class="text-2xl md:text-3xl font-bold text-gray-900 flex items-center">
                    {{-- Font Awesome Icon: Balance Scale (For Resolution/Justice) --}}
                    <i class="fa-solid fa-scale-balanced fa-xl mr-3 text-yellow-600"></i>
                    Dispute Resolution Center
                </h1>
                <p class="text-xs sm:text-sm text-gray-500 mt-1">Manage complaints, appeals, investigation workflows, and
                    refund decisions.</p>
            </div>
            <div class="flex flex-wrap gap-2">
                <button @click="currentView = 'rules'"
                    :class="{ 'bg-gray-200 text-gray-800 border-gray-400': currentView === 'rules' }"
                    class="flex items-center px-3 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-100 transition duration-150 ease-in-out shadow-sm">
                    {{-- Font Awesome Icon: File Contract (For Rules/Agreements) --}}
                    <i class="fa-solid fa-file-contract w-4 h-4 mr-2"></i>
                    Auto-Refund Rules
                </button>
            </div>
        </header>

        {{-- 2. Dispute Summary Cards (Focus on Speed and Urgency) --}}
        <section class="grid grid-cols-2 md:grid-cols-4 gap-4">
            @php
                // Original icons: folder, upload, clock, alert
                $cards = [
                    [
                        'title' => 'Open Cases',
                        'value' => '45',
                        'icon_fa' => 'fa-folder-open',
                        'color' => 'blue',
                        'trend' => 'Normal',
                    ],
                    [
                        'title' => 'Awaiting Evidence',
                        'value' => '12',
                        'icon_fa' => 'fa-cloud-arrow-up',
                        'color' => 'indigo',
                        'trend' => 'Low Risk',
                    ],
                    [
                        'title' => 'Awaiting Moderation',
                        'value' => '8',
                        'icon_fa' => 'fa-hourglass-half',
                        'color' => 'orange',
                        'trend' => 'Time Critical',
                    ],
                    [
                        'title' => 'Escalated Cases',
                        'value' => '3',
                        'icon_fa' => 'fa-triangle-exclamation',
                        'color' => 'red',
                        'trend' => 'Urgent Action',
                    ],
                ];
            @endphp

            @foreach ($cards as $card)
                <div
                    class="bg-white p-4 rounded-xl shadow-lg hover:shadow-xl transform hover:scale-[1.03] transition duration-300 ease-in-out border border-gray-100 border-l-4 border-{{ $card['color'] }}-500">
                    <p class="text-xs font-medium text-gray-500 truncate">{{ $card['title'] }}</p>
                    <p class="text-2xl font-bold text-gray-900 mt-1">{{ $card['value'] }}</p>
                    <span
                        class="text-[10px] font-semibold text-{{ $card['color'] }}-500 mt-2 block">{{ $card['trend'] }}</span>
                </div>
            @endforeach
        </section>

        <hr class="border-gray-200">

        {{-- 3. Main Content Area: Complaint Queue or Rules --}}
        {{-- 3. Main Content Area: Complaint Queue or Rules (Wrap in Alpine data) --}}
        <div x-data="{
            // Filter State
            searchQuery: '',
            statusFilter: 'All Statuses',
            riskLevelFilter: 'Risk Level',
        
            // Sample Data
            complaints: [
                { id: 4521, orderId: 'ORD-90123', type: 'Item significantly Not as Described', requested: 'Full Refund ($120.00)', status: 'Awaiting Reply', deadline: 'Awaiting Reply', submitted: '3 days ago', risk: 'High', escalated: true, statusColor: 'orange' },
                { id: 4522, orderId: 'SVC-5001', type: 'Rider was 30 mins late', requested: '20% Discount ($15.00)', status: 'Investigating', deadline: 'Tomorrow', submitted: '1 day ago', risk: 'Medium', escalated: false, statusColor: 'blue' },
                { id: 4523, orderId: 'ORD-90124', type: 'Wrong item delivered', requested: 'Replacement', status: 'Submitted', deadline: 'Today', submitted: '1 hour ago', risk: 'Medium', escalated: false, statusColor: 'green' },
                { id: 4524, orderId: 'ORD-90125', type: 'Rider was rude', requested: 'Warning/Action', status: 'Appeal', deadline: 'Pending', submitted: '5 days ago', risk: 'Low', escalated: false, statusColor: 'purple' },
            ],
        
            // Filtering Logic
            filteredComplaints() {
                return this.complaints.filter(complaint => {
                    // 1. Search Filter (ID, Order ID, Type)
                    const searchMatch = this.searchQuery === '' ||
                        complaint.id.toString().includes(this.searchQuery.toLowerCase()) ||
                        complaint.orderId.toLowerCase().includes(this.searchQuery.toLowerCase()) ||
                        complaint.type.toLowerCase().includes(this.searchQuery.toLowerCase());
        
                    // 2. Status Filter
                    const statusMatch = this.statusFilter === 'All Statuses' ||
                        complaint.status === this.statusFilter;
        
                    // 3. Risk Level Filter
                    let riskLevelMatch = true;
                    if (this.riskLevelFilter !== 'Risk Level') {
                        const requiredRisk = this.riskLevelFilter.split(' ')[0]; // Extract 'High', 'Medium'
                        riskLevelMatch = complaint.risk === requiredRisk;
                    }
        
                    return searchMatch && statusMatch && riskLevelMatch;
                });
            },
        
            // Utility for status colors
            getStatusClasses(statusColor) {
                return {
                    'orange': 'font-semibold text-orange-600',
                    'blue': 'font-semibold text-blue-600',
                    'green': 'font-semibold text-green-600',
                    'purple': 'font-semibold text-purple-600',
                } [statusColor] || 'font-semibold text-gray-700';
            },
        
            // Utility for risk/escalation badge colors
            getRiskBadgeColor(risk) {
                return {
                    'High': 'bg-red-100 text-red-800',
                    'Medium': 'bg-yellow-100 text-yellow-800',
                    'Low': 'bg-green-100 text-green-800',
                } [risk];
            },
        }" class="mt-8 bg-white p-4 sm:p-6 rounded-xl shadow-2xl border border-gray-100">

            {{-- Complaint Queue View --}}
            <div x-show="currentView === 'queue'" class="space-y-4">
                <h2 class="text-lg sm:text-xl font-semibold text-gray-800">Active Complaint Queue</h2>

                {{-- Queue Filters (Bound with x-model) --}}
                <div
                    class="grid grid-cols-2 sm:grid-cols-4 lg:grid-cols-8 gap-3 items-center pb-4 border-b border-gray-100">
                    <div class="relative col-span-2">
                        {{-- Search Input (Bound with x-model) --}}
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                            <i class="fa-solid fa-magnifying-glass text-gray-400"></i>
                        </div>
                        <input type="text" placeholder="Search ID, Order, or User..."
                            x-model.debounce.300ms="searchQuery"
                            class="block w-full text-sm pl-10 pr-4 py-2 border-gray-300 rounded-xl focus:ring-yellow-500 focus:border-yellow-500 shadow-sm rounded-xl shadow-black/70" />
                    </div>
                    <select x-model="statusFilter"
                        class="col-span-1 form-select rounded-xl px-2 shadow-black/70 border-gray-300 shadow-sm py-2 text-sm focus:ring-yellow-500 focus:border-yellow-500">
                        <option value="All Statuses">All Statuses</option>
                        <option>Submitted</option>
                        <option>Investigating</option>
                        <option>Appeal</option>
                        <option>Awaiting Reply</option>
                    </select>
                    <select x-model="riskLevelFilter"
                        class="col-span-1 form-select rounded-xl shadow-black/70 border-gray-300 shadow-sm px-2 py-2 text-sm focus:ring-yellow-500 focus:border-yellow-500">
                        <option value="Risk Level">Risk Level</option>
                        <option>High (Urgent)</option>
                        <option>Medium</option>
                        <option>Low</option>
                    </select>

                    {{-- Reset Button --}}
                    <div class="col-span-1 flex justify-end">
                        <button @click="statusFilter = 'All Statuses'; riskLevelFilter = 'Risk Level'; searchQuery = ''"
                            class="w-full px-3 py-2 text-sm font-medium text-gray-600 bg-gray-100 rounded-xl hover:bg-gray-200 transition duration-150 ease-in-out">
                            Reset
                        </button>
                    </div>
                </div>

                {{-- Complaint List Table (Dynamic) --}}
                <div class="overflow-x-auto pt-4">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th
                                    class="px-3 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider min-w-[200px]">
                                    Case ID / Order
                                </th>
                                <th
                                    class="px-3 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider min-w-[300px]">
                                    Complaint Type / Requested
                                </th>
                                <th
                                    class="px-3 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider min-w-[150px]">
                                    Status
                                </th>
                                <th
                                    class="px-3 sm:px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider sticky right-0 bg-gray-50 border-l border-gray-200 min-w-[120px]">
                                    Action
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-100">

                            {{-- Dynamic Complaint Rows --}}
                            <template x-for="complaint in filteredComplaints()" :key="complaint.id">
                                <tr :class="complaint.risk === 'High' ? 'hover:bg-red-50/50' : 'hover:bg-yellow-50/50'"
                                    class="transition duration-150 ease-in-out group">

                                    {{-- COL 1: Dispute Info --}}
                                    <td class="px-3 sm:px-6 py-3 whitespace-nowrap">
                                        <p class="text-sm font-semibold"
                                            :class="complaint.risk === 'High' ? 'text-red-700' : 'text-gray-900'">
                                            <span x-text="`DIS-${complaint.id}`"></span>
                                            <span x-show="complaint.status === 'Awaiting Reply'"
                                                class="text-xs font-normal text-gray-400">(Awaiting Reply)</span>
                                        </p>
                                        <p class="text-xs text-gray-500 mt-1" x-text="`Order: ${complaint.orderId}`"></p>
                                        <span
                                            class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold mt-1"
                                            :class="getRiskBadgeColor(complaint.risk)" x-text="complaint.risk + ' Risk'">
                                        </span>
                                    </td>

                                    {{-- COL 2: Complaint Details --}}
                                    <td class="px-3 sm:px-6 py-3 text-sm text-gray-500">
                                        <p class="font-bold text-gray-700" x-text="complaint.type"></p>
                                        <p class="text-xs text-blue-600 mt-1" x-text="`Requested: ${complaint.requested}`">
                                        </p>
                                        <span x-show="complaint.escalated"
                                            class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold bg-red-100 text-red-800 mt-1">
                                            Escalated
                                        </span>
                                    </td>

                                    {{-- COL 3: Status & Timeline --}}
                                    <td class="px-3 sm:px-6 py-3 text-sm text-gray-500">
                                        <p :class="getStatusClasses(complaint.statusColor)" x-text="complaint.status"></p>
                                        <p class="text-xs text-gray-400 mt-1" x-text="`Submitted: ${complaint.submitted}`">
                                        </p>
                                        <p class="text-xs text-gray-500 mt-1" x-text="`Deadline: ${complaint.deadline}`">
                                        </p>
                                    </td>

                                    {{-- COL 4: Actions (Sticky) --}}
                                    <td class="px-3 sm:px-6 py-3 whitespace-nowrap text-right text-sm font-medium sticky right-0 bg-white border-l border-gray-200"
                                        :class="complaint.risk === 'High' ? 'group-hover:bg-red-50/50' :
                                            'group-hover:bg-yellow-50/50'">
                                        <button @click.stop="openDisputeId = complaint.id"
                                            class="p-2 rounded-full text-white bg-yellow-600 hover:bg-yellow-700 shadow-md transition duration-150 ease-in-out"
                                            title="Investigate Case">
                                            <i class="fa-solid fa-eye w-5 h-5"></i>
                                        </button>
                                    </td>
                                </tr>
                            </template>

                            {{-- No Results Row --}}
                            <tr x-show="filteredComplaints().length === 0">
                                <td colspan="4" class="px-6 py-8 text-center text-gray-500 font-medium">
                                    No complaints match your current filters or search query.
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Auto-Refund Rules View (Unchanged - Static Configuration) --}}
            <div x-show="currentView === 'rules'" class="space-y-6">
                <h2 class="text-xl font-semibold text-gray-800">Automated Refund Rules Configuration</h2>
                <p class="text-gray-600">Configure rules for instant customer resolution and reduce manual moderation. </p>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    {{-- Rule 1 --}}
                    <div class="p-4 bg-green-50 rounded-xl border-l-4 border-green-500 shadow-md">
                        <p class="font-bold text-green-800">Rule #1: Late Service/Rider</p>
                        <p class="text-sm text-gray-700 mt-1">If Rider/Service is **30 minutes or more** late, automatically
                            apply a **20% discount** (max $20) to the customer wallet. Exemptions: Peak Hours.</p>
                        <div class="flex justify-between items-center mt-3">
                            <span class="text-xs text-gray-500">Status: Active</span>
                            <button class="text-sm text-green-600 hover:underline">Edit Rule</button>
                        </div>
                    </div>

                    {{-- Rule 2 --}}
                    <div class="p-4 bg-blue-50 rounded-xl border-l-4 border-blue-500 shadow-md">
                        <p class="font-bold text-blue-800">Rule #2: Out-of-Stock Replacement</p>
                        <p class="text-sm text-gray-700 mt-1">If substituted item is **25% cheaper** than original,
                            automatically refund the **price difference** to customer wallet.</p>
                        <div class="flex justify-between items-center mt-3">
                            <span class="text-xs text-gray-500">Status: Active</span>
                            <button class="text-sm text-blue-600 hover:underline">Edit Rule</button>
                        </div>
                    </div>

                    <button
                        class="col-span-1 md:col-span-2 flex items-center justify-center p-3 text-sm font-medium text-gray-700 bg-gray-100 rounded-xl hover:bg-gray-200 border-dashed border-2 border-gray-300 transition duration-150 ease-in-out">
                        <i class="fa-solid fa-plus w-4 h-4 mr-2"></i>
                        Add New Auto-Refund Rule
                    </button>
                </div>
            </div>
        </div>

        {{-- 4. Dispute Detail Slide-Over Panel (No icons were in this section, only the close button) --}}
        <div x-show="openDisputeId !== null" x-transition:enter="ease-in-out duration-500"
            x-transition:leave="ease-in-out duration-500" class="fixed inset-0 overflow-hidden z-40">

            <div class="absolute inset-0 overflow-hidden">
                {{-- Background overlay --}}
                <div x-show="openDisputeId !== null" @click="openDisputeId = null"
                    class="absolute inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>

                <div class="fixed inset-y-0 right-0 max-w-full flex">
                    {{-- Slide-over panel (Responsive width) --}}
                    <div x-show="openDisputeId !== null"
                        x-transition:enter="transform transition ease-in-out duration-500 sm:duration-700"
                        x-transition:leave="transform transition ease-in-out duration-500 sm:duration-700"
                        class="w-screen max-w-md md:max-w-xl lg:max-w-3xl">

                        <div class="h-full flex flex-col bg-white shadow-xl overflow-y-scroll">
                            <div class="p-4 sm:p-6 bg-yellow-600">
                                {{-- Header and Close Button --}}
                                <div class="flex items-start justify-between">
                                    <h2 id="slide-over-title" class="text-lg sm:text-xl font-bold text-white">
                                        Case Investigation (DIS-<span x-text="openDisputeId"></span>)
                                    </h2>
                                    <button type="button" class="rounded-md text-yellow-200 hover:text-white"
                                        @click="openDisputeId = null">
                                        {{-- Font Awesome Icon: Times/XMark (For Close) --}}
                                        <i class="fa-solid fa-xmark h-6 w-6"></i>
                                    </button>
                                </div>
                                <p class="text-sm text-yellow-200 mt-1">Complaint: Item Not as Described</p>
                            </div>

                            {{-- Tabbed Navigation for Workflow --}}
                            <nav x-data="{ detailTab: 'moderation' }"
                                class="flex space-x-4 px-6 pt-4 border-b border-gray-200 sticky top-0 bg-white z-10 overflow-x-auto">
                                @php
                                    $tabs = ['Moderation', 'Evidence', 'Timeline', 'Final Decision'];
                                @endphp
                                @foreach ($tabs as $tab)
                                    <button @click="detailTab = '{{ strtolower(str_replace(' ', '-', $tab)) }}'"
                                        :class="{ 'border-yellow-500 text-yellow-600': detailTab === '{{ strtolower(str_replace(' ', '-', $tab)) }}', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': detailTab !== '{{ strtolower(str_replace(' ', '-', $tab)) }}' }"
                                        class="whitespace-nowrap pb-3 px-1 border-b-2 text-sm font-medium transition duration-150 ease-in-out">
                                        {{ $tab }}
                                    </button>
                                @endforeach
                            </nav>

                            <div class="p-6 flex-1 overflow-y-auto space-y-6">

                                {{-- Moderation Tab Content --}}
                                <div x-show="detailTab === 'moderation'" class="space-y-4">
                                    <h3 class="font-semibold text-gray-900">Investigation Notes</h3>
                                    <textarea rows="4"
                                        class="w-full rounded-lg border-gray-300 text-sm focus:border-yellow-500 focus:ring-yellow-500"
                                        placeholder="Add your moderation notes here..."></textarea>

                                    <h3 class="font-semibold text-gray-900 mt-4">Provider Reply</h3>
                                    <div class="p-3 bg-gray-50 border border-gray-200 rounded-lg text-sm text-gray-700">
                                        "We acknowledge the complaint. The item was a different color due to a temporary
                                        stock issue. We offered a 10% coupon."
                                    </div>
                                    <button class="text-sm font-medium text-yellow-600 hover:underline mt-2">Request
                                        Clarification</button>
                                </div>

                                {{-- Evidence Tab Content --}}
                                <div x-show="detailTab === 'evidence'" class="space-y-4">
                                    <h3 class="font-semibold text-gray-900">Evidence Uploads</h3>
                                    <div class="space-y-3 p-3 border rounded-lg">
                                        <p class="font-medium text-gray-700">Customer Evidence (3 files)</p>
                                        <ul class="list-disc list-inside text-sm text-blue-600">
                                            <li><a href="#" class="hover:underline">Photo_Damaged_Item.jpg</a></li>
                                            <li><a href="#" class="hover:underline">Chat_Transcript.pdf</a></li>
                                        </ul>
                                    </div>
                                    <div class="space-y-3 p-3 border rounded-lg">
                                        <p class="font-medium text-gray-700">Provider Evidence (1 file)</p>
                                    </div>
                                    <button
                                        class="mt-4 px-3 py-2 text-sm font-medium text-white bg-green-600 rounded-lg hover:bg-green-700">Upload
                                        Moderator Evidence</button>
                                </div>

                                {{-- Timeline Tab Content --}}
                                <div x-show="detailTab === 'timeline'" class="space-y-4">
                                    <h3 class="font-semibold text-gray-900">Case History / Escalation Path</h3>
                                    <ol class="relative border-s border-gray-200 ml-3">
                                        <li class="mb-4 ms-6">
                                            <span
                                                class="absolute flex items-center justify-center w-3 h-3 bg-gray-200 rounded-full -start-1.5 ring-4 ring-white"></span>
                                            <h3 class="mb-1 text-sm font-semibold text-gray-900">Appeal Submitted</h3>
                                            <time class="block mb-2 text-xs font-normal leading-none text-red-600">4 Hours
                                                Ago (Urgent)</time>
                                        </li>
                                        <li class="mb-4 ms-6">
                                            <span
                                                class="absolute flex items-center justify-center w-3 h-3 bg-gray-200 rounded-full -start-1.5 ring-4 ring-white"></span>
                                            <h3 class="mb-1 text-sm font-semibold text-gray-900">Provider Reply Submitted
                                            </h3>
                                            <time class="block mb-2 text-xs font-normal leading-none text-gray-400">1 Day
                                                Ago</time>
                                        </li>
                                    </ol>
                                </div>

                                {{-- Final Decision Tab Content --}}
                                <div x-show="detailTab === 'final-decision'" class="space-y-4">
                                    <h3 class="font-semibold text-gray-900">Final Decision & Refund Workflow</h3>
                                    <label class="block text-sm font-medium text-gray-700">Outcome</label>
                                    <select
                                        class="w-full rounded-lg border-gray-300 text-sm focus:border-yellow-500 focus:ring-yellow-500">
                                        <option>Select Decision...</option>
                                        <option>Full Refund Approved</option>
                                        <option>Partial Refund Approved</option>
                                        <option>Complaint Rejected</option>
                                    </select>

                                    <div class="p-3 bg-red-50 rounded-lg border border-red-200">
                                        <label class="block text-sm font-medium text-gray-700">Refund Amount ($)</label>
                                        <input type="number" placeholder="Enter amount..."
                                            class="w-full rounded-lg border-gray-300 text-sm focus:border-yellow-500 focus:ring-yellow-500 mt-1">
                                    </div>

                                    <button
                                        class="mt-4 w-full py-2 text-white bg-red-600 hover:bg-red-700 rounded-lg font-bold">
                                        Finalize Decision & Process Refund
                                    </button>
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
