@extends('layouts.app')

@section('title', 'Network Security')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
            <div>
                <h1 class="text-2xl font-bold text-slate-900">Network Defense Layer</h1>
                <p class="text-slate-500 mt-1">Configure IP firewalls, geo-blocking, and impossible travel detection.</p>
            </div>
            
            <button onclick="togglePanicMode()" class="flex items-center gap-2 px-4 py-2 bg-rose-100 border border-rose-200 rounded-lg text-sm font-bold text-rose-700 hover:bg-rose-200 transition-colors">
                <i data-lucide="siren" class="w-4 h-4"></i> 
                <span>Block All Non-Domestic Traffic</span>
            </button>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <div class="lg:col-span-2 space-y-6">
                
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-100 bg-slate-50 flex justify-between items-center">
                        <h3 class="font-semibold text-slate-800 flex items-center gap-2">
                            <i data-lucide="network" class="w-4 h-4 text-indigo-500"></i> IP Access Rules
                        </h3>
                        <button onclick="openIpModal()" class="text-xs font-bold text-white bg-indigo-600 px-3 py-1.5 rounded hover:bg-indigo-700">
                            + ADD RULE
                        </button>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-sm text-slate-600">
                            <thead class="bg-slate-50 text-slate-700 font-semibold uppercase text-xs">
                                <tr>
                                    <th class="px-6 py-3">IP / CIDR</th>
                                    <th class="px-6 py-3">Type</th>
                                    <th class="px-6 py-3">Applies To</th>
                                    <th class="px-6 py-3">Comment</th>
                                    <th class="px-6 py-3 text-right">Action</th>
                                </th>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                <tr class="hover:bg-slate-50">
                                    <td class="px-6 py-3 font-mono text-slate-900">203.0.113.0/24</td>
                                    <td class="px-6 py-3">
                                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded text-xs font-bold bg-green-100 text-green-700">
                                            ALLOW
                                        </span>
                                    </td>
                                    <td class="px-6 py-3">
                                        <span class="px-2 py-0.5 rounded bg-gray-100 text-gray-600 text-xs border border-gray-200">Admins Only</span>
                                    </td>
                                    <td class="px-6 py-3 text-slate-500 text-xs">Head Office WiFi</td>
                                    <td class="px-6 py-3 text-right">
                                        <button class="text-slate-400 hover:text-red-600"><i data-lucide="trash-2" class="w-4 h-4"></i></button>
                                    </td>
                                </tr>

                                <tr class="bg-red-50/30 hover:bg-red-50">
                                    <td class="px-6 py-3 font-mono text-slate-900">198.51.100.42</td>
                                    <td class="px-6 py-3">
                                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded text-xs font-bold bg-red-100 text-red-700">
                                            DENY
                                        </span>
                                    </td>
                                    <td class="px-6 py-3">
                                        <span class="px-2 py-0.5 rounded bg-gray-100 text-gray-600 text-xs border border-gray-200">Global</span>
                                    </td>
                                    <td class="px-6 py-3 text-slate-500 text-xs">Bot Attack Source</td>
                                    <td class="px-6 py-3 text-right">
                                        <button class="text-slate-400 hover:text-red-600"><i data-lucide="trash-2" class="w-4 h-4"></i></button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h3 class="font-semibold text-slate-800 mb-4 flex items-center gap-2">
                        <i data-lucide="zap" class="w-4 h-4 text-amber-500"></i> AI Detection: Impossible Travel
                    </h3>
                    
                    <div class="space-y-4">
                        <div class="flex items-start gap-4 p-3 bg-amber-50 rounded-lg border border-amber-100">
                            <div class="mt-1">
                                <i data-lucide="alert-triangle" class="w-5 h-5 text-amber-600"></i>
                            </div>
                            <div class="flex-1">
                                <p class="text-sm font-bold text-slate-800">Anomaly Detected: User #41 (Sarah)</p>
                                <p class="text-xs text-slate-600 mt-1">
                                    Login from <span class="font-bold">London, UK</span> at 10:00 AM.<br>
                                    Login from <span class="font-bold">New York, USA</span> at 10:15 AM.<br>
                                    <span class="italic text-amber-700">Distance: 5,500km in 15 mins (Impossible Speed)</span>
                                </p>
                            </div>
                            <button class="text-xs font-bold bg-white border border-amber-300 text-amber-700 px-3 py-1 rounded shadow-sm hover:bg-amber-100">
                                FREEZE ACCOUNT
                            </button>
                        </div>
                    </div>
                </div>

            </div>

            <div class="space-y-6">
                
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-100 bg-slate-50">
                        <h3 class="font-semibold text-slate-800 flex items-center gap-2">
                            <i data-lucide="globe" class="w-4 h-4 text-indigo-500"></i> Geo-Blocking
                        </h3>
                    </div>
                    
                    <div class="p-4 border-b border-gray-100">
                        <div class="relative">
                            <i data-lucide="search" class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400"></i>
                            <input type="text" placeholder="Search Country..." class="pl-10 w-full border-gray-300 rounded-lg text-sm focus:ring-indigo-500 focus:border-indigo-500">
                        </div>
                    </div>

                    <div class="max-h-[400px] overflow-y-auto p-2 space-y-1">
                        
                        <div class="flex items-center justify-between p-2 hover:bg-slate-50 rounded-lg group">
                            <div class="flex items-center gap-3">
                                <span class="text-xl">🇵🇰</span>
                                <span class="text-sm font-medium text-slate-700">Pakistan</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="text-[10px] text-green-600 bg-green-50 px-1.5 py-0.5 rounded font-bold">ALLOWED</span>
                            </div>
                        </div>

                        <div class="flex items-center justify-between p-2 hover:bg-slate-50 rounded-lg group">
                            <div class="flex items-center gap-3">
                                <span class="text-xl">🇺🇸</span>
                                <span class="text-sm font-medium text-slate-700">United States</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="text-[10px] text-green-600 bg-green-50 px-1.5 py-0.5 rounded font-bold">ALLOWED</span>
                            </div>
                        </div>

                        <div class="flex items-center justify-between p-2 bg-red-50/50 rounded-lg group border border-red-100">
                            <div class="flex items-center gap-3">
                                <span class="text-xl">🇷🇺</span>
                                <span class="text-sm font-medium text-slate-700">Russia</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <button class="text-[10px] text-red-600 bg-white border border-red-200 px-2 py-0.5 rounded font-bold hover:bg-red-50">UNBLOCK</button>
                            </div>
                        </div>

                        <div class="flex items-center justify-between p-2 bg-red-50/50 rounded-lg group border border-red-100">
                            <div class="flex items-center gap-3">
                                <span class="text-xl">🇨🇳</span>
                                <span class="text-sm font-medium text-slate-700">China</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <button class="text-[10px] text-red-600 bg-white border border-red-200 px-2 py-0.5 rounded font-bold hover:bg-red-50">UNBLOCK</button>
                            </div>
                        </div>

                    </div>
                    
                    <div class="p-4 bg-gray-50 border-t border-gray-100 text-center">
                        <p class="text-xs text-slate-500 mb-2">Default Global Policy</p>
                        <div class="inline-flex bg-white rounded-lg border border-gray-200 p-1">
                            <button class="px-3 py-1 text-xs font-bold text-white bg-green-600 rounded shadow-sm">ALLOW ALL</button>
                            <button class="px-3 py-1 text-xs font-medium text-slate-600 hover:text-slate-900">DENY ALL</button>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div id="ip-modal" class="hidden fixed inset-0 bg-slate-900/50 backdrop-blur-sm z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-xl shadow-2xl max-w-md w-full p-6">
            <h3 class="text-lg font-bold text-slate-900 mb-4">Add IP Access Rule</h3>
            
            <form action="#" method="POST">
                <div class="space-y-4">
                    
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">IP Address or CIDR</label>
                        <input type="text" placeholder="e.g. 192.168.1.5 or 10.0.0.0/24" class="w-full border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Rule Type</label>
                        <div class="flex gap-4">
                            <label class="flex items-center gap-2">
                                <input type="radio" name="rule_type" value="allow" class="text-green-600 focus:ring-green-500" checked>
                                <span class="text-sm text-slate-700">Allow (Whitelist)</span>
                            </label>
                            <label class="flex items-center gap-2">
                                <input type="radio" name="rule_type" value="deny" class="text-red-600 focus:ring-red-500">
                                <span class="text-sm text-slate-700">Block (Blacklist)</span>
                            </label>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Applies To</label>
                        <select class="w-full border-gray-300 rounded-lg focus:ring-indigo-500">
                            <option value="all">Global (Everyone)</option>
                            <option value="admin">Admins Only</option>
                            <option value="api">API Clients Only</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Comment / Reason</label>
                        <input type="text" placeholder="e.g. Finance Team Office IP" class="w-full border-gray-300 rounded-lg focus:ring-indigo-500">
                    </div>

                </div>

                <div class="mt-6 flex justify-end gap-3">
                    <button type="button" onclick="document.getElementById('ip-modal').classList.add('hidden')" class="px-4 py-2 text-slate-700 hover:bg-slate-100 rounded-lg">Cancel</button>
                    <button type="submit" class="px-4 py-2 bg-indigo-600 text-white hover:bg-indigo-700 rounded-lg font-medium shadow-sm">Save Rule</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://unpkg.com/lucide@latest"></script>
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            lucide.createIcons();
        });

        function openIpModal() {
            document.getElementById('ip-modal').classList.remove('hidden');
        }

        function togglePanicMode() {
            if(confirm("DANGER: This will immediately block all IP addresses outside your country. Are you sure?")) {
                alert("Panic Mode Activated. Foreign traffic dropped.");
                // Call API to activate panic mode
            }
        }
    </script>
@endpush