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
            $table->longText('canvas_data')->nullable();
            $table->timestamp('canvas_updated_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cocreate_rooms', function (Blueprint $table) {
            $table->dropColumn(['canvas_data', 'canvas_updated_at']);
        });
    }
};
