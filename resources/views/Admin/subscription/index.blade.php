@extends('layouts.app')

@section('content')
<script src="https://cdn.tailwindcss.com"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<style>
    /* Custom Tab Styles */
    .tab-active {
        border-bottom: 2px solid #4f46e5; /* Indigo-600 */
        color: #4f46e5;
        font-weight: 600;
    }
    .tab-inactive {
        border-bottom: 2px solid transparent;
        color: #6b7280; /* Gray-500 */
    }
    .tab-inactive:hover {
        color: #374151; /* Gray-700 */
        border-bottom: 2px solid #e5e7eb;
    }
</style>

<div class="min-h-screen bg-gray-50/50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="mb-8 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h2 class="text-2xl font-bold text-gray-900 tracking-tight">Subscription Hub</h2>
                <p class="text-gray-500 text-sm mt-1">Manage subscribers, billing, and pricing plans from one place.</p>
            </div>
            <div class="flex items-center gap-4 bg-white p-2 rounded-lg border border-gray-200 shadow-sm">
                <div class="px-4 border-r border-gray-100">
                    <div class="text-xs text-gray-500 uppercase font-semibold">MRR</div>
                    <div class="text-lg font-bold text-indigo-600">$45,200</div>
                </div>
                <div class="px-4">
                    <div class="text-xs text-gray-500 uppercase font-semibold">Active</div>
                    <div class="text-lg font-bold text-green-600">2,100</div>
                </div>
            </div>
        </div>

        <div class="mb-6 border-b border-gray-200">
            <nav class="-mb-px flex space-x-8" aria-label="Tabs">
                <button onclick="switchTab('subscribers')" id="btn-subscribers" class="tab-active whitespace-nowrap py-4 px-1 text-sm font-medium transition-colors">
                    <i class="fas fa-users mr-2"></i>Subscribers List
                </button>
                <button onclick="switchTab('plans')" id="btn-plans" class="tab-inactive whitespace-nowrap py-4 px-1 text-sm font-medium transition-colors">
                    <i class="fas fa-layer-group mr-2"></i>Manage Plans
                </button>
            </nav>
        </div>

        <div id="tab-subscribers" class="tab-content block animate-fade-in">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-xs font-semibold text-gray-400 uppercase">Total Subscribers</p>
                            <h3 class="text-2xl font-bold text-gray-900 mt-1">2,543</h3>
                        </div>
                        <div class="p-2 bg-indigo-50 text-indigo-600 rounded-lg"><i class="fas fa-users"></i></div>
                    </div>
                </div>
                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-xs font-semibold text-gray-400 uppercase">Active Subscribers</p>
                            <h3 class="text-2xl font-bold text-gray-900 mt-1">2,100</h3>
                        </div>
                        <div class="p-2 bg-green-50 text-green-600 rounded-lg"><i class="fas fa-check-circle"></i></div>
                    </div>
                </div>
                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-xs font-semibold text-gray-400 uppercase">Pending Due</p>
                            <h3 class="text-2xl font-bold text-gray-900 mt-1">45</h3>
                        </div>
                        <div class="p-2 bg-yellow-50 text-yellow-600 rounded-lg"><i class="fas fa-clock"></i></div>
                    </div>
                </div>
                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-xs font-semibold text-gray-400 uppercase">Canceled</p>
                            <h3 class="text-2xl font-bold text-gray-900 mt-1">12</h3>
                        </div>
                        <div class="p-2 bg-red-50 text-red-600 rounded-lg"><i class="fas fa-times-circle"></i></div>
                    </div>
                </div>
            </div>

            <div class="bg-white border border-gray-100 shadow-sm rounded-xl overflow-hidden">
                <div class="p-5 border-b border-gray-100 flex flex-col sm:flex-row justify-between gap-4">
                    <div class="relative w-full sm:w-72">
                        <input type="text" class="block w-full pl-10 pr-3 py-2 border border-gray-200 rounded-lg bg-gray-50 text-sm focus:ring-indigo-500 focus:border-indigo-500" placeholder="Search user...">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none"><i class="fas fa-search text-gray-400"></i></div>
                    </div>
                    <button class="px-4 py-2 bg-white border border-gray-200 rounded-lg text-sm text-gray-700 hover:bg-gray-50"><i class="fas fa-filter mr-2"></i>Filter</button>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">User</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Plan</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Amount</th>
                                <th class="px-6 py-3 text-right">Action</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 flex items-center gap-3">
                                    <div class="h-8 w-8 rounded-full bg-indigo-100 text-indigo-600 flex items-center justify-center font-bold text-xs">JD</div>
                                    <div><div class="text-sm font-medium text-gray-900">John Doe</div><div class="text-xs text-gray-500">john@example.com</div></div>
                                </td>
                                <td class="px-6 py-4"><span class="bg-indigo-50 text-indigo-700 px-2 py-0.5 rounded text-xs font-medium border border-indigo-100">Pro Plan</span></td>
                                <td class="px-6 py-4"><span class="text-green-600 text-xs font-medium bg-green-50 px-2 py-1 rounded-full">Active</span></td>
                                <td class="px-6 py-4 text-sm font-bold text-gray-900">$49.00</td>
                                <td class="px-6 py-4 text-right"><button class="text-gray-400 hover:text-indigo-600"><i class="fas fa-ellipsis-v"></i></button></td>
                            </tr>
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 flex items-center gap-3">
                                    <div class="h-8 w-8 rounded-full bg-yellow-100 text-yellow-600 flex items-center justify-center font-bold text-xs">AS</div>
                                    <div><div class="text-sm font-medium text-gray-900">Alice Smith</div><div class="text-xs text-gray-500">alice@example.com</div></div>
                                </td>
                                <td class="px-6 py-4"><span class="bg-gray-100 text-gray-700 px-2 py-0.5 rounded text-xs font-medium border border-gray-200">Basic</span></td>
                                <td class="px-6 py-4"><span class="text-red-600 text-xs font-medium bg-red-50 px-2 py-1 rounded-full">Expired</span></td>
                                <td class="px-6 py-4 text-sm font-bold text-gray-900">$19.00</td>
                                <td class="px-6 py-4 text-right"><button class="text-gray-400 hover:text-indigo-600"><i class="fas fa-ellipsis-v"></i></button></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div id="tab-plans" class="tab-content hidden animate-fade-in">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <div class="lg:col-span-2">
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                        <div class="p-6 border-b border-gray-100 bg-gray-50/50">
                            <h3 class="font-semibold text-gray-800">Create New Subscription Plan</h3>
                        </div>
                        <form action="#" method="POST" class="p-6 space-y-5">
                            @csrf
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Plan Name</label>
                                    <input type="text" name="name" class="w-full rounded-lg border-gray-300 border px-3 py-2 text-sm focus:ring-indigo-500 focus:border-indigo-500" placeholder="e.g. Gold Tier">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Tagline</label>
                                    <input type="text" name="tagline" class="w-full rounded-lg border-gray-300 border px-3 py-2 text-sm focus:ring-indigo-500 focus:border-indigo-500" placeholder="e.g. Best value">
                                </div>
                            </div>
                            <div class="grid grid-cols-3 gap-5">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Currency</label>
                                    <select class="w-full rounded-lg border-gray-300 border px-3 py-2 text-sm"><option>USD ($)</option><option>PKR (Rs)</option></select>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Price</label>
                                    <input type="number" class="w-full rounded-lg border-gray-300 border px-3 py-2 text-sm" placeholder="99.00">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Interval</label>
                                    <select class="w-full rounded-lg border-gray-300 border px-3 py-2 text-sm"><option>Monthly</option><option>Yearly</option></select>
                                </div>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Features Included</label>
                                <div id="features-list" class="space-y-2">
                                    <div class="flex gap-2">
                                        <input type="text" name="features[]" class="w-full rounded-lg border-gray-300 border px-3 py-2 text-sm" placeholder="Feature 1">
                                        <button type="button" onclick="removeRow(this)" class="text-red-500 hover:bg-red-50 p-2 rounded"><i class="fas fa-trash"></i></button>
                                    </div>
                                </div>
                                <button type="button" onclick="addFeatureRow()" class="mt-2 text-sm text-indigo-600 font-medium hover:underline">+ Add another feature</button>
                            </div>

                            <div class="flex justify-end gap-3 pt-4 border-t border-gray-100">
                                <button type="button" class="px-4 py-2 text-sm text-gray-700 bg-white border border-gray-300 rounded-lg">Cancel</button>
                                <button type="submit" class="px-4 py-2 text-sm text-white bg-indigo-600 rounded-lg hover:bg-indigo-700">Save Plan</button>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="lg:col-span-1">
                    <h3 class="text-sm font-bold text-gray-900 uppercase tracking-wider mb-4">Live Plans</h3>
                    
                    <div class="bg-white p-5 rounded-xl border border-gray-200 shadow-sm mb-4 relative group hover:border-indigo-400 transition-all">
                        <div class="absolute top-4 right-4 text-gray-400 group-hover:text-indigo-600 cursor-pointer"><i class="fas fa-pen"></i></div>
                        <h4 class="font-bold text-gray-800">Basic</h4>
                        <div class="text-2xl font-bold text-gray-900 my-2">$9<span class="text-sm text-gray-500 font-normal">/mo</span></div>
                        <ul class="text-xs text-gray-500 space-y-1">
                            <li><i class="fas fa-check text-green-500 mr-1"></i> Access to dashboard</li>
                            <li><i class="fas fa-check text-green-500 mr-1"></i> Email support</li>
                        </ul>
                    </div>

                    <div class="bg-white p-5 rounded-xl border-2 border-indigo-500 shadow-md relative">
                        <div class="absolute -top-3 left-1/2 transform -translate-x-1/2 bg-indigo-500 text-white text-[10px] font-bold px-3 py-0.5 rounded-full">Recommended</div>
                        <h4 class="font-bold text-gray-800">Pro Bundle</h4>                        <div class="text-2xl font-bold text-gray-900 my-2">$49<span class="text-sm text-gray-500 font-normal">/mo</span></div>
                        <ul class="text-xs text-gray-500 space-y-1">
                            <li><i class="fas fa-check text-green-500 mr-1"></i> All Basic features</li>
                            <li><i class="fas fa-check text-green-500 mr-1"></i> Priority Support</li>
                            <li><i class="fas fa-check text-green-500 mr-1"></i> Advanced Analytics</li>
                        </ul>
                    </div>

                   <div class="bg-white p-5 rounded-xl border-2 border-indigo-500 shadow-md relative mt-4">
                        <div class="absolute -top-3 left-1/2 transform -translate-x-1/2 bg-indigo-500 text-white text-[10px] font-bold px-3 py-0.5 rounded-full">POPULAR</div>
                        <h4 class="font-bold text-gray-800">Pro Bundle</h4>
                        <div class="text-2xl font-bold text-gray-900 my-2">$120<span class="text-sm text-gray-500 font-normal">/mo</span></div>
                        <ul class="text-xs text-gray-500 space-y-1">
                            <li><i class="fas fa-check text-green-500 mr-1"></i> All Basic features</li>
                            <li><i class="fas fa-check text-green-500 mr-1"></i> Priority Support</li>
                            <li><i class="fas fa-check text-green-500 mr-1"></i> Advanced Analytics</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<script>
    // Tab Switching Logic
    function switchTab(tabId) {
        // Hide all contents
        document.querySelectorAll('.tab-content').forEach(el => el.classList.add('hidden'));
        document.querySelectorAll('.tab-content').forEach(el => el.classList.remove('block'));
        
        // Reset tab button styles
        document.getElementById('btn-subscribers').className = 'tab-inactive whitespace-nowrap py-4 px-1 text-sm font-medium transition-colors cursor-pointer';
        document.getElementById('btn-plans').className = 'tab-inactive whitespace-nowrap py-4 px-1 text-sm font-medium transition-colors cursor-pointer';

        // Show selected content
        document.getElementById('tab-' + tabId).classList.remove('hidden');
        document.getElementById('tab-' + tabId).classList.add('block');

        // Set active tab style
        document.getElementById('btn-' + tabId).className = 'tab-active whitespace-nowrap py-4 px-1 text-sm font-medium transition-colors cursor-pointer';
    }

    // Add Feature Row Logic
    function addFeatureRow() {
        const container = document.getElementById('features-list');
        const div = document.createElement('div');
        div.className = 'flex gap-2';
        div.innerHTML = `
            <input type="text" name="features[]" class="w-full rounded-lg border-gray-300 border px-3 py-2 text-sm" placeholder="Next Feature">
            <button type="button" onclick="removeRow(this)" class="text-red-500 hover:bg-red-50 p-2 rounded"><i class="fas fa-trash"></i></button>
        `;
        container.appendChild(div);
    }

    function removeRow(btn) {
        btn.parentElement.remove();
    }
</script>
@endsection