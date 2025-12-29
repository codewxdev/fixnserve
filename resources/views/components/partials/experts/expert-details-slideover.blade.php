<div id="expert-details-slideover" class="relative z-50 hidden" aria-labelledby="slide-over-title" role="dialog" aria-modal="true">

    <div id="slideover-backdrop" class="fixed inset-0 bg-gray-900/60 opacity-0 transition-opacity ease-in-out duration-500 backdrop-blur-sm"></div>

    <div class="fixed inset-0 overflow-hidden">
        <div class="absolute inset-0 overflow-hidden">
            <div class="pointer-events-none fixed inset-y-0 right-0 flex max-w-full pl-10">

                <div id="slideover-panel" class="pointer-events-auto w-screen max-w-2xl transform translate-x-full transition-transform ease-in-out duration-500 sm:duration-500">
                    <div class="flex h-full flex-col bg-white shadow-2xl">

                        <div class="bg-indigo-900 px-4 py-6 sm:px-6">
                            <div class="flex items-center justify-between">
                                <h2 class="text-lg font-medium text-white" id="slide-over-title">Expert Profile</h2>
                                <div class="ml-3 flex h-7 items-center">
                                    <button type="button" class="rounded-md bg-indigo-900 text-indigo-200 hover:text-white focus:outline-none focus:ring-2 focus:ring-white" onclick="closeExpertDetails()">
                                        <span class="sr-only">Close panel</span>
                                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                            <div class="mt-6 flex items-center">
                                <div class="flex-shrink-0">
                                    <img class="h-15 w-15 rounded-full object-cover"
                                        src="https://ui-avatars.com/api/?name=Amelia+Reed&background=0D8ABC&color=fff"
                                        alt="Amelia Reed">
                                </div>
                                <div class="ml-4">
                                    <h3 class="text-xl font-bold text-white">Amelia Reed</h3>
                                    <p class="text-indigo-200 text-sm">Senior Legal Consultant • Joined Jan 2023</p>
                                    <div class="mt-2 flex items-center gap-2">
                                        <span class="inline-flex items-center rounded-md bg-green-400/10 px-2 py-1 text-xs font-medium text-green-400 ring-1 ring-inset ring-green-400/20">Verified Identity</span>
                                        <span class="inline-flex items-center rounded-md bg-indigo-400/10 px-2 py-1 text-xs font-medium text-indigo-300 ring-1 ring-inset ring-indigo-400/20">Top Rated</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="border-b border-gray-200 bg-gray-50 px-4 py-3 flex gap-3 overflow-x-auto">
                            <button class="flex-1 inline-flex justify-center items-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50">
                                <svg class="mr-1.5 h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M10 12.5a2.5 2.5 0 100-5 2.5 2.5 0 000 5z" />
                                    <path fill-rule="evenodd" d="M.664 10.59a1.651 1.651 0 010-1.186A10.004 10.004 0 0110 3c4.257 0 7.893 2.66 9.336 6.41.147.381.146.804 0 1.186A10.004 10.004 0 0110 17c-4.257 0-7.893-2.66-9.336-6.41zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" />
                                </svg>
                                Log in as User
                            </button>
                            <button class="flex-1 inline-flex justify-center items-center rounded-md bg-green-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-green-500">
                                Approve KYC
                            </button>
                            <button class="flex-1 inline-flex justify-center items-center rounded-md bg-red-50 px-3 py-2 text-sm font-semibold text-red-600 shadow-sm ring-1 ring-inset ring-red-300 hover:bg-red-100">
                                Suspend
                            </button>
                        </div>

                        <div class="flex-1 overflow-y-auto custom-scrollbar bg-white px-4 py-6 sm:px-6">

                            <section class="mb-8">
                                <h4 class="text-sm font-bold text-gray-500 uppercase tracking-wide mb-4">Professional Overview</h4>
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                    <div class="bg-gray-50 p-3 rounded-lg border border-gray-100">
                                        <p class="text-xs text-gray-500">Hourly Rate</p>
                                        <p class="text-lg font-semibold text-gray-900">$180.00 <span class="text-xs font-normal text-gray-400">/hr</span></p>
                                    </div>
                                    <div class="bg-gray-50 p-3 rounded-lg border border-gray-100">
                                        <p class="text-xs text-gray-500">Total Consultations</p>
                                        <p class="text-lg font-semibold text-gray-900">145</p>
                                    </div>
                                    <div class="col-span-1 sm:col-span-2 bg-gray-50 p-3 rounded-lg border border-gray-100">
                                        <p class="text-xs text-gray-500">Expertise Tags</p>
                                        <div class="flex flex-wrap gap-2 mt-2">
                                            <span class="px-2 py-1 bg-white border rounded text-xs text-gray-600">Corporate Law</span>
                                            <span class="px-2 py-1 bg-white border rounded text-xs text-gray-600">IP Rights</span>
                                            <span class="px-2 py-1 bg-white border rounded text-xs text-gray-600">Contract Review</span>
                                        </div>
                                    </div>
                                </div>
                            </section>

                            <section class="mb-8">
                                <h4 class="text-sm font-bold text-gray-500 uppercase tracking-wide mb-4">Verification Documents</h4>
                                <ul role="list" class="divide-y divide-gray-100 rounded-md border border-gray-200">
                                    <li class="flex items-center justify-between py-3 pl-3 pr-4 text-sm hover:bg-gray-50">
                                        <div class="flex w-0 flex-1 items-center">
                                            <svg class="h-5 w-5 flex-shrink-0 text-gray-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                                            </svg>
                                            <span class="ml-2 w-0 flex-1 truncate">government_id_front.pdf</span>
                                        </div>
                                        <div class="ml-4 flex-shrink-0 flex gap-3">
                                            <a href="#" class="font-medium text-indigo-600 hover:text-indigo-500">View</a>
                                            <span class="text-green-600 text-xs flex items-center font-bold">✓ Approved</span>
                                        </div>
                                    </li>
                                    <li class="flex items-center justify-between py-3 pl-3 pr-4 text-sm hover:bg-gray-50">
                                        <div class="flex w-0 flex-1 items-center">
                                            <svg class="h-5 w-5 flex-shrink-0 text-gray-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M4.26 10.147a60.436 60.436 0 00-.491 6.347A48.627 48.627 0 0112 20.904a48.627 48.627 0 018.232-4.41 60.46 60.46 0 00-.491-6.347m-15.482 0a50.57 50.57 0 00-2.658-.813A59.905 59.905 0 0112 3.493a59.902 59.902 0 0110.499 5.24 50.552 50.552 0 00-2.658.814m-15.482 0A50.697 50.697 0 0112 13.489a50.702 50.702 0 017.74-3.342M6.75 15a.75.75 0 100-1.5.75.75 0 000 1.5zm0 0v-3.675A55.378 55.378 0 0112 8.443m-7.007 11.55A5.981 5.981 0 006.75 15.75v-1.5" />
                                            </svg>
                                            <span class="ml-2 w-0 flex-1 truncate">law_degree_certificate.jpg</span>
                                        </div>
                                        <div class="ml-4 flex-shrink-0 flex gap-3">
                                            <a href="#" class="font-medium text-indigo-600 hover:text-indigo-500">View</a>
                                            <button class="font-medium text-orange-600 hover:text-orange-500 text-xs border border-orange-200 px-2 py-1 rounded">Validate</button>
                                        </div>
                                    </li>
                                </ul>
                            </section>

                            <section>
                                <h4 class="text-sm font-bold text-gray-500 uppercase tracking-wide mb-4">Financial Overview (YTD)</h4>
                                <div class="bg-white border border-gray-200 rounded-lg overflow-hidden">
                                    <div class="px-4 py-5 sm:p-6 grid grid-cols-3 divide-x divide-gray-200 text-center">
                                        <div>
                                            <dt class="text-xs font-normal text-gray-500">Earnings</dt>
                                            <dd class="mt-1 text-xl font-semibold tracking-tight text-gray-900">$12,450</dd>
                                        </div>
                                        <div>
                                            <dt class="text-xs font-normal text-gray-500">Pending</dt>
                                            <dd class="mt-1 text-xl font-semibold tracking-tight text-gray-900">$1,200</dd>
                                        </div>
                                        <div>
                                            <dt class="text-xs font-normal text-gray-500">Refunds</dt>
                                            <dd class="mt-1 text-xl font-semibold tracking-tight text-red-600">$180</dd>
                                        </div>
                                    </div>
                                    <div class="bg-gray-50 px-4 py-3 sm:px-6">
                                        <div class="text-sm">
                                            <a href="#" class="font-medium text-indigo-600 hover:text-indigo-500">View full transaction history <span aria-hidden="true">&rarr;</span></a>
                                        </div>
                                    </div>
                                </div>
                            </section>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>