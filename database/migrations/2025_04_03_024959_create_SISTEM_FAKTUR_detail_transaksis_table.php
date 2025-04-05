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
            $table->string('harga_satuan')->nullable();
            $table->decimal('total_harga')->nullable();
            $table->decimal('pemotongan_harga')->nullable();
            $table->decimal('dpp')->nullable();
            $table->decimal('ppn')->nullable();
            $table->decimal('dpp_lain')->nullable();
            $table->decimal('ppnbm')->nullable();
            $table->decimal('tarif_ppnbm')->nullable();
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
