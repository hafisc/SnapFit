<?php

namespace App\Http\Controllers;

use App\Models\RoleApplication;
use App\Models\Role;
use App\Services\GroqVerificationService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RoleApplicationController extends Controller
{
    /**
     * Submit UMKM role application with AI verification.
     */
    public function submitUmkm(Request $request): JsonResponse
    {
        $request->validate([
            'store_name' => 'required|string|max:255',
            'owner_name' => 'required|string|max:255',
            'category' => 'required|string|max:100',
            'origin_city' => 'required|string|max:100',
            'address' => 'required|string|max:500',
            'whatsapp' => 'required|string|max:20',
            'description' => 'required|string|min:30',
            'brand_story' => 'nullable|string',
            'logo_url' => 'nullable|string',
            'sample_product_image' => 'nullable|string',
            'identity_number' => 'nullable|string|max:30',
            'identity_document_url' => 'nullable|string',
            'instagram' => 'nullable|string|max:255',
            'website' => 'nullable|string|max:255',
        ]);

        $user = $request->user();

        // Check if user already has UMKM role
        if ($user->hasRole('umkm')) {
            return response()->json(['message' => 'Anda sudah terdaftar sebagai UMKM.'], 400);
        }

        // Check if there's already a pending/ai_reviewing application
        $existing = RoleApplication::where('user_id', $user->id)
            ->where('requested_role', 'umkm')
            ->whereIn('status', ['submitted', 'ai_reviewing', 'approved'])
            ->first();

        if ($existing) {
            return response()->json([
                'message' => 'Anda sudah memiliki pengajuan yang sedang diproses.',
                'application' => $existing,
            ], 400);
        }

        // Delete old rejected applications so user can reapply
        RoleApplication::where('user_id', $user->id)
            ->where('requested_role', 'umkm')
            ->whereIn('status', ['rejected', 'need_review', 'draft', 'pending'])
            ->delete();

        $formData = $request->only([
            'store_name', 'owner_name', 'category', 'origin_city',
            'address', 'whatsapp', 'description', 'brand_story',
            'logo_url', 'sample_product_image', 'identity_number',
            'identity_document_url', 'instagram', 'website',
        ]);

        // Create application with status 'ai_reviewing'
        $application = RoleApplication::create([
            'user_id' => $user->id,
            'requested_role' => 'umkm',
            'status' => 'ai_reviewing',
            'data' => $formData,
            'submitted_at' => now(),
        ]);

        // Run AI verification
        $groq = new GroqVerificationService();
        $aiResult = $groq->verifyUmkm($formData);

        // Update application with AI result
        $application->update([
            'status' => $aiResult['status'],
            'ai_score' => $aiResult['score'] ?? null,
            'ai_summary' => $aiResult['summary'] ?? null,
            'ai_issues' => $aiResult['issues'] ?? [],
            'ai_recommendations' => $aiResult['recommendations'] ?? [],
            'ai_result' => $aiResult,
            'ai_verified_at' => now(),
        ]);

        // If approved, assign role immediately
        if ($aiResult['status'] === 'approved') {
            $this->assignRole($user, 'umkm');
        }

        return response()->json([
            'message' => 'Verifikasi AI selesai.',
            'application' => [
                'id' => $application->id,
                'status' => $application->status,
                'ai_score' => $application->ai_score,
                'ai_summary' => $application->ai_summary,
                'ai_issues' => $application->ai_issues,
                'ai_recommendations' => $application->ai_recommendations,
                'ai_verified_at' => $application->ai_verified_at,
            ],
        ]);
    }

    /**
     * Submit Designer role application with AI verification.
     */
    public function submitDesigner(Request $request): JsonResponse
    {
        $request->validate([
            'display_name' => 'required|string|max:255',
            'city' => 'required|string|max:100',
            'skills' => 'required|array|min:1',
            'skills.*' => 'string',
            'bio' => 'required|string|min:30',
            'experience' => 'required|string',
            'portfolio_url' => 'nullable|string|max:500',
            'sample_work_url' => 'nullable|string',
            'tools' => 'nullable|array',
            'tools.*' => 'string',
            'collaboration_interest' => 'nullable|string',
            'whatsapp' => 'required|string|max:20',
            'rate' => 'nullable|string|max:100',
        ]);

        $user = $request->user();

        // Check if user already has Designer role
        if ($user->hasRole('designer')) {
            return response()->json(['message' => 'Anda sudah terdaftar sebagai Designer.'], 400);
        }

        // Check if there's already a pending/ai_reviewing application
        $existing = RoleApplication::where('user_id', $user->id)
            ->where('requested_role', 'designer')
            ->whereIn('status', ['submitted', 'ai_reviewing', 'approved'])
            ->first();

        if ($existing) {
            return response()->json([
                'message' => 'Anda sudah memiliki pengajuan yang sedang diproses.',
                'application' => $existing,
            ], 400);
        }

        // Delete old rejected applications
        RoleApplication::where('user_id', $user->id)
            ->where('requested_role', 'designer')
            ->whereIn('status', ['rejected', 'need_review', 'draft', 'pending'])
            ->delete();

        $formData = $request->only([
            'display_name', 'city', 'skills', 'bio', 'experience',
            'portfolio_url', 'sample_work_url', 'tools',
            'collaboration_interest', 'whatsapp', 'rate',
        ]);

        // Create application with status 'ai_reviewing'
        $application = RoleApplication::create([
            'user_id' => $user->id,
            'requested_role' => 'designer',
            'status' => 'ai_reviewing',
            'data' => $formData,
            'submitted_at' => now(),
        ]);

        // Run AI verification
        $groq = new GroqVerificationService();
        $aiResult = $groq->verifyDesigner($formData);

        // Update application with AI result
        $application->update([
            'status' => $aiResult['status'],
            'ai_score' => $aiResult['score'] ?? null,
            'ai_summary' => $aiResult['summary'] ?? null,
            'ai_issues' => $aiResult['issues'] ?? [],
            'ai_recommendations' => $aiResult['recommendations'] ?? [],
            'ai_result' => $aiResult,
            'ai_verified_at' => now(),
        ]);

        // If approved, assign role immediately
        if ($aiResult['status'] === 'approved') {
            $this->assignRole($user, 'designer');
        }

        return response()->json([
            'message' => 'Verifikasi AI selesai.',
            'application' => [
                'id' => $application->id,
                'status' => $application->status,
                'ai_score' => $application->ai_score,
                'ai_summary' => $application->ai_summary,
                'ai_issues' => $application->ai_issues,
                'ai_recommendations' => $application->ai_recommendations,
                'ai_verified_at' => $application->ai_verified_at,
            ],
        ]);
    }

    /**
     * Get current user's application status.
     */
    public function status(Request $request, string $role): JsonResponse
    {
        $application = RoleApplication::where('user_id', $request->user()->id)
            ->where('requested_role', $role)
            ->latest()
            ->first();

        if (!$application) {
            return response()->json(['application' => null]);
        }

        return response()->json([
            'application' => [
                'id' => $application->id,
                'status' => $application->status,
                'data' => $application->data,
                'ai_score' => $application->ai_score,
                'ai_summary' => $application->ai_summary,
                'ai_issues' => $application->ai_issues,
                'ai_recommendations' => $application->ai_recommendations,
                'ai_verified_at' => $application->ai_verified_at,
                'submitted_at' => $application->submitted_at,
                'reviewed_at' => $application->reviewed_at,
                'rejection_reason' => $application->rejection_reason,
            ],
        ]);
    }

    /**
     * Assign role to user.
     */
    private function assignRole($user, string $roleName): void
    {
        $role = Role::where('name', $roleName)->first();
        if ($role && !$user->roles()->where('role_id', $role->id)->exists()) {
            $user->roles()->attach($role->id);
        }
    }
}
