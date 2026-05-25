<?php

namespace App\Http\Controllers;

use App\Http\Requests\Review\StoreReviewRequest;
use App\Http\Resources\ReviewResource;
use App\Models\Product;
use App\Models\Review;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReviewController extends Controller
{
    /**
     * List semua review untuk sebuah produk.
     */
    public function index(Product $product): JsonResponse
    {
        $reviews = $product->reviews()
            ->with('user.profile')
            ->latest()
            ->paginate(10);

        $summary = [
            'avg_rating'    => round($product->avg_rating, 1),
            'reviews_count' => $product->reviews_count,
            'distribution'  => Review::where('product_id', $product->id)
                ->selectRaw('rating, count(*) as total')
                ->groupBy('rating')
                ->orderBy('rating', 'desc')
                ->pluck('total', 'rating'),
        ];

        return response()->json([
            'summary'    => $summary,
            'data'       => ReviewResource::collection($reviews),
            'pagination' => [
                'total'        => $reviews->total(),
                'current_page' => $reviews->currentPage(),
                'last_page'    => $reviews->lastPage(),
            ],
        ]);
    }

    /**
     * Buat review baru untuk produk (hanya yang sudah pernah order).
     */
    public function store(StoreReviewRequest $request, Product $product): JsonResponse
    {
        // Validasi: user harus sudah pernah membeli produk ini
        $hasPurchased = DB::table('order_items')
            ->join('orders', 'orders.id', '=', 'order_items.order_id')
            ->where('orders.buyer_id', $request->user()->id)
            ->where('order_items.product_id', $product->id)
            ->where('orders.status', 'completed')
            ->exists();

        if (!$hasPurchased) {
            return response()->json([
                'message' => 'Anda hanya bisa memberikan ulasan setelah membeli dan menerima produk ini.',
            ], 403);
        }

        // Cek sudah pernah review
        $alreadyReviewed = Review::where('user_id', $request->user()->id)
            ->where('product_id', $product->id)
            ->exists();

        if ($alreadyReviewed) {
            return response()->json([
                'message' => 'Anda sudah memberikan ulasan untuk produk ini.',
            ], 422);
        }

        $review = Review::create([
            'user_id'    => $request->user()->id,
            'product_id' => $product->id,
            'rating'     => $request->rating,
            'comment'    => $request->comment,
            'image_url'  => $request->image_url,
        ]);

        // Update avg_rating & reviews_count di tabel products (denormalized)
        $this->updateProductRatingCache($product);

        $review->load('user.profile');

        return response()->json([
            'message' => 'Ulasan berhasil dikirim. Terima kasih!',
            'data'    => new ReviewResource($review),
        ], 201);
    }

    /**
     * Update review milik user.
     */
    public function update(StoreReviewRequest $request, Product $product, Review $review): JsonResponse
    {
        if ($review->user_id !== $request->user()->id) {
            return response()->json(['message' => 'Forbidden.'], 403);
        }

        $review->update([
            'rating'  => $request->rating,
            'comment' => $request->comment,
            'image_url' => $request->image_url,
        ]);

        $this->updateProductRatingCache($product);

        return response()->json([
            'message' => 'Ulasan berhasil diperbarui.',
            'data'    => new ReviewResource($review->fresh()->load('user.profile')),
        ]);
    }

    /**
     * Hapus review milik user (atau admin).
     */
    public function destroy(Request $request, Product $product, Review $review): JsonResponse
    {
        if ($review->user_id !== $request->user()->id && !$request->user()->isAdmin()) {
            return response()->json(['message' => 'Forbidden.'], 403);
        }

        $review->delete();
        $this->updateProductRatingCache($product);

        return response()->json(['message' => 'Ulasan berhasil dihapus.']);
    }

    /**
     * Update cache avg_rating & reviews_count di tabel products.
     */
    private function updateProductRatingCache(Product $product): void
    {
        $stats = Review::where('product_id', $product->id)
            ->selectRaw('AVG(rating) as avg, COUNT(*) as total')
            ->first();

        $product->update([
            'avg_rating'    => round($stats->avg ?? 0, 2),
            'reviews_count' => $stats->total ?? 0,
        ]);
    }
}
