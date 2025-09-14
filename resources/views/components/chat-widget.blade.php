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
                    <div class="message-text">Halo! Saya AI Assistant Rumah Sakit Sehat Sentosa. Bagaimana saya bisa membantu Anda hari ini?
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
                <button class="suggestion-btn" id="faqBtn">FAQ</button>
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
    white-space: pre-wrap;
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
document.addEventListener('DOMContentLoaded', () => {
    const chatToggle = document.getElementById('chatToggle');
	const chatWindow = document.getElementById('chatWindow');
	const chatMinimize = document.getElementById('chatMinimize');
	const chatBadge = document.getElementById('chatBadge');
	const chatInput = document.getElementById('chatInput');
	const chatSend = document.getElementById('chatSend');
	const chatMessages = document.getElementById('chatMessages');
	const suggestionButtons = document.querySelectorAll('.suggestion-btn');
	const faqBtn = document.getElementById('faqBtn');
	const chatSendUrl = "{{ route('chat.send') }}";
	const csrfTokenMeta = document.querySelector('meta[name="csrf-token"]');
	let sessionId = localStorage.getItem('chat_session_id') || null;
	let unreadCount = 0;
	let isSending = false;
	let typingEl = null;
	function formatTime(date) {
		return date.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' });
	}
	function toggleChat(open) {
		const shouldOpen = typeof open === 'boolean' ? open : chatWindow.style.display === 'none';
		chatWindow.style.display = shouldOpen ? 'flex' : 'none';
		if (shouldOpen) {
			unreadCount = 0;
			updateBadge();
			chatInput.focus();
			chatMessages.scrollTop = chatMessages.scrollHeight;
		}
	}
	function updateBadge() {
		if (unreadCount > 0) {
			chatBadge.textContent = String(unreadCount);
			chatBadge.style.display = 'flex';
		} else {
			chatBadge.style.display = 'none';
		}
	}
	function showTyping() {
		if (typingEl) return;
		typingEl = document.createElement('div');
		typingEl.className = 'chat-message ai-message';
		const avatar = document.createElement('div');
		avatar.className = 'message-avatar';
		avatar.innerHTML = '<i class="fas fa-robot"></i>';
		const content = document.createElement('div');
		content.className = 'message-content';
		const indicator = document.createElement('div');
		indicator.className = 'typing-indicator';
		indicator.innerHTML = '<span class="typing-dot"></span><span class="typing-dot"></span><span class="typing-dot"></span>';
		content.appendChild(indicator);
		typingEl.appendChild(avatar);
		typingEl.appendChild(content);
		chatMessages.appendChild(typingEl);
		chatMessages.scrollTop = chatMessages.scrollHeight;
	}
	function hideTyping() {
		if (typingEl && typingEl.parentNode) {
			typingEl.parentNode.removeChild(typingEl);
		}
		typingEl = null;
	}
	function addMessage(message, sender) {
		const messageWrapper = document.createElement('div');
		messageWrapper.className = `chat-message ${sender}-message`;
		const avatar = document.createElement('div');
		avatar.className = 'message-avatar';
		avatar.innerHTML = sender === 'ai' ? '<i class="fas fa-robot"></i>' : '<i class="fas fa-user"></i>';
		const content = document.createElement('div');
		content.className = 'message-content';
		const text = document.createElement('div');
		text.className = 'message-text';
		text.textContent = message;
		const time = document.createElement('div');
		time.className = 'message-time';
		time.textContent = formatTime(new Date());
		content.appendChild(text);
		content.appendChild(time);
		if (sender === 'user') {
			messageWrapper.appendChild(avatar);
			messageWrapper.appendChild(content);
		} else {
			messageWrapper.appendChild(avatar);
			messageWrapper.appendChild(content);
		}
		chatMessages.appendChild(messageWrapper);
		chatMessages.scrollTop = chatMessages.scrollHeight;
		if (sender === 'ai' && chatWindow.style.display === 'none') {
			unreadCount += 1;
			updateBadge();
		}
	}
	async function sendMessage(message) {
		if (!message || !message.trim() || isSending) return;
		addMessage(message, 'user');
		chatInput.value = '';
		isSending = true;
		chatInput.disabled = true;
		chatSend.disabled = true;
		showTyping();
		try {
			const headers = {
				'Content-Type': 'application/json',
				'Accept': 'application/json',
				'X-Requested-With': 'XMLHttpRequest'
			};
			if (csrfTokenMeta) {
				headers['X-CSRF-TOKEN'] = csrfTokenMeta.getAttribute('content');
			}
			const response = await fetch(chatSendUrl, {
				method: 'POST',
				headers,
				body: JSON.stringify({ message, session_id: sessionId })
			});
			if (!response.ok) throw new Error(`HTTP ${response.status}`);
			const data = await response.json();
			if (data && data.success && data.ai_response && data.ai_response.message) {
				sessionId = data.session_id || sessionId;
				if (sessionId) localStorage.setItem('chat_session_id', sessionId);
				addMessage(data.ai_response.message, 'ai');
			} else {
				addMessage('Maaf, saya mengalami gangguan teknis.', 'ai');
			}
		} catch (error) {
			console.error('Chat send error:', error);
			addMessage('Maaf, saya mengalami gangguan teknis.', 'ai');
		} finally {
			hideTyping();
			isSending = false;
			chatInput.disabled = false;
			chatSend.disabled = false;
			chatInput.focus();
		}
	}
	// Toggle chat window
	chatToggle.addEventListener('click', () => toggleChat());
	chatMinimize.addEventListener('click', () => toggleChat(false));
	// Send button click
	chatSend.addEventListener('click', () => {
		const message = chatInput.value.trim();
		if (message) sendMessage(message);
	});
	// Enter key press
	chatInput.addEventListener('keydown', (e) => {
		if (e.key === 'Enter' && !e.shiftKey) {
			e.preventDefault();
			const message = chatInput.value.trim();
			if (message) sendMessage(message);
		}
	});
	// Suggestions
	suggestionButtons.forEach(btn => {
		btn.addEventListener('click', () => {
			const quick = btn.getAttribute('data-message');
			toggleChat(true);
			if (quick) sendMessage(quick);
		});
	});
	if (faqBtn && !faqBtn.getAttribute('data-message')) {
		faqBtn.addEventListener('click', () => {
			toggleChat(true);
			sendMessage('FAQ');
		});
	}
});
</script>