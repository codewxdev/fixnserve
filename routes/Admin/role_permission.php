<?php

use App\Http\Controllers\Front\RolePermissionController;
use Illuminate\Support\Facades\Route;
 

//Roles & permission Module Routes
Route::get('/roles/permissions',[RolePermissionController::class, 'index'])->name('role.permission.index');