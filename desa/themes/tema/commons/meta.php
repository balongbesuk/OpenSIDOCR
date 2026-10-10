<?php  if(!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php
$desa_name = trim((string) ($desa['nama_desa'] ?? ''));
$desa_title = trim($this->setting->website_title . ' ' . ucwords($this->setting->sebutan_desa) . ' ' . $desa_name);
$current_url = function_exists('current_url') ? current_url() : site_url();
$seo_title = $desa_title;
$seo_description = 'Portal resmi ' . $desa_title . ' - berita, layanan publik, profil wilayah, dan transparansi informasi desa.';
$seo_type = 'website';
$seo_image = base_url() . LOKASI_LOGO_DESA . 'Logo.jpg';
$seo_image_alt = 'Logo ' . ($desa_name !== '' ? $desa_name : 'desa');

if (!empty($single_artikel['judul'])) {
    $seo_title = trim($single_artikel['judul'] . ' - ' . $desa_title);
    $seo_type = 'article';

    if (!empty($single_artikel['isi'])) {
        $plain_content = trim(preg_replace('/\s+/', ' ', strip_tags((string) $single_artikel['isi'])));
        if ($plain_content !== '') {
            $seo_description = function_exists('mb_substr')
                ? mb_substr($plain_content, 0, 160)
                : substr($plain_content, 0, 160);
        }
    }

    if (!empty($single_artikel['gambar'])) {
        $seo_image = e(AmbilFotoArtikel($single_artikel['gambar'], 'sedang'));
        $seo_image_alt = $single_artikel['judul'];
    }
} elseif (!empty($heading)) {
    $seo_title = trim($heading . ' - ' . $desa_title);
    $seo_description = 'Informasi ' . $heading . ' di ' . $desa_title . '.';
}

$seo_title = html_escape($seo_title);
$seo_description = html_escape($seo_description);
$seo_image = html_escape($seo_image);
$seo_image_alt = html_escape($seo_image_alt);
$current_url = html_escape($current_url);
?>

    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    
    <!-- Core Dependencies -->
    <script src="<?= base_url($folder_themes . '/assets/js/jquery.min.js') ?>"></script>
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <meta name="robots" content="index,follow,max-image-preview:large,max-snippet:-1,max-video-preview:-1">
    <meta name="theme-color" content="#ffffff" media="(prefers-color-scheme: light)">
    <meta name="theme-color" content="#0f172a" media="(prefers-color-scheme: dark)">
    
    <title><?= $seo_title ?></title>

    <script>
        // Inisialisasi Dark Mode segera untuk mencegah flickering
        (function() {
            if (localStorage.getItem('theme') === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
            }
        })();
    </script>

    <!-- Meta SEO Modern -->
    <meta name="description" content="<?= $seo_description ?>">
    <meta name="keywords" content="desa, <?= html_escape($desa['nama_desa']) ?>, <?= html_escape($desa['nama_kecamatan']) ?>, opensid, profil desa">
    <link rel="canonical" href="<?= $current_url ?>">
    
    <!-- Open Graph Style -->
    <meta property="og:locale" content="id_ID">
    <meta property="og:title" content="<?= $seo_title ?>">
    <meta property="og:description" content="<?= $seo_description ?>">
    <meta property="og:type" content="<?= $seo_type ?>">
    <meta property="og:url" content="<?= $current_url ?>">
    <meta property="og:image" content="<?= $seo_image ?>">
    <meta property="og:image:alt" content="<?= $seo_image_alt ?>">
    <meta property="og:site_name" content="<?= html_escape($desa['nama_desa']) ?>">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="<?= $seo_title ?>">
    <meta name="twitter:description" content="<?= $seo_description ?>">
    <meta name="twitter:image" content="<?= $seo_image ?>">
    <meta name="twitter:image:alt" content="<?= $seo_image_alt ?>">

    <!-- Font Optimization -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="dns-prefetch" href="https://fonts.googleapis.com">
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link rel="preload" as="style" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Outfit:wght@400;600;800&display=swap">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Outfit:wght@400;600;800&display=swap" rel="stylesheet">

    <!-- Font Display Optimization for FontAwesome -->
    <style>
        @font-face { font-family: 'Font Awesome 6 Free'; font-display: swap; }
        @font-face { font-family: 'Font Awesome 6 Brands'; font-display: swap; }
        
        /* Global Accessibility Improvements */
        .text-slate-400 { color: #64748b !important; }
        .dark .text-slate-400 { color: #94a3b8 !important; }
        .text-slate-500 { color: #475569 !important; }
        .dark .text-slate-500 { color: #cbd5e1 !important; }
        iframe { border: none; }
    </style>

    <!-- Resource Preloading -->
    <link rel="dns-prefetch" href="https://unpkg.com">
    <link rel="preconnect" href="https://unpkg.com" crossorigin>
    <link rel="preload" href="<?= base_url($folder_themes . '/assets/webfonts/fa-solid-900.woff2') ?>" as="font" type="font/woff2" crossorigin>
    <link rel="preload" href="<?= base_url($folder_themes . '/assets/css/all.min.css') ?>" as="style">
    <link rel="preload" href="<?= base_url($folder_themes . '/assets/css/app.css') ?>?v=<?= file_exists(FCPATH . $folder_themes . '/assets/css/app.css') ? filemtime(FCPATH . $folder_themes . '/assets/css/app.css') : time() ?>" as="style">

    <!-- Font Awesome 6 (Localised) -->
    <link rel="stylesheet" href="<?= base_url($folder_themes . '/assets/css/all.min.css') ?>">

    <!-- Theme Main Style -->
    <link rel="stylesheet" href="<?= base_url($folder_themes . '/assets/css/app.css') ?>?v=<?= file_exists(FCPATH . $folder_themes . '/assets/css/app.css') ? filemtime(FCPATH . $folder_themes . '/assets/css/app.css') : time() ?>">

    <!-- AOS (Animate On Scroll) -->
    <link rel="preload" as="style" href="https://unpkg.com/aos@2.3.1/dist/aos.css">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet" media="print" onload="this.media='all'">
    <noscript><link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet"></noscript>

    <!-- Tailwind CSS Engine -->
    <script>
        (function() {
            var originalWarn = console.warn;
            console.warn = function() {
                if (arguments[0] && String(arguments[0]).indexOf('cdn.tailwindcss.com should not be used in production') !== -1) {
                    return;
                }
                return originalWarn.apply(console, arguments);
            };
            window.__restoreTailwindWarn = function() {
                console.warn = originalWarn;
            };
        })();
    </script>
    <script src="<?= base_url($folder_themes . '/assets/js/tailwind.js') ?>"></script>
    <script>
        if (window.__restoreTailwindWarn) {
            window.__restoreTailwindWarn();
            delete window.__restoreTailwindWarn;
        }
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                        display: ['Outfit', 'sans-serif'],
                    },
                    colors: {
                        brand: { 
                            50: '#eff6ff', 
                            100: '#dbeafe', 
                            300: '#93c5fd',
                            400: '#60a5fa', 
                            500: '#3b82f6', 
                            600: '#2563eb', 
                            700: '#1d4ed8', 
                            800: '#1e40af',
                            900: '#1e3a8a' 
                        },
                        accent: '#10b981'
                    }
                }
            }
        }
    </script>

    <!-- PWA (Progressive Web App) Support -->
    <link rel="manifest" href="<?= base_url('manifest.json') ?>">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="default">
    <meta name="apple-mobile-web-app-title" content="Desa Balongbesuk">
    <link rel="apple-touch-icon" href="<?= base_url('apple-touch-icon.png') ?>">

    <!-- OneSignal Push Notification SDK -->
    <script src="https://cdn.onesignal.com/sdks/web/v16/OneSignalSDK.page.js" defer></script>
    <script>
        window.OneSignalDeferred = window.OneSignalDeferred || [];
        OneSignalDeferred.push(async function(OneSignal) {
            await OneSignal.init({
                appId: "56a523c8-0ab9-4702-9f18-2ad17efa97e3",
            });
        });
    </script>

    <?php $this->load->view('head_tags_front') ?>

    <!-- [ POINT 4: SEO & OPENGRAPH ENHANCEMENT ] -->
    <?php if (!empty($single_artikel)): ?>
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "NewsArticle",
        "mainEntityOfPage": {
            "@type": "WebPage",
            "@id": "<?= $current_url ?>"
        },
        "headline": "<?= $seo_title ?>",
        "image": "<?= $seo_image ?>",
        "datePublished": "<?= date('c', strtotime($single_artikel['tgl_upload'])) ?>",
        "dateModified": "<?= date('c', strtotime($single_artikel['tgl_upload'])) ?>",
        "author": {
            "@type": "Organization",
            "name": "Pemerintah <?= ucwords($this->setting->sebutan_desa) ?> <?= $desa_name ?>",
            "url": "<?= site_url() ?>"
        },
        "publisher": {
            "@type": "Organization",
            "name": "Pemerintah <?= ucwords($this->setting->sebutan_desa) ?> <?= $desa_name ?>",
            "logo": {
                "@type": "ImageObject",
                "url": "<?= base_url() . LOKASI_LOGO_DESA . 'Logo.jpg' ?>"
            }
        },
        "description": "<?= $seo_description ?>"
    }
    </script>
    <?php endif; ?>

    <!-- [ POINT 1: SCRIPT PERFORMANCE OPTIMIZATION ] -->
    <script>
        // Global Performance Helper
        window.lazyScripts = [];
        function loadDeferredScripts() {
            window.lazyScripts.forEach(src => {
                const script = document.createElement('script');
                script.src = src;
                script.defer = true;
                document.body.appendChild(script);
            });
        }
        window.addEventListener('load', loadDeferredScripts);
    </script>

    <!-- PWA App Badging - Clear badge on app open -->
    <script>
        if ('clearAppBadge' in navigator) {
            navigator.clearAppBadge().catch(function(err) {
                console.warn('Gagal membersihkan badge:', err);
            });
        }
    </script>
