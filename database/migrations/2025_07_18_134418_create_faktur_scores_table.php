<?php

use App\Support\Enums\FakturTypeEnum;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('faktur_scores', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sistem_id')->constrained()->cascadeOnDelete();
            $table->enum('tipe_faktur', FakturTypeEnum::toArray())->nullable();
            $table->decimal('score', 5, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('faktur_scores');
    }
};
