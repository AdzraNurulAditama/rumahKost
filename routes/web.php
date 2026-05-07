<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DisukaiController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\KelolaKostController;
use App\Http\Controllers\UserProfileController;
use App\Http\Controllers\PengajuanController;
use App\Http\Controllers\KelolaKamarController;
use App\Http\Controllers\PenyewaController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\ChatController;

/*
|--------------------------------------------------------------------------
| PUBLIC
|--------------------------------------------------------------------------
*/

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/kost/{id}', [HomeController::class, 'detail'])
    ->name('kost.detail');


// ======================
// REGISTER USER
// ======================

Route::get('/register', function () {
    return view('user.auth.register');
})->name('register');

Route::post('/register', [AuthController::class, 'register'])
    ->name('register.process');


// ======================
// LOGIN USER
// ======================

Route::get('/login', [AuthController::class, 'showLogin'])
    ->name('login');

Route::post('/login', [AuthController::class, 'login'])
    ->name('login.process');

Route::post('/logout', [AuthController::class, 'logout'])
    ->name('logout');


// ======================
// OTP USER
// ======================

Route::get('/otp', [AuthController::class, 'showOtpForm'])
    ->name('otp.form');

Route::post('/otp', [AuthController::class, 'verifyOtp'])
    ->name('otp.verify');


/*
|--------------------------------------------------------------------------
| USER
|--------------------------------------------------------------------------
*/

Route::prefix('user')->name('user.')->middleware('auth')->group(function () {

    // ❤️ LIKE
    Route::post('/like/{id}', [LikeController::class, 'toggle'])
        ->name('like.toggle');

    // ❤️ DISUKAI
    Route::get('/disukai', [DisukaiController::class, 'index'])
        ->name('disukai');

    // PROFILE
    Route::get('/profile', [UserProfileController::class, 'index'])
        ->name('profile');

    Route::post('/profile/update', [UserProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile/photo', [UserProfileController::class, 'deletePhoto'])
        ->name('profile.photo.delete');

    // GALLERY
    Route::get('/kost/{id}/gallery', [GalleryController::class, 'index'])
        ->name('gallery');

    // PENGAJUAN SEWA
    Route::get('/pengajuan-sewa/{id}', [PengajuanController::class, 'show'])
        ->name('pengajuan.show');

    Route::post('/pengajuan/{id}', [PengajuanController::class, 'create'])
        ->name('pengajuan.create');

    // RIWAYAT SEWA
    Route::get('/sewa', [PengajuanController::class, 'riwayat'])
        ->name('sewa');

    // BATAL PENGAJUAN
    Route::delete('/pengajuan/{id}', [PengajuanController::class, 'batal'])
        ->name('pengajuan.batal');

    // KOSAN SAYA
    Route::get('/kosan-saya', [PenyewaController::class, 'kosanSaya'])
        ->name('kosan.saya');

    // ULASAN
    Route::get('/ulasan', [ReviewController::class, 'index'])
        ->name('ulasan');

    // CHAT
    Route::get('/chat/{user}', [ChatController::class, 'index'])
        ->name('chat.room');

    Route::post('/chat/send', [ChatController::class, 'send'])
        ->name('chat.send');

    Route::get('/chat/kost/{kost}', [ChatController::class, 'chatKost'])
        ->name('chat.kost');

});


// ======================
// STORE PENGAJUAN
// ======================

Route::post('/pengajuan', [PengajuanController::class, 'storePengajuan'])
    ->middleware('auth')
    ->name('pengajuan.store');


// ======================
// HALAMAN MENUNGGU
// ======================

Route::get('/menunggu-persetujuan', function () {
    return view('user.menunggu');
})->name('menunggu');


// ======================
// CHECKIN
// ======================

Route::get('/checkin', function () {
    return view('user.checkin');
})->name('checkin');


// ======================
// REVIEW GLOBAL
// ======================

Route::post('/review/{kost}', [ReviewController::class, 'store'])
    ->name('review.store');

Route::delete('/review/{id}', [ReviewController::class, 'destroy'])
    ->name('review.delete');


/*
|--------------------------------------------------------------------------
| ADMIN
|--------------------------------------------------------------------------
*/

Route::prefix('admin')->name('admin.')->group(function () {

    // ======================
    // LOGIN ADMIN
    // ======================

    Route::get('/login', [AdminAuthController::class, 'showLogin'])
        ->name('login');

    Route::post('/login', [AdminAuthController::class, 'login'])
        ->name('login.process');


    // ======================
    // OTP ADMIN
    // ======================

    Route::get('/otp', [AdminAuthController::class, 'showOtpForm'])
        ->name('otp.form');

    Route::post('/otp', [AdminAuthController::class, 'verifyOtp'])
        ->name('otp.verify');


    // ======================
    // REGISTER ADMIN
    // ======================

    Route::get('/register', [AdminAuthController::class, 'showRegister'])
        ->name('register');

    Route::post('/register', [AdminAuthController::class, 'register'])
        ->name('register.process');


    Route::middleware('auth')->group(function () {

        // LOGOUT
        Route::post('/logout', [AdminAuthController::class, 'logout'])
            ->name('logout');

        // DASHBOARD
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])
            ->name('dashboard');

        // PROFILE
        Route::get('/profile', [UserProfileController::class, 'index'])
            ->name('profile');

        // ======================
        // KELOLA KOST
        // ======================

        Route::delete('kost/image/{id}', [KelolaKostController::class, 'destroyImage'])
            ->name('kost.image.delete');

        Route::delete('kost/video/{id}', [KelolaKostController::class, 'destroyVideo'])
            ->name('kost.video.delete');

        Route::resource('kost', KelolaKostController::class);

        // ======================
        // PENYEWA
        // ======================

        Route::get('/penyewa', [PenyewaController::class, 'index'])
            ->name('penyewa.index');

        Route::put('/penyewa/{id}', [PenyewaController::class, 'update'])
            ->name('penyewa.update');

        Route::delete('/penyewa/{id}', [PenyewaController::class, 'destroy'])
            ->name('penyewa.destroy');

        // ======================
        // KAMAR
        // ======================

        Route::get('/kelola-kamar', [KelolaKamarController::class, 'index'])
            ->name('kamar.index');

        Route::get('/kelola-kamar/create', [KelolaKamarController::class, 'create'])
            ->name('kamar.create');

        Route::post('/kelola-kamar', [KelolaKamarController::class, 'store'])
            ->name('kamar.store');

        Route::put('/kelola-kamar/{id}', [KelolaKamarController::class, 'update'])
            ->name('kamar.update');

        Route::delete('/kelola-kamar/{id}', [KelolaKamarController::class, 'destroy'])
            ->name('kamar.destroy');

        // ======================
        // CHAT ADMIN
        // ======================

        Route::get('/chat', [ChatController::class, 'adminIndex'])
            ->name('chat.index');

        Route::get('/chat/{user}', [ChatController::class, 'index'])
            ->name('chat.room');

    });

});