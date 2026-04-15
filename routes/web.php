<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Admin\KelolaPembayaranController as AdminKelolaPembayaranController;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DisukaiController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\KelolaKostController;
use App\Http\Controllers\UserProfileController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\PembayaranController;
use App\Http\Controllers\PengajuanController;
use App\Http\Controllers\KelolaKamarController;
use App\Http\Controllers\PenyewaController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\KelolaPembayaranController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\MidtransController;

/*
|--------------------------------------------------------------------------
| PUBLIC
|--------------------------------------------------------------------------
*/

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/kost/{id}', [HomeController::class, 'detail'])->name('kost.detail');

Route::get('/register', function () {
    return view('user.auth.register');
})->name('register');

Route::post('/register', [AuthController::class, 'register'])->name('register.process');

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.process');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::post('/midtrans/callback', [MidtransController::class, 'callback']);

/*
|--------------------------------------------------------------------------
| USER
|--------------------------------------------------------------------------
*/

Route::prefix('user')->name('user.')->middleware('auth')->group(function () {

    Route::get('/disukai', [DisukaiController::class, 'index'])->name('disukai');
    Route::post('/like/{id}', [LikeController::class, 'toggle'])->name('like.toggle');

    // PROFILE
    Route::get('/profile', [UserProfileController::class, 'index'])->name('profile');
    Route::post('/profile/update', [UserProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile/photo', [UserProfileController::class, 'deletePhoto'])->name('profile.photo.delete');

    Route::get('/kost/{id}/gallery', [GalleryController::class, 'index'])->name('gallery');

    Route::get('/transaksi', [TransaksiController::class, 'index'])->name('transaksi');

    // PENGAJUAN
    Route::get('/pengajuan-sewa/{id}', [PengajuanController::class, 'show'])->name('pengajuan');
    Route::post('/pengajuan-sewa/{id}', [PengajuanController::class, 'create'])->name('pengajuan.create');
    Route::get('/pengajuan-status/{id}', [PengajuanController::class, 'status'])->name('pengajuan.status');
    Route::delete('/pengajuan-batal/{id}', [PengajuanController::class, 'batal'])->name('pengajuan.batal');

    Route::get('/sewa', [PengajuanController::class,'riwayat'])->name('sewa');
    Route::get('/kosan-saya', [PenyewaController::class,'kosanSaya'])->name('kosan.saya');

    // PEMBAYARAN
    Route::get('/pembayaran/{id}', [PembayaranController::class, 'index'])->name('pembayaran.index');
    Route::post('/pembayaran/{id}', [PembayaranController::class, 'bayar'])->name('pembayaran.bayar');

    // ======================
    // 🔥 TAMBAHAN FIX ULASAN
    // ======================
    Route::get('/ulasan', [ReviewController::class, 'index'])->name('ulasan');

    // ======================
    // CHAT (USER & ADMIN)
    // ======================
    Route::get('/chat/{user}', [ChatController::class, 'index'])->name('chat.room');
    Route::post('/chat/send', [ChatController::class, 'send'])->name('chat.send');
    Route::get('/chat/kost/{kost}', [ChatController::class, 'chatKost'])->name('chat.kost');

});

// REVIEW GLOBAL
Route::post('/review/{kost}', [ReviewController::class, 'store'])->name('review.store');
Route::delete('/review/{id}', [ReviewController::class, 'destroy'])->name('review.delete');

/*
|--------------------------------------------------------------------------
| ADMIN
|--------------------------------------------------------------------------
*/

Route::prefix('admin')->name('admin.')->group(function () {

    Route::get('/login',[AdminAuthController::class,'showLogin'])->name('login');
    Route::post('/login',[AdminAuthController::class,'login'])->name('login.process');

    Route::get('/register',[AdminAuthController::class,'showRegister'])->name('register');
    Route::post('/register',[AdminAuthController::class,'register'])->name('register.process');

    Route::middleware('auth')->group(function () {

        Route::post('/logout',[AdminAuthController::class,'logout'])->name('logout');

        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

        Route::get('/profile', [UserProfileController::class, 'index'])->name('profile');

        // KELOLA KOST
        Route::delete('kost/image/{id}', [KelolaKostController::class, 'destroyImage'])->name('kost.image.delete');
        Route::delete('kost/video/{id}', [KelolaKostController::class, 'destroyVideo'])->name('kost.video.delete');
        Route::resource('kost', KelolaKostController::class);

        // PENYEWA
        Route::get('/penyewa', [PenyewaController::class, 'index'])->name('penyewa.index');
        Route::put('/penyewa/{id}', [PenyewaController::class, 'update'])->name('penyewa.update');
        Route::delete('/penyewa/{id}', [PenyewaController::class,'destroy'])->name('penyewa.destroy');

        // KAMAR
        Route::get('/kelola-kamar', [KelolaKamarController::class, 'index'])->name('kamar.index');
        Route::get('/kelola-kamar/create', [KelolaKamarController::class, 'create'])->name('kamar.create');
        Route::post('/kelola-kamar', [KelolaKamarController::class, 'store'])->name('kamar.store');
        Route::put('/kelola-kamar/{id}', [KelolaKamarController::class, 'update'])->name('kamar.update');
        Route::delete('/kelola-kamar/{id}', [KelolaKamarController::class, 'destroy'])->name('kamar.destroy');

        // PEMBAYARAN
        Route::resource('pembayaran', KelolaPembayaranController::class);

        // CHAT ADMIN
        Route::get('/chat', [ChatController::class, 'adminIndex'])->name('chat.index');
        Route::get('/chat/{user}', [ChatController::class, 'index'])->name('chat.room');

    });

});