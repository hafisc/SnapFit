<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\User;
use App\Models\Review;
use App\Models\Profile;
use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $umkmUsers = User::whereHas('roles', function($q) { $q->where('name', 'umkm'); })->get();

        if ($umkmUsers->isEmpty()) {
            $this->command->warn('Tidak ada user UMKM. Jalankan UserSeeder dulu.');
            return;
        }

        // Clear old products, reviews, orders, and order_items
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Product::truncate();
        Review::truncate();
        \App\Models\Order::truncate();
        \App\Models\OrderItem::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // 1. Seed Mock Buyer Users for Reviews
        $buyerRole = Role::where('name', 'buyer')->first();
        $buyers = [];
        $buyersData = [
            ['name' => 'Budi Santoso', 'email' => 'budi@gmail.com'],
            ['name' => 'Ani Wijaya', 'email' => 'ani@gmail.com'],
            ['name' => 'Joko Susilo', 'email' => 'joko@gmail.com'],
            ['name' => 'Siti Aminah', 'email' => 'siti@gmail.com'],
            ['name' => 'Rian Hidayat', 'email' => 'rian@gmail.com'],
        ];

        foreach ($buyersData as $data) {
            $u = User::firstOrCreate(
                ['email' => $data['email']],
                [
                    'name' => $data['name'],
                    'password' => bcrypt('password123'),
                    'active_role' => 'buyer'
                ]
            );
            if ($buyerRole) {
                $u->roles()->syncWithoutDetaching([$buyerRole->id]);
            }
            // Ensure profile exists
            Profile::firstOrCreate(
                ['user_id' => $u->id],
                [
                    'full_name' => $data['name'],
                    'phone' => '08' . rand(1000000000, 9999999999),
                    'address' => 'Jl. Merdeka No. ' . rand(1, 100) . ', Malang, Jawa Timur'
                ]
            );
            $buyers[] = $u;
        }

        // Review templates based on product categories
        $reviewsPool = [
            'batik' => [
                ['rating' => 5, 'comment' => 'Sangat puas! Motif batik Parang-nya rapi sekali dan bahannya adem untuk dipakai formal.'],
                ['rating' => 5, 'comment' => 'Kualitas premium, jahitannya sangat kuat dan rapi. Pengiriman cepat.'],
                ['rating' => 5, 'comment' => 'Batiknya sangat elegan, warnanya pas tidak norak. Recommended!'],
                ['rating' => 4, 'comment' => 'Bahan bagus dan motif cantik, tapi pengiriman agak lambat sedikit.'],
                ['rating' => 4, 'comment' => 'Kemeja pas di badan, sayangnya varian warna kurang banyak. Tapi overall mantap.'],
            ],
            'fashion' => [
                ['rating' => 5, 'comment' => 'Potongan slim fit-nya pas sekali di badan saya. Terlihat sangat modern dan stylish.'],
                ['rating' => 5, 'comment' => 'Jahitan sangat presisi, bahannya halus tidak gampang kusut. Cocok untuk ngantor.'],
                ['rating' => 4, 'comment' => 'Sangat bagus, warna sesuai dengan gambar. Pengemasan sangat rapi.'],
            ],
            'kerajinan' => [
                ['rating' => 5, 'comment' => 'Kain tenun ikatnya luar biasa indah! Pewarnaan alaminya terasa sangat estetik.'],
                ['rating' => 5, 'comment' => 'Pahatannya sangat detail dan pengerjaan yang halus. Benar-benar karya seni terbaik.'],
                ['rating' => 5, 'comment' => 'Sangat puas dengan kualitas kerajinan tangan ini, pengemasan sangat aman.'],
                ['rating' => 4, 'comment' => 'Sangat berseni, tetapi warnanya sedikit berbeda dari foto karena pencahayaan.'],
                ['rating' => 4, 'comment' => 'Kainnya bagus, tapi agak kaku sedikit di awal. Setelah dicuci baru terasa lembut.'],
            ],
            'dekorasi' => [
                ['rating' => 5, 'comment' => 'Bantal sofa batiknya menambah kehangatan ruang tamu kami. Estetis sekali.'],
                ['rating' => 5, 'comment' => 'Runner mejanya sangat mewah, motifnya lurus dan rapi. Suka sekali dengan paduan warnanya.'],
                ['rating' => 5, 'comment' => 'Kualitas kain tebal, awet, dan motif batik Mega Mendung-nya sangat menyala.'],
                ['rating' => 4, 'comment' => 'Sangat mempercantik ruangan, tapi ukurannya sedikit lebih pendek dari meja saya.'],
            ],
            'aksesoris' => [
                ['rating' => 5, 'comment' => 'Gelang peraknya cantik sekali! Ukirannya sangat detail dan tidak gampang kusam.'],
                ['rating' => 5, 'comment' => 'Brosnya sangat berkilau dan mewah, pas disandingkan dengan kebaya kutubaru.'],
                ['rating' => 5, 'comment' => 'Pengerjaan handmade yang sangat presisi. Seniman peraknya juara!'],
                ['rating' => 4, 'comment' => 'Cantik sekali, tapi ukuran gelangnya agak sedikit ketat di tangan saya.'],
            ],
        ];

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
                'ar_model_url'=> null,
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
                'ar_model_url'=> null,
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
                'ar_model_url'=> null,
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
                'ar_model_url'=> null,
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
                'ar_model_url'=> null,
            ],
            [
                'name'        => 'Kemeja Batik Slim Fit Modern',
                'description' => 'Kemeja batik pria bergaya kasual kontemporer dengan potongan slim fit modern and motif abstrak dinamis yang elegan untuk acara semi-formal.',
                'price'       => 285000,
                'category'    => 'fashion',
                'origin'      => 'Bandung',
                'badges'      => ['Modern Fit', 'AR Ready'],
                'rating'      => 4.7,
                'sold'        => 520,
                'umkm_name'   => 'Batik Urban Studio',
                'ar_model_url'=> null,
            ],
            [
                'name'        => 'Kain Tenun Ikat Sumba',
                'description' => 'Kain tenun ikat tradisional asli Sumba Timur buatan tangan pengrajin lokal dengan pewarna alami dari akar mengkudu dan kayu indigo.',
                'price'       => 520000,
                'category'    => 'kerajinan',
                'origin'      => 'Sumba',
                'badges'      => ['Handmade', 'Eco Craft', '3D Detail'],
                'rating'      => 4.9,
                'sold'        => 85,
                'umkm_name'   => 'Rumah Tenun Marapu',
                'ar_model_url'=> 'https://modelviewer.dev/shared-assets/models/glTF-Sample-Assets/Models/Lantern/glTF-Binary/Lantern.glb',
            ],
            [
                'name'        => 'Kain Songket Palembang Emas',
                'description' => 'Kain songket sutra merah Palembang yang ditenun menggunakan benang emas murni dengan motif bunga melati berkilau, melambangkan keagungan Sriwijaya.',
                'price'       => 1250000,
                'category'    => 'kerajinan',
                'origin'      => 'Palembang',
                'badges'      => ['Premium', 'Limited', '3D Detail'],
                'rating'      => 5.0,
                'sold'        => 12,
                'umkm_name'   => 'Songket Sriwijaya',
                'ar_model_url'=> 'https://modelviewer.dev/shared-assets/models/glTF-Sample-Assets/Models/Lantern/glTF-Binary/Lantern.glb',
            ],
            [
                'name'        => 'Gelang Perak Motif Batik Celuk',
                'description' => 'Gelang perak bakar sterling 925 dengan detail ukiran motif flora khas desa Celuk Bali, dipahat tangan oleh seniman perak lokal.',
                'price'       => 189000,
                'category'    => 'aksesoris',
                'origin'      => 'Bali',
                'badges'      => ['Handmade', 'Silver 925', '3D Detail'],
                'rating'      => 4.8,
                'sold'        => 150,
                'umkm_name'   => 'Celuk Silver Art',
                'ar_model_url'=> 'https://modelviewer.dev/shared-assets/models/glTF-Sample-Assets/Models/ToyCar/glTF-Binary/ToyCar.glb',
            ],
            [
                'name'        => 'Bros Kebaya Batik Alpaka',
                'description' => 'Bros kebaya cantik dari logam alpaka lapis emas kuning 18 karat dengan aksen motif batik mini yang cocok disandingkan dengan kebaya kutubaru Anda.',
                'price'       => 125000,
                'category'    => 'aksesoris',
                'origin'      => 'Yogyakarta',
                'badges'      => ['3D Detail', 'Handmade'],
                'rating'      => 4.8,
                'sold'        => 280,
                'umkm_name'   => 'Jogja Aksesoris Craft',
                'ar_model_url'=> 'https://modelviewer.dev/shared-assets/models/glTF-Sample-Assets/Models/ToyCar/glTF-Binary/ToyCar.glb',
            ],
            [
                'name'        => 'Bantal Sofa Batik Parang',
                'description' => 'Sarung bantal sofa dekoratif bermotif batik Parang Yogyakarta dari kain katun prima tebal untuk mempercantik dan memberi sentuhan etnik pada ruang tamu Anda.',
                'price'       => 95000,
                'category'    => 'dekorasi',
                'origin'      => 'Solo',
                'badges'      => ['Eco Craft', 'Best Seller', '3D Detail'],
                'rating'      => 4.5,
                'sold'        => 230,
                'umkm_name'   => 'Batik Home Living',
                'ar_model_url'=> 'https://modelviewer.dev/shared-assets/models/glTF-Sample-Assets/Models/SheenChair/glTF-Binary/SheenChair.glb',
            ],
            [
                'name'        => 'Runner Meja Batik Mega Mendung',
                'description' => 'Table runner / taplak meja panjang bermotif batik Mega Mendung biru dari katun premium berukuran 150x40 cm untuk memperindah estetika meja makan kayu Anda.',
                'price'       => 135000,
                'category'    => 'dekorasi',
                'origin'      => 'Cirebon',
                'badges'      => ['Eco Craft', '3D Detail'],
                'rating'      => 4.6,
                'sold'        => 158,
                'umkm_name'   => 'Cirebon Home Decor',
                'ar_model_url'=> 'https://modelviewer.dev/shared-assets/models/glTF-Sample-Assets/Models/SheenChair/glTF-Binary/SheenChair.glb',
            ],
            [
                'name'        => 'Batik Serat Jati Madiun',
                'description' => 'Kemeja batik khas Madiun dengan motif serat kayu jati dan kombinasi kelor bunga pecilan, melambangkan kekuatan alam serta keteguhan budi pekerti masyarakat Madiun.',
                'price'       => 295000,
                'category'    => 'batik',
                'origin'      => 'Madiun',
                'badges'      => ['Khas Madiun', 'Katun Prima', 'Batik Cap'],
                'rating'      => 4.8,
                'sold'        => 92,
                'umkm_name'   => 'Batik Retno Dumilah',
                'ar_model_url'=> null,
            ],
            [
                'name'        => 'Tenun Ikat Bandar Kediri',
                'description' => 'Kemeja premium pria yang dibuat dari kain tenun ikat tradisional Bandar Kidul Kediri, ditenun secara presisi oleh pengrajin lokal menggunakan Alat Tenun Bukan Mesin (ATBM).',
                'price'       => 380000,
                'category'    => 'fashion',
                'origin'      => 'Kediri',
                'badges'      => ['Tenun ATBM', 'Khas Kediri', 'Handmade'],
                'rating'      => 4.9,
                'sold'        => 110,
                'umkm_name'   => 'Tenun Bandar Lestari',
                'ar_model_url'=> null,
            ],
            [
                'name'        => 'Batik Papua Cendrawasih',
                'description' => 'Kemeja batik katun eksotis dengan motif Burung Cendrawasih yang ikonik dari tanah Papua, dikombinasikan dengan ornamen tifa dan ukiran etnik suku Kamoro yang artistik.',
                'price'       => 425000,
                'category'    => 'batik',
                'origin'      => 'Jayapura',
                'badges'      => ['Motif Papua', 'Premium', 'Cultural Heritage'],
                'rating'      => 4.9,
                'sold'        => 75,
                'umkm_name'   => 'Batik Papua Asli',
                'ar_model_url'=> null,
            ],
            [
                'name'        => 'Batik Gentongan Madura',
                'description' => 'Kain batik tulis Gentongan klasik dari Madura dengan warna-warna berani merah-biru yang sangat awet, diproses melalui perendaman gentong batu tradisional selama berbulan-bulan.',
                'price'       => 950000,
                'category'    => 'batik',
                'origin'      => 'Bangkalan',
                'badges'      => ['Gentongan', 'Batik Tulis', 'Collector Item'],
                'rating'      => 5.0,
                'sold'        => 18,
                'umkm_name'   => 'Batik Gentong Madura',
                'ar_model_url'=> null,
            ],
            [
                'name'        => 'Kebaya Kutubaru Klasik Jawa',
                'description' => 'Setelan kebaya kutubaru khas Jawa Timur dengan bahan brokat katun halus berwarna merah marun berhias detail bef dada tradisional, memancarkan keanggunan abadi.',
                'price'       => 350000,
                'category'    => 'fashion',
                'origin'      => 'Surabaya',
                'badges'      => ['Kebaya', 'Jawa Timur', 'Elegant Fit'],
                'rating'      => 4.8,
                'sold'        => 134,
                'umkm_name'   => 'Kebaya Cantik Nusantara',
                'ar_model_url'=> null,
            ],
            [
                'name'        => 'Surjan Lurik Tradisional',
                'description' => 'Baju surjan pria bermotif lurik garis cokelat-hitam klasik khas Yogyakarta, dibuat dari kain katun ATBM yang lembut, adem, dan sangat nyaman dipakai untuk acara adat.',
                'price'       => 145000,
                'category'    => 'fashion',
                'origin'      => 'Klaten',
                'badges'      => ['Tenun Lurik', 'Khas Jogja', 'Best Seller'],
                'rating'      => 4.7,
                'sold'        => 340,
                'umkm_name'   => 'Lurik Klaten Indah',
                'ar_model_url'=> null,
            ],
            [
                'name'        => 'Kemeja Sasirangan Banjar',
                'description' => 'Kemeja pria lengan pendek bermotif Sasirangan khas Banjar Kalimantan Selatan, diproses dengan teknik jelujur handmade menggunakan bahan pewarna ramah lingkungan.',
                'price'       => 320000,
                'category'    => 'fashion',
                'origin'      => 'Banjarmasin',
                'badges'      => ['Sasirangan', 'Eco Craft', 'Handmade'],
                'rating'      => 4.8,
                'sold'        => 85,
                'umkm_name'   => 'Sasirangan Lestari',
                'ar_model_url'=> null,
            ],
            [
                'name'        => 'Baju Kurung Basiba Minang',
                'description' => 'Baju kurung basiba longgar khas wanita Minangkabau Sumatera Barat, dihiasi dengan bordir sulaman benang emas yang detail dan anggun di bagian leher serta lengan.',
                'price'       => 450000,
                'category'    => 'fashion',
                'origin'      => 'Padang',
                'badges'      => ['Minang Authentic', 'Sulaman Emas', 'Premium Fit'],
                'rating'      => 5.0,
                'sold'        => 40,
                'umkm_name'   => 'Sulaman Minang Sakato',
                'ar_model_url'=> null,
            ],
        ];

        $demoUser = User::where('email', 'user@snapfit.id')->first();
        $umkmRole = Role::where('name', 'umkm')->first();

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
                Profile::updateOrCreate(
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
            } elseif ($pName === 'Batik Serat Jati Madiun') {
                $imageName = 'batik_madiun.png';
            } elseif ($pName === 'Tenun Ikat Bandar Kediri') {
                $imageName = 'tenun_kediri.png';
            } elseif ($pName === 'Batik Papua Cendrawasih') {
                $imageName = 'batik_papua.png';
            } elseif ($pName === 'Batik Gentongan Madura') {
                $imageName = 'batik_madura.png';
            } elseif ($pName === 'Kebaya Kutubaru Klasik Jawa') {
                $imageName = 'kebaya_kutubaru.png';
            } elseif ($pName === 'Surjan Lurik Tradisional') {
                $imageName = 'surjan_lurik.png';
            } elseif ($pName === 'Kemeja Sasirangan Banjar') {
                $imageName = 'sasirangan_banjar.png';
            } elseif ($pName === 'Baju Kurung Basiba Minang') {
                $imageName = 'kurung_basiba.png';
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

            $product = Product::create(array_merge($p, [
                'user_id' => $user->id,
                'images'  => $productImage,
                'is_published' => true,
            ]));

            // Seed 3-4 Reviews per product
            $catReviews = $reviewsPool[$pCat] ?? $reviewsPool['batik'];
            shuffle($catReviews);
            shuffle($buyers);
            $numReviews = rand(3, 4);

            for ($i = 0; $i < $numReviews; $i++) {
                if (isset($buyers[$i]) && isset($catReviews[$i])) {
                    Review::create([
                        'user_id'    => $buyers[$i]->id,
                        'product_id' => $product->id,
                        'rating'     => $catReviews[$i]['rating'],
                        'comment'    => $catReviews[$i]['comment'],
                    ]);
                }
            }

            // Recalculate Rating and Reviews Count Cache in Product model
            $avg = $product->reviews()->avg('rating');
            $count = $product->reviews()->count();
            $product->update([
                'avg_rating'    => round($avg, 2),
                'rating'        => round($avg, 1),
                'reviews_count' => $count
            ]);
        }

        // Seed completed orders for all users in the database on all products, so any logged-in user can submit reviews
        $allUsers = User::all();
        $allProducts = Product::all();
        foreach ($allUsers as $user) {
            foreach ($allProducts as $prod) {
                $order = \App\Models\Order::create([
                    'buyer_id' => $user->id,
                    'midtrans_order_id' => 'DEMO-ORDER-' . $user->id . '-' . $prod->id . '-' . uniqid(),
                    'total_amount' => $prod->price,
                    'status' => 'completed',
                ]);

                \App\Models\OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $prod->id,
                    'quantity' => 1,
                    'price' => $prod->price,
                    'variant' => 'Standard',
                ]);
            }
        }

        $this->command->info('✅ Products, Customer Reviews & Demo Orders seeded successfully!');
    }
}
