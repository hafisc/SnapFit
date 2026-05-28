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

        // 1. Seed Mock Buyer Users for Reviews (Nama Indonesia yang natural, bukan buatan AI formal)
        $buyerRole = Role::where('name', 'buyer')->first();
        $buyers = [];
        $buyersData = [
            ['name' => 'Dian Prasetyo', 'email' => 'dian.pras@gmail.com'],
            ['name' => 'Rina Kartika', 'email' => 'rina.k@gmail.com'],
            ['name' => 'Aditya Pratama', 'email' => 'adit.pratama@gmail.com'],
            ['name' => 'Dewi Lestari', 'email' => 'dewi.les@gmail.com'],
            ['name' => 'Ahmad Fauzi', 'email' => 'fauzi.ahmad@gmail.com'],
            ['name' => 'Siti Rahmawati', 'email' => 'siti.rahma@gmail.com'],
            ['name' => 'Hendra Wijaya', 'email' => 'hendra.w@gmail.com'],
            ['name' => 'Indah Permatasari', 'email' => 'indah.p@gmail.com'],
            ['name' => 'Fajar Nugroho', 'email' => 'fajar.nug@gmail.com'],
            ['name' => 'Eka Putri', 'email' => 'eka.putri@gmail.com'],
            ['name' => 'Yusuf Sulistyo', 'email' => 'yusuf.s@gmail.com'],
            ['name' => 'Rani Safitri', 'email' => 'rani.saf@gmail.com'],
            ['name' => 'Taufik Hidayat', 'email' => 'taufik.h@gmail.com'],
            ['name' => 'Mega Utami', 'email' => 'mega.u@gmail.com'],
            ['name' => 'Bambang Triyono', 'email' => 'bambang.tri@gmail.com'],
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
                    'address' => 'Jl. Mawar No. ' . rand(1, 100) . ', Malang, Jawa Timur'
                ]
            );
            $buyers[] = $u;
        }

        // Review templates with natural Indonesian e-commerce tone (adem, rapi, cepet, rekomen, dll)
        $reviewsPool = [
            'batik' => [
                ['rating' => 5, 'comment' => 'Bahannya adem, motif batik parangnya keliatan rapi. Pas banget buat dipake kondangan.'],
                ['rating' => 5, 'comment' => 'Jahitannya rapi dan kuat. Warnanya juga awet ga gampang luntur pas dicuci.'],
                ['rating' => 5, 'comment' => 'Bagus banget batiknya, motifnya keliatan elegan dan ga pasaran.'],
                ['rating' => 4, 'comment' => 'Bahan katunnya enak dipake, cuma pengiriman dari ekspedisinya agak telat sehari.'],
                ['rating' => 4, 'comment' => 'Kemejanya pas di badan, tapi sayang pilihan sizenya cepet abis.'],
                ['rating' => 5, 'comment' => 'Harga bersahabat banget buat kualitas batik sekeren ini.'],
                ['rating' => 5, 'comment' => 'Suka sama motifnya, keliatan mewah pas dipake. Jahitan rapi.'],
            ],
            'fashion' => [
                ['rating' => 5, 'comment' => 'Potongan slim fit nya pas di badan, keliatan modern dan stylish.'],
                ['rating' => 5, 'comment' => 'Jahitan rapi presisi, bahannya alus ga gampang lecek. Cocok buat kerja sehari-hari.'],
                ['rating' => 4, 'comment' => 'Barang sesuai deskripsi, warna aslinya malah lebih bagus. Pengemasan aman.'],
                ['rating' => 5, 'comment' => 'Nyaman banget dipake seharian, bahannya ga bikin gerah.'],
                ['rating' => 4, 'comment' => 'Ukuran L nya pas di saya yang tinggi 175cm. Pengiriman cepet.'],
                ['rating' => 5, 'comment' => 'Bahannya jatuh, dipake adem dan cuttingannya bikin keliatan langsing.'],
            ],
            'kerajinan' => [
                ['rating' => 5, 'comment' => 'Tenun ikatnya bagus banget! Warnanya keliatan alami dan estetik.'],
                ['rating' => 5, 'comment' => 'Pengerjaannya rapi banget, detail tenunannya keliatan bernilai seni tinggi.'],
                ['rating' => 5, 'comment' => 'Puas belanja disini, packingnya tebal jadi barang sampai dengan aman.'],
                ['rating' => 4, 'comment' => 'Kainnya bagus, cuma pas awal dateng agak kaku. Setelah dicuci baru lemes.'],
                ['rating' => 5, 'comment' => 'Asli handmade, worth it banget dengan harganya.'],
            ],
            'dekorasi' => [
                ['rating' => 5, 'comment' => 'Bantal sofa batiknya bikin ruang tamu keliatan makin estetik dan rapi.'],
                ['rating' => 5, 'comment' => 'Runner mejanya mewah, motifnya sejajar dan rapi. Suka sama kombinasi warnanya.'],
                ['rating' => 5, 'comment' => 'Bahannya tebal, awet, dan motif Mega Mendungnya cerah banget.'],
                ['rating' => 4, 'comment' => 'Bagus buat hiasan meja makan, cuma ukurannya agak ngepas.'],
                ['rating' => 5, 'comment' => 'Jahitan sarung bantalnya rapi sekali. Respon penjual cepat.'],
            ],
            'aksesoris' => [
                ['rating' => 5, 'comment' => 'Gelang peraknya cantik pol! Detail ukirannya rapi dan ga gampang kusam.'],
                ['rating' => 5, 'comment' => 'Brosnya mewah banget, pas banget disandingin sama kebaya.'],
                ['rating' => 5, 'comment' => 'Detail handmade-nya keliatan teliti banget. Suka sama modelnya.'],
                ['rating' => 4, 'comment' => 'Bagus dan berkilau, cuma ukurannya agak sedikit ngepas di pergelangan tangan.'],
                ['rating' => 5, 'comment' => 'Ukirannya khas banget, kualitas perak Celuk emang ga usah diraguin.'],
            ],
        ];

        // 30 Distinct Products (dengan harga terjangkau / tidak terlalu mahal)
        $products = [
            [
                'name'        => 'Batik Parang Heritage',
                'description' => 'Kemeja batik katun prima pria dengan motif Parang klasik Yogyakarta yang gagah, melambangkan kekuatan, kekuasaan, dan semangat perjuangan.',
                'price'       => 235000,
                'category'    => 'batik',
                'origin'      => 'Yogyakarta',
                'badges'      => ['Batik Cap', 'AR Ready', 'Handmade'],
                'rating'      => 4.9,
                'sold'        => 120,
                'umkm_name'   => 'Sanggar Batik Laras',
                'ar_model_url'=> '/models/batik_parang.glb',
            ],
            [
                'name'        => 'Batik Tulis Lasem Tiga Negeri',
                'description' => 'Kemeja batik tulis Lasem motif Tiga Negeri dengan perpaduan warna merah darah ayam khas Tionghoa, biru, dan sogan Jawa yang legendaris.',
                'price'       => 395000,
                'category'    => 'batik',
                'origin'      => 'Rembang',
                'badges'      => ['Batik Tulis', 'Premium'],
                'rating'      => 4.9,
                'sold'        => 45,
                'umkm_name'   => 'Batik Pusaka Lasem',
                'ar_model_url'=> '/models/batik_lasem.glb',
            ],
            [
                'name'        => 'Batik Mega Mendung Klasik',
                'description' => 'Kemeja batik bermotif Mega Mendung khas Cirebon dengan warna gradasi biru menawan yang melambangkan ketenangan dan kesabaran.',
                'price'       => 245000,
                'category'    => 'batik',
                'origin'      => 'Cirebon',
                'badges'      => ['Batik Cap', 'AR Ready'],
                'rating'      => 4.7,
                'sold'        => 88,
                'umkm_name'   => 'Batik Trusmi Cirebon',
                'ar_model_url'=> '/models/batik_megamendung.glb',
            ],
            [
                'name'        => 'Batik Sidomukti Solo Alam',
                'description' => 'Kemeja batik motif Sidomukti klasik khas Solo dengan pewarnaan soga alam, melambangkan harapan akan kemakmuran dan kebahagiaan hidup.',
                'price'       => 295000,
                'category'    => 'batik',
                'origin'      => 'Solo',
                'badges'      => ['Batik Cap', 'Premium'],
                'rating'      => 5.0,
                'sold'        => 32,
                'umkm_name'   => 'Batik Keraton Solo',
                'ar_model_url'=> '/models/batik_sidomukti.glb',
            ],
            [
                'name'        => 'Batik Kawung Kencana Sogan',
                'description' => 'Kemeja batik motif Kawung sogan yang merepresentasikan buah aren simetris sebagai simbol kesucian, keadilan, dan umur panjang.',
                'price'       => 195000,
                'category'    => 'batik',
                'origin'      => 'Yogyakarta',
                'badges'      => ['Batik Cap', 'Handmade'],
                'rating'      => 4.8,
                'sold'        => 67,
                'umkm_name'   => 'Omah Batik Kawung',
                'ar_model_url'=> '/models/batik_kawung.glb',
            ],
            [
                'name'        => 'Kemeja Batik Slim Fit Modern',
                'description' => 'Kemeja batik pria bergaya kasual kontemporer dengan potongan slim fit modern dan motif abstrak dinamis yang elegan untuk acara formal.',
                'price'       => 165000,
                'category'    => 'fashion',
                'origin'      => 'Bandung',
                'badges'      => ['Modern Fit', 'AR Ready'],
                'rating'      => 4.7,
                'sold'        => 520,
                'umkm_name'   => 'Batik Urban Studio',
                'ar_model_url'=> '/models/batik_parang.glb',
            ],
            [
                'name'        => 'Kain Tenun Ikat Sumba Barat',
                'description' => 'Kain tenun ikat tradisional asli Sumba Barat buatan tangan pengrajin lokal dengan pewarna alami dari akar mengkudu dan kayu indigo.',
                'price'       => 320000,
                'category'    => 'kerajinan',
                'origin'      => 'Sumba',
                'badges'      => ['Handmade', 'Eco Craft', '3D Detail'],
                'rating'      => 4.9,
                'sold'        => 85,
                'umkm_name'   => 'Rumah Tenun Marapu',
                'ar_model_url'=> '/models/tenun_ikat.glb',
            ],
            [
                'name'        => 'Kain Songket Palembang Emas',
                'description' => 'Kain songket sutra merah Palembang yang ditenun menggunakan benang emas pilihan dengan motif bunga melati berkilau khas Sriwijaya.',
                'price'       => 450000,
                'category'    => 'kerajinan',
                'origin'      => 'Palembang',
                'badges'      => ['Premium', 'Limited', '3D Detail'],
                'rating'      => 5.0,
                'sold'        => 12,
                'umkm_name'   => 'Songket Sriwijaya',
                'ar_model_url'=> '/models/songket_palembang.glb',
            ],
            [
                'name'        => 'Gelang Perak Motif Batik Celuk',
                'description' => 'Gelang perak bakar sterling 925 dengan detail ukiran motif flora khas desa Celuk Bali, dipahat tangan oleh seniman perak lokal.',
                'price'       => 149000,
                'category'    => 'aksesoris',
                'origin'      => 'Bali',
                'badges'      => ['Handmade', 'Silver 925', '3D Detail'],
                'rating'      => 4.8,
                'sold'        => 150,
                'umkm_name'   => 'Celuk Silver Art',
                'ar_model_url'=> '/models/gelang_perak.glb',
            ],
            [
                'name'        => 'Bros Kebaya Batik Alpaka',
                'description' => 'Bros kebaya cantik dari logam alpaka lapis emas kuning 18 karat dengan aksen motif batik mini yang cocok disandingkan dengan kebaya kutubaru.',
                'price'       => 65000,
                'category'    => 'aksesoris',
                'origin'      => 'Yogyakarta',
                'badges'      => ['3D Detail', 'Handmade'],
                'rating'      => 4.8,
                'sold'        => 280,
                'umkm_name'   => 'Jogja Aksesoris Craft',
                'ar_model_url'=> '/models/bros_kebaya.glb',
            ],
            [
                'name'        => 'Bantal Sofa Batik Parang',
                'description' => 'Sarung bantal sofa dekoratif bermotif batik Parang Yogyakarta dari kain katun prima tebal untuk mempercantik interior ruang tamu Anda.',
                'price'       => 45000,
                'category'    => 'dekorasi',
                'origin'      => 'Solo',
                'badges'      => ['Eco Craft', 'Best Seller', '3D Detail'],
                'rating'      => 4.5,
                'sold'        => 230,
                'umkm_name'   => 'Batik Home Living',
                'ar_model_url'=> '/models/bantal_batik.glb',
            ],
            [
                'name'        => 'Runner Meja Batik Mega Mendung',
                'description' => 'Table runner / taplak meja panjang bermotif batik Mega Mendung biru dari katun premium berukuran 150x40 cm untuk keindahan meja makan.',
                'price'       => 85000,
                'category'    => 'dekorasi',
                'origin'      => 'Cirebon',
                'badges'      => ['Eco Craft', '3D Detail'],
                'rating'      => 4.6,
                'sold'        => 158,
                'umkm_name'   => 'Cirebon Home Decor',
                'ar_model_url'=> '/models/runner_meja.glb',
            ],
            [
                'name'        => 'Batik Serat Jati Madiun',
                'description' => 'Kemeja batik khas Madiun dengan motif serat kayu jati dan kelor, melambangkan kekuatan alam serta keteguhan budi pekerti masyarakat.',
                'price'       => 195000,
                'category'    => 'batik',
                'origin'      => 'Madiun',
                'badges'      => ['Khas Madiun', 'Katun Prima', 'Batik Cap'],
                'rating'      => 4.8,
                'sold'        => 92,
                'umkm_name'   => 'Batik Retno Dumilah',
                'ar_model_url'=> '/models/batik_madiun.glb',
            ],
            [
                'name'        => 'Tenun Ikat Bandar Kediri',
                'description' => 'Kemeja premium pria yang dibuat dari kain tenun ikat tradisional Bandar Kidul Kediri, ditenun secara presisi menggunakan ATBM.',
                'price'       => 245000,
                'category'    => 'fashion',
                'origin'      => 'Kediri',
                'badges'      => ['Tenun ATBM', 'Khas Kediri', 'Handmade'],
                'rating'      => 4.9,
                'sold'        => 110,
                'umkm_name'   => 'Tenun Bandar Lestari',
                'ar_model_url'=> '/models/tenun_kediri.glb',
            ],
            [
                'name'        => 'Batik Papua Cendrawasih',
                'description' => 'Kemeja batik katun eksotis dengan motif Burung Cendrawasih yang ikonik dari tanah Papua, dikombinasikan dengan ornamen tifa yang artistik.',
                'price'       => 265000,
                'category'    => 'batik',
                'origin'      => 'Jayapura',
                'badges'      => ['Motif Papua', 'Premium', 'Cultural Heritage'],
                'rating'      => 4.9,
                'sold'        => 75,
                'umkm_name'   => 'Batik Papua Asli',
                'ar_model_url'=> '/models/batik_papua.glb',
            ],
            [
                'name'        => 'Batik Gentongan Madura Jingga',
                'description' => 'Kain batik tulis Gentongan klasik dari Madura dengan warna-warna berani merah-biru awet, diproses melalui perendaman gentong batu tradisional.',
                'price'       => 395000,
                'category'    => 'batik',
                'origin'      => 'Bangkalan',
                'badges'      => ['Gentongan', 'Batik Tulis', 'Collector Item'],
                'rating'      => 5.0,
                'sold'        => 18,
                'umkm_name'   => 'Batik Gentong Madura',
                'ar_model_url'=> '/models/batik_madura.glb',
            ],
            [
                'name'        => 'Kebaya Kutubaru Klasik Jawa',
                'description' => 'Setelan kebaya kutubaru khas Jawa Timur dengan bahan brokat katun halus berwarna merah marun berhias detail bef dada tradisional.',
                'price'       => 215000,
                'category'    => 'fashion',
                'origin'      => 'Surabaya',
                'badges'      => ['Kebaya', 'Jawa Timur', 'Elegant Fit'],
                'rating'      => 4.8,
                'sold'        => 134,
                'umkm_name'   => 'Kebaya Cantik Nusantara',
                'ar_model_url'=> '/models/kebaya_kutubaru.glb',
            ],
            [
                'name'        => 'Surjan Lurik Tradisional',
                'description' => 'Baju surjan pria bermotif lurik garis cokelat-hitam klasik khas Yogyakarta, dibuat dari kain katun lembut, adem, dan nyaman dipakai.',
                'price'       => 95000,
                'category'    => 'fashion',
                'origin'      => 'Klaten',
                'badges'      => ['Tenun Lurik', 'Khas Jogja', 'Best Seller'],
                'rating'      => 4.7,
                'sold'        => 340,
                'umkm_name'   => 'Lurik Klaten Indah',
                'ar_model_url'=> '/models/surjan_lurik.glb',
            ],
            [
                'name'        => 'Kemeja Sasirangan Banjar Hijau',
                'description' => 'Kemeja pria lengan pendek bermotif Sasirangan khas Banjar Kalimantan Selatan, diproses dengan teknik jelujur handmade ramah lingkungan.',
                'price'       => 185000,
                'category'    => 'fashion',
                'origin'      => 'Banjarmasin',
                'badges'      => ['Sasirangan', 'Eco Craft', 'Handmade'],
                'rating'      => 4.8,
                'sold'        => 85,
                'umkm_name'   => 'Sasirangan Lestari',
                'ar_model_url'=> '/models/sasirangan_banjar.glb',
            ],
            [
                'name'        => 'Baju Kurung Basiba Minang Gold',
                'description' => 'Baju kurung basiba longgar khas wanita Minangkabau Sumatera Barat, dihiasi dengan bordir sulaman benang emas yang detail dan anggun.',
                'price'       => 225000,
                'category'    => 'fashion',
                'origin'      => 'Padang',
                'badges'      => ['Minang Authentic', 'Sulaman Emas', 'Premium Fit'],
                'rating'      => 5.0,
                'sold'        => 40,
                'umkm_name'   => 'Sulaman Minang Sakato',
                'ar_model_url'=> '/models/kurung_basiba.glb',
            ],
            // NEW PRODUCTS (21-30) untuk melengkapi ke 30 seeder
            [
                'name'        => 'Batik Pekalongan Floral',
                'description' => 'Kemeja katun premium dengan motif bunga dan pesisiran khas Pekalongan yang cerah dan berwarna-warni ceria.',
                'price'       => 145000,
                'category'    => 'batik',
                'origin'      => 'Pekalongan',
                'badges'      => ['Batik Pesisir', 'Warna Cerah'],
                'rating'      => 4.8,
                'sold'        => 192,
                'umkm_name'   => 'Sanggar Batik Laras',
                'ar_model_url'=> '/models/batik_fallback.glb',
            ],
            [
                'name'        => 'Blouse Batik Kawung Wanita',
                'description' => 'Atasan wanita modern dengan motif batik Kawung kencana, berpotongan asimetris yang stylish untuk ngantor maupun hangout.',
                'price'       => 135000,
                'category'    => 'fashion',
                'origin'      => 'Solo',
                'badges'      => ['Kemeja Wanita', 'Kantor Look'],
                'rating'      => 4.7,
                'sold'        => 140,
                'umkm_name'   => 'Omah Batik Kawung',
                'ar_model_url'=> '/models/fashion_fallback.glb',
            ],
            [
                'name'        => 'Kemeja Tenun Toraja Etnik',
                'description' => 'Kemeja katun bermotif tenunan khas suku Toraja Sulawesi Selatan dengan kombinasi warna hitam dan merah bata yang tegas.',
                'price'       => 245000,
                'category'    => 'fashion',
                'origin'      => 'Toraja',
                'badges'      => ['Toraja Motif', 'Premium'],
                'rating'      => 4.9,
                'sold'        => 58,
                'umkm_name'   => 'Rumah Tenun Marapu',
                'ar_model_url'=> '/models/tenun_ikat.glb',
            ],
            [
                'name'        => 'Kopiah Songket Melayu Riau',
                'description' => 'Peci / kopiah tradisional Melayu Riau bersulam benang emas dengan motif pucuk rebung klasik yang anggun.',
                'price'       => 75000,
                'category'    => 'aksesoris',
                'origin'      => 'Pekanbaru',
                'badges'      => ['Handmade', 'Melayu Authentic'],
                'rating'      => 4.6,
                'sold'        => 95,
                'umkm_name'   => 'Songket Sriwijaya',
                'ar_model_url'=> '/models/aksesoris_fallback.glb',
            ],
            [
                'name'        => 'Cincin Perak Ukir Bali Sandi',
                'description' => 'Cincin perak sterling 925 dengan pahatan ukiran barong khas Bali, buatan tangan pengrajin perak Celuk.',
                'price'       => 115000,
                'category'    => 'aksesoris',
                'origin'      => 'Bali',
                'badges'      => ['Sterling 925', 'Barong Detail'],
                'rating'      => 4.9,
                'sold'        => 74,
                'umkm_name'   => 'Celuk Silver Art',
                'ar_model_url'=> '/models/gelang_perak.glb',
            ],
            [
                'name'        => 'Taplak Meja Tenun Troso Jepara',
                'description' => 'Taplak meja makan minimalis dengan corak tenun Troso Jepara warna krem natural yang menenangkan.',
                'price'       => 95000,
                'category' => 'dekorasi',
                'origin'      => 'Jepara',
                'badges'      => ['Tenun Troso', 'Krem Natural'],
                'rating'      => 4.5,
                'sold'        => 83,
                'umkm_name'   => 'Cirebon Home Decor',
                'ar_model_url'=> '/models/dekorasi_fallback.glb',
            ],
            [
                'name'        => 'Gantungan Kunci Kulit Tatah',
                'description' => 'Gantungan kunci serbaguna dari kulit sapi asli dengan tatahan motif wayang Gunungan khas Jawa Tengah.',
                'price'       => 35000,
                'category'    => 'aksesoris',
                'origin'      => 'Solo',
                'badges'      => ['Kulit Asli', 'Wayang Detail'],
                'rating'      => 4.8,
                'sold'        => 312,
                'umkm_name'   => 'Jogja Aksesoris Craft',
                'ar_model_url'=> '/models/aksesoris_fallback.glb',
            ],
            [
                'name'        => 'Tas Jinjing Goni Kombinasi Batik',
                'description' => 'Tote bag ramah lingkungan dari serat goni dipadukan dengan aksen kain perca batik Parang di bagian kantong depan.',
                'price'       => 89000,
                'category'    => 'dekorasi',
                'origin'      => 'Yogyakarta',
                'badges'      => ['Eco Friendly', 'Tote Bag'],
                'rating'      => 4.7,
                'sold'        => 148,
                'umkm_name'   => 'Batik Home Living',
                'ar_model_url'=> '/models/dekorasi_fallback.glb',
            ],
            [
                'name'        => 'Dompet Tenun Etnik Nusantara',
                'description' => 'Dompet genggam wanita berukuran sedang dari kombinasi kain tenun Lombok warna-warni yang ceria.',
                'price'       => 55000,
                'category'    => 'aksesoris',
                'origin'      => 'Lombok',
                'badges'      => ['Tenun Lombok', 'Etnik Dompet'],
                'rating'      => 4.8,
                'sold'        => 225,
                'umkm_name'   => 'Tenun Bandar Lestari',
                'ar_model_url'=> '/models/aksesoris_fallback.glb',
            ],
            [
                'name'        => 'Slayer Batik Cap Klasik',
                'description' => 'Slayer / bandana serbaguna dari bahan katun motif batik kawung hitam-putih untuk pelengkap ootd kasual Anda.',
                'price'       => 30000,
                'category'    => 'aksesoris',
                'origin'      => 'Solo',
                'badges'      => ['Bandana', 'Batik Cap'],
                'rating'      => 4.6,
                'sold'        => 410,
                'umkm_name'   => 'Batik Gentong Madura',
                'ar_model_url'=> '/models/aksesoris_fallback.glb',
            ],
        ];

        $demoUser = User::where('email', 'user@snapfit.id')->first();
        $umkmRole = Role::where('name', 'umkm')->first();

        $usedImages = [];

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

            if (str_contains($pName, 'Batik Parang Heritage') || str_contains($pName, 'Bantal Sofa Batik Parang')) {
                $imageName = str_contains($pName, 'Bantal') ? 'bantal_batik.png' : 'batik_parang.png';
            } elseif (str_contains($pName, 'Batik Tulis Lasem')) {
                $imageName = 'batik_lasem.png';
            } elseif (str_contains($pName, 'Batik Mega Mendung') || str_contains($pName, 'Runner Meja')) {
                $imageName = str_contains($pName, 'Runner') ? 'runner_meja.png' : 'batik_megamendung.png';
            } elseif (str_contains($pName, 'Batik Sidomukti')) {
                $imageName = 'batik_sidomukti.png';
            } elseif (str_contains($pName, 'Blouse Batik Kawung')) {
                $imageName = 'blouse_kawung.png';
            } elseif (str_contains($pName, 'Batik Kawung')) {
                $imageName = 'batik_kawung.png';
            } elseif (str_contains($pName, 'Tenun Ikat Sumba')) {
                $imageName = 'tenun_ikat.png';
            } elseif (str_contains($pName, 'Songket Palembang')) {
                $imageName = 'songket_palembang.png';
            } elseif (str_contains($pName, 'Gelang Perak')) {
                $imageName = 'gelang_perak.png';
            } elseif (str_contains($pName, 'Bros Kebaya')) {
                $imageName = 'bros_kebaya.png';
            } elseif (str_contains($pName, 'Batik Serat Jati')) {
                $imageName = 'batik_madiun.png';
            } elseif (str_contains($pName, 'Tenun Ikat Bandar')) {
                $imageName = 'tenun_kediri.png';
            } elseif (str_contains($pName, 'Batik Papua')) {
                $imageName = 'batik_papua.png';
            } elseif (str_contains($pName, 'Batik Gentongan')) {
                $imageName = 'batik_madura.png';
            } elseif (str_contains($pName, 'Kebaya Kutubaru')) {
                $imageName = 'kebaya_kutubaru.png';
            } elseif (str_contains($pName, 'Surjan Lurik')) {
                $imageName = 'surjan_lurik.png';
            } elseif (str_contains($pName, 'Sasirangan Banjar')) {
                $imageName = 'sasirangan_banjar.png';
            } elseif (str_contains($pName, 'Baju Kurung Basiba')) {
                $imageName = 'kurung_basiba.png';
            } elseif (str_contains($pName, 'Batik Pekalongan')) {
                $imageName = 'batik_pekalongan.png';
            } elseif (str_contains($pName, 'Tenun Toraja')) {
                $imageName = 'tenun_toraja.png';
            } elseif (str_contains($pName, 'Kopiah Songket')) {
                $imageName = 'peci_songket.png';
            } elseif (str_contains($pName, 'Cincin Perak')) {
                $imageName = 'cincin_perak.png';
            } elseif (str_contains($pName, 'Taplak Meja Tenun')) {
                $imageName = 'taplak_troso.png';
            } elseif (str_contains($pName, 'Gantungan Kunci Kulit')) {
                $imageName = 'gantungan_kulit.png';
            } elseif (str_contains($pName, 'Tas Jinjing Goni')) {
                $imageName = 'tas_goni.png';
            } elseif (str_contains($pName, 'Dompet Tenun')) {
                $imageName = 'dompet_tenun.png';
            } elseif (str_contains($pName, 'Slayer Batik Cap')) {
                $imageName = 'slayer_kawung.png';
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

            // Ensure no duplicate image is used
            if (in_array($imageName, $usedImages)) {
                throw new \Exception("Duplicate product image detected: '{$imageName}' for product '{$pName}'. Each product must have a unique image.");
            }
            $usedImages[] = $imageName;

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

        // Seed completed orders for all users on all products, so they can submit reviews
        $allUsers = User::all();
        $allProducts = Product::all();
        foreach ($allUsers as $user) {
            foreach ($allProducts as $prod) {
                $order = \App\Models\Order::create([
                    'buyer_id' => $user->id,
                    'midtrans_order_id' => 'SF-' . date('Ymd') . '-' . sprintf("%04d", $user->id) . '-' . sprintf("%03d", $prod->id) . '-' . substr(uniqid(), -4),
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
