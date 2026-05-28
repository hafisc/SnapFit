<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'              => $this->id,
            'name'            => $this->name,
            'email'           => $this->email,
            'active_role'     => $this->active_role ?? 'buyer',
            'owned_roles'     => $this->whenLoaded('roles', fn() => 
                $this->roles->pluck('name')->toArray()
            ),
            'is_admin'        => $this->isAdmin(),
            'is_umkm'         => $this->isUmkm(),
            'is_designer'     => $this->isDesigner(),
            'is_buyer'        => $this->isBuyer(),
            'created_at'      => $this->created_at->toDateTimeString(),
            'profile'         => $this->whenLoaded('profile', fn() => [
                'full_name'     => $this->profile?->full_name,
                'business_name' => $this->profile?->business_name,
                'avatar_url'    => $this->profile?->avatar_url,
                'phone'         => $this->profile?->phone,
                'address'       => $this->profile?->address,
                'bio'           => $this->profile?->bio,
                'category'      => $this->profile?->category,
                'socials'       => $this->profile?->socials,
                'skills'        => $this->isDesigner() ? 
                    (\App\Models\RoleApplication::where('user_id', $this->id)->where('requested_role', 'designer')->latest()->first()?->data['skills'] ?? ['UI/UX Design', 'Packaging', 'Branding', 'Product Photography', 'Figma', 'Adobe Photoshop'])
                    : null,
            ]),
        ];
    }
}

