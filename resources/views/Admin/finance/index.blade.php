@extends('layouts.app')

{{-- Assume 'app' layout includes necessary Tailwind CSS and Alpine.js setup --}}

@section('content')

{{-- Alpine.js state for tab navigation and potential modals/slide-overs --}}
<div id="finance-management-page" 
     class="space-y-6 p-4 md:p-8 bg-gray-50 min-h-screen" 
     x-data="{ currentModule: 'overview', openSettings: false }" 
     x-cloak>
    
    {{-- 1. Header and Global Actions --}}
    <header class="flex flex-col sm:flex-row justify-between items-start sm:items-center pb-4 border-b border-gray-200">
        <div class="mb-4 sm:mb-0">
            <h1 class="text-2xl md:text-3xl font-bold text-gray-900 flex items-center">
                <svg class="w-6 h-6 md:w-8 md:h-8 mr-3 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                Payments & Finance Center
            </h1>
            <p class="text-xs sm:text-sm text-gray-500 mt-1">Manage all transactions, payouts, commission rules, and tax configurations.</p>
        </div>
        <div class="flex flex-wrap gap-2"> 
            <button @click="openSettings = true" class="flex items-center px-3 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition duration-150 ease-in-out shadow-sm">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.585.355 1.288.465 1.724.066z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                System Settings
            </button>
        </div>
    </header>

    {{-- 2. Module Navigation Tabs (Sticky) --}}
    <nav class="sticky top-0 z-20 bg-gray-50 border-b border-gray-200 -mx-4 sm:mx-0 px-4 sm:px-0 pt-2 flex space-x-6 overflow-x-auto">
        @php
            $modules = [
                'overview' => 'Overview & KPIs',
                'payouts' => 'Payouts & Settlement',
                'refunds' => 'Refund Management',
                'config' => 'Commission & Tax Rules',
                'wallet' => 'Wallet & Conversion',
                'gateway' => 'Gateway Logs'
            ];
        @endphp
        
        @foreach($modules as $key => $label)
            <button @click="currentModule = '{{ $key }}'"
                    :class="{'border-teal-500 text-teal-600 font-semibold': currentModule === '{{ $key }}', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': currentModule !== '{{ $key }}'}"
                    class="whitespace-nowrap pb-3 border-b-2 text-sm transition duration-150 ease-in-out">
                {{ $label }}
            </button>
        @endforeach
    </nav>
    
    {{-- 3. Module Content Views (Unique/Modern Design) --}}

    {{-- 3a. Overview & KPIs Dashboard --}}
    <div x-show="currentModule === 'overview'" class="space-y-6">
        <h2 class="text-xl font-bold text-gray-800">Financial Snapshot (YTD)</h2>
        
        {{-- High-Impact KPI Cards (3 Big Cards) --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            
            {{-- Total Revenue Card --}}
            <div class="bg-white p-6 rounded-xl shadow-2xl border-l-4 border-teal-500">
                <p class="text-sm font-medium text-gray-500">Total Net Platform Revenue</p>
                <p class="text-4xl font-bold text-gray-900 mt-2">$1.85M</p>
                <div class="flex items-center mt-3 text-sm font-medium text-teal-600">
                    <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                    +18.5% YOY
                </div>
            </div>

            {{-- Payouts Due Card --}}
            <div class="bg-white p-6 rounded-xl shadow-2xl border-l-4 border-orange-500">
                <p class="text-sm font-medium text-gray-500">Total Pending Payouts (Next Cycle)</p>
                <p class="text-4xl font-bold text-gray-900 mt-2">$125,400</p>
                <div class="flex items-center mt-3 text-sm font-medium text-orange-600">
                    <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    1,240 Transactions Pending
                </div>
            </div>

            {{-- Refund Rate Card --}}
            <div class="bg-white p-6 rounded-xl shadow-2xl border-l-4 border-red-500">
                <p class="text-sm font-medium text-gray-500">Global Refund Rate</p>
                <p class="text-4xl font-bold text-gray-900 mt-2">1.45%</p>
                <div class="flex items-center mt-3 text-sm font-medium text-red-600">
                    <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 17h8m0 0V9m0 8l-8-8-4 4-6-6"></path></svg>
                    Goal: < 1.0%
                </div>
            </div>
        </div>

        {{-- Small Metrics Cards (2x4 Grid) --}}
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 pt-4">
            @php
                $metrics = [
                    ['label' => 'Total Commission Earned', 'value' => '$450K', 'icon' => 'banknotes', 'color' => 'blue'],
                    ['label' => 'Tax Liability (MTD)', 'value' => '$12.5K', 'icon' => 'receipt', 'color' => 'indigo'],
                    ['label' => 'Active Wallets', 'value' => '8,500', 'icon' => 'wallet', 'color' => 'purple'],
                    ['label' => 'Failed Gateway Attempts', 'value' => '45', 'icon' => 'x-circle', 'color' => 'yellow'],
                ];
            @endphp
            @foreach($metrics as $metric)
                <div class="bg-white p-4 rounded-lg shadow border border-gray-100">
                    <p class="text-xs font-medium text-gray-500 truncate">{{ $metric['label'] }}</p>
                    <p class="text-xl font-bold text-gray-800 mt-1">{{ $metric['value'] }}</p>
                </div>
            @endforeach
        </div>
    </div>
    
    {{-- 3b. Payouts & Settlement (Simplified Table View) --}}
    <div x-show="currentModule === 'payouts'" class="bg-white p-6 rounded-xl shadow-2xl">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-xl font-semibold text-gray-800">Payout Cycles Management</h3>
            <button class="px-3 py-2 text-sm font-medium text-white bg-teal-600 rounded-lg hover:bg-teal-700">
                Run New Payout Cycle
            </button>
        </div>
        
        {{-- Payout Filter Bar --}}
        <div class="flex space-x-3 mb-4">
             <select class="form-select rounded-lg text-sm border-gray-300 shadow-sm py-2">
                <option>All Payee Types</option>
                <option>Vendor Payouts</option>
                <option>Rider Payouts</option>
            </select>
             <select class="form-select rounded-lg text-sm border-gray-300 shadow-sm py-2">
                <option>Settlement Cycle: Weekly</option>
                <option>Monthly</option>
            </select>
        </div>

        {{-- Payouts Table --}}
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Payee</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Amount Due</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Last Settled</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-100">
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">SuperMart Groceries (VND-101)</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Vendor</td>
                        <td class="px-6 py-4 whitespace-nowrap text-md font-bold text-teal-700">$5,120.50</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Dec 01, 2025</td>
                        <td class="px-6 py-4 whitespace-nowrap text-right">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-orange-100 text-orange-800">Pending</span>
                        </td>
                    </tr>
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">Rider John Doe (RDR-201)</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Rider</td>
                        <td class="px-6 py-4 whitespace-nowrap text-md font-bold text-teal-700">$540.00</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Yesterday</td>
                        <td class="px-6 py-4 whitespace-nowrap text-right">
                             <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Paid</span>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    {{-- 3c. Refund Management (Dedicated View) --}}
    <div x-show="currentModule === 'refunds'" class="bg-white p-6 rounded-xl shadow-2xl">
        <h3 class="text-xl font-semibold text-gray-800 mb-4">Refund Queue</h3>
        <div class="p-4 bg-red-50 rounded-lg mb-4 flex justify-between items-center border border-red-200">
            <p class="text-lg font-bold text-red-700">6 Urgent Refund Requests Awaiting Approval</p>
            <button class="px-3 py-2 text-sm font-medium text-white bg-red-600 rounded-lg hover:bg-red-700">
                View Queue
            </button>
        </div>

        <div class="overflow-x-auto">
             <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Order ID</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Reason</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
                    </tr>
                </thead>
                {{-- Table rows omitted for brevity --}}
            </table>
        </div>
    </div>

    {{-- 3d. Commission & Tax Rules (Configuration View) --}}
    <div x-show="currentModule === 'config'" class="bg-white p-6 rounded-xl shadow-2xl space-y-6">
        <h3 class="text-xl font-semibold text-gray-800">Global Financial Configuration</h3>

        {{-- Commission Engine Card --}}
        <div class="p-5 border-2 border-dashed border-teal-300 rounded-xl bg-teal-50">
            <h4 class="text-lg font-bold text-teal-700 mb-3">Commission Engine Rules</h4>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                <div>
                    <p class="text-gray-500">Vendor Commission (Base)</p>
                    <p class="font-bold">15%</p>
                </div>
                <div>
                    <p class="text-gray-500">Rider Commission (Per Delivery)</p>
                    <p class="font-bold">$3.50 + 2%</p>
                </div>
                <div>
                    <p class="text-gray-500">Service Category Overrides</p>
                    <p class="font-bold text-orange-600">Active (5 categories)</p>
                </div>
            </div>
            <button class="mt-4 text-sm font-medium text-teal-600 hover:underline">Edit Commission Tiers</button>
        </div>

        {{-- Tax Rules Card --}}
        <div class="p-5 border-2 border-dashed border-indigo-300 rounded-xl bg-indigo-50">
            <h4 class="text-lg font-bold text-indigo-700 mb-3">Tax Rules & Compliance</h4>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
                <div>
                    <p class="text-gray-500">UAE (VAT)</p>
                    <p class="font-bold text-green-600">5% Applied</p>
                </div>
                <div>
                    <p class="text-gray-500">AUS (GST)</p>
                    <p class="font-bold text-green-600">10% Applied</p>
                </div>
                <div>
                    <p class="text-gray-500">KSA (VAT)</p>
                    <p class="font-bold text-green-600">15% Applied</p>
                </div>
            </div>
            <button class="mt-4 text-sm font-medium text-indigo-600 hover:underline">Manage Regional Tax Profiles</button>
        </div>
    </div>

    {{-- 3e. Wallet & Conversion (Unique View) --}}
    <div x-show="currentModule === 'wallet'" class="bg-white p-6 rounded-xl shadow-2xl space-y-6">
        <h3 class="text-xl font-semibold text-gray-800">User Wallet & Currency Conversion</h3>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            {{-- Wallet Summary --}}
            <div class="bg-blue-600 p-6 rounded-xl text-white shadow-xl">
                <p class="text-sm font-medium opacity-80">Total Value in Managed Wallets</p>
                <p class="text-3xl font-bold mt-1">$45,800 USD Eq.</p>
                <p class="text-xs mt-3">8,500 Active Wallets | Avg Balance: $5.39</p>
            </div>
            {{-- Conversion Rates --}}
            <div class="bg-gray-50 p-6 rounded-xl shadow-md border border-gray-200">
                <p class="text-sm font-medium text-gray-700">Live Currency Conversion</p>
                <p class="text-2xl font-bold text-gray-900 mt-1">1 USD = 3.67 AED</p>
                <p class="text-xs text-red-500 mt-2">Last Updated: 1 min ago (Via API)</p>
                <button class="mt-3 text-sm font-medium text-teal-600 hover:underline">View All Rates</button>
            </div>
        </div>
    </div>

    {{-- 3f. Gateway Logs (Simplified Table View) --}}
    <div x-show="currentModule === 'gateway'" class="bg-white p-6 rounded-xl shadow-2xl">
        <h3 class="text-xl font-semibold text-gray-800 mb-4">Payment Gateway Transaction Logs</h3>
        
        <div class="overflow-x-auto">
             <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Txn ID</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Gateway</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Time</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-100">
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">TXN-450123</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-800">$45.00</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Stripe</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Success</span>
                        </td>
                         <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">4:30 PM</td>
                    </tr>
                     <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">TXN-450124</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-800">$120.99</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Custom KSA Gateway</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Failed</span>
                        </td>
                         <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">4:31 PM</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    
    {{-- Global Settings Slide-Over (Placeholder) --}}
    <div x-show="openSettings" 
         x-transition:enter="ease-in-out duration-500" 
         x-transition:leave="ease-in-out duration-500" 
         class="fixed inset-0 overflow-hidden z-50">
        {{-- Full slide-over implementation omitted for brevity, focusing on the main dashboard structure --}}
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