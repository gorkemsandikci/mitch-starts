<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {

//    return ['Laravel' => app()->version()];
    return ['Laravel' => route('google.redirect')];
});

require __DIR__.'/auth.php';
