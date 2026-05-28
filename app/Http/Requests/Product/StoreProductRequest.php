<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->isUmkm();
    }

    public function rules(): array
    {
        return [
            'name'         => ['required', 'string', 'max:255'],
            'description'  => ['nullable', 'string'],
            'price'        => ['required', 'numeric', 'min:0'],
            'category'     => ['required', 'in:batik,fashion,kerajinan,makanan,aksesoris,dekorasi,minuman'],
            'images'       => ['nullable', 'array'],
            'images.*'     => ['url'],
            'ar_model_url' => ['nullable', 'string'],
            'is_published' => ['boolean'],
            'origin'       => ['nullable', 'string', 'max:255'],
            'badges'       => ['nullable', 'array'],
            'badges.*'     => ['string', 'max:50'],
        ];
    }
}
