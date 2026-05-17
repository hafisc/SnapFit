<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = ['name', 'email', 'password', 'active_role', 'google_id'];

    protected $hidden = ['password', 'remember_token'];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // ========================
    // RELATIONSHIPS
    // ========================

    /**
     * Relationship: Roles yang dimiliki user (many-to-many)
     */
    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'role_user');
    }

    /**
     * Relationship: Profile
     */
    public function profile(): HasOne
    {
        return $this->hasOne(Profile::class);
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class, 'buyer_id');
    }

    public function createdRooms(): HasMany
    {
        return $this->hasMany(CocreateRoom::class, 'creator_id');
    }

    public function roomParticipations(): HasMany
    {
        return $this->hasMany(RoomParticipant::class);
    }

    public function aiGenerations(): HasMany
    {
        return $this->hasMany(AiGeneration::class);
    }

    public function notifications(): HasMany
    {
        return $this->hasMany(Notification::class);
    }

    public function wishlists(): HasMany
    {
        return $this->hasMany(Wishlist::class);
    }

    // ========================
    // ROLE CHECKING METHODS
    // ========================

    /**
     * Check apakah user punya role tertentu (case-insensitive)
     */
    public function hasRole(string|array $roleNames): bool
    {
        $roleNames = is_array($roleNames) ? $roleNames : [$roleNames];
        return $this->roles()->whereIn('name', $roleNames)->exists();
    }

    /**
     * Check apakah user admin
     */
    public function isAdmin(): bool
    {
        return $this->hasRole('admin');
    }

    /**
     * Check apakah user punya role umkm
     */
    public function isUmkm(): bool
    {
        return $this->hasRole('umkm');
    }

    /**
     * Check apakah user punya role designer
     */
    public function isDesigner(): bool
    {
        return $this->hasRole('designer');
    }

    /**
     * Check apakah user punya role buyer (semua user punya ini)
     */
    public function isBuyer(): bool
    {
        return $this->hasRole('buyer');
    }

    /**
     * Get nama role yang sedang aktif
     */
    public function getActiveRoleName(): string
    {
        return $this->active_role ?? 'buyer';
    }

    /**
     * Set active role dan pastikan user punya role tersebut
     */
    public function switchRole(string $roleName): bool
    {
        if ($this->hasRole($roleName)) {
            $this->update(['active_role' => $roleName]);
            return true;
        }
        return false;
    }

    /**
     * Reset active role ke buyer (default saat login ulang)
     */
    public function resetActiveRole(): void
    {
        $this->update(['active_role' => 'buyer']);
    }

    /**
     * Get list semua role names yang dimiliki user
     */
    public function getRoleNames(): array
    {
        return $this->roles()->pluck('name')->toArray();
    }
}

