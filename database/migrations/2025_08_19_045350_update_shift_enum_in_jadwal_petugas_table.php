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
        Schema::table('jadwal_petugas', function (Blueprint $table) {
            // Hapus dulu kolom lama
            $table->dropColumn('shift');
        });

        Schema::table('jadwal_petugas', function (Blueprint $table) {
            // Tambah ulang kolom shift dengan enum
            $table->enum('shift', [
                'Shift 1 (07.00 - 15.00)',
                'Shift 2 (15.00 - 23.00)'
            ])->after('tanggal');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('jadwal_petugas', function (Blueprint $table) {
            $table->dropColumn('shift');
        });

        Schema::table('jadwal_petugas', function (Blueprint $table) {
            $table->string('shift')->after('tanggal');
        });
    }
};
