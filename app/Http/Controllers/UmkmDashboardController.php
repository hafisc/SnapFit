<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\CocreateRoom;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class UmkmDashboardController extends Controller
{
    /**
     * Get UMKM dashboard data
     */
    public function index(Request $request)
    {
        $user = $request->user();
        
        // Get date ranges
        $now = Carbon::now();
        $startOfMonth = $now->copy()->startOfMonth();
        $startOfLastMonth = $now->copy()->subMonth()->startOfMonth();
        $endOfLastMonth = $now->copy()->subMonth()->endOfMonth();
        $last7Days = $now->copy()->subDays(7);
        $last14Days = $now->copy()->subDays(14);

        // ─── STATS ────────────────────────────────────────────────────────────
        
        // Total Products
        $totalProducts = Product::where('user_id', $user->id)->count();
        $newProducts = Product::where('user_id', $user->id)
            ->where('created_at', '>=', $startOfMonth)
            ->count();

        // Total Orders (orders that contain user's products)
        $totalOrders = Order::whereHas('items.product', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })->count();

        $newOrders = Order::whereHas('items.product', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })->where('created_at', '>=', $startOfMonth)->count();

        // Active Collaborations
        $activeCollaborations = CocreateRoom::where('creator_id', $user->id)
            ->where('status', 'active')
            ->count();

        // Total Revenue (from completed orders)
        $totalRevenue = OrderItem::whereHas('order', function ($query) {
            $query->where('status', 'completed');
        })->whereHas('product', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })->sum(DB::raw('quantity * price'));

        // Revenue last month for growth calculation
        $lastMonthRevenue = OrderItem::whereHas('order', function ($query) use ($startOfLastMonth, $endOfLastMonth) {
            $query->where('status', 'completed')
                ->whereBetween('created_at', [$startOfLastMonth, $endOfLastMonth]);
        })->whereHas('product', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })->sum(DB::raw('quantity * price'));

        // Calculate revenue growth
        $revenueGrowth = 0;
        if ($lastMonthRevenue > 0) {
            $currentMonthRevenue = OrderItem::whereHas('order', function ($query) use ($startOfMonth) {
                $query->where('status', 'completed')
                    ->where('created_at', '>=', $startOfMonth);
            })->whereHas('product', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })->sum(DB::raw('quantity * price'));

            $revenueGrowth = round((($currentMonthRevenue - $lastMonthRevenue) / $lastMonthRevenue) * 100, 1);
        }

        // ─── RECENT ORDERS ────────────────────────────────────────────────────
        $recentOrders = Order::whereHas('items.product', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })
        ->with(['buyer', 'items.product'])
        ->orderBy('created_at', 'desc')
        ->limit(5)
        ->get()
        ->map(function ($order) use ($user) {
            // Calculate total for this UMKM's products only
            $umkmTotal = $order->items()
                ->whereHas('product', function ($query) use ($user) {
                    $query->where('user_id', $user->id);
                })
                ->sum(DB::raw('quantity * price'));

            return [
                'id' => $order->id,
                'order_number' => '#ORD-' . str_pad($order->id, 4, '0', STR_PAD_LEFT),
                'customer_name' => $order->buyer->name ?? 'Customer',
                'total_amount' => $umkmTotal,
                'status' => $order->status,
                'created_at' => $order->created_at->format('Y-m-d H:i:s'),
            ];
        });

        // ─── TOP PRODUCTS ─────────────────────────────────────────────────────
        $topProducts = Product::where('user_id', $user->id)
            ->withCount(['orderItems as sales_count' => function ($query) {
                $query->whereHas('order', function ($q) {
                    $q->where('status', 'completed');
                });
            }])
            ->having('sales_count', '>', 0)
            ->orderBy('sales_count', 'desc')
            ->limit(3)
            ->get()
            ->map(function ($product) use ($last7Days, $last14Days) {
                // Calculate growth (last 7 days vs previous 7 days)
                $recentSales = OrderItem::where('product_id', $product->id)
                    ->whereHas('order', function ($query) use ($last7Days) {
                        $query->where('status', 'completed')
                            ->where('created_at', '>=', $last7Days);
                    })
                    ->sum('quantity');

                $previousSales = OrderItem::where('product_id', $product->id)
                    ->whereHas('order', function ($query) use ($last7Days, $last14Days) {
                        $query->where('status', 'completed')
                            ->whereBetween('created_at', [$last14Days, $last7Days]);
                    })
                    ->sum('quantity');

                $growth = 0;
                if ($previousSales > 0) {
                    $growth = round((($recentSales - $previousSales) / $previousSales) * 100, 1);
                } elseif ($recentSales > 0) {
                    $growth = 100;
                }

                return [
                    'id' => $product->id,
                    'name' => $product->name,
                    'sales_count' => $product->sales_count,
                    'growth_percentage' => $growth,
                    'image_url' => $product->images[0] ?? null,
                    'price' => $product->price,
                ];
            });

        // ─── REVENUE CHART (Last 7 Days) ─────────────────────────────────────
        $revenueChart = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = $now->copy()->subDays($i);
            $dayStart = $date->copy()->startOfDay();
            $dayEnd = $date->copy()->endOfDay();

            $dayRevenue = OrderItem::whereHas('order', function ($query) use ($dayStart, $dayEnd) {
                $query->where('status', 'completed')
                    ->whereBetween('created_at', [$dayStart, $dayEnd]);
            })->whereHas('product', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })->sum(DB::raw('quantity * price'));

            $revenueChart[] = [
                'day' => $date->locale('id')->isoFormat('ddd'),
                'date' => $date->format('Y-m-d'),
                'amount' => (float) $dayRevenue,
                'percentage' => 0, // Will calculate after getting max
            ];
        }

        // Calculate percentages for chart
        $maxRevenue = max(array_column($revenueChart, 'amount'));
        if ($maxRevenue > 0) {
            foreach ($revenueChart as &$day) {
                $day['percentage'] = round(($day['amount'] / $maxRevenue) * 100, 1);
            }
        }

        // ─── RESPONSE ─────────────────────────────────────────────────────────
        return response()->json([
            'stats' => [
                'total_products' => $totalProducts,
                'new_products' => $newProducts,
                'total_orders' => $totalOrders,
                'new_orders' => $newOrders,
                'active_collaborations' => $activeCollaborations,
                'total_revenue' => (float) $totalRevenue,
                'revenue_growth' => $revenueGrowth,
            ],
            'recent_orders' => $recentOrders,
            'top_products' => $topProducts,
            'revenue_chart' => $revenueChart,
        ]);
    }
}
