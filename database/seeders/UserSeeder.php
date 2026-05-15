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
                'name'     => 'Admin SnapFit',
                'email'    => 'admin@snapfit.id',
                'password' => Hash::make('password'),
                'role'     => 'admin',
                'profile'  => [
                    'full_name' => 'Admin SnapFit',
                    'bio'       => 'Administrator platform SnapFit.',
                ],
            ],
            // UMKM Kreator 1
            [
                'name'     => 'Raja Batik Malang',
                'email'    => 'raja@gmail.com',
                'password' => Hash::make('password'),
                'role'     => 'umkm',
                'profile'  => [
                    'full_name'     => 'Raja Batik Malang',
                    'business_name' => 'Raja Batik Malang',
                    'phone'         => '081234567890',
                    'address'       => 'Jl. Batik No. 12, Malang',
                    'bio'           => 'Pengrajin batik tulis asli Malang dengan motif khas Arema.',
                ],
            ],
            // Desainer
            [
                'name'     => 'Reza Designer',
                'email'    => 'reza@snapfit.id',
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
                'name'     => 'Andi Pembeli',
                'email'    => 'pembeli@snapfit.id',
                'password' => Hash::make('password'),
                'role'     => 'pembeli',
                'profile'  => [
                    'full_name' => 'Andi Wicaksono',
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
