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
                'images'      => ['https://images.unsplash.com/photo-1588615419958-3dc10b938f29?q=80&w=800'],
                'is_published' => true,
            ],
            [
                'name'        => 'Kain Batik Cap Parang Rusak',
                'description' => 'Batik cap berkualitas tinggi dengan motif legendaris Parang Rusak. Material katun primisima premium.',
                'price'       => 215000,
                'category'    => 'batik',
                'images'      => ['https://images.unsplash.com/photo-1620803451556-9e8c0dbabcfc?q=80&w=800'],
                'is_published' => true,
            ],
            [
                'name'        => 'Batik Tulis Lasem Tiga Negeri',
                'description' => 'Kain batik pesisir Lasem motif tiga negeri dengan perpaduan warna yang sangat menawan dan detail.',
                'price'       => 850000,
                'category'    => 'batik',
                'images'      => ['https://images.unsplash.com/photo-1596484552834-6a58f8682a89?q=80&w=800'],
                'is_published' => true,
            ],
            [
                'name'        => 'Kain Batik Motif Megamendung',
                'description' => 'Batik motif khas Cirebon Megamendung dengan warna biru gradasi yang elegan dan modern.',
                'price'       => 275000,
                'category'    => 'batik',
                'images'      => ['https://images.unsplash.com/photo-1580922881263-2b2dfa4e094f?q=80&w=800'],
                'is_published' => true,
            ],
            [
                'name'        => 'Batik Tulis Klasik Solo',
                'description' => 'Batik klasik Solo dengan pewarnaan soga alam yang khas, memancarkan aura keraton yang anggun.',
                'price'       => 650000,
                'category'    => 'batik',
                'images'      => ['https://images.unsplash.com/photo-1598282381274-12af90ebf1a3?q=80&w=800'],
                'is_published' => true,
            ],
            
            // KERAJINAN
            [
                'name'        => 'Tas Anyaman Rotan Bali Natural',
                'description' => 'Tas rotan handmade asli Bali. Tahan lama, estetik, dan cocok untuk liburan atau OOTD.',
                'price'       => 150000,
                'category'    => 'kerajinan',
                'images'      => ['https://images.unsplash.com/photo-1605808360022-d04b121fb656?q=80&w=800'],
                'is_published' => true,
            ],
            [
                'name'        => 'Keranjang Bambu Estetik Multiguna',
                'description' => 'Keranjang anyaman bambu kokoh untuk laundry, pot tanaman, atau dekorasi sudut ruang.',
                'price'       => 85000,
                'category'    => 'kerajinan',
                'images'      => ['https://images.unsplash.com/photo-1621379468087-9b22a0a38b1d?q=80&w=800'],
                'is_published' => true,
            ],
            [
                'name'        => 'Topi Anyaman Pandan Klasik',
                'description' => 'Topi lebar dari daun pandan asli, nyaman dipakai ke pantai atau berkebun.',
                'price'       => 45000,
                'category'    => 'kerajinan',
                'images'      => ['https://images.unsplash.com/photo-1514327605112-b887c0e61c0a?q=80&w=800'],
                'is_published' => true,
            ],
            [
                'name'        => 'Tikar Tenun Lontar Asli',
                'description' => 'Tikar lontar tenun tangan, sangat sejuk saat digunakan dan memberikan nuansa tropis yang elegan.',
                'price'       => 195000,
                'category'    => 'kerajinan',
                'images'      => ['https://images.unsplash.com/photo-1623062837330-8d542d99d9ed?q=80&w=800'],
                'is_published' => true,
            ],

            // AKSESORIS
            [
                'name'        => 'Gelang Kayu Kokka Asli',
                'description' => 'Gelang terbuat dari kayu Kokka berkualitas tinggi. Desain minimalis dan tahan lama.',
                'price'       => 35000,
                'category'    => 'aksesoris',
                'images'      => ['https://images.unsplash.com/photo-1611591437281-460bfbe1220a?q=80&w=800'],
                'is_published' => true,
            ],
            [
                'name'        => 'Kalung Etnik Batu Alam',
                'description' => 'Kalung dengan liontin batu alam berbalut perak khas pengrajin perak Kotagede.',
                'price'       => 125000,
                'category'    => 'aksesoris',
                'images'      => ['https://images.unsplash.com/photo-1599643478514-4a110185908b?q=80&w=800'],
                'is_published' => true,
            ],
            [
                'name'        => 'Bros Kebaya Motif Kupu-kupu',
                'description' => 'Bros tembaga lapis emas dengan detail permata zirconia, sangat cocok untuk kebaya kutubaru.',
                'price'       => 95000,
                'category'    => 'aksesoris',
                'images'      => ['https://images.unsplash.com/photo-1535632066927-ab7c9ab60908?q=80&w=800'],
                'is_published' => true,
            ],
            [
                'name'        => 'Cincin Perak Ukir Tradisional',
                'description' => 'Cincin perak 925 dengan ukiran motif Majapahit, tebal dan tidak mudah pudar.',
                'price'       => 185000,
                'category'    => 'aksesoris',
                'images'      => ['https://images.unsplash.com/photo-1605100804763-247f67b2548e?q=80&w=800'],
                'is_published' => true,
            ],

            // DEKORASI
            [
                'name'        => 'Pajangan Kayu Ukir Jepara',
                'description' => 'Ukiran dinding kayu jati dari Jepara motif daun merambat, memberikan kesan hangat di ruangan.',
                'price'       => 450000,
                'category'    => 'dekorasi',
                'images'      => ['https://images.unsplash.com/photo-1600171694924-4d8cc382d615?q=80&w=800'],
                'is_published' => true,
            ],
            [
                'name'        => 'Guci Keramik Tanah Liat Kasongan',
                'description' => 'Guci keramik besar dari pengrajin Kasongan, dengan sentuhan warna terakota alami yang estetik.',
                'price'       => 320000,
                'category'    => 'dekorasi',
                'images'      => ['https://images.unsplash.com/photo-1610701596007-11502861dcfa?q=80&w=800'],
                'is_published' => true,
            ],
            [
                'name'        => 'Lampu Gantung Anyaman Bambu',
                'description' => 'Kap lampu gantung bergaya rustic dari anyaman bambu, membuat cahaya ruangan lebih dramatis.',
                'price'       => 175000,
                'category'    => 'dekorasi',
                'images'      => ['https://images.unsplash.com/photo-1513519245088-0e12902e5a38?q=80&w=800'],
                'is_published' => true,
            ],
            [
                'name'        => 'Taplak Meja Tenun Jepara',
                'description' => 'Taplak meja bahan tenun asli Troso Jepara. Menambah nilai estetika ruang tamu atau meja makan.',
                'price'       => 110000,
                'category'    => 'dekorasi',
                'images'      => ['https://images.unsplash.com/photo-1558591710-4b4a1ae0f04d?q=80&w=800'],
                'is_published' => true,
            ],

            // FASHION
            [
                'name'        => 'Kemeja Batik Pria Slim Fit',
                'description' => 'Kemeja lengan pendek bahan katun adem, motif modern slim fit. Pas untuk ke kantor atau kasual.',
                'price'       => 225000,
                'category'    => 'fashion',
                'images'      => ['https://images.unsplash.com/photo-1593030103066-0093718efeb9?q=80&w=800'],
                'is_published' => true,
            ],
            [
                'name'        => 'Outer Tenun Ikat Etnik',
                'description' => 'Outer/kardigan cantik berbahan kain tenun ikat NTT. Desain open front yang sangat stylish.',
                'price'       => 315000,
                'category'    => 'fashion',
                'images'      => ['https://images.unsplash.com/photo-1520011557088-7e3f898a964f?q=80&w=800'],
                'is_published' => true,
            ],
            [
                'name'        => 'Dress Batik Modern Wanita',
                'description' => 'Gaun midi batik motif cap dengan resleting belakang. Bahan jatuh dan anti kusut.',
                'price'       => 285000,
                'category'    => 'fashion',
                'images'      => ['https://images.unsplash.com/photo-1550614000-4b95dd2475aa?q=80&w=800'],
                'is_published' => true,
            ],
            [
                'name'        => 'Celana Kulot Batik Lasem',
                'description' => 'Kulot panjang katun dengan motif batik Lasem merah cerah, dilengkapi pinggang karet elastis.',
                'price'       => 150000,
                'category'    => 'fashion',
                'images'      => ['https://images.unsplash.com/photo-1551122114-1e0e470c1bc7?q=80&w=800'],
                'is_published' => true,
            ],
            [
                'name'        => 'Selendang Tenun Sutra',
                'description' => 'Selendang berbahan sutra asli dengan corak songket eksklusif. Halus dan berkilau mewah.',
                'price'       => 750000,
                'category'    => 'fashion',
                'images'      => ['https://images.unsplash.com/photo-1601646272520-2b15e21971d6?q=80&w=800'],
                'is_published' => true,
            ],
            [
                'name'        => 'Tas Tote Bag Tenun Etnik',
                'description' => 'Tote bag kokoh dengan jahitan rapi, full tenun blanket. Cocok untuk kuliah atau jalan-jalan.',
                'price'       => 135000,
                'category'    => 'fashion',
                'images'      => ['https://images.unsplash.com/photo-1591561954557-26941169b49e?q=80&w=800'],
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
