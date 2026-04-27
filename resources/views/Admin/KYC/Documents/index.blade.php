@extends('layouts.app')

@section('title', 'KYC & Document Verification')

@section('content')
<div class="p-4 sm:p-6 lg:p-8 bg-bg-primary min-h-screen flex flex-col w-full" x-data="documentManagement()">

    <div x-show="toast.show" x-transition class="fixed top-6 right-6 z-[100] bg-bg-secondary border-l-4 shadow-xl flex items-center gap-3 min-w-[300px] p-4 rounded-lg"
         :class="toast.type === 'error' ? 'border-semantic-error' : 'border-semantic-success'" style="display: none;" x-cloak>
        <i data-lucide="info" class="w-5 h-5" :class="toast.type === 'error' ? 'text-semantic-error' : 'text-semantic-success'"></i>
        <span x-text="toast.message" class="text-body-sm font-semibold text-text-primary"></span>
    </div>

    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 sm:mb-8 gap-4 shrink-0">
        <div class="min-w-0 flex-1">
            <h1 class="text-h3 sm:text-h2 font-bold tracking-tight text-text-primary flex items-center gap-3">
                <span class="p-2 bg-brand-primary/10 rounded-lg text-brand-primary border border-brand-primary/20 shrink-0">
                    <i data-lucide="file-check-2" class="w-5 h-5 sm:w-6 sm:h-6"></i>
                </span>
                KYC & Document Verification
            </h1>
            <p class="text-text-secondary text-body-sm mt-2">Enterprise Identity Assurance, Compliance & Secure Document Storage (S3 SSE-KMS).</p>
        </div>

        <div class="flex flex-wrap items-center gap-3 w-full md:w-auto shrink-0">
            <button @click="fetchData()" class="btn btn-secondary p-2 flex-1 md:flex-none flex items-center justify-center gap-2">
                <i data-lucide="refresh-cw" class="w-4 h-4" :class="isLoading ? 'animate-spin' : ''"></i> 
                <span class="whitespace-nowrap">Sync Repository</span>
            </button>
        </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 sm:gap-6 mb-6 sm:mb-8 shrink-0">
        <div class="card p-4 sm:p-5 flex items-center gap-4 border-semantic-error/30 bg-semantic-error-bg/10">
            <div class="w-10 h-10 rounded-full bg-semantic-error/20 text-semantic-error flex items-center justify-center shrink-0">
                <i data-lucide="alert-octagon" class="w-5 h-5"></i>
            </div>
            <div>
                <p class="text-caption font-bold text-semantic-error uppercase tracking-wider">Expiring < 30 Days</p>
                <h3 class="text-h3 font-bold text-text-primary" x-text="stats.expiring"></h3>
            </div>
        </div>

        <div class="card p-4 sm:p-5 flex items-center gap-4 border-semantic-warning/30 bg-semantic-warning-bg/10">
            <div class="w-10 h-10 rounded-full bg-semantic-warning/20 text-semantic-warning flex items-center justify-center shrink-0">
                <i data-lucide="clock" class="w-5 h-5"></i>
            </div>
            <div>
                <p class="text-caption font-bold text-semantic-warning uppercase tracking-wider">Pending Review</p>
                <h3 class="text-h3 font-bold text-text-primary" x-text="stats.pending"></h3>
            </div>
        </div>

        <div class="card p-4 sm:p-5 flex items-center gap-4">
            <div class="w-10 h-10 rounded-full bg-semantic-success-bg text-semantic-success border border-semantic-success/20 flex items-center justify-center shrink-0">
                <i data-lucide="shield-check" class="w-5 h-5"></i>
            </div>
            <div>
                <p class="text-caption font-bold text-text-tertiary uppercase tracking-wider">Vault Integrity</p>
                <h3 class="text-body-sm font-bold text-semantic-success mt-1">S3 SSE-KMS Secured</h3>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 xl:grid-cols-3 gap-6 sm:gap-8 flex-1 min-h-0">
        
        <div class="xl:col-span-1 space-y-6">
            <div class="card p-0 border-border-default shadow-sm overflow-hidden flex flex-col h-full">
                <div class="p-5 border-b border-border-default bg-bg-tertiary">
                    <h3 class="text-h4 font-bold text-text-primary flex items-center gap-2">
                        <i data-lucide="upload-cloud" class="w-5 h-5 text-brand-primary"></i> Manual Ingestion
                    </h3>
                </div>

                <form @submit.prevent="uploadDocument" class="flex flex-col flex-1 p-5 space-y-5 bg-bg-secondary">
                    
                    <div class="form-group mb-0">
                        <label class="form-label">Business Target</label>
                        <select x-model="uploadForm.businessId" required class="form-input w-full text-body-sm bg-bg-primary">
                            <option value="" disabled selected>Select Business...</option>
                            <option value="B-101">Elevate Digital (B-101)</option>
                            <option value="B-102">Dubai Cool AC (B-102)</option>
                            <option value="B-103">Apex Legal (B-103)</option>
                        </select>
                    </div>

                    <div class="form-group mb-0">
                        <label class="form-label">UAE Document Type</label>
                        <select x-model="uploadForm.docType" required class="form-input w-full text-body-sm bg-bg-primary">
                            <optgroup label="Mandatory (UAE)">
                                <option value="Trade License">Trade License</option>
                                <option value="Owner Emirates ID">Owner Emirates ID (Front & Back)</option>
                                <option value="VAT Certificate">VAT Registration Certificate</option>
                                <option value="Bank Proof">Bank Account Proof</option>
                                <option value="Address Proof">Office Address Verification</option>
                            </optgroup>
                            <optgroup label="Optional">
                                <option value="Employee List">Employee List</option>
                                <option value="Professional License">Professional / Medical License</option>
                            </optgroup>
                        </select>
                    </div>

                    <div class="form-group mb-0" x-show="uploadForm.docType && uploadForm.docType !== 'Address Proof' && uploadForm.docType !== 'Employee List'">
                        <label class="form-label">Document Expiry Date</label>
                        <input type="date" x-model="uploadForm.expiryDate" class="form-input w-full bg-bg-primary text-body-sm" :required="['Trade License', 'Owner Emirates ID'].includes(uploadForm.docType)">
                        <span class="text-[9px] text-text-tertiary mt-1 block">Required for Trade Licenses and Emirates IDs.</span>
                    </div>

                    <div class="mt-2 relative">
                        <input type="file" id="file-upload" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10" @change="handleFileSelect" accept=".pdf,.jpg,.jpeg,.png">
                        <div class="flex justify-center px-6 pt-5 pb-6 border-2 border-border-strong border-dashed rounded-lg bg-bg-primary transition-colors"
                             :class="uploadForm.file ? 'border-brand-primary bg-brand-primary/5' : 'hover:border-brand-primary/50'">
                            <div class="space-y-2 text-center">
                                <i data-lucide="file-up" class="mx-auto h-8 w-8 text-text-tertiary" x-show="!uploadForm.file"></i>
                                <i data-lucide="file-check" class="mx-auto h-8 w-8 text-brand-primary" x-show="uploadForm.file" x-cloak></i>
                                
                                <div class="text-body-sm text-text-primary" x-show="!uploadForm.file">
                                    <span class="font-bold text-brand-primary">Click to upload</span> or drag and drop
                                </div>
                                <div class="text-body-sm font-bold text-brand-primary truncate max-w-[200px] mx-auto" x-show="uploadForm.file" x-text="uploadForm.file?.name" x-cloak></div>
                                
                                <p class="text-[10px] text-text-secondary uppercase tracking-wider font-bold">PDF, JPG, PNG up to 10MB</p>
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary w-full mt-auto" :disabled="!uploadForm.file || !uploadForm.businessId || !uploadForm.docType || isUploading">
                        <i data-lucide="loader-2" class="w-4 h-4 mr-2 animate-spin" x-show="isUploading" x-cloak></i>
                        <span x-text="isUploading ? 'Encrypting & Uploading...' : 'Upload to KMS Vault'"></span>
                    </button>
                </form>
            </div>
        </div>

        <div class="xl:col-span-2 card p-0 flex flex-col min-h-[500px] border-border-default shadow-sm overflow-hidden relative">
            
            <div class="px-5 py-4 border-b border-border-default bg-bg-tertiary flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 shrink-0">
                <h3 class="text-h4 font-bold text-text-primary">Vault Repository</h3>
                
                <div class="flex items-center gap-3 w-full sm:w-auto">
                    <select x-model="filters.status" class="form-input h-9 text-body-sm bg-bg-primary border-border-default w-full sm:w-auto">
                        <option value="All">All Statuses</option>
                        <option value="Verified">Verified</option>
                        <option value="Pending">Pending Review</option>
                        <option value="Rejected">Rejected</option>
                    </select>

                    <div class="relative w-full sm:w-64 shrink-0">
                        <i data-lucide="search" class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-text-tertiary"></i>
                        <input type="text" x-model="filters.search" placeholder="Search business or doc type..." class="form-input w-full pl-9 h-9 text-body-sm bg-bg-primary">
                    </div>
                </div>
            </div>

            <div class="flex-1 overflow-auto custom-scrollbar relative bg-bg-primary w-full">
                
                <div x-show="isLoading" class="absolute inset-0 z-50 bg-bg-primary/90 backdrop-blur-sm flex flex-col items-center justify-center">
                    <i data-lucide="loader-2" class="w-8 h-8 animate-spin text-brand-primary mb-3"></i>
                    <span class="text-body-sm font-bold text-text-primary animate-pulse">Querying KMS Vault...</span>
                </div>

                <table class="w-full text-left border-collapse min-w-[800px]">
                    <thead class="text-caption uppercase text-text-secondary font-semibold bg-bg-secondary sticky top-0 z-30 shadow-[0_1px_0_0_rgb(var(--border-strong))]">
                        <tr>
                            <th class="px-5 py-3 border-r border-border-default">Business Identity</th>
                            <th class="px-5 py-3 border-r border-border-default">Document Details</th>
                            <th class="px-5 py-3 border-r border-border-default text-center">Verification Status</th>
                            <th class="px-5 py-3 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-border-default bg-bg-primary">
                        
                        <tr x-show="!isLoading && filteredDocs.length === 0" x-cloak>
                            <td colspan="4" class="px-6 py-16 text-center text-text-tertiary">
                                <i data-lucide="file-search" class="w-10 h-10 mx-auto mb-3 opacity-30"></i>
                                <p class="text-body-sm">No documents found matching criteria.</p>
                            </td>
                        </tr>

                        <template x-for="doc in filteredDocs" :key="doc.id">
                            <tr class="hover:bg-bg-tertiary/50 transition-colors group">
                                
                                <td class="px-5 py-4 border-r border-border-default align-top">
                                    <div class="font-bold text-text-primary text-body-sm truncate" x-text="doc.businessName"></div>
                                    <div class="text-[10px] text-text-secondary mt-0.5 font-mono" x-text="'ID: ' + doc.businessId"></div>
                                </td>

                                <td class="px-5 py-4 border-r border-border-default align-top">
                                    <div class="flex items-center gap-2 mb-1.5">
                                        <i data-lucide="file-text" class="w-3.5 h-3.5 text-text-tertiary"></i>
                                        <span class="font-bold text-text-primary text-body-sm" x-text="doc.type"></span>
                                        <span x-show="doc.isMandatory" class="px-1.5 py-0.5 bg-semantic-error-bg border border-semantic-error/20 text-semantic-error text-[8px] font-bold uppercase rounded">Mandatory</span>
                                    </div>
                                    <div class="text-caption text-text-secondary font-mono flex items-center gap-2 mb-1">
                                        <i data-lucide="hash" class="w-3 h-3"></i> <span class="truncate max-w-[150px]" :title="doc.hash" x-text="doc.hash"></span>
                                    </div>
                                    <div class="text-[10px] flex items-center gap-1.5" :class="isExpiringSoon(doc.expiry) ? 'text-semantic-error font-bold' : 'text-text-tertiary'">
                                        <i data-lucide="calendar" class="w-3 h-3"></i> 
                                        <span x-text="doc.expiry ? 'Expires: ' + doc.expiry : 'No Expiry'"></span>
                                    </div>
                                </td>

                                <td class="px-5 py-4 border-r border-border-default text-center align-middle">
                                    <span class="inline-flex items-center gap-1.5 px-2 py-1 rounded text-[10px] font-bold uppercase tracking-wider border w-fit"
                                          :class="getStatusBadgeClass(doc.status)">
                                        <i :data-lucide="getStatusIcon(doc.status)" class="w-3 h-3"></i> <span x-text="doc.status"></span>
                                    </span>
                                </td>

                                <td class="px-5 py-4 text-right align-middle">
                                    <button @click="viewDocument(doc)" class="btn btn-secondary btn-sm flex items-center justify-center gap-2 w-full mx-auto max-w-[100px]">
                                        <i data-lucide="eye" class="w-3.5 h-3.5"></i> Inspect
                                    </button>
                                </td>

                            </tr>
                        </template>
                    </tbody>
                </table>
            </div>
            
            <div class="p-4 border-t border-border-default bg-bg-tertiary text-body-sm text-text-secondary text-right shrink-0">
                <span x-text="`Showing ${filteredDocs.length} items`"></span>
            </div>
        </div>

    </div>

    <div x-show="modals.inspection" class="fixed inset-0 z-50 flex items-center justify-center bg-brand-secondary/80 backdrop-blur-sm p-4" x-cloak>
        <div class="card w-full max-w-4xl p-0 shadow-2xl flex flex-col h-[90vh]" @click.away="closeInspectionModal()">
            
            <div class="p-5 border-b border-border-default bg-bg-tertiary flex justify-between items-center rounded-t-lg shrink-0">
                <h3 class="text-h4 font-bold text-text-primary flex items-center gap-2"><i data-lucide="search" class="w-5 h-5 text-brand-primary"></i> Document Inspection</h3>
                <button @click="closeInspectionModal()" class="text-text-tertiary hover:text-text-primary"><i data-lucide="x" class="w-5 h-5"></i></button>
            </div>
            
            <div class="flex flex-col md:flex-row flex-1 min-h-0 overflow-hidden bg-bg-primary">
                
                <div class="flex-1 border-b md:border-b-0 md:border-r border-border-default bg-bg-secondary flex flex-col items-center justify-center p-6 relative">
                    <div class="absolute inset-0 pointer-events-none flex items-center justify-center opacity-5">
                        <span class="text-4xl font-bold uppercase transform -rotate-45" x-text="selectedDoc?.businessName"></span>
                    </div>
                    
                    <i data-lucide="file-text" class="w-24 h-24 text-border-strong mb-4"></i>
                    <p class="text-body font-mono text-text-secondary">[ Secure Vault Renderer: <span x-text="selectedDoc?.type"></span> ]</p>
                    <button class="mt-4 btn btn-secondary btn-sm shadow-sm"><i data-lucide="download" class="w-4 h-4 mr-2"></i> Download Encrypted Copy</button>
                </div>

                <div class="w-full md:w-80 shrink-0 bg-bg-tertiary flex flex-col overflow-y-auto custom-scrollbar">
                    <div class="p-5 space-y-5">
                        
                        <div>
                            <h4 class="text-caption font-bold text-text-tertiary uppercase tracking-wider mb-2">Metadata Attributes</h4>
                            <div class="space-y-2 bg-bg-primary p-3 rounded border border-border-default">
                                <div class="flex flex-col">
                                    <span class="text-[10px] text-text-secondary">Uploader</span>
                                    <span class="text-body-sm font-bold text-text-primary" x-text="selectedDoc?.businessName"></span>
                                </div>
                                <div class="flex flex-col">
                                    <span class="text-[10px] text-text-secondary">Upload Date</span>
                                    <span class="text-body-sm text-text-primary" x-text="selectedDoc?.uploadedAt"></span>
                                </div>
                                <div class="flex flex-col">
                                    <span class="text-[10px] text-text-secondary">KMS Hash</span>
                                    <span class="text-[10px] font-mono text-text-primary truncate" :title="selectedDoc?.hash" x-text="selectedDoc?.hash"></span>
                                </div>
                            </div>
                        </div>

                        <div x-show="selectedDoc?.status === 'Pending'">
                            <h4 class="text-caption font-bold text-text-tertiary uppercase tracking-wider mb-2">Verification Decision</h4>
                            <div class="space-y-3">
                                <button @click="verifyDocument('Verified')" class="w-full btn btn-sm border-semantic-success/30 text-semantic-success hover:bg-semantic-success hover:text-white flex justify-center shadow-sm">
                                    <i data-lucide="check-circle" class="w-4 h-4 mr-2"></i> Approve & Verify
                                </button>
                                <button @click="verifyDocument('Rejected')" class="w-full btn btn-sm border-semantic-error/30 text-semantic-error hover:bg-semantic-error hover:text-white flex justify-center shadow-sm">
                                    <i data-lucide="x-circle" class="w-4 h-4 mr-2"></i> Reject Document
                                </button>
                            </div>
                        </div>

                        <div x-show="selectedDoc?.status !== 'Pending'" class="p-3 rounded-lg border flex items-start gap-2" :class="selectedDoc?.status === 'Verified' ? 'bg-semantic-success-bg border-semantic-success/30' : 'bg-semantic-error-bg border-semantic-error/30'">
                            <i data-lucide="info" class="w-4 h-4 mt-0.5 shrink-0" :class="selectedDoc?.status === 'Verified' ? 'text-semantic-success' : 'text-semantic-error'"></i>
                            <div>
                                <p class="text-body-sm font-bold" :class="selectedDoc?.status === 'Verified' ? 'text-semantic-success' : 'text-semantic-error'" x-text="'Document ' + selectedLog?.status"></p>
                                <p class="text-[10px] text-text-primary mt-1">Processed by Compliance Admin.</p>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

@push('scripts')
<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('documentManagement', () => ({
        isLoading: true,
        isUploading: false,
        toast: { show: false, message: '', type: 'success' },
        
        filters: { status: 'All', search: '' },
        modals: { inspection: false },
        
        uploadForm: { businessId: '', docType: '', expiryDate: '', file: null },
        selectedDoc: null,
        documents: [],

        init() {
            this.fetchData();
        },

        get stats() {
            return {
                expiring: this.documents.filter(d => this.isExpiringSoon(d.expiry)).length,
                pending: this.documents.filter(d => d.status === 'Pending').length,
            };
        },

        get filteredDocs() {
            let result = this.documents;
            if (this.filters.status !== 'All') {
                result = result.filter(d => d.status === this.filters.status);
            }
            if (this.filters.search) {
                const q = this.filters.search.toLowerCase();
                result = result.filter(d => d.businessName.toLowerCase().includes(q) || d.type.toLowerCase().includes(q));
            }
            return result;
        },

        async fetchData() {
            this.isLoading = true;
            await new Promise(r => setTimeout(r, 600)); // Simulate API
            
             this.documents = [
                { id: 'DOC-101', businessId: 'B-101', businessName: 'Elevate Digital', type: 'Trade License', isMandatory: true, status: 'Verified', uploadedAt: '12-Sep-2026', expiry: '12-Sep-2027', hash: 'sha256:9f86d081884c7d659a2feaa0c55ad015a3bf4f1b2b0b822cd15d6c15b0f00a08' },
                { id: 'DOC-102', businessId: 'B-101', businessName: 'Elevate Digital', type: 'Owner Emirates ID', isMandatory: true, status: 'Pending', uploadedAt: '13-Sep-2026', expiry: '15-Oct-2026', hash: 'sha256:4d98a287f3292410a562e847c126cfd5958221b0dc3d4e8c56fa7f017362a265' },
                { id: 'DOC-103', businessId: 'B-102', businessName: 'Dubai Cool AC', type: 'VAT Certificate', isMandatory: false, status: 'Rejected', uploadedAt: '01-Oct-2026', expiry: null, hash: 'sha256:8b41295b9d36a3f12463e26bbfa43b020a7b4097486e9021eb31110f01a30a43' },
                { id: 'DOC-104', businessId: 'B-103', businessName: 'Apex Legal', type: 'Professional License', isMandatory: false, status: 'Verified', uploadedAt: '22-Aug-2026', expiry: '22-Aug-2028', hash: 'sha256:f12a32df149ea75f8ba33ec220d91d90fc92b45f18c6422bdf55928d36329fa9' }
            ];

            this.isLoading = false;
            this.$nextTick(() => lucide.createIcons());
        },

        showToast(msg, type = 'success') {
            this.toast = { show: true, message: msg, type: type };
            setTimeout(() => this.toast.show = false, 3000);
        },

        // --- Upload Logic ---
        handleFileSelect(event) {
            const file = event.target.files[0];
            if (file) {
                if (file.size > 10 * 1024 * 1024) {
                    this.showToast('File exceeds 10MB limit.', 'error');
                    event.target.value = '';
                    this.uploadForm.file = null;
                    return;
                }
                this.uploadForm.file = file;
            }
        },

        uploadDocument() {
            this.isUploading = true;
            setTimeout(() => {
                const isMandatory = ['Trade License', 'Owner Emirates ID'].includes(this.uploadForm.docType);
                
                this.documents.unshift({
                    id: 'DOC-' + Math.floor(Math.random() * 1000),
                    businessId: this.uploadForm.businessId,
                    businessName: this.uploadForm.businessId === 'B-101' ? 'Elevate Digital' : 'Selected Business',
                    type: this.uploadForm.docType,
                    isMandatory: isMandatory,
                    status: 'Pending',
                    uploadedAt: new Date().toLocaleDateString('en-GB', { day: '2-digit', month: 'short', year: 'numeric' }).replace(/ /g, '-'),
                    expiry: this.uploadForm.expiryDate || null,
                    hash: 'sha256:' + Math.random().toString(36).substring(2, 15) + Math.random().toString(36).substring(2, 15)
                });

                this.isUploading = false;
                this.showToast('Document securely ingested and queued for review.');
                
                // Reset form
                this.uploadForm = { businessId: '', docType: '', expiryDate: '', file: null };
                document.getElementById('file-upload').value = '';
                this.$nextTick(() => lucide.createIcons());
            }, 1000);
        },

        // --- Inspection Logic ---
        viewDocument(doc) {
            this.selectedDoc = doc;
            this.modals.inspection = true;
            this.$nextTick(() => lucide.createIcons());
        },

        closeInspectionModal() {
            this.modals.inspection = false;
            this.selectedDoc = null;
        },

        verifyDocument(status) {
            if(confirm(`Mark document as ${status}?`)) {
                this.selectedDoc.status = status;
                const idx = this.documents.findIndex(d => d.id === this.selectedDoc.id);
                if(idx !== -1) this.documents[idx].status = status;
                
                this.showToast(`Document ${status}.`);
                this.closeInspectionModal();
            }
        },

        // --- Helpers ---
        isExpiringSoon(expiryString) {
            if(!expiryString) return false;
            const exp = new Date(expiryString);
            const now = new Date();
            const diffDays = (exp - now) / (1000 * 60 * 60 * 24);
            return diffDays > 0 && diffDays <= 30; // Within 30 days
        },

        getStatusBadgeClass(status) {
            if(status === 'Verified') return 'bg-semantic-success-bg text-semantic-success border-semantic-success/20';
            if(status === 'Pending') return 'bg-semantic-warning-bg text-semantic-warning border-semantic-warning/20';
            if(status === 'Rejected') return 'bg-semantic-error-bg text-semantic-error border-semantic-error/20';
            return 'bg-bg-tertiary text-text-secondary border-border-strong';
        },

        getStatusIcon(status) {
            if(status === 'Verified') return 'check-circle-2';
            if(status === 'Pending') return 'clock';
            if(status === 'Rejected') return 'x-octagon';
            return 'file';
        }
    }));
});
</script>
@endpush
@endsection