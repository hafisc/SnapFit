<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'                 => $this->id,
            'total_amount'       => (float) $this->total_amount,
            'status'             => $this->status,
            'midtrans_order_id'  => $this->midtrans_order_id,
            'shipping_courier'   => $this->shipping_courier,
            'tracking_number'    => $this->tracking_number,
            'cancelled_at'       => $this->cancelled_at?->toDateTimeString(),
            'created_at'         => $this->created_at->toDateTimeString(),
            'buyer'              => $this->whenLoaded('buyer', function () {
                return [
                    'id'            => $this->buyer->id,
                    'email'         => $this->buyer->email,
                    'phone_number'  => $this->buyer->phone_number,
                    'profile'       => $this->buyer->relationLoaded('profile') ? [
                        'full_name' => $this->buyer->profile->full_name,
                        'address'   => $this->buyer->profile->address,
                        'phone'     => $this->buyer->profile->phone,
                    ] : null,
                ];
            }),
            'items'              => $this->whenLoaded('items', function () {
                return $this->items->map(fn($item) => [
                    'id'         => $item->id,
                    'quantity'   => $item->quantity,
                    'price'      => (float) $item->price,
                    'subtotal'   => (float) ($item->price * $item->quantity),
                    'product'    => $item->relationLoaded('product') ? [
                        'id'     => $item->product->id,
                        'name'   => $item->product->name,
                        'images' => $item->product->images,
                        'image_url' => $item->product->images ? $item->product->images[0] : null,
                    ] : null,
                ]);
            }),
        ];
    }
}
