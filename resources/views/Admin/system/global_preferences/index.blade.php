@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-0 fw-bold">Global Platform Preferences</h2>
            <p class="text-muted mb-0">Manage core behavioral rules, branding, and global defaults.</p>
        </div>
        <div>
            <button type="button" class="btn btn-outline-secondary me-2">Cancel</button>
            <button type="button" class="btn btn-primary px-4" id="btnPublish" onclick="confirmPublish()">
                <i class="bi bi-cloud-arrow-up-fill me-1"></i> Validate & Publish
            </button>
        </div>
    </div>

    <form id="preferencesForm">
        <div class="row">
            <div class="col-lg-8">
                
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-header bg-white border-bottom-0 pt-4 pb-0">
                        <h5 class="fw-bold"><i class="bi bi-palette text-primary me-2"></i> Branding & Identity</h5>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Platform Name</label>
                                <input type="text" class="form-control" value="SahorOne Platform" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Company Legal Name</label>
                                <input type="text" class="form-control" value="SahorOne Technologies LLC" required>
                            </div>
                            <div class="col-md-12">
                                <label class="form-label">Brand Logo</label>
                                <input class="form-control" type="file" id="brandLogo">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-header bg-white border-bottom-0 pt-4 pb-0">
                        <h5 class="fw-bold"><i class="bi bi-globe-americas text-primary me-2"></i> Regional & Currency Defaults</h5>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Default Country</label>
                                <select class="form-select">
                                    <option value="PK" selected>Pakistan</option>
                                    <option value="US">United States</option>
                                    <option value="AE">United Arab Emirates</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Default Timezone</label>
                                <select class="form-select">
                                    <option value="Asia/Karachi" selected>Asia/Karachi (PKT)</option>
                                    <option value="UTC">UTC (Global Default)</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Global Base Currency</label>
                                <select class="form-select">
                                    <option value="PKR" selected>PKR - Pakistani Rupee</option>
                                    <option value="USD">USD - US Dollar</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Rounding Rules</label>
                                <select class="form-select">
                                    <option value="nearest">Round to nearest</option>
                                    <option value="up">Round up (Ceil)</option>
                                    <option value="down">Round down (Floor)</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-header bg-white border-bottom-0 pt-4 pb-0">
                        <h5 class="fw-bold"><i class="bi bi-headset text-primary me-2"></i> Support Contact Details</h5>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Global Support Email</label>
                                <input type="email" class="form-control" value="support@sahorone.com">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Emergency Operations Contact</label>
                                <input type="tel" class="form-control" value="+92-300-0000000">
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <div class="col-lg-4">
                
                <div class="card shadow-sm border-0 mb-4 border-top border-warning border-3">
                    <div class="card-header bg-white border-bottom-0 pt-4 pb-0">
                        <h5 class="fw-bold"><i class="bi bi-sliders text-warning me-2"></i> Platform Master Switches</h5>
                    </div>
                    <div class="card-body">
                        <div class="form-check form-switch custom-switch mb-3">
                            <input class="form-check-input" type="checkbox" id="switchOnboarding" checked>
                            <label class="form-check-label ms-2" for="switchOnboarding">
                                <strong>Allow New User Onboarding</strong><br>
                                <small class="text-muted">Disable to stop all new signups globally.</small>
                            </label>
                        </div>
                        <div class="form-check form-switch custom-switch mb-3">
                            <input class="form-check-input" type="checkbox" id="switchMaintenance">
                            <label class="form-check-label ms-2" for="switchMaintenance">
                                <strong>Maintenance Mode</strong><br>
                                <small class="text-muted text-danger">Warning: Takes entire platform offline.</small>
                            </label>
                        </div>
                    </div>
                </div>

                <div class="card shadow-sm border-0 mb-4 border-top border-info border-3">
                    <div class="card-header bg-white border-bottom-0 pt-4 pb-0">
                        <h5 class="fw-bold"><i class="bi bi-shield-check text-info me-2"></i> Publishing & Audit</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Rollout Mode</label>
                            <select class="form-select">
                                <option value="instant" class="text-danger">Instant (Apply Immediately)</option>
                                <option value="staged" selected>Staged (Requires Validation)</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Reason for Change <span class="text-danger">*</span></label>
                            <textarea class="form-control" rows="3" placeholder="Mandatory audit trail reason..." required></textarea>
                            <small class="text-muted">Required for governance and audit logs.</small>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </form>
</div>

<div class="modal fade" id="validationModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title fw-bold">Config Impact Analysis</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="alert alert-warning">
            <strong>System Impact:</strong> Low Risk. Changes will affect localization caching.
        </div>
        <p>Are you sure you want to publish these changes? The system will create a snapshot for easy rollback.</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-primary" onclick="submitChanges()">Confirm & Apply</button>
      </div>
    </div>
  </div>
</div>
@endsection

@push('styles')
<style>
    /* Custom Styling for Admin Experience */
    body {
        background-color: #f8f9fa;
    }
    .card {
        border-radius: 10px;
        transition: all 0.3s ease;
    }
    .card:hover {
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.05) !important;
    }
    .form-label {
        font-weight: 500;
        color: #495057;
    }
    .custom-switch .form-check-input {
        width: 3em;
        height: 1.5em;
        cursor: pointer;
    }
    .custom-switch .form-check-input:checked {
        background-color: #198754; /* Green for active */
        border-color: #198754;
    }
</style>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
@endpush

@push('scripts')
<script>
    function confirmPublish() {
        // Simple UI validation check
        const form = document.getElementById('preferencesForm');
        if(form.checkValidity()) {
            // Document Flow: Validation -> Publish
            var myModal = new bootstrap.Modal(document.getElementById('validationModal'));
            myModal.show();
        } else {
            form.reportValidity();
        }
    }

    function submitChanges() {
        // Document Flow: Publish -> Runtime Sync -> Audit Log
        const btn = document.querySelector('#validationModal .btn-primary');
        btn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Applying...';
        btn.disabled = true;

        // Simulating API Call
        setTimeout(() => {
            alert('Settings Synced and Audit Log Created Successfully!');
            window.location.reload();
        }, 1500);
    }
</script>
@endpush