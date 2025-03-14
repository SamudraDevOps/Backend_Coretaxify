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
        Schema::create('informasi_umums', function (Blueprint $table) {
            $table->id();

            $table->string('npwp')->nullable();
            $table->string('jenis_wajib_pajak')->nullable();
            $table->string('nama')->nullable();
            $table->string('kategori_wajib_pajak')->nullable();

            $table->string('negara_asal')->nullable();
            $table->date('tanggal_keputusan_pengesahan')->nullable();
            $table->string('nomor_keputusan_pengesahan_perubahan')->nullable();
            $table->date('tanggal_surat_keputusasan_pengesahan_perubahan')->nullable();
            $table->string('nomor_akta_pendirian')->nullable();
            $table->string('tempat_pendirian')->nullable();
            $table->date('tanggal_pendirian')->nullable();
            $table->string('nik_notaris')->nullable();
            $table->string('nama_notaris')->nullable();
            $table->string('jenis_perusahaan')->nullable();
            $table->string('modal_dasar')->nullable();
            $table->string('modal_ditempatkan')->nullable();
            $table->string('modal_disetor')->nullable();
            $table->string('kewarganegaraan')->nullable();
            $table->string('bahasa')->nullable();

            $table->string('nomor_paspor')->nullable();
            $table->string('tempat_lahir')->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->string('jenis_kelamin')->nullable();
            $table->string('status_perkawinan')->nullable();
            $table->string('status_hubungan_keluarga')->nullable();
            $table->string('agama')->nullable();
            $table->string('jenis_pekerjaan')->nullable();
            $table->string('nama_ibu_kandung')->nullable();
            $table->string('nomor_kartu_keluarga')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('informasi_umums');
    }
};
