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
        Schema::create('pihak_terkaits', function (Blueprint $table) {
            $table->id();
            $table->string('npwp')->nullable();
            $table->string('nama_pengurus')->nullable();
            $table->string('jenis_orang_terkait')->default('Orang Pribadi');
            $table->string('kategori_wajib_pajak')->default('Orang Pribadi');
            $table->string('kewarganegaraan')->nullable();
            $table->string('negara_asal')->nullable();
            $table->string('sub_orang_terkait')->nullable();
            $table->string('id_penunjukkan_perwakilan')->nullable();
            $table->string('keterangan')->nullable();
            $table->boolean('is_orang_terkait')->default(true);
            $table->boolean('is_penanggung_jawab')->default(true);
            $table->date('tanggal_mulai')->nullable();
            $table->date('tanggal_berakhir')->nullable();

            $table->boolean('adalah_data_eksternal')->nullable();
            $table->string('nomor_paspor')->nullable();
            $table->string('presentasi_pemgegang_saham')->nullable();
            $table->string('klasifikasi_saham')->nullable();
            $table->string('jenis_wajib_pajak_terkait')->nullable();
            $table->string('kewarganegaraan_pemegang_saham')->nullable();
            $table->string('kriteria_pemilik_manfaat')->nullable();
            $table->date('tanggal_selesai')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pihak_terkaits');
    }
};