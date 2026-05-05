@extends('Layouts.app')
@section('title', 'Health Monitoring | External Integrations')
@section('content')
<div class="p-4 sm:p-6 lg:p-8 bg-bg-primary min-h-screen">
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-h3 font-bold text-text-primary">Vendor Health & Telemetry</h1>
            <p class="text-body-sm text-text-secondary mt-1">Uptime, latency, error rates, and API cost per call metrics.</p>
        </div>
        <select class="form-input text-sm w-40"><option>Last 24 Hours</option><option>Last 7 Days</option></select>
    </div>

    <!-- Vendor Matrix -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        
        <!-- Maps / Infra -->
        <div class="card p-6 border-border-default">
            <div class="flex justify-between items-start border-b border-border-default pb-4 mb-4">
                <div>
                    <h3 class="text-body font-bold text-text-primary">Google Maps API</h3>
                    <p class="text-caption text-text-secondary mt-1">Geocoding & Autocomplete</p>
                </div>
                <div class="text-right">
                    <p class="text-h4 font-black text-text-primary">$0.017</p>
                    <p class="text-[10px] uppercase font-bold text-text-tertiary">Cost / Call</p>
                </div>
            </div>
            <div class="grid grid-cols-3 gap-4 text-center">
                <div>
                    <p class="text-caption text-text-secondary mb-1">Uptime</p>
                    <p class="text-body-sm font-bold text-semantic-success">100%</p>
                </div>
                <div>
                    <p class="text-caption text-text-secondary mb-1">Avg Latency</p>
                    <p class="text-body-sm font-bold text-text-primary">124ms</p>
                </div>
                <div>
                    <p class="text-caption text-text-secondary mb-1">Error Rate (5xx)</p>
                    <p class="text-body-sm font-bold text-semantic-success">0.00%</p>
                </div>
            </div>
        </div>

        <!-- Twilio -->
        <div class="card p-6 border-border-default">
            <div class="flex justify-between items-start border-b border-border-default pb-4 mb-4">
                <div>
                    <h3 class="text-body font-bold text-text-primary flex items-center gap-2">WhatsApp Business (Twilio) <i data-lucide="alert-triangle" class="w-4 h-4 text-semantic-warning"></i></h3>
                    <p class="text-caption text-text-secondary mt-1">Platform Notifications</p>
                </div>
                <div class="text-right">
                    <p class="text-h4 font-black text-text-primary">$0.04</p>
                    <p class="text-[10px] uppercase font-bold text-text-tertiary">Cost / Msg</p>
                </div>
            </div>
            <div class="grid grid-cols-3 gap-4 text-center">
                <div>
                    <p class="text-caption text-text-secondary mb-1">Uptime</p>
                    <p class="text-body-sm font-bold text-semantic-warning">99.1%</p>
                </div>
                <div>
                    <p class="text-caption text-text-secondary mb-1">Avg Latency</p>
                    <p class="text-body-sm font-bold text-semantic-error">1.2s</p>
                </div>
                <div>
                    <p class="text-caption text-text-secondary mb-1">Error Rate (5xx)</p>
                    <p class="text-body-sm font-bold text-semantic-warning">1.4%</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection