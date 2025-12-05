<div id="expert-details-slideover" class="relative z-50 hidden" aria-labelledby="slide-over-title" role="dialog" aria-modal="true">
    <div id="slideover-backdrop" class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity ease-in-out duration-500 opacity-100"></div>

    <div class="fixed inset-0 overflow-hidden">
        <div class="absolute inset-0 overflow-hidden">
            <div id="slideover-panel" class="pointer-events-none fixed inset-y-0 right-0 flex max-w-full pl-10 transform translate-x-full transition ease-in-out duration-300 sm:duration-500">
                <div class="pointer-events-auto w-screen max-w-4xl">
                    <div class="flex h-full flex-col overflow-y-scroll bg-white shadow-xl">
                        <div class="px-8 py-6 bg-gray-50">
                            <div class="flex items-start justify-between">
                                <h2 class="text-2xl font-bold text-gray-900" id="slide-over-title">Expert Details: [Expert Full Name]</h2>
                                <div class="ml-3 flex h-7 items-center">
                                    <button type="button" class="rounded-md bg-gray-50 text-gray-400 hover:text-gray-500 focus:outline-none" onclick="closeExpertDetails()">
                                        <span class="sr-only">Close panel</span>
                                        <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
                                    </button>
                                </div>
                            </div>
                            <div class="mt-4 flex space-x-3">
                                <button class="inline-flex items-center rounded-md bg-green-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-green-700">Approve KYC</button>
                                <button class="inline-flex items-center rounded-md bg-indigo-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-indigo-700">Validate Degrees</button>
                                <button class="inline-flex items-center rounded-md bg-red-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-red-700">Suspend Expert</button>
                                <button class="inline-flex items-center rounded-md bg-gray-200 text-gray-700 px-4 py-2 text-sm font-medium hover:bg-gray-300">Reset Password</button>
                            </div>
                        </div>

                        <div class="p-8 space-y-8 flex-1 overflow-y-auto">

                            <section>
                                <h3 class="text-lg font-semibold border-b pb-2 mb-4 text-gray-700">Profile Overview</h3>
                                </section>

                            <section>
                                <h3 class="text-lg font-semibold border-b pb-2 mb-4 text-gray-700">Verification & Compliance</h3>
                                </section>
                            
                            <section>
                                <h3 class="text-lg font-semibold border-b pb-2 mb-4 text-gray-700">Consultation Settings</h3>
                                </section>

                            <section>
                                <h3 class="text-lg font-semibold border-b pb-2 mb-4 text-gray-700">Performance & Earnings</h3>
                                </section>

                            <section>
                                <h3 class="text-lg font-semibold border-b pb-2 mb-4 text-gray-700">Violations & Penalties</h3>
                                </section>

                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>