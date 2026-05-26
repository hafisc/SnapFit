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
        if ($request->filled('sort_by')) {
            $sortBy  = $request->get('sort_by');
            $sortDir = $request->get('sort_dir', 'desc');
            $allowedSorts = ['created_at', 'price', 'views', 'name', 'random'];
            if ($sortBy === 'random') {
                $query->inRandomOrder();
            } elseif (in_array($sortBy, $allowedSorts)) {
                $query->orderBy($sortBy, $sortDir === 'asc' ? 'asc' : 'desc');
            }
        } else {
            // Default to random order if no sort is specified to randomize on refresh
            $query->inRandomOrder();
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

    /**
     * Generate 3D model menggunakan AI secara simulasi, simpan ke database, dan return.
     */
    public function generate3d(Product $product): JsonResponse
    {
        if ($product->ar_model_url) {
            return response()->json([
                'message' => 'Model 3D sudah tersedia.',
                'ar_model_url' => $product->ar_model_url,
            ]);
        }

        // Simulasi delay pemrosesan AI 3 detik
        sleep(3);

        // Pilih model berdasarkan kategori produk
        $category = strtolower($product->category);
        if ($category === 'dekorasi') {
            $modelUrl = 'https://modelviewer.dev/shared-assets/models/glTF-Sample-Assets/Models/SheenChair/glTF-Binary/SheenChair.glb';
        } elseif ($category === 'aksesoris') {
            $modelUrl = 'https://modelviewer.dev/shared-assets/models/glTF-Sample-Assets/Models/ToyCar/glTF-Binary/ToyCar.glb';
        } else {
            // Default/Kerajinan
            $modelUrl = 'https://modelviewer.dev/shared-assets/models/glTF-Sample-Assets/Models/Lantern/glTF-Binary/Lantern.glb';
        }

        $product->update([
            'ar_model_url' => $modelUrl,
        ]);

        return response()->json([
            'message' => 'Model 3D berhasil di-generate menggunakan AI!',
            'ar_model_url' => $modelUrl,
        ]);
    }

    /**
     * Get public shop profile and products.
     */
    public function shop(\App\Models\User $user): JsonResponse
    {
        $user->load('profile');
        
        $products = Product::where('user_id', $user->id)
            ->where('is_published', true)
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'seller' => [
                'id'         => $user->id,
                'name'       => $user->profile?->business_name ?? $user->name,
                'location'   => $user->profile?->address ?? 'Yogyakarta, Indonesia',
                'bio'        => $user->profile?->bio ?? 'Pelestari kerajinan nusantara berkualitas tinggi.',
                'avatar_url' => $user->profile?->avatar_url,
                'phone'      => $user->profile?->phone,
                'rating'     => round($user->products()->avg('rating') ?? 4.8, 1),
                'sold'       => (int) $user->products()->sum('sold'),
            ],
            'products' => ProductResource::collection($products),
        ]);
    }
}
