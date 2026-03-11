 @extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
        <div>
            <h2 class="text-2xl font-bold text-[rgb(var(--text-main))]">Access Control & Governance</h2>
            <p class="text-sm text-[rgb(var(--text-muted))] mt-1">Ensure only authorized admins can change critical system settings.</p>
        </div>
        <div>
            <button class="bg-[rgb(var(--bg-card))] border border-[rgb(var(--border-color))] hover:bg-[rgb(var(--item-active-bg))] text-[rgb(var(--text-main))] font-medium py-2 px-4 rounded-md inline-flex items-center transition duration-150 ease-in-out shadow-sm">
                <svg class="w-4 h-4 mr-2 text-[rgb(var(--text-muted))]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                View Audit Logs
            </button>
        </div>
    </div>

    <div class="grid grid-cols-1 xl:grid-cols-12 gap-6">
        
        <div class="xl:col-span-8 flex flex-col gap-6">
            
            <div class="bg-[rgb(var(--bg-card))] rounded-lg shadow-sm border border-[rgb(var(--border-color))] overflow-hidden">
                <div class="px-6 py-4 border-b border-[rgb(var(--border-color))] bg-[rgb(var(--item-active-bg))] flex justify-between items-center">
                    <h5 class="text-lg font-semibold text-[rgb(var(--text-main))] flex items-center gap-2">
                        <svg class="w-5 h-5 text-[rgb(var(--brand-primary))]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        Grant Time-Bound Privileges
                    </h5>
                </div>
                <div class="p-6">
                    <p class="text-sm text-[rgb(var(--text-muted))] mb-4">Temporarily elevate a user's permissions. Access automatically revokes when the timer expires.</p>
                    
                    <form id="timeBoundForm" class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end mb-6">
                        <div class="col-span-1">
                            <label class="block text-sm font-medium text-[rgb(var(--text-muted))] mb-1">Target Admin</label>
                            <select class="block w-full pl-3 pr-10 py-2 text-sm border-[rgb(var(--border-color))] focus:outline-none focus:ring-[rgb(var(--brand-primary))] focus:border-[rgb(var(--brand-primary))] rounded-md border text-[rgb(var(--text-main))] bg-[rgb(var(--bg-card))]">
                                <option>Ayesha Khan (Support)</option>
                                <option>Bilal Ahmed (DevOps)</option>
                            </select>
                        </div>
                        <div class="col-span-1">
                            <label class="block text-sm font-medium text-[rgb(var(--text-muted))] mb-1">Temporary Role</label>
                            <select class="block w-full pl-3 pr-10 py-2 text-sm border-[rgb(var(--border-color))] focus:outline-none focus:ring-[rgb(var(--brand-primary))] focus:border-[rgb(var(--brand-primary))] rounded-md border text-[rgb(var(--text-main))] bg-[rgb(var(--bg-card))]">
                                <option>Super Admin</option>
                                <option>Finance Manager</option>
                                <option>System Architect</option>
                            </select>
                        </div>
                        <div class="col-span-1">
                            <label class="block text-sm font-medium text-[rgb(var(--text-muted))] mb-1">Duration</label>
                            <select class="block w-full pl-3 pr-10 py-2 text-sm border-[rgb(var(--border-color))] focus:outline-none focus:ring-[rgb(var(--brand-primary))] focus:border-[rgb(var(--brand-primary))] rounded-md border text-[rgb(var(--text-main))] bg-[rgb(var(--bg-card))]">
                                <option>1 Hour</option>
                                <option>4 Hours</option>
                                <option>24 Hours</option>
                                <option>Until End of Day</option>
                            </select>
                        </div>
                        <div class="col-span-1">
                            <button type="button" onclick="grantAccess()" class="w-full bg-[rgb(var(--brand-primary))] hover:bg-[rgb(var(--brand-secondary))] text-white font-medium py-2 px-4 rounded-md transition duration-150 ease-in-out shadow-sm">
                                Grant Access
                            </button>
                        </div>
                    </form>

                    <h6 class="text-xs font-bold text-[rgb(var(--text-muted))] uppercase tracking-wider mb-3">Active Temporary Grants</h6>
                    <div class="border border-[rgb(var(--border-color))] rounded-md overflow-hidden">
                        <table class="min-w-full divide-y divide-[rgb(var(--border-color))]">
                            <tbody class="bg-[rgb(var(--bg-card))] divide-y divide-[rgb(var(--border-color))]">
                                <tr>
                                    <td class="px-4 py-3 whitespace-nowrap">
                                        <div class="text-sm font-medium text-[rgb(var(--text-main))]">Bilal Ahmed</div>
                                        <div class="text-xs text-[rgb(var(--text-muted))]">Granted by: SuperAdmin</div>
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">System Architect</span>
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap">
                                        <div class="text-sm text-[rgb(var(--text-main))]">Expires in <span class="text-red-600 font-bold animate-pulse">45m 12s</span></div>
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap text-right text-sm font-medium">
                                        <button class="text-red-600 hover:text-red-800 border border-red-200 bg-red-50 hover:bg-red-100 px-2 py-1 rounded transition-colors text-xs">Revoke Now</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="bg-[rgb(var(--bg-card))] rounded-lg shadow-sm border border-[rgb(var(--border-color))] overflow-hidden flex-1">
                <div class="px-6 py-4 border-b border-[rgb(var(--border-color))] bg-[rgb(var(--item-active-bg))] flex justify-between items-center">
                    <h5 class="text-lg font-semibold text-[rgb(var(--text-main))]">Role-Based Access Control (RBAC)</h5>
                    <button class="text-[rgb(var(--brand-primary))] text-sm font-medium hover:underline">+ Create Custom Role</button>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-[rgb(var(--border-color))]">
                        <thead class="bg-[rgb(var(--item-active-bg))]">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-[rgb(var(--text-muted))] uppercase tracking-wider">Role Name</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-[rgb(var(--text-muted))] uppercase tracking-wider">Assigned Users</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-[rgb(var(--text-muted))] uppercase tracking-wider">Access Scope</th>
                                <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-[rgb(var(--text-muted))] uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-[rgb(var(--bg-card))] divide-y divide-[rgb(var(--border-color))]">
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-bold text-[rgb(var(--text-main))]">Super Admin</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-[rgb(var(--text-muted))]">2 Users</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-[rgb(var(--text-muted))]">Full System Access</td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <span class="text-gray-400 italic text-xs">System Default</span>
                                </td>
                            </tr>
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-bold text-[rgb(var(--text-main))]">Operations Manager</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-[rgb(var(--text-muted))]">8 Users</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-[rgb(var(--text-muted))]">Users, Rides, Geofencing</td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <button class="text-[rgb(var(--brand-primary))] hover:text-[rgb(var(--brand-secondary))] mr-3">Edit</button>
                                </td>
                            </tr>
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-bold text-[rgb(var(--text-main))]">Support Agent</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-[rgb(var(--text-muted))]">24 Users</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-[rgb(var(--text-muted))]">Read-Only (Users, Rides)</td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <button class="text-[rgb(var(--brand-primary))] hover:text-[rgb(var(--brand-secondary))] mr-3">Edit</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="xl:col-span-4 flex flex-col gap-6">
            
            <div class="bg-[rgb(var(--bg-card))] rounded-lg shadow-sm border border-[rgb(var(--border-color))] overflow-hidden">
                <div class="px-6 py-4 border-b border-[rgb(var(--border-color))] bg-[rgb(var(--item-active-bg))]">
                    <h5 class="text-lg font-semibold text-[rgb(var(--text-main))] flex items-center gap-2">
                        <svg class="w-5 h-5 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                        Dual Approval Rules
                    </h5>
                    <p class="text-xs text-[rgb(var(--text-muted))] mt-1">Require a second admin to approve high-risk changes.</p>
                </div>
                <div class="p-4 space-y-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-[rgb(var(--text-main))]">Financial Settings</p>
                            <p class="text-xs text-[rgb(var(--text-muted))]">Pricing models, surge rules, payment gateways</p>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" class="sr-only peer" checked>
                            <div class="w-9 h-5 bg-gray-200 peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-[rgb(var(--brand-primary))] rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-[rgb(var(--bg-card))] after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-[rgb(var(--bg-card))] after:border-[rgb(var(--border-color))] after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-[rgb(var(--brand-primary))]"></div>
                        </label>
                    </div>
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-[rgb(var(--text-main))]">API Rate Limits & Throttling</p>
                            <p class="text-xs text-[rgb(var(--text-muted))]">Global rate limits, emergency throttling</p>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" class="sr-only peer" checked>
                            <div class="w-9 h-5 bg-gray-200 peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-[rgb(var(--brand-primary))] rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-[rgb(var(--bg-card))] after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-[rgb(var(--bg-card))] after:border-[rgb(var(--border-color))] after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-[rgb(var(--brand-primary))]"></div>
                        </label>
                    </div>
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-[rgb(var(--text-main))]">Geofence Outages</p>
                            <p class="text-xs text-[rgb(var(--text-muted))]">Creating restricted zones, emergency locks</p>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" class="sr-only peer">
                            <div class="w-9 h-5 bg-gray-200 peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-[rgb(var(--brand-primary))] rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-[rgb(var(--bg-card))] after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-[rgb(var(--bg-card))] after:border-[rgb(var(--border-color))] after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-[rgb(var(--brand-primary))]"></div>
                        </label>
                    </div>
                </div>
            </div>

            <div class="bg-[rgb(var(--bg-card))] rounded-lg shadow-sm border border-[rgb(var(--border-color))] overflow-hidden">
                <div class="px-6 py-4 border-b border-[rgb(var(--border-color))] bg-[rgb(var(--item-active-bg))]">
                    <h5 class="text-lg font-semibold text-[rgb(var(--text-main))]">Mandatory Reason Codes</h5>
                    <p class="text-xs text-[rgb(var(--text-muted))] mt-1">Require admins to log a reason when making changes.</p>
                </div>
                <div class="p-4">
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-[rgb(var(--text-muted))] mb-1">Enforcement Level</label>
                        <select class="block w-full pl-3 pr-10 py-2 text-sm border-[rgb(var(--border-color))] focus:outline-none focus:ring-[rgb(var(--brand-primary))] focus:border-[rgb(var(--brand-primary))] rounded-md border text-[rgb(var(--text-main))] bg-[rgb(var(--bg-card))]">
                            <option>Strict (All Configuration Changes)</option>
                            <option selected>Moderate (High-Risk Changes Only)</option>
                            <option>Disabled</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-[rgb(var(--text-muted))] mb-2">Predefined Justifications</label>
                        <div class="flex flex-wrap gap-2">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-[rgb(var(--item-active-bg))] text-[rgb(var(--text-main))] border border-[rgb(var(--border-color))]">
                                Routine Maintenance
                            </span>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-[rgb(var(--item-active-bg))] text-[rgb(var(--text-main))] border border-[rgb(var(--border-color))]">
                                Incident Resolution
                            </span>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-[rgb(var(--item-active-bg))] text-[rgb(var(--text-main))] border border-[rgb(var(--border-color))]">
                                Feature Rollout
                            </span>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-[rgb(var(--item-active-bg))] text-[rgb(var(--text-main))] border border-[rgb(var(--border-color))]">
                                Emergency Override
                            </span>
                            <button class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-[rgb(var(--bg-card))] text-[rgb(var(--brand-primary))] border border-dashed border-[rgb(var(--brand-primary))] hover:bg-[rgb(var(--item-active-bg))]">
                                + Add Code
                            </button>
                        </div>
                    </div>
                </div>
                <div class="px-4 py-3 bg-[rgb(var(--item-active-bg))] border-t border-[rgb(var(--border-color))] text-right">
                    <button class="bg-[rgb(var(--brand-primary))] hover:bg-[rgb(var(--brand-secondary))] text-white text-sm font-medium py-1.5 px-4 rounded shadow-sm transition-colors">Save Policies</button>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function grantAccess() {
        const btn = document.querySelector('#timeBoundForm button');
        const originalText = btn.innerText;
        
        btn.innerText = "Processing...";
        btn.disabled = true;
        btn.classList.add('opacity-75', 'cursor-not-allowed');

        setTimeout(() => {
            btn.innerText = originalText;
            btn.disabled = false;
            btn.classList.remove('opacity-75', 'cursor-not-allowed');
            
            // In a real application, you would append the new active grant to the table here via DOM manipulation.
            alert("✅ Temporary privileges granted successfully. An audit log has been created.");
        }, 1000);
    }
</script>
@endpush
