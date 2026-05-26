<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CocreateRoom extends Model
{
    protected $fillable = ['name', 'creator_id', 'description', 'status', 'canvas_data', 'canvas_updated_at'];

    protected $casts = [
        'canvas_updated_at' => 'datetime',
    ];

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'creator_id');
    }

    public function participants(): HasMany
    {
        return $this->hasMany(RoomParticipant::class, 'room_id');
    }
}
