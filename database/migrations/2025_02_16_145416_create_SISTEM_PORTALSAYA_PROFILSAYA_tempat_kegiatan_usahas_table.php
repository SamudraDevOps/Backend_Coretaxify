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
        Schema::create('tempat_kegiatan_usahas', function (Blueprint $table) {
            $table->id();
            $table->string('nitku')->nullable();
            $table->string('jenis_tku')->nullable();
            $table->string('nama_tku')->nullable();
            $table->string('jenis_usaha')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tempat_kegiatan_usahas');
    }
};
