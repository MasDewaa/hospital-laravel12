<?php

namespace Tests\Unit;

use App\Services\RAGService;
use App\Models\User;
use App\Models\Patient;
use App\Models\Doctor;
use App\Models\Appointment;
use App\Models\Chat;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RAGServiceTest extends TestCase
{
    use RefreshDatabase;

    protected $ragService;
    protected $user;
    protected $patient;
    protected $doctor;

    protected function setUp(): void
    {
        parent::setUp();
        
        $this->ragService = new RAGService();
        
        // Create test user
        $this->user = User::factory()->create([
            'role' => 'patient',
            'email' => 'patient@test.com'
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

    public function test_retrieve_context_with_hospital_info()
    {
        $context = $this->ragService->retrieveContext('rumah sakit alamat', $this->user->id);

        $this->assertArrayHasKey('hospital_info', $context);
        $this->assertEquals('Rumah Sakit Sehat Sentosa', $context['hospital_info']['name']);
        $this->assertArrayHasKey('address', $context['hospital_info']);
        $this->assertArrayHasKey('phone', $context['hospital_info']);
    }

    public function test_retrieve_context_with_services()
    {
        $context = $this->ragService->retrieveContext('layanan poli', $this->user->id);

        $this->assertArrayHasKey('services', $context);
        $this->assertArrayHasKey('poli_umum', $context['services']);
        $this->assertArrayHasKey('emergency', $context['services']);
    }

    public function test_retrieve_context_with_doctors()
    {
        $context = $this->ragService->retrieveContext('dokter spesialis', $this->user->id);

        $this->assertArrayHasKey('doctors', $context);
        $this->assertCount(1, $context['doctors']);
        $this->assertEquals('Dr. Test', $context['doctors'][0]['name']);
        $this->assertEquals('General Medicine', $context['doctors'][0]['specialization']);
    }

    public function test_retrieve_context_with_appointments()
    {
        // Create test appointment
        Appointment::factory()->create([
            'patient_id' => $this->patient->id,
            'doctor_id' => $this->doctor->id,
            'appointment_date' => now()->addDay(),
            'appointment_time' => '10:00',
            'status' => 'scheduled'
        ]);

        $context = $this->ragService->retrieveContext('janji temu', $this->user->id);

        $this->assertArrayHasKey('user_appointments', $context);
        $this->assertCount(1, $context['user_appointments']);
        $this->assertEquals('Dr. Test', $context['user_appointments'][0]['doctor']);
    }

    public function test_retrieve_context_with_patient_info()
    {
        $context = $this->ragService->retrieveContext('saya profil', $this->user->id);

        $this->assertArrayHasKey('patient_info', $context);
        $this->assertEquals('Test Patient', $context['patient_info']['name']);
        $this->assertEquals($this->patient->patient_id, $context['patient_info']['patient_id']);
    }

    public function test_retrieve_context_with_chat_history()
    {
        // Create test chat history
        Chat::factory()->create([
            'user_id' => $this->user->id,
            'sender' => 'user',
            'message' => 'Previous message',
            'created_at' => now()->subHour()
        ]);

        Chat::factory()->create([
            'user_id' => $this->user->id,
            'sender' => 'ai',
            'message' => 'Previous AI response',
            'created_at' => now()->subMinutes(30)
        ]);

        $context = $this->ragService->retrieveContext('test message', $this->user->id);

        $this->assertArrayHasKey('chat_history', $context);
        $this->assertCount(2, $context['chat_history']);
    }

    public function test_extract_keywords()
    {
        $reflection = new \ReflectionClass($this->ragService);
        $method = $reflection->getMethod('extractKeywords');
        $method->setAccessible(true);

        $keywords = $method->invoke($this->ragService, 'saya ingin tahu tentang layanan rumah sakit');

        $this->assertContains('ingin', $keywords);
        $this->assertContains('tahu', $keywords);
        $this->assertContains('tentang', $keywords);
        $this->assertContains('layanan', $keywords);
        $this->assertContains('rumah', $keywords);
        $this->assertContains('sakit', $keywords);
        $this->assertNotContains('saya', $keywords); // Should be filtered out as stop word
    }

    public function test_get_similar_questions()
    {
        // Create test chat data
        Chat::factory()->create([
            'user_id' => $this->user->id,
            'sender' => 'user',
            'message' => 'Apa saja layanan yang tersedia?',
            'created_at' => now()->subHour()
        ]);

        Chat::factory()->create([
            'user_id' => $this->user->id,
            'sender' => 'user',
            'message' => 'Bagaimana cara membuat janji temu?',
            'created_at' => now()->subMinutes(30)
        ]);

        $similarQuestions = $this->ragService->getSimilarQuestions('layanan', 5);

        $this->assertCount(1, $similarQuestions);
        $this->assertEquals('Apa saja layanan yang tersedia?', $similarQuestions[0]['question']);
    }

    public function test_get_faq()
    {
        $faq = $this->ragService->getFAQ();

        $this->assertIsArray($faq);
        $this->assertCount(5, $faq);
        
        $firstFaq = $faq[0];
        $this->assertArrayHasKey('question', $firstFaq);
        $this->assertArrayHasKey('answer', $firstFaq);
        $this->assertStringContains('layanan', $firstFaq['question']);
    }

    public function test_has_keyword()
    {
        $reflection = new \ReflectionClass($this->ragService);
        $method = $reflection->getMethod('hasKeyword');
        $method->setAccessible(true);

        $keywords = ['layanan', 'rumah', 'sakit'];
        $terms = ['layanan', 'service'];

        $result = $method->invoke($this->ragService, $keywords, $terms);
        $this->assertTrue($result);

        $terms = ['dokter', 'doctor'];
        $result = $method->invoke($this->ragService, $keywords, $terms);
        $this->assertFalse($result);
    }

    public function test_retrieve_context_without_user()
    {
        $context = $this->ragService->retrieveContext('layanan rumah sakit');

        $this->assertArrayHasKey('services', $context);
        $this->assertArrayNotHasKey('user_appointments', $context);
        $this->assertArrayNotHasKey('patient_info', $context);
        $this->assertArrayNotHasKey('chat_history', $context);
    }

    public function test_retrieve_context_empty_query()
    {
        $context = $this->ragService->retrieveContext('', $this->user->id);

        $this->assertIsArray($context);
        $this->assertEmpty($context);
    }
}