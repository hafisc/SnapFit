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
        'ai_score',
        'ai_summary',
        'ai_issues',
        'ai_recommendations',
        'ai_result',
        'rejection_reason',
        'submitted_at',
        'ai_verified_at',
        'reviewed_at',
    ];

    protected $casts = [
        'data' => 'array',
        'ai_issues' => 'array',
        'ai_recommendations' => 'array',
        'ai_result' => 'array',
        'submitted_at' => 'datetime',
        'ai_verified_at' => 'datetime',
        'reviewed_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function isApproved(): bool
    {
        return $this->status === 'approved';
    }

    public function isNeedReview(): bool
    {
        return $this->status === 'need_review';
    }

    public function isRejected(): bool
    {
        return $this->status === 'rejected';
    }
}
