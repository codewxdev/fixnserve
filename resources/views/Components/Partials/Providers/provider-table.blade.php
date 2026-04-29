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
            
            @for ($i = 1; $i <= 10; $i++)
            <tr class="hover:bg-blue-50/50 transition duration-150 ease-in-out">
                
                <td class="px-6 py-4 whitespace-nowrap">
                    <div class="flex items-center">
                        <img class="h-10 w-10 rounded-full object-cover shadow-sm ring-1 ring-gray-100" src="https://i.pravatar.cc/150?img={{ $i }}" alt="Profile Photo">
                        <div class="ml-4">
                            <div class="text-sm font-medium text-gray-900">John Doe #{{ $i }}</div>
                            <div class="text-xs text-gray-500">ID: PRV-{{ 1000 + $i }}</div>
                        </div>
                    </div>
                </td>
                
                <td class="px-6 py-4 whitespace-nowrap">
                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-medium rounded-full bg-blue-100 text-blue-800">
                        Plumber
                    </span>
                    <div class="text-xs text-gray-500 mt-1">
                        Model: <span class="font-semibold text-gray-700">Fixed/Hourly</span>
                    </div>
                </td>
                
                <td class="px-6 py-4 whitespace-nowrap text-center text-sm">
                    <div class="mb-1">
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                            Verified
                        </span>
                        <span title="KYC Status" class="text-xs text-gray-400">KYC</span>
                    </div>
                    <div>
                        <span class="inline-flex items-center text-xs font-medium text-gray-700">
                            <i class="fas fa-circle text-green-500 text-[8px] mr-1"></i> Online
                        </span>
                    </div>
                </td>
                
                <td class="px-6 py-4 whitespace-nowrap text-center text-sm">
                    <div class="text-yellow-500 flex items-center justify-center">
                        <i class="fas fa-star text-xs mr-1"></i> 4.{{ 8 - ($i % 3) }} 
                    </div>
                    <div class="text-xs text-gray-500 mt-1">
                        <i class="fas fa-check-circle text-blue-500 text-xs"></i> **{{ 200 + $i * 10 }}** Orders
                    </div>
                </td>
                
                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                    <div class="text-gray-900">
                        **${{ 1000 + $i * 50 }}.00** <span class="text-xs text-gray-500">(Bal)</span>
                    </div>
                    <div class="text-red-500 mt-1">
                        <i class="fas fa-exclamation-triangle text-xs"></i> **{{ $i % 3 }}** Violations
                    </div>
                </td>
                
                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                    <div class="flex justify-end items-center space-x-2">
                        <button onclick="openProviderDetails('{{ $i }}')" class="px-3 py-1 text-blue-600 bg-blue-50 rounded-md hover:bg-blue-100 transition duration-150 text-xs font-semibold" title="View Full Details">
                            View
                        </button>
                        
                        <div class="relative inline-block text-left" x-data="{ open: false }">
                            <button @click="open = !open" class="action-dropdown-btn inline-flex justify-center rounded-full text-gray-400 hover:text-gray-600 p-1 focus:outline-none transition duration-150" title="More Actions">
                                <i class="fas fa-ellipsis-v text-sm"></i>
                            </button>

                            <div class="action-dropdown-menu hidden origin-top-right absolute right-0 mt-2 w-56 rounded-lg shadow-2xl bg-white ring-1 ring-black ring-opacity-5 divide-y divide-gray-100 z-20" role="menu">
                                <div class="py-1">
                                    <a href="#" class="flex items-center px-4 py-2 text-sm text-green-700 hover:bg-green-50"><i class="fas fa-check-circle mr-3 w-4"></i> Approve KYC</a>
                                    <a href="#" class="flex items-center px-4 py-2 text-sm text-red-700 hover:bg-red-50"><i class="fas fa-times-circle mr-3 w-4"></i> Reject KYC</a>
                                </div>
                                <div class="py-1">
                                    <a href="#" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-50"><i class="fas fa-gavel mr-3 w-4"></i> Suspend/Ban</a>
                                    <a href="#" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-50"><i class="fas fa-key mr-3 w-4"></i> Reset Password</a>
                                    <a href="#" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-50"><i class="fas fa-clipboard-list mr-3 w-4"></i> Assign Orders</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </td>
            </tr>
            @endfor
        </tbody>
    </table>
</div>