<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('assignment_users', function (Blueprint $table) {
            $table->boolean('is_shared_copy')->default(false)->after('is_start');
            $table->foreignId('original_assignment_user_id')->nullable()->constrained('assignment_users')->after('is_shared_copy');
            $table->json('shared_metadata')->nullable()->after('original_assignment_user_id');
        });
    }

    public function down(): void
    {
        Schema::table('assignment_users', function (Blueprint $table) {
            $table->dropForeign(['original_assignment_user_id']);
            $table->dropColumn(['is_shared_copy', 'original_assignment_user_id', 'shared_metadata']);
        });
    }
};
