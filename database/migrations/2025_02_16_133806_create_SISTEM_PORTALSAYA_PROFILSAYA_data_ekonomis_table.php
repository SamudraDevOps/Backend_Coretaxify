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
            $table->foreignId('profil_saya_id')->nullable()->constrained();
            $table->string('merek_dagang')->nullable();
            $table->boolean('is_karyuawan')->nullable();
            $table->string('jumlah_karyawan')->nullable();
            $table->string('metode_pembukuan')->nullable();
            $table->string('mata_uang_pembukuan')->nullable();
            $table->string('periode_pembukuan')->nullable();
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