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
        Schema::create('wakil_sayas', function (Blueprint $table) {
            $table->id();
            $table->string('nama')->nullable();
            $table->string('npwp')->nullable();
            $table->string('jenis_perwakilan')->nullable();
            $table->string('id_penunjukkan_perwakilan')->nullable();
            $table->string('nomor_dokumen_penunjukkan_perwakilan')->unique()->nullable();
            $table->string('izin_perwakilan')->nullable();
            $table->string('status_penunjukkan')->nullable();
            $table->date('tanggal_disetujui')->nullable();
            $table->date('tanggal_ditolak')->nullable();
            $table->date('tanggal_dicabut')->nullable();
            $table->date('tanggal_dibatalkan')->nullable();
            $table->string('alasan')->nullable();
            $table->date('tanggal_mulai')->nullable();
            $table->date('tanggal_berakhir')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wakil_sayas');
    }
};