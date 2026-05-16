<?php

namespace App\Http\Controllers;

use App\Models\AiGeneration;
use App\Services\AiImageGenerationService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AiGenerationController extends Controller
{
    protected $aiImageService;

    public function __construct(AiImageGenerationService $aiImageService)
    {
        $this->aiImageService = $aiImageService;
    }
    /**
     * List riwayat AI generation milik UMKM.
     */
    public function index(Request $request): JsonResponse
    {
        $generations = $request->user()
            ->aiGenerations()
            ->latest()
            ->paginate(10);

        return response()->json([
            'data' => $generations->map(fn($g) => [
                'id'                 => $g->id,
                'original_image_url' => $g->original_image_url,
                'generated_images'   => $g->generated_images ?? [],
                'prompt'             => $g->prompt,
                'ai_analysis'        => $g->ai_analysis,
                'created_at'         => $g->created_at->toDateTimeString(),
            ]),
            'pagination' => [
                'total'        => $generations->total(),
                'current_page' => $generations->currentPage(),
                'last_page'    => $generations->lastPage(),
            ],
        ]);
    }

    /**
     * Generate AI images for product (NEW: actual AI generation)
     */
    public function generate(Request $request): JsonResponse
    {
        $request->validate([
            'original_image_url' => ['required', 'url'],
            'prompt'             => ['nullable', 'string', 'max:1000'],
        ]);

        try {
            // Generate images using AI service
            $result = $this->aiImageService->generateProductImages(
                $request->original_image_url,
                $request->prompt ?? 'Professional product photography'
            );

            // Save to database
            $generation = $request->user()->aiGenerations()->create([
                'original_image_url' => $request->original_image_url,
                'prompt'             => $request->prompt,
                'generated_images'   => $result['images'] ?? [],
                'ai_analysis'        => $result['analysis'] ?? null,
            ]);

            return response()->json([
                'message' => 'AI Generation berhasil.',
                'data'    => [
                    'id'                 => $generation->id,
                    'original_image_url' => $generation->original_image_url,
                    'generated_images'   => $generation->generated_images,
                    'prompt'             => $generation->prompt,
                    'ai_analysis'        => $generation->ai_analysis,
                    'created_at'         => $generation->created_at->toDateTimeString(),
                ],
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Gagal menghasilkan gambar AI.',
                'error'   => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Simpan request AI generation baru (proses AI dilakukan di sisi klien/eksternal).
     */
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'original_image_url' => ['required', 'url'],
            'prompt'             => ['nullable', 'string', 'max:1000'],
            'generated_images'   => ['nullable', 'array'],
            'generated_images.*' => ['url'],
        ]);

        $generation = $request->user()->aiGenerations()->create([
            'original_image_url' => $request->original_image_url,
            'prompt'             => $request->prompt,
            'generated_images'   => $request->generated_images ?? [],
        ]);

        return response()->json([
            'message' => 'AI Generation berhasil disimpan.',
            'data'    => [
                'id'                 => $generation->id,
                'original_image_url' => $generation->original_image_url,
                'generated_images'   => $generation->generated_images,
                'prompt'             => $generation->prompt,
                'created_at'         => $generation->created_at->toDateTimeString(),
            ],
        ], 201);
    }

    /**
     * Hapus satu riwayat generation.
     */
    public function destroy(Request $request, AiGeneration $aiGeneration): JsonResponse
    {
        if ($aiGeneration->user_id !== $request->user()->id) {
            return response()->json(['message' => 'Forbidden.'], 403);
        }

        $aiGeneration->delete();

        return response()->json(['message' => 'Riwayat AI generation dihapus.']);
    }
}
