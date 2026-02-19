<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('kosts', function (Blueprint $table) {
            $table->id();

            $table->string('nama');
            $table->text('alamat');
            $table->string('lokasi'); // Karawang, Karawang Barat, dll

            $table->integer('harga'); // harga per tahun

            $table->string('gambar'); // path gambar

            // 1 kolom fasilitas (JSON)
            // contoh isi: ["AC","WiFi","Lemari","Dapur","Parkir"]
            $table->json('fasilitas');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kosts');
    }
};
