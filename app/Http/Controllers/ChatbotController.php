<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ChatbotController extends Controller
{
    /**
     * Handle incoming chat message from user.
     */
    public function sendMessage(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'message' => ['required', 'string', 'max:1000'],
        ]);

        $userMessage = trim($validated['message']);
        if ($userMessage === '') {
            return response()->json([
                'status' => 'error',
                'message' => 'Pesan tidak boleh kosong.',
            ], 422);
        }

        $provider = (string) config('chatbot.provider', 'openai');
        $apiKey = (string) config('chatbot.api_key', '');
        $systemPrompt = (string) config('chatbot.system_prompt', '');

        // Retrieve existing conversation history from user session (up to last 6 messages for context)
        /** @var array<int, array{role: string, content: string}> $history */
        $history = $request->session()->get('chatbot_history', []);
        if (! is_array($history)) {
            $history = [];
        }

        try {
            $isFastApi = in_array(strtolower($provider), ['fastapi', 'vps'], true);
            if (! $isFastApi && empty($apiKey)) {
                $cleanReply = $this->getFallbackKnowledgeBaseResponse($userMessage);
            } else {
                try {
                    $reply = match (strtolower($provider)) {
                        'fastapi', 'vps' => $this->callFastApiGateway($userMessage),
                        'gemini' => $this->callGeminiApi($userMessage, $history, $apiKey, $systemPrompt),
                        default => $this->callOpenAiCompatibleApi($userMessage, $history, $apiKey, $systemPrompt),
                    };
                    $cleanReply = $this->sanitizePlainTextResponse($reply);
                } catch (\Throwable $apiException) {
                    Log::warning('Chatbot provider API failed, fallback to knowledge base: '.$apiException->getMessage());
                    $cleanReply = $this->getFallbackKnowledgeBaseResponse($userMessage);
                }
            }

            // Update session history
            $history[] = ['role' => 'user', 'content' => $userMessage];
            $history[] = ['role' => 'assistant', 'content' => $cleanReply];

            // Keep only the last 8 entries to avoid session bloat
            if (count($history) > 8) {
                $history = array_slice($history, -8);
            }
            $request->session()->put('chatbot_history', $history);

            return response()->json([
                'status' => 'success',
                'reply' => $cleanReply,
            ]);
        } catch (\Throwable $e) {
            Log::error('Chatbot Controller Error: '.$e->getMessage(), [
                'exception' => $e,
                'provider' => $provider,
            ]);

            return response()->json([
                'status' => 'error',
                'message' => 'Mohon maaf, saat ini sistem asisten AI sedang mengalami kendala. Silakan coba beberapa saat lagi atau hubungi kontak admin resmi kami.',
            ], 500);
        }
    }

    /**
     * Fallback response strictly compliant with Knowledge Base and rules:
     * - Pure plain text
     * - No emojis
     * - No markdown
     * - Polite, concise, and direct
     */
    protected function getFallbackKnowledgeBaseResponse(string $message): string
    {
        $normalized = strtolower(trim($message));

        // 1. Off-topic checks
        $offTopicKeywords = [
            'resep', 'masak', 'cuaca', 'politik', 'presiden', 'pemilu',
            'sepak bola', 'game', 'film', 'lagu', 'chord', 'lirik', 'crypto', 'bitcoin',
        ];
        foreach ($offTopicKeywords as $keyword) {
            if (str_contains($normalized, $keyword)) {
                return 'Wah, kalau itu di luar topik pembahasan kita nih! Ada hal seputar website UMKM ini, cara bergabung, atau kerja sama yang ingin kamu tanyakan?';
            }
        }

        // 2. Tujuan & Visi Website
        if (str_contains($normalized, 'tujuan') || str_contains($normalized, 'visi') || str_contains($normalized, 'tentang') || str_contains($normalized, 'apa itu') || str_contains($normalized, 'platform')) {
            return 'Website ini adalah platform kolaborasi dan pusat informasi UMKM yang bertujuan untuk menghubungkan para pelaku usaha, mitra, dan masyarakat secara terpadu.';
        }

        // 3. Cara Bergabung
        if (str_contains($normalized, 'gabung') || str_contains($normalized, 'daftar') || str_contains($normalized, 'cara') || str_contains($normalized, 'registrasi') || str_contains($normalized, 'ikut')) {
            return 'Saat ini website masih dalam tahap pengembangan beta. Kamu dapat memantau informasi pendaftaran melalui formulir di halaman utama atau langsung menghubungi admin resmi kami.';
        }

        // 4. Informasi Investor & Pendanaan
        if (str_contains($normalized, 'investor') || str_contains($normalized, 'investasi') || str_contains($normalized, 'modal') || str_contains($normalized, 'dana') || str_contains($normalized, 'kerja sama') || str_contains($normalized, 'mitra') || str_contains($normalized, 'proposal')) {
            return 'Kami membuka peluang kerja sama strategis bagi para investor yang ingin mendukung perkembangan UMKM. Untuk proposal atau penjadwalan diskusi, silakan hubungi tim kami melalui kontak resmi yang tertera di website.';
        }

        // 5. Default Knowledge Base Greeting / Help
        return 'Saya adalah asisten AI website UMKM. Saya dapat membantu menjelaskan tujuan platform kami, cara bergabung, maupun informasi kemitraan bagi investor. Ada topik tersebut yang ingin kamu ketahui?';
    }

    /**
     * Reset chat conversation history stored in session.
     */
    public function resetChat(Request $request): JsonResponse
    {
        $request->session()->forget('chatbot_history');

        return response()->json([
            'status' => 'success',
            'message' => 'Riwayat obrolan telah dibersihkan.',
        ]);
    }

    /**
     * Call OpenAI-compatible endpoint (OpenAI, Groq, DeepSeek, LocalAI, vLLM, custom proxy).
     *
     * @param  array<int, array{role: string, content: string}>  $history
     */
    protected function callOpenAiCompatibleApi(string $message, array $history, string $apiKey, string $systemPrompt): string
    {
        $apiUrl = (string) config('chatbot.api_url', 'https://api.openai.com/v1/chat/completions');
        $model = (string) config('chatbot.model', 'gpt-4o-mini');

        $messages = [
            ['role' => 'system', 'content' => $systemPrompt],
        ];

        foreach ($history as $chat) {
            $messages[] = [
                'role' => $chat['role'] === 'user' ? 'user' : 'assistant',
                'content' => $chat['content'],
            ];
        }

        $messages[] = ['role' => 'user', 'content' => $message];

        $headers = [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ];

        if (! empty($apiKey)) {
            $headers['Authorization'] = 'Bearer '.$apiKey;
        }

        $response = Http::withHeaders($headers)
            ->timeout(25)
            ->post($apiUrl, [
                'model' => $model,
                'messages' => $messages,
                'temperature' => 0.3,
            ]);

        if (! $response->successful()) {
            throw new \RuntimeException('AI Provider Error ('.$response->status().'): '.$response->body());
        }

        $data = $response->json();
        $content = $data['choices'][0]['message']['content'] ?? null;

        if (! is_string($content) || trim($content) === '') {
            throw new \RuntimeException('Respon dari provider AI kosong.');
        }

        return $content;
    }

    /**
     * Call Google Gemini API (generateContent).
     *
     * @param  array<int, array{role: string, content: string}>  $history
     */
    protected function callGeminiApi(string $message, array $history, string $apiKey, string $systemPrompt): string
    {
        $model = (string) config('chatbot.gemini_model', 'gemini-1.5-flash');
        $endpoint = 'https://generativelanguage.googleapis.com/v1beta/models/'.$model.':generateContent?key='.$apiKey;

        $contents = [];

        foreach ($history as $chat) {
            $contents[] = [
                'role' => $chat['role'] === 'user' ? 'user' : 'model',
                'parts' => [
                    ['text' => $chat['content']],
                ],
            ];
        }

        $contents[] = [
            'role' => 'user',
            'parts' => [
                ['text' => $message],
            ],
        ];

        $payload = [
            'systemInstruction' => [
                'parts' => [
                    ['text' => $systemPrompt],
                ],
            ],
            'contents' => $contents,
            'generationConfig' => [
                'temperature' => 0.3,
            ],
        ];

        $response = Http::withHeaders(['Content-Type' => 'application/json'])
            ->timeout(25)
            ->post($endpoint, $payload);

        if (! $response->successful()) {
            throw new \RuntimeException('Gemini API Error ('.$response->status().'): '.$response->body());
        }

        $data = $response->json();
        $text = $data['candidates'][0]['content']['parts'][0]['text'] ?? null;

        if (! is_string($text) || trim($text) === '') {
            throw new \RuntimeException('Respon dari Gemini kosong.');
        }

        return $text;
    }

    /**
     * Call self-hosted FastAPI AI Gateway (on laptop/VPS via Cloudflare Tunnel).
     */
    protected function callFastApiGateway(string $message): string
    {
        $url = (string) config('chatbot.fastapi_url', env('FASTAPI_URL', 'https://expected-memorabilia-lodging-did.trycloudflare.com/chat'));
        $secretToken = (string) config('chatbot.fastapi_secret_token', env('FASTAPI_SECRET_TOKEN', 'tikum_secret_token_2026'));

        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
            'X-Api-Key' => $secretToken,
        ])
            ->timeout(35)
            ->post($url, [
                'message' => $message,
            ]);

        if (! $response->successful()) {
            throw new \RuntimeException('FastAPI Gateway Error ('.$response->status().'): '.$response->body());
        }

        $data = $response->json();
        $reply = $data['reply'] ?? null;

        if (! is_string($reply) || trim($reply) === '') {
            throw new \RuntimeException('Respon dari FastAPI Gateway kosong.');
        }

        return $reply;
    }

    /**
     * Sanitize output to strictly comply with rules:
     * - Pure plain text only
     * - No markdown (*, _, `, ~, #, >, -)
     * - No emojis
     */
    protected function sanitizePlainTextResponse(string $text): string
    {
        // 1. Strip emojis (Unicode ranges)
        $clean = preg_replace('/[\x{1F600}-\x{1F64F}\x{1F300}-\x{1F5FF}\x{1F680}-\x{1F6FF}\x{1F1E0}-\x{1F1FF}\x{2600}-\x{26FF}\x{2700}-\x{27BF}\x{FE00}-\x{FE0F}\x{1F900}-\x{1F9FF}\x{1FA70}-\x{1FAFF}]/u', '', $text) ?? $text;

        // 2. Remove markdown formatting characters (*, _, `, ~, #, >, bullet dashes)
        $clean = preg_replace('/[*_`~#]/', '', $clean) ?? $clean;
        $clean = preg_replace('/^(\s*)[->+]\s+/m', '$1', $clean) ?? $clean;

        // 3. Remove markdown links [text](url) -> text
        $clean = preg_replace('/\[([^\]]+)\]\([^)]+\)/', '$1', $clean) ?? $clean;

        // 4. Normalize multiple empty lines to maximum single empty line
        $clean = preg_replace("/\n{3,}/", "\n\n", $clean) ?? $clean;

        return trim($clean);
    }
}
