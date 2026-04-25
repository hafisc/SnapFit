<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\OrderResource;
use App\Http\Resources\ProductResource;
use App\Http\Resources\UserResource;
use App\Models\AiGeneration;
use App\Models\CocreateRoom;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    /**
     * Global analytics untuk juri/admin.
     */
    public function stats(): JsonResponse
    {
        return response()->json([
            'users' => [
                'total'    => User::count(),
                'umkm'     => User::where('role', 'umkm')->count(),
                'desainer' => User::where('role', 'desainer')->count(),
                'pembeli'  => User::where('role', 'pembeli')->count(),
            ],
            'products' => [
                'total'     => Product::count(),
                'published' => Product::where('is_published', true)->count(),
                'by_category' => Product::selectRaw('category, count(*) as total')
                    ->groupBy('category')
                    ->pluck('total', 'category'),
            ],
            'orders' => [
                'total'     => Order::count(),
                'pending'   => Order::where('status', 'pending')->count(),
                'paid'      => Order::where('status', 'paid')->count(),
                'shipped'   => Order::where('status', 'shipped')->count(),
                'completed' => Order::where('status', 'completed')->count(),
                'revenue'   => Order::where('status', 'completed')->sum('total_amount'),
            ],
            'cocreate_rooms' => [
                'total'     => CocreateRoom::count(),
                'active'    => CocreateRoom::where('status', 'active')->count(),
                'completed' => CocreateRoom::where('status', 'completed')->count(),
            ],
            'ai_generations' => [
                'total' => AiGeneration::count(),
            ],
        ]);
    }

    /**
     * List semua user (dengan filter).
     */
    public function users(Request $request): JsonResponse
    {
        $users = User::with('profile')
            ->when($request->filled('role'), fn($q) => $q->where('role', $request->role))
            ->when($request->filled('search'), fn($q) => $q->where('name', 'like', '%' . $request->search . '%')
                ->orWhere('email', 'like', '%' . $request->search . '%'))
            ->latest()
            ->paginate(15);

        return response()->json([
            'data'       => UserResource::collection($users),
            'pagination' => [
                'total'        => $users->total(),
                'current_page' => $users->currentPage(),
                'last_page'    => $users->lastPage(),
            ],
        ]);
    }

    /**
     * Create user (admin).
     */
    public function storeUser(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
            'role'     => 'required|in:umkm,desainer,pembeli,admin',
        ]);

        $user = User::create([
            'name'     => $validated['name'],
            'email'    => $validated['email'],
            'password' => bcrypt($validated['password']),
            'role'     => $validated['role'],
        ]);

        return response()->json([
            'message' => 'User berhasil dibuat',
            'user'    => new UserResource($user->load('profile')),
        ], 201);
    }

    /**
     * Update user (admin).
     */
    public function updateUser(Request $request, User $user): JsonResponse
    {
        $validated = $request->validate([
            'name'  => 'sometimes|string|max:255',
            'email' => 'sometimes|email|unique:users,email,' . $user->id,
            'role'  => 'sometimes|in:umkm,desainer,pembeli,admin',
        ]);

        $user->update($validated);

        return response()->json([
            'message' => 'User berhasil diupdate',
            'user'    => new UserResource($user->load('profile')),
        ]);
    }

    /**
     * Delete user (admin).
     */
    public function destroyUser(User $user): JsonResponse
    {
        $user->delete();

        return response()->json([
            'message' => 'User berhasil dihapus',
        ]);
    }

    /**
     * List semua order (admin view).
     */
    public function orders(Request $request): JsonResponse
    {
        $orders = Order::with(['items.product', 'buyer'])
            ->when($request->filled('status'), fn($q) => $q->where('status', $request->status))
            ->latest()
            ->paginate(15);

        return response()->json([
            'data'       => OrderResource::collection($orders),
            'pagination' => [
                'total'        => $orders->total(),
                'current_page' => $orders->currentPage(),
                'last_page'    => $orders->lastPage(),
            ],
        ]);
    }

    /**
     * List semua produk (admin view, termasuk unpublished).
     */
    public function products(Request $request): JsonResponse
    {
        $products = Product::with('owner.profile')
            ->when($request->filled('category'), fn($q) => $q->where('category', $request->category))
            ->latest()
            ->paginate(15);

        return response()->json([
            'data'       => ProductResource::collection($products),
            'pagination' => [
                'total'        => $products->total(),
                'current_page' => $products->currentPage(),
                'last_page'    => $products->lastPage(),
            ],
        ]);
    }
}
