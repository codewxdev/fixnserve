@extends('layouts.app')

{{-- Assume 'app' layout includes necessary Tailwind CSS and Alpine.js setup --}}

@section('content')

{{-- Alpine.js state for managing the primary navigation (Build vs Logs) and campaign type --}}
<div id="notification-engine-page" 
     class="space-y-6 p-4 md:p-8 bg-gray-50 min-h-screen" 
     x-data="{ 
         mainNav: 'build', 
         currentChannel: 'push',
         isBulk: true 
     }" 
     x-cloak>
    
    {{-- 1. Header and Global Toggle --}}
    <header class="flex flex-col sm:flex-row justify-between items-start sm:items-center pb-4 border-b border-gray-200">
        <div class="mb-4 sm:mb-0">
            <h1 class="text-2xl md:text-3xl font-bold text-gray-900 flex items-center">
                <svg class="w-6 h-6 md:w-8 md:h-8 mr-3 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-2.81c-.13-.26-.2-.544-.2-.835V10c0-1.077-.4-2.078-1.12-2.828l-.134-.134A4.004 4.004 0 0012 4c-1.077 0-2.078.4-2.828 1.12l-.134.134A4.004 4.004 0 008 10v3.355c0 .291-.07.575-.2.835L6 17h5m4 0v2a1 1 0 01-1 1H8a1 1 0 01-1-1v-2m4 0h-4"></path></svg>
                Notification Engine
            </h1>
            <p class="text-xs sm:text-sm text-gray-500 mt-1">Manage multi-channel communications, templates, and targeted campaigns.</p>
        </div>
        
        {{-- Main View Toggle (Build vs Logs) --}}
        <div class="p-1 bg-gray-100 rounded-xl flex space-x-1">
            <button @click="mainNav = 'build'"
                    :class="{'bg-white shadow-md text-red-600': mainNav === 'build', 'text-gray-500': mainNav !== 'build'}"
                    class="px-3 py-2 text-sm font-medium rounded-lg transition duration-200">
                  New Campaign
            </button>
            <button @click="mainNav = 'logs'"
                    :class="{'bg-white shadow-md text-red-600': mainNav === 'logs', 'text-gray-500': mainNav !== 'logs'}"
                    class="px-3 py-2 text-sm font-medium rounded-lg transition duration-200">
                 Logs & History
            </button>
        </div>
    </header>

    {{-- 2. Campaign Builder View --}}
    <div x-show="mainNav === 'build'" class="lg:grid lg:grid-cols-12 lg:gap-8 mt-6">
        
        {{-- Channel Selector (Col 1-3) --}}
        <nav class="lg:col-span-3 space-y-4">
            <h3 class="text-sm font-bold text-red-700 uppercase mb-2">Channels</h3>
            @php
                $channels = [
                    'push' => ['label' => 'Push Notifications', 'color' => 'red'],
                    'sms' => ['label' => 'SMS', 'color' => 'orange'],
                    'email' => ['label' => 'Email', 'color' => 'blue'],
                    'inapp' => ['label' => 'In-App', 'color' => 'purple'],
                ];
            @endphp
            <div class="bg-white p-4 rounded-xl shadow-lg border border-gray-100 space-y-2">
                @foreach($channels as $key => $channel)
                    <button @click="currentChannel = '{{ $key }}'"
                            :class="{'bg-{{ $channel['color'] }}-50 text-{{ $channel['color'] }}-700 font-semibold border-l-4 border-{{ $channel['color'] }}-600': currentChannel === '{{ $key }}', 'text-gray-700 hover:bg-gray-50 border-l-4 border-transparent': currentChannel !== '{{ $key }}'}"
                            class="w-full text-left px-4 py-3 rounded-lg text-sm transition duration-150 ease-in-out">
                        {{ $channel['label'] }}
                    </button>
                @endforeach
            </div>

            {{-- Campaign Type Toggle --}}
            <div class="p-3 bg-gray-100 rounded-xl flex space-x-1 text-sm font-medium">
                 <button @click="isBulk = true"
                    :class="{'bg-white shadow-sm text-red-600': isBulk, 'text-gray-500': !isBulk}"
                    class="flex-1 py-2 rounded-lg transition duration-200">
                    <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20v-2a3 3 0 00-5.356-1.857"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 11A6 6 0 1012 3a6 6 0 00-3 8z"></path></svg>
                    Bulk Campaign
                </button>
                <button @click="isBulk = false"
                    :class="{'bg-white shadow-sm text-red-600': !isBulk, 'text-gray-500': isBulk}"
                    class="flex-1 py-2 rounded-lg transition duration-200">
                    <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                    Single User
                </button>
            </div>
        </nav>

        {{-- Campaign Content Area (Col 4-12) --}}
        <main class="lg:col-span-9 mt-6 lg:mt-0">
            <div class="bg-white p-6 sm:p-8 rounded-xl shadow-2xl border border-gray-100 space-y-8">
                
                {{-- Dynamic Campaign Title --}}
                <h2 class="text-xl md:text-2xl font-bold text-gray-900 border-b pb-3">
                    <span x-text="channels[currentChannel].label">Push Notifications</span> Campaign Builder
                </h2>

                {{-- 2a. Targeting (Segments) --}}
                <div x-show="isBulk" class="space-y-4 p-4 border rounded-xl bg-gray-50">
                    <h3 class="text-lg font-semibold text-gray-800 flex items-center">
                         
                        Target Segments
                    </h3>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                        <label class="inline-flex items-center text-sm font-medium text-gray-700">
                            <input type="checkbox" checked class="form-checkbox text-red-600 rounded-lg border-gray-300 shadow-sm focus:ring-red-500">
                            <span class="ml-2">All Users</span>
                        </label>
                        <label class="inline-flex items-center text-sm font-medium text-gray-700">
                            <input type="checkbox" class="form-checkbox text-red-600 rounded-lg border-gray-300 shadow-sm focus:ring-red-500">
                            <span class="ml-2">UAE Region</span>
                        </label>
                        <label class="inline-flex items-center text-sm font-medium text-gray-700">
                            <input type="checkbox" class="form-checkbox text-red-600 rounded-lg border-gray-300 shadow-sm focus:ring-red-500">
                            <span class="ml-2">KSA Region</span>
                        </label>
                        <label class="inline-flex items-center text-sm font-medium text-gray-700">
                            <input type="checkbox" class="form-checkbox text-red-600 rounded-lg border-gray-300 shadow-sm focus:ring-red-500">
                            <span class="ml-2">AUS Region</span>
                        </label>
                    </div>
                </div>
                
                {{-- 2b. Single User Targeting --}}
                <div x-show="!isBulk" class="space-y-4 p-4 border rounded-xl bg-gray-50">
                    <h3 class="text-lg font-semibold text-gray-800">Single User Target</h3>
                    <input type="email" placeholder="Enter User ID or Email Address" 
                           class="w-full rounded-lg border-gray-300 text-sm focus:border-red-500 focus:ring-red-500">
                </div>
                

                {{-- 2c. Template Selection --}}
                <div class="space-y-4 p-4 border rounded-xl">
                    <h3 class="text-lg font-semibold text-gray-800">Content & Templates</h3>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Load Existing Template</label>
                        <select class="w-full rounded-lg p-3 border-gray-300 text-sm focus:border-red-500 focus:ring-red-500 mt-1">
                            <option>-- Select Template --</option>
                            <option>Order Status Update</option>
                            <option>New Discount Alert (Promo-20)</option>
                        </select>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Notification Title (Push/Email Subject)</label>
                        <input type="text" placeholder="e.g., Your exclusive weekend deal is here!"
                               class="w-full rounded-lg border-gray-300 text-sm focus:border-red-500 focus:ring-red-500 mt-1">
                    </div>

                    <div x-show="currentChannel !== 'email'">
                         <label class="block text-sm font-medium text-gray-700">Message Body</label>
                         <textarea rows="3" placeholder="Enter short message body..."
                                   class="w-full rounded-lg border-gray-300 text-sm focus:border-red-500 focus:ring-red-500 mt-1"></textarea>
                    </div>
                    
                    <div x-show="currentChannel === 'email'">
                         <label class="block text-sm font-medium text-gray-700">Email HTML Body (Advanced)</label>
                         <textarea rows="6" placeholder="Paste HTML or use the rich text editor..."
                                   class="w-full font-mono rounded-lg border-gray-300 text-sm focus:border-red-500 focus:ring-red-500 mt-1"></textarea>
                    </div>
                    
                </div>
                
                {{-- 2d. Schedule & Action --}}
                <div class="flex flex-col md:flex-row justify-between items-center pt-4 border-t border-gray-200">
                    <div class="space-y-2 md:w-1/2 mb-4 md:mb-0">
                        <label class="block text-sm font-medium text-gray-700">Schedule</label>
                        <select class="rounded-lg p-3 border-gray-300 text-sm focus:border-red-500 focus:ring-red-500">
                            <option>Send Now</option>
                            <option>Schedule for Later</option>
                        </select>
                    </div>
                    
                    <button class="w-full md:w-auto px-8 py-3 text-lg font-medium text-white bg-red-600 rounded-xl hover:bg-red-700 shadow-xl transition duration-150 ease-in-out">
                        Send Campaign
                    </button>
                </div>
                
            </div>
        </main>
    </div>
    
    {{-- 3. Logs & History View --}}
    <div x-show="mainNav === 'logs'" class="bg-white p-6 rounded-xl shadow-2xl space-y-6">
        <h2 class="text-2xl font-bold text-red-700"> Notification Logs & History</h2>
        
        {{-- Log Summary Cards --}}
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
            <div class="bg-green-50 p-4 rounded-xl border border-green-200">
                <p class="text-sm font-medium text-gray-500">Sent Last 24h</p>
                <p class="text-2xl font-bold text-green-700 mt-1">12,500</p>
            </div>
            <div class="bg-blue-50 p-4 rounded-xl border border-blue-200">
                <p class="text-sm font-medium text-gray-500">Total Opens/Clicks (Email)</p>
                <p class="text-2xl font-bold text-blue-700 mt-1">45%</p>
            </div>
            <div class="bg-yellow-50 p-4 rounded-xl border border-yellow-200">
                <p class="text-sm font-medium text-gray-500">Retry Queue</p>
                <p class="text-2xl font-bold text-yellow-700 mt-1">85</p>
            </div>
            <div class="bg-red-50 p-4 rounded-xl border border-red-200">
                <p class="text-sm font-medium text-gray-500">Total Failures</p>
                <p class="text-2xl font-bold text-red-700 mt-1">210</p>
            </div>
        </div>
        
        {{-- Log Filters --}}
        <div class="flex space-x-3 pt-4 border-t border-gray-100">
             <select class="form-select rounded-lg text-sm border-gray-300 shadow-sm py-2">
                <option>Filter by Channel</option>
                <option>Push</option>
                <option>Email</option>
            </select>
             <select class="form-select rounded-lg text-sm border-gray-300 shadow-sm py-2">
                <option>Filter by Status</option>
                <option>Success</option>
                <option>Failed</option>
            </select>
        </div>

        {{-- Log Table --}}
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Campaign/Log ID</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Channel</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Target</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Time</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-100">
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">BULK-20251208-01</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-red-600">Push</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">All Users (12,000)</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Completed</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm text-gray-500">5 min ago</td>
                    </tr>
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">LOG-450123</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-blue-600">Email</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">user@example.com</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Failed</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm text-gray-500">1 hour ago</td>
                    </tr>
                </tbody>
            </table>
        </div>
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