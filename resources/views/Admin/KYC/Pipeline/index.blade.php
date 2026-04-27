@extends('layouts.app')

@section('title', 'KYC Verification Pipeline')

@section('content')
<div class="p-4 sm:p-6 lg:p-8 bg-bg-primary min-h-screen flex flex-col w-full" x-data="kycVerificationPipeline()">

    <div x-show="toast.show" x-transition class="fixed top-6 right-6 z-[100] bg-bg-secondary border-l-4 shadow-xl flex items-center gap-3 min-w-[300px] p-4 rounded-lg"
         :class="toast.type === 'error' ? 'border-semantic-error' : 'border-semantic-success'" style="display: none;" x-cloak>
        <i data-lucide="info" class="w-5 h-5" :class="toast.type === 'error' ? 'text-semantic-error' : 'text-semantic-success'"></i>
        <span x-text="toast.message" class="text-body-sm font-semibold text-text-primary"></span>
    </div>

    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 sm:mb-8 gap-4 shrink-0">
        <div class="min-w-0 flex-1">
            <h1 class="text-h3 sm:text-h2 font-bold tracking-tight text-text-primary flex items-center gap-3">
                <span class="p-2 bg-brand-primary/10 rounded-lg text-brand-primary border border-brand-primary/20 shrink-0">
                    <i data-lucide="check-square" class="w-5 h-5 sm:w-6 sm:h-6"></i>
                </span>
                Verification Pipeline
            </h1>
            <p class="text-text-secondary text-body-sm mt-2">Process business KYC documents, monitor SLAs, and review AI authenticity checks.</p>
        </div>

        <div class="flex flex-wrap items-center gap-3 w-full md:w-auto shrink-0">
            <button @click="fetchQueue()" class="btn btn-secondary p-2 flex-1 md:flex-none flex items-center justify-center gap-2">
                <i data-lucide="refresh-cw" class="w-4 h-4" :class="isLoading ? 'animate-spin' : ''"></i> 
                <span class="whitespace-nowrap">Refresh Queue</span>
            </button>
        </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-4 gap-4 sm:gap-6 mb-6 shrink-0">
        <div class="card p-4 sm:p-5">
            <p class="text-caption font-bold text-text-tertiary uppercase tracking-wider">Pending Review</p>
            <div class="flex items-end gap-3 mt-1">
                <h3 class="text-h2 font-bold text-text-primary" x-text="queue.length"></h3>
                <span class="text-body-sm text-text-secondary mb-1">Documents</span>
            </div>
        </div>

        <div class="card p-4 sm:p-5 border-semantic-error/30 bg-semantic-error-bg/10">
            <p class="text-caption font-bold text-semantic-error uppercase tracking-wider">SLA Risk (< 4 Hrs)</p>
            <div class="flex items-end gap-3 mt-1">
                <h3 class="text-h2 font-bold text-text-primary" x-text="queue.filter(q => q.slaHours < 4).length"></h3>
                <i data-lucide="alert-triangle" class="w-5 h-5 text-semantic-error mb-1.5"></i>
            </div>
        </div>

        <div class="card p-4 sm:p-5 border-semantic-info/30 bg-semantic-info-bg/10">
            <p class="text-caption font-bold text-semantic-info uppercase tracking-wider">AI Pre-Checked</p>
            <div class="flex items-end gap-3 mt-1">
                <h3 class="text-h2 font-bold text-text-primary">100%</h3>
                <i data-lucide="bot" class="w-5 h-5 text-semantic-info mb-1.5"></i>
            </div>
        </div>

        <div class="card p-4 sm:p-5 border-semantic-success/30 bg-semantic-success-bg/10">
            <p class="text-caption font-bold text-semantic-success uppercase tracking-wider">Today's Output</p>
            <div class="flex items-end gap-3 mt-1">
                <h3 class="text-h2 font-bold text-text-primary">42</h3>
                <span class="text-body-sm text-text-secondary mb-1">Processed</span>
            </div>
        </div>
    </div>

    <div class="flex flex-col lg:flex-row gap-6 flex-1 min-h-[700px] w-full overflow-hidden">
        
        <aside class="w-full lg:w-80 shrink-0 flex flex-col h-[400px] lg:h-full card p-0 border-border-default shadow-sm overflow-hidden">
            <div class="p-4 border-b border-border-default bg-bg-tertiary flex items-center justify-between shrink-0">
                <h3 class="text-body-sm font-bold text-text-primary">Review Queue</h3>
                <span class="text-[10px] bg-brand-primary/10 text-brand-primary border border-brand-primary/20 px-2 py-0.5 rounded font-bold uppercase tracking-wider">Auto-Assigned</span>
            </div>
            
            <div class="p-3 bg-bg-secondary border-b border-border-default shrink-0">
                <div class="relative">
                    <i data-lucide="search" class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-text-tertiary"></i>
                    <input type="text" x-model="searchQuery" placeholder="Search business..." class="form-input w-full pl-9 h-9 text-body-sm bg-bg-primary">
                </div>
            </div>

            <div class="flex-1 overflow-y-auto custom-scrollbar bg-bg-secondary p-2 space-y-1.5">
                
                <div x-show="isLoading" class="py-10 text-center">
                    <i data-lucide="loader-2" class="w-6 h-6 animate-spin text-brand-primary mx-auto"></i>
                </div>

                <div x-show="!isLoading && filteredQueue.length === 0" class="py-10 text-center text-text-tertiary" x-cloak>
                    <p class="text-body-sm">Queue is empty. Great job!</p>
                </div>

                <template x-for="item in filteredQueue" :key="item.id">
                    <button @click="selectItem(item)" 
                            class="w-full text-left p-3 rounded-lg border transition-all"
                            :class="selectedItem?.id === item.id ? 'bg-bg-primary border-brand-primary shadow-sm' : 'bg-bg-primary border-border-default hover:border-border-strong'">
                        
                        <div class="flex justify-between items-start mb-1.5">
                            <span class="font-bold text-body-sm text-text-primary truncate pr-2" x-text="item.businessName"></span>
                            <span class="shrink-0 text-[10px] font-bold px-1.5 py-0.5 rounded flex items-center gap-1 border"
                                  :class="item.slaHours < 4 ? 'bg-semantic-error-bg text-semantic-error border-semantic-error/20 animate-pulse' : 'bg-semantic-warning-bg text-semantic-warning border-semantic-warning/20'">
                                <i data-lucide="clock" class="w-3 h-3"></i> <span x-text="item.slaHours + 'h left'"></span>
                            </span>
                        </div>
                        
                        <div class="text-caption text-text-secondary flex items-center gap-1.5">
                            <i data-lucide="file-text" class="w-3.5 h-3.5"></i>
                            <span class="truncate" x-text="item.docType"></span>
                        </div>
                        
                        <div class="mt-2 flex items-center gap-2">
                            <span x-show="item.isPilot" class="text-[9px] bg-purple-500/10 text-purple-500 border border-purple-500/20 px-1.5 py-0.5 rounded font-bold uppercase tracking-wider">Pilot Cohort (24h SLA)</span>
                            <span x-show="!item.isPilot" class="text-[9px] bg-bg-muted text-text-tertiary border border-border-strong px-1.5 py-0.5 rounded font-bold uppercase tracking-wider">Standard (48h SLA)</span>
                        </div>
                    </button>
                </template>
            </div>
        </aside>

        <main class="flex-1 card p-0 flex flex-col min-w-0 border-border-default shadow-sm min-h-[600px] lg:min-h-0 relative">
            
            <div x-show="!selectedItem" class="absolute inset-0 flex flex-col items-center justify-center bg-bg-primary z-10">
                <div class="w-16 h-16 rounded-full bg-bg-secondary flex items-center justify-center border border-border-default mb-4">
                    <i data-lucide="mouse-pointer-click" class="w-8 h-8 text-text-tertiary"></i>
                </div>
                <h3 class="text-h4 font-bold text-text-primary">No Document Selected</h3>
                <p class="text-body-sm text-text-secondary mt-1">Select an item from the queue to begin verification.</p>
            </div>

            <div x-show="selectedItem" class="flex flex-col h-full w-full" x-cloak>
                
                <div class="px-5 py-4 border-b border-border-default bg-bg-tertiary flex flex-col md:flex-row justify-between items-start md:items-center gap-4 shrink-0">
                    <div>
                        <h2 class="text-h3 font-bold text-text-primary" x-text="selectedItem?.businessName"></h2>
                        <div class="flex items-center gap-2 mt-1 text-body-sm text-text-secondary">
                            <i data-lucide="folder-open" class="w-4 h-4"></i>
                            <span x-text="selectedItem?.docType"></span>
                            <span class="w-1 h-1 rounded-full bg-border-strong"></span>
                            <span class="font-mono text-[10px] uppercase tracking-wider" x-text="'ID: ' + selectedItem?.id"></span>
                        </div>
                    </div>
                    <div class="flex gap-2 shrink-0 w-full md:w-auto">
                        <button @click="modals.action = true; actionType = 'Re-upload'" class="btn btn-secondary text-semantic-warning border-semantic-warning/30 hover:bg-semantic-warning hover:text-white flex-1 md:flex-none">Request Re-upload</button>
                        <button @click="modals.action = true; actionType = 'Reject'" class="btn btn-destructive flex-1 md:flex-none">Reject</button>
                        <button @click="approveDocument()" class="btn btn-primary bg-semantic-success border-semantic-success hover:bg-green-600 text-white shadow-lg flex-1 md:flex-none">Approve</button>
                    </div>
                </div>

                <div class="flex flex-col xl:flex-row flex-1 min-h-0 overflow-hidden bg-bg-primary">
                    
                    <div class="w-full xl:w-1/2 border-b xl:border-b-0 xl:border-r border-border-default bg-bg-secondary flex flex-col relative min-h-[300px]">
                        <div class="absolute inset-0 pointer-events-none flex items-center justify-center opacity-5 overflow-hidden z-0">
                            <span class="text-6xl font-black uppercase transform -rotate-45 whitespace-nowrap text-text-primary">SAHOR ONE CONFIDENTIAL</span>
                        </div>
                        <div class="flex-1 p-4 flex items-center justify-center relative z-10 overflow-auto">
                            <img :src="selectedItem?.previewUrl" alt="Document Preview" class="max-w-full max-h-full object-contain rounded border border-border-default shadow-sm bg-white" x-show="selectedItem?.previewUrl">
                            <div x-show="!selectedItem?.previewUrl" class="text-center text-text-tertiary">
                                <i data-lucide="file-image" class="w-16 h-16 mx-auto mb-2 opacity-50"></i>
                                <p class="text-body-sm font-mono">[ Secure Image Renderer ]</p>
                            </div>
                        </div>
                        <div class="p-3 border-t border-border-default bg-bg-tertiary flex justify-between items-center text-caption text-text-secondary shrink-0 relative z-10">
                            <span>S3 SSE-KMS Encrypted</span>
                            <button class="hover:text-text-primary"><i data-lucide="zoom-in" class="w-4 h-4"></i></button>
                        </div>
                    </div>

                    <div class="w-full xl:w-1/2 flex flex-col overflow-y-auto custom-scrollbar bg-bg-primary">
                        <div class="p-5 space-y-6">
                            
                            <div>
                                <h4 class="text-caption font-bold text-text-tertiary uppercase tracking-wider mb-3 flex items-center gap-2">
                                    <i data-lucide="scan-line" class="w-4 h-4"></i> AI OCR Extraction
                                </h4>
                                <div class="bg-bg-secondary border border-border-default rounded-lg overflow-hidden">
                                    <table class="w-full text-left text-body-sm">
                                        <thead class="bg-bg-tertiary border-b border-border-default text-text-secondary">
                                            <tr>
                                                <th class="px-4 py-2 font-medium">Data Field</th>
                                                <th class="px-4 py-2 font-medium">Extracted Value</th>
                                                <th class="px-4 py-2 font-medium text-center">Match</th>
                                            </tr>
                                        </thead>
                                        <tbody class="divide-y divide-border-default">
                                            <template x-for="field in selectedItem?.aiData.ocr" :key="field.label">
                                                <tr>
                                                    <td class="px-4 py-3 font-medium text-text-secondary" x-text="field.label"></td>
                                                    <td class="px-4 py-3 font-bold text-text-primary" x-text="field.value"></td>
                                                    <td class="px-4 py-3 text-center">
                                                        <i x-show="field.match" data-lucide="check-circle-2" class="w-4 h-4 text-semantic-success mx-auto"></i>
                                                        <i x-show="!field.match" data-lucide="x-circle" class="w-4 h-4 text-semantic-error mx-auto cursor-help" title="Mismatch with Business Profile"></i>
                                                    </td>
                                                </tr>
                                            </template>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div>
                                <h4 class="text-caption font-bold text-text-tertiary uppercase tracking-wider mb-3 flex items-center gap-2">
                                    <i data-lucide="fingerprint" class="w-4 h-4"></i> Authenticity Analyzer
                                </h4>
                                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                                    <template x-for="check in selectedItem?.aiData.authenticity" :key="check.label">
                                        <div class="p-3 rounded-lg border flex flex-col items-center justify-center text-center gap-1.5"
                                             :class="check.passed ? 'bg-semantic-success-bg border-semantic-success/20' : 'bg-semantic-error-bg border-semantic-error/30'">
                                            <i :data-lucide="check.passed ? 'shield-check' : 'shield-alert'" class="w-5 h-5" :class="check.passed ? 'text-semantic-success' : 'text-semantic-error'"></i>
                                            <span class="text-[10px] font-bold uppercase tracking-wider" :class="check.passed ? 'text-semantic-success' : 'text-semantic-error'" x-text="check.label"></span>
                                        </div>
                                    </template>
                                </div>
                            </div>

                            <div>
                                <h4 class="text-caption font-bold text-text-tertiary uppercase tracking-wider mb-3 flex items-center gap-2">
                                    <i data-lucide="network" class="w-4 h-4"></i> API Cross-Reference
                                </h4>
                                <div class="space-y-3">
                                    <template x-for="ref in selectedItem?.aiData.crossRef" :key="ref.source">
                                        <div class="flex items-center justify-between p-3 rounded-lg border bg-bg-secondary" :class="ref.verified ? 'border-border-default' : 'border-semantic-error/30'">
                                            <div class="flex items-center gap-3">
                                                <div class="w-8 h-8 rounded bg-bg-primary border border-border-strong flex items-center justify-center">
                                                    <i data-lucide="database" class="w-4 h-4 text-text-secondary"></i>
                                                </div>
                                                <div>
                                                    <p class="text-body-sm font-bold text-text-primary" x-text="ref.source"></p>
                                                    <p class="text-[10px] font-mono text-text-secondary mt-0.5" x-text="ref.details"></p>
                                                </div>
                                            </div>
                                            <div>
                                                <span x-show="ref.verified" class="px-2 py-1 bg-semantic-success-bg text-semantic-success border border-semantic-success/20 rounded text-[10px] font-bold uppercase tracking-wider flex items-center gap-1"><i data-lucide="check" class="w-3 h-3"></i> Verified</span>
                                                <span x-show="!ref.verified" class="px-2 py-1 bg-semantic-error-bg text-semantic-error border border-semantic-error/20 rounded text-[10px] font-bold uppercase tracking-wider flex items-center gap-1"><i data-lucide="x" class="w-3 h-3"></i> Failed</span>
                                            </div>
                                        </div>
                                    </template>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

            </div>
        </main>
    </div>

    <div x-show="modals.action" class="fixed inset-0 z-[60] flex items-center justify-center bg-brand-secondary/80 backdrop-blur-sm p-4" x-cloak>
        <div class="card w-full max-w-lg p-0 shadow-2xl" :class="actionType === 'Reject' ? 'border-semantic-error' : 'border-semantic-warning'" @click.away="modals.action = false">
            
            <div class="p-5 border-b border-border-default bg-bg-tertiary flex justify-between items-center rounded-t-xl">
                <h3 class="text-h4 font-bold text-text-primary flex items-center gap-2">
                    <i data-lucide="alert-triangle" class="w-5 h-5" :class="actionType === 'Reject' ? 'text-semantic-error' : 'text-semantic-warning'"></i>
                    <span x-text="actionType + ' Document'"></span>
                </h3>
                <button @click="modals.action = false" class="text-text-tertiary hover:text-text-primary"><i data-lucide="x" class="w-5 h-5"></i></button>
            </div>
            
            <form @submit.prevent="executeAction">
                <div class="p-6 space-y-4">
                    <p class="text-body-sm text-text-secondary">Please provide a clear reason. This will be sent directly to <strong class="text-text-primary" x-text="selectedItem?.businessName"></strong> and logged for compliance auditing.</p>

                    <div class="form-group mb-0 mt-4">
                        <label class="form-label">Reason Code</label>
                        <select x-model="actionReasonCode" required class="form-input w-full text-body-sm">
                            <option value="" disabled selected>Select standard reason...</option>
                            <option value="Blurry/Unreadable">Document is blurry or unreadable</option>
                            <option value="Expired">Document is expired</option>
                            <option value="Name Mismatch">Name on document does not match profile</option>
                            <option value="Tampering Detected">Suspected document tampering</option>
                            <option value="Wrong Document Type">Incorrect document type uploaded</option>
                            <option value="Other">Other (Specify below)</option>
                        </select>
                    </div>

                    <div class="form-group mb-0">
                        <label class="form-label">Detailed Explanation</label>
                        <textarea x-model="actionReason" required rows="3" class="form-input w-full text-body-sm rounded-xl" placeholder="Provide specific instructions for the business..."></textarea>
                    </div>
                </div>
                
                <div class="p-5 border-t border-border-default flex justify-end gap-3 rounded-b-xl bg-bg-tertiary">
                    <button type="button" @click="modals.action = false" class="btn btn-tertiary">Cancel</button>
                    <button type="submit" class="btn text-white shadow-lg" :class="actionType === 'Reject' ? 'btn-destructive' : 'btn-primary bg-semantic-warning hover:bg-orange-500 border-none'" :disabled="!actionReason || !actionReasonCode">
                        <span x-text="'Confirm ' + actionType"></span>
                    </button>
                </div>
            </form>
        </div>
    </div>

</div>

@push('scripts')
<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('kycVerificationPipeline', () => ({
        isLoading: true,
        searchQuery: '',
        toast: { show: false, message: '', type: 'success' },
        
        modals: { action: false },
        actionType: '',
        actionReasonCode: '',
        actionReason: '',

        queue: [],
        selectedItem: null,

        init() {
            this.fetchQueue();
        },

        get filteredQueue() {
            if (!this.searchQuery) return this.queue;
            const q = this.searchQuery.toLowerCase();
            return this.queue.filter(item => item.businessName.toLowerCase().includes(q) || item.docType.toLowerCase().includes(q));
        },

        async fetchQueue() {
            this.isLoading = true;
            this.selectedItem = null;
            await new Promise(r => setTimeout(r, 600)); // Simulate API
            
             this.queue = [
                { 
                    id: 'Q-8821', businessName: 'Elevate Digital', docType: 'Trade License', slaHours: 2, isPilot: true, previewUrl: '',
                    aiData: {
                        ocr: [
                            { label: 'Business Name', value: 'ELEVATE DIGITAL LLC', match: true },
                            { label: 'License Number', value: 'CN-1002934', match: true },
                            { label: 'Expiry Date', value: '12-Oct-2027', match: true },
                            { label: 'Issuing Authority', value: 'Dubai Economy (DED)', match: true }
                        ],
                        authenticity: [
                            { label: 'No Tampering', passed: true },
                            { label: 'Metadata Valid', passed: true },
                            { label: 'Watermark Match', passed: true }
                        ],
                        crossRef: [
                            { source: 'UAE Chamber of Commerce API', details: 'Status: ACTIVE', verified: true }
                        ]
                    }
                },
                { 
                    id: 'Q-8822', businessName: 'Dubai Cool AC Repair', docType: 'Owner Emirates ID', slaHours: 14, isPilot: true, previewUrl: '',
                    aiData: {
                        ocr: [
                            { label: 'Owner Name', value: 'TARIQ AL FASI', match: true },
                            { label: 'ID Number', value: '784-1988-1234567-1', match: true },
                            { label: 'Expiry Date', value: '05-Jun-2025', match: true }
                        ],
                        authenticity: [
                            { label: 'No Tampering', passed: false }, // AI Flagged
                            { label: 'Metadata Valid', passed: true },
                            { label: 'Font/Layout Check', passed: true }
                        ],
                        crossRef: [
                            { source: 'Federal Authority for Identity (ICA)', details: 'Record mismatch detected', verified: false }
                        ]
                    }
                },
                { 
                    id: 'Q-8823', businessName: 'Apex Legal Consultants', docType: 'Trade License', slaHours: 36, isPilot: false, previewUrl: '',
                    aiData: {
                        ocr: [
                            { label: 'Business Name', value: 'APEX LEGAL FZ-LLC', match: false }, // Name mismatch
                            { label: 'License Number', value: 'FZ-99120', match: true },
                            { label: 'Expiry Date', value: '01-Jan-2027', match: true }
                        ],
                        authenticity: [
                            { label: 'No Tampering', passed: true },
                            { label: 'Metadata Valid', passed: true },
                            { label: 'Watermark Match', passed: true }
                        ],
                        crossRef: [
                            { source: 'UAE Chamber of Commerce API', details: 'Status: ACTIVE', verified: true }
                        ]
                    }
                }
            ];

            // Sort by SLA ascending
            this.queue.sort((a, b) => a.slaHours - b.slaHours);

            this.isLoading = false;
            this.$nextTick(() => lucide.createIcons());
        },

        selectItem(item) {
            this.selectedItem = item;
            this.$nextTick(() => lucide.createIcons());
        },

        showToast(msg, type = 'success') {
            this.toast = { show: true, message: msg, type: type };
            setTimeout(() => this.toast.show = false, 3000);
        },

        approveDocument() {
            if(confirm(`Approve this ${this.selectedItem.docType} for ${this.selectedItem.businessName}?`)) {
                this.removeFromQueue();
                this.showToast('Document Verified & Approved successfully.');
            }
        },

        executeAction() {
            const actionVerb = this.actionType === 'Reject' ? 'Rejected' : 'Re-upload requested';
            this.removeFromQueue();
            this.modals.action = false;
            this.actionReasonCode = '';
            this.actionReason = '';
            this.showToast(`Document ${actionVerb}. Notification sent to business.`, this.actionType === 'Reject' ? 'error' : 'success');
        },

        removeFromQueue() {
            this.queue = this.queue.filter(q => q.id !== this.selectedItem.id);
            this.selectedItem = null;
        }
    }));
});
</script>
@endpush
@endsection