<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserProfileController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| PUBLIC
|--------------------------------------------------------------------------
*/

// HOME
Route::get('/', [HomeController::class, 'index'])->name('home');

// REGISTER
Route::get('/register', function () {
    return view('user.auth.register');
})->name('register');

Route::post('/register', [AuthController::class, 'register'])
    ->name('register.process');

// LOGIN
Route::get('/login', [AuthController::class, 'showLogin'])
    ->name('login');

Route::post('/login', [AuthController::class, 'login'])
    ->name('login.process');

Route::post('/logout', [AuthController::class, 'logout'])
    ->name('logout');


/*
|--------------------------------------------------------------------------
| PROTECTED (WAJIB LOGIN)
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    // DASHBOARD
    Route::get('/dashboard', function () {
        return view('user.home.dashboard');
    })->name('dashboard');

    // PROFILE
    Route::get('/profile', [UserProfileController::class, 'index'])
        ->name('profile');

    Route::post('/profile/update', [UserProfileController::class, 'update'])
        ->name('profile.update');

    Route::post('/profile/password', [UserProfileController::class, 'updatePassword'])
        ->name('profile.password');
});
