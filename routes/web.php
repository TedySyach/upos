<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\MasterDataController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('pages.auth-login');
});

Route::middleware(['auth'])->group(
    function () {
        Route::get('home', function () {
            return view('pages.dashboard');
        })->name('home');
        Route::resource('cashiers', UserController::class);
        Route::resource('masterdata', MasterDataController::class);
        Route::resource('category', CategoryController::class);
    }
);

// Route::get('/login', function () {
//     return view('pages.auth-login');
// });
