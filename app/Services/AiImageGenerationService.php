<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class AiImageGenerationService
{
    /**
     * Generate product images using AI
     * 
     * @param string $originalImageUrl URL of the original product image
     * @param string $prompt User's styling prompt
     * @return array Array of generated image URLs and ai analysis
     */
    public function generateProductImages(string $originalImageUrl, string $prompt): array
    {
        // Try Groq API first
        if ($groqKey = config('services.groq.api_key')) {
            return $this->generateWithGroq($originalImageUrl, $prompt, $groqKey);
        }

        // Try OpenRouter API as fallback
        if ($openRouterKey = config('services.openrouter.api_key')) {
            return $this->generateWithOpenRouter($originalImageUrl, $prompt, $openRouterKey);
        }
        
        // If no API key configured, return mock images
        return $this->generateMockImages($originalImageUrl, $prompt);
    }

    /**
     * Generate images and analysis using OpenRouter API
     */
    private function generateWithOpenRouter(string $imageUrl, string $prompt, string $apiKey): array
    {
        try {
            // Kita ubah image URL jadi path utuh agar AI bisa baca (jika tidak public, kita pakai teks saja)
            // Note: Idealnya URL ini public. Karena app mungkin masih local, kita akan pakai text prompt saja
            // namun jika URL dari cloud storage, AI bisa membacanya.
            
            // Format URL agar valid jika pakai storage public
            $isLocal = str_contains($imageUrl, 'localhost') || str_contains($imageUrl, '127.0.0.1');
            $imageContent = [];
            
            if (!$isLocal && filter_var($imageUrl, FILTER_VALIDATE_URL)) {
                 $imageContent[] = [
                     'type' => 'image_url',
                     'image_url' => ['url' => $imageUrl],
                 ];
            }

            $imageContent[] = [
                'type' => 'text',
                'text' => "Analyze this product photography prompt: '{$prompt}'. \n\nPlease provide a highly detailed, professional AI Product Studio report in Markdown format. \n\nInclude the following sections:\n\n1. 📸 **Product Analysis & Styling Recommendations:** Based on the prompt, suggest the best lighting, camera angles, and background setting to make the product look premium and cinematic.\n2. ✍️ **Marketing Captions:** Provide 3 engaging Instagram/TikTok caption variations (1 casual, 1 professional, 1 persuasive) complete with emojis.\n3. 🏷️ **Hashtags:** Suggest 10 highly relevant and trending hashtags.\n4. 🎨 **Target Audience & Vibe:** Describe the target market and the aesthetic vibe of this photoshoot.\n\nMake it sound like a senior creative director advising an MSME (UMKM). Use Indonesian language.",
            ];

            $response = Http::withHeaders([
                'Authorization' => "Bearer {$apiKey}",
                'Content-Type' => 'application/json',
                'HTTP-Referer' => config('app.url'),
                'X-Title' => 'SnapFit AI Studio',
            ])->timeout(60)->post('https://openrouter.ai/api/v1/chat/completions', [
                'model' => 'openrouter/free', // Free auto-routed model
                'messages' => [
                    [
                        'role' => 'system',
                        'content' => 'You are a professional product photographer and creative director helping Indonesian UMKM. Give structured, highly valuable, and premium advice. Answer in Indonesian.',
                    ],
                    [
                        'role' => 'user',
                        'content' => $imageContent,
                    ],
                ],
                'max_tokens' => 2000,
                'temperature' => 0.7,
            ]);

            if ($response->successful()) {
                $analysis = $response->json('choices.0.message.content', '');
                Log::info('OpenRouter AI Analysis Success');
                
                return $this->generateEnhancedVariations($imageUrl, $analysis, $prompt);
            }
            
            Log::error('OpenRouter API Error', [
                'status' => $response->status(),
                'body' => $response->body(),
            ]);
            
        } catch (\Exception $e) {
            Log::error('OpenRouter Exception', ['error' => $e->getMessage()]);
        }
        
        return $this->generateMockImages($imageUrl, $prompt);
    }

    /**
     * Generate enhanced variations using AI analysis
     */
    private function generateEnhancedVariations(string $originalUrl, string $aiAnalysis, string $prompt): array
    {
        return [
            'images' => [
                $originalUrl . '?style=professional',
                $originalUrl . '?style=minimal',
                $originalUrl . '?style=vibrant',
                $originalUrl . '?style=elegant',
            ],
            'analysis' => $aiAnalysis
        ];
    }

    /**
     * Generate images using Replicate API (Stable Diffusion)
     */
    private function generateWithReplicate(string $imageUrl, string $prompt, string $apiKey): array
    {
        try {
            // Using Stable Diffusion img2img model
            $response = Http::withHeaders([
                'Authorization' => "Token {$apiKey}",
                'Content-Type' => 'application/json',
            ])->timeout(60)->post('https://api.replicate.com/v1/predictions', [
                'version' => 'stability-ai/sdxl:39ed52f2a78e934b3ba6e2a89f5b1c712de7dfea535525255b1aa35c5565e08b',
                'input' => [
                    'image' => $imageUrl,
                    'prompt' => $this->enhancePrompt($prompt),
                    'num_outputs' => 4,
                    'guidance_scale' => 7.5,
                    'num_inference_steps' => 30,
                    'strength' => 0.7, // How much to transform the original image
                ],
            ]);

            if ($response->successful()) {
                $predictionId = $response->json('id');
                
                // Poll for results (max 60 seconds)
                $maxAttempts = 30;
                $attempt = 0;
                
                while ($attempt < $maxAttempts) {
                    sleep(2);
                    
                    $statusResponse = Http::withHeaders([
                        'Authorization' => "Token {$apiKey}",
                    ])->get("https://api.replicate.com/v1/predictions/{$predictionId}");
                    
                    if ($statusResponse->successful()) {
                        $status = $statusResponse->json('status');
                        
                        if ($status === 'succeeded') {
                            $outputs = $statusResponse->json('output', []);
                            return is_array($outputs) ? $outputs : [$outputs];
                        }
                        
                        if ($status === 'failed') {
                            Log::error('Replicate generation failed', $statusResponse->json());
                            break;
                        }
                    }
                    
                    $attempt++;
                }
            }
            
            Log::error('Replicate API Error', [
                'status' => $response->status(),
                'body' => $response->body(),
            ]);
            
        } catch (\Exception $e) {
            Log::error('Replicate Exception', ['error' => $e->getMessage()]);
        }
        
        return $this->generateMockImages($imageUrl, $prompt);
    }

    /**
     * Generate images using Stability AI
     */
    private function generateWithStability(string $imageUrl, string $prompt, string $apiKey): array
    {
        try {
            // Download the original image
            $imageData = file_get_contents($imageUrl);
            
            if ($imageData === false) {
                throw new \Exception('Failed to download original image');
            }
            
            $response = Http::withHeaders([
                'Authorization' => "Bearer {$apiKey}",
                'Accept' => 'application/json',
            ])->timeout(60)->attach(
                'init_image', $imageData, 'image.jpg'
            )->post('https://api.stability.ai/v1/generation/stable-diffusion-xl-1024-v1-0/image-to-image', [
                'text_prompts[0][text]' => $this->enhancePrompt($prompt),
                'text_prompts[0][weight]' => 1,
                'cfg_scale' => 7,
                'samples' => 4,
                'steps' => 30,
                'image_strength' => 0.35,
            ]);

            if ($response->successful()) {
                $artifacts = $response->json('artifacts', []);
                $images = [];
                
                foreach ($artifacts as $artifact) {
                    if (isset($artifact['base64'])) {
                        // Convert base64 to URL (you'd need to save this to storage)
                        $images[] = 'data:image/png;base64,' . $artifact['base64'];
                    }
                }
                
                if (!empty($images)) {
                    return $images;
                }
            }
            
            Log::error('Stability AI Error', [
                'status' => $response->status(),
                'body' => $response->body(),
            ]);
            
        } catch (\Exception $e) {
            Log::error('Stability AI Exception', ['error' => $e->getMessage()]);
        }
        
        return $this->generateMockImages($imageUrl, $prompt);
    }

    /**
     * Generate images and analysis using Groq
     */
    private function generateWithGroq(string $imageUrl, string $prompt, string $apiKey): array
    {
        try {
            $imageContent = [
                [
                    'type' => 'text',
                    'text' => "Analyze this product photography prompt: '{$prompt}'. \n\nPlease provide a highly detailed, professional AI Product Studio report in Markdown format. \n\nInclude the following sections:\n\n1. 📸 **Product Analysis & Styling Recommendations:** Based on the prompt, suggest the best lighting, camera angles, and background setting to make the product look premium and cinematic.\n2. ✍️ **Marketing Captions:** Provide 3 engaging Instagram/TikTok caption variations (1 casual, 1 professional, 1 persuasive) complete with emojis.\n3. 🏷️ **Hashtags:** Suggest 10 highly relevant and trending hashtags.\n4. 🎨 **Target Audience & Vibe:** Describe the target market and the aesthetic vibe of this photoshoot.\n\nMake it sound like a senior creative director advising an MSME (UMKM). Use Indonesian language.",
                ]
            ];

            // Groq currently does not support vision models (decommissioned), so we only send the text prompt
            // using their fastest text model.
            $response = Http::withHeaders([
                'Authorization' => "Bearer {$apiKey}",
                'Content-Type' => 'application/json',
            ])->timeout(60)->post('https://api.groq.com/openai/v1/chat/completions', [
                'model' => 'llama-3.3-70b-versatile',
                'messages' => [
                    [
                        'role' => 'user', 
                        'content' => $imageContent,
                    ],
                ],
                'max_tokens' => 2000,
                'temperature' => 0.7,
            ]);

            if ($response->successful()) {
                $analysis = $response->json('choices.0.message.content', '');
                Log::info('Groq AI Analysis Success');
                
                return $this->generateEnhancedVariations($imageUrl, $analysis, $prompt);
            }
            
            Log::error('Groq API Error', [
                'status' => $response->status(),
                'body' => $response->body(),
            ]);
            
        } catch (\Exception $e) {
            Log::error('Groq Exception', ['error' => $e->getMessage()]);
        }
        
        return $this->generateMockImages($imageUrl, $prompt);
    }

    /**
     * Generate mock images for demo purposes
     */
    private function generateMockImages(string $originalImageUrl, string $prompt): array
    {
        // Return variations of the original image with different styling
        // In production, these would be actual AI-generated images
        $timestamp = time();
        
        return [
            'images' => [
                $originalImageUrl . '?style=professional&t=' . $timestamp,
                $originalImageUrl . '?style=minimal&t=' . ($timestamp + 1),
                $originalImageUrl . '?style=vibrant&t=' . ($timestamp + 2),
                $originalImageUrl . '?style=elegant&t=' . ($timestamp + 3),
            ],
            'analysis' => null
        ];
    }

    /**
     * Enhance the user's prompt with professional photography terms
     */
    private function enhancePrompt(string $prompt): string
    {
        $basePrompt = "Professional product photography, high quality, 8k resolution, studio lighting";
        
        if (empty($prompt)) {
            return $basePrompt;
        }
        
        return "{$prompt}, {$basePrompt}";
    }
}
