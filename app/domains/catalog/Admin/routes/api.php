<?php

use App\Domains\Catalog\Admin\Controllers\Api\CategoryController;
use App\Domains\Catalog\Admin\Controllers\Api\MartCategoryController;
use App\Domains\Catalog\Admin\Controllers\Api\MartSubCategoryController;
use App\Domains\Catalog\Admin\Controllers\Api\SkillController;
use App\Domains\Catalog\Admin\Controllers\Api\SpecialtyController;
use App\Domains\Catalog\Admin\Controllers\Api\SubcategoryController;
use App\Domains\Catalog\Admin\Controllers\Api\SubSpecialtyController;
use Illuminate\Support\Facades\Route;

Route::middleware('health_api', 'check_country')->group(function () {
    Route::get('/skill/suggested', [SkillController::class, 'suggested']);
    Route::get('/skill/search', [SkillController::class, 'search']);

    // Main Authenticated Routes Group with User Status Check
    Route::middleware(['auth:api', 'user.active', 'active.session'])->group(function () {
        Route::prefix('skills')->group(function () {
            Route::post('/add', [SkillController::class, 'addSkills']);
        });

        Route::middleware(['role:Super Admin', '2fa'])->group(function () {
            Route::apiResource('mart-categories', MartCategoryController::class);
            Route::apiResource('mart-sub-categories', MartSubCategoryController::class);
            Route::apiResource('specialties', SpecialtyController::class);
            Route::apiResource('sub-specialties', SubSpecialtyController::class);
            Route::apiResource('categories', CategoryController::class);
            Route::apiResource('subcategories', SubcategoryController::class);
            Route::apiResource('skills', SkillController::class);

        });

    });
});
