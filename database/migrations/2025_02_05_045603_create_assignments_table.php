<?php

use App\Models\Assignment;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Support\Enums\AssignmentTypeEnum;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('assignments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('group_id')->nullable()->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained();
            $table->foreignId('task_id')->nullable()->constrained()->onDelete('cascade');
            $table->enum('tipe', AssignmentTypeEnum::toArray());
            $table->string('name');
            $table->string('assignment_code')->nullable()->unique();
            $table->dateTime('start_period')->nullable();
            $table->dateTime('end_period')->nullable();
            $table->integer('duration')->nullable();
            $table->string('supporting_file')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assignments');
    }
};
