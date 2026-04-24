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
        // 1. Menambahkan kolom role ke tabel users yang sudah ada
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'role')) {
                // Menambahkan role setelah email untuk kerapian
                $table->enum('role', ['umkm', 'desainer', 'pembeli', 'admin'])->default('pembeli')->after('email');
            }
        });

        // 2. Tabel profiles (Profil detail user/UMKM)
        Schema::create('profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('full_name');
            $table->string('business_name')->nullable()->comment('Khusus UMKM Kreator');
            $table->string('avatar_url')->nullable();
            $table->string('phone')->nullable();
            $table->text('address')->nullable();
            $table->text('bio')->nullable();
            $table->timestamps();
        });

        // 3. Tabel products (Produk yang dijual UMKM)
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade')->comment('UMKM pemilik produk');
            $table->string('name');
            $table->text('description')->nullable();
            $table->decimal('price', 12, 2)->index();
            $table->enum('category', [
                'batik', 'fashion', 'kerajinan', 'makanan', 'aksesoris', 'dekorasi', 'minuman'
            ])->index();
            $table->json('images')->nullable()->comment('Untuk menyimpan multiple URL foto');
            $table->string('ar_model_url')->nullable()->comment('URL model 3D untuk AR Try-On');
            $table->boolean('is_published')->default(false)->index();
            $table->integer('views')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });

        // 4. Tabel orders (Pesanan pembeli)
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('buyer_id')->constrained('users')->onDelete('cascade');
            $table->decimal('total_amount', 12, 2);
            $table->enum('status', ['pending', 'paid', 'shipped', 'completed'])->default('pending')->index();
            $table->string('midtrans_order_id')->nullable()->unique();
            $table->timestamps();
            $table->softDeletes();
        });

        // 5. Tabel order_items (Detail barang dalam pesanan)
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained('orders')->onDelete('cascade');
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade');
            $table->integer('quantity');
            $table->decimal('price', 12, 2);
            $table->timestamps();
        });

        // 6. Tabel cocreate_rooms (Ruang kolaborasi Realtime)
        Schema::create('cocreate_rooms', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('creator_id')->constrained('users')->onDelete('cascade');
            $table->text('description')->nullable();
            $table->enum('status', ['active', 'completed'])->default('active')->index();
            $table->timestamps();
        });

        // 7. Tabel room_participants (Peserta dalam ruang kolaborasi)
        Schema::create('room_participants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('room_id')->constrained('cocreate_rooms')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->timestamp('joined_at')->useCurrent();
            $table->timestamps();
        });

        // 8. Tabel ai_generations (Hasil generate foto studio/caption via AI)
        Schema::create('ai_generations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('original_image_url')->nullable();
            $table->json('generated_images')->nullable();
            $table->text('prompt')->nullable();
            $table->timestamps();
        });

        // 9. Tabel notifications (Notifikasi in-app)
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('title');
            $table->text('message');
            $table->boolean('is_read')->default(false)->index();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
        Schema::dropIfExists('ai_generations');
        Schema::dropIfExists('room_participants');
        Schema::dropIfExists('cocreate_rooms');
        Schema::dropIfExists('order_items');
        Schema::dropIfExists('orders');
        Schema::dropIfExists('products');
        Schema::dropIfExists('profiles');
        
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'role')) {
                $table->dropColumn('role');
            }
        });
    }
};
