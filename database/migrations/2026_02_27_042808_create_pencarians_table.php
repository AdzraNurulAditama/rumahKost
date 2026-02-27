<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pencarians', function (Blueprint $table) {
            $table->id();
            $table->string('nama_kost');
            $table->string('lokasi');
            $table->integer('harga');
            $table->text('fasilitas')->nullable();
            $table->string('foto')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pencarians');
    }
};