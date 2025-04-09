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
        Schema::create('data_ekonomis', function (Blueprint $table) {
            $table->id();
            $table->string('sumber_penghasilan')->nullable();
            $table->string('izin_usaha')->nullable();
            $table->date('tanggal_izin_usaha')->nullable();
            $table->string('tempat_kerja')->nullable();
            $table->string('penghasilan_per_bulan')->nullable();
            $table->date('tanggal_mulai')->nullable();
            $table->string('jumlah_karyawan')->nullable();
            $table->string('deskrisi_kegiatan')->nullable();
            $table->string('periode_pembukuan')->nullable();
            $table->string('peredaran_bruto')->nullable();
            $table->string('metode_pembukuan')->nullable();
            $table->string('mata_uang_pembukuan')->nullable();
            $table->string('merek_dagang')->nullable();
            $table->string('omset_per_tahun')->nullable();
            $table->string('jumlah_peredaran_bruto')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_ekonomis');
    }
};
