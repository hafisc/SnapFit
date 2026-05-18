<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Role;
use App\Models\RoleApplication;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class VerifiedUserSeeder extends Seeder
{
    public function run(): void
    {
        // Create user
        $user = User::create([
            'name' => 'Rina Kartika',
            'email' => 'rina@snapfit.id',
            'password' => Hash::make('password123'),
            'active_role' => 'buyer',
        ]);

        // Create profile
        $user->profile()->create([
            'full_name' => 'Rina Kartika',
            'address' => 'Jl. Malioboro No. 45, Yogyakarta',
            'phone' => '081234567890',
        ]);

        // Assign roles
        $buyerRole = Role::where('name', 'buyer')->first();
        $umkmRole = Role::where('name', 'umkm')->first();
        $designerRole = Role::where('name', 'designer')->first();

        $user->roles()->attach([$buyerRole->id, $umkmRole->id, $designerRole->id]);

        // Create approved UMKM application
        RoleApplication::create([
            'user_id' => $user->id,
            'requested_role' => 'umkm',
            'status' => 'approved',
            'data' => [
                'store_name' => 'Batik Kartika Yogya',
                'owner_name' => 'Rina Kartika',
                'category' => 'Batik & Tenun',
                'origin_city' => 'Yogyakarta',
                'address' => 'Jl. Malioboro No. 45, Yogyakarta',
                'whatsapp' => '081234567890',
                'description' => 'Batik Kartika Yogya adalah UMKM yang memproduksi batik tulis dan cap khas Yogyakarta dengan motif kontemporer yang memadukan tradisi dan modernitas. Kami menggunakan pewarna alami dari tumbuhan lokal.',
                'brand_story' => 'Dimulai dari garasi rumah nenek pada tahun 2018, kini Batik Kartika telah melayani lebih dari 500 pelanggan di seluruh Indonesia.',
                'instagram' => '@batikkartikayogya',
            ],
            'ai_score' => 92,
            'ai_summary' => 'Data UMKM sangat lengkap dan sesuai dengan konsep produk kreatif lokal SnapFit. Deskripsi usaha detail dan kategori sesuai.',
            'ai_issues' => [],
            'ai_recommendations' => ['Tambahkan foto produk dengan pencahayaan studio untuk katalog yang lebih profesional.'],
            'ai_result' => [
                'status' => 'approved',
                'score' => 92,
                'summary' => 'Data UMKM sangat lengkap dan sesuai dengan konsep produk kreatif lokal SnapFit.',
                'issues' => [],
                'recommendations' => ['Tambahkan foto produk dengan pencahayaan studio untuk katalog yang lebih profesional.'],
            ],
            'submitted_at' => now()->subDays(3),
            'ai_verified_at' => now()->subDays(3),
        ]);

        // Create approved Designer application
        RoleApplication::create([
            'user_id' => $user->id,
            'requested_role' => 'designer',
            'status' => 'approved',
            'data' => [
                'display_name' => 'Rina Design Studio',
                'city' => 'Yogyakarta',
                'skills' => ['Branding', 'Packaging Design', 'Social Media Design'],
                'bio' => 'Designer kreatif dengan fokus pada branding dan packaging untuk UMKM lokal Indonesia. Berpengalaman 4 tahun membantu lebih dari 50 UMKM membangun identitas visual yang kuat.',
                'experience' => 'Freelance designer sejak 2022. Pernah bekerja sama dengan Dinas UMKM DIY untuk program digitalisasi branding UMKM.',
                'portfolio_url' => 'https://behance.net/rinakartika',
                'tools' => ['Adobe Illustrator', 'Figma', 'Canva', 'Adobe Photoshop'],
                'collaboration_interest' => 'Branding UMKM, Packaging Design, Social Media Content',
                'whatsapp' => '081234567890',
                'rate' => 'Mulai dari Rp 500.000 / project',
            ],
            'ai_score' => 88,
            'ai_summary' => 'Profil designer lengkap dengan fokus pada branding dan packaging design. Pengalaman relevan dengan kebutuhan UMKM di SnapFit.',
            'ai_issues' => [],
            'ai_recommendations' => ['Tambahkan minimal 3 contoh karya untuk meningkatkan kredibilitas.'],
            'ai_result' => [
                'status' => 'approved',
                'score' => 88,
                'summary' => 'Profil designer lengkap dengan fokus pada branding dan packaging design.',
                'skills_detected' => ['Branding', 'Packaging Design', 'Social Media Design'],
                'issues' => [],
                'recommendations' => ['Tambahkan minimal 3 contoh karya untuk meningkatkan kredibilitas.'],
            ],
            'submitted_at' => now()->subDays(2),
            'ai_verified_at' => now()->subDays(2),
        ]);

        $this->command->info("User created: rina@snapfit.id / password123");
        $this->command->info("Roles: buyer, umkm, designer (all verified)");
    }
}
