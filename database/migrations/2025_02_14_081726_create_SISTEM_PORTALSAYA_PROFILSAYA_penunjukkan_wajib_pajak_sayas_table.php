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
        Schema::create('penunjukkan_wajib_pajak_sayas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('profil_saya_id')->nullable()->constrained();
            $table->string('status_pemberian_akses_portal')->nullable();
            $table->string('nama_wajib_pajak')->nullable();
            $table->string('npwp')->nullable();
            $table->string('nomor_penunjukkan')->nullable();
            $table->string('status_penunjukkan')->nullable();
            $table->date('tanggal_disetujui')->nullable();
            $table->date('tanggal_ditolak')->nullable();
            $table->date('tanggal_dicabut')->nullable();
            $table->date('tanggal_dibatalkan')->nullable();
            $table->string('alasan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penunjukkan_wajib_pajak_sayas');
    }
};