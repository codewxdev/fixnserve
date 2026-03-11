@extends('layouts.app')

@section('content')
<div class="w-full px-4 py-6 max-w-7xl mx-auto">
    
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
        <div>
            <h2 class="text-2xl font-bold text-[rgb(var(--text-main))]">Geo & Map Configuration</h2>
            <p class="text-sm text-[rgb(var(--text-muted))] mt-1">Control location-based behavior and restrictions.</p>
        </div>
        <div class="flex items-center gap-3">
            <button id="emergencyLockBtn" onclick="toggleEmergencyLock()" class="bg-red-600 hover:bg-red-700 text-white font-medium py-2 px-4 rounded-md inline-flex items-center transition duration-150 ease-in-out shadow-sm">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                Emergency Geo-Lock
            </button>
        </div>
    </div>

    <div class="grid grid-cols-1 xl:grid-cols-12 gap-6"> 
        <div class="xl:col-span-4 flex flex-col gap-6">
            <div class="bg-[rgb(var(--bg-card))] rounded-lg shadow-sm border border-[rgb(var(--border-color))]">
                <div class="px-6 py-4 border-b border-[rgb(var(--border-color))] bg-[rgb(var(--item-active-bg))] rounded-t-lg">
                    <h5 class="text-lg font-semibold text-[rgb(var(--text-main))]">Core Settings</h5>
                </div>
                <div class="p-6">
                    <form>
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-[rgb(var(--text-muted))] mb-1">Map Provider Selection</label>
                            <select class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-[rgb(var(--border-color))] focus:outline-none focus:ring-[rgb(var(--brand-primary))] focus:border-[rgb(var(--brand-primary))] sm:text-sm rounded-md border text-[rgb(var(--text-main))] bg-[rgb(var(--bg-card))]">
                                <option value="google">Google Maps API</option>
                                <option value="mapbox">Mapbox</option>
                                <option value="osm">OpenStreetMap</option>
                            </select>
                        </div>
                        
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-[rgb(var(--text-muted))] mb-1">Distance Calculation Mode</label>
                            <select class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-[rgb(var(--border-color))] focus:outline-none focus:ring-[rgb(var(--brand-primary))] focus:border-[rgb(var(--brand-primary))] sm:text-sm rounded-md border text-[rgb(var(--text-main))] bg-[rgb(var(--bg-card))]">
                                <option value="driving">Routing Engine (Actual Driving Dist.)</option>
                                <option value="haversine">Haversine (Straight Line)</option>
                                <option value="manhattan">Manhattan Distance</option>
                            </select>
                        </div>

                        <div class="mb-6">
                            <label class="block text-sm font-medium text-[rgb(var(--text-muted))] mb-1">Default Service Radius (km)</label>
                            <input type="number" value="15" class="mt-1 block w-full rounded-md border-[rgb(var(--border-color))] bg-[rgb(var(--bg-card))] text-[rgb(var(--text-main))] border py-2 px-3 focus:border-[rgb(var(--brand-primary))] focus:ring-[rgb(var(--brand-primary))] sm:text-sm">
                            <p class="text-xs text-[rgb(var(--text-muted))] mt-1">Maximum allowed distance for delivery/service allocation.</p>
                        </div>

                        <button type="button" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-[rgb(var(--brand-primary))] hover:bg-[rgb(var(--brand-secondary))] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[rgb(var(--brand-primary))] transition duration-150">
                            Save Configuration
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <div class="xl:col-span-8">
            <div class="bg-[rgb(var(--bg-card))] rounded-lg shadow-sm border border-[rgb(var(--border-color))] h-full flex flex-col">
                <div class="px-6 py-4 border-b border-[rgb(var(--border-color))] flex justify-between items-center bg-[rgb(var(--item-active-bg))] rounded-t-lg">
                    <h5 class="text-lg font-semibold text-[rgb(var(--text-main))]">Geofencing & Regional Rules</h5>
                    <button onclick="toggleModal('addGeofenceModal')" class="bg-[rgb(var(--brand-primary))] hover:bg-[rgb(var(--brand-secondary))] text-white text-sm font-medium py-1.5 px-3 rounded transition duration-150">
                        + Add Geofence
                    </button>
                </div>
                
                <div class="overflow-x-auto flex-1">
                    <table class="min-w-full divide-y divide-[rgb(var(--border-color))]">
                        <thead class="bg-[rgb(var(--item-active-bg))]">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-[rgb(var(--text-muted))] uppercase tracking-wider">Zone Name</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-[rgb(var(--text-muted))] uppercase tracking-wider">Type</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-[rgb(var(--text-muted))] uppercase tracking-wider">Details</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-[rgb(var(--text-muted))] uppercase tracking-wider">Status</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-[rgb(var(--text-muted))] uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-[rgb(var(--bg-card))] divide-y divide-[rgb(var(--border-color))]">
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-[rgb(var(--text-main))]">Downtown Hub</div>
                                    <div class="text-xs text-[rgb(var(--text-muted))]">Polygon (14 points)</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-md bg-green-100 text-green-800 border border-green-200">Service Area</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-[rgb(var(--text-muted))]">
                                    Base fare multiplier: 1.0x
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <label class="relative inline-flex items-center cursor-pointer" title="Enable/Disable Region">
                                        <input type="checkbox" class="sr-only peer" checked>
                                        <div class="w-9 h-5 bg-gray-200 peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-[rgb(var(--brand-primary))] rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-[rgb(var(--bg-card))] after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-[rgb(var(--bg-card))] after:border-[rgb(var(--border-color))] after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-[rgb(var(--brand-primary))]"></div>
                                    </label>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <button class="text-[rgb(var(--brand-primary))] hover:text-[rgb(var(--brand-secondary))] mr-3">Edit</button>
                                    <button class="text-red-600 hover:text-red-800">Delete</button>
                                </td>
                            </tr>
                            
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-[rgb(var(--text-main))]">Military Cantonment</div>
                                    <div class="text-xs text-[rgb(var(--text-muted))]">Radius: 5km</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-md bg-red-100 text-red-800 border border-red-200">Restricted Zone</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-[rgb(var(--text-muted))]">
                                    No pickups/drop-offs
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <label class="relative inline-flex items-center cursor-pointer" title="Enable/Disable Region">
                                        <input type="checkbox" class="sr-only peer" checked>
                                        <div class="w-9 h-5 bg-gray-200 peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-[rgb(var(--brand-primary))] rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-[rgb(var(--bg-card))] after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-[rgb(var(--bg-card))] after:border-[rgb(var(--border-color))] after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-[rgb(var(--brand-primary))]"></div>
                                    </label>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <button class="text-[rgb(var(--brand-primary))] hover:text-[rgb(var(--brand-secondary))] mr-3">Edit</button>
                                    <button class="text-red-600 hover:text-red-800">Delete</button>
                                </td>
                            </tr>
                            
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-[rgb(var(--text-main))]">Airport Terminal</div>
                                    <div class="text-xs text-[rgb(var(--text-muted))]">Polygon (8 points)</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-md bg-yellow-100 text-yellow-800 border border-yellow-200">Surcharge Zone</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-[rgb(var(--text-muted))]">
                                    Fee: +150 PKR
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <label class="relative inline-flex items-center cursor-pointer" title="Enable/Disable Region">
                                        <input type="checkbox" class="sr-only peer">
                                        <div class="w-9 h-5 bg-gray-200 peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-[rgb(var(--brand-primary))] rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-[rgb(var(--bg-card))] after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-[rgb(var(--bg-card))] after:border-[rgb(var(--border-color))] after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-[rgb(var(--brand-primary))]"></div>
                                    </label>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <button class="text-[rgb(var(--brand-primary))] hover:text-[rgb(var(--brand-secondary))] mr-3">Edit</button>
                                    <button class="text-red-600 hover:text-red-800">Delete</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="addGeofenceModal" class="hidden relative z-50" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>
    <div class="fixed inset-0 z-10 overflow-y-auto">
        <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
            <div class="relative transform overflow-hidden rounded-lg bg-[rgb(var(--bg-card))] text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-2xl">
                <div class="bg-[rgb(var(--bg-card))] px-4 pb-4 pt-5 sm:p-6 sm:pb-4 border-b border-[rgb(var(--border-color))]">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-semibold leading-6 text-[rgb(var(--text-main))]" id="modal-title">Add New Geofence</h3>
                        <button onclick="toggleModal('addGeofenceModal')" class="text-[rgb(var(--text-muted))] hover:text-[rgb(var(--text-main))]">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
                        </button>
                    </div>
                    <form>
                        <div class="grid grid-cols-2 gap-4">
                            <div class="col-span-2 sm:col-span-1 mb-4">
                                <label class="block text-sm font-medium text-[rgb(var(--text-muted))] mb-1">Zone Name</label>
                                <input type="text" class="mt-1 block w-full rounded-md border-[rgb(var(--border-color))] bg-[rgb(var(--bg-card))] text-[rgb(var(--text-main))] border py-2 px-3 focus:border-[rgb(var(--brand-primary))] focus:ring-[rgb(var(--brand-primary))] sm:text-sm" placeholder="e.g. North Side Block">
                            </div>
                            <div class="col-span-2 sm:col-span-1 mb-4">
                                <label class="block text-sm font-medium text-[rgb(var(--text-muted))] mb-1">Rule Type</label>
                                <select class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-[rgb(var(--border-color))] focus:outline-none focus:ring-[rgb(var(--brand-primary))] focus:border-[rgb(var(--brand-primary))] sm:text-sm rounded-md border text-[rgb(var(--text-main))] bg-[rgb(var(--bg-card))]">
                                    <option value="service">Service Area</option>
                                    <option value="restricted">Restricted Zone</option>
                                    <option value="surcharge">Surcharge Zone</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-[rgb(var(--text-muted))] mb-2">Draw Area on Map</label>
                            <div class="w-full h-64 bg-gray-200 rounded-md border border-[rgb(var(--border-color))] flex items-center justify-center relative overflow-hidden">
                                <span class="text-gray-500 text-sm font-medium z-10 bg-white/80 px-3 py-1 rounded shadow-sm">Map Integration Canvas</span>
                                <div class="absolute inset-0 opacity-20" style="background-image: radial-gradient(circle, #000 1px, transparent 1px); background-size: 20px 20px;"></div>
                            </div>
                            <div class="flex gap-2 mt-2">
                                <button type="button" class="text-xs bg-[rgb(var(--item-active-bg))] border border-[rgb(var(--border-color))] text-[rgb(var(--text-main))] px-3 py-1.5 rounded hover:bg-gray-100">Draw Polygon</button>
                                <button type="button" class="text-xs bg-[rgb(var(--item-active-bg))] border border-[rgb(var(--border-color))] text-[rgb(var(--text-main))] px-3 py-1.5 rounded hover:bg-gray-100">Draw Circle</button>
                                <button type="button" class="text-xs bg-red-50 border border-red-200 text-red-600 px-3 py-1.5 rounded hover:bg-red-100 ml-auto">Clear Shape</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="bg-[rgb(var(--item-active-bg))] px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
                    <button type="button" class="inline-flex w-full justify-center rounded-md bg-[rgb(var(--brand-primary))] px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-[rgb(var(--brand-secondary))] sm:ml-3 sm:w-auto">Save Geofence</button>
                    <button onclick="toggleModal('addGeofenceModal')" type="button" class="mt-3 inline-flex w-full justify-center rounded-md bg-[rgb(var(--bg-card))] px-3 py-2 text-sm font-semibold text-[rgb(var(--text-main))] shadow-sm ring-1 ring-inset ring-[rgb(var(--border-color))] hover:bg-[rgb(var(--item-active-bg))] sm:mt-0 sm:w-auto">Cancel</button>
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

    // Emergency Geo-Lock Simulation
    function toggleEmergencyLock() {
        const btn = document.getElementById('emergencyLockBtn');
        const isLocked = btn.classList.contains('bg-gray-800');
        
        if (!isLocked) {
            const confirmLock = confirm("⚠️ WARNING: Enabling Emergency Geo-Lock will instantly suspend ALL service availability in all regions and halt the routing engine. Proceed?");
            
            if (confirmLock) {
                btn.classList.replace('bg-red-600', 'bg-gray-800');
                btn.classList.replace('hover:bg-red-700', 'hover:bg-gray-900');
                btn.innerHTML = `
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                    System Locked
                `;
                alert("🚨 Emergency Geo-Lock ACTIVATED. All services halted.");
            }
        } else {
            const unlock = confirm("Are you sure you want to disable the lock and resume normal operations?");
            if (unlock) {
                btn.classList.replace('bg-gray-800', 'bg-red-600');
                btn.classList.replace('hover:bg-gray-900', 'hover:bg-red-700');
                btn.innerHTML = `
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                    Emergency Geo-Lock
                `;
                alert("✅ System Unlocked. Normal routing and service availability restored.");
            }
        }
    }
</script>
@endpush

 