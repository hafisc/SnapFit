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
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Laravel\Socialite\Facades\Socialite;

class AuthController extends Controller
{
    /**
     * Register user baru.
     * 
     * User baru SELALU dimulai sebagai BUYER.
     * Jika ingin daftar sebagai UMKM/Designer, gunakan endpoint register/umkm atau register/designer.
     */
    public function register(RegisterRequest $request): JsonResponse
    {
        // Buat user dengan active_role default 'buyer'
        $user = User::create([
            'name'        => $request->name,
            'email'       => $request->email,
            'password'    => Hash::make($request->password),
            'active_role' => 'buyer', // Always start as buyer
        ]);

        // Assign buyer role secara otomatis
        $buyerRole = DB::table('roles')->where('name', 'buyer')->first();
        $user->roles()->attach($buyerRole->id);

        // Buat profil kosong otomatis
        Profile::create([
            'user_id'   => $user->id,
            'full_name' => $request->name,
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'Registrasi berhasil. Selamat datang di SnapFit!',
            'user'    => new UserResource($user->load('profile', 'roles')),
            'token'   => $token,
        ], 201);
    }

    /**
     * Register UMKM (endpoint terpisah).
     * Hanya bisa dipanggil oleh user yang sudah login sebagai buyer.
     * Setelah registrasi, active_role diubah menjadi 'umkm'.
     */
    public function registerUmkm(Request $request): JsonResponse
    {
        $request->validate([
            'business_name' => 'required|string|max:255',
            'business_phone' => 'nullable|string',
            'business_address' => 'nullable|string',
            'business_bio' => 'nullable|string',
        ]);

        $user = Auth::user();

        // Cek apakah sudah punya role UMKM
        if ($user->hasRole('umkm')) {
            return response()->json([
                'message' => 'Anda sudah terdaftar sebagai UMKM.',
            ], 400);
        }

        // Assign UMKM role
        $umkmRole = DB::table('roles')->where('name', 'umkm')->first();
        $user->roles()->attach($umkmRole->id);

        // Update profile dengan data UMKM
        if (!$user->profile) {
            Profile::create(['user_id' => $user->id, 'full_name' => $user->name]);
        }
        
        $user->profile->update([
            'business_name' => $request->business_name,
            'phone' => $request->business_phone,
            'address' => $request->business_address,
            'bio' => $request->business_bio,
        ]);

        // Set active_role ke umkm
        $user->update(['active_role' => 'umkm']);

        return response()->json([
            'message' => 'Anda berhasil terdaftar sebagai UMKM!',
            'user' => new UserResource($user->fresh()->load('profile', 'roles')),
            'redirect_url' => $this->getDashboardUrl('umkm'),
        ]);
    }

    /**
     * Register Designer (endpoint terpisah).
     * Hanya bisa dipanggil oleh user yang sudah login sebagai buyer.
     * Setelah registrasi, active_role diubah menjadi 'designer'.
     */
    public function registerDesigner(Request $request): JsonResponse
    {
        $request->validate([
            'designer_name' => 'nullable|string|max:255',
            'designer_portfolio_url' => 'nullable|url',
            'designer_bio' => 'nullable|string',
        ]);

        $user = Auth::user();

        // Cek apakah sudah punya role Designer
        if ($user->hasRole('designer')) {
            return response()->json([
                'message' => 'Anda sudah terdaftar sebagai Designer.',
            ], 400);
        }

        // Assign Designer role
        $designerRole = DB::table('roles')->where('name', 'designer')->first();
        $user->roles()->attach($designerRole->id);

        // Update profile dengan data Designer
        if (!$user->profile) {
            Profile::create(['user_id' => $user->id, 'full_name' => $user->name]);
        }
        
        $user->profile->update([
            'bio' => $request->designer_bio,
        ]);

        // Set active_role ke designer
        $user->update(['active_role' => 'designer']);

        return response()->json([
            'message' => 'Anda berhasil terdaftar sebagai Designer!',
            'user' => new UserResource($user->fresh()->load('profile', 'roles')),
            'redirect_url' => $this->getDashboardUrl('designer'),
        ]);
    }

    /**
     * Login user.
     * 
     * User akan diarahkan ke dashboard yang sesuai dengan active_role mereka:
     * - buyer → /dashboard (marketplace)
     * - umkm → /umkm/dashboard
     * - designer → /designer/dashboard
     * - admin → /admin/dashboard
     */
    public function login(LoginRequest $request): JsonResponse
    {
        if (!Auth::attempt($request->only('email', 'password'))) {
            throw ValidationException::withMessages([
                'email' => 'Email atau password salah.',
            ]);
        }

        $user = Auth::user();

        // Jangan reset active_role - biarkan user tetap di role terakhir mereka
        // Hanya untuk admin, tetap admin
        if (!$user->isAdmin() && !$user->hasRole($user->active_role)) {
            // Jika active_role tidak valid (misalnya role dihapus), reset ke buyer
            $user->update(['active_role' => 'buyer']);
        }

        // Hapus token lama & buat yang baru
        $user->tokens()->delete();
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'Login berhasil.',
            'user'    => new UserResource($user->load('profile', 'roles')),
            'token'   => $token,
            'redirect_url' => $this->getDashboardUrl($user->active_role),
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
        $user = $request->user();
        return response()->json([
            'user' => new UserResource($user->load('profile', 'roles')),
        ]);
    }

    /**
     * Switch active role user.
     * 
     * User bisa switch ke role yang sudah dimiliki.
     */
    public function switchRole(Request $request): JsonResponse
    {
        $request->validate([
            'role' => 'required|string|in:buyer,umkm,designer',
        ]);

        $user = $request->user();

        if ($user->switchRole($request->role)) {
            return response()->json([
                'message' => 'Role berhasil diubah.',
                'user' => new UserResource($user->fresh()->load('profile', 'roles')),
            ]);
        }

        return response()->json([
            'message' => 'Anda tidak memiliki role tersebut.',
        ], 403);
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
     * 
     * Flow:
     * 1. Cek email apakah sudah ada
     * 2. Jika ada → login (keep their active_role)
     * 3. Jika belum ada → buat akun baru dengan role buyer
     */
    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->stateless()->user();
            $email = $googleUser->getEmail();

            // Cek apakah user sudah ada berdasarkan email
            $user = User::where('email', $email)->first();

            if (!$user) {
                // Buat user baru dengan active_role='buyer'
                $user = User::create([
                    'name'        => $googleUser->getName(),
                    'email'       => $email,
                    'password'    => null,
                    'google_id'   => $googleUser->getId(),
                    'active_role' => 'buyer', // Default role
                ]);

                // Assign buyer role secara otomatis
                $buyerRole = DB::table('roles')->where('name', 'buyer')->first();
                $user->roles()->attach($buyerRole->id);

                // Buat profil kosong
                Profile::create([
                    'user_id'   => $user->id,
                    'full_name' => $googleUser->getName(),
                    'avatar_url'=> $googleUser->getAvatar(),
                ]);
            } else {
                // User sudah ada
                if (!$user->google_id) {
                    // Link Google ID jika belum terhubung
                    $user->update(['google_id' => $googleUser->getId()]);
                }

                if ($user->profile && !$user->profile->avatar_url) {
                    $user->profile->update(['avatar_url' => $googleUser->getAvatar()]);
                }

                // Jangan reset active_role - biarkan user tetap di role terakhir mereka
                if (!$user->isAdmin() && !$user->hasRole($user->active_role)) {
                    // Jika active_role tidak valid, reset ke buyer
                    $user->update(['active_role' => 'buyer']);
                }
            }

            // Generate token
            $user->tokens()->delete();
            $token = $user->createToken('auth_token')->plainTextToken;

            // Arahkan ke dashboard yang sesuai dengan active_role mereka
            $frontendUrl = config('app.frontend_url', 'http://localhost:5174');
            $redirectPath = $this->getDashboardUrl($user->active_role);

            return redirect()->away($frontendUrl . $redirectPath . '?token=' . $token);
        } catch (\Exception $e) {
            $frontendUrl = config('app.frontend_url', 'http://localhost:5174');
            return redirect()->away($frontendUrl . '/?error=' . urlencode('Terjadi kesalahan saat login dengan Google.'));
        }
    }

    /**
     * Helper: Dapatkan dashboard URL berdasarkan active_role.
     */
    private function getDashboardUrl(string $role): string
    {
        return match($role) {
            'admin' => '/admin/dashboard',
            'umkm' => '/umkm/dashboard',
            'designer' => '/designer/dashboard',
            default => '/dashboard', // buyer
        };
    }
}

