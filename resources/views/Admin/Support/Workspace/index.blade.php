@extends('layouts.app')
@section('title', 'Agent Workspace | Support')
@section('content')
<div class="p-0 bg-bg-primary min-h-screen flex flex-col md:flex-row h-screen">
    
    <!-- Left: Context Panel -->
    <div class="w-full md:w-80 border-r border-border-default bg-bg-tertiary flex flex-col overflow-y-auto">
        <div class="p-5 border-b border-border-default">
            <p class="text-[10px] font-bold uppercase text-text-tertiary tracking-wider mb-1">Business Context</p>
            <h2 class="text-h4 font-bold text-text-primary">Elevate Digital (B-1024)</h2>
            <div class="flex gap-2 mt-2">
                <span class="px-2 py-0.5 text-[10px] font-bold bg-brand-primary text-white rounded">Growth Tier</span>
                <span class="px-2 py-0.5 text-[10px] font-bold bg-semantic-success-bg text-semantic-success rounded border border-semantic-success/20">Health: 94/100</span>
            </div>
        </div>
        
        <div class="p-5 border-b border-border-default space-y-4">
            <div>
                <p class="text-[10px] font-bold uppercase text-text-tertiary mb-1">Financial Context</p>
                <p class="text-body-sm text-text-secondary">MRR: <strong class="text-text-primary">$129.00</strong></p>
                <p class="text-body-sm text-text-secondary">Last Payment: <strong class="text-semantic-success">Successful (2d ago)</strong></p>
            </div>
            <div>
                <p class="text-[10px] font-bold uppercase text-text-tertiary mb-1">Technical Context</p>
                <p class="text-body-sm text-text-secondary">Recent Errors: <strong class="text-semantic-error">3x 500 (API)</strong></p>
            </div>
        </div>

        <div class="p-5 mt-auto border-t border-border-default space-y-2">
            <p class="text-[10px] font-bold uppercase text-text-tertiary mb-2">Agent Tools (Zero-Trust)</p>
            <button class="w-full btn btn-secondary text-left justify-start py-2 text-sm"><i data-lucide="monitor-play" class="w-4 h-4 mr-2 text-brand-primary"></i> Request Screen Share</button>
            <button class="w-full btn btn-secondary text-left justify-start py-2 text-sm text-semantic-warning border-semantic-warning/30"><i data-lucide="user-check" class="w-4 h-4 mr-2"></i> Impersonate (Audited)</button>
        </div>
    </div>

    <!-- Center: Ticket Thread -->
    <div class="flex-1 flex flex-col bg-bg-primary h-full">
        <div class="p-5 border-b border-border-default flex justify-between items-center bg-bg-primary">
            <div>
                <h1 class="text-body font-bold text-text-primary">#4492: Cannot generate API key</h1>
                <p class="text-caption text-text-secondary mt-1">Submitted 2 hours ago via In-App Widget</p>
            </div>
            <span class="px-2 py-1 text-[10px] font-bold uppercase bg-semantic-warning-bg text-semantic-warning rounded border border-semantic-warning/20">P2 High</span>
        </div>
        
        <div class="flex-1 p-6 overflow-y-auto space-y-6 bg-bg-secondary">
            <!-- Client Message -->
            <div class="bg-bg-primary border border-border-default p-4 rounded-lg rounded-tl-none w-3/4 shadow-sm">
                <p class="text-caption font-bold text-text-secondary mb-2">Sarah Jenkins (Client)</p>
                <p class="text-body-sm text-text-primary">Hi, I just upgraded to the Growth tier but the API key generation button is still disabled for me. Please help.</p>
            </div>
            <!-- AI Assistant Suggestion -->
            <div class="bg-brand-primary/5 border border-brand-primary/30 p-4 rounded-lg w-3/4 ml-auto relative">
                <div class="absolute -top-3 left-4 bg-brand-primary text-white text-[10px] font-bold uppercase px-2 py-0.5 rounded">AI Suggestion</div>
                <p class="text-body-sm text-text-primary mt-2">"Hi Sarah, I see your Growth tier upgrade was successful. Please log out and log back in to refresh your entitlement cache. If the button is still disabled, let me know!"</p>
                <div class="mt-3 flex gap-2">
                    <button class="btn btn-sm btn-primary py-1 px-3">Use Reply</button>
                    <button class="btn btn-sm btn-secondary text-text-tertiary py-1 px-3 border-transparent hover:bg-brand-primary/10">Dismiss</button>
                </div>
            </div>
        </div>

        <div class="p-4 border-t border-border-default bg-bg-primary">
            <textarea class="form-input w-full p-3 h-24 text-sm resize-none" placeholder="Type your reply or use '/' for canned responses..."></textarea>
            <div class="flex justify-between items-center mt-3">
                <div class="flex gap-2">
                    <button class="text-text-tertiary hover:text-brand-primary p-2"><i data-lucide="paperclip" class="w-4 h-4"></i></button>
                    <button class="text-text-tertiary hover:text-brand-primary p-2"><i data-lucide="file-text" class="w-4 h-4"></i></button>
                </div>
                <div class="flex gap-2">
                    <button class="btn btn-secondary py-2 px-4 transition-colors">Add Internal Note</button>
                    <button class="btn btn-primary py-2 px-4 transition-colors">Send & Resolve</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection