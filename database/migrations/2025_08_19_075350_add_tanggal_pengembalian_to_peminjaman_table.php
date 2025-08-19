<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
        {
            Schema::table('peminjaman', function (Blueprint $table) {
                $table->date('tanggal_pengembalian')->nullable()->after('tgl_kembali');
            });
        }

    public function down(): void
        {
            Schema::table('peminjaman', function (Blueprint $table) {
                $table->dropColumn('tanggal_pengembalian');
            });
}

};
