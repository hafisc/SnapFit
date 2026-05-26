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
        Schema::table('cocreate_rooms', function (Blueprint $table) {
            $table->foreignId('invited_user_id')->nullable()->after('creator_id')->constrained('users')->onDelete('cascade');
            $table->string('status', 50)->default('pending')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cocreate_rooms', function (Blueprint $table) {
            if (Schema::hasColumn('cocreate_rooms', 'invited_user_id')) {
                $table->dropForeign(['invited_user_id']);
                $table->dropColumn('invited_user_id');
            }
            $table->string('status', 50)->default('active')->change();
        });
    }
};
