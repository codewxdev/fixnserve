@extends('layouts.app')

@section('content')

<div class="min-h-screen bg-[rgb(var(--bg-body))] font-sans transition-colors duration-300">
    <div class="container mx-auto px-4 py-8">

        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 border-b border-[rgb(var(--border-color))] pb-4">
            <div>
                <h1 class="text-3xl font-bold text-[rgb(var(--text-main))] transition-colors">KYC Orchestration Engine</h1>
                <p class="text-sm text-[rgb(var(--text-muted))] mt-1 transition-colors">Intelligent Routing & Third-Party Provider Management</p>
            </div>
            
            <div class="mt-4 md:mt-0 flex space-x-3">
                <button class="bg-[rgb(var(--bg-card))] border border-[rgb(var(--border-color))] text-[rgb(var(--text-main))] px-4 py-2 rounded text-sm font-semibold hover:bg-[rgb(var(--item-active-bg))] transition-colors">
                    Add New Provider
                </button>
                <button class="bg-[rgb(var(--brand-primary))] text-white px-4 py-2 rounded text-sm font-semibold hover:bg-[rgb(var(--brand-secondary))] transition-colors">
                    Run Failover Test
                </button>
            </div>
        </div>

        <div class="mb-6">
            <nav class="flex space-x-4 border-b border-[rgb(var(--border-color))] overflow-x-auto">
                <a href="#" class="border-b-2 border-transparent text-[rgb(var(--text-muted))] hover:text-[rgb(var(--text-main))] py-3 px-4 font-medium text-sm transition-colors whitespace-nowrap">
                    5.1 Document Management
                </a>
                <a href="#" class="border-b-2 border-transparent text-[rgb(var(--text-muted))] hover:text-[rgb(var(--text-main))] py-3 px-4 font-medium text-sm transition-colors whitespace-nowrap">
                    5.2 AI Verification
                </a>
                <a href="#" class="border-b-2 border-[rgb(var(--brand-primary))] text-[rgb(var(--brand-primary))] py-3 px-4 font-semibold text-sm transition-colors whitespace-nowrap">
                    5.3 Orchestration Engine
                </a>
                <a href="#" class="border-b-2 border-transparent text-[rgb(var(--text-muted))] hover:text-[rgb(var(--text-main))] py-3 px-4 font-medium text-sm transition-colors whitespace-nowrap">
                    5.4 Entities
                </a>
                <a href="#" class="border-b-2 border-transparent text-[rgb(var(--text-muted))] hover:text-[rgb(var(--text-main))] py-3 px-4 font-medium text-sm transition-colors whitespace-nowrap">
                    5.5 Compliance
                </a>
            </nav>
        </div>

        <h3 class="text-lg font-semibold text-[rgb(var(--text-main))] mb-4">Supported Providers & API Health</h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            
            <div class="bg-[rgb(var(--bg-card))] p-5 rounded-lg shadow-sm border border-green-200 border-l-4 border-l-green-500 transition-colors duration-300">
                <div class="flex justify-between items-center mb-3">
                    <h4 class="font-bold text-[rgb(var(--text-main))] text-lg">SumSub</h4>
                    <span class="flex h-3 w-3 relative">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-3 w-3 bg-green-500"></span>
                    </span>
                </div>
                <div class="grid grid-cols-2 gap-4 text-sm">
                    <div>
                        <p class="text-[rgb(var(--text-muted))] text-xs">Latency</p>
                        <p class="font-semibold text-[rgb(var(--text-main))]">1.2s</p>
                    </div>
                    <div>
                        <p class="text-[rgb(var(--text-muted))] text-xs">Success Rate</p>
                        <p class="font-semibold text-[rgb(var(--text-main))]">99.8%</p>
                    </div>
                </div>
                <div class="mt-4 pt-3 border-t border-[rgb(var(--border-color))] flex justify-between items-center text-xs">
                    <span class="text-[rgb(var(--text-muted))]">Primary for: MENA, Asia</span>
                    <button class="text-[rgb(var(--brand-primary))] hover:underline font-medium">Configure</button>
                </div>
            </div>

            <div class="bg-[rgb(var(--bg-card))] p-5 rounded-lg shadow-sm border border-green-200 border-l-4 border-l-green-500 transition-colors duration-300">
                <div class="flex justify-between items-center mb-3">
                    <h4 class="font-bold text-[rgb(var(--text-main))] text-lg">Onfido</h4>
                    <span class="flex h-3 w-3 relative">
                        <span class="relative inline-flex rounded-full h-3 w-3 bg-green-500"></span>
                    </span>
                </div>
                <div class="grid grid-cols-2 gap-4 text-sm">
                    <div>
                        <p class="text-[rgb(var(--text-muted))] text-xs">Latency</p>
                        <p class="font-semibold text-[rgb(var(--text-main))]">1.5s</p>
                    </div>
                    <div>
                        <p class="text-[rgb(var(--text-muted))] text-xs">Success Rate</p>
                        <p class="font-semibold text-[rgb(var(--text-main))]">98.5%</p>
                    </div>
                </div>
                <div class="mt-4 pt-3 border-t border-[rgb(var(--border-color))] flex justify-between items-center text-xs">
                    <span class="text-[rgb(var(--text-muted))]">Primary for: EU, UK, NA</span>
                    <button class="text-[rgb(var(--brand-primary))] hover:underline font-medium">Configure</button>
                </div>
            </div>

            <div class="bg-[rgb(var(--bg-card))] p-5 rounded-lg shadow-sm border border-yellow-200 border-l-4 border-l-yellow-500 transition-colors duration-300">
                <div class="flex justify-between items-center mb-3">
                    <h4 class="font-bold text-[rgb(var(--text-main))] text-lg">Trulioo</h4>
                    <span class="flex h-3 w-3 relative">
                        <span class="relative inline-flex rounded-full h-3 w-3 bg-yellow-500"></span>
                    </span>
                </div>
                <div class="grid grid-cols-2 gap-4 text-sm">
                    <div>
                        <p class="text-[rgb(var(--text-muted))] text-xs">Latency</p>
                        <p class="font-semibold text-yellow-600">3.4s (High)</p>
                    </div>
                    <div>
                        <p class="text-[rgb(var(--text-muted))] text-xs">Success Rate</p>
                        <p class="font-semibold text-[rgb(var(--text-main))]">97.2%</p>
                    </div>
                </div>
                <div class="mt-4 pt-3 border-t border-[rgb(var(--border-color))] flex justify-between items-center text-xs">
                    <span class="text-[rgb(var(--text-muted))]">Role: Failover / High-Risk</span>
                    <button class="text-[rgb(var(--brand-primary))] hover:underline font-medium">Configure</button>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <div class="lg:col-span-1 space-y-6">
                <div class="bg-[rgb(var(--bg-card))] p-6 rounded-lg shadow-sm border border-[rgb(var(--border-color))] transition-colors duration-300">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-semibold text-[rgb(var(--text-main))]">Routing Rules</h3>
                        <button class="text-xs bg-[rgb(var(--item-active-bg))] text-[rgb(var(--text-main))] px-2 py-1 rounded border border-[rgb(var(--border-color))]">+ Add Rule</button>
                    </div>
                    
                    <div class="space-y-4">
                        <div class="p-3 border border-[rgb(var(--border-color))] rounded-md bg-[rgb(var(--item-active-bg))]">
                            <div class="flex justify-between items-center mb-2">
                                <span class="text-sm font-bold text-[rgb(var(--text-main))]">Pakistan & UAE</span>
                                <span class="text-xs bg-[rgb(var(--brand-primary))] text-white px-2 py-1 rounded">SumSub</span>
                            </div>
                            <p class="text-xs text-[rgb(var(--text-muted))]">Optimize for: <span class="font-medium text-[rgb(var(--text-main))]">Cost & Local ID Format</span></p>
                        </div>

                        <div class="p-3 border border-[rgb(var(--border-color))] rounded-md bg-[rgb(var(--item-active-bg))]">
                            <div class="flex justify-between items-center mb-2">
                                <span class="text-sm font-bold text-[rgb(var(--text-main))]">High-Risk Entities</span>
                                <span class="text-xs bg-gray-800 text-white px-2 py-1 rounded">Trulioo</span>
                            </div>
                            <p class="text-xs text-[rgb(var(--text-muted))]">Optimize for: <span class="font-medium text-[rgb(var(--text-main))]">Maximum Accuracy & AML Check</span></p>
                        </div>

                        <div class="p-3 border border-[rgb(var(--border-color))] border-dashed rounded-md">
                            <div class="flex justify-between items-center mb-2">
                                <span class="text-sm font-bold text-[rgb(var(--text-main))]">Global Failover</span>
                                <span class="text-xs bg-gray-200 text-gray-800 px-2 py-1 rounded">Onfido</span>
                            </div>
                            <p class="text-xs text-[rgb(var(--text-muted))]">Triggered if primary API times out (>5s)</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="lg:col-span-2">
                <div class="bg-[rgb(var(--bg-card))] rounded-lg shadow-sm border border-[rgb(var(--border-color))] overflow-hidden transition-colors duration-300">
                    <div class="px-6 py-4 border-b border-[rgb(var(--border-color))] bg-[rgb(var(--item-active-bg))] flex justify-between items-center">
                        <h3 class="text-lg font-semibold text-[rgb(var(--text-main))]">Recent Orchestration Jobs</h3>
                        <span class="text-xs text-[rgb(var(--text-muted))]">Live feed of API decisions</span>
                    </div>
                    
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-[rgb(var(--border-color))]">
                            <thead class="bg-[rgb(var(--bg-card))]">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-[rgb(var(--text-muted))] uppercase tracking-wider">Job ID & Entity</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-[rgb(var(--text-muted))] uppercase tracking-wider">Routed To</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-[rgb(var(--text-muted))] uppercase tracking-wider">Scores (AI + API)</th>
                                    <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-[rgb(var(--text-muted))] uppercase tracking-wider">Aggregated Result</th>
                                </tr>
                            </thead>
                            <tbody class="bg-[rgb(var(--bg-card))] divide-y divide-[rgb(var(--border-color))]">
                                
                                <tr class="hover:bg-[rgb(var(--item-active-bg))] transition-colors">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-[rgb(var(--brand-primary))]">#JOB-8841</div>
                                        <div class="text-xs text-[rgb(var(--text-muted))]">Mart Vendor (UAE)</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded bg-green-100 text-green-800">
                                            SumSub
                                        </span>
                                        <div class="text-[10px] text-[rgb(var(--text-muted))] mt-1">Rule: MENA Routing</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-xs text-[rgb(var(--text-main))]">AI Pre-Check: <span class="font-bold">98%</span></div>
                                        <div class="text-xs text-[rgb(var(--text-main))]">API Score: <span class="font-bold text-green-600">Approved</span></div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 border border-green-200">
                                            Auto-Approved
                                        </span>
                                    </td>
                                </tr>

                                <tr class="hover:bg-[rgb(var(--item-active-bg))] transition-colors">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-[rgb(var(--brand-primary))]">#JOB-8842</div>
                                        <div class="text-xs text-[rgb(var(--text-muted))]">Consultant (UK)</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded bg-blue-100 text-blue-800">
                                            Onfido
                                        </span>
                                        <div class="text-[10px] text-[rgb(var(--text-muted))] mt-1">Rule: EU/UK Routing</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-xs text-[rgb(var(--text-main))]">AI Pre-Check: <span class="font-bold text-yellow-600">75% (Blur)</span></div>
                                        <div class="text-xs text-[rgb(var(--text-main))]">API Score: <span class="font-bold text-yellow-600">Consider</span></div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 border border-yellow-200">
                                            Sent to Manual Queue
                                        </span>
                                    </td>
                                </tr>

                                <tr class="hover:bg-[rgb(var(--item-active-bg))] transition-colors bg-red-50/30">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-[rgb(var(--brand-primary))]">#JOB-8843</div>
                                        <div class="text-xs text-[rgb(var(--text-muted))]">Professional Expert</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded bg-gray-200 text-gray-800 line-through mr-1">
                                            Onfido
                                        </span>
                                        <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded bg-yellow-100 text-yellow-800">
                                            Trulioo
                                        </span>
                                        <div class="text-[10px] text-red-500 mt-1 font-semibold">Timeout > Failover</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-xs text-[rgb(var(--text-main))]">AI Pre-Check: <span class="font-bold">92%</span></div>
                                        <div class="text-xs text-[rgb(var(--text-main))]">API Score: <span class="font-bold text-green-600">Clear</span></div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 border border-green-200">
                                            Auto-Approved
                                        </span>
                                    </td>
                                </tr>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</div>
@endsection