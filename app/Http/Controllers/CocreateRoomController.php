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
    public function index(): JsonResponse
    {
        $rooms = CocreateRoom::with(['creator', 'participants'])
            ->withCount('participants')
            ->where('status', 'active')
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
        $room = CocreateRoom::create([
            'name'        => $request->name,
            'description' => $request->description,
            'creator_id'  => $request->user()->id,
            'status'      => 'active',
        ]);

        // Creator otomatis jadi partisipan pertama
        RoomParticipant::create([
            'room_id'   => $room->id,
            'user_id'   => $request->user()->id,
            'joined_at' => now(),
        ]);

        return response()->json([
            'message' => 'Co-Create Room berhasil dibuat.',
            'data'    => new CocreateRoomResource($room->load('creator')),
        ], 201);
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
}
