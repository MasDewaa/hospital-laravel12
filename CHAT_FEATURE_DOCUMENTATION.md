# Live Chat AI Feature Documentation

## Overview
Sistem Hospital Management sekarang dilengkapi dengan fitur Live Chat AI yang dapat membantu pengunjung dan pasien mendapatkan informasi tentang layanan rumah sakit secara real-time.

## Features

### 🤖 AI Assistant Capabilities
- **Informasi Layanan**: Memberikan informasi lengkap tentang layanan rumah sakit
- **Panduan Janji Temu**: Membantu cara membuat janji temu
- **Informasi Kontak**: Menyediakan informasi kontak dan alamat
- **Keadaan Darurat**: Panduan untuk situasi darurat
- **Informasi Dokter**: Daftar dokter dan spesialisasi
- **Informasi Pembayaran**: Panduan pembayaran dan asuransi

### 💬 Chat Features
- **Real-time Messaging**: Chat langsung dengan AI assistant
- **Session Management**: Setiap percakapan memiliki session ID unik
- **Message History**: Menyimpan riwayat percakapan
- **Typing Indicator**: Indikator AI sedang mengetik
- **Quick Suggestions**: Tombol saran cepat untuk pertanyaan umum
- **Responsive Design**: Tampilan optimal di desktop dan mobile

## Implementation

### Database Schema
```sql
CREATE TABLE chats (
    id BIGINT PRIMARY KEY,
    session_id VARCHAR(255) INDEX,
    user_id BIGINT NULL,
    sender ENUM('user', 'ai'),
    message TEXT,
    metadata JSON NULL,
    created_at TIMESTAMP,
    updated_at TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);
```

### API Endpoints

#### 1. Send Message
**POST** `/api/chat/send`

**Request Body:**
```json
{
    "message": "Apa saja layanan yang tersedia?",
    "session_id": "optional-session-id"
}
```

**Response:**
```json
{
    "success": true,
    "session_id": "chat_1234567890_abc123",
    "user_message": {
        "id": 1,
        "session_id": "chat_1234567890_abc123",
        "user_id": null,
        "sender": "user",
        "message": "Apa saja layanan yang tersedia?",
        "metadata": {
            "timestamp": "2025-09-13T08:19:06.000000Z",
            "ip_address": "127.0.0.1"
        },
        "created_at": "2025-09-13T08:19:06.000000Z",
        "updated_at": "2025-09-13T08:19:06.000000Z"
    },
    "ai_response": {
        "id": 2,
        "session_id": "chat_1234567890_abc123",
        "user_id": null,
        "sender": "ai",
        "message": "Rumah Sakit Sehat Sentosa menyediakan berbagai layanan kesehatan:\n• Poli Umum - Konsultasi kesehatan umum\n• Poli Gigi - Perawatan gigi dan mulut\n• Poli Jantung - Pemeriksaan dan perawatan jantung\n• Poli Anak - Perawatan khusus anak-anak\n• Emergency 24/7 - Pelayanan darurat\nApakah ada layanan khusus yang ingin Anda ketahui lebih detail?",
        "metadata": {
            "timestamp": "2025-09-13T08:19:06.000000Z",
            "response_time": 0.123456
        },
        "created_at": "2025-09-13T08:19:06.000000Z",
        "updated_at": "2025-09-13T08:19:06.000000Z"
    }
}
```

#### 2. Get Chat History
**GET** `/api/chat/history?session_id=chat_1234567890_abc123`

**Response:**
```json
{
    "success": true,
    "data": [
        {
            "id": 1,
            "session_id": "chat_1234567890_abc123",
            "user_id": null,
            "sender": "user",
            "message": "Halo",
            "metadata": {...},
            "created_at": "2025-09-13T08:19:06.000000Z",
            "updated_at": "2025-09-13T08:19:06.000000Z"
        }
    ]
}
```

#### 3. Get Chat Statistics
**GET** `/api/chat/stats`

**Response:**
```json
{
    "success": true,
    "data": {
        "total_chats": 150,
        "user_messages": 75,
        "ai_messages": 75,
        "unique_sessions": 25
    }
}
```

### Frontend Integration

#### Chat Widget Component
File: `resources/views/components/chat-widget.blade.php`

**Features:**
- Floating chat button
- Expandable chat window
- Message history
- Typing indicator
- Quick suggestion buttons
- Responsive design

**Usage:**
```blade
@include('components.chat-widget')
```

#### Integration Points
1. **Homepage** (`/`): Chat widget tersedia untuk pengunjung umum
2. **Patient Dashboard** (`/patient-dashboard`): Chat widget untuk pasien yang sudah login

### AI Response Logic

#### Keyword Detection
Sistem AI menggunakan keyword detection untuk memberikan respons yang relevan:

- **Greetings**: `halo`, `hai`, `selamat`, `pagi`, `siang`, `sore`, `malam`
- **Services**: `layanan`, `service`, `poli`, `klinik`, `rawat`, `inap`
- **Appointments**: `janji`, `appointment`, `booking`, `daftar`, `reservasi`
- **Contact**: `kontak`, `telepon`, `alamat`, `email`, `hubung`
- **Emergency**: `darurat`, `emergency`, `urgent`, `gawat`, `sakit`, `parah`
- **Doctors**: `dokter`, `doctor`, `spesialis`, `medis`
- **Payment**: `bayar`, `pembayaran`, `harga`, `biaya`, `asuransi`, `bpjs`

#### Context Awareness
AI dapat menganalisis konteks percakapan untuk memberikan respons yang lebih relevan:

- Jika AI sebelumnya membahas janji temu, akan menawarkan bantuan lebih lanjut
- Jika membahas layanan, akan meminta spesifikasi layanan yang diminati
- Menggunakan riwayat chat untuk konteks yang lebih baik

### Styling & UX

#### Design Features
- **Modern UI**: Gradient background, rounded corners, smooth animations
- **Color Scheme**: Primary gradient (#667eea to #764ba2)
- **Typography**: Clean, readable fonts
- **Icons**: Font Awesome icons for better visual appeal
- **Animations**: Smooth slide-up, fade-in effects
- **Responsive**: Mobile-first design

#### User Experience
- **One-click Access**: Single click to open chat
- **Quick Suggestions**: Pre-defined buttons for common questions
- **Real-time Feedback**: Typing indicator and instant responses
- **Message History**: Persistent conversation history
- **Easy Navigation**: Minimize/maximize functionality

### Security Features

#### CSRF Protection
- All web routes protected with CSRF tokens
- API routes available for external integrations

#### Input Validation
- Message length limit (1000 characters)
- XSS protection through proper escaping
- SQL injection protection via Eloquent ORM

#### Rate Limiting
- Built-in Laravel rate limiting
- Session-based throttling

### Performance Optimization

#### Database Optimization
- Indexed session_id for fast lookups
- JSON metadata for flexible data storage
- Efficient querying with Eloquent scopes

#### Frontend Optimization
- Minimal JavaScript footprint
- CSS animations for smooth UX
- Lazy loading of chat history

### Customization Options

#### AI Responses
Easily customizable response templates in `ChatController.php`:

```php
$responses = [
    'greeting' => [
        'Halo! Saya AI Assistant Rumah Sakit Sehat Sentosa...',
        // Add more greeting variations
    ],
    'layanan' => [
        'Rumah Sakit Sehat Sentosa menyediakan...',
        // Add service information
    ],
    // Add more response categories
];
```

#### Styling
Customize colors, fonts, and layout in the component's `<style>` section.

#### Keywords
Add new keyword patterns in the `generateAIResponse()` method.

## Usage Examples

### For Visitors
1. Visit homepage (`http://localhost:8000`)
2. Click the chat button (bottom right)
3. Ask questions like:
   - "Apa saja layanan yang tersedia?"
   - "Bagaimana cara membuat janji temu?"
   - "Informasi kontak rumah sakit"

### For Patients
1. Login to patient dashboard
2. Access chat widget
3. Get personalized assistance:
   - "Kapan jadwal dokter jantung?"
   - "Bagaimana cara membayar tagihan?"
   - "Informasi tentang appointment saya"

## Future Enhancements

### Planned Features
- **Multi-language Support**: Bahasa Indonesia & English
- **Voice Messages**: Audio input/output
- **File Sharing**: Image/document sharing
- **Integration with Real Staff**: Escalation to human agents
- **Analytics Dashboard**: Chat performance metrics
- **Advanced AI**: Integration with external AI services

### Technical Improvements
- **WebSocket Support**: Real-time bidirectional communication
- **Caching**: Redis caching for better performance
- **Queue Jobs**: Background processing for heavy operations
- **API Rate Limiting**: Advanced throttling mechanisms

## Troubleshooting

### Common Issues

#### Chat Not Loading
- Check if CSRF token is included in meta tags
- Verify JavaScript console for errors
- Ensure server is running on correct port

#### AI Not Responding
- Check server logs for errors
- Verify database connection
- Test API endpoints directly

#### Styling Issues
- Clear browser cache
- Check CSS conflicts
- Verify Font Awesome is loaded

### Debug Mode
Enable debug mode in `.env`:
```
APP_DEBUG=true
LOG_LEVEL=debug
```

## Support

For technical support or feature requests, please contact the development team or create an issue in the project repository.

---

**Version**: 1.0.0  
**Last Updated**: September 13, 2025  
**Compatibility**: Laravel 12.x, PHP 8.2+
