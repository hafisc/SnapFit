<?php

namespace Database\Seeders;

use App\Models\CocreateRoom;
use App\Models\Notification;
use App\Models\RoomParticipant;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            ProductSeeder::class,
        ]);

        // Seed CoCreate Room demo
        $umkm     = User::whereHas('roles', function($q) { $q->where('name', 'umkm'); })->first();
        $desainer = User::whereHas('roles', function($q) { $q->where('name', 'designer'); })->first();

        if ($umkm && $desainer) {
            $room = CocreateRoom::updateOrCreate(
                ['name' => 'Kolaborasi Batik x Modern Design'],
                [
                    'name'        => 'Kolaborasi Batik x Modern Design',
                    'creator_id'  => $umkm->id,
                    'description' => 'Room kolaborasi antara UMKM batik Malang dengan desainer modern untuk menciptakan produk fashion baru.',
                    'status'      => 'active',
                ]
            );

            RoomParticipant::updateOrCreate(
                ['room_id' => $room->id, 'user_id' => $umkm->id],
                ['joined_at' => now()]
            );

            RoomParticipant::updateOrCreate(
                ['room_id' => $room->id, 'user_id' => $desainer->id],
                ['joined_at' => now()]
            );

            $this->command->info('✅ CoCreate Room demo seeded.');
        }

        // Seed Notifikasi demo
        $allUsers = User::all();
        foreach ($allUsers as $user) {
            Notification::updateOrCreate(
                ['user_id' => $user->id, 'title' => 'Selamat datang di KreatiLink!'],
                [
                    'user_id' => $user->id,
                    'title'   => 'Selamat datang di KreatiLink!',
                    'message' => "Halo {$user->name}, selamat bergabung di platform UMKM kreatif Malang. Mulai eksplorasi fitur-fitur unggulan kami!",
                    'is_read' => false,
                ]
            );
        }

        $this->command->info('✅ Notifications seeded.');
        $this->command->newLine();
        $this->command->info('🎉 Demo credentials:');
        $this->command->table(
            ['Role', 'Email', 'Password'],
            [
                ['Admin',   'admin@snapfit.id',   'password123'],
                ['User (Buyer, UMKM, Designer)',    'user@snapfit.id',     'password123'],
            ]
        );
    }
}
