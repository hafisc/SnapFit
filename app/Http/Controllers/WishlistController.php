<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductResource;
use App\Models\Wishlist;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class WishlistController extends Controller
{
    /**
     * List semua produk di wishlist user.
     */
    public function index(Request $request): JsonResponse
    {
        $wishlists = $request->user()
            ->wishlists()
            ->with('product.owner.profile')
            ->latest()
            ->paginate(12);

        return response()->json([
            'data'       => $wishlists->map(fn($w) => new ProductResource($w->product)),
            'total'      => $wishlists->total(),
            'pagination' => [
                'total'        => $wishlists->total(),
                'current_page' => $wishlists->currentPage(),
                'last_page'    => $wishlists->lastPage(),
            ],
        ]);
    }

    /**
     * Toggle wishlist — tambah jika belum ada, hapus jika sudah ada.
     */
    public function toggle(Request $request, int $productId): JsonResponse
    {
        $existing = Wishlist::where('user_id', $request->user()->id)
            ->where('product_id', $productId)
            ->first();

        if ($existing) {
            $existing->delete();
            return response()->json([
                'message'       => 'Produk dihapus dari wishlist.',
                'wishlisted'    => false,
                'product_id'    => $productId,
            ]);
        }

        Wishlist::create([
            'user_id'    => $request->user()->id,
            'product_id' => $productId,
        ]);

        return response()->json([
            'message'    => 'Produk ditambahkan ke wishlist.',
            'wishlisted' => true,
            'product_id' => $productId,
        ], 201);
    }

    /**
     * Cek apakah sebuah produk ada di wishlist user.
     */
    public function check(Request $request, int $productId): JsonResponse
    {
        $wishlisted = Wishlist::where('user_id', $request->user()->id)
            ->where('product_id', $productId)
            ->exists();

        return response()->json([
            'product_id' => $productId,
            'wishlisted' => $wishlisted,
        ]);
    }

    /**
     * Hapus semua wishlist user (clear all).
     */
    public function clearAll(Request $request): JsonResponse
    {
        $count = $request->user()->wishlists()->count();
        $request->user()->wishlists()->delete();

        return response()->json([
            'message' => "{$count} produk dihapus dari wishlist.",
        ]);
    }
}
