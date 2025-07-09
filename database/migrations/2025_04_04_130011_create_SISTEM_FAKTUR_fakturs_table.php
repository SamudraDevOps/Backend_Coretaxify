<?php

use Illuminate\Support\Facades\Schema;
use App\Support\Enums\FakturStatusEnum;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('fakturs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('badan_id')->nullable()->references('id')->on('sistems');
            $table->foreignId('pic_id')->nullable()->references('id')->on('sistems');
            $table->foreignId('akun_pengirim_id')->nullable()->references('id')->on('sistems');
            $table->foreignId('akun_penerima_id')->nullable()->references('id')->on('sistems');
            $table->boolean('is_draft')->nullable();
            $table->boolean('is_kredit')->default(false);
            $table->boolean('is_akun_tambahan')->nullable();
            $table->boolean('is_retur')->default(false);
            $table->enum('status', FakturStatusEnum::toArray())->nullable();
            $table->string('nomor_faktur_pajak')->nullable();
            $table->string('masa_pajak')->nullable();
            $table->string('tahun')->nullable();
            $table->string('esign_status')->nullable();
            $table->string('nomor_retur')->nullable();
            $table->decimal('dpp',18,2)->nullable();
            $table->decimal('ppn',18,2)->nullable();
            $table->decimal('ppnbm',18,2)->nullable();
            $table->decimal('dpp_lain',18,2)->nullable();
            $table->decimal('ppn_retur',18,2)->nullable();
            $table->decimal('dpp_lain_retur',18,2)->nullable();
            $table->decimal('ppnbm_retur',18,2)->nullable();
            $table->string('penandatangan')->nullable();
            $table->string('referensi')->nullable();
            $table->string('kode_transaksi')->nullable();
            $table->string('informasi_tambahan')->nullable();
            $table->string('cap_fasilitas')->nullable();
            $table->boolean('dilaporkan_oleh_penjual')->nullable();
            $table->boolean('dilaporkan_oleh_pemungut_ppn')->nullable();
            $table->date('tanggal_faktur_pajak')->nullable();
            $table->date('tanggal_retur')->nullable();
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
