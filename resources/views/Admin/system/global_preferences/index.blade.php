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
        // --- API & Auth Setup ---
        function getApiHeaders() {
            const token = localStorage.getItem('token');
            return {
                'Accept': 'application/json',
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '',
                'Authorization': token ? `Bearer ${token}` : ''
            };
        }

        // --- Custom Toast Notification ---
        function showToast(message, isError = false) {
            // Creating toaster dynamically if it doesn't exist
            let toast = document.getElementById('systemToast');
            if (!toast) {
                toast = document.createElement('div');
                toast.id = 'systemToast';
                toast.className =
                    'fixed top-5 right-5 px-6 py-3 rounded shadow-lg transform transition-transform translate-x-[150%] z-[100] flex items-center text-white font-medium';
                document.body.appendChild(toast);
            }

            toast.innerText = message;
            toast.style.backgroundColor = isError ? '#ef4444' : '#10b981'; // Red for error, Green for success

            // Slide in
            setTimeout(() => toast.style.transform = "translateX(0)", 10);

            // Slide out after 3 seconds
            setTimeout(() => {
                toast.style.transform = "translateX(150%)";
            }, 3000);
        }

        // --- Modal Controls ---
        function confirmPublish() {
            // Form validation before opening modal
            const form = document.getElementById('preferencesForm');
            if (!form.checkValidity()) {
                form.reportValidity();
                return;
            }
            document.getElementById('validationModal').classList.remove('hidden');
        }

        function closeModal() {
            document.getElementById('validationModal').classList.add('hidden');
        }

        // --- Submit Data Logic ---
        async function submitChanges() {
            const btn = document.getElementById('confirmBtn');
            const originalText = btn.innerText;
            btn.innerText = 'Saving...';
            btn.disabled = true;

            // 1. Collect Data from the form
            const settingsPayload = {
                platform_name: document.getElementById('platform_name').value,
                legal_name: document.getElementById('legal_name').value,
                country: document.getElementById('country').value,
                timezone: document.getElementById('timezone').value,
                currency: document.getElementById('currency').value,
                rounding_rules: document.getElementById('rounding_rules').value,
                support_email: document.getElementById('support_email').value,
                support_phone: document.getElementById('support_phone').value,
                flag_onboarding: document.getElementById('flag_onboarding').checked,
                flag_major_flows: document.getElementById('flag_major_flows').checked,
                change_reason: document.getElementById('change_reason').value,
            };

            const rolloutMode = document.getElementById('rollout_mode').value;

            // 2. Prepare Final Request Body
            const requestBody = {
                settings: settingsPayload,
                rollout_mode: rolloutMode
            };

            try {
                // Update the URL to point to your PlatformPreferenceController route
                const res = await fetch('/api/admin/platform-preferences/update', {
                    method: 'POST', // or POST depending on your api.php routes
                    headers: getApiHeaders(),
                    body: JSON.stringify(requestBody)
                });

                const result = await res.json();

                if (res.ok) {
                    showToast('Platform preferences updated successfully!');
                    closeModal();
                    document.getElementById('change_reason').value = ''; // Reset audit field
                } else {
                    // Handle Validation Errors from Laravel
                    const errorMsg = result.errors ? Object.values(result.errors).flat().join(' | ') : (result
                        .message || 'Error saving preferences');
                    showToast(`Validation Error: ${errorMsg}`, true);
                    closeModal();
                }
            } catch (error) {
                console.error(error);
                showToast('Network error occurred while saving.', true);
            } finally {
                btn.innerText = originalText;
                btn.disabled = false;
            }
        }

        // --- Optional: Fetch existing settings on page load ---
        document.addEventListener('DOMContentLoaded', async () => {
            try {
                const res = await fetch('/api/admin/platform-preferences/current', {
                    headers: getApiHeaders()
                });
                if (res.ok) {
                    const data = await res.json();
                    // Logic to populate the form inputs with data.data if it exists
                    // document.getElementById('platform_name').value = data.data.platform_name || '';
                    // ... populate other fields similarly
                }
            } catch (error) {
                console.log('No existing preferences found or network issue.');
            }
        });

        // --- Fetch and Populate Existing Settings on Page Load ---
    document.addEventListener('DOMContentLoaded', async () => {
        try {
            // Update this URL if your route is different in api.php
            const res = await fetch('/api/admin/platform-preferences/current', { 
                headers: getApiHeaders() 
            });
            
            if (res.ok) {
                const responseData = await res.json();
                
                // Laravel typically wraps responses in a 'data' object when using standard API resources
                // Adjust this if your BaseApiController's success() method structures it differently
                const settings = responseData.data || responseData;

                if (settings && Object.keys(settings).length > 0) {
                    // Populate Text & Select Inputs
                    if (settings.platform_name) document.getElementById('platform_name').value = settings.platform_name;
                    if (settings.legal_name) document.getElementById('legal_name').value = settings.legal_name;
                    if (settings.country) document.getElementById('country').value = settings.country;
                    if (settings.timezone) document.getElementById('timezone').value = settings.timezone;
                    if (settings.currency) document.getElementById('currency').value = settings.currency;
                    if (settings.rounding_rules) document.getElementById('rounding_rules').value = settings.rounding_rules;
                    if (settings.support_email) document.getElementById('support_email').value = settings.support_email;
                    if (settings.support_phone) document.getElementById('support_phone').value = settings.support_phone;

                    // Populate Master Switches (Checkboxes)
                    // Boolean check ensures it properly ticks or unticks the toggle
                    if (settings.flag_onboarding !== undefined) {
                        document.getElementById('flag_onboarding').checked = settings.flag_onboarding === true || settings.flag_onboarding === 'true' || settings.flag_onboarding === 1;
                    }
                    if (settings.flag_major_flows !== undefined) {
                        document.getElementById('flag_major_flows').checked = settings.flag_major_flows === true || settings.flag_major_flows === 'true' || settings.flag_major_flows === 1;
                    }
                }
            } else {
                console.warn('No existing preferences found or API returned an error.');
            }
        } catch (error) {
            console.error('Error fetching current preferences:', error);
            // Using your custom modern toaster instead of alerts
            showToast('Could not load existing settings. Network error.', true);
        }
    });
    </script>
@endpush
