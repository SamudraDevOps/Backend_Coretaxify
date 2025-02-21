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
        Schema::create('kuasa_wajib_pajaks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('profil_saya_id')->nullable()->constrained();
            $table->boolean('is_wajib_pajak')->nullable();
            $table->string('id_penunjukkan_perwakilan')->nullable();
            $table->string('npwp_perwakilan')->nullable();
            $table->string('nama_wakil')->nullable();
            $table->string('jenis_perwakilan')->nullable();
            $table->string('nomor_dokumen_penunjukkan_perwakilan')->nullable();
            $table->string('izin_perwakilan')->nullable();
            $table->string('status_penunjukkan')->nullable();
            $table->date('tanggal_disetujui')->nullable();
            $table->date('tanggal_ditolak')->nullable();
            $table->date('tanggal_dicabut')->nullable();
            $table->date('tanggal_dibatalkan')->nullable();
            $table->date('tanggal_tertunda')->nullable();
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
        Schema::dropIfExists('kuasa_wajib_pajaks');
    }
};