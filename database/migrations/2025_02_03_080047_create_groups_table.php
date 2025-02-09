<?php

use App\Support\Enums\GroupStatusEnum;
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
        Schema::create('groups', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->integer('qty_student')->nullable();
            $table->date('start_period')->nullable();
            $table->date('end_period')->nullable();
            $table->integer('spt')->nullable();
            $table->integer('bupot')->nullable();
            $table->integer('faktur')->nullable();
            $table->string('class_code')->nullable()->unique();
            $table->enum('status', GroupStatusEnum::toArray());
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('groups');
    }
};
