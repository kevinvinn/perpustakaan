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
    Schema::create('buku', function (Blueprint $table) {
        $table->id();
        $table->string('judul');
        $table->unsignedBigInteger('kategori_id');
        $table->integer('stok');
        $table->year('tahun_terbit');
        $table->timestamps();

        $table->foreign('kategori_id')->references('id')->on('kategori')->onDelete('cascade');
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('buku');
    }
};
