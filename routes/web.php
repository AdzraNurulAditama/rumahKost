<?php

use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| WEB ROUTES
|--------------------------------------------------------------------------
*/

// HOME / DASHBOARD (LIST + FILTER KOST)
Route::get('/', [HomeController::class, 'index'])
    ->name('home');

// // DETAIL KOST (KLIK CARD)
// Route::get('/kost/{id}', [HomeController::class, 'show'])
//     ->name('kost.detail');
