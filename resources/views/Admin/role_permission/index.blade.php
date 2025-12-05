@extends('layouts.app')

@section('content')
    <div class="space-y-8 p-6 lg:p-10">

        {{-- A. Header Section --}}
        <header class="flex flex-col md:flex-row md:items-center md:justify-between space-y-4 md:space-y-0">
            <div>
                {{-- Icon-based breadcrumb navigation --}}
                <nav class="text-sm font-medium text-slate-500 mb-1" aria-label="Breadcrumb">
                    <ol class="inline-flex items-center space-x-1 md:space-x-3">
                        <li class="inline-flex items-center">
                            <a href="#" class="text-slate-400 hover:text-indigo-600 transition-colors">
                                <svg class="w-4 h-4 mr-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0h6m-6 0h-6">
                                    </path>
                                </svg>
                            </a>
                        </li>
                        <li><span class="mx-2 text-slate-300">/</span></li>
                        <li>
                            <a href="#" class="text-slate-400 hover:text-indigo-600 transition-colors">Settings</a>
                        </li>
                        <li><span class="mx-2 text-slate-300">/</span></li>
                        <li aria-current="page">
                            <span class="text-indigo-600">Roles & Permissions</span>
                        </li>
                    </ol>
                </nav>

                {{-- Page title & Subtitle --}}
                <h1 class="text-3xl font-extrabold text-slate-900 leading-tight">Roles & Permissions Management</h1>
                <p class="text-lg text-slate-600 mt-1">Control system access and security across the platform.</p>
            </div>
            <div class="div">
                <button onclick="document.getElementById('addRoleModal').classList.remove('hidden')"
                    class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white font-semibold rounded-xl shadow-lg hover:bg-indigo-700 transition-all duration-300 ease-in-out transform hover:scale-[1.02] active:scale-[0.98]">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM12 10a4 4 0 00-4 4v2a2 2 0 002 2h6a2 2 0 002-2v-2a4 4 0 00-4-4h-2z">
                        </path>
                    </svg>
                    Create New Role
                </button>
                <button onclick="document.getElementById('addPermissionModal').classList.remove('hidden')"
                    class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white font-semibold rounded-xl shadow-lg hover:bg-indigo-700 transition-all duration-300 ease-in-out transform hover:scale-[1.02] active:scale-[0.98]">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM12 10a4 4 0 00-4 4v2a2 2 0 002 2h6a2 2 0 002-2v-2a4 4 0 00-4-4h-2z">
                        </path>
                    </svg>
                    Create New Permission
                </button>
            </div>


        </header>

        <hr class="border-slate-200">

        {{-- B. Overview Statistics (Top Insight Cards) --}}
        <section class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-6 gap-6">
            {{-- Card 1: Total Roles (Hardcoded) --}}
            <div
                class="bg-white p-5 rounded-2xl shadow-xl transition-all duration-300 ease-in-out transform hover:shadow-2xl hover:-translate-y-0.5 border border-slate-100">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-indigo-100 text-indigo-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20v-2c0-.656-.126-1.283-.356-1.857M9 20H7a4 4 0 01-4-4v-2.586a1 1 0 01.293-.707l3.95-3.95a1 1 0 01.707-.293h2.586M7 20v-2c0-.656.126-1.283.356-1.857M11 5a2 2 0 11-4 0 2 2 0 014 0zM12 12a4 4 0 100-8 4 4 0 000 8z">
                            </path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-slate-500">Total Roles</p>
                        <p class="text-2xl font-bold text-slate-900">7</p>
                    </div>
                </div>
            </div>
            {{-- Card 2: Total Permissions --}}
            <div
                class="bg-white p-5 rounded-2xl shadow-xl transition-all duration-300 ease-in-out transform hover:shadow-2xl hover:-translate-y-0.5 border border-slate-100">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-green-100 text-green-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.001 12.001 0 002.944 12c.045 2.502.506 4.909 1.332 7.15A12.001 12.001 0 0012 22c2.474 0 4.839-.558 6.892-1.637A12.001 12.001 0 0021.056 12a11.955 11.955 0 01-3.438-7.016z">
                            </path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-slate-500">Total Permissions</p>
                        <p class="text-2xl font-bold text-slate-900">94</p>
                    </div>
                </div>
            </div>
            {{-- Card 3: System-Level Permissions --}}
            <div
                class="bg-white p-5 rounded-2xl shadow-xl transition-all duration-300 ease-in-out transform hover:shadow-2xl hover:-translate-y-0.5 border border-slate-100">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-red-100 text-red-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.942 3.313.824 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.942 1.543-.824 3.313-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.942-3.313-.824-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.942-1.543.824-3.313 2.37-2.37a1.724 1.724 0 002.572-1.065z">
                            </path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-slate-500">System-Level</p>
                        <p class="text-2xl font-bold text-slate-900">8</p>
                    </div>
                </div>
            </div>
            {{-- Card 4: Role Groups --}}
            <div
                class="bg-white p-5 rounded-2xl shadow-xl transition-all duration-300 ease-in-out transform hover:shadow-2xl hover:-translate-y-0.5 border border-slate-100">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-blue-100 text-blue-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0v-2a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10">
                            </path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-slate-500">Role Groups</p>
                        <p class="text-2xl font-bold text-slate-900">5</p>
                    </div>
                </div>
            </div>
            {{-- Card 5: Modified (7d) --}}
            <div
                class="bg-white p-5 rounded-2xl shadow-xl transition-all duration-300 ease-in-out transform hover:shadow-2xl hover:-translate-y-0.5 border border-slate-100">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-orange-100 text-orange-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11.116-2.227a9.75 9.75 0 00-3.155-2.887M16 11V7h-4M5.612 18.337A9.75 9.75 0 009.767 20h4.466c1.868 0 3.633-.679 4.965-1.836M8 13v4h4">
                            </path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-slate-500">Modified (7d)</p>
                        <p class="text-2xl font-bold text-slate-900">4</p>
                    </div>
                </div>
            </div>
            {{-- Card 6: Restricted Logs --}}
            <div
                class="bg-white p-5 rounded-2xl shadow-xl transition-all duration-300 ease-in-out transform hover:shadow-2xl hover:-translate-y-0.5 border border-slate-100">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-slate-100 text-slate-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-6v-2m-4 2v-2m-4 2v-2m10 2v-2m-8 2v-2m-8 4h16a2 2 0 002-2v-6a2 2 0 00-2-2H4a2 2 0 00-2 2v6a2 2 0 002 2z">
                            </path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-slate-500">Restricted Logs</p>
                        <p class="text-2xl font-bold text-slate-900">23</p>
                    </div>
                </div>
            </div>
        </section>

        <hr class="border-slate-200">

        {{-- C. Main Content: Roles & Permission Matrix / Card View Toggle --}}
        <section class="space-y-6">
            {{-- View Toggle --}}
            <div class="flex justify-end">
                <div class="inline-flex rounded-xl bg-slate-100 p-1 shadow-inner">
                    <button id="toggle-matrix" onclick="switchView('matrix')"
                        class="view-toggle-btn active-view-btn transition-all duration-300 py-2 px-4 text-sm font-semibold rounded-lg">
                        <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 10h18M3 14h18m-9-4v8m-7 0h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z">
                            </path>
                        </svg>
                        Matrix View
                    </button>
                    <button id="toggle-cards" onclick="switchView('cards')"
                        class="view-toggle-btn transition-all duration-300 py-2 px-4 text-sm font-semibold rounded-lg text-slate-500 hover:text-indigo-600">
                        <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z">
                            </path>
                        </svg>
                        Card View
                    </button>
                </div>
            </div>

            <div class="flex space-x-6">
                {{-- 3. Permission Categories (Left Sidebar) --}}
                <aside class="w-64 hidden lg:block">
                    <div class="sticky top-6 bg-white p-5 rounded-2xl shadow-lg border border-slate-100 space-y-2">
                        <h3 class="text-sm font-bold uppercase tracking-wider text-slate-500 mb-3">Categories</h3>
                        <button
                            class="category-filter-btn w-full text-left flex items-center p-2 rounded-lg text-slate-700 hover:bg-slate-50 hover:text-indigo-600 transition-colors duration-200">
                            <span class="mr-2"></span><span class="text-sm font-medium">Core System</span>
                        </button>
                        <button
                            class="category-filter-btn w-full text-left flex items-center p-2 rounded-lg text-slate-700 hover:bg-slate-50 hover:text-indigo-600 transition-colors duration-200">
                            <span class="mr-2"></span><span class="text-sm font-medium">Admin Controls</span>
                        </button>
                        <button
                            class="category-filter-btn w-full text-left flex items-center p-2 rounded-lg text-indigo-600 bg-indigo-50 font-bold transition-colors duration-200">
                            <span class="mr-2"></span><span class="text-sm font-medium">Finance Module</span>
                        </button>
                        <button
                            class="category-filter-btn w-full text-left flex items-center p-2 rounded-lg text-slate-700 hover:bg-slate-50 hover:text-indigo-600 transition-colors duration-200">
                            <span class="mr-2"></span><span class="text-sm font-medium">Vendor Module</span>
                        </button>
                        <button
                            class="category-filter-btn w-full text-left flex items-center p-2 rounded-lg text-slate-700 hover:bg-slate-50 hover:text-indigo-600 transition-colors duration-200">
                            <span class="mr-2"></span><span class="text-sm font-medium">Support & Complaints</span>
                        </button>
                        <button
                            class="category-filter-btn w-full text-left flex items-center p-2 rounded-lg text-slate-700 hover:bg-slate-50 hover:text-indigo-600 transition-colors duration-200">
                            <span class="mr-2"></span><span class="text-sm font-medium">QC & Review Moderation</span>
                        </button>
                        <button
                            class="category-filter-btn w-full text-left flex items-center p-2 rounded-lg text-slate-700 hover:bg-slate-50 hover:text-indigo-600 transition-colors duration-200">
                            <span class="mr-2"></span><span class="text-sm font-medium">Content & CMS</span>
                        </button>
                        <button
                            class="category-filter-btn w-full text-left flex items-center p-2 rounded-lg text-slate-700 hover:bg-slate-50 hover:text-indigo-600 transition-colors duration-200">
                            <span class="mr-2"></span><span class="text-sm font-medium">AI & Automation</span>
                        </button>
                        <button
                            class="category-filter-btn w-full text-left flex items-center p-2 rounded-lg text-slate-700 hover:bg-slate-50 hover:text-indigo-600 transition-colors duration-200">
                            <span class="mr-2"></span><span class="text-sm font-medium">Advanced Controls</span>
                        </button>
                    </div>
                </aside>

                <main class="flex-grow min-w-0">
                    {{-- Matrix View --}}
                    <div id="matrix-view"
                        class="bg-white rounded-2xl shadow-xl border border-slate-100 p-0 overflow-x-auto">
                        {{-- C. Main Content: Roles & Permission Matrix --}}
                        <div class="min-w-full">
                            <table class="w-full text-sm text-left text-slate-500 border-collapse">
                                <thead class="sticky top-0 z-10 bg-slate-50 border-b border-slate-200 shadow-sm">
                                    <tr>
                                        <th scope="col" class="w-64 px-4 py-3 font-semibold text-slate-700">
                                            <span class="text-xs uppercase tracking-wider">Permission</span>
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-center w-36 relative">
                                            <span class="font-bold text-slate-800">Super Admin</span>
                                            <span
                                                class="absolute top-0 right-0 inline-flex items-center rounded-full bg-red-100 px-2 py-0.5 text-xs font-medium text-red-700 translate-x-3 -translate-y-2">Core</span>
                                            <div class="mt-1 flex justify-center space-x-2">
                                                <button onclick="openManagePermissions('Super Admin')"
                                                    title="Manage Permissions"
                                                    class="text-indigo-500 hover:text-indigo-700 transition-colors">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                                        </path>
                                                    </svg>
                                                </button>
                                            </div>
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-center w-36 relative">
                                            <span class="font-bold text-slate-800">Admin</span>
                                            <div class="mt-1 flex justify-center space-x-2">
                                                <button onclick="openManagePermissions('Admin')"
                                                    title="Manage Permissions"
                                                    class="text-indigo-500 hover:text-indigo-700 transition-colors">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                                        </path>
                                                    </svg>
                                                </button>
                                            </div>
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-center w-36 relative">
                                            <span class="font-bold text-slate-800">Finance Manager</span>
                                            <div class="mt-1 flex justify-center space-x-2">
                                                <button onclick="openManagePermissions('Finance Manager')"
                                                    title="Manage Permissions"
                                                    class="text-indigo-500 hover:text-indigo-700 transition-colors">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                                        </path>
                                                    </svg>
                                                </button>
                                            </div>
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-center w-36 relative">
                                            <span class="font-bold text-slate-800">Vendor Manager</span>
                                            <div class="mt-1 flex justify-center space-x-2">
                                                <button onclick="openManagePermissions('Vendor Manager')"
                                                    title="Manage Permissions"
                                                    class="text-indigo-500 hover:text-indigo-700 transition-colors">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                                        </path>
                                                    </svg>
                                                </button>
                                            </div>
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-center w-36 relative">
                                            <span class="font-bold text-slate-800">Support Staff</span>
                                            <div class="mt-1 flex justify-center space-x-2">
                                                <button onclick="openManagePermissions('Support Staff')"
                                                    title="Manage Permissions"
                                                    class="text-indigo-500 hover:text-indigo-700 transition-colors">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                                        </path>
                                                    </svg>
                                                </button>
                                            </div>
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-center w-36 relative">
                                            <span class="font-bold text-slate-800">Quality Control</span>
                                            <div class="mt-1 flex justify-center space-x-2">
                                                <button onclick="openManagePermissions('Quality Control')"
                                                    title="Manage Permissions"
                                                    class="text-indigo-500 hover:text-indigo-700 transition-colors">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                                        </path>
                                                    </svg>
                                                </button>
                                            </div>
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-center w-36 relative">
                                            <span class="font-bold text-slate-800">Custom Role</span>
                                            <div class="mt-1 flex justify-center space-x-2">
                                                <button onclick="openManagePermissions('Custom Role')"
                                                    title="Manage Permissions"
                                                    class="text-indigo-500 hover:text-indigo-700 transition-colors">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                                        </path>
                                                    </svg>
                                                </button>
                                            </div>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {{-- Group: User Management --}}
                                    <tr class="bg-slate-100/50 border-t border-b border-slate-200">
                                        <td colspan="8"
                                            class="px-4 py-2 font-extrabold text-xs uppercase tracking-wider text-indigo-600 bg-slate-100">
                                            User Management
                                        </td>
                                    </tr>
                                    <tr
                                        class="hover:bg-indigo-50/50 transition-colors duration-150 border-b border-slate-100">
                                        <td class="px-4 py-3 font-medium text-slate-800">Can assign riders</td>
                                        <td class="px-6 py-3 text-center">
                                            {{-- Super Admin: Checked & Disabled --}}
                                            <label class="relative inline-flex items-center">
                                                <input type="checkbox" checked disabled
                                                    class="sr-only peer toggle-checkbox custom-toggle rounded-full">
                                                <div
                                                    class="custom-toggle rounded-full peer peer-checked:bg-indigo-600 opacity-60">
                                                </div>
                                                <div
                                                    class="absolute bg-white rounded-full shadow custom-toggle-dot peer-checked:transform peer-checked:translate-x-full opacity-60">
                                                </div>
                                            </label>
                                        </td>
                                        <td class="px-6 py-3 text-center">
                                            {{-- Admin: Checked & Enabled --}}
                                            <label class="relative inline-flex items-center cursor-pointer">
                                                <input type="checkbox" checked
                                                    class="sr-only peer toggle-checkbox custom-toggle rounded-full">
                                                <div
                                                    class="custom-toggle rounded-full peer peer-focus:ring-2 peer-focus:ring-indigo-300 peer-checked:bg-indigo-600">
                                                </div>
                                                <div
                                                    class="absolute bg-white rounded-full shadow custom-toggle-dot peer-checked:transform peer-checked:translate-x-full">
                                                </div>
                                            </label>
                                        </td>
                                        <td class="px-6 py-3 text-center">
                                            {{-- Finance Manager: Unchecked --}}
                                            <label class="relative inline-flex items-center cursor-pointer">
                                                <input type="checkbox"
                                                    class="sr-only peer toggle-checkbox custom-toggle rounded-full">
                                                <div
                                                    class="custom-toggle rounded-full peer peer-focus:ring-2 peer-focus:ring-indigo-300 peer-checked:bg-indigo-600">
                                                </div>
                                                <div
                                                    class="absolute bg-white rounded-full shadow custom-toggle-dot peer-checked:transform peer-checked:translate-x-full">
                                                </div>
                                            </label>
                                        </td>
                                        <td class="px-6 py-3 text-center">
                                            {{-- Vendor Manager: Checked & Enabled --}}
                                            <label class="relative inline-flex items-center cursor-pointer">
                                                <input type="checkbox" checked
                                                    class="sr-only peer toggle-checkbox custom-toggle rounded-full">
                                                <div
                                                    class="custom-toggle rounded-full peer peer-focus:ring-2 peer-focus:ring-indigo-300 peer-checked:bg-indigo-600">
                                                </div>
                                                <div
                                                    class="absolute bg-white rounded-full shadow custom-toggle-dot peer-checked:transform peer-checked:translate-x-full">
                                                </div>
                                            </label>
                                        </td>
                                        <td class="px-6 py-3 text-center">
                                            {{-- Support Staff: Unchecked --}}
                                            <label class="relative inline-flex items-center cursor-pointer">
                                                <input type="checkbox"
                                                    class="sr-only peer toggle-checkbox custom-toggle rounded-full">
                                                <div
                                                    class="custom-toggle rounded-full peer peer-focus:ring-2 peer-focus:ring-indigo-300 peer-checked:bg-indigo-600">
                                                </div>
                                                <div
                                                    class="absolute bg-white rounded-full shadow custom-toggle-dot peer-checked:transform peer-checked:translate-x-full">
                                                </div>
                                            </label>
                                        </td>
                                        <td class="px-6 py-3 text-center">
                                            {{-- Quality Control: Unchecked --}}
                                            <label class="relative inline-flex items-center cursor-pointer">
                                                <input type="checkbox"
                                                    class="sr-only peer toggle-checkbox custom-toggle rounded-full">
                                                <div
                                                    class="custom-toggle rounded-full peer peer-focus:ring-2 peer-focus:ring-indigo-300 peer-checked:bg-indigo-600">
                                                </div>
                                                <div
                                                    class="absolute bg-white rounded-full shadow custom-toggle-dot peer-checked:transform peer-checked:translate-x-full">
                                                </div>
                                            </label>
                                        </td>
                                        <td class="px-6 py-3 text-center">
                                            {{-- Custom Role: Unchecked --}}
                                            <label class="relative inline-flex items-center cursor-pointer">
                                                <input type="checkbox"
                                                    class="sr-only peer toggle-checkbox custom-toggle rounded-full">
                                                <div
                                                    class="custom-toggle rounded-full peer peer-focus:ring-2 peer-focus:ring-indigo-300 peer-checked:bg-indigo-600">
                                                </div>
                                                <div
                                                    class="absolute bg-white rounded-full shadow custom-toggle-dot peer-checked:transform peer-checked:translate-x-full">
                                                </div>
                                            </label>
                                        </td>
                                    </tr>
                                    <tr
                                        class="hover:bg-indigo-50/50 transition-colors duration-150 border-b border-slate-100">
                                        <td class="px-4 py-3 font-medium text-slate-800">Create/Edit User Profiles</td>
                                        <td class="px-6 py-3 text-center">
                                            {{-- Super Admin: Checked & Disabled --}}
                                            <label class="relative inline-flex items-center">
                                                <input type="checkbox" checked disabled
                                                    class="sr-only peer toggle-checkbox custom-toggle rounded-full">
                                                <div
                                                    class="custom-toggle rounded-full peer peer-checked:bg-indigo-600 opacity-60">
                                                </div>
                                                <div
                                                    class="absolute bg-white rounded-full shadow custom-toggle-dot peer-checked:transform peer-checked:translate-x-full opacity-60">
                                                </div>
                                            </label>
                                        </td>
                                        <td class="px-6 py-3 text-center">
                                            {{-- Admin: Checked & Enabled --}}
                                            <label class="relative inline-flex items-center cursor-pointer">
                                                <input type="checkbox" checked
                                                    class="sr-only peer toggle-checkbox custom-toggle rounded-full">
                                                <div
                                                    class="custom-toggle rounded-full peer peer-focus:ring-2 peer-focus:ring-indigo-300 peer-checked:bg-indigo-600">
                                                </div>
                                                <div
                                                    class="absolute bg-white rounded-full shadow custom-toggle-dot peer-checked:transform peer-checked:translate-x-full">
                                                </div>
                                            </label>
                                        </td>
                                        <td class="px-6 py-3 text-center">
                                            {{-- Finance Manager: Unchecked --}}
                                            <label class="relative inline-flex items-center cursor-pointer">
                                                <input type="checkbox"
                                                    class="sr-only peer toggle-checkbox custom-toggle rounded-full">
                                                <div
                                                    class="custom-toggle rounded-full peer peer-focus:ring-2 peer-focus:ring-indigo-300 peer-checked:bg-indigo-600">
                                                </div>
                                                <div
                                                    class="absolute bg-white rounded-full shadow custom-toggle-dot peer-checked:transform peer-checked:translate-x-full">
                                                </div>
                                            </label>
                                        </td>
                                        <td class="px-6 py-3 text-center">
                                            {{-- Vendor Manager: Unchecked --}}
                                            <label class="relative inline-flex items-center cursor-pointer">
                                                <input type="checkbox"
                                                    class="sr-only peer toggle-checkbox custom-toggle rounded-full">
                                                <div
                                                    class="custom-toggle rounded-full peer peer-focus:ring-2 peer-focus:ring-indigo-300 peer-checked:bg-indigo-600">
                                                </div>
                                                <div
                                                    class="absolute bg-white rounded-full shadow custom-toggle-dot peer-checked:transform peer-checked:translate-x-full">
                                                </div>
                                            </label>
                                        </td>
                                        <td class="px-6 py-3 text-center">
                                            {{-- Support Staff: Unchecked --}}
                                            <label class="relative inline-flex items-center cursor-pointer">
                                                <input type="checkbox"
                                                    class="sr-only peer toggle-checkbox custom-toggle rounded-full">
                                                <div
                                                    class="custom-toggle rounded-full peer peer-focus:ring-2 peer-focus:ring-indigo-300 peer-checked:bg-indigo-600">
                                                </div>
                                                <div
                                                    class="absolute bg-white rounded-full shadow custom-toggle-dot peer-checked:transform peer-checked:translate-x-full">
                                                </div>
                                            </label>
                                        </td>
                                        <td class="px-6 py-3 text-center">
                                            {{-- Quality Control: Unchecked --}}
                                            <label class="relative inline-flex items-center cursor-pointer">
                                                <input type="checkbox"
                                                    class="sr-only peer toggle-checkbox custom-toggle rounded-full">
                                                <div
                                                    class="custom-toggle rounded-full peer peer-focus:ring-2 peer-focus:ring-indigo-300 peer-checked:bg-indigo-600">
                                                </div>
                                                <div
                                                    class="absolute bg-white rounded-full shadow custom-toggle-dot peer-checked:transform peer-checked:translate-x-full">
                                                </div>
                                            </label>
                                        </td>
                                        <td class="px-6 py-3 text-center">
                                            {{-- Custom Role: Unchecked --}}
                                            <label class="relative inline-flex items-center cursor-pointer">
                                                <input type="checkbox"
                                                    class="sr-only peer toggle-checkbox custom-toggle rounded-full">
                                                <div
                                                    class="custom-toggle rounded-full peer peer-focus:ring-2 peer-focus:ring-indigo-300 peer-checked:bg-indigo-600">
                                                </div>
                                                <div
                                                    class="absolute bg-white rounded-full shadow custom-toggle-dot peer-checked:transform peer-checked:translate-x-full">
                                                </div>
                                            </label>
                                        </td>
                                    </tr>

                                    {{-- Group: Financial Actions --}}
                                    <tr class="bg-slate-100/50 border-t border-b border-slate-200">
                                        <td colspan="8"
                                            class="px-4 py-2 font-extrabold text-xs uppercase tracking-wider text-indigo-600 bg-slate-100">
                                            Financial Actions
                                        </td>
                                    </tr>
                                    <tr
                                        class="hover:bg-indigo-50/50 transition-colors duration-150 border-b border-slate-100">
                                        <td class="px-4 py-3 font-medium text-slate-800">Access refund operations</td>
                                        <td class="px-6 py-3 text-center">
                                            {{-- Super Admin: Checked & Disabled --}}
                                            <label class="relative inline-flex items-center">
                                                <input type="checkbox" checked disabled
                                                    class="sr-only peer toggle-checkbox custom-toggle rounded-full">
                                                <div
                                                    class="custom-toggle rounded-full peer peer-checked:bg-indigo-600 opacity-60">
                                                </div>
                                                <div
                                                    class="absolute bg-white rounded-full shadow custom-toggle-dot peer-checked:transform peer-checked:translate-x-full opacity-60">
                                                </div>
                                            </label>
                                        </td>
                                        <td class="px-6 py-3 text-center">
                                            {{-- Admin: Unchecked --}}
                                            <label class="relative inline-flex items-center cursor-pointer">
                                                <input type="checkbox"
                                                    class="sr-only peer toggle-checkbox custom-toggle rounded-full">
                                                <div
                                                    class="custom-toggle rounded-full peer peer-focus:ring-2 peer-focus:ring-indigo-300 peer-checked:bg-indigo-600">
                                                </div>
                                                <div
                                                    class="absolute bg-white rounded-full shadow custom-toggle-dot peer-checked:transform peer-checked:translate-x-full">
                                                </div>
                                            </label>
                                        </td>
                                        <td class="px-6 py-3 text-center">
                                            {{-- Finance Manager: Checked & Enabled --}}
                                            <label class="relative inline-flex items-center cursor-pointer">
                                                <input type="checkbox" checked
                                                    class="sr-only peer toggle-checkbox custom-toggle rounded-full">
                                                <div
                                                    class="custom-toggle rounded-full peer peer-focus:ring-2 peer-focus:ring-indigo-300 peer-checked:bg-indigo-600">
                                                </div>
                                                <div
                                                    class="absolute bg-white rounded-full shadow custom-toggle-dot peer-checked:transform peer-checked:translate-x-full">
                                                </div>
                                            </label>
                                        </td>
                                        <td class="px-6 py-3 text-center">
                                            {{-- Vendor Manager: Unchecked --}}
                                            <label class="relative inline-flex items-center cursor-pointer">
                                                <input type="checkbox"
                                                    class="sr-only peer toggle-checkbox custom-toggle rounded-full">
                                                <div
                                                    class="custom-toggle rounded-full peer peer-focus:ring-2 peer-focus:ring-indigo-300 peer-checked:bg-indigo-600">
                                                </div>
                                                <div
                                                    class="absolute bg-white rounded-full shadow custom-toggle-dot peer-checked:transform peer-checked:translate-x-full">
                                                </div>
                                            </label>
                                        </td>
                                        <td class="px-6 py-3 text-center">
                                            {{-- Support Staff: Unchecked --}}
                                            <label class="relative inline-flex items-center cursor-pointer">
                                                <input type="checkbox"
                                                    class="sr-only peer toggle-checkbox custom-toggle rounded-full">
                                                <div
                                                    class="custom-toggle rounded-full peer peer-focus:ring-2 peer-focus:ring-indigo-300 peer-checked:bg-indigo-600">
                                                </div>
                                                <div
                                                    class="absolute bg-white rounded-full shadow custom-toggle-dot peer-checked:transform peer-checked:translate-x-full">
                                                </div>
                                            </label>
                                        </td>
                                        <td class="px-6 py-3 text-center">
                                            {{-- Quality Control: Unchecked --}}
                                            <label class="relative inline-flex items-center cursor-pointer">
                                                <input type="checkbox"
                                                    class="sr-only peer toggle-checkbox custom-toggle rounded-full">
                                                <div
                                                    class="custom-toggle rounded-full peer peer-focus:ring-2 peer-focus:ring-indigo-300 peer-checked:bg-indigo-600">
                                                </div>
                                                <div
                                                    class="absolute bg-white rounded-full shadow custom-toggle-dot peer-checked:transform peer-checked:translate-x-full">
                                                </div>
                                            </label>
                                        </td>
                                        <td class="px-6 py-3 text-center">
                                            {{-- Custom Role: Unchecked --}}
                                            <label class="relative inline-flex items-center cursor-pointer">
                                                <input type="checkbox"
                                                    class="sr-only peer toggle-checkbox custom-toggle rounded-full">
                                                <div
                                                    class="custom-toggle rounded-full peer peer-focus:ring-2 peer-focus:ring-indigo-300 peer-checked:bg-indigo-600">
                                                </div>
                                                <div
                                                    class="absolute bg-white rounded-full shadow custom-toggle-dot peer-checked:transform peer-checked:translate-x-full">
                                                </div>
                                            </label>
                                        </td>
                                    </tr>
                                    <tr
                                        class="hover:bg-indigo-50/50 transition-colors duration-150 border-b border-slate-100">
                                        <td class="px-4 py-3 font-medium text-slate-800">Manage tax configuration</td>
                                        <td class="px-6 py-3 text-center">
                                            {{-- Super Admin: Checked & Disabled --}}
                                            <label class="relative inline-flex items-center">
                                                <input type="checkbox" checked disabled
                                                    class="sr-only peer toggle-checkbox custom-toggle rounded-full">
                                                <div
                                                    class="custom-toggle rounded-full peer peer-checked:bg-indigo-600 opacity-60">
                                                </div>
                                                <div
                                                    class="absolute bg-white rounded-full shadow custom-toggle-dot peer-checked:transform peer-checked:translate-x-full opacity-60">
                                                </div>
                                            </label>
                                        </td>
                                        <td class="px-6 py-3 text-center">
                                            {{-- Admin: Unchecked --}}
                                            <label class="relative inline-flex items-center cursor-pointer">
                                                <input type="checkbox"
                                                    class="sr-only peer toggle-checkbox custom-toggle rounded-full">
                                                <div
                                                    class="custom-toggle rounded-full peer peer-focus:ring-2 peer-focus:ring-indigo-300 peer-checked:bg-indigo-600">
                                                </div>
                                                <div
                                                    class="absolute bg-white rounded-full shadow custom-toggle-dot peer-checked:transform peer-checked:translate-x-full">
                                                </div>
                                            </label>
                                        </td>
                                        <td class="px-6 py-3 text-center">
                                            {{-- Finance Manager: Checked & Enabled --}}
                                            <label class="relative inline-flex items-center cursor-pointer">
                                                <input type="checkbox" checked
                                                    class="sr-only peer toggle-checkbox custom-toggle rounded-full">
                                                <div
                                                    class="custom-toggle rounded-full peer peer-focus:ring-2 peer-focus:ring-indigo-300 peer-checked:bg-indigo-600">
                                                </div>
                                                <div
                                                    class="absolute bg-white rounded-full shadow custom-toggle-dot peer-checked:transform peer-checked:translate-x-full">
                                                </div>
                                            </label>
                                        </td>
                                        <td class="px-6 py-3 text-center">
                                            {{-- Vendor Manager: Unchecked --}}
                                            <label class="relative inline-flex items-center cursor-pointer">
                                                <input type="checkbox"
                                                    class="sr-only peer toggle-checkbox custom-toggle rounded-full">
                                                <div
                                                    class="custom-toggle rounded-full peer peer-focus:ring-2 peer-focus:ring-indigo-300 peer-checked:bg-indigo-600">
                                                </div>
                                                <div
                                                    class="absolute bg-white rounded-full shadow custom-toggle-dot peer-checked:transform peer-checked:translate-x-full">
                                                </div>
                                            </label>
                                        </td>
                                        <td class="px-6 py-3 text-center">
                                            {{-- Support Staff: Unchecked --}}
                                            <label class="relative inline-flex items-center cursor-pointer">
                                                <input type="checkbox"
                                                    class="sr-only peer toggle-checkbox custom-toggle rounded-full">
                                                <div
                                                    class="custom-toggle rounded-full peer peer-focus:ring-2 peer-focus:ring-indigo-300 peer-checked:bg-indigo-600">
                                                </div>
                                                <div
                                                    class="absolute bg-white rounded-full shadow custom-toggle-dot peer-checked:transform peer-checked:translate-x-full">
                                                </div>
                                            </label>
                                        </td>
                                        <td class="px-6 py-3 text-center">
                                            {{-- Quality Control: Unchecked --}}
                                            <label class="relative inline-flex items-center cursor-pointer">
                                                <input type="checkbox"
                                                    class="sr-only peer toggle-checkbox custom-toggle rounded-full">
                                                <div
                                                    class="custom-toggle rounded-full peer peer-focus:ring-2 peer-focus:ring-indigo-300 peer-checked:bg-indigo-600">
                                                </div>
                                                <div
                                                    class="absolute bg-white rounded-full shadow custom-toggle-dot peer-checked:transform peer-checked:translate-x-full">
                                                </div>
                                            </label>
                                        </td>
                                        <td class="px-6 py-3 text-center">
                                            {{-- Custom Role: Unchecked --}}
                                            <label class="relative inline-flex items-center cursor-pointer">
                                                <input type="checkbox"
                                                    class="sr-only peer toggle-checkbox custom-toggle rounded-full">
                                                <div
                                                    class="custom-toggle rounded-full peer peer-focus:ring-2 peer-focus:ring-indigo-300 peer-checked:bg-indigo-600">
                                                </div>
                                                <div
                                                    class="absolute bg-white rounded-full shadow custom-toggle-dot peer-checked:transform peer-checked:translate-x-full">
                                                </div>
                                            </label>
                                        </td>
                                    </tr>
                                    <tr
                                        class="hover:bg-indigo-50/50 transition-colors duration-150 border-b border-slate-100">
                                        <td class="px-4 py-3 font-medium text-slate-800">Payout Management</td>
                                        <td class="px-6 py-3 text-center">
                                            {{-- Super Admin: Checked & Disabled --}}
                                            <label class="relative inline-flex items-center">
                                                <input type="checkbox" checked disabled
                                                    class="sr-only peer toggle-checkbox custom-toggle rounded-full">
                                                <div
                                                    class="custom-toggle rounded-full peer peer-checked:bg-indigo-600 opacity-60">
                                                </div>
                                                <div
                                                    class="absolute bg-white rounded-full shadow custom-toggle-dot peer-checked:transform peer-checked:translate-x-full opacity-60">
                                                </div>
                                            </label>
                                        </td>
                                        <td class="px-6 py-3 text-center">
                                            {{-- Admin: Unchecked --}}
                                            <label class="relative inline-flex items-center cursor-pointer">
                                                <input type="checkbox"
                                                    class="sr-only peer toggle-checkbox custom-toggle rounded-full">
                                                <div
                                                    class="custom-toggle rounded-full peer peer-focus:ring-2 peer-focus:ring-indigo-300 peer-checked:bg-indigo-600">
                                                </div>
                                                <div
                                                    class="absolute bg-white rounded-full shadow custom-toggle-dot peer-checked:transform peer-checked:translate-x-full">
                                                </div>
                                            </label>
                                        </td>
                                        <td class="px-6 py-3 text-center">
                                            {{-- Finance Manager: Checked & Enabled --}}
                                            <label class="relative inline-flex items-center cursor-pointer">
                                                <input type="checkbox" checked
                                                    class="sr-only peer toggle-checkbox custom-toggle rounded-full">
                                                <div
                                                    class="custom-toggle rounded-full peer peer-focus:ring-2 peer-focus:ring-indigo-300 peer-checked:bg-indigo-600">
                                                </div>
                                                <div
                                                    class="absolute bg-white rounded-full shadow custom-toggle-dot peer-checked:transform peer-checked:translate-x-full">
                                                </div>
                                            </label>
                                        </td>
                                        <td class="px-6 py-3 text-center">
                                            {{-- Vendor Manager: Unchecked --}}
                                            <label class="relative inline-flex items-center cursor-pointer">
                                                <input type="checkbox"
                                                    class="sr-only peer toggle-checkbox custom-toggle rounded-full">
                                                <div
                                                    class="custom-toggle rounded-full peer peer-focus:ring-2 peer-focus:ring-indigo-300 peer-checked:bg-indigo-600">
                                                </div>
                                                <div
                                                    class="absolute bg-white rounded-full shadow custom-toggle-dot peer-checked:transform peer-checked:translate-x-full">
                                                </div>
                                            </label>
                                        </td>
                                        <td class="px-6 py-3 text-center">
                                            {{-- Support Staff: Unchecked --}}
                                            <label class="relative inline-flex items-center cursor-pointer">
                                                <input type="checkbox"
                                                    class="sr-only peer toggle-checkbox custom-toggle rounded-full">
                                                <div
                                                    class="custom-toggle rounded-full peer peer-focus:ring-2 peer-focus:ring-indigo-300 peer-checked:bg-indigo-600">
                                                </div>
                                                <div
                                                    class="absolute bg-white rounded-full shadow custom-toggle-dot peer-checked:transform peer-checked:translate-x-full">
                                                </div>
                                            </label>
                                        </td>
                                        <td class="px-6 py-3 text-center">
                                            {{-- Quality Control: Unchecked --}}
                                            <label class="relative inline-flex items-center cursor-pointer">
                                                <input type="checkbox"
                                                    class="sr-only peer toggle-checkbox custom-toggle rounded-full">
                                                <div
                                                    class="custom-toggle rounded-full peer peer-focus:ring-2 peer-focus:ring-indigo-300 peer-checked:bg-indigo-600">
                                                </div>
                                                <div
                                                    class="absolute bg-white rounded-full shadow custom-toggle-dot peer-checked:transform peer-checked:translate-x-full">
                                                </div>
                                            </label>
                                        </td>
                                        <td class="px-6 py-3 text-center">
                                            {{-- Custom Role: Unchecked --}}
                                            <label class="relative inline-flex items-center cursor-pointer">
                                                <input type="checkbox"
                                                    class="sr-only peer toggle-checkbox custom-toggle rounded-full">
                                                <div
                                                    class="custom-toggle rounded-full peer peer-focus:ring-2 peer-focus:ring-indigo-300 peer-checked:bg-indigo-600">
                                                </div>
                                                <div
                                                    class="absolute bg-white rounded-full shadow custom-toggle-dot peer-checked:transform peer-checked:translate-x-full">
                                                </div>
                                            </label>
                                        </td>
                                    </tr>

                                    {{-- Group: Vendor Approval --}}
                                    <tr class="bg-slate-100/50 border-t border-b border-slate-200">
                                        <td colspan="8"
                                            class="px-4 py-2 font-extrabold text-xs uppercase tracking-wider text-indigo-600 bg-slate-100">
                                            Vendor Approval
                                        </td>
                                    </tr>
                                    <tr
                                        class="hover:bg-indigo-50/50 transition-colors duration-150 border-b border-slate-100">
                                        <td class="px-4 py-3 font-medium text-slate-800">Can disable vendor accounts</td>
                                        <td class="px-6 py-3 text-center">
                                            {{-- Super Admin: Checked & Disabled --}}
                                            <label class="relative inline-flex items-center">
                                                <input type="checkbox" checked disabled
                                                    class="sr-only peer toggle-checkbox custom-toggle rounded-full">
                                                <div
                                                    class="custom-toggle rounded-full peer peer-checked:bg-indigo-600 opacity-60">
                                                </div>
                                                <div
                                                    class="absolute bg-white rounded-full shadow custom-toggle-dot peer-checked:transform peer-checked:translate-x-full opacity-60">
                                                </div>
                                            </label>
                                        </td>
                                        <td class="px-6 py-3 text-center">
                                            {{-- Admin: Unchecked --}}
                                            <label class="relative inline-flex items-center cursor-pointer">
                                                <input type="checkbox"
                                                    class="sr-only peer toggle-checkbox custom-toggle rounded-full">
                                                <div
                                                    class="custom-toggle rounded-full peer peer-focus:ring-2 peer-focus:ring-indigo-300 peer-checked:bg-indigo-600">
                                                </div>
                                                <div
                                                    class="absolute bg-white rounded-full shadow custom-toggle-dot peer-checked:transform peer-checked:translate-x-full">
                                                </div>
                                            </label>
                                        </td>
                                        <td class="px-6 py-3 text-center">
                                            {{-- Finance Manager: Unchecked --}}
                                            <label class="relative inline-flex items-center cursor-pointer">
                                                <input type="checkbox"
                                                    class="sr-only peer toggle-checkbox custom-toggle rounded-full">
                                                <div
                                                    class="custom-toggle rounded-full peer peer-focus:ring-2 peer-focus:ring-indigo-300 peer-checked:bg-indigo-600">
                                                </div>
                                                <div
                                                    class="absolute bg-white rounded-full shadow custom-toggle-dot peer-checked:transform peer-checked:translate-x-full">
                                                </div>
                                            </label>
                                        </td>
                                        <td class="px-6 py-3 text-center">
                                            {{-- Vendor Manager: Checked & Enabled --}}
                                            <label class="relative inline-flex items-center cursor-pointer">
                                                <input type="checkbox" checked
                                                    class="sr-only peer toggle-checkbox custom-toggle rounded-full">
                                                <div
                                                    class="custom-toggle rounded-full peer peer-focus:ring-2 peer-focus:ring-indigo-300 peer-checked:bg-indigo-600">
                                                </div>
                                                <div
                                                    class="absolute bg-white rounded-full shadow custom-toggle-dot peer-checked:transform peer-checked:translate-x-full">
                                                </div>
                                            </label>
                                        </td>
                                        <td class="px-6 py-3 text-center">
                                            {{-- Support Staff: Unchecked --}}
                                            <label class="relative inline-flex items-center cursor-pointer">
                                                <input type="checkbox"
                                                    class="sr-only peer toggle-checkbox custom-toggle rounded-full">
                                                <div
                                                    class="custom-toggle rounded-full peer peer-focus:ring-2 peer-focus:ring-indigo-300 peer-checked:bg-indigo-600">
                                                </div>
                                                <div
                                                    class="absolute bg-white rounded-full shadow custom-toggle-dot peer-checked:transform peer-checked:translate-x-full">
                                                </div>
                                            </label>
                                        </td>
                                        <td class="px-6 py-3 text-center">
                                            {{-- Quality Control: Unchecked --}}
                                            <label class="relative inline-flex items-center cursor-pointer">
                                                <input type="checkbox"
                                                    class="sr-only peer toggle-checkbox custom-toggle rounded-full">
                                                <div
                                                    class="custom-toggle rounded-full peer peer-focus:ring-2 peer-focus:ring-indigo-300 peer-checked:bg-indigo-600">
                                                </div>
                                                <div
                                                    class="absolute bg-white rounded-full shadow custom-toggle-dot peer-checked:transform peer-checked:translate-x-full">
                                                </div>
                                            </label>
                                        </td>
                                        <td class="px-6 py-3 text-center">
                                            {{-- Custom Role: Unchecked --}}
                                            <label class="relative inline-flex items-center cursor-pointer">
                                                <input type="checkbox"
                                                    class="sr-only peer toggle-checkbox custom-toggle rounded-full">
                                                <div
                                                    class="custom-toggle rounded-full peer peer-focus:ring-2 peer-focus:ring-indigo-300 peer-checked:bg-indigo-600">
                                                </div>
                                                <div
                                                    class="absolute bg-white rounded-full shadow custom-toggle-dot peer-checked:transform peer-checked:translate-x-full">
                                                </div>
                                            </label>
                                        </td>
                                    </tr>
                                    <tr
                                        class="hover:bg-indigo-50/50 transition-colors duration-150 border-b border-slate-100">
                                        <td class="px-4 py-3 font-medium text-slate-800">Approve documents</td>
                                        <td class="px-6 py-3 text-center">
                                            {{-- Super Admin: Checked & Disabled --}}
                                            <label class="relative inline-flex items-center">
                                                <input type="checkbox" checked disabled
                                                    class="sr-only peer toggle-checkbox custom-toggle rounded-full">
                                                <div
                                                    class="custom-toggle rounded-full peer peer-checked:bg-indigo-600 opacity-60">
                                                </div>
                                                <div
                                                    class="absolute bg-white rounded-full shadow custom-toggle-dot peer-checked:transform peer-checked:translate-x-full opacity-60">
                                                </div>
                                            </label>
                                        </td>
                                        <td class="px-6 py-3 text-center">
                                            {{-- Admin: Checked & Enabled --}}
                                            <label class="relative inline-flex items-center cursor-pointer">
                                                <input type="checkbox" checked
                                                    class="sr-only peer toggle-checkbox custom-toggle rounded-full">
                                                <div
                                                    class="custom-toggle rounded-full peer peer-focus:ring-2 peer-focus:ring-indigo-300 peer-checked:bg-indigo-600">
                                                </div>
                                                <div
                                                    class="absolute bg-white rounded-full shadow custom-toggle-dot peer-checked:transform peer-checked:translate-x-full">
                                                </div>
                                            </label>
                                        </td>
                                        <td class="px-6 py-3 text-center">
                                            {{-- Finance Manager: Unchecked --}}
                                            <label class="relative inline-flex items-center cursor-pointer">
                                                <input type="checkbox"
                                                    class="sr-only peer toggle-checkbox custom-toggle rounded-full">
                                                <div
                                                    class="custom-toggle rounded-full peer peer-focus:ring-2 peer-focus:ring-indigo-300 peer-checked:bg-indigo-600">
                                                </div>
                                                <div
                                                    class="absolute bg-white rounded-full shadow custom-toggle-dot peer-checked:transform peer-checked:translate-x-full">
                                                </div>
                                            </label>
                                        </td>
                                        <td class="px-6 py-3 text-center">
                                            {{-- Vendor Manager: Checked & Enabled --}}
                                            <label class="relative inline-flex items-center cursor-pointer">
                                                <input type="checkbox" checked
                                                    class="sr-only peer toggle-checkbox custom-toggle rounded-full">
                                                <div
                                                    class="custom-toggle rounded-full peer peer-focus:ring-2 peer-focus:ring-indigo-300 peer-checked:bg-indigo-600">
                                                </div>
                                                <div
                                                    class="absolute bg-white rounded-full shadow custom-toggle-dot peer-checked:transform peer-checked:translate-x-full">
                                                </div>
                                            </label>
                                        </td>
                                        <td class="px-6 py-3 text-center">
                                            {{-- Support Staff: Unchecked --}}
                                            <label class="relative inline-flex items-center cursor-pointer">
                                                <input type="checkbox"
                                                    class="sr-only peer toggle-checkbox custom-toggle rounded-full">
                                                <div
                                                    class="custom-toggle rounded-full peer peer-focus:ring-2 peer-focus:ring-indigo-300 peer-checked:bg-indigo-600">
                                                </div>
                                                <div
                                                    class="absolute bg-white rounded-full shadow custom-toggle-dot peer-checked:transform peer-checked:translate-x-full">
                                                </div>
                                            </label>
                                        </td>
                                        <td class="px-6 py-3 text-center">
                                            {{-- Quality Control: Unchecked --}}
                                            <label class="relative inline-flex items-center cursor-pointer">
                                                <input type="checkbox"
                                                    class="sr-only peer toggle-checkbox custom-toggle rounded-full">
                                                <div
                                                    class="custom-toggle rounded-full peer peer-focus:ring-2 peer-focus:ring-indigo-300 peer-checked:bg-indigo-600">
                                                </div>
                                                <div
                                                    class="absolute bg-white rounded-full shadow custom-toggle-dot peer-checked:transform peer-checked:translate-x-full">
                                                </div>
                                            </label>
                                        </td>
                                        <td class="px-6 py-3 text-center">
                                            {{-- Custom Role: Unchecked --}}
                                            <label class="relative inline-flex items-center cursor-pointer">
                                                <input type="checkbox"
                                                    class="sr-only peer toggle-checkbox custom-toggle rounded-full">
                                                <div
                                                    class="custom-toggle rounded-full peer peer-focus:ring-2 peer-focus:ring-indigo-300 peer-checked:bg-indigo-600">
                                                </div>
                                                <div
                                                    class="absolute bg-white rounded-full shadow custom-toggle-dot peer-checked:transform peer-checked:translate-x-full">
                                                </div>
                                            </label>
                                        </td>
                                    </tr>
                                    <tr
                                        class="hover:bg-indigo-50/50 transition-colors duration-150 border-b border-slate-100">
                                        <td class="px-4 py-3 font-medium text-slate-800">View KYC details</td>
                                        <td class="px-6 py-3 text-center">
                                            {{-- Super Admin: Checked & Disabled --}}
                                            <label class="relative inline-flex items-center">
                                                <input type="checkbox" checked disabled
                                                    class="sr-only peer toggle-checkbox custom-toggle rounded-full">
                                                <div
                                                    class="custom-toggle rounded-full peer peer-checked:bg-indigo-600 opacity-60">
                                                </div>
                                                <div
                                                    class="absolute bg-white rounded-full shadow custom-toggle-dot peer-checked:transform peer-checked:translate-x-full opacity-60">
                                                </div>
                                            </label>
                                        </td>
                                        <td class="px-6 py-3 text-center">
                                            {{-- Admin: Unchecked --}}
                                            <label class="relative inline-flex items-center cursor-pointer">
                                                <input type="checkbox"
                                                    class="sr-only peer toggle-checkbox custom-toggle rounded-full">
                                                <div
                                                    class="custom-toggle rounded-full peer peer-focus:ring-2 peer-focus:ring-indigo-300 peer-checked:bg-indigo-600">
                                                </div>
                                                <div
                                                    class="absolute bg-white rounded-full shadow custom-toggle-dot peer-checked:transform peer-checked:translate-x-full">
                                                </div>
                                            </label>
                                        </td>
                                        <td class="px-6 py-3 text-center">
                                            {{-- Finance Manager: Unchecked --}}
                                            <label class="relative inline-flex items-center cursor-pointer">
                                                <input type="checkbox"
                                                    class="sr-only peer toggle-checkbox custom-toggle rounded-full">
                                                <div
                                                    class="custom-toggle rounded-full peer peer-focus:ring-2 peer-focus:ring-indigo-300 peer-checked:bg-indigo-600">
                                                </div>
                                                <div
                                                    class="absolute bg-white rounded-full shadow custom-toggle-dot peer-checked:transform peer-checked:translate-x-full">
                                                </div>
                                            </label>
                                        </td>
                                        <td class="px-6 py-3 text-center">
                                            {{-- Vendor Manager: Checked & Enabled --}}
                                            <label class="relative inline-flex items-center cursor-pointer">
                                                <input type="checkbox" checked
                                                    class="sr-only peer toggle-checkbox custom-toggle rounded-full">
                                                <div
                                                    class="custom-toggle rounded-full peer peer-focus:ring-2 peer-focus:ring-indigo-300 peer-checked:bg-indigo-600">
                                                </div>
                                                <div
                                                    class="absolute bg-white rounded-full shadow custom-toggle-dot peer-checked:transform peer-checked:translate-x-full">
                                                </div>
                                            </label>
                                        </td>
                                        <td class="px-6 py-3 text-center">
                                            {{-- Support Staff: Unchecked --}}
                                            <label class="relative inline-flex items-center cursor-pointer">
                                                <input type="checkbox"
                                                    class="sr-only peer toggle-checkbox custom-toggle rounded-full">
                                                <div
                                                    class="custom-toggle rounded-full peer peer-focus:ring-2 peer-focus:ring-indigo-300 peer-checked:bg-indigo-600">
                                                </div>
                                                <div
                                                    class="absolute bg-white rounded-full shadow custom-toggle-dot peer-checked:transform peer-checked:translate-x-full">
                                                </div>
                                            </label>
                                        </td>
                                        <td class="px-6 py-3 text-center">
                                            {{-- Quality Control: Unchecked --}}
                                            <label class="relative inline-flex items-center cursor-pointer">
                                                <input type="checkbox"
                                                    class="sr-only peer toggle-checkbox custom-toggle rounded-full">
                                                <div
                                                    class="custom-toggle rounded-full peer peer-focus:ring-2 peer-focus:ring-indigo-300 peer-checked:bg-indigo-600">
                                                </div>
                                                <div
                                                    class="absolute bg-white rounded-full shadow custom-toggle-dot peer-checked:transform peer-checked:translate-x-full">
                                                </div>
                                            </label>
                                        </td>
                                        <td class="px-6 py-3 text-center">
                                            {{-- Custom Role: Unchecked --}}
                                            <label class="relative inline-flex items-center cursor-pointer">
                                                <input type="checkbox"
                                                    class="sr-only peer toggle-checkbox custom-toggle rounded-full">
                                                <div
                                                    class="custom-toggle rounded-full peer peer-focus:ring-2 peer-focus:ring-indigo-300 peer-checked:bg-indigo-600">
                                                </div>
                                                <div
                                                    class="absolute bg-white rounded-full shadow custom-toggle-dot peer-checked:transform peer-checked:translate-x-full">
                                                </div>
                                            </label>
                                        </td>
                                    </tr>

                                    {{-- Group: CMS Management --}}
                                    <tr class="bg-slate-100/50 border-t border-b border-slate-200">
                                        <td colspan="8"
                                            class="px-4 py-2 font-extrabold text-xs uppercase tracking-wider text-indigo-600 bg-slate-100">
                                            CMS Management
                                        </td>
                                    </tr>
                                    <tr
                                        class="hover:bg-indigo-50/50 transition-colors duration-150 border-b border-slate-100">
                                        <td class="px-4 py-3 font-medium text-slate-800">Edit CMS pages</td>
                                        <td class="px-6 py-3 text-center">
                                            {{-- Super Admin: Checked & Disabled --}}
                                            <label class="relative inline-flex items-center">
                                                <input type="checkbox" checked disabled
                                                    class="sr-only peer toggle-checkbox custom-toggle rounded-full">
                                                <div
                                                    class="custom-toggle rounded-full peer peer-checked:bg-indigo-600 opacity-60">
                                                </div>
                                                <div
                                                    class="absolute bg-white rounded-full shadow custom-toggle-dot peer-checked:transform peer-checked:translate-x-full opacity-60">
                                                </div>
                                            </label>
                                        </td>
                                        <td class="px-6 py-3 text-center">
                                            {{-- Admin: Checked & Enabled --}}
                                            <label class="relative inline-flex items-center cursor-pointer">
                                                <input type="checkbox" checked
                                                    class="sr-only peer toggle-checkbox custom-toggle rounded-full">
                                                <div
                                                    class="custom-toggle rounded-full peer peer-focus:ring-2 peer-focus:ring-indigo-300 peer-checked:bg-indigo-600">
                                                </div>
                                                <div
                                                    class="absolute bg-white rounded-full shadow custom-toggle-dot peer-checked:transform peer-checked:translate-x-full">
                                                </div>
                                            </label>
                                        </td>
                                        <td class="px-6 py-3 text-center">
                                            {{-- Finance Manager: Unchecked --}}
                                            <label class="relative inline-flex items-center cursor-pointer">
                                                <input type="checkbox"
                                                    class="sr-only peer toggle-checkbox custom-toggle rounded-full">
                                                <div
                                                    class="custom-toggle rounded-full peer peer-focus:ring-2 peer-focus:ring-indigo-300 peer-checked:bg-indigo-600">
                                                </div>
                                                <div
                                                    class="absolute bg-white rounded-full shadow custom-toggle-dot peer-checked:transform peer-checked:translate-x-full">
                                                </div>
                                            </label>
                                        </td>
                                        <td class="px-6 py-3 text-center">
                                            {{-- Vendor Manager: Unchecked --}}
                                            <label class="relative inline-flex items-center cursor-pointer">
                                                <input type="checkbox"
                                                    class="sr-only peer toggle-checkbox custom-toggle rounded-full">
                                                <div
                                                    class="custom-toggle rounded-full peer peer-focus:ring-2 peer-focus:ring-indigo-300 peer-checked:bg-indigo-600">
                                                </div>
                                                <div
                                                    class="absolute bg-white rounded-full shadow custom-toggle-dot peer-checked:transform peer-checked:translate-x-full">
                                                </div>
                                            </label>
                                        </td>
                                        <td class="px-6 py-3 text-center">
                                            {{-- Support Staff: Unchecked --}}
                                            <label class="relative inline-flex items-center cursor-pointer">
                                                <input type="checkbox"
                                                    class="sr-only peer toggle-checkbox custom-toggle rounded-full">
                                                <div
                                                    class="custom-toggle rounded-full peer peer-focus:ring-2 peer-focus:ring-indigo-300 peer-checked:bg-indigo-600">
                                                </div>
                                                <div
                                                    class="absolute bg-white rounded-full shadow custom-toggle-dot peer-checked:transform peer-checked:translate-x-full">
                                                </div>
                                            </label>
                                        </td>
                                        <td class="px-6 py-3 text-center">
                                            {{-- Quality Control: Checked & Enabled --}}
                                            <label class="relative inline-flex items-center cursor-pointer">
                                                <input type="checkbox" checked
                                                    class="sr-only peer toggle-checkbox custom-toggle rounded-full">
                                                <div
                                                    class="custom-toggle rounded-full peer peer-focus:ring-2 peer-focus:ring-indigo-300 peer-checked:bg-indigo-600">
                                                </div>
                                                <div
                                                    class="absolute bg-white rounded-full shadow custom-toggle-dot peer-checked:transform peer-checked:translate-x-full">
                                                </div>
                                            </label>
                                        </td>
                                        <td class="px-6 py-3 text-center">
                                            {{-- Custom Role: Unchecked --}}
                                            <label class="relative inline-flex items-center cursor-pointer">
                                                <input type="checkbox"
                                                    class="sr-only peer toggle-checkbox custom-toggle rounded-full">
                                                <div
                                                    class="custom-toggle rounded-full peer peer-focus:ring-2 peer-focus:ring-indigo-300 peer-checked:bg-indigo-600">
                                                </div>
                                                <div
                                                    class="absolute bg-white rounded-full shadow custom-toggle-dot peer-checked:transform peer-checked:translate-x-full">
                                                </div>
                                            </label>
                                        </td>
                                    </tr>
                                    <tr
                                        class="hover:bg-indigo-50/50 transition-colors duration-150 border-b border-slate-100">
                                        <td class="px-4 py-3 font-medium text-slate-800">Control push notifications</td>
                                        <td class="px-6 py-3 text-center">
                                            {{-- Super Admin: Checked & Disabled --}}
                                            <label class="relative inline-flex items-center">
                                                <input type="checkbox" checked disabled
                                                    class="sr-only peer toggle-checkbox custom-toggle rounded-full">
                                                <div
                                                    class="custom-toggle rounded-full peer peer-checked:bg-indigo-600 opacity-60">
                                                </div>
                                                <div
                                                    class="absolute bg-white rounded-full shadow custom-toggle-dot peer-checked:transform peer-checked:translate-x-full opacity-60">
                                                </div>
                                            </label>
                                        </td>
                                        <td class="px-6 py-3 text-center">
                                            {{-- Admin: Checked & Enabled --}}
                                            <label class="relative inline-flex items-center cursor-pointer">
                                                <input type="checkbox" checked
                                                    class="sr-only peer toggle-checkbox custom-toggle rounded-full">
                                                <div
                                                    class="custom-toggle rounded-full peer peer-focus:ring-2 peer-focus:ring-indigo-300 peer-checked:bg-indigo-600">
                                                </div>
                                                <div
                                                    class="absolute bg-white rounded-full shadow custom-toggle-dot peer-checked:transform peer-checked:translate-x-full">
                                                </div>
                                            </label>
                                        </td>
                                        <td class="px-6 py-3 text-center">
                                            {{-- Finance Manager: Unchecked --}}
                                            <label class="relative inline-flex items-center cursor-pointer">
                                                <input type="checkbox"
                                                    class="sr-only peer toggle-checkbox custom-toggle rounded-full">
                                                <div
                                                    class="custom-toggle rounded-full peer peer-focus:ring-2 peer-focus:ring-indigo-300 peer-checked:bg-indigo-600">
                                                </div>
                                                <div
                                                    class="absolute bg-white rounded-full shadow custom-toggle-dot peer-checked:transform peer-checked:translate-x-full">
                                                </div>
                                            </label>
                                        </td>
                                        <td class="px-6 py-3 text-center">
                                            {{-- Vendor Manager: Unchecked --}}
                                            <label class="relative inline-flex items-center cursor-pointer">
                                                <input type="checkbox"
                                                    class="sr-only peer toggle-checkbox custom-toggle rounded-full">
                                                <div
                                                    class="custom-toggle rounded-full peer peer-focus:ring-2 peer-focus:ring-indigo-300 peer-checked:bg-indigo-600">
                                                </div>
                                                <div
                                                    class="absolute bg-white rounded-full shadow custom-toggle-dot peer-checked:transform peer-checked:translate-x-full">
                                                </div>
                                            </label>
                                        </td>
                                        <td class="px-6 py-3 text-center">
                                            {{-- Support Staff: Unchecked --}}
                                            <label class="relative inline-flex items-center cursor-pointer">
                                                <input type="checkbox"
                                                    class="sr-only peer toggle-checkbox custom-toggle rounded-full">
                                                <div
                                                    class="custom-toggle rounded-full peer peer-focus:ring-2 peer-focus:ring-indigo-300 peer-checked:bg-indigo-600">
                                                </div>
                                                <div
                                                    class="absolute bg-white rounded-full shadow custom-toggle-dot peer-checked:transform peer-checked:translate-x-full">
                                                </div>
                                            </label>
                                        </td>
                                        <td class="px-6 py-3 text-center">
                                            {{-- Quality Control: Unchecked --}}
                                            <label class="relative inline-flex items-center cursor-pointer">
                                                <input type="checkbox"
                                                    class="sr-only peer toggle-checkbox custom-toggle rounded-full">
                                                <div
                                                    class="custom-toggle rounded-full peer peer-focus:ring-2 peer-focus:ring-indigo-300 peer-checked:bg-indigo-600">
                                                </div>
                                                <div
                                                    class="absolute bg-white rounded-full shadow custom-toggle-dot peer-checked:transform peer-checked:translate-x-full">
                                                </div>
                                            </label>
                                        </td>
                                        <td class="px-6 py-3 text-center">
                                            {{-- Custom Role: Unchecked --}}
                                            <label class="relative inline-flex items-center cursor-pointer">
                                                <input type="checkbox"
                                                    class="sr-only peer toggle-checkbox custom-toggle rounded-full">
                                                <div
                                                    class="custom-toggle rounded-full peer peer-focus:ring-2 peer-focus:ring-indigo-300 peer-checked:bg-indigo-600">
                                                </div>
                                                <div
                                                    class="absolute bg-white rounded-full shadow custom-toggle-dot peer-checked:transform peer-checked:translate-x-full">
                                                </div>
                                            </label>
                                        </td>
                                    </tr>

                                    {{-- Group: AI & Automation --}}
                                    <tr class="bg-slate-100/50 border-t border-b border-slate-200">
                                        <td colspan="8"
                                            class="px-4 py-2 font-extrabold text-xs uppercase tracking-wider text-indigo-600 bg-slate-100">
                                            AI & Automation
                                        </td>
                                    </tr>
                                    <tr
                                        class="hover:bg-indigo-50/50 transition-colors duration-150 border-b border-slate-100">
                                        <td class="px-4 py-3 font-medium text-slate-800">Access AI recommendations</td>
                                        <td class="px-6 py-3 text-center">
                                            {{-- Super Admin: Checked & Disabled --}}
                                            <label class="relative inline-flex items-center">
                                                <input type="checkbox" checked disabled
                                                    class="sr-only peer toggle-checkbox custom-toggle rounded-full">
                                                <div
                                                    class="custom-toggle rounded-full peer peer-checked:bg-indigo-600 opacity-60">
                                                </div>
                                                <div
                                                    class="absolute bg-white rounded-full shadow custom-toggle-dot peer-checked:transform peer-checked:translate-x-full opacity-60">
                                                </div>
                                            </label>
                                        </td>
                                        <td class="px-6 py-3 text-center">
                                            {{-- Admin: Unchecked --}}
                                            <label class="relative inline-flex items-center cursor-pointer">
                                                <input type="checkbox"
                                                    class="sr-only peer toggle-checkbox custom-toggle rounded-full">
                                                <div
                                                    class="custom-toggle rounded-full peer peer-focus:ring-2 peer-focus:ring-indigo-300 peer-checked:bg-indigo-600">
                                                </div>
                                                <div
                                                    class="absolute bg-white rounded-full shadow custom-toggle-dot peer-checked:transform peer-checked:translate-x-full">
                                                </div>
                                            </label>
                                        </td>
                                        <td class="px-6 py-3 text-center">
                                            {{-- Finance Manager: Unchecked --}}
                                            <label class="relative inline-flex items-center cursor-pointer">
                                                <input type="checkbox"
                                                    class="sr-only peer toggle-checkbox custom-toggle rounded-full">
                                                <div
                                                    class="custom-toggle rounded-full peer peer-focus:ring-2 peer-focus:ring-indigo-300 peer-checked:bg-indigo-600">
                                                </div>
                                                <div
                                                    class="absolute bg-white rounded-full shadow custom-toggle-dot peer-checked:transform peer-checked:translate-x-full">
                                                </div>
                                            </label>
                                        </td>
                                        <td class="px-6 py-3 text-center">
                                            {{-- Vendor Manager: Unchecked --}}
                                            <label class="relative inline-flex items-center cursor-pointer">
                                                <input type="checkbox"
                                                    class="sr-only peer toggle-checkbox custom-toggle rounded-full">
                                                <div
                                                    class="custom-toggle rounded-full peer peer-focus:ring-2 peer-focus:ring-indigo-300 peer-checked:bg-indigo-600">
                                                </div>
                                                <div
                                                    class="absolute bg-white rounded-full shadow custom-toggle-dot peer-checked:transform peer-checked:translate-x-full">
                                                </div>
                                            </label>
                                        </td>
                                        <td class="px-6 py-3 text-center">
                                            {{-- Support Staff: Unchecked --}}
                                            <label class="relative inline-flex items-center cursor-pointer">
                                                <input type="checkbox"
                                                    class="sr-only peer toggle-checkbox custom-toggle rounded-full">
                                                <div
                                                    class="custom-toggle rounded-full peer peer-focus:ring-2 peer-focus:ring-indigo-300 peer-checked:bg-indigo-600">
                                                </div>
                                                <div
                                                    class="absolute bg-white rounded-full shadow custom-toggle-dot peer-checked:transform peer-checked:translate-x-full">
                                                </div>
                                            </label>
                                        </td>
                                        <td class="px-6 py-3 text-center">
                                            {{-- Quality Control: Unchecked --}}
                                            <label class="relative inline-flex items-center cursor-pointer">
                                                <input type="checkbox"
                                                    class="sr-only peer toggle-checkbox custom-toggle rounded-full">
                                                <div
                                                    class="custom-toggle rounded-full peer peer-focus:ring-2 peer-focus:ring-indigo-300 peer-checked:bg-indigo-600">
                                                </div>
                                                <div
                                                    class="absolute bg-white rounded-full shadow custom-toggle-dot peer-checked:transform peer-checked:translate-x-full">
                                                </div>
                                            </label>
                                        </td>
                                        <td class="px-6 py-3 text-center">
                                            {{-- Custom Role: Checked & Enabled --}}
                                            <label class="relative inline-flex items-center cursor-pointer">
                                                <input type="checkbox" checked
                                                    class="sr-only peer toggle-checkbox custom-toggle rounded-full">
                                                <div
                                                    class="custom-toggle rounded-full peer peer-focus:ring-2 peer-focus:ring-indigo-300 peer-checked:bg-indigo-600">
                                                </div>
                                                <div
                                                    class="absolute bg-white rounded-full shadow custom-toggle-dot peer-checked:transform peer-checked:translate-x-full">
                                                </div>
                                            </label>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    {{-- 2. Role Cards (Alternative View - Hidden by default) --}}
                    <div id="cards-view" class="hidden grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        {{-- Role Card: Super Admin --}}
                        <div
                            class="bg-white rounded-2xl p-6 shadow-xl border border-slate-100 transition-all duration-300 ease-in-out transform hover:shadow-2xl hover:border-indigo-200 space-y-4">
                            <div class="flex items-start justify-between">
                                <h3 class="text-xl font-bold text-slate-900">Super Admin</h3>
                                <span class="text-xs font-semibold text-slate-500">Updated: 2 days ago</span>
                            </div>
                            <p class="text-sm text-slate-600">Unrestricted system access. Should be assigned with extreme
                                caution.</p>
                            <div class="flex flex-wrap gap-2">
                                <span
                                    class="inline-flex items-center rounded-full bg-red-100 px-3 py-1 text-xs font-medium text-red-700">
                                    94 Permissions
                                </span>
                                <span
                                    class="inline-flex items-center rounded-full bg-slate-100 px-3 py-1 text-xs font-medium text-slate-700 cursor-pointer hover:bg-slate-200 transition-colors">
                                    Core
                                </span>
                                <span
                                    class="inline-flex items-center rounded-full bg-slate-100 px-3 py-1 text-xs font-medium text-slate-700 cursor-pointer hover:bg-slate-200 transition-colors">
                                    Locked
                                </span>
                            </div>
                            <div class="border-t border-slate-100 pt-4 flex space-x-3">
                                <button onclick="openManagePermissions('Super Admin')"
                                    class="inline-flex items-center justify-center px-3 py-2 text-sm font-medium rounded-xl text-white bg-indigo-600 hover:bg-indigo-700 transition-colors shadow-md">
                                    Manage Permissions
                                </button>
                                <button
                                    class="px-3 py-2 text-sm font-medium rounded-xl text-slate-700 bg-slate-100 hover:bg-slate-200 transition-colors">
                                    Edit
                                </button>
                                <button class="text-red-500 hover:text-red-700 transition-colors p-2 rounded-xl">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                        </path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                        {{-- Role Card: Finance Manager --}}
                        <div
                            class="bg-white rounded-2xl p-6 shadow-xl border border-slate-100 transition-all duration-300 ease-in-out transform hover:shadow-2xl hover:border-indigo-200 space-y-4">
                            <div class="flex items-start justify-between">
                                <h3 class="text-xl font-bold text-slate-900">Finance Manager</h3>
                                <span class="text-xs font-semibold text-slate-500">Updated: 1 hour ago</span>
                            </div>
                            <p class="text-sm text-slate-600">Access to all financial and accounting modules, including
                                reports and payouts.</p>
                            <div class="flex flex-wrap gap-2">
                                <span
                                    class="inline-flex items-center rounded-full bg-indigo-100 px-3 py-1 text-xs font-medium text-indigo-700">
                                    18 Permissions
                                </span>
                                <span
                                    class="inline-flex items-center rounded-full bg-slate-100 px-3 py-1 text-xs font-medium text-slate-700 cursor-pointer hover:bg-slate-200 transition-colors">
                                    Finance
                                </span>
                                <span
                                    class="inline-flex items-center rounded-full bg-slate-100 px-3 py-1 text-xs font-medium text-slate-700 cursor-pointer hover:bg-slate-200 transition-colors">
                                    Reports
                                </span>
                            </div>
                            <div class="border-t border-slate-100 pt-4 flex space-x-3">
                                <button onclick="openManagePermissions('Finance Manager')"
                                    class="inline-flex items-center justify-center px-3 py-2 text-sm font-medium rounded-xl text-white bg-indigo-600 hover:bg-indigo-700 transition-colors shadow-md">
                                    Manage Permissions
                                </button>
                                <button
                                    class="px-3 py-2 text-sm font-medium rounded-xl text-slate-700 bg-slate-100 hover:bg-slate-200 transition-colors">
                                    Edit
                                </button>
                                <button class="text-red-500 hover:text-red-700 transition-colors p-2 rounded-xl">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                        </path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                        {{-- Role Card: Support Staff --}}
                        <div
                            class="bg-white rounded-2xl p-6 shadow-xl border border-slate-100 transition-all duration-300 ease-in-out transform hover:shadow-2xl hover:border-indigo-200 space-y-4">
                            <div class="flex items-start justify-between">
                                <h3 class="text-xl font-bold text-slate-900">Support Staff</h3>
                                <span class="text-xs font-semibold text-slate-500">Updated: 5 days ago</span>
                            </div>
                            <p class="text-sm text-slate-600">Access to customer support tools and complaint handling
                                systems.</p>
                            <div class="flex flex-wrap gap-2">
                                <span
                                    class="inline-flex items-center rounded-full bg-indigo-100 px-3 py-1 text-xs font-medium text-indigo-700">
                                    7 Permissions
                                </span>
                                <span
                                    class="inline-flex items-center rounded-full bg-slate-100 px-3 py-1 text-xs font-medium text-slate-700 cursor-pointer hover:bg-slate-200 transition-colors">
                                    Support
                                </span>
                                <span
                                    class="inline-flex items-center rounded-full bg-slate-100 px-3 py-1 text-xs font-medium text-slate-700 cursor-pointer hover:bg-slate-200 transition-colors">
                                    Tickets
                                </span>
                            </div>
                            <div class="border-t border-slate-100 pt-4 flex space-x-3">
                                <button onclick="openManagePermissions('Support Staff')"
                                    class="inline-flex items-center justify-center px-3 py-2 text-sm font-medium rounded-xl text-white bg-indigo-600 hover:bg-indigo-700 transition-colors shadow-md">
                                    Manage Permissions
                                </button>
                                <button
                                    class="px-3 py-2 text-sm font-medium rounded-xl text-slate-700 bg-slate-100 hover:bg-slate-200 transition-colors">
                                    Edit
                                </button>
                                <button class="text-red-500 hover:text-red-700 transition-colors p-2 rounded-xl">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                        </path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
        </section>

    </div>

    {{-- 4. Assign Permissions Modal / Slide-Over (Hidden by default) --}}
    <div id="managePermissionsSlideover" class="hidden fixed inset-0 z-50 overflow-hidden">
        {{-- Backdrop (Modal Overlay) --}}
        <div id="slideover-backdrop" onclick="closeManagePermissions()"
            class="absolute inset-0 bg-slate-900/50 transition-opacity duration-300 opacity-0 pointer-events-none"
            aria-hidden="true"></div>

        {{-- Slide-Over Panel --}}
        <div id="slideover-panel"
            class="fixed inset-y-0 right-0 max-w-full flex transition-transform duration-300 transform translate-x-full">
            <div class="w-screen max-w-xl">
                <div class="h-full flex flex-col bg-white shadow-2xl rounded-l-2xl overflow-y-auto">

                    {{-- Header --}}
                    <div class="p-6 bg-slate-50 border-b border-slate-200 flex items-center justify-between shadow-sm">
                        <h2 class="text-2xl font-bold text-slate-900">Manage Permissions for: <span
                                id="slideover-role-name" class="text-indigo-600">Admin</span></h2>
                        <button onclick="closeManagePermissions()"
                            class="text-slate-400 hover:text-slate-600 transition-colors">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>

                    {{-- Summary and Search --}}
                    <div class="p-6 space-y-4">
                        <div class="flex flex-wrap gap-2 text-sm text-slate-600">
                            <span class="px-3 py-1 bg-indigo-100 rounded-full font-medium">42 Permissions Assigned</span>
                            <span class="px-3 py-1 bg-slate-100 rounded-full">Operational Role</span>
                        </div>
                        <input type="text" placeholder="Search permissions (e.g., 'refund')"
                            class="w-full px-4 py-2 border border-slate-300 rounded-xl focus:ring-indigo-500 focus:border-indigo-500 transition-colors shadow-sm">
                        {{-- Category Filter (Dropdown/Select for mobile sidebar categories) --}}
                        <select class="w-full px-4 py-2 border border-slate-300 rounded-xl">
                            <option>Filter by Category...</option>
                            <option>User Management</option>
                            <option>Financial Actions</option>
                        </select>
                    </div>

                    {{-- Permission List (Grouped) --}}
                    <div class="flex-1 overflow-y-auto p-6 space-y-6">
                        <div class="border-b border-slate-200 pb-4">
                            <div class="flex items-center justify-between mb-3">
                                <h3 class="text-lg font-bold text-slate-800">User Management</h3>
                                <button
                                    class="text-xs font-semibold text-indigo-600 hover:text-indigo-800 transition-colors">
                                    Select All in Category
                                </button>
                            </div>
                            <div class="space-y-3">
                                <div
                                    class="flex items-center justify-between p-3 bg-slate-50 rounded-lg transition-colors hover:bg-indigo-50/50 border border-slate-100">
                                    <span class="text-sm text-slate-700">Can assign riders</span>
                                    <label class="relative inline-flex items-center cursor-pointer">
                                        <input type="checkbox" checked
                                            class="sr-only peer toggle-checkbox custom-toggle rounded-full">
                                        <div
                                            class="custom-toggle rounded-full peer peer-focus:ring-2 peer-focus:ring-indigo-300 peer-checked:bg-indigo-600">
                                        </div>
                                        <div
                                            class="absolute bg-white rounded-full shadow custom-toggle-dot peer-checked:transform peer-checked:translate-x-full">
                                        </div>
                                    </label>
                                </div>
                                <div
                                    class="flex items-center justify-between p-3 bg-slate-50 rounded-lg transition-colors hover:bg-indigo-50/50 border border-slate-100">
                                    <span class="text-sm text-slate-700">Create/Edit User Profiles</span>
                                    <label class="relative inline-flex items-center cursor-pointer">
                                        <input type="checkbox" checked
                                            class="sr-only peer toggle-checkbox custom-toggle rounded-full">
                                        <div
                                            class="custom-toggle rounded-full peer peer-focus:ring-2 peer-focus:ring-indigo-300 peer-checked:bg-indigo-600">
                                        </div>
                                        <div
                                            class="absolute bg-white rounded-full shadow custom-toggle-dot peer-checked:transform peer-checked:translate-x-full">
                                        </div>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="border-b border-slate-200 pb-4">
                            <div class="flex items-center justify-between mb-3">
                                <h3 class="text-lg font-bold text-slate-800">Financial Actions</h3>
                                <button
                                    class="text-xs font-semibold text-indigo-600 hover:text-indigo-800 transition-colors">
                                    Select All in Category
                                </button>
                            </div>
                            <div class="space-y-3">
                                <div
                                    class="flex items-center justify-between p-3 bg-slate-50 rounded-lg transition-colors hover:bg-indigo-50/50 border border-slate-100">
                                    <span class="text-sm text-slate-700">Access refund operations</span>
                                    <label class="relative inline-flex items-center cursor-pointer">
                                        <input type="checkbox" checked
                                            class="sr-only peer toggle-checkbox custom-toggle rounded-full">
                                        <div
                                            class="custom-toggle rounded-full peer peer-focus:ring-2 peer-focus:ring-indigo-300 peer-checked:bg-indigo-600">
                                        </div>
                                        <div
                                            class="absolute bg-white rounded-full shadow custom-toggle-dot peer-checked:transform peer-checked:translate-x-full">
                                        </div>
                                    </label>
                                </div>
                                <div
                                    class="flex items-center justify-between p-3 bg-slate-50 rounded-lg transition-colors hover:bg-indigo-50/50 border border-slate-100">
                                    <span class="text-sm text-slate-700">Manage tax configuration</span>
                                    <label class="relative inline-flex items-center cursor-pointer">
                                        <input type="checkbox"
                                            class="sr-only peer toggle-checkbox custom-toggle rounded-full">
                                        <div
                                            class="custom-toggle rounded-full peer peer-focus:ring-2 peer-focus:ring-indigo-300 peer-checked:bg-indigo-600">
                                        </div>
                                        <div
                                            class="absolute bg-white rounded-full shadow custom-toggle-dot peer-checked:transform peer-checked:translate-x-full">
                                        </div>
                                    </label>
                                </div>
                                <div
                                    class="flex items-center justify-between p-3 bg-slate-50 rounded-lg transition-colors hover:bg-indigo-50/50 border border-slate-100">
                                    <span class="text-sm text-slate-700">Payout Management</span>
                                    <label class="relative inline-flex items-center cursor-pointer">
                                        <input type="checkbox" checked
                                            class="sr-only peer toggle-checkbox custom-toggle rounded-full">
                                        <div
                                            class="custom-toggle rounded-full peer peer-focus:ring-2 peer-focus:ring-indigo-300 peer-checked:bg-indigo-600">
                                        </div>
                                        <div
                                            class="absolute bg-white rounded-full shadow custom-toggle-dot peer-checked:transform peer-checked:translate-x-full">
                                        </div>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Footer / Save Button --}}
                    <div class="p-6 bg-white border-t border-slate-200 shadow-xl">
                        <button
                            class="w-full py-3 bg-indigo-600 text-white font-semibold rounded-xl shadow-lg hover:bg-indigo-700 transition-all duration-300 ease-in-out transform hover:scale-[1.01] active:scale-[0.99]">
                            Save Changes (42/94 Permissions)
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Add New Role Modal --}}
    <div id="addRoleModal"
        class="hidden fixed inset-0 bg-slate-900/50 z-[60] flex items-center justify-center transition-opacity duration-300">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-lg m-4 transition-transform duration-300 transform scale-95"
            role="dialog" aria-modal="true">
            <div class="p-8 space-y-6">
                <header class="flex items-center justify-between">
                    <h3 class="text-2xl font-bold text-slate-900">Create New Role</h3>
                    <button onclick="document.getElementById('addRoleModal').classList.add('hidden')"
                        class="text-slate-400 hover:text-slate-600 transition-colors">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </header>

                <form class="space-y-4">
                    <div>
                        <label for="role_name" class="block text-sm font-medium text-slate-700 mb-1">Role Name</label>
                        <input type="text" id="role_name" placeholder="e.g., Marketing Analyst"
                            class="w-full px-4 py-2 border border-slate-300 rounded-xl focus:ring-indigo-500 focus:border-indigo-500 transition-colors shadow-sm"
                            required>
                    </div>
                   
                </form>

                <footer class="flex justify-end space-x-3 pt-4">
                    <button onclick="document.getElementById('addRoleModal').classList.add('hidden')" type="button"
                        class="px-5 py-2 text-sm font-medium rounded-xl text-slate-700 bg-slate-100 hover:bg-slate-200 transition-colors">
                        Cancel
                    </button>
                    <button type="submit"
                        class="px-5 py-2 text-sm font-medium rounded-xl text-white bg-indigo-600 hover:bg-indigo-700 transition-colors shadow-md">
                        Create Role & Assign Permissions
                    </button>
                </footer>
            </div>
        </div>
    </div>

    {{-- Add New Role Modal --}}
    <div id="addPermissionModal"
        class="hidden fixed inset-0 bg-slate-900/50 z-[60] flex items-center justify-center transition-opacity duration-300">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-lg m-4 transition-transform duration-300 transform scale-95"
            role="dialog" aria-modal="true">
            <div class="p-8 space-y-6">
                <header class="flex items-center justify-between">
                    <h3 class="text-2xl font-bold text-slate-900">Create New Role </h3>
                    <button onclick="document.getElementById('addPermissionModal').classList.add('hidden')"
                        class="text-slate-400 hover:text-slate-600 transition-colors">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </header>

                <form class="space-y-4">
                    <div>
                        <label for="role_name" class="block text-sm font-medium text-slate-700 mb-1">Permission Name</label>
                        <input type="text" id="role_name" placeholder="e.g., Marketing Analyst"
                            class="w-full px-4 py-2 border border-slate-300 rounded-xl focus:ring-indigo-500 focus:border-indigo-500 transition-colors shadow-sm"
                            required>
                    </div>
                   
                </form>

                <footer class="flex justify-end space-x-3 pt-4">
                    <button onclick="document.getElementById('addPermissionModal').classList.add('hidden')"
                        type="button"
                        class="px-5 py-2 text-sm font-medium rounded-xl text-slate-700 bg-slate-100 hover:bg-slate-200 transition-colors">
                        Cancel
                    </button>
                    <button type="submit"
                        class="px-5 py-2 text-sm font-medium rounded-xl text-white bg-indigo-600 hover:bg-indigo-700 transition-colors shadow-md">
                        Create Role & Assign Permissions
                    </button>
                </footer>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        /* Custom Scrollbar for matrix to match premium UI */
        #matrix-view::-webkit-scrollbar {
            height: 8px;
            width: 8px;
        }

        #matrix-view::-webkit-scrollbar-thumb {
            background-color: #cbd5e1;
            /* slate-300 */
            border-radius: 4px;
        }

        #matrix-view::-webkit-scrollbar-track {
            background-color: #f8fafc;
            /* slate-50 */
        }

        /* Custom Toggle Switch (Linear/Stripe Style) */
        .custom-toggle {
            width: 3rem;
            height: 1.5rem;
            background-color: #e2e8f0;
            /* slate-200 */
            transition: background-color 0.2s;
            border-radius: 9999px;
            /* Tailwind's rounded-full */
        }

        .custom-toggle:checked {
            background-color: #4f46e5;
            /* indigo-600 */
        }

        .custom-toggle-dot {
            width: 1.25rem;
            height: 1.25rem;
            background-color: white;
            border-radius: 9999px;
            transform: translate(0.125rem, 0.125rem);
            /* Adjust initial position */
            transition: transform 0.2s;
        }

        .custom-toggle:checked~.custom-toggle-dot {
            transform: translate(1.625rem, 0.125rem);
            /* 3rem width - 1.25rem dot - 0.125rem padding = 1.625rem translation */
        }

        .active-view-btn {
            background-color: white;
            color: #4f46e5;
            /* indigo-600 */
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
        }
    </style>
@endpush

@push('scripts')
    <script>
        // Toggle between Matrix and Card View
        function switchView(view) {
            document.getElementById('matrix-view').classList.toggle('hidden', view !== 'matrix');
            document.getElementById('cards-view').classList.toggle('hidden', view !== 'cards');

            document.querySelectorAll('.view-toggle-btn').forEach(btn => {
                btn.classList.remove('active-view-btn', 'text-indigo-600');
                btn.classList.add('text-slate-500', 'hover:text-indigo-600');
            });

            const activeBtn = document.getElementById(`toggle-${view}`);
            activeBtn.classList.add('active-view-btn', 'text-indigo-600');
            activeBtn.classList.remove('text-slate-500', 'hover:text-indigo-600');
        }

        // Slide-Over functionality
        function openManagePermissions(roleName) {
            // Update modal content
            document.getElementById('slideover-role-name').textContent = roleName;

            // Show the slide-over
            document.getElementById('managePermissionsSlideover').classList.remove('hidden');
            document.getElementById('slideover-backdrop').classList.remove('opacity-0', 'pointer-events-none');
            document.getElementById('slideover-panel').classList.remove('translate-x-full');
        }

        function closeManagePermissions() {
            // Hide the slide-over
            document.getElementById('slideover-backdrop').classList.add('opacity-0', 'pointer-events-none');
            document.getElementById('slideover-panel').classList.add('translate-x-full');
            setTimeout(() => {
                document.getElementById('managePermissionsSlideover').classList.add('hidden');
            }, 300); // Wait for transition
        }
    </script>
@endpush
