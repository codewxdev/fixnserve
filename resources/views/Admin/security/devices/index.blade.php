@extends('layouts.app')

@section('title', 'Device Security')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
            <div>
                <h1 class="text-2xl font-bold text-slate-900">Device Trust & Fingerprinting</h1>
                <p class="text-slate-500 mt-1">Manage recognized devices and enforce hardware-level security policies.</p>
            </div>
            <div class="flex gap-3">
                <button class="flex items-center gap-2 px-4 py-2 bg-white border border-gray-300 rounded-lg text-sm font-medium hover:bg-gray-50 text-slate-700 transition-colors shadow-sm">
                    <i data-lucide="download" class="w-4 h-4"></i> 
                    <span>Export Device Log</span>
                </button>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
            <div class="lg:col-span-2 bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 bg-slate-50 flex justify-between items-center">
                    <h3 class="font-semibold text-slate-800 flex items-center gap-2">
                        <i data-lucide="shield-check" class="w-4 h-4 text-indigo-500"></i> Trust Policies
                    </h3>
                    <span class="text-xs font-medium text-green-600 bg-green-50 px-2 py-1 rounded">ENFORCED</span>
                </div>
                <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                    
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Max Trusted Devices per User</label>
                        <select class="w-full border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 text-sm">
                            <option value="1">1 (Strict)</option>
                            <option value="3" selected>3 (Standard)</option>
                            <option value="5">5 (Relaxed)</option>
                            <option value="99">Unlimited (Not Recommended)</option>
                        </select>
                        <p class="text-xs text-slate-400 mt-1">Oldest device revoked when limit reached.</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Trust Expiration</label>
                        <div class="relative">
                            <input type="number" value="30" class="w-full pl-3 pr-12 py-2 border border-gray-300 rounded-lg text-sm focus:ring-indigo-500 focus:border-indigo-500">
                            <span class="absolute right-3 top-2 text-slate-400 text-sm">days</span>
                        </div>
                        <p class="text-xs text-slate-400 mt-1">Require re-verification after inactivity.</p>
                    </div>

                    <div class="md:col-span-2 space-y-3 pt-2 border-t border-gray-100">
                        <label class="flex items-center justify-between cursor-pointer">
                            <span class="text-sm font-medium text-slate-700">Block Rooted / Jailbroken Devices (Mobile)</span>
                            <div class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" checked class="sr-only peer">
                                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-indigo-600"></div>
                            </div>
                        </label>
                        <label class="flex items-center justify-between cursor-pointer">
                            <span class="text-sm font-medium text-slate-700">Require Email OTP for New Unknown Devices</span>
                            <div class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" checked class="sr-only peer">
                                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:bg-indigo-600 after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all"></div>
                            </div>
                        </label>
                    </div>
                </div>
            </div>

            <div class="bg-indigo-900 rounded-xl shadow-lg p-6 text-white flex flex-col justify-between">
                <div>
                    <h3 class="text-lg font-semibold flex items-center gap-2 mb-4">
                        <i data-lucide="smartphone" class="w-5 h-5 text-indigo-400"></i> Device Insights
                    </h3>
                    <div class="space-y-4">
                        <div class="flex justify-between items-center border-b border-indigo-800 pb-2">
                            <span class="text-indigo-200 text-sm">Total Recognized</span>
                            <span class="text-xl font-bold">1,240</span>
                        </div>
                        <div class="flex justify-between items-center border-b border-indigo-800 pb-2">
                            <span class="text-indigo-200 text-sm">Untrusted / New</span>
                            <span class="text-xl font-bold text-yellow-400">45</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-indigo-200 text-sm">Banned Fingerprints</span>
                            <span class="text-xl font-bold text-red-400">12</span>
                        </div>
                    </div>
                </div>
                <div class="mt-6 text-xs text-indigo-300 bg-indigo-950/50 p-3 rounded border border-indigo-800">
                    <i data-lucide="info" class="inline w-3 h-3 mr-1"></i>
                    Device fingerprinting uses hardware canvas, audio context, and screen resolution to create a unique ID.
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="p-4 border-b border-gray-100 flex flex-col md:flex-row justify-between items-center gap-4">
                <h3 class="font-semibold text-slate-800">Device Inventory</h3>
                
                <div class="relative w-full max-w-md">
                    <i data-lucide="search" class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400"></i>
                    <input type="text" placeholder="Search by User Email, Fingerprint Hash, or IP..." class="pl-10 w-full border-gray-300 rounded-lg text-sm focus:ring-indigo-500 focus:border-indigo-500">
                </div>
            </div>
            
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-slate-600">
                    <thead class="bg-slate-50 text-slate-700 font-semibold uppercase text-xs">
                        <tr>
                            <th class="px-6 py-3">Device / Fingerprint</th>
                            <th class="px-6 py-3">User</th>
                            <th class="px-6 py-3">Trust Status</th>
                            <th class="px-6 py-3">Last Seen / IP</th>
                            <th class="px-6 py-3 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded bg-slate-100 flex items-center justify-center text-slate-500">
                                        <i data-lucide="laptop" class="w-5 h-5"></i>
                                    </div>
                                    <div>
                                        <div class="font-medium text-slate-900">MacBook Pro (M1)</div>
                                        <div class="text-[10px] font-mono text-slate-400 uppercase">FP: 8a2c...91x0</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="font-medium text-slate-900">Javed Baloch</div>
                                <div class="text-xs text-slate-500">javedbaloch@gmail.com</div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-700 border border-green-200">
                                    <i data-lucide="check-circle" class="w-3 h-3"></i> Trusted
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-slate-900">2 mins ago</div>
                                <div class="text-xs text-slate-400 font-mono">192.168.1.5</div>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <button class="text-red-600 hover:text-red-800 text-xs font-bold border border-red-200 hover:border-red-400 rounded px-2 py-1">REVOKE</button>
                            </td>
                        </tr>

                        <tr class="hover:bg-slate-50 transition-colors bg-yellow-50/30">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded bg-orange-100 flex items-center justify-center text-orange-600">
                                        <i data-lucide="smartphone" class="w-5 h-5"></i>
                                    </div>
                                    <div>
                                        <div class="font-medium text-slate-900">iPhone 14 (iOS 17)</div>
                                        <div class="text-[10px] font-mono text-slate-400 uppercase">FP: 3b1z...88q1</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="font-medium text-slate-900">Sarah Khan</div>
                                <div class="text-xs text-slate-500">sarah@example.com</div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-700 border border-yellow-200">
                                    <i data-lucide="help-circle" class="w-3 h-3"></i> Unverified
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-slate-900">1 day ago</div>
                                <div class="text-xs text-slate-400 font-mono">10.0.0.42</div>
                            </td>
                            <td class="px-6 py-4 text-right flex justify-end gap-2">
                                <button class="text-indigo-600 hover:text-indigo-800 text-xs font-bold hover:underline">Trust</button>
                                <button class="text-slate-400 hover:text-red-600 text-xs font-bold hover:underline">Ban</button>
                            </td>
                        </tr>

                        <tr class="bg-red-50/50 hover:bg-red-50 transition-colors">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded bg-red-100 flex items-center justify-center text-red-600">
                                        <i data-lucide="shield-alert" class="w-5 h-5"></i>
                                    </div>
                                    <div>
                                        <div class="font-medium text-slate-900">Unknown Windows PC</div>
                                        <div class="text-[10px] font-mono text-slate-400 uppercase">FP: 9x9x...BAD1</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="font-medium text-slate-900">Multiple Users</div>
                                <div class="text-xs text-red-500 font-bold">Botnet Detected</div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-700 border border-red-200">
                                    <i data-lucide="ban" class="w-3 h-3"></i> Banned
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-slate-900">Feb 10, 2026</div>
                                <div class="text-xs text-slate-400 font-mono">VPN Exit Node</div>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <button class="text-slate-500 hover:text-slate-700 text-xs hover:underline">Unban</button>
                            </td>
                        </tr>

                    </tbody>
                </table>
            </div>
            
            <div class="bg-white px-4 py-3 border-t border-gray-200 flex items-center justify-between sm:px-6">
                <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
                    <div>
                        <p class="text-sm text-gray-700">
                            Showing <span class="font-medium">1</span> to <span class="font-medium">10</span> of <span class="font-medium">1240</span> results
                        </p>
                    </div>
                    <div>
                        <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px" aria-label="Pagination">
                            <a href="#" class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">Previous</a>
                            <a href="#" class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50">1</a>
                            <a href="#" class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50">2</a>
                            <a href="#" class="relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">Next</a>
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

        // Example: Logic to handle toggles saving
        const toggles = document.querySelectorAll('input[type="checkbox"]');
        toggles.forEach(toggle => {
            toggle.addEventListener('change', function() {
                // In real app: call API to update policy
                console.log('Policy updated:', this.parentNode.previousElementSibling.innerText, this.checked);
            });
        });
    </script>
@endpush