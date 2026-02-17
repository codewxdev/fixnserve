@extends('layouts.app')

@section('title', 'Device Security')

@section('content')
    <div class="min-h-screen theme-bg-body theme-text-main max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
            <div>
                <h1 class="text-2xl font-bold theme-text-main">Device Trust & Fingerprinting</h1>
                <p class="theme-text-muted mt-1">Manage recognized devices and enforce hardware-level security policies.</p>
            </div>
            <div class="flex gap-3">
                <button class="flex items-center gap-2 px-4 py-2 theme-bg-card border theme-border rounded-lg text-sm font-medium hover:bg-white/5 theme-text-main transition-colors shadow-sm">
                    <i data-lucide="download" class="w-4 h-4"></i> 
                    <span>Export Device Log</span>
                </button>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
            
            {{-- TRUST POLICIES CARD --}}
            <div class="lg:col-span-2 theme-bg-card rounded-xl shadow-sm border theme-border overflow-hidden">
                <div class="px-6 py-4 border-b theme-border flex justify-between items-center" style="background-color: rgba(var(--bg-body), 0.5);">
                    <h3 class="font-semibold theme-text-main flex items-center gap-2">
                        <i data-lucide="shield-check" class="w-4 h-4" style="color: rgb(var(--brand-primary));"></i> Trust Policies
                    </h3>
                    <span class="text-xs font-medium text-green-500 bg-green-500/10 border border-green-500/20 px-2 py-1 rounded">ENFORCED</span>
                </div>
                <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                    
                    <div>
                        <label class="block text-sm font-medium theme-text-muted mb-2">Max Trusted Devices per User</label>
                        <select class="w-full theme-bg-body border theme-border rounded-lg text-sm theme-text-main focus:ring-2 focus:ring-blue-500 p-2.5">
                            <option value="1">1 (Strict)</option>
                            <option value="3" selected>3 (Standard)</option>
                            <option value="5">5 (Relaxed)</option>
                            <option value="99">Unlimited (Not Recommended)</option>
                        </select>
                        <p class="text-xs theme-text-muted mt-1">Oldest device revoked when limit reached.</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium theme-text-muted mb-2">Trust Expiration</label>
                        <div class="relative">
                            <input type="number" value="30" class="w-full pl-3 pr-12 py-2 theme-bg-body border theme-border rounded-lg text-sm theme-text-main focus:ring-2 focus:ring-blue-500">
                            <span class="absolute right-3 top-2 theme-text-muted text-sm">days</span>
                        </div>
                        <p class="text-xs theme-text-muted mt-1">Require re-verification after inactivity.</p>
                    </div>

                    <div class="md:col-span-2 space-y-3 pt-4 border-t theme-border">
                        <label class="flex items-center justify-between cursor-pointer">
                            <span class="text-sm font-medium theme-text-main">Block Rooted / Jailbroken Devices (Mobile)</span>
                            <div class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" checked class="sr-only peer toggle-checkbox">
                                <div class="toggle-bg w-11 h-6 bg-gray-600/30 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all"></div>
                            </div>
                        </label>
                        <label class="flex items-center justify-between cursor-pointer">
                            <span class="text-sm font-medium theme-text-main">Require Email OTP for New Unknown Devices</span>
                            <div class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" checked class="sr-only peer toggle-checkbox">
                                <div class="toggle-bg w-11 h-6 bg-gray-600/30 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all"></div>
                            </div>
                        </label>
                    </div>
                </div>
            </div>

            {{-- DEVICE INSIGHTS CARD (Gradient) --}}
            <div class="rounded-xl shadow-lg p-6 text-white flex flex-col justify-between border theme-border" 
                 style="background: linear-gradient(135deg, rgb(var(--brand-primary)), rgb(var(--brand-secondary)));">
                <div>
                    <h3 class="text-lg font-semibold flex items-center gap-2 mb-4">
                        <i data-lucide="smartphone" class="w-5 h-5 text-white/80"></i> Device Insights
                    </h3>
                    <div class="space-y-4">
                        <div class="flex justify-between items-center border-b border-white/20 pb-2">
                            <span class="text-white/70 text-sm">Total Recognized</span>
                            <span class="text-xl font-bold">1,240</span>
                        </div>
                        <div class="flex justify-between items-center border-b border-white/20 pb-2">
                            <span class="text-white/70 text-sm">Untrusted / New</span>
                            <span class="text-xl font-bold text-yellow-300">45</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-white/70 text-sm">Banned Fingerprints</span>
                            <span class="text-xl font-bold text-red-300">12</span>
                        </div>
                    </div>
                </div>
                <div class="mt-6 text-xs text-white/80 bg-black/20 p-3 rounded border border-white/10">
                    <i data-lucide="info" class="inline w-3 h-3 mr-1"></i>
                    Device fingerprinting uses hardware canvas, audio context, and screen resolution to create a unique ID.
                </div>
            </div>
        </div>

        {{-- DEVICE INVENTORY TABLE --}}
        <div class="theme-bg-card rounded-xl shadow-sm border theme-border overflow-hidden">
            <div class="p-4 border-b theme-border flex flex-col md:flex-row justify-between items-center gap-4">
                <h3 class="font-semibold theme-text-main">Device Inventory</h3>
                
                <div class="relative w-full max-w-md">
                    <i data-lucide="search" class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 theme-text-muted"></i>
                    <input type="text" placeholder="Search by User Email, Fingerprint Hash, or IP..." 
                        class="pl-10 w-full theme-bg-body border theme-border rounded-lg text-sm theme-text-main focus:ring-2 focus:ring-blue-500 placeholder-gray-500">
                </div>
            </div>
            
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead class="theme-text-muted font-semibold uppercase text-xs" style="background-color: rgba(var(--bg-body), 0.5);">
                        <tr>
                            <th class="px-6 py-3">Device / Fingerprint</th>
                            <th class="px-6 py-3">User</th>
                            <th class="px-6 py-3">Trust Status</th>
                            <th class="px-6 py-3">Last Seen / IP</th>
                            <th class="px-6 py-3 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y theme-border" style="border-color: rgb(var(--border-color));">
                        
                        <tr class="hover:bg-white/5 transition-colors">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded theme-bg-body flex items-center justify-center theme-text-muted border theme-border">
                                        <i data-lucide="laptop" class="w-5 h-5"></i>
                                    </div>
                                    <div>
                                        <div class="font-medium theme-text-main">MacBook Pro (M1)</div>
                                        <div class="text-[10px] font-mono theme-text-muted uppercase">FP: 8a2c...91x0</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="font-medium theme-text-main">Javed Baloch</div>
                                <div class="text-xs theme-text-muted">javedbaloch@gmail.com</div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-500/10 text-green-500 border border-green-500/20">
                                    <i data-lucide="check-circle" class="w-3 h-3"></i> Trusted
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="theme-text-main">2 mins ago</div>
                                <div class="text-xs theme-text-muted font-mono">192.168.1.5</div>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <button class="text-red-500 hover:text-red-400 text-xs font-bold border border-red-500/30 hover:border-red-500 rounded px-2 py-1 transition-colors">REVOKE</button>
                            </td>
                        </tr>

                        <tr class="hover:bg-white/5 transition-colors" style="background-color: rgba(234, 179, 8, 0.05);">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded bg-yellow-500/10 flex items-center justify-center text-yellow-500 border border-yellow-500/20">
                                        <i data-lucide="smartphone" class="w-5 h-5"></i>
                                    </div>
                                    <div>
                                        <div class="font-medium theme-text-main">iPhone 14 (iOS 17)</div>
                                        <div class="text-[10px] font-mono theme-text-muted uppercase">FP: 3b1z...88q1</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="font-medium theme-text-main">Sarah Khan</div>
                                <div class="text-xs theme-text-muted">sarah@example.com</div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-500/10 text-yellow-500 border border-yellow-500/20">
                                    <i data-lucide="help-circle" class="w-3 h-3"></i> Unverified
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="theme-text-main">1 day ago</div>
                                <div class="text-xs theme-text-muted font-mono">10.0.0.42</div>
                            </td>
                            <td class="px-6 py-4 text-right flex justify-end gap-2">
                                <button class="hover:underline text-xs font-bold" style="color: rgb(var(--brand-primary));">Trust</button>
                                <button class="theme-text-muted hover:text-red-500 text-xs font-bold hover:underline">Ban</button>
                            </td>
                        </tr>

                        <tr class="hover:bg-red-500/10 transition-colors" style="background-color: rgba(239, 68, 68, 0.05);">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded bg-red-500/10 flex items-center justify-center text-red-500 border border-red-500/20">
                                        <i data-lucide="shield-alert" class="w-5 h-5"></i>
                                    </div>
                                    <div>
                                        <div class="font-medium theme-text-main">Unknown Windows PC</div>
                                        <div class="text-[10px] font-mono theme-text-muted uppercase">FP: 9x9x...BAD1</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="font-medium theme-text-main">Multiple Users</div>
                                <div class="text-xs text-red-500 font-bold">Botnet Detected</div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-500/10 text-red-500 border border-red-500/20">
                                    <i data-lucide="ban" class="w-3 h-3"></i> Banned
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="theme-text-main">Feb 10, 2026</div>
                                <div class="text-xs theme-text-muted font-mono">VPN Exit Node</div>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <button class="theme-text-muted hover:theme-text-main text-xs hover:underline">Unban</button>
                            </td>
                        </tr>

                    </tbody>
                </table>
            </div>
            
            <div class="px-4 py-3 border-t theme-border flex items-center justify-between sm:px-6">
                <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
                    <div>
                        <p class="text-sm theme-text-muted">
                            Showing <span class="font-medium theme-text-main">1</span> to <span class="font-medium theme-text-main">10</span> of <span class="font-medium theme-text-main">1240</span> results
                        </p>
                    </div>
                    <div>
                        <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px" aria-label="Pagination">
                            <a href="#" class="relative inline-flex items-center px-2 py-2 rounded-l-md border theme-border theme-bg-card text-sm font-medium theme-text-muted hover:bg-white/5">Previous</a>
                            <a href="#" class="relative inline-flex items-center px-4 py-2 border theme-border text-sm font-medium text-white hover:bg-opacity-90" style="background-color: rgb(var(--brand-primary));">1</a>
                            <a href="#" class="relative inline-flex items-center px-4 py-2 border theme-border theme-bg-card text-sm font-medium theme-text-muted hover:bg-white/5">2</a>
                            <a href="#" class="relative inline-flex items-center px-2 py-2 rounded-r-md border theme-border theme-bg-card text-sm font-medium theme-text-muted hover:bg-white/5">Next</a>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://unpkg.com/lucide@latest"></script>
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            lucide.createIcons();
        });
    </script>
@endpush

@push('styles')
<style>
    /* Logic to make toggles adopt the Theme Brand Color */
    .toggle-checkbox:checked + .toggle-bg {
        background-color: rgb(var(--brand-primary));
    }
</style>
@endpush