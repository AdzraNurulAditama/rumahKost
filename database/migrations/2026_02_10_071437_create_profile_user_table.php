<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
{
    Schema::table('users', function (Blueprint $table) {
        if (!Schema::hasColumn('users', 'nomor_telepon')) {
            $table->string('nomor_telepon')->nullable()->after('email');
        }
        if (!Schema::hasColumn('users', 'tanggal_lahir')) {
            $table->date('tanggal_lahir')->nullable()->after('nomor_telepon');
        }
        if (!Schema::hasColumn('users', 'jenis_kelamin')) {
            $table->string('jenis_kelamin')->nullable()->after('tanggal_lahir');
        }
        if (!Schema::hasColumn('users', 'status')) {
            $table->string('status')->nullable()->after('jenis_kelamin');
        }
        // TAMBAHKAN INI:
        if (!Schema::hasColumn('users', 'photo')) {
            $table->string('photo')->nullable()->after('status');
        }
    });
}

public function down()
{
    Schema::table('users', function (Blueprint $table) {
        // Tambahkan 'photo' di daftar drop
        $table->dropColumn(['nomor_telepon', 'tanggal_lahir', 'jenis_kelamin', 'status', 'photo']);
    });
}
};
