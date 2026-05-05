@extends('Layouts.app')
@section('title', 'AI-Assisted Triage | Disputes')
@section('content')
<div class="p-4 sm:p-6 lg:p-8 bg-bg-primary min-h-screen">
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-h3 font-bold text-text-primary">AI-Assisted Triage</h1>
            <p class="text-body-sm text-text-secondary mt-1">Automated classification, precedent matching, and resolution suggestions.</p>
        </div>
    </div>

    <!-- New Incoming Queue -->
    <div class="card p-0 shadow-sm border-border-default mb-8">
        <div class="p-5 border-b border-border-default bg-bg-tertiary flex justify-between items-center">
            <h3 class="text-h4 font-bold text-text-primary">Incoming Unassigned Disputes</h3>
            <span class="px-2 py-0.5 text-[10px] uppercase font-bold bg-brand-primary/10 text-brand-primary rounded border border-brand-primary/20">AI Processing Active</span>
        </div>
        <div class="p-6">
            
            <!-- AI Triage Card -->
            <div class="p-5 border border-brand-primary/30 bg-brand-primary/5 rounded-lg flex flex-col md:flex-row gap-6">
                <!-- User Input -->
                <div class="flex-1 border-r border-border-default pr-6">
                    <p class="text-caption font-bold text-text-tertiary uppercase tracking-wider mb-2">Raw Submission (B-199)</p>
                    <p class="text-body-sm text-text-primary italic">"Hey, you charged me $129 for Growth tier but I downgraded to Starter on the 2nd of the month. I want a refund for the difference."</p>
                </div>
                <!-- AI Output -->
                <div class="flex-1 space-y-4">
                    <div class="flex justify-between items-center">
                        <p class="text-caption font-bold text-text-tertiary uppercase tracking-wider">AI Classification</p>
                        <span class="px-2 py-0.5 text-[10px] font-bold bg-semantic-success-bg text-semantic-success rounded">98% Confidence</span>
                    </div>
                    <div class="space-y-2">
                        <p class="text-body-sm"><strong class="text-text-primary">Category:</strong> Subscription Billing Dispute</p>
                        <p class="text-body-sm"><strong class="text-text-primary">Precedent Analysis:</strong> 14 similar cases. Platform policy states "Downgrades are effective next billing cycle."</p>
                        <p class="text-body-sm"><strong class="text-brand-primary">Suggested Resolution:</strong> Reject Refund Request. Provide automated policy link.</p>
                    </div>
                    <div class="pt-4 flex gap-2">
                        <button class="btn btn-primary py-2 px-4 shadow-sm w-full md:w-auto">Apply Suggestion & Resolve</button>
                        <button class="btn btn-secondary py-2 px-4 w-full md:w-auto hover:bg-bg-tertiary">Route to Human</button>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection