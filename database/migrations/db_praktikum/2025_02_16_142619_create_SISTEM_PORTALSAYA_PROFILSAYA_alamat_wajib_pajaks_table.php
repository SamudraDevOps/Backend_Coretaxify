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
        Schema::create('alamat_wajib_pajaks', function (Blueprint $table) {
            $table->id();
            $table->string('negara')->nullable();
            $table->string('jenis_alamat')->nullable();
            $table->string('detail_alamat')->nullable();
            $table->string('is_lokasi_disewa')->nullable();
            $table->string('npwp_pemilik_tempat_sewa')->nullable();
            $table->string('nama_pemilik_tempat_sewa')->nullable();
            $table->date('tanggal_mulai_sewa')->nullable();
            $table->date('tanggal_berakhir_sewa')->nullable();
            $table->date('tanggal_mulai')->nullable();
            $table->date('tanggal_berakhir')->nullable();
            $table->string('kode_kpp')->nullable();
            $table->string('kpp')->nullable();
            $table->string('seksi_pengawasan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('alamat_wajib_pajaks');
    }
};