<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    /**
     * Fetch user's cart items with product details
     */
    public function index()
    {
        $user = Auth::user();
        $carts = Cart::with('product')
            ->where('user_id', $user->id)
            ->get()
            ->map(function ($cart) {
                return [
                    'id' => $cart->id,
                    'product_id' => $cart->product_id,
                    'quantity' => $cart->quantity,
                    'variant' => $cart->variant,
                    'product' => $cart->product ? [
                        'id' => $cart->product->id,
                        'name' => $cart->product->name,
                        'price' => $cart->product->price,
                        'images' => $cart->product->images,
                        'category' => $cart->product->category,
                    ] : null,
                ];
            });

        return response()->json([
            'status' => 'success',
            'data' => $carts
        ]);
    }

    /**
     * Add item to cart
     */
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'integer|min:1',
            'variant' => 'nullable|string',
        ]);

        $user = Auth::user();

        // Check if item already exists in cart
        $existing = Cart::where('user_id', $user->id)
            ->where('product_id', $request->product_id)
            ->where('variant', $request->variant)
            ->first();

        if ($existing) {
            $existing->quantity += $request->input('quantity', 1);
            $existing->save();
            $cart = $existing;
        } else {
            $cart = Cart::create([
                'user_id' => $user->id,
                'product_id' => $request->product_id,
                'quantity' => $request->input('quantity', 1),
                'variant' => $request->variant,
            ]);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Item added to cart',
            'data' => $cart->load('product')
        ]);
    }

    /**
     * Update cart item quantity
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $user = Auth::user();
        $cart = Cart::where('user_id', $user->id)->findOrFail($id);
        $cart->update(['quantity' => $request->quantity]);

        return response()->json([
            'status' => 'success',
            'message' => 'Cart updated',
            'data' => $cart->load('product')
        ]);
    }

    /**
     * Remove item from cart
     */
    public function destroy($id)
    {
        $user = Auth::user();
        $cart = Cart::where('user_id', $user->id)->findOrFail($id);
        $cart->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Item removed from cart'
        ]);
    }

    /**
     * Sync local storage items to backend
     */
    public function sync(Request $request)
    {
        $user = Auth::user();
        $items = $request->input('items', []);

        Cart::where('user_id', $user->id)->delete();

        $cartRecords = [];
        foreach ($items as $item) {
            $cartRecords[] = [
                'user_id' => $user->id,
                'product_id' => $item['product_id'] ?? $item['id'],
                'quantity' => $item['quantity'] ?? 1,
                'variant' => $item['variant'] ?? null,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        if (count($cartRecords) > 0) {
            Cart::insert($cartRecords);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Cart synced successfully'
        ]);
    }
}
