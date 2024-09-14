<?php

use \Illuminate\Support\Facades\Route;

Route::apiResource('/category', \App\Http\Controllers\Category\CategoryController::class);
