<?php

namespace App\Http\Controllers;

use App\Http\Requests\Profile\UpdateProfileRequest;
use App\Http\Resources\UserResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    /**
     * Lihat profil user yang login.
     */
    public function show(Request $request): JsonResponse
    {
        return response()->json([
            'user' => new UserResource($request->user()->load('profile', 'roles')),
        ]);
    }

    /**
     * Update profil user.
     */
    public function update(UpdateProfileRequest $request): JsonResponse
    {
        $user    = $request->user();
        $profile = $user->profile;

        if (!$profile) {
            $profile = $user->profile()->create(['full_name' => $user->name]);
        }

        $profile->update($request->validated());

        return response()->json([
            'message' => 'Profil berhasil diperbarui.',
            'user'    => new UserResource($user->fresh()->load('profile', 'roles')),
        ]);
    }

    /**
     * Get role menu untuk profile page.
     * 
     * Mengembalikan list menu role yang bisa ditampilkan di profile page.
     * Untuk setiap role, tampilkan status apakah user sudah punya role tersebut.
     */
    public function getRoleMenu(Request $request): JsonResponse
    {
        $user = $request->user();

        // Skip untuk admin
        if ($user->isAdmin()) {
            return response()->json([
                'message' => 'Admin tidak bisa switch role.',
                'roles' => [],
            ]);
        }

        $roles = [];

        // Check pending applications
        $applications = \App\Models\RoleApplication::where('user_id', $user->id)
            ->whereIn('status', ['pending', 'rejected'])
            ->get()->keyBy('requested_role');

        // Role UMKM
        if ($user->hasRole('umkm')) {
            $roles[] = [
                'name' => 'umkm',
                'display_name' => 'UMKM Dashboard',
                'status' => 'active',
                'action' => 'switch',
                'url' => '/umkm/dashboard',
            ];
        } else {
            $app = $applications['umkm'] ?? null;
            if ($app && $app->status === 'pending') {
                $roles[] = [
                    'name' => 'umkm',
                    'display_name' => 'Daftar sebagai UMKM',
                    'status' => 'pending',
                    'action' => 'wait',
                ];
            } else if ($app && $app->status === 'rejected') {
                $roles[] = [
                    'name' => 'umkm',
                    'display_name' => 'Daftar sebagai UMKM',
                    'status' => 'rejected',
                    'action' => 'register',
                    'url' => '/register/umkm',
                    'rejection_reason' => $app->rejection_reason,
                ];
            } else {
                $roles[] = [
                    'name' => 'umkm',
                    'display_name' => 'Daftar sebagai UMKM',
                    'status' => 'inactive',
                    'action' => 'register',
                    'url' => '/register/umkm',
                ];
            }
        }

        // Role Designer
        if ($user->hasRole('designer')) {
            $roles[] = [
                'name' => 'designer',
                'display_name' => 'Designer Dashboard',
                'status' => 'active',
                'action' => 'switch',
                'url' => '/designer/dashboard',
            ];
        } else {
            $app = $applications['designer'] ?? null;
            if ($app && $app->status === 'pending') {
                $roles[] = [
                    'name' => 'designer',
                    'display_name' => 'Daftar sebagai Designer',
                    'status' => 'pending',
                    'action' => 'wait',
                ];
            } else if ($app && $app->status === 'rejected') {
                $roles[] = [
                    'name' => 'designer',
                    'display_name' => 'Daftar sebagai Designer',
                    'status' => 'rejected',
                    'action' => 'register',
                    'url' => '/register/designer',
                    'rejection_reason' => $app->rejection_reason,
                ];
            } else {
                $roles[] = [
                    'name' => 'designer',
                    'display_name' => 'Daftar sebagai Designer',
                    'status' => 'inactive',
                    'action' => 'register',
                    'url' => '/register/designer',
                ];
            }
        }

        return response()->json([
            'message' => 'Role menu retrieved.',
            'current_active_role' => $user->active_role,
            'roles' => $roles,
        ]);
    }

    /**
     * Switch active role.
     */
    public function switchRole(Request $request): JsonResponse
    {
        $request->validate([
            'role' => 'required|string|in:buyer,umkm,designer',
        ]);

        $user = $request->user();

        // Admin tidak bisa switch role
        if ($user->isAdmin()) {
            return response()->json([
                'message' => 'Admin tidak bisa switch role.',
            ], 403);
        }

        // Cek apakah user memiliki role yang diminta
        if (!$user->hasRole($request->role)) {
            return response()->json([
                'message' => 'Anda tidak memiliki role tersebut.',
            ], 403);
        }

        // Switch role
        $user->update(['active_role' => $request->role]);

        return response()->json([
            'message' => 'Role berhasil diubah ke: ' . $request->role,
            'user' => new UserResource($user->fresh()->load('profile', 'roles')),
        ]);
    }
    /**
     * Register a new role for the user.
     */
    public function registerRole(Request $request): JsonResponse
    {
        $request->validate([
            'role' => 'required|string|in:umkm,designer',
            'data' => 'nullable|array'
        ]);

        $user = $request->user();

        // Admin cannot register new roles like this
        if ($user->isAdmin()) {
            return response()->json([
                'message' => 'Admin tidak bisa mendaftar role baru.',
            ], 403);
        }

        // Check if user already has the role
        if ($user->hasRole($request->role)) {
            return response()->json([
                'message' => 'Anda sudah memiliki role ' . $request->role,
            ], 400);
        }

        // Check if application already pending
        $pending = \App\Models\RoleApplication::where('user_id', $user->id)
            ->where('requested_role', $request->role)
            ->where('status', 'pending')
            ->first();

        if ($pending) {
            return response()->json([
                'message' => 'Anda sudah mengajukan pendaftaran untuk role ini. Menunggu verifikasi admin.',
            ], 400);
        }

        // Create application
        \App\Models\RoleApplication::create([
            'user_id' => $user->id,
            'requested_role' => $request->role,
            'status' => 'pending',
            'data' => $request->data ?? [],
        ]);

        return response()->json([
            'message' => 'Pengajuan berhasil dikirim! Silakan tunggu verifikasi dari Admin.',
            'user' => new UserResource($user->fresh()->load('profile', 'roles')),
        ]);
    }
}

