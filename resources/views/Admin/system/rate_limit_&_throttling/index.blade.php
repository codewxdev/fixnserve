@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
        <div>
            <h2 class="text-2xl font-bold text-[rgb(var(--text-main))]">Rate Limits & Throttling</h2>
            <p class="text-sm text-[rgb(var(--text-muted))] mt-1">Protect system stability and integrations.</p>
        </div>
        <div>
            <button id="emergencyThrottleBtn" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-md font-medium flex items-center gap-2 transition-all duration-300 shadow-sm">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
                <span id="emergencyText">Enable Emergency Throttling</span>
            </button>
        </div>
    </div>

    <form action="#" method="POST" id="rateLimitForm">
        @csrf
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div class="bg-[rgb(var(--bg-card))] rounded-lg shadow-sm border border-[rgb(var(--border-color))] overflow-hidden flex flex-col">
                <div class="bg-[rgb(var(--item-active-bg))] px-6 py-4 border-b border-[rgb(var(--border-color))]">
                    <h5 class="text-lg font-medium text-[rgb(var(--text-main))]">Global & API Controls</h5>
                </div>
                <div class="p-6 flex-1 space-y-4">
                    <div>
                        <label for="api_rate_limit" class="block text-sm font-medium text-[rgb(var(--text-muted))] mb-1">
                            API Rate Limits <span class="text-xs font-normal opacity-70">(requests / minute)</span>
                        </label>
                        <input type="number" id="api_rate_limit" name="api_rate_limit" value="1000" required
                            class="w-full bg-[rgb(var(--bg-card))] text-[rgb(var(--text-main))] border border-[rgb(var(--border-color))] rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[rgb(var(--brand-primary))] focus:border-[rgb(var(--brand-primary))]">
                    </div>
                    <div>
                        <label for="burst_limit" class="block text-sm font-medium text-[rgb(var(--text-muted))] mb-1">
                            Burst Limits <span class="text-xs font-normal opacity-70">(requests / second)</span>
                        </label>
                        <input type="number" id="burst_limit" name="burst_limit" value="50" required
                            class="w-full bg-[rgb(var(--bg-card))] text-[rgb(var(--text-main))] border border-[rgb(var(--border-color))] rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[rgb(var(--brand-primary))] focus:border-[rgb(var(--brand-primary))]">
                    </div>
                </div>
            </div>

            <div class="bg-[rgb(var(--bg-card))] rounded-lg shadow-sm border border-[rgb(var(--border-color))] overflow-hidden flex flex-col">
                <div class="bg-[rgb(var(--item-active-bg))] px-6 py-4 border-b border-[rgb(var(--border-color))]">
                    <h5 class="text-lg font-medium text-[rgb(var(--text-main))]">Entity Restrictions</h5>
                </div>
                <div class="p-6 flex-1 space-y-4">
                    <div>
                        <label for="user_limit" class="block text-sm font-medium text-[rgb(var(--text-muted))] mb-1">
                            Per-User Limits <span class="text-xs font-normal opacity-70">(requests / minute)</span>
                        </label>
                        <input type="number" id="user_limit" name="user_limit" value="60" required
                            class="w-full bg-[rgb(var(--bg-card))] text-[rgb(var(--text-main))] border border-[rgb(var(--border-color))] rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[rgb(var(--brand-primary))] focus:border-[rgb(var(--brand-primary))]">
                    </div>
                    <div>
                        <label for="ip_limit" class="block text-sm font-medium text-[rgb(var(--text-muted))] mb-1">
                            Per-IP Limits <span class="text-xs font-normal opacity-70">(requests / minute)</span>
                        </label>
                        <input type="number" id="ip_limit" name="ip_limit" value="120" required
                            class="w-full bg-[rgb(var(--bg-card))] text-[rgb(var(--text-main))] border border-[rgb(var(--border-color))] rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[rgb(var(--brand-primary))] focus:border-[rgb(var(--brand-primary))]">
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-[rgb(var(--bg-card))] rounded-lg shadow-sm border border-[rgb(var(--border-color))] overflow-hidden mb-6">
            <div class="bg-[rgb(var(--item-active-bg))] px-6 py-4 border-b border-[rgb(var(--border-color))]">
                <h5 class="text-lg font-medium text-[rgb(var(--text-main))]">Channel-Specific Throttles</h5>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div>
                        <label for="sms_throttle" class="block text-sm font-medium text-[rgb(var(--text-muted))] mb-1">
                            SMS Limits <span class="text-xs font-normal opacity-70">(msgs / min)</span>
                        </label>
                        <input type="number" id="sms_throttle" name="sms_throttle" value="20"
                            class="w-full bg-[rgb(var(--bg-card))] text-[rgb(var(--text-main))] border border-[rgb(var(--border-color))] rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[rgb(var(--brand-primary))] focus:border-[rgb(var(--brand-primary))]">
                    </div>
                    <div>
                        <label for="push_throttle" class="block text-sm font-medium text-[rgb(var(--text-muted))] mb-1">
                            Push Limits <span class="text-xs font-normal opacity-70">(msgs / min)</span>
                        </label>
                        <input type="number" id="push_throttle" name="push_throttle" value="100"
                            class="w-full bg-[rgb(var(--bg-card))] text-[rgb(var(--text-main))] border border-[rgb(var(--border-color))] rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[rgb(var(--brand-primary))] focus:border-[rgb(var(--brand-primary))]">
                    </div>
                    <div>
                        <label for="email_throttle" class="block text-sm font-medium text-[rgb(var(--text-muted))] mb-1">
                            Email Limits <span class="text-xs font-normal opacity-70">(msgs / min)</span>
                        </label>
                        <input type="number" id="email_throttle" name="email_throttle" value="50"
                            class="w-full bg-[rgb(var(--bg-card))] text-[rgb(var(--text-main))] border border-[rgb(var(--border-color))] rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[rgb(var(--brand-primary))] focus:border-[rgb(var(--brand-primary))]">
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-[rgb(var(--bg-card))] rounded-lg shadow-sm border border-yellow-300 overflow-hidden mb-8">
            <div class="bg-yellow-50 px-6 py-4 border-b border-yellow-200 flex justify-between items-center">
                <h5 class="text-lg font-medium text-yellow-900">Temporary Overrides</h5>
                <button type="button" id="addOverrideBtn" class="bg-yellow-200 hover:bg-yellow-300 text-yellow-900 text-sm font-medium px-3 py-1.5 rounded transition-colors">
                    + Add Override
                </button>
            </div>
            <div class="p-6">
                <p class="text-sm text-[rgb(var(--text-muted))] mb-4">Set temporary limits for specific IPs, Users, or API Keys during maintenance or special events.</p>
                
                <div id="overridesList" class="space-y-4">
                </div>
            </div>
        </div>

        <div class="flex justify-end mb-8">
            <button type="submit" class="bg-[rgb(var(--brand-primary))] hover:bg-[rgb(var(--brand-secondary))] text-white font-semibold py-2.5 px-8 rounded-md shadow-sm transition-colors">
                Save Limits
            </button>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        
        // --- Emergency Throttling Toggle ---
        const emergencyBtn = document.getElementById('emergencyThrottleBtn');
        const emergencyText = document.getElementById('emergencyText');
        let isEmergencyActive = false;

        emergencyBtn.addEventListener('click', function(e) {
            e.preventDefault();
            isEmergencyActive = !isEmergencyActive;
            
            if(isEmergencyActive) {
                this.classList.add('emergency-active');
                this.classList.replace('bg-red-600', 'bg-red-700');
                emergencyText.innerText = "System Locked (Strict Limits)";
                // Replace Icon with a Lock
                this.querySelector('svg').outerHTML = `
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                      <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" />
                    </svg>
                `;
                alert('Emergency Throttling Enabled! System is running on minimum thresholds.');
            } else {
                this.classList.remove('emergency-active');
                this.classList.replace('bg-red-700', 'bg-red-600');
                emergencyText.innerText = "Enable Emergency Throttling";
                // Replace Icon back to warning
                this.querySelector('svg').outerHTML = `
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                      <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                `;
            }
        });

        // --- Temporary Overrides Logic ---
        const addOverrideBtn = document.getElementById('addOverrideBtn');
        const overridesList = document.getElementById('overridesList');
        let overrideCount = 0;

        addOverrideBtn.addEventListener('click', function() {
            overrideCount++;
            const rowId = 'override-' + overrideCount;
            
            // Updated template literal with CSS variables to match theme dynamically
            const rowHTML = `
                <div class="flex flex-col md:flex-row gap-4 items-end bg-[rgb(var(--item-active-bg))] p-4 rounded-md border border-[rgb(var(--border-color))]" id="${rowId}">
                    <div class="flex-1 w-full">
                        <label class="block text-xs font-medium text-[rgb(var(--text-muted))] mb-1">Target Type</label>
                        <select name="overrides[${overrideCount}][type]" class="w-full border border-[rgb(var(--border-color))] bg-[rgb(var(--bg-card))] text-[rgb(var(--text-main))] rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[rgb(var(--brand-primary))]">
                            <option value="ip">IP Address</option>
                            <option value="user">User ID</option>
                            <option value="api_key">API Key</option>
                        </select>
                    </div>
                    <div class="flex-1 w-full">
                        <label class="block text-xs font-medium text-[rgb(var(--text-muted))] mb-1">Target Identifier</label>
                        <input type="text" name="overrides[${overrideCount}][identifier]" placeholder="e.g. 192.168.1.1" 
                            class="w-full border border-[rgb(var(--border-color))] bg-[rgb(var(--bg-card))] text-[rgb(var(--text-main))] rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[rgb(var(--brand-primary))]">
                    </div>
                    <div class="flex-1 w-full">
                        <label class="block text-xs font-medium text-[rgb(var(--text-muted))] mb-1">New Limit (req/min)</label>
                        <input type="number" name="overrides[${overrideCount}][limit]" placeholder="e.g. 5000" 
                            class="w-full border border-[rgb(var(--border-color))] bg-[rgb(var(--bg-card))] text-[rgb(var(--text-main))] rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[rgb(var(--brand-primary))]">
                    </div>
                    <div class="w-full md:w-auto">
                        <button type="button" onclick="removeOverride('${rowId}')" 
                            class="w-full md:w-auto bg-[rgb(var(--bg-card))] text-red-600 border border-red-200 hover:bg-red-50 hover:border-red-300 px-4 py-2 rounded-md font-medium transition-colors">
                            Remove
                        </button>
                    </div>
                </div>
            `;
            
            overridesList.insertAdjacentHTML('beforeend', rowHTML);
        });

        // Global function to remove override row
        window.removeOverride = function(id) {
            const el = document.getElementById(id);
            if(el) { el.remove(); }
        }
    });
</script>
@endpush

 