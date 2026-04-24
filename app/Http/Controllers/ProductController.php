<?php

namespace App\Http\Controllers;

use App\Http\Requests\Product\StoreProductRequest;
use App\Http\Requests\Product\UpdateProductRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * List produk publik (guest bisa akses, dengan filter kategori/harga).
     */
    public function index(Request $request): JsonResponse
    {
        $query = Product::with('owner.profile')
            ->where('is_published', true);

        // Filter kategori
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        // Filter harga
        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }
        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }

        // Search nama
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // Sort
        $sortBy  = $request->get('sort_by', 'created_at');
        $sortDir = $request->get('sort_dir', 'desc');
        $allowedSorts = ['created_at', 'price', 'views', 'name'];
        if (in_array($sortBy, $allowedSorts)) {
            $query->orderBy($sortBy, $sortDir === 'asc' ? 'asc' : 'desc');
        }

        $products = $query->paginate($request->get('per_page', 12));

        return response()->json([
            'data'       => ProductResource::collection($products),
            'pagination' => [
                'total'        => $products->total(),
                'per_page'     => $products->perPage(),
                'current_page' => $products->currentPage(),
                'last_page'    => $products->lastPage(),
            ],
        ]);
    }

    /**
     * Detail produk (tambah view counter).
     */
    public function show(Product $product): JsonResponse
    {
        if ($product->is_published) {
            $product->increment('views');
        }

        $product->load('owner.profile');

        return response()->json([
            'data' => new ProductResource($product),
        ]);
    }

    /**
     * Buat produk baru (UMKM only).
     */
    public function store(StoreProductRequest $request): JsonResponse
    {
        $product = $request->user()->products()->create($request->validated());

        return response()->json([
            'message' => 'Produk berhasil dibuat.',
            'data'    => new ProductResource($product),
        ], 201);
    }

    /**
     * Update produk (UMKM pemilik only).
     */
    public function update(UpdateProductRequest $request, Product $product): JsonResponse
    {
        $product->update($request->validated());

        return response()->json([
            'message' => 'Produk berhasil diperbarui.',
            'data'    => new ProductResource($product->fresh()->load('owner.profile')),
        ]);
    }

    /**
     * Hapus produk (soft delete).
     */
    public function destroy(Request $request, Product $product): JsonResponse
    {
        if ($product->user_id !== $request->user()->id && !$request->user()->isAdmin()) {
            return response()->json(['message' => 'Forbidden.'], 403);
        }

        $product->delete();

        return response()->json(['message' => 'Produk berhasil dihapus.']);
    }

    /**
     * Produk milik UMKM yang login.
     */
    public function myProducts(Request $request): JsonResponse
    {
        $products = $request->user()
            ->products()
            ->with('owner.profile')
            ->latest()
            ->paginate($request->get('per_page', 10));

        return response()->json([
            'data'       => ProductResource::collection($products),
            'pagination' => [
                'total'        => $products->total(),
                'per_page'     => $products->perPage(),
                'current_page' => $products->currentPage(),
                'last_page'    => $products->lastPage(),
            ],
        ]);
    }

    /**
     * Toggle publish/unpublish produk.
     */
    public function togglePublish(Request $request, Product $product): JsonResponse
    {
        if ($product->user_id !== $request->user()->id) {
            return response()->json(['message' => 'Forbidden.'], 403);
        }

        $product->update(['is_published' => !$product->is_published]);

        return response()->json([
            'message'      => $product->is_published ? 'Produk dipublikasikan.' : 'Produk disembunyikan.',
            'is_published' => $product->is_published,
        ]);
    }
}
