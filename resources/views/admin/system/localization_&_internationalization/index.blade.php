@extends('layouts.app')

@section('content')
<div class="w-full px-4 py-6 max-w-7xl mx-auto">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
        <div>
            <h2 class="text-2xl font-bold text-[rgb(var(--text-main))]">Localization & Internationalization (I18N)</h2>
            <p class="text-sm text-[rgb(var(--text-muted))] mt-1">Manage multi-country and multi-language operations.</p>
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
            <div class="bg-[rgb(var(--bg-card))] rounded-lg shadow-sm border border-[rgb(var(--border-color))] h-full flex flex-col">
                <div class="px-6 py-4 border-b border-[rgb(var(--border-color))] flex justify-between items-center bg-[rgb(var(--item-active-bg))] rounded-t-lg">
                    <h5 class="text-lg font-semibold text-[rgb(var(--text-main))]">Language & Locale Management</h5>
                    <button onclick="toggleModal('addLocaleModal')" class="bg-[rgb(var(--brand-primary))] hover:bg-[rgb(var(--brand-secondary))] text-white text-sm font-medium py-1.5 px-3 rounded transition duration-150">
                        + Add Locale
                    </button>
                </div>
                <div class="overflow-x-auto flex-1">
                    <table class="min-w-full divide-y divide-[rgb(var(--border-color))]">
                        <thead class="bg-[rgb(var(--item-active-bg))]">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-[rgb(var(--text-muted))] uppercase tracking-wider">Locale</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-[rgb(var(--text-muted))] uppercase tracking-wider">Language</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-[rgb(var(--text-muted))] uppercase tracking-wider">Status</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-[rgb(var(--text-muted))] uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-[rgb(var(--bg-card))] divide-y divide-[rgb(var(--border-color))]">
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <code class="text-sm bg-[rgb(var(--item-active-bg))] px-2 py-1 rounded text-pink-600 font-mono">en-US</code>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-[rgb(var(--text-muted))]">English (United States)</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Enabled</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium flex items-center space-x-3">
                                    <label class="relative inline-flex items-center cursor-pointer" title="Enable/Disable">
                                        <input type="checkbox" value="" class="sr-only peer" checked>
                                        <div class="w-9 h-5 bg-gray-200 peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-[rgb(var(--brand-primary))] rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-[rgb(var(--bg-card))] after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-[rgb(var(--bg-card))] after:border-[rgb(var(--border-color))] after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-[rgb(var(--brand-primary))]"></div>
                                    </label>
                                    <button class="text-red-600 border border-red-600 hover:bg-red-50 py-1 px-3 rounded text-xs transition duration-150" title="Deprecate Locale">Deprecate</button>
                                </td>
                            </tr>
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <code class="text-sm bg-[rgb(var(--item-active-bg))] px-2 py-1 rounded text-pink-600 font-mono">ur-PK</code>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-[rgb(var(--text-muted))]">Urdu (Pakistan)</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Enabled</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium flex items-center space-x-3">
                                    <label class="relative inline-flex items-center cursor-pointer" title="Enable/Disable">
                                        <input type="checkbox" value="" class="sr-only peer" checked>
                                        <div class="w-9 h-5 bg-gray-200 peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-[rgb(var(--brand-primary))] rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-[rgb(var(--bg-card))] after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-[rgb(var(--bg-card))] after:border-[rgb(var(--border-color))] after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-[rgb(var(--brand-primary))]"></div>
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
            <div class="bg-[rgb(var(--bg-card))] rounded-lg shadow-sm border border-[rgb(var(--border-color))]">
                <div class="px-6 py-4 border-b border-[rgb(var(--border-color))] bg-[rgb(var(--item-active-bg))] rounded-t-lg">
                    <h5 class="text-lg font-semibold text-[rgb(var(--text-main))]">Regional Configurations</h5>
                </div>
                <div class="p-6">
                    <form>
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-[rgb(var(--text-muted))] mb-1">Select Region</label>
                            <select class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-[rgb(var(--border-color))] focus:outline-none focus:ring-[rgb(var(--brand-primary))] focus:border-[rgb(var(--brand-primary))] sm:text-sm rounded-md border text-[rgb(var(--text-main))] bg-[rgb(var(--bg-card))]">
                                <option value="global">Global (Default)</option>
                                <option value="pk">Pakistan</option>
                                <option value="us">United States</option>
                            </select>
                        </div>
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-[rgb(var(--text-muted))] mb-1">Default Language for Region</label>
                            <select class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-[rgb(var(--border-color))] focus:outline-none focus:ring-[rgb(var(--brand-primary))] focus:border-[rgb(var(--brand-primary))] sm:text-sm rounded-md border text-[rgb(var(--text-main))] bg-[rgb(var(--bg-card))]">
                                <option value="en">English</option>
                                <option value="ur">Urdu</option>
                            </select>
                        </div>
                        <div class="mb-5 flex items-start">
                            <div class="flex items-center h-5">
                                <input id="overrideRegion" type="checkbox" class="focus:ring-[rgb(var(--brand-primary))] h-4 w-4 text-[rgb(var(--brand-primary))] border-[rgb(var(--border-color))] rounded">
                            </div>
                            <div class="ml-3 text-sm">
                                <label for="overrideRegion" class="font-medium text-[rgb(var(--text-muted))]">Enable Overrides per Region</label>
                            </div>
                        </div>
                        <button type="button" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-[rgb(var(--brand-primary))] hover:bg-[rgb(var(--brand-secondary))] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[rgb(var(--brand-primary))]">
                            Save Region Settings
                        </button>
                    </form>
                </div>
            </div>

            <div class="bg-[rgb(var(--bg-card))] rounded-lg shadow-sm border border-[rgb(var(--border-color))]">
                <div class="px-6 py-4 border-b border-[rgb(var(--border-color))] bg-[rgb(var(--item-active-bg))] rounded-t-lg">
                    <h5 class="text-lg font-semibold text-[rgb(var(--text-main))]">Global Format Settings</h5>
                </div>
                <div class="p-6">
                    <form>
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-[rgb(var(--text-muted))] mb-1">Currency Configuration</label>
                            <select class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-[rgb(var(--border-color))] focus:outline-none focus:ring-[rgb(var(--brand-primary))] focus:border-[rgb(var(--brand-primary))] sm:text-sm rounded-md border text-[rgb(var(--text-main))] bg-[rgb(var(--bg-card))]">
                                <option value="PKR">PKR (₨)</option>
                                <option value="USD">USD ($)</option>
                            </select>
                        </div>
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-[rgb(var(--text-muted))] mb-1">Date/Time Format</label>
                            <select class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-[rgb(var(--border-color))] focus:outline-none focus:ring-[rgb(var(--brand-primary))] focus:border-[rgb(var(--brand-primary))] sm:text-sm rounded-md border text-[rgb(var(--text-main))] bg-[rgb(var(--bg-card))]">
                                <option value="Y-m-d H:i:s">YYYY-MM-DD HH:MM:SS (2024-10-25 14:30:00)</option>
                                <option value="d/m/Y h:i A">DD/MM/YYYY hh:mm AM/PM (25/10/2024 02:30 PM)</option>
                            </select>
                        </div>
                        <div class="mb-5">
                            <label class="block text-sm font-medium text-[rgb(var(--text-muted))] mb-1">Number Format</label>
                            <select class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-[rgb(var(--border-color))] focus:outline-none focus:ring-[rgb(var(--brand-primary))] focus:border-[rgb(var(--brand-primary))] sm:text-sm rounded-md border text-[rgb(var(--text-main))] bg-[rgb(var(--bg-card))]">
                                <option value="1,000.00">1,000.00 (US/UK Style)</option>
                                <option value="1.000,00">1.000,00 (EU Style)</option>
                            </select>
                        </div>
                        <button type="button" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-[rgb(var(--brand-primary))] hover:bg-[rgb(var(--brand-secondary))] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[rgb(var(--brand-primary))]">
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
            <div class="relative transform overflow-hidden rounded-lg bg-[rgb(var(--bg-card))] text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg">
                <div class="bg-[rgb(var(--bg-card))] px-4 pb-4 pt-5 sm:p-6 sm:pb-4 border-b border-[rgb(var(--border-color))]">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-semibold leading-6 text-[rgb(var(--text-main))]" id="modal-title">Add New Locale</h3>
                        <button onclick="toggleModal('addLocaleModal')" class="text-[rgb(var(--text-muted))] hover:text-[rgb(var(--text-main))]">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
                        </button>
                    </div>
                    <form>
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-[rgb(var(--text-muted))] mb-1">Locale Code (e.g., fr-FR)</label>
                            <input type="text" class="mt-1 block w-full rounded-md border-[rgb(var(--border-color))] bg-[rgb(var(--bg-card))] text-[rgb(var(--text-main))] border py-2 px-3 focus:border-[rgb(var(--brand-primary))] focus:ring-[rgb(var(--brand-primary))] sm:text-sm" placeholder="fr-FR">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-[rgb(var(--text-muted))] mb-1">Language Name</label>
                            <input type="text" class="mt-1 block w-full rounded-md border-[rgb(var(--border-color))] bg-[rgb(var(--bg-card))] text-[rgb(var(--text-main))] border py-2 px-3 focus:border-[rgb(var(--brand-primary))] focus:ring-[rgb(var(--brand-primary))] sm:text-sm" placeholder="French (France)">
                        </div>
                    </form>
                </div>
                <div class="bg-[rgb(var(--item-active-bg))] px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
                    <button type="button" class="inline-flex w-full justify-center rounded-md bg-[rgb(var(--brand-primary))] px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-[rgb(var(--brand-secondary))] sm:ml-3 sm:w-auto">Add Locale</button>
                    <button onclick="toggleModal('addLocaleModal')" type="button" class="mt-3 inline-flex w-full justify-center rounded-md bg-[rgb(var(--bg-card))] px-3 py-2 text-sm font-semibold text-[rgb(var(--text-main))] shadow-sm ring-1 ring-inset ring-[rgb(var(--border-color))] hover:bg-[rgb(var(--item-active-bg))] sm:mt-0 sm:w-auto">Cancel</button>
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

     function triggerSystemFlow() {
        const btn = document.getElementById('syncCacheBtn');
        const originalText = btn.innerHTML;
        
         btn.innerHTML = `
            <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            Syncing Translations...`;
        btn.disabled = true;
        btn.classList.add('opacity-75', 'cursor-not-allowed');

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
                
                 btn.classList.replace('bg-green-600', 'bg-[rgb(var(--brand-primary))]');
                btn.classList.replace('hover:bg-green-700', 'hover:bg-[rgb(var(--brand-secondary))]');
                
                 setTimeout(() => {
                    btn.innerHTML = originalText;
                     btn.classList.replace('bg-[rgb(var(--brand-primary))]', 'bg-green-600');
                    btn.classList.replace('hover:bg-[rgb(var(--brand-secondary))]', 'hover:bg-green-700');
                    btn.disabled = false;
                    btn.classList.remove('opacity-75', 'cursor-not-allowed');
                }, 3000);
                
                alert('Flow Executed Successfully:\n1. Translation Synced\n2. App Updated\n3. Cache Refreshed');
            }, 1500);
        }, 1500);
    }
</script>
@endpush

 