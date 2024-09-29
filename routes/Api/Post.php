<?php

use \Illuminate\Support\Facades\Route;

Route::post('/upload', [\App\Http\Controllers\Post\PostController::class, 'uploadImageCkeditor']);

Route::apiResource('/blog', \App\Http\Controllers\Post\PostController::class);
