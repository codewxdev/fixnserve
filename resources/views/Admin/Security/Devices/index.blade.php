@extends('Layouts.app')

@section('title', 'Device Security & Trust')

@section('content')
    <!-- MAIN WRAPPER START (x-data starts here) -->
    <div class="p-4 sm:p-6 lg:p-8 bg-bg-primary min-h-screen flex flex-col" x-data="deviceTrust()">

        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 sm:mb-8 gap-4 shrink-0">
            <div>
                <h1 class="text-h3 sm:text-h2 font-bold tracking-tight text-text-primary flex items-center gap-3">
                    <span class="p-2 bg-brand-primary/10 rounded-lg text-brand-primary border border-brand-primary/20">
                        <i data-lucide="smartphone" class="w-5 h-5 sm:w-6 sm:h-6"></i>
                    </span>
                    Device Trust & Fingerprinting
                </h1>
                <p class="text-text-secondary text-body-sm mt-2">Manage recognized devices, hardware-level policies, and
                    spoofing detection.</p>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">

            <div class="lg:col-span-2 card p-0 overflow-hidden flex flex-col h-full">
                <div class="px-5 py-4 border-b border-border-default bg-bg-tertiary flex justify-between items-center">
                    <h3 class="text-body font-bold text-text-primary flex items-center gap-2">
                        <i data-lucide="shield-check" class="w-4 h-4 text-brand-primary"></i> Trust Policies
                    </h3>
                    <span
                        class="px-2 py-0.5 bg-semantic-success-bg text-semantic-success border border-semantic-success/20 text-[10px] font-bold rounded uppercase tracking-wider">Enforced</span>
                </div>

                <div class="p-5 grid grid-cols-1 sm:grid-cols-2 gap-5 flex-1">
                    <div class="form-group mb-0">
                        <label class="form-label">Max Trusted Devices / User</label>
                        <select x-model="policy.maxDevices" class="form-input w-full">
                            <option value="1">1 (Strict)</option>
                            <option value="3">3 (Standard)</option>
                            <option value="5">5 (Relaxed - Default)</option>
                            <option value="99">Unlimited</option>
                        </select>
                    </div>

                    <div class="form-group mb-0">
                        <label class="form-label">Auto-Expire Trust</label>
                        <div class="relative">
                            <input type="number" x-model="policy.expiryDays" class="form-input w-full pl-3 pr-12">
                            <span class="absolute right-3 top-2 text-text-tertiary text-body-sm">days</span>
                        </div>
                    </div>

                    <div class="sm:col-span-2 space-y-3 pt-3 border-t border-border-default">
                        <label class="flex items-center gap-3 cursor-pointer group">
                            <input type="checkbox" x-model="policy.blockRooted"
                                class="w-4 h-4 rounded border-border-strong text-brand-primary focus:ring-brand-primary/20 bg-bg-primary transition-colors">
                            <div>
                                <span
                                    class="block text-body-sm font-bold text-text-primary group-hover:text-brand-primary transition-colors">Block
                                    Rooted / Jailbroken Devices</span>
                                <span class="block text-[10px] text-text-secondary mt-0.5">Deny authentication if OS
                                    tampering is detected.</span>
                            </div>
                        </label>

                        <label class="flex items-center gap-3 cursor-pointer group">
                            <input type="checkbox" x-model="policy.requireOtpNew"
                                class="w-4 h-4 rounded border-border-strong text-brand-primary focus:ring-brand-primary/20 bg-bg-primary transition-colors">
                            <div>
                                <span
                                    class="block text-body-sm font-bold text-text-primary group-hover:text-brand-primary transition-colors">Require
                                    Verification on New Device</span>
                                <span class="block text-[10px] text-text-secondary mt-0.5">Force Email/SMS OTP when an
                                    unknown fingerprint logs in.</span>
                            </div>
                        </label>
                    </div>
                </div>

                <div class="p-4 border-t border-border-default bg-bg-tertiary flex justify-end">
                    <button @click="savePolicy()"
                        class="btn btn-primary btn-sm flex items-center justify-center gap-2 min-w-[120px]"
                        :disabled="isSaving">
                        <i data-lucide="save" class="w-4 h-4" x-show="!isSaving"></i>
                        <i data-lucide="loader-2" class="w-4 h-4 animate-spin" x-show="isSaving" x-cloak></i>
                        <span x-text="isSaving ? 'Saving...' : 'Save Policies'"></span>
                    </button>
                </div>
            </div>

            <div class="card p-0 overflow-hidden flex flex-col h-full border-brand-primary/30">
                <div class="px-5 py-4 border-b border-border-default bg-brand-primary/5">
                    <h3 class="text-body font-bold text-brand-primary flex items-center gap-2">
                        <i data-lucide="cpu" class="w-4 h-4"></i> AI Fleet Insights
                    </h3>
                </div>
                <div class="p-5 flex-1 flex flex-col justify-center space-y-4">
                    <div class="flex justify-between items-end border-b border-border-default pb-3">
                        <div>
                            <span class="block text-[10px] uppercase font-bold text-text-tertiary tracking-wider mb-1">Total
                                Recognized</span>
                            <span class="text-h3 font-bold text-text-primary" x-text="insights.total"></span>
                        </div>
                        <i data-lucide="check-circle-2" class="w-5 h-5 text-semantic-success mb-1"></i>
                    </div>

                    <div class="flex justify-between items-end border-b border-border-default pb-3">
                        <div>
                            <span
                                class="block text-[10px] uppercase font-bold text-text-tertiary tracking-wider mb-1">Pending
                                Verification</span>
                            <span class="text-h3 font-bold text-semantic" x-text="insights.untrusted"></span>
                        </div>
                        <i data-lucide="help-circle" class="w-5 h-5 text-semantic-primary mb-1"></i>
                    </div>

                    <div class="flex justify-between items-end">
                        <div>
                            <span
                                class="block text-[10px] uppercase font-bold text-text-tertiary tracking-wider mb-1">Spoofed
                                / Banned</span>
                            <span class="text-h3 font-bold text-semantic-error" x-text="insights.banned"></span>
                        </div>
                        <i data-lucide="ban" class="w-5 h-5 text-semantic-error mb-1"></i>
                    </div>
                </div>
            </div>

        </div>

        <div class="card p-0 overflow-hidden flex-1 flex flex-col min-h-[500px]">

            <div
                class="p-4 border-b border-border-default bg-bg-tertiary flex flex-col sm:flex-row justify-between items-center gap-4">
                <h3 class="font-bold text-text-primary">Device Fingerprint Registry</h3>
                <div class="relative w-full sm:max-w-md">
                    <i data-lucide="search" class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-text-tertiary"></i>
                    <input type="text" x-model="searchQuery" placeholder="Search by Hash, User, or IP..."
                        class="form-input w-full pl-9 h-9 text-body-sm">
                </div>
            </div>

            <div class="overflow-x-auto custom-scrollbar flex-1">
                <table class="w-full text-left min-w-[900px]">
                    <thead
                        class="text-caption uppercase text-text-secondary font-semibold bg-bg-primary border-b border-border-strong sticky top-0">
                        <tr>
                            <th class="px-5 py-3 whitespace-nowrap">Hardware & OS Context</th>
                            <th class="px-5 py-3 whitespace-nowrap">Bound Identity</th>
                            <th class="px-5 py-3 whitespace-nowrap">Trust Status</th>
                            <th class="px-5 py-3 whitespace-nowrap">Network & Time</th>
                            <th class="px-5 py-3 whitespace-nowrap text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-border-default bg-bg-secondary">

                        <tr x-show="isLoading">
                            <td colspan="5" class="px-6 py-12 text-center text-text-tertiary">
                                <i data-lucide="loader-2" class="w-8 h-8 animate-spin mx-auto mb-2 opacity-50"></i>
                                <p class="text-body-sm">Fetching device telemetry...</p>
                            </td>
                        </tr>

                        <tr x-show="!isLoading && filteredDevices.length === 0" x-cloak>
                            <td colspan="5" class="px-6 py-12 text-center text-text-tertiary">
                                <i data-lucide="smartphone" class="w-8 h-8 mx-auto mb-2 opacity-50"></i>
                                <p class="text-body-sm">No devices match your search.</p>
                            </td>
                        </tr>

                        <template x-for="device in filteredDevices" :key="device.id">
                            <tr class="hover:bg-bg-tertiary transition-colors group">

                                <td class="px-5 py-4">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="w-10 h-10 rounded border border-border-default bg-bg-primary flex items-center justify-center text-text-secondary shrink-0">
                                            <i :data-lucide="device.is_mobile ? 'smartphone' : 'laptop'"
                                                class="w-5 h-5"></i>
                                        </div>
                                        <div class="min-w-0">
                                            <div class="font-bold text-text-primary text-body-sm truncate"
                                                x-text="device.os_name"></div>
                                            <div class="text-[10px] font-mono text-text-tertiary mt-1 truncate"
                                                title="Hardware Signature Hash" x-text="device.fingerprint"></div>
                                        </div>
                                    </div>
                                </td>

                                <td class="px-5 py-4">
                                    <div class="font-bold text-text-primary text-body-sm truncate"
                                        x-text="device.user.name"></div>
                                    <div class="text-caption text-text-secondary mt-0.5 truncate"
                                        x-text="device.user.email"></div>
                                </td>

                                <td class="px-5 py-4">
                                    <div class="flex flex-col items-start gap-1.5">
                                        <span x-show="device.status === 'trusted'"
                                            class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded text-[10px] font-bold bg-semantic-success-bg text-semantic-success border border-semantic-success/20 uppercase tracking-wider">
                                            <i data-lucide="shield-check" class="w-3 h-3"></i> Trusted
                                        </span>
                                        <span x-show="device.status === 'unverified'"
                                            class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded text-[10px] font-bold bg-semantic-warning-bg text-semantic-warning border border-semantic-warning/20 uppercase tracking-wider">
                                            <i data-lucide="shield-alert" class="w-3 h-3"></i> Unverified
                                        </span>
                                        <span x-show="device.status === 'banned'"
                                            class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded text-[10px] font-bold bg-semantic-error-bg text-semantic-error border border-semantic-error/20 uppercase tracking-wider">
                                            <i data-lucide="ban" class="w-3 h-3"></i> Banned
                                        </span>

                                        <span x-show="device.ai_spoof_risk > 70"
                                            class="text-[9px] text-semantic-error font-bold flex items-center gap-1"
                                            title="High similarity to known banned device">
                                            <i data-lucide="alert-triangle" class="w-2.5 h-2.5"></i> Clone Risk Detected
                                        </span>
                                    </div>
                                </td>

                                <td class="px-5 py-4">
                                    <div class="text-body-sm text-text-primary mb-0.5" x-text="device.last_seen"></div>
                                    <div class="flex items-center gap-2 text-[10px] text-text-secondary font-mono">
                                        <span x-text="device.ip"></span>
                                    </div>
                                </td>

                                <td class="px-5 py-4 text-right">
                                    <button @click="viewContext(device)" title="View Full Footprint"
                                        class="inline-flex items-center justify-center rounded-lg border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-900 text-slate-700 dark:text-slate-200 hover:bg-slate-100 dark:hover:bg-slate-800 hover:text-slate-900 dark:hover:text-white transition-all duration-200 shadow-sm hover:shadow-md px-2.5 py-2 mr-1">
                                        <i data-lucide="fingerprint" class="w-4 h-4"></i>
                                    </button>

                                    <button x-show="device.status === 'unverified'"
                                        @click="handleAction(device.id, 'trust')"
                                        class="btn btn-sm bg-transparent text-brand-primary border-brand-primary/30 hover:bg-brand-primary hover:text-white transition-colors duration-200 text-xs">Trust</button>

                                    <button x-show="device.status === 'trusted'"
                                        @click="handleAction(device.id, 'revoke')"
                                        class="btn btn-sm bg-transparent text-brand-primary border-brand-primary/30 hover:bg-brand-primary hover:text-white transition-colors duration-200 text-xs">Revoke</button>

                                    <button x-show="device.status !== 'banned'" @click="handleAction(device.id, 'ban')"
                                        class="btn btn-sm btn-destructive text-xs">Ban</button>

                                    <button x-show="device.status === 'banned'" @click="handleAction(device.id, 'unban')"
                                        class="btn btn-sm btn-secondary text-text-primary text-xs">Unban</button>
                                </td>
                            </tr>
                        </template>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- FINGERPRINT MODAL -->
        <div x-show="modals.context"
            class="fixed inset-0 z-50 flex items-center justify-center bg-brand-secondary/80 backdrop-blur-sm p-4" x-cloak>
            <div class="card w-full max-w-2xl p-0 shadow-2xl" @click.away="modals.context = false">
                <div
                    class="p-5 border-b border-border-default bg-bg-tertiary flex justify-between items-center rounded-t-lg">
                    <h3 class="text-h4 font-bold text-text-primary flex items-center gap-2"><i data-lucide="fingerprint"
                            class="w-5 h-5 text-text-secondary"></i> Device Footprint</h3>
                    <button @click="modals.context = false" class="text-text-tertiary hover:text-text-primary"><i
                            data-lucide="x" class="w-5 h-5"></i></button>
                </div>
                <div class="p-6 space-y-6" x-show="selectedDevice">

                    <div class="grid grid-cols-2 gap-4">
                        <div class="bg-bg-secondary p-3 rounded border border-border-default">
                            <span class="text-[10px] text-text-tertiary uppercase font-bold block mb-1">Hardware Signature</span>
                            <span class="text-body-sm font-mono text-text-primary break-all"
                                x-text="selectedDevice?.fingerprint"></span>
                        </div>
                        <div class="bg-bg-secondary p-3 rounded border border-border-default">
                            <span class="text-[10px] text-text-tertiary uppercase font-bold block mb-1">Screen / Locale</span>
                            <span class="text-body-sm text-text-primary" x-text="selectedDevice?.specs"></span>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                        <div class="bg-bg-secondary p-3 rounded border border-border-default">
                            <span class="text-[10px] text-text-tertiary uppercase font-bold block mb-1">OS / Version</span>
                            <span class="text-caption text-text-primary truncate block"
                                x-text="selectedDevice?.os_name"></span>
                        </div>
                        <div class="bg-bg-secondary p-3 rounded border border-border-default">
                            <span class="text-[10px] text-text-tertiary uppercase font-bold block mb-1">Browser / App</span>
                            <span class="text-caption text-text-primary truncate block"
                                x-text="selectedDevice?.browser"></span>
                        </div>
                        <div class="bg-bg-secondary p-3 rounded border border-border-default">
                            <span class="text-[10px] text-text-tertiary uppercase font-bold block mb-1">Timezone</span>
                            <span class="text-caption text-text-primary truncate block"
                                x-text="selectedDevice?.timezone"></span>
                        </div>
                        <div class="bg-bg-secondary p-3 rounded border border-border-default">
                            <span class="text-[10px] text-text-tertiary uppercase font-bold block mb-1">AI Similarity</span>
                            <span class="text-caption font-bold"
                                :class="selectedDevice?.ai_spoof_risk > 70 ? 'text-semantic-error' : 'text-semantic-success'"
                                x-text="selectedDevice?.ai_spoof_risk + '%'"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- CONFIRM MODAL -->
        <div x-show="modals.confirm" x-transition
            class="fixed inset-0 z-[100] flex items-center justify-center bg-black/60 backdrop-blur-sm p-4" x-cloak>

            <div class="card max-w-sm w-full p-5 bg-bg-primary">
                <h2 class="text-h4 font-bold text-text-primary mb-2" x-text="confirmData.title"></h2>
                <p class="text-body-sm text-text-secondary mb-4" x-text="confirmData.message"></p>

                <div class="flex justify-end gap-2">
                    <button @click="modals.confirm = false" class="btn btn-secondary">Cancel</button>

                    <button @click="modals.confirm = false; confirmData.onConfirm && confirmData.onConfirm()"
                        class="btn btn-destructive">
                        Confirm
                    </button>
                </div>
            </div>
        </div>

        <!-- INPUT MODAL -->
        <div x-show="modals.input" x-transition
            class="fixed inset-0 z-[100] flex items-center justify-center bg-black/60 backdrop-blur-sm p-4" x-cloak>

            <div class="card max-w-md w-full p-5 bg-bg-primary">
                <h2 class="text-h4 font-bold text-text-primary mb-2" x-text="inputData.title"></h2>
                <p class="text-body-sm text-text-secondary mb-3" x-text="inputData.message"></p>

                <textarea x-model="inputData.value" class="form-input w-full h-24 mb-4" placeholder="Enter reason..."></textarea>

                <div class="flex justify-end gap-2">
                    <button @click="modals.input = false" class="btn btn-secondary">Cancel</button>

                    <button @click="modals.input = false; inputData.onSubmit && inputData.onSubmit(inputData.value)"
                        class="btn btn-primary">
                        Submit
                    </button>
                </div>
            </div>
        </div>

    </div> <!-- MAIN WRAPPER END (x-data ends here) -->

    @push('scripts')
        <script>
            document.addEventListener('alpine:init', () => {
                Alpine.data('deviceTrust', () => ({
                    isLoading: true,
                    isSaving: false,
                    searchQuery: '',

                    toasts: [],

                    modals: {
                        context: false,
                        confirm: false,
                        input: false,
                    },

                    confirmData: {
                        title: '',
                        message: '',
                        onConfirm: () => {}
                    },

                    inputData: {
                        title: '',
                        message: '',
                        value: '',
                        onSubmit: () => {}
                    },

                    selectedDevice: null,

                    policy: {
                        maxDevices: 5,
                        expiryDays: 30,
                        blockRooted: true,
                        requireOtpNew: true
                    },

                    insights: {
                        total: 0,
                        untrusted: 0,
                        banned: 0
                    },

                    devices: [],

                    init() {
                        this.fetchData();
                    },

                    notify(message, type = 'success') {
                        const id = Date.now();
                        this.toasts.push({ id, message, type });
                        setTimeout(() => {
                            this.toasts = this.toasts.filter(t => t.id !== id);
                        }, 3000);
                    },

                    confirm(title, message, onConfirm) {
                        this.confirmData = { title, message, onConfirm };
                        this.modals.confirm = true;
                    },

                    ask(title, message, onSubmit) {
                        this.inputData = { title, message, value: '', onSubmit };
                        this.modals.input = true;
                    },

                    get filteredDevices() {
                        if (!this.searchQuery) return this.devices;
                        const q = this.searchQuery.toLowerCase();
                        return this.devices.filter(d =>
                            d.os_name.toLowerCase().includes(q) ||
                            d.fingerprint.toLowerCase().includes(q) ||
                            d.user.name.toLowerCase().includes(q) ||
                            d.ip.includes(q)
                        );
                    },

                    async fetchData() {
                        this.isLoading = true;
                        await new Promise(r => setTimeout(r, 800));

                        this.insights = { total: 1248, untrusted: 42, banned: 14 };
                        this.devices = [
                            /* Insert your sample data here if needed */
                        ];

                        this.isLoading = false;
                        this.$nextTick(() => { if(typeof lucide !== 'undefined') lucide.createIcons(); });
                    },

                    async savePolicy() {
                        this.isSaving = true;
                        await new Promise(r => setTimeout(r, 600));
                        this.isSaving = false;
                        this.notify("Policies updated successfully", "success");
                    },

                    viewContext(device) {
                        this.selectedDevice = device;
                        this.modals.context = true;
                    },

                    handleAction(id, action) {
                        const d = this.devices.find(x => x.id === id);
                        if (!d) return;

                        if (action === 'trust') {
                            this.confirm("Trust Device?", "Are you sure you want to trust this device?", () => {
                                d.status = 'trusted';
                                this.notify("Device trusted", "success");
                            });
                        } else if (action === 'revoke') {
                            this.confirm("Revoke Trust?", "Device will require OTP on next login.", () => {
                                d.status = 'unverified';
                                this.notify("Trust revoked", "warning");
                            });
                        } else if (action === 'ban') {
                            this.ask("Ban Device", "Enter reason for banning this device:", (reason) => {
                                if (!reason || !reason.trim()) return;
                                d.status = 'banned';
                                this.notify("Device banned", "error");
                            });
                        } else if (action === 'unban') {
                            this.confirm("Unban Device?", "Device will be restored to unverified state.", () => {
                                d.status = 'unverified';
                                this.notify("Device unbanned", "success");
                            });
                        }
                    }
                }));
            });
        </script>
    @endpush
@endsection