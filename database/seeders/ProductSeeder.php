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
            [
                'name'        => 'Batik Tulis Motif Arema',
                'description' => 'Batik tulis asli Malang dengan motif Arema, dikerjakan secara manual oleh pengrajin berpengalaman. Cocok untuk kemeja dan dress.',
                'price'       => 350000,
                'category'    => 'batik',
                'images'      => [
                    'https://picsum.photos/seed/batik1/600/600',
                    'https://picsum.photos/seed/batik2/600/600',
                ],
                'is_published' => true,
            ],
            [
                'name'        => 'Batik Cap Bunga Malang',
                'description' => 'Batik cap premium dengan motif bunga khas Kota Malang. Material katun premium, nyaman dipakai sehari-hari.',
                'price'       => 185000,
                'category'    => 'batik',
                'images'      => ['https://picsum.photos/seed/batik3/600/600'],
                'is_published' => true,
            ],
            [
                'name'        => 'Tas Anyaman Rotan Natural',
                'description' => 'Tas anyaman rotan handmade, tahan lama dan ramah lingkungan. Tersedia dalam berbagai ukuran.',
                'price'       => 275000,
                'category'    => 'kerajinan',
                'images'      => [
                    'https://picsum.photos/seed/rotan1/600/600',
                    'https://picsum.photos/seed/rotan2/600/600',
                ],
                'is_published' => true,
            ],
            [
                'name'        => 'Aksesoris Gelang Batik',
                'description' => 'Gelang cantik bermotif batik, dibuat dari kain batik tulis asli Malang. Cocok sebagai oleh-oleh.',
                'price'       => 45000,
                'category'    => 'aksesoris',
                'images'      => ['https://picsum.photos/seed/aksesoris1/600/600'],
                'is_published' => true,
            ],
            [
                'name'        => 'Miniatur Candi dari Kayu',
                'description' => 'Miniatur candi khas Malang dibuat dari kayu jati pilihan, detail tinggi, cocok untuk dekorasi meja.',
                'price'       => 120000,
                'category'    => 'dekorasi',
                'images'      => ['https://picsum.photos/seed/dekorasi1/600/600'],
                'is_published' => true,
            ],
            [
                'name'        => 'Kemeja Batik Modern Slim Fit',
                'description' => 'Kemeja batik dengan potongan modern slim fit. Memadukan motif batik tradisional dengan desain kontemporer.',
                'price'       => 420000,
                'category'    => 'fashion',
                'images'      => [
                    'https://picsum.photos/seed/fashion1/600/600',
                    'https://picsum.photos/seed/fashion2/600/600',
                ],
                'is_published' => true,
            ],
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
