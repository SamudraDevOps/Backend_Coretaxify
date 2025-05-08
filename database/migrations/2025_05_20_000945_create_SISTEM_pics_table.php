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
        Schema::create('pics', function (Blueprint $table) {
            $table->id();
            $table->foreignId('akun_op_id')->references('id')->on('sistems');
            $table->foreignId('akun_badan_id')->references('id')->on('sistems');
            $table->foreignId('assignment_user_id')->references('id')->on('assignment_users');
            $table->timestamps();
        });

        Schema::table('spts', function (Blueprint $table) {
            $table->foreignId('pic_id')->nullable()->constrained()->onDelete('cascade');
        });

        Schema::table('fakturs', function (Blueprint $table) {
            $table->foreignId('pic_id')->nullable()->constrained()->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pics');
    }
};
