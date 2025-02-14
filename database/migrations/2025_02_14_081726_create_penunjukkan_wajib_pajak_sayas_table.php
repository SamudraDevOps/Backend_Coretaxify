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
        Schema::create('penunjukkan_wajib_pajak_sayas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('account_id')->constrained()->onDelete('cascade');
            $table->foreignId('assignment_users_id')->constrained()->onDelete('cascade');
            $table->string('status_pemberian_akses_portal');
            $table->string('nama_wajib_pajak');
            $table->string('npwp');
            $table->string('nomor_penunjukkan');
            $table->string('status_penunjukkan');
            $table->date('tanggal_disetujui');
            $table->date('tanggal_ditolak');
            $table->date('tanggal_dicabut');
            $table->date('tanggal_dibatalkan');
            $table->string('alasan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penunjukkan_wajib_pajak_sayas');
    }
};