@extends('layouts.app')


@section('content')

    <body class="bg-fixnserve-bg font-sans" x-data="{ isDrawerOpen: false, selectedOrder: {} }">

        <div class="min-h-screen p-6 md:p-8 lg:p-10">

            <header class="mb-8">
                <nav class="flex text-sm text-gray-500 mb-2">
                    <ol role="list" class="flex items-center space-x-2">
                        <li><a href="#" class="hover:text-fixnserve-primary">Dashboard</a></li>
                        <li>
                            <svg class="h-5 w-5 flex-shrink-0 text-gray-300" viewBox="0 0 20 20" fill="currentColor"
                                aria-hidden="true">
                                <path d="M5.555 17.777l8-16 1 1-8 16z" />
                            </svg>
                        </li>
                        <li class="font-medium text-gray-700">Order History</li>
                    </ol>
                </nav>

                <h1 class="text-3xl font-extrabold text-gray-900 mb-1">Order History</h1>
                <p class="text-gray-500">View, filter, and manage all service, consultation, and mart orders.</p>
            </header>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-6 mb-10">

                <div
                    class="bg-white p-5 rounded-xl shadow-lg border border-gray-100 transition duration-300 hover:shadow-xl">
                    <div class="flex items-start justify-between">
                        <div>
                            <p class="text-3xl font-bold text-gray-900">452</p>
                            <p class="text-sm text-gray-500 mt-1">Total Orders Today</p>
                        </div>
                        <div class="p-3 bg-indigo-100 rounded-full text-indigo-600">
                            <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                        </div>
                    </div>
                </div>

                <div
                    class="bg-white p-5 rounded-xl shadow-lg border border-gray-100 transition duration-300 hover:shadow-xl">
                    <div class="flex items-start justify-between">
                        <div>
                            <p class="text-3xl font-bold text-gray-900">388</p>
                            <p class="text-sm text-gray-500 mt-1">Completed Orders</p>
                        </div>
                        <div class="p-3 bg-green-100 rounded-full text-green-600">
                            <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </div>
                </div>

                <div
                    class="bg-white p-5 rounded-xl shadow-lg border border-gray-100 transition duration-300 hover:shadow-xl">
                    <div class="flex items-start justify-between">
                        <div>
                            <p class="text-3xl font-bold text-gray-900">18</p>
                            <p class="text-sm text-gray-500 mt-1">Cancelled Orders</p>
                        </div>
                        <div class="p-3 bg-red-100 rounded-full text-red-600">
                            <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M9.75 9.75l4.5 4.5m0-4.5l-4.5 4.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </div>
                </div>

                <div
                    class="bg-white p-5 rounded-xl shadow-lg border border-gray-100 transition duration-300 hover:shadow-xl">
                    <div class="flex items-start justify-between">
                        <div>
                            <p class="text-3xl font-bold text-gray-900">4</p>
                            <p class="text-sm text-gray-500 mt-1">Pending Refunds</p>
                        </div>
                        <div class="p-3 bg-yellow-100 rounded-full text-yellow-600">
                            <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </div>
                </div>

                <div
                    class="bg-white p-5 rounded-xl shadow-lg border border-gray-100 transition duration-300 hover:shadow-xl">
                    <div class="flex items-start justify-between">
                        <div>
                            <p class="text-3xl font-bold text-gray-900">$12,450</p>
                            <p class="text-sm text-gray-500 mt-1">Today's Revenue</p>
                        </div>
                        <div class="p-3 bg-blue-100 rounded-full text-blue-600">
                            <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M12 6v12m-3-2.818l-.879-.879m1.569-9.131L12 3.586l2.121 2.121m4.878 4.879l-4.879 4.879m0 0l4.879-4.879m-3-12h8.25c.621 0 1.125.504 1.125 1.125v17.25c0 .621-.504 1.125-1.125 1.125H3.375c-.621 0-1.125-.504-1.125-1.125V3.375c0-.621.504-1.125 1.125-1.125z" />
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white p-6 md:p-8 rounded-xl shadow-2xl shadow-gray-200 border border-gray-100">

                <div class="mb-6 pb-6 border-b border-gray-100">
                    <h3 class="text-xl font-semibold text-gray-800 mb-4">Advanced Filters</h3>
                    <div class="flex flex-wrap items-end gap-3 lg:gap-4">

                        <div class="flex-1 min-w-[200px]">
                            <label for="order-id" class="sr-only">Order ID</label>
                            <div class="relative rounded-full shadow-sm">
                                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                    <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M9 3.5a5.5 5.5 0 100 11 5.5 5.5 0 000-11zM2 9a7 7 0 1112.452 4.391l3.328 3.329a.75.75 0 11-1.06 1.06l-3.329-3.328A7 7 0 012 9z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <input type="text" name="order-id" id="order-id"
                                    class="block w-full rounded-full border-0 py-2 pl-10 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-fixnserve-primary sm:text-sm sm:leading-6"
                                    placeholder="Order ID or Customer Name">
                            </div>
                        </div>

                        <div class="min-w-[150px]">
                            <label for="order-type" class="sr-only">Order Type</label>
                            <select id="order-type" name="order-type"
                                class="block w-full rounded-full border-0 py-2 pl-4 pr-10 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-fixnserve-primary sm:text-sm sm:leading-6">
                                <option>Order Type</option>
                                <option>Service</option>
                                <option>Consultation</option>
                                <option>Mart Order</option>
                                <option>Delivery</option>
                            </select>
                        </div>

                        <div class="min-w-[150px]">
                            <label for="order-status" class="sr-only">Order Status</label>
                            <select id="order-status" name="order-status"
                                class="block w-full rounded-full border-0 py-2 pl-4 pr-10 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-fixnserve-primary sm:text-sm sm:leading-6">
                                <option>Status</option>
                                <option>Completed</option>
                                <option>Pending</option>
                                <option>In Progress</option>
                                <option>Cancelled</option>
                            </select>
                        </div>

                        <div class="min-w-[200px]">
                            <label for="date-range" class="sr-only">Date Range</label>
                            <div class="relative rounded-full shadow-sm">
                                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                    <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <input type="text" id="date-range"
                                    class="block w-full rounded-full border-0 py-2 pl-10 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-fixnserve-primary sm:text-sm sm:leading-6"
                                    placeholder="Date Range">
                            </div>
                        </div>

                        <button type="button"
                            class="inline-flex items-center gap-x-1.5 rounded-full bg-fixnserve-primary px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-emerald-600 transition duration-150">
                            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M2.628 1.636a.75.75 0 00-.898.898l.848 1.696a.75.75 0 001.21-.497l-.848-1.697zM5.592 2.628a.75.75 0 00.497-1.21l-1.697-.848a.75.75 0 10-.497 1.21l1.697.848zM8.5 2.5a.5.5 0 00-1 0v15a.5.5 0 001 0V2.5z"
                                    clip-rule="evenodd" />
                                <path fill-rule="evenodd"
                                    d="M12.5 2.5a.5.5 0 00-1 0v15a.5.5 0 001 0V2.5zM15.864 1.636a.75.75 0 00-.898.898l.848 1.696a.75.75 0 001.21-.497l-.848-1.697zM18.828 2.628a.75.75 0 00.497-1.21l-1.697-.848a.75.75 0 10-.497 1.21l1.697.848z"
                                    clip-rule="evenodd" />
                            </svg>
                            Apply Filters
                        </button>

                        <button type="button"
                            class="inline-flex items-center gap-x-1.5 rounded-full bg-gray-200 px-4 py-2 text-sm font-semibold text-gray-700 shadow-sm hover:bg-gray-300 transition duration-150">
                            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M15.31 4.887a.75.75 0 00-1.06.007L11.5 7.644l-2.75-2.75a.75.75 0 00-1.06 1.06l3.25 3.25a.75.75 0 001.06 0l3.25-3.25a.75.75 0 00.007-1.06zM7.5 14.5a.5.5 0 00-1 0v1.5a.5.5 0 001 0V14.5zM10.5 14.5a.5.5 0 00-1 0v1.5a.5.5 0 001 0V14.5zM13.5 14.5a.5.5 0 00-1 0v1.5a.5.5 0 001 0V14.5z"
                                    clip-rule="evenodd" />
                            </svg>
                            Reset
                        </button>
                    </div>
                </div>

                <h3 class="text-xl font-semibold text-gray-800 mb-4">Orders Data</h3>
                <div class="relative overflow-x-auto custom-scroll rounded-lg shadow-inner border border-gray-100">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50 sticky-header">
                            <tr>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                    Order ID</th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                    Type</th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                    Customer</th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                    Provider / Vendor</th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                    Items / Service</th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                    Order Date</th>
                                <th scope="col"
                                    class="px-6 py-3 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                    Amount</th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                    Status</th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                    Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">

                            <tr class="hover:bg-indigo-50 transition duration-150 cursor-pointer"
                                @click="selectedOrder = { id: 'FS10001', type: 'Service', status: 'Completed' }; isDrawerOpen = true;">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">#FS10001</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span
                                        class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">Service</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">Jane Cooper</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">Electrician Pro</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">A/C Repair - Split Unit</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">2025-12-04</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-right text-gray-900">
                                    $180.00</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span
                                        class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Completed</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex space-x-2">
                                        <button
                                            @click.stop="selectedOrder = { id: 'FS10001', type: 'Service', status: 'Completed' }; isDrawerOpen = true;"
                                            class="text-indigo-600 hover:text-indigo-900 text-xs font-semibold">View
                                            Details</button>
                                        <button
                                            class="text-gray-500 hover:text-gray-700 text-xs font-semibold">Invoice</button>
                                    </div>
                                </td>
                            </tr>

                            <tr class="hover:bg-indigo-50 transition duration-150 cursor-pointer"
                                @click="selectedOrder = { id: 'FS10002', type: 'Mart Order', status: 'Pending' }; isDrawerOpen = true;">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">#FS10002</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span
                                        class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-pink-100 text-pink-800">Mart
                                        Order</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">Robert Fox</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">QuickMart Store</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">3 Items (Groceries)</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">2025-12-04</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-right text-gray-900">$55.50
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span
                                        class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">Pending</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex space-x-2">
                                        <button
                                            @click.stop="selectedOrder = { id: 'FS10002', type: 'Mart Order', status: 'Pending' }; isDrawerOpen = true;"
                                            class="text-indigo-600 hover:text-indigo-900 text-xs font-semibold">View
                                            Details</button>
                                        <button class="text-green-600 hover:text-green-800 text-xs font-semibold">Assign
                                            Rider</button>
                                    </div>
                                </td>
                            </tr>

                            <tr class="hover:bg-indigo-50 transition duration-150 cursor-pointer"
                                @click="selectedOrder = { id: 'FS10003', type: 'Consultation', status: 'Cancelled' }; isDrawerOpen = true;">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">#FS10003</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span
                                        class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-purple-100 text-purple-800">Consultation</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">Jenny Wilson</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">Dr. Sarah Lee</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Video Session (Legal)</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">2025-12-03</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-right text-gray-900">$50.00
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span
                                        class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Cancelled</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex space-x-2">
                                        <button
                                            @click.stop="selectedOrder = { id: 'FS10003', type: 'Consultation', status: 'Cancelled' }; isDrawerOpen = true;"
                                            class="text-indigo-600 hover:text-indigo-900 text-xs font-semibold">View
                                            Details</button>
                                        <button
                                            class="text-red-600 hover:text-red-800 text-xs font-semibold">Refund</button>
                                    </div>
                                </td>
                            </tr>

                        </tbody>
                    </table>
                </div>

                <div
                    class="mt-6 flex items-center justify-between border-t border-gray-200 bg-white px-4 py-3 sm:px-6 rounded-lg shadow-sm">
                    <div class="flex flex-1 justify-between sm:hidden">
                        <a href="#"
                            class="relative inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50">Previous</a>
                        <a href="#"
                            class="relative ml-3 inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50">Next</a>
                    </div>
                    <div class="hidden sm:flex sm:flex-1 sm:items-center sm:justify-between">
                        <div>
                            <p class="text-sm text-gray-700">
                                Showing <span class="font-medium">1</span> to <span class="font-medium">10</span> of <span
                                    class="font-medium">97</span> results
                            </p>
                        </div>
                        <div>
                            <nav class="isolate inline-flex -space-x-px rounded-md shadow-sm" aria-label="Pagination">
                                <a href="#"
                                    class="relative inline-flex items-center rounded-l-md px-2 py-2 text-gray-400 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:z-20 focus:outline-offset-0">
                                    <span class="sr-only">Previous</span>
                                    <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path fill-rule="evenodd"
                                            d="M12.79 5.23a.75.75 0 010 1.06L9.06 10l3.73 3.71a.75.75 0 11-1.06 1.06l-4.25-4.25a.75.75 0 010-1.06l4.25-4.25a.75.75 0 011.06 0z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </a>
                                <a href="#" aria-current="page"
                                    class="relative z-10 inline-flex items-center bg-fixnserve-primary px-4 py-2 text-sm font-semibold text-white focus:z-20 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-fixnserve-primary">1</a>
                                <a href="#"
                                    class="relative inline-flex items-center px-4 py-2 text-sm font-semibold text-gray-900 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:z-20 focus:outline-offset-0">2</a>
                                <span
                                    class="relative inline-flex items-center px-4 py-2 text-sm font-semibold text-gray-700 ring-1 ring-inset ring-gray-300 focus:outline-offset-0">...</span>
                                <a href="#"
                                    class="relative inline-flex items-center px-4 py-2 text-sm font-semibold text-gray-900 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:z-20 focus:outline-offset-0">10</a>
                                <a href="#"
                                    class="relative inline-flex items-center rounded-r-md px-2 py-2 text-gray-400 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:z-20 focus:outline-offset-0">
                                    <span class="sr-only">Next</span>
                                    <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path fill-rule="evenodd"
                                            d="M7.21 14.77a.75.75 0 010-1.06L10.94 10 7.21 6.29a.75.75 0 111.06-1.06l4.25 4.25a.75.75 0 010 1.06l-4.25 4.25a.75.75 0 01-1.06 0z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </a>
                            </nav>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <div x-cloak x-show="isDrawerOpen" x-transition:enter="transition ease-in-out duration-500"
            x-transition:enter-start="translate-x-full" x-transition:enter-end="translate-x-0"
            x-transition:leave="transition ease-in-out duration-500" x-transition:leave-start="translate-x-0"
            x-transition:leave-end="translate-x-full" class="fixed inset-0 overflow-hidden z-40">
            <div class="absolute inset-0 overflow-hidden">
                <div x-show="isDrawerOpen" x-transition.opacity @click="isDrawerOpen = false"
                    class="absolute inset-0 bg-gray-900 bg-opacity-75 transition-opacity"></div>

                <section class="absolute inset-y-0 right-0 max-w-full flex">
                    <div class="w-screen max-w-md">
                        <div class="h-full flex flex-col bg-white shadow-xl rounded-l-2xl">

                            <div class="px-6 py-6 border-b border-gray-200 bg-gray-50 rounded-tl-2xl">
                                <div class="flex items-start justify-between">
                                    <h2 class="text-xl font-bold text-gray-900">Order Details - <span
                                            x-text="selectedOrder.id || 'N/A'"></span></h2>
                                    <div class="ml-3 flex h-7 items-center">
                                        <button type="button"
                                            class="relative rounded-md bg-white text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                                            @click="isDrawerOpen = false">
                                            <span class="absolute -inset-2.5"></span>
                                            <span class="sr-only">Close panel</span>
                                            <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none"
                                                viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                                aria-hidden="true">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M6 18L18 6M6 6l12 12" />
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                                <p class="text-sm text-gray-500 mt-1">Status:
                                    <span class="font-semibold"
                                        :class="{
                                            'text-green-600': selectedOrder.status === 'Completed',
                                            'text-yellow-600': selectedOrder.status === 'Pending',
                                            'text-red-600': selectedOrder.status === 'Cancelled'
                                        }"
                                        x-text="selectedOrder.status"></span>
                                </p>
                            </div>

                            <div class="flex-1 overflow-y-auto">
                                <div class="p-6 space-y-8">

                                    <div>
                                        <h3 class="text-lg font-semibold text-gray-900 mb-3 flex items-center">
                                            <svg class="h-5 w-5 mr-2 text-indigo-500" xmlns="http://www.w3.org/2000/svg"
                                                viewBox="0 0 20 20" fill="currentColor">
                                                <path
                                                    d="M10 8a3 3 0 100-6 3 3 0 000 6zM3.465 17.567A2.396 2.396 0 015 16.5v-1.897a2.5 2.5 0 01-.25-4.873c.42-.42 1.05-.75 1.766-.828a5 5 0 116.55 0c.716.078 1.346.408 1.766.828a2.5 2.5 0 01-.25 4.873V16.5a2.396 2.396 0 011.535 1.067A10 10 0 103.465 17.567z" />
                                            </svg>
                                            Customer & Vendor Info
                                        </h3>
                                        <dl class="text-sm grid grid-cols-2 gap-x-4 gap-y-2">
                                            <dt class="font-medium text-gray-500">Customer Name:</dt>
                                            <dd class="font-semibold text-gray-900">Jane Cooper</dd>
                                            <dt class="font-medium text-gray-500">Phone:</dt>
                                            <dd class="font-semibold text-gray-900">+1 555-123-4567</dd>
                                            <dt class="font-medium text-gray-500"
                                                x-text="selectedOrder.type === 'Mart Order' ? 'Vendor Name:' : 'Provider/Consultant:'">
                                            </dt>
                                            <dd class="font-semibold text-gray-900">Electrician Pro</dd>
                                            <dt class="font-medium text-gray-500">Order Type:</dt>
                                            <dd class="font-semibold text-gray-900" x-text="selectedOrder.type"></dd>
                                        </dl>
                                    </div>
                                    <div class="border-t border-gray-200"></div>

                                    <div>
                                        <h3 class="text-lg font-semibold text-gray-900 mb-3 flex items-center">
                                            <svg class="h-5 w-5 mr-2 text-green-500" xmlns="http://www.w3.org/2000/svg"
                                                viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd"
                                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zM6 9a.75.75 0 000 1.5h4.5a.75.75 0 00.75-.75V7.5a.75.75 0 00-1.5 0v1.5H6zM11 5.25a.75.75 0 00-.75.75v1.5a.75.75 0 001.5 0V6a.75.75 0 00-.75-.75z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                            Pricing Breakdown
                                        </h3>
                                        <dl class="text-sm space-y-1">
                                            <div class="flex justify-between">
                                                <dt class="text-gray-500">Service/Item Subtotal:</dt>
                                                <dd class="text-gray-700">$165.00</dd>
                                            </div>
                                            <div class="flex justify-between">
                                                <dt class="text-gray-500">Tax (7%):</dt>
                                                <dd class="text-gray-700">$11.55</dd>
                                            </div>
                                            <div class="flex justify-between">
                                                <dt class="text-gray-500">Platform Fee:</dt>
                                                <dd class="text-gray-700">$3.45</dd>
                                            </div>
                                            <div class="flex justify-between border-t border-dashed pt-2">
                                                <dt class="font-bold text-base text-gray-900">Total Paid:</dt>
                                                <dd class="font-bold text-base text-green-600">$180.00</dd>
                                            </div>
                                        </dl>
                                    </div>
                                    <div class="border-t border-gray-200"></div>

                                    <div>
                                        <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                                            <svg class="h-5 w-5 mr-2 text-yellow-500" xmlns="http://www.w3.org/2000/svg"
                                                viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd"
                                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm-1-7h2V8h-2v3zm0 4h2v-1h-2v1z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                            Order Timeline
                                        </h3>
                                        <ol role="list" class="space-y-4">
                                            <li class="relative pb-8">
                                                <div
                                                    class="absolute top-0 left-0 -ml-px mt-0.5 h-full w-0.5 bg-fixnserve-primary">
                                                </div>
                                                <div class="relative flex space-x-3">
                                                    <div
                                                        class="h-6 w-6 rounded-full bg-fixnserve-primary flex items-center justify-center text-white font-bold text-xs">
                                                        ✓</div>
                                                    <div class="min-w-0 flex-1 pt-0.5">
                                                        <p class="text-sm font-medium text-gray-900">Order Placed</p>
                                                        <p class="text-sm text-gray-500">Dec 4, 2025 at 10:00 AM</p>
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="relative pb-8">
                                                <div class="absolute top-0 left-0 -ml-px mt-0.5 h-full w-0.5 bg-gray-200">
                                                </div>
                                                <div class="relative flex space-x-3">
                                                    <div
                                                        class="h-6 w-6 rounded-full bg-yellow-400 flex items-center justify-center text-white font-bold text-xs">
                                                        !</div>
                                                    <div class="min-w-0 flex-1 pt-0.5">
                                                        <p class="text-sm font-medium text-gray-900">In Progress (Service
                                                            Started)</p>
                                                        <p class="text-sm text-gray-500">Dec 4, 2025 at 11:30 AM</p>
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="relative">
                                                <div class="relative flex space-x-3">
                                                    <div
                                                        class="h-6 w-6 rounded-full ring-4 ring-gray-100 bg-white border-2 border-gray-300">
                                                    </div>
                                                    <div class="min-w-0 flex-1 pt-0.5">
                                                        <p class="text-sm font-medium text-gray-500">Completed / Delivered
                                                        </p>
                                                    </div>
                                                </div>
                                            </li>
                                        </ol>
                                    </div>
                                    <div class="border-t border-gray-200"></div>

                                    <div>
                                        <h3 class="text-lg font-semibold text-gray-900 mb-3 flex items-center">
                                            <svg class="h-5 w-5 mr-2 text-red-500" xmlns="http://www.w3.org/2000/svg"
                                                viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd"
                                                    d="M9.69 1.62l-4.5 9a1 1 0 00.95 1.38H7v3a1 1 0 002 0v-3h2v3a1 1 0 002 0v-3h.86a1 1 0 00.95-1.38l-4.5-9a1 1 0 00-1.88 0z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                            Rider Tracking
                                        </h3>
                                        <div
                                            class="h-40 bg-gray-200 rounded-xl flex items-center justify-center text-gray-500 text-sm italic">

                                        </div>
                                    </div>

                                    <div x-show="selectedOrder.status === 'Cancelled'"
                                        class="bg-red-50 p-4 rounded-xl border border-red-200">
                                        <h4 class="font-bold text-red-800 flex items-center mb-2">
                                            <svg class="h-5 w-5 mr-1" xmlns="http://www.w3.org/2000/svg"
                                                viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd"
                                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.28 7.22a.75.75 0 00-1.06 1.06L8.94 10l-1.72 1.72a.75.75 0 101.06 1.06L10 11.06l1.72 1.72a.75.75 0 101.06-1.06L11.06 10l1.72-1.72a.75.75 0 00-1.06-1.06L10 8.94l-1.72-1.72z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                            Cancellation & Refund Required
                                        </h4>
                                        <p class="text-sm text-red-700">Reason: Customer changed mind. Refund requested:
                                            **$180.00**.</p>
                                        <button type="button"
                                            class="mt-3 text-sm font-semibold text-white bg-red-600 hover:bg-red-700 px-3 py-1.5 rounded-lg shadow transition duration-150">Process
                                            Refund Now</button>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>

    </body>
@endsection

@push('styles')
@endpush

@push('scripts')
    <script></script>
@endpush
{{-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FixnServe Admin - Order History</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        
    </style>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'fixnserve-primary': '#10B981', // Emerald 500
                        'fixnserve-bg': '#F8FAFC', // Slate 50
                    }
                }
            }
        }
    </script>
</head> --}}

<body class="bg-fixnserve-bg font-sans" x-data="{ isDrawerOpen: false, selectedOrder: {} }">

    <div class="min-h-screen p-6 md:p-8 lg:p-10">

        <header class="mb-8">
            <nav class="flex text-sm text-gray-500 mb-2">
                <ol role="list" class="flex items-center space-x-2">
                    <li><a href="#" class="hover:text-fixnserve-primary">Dashboard</a></li>
                    <li>
                        <svg class="h-5 w-5 flex-shrink-0 text-gray-300" viewBox="0 0 20 20" fill="currentColor"
                            aria-hidden="true">
                            <path d="M5.555 17.777l8-16 1 1-8 16z" />
                        </svg>
                    </li>
                    <li class="font-medium text-gray-700">Order History</li>
                </ol>
            </nav>

            <h1 class="text-3xl font-extrabold text-gray-900 mb-1">Order History</h1>
            <p class="text-gray-500">View, filter, and manage all service, consultation, and mart orders.</p>
        </header>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-6 mb-10">

            <div
                class="bg-white p-5 rounded-xl shadow-lg border border-gray-100 transition duration-300 hover:shadow-xl">
                <div class="flex items-start justify-between">
                    <div>
                        <p class="text-3xl font-bold text-gray-900">452</p>
                        <p class="text-sm text-gray-500 mt-1">Total Orders Today</p>
                    </div>
                    <div class="p-3 bg-indigo-100 rounded-full text-indigo-600">
                        <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </div>
                </div>
            </div>

            <div
                class="bg-white p-5 rounded-xl shadow-lg border border-gray-100 transition duration-300 hover:shadow-xl">
                <div class="flex items-start justify-between">
                    <div>
                        <p class="text-3xl font-bold text-gray-900">388</p>
                        <p class="text-sm text-gray-500 mt-1">Completed Orders</p>
                    </div>
                    <div class="p-3 bg-green-100 rounded-full text-green-600">
                        <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
            </div>

            <div
                class="bg-white p-5 rounded-xl shadow-lg border border-gray-100 transition duration-300 hover:shadow-xl">
                <div class="flex items-start justify-between">
                    <div>
                        <p class="text-3xl font-bold text-gray-900">18</p>
                        <p class="text-sm text-gray-500 mt-1">Cancelled Orders</p>
                    </div>
                    <div class="p-3 bg-red-100 rounded-full text-red-600">
                        <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M9.75 9.75l4.5 4.5m0-4.5l-4.5 4.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
            </div>

            <div
                class="bg-white p-5 rounded-xl shadow-lg border border-gray-100 transition duration-300 hover:shadow-xl">
                <div class="flex items-start justify-between">
                    <div>
                        <p class="text-3xl font-bold text-gray-900">4</p>
                        <p class="text-sm text-gray-500 mt-1">Pending Refunds</p>
                    </div>
                    <div class="p-3 bg-yellow-100 rounded-full text-yellow-600">
                        <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
            </div>

            <div
                class="bg-white p-5 rounded-xl shadow-lg border border-gray-100 transition duration-300 hover:shadow-xl">
                <div class="flex items-start justify-between">
                    <div>
                        <p class="text-3xl font-bold text-gray-900">$12,450</p>
                        <p class="text-sm text-gray-500 mt-1">Today's Revenue</p>
                    </div>
                    <div class="p-3 bg-blue-100 rounded-full text-blue-600">
                        <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 6v12m-3-2.818l-.879-.879m1.569-9.131L12 3.586l2.121 2.121m4.878 4.879l-4.879 4.879m0 0l4.879-4.879m-3-12h8.25c.621 0 1.125.504 1.125 1.125v17.25c0 .621-.504 1.125-1.125 1.125H3.375c-.621 0-1.125-.504-1.125-1.125V3.375c0-.621.504-1.125 1.125-1.125z" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white p-6 md:p-8 rounded-xl shadow-2xl shadow-gray-200 border border-gray-100">

            <div class="mb-6 pb-6 border-b border-gray-100">
                <h3 class="text-xl font-semibold text-gray-800 mb-4">Advanced Filters</h3>
                <div class="flex flex-wrap items-end gap-3 lg:gap-4">

                    <div class="flex-1 min-w-[200px]">
                        <label for="order-id" class="sr-only">Order ID</label>
                        <div class="relative rounded-full shadow-sm">
                            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M9 3.5a5.5 5.5 0 100 11 5.5 5.5 0 000-11zM2 9a7 7 0 1112.452 4.391l3.328 3.329a.75.75 0 11-1.06 1.06l-3.329-3.328A7 7 0 012 9z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                            <input type="text" name="order-id" id="order-id"
                                class="block w-full rounded-full border-0 py-2 pl-10 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-fixnserve-primary sm:text-sm sm:leading-6"
                                placeholder="Order ID or Customer Name">
                        </div>
                    </div>

                    <div class="min-w-[150px]">
                        <label for="order-type" class="sr-only">Order Type</label>
                        <select id="order-type" name="order-type"
                            class="block w-full rounded-full border-0 py-2 pl-4 pr-10 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-fixnserve-primary sm:text-sm sm:leading-6">
                            <option>Order Type</option>
                            <option>Service</option>
                            <option>Consultation</option>
                            <option>Mart Order</option>
                            <option>Delivery</option>
                        </select>
                    </div>

                    <div class="min-w-[150px]">
                        <label for="order-status" class="sr-only">Order Status</label>
                        <select id="order-status" name="order-status"
                            class="block w-full rounded-full border-0 py-2 pl-4 pr-10 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-fixnserve-primary sm:text-sm sm:leading-6">
                            <option>Status</option>
                            <option>Completed</option>
                            <option>Pending</option>
                            <option>In Progress</option>
                            <option>Cancelled</option>
                        </select>
                    </div>

                    <div class="min-w-[200px]">
                        <label for="date-range" class="sr-only">Date Range</label>
                        <div class="relative rounded-full shadow-sm">
                            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                            <input type="text" id="date-range"
                                class="block w-full rounded-full border-0 py-2 pl-10 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-fixnserve-primary sm:text-sm sm:leading-6"
                                placeholder="Date Range">
                        </div>
                    </div>

                    <button type="button"
                        class="inline-flex items-center gap-x-1.5 rounded-full bg-fixnserve-primary px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-emerald-600 transition duration-150">
                        <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                            fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M2.628 1.636a.75.75 0 00-.898.898l.848 1.696a.75.75 0 001.21-.497l-.848-1.697zM5.592 2.628a.75.75 0 00.497-1.21l-1.697-.848a.75.75 0 10-.497 1.21l1.697.848zM8.5 2.5a.5.5 0 00-1 0v15a.5.5 0 001 0V2.5z"
                                clip-rule="evenodd" />
                            <path fill-rule="evenodd"
                                d="M12.5 2.5a.5.5 0 00-1 0v15a.5.5 0 001 0V2.5zM15.864 1.636a.75.75 0 00-.898.898l.848 1.696a.75.75 0 001.21-.497l-.848-1.697zM18.828 2.628a.75.75 0 00.497-1.21l-1.697-.848a.75.75 0 10-.497 1.21l1.697.848z"
                                clip-rule="evenodd" />
                        </svg>
                        Apply Filters
                    </button>

                    <button type="button"
                        class="inline-flex items-center gap-x-1.5 rounded-full bg-gray-200 px-4 py-2 text-sm font-semibold text-gray-700 shadow-sm hover:bg-gray-300 transition duration-150">
                        <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                            fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M15.31 4.887a.75.75 0 00-1.06.007L11.5 7.644l-2.75-2.75a.75.75 0 00-1.06 1.06l3.25 3.25a.75.75 0 001.06 0l3.25-3.25a.75.75 0 00.007-1.06zM7.5 14.5a.5.5 0 00-1 0v1.5a.5.5 0 001 0V14.5zM10.5 14.5a.5.5 0 00-1 0v1.5a.5.5 0 001 0V14.5zM13.5 14.5a.5.5 0 00-1 0v1.5a.5.5 0 001 0V14.5z"
                                clip-rule="evenodd" />
                        </svg>
                        Reset
                    </button>
                </div>
            </div>

            <h3 class="text-xl font-semibold text-gray-800 mb-4">Orders Data</h3>
            <div class="relative overflow-x-auto custom-scroll rounded-lg shadow-inner border border-gray-100">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50 sticky-header">
                        <tr>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                Order ID</th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                Type</th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                Customer</th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                Provider / Vendor</th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                Items / Service</th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                Order Date</th>
                            <th scope="col"
                                class="px-6 py-3 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                Amount</th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                Status</th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">

                        <tr class="hover:bg-indigo-50 transition duration-150 cursor-pointer"
                            @click="selectedOrder = { id: 'FS10001', type: 'Service', status: 'Completed' }; isDrawerOpen = true;">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">#FS10001</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span
                                    class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">Service</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">Jane Cooper</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">Electrician Pro</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">A/C Repair - Split Unit</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">2025-12-04</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-right text-gray-900">
                                $180.00</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span
                                    class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Completed</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex space-x-2">
                                    <button
                                        @click.stop="selectedOrder = { id: 'FS10001', type: 'Service', status: 'Completed' }; isDrawerOpen = true;"
                                        class="text-indigo-600 hover:text-indigo-900 text-xs font-semibold">View
                                        Details</button>
                                    <button
                                        class="text-gray-500 hover:text-gray-700 text-xs font-semibold">Invoice</button>
                                </div>
                            </td>
                        </tr>

                        <tr class="hover:bg-indigo-50 transition duration-150 cursor-pointer"
                            @click="selectedOrder = { id: 'FS10002', type: 'Mart Order', status: 'Pending' }; isDrawerOpen = true;">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">#FS10002</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span
                                    class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-pink-100 text-pink-800">Mart
                                    Order</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">Robert Fox</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">QuickMart Store</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">3 Items (Groceries)</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">2025-12-04</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-right text-gray-900">$55.50
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span
                                    class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">Pending</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex space-x-2">
                                    <button
                                        @click.stop="selectedOrder = { id: 'FS10002', type: 'Mart Order', status: 'Pending' }; isDrawerOpen = true;"
                                        class="text-indigo-600 hover:text-indigo-900 text-xs font-semibold">View
                                        Details</button>
                                    <button class="text-green-600 hover:text-green-800 text-xs font-semibold">Assign
                                        Rider</button>
                                </div>
                            </td>
                        </tr>

                        <tr class="hover:bg-indigo-50 transition duration-150 cursor-pointer"
                            @click="selectedOrder = { id: 'FS10003', type: 'Consultation', status: 'Cancelled' }; isDrawerOpen = true;">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">#FS10003</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span
                                    class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-purple-100 text-purple-800">Consultation</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">Jenny Wilson</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">Dr. Sarah Lee</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Video Session (Legal)</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">2025-12-03</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-right text-gray-900">$50.00
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span
                                    class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Cancelled</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex space-x-2">
                                    <button
                                        @click.stop="selectedOrder = { id: 'FS10003', type: 'Consultation', status: 'Cancelled' }; isDrawerOpen = true;"
                                        class="text-indigo-600 hover:text-indigo-900 text-xs font-semibold">View
                                        Details</button>
                                    <button
                                        class="text-red-600 hover:text-red-800 text-xs font-semibold">Refund</button>
                                </div>
                            </td>
                        </tr>

                    </tbody>
                </table>
            </div>

            <div
                class="mt-6 flex items-center justify-between border-t border-gray-200 bg-white px-4 py-3 sm:px-6 rounded-lg shadow-sm">
                <div class="flex flex-1 justify-between sm:hidden">
                    <a href="#"
                        class="relative inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50">Previous</a>
                    <a href="#"
                        class="relative ml-3 inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50">Next</a>
                </div>
                <div class="hidden sm:flex sm:flex-1 sm:items-center sm:justify-between">
                    <div>
                        <p class="text-sm text-gray-700">
                            Showing <span class="font-medium">1</span> to <span class="font-medium">10</span> of <span
                                class="font-medium">97</span> results
                        </p>
                    </div>
                    <div>
                        <nav class="isolate inline-flex -space-x-px rounded-md shadow-sm" aria-label="Pagination">
                            <a href="#"
                                class="relative inline-flex items-center rounded-l-md px-2 py-2 text-gray-400 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:z-20 focus:outline-offset-0">
                                <span class="sr-only">Previous</span>
                                <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd"
                                        d="M12.79 5.23a.75.75 0 010 1.06L9.06 10l3.73 3.71a.75.75 0 11-1.06 1.06l-4.25-4.25a.75.75 0 010-1.06l4.25-4.25a.75.75 0 011.06 0z"
                                        clip-rule="evenodd" />
                                </svg>
                            </a>
                            <a href="#" aria-current="page"
                                class="relative z-10 inline-flex items-center bg-fixnserve-primary px-4 py-2 text-sm font-semibold text-white focus:z-20 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-fixnserve-primary">1</a>
                            <a href="#"
                                class="relative inline-flex items-center px-4 py-2 text-sm font-semibold text-gray-900 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:z-20 focus:outline-offset-0">2</a>
                            <span
                                class="relative inline-flex items-center px-4 py-2 text-sm font-semibold text-gray-700 ring-1 ring-inset ring-gray-300 focus:outline-offset-0">...</span>
                            <a href="#"
                                class="relative inline-flex items-center px-4 py-2 text-sm font-semibold text-gray-900 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:z-20 focus:outline-offset-0">10</a>
                            <a href="#"
                                class="relative inline-flex items-center rounded-r-md px-2 py-2 text-gray-400 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:z-20 focus:outline-offset-0">
                                <span class="sr-only">Next</span>
                                <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd"
                                        d="M7.21 14.77a.75.75 0 010-1.06L10.94 10 7.21 6.29a.75.75 0 111.06-1.06l4.25 4.25a.75.75 0 010 1.06l-4.25 4.25a.75.75 0 01-1.06 0z"
                                        clip-rule="evenodd" />
                                </svg>
                            </a>
                        </nav>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <div x-cloak x-show="isDrawerOpen" x-transition:enter="transition ease-in-out duration-500"
        x-transition:enter-start="translate-x-full" x-transition:enter-end="translate-x-0"
        x-transition:leave="transition ease-in-out duration-500" x-transition:leave-start="translate-x-0"
        x-transition:leave-end="translate-x-full" class="fixed inset-0 overflow-hidden z-40">
        <div class="absolute inset-0 overflow-hidden">
            <div x-show="isDrawerOpen" x-transition.opacity @click="isDrawerOpen = false"
                class="absolute inset-0 bg-gray-900 bg-opacity-75 transition-opacity"></div>

            <section class="absolute inset-y-0 right-0 max-w-full flex">
                <div class="w-screen max-w-md">
                    <div class="h-full flex flex-col bg-white shadow-xl rounded-l-2xl">

                        <div class="px-6 py-6 border-b border-gray-200 bg-gray-50 rounded-tl-2xl">
                            <div class="flex items-start justify-between">
                                <h2 class="text-xl font-bold text-gray-900">Order Details - <span
                                        x-text="selectedOrder.id || 'N/A'"></span></h2>
                                <div class="ml-3 flex h-7 items-center">
                                    <button type="button"
                                        class="relative rounded-md bg-white text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                                        @click="isDrawerOpen = false">
                                        <span class="absolute -inset-2.5"></span>
                                        <span class="sr-only">Close panel</span>
                                        <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none"
                                            viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                            aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                            <p class="text-sm text-gray-500 mt-1">Status:
                                <span class="font-semibold"
                                    :class="{
                                        'text-green-600': selectedOrder.status === 'Completed',
                                        'text-yellow-600': selectedOrder.status === 'Pending',
                                        'text-red-600': selectedOrder.status === 'Cancelled'
                                    }"
                                    x-text="selectedOrder.status"></span>
                            </p>
                        </div>

                        <div class="flex-1 overflow-y-auto">
                            <div class="p-6 space-y-8">

                                <div>
                                    <h3 class="text-lg font-semibold text-gray-900 mb-3 flex items-center">
                                        <svg class="h-5 w-5 mr-2 text-indigo-500" xmlns="http://www.w3.org/2000/svg"
                                            viewBox="0 0 20 20" fill="currentColor">
                                            <path
                                                d="M10 8a3 3 0 100-6 3 3 0 000 6zM3.465 17.567A2.396 2.396 0 015 16.5v-1.897a2.5 2.5 0 01-.25-4.873c.42-.42 1.05-.75 1.766-.828a5 5 0 116.55 0c.716.078 1.346.408 1.766.828a2.5 2.5 0 01-.25 4.873V16.5a2.396 2.396 0 011.535 1.067A10 10 0 103.465 17.567z" />
                                        </svg>
                                        Customer & Vendor Info
                                    </h3>
                                    <dl class="text-sm grid grid-cols-2 gap-x-4 gap-y-2">
                                        <dt class="font-medium text-gray-500">Customer Name:</dt>
                                        <dd class="font-semibold text-gray-900">Jane Cooper</dd>
                                        <dt class="font-medium text-gray-500">Phone:</dt>
                                        <dd class="font-semibold text-gray-900">+1 555-123-4567</dd>
                                        <dt class="font-medium text-gray-500"
                                            x-text="selectedOrder.type === 'Mart Order' ? 'Vendor Name:' : 'Provider/Consultant:'">
                                        </dt>
                                        <dd class="font-semibold text-gray-900">Electrician Pro</dd>
                                        <dt class="font-medium text-gray-500">Order Type:</dt>
                                        <dd class="font-semibold text-gray-900" x-text="selectedOrder.type"></dd>
                                    </dl>
                                </div>
                                <div class="border-t border-gray-200"></div>

                                <div>
                                    <h3 class="text-lg font-semibold text-gray-900 mb-3 flex items-center">
                                        <svg class="h-5 w-5 mr-2 text-green-500" xmlns="http://www.w3.org/2000/svg"
                                            viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd"
                                                d="M10 18a8 8 0 100-16 8 8 0 000 16zM6 9a.75.75 0 000 1.5h4.5a.75.75 0 00.75-.75V7.5a.75.75 0 00-1.5 0v1.5H6zM11 5.25a.75.75 0 00-.75.75v1.5a.75.75 0 001.5 0V6a.75.75 0 00-.75-.75z"
                                                clip-rule="evenodd" />
                                        </svg>
                                        Pricing Breakdown
                                    </h3>
                                    <dl class="text-sm space-y-1">
                                        <div class="flex justify-between">
                                            <dt class="text-gray-500">Service/Item Subtotal:</dt>
                                            <dd class="text-gray-700">$165.00</dd>
                                        </div>
                                        <div class="flex justify-between">
                                            <dt class="text-gray-500">Tax (7%):</dt>
                                            <dd class="text-gray-700">$11.55</dd>
                                        </div>
                                        <div class="flex justify-between">
                                            <dt class="text-gray-500">Platform Fee:</dt>
                                            <dd class="text-gray-700">$3.45</dd>
                                        </div>
                                        <div class="flex justify-between border-t border-dashed pt-2">
                                            <dt class="font-bold text-base text-gray-900">Total Paid:</dt>
                                            <dd class="font-bold text-base text-green-600">$180.00</dd>
                                        </div>
                                    </dl>
                                </div>
                                <div class="border-t border-gray-200"></div>

                                <div>
                                    <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                                        <svg class="h-5 w-5 mr-2 text-yellow-500" xmlns="http://www.w3.org/2000/svg"
                                            viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd"
                                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm-1-7h2V8h-2v3zm0 4h2v-1h-2v1z"
                                                clip-rule="evenodd" />
                                        </svg>
                                        Order Timeline
                                    </h3>
                                    <ol role="list" class="space-y-4">
                                        <li class="relative pb-8">
                                            <div
                                                class="absolute top-0 left-0 -ml-px mt-0.5 h-full w-0.5 bg-fixnserve-primary">
                                            </div>
                                            <div class="relative flex space-x-3">
                                                <div
                                                    class="h-6 w-6 rounded-full bg-fixnserve-primary flex items-center justify-center text-white font-bold text-xs">
                                                    ✓</div>
                                                <div class="min-w-0 flex-1 pt-0.5">
                                                    <p class="text-sm font-medium text-gray-900">Order Placed</p>
                                                    <p class="text-sm text-gray-500">Dec 4, 2025 at 10:00 AM</p>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="relative pb-8">
                                            <div class="absolute top-0 left-0 -ml-px mt-0.5 h-full w-0.5 bg-gray-200">
                                            </div>
                                            <div class="relative flex space-x-3">
                                                <div
                                                    class="h-6 w-6 rounded-full bg-yellow-400 flex items-center justify-center text-white font-bold text-xs">
                                                    !</div>
                                                <div class="min-w-0 flex-1 pt-0.5">
                                                    <p class="text-sm font-medium text-gray-900">In Progress (Service
                                                        Started)</p>
                                                    <p class="text-sm text-gray-500">Dec 4, 2025 at 11:30 AM</p>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="relative">
                                            <div class="relative flex space-x-3">
                                                <div
                                                    class="h-6 w-6 rounded-full ring-4 ring-gray-100 bg-white border-2 border-gray-300">
                                                </div>
                                                <div class="min-w-0 flex-1 pt-0.5">
                                                    <p class="text-sm font-medium text-gray-500">Completed / Delivered
                                                    </p>
                                                </div>
                                            </div>
                                        </li>
                                    </ol>
                                </div>
                                <div class="border-t border-gray-200"></div>

                                <div>
                                    <h3 class="text-lg font-semibold text-gray-900 mb-3 flex items-center">
                                        <svg class="h-5 w-5 mr-2 text-red-500" xmlns="http://www.w3.org/2000/svg"
                                            viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd"
                                                d="M9.69 1.62l-4.5 9a1 1 0 00.95 1.38H7v3a1 1 0 002 0v-3h2v3a1 1 0 002 0v-3h.86a1 1 0 00.95-1.38l-4.5-9a1 1 0 00-1.88 0z"
                                                clip-rule="evenodd" />
                                        </svg>
                                        Rider Tracking
                                    </h3>
                                    <div
                                        class="h-40 bg-gray-200 rounded-xl flex items-center justify-center text-gray-500 text-sm italic">

                                    </div>
                                </div>

                                <div x-show="selectedOrder.status === 'Cancelled'"
                                    class="bg-red-50 p-4 rounded-xl border border-red-200">
                                    <h4 class="font-bold text-red-800 flex items-center mb-2">
                                        <svg class="h-5 w-5 mr-1" xmlns="http://www.w3.org/2000/svg"
                                            viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd"
                                                d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.28 7.22a.75.75 0 00-1.06 1.06L8.94 10l-1.72 1.72a.75.75 0 101.06 1.06L10 11.06l1.72 1.72a.75.75 0 101.06-1.06L11.06 10l1.72-1.72a.75.75 0 00-1.06-1.06L10 8.94l-1.72-1.72z"
                                                clip-rule="evenodd" />
                                        </svg>
                                        Cancellation & Refund Required
                                    </h4>
                                    <p class="text-sm text-red-700">Reason: Customer changed mind. Refund requested:
                                        **$180.00**.</p>
                                    <button type="button"
                                        class="mt-3 text-sm font-semibold text-white bg-red-600 hover:bg-red-700 px-3 py-1.5 rounded-lg shadow transition duration-150">Process
                                        Refund Now</button>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>

</body>

</html>
