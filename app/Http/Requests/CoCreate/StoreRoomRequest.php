<?php

namespace App\Http\Requests\CoCreate;

use Illuminate\Foundation\Http\FormRequest;

class StoreRoomRequest extends FormRequest
{
    public function authorize(): bool
    {
        // UMKM atau Desainer bisa buat room
        $role = $this->user()?->getActiveRoleName();
        return in_array($role, ['umkm', 'designer']);
    }

    public function rules(): array
    {
        return [
            'name'           => ['required', 'string', 'max:255'],
            'description'    => ['nullable', 'string', 'max:1000'],
            'invite_user_id' => ['nullable', 'exists:users,id'],
        ];
    }
}
