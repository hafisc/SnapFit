<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $umkmUsers = User::where('role', 'umkm')->get();

        if ($umkmUsers->isEmpty()) {
            $this->command->warn('Tidak ada user UMKM. Jalankan UserSeeder dulu.');
            return;
        }

        $products = [
            // BATIK
            [
                'name'        => 'Kain Batik Tulis Motif Kawung',
                'description' => 'Batik tulis asli motif Kawung, dikerjakan secara manual oleh pengrajin. Cocok untuk seragam dan acara resmi.',
                'price'       => 450000,
                'category'    => 'batik',
                'images'      => ['/images/baju_batik_pria.png'],
                'is_published' => true,
            ],
            [
                'name'        => 'Kain Batik Cap Parang Rusak',
                'description' => 'Batik cap berkualitas tinggi dengan motif legendaris Parang Rusak. Material katun primisima premium.',
                'price'       => 215000,
                'category'    => 'batik',
                'images'      => ['/images/baju_batik_pria.png'],
                'is_published' => true,
            ],
            [
                'name'        => 'Batik Tulis Lasem Tiga Negeri',
                'description' => 'Kain batik pesisir Lasem motif tiga negeri dengan perpaduan warna yang sangat menawan dan detail.',
                'price'       => 850000,
                'category'    => 'batik',
                'images'      => ['/images/baju_batik_pria.png'],
                'is_published' => true,
            ],
            [
                'name'        => 'Kain Batik Motif Megamendung',
                'description' => 'Batik motif khas Cirebon Megamendung dengan warna biru gradasi yang elegan dan modern.',
                'price'       => 275000,
                'category'    => 'batik',
                'images'      => ['/images/baju_batik_pria.png'],
                'is_published' => true,
            ],
            [
                'name'        => 'Batik Tulis Klasik Solo',
                'description' => 'Batik klasik Solo dengan pewarnaan soga alam yang khas, memancarkan aura keraton yang anggun.',
                'price'       => 650000,
                'category'    => 'batik',
                'images'      => ['/images/baju_batik_pria.png'],
                'is_published' => true,
            ],
            
            // KERAJINAN
            [
                'name'        => 'Tas Anyaman Rotan Bali Natural',
                'description' => 'Tas rotan handmade asli Bali. Tahan lama, estetik, dan cocok untuk liburan atau OOTD.',
                'price'       => 150000,
                'category'    => 'kerajinan',
                'images'      => ['/images/baju_batik_pria.png'],
                'is_published' => true,
            ],
            [
                'name'        => 'Keranjang Bambu Estetik Multiguna',
                'description' => 'Keranjang anyaman bambu kokoh untuk laundry, pot tanaman, atau dekorasi sudut ruang.',
                'price'       => 85000,
                'category'    => 'kerajinan',
                'images'      => ['/images/baju_batik_pria.png'],
                'is_published' => true,
            ],
            [
                'name'        => 'Topi Anyaman Pandan Klasik',
                'description' => 'Topi lebar dari daun pandan asli, nyaman dipakai ke pantai atau berkebun.',
                'price'       => 45000,
                'category'    => 'kerajinan',
                'images'      => ['/images/baju_batik_pria.png'],
                'is_published' => true,
            ],
            [
                'name'        => 'Tikar Tenun Lontar Asli',
                'description' => 'Tikar lontar tenun tangan, sangat sejuk saat digunakan dan memberikan nuansa tropis yang elegan.',
                'price'       => 195000,
                'category'    => 'kerajinan',
                'images'      => ['/images/baju_batik_pria.png'],
                'is_published' => true,
            ],

            // AKSESORIS
            [
                'name'        => 'Gelang Kayu Kokka Asli',
                'description' => 'Gelang terbuat dari kayu Kokka berkualitas tinggi. Desain minimalis dan tahan lama.',
                'price'       => 35000,
                'category'    => 'aksesoris',
                'images'      => ['/images/baju_batik_pria.png'],
                'is_published' => true,
            ],
            [
                'name'        => 'Kalung Etnik Batu Alam',
                'description' => 'Kalung dengan liontin batu alam berbalut perak khas pengrajin perak Kotagede.',
                'price'       => 125000,
                'category'    => 'aksesoris',
                'images'      => ['/images/baju_batik_pria.png'],
                'is_published' => true,
            ],
            [
                'name'        => 'Bros Kebaya Motif Kupu-kupu',
                'description' => 'Bros tembaga lapis emas dengan detail permata zirconia, sangat cocok untuk kebaya kutubaru.',
                'price'       => 95000,
                'category'    => 'aksesoris',
                'images'      => ['/images/baju_batik_pria.png'],
                'is_published' => true,
            ],
            [
                'name'        => 'Cincin Perak Ukir Tradisional',
                'description' => 'Cincin perak 925 dengan ukiran motif Majapahit, tebal dan tidak mudah pudar.',
                'price'       => 185000,
                'category'    => 'aksesoris',
                'images'      => ['/images/baju_batik_pria.png'],
                'is_published' => true,
            ],

            // DEKORASI
            [
                'name'        => 'Pajangan Kayu Ukir Jepara',
                'description' => 'Ukiran dinding kayu jati dari Jepara motif daun merambat, memberikan kesan hangat di ruangan.',
                'price'       => 450000,
                'category'    => 'dekorasi',
                'images'      => ['/images/baju_batik_pria.png'],
                'is_published' => true,
            ],
            [
                'name'        => 'Guci Keramik Tanah Liat Kasongan',
                'description' => 'Guci keramik besar dari pengrajin Kasongan, dengan sentuhan warna terakota alami yang estetik.',
                'price'       => 320000,
                'category'    => 'dekorasi',
                'images'      => ['/images/baju_batik_pria.png'],
                'is_published' => true,
            ],
            [
                'name'        => 'Lampu Gantung Anyaman Bambu',
                'description' => 'Kap lampu gantung bergaya rustic dari anyaman bambu, membuat cahaya ruangan lebih dramatis.',
                'price'       => 175000,
                'category'    => 'dekorasi',
                'images'      => ['/images/baju_batik_pria.png'],
                'is_published' => true,
            ],
            [
                'name'        => 'Taplak Meja Tenun Jepara',
                'description' => 'Taplak meja bahan tenun asli Troso Jepara. Menambah nilai estetika ruang tamu atau meja makan.',
                'price'       => 110000,
                'category'    => 'dekorasi',
                'images'      => ['/images/baju_batik_pria.png'],
                'is_published' => true,
            ],

            // FASHION
            [
                'name'        => 'Kemeja Batik Pria Slim Fit',
                'description' => 'Kemeja lengan pendek bahan katun adem, motif modern slim fit. Pas untuk ke kantor atau kasual.',
                'price'       => 225000,
                'category'    => 'fashion',
                'images'      => ['/images/baju_batik_pria.png'],
                'is_published' => true,
            ],
            [
                'name'        => 'Outer Tenun Ikat Etnik',
                'description' => 'Outer/kardigan cantik berbahan kain tenun ikat NTT. Desain open front yang sangat stylish.',
                'price'       => 315000,
                'category'    => 'fashion',
                'images'      => ['/images/baju_batik_pria.png'],
                'is_published' => true,
            ],
            [
                'name'        => 'Dress Batik Modern Wanita',
                'description' => 'Gaun midi batik motif cap dengan resleting belakang. Bahan jatuh dan anti kusut.',
                'price'       => 285000,
                'category'    => 'fashion',
                'images'      => ['/images/baju_batik_pria.png'],
                'is_published' => true,
            ],
            [
                'name'        => 'Celana Kulot Batik Lasem',
                'description' => 'Kulot panjang katun dengan motif batik Lasem merah cerah, dilengkapi pinggang karet elastis.',
                'price'       => 150000,
                'category'    => 'fashion',
                'images'      => ['/images/baju_batik_pria.png'],
                'is_published' => true,
            ],
            [
                'name'        => 'Selendang Tenun Sutra',
                'description' => 'Selendang berbahan sutra asli dengan corak songket eksklusif. Halus dan berkilau mewah.',
                'price'       => 750000,
                'category'    => 'fashion',
                'images'      => ['/images/baju_batik_pria.png'],
                'is_published' => true,
            ],
            [
                'name'        => 'Tas Tote Bag Tenun Etnik',
                'description' => 'Tote bag kokoh dengan jahitan rapi, full tenun blanket. Cocok untuk kuliah atau jalan-jalan.',
                'price'       => 135000,
                'category'    => 'fashion',
                'images'      => ['/images/baju_batik_pria.png'],
                'is_published' => true,
            ],
            
            // DRAFTS
            [
                'name'        => 'Draft Produk (Belum Dipublikasi)',
                'description' => 'Produk yang masih dalam tahap pengembangan.',
                'price'       => 99000,
                'category'    => 'kerajinan',
                'images'      => [],
                'is_published' => false,
            ],
        ];

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

        foreach ($products as $index => $data) {
            Product::updateOrCreate(
                ['name' => $data['name']],
                array_merge($data, [
                    'user_id' => $umkmIds[$index % count($umkmIds)],
                ])
            );
        }

        $this->command->info('✅ Products seeded (' . count($products) . ' produk).');
    }
}
