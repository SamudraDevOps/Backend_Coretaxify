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
        Schema::create('unit_pajak_keluargas', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('nik_anggota_keluarga');
            $table->string('jenis_kelamin');
            $table->string('tempat_lahir');
            $table->string('nomor_kartu_keluarga');
            $table->string('nama_anggota_keluarga');
            $table->string('status_hubungan_keluarga');
            $table->string('pekerjaan');
            $table->string('status_unit_perpajakan');
            $table->string('status_ptkp');
            $table->date('tanggal_lahir');
            $table->date('tanggal_mulai');
            $table->date('tanggal_berakhir');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('unit_pajak_keluargas');
    }
};
