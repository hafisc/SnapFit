<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        // Pastikan UMKM hanya bisa edit produk miliknya
        $product = $this->route('product');
        return $this->user()?->isUmkm() && $product->user_id === $this->user()->id;
    }

    public function rules(): array
    {
        return [
            'name'         => ['sometimes', 'string', 'max:255'],
            'description'  => ['nullable', 'string'],
            'price'        => ['sometimes', 'numeric', 'min:0'],
            'category'     => ['sometimes', 'in:batik,fashion,kerajinan,makanan,aksesoris,dekorasi,minuman'],
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
