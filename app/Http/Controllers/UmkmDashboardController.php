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

    /**
     * Get UMKM analytics data
     */
    public function analytics(Request $request): \Illuminate\Http\JsonResponse
    {
        $user = $request->user();
        $now = Carbon::now();
        $period = $request->query('period', 'Bulan Ini');

        // Set date ranges based on period
        switch ($period) {
            case 'Minggu Ini':
                $startDate = $now->copy()->startOfWeek();
                $endDate = $now->copy()->endOfWeek();
                $prevStartDate = $startDate->copy()->subWeek();
                $prevEndDate = $endDate->copy()->subWeek();
                break;
            case 'Bulan Ini':
            default:
                $startDate = $now->copy()->startOfMonth();
                $endDate = $now->copy()->endOfMonth();
                $prevStartDate = $startDate->copy()->subMonth();
                $prevEndDate = $endDate->copy()->subMonth();
                break;
            case '3 Bulan':
                $startDate = $now->copy()->subMonths(2)->startOfMonth();
                $endDate = $now->copy()->endOfMonth();
                $prevStartDate = $startDate->copy()->subMonths(3)->startOfMonth();
                $prevEndDate = $startDate->copy()->subSecond();
                break;
            case '1 Tahun':
                $startDate = $now->copy()->subMonths(11)->startOfMonth();
                $endDate = $now->copy()->endOfMonth();
                $prevStartDate = $startDate->copy()->subYear();
                $prevEndDate = $startDate->copy()->subSecond();
                break;
        }

        // 1. KPIs
        // Total Revenue
        $totalRevenue = OrderItem::whereHas('order', function ($query) use ($startDate, $endDate) {
            $query->where('status', 'completed')
                ->whereBetween('created_at', [$startDate, $endDate]);
        })->whereHas('product', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })->sum(DB::raw('quantity * price'));

        // Prev Revenue
        $prevRevenue = OrderItem::whereHas('order', function ($query) use ($prevStartDate, $prevEndDate) {
            $query->where('status', 'completed')
                ->whereBetween('created_at', [$prevStartDate, $prevEndDate]);
        })->whereHas('product', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })->sum(DB::raw('quantity * price'));

        // Total Orders
        $totalOrders = Order::where('status', 'completed')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->whereHas('items.product', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })->count();

        // Prev Orders
        $prevOrders = Order::where('status', 'completed')
            ->whereBetween('created_at', [$prevStartDate, $prevEndDate])
            ->whereHas('items.product', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })->count();

        // Average Order Value
        $avgOrderValue = $totalOrders > 0 ? round($totalRevenue / $totalOrders) : 0;
        $prevAvgOrderValue = $prevOrders > 0 ? round($prevRevenue / $prevOrders) : 0;

        // Total Products
        $totalProducts = Product::where('user_id', $user->id)
            ->where('created_at', '<=', $endDate)
            ->count();
        $prevProducts = Product::where('user_id', $user->id)
            ->where('created_at', '<=', $prevEndDate)
            ->count();

        // Growths
        $revenueGrowth = 0;
        if ($prevRevenue > 0) {
            $revenueGrowth = round((($totalRevenue - $prevRevenue) / $prevRevenue) * 100, 1);
        }

        $ordersGrowth = 0;
        if ($prevOrders > 0) {
            $ordersGrowth = round((($totalOrders - $prevOrders) / $prevOrders) * 100, 1);
        }

        $avgOrderGrowth = 0;
        if ($prevAvgOrderValue > 0) {
            $avgOrderGrowth = round((($avgOrderValue - $prevAvgOrderValue) / $prevAvgOrderValue) * 100, 1);
        }

        $productsGrowth = 0;
        if ($prevProducts > 0) {
            $productsGrowth = round((($totalProducts - $prevProducts) / $prevProducts) * 100, 1);
        }

        // 2. Revenue Trend
        $revenueData = [];
        if ($period === 'Minggu Ini') {
            $weekStart = $startDate->copy();
            for ($i = 0; $i < 7; $i++) {
                $dayDate = $weekStart->copy()->addDays($i);
                $dayStart = $dayDate->copy()->startOfDay();
                $dayEnd = $dayDate->copy()->endOfDay();

                $dayRevenue = OrderItem::whereHas('order', function ($query) use ($dayStart, $dayEnd) {
                    $query->where('status', 'completed')
                        ->whereBetween('created_at', [$dayStart, $dayEnd]);
                })->whereHas('product', function ($query) use ($user) {
                    $query->where('user_id', $user->id);
                })->sum(DB::raw('quantity * price'));

                $revenueData[] = [
                    'label' => $dayDate->locale('id')->isoFormat('ddd'),
                    'value' => round($dayRevenue / 1000000, 2),
                    'raw_value' => (float)$dayRevenue,
                    'pct' => 0
                ];
            }
        } elseif ($period === 'Bulan Ini') {
            $monthStart = $startDate->copy();
            $weeks = [
                ['start' => $monthStart->copy(), 'end' => $monthStart->copy()->addDays(6)->endOfDay(), 'label' => 'Mgg 1'],
                ['start' => $monthStart->copy()->addDays(7), 'end' => $monthStart->copy()->addDays(13)->endOfDay(), 'label' => 'Mgg 2'],
                ['start' => $monthStart->copy()->addDays(14), 'end' => $monthStart->copy()->addDays(20)->endOfDay(), 'label' => 'Mgg 3'],
                ['start' => $monthStart->copy()->addDays(21), 'end' => $endDate->copy(), 'label' => 'Mgg 4'],
            ];
            foreach ($weeks as $w) {
                $weekRevenue = OrderItem::whereHas('order', function ($query) use ($w) {
                    $query->where('status', 'completed')
                        ->whereBetween('created_at', [$w['start'], $w['end']]);
                })->whereHas('product', function ($query) use ($user) {
                    $query->where('user_id', $user->id);
                })->sum(DB::raw('quantity * price'));

                $revenueData[] = [
                    'label' => $w['label'],
                    'value' => round($weekRevenue / 1000000, 1),
                    'raw_value' => (float)$weekRevenue,
                    'pct' => 0
                ];
            }
        } elseif ($period === '3 Bulan') {
            for ($i = 2; $i >= 0; $i--) {
                $monthDate = $now->copy()->subMonths($i);
                $monthStart = $monthDate->copy()->startOfMonth();
                $monthEnd = $monthDate->copy()->endOfMonth();

                $monthRevenue = OrderItem::whereHas('order', function ($query) use ($monthStart, $monthEnd) {
                    $query->where('status', 'completed')
                        ->whereBetween('created_at', [$monthStart, $monthEnd]);
                })->whereHas('product', function ($query) use ($user) {
                    $query->where('user_id', $user->id);
                })->sum(DB::raw('quantity * price'));

                $revenueData[] = [
                    'label' => $monthDate->locale('id')->isoFormat('MMM'),
                    'value' => round($monthRevenue / 1000000, 1),
                    'raw_value' => (float)$monthRevenue,
                    'pct' => 0
                ];
            }
        } else { // 1 Tahun
            for ($i = 11; $i >= 0; $i--) {
                $monthDate = $now->copy()->subMonths($i);
                $monthStart = $monthDate->copy()->startOfMonth();
                $monthEnd = $monthDate->copy()->endOfMonth();

                $monthRevenue = OrderItem::whereHas('order', function ($query) use ($monthStart, $monthEnd) {
                    $query->where('status', 'completed')
                        ->whereBetween('created_at', [$monthStart, $monthEnd]);
                })->whereHas('product', function ($query) use ($user) {
                    $query->where('user_id', $user->id);
                })->sum(DB::raw('quantity * price'));

                $revenueData[] = [
                    'label' => $monthDate->locale('id')->isoFormat('MMM'),
                    'value' => round($monthRevenue / 1000000, 1),
                    'raw_value' => (float)$monthRevenue,
                    'pct' => 0
                ];
            }
        }

        $maxVal = max(array_column($revenueData, 'raw_value'));
        if ($maxVal > 0) {
            foreach ($revenueData as &$m) {
                $m['pct'] = round(($m['raw_value'] / $maxVal) * 100);
            }
        }

        // 3. Product Performance
        $productPerf = Product::where('user_id', $user->id)
            ->withCount(['orderItems as orders' => function ($query) use ($startDate, $endDate) {
                $query->whereHas('order', function ($q) use ($startDate, $endDate) {
                    $q->where('status', 'completed')
                        ->whereBetween('created_at', [$startDate, $endDate]);
                });
            }])
            ->orderBy('orders', 'desc')
            ->limit(4)
            ->get()
            ->map(function ($p) {
                // Mock some views count for visual conversion rate
                $views = $p->orders * 10 + rand(15, 45);
                $conversion = $views > 0 ? round(($p->orders / $views) * 100, 1) : 0;
                
                // Color choices for layout styling
                $colorClasses = ['bg-orange-400', 'bg-blue-400', 'bg-emerald-400', 'bg-violet-400'];
                static $idx = 0;
                $barClass = $colorClasses[$idx % 4];
                $idx++;

                return [
                    'name' => $p->name,
                    'views' => $views,
                    'orders' => $p->orders,
                    'conversion' => $conversion,
                    'barClass' => $barClass
                ];
            });

        // 4. Demographics (Orders grouped by City)
        $ordersQuery = Order::where('status', 'completed')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->whereHas('items.product', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })
            ->with('buyer.profile')
            ->get();

        $cityCounts = [];
        foreach ($ordersQuery as $order) {
            $address = strtolower($order->buyer->profile->address ?? '');
            $city = 'Lainnya';
            if (str_contains($address, 'malang')) {
                $city = 'Kota Malang';
            } elseif (str_contains($address, 'surabaya')) {
                $city = 'Surabaya';
            } elseif (str_contains($address, 'jakarta')) {
                $city = 'Jakarta';
            } elseif (str_contains($address, 'yogyakarta') || str_contains($address, 'jogja')) {
                $city = 'Yogyakarta';
            } elseif (str_contains($address, 'solo') || str_contains($address, 'surakarta')) {
                $city = 'Solo';
            } elseif (str_contains($address, 'bandung')) {
                $city = 'Bandung';
            }
            $cityCounts[$city] = ($cityCounts[$city] ?? 0) + 1;
        }

        arsort($cityCounts);
        $demographics = [];
        $colorClasses = ['bg-terracotta', 'bg-blue-500', 'bg-emerald-500', 'bg-violet-500', 'bg-slate-400'];
        $idx = 0;
        foreach ($cityCounts as $city => $count) {
            $demographics[] = [
                'city' => $city,
                'orders' => $count,
                'dotClass' => $colorClasses[$idx % 5]
            ];
            $idx++;
        }

        // 5. AI Studio Stats
        $aiGenerationsCount = \App\Models\AiGeneration::where('user_id', $user->id)
            ->whereBetween('created_at', [$startDate, $endDate])
            ->count();

        $aiStats = [
            [
                'label' => 'Foto Studio AI Dibuat',
                'value' => (string)$aiGenerationsCount,
                'pct' => min(round(($aiGenerationsCount / 20) * 100), 100),
                'valueClass' => 'text-terracotta',
                'barClass' => 'bg-orange-400'
            ],
            [
                'label' => 'Video 360° Dibuat',
                'value' => '0',
                'pct' => 0,
                'valueClass' => 'text-blue-600',
                'barClass' => 'bg-blue-400'
            ],
            [
                'label' => 'Deskripsi AI Ditulis',
                'value' => (string)$aiGenerationsCount,
                'pct' => min(round(($aiGenerationsCount / 20) * 100), 100),
                'valueClass' => 'text-emerald-600',
                'barClass' => 'bg-emerald-400'
            ],
            [
                'label' => 'Sisa Kuota',
                'value' => max(0, 100 - min(round(($aiGenerationsCount / 20) * 100), 100)) . '%',
                'pct' => max(0, 100 - min(round(($aiGenerationsCount / 20) * 100), 100)),
                'valueClass' => 'text-amber-600',
                'barClass' => 'bg-amber-400'
            ]
        ];

        return response()->json([
            'kpis' => [
                [
                    'label' => 'Total Pendapatan',
                    'value' => 'Rp ' . ($totalRevenue >= 1000000 ? round($totalRevenue / 1000000, 1) . 'M' : ($totalRevenue >= 1000 ? round($totalRevenue / 1000) . 'K' : $totalRevenue)),
                    'change' => abs($revenueGrowth) . '%',
                    'up' => $revenueGrowth >= 0
                ],
                [
                    'label' => 'Total Pesanan',
                    'value' => (string)$totalOrders,
                    'change' => abs($ordersGrowth) . '%',
                    'up' => $ordersGrowth >= 0
                ],
                [
                    'label' => 'Rata-rata Order',
                    'value' => 'Rp ' . ($avgOrderValue >= 1000 ? round($avgOrderValue / 1000) . 'K' : $avgOrderValue),
                    'change' => abs($avgOrderGrowth) . '%',
                    'up' => $avgOrderGrowth >= 0
                ],
                [
                    'label' => 'Total Produk',
                    'value' => (string)$totalProducts,
                    'change' => abs($productsGrowth) . '%',
                    'up' => $productsGrowth >= 0
                ]
            ],
            'revenue_trend' => $revenueData,
            'product_perf' => $productPerf,
            'demographics' => $demographics,
            'ai_stats' => $aiStats
        ]);
    }
}
