import Lenis from 'lenis';
import gsap from 'gsap';
import { ScrollTrigger } from 'gsap/ScrollTrigger';

function initMotion() {
    // 1. Reduced motion check — return immediately, leaving all content in default visible state
    const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    if (prefersReducedMotion) {
        document.querySelectorAll('[data-reveal], [data-reveal-item]').forEach(el => {
            el.style.opacity = '1';
            el.style.transform = 'none';
        });
        return;
    }

    // 2. Register GSAP Plugin once
    gsap.registerPlugin(ScrollTrigger);

    // 3. Initialize Lenis Smooth Scroll (Landing page & Gabung public pages)
    const lenis = new Lenis({
        duration: 1.1,
        smoothWheel: true,
        smoothTouch: false,
    });

    lenis.on('scroll', ScrollTrigger.update);
    gsap.ticker.add((time) => {
        lenis.raf(time * 1000);
    });
    gsap.ticker.lagSmoothing(0);
    window.lenis = lenis;

    // 4. Header sticky scrolled state synced with Lenis
    const header = document.getElementById('site-header');
    if (header) {
        const updateHeaderTransparency = () => {
            const isScrolled = (window.scrollY || window.pageYOffset || 0) > 15;
            if (isScrolled) {
                header.classList.remove('header-transparent');
                header.classList.add('header-scrolled');
            } else {
                header.classList.add('header-transparent');
                header.classList.remove('header-scrolled');
            }
        };

        lenis.on('scroll', () => {
            updateHeaderTransparency();
            if (typeof window.updateScrollSpy === 'function') {
                window.updateScrollSpy();
            }
        });
        updateHeaderTransparency();
    }

    // 5. Dynamic "Slide Pop-Up Ke Atas" Motion on Text & Elements (Landing Page & Public Pages)
    // Find all groups with [data-reveal-group] or fallback [data-reveal]
    const revealGroups = document.querySelectorAll('[data-reveal-group], [data-reveal]');
    const groupTimelines = new Map();

    revealGroups.forEach((group) => {
        // Find direct data-reveal-item children for this specific group
        const allItems = group.querySelectorAll('[data-reveal-item]');
        const items = Array.from(allItems).filter(item => {
            const closest = item.closest('[data-reveal-group], [data-reveal]');
            return closest === group;
        });

        if (items.length === 0) return;

        const isHero = group.id === 'beranda' || 
                        group.hasAttribute('data-hero') || 
                        Boolean(group.closest('#beranda'));

        // Set initial pop-up state: lower down (y: 44px), slightly scaled down (scale: 0.94), opacity: 0
        gsap.set(items, {
            opacity: 0,
            y: 44,
            scale: 0.94,
            transformOrigin: '50% 100%',
            force3D: true,
        });

        const tl = gsap.timeline({
            paused: true,
        });

        tl.to(items, {
            opacity: 1,
            y: 0,
            scale: 1,
            duration: 0.78,
            stagger: 0.11,
            ease: 'back.out(1.5)',
            clearProps: 'transform,opacity',
        });

        groupTimelines.set(group, tl);

        if (isHero) {
            // Hero section animates with a crisp pop after brief entry delay on initial load
            gsap.delayedCall(0.18, () => {
                tl.play();
            });
        } else {
            // ScrollTrigger triggers exactly as the text enters the active viewport (top 82%)
            ScrollTrigger.create({
                trigger: group,
                start: 'top 82%',
                onEnter: () => {
                    tl.play();
                },
                onLeaveBack: () => {
                    // Reset when scrolled completely back above viewport so it pops up again when scrolling down
                    tl.pause(0);
                    gsap.set(items, {
                        opacity: 0,
                        y: 44,
                        scale: 0.94,
                        transformOrigin: '50% 100%',
                    });
                }
            });
        }
    });

    // Safety net: ensure elements currently in viewport are revealed
    setTimeout(() => {
        groupTimelines.forEach((tl, group) => {
            if (tl.progress() === 0) {
                const rect = group.getBoundingClientRect();
                if (rect.top < window.innerHeight && rect.bottom > 0) {
                    tl.play();
                }
            }
        });
    }, 1200);

    // 6. Anchor link navigation coordinated with Lenis and Section Reveals
    function navigateToSection(targetEl, hash) {
        if (!targetEl) return;

        lenis.scrollTo(targetEl, {
            offset: -96,
            duration: 1.1,
            onComplete: () => {
                history.pushState(null, null, hash);
                // Guarantee the section has played its reveal animation upon reaching it
                groupTimelines.forEach((tl, group) => {
                    if (targetEl.contains(group) || group === targetEl) {
                        tl.play();
                    }
                });
                ScrollTrigger.refresh();
            }
        });

        const mobileMenu = document.getElementById('mobile-menu');
        if (mobileMenu && !mobileMenu.classList.contains('hidden')) {
            mobileMenu.classList.add('hidden');
        }
    }

    document.querySelectorAll('a[href*="#"]').forEach(link => {
        link.addEventListener('click', function(e) {
            const href = this.getAttribute('href');
            if (!href) return;
            const hashIndex = href.indexOf('#');
            if (hashIndex === -1) return;

            // Check if this link points to a hash on another page
            const pathPart = href.substring(0, hashIndex);
            const currentPath = window.location.pathname.replace(/\/$/, '') || '/';
            const cleanPathPart = pathPart.replace(/\/$/, '') || '/';
            
            if (pathPart && cleanPathPart !== currentPath) {
                // Cross-page link (e.g. href="/#tentang-kami" while on "/gabung/umkm")
                // Let browser navigate normally to the target page!
                return;
            }

            const hash = href.substring(hashIndex);
            if (!hash || hash === '#') return;

            const targetEl = document.querySelector(hash);
            if (targetEl) {
                e.preventDefault();
                navigateToSection(targetEl, hash);
            }
        });
    });

    const berandaLink = document.getElementById('nav-link-beranda');
    if (berandaLink) {
        berandaLink.addEventListener('click', function(e) {
            const isLanding = window.location.pathname === '/' || window.location.pathname === '';
            if (isLanding) {
                e.preventDefault();
                lenis.scrollTo(0, {
                    duration: 1.1,
                    onComplete: () => {
                        history.pushState(null, null, ' ');
                        ScrollTrigger.refresh();
                    }
                });
            }
        });
    }

    // 7. Initial Hash Navigation: e.g. opening /#tentang-kami or /gabung/umkm#manfaat-umkm directly
    if (window.location.hash) {
        const hash = window.location.hash;
        const targetEl = document.querySelector(hash);
        if (targetEl) {
            window.scrollTo(0, 0);
            setTimeout(() => {
                navigateToSection(targetEl, hash);
            }, 150);
        }
    }

    // 8. Refresh ScrollTrigger after initial setup
    ScrollTrigger.refresh();
}

// Register triggers once DOM is loaded, then refresh when fonts and images are ready
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', () => {
        initMotion();
        if (document.fonts) {
            document.fonts.ready.then(() => {
                ScrollTrigger.refresh();
            });
        }
    });
} else {
    initMotion();
    if (document.fonts) {
        document.fonts.ready.then(() => {
            ScrollTrigger.refresh();
        });
    }
}

window.addEventListener('load', () => {
    ScrollTrigger.refresh();
});

window.addEventListener('resize', () => {
    ScrollTrigger.refresh();
});
