<?php

use \Illuminate\Support\Facades\Route;


Route::post('/login', \App\Http\Controllers\Admin\AuthAdminController::class);
Route::apiResource('/admin', \App\Http\Controllers\Admin\AdminController::class);
