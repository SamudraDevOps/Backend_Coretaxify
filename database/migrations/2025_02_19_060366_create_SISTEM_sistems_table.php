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
        Schema::create('sistems', function (Blueprint $table) {
            $table->id();
            $table->foreignId('assignment_user_id')->nullable()->constrained();
            $table->foreignId('portal_saya_id')->nullable()->constrained();
            $table->foreignId('sistem_id')->nullable()->constrained();
            // $table->foreignId('spt_id')->nullable()->constrained();
            // $table->foreignId('faktur_id')->nullable()->constrained();
            $table->string('nama_akun');
            $table->string('npwp_akun');
            $table->string('tipe_akun');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sistems');
    }
};