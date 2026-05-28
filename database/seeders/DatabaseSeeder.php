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
        $batavia = User::where('email', 'user@snapfit.id')->first();
        
        if ($batavia) {
            // Find other users to act as partners (excluding Batavia and admin)
            $otherUsers = User::where('id', '!=', $batavia->id)
                ->whereHas('roles', function($q) {
                    $q->whereIn('name', ['umkm', 'designer']);
                })
                ->get();

            $partner1 = $otherUsers->get(0);
            $partner2 = $otherUsers->get(1);

            // 1. Seed Active Room (Kolaborasi Batik x Modern Design)
            if ($partner1) {
                $room1 = CocreateRoom::updateOrCreate(
                    ['name' => 'Kolaborasi Batik x Modern Design'],
                    [
                        'name'        => 'Kolaborasi Batik x Modern Design',
                        'creator_id'  => $partner1->id,
                        'description' => 'Room kolaborasi antara UMKM batik Malang dengan desainer modern untuk menciptakan produk fashion baru.',
                        'status'      => 'active',
                    ]
                );

                RoomParticipant::updateOrCreate(
                    ['room_id' => $room1->id, 'user_id' => $partner1->id],
                    ['joined_at' => now()]
                );

                RoomParticipant::updateOrCreate(
                    ['room_id' => $room1->id, 'user_id' => $batavia->id],
                    ['joined_at' => now()]
                );
            }

            if ($partner2) {
                $room2 = CocreateRoom::updateOrCreate(
                    ['name' => 'Kolaborasi Furnitur Rotan Estetik'],
                    [
                        'name'        => 'Kolaborasi Furnitur Rotan Estetik',
                        'creator_id'  => $partner2->id,
                        'description' => 'Mendesain ulang katalog visual furnitur anyaman rotan untuk pasar ekspor Eropa.',
                        'status'      => 'active',
                    ]
                );

                RoomParticipant::updateOrCreate(
                    ['room_id' => $room2->id, 'user_id' => $partner2->id],
                    ['joined_at' => now()]
                );

                RoomParticipant::updateOrCreate(
                    ['room_id' => $room2->id, 'user_id' => $batavia->id],
                    ['joined_at' => now()]
                );
            }

            // 2. Seed Incoming Pending Invitations (Undangan Masuk)
            if ($partner1) {
                $incomingRoom1 = CocreateRoom::updateOrCreate(
                    ['name' => 'Redesign Label & Packaging Batik Tulis'],
                    [
                        'name'            => 'Redesign Label & Packaging Batik Tulis',
                        'creator_id'      => $partner1->id,
                        'invited_user_id' => $batavia->id,
                        'description'     => 'Kami mencari masukan desainer untuk menyesuaikan motif parang klasik agar cocok dipadukan dengan kaos streetwear anak muda.',
                        'status'          => 'pending',
                    ]
                );

                RoomParticipant::updateOrCreate(
                    ['room_id' => $incomingRoom1->id, 'user_id' => $partner1->id],
                    ['joined_at' => now()]
                );
            }

            if ($partner2) {
                $incomingRoom2 = CocreateRoom::updateOrCreate(
                    ['name' => 'Branding Identity & Catalog Design'],
                    [
                        'name'            => 'Branding Identity & Catalog Design',
                        'creator_id'      => $partner2->id,
                        'invited_user_id' => $batavia->id,
                        'description'     => 'Kami mencari konsep kemasan premium eco-friendly untuk produk anyaman rotan.',
                        'status'          => 'pending',
                    ]
                );

                RoomParticipant::updateOrCreate(
                    ['room_id' => $incomingRoom2->id, 'user_id' => $partner2->id],
                    ['joined_at' => now()]
                );
            }

            // 3. Seed Outgoing Pending Invitation (Permintaan Dikirim)
            if ($partner2) {
                $outgoingRoom = CocreateRoom::updateOrCreate(
                    ['name' => 'Redesain Kemasan & Branding Sutra'],
                    [
                        'name'            => 'Redesain Kemasan & Branding Sutra',
                        'creator_id'      => $batavia->id,
                        'invited_user_id' => $partner2->id,
                        'description'     => 'Mengembangkan konsep kemasan premium eco-friendly untuk produk kain songket dan sutra tulis.',
                        'status'          => 'pending',
                    ]
                );

                RoomParticipant::updateOrCreate(
                    ['room_id' => $outgoingRoom->id, 'user_id' => $batavia->id],
                    ['joined_at' => now()]
                );
            }

            $this->command->info('✅ CoCreate Rooms & Invitations demo seeded.');
        }

        // Seed Notifikasi demo
        $allUsers = User::all();
        foreach ($allUsers as $user) {
            Notification::updateOrCreate(
                ['user_id' => $user->id, 'title' => 'Selamat datang di SnapFit!'],
                [
                    'user_id' => $user->id,
                    'title'   => 'Selamat datang di SnapFit!',
                    'message' => "Halo {$user->name}, selamat bergabung di platform UMKM kreatif Indonesia. Mulai eksplorasi fitur-fitur unggulan kami!",
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
