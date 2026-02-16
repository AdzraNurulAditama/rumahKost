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
    Schema::create('kelolakost', function (Blueprint $table) {
        $table->id();
        $table->string('nama');
        $table->string('alamat');
        $table->string('jenis')->default('Putra'); // Sesuai kolom "Jenis" di gambar
        $table->integer('harga');
        $table->json('fasilitas'); // Untuk menyimpan banyak fasilitas sekaligus
        $table->string('gambar');
        $table->string('status')->default('Aktif'); // Sesuai kolom "Status" di gambar
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kelolakost');
    }
};
