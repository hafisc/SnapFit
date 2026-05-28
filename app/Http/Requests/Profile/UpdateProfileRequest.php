<?php

namespace App\Http\Requests\Profile;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProfileRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    public function rules(): array
    {
        $userId = $this->user()?->id;
        return [
            'name'          => ['nullable', 'string', 'max:255'],
            'email'         => ['nullable', 'email', 'max:255', 'unique:users,email,' . $userId],
            'full_name'     => ['required', 'string', 'max:255'],
            'business_name' => ['nullable', 'string', 'max:255'],
            'avatar_url'    => ['nullable', 'string', 'max:1000'],
            'phone'         => ['nullable', 'string', 'max:20'],
            'address'       => ['nullable', 'string', 'max:500'],
            'bio'           => ['nullable', 'string', 'max:1000'],
            'category'      => ['nullable', 'string', 'max:50'],
            'socials'       => ['nullable', 'array'],
            'skills'        => ['nullable', 'array'],
        ];
    }
}
