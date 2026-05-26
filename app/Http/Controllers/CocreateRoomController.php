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
