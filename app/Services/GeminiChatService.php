<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GeminiChatService
{
    private string $apiKey;
    private string $baseUrl;
    private string $defaultModel;
    private array $fallbackModels;
    private array $generationConfig;
    private array $safetySettings;
    private string $defaultSystemInstruction;

    public function __construct()
    {
        $this->apiKey = config('gemini.api_key') ?? config('services.gemini.api_key', '');
        $this->baseUrl = rtrim(config('gemini.base_url', 'https://generativelanguage.googleapis.com/v1beta'), '/');
        $this->defaultModel = config('gemini.default_model', 'gemini-3.1-flash-lite');
        $this->fallbackModels = config('gemini.fallback_models', [
            'gemini-3.1-flash-lite',
            'gemini-2.5-flash-lite',
            'gemini-3.5-flash',
            'gemini-3-flash',
            'gemini-2.5-flash',
        ]);
        $this->generationConfig = config('gemini.generation_config', [
            'temperature' => 0.7,
            'maxOutputTokens' => 1024,
        ]);
        $this->safetySettings = config('gemini.safety_settings', []);

        // Guardrails Persona: Ramah, Aman untuk Anak (10-14th), Edukatif, dan Menolak Topik Dewasa/Bahaya dengan Sopan.
        $this->defaultSystemInstruction = 'Kamu adalah guru Sekolah Dasar & Menengah di Indonesia yang sangat ramah, sabar, dan menyenangkan. '
            . 'Tugasmu adalah membimbing dan menjawab pertanyaan pelajaran dari anak-anak usia 10-14 tahun. '
            . 'Aturan Keamanan (Guardrails Utama): '
            . '1. Gunakan bahasa Indonesia yang baku namun sederhana, komunikatif, dan mudah dipahami anak kecil. '
            . '2. Jawab HANYA hal-hal seputar materi pelajaran sekolah (Matematika, Sains, Bahasa, Pengetahuan Umum) dan edukasi positif. '
            . '3. Jika anak bertanya hal yang tidak pantas, kekerasan, materi dewasa, atau di luar konteks sekolah, tolak secara halus dan arahkan kembali ke pelajaran dengan ramah (contoh: "Wah, topik itu bukan materi sekolah kita ya, Dek! Yuk kita belajar Matematika atau Sains saja!"). '
            . '4. Berikan perumpamaan sederhana dan selalu konfirmasi pemahaman anak di akhir penjelasan.';
    }

    /**
     * Kirim pesan ke Gemini API dengan otomatis Looping/Fallback ke model berikutnya jika limit/error,
     * serta menerapkan Safety Guardrails untuk anak.
     *
     * @param  string  $userMessage  Pesan baru pengguna.
     * @param  array   $history      Riwayat percakapan sebelumnya.
     * @param  string|null $customSystemPrompt Prompt instruksi khusus/persona per topik.
     * @return array{text: string, model: string} Hasil respon AI dan model yang berhasil digunakan.
     *
     * @throws \Exception Jika seluruh model candidate gagal dipanggil.
     */
    public function sendMessage(string $userMessage, array $history = [], ?string $customSystemPrompt = null): array
    {
        // Susun riwayat percakapan + pesan user baru
        $contents = $history;
        $contents[] = [
            'role' => 'user',
            'parts' => [['text' => $userMessage]],
        ];

        // Penggabungan Guardrails System Instruction
        $systemPrompt = $customSystemPrompt
            ? $customSystemPrompt . "\n\nGuardrails Tambahan: Gunakan bahasa yang sopan dan ramah untuk anak usia 10-14 tahun. Tolak topik berbahaya atau di luar edukasi secara santun."
            : $this->defaultSystemInstruction;

        $payload = [
            'system_instruction' => [
                'parts' => [['text' => $systemPrompt]],
            ],
            'contents' => $contents,
            'generationConfig' => $this->generationConfig,
            'safetySettings' => $this->safetySettings,
        ];

        // Buat urutan model yang akan dicoba (Default model di urutan pertama)
        $modelsToTry = array_unique(array_merge([$this->defaultModel], $this->fallbackModels));
        $lastException = null;

        foreach ($modelsToTry as $modelName) {
            $endpointUrl = "{$this->baseUrl}/models/{$modelName}:generateContent";

            try {
                $response = Http::withQueryParameters(['key' => $this->apiKey])
                    ->timeout(30)
                    ->post($endpointUrl, $payload);

                // Jika sukses (200 OK)
                if ($response->successful()) {
                    $data = $response->json();
                    $candidate = $data['candidates'][0] ?? null;

                    // Cek jika diblokir oleh Safety Guardrail Gemini
                    if (isset($candidate['finishReason']) && $candidate['finishReason'] === 'SAFETY') {
                        return [
                            'text' => 'Maaf ya Dek, Kakak AI tidak bisa menjawab pertanyaan tersebut karena mengandung topik yang tidak sesuai untuk anak-anak. Yuk, kita tanyakan soal pelajaran sekolah saja! 😊',
                            'model' => $modelName,
                        ];
                    }

                    $replyText = $candidate['content']['parts'][0]['text'] ?? null;

                    if ($replyText) {
                        Log::info("Gemini API call success using model [{$modelName}]");
                        return [
                            'text' => $replyText,
                            'model' => $modelName,
                        ];
                    }
                }

                // Jika gagal (Rate limit 429, Server error 500/503, dll)
                $statusCode = $response->status();
                Log::warning("Gemini API call failed for model [{$modelName}]", [
                    'status' => $statusCode,
                    'body' => mb_substr($response->body(), 0, 200),
                ]);

            } catch (\Exception $e) {
                Log::warning("Gemini API exception for model [{$modelName}]: {$e->getMessage()}");
                $lastException = $e;
            }
        }

        // Jika seluruh model candidate telah dicoba dan semuanya gagal
        Log::error("All Gemini fallback models failed/exhausted.", ['models_tried' => $modelsToTry]);

        throw new \Exception(
            'Layanan AI sedang padat atau mencapai kuota harian. Silakan coba lagi beberapa saat lagi.',
            503,
            $lastException
        );
    }

    /**
     * Bangun array history dari koleksi ChatMessage untuk dikirim ke Gemini.
     *
     * @param  \Illuminate\Database\Eloquent\Collection  $messages
     * @return array<array{role: string, parts: array}>
     */
    public function buildHistoryFromMessages($messages): array
    {
        return $messages->map(function ($msg) {
            return [
                'role' => $msg->sender_type === 'user' ? 'user' : 'model',
                'parts' => [['text' => $msg->message]],
            ];
        })->values()->toArray();
    }
}
