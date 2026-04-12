<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Midtrans Server Key
    |--------------------------------------------------------------------------
    |
    | Ambil dari dashboard Midtrans (Settings → Access Keys)
    |
    */

    'server_key' => env('MIDTRANS_SERVER_KEY'),

    /*
    |--------------------------------------------------------------------------
    | Midtrans Client Key
    |--------------------------------------------------------------------------
    |
    | Digunakan di frontend (Snap.js)
    |
    */

    'client_key' => env('MIDTRANS_CLIENT_KEY'),

    /*
    |--------------------------------------------------------------------------
    | Production Mode
    |--------------------------------------------------------------------------
    |
    | false = Sandbox (testing)
    | true  = Production (live)
    |
    */

    'is_production' => env('MIDTRANS_IS_PRODUCTION', false),

    /*
    |--------------------------------------------------------------------------
    | Sanitized
    |--------------------------------------------------------------------------
    |
    | Membersihkan input dari potensi karakter berbahaya
    |
    */

    'is_sanitized' => env('MIDTRANS_IS_SANITIZED', true),

    /*
    |--------------------------------------------------------------------------
    | 3DS Security
    |--------------------------------------------------------------------------
    |
    | Untuk keamanan kartu kredit (wajib aktif di production)
    |
    */

    'is_3ds' => env('MIDTRANS_IS_3DS', true),

];