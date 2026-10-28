<!-- WIDGET AKSESIBILITAS & DISABILITAS (100% Frontend) -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Lexend:wght@400;500;600;700&display=swap" rel="stylesheet">

<?php
    $isDashboardLayout = $isDashboardLayout ?? false;
?>

<div id="a11y-widget-root" class="a11y-ignore">

    <!-- 1. Floating Action Button (FAB) Aksesibilitas (Digeser ke Kanan Bawah di Dashboard agar tidak menimpa Sidebar) -->
    <button type="button" 
            id="a11y-trigger-btn"
            class="a11y-ignore a11y-trigger fixed <?php echo e($isDashboardLayout ? 'bottom-6 right-6' : 'bottom-6 left-6'); ?> z-[9990] w-14 h-14 sm:w-16 sm:h-16 rounded-full bg-[#0b5a4a] hover:bg-[#084539] text-white flex items-center justify-center shadow-xl hover:shadow-2xl transition-all duration-200 hover:scale-105 active:scale-95 cursor-pointer focus:outline-none focus:ring-4 focus:ring-[#0b5a4a]/40 border-2 border-white/80"
            aria-label="Buka menu aksesibilitas disabilitas"
            aria-haspopup="dialog"
            aria-expanded="false"
            title="Aksesibilitas & Disabilitas">
        <!-- Universal Accessibility Icon -->
        <svg class="w-8 h-8 sm:w-9 sm:h-9 text-white pointer-events-none" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
            <path d="M12 2C13.1 2 14 2.9 14 4C14 5.1 13.1 6 12 6C10.9 6 10 5.1 10 4C10 2.9 10.9 2 12 2ZM20.5 6.5C19.8 5.8 18.7 5.7 17.9 6.2L13.8 8.7C13.3 9 12.7 9.2 12 9.2C11.3 9.2 10.7 9 10.2 8.7L6.1 6.2C5.3 5.7 4.2 5.8 3.5 6.5C2.7 7.2 2.7 8.3 3.3 9.1L6.5 13.3C6.8 13.7 7 14.3 7 14.8V21C7 21.6 7.4 22 8 22H10C10.6 22 11 21.6 11 21V16H13V21C13 21.6 13.4 22 14 22H16C16.6 22 17 21.6 17 21V14.8C17 14.3 17.2 13.7 17.5 13.3L20.7 9.1C21.3 8.3 21.3 7.2 20.5 6.5Z"/>
        </svg>
    </button>

    <!-- 2. Panel Menu Aksesibilitas (Super Simpel & Bersih) -->
    <div id="a11y-panel" 
         class="a11y-ignore hidden fixed <?php echo e($isDashboardLayout ? 'bottom-24 right-4 sm:right-6' : 'bottom-24 left-4 sm:left-6'); ?> z-[99999] w-[320px] sm:w-[350px] max-w-[calc(100vw-2rem)] bg-white rounded-2xl border border-[#e2e1d8] shadow-2xl p-5 max-h-[85vh] overflow-y-auto text-left"
         role="dialog"
         aria-modal="true"
         aria-label="Panel Pengaturan Aksesibilitas">
        
        <!-- Header Panel Simpel -->
        <div class="flex items-center justify-between pb-3 border-b border-[#e2e1d8]">
            <h2 class="text-[16px] font-bold text-[#161d1a]">Aksesibilitas</h2>

            <button type="button" 
                    id="a11y-close-btn"
                    class="p-1 rounded-md text-[#4b5551] hover:text-[#161d1a] hover:bg-[#f7f6f1] transition cursor-pointer"
                    aria-label="Tutup panel aksesibilitas">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        <!-- FITUR 1: Pembaca Layar -->
        <div class="py-3.5 border-b border-[#e2e1d8] flex items-center justify-between gap-3">
            <div class="space-y-0.5 pr-2">
                <div class="text-[14px] font-bold text-[#161d1a]">Pembaca layar</div>
                <div class="text-[12px] text-[#4b5551] leading-relaxed">
                    Klik teks untuk mendengarkannya
                </div>
            </div>
            <button type="button" 
                    id="a11y-toggle-reader"
                    class="a11y-switch"
                    role="switch" 
                    aria-checked="false"
                    aria-label="Aktifkan pembaca layar">
                <span class="sr-only">Aktifkan pembaca layar</span>
                <span class="a11y-switch-thumb"></span>
            </button>
        </div>

        <!-- FITUR 2: Ukuran Teks (3 Tombol Terpisah) -->
        <div class="py-3.5 border-b border-[#e2e1d8] space-y-2.5">
            <div class="text-[14px] font-bold text-[#161d1a]">Ukuran teks</div>
            <div class="grid grid-cols-3 gap-2">
                <button type="button" 
                        data-size="normal"
                        class="a11y-size-btn active py-2 px-1 sm:px-2 rounded-[8px] border border-[#0b5a4a] bg-[#0b5a4a] text-white text-[12.5px] sm:text-[13px] font-semibold transition cursor-pointer text-center shadow-sm">
                    Normal
                </button>
                <button type="button" 
                        data-size="lg"
                        class="a11y-size-btn py-2 px-1 sm:px-2 rounded-[8px] border border-[#e2e1d8] bg-white text-[#161d1a] hover:bg-[#f7f6f1] text-[12.5px] sm:text-[13px] font-medium transition cursor-pointer text-center">
                    Besar
                </button>
                <button type="button" 
                        data-size="xl"
                        class="a11y-size-btn py-2 px-1 sm:px-2 rounded-[8px] border border-[#e2e1d8] bg-white text-[#161d1a] hover:bg-[#f7f6f1] text-[12px] sm:text-[12.5px] font-medium transition cursor-pointer text-center whitespace-nowrap">
                    Lebih besar
                </button>
            </div>
        </div>

        <!-- FITUR 3: Kontras Tinggi -->
        <div class="py-3.5 border-b border-[#e2e1d8] flex items-center justify-between gap-3">
            <div class="space-y-0.5 pr-2">
                <div class="text-[14px] font-bold text-[#161d1a]">Kontras tinggi</div>
                <div class="text-[12px] text-[#4b5551] leading-relaxed">
                    Latar gelap dengan teks kuning
                </div>
            </div>
            <button type="button" 
                    id="a11y-toggle-contrast"
                    class="a11y-switch"
                    role="switch" 
                    aria-checked="false"
                    aria-label="Aktifkan kontras tinggi">
                <span class="sr-only">Aktifkan kontras tinggi</span>
                <span class="a11y-switch-thumb"></span>
            </button>
        </div>

        <!-- FITUR 4: Ramah Disleksia -->
        <div class="py-3.5 border-b border-[#e2e1d8] flex items-center justify-between gap-3">
            <div class="space-y-0.5 pr-2">
                <div class="text-[14px] font-bold text-[#161d1a]">Ramah disleksia</div>
                <div class="text-[12px] text-[#4b5551] leading-relaxed">
                    Jenis huruf dan spasi yang lebih lapang
                </div>
            </div>
            <button type="button" 
                    id="a11y-toggle-dyslexia"
                    class="a11y-switch"
                    role="switch" 
                    aria-checked="false"
                    aria-label="Aktifkan ramah disleksia">
                <span class="sr-only">Aktifkan ramah disleksia</span>
                <span class="a11y-switch-thumb"></span>
            </button>
        </div>

        <!-- FITUR 5: Sorot Tautan -->
        <div class="py-3.5 flex items-center justify-between gap-3">
            <div class="space-y-0.5 pr-2">
                <div class="text-[14px] font-bold text-[#161d1a]">Sorot tautan</div>
                <div class="text-[12px] text-[#4b5551] leading-relaxed">
                    Tandai tautan dan tombol dengan kuning
                </div>
            </div>
            <button type="button" 
                    id="a11y-toggle-links"
                    class="a11y-switch"
                    role="switch" 
                    aria-checked="false"
                    aria-label="Aktifkan sorot tautan">
                <span class="sr-only">Aktifkan sorot tautan</span>
                <span class="a11y-switch-thumb"></span>
            </button>
        </div>

        <!-- FOOTER: Tombol Atur Ulang -->
        <div class="pt-3 border-t border-[#e2e1d8]">
            <button type="button" 
                    id="a11y-btn-reset"
                    class="w-full py-2.5 px-4 rounded-[8px] border border-[#e2e1d8] bg-white hover:bg-[#f7f6f1] text-[#0b5a4a] hover:border-[#0b5a4a] text-[13px] font-semibold transition cursor-pointer flex items-center justify-center gap-2">
                <svg class="w-4 h-4 text-[#0b5a4a]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                </svg>
                <span>Atur ulang</span>
            </button>
        </div>

    </div>

</div>

<!-- SCRIPT PENGENDALI AKSESIBILITAS -->
<script>
    (function() {
        const STORAGE_KEY = 'daya_umkm_a11y_prefs';

        // State default
        const defaultState = {
            screenReader: false,
            fontSize: 'normal',
            contrast: false,
            dyslexia: false,
            links: false
        };

        let state = Object.assign({}, defaultState);

        // Load state dari localStorage
        try {
            const saved = localStorage.getItem(STORAGE_KEY);
            if (saved) {
                state = Object.assign({}, defaultState, JSON.parse(saved));
            }
        } catch (e) {
            console.error('Failed to load a11y preferences', e);
        }

        // DOM elements
        const panel = document.getElementById('a11y-panel');
        const triggerBtn = document.getElementById('a11y-trigger-btn');
        const closeBtn = document.getElementById('a11y-close-btn');
        const resetBtn = document.getElementById('a11y-btn-reset');

        const readerToggle = document.getElementById('a11y-toggle-reader');
        const contrastToggle = document.getElementById('a11y-toggle-contrast');
        const dyslexiaToggle = document.getElementById('a11y-toggle-dyslexia');
        const linksToggle = document.getElementById('a11y-toggle-links');
        const fontBtns = document.querySelectorAll('.a11y-size-btn');

        // Helper update visual switch (100% presisi dan tidak pernah overflow)
        function setSwitchVisual(switchEl, active) {
            if (!switchEl) return;
            switchEl.setAttribute('aria-checked', active ? 'true' : 'false');
            if (active) {
                switchEl.classList.add('active');
            } else {
                switchEl.classList.remove('active');
            }
        }

        // Simpan ke localStorage
        function saveState() {
            try {
                localStorage.setItem(STORAGE_KEY, JSON.stringify(state));
            } catch (e) {
                console.error('Failed to save a11y state', e);
            }
        }

        // Terapkan semua class ke elemen HTML
        function applyState() {
            const root = document.documentElement;

            // 1. Ukuran font
            root.classList.remove('a11y-font-sm', 'a11y-font-normal', 'a11y-font-lg', 'a11y-font-xl');
            if (state.fontSize === 'lg') root.classList.add('a11y-font-lg');
            else if (state.fontSize === 'xl') root.classList.add('a11y-font-xl');
            else root.classList.add('a11y-font-normal');

            // Update font buttons
            fontBtns.forEach(btn => {
                const s = btn.getAttribute('data-size');
                if (s === state.fontSize) {
                    btn.classList.add('active', 'bg-[#0b5a4a]', 'text-white', 'border-[#0b5a4a]', 'font-semibold', 'shadow-sm');
                    btn.classList.remove('bg-white', 'text-[#161d1a]', 'border-[#e2e1d8]', 'hover:bg-[#f7f6f1]', 'font-medium');
                } else {
                    btn.classList.remove('active', 'bg-[#0b5a4a]', 'text-white', 'border-[#0b5a4a]', 'font-semibold', 'shadow-sm');
                    btn.classList.add('bg-white', 'text-[#161d1a]', 'border-[#e2e1d8]', 'hover:bg-[#f7f6f1]', 'font-medium');
                }
            });

            // 2. Kontras tinggi
            if (state.contrast) {
                root.classList.add('a11y-high-contrast');
            } else {
                root.classList.remove('a11y-high-contrast');
            }
            setSwitchVisual(contrastToggle, state.contrast);

            // 3. Ramah disleksia
            if (state.dyslexia) {
                root.classList.add('a11y-dyslexia');
            } else {
                root.classList.remove('a11y-dyslexia');
            }
            setSwitchVisual(dyslexiaToggle, state.dyslexia);

            // 4. Sorot tautan
            if (state.links) {
                root.classList.add('a11y-highlight-links');
            } else {
                root.classList.remove('a11y-highlight-links');
            }
            setSwitchVisual(linksToggle, state.links);

            // 5. Pembaca Layar
            setSwitchVisual(readerToggle, state.screenReader);
            if (!state.screenReader && window.speechSynthesis) {
                window.speechSynthesis.cancel();
                clearSpeakingHighlight();
            }
        }

        // ==========================================
        // FITUR SCREEN READER (Web Speech API)
        // ==========================================
        let currentSpeakingEl = null;
        let selectedIndonesianVoice = null;

        function getBestIndonesianVoice() {
            if (!window.speechSynthesis) return null;
            const voices = window.speechSynthesis.getVoices();
            if (!voices || voices.length === 0) return null;

            // 1. Prioritas Suara Natural Edge (Microsoft Gadis / Ardi) - Sangat manusiawi & jernih
            let voice = voices.find(v => 
                (v.name.includes('Natural') || v.name.includes('Online')) && 
                (v.lang.toLowerCase().includes('id') || v.name.toLowerCase().includes('indonesia'))
            );
            if (voice) return voice;

            // 2. Prioritas Google Bahasa Indonesia (Chrome)
            voice = voices.find(v => 
                v.name.toLowerCase().includes('google') && 
                (v.lang.toLowerCase().includes('id') || v.name.toLowerCase().includes('indonesia'))
            );
            if (voice) return voice;

            // 3. Suara Apple macOS / iOS (Damayanti) atau nama Indonesia lain
            voice = voices.find(v => 
                v.name.toLowerCase().includes('damayanti') || 
                v.name.toLowerCase().includes('andika') || 
                v.name.toLowerCase().includes('indonesia')
            );
            if (voice) return voice;

            // 4. Semua suara dengan kode bahasa id-ID / id
            voice = voices.find(v => 
                v.lang && (v.lang.toLowerCase() === 'id-id' || v.lang.toLowerCase().startsWith('id'))
            );
            if (voice) return voice;

            // 5. Cadangan terdekat: Bahasa Melayu (ms-MY) jika tidak ada suara Indonesia
            voice = voices.find(v => 
                v.lang && (v.lang.toLowerCase().startsWith('ms') || v.name.toLowerCase().includes('malay'))
            );
            return voice || null;
        }

        function initVoices() {
            selectedIndonesianVoice = getBestIndonesianVoice();
        }

        if (window.speechSynthesis) {
            initVoices();
            if (window.speechSynthesis.onvoiceschanged !== undefined) {
                window.speechSynthesis.onvoiceschanged = initVoices;
            }
        }

        function clearSpeakingHighlight() {
            if (currentSpeakingEl) {
                currentSpeakingEl.classList.remove('a11y-speaking-active');
                currentSpeakingEl = null;
            }
        }

        function speakText(text, targetEl) {
            if (!window.speechSynthesis) {
                alert('Browser Anda belum mendukung Web Speech API pembaca suara.');
                return;
            }

            window.speechSynthesis.cancel();
            clearSpeakingHighlight();

            if (!text || !text.trim()) return;

            const utterance = new SpeechSynthesisUtterance(text.trim());
            utterance.lang = 'id-ID';

            // Pastikan voice terbaru terdeteksi
            if (!selectedIndonesianVoice) {
                selectedIndonesianVoice = getBestIndonesianVoice();
            }

            if (selectedIndonesianVoice) {
                utterance.voice = selectedIndonesianVoice;
            }

            // Kecepatan dan intonasi santai agar artikulasi bahasa Indonesia terdengar fasih & jelas
            utterance.rate = 0.94;
            utterance.pitch = 1.0;

            if (targetEl) {
                currentSpeakingEl = targetEl;
                currentSpeakingEl.classList.add('a11y-speaking-active');
            }

            utterance.onend = function() {
                clearSpeakingHighlight();
            };

            utterance.onerror = function() {
                clearSpeakingHighlight();
            };

            window.speechSynthesis.speak(utterance);
        }

        // Handler klik elemen teks saat mode pembaca layar aktif
        document.addEventListener('click', function(e) {
            if (!state.screenReader) return;

            // Abaikan klik di dalam panel widget aksesibilitas
            if (e.target.closest('.a11y-ignore')) return;

            // Cari elemen teks terdekat
            const target = e.target.closest('h1, h2, h3, h4, h5, h6, p, span, a, button, li, label, th, td');
            if (target) {
                const text = target.innerText || target.textContent;
                if (text && text.trim().length > 0) {
                    speakText(text, target);
                }
            }
        }, true);

        // ==========================================
        // EVENT HANDLERS PANEL & SWITCHES
        // ==========================================
        function togglePanel() {
            if (!panel) return;
            const isHidden = panel.classList.contains('hidden');
            if (isHidden) {
                panel.classList.remove('hidden');
                document.querySelectorAll('.a11y-trigger, #a11y-trigger-btn').forEach(btn => btn.setAttribute('aria-expanded', 'true'));
            } else {
                panel.classList.add('hidden');
                document.querySelectorAll('.a11y-trigger, #a11y-trigger-btn').forEach(btn => btn.setAttribute('aria-expanded', 'false'));
            }
        }

        if (closeBtn) {
            closeBtn.addEventListener('click', togglePanel);
        }

        // Delegated trigger & outside click handler
        document.addEventListener('click', function(e) {
            const triggerEl = e.target.closest('.a11y-trigger') || e.target.closest('#a11y-trigger-btn');
            if (triggerEl) {
                e.preventDefault();
                togglePanel();
                return;
            }

            if (!panel || panel.classList.contains('hidden')) return;
            if (!panel.contains(e.target)) {
                panel.classList.add('hidden');
                document.querySelectorAll('.a11y-trigger, #a11y-trigger-btn').forEach(btn => btn.setAttribute('aria-expanded', 'false'));
            }
        });

        // Tutup dengan tombol Escape
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && panel && !panel.classList.contains('hidden')) {
                panel.classList.add('hidden');
                document.querySelectorAll('.a11y-trigger, #a11y-trigger-btn').forEach(btn => btn.setAttribute('aria-expanded', 'false'));
            }
        });

        // Toggle Screen Reader
        if (readerToggle) {
            readerToggle.addEventListener('click', function() {
                state.screenReader = !state.screenReader;
                saveState();
                applyState();
                if (state.screenReader) {
                    speakText('Mode pembaca layar aktif. Silakan klik pada teks yang ingin Anda dengarkan.');
                }
            });
        }

        // Toggle Font Size Buttons
        fontBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                const size = this.getAttribute('data-size');
                state.fontSize = size;
                saveState();
                applyState();
            });
        });

        // Toggle Kontras
        if (contrastToggle) {
            contrastToggle.addEventListener('click', function() {
                state.contrast = !state.contrast;
                saveState();
                applyState();
            });
        }

        // Toggle Dyslexia
        if (dyslexiaToggle) {
            dyslexiaToggle.addEventListener('click', function() {
                state.dyslexia = !state.dyslexia;
                saveState();
                applyState();
            });
        }

        // Toggle Links
        if (linksToggle) {
            linksToggle.addEventListener('click', function() {
                state.links = !state.links;
                saveState();
                applyState();
            });
        }

        // Reset All
        if (resetBtn) {
            resetBtn.addEventListener('click', function() {
                state = Object.assign({}, defaultState);
                saveState();
                applyState();
                if (window.speechSynthesis) {
                    window.speechSynthesis.cancel();
                    clearSpeakingHighlight();
                }
            });
        }

        // Inisialisasi awal saat halaman dimuat
        applyState();
    })();
</script>
<?php /**PATH C:\laragon\laragon\www\Titik-UMKM\resources\views/components/accessibility-widget.blade.php ENDPATH**/ ?>