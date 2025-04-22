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
            $table->foreignId('akun_pengirim_id')->references('id')->on('sistems')->nulllable();
            $table->foreignId('akun_penerima_id')->references('id')->on('sistems')->nulllable();
            $table->boolean('is_draft')->nulllable();
            $table->boolean('is_spt')->nulllable();
            $table->boolean('is_kredit')->nulllable();
            $table->boolean('is_akun_tambahan')->nulllable();
            $table->string('nomor_faktur_pajak')->unique()->nulllable();
            $table->string('masa_pajak')->nulllable();
            $table->string('tahun')->nulllable();
            $table->string('status_faktur')->nulllable();
            $table->string('esign_status')->nulllable();
            $table->decimal('dpp',18,2)->nullable();
            $table->decimal('ppn',18,2)->nullable();
            $table->decimal('dpp_lain',18,2)->nullable();
            $table->decimal('ppnbm',18,2)->nullable();
            $table->string('penandatangan')->nulllable();
            $table->string('referensi')->nulllable();
            $table->string('kode_transaksi')->nulllable();
            $table->string('informasi_tambahan')->nulllable();
            $table->string('cap_fasilitas')->nulllable();
            $table->boolean('dilaporkan_oleh_penjual')->nulllable();
            $table->boolean('dilaporkan_oleh_pemungut_ppn')->nulllable();
            $table->date('tanggal_faktur_pajak')->nulllable();
            $table->timestamps();
        });

        Schema::table('detail_transaksis', function (Blueprint $table) {
            $table->foreignId('faktur_id')->constrained()->onDelete('cascade');
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
