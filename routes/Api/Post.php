<?php

use \Illuminate\Support\Facades\Route;

Route::apiResource('/blog', \App\Http\Controllers\Post\PostController::class);
