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
            $table->string('lokasi');
            $table->string('jenis'); // ✅ ini penting
            $table->integer('harga');
            $table->string('gambar');
            $table->string('status');
            $table->json('fasilitas');
            // 1 kolom fasilitas (JSON)
            // contoh isi: ["AC","WiFi","Lemari","Dapur","Parkir"]
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
