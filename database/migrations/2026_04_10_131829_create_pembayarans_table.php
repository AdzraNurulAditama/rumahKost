<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('pembayarans', function (Blueprint $table) {
            $table->id();

            $table->foreignId('penyewa_id')->constrained()->cascadeOnDelete();
            $table->foreignId('kamar_id')->constrained()->cascadeOnDelete();

            $table->integer('jumlah');
            $table->date('tanggal');

            $table->string('bukti')->nullable();
            $table->enum('status', ['menunggu', 'lunas'])->default('menunggu');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pembayarans');
    }
};