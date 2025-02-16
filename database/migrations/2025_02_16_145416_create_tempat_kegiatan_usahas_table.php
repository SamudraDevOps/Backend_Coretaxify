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
            $table->foreignId('account_id')->constrained()->onDelete('cascade');
            $table->foreignId('assignment_users_id')->constrained()->onDelete('cascade');
            $table->string('nitku');
            $table->string('jenis_tku');
            $table->string('nama_tku');
            $table->string('deskripsi_tku');
            $table->string('nama_klu');
            $table->string('deskripsi_klu');
            $table->string('tambah_pic_tku_id');
            $table->string('jenis_alamat');
            $table->string('detail_alamat');
            $table->string('rt');
            $table->string('rw');
            $table->string('provinsi');
            $table->string('kota_kabupaten');
            $table->string('kecamatan');
            $table->string('kelurahan_desa');
            $table->string('kode_pos');
            $table->string('data_geometri');
            $table->string('seksi_pengawasan');
            $table->boolean('is_lokasi_yang_disewa');
            $table->date('tanggal_dimulai');
            $table->date('tanggal_berakhir');
            $table->boolean('is_toko_retail');
            $table->boolean('is_kawasan_bebas');
            $table->boolean('is_kawasan_ekonomi_khusus');
            $table->boolean('is_tempat_penimbunan_berikat');
            $table->string('nomor_surat_keputusan');
            $table->date('decree_number_data_valid_from');
            $table->date('decree_number_data_valid_to');
            $table->string('kode_kpp');
            $table->boolean('is_alamat_utama_pkp');
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