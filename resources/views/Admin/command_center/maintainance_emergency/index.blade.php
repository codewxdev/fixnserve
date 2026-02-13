@extends('layouts.app')

@section('content')
    {{-- 
    ==========================================================================
    MODULE 1.4: MAINTENANCE & EMERGENCY OPS (DYNAMIC)
    ==========================================================================
    --}}

    <div class="min-h-screen theme-bg-body theme-text-main p-6 font-sans relative overflow-hidden" x-data="emergencySystem()"
        x-init="init()"> {{-- Init function call to load initial data --}}

        {{-- GLOBAL LOADING OVERLAY --}}
        <div x-show="isLoading" x-transition.opacity
            class="fixed inset-0 bg-black/80 z-[60] flex flex-col items-center justify-center backdrop-blur-sm"
            style="display: none;">
            <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-red-500 mb-4"></div>
            <div class="text-xs theme-text-muted font-mono animate-pulse" x-text="loadingMessage">Processing...</div>
        </div>

        {{-- EMERGENCY OVERRIDE VISUAL ALERT --}}
        <div x-show="override.active" x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 scale-90" x-transition:enter-end="opacity-100 scale-100"
            class="absolute inset-0 border-[8px] border-red-600/30 z-0 pointer-events-none animate-pulse"
            style="display: none;">
        </div>

        {{-- TOAST NOTIFICATION --}}
        <div x-show="toast.show" x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 translate-x-8" x-transition:enter-end="opacity-100 translate-x-0"
            x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 translate-x-0"
            x-transition:leave-end="opacity-0 translate-x-8"
            class="fixed top-6 right-6 z-[70] theme-bg-card border-l-4 p-4 rounded shadow-2xl flex items-center gap-3 min-w-[300px]"
            :class="toast.type === 'success' ? 'border-green-500' : (toast.type === 'danger' ? 'border-red-500' :
                'border-blue-500')"
            style="display: none;">
            <div x-text="toast.message" class="text-sm font-semibold theme-text-main"></div>
        </div>

        {{-- HEADER --}}
        <div
            class="relative z-10 flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4 border-b theme-border pb-6">
            <div>
                <h1 class="text-3xl font-bold tracking-tight theme-text-main flex items-center gap-3">
                    <div class="p-2 bg-red-500/10 rounded-lg text-red-500 border border-red-500/30">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
                            </path>
                        </svg>
                    </div>
                    <span>System Governance</span>
                </h1>
                <p class="theme-text-muted text-sm mt-2 ml-14">
                    Maintenance Controls & Emergency Kill Switches
                </p>
            </div>

            {{-- EMERGENCY OVERRIDE BUTTON --}}
            <div class="flex items-center gap-4">
                <div x-show="override.active" class="text-right" style="display: none;">
                    <div class="text-red-500 font-mono font-bold text-xl" x-text="formatTimer()">00:00</div>
                    <div class="text-[10px] text-red-400 uppercase tracking-widest">Auto-Termination</div>
                </div>

                <button @click="toggleOverride()"
                    :class="override.active ? 'bg-red-600 hover:bg-red-700 animate-pulse border-red-500 shadow-red-900/50' :
                        'theme-bg-card theme-border hover:bg-white/5'"
                    class="group border px-5 py-3 rounded-lg transition-all flex items-center gap-3 shadow-lg">
                    <div :class="override.active ? 'bg-white text-red-600' : 'bg-gray-700 text-gray-400'"
                        class="p-1.5 rounded-md transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z">
                            </path>
                        </svg>
                    </div>
                    <div class="text-left">
                        <div class="text-xs font-bold uppercase tracking-wide theme-text-main"
                            x-text="override.active ? 'TERMINATE SESSION' : 'EMERGENCY OVERRIDE'"></div>
                        <div class="text-[10px] opacity-70 theme-text-muted"
                            x-text="override.active ? 'Root Access Granted' : 'Requires MFA'"></div>
                    </div>
                </button>
            </div>
        </div>

        <div class="grid grid-cols-1 xl:grid-cols-3 gap-8 relative z-10">

            {{-- COLUMN 1: MAINTENANCE CONFIGURATION --}}
            <div class="xl:col-span-1 space-y-6">
                <div class="theme-bg-card rounded-xl border theme-border shadow-lg overflow-hidden">
                    <div class="p-5 border-b theme-border flex justify-between items-center"
                        style="background-color: rgba(var(--bg-body), 0.5);">
                        <h3 class="font-bold theme-text-main flex items-center gap-2">
                            <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z">
                                </path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            Maintenance Mode
                        </h3>
                        <div class="flex gap-1 items-center"
                            :class="maintenance.isActive ? 'text-yellow-400' : 'text-green-400'">
                            <span class="h-2 w-2 rounded-full animate-pulse"
                                :class="maintenance.isActive ? 'bg-yellow-500' : 'bg-green-500'"></span>
                            <span class="text-[10px] font-mono uppercase"
                                x-text="maintenance.isActive ? 'MAINTENANCE ACTIVE' : 'SYSTEMS LIVE'"></span>
                        </div>
                    </div>

                    <div class="p-6 space-y-5">
                        {{-- Scope Tabs --}}
                        <div>
                            <label class="block text-xs font-semibold theme-text-muted uppercase mb-2">Scope</label>
                            <div class="grid grid-cols-3 gap-2 theme-bg-body p-1 rounded-lg">
                                <button @click="maintenance.scope = 'global'; maintenance.target = null"
                                    :class="maintenance.scope === 'global' ? 'bg-gray-700 text-white shadow' :
                                        'text-gray-500 hover:text-gray-300'"
                                    class="py-1.5 text-xs font-medium rounded transition">Global</button>
                                <button @click="maintenance.scope = 'module'"
                                    :class="maintenance.scope === 'module' ? 'bg-gray-700 text-white shadow' :
                                        'text-gray-500 hover:text-gray-300'"
                                    class="py-1.5 text-xs font-medium rounded transition">Module</button>
                                <button @click="maintenance.scope = 'region'"
                                    :class="maintenance.scope === 'region' ? 'bg-gray-700 text-white shadow' :
                                        'text-gray-500 hover:text-gray-300'"
                                    class="py-1.5 text-xs font-medium rounded transition">Region</button>
                            </div>
                        </div>

                        {{-- Dynamic Selects (Mapped to match API Expectations) --}}
                        <div x-show="maintenance.scope === 'module'" x-transition style="display: none;">
                            <label class="block text-xs theme-text-muted mb-1">Target Module</label>
                            <select x-model="maintenance.target"
                                class="w-full theme-bg-body border theme-border rounded-lg text-sm px-3 py-2 theme-text-main focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                                <option value="" disabled selected>Select Module</option>
                                <option value="orders">Order System</option>
                                <option value="payments">Payment Gateway</option>
                                <option value="auth">Authentication</option>
                            </select>
                        </div>

                        <div x-show="maintenance.scope === 'region'" x-transition style="display: none;">
                            <label class="block text-xs theme-text-muted mb-1">Target Region</label>
                            <select x-model="maintenance.target"
                                class="w-full theme-bg-body border theme-border rounded-lg text-sm px-3 py-2 theme-text-main focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                                <option value="" disabled selected>Select Region</option>
                                <option value="1">Pakistan</option>
                                <option value="2">USA</option>
                                <option value="3">UK</option>
                            </select>
                        </div>

                        {{-- Reason --}}
                        <div>
                            <label class="block text-xs font-semibold theme-text-muted uppercase mb-2">Reason Code</label>
                            <select x-model="maintenance.reason"
                                class="w-full theme-bg-body border theme-border rounded-lg text-sm px-3 py-2 mb-3 theme-text-main focus:border-blue-500">
                                <option value="Order service upgrade">Order service upgrade</option>
                                <option value="Emergency Patch">Emergency Patch (Critical)</option>
                                <option value="Database Optimization">Database Optimization</option>
                                <option value="Scheduled Maintenance">Scheduled Maintenance</option>
                            </select>

                            {{-- User Message Input (Required by API) --}}
                            <label class="block text-xs font-semibold theme-text-muted uppercase mb-2 mt-2">Public
                                Message</label>
                            <input type="text" x-model="maintenance.userMessage"
                                class="w-full theme-bg-body border theme-border rounded-lg text-sm px-3 py-2 mb-3 theme-text-main focus:border-blue-500"
                                placeholder="e.g. Services will be back shortly">

                        </div>

                        {{-- Actions --}}
                        <div class="grid grid-cols-2 gap-3 pt-2">
                            <button
                                class="px-4 py-2 text-xs font-bold theme-text-muted hover:bg-white/5 rounded-lg border theme-border transition">
                                Schedule Later
                            </button>
                            <button @click="toggleMaintenance()"
                                class="px-4 py-2 text-xs font-bold text-white rounded-lg shadow-lg transition flex justify-center items-center gap-2"
                                :class="maintenance.isActive ? 'bg-red-600 hover:bg-red-500' : 'bg-blue-600 hover:bg-blue-500'">
                                <span x-show="isLoading"
                                    class="animate-spin h-3 w-3 border-2 border-white border-t-transparent rounded-full"></span>
                                <span x-text="maintenance.isActive ? 'Deactivate Mode' : 'Activate Mode'"></span>
                            </button>
                        </div>
                    </div>
                </div>

                {{-- LIVE AUDIT LOG --}}
                <div class="theme-bg-card rounded-xl border theme-border shadow-lg overflow-hidden flex flex-col h-64">
                    <div class="p-4 border-b theme-border flex justify-between items-center"
                        style="background-color: rgba(var(--bg-body), 0.5);">
                        <h3 class="font-bold theme-text-main text-sm">Live Audit Trail</h3>
                        <div class="flex items-center gap-2">
                            <span class="relative flex h-2 w-2">
                                <span
                                    class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                                <span class="relative inline-flex rounded-full h-2 w-2 bg-green-500"></span>
                            </span>
                            <span class="text-[10px] text-gray-500">Live</span>
                        </div>
                    </div>
                    <div class="flex-1 overflow-y-auto custom-scrollbar p-2" id="logs-container">
                        <table class="w-full text-left text-[10px]">
                            <tbody class="divide-y" style="border-color: rgba(var(--border-color), 0.5);">
                                <template x-for="log in logs" :key="log.id">
                                    <tr class="hover:bg-white/5 transition">
                                        <td class="p-2 text-gray-400 font-mono whitespace-nowrap" x-text="log.time"></td>
                                        <td class="p-2 theme-text-main font-bold" x-text="log.admin || 'System'"></td>
                                        <td class="p-2">
                                            <span class="px-1.5 py-0.5 rounded border inline-block w-full text-center"
                                                :class="{
                                                    'bg-red-500/10 border-red-500/30 text-red-400': log
                                                        .type === 'danger',
                                                    'bg-yellow-500/10 border-yellow-500/30 text-yellow-400': log
                                                        .type === 'warning',
                                                    'bg-blue-500/10 border-blue-500/30 text-blue-400': log
                                                        .type === 'info',
                                                    'bg-green-500/10 border-green-500/30 text-green-400': log
                                                        .type === 'success'
                                                }"
                                                x-text="log.action"></span>
                                        </td>
                                    </tr>
                                </template>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            {{-- COLUMN 2 & 3: KILL SWITCHES --}}
            <div class="xl:col-span-2">
                <div class="theme-bg-card rounded-xl border theme-border shadow-lg overflow-hidden h-full flex flex-col">
                    <div class="p-5 border-b theme-border flex justify-between items-center"
                        style="background-color: rgba(var(--bg-body), 0.5);">
                        <div>
                            <h3 class="font-bold theme-text-main flex items-center gap-2 text-lg">
                                <svg class="w-6 h-6 text-red-500" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636">
                                    </path>
                                </svg>
                                Service Kill Switches
                            </h3>
                            <p class="text-xs theme-text-muted mt-1">
                                Realtime API Status
                            </p>
                        </div>

                        {{-- SYNC BUTTON --}}
                        <div class="text-right">
                            <button @click="refreshServices()"
                                class="text-xs text-blue-400 hover:text-blue-300 flex items-center gap-1">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15">
                                    </path>
                                </svg>
                                Sync Status
                            </button>
                        </div>
                    </div>

                    <div class="p-6 flex-1 overflow-y-auto">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                            {{-- Dynamic Service Cards --}}
                            <template x-for="service in services" :key="service.id">
                                <div
                                    class="theme-bg-body border theme-border rounded-lg p-4 relative overflow-hidden group hover:border-gray-500 transition-all">
                                    {{-- Status Indicator Strip --}}
                                    <div class="absolute left-0 top-0 bottom-0 w-1 transition-colors duration-500"
                                        :class="{
                                            'bg-green-500': service.status === 'operational',
                                            'bg-yellow-500': service.status === 'soft',
                                            'bg-red-600': service.status === 'hard'
                                        }">
                                    </div>

                                    <div class="flex justify-between items-start pl-3 mb-4">
                                        <div>
                                            <h4 class="font-bold theme-text-main" x-text="service.name"></h4>
                                            <div class="flex items-center gap-2 mt-1">
                                                <span class="h-1.5 w-1.5 rounded-full"
                                                    :class="{
                                                        'bg-green-500 animate-pulse': service.status === 'operational',
                                                        'bg-yellow-500': service.status === 'soft',
                                                        'bg-red-500': service.status === 'hard'
                                                    }"></span>
                                                <span class="text-[10px] uppercase font-mono tracking-wide"
                                                    :class="{
                                                        'text-green-500': service.status === 'operational',
                                                        'text-yellow-500': service.status === 'soft',
                                                        'text-red-500': service.status === 'hard'
                                                    }"
                                                    x-text="service.status === 'operational' ? 'OPERATIONAL' : (service.status.toUpperCase() + ' KILL ACTIVE')"></span>
                                            </div>
                                        </div>
                                        <div class="text-right">
                                            <div class="text-[10px] text-gray-500 font-mono"
                                                x-text="'PID: ' + (2000 + service.id)"></div>
                                            <div class="text-[10px] theme-text-muted" x-text="service.latency + 'ms'">
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Action Buttons --}}
                                    <div class="grid grid-cols-2 gap-3 pl-3">
                                        {{-- Soft Kill Logic --}}
                                        <button @click="openKillModal(service, 'soft')"
                                            :disabled="service.status === 'soft' || !override.active"
                                            class="py-2 px-3 rounded text-xs font-bold transition disabled:opacity-40 disabled:cursor-not-allowed border"
                                            :class="service.status === 'soft' ?
                                                'bg-yellow-500/10 text-yellow-500 border-yellow-500/30' :
                                                'bg-yellow-500/20 text-yellow-500 border-yellow-500/30 hover:bg-yellow-500 hover:text-gray-900'">
                                            <span
                                                x-text="service.status === 'soft' ? 'Graceful Shutdown' : 'Soft Kill'"></span>
                                        </button>

                                        {{-- Hard Kill Logic --}}
                                        <button @click="openKillModal(service, 'hard')"
                                            :disabled="service.status === 'hard' || !override.active"
                                            class="py-2 px-3 rounded text-xs font-bold transition disabled:opacity-40 disabled:cursor-not-allowed border"
                                            :class="service.status === 'hard' ?
                                                'bg-red-500/10 text-red-500 border-red-500/30' :
                                                'bg-red-500/20 text-red-500 border-red-500/30 hover:bg-red-600 hover:text-white'">
                                            <span
                                                x-text="service.status === 'hard' ? 'Process Killed' : 'Hard Kill'"></span>
                                        </button>
                                    </div>

                                    {{-- Lock Hint --}}
                                    <div x-show="!override.active"
                                        class="absolute inset-0 bg-gray-900/60 flex items-center justify-center backdrop-blur-[1px] opacity-0 group-hover:opacity-100 transition-opacity">
                                        <div
                                            class="theme-bg-card text-xs text-red-400 px-3 py-1 rounded border border-red-500/30 flex items-center gap-2">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z">
                                                </path>
                                            </svg>
                                            Engage Override First
                                        </div>
                                    </div>
                                </div>
                            </template>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- BACKEND DEVELOPER PREVIEW AREA --}}
        <div class="mt-8 relative z-10 bg-black/50 border theme-border rounded-xl p-4 font-mono text-xs">
            <div class="flex justify-between items-center mb-2">
                <h4 class="text-gray-400 uppercase font-bold">Backend Payload Preview (Last Action)</h4>
                <button @click="copyPayload()" class="text-blue-400 hover:text-white transition">Copy JSON</button>
            </div>
            <div class="theme-bg-body p-4 rounded border theme-border overflow-x-auto text-green-400">
                <pre x-text="JSON.stringify(lastPayload, null, 2)"></pre>
            </div>
        </div>

        {{-- KILL SWITCH MODAL --}}
        <div x-show="killModal.open"
            class="fixed inset-0 z-50 flex items-center justify-center bg-black/90 backdrop-blur-sm"
            style="display: none;">
            {{-- Same Modal Content as before... just adding x-model binding checks --}}
            <div class="theme-bg-card w-full max-w-2xl rounded-2xl border border-red-500/50 shadow-2xl relative overflow-hidden"
                @click.away="killModal.open = false">

                <div class="h-2 w-full bg-stripes-red"></div>

                <div class="p-8">
                    <div class="flex items-start gap-4 mb-6">
                        <div class="p-3 bg-red-500/20 rounded-full border border-red-500/50">
                            <svg class="w-8 h-8 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
                                </path>
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-2xl font-bold theme-text-main">Confirm <span x-text="killModal.type"></span>
                                Kill</h2>
                            <p class="theme-text-muted text-sm mt-1">Target: <strong class="text-white"
                                    x-text="killModal.serviceName"></strong></p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div class="col-span-2">
                            <label class="block text-xs theme-text-muted mb-1">Mandatory Justification</label>
                            <textarea x-model="killModal.justification" placeholder="Reason for intervention..."
                                class="w-full theme-bg-body border theme-border rounded-lg p-3 text-sm focus:border-red-500 focus:ring-1 focus:ring-red-500 theme-text-main h-20 resize-none"></textarea>
                        </div>
                        <div>
                            <label class="block text-xs theme-text-muted mb-1">Admin 2 Approval (Simulated)</label>
                            <input type="password" x-model="killModal.admin2Pass" placeholder="Enter 'root'"
                                class="w-full theme-bg-body border border-red-500/50 rounded-lg p-2 text-sm theme-text-main focus:ring-1 focus:ring-red-500">
                        </div>
                    </div>

                    <div class="flex justify-end gap-3 pt-4 border-t theme-border">
                        <button @click="killModal.open = false"
                            class="px-5 py-2 text-sm theme-text-muted hover:text-white transition">Cancel</button>
                        <button @click="executeKill()" :disabled="!killModal.admin2Pass || !killModal.justification"
                            class="px-6 py-2 bg-red-600 hover:bg-red-700 disabled:bg-gray-700 disabled:text-gray-500 text-white font-bold rounded-lg shadow-lg transition flex items-center gap-2">
                            <span x-show="isLoading"
                                class="animate-spin h-4 w-4 border-2 border-white border-t-transparent rounded-full"></span>
                            Confirm Kill
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

{{-- @push('scripts') --}}
    {{-- <script>
    // ==========================================
    // CONFIGURATION
    // ==========================================
    const API_BASE = 'http://127.0.0.1:8000/api';
    const CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

    window.emergencySystem = function() {
        return {
            // ==========================================
            // STATE MANAGEMENT
            // ==========================================
            isLoading: false,
            loadingMessage: 'Processing...',
            lastPayload: {}, // For Developer Preview
            
            // 1. Maintenance State (Schema: maintenances)
            maintenance: {
                id: null, // Tracks DB ID
                scope: 'global', // Enum: global, module, region
                target: '',      // Stores 'module' string OR 'country_id'
                reason: 'Scheduled Maintenance',
                userMessage: 'We are currently performing system upgrades.',
                isActive: false,
                startsAt: null
            },

            // 2. Override State (Schema: emergency_overrides)
            override: {
                id: null,
                active: false,
                expiresAt: null,
                timeLeft: 0,
                timer: null,
                reason: ''
            },

            // 3. Kill Switches (Schema: kill_switches)
            // Note: 'id' matches the ENUM in your database schema
            services: [
                { key: 'payments', name: 'Payment Gateway', status: 'operational', db_id: null, latency: 45 },
                { key: 'orders', name: 'Order Processing', status: 'operational', db_id: null, latency: 120 },
                { key: 'subscriptions', name: 'Subscription Engine', status: 'operational', db_id: null, latency: 65 },
                { key: 'payouts', name: 'Payout Service', status: 'operational', db_id: null, latency: 0 },
                { key: 'notifications', name: 'Notification Service', status: 'operational', db_id: null, latency: 32 },
            ],

            // Logs (Schema: emergency_override_logs)
            logs: [],

            // Toast Notification
            toast: { show: false, message: '', type: 'success' },

            // Modal State
            killModal: {
                open: false,
                serviceKey: null, // e.g., 'payments'
                serviceName: '',
                type: '', // 'soft' or 'hard'
                justification: '',
                admin2Pass: ''
            },

            // ==========================================
            // INITIALIZATION (Sync with DB)
            // ==========================================
            async init() {
                console.log('System Governance Module Loaded');
                this.addLog('System', 'Connecting to Control Plane...', 'info');
                
                // 1. Fetch Current Maintenance Status
                await this.syncMaintenanceState();

                // 2. Fetch Active Kill Switches
                await this.syncKillSwitches();

                // 3. Fetch Emergency Override Status
                await this.syncOverrideState();
            },

            // ==========================================
            // MODULE 1: MAINTENANCE OPERATIONS
            // ==========================================
            async syncMaintenanceState() {
                try {
                    // Endpoint expected to return the latest active record from 'maintenances' table
                    const res = await this.callApi('/maintenance/status', 'GET');
                    if (res.data && res.data.status === 'active') {
                        this.maintenance.id = res.data.id;
                        this.maintenance.isActive = true;
                        this.maintenance.scope = res.data.type; 
                        this.maintenance.target = res.data.module || res.data.country_id;
                        this.maintenance.reason = res.data.reason;
                    }
                } catch (e) { console.error('Maintenance Sync Failed', e); }
            },

            async toggleMaintenance() {
                // VALIDATION: Target required if not global
                if (!this.maintenance.isActive && this.maintenance.scope !== 'global' && !this.maintenance.target) {
                    this.showToast('Error: Target Selection Required', 'danger');
                    return;
                }

                this.isLoading = true;

                if (!this.maintenance.isActive) {
                    // --- CREATE (Start Maintenance) ---
                    const payload = {
                        type: this.maintenance.scope,           // 'global', 'module', 'region'
                        module: this.maintenance.scope === 'module' ? this.maintenance.target : null,
                        country_id: this.maintenance.scope === 'region' ? this.maintenance.target : null,
                        reason: this.maintenance.reason,
                        user_message: this.maintenance.userMessage,
                        starts_at: new Date().toISOString().slice(0, 19).replace('T', ' '), // MySQL Format
                        status: 'active',
                        created_by: 1 // Ideally handled by Auth::user() in backend
                    };

                    this.lastPayload = payload;

                    try {
                        const res = await this.callApi('/maintenance', 'POST', payload);
                        this.maintenance.isActive = true;
                        this.maintenance.id = res.data.id;
                        this.showToast('Maintenance Mode ACTIVATED', 'warning');
                        this.addLog('Admin', `Maintenance Started: ${this.maintenance.scope}`, 'warning');
                    } catch (e) {
                        this.showToast('Failed to start maintenance', 'danger');
                    }
                } else {
                    // --- CANCEL (End Maintenance) ---
                    try {
                        // Updates status to 'cancelled' or 'completed'
                        await this.callApi(`/maintenance/${this.maintenance.id}/cancel`, 'POST');
                        this.maintenance.isActive = false;
                        this.maintenance.id = null;
                        this.showToast('Maintenance Mode ENDED', 'success');
                        this.addLog('Admin', 'Maintenance Ended', 'success');
                    } catch (e) {
                        this.showToast('Error ending maintenance', 'danger');
                    }
                }
                this.isLoading = false;
            },

            // ==========================================
            // MODULE 2: KILL SWITCHES
            // ==========================================
            async syncKillSwitches() {
                try {
                    // Endpoint should return all rows from 'kill_switches' where status = 'active'
                    const res = await this.callApi('/kill-switches/active', 'GET');
                    
                    // Reset all first
                    this.services.forEach(s => { s.status = 'operational'; s.db_id = null; });

                    if(res.data) {
                        res.data.forEach(activeSwitch => {
                            // Find matching service in our UI array
                            const service = this.services.find(s => s.key === activeSwitch.scope);
                            if (service) {
                                service.status = activeSwitch.type; // 'soft' or 'hard'
                                service.db_id = activeSwitch.id;
                                service.latency = 0; // Killed services have 0 latency
                            }
                        });
                    }
                } catch (e) { console.error('Kill Switch Sync Failed', e); }
            },

            openKillModal(service, type) {
                // If service is already killed, this button acts as "Restore"
                if (service.status !== 'operational') {
                    this.restoreService(service);
                    return;
                }

                this.killModal = {
                    open: true,
                    serviceKey: service.key,
                    serviceName: service.name,
                    type: type,
                    justification: '',
                    admin2Pass: ''
                };
            },

            async executeKill() {
                this.isLoading = true;
                this.loadingMessage = `INITIATING ${this.killModal.type.toUpperCase()} KILL...`;

                const payload = {
                    scope: this.killModal.serviceKey, // Matches enum: 'payments', 'orders' etc
                    type: this.killModal.type,        // 'soft', 'hard'
                    reason: this.killModal.justification,
                    expires_at: new Date(Date.now() + (24 * 60 * 60 * 1000)).toISOString().slice(0, 19).replace('T', ' '), // 24h default expiry
                    created_by: 1 // Handle in backend
                };
                
                this.lastPayload = payload;

                try {
                    const res = await this.callApi('/kill-switches', 'POST', payload);
                    
                    // Update UI locally
                    const service = this.services.find(s => s.key === this.killModal.serviceKey);
                    if (service) {
                        service.status = this.killModal.type;
                        service.db_id = res.data.id;
                        service.latency = 0;
                    }

                    this.showToast(`${service.name} Killed Successfully`, 'danger');
                    this.addLog('Admin', `Kill Switch: ${service.name} (${this.killModal.type})`, 'danger');
                    this.killModal.open = false;
                } catch (e) {
                    this.showToast('Kill Switch Failed', 'danger');
                }

                this.isLoading = false;
            },

            async restoreService(service) {
                if(!confirm(`Are you sure you want to RESTORE ${service.name}?`)) return;

                this.isLoading = true;
                this.loadingMessage = 'RESTORING SERVICES...';

                try {
                    // Update status to 'cancelled' or 'expired'
                    await this.callApi(`/kill-switches/${service.db_id}/restore`, 'POST');
                    
                    service.status = 'operational';
                    service.db_id = null;
                    service.latency = Math.floor(Math.random() * 50) + 20; // Simulate live latency
                    
                    this.showToast(`${service.name} Restored`, 'success');
                    this.addLog('Admin', `Service Restored: ${service.name}`, 'success');
                } catch (e) {
                    this.showToast('Failed to restore service', 'danger');
                }
                this.isLoading = false;
            },

            // ==========================================
            // MODULE 3: EMERGENCY OVERRIDE
            // ==========================================
            async syncOverrideState() {
                try {
                    const res = await this.callApi('/emergency-override/status', 'GET');
                    if (res.data && res.data.active) {
                        this.override.active = true;
                        this.override.id = res.data.id;
                        
                        // Calculate remaining time
                        const expires = new Date(res.data.expires_at).getTime();
                        const now = new Date().getTime();
                        const diff = Math.floor((expires - now) / 1000);
                        
                        this.override.timeLeft = diff > 0 ? diff : 0;
                        this.startTimer();
                    }
                } catch (e) { console.error('Override Sync Failed', e); }
            },

            async toggleOverride() {
                this.isLoading = true;

                if (this.override.active) {
                    // TERMINATE
                    try {
                        // Updates 'active' boolean to false in 'emergency_overrides'
                        await this.callApi(`/emergency-override/${this.override.id}/terminate`, 'POST');
                        this.override.active = false;
                        this.override.id = null;
                        clearInterval(this.override.timer);
                        this.showToast('Emergency Access Revoked', 'info');
                        this.addLog('Admin', 'Emergency Override Terminated', 'info');
                    } catch (e) { this.showToast('Termination Failed', 'danger'); }

                } else {
                    // ACTIVATE
                    // Note: In a real app, you would prompt for MFA Code here.
                    const payload = {
                        reason: 'Critical System Recovery',
                        admin_id: 1, // Handle in backend
                        expires_at: new Date(Date.now() + (5 * 60 * 1000)).toISOString().slice(0, 19).replace('T', ' ') // 5 Mins
                    };

                    try {
                        const res = await this.callApi('/emergency-override', 'POST', payload);
                        this.override.active = true;
                        this.override.id = res.data.id;
                        this.override.timeLeft = 300; // 5 mins
                        this.startTimer();
                        this.showToast('ROOT ACCESS GRANTED', 'danger');
                        this.addLog('Admin', 'EMERGENCY OVERRIDE ACTIVATED', 'danger');
                    } catch (e) { this.showToast('Activation Failed', 'danger'); }
                }
                this.isLoading = false;
            },

            startTimer() {
                if(this.override.timer) clearInterval(this.override.timer);
                this.override.timer = setInterval(() => {
                    if (this.override.timeLeft <= 0) {
                        this.toggleOverride(); // Auto-terminate
                    } else {
                        this.override.timeLeft--;
                    }
                }, 1000);
            },

            // ==========================================
            // HELPERS
            // ==========================================
            async callApi(endpoint, method, body = null) {
                const options = {
                    method: method,
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': CSRF_TOKEN
                    }
                };
                if (body) options.body = JSON.stringify(body);

                const response = await fetch(`${API_BASE}${endpoint}`, options);
                const json = await response.json();

                if (!response.ok) {
                    throw new Error(json.message || 'API Error');
                }
                return json;
            },

            formatTimer() {
                const m = Math.floor(this.override.timeLeft / 60);
                const s = this.override.timeLeft % 60;
                return `${m.toString().padStart(2, '0')}:${s.toString().padStart(2, '0')}`;
            },

            addLog(admin, action, type) {
                const now = new Date();
                const time = now.getHours().toString().padStart(2, '0') + ':' + now.getMinutes().toString().padStart(2, '0');
                this.logs.unshift({ id: Date.now(), time, admin, action, type });
                if(this.logs.length > 50) this.logs.pop();
            },

            showToast(msg, type) {
                this.toast.message = msg;
                this.toast.type = type;
                this.toast.show = true;
                setTimeout(() => this.toast.show = false, 3000);
            },
            
            copyPayload() {
                navigator.clipboard.writeText(JSON.stringify(this.lastPayload, null, 2));
                this.showToast('JSON copied to clipboard', 'info');
            }
        };
    }
</script> --}}

    <script>
        window.emergencySystem = function() {
            return {
                // ==========================================
                // STATE MANAGEMENT
                // ==========================================
                isLoading: false,
                loadingMessage: 'Processing...',
                lastPayload: {
                    "info": "Waiting for action..."
                },

                // CSRF Token fetcher
                csrfToken() {
                    return document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                },

                // Configuration Options (Mapped from DB Enums)
                config: {
                    modules: [{
                            id: 'orders',
                            name: 'Orders Module'
                        },
                        {
                            id: 'payments',
                            name: 'Payments Gateway'
                        },
                        {
                            id: 'subscriptions',
                            name: 'Subscriptions'
                        },
                        {
                            id: 'payouts',
                            name: 'Payouts Service'
                        },
                        {
                            id: 'notifications',
                            name: 'Notification Service'
                        }
                    ],
                    regions: [{
                            id: 1,
                            name: 'Asia Pacific (PK)'
                        }, // Assuming country_id 1
                        {
                            id: 2,
                            name: 'North America (US)'
                        }
                    ]
                },

                maintenance: {
                    id: null, // To store active maintenance ID for cancellation
                    scope: 'global',
                    target: '',
                    reason: 'Scheduled Maintenance',
                    user_message: 'We are undergoing scheduled maintenance.',
                    isActive: false
                },

                override: {
                    active: false,
                    timeLeft: 300,
                    timer: null
                },

                toast: {
                    show: false,
                    message: '',
                    type: 'success'
                },

                // Services mapped to 'kill_switches' table scope
                services: [{
                        id: 'payments',
                        name: 'Payment Gateway',
                        status: 'operational',
                        latency: 45
                    },
                    {
                        id: 'orders',
                        name: 'Order Processing',
                        status: 'operational',
                        latency: 120
                    },
                    {
                        id: 'payouts',
                        name: 'Payout Service',
                        status: 'operational',
                        latency: 20
                    },
                    {
                        id: 'notifications',
                        name: 'Notifications',
                        status: 'operational',
                        latency: 32
                    },
                    {
                        id: 'subscriptions',
                        name: 'User Subscriptions',
                        status: 'operational',
                        latency: 15
                    },
                ],

                logs: [],

                killModal: {
                    open: false,
                    serviceId: null, // This will be the scope enum (e.g., 'orders')
                    serviceName: '',
                    type: '', // soft or hard
                    justification: '',
                    admin2Pass: '',
                    aiLoaded: false,
                    ai: {}
                },

                // ==========================================
                // INITIALIZATION
                // ==========================================
                async init() {
                    this.isLoading = true;
                    this.loadingMessage = 'Syncing with Server...';

                    await Promise.all([
                        this.fetchMaintenanceStatus(),
                        this.fetchAuditLogs()
                        // Future: this.fetchKillSwitchStatus() 
                    ]);

                    this.isLoading = false;
                    this.addLog('System', 'Dashboard Synced', 'info');

                    // Live Latency Simulation (Visual only)
                    setInterval(() => {
                        this.services.forEach(s => {
                            if (s.status === 'operational') {
                                s.latency = Math.max(10, Math.floor(s.latency + (Math.random() *
                                    20 - 10)));
                            }
                        });
                    }, 2000);
                },

                // ==========================================
                // API ACTIONS
                // ==========================================

                // 1. Maintenance Logic
                async toggleMaintenance() {
                    // CASE: Deactivate / Cancel
                    if (this.maintenance.isActive) {
                        if (!this.maintenance.id) return;

                        // Note: Using DELETE standard, but based on your API prompt, assumes endpoint exists
                        // Or standard update status to 'cancelled'
                        await this.apiCall(`/api/maintenance/${this.maintenance.id}`, 'DELETE', {});

                        this.maintenance.isActive = false;
                        this.maintenance.id = null;
                        this.showToast('Maintenance Mode Deactivated', 'success');
                        this.addLog('Admin', 'Maintenance Ended', 'success');
                        return;
                    }

                    // CASE: Activate
                    if (this.maintenance.scope !== 'global' && !this.maintenance.target) {
                        this.showToast('Error: Target Selection Required', 'danger');
                        return;
                    }

                    const payload = {
                        type: this.maintenance.scope,
                        module: this.maintenance.scope === 'module' ? this.maintenance.target : null,
                        country_id: this.maintenance.scope === 'region' ? this.maintenance.target : null,
                        reason: this.maintenance.reason,
                        user_message: this.maintenance.user_message,
                        starts_at: new Date().toISOString().slice(0, 19).replace('T', ' '), // MySQL format
                        status: 'active',
                        created_by: 1 // Assuming logged in user ID is handled by backend or passed here
                    };

                    const response = await this.apiCall('/api/maintenance', 'POST', payload);

                    if (response) {
                        this.maintenance.isActive = true;
                        this.maintenance.id = response.id; // Capture ID from response
                        this.showToast('Maintenance Mode Activated', 'warning');
                        this.addLog('Admin', `Maintenance Started: ${this.maintenance.scope}`, 'warning');
                    }
                },

                // 2. Kill Switch Logic
                openKillModal(service, type) {
                    this.killModal = {
                        open: true,
                        serviceId: service.id, // scope name
                        serviceName: service.name,
                        type: type,
                        justification: '',
                        admin2Pass: '',
                        aiLoaded: false,
                        ai: {}
                    };

                    // Fake AI delay
                    setTimeout(() => {
                        this.killModal.ai = {
                            impactUsers: Math.floor(Math.random() * 5000) + 500,
                            revenueLoss: '$' + (Math.floor(Math.random() * 50) + 10) + ',000',
                            riskLevel: Math.random() > 0.5 ? 'High' : 'Critical'
                        };
                        this.killModal.aiLoaded = true;
                    }, 1000);
                },

                async executeKill() {
                    const payload = {
                        scope: this.killModal.serviceId, // Maps to DB enum
                        type: this.killModal.type, // soft / hard
                        reason: this.killModal.justification,
                        created_by: 1 // Replace with auth()->id()
                    };

                    const response = await this.apiCall('/api/kill/switch', 'POST', payload);

                    if (response) {
                        // Update UI State
                        const service = this.services.find(s => s.id === this.killModal.serviceId);
                        if (service) {
                            service.status = this.killModal.type;
                            service.latency = 0;
                        }

                        this.killModal.open = false;
                        this.addLog('Admin', `Kill Switch Executed: ${service.name}`, 'danger');
                        this.showToast(`${service.name} Killed Successfully`, 'danger');
                    }
                },

                // 3. Emergency Override Logic
                async toggleOverride() {
                    if (this.override.active) {
                        // Terminate
                        await this.apiCall('/api/emergency-override/terminate', 'POST', {});
                        this.override.active = false;
                        clearInterval(this.override.timer);
                        this.addLog('Admin', 'Override Session Terminated', 'info');
                        this.showToast('Secure Session Closed', 'info');
                    } else {
                        // Activate
                        const response = await this.apiCall('/api/emergency-override/activate', 'POST', {
                            reason: 'Critical Intervention'
                        });

                        if (response) {
                            this.override.active = true;
                            this.override.timeLeft = 300;
                            this.addLog('Admin', 'ROOT OVERRIDE GRANTED', 'danger');
                            this.showToast('Emergency Access Granted', 'danger');

                            this.override.timer = setInterval(() => {
                                if (this.override.timeLeft <= 0) this.toggleOverride();
                                else this.override.timeLeft--;
                            }, 1000);
                        }
                    }
                },

                // 4. Data Fetching Helpers
                async fetchMaintenanceStatus() {
                    // Fetches list and checks if any is active
                    const data = await this.apiCall('/api/maintenance', 'GET');
                    if (data && data.data) {
                        const active = data.data.find(m => m.status === 'active');
                        if (active) {
                            this.maintenance.isActive = true;
                            this.maintenance.id = active.id;
                            this.maintenance.scope = active.type;
                            this.maintenance.reason = active.reason;
                            this.maintenance.target = active.module || active.country_id;
                        }
                    }
                },

                async fetchAuditLogs() {
                    // Assuming the logs endpoint returns data
                    const data = await this.apiCall('/api/emergency-override/logs', 'GET');
                    if (data && Array.isArray(data)) {
                        // Map backend log format to frontend UI format
                        this.logs = data.map(log => ({
                            id: log.id,
                            time: new Date(log.created_at).toLocaleTimeString(),
                            admin: 'Admin ' + log.admin_id,
                            action: log.action,
                            type: 'info' // You can map this based on action keywords
                        }));
                    }
                },

                // ==========================================
                // GENERIC API HANDLER
                // ==========================================
                async apiCall(url, method, body = null) {
                    this.isLoading = true;
                    this.loadingMessage = `Requesting ${method}...`;

                    try {
                        const options = {
                            method: method,
                            headers: {
                                'Content-Type': 'application/json',
                                'Accept': 'application/json',
                                'X-CSRF-TOKEN': this.csrfToken()
                            }
                        };

                        if (body && method !== 'GET') {
                            options.body = JSON.stringify(body);
                            this.lastPayload = body; // Update preview box
                        }

                        const req = await fetch(url, options);
                        const res = await req.json();

                        if (!req.ok) throw new Error(res.message || 'API Error');

                        this.isLoading = false;
                        return res;

                    } catch (error) {
                        this.isLoading = false;
                        console.error('API Error:', error);
                        this.showToast(error.message, 'danger');
                        this.addLog('System', `Error: ${error.message}`, 'danger');
                        return null;
                    }
                },

                // ==========================================
                // UI HELPERS
                // ==========================================
                refreshServices() {
                    this.fetchMaintenanceStatus();
                    this.showToast('Status Synced', 'info');
                },

                formatTimer() {
                    const m = Math.floor(this.override.timeLeft / 60);
                    const s = this.override.timeLeft % 60;
                    return `${m.toString().padStart(2, '0')}:${s.toString().padStart(2, '0')}`;
                },

                addLog(admin, action, type) {
                    const now = new Date();
                    const time = now.toLocaleTimeString('en-US', {
                        hour12: false
                    });
                    this.logs.unshift({
                        id: Date.now(),
                        time,
                        admin,
                        action,
                        type
                    });
                    if (this.logs.length > 50) this.logs.pop();
                },

                showToast(msg, type) {
                    this.toast.message = msg;
                    this.toast.type = type;
                    this.toast.show = true;
                    setTimeout(() => this.toast.show = false, 3000);
                },

                copyPayload() {
                    navigator.clipboard.writeText(JSON.stringify(this.lastPayload, null, 2));
                    this.showToast('Payload copied to clipboard', 'info');
                }
            };
        }
    </script>

