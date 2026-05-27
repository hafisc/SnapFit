<?php

namespace Database\Seeders;

use App\Models\Profile;
use App\Models\User;
use App\Models\Role;
use App\Models\RoleApplication;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            // Admin (untuk demo juri)
            [
                'name'        => 'Admin SnapFit',
                'email'       => 'admin@snapfit.id',
                'password'    => Hash::make('password123'),
                'active_role' => 'admin',
                'roles'       => ['admin'],
                'profile'     => [
                    'full_name' => 'Admin SnapFit',
                    'bio'       => 'Administrator platform SnapFit.',
                ],
            ],
            // User dengan role Pembeli, UMKM, dan Designer (sudah terverifikasi)
            [
                'name'        => 'Batavia',
                'email'       => 'user@snapfit.id',
                'password'    => Hash::make('password123'),
                'active_role' => 'buyer',
                'roles'       => ['buyer', 'umkm', 'designer'],
                'profile'     => [
                    'full_name'     => 'User SnapFit',
                    'business_name' => 'Batik SnapFit Nusantara',
                    'phone'         => '081234567890',
                    'address'       => 'Yogyakarta, Indonesia',
                    'bio'           => 'User SnapFit yang memiliki role Pembeli, UMKM, dan Designer yang sudah terverifikasi.',
                ],
            ],
        ];

        foreach ($users as $data) {
            $profile = $data['profile'];
            $rolesToAssign = $data['roles'];
            
            unset($data['profile']);
            unset($data['roles']);

            $user = User::updateOrCreate(['email' => $data['email']], $data);

            // Assign roles ke user
            $roleIds = Role::whereIn('name', $rolesToAssign)->pluck('id')->toArray();
            $user->roles()->sync($roleIds);

            // Buat atau update profile
            Profile::updateOrCreate(
                ['user_id' => $user->id],
                array_merge(['user_id' => $user->id], $profile)
            );

            // Jika user memiliki role umkm atau designer, tambahkan/setujui role application nya agar otomatis terverifikasi
            foreach (['umkm', 'designer'] as $roleName) {
                if (in_array($roleName, $rolesToAssign)) {
                    RoleApplication::updateOrCreate(
                        ['user_id' => $user->id, 'requested_role' => $roleName],
                        [
                            'status'         => 'approved',
                            'data'           => ['business_name' => $profile['business_name'] ?? $profile['full_name']],
                            'submitted_at'   => now(),
                            'reviewed_at'    => now(),
                            'ai_score'       => 95,
                            'ai_summary'     => 'Verifikasi otomatis disetujui untuk akun demo juri.',
                            'ai_verified_at' => now(),
                        ]
                    );
                }
            }
        }

        $this->command->info('✅ Users & Profiles seeded with Multi-Role System.');
    }
}
