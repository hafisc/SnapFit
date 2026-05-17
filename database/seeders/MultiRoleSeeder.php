<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class MultiRoleSeeder extends Seeder
{
    /**
     * Seed database dengan test data untuk multi-role system.
     * 
     * Membuat:
     * 1. User Buyer biasa (hanya role buyer)
     * 2. User UMKM (role buyer + umkm)
     * 3. User Designer (role buyer + designer)
     * 4. User dengan semua role (buyer + umkm + designer)
     * 5. User Admin
     */
    public function run(): void
    {
        // Get roles
        $buyerRole = Role::where('name', 'buyer')->first();
        $umkmRole = Role::where('name', 'umkm')->first();
        $designerRole = Role::where('name', 'designer')->first();
        $adminRole = Role::where('name', 'admin')->first();

        // 1. User Buyer biasa
        $buyer = User::firstOrCreate(
            ['email' => 'buyer@test.com'],
            [
                'name' => 'Pembeli Test',
                'password' => Hash::make('password123'),
                'active_role' => 'buyer',
            ]
        );
        $buyer->roles()->sync([$buyerRole->id]);
        $this->command->info('✅ Created: Buyer User');

        // 2. User UMKM (buyer + umkm)
        $umkm = User::firstOrCreate(
            ['email' => 'umkm@test.com'],
            [
                'name' => 'UMKM Batik Malang',
                'password' => Hash::make('password123'),
                'active_role' => 'buyer',
            ]
        );
        $umkm->roles()->sync([$buyerRole->id, $umkmRole->id]);
        
        // Update profile dengan data UMKM
        if (!$umkm->profile) {
            $umkm->profile()->create([
                'full_name' => 'UMKM Batik Malang',
                'business_name' => 'Batik Kreasi Nusantara',
            ]);
        } else {
            $umkm->profile()->update([
                'business_name' => 'Batik Kreasi Nusantara',
            ]);
        }
        $this->command->info('✅ Created: UMKM User (buyer + umkm)');

        // 3. User Designer (buyer + designer)
        $designer = User::firstOrCreate(
            ['email' => 'designer@test.com'],
            [
                'name' => 'Designer Profesional',
                'password' => Hash::make('password123'),
                'active_role' => 'buyer',
            ]
        );
        $designer->roles()->sync([$buyerRole->id, $designerRole->id]);
        
        if (!$designer->profile) {
            $designer->profile()->create([
                'full_name' => 'Designer Profesional',
            ]);
        }
        $this->command->info('✅ Created: Designer User (buyer + designer)');

        // 4. User dengan semua role (buyer + umkm + designer)
        $allRoles = User::firstOrCreate(
            ['email' => 'allroles@test.com'],
            [
                'name' => 'Multi Role User',
                'password' => Hash::make('password123'),
                'active_role' => 'buyer',
            ]
        );
        $allRoles->roles()->sync([$buyerRole->id, $umkmRole->id, $designerRole->id]);
        
        if (!$allRoles->profile) {
            $allRoles->profile()->create([
                'full_name' => 'Multi Role User',
                'business_name' => 'Multi Business',
            ]);
        } else {
            $allRoles->profile()->update([
                'business_name' => 'Multi Business',
            ]);
        }
        $this->command->info('✅ Created: Multi-Role User (buyer + umkm + designer)');

        // 5. User Admin
        $admin = User::firstOrCreate(
            ['email' => 'admin@test.com'],
            [
                'name' => 'Admin SnapFit',
                'password' => Hash::make('password123'),
                'active_role' => 'admin',
            ]
        );
        $admin->roles()->sync([$adminRole->id]);
        
        if (!$admin->profile) {
            $admin->profile()->create([
                'full_name' => 'Admin SnapFit',
            ]);
        }
        $this->command->info('✅ Created: Admin User');

        $this->command->info('');
        $this->command->info('===========================================');
        $this->command->info('Multi-Role Test Accounts:');
        $this->command->info('===========================================');
        $this->command->info('🛍️  Buyer:     buyer@test.com / password123');
        $this->command->info('🏪 UMKM:      umkm@test.com / password123');
        $this->command->info('🎨 Designer:  designer@test.com / password123');
        $this->command->info('🔀 All Roles: allroles@test.com / password123');
        $this->command->info('🔐 Admin:     admin@test.com / password123');
        $this->command->info('===========================================');
    }
}
