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
        Schema::create('sistem_tambahans', function (Blueprint $table) {
            $table->id();
            $table->string('nama_akun')->nullable();
            $table->string('npwp_akun')->nullable();
            $table->string('tipe_akun')->nullable();
            $table->string('alamat_utama_akun')->nullable();
            $table->string('email_akun')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sistem_tambahans');
    }
};
