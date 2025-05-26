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
        Schema::create('pembayarans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sistem_id')->nullable()->constrained();
            $table->foreignId('pic_id')->nullable()->constrained()->onDelete('cascade');
            $table->foreignId('kap_kjs_id')->nullable()->constrained();
            $table->string('kode_billing')->nullable();
            $table->string('masa_bulan')->nullable();
            $table->string('masa_tahun')->nullable();
            $table->string('keterangan')->nullable();
            $table->string('ntpn')->nullable();
            $table->date('masa_aktif')->nullable();
            $table->boolean('is_paid')->nullable()->default(false);
            $table->decimal('nilai',18,2)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembayarans');
    }
};
