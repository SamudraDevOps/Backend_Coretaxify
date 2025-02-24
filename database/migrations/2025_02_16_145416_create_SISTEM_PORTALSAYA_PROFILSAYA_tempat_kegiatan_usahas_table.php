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
        Schema::create('tempat_kegiatan_usahas', function (Blueprint $table) {
            $table->id();
             
            $table->string('nitku')->nullable();
            $table->string('jenis_tku')->nullable();
            $table->string('nama_tku')->nullable();
            $table->string('deskripsi_tku')->nullable();
            $table->string('nama_klu')->nullable();
            $table->string('deskripsi_klu')->nullable();
            $table->string('tambah_pic_tku_id')->nullable();
            $table->string('jenis_alamat')->nullable();
            $table->string('detail_alamat')->nullable();
            $table->string('rt')->nullable();
            $table->string('rw')->nullable();
            $table->string('provinsi')->nullable();
            $table->string('kota_kabupaten')->nullable();
            $table->string('kecamatan')->nullable();
            $table->string('kelurahan_desa')->nullable();
            $table->string('kode_pos')->nullable();
            $table->string('data_geometri')->nullable();
            $table->string('seksi_pengawasan')->nullable();
            $table->boolean('is_lokasi_yang_disewa')->nullable();
            $table->date('tanggal_dimulai')->nullable();
            $table->date('tanggal_berakhir')->nullable();
            $table->boolean('is_toko_retail')->nullable();
            $table->boolean('is_kawasan_bebas')->nullable();
            $table->boolean('is_kawasan_ekonomi_khusus')->nullable();
            $table->boolean('is_tempat_penimbunan_berikat')->nullable();
            $table->string('nomor_surat_keputusan')->nullable();
            $table->date('decree_number_data_valid_from')->nullable();
            $table->date('decree_number_data_valid_to')->nullable();
            $table->string('kode_kpp')->nullable();
            $table->boolean('is_alamat_utama_pkp')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tempat_kegiatan_usahas');
    }
};