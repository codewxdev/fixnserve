@extends('layouts.app')

@section('title', 'Device Security')

@section('content')
    <div class="min-h-screen theme-bg-body theme-text-main max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
            <div>
                <h1 class="text-2xl font-bold theme-text-main">Device Trust & Fingerprinting</h1>
                <p class="theme-text-muted mt-1">Manage recognized devices and enforce hardware-level security policies.</p>
            </div>
            {{-- <div class="flex gap-3">
                <button onclick="exportDeviceLog()"
                    class="flex items-center gap-2 px-4 py-2 theme-bg-card border theme-border rounded-lg text-sm font-medium hover:bg-white/5 theme-text-main transition-colors shadow-sm">
                    <i data-lucide="download" class="w-4 h-4"></i>
                    <span>Export Device Log</span>
                </button>
            </div> --}}
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
            {{-- TRUST POLICIES CARD --}}
            <div class="lg:col-span-2 theme-bg-card rounded-xl shadow-sm border theme-border overflow-hidden">
                <div class="px-6 py-4 border-b theme-border flex justify-between items-center"
                    style="background-color: rgba(var(--bg-body), 0.5);">
                    <h3 class="font-semibold theme-text-main flex items-center gap-2">
                        <i data-lucide="shield-check" class="w-4 h-4" style="color: rgb(var(--brand-primary));"></i> Trust
                        Policies
                    </h3>
                    <span
                        class="text-xs font-medium text-green-500 bg-green-500/10 border border-green-500/20 px-2 py-1 rounded">ENFORCED</span>
                </div>
                <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6" id="policy-form">
                    <div>
                        <label class="block text-sm font-medium theme-text-muted mb-2">Max Trusted Devices per User</label>
                        <select id="max-devices"
                            class="w-full theme-bg-body border theme-border rounded-lg text-sm theme-text-main focus:ring-2 focus:ring-blue-500 p-2.5">
                            <option value="1">1 (Strict)</option>
                            <option value="3">3 (Standard)</option>
                            <option value="5">5 (Relaxed)</option>
                            <option value="99">Unlimited</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium theme-text-muted mb-2">Trust Expiration</label>
                        <div class="relative">
                            <input type="number" id="trust-expiry"
                                class="w-full pl-3 pr-12 py-2 theme-bg-body border theme-border rounded-lg text-sm theme-text-main focus:ring-2 focus:ring-blue-500">
                            <span class="absolute right-3 top-2 theme-text-muted text-sm">days</span>
                        </div>
                    </div>

                    <div class="md:col-span-2 space-y-3 pt-4 border-t theme-border">
                        <label class="flex items-center justify-between cursor-pointer">
                            <span class="text-sm font-medium theme-text-main">Block Rooted / Jailbroken Devices</span>
                            <div class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" id="block-rooted" class="sr-only peer toggle-checkbox">
                                <div
                                    class="toggle-bg w-11 h-6 bg-gray-600/30 rounded-full peer peer-checked:after:translate-x-full after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all">
                                </div>
                            </div>
                        </label>
                        <label class="flex items-center justify-between cursor-pointer">
                            <span class="text-sm font-medium theme-text-main">Require Email OTP for New Unknown
                                Devices</span>
                            <div class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" id="require-otp" class="sr-only peer toggle-checkbox">
                                <div
                                    class="toggle-bg w-11 h-6 bg-gray-600/30 rounded-full peer peer-checked:after:translate-x-full after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all">
                                </div>
                            </div>
                        </label>
                    </div>
                    <div class="md:col-span-2 text-right pt-2">
                        <button onclick="updateDevicePolicy()" id="btn-save-policy"
                            class="px-4 py-2 bg-blue-600 text-white rounded-lg text-sm font-bold hover:bg-blue-700 transition shadow-lg">
                            SAVE POLICIES
                        </button>
                    </div>
                </div>
            </div>

            {{-- DEVICE INSIGHTS CARD --}}
            <div class="rounded-xl shadow-lg p-6 text-white flex flex-col justify-between border theme-border"
                style="background: linear-gradient(135deg, rgb(var(--brand-primary)), rgb(var(--brand-secondary)));">
                <div>
                    <h3 class="text-lg font-semibold flex items-center gap-2 mb-4">
                        <i data-lucide="smartphone" class="w-5 h-5 text-white/80"></i> Device Insights
                    </h3>
                    <div class="space-y-4">
                        <div class="flex justify-between items-center border-b border-white/20 pb-2">
                            <span class="text-white/70 text-sm">Total Recognized</span>
                            <span id="total-count" class="text-xl font-bold">...</span>
                        </div>
                        <div class="flex justify-between items-center border-b border-white/20 pb-2">
                            <span class="text-white/70 text-sm">Untrusted / New</span>
                            <span id="untrusted-count" class="text-xl font-bold text-yellow-300">...</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-white/70 text-sm">Banned Fingerprints</span>
                            <span id="banned-count" class="text-xl font-bold text-red-300">...</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- DEVICE INVENTORY TABLE --}}
        <div class="theme-bg-card rounded-xl shadow-sm border theme-border overflow-hidden">
            <div class="p-4 border-b theme-border flex flex-col md:flex-row justify-between items-center gap-4">
                <h3 class="font-semibold theme-text-main">Device Inventory</h3>
                <div class="relative w-full max-w-md">
                    <i data-lucide="search" class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 theme-text-muted"></i>
                    <input type="text" id="device-search" oninput="applyDeviceFilters()"
                        placeholder="Search by User, Fingerprint, or IP..."
                        class="pl-10 w-full theme-bg-body border theme-border rounded-lg text-sm theme-text-main focus:ring-2 focus:ring-blue-500">
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead class="theme-text-muted font-semibold uppercase text-xs"
                        style="background-color: rgba(var(--bg-body), 0.5);">
                        <tr>
                            <th class="px-6 py-3">Device / Fingerprint</th>
                            <th class="px-6 py-3">User</th>
                            <th class="px-6 py-3">Trust Status</th>
                            <th class="px-6 py-3">Last Seen / IP</th>
                            <th class="px-6 py-3 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="device-table-body" class="divide-y theme-border"
                        style="border-color: rgb(var(--border-color));">
                        {{-- Data will be injected here --}}
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://unpkg.com/lucide@latest"></script>
    <script>
        let allDevices = [];

        document.addEventListener("DOMContentLoaded", () => {
            lucide.createIcons();
            fetchDevicePolicies();
            fetchDeviceInsights();
            fetchDevices();
        });

        // --- API Helper ---
        async function apiRequest(endpoint, method = 'GET', body = null) {
            const token = localStorage.getItem('token');
            const fingerprint = localStorage.getItem('device_fingerprint') || 'unknown';

            const options = {
                method: method,
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'Authorization': `Bearer ${token}`,
                    'X-Device-Fingerprint': fingerprint
                }
            };
            if (body) options.body = JSON.stringify(body);

            try {
                const response = await fetch(endpoint, options);
                const result = await response.json();
                if (!response.ok) throw result; // Throw the whole result to catch validation errors
                return result;
            } catch (error) {
                console.error('API Error:', error);
                if (error.errors) {
                    // Display validation errors clearly
                    const msg = Object.values(error.errors).flat().join('\n');
                    alert("Validation Error:\n" + msg);
                } else {
                    alert(error.message || 'Something went wrong');
                }
                return null;
            }
        }

        // --- 1. Fetch & Update Policies (Synced with Controller validate) ---
        async function fetchDevicePolicies() {
            const res = await apiRequest('/api/devices/policies');
            if (res) {
                // Note: Controller returns the model directly or via JSON
                document.getElementById('max-devices').value = res.max_trusted_devices || 3;
                document.getElementById('trust-expiry').value = res.trust_expiration_days || 30;
                document.getElementById('require-otp').checked = !!res.require_otp_new_device;
                document.getElementById('block-rooted').checked = !!res.block_rooted_devices;
            }
        }

        async function updateDevicePolicy() {
            const btn = document.getElementById('btn-save-policy');
            btn.innerText = 'SAVING...';

            const payload = {
                max_trusted_devices: parseInt(document.getElementById('max-devices').value),
                trust_expiration_days: parseInt(document.getElementById('trust-expiry').value),
                require_otp_new_device: document.getElementById('require-otp').checked ? 1 : 0,
                block_rooted_devices: document.getElementById('block-rooted').checked ? 1 : 0
            };

            const res = await apiRequest('/api/devices/policy', 'POST', payload);
            if (res) alert('Device policy saved successfully!');
            btn.innerText = 'SAVE POLICIES';
        }

        // --- 2. Insights (Synced with Controller insights method) ---
        async function fetchDeviceInsights() {
            const res = await apiRequest('/api/devices/insights');
            if (res) {
                document.getElementById('total-count').innerText = res.total_recognized || 0;
                document.getElementById('untrusted-count').innerText = res.untrusted || 0;
                document.getElementById('banned-count').innerText = res.banned || 0;
            }
        }

        // --- 3. Device Inventory (Handles Pagination) ---
        async function fetchDevices(page = 1) {
            const res = await apiRequest(`/api/devices?page=${page}`);
            if (res && res.data) {
                allDevices = res.data; // Laravel pagination puts rows in 'data'
                renderDevices(allDevices);
                // Optional: Handle pagination links here if needed
            }
        }

        function renderDevices(devices) {
            const container = document.getElementById('device-table-body');
            container.innerHTML = '';

            devices.forEach(device => {
                const row = `
                <tr class="hover:bg-white/5 transition-colors">
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded theme-bg-body flex items-center justify-center theme-text-muted border theme-border">
                                <i data-lucide="${device.is_mobile ? 'smartphone' : 'laptop'}" class="w-5 h-5"></i>
                            </div>
                            <div>
                                <div class="font-medium theme-text-main">${device.device_name || 'Device'}</div>
                                <div class="text-[10px] font-mono theme-text-muted uppercase">FP: ${device.fingerprint ? device.fingerprint.substring(0,10) : '---'}...</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="font-medium theme-text-main">${device.user ? device.user.name : 'Unknown'}</div>
                        <div class="text-xs theme-text-muted">${device.user ? device.user.email : ''}</div>
                    </td>
                    <td class="px-6 py-4">${getStatusBadge(device.trust_status)}</td>
                    <td class="px-6 py-4">
                        <div class="theme-text-main">${device.updated_at}</div>
                        <div class="text-xs theme-text-muted font-mono">${device.last_ip || '0.0.0.0'}</div>
                    </td>
                    <td class="px-6 py-4 text-right">
                        <div class="flex justify-end gap-2">${getActionButtons(device)}</div>
                    </td>
                </tr>`;
                container.insertAdjacentHTML('beforeend', row);
            });
            lucide.createIcons();
        }

        // --- Helpers ---
        function getStatusBadge(status) {
            if (status === 'trusted')
                return `<span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-500/10 text-green-500 border border-green-500/20"><i data-lucide="check-circle" class="w-3 h-3"></i> Trusted</span>`;
            if (status === 'banned')
                return `<span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-500/10 text-red-500 border border-red-500/20"><i data-lucide="ban" class="w-3 h-3"></i> Banned</span>`;
            return `<span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-500/10 text-yellow-500 border border-yellow-500/20"><i data-lucide="help-circle" class="w-3 h-3"></i> Unverified</span>`;
        }

        function getActionButtons(device) {
            if (device.trust_status === 'banned')
                return `<button onclick="handleAction(${device.id}, 'unban')" class="text-xs font-bold text-blue-500 hover:underline">UNBAN</button>`;

            let actions =
                `<button onclick="handleAction(${device.id}, 'ban')" class="text-xs font-bold text-red-500 hover:underline">BAN</button>`;
            if (device.trust_status === 'unverified') {
                actions =
                    `<button onclick="handleAction(${device.id}, 'trust')" class="text-xs font-bold text-blue-500 hover:underline">TRUST</button> ` +
                    actions;
            } else if (device.trust_status === 'trusted') {
                actions =
                    `<button onclick="handleAction(${device.id}, 'revoke')" class="text-xs font-bold text-orange-500 hover:underline">REVOKE</button> ` +
                    actions;
            }
            return actions;
        }

        async function handleAction(id, action) {
            if (!confirm(`Are you sure you want to ${action} this device?`)) return;
            const res = await apiRequest(`/api/devices/${id}/${action}`, 'POST');
            if (res) {
                fetchDevices();
                fetchDeviceInsights();
            }
        }

        // --- 4. Filter System Implementation ---
        function applyDeviceFilters() {
            const query = document.getElementById('device-search').value.toLowerCase().trim();

            // If search is empty, show all loaded devices
            if (!query) {
                renderDevices(allDevices);
                return;
            }

            const filteredResults = allDevices.filter(device => {
                const deviceName = (device.device_name || '').toLowerCase();
                const fingerprint = (device.fingerprint || '').toLowerCase();
                const userName = (device.user?.name || '').toLowerCase();
                const userEmail = (device.user?.email || '').toLowerCase();
                const ipAddress = (device.last_ip || '').toLowerCase();

                return deviceName.includes(query) ||
                    fingerprint.includes(query) ||
                    userName.includes(query) ||
                    userEmail.includes(query) ||
                    ipAddress.includes(query);
            });

            renderDevices(filteredResults);
        }

        // --- 5. Export System Implementation ---
        function exportDeviceLog() {
            if (allDevices.length === 0) {
                alert("No device data available to export.");
                return;
            }

            // Define CSV Headers
            const headers = ["Device Name", "Fingerprint", "User Name", "User Email", "Status", "IP Address", "Last Seen"];

            // Map data to rows
            const rows = allDevices.map(device => [
                `"${device.device_name || 'Unknown'}"`,
                `"${device.fingerprint || 'N/A'}"`,
                `"${device.user?.name || 'Unknown'}"`,
                `"${device.user?.email || 'N/A'}"`,
                `"${device.trust_status}"`,
                `"${device.last_ip || '0.0.0.0'}"`,
                `"${device.updated_at}"`
            ]);

            // Combine headers and rows
            const csvContent = [headers, ...rows].map(e => e.join(",")).join("\n");

            // Create a Blob and trigger download
            const blob = new Blob([csvContent], {
                type: 'text/csv;charset=utf-8;'
            });
            const url = URL.createObjectURL(blob);
            const link = document.createElement("a");

            const timestamp = new Date().toISOString().split('T')[0];
            link.setAttribute("href", url);
            link.setAttribute("download", `device_log_${timestamp}.csv`);
            link.style.visibility = 'hidden';

            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        }
    </script>
@endpush
