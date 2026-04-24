<?php

namespace Database\Seeders;

use App\Models\Profile;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            // Admin (untuk demo juri)
            [
                'name'     => 'Admin KreatiLink',
                'email'    => 'admin@kreatilink.id',
                'password' => Hash::make('password'),
                'role'     => 'admin',
                'profile'  => [
                    'full_name'  => 'Admin KreatiLink',
                    'bio'        => 'Administrator platform KreatiLink.',
                ],
            ],
            // UMKM Kreator
            [
                'name'     => 'Sari Batik Malang',
                'email'    => 'sari@umkm.id',
                'password' => Hash::make('password'),
                'role'     => 'umkm',
                'profile'  => [
                    'full_name'     => 'Sari Rahayu',
                    'business_name' => 'Batik Sari Malang',
                    'phone'         => '081234567890',
                    'address'       => 'Jl. Batik No. 12, Malang',
                    'bio'           => 'Pengrajin batik tulis asli Malang dengan motif khas Arema.',
                ],
            ],
            [
                'name'     => 'Kerajinan Tangan Budi',
                'email'    => 'budi@umkm.id',
                'password' => Hash::make('password'),
                'role'     => 'umkm',
                'profile'  => [
                    'full_name'     => 'Budi Santoso',
                    'business_name' => 'Kerajinan Budi Malang',
                    'phone'         => '082345678901',
                    'address'       => 'Jl. Kerajinan No. 7, Malang',
                    'bio'           => 'Pengrajin anyaman rotan dan bambu berkualitas tinggi.',
                ],
            ],
            // Desainer
            [
                'name'     => 'Reza Designer',
                'email'    => 'reza@desainer.id',
                'password' => Hash::make('password'),
                'role'     => 'desainer',
                'profile'  => [
                    'full_name' => 'Reza Firmansyah',
                    'phone'     => '083456789012',
                    'bio'       => 'Desainer grafis dan produk dengan 5 tahun pengalaman di industri kreatif.',
                ],
            ],
            // Pembeli
            [
                'name'     => 'Pembeli Demo',
                'email'    => 'pembeli@demo.id',
                'password' => Hash::make('password'),
                'role'     => 'pembeli',
                'profile'  => [
                    'full_name' => 'Andi Pembeli',
                    'phone'     => '084567890123',
                    'address'   => 'Jl. Raya No. 5, Malang',
                ],
            ],
        ];

        foreach ($users as $data) {
            $profile = $data['profile'];
            unset($data['profile']);

            $user = User::updateOrCreate(['email' => $data['email']], $data);

            Profile::updateOrCreate(
                ['user_id' => $user->id],
                array_merge(['user_id' => $user->id], $profile)
            );
        }

        $this->command->info('✅ Users & Profiles seeded.');
    }
}
