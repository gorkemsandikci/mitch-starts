<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return ['Laravel' => route('google.redirect')];
});

Route::get('/google/callback', function () {
    return ['Laravel' => app()->version()];
});

require __DIR__ . '/auth.php';
