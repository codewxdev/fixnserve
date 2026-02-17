@extends('layouts.app')

@section('title', 'Privileged Access Governance')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
            <div>
                <h1 class="text-2xl font-bold text-slate-900">Privileged Access & Approvals</h1>
                <p class="text-slate-500 mt-1">Manage Just-In-Time (JIT) access requests and enforce multi-party authorization.</p>
            </div>
            
            <button onclick="openRequestModal()" class="flex items-center gap-2 px-4 py-2 bg-indigo-600 rounded-lg text-sm font-medium text-white hover:bg-indigo-700 shadow-sm transition-colors">
                <i data-lucide="key" class="w-4 h-4"></i> 
                <span>Request Elevation</span>
            </button>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <div class="lg:col-span-2 space-y-8">
                
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-100 bg-slate-50 flex justify-between items-center">
                        <h3 class="font-semibold text-slate-800 flex items-center gap-2">
                            <i data-lucide="timer" class="w-4 h-4 text-indigo-500"></i> Active Elevations
                        </h3>
                        <span class="bg-indigo-100 text-indigo-700 text-xs font-bold px-2 py-1 rounded">2 ACTIVE</span>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-sm text-slate-600">
                            <thead class="bg-white text-slate-500 font-medium border-b border-gray-100">
                                <tr>
                                    <th class="px-6 py-3">User</th>
                                    <th class="px-6 py-3">Role / Scope</th>
                                    <th class="px-6 py-3">Reason</th>
                                    <th class="px-6 py-3">Time Remaining</th>
                                    <th class="px-6 py-3 text-right">Action</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-50">
                                <tr class="hover:bg-slate-50">
                                    <td class="px-6 py-4 font-medium text-slate-900">Javed Baloch</td>
                                    <td class="px-6 py-4">
                                        <div class="flex flex-col">
                                            <span class="text-xs font-bold text-red-600">SUPER ADMIN</span>
                                            <span class="text-[10px] text-slate-400">Scope: Full System</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-slate-500 text-xs">"Fixing Payout DB Schema"</td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-2 font-mono text-indigo-600 font-bold">
                                            <i data-lucide="clock" class="w-3 h-3"></i> 00:42:15
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <button class="text-xs text-red-600 border border-red-200 bg-red-50 hover:bg-red-100 px-2 py-1 rounded transition-colors">REVOKE</button>
                                    </td>
                                </tr>

                                <tr class="hover:bg-slate-50">
                                    <td class="px-6 py-4 font-medium text-slate-900">Support Lead</td>
                                    <td class="px-6 py-4">
                                        <div class="flex flex-col">
                                            <span class="text-xs font-bold text-amber-600">USER IMPERSONATION</span>
                                            <span class="text-[10px] text-slate-400">Target: User #9921</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-slate-500 text-xs">"Ticket #8821 Debug"</td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-2 font-mono text-amber-600 font-bold">
                                            <i data-lucide="clock" class="w-3 h-3"></i> 00:08:30
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <button class="text-xs text-red-600 border border-red-200 bg-red-50 hover:bg-red-100 px-2 py-1 rounded transition-colors">REVOKE</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-sm border border-gray-200">
                    <div class="px-6 py-4 border-b border-gray-100 bg-slate-50 flex justify-between items-center">
                        <h3 class="font-semibold text-slate-800 flex items-center gap-2">
                            <i data-lucide="users" class="w-4 h-4 text-amber-500"></i> Pending Dual Approvals
                        </h3>
                        <span class="bg-amber-100 text-amber-700 text-xs font-bold px-2 py-1 rounded">1 PENDING</span>
                    </div>

                    <div class="p-6 space-y-4">
                        
                        <div class="border border-gray-200 rounded-lg p-4 flex flex-col md:flex-row gap-4 items-start md:items-center justify-between hover:border-indigo-300 transition-colors">
                            <div class="flex items-start gap-4">
                                <div class="bg-amber-50 p-2 rounded-lg text-amber-600 mt-1">
                                    <i data-lucide="banknote" class="w-6 h-6"></i>
                                </div>
                                <div>
                                    <h4 class="font-bold text-slate-900">Large Payout Release</h4>
                                    <p class="text-sm text-slate-500">Amount: <span class="font-mono font-bold text-slate-800">$15,000.00</span> | To: Vendor XYZ Ltd.</p>
                                    <div class="flex items-center gap-4 mt-2 text-xs">
                                        <span class="text-slate-400">Requester: <span class="text-slate-700 font-medium">Finance Manager</span></span>
                                        <span class="text-slate-300">|</span>
                                        <span class="text-slate-400">Time: 10 mins ago</span>
                                    </div>
                                </div>
                            </div>

                            <div class="flex flex-col items-end gap-2 min-w-[140px]">
                                <div class="flex items-center gap-1 text-xs font-bold text-slate-500 mb-1">
                                    <span>Progress:</span>
                                    <span class="text-indigo-600">1 / 2</span>
                                </div>
                                <div class="flex -space-x-2 overflow-hidden mb-2">
                                    <img class="inline-block h-6 w-6 rounded-full ring-2 ring-white" src="https://ui-avatars.com/api/?name=Ali+Raza&background=0D8ABC&color=fff" alt="" title="Approved by Ali">
                                    <div class="inline-block h-6 w-6 rounded-full ring-2 ring-white bg-gray-200 flex items-center justify-center text-[10px] text-gray-500 font-bold border border-gray-300 border-dashed">?</div>
                                </div>
                                <div class="flex gap-2">
                                    <button class="px-3 py-1 bg-green-600 text-white text-xs font-bold rounded shadow-sm hover:bg-green-700">APPROVE</button>
                                    <button class="px-3 py-1 bg-white border border-gray-300 text-slate-600 text-xs font-bold rounded hover:bg-gray-50">REJECT</button>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

            </div>

            <div class="space-y-6">
                
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-100 bg-slate-50">
                        <h3 class="font-semibold text-slate-800 flex items-center gap-2">
                            <i data-lucide="shield" class="w-4 h-4 text-indigo-500"></i> Governance Rules
                        </h3>
                    </div>
                    <div class="p-4 space-y-4">
                        
                        <div class="flex items-center justify-between pb-3 border-b border-gray-100">
                            <div>
                                <p class="text-sm font-medium text-slate-900">Max Elevation Time</p>
                                <p class="text-xs text-slate-400">Auto-revoke after duration</p>
                            </div>
                            <span class="text-xs font-bold bg-gray-100 px-2 py-1 rounded">1 Hour</span>
                        </div>

                        <div class="flex items-center justify-between pb-3 border-b border-gray-100">
                            <div>
                                <p class="text-sm font-medium text-slate-900">Payout Threshold</p>
                                <p class="text-xs text-slate-400">Requires Dual Approval</p>
                            </div>
                            <span class="text-xs font-bold bg-gray-100 px-2 py-1 rounded">>$1,000</span>
                        </div>

                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-slate-900">Refund Threshold</p>
                                <p class="text-xs text-slate-400">Requires Dual Approval</p>
                            </div>
                            <span class="text-xs font-bold bg-gray-100 px-2 py-1 rounded">>$500</span>
                        </div>

                        <button class="w-full mt-4 text-xs text-indigo-600 font-bold hover:underline">EDIT POLICIES</button>
                    </div>
                </div>

                <div class="bg-slate-900 rounded-xl shadow-lg p-6 text-white">
                    <h3 class="font-semibold flex items-center gap-2 mb-4">
                        <i data-lucide="file-text" class="w-4 h-4 text-slate-400"></i> Recent Audit
                    </h3>
                    <div class="space-y-4 text-xs font-mono">
                        
                        <div class="flex gap-3">
                            <div class="min-w-[4px] bg-green-500 rounded-full"></div>
                            <div>
                                <p class="text-slate-300">10:42 AM</p>
                                <p class="text-white">Admin <span class="text-green-400">APPROVED</span> Payout #991</p>
                            </div>
                        </div>

                        <div class="flex gap-3">
                            <div class="min-w-[4px] bg-red-500 rounded-full"></div>
                            <div>
                                <p class="text-slate-300">09:15 AM</p>
                                <p class="text-white">System <span class="text-red-400">REVOKED</span> User #44 JIT Access (Expired)</p>
                            </div>
                        </div>

                        <div class="flex gap-3">
                            <div class="min-w-[4px] bg-indigo-500 rounded-full"></div>
                            <div>
                                <p class="text-slate-300">09:00 AM</p>
                                <p class="text-white">Javed <span class="text-indigo-400">REQUESTED</span> Elevation</p>
                            </div>
                        </div>

                    </div>
                    <button class="w-full mt-4 py-2 bg-slate-800 text-slate-300 text-xs rounded hover:bg-slate-700">View Full Logs</button>
                </div>

            </div>
        </div>
    </div>

    <div id="access-modal" class="hidden fixed inset-0 bg-slate-900/50 backdrop-blur-sm z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-xl shadow-2xl max-w-md w-full p-6">
            <h3 class="text-lg font-bold text-slate-900 mb-4">Request Temporary Access</h3>
            
            <form action="#" method="POST">
                <div class="space-y-4">
                    
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Role / Permission</label>
                        <select class="w-full border-gray-300 rounded-lg focus:ring-indigo-500">
                            <option>Super Admin (Full Access)</option>
                            <option>Finance Manager (Payouts)</option>
                            <option>User Impersonation (Support)</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Duration Needed</label>
                        <select class="w-full border-gray-300 rounded-lg focus:ring-indigo-500">
                            <option>15 Minutes</option>
                            <option>30 Minutes</option>
                            <option>1 Hour (Max)</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Reason / Ticket ID</label>
                        <textarea rows="3" placeholder="Why do you need this access? e.g. 'Resolving Payout Bug #123'" class="w-full border-gray-300 rounded-lg focus:ring-indigo-500"></textarea>
                    </div>

                </div>

                <div class="mt-6 flex justify-end gap-3">
                    <button type="button" onclick="document.getElementById('access-modal').classList.add('hidden')" class="px-4 py-2 text-slate-700 hover:bg-slate-100 rounded-lg">Cancel</button>
                    <button type="submit" class="px-4 py-2 bg-indigo-600 text-white hover:bg-indigo-700 rounded-lg font-medium shadow-sm">Submit Request</button>
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

        function openRequestModal() {
            document.getElementById('access-modal').classList.remove('hidden');
        }
    </script>
@endpush