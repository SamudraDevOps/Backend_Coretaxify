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
        Schema::create('detail_banks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('account_id')->constrained()->onDelete('cascade');
            $table->foreignId('assignment_users_id')->constrained()->onDelete('cascade');
            $table->string('nama_bank');
            $table->string('nomor_rekening_bank');
            $table->string('jenis_rekening_bank');
            $table->string('keterangan');
            $table->date('tanggal_mulai');
            $table->date('tanggal_berakhir');
            $table->boolean('is_rekening_bank_utama');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_banks');
    }
};