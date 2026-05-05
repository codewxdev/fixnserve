@extends('Layouts.app')
@section('title', 'Vendor Performance | External Integrations')
@section('content')
<div class="p-4 sm:p-6 lg:p-8 bg-bg-primary min-h-screen">
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-h3 font-bold text-text-primary">Vendor Performance & SLAs</h1>
            <p class="text-body-sm text-text-secondary mt-1">Track financial efficiency, SLA adherence, and alternative vendor comparisons.</p>
        </div>
    </div>

    <!-- Global Vendor Spend -->
    <div class="mb-8 card p-6 border-border-default bg-bg-tertiary flex flex-col md:flex-row justify-between items-center gap-6">
        <div>
            <p class="text-caption font-bold text-text-tertiary uppercase">Total Vendor Spend (MTD)</p>
            <h2 class="text-h2 font-black text-text-primary mt-1">$4,250.00</h2>
            <p class="text-caption text-semantic-success mt-1">Under projected budget by 8%</p>
        </div>
        <div class="flex gap-2">
            <button class="btn btn-secondary py-2.5 px-4"><i data-lucide="download" class="w-4 h-4 mr-2"></i> Export Expense Report</button>
        </div>
    </div>

    <!-- Vendor Matrix -->
    <div class="card p-0 shadow-sm border-border-default">
        <div class="p-5 border-b border-border-default bg-bg-primary flex justify-between items-center">
            <h3 class="text-h4 font-bold text-text-primary">Primary vs Alternative Vendors</h3>
        </div>
        <table class="w-full text-left whitespace-nowrap">
            <thead class="text-caption uppercase text-text-secondary font-semibold border-b border-border-strong bg-bg-tertiary">
                <tr>
                    <th class="px-6 py-4">Vendor & Category</th>
                    <th class="px-6 py-4">MTD Spend</th>
                    <th class="px-6 py-4">SLA Adherence</th>
                    <th class="px-6 py-4">Alternative Benchmarking</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-border-default">
                <!-- Stripe -->
                <tr class="hover:bg-bg-secondary transition-colors">
                    <td class="px-6 py-4">
                        <p class="text-body-sm font-bold text-text-primary">Stripe</p>
                        <p class="text-[10px] text-text-secondary uppercase tracking-wider font-bold mt-0.5">Payment Processor</p>
                    </td>
                    <td class="px-6 py-4 text-body-sm font-bold text-text-primary">$3,200.00</td>
                    <td class="px-6 py-4"><span class="px-2 py-0.5 bg-semantic-success-bg border border-semantic-success/20 text-semantic-success rounded font-bold text-[10px] uppercase">Pass (99.99%)</span></td>
                    <td class="px-6 py-4">
                        <p class="text-caption text-text-secondary">vs <strong class="text-text-primary">PayTabs</strong>: Stripe is $400 more expensive, but boasts 4% higher success rate.</p>
                    </td>
                </tr>
                <!-- Twilio -->
                <tr class="hover:bg-bg-secondary transition-colors">
                    <td class="px-6 py-4">
                        <p class="text-body-sm font-bold text-text-primary">Twilio / SendGrid</p>
                        <p class="text-[10px] text-text-secondary uppercase tracking-wider font-bold mt-0.5">Notifications</p>
                    </td>
                    <td class="px-6 py-4 text-body-sm font-bold text-text-primary">$850.00</td>
                    <td class="px-6 py-4"><span class="px-2 py-0.5 bg-semantic-warning-bg border border-semantic-warning/20 text-semantic-warning rounded font-bold text-[10px] uppercase">Warning (99.1%)</span></td>
                    <td class="px-6 py-4">
                        <p class="text-caption text-text-secondary">vs <strong class="text-text-primary">MessageBird</strong>: Competitor offers 12% lower cost per WhatsApp msg.</p>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection