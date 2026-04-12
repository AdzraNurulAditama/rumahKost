<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('kamars', function (Blueprint $table) {
            $table->id();
            // Menyambungkan ke tabel kosts milikmu
            $table->foreignId('kost_id')->constrained('kosts')->onDelete('cascade');
            $table->string('nomor_kamar');
            $table->string('tipe_kamar');
            $table->integer('harga');
            $table->string('status')->default('Aktif');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('kamars');
    }
};