<?php

use App\Domains\System\Controllers\Cp\v1\CountryController;
use Illuminate\Routing\Route;

Route::get('countries/list', [CountryController::class, 'index']);
