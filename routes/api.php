<?php
require_once __DIR__ . '/Api/Admin.php';
require_once __DIR__ . '/Api/Post.php';
require_once __DIR__ . '/Api/Contact.php';

\Illuminate\Support\Facades\Route::get('/api-doc' , function () {
   $file = \Illuminate\Support\Facades\Storage::get('/api-docs/api-docs.json');
   return response($file, 200)->header("Content-Type", "application/json");
});
