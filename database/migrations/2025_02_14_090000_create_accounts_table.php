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
        Schema::create('accounts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('task_id')->nullable()->constrained();
            $table->foreignId('account_type_id')->constrained();
            $table->foreignId('exam_id')->nullable()->constrained();
            $table->foreignId('group_id')->nullable()->constrained();
            $table->string('nama');
            $table->string('npwp');
            $table->string('kegiatan_utama')->nullable();
            $table->string('jenis_wajib_pajak')->nullable();
            $table->string('kategori_wajib_pajak')->nullable();
            $table->string('status_npwp')->nullable();
            $table->dateTime('tanggal_terdaftar')->nullable();
            $table->dateTime('tanggal_aktivasi')->nullable();
            $table->string('status_pengusaha_kena_pajak')->nullable();
            $table->dateTime('tanggal_pengukuhan_pkp')->nullable();
            $table->string('kantor_wilayah_direktorat_jenderal_pajak')->nullable();
            $table->string('kantor_pelayanan_pajak')->nullable();
            $table->string('seksi_pengawasan')->nullable();
            $table->dateTime('tanggal_pembaruan_profil_terakhir')->nullable();
            $table->string('alamat_utama')->nullable();
            $table->string('nomor_handphone')->nullable();
            $table->string('email')->nullable();
            $table->string('kode_klasifikasi_lapangan_usaha')->nullable();
            $table->string('deskripsi_klasifikasi_lapangan_usaha')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('accounts');
    }
};
