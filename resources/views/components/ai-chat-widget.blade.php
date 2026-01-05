<!-- AI Chat Widget -->
<style>
    /* Fallback styles in case utility classes are missing */
    .ai-chat-fixed { position: fixed; bottom: 24px; right: 24px; z-index: 9999; }
    .ai-chat-btn { width: 64px; height: 64px; border-radius: 9999px; border: none; color: #fff;
        background: linear-gradient(135deg, #ec4899, #ef4444, #f97316);
        box-shadow: 0 12px 30px rgba(239, 68, 68, 0.35); }
    
    /* Custom Scrollbar */
    .chat-messages {
        display: flex;
        flex-direction: column;
        overflow-y: scroll !important;
        scrollbar-gutter: stable;
        scrollbar-width: auto;
        scrollbar-color: #ec4899 #f1f1f1;
    }
    .chat-messages::-webkit-scrollbar {
        width: 12px;
    }
    .chat-messages::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
        margin: 5px 0;
    }
    .chat-messages::-webkit-scrollbar-thumb {
        background: linear-gradient(180deg, #ec4899, #ef4444);
        border-radius: 10px;
        min-height: 40px;
    }
    .chat-messages::-webkit-scrollbar-thumb:hover {
        background: linear-gradient(180deg, #db2777, #dc2626);
    }
    /* Selection color fix */
    .chat-messages ::selection {
        background: #3b82f6;
        color: white;
    }
    .chat-messages ::-moz-selection {
        background: #3b82f6;
        color: white;
    }
</style>

<div x-data="aiChatWidget()" x-init="init()" class="ai-chat-fixed fixed bottom-8 right-8 z-[9999]">
    <!-- Chat Button -->
    <button 
        @click="toggleChat()"
        x-show="!isOpen"
        class="ai-chat-btn bg-gradient-to-br from-pink-500 via-red-500 to-orange-500 text-white w-16 h-16 rounded-full shadow-2xl hover:shadow-pink-500/50 hover:scale-110 transition-all duration-300 flex items-center justify-center group ring-4 ring-white"
        title="Trợ lý AI">
        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path>
        </svg>
        <span class="absolute -top-1 -right-1 w-5 h-5 bg-yellow-400 rounded-full animate-ping"></span>
        <span class="absolute -top-1 -right-1 w-5 h-5 bg-yellow-400 rounded-full flex items-center justify-center text-xs font-bold">!</span>
    </button>

    <!-- Chat Panel -->
    <div 
        x-show="isOpen"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 transform scale-75"
        x-transition:enter-end="opacity-100 transform scale-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100 transform scale-100"
        x-transition:leave-end="opacity-0 transform scale-75"
        class="bg-white rounded-2xl shadow-2xl flex flex-col border border-gray-200 overflow-hidden"
        style="display: none; width: 30rem; height: 45rem;">
        
        <!-- Header -->
        <div class="bg-gradient-to-r from-pink-500 via-red-500 to-orange-500 text-white flex items-center justify-between" style="padding: 16px; height: 70px; flex-shrink: 0;">
            <div class="flex items-center" style="gap: 12px;">
                <div style="width: 40px; height: 40px; background: rgba(255,255,255,0.2); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                    🤖
                </div>
                <div>
                    <h3 style="font-weight: bold; font-size: 16px; color: black; margin: 0;">Trợ lý AI</h3>
                    <p style="font-size: 12px; color: black; margin: 0;">Hỗ trợ 24/7</p>
                </div>
            </div>
            <div class="flex" style="gap: 8px;">
                <button @click="clearMessages()" x-show="messages.length > 0" title="Xóa chat" style="background: rgba(255,255,255,0.2); padding: 8px; border-radius: 8px; border: none; cursor: pointer; display: flex; align-items: center; justify-content: center;">
                    <svg style="width: 20px; height: 20px; color: black;" fill="none" stroke="black" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                    </svg>
                </button>
                <button @click="toggleChat()" style="background: rgba(255,255,255,0.2); padding: 8px; border-radius: 8px; border: none; cursor: pointer; display: flex; align-items: center; justify-content: center;">
                    <svg style="width: 20px; height: 20px; color: black;" fill="none" stroke="black" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
        </div>

        <!-- Messages Area -->
        <div class="p-4 bg-gray-50 chat-messages" x-ref="messagesContainer" style="flex: 1; overflow-y: scroll;">
            <!-- Welcome Message -->
            <div class="flex gap-2 mb-4" x-show="messages.length === 0">
                <div class="w-8 h-8 bg-orange-100 rounded-full flex items-center justify-center flex-shrink-0">
                    🤖
                </div>
                <div class="bg-white rounded-2xl rounded-tl-none p-3 shadow-sm max-w-xs">
                    <p class="text-sm text-gray-800">Xin chào! Tôi là trợ lý AI của FARM FRESH. Tôi có thể giúp bạn tìm sản phẩm, tư vấn nông sản tươi ngon. Bạn cần gì?</p>
                </div>
            </div>

            <!-- Messages -->
            <template x-for="(msg, index) in messages" :key="index">
                <div class="flex gap-2 mb-4" :class="msg.isUser ? 'flex-row-reverse' : ''">
                    <div class="w-8 h-8 rounded-full flex items-center justify-center flex-shrink-0"
                         :class="msg.isUser ? 'bg-blue-100' : 'bg-orange-100'">
                        <span x-text="msg.isUser ? '👤' : '🤖'"></span>
                    </div>
                    <div class="rounded-2xl p-3 shadow-sm max-w-xs"
                         :class="msg.isUser ? 'bg-blue-500 text-white rounded-tr-none' : 'bg-white text-gray-800 rounded-tl-none'">
                        <p class="text-sm whitespace-pre-wrap" x-text="msg.text"></p>
                        <span class="text-xs opacity-70 mt-1 block" x-text="msg.time"></span>
                    </div>
                </div>
            </template>

            <!-- Typing Indicator -->
            <div class="flex gap-2" x-show="isTyping">
                <div class="w-8 h-8 bg-orange-100 rounded-full flex items-center justify-center flex-shrink-0">
                    🤖
                </div>
                <div class="bg-white rounded-2xl rounded-tl-none p-3 shadow-sm">
                    <div class="flex gap-1">
                        <span class="w-2 h-2 bg-gray-400 rounded-full animate-bounce" style="animation-delay: 0s"></span>
                        <span class="w-2 h-2 bg-gray-400 rounded-full animate-bounce" style="animation-delay: 0.2s"></span>
                        <span class="w-2 h-2 bg-gray-400 rounded-full animate-bounce" style="animation-delay: 0.4s"></span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Suggestions -->
        <div class="px-4 pb-2" x-show="suggestions.length > 0">
            <div class="flex flex-wrap gap-2">
                <template x-for="(suggestion, index) in suggestions" :key="index">
                    <button @click="sendMessage(suggestion)" 
                            class="text-xs bg-orange-50 hover:bg-orange-100 text-orange-700 px-3 py-1.5 rounded-full border border-orange-200 transition">
                        <span x-text="suggestion"></span>
                    </button>
                </template>
            </div>
        </div>

        <!-- Input Area -->
        <div class="p-4 bg-white border-t">
            <form @submit.prevent="sendUserMessage()" class="flex gap-2">
                <input 
                    type="text" 
                    x-model="userInput"
                    placeholder="Nhập tin nhắn..."
                    class="flex-1 px-4 py-3 border-2 border-blue-300 rounded-full focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                    :disabled="isTyping">
                <button 
                    type="submit"
                    :disabled="!userInput.trim() || isTyping"
                    class="hover:bg-gray-800 text-white rounded-full flex items-center justify-center transition disabled:cursor-not-allowed shadow-lg"
                    style="width: 48px; height: 48px; flex-shrink: 0; background: #000; opacity: 1 !important;">
                    <svg class="w-6 h-6" fill="none" stroke="white" viewBox="0 0 24 24" style="opacity: 1; transform: rotate(90deg);">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                    </svg>
                </button>
            </form>
        </div>
    </div>
</div>

<script>
function aiChatWidget() {
    return {
        isOpen: false,
        messages: [],
        userInput: '',
        isTyping: false,
        suggestions: [
            'Có sản phẩm nào đang giảm giá?',
            'Tôi muốn mua rau củ tươi',
            'Sản phẩm nào bán chạy?'
        ],

        init() {
            // Kiểm tra xem có cần xóa chat từ session
            const needsClear = document.body.getAttribute('data-clear-ai-chat');
            if (needsClear === 'true') {
                localStorage.removeItem('aiChatHistory');
                document.body.removeAttribute('data-clear-ai-chat');
            }
            
            // Load chat history từ localStorage nếu có
            const savedMessages = localStorage.getItem('aiChatHistory');
            if (savedMessages) {
                try {
                    this.messages = JSON.parse(savedMessages);
                } catch (e) {
                    this.messages = [];
                }
            }
        },

        toggleChat() {
            this.isOpen = !this.isOpen;
            if (this.isOpen) {
                this.$nextTick(() => {
                    this.scrollToBottom();
                });
            }
        },

        async sendUserMessage() {
            if (!this.userInput.trim()) return;

            const message = this.userInput.trim();
            this.addMessage(message, true);
            this.userInput = '';
            this.isTyping = true;

            try {
                const response = await fetch('/api/ai-chat', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({
                        message: message,
                        search_keyword: this.extractKeywords(message)
                    })
                });

                const data = await response.json();

                if (data.success && data.reply) {
                    this.addMessage(data.reply, false);
                    
                    // Cập nhật suggestions nếu có
                    if (data.suggestions && data.suggestions.length > 0) {
                        this.suggestions = data.suggestions;
                    }
                } else {
                    this.addMessage('Xin lỗi, tôi không thể trả lời lúc này. Vui lòng thử lại sau.', false);
                }
            } catch (error) {
                console.error('Chat error:', error);
                this.addMessage('Đã xảy ra lỗi kết nối. Vui lòng thử lại.', false);
            } finally {
                this.isTyping = false;
            }
        },

        sendMessage(text) {
            this.userInput = text;
            this.sendUserMessage();
        },

        addMessage(text, isUser) {
            const now = new Date();
            const time = now.getHours().toString().padStart(2, '0') + ':' + 
                        now.getMinutes().toString().padStart(2, '0');
            
            this.messages.push({
                text: text,
                isUser: isUser,
                time: time
            });

            // Lưu vào localStorage (giới hạn 50 tin)
            if (this.messages.length > 50) {
                this.messages = this.messages.slice(-50);
            }
            localStorage.setItem('aiChatHistory', JSON.stringify(this.messages));

            this.$nextTick(() => {
                this.scrollToBottom();
            });
        },

        scrollToBottom() {
            const container = this.$refs.messagesContainer;
            if (container) {
                container.scrollTop = container.scrollHeight;
            }
        },

        clearMessages() {
            if (confirm('Bạn có chắc muốn xóa toàn bộ nội dung chat?')) {
                this.messages = [];
                localStorage.removeItem('aiChatHistory');
            }
        },

        extractKeywords(message) {
            const keywords = ['rau', 'củ', 'quả', 'trái cây', 'nông sản', 'tươi', 'sạch', 'organic'];
            for (const keyword of keywords) {
                if (message.toLowerCase().includes(keyword)) {
                    return keyword;
                }
            }
            return '';
        }
    };
}
</script>
