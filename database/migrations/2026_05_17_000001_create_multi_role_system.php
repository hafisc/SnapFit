<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Tambah kolom active_role ke users table
        Schema::table('users', function (Blueprint $table) {
            // Rename atau backup role lama jika ada
            if (Schema::hasColumn('users', 'role')) {
                $table->dropColumn('role');
            }
            // Tambah active_role (default buyer)
            $table->string('active_role')->default('buyer')->after('email');
        });

        // 2. Buat tabel roles
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique(); // buyer, umkm, designer, admin
            $table->string('display_name')->nullable();
            $table->text('description')->nullable();
            $table->timestamps();
        });

        // 3. Buat tabel pivot role_user (many-to-many)
        Schema::create('role_user', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('role_id')->constrained('roles')->onDelete('cascade');
            $table->timestamps();
            
            // Unique constraint: satu user tidak bisa punya role yang sama 2x
            $table->unique(['user_id', 'role_id']);
        });

        // 4. Seed roles dasar
        DB::table('roles')->insert([
            ['name' => 'buyer', 'display_name' => 'Buyer', 'description' => 'Role pembeli di marketplace'],
            ['name' => 'umkm', 'display_name' => 'UMKM', 'description' => 'Role penjual/UMKM kreator'],
            ['name' => 'designer', 'display_name' => 'Designer', 'description' => 'Role desainer profesional'],
            ['name' => 'admin', 'display_name' => 'Admin', 'description' => 'Role administrator platform'],
        ]);

        // 5. Assign role buyer ke semua users yang sudah ada
        $users = DB::table('users')->get();
        $buyerRole = DB::table('roles')->where('name', 'buyer')->first();
        
        foreach ($users as $user) {
            DB::table('role_user')->insert([
                'user_id' => $user->id,
                'role_id' => $buyerRole->id,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('role_user');
        Schema::dropIfExists('roles');
        
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'active_role')) {
                $table->dropColumn('active_role');
            }
        });
    }
};
