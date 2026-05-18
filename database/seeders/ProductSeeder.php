<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $umkmUsers = User::where('active_role', 'umkm')->get();

        if ($umkmUsers->isEmpty()) {
            $this->command->warn('Tidak ada user UMKM. Jalankan UserSeeder dulu.');
            return;
        }

                        $products = [
            // BATIK & FASHION
            [
                'name'        => 'Batik Parang Heritage',
                'description' => 'Motif parang klasik yang melambangkan kekuatan dan keteguhan.',
                'price'       => 349000,
                'category'    => 'batik',
                'origin'      => 'Yogyakarta, Indonesia',
                'badges'      => ['Batik Tulis', 'AR Ready'],
                'rating'      => 4.8,
                'sold'        => 120,
                'images'      => ['/images/baju_batik_pria.png'],
                'is_published'=> true,
                'umkm_name'   => 'Sanggar Batik Laras'
            ],
            [
                'name'        => 'Batik Tulis Lasem',
                'description' => 'Kain batik pesisir Lasem motif tiga negeri dengan perpaduan warna menawan.',
                'price'       => 850000,
                'category'    => 'batik',
                'origin'      => 'Rembang, Indonesia',
                'badges'      => ['Batik Tulis', 'Premium'],
                'rating'      => 4.9,
                'sold'        => 45,
                'images'      => ['/images/baju_batik_pria.png'],
                'is_published'=> true,
                'umkm_name'   => 'Batik Pusaka Lasem'
            ],
            [
                'name'        => 'Kemeja Tenun Jepara',
                'description' => 'Kemeja pria elegan berbahan tenun troso asli Jepara.',
                'price'       => 250000,
                'category'    => 'fashion',
                'origin'      => 'Jepara, Indonesia',
                'badges'      => ['Handmade', 'AR Ready'],
                'rating'      => 4.7,
                'sold'        => 310,
                'images'      => ['/images/baju_batik_pria.png'],
                'is_published'=> true,
                'umkm_name'   => 'Tenun Troso Indah'
            ],
            [
                'name'        => 'Kain Songket Palembang',
                'description' => 'Songket merah emas khas Palembang ditenun manual benang emas.',
                'price'       => 1250000,
                'category'    => 'fashion',
                'origin'      => 'Palembang, Indonesia',
                'badges'      => ['Premium', 'Limited'],
                'rating'      => 5.0,
                'sold'        => 12,
                'images'      => ['/images/baju_batik_pria.png'],
                'is_published'=> true,
                'umkm_name'   => 'Songket Sriwijaya'
            ],
            [
                'name'        => 'Kebaya Kutu Baru Modern',
                'description' => 'Kebaya tradisional dengan sentuhan potongan modern dan brokat lembut.',
                'price'       => 450000,
                'category'    => 'fashion',
                'origin'      => 'Solo, Indonesia',
                'badges'      => ['AR Ready'],
                'rating'      => 4.6,
                'sold'        => 88,
                'images'      => ['/images/baju_batik_pria.png'],
                'is_published'=> true,
                'umkm_name'   => 'Kebaya Keraton'
            ],
            
            // KERAJINAN & DEKORASI
            [
                'name'        => 'Tenun Ikat Sumba',
                'description' => 'Kain tenun handmade dengan warna alam dan motif tradisional Sumba.',
                'price'       => 520000,
                'category'    => 'kerajinan',
                'origin'      => 'Sumba, Indonesia',
                'badges'      => ['Handmade', 'Limited'],
                'rating'      => 4.9,
                'sold'        => 85,
                'images'      => ['/images/baju_batik_pria.png'],
                'is_published'=> true,
                'umkm_name'   => 'Rumah Tenun Marapu'
            ],
            [
                'name'        => 'Tas Anyaman Bali',
                'description' => 'Tas rotan handmade dengan desain modern untuk gaya kasual.',
                'price'       => 275000,
                'category'    => 'kerajinan',
                'origin'      => 'Bali, Indonesia',
                'badges'      => ['Eco Craft', 'Handmade'],
                'rating'      => 4.7,
                'sold'        => 210,
                'images'      => ['/images/baju_batik_pria.png'],
                'is_published'=> true,
                'umkm_name'   => 'Bali Rattan Studio'
            ],
            [
                'name'        => 'Keramik Kasongan',
                'description' => 'Vas keramik handmade dengan sentuhan natural untuk dekorasi rumah.',
                'price'       => 160000,
                'category'    => 'dekorasi',
                'origin'      => 'Yogyakarta, Indonesia',
                'badges'      => ['Eco Craft'],
                'rating'      => 4.6,
                'sold'        => 95,
                'images'      => ['/images/baju_batik_pria.png'],
                'is_published'=> true,
                'umkm_name'   => 'Kasongan Clay Studio'
            ],
            [
                'name'        => 'Ukiran Kayu Jepara',
                'description' => 'Dekorasi kayu ukir dengan motif floral khas Jepara.',
                'price'       => 310000,
                'category'    => 'dekorasi',
                'origin'      => 'Jepara, Indonesia',
                'badges'      => ['Handmade', 'Premium'],
                'rating'      => 4.9,
                'sold'        => 60,
                'images'      => ['/images/baju_batik_pria.png'],
                'is_published'=> true,
                'umkm_name'   => 'Jepara Woodcraft'
            ],
            [
                'name'        => 'Lampu Gantung Bambu',
                'description' => 'Lampu hias anyaman bambu memberi kesan hangat dan estetik.',
                'price'       => 185000,
                'category'    => 'dekorasi',
                'origin'      => 'Bandung, Indonesia',
                'badges'      => ['Eco Craft', 'Handmade'],
                'rating'      => 4.8,
                'sold'        => 140,
                'images'      => ['/images/baju_batik_pria.png'],
                'is_published'=> true,
                'umkm_name'   => 'Bambu Nusantara'
            ],
            [
                'name'        => 'Karpet Anyaman Enceng Gondok',
                'description' => 'Karpet ramah lingkungan dari enceng gondok asli dengan tekstur alami.',
                'price'       => 350000,
                'category'    => 'dekorasi',
                'origin'      => 'Semarang, Indonesia',
                'badges'      => ['Eco Craft'],
                'rating'      => 4.5,
                'sold'        => 75,
                'images'      => ['/images/baju_batik_pria.png'],
                'is_published'=> true,
                'umkm_name'   => 'Kriya Alam Sejahtera'
            ],

            // AKSESORIS
            [
                'name'        => 'Gelang Perak Celuk',
                'description' => 'Gelang perak ukir khas Celuk dengan detail elegan.',
                'price'       => 189000,
                'category'    => 'aksesoris',
                'origin'      => 'Bali, Indonesia',
                'badges'      => ['Handmade', 'AR Ready'],
                'rating'      => 4.8,
                'sold'        => 150,
                'images'      => ['/images/baju_batik_pria.png'],
                'is_published'=> true,
                'umkm_name'   => 'Celuk Silver Art'
            ],
            [
                'name'        => 'Kalung Mutiara Lombok',
                'description' => 'Kalung mutiara air laut asli Lombok dengan ikatan perak murni.',
                'price'       => 850000,
                'category'    => 'aksesoris',
                'origin'      => 'Lombok, Indonesia',
                'badges'      => ['Premium', 'Limited'],
                'rating'      => 4.9,
                'sold'        => 35,
                'images'      => ['/images/baju_batik_pria.png'],
                'is_published'=> true,
                'umkm_name'   => 'Mutiara Mandalika'
            ],
            [
                'name'        => 'Cincin Kayu Kokka',
                'description' => 'Cincin unik dari bahan kayu kokka asli dengan ukiran minimalis.',
                'price'       => 45000,
                'category'    => 'aksesoris',
                'origin'      => 'Martapura, Indonesia',
                'badges'      => ['Handmade'],
                'rating'      => 4.7,
                'sold'        => 420,
                'images'      => ['/images/baju_batik_pria.png'],
                'is_published'=> true,
                'umkm_name'   => 'Kokka Craft'
            ],
            [
                'name'        => 'Bros Kebaya Alpaka',
                'description' => 'Bros kebaya cantik dari bahan alpaka lapis emas untuk acara formal.',
                'price'       => 125000,
                'category'    => 'aksesoris',
                'origin'      => 'Bali, Indonesia',
                'badges'      => ['AR Ready'],
                'rating'      => 4.8,
                'sold'        => 280,
                'images'      => ['/images/baju_batik_pria.png'],
                'is_published'=> true,
                'umkm_name'   => 'Bali Aksesoris'
            ],
            
            // MAKANAN & MINUMAN LOKAL
            [
                'name'        => 'Kopi Arabika Gayo',
                'description' => 'Kopi Arabika asli dataran tinggi Gayo Aceh dengan aroma khas rempah.',
                'price'       => 85000,
                'category'    => 'minuman',
                'origin'      => 'Aceh, Indonesia',
                'badges'      => ['Organic', 'Premium'],
                'rating'      => 4.9,
                'sold'        => 650,
                'images'      => ['/images/baju_batik_pria.png'],
                'is_published'=> true,
                'umkm_name'   => 'Gayo Coffee Roastery'
            ],
            [
                'name'        => 'Teh Oolong Halimun',
                'description' => 'Teh pegunungan Halimun organik kualitas ekspor.',
                'price'       => 55000,
                'category'    => 'minuman',
                'origin'      => 'Jawa Barat, Indonesia',
                'badges'      => ['Organic'],
                'rating'      => 4.7,
                'sold'        => 310,
                'images'      => ['/images/baju_batik_pria.png'],
                'is_published'=> true,
                'umkm_name'   => 'Pusaka Teh Jabar'
            ],
            [
                'name'        => 'Cokelat Ransiki Papua',
                'description' => 'Dark chocolate 70% asli dari biji kakao premium Ransiki Papua.',
                'price'       => 45000,
                'category'    => 'makanan',
                'origin'      => 'Papua, Indonesia',
                'badges'      => ['Organic', 'Premium'],
                'rating'      => 4.8,
                'sold'        => 480,
                'images'      => ['/images/baju_batik_pria.png'],
                'is_published'=> true,
                'umkm_name'   => 'Papua Cocoa'
            ],
            [
                'name'        => 'Keripik Tempe Sagu',
                'description' => 'Keripik tempe renyah berlapis sagu, oleh-oleh khas Malang.',
                'price'       => 20000,
                'category'    => 'makanan',
                'origin'      => 'Malang, Indonesia',
                'badges'      => ['Handmade'],
                'rating'      => 4.6,
                'sold'        => 1200,
                'images'      => ['/images/baju_batik_pria.png'],
                'is_published'=> true,
                'umkm_name'   => 'Oleh Oleh Arema'
            ],
            [
                'name'        => 'Sambal Roa Manado',
                'description' => 'Sambal botol pedas ikan roa asap khas Sulawesi Utara.',
                'price'       => 35000,
                'category'    => 'makanan',
                'origin'      => 'Manado, Indonesia',
                'badges'      => ['Handmade'],
                'rating'      => 4.8,
                'sold'        => 890,
                'images'      => ['/images/baju_batik_pria.png'],
                'is_published'=> true,
                'umkm_name'   => 'Roa Khas Minahasa'
            ],
        ];

        foreach ($products as $p) {
            // Find or create user for this UMKM
            $user = User::firstOrCreate(
                ['email' => strtolower(str_replace(' ', '', $p['umkm_name'])) . '@umkm.com'],
                [
                    'name' => $p['umkm_name'],
                    'password' => bcrypt('password'),
                    'active_role' => 'umkm'
                ]
            );
            
            // Create or update profile
            \App\Models\Profile::updateOrCreate(
                ['user_id' => $user->id],
                [
                    'full_name' => $p['umkm_name'],
                    'business_name' => $p['umkm_name'],
                    'phone' => '08123456789'
                ]
            );

            $p['user_id'] = $user->id;
            unset($p['umkm_name']);
            Product::create($p);
        }
        
        return; // Skip the rest of the old seeder

        // Generate tambahan 100 produk dummy dengan Faker
        $faker = \Faker\Factory::create('id_ID');
        $categories = ['batik', 'kerajinan', 'aksesoris', 'dekorasi', 'fashion'];

        for ($i = 0; $i < 100; $i++) {
            $products[] = [
                'name'        => $faker->words(3, true) . ' Premium',
                'description' => $faker->paragraph(),
                'price'       => $faker->numberBetween(50000, 1000000),
                'category'    => $faker->randomElement($categories),
                'images'      => ['/images/baju_batik_pria.png'],
                'is_published' => true,
            ];
        }

        $umkmIds = $umkmUsers->pluck('id')->toArray();

        $categoryImages = [
            'batik'     => [
                'https://images.unsplash.com/photo-1620054707166-0b299e5a1b32?q=80&w=800&auto=format&fit=crop',
                'https://images.unsplash.com/photo-1598300042247-083623910543?q=80&w=800&auto=format&fit=crop'
            ],
            'kerajinan' => [
                'https://images.unsplash.com/photo-1590874103328-eac38a683ce7?q=80&w=800&auto=format&fit=crop',
                'https://images.unsplash.com/photo-1610701596007-11502861dcfa?q=80&w=800&auto=format&fit=crop'
            ],
            'aksesoris' => [
                'https://images.unsplash.com/photo-1611591437281-460bfbe1220a?q=80&w=800&auto=format&fit=crop',
                'https://images.unsplash.com/photo-1574015974293-817f0ebebb74?q=80&w=800&auto=format&fit=crop'
            ],
            'dekorasi'  => [
                'https://images.unsplash.com/photo-1600585154340-be6161a56a0c?q=80&w=800&auto=format&fit=crop',
                'https://images.unsplash.com/photo-1513519245088-0e12902e5a38?q=80&w=800&auto=format&fit=crop'
            ],
            'fashion'   => [
                'https://images.unsplash.com/photo-1583417319070-4a69db38a482?q=80&w=800&auto=format&fit=crop',
                'https://images.unsplash.com/photo-1523906354313-059715560931?q=80&w=800&auto=format&fit=crop'
            ],
        ];

        foreach ($products as $index => $data) {
            // Jika image masih dummy baju_batik, ganti dengan gambar random sesuai kategori
            if (isset($data['images'][0]) && $data['images'][0] === '/images/baju_batik_pria.png') {
                $availableImages = $categoryImages[$data['category']] ?? $categoryImages['fashion'];
                $data['images'] = [$availableImages[array_rand($availableImages)]];
            }

            Product::updateOrCreate(
                ['name' => $data['name']],
                array_merge($data, [
                    'user_id' => $umkmIds[$index % count($umkmIds)],
                ])
            );
        }

        $this->command->info('✅ Products seeded (' . count($products) . ' produk) with varied images.');
    }
}
