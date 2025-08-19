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
    Schema::create('peminjaman', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('anggota_id');
        $table->unsignedBigInteger('petugas_id');
        $table->date('tgl_pinjam');
        $table->date('tgl_kembali');
        $table->enum('status', ['dipinjam', 'dikembalikan', 'terlambat']);
        $table->timestamps();

        $table->foreign('anggota_id')->references('id')->on('anggota')->onDelete('cascade');
        $table->foreign('petugas_id')->references('id')->on('users')->onDelete('cascade');
    });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('peminjaman');
    }
};
