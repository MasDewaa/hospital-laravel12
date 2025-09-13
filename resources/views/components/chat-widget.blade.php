<!-- Chat Widget Component -->
<div id="chatWidget" class="chat-widget">
    <!-- Chat Toggle Button -->
    <button id="chatToggle" class="chat-toggle-btn">
        <i class="fas fa-comments"></i>
        <span class="chat-badge" id="chatBadge" style="display: none;">1</span>
    </button>

    <!-- Chat Window -->
    <div id="chatWindow" class="chat-window" style="display: none;">
        <!-- Chat Header -->
        <div class="chat-header">
            <div class="chat-header-info">
                <i class="fas fa-robot"></i>
                <span>AI Assistant</span>
                <small>Rumah Sakit Sehat Sentosa</small>
            </div>
            <button id="chatMinimize" class="chat-minimize-btn">
                <i class="fas fa-minus"></i>
            </button>
        </div>

        <!-- Chat Messages -->
        <div id="chatMessages" class="chat-messages">
            <div class="chat-message ai-message">
                <div class="message-avatar">
                    <i class="fas fa-robot"></i>
                </div>
                <div class="message-content">
                    <div class="message-text">
                        Halo! Saya AI Assistant Rumah Sakit Sehat Sentosa. Bagaimana saya bisa membantu Anda hari ini?
                    </div>
                    <div class="message-time">{{ now()->format('H:i') }}</div>
                </div>
            </div>
        </div>

        <!-- Chat Input -->
        <div class="chat-input-container">
            <div class="chat-input-wrapper">
                <input type="text" id="chatInput" placeholder="Ketik pesan Anda..." maxlength="1000">
                <button id="chatSend" class="chat-send-btn">
                    <i class="fas fa-paper-plane"></i>
                </button>
            </div>
            <div class="chat-suggestions">
                <button class="suggestion-btn" data-message="Apa saja layanan yang tersedia?">Layanan</button>
                <button class="suggestion-btn" data-message="Bagaimana cara membuat janji temu?">Janji Temu</button>
                <button class="suggestion-btn" data-message="Informasi kontak rumah sakit">Kontak</button>
            </div>
        </div>
    </div>
</div>

<style>
.chat-widget {
    position: fixed;
    bottom: 20px;
    right: 20px;
    z-index: 1000;
    font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
}

.chat-toggle-btn {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border: none;
    color: white;
    font-size: 24px;
    cursor: pointer;
    box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
    transition: all 0.3s ease;
    position: relative;
}

.chat-toggle-btn:hover {
    transform: scale(1.1);
    box-shadow: 0 6px 20px rgba(102, 126, 234, 0.6);
}

.chat-badge {
    position: absolute;
    top: -5px;
    right: -5px;
    background: #ff4757;
    color: white;
    border-radius: 50%;
    width: 20px;
    height: 20px;
    font-size: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: bold;
}

.chat-window {
    position: absolute;
    bottom: 80px;
    right: 0;
    width: 350px;
    height: 500px;
    background: white;
    border-radius: 12px;
    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
    display: flex;
    flex-direction: column;
    overflow: hidden;
    animation: slideUp 0.3s ease;
}

@keyframes slideUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.chat-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 15px 20px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.chat-header-info {
    display: flex;
    flex-direction: column;
}

.chat-header-info i {
    font-size: 20px;
    margin-bottom: 2px;
}

.chat-header-info span {
    font-weight: 600;
    font-size: 16px;
}

.chat-header-info small {
    font-size: 12px;
    opacity: 0.9;
}

.chat-minimize-btn {
    background: none;
    border: none;
    color: white;
    font-size: 16px;
    cursor: pointer;
    padding: 5px;
    border-radius: 4px;
    transition: background 0.2s ease;
}

.chat-minimize-btn:hover {
    background: rgba(255, 255, 255, 0.2);
}

.chat-messages {
    flex: 1;
    padding: 20px;
    overflow-y: auto;
    background: #f8f9fa;
}

.chat-message {
    display: flex;
    margin-bottom: 15px;
    animation: fadeIn 0.3s ease;
}

@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.user-message {
    flex-direction: row-reverse;
}

.user-message .message-content {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    margin-right: 10px;
}

.ai-message .message-content {
    background: white;
    color: #333;
    margin-left: 10px;
    border: 1px solid #e9ecef;
}

.message-avatar {
    width: 32px;
    height: 32px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 14px;
    flex-shrink: 0;
}

.user-message .message-avatar {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
}

.ai-message .message-avatar {
    background: #e9ecef;
    color: #667eea;
}

.message-content {
    max-width: 80%;
    padding: 12px 16px;
    border-radius: 18px;
    position: relative;
}

.message-text {
    line-height: 1.4;
    word-wrap: break-word;
}

.message-time {
    font-size: 11px;
    opacity: 0.7;
    margin-top: 4px;
}

.chat-input-container {
    padding: 15px 20px;
    background: white;
    border-top: 1px solid #e9ecef;
}

.chat-input-wrapper {
    display: flex;
    gap: 10px;
    margin-bottom: 10px;
}

.chat-input-wrapper input {
    flex: 1;
    padding: 12px 16px;
    border: 1px solid #e9ecef;
    border-radius: 25px;
    outline: none;
    font-size: 14px;
    transition: border-color 0.2s ease;
}

.chat-input-wrapper input:focus {
    border-color: #667eea;
}

.chat-send-btn {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border: none;
    color: white;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: transform 0.2s ease;
}

.chat-send-btn:hover {
    transform: scale(1.1);
}

.chat-suggestions {
    display: flex;
    gap: 8px;
    flex-wrap: wrap;
}

.suggestion-btn {
    padding: 6px 12px;
    background: #f8f9fa;
    border: 1px solid #e9ecef;
    border-radius: 15px;
    font-size: 12px;
    cursor: pointer;
    transition: all 0.2s ease;
}

.suggestion-btn:hover {
    background: #667eea;
    color: white;
    border-color: #667eea;
}

.typing-indicator {
    display: flex;
    align-items: center;
    gap: 4px;
    padding: 12px 16px;
    background: white;
    border: 1px solid #e9ecef;
    border-radius: 18px;
    margin-left: 10px;
    max-width: 80px;
}

.typing-dot {
    width: 6px;
    height: 6px;
    background: #667eea;
    border-radius: 50%;
    animation: typing 1.4s infinite ease-in-out;
}

.typing-dot:nth-child(2) {
    animation-delay: 0.2s;
}

.typing-dot:nth-child(3) {
    animation-delay: 0.4s;
}

@keyframes typing {
    0%, 60%, 100% {
        transform: translateY(0);
    }
    30% {
        transform: translateY(-10px);
    }
}

/* Mobile Responsive */
@media (max-width: 480px) {
    .chat-window {
        width: calc(100vw - 40px);
        right: -10px;
        height: 400px;
    }
    
    .chat-widget {
        right: 10px;
        bottom: 10px;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const chatToggle = document.getElementById('chatToggle');
    const chatWindow = document.getElementById('chatWindow');
    const chatMinimize = document.getElementById('chatMinimize');
    const chatInput = document.getElementById('chatInput');
    const chatSend = document.getElementById('chatSend');
    const chatMessages = document.getElementById('chatMessages');
    const chatBadge = document.getElementById('chatBadge');
    const suggestionBtns = document.querySelectorAll('.suggestion-btn');

    let sessionId = generateSessionId();
    let isTyping = false;

    // Generate unique session ID
    function generateSessionId() {
        return 'chat_' + Date.now() + '_' + Math.random().toString(36).substr(2, 9);
    }

    // Toggle chat window
    chatToggle.addEventListener('click', function() {
        if (chatWindow.style.display === 'none') {
            chatWindow.style.display = 'flex';
            chatInput.focus();
            chatBadge.style.display = 'none';
        } else {
            chatWindow.style.display = 'none';
        }
    });

    // Minimize chat window
    chatMinimize.addEventListener('click', function() {
        chatWindow.style.display = 'none';
    });

    // Send message
    function sendMessage(message) {
        if (!message.trim()) return;

        // Add user message to chat
        addMessage(message, 'user');
        
        // Clear input
        chatInput.value = '';
        
        // Show typing indicator
        showTypingIndicator();

        // Send to server
        fetch('/chat/send', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                message: message,
                session_id: sessionId
            })
        })
        .then(response => response.json())
        .then(data => {
            hideTypingIndicator();
            if (data.success) {
                addMessage(data.ai_response.message, 'ai');
            } else {
                addMessage('Maaf, terjadi kesalahan. Silakan coba lagi.', 'ai');
            }
        })
        .catch(error => {
            hideTypingIndicator();
            addMessage('Maaf, terjadi kesalahan. Silakan coba lagi.', 'ai');
            console.error('Error:', error);
        });
    }

    // Add message to chat
    function addMessage(message, sender) {
        const messageDiv = document.createElement('div');
        messageDiv.className = `chat-message ${sender}-message`;
        
        const avatar = document.createElement('div');
        avatar.className = 'message-avatar';
        avatar.innerHTML = sender === 'user' ? '<i class="fas fa-user"></i>' : '<i class="fas fa-robot"></i>';
        
        const content = document.createElement('div');
        content.className = 'message-content';
        
        const text = document.createElement('div');
        text.className = 'message-text';
        text.textContent = message;
        
        const time = document.createElement('div');
        time.className = 'message-time';
        time.textContent = new Date().toLocaleTimeString('id-ID', { 
            hour: '2-digit', 
            minute: '2-digit' 
        });
        
        content.appendChild(text);
        content.appendChild(time);
        messageDiv.appendChild(avatar);
        messageDiv.appendChild(content);
        
        chatMessages.appendChild(messageDiv);
        chatMessages.scrollTop = chatMessages.scrollHeight;
    }

    // Show typing indicator
    function showTypingIndicator() {
        isTyping = true;
        const typingDiv = document.createElement('div');
        typingDiv.className = 'chat-message ai-message';
        typingDiv.id = 'typingIndicator';
        
        const avatar = document.createElement('div');
        avatar.className = 'message-avatar';
        avatar.innerHTML = '<i class="fas fa-robot"></i>';
        
        const indicator = document.createElement('div');
        indicator.className = 'typing-indicator';
        indicator.innerHTML = `
            <div class="typing-dot"></div>
            <div class="typing-dot"></div>
            <div class="typing-dot"></div>
        `;
        
        typingDiv.appendChild(avatar);
        typingDiv.appendChild(indicator);
        chatMessages.appendChild(typingDiv);
        chatMessages.scrollTop = chatMessages.scrollHeight;
    }

    // Hide typing indicator
    function hideTypingIndicator() {
        isTyping = false;
        const indicator = document.getElementById('typingIndicator');
        if (indicator) {
            indicator.remove();
        }
    }

    // Send button click
    chatSend.addEventListener('click', function() {
        const message = chatInput.value.trim();
        if (message) {
            sendMessage(message);
        }
    });

    // Enter key press
    chatInput.addEventListener('keypress', function(e) {
        if (e.key === 'Enter' && !e.shiftKey) {
            e.preventDefault();
            const message = chatInput.value.trim();
            if (message) {
                sendMessage(message);
            }
        }
    });

    // Suggestion buttons
    suggestionBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            const message = this.getAttribute('data-message');
            sendMessage(message);
        });
    });

    // Load chat history
    function loadChatHistory() {
        fetch(`/chat/history?session_id=${sessionId}`)
        .then(response => response.json())
        .then(data => {
            if (data.success && data.data.length > 0) {
                chatMessages.innerHTML = '';
                data.data.forEach(chat => {
                    addMessage(chat.message, chat.sender);
                });
            }
        })
        .catch(error => {
            console.error('Error loading chat history:', error);
        });
    }

    // Load history when chat opens
    chatToggle.addEventListener('click', function() {
        if (chatWindow.style.display === 'flex') {
            loadChatHistory();
        }
    });
});
</script>
