<?php

use \Illuminate\Support\Facades\Route;

Route::apiResource('/contact', \App\Http\Controllers\Contact\ContactController::class);
