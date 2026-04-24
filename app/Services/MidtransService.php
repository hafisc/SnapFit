<?php

namespace App\Services;

use Midtrans\Config;
use Midtrans\Snap;
use Midtrans\Notification;

class MidtransService
{
    public function __construct()
    {
        Config::$serverKey    = config('midtrans.server_key');
        Config::$clientKey    = config('midtrans.client_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized  = config('midtrans.is_sanitized');
        Config::$is3ds        = config('midtrans.is_3ds');
    }

    /**
     * Buat Snap Token untuk pembayaran.
     *
     * @param  \App\Models\Order  $order
     * @param  \App\Models\User   $buyer
     * @return array{token: string, redirect_url: string}
     */
    public function createSnapToken($order, $buyer): array
    {
        $params = [
            'transaction_details' => [
                'order_id'     => $order->midtrans_order_id,
                'gross_amount' => (int) $order->total_amount,
            ],
            'customer_details' => [
                'first_name' => $buyer->name,
                'email'      => $buyer->email,
                'phone'      => $buyer->profile?->phone ?? '',
            ],
            'item_details' => $order->items->map(fn($item) => [
                'id'       => (string) $item->product_id,
                'price'    => (int) $item->price,
                'quantity' => $item->quantity,
                'name'     => substr($item->product->name ?? 'Produk SnapFit', 0, 50),
            ])->toArray(),
            'callbacks' => [
                'finish' => config('app.url') . '/payment/finish',
            ],
        ];

        $snapToken   = Snap::getSnapToken($params);
        $redirectUrl = config('midtrans.is_production')
            ? 'https://app.midtrans.com/snap/v2/vtweb/' . $snapToken
            : 'https://app.sandbox.midtrans.com/snap/v2/vtweb/' . $snapToken;

        return [
            'token'        => $snapToken,
            'redirect_url' => $redirectUrl,
        ];
    }

    /**
     * Verifikasi notifikasi webhook dari Midtrans.
     */
    public function verifyNotification(): object
    {
        return new Notification();
    }

    /**
     * Map status Midtrans ke status order SnapFit.
     */
    public function mapStatus(string $transactionStatus, string $fraudStatus = ''): string
    {
        return match (true) {
            $transactionStatus === 'capture' && $fraudStatus === 'accept' => 'paid',
            $transactionStatus === 'settlement'                           => 'paid',
            $transactionStatus === 'pending'                             => 'pending',
            in_array($transactionStatus, ['deny', 'cancel', 'expire'])  => 'pending',
            default                                                       => 'pending',
        };
    }
}
