@extends('layouts.app')

@section('content')
<script src="https://cdn.tailwindcss.com"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<style>
    /* Tab Navigation Styles */
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

    /* Module Selector Card Styles */
    .module-select-active {
        background-color: #eef2ff; /* Indigo-50 */
        border-color: #6366f1; /* Indigo-500 */
        color: #4338ca; /* Indigo-700 */
        transform: translateY(-2px);
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    }
    .module-select-inactive {
        background-color: #ffffff;
        border-color: #e5e7eb; /* Gray-200 */
        color: #6b7280; /* Gray-500 */
    }
    .module-select-inactive:hover {
        border-color: #cbd5e1;
        background-color: #f8fafc;
    }

    /* Animations */
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(5px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .animate-fade-in {
        animation: fadeIn 0.3s ease-out forwards;
    }
</style>

<div class="min-h-screen bg-gray-50/50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="mb-8 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h2 class="text-2xl font-bold text-gray-900 tracking-tight">Subscription Master</h2>
                <p class="text-gray-500 text-sm mt-1">Central hub for all service module subscriptions.</p>
            </div>
            <div class="flex items-center gap-4 bg-white p-2 rounded-lg border border-gray-200 shadow-sm">
                <div class="px-4 border-r border-gray-100">
                    <div class="text-xs text-gray-500 uppercase font-semibold">Total Revenue</div>
                    <div class="text-lg font-bold text-indigo-600">$45,200</div>
                </div>
                <div class="px-4">
                    <div class="text-xs text-gray-500 uppercase font-semibold">Active Subscriptions</div>
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
                            <p class="text-xs font-semibold text-gray-400 uppercase">Active</p>
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
                        <input type="text" class="block w-full pl-10 pr-3 py-2 border border-gray-200 rounded-lg bg-gray-50 text-sm focus:ring-indigo-500 focus:border-indigo-500" placeholder="Search user, email or role...">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none"><i class="fas fa-search text-gray-400"></i></div>
                    </div>
                    <button class="px-4 py-2 bg-white border border-gray-200 rounded-lg text-sm text-gray-700 hover:bg-gray-50"><i class="fas fa-filter mr-2"></i>Filter by Module</button>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">User</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Module Role</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Current Plan</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Amount</th>
                                <th class="px-6 py-3 text-right">Action</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 flex items-center gap-3">
                                    <div class="h-8 w-8 rounded-full bg-indigo-100 text-indigo-600 flex items-center justify-center font-bold text-xs">JD</div>
                                    <div><div class="text-sm font-medium text-gray-900">John Doe</div><div class="text-xs text-gray-500">john@mart.com</div></div>
                                </td>
                                <td class="px-6 py-4"><span class="bg-orange-100 text-orange-700 px-2 py-1 rounded text-xs font-bold">Vendor</span></td>
                                <td class="px-6 py-4"><span class="text-gray-700 text-sm">Gold Tier</span></td>
                                <td class="px-6 py-4"><span class="text-green-600 text-xs font-medium bg-green-50 px-2 py-1 rounded-full">Active</span></td>
                                <td class="px-6 py-4 text-sm font-bold text-gray-900">$49.00</td>
                                <td class="px-6 py-4 text-right"><button class="text-gray-400 hover:text-indigo-600"><i class="fas fa-ellipsis-v"></i></button></td>
                            </tr>
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 flex items-center gap-3">
                                    <div class="h-8 w-8 rounded-full bg-green-100 text-green-600 flex items-center justify-center font-bold text-xs">AS</div>
                                    <div><div class="text-sm font-medium text-gray-900">Alice Smith</div><div class="text-xs text-gray-500">alice@ride.com</div></div>
                                </td>
                                <td class="px-6 py-4"><span class="bg-green-100 text-green-700 px-2 py-1 rounded text-xs font-bold">Rider</span></td>
                                <td class="px-6 py-4"><span class="text-gray-700 text-sm">Speedy Pro</span></td>
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
            
            <div class="mb-8">
                <h3 class="text-sm font-semibold text-gray-700 mb-3 uppercase tracking-wide">Select Module to Manage</h3>
                <div class="grid grid-cols-2 md:grid-cols-5 gap-4">
                    <button onclick="selectModule('vendor')" id="mod-vendor" class="module-select-active flex flex-col items-center p-4 rounded-xl border-2 transition-all cursor-pointer">
                        <div class="h-10 w-10 rounded-full bg-orange-100 text-orange-600 flex items-center justify-center mb-2"><i class="fas fa-store"></i></div>
                        <span class="font-bold text-sm">Mart Vendor</span>
                    </button>
                    
                    <button onclick="selectModule('professional')" id="mod-professional" class="module-select-inactive flex flex-col items-center p-4 rounded-xl border-2 transition-all cursor-pointer">
                        <div class="h-10 w-10 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center mb-2"><i class="fas fa-user-tie"></i></div>
                        <span class="font-bold text-sm">Professional</span>
                    </button>

                    <button onclick="selectModule('consultant')" id="mod-consultant" class="module-select-inactive flex flex-col items-center p-4 rounded-xl border-2 transition-all cursor-pointer">
                        <div class="h-10 w-10 rounded-full bg-purple-100 text-purple-600 flex items-center justify-center mb-2"><i class="fas fa-headset"></i></div>
                        <span class="font-bold text-sm">Consultant</span>
                    </button>

                    <button onclick="selectModule('rider')" id="mod-rider" class="module-select-inactive flex flex-col items-center p-4 rounded-xl border-2 transition-all cursor-pointer">
                        <div class="h-10 w-10 rounded-full bg-green-100 text-green-600 flex items-center justify-center mb-2"><i class="fas fa-motorcycle"></i></div>
                        <span class="font-bold text-sm">Rider</span>
                    </button>

                    <button onclick="selectModule('provider')" id="mod-provider" class="module-select-inactive flex flex-col items-center p-4 rounded-xl border-2 transition-all cursor-pointer">
                        <div class="h-10 w-10 rounded-full bg-teal-100 text-teal-600 flex items-center justify-center mb-2"><i class="fas fa-tools"></i></div>
                        <span class="font-bold text-sm">Provider</span>
                    </button>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                
                <div class="lg:col-span-2">
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden relative">
                        <div class="p-6 border-b border-gray-100 bg-gray-50/50 flex justify-between items-center">
                            <h3 class="font-semibold text-gray-800">
                                Create New Plan for <span id="form-module-name" class="text-indigo-600 font-bold">Mart Vendor</span>
                            </h3>
                            <span class="text-xs bg-gray-200 text-gray-600 px-2 py-1 rounded">Module ID: <span id="form-module-id">vendor</span></span>
                        </div>

                        <form action="#" method="POST" class="p-6 space-y-5">
                            @csrf
                            <input type="hidden" name="module_type" id="input-module-type" value="vendor">

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Plan Name</label>
                                    <input type="text" name="name" class="w-full rounded-lg border-gray-300 border px-3 py-2 text-sm focus:ring-indigo-500 focus:border-indigo-500" placeholder="e.g. Gold Tier">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Highlight Tag</label>
                                    <input type="text" name="tagline" class="w-full rounded-lg border-gray-300 border px-3 py-2 text-sm focus:ring-indigo-500 focus:border-indigo-500" placeholder="e.g. Best Value">
                                </div>
                            </div>
                            
                            <div class="grid grid-cols-3 gap-5">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Price</label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none"><span class="text-gray-500 sm:text-sm">$</span></div>
                                        <input type="number" name="price" class="w-full rounded-lg border-gray-300 border pl-7 pr-3 py-2 text-sm" placeholder="0.00">
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Interval</label>
                                    <select name="interval" class="w-full rounded-lg border-gray-300 border px-3 py-2 text-sm">
                                        <option value="monthly">Monthly</option>
                                        <option value="yearly">Yearly</option>
                                        <option value="lifetime">Lifetime</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Trial Days</label>
                                    <input type="number" name="trial_days" class="w-full rounded-lg border-gray-300 border px-3 py-2 text-sm" placeholder="7">
                                </div>
                            </div>
                            
                            <div class="bg-gray-50 p-4 rounded-lg border border-dashed border-gray-200">
                                <label class="block text-xs font-bold text-gray-500 uppercase mb-3">Module Limits & Configuration</label>
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label class="text-xs text-gray-600 block mb-1">Max Products/Gigs</label>
                                        <input type="number" name="limit_items" class="w-full rounded border-gray-300 text-sm py-1.5" placeholder="e.g. 50">
                                    </div>
                                    <div>
                                        <label class="text-xs text-gray-600 block mb-1">Commission Fee (%)</label>
                                        <input type="number" name="commission_fee" class="w-full rounded border-gray-300 text-sm py-1.5" placeholder="e.g. 5">
                                    </div>
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Display Features</label>
                                <div id="features-list" class="space-y-2">
                                    <div class="flex gap-2">
                                        <input type="text" name="features[]" class="w-full rounded-lg border-gray-300 border px-3 py-2 text-sm" placeholder="e.g. Priority Support">
                                        <button type="button" onclick="removeRow(this)" class="text-red-500 hover:bg-red-50 p-2 rounded"><i class="fas fa-trash"></i></button>
                                    </div>
                                </div>
                                <button type="button" onclick="addFeatureRow()" class="mt-2 text-sm text-indigo-600 font-medium hover:underline">+ Add another feature</button>
                            </div>

                            <div class="flex justify-end gap-3 pt-4 border-t border-gray-100">
                                <button type="button" class="px-4 py-2 text-sm text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50">Cancel</button>
                                <button type="submit" class="px-4 py-2 text-sm text-white bg-indigo-600 rounded-lg hover:bg-indigo-700 shadow-sm transition-colors">
                                    Save <span class="current-module-text">Vendor</span> Plan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="lg:col-span-1">
                    <div class="flex justify-between items-end mb-4">
                        <h3 class="text-sm font-bold text-gray-900 uppercase tracking-wider">Live Plans</h3>
                        <span class="text-xs text-indigo-600 font-medium cursor-pointer hover:underline">View All</span>
                    </div>
                    
                    <div id="live-plans-container" class="space-y-4">
                        
                        <div class="plan-card plan-vendor bg-white p-5 rounded-xl border border-gray-200 shadow-sm relative group hover:border-orange-400 transition-all">
                            <div class="absolute top-0 right-0 bg-orange-100 text-orange-600 text-[10px] font-bold px-2 py-1 rounded-bl-lg rounded-tr-lg">VENDOR</div>
                            <h4 class="font-bold text-gray-800">Shop Basic</h4>
                            <div class="text-2xl font-bold text-gray-900 my-2">$15<span class="text-sm text-gray-500 font-normal">/mo</span></div>
                            <ul class="text-xs text-gray-500 space-y-1">
                                <li><i class="fas fa-check text-green-500 mr-1"></i> 50 Products Limit</li>
                                <li><i class="fas fa-check text-green-500 mr-1"></i> 5% Commission</li>
                            </ul>
                        </div>

                        <div class="plan-card plan-professional hidden bg-white p-5 rounded-xl border border-gray-200 shadow-sm relative group hover:border-blue-400 transition-all">
                            <div class="absolute top-0 right-0 bg-blue-100 text-blue-600 text-[10px] font-bold px-2 py-1 rounded-bl-lg rounded-tr-lg">PROFESSIONAL</div>
                            <h4 class="font-bold text-gray-800">Pro Starter</h4>
                            <div class="text-2xl font-bold text-gray-900 my-2">$29<span class="text-sm text-gray-500 font-normal">/mo</span></div>
                             <ul class="text-xs text-gray-500 space-y-1">
                                <li><i class="fas fa-check text-green-500 mr-1"></i> Profile Featured</li>
                                <li><i class="fas fa-check text-green-500 mr-1"></i> Verified Badge</li>
                            </ul>
                        </div>

                        <div class="plan-card plan-rider hidden bg-white p-5 rounded-xl border border-gray-200 shadow-sm relative group hover:border-green-400 transition-all">
                            <div class="absolute top-0 right-0 bg-green-100 text-green-600 text-[10px] font-bold px-2 py-1 rounded-bl-lg rounded-tr-lg">RIDER</div>
                            <h4 class="font-bold text-gray-800">Zero Commission</h4>
                            <div class="text-2xl font-bold text-gray-900 my-2">$9<span class="text-sm text-gray-500 font-normal">/mo</span></div>
                             <ul class="text-xs text-gray-500 space-y-1">
                                <li><i class="fas fa-check text-green-500 mr-1"></i> Keep 100% Earnings</li>
                                <li><i class="fas fa-check text-green-500 mr-1"></i> Instant Payouts</li>
                            </ul>
                        </div>

                         <div class="plan-card plan-consultant hidden bg-white p-5 rounded-xl border border-gray-200 shadow-sm relative group hover:border-purple-400 transition-all">
                            <div class="absolute top-0 right-0 bg-purple-100 text-purple-600 text-[10px] font-bold px-2 py-1 rounded-bl-lg rounded-tr-lg">CONSULTANT</div>
                            <h4 class="font-bold text-gray-800">Expert Suite</h4>
                            <div class="text-2xl font-bold text-gray-900 my-2">$49<span class="text-sm text-gray-500 font-normal">/mo</span></div>
                             <ul class="text-xs text-gray-500 space-y-1">
                                <li><i class="fas fa-check text-green-500 mr-1"></i> Video Call Tools</li>
                                <li><i class="fas fa-check text-green-500 mr-1"></i> Appointment Booking</li>
                            </ul>
                        </div>

                    </div>

                    <div id="empty-state" class="hidden text-center py-10 bg-gray-50 rounded-xl border border-dashed border-gray-200 mt-2">
                        <i class="fas fa-box-open text-gray-300 text-3xl mb-3"></i>
                        <p class="text-sm text-gray-500">No active plans for this module.</p>
                        <p class="text-xs text-gray-400">Create one using the form.</p>
                    </div>

                </div>
            </div>
        </div>

    </div>
</div>

<script>
    // --- 1. TAB SWITCHING (Subscribers vs Plans) ---
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

    // --- 2. MODULE SELECTION LOGIC (The Core Logic) ---
    function selectModule(moduleId) {
        const modules = ['vendor', 'professional', 'consultant', 'rider', 'provider'];
        
        // A. Visual Update of Top Buttons
        modules.forEach(mod => {
            const btn = document.getElementById('mod-' + mod);
            if (mod === moduleId) {
                btn.classList.remove('module-select-inactive');
                btn.classList.add('module-select-active');
            } else {
                btn.classList.remove('module-select-active');
                btn.classList.add('module-select-inactive');
            }
        });

        // B. Update Form Inputs
        document.getElementById('form-module-name').innerText = capitalizeFirstLetter(moduleId);
        document.getElementById('form-module-id').innerText = moduleId;
        document.getElementById('input-module-type').value = moduleId; // Updates Hidden Input
        
        // Update all button texts
        document.querySelectorAll('.current-module-text').forEach(el => {
            el.innerText = capitalizeFirstLetter(moduleId);
        });

        // C. Filter Live Plans List
        filterLivePlans(moduleId);
    }

    function filterLivePlans(moduleId) {
        const allCards = document.querySelectorAll('.plan-card');
        let visibleCount = 0;

        allCards.forEach(card => {
            if (card.classList.contains('plan-' + moduleId)) {
                card.classList.remove('hidden');
                visibleCount++;
            } else {
                card.classList.add('hidden');
            }
        });

        // Show/Hide Empty State
        if (visibleCount === 0) {
            document.getElementById('empty-state').classList.remove('hidden');
        } else {
            document.getElementById('empty-state').classList.add('hidden');
        }
    }

    // Helper: Capitalize String
    function capitalizeFirstLetter(string) {
        return string.charAt(0).toUpperCase() + string.slice(1);
    }

    // --- 3. DYNAMIC FORM ROWS ---
    function addFeatureRow() {
        const container = document.getElementById('features-list');
        const div = document.createElement('div');
        div.className = 'flex gap-2';
        div.innerHTML = `
            <input type="text" name="features[]" class="w-full rounded-lg border-gray-300 border px-3 py-2 text-sm" placeholder="Feature description...">
            <button type="button" onclick="removeRow(this)" class="text-red-500 hover:bg-red-50 p-2 rounded"><i class="fas fa-trash"></i></button>
        `;
        container.appendChild(div);
    }

    function removeRow(btn) {
        btn.parentElement.remove();
    }

    // Initialize View
    document.addEventListener('DOMContentLoaded', function() {
        // Default to showing the subscribers tab
        switchTab('subscribers');
        // Default module selection
        selectModule('vendor'); 
    });
</script>
@endsection