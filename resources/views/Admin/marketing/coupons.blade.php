@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-slate-50 py-8 px-4 sm:px-6 lg:px-8">
    
    <div class="flex flex-col md:flex-row justify-between items-center mb-8">
        <div>
            <h1 class="text-3xl font-bold text-slate-800">Promo Codes & Coupons</h1>
            <p class="text-slate-500 mt-1">Manage discounts and seasonal offers for Customers and Mart.</p>
        </div>
        <button class="mt-4 md:mt-0 px-6 py-2.5 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-medium rounded-lg shadow-lg shadow-blue-500/30 flex items-center gap-2 transition-all transform hover:scale-105">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Create New Coupon
        </button>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 bg-blue-50 text-blue-600 rounded-lg">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/></svg>
                </div>
                <span class="text-xs font-semibold text-green-600 bg-green-100 px-2 py-1 rounded-full">+12%</span>
            </div>
            <h3 class="text-2xl font-bold text-slate-800">45</h3>
            <p class="text-slate-500 text-sm">Active Coupons</p>
        </div>
        
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 bg-indigo-50 text-indigo-600 rounded-lg">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                </div>
            </div>
            <h3 class="text-2xl font-bold text-slate-800">1,204</h3>
            <p class="text-slate-500 text-sm">Total Redemptions</p>
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
        <div class="p-5 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div class="relative w-full sm:w-72">
                <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                </span>
                <input type="text" class="w-full pl-10 pr-4 py-2 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm placeholder-slate-400 transition-colors" placeholder="Search by code...">
            </div>
            <div class="flex gap-2">
                <select class="px-4 py-2 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-600 focus:ring-blue-500 focus:border-blue-500">
                    <option>All Status</option>
                    <option>Active</option>
                    <option>Expired</option>
                </select>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/50 text-slate-500 text-xs uppercase tracking-wider font-semibold">
                        <th class="px-6 py-4">Code Name</th>
                        <th class="px-6 py-4">Discount</th>
                        <th class="px-6 py-4">Applies To</th>
                        <th class="px-6 py-4">Usage / Limit</th>
                        <th class="px-6 py-4">Validity</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4 text-right">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-sm text-slate-700">
                    <tr class="hover:bg-slate-50/80 transition-colors group">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="h-10 w-10 rounded-lg bg-orange-100 flex items-center justify-center text-orange-600 font-bold border border-orange-200">
                                    SUM
                                </div>
                                <div>
                                    <span class="block font-bold text-slate-800">SUMMER24</span>
                                    <span class="text-xs text-slate-500">Created: 12 Jan 2024</span>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 font-medium text-green-600">20% OFF</td>
                        <td class="px-6 py-4"><span class="px-2.5 py-1 bg-slate-100 text-slate-600 rounded-md text-xs font-medium">AC Services</span></td>
                        <td class="px-6 py-4">
                            <div class="w-24">
                                <div class="flex justify-between text-xs mb-1">
                                    <span>450</span>
                                    <span class="text-slate-400">/ 500</span>
                                </div>
                                <div class="h-1.5 w-full bg-slate-100 rounded-full overflow-hidden">
                                    <div class="h-full bg-blue-500 rounded-full" style="width: 90%"></div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-slate-500">Jan 01 - Feb 01</td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-50 text-green-700 border border-green-100">
                                <span class="w-1.5 h-1.5 rounded-full bg-green-500 mr-1.5"></span> Active
                            </span>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <button class="text-slate-400 hover:text-blue-600 transition-colors p-1">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                            </button>
                        </td>
                    </tr>
                    
                    <tr class="hover:bg-slate-50/80 transition-colors group">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="h-10 w-10 rounded-lg bg-gray-100 flex items-center justify-center text-gray-600 font-bold border border-gray-200">
                                    WEL
                                </div>
                                <div>
                                    <span class="block font-bold text-slate-800">WELCOME</span>
                                    <span class="text-xs text-slate-500">Created: 10 Dec 2023</span>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 font-medium text-slate-600">Flat 500 PKR</td>
                        <td class="px-6 py-4"><span class="px-2.5 py-1 bg-slate-100 text-slate-600 rounded-md text-xs font-medium">All Services</span></td>
                        <td class="px-6 py-4">
                             <div class="w-24">
                                <div class="flex justify-between text-xs mb-1">
                                    <span>1000</span>
                                    <span class="text-slate-400">/ 1000</span>
                                </div>
                                <div class="h-1.5 w-full bg-slate-100 rounded-full overflow-hidden">
                                    <div class="h-full bg-slate-400 rounded-full" style="width: 100%"></div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-slate-500">Dec 10 - Dec 31</td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-slate-100 text-slate-600 border border-slate-200">
                                Expired
                            </span>
                        </td>
                        <td class="px-6 py-4 text-right">
                             <button class="text-slate-400 hover:text-blue-600 transition-colors p-1">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        
        <div class="px-6 py-4 border-t border-slate-100 flex justify-between items-center">
            <span class="text-xs text-slate-500">Showing 1 to 2 of 2 entries</span>
            <div class="flex gap-1">
                <button class="px-3 py-1 rounded-md border border-slate-200 text-slate-500 hover:bg-slate-50 text-xs">Prev</button>
                <button class="px-3 py-1 rounded-md bg-blue-600 text-white text-xs">1</button>
                <button class="px-3 py-1 rounded-md border border-slate-200 text-slate-500 hover:bg-slate-50 text-xs">Next</button>
            </div>
        </div>
    </div>
</div>
@endsection