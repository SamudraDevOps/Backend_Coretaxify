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
            $table->string('tipe')->nullable();
            $table->string('nama')->nullable();
            $table->string('kode')->nullable();
            $table->string('kuantitas')->nullable();
            $table->string('satuan')->nullable();
            $table->decimal('harga_satuan',18,2)->nullable();
            $table->decimal('total_harga',18,2)->nullable();
            $table->decimal('pemotongan_harga',18,2)->nullable();
            $table->decimal('dpp',18,2)->nullable();
            $table->decimal('ppn',18,2)->nullable();
            $table->decimal('dpp_lain',18,2)->nullable();
            $table->decimal('ppnbm',18,2)->nullable();
            $table->decimal('tarif_ppnbm',18,2)->nullable();
            $table->timestamps();
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
