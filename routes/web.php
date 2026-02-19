<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserProfileController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DisukaiController;
use App\Http\Controllers\KelolaKostController; 
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

    // DASHBOARD USER
    Route::get('/dashboard', [HomeController::class, 'dashboard'])
        ->name('dashboard');

    // PROFILE
    Route::get('/profile', [userProfileController::class, 'index'])->name('user.profile');
    Route::post('/profile/update', [userProfileController::class, 'update'])->name('user.profile.update');
    Route::post('/profile/password', [userProfileController::class, 'updatePassword'])->name('user.password.update');
    
    Route::get('/profile/disukai', [DisukaiController::class, 'index'])->name('user.disukai');
    Route::get('/profile/voucher', [userProfileController::class, 'voucher'])->name('user.voucher');
    /*
    |--------------------------------------------------------------------------
    | ADMIN AREA (KELOLA KOST) - SESUAI DESAIN DASHBOARD ADMIN
    |--------------------------------------------------------------------------
    */
    Route::prefix('admin')->name('admin.')->group(function () {
        
        // Halaman Utama Tabel Kelola Kost
        Route::get('/kost', [KelolaKostController::class, 'index'])->name('kost.index');
        
        // Form Tambah Kost Baru
        Route::get('/kost/create', [KelolaKostController::class, 'create'])->name('kost.create');
        
        // Simpan Data Kost
        Route::post('/kost', [KelolaKostController::class, 'store'])->name('kost.store');
        
        // Form Edit Kost
        Route::get('/kost/{id}/edit', [KelolaKostController::class, 'edit'])->name('kost.edit');
        
        // Update Data Kost
        Route::put('/kost/{id}', [KelolaKostController::class, 'update'])->name('kost.update');
        
        // Hapus Data Kost
        Route::delete('/kost/{id}', [KelolaKostController::class, 'destroy'])->name('kost.destroy');
    });

    
});