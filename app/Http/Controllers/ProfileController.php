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
            'user' => new UserResource($request->user()->load('profile')),
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
            'user'    => new UserResource($user->fresh()->load('profile')),
        ]);
    }
}
