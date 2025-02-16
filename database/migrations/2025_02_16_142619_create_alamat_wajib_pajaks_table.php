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
            $table->foreignId('account_id')->constrained()->onDelete('cascade');
            $table->foreignId('assignment_users_id')->constrained()->onDelete('cascade');
            $table->string('negara');
            $table->string('jenis_alamat');
            $table->string('detail_alamat');
            $table->string('is_lokasi_disewa');
            $table->string('npwp_pemilik_tempat_sewa');
            $table->string('nama_pemilik_tempat_sewa');
            $table->date('tanggal_mulai_sewa');
            $table->date('tanggal_berakhir_sewa');
            $table->date('tanggal_mulai');
            $table->date('tanggal_berakhir');
            $table->string('kode_kpp');
            $table->string('kpp');
            $table->string('seksi_pengawasan');
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