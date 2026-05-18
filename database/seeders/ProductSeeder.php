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
            [
                'name'        => 'Batik Tulis Lasem',
                'description' => 'Kemeja batik pesisir Lasem motif tiga negeri dengan perpaduan warna merah, biru, dan sogan yang menawan.',
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
                'description' => 'Kemeja batik motif mega mendung khas Cirebon melambangkan ketenangan dan kesabaran. Warna biru gradasi yang memukau.',
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
                'description' => 'Kemeja batik motif sidomukti bermakna kemakmuran dan kebahagiaan. Pilihan sempurna untuk acara pernikahan adat Jawa.',
                'price'       => 680000,
                'category'    => 'batik',
                'origin'      => 'Solo',
                'badges'      => ['Batik Tulis', 'Limited'],
                'rating'      => 5.0,
                'sold'        => 32,
                'umkm_name'   => 'Batik Keraton Solo',
            ],
            [
                'name'        => 'Batik Kawung Kencana',
                'description' => 'Kemeja batik motif kawung yang merepresentasikan kesucian dan keadilan. Motif ini dahulu hanya dipakai oleh keluarga keraton.',
                'price'       => 520000,
                'category'    => 'batik',
                'origin'      => 'Yogyakarta',
                'badges'      => ['Batik Tulis', 'Premium'],
                'rating'      => 4.8,
                'sold'        => 67,
                'umkm_name'   => 'Omah Batik Kawung',
            ],
            [
                'name'        => 'Batik Sekar Jagad',
                'description' => 'Kemeja batik motif sekar jagad yang bermakna keindahan dan keberagaman dunia. Perpaduan warna yang harmonis.',
                'price'       => 595000,
                'category'    => 'batik',
                'origin'      => 'Solo',
                'badges'      => ['Batik Tulis', 'AR Ready'],
                'rating'      => 4.8,
                'sold'        => 74,
                'umkm_name'   => 'Batik Sekar Arum',
            ],
            [
                'name'        => 'Batik Sogan Klasik',
                'description' => 'Kemeja batik warna sogan coklat khas Solo. Warna alam yang elegan, cocok untuk acara formal maupun semi-formal.',
                'price'       => 425000,
                'category'    => 'batik',
                'origin'      => 'Solo',
                'badges'      => ['Batik Tulis', 'Handmade'],
                'rating'      => 4.7,
                'sold'        => 156,
                'umkm_name'   => 'Batik Danar Hadi',
            ],
            [
                'name'        => 'Batik Gentongan Madura',
                'description' => 'Kemeja batik gentongan khas Madura yang direndam dalam gentong tanah liat selama berbulan-bulan untuk menghasilkan warna unik.',
                'price'       => 1200000,
                'category'    => 'batik',
                'origin'      => 'Madura',
                'badges'      => ['Premium', 'Limited'],
                'rating'      => 4.9,
                'sold'        => 18,
                'umkm_name'   => 'Batik Tanjung Bumi',
            ],
            [
                'name'        => 'Batik Tulis Pekalongan',
                'description' => 'Kemeja batik khas Pekalongan dengan motif bunga dan burung yang kaya warna. Perpaduan budaya Jawa dan pengaruh pesisir.',
                'price'       => 380000,
                'category'    => 'batik',
                'origin'      => 'Pekalongan',
                'badges'      => ['Batik Tulis', 'AR Ready'],
                'rating'      => 4.6,
                'sold'        => 203,
                'umkm_name'   => 'Batik Pekalongan Jaya',
            ],
            [
                'name'        => 'Batik Truntum Surakarta',
                'description' => 'Kemeja batik motif truntum yang melambangkan cinta yang tumbuh kembali. Sering dipakai orang tua pengantin dalam upacara pernikahan.',
                'price'       => 550000,
                'category'    => 'batik',
                'origin'      => 'Surakarta',
                'badges'      => ['Batik Tulis', 'Handmade'],
                'rating'      => 4.8,
                'sold'        => 91,
                'umkm_name'   => 'Griya Batik Surakarta',
            ],
            [
                'name'        => 'Batik Ceplok Jogja',
                'description' => 'Kemeja batik motif ceplok geometris khas Yogyakarta. Desain simetris yang rapi dengan sentuhan modern.',
                'price'       => 295000,
                'category'    => 'batik',
                'origin'      => 'Yogyakarta',
                'badges'      => ['Batik Cap', 'AR Ready'],
                'rating'      => 4.5,
                'sold'        => 340,
                'umkm_name'   => 'Batik Jogja Istimewa',
            ],
            [
                'name'        => 'Batik Tambal Pekalongan',
                'description' => 'Kemeja batik motif tambal yang menggabungkan berbagai pola dalam satu kain. Bermakna penyembuhan dan harapan baru.',
                'price'       => 445000,
                'category'    => 'batik',
                'origin'      => 'Pekalongan',
                'badges'      => ['Batik Tulis', 'Handmade'],
                'rating'      => 4.7,
                'sold'        => 58,
                'umkm_name'   => 'Rumah Batik Pesisir',
            ],
            [
                'name'        => 'Batik Lereng Kencana',
                'description' => 'Kemeja batik motif lereng dengan garis diagonal yang elegan. Dulunya hanya dikenakan oleh bangsawan keraton.',
                'price'       => 620000,
                'category'    => 'batik',
                'origin'      => 'Yogyakarta',
                'badges'      => ['Batik Tulis', 'Premium'],
                'rating'      => 4.9,
                'sold'        => 42,
                'umkm_name'   => 'Sanggar Batik Mataram',
            ],
            [
                'name'        => 'Batik Nitik Kerok',
                'description' => 'Kemeja batik motif nitik yang dibuat dengan teknik titik-titik halus. Membutuhkan ketelitian tinggi dan waktu pembuatan berbulan-bulan.',
                'price'       => 950000,
                'category'    => 'batik',
                'origin'      => 'Yogyakarta',
                'badges'      => ['Batik Tulis', 'Limited'],
                'rating'      => 5.0,
                'sold'        => 15,
                'umkm_name'   => 'Batik Nitik Yogya',
            ],
            [
                'name'        => 'Batik Wahyu Tumurun',
                'description' => 'Kemeja batik motif wahyu tumurun bermakna anugerah dari Tuhan. Motif yang penuh makna spiritual dan keagungan.',
                'price'       => 725000,
                'category'    => 'batik',
                'origin'      => 'Solo',
                'badges'      => ['Batik Tulis', 'Premium'],
                'rating'      => 4.8,
                'sold'        => 37,
                'umkm_name'   => 'Batik Wahyu Keraton',
            ],

            // ═══ FASHION (10 produk) ═══
            [
                'name'        => 'Kemeja Batik Slim Fit Modern',
                'description' => 'Kemeja batik pria dengan potongan slim fit kontemporer. Cocok untuk anak muda yang ingin tampil stylish dengan sentuhan tradisional.',
                'price'       => 285000,
                'category'    => 'fashion',
                'origin'      => 'Bandung',
                'badges'      => ['Modern Fit', 'AR Ready'],
                'rating'      => 4.7,
                'sold'        => 520,
                'umkm_name'   => 'Batik Urban Studio',
            ],
            [
                'name'        => 'Kemeja Tenun Troso Jepara',
                'description' => 'Kemeja pria elegan berbahan tenun troso asli Jepara. Benang berwarna-warni ditenun menjadi motif yang khas.',
                'price'       => 250000,
                'category'    => 'fashion',
                'origin'      => 'Jepara',
                'badges'      => ['Handmade', 'AR Ready'],
                'rating'      => 4.7,
                'sold'        => 310,
                'umkm_name'   => 'Tenun Troso Indah',
            ],
            [
                'name'        => 'Outer Batik Nusantara',
                'description' => 'Outer pria berbahan batik premium dengan desain kontemporer. Layering piece yang sempurna untuk gaya smart casual.',
                'price'       => 450000,
                'category'    => 'fashion',
                'origin'      => 'Jakarta',
                'badges'      => ['Modern Fit', 'Premium'],
                'rating'      => 4.6,
                'sold'        => 145,
                'umkm_name'   => 'Nusantara Fashion Lab',
            ],
            [
                'name'        => 'Kemeja Batik Lengan Pendek Kasual',
                'description' => 'Kemeja batik santai lengan pendek untuk gaya everyday. Bahan katun premium yang adem dan nyaman sepanjang hari.',
                'price'       => 195000,
                'category'    => 'fashion',
                'origin'      => 'Yogyakarta',
                'badges'      => ['Casual Fit', 'AR Ready'],
                'rating'      => 4.5,
                'sold'        => 680,
                'umkm_name'   => 'Batik Casual ID',
            ],
            [
                'name'        => 'Kemeja Batik Kombinasi Lurik',
                'description' => 'Kemeja batik dengan kombinasi kain lurik pada aksen kerah dan manset. Perpaduan dua warisan tekstil Jawa yang harmonis.',
                'price'       => 320000,
                'category'    => 'fashion',
                'origin'      => 'Solo',
                'badges'      => ['Handmade', 'Limited'],
                'rating'      => 4.8,
                'sold'        => 92,
                'umkm_name'   => 'Lurik Batik House',
            ],
            [
                'name'        => 'Scarf Batik Cirebon',
                'description' => 'Scarf pria dari bahan sutra halus dengan motif batik Cirebon. Aksesori premium yang menambah kesan elegan.',
                'price'       => 185000,
                'category'    => 'fashion',
                'origin'      => 'Cirebon',
                'badges'      => ['Batik Tulis', 'AR Ready'],
                'rating'      => 4.8,
                'sold'        => 92,
                'umkm_name'   => 'Mega Mendung Atelier',
            ],
            [
                'name'        => 'Kemeja Batik Dobby Premium',
                'description' => 'Kemeja batik dengan bahan dobby yang bertekstur halus. Memberikan dimensi visual yang menarik pada motif batik.',
                'price'       => 375000,
                'category'    => 'fashion',
                'origin'      => 'Bandung',
                'badges'      => ['Premium', 'Modern Fit'],
                'rating'      => 4.6,
                'sold'        => 178,
                'umkm_name'   => 'Dobby Batik Co.',
            ],
            [
                'name'        => 'Kemeja Batik Printing Exclusive',
                'description' => 'Kemeja batik printing berkualitas tinggi dengan detail warna yang tajam. Pilihan praktis untuk tampil batik setiap hari.',
                'price'       => 165000,
                'category'    => 'fashion',
                'origin'      => 'Pekalongan',
                'badges'      => ['Best Seller'],
                'rating'      => 4.4,
                'sold'        => 1250,
                'umkm_name'   => 'Batik Print Nusantara',
            ],
            [
                'name'        => 'Kemeja Batik Fractal Art',
                'description' => 'Kemeja batik dengan motif fractal berbasis matematika. Inovasi desain batik yang memadukan sains dan seni tradisional.',
                'price'       => 395000,
                'category'    => 'fashion',
                'origin'      => 'Bandung',
                'badges'      => ['Innovation', 'AR Ready'],
                'rating'      => 4.7,
                'sold'        => 134,
                'umkm_name'   => 'Batik Fractal',
            ],
            [
                'name'        => 'Dompet Kulit Batik Garut',
                'description' => 'Dompet kulit domba Garut premium dengan aksen batik stamp pada bagian depan. Perpaduan craft kulit dan seni batik.',
                'price'       => 220000,
                'category'    => 'fashion',
                'origin'      => 'Garut',
                'badges'      => ['Handmade'],
                'rating'      => 4.7,
                'sold'        => 140,
                'umkm_name'   => 'Garut Leather Craft',
            ],

            // ═══ KERAJINAN (5 produk) ═══
            [
                'name'        => 'Kain Tenun Ikat Sumba',
                'description' => 'Kain tenun handmade dengan pewarna alam dan motif tradisional Sumba. Setiap lembar membutuhkan waktu 3-6 bulan pengerjaan.',
                'price'       => 520000,
                'category'    => 'kerajinan',
                'origin'      => 'Sumba',
                'badges'      => ['Handmade', 'Limited'],
                'rating'      => 4.9,
                'sold'        => 85,
                'umkm_name'   => 'Rumah Tenun Marapu',
            ],
            [
                'name'        => 'Kain Songket Palembang Emas',
                'description' => 'Songket merah emas khas Palembang ditenun manual dengan benang emas asli. Warisan budaya Sriwijaya yang agung.',
                'price'       => 1250000,
                'category'    => 'kerajinan',
                'origin'      => 'Palembang',
                'badges'      => ['Premium', 'Limited'],
                'rating'      => 5.0,
                'sold'        => 12,
                'umkm_name'   => 'Songket Sriwijaya',
            ],
            [
                'name'        => 'Kain Ulos Batak Sadum',
                'description' => 'Kain ulos asli Batak motif sadum yang ditenun manual. Sarat makna budaya dan sering digunakan dalam upacara adat.',
                'price'       => 480000,
                'category'    => 'kerajinan',
                'origin'      => 'Samosir',
                'badges'      => ['Handmade', 'AR Ready'],
                'rating'      => 4.8,
                'sold'        => 63,
                'umkm_name'   => 'Ulos Samosir Heritage',
            ],
            [
                'name'        => 'Kain Sasirangan Banjar',
                'description' => 'Kain sasirangan khas Banjarmasin dengan teknik ikat celup tradisional. Warna-warna cerah yang memukau dari pewarna alam.',
                'price'       => 275000,
                'category'    => 'kerajinan',
                'origin'      => 'Banjarmasin',
                'badges'      => ['Handmade', 'Eco Craft'],
                'rating'      => 4.6,
                'sold'        => 97,
                'umkm_name'   => 'Sasirangan Banjar Art',
            ],
            [
                'name'        => 'Kain Tapis Lampung',
                'description' => 'Kain tapis Lampung dengan sulaman benang emas yang rumit. Kain seremonial yang mencerminkan status sosial pemakainya.',
                'price'       => 890000,
                'category'    => 'kerajinan',
                'origin'      => 'Lampung',
                'badges'      => ['Premium', 'Handmade'],
                'rating'      => 4.9,
                'sold'        => 28,
                'umkm_name'   => 'Tapis Lampung Indah',
            ],

            // ═══ AKSESORIS (5 produk) ═══
            [
                'name'        => 'Gelang Perak Motif Batik Celuk',
                'description' => 'Gelang perak ukir khas Celuk Bali dengan motif batik. Perpaduan dua tradisi kerajinan Indonesia dalam satu karya.',
                'price'       => 189000,
                'category'    => 'aksesoris',
                'origin'      => 'Bali',
                'badges'      => ['Handmade', 'AR Ready'],
                'rating'      => 4.8,
                'sold'        => 150,
                'umkm_name'   => 'Celuk Silver Art',
            ],
            [
                'name'        => 'Kalung Etnik Toraja',
                'description' => 'Kalung etnik dengan ornamen ukiran Toraja dari perak murni. Desain yang terinspirasi dari tongkonan dan motif pa\'tedong.',
                'price'       => 265000,
                'category'    => 'aksesoris',
                'origin'      => 'Toraja',
                'badges'      => ['Handmade', 'Limited'],
                'rating'      => 4.7,
                'sold'        => 76,
                'umkm_name'   => 'Toraja Silver House',
            ],
            [
                'name'        => 'Bros Kebaya Batik Alpaka',
                'description' => 'Bros kebaya cantik dari bahan alpaka lapis emas dengan motif batik mini. Aksesori sempurna untuk kebaya dan baju formal.',
                'price'       => 125000,
                'category'    => 'aksesoris',
                'origin'      => 'Yogyakarta',
                'badges'      => ['AR Ready'],
                'rating'      => 4.8,
                'sold'        => 280,
                'umkm_name'   => 'Jogja Aksesoris Craft',
            ],
            [
                'name'        => 'Cincin Perak Motif Kawung',
                'description' => 'Cincin perak 925 dengan ukiran motif kawung halus. Cocok untuk pria maupun wanita yang menghargai kerajinan tradisional.',
                'price'       => 145000,
                'category'    => 'aksesoris',
                'origin'      => 'Kotagede',
                'badges'      => ['Handmade'],
                'rating'      => 4.6,
                'sold'        => 195,
                'umkm_name'   => 'Kotagede Silver',
            ],
            [
                'name'        => 'Manset Batik Premium',
                'description' => 'Manset kemeja dari perak dan enamel bermotif batik parang. Detail finishing yang menunjukkan perhatian pada kesempurnaan.',
                'price'       => 175000,
                'category'    => 'aksesoris',
                'origin'      => 'Jakarta',
                'badges'      => ['Premium', 'AR Ready'],
                'rating'      => 4.5,
                'sold'        => 88,
                'umkm_name'   => 'Batik Accessories ID',
            ],

            // ═══ DEKORASI (5 produk) ═══
            [
                'name'        => 'Bantal Sofa Batik Parang',
                'description' => 'Bantal dekoratif dengan sarung kain batik motif parang. Sentuhan budaya untuk interior rumah modern Anda.',
                'price'       => 95000,
                'category'    => 'dekorasi',
                'origin'      => 'Solo',
                'badges'      => ['Eco Craft'],
                'rating'      => 4.5,
                'sold'        => 230,
                'umkm_name'   => 'Batik Home Living',
            ],
            [
                'name'        => 'Taplak Meja Batik Tulis',
                'description' => 'Taplak meja berbahan katun prima dengan motif batik tulis. Mempercantik ruang makan dengan sentuhan tradisional.',
                'price'       => 185000,
                'category'    => 'dekorasi',
                'origin'      => 'Pekalongan',
                'badges'      => ['Batik Tulis', 'Handmade'],
                'rating'      => 4.7,
                'sold'        => 112,
                'umkm_name'   => 'Batik Interior House',
            ],
            [
                'name'        => 'Wall Art Batik Frame',
                'description' => 'Hiasan dinding kain batik asli dalam bingkai kayu jati. Karya seni yang memberikan karakter pada setiap ruangan.',
                'price'       => 350000,
                'category'    => 'dekorasi',
                'origin'      => 'Yogyakarta',
                'badges'      => ['Premium', 'Handmade'],
                'rating'      => 4.8,
                'sold'        => 64,
                'umkm_name'   => 'Batik Art Gallery',
            ],
            [
                'name'        => 'Runner Meja Batik Mega Mendung',
                'description' => 'Table runner bermotif mega mendung yang elegan. Panjang 150cm, cocok untuk meja makan dan meja konsol.',
                'price'       => 135000,
                'category'    => 'dekorasi',
                'origin'      => 'Cirebon',
                'badges'      => ['Eco Craft'],
                'rating'      => 4.6,
                'sold'        => 158,
                'umkm_name'   => 'Cirebon Home Decor',
            ],
            [
                'name'        => 'Sarung Bantal Kursi Batik Set',
                'description' => 'Set 4 sarung bantal kursi bermotif batik kawung. Bahan katun tebal yang nyaman dan mudah dicuci.',
                'price'       => 120000,
                'category'    => 'dekorasi',
                'origin'      => 'Solo',
                'badges'      => ['Best Seller', 'Eco Craft'],
                'rating'      => 4.4,
                'sold'        => 445,
                'umkm_name'   => 'Batik Home Solo',
            ],
        ];

        foreach ($products as $index => $p) {
            // Find or create user for this UMKM
            $user = User::firstOrCreate(
                ['email' => strtolower(str_replace([' ', '.', ',', '\''], '', $p['umkm_name'])) . '@umkm.com'],
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
                    'phone' => '08' . rand(1000000000, 9999999999)
                ]
            );

            // Category-specific curated images
            $categoryImages = [
                'batik' => [
                    'https://images.unsplash.com/photo-1617627143750-d86bc21e42bb?w=500&q=80',
                    'https://images.unsplash.com/photo-1585487000160-6ebcfceb0d44?w=500&q=80',
                    'https://images.unsplash.com/photo-1609709295948-17d77cb2a69b?w=500&q=80',
                    'https://images.unsplash.com/photo-1617627143233-0c93f55dda49?w=500&q=80',
                    'https://images.unsplash.com/photo-1528360983277-13d401cdc186?w=500&q=80',
                ],
                'fashion' => [
                    'https://images.unsplash.com/photo-1594938298603-c8148c4dae35?w=500&q=80',
                    'https://images.unsplash.com/photo-1620799140408-edc6dcb6d633?w=500&q=80',
                    'https://images.unsplash.com/photo-1558171813-01a7b6f4c02d?w=500&q=80',
                    'https://images.unsplash.com/photo-1489987707025-afc232f7ea0f?w=500&q=80',
                    'https://images.unsplash.com/photo-1556905055-8f358a7a47b2?w=500&q=80',
                ],
                'kerajinan' => [
                    'https://images.unsplash.com/photo-1606722590583-6951b5ea92ad?w=500&q=80',
                    'https://images.unsplash.com/photo-1599409636295-e3cf3d0f8a8a?w=500&q=80',
                    'https://images.unsplash.com/photo-1615486511484-92e172cc4fe0?w=500&q=80',
                    'https://images.unsplash.com/photo-1513364776144-60967b0f800f?w=500&q=80',
                    'https://images.unsplash.com/photo-1601925260368-ae2f83cf8b7f?w=500&q=80',
                ],
                'aksesoris' => [
                    'https://images.unsplash.com/photo-1515562141589-67f0d96e1790?w=500&q=80',
                    'https://images.unsplash.com/photo-1573408301185-9146fe634ad0?w=500&q=80',
                    'https://images.unsplash.com/photo-1611652022419-a9419f74343d?w=500&q=80',
                    'https://images.unsplash.com/photo-1535632066927-ab7c9ab60908?w=500&q=80',
                    'https://images.unsplash.com/photo-1601121141418-c1cc38253e09?w=500&q=80',
                ],
                'dekorasi' => [
                    'https://images.unsplash.com/photo-1616486338812-3dadae4b4ace?w=500&q=80',
                    'https://images.unsplash.com/photo-1567016432779-094069958ea5?w=500&q=80',
                    'https://images.unsplash.com/photo-1513694203232-719a280e022f?w=500&q=80',
                    'https://images.unsplash.com/photo-1586023492125-27b2c045efd7?w=500&q=80',
                    'https://images.unsplash.com/photo-1615529328331-f8917597711f?w=500&q=80',
                ],
            ];

            $category = $p['category'];
            $images = $categoryImages[$category] ?? $categoryImages['batik'];
            // Cycle through images for each product in the same category
            $imageIndex = 0;
            static $categoryCounters = [];
            if (!isset($categoryCounters[$category])) {
                $categoryCounters[$category] = 0;
            }
            $imageIndex = $categoryCounters[$category] % count($images);
            $categoryCounters[$category]++;

            $productImage = [$images[$imageIndex]];

            $umkmName = $p['umkm_name'];
            unset($p['umkm_name']);

            Product::create(array_merge($p, [
                'user_id' => $user->id,
                'images'  => $productImage,
                'is_published' => true,
            ]));
        }

        $this->command->info('✅ Products seeded (' . count($products) . ' produk batik & fashion Nusantara)');
    }
}
