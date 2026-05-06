<?php

use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\AiGenerationController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\PasswordResetController;
use App\Http\Controllers\CocreateRoomController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\UploadController;
use App\Http\Controllers\WishlistController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes - SnapFit
|--------------------------------------------------------------------------
| Prefix: /api/v1
*/

// ─── PUBLIC ROUTES ────────────────────────────────────────────────────────────
Route::prefix('v1')->group(function () {

    // Auth
    Route::prefix('auth')->group(function () {
        Route::post('register',        [AuthController::class, 'register']);
        Route::post('login',           [AuthController::class, 'login']);
        Route::post('forgot-password', [PasswordResetController::class, 'forgotPassword']);
        Route::post('reset-password',  [PasswordResetController::class, 'resetPassword']);
    });

    // Marketplace publik
    Route::get('products',                        [ProductController::class, 'index']);
    Route::get('products/{product}',              [ProductController::class, 'show']);
    Route::get('products/{product}/reviews',      [ReviewController::class, 'index']);

    // Midtrans Webhook (public, verified via signature)
    Route::post('payment/webhook', [PaymentController::class, 'webhook']);

    // ─── AUTHENTICATED ROUTES ─────────────────────────────────────────────────
    Route::middleware('auth:sanctum')->group(function () {

        // Auth
        Route::post('auth/logout',          [AuthController::class, 'logout']);
        Route::get('auth/me',               [AuthController::class, 'me']);
        Route::post('auth/change-password', [PasswordResetController::class, 'changePassword']);

        // Profile
        Route::get('profile', [ProfileController::class, 'show']);
        Route::put('profile', [ProfileController::class, 'update']);

        // ─── UPLOAD ──────────────────────────────────────────────────────────
        Route::prefix('upload')->group(function () {
            Route::post('avatar',        [UploadController::class, 'uploadAvatar']);
            Route::post('product-image', [UploadController::class, 'uploadProductImage']);
            Route::post('ai-source',     [UploadController::class, 'uploadAiSource']);
            Route::post('ar-model',      [UploadController::class, 'uploadArModel']);
        });

        // ─── WISHLIST ─────────────────────────────────────────────────────────
        Route::prefix('wishlist')->group(function () {
            Route::get('/',                   [WishlistController::class, 'index']);
            Route::post('{productId}/toggle', [WishlistController::class, 'toggle']);
            Route::get('{productId}/check',   [WishlistController::class, 'check']);
            Route::delete('clear',            [WishlistController::class, 'clearAll']);
        });

        // ─── REVIEWS ─────────────────────────────────────────────────────────
        Route::prefix('products/{product}/reviews')->group(function () {
            Route::post('/',               [ReviewController::class, 'store']);
            Route::put('{review}',         [ReviewController::class, 'update']);
            Route::delete('{review}',      [ReviewController::class, 'destroy']);
        });

        // ─── NOTIFICATIONS ────────────────────────────────────────────────────
        Route::prefix('notifications')->group(function () {
            Route::get('/',           [NotificationController::class, 'index']);
            Route::patch('{id}/read', [NotificationController::class, 'markAsRead']);
            Route::patch('read-all',  [NotificationController::class, 'markAllAsRead']);
        });

        // ─── PAYMENT (MIDTRANS) ───────────────────────────────────────────────
        Route::prefix('payment')->group(function () {
            Route::post('orders/{order}/snap-token', [PaymentController::class, 'createSnapToken']);
            Route::get('orders/{order}/status',      [PaymentController::class, 'checkStatus']);
        });

        // ─── ORDERS (semua role bisa beli) ────────────────────────────────────
        Route::middleware('role:pembeli,umkm,desainer,admin')->prefix('orders')->group(function () {
            Route::get('/',        [OrderController::class, 'index']);
            Route::get('/{order}', [OrderController::class, 'show']);
            Route::post('/',       [OrderController::class, 'store']);
            Route::post('/{order}/cancel', [OrderController::class, 'cancel']);
            Route::post('/{order}/review', [OrderController::class, 'review']);
        });

        // ─── UMKM ONLY ────────────────────────────────────────────────────────
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

        // ─── UMKM + DESAINER (Co-Create Room) ────────────────────────────────
        Route::middleware('role:umkm,desainer')->prefix('cocreate')->group(function () {
            Route::get('rooms',                [CocreateRoomController::class, 'index']);
            Route::get('rooms/{room}',         [CocreateRoomController::class, 'show']);
            Route::post('rooms',               [CocreateRoomController::class, 'store']);
            Route::post('rooms/{room}/join',   [CocreateRoomController::class, 'join']);
            Route::patch('rooms/{room}/close', [CocreateRoomController::class, 'close']);
        });

        // ─── ADMIN ONLY ───────────────────────────────────────────────────────
        Route::middleware('role:admin')->prefix('admin')->group(function () {
            Route::get('stats',                   [AdminDashboardController::class, 'stats']);
            
            // User Management
            Route::get('users',                   [AdminDashboardController::class, 'users']);
            Route::post('users',                  [AdminDashboardController::class, 'storeUser']);
            Route::put('users/{user}',            [AdminDashboardController::class, 'updateUser']);
            Route::delete('users/{user}',         [AdminDashboardController::class, 'destroyUser']);
            
            Route::get('orders',                  [AdminDashboardController::class, 'orders']);
            Route::get('products',                [AdminDashboardController::class, 'products']);
            Route::get('reviews',                 [AdminDashboardController::class, 'reviews']);
            Route::patch('orders/{order}/status', [OrderController::class, 'updateStatus']);
            Route::delete('products/{product}',   [ProductController::class, 'destroy']);
            Route::delete('reviews/{review}',     [ReviewController::class, 'destroy']);
        });
    });
});
