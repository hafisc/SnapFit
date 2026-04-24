<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade');
            $table->unsignedTinyInteger('rating'); // 1 - 5
            $table->text('comment')->nullable();
            $table->timestamps();

            // Satu user hanya bisa review satu produk sekali
            $table->unique(['user_id', 'product_id']);

            // Index untuk agregasi rating
            $table->index(['product_id', 'rating']);
        });

        // Tambah kolom avg_rating & reviews_count ke products untuk performa
        Schema::table('products', function (Blueprint $table) {
            $table->decimal('avg_rating', 3, 2)->default(0)->after('views');
            $table->unsignedInteger('reviews_count')->default(0)->after('avg_rating');
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['avg_rating', 'reviews_count']);
        });

        Schema::dropIfExists('reviews');
    }
};
