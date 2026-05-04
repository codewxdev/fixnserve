@extends('layouts.app')
@section('title', 'Key Management | Payments')
@section('content')
<div class="p-4 sm:p-6 lg:p-8 bg-bg-primary min-h-screen">
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-h3 font-bold text-text-primary">API Key Management</h1>
            <p class="text-body-sm text-text-secondary mt-1">Stripe credentials, HSM storage status, and 180-day rotation enforcement.</p>
        </div>
    </div>

    <!-- Security Status -->
    <div class="mb-8 p-4 bg-semantic-success-bg/30 border border-semantic-success/30 rounded-lg flex justify-between items-center">
        <div class="flex items-center gap-3">
            <i data-lucide="shield-check" class="w-6 h-6 text-semantic-success"></i>
            <div>
                <p class="text-body-sm font-bold text-text-primary">HSM Storage Active</p>
                <p class="text-caption text-text-secondary">Secrets are encrypted at rest. No plaintext exposure in codebase.</p>
            </div>
        </div>
        <p class="text-caption font-bold text-text-tertiary text-right">Last Rotation: 45 Days Ago</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <!-- Live Keys -->
        <div class="card p-0 shadow-sm border-semantic-warning/30">
            <div class="p-5 border-b border-border-default bg-semantic-warning/5 flex items-center gap-2">
                <div class="w-2 h-2 rounded-full bg-semantic-warning animate-pulse"></div>
                <h3 class="text-h4 font-bold text-text-primary">Production (Live) Keys</h3>
            </div>
            <div class="p-6 space-y-6">
                <div>
                    <label class="text-caption font-bold text-text-tertiary uppercase mb-1 block">Live Publishable Key</label>
                    <div class="flex">
                        <input type="text" value="pk_live_51Nx...XXXX" readonly class="form-input w-full font-mono text-sm bg-bg-secondary rounded-r-none border-r-0 text-text-secondary">
                        <button class="btn btn-secondary rounded-l-none border-border-strong border-l-0 px-3"><i data-lucide="copy" class="w-4 h-4 text-text-tertiary"></i></button>
                    </div>
                </div>
                <div>
                    <label class="text-caption font-bold text-text-tertiary uppercase mb-1 block">Live Secret Key</label>
                    <div class="flex">
                        <input type="password" value="sk_live_dummydata" readonly class="form-input w-full font-mono text-sm bg-bg-secondary rounded-r-none border-r-0 text-text-secondary">
                        <button class="btn btn-secondary rounded-l-none border-border-strong border-l-0 px-3"><i data-lucide="eye" class="w-4 h-4 text-text-tertiary"></i></button>
                    </div>
                </div>
                <div>
                    <label class="text-caption font-bold text-text-tertiary uppercase mb-1 block">Webhook Signing Secret</label>
                    <input type="password" value="whsec_dummydata" readonly class="form-input w-full font-mono text-sm bg-bg-secondary text-text-secondary">
                </div>
                <div class="pt-4 border-t border-border-default space-y-3">
                    <button class="w-full btn btn-secondary text-brand-primary border-brand-primary/30 hover:bg-brand-primary/10 transition-colors py-2.5"><i data-lucide="refresh-cw" class="w-4 h-4 mr-2"></i> Rotate Keys (Dual Approval)</button>
                    <button class="w-full btn btn-destructive py-2.5 shadow-sm shadow-semantic-error/20"><i data-lucide="power-off" class="w-4 h-4 mr-2"></i> Revoke All Live Keys (Emergency)</button>
                </div>
            </div>
        </div>

        <!-- Sandbox Keys -->
        <div class="card p-0 shadow-sm border-border-default">
            <div class="p-5 border-b border-border-default bg-bg-tertiary flex items-center gap-2">
                <div class="w-2 h-2 rounded-full bg-text-tertiary"></div>
                <h3 class="text-h4 font-bold text-text-primary">Sandbox (Test) Keys</h3>
            </div>
            <div class="p-6 space-y-6">
                <div>
                    <label class="text-caption font-bold text-text-tertiary uppercase mb-1 block">Test Publishable Key</label>
                    <input type="text" value="pk_test_51Nx...YYYY" readonly class="form-input w-full font-mono text-sm bg-bg-secondary text-text-secondary">
                </div>
                <div>
                    <label class="text-caption font-bold text-text-tertiary uppercase mb-1 block">Test Secret Key</label>
                    <input type="password" value="sk_test_dummydata" readonly class="form-input w-full font-mono text-sm bg-bg-secondary text-text-secondary">
                </div>
                <div class="pt-4 border-t border-border-default">
                    <button class="w-full btn btn-secondary hover:bg-bg-tertiary transition-colors py-2.5"><i data-lucide="check-circle" class="w-4 h-4 mr-2"></i> Validate Test Keys</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection