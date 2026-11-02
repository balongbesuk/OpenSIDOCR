/**
 * Website Official Theme Engine
 * Centralized JavaScript for Performance & Maintainability
 */

document.addEventListener('DOMContentLoaded', function() {
    
    // 1. [ THEME ENGINE ] - Check & Init Dark Mode
    const initTheme = () => {
        if (localStorage.getItem('theme') === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    };
    initTheme();

    // 2. [ SCROLL ORCHESTRATOR ]
    const header = document.querySelector('header');
    const bt = document.getElementById('backToTop');
    const progress = document.getElementById('reading-progress');

    window.addEventListener('scroll', function() {
        const scrollY = window.scrollY;

        // Header Glassmorphism
        if (header) {
            if (scrollY > 50) {
                header.classList.add('header-scrolled', 'py-1');
            } else {
                header.classList.remove('header-scrolled', 'py-1');
            }
        }

        // Back to Top Visibility
        if (bt) {
            if (scrollY > 500) {
                bt.classList.remove('opacity-0', 'invisible', 'translate-y-10');
            } else {
                bt.classList.add('opacity-0', 'invisible', 'translate-y-10');
            }
        }

        // Reading Progress
        if (progress) {
            const winScroll = document.body.scrollTop || document.documentElement.scrollTop;
            const height = document.documentElement.scrollHeight - document.documentElement.clientHeight;
            const scrolled = (winScroll / height) * 100;
            progress.style.width = scrolled + "%";
        }
    });

    // Back to Top Action
    if (bt) {
        bt.addEventListener('click', () => {
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });
    }

    // 3. [ NAVIGATION HANDLERS ]
    window.toggleMobileMenu = function() {
        const menu = document.getElementById('mobileMenu');
        if (!menu) return;
        menu.classList.toggle('translate-x-full');
        document.body.classList.toggle('overflow-hidden');
    };

    window.toggleDarkMode = function() {
        document.documentElement.classList.toggle('dark');
        const isDark = document.documentElement.classList.contains('dark');
        localStorage.setItem('theme', isDark ? 'dark' : 'light');
        
        // Update Highcharts if exists
        if (typeof Highcharts !== 'undefined') {
            Highcharts.charts.forEach(chart => {
                if (chart) {
                    const textColor = isDark ? '#94a3b8' : '#475569';
                    const gridColor = isDark ? '#1e293b' : '#f1f5f9';
                    chart.update({
                        chart: { backgroundColor: 'transparent' },
                        xAxis: { labels: { style: { color: textColor } }, lineColor: gridColor, tickColor: gridColor },
                        yAxis: { labels: { style: { color: textColor } }, gridLineColor: gridColor },
                        legend: { itemStyle: { color: textColor } }
                    });
                }
            });
        }
    };

    window.toggleSubMenu = function(btn) {
        if (!btn) return;
        const parentNode = btn.closest('.group\\/mobile-nav') || btn.closest('.relative') || btn.parentElement;
        const submenu = parentNode ? parentNode.querySelector('.mobile-submenu') : (btn.parentElement ? btn.parentElement.nextElementSibling : null);
        if (!submenu) return;

        const isHidden = submenu.classList.contains('max-h-0') || submenu.style.maxHeight === '0px' || !submenu.style.maxHeight;
        const icon = btn.querySelector('i');

        if (isHidden) {
            submenu.classList.remove('max-h-0', 'opacity-0', 'pointer-events-none');
            submenu.classList.add('opacity-100', 'pointer-events-auto');
            // Ukur scrollHeight asli agar semua item tampil penuh tanpa terpotong berapa pun banyaknya
            const targetHeight = Math.max(submenu.scrollHeight, 80) + 60;
            submenu.style.maxHeight = targetHeight + 'px';
            if (icon) {
                icon.classList.remove('fa-plus');
                icon.classList.add('fa-minus');
            }
            // Setelah transisi selesai, lepaskan batasan maxHeight agar sub-item dinamis tampil penuh
            setTimeout(() => {
                if (!submenu.classList.contains('max-h-0')) {
                    submenu.style.maxHeight = 'none';
                    submenu.style.overflow = 'visible';
                }
            }, 450);
        } else {
            submenu.style.overflow = 'hidden';
            submenu.style.maxHeight = submenu.scrollHeight + 'px';
            void submenu.offsetHeight; // trigger reflow
            submenu.style.maxHeight = '0px';
            submenu.classList.add('max-h-0', 'opacity-0', 'pointer-events-none');
            submenu.classList.remove('opacity-100', 'pointer-events-auto');
            if (icon) {
                icon.classList.remove('fa-minus');
                icon.classList.add('fa-plus');
            }
        }
    };

    // Tutup mobile menu saat tombol Escape ditekan
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            const menu = document.getElementById('mobileMenu');
            if (menu && !menu.classList.contains('translate-x-full')) {
                window.toggleMobileMenu();
            }
        }
    });

    // 4. [ LIGHTBOX ENGINE ]
    const initLightbox = () => {
        if (document.getElementById('imageLightbox')) return;
        const lightbox = document.createElement('div');
        lightbox.id = 'imageLightbox';
        lightbox.innerHTML = `
            <div class="close-lightbox"><i class="fa-solid fa-xmark"></i></div>
            <img src="" alt="Lightbox Preview">
        `;
        document.body.appendChild(lightbox);

        window.openLightbox = function(src) {
            const img = lightbox.querySelector('img');
            img.src = src;
            lightbox.classList.add('active');
            document.body.classList.add('overflow-hidden');
        };

        lightbox.addEventListener('click', () => {
            lightbox.classList.remove('active');
            document.body.classList.remove('overflow-hidden');
        });

        const closeBtn = lightbox.querySelector('.close-lightbox');
        closeBtn.addEventListener('click', (e) => {
            e.stopPropagation();
            lightbox.classList.remove('active');
            document.body.classList.remove('overflow-hidden');
        });
    };
    initLightbox();

    // 5. [ AOS GLOBAL INIT ]
    if (typeof AOS !== 'undefined') {
        setTimeout(() => {
            AOS.init({
                duration: 1000,
                once: true,
                easing: 'ease-in-out-cubic'
            });
        }, 500);
    }

    // 6. [ ACCESSIBILITY PATCH ]
    const patchA11y = () => {
        // Fix missing iframe titles
        document.querySelectorAll('iframe:not([title])').forEach(el => {
            el.setAttribute('title', 'Konten Eksternal');
        });

        // MutationObserver to catch late-loaded iframes (like Disqus)
        const observer = new MutationObserver((mutations) => {
            mutations.forEach((mutation) => {
                mutation.addedNodes.forEach((node) => {
                    if (node.nodeName === 'IFRAME' && !node.hasAttribute('title')) {
                        node.setAttribute('title', 'Konten Eksternal');
                    } else if (node.querySelectorAll) {
                        node.querySelectorAll('iframe:not([title])').forEach(iframe => {
                            iframe.setAttribute('title', 'Konten Eksternal');
                        });
                    }
                });
            });
        });

        observer.observe(document.body, { childList: true, subtree: true });
    };
    patchA11y();

    // 7. [ WIDGET HELPERS ]
    window.switchArsipTab = function(tabId) {
        document.querySelectorAll('.arsip-panel').forEach(p => {
            p.classList.add('hidden');
            p.classList.remove('block');
        });
        
        const activePanel = document.getElementById('panel-' + tabId);
        if (activePanel) {
            activePanel.classList.remove('hidden');
            activePanel.classList.add('block');
        }
        
        document.querySelectorAll('.arsip-tab-btn').forEach(b => {
            b.classList.remove('border-brand-600', 'text-brand-600', 'dark:text-brand-400');
            b.classList.add('border-transparent', 'text-slate-400');
        });
        
        const activeBtn = document.getElementById('tab-btn-' + tabId);
        if (activeBtn) {
            activeBtn.classList.add('border-brand-600', 'text-brand-600', 'dark:text-brand-400');
            activeBtn.classList.remove('border-transparent', 'text-slate-400');
        }
    };

});
