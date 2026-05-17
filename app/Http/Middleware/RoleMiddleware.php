<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Middleware untuk checking apakah user memiliki role tertentu.
     * 
     * Usage: ->middleware('role:admin,umkm')
     * Jika user punya minimal satu dari role yang disebutkan, request diizinkan.
     * 
     * Khusus untuk role 'admin', user HARUS memiliki role admin.
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        if (!$request->user()) {
            return response()->json(['message' => 'Unauthenticated.'], 401);
        }

        $user = $request->user();

        // Special case: jika request memerlukan 'admin' role, strict check
        if (in_array('admin', $roles)) {
            if (!$user->isAdmin()) {
                return response()->json([
                    'message' => 'Forbidden. Hanya admin yang dapat mengakses.',
                    'your_roles' => $user->getRoleNames(),
                    'required_roles' => $roles,
                ], 403);
            }
            return $next($request);
        }

        // Untuk role lain, cek apakah user punya minimal satu dari role yang diminta
        if (!$user->hasRole($roles)) {
            return response()->json([
                'message' => 'Forbidden. Anda tidak memiliki akses ke resource ini.',
                'your_roles' => $user->getRoleNames(),
                'required_roles' => $roles,
            ], 403);
        }

        return $next($request);
    }
}

