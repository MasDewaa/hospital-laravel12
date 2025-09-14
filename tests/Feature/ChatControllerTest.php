<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Chat;
use App\Models\Patient;
use App\Models\Doctor;
use App\Services\GeminiService;
use App\Services\RAGService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Mockery;

class ChatControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected $user;
    protected $patient;
    protected $doctor;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Create test user
        $this->user = User::factory()->create([
            'role' => 'patient',
            'email' => 'patient@test.com',
            'password' => bcrypt('password')
        ]);

        // Create patient
        $this->patient = Patient::factory()->create([
            'user_id' => $this->user->id,
            'name' => 'Test Patient',
            'email' => 'patient@test.com'
        ]);

        // Create doctor
        $this->doctor = Doctor::factory()->create([
            'name' => 'Dr. Test',
            'specialization' => 'General Medicine',
            'email' => 'doctor@test.com'
        ]);
    }

    public function test_send_message_success()
    {
        // Mock services
        $this->mock(GeminiService::class, function ($mock) {
            $mock->shouldReceive('generateResponse')
                ->once()
                ->andReturn('Test AI response');
        });

        $this->mock(RAGService::class, function ($mock) {
            $mock->shouldReceive('retrieveContext')
                ->once()
                ->andReturn([]);
        });

        $response = $this->actingAs($this->user)
            ->postJson('/chat/send', [
                'message' => 'Test message'
            ]);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'success',
                'session_id',
                'user_message',
                'ai_response'
            ]);

        $this->assertDatabaseHas('chats', [
            'user_id' => $this->user->id,
            'sender' => 'user',
            'message' => 'Test message'
        ]);

        $this->assertDatabaseHas('chats', [
            'user_id' => $this->user->id,
            'sender' => 'ai',
            'message' => 'Test AI response'
        ]);
    }

    public function test_send_message_validation_error()
    {
        $response = $this->actingAs($this->user)
            ->postJson('/chat/send', [
                'message' => ''
            ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['message']);
    }

    public function test_send_message_unauthorized()
    {
        $response = $this->postJson('/chat/send', [
            'message' => 'Test message'
        ]);

        $response->assertStatus(401);
    }

    public function test_test_gemini_success()
    {
        $this->mock(GeminiService::class, function ($mock) {
            $mock->shouldReceive('generateResponse')
                ->once()
                ->andReturn('Test response');
        });

        $response = $this->getJson('/chat/test-gemini');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'success',
                'message',
                'test_response',
                'timestamp'
            ]);
    }

    public function test_test_gemini_failure()
    {
        $this->mock(GeminiService::class, function ($mock) {
            $mock->shouldReceive('generateResponse')
                ->once()
                ->andThrow(new \Exception('API Error'));
        });

        $response = $this->getJson('/chat/test-gemini');

        $response->assertStatus(500)
            ->assertJsonStructure([
                'success',
                'message',
                'error',
                'timestamp'
            ]);
    }

    public function test_get_faq_success()
    {
        $this->mock(RAGService::class, function ($mock) {
            $mock->shouldReceive('getFAQ')
                ->once()
                ->andReturn([
                    [
                        'question' => 'Test question',
                        'answer' => 'Test answer'
                    ]
                ]);
        });

        $response = $this->getJson('/chat/faq');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'success',
                'data',
                'timestamp'
            ]);
    }

    public function test_get_similar_questions_success()
    {
        // Create some test chat data
        Chat::factory()->create([
            'user_id' => $this->user->id,
            'sender' => 'user',
            'message' => 'Test question about services'
        ]);

        $this->mock(RAGService::class, function ($mock) {
            $mock->shouldReceive('getSimilarQuestions')
                ->once()
                ->andReturn([
                    [
                        'question' => 'Test question about services',
                        'time' => 'Sep 14, 10:30'
                    ]
                ]);
        });

        $response = $this->getJson('/chat/similar-questions?query=services');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'success',
                'data',
                'query',
                'timestamp'
            ]);
    }

    public function test_get_similar_questions_validation_error()
    {
        $response = $this->getJson('/chat/similar-questions');

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['query']);
    }

    public function test_get_history_success()
    {
        // Create some test chat data
        Chat::factory()->count(5)->create([
            'user_id' => $this->user->id,
            'sender' => 'user'
        ]);

        $response = $this->actingAs($this->user)
            ->getJson('/chat/history');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'success',
                'data',
                'pagination',
                'timestamp'
            ]);

        $this->assertCount(5, $response->json('data'));
    }

    public function test_get_history_with_pagination()
    {
        // Create more test data
        Chat::factory()->count(15)->create([
            'user_id' => $this->user->id,
            'sender' => 'user'
        ]);

        $response = $this->actingAs($this->user)
            ->getJson('/chat/history?limit=10&offset=0');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'success',
                'data',
                'pagination',
                'timestamp'
            ]);

        $this->assertCount(10, $response->json('data'));
    }

    public function test_get_stats_success()
    {
        // Create test chat data
        Chat::factory()->count(10)->create([
            'user_id' => $this->user->id,
            'sender' => 'user'
        ]);

        Chat::factory()->count(10)->create([
            'user_id' => $this->user->id,
            'sender' => 'ai'
        ]);

        $response = $this->actingAs($this->user)
            ->getJson('/chat/stats');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'success',
                'data',
                'timestamp'
            ])
            ->assertJson([
                'data' => [
                    'total_messages' => 20,
                    'user_messages' => 10,
                    'ai_messages' => 10,
                    'total_sessions' => 1,
                ]
            ]);
    }

    public function test_get_stats_with_session_filter()
    {
        $sessionId = 'test-session-123';
        
        // Create test data with specific session
        Chat::factory()->count(5)->create([
            'user_id' => $this->user->id,
            'session_id' => $sessionId,
            'sender' => 'user'
        ]);

        $response = $this->actingAs($this->user)
            ->getJson("/chat/stats?session_id={$sessionId}");

        $response->assertStatus(200)
            ->assertJson([
                'data' => [
                    'total_messages' => 5,
                    'user_messages' => 5,
                    'ai_messages' => 0,
                ]
            ]);
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }
}