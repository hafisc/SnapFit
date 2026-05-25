<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use App\Models\Order;
use App\Services\MidtransService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function __construct(private MidtransService $midtrans) {}

    /**
     * Buat Snap Token Midtrans untuk order yang sudah ada (status: pending).
     * Frontend akan pakai token ini untuk tampilkan popup payment Midtrans.
     */
    public function createSnapToken(Request $request, Order $order): JsonResponse
    {
        // Pastikan order milik user yang login
        if ($order->buyer_id !== $request->user()->id) {
            return response()->json(['message' => 'Forbidden.'], 403);
        }

        if ($order->status !== 'pending') {
            return response()->json([
                'message' => 'Order ini sudah diproses atau dibayar.',
                'status'  => $order->status,
            ], 422);
        }

        // Load items dan produk untuk item_details Midtrans
        $order->load(['items.product', 'buyer.profile']);

        // Regenerate midtrans_order_id to avoid "order_id has already been taken" error in Midtrans Sandbox/Production
        $order->midtrans_order_id = 'SNAPFIT-' . $order->id . '-' . strtoupper(\Illuminate\Support\Str::random(6));
        $order->save();

        try {
            $snap = $this->midtrans->createSnapToken($order, $request->user());

            return response()->json([
                'message'      => 'Snap token berhasil dibuat.',
                'snap_token'   => $snap['token'],
                'redirect_url' => $snap['redirect_url'],
                'order_id'     => $order->midtrans_order_id,
                'amount'       => (int) $order->total_amount,
                'client_key'   => config('midtrans.client_key'),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Gagal membuat token pembayaran.',
                'error'   => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Webhook Midtrans - dipanggil otomatis oleh server Midtrans setelah pembayaran.
     * Endpoint ini TIDAK menggunakan auth middleware (public, diverifikasi via signature).
     */
    public function webhook(Request $request): JsonResponse
    {
        try {
            $notification = $this->midtrans->verifyNotification();

            $orderId           = $notification->order_id;
            $transactionStatus = $notification->transaction_status;
            $fraudStatus       = $notification->fraud_status ?? '';
            $signatureKey      = $notification->signature_key;

            // Verifikasi signature key Midtrans
            $expectedSignature = hash('sha512',
                $orderId .
                $notification->status_code .
                $notification->gross_amount .
                config('midtrans.server_key')
            );

            if ($signatureKey !== $expectedSignature) {
                return response()->json(['message' => 'Invalid signature.'], 403);
            }

            $order = Order::where('midtrans_order_id', $orderId)->first();

            if (!$order) {
                return response()->json(['message' => 'Order not found.'], 404);
            }

            // Map status Midtrans ke status internal SnapFit
            $newStatus = $this->midtrans->mapStatus($transactionStatus, $fraudStatus);
            $order->update(['status' => $newStatus]);

            // Kirim notifikasi ke pembeli jika pembayaran berhasil
            if ($newStatus === 'paid') {
                Notification::create([
                    'user_id' => $order->buyer_id,
                    'title'   => 'Pembayaran Berhasil! 🎉',
                    'message' => "Pembayaran untuk order #{$order->midtrans_order_id} telah dikonfirmasi. Pesanan Anda sedang diproses.",
                    'is_read' => false,
                ]);
            }

            return response()->json(['message' => 'OK']);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Webhook error.',
                'error'   => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Cek status pembayaran order (manual polling dari frontend).
     */
    public function checkStatus(Request $request, Order $order): JsonResponse
    {
        if ($order->buyer_id !== $request->user()->id && !$request->user()->isAdmin()) {
            return response()->json(['message' => 'Forbidden.'], 403);
        }

        // Sinkronkan status pembayaran secara real-time dari Midtrans
        $this->midtrans->checkAndSyncStatus($order);

        return response()->json([
            'order_id'          => $order->midtrans_order_id,
            'status'            => $order->status,
            'total_amount'      => (int) $order->total_amount,
            'updated_at'        => $order->updated_at->toDateTimeString(),
        ]);
    }
}
