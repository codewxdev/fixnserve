@extends('layouts.app')

@section('content')
<div id="app" class="min-h-screen bg-slate-50/50 space-y-8 p-6 lg:p-10 font-sans text-slate-600">

    {{-- A. Header Section --}}
    <header class="flex flex-col md:flex-row md:items-end md:justify-between space-y-4 md:space-y-0">
        <div>
            {{-- Breadcrumb --}}
            <nav class="text-xs font-semibold uppercase tracking-wider text-slate-400 mb-2">
                <ol class="inline-flex items-center space-x-1 md:space-x-2">
                    <li><a href="#" class="hover:text-indigo-600 transition-colors">Dashboard</a></li>
                    <li><span class="text-slate-300">/</span></li>
                    <li><a href="#" class="hover:text-indigo-600 transition-colors">Settings</a></li>
                    <li><span class="text-slate-300">/</span></li>
                    <li class="text-indigo-600">Roles & Permissions</li>
                </ol>
            </nav>

            {{-- Title --}}
            <h1 class="text-3xl md:text-4xl font-extrabold text-slate-900 tracking-tight">
                Access Control
            </h1>
            <p class="text-base text-slate-500 mt-2 max-w-2xl">
                Manage role hierarchies and fine-tune permission levels to ensure secure and efficient system access.
            </p>
        </div>

        <div class="flex flex-wrap gap-3">
            <button onclick="document.getElementById('addRoleModal').classList.remove('hidden')"
                class="inline-flex items-center px-5 py-2.5 bg-white border border-slate-200 text-slate-700 font-semibold rounded-xl shadow-sm hover:bg-slate-50 hover:border-indigo-300 hover:text-indigo-600 transition-all duration-300">
                <svg class="w-5 h-5 mr-2 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20v-2c0-.656-.126-1.283-.356-1.857M9 20H7a4 4 0 01-4-4v-2.586a1 1 0 01.293-.707l3.95-3.95a1 1 0 01.707-.293h2.586M7 20v-2c0-.656.126-1.283.356-1.857M11 5a2 2 0 11-4 0 2 2 0 014 0zM12 12a4 4 0 100-8 4 4 0 000 8z">
                    </path>
                </svg>
                New Role
            </button>
            <button onclick="document.getElementById('addPermissionModal').classList.remove('hidden')"
                class="inline-flex items-center px-5 py-2.5 bg-indigo-600 text-white font-semibold rounded-xl shadow-lg shadow-indigo-200 hover:bg-indigo-700 hover:shadow-indigo-300 transition-all duration-300 transform hover:-translate-y-0.5">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                New Permission
            </button>
        </div>
    </header>

    {{-- B. Stats Overview --}}
    <section id="stats-section" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        <div id="total-roles-card"
            class="group bg-white p-6 rounded-2xl shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-slate-100 hover:border-indigo-100 transition-all duration-300">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 rounded-xl bg-indigo-50 text-indigo-600 group-hover:bg-indigo-600 group-hover:text-white transition-colors duration-300">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                    </svg>
                </div>
                <span class="text-xs font-bold text-green-500 bg-green-50 px-2 py-1 rounded-lg">+2 this week</span>
            </div>
            <p class="text-slate-500 text-sm font-medium">Active Roles</p>
            <h3 class="text-3xl font-bold text-slate-800" id="stat-total-roles">...</h3>
        </div>

        <div id="total-permissions-card"
            class="group bg-white p-6 rounded-2xl shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-slate-100 hover:border-emerald-100 transition-all duration-300">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 rounded-xl bg-emerald-50 text-emerald-600 group-hover:bg-emerald-600 group-hover:text-white transition-colors duration-300">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
            <p class="text-slate-500 text-sm font-medium">Total Permissions</p>
            <h3 class="text-3xl font-bold text-slate-800" id="stat-total-permissions">...</h3>
        </div>

        <div class="group bg-white p-6 rounded-2xl shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-slate-100 hover:border-blue-100 transition-all duration-300">
             <div class="flex items-center justify-between mb-4">
                <div class="p-3 rounded-xl bg-blue-50 text-blue-600 group-hover:bg-blue-600 group-hover:text-white transition-colors duration-300">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0v-2a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                    </svg>
                </div>
            </div>
            <p class="text-slate-500 text-sm font-medium">System Modules</p>
            <h3 class="text-3xl font-bold text-slate-800">8</h3>
        </div>

        <div class="group bg-gradient-to-br from-indigo-600 to-purple-700 p-6 rounded-2xl shadow-xl shadow-indigo-200 text-white">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 rounded-xl bg-white/20 text-white backdrop-blur-sm">
                   <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                </div>
                <span class="text-xs font-bold bg-white/20 px-2 py-1 rounded-lg backdrop-blur-sm">Live</span>
            </div>
            <p class="text-indigo-100 text-sm font-medium">System Status</p>
            <h3 class="text-xl font-bold mt-1">Fully Operational</h3>
        </div>
    </section>

    {{-- C. Main Interface --}}
    <section class="space-y-6">
        {{-- Toolbar --}}
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white p-2 rounded-2xl border border-slate-200 shadow-sm">
            <div class="px-4 py-2">
                <h2 class="text-lg font-bold text-slate-800">Permission Matrix</h2>
            </div>
            
            <div class="flex items-center space-x-2 bg-slate-100 p-1.5 rounded-xl">
                <button id="toggle-matrix" onclick="window.switchView('matrix')"
                    class="view-toggle-btn active-view-btn flex items-center px-4 py-2 rounded-lg text-sm font-semibold transition-all duration-200">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"></path></svg>
                    Grid
                </button>
                <button id="toggle-cards" onclick="window.switchView('cards')"
                    class="view-toggle-btn flex items-center px-4 py-2 rounded-lg text-sm font-semibold text-slate-500 hover:text-indigo-600 transition-all duration-200">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                    Cards
                </button>
            </div>
        </div>

        <div class="flex flex-col lg:flex-row gap-6">
            {{-- Sidebar Categories --}}
            <aside class="w-full lg:w-64 flex-shrink-0">
                <div class="sticky top-6 bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
                    <div class="p-4 bg-slate-50 border-b border-slate-100">
                        <h3 class="text-xs font-bold uppercase tracking-wider text-slate-500">Filter By Group</h3>
                    </div>
                    <div class="p-3 space-y-1 max-h-[70vh] overflow-y-auto custom-scrollbar">
                         <button onclick="window.filterPermissions('All')"
                            class="category-filter-btn active-category-btn w-full text-left flex items-center justify-between px-3 py-2.5 rounded-lg text-sm text-slate-600 transition-colors">
                            <span class="truncate font-medium">All Permissions</span>
                            <span class="text-xs bg-slate-100 px-2 py-0.5 rounded-full text-slate-500 ml-2"></span>
                        </button>
                        <div id="category-list" class="space-y-1">
                            {{-- Dynamic Categories --}}
                        </div>
                    </div>
                </div>
            </aside>

            {{-- Main Content Area --}}
            <main class="flex-grow min-w-0">
                
                {{-- Matrix View --}}
                <div id="matrix-view" class="bg-white rounded-2xl shadow-[0_4px_20px_rgb(0,0,0,0.03)] border border-slate-200 overflow-hidden relative min-h-[400px]">
                    <div id="matrix-loading" class="absolute inset-0 bg-white/80 backdrop-blur-sm z-30 flex flex-col items-center justify-center">
                        <div class="animate-spin rounded-full h-10 w-10 border-b-2 border-indigo-600 mb-4"></div>
                        <span class="text-indigo-600 font-semibold animate-pulse">Loading Matrix...</span>
                    </div>
                    
                    <div class="overflow-x-auto custom-scrollbar pb-4">
                        <table class="w-full text-sm text-left border-collapse">
                            <thead id="matrix-header" class="bg-slate-50 text-slate-700 sticky top-0 z-20 shadow-sm backdrop-blur-md bg-opacity-95">
                                {{-- Headers Injected via JS --}}
                            </thead>
                            <tbody id="matrix-body" class="divide-y divide-slate-100">
                                {{-- Body Injected via JS --}}
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- Card View --}}
                <div id="cards-view" class="hidden grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
                    <div id="cards-loading" class="col-span-full flex flex-col items-center justify-center py-20">
                        <div class="animate-spin rounded-full h-10 w-10 border-b-2 border-indigo-600 mb-4"></div>
                        <span class="text-indigo-600 font-semibold">Loading Role Cards...</span>
                    </div>
                    {{-- Cards Injected via JS --}}
                </div>
            </main>
        </div>
    </section>
</div>

{{-- SLIDE-OVER: Manage Permissions --}}
<div id="managePermissionsSlideover" class="hidden fixed inset-0 z-50 overflow-hidden" aria-labelledby="slide-over-title" role="dialog" aria-modal="true">
    <div id="slideover-backdrop" onclick="window.closeManagePermissions()" class="absolute inset-0 bg-slate-900/40 backdrop-blur-sm transition-opacity opacity-0 duration-300"></div>
    <div id="slideover-panel" class="fixed inset-y-0 right-0 max-w-full flex transition-transform transform translate-x-full duration-300 pl-10">
        <div class="w-screen max-w-lg">
            <div class="h-full flex flex-col bg-white shadow-2xl rounded-l-2xl">
                {{-- Header --}}
                <div class="px-6 py-5 bg-white border-b border-slate-100 flex items-center justify-between">
                    <div>
                        <h2 class="text-xl font-bold text-slate-900">Manage Role</h2>
                        <p class="text-sm text-indigo-600 font-medium mt-0.5" id="slideover-role-name">...</p>
                    </div>
                    <button onclick="window.closeManagePermissions()" class="rounded-full p-2 bg-slate-50 text-slate-400 hover:text-slate-600 hover:bg-slate-100 transition-colors">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                    </button>
                </div>

                {{-- Search & Stats --}}
                <div class="px-6 py-4 bg-slate-50/50 border-b border-slate-100 space-y-3">
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-4 w-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                        </div>
                        <input type="text" id="slideover-search-input" placeholder="Filter permissions..." 
                            class="block w-full pl-10 pr-3 py-2 border border-slate-200 rounded-xl leading-5 bg-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm transition-shadow"
                            onkeyup="window.filterSlideoverPermissions()">
                    </div>
                    <div class="flex items-center justify-between text-xs text-slate-500 font-medium">
                        <span id="slideover-permission-count">0 Assigned</span>
                         <span class="text-indigo-600 cursor-pointer hover:underline" onclick="document.getElementById('slideover-search-input').value = ''; window.filterSlideoverPermissions();">Clear Filter</span>
                    </div>
                </div>

                {{-- Content --}}
                <div id="slideover-permission-list" class="flex-1 overflow-y-auto px-6 py-4 space-y-6 custom-scrollbar bg-slate-50/30">
                    {{-- Groups injected --}}
                </div>

                {{-- Footer --}}
                <div class="px-6 py-4 bg-white border-t border-slate-100">
                    <button id="slideover-save-btn" onclick="window.saveRolePermissions()"
                        class="w-full flex justify-center items-center px-4 py-3 border border-transparent rounded-xl shadow-lg shadow-indigo-200 text-sm font-bold text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all transform active:scale-[0.98]">
                        Save Changes
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- MODAL: Create Role --}}
<div id="addRoleModal" class="hidden fixed inset-0 z-[60] overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity" aria-hidden="true" onclick="document.getElementById('addRoleModal').classList.add('hidden')"></div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        
        <div class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg w-full">
            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <div class="sm:flex sm:items-start">
                    <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-indigo-100 sm:mx-0 sm:h-10 sm:w-10">
                        <svg class="h-6 w-6 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" /></svg>
                    </div>
                    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                        <h3 class="text-lg leading-6 font-bold text-slate-900" id="modal-title">Create New Role</h3>
                        <div class="mt-4">
                            <form id="addRoleForm" class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-slate-700 mb-1">Role Name</label>
                                    <input type="text" id="role_name" name="name" placeholder="e.g. Content Editor" class="w-full px-4 py-2 border border-slate-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-all">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="bg-slate-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse border-t border-slate-100">
                <button id="submitRoleBtn" type="button" onclick="document.getElementById('addRoleForm').dispatchEvent(new Event('submit'))" class="w-full inline-flex justify-center rounded-xl border border-transparent shadow-sm px-4 py-2 bg-indigo-600 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none sm:ml-3 sm:w-auto sm:text-sm">
                    Create Role
                </button>
                <button type="button" onclick="document.getElementById('addRoleModal').classList.add('hidden')" class="mt-3 w-full inline-flex justify-center rounded-xl border border-slate-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-slate-700 hover:bg-slate-50 focus:outline-none sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                    Cancel
                </button>
            </div>
        </div>
    </div>
</div>

{{-- MODAL: Edit Role (Added as requested) --}}
<div id="editRoleModal" class="hidden fixed inset-0 z-[60] overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity" aria-hidden="true" onclick="window.closeEditRoleModal()"></div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        
        <div class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg w-full">
            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <div class="sm:flex sm:items-start">
                    <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-blue-100 sm:mx-0 sm:h-10 sm:w-10">
                        <svg class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
                    </div>
                    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                        <h3 class="text-lg leading-6 font-bold text-slate-900">Edit Role</h3>
                        <div class="mt-4">
                            <form id="editRoleForm" class="space-y-4">
                                <input type="hidden" id="edit_role_id">
                                <div>
                                    <label class="block text-sm font-medium text-slate-700 mb-1">Role Name</label>
                                    <input type="text" id="edit_role_name" name="name" class="w-full px-4 py-2 border border-slate-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="bg-slate-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse border-t border-slate-100">
                <button id="submitEditRoleBtn" type="button" class="w-full inline-flex justify-center rounded-xl border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none sm:ml-3 sm:w-auto sm:text-sm">
                    Update Role
                </button>
                <button type="button" onclick="window.closeEditRoleModal()" class="mt-3 w-full inline-flex justify-center rounded-xl border border-slate-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-slate-700 hover:bg-slate-50 focus:outline-none sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                    Cancel
                </button>
            </div>
        </div>
    </div>
</div>

{{-- MODAL: Create Permission --}}
<div id="addPermissionModal" class="hidden fixed inset-0 z-[60] overflow-y-auto">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity" onclick="document.getElementById('addPermissionModal').classList.add('hidden')"></div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>
        <div class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg w-full">
            <div class="bg-white px-4 pt-5 pb-4 sm:p-6">
                 <div class="sm:flex sm:items-start">
                    <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-indigo-100 sm:mx-0 sm:h-10 sm:w-10">
                         <svg class="h-6 w-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM12 10a4 4 0 00-4 4v2a2 2 0 002 2h6a2 2 0 002-2v-2a4 4 0 00-4-4h-2z"></path></svg>
                    </div>
                    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                        <h3 class="text-lg leading-6 font-bold text-slate-900">Create Permission</h3>
                        <form id="addPermissionForm" class="mt-4 space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-1">Permission Name</label>
                                <input type="text" id="permission_name" name="name" placeholder="e.g. view_reports" class="w-full px-4 py-2 border border-slate-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-1">Category</label>
                                <select id="permission_category" name="category" class="w-full px-4 py-2 border border-slate-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none">
                                    <option value="">Select Category</option>
                                </select>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="bg-slate-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse border-t border-slate-100">
                <button id="submitPermissionBtn" type="button" onclick="document.getElementById('addPermissionForm').dispatchEvent(new Event('submit'))" class="w-full inline-flex justify-center rounded-xl border border-transparent shadow-sm px-4 py-2 bg-indigo-600 text-base font-medium text-white hover:bg-indigo-700 sm:ml-3 sm:w-auto sm:text-sm">
                    Save Permission
                </button>
                <button type="button" onclick="document.getElementById('addPermissionModal').classList.add('hidden')" class="mt-3 w-full inline-flex justify-center rounded-xl border border-slate-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-slate-700 hover:bg-slate-50 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                    Cancel
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    /* Premium Scrollbar */
    .custom-scrollbar::-webkit-scrollbar {
        height: 6px;
        width: 6px;
    }
    .custom-scrollbar::-webkit-scrollbar-track {
        background: transparent;
    }
    .custom-scrollbar::-webkit-scrollbar-thumb {
        background-color: #cbd5e1;
        border-radius: 20px;
    }
    .custom-scrollbar::-webkit-scrollbar-thumb:hover {
        background-color: #94a3b8;
    }

    /* --- VIEW TOGGLE BUTTONS (Grid/Card) FIX --- */
    .active-view-btn {
        background-color: #4f46e5 !important; /* Indigo 600 */
        color: white !important;
        box-shadow: 0 4px 6px -1px rgba(79, 70, 229, 0.2);
    }
    
    /* Hover effect for the inactive button */
    .view-toggle-btn:hover:not(.active-view-btn) {
        background-color: #f8fafc; /* Slate 50 */
        color: #4f46e5; /* Indigo 600 */
    }

    /* --- SIDEBAR FILTER ACTIVE STATE --- */
    .active-category-btn {
        background-color: #eef2ff !important;
        color: #4f46e5 !important;
        font-weight: 600;
        border-right: 3px solid #4f46e5;
    }

    .category-filter-btn:hover:not(.active-category-btn) {
        background-color: #f8fafc;
        color: #4f46e5;
    }

    /* --- PERMISSION TOGGLE SWITCHES --- */
    .toggle-track {
        width: 2.75rem;
        height: 1.5rem;
        background-color: #e2e8f0;
        border-radius: 9999px;
        transition: background-color 0.2s ease-in-out;
        cursor: pointer;
    }
    
    .toggle-dot {
        width: 1.1rem;
        height: 1.1rem;
        background-color: white;
        border-radius: 50%;
        position: absolute;
        top: 0.2rem;
        left: 0.2rem;
        transition: transform 0.2s ease-in-out;
        box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
        pointer-events: none;
    }

    /* Checked State */
    input:checked + .toggle-track {
        background-color: #4f46e5 !important;
    }
    input:checked ~ .toggle-dot {
        transform: translateX(1.25rem);
    }
    /* Disabled State */
    input:disabled + .toggle-track {
        opacity: 0.5;
        cursor: not-allowed;
    }

    /* Table Styling */
    .role-cell { min-width: 150px; }
    .permission-cell { min-width: 280px; }
    tbody tr:hover td { background-color: #f8fafc; }
</style>
@endpush

@push('scripts')
<script>
    const AUTH_TOKEN = localStorage.getItem('api_token');
    const BASE_URL = 'http://127.0.0.1:8000/api';
    const CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]')?.content || '';

    let roles = [];
    let permissions = [];
    let permissionsByCategory = {};
    let activeRoleForSlideover = null;
    let currentView = 'matrix';
    let currentFilterCategory = 'All';

    const STATIC_CATEGORIES = {
        'Core System': 1, 'Admin Controls': 2, 'Financial Actions': 3,
        'Vendor Approval': 4, 'CMS Management': 5, 'Support & Complaints': 6,
        'AI & Automation': 7, 'Advanced Controls': 8,
    };

    function showToaster(message, type = 'success') {
        let container = document.getElementById('toast-container');
        if (!container) {
            container = document.createElement('div');
            container.id = 'toast-container';
            container.className = 'fixed bottom-5 right-5 space-y-3 z-[100]';
            document.body.appendChild(container);
        }

        const toast = document.createElement('div');
        const bgColor = type === 'success' ? 'bg-slate-800' : 'bg-red-600';
        toast.className = `${bgColor} text-white px-6 py-4 rounded-xl shadow-2xl flex items-center gap-3 transform translate-y-10 opacity-0 transition-all duration-300`;
        
        const icon = type === 'success' 
            ? '<svg class="w-5 h-5 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>'
            : '<svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>';

        toast.innerHTML = `${icon}<span class="font-medium text-sm">${message}</span>`;
        container.appendChild(toast);

        requestAnimationFrame(() => {
            toast.classList.remove('translate-y-10', 'opacity-0');
        });

        setTimeout(() => {
            toast.classList.add('opacity-0', 'translate-y-2');
            setTimeout(() => toast.remove(), 300);
        }, 3000);
    }

    async function fetchData(endpoint, method = 'GET', body = null) {
        const headers = {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-CSRF-TOKEN': CSRF_TOKEN,
        };
        if (AUTH_TOKEN) headers['Authorization'] = `Bearer ${AUTH_TOKEN}`;

        try {
            const response = await fetch(`${BASE_URL}${endpoint}`, {
                method,
                headers,
                body: body ? JSON.stringify(body) : null
            });
            const data = await response.json();
            if (!response.ok) throw { status: response.status, data };
            return data;
        } catch (error) {
            console.error(`API Error (${method} ${endpoint}):`, error);
            throw error;
        }
    }

    async function loadInitialData() {
        try {
            document.getElementById('matrix-loading').classList.remove('hidden');
            
            const roleRes = await fetchData('/roles');
            roles = (roleRes.data || []).map(r => ({
                ...r,
                permissions_list: (r.permissions || []).map(p => p.name)
            })).sort((a,b) => a.id === 1 ? -1 : 1);

            document.getElementById('stat-total-roles').textContent = roles.length;

            const permRes = await fetchData('/permissions');
            permissions = (permRes.data || []).map(p => ({
                ...p,
                category: p.category || getStaticCategory(p.name)
            }));

            document.getElementById('stat-total-permissions').textContent = permissions.length;

            permissionsByCategory = permissions.reduce((acc, p) => {
                if (!acc[p.category]) acc[p.category] = [];
                acc[p.category].push(p);
                return acc;
            }, {});

            renderPermissionCategories();
            renderMatrixView();
            renderCardView();

        } catch (e) {
            showToaster(e.data?.message || 'Failed to load data', 'error');
        } finally {
            document.getElementById('matrix-loading').classList.add('hidden');
        }
    }

    function getStaticCategory(name) {
        name = name.toLowerCase();
        if (name.includes('admin') || name.includes('system')) return 'Core System';
        if (name.includes('finance') || name.includes('payment')) return 'Financial Actions';
        return 'Admin Controls';
    }

    function renderPermissionCategories() {
        const list = document.getElementById('category-list');
        list.innerHTML = '';
        Object.keys(permissionsByCategory).sort().forEach(cat => {
            const btn = document.createElement('button');
            btn.className = `category-filter-btn w-full text-left flex items-center justify-between px-3 py-2.5 rounded-lg text-sm text-slate-600 transition-colors`;
            btn.onclick = () => filterPermissions(cat);
            btn.innerHTML = `<span class="truncate font-medium">${cat}</span><span class="text-xs bg-slate-100 px-2 py-0.5 rounded-full text-slate-500 ml-2">${permissionsByCategory[cat].length}</span>`;
            list.appendChild(btn);
        });
        filterPermissions(currentFilterCategory);
    }

    function filterPermissions(cat) {
        currentFilterCategory = cat;
        document.querySelectorAll('.category-filter-btn').forEach(b => {
            const btnText = b.querySelector('span.truncate').textContent;
            if (btnText === cat || (cat === 'All' && btnText === 'All Permissions')) {
                b.classList.add('active-category-btn');
            } else {
                b.classList.remove('active-category-btn');
            }
        });
        currentView === 'matrix' ? renderMatrixView() : renderCardView();
    }

    function renderMatrixView() {
        const header = document.getElementById('matrix-header');
        const body = document.getElementById('matrix-body');
        
        let hHtml = `<tr><th class="permission-cell px-6 py-4 text-xs font-bold uppercase tracking-wider bg-slate-50 border-r border-slate-200 sticky left-0 z-20">Permission</th>`;
        roles.forEach(r => {
            const isSuper = r.name.toLowerCase() === 'super admin';
            hHtml += `<th class="role-cell px-4 py-4 text-center">
                <div class="flex flex-col items-center">
                    <span class="text-sm font-bold text-slate-800">${r.name}</span>
                    ${isSuper ? '<span class="text-[10px] uppercase font-bold text-red-500 bg-red-50 px-1.5 py-0.5 rounded mt-1">Locked</span>' : ''}
                </div>
            </th>`;
        });
        header.innerHTML = hHtml + '</tr>';

        body.innerHTML = '';
        const categories = Object.keys(permissionsByCategory).sort();

        categories.forEach(cat => {
            if (currentFilterCategory !== 'All' && currentFilterCategory !== cat) return;
            body.innerHTML += `<tr class="bg-indigo-50/40"><td colspan="${roles.length+1}" class="px-6 py-2 text-xs font-bold text-indigo-700 uppercase tracking-widest sticky left-0 z-10">${cat}</td></tr>`;

            permissionsByCategory[cat].sort((a,b) => a.name.localeCompare(b.name)).forEach(p => {
                let row = `<tr><td class="permission-cell px-6 py-3 text-sm font-medium text-slate-700 bg-white border-r border-slate-100 sticky left-0 z-10">${p.name}</td>`;
                roles.forEach(r => {
                    const has = r.permissions_list.includes(p.name);
                    const isSuper = r.name.toLowerCase() === 'super admin';
                    row += `<td class="px-4 py-3 text-center align-middle">
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" class="sr-only peer" 
                                ${has ? 'checked' : ''} ${isSuper ? 'disabled' : ''}
                                data-role-id="${r.id}" data-perm-id="${p.id}"
                                onchange="window.togglePermission(this)">
                            <div class="toggle-track"></div>
                            <div class="toggle-dot"></div>
                        </label>
                    </td>`;
                });
                body.innerHTML += row + '</tr>';
            });
        });
    }

    function renderCardView() {
        const container = document.getElementById('cards-view');
        container.innerHTML = '';
        roles.forEach(role => {
            const isSuper = role.name.toLowerCase() === 'super admin';
            const count = role.permissions_list.length;
            const manageBtn = `<button onclick="window.openManagePermissions('${role.id}')" class="flex-1 px-3 py-2 text-sm font-medium text-white bg-indigo-600 rounded-lg hover:bg-indigo-700 transition shadow-sm hover:shadow-md">Manage</button>`;
            const editBtn = isSuper 
                ? `<button disabled class="p-2 text-slate-300 cursor-not-allowed"><svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg></button>`
                : `<button onclick="window.openEditRoleModal('${role.id}', '${role.name}')" class="p-2 text-slate-400 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition" title="Edit Role Name"><svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg></button>`;
            const deleteBtn = isSuper
                ? `<button disabled class="p-2 text-slate-300 cursor-not-allowed"><svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg></button>`
                : `<button onclick="window.deleteRole('${role.id}')" class="p-2 text-slate-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition" title="Delete Role"><svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg></button>`;

            const html = `<div class="bg-white rounded-2xl p-6 border border-slate-100 shadow-[0_4px_20px_rgb(0,0,0,0.03)] hover:shadow-[0_10px_30px_rgb(0,0,0,0.06)] hover:-translate-y-1 transition-all duration-300 flex flex-col h-full">
                <div class="flex justify-between items-start mb-4">
                    <div><h3 class="text-xl font-bold text-slate-800">${role.name}</h3><span class="text-xs text-slate-400 font-medium">Updated recently</span></div>
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium ${isSuper ? 'bg-red-100 text-red-800' : 'bg-indigo-100 text-indigo-800'}">${isSuper ? 'System Core' : 'Custom Role'}</span>
                </div>
                <p class="text-sm text-slate-500 mb-6 flex-grow">${isSuper ? 'Full administrative access. Cannot be deleted or modified.' : `Has access to ${count} permissions across various system modules.`}</p>
                <div class="flex items-center gap-3 pt-4 border-t border-slate-100">${manageBtn}<div class="flex items-center border-l border-slate-100 pl-2">${editBtn}${deleteBtn}</div></div>
            </div>`;
            container.innerHTML += html;
        });
    }

    function renderSlideoverList() {
        const list = document.getElementById('slideover-permission-list');
        list.innerHTML = '';
        if(!activeRoleForSlideover) return;

        const isSuper = activeRoleForSlideover.name.toLowerCase() === 'super admin';
        document.getElementById('slideover-permission-count').innerText = `${activeRoleForSlideover.permissions_list.length} Permissions Assigned`;

        Object.keys(permissionsByCategory).sort().forEach(cat => {
            const groupDiv = document.createElement('div');
            groupDiv.className = 'slideover-group mb-6';
            groupDiv.innerHTML = `<h4 class="text-xs font-bold uppercase text-slate-500 mb-3 tracking-wider">${cat}</h4>`;
            permissionsByCategory[cat].forEach(p => {
                const has = activeRoleForSlideover.permissions_list.includes(p.name);
                const item = document.createElement('div');
                item.className = 'slideover-item flex items-center justify-between p-3 mb-2 bg-white rounded-xl border border-slate-100 shadow-sm hover:border-indigo-200 transition-colors';
                item.dataset.pname = p.name.toLowerCase();
                item.innerHTML = `<span class="text-sm font-medium text-slate-700">${p.name}</span>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" class="sr-only peer" ${has ? 'checked' : ''} ${isSuper ? 'disabled' : ''} data-role-id="${activeRoleForSlideover.id}" data-perm-name="${p.name}" onchange="window.togglePermission(this)">
                        <div class="toggle-track"></div><div class="toggle-dot"></div>
                    </label>`;
                groupDiv.appendChild(item);
            });
            list.appendChild(groupDiv);
        });
    }

    window.togglePermission = async function(checkbox) {
        const roleId = checkbox.dataset.roleId;
        const role = roles.find(r => r.id == roleId);
        if(role.name.toLowerCase() === 'super admin') { checkbox.checked = true; return; }

        const permName = permissions.find(p => p.id == checkbox.dataset.permId)?.name || checkbox.dataset.permName; 
        const oldList = [...role.permissions_list];
        if(checkbox.checked && !role.permissions_list.includes(permName)) role.permissions_list.push(permName);
        else if(!checkbox.checked) role.permissions_list = role.permissions_list.filter(n => n !== permName);

        try {
            await fetchData('/role-permission', 'POST', { role: role.name, permissions: role.permissions_list });
            showToaster(`Updated permissions for ${role.name}`);
        } catch(e) {
            role.permissions_list = oldList;
            checkbox.checked = !checkbox.checked;
            showToaster('Update failed', 'error');
        }
    };

    window.deleteRole = async function(id) {
        const role = roles.find(r => r.id == id);
        if(!role) return;
        if(!confirm(`Are you sure you want to delete "${role.name}"?`)) return;
        try {
            await fetchData(`/roles/${id}`, 'DELETE');
            showToaster(`Role "${role.name}" deleted successfully`);
            await loadInitialData(); 
        } catch(e) { showToaster(e.data?.message || 'Failed to delete role', 'error'); }
    };

    window.openEditRoleModal = function(id, name) {
        document.getElementById('edit_role_id').value = id;
        document.getElementById('edit_role_name').value = name;
        document.getElementById('editRoleModal').classList.remove('hidden');
    };
    window.closeEditRoleModal = function() { document.getElementById('editRoleModal').classList.add('hidden'); };

    document.getElementById('submitEditRoleBtn').addEventListener('click', async function() {
        const id = document.getElementById('edit_role_id').value;
        const name = document.getElementById('edit_role_name').value.trim();
        const btn = this;
        if(!name) { showToaster('Role name is required', 'error'); return; }
        btn.disabled = true; btn.innerText = 'Updating...';
        try {
            await fetchData(`/roles/${id}`, 'PUT', { name: name });
            showToaster('Role updated successfully');
            closeEditRoleModal();
            await loadInitialData();
        } catch(e) { showToaster(e.data?.message || 'Update failed', 'error'); } 
        finally { btn.disabled = false; btn.innerText = 'Update Role'; }
    });

    window.openManagePermissions = function(roleId) {
        const role = roles.find(r => r.id == roleId);
        if(!role) return;
        activeRoleForSlideover = role;
        document.getElementById('slideover-role-name').innerText = role.name;
        document.getElementById('managePermissionsSlideover').classList.remove('hidden');
        document.getElementById('slideover-backdrop').classList.remove('opacity-0');
        document.getElementById('slideover-panel').classList.remove('translate-x-full');
        renderSlideoverList();
    };

    window.closeManagePermissions = function() {
        activeRoleForSlideover = null;
        document.getElementById('slideover-panel').classList.add('translate-x-full');
        document.getElementById('slideover-backdrop').classList.add('opacity-0');
        setTimeout(() => document.getElementById('managePermissionsSlideover').classList.add('hidden'), 300);
    };

    window.filterSlideoverPermissions = function() {
        const term = document.getElementById('slideover-search-input').value.toLowerCase();
        document.querySelectorAll('.slideover-item').forEach(el => {
            el.style.display = el.dataset.pname.includes(term) ? 'flex' : 'none';
        });
        document.querySelectorAll('.slideover-group').forEach(grp => {
            const visible = Array.from(grp.querySelectorAll('.slideover-item')).some(i => i.style.display !== 'none');
            grp.style.display = visible ? 'block' : 'none';
        });
    };

    window.saveRolePermissions = function() {
        showToaster('Changes saved successfully');
        closeManagePermissions();
        renderCardView(); renderMatrixView(); 
    };

    document.getElementById('addRoleForm').addEventListener('submit', async (e) => {
        e.preventDefault();
        const btn = document.getElementById('submitRoleBtn');
        const name = document.getElementById('role_name').value.trim();
        if(!name) { showToaster('Name is required', 'error'); return; }
        btn.disabled = true; btn.innerText = 'Creating...';
        try {
            await fetchData('/roles', 'POST', { name });
            showToaster('Role created!');
            e.target.reset();
            document.getElementById('addRoleModal').classList.add('hidden');
            await loadInitialData();
        } catch(err) { showToaster(err.data?.message || 'Creation failed', 'error'); } 
        finally { btn.disabled = false; btn.innerText = 'Create Role'; }
    });

    document.getElementById('addPermissionForm').addEventListener('submit', async (e) => {
        e.preventDefault();
        const btn = document.getElementById('submitPermissionBtn');
        const name = document.getElementById('permission_name').value.trim();
        const cat = document.getElementById('permission_category').value;
        if(!name || !cat) { showToaster('Fields required', 'error'); return; }
        btn.disabled = true; btn.innerText = 'Saving...';
        try {
            await fetchData('/permissions', 'POST', { name, category: cat });
            showToaster('Permission created!');
            e.target.reset();
            document.getElementById('addPermissionModal').classList.add('hidden');
            await loadInitialData();
        } catch(err) { showToaster(err.data?.message || 'Creation failed', 'error'); } 
        finally { btn.disabled = false; btn.innerText = 'Save Permission'; }
    });

    window.switchView = function(view) {
        currentView = view;
        document.getElementById('matrix-view').classList.toggle('hidden', view !== 'matrix');
        document.getElementById('cards-view').classList.toggle('hidden', view !== 'cards');
        
        const mBtn = document.getElementById('toggle-matrix');
        const cBtn = document.getElementById('toggle-cards');
        
        const base = "view-toggle-btn flex items-center px-4 py-2 rounded-lg text-sm font-semibold transition-all duration-200";
        const inactive = "text-slate-500 hover:text-indigo-600";
        const active = "active-view-btn";

        mBtn.className = `${base} ${view === 'matrix' ? active : inactive}`;
        cBtn.className = `${base} ${view === 'cards' ? active : inactive}`;

        if(view === 'matrix') renderMatrixView();
        else renderCardView();
    }

    document.addEventListener('DOMContentLoaded', () => {
        loadInitialData();
        const catSelect = document.getElementById('permission_category');
        Object.keys(STATIC_CATEGORIES).forEach(c => {
            const opt = document.createElement('option');
            opt.value = c; opt.text = c;
            catSelect.appendChild(opt);
        });
    });
</script>
@endpush