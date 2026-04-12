<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kost_videos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kost_id')->constrained()->onDelete('cascade');
            $table->string('video'); // nama file video
            $table->string('judul')->nullable(); // judul opsional
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kost_videos');
    }
};