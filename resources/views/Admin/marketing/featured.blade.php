@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-slate-50 py-8 px-4 sm:px-6 lg:px-8">
    
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
        <div>
            <h1 class="text-3xl font-bold text-slate-800">Featured Requests</h1>
            <p class="text-slate-500 mt-1">Approve monetization requests from Providers & Vendors.</p>
        </div>
        <button class="px-4 py-2 bg-white border border-slate-200 text-slate-700 font-medium rounded-lg shadow-sm hover:bg-slate-50 transition-colors flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
            Pricing Settings
        </button>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl p-6 shadow-lg shadow-blue-500/20 text-white">
             <div class="flex justify-between items-start">
                <div>
                    <p class="text-blue-100 text-sm font-medium mb-1">Pending Approval</p>
                    <h3 class="text-3xl font-bold">12</h3>
                </div>
                <div class="p-2 bg-white/20 rounded-lg backdrop-blur-sm">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
            </div>
             <p class="text-xs text-blue-100 mt-4">Needs attention within 24hrs</p>
        </div>

        <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-200">
             <div class="flex justify-between items-start">
                <div>
                    <p class="text-slate-500 text-sm font-medium mb-1">Active Featured</p>
                    <h3 class="text-3xl font-bold text-slate-800">45</h3>
                </div>
                <div class="p-2 bg-purple-50 rounded-lg">
                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/></svg>
                </div>
            </div>
             <p class="text-xs text-green-600 mt-4 flex items-center gap-1">
                <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/></svg>
                +5 requests today
            </p>
        </div>

        <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-200">
             <div class="flex justify-between items-start">
                <div>
                    <p class="text-slate-500 text-sm font-medium mb-1">Ad Revenue (Monthly)</p>
                    <h3 class="text-3xl font-bold text-slate-800">Rs 85k</h3>
                </div>
                <div class="p-2 bg-green-50 rounded-lg">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
            </div>
             <p class="text-xs text-slate-400 mt-4">15% increase from last month</p>
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
        <div class="flex border-b border-slate-100">
            <button class="px-6 py-4 text-sm font-medium text-blue-600 border-b-2 border-blue-600 bg-blue-50/50">Pending Requests (12)</button>
            <button class="px-6 py-4 text-sm font-medium text-slate-500 hover:text-slate-700 hover:bg-slate-50 transition-colors">Active Ads</button>
            <button class="px-6 py-4 text-sm font-medium text-slate-500 hover:text-slate-700 hover:bg-slate-50 transition-colors">History</button>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-slate-50/50 text-slate-500 text-xs uppercase font-semibold">
                    <tr>
                        <th class="px-6 py-4">Requester</th>
                        <th class="px-6 py-4">Type</th>
                        <th class="px-6 py-4">Duration</th>
                        <th class="px-6 py-4">Amount</th>
                        <th class="px-6 py-4">Payment</th>
                        <th class="px-6 py-4 text-right">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-sm">
                    
                    <tr class="hover:bg-slate-50/50 transition-colors group">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <img src="https://ui-avatars.com/api/?name=Ahmed+R&background=random" class="h-10 w-10 rounded-full border border-slate-200" alt="">
                                <div>
                                    <span class="block font-bold text-slate-800">Ahmed Repair Works</span>
                                    <span class="text-xs text-slate-500">Plumber • Lahore</span>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center px-2 py-1 rounded-md text-xs font-medium bg-indigo-50 text-indigo-700 border border-indigo-100">
                                Service Provider
                            </span>
                        </td>
                        <td class="px-6 py-4 text-slate-600">
                            7 Days <br>
                            <span class="text-xs text-slate-400">Start: 25 Oct</span>
                        </td>
                        <td class="px-6 py-4 font-bold text-slate-800">Rs. 2,500</td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-1 text-green-600 text-xs font-bold bg-green-50 w-fit px-2 py-1 rounded border border-green-100">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                Paid
                            </div>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex justify-end gap-2">
                                <button class="p-2 rounded-lg text-slate-400 hover:bg-red-50 hover:text-red-600 transition-colors" title="Reject">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                </button>
                                <button class="p-2 rounded-lg text-white bg-blue-600 hover:bg-blue-700 shadow-lg shadow-blue-500/30 transition-all" title="Approve">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                </button>
                            </div>
                        </td>
                    </tr>

                    <tr class="hover:bg-slate-50/50 transition-colors group">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="h-10 w-10 rounded-lg bg-orange-100 flex items-center justify-center text-orange-600 font-bold border border-orange-200">
                                    GM
                                </div>
                                <div>
                                    <span class="block font-bold text-slate-800">Green Mart</span>
                                    <span class="text-xs text-slate-500">Grocery Vendor</span>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center px-2 py-1 rounded-md text-xs font-medium bg-orange-50 text-orange-700 border border-orange-100">
                                Mart Product
                            </span>
                        </td>
                        <td class="px-6 py-4 text-slate-600">
                            30 Days <br>
                            <span class="text-xs text-slate-400">Start: 01 Nov</span>
                        </td>
                        <td class="px-6 py-4 font-bold text-slate-800">Rs. 8,000</td>
                        <td class="px-6 py-4">
                             <div class="flex items-center gap-1 text-slate-500 text-xs font-medium bg-slate-100 w-fit px-2 py-1 rounded border border-slate-200">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                Pending Verification
                            </div>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex justify-end gap-2">
                                <button class="p-2 rounded-lg text-slate-400 hover:bg-red-50 hover:text-red-600 transition-colors" title="Reject">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                </button>
                                <button class="p-2 rounded-lg text-white bg-blue-600 hover:bg-blue-700 shadow-lg shadow-blue-500/30 transition-all" title="Approve">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                </button>
                            </div>
                        </td>
                    </tr>

                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection