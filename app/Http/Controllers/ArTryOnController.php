<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ArTryOnController extends Controller
{
    /**
     * Analyze how a product would look on the user using Groq AI (LLaMA Vision).
     * Accepts a base64 user photo + product info, returns AI styling analysis.
     */
    public function analyze(Request $request): JsonResponse
    {
        $request->validate([
            'user_photo'   => ['required', 'string'], // base64 image
            'product_name' => ['required', 'string'],
            'product_category' => ['nullable', 'string'],
            'product_description' => ['nullable', 'string'],
        ]);

        $apiKey = config('services.groq.api_key');

        if (!$apiKey) {
            return response()->json([
                'message' => 'API key Groq belum dikonfigurasi.',
            ], 500);
        }

        $productName = $request->product_name;
        $productCategory = $request->product_category ?? 'fashion';
        $productDesc = $request->product_description ?? '';

        $systemPrompt = <<<PROMPT
Kamu adalah asisten fashion AI bernama SnapFit AR Stylist yang ahli dalam analisis gaya busana Indonesia, terutama batik dan kerajinan tradisional.

Tugasmu:
1. Analisis foto pengguna (postur tubuh, warna kulit, bentuk tubuh)
2. Berikan rekomendasi styling untuk produk "{$productName}" ({$productCategory})
3. Jelaskan bagaimana produk akan terlihat pada pengguna
4. Berikan skor kecocokan (1-100)
5. Berikan tips pemakaian

Format respons dalam JSON seperti ini:
{
  "match_score": 85,
  "body_analysis": "Deskripsi singkat analisis tubuh pengguna",
  "styling_recommendation": "Rekomendasi gaya pemakaian produk",
  "how_it_looks": "Deskripsi visual bagaimana produk akan terlihat pada pengguna",
  "color_harmony": "Analisis keserasian warna produk dengan pengguna",
  "occasion_tips": ["Acara 1", "Acara 2", "Acara 3"],
  "pairing_suggestions": ["Saran paduan 1", "Saran paduan 2"],
  "confidence_note": "Catatan tentang tingkat keyakinan analisis"
}

Jawab dalam Bahasa Indonesia yang profesional dan ramah.
PROMPT;

        try {
            $response = Http::withHeaders([
                'Authorization' => "Bearer {$apiKey}",
                'Content-Type'  => 'application/json',
            ])->timeout(30)->post('https://api.groq.com/openai/v1/chat/completions', [
                'model'    => 'llama-3.2-11b-vision-preview',
                'messages' => [
                    [
                        'role'    => 'system',
                        'content' => $systemPrompt,
                    ],
                    [
                        'role'    => 'user',
                        'content' => [
                            [
                                'type' => 'text',
                                'text' => "Analisis foto saya dan berikan rekomendasi styling untuk produk: {$productName}. Deskripsi produk: {$productDesc}. Kategori: {$productCategory}. Berikan respons dalam format JSON.",
                            ],
                            [
                                'type'      => 'image_url',
                                'image_url' => [
                                    'url' => $request->user_photo,
                                ],
                            ],
                        ],
                    ],
                ],
                'max_tokens'  => 1024,
                'temperature' => 0.7,
                'response_format' => ['type' => 'json_object'],
            ]);

            if ($response->failed()) {
                Log::error('Groq API Error', [
                    'status' => $response->status(),
                    'body'   => $response->body(),
                ]);

                return response()->json([
                    'message' => 'Gagal menghubungi AI service.',
                    'error'   => $response->json('error.message', 'Unknown error'),
                ], 502);
            }

            $content = $response->json('choices.0.message.content', '{}');

            // Try to parse as JSON
            $analysis = json_decode($content, true);
            if (json_last_error() !== JSON_ERROR_NONE) {
                // If not valid JSON, wrap it
                $analysis = [
                    'match_score'            => 75,
                    'styling_recommendation' => $content,
                    'how_it_looks'           => 'Analisis AI tersedia dalam format teks.',
                    'body_analysis'          => '-',
                    'color_harmony'          => '-',
                    'occasion_tips'          => [],
                    'pairing_suggestions'    => [],
                    'confidence_note'        => 'Analisis dalam format teks.',
                ];
            }

            return response()->json([
                'message'  => 'Analisis AR Try-On berhasil.',
                'analysis' => $analysis,
            ]);

        } catch (\Exception $e) {
            Log::error('AR Try-On Exception', ['error' => $e->getMessage()]);

            return response()->json([
                'message' => 'Terjadi kesalahan saat memproses AR Try-On.',
                'error'   => $e->getMessage(),
            ], 500);
        }
    }
}
