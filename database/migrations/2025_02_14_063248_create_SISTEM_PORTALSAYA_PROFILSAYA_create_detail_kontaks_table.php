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
        Schema::create('detail_kontaks', function (Blueprint $table) {
            $table->id();
            $table->string('jenis_kontak')->nullable();
            $table->string('nomor_telpon')->nullable();
            $table->string('nomor_handphone')->nullable();
            $table->string('nomor_faksimile')->nullable();
            $table->string('alamat_email')->nullable();
            $table->string('alamat_situs_wajib')->nullable();
            $table->string('keterangan')->nullable();
            $table->string('tanggal_mulai')->nullable();
            $table->string('tanggal_berakhir')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_kontaks');
    }
};