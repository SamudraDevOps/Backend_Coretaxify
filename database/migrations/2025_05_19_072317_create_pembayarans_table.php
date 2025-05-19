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
            $table->string('kode_billing')->nullable();
            $table->string('kapKjs')->nullable();
            $table->string('keterangan')->nullable();
            $table->boolean('is_paid')->nullable();
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
