@extends('layouts.app')

@section('content')
    <div class="min-h-screen theme-bg-body theme-text-main p-6 font-sans relative overflow-hidden" x-data="emergencySystem()"
        x-init="init()">

        {{-- GLOBAL LOADING OVERLAY --}}
        <div x-show="isLoading" class="fixed inset-0 bg-black/80 z-[60] flex flex-col items-center justify-center backdrop-blur-sm" style="display: none;">
            <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-red-500 mb-4"></div>
            <div class="text-xs theme-text-muted font-mono animate-pulse" x-text="loadingMessage">Processing...</div>
        </div>

        {{-- TOAST NOTIFICATION --}}
        <div x-show="toast.show" x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 translate-x-8" x-transition:enter-end="opacity-100 translate-x-0"
            x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 translate-x-0"
            x-transition:leave-end="opacity-0 translate-x-8"
            class="fixed top-6 right-6 z-[70] theme-bg-card border-l-4 p-4 rounded shadow-2xl flex items-center gap-3 min-w-[300px]"
            :class="toast.type === 'success' ? 'border-green-500' : (toast.type === 'danger' ? 'border-red-500' : 'border-blue-500')"
            style="display: none;">
            <div x-text="toast.message" class="text-sm font-semibold theme-text-main"></div>
        </div>

        {{-- VISUAL OVERRIDE INDICATOR --}}
        <div x-show="override.active" class="absolute inset-0 border-[8px] border-red-600/30 z-0 pointer-events-none animate-pulse" style="display: none;"></div>

        {{-- HEADER --}}
        <div class="relative z-10 flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4 border-b theme-border pb-6">
            <div>
                <h1 class="text-3xl font-bold tracking-tight theme-text-main flex items-center gap-3">
                    <div class="p-2 bg-red-500/10 rounded-lg text-red-500 border border-red-500/30">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                    </div>
                    <span>System Governance</span>
                </h1>
                <p class="theme-text-muted text-sm mt-2 ml-14">Maintenance Controls & Emergency Kill Switches</p>
            </div>

            <div class="flex items-center gap-4">
                <div x-show="override.active" class="text-right" style="display: none;">
                    <div class="text-red-500 font-mono font-bold text-xl" x-text="formatTimer()">00:00</div>
                    <div class="text-[10px] text-red-400 uppercase tracking-widest">Auto-Termination</div>
                </div>

                <button @click="handleOverrideClick()" :class="override.active ? 'bg-red-600 hover:bg-red-700 animate-pulse border-red-500 shadow-red-900/50' : 'theme-bg-card theme-border hover:bg-white/5'" class="group border px-5 py-3 rounded-lg transition-all flex items-center gap-3 shadow-lg">
                    <div :class="override.active ? 'bg-white text-red-600' : 'bg-gray-700 text-gray-400'" class="p-1.5 rounded-md transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path></svg>
                    </div>
                    <div class="text-left">
                        <div class="text-xs font-bold uppercase tracking-wide theme-text-main" x-text="override.active ? 'TERMINATE SESSION' : 'EMERGENCY OVERRIDE'"></div>
                        <div class="text-[10px] opacity-70 theme-text-muted" x-text="override.active ? 'Root Access Granted' : 'Request Access'"></div>
                    </div>
                </button>
            </div>
        </div>

        <div class="grid grid-cols-1 xl:grid-cols-3 gap-8 relative z-10">
            
            {{-- COLUMN 1: MAINTENANCE CONFIGURATION --}}
            <div class="xl:col-span-1 space-y-6">
                <div class="theme-bg-card rounded-xl border theme-border shadow-lg overflow-hidden flex flex-col h-full">
                    <div class="p-5 border-b theme-border flex justify-between items-center" style="background-color: rgba(var(--bg-body), 0.5);">
                        <h3 class="font-bold theme-text-main flex items-center gap-2">Maintenance Mode</h3>
                        {{-- Global Lock Indicator --}}
                        <div x-show="isGlobalActive" class="px-2 py-1 bg-red-600 text-white text-[10px] font-bold uppercase rounded animate-pulse">
                            ⛔ Global Lock
                        </div>
                    </div>

                    <div class="p-6 space-y-5 flex-1 relative">
                        {{-- Disabled Overlay if Global Active --}}
                        <div x-show="isGlobalActive" class="absolute inset-0 bg-gray-900/80 z-20 flex flex-col items-center justify-center text-center p-6 backdrop-blur-sm">
                            <svg class="w-10 h-10 text-red-500 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                            <h4 class="text-white font-bold">System Wide Maintenance Active</h4>
                            <p class="text-xs text-gray-400 mt-1">You cannot add specific module maintenance while global maintenance is active.</p>
                        </div>

                        {{-- Scope Tabs --}}
                        <div>
                            <label class="block text-xs font-semibold theme-text-muted uppercase mb-2">Scope</label>
                            <div class="grid grid-cols-3 gap-2 theme-bg-body p-1 rounded-lg">
                                <button @click="maintenanceForm.scope = 'global'; maintenanceForm.target = null" :class="maintenanceForm.scope === 'global' ? 'bg-gray-700 text-white shadow' : 'text-gray-500 hover:text-gray-300'" class="py-1.5 text-xs font-medium rounded transition">Global</button>
                                <button @click="maintenanceForm.scope = 'module'" :class="maintenanceForm.scope === 'module' ? 'bg-gray-700 text-white shadow' : 'text-gray-500 hover:text-gray-300'" class="py-1.5 text-xs font-medium rounded transition">Module</button>
                                <button @click="maintenanceForm.scope = 'region'" :class="maintenanceForm.scope === 'region' ? 'bg-gray-700 text-white shadow' : 'text-gray-500 hover:text-gray-300'" class="py-1.5 text-xs font-medium rounded transition">Region</button>
                            </div>
                        </div>

                        {{-- Target Inputs --}}
                        <div x-show="maintenanceForm.scope === 'module'" style="display: none;">
                            <label class="block text-xs theme-text-muted mb-1">Target Module</label>
                            <select x-model="maintenanceForm.target" class="w-full theme-bg-body border theme-border rounded-lg text-sm px-3 py-2 theme-text-main">
                                <option value="" disabled selected>Select Module</option>
                                <option value="orders">Orders</option>
                                <option value="payments">Payments</option>
                                <option value="subscriptions">Subscriptions</option>
                            </select>
                        </div>

                        <div x-show="maintenanceForm.scope === 'region'" style="display: none;">
                            <label class="block text-xs theme-text-muted mb-1">Target Country ID</label>
                            <input type="number" x-model="maintenanceForm.target" class="w-full theme-bg-body border theme-border rounded-lg text-sm px-3 py-2 theme-text-main" placeholder="e.g. 1">
                        </div>

                        {{-- Reason --}}
                        <div>
                            <label class="block text-xs font-semibold theme-text-muted uppercase mb-2">Reason</label>
                            <select x-model="maintenanceForm.reason" class="w-full theme-bg-body border theme-border rounded-lg text-sm px-3 py-2 mb-3 theme-text-main">
                                <option value="Order service upgrade">Order service upgrade</option>
                                <option value="Database maintenance">Database maintenance</option>
                                <option value="Security patch">Security patch</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-xs font-semibold theme-text-muted uppercase mb-2">Public Message</label>
                            <input type="text" x-model="maintenanceForm.userMessage" class="w-full theme-bg-body border theme-border rounded-lg text-sm px-3 py-2 mb-3 theme-text-main" placeholder="System upgrade in progress...">
                        </div>

                        <button @click="createMaintenance()" class="w-full py-2 text-xs font-bold text-white bg-blue-600 hover:bg-blue-500 rounded-lg shadow-lg transition">
                            Activate Mode
                        </button>
                    </div>

                    {{-- ACTIVE MAINTENANCE LIST --}}
                    <div class="border-t theme-border bg-black/20">
                        <div class="p-3 bg-white/5 text-[10px] font-bold text-gray-400 uppercase tracking-wider">
                            Active Tasks
                        </div>
                        <div class="max-h-40 overflow-y-auto custom-scrollbar">
                            <template x-for="task in activeMaintenances" :key="task.id">
                                <div class="flex items-center justify-between p-3 border-b border-white/5 hover:bg-white/5 transition">
                                    <div>
                                        <div class="flex items-center gap-2">
                                            <span class="w-2 h-2 rounded-full" :class="task.type === 'global' ? 'bg-red-500 animate-pulse' : 'bg-yellow-500'"></span>
                                            <span class="text-xs font-bold text-white uppercase" x-text="task.type"></span>
                                            <span x-show="task.type !== 'global'" class="text-[10px] text-gray-400" x-text="'(' + (task.module || task.country_id) + ')'"></span>
                                        </div>
                                        <div class="text-[10px] text-gray-500 mt-0.5" x-text="task.reason"></div>
                                    </div>
                                    <button @click="cancelMaintenance(task.id)" class="text-[10px] px-2 py-1 bg-gray-800 hover:bg-red-900 hover:text-white text-gray-400 rounded border border-gray-700 transition">
                                        End
                                    </button>
                                </div>
                            </template>
                            <div x-show="activeMaintenances.length === 0" class="p-4 text-center text-[10px] text-gray-600 italic">
                                All systems operational.
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- COLUMN 2 & 3: KILL SWITCHES & LOGS --}}
            <div class="xl:col-span-2 space-y-6">
                
                {{-- KILL SWITCHES --}}
                <div class="theme-bg-card rounded-xl border theme-border shadow-lg overflow-hidden">
                    <div class="p-5 border-b theme-border flex justify-between items-center" style="background-color: rgba(var(--bg-body), 0.5);">
                        <h3 class="font-bold theme-text-main flex items-center gap-2 text-lg">Service Kill Switches</h3>
                        <button @click="syncKillSwitches()" class="text-xs text-blue-400 hover:text-blue-300">Sync Status</button>
                    </div>

                    <div class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <template x-for="service in services" :key="service.id">
                                <div class="theme-bg-body border theme-border rounded-lg p-4 relative overflow-hidden group hover:border-gray-500 transition-all">
                                    <div class="absolute left-0 top-0 bottom-0 w-1 transition-colors duration-500" :class="{'bg-green-500': service.status === 'operational', 'bg-yellow-500': service.status === 'soft', 'bg-red-600': service.status === 'hard'}"></div>
                                    <div class="flex justify-between items-start pl-3 mb-4">
                                        <div>
                                            <h4 class="font-bold theme-text-main" x-text="service.name"></h4>
                                            <div class="text-[10px] uppercase font-mono tracking-wide mt-1" :class="{'text-green-500': service.status === 'operational', 'text-red-500': service.status !== 'operational'}" x-text="service.status.toUpperCase()"></div>
                                        </div>
                                    </div>
                                    <div class="grid grid-cols-2 gap-3 pl-3">
                                        <button @click="openKillModal(service, 'soft')" :disabled="service.status === 'soft'" class="py-2 px-3 rounded text-xs font-bold border transition disabled:opacity-50 disabled:cursor-not-allowed" :class="service.status === 'soft' ? 'bg-yellow-500/10 text-yellow-500 border-yellow-500/30' : 'bg-yellow-500/20 text-yellow-500 border-yellow-500/30 hover:bg-yellow-500 hover:text-gray-900'">Soft Kill</button>
                                        <button @click="openKillModal(service, 'hard')" :disabled="service.status === 'hard'" class="py-2 px-3 rounded text-xs font-bold border transition disabled:opacity-50 disabled:cursor-not-allowed" :class="service.status === 'hard' ? 'bg-red-500/10 text-red-500 border-red-500/30' : 'bg-red-500/20 text-red-500 border-red-500/30 hover:bg-red-600 hover:text-white'">Hard Kill</button>
                                    </div>
                                </div>
                            </template>
                        </div>
                    </div>
                </div>

                {{-- AUDIT LOGS --}}
                <div class="theme-bg-card rounded-xl border theme-border shadow-lg overflow-hidden flex flex-col h-64">
                    <div class="p-4 border-b theme-border flex justify-between items-center" style="background-color: rgba(var(--bg-body), 0.5);">
                        <h3 class="font-bold theme-text-main text-sm">Live Audit Trail</h3>
                        <button @click="fetchLogs()" class="text-[10px] theme-text-muted hover:text-white underline">Refresh</button>
                    </div>
                    <div class="flex-1 overflow-y-auto custom-scrollbar p-2">
                        <table class="w-full text-left text-[10px]">
                            <tbody class="divide-y" style="border-color: rgba(var(--border-color), 0.5);">
                                <template x-for="log in logs" :key="log.id">
                                    <tr class="hover:bg-white/5 transition">
                                        <td class="p-2 text-gray-400 font-mono whitespace-nowrap" x-text="formatTime(log.created_at)"></td>
                                        <td class="p-2 theme-text-main font-bold" x-text="'Admin ' + log.admin_id"></td>
                                        <td class="p-2">
                                             <span class="px-1.5 py-0.5 rounded border inline-block w-full text-center"
                                                :class="getLogBadgeClass(log.action)"
                                                x-text="log.action"></span>
                                        </td>
                                    </tr>
                                </template>
                                <tr x-show="logs.length === 0">
                                    <td colspan="3" class="p-4 text-center text-gray-500">No logs found</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>

        {{-- MODALS --}}
        {{-- KILL SWITCH MODAL --}}
        <div x-show="killModal.open" class="fixed inset-0 z-50 flex items-center justify-center bg-black/90 backdrop-blur-sm" style="display: none;">
            <div class="theme-bg-card w-full max-w-lg rounded-2xl border border-red-500/50 shadow-2xl p-6" @click.away="killModal.open = false">
                <h2 class="text-xl font-bold theme-text-main mb-4">Confirm <span x-text="killModal.type"></span> Kill</h2>
                <textarea x-model="killModal.justification" placeholder="Required: Reason for kill..." class="w-full theme-bg-body border theme-border rounded-lg p-3 text-sm theme-text-main h-24 mb-4"></textarea>
                <div class="flex justify-end gap-3">
                    <button @click="killModal.open = false" class="px-4 py-2 text-sm theme-text-muted">Cancel</button>
                    <button @click="executeKill()" :disabled="!killModal.justification" class="px-4 py-2 bg-red-600 text-white rounded font-bold hover:bg-red-700">Execute</button>
                </div>
            </div>
        </div>

        {{-- EMERGENCY OVERRIDE MODAL --}}
        <div x-show="overrideModal.open" class="fixed inset-0 z-50 flex items-center justify-center bg-black/90 backdrop-blur-sm" style="display: none;">
            <div class="theme-bg-card w-full max-w-md rounded-2xl border border-red-600 shadow-red-900/20 shadow-2xl p-6" @click.away="overrideModal.open = false">
                <div class="flex items-center gap-3 mb-4 text-red-500">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                    <h2 class="text-xl font-bold">Emergency Override</h2>
                </div>
                <div class="space-y-4">
                    <div>
                        <label class="block text-xs font-semibold theme-text-muted uppercase mb-2">Reason</label>
                        <select x-model="overrideModal.reason" class="w-full theme-bg-body border theme-border rounded-lg text-sm px-3 py-2 theme-text-main">
                            <option value="Order service upgrade">Order service upgrade</option>
                            <option value="Critical System Recovery">Critical System Recovery</option>
                            <option value="Database Incident">Database Incident</option>
                            <option value="Security Breach">Security Breach</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold theme-text-muted uppercase mb-2">Duration (Minutes)</label>
                        <input type="number" x-model="overrideModal.duration" class="w-full theme-bg-body border theme-border rounded-lg text-sm px-3 py-2 theme-text-main" min="5" max="120">
                    </div>
                </div>
                <div class="flex justify-end gap-3 mt-6">
                    <button @click="overrideModal.open = false" class="px-4 py-2 text-sm theme-text-muted hover:text-white">Cancel</button>
                    <button @click="submitOverride()" class="px-4 py-2 bg-red-600 text-white rounded font-bold hover:bg-red-700 shadow-lg">Activate Override</button>
                </div>
            </div>
        </div>

    </div>


@endsection

<script>
    window.emergencySystem = function() {
        return {
            isLoading: false,
            loadingMessage: 'Processing...',
            
            // --- STATE ---
            activeMaintenances: [], // Holds array of active tasks
            isGlobalActive: false,  // Flag for lock
            maintenanceForm: { scope: 'global', target: '', reason: 'Order service upgrade', userMessage: '' },
            
            override: { active: false, timeLeft: 0, timer: null },
            overrideModal: { open: false, reason: 'Order service upgrade', duration: 30 },

            services: [
                { id: 'payments', name: 'Payment Gateway', status: 'operational', db_id: null },
                { id: 'orders', name: 'Order Processing', status: 'operational', db_id: null },
                { id: 'payouts', name: 'Payout Service', status: 'operational', db_id: null },
                { id: 'notifications', name: 'Notifications', status: 'operational', db_id: null },
                { id: 'subscriptions', name: 'Subscriptions', status: 'operational', db_id: null },
            ],

            logs: [],
            toast: { show: false, message: '', type: 'success' },
            killModal: { open: false, serviceId: null, type: '', justification: '' },

            // --- INIT ---
            async init() {
                this.isLoading = true;
                await Promise.all([
                    this.syncMaintenance(),
                    this.syncKillSwitches(),
                    this.fetchLogs()
                ]);
                this.isLoading = false;
            },

            // --- API CALLER ---
            async callApi(endpoint, method, body = null) {
                const token = localStorage.getItem('token');
                if (!token) this.showToast('Authentication Token Missing.', 'danger');

                const options = {
                    method: method,
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'Authorization': `Bearer ${token}`
                    }
                };
                if (body && method !== 'GET') options.body = JSON.stringify(body);

                try {
                    const response = await fetch(`http://127.0.0.1:8000${endpoint}`, options);
                    const json = await response.json();
                    if (!response.ok) throw new Error(json.message || 'API Error');
                    return json;
                } catch (e) {
                    console.error(e);
                    this.showToast(e.message, 'danger');
                    return null;
                }
            },

            // --- MAINTENANCE LOGIC (UPDATED FOR MULTIPLE) ---
            async syncMaintenance() {
                const res = await this.callApi('/api/maintenance', 'GET');
                if (res && res.data) {
                    // Filter only active or scheduled tasks
                    this.activeMaintenances = res.data.filter(m => m.status === 'active' || m.status === 'scheduled');
                    
                    // Check for Global Lock
                    this.isGlobalActive = this.activeMaintenances.some(m => m.type === 'global');
                }
            },

            async createMaintenance() {
                // Pre-check: If global lock is active, stop.
                if(this.isGlobalActive && this.maintenanceForm.scope !== 'global') {
                     this.showToast('System is under Global Lock', 'danger');
                     return;
                }

                const now = new Date();
                const formattedDate = now.getFullYear() + "-" +
                    ("0" + (now.getMonth() + 1)).slice(-2) + "-" +
                    ("0" + now.getDate()).slice(-2) + " " +
                    ("0" + now.getHours()).slice(-2) + ":" +
                    ("0" + now.getMinutes()).slice(-2) + ":" +
                    ("0" + now.getSeconds()).slice(-2);

                const payload = {
                    type: this.maintenanceForm.scope,
                    module: this.maintenanceForm.scope === 'module' ? this.maintenanceForm.target : null,
                    country_id: this.maintenanceForm.scope === 'region' ? this.maintenanceForm.target : null,
                    reason: this.maintenanceForm.reason,
                    user_message: this.maintenanceForm.userMessage,
                    starts_at: formattedDate
                };

                const res = await this.callApi('/api/maintenance', 'POST', payload);
                if(res) {
                    this.showToast('Maintenance Task Added', 'warning');
                    this.maintenanceForm.userMessage = ''; // Reset message
                    this.syncMaintenance(); // Refresh list
                    this.fetchLogs();
                }
            },

            async cancelMaintenance(id) {
                // Endpoint to cancel specific ID
                const res = await this.callApi(`/api/maintenance/${id}`, 'PATCH');
                if(res) {
                    this.showToast('Maintenance Ended', 'success');
                    this.syncMaintenance(); // Refresh list
                    this.fetchLogs();
                }
            },

            // --- OVERRIDE LOGIC ---
            handleOverrideClick() {
                if (this.override.active) {
                    this.terminateOverride();
                } else {
                    this.overrideModal.open = true;
                }
            },

            async submitOverride() {
                this.overrideModal.open = false;
                this.isLoading = true;
                const payload = {
                    reason: this.overrideModal.reason,
                    duration_minutes: parseInt(this.overrideModal.duration)
                };
                const res = await this.callApi('/api/emergency-override/activate', 'POST', payload);
                if(res) {
                    this.override.active = true;
                    const expiry = new Date(res.expires_at).getTime();
                    const now = new Date().getTime();
                    this.override.timeLeft = Math.max(0, Math.floor((expiry - now) / 1000));
                    this.startTimer();
                    this.showToast('Override Activated', 'danger');
                }
                this.fetchLogs();
                this.isLoading = false;
            },

            async terminateOverride() {
                await this.callApi('/api/emergency-override/terminate', 'POST');
                this.override.active = false;
                clearInterval(this.override.timer);
                this.showToast('Override Terminated', 'info');
                this.fetchLogs();
            },

            // --- KILL SWITCH LOGIC ---
            async syncKillSwitches() {
                const res = await this.callApi('/api/kill/switch', 'GET');
                this.services.forEach(s => { s.status = 'operational'; s.db_id = null; });
                if (res) {
                    const list = Array.isArray(res) ? res : (res.data || []);
                    list.forEach(k => {
                        if (k.status === 'active') {
                            const service = this.services.find(s => s.id === k.scope);
                            if (service) {
                                service.status = k.type;
                                service.db_id = k.id;
                            }
                        }
                    });
                }
            },

            openKillModal(service, type) {
                if (service.status !== 'operational') {
                    if(confirm('Restore service functionality?')) {
                        this.restoreService(service);
                    }
                    return;
                }
                this.killModal = { open: true, serviceId: service.id, type: type, justification: '' };
            },

            async executeKill() {
                const payload = {
                    scope: this.killModal.serviceId,
                    type: this.killModal.type,
                    reason: this.killModal.justification
                };
                const res = await this.callApi('/api/kill/switch', 'POST', payload);
                if(res) {
                    this.killModal.open = false;
                    this.showToast('Kill Switch Activated', 'danger');
                    this.syncKillSwitches();
                    this.fetchLogs();
                }
            },

            async restoreService(service) {
                const res = await this.callApi(`/api/kill/switch/cancel/${service.db_id}`, 'POST');
                if(res) {
                    this.showToast('Service Restored', 'success');
                    this.syncKillSwitches();
                    this.fetchLogs();
                }
            },

            // --- UTILS ---
            async fetchLogs() {
                const res = await this.callApi('/api/emergency-override/logs', 'GET');
                if(res) {
                    this.logs = res;
                    this.inferOverrideStatus(res);
                }
            },

            inferOverrideStatus(logs) {
                if (!logs || logs.length === 0) return;
                const sorted = logs.sort((a, b) => b.id - a.id);
                const lastLog = sorted.find(l => l.action.includes('OVERRIDE'));
                
                if (lastLog && lastLog.action === 'OVERRIDE_ACTIVATED') {
                    if(!this.override.active) {
                        this.override.active = true;
                        this.override.timeLeft = 1800; 
                        this.startTimer();
                    }
                } else {
                     this.override.active = false;
                }
            },

            startTimer() {
                if (this.override.timer) clearInterval(this.override.timer);
                this.override.timer = setInterval(() => {
                    if (this.override.timeLeft-- <= 0) {
                        this.override.active = false;
                        clearInterval(this.override.timer);
                    }
                }, 1000);
            },

            formatTimer() {
                const m = Math.floor(this.override.timeLeft / 60);
                const s = this.override.timeLeft % 60;
                return `${m}:${s.toString().padStart(2, '0')}`;
            },

            formatTime(iso) { return new Date(iso).toLocaleTimeString(); },
            
            getLogBadgeClass(action) {
                if (action.includes('ACTIVATED') || action.includes('HARD') || action.includes('SOFT')) return 'bg-red-500/10 text-red-400 border-red-500/30';
                if (action.includes('TERMINATED') || action.includes('RESTORE') || action.includes('CANCEL')) return 'bg-green-500/10 text-green-400 border-green-500/30';
                return 'text-gray-400';
            },

            showToast(msg, type) {
                this.toast = { show: true, message: msg, type };
                setTimeout(() => this.toast.show = false, 3000);
            }
        };
    }
</script>