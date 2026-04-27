@extends('layouts.app')

@section('title', 'Plan Management & Subscriptions')

@section('content')
<div class="p-4 sm:p-6 lg:p-8 bg-bg-primary min-h-screen flex flex-col w-full" x-data="planManagement()">

    <div x-show="toast.show" x-transition class="fixed top-6 right-6 z-[100] bg-bg-secondary border-l-4 shadow-xl flex items-center gap-3 min-w-[300px] p-4 rounded-lg"
         :class="toast.type === 'error' ? 'border-semantic-error' : 'border-semantic-success'" style="display: none;" x-cloak>
        <i data-lucide="info" class="w-5 h-5" :class="toast.type === 'error' ? 'text-semantic-error' : 'text-semantic-success'"></i>
        <span x-text="toast.message" class="text-body-sm font-semibold text-text-primary"></span>
    </div>

    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 sm:mb-8 gap-4 shrink-0">
        <div class="min-w-0 flex-1">
            <h1 class="text-h3 sm:text-h2 font-bold tracking-tight text-text-primary flex items-center gap-3">
                <span class="p-2 bg-brand-primary/10 rounded-lg text-brand-primary border border-brand-primary/20 shrink-0">
                    <i data-lucide="credit-card" class="w-5 h-5 sm:w-6 sm:h-6"></i>
                </span>
                Plan Management
            </h1>
            <p class="text-text-secondary text-body-sm mt-2">Manage subscription tiers, feature limits, pricing schedules, and billing rules.</p>
        </div>

        <div class="flex flex-wrap items-center gap-3 w-full md:w-auto shrink-0">
            <button @click="openConfigModal()" class="btn btn-secondary flex-1 md:flex-none flex items-center justify-center gap-2">
                <i data-lucide="settings" class="w-4 h-4"></i> <span class="whitespace-nowrap">Global Config</span>
            </button>
            <button @click="openPlanModal()" class="btn btn-primary flex-1 md:flex-none flex items-center justify-center gap-2 shadow-lg">
                <i data-lucide="plus" class="w-4 h-4"></i> <span class="whitespace-nowrap">Create Plan</span>
            </button>
        </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6 mb-6 sm:mb-8 shrink-0">
        <div class="card p-4 sm:p-5 flex items-center gap-4">
            <div class="w-12 h-12 rounded-full bg-semantic-success-bg text-semantic-success border border-semantic-success/20 flex items-center justify-center shrink-0">
                <i data-lucide="trending-up" class="w-6 h-6"></i>
            </div>
            <div>
                <p class="text-caption font-bold text-text-tertiary uppercase tracking-wider">Total MRR</p>
                <h3 class="text-h2 font-bold text-text-primary" x-text="formatCurrency(stats.totalMrr)"></h3>
            </div>
        </div>

        <div class="card p-4 sm:p-5 flex items-center gap-4">
            <div class="w-12 h-12 rounded-full bg-brand-primary/10 text-brand-primary border border-brand-primary/20 flex items-center justify-center shrink-0">
                <i data-lucide="users" class="w-6 h-6"></i>
            </div>
            <div>
                <p class="text-caption font-bold text-text-tertiary uppercase tracking-wider">Active Subscribers</p>
                <h3 class="text-h2 font-bold text-text-primary" x-text="stats.subscribers.toLocaleString()"></h3>
            </div>
        </div>

        <div class="card p-4 sm:p-5 flex items-center gap-4">
            <div class="w-12 h-12 rounded-full bg-purple-500/10 text-purple-500 border border-purple-500/20 flex items-center justify-center shrink-0">
                <i data-lucide="layers" class="w-6 h-6"></i>
            </div>
            <div>
                <p class="text-caption font-bold text-text-tertiary uppercase tracking-wider">ARPU (Avg Rev)</p>
                <h3 class="text-h2 font-bold text-text-primary" x-text="formatCurrency(stats.arpu)"></h3>
            </div>
        </div>

        <div class="card p-4 sm:p-5 flex items-center gap-4 border-semantic-warning/30 bg-semantic-warning-bg/10">
            <div class="w-12 h-12 rounded-full bg-semantic-warning/20 text-semantic-warning flex items-center justify-center shrink-0">
                <i data-lucide="clock" class="w-6 h-6"></i>
            </div>
            <div>
                <p class="text-caption font-bold text-semantic-warning uppercase tracking-wider">Pending Price Changes</p>
                <h3 class="text-h2 font-bold text-text-primary" x-text="plans.filter(p => p.pendingChange).length"></h3>
            </div>
        </div>
    </div>

    <div class="flex items-center justify-between mb-4">
        <h2 class="text-h4 font-bold text-text-primary">Subscription Tiers</h2>
        <div class="flex items-center gap-2 text-body-sm text-text-secondary font-medium">
            <span class="flex items-center gap-1.5"><div class="w-2.5 h-2.5 rounded-full bg-semantic-success"></div> Active</span>
            <span class="flex items-center gap-1.5 ml-3"><div class="w-2.5 h-2.5 rounded-full bg-text-tertiary"></div> Deprecated</span>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-5 sm:gap-6 mb-8">
        
        <div x-show="isLoading" class="col-span-full py-12 flex flex-col items-center justify-center bg-bg-secondary rounded-2xl border border-border-default">
            <i data-lucide="loader-2" class="w-8 h-8 animate-spin text-brand-primary mb-3"></i>
            <span class="text-body font-bold text-text-primary">Loading Plans...</span>
        </div>

        <template x-for="plan in plans" :key="plan.id">
            <div class="card p-0 flex flex-col relative transition-all duration-300 hover:shadow-md border border-border-default overflow-hidden"
                 :class="!plan.isActive ? 'bg-bg-tertiary border-dashed opacity-80' : 'bg-bg-primary'">
                
                <div class="h-1.5 w-full absolute top-0 left-0" :class="plan.isActive ? 'bg-brand-primary' : 'bg-text-tertiary'"></div>

                <div class="p-5 flex-1 flex flex-col">
                    <div class="flex justify-between items-start mb-2 mt-1">
                        <div>
                            <h3 class="text-h3 font-black text-text-primary" x-text="plan.name"></h3>
                            <span x-show="!plan.isActive" class="text-[10px] bg-bg-muted text-text-tertiary border border-border-strong px-2 py-0.5 rounded font-bold uppercase tracking-wider">No New Signups</span>
                        </div>
                        <div class="p-2 rounded-lg bg-bg-secondary border border-border-default">
                            <i :data-lucide="plan.icon" class="w-5 h-5 text-brand-primary"></i>
                        </div>
                    </div>

                    <div class="mt-4 mb-5 flex items-baseline gap-1">
                        <span class="text-3xl font-black text-text-primary" x-text="plan.price === 'Custom' ? 'Custom' : '$' + plan.price"></span>
                        <span x-show="plan.price !== 'Custom'" class="text-body-sm font-bold text-text-secondary">/mo</span>
                    </div>

                    <div class="space-y-3 mb-6 bg-bg-secondary p-3 rounded-lg border border-border-default">
                        <div class="flex justify-between items-center text-body-sm">
                            <span class="text-text-secondary">Active Subscribers</span>
                            <span class="font-bold text-text-primary" x-text="plan.subscribers.toLocaleString()"></span>
                        </div>
                        <div class="flex justify-between items-center text-body-sm">
                            <span class="text-text-secondary">Generated MRR</span>
                            <span class="font-bold text-semantic-success" x-text="formatCurrency(plan.mrr)"></span>
                        </div>
                    </div>

                    <div x-show="plan.pendingChange" class="mb-4 bg-semantic-warning-bg/50 border border-semantic-warning/30 p-2.5 rounded text-caption flex items-start gap-2">
                        <i data-lucide="clock" class="w-4 h-4 text-semantic-warning shrink-0"></i>
                        <div>
                            <span class="font-bold text-semantic-warning">Price changing to <span x-text="'$' + plan.pendingChange.newPrice"></span></span>
                            <span class="block text-text-primary mt-0.5" x-text="'Effective: ' + plan.pendingChange.date"></span>
                        </div>
                    </div>

                    <div class="space-y-2 mt-auto text-caption text-text-secondary border-t border-border-default pt-4">
                        <p class="flex items-center gap-2"><i data-lucide="users" class="w-3.5 h-3.5 text-brand-primary"></i> <strong class="text-text-primary" x-text="plan.limits.team"></strong> Team Members</p>
                        <p class="flex items-center gap-2"><i data-lucide="activity" class="w-3.5 h-3.5 text-brand-primary"></i> <strong class="text-text-primary" x-text="plan.limits.jobs"></strong> Active Jobs/mo</p>
                        <p class="flex items-center gap-2"><i data-lucide="percent" class="w-3.5 h-3.5 text-brand-primary"></i> <strong class="text-text-primary" x-text="plan.limits.fee + '%'"></strong> Processing Fee</p>
                    </div>
                </div>

                <div class="border-t border-border-default bg-bg-tertiary p-3 flex justify-between items-center">
                    <button @click="openPlanModal(plan)" class="btn btn-sm btn-secondary bg-bg-primary text-text-primary hover:text-brand-primary border-border-default shadow-sm"><i data-lucide="edit-2" class="w-3.5 h-3.5 mr-1.5"></i> Edit</button>
                    
                    <div class="relative" x-data="{ open: false }" @click.away="open = false">
                        <button @click="open = !open" class="p-1.5 text-text-tertiary hover:text-text-primary rounded-md hover:bg-bg-secondary transition-colors">
                            <i data-lucide="more-horizontal" class="w-5 h-5"></i>
                        </button>
                        <div x-show="open" class="absolute right-0 bottom-full mb-1 w-48 rounded-md shadow-lg bg-bg-secondary border border-border-default z-20 py-1" x-cloak>
                            <button @click="clonePlan(plan); open = false" class="w-full text-left px-4 py-2 text-body-sm text-text-primary hover:bg-bg-tertiary flex items-center gap-2">
                                <i data-lucide="copy" class="w-4 h-4 text-text-secondary"></i> Clone Version
                            </button>
                            <button @click="openScheduleModal(plan); open = false" class="w-full text-left px-4 py-2 text-body-sm text-text-primary hover:bg-bg-tertiary flex items-center gap-2">
                                <i data-lucide="calendar-clock" class="w-4 h-4 text-semantic-warning"></i> Schedule Price Change
                            </button>
                            <div class="h-px bg-border-default my-1"></div>
                            
                            <button x-show="plan.isActive" @click="toggleStatus(plan); open = false" class="w-full text-left px-4 py-2 text-body-sm text-semantic-warning hover:bg-semantic-warning-bg flex items-center gap-2">
                                <i data-lucide="power-off" class="w-4 h-4"></i> Deactivate (Grandfather)
                            </button>
                            <button x-show="!plan.isActive" @click="toggleStatus(plan); open = false" class="w-full text-left px-4 py-2 text-body-sm text-semantic-success hover:bg-semantic-success-bg flex items-center gap-2">
                                <i data-lucide="power" class="w-4 h-4"></i> Reactivate Signup
                            </button>
                            
                            <button @click="deletePlan(plan); open = false" :disabled="plan.subscribers > 0" class="w-full text-left px-4 py-2 text-body-sm flex items-center gap-2 disabled:opacity-50 disabled:cursor-not-allowed" :class="plan.subscribers > 0 ? 'text-text-tertiary' : 'text-semantic-error hover:bg-semantic-error-bg'">
                                <i :data-lucide="plan.subscribers > 0 ? 'lock' : 'trash-2'" class="w-4 h-4"></i> Force Delete
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </template>

    </div>

    <div class="card p-0 overflow-hidden border-border-default shadow-sm mb-8">
        <div class="px-5 py-4 border-b border-border-default bg-bg-tertiary flex justify-between items-center">
            <h3 class="text-h4 font-bold text-text-primary">Feature Comparison Matrix</h3>
        </div>
        
        <div class="overflow-x-auto custom-scrollbar">
            <table class="w-full text-left border-collapse min-w-[800px]">
                <thead class="text-caption uppercase text-text-secondary font-semibold bg-bg-secondary border-b border-border-strong">
                    <tr>
                        <th class="px-5 py-4 w-1/4 border-r border-border-default">Feature / Limit</th>
                        <template x-for="plan in plans" :key="plan.id">
                            <th class="px-4 py-4 text-center border-r border-border-default bg-bg-primary">
                                <span class="text-body-sm font-bold text-brand-primary" x-text="plan.name"></span>
                            </th>
                        </template>
                    </tr>
                </thead>
                <tbody class="divide-y divide-border-default bg-bg-primary">
                    <template x-for="feature in comparisonFeatures" :key="feature.key">
                        <tr class="hover:bg-bg-secondary transition-colors">
                            <td class="px-5 py-3 font-bold text-body-sm text-text-primary border-r border-border-default bg-bg-secondary" x-text="feature.label"></td>
                            <template x-for="plan in plans" :key="plan.id">
                                <td class="px-4 py-3 text-center border-r border-border-default text-body-sm text-text-secondary">
                                    <template x-if="typeof plan.features[feature.key] === 'boolean'">
                                        <div class="flex justify-center">
                                            <i x-show="plan.features[feature.key]" data-lucide="check" class="w-4 h-4 text-semantic-success font-bold"></i>
                                            <i x-show="!plan.features[feature.key]" data-lucide="minus" class="w-4 h-4 text-text-tertiary"></i>
                                        </div>
                                    </template>
                                    <template x-if="typeof plan.features[feature.key] !== 'boolean'">
                                        <span x-text="plan.features[feature.key]" :class="plan.features[feature.key] === 'Unlimited' || plan.features[feature.key] === 'Custom' ? 'font-bold text-brand-primary' : ''"></span>
                                    </template>
                                </td>
                            </template>
                        </tr>
                    </template>
                </tbody>
            </table>
        </div>
    </div>

    <div x-show="modals.plan" class="fixed inset-0 z-[60] flex items-center justify-center bg-brand-secondary/80 backdrop-blur-sm p-4" x-cloak>
        <div class="card w-full max-w-2xl p-0 shadow-2xl flex flex-col max-h-[90vh]" @click.away="modals.plan = false">
            <div class="p-5 border-b border-border-default bg-bg-tertiary flex justify-between items-center rounded-t-xl shrink-0">
                <h3 class="text-h4 font-bold text-text-primary flex items-center gap-2">
                    <i data-lucide="layers" class="w-5 h-5 text-brand-primary"></i> <span x-text="planForm.id ? 'Edit Configuration' : 'Create Subscription Tier'"></span>
                </h3>
                <button @click="modals.plan = false" class="text-text-tertiary"><i data-lucide="x" class="w-5 h-5"></i></button>
            </div>
            
            <form @submit.prevent="savePlan" class="flex flex-col flex-1 overflow-hidden">
                <div class="p-6 space-y-6 overflow-y-auto custom-scrollbar">
                    
                    <div class="grid grid-cols-2 gap-4">
                        <div class="form-group mb-0">
                            <label class="form-label">Tier Name</label>
                            <input type="text" x-model="planForm.name" required class="form-input w-full text-body-sm" placeholder="e.g. Pro Tier">
                        </div>
                        <div class="form-group mb-0">
                            <label class="form-label">Monthly Price (<span x-text="globalConfig.currency"></span>)</label>
                            <input type="text" x-model="planForm.price" required class="form-input w-full text-body-sm" placeholder="0 or Custom">
                        </div>
                    </div>

                    <div class="h-px bg-border-default"></div>
                    <h4 class="text-body-sm font-bold text-text-primary">Core Limits</h4>

                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                        <div class="form-group mb-0">
                            <label class="form-label">Max Team Members</label>
                            <input type="text" x-model="planForm.limits.team" class="form-input w-full text-body-sm" placeholder="e.g. 5, 20, Unlimited">
                        </div>
                        <div class="form-group mb-0">
                            <label class="form-label">Active Jobs / Month</label>
                            <input type="text" x-model="planForm.limits.jobs" class="form-input w-full text-body-sm" placeholder="e.g. 50, 1000">
                        </div>
                        <div class="form-group mb-0">
                            <label class="form-label">Payment Processing Fee (%)</label>
                            <input type="number" step="0.1" x-model="planForm.limits.fee" class="form-input w-full text-body-sm" placeholder="e.g. 2.5">
                        </div>
                    </div>

                    <div class="h-px bg-border-default"></div>
                    <h4 class="text-body-sm font-bold text-text-primary">Feature Access Toggles</h4>

                    <div class="grid grid-cols-2 gap-y-3 gap-x-6">
                        <label class="flex items-center gap-3 cursor-pointer group">
                            <input type="checkbox" x-model="planForm.features.api" class="w-4 h-4 rounded border-border-strong text-brand-primary focus:ring-brand-primary/20 bg-bg-primary">
                            <span class="text-body-sm font-bold text-text-secondary group-hover:text-text-primary">API Access</span>
                        </label>
                        <label class="flex items-center gap-3 cursor-pointer group">
                            <input type="checkbox" x-model="planForm.features.sso" class="w-4 h-4 rounded border-border-strong text-brand-primary focus:ring-brand-primary/20 bg-bg-primary">
                            <span class="text-body-sm font-bold text-text-secondary group-hover:text-text-primary">SSO Integration</span>
                        </label>
                        <label class="flex items-center gap-3 cursor-pointer group">
                            <input type="checkbox" x-model="planForm.features.customBranding" class="w-4 h-4 rounded border-border-strong text-brand-primary focus:ring-brand-primary/20 bg-bg-primary">
                            <span class="text-body-sm font-bold text-text-secondary group-hover:text-text-primary">Custom Portal Branding</span>
                        </label>
                        <label class="flex items-center gap-3 cursor-pointer group">
                            <input type="checkbox" x-model="planForm.features.prioritySupport" class="w-4 h-4 rounded border-border-strong text-brand-primary focus:ring-brand-primary/20 bg-bg-primary">
                            <span class="text-body-sm font-bold text-text-secondary group-hover:text-text-primary">Priority Support SLA</span>
                        </label>
                    </div>

                </div>
                
                <div class="p-4 border-t border-border-default flex justify-end gap-3 rounded-b-xl bg-bg-tertiary shrink-0">
                    <button type="button" @click="modals.plan = false" class="btn btn-tertiary">Cancel</button>
                    <button type="submit" class="btn btn-primary" :disabled="isSaving">
                        <span x-text="planForm.id ? 'Save Configuration' : 'Create Tier'"></span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div x-show="modals.schedule" class="fixed inset-0 z-[70] flex items-center justify-center bg-brand-secondary/80 backdrop-blur-sm p-4" x-cloak>
        <div class="card w-full max-w-md p-0 shadow-2xl border-semantic-warning" @click.away="modals.schedule = false">
            <div class="p-5 border-b border-border-default bg-bg-tertiary flex items-center gap-3 rounded-t-xl">
                <div class="w-10 h-10 rounded-full bg-semantic-warning-bg text-semantic-warning flex items-center justify-center shrink-0">
                    <i data-lucide="calendar-clock" class="w-5 h-5"></i>
                </div>
                <div>
                    <h3 class="text-h4 font-bold text-text-primary">Schedule Price Change</h3>
                    <p class="text-[10px] text-text-secondary mt-0.5 uppercase tracking-wider font-bold" x-text="scheduleForm.planName"></p>
                </div>
            </div>
            
            <form @submit.prevent="executeSchedule">
                <div class="p-6 space-y-5">
                    <div class="bg-semantic-info-bg border border-semantic-info/30 rounded-lg p-4">
                        <p class="text-caption text-text-primary">Price changes automatically apply to <strong>New Signups</strong> and <strong>Upcoming Renewals</strong> on the effective date. Existing active cycles are untouched until renewal.</p>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div class="form-group mb-0">
                            <label class="form-label">New Price (<span x-text="globalConfig.currency"></span>/mo)</label>
                            <input type="number" x-model="scheduleForm.newPrice" required class="form-input w-full text-body-sm">
                        </div>
                        <div class="form-group mb-0">
                            <label class="form-label">Effective Date</label>
                            <input type="date" x-model="scheduleForm.date" required class="form-input w-full text-body-sm">
                        </div>
                    </div>
                </div>
                
                <div class="p-4 border-t border-border-default flex justify-end gap-3 rounded-b-xl bg-bg-tertiary">
                    <button type="button" @click="modals.schedule = false" class="btn btn-tertiary">Cancel</button>
                    <button type="submit" class="btn btn-primary bg-semantic-warning border-none hover:bg-orange-500 text-white shadow-lg">Schedule Update</button>
                </div>
            </form>
        </div>
    </div>

    <div x-show="modals.config" class="fixed inset-0 z-[60] flex items-center justify-center bg-brand-secondary/80 backdrop-blur-sm p-4" x-cloak>
        <div class="card w-full max-w-md p-0 shadow-2xl border-border-default" @click.away="modals.config = false">
            <div class="p-5 border-b border-border-default bg-bg-tertiary flex justify-between items-center rounded-t-xl">
                <h3 class="text-h4 font-bold text-text-primary flex items-center gap-2">
                    <i data-lucide="settings" class="w-5 h-5 text-brand-primary"></i> Global Billing Rules
                </h3>
                <button @click="modals.config = false" class="text-text-tertiary hover:text-text-primary"><i data-lucide="x" class="w-5 h-5"></i></button>
            </div>
            
            <form @submit.prevent="saveGlobalConfig">
                <div class="p-6 space-y-5">
                    
                    <div class="grid grid-cols-2 gap-4">
                        <div class="form-group mb-0">
                            <label class="form-label">Base Currency</label>
                            <select x-model="globalConfig.currency" class="form-input w-full text-body-sm">
                                <option value="AED">AED - Dirham</option>
                                <option value="USD">USD - Dollar</option>
                                <option value="GBP">GBP - Pound</option>
                            </select>
                        </div>
                        <div class="form-group mb-0">
                            <label class="form-label">Tax Handling (VAT %)</label>
                            <input type="number" step="0.1" x-model="globalConfig.tax" required class="form-input w-full text-body-sm">
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div class="form-group mb-0">
                            <label class="form-label">Trial Duration (Days)</label>
                            <select x-model="globalConfig.trial" class="form-input w-full text-body-sm">
                                <option value="0">0 (No Trial)</option>
                                <option value="7">7 Days</option>
                                <option value="14">14 Days</option>
                                <option value="30">30 Days</option>
                            </select>
                        </div>
                        <div class="form-group mb-0">
                            <label class="form-label">Grace Period (Days)</label>
                            <input type="number" x-model="globalConfig.grace" required class="form-input w-full text-body-sm" title="Days before suspension after failed payment">
                        </div>
                    </div>

                </div>
                
                <div class="p-4 border-t border-border-default flex justify-end gap-3 rounded-b-xl bg-bg-tertiary">
                    <button type="button" @click="modals.config = false" class="btn btn-tertiary">Cancel</button>
                    <button type="submit" class="btn btn-primary" :disabled="isSaving">Save Policies</button>
                </div>
            </form>
        </div>
    </div>

</div>

@push('scripts')
<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('planManagement', () => ({
        isLoading: true,
        isSaving: false,
        toast: { show: false, message: '', type: 'success' },
        
        modals: { plan: false, schedule: false, config: false },
        
        globalConfig: { currency: 'USD', tax: 5.0, trial: 14, grace: 5 },
        
        plans: [],
        planForm: { id: null, name: '', price: '', limits: { team: '', jobs: '', fee: '' }, features: { api: false, sso: false, customBranding: false, prioritySupport: false } },
        scheduleForm: { planId: null, planName: '', newPrice: '', date: '' },

        comparisonFeatures: [
            { key: 'analytics', label: 'Analytics Level' },
            { key: 'support', label: 'Support SLA' },
            { key: 'api', label: 'API Access' },
            { key: 'sso', label: 'SSO Integration' },
            { key: 'customBranding', label: 'White-label Portal' },
        ],

        init() {
            this.fetchData();
        },

        get stats() {
            return {
                totalMrr: this.plans.reduce((sum, p) => sum + p.mrr, 0),
                subscribers: this.plans.reduce((sum, p) => sum + p.subscribers, 0),
                get arpu() { return this.subscribers > 0 ? this.totalMrr / this.subscribers : 0; }
            };
        },

        async fetchData() {
            this.isLoading = true;
            await new Promise(r => setTimeout(r, 600)); // Simulate API Fast
            
             this.plans = [
                { 
                    id: 1, name: 'Starter', price: 49, icon: 'rocket', isActive: true, subscribers: 1240, mrr: 60760, pendingChange: null,
                    limits: { team: 5, jobs: 50, fee: 3.0 },
                    features: { analytics: 'Basic', support: 'Email', api: false, sso: false, customBranding: false }
                },
                { 
                    id: 2, name: 'Growth', price: 129, icon: 'trending-up', isActive: true, subscribers: 450, mrr: 58050, pendingChange: { newPrice: 149, date: '2026-06-01' },
                    limits: { team: 20, jobs: 250, fee: 2.5 },
                    features: { analytics: 'Advanced', support: 'Priority Email', api: true, sso: false, customBranding: true }
                },
                { 
                    id: 3, name: 'Scale', price: 249, icon: 'layers', isActive: true, subscribers: 180, mrr: 44820, pendingChange: null,
                    limits: { team: 50, jobs: 1000, fee: 2.2 },
                    features: { analytics: 'Full + Custom', support: 'Dedicated Manager', api: true, sso: true, customBranding: true }
                },
                { 
                    id: 4, name: 'Enterprise', price: 'Custom', icon: 'building-2', isActive: true, subscribers: 12, mrr: 35000, pendingChange: null,
                    limits: { team: 'Unlimited', jobs: 'Unlimited', fee: 'Custom' },
                    features: { analytics: 'Full + Custom', support: 'Custom SLA', api: true, sso: true, customBranding: true }
                }
            ];

            this.isLoading = false;
            this.$nextTick(() => lucide.createIcons());
        },

        formatCurrency(val) {
            if(isNaN(val)) return val;
            return new Intl.NumberFormat('en-US', { style: 'currency', currency: this.globalConfig.currency, maximumFractionDigits: 0 }).format(val);
        },

        showToast(msg, type = 'success') {
            this.toast = { show: true, message: msg, type: type };
            setTimeout(() => this.toast.show = false, 3000);
        },

        // --- Modals & Forms ---
        openConfigModal() {
            this.modals.config = true;
        },

        saveGlobalConfig() {
            this.isSaving = true;
            setTimeout(() => {
                this.isSaving = false;
                this.modals.config = false;
                this.showToast('Global billing policies synchronized successfully.');
            }, 600);
        },

        openPlanModal(plan = null) {
            if(plan) {
                // Edit
                this.planForm = JSON.parse(JSON.stringify(plan));
            } else {
                // Create
                this.planForm = { id: null, name: '', price: '', limits: { team: '', jobs: '', fee: '' }, features: { analytics: 'Standard', support: 'Standard', api: false, sso: false, customBranding: false } };
            }
            this.modals.plan = true;
        },

        savePlan() {
            this.isSaving = true;
            setTimeout(() => {
                if (this.planForm.id) {
                    const idx = this.plans.findIndex(p => p.id === this.planForm.id);
                    if(idx !== -1) {
                         this.plans[idx].name = this.planForm.name;
                        this.plans[idx].price = this.planForm.price;
                        this.plans[idx].limits = this.planForm.limits;
                        Object.assign(this.plans[idx].features, this.planForm.features);
                    }
                    this.showToast('Tier configuration updated.');
                } else {
                    this.plans.push({
                        ...this.planForm,
                        id: Date.now(),
                        icon: 'box',
                        isActive: true,
                        subscribers: 0,
                        mrr: 0,
                        pendingChange: null
                    });
                    this.showToast('New Subscription Tier created.');
                }
                this.isSaving = false;
                this.modals.plan = false;
                this.$nextTick(() => lucide.createIcons());
            }, 600);
        },

        clonePlan(plan) {
            const cloned = JSON.parse(JSON.stringify(plan));
            cloned.id = null;
            cloned.name = cloned.name + ' (V2)';
            cloned.subscribers = 0;
            cloned.mrr = 0;
            cloned.pendingChange = null;
            this.planForm = cloned;
            this.modals.plan = true;
        },

        openScheduleModal(plan) {
            this.scheduleForm = { planId: plan.id, planName: plan.name, newPrice: plan.price, date: '' };
            this.modals.schedule = true;
        },

        executeSchedule() {
            const plan = this.plans.find(p => p.id === this.scheduleForm.planId);
            if(plan) {
                plan.pendingChange = { newPrice: this.scheduleForm.newPrice, date: this.scheduleForm.date };
                this.showToast(`Price change scheduled for ${plan.name}.`);
                this.modals.schedule = false;
            }
        },

        toggleStatus(plan) {
            if(plan.isActive) {
                if(confirm(`Deactivate ${plan.name}? It will be grandfathered (no new signups) but existing subscribers will not be affected.`)) {
                    plan.isActive = false;
                    this.showToast('Plan deactivated successfully.');
                }
            } else {
                plan.isActive = true;
                this.showToast('Plan reactivated for new signups.');
            }
        },

        deletePlan(plan) {
             if(plan.subscribers > 0) {
                this.showToast('Cannot delete plan with active subscribers. Deactivate it instead.', 'error');
                return;
            }
            if(confirm(`Force delete empty plan "${plan.name}"? This cannot be undone.`)) {
                this.plans = this.plans.filter(p => p.id !== plan.id);
                this.showToast('Plan deleted.');
            }
        }
    }));
});
</script>
@endpush
@endsection