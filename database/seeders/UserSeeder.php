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
                    'full_name'     => 'Batavia',
                    'business_name' => 'Batik Batavia Nusantara',
                    'phone'         => '081234567890',
                    'address'       => 'Yogyakarta, Indonesia',
                    'bio'           => 'User SnapFit yang memiliki role Pembeli, UMKM, dan Designer yang sudah terverifikasi.',
                ],
            ],
            // Partner UMKM 1
            [
                'name'        => 'Batik Sari Malang',
                'email'       => 'sari@batik.id',
                'password'    => Hash::make('password123'),
                'active_role' => 'umkm',
                'roles'       => ['umkm'],
                'profile'     => [
                    'full_name'     => 'Batik Sari Malang',
                    'business_name' => 'Batik Sari Malang',
                    'phone'         => '081234567891',
                    'address'       => 'Malang, Indonesia',
                    'bio'           => 'UMKM Batik Malang yang berfokus pada batik tulis tradisional Jawa Timur.',
                ],
            ],
            // Partner UMKM 2
            [
                'name'        => 'Rotan Craft Arjosari',
                'email'       => 'arjosari@rotan.id',
                'password'    => Hash::make('password123'),
                'active_role' => 'umkm',
                'roles'       => ['umkm'],
                'profile'     => [
                    'full_name'     => 'Rotan Craft Arjosari',
                    'business_name' => 'Rotan Craft Arjosari',
                    'phone'         => '081234567892',
                    'address'       => 'Malang, Indonesia',
                    'bio'           => 'UMKM kerajinan anyaman rotan dengan desain ramah lingkungan modern.',
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
                    $appData = ['business_name' => $profile['business_name'] ?? $profile['full_name']];
                    if ($roleName === 'designer') {
                        $appData['skills'] = ['UI/UX Design', 'Packaging', 'Branding', 'Product Photography', 'Figma', 'Adobe Photoshop'];
                    }
                    RoleApplication::updateOrCreate(
                        ['user_id' => $user->id, 'requested_role' => $roleName],
                        [
                            'status'         => 'approved',
                            'data'           => $appData,
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

        // Seed data riwayat AI Product Studio untuk user Batavia
        $batavia = User::where('email', 'user@snapfit.id')->first();
        if ($batavia) {
            \App\Models\AiGeneration::where('user_id', $batavia->id)->delete();

            \App\Models\AiGeneration::create([
                'user_id' => $batavia->id,
                'original_image_url' => '/images/products/batik_parang.png',
                'prompt' => 'Ubah latar belakang menjadi studio foto profesional bertema alam Jawa tropis dengan pencahayaan hangat.',
                'generated_images' => [
                    '/images/products/batik_parang.png',
                    '/images/products/batik_fallback.png',
                ],
                'ai_analysis' => "### 🌟 Analisis Strategi Visual & Konten\nAnalisis AI untuk kemeja batik Parang Anda:\n\n#### 1. Rekomendasi Visual\n- **Latar Belakang**: Studio premium bertema alam tropis dengan tanaman *monstera* dan pencahayaan hangat (*warm gold*).\n- **Properti**: Gantungan kayu estetik dan latar belakang kain linen kasar untuk menonjolkan tekstur katun batik yang mewah.\n- **Model**: Pria postur tegap dengan celana bahan slim-fit warna cokelat tua atau hitam.\n\n#### 2. Salinan Pemasaran (Caption)\n> **Gagah Berwibawa dalam Balutan Tradisi** ✨\n> Kemeja Batik Parang Heritage ini melambangkan kekuatan, keteguhan hati, dan ambisi yang tak pernah putus. Dibuat dengan katun prima berkualitas tinggi yang adem dan nyaman digunakan seharian. Cocok untuk pertemuan bisnis maupun acara formal keluarga Anda.\n> \n> *Dapatkan diskon khusus 10% untuk pemesanan minggu ini!*\n\n#### 3. Strategi Katalog & Tag\n- **Target Pasar**: Profesional muda (25-40 tahun), eksekutif, pencinta budaya.\n- **Rekomendasi Tag**: `#batikpremium` `#batikparang` `#localpride` `#indonesianheritage`"
            ]);

            \App\Models\AiGeneration::create([
                'user_id' => $batavia->id,
                'original_image_url' => '/images/products/kebaya_kutubaru.png',
                'prompt' => 'Ubah latar belakang menjadi interior rumah klasik Jawa bernuansa kayu jati dengan pencahayaan natural.',
                'generated_images' => [
                    '/images/products/kebaya_kutubaru.png',
                    '/images/products/fashion_fallback.png',
                ],
                'ai_analysis' => "### 🌟 Analisis Strategi Visual & Konten\nAnalisis AI untuk Kebaya Kutubaru klasik Anda:\n\n#### 1. Rekomendasi Visual\n- **Latar Belakang**: Interior rumah adat Jawa (Joglo) bernuansa kayu jati gelap dengan tanaman hijau untuk memberikan kontras yang menyegarkan.\n- **Properti**: Cermin antik kuningan dan lampu gantung tradisional hangat.\n- **Model**: Wanita dengan tatanan rambut sanggul modern, dipadukan dengan kain jarik batik sogan klasik.\n\n#### 2. Salinan Pemasaran (Caption)\n> **Keanggunan Abadi Kebaya Jawa** 🌸\n> Tampil anggun dan mempesona dengan Kebaya Kutubaru Klasik ini. Dibuat dari brokat katun halus premium berwarna marun mewah yang memeluk lekuk tubuh dengan sempurna namun tetap nyaman dipakai. Mewakili keindahan sejati wanita Nusantara.\n> \n> *Tersedia dalam ukuran S, M, L, dan XL. Pesan sekarang!*\n\n#### 3. Strategi Katalog & Tag\n- **Target Pasar**: Wanita (18-45 tahun), mahasiswa (untuk wisuda), panitia acara pernikahan, pencinta pakaian etnik.\n- **Rekomendasi Tag**: `#kebaya` `#kebayakutubaru` `#wisudalook` `#javanesekebaya` `#lokalbrand`"
            ]);
        }

        $this->command->info('✅ Users & Profiles seeded with Multi-Role System.');
    }
}
