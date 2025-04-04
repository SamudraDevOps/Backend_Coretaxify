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
        Schema::create('fakturs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('akun_pengirim')->references('id')->on('sistems');
            $table->foreignId('akun_penerima')->references('id')->on('sistems');
            $table->string('nomor_faktur_pajak')->unique();
            $table->string('masa_pajak');
            $table->string('tahun');
            $table->string('status_faktur');
            $table->string('esign_status');
            $table->string('harga_jual');
            $table->string('dpp_nilai_lain');
            $table->string('ppn');
            $table->string('ppnbm');
            $table->string('penandatangan');
            $table->string('referensi');
            $table->boolean('dilaporkan_oleh_penjual');
            $table->boolean('dilaporkan_oleh_pemungut_ppn');
            $table->date('tanggal_faktur_pajak');
            $table->foreignId('kode_transaksi_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fakturs');
    }
};