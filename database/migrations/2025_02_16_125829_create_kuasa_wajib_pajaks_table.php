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
            $table->foreignId('account_id')->constrained()->onDelete('cascade');
            $table->foreignId('assignment_users_id')->constrained()->onDelete('cascade');
            $table->boolean('is_wajib_pajak');
            $table->string('id_penunjukkan_perwakilan');
            $table->string('npwp_perwakilan');
            $table->string('nama_wakil');
            $table->string('jenis_perwakilan');
            $table->string('nomor_dokumen_penunjukkan_perwakilan');
            $table->string('izin_perwakilan');
            $table->string('status_penunjukkan');
            $table->date('tanggal_disetujui');
            $table->date('tanggal_ditolak');
            $table->date('tanggal_dicabut');
            $table->date('tanggal_dibatalkan');
            $table->date('tanggal_tertunda');
            $table->string('alasan');
            $table->date('tanggal_mulai');
            $table->date('tanggal_berakhir');
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