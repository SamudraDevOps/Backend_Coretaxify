<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('shared_assignment_users', function (Blueprint $table) {
            $table->id();
            $table->foreignId('original_assignment_user_id')->constrained('assignment_users')->onDelete('cascade');
            $table->foreignId('shared_assignment_user_id')->constrained('assignment_users')->onDelete('cascade');
            $table->foreignId('shared_by_user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('shared_to_user_id')->constrained('users')->onDelete('cascade');
            $table->enum('share_type', ['admin_to_dosen', 'psc_to_instructor']);
            $table->json('metadata')->nullable();
            $table->timestamp('shared_at');
            $table->timestamps();

            $table->index(['shared_to_user_id', 'share_type']);
            $table->index(['original_assignment_user_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('shared_assignment_users');
    }
};
