<?php

use \Illuminate\Support\Facades\Route;

Route::apiResource('/admin', \App\Http\Controllers\Admin\AdminController::class);
