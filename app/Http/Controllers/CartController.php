<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    /**
     * Fetch user's cart items
     */
    public function index()
    {
        $user = Auth::user();
        $carts = Cart::where('user_id', $user->id)->get();

        // Normally, you would eager load the Product model here:
        // $carts = Cart::with('product')->where('user_id', $user->id)->get();
        // Since products might be static/dummy in frontend, we just return cart rows.

        return response()->json([
            'status' => 'success',
            'data' => $carts
        ]);
    }

    /**
     * Sync local storage items to backend
     */
    public function sync(Request $request)
    {
        $user = Auth::user();
        $items = $request->input('items', []);

        // Delete existing items for user and recreate to ensure full sync
        // Alternatively, update based on product_id. We'll do a simple wipe & replace for now
        // to match localStorage state.
        
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
