<?php

use App\Http\Controllers\Front\ProviderController;
use App\Http\Controllers\Front\RegionalController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// ====================================================
// Regional Controle 
// ====================================================
Route::get('/regional_controle', [RegionalController::class, 'index'])->name('regional_controle.index');

// routes/api.php
Route::put('/countries/{id}', function (Request $request, $id) {
    $country = \App\Models\Country::findOrFail($id);
    $country->update(['status' => $request->status]);
    return response()->json(['success' => true]);
});
