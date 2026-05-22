<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class AiImageGenerationService
{
    /**
     * Generate product images using AI
     */
    public function generateProductImages(string $originalImageUrl, string $prompt): array
    {
        $analysis = null;
        $images = [];

        // Step 1: Get AI text analysis from Groq
        if ($groqKey = config('services.groq.api_key')) {
            $analysis = $this->getTextAnalysis($originalImageUrl, $prompt, $groqKey);
        }

        // Step 2: Generate images with Replicate (Flux)
        if ($replicateKey = config('services.replicate.api_key')) {
            $images = $this->generateWithReplicate($originalImageUrl, $prompt, $replicateKey);
        }

        return [
            'images' => $images,
            'analysis' => $analysis,
        ];
    }

    /**
     * Get text analysis from Groq
     */
    private function getTextAnalysis(string $imageUrl, string $prompt, string $apiKey): ?string
    {
        try {
            $response = Http::withHeaders([
                'Authorization' => "Bearer {$apiKey}",
                'Content-Type' => 'application/json',
            ])->timeout(60)->post('https://api.groq.com/openai/v1/chat/completions', [
                'model' => 'llama-3.1-8b-instant',
                'messages' => [
                    [
                        'role' => 'user',
                        'content' => "Analyze this product photography request: '{$prompt}'. The product image URL is: {$imageUrl}\n\nProvide a detailed AI Product Studio report in Markdown format in Indonesian language.\n\nInclude:\n1. 📸 **Analisis Produk & Rekomendasi Styling** - lighting, angle kamera, background\n2. ✍️ **Kaption Pemasaran** - 3 variasi caption Instagram/TikTok (casual, profesional, persuasif) dengan emoji\n3. 🏷️ **Hashtag** - 10 hashtag relevan dan trending\n4. 🎨 **Target Audiens & Vibe** - target market dan aesthetic\n\nBuat seperti senior creative director yang menasihati UMKM.",
                    ],
                ],
                'max_tokens' => 2000,
                'temperature' => 0.7,
            ]);

            if ($response->successful()) {
                return $response->json('choices.0.message.content', '');
            }

            Log::error('Groq Analysis Error', ['status' => $response->status(), 'body' => $response->body()]);
        } catch (\Exception $e) {
            Log::error('Groq Analysis Exception', ['error' => $e->getMessage()]);
        }

        return null;
    }

    /**
     * Generate images using Replicate API (Flux Schnell - free model)
     */
    private function generateWithReplicate(string $imageUrl, string $prompt, string $apiKey): array
    {
        try {
            $enhancedPrompt = $this->enhancePrompt($prompt);

            // Use flux-schnell which is free on Replicate
            $response = Http::withHeaders([
                'Authorization' => "Token {$apiKey}",
                'Content-Type' => 'application/json',
                'Prefer' => 'wait',
            ])->timeout(120)->post('https://api.replicate.com/v1/models/black-forest-labs/flux-schnell/predictions', [
                'input' => [
                    'prompt' => $enhancedPrompt,
                    'num_outputs' => 1,
                    'aspect_ratio' => '1:1',
                    'output_format' => 'webp',
                    'output_quality' => 80,
                ],
            ]);

            if ($response->successful()) {
                $output = $response->json('output');

                if ($output) {
                    $images = is_array($output) ? $output : [$output];
                    Log::info('Replicate Flux Schnell success', ['count' => count($images)]);
                    return $images;
                }

                // If async, poll
                $predictionUrl = $response->json('urls.get');
                if ($predictionUrl) {
                    return $this->pollReplicate($predictionUrl, $apiKey);
                }
            }

            Log::error('Replicate API Error', ['status' => $response->status(), 'body' => $response->body()]);
        } catch (\Exception $e) {
            Log::error('Replicate Exception', ['error' => $e->getMessage()]);
        }

        return [];
    }

    /**
     * Poll Replicate for async prediction result
     */
    private function pollReplicate(string $url, string $apiKey): array
    {
        for ($i = 0; $i < 30; $i++) {
            sleep(2);
            try {
                $res = Http::withHeaders(['Authorization' => "Token {$apiKey}"])->get($url);
                if ($res->successful()) {
                    $status = $res->json('status');
                    if ($status === 'succeeded') {
                        $output = $res->json('output');
                        return is_array($output) ? $output : [$output];
                    }
                    if ($status === 'failed' || $status === 'canceled') break;
                }
            } catch (\Exception $e) {
                Log::error('Replicate poll error', ['error' => $e->getMessage()]);
                break;
            }
        }
        return [];
    }

    /**
     * Generate with OpenRouter as fallback for text analysis
     */
    private function generateWithOpenRouter(string $imageUrl, string $prompt, string $apiKey): array
    {
        try {
            $response = Http::withHeaders([
                'Authorization' => "Bearer {$apiKey}",
                'Content-Type' => 'application/json',
                'HTTP-Referer' => config('app.url'),
                'X-Title' => 'SnapFit AI Studio',
            ])->timeout(60)->post('https://openrouter.ai/api/v1/chat/completions', [
                'model' => 'openrouter/free',
                'messages' => [
                    [
                        'role' => 'system',
                        'content' => 'You are a professional product photographer and creative director helping Indonesian UMKM. Answer in Indonesian.',
                    ],
                    [
                        'role' => 'user',
                        'content' => "Analyze this product photography prompt: '{$prompt}'. Image URL: {$imageUrl}\n\nProvide a detailed report in Markdown with: styling recommendations, 3 caption variations, 10 hashtags, and target audience analysis.",
                    ],
                ],
                'max_tokens' => 2000,
                'temperature' => 0.7,
            ]);

            if ($response->successful()) {
                return ['images' => [], 'analysis' => $response->json('choices.0.message.content', '')];
            }
        } catch (\Exception $e) {
            Log::error('OpenRouter Exception', ['error' => $e->getMessage()]);
        }

        return ['images' => [], 'analysis' => null];
    }

    /**
     * Enhance prompt for image generation
     */
    private function enhancePrompt(string $prompt): string
    {
        $base = "Professional product photography, high quality, studio lighting, clean background, e-commerce catalog style";
        return empty($prompt) ? $base : "{$prompt}, {$base}";
    }
}
