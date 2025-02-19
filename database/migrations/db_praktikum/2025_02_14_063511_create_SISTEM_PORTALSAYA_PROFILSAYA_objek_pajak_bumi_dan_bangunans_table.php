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
        Schema::create('objek_pajak_bumi_dan_bangunans', function (Blueprint $table) {
            $table->id();
            $table->string('nop')->nullable();
            $table->string('nama_objek_pajak')->nullable();
            $table->string('sektor')->nullable();
            $table->string('jenis')->nullable();
            $table->string('tipe_bumi')->nullable();
            $table->string('rincian')->nullable();
            $table->string('status_kegiatan')->nullable();
            $table->string('instansi_pemberi_izin')->nullable();
            $table->integer('luas_objek_pajak')->nullable();
            $table->integer('nomor_induk_berusaha')->nullable();
            $table->date('tanggal_nomor_induk_berusaha')->nullable();
            $table->integer('nomor_ijin_objek')->nullable();
            $table->date('tanggal_ijin_objek')->nullable();
            $table->string('detail_alamat')->nullable();
            $table->string('provinsi')->nullable();
            $table->string('kota_kabupaten')->nullable();
            $table->string('kecamatan')->nullable();
            $table->string('kelurahan_desa')->nullable();
            $table->string('kode_wilayah')->nullable();
            $table->string('kode_pos')->nullable();
            $table->string('data_geometri')->nullable();
            $table->date('tanggal_pendaftaran')->nullable();
            $table->date('tanggal_pencabutan_pendaftaran')->nullable();
            $table->string('kode_kpp')->nullable();
            $table->string('seksi_pengawasan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('objek_pajak_bumi_dan_bangunans');
    }
};