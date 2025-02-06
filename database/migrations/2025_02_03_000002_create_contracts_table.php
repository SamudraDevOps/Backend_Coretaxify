<?php

use App\Support\Enums\ContractTypeEnum;
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
        Schema::create('contracts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('university_id')->constrained()->onDelete('cascade');
            $table->enum('contract_type', ContractTypeEnum::toArray());
            $table->integer('qty_student');
            $table->date('start_period');
            $table->date('end_period');
            $table->integer('spt');
            $table->integer('bupot');
            $table->integer('faktur');
            $table->string('contract_code')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contracts');
    }
};
