<!-- <div class="bg-white border border-gray-100 rounded-xl shadow-sm mt-8 overflow-hidden"> -->
    <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
        <h2 class="text-lg font-semibold text-gray-800">Expert Registry</h2>
        <span id="result-count" class="text-xs font-medium text-gray-500 bg-white border border-gray-200 px-2 py-1 rounded">Total: 3</span>
    </div>
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Expert Profile</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Category & Rate</th>
                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Compliance</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Performance</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody id="experts-table-body" class="bg-white divide-y divide-gray-200">

                <tr class="expert-row hover:bg-gray-50 transition duration-150"
                    data-name="amelia reed"
                    data-id="exp-001"
                    data-category="legal"
                    data-rate="180"
                    data-status="online"
                    data-kyc="verified"
                    data-region="north america">

                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <div class="h-10 w-10 flex-shrink-0">
                                <img class="h-10 w-10 rounded-full object-cover"
                                    src="https://ui-avatars.com/api/?name=Amelia+Reed&background=0D8ABC&color=fff"
                                    alt="Amelia Reed">
                            </div>
                            <div class="ml-4">
                                <div class="text-sm font-medium text-gray-900">Amelia Reed</div>
                                <div class="text-xs text-gray-500">ID: EXP-001</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900">Legal Consultant</div>
                        <div class="text-xs text-gray-500">$180/hr</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-center">
                        <span class="inline-flex items-center rounded-full bg-green-50 px-2 py-1 text-xs font-medium text-green-700 ring-1 ring-inset ring-green-600/20">Online</span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex flex-col gap-1">
                            <span class="inline-flex items-center gap-1 text-xs text-gray-600">
                                <svg class="w-3 h-3 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                </svg>
                                Identity Verified
                            </span>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm text-gray-500">
                        <span class="font-bold text-gray-900">4.9 ★</span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                        <button onclick="openExpertDetails('1')" class="text-indigo-600 hover:text-indigo-900 bg-indigo-50 hover:bg-indigo-100 px-3 py-1.5 rounded-md transition-colors">Details</button>
                    </td>
                </tr>

                <tr class="expert-row hover:bg-gray-50 transition duration-150"
                    data-name="marcus cole"
                    data-id="exp-002"
                    data-category="architecture"
                    data-rate="250"
                    data-status="busy"
                    data-kyc="pending"
                    data-region="europe">

                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <div class="h-10 w-10 flex-shrink-0">
                                <img class="h-10 w-10 rounded-full object-cover" src="https://images.unsplash.com/photo-1544005313-94ddf0286df2?auto=format&fit=crop&q=80&w=100" alt="">
                            </div>
                            <div class="ml-4">
                                <div class="text-sm font-medium text-gray-900">Marcus Cole</div>
                                <div class="text-xs text-gray-500">ID: EXP-002</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900">Senior Architect</div>
                        <div class="text-xs text-gray-500">$250/hr</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-center">
                        <span class="inline-flex items-center rounded-full bg-yellow-50 px-2 py-1 text-xs font-medium text-yellow-800 ring-1 ring-inset ring-yellow-600/20">Busy</span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex flex-col gap-1">
                            <span class="inline-flex items-center gap-1 text-xs text-orange-600 font-medium">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                KYC Pending
                            </span>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm text-gray-500">
                        <span class="font-bold text-gray-900">4.7 ★</span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                        <button onclick="openExpertDetails('2')" class="text-indigo-600 hover:text-indigo-900 bg-indigo-50 hover:bg-indigo-100 px-3 py-1.5 rounded-md transition-colors">Details</button>
                    </td>
                </tr>

                <tr class="expert-row hover:bg-gray-50 transition duration-150"
                    data-name="sarah jenkins"
                    data-id="exp-003"
                    data-category="finance"
                    data-rate="120"
                    data-status="offline"
                    data-kyc="rejected"
                    data-region="asia">

                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <div class="h-10 w-10 flex-shrink-0">
                                <img class="h-10 w-10 rounded-full object-cover" src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?auto=format&fit=crop&q=80&w=100" alt="">
                            </div>
                            <div class="ml-4">
                                <div class="text-sm font-medium text-gray-900">Sarah Jenkins</div>
                                <div class="text-xs text-gray-500">ID: EXP-003</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900">Finance Audit</div>
                        <div class="text-xs text-gray-500">$120/hr</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-center">
                        <span class="inline-flex items-center rounded-full bg-gray-100 px-2 py-1 text-xs font-medium text-gray-600 ring-1 ring-inset ring-gray-600/20">Offline</span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex flex-col gap-1">
                            <span class="inline-flex items-center gap-1 text-xs text-red-600 font-medium">
                                Rejected
                            </span>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm text-gray-500">
                        <span class="font-bold text-gray-900">4.2 ★</span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                        <button onclick="openExpertDetails('3')" class="text-indigo-600 hover:text-indigo-900 bg-indigo-50 hover:bg-indigo-100 px-3 py-1.5 rounded-md transition-colors">Details</button>
                    </td>
                </tr>

            </tbody>
        </table>
    </div>
    <div class="px-6 py-4 border-t border-gray-100 flex justify-center">
        <span id="showing-text" class="text-sm text-gray-500">Showing all results</span>
    </div>
<!-- </div> -->