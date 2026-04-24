<?php

use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\AiGenerationController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\CocreateRoomController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes - SnapFit
|--------------------------------------------------------------------------
| Prefix: /api
*/

// ─── PUBLIC ROUTES (no auth required) ────────────────────────────────────────
Route::prefix('v1')->group(function () {

    // Auth
    Route::prefix('auth')->group(function () {
        Route::post('register', [AuthController::class, 'register']);
        Route::post('login',    [AuthController::class, 'login']);
    });

    // Marketplace publik (guest bisa browse)
    Route::get('products',           [ProductController::class, 'index']);
    Route::get('products/{product}', [ProductController::class, 'show']);

    // Midtrans Webhook (public, diverifikasi internal via signature)
    Route::post('payment/webhook', [PaymentController::class, 'webhook']);

    // ─── AUTHENTICATED ROUTES ─────────────────────────────────────────────────
    Route::middleware('auth:sanctum')->group(function () {

        // Auth
        Route::post('auth/logout', [AuthController::class, 'logout']);
        Route::get('auth/me',      [AuthController::class, 'me']);

        // Profile
        Route::get('profile', [ProfileController::class, 'show']);
        Route::put('profile', [ProfileController::class, 'update']);

        // Notifications
        Route::get('notifications',             [NotificationController::class, 'index']);
        Route::patch('notifications/{id}/read', [NotificationController::class, 'markAsRead']);
        Route::patch('notifications/read-all',  [NotificationController::class, 'markAllAsRead']);

        // Payment (Midtrans)
        Route::prefix('payment')->group(function () {
            Route::post('orders/{order}/snap-token', [PaymentController::class, 'createSnapToken']);
            Route::get('orders/{order}/status',      [PaymentController::class, 'checkStatus']);
        });

        // ─── UMKM ROUTES ─────────────────────────────────────────────────────
        Route::middleware('role:umkm')->prefix('umkm')->group(function () {
            Route::get('products',                         [ProductController::class, 'myProducts']);
            Route::post('products',                        [ProductController::class, 'store']);
            Route::put('products/{product}',               [ProductController::class, 'update']);
            Route::delete('products/{product}',            [ProductController::class, 'destroy']);
            Route::patch('products/{product}/publish',     [ProductController::class, 'togglePublish']);

            // AI Product Studio
            Route::get('ai-generations',                   [AiGenerationController::class, 'index']);
            Route::post('ai-generations',                  [AiGenerationController::class, 'store']);
            Route::delete('ai-generations/{aiGeneration}', [AiGenerationController::class, 'destroy']);
        });

        // ─── UMKM + DESAINER ROUTES ───────────────────────────────────────────
        Route::middleware('role:umkm,desainer')->prefix('cocreate')->group(function () {
            Route::get('rooms',                [CocreateRoomController::class, 'index']);
            Route::get('rooms/{room}',         [CocreateRoomController::class, 'show']);
            Route::post('rooms',               [CocreateRoomController::class, 'store']);
            Route::post('rooms/{room}/join',   [CocreateRoomController::class, 'join']);
            Route::patch('rooms/{room}/close', [CocreateRoomController::class, 'close']);
        });

        // ─── BUYER / SEMUA ROLE (Order) ───────────────────────────────────────
        Route::middleware('role:pembeli,umkm,desainer,admin')->prefix('orders')->group(function () {
            Route::get('/',        [OrderController::class, 'index']);
            Route::get('/{order}', [OrderController::class, 'show']);
            Route::post('/',       [OrderController::class, 'store']);
        });

        // ─── ADMIN ROUTES ─────────────────────────────────────────────────────
        Route::middleware('role:admin')->prefix('admin')->group(function () {
            Route::get('stats',                    [AdminDashboardController::class, 'stats']);
            Route::get('users',                    [AdminDashboardController::class, 'users']);
            Route::get('orders',                   [AdminDashboardController::class, 'orders']);
            Route::get('products',                 [AdminDashboardController::class, 'products']);
            Route::patch('orders/{order}/status',  [OrderController::class, 'updateStatus']);
            Route::delete('products/{product}',    [ProductController::class, 'destroy']);
        });
    });
});
