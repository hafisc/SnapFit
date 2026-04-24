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
            'created_at'   => $this->created_at->toDateTimeString(),
            'owner'        => $this->whenLoaded('owner', fn() => [
                'id'   => $this->owner->id,
                'name' => $this->owner->name,
                'profile' => [
                    'business_name' => $this->owner->profile?->business_name,
                    'avatar_url'    => $this->owner->profile?->avatar_url,
                ],
            ]),
        ];
    }
}
