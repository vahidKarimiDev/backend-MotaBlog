<?php
require_once __DIR__ . '/Api/Admin.php';
\Illuminate\Support\Facades\Route::apiResource('/test', \App\Http\Controllers\Post\PostController::class);
