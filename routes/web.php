<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\userProfileController;
use Illuminate\Support\Facades\Route;

// HOME / DASHBOARD (LIST + FILTER KOST)
Route::get('/', [HomeController::class, 'index'])->name('home');

// PROFILE
Route::get('/profile', [userProfileController::class, 'index'])->name('profile.index');
Route::post('/profile/update', [userProfileController::class, 'update'])->name('profile.update');
Route::post('/profile/password', [userProfileController::class, 'updatePassword'])->name('profile.password');
 