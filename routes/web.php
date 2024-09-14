<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;

Route::fallback(function () {
    return "<h1>404 Not Found</h1>";
});

Route::get('/', function () {
    return view('index');
})->name('index');

Route::get('/about', [AdminController::class, 'about'])->name('about');
Route::get('/blog', [AdminController::class, 'blog'])->name('blog');
Route::get('/create_post', [AdminController::class, 'create'])->name('create_post');
Route::post('/insert', [AdminController::class, 'insert'])->name('insert');
Route::get('delete/{id}', [AdminController::class, 'delete'])->name('delete');
Route::get('change/{id}', [AdminController::class, 'change'])->name('change');
Route::put('/update/{id}', [AdminController::class, 'update'])->name('update');