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
            'created_at'         => $this->created_at->toDateTimeString(),
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
                    ] : null,
                ]);
            }),
        ];
    }
}
