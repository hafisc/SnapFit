<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id', 'name', 'description', 'price', 'category',
        'images', 'ar_model_url', 'is_published', 'views',
        'avg_rating', 'reviews_count',
        'origin', 'badges', 'rating', 'sold'
    ];

    protected $casts = [
        'images'        => 'array',
        'badges'        => 'array',
        'is_published'  => 'boolean',
        'price'         => 'decimal:2',
        'avg_rating'    => 'float',
        'reviews_count' => 'integer',
        'rating'        => 'float',
        'sold'          => 'integer',
    ];

    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    public function wishlists(): HasMany
    {
        return $this->hasMany(Wishlist::class);
    }
}
