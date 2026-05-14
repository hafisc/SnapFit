# AI Product Studio - Setup Guide

## Overview
AI Product Studio menggunakan AI image generation untuk mengubah foto produk biasa menjadi foto studio profesional dengan berbagai gaya visual.

## Supported AI Services

### 1. Replicate API (Recommended) ⭐
**Model:** Stable Diffusion XL
**Best for:** High-quality product photography with img2img transformation

#### Setup:
1. Daftar di [replicate.com](https://replicate.com)
2. Dapatkan API key dari dashboard
3. Tambahkan ke `.env`:
```env
REPLICATE_API_KEY=r8_your_api_key_here
```

#### Pricing:
- Pay-per-use: ~$0.0023 per image
- Free tier: $5 credit untuk testing

---

### 2. Stability AI
**Model:** Stable Diffusion XL 1.0
**Best for:** Professional image-to-image transformation

#### Setup:
1. Daftar di [platform.stability.ai](https://platform.stability.ai)
2. Dapatkan API key
3. Tambahkan ke `.env`:
```env
STABILITY_API_KEY=sk-your_api_key_here
```

#### Pricing:
- Pay-per-use: ~$0.04 per image
- Free tier: 25 credits untuk testing

---

### 3. Groq API (Already Configured)
**Model:** LLaMA 3.2 Vision
**Best for:** Prompt enhancement and image analysis

Groq API sudah dikonfigurasi untuk AR Try-On. Untuk AI Studio, Groq digunakan untuk:
- Enhance user prompts
- Analyze product images
- Generate better descriptions

---

## How It Works

### Without API Key (Demo Mode)
```
User uploads image + prompt
    ↓
System returns variations of original image
    ↓
Saved to database with prompt
```

### With Replicate API
```
User uploads image + prompt
    ↓
Send to Replicate API (Stable Diffusion img2img)
    ↓
Wait for generation (20-40 seconds)
    ↓
Receive 4 AI-generated variations
    ↓
Save to database
```

### With Stability AI
```
User uploads image + prompt
    ↓
Download original image
    ↓
Send to Stability AI API
    ↓
Receive base64 encoded images
    ↓
Convert and save to storage
    ↓
Save URLs to database
```

---

## Configuration

### 1. Add API Keys to `.env`
```env
# AI Image Generation
REPLICATE_API_KEY=r8_xxxxxxxxxxxxxxxxxxxxx
STABILITY_API_KEY=sk-xxxxxxxxxxxxxxxxxxxxx

# Already configured
GROQ_API_KEY=gsk_xxxxxxxxxxxxxxxxxxxxx
```

### 2. Test Configuration
```bash
# Check if API keys are loaded
php artisan tinker
>>> config('services.replicate.api_key')
>>> config('services.stability.api_key')
```

### 3. Test AI Generation
```bash
# Using cURL
curl -X POST http://127.0.0.1:8000/api/v1/umkm/ai-generations/generate \
  -H "Authorization: Bearer YOUR_TOKEN" \
  -H "Content-Type: application/json" \
  -d '{
    "original_image_url": "https://example.com/product.jpg",
    "prompt": "Professional studio lighting, white background, 8k resolution"
  }'
```

---

## Prompt Engineering Tips

### Good Prompts:
✅ "Professional product photography, studio lighting, white background, 8k resolution, photorealistic"
✅ "Minimalist aesthetic, soft shadows, natural light, clean composition"
✅ "Luxury brand style, dramatic lighting, dark background, high contrast"
✅ "E-commerce product photo, bright and clean, multiple angles"

### Bad Prompts:
❌ "Make it nice"
❌ "Good photo"
❌ "Professional"

### Prompt Structure:
```
[Main Style] + [Lighting] + [Background] + [Quality] + [Additional Details]

Example:
"Cyberpunk aesthetic, neon lighting, dark urban background, 8k resolution, glowing reflections"
```

---

## API Service Comparison

| Feature | Replicate | Stability AI | Groq |
|---------|-----------|--------------|------|
| Image Generation | ✅ Yes | ✅ Yes | ❌ No |
| Img2Img | ✅ Yes | ✅ Yes | ❌ No |
| Speed | ~30s | ~20s | ~5s |
| Quality | ⭐⭐⭐⭐⭐ | ⭐⭐⭐⭐⭐ | N/A |
| Cost | $ | $$ | Free |
| Prompt Enhancement | ❌ No | ❌ No | ✅ Yes |

---

## Troubleshooting

### Issue: "API key not configured"
**Solution:** Add API key to `.env` and restart server
```bash
php artisan config:clear
php artisan serve
```

### Issue: "Generation timeout"
**Solution:** Increase timeout in `AiImageGenerationService.php`
```php
->timeout(120) // Increase from 60 to 120 seconds
```

### Issue: "Invalid image URL"
**Solution:** Ensure image URL is publicly accessible
- Use HTTPS URLs
- Check if image is not behind authentication
- Verify image format (JPG, PNG, WEBP)

### Issue: "Rate limit exceeded"
**Solution:** 
- Wait a few minutes
- Upgrade API plan
- Implement queue system for batch processing

---

## Production Recommendations

### 1. Use Queue System
```php
// In controller
dispatch(new GenerateAiImagesJob($generation));
```

### 2. Store Images Locally
```php
// Download and save to S3/local storage
$imageData = file_get_contents($aiGeneratedUrl);
Storage::disk('s3')->put("ai-generations/{$id}.jpg", $imageData);
```

### 3. Add Caching
```php
// Cache generated images for 24 hours
Cache::remember("ai-gen-{$id}", 86400, function() {
    return $this->aiImageService->generate(...);
});
```

### 4. Implement Rate Limiting
```php
// In routes/api.php
Route::middleware('throttle:10,1')->group(function() {
    Route::post('ai-generations/generate', ...);
});
```

---

## Cost Estimation

### For 1000 Generations/Month:

**Replicate:**
- 1000 generations × 4 images × $0.0023 = **$9.20/month**

**Stability AI:**
- 1000 generations × 4 images × $0.04 = **$160/month**

**Recommendation:** Start with Replicate for cost-effectiveness

---

## Alternative: Self-Hosted AI

### Using Stable Diffusion Locally:
```bash
# Install Automatic1111 WebUI
git clone https://github.com/AUTOMATIC1111/stable-diffusion-webui
cd stable-diffusion-webui
./webui.sh --api

# Update .env
STABLE_DIFFUSION_API_URL=http://localhost:7860
```

### Pros:
- ✅ No API costs
- ✅ Full control
- ✅ Privacy

### Cons:
- ❌ Requires GPU (RTX 3060+ recommended)
- ❌ Slower generation
- ❌ Maintenance overhead

---

## Support

For issues or questions:
1. Check logs: `storage/logs/laravel.log`
2. Enable debug mode: `APP_DEBUG=true` in `.env`
3. Test API directly using Postman/cURL
4. Check API service status pages

---

## Next Steps

1. ✅ Add API key to `.env`
2. ✅ Test generation with sample image
3. ✅ Monitor API usage and costs
4. ✅ Implement queue system for production
5. ✅ Add image storage (S3/CloudFlare R2)
6. ✅ Setup monitoring and alerts
