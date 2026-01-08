@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50/50 p-6 sm:p-10" x-data="{ activeTab: 'professionals' }">
    
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 tracking-tight">Codeworx Developers</h1>
            <p class="text-gray-500 text-sm mt-1">Manage your team, track earnings, and assign projects.</p>
        </div>
        <div class="flex items-center gap-3">
            <span class="text-sm text-gray-500 bg-white px-3 py-1 rounded-full border border-gray-200 shadow-sm">
                Balance: <span class="font-bold text-gray-800">PKR 450,000</span>
            </span>
            <button class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-all shadow-lg shadow-indigo-200">
                + Add New Talent
            </button>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-gradient-to-br from-indigo-500 to-indigo-700 rounded-2xl p-6 text-white shadow-xl shadow-indigo-100 relative overflow-hidden">
            <div class="relative z-10">
                <p class="text-indigo-100 text-xs font-bold uppercase tracking-wider">Total Agency Revenue</p>
                <h3 class="text-3xl font-bold mt-1">PKR 8.2M</h3>
                <p class="text-xs mt-2 text-indigo-200 bg-indigo-600/30 inline-block px-2 py-1 rounded">
                    ▲ 18% vs last month
                </p>
            </div>
            <div class="absolute -right-6 -bottom-10 w-32 h-32 bg-white/10 rounded-full blur-2xl"></div>
        </div>

        <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm hover:shadow-md transition-shadow">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-gray-500 text-xs font-bold uppercase tracking-wider">Active Professionals</p>
                    <h3 class="text-3xl font-bold text-gray-900 mt-1">12</h3>
                </div>
                <div class="p-2 bg-green-50 rounded-lg text-green-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                </div>
            </div>
            <div class="mt-4 flex -space-x-2 overflow-hidden">
                <img class="inline-block h-8 w-8 rounded-full ring-2 ring-white" src="https://ui-avatars.com/api/?name=Ali&bg=random" alt=""/>
                <img class="inline-block h-8 w-8 rounded-full ring-2 ring-white" src="https://ui-avatars.com/api/?name=Sana&bg=random" alt=""/>
                <img class="inline-block h-8 w-8 rounded-full ring-2 ring-white" src="https://ui-avatars.com/api/?name=John&bg=random" alt=""/>
                <span class="inline-flex items-center justify-center h-8 w-8 rounded-full ring-2 ring-white bg-gray-100 text-xs text-gray-500 font-medium">+9</span>
            </div>
        </div>

        <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm hover:shadow-md transition-shadow">
             <div class="flex justify-between items-start">
                <div>
                    <p class="text-gray-500 text-xs font-bold uppercase tracking-wider">Project Completion</p>
                    <h3 class="text-3xl font-bold text-gray-900 mt-1">94%</h3>
                </div>
                <div class="p-2 bg-purple-50 rounded-lg text-purple-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
            </div>
            <div class="w-full bg-gray-200 rounded-full h-1.5 mt-4">
                <div class="bg-purple-600 h-1.5 rounded-full" style="width: 94%"></div>
            </div>
            <p class="text-xs text-gray-400 mt-2">Based on last 50 projects</p>
        </div>
    </div>

    <div class="mb-6">
        <div class="border-b border-gray-200">
            <nav class="-mb-px flex space-x-8" aria-label="Tabs">
                
                <button 
                    @click="activeTab = 'professionals'"
                    :class="activeTab === 'professionals' 
                        ? 'border-indigo-500 text-indigo-600' 
                        : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                    class="group inline-flex items-center py-4 px-1 border-b-2 font-medium text-sm transition-colors">
                    <svg :class="activeTab === 'professionals' ? 'text-indigo-500' : 'text-gray-400'" class="mr-2 h-5 w-5 group-hover:text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                    All Professionals
                    <span class="ml-2 bg-gray-100 text-gray-900 py-0.5 px-2 rounded-full text-xs">12</span>
                </button>

                <button 
                    @click="activeTab = 'sales'"
                    :class="activeTab === 'sales' 
                        ? 'border-indigo-500 text-indigo-600' 
                        : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                    class="group inline-flex items-center py-4 px-1 border-b-2 font-medium text-sm transition-colors">
                    <svg :class="activeTab === 'sales' ? 'text-indigo-500' : 'text-gray-400'" class="mr-2 h-5 w-5 group-hover:text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Sales & Performance
                </button>

                 <button 
                    @click="activeTab = 'projects'"
                    :class="activeTab === 'projects' 
                        ? 'border-indigo-500 text-indigo-600' 
                        : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                    class="group inline-flex items-center py-4 px-1 border-b-2 font-medium text-sm transition-colors">
                    <svg :class="activeTab === 'projects' ? 'text-indigo-500' : 'text-gray-400'" class="mr-2 h-5 w-5 group-hover:text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                    Recent Projects
                </button>
            </nav>
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden min-h-[400px]">
        
        <div x-show="activeTab === 'professionals'" x-transition.opacity.duration.300ms>
            <div class="p-5 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
                <h3 class="font-bold text-gray-800">Team Members</h3>
                <div class="flex gap-2">
                    <input type="text" placeholder="Search name..." class="text-sm border-gray-200 rounded-lg focus:ring-indigo-500 focus:border-indigo-500">
                </div>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-gray-500">
                    <thead class="bg-gray-50 text-xs uppercase text-gray-400 font-medium">
                        <tr>
                            <th class="px-6 py-4">Professional</th>
                            <th class="px-6 py-4">Designation</th>
                            <th class="px-6 py-4">Hourly Rate</th>
                            <th class="px-6 py-4">Total Generated</th>
                            <th class="px-6 py-4">Status</th>
                            <th class="px-6 py-4 text-right">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="relative">
                                        <img class="h-10 w-10 rounded-full object-cover border border-gray-200" src="https://ui-avatars.com/api/?name=Ali+Khan&background=c7d2fe&color=3730a3" alt="">
                                        <span class="absolute bottom-0 right-0 block h-2.5 w-2.5 rounded-full ring-2 ring-white bg-green-400"></span>
                                    </div>
                                    <div>
                                        <div class="font-medium text-gray-900">Ali Khan</div>
                                        <div class="text-xs text-gray-400">Joined Jan 2024</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4"><span class="bg-indigo-50 text-indigo-700 px-2 py-1 rounded-md text-xs font-medium">Snr. Developer</span></td>
                            <td class="px-6 py-4 text-gray-900 font-medium">PKR 3,500/hr</td>
                            <td class="px-6 py-4">
                                <div class="font-bold text-gray-900">PKR 1.2M</div>
                                <div class="text-xs text-green-600">High Performer</div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center rounded-full bg-red-50 px-2 py-1 text-xs font-medium text-red-700 ring-1 ring-inset ring-red-600/10">Busy (Project A)</span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <button class="text-indigo-600 hover:text-indigo-900 font-medium text-xs">Manage</button>
                            </td>
                        </tr>

                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="relative">
                                        <img class="h-10 w-10 rounded-full object-cover border border-gray-200" src="https://ui-avatars.com/api/?name=Sara+Ahmed&background=fce7f3&color=db2777" alt="">
                                        <span class="absolute bottom-0 right-0 block h-2.5 w-2.5 rounded-full ring-2 ring-white bg-green-400"></span>
                                    </div>
                                    <div>
                                        <div class="font-medium text-gray-900">Sara Ahmed</div>
                                        <div class="text-xs text-gray-400">Joined Mar 2024</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4"><span class="bg-pink-50 text-pink-700 px-2 py-1 rounded-md text-xs font-medium">UI/UX Designer</span></td>
                            <td class="px-6 py-4 text-gray-900 font-medium">PKR 2,800/hr</td>
                            <td class="px-6 py-4">
                                <div class="font-bold text-gray-900">PKR 850k</div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center rounded-full bg-green-50 px-2 py-1 text-xs font-medium text-green-700 ring-1 ring-inset ring-green-600/20">Available</span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <button class="text-indigo-600 hover:text-indigo-900 font-medium text-xs">Manage</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div x-show="activeTab === 'sales'" x-transition.opacity.duration.300ms style="display: none;">
            <div class="p-8">
                <h3 class="text-lg font-bold text-gray-900 mb-6">Financial Overview</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="bg-gray-50 rounded-xl p-6 border border-gray-200">
                        <h4 class="text-sm font-bold text-gray-500 uppercase tracking-wide mb-4">Top Revenue Generators</h4>
                        <div class="space-y-4">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-3">
                                    <div class="text-sm font-bold text-gray-900">1. Ali Khan</div>
                                    <span class="text-xs text-gray-500">(Developer)</span>
                                </div>
                                <div class="text-sm font-bold text-green-600">PKR 1.2M</div>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-1.5">
                                <div class="bg-green-500 h-1.5 rounded-full" style="width: 90%"></div>
                            </div>

                            <div class="flex items-center justify-between mt-2">
                                <div class="flex items-center gap-3">
                                    <div class="text-sm font-bold text-gray-900">2. Sara Ahmed</div>
                                    <span class="text-xs text-gray-500">(Designer)</span>
                                </div>
                                <div class="text-sm font-bold text-green-600">PKR 850k</div>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-1.5">
                                <div class="bg-green-500 h-1.5 rounded-full" style="width: 65%"></div>
                            </div>
                        </div>
                    </div>

                    <div class="border border-gray-100 rounded-xl overflow-hidden">
                        <table class="w-full text-sm text-left">
                            <thead class="bg-gray-100 text-gray-500 font-medium">
                                <tr>
                                    <th class="px-4 py-3">Project</th>
                                    <th class="px-4 py-3">Amount</th>
                                    <th class="px-4 py-3">Date</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 bg-white">
                                <tr>
                                    <td class="px-4 py-3">E-commerce App</td>
                                    <td class="px-4 py-3 text-green-600 font-bold">+ 150,000</td>
                                    <td class="px-4 py-3 text-gray-400">Today</td>
                                </tr>
                                <tr>
                                    <td class="px-4 py-3">Logo Design</td>
                                    <td class="px-4 py-3 text-green-600 font-bold">+ 25,000</td>
                                    <td class="px-4 py-3 text-gray-400">Yesterday</td>
                                </tr>
                                <tr>
                                    <td class="px-4 py-3">SEO Consulting</td>
                                    <td class="px-4 py-3 text-green-600 font-bold">+ 40,000</td>
                                    <td class="px-4 py-3 text-gray-400">Jan 5</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div x-show="activeTab === 'projects'" x-transition.opacity.duration.300ms style="display: none;">
             <div class="p-10 text-center text-gray-500">
                <svg class="w-16 h-16 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                <h3 class="text-lg font-medium text-gray-900">Project Timeline</h3>
                <p>This section will show the Kanban board of active projects.</p>
            </div>
        </div>

    </div>
</div>
@endsection