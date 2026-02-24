@extends('layouts.app')

@section('title', 'Privileged Access Governance')

@section('content')
    <div class="min-h-screen theme-bg-body theme-text-main max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
            <div>
                <h1 class="text-2xl font-bold theme-text-main">Privileged Access & Approvals</h1>
                <p class="theme-text-muted mt-1">Manage Just-In-Time (JIT) access requests and enforce multi-party authorization.</p>
            </div>
            
            <button onclick="openRequestModal()" 
                class="flex items-center gap-2 px-4 py-2 text-white rounded-lg text-sm font-medium hover:opacity-90 shadow-sm transition-colors"
                style="background-color: rgb(var(--brand-primary)); box-shadow: 0 4px 10px rgba(var(--brand-primary), 0.3);">
                <i data-lucide="key" class="w-4 h-4"></i> 
                <span>Request Elevation</span>
            </button>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <div class="lg:col-span-2 space-y-8">
                
                {{-- ACTIVE ELEVATIONS TABLE --}}
                <div class="theme-bg-card rounded-xl shadow-sm border theme-border overflow-hidden">
                    <div class="px-6 py-4 border-b theme-border flex justify-between items-center" style="background-color: rgba(var(--bg-body), 0.5);">
                        <h3 class="font-semibold theme-text-main flex items-center gap-2">
                            <i data-lucide="timer" class="w-4 h-4" style="color: rgb(var(--brand-primary));"></i> Active Elevations
                        </h3>
                        <span class="bg-indigo-500/10 text-indigo-500 border border-indigo-500/20 text-xs font-bold px-2 py-1 rounded">2 ACTIVE</span>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-sm theme-text-muted">
                            <thead class="theme-bg-body theme-text-muted font-medium border-b theme-border">
                                <tr>
                                    <th class="px-6 py-3">User</th>
                                    <th class="px-6 py-3">Role / Scope</th>
                                    <th class="px-6 py-3">Reason</th>
                                    <th class="px-6 py-3">Time Remaining</th>
                                    <th class="px-6 py-3 text-right">Action</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y theme-border" style="border-color: rgb(var(--border-color));">
                                <tr class="hover:bg-white/5 transition-colors">
                                    <td class="px-6 py-4 font-medium theme-text-main">Javed Baloch</td>
                                    <td class="px-6 py-4">
                                        <div class="flex flex-col">
                                            <span class="text-xs font-bold text-red-500">SUPER ADMIN</span>
                                            <span class="text-[10px] theme-text-muted">Scope: Full System</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 theme-text-muted text-xs">"Fixing Payout DB Schema"</td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-2 font-mono font-bold" style="color: rgb(var(--brand-primary));">
                                            <i data-lucide="clock" class="w-3 h-3"></i> 00:42:15
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <button class="text-xs text-red-500 border border-red-500/30 bg-red-500/10 hover:bg-red-500/20 px-2 py-1 rounded transition-colors">REVOKE</button>
                                    </td>
                                </tr>

                                <tr class="hover:bg-white/5 transition-colors">
                                    <td class="px-6 py-4 font-medium theme-text-main">Support Lead</td>
                                    <td class="px-6 py-4">
                                        <div class="flex flex-col">
                                            <span class="text-xs font-bold text-amber-500">USER IMPERSONATION</span>
                                            <span class="text-[10px] theme-text-muted">Target: User #9921</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 theme-text-muted text-xs">"Ticket #8821 Debug"</td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-2 font-mono text-amber-500 font-bold">
                                            <i data-lucide="clock" class="w-3 h-3"></i> 00:08:30
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <button class="text-xs text-red-500 border border-red-500/30 bg-red-500/10 hover:bg-red-500/20 px-2 py-1 rounded transition-colors">REVOKE</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- PENDING APPROVALS --}}
                <div class="theme-bg-card rounded-xl shadow-sm border theme-border">
                    <div class="px-6 py-4 border-b theme-border flex justify-between items-center" style="background-color: rgba(var(--bg-body), 0.5);">
                        <h3 class="font-semibold theme-text-main flex items-center gap-2">
                            <i data-lucide="users" class="w-4 h-4 text-amber-500"></i> Pending Dual Approvals
                        </h3>
                        <span class="bg-amber-500/10 text-amber-500 border border-amber-500/20 text-xs font-bold px-2 py-1 rounded">1 PENDING</span>
                    </div>

                    <div class="p-6 space-y-4">
                        
                        <div class="border theme-border rounded-lg p-4 flex flex-col md:flex-row gap-4 items-start md:items-center justify-between hover:bg-white/5 transition-colors">
                            <div class="flex items-start gap-4">
                                <div class="bg-amber-500/10 p-2 rounded-lg text-amber-500 mt-1 border border-amber-500/20">
                                    <i data-lucide="banknote" class="w-6 h-6"></i>
                                </div>
                                <div>
                                    <h4 class="font-bold theme-text-main">Large Payout Release</h4>
                                    <p class="text-sm theme-text-muted">Amount: <span class="font-mono font-bold theme-text-main">$15,000.00</span> | To: Vendor XYZ Ltd.</p>
                                    <div class="flex items-center gap-4 mt-2 text-xs">
                                        <span class="theme-text-muted">Requester: <span class="theme-text-main font-medium">Finance Manager</span></span>
                                        <span class="theme-text-muted">|</span>
                                        <span class="theme-text-muted">Time: 10 mins ago</span>
                                    </div>
                                </div>
                            </div>

                            <div class="flex flex-col items-end gap-2 min-w-[140px]">
                                <div class="flex items-center gap-1 text-xs font-bold theme-text-muted mb-1">
                                    <span>Progress:</span>
                                    <span style="color: rgb(var(--brand-primary));">1 / 2</span>
                                </div>
                                <div class="flex -space-x-2 overflow-hidden mb-2">
                                    <img class="inline-block h-6 w-6 rounded-full ring-2 theme-ring" src="https://ui-avatars.com/api/?name=Ali+Raza&background=0D8ABC&color=fff" alt="" title="Approved by Ali">
                                    <div class="inline-block h-6 w-6 rounded-full ring-2 theme-ring theme-bg-body flex items-center justify-center text-[10px] theme-text-muted font-bold border theme-border border-dashed">?</div>
                                </div>
                                <div class="flex gap-2">
                                    <button class="px-3 py-1 bg-green-600 text-white text-xs font-bold rounded shadow-sm hover:bg-green-700 transition">APPROVE</button>
                                    <button class="px-3 py-1 theme-bg-body border theme-border theme-text-muted text-xs font-bold rounded hover:bg-white/10 transition">REJECT</button>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

            </div>

            <div class="space-y-6">
                
                {{-- GOVERNANCE RULES --}}
                <div class="theme-bg-card rounded-xl shadow-sm border theme-border overflow-hidden">
                    <div class="px-6 py-4 border-b theme-border" style="background-color: rgba(var(--bg-body), 0.5);">
                        <h3 class="font-semibold theme-text-main flex items-center gap-2">
                            <i data-lucide="shield" class="w-4 h-4" style="color: rgb(var(--brand-primary));"></i> Governance Rules
                        </h3>
                    </div>
                    <div class="p-4 space-y-4">
                        
                        <div class="flex items-center justify-between pb-3 border-b theme-border">
                            <div>
                                <p class="text-sm font-medium theme-text-main">Max Elevation Time</p>
                                <p class="text-xs theme-text-muted">Auto-revoke after duration</p>
                            </div>
                            <span class="text-xs font-bold theme-bg-body border theme-border px-2 py-1 rounded theme-text-muted">1 Hour</span>
                        </div>

                        <div class="flex items-center justify-between pb-3 border-b theme-border">
                            <div>
                                <p class="text-sm font-medium theme-text-main">Payout Threshold</p>
                                <p class="text-xs theme-text-muted">Requires Dual Approval</p>
                            </div>
                            <span class="text-xs font-bold theme-bg-body border theme-border px-2 py-1 rounded theme-text-muted">>$1,000</span>
                        </div>

                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium theme-text-main">Refund Threshold</p>
                                <p class="text-xs theme-text-muted">Requires Dual Approval</p>
                            </div>
                            <span class="text-xs font-bold theme-bg-body border theme-border px-2 py-1 rounded theme-text-muted">>$500</span>
                        </div>

                        <button class="w-full mt-4 text-xs font-bold hover:underline" style="color: rgb(var(--brand-primary));">EDIT POLICIES</button>
                    </div>
                </div>

                {{-- RECENT AUDIT --}}
                <div class="rounded-xl shadow-lg p-6 border theme-border" style="background-color: rgba(15, 23, 42, 0.95);">
                    <h3 class="font-semibold flex items-center gap-2 mb-4 text-white">
                        <i data-lucide="file-text" class="w-4 h-4 text-gray-400"></i> Recent Audit
                    </h3>
                    <div class="space-y-4 text-xs font-mono">
                        
                        <div class="flex gap-3">
                            <div class="min-w-[4px] bg-green-500 rounded-full"></div>
                            <div>
                                <p class="text-gray-400">10:42 AM</p>
                                <p class="text-white">Admin <span class="text-green-400">APPROVED</span> Payout #991</p>
                            </div>
                        </div>

                        <div class="flex gap-3">
                            <div class="min-w-[4px] bg-red-500 rounded-full"></div>
                            <div>
                                <p class="text-gray-400">09:15 AM</p>
                                <p class="text-white">System <span class="text-red-400">REVOKED</span> User #44 JIT Access (Expired)</p>
                            </div>
                        </div>

                        <div class="flex gap-3">
                            <div class="min-w-[4px] bg-indigo-500 rounded-full"></div>
                            <div>
                                <p class="text-gray-400">09:00 AM</p>
                                <p class="text-white">Javed <span class="text-indigo-400">REQUESTED</span> Elevation</p>
                            </div>
                        </div>

                    </div>
                    <button class="w-full mt-4 py-2 bg-white/10 text-gray-300 text-xs rounded hover:bg-white/20 transition">View Full Logs</button>
                </div>

            </div>
        </div>
    </div>

    {{-- REQUEST MODAL --}}
    <div id="access-modal" class="hidden fixed inset-0 bg-black/80 backdrop-blur-sm z-50 flex items-center justify-center p-4">
        <div class="theme-bg-card rounded-xl shadow-2xl max-w-md w-full p-6 border theme-border">
            <h3 class="text-lg font-bold theme-text-main mb-4">Request Temporary Access</h3>
            
            <form action="#" method="POST">
                <div class="space-y-4">
                    
                    <div>
                        <label class="block text-sm font-medium theme-text-muted mb-1">Role / Permission</label>
                        <select class="w-full theme-bg-body border theme-border rounded-lg theme-text-main focus:ring-2 focus:ring-blue-500 p-2.5">
                            <option>Super Admin (Full Access)</option>
                            <option>Finance Manager (Payouts)</option>
                            <option>User Impersonation (Support)</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium theme-text-muted mb-1">Duration Needed</label>
                        <select class="w-full theme-bg-body border theme-border rounded-lg theme-text-main focus:ring-2 focus:ring-blue-500 p-2.5">
                            <option>15 Minutes</option>
                            <option>30 Minutes</option>
                            <option>1 Hour (Max)</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium theme-text-muted mb-1">Reason / Ticket ID</label>
                        <textarea rows="3" placeholder="Why do you need this access? e.g. 'Resolving Payout Bug #123'" 
                            class="w-full theme-bg-body border theme-border rounded-lg theme-text-main focus:ring-2 focus:ring-blue-500 p-2.5"></textarea>
                    </div>

                </div>

                <div class="mt-6 flex justify-end gap-3">
                    <button type="button" onclick="document.getElementById('access-modal').classList.add('hidden')" 
                        class="px-4 py-2 theme-text-muted hover:bg-white/5 rounded-lg transition">Cancel</button>
                    <button type="submit" 
                        class="px-4 py-2 text-white rounded-lg font-medium shadow-sm hover:opacity-90 transition"
                        style="background-color: rgb(var(--brand-primary));">Submit Request</button>
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

@push('styles')
<style>
    /* Custom Ring Color for avatars based on theme */
    .theme-ring {
        --tw-ring-color: rgb(var(--bg-card));
    }
</style>
@endpush