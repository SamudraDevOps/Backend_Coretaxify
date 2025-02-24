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
        Schema::create('profil_sayas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('informasi_umum_id')->nullable()->constrained();
            $table->foreignId('data_ekonomi_id')->nullable()->constrained();
            $table->foreignId('detail_bank_id')->nullable()->constrained();
            $table->foreignId('jenis_pajak_id')->nullable()->constrained();
            $table->foreignId('kode_klu_id')->nullable()->constrained();
            $table->foreignId('kuasa_wajib_pajak_id')->nullable()->constrained();
            $table->foreignId('manajemen_kasus_id')->nullable()->constrained();
            $table->foreignId('nomor_identifikasi_eksternal_id')->nullable()->constrained();
            $table->foreignId('objek_pajak_bumi_dan_bangunan_id')->nullable()->constrained();
            $table->foreignId('pihak_terkait')->nullable()->constrained();
            $table->foreignId('tempat_kegiatan_usaha')->nullable()->constrained();
            $table->foreignId('alamat_wajib_pajak_id')->nullable()->constrained();
            $table->foreignId('penunjukkan_wajib_pajak_saya_id')->nullable()->constrained();
            $table->foreignId('detail_kontak_id')->nullable()->constrained();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profil_sayas');
    }
};