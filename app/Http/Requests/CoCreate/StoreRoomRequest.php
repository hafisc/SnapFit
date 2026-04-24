<?php

namespace App\Http\Requests\CoCreate;

use Illuminate\Foundation\Http\FormRequest;

class StoreRoomRequest extends FormRequest
{
    public function authorize(): bool
    {
        // UMKM atau Desainer bisa buat room
        return in_array($this->user()?->role, ['umkm', 'desainer']);
    }

    public function rules(): array
    {
        return [
            'name'        => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:1000'],
        ];
    }
}
