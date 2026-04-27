@extends('layouts.app')

@section('title', 'Maintenance & Emergency')

@section('content')
<div class="container py-8" x-data="emergencySystem()">

    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4 border-b border-border-default pb-6">
        <div>
            <h1 class="text-h2 font-bold tracking-tight text-text-primary flex items-center gap-3">
                <div class="p-2 bg-semantic-error-bg rounded-lg text-semantic-error border border-semantic-error/30">
                    <i data-lucide="shield-alert" class="w-6 h-6"></i>
                </div>
                Maintenance & Emergency
            </h1>
            <p class="text-text-secondary text-body-sm mt-2 ml-14">Safe intervention, impact estimation, and platform kill switches.</p>
        </div>

        <div class="flex items-center gap-4">
            <div x-show="override.active" class="text-right" x-cloak>
                <div class="text-semantic-error font-mono font-bold text-h3" x-text="formatTimer()"></div>
                <div class="text-[10px] text-semantic-error/80 uppercase tracking-widest font-bold">Auto-Termination</div>
            </div>

            <button @click="handleOverrideClick()"
                :class="override.active ? 'bg-semantic-error hover:bg-red-700 animate-pulse text-white shadow-lg' : 'btn-secondary text-text-primary'"
                class="btn btn-lg flex items-center gap-3">
                <i data-lucide="key" class="w-5 h-5"></i>
                <div class="text-left leading-tight">
                    <div class="text-body-sm font-bold uppercase tracking-wide" x-text="override.active ? 'TERMINATE OVERRIDE' : 'EMERGENCY OVERRIDE'"></div>
                    <div class="text-[10px] opacity-70 font-medium" x-text="override.active ? 'Root Access Granted (Max 2H)' : 'Request Root Access'"></div>
                </div>
            </button>
        </div>
    </div>

    <div class="grid grid-cols-1 xl:grid-cols-3 gap-8">

        <div class="xl:col-span-1 space-y-6">
            <div class="card p-0 flex flex-col h-full">
                <div class="p-5 border-b border-border-default bg-bg-tertiary">
                    <h3 class="text-body font-bold text-text-primary">Maintenance Mode</h3>
                </div>

                <div class="p-6 space-y-5 flex-1">
                    
                    <div class="form-group mb-0">
                        <label class="form-label">Scope</label>
                        <select x-model="form.scope" class="form-input w-full">
                            <option value="global">Global Platform</option>
                            <option value="module">Specific Module</option>
                            <option value="region">Specific Region</option>
                        </select>
                    </div>

                    <div class="p-4 bg-semantic-info-bg border border-semantic-info/30 rounded-lg">
                        <h4 class="text-caption font-bold text-semantic-info uppercase tracking-wider mb-2">Business Impact Estimator</h4>
                        <div class="flex justify-between text-body-sm text-text-primary font-bold">
                            <span>Affected Businesses:</span>
                            <span x-text="form.scope === 'global' ? '1,240 (100%)' : '450 (~36%)'"></span>
                        </div>
                    </div>

                    <div class="form-group mb-0">
                        <label class="form-label">Public Message (Multi-language Support)</label>
                        <textarea x-model="form.message" class="form-input w-full" rows="2" placeholder="Platform is down for scheduled maintenance..."></textarea>
                    </div>

                    <label class="flex items-center gap-3 cursor-pointer">
                        <input type="checkbox" x-model="form.preNotify" class="w-4 h-4 rounded border-border-strong text-brand-primary focus:ring-brand-primary/20 bg-bg-primary">
                        <span class="text-body-sm font-bold text-text-primary">Send Pre-Notification Email to Businesses</span>
                    </label>

                    <button @click="activateMaintenance()" class="btn btn-primary w-full">Schedule Maintenance</button>
                </div>
            </div>
        </div>

        <div class="xl:col-span-2 space-y-6">
            <div class="card p-0">
                <div class="p-5 border-b border-border-default bg-bg-tertiary flex justify-between items-center">
                    <div>
                        <h3 class="text-h4 font-bold text-text-primary">Service Kill Switches</h3>
                        <p class="text-caption text-text-secondary mt-0.5">Max 4 hours auto-expiry. Dual approval strictly enforced.</p>
                    </div>
                    <span class="text-caption text-semantic-error bg-semantic-error-bg px-2 py-1 border border-semantic-error/20 rounded font-bold uppercase">Emergency Use Only</span>
                </div>

                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <template x-for="service in services" :key="service.id">
                            <div class="bg-bg-secondary border border-border-default rounded-lg p-4 relative overflow-hidden">
                                <div class="absolute left-0 top-0 bottom-0 w-1" :class="{ 'bg-semantic-success': service.status === 'operational', 'bg-semantic-warning': service.status === 'soft', 'bg-semantic-error': service.status === 'hard' }"></div>
                                
                                <div class="flex justify-between items-start pl-3 mb-4">
                                    <div>
                                        <h4 class="font-bold text-text-primary text-body-sm" x-text="service.name"></h4>
                                        <div class="text-[10px] uppercase font-mono tracking-wide mt-1 font-bold" :class="{ 'text-semantic-success': service.status === 'operational', 'text-semantic-error': service.status !== 'operational' }" x-text="service.status"></div>
                                    </div>
                                </div>
                                
                                <div class="grid grid-cols-2 gap-3 pl-3">
                                    <button @click="confirmKill(service, 'soft')" :disabled="service.status === 'soft'" class="btn btn-sm text-xs font-bold w-full" :class="service.status === 'soft' ? 'bg-semantic-warning-bg text-semantic-warning border border-semantic-warning/30 opacity-50' : 'bg-bg-primary text-semantic-warning border border-semantic-warning hover:bg-semantic-warning hover:text-white'" title="Graceful Degradation">Soft Kill</button>
                                    
                                    <button @click="confirmKill(service, 'hard')" :disabled="service.status === 'hard'" class="btn btn-sm text-xs font-bold w-full" :class="service.status === 'hard' ? 'bg-semantic-error-bg text-semantic-error border border-semantic-error/30 opacity-50' : 'bg-bg-primary text-semantic-error border border-semantic-error hover:bg-semantic-error hover:text-white'" title="Immediate Stop">Hard Kill</button>
                                </div>
                            </div>
                        </template>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <div x-show="overrideModal" class="fixed inset-0 z-50 flex items-center justify-center bg-brand-secondary/90 backdrop-blur-sm" x-cloak>
        <div class="card w-full max-w-md border border-semantic-error shadow-2xl p-0" @click.away="overrideModal = false">
            <div class="p-6">
                <div class="flex items-center gap-3 mb-6 text-semantic-error">
                    <i data-lucide="shield-alert" class="w-8 h-8"></i>
                    <h2 class="text-h3 font-bold">Emergency Override Request</h2>
                </div>
                <div class="space-y-4">
                    <div class="form-group mb-0">
                        <label class="form-label">Justification (Required)</label>
                        <select x-model="overrideReason" class="form-input w-full">
                            <option value="Critical System Recovery">Critical System Recovery</option>
                            <option value="Database Incident">Database Incident</option>
                            <option value="Security Breach">Security Breach</option>
                        </select>
                    </div>
                    
                    <div class="form-group mb-0">
                        <label class="form-label">MFA Token (Hardware Key Required)</label>
                        <input type="text" placeholder="Enter 6-digit TOTP or tap YubiKey" class="form-input w-full font-mono text-center tracking-widest">
                    </div>

                    <div class="p-3 bg-semantic-error-bg border border-semantic-error/30 rounded-md">
                        <p class="text-caption text-text-primary font-medium"><strong class="text-semantic-error">Strict Policy:</strong> Actions during override are video recorded, logged immutably, and mandate a postmortem. Max duration: 2 hours.</p>
                    </div>
                </div>
            </div>
            <div class="p-4 border-t border-border-default rounded-b-lg bg-bg-tertiary flex justify-end gap-3">
                <button @click="overrideModal = false" class="btn btn-tertiary">Cancel</button>
                <button @click="executeOverride()" class="btn btn-destructive shadow-lg">Verify & Activate</button>
            </div>
        </div>
    </div>

</div>

@push('scripts')
<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('emergencySystem', () => ({
            form: { scope: 'global', message: '', preNotify: false },
            overrideModal: false,
            overrideReason: 'Critical System Recovery',
            override: { active: false, timeLeft: 0, timer: null },
            
            // Spec: Explicit Targets for Kill Switch
            services: [
                { id: 'payments', name: 'Payment Processing (Stripe)', status: 'operational' },
                { id: 'signups', name: 'New Business Signups', status: 'operational' },
                { id: 'existing_ops', name: 'Existing Business Operations', status: 'operational' },
                { id: 'webhooks', name: 'Webhook Deliveries', status: 'operational' },
                { id: 'notifications', name: 'Email/SMS Notifications', status: 'operational' }
            ],

            activateMaintenance() {
                alert(`Maintenance scheduled. Pre-notification: ${this.form.preNotify ? 'Yes' : 'No'}. Impact analyzed.`);
            },

            confirmKill(service, type) {
                if(confirm(`WARNING: Executing a ${type.toUpperCase()} KILL on ${service.name}. This triggers a Dual Approval request and implements a 4-hour auto-expiry. Proceed?`)) {
                    alert(`Kill Switch request routed to secondary approver via Slack.`);
                }
            },

            handleOverrideClick() {
                if (this.override.active) {
                    this.override.active = false;
                    clearInterval(this.override.timer);
                    alert('Override Terminated. Video recording stopped.');
                } else {
                    this.overrideModal = true;
                }
            },

            executeOverride() {
                this.overrideModal = false;
                this.override.active = true;
                this.override.timeLeft = 7200; // 2 hours strictly enforced
                
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
                return `${String(m).padStart(2, '0')}:${String(s).padStart(2, '0')}`;
            }
        }));
    });
</script>
@endpush
@endsection