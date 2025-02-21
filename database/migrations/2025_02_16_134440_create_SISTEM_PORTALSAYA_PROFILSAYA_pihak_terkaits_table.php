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
        Schema::create('pihak_terkaits', function (Blueprint $table) {
            $table->id();
            $table->foreignId('profil_saya_id')->nullable()->constrained();
            $table->string('tipe_pihak_terkait')->nullable();
            $table->boolean('is_pic')->nullable();
            $table->string('jenis_orang_terkait')->nullable();
            $table->string('npwp')->nullable();
            $table->string('nomor_paspor')->nullable();
            $table->string('kewarganegaraan')->nullable();
            $table->string('negara_asal')->nullable();
            $table->string('email')->nullable();
            $table->string('nomor_handphone')->nullable();
            $table->date('tanggal_mulai')->nullable();
            $table->date('tanggal_berakhir')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pihak_terkaits');
    }
};