@extends('layouts.app')

@section('content')
<div class="w-full px-4 py-6 max-w-7xl mx-auto">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">Localization & Internationalization (I18N)</h2>
            <p class="text-sm text-gray-500 mt-1">Manage multi-country and multi-language operations.</p>
        </div>
        <div>
            <button id="syncCacheBtn" onclick="triggerSystemFlow()" class="bg-green-600 hover:bg-green-700 text-white font-medium py-2 px-4 rounded-md inline-flex items-center transition duration-150 ease-in-out shadow-sm">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                Sync Translations & Refresh Cache
            </button>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
        <div class="lg:col-span-7">
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 h-full flex flex-col">
                <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center bg-gray-50 rounded-t-lg">
                    <h5 class="text-lg font-semibold text-gray-800">Language & Locale Management</h5>
                    <button onclick="toggleModal('addLocaleModal')" class="bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium py-1.5 px-3 rounded transition duration-150">
                        + Add Locale
                    </button>
                </div>
                <div class="overflow-x-auto flex-1">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Locale</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Language</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <code class="text-sm bg-gray-100 px-2 py-1 rounded text-pink-600 font-mono">en-US</code>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">English (United States)</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Enabled</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium flex items-center space-x-3">
                                    <label class="relative inline-flex items-center cursor-pointer" title="Enable/Disable">
                                        <input type="checkbox" value="" class="sr-only peer" checked>
                                        <div class="w-9 h-5 bg-gray-200 peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-blue-600"></div>
                                    </label>
                                    <button class="text-red-600 border border-red-600 hover:bg-red-50 py-1 px-3 rounded text-xs transition duration-150" title="Deprecate Locale">Deprecate</button>
                                </td>
                            </tr>
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <code class="text-sm bg-gray-100 px-2 py-1 rounded text-pink-600 font-mono">ur-PK</code>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">Urdu (Pakistan)</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Enabled</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium flex items-center space-x-3">
                                    <label class="relative inline-flex items-center cursor-pointer" title="Enable/Disable">
                                        <input type="checkbox" value="" class="sr-only peer" checked>
                                        <div class="w-9 h-5 bg-gray-200 peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-blue-600"></div>
                                    </label>
                                    <button class="text-red-600 border border-red-600 hover:bg-red-50 py-1 px-3 rounded text-xs transition duration-150" title="Deprecate Locale">Deprecate</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="lg:col-span-5 flex flex-col gap-6">
            <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                <div class="px-6 py-4 border-b border-gray-200 bg-gray-50 rounded-t-lg">
                    <h5 class="text-lg font-semibold text-gray-800">Regional Configurations</h5>
                </div>
                <div class="p-6">
                    <form>
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Select Region</label>
                            <select class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md border">
                                <option value="global">Global (Default)</option>
                                <option value="pk">Pakistan</option>
                                <option value="us">United States</option>
                            </select>
                        </div>
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Default Language for Region</label>
                            <select class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md border">
                                <option value="en">English</option>
                                <option value="ur">Urdu</option>
                            </select>
                        </div>
                        <div class="mb-5 flex items-start">
                            <div class="flex items-center h-5">
                                <input id="overrideRegion" type="checkbox" class="focus:ring-blue-500 h-4 w-4 text-blue-600 border-gray-300 rounded">
                            </div>
                            <div class="ml-3 text-sm">
                                <label for="overrideRegion" class="font-medium text-gray-700">Enable Overrides per Region</label>
                            </div>
                        </div>
                        <button type="button" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            Save Region Settings
                        </button>
                    </form>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                <div class="px-6 py-4 border-b border-gray-200 bg-gray-50 rounded-t-lg">
                    <h5 class="text-lg font-semibold text-gray-800">Global Format Settings</h5>
                </div>
                <div class="p-6">
                    <form>
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Currency Configuration</label>
                            <select class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md border">
                                <option value="PKR">PKR (₨)</option>
                                <option value="USD">USD ($)</option>
                            </select>
                        </div>
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Date/Time Format</label>
                            <select class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md border">
                                <option value="Y-m-d H:i:s">YYYY-MM-DD HH:MM:SS (2024-10-25 14:30:00)</option>
                                <option value="d/m/Y h:i A">DD/MM/YYYY hh:mm AM/PM (25/10/2024 02:30 PM)</option>
                            </select>
                        </div>
                        <div class="mb-5">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Number Format</label>
                            <select class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md border">
                                <option value="1,000.00">1,000.00 (US/UK Style)</option>
                                <option value="1.000,00">1.000,00 (EU Style)</option>
                            </select>
                        </div>
                        <button type="button" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            Save Formats
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="addLocaleModal" class="hidden relative z-10" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>
    <div class="fixed inset-0 z-10 overflow-y-auto">
        <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
            <div class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg">
                <div class="bg-white px-4 pb-4 pt-5 sm:p-6 sm:pb-4 border-b border-gray-200">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-semibold leading-6 text-gray-900" id="modal-title">Add New Locale</h3>
                        <button onclick="toggleModal('addLocaleModal')" class="text-gray-400 hover:text-gray-500">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
                        </button>
                    </div>
                    <form>
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Locale Code (e.g., fr-FR)</label>
                            <input type="text" class="mt-1 block w-full rounded-md border-gray-300 border py-2 px-3 focus:border-blue-500 focus:ring-blue-500 sm:text-sm" placeholder="fr-FR">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Language Name</label>
                            <input type="text" class="mt-1 block w-full rounded-md border-gray-300 border py-2 px-3 focus:border-blue-500 focus:ring-blue-500 sm:text-sm" placeholder="French (France)">
                        </div>
                    </form>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
                    <button type="button" class="inline-flex w-full justify-center rounded-md bg-blue-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-blue-700 sm:ml-3 sm:w-auto">Add Locale</button>
                    <button onclick="toggleModal('addLocaleModal')" type="button" class="mt-3 inline-flex w-full justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:mt-0 sm:w-auto">Cancel</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Modal Toggle Function
    function toggleModal(modalID) {
        document.getElementById(modalID).classList.toggle("hidden");
    }

    // Simulate the Flow: Locale Change -> Translation Sync -> App Update -> Cache Refresh
    function triggerSystemFlow() {
        const btn = document.getElementById('syncCacheBtn');
        const originalText = btn.innerHTML;
        
        // Step 1: UI loading state (Adding simple spinner SVG via JS)
        btn.innerHTML = `
            <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            Syncing Translations...`;
        btn.disabled = true;
        btn.classList.add('opacity-75', 'cursor-not-allowed');

        // Step 2: Simulate API Call flow
        setTimeout(() => {
            btn.innerHTML = `
            <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            Updating App & Cache...`;
            
            setTimeout(() => {
                // Flow Complete
                btn.innerHTML = `
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                System Updated`;
                
                btn.classList.replace('bg-green-600', 'bg-blue-600');
                btn.classList.replace('hover:bg-green-700', 'hover:bg-blue-700');
                
                // Reset after 3 seconds
                setTimeout(() => {
                    btn.innerHTML = originalText;
                    btn.classList.replace('bg-blue-600', 'bg-green-600');
                    btn.classList.replace('hover:bg-blue-700', 'hover:bg-green-700');
                    btn.disabled = false;
                    btn.classList.remove('opacity-75', 'cursor-not-allowed');
                }, 3000);
                
                alert('Flow Executed Successfully:\n1. Translation Synced\n2. App Updated\n3. Cache Refreshed');
            }, 1500);
        }, 1500);
    }
</script>
@endpush

@push('styles')
    @endpush