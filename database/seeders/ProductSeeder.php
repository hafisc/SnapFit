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
            [
                'name'        => 'Batik Parang Heritage',
                'description' => 'Kemeja batik premium pria dengan motif Parang klasik Yogyakarta yang gagah, melambangkan kekuatan, kekuasaan, dan semangat perjuangan yang tak pernah putus.',
                'price'       => 349000,
                'category'    => 'batik',
                'origin'      => 'Yogyakarta',
                'badges'      => ['Batik Tulis', 'AR Ready', 'Handmade'],
                'rating'      => 4.9,
                'sold'        => 120,
                'umkm_name'   => 'Sanggar Batik Laras',
            ],
            [
                'name'        => 'Batik Tulis Lasem',
                'description' => 'Kemeja batik tulis Lasem motif Tiga Negeri dengan perpaduan warna merah darah ayam khas Tionghoa, biru, dan sogan Jawa yang legendaris.',
                'price'       => 850000,
                'category'    => 'batik',
                'origin'      => 'Rembang',
                'badges'      => ['Batik Tulis', 'Premium'],
                'rating'      => 4.9,
                'sold'        => 45,
                'umkm_name'   => 'Batik Pusaka Lasem',
            ],
            [
                'name'        => 'Batik Mega Mendung',
                'description' => 'Kemeja batik bermotif Mega Mendung khas Cirebon dengan warna gradasi biru menawan yang melambangkan ketenangan, kesabaran, dan kelapangan hati.',
                'price'       => 475000,
                'category'    => 'batik',
                'origin'      => 'Cirebon',
                'badges'      => ['Batik Cap', 'AR Ready'],
                'rating'      => 4.7,
                'sold'        => 88,
                'umkm_name'   => 'Batik Trusmi Cirebon',
            ],
            [
                'name'        => 'Batik Sidomukti Solo',
                'description' => 'Kemeja batik tulis motif Sidomukti klasik khas Solo dengan pewarnaan soga alam, melambangkan harapan akan kemakmuran, ketenteraman, dan kebahagiaan hidup.',
                'price'       => 680000,
                'category'    => 'batik',
                'origin'      => 'Solo',
                'badges'      => ['Batik Tulis', 'Premium', 'Limited'],
                'rating'      => 5.0,
                'sold'        => 32,
                'umkm_name'   => 'Batik Keraton Solo',
            ],
            [
                'name'        => 'Batik Kawung Kencana',
                'description' => 'Kemeja batik motif Kawung yang merepresentasikan buah aren simetris sebagai simbol kesucian, keadilan, kebersihan hati, dan umur panjang.',
                'price'       => 520000,
                'category'    => 'batik',
                'origin'      => 'Yogyakarta',
                'badges'      => ['Batik Tulis', 'Handmade'],
                'rating'      => 4.8,
                'sold'        => 67,
                'umkm_name'   => 'Omah Batik Kawung',
            ],
            [
                'name'        => 'Kemeja Batik Slim Fit Modern',
                'description' => 'Kemeja batik pria bergaya kasual kontemporer dengan potongan slim fit modern dan motif abstrak dinamis yang elegan untuk acara semi-formal.',
                'price'       => 285000,
                'category'    => 'fashion',
                'origin'      => 'Bandung',
                'badges'      => ['Modern Fit', 'AR Ready'],
                'rating'      => 4.7,
                'sold'        => 520,
                'umkm_name'   => 'Batik Urban Studio',
            ],
            [
                'name'        => 'Kain Tenun Ikat Sumba',
                'description' => 'Kain tenun ikat tradisional asli Sumba Timur buatan tangan pengrajin lokal dengan pewarna alami dari akar mengkudu dan kayu indigo.',
                'price'       => 520000,
                'category'    => 'kerajinan',
                'origin'      => 'Sumba',
                'badges'      => ['Handmade', 'Eco Craft'],
                'rating'      => 4.9,
                'sold'        => 85,
                'umkm_name'   => 'Rumah Tenun Marapu',
            ],
            [
                'name'        => 'Kain Songket Palembang Emas',
                'description' => 'Kain songket sutra merah Palembang yang ditenun menggunakan benang emas murni dengan motif bunga melati berkilau, melambangkan keagungan Sriwijaya.',
                'price'       => 1250000,
                'category'    => 'kerajinan',
                'origin'      => 'Palembang',
                'badges'      => ['Premium', 'Limited'],
                'rating'      => 5.0,
                'sold'        => 12,
                'umkm_name'   => 'Songket Sriwijaya',
            ],
            [
                'name'        => 'Gelang Perak Motif Batik Celuk',
                'description' => 'Gelang perak bakar sterling 925 dengan detail ukiran motif flora khas desa Celuk Bali, dipahat tangan oleh seniman perak lokal.',
                'price'       => 189000,
                'category'    => 'aksesoris',
                'origin'      => 'Bali',
                'badges'      => ['Handmade', 'Silver 925'],
                'rating'      => 4.8,
                'sold'        => 150,
                'umkm_name'   => 'Celuk Silver Art',
            ],
            [
                'name'        => 'Bros Kebaya Batik Alpaka',
                'description' => 'Bros kebaya cantik dari logam alpaka lapis emas kuning 18 karat dengan aksen motif batik mini yang cocok disandingkan dengan kebaya kutubaru Anda.',
                'price'       => 125000,
                'category'    => 'aksesoris',
                'origin'      => 'Yogyakarta',
                'badges'      => ['AR Ready', 'Handmade'],
                'rating'      => 4.8,
                'sold'        => 280,
                'umkm_name'   => 'Jogja Aksesoris Craft',
            ],
            [
                'name'        => 'Bantal Sofa Batik Parang',
                'description' => 'Sarung bantal sofa dekoratif bermotif batik Parang Yogyakarta dari kain katun prima tebal untuk mempercantik dan memberi sentuhan etnik pada ruang tamu Anda.',
                'price'       => 95000,
                'category'    => 'dekorasi',
                'origin'      => 'Solo',
                'badges'      => ['Eco Craft', 'Best Seller'],
                'rating'      => 4.5,
                'sold'        => 230,
                'umkm_name'   => 'Batik Home Living',
            ],
            [
                'name'        => 'Runner Meja Batik Mega Mendung',
                'description' => 'Table runner / taplak meja panjang bermotif batik Mega Mendung biru dari katun premium berukuran 150x40 cm untuk memperindah estetika meja makan kayu Anda.',
                'price'       => 135000,
                'category'    => 'dekorasi',
                'origin'      => 'Cirebon',
                'badges'      => ['Eco Craft'],
                'rating'      => 4.6,
                'sold'        => 158,
                'umkm_name'   => 'Cirebon Home Decor',
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
