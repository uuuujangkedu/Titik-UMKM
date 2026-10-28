<!-- ========================================================
     CHATBOT FLOATING WIDGET - MAS FAUZA (Asisten Virtual TIKUM)
     Desain disesuaikan presisi dengan referensi karakter Mas Fauza
     ======================================================== -->
<style>
    /* Scoped Clean Scrollbar */
    #chatbot-messages-container::-webkit-scrollbar {
        width: 6px;
    }
    #chatbot-messages-container::-webkit-scrollbar-track {
        background: #F0F4F1;
        border-radius: 9999px;
    }
    #chatbot-messages-container::-webkit-scrollbar-thumb {
        background: #A3C9B2;
        border-radius: 9999px;
    }
    #chatbot-messages-container::-webkit-scrollbar-thumb:hover {
        background: #1E5B38;
    }

    /* Panel Shadow */
    .chatbot-panel-shadow {
        box-shadow: 0 20px 45px -10px rgba(18, 59, 36, 0.3),
                    0 0 0 1px rgba(30, 91, 56, 0.15);
    }
</style>

<div id="chatbot-widget-root" class="select-none font-sans" aria-label="Widget Mas Fauza Asisten Virtual TIKUM">

    <!-- 1. FLOATING ACTION BUTTON (Pojok Kanan Bawah - Karakter Mas Fauza) -->
    <button type="button" 
            id="chatbot-trigger-btn"
            class="fixed bottom-6 right-6 z-[9990] w-14 h-14 sm:w-16 sm:h-16 rounded-full bg-[#1E5B38] hover:bg-[#164E2F] text-white flex items-center justify-center transition-all duration-300 hover:scale-105 active:scale-95 cursor-pointer shadow-xl border-2 border-white focus:outline-none focus:ring-4 focus:ring-[#1E5B38]/30"
            aria-label="Buka Chatbot Mas Fauza"
            aria-expanded="false"
            title="Tanya Mas Fauza">
        
        <!-- Foto Profil Mas Fauza saat widget tertutup -->
        <div id="chatbot-icon-open" class="w-full h-full rounded-full overflow-hidden p-0.5 transition-transform duration-300">
            <img src="{{ asset('images/character-chatbot-profile.png') }}" 
                 alt="Mas Fauza" 
                 class="w-full h-full object-cover object-top rounded-full">
        </div>

        <!-- Icon Silang saat widget terbuka -->
        <svg id="chatbot-icon-close" class="w-7 h-7 sm:w-8 sm:h-8 hidden text-white transition-transform duration-300" fill="none" stroke="currentColor" stroke-width="2.4" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
        </svg>


    </button>

    <!-- 2. PANEL WINDOW CHATBOT -->
    <div id="chatbot-panel"
         class="chatbot-panel-shadow hidden fixed bottom-24 right-4 sm:right-6 z-[9990] w-[calc(100vw-2rem)] sm:w-[410px] h-[560px] max-h-[84vh] bg-white rounded-3xl flex flex-col overflow-hidden transition-all duration-300 opacity-0 translate-y-4"
         role="dialog"
         aria-modal="true"
         aria-label="Jendela Chatbot Mas Fauza">

        <!-- HEADER PANEL (Sesuai Referensi: Dark Green, Foto Lingkaran, Nama & Asisten Virtual TIKUM) -->
        <div class="bg-[#1E5B38] text-white px-4 py-3 sm:px-5 sm:py-3.5 flex items-center justify-between shrink-0 select-none border-b border-black/10">
            
            <div class="flex items-center space-x-3">
                <!-- Avatar Profil Mas Fauza -->
                <div class="w-12 h-12 rounded-full overflow-hidden bg-white border-2 border-white/90 shrink-0 shadow-sm flex items-center justify-center">
                    <img src="{{ asset('images/character-chatbot-profile.png') }}" 
                         alt="Mas Fauza" 
                         class="w-full h-full object-cover object-top">
                </div>
                <div>
                    <h3 class="font-bold text-[16px] text-white leading-tight tracking-wide">Mas Fauza</h3>
                    <p class="text-[12.5px] text-white/90 font-medium">Asisten Virtual TIKUM</p>
                </div>
            </div>

            <!-- Tombol Aksi: Refresh & Close (Sesuai Icon di Referensi) -->
            <div class="flex items-center gap-1">
                <button type="button" 
                        id="chatbot-reset-btn"
                        class="p-2 text-white/90 hover:text-white hover:bg-white/15 rounded-xl transition-all cursor-pointer"
                        title="Bersihkan Percakapan"
                        aria-label="Bersihkan Percakapan">
                    <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99" />
                    </svg>
                </button>
                <button type="button" 
                        id="chatbot-close-btn"
                        class="p-2 text-white/90 hover:text-white hover:bg-white/15 rounded-xl transition-all cursor-pointer"
                        title="Tutup Chat"
                        aria-label="Tutup Chat">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.4" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>

        <!-- AREA MESSAGES CONTAINER (Latar Belakang Halus) -->
        <div id="chatbot-messages-container" 
             class="flex-1 p-4 sm:p-5 space-y-4 overflow-y-auto bg-[#F7F9F7] text-[13.5px] leading-relaxed scroll-smooth">
            
            <!-- Welcome Initial Message from Bot (Sesuai Persis Tampilan Referensi!) -->
            <div class="flex flex-col items-start space-y-1">
                
                <!-- Card Sambutan dengan Karakter Mas Fauza Melambaikan Tangan di Sebelah Kanan -->
                <div class="bg-white border border-[#D4E7DC] rounded-2xl p-4 sm:p-4.5 shadow-xs relative overflow-hidden flex items-end justify-between gap-2.5 w-full">
                    <div class="space-y-3.5 z-10 py-1 text-[13.5px] text-[#15241C] leading-[1.6] font-medium max-w-[58%] text-left">
                        <p>Halo, aku Mas Fauza, asisten virtual dari Titik UMKM!!</p>
                        <p>Kalau kamu ada pertanyaan seputar Titik UMKM, Bisa tanya aku yaa</p>
                    </div>

                    <!-- Visual Ilustrasi Karakter Mas Fauza Melambai -->
                    <div class="shrink-0 -mb-4 -mr-1 z-10 w-[130px] sm:w-[145px] pointer-events-none select-none">
                        <img src="{{ asset('images/character-chatbot-chat.png') }}" 
                             alt="Mas Fauza Melambai" 
                             class="w-full h-auto object-contain object-bottom drop-shadow-sm">
                    </div>
                </div>
            </div>

            <!-- Quick Suggestion Chips (Sesuai Gaya Kotak Border Hijau di Referensi) -->
            <div id="chatbot-chips-container" class="space-y-2 pt-1">
                <button type="button" 
                        class="chatbot-quick-chip w-full text-center bg-white border border-[#1E5B38] text-[#1E5B38] hover:bg-[#EAF5E9] font-bold text-[13px] px-4 py-2.5 rounded-xl transition-all cursor-pointer shadow-xs hover:-translate-y-0.5">
                    APA TUJUAN DARI PLATFORM INI?
                </button>
                <button type="button" 
                        class="chatbot-quick-chip w-full text-center bg-white border border-[#1E5B38] text-[#1E5B38] hover:bg-[#EAF5E9] font-bold text-[13px] px-4 py-2.5 rounded-xl transition-all cursor-pointer shadow-xs hover:-translate-y-0.5">
                    BAGAIMANA CARA BERGABUNG?
                </button>
                <button type="button" 
                        class="chatbot-quick-chip w-full text-center bg-white border border-[#1E5B38] text-[#1E5B38] hover:bg-[#EAF5E9] font-bold text-[13px] px-4 py-2.5 rounded-xl transition-all cursor-pointer shadow-xs hover:-translate-y-0.5">
                    INFORMASI KERJA SAMA INVESTOR
                </button>
            </div>

            <!-- Typing Indicator (Hidden by default) -->
            <div id="chatbot-typing-indicator" class="hidden flex-col items-start space-y-1">
                <div class="bg-white border border-[#D4E7DC] p-3 rounded-2xl rounded-tl-xs shadow-xs flex items-center gap-1.5">
                    <span class="w-2.5 h-2.5 rounded-full bg-[#1E5B38] animate-bounce" style="animation-delay: 0ms;"></span>
                    <span class="w-2.5 h-2.5 rounded-full bg-[#2D6B22] animate-bounce" style="animation-delay: 150ms;"></span>
                    <span class="w-2.5 h-2.5 rounded-full bg-[#6FC142] animate-bounce" style="animation-delay: 300ms;"></span>
                </div>
            </div>

        </div>

        <!-- FOOTER INPUT AREA (Sesuai Referensi: Rounded Input + Dark Green Send Button) -->
        <div class="p-3.5 bg-white border-t border-[#E5E7EB] shrink-0 select-none">
            <form id="chatbot-form" class="flex items-center gap-2">
                <input type="text" 
                       id="chatbot-input" 
                       name="message" 
                       maxlength="500"
                       autocomplete="off"
                       placeholder="Ketik pertanyaan kamu di sini..." 
                       class="flex-1 bg-[#FAFBF9] border border-[#D1D5DB] focus:border-[#1E5B38] rounded-xl px-3.5 py-2.5 text-[13.5px] text-[#15241C] placeholder-[#9CA3AF] focus:outline-none focus:ring-2 focus:ring-[#1E5B38]/20 transition">
                
                <button type="submit" 
                        id="chatbot-send-btn"
                        class="p-2.5 rounded-xl bg-[#1E5B38] hover:bg-[#164E2F] disabled:opacity-50 text-white transition cursor-pointer flex items-center justify-center shrink-0 shadow-sm hover:scale-105 active:scale-95"
                        title="Kirim Pesan"
                        aria-label="Kirim Pesan">
                    <!-- Icon Kirim / Paper Plane Menghadap Lurus ke Kanan -->
                    <svg class="w-4 h-4 text-white" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M2.01 21L23 12 2.01 3 2 10l15 2-15 2z"/>
                    </svg>
                </button>
            </form>
        </div>

    </div>
</div>

<!-- ========================================================
     CHATBOT FRONTEND JAVASCRIPT LOGIC
     ======================================================== -->
<script>
(function() {
    const triggerBtn = document.getElementById('chatbot-trigger-btn');
    const closeBtn = document.getElementById('chatbot-close-btn');
    const resetBtn = document.getElementById('chatbot-reset-btn');
    const panel = document.getElementById('chatbot-panel');
    const iconOpen = document.getElementById('chatbot-icon-open');
    const iconClose = document.getElementById('chatbot-icon-close');
    const form = document.getElementById('chatbot-form');
    const input = document.getElementById('chatbot-input');
    const sendBtn = document.getElementById('chatbot-send-btn');
    const messagesContainer = document.getElementById('chatbot-messages-container');
    const typingIndicator = document.getElementById('chatbot-typing-indicator');
    const chipsContainer = document.getElementById('chatbot-chips-container');

    if (!triggerBtn || !panel) {
        return;
    }

    let isOpen = false;
    let isSending = false;

    // Toggle Open / Close
    function toggleChatbot(forceState) {
        isOpen = (typeof forceState === 'boolean') ? forceState : !isOpen;
        if (isOpen) {
            panel.classList.remove('hidden');
            setTimeout(() => {
                panel.classList.remove('opacity-0', 'translate-y-4');
                panel.classList.add('opacity-100', 'translate-y-0');
            }, 10);
            if (iconOpen) iconOpen.classList.add('hidden');
            if (iconClose) iconClose.classList.remove('hidden');
            triggerBtn.setAttribute('aria-expanded', 'true');
            scrollToBottom();
            setTimeout(() => { if (input) input.focus(); }, 150);
        } else {
            panel.classList.remove('opacity-100', 'translate-y-0');
            panel.classList.add('opacity-0', 'translate-y-4');
            if (iconOpen) iconOpen.classList.remove('hidden');
            if (iconClose) iconClose.classList.add('hidden');
            triggerBtn.setAttribute('aria-expanded', 'false');
            setTimeout(() => {
                panel.classList.add('hidden');
            }, 300);
        }
    }

    triggerBtn.addEventListener('click', (e) => {
        e.preventDefault();
        toggleChatbot();
    });

    if (closeBtn) {
        closeBtn.addEventListener('click', (e) => {
            e.preventDefault();
            toggleChatbot(false);
        });
    }

    // Keyboard ESC to close
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && isOpen) {
            toggleChatbot(false);
        }
    });

    // Helper: Scroll to bottom
    function scrollToBottom() {
        if (messagesContainer) {
            messagesContainer.scrollTop = messagesContainer.scrollHeight;
        }
    }

    // Append Message to UI
    function appendMessage(sender, text) {
        const wrapper = document.createElement('div');
        wrapper.className = sender === 'user' 
            ? 'flex flex-col items-end space-y-1' 
            : 'flex flex-col items-start space-y-1';

        const bubble = document.createElement('div');
        if (sender === 'user') {
            bubble.className = 'bg-[#1E5B38] text-white font-medium text-[13.5px] p-3.5 rounded-2xl rounded-tr-xs shadow-xs max-w-[85%] whitespace-pre-line break-words text-left';
        } else {
            bubble.className = 'bg-white text-[#15241C] border border-[#D4E7DC] font-normal text-[13.5px] p-3.5 rounded-2xl rounded-tl-xs shadow-xs max-w-[90%] whitespace-pre-line break-words text-left';
        }

        // Strict plain text assignment (prevents XSS and ensures pure text display)
        bubble.textContent = text;

        wrapper.appendChild(bubble);

        // Insert before typing indicator
        messagesContainer.insertBefore(wrapper, typingIndicator);
        scrollToBottom();
    }

    // Send Message Logic
    async function sendMessage(text) {
        const query = (text || input.value || '').trim();
        if (!query || isSending) return;

        // Reset input field
        input.value = '';
        input.disabled = true;
        sendBtn.disabled = true;
        isSending = true;

        // Hide chips after first message
        if (chipsContainer) {
            chipsContainer.classList.add('hidden');
        }

        // Show User message
        appendMessage('user', query);

        // Show typing indicator
        typingIndicator.classList.remove('hidden');
        scrollToBottom();

        // Get CSRF Token
        const csrfTokenMeta = document.querySelector('meta[name=\"csrf-token\"]');
        const csrfToken = csrfTokenMeta ? csrfTokenMeta.getAttribute('content') : '{{ csrf_token() }}';

        try {
            const response = await fetch("{{ route('chatbot.message') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                },
                body: JSON.stringify({ message: query }),
            });

            const data = await response.json();

            // Hide typing indicator
            typingIndicator.classList.add('hidden');

            if (response.ok && data.status === 'success' && data.reply) {
                appendMessage('assistant', data.reply);
            } else {
                const errorMsg = data.message || 'Mohon maaf, terjadi kendala saat memproses jawaban. Silakan coba kembali.';
                appendMessage('assistant', errorMsg);
            }
        } catch (err) {
            typingIndicator.classList.add('hidden');
            appendMessage('assistant', 'Mohon maaf, koneksi ke server terputus. Pastikan jaringan internet stabil dan coba kirim kembali pesanmu.');
        } finally {
            isSending = false;
            input.disabled = false;
            sendBtn.disabled = false;
            input.focus();
            scrollToBottom();
        }
    }

    // Handle Form Submit
    form.addEventListener('submit', (e) => {
        e.preventDefault();
        sendMessage();
    });

    // Handle Quick Chips
    document.querySelectorAll('.chatbot-quick-chip').forEach(chip => {
        chip.addEventListener('click', function() {
            const promptText = this.textContent.trim();
            sendMessage(promptText);
        });
    });

    // Reset Chat Button
    if (resetBtn) {
        resetBtn.addEventListener('click', async () => {
            const executeReset = async () => {
                const csrfTokenMeta = document.querySelector('meta[name="csrf-token"]');
                const csrfToken = csrfTokenMeta ? csrfTokenMeta.getAttribute('content') : '{{ csrf_token() }}';

                try {
                    await fetch("{{ route('chatbot.reset') }}", {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': csrfToken,
                        },
                    });
                } catch (e) {
                    // silent fail
                }

                // Clear UI messages except initial greeting & chips
                if (messagesContainer) {
                    const allBubbles = messagesContainer.querySelectorAll('.flex-col:not(#chatbot-typing-indicator)');
                    allBubbles.forEach((el, index) => {
                        if (index > 0) el.remove(); // keep only the first greeting
                    });
                }

                if (chipsContainer) {
                    chipsContainer.classList.remove('hidden');
                }

                scrollToBottom();
            };

            if (typeof openAppConfirmModal === 'function') {
                openAppConfirmModal({
                    title: 'Bersihkan Obrolan AI',
                    message: 'Apakah Anda ingin membersihkan seluruh percakapan dan memulai obrolan baru dengan AI Assistant?',
                    confirmText: 'Bersihkan',
                    confirmClass: 'bg-rose-600 hover:bg-rose-700 text-white',
                    icon: 'danger',
                    onConfirm: executeReset
                });
            } else {
                executeReset();
            }
        });
    }
})();
</script>
