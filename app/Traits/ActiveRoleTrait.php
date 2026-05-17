<?php

namespace App\Traits;

use Illuminate\Http\Request;

/**
 * Trait untuk menangani active_role dalam session/middleware.
 * 
 * Gunakan dalam middleware atau service untuk memastikan active_role
 * tersimpan dan di-reset sesuai aturan.
 */
trait ActiveRoleTrait
{
    /**
     * Get active role dari user.
     * Fallback ke 'buyer' jika tidak ada.
     */
    public function getActiveRole($user): string
    {
        return $user->active_role ?? 'buyer';
    }

    /**
     * Reset active role ke buyer (untuk logout/login baru).
     * Kecuali untuk admin, tetap di role mereka.
     */
    public function resetActiveRole($user): void
    {
        if (!$user->isAdmin()) {
            $user->update(['active_role' => 'buyer']);
        }
    }

    /**
     * Validasi dan set active role.
     * Hanya bisa set ke role yang user miliki.
     */
    public function setActiveRole($user, string $role): bool
    {
        if ($user->hasRole($role)) {
            $user->update(['active_role' => $role]);
            return true;
        }
        return false;
    }

    /**
     * Middleware-compatible method untuk store active_role ke request.
     * Bisa digunakan untuk tracking atau logging.
     */
    public function storeActiveRoleInRequest(Request $request, $user): void
    {
        $request->attributes->set('active_role', $user->active_role ?? 'buyer');
    }
}
