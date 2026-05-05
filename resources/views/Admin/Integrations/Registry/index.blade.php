@extends('layouts.app')
@section('title', 'Integration Registry | External Integrations')
@section('content')
<div class="p-4 sm:p-6 lg:p-8 bg-bg-primary min-h-screen">
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-h3 font-bold text-text-primary">Integration Registry</h1>
            <p class="text-body-sm text-text-secondary mt-1">Govern all external service connections across the Sahor One platform.</p>
        </div>
        <button class="btn btn-primary py-2.5 px-4 shadow-sm transition-colors"><i data-lucide="plus" class="w-4 h-4 mr-2"></i> Add Integration</button>
    </div>

    <!-- Integration Categories -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        
        <!-- Payment -->
        <div class="card p-0 shadow-sm border-border-default">
            <div class="p-4 border-b border-border-default bg-bg-tertiary">
                <h3 class="text-body-sm font-bold text-text-primary uppercase tracking-wider">Payment Processing</h3>
            </div>
            <div class="p-5 space-y-4">
                <div class="flex justify-between items-center">
                    <div>
                        <p class="font-bold text-text-primary flex items-center gap-2">Stripe Connect <span class="px-2 py-0.5 text-[9px] bg-brand-primary/10 text-brand-primary border border-brand-primary/20 rounded uppercase">Primary</span></p>
                        <p class="text-caption text-text-secondary mt-0.5">Core payment infrastructure.</p>
                    </div>
                    <div class="w-2 h-2 rounded-full bg-semantic-success shadow-[0_0_8px_rgba(34,197,94,0.8)]"></div>
                </div>
                <div class="flex justify-between items-center pt-4 border-t border-border-default opacity-60">
                    <div>
                        <p class="font-bold text-text-primary">PayTabs UAE</p>
                        <p class="text-caption text-text-secondary mt-0.5">Secondary Fallback (Inactive).</p>
                    </div>
                    <div class="w-2 h-2 rounded-full bg-text-tertiary"></div>
                </div>
            </div>
        </div>

        <!-- Notifications -->
        <div class="card p-0 shadow-sm border-border-default">
            <div class="p-4 border-b border-border-default bg-bg-tertiary">
                <h3 class="text-body-sm font-bold text-text-primary uppercase tracking-wider">Notifications</h3>
            </div>
            <div class="p-5 space-y-4">
                <div class="flex justify-between items-center">
                    <div>
                        <p class="font-bold text-text-primary">Twilio SendGrid</p>
                        <p class="text-caption text-text-secondary mt-0.5">Transactional & Marketing Emails.</p>
                    </div>
                    <div class="w-2 h-2 rounded-full bg-semantic-success shadow-[0_0_8px_rgba(34,197,94,0.8)]"></div>
                </div>
                <div class="flex justify-between items-center pt-4 border-t border-border-default">
                    <div>
                        <p class="font-bold text-text-primary">WhatsApp Business API</p>
                        <p class="text-caption text-text-secondary mt-0.5">Priority support & alerts.</p>
                    </div>
                    <div class="w-2 h-2 rounded-full bg-semantic-success shadow-[0_0_8px_rgba(34,197,94,0.8)]"></div>
                </div>
            </div>
        </div>

        <!-- Analytics & APM -->
        <div class="card p-0 shadow-sm border-border-default">
            <div class="p-4 border-b border-border-default bg-bg-tertiary">
                <h3 class="text-body-sm font-bold text-text-primary uppercase tracking-wider">Telemetry & APM</h3>
            </div>
            <div class="p-5 space-y-4">
                <div class="flex justify-between items-center">
                    <div>
                        <p class="font-bold text-text-primary">Datadog</p>
                        <p class="text-caption text-text-secondary mt-0.5">Application Performance Monitoring.</p>
                    </div>
                    <div class="w-2 h-2 rounded-full bg-semantic-success shadow-[0_0_8px_rgba(34,197,94,0.8)]"></div>
                </div>
                <div class="flex justify-between items-center pt-4 border-t border-border-default">
                    <div>
                        <p class="font-bold text-text-primary">Sentry</p>
                        <p class="text-caption text-text-secondary mt-0.5">Exception & Error Tracking.</p>
                    </div>
                    <div class="w-2 h-2 rounded-full bg-semantic-success shadow-[0_0_8px_rgba(34,197,94,0.8)]"></div>
                </div>
                <div class="flex justify-between items-center pt-4 border-t border-border-default">
                    <div>
                        <p class="font-bold text-text-primary">Amplitude</p>
                        <p class="text-caption text-text-secondary mt-0.5">Product Analytics.</p>
                    </div>
                    <div class="w-2 h-2 rounded-full bg-semantic-success shadow-[0_0_8px_rgba(34,197,94,0.8)]"></div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection