<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CocreateRoomResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'               => $this->id,
            'name'             => $this->name,
            'description'      => $this->description,
            'status'           => $this->status,
            'created_at'       => $this->created_at->toDateTimeString(),
            'creator'          => $this->whenLoaded('creator', fn() => [
                'id'   => $this->creator->id,
                'name' => $this->creator->name,
                'role' => $this->creator->role,
            ]),
            'participants_count' => $this->whenCounted('participants'),
            'participants'       => $this->whenLoaded('participants', fn() =>
                $this->participants->map(fn($p) => [
                    'id'        => $p->user_id,
                    'name'      => $p->user->name,
                    'role'      => $p->user->role,
                    'joined_at' => $p->joined_at?->toDateTimeString(),
                ])
            ),
        ];
    }
}
