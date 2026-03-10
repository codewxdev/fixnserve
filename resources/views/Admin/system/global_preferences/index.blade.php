@extends('layouts.app')

@section('content')
    <div class="w-full px-4 py-8 mx-auto theme-bg-body min-h-screen transition-colors duration-300">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
            <div>
                <h2 class="text-2xl font-bold m-0 theme-text-main">Global Platform Preferences</h2>
                <p class="theme-text-muted mt-1">Manage core behavioral rules and branding.</p>
            </div>
            <div class="flex gap-3">
                <button type="button" onclick="window.location.reload()"
                    class="px-4 py-2 theme-bg-card theme-text-main border rounded-lg hover:opacity-80 transition-all shadow-sm">
                    Reset
                </button>
                <button type="button" id="btnPublish" onclick="confirmPublish()"
                    class="flex items-center px-5 py-2 text-sm font-medium text-white rounded-lg hover:opacity-90 transition-all shadow-md"
                    style="background-color: rgb(var(--brand-primary))">
                    <span id="btnText">Validate & Publish</span>
                </button>
            </div>
        </div>

        <form id="preferencesForm">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <div class="lg:col-span-2 space-y-6">

                    <div class="theme-card theme-bg-card rounded-xl shadow-sm overflow-hidden">
                        <div class="px-6 py-4 border-b theme-border">
                            <h5 class="text-lg font-bold flex items-center theme-text-main">Branding & Identity</h5>
                        </div>
                        <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium mb-2 theme-text-main">Platform Name</label>
                                <input type="text" name="platform_name" id="platform_name"
                                    class="w-full px-4 py-2 bg-transparent border theme-border rounded-lg focus:outline-none focus:ring-2 theme-text-main"
                                    style="--tw-ring-color: rgb(var(--brand-primary))" required>
                            </div>
                            <div>
                                <label class="block text-sm font-medium mb-2 theme-text-main">Company Legal Name</label>
                                <input type="text" name="legal_name" id="legal_name"
                                    class="w-full px-4 py-2 bg-transparent border theme-border rounded-lg focus:outline-none focus:ring-2 theme-text-main"
                                    style="--tw-ring-color: rgb(var(--brand-primary))" required>
                            </div>
                        </div>
                    </div>

                    <div class="theme-card theme-bg-card rounded-xl shadow-sm overflow-hidden">
                        <div class="px-6 py-4 border-b theme-border">
                            <h5 class="text-lg font-bold flex items-center theme-text-main">Regional & Currency</h5>
                        </div>
                        <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium mb-2 theme-text-main">Default Country</label>
                                <select name="country" id="country"
                                    class="w-full px-4 py-2 bg-transparent border theme-border rounded-lg focus:outline-none theme-text-main">
                                    <option value="" class="bg-slate-800">Select Country</option>
                                    <option value="PK" class="bg-slate-800">Pakistan</option>
                                    <option value="US" class="bg-slate-800">United States</option>
                                    <option value="UK" class="bg-slate-800">United Kingdom</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium mb-2 theme-text-main">Default Timezone</label>
                                <select name="timezone" id="timezone"
                                    class="w-full px-4 py-2 bg-transparent border theme-border rounded-lg focus:outline-none theme-text-main">
                                    <option value="" class="bg-slate-800">Select Timezone</option>
                                    <option value="Asia/Karachi" class="bg-slate-800">Asia/Karachi</option>
                                    <option value="UTC" class="bg-slate-800">UTC</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium mb-2 theme-text-main">Global Base Currency</label>
                                <select name="currency" id="currency"
                                    class="w-full px-4 py-2 bg-transparent border theme-border rounded-lg focus:outline-none theme-text-main">
                                    <option value="" class="bg-slate-800">Select Currency</option>
                                    <option value="PKR" class="bg-slate-800">PKR</option>
                                    <option value="USD" class="bg-slate-800">USD</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium mb-2 theme-text-main">Rounding Rules</label>
                                <select name="rounding_rules" id="rounding_rules"
                                    class="w-full px-4 py-2 bg-transparent border theme-border rounded-lg focus:outline-none theme-text-main">
                                    <option value="standard" class="bg-slate-800">Standard (Nearest)</option>
                                    <option value="up" class="bg-slate-800">Always Round Up</option>
                                    <option value="down" class="bg-slate-800">Always Round Down</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="theme-card theme-bg-card rounded-xl shadow-sm overflow-hidden">
                        <div class="px-6 py-4 border-b theme-border">
                            <h5 class="text-lg font-bold flex items-center theme-text-main">Support Contact Details</h5>
                        </div>
                        <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium mb-2 theme-text-main">Support Email</label>
                                <input type="email" name="support_email" id="support_email"
                                    class="w-full px-4 py-2 bg-transparent border theme-border rounded-lg focus:outline-none focus:ring-2 theme-text-main"
                                    style="--tw-ring-color: rgb(var(--brand-primary))" required>
                            </div>
                            <div>
                                <label class="block text-sm font-medium mb-2 theme-text-main">Support Phone</label>
                                <input type="text" name="support_phone" id="support_phone"
                                    class="w-full px-4 py-2 bg-transparent border theme-border rounded-lg focus:outline-none focus:ring-2 theme-text-main"
                                    style="--tw-ring-color: rgb(var(--brand-primary))">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="lg:col-span-1 space-y-6">

                    <div class="theme-card theme-bg-card rounded-xl shadow-sm overflow-hidden border-t-4"
                        style="border-top-color: rgb(var(--brand-secondary))">
                        <div class="px-6 py-4 border-b theme-border">
                            <h5 class="text-lg font-bold flex items-center theme-text-main">⚙️ Master Switches</h5>
                        </div>
                        <div class="p-6 space-y-4">
                            <label class="flex items-start cursor-pointer group">
                                <input type="checkbox" id="flag_onboarding" class="sr-only peer">
                                <div
                                    class="relative w-11 h-6 bg-gray-600 rounded-full peer peer-checked:after:translate-x-full after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-[rgb(var(--brand-primary))]">
                                </div>
                                <div class="ml-3 text-sm">
                                    <span class="font-bold block theme-text-main">Allow New User Onboarding</span>
                                    <span class="theme-text-muted">Disable to stop all new signups.</span>
                                </div>
                            </label>

                            <label class="flex items-start cursor-pointer group mt-4">
                                <input type="checkbox" id="flag_major_flows" class="sr-only peer">
                                <div
                                    class="relative w-11 h-6 bg-gray-600 rounded-full peer peer-checked:after:translate-x-full after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-[rgb(var(--brand-primary))]">
                                </div>
                                <div class="ml-3 text-sm">
                                    <span class="font-bold block theme-text-main">Enable Major Flows</span>
                                    <span class="theme-text-muted">Toggle core platform transactions.</span>
                                </div>
                            </label>
                        </div>
                    </div>

                    <div class="theme-card theme-bg-card rounded-xl shadow-sm overflow-hidden border-t-4"
                        style="border-top-color: rgb(var(--brand-primary))">
                        <div class="px-6 py-4 border-b theme-border">
                            <h5 class="text-lg font-bold theme-text-main">Publishing Configuration</h5>
                        </div>
                        <div class="p-6 space-y-4">
                            <div>
                                <label class="block text-sm font-bold theme-text-main mb-2">Rollout Mode</label>
                                <select id="rollout_mode"
                                    class="w-full px-4 py-2 bg-transparent border theme-border rounded-lg focus:outline-none theme-text-main">
                                    <option value="immediate" class="bg-slate-800">Immediate Rollout</option>
                                    <option value="scheduled" class="bg-slate-800">Scheduled Rollout</option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-sm font-bold theme-text-main mb-2">Reason for Change (Audit) <span
                                        class="text-red-500">*</span></label>
                                <textarea id="change_reason"
                                    class="w-full px-4 py-2 bg-transparent border theme-border rounded-lg focus:outline-none theme-text-main"
                                    rows="3" required></textarea>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </form>
    </div>

    <div id="validationModal" class="fixed inset-0 z-50 hidden" aria-labelledby="modal-title" role="dialog"
        aria-modal="true">
        <div class="fixed inset-0 bg-black/60 backdrop-blur-sm transition-opacity"></div>
        <div class="fixed inset-0 z-10 overflow-y-auto">
            <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">
                <div
                    class="relative transform overflow-hidden rounded-xl theme-bg-card text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-lg border theme-border">
                    <div class="px-6 py-4 border-b theme-border flex justify-between items-center bg-black/5">
                        <h3 class="text-lg font-bold theme-text-main flex items-center" id="modal-title">
                            <span class="mr-2 text-blue-500">🛡️</span> Config Impact Analysis
                        </h3>
                        <button type="button" onclick="closeModal()"
                            class="theme-text-muted hover:theme-text-main transition-colors text-xl">
                            &times;
                        </button>
                    </div>

                    <div class="p-6">
                        <div class="p-4 rounded-lg mb-6 flex items-start"
                            style="background-color: rgba(var(--brand-primary), 0.1); border-left: 4px solid rgb(var(--brand-primary))">
                            <div class="flex-shrink-0 mt-0.5">
                                <svg class="h-5 w-5" style="color: rgb(var(--brand-primary))" fill="currentColor"
                                    viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h4 class="text-sm font-bold theme-text-main">System-wide Change Validation</h4>
                                <p class="text-xs theme-text-muted mt-1 leading-relaxed">
                                    Ye changes publish karne se platform ki core configurations globally update ho jayengi.
                                    Caching refresh hogi aur users ko nayi branding/rules nazar aayenge.
                                </p>
                            </div>
                        </div>

                        <div class="space-y-3">
                            <p class="text-sm theme-text-main font-medium">Confirming this action will:</p>
                            <ul class="text-xs theme-text-muted space-y-2 list-disc pl-5">
                                <li>Update preferences via <span class="font-bold">Immediate/Scheduled</span> Rollout Mode.
                                </li>
                                <li>Sync platform-wide toggles internally.</li>
                                <li>Record an entry in the Platform Audit Log.</li>
                            </ul>
                        </div>
                    </div>

                    <div class="px-6 py-4 border-t theme-border flex justify-end gap-3 bg-black/5">
                        <button type="button" onclick="closeModal()"
                            class="px-4 py-2 text-sm font-medium theme-text-main hover:bg-black/10 rounded-lg transition-all">
                            Cancel
                        </button>
                        <button type="button" id="confirmBtn" onclick="submitChanges()"
                            class="flex items-center justify-center px-6 py-2 text-sm font-bold text-white rounded-lg shadow-lg hover:opacity-90 transition-all min-w-[140px]"
                            style="background-color: rgb(var(--brand-primary))">
                            Confirm & Apply
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        const API_BASE = "/api/admin/platform-preferences";

        function getHeaders() {
            const token = localStorage.getItem('token');
            const fingerprint = localStorage.getItem('device_fingerprint');
            return {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content,
                'X-Device-Fingerprint': fingerprint || '',
                'Authorization': token ? `Bearer ${token}` : ''
            };
        }

        document.addEventListener('DOMContentLoaded', async () => {
            await loadPreferences();
        });

        async function loadPreferences() {
            try {
                // 1. Fetch current settings
                const prefRes = await fetch(`${API_BASE}/current`, {
                    headers: getHeaders()
                });
                const response = await prefRes.json();

                // Ensure we work with the object structure provided by your controller
                const data = response.settings || response;

                if (data) {
                    // Fill Branding
                    document.getElementById('platform_name').value = data.branding?.platform_name || '';
                    document.getElementById('legal_name').value = data.branding?.legal_name || '';

                    // Fill Support
                    document.getElementById('support_email').value = data.support?.email || '';
                    document.getElementById('support_phone').value = data.support?.phone || '';

                    // Fill Regional (Dropdowns)
                    document.getElementById('timezone').value = data.regional?.timezone || '';
                    document.getElementById('currency').value = data.regional?.currency || '';
                    document.getElementById('rounding_rules').value = data.regional?.rounding_rules || 'standard';

                    // Fill Master Switches
                    document.getElementById('flag_onboarding').checked = data.toggles?.allow_onboarding ?? false;
                    document.getElementById('flag_major_flows').checked = data.toggles?.enable_major_flows ?? false;

                    if (data.rollout_mode) {
                        document.getElementById('rollout_mode').value = data.rollout_mode;
                    }
                    // 2. Load Countries API and set value after options are populated
                    await fetchCountries(data.regional?.country);
                }
            } catch (error) {
                console.error("Error loading preferences:", error);
            }
        }

        async function submitChanges() {
            const btn = document.getElementById('confirmBtn');
            const originalContent = btn.innerHTML;
            setLoading(btn, true);

            try {
                // Building payload exactly as the Controller expects
                const payload = {
                    rollout_mode: document.getElementById('rollout_mode').value,
                    settings: {
                        branding: {
                            platform_name: document.getElementById('platform_name').value,
                            legal_name: document.getElementById('legal_name').value,
                        },
                        regional: {
                            country: document.getElementById('country').value,
                            timezone: document.getElementById('timezone').value,
                            currency: document.getElementById('currency').value,
                            rounding_rules: document.getElementById('rounding_rules').value
                        },
                        support: {
                            email: document.getElementById('support_email').value,
                            phone: document.getElementById('support_phone').value
                        },
                        toggles: {
                            allow_onboarding: document.getElementById('flag_onboarding').checked,
                            enable_major_flows: document.getElementById('flag_major_flows').checked
                        },
                        audit: {
                            reason: document.getElementById('change_reason').value
                        },
                         
                    },

                };

                const response = await fetch(`${API_BASE}/update`, {
                    method: 'POST',
                    headers: getHeaders(),
                    body: JSON.stringify(payload)
                });

                if (response.ok) {
                    const resData = await response.json();
                    alert(resData.message || 'Platform preferences updated successfully!');
                    closeModal();
                    window.location.reload();
                } else {
                    const errorData = await response.json();
                    alert('Validation Error: ' + (errorData.message || 'Check your inputs.'));
                }
            } catch (error) {
                alert('Error syncing data: ' + error.message);
            } finally {
                setLoading(btn, false, originalContent);
            }
        }

        function setLoading(btn, isLoading, content = "") {
            if (isLoading) {
                btn.innerHTML =
                    `<svg class="animate-spin h-4 w-4 mr-2 border-2 border-white border-t-transparent rounded-full" viewBox="0 0 24 24"></svg> Processing...`;
                btn.disabled = true;
            } else {
                btn.innerHTML = content;
                btn.disabled = false;
            }
        }

        async function fetchCountries(selectedCode = null) {
            const countrySelect = document.getElementById('country');
            const COUNTRIES_API = "http://127.0.0.1:8000/api/countries";

            try {
                const response = await fetch(COUNTRIES_API, {
                    method: 'GET',
                    headers: getHeaders()
                });
                const result = await response.json();
                const countries = Array.isArray(result) ? result : result.data;

                if (countries) {
                    countrySelect.innerHTML = '<option value="">Select Country</option>';
                    countries.forEach(country => {
                        const option = document.createElement('option');
                        option.value = country.code || country.id;
                        option.textContent = country.name;
                        option.className = "bg-slate-800";

                        // If this is the saved country, select it
                        if (option.value === selectedCode) {
                            option.selected = true;
                        }
                        countrySelect.appendChild(option);
                    });
                }
            } catch (error) {
                console.error("Error fetching countries:", error);
            }
        }

        function closeModal() {
            document.getElementById('validationModal').classList.add('hidden');
        }

        function confirmPublish() {
            if (document.getElementById('preferencesForm').checkValidity()) {
                document.getElementById('validationModal').classList.remove('hidden');
            } else {
                document.getElementById('preferencesForm').reportValidity();
            }
        }
    </script>
@endpush
