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
        Schema::create('detail_transaksis', function (Blueprint $table) {
            $table->id();
            $table->boolean('is_tambahan')->default(false);
            $table->boolean('is_lama')->default(false);
            $table->boolean('is_retur')->default(false);

            $table->string('tipe')->nullable();
            $table->string('nama')->nullable();
            $table->string('kode')->nullable();
            $table->string('kuantitas')->nullable();
            $table->integer('jumlah_barang_diretur')->nullable();

            $table->decimal('pemotongan_harga',18,2)->nullable();
            $table->decimal('pemotongan_harga_diretur',18,2)->nullable();

            $table->decimal('total_harga',18,2)->nullable();
            $table->decimal('total_harga_diretur',18,2)->nullable();

            $table->string('satuan')->nullable();
            $table->decimal('harga_satuan',18,2)->nullable();
            $table->decimal('dpp',18,2)->nullable();
            $table->decimal('ppn',18,2)->nullable();
            $table->decimal('dpp_lain',18,2)->nullable();
            $table->decimal('ppnbm',18,2)->nullable();
            $table->decimal('ppn_retur',18,2)->nullable();
            $table->decimal('dpp_lain_retur',18,2)->nullable();
            $table->decimal('ppnbm_retur',18,2)->nullable();
            $table->decimal('tarif_ppnbm',18,2)->nullable();

            $table->string('tipe_lama')->nullable();
            $table->string('nama_lama')->nullable();
            $table->string('kode_lama')->nullable();
            $table->string('kuantitas_lama')->nullable();
            $table->string('satuan_lama')->nullable();
            $table->decimal('harga_satuan_lama',18,2)->nullable();
            $table->decimal('total_harga_lama',18,2)->nullable();
            $table->decimal('pemotongan_harga_lama',18,2)->nullable();
            $table->decimal('dpp_lama',18,2)->nullable();
            $table->decimal('ppn_lama',18,2)->nullable();
            $table->decimal('dpp_lain_lama',18,2)->nullable();
            $table->decimal('ppnbm_lama',18,2)->nullable();
            $table->decimal('ppn_retur_lama',18,2)->nullable();
            $table->decimal('dpp_lain_retur_lama',18,2)->nullable();
            $table->decimal('ppnbm_retur_lama',18,2)->nullable();
            $table->decimal('tarif_ppnbm_lama',18,2)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_transaksis');
    }
};
