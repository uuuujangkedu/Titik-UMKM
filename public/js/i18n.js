// DAYA-UMKM Multi-Language (i18n) Engine
(function() {
    'use strict';

    const STORAGE_KEY = 'daya_umkm_lang';
    const DEFAULT_LANG = 'id';

    // Indonesian translations
    const id = {
        'brand.subtitle': 'Produksi & sewa ruko',
        'nav.beranda': 'Beranda',
        'nav.tentang': 'Tentang kami',
        'nav.gabung': 'Gabung',
        'nav.gabung_label': 'Gabung:',
        'nav.gabung_investor_title': 'Daftar mitra investor',
        'nav.gabung_investor_sub': 'Mulai danai dan kembangkan usaha',
        'nav.gabung_umkm_title': 'Daftar pelaku UMKM',
        'nav.gabung_umkm_sub': 'Dapatkan akses modal dan sewa ruko',
        'nav.tutorial': 'Tutorial',
        'nav.bantuan': 'Bantuan',
        'nav.kontak': 'Kontak',
        'nav.masuk': 'Masuk',
        'nav.dashboard': 'Dashboard',
        'nav.bahasa_label': 'Bahasa:',
        'footer.copyright': '© ' + new Date().getFullYear() + '. Hak cipta dilindungi.',
        'footer.privacy': 'Kebijakan privasi',
        'footer.terms': 'Syarat dan ketentuan',
        'footer.help': 'Hubungi bantuan',

        // Dashboard common
        'dashboard.welcome': 'Selamat datang',
        'dashboard.profile': 'Profil',
        'dashboard.logout': 'Keluar',
        'dashboard.settings': 'Pengaturan',
        'dashboard.notifications': 'Notifikasi',
        'dashboard.total_portfolio': 'Total Portofolio:',
        'dashboard.kyc_verified': 'KYC Terverifikasi',
        'dashboard.fund_umkm': 'Danai UMKM',
    };

    // English translations
    const en = {
        'brand.subtitle': 'Production & shop rental',
        'nav.beranda': 'Home',
        'nav.tentang': 'About us',
        'nav.gabung': 'Join',
        'nav.gabung_label': 'Join:',
        'nav.gabung_investor_title': 'Register as Investor Partner',
        'nav.gabung_investor_sub': 'Fund and scale promising businesses',
        'nav.gabung_umkm_title': 'Register as MSME Entrepreneur',
        'nav.gabung_umkm_sub': 'Access productive capital and rentals',
        'nav.tutorial': 'How It Works',
        'nav.bantuan': 'Support',
        'nav.kontak': 'Contact',
        'nav.masuk': 'Sign In',
        'nav.dashboard': 'Dashboard',
        'nav.bahasa_label': 'Language:',
        'footer.copyright': '© ' + new Date().getFullYear() + '. All rights reserved.',
        'footer.privacy': 'Privacy Policy',
        'footer.terms': 'Terms & Conditions',
        'footer.help': 'Contact Support',

        // Dashboard common
        'dashboard.welcome': 'Welcome',
        'dashboard.profile': 'Profile',
        'dashboard.logout': 'Sign Out',
        'dashboard.settings': 'Settings',
        'dashboard.notifications': 'Notifications',
        'dashboard.total_portfolio': 'Total Portfolio:',
        'dashboard.kyc_verified': 'KYC Verified',
        'dashboard.fund_umkm': 'Fund MSME',
    };

    const i18nDict = { id, en };

    // Get saved language or default
    let savedLang = localStorage.getItem(STORAGE_KEY) || DEFAULT_LANG;
    if (!i18nDict[savedLang]) savedLang = DEFAULT_LANG;

    // Apply language to page
    function applyLanguage(lang) {
        if (!i18nDict[lang]) lang = DEFAULT_LANG;
        
        const currentDict = i18nDict[lang];
        localStorage.setItem(STORAGE_KEY, lang);
        document.documentElement.lang = lang;

        // Update text content
        document.querySelectorAll('[data-i18n]').forEach(el => {
            const key = el.getAttribute('data-i18n');
            if (currentDict[key]) {
                if (el.tagName === 'INPUT' || el.tagName === 'TEXTAREA') {
                    el.placeholder = currentDict[key];
                } else {
                    el.textContent = currentDict[key];
                }
            }
        });

        // Update placeholders
        document.querySelectorAll('[data-i18n-placeholder]').forEach(el => {
            const pKey = el.getAttribute('data-i18n-placeholder');
            if (currentDict[pKey]) {
                el.placeholder = currentDict[pKey];
            }
        });

        // Update titles
        document.querySelectorAll('[data-i18n-title]').forEach(el => {
            const tKey = el.getAttribute('data-i18n-title');
            if (currentDict[tKey]) {
                el.title = currentDict[tKey];
            }
        });

        // Update button states
        document.querySelectorAll('.lang-btn').forEach(btn => {
            const btnLang = btn.getAttribute('data-lang');
            if (btnLang === lang) {
                btn.classList.add('active');
                btn.setAttribute('aria-pressed', 'true');
            } else {
                btn.classList.remove('active');
                btn.setAttribute('aria-pressed', 'false');
            }
        });

        // Dispatch event
        window.dispatchEvent(new CustomEvent('appLanguageChanged', { detail: { lang } }));
    }

    // Initialize on page load
    function initLanguageSwitcher() {
        applyLanguage(savedLang);

        // Bind click handlers
        document.querySelectorAll('.lang-btn').forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                const lang = this.getAttribute('data-lang');
                applyLanguage(lang);
            });
        });
    }

    // Expose globally
    window.DayaUMKMLang = {
        applyLanguage,
        getCurrentLang: () => localStorage.getItem(STORAGE_KEY) || DEFAULT_LANG,
        getSupportedLangs: () => Object.keys(i18nDict),
        addTranslations: (lang, translations) => {
            if (i18nDict[lang]) {
                Object.assign(i18nDict[lang], translations);
            }
        }
    };

    // Auto-init when DOM ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initLanguageSwitcher);
    } else {
        initLanguageSwitcher();
    }
})();
