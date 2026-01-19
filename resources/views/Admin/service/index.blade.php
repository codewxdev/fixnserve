@extends('layouts.app')

@section('content')
    {{-- Script Section --}}
    <script>
        function hierarchyManager() {
            return {
                allCategories: @json($categories),
                currentModule: 'professionalExpert',
                currentLevel: 'category',
                breadcrumbs: [],
                isModalOpen: false,
                isEditing: false,
                formData: {
                    name: '',
                    id: null,
                    active: true // Default active
                },

                modules: [{
                        id: 'professionalExpert',
                        name: 'Professionals'
                    },
                    {
                        id: 'onlineConsultant',
                        name: 'Consultants'
                    },
                    {
                        id: 'serviceProvider',
                        name: 'Service Providers'
                    },
                    {
                        id: 'martVender',
                        name: 'Mart Vendors'
                    },
                ],

                // Modal band karne ka function jo missing tha
                closeModal() {
                    this.isModalOpen = false;
                    this.formData = {
                        name: '',
                        id: null,
                        active: true
                    };
                },

                openModal() {
                    this.isEditing = false;
                    this.formData = {
                        name: '',
                        id: null,
                        active: true
                    };
                    this.isModalOpen = true;
                },

                get currentItems() {
                    if (this.breadcrumbs.length === 0) {
                        return this.allCategories.filter(c => c.type === this.currentModule);
                    }
                    let lastCrumb = this.breadcrumbs[this.breadcrumbs.length - 1];
                    // Ensure subcategories exist to avoid map errors
                    return lastCrumb.item.subcategories || [];
                },

                async saveItem() {
                    const isCategory = this.currentLevel === 'category';
                    const url = isCategory ? '{{ route('store.category') }}' : '{{ route('store.subcategory') }}';
                    const token = '{{ csrf_token() }}';

                    let payload = {
                        name: this.formData.name,
                        active: this.formData.active ? 1 : 0
                    };

                    if (isCategory) {
                        payload.type = this.currentModule;
                    } else {
                        // Ensure we pick the correct ID from the breadcrumb
                        if (this.breadcrumbs.length > 0) {
                            payload.category_id = this.breadcrumbs[this.breadcrumbs.length - 1].item.id;
                        } else {
                            alert("Please select a parent category first.");
                            return;
                        }
                    }

                    try {
                        const response = await fetch(url, {
                            method: 'POST',
                            credentials: 'same-origin',
                            headers: {
                                'Content-Type': 'application/json',
                                'Accept': 'application/json',
                                'X-CSRF-TOKEN': token
                            },
                            body: JSON.stringify(payload)
                        });

                        const result = await response.json();

                        if (response.ok) {
                            this.closeModal(); // Ab yeh function exist karta hai
                            window.location.reload();
                        } else {
                            // Agar 403 ya 422 error hai toh alert dikhayen
                            alert(result.message || 'Error: ' + response.status);
                            console.error("Server Error:", result);
                        }
                    } catch (error) {
                        console.error("Request failed:", error);
                    }
                },

                // Baaki functions (switchModule, drillDown, etc.) waise hi rahenge...
                switchModule(moduleId) {
                    this.currentModule = moduleId;
                    this.resetToRoot();
                },
                resetToRoot() {
                    this.breadcrumbs = [];
                    this.currentLevel = 'category';
                },
                drillDown(item) {
                    if (this.currentLevel === 'category') {
                        this.breadcrumbs.push({
                            name: item.name,
                            level: 'category',
                            item: item
                        });
                        this.currentLevel = 'subcategory';
                    }
                },
                navigateToCrumb(index) {
                    this.breadcrumbs = this.breadcrumbs.slice(0, index + 1);
                    this.currentLevel = 'subcategory';
                },
                getChildCount(item) {
                    return item.subcategories ? item.subcategories.length : 0;
                },
                getNextLevelLabel() {
                    return this.currentLevel === 'category' ? 'Sub Categories' : '';
                },
                get currentLevelLabel() {
                    return this.currentLevel === 'category' ? 'Main Category' : 'Sub Category';
                }
            };
        }
    </script>

    <div id="hierarchy-management-page" class="space-y-6 p-4 md:p-8 bg-gray-50 min-h-screen" x-data="hierarchyManager()" x-cloak>

        {{-- 1. Header --}}
        <header class="flex flex-col md:flex-row justify-between items-center pb-4 border-b border-gray-200 gap-4">
            <div>
                <h1 class="text-2xl md:text-3xl font-bold text-gray-900 flex items-center">
                    <svg class="w-8 h-8 mr-3 text-cyan-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10">
                        </path>
                    </svg>
                    Service & Mart Management
                </h1>
                <p class="text-sm text-gray-500 mt-1">Manage Categories for Service Providers and Mart Vendors.</p>
            </div>

            {{-- Module Tabs --}}
            <div class="bg-white p-1 rounded-lg border border-gray-200 flex space-x-1 shadow-sm overflow-x-auto max-w-full">
                <template x-for="mod in modules" :key="mod.id">
                    <button @click="switchModule(mod.id)"
                        :class="currentModule === mod.id ? 'bg-cyan-50 text-cyan-700 border-cyan-200' :
                            'text-gray-500 hover:bg-gray-50'"
                        class="px-4 py-2 text-sm font-medium rounded-md border border-transparent transition-all capitalize whitespace-nowrap"
                        x-text="mod.name">
                    </button>
                </template>
            </div>
        </header>

        {{-- 2. Breadcrumbs & Level Info --}}
        <div class="flex items-center justify-between bg-white p-4 rounded-xl shadow-sm border border-gray-100">
            <div class="flex items-center space-x-2 text-sm text-gray-600 overflow-x-auto">
                {{-- Home / Root --}}
                <button @click="resetToRoot()" class="flex items-center hover:text-cyan-600 font-bold">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                        </path>
                    </svg>
                    <span x-text="modules.find(m => m.id === currentModule).name"></span>
                </button>

                {{-- Dynamic Breadcrumbs --}}
                <template x-for="(crumb, index) in breadcrumbs" :key="index">
                    <div class="flex items-center">
                        <svg class="w-4 h-4 text-gray-400 mx-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                        <button @click="navigateToCrumb(index)"
                            class="hover:text-cyan-600 font-medium truncate max-w-[150px]" x-text="crumb.name"></button>
                    </div>
                </template>

                {{-- Current Badge --}}
                <div class="flex items-center">
                    <svg class="w-4 h-4 text-gray-400 mx-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                    <span
                        class="text-cyan-600 font-bold bg-cyan-50 px-2 py-0.5 rounded-full text-xs uppercase tracking-wide"
                        x-text="currentLevelLabel"></span>
                </div>
            </div>

            <button @click="openModal()"
                class="flex items-center px-4 py-2 text-sm font-medium text-white bg-cyan-600 rounded-lg hover:bg-cyan-700 shadow-md transition">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6">
                    </path>
                </svg>
                Add <span x-text="currentLevelLabel" class="ml-1"></span>
            </button>
        </div>

        {{-- 3. Data Table --}}
        <div class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name
                                & Icon</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type
                            </th>
                            <th x-show="currentLevel !== 'subspeciality'"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Contains</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Status</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-100">
                        <template x-for="item in currentItems" :key="item.id">
                            <tr class="hover:bg-cyan-50/30 transition group">
                                <td class="px-6 py-4 whitespace-nowrap flex items-center">
                                    <div
                                        class="h-10 w-10 flex-shrink-0 bg-gray-100 rounded-lg flex items-center justify-center text-gray-500 overflow-hidden">
                                        <template x-if="item.image">
                                            <img :src="item.image" class="h-full w-full object-cover">
                                        </template>
                                        <template x-if="!item.image">
                                            <span class="text-xs font-bold"
                                                x-text="item.name.substring(0,2).toUpperCase()"></span>
                                        </template>
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-bold text-gray-900 group-hover:text-cyan-700 transition"
                                            x-text="item.name"></div>
                                        <div class="text-xs text-gray-400" x-text="'ID: ' + item.id"></div>
                                    </div>
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium capitalize"
                                        :class="{
                                            'bg-blue-100 text-blue-800': currentLevel === 'category',
                                            'bg-purple-100 text-purple-800': currentLevel === 'subcategory',
                                            'bg-orange-100 text-orange-800': currentLevel === 'speciality',
                                            'bg-pink-100 text-pink-800': currentLevel === 'subspeciality'
                                        }"
                                        x-text="currentLevelLabel"> </span>
                                </td>

                                <td x-show="currentLevel !== 'subspeciality'" class="px-6 py-4 whitespace-nowrap">
                                    <button @click="drillDown(item)"
                                        class="flex items-center text-sm text-gray-600 hover:text-cyan-600 font-medium transition">
                                        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10">
                                            </path>
                                        </svg>
                                        <span x-text="getChildCount(item) + ' ' + getNextLevelLabel()"></span>
                                        <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 5l7 7-7 7"></path>
                                        </svg>
                                    </button>
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap">
                                    <button @click="item.active = !item.active"
                                        class="relative inline-flex h-5 w-9 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none"
                                        :class="item.active ? 'bg-green-500' : 'bg-gray-200'">
                                        <span
                                            class="pointer-events-none inline-block h-4 w-4 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out"
                                            :class="item.active ? 'translate-x-4' : 'translate-x-0'"></span>
                                    </button>
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <button @click="editItem(item)"
                                        class="text-cyan-600 hover:text-cyan-900 mr-3">Edit</button>
                                    <button class="text-red-400 hover:text-red-600">Delete</button>
                                </td>
                            </tr>
                        </template>

                        {{-- Empty State --}}
                        <tr x-show="currentItems.length === 0">
                            <td colspan="5" class="px-6 py-10 text-center text-gray-500">
                                <div class="flex flex-col items-center justify-center">
                                    <svg class="w-12 h-12 text-gray-300 mb-2" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4">
                                        </path>
                                    </svg>
                                    <p>No <span x-text="currentLevelLabel"></span> found here.</p>
                                    <button @click="openModal()" class="mt-2 text-cyan-600 hover:underline">Add First
                                        Record</button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        {{-- 4. Modal --}}
        <div x-show="isModalOpen" class="fixed inset-0 overflow-hidden z-50" style="display: none;">
            <div class="absolute inset-0 overflow-hidden">
                <div class="absolute inset-0 bg-black bg-opacity-50 transition-opacity" @click="closeModal()"></div>
                <div class="fixed inset-y-0 right-0 pl-10 max-w-full flex">
                    <div class="w-screen max-w-md bg-white shadow-xl flex flex-col h-full transform transition ease-in-out duration-300"
                        x-transition:enter="translate-x-full" x-transition:enter-end="translate-x-0"
                        x-transition:leave="translate-x-0" x-transition:leave-end="translate-x-full">

                        <div class="bg-cyan-700 px-4 py-6 sm:px-6">
                            <div class="flex items-start justify-between">
                                <div>
                                    <h2 class="text-lg font-medium text-white">
                                        <span x-text="isEditing ? 'Edit' : 'Add New'"></span>
                                        <span x-text="currentLevelLabel" class="capitalize"></span>
                                    </h2>
                                    <p class="text-cyan-100 text-xs mt-1" x-show="breadcrumbs.length > 0">
                                        Parent: <span
                                            x-text="breadcrumbs.length > 0 ? breadcrumbs[breadcrumbs.length - 1].name : ''"></span>
                                    </p>
                                </div>
                                <button @click="closeModal()" class="text-cyan-200 hover:text-white">
                                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <div class="flex-1 overflow-y-auto p-6 space-y-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Name <span
                                        class="text-red-500">*</span></label>
                                <input type="text" x-model="formData.name"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-cyan-500 focus:ring-cyan-500 sm:text-sm"
                                    placeholder="e.g. Groceries or Pipe Fitting">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Description</label>
                                <textarea x-model="formData.description" rows="3"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-cyan-500 focus:ring-cyan-500 sm:text-sm"></textarea>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Icon / Image</label>
                                <div
                                    class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md hover:border-cyan-500 transition">
                                    <div class="space-y-1 text-center">
                                        <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none"
                                            viewBox="0 0 48 48">
                                            <path
                                                d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02"
                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                        <div class="flex text-sm text-gray-600">
                                            <label
                                                class="relative cursor-pointer bg-white rounded-md font-medium text-cyan-600 hover:text-cyan-500">
                                                <span>Upload a file</span>
                                                <input type="file" class="sr-only">
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Status</label>
                                <div class="mt-2 flex items-center">
                                    <button type="button" @click="formData.active = !formData.active"
                                        class="relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none"
                                        :class="formData.active ? 'bg-cyan-600' : 'bg-gray-200'">
                                        <span
                                            class="pointer-events-none inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out"
                                            :class="formData.active ? 'translate-x-5' : 'translate-x-0'"></span>
                                    </button>
                                    <span class="ml-3 text-sm font-medium text-gray-900"
                                        x-text="formData.active ? 'Active' : 'Inactive'"></span>
                                </div>
                            </div>
                        </div>

                        <div class="border-t border-gray-200 px-4 py-6 sm:px-6 bg-gray-50 flex justify-end gap-3">
                            <button @click="closeModal()"
                                class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50">Cancel</button>
                            <button @click="saveItem()"
                                class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-cyan-600 hover:bg-cyan-700">Save</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
