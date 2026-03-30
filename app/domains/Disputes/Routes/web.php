<?php

use App\Domains\Disputes\Controllers\Front\DisputeController;
use Illuminate\Support\Facades\Route;

Route::get('/dispute/complaint-intake-classification',[DisputeController::class,'index'])->name('dispute.complaint_intake_classification');
Route::get('/dispute/evidence_context',[DisputeController::class,'EvidenceContext'])->name('dispute.evidence_context');