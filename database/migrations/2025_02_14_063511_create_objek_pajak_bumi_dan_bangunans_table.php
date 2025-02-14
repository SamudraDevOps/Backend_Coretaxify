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
            $table->foreignId('account_id')->constrained()->onDelete('cascade');
            $table->foreignId('assignment_users_id')->constrained()->onDelete('cascade');
            $table->string('nop');
            $table->string('nama_objek_pajak');
            $table->string('sektor');
            $table->string('jenis');
            $table->string('tipe_bumi');
            $table->string('rincian');
            $table->string('status_kegiatan');
            $table->string('instansi_pemberi_izin');
            $table->integer('luas_objek_pajak');
            $table->integer('nomor_induk_berusaha');
            $table->date('tanggal_nomor_induk_berusaha');
            $table->integer('nomor_ijin_objek');
            $table->date('tanggal_ijin_objek');
            $table->string('detail_alamat');
            $table->string('provinsi');
            $table->string('kota_kabupaten');
            $table->string('kecamatan');
            $table->string('kelurahan_desa');
            $table->string('kode_wilayah');
            $table->string('kode_pos');
            $table->string('data_geometri');
            $table->date('tanggal_pendaftaran');
            $table->date('tanggal_pencabutan_pendaftaran');
            $table->string('kode_kpp');
            $table->string('seksi_pengawasan');
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