@extends('User.layout.app')

@section('content')

    <div class="mb-8">
        <div class="bg-gradient-to-r from-indigo-900 to-indigo-700 rounded-2xl p-6 text-white shadow-lg relative overflow-hidden">
            <div class="absolute top-0 right-0 -mr-16 -mt-16 w-64 h-64 bg-white opacity-5 rounded-full blur-3xl"></div>
            <div class="absolute bottom-0 left-0 -ml-16 -mb-16 w-40 h-40 bg-purple-500 opacity-20 rounded-full blur-2xl"></div>
            
            <div class="relative z-10 flex flex-col md:flex-row justify-between items-center gap-6">
                <div>
                    <h1 class="text-2xl font-bold">Good Morning, Ali! </h1>
                    <p class="text-indigo-200 text-sm mt-1">You have <span class="text-white font-bold underline">2 pending jobs</span> waiting for your approval today.</p>
                </div>
                
                <div class="flex gap-4">
                    <div class="bg-white/10 backdrop-blur-sm p-3 rounded-lg border border-white/10 text-center min-w-[100px]">
                        <p class="text-xs text-indigo-200 uppercase">Today's Earn</p>
                        <p class="text-xl font-bold">$120</p>
                    </div>
                    <div class="bg-white/10 backdrop-blur-sm p-3 rounded-lg border border-white/10 text-center min-w-[100px]">
                        <p class="text-xs text-indigo-200 uppercase">Rating</p>
                        <p class="text-xl font-bold flex justify-center items-center gap-1">4.9 <i class="fas fa-star text-xs text-yellow-400"></i></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <div class="lg:col-span-2 space-y-8">
            
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
                    <h3 class="font-bold text-gray-800"><i class="fas fa-bell text-indigo-500 mr-2"></i>New Job Requests</h3>
                    <span class="bg-indigo-100 text-indigo-700 text-xs font-bold px-2 py-1 rounded-full">2 New</span>
                </div>
                
                <div class="divide-y divide-gray-100">
                    <div class="p-5 hover:bg-gray-50 transition flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                        <div class="flex items-start gap-4">
                            <div class="h-12 w-12 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center text-xl shrink-0">
                                <i class="fas fa-fan"></i>
                            </div>
                            <div>
                                <h4 class="font-bold text-gray-900">AC Repair & Maintenance</h4>
                                <p class="text-sm text-gray-500 mb-1"><i class="fas fa-map-marker-alt mr-1"></i> Bahria Town, Phase 4</p>
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-green-100 text-green-800">
                                  Cash: $45.00
                                </span>
                            </div>
                        </div>
                        <div class="flex gap-2 self-end sm:self-center">
                            <button class="px-4 py-2 border border-gray-300 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-50">Decline</button>
                            <button class="px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-lg hover:bg-indigo-700 shadow-md shadow-indigo-200">Accept Job</button>
                        </div>
                    </div>

                    <div class="p-5 hover:bg-gray-50 transition flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                        <div class="flex items-start gap-4">
                            <div class="h-12 w-12 rounded-lg bg-orange-50 text-orange-600 flex items-center justify-center text-xl shrink-0">
                                <i class="fas fa-wrench"></i>
                            </div>
                            <div>
                                <h4 class="font-bold text-gray-900">Pipeline Leakage Fix</h4>
                                <p class="text-sm text-gray-500 mb-1"><i class="fas fa-map-marker-alt mr-1"></i> Satellite Town, Block B</p>
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-green-100 text-green-800">
                                  Cash: $30.00
                                </span>
                            </div>
                        </div>
                        <div class="flex gap-2 self-end sm:self-center">
                            <button class="px-4 py-2 border border-gray-300 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-50">Decline</button>
                            <button class="px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-lg hover:bg-indigo-700 shadow-md shadow-indigo-200">Accept Job</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-200">
                <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center">
                    <h3 class="font-bold text-gray-800">Active & Recent Orders</h3>
                    <a href="#" class="text-indigo-600 text-sm hover:underline">View All</a>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-500">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                            <tr>
                                <th class="px-6 py-3">Order ID</th>
                                <th class="px-6 py-3">Customer</th>
                                <th class="px-6 py-3">Status</th>
                                <th class="px-6 py-3 text-right">Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="bg-white border-b hover:bg-gray-50">
                                <td class="px-6 py-4 font-medium text-gray-900">#ORD-3321</td>
                                <td class="px-6 py-4">Saad Khan</td>
                                <td class="px-6 py-4"><span class="bg-blue-100 text-blue-800 text-xs font-bold px-2 py-1 rounded">In Progress</span></td>
                                <td class="px-6 py-4 text-right">$50.00</td>
                            </tr>
                            <tr class="bg-white border-b hover:bg-gray-50">
                                <td class="px-6 py-4 font-medium text-gray-900">#ORD-3319</td>
                                <td class="px-6 py-4">Mrs. Ahmed</td>
                                <td class="px-6 py-4"><span class="bg-green-100 text-green-800 text-xs font-bold px-2 py-1 rounded">Completed</span></td>
                                <td class="px-6 py-4 text-right">$120.00</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>

        <div class="space-y-6">

            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="font-bold text-gray-800">Your Wallet</h3>
                    <button class="text-gray-400 hover:text-indigo-600"><i class="fas fa-history"></i></button>
                </div>
                <div class="text-center py-4">
                    <span class="text-gray-400 text-sm uppercase tracking-wider">Available Balance</span>
                    <h2 class="text-4xl font-extrabold text-gray-900 mt-2">$2,450.50</h2>
                </div>
                <button class="w-full py-3 mt-2 bg-gray-900 hover:bg-gray-800 text-white rounded-lg font-bold transition flex items-center justify-center gap-2">
                    <i class="fas fa-university"></i> Withdraw Funds
                </button>
            </div>

            <div class="bg-amber-50 p-6 rounded-xl border border-amber-100 relative overflow-hidden">
                <div class="absolute -right-4 -top-4 text-amber-100 text-9xl z-0">
                    <i class="fas fa-shield-alt"></i>
                </div>
                <div class="relative z-10">
                    <h3 class="font-bold text-amber-900">Action Required</h3>
                    <p class="text-sm text-amber-700 mt-2">Your KYC documents are pending review. You cannot withdraw funds until verified.</p>
                    <button class="mt-4 px-4 py-2 bg-amber-200 text-amber-900 hover:bg-amber-300 rounded-lg text-sm font-bold w-full">
                        Upload Documents
                    </button>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <a href="#" class="p-4 bg-white border border-gray-200 rounded-xl hover:shadow-md hover:border-indigo-200 transition text-center group">
                    <div class="h-10 w-10 mx-auto bg-indigo-50 text-indigo-600 rounded-full flex items-center justify-center group-hover:bg-indigo-600 group-hover:text-white transition">
                        <i class="fas fa-edit"></i>
                    </div>
                    <p class="text-xs font-bold text-gray-700 mt-3">Edit Gigs</p>
                </a>
                <a href="#" class="p-4 bg-white border border-gray-200 rounded-xl hover:shadow-md hover:border-indigo-200 transition text-center group">
                    <div class="h-10 w-10 mx-auto bg-indigo-50 text-indigo-600 rounded-full flex items-center justify-center group-hover:bg-indigo-600 group-hover:text-white transition">
                        <i class="fas fa-crown"></i>
                    </div>
                    <p class="text-xs font-bold text-gray-700 mt-3">Plans</p>
                </a>
            </div>

        </div>
    </div>

@endsection