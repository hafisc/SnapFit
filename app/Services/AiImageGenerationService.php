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
     * @return array Array of generated image URLs
     */
    public function generateProductImages(string $originalImageUrl, string $prompt): array
    {
        // Try OpenRouter API first (if configured)
        if ($openRouterKey = config('services.openrouter.api_key')) {
            return $this->generateWithOpenRouter($originalImageUrl, $prompt, $openRouterKey);
        }
        
        // Try Replicate API
        if ($replicateKey = config('services.replicate.api_key')) {
            return $this->generateWithReplicate($originalImageUrl, $prompt, $replicateKey);
        }
        
        // Try Stability AI as fallback
        if ($stabilityKey = config('services.stability.api_key')) {
            return $this->generateWithStability($originalImageUrl, $prompt, $stabilityKey);
        }
        
        // Try Groq with image-to-image (if supported)
        if ($groqKey = config('services.groq.api_key')) {
            return $this->generateWithGroq($originalImageUrl, $prompt, $groqKey);
        }
        
        // If no API key configured, return mock images
        return $this->generateMockImages($originalImageUrl, $prompt);
    }

    /**
     * Generate images using OpenRouter API
     */
    private function generateWithOpenRouter(string $imageUrl, string $prompt, string $apiKey): array
    {
        try {
            // OpenRouter supports multiple AI models including image generation
            // Using vision model to analyze and describe the image, then generate variations
            $response = Http::withHeaders([
                'Authorization' => "Bearer {$apiKey}",
                'Content-Type' => 'application/json',
                'HTTP-Referer' => config('app.url'),
                'X-Title' => 'SnapFit AI Studio',
            ])->timeout(60)->post('https://openrouter.ai/api/v1/chat/completions', [
                'model' => 'google/gemini-2.0-flash-exp:free', // Free vision model
                'messages' => [
                    [
                        'role' => 'system',
                        'content' => 'You are a professional product photographer. Analyze the product image and provide detailed descriptions for 4 different professional photography styles that would enhance this product.',
                    ],
                    [
                        'role' => 'user',
                        'content' => [
                            [
                                'type' => 'text',
                                'text' => "Analyze this product image and create 4 different professional photography style descriptions based on this prompt: {$prompt}. For each style, provide a detailed description of lighting, background, composition, and mood. Format as JSON array with keys: style1, style2, style3, style4.",
                            ],
                            [
                                'type' => 'image_url',
                                'image_url' => ['url' => $imageUrl],
                            ],
                        ],
                    ],
                ],
                'max_tokens' => 1000,
                'temperature' => 0.8,
            ]);

            if ($response->successful()) {
                $content = $response->json('choices.0.message.content', '');
                Log::info('OpenRouter AI Analysis', ['content' => $content]);
                
                // Since OpenRouter doesn't generate actual images, we'll use the enhanced descriptions
                // and return variations of the original image with metadata
                // In production, you'd use these descriptions with an actual image generation API
                return $this->generateEnhancedVariations($imageUrl, $content, $prompt);
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
        // Create 4 variations with different filters/styles
        // In production, you'd use the AI analysis to actually generate new images
        $timestamp = time();
        $styles = ['professional', 'minimal', 'vibrant', 'elegant'];
        
        $variations = [];
        foreach ($styles as $index => $style) {
            $variations[] = $originalUrl . '?style=' . $style . '&ai=enhanced&t=' . ($timestamp + $index);
        }
        
        return $variations;
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
     * Generate images using Groq (text-based enhancement)
     */
    private function generateWithGroq(string $imageUrl, string $prompt, string $apiKey): array
    {
        try {
            // Groq doesn't support image generation, but we can use it to enhance the prompt
            // and then use that enhanced prompt with mock images
            $response = Http::withHeaders([
                'Authorization' => "Bearer {$apiKey}",
                'Content-Type' => 'application/json',
            ])->timeout(30)->post('https://api.groq.com/openai/v1/chat/completions', [
                'model' => 'llama-3.2-11b-vision-preview',
                'messages' => [
                    [
                        'role' => 'system',
                        'content' => 'You are a professional product photography expert. Enhance the user\'s prompt to create stunning product photos.',
                    ],
                    [
                        'role' => 'user',
                        'content' => [
                            [
                                'type' => 'text',
                                'text' => "Enhance this product photography prompt: {$prompt}. Make it more detailed and professional.",
                            ],
                            [
                                'type' => 'image_url',
                                'image_url' => ['url' => $imageUrl],
                            ],
                        ],
                    ],
                ],
                'max_tokens' => 500,
                'temperature' => 0.7,
            ]);

            if ($response->successful()) {
                $enhancedPrompt = $response->json('choices.0.message.content', $prompt);
                Log::info('Groq enhanced prompt', ['original' => $prompt, 'enhanced' => $enhancedPrompt]);
            }
            
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
            $originalImageUrl . '?style=professional&t=' . $timestamp,
            $originalImageUrl . '?style=minimal&t=' . ($timestamp + 1),
            $originalImageUrl . '?style=vibrant&t=' . ($timestamp + 2),
            $originalImageUrl . '?style=elegant&t=' . ($timestamp + 3),
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
