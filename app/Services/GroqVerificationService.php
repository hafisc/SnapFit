<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GroqVerificationService
{
    private string $apiKey;
    private string $baseUrl = 'https://api.groq.com/openai/v1/chat/completions';
    private string $model = 'llama-3.1-8b-instant';

    public function __construct()
    {
        $this->apiKey = config('services.groq.api_key');
    }

    /**
     * Verify UMKM application data using AI.
     */
    public function verifyUmkm(array $data): array
    {
        $prompt = $this->buildUmkmPrompt($data);
        return $this->callGroq($prompt);
    }

    /**
     * Verify Designer application data using AI.
     */
    public function verifyDesigner(array $data): array
    {
        $prompt = $this->buildDesignerPrompt($data);
        return $this->callGroq($prompt);
    }

    private function buildUmkmPrompt(array $data): string
    {
        $json = json_encode($data, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);

        return <<<PROMPT
Kamu adalah AI verifikator untuk platform SnapFit, marketplace produk kreatif lokal Indonesia. Tugasmu adalah memverifikasi kelayakan pendaftaran UMKM berdasarkan data yang diberikan.

Data Pendaftaran UMKM:
{$json}

Evaluasi berdasarkan kriteria berikut:
1. Apakah nama toko valid dan tidak kosong/asal-asalan
2. Apakah deskripsi usaha masuk akal dan cukup detail (minimal 50 karakter)
3. Apakah kategori sesuai dengan deskripsi usaha
4. Apakah produk cocok dengan konsep SnapFit (produk kreatif lokal Indonesia)
5. Apakah data alamat/daerah lengkap
6. Apakah dokumen/foto pendukung ada (logo, foto produk)
7. Apakah ada indikasi spam atau data asal-asalan
8. Apakah nomor WhatsApp terisi

Berikan response dalam format JSON SAJA (tanpa markdown, tanpa backtick, tanpa penjelasan tambahan):
{
  "status": "approved" atau "need_review" atau "rejected",
  "score": angka 0-100,
  "summary": "ringkasan evaluasi dalam bahasa Indonesia",
  "issues": ["list masalah yang ditemukan"],
  "recommendations": ["list rekomendasi perbaikan"]
}

Rules scoring:
- Score 75-100: approved (data lengkap dan valid)
- Score 50-74: need_review (data kurang lengkap tapi tidak spam)
- Score 0-49: rejected (data tidak valid/spam/asal-asalan)
PROMPT;
    }

    private function buildDesignerPrompt(array $data): string
    {
        $json = json_encode($data, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);

        return <<<PROMPT
Kamu adalah AI verifikator untuk platform SnapFit, marketplace produk kreatif lokal Indonesia. Tugasmu adalah memverifikasi kelayakan pendaftaran Designer berdasarkan data yang diberikan.

Data Pendaftaran Designer:
{$json}

Evaluasi berdasarkan kriteria berikut:
1. Apakah bio designer jelas dan profesional
2. Apakah skill/keahlian sesuai dengan deskripsi portfolio
3. Apakah link portfolio diisi
4. Apakah contoh karya tersedia (upload atau link)
5. Apakah designer cocok untuk membantu UMKM di bidang desain
6. Apakah data terlalu asal-asalan atau spam
7. Apakah pengalaman terisi dengan jelas
8. Apakah software yang dikuasai relevan

Berikan response dalam format JSON SAJA (tanpa markdown, tanpa backtick, tanpa penjelasan tambahan):
{
  "status": "approved" atau "need_review" atau "rejected",
  "score": angka 0-100,
  "summary": "ringkasan evaluasi dalam bahasa Indonesia",
  "skills_detected": ["list skill yang terdeteksi dari data"],
  "issues": ["list masalah yang ditemukan"],
  "recommendations": ["list rekomendasi perbaikan"]
}

Rules scoring:
- Score 75-100: approved (profil lengkap dan kredibel)
- Score 50-74: need_review (profil kurang lengkap tapi potensial)
- Score 0-49: rejected (data tidak valid/spam/asal-asalan)
PROMPT;
    }

    private function callGroq(string $prompt): array
    {
        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->apiKey,
                'Content-Type' => 'application/json',
            ])->timeout(30)->post($this->baseUrl, [
                'model' => $this->model,
                'messages' => [
                    [
                        'role' => 'system',
                        'content' => 'Kamu adalah AI verifikator profesional. Selalu respond dalam format JSON valid tanpa markdown formatting.'
                    ],
                    [
                        'role' => 'user',
                        'content' => $prompt,
                    ],
                ],
                'temperature' => 0.3,
                'max_tokens' => 1024,
            ]);

            if ($response->successful()) {
                $content = $response->json('choices.0.message.content');
                
                // Clean up response - remove markdown code blocks if present
                $content = preg_replace('/^```json\s*/', '', trim($content));
                $content = preg_replace('/\s*```$/', '', $content);
                $content = trim($content);

                $result = json_decode($content, true);

                if (json_last_error() === JSON_ERROR_NONE && isset($result['status'], $result['score'])) {
                    return $result;
                }

                Log::warning('Groq AI returned invalid JSON', ['content' => $content]);
                return $this->fallbackResult();
            }

            Log::error('Groq API request failed', [
                'status' => $response->status(),
                'body' => $response->body(),
            ]);

            return $this->fallbackResult();
        } catch (\Exception $e) {
            Log::error('Groq verification error', ['error' => $e->getMessage()]);
            return $this->fallbackResult();
        }
    }

    private function fallbackResult(): array
    {
        return [
            'status' => 'need_review',
            'score' => 50,
            'summary' => 'Verifikasi AI tidak dapat dilakukan saat ini. Data akan direview manual oleh admin.',
            'issues' => ['Sistem AI sedang tidak tersedia'],
            'recommendations' => ['Tunggu review manual dari admin'],
        ];
    }
}
