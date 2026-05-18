<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('role_applications', function (Blueprint $table) {
            $table->integer('ai_score')->nullable()->after('data');
            $table->text('ai_summary')->nullable()->after('ai_score');
            $table->json('ai_issues')->nullable()->after('ai_summary');
            $table->json('ai_recommendations')->nullable()->after('ai_issues');
            $table->json('ai_result')->nullable()->after('ai_recommendations');
            $table->timestamp('submitted_at')->nullable()->after('reviewed_at');
            $table->timestamp('ai_verified_at')->nullable()->after('submitted_at');
        });
    }

    public function down(): void
    {
        Schema::table('role_applications', function (Blueprint $table) {
            $table->dropColumn([
                'ai_score',
                'ai_summary',
                'ai_issues',
                'ai_recommendations',
                'ai_result',
                'submitted_at',
                'ai_verified_at',
            ]);
        });
    }
};
