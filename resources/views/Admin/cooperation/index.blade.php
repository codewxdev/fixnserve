@extends('layouts.app')

@section('content')
    {{-- Main Container with Alpine Data for Sidebar --}}
    <div x-data="{ slideOverOpen: false, selectedRequest: null }" class="min-h-screen bg-gray-50 py-8 relative">

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="sm:flex sm:items-center sm:justify-between mb-8">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Cooperation Requests</h1>
                    <p class="mt-2 text-sm text-gray-600">Manage partnership inquiries and agency applications.</p>
                </div>
            </div>

            <div class="grid grid-cols-1 gap-5 sm:grid-cols-3 mb-8">

                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 relative overflow-hidden group">
                    <div
                        class="absolute right-0 top-0 w-24 h-24 bg-yellow-50 rounded-bl-full -mr-4 -mt-4 transition group-hover:bg-yellow-100">
                    </div>
                    <p class="text-gray-500 text-xs font-bold uppercase tracking-wider relative z-10">Pending Requests</p>
                    <h3 class="text-3xl font-bold text-gray-900 mt-2 relative z-10">12</h3>
                    <p class="text-yellow-600 text-xs font-bold mt-2 flex items-center relative z-10">
                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Needs Review
                    </p>
                </div>

                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 relative overflow-hidden group">
                    <div
                        class="absolute right-0 top-0 w-24 h-24 bg-indigo-50 rounded-bl-full -mr-4 -mt-4 transition group-hover:bg-indigo-100">
                    </div>
                    <p class="text-gray-500 text-xs font-bold uppercase tracking-wider relative z-10">Total Partners</p>
                    <h3 class="text-3xl font-bold text-gray-900 mt-2 relative z-10">45</h3>
                    <p class="text-green-500 text-xs font-bold mt-2 flex items-center relative z-10">
                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                        </svg>
                        Dummy text
                    </p>
                </div>

                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 relative overflow-hidden group">
                    <div
                        class="absolute right-0 top-0 w-24 h-24 bg-red-50 rounded-bl-full -mr-4 -mt-4 transition group-hover:bg-red-100">
                    </div>
                    <p class="text-gray-500 text-xs font-bold uppercase tracking-wider relative z-10">Rejected</p>
                    <h3 class="text-3xl font-bold text-gray-900 mt-2 relative z-10">8</h3>
                    <p class="text-red-500 text-xs font-bold mt-2 flex items-center relative z-10">
                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 17h8m0 0V9m0 8l-8-8-4 4-6-6"></path>
                        </svg>
                        Dummy text
                    </p>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div
                    class="p-5 border-b border-gray-200 flex flex-col sm:flex-row gap-4 justify-between items-center bg-gray-50/50">
                    <div class="relative w-full sm:w-96">
                        <input type="text"
                            class="block w-full rounded-lg border-gray-300 pl-10 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm py-2"
                            placeholder="Search requests...">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                    </div>


                    <button type="submit"
                        class="inline-flex items-center gap-2 rounded-lg bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 transition-all active:scale-95">
                        <svg class="h-4 w-4 text-gray-500" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5m-13.5-9L12 3m0 0l4.5 4.5M12 3v13.5" />
                        </svg>
                        Export CSV
                    </button>

                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                    Entity / Module</th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                    Contact Person</th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                    Status</th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                    Submitted</th>
                                <th scope="col"
                                    class="px-6 py-3 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                    Action</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div
                                            class="h-10 w-10 rounded-full bg-blue-100 flex items-center justify-center text-blue-700 font-bold text-sm">
                                            MS
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">Tech Solutions Ltd.</div>
                                            <div class="text-sm text-gray-500">Professional (Consultant)</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    <div>Muhammad Salman</div>
                                    <div class="text-xs text-gray-400">+92 321 9876543</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span
                                        class="inline-flex items-center rounded-full bg-yellow-50 px-2.5 py-0.5 text-xs font-medium text-yellow-800 ring-1 ring-inset ring-yellow-600/20">Pending</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    Jan 7, 2026
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <div class="flex justify-end gap-3 items-center">
                                        <button
                                            class="text-green-600 hover:text-green-900 bg-green-50 p-1.5 rounded-md hover:bg-green-100 transition"
                                            title="Approve">
                                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M5 13l4 4L19 7" />
                                            </svg>
                                        </button>
                                        <button
                                            class="text-red-600 hover:text-red-900 bg-red-50 p-1.5 rounded-md hover:bg-red-100 transition"
                                            title="Reject">
                                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                                                stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M6 18L18 6M6 6l12 12" />
                                            </svg>
                                        </button>
                                        <button @click="slideOverOpen = true"
                                            class="text-indigo-600 hover:text-indigo-900 p-1.5 hover:bg-indigo-50 rounded-md transition"
                                            title="View Details">
                                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                                                stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>

                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div
                                            class="h-10 w-10 rounded-full bg-orange-100 flex items-center justify-center text-orange-700 font-bold text-sm">
                                            ZR
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">Quick Delivery</div>
                                            <div class="text-sm text-gray-500">Rider / Service Provider</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    <div>Zia-ur-Rehman</div>
                                    <div class="text-xs text-gray-400">+92 345 0011223</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span
                                        class="inline-flex items-center rounded-full bg-green-50 px-2.5 py-0.5 text-xs font-medium text-green-800 ring-1 ring-inset ring-green-600/20">Approved</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    Jan 6, 2026
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <div class="flex justify-end gap-3 items-center">
                                        <button
                                            class="text-indigo-600 hover:text-indigo-900 p-1.5 hover:bg-indigo-50 rounded-md transition"
                                            title="View Details">
                                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                                                stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div x-show="slideOverOpen" class="relative z-50" aria-labelledby="slide-over-title" role="dialog"
            aria-modal="true" style="display: none;">
            <div x-show="slideOverOpen" x-transition:enter="ease-in-out duration-500"
                x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                x-transition:leave="ease-in-out duration-500" x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0" class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity">
            </div>

            <div class="fixed inset-0 overflow-hidden">
                <div class="absolute inset-0 overflow-hidden">
                    <div class="pointer-events-none fixed inset-y-0 right-0 flex max-w-full pl-10">

                        <div x-show="slideOverOpen"
                            x-transition:enter="transform transition ease-in-out duration-500 sm:duration-700"
                            x-transition:enter-start="translate-x-full" x-transition:enter-end="translate-x-0"
                            x-transition:leave="transform transition ease-in-out duration-500 sm:duration-700"
                            x-transition:leave-start="translate-x-0" x-transition:leave-end="translate-x-full"
                            @click.away="slideOverOpen = false" class="pointer-events-auto w-screen max-w-md">

                            <div class="flex h-full flex-col overflow-y-scroll bg-white shadow-xl">
                                <div class="px-4 py-6 sm:px-6 bg-indigo-600">
                                    <div class="flex items-start justify-between">
                                        <h2 class="text-base font-semibold leading-6 text-white" id="slide-over-title">
                                            Request Details</h2>
                                        <div class="ml-3 flex h-7 items-center">
                                            <button @click="slideOverOpen = false" type="button"
                                                class="relative rounded-md bg-indigo-600 text-indigo-200 hover:text-white focus:outline-none focus:ring-2 focus:ring-white">
                                                <span class="absolute -inset-2.5"></span>
                                                <span class="sr-only">Close panel</span>
                                                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                                    stroke-width="1.5" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M6 18L18 6M6 6l12 12" />
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="mt-1">
                                        <p class="text-sm text-indigo-100">Full information provided by the agency.</p>
                                    </div>
                                </div>
                                <div class="relative mt-6 flex-1 px-4 sm:px-6">
                                    <div class="flow-root">
                                        <dl class="-my-3 divide-y divide-gray-100 text-sm">
                                            <div class="grid grid-cols-1 gap-1 py-3 sm:grid-cols-3 sm:gap-4">
                                                <dt class="font-medium text-gray-900">Agency Name</dt>
                                                <dd class="text-gray-700 sm:col-span-2">Karachi Associates</dd>
                                            </div>

                                            <div class="grid grid-cols-1 gap-1 py-3 sm:grid-cols-3 sm:gap-4">
                                                <dt class="font-medium text-gray-900">Email</dt>
                                                <dd class="text-gray-700 sm:col-span-2">ahmed@karachiassociates.com</dd>
                                            </div>

                                            <div class="grid grid-cols-1 gap-1 py-3 sm:grid-cols-3 sm:gap-4">
                                                <dt class="font-medium text-gray-900">Phone</dt>
                                                <dd class="text-gray-700 sm:col-span-2">+92 300 1234567</dd>
                                            </div>

                                            <div class="grid grid-cols-1 gap-1 py-3 sm:grid-cols-3 sm:gap-4">
                                                <dt class="font-medium text-gray-900">City</dt>
                                                <dd class="text-gray-700 sm:col-span-2">Karachi, Pakistan</dd>
                                            </div>

                                            <div class="grid grid-cols-1 gap-1 py-3 sm:grid-cols-3 sm:gap-4">
                                                <dt class="font-medium text-gray-900">Message</dt>
                                                <dd class="text-gray-700 sm:col-span-2 text-justify">
                                                    Hum apki B2B partnership join karna chahty hain. Humara focus DHA aur
                                                    Clifton area mein hai aur humare paas 200+ active properties hain.
                                                </dd>
                                            </div>

                                            <div class="grid grid-cols-1 gap-1 py-3 sm:grid-cols-3 sm:gap-4">
                                                <dt class="font-medium text-gray-900">Documents</dt>
                                                <dd class="text-gray-700 sm:col-span-2">
                                                    <ul class="rounded-md border border-gray-200 divide-y divide-gray-100">
                                                        <li
                                                            class="flex items-center justify-between py-2 pl-3 pr-4 text-sm">
                                                            <div class="flex w-0 flex-1 items-center">
                                                                <svg class="h-5 w-5 flex-shrink-0 text-gray-400"
                                                                    viewBox="0 0 20 20" fill="currentColor">
                                                                    <path fill-rule="evenodd"
                                                                        d="M15.621 4.379a3 3 0 00-4.242 0l-7 7a3 3 0 004.241 4.243h.001l.497-.5a.75.75 0 011.064 1.057l-.498.501-.002.002a4.5 4.5 0 01-6.364-6.364l7-7a4.5 4.5 0 016.368 6.36l-3.455 3.553A2.625 2.625 0 119.52 9.52l3.45-3.451a.75.75 0 111.061 1.06l-3.45 3.451a1.125 1.125 0 001.587 1.595l3.454-3.553a3 3 0 000-4.242z"
                                                                        clip-rule="evenodd" />
                                                                </svg>
                                                                <span
                                                                    class="ml-2 w-0 flex-1 truncate">NTN_Certificate.pdf</span>
                                                            </div>
                                                            <div class="ml-4 flex-shrink-0">
                                                                <a href="#"
                                                                    class="font-medium text-indigo-600 hover:text-indigo-500">Download</a>
                                                            </div>
                                                        </li>
                                                    </ul>
                                                </dd>
                                            </div>
                                        </dl>
                                    </div>

                                    <div class="mt-8 pt-4 border-t border-gray-200 flex justify-end gap-3">
                                        <button @click="slideOverOpen = false"
                                            class="px-4 py-2 bg-white text-gray-700 border border-gray-300 rounded-lg text-sm font-medium hover:bg-gray-50">Cancel</button>
                                        <button
                                            class="px-4 py-2 bg-indigo-600 text-white rounded-lg text-sm font-medium hover:bg-indigo-700 shadow-sm">Approve
                                            Request</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
