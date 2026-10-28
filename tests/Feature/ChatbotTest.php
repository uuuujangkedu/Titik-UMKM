<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class ChatbotTest extends TestCase
{
    public function test_rejects_empty_message(): void
    {
        $response = $this->postJson(route('chatbot.message'), [
            'message' => '',
        ]);

        $response->assertStatus(422);
    }

    public function test_successful_chat_with_openai_compatible_api_and_sanitizes_plain_text(): void
    {
        Config::set('chatbot.provider', 'openai');
        Config::set('chatbot.api_key', 'test-key');
        Config::set('chatbot.api_url', 'https://api.openai.com/v1/chat/completions');

        Http::fake([
            'https://api.openai.com/v1/chat/completions' => Http::response([
                'choices' => [
                    [
                        'message' => [
                            // Notice: Response contains markdown and emoji to test the sanitizer
                            'content' => 'Halo! 😊 Ini adalah informasi seputar **tujuan** platform kami.',
                        ],
                    ],
                ],
            ], 200),
        ]);

        $response = $this->postJson(route('chatbot.message'), [
            'message' => 'Apa tujuan platform ini?',
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'status' => 'success',
                // Asterisks and emoji must be completely stripped
                'reply' => 'Halo!  Ini adalah informasi seputar tujuan platform kami.',
            ]);
    }

    public function test_successful_chat_with_gemini_api(): void
    {
        Config::set('chatbot.provider', 'gemini');
        Config::set('chatbot.api_key', 'gemini-key');

        Http::fake([
            'https://generativelanguage.googleapis.com/*' => Http::response([
                'candidates' => [
                    [
                        'content' => [
                            'parts' => [
                                ['text' => 'Website ini masih dalam tahap pengembangan beta.'],
                            ],
                        ],
                    ],
                ],
            ], 200),
        ]);

        $response = $this->postJson(route('chatbot.message'), [
            'message' => 'Bagaimana cara bergabung?',
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'status' => 'success',
                'reply' => 'Website ini masih dalam tahap pengembangan beta.',
            ]);
    }

    public function test_reset_conversation_history(): void
    {
        $response = $this->withSession([
            'chatbot_history' => [
                ['role' => 'user', 'content' => 'Halo'],
                ['role' => 'assistant', 'content' => 'Halo ada yang bisa dibantu?'],
            ],
        ])->postJson(route('chatbot.reset'));

        $response->assertStatus(200)
            ->assertJson([
                'status' => 'success',
            ]);

        $this->assertNull(session('chatbot_history'));
    }

    public function test_successful_chat_with_fastapi_gateway(): void
    {
        Config::set('chatbot.provider', 'fastapi');
        Config::set('chatbot.fastapi_url', 'https://expected-memorabilia-lodging-did.trycloudflare.com/chat');
        Config::set('chatbot.fastapi_secret_token', 'tikum_secret_token_2026');

        Http::fake([
            'https://expected-memorabilia-lodging-did.trycloudflare.com/chat' => Http::response([
                'reply' => 'Halo! Titik UMKM (TIKUM) adalah platform kolaborasi terpadu.',
            ], 200),
        ]);

        $response = $this->postJson(route('chatbot.message'), [
            'message' => 'Apa itu TIKUM?',
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'status' => 'success',
                'reply' => 'Halo! Titik UMKM (TIKUM) adalah platform kolaborasi terpadu.',
            ]);
    }

    public function test_fallback_knowledge_base_response_when_api_key_empty(): void
    {
        Config::set('chatbot.provider', 'openai');
        Config::set('chatbot.api_key', '');

        $response = $this->postJson(route('chatbot.message'), [
            'message' => 'Apa tujuan website ini?',
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'status' => 'success',
                'reply' => 'Website ini adalah platform kolaborasi dan pusat informasi UMKM yang bertujuan untuk menghubungkan para pelaku usaha, mitra, dan masyarakat secara terpadu.',
            ]);
    }

    public function test_rejects_off_topic_questions_politely(): void
    {
        Config::set('chatbot.provider', 'openai');
        Config::set('chatbot.api_key', '');

        $response = $this->postJson(route('chatbot.message'), [
            'message' => 'Bagaimana resep nasi goreng kambing?',
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'status' => 'success',
                'reply' => 'Wah, kalau itu di luar topik pembahasan kita nih! Ada hal seputar website UMKM ini, cara bergabung, atau kerja sama yang ingin kamu tanyakan?',
            ]);
    }

    public function test_successful_chat_with_tokenharbor_direct_api(): void
    {
        Config::set('chatbot.provider', 'openai');
        Config::set('chatbot.api_key', 'thk_live_test_key');
        Config::set('chatbot.api_url', 'https://tokenharbor.ai/v1/chat/completions');
        Config::set('chatbot.model', 'deepseek-v4.1-flash:free');

        Http::fake([
            'https://tokenharbor.ai/v1/chat/completions' => Http::response([
                'choices' => [
                    [
                        'message' => [
                            'content' => 'Halo! Titik UMKM adalah platform terpadu untuk pelaku usaha.',
                        ],
                    ],
                ],
            ], 200),
        ]);

        $response = $this->postJson(route('chatbot.message'), [
            'message' => 'Apa itu Titik UMKM?',
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'status' => 'success',
                'reply' => 'Halo! Titik UMKM adalah platform terpadu untuk pelaku usaha.',
            ]);
    }
}
