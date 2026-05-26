<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'           => $this->id,
            'name'         => $this->name,
            'description'  => $this->description,
            'price'        => (float) $this->price,
            'category'     => $this->category,
            'images'       => $this->images ?? [],
            'ar_model_url' => $this->ar_model_url,
            'is_published' => $this->is_published,
            'views'        => $this->views,
            'origin'       => $this->origin,
            'rating'       => $this->rating ? round((float) $this->rating, 1) : null,
            'sold'         => $this->sold ?? 0,
            'badges'       => $this->badges ?? [],
            'umkm_name'    => $this->whenLoaded('owner', fn() => $this->owner?->profile?->business_name ?? $this->owner?->name),
            'avg_rating'   => round($this->avg_rating ?? 0, 1),
            'reviews_count'=> $this->reviews_count ?? 0,
            'created_at'   => $this->created_at->toDateTimeString(),
            'owner'        => $this->whenLoaded('owner', fn() => [
                'id'   => $this->owner->id,
                'name' => $this->owner->name,
                'profile' => [
                    'business_name' => $this->owner->profile?->business_name,
                    'avatar_url'    => $this->owner->profile?->avatar_url,
                ],
                'rating' => round($this->owner->products()->avg('rating') ?? 4.8, 1),
                'sold'   => (int) $this->owner->products()->sum('sold'),
            ]),
        ];
    }
}
