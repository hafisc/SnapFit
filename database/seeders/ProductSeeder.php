<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $umkmUsers = User::whereHas('roles', function($q) { $q->where('name', 'umkm'); })->get();

        if ($umkmUsers->isEmpty()) {
            $this->command->warn('Tidak ada user UMKM. Jalankan UserSeeder dulu.');
            return;
        }

        // Clear old products
        \DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Product::truncate();
        \DB::statement('SET FOREIGN_KEY_CHECKS=1;');


        $products = [
            // ═══ BATIK (15 produk) ═══
            [
                'name'        => 'Batik Parang Heritage',
                'description' => 'Kemeja batik motif parang klasik yang melambangkan kekuatan dan keteguhan. Dibuat dengan teknik tulis tangan oleh pengrajin maestro Yogyakarta.',
                'price'       => 349000,
                'category'    => 'batik',
                'origin'      => 'Yogyakarta',
                'badges'      => ['Batik Tulis', 'AR Ready'],
                'rating'      => 4.9,
                'sold'        => 120,
                'umkm_name'   => 'Sanggar Batik Laras',
            ],
        ];

        $demoUser = User::where('email', 'user@snapfit.id')->first();
        $umkmRole = \App\Models\Role::where('name', 'umkm')->first();

        foreach ($products as $index => $p) {
            $umkmName = $p['umkm_name'];
            unset($p['umkm_name']);

            if ($demoUser && $umkmName === 'Sanggar Batik Laras') {
                $user = $demoUser;
            } else {
                // Find or create user for this UMKM
                $user = User::firstOrCreate(
                    ['email' => strtolower(str_replace([' ', '.', ',', '\''], '', $umkmName)) . '@umkm.com'],
                    [
                        'name' => $umkmName,
                        'password' => bcrypt('password'),
                        'active_role' => 'umkm'
                    ]
                );

                if ($umkmRole) {
                    $user->roles()->syncWithoutDetaching([$umkmRole->id]);
                }

                // Create or update profile
                \App\Models\Profile::updateOrCreate(
                    ['user_id' => $user->id],
                    [
                        'full_name' => $umkmName,
                        'business_name' => $umkmName,
                        'phone' => '08' . rand(1000000000, 9999999999)
                    ]
                );
            }

            // Assign specific images to key products, otherwise use category-wide fallbacks
            $imageName = null;
            $pName = $p['name'] ?? '';
            $pCat = $p['category'] ?? '';

            if ($pName === 'Batik Parang Heritage') {
                $imageName = 'batik_parang.png';
            } elseif ($pName === 'Batik Tulis Lasem') {
                $imageName = 'batik_lasem.png';
            } elseif ($pName === 'Batik Mega Mendung') {
                $imageName = 'batik_megamendung.png';
            } elseif ($pName === 'Batik Sidomukti Solo') {
                $imageName = 'batik_sidomukti.png';
            } elseif ($pName === 'Batik Kawung Kencana') {
                $imageName = 'batik_kawung.png';
            } elseif ($pName === 'Kain Tenun Ikat Sumba') {
                $imageName = 'tenun_ikat.png';
            } elseif ($pName === 'Kain Songket Palembang Emas') {
                $imageName = 'songket_palembang.png';
            } elseif ($pName === 'Gelang Perak Motif Batik Celuk') {
                $imageName = 'gelang_perak.png';
            } elseif ($pName === 'Bros Kebaya Batik Alpaka') {
                $imageName = 'bros_kebaya.png';
            } elseif ($pName === 'Bantal Sofa Batik Parang') {
                $imageName = 'bantal_batik.png';
            } elseif ($pName === 'Runner Meja Batik Mega Mendung') {
                $imageName = 'runner_meja.png';
            } else {
                // Category-wise fallback
                if ($pCat === 'batik') {
                    $imageName = 'batik_fallback.png';
                } elseif ($pCat === 'fashion') {
                    $imageName = 'fashion_fallback.png';
                } elseif ($pCat === 'kerajinan') {
                    $imageName = 'kerajinan_fallback.png';
                } elseif ($pCat === 'aksesoris') {
                    $imageName = 'aksesoris_fallback.png';
                } elseif ($pCat === 'dekorasi') {
                    $imageName = 'dekorasi_fallback.png';
                } else {
                    $imageName = 'batik_fallback.png';
                }
            }

            $productImage = ["/images/products/{$imageName}"];

            Product::create(array_merge($p, [
                'user_id' => $user->id,
                'images'  => $productImage,
                'is_published' => true,
            ]));
        }

        $this->command->info('✅ Products seeded (' . count($products) . ' produk batik & fashion Nusantara)');
    }
}
