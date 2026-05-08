<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Laravel\Socialite\Facades\Socialite;

class AuthController extends Controller
{
    /**
     * Register user baru (UMKM atau Desainer).
     */
    public function register(RegisterRequest $request): JsonResponse
    {
        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => $request->role,
        ]);

        // Buat profil kosong otomatis
        Profile::create([
            'user_id'   => $user->id,
            'full_name' => $request->name,
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'Registrasi berhasil. Selamat datang di SnapFit!',
            'user'    => new UserResource($user->load('profile')),
            'token'   => $token,
        ], 201);
    }

    /**
     * Login user.
     */
    public function login(LoginRequest $request): JsonResponse
    {
        if (!Auth::attempt($request->only('email', 'password'))) {
            throw ValidationException::withMessages([
                'email' => 'Email atau password salah.',
            ]);
        }

        $user = Auth::user();

        // Hapus token lama & buat yang baru
        $user->tokens()->delete();
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'Login berhasil.',
            'user'    => new UserResource($user->load('profile')),
            'token'   => $token,
        ]);
    }

    /**
     * Logout user.
     */
    public function logout(Request $request): JsonResponse
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Logout berhasil.']);
    }

    /**
     * Data user yang sedang login.
     */
    public function me(Request $request): JsonResponse
    {
        return response()->json([
            'user' => new UserResource($request->user()->load('profile')),
        ]);
    }

    /**
     * Redirect to Google OAuth.
     */
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->stateless()->redirect();
    }

    /**
     * Handle Google OAuth Callback.
     */
    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->stateless()->user();
            
            // Check if user exists by email
            $user = User::where('email', $googleUser->getEmail())->first();
            
            if (!$user) {
                // Create user if not exists
                $user = User::create([
                    'name' => $googleUser->getName(),
                    'email' => $googleUser->getEmail(),
                    'password' => null,
                    'google_id' => $googleUser->getId(),
                    'role' => 'pembeli', // Default role for OAuth
                ]);
                
                // Create empty profile
                Profile::create([
                    'user_id'   => $user->id,
                    'full_name' => $googleUser->getName(),
                ]);
            } elseif (!$user->google_id) {
                // Link existing user to google
                $user->update(['google_id' => $googleUser->getId()]);
            }
            
            // Generate token
            $user->tokens()->delete();
            $token = $user->createToken('auth_token')->plainTextToken;
            
            // Redirect to frontend with token
            return redirect()->away(url('/login') . '?token=' . $token . '&role=' . $user->role);
            
        } catch (\Exception $e) {
            return redirect()->away(url('/login') . '?error=Terjadi kesalahan saat login dengan Google.');
        }
    }
}
