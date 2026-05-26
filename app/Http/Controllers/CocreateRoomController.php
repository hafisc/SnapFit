<?php

namespace App\Http\Controllers;

use App\Http\Requests\CoCreate\StoreRoomRequest;
use App\Http\Resources\CocreateRoomResource;
use App\Models\CocreateRoom;
use App\Models\RoomParticipant;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CocreateRoomController extends Controller
{
    /**
     * List semua room aktif.
     */
    /**
     * List semua room aktif/selesai untuk user saat ini.
     */
    public function index(Request $request): JsonResponse
    {
        $status = $request->query('status', 'active');

        $rooms = CocreateRoom::with(['creator', 'participants.user'])
            ->withCount('participants')
            ->where('status', $status)
            ->whereHas('participants', function ($query) use ($request) {
                $query->where('user_id', $request->user()->id);
            })
            ->latest()
            ->paginate(10);

        return response()->json([
            'data'       => CocreateRoomResource::collection($rooms),
            'pagination' => [
                'total'        => $rooms->total(),
                'current_page' => $rooms->currentPage(),
                'last_page'    => $rooms->lastPage(),
            ],
        ]);
    }

    /**
     * Detail satu room.
     */
    public function show(CocreateRoom $room): JsonResponse
    {
        $room->load(['creator', 'participants.user']);

        return response()->json(['data' => new CocreateRoomResource($room)]);
    }

    /**
     * Buat room baru (UMKM atau Desainer).
     */
    public function store(StoreRoomRequest $request): JsonResponse
    {
        $status = $request->filled('invite_user_id') ? 'pending' : 'active';

        $room = CocreateRoom::create([
            'name'            => $request->name,
            'description'     => $request->description,
            'creator_id'      => $request->user()->id,
            'invited_user_id' => $request->invite_user_id,
            'status'          => $status,
        ]);

        // Creator otomatis jadi partisipan pertama
        RoomParticipant::create([
            'room_id'   => $room->id,
            'user_id'   => $request->user()->id,
            'joined_at' => now(),
        ]);

        // Kirim notifikasi email ke user yang diundang
        if ($status === 'pending' && $room->invited_user_id) {
            $invitedUser = \App\Models\User::find($room->invited_user_id);
            if ($invitedUser) {
                try {
                    $invitedUser->notify(new \App\Notifications\CollaborationInvitedNotification($room));
                } catch (\Exception $e) {
                    \Log::error('Gagal mengirim email undangan kolaborasi: ' . $e->getMessage());
                }
            }
        }

        return response()->json([
            'message' => $status === 'pending'
                ? 'Permintaan kolaborasi berhasil dikirim.'
                : 'Co-Create Room berhasil dibuat.',
            'data'    => new CocreateRoomResource($room->load(['creator', 'participants'])),
        ], 201);
    }

    /**
     * Ambil daftar undangan masuk dan keluar.
     */
    public function invitations(Request $request): JsonResponse
    {
        $user = $request->user();

        $incoming = CocreateRoom::with(['creator'])
            ->where('invited_user_id', $user->id)
            ->where('status', 'pending')
            ->latest()
            ->get();

        $outgoing = CocreateRoom::with(['invitedUser'])
            ->where('creator_id', $user->id)
            ->where('status', 'pending')
            ->latest()
            ->get();

        return response()->json([
            'incoming' => CocreateRoomResource::collection($incoming),
            'outgoing' => CocreateRoomResource::collection($outgoing),
        ]);
    }

    /**
     * Setujui undangan kolaborasi.
     */
    public function accept(Request $request, CocreateRoom $room): JsonResponse
    {
        if ($room->invited_user_id !== $request->user()->id) {
            return response()->json(['message' => 'Anda tidak berhak menyetujui undangan ini.'], 403);
        }

        if ($room->status !== 'pending') {
            return response()->json(['message' => 'Undangan ini sudah tidak aktif atau sudah diproses.'], 422);
        }

        $room->update(['status' => 'active']);

        // Tambahkan user yang diundang ke partisipan
        RoomParticipant::firstOrCreate([
            'room_id' => $room->id,
            'user_id' => $request->user()->id,
        ], [
            'joined_at' => now(),
        ]);

        // Kirim notifikasi email ke pembuat kolaborasi (creator) bahwa undangan telah di-acc
        $creator = $room->creator;
        if ($creator) {
            try {
                $creator->notify(new \App\Notifications\CollaborationAcceptedNotification($room));
            } catch (\Exception $e) {
                \Log::error('Gagal mengirim email persetujuan kolaborasi: ' . $e->getMessage());
            }
        }

        return response()->json([
            'message' => 'Kolaborasi berhasil disetujui.',
            'data'    => new CocreateRoomResource($room->load(['creator', 'participants'])),
        ]);
    }

    /**
     * Tolak atau batalkan undangan kolaborasi.
     */
    public function decline(Request $request, CocreateRoom $room): JsonResponse
    {
        if ($room->invited_user_id !== $request->user()->id && $room->creator_id !== $request->user()->id) {
            return response()->json(['message' => 'Anda tidak berhak menolak atau membatalkan undangan ini.'], 403);
        }

        if ($room->status !== 'pending') {
            return response()->json(['message' => 'Undangan ini sudah tidak aktif atau sudah diproses.'], 422);
        }

        $room->delete();

        return response()->json([
            'message' => 'Kolaborasi berhasil ditolak atau dibatalkan.',
        ]);
    }

    /**
     * Bergabung ke room.
     */
    public function join(Request $request, CocreateRoom $room): JsonResponse
    {
        if ($room->status !== 'active') {
            return response()->json(['message' => 'Room sudah tidak aktif.'], 422);
        }

        $already = RoomParticipant::where('room_id', $room->id)
            ->where('user_id', $request->user()->id)
            ->exists();

        if ($already) {
            return response()->json(['message' => 'Anda sudah bergabung di room ini.'], 200);
        }

        RoomParticipant::create([
            'room_id'   => $room->id,
            'user_id'   => $request->user()->id,
            'joined_at' => now(),
        ]);

        return response()->json(['message' => 'Berhasil bergabung ke room.']);
    }

    /**
     * Tutup room (creator atau admin).
     */
    public function close(Request $request, CocreateRoom $room): JsonResponse
    {
        if ($room->creator_id !== $request->user()->id && !$request->user()->isAdmin()) {
            return response()->json(['message' => 'Forbidden.'], 403);
        }

        $room->update(['status' => 'completed']);

        return response()->json(['message' => 'Room telah ditutup.']);
    }

    /**
     * Get messages for a room.
     */
    public function messages(CocreateRoom $room): JsonResponse
    {
        $messages = \App\Models\RoomMessage::with('user')
            ->where('room_id', $room->id)
            ->orderBy('created_at', 'asc')
            ->limit(100)
            ->get();

        return response()->json([
            'data' => $messages->map(fn($m) => [
                'id' => $m->id,
                'user_id' => $m->user_id,
                'message' => $m->message,
                'user' => ['id' => $m->user->id, 'name' => $m->user->name],
                'created_at' => $m->created_at->toDateTimeString(),
            ]),
        ]);
    }

    /**
     * Send a message to a room.
     */
    public function sendMessage(Request $request, CocreateRoom $room): JsonResponse
    {
        $request->validate(['message' => 'required|string|max:1000']);

        $msg = \App\Models\RoomMessage::create([
            'room_id' => $room->id,
            'user_id' => $request->user()->id,
            'message' => $request->message,
        ]);

        return response()->json([
            'data' => [
                'id' => $msg->id,
                'user_id' => $msg->user_id,
                'message' => $msg->message,
                'user' => ['id' => $request->user()->id, 'name' => $request->user()->name],
                'created_at' => $msg->created_at->toDateTimeString(),
            ],
        ], 201);
    }

    /**
     * Get canvas data for a room.
     */
    public function getCanvas(CocreateRoom $room): JsonResponse
    {
        return response()->json([
            'canvas_data' => $room->canvas_data,
            'canvas_updated_at' => $room->canvas_updated_at ? $room->canvas_updated_at->toDateTimeString() : null,
        ]);
    }

    /**
     * Save canvas data for a room.
     */
    public function saveCanvas(Request $request, CocreateRoom $room): JsonResponse
    {
        $request->validate([
            'canvas_data' => 'required|string',
        ]);

        $room->update([
            'canvas_data' => $request->canvas_data,
            'canvas_updated_at' => now(),
        ]);

        return response()->json([
            'message' => 'Kanvas berhasil disimpan.',
            'canvas_updated_at' => $room->canvas_updated_at->toDateTimeString(),
        ]);
    }
}
