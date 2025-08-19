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
    Schema::create('denda', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('peminjaman_id');
        $table->integer('jumlah_denda'); // misal rupiah
        $table->date('tanggal_denda');
        $table->timestamps();

        $table->foreign('peminjaman_id')->references('id')->on('peminjaman')->onDelete('cascade');
    });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('denda');
    }
};
