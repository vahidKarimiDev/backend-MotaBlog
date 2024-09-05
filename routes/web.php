<?php

use \Illuminate\Support\Facades\Route;

Route::get('/apiDoc', function () {
    return view('apiDoc');
});
