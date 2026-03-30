@extends('layouts.app')

@section('content')

<style>
    body.theme-saas {
        --brand-primary: 79, 70, 229;
        --brand-secondary: 67, 56, 202;
        --bg-body: 243, 244, 246;
        --bg-card: 255, 255, 255;
        --bg-sidebar: 255, 255, 255;
        --border-color: 229, 231, 235;
        --sidebar-border: 229, 231, 235;
        --text-main: 17, 24, 39;
        --text-muted: 107, 114, 128;
        --item-active-bg: 243, 244, 246;
    }
</style>

<div class="min-h-screen bg-[rgb(var(--bg-body))] font-sans transition-colors duration-300">
    <div class="container mx-auto px-4 py-8">

        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 border-b border-[rgb(var(--border-color))] pb-4">
            <div class="mb-4 md:mb-0">
                <h1 class="text-3xl font-bold text-[rgb(var(--text-main))] transition-colors">KYC & Document Verification</h1>
                <p class="text-sm text-[rgb(var(--text-muted))] mt-1 transition-colors">Enterprise Identity Assurance, Compliance & Trust Engine</p>
            </div>
            <div class="flex space-x-4">
                <div class="bg-red-50 text-red-700 px-4 py-2 rounded shadow-sm border border-red-100">
                    <span class="block text-xs uppercase font-bold tracking-wider">High Risk</span>
                    <span class="text-lg font-bold">3 Alerts</span>
                </div>
                <div class="bg-yellow-50 text-yellow-700 px-4 py-2 rounded shadow-sm border border-yellow-100">
                    <span class="block text-xs uppercase font-bold tracking-wider">Pending Review</span>
                    <span class="text-lg font-bold">12 Docs</span>
                </div>
                <div class="bg-green-50 text-green-700 px-4 py-2 rounded shadow-sm border border-green-100">
                    <span class="block text-xs uppercase font-bold tracking-wider">System Status</span>
                    <span class="text-lg font-bold">Active</span>
                </div>
            </div>
        </div>

        <div class="mb-6">
            <nav class="flex space-x-4 border-b border-[rgb(var(--border-color))] overflow-x-auto">
                <a href="#" class="border-b-2 border-[rgb(var(--brand-primary))] text-[rgb(var(--brand-primary))] py-3 px-4 font-semibold text-sm transition-colors whitespace-nowrap">
                    5.1 Document Management
                </a>
                <a href="#" class="border-b-2 border-transparent text-[rgb(var(--text-muted))] hover:text-[rgb(var(--text-main))] py-3 px-4 font-medium text-sm transition-colors whitespace-nowrap">
                    5.2 AI Verification
                </a>
                <a href="#" class="border-b-2 border-transparent text-[rgb(var(--text-muted))] hover:text-[rgb(var(--text-main))] py-3 px-4 font-medium text-sm transition-colors whitespace-nowrap">
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

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            
            <div class="lg:col-span-1 space-y-6">
                
                <div class="bg-[rgb(var(--bg-card))] p-6 rounded-lg shadow-sm border border-[rgb(var(--border-color))] transition-colors duration-300">
                    <h3 class="text-lg font-semibold text-[rgb(var(--text-main))] mb-4">Secure Document Ingestion</h3>
                    <form action="#" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-[rgb(var(--text-main))] mb-1">Entity Type</label>
                            <select class="w-full border-[rgb(var(--border-color))] bg-[rgb(var(--bg-card))] text-[rgb(var(--text-main))] rounded-md shadow-sm focus:ring-[rgb(var(--brand-primary))] focus:border-[rgb(var(--brand-primary))]">
                                <option>Service Provider</option>
                                <option>Professional Expert</option>
                                <option>Mart Vendor</option>
                                <option>Rider</option>
                            </select>
                        </div>
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-[rgb(var(--text-main))] mb-1">Document Type</label>
                            <select class="w-full border-[rgb(var(--border-color))] bg-[rgb(var(--bg-card))] text-[rgb(var(--text-main))] rounded-md shadow-sm focus:ring-[rgb(var(--brand-primary))] focus:border-[rgb(var(--brand-primary))]">
                                <option>Government ID (Front & Back)</option>
                                <option>Trade License</option>
                                <option>Tax Document</option>
                            </select>
                        </div>
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-[rgb(var(--text-main))] mb-1">Upload File</label>
                            <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-[rgb(var(--border-color))] border-dashed rounded-md hover:border-[rgb(var(--brand-primary))] transition-colors">
                                <div class="space-y-1 text-center">
                                    <svg class="mx-auto h-12 w-12 text-[rgb(var(--text-muted))]" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                        <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                    <div class="flex text-sm text-[rgb(var(--text-muted))] justify-center">
                                        <label for="file-upload" class="relative cursor-pointer bg-[rgb(var(--bg-card))] rounded-md font-medium text-[rgb(var(--brand-primary))] hover:text-[rgb(var(--brand-secondary))] focus-within:outline-none">
                                            <span>Upload a file</span>
                                            <input id="file-upload" name="file-upload" type="file" class="sr-only">
                                        </label>
                                        <p class="pl-1">or drag and drop</p>
                                    </div>
                                    <p class="text-xs text-[rgb(var(--text-muted))]">PNG, JPG, PDF up to 10MB</p>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="w-full bg-[rgb(var(--brand-primary))] text-white font-semibold py-2 px-4 rounded hover:bg-[rgb(var(--brand-secondary))] transition-colors">
                            Run AI Pre-Check & Upload
                        </button>
                    </form>
                </div>
                
                <div class="bg-[rgb(var(--bg-card))] p-6 rounded-lg shadow-sm border border-[rgb(var(--border-color))] transition-colors duration-300">
                    <h3 class="text-lg font-semibold text-[rgb(var(--text-main))] mb-4">Expiry Tracking</h3>
                    <ul class="space-y-3">
                        <li class="flex justify-between items-center text-sm">
                            <span class="text-[rgb(var(--text-muted))]">Vendor Trade Licenses</span>
                            <span class="text-red-600 font-semibold">4 Expiring &lt; 30 days</span>
                        </li>
                        <li class="flex justify-between items-center text-sm">
                            <span class="text-[rgb(var(--text-muted))]">Rider Driving Licenses</span>
                            <span class="text-yellow-600 font-semibold">12 Expiring &lt; 60 days</span>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="lg:col-span-2">
                <div class="bg-[rgb(var(--bg-card))] rounded-lg shadow-sm border border-[rgb(var(--border-color))] overflow-hidden transition-colors duration-300">
                    <div class="px-6 py-4 border-b border-[rgb(var(--border-color))] bg-[rgb(var(--item-active-bg))] flex justify-between items-center transition-colors">
                        <h3 class="text-lg font-semibold text-[rgb(var(--text-main))]">Manual Review Queue (Risk-Based)</h3>
                        <button class="text-sm text-[rgb(var(--brand-primary))] font-medium hover:text-[rgb(var(--brand-secondary))]">View SLA Dashboard</button>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-[rgb(var(--border-color))]">
                            <thead class="bg-[rgb(var(--bg-card))] transition-colors">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-[rgb(var(--text-muted))] uppercase tracking-wider">Entity</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-[rgb(var(--text-muted))] uppercase tracking-wider">Document</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-[rgb(var(--text-muted))] uppercase tracking-wider">AI Confidence</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-[rgb(var(--text-muted))] uppercase tracking-wider">SLA / Status</th>
                                    <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-[rgb(var(--text-muted))] uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-[rgb(var(--bg-card))] divide-y divide-[rgb(var(--border-color))] transition-colors">
                                <tr class="hover:bg-[rgb(var(--item-active-bg))] transition-colors">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div>
                                                <div class="text-sm font-medium text-[rgb(var(--text-main))]">Ali Khan</div>
                                                <div class="text-sm text-[rgb(var(--text-muted))]">Rider #R-8922</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-[rgb(var(--text-main))]">Government ID</div>
                                        <div class="text-xs text-[rgb(var(--text-muted))]">Uploaded: 2 hours ago</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                            72% (Blurry)
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        <span class="text-red-500 font-semibold">2h Left</span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <button class="text-[rgb(var(--brand-primary))] hover:text-[rgb(var(--brand-secondary))] mr-3">Review</button>
                                    </td>
                                </tr>
                                
                                <tr class="hover:bg-[rgb(var(--item-active-bg))] transition-colors">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div>
                                                <div class="text-sm font-medium text-[rgb(var(--text-main))]">TechMart Ltd</div>
                                                <div class="text-sm text-[rgb(var(--text-muted))]">Mart Vendor #V-102</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-[rgb(var(--text-main))]">Trade License</div>
                                        <div class="text-xs text-[rgb(var(--text-muted))]">Uploaded: 5 hours ago</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                            Tamper Suspected
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        <span class="text-yellow-600 font-semibold">12h Left</span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium flex justify-end space-x-2">
                                        <button class="text-green-600 hover:text-green-800">Approve</button>
                                        <button class="text-red-600 hover:text-red-800">Reject</button>
                                        <button class="text-[rgb(var(--text-main))] hover:text-[rgb(var(--brand-primary))]">Escalate</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="bg-[rgb(var(--bg-card))] px-4 py-3 border-t border-[rgb(var(--border-color))] sm:px-6 transition-colors">
                        <div class="flex justify-between items-center">
                            <div class="text-sm text-[rgb(var(--text-muted))]">Showing <span class="font-medium text-[rgb(var(--text-main))]">1</span> to <span class="font-medium text-[rgb(var(--text-main))]">2</span> of <span class="font-medium text-[rgb(var(--text-main))]">12</span> results</div>
                            <div class="flex space-x-2">
                                <button class="px-3 py-1 border border-[rgb(var(--border-color))] rounded text-sm text-[rgb(var(--text-main))] hover:bg-[rgb(var(--item-active-bg))] transition-colors">Previous</button>
                                <button class="px-3 py-1 border border-[rgb(var(--border-color))] rounded text-sm text-[rgb(var(--text-main))] hover:bg-[rgb(var(--item-active-bg))] transition-colors">Next</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection