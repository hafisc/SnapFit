<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RoleApplication extends Model
{
    protected $fillable = [
        'user_id',
        'requested_role',
        'status',
        'data',
        'rejection_reason',
        'reviewed_at',
    ];

    protected $casts = [
        'data' => 'array',
        'reviewed_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
