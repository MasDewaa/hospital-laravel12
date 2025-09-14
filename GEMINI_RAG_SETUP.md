# Setup Gemini AI + RAG untuk Chat System

## Overview
Sistem chat sekarang terintegrasi dengan Google Gemini AI dan RAG (Retrieval-Augmented Generation) untuk memberikan respons yang lebih cerdas dan kontekstual.

## Setup Gemini API

### 1. Dapatkan API Key
1. Kunjungi [Google AI Studio](https://makersuite.google.com/app/apikey)
2. Login dengan Google account
3. Buat API key baru
4. Copy API key yang dihasilkan

### 2. Konfigurasi Environment
Tambahkan ke file `.env`:
```env
# Gemini AI Configuration
GEMINI_API_KEY=your_gemini_api_key_here
GEMINI_MODEL=gemini-1.5-flash
GEMINI_BASE_URL=https://generativelanguage.googleapis.com/v1beta
```

### 3. Test Koneksi
Test koneksi Gemini API:
```bash
curl -X GET "http://localhost:8000/chat/test-gemini"
```

## Fitur RAG (Retrieval-Augmented Generation)

### 1. Knowledge Base
Sistem RAG menggunakan data dari database sebagai knowledge base:
- **Informasi Rumah Sakit**: Alamat, kontak, jam operasional
- **Layanan**: Daftar layanan yang tersedia
- **Dokter**: Informasi dokter dan spesialisasi
- **Appointments**: Data janji temu pasien
- **Chat History**: Riwayat percakapan untuk konteks

### 2. Context Retrieval
RAG service akan:
- Menganalisis query pengguna
- Mengambil data relevan dari database
- Memberikan konteks ke Gemini AI
- Menghasilkan respons yang lebih akurat

## API Endpoints Baru

### 1. Test Gemini Connection
**GET** `/chat/test-gemini`
```json
{
    "success": true,
    "message": "Gemini API connected successfully",
    "timestamp": "2025-09-13T08:30:00.000000Z"
}
```

### 2. Get FAQ
**GET** `/chat/faq`
```json
{
    "success": true,
    "data": [
        {
            "question": "Apa saja layanan yang tersedia di rumah sakit?",
            "answer": "Rumah Sakit Sehat Sentosa menyediakan Poli Umum, Poli Gigi, Poli Jantung, Poli Anak, Emergency 24/7, Rawat Inap, Laboratorium, Radiologi, dan Apotek."
        }
    ]
}
```

### 3. Get Similar Questions
**GET** `/chat/similar-questions?query=layanan&limit=5`
```json
{
    "success": true,
    "data": [
        {
            "question": "Apa saja layanan yang tersedia?",
            "time": "Sep 13, 08:30"
        }
    ]
}
```

## Cara Kerja Sistem

### 1. User Input
Pengguna mengetik pesan di chat widget

### 2. RAG Processing
- Ekstrak keywords dari query
- Cari data relevan di database
- Ambil konteks dari chat history
- Siapkan context untuk AI

### 3. Gemini AI Processing
- Kirim query + context ke Gemini API
- Dapatkan respons yang kontekstual
- Fallback ke simple responses jika API gagal

### 4. Response Delivery
- Simpan chat ke database
- Tampilkan respons ke user
- Update chat history

## Konfigurasi Advanced

### 1. Customize AI Responses
Edit `app/Services/GeminiService.php`:
```php
private function buildPrompt(string $userMessage, array $context = []): string
{
    // Customize system prompt here
    $systemPrompt = "Your custom system prompt...";
    // ...
}
```

### 2. Add More Knowledge Sources
Edit `app/Services/RAGService.php`:
```php
private function getCustomInfo(array $keywords): array
{
    // Add custom knowledge retrieval
    return $context;
}
```

### 3. Adjust AI Parameters
Edit `app/Services/GeminiService.php`:
```php
'generationConfig' => [
    'temperature' => 0.7,    // Creativity (0-1)
    'topK' => 40,           // Diversity
    'topP' => 0.95,         // Nucleus sampling
    'maxOutputTokens' => 1024, // Max response length
],
```

## Monitoring & Debugging

### 1. Check Logs
```bash
tail -f storage/logs/laravel.log
```

### 2. Test Individual Components
```bash
# Test RAG service
php artisan tinker
>>> app(\App\Services\RAGService::class)->retrieveContext('layanan rumah sakit');

# Test Gemini service
>>> app(\App\Services\GeminiService::class)->testConnection();
```

### 3. Monitor API Usage
- Check Gemini API usage di Google AI Studio
- Monitor database queries untuk RAG
- Track response times

## Troubleshooting

### 1. Gemini API Issues
- **Error 401**: Check API key
- **Error 403**: Check API permissions
- **Error 429**: Rate limit exceeded
- **Error 500**: API server error

### 2. RAG Issues
- **Empty context**: Check database data
- **Slow retrieval**: Optimize database queries
- **Wrong context**: Improve keyword matching

### 3. Fallback Responses
Jika Gemini API gagal, sistem akan menggunakan fallback responses berdasarkan keyword matching.

## Performance Optimization

### 1. Caching
```php
// Cache frequent queries
$context = Cache::remember("rag_context_{$query}", 300, function() use ($query) {
    return $this->ragService->retrieveContext($query);
});
```

### 2. Database Optimization
- Index pada kolom yang sering dicari
- Optimize query dengan eager loading
- Use database connection pooling

### 3. API Optimization
- Batch multiple requests
- Use async requests where possible
- Implement response caching

## Security Considerations

### 1. API Key Security
- Jangan commit API key ke repository
- Use environment variables
- Rotate keys regularly

### 2. Input Validation
- Sanitize user input
- Limit message length
- Validate against XSS

### 3. Rate Limiting
- Implement rate limiting
- Monitor API usage
- Set up alerts for abuse

## Future Enhancements

### 1. Vector Search
- Implement vector embeddings
- Use similarity search
- Improve context retrieval

### 2. Multi-language Support
- Support multiple languages
- Language detection
- Localized responses

### 3. Advanced Analytics
- Track conversation quality
- Monitor user satisfaction
- A/B test responses

---

**Version**: 1.0.0  
**Last Updated**: September 13, 2025  
**Dependencies**: Google Gemini AI, Laravel 12.x, PHP 8.2+

