@extends('layouts.app')

@section('content')
<div class="container py-8" x-data="emergencySystem()">

    <div x-show="toast.show" x-transition class="fixed top-6 right-6 z-50 card border-l-4 shadow-xl flex items-center gap-3 min-w-[300px]"
         :class="toast.type === 'danger' ? 'border-semantic-error' : 'border-semantic-success'" style="display: none;">
        <span x-text="toast.message" class="text-body-sm font-semibold text-text-primary"></span>
    </div>

    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4 border-b border-border-default pb-6">
        <div>
            <h1 class="text-h2 font-bold tracking-tight text-text-primary flex items-center gap-3">
                <div class="p-2 bg-semantic-error-bg rounded-lg text-semantic-error border border-semantic-error/30">
                    <i data-lucide="shield-alert" class="w-6 h-6"></i>
                </div>
                Maintenance & Emergency
            </h1>
            <p class="text-text-secondary text-body-sm mt-2 ml-14">Safe intervention and kill switches during incidents.</p>
        </div>

        <div class="flex items-center gap-4">
            <div x-show="override.active" class="text-right" style="display: none;">
                <div class="text-semantic-error font-mono font-bold text-h3" x-text="formatTimer()">00:00</div>
                <div class="text-[10px] text-semantic-error/80 uppercase tracking-widest font-bold">Auto-Termination</div>
            </div>

            <button @click="handleOverrideClick()"
                :class="override.active ? 'bg-semantic-error hover:bg-red-700 animate-pulse text-white shadow-lg' : 'btn-secondary text-text-primary'"
                class="btn btn-lg flex items-center gap-3">
                <i data-lucide="key" class="w-5 h-5"></i>
                <div class="text-left leading-tight">
                    <div class="text-body-sm font-bold uppercase tracking-wide" x-text="override.active ? 'TERMINATE OVERRIDE' : 'EMERGENCY OVERRIDE'"></div>
                    <div class="text-[10px] opacity-70 font-medium" x-text="override.active ? 'Root Access Granted' : 'Request Access'"></div>
                </div>
            </button>
        </div>
    </div>

    <div class="grid grid-cols-1 xl:grid-cols-3 gap-8">

        <div class="xl:col-span-1 space-y-6">
            <div class="card p-0 flex flex-col h-full">
                <div class="p-5 border-b border-border-default bg-bg-tertiary flex justify-between items-center">
                    <h3 class="text-body font-bold text-text-primary flex items-center gap-2">Maintenance Mode</h3>
                    <div x-show="isGlobalActive" class="px-2 py-1 bg-semantic-error text-white text-[10px] font-bold uppercase rounded animate-pulse">
                        ⛔ Global Lock
                    </div>
                </div>

                <div class="p-6 space-y-5 flex-1 relative">
                    <div>
                        <label class="text-label text-text-secondary block mb-2">Scope</label>
                        <div class="grid grid-cols-3 gap-2 bg-bg-tertiary p-1 rounded-lg border border-border-default">
                            <button @click="form.scope = 'global'" :class="form.scope === 'global' ? 'bg-bg-primary text-text-primary shadow-sm border border-border-strong' : 'text-text-tertiary hover:text-text-primary'" class="py-1.5 text-caption font-medium rounded transition">Global</button>
                            <button @click="form.scope = 'module'" :class="form.scope === 'module' ? 'bg-bg-primary text-text-primary shadow-sm border border-border-strong' : 'text-text-tertiary hover:text-text-primary'" class="py-1.5 text-caption font-medium rounded transition">Module</button>
                            <button @click="form.scope = 'region'" :class="form.scope === 'region' ? 'bg-bg-primary text-text-primary shadow-sm border border-border-strong' : 'text-text-tertiary hover:text-text-primary'" class="py-1.5 text-caption font-medium rounded transition">Region</button>
                        </div>
                    </div>

                    <div x-show="form.scope === 'module'" class="form-group mb-0" style="display: none;">
                        <label class="form-label">Target Module</label>
                        <select x-model="form.target" class="form-input w-full">
                            <option value="payments">Payment Processing</option>
                            <option value="signups">Business Signups</option>
                            <option value="webhooks">Webhook Deliveries</option>
                        </select>
                    </div>

                    <div class="form-group mb-0">
                        <label class="form-label">Reason</label>
                        <select x-model="form.reason" class="form-input w-full">
                            <option value="System upgrade">System Upgrade</option>
                            <option value="Database migration">Database Migration</option>
                            <option value="Security incident">Security Incident</option>
                        </select>
                    </div>

                    <div class="form-group mb-0">
                        <label class="form-label">Public Message</label>
                        <input type="text" x-model="form.message" class="form-input w-full" placeholder="Platform is down for scheduled maintenance...">
                    </div>

                    <button @click="activateMaintenance()" class="btn btn-primary w-full">Schedule Maintenance</button>
                </div>
            </div>
        </div>

        <div class="xl:col-span-2 space-y-6">
            <div class="card p-0">
                <div class="p-5 border-b border-border-default bg-bg-tertiary flex justify-between items-center">
                    <h3 class="text-h4 font-bold text-text-primary">Service Kill Switches</h3>
                    <span class="text-caption text-semantic-error bg-semantic-error-bg px-2 py-1 border border-semantic-error/20 rounded font-bold uppercase">Emergency Use Only</span>
                </div>

                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <template x-for="service in services" :key="service.id">
                            <div class="bg-bg-secondary border border-border-default rounded-lg p-4 relative overflow-hidden group">
                                <div class="absolute left-0 top-0 bottom-0 w-1" :class="{ 'bg-semantic-success': service.status === 'operational', 'bg-semantic-warning': service.status === 'soft', 'bg-semantic-error': service.status === 'hard' }"></div>
                                
                                <div class="flex justify-between items-start pl-3 mb-4">
                                    <div>
                                        <h4 class="font-bold text-text-primary text-body-sm" x-text="service.name"></h4>
                                        <div class="text-[10px] uppercase font-mono tracking-wide mt-1 font-bold" :class="{ 'text-semantic-success': service.status === 'operational', 'text-semantic-error': service.status !== 'operational' }" x-text="service.status"></div>
                                    </div>
                                </div>
                                
                                <div class="grid grid-cols-2 gap-3 pl-3">
                                    <button @click="confirmKill(service, 'soft')" :disabled="service.status === 'soft'" class="btn btn-sm text-xs font-bold w-full" :class="service.status === 'soft' ? 'bg-semantic-warning-bg text-semantic-warning border border-semantic-warning/30 opacity-50' : 'bg-bg-primary text-semantic-warning border border-semantic-warning hover:bg-semantic-warning hover:text-white'">Soft Kill</button>
                                    
                                    <button @click="confirmKill(service, 'hard')" :disabled="service.status === 'hard'" class="btn btn-sm text-xs font-bold w-full" :class="service.status === 'hard' ? 'bg-semantic-error-bg text-semantic-error border border-semantic-error/30 opacity-50' : 'bg-bg-primary text-semantic-error border border-semantic-error hover:bg-semantic-error hover:text-white'">Hard Kill</button>
                                </div>
                            </div>
                        </template>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <div x-show="overrideModal" class="fixed inset-0 z-50 flex items-center justify-center bg-brand-secondary/90 backdrop-blur-sm" style="display:none;">
        <div class="card w-full max-w-md border border-semantic-error shadow-2xl p-0" @click.away="overrideModal = false">
            <div class="p-6">
                <div class="flex items-center gap-3 mb-6 text-semantic-error">
                    <i data-lucide="shield-alert" class="w-8 h-8"></i>
                    <h2 class="text-h3 font-bold">Emergency Override</h2>
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
                    <div class="p-3 bg-semantic-error-bg border border-semantic-error/30 rounded-md">
                        <p class="text-caption text-text-primary font-medium"><strong class="text-semantic-error">Warning:</strong> All actions during override are video recorded, logged immutably, and require an automatic postmortem generation. Max duration is 2 hours.</p>
                    </div>
                </div>
            </div>
            <div class="p-4 border-t border-border-default rounded-b-lg bg-bg-tertiary flex justify-end gap-3">
                <button @click="overrideModal = false" class="btn btn-tertiary">Cancel</button>
                <button @click="executeOverride()" class="btn btn-destructive shadow-lg">Activate Override</button>
            </div>
        </div>
    </div>

</div>

@push('scripts')
<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('emergencySystem', () => ({
            isGlobalActive: false,
            toast: { show: false, message: '', type: '' },
            form: { scope: 'global', target: 'payments', reason: 'System upgrade', message: '' },
            overrideModal: false,
            overrideReason: 'Critical System Recovery',
            override: { active: false, timeLeft: 0, timer: null },
            services: [
                { id: 'payments', name: 'Payment Processing (Stripe)', status: 'operational' },
                { id: 'signups', name: 'New Business Signups', status: 'operational' },
                { id: 'webhooks', name: 'Webhook Deliveries', status: 'operational' },
                { id: 'notifications', name: 'Email/SMS Dispatch', status: 'operational' }
            ],

            showToast(msg, type = 'success') {
                this.toast = { show: true, message: msg, type: type };
                setTimeout(() => this.toast.show = false, 3000);
            },

            activateMaintenance() {
                this.showToast('Maintenance Scheduled Successfully', 'success');
                if(this.form.scope === 'global') this.isGlobalActive = true;
            },

            confirmKill(service, type) {
                if(confirm(`Are you sure you want to execute a ${type.toUpperCase()} KILL on ${service.name}? This requires dual admin approval in production.`)) {
                    service.status = type;
                    this.showToast(`${service.name} killed (${type})`, 'danger');
                }
            },

            handleOverrideClick() {
                if (this.override.active) {
                    this.override.active = false;
                    clearInterval(this.override.timer);
                    this.showToast('Override Terminated', 'success');
                } else {
                    this.overrideModal = true;
                }
            },

            executeOverride() {
                this.overrideModal = false;
                this.override.active = true;
                this.override.timeLeft = 7200; // 2 hours max
                this.showToast('OVERRIDE ACTIVATED. Session is being recorded.', 'danger');
                
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