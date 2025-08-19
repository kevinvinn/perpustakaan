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
    Schema::create('jadwal_petugas', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('petugas_id');
        $table->date('tanggal');
        $table->string('shift');
        $table->timestamps();

        $table->foreign('petugas_id')->references('id')->on('users')->onDelete('cascade');
    });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jadwal_petugas');
    }
};
