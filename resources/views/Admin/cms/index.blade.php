@extends('layouts.app')

{{-- Assume 'app' layout includes necessary Tailwind CSS and Alpine.js setup --}}

@section('content')

{{-- Alpine.js state for managing the primary navigation (CMS vs Settings) and current submodule --}}
<div id="config-management-page" 
     class="space-y-6 p-4 md:p-8 bg-gray-50 min-h-screen" 
     x-data="{ 
         mainNav: 'cms', 
         currentModule: 'homepage', 
         cmsModules: {
             homepage: 'Home Page Layout Manager',
             banners: 'Banners & Promotions',
             notifications: 'Notification Templates',
             blogs: 'Blogs & Static Pages',
             seo: 'SEO Settings'
         },
         settingModules: {
             system: 'System Preferences',
             
             localization: 'Localization & Currencies',
             maps: 'Map & Geo Settings',
             payments: 'Payment Gateway Keys',
              
         }
     }" 
     x-cloak>
    
    {{-- 1. Header and Global Toggle --}}
    <header class="flex flex-col sm:flex-row justify-between items-start sm:items-center pb-4 border-b border-gray-200">
        <div class="mb-4 sm:mb-0">
            <h1 class="text-2xl md:text-3xl font-bold text-gray-900 flex items-center">
                <svg class="w-6 h-6 md:w-8 md:h-8 mr-3 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.585.355 1.288.465 1.724.066z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                CMS & System Configuration
            </h1>
            <p class="text-xs sm:text-sm text-gray-500 mt-1">Manage content, templates, and core platform settings.</p>
        </div>
        
        {{-- Main Toggle Switch (CMS vs Settings) --}}
        <div class="p-1 bg-gray-100 rounded-xl flex space-x-1">
            <button @click="mainNav = 'cms'; currentModule = 'homepage'"
                    :class="{'bg-white shadow-md text-purple-600': mainNav === 'cms', 'text-gray-500': mainNav !== 'cms'}"
                    class="px-3 py-2 text-sm font-medium rounded-lg transition duration-200">
                 CMS & Content
            </button>
            <button @click="mainNav = 'settings'; currentModule = 'system'"
                    :class="{'bg-white shadow-md text-purple-600': mainNav === 'settings', 'text-gray-500': mainNav !== 'settings'}"
                    class="px-3 py-2 text-sm font-medium rounded-lg transition duration-200">
                 System Settings
            </button>
        </div>
    </header>

    {{-- 2. Two-Column Layout (Sidebar and Content) --}}
    <div class="lg:grid lg:grid-cols-12 lg:gap-8 mt-6">
        
        {{-- Configuration Sidebar (Col 1-3) --}}
        <nav class="lg:col-span-3 space-y-6">
            
            {{-- CMS Navigation (Visible when mainNav is 'cms') --}}
            <div x-show="mainNav === 'cms'" class="bg-white p-4 rounded-xl shadow-lg border border-gray-100 space-y-2">
                <h3 class="text-sm font-bold text-purple-700 uppercase mb-3">Content Management</h3>
                <template x-for="(label, key) in cmsModules" :key="key">
                    <button @click="currentModule = key"
                            :class="{'bg-purple-50 text-purple-700 font-semibold border-l-4 border-purple-600': currentModule === key, 'text-gray-700 hover:bg-gray-50 border-l-4 border-transparent': currentModule !== key}"
                            class="w-full text-left px-4 py-3 rounded-lg text-sm transition duration-150 ease-in-out">
                        <span x-text="label"></span>
                    </button>
                </template>
            </div>

            {{-- Settings Navigation (Visible when mainNav is 'settings') --}}
            <div x-show="mainNav === 'settings'" class="bg-white p-4 rounded-xl shadow-lg border border-gray-100 space-y-2">
                <h3 class="text-sm font-bold text-purple-700 uppercase mb-3">Core Settings</h3>
                <template x-for="(label, key) in settingModules" :key="key">
                    <button @click="currentModule = key"
                            :class="{'bg-purple-50 text-purple-700 font-semibold border-l-4 border-purple-600': currentModule === key, 'text-gray-700 hover:bg-gray-50 border-l-4 border-transparent': currentModule !== key}"
                            class="w-full text-left px-4 py-3 rounded-lg text-sm transition duration-150 ease-in-out">
                        <span x-text="label"></span>
                    </button>
                </template>
            </div>
        </nav>

        {{-- Configuration Content Area (Col 4-12) --}}
        <main class="lg:col-span-9 mt-6 lg:mt-0">
            <div class="bg-white p-6 sm:p-8 rounded-xl shadow-2xl border border-gray-100 space-y-8">
                
                {{-- Dynamic Title --}}
                <h2 class="text-xl md:text-2xl font-bold text-gray-900 border-b pb-3" 
                    x-text="mainNav === 'cms' ? cmsModules[currentModule] : settingModules[currentModule]">
                    Home Page Layout Manager
                </h2>

                {{-- CMS MODULES --}}

                {{-- Home Page Layout Manager --}}
                <div x-show="mainNav === 'cms' && currentModule === 'homepage'" class="space-y-6">
                    <p class="text-gray-600">Drag-and-drop interface for structuring the homepage appearance on web and mobile.</p>
                    <div class="p-6 bg-gray-100 rounded-lg border-2 border-dashed border-gray-300 h-96 flex items-center justify-center">
                        <p class="text-lg font-medium text-gray-500">
                            [Visual Builder Placeholder: Section Reordering]
                        </p>
                    </div>
                    <button class="px-4 py-2 text-sm font-medium text-white bg-green-600 rounded-lg hover:bg-green-700">Save Home Layout</button>
                </div>

                {{-- Banners & Promotions --}}
                <div x-show="mainNav === 'cms' && currentModule === 'banners'" class="space-y-6">
                    <p class="text-gray-600">Manage all dynamic banners, carousel slides, and promotional images.</p>
                    <div class="p-4 border rounded-lg space-y-3">
                        <div class="flex justify-between items-center bg-purple-50 p-3 rounded-md">
                            <p class="font-semibold text-purple-700">Banner ID: PROMO-WINTER25</p>
                            <span class="text-xs font-bold text-white bg-red-500 px-2 py-1 rounded-full">Expires in 7 days</span>
                        </div>
                        <button class="text-sm font-medium text-purple-600 hover:underline">Edit Banner Details</button>
                    </div>
                    <button class="px-4 py-2 text-sm font-medium text-white bg-purple-600 rounded-lg hover:bg-purple-700">Add New Banner</button>
                </div>

                {{-- Notification Templates (Push & Email) --}}
                <div x-show="mainNav === 'cms' && currentModule === 'notifications'" class="space-y-6">
                    <h3 class="text-xl font-semibold text-gray-800">Push & Email Templates</h3>
                    
                    <label class="block text-sm font-medium text-gray-700">Select Template to Edit</label>
                    <select class="w-full rounded-lg border-gray-300 text-sm focus:border-purple-500 focus:ring-purple-500">
                        <option>Order Confirmation - Email</option>
                        <option>Rider Assigned - Push Notification</option>
                    </select>

                    <h4 class="font-semibold text-gray-800 mt-4">Template Preview</h4>
                    <div class="p-4 bg-gray-100 rounded-lg text-sm font-mono text-gray-700">
                        Hi [USER_NAME], your order #[ORDER_ID] has been placed successfully.
                    </div>
                    <button class="px-4 py-2 text-sm font-medium text-white bg-indigo-600 rounded-lg hover:bg-indigo-700">Save Template</button>
                </div>

                {{-- Blogs & Static Pages --}}
                <div x-show="mainNav === 'cms' && currentModule === 'blogs'" class="space-y-6">
                    <p class="text-gray-600">Manage blog articles and static pages (About Us, T&C, Privacy).</p>
                    <div class="p-4 border rounded-lg space-y-3">
                        <div class="flex justify-between items-center">
                            <p class="font-semibold text-gray-700">Privacy Policy (Last Updated: 2025-10-15)</p>
                            <span class="text-xs font-bold text-green-500">Published</span>
                        </div>
                        <button class="text-sm font-medium text-purple-600 hover:underline">Edit Content</button>
                    </div>
                </div>

                {{-- SEO Settings --}}
                <div x-show="mainNav === 'cms' && currentModule === 'seo'" class="space-y-6">
                    <p class="text-gray-600">Configure global metadata and sitemaps for search engines.</p>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Global Title Tag</label>
                        <input type="text" value="[Your App Name] | On-Demand Services & Delivery" class="w-full rounded-lg border-gray-300 text-sm focus:border-purple-500 focus:ring-purple-500 mt-1">
                    </div>
                </div>


                {{-- SETTINGS MODULES --}}

                {{-- System Preferences --}}
                <div x-show="mainNav === 'settings' && currentModule === 'system'" class="space-y-6">
                    <h3 class="text-xl font-semibold text-gray-800">Core System Preferences</h3>
                    <div class="p-4 bg-yellow-50 rounded-lg border border-yellow-200">
                        <label class="block text-sm font-medium text-gray-700">Maintenance Mode</label>
                        <div class="flex justify-between items-center mt-2">
                             <p class="text-sm text-gray-600">Enable to take the site offline for updates (Requires Admin bypass).</p>
                             <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" class="sr-only peer">
                                <div class="w-11 h-6 bg-gray-200 rounded-full peer-checked:bg-red-600"></div>
                            </label>
                        </div>
                    </div>
                    <div>
                         <label class="block text-sm font-medium text-gray-700">Default Time Zone</label>
                         <select class="w-full rounded-lg border-gray-300 text-sm focus:border-purple-500 focus:ring-purple-500 mt-1">
                            <option>Asia/Dubai (UTC+4)</option>
                         </select>
                    </div>
                </div>

                {{-- Financial Rules (Taxes, Commissions) --}}
                <div x-show="mainNav === 'settings' && currentModule === 'finance'" class="space-y-6">
                    <p class="text-gray-600">Centralized control for tax rules and commission structures.</p>
                    <div class="p-4 border-2 border-indigo-300 rounded-xl bg-indigo-50">
                        <p class="font-bold text-indigo-700">Global Commission Rate (Base)</p>
                        <input type="number" value="15" class="w-24 text-right rounded-lg border-gray-300 text-sm focus:border-purple-500 focus:ring-purple-500 mt-1"> %
                        <button class="text-sm font-medium text-indigo-600 hover:underline ml-4">View Category Overrides</button>
                    </div>
                </div>
                
                {{-- Localization & Currencies --}}
                <div x-show="mainNav === 'settings' && currentModule === 'localization'" class="space-y-6">
                    <p class="text-gray-600">Manage supported languages and currency configurations.</p>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Default Currency</label>
                        <select class="w-full rounded-lg border-gray-300 text-sm focus:border-purple-500 focus:ring-purple-500 mt-1">
                            <option>AED - UAE Dirham</option>
                            <option>SAR - Saudi Riyal</option>
                            <option>AUD - Australian Dollar</option>
                        </select>
                        <p class="text-xs text-gray-500 mt-1">Base Currency: USD</p>
                    </div>
                </div>

                {{-- Map & Geo Settings --}}
                <div x-show="mainNav === 'settings' && currentModule === 'maps'" class="space-y-6">
                    <p class="text-gray-600">Configure map providers, API keys, and service area boundaries.</p>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Map Provider</label>
                        <select class="w-full rounded-lg border-gray-300 text-sm focus:border-purple-500 focus:ring-purple-500 mt-1">
                            <option>Google Maps</option>
                            <option>Mapbox</option>
                        </select>
                        <p class="text-xs text-gray-500 mt-1">Active Geo-fences: 12</p>
                    </div>
                </div>
                
                {{-- Payment Gateway Keys --}}
                <div x-show="mainNav === 'settings' && currentModule === 'payments'" class="space-y-6">
                    <p class="text-gray-600">Securely manage API keys and credentials for payment processors.</p>
                    <div class="p-4 border border-gray-300 rounded-lg">
                        <p class="font-bold text-gray-700">Stripe Integration</p>
                        <p class="text-xs text-green-600">Status: Live and Operational</p>
                        <input type="password" placeholder="Publishable Key" class="w-full rounded-lg border-gray-300 text-sm focus:border-purple-500 focus:ring-purple-500 mt-2">
                        <button class="text-sm font-medium text-red-600 hover:underline mt-2">Rotate Key</button>
                    </div>
                </div>
 
                {{-- Global Save Button (Sticky Footer Style) --}}
                <div class="sticky bottom-0 bg-white border-t -mx-8 p-4 flex justify-end">
                    <button class="px-6 py-3 text-lg font-medium text-white bg-purple-600 rounded-xl hover:bg-purple-700 shadow-xl transition duration-150 ease-in-out">
                        Save Changes
                    </button>
                </div>
            </div>
        </main>
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