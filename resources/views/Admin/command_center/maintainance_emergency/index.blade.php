@extends('layouts.app')

@section('content')
    {{-- 
    ==========================================================================
    MODULE 1.4: MAINTENANCE & EMERGENCY OPS
    ==========================================================================
    --}}

    <div class="min-h-screen theme-bg-body theme-text-main p-6 font-sans relative overflow-hidden" 
         x-data="emergencySystem()">

        {{-- GLOBAL LOADING OVERLAY --}}
        <div x-show="isLoading" 
             x-transition.opacity
             class="fixed inset-0 bg-black/80 z-[60] flex flex-col items-center justify-center backdrop-blur-sm"
             style="display: none;">
            <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-red-500 mb-4"></div>
            <div class="text-xs theme-text-muted font-mono animate-pulse" x-text="loadingMessage">Processing...</div>
        </div>

        {{-- EMERGENCY OVERRIDE VISUAL ALERT --}}
        <div x-show="override.active" 
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 scale-90"
             x-transition:enter-end="opacity-100 scale-100"
             class="absolute inset-0 border-[8px] border-red-600/30 z-0 pointer-events-none animate-pulse"
             style="display: none;">
        </div>

        {{-- TOAST NOTIFICATION --}}
        <div x-show="toast.show" 
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 translate-x-8"
             x-transition:enter-end="opacity-100 translate-x-0"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 translate-x-0"
             x-transition:leave-end="opacity-0 translate-x-8"
             class="fixed top-6 right-6 z-[70] theme-bg-card border-l-4 p-4 rounded shadow-2xl flex items-center gap-3 min-w-[300px]"
             :class="toast.type === 'success' ? 'border-green-500' : (toast.type === 'danger' ? 'border-red-500' : 'border-blue-500')"
             style="display: none;">
            <div x-text="toast.message" class="text-sm font-semibold theme-text-main"></div>
        </div>

        {{-- HEADER --}}
        <div class="relative z-10 flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4 border-b theme-border pb-6">
            <div>
                <h1 class="text-3xl font-bold tracking-tight theme-text-main flex items-center gap-3">
                    <div class="p-2 bg-red-500/10 rounded-lg text-red-500 border border-red-500/30">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
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
                    :class="override.active ? 'bg-red-600 hover:bg-red-700 animate-pulse border-red-500 shadow-red-900/50' : 'theme-bg-card theme-border hover:bg-white/5'"
                    class="group border px-5 py-3 rounded-lg transition-all flex items-center gap-3 shadow-lg">
                    <div :class="override.active ? 'bg-white text-red-600' : 'bg-gray-700 text-gray-400'"
                        class="p-1.5 rounded-md transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path>
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
                    <div class="p-5 border-b theme-border flex justify-between items-center" style="background-color: rgba(var(--bg-body), 0.5);">
                        <h3 class="font-bold theme-text-main flex items-center gap-2">
                            <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
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
                                <button @click="maintenance.scope = 'global'"
                                    :class="maintenance.scope === 'global' ? 'bg-gray-700 text-white shadow' : 'text-gray-500 hover:text-gray-300'"
                                    class="py-1.5 text-xs font-medium rounded transition">Global</button>
                                <button @click="maintenance.scope = 'module'"
                                    :class="maintenance.scope === 'module' ? 'bg-gray-700 text-white shadow' : 'text-gray-500 hover:text-gray-300'"
                                    class="py-1.5 text-xs font-medium rounded transition">Module</button>
                                <button @click="maintenance.scope = 'region'"
                                    :class="maintenance.scope === 'region' ? 'bg-gray-700 text-white shadow' : 'text-gray-500 hover:text-gray-300'"
                                    class="py-1.5 text-xs font-medium rounded transition">Region</button>
                            </div>
                        </div>

                        {{-- Dynamic Selects --}}
                        <div x-show="maintenance.scope === 'module'" x-transition style="display: none;">
                            <label class="block text-xs theme-text-muted mb-1">Target Module</label>
                            <select x-model="maintenance.target"
                                class="w-full theme-bg-body border theme-border rounded-lg text-sm px-3 py-2 theme-text-main focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                                <option value="" disabled selected>Select Module</option>
                                <template x-for="mod in mockData.modules" :key="mod.id">
                                    <option :value="mod.id" x-text="mod.name"></option>
                                </template>
                            </select>
                        </div>

                        <div x-show="maintenance.scope === 'region'" x-transition style="display: none;">
                            <label class="block text-xs theme-text-muted mb-1">Target Region</label>
                            <select x-model="maintenance.target"
                                class="w-full theme-bg-body border theme-border rounded-lg text-sm px-3 py-2 theme-text-main focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                                <option value="" disabled selected>Select Region</option>
                                <template x-for="reg in mockData.regions" :key="reg.id">
                                    <option :value="reg.id" x-text="reg.name"></option>
                                </template>
                            </select>
                        </div>

                        {{-- Reason --}}
                        <div>
                            <label class="block text-xs font-semibold theme-text-muted uppercase mb-2">Reason Code</label>
                            <select x-model="maintenance.reason"
                                class="w-full theme-bg-body border theme-border rounded-lg text-sm px-3 py-2 mb-3 theme-text-main focus:border-blue-500">
                                <option value="scheduled">Scheduled Maintenance (Standard)</option>
                                <option value="emergency">Emergency Patch (Critical)</option>
                                <option value="performance">Database Optimization</option>
                                <option value="compliance">Compliance Audit (Locked)</option>
                            </select>

                            <div class="bg-blue-900/20 border border-blue-500/30 p-3 rounded-lg">
                                <p class="text-[10px] text-blue-400 uppercase font-bold mb-1">Notice Preview</p>
                                <p class="text-xs text-gray-300 italic">
                                    "System <span x-text="maintenance.scope"></span> is under <span x-text="maintenance.reason"></span>."
                                </p>
                            </div>
                        </div>

                        {{-- Actions --}}
                        <div class="grid grid-cols-2 gap-3 pt-2">
                            <button
                                class="px-4 py-2 text-xs font-bold theme-text-muted hover:bg-white/5 rounded-lg border theme-border transition">
                                Schedule Later
                            </button>
                            <button @click="toggleMaintenance()"
                                class="px-4 py-2 text-xs font-bold text-white rounded-lg shadow-lg transition flex justify-center"
                                :class="maintenance.isActive ? 'bg-red-600 hover:bg-red-500' : 'bg-blue-600 hover:bg-blue-500'">
                                <span x-text="maintenance.isActive ? 'Deactivate Mode' : 'Activate Mode'"></span>
                            </button>
                        </div>
                    </div>
                </div>

                {{-- LIVE AUDIT LOG --}}
                <div class="theme-bg-card rounded-xl border theme-border shadow-lg overflow-hidden flex flex-col h-64">
                    <div class="p-4 border-b theme-border flex justify-between items-center" style="background-color: rgba(var(--bg-body), 0.5);">
                        <h3 class="font-bold theme-text-main text-sm">Live Audit Trail</h3>
                        <div class="flex items-center gap-2">
                            <span class="relative flex h-2 w-2">
                                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                                <span class="relative inline-flex rounded-full h-2 w-2 bg-green-500"></span>
                            </span>
                            <span class="text-[10px] text-gray-500">WS Connected</span>
                        </div>
                    </div>
                    <div class="flex-1 overflow-y-auto custom-scrollbar p-2" id="logs-container">
                        <table class="w-full text-left text-[10px]">
                            <tbody class="divide-y" style="border-color: rgba(var(--border-color), 0.5);">
                                <template x-for="log in logs" :key="log.id">
                                    <tr class="hover:bg-white/5 transition">
                                        <td class="p-2 text-gray-400 font-mono whitespace-nowrap" x-text="log.time"></td>
                                        <td class="p-2 theme-text-main font-bold" x-text="log.admin"></td>
                                        <td class="p-2">
                                            <span class="px-1.5 py-0.5 rounded border inline-block w-full text-center"
                                                :class="{
                                                    'bg-red-500/10 border-red-500/30 text-red-400': log.type === 'danger',
                                                    'bg-yellow-500/10 border-yellow-500/30 text-yellow-400': log.type === 'warning',
                                                    'bg-blue-500/10 border-blue-500/30 text-blue-400': log.type === 'info',
                                                    'bg-green-500/10 border-green-500/30 text-green-400': log.type === 'success'
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
                    <div class="p-5 border-b theme-border flex justify-between items-center" style="background-color: rgba(var(--bg-body), 0.5);">
                        <div>
                            <h3 class="font-bold theme-text-main flex items-center gap-2 text-lg">
                                <svg class="w-6 h-6 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"></path>
                                </svg>
                                Service Kill Switches
                            </h3>
                            <p class="text-xs theme-text-muted mt-1">
                                Status: <span class="theme-text-main font-mono" x-text="services.filter(s => s.status === 'operational').length"></span>/<span x-text="services.length"></span> Operational
                            </p>
                        </div>
                        
                        {{-- SYNC BUTTON --}}
                        <div class="text-right">
                            <button @click="refreshServices()" class="text-xs text-blue-400 hover:text-blue-300 flex items-center gap-1">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                </svg>
                                Sync Status
                            </button>
                        </div>
                    </div>

                    <div class="p-6 flex-1 overflow-y-auto">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                            {{-- Dynamic Service Cards --}}
                            <template x-for="service in services" :key="service.id">
                                <div class="theme-bg-body border theme-border rounded-lg p-4 relative overflow-hidden group hover:border-gray-500 transition-all">
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
                                            <div class="text-[10px] text-gray-500 font-mono" x-text="'PID: ' + (2000 + service.id)"></div>
                                            <div class="text-[10px] theme-text-muted" x-text="service.latency + 'ms'"></div>
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
                                            <span x-text="service.status === 'soft' ? 'Graceful Shutdown' : 'Soft Kill'"></span>
                                        </button>

                                        {{-- Hard Kill Logic --}}
                                        <button @click="openKillModal(service, 'hard')"
                                            :disabled="service.status === 'hard' || !override.active"
                                            class="py-2 px-3 rounded text-xs font-bold transition disabled:opacity-40 disabled:cursor-not-allowed border"
                                            :class="service.status === 'hard' ? 
                                                'bg-red-500/10 text-red-500 border-red-500/30' :
                                                'bg-red-500/20 text-red-500 border-red-500/30 hover:bg-red-600 hover:text-white'">
                                            <span x-text="service.status === 'hard' ? 'Process Killed' : 'Hard Kill'"></span>
                                        </button>
                                    </div>
                                    
                                    {{-- Lock Hint --}}
                                    <div x-show="!override.active" class="absolute inset-0 bg-gray-900/60 flex items-center justify-center backdrop-blur-[1px] opacity-0 group-hover:opacity-100 transition-opacity">
                                        <div class="theme-bg-card text-xs text-red-400 px-3 py-1 rounded border border-red-500/30 flex items-center gap-2">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
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
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            style="display: none;">

            <div class="theme-bg-card w-full max-w-2xl rounded-2xl border border-red-500/50 shadow-2xl relative overflow-hidden"
                @click.away="killModal.open = false">

                <div class="h-2 w-full bg-stripes-red"></div>

                <div class="p-8">
                    <div class="flex items-start gap-4 mb-6">
                        <div class="p-3 bg-red-500/20 rounded-full border border-red-500/50">
                            <svg class="w-8 h-8 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-2xl font-bold theme-text-main">Confirm <span x-text="killModal.type"></span> Kill</h2>
                            <p class="theme-text-muted text-sm mt-1">Target: <strong class="text-white" x-text="killModal.serviceName"></strong></p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        {{-- AI Blast Radius --}}
                        <div class="col-span-2 theme-bg-body rounded-lg border theme-border p-4 relative overflow-hidden">
                             {{-- AI SCAN LINE ANIMATION --}}
                            <div x-show="!killModal.aiLoaded" class="absolute top-0 left-0 w-full h-[2px] bg-purple-500 shadow-[0_0_15px_#a855f7] animate-scan"></div>
                            
                            <div class="flex items-center justify-between mb-3">
                                <span class="text-xs font-bold text-purple-400 uppercase flex items-center gap-1">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.384-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path>
                                    </svg>
                                    Blast Radius AI
                                </span>
                                <div x-show="!killModal.aiLoaded" class="text-[10px] text-gray-500 animate-pulse">Running Monte Carlo simulation...</div>
                            </div>
                            
                            <div x-show="killModal.aiLoaded" class="grid grid-cols-3 gap-4 text-center" 
                                x-transition:enter="transition ease-out duration-500"
                                x-transition:enter-start="opacity-0 translate-y-2"
                                x-transition:enter-end="opacity-100 translate-y-0"
                                style="display: none;">
                                <div>
                                    <div class="text-2xl font-mono font-bold theme-text-main" x-text="killModal.ai.impactUsers"></div>
                                    <div class="text-[10px] text-gray-500 uppercase">Impacted Users</div>
                                </div>
                                <div>
                                    <div class="text-2xl font-mono font-bold theme-text-main" x-text="killModal.ai.revenueLoss"></div>
                                    <div class="text-[10px] text-gray-500 uppercase">Est. Revenue Loss</div>
                                </div>
                                <div>
                                    <div class="text-2xl font-mono font-bold" 
                                        :class="killModal.ai.riskLevel === 'High' ? 'text-red-400' : 'text-yellow-400'"
                                        x-text="killModal.ai.riskLevel"></div>
                                    <div class="text-[10px] text-gray-500 uppercase">Risk Level</div>
                                </div>
                            </div>
                        </div>

                        <div class="col-span-2">
                            <label class="block text-xs theme-text-muted mb-1">Mandatory Justification</label>
                            <textarea x-model="killModal.justification" placeholder="Reason for intervention..."
                                class="w-full theme-bg-body border theme-border rounded-lg p-3 text-sm focus:border-red-500 focus:ring-1 focus:ring-red-500 theme-text-main h-20 resize-none"></textarea>
                        </div>

                        <div>
                            <label class="block text-xs theme-text-muted mb-1">Admin 2 Approval</label>
                            <input type="password" x-model="killModal.admin2Pass" placeholder="Enter 'root'"
                                class="w-full theme-bg-body border border-red-500/50 rounded-lg p-2 text-sm theme-text-main focus:ring-1 focus:ring-red-500">
                        </div>
                    </div>

                    <div class="flex justify-end gap-3 pt-4 border-t theme-border">
                        <button @click="killModal.open = false" class="px-5 py-2 text-sm theme-text-muted hover:text-white transition">Cancel</button>
                        <button @click="executeKill()"
                            :disabled="!killModal.admin2Pass || !killModal.justification || !killModal.aiLoaded"
                            class="px-6 py-2 bg-red-600 hover:bg-red-700 disabled:bg-gray-700 disabled:text-gray-500 text-white font-bold rounded-lg shadow-lg transition flex items-center gap-2">
                            <span x-show="isLoading" class="animate-spin h-4 w-4 border-2 border-white border-t-transparent rounded-full"></span>
                            Confirm Kill
                        </button>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <style>
        /* Specific styles for this module not covered by global theme */
        .bg-stripes-red { background-image: linear-gradient(45deg, #ef4444 25%, #7f1d1d 25%, #7f1d1d 50%, #ef4444 50%, #ef4444 75%, #7f1d1d 75%, #7f1d1d 100%); background-size: 20px 20px; }
        @keyframes scan { 0% { top: 0; } 100% { top: 100%; } }
        .animate-scan { animation: scan 1.5s linear infinite; }
    </style>
@endsection

@push('scripts')
<script>
    // CRITICAL FIX: Define directly on window so Alpine can find it regardless of load order
    window.emergencySystem = function() {
        return {
            // ==========================================
            // STATE MANAGEMENT
            // ==========================================
            isLoading: false,
            loadingMessage: 'Processing...',
            lastPayload: { "info": "Interact with UI to generate payload" },
            
            mockData: {
                modules: [
                    { id: 101, name: 'Billing Service' },
                    { id: 102, name: 'Logistics API' },
                    { id: 103, name: 'Auth Server' }
                ],
                regions: [
                    { id: 'pk', name: 'Asia Pacific (PK)' },
                    { id: 'us', name: 'North America (US-East)' },
                    { id: 'eu', name: 'Europe (Frankfurt)' }
                ]
            },

            maintenance: {
                scope: 'global',
                target: '',
                reason: 'scheduled',
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

            services: [
                { id: 1, name: 'Payment Gateway', status: 'operational', latency: 45 },
                { id: 2, name: 'Order Processing', status: 'operational', latency: 120 },
                { id: 3, name: 'Payout Service', status: 'soft', latency: 0 },
                { id: 4, name: 'Notifications', status: 'operational', latency: 32 },
                { id: 5, name: 'User Auth', status: 'operational', latency: 15 },
                { id: 6, name: 'Inventory Sync', status: 'hard', latency: 0 }
            ],

            logs: [
                { id: 1, time: '14:20:01', admin: 'System', action: 'Handshake Established', type: 'info' }
            ],

            killModal: {
                open: false,
                serviceId: null,
                serviceName: '',
                type: '',
                justification: '',
                admin2Pass: '',
                aiLoaded: false,
                ai: {}
            },

            // ==========================================
            // LIFECYCLE (Renamed to 'init' for Alpine auto-detection)
            // ==========================================
            init() {
                this.simulateApiCall('Initializing Control Plane...', () => {
                    this.addLog('System', 'WS Connection: Stable', 'success');
                    this.showToast('Control Plane Connected', 'success');
                });
                
                // Simulate latency fluctuation
                setInterval(() => {
                    this.services.forEach(s => {
                        if(s.status === 'operational') {
                            s.latency = Math.max(10, Math.floor(s.latency + (Math.random() * 20 - 10)));
                        }
                    });
                }, 2000);
            },

            // ==========================================
            // ACTIONS
            // ==========================================
            toggleMaintenance() {
                // Validation
                if (this.maintenance.scope !== 'global' && !this.maintenance.target) {
                    this.showToast('Error: Target Selection Required', 'danger');
                    return;
                }

                // Payload generation
                const payload = {
                    endpoint: '/api/admin/maintenance/update',
                    method: 'POST',
                    body: {
                        scope: this.maintenance.scope,
                        target_id: this.maintenance.target,
                        status: this.maintenance.isActive ? 'scheduled' : 'active', 
                        reason: this.maintenance.reason
                    }
                };
                this.lastPayload = payload;

                this.simulateApiCall('Updating Propagation Servers...', () => {
                    this.maintenance.isActive = !this.maintenance.isActive;
                    const msg = this.maintenance.isActive ? 'Maintenance Mode ACTIVE' : 'Maintenance Mode DISABLED';
                    this.addLog('Admin_01', msg, 'warning');
                    this.showToast(msg, this.maintenance.isActive ? 'warning' : 'success');
                });
            },

            toggleOverride() {
                if (this.override.active) {
                    this.override.active = false;
                    clearInterval(this.override.timer);
                    this.override.timeLeft = 300;
                    this.addLog('Admin_01', 'Emergency Override Disengaged', 'info');
                    this.lastPayload = { endpoint: '/api/admin/emergency/terminate', method: 'POST' };
                } else {
                    // Simulate MFA Check
                    this.simulateApiCall('Verifying MFA Token...', () => {
                        this.override.active = true;
                        this.addLog('Admin_01', 'ROOT OVERRIDE GRANTED', 'danger');
                        this.showToast('Emergency Protocols Unlocked', 'danger');
                        
                        this.override.timer = setInterval(() => {
                            if (this.override.timeLeft <= 0) this.toggleOverride();
                            else this.override.timeLeft--;
                        }, 1000);
                        
                        this.lastPayload = { endpoint: '/api/admin/emergency/override', method: 'POST', body: { mfa_token: '***' } };
                    });
                }
            },

            refreshServices() {
                this.simulateApiCall('Syncing Service Status...', () => {
                   this.showToast('Services Synced', 'info');
                });
            },

            // ==========================================
            // KILL SWITCH LOGIC
            // ==========================================
            openKillModal(service, type) {
                this.killModal = {
                    open: true,
                    serviceId: service.id,
                    serviceName: service.name,
                    type: type,
                    justification: '',
                    admin2Pass: '',
                    aiLoaded: false,
                    ai: {}
                };

                // Simulate AI Impact Calculation API
                setTimeout(() => {
                    this.killModal.ai = {
                        impactUsers: Math.floor(Math.random() * 5000) + 500,
                        revenueLoss: '$' + (Math.floor(Math.random() * 50) + 10) + ',000',
                        riskLevel: Math.random() > 0.5 ? 'High' : 'Critical'
                    };
                    this.killModal.aiLoaded = true;
                }, 1500);
            },

            executeKill() {
                // Prepare Payload
                const payload = {
                    endpoint: `/api/admin/kill-switch/${this.killModal.serviceId}`,
                    method: 'POST',
                    body: {
                        action: this.killModal.type + '_kill',
                        justification: this.killModal.justification,
                        auth_hash: 'sha256(***)' 
                    }
                };
                this.lastPayload = payload;

                // Simulate API Call
                this.isLoading = true;
                this.loadingMessage = `EXECUTING ${this.killModal.type.toUpperCase()} KILL...`;
                
                setTimeout(() => {
                    const service = this.services.find(s => s.id === this.killModal.serviceId);
                    if (service) {
                        service.status = this.killModal.type; 
                        service.latency = 0;
                    }
                    this.killModal.open = false;
                    this.isLoading = false;
                    
                    this.addLog('Admin_01', `${this.killModal.type.toUpperCase()} KILL: ${service.name}`, 'danger');
                    this.showToast(`${service.name} has been stopped`, 'danger');
                }, 1000);
            },

            // ==========================================
            // HELPERS
            // ==========================================
            simulateApiCall(msg, callback) {
                this.loadingMessage = msg;
                this.isLoading = true;
                setTimeout(() => {
                    this.isLoading = false;
                    callback();
                }, 800);
            },

            formatTimer() {
                const m = Math.floor(this.override.timeLeft / 60);
                const s = this.override.timeLeft % 60;
                return `${m.toString().padStart(2, '0')}:${s.toString().padStart(2, '0')}`;
            },

            addLog(admin, action, type) {
                const now = new Date();
                const time = now.getHours().toString().padStart(2, '0') + ':' + 
                             now.getMinutes().toString().padStart(2, '0') + ':' + 
                             now.getSeconds().toString().padStart(2, '0');
                
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
                this.showToast('Payload copied to clipboard', 'info');
            }
        };
    }
</script>
@endpushz