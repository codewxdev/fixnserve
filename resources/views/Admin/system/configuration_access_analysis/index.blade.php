@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
        <div>
            <h2 class="text-2xl font-bold text-[rgb(var(--text-main))] flex items-center gap-2">
                Impact Analysis 
                <span class="bg-indigo-100 text-indigo-800 text-xs font-semibold px-2.5 py-0.5 rounded-full border border-indigo-200 flex items-center gap-1">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                    AI-Assisted
                </span>
            </h2>
            <p class="text-sm text-[rgb(var(--text-muted))] mt-1">Predict blast radius and mitigate risks before deploying configuration changes.</p>
        </div>
        <div>
            <button id="runAnalysisBtn" onclick="runAiAnalysis()" class="bg-[rgb(var(--brand-primary))] hover:bg-[rgb(var(--brand-secondary))] text-white font-medium py-2 px-4 rounded-md inline-flex items-center transition duration-150 ease-in-out shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[rgb(var(--brand-primary))]">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path></svg>
                Run Impact Analysis
            </button>
        </div>
    </div>

    <div class="bg-[rgb(var(--bg-card))] rounded-lg shadow-sm border border-[rgb(var(--border-color))] p-4 mb-6 flex items-center gap-4">
        <label class="text-sm font-medium text-[rgb(var(--text-main))] whitespace-nowrap">Pending Change:</label>
        <select class="block w-full max-w-xl pl-3 pr-10 py-2 text-sm border-[rgb(var(--border-color))] focus:outline-none focus:ring-[rgb(var(--brand-primary))] focus:border-[rgb(var(--brand-primary))] rounded-md border text-[rgb(var(--text-main))] bg-[rgb(var(--bg-card))]">
            <option value="draft_1">Draft #402: Increase Default Service Radius to 25km</option>
            <option value="draft_2">Draft #403: Enable Surge Pricing globally</option>
        </select>
        <span class="text-xs text-[rgb(var(--text-muted))] ml-auto">Last analyzed: 2 mins ago</span>
    </div>

    <div id="analysisResults" class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <div class="lg:col-span-1 flex flex-col gap-6">
            <div class="bg-[rgb(var(--bg-card))] rounded-lg shadow-sm border border-[rgb(var(--border-color))] p-6 text-center flex flex-col items-center justify-center h-full">
                <h3 class="text-sm font-semibold text-[rgb(var(--text-muted))] uppercase tracking-wider mb-4">Risk Impact Score</h3>
                
                <div class="relative w-32 h-32 flex items-center justify-center bg-[rgb(var(--item-active-bg))] rounded-full border-4 border-yellow-400 mb-4 shadow-inner">
                    <div class="text-3xl font-bold text-[rgb(var(--text-main))]">68<span class="text-lg text-[rgb(var(--text-muted))]">/100</span></div>
                </div>
                
                <span class="px-3 py-1 rounded-full text-sm font-semibold bg-yellow-100 text-yellow-800 border border-yellow-200">
                    Medium Risk
                </span>
                
                <p class="text-sm text-[rgb(var(--text-muted))] mt-4 text-left">
                    This configuration change modifies core geographic boundaries. It has a high potential to affect active driver routing and ETA calculations.
                </p>
            </div>
        </div>

        <div class="lg:col-span-2 flex flex-col gap-6">
            
            <div class="bg-[rgb(var(--bg-card))] rounded-lg shadow-sm border border-[rgb(var(--border-color))] overflow-hidden">
                <div class="px-6 py-4 border-b border-[rgb(var(--border-color))] bg-[rgb(var(--item-active-bg))] flex items-center gap-2">
                    <svg class="w-5 h-5 text-[rgb(var(--text-muted))]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                    <h5 class="text-lg font-semibold text-[rgb(var(--text-main))]">Dependency Graph Analysis</h5>
                </div>
                <div class="p-6">
                    <p class="text-sm text-[rgb(var(--text-muted))] mb-4">The AI has identified the following modules in the blast radius of this change:</p>
                    
                    <div class="space-y-3">
                        <div class="flex items-center justify-between p-3 rounded-md bg-[rgb(var(--item-active-bg))] border border-[rgb(var(--border-color))]">
                            <div class="flex items-center gap-3">
                                <div class="w-2 h-2 rounded-full bg-red-500"></div>
                                <span class="font-medium text-[rgb(var(--text-main))]">Routing Engine</span>
                            </div>
                            <span class="text-xs font-semibold text-red-600 bg-red-50 px-2 py-1 rounded">Critical Impact</span>
                        </div>
                        
                        <div class="flex items-center justify-between p-3 rounded-md bg-[rgb(var(--item-active-bg))] border border-[rgb(var(--border-color))]">
                            <div class="flex items-center gap-3">
                                <div class="w-2 h-2 rounded-full bg-yellow-500"></div>
                                <span class="font-medium text-[rgb(var(--text-main))]">Driver Allocation Service</span>
                            </div>
                            <span class="text-xs font-semibold text-yellow-600 bg-yellow-50 px-2 py-1 rounded">Moderate Impact</span>
                        </div>

                        <div class="flex items-center justify-between p-3 rounded-md bg-[rgb(var(--item-active-bg))] border border-[rgb(var(--border-color))]">
                            <div class="flex items-center gap-3">
                                <div class="w-2 h-2 rounded-full bg-green-500"></div>
                                <span class="font-medium text-[rgb(var(--text-main))]">Pricing API</span>
                            </div>
                            <span class="text-xs font-semibold text-green-600 bg-green-50 px-2 py-1 rounded">Low Impact</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-[rgb(var(--bg-card))] rounded-lg shadow-sm border border-[rgb(var(--brand-primary))] overflow-hidden">
                <div class="px-6 py-4 border-b border-[rgb(var(--border-color))] bg-indigo-50 flex justify-between items-center">
                    <div class="flex items-center gap-2">
                        <svg class="w-5 h-5 text-[rgb(var(--brand-primary))]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                        <h5 class="text-lg font-semibold text-[rgb(var(--brand-primary))]">AI Rollout Strategy</h5>
                    </div>
                    <button class="text-sm font-medium text-[rgb(var(--brand-primary))] hover:underline">Apply Strategy</button>
                </div>
                <div class="p-6">
                    <p class="text-sm text-[rgb(var(--text-main))] font-medium mb-3">Recommended Approach: Canary Deployment</p>
                    <ol class="relative border-l border-[rgb(var(--border-color))] ml-3 space-y-5">
                        <li class="pl-6">
                            <span class="absolute flex items-center justify-center w-6 h-6 bg-indigo-100 rounded-full -left-3 ring-4 ring-[rgb(var(--bg-card))]">
                                <span class="text-xs font-bold text-[rgb(var(--brand-primary))]">1</span>
                            </span>
                            <h3 class="font-medium text-[rgb(var(--text-main))] text-sm">Targeted Regional Test</h3>
                            <p class="text-sm text-[rgb(var(--text-muted))] mt-1">Deploy changes to the Rawalpindi sector first. This isolates the risk to a single, easily observable zone.</p>
                        </li>
                        <li class="pl-6">
                            <span class="absolute flex items-center justify-center w-6 h-6 bg-[rgb(var(--item-active-bg))] rounded-full -left-3 ring-4 ring-[rgb(var(--bg-card))]">
                                <span class="text-xs font-bold text-[rgb(var(--text-muted))]">2</span>
                            </span>
                            <h3 class="font-medium text-[rgb(var(--text-main))] text-sm">Monitor Health Metrics</h3>
                            <p class="text-sm text-[rgb(var(--text-muted))] mt-1">Halt rollout if ETA accuracy drops below 92% or timeout errors on the Routing API exceed 2% within a 30-minute window.</p>
                        </li>
                        <li class="pl-6">
                            <span class="absolute flex items-center justify-center w-6 h-6 bg-[rgb(var(--item-active-bg))] rounded-full -left-3 ring-4 ring-[rgb(var(--bg-card))]">
                                <span class="text-xs font-bold text-[rgb(var(--text-muted))]">3</span>
                            </span>
                            <h3 class="font-medium text-[rgb(var(--text-main))] text-sm">Global Availability</h3>
                            <p class="text-sm text-[rgb(var(--text-muted))] mt-1">Automatically expand to all remaining zones and remove overrides after 2 hours of stable regional testing.</p>
                        </li>
                    </ol>
                </div>
            </div>
            
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function runAiAnalysis() {
        const btn = document.getElementById('runAnalysisBtn');
        const resultsArea = document.getElementById('analysisResults');
        const originalText = btn.innerHTML;
        
        // Add a pulsing effect to simulate the AI "thinking"
        resultsArea.classList.add('opacity-50', 'animate-pulse');
        
        btn.innerHTML = `
            <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            Analyzing Graph...
        `;
        btn.disabled = true;
        btn.classList.add('opacity-75', 'cursor-not-allowed');

        setTimeout(() => {
            // Restore UI after "analysis" completes
            resultsArea.classList.remove('opacity-50', 'animate-pulse');
            btn.innerHTML = originalText;
            btn.disabled = false;
            btn.classList.remove('opacity-75', 'cursor-not-allowed');
            
        }, 2500);
    }
</script>
@endpush
