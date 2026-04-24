<?php

namespace App\Http\Controllers;

use App\Http\Resources\NotificationResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    /**
     * List notifikasi milik user.
     */
    public function index(Request $request): JsonResponse
    {
        $notifications = $request->user()
            ->notifications()
            ->latest()
            ->paginate(15);

        $unreadCount = $request->user()
            ->notifications()
            ->where('is_read', false)
            ->count();

        return response()->json([
            'data'         => NotificationResource::collection($notifications),
            'unread_count' => $unreadCount,
            'pagination'   => [
                'total'        => $notifications->total(),
                'current_page' => $notifications->currentPage(),
                'last_page'    => $notifications->lastPage(),
            ],
        ]);
    }

    /**
     * Tandai satu notifikasi sebagai dibaca.
     */
    public function markAsRead(Request $request, int $id): JsonResponse
    {
        $notif = $request->user()->notifications()->findOrFail($id);
        $notif->update(['is_read' => true]);

        return response()->json(['message' => 'Notifikasi ditandai dibaca.']);
    }

    /**
     * Tandai semua notifikasi sebagai dibaca.
     */
    public function markAllAsRead(Request $request): JsonResponse
    {
        $request->user()->notifications()->update(['is_read' => true]);

        return response()->json(['message' => 'Semua notifikasi ditandai dibaca.']);
    }
}
