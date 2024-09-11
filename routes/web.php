<?php

use Illuminate\Support\Facades\Route;

Route::get('/about', function () {
    return view('welcome');
});
Route::get('/', function () {
    return view(('index'));
});
