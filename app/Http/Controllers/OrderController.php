<?php

namespace App\Http\Controllers;

use App\Http\Requests\Order\StoreOrderRequest;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    /**
     * Riwayat order milik pembeli.
     */
    public function index(Request $request): JsonResponse
    {
        $orders = Order::with(['items.product'])
            ->where('buyer_id', $request->user()->id)
            ->latest()
            ->paginate(10);

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
     * Detail satu order.
     */
    public function show(Request $request, Order $order): JsonResponse
    {
        if ($order->buyer_id !== $request->user()->id && !$request->user()->isAdmin()) {
            return response()->json(['message' => 'Forbidden.'], 403);
        }

        $order->load(['items.product']);

        return response()->json(['data' => new OrderResource($order)]);
    }

    /**
     * Buat order baru (checkout).
     */
    public function store(StoreOrderRequest $request): JsonResponse
    {
        return DB::transaction(function () use ($request) {
            $productIds = collect($request->items)->pluck('product_id');
            $products   = Product::whereIn('id', $productIds)
                ->where('is_published', true)
                ->get()
                ->keyBy('id');

            // Validasi produk tersedia
            foreach ($request->items as $item) {
                if (!$products->has($item['product_id'])) {
                    return response()->json([
                        'message' => "Produk ID {$item['product_id']} tidak tersedia.",
                    ], 422);
                }
            }

            // Hitung total
            $totalAmount = collect($request->items)->sum(function ($item) use ($products) {
                return $products[$item['product_id']]->price * $item['quantity'];
            });

            // Buat order
            $order = Order::create([
                'buyer_id'           => $request->user()->id,
                'total_amount'       => $totalAmount,
                'status'             => 'pending',
                'midtrans_order_id'  => 'KREATI-' . strtoupper(Str::random(10)),
            ]);

            // Buat order items
            foreach ($request->items as $item) {
                OrderItem::create([
                    'order_id'   => $order->id,
                    'product_id' => $item['product_id'],
                    'quantity'   => $item['quantity'],
                    'price'      => $products[$item['product_id']]->price,
                ]);
            }

            $order->load(['items.product']);

            return response()->json([
                'message' => 'Order berhasil dibuat. Lanjutkan ke pembayaran.',
                'data'    => new OrderResource($order),
            ], 201);
        });
    }

    /**
     * Update status order (Admin only).
     */
    public function updateStatus(Request $request, Order $order): JsonResponse
    {
        $request->validate([
            'status' => ['required', 'in:pending,paid,shipped,completed'],
        ]);

        $order->update(['status' => $request->status]);

        return response()->json([
            'message' => 'Status order diperbarui.',
            'data'    => new OrderResource($order),
        ]);
    }
}
