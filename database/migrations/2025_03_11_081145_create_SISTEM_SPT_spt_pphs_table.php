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
        Schema::create('spt_pphs', function (Blueprint $table) {
            $table->id();
            $table->decimal('cl_bp1_1',18,2)->nullable();
            $table->decimal('cl_bp1_2',18,2)->nullable();
            $table->decimal('cl_bp1_3',18,2)->nullable();
            $table->decimal('cl_bp1_4',18,2)->nullable();
            $table->decimal('cl_bp1_5',18,2)->nullable();
            $table->decimal('cl_bp1_6',18,2)->nullable();
            $table->decimal('cl_bp1_7',18,2)->nullable();
            $table->decimal('cl_bp1_8',18,2)->nullable();
            $table->decimal('cl_bp2_1',18,2)->nullable();
            $table->decimal('cl_bp2_2',18,2)->nullable();
            $table->decimal('cl_bp2_3',18,2)->nullable();
            $table->decimal('cl_bp2_4',18,2)->nullable();
            $table->decimal('cl_bp2_5',18,2)->nullable();
            $table->decimal('cl_bp2_6',18,2)->nullable();
            $table->decimal('cl_bp2_7',18,2)->nullable();
            $table->decimal('cl_bp2_8',18,2)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('spt_pphs');
    }
};