<?php

use App\Domains\System\Controllers\Api\V1\CountryController;
use Illuminate\Support\Facades\Route;

Route::get('countries/list', [CountryController::class, 'index']);
