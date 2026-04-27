@extends('layouts.app')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        <div class="flex flex-col xl:flex-row justify-between items-start xl:items-center mb-8 gap-4">
            <div>
                <h2 class="text-2xl font-bold text-[rgb(var(--text-main))]">Configuration Versioning & Rollback</h2>
                <p class="text-sm text-[rgb(var(--text-muted))] mt-1">Prevent misconfiguration-induced outages and track
                    system changes.</p>
            </div>

            <div
                class="flex items-center text-xs text-[rgb(var(--text-muted))] bg-[rgb(var(--item-active-bg))] px-4 py-2 rounded-full border border-[rgb(var(--border-color))] overflow-x-auto whitespace-nowrap">
                <span class="font-medium text-[rgb(var(--text-main))]">Change</span>
                <svg class="w-4 h-4 mx-2 text-[rgb(var(--brand-primary))]" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3">
                    </path>
                </svg>
                <span class="font-medium text-[rgb(var(--text-main))]">Snapshot</span>
                <svg class="w-4 h-4 mx-2 text-[rgb(var(--brand-primary))]" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3">
                    </path>
                </svg>
                <span class="font-medium text-[rgb(var(--text-main))]">Apply</span>
                <svg class="w-4 h-4 mx-2 text-[rgb(var(--brand-primary))]" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3">
                    </path>
                </svg>
                <span class="font-medium text-[rgb(var(--text-main))]">Monitor</span>
                <svg class="w-4 h-4 mx-2 text-[rgb(var(--brand-primary))]" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3">
                    </path>
                </svg>
                <span class="font-medium text-[rgb(var(--text-main))]">Rollback</span>
            </div>
        </div>

        <div
            class="bg-[rgb(var(--bg-card))] rounded-lg shadow-sm border border-[rgb(var(--border-color))] overflow-hidden flex flex-col mb-8">
            <div
                class="px-6 py-4 border-b border-[rgb(var(--border-color))] flex justify-between items-center bg-[rgb(var(--item-active-bg))]">
                <h5 class="text-lg font-semibold text-[rgb(var(--text-main))]">Version History</h5>
                <button
                    class="bg-[rgb(var(--bg-card))] border border-[rgb(var(--border-color))] hover:bg-[rgb(var(--item-active-bg))] text-[rgb(var(--text-main))] text-sm font-medium py-1.5 px-3 rounded transition duration-150 shadow-sm">
                    Create Manual Snapshot
                </button>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-[rgb(var(--border-color))]">
                    <thead class="bg-[rgb(var(--item-active-bg))]">
                        <tr>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-[rgb(var(--text-muted))] uppercase tracking-wider">
                                Version ID</th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-[rgb(var(--text-muted))] uppercase tracking-wider">
                                Date & Time</th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-[rgb(var(--text-muted))] uppercase tracking-wider">
                                Author</th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-[rgb(var(--text-muted))] uppercase tracking-wider">
                                Changes</th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-[rgb(var(--text-muted))] uppercase tracking-wider">
                                Status</th>
                            <th scope="col"
                                class="px-6 py-3 text-right text-xs font-medium text-[rgb(var(--text-muted))] uppercase tracking-wider">
                                Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-[rgb(var(--bg-card))] divide-y divide-[rgb(var(--border-color))]">
                        <tr class="bg-[rgb(var(--item-active-bg))]/30">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <span
                                        class="font-mono text-sm font-medium text-[rgb(var(--brand-primary))]">v2.4.1</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-[rgb(var(--text-muted))]">
                                Today, 10:45 AM
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-[rgb(var(--text-main))]">
                                System Admin
                            </td>
                            <td class="px-6 py-4 text-sm text-[rgb(var(--text-muted))]">
                                Updated API rate limits, Modified Global Geofence
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span
                                    class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800 border border-green-200">Current
                                    (Active)</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <button disabled class="text-gray-400 cursor-not-allowed mr-3"
                                    title="Cannot compare active with itself">Compare</button>
                                <button disabled class="text-gray-400 cursor-not-allowed">Rollback</button>
                            </td>
                        </tr>

                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="font-mono text-sm font-medium text-[rgb(var(--text-main))]">v2.4.0</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-[rgb(var(--text-muted))]">
                                Yesterday, 04:30 PM
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-[rgb(var(--text-main))]">
                                Ali Raza
                            </td>
                            <td class="px-6 py-4 text-sm text-[rgb(var(--text-muted))]">
                                Added 'Surcharge Zone' for Airport
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span
                                    class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800 border border-gray-200">Archived</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <button onclick="openDiffModal('v2.4.0')"
                                    class="text-[rgb(var(--brand-primary))] hover:text-[rgb(var(--brand-secondary))] mr-3 transition-colors">Compare
                                    Diff</button>
                                <button onclick="confirmRollback('v2.4.0')"
                                    class="text-red-600 hover:text-red-800 transition-colors">Rollback</button>
                            </td>
                        </tr>

                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="font-mono text-sm font-medium text-[rgb(var(--text-main))]">v2.3.9</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-[rgb(var(--text-muted))]">
                                Oct 22, 2024
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-[rgb(var(--text-main))]">
                                System Admin
                            </td>
                            <td class="px-6 py-4 text-sm text-[rgb(var(--text-muted))]">
                                Updated Map Provider to Mapbox
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span
                                    class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800 border border-gray-200">Archived</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <button onclick="openDiffModal('v2.3.9')"
                                    class="text-[rgb(var(--brand-primary))] hover:text-[rgb(var(--brand-secondary))] mr-3 transition-colors">Compare
                                    Diff</button>
                                <button onclick="confirmRollback('v2.3.9')"
                                    class="text-red-600 hover:text-red-800 transition-colors">Rollback</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div id="diffModal" class="hidden relative z-50" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="fixed inset-0 bg-gray-900 bg-opacity-75 transition-opacity"></div>
        <div class="fixed inset-0 z-10 overflow-y-auto">
            <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                <div
                    class="relative transform overflow-hidden rounded-lg bg-[rgb(var(--bg-card))] text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-4xl">

                    <div
                        class="bg-[rgb(var(--bg-card))] px-6 py-4 border-b border-[rgb(var(--border-color))] flex justify-between items-center">
                        <div>
                            <h3 class="text-lg font-semibold leading-6 text-[rgb(var(--text-main))]" id="modal-title">
                                Configuration Comparison
                            </h3>
                            <p class="text-sm text-[rgb(var(--text-muted))] mt-1">Comparing Active (<span
                                    class="font-mono">v2.4.1</span>) against Target (<span id="targetVersionLabel"
                                    class="font-mono font-bold text-[rgb(var(--brand-primary))]">v2.4.0</span>)</p>
                        </div>
                        <button onclick="closeDiffModal()"
                            class="text-[rgb(var(--text-muted))] hover:text-[rgb(var(--text-main))] focus:outline-none">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 mx-6 mt-4 rounded-r-md">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-yellow-800">Impact Preview Warning</h3>
                                <p class="text-sm text-yellow-700 mt-1">Rolling back to this version will revert <strong
                                        id="impactScope">API limits</strong> and <strong id="impactUsers">affect currently
                                        active geofences</strong>. Approximately <span class="font-bold">120 active
                                        drivers</span> might experience session refreshes.</p>
                            </div>
                        </div>
                    </div>

                    <div class="p-6 bg-[rgb(var(--bg-card))]">
                        <div
                            class="grid grid-cols-2 gap-4 rounded-md border border-[rgb(var(--border-color))] overflow-hidden">

                            <div class="bg-[rgb(var(--bg-body))] border-r border-[rgb(var(--border-color))]">
                                <div
                                    class="bg-[rgb(var(--item-active-bg))] px-4 py-2 border-b border-[rgb(var(--border-color))] text-xs font-bold text-[rgb(var(--text-main))]">
                                    Target Version (<span id="diffOldLabel">v2.4.0</span>)
                                </div>
                                <pre class="p-4 text-xs font-mono text-[rgb(var(--text-main))] overflow-x-auto whitespace-pre-wrap"><code>{
  "api_rate_limit": <span class="bg-green-100 text-green-800 px-1 rounded">"500"</span>,
  "burst_limit": "50",
  "geofence_active": <span class="bg-green-100 text-green-800 px-1 rounded">false</span>,
  "provider": "google_maps"
}</code></pre>
                            </div>

                            <div class="bg-[rgb(var(--bg-body))]">
                                <div
                                    class="bg-[rgb(var(--item-active-bg))] px-4 py-2 border-b border-[rgb(var(--border-color))] text-xs font-bold text-[rgb(var(--text-main))]">
                                    Current Active (v2.4.1)
                                </div>
                                <pre class="p-4 text-xs font-mono text-[rgb(var(--text-main))] overflow-x-auto whitespace-pre-wrap"><code>{
  "api_rate_limit": <span class="bg-red-100 text-red-800 line-through px-1 rounded">"1000"</span>,
  "burst_limit": "50",
  "geofence_active": <span class="bg-red-100 text-red-800 line-through px-1 rounded">true</span>,
  "provider": "google_maps"
}</code></pre>
                            </div>
                        </div>
                    </div>

                    <div
                        class="bg-[rgb(var(--item-active-bg))] px-6 py-4 flex items-center justify-between rounded-b-lg border-t border-[rgb(var(--border-color))]">
                        <span class="text-sm text-[rgb(var(--text-muted))]">Review changes carefully before
                            applying.</span>
                        <div class="flex gap-3">
                            <button onclick="closeDiffModal()" type="button"
                                class="bg-[rgb(var(--bg-card))] px-4 py-2 text-sm font-medium text-[rgb(var(--text-main))] border border-[rgb(var(--border-color))] rounded-md shadow-sm hover:bg-[rgb(var(--item-active-bg))] transition-colors focus:outline-none focus:ring-2 focus:ring-[rgb(var(--brand-primary))]">
                                Cancel
                            </button>
                            <button id="executeRollbackBtn" type="button"
                                class="bg-red-600 px-4 py-2 text-sm font-medium text-white border border-transparent rounded-md shadow-sm hover:bg-red-700 transition-colors focus:outline-none focus:ring-2 focus:ring-red-500 flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"></path>
                                </svg>
                                One-Click Rollback
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        let currentTargetVersion = '';

         function openDiffModal(version) {
            currentTargetVersion = version;
            document.getElementById('targetVersionLabel').innerText = version;
            document.getElementById('diffOldLabel').innerText = version;

             if (version === 'v2.3.9') {
                document.getElementById('impactScope').innerText = 'Map Provider Settings';
                document.getElementById('impactUsers').innerText = 'disrupt active route calculations';
            } else {
                document.getElementById('impactScope').innerText = 'API limits';
                document.getElementById('impactUsers').innerText = 'affect currently active geofences';
            }

            document.getElementById('diffModal').classList.remove('hidden');
        }

        // Close Modal
        function closeDiffModal() {
            document.getElementById('diffModal').classList.add('hidden');
        }

         function confirmRollback(version) {
            if (confirm(
                    `WARNING: Are you sure you want to rollback the active configuration to ${version}? This action will create a new snapshot of the current state before reverting.`
                )) {
                simulateRollbackProcess(version);
            }
        }

         document.getElementById('executeRollbackBtn').addEventListener('click', function() {
            simulateRollbackProcess(currentTargetVersion, true);
        });

         function simulateRollbackProcess(version, fromModal = false) {
            if (fromModal) {
                const btn = document.getElementById('executeRollbackBtn');
                btn.innerHTML = `
                <svg class="animate-spin h-4 w-4 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                Rolling back...
            `;
                btn.disabled = true;
                btn.classList.add('opacity-75', 'cursor-not-allowed');
            }

            setTimeout(() => {
                alert(
                    `System successfully rolled back to ${version}.\nA backup snapshot of the pre-rollback state has been saved.`
                );
                if (fromModal) closeDiffModal();
                location.reload();  
            }, 1500);
        }
    </script>
@endpush
