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
        Schema::create('jenis_pajaks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('profil_saya_id')->nullable()->constrained();
            $table->string('jenis_pajak')->nullable();
            $table->date('tanggal_permohonan')->nullable();
            $table->date('tanggal_mulai_transaksi')->nullable();
            $table->date('tanggal_pendaftaran')->nullable();
            $table->date('tanggal_pencabutan_pendaftaran')->nullable();
            $table->integer('nomor_kasus')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jenis_pajaks');
    }
};