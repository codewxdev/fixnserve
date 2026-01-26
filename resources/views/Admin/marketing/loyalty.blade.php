@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-slate-50 py-8 px-4 sm:px-6 lg:px-8">
    
    <div class="flex flex-col md:flex-row justify-between items-center mb-8">
        <div>
            <h1 class="text-3xl font-bold text-slate-800">Loyalty & Rewards</h1>
            <p class="text-slate-500 mt-1">Configure points system and manage user tiers.</p>
        </div>
        <div class="flex items-center bg-white border border-slate-200 rounded-full px-4 py-2 shadow-sm">
            <span class="mr-3 text-sm font-medium text-slate-600">Program Status</span>
            <label class="relative inline-flex items-center cursor-pointer">
                <input type="checkbox" checked class="sr-only peer">
                <div class="w-11 h-6 bg-slate-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
            </label>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
        
        <div class="lg:col-span-1 space-y-6">
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-200 relative overflow-hidden">
                <div class="absolute top-0 right-0 p-4 opacity-10">
                    <svg class="w-20 h-20 text-blue-600" fill="currentColor" viewBox="0 0 20 20"><path d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6zM10 18a3 3 0 01-3-3h6a3 3 0 01-3 3z"/></svg>
                </div>
                <h3 class="text-lg font-bold text-slate-800 mb-4 flex items-center gap-2">
                    <span class="p-1.5 bg-blue-100 text-blue-600 rounded-lg"><svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg></span>
                    Earning Logic
                </h3>
                <div class="space-y-4">
                    <div>
                        <label class="block text-xs font-medium text-slate-500 mb-1 uppercase">Customer Spends (PKR)</label>
                        <div class="flex items-center">
                            <input type="number" value="100" class="w-full bg-slate-50 border border-slate-200 rounded-l-lg px-3 py-2 text-slate-700 focus:outline-none focus:border-blue-500">
                            <span class="bg-slate-100 border border-l-0 border-slate-200 rounded-r-lg px-3 py-2 text-slate-500 text-sm">PKR</span>
                        </div>
                    </div>
                    <div class="flex justify-center text-slate-400">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"/></svg>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-slate-500 mb-1 uppercase">They Earn (Points)</label>
                        <div class="flex items-center">
                            <input type="number" value="1" class="w-full bg-slate-50 border border-slate-200 rounded-l-lg px-3 py-2 text-slate-700 focus:outline-none focus:border-blue-500">
                            <span class="bg-slate-100 border border-l-0 border-slate-200 rounded-r-lg px-3 py-2 text-slate-500 text-sm">PT</span>
                        </div>
                    </div>
                    <button class="w-full py-2 bg-slate-800 hover:bg-slate-700 text-white rounded-lg text-sm transition-colors">Update Rule</button>
                </div>
            </div>

            <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-200 relative overflow-hidden">
                 <h3 class="text-lg font-bold text-slate-800 mb-4 flex items-center gap-2">
                    <span class="p-1.5 bg-green-100 text-green-600 rounded-lg"><svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" /></svg></span>
                    Redemption Value
                </h3>
                <div class="flex items-center justify-between bg-slate-50 p-3 rounded-xl border border-slate-200">
                    <div>
                        <span class="block text-xl font-bold text-slate-800">10 Pts</span>
                        <span class="text-xs text-slate-500">Points Deducted</span>
                    </div>
                    <span class="text-xl font-bold text-slate-300">=</span>
                    <div class="text-right">
                        <span class="block text-xl font-bold text-green-600">1 PKR</span>
                        <span class="text-xs text-slate-500">Wallet Credit</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-200 h-full">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-lg font-bold text-slate-800">Membership Tiers</h3>
                    <button class="text-sm text-blue-600 hover:underline">Edit Requirements</button>
                </div>

                <div class="flex items-center p-4 mb-4 bg-orange-50 border border-orange-100 rounded-xl transition-transform hover:scale-[1.01]">
                    <div class="h-12 w-12 rounded-full bg-gradient-to-br from-orange-400 to-amber-600 flex items-center justify-center text-white shadow-lg shadow-orange-500/30 font-bold text-lg">B</div>
                    <div class="ml-4 flex-1">
                        <h4 class="font-bold text-slate-800">Bronze User</h4>
                        <p class="text-xs text-slate-500">Standard entry level. No spend required.</p>
                    </div>
                    <div class="text-right">
                         <span class="block font-bold text-slate-800">1x</span>
                         <span class="text-xs text-slate-500">Point Multiplier</span>
                    </div>
                </div>

                <div class="flex items-center p-4 mb-4 bg-slate-50 border border-slate-200 rounded-xl transition-transform hover:scale-[1.01]">
                    <div class="h-12 w-12 rounded-full bg-gradient-to-br from-slate-300 to-slate-400 flex items-center justify-center text-white shadow-lg shadow-slate-400/30 font-bold text-lg">S</div>
                    <div class="ml-4 flex-1">
                        <h4 class="font-bold text-slate-800">Silver User</h4>
                        <p class="text-xs text-slate-500">Spend > 50,000 PKR annually.</p>
                    </div>
                    <div class="text-right">
                         <span class="block font-bold text-slate-800">1.2x</span>
                         <span class="text-xs text-slate-500">Point Multiplier</span>
                    </div>
                </div>

                <div class="flex items-center p-4 bg-yellow-50 border border-yellow-100 rounded-xl transition-transform hover:scale-[1.01]">
                    <div class="h-12 w-12 rounded-full bg-gradient-to-br from-yellow-400 to-yellow-600 flex items-center justify-center text-white shadow-lg shadow-yellow-500/30 font-bold text-lg">G</div>
                    <div class="ml-4 flex-1">
                        <h4 class="font-bold text-slate-800">Gold User</h4>
                        <p class="text-xs text-slate-500">Spend > 150,000 PKR annually. Priority Support.</p>
                    </div>
                    <div class="text-right">
                         <span class="block font-bold text-slate-800">2x</span>
                         <span class="text-xs text-slate-500">Point Multiplier</span>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-slate-200">
        <div class="px-6 py-5 border-b border-slate-100">
            <h3 class="font-bold text-slate-800">Real-time Point Ledger</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-slate-600">
                <thead class="bg-slate-50 text-xs uppercase font-semibold text-slate-500">
                    <tr>
                        <th class="px-6 py-4">User</th>
                        <th class="px-6 py-4">Transaction</th>
                        <th class="px-6 py-4">Points</th>
                        <th class="px-6 py-4">Source</th>
                        <th class="px-6 py-4">Date</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="px-6 py-4 font-medium text-slate-800">Ali Khan</td>
                        <td class="px-6 py-4"><span class="text-green-600 bg-green-50 px-2 py-1 rounded text-xs font-bold">EARNED</span></td>
                        <td class="px-6 py-4 font-bold">+120</td>
                        <td class="px-6 py-4 text-xs">Order #ORD-9921 (AC Repair)</td>
                        <td class="px-6 py-4 text-slate-400">2 mins ago</td>
                    </tr>
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="px-6 py-4 font-medium text-slate-800">Sara Ahmed</td>
                        <td class="px-6 py-4"><span class="text-red-600 bg-red-50 px-2 py-1 rounded text-xs font-bold">REDEEMED</span></td>
                        <td class="px-6 py-4 font-bold">-500</td>
                        <td class="px-6 py-4 text-xs">Converted to Wallet Balance</td>
                        <td class="px-6 py-4 text-slate-400">15 mins ago</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection