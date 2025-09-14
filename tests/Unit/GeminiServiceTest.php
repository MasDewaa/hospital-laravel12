<?php

namespace Tests\Unit;

use App\Services\GeminiService;
use Gemini\Laravel\Facades\Gemini;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Config;
use Tests\TestCase;
use Mockery;

class GeminiServiceTest extends TestCase
{
    use RefreshDatabase;

    protected $geminiService;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Set up test configuration
        Config::set('gemini.model', 'gemini-1.5-flash');
        Config::set('gemini.api_key', 'test-api-key');
        Config::set('gemini.base_url', 'https://test-api.com');
        
        $this->geminiService = new GeminiService();
    }

    public function test_generate_response_success()
    {
        $mockResult = Mockery::mock();
        $mockResult->shouldReceive('text')->andReturn('Test AI response');

        Gemini::shouldReceive('generativeModel')
            ->with('model', 'gemini-1.5-flash')
            ->andReturnSelf();
        
        Gemini::shouldReceive('generateContent')
            ->andReturn($mockResult);

        $response = $this->geminiService->generateResponse('Test message', []);

        $this->assertEquals('Test AI response', $response);
    }

    public function test_generate_response_with_context()
    {
        $context = [
            'hospital_info' => [
                'name' => 'Test Hospital',
                'phone' => '123-456-7890'
            ],
            'services' => [
                'emergency' => '24/7 Emergency Service'
            ]
        ];

        $mockResult = Mockery::mock();
        $mockResult->shouldReceive('text')->andReturn('Test AI response with context');

        Gemini::shouldReceive('generativeModel')
            ->with('model', 'gemini-1.5-flash')
            ->andReturnSelf();
        
        Gemini::shouldReceive('generateContent')
            ->andReturn($mockResult);

        $response = $this->geminiService->generateResponse('Test message', $context);

        $this->assertEquals('Test AI response with context', $response);
    }

    public function test_generate_response_api_error()
    {
        Gemini::shouldReceive('generativeModel')
            ->with('model', 'gemini-1.5-flash')
            ->andReturnSelf();
        
        Gemini::shouldReceive('generateContent')
            ->andThrow(new \Exception('API Error'));

        $response = $this->geminiService->generateResponse('Test message', []);

        $this->assertStringContains('Maaf, saya mengalami gangguan teknis', $response);
    }

    public function test_test_connection_success()
    {
        $mockResult = Mockery::mock();
        $mockResult->shouldReceive('text')->andReturn('Test connection response');

        Gemini::shouldReceive('generativeModel')
            ->with('model', 'gemini-1.5-flash')
            ->andReturnSelf();
        
        Gemini::shouldReceive('generateContent')
            ->andReturn($mockResult);

        $result = $this->geminiService->testConnection();

        $this->assertTrue($result['success']);
        $this->assertEquals('Gemini API connected successfully', $result['message']);
        $this->assertEquals('Test connection response', $result['test_response']);
    }

    public function test_test_connection_failure()
    {
        Gemini::shouldReceive('generativeModel')
            ->with('model', 'gemini-1.5-flash')
            ->andReturnSelf();
        
        Gemini::shouldReceive('generateContent')
            ->andThrow(new \Exception('Connection failed'));

        $result = $this->geminiService->testConnection();

        $this->assertFalse($result['success']);
        $this->assertEquals('Gemini API connection failed', $result['message']);
        $this->assertEquals('Connection failed', $result['error']);
    }

    public function test_is_configured_with_api_key()
    {
        Config::set('gemini.api_key', 'test-api-key');
        
        $this->assertTrue($this->geminiService->isConfigured());
    }

    public function test_is_configured_without_api_key()
    {
        Config::set('gemini.api_key', '');
        
        $this->assertFalse($this->geminiService->isConfigured());
    }

    public function test_get_config()
    {
        $config = $this->geminiService->getConfig();

        $this->assertArrayHasKey('model', $config);
        $this->assertArrayHasKey('api_key_configured', $config);
        $this->assertArrayHasKey('base_url', $config);
        $this->assertEquals('gemini-1.5-flash', $config['model']);
        $this->assertTrue($config['api_key_configured']);
    }

    public function test_fallback_response_for_services()
    {
        $response = $this->geminiService->generateResponse('layanan', []);

        $this->assertStringContains('Rumah Sakit Sehat Sentosa', $response);
        $this->assertStringContains('layanan', $response);
    }

    public function test_fallback_response_for_appointments()
    {
        $response = $this->geminiService->generateResponse('janji temu', []);

        $this->assertStringContains('janji temu', $response);
        $this->assertStringContains('login', $response);
    }

    public function test_fallback_response_for_contact()
    {
        $response = $this->geminiService->generateResponse('kontak', []);

        $this->assertStringContains('Telepon', $response);
        $this->assertStringContains('Emergency', $response);
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }
}