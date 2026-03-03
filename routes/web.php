<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserProfileController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DisukaiController;
use App\Http\Controllers\KelolaKostController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\PenyewaController; 
use App\Http\Controllers\PencarianController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| PUBLIC
|--------------------------------------------------------------------------
*/

// HOME
Route::get('/', [HomeController::class, 'index'])->name('home');

// DETAIL KOST (USER LIHAT DETAIL)
Route::get('/kost/{id}', [HomeController::class, 'detail'])
    ->name('kost.detail');

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
| USER (WAJIB LOGIN)
|--------------------------------------------------------------------------
*/

Route::prefix('user')->name('user.')->middleware('auth')->group(function () {

    // FAVORIT
    Route::get('/disukai', [DisukaiController::class, 'index'])
        ->name('disukai');

    // PROFILE
    Route::get('/profile', [UserProfileController::class, 'index'])
        ->name('profile');
});


/*
|--------------------------------------------------------------------------
| PROTECTED (ADMIN)
|--------------------------------------------------------------------------
*/

Route::prefix('admin')->name('admin.')->group(function () {

    // Dashboard Admin
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])
        ->name('dashboard');

    /*
    |------------------------------------------------------------------
    | KELOLA KOST
    |------------------------------------------------------------------
    */

    Route::get('/kost', [KelolaKostController::class, 'index'])
        ->name('kost.index');

    Route::get('/kost/create', [KelolaKostController::class, 'create'])
        ->name('kost.create');

    Route::post('/kost', [KelolaKostController::class, 'store'])
        ->name('kost.store');

    Route::get('/kost/{kost}/edit', [KelolaKostController::class, 'edit'])
        ->name('kost.edit');

    Route::put('/kost/{kost}', [KelolaKostController::class, 'update'])
        ->name('kost.update');

    Route::delete('/kost/{kost}', [KelolaKostController::class, 'destroy'])
        ->name('kost.destroy');

    Route::delete('/kost/image/{image}', [KelolaKostController::class, 'deleteImage'])
        ->name('kost.image.delete');


    /*
    |------------------------------------------------------------------
    | KELOLA PENYEWA
    |------------------------------------------------------------------
    */

    Route::get('/penyewa', [PenyewaController::class, 'index'])
        ->name('penyewa.index');

    Route::post('/penyewa', [PenyewaController::class, 'store'])
        ->name('penyewa.store');

    Route::delete('/penyewa/{id}', [PenyewaController::class, 'destroy'])
        ->name('penyewa.destroy');
});