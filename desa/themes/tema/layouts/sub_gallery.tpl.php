<?php if(!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <?php $this->load->view("$folder_themes/commons/meta.php"); ?>
    <!-- Fancybox CSS is usually in meta/header, but making sure we have premium feel -->
</head>
<body class="bg-white dark:bg-slate-950 font-sans text-slate-900 dark:text-slate-100 selection:bg-brand-100 dark:selection:bg-brand-900 selection:text-brand-900 dark:selection:text-brand-100 transition-colors duration-300 overflow-x-hidden">
    
    <!-- Navbar (Fixed) -->
    <?php $this->load->view("$folder_themes/commons/header.php"); ?>

    <!-- Hero Header Section -->
    <header class="relative pt-32 pb-20 md:pt-48 md:pb-32 overflow-hidden bg-slate-900">
        <!-- Background Decoration -->
        <div class="absolute inset-0 z-0">
            <?php if (is_file(LOKASI_GALERI . "sedang_" . $parent['gambar'])): ?>
                <img src="<?= AmbilGaleri($parent['gambar'], 'sedang') ?>" class="w-full h-full object-cover opacity-20 blur-sm scale-110" alt="bg">
            <?php endif; ?>
            <div class="absolute inset-0 bg-gradient-to-b from-slate-900/60 via-slate-900 to-slate-950"></div>
        </div>

        <div class="container mx-auto px-4 relative z-10 text-center">
            <!-- Breadcrumb Hero -->
            <nav class="flex items-center justify-center gap-3 text-[10px] font-black text-brand-400 uppercase tracking-[0.3em] mb-8">
                <a href="<?= site_url() ?>" class="hover:text-white transition-colors">Beranda</a>
                <i class="fa-solid fa-circle text-[4px] opacity-40"></i>
                <a href="<?= site_url('galeri') ?>" class="hover:text-white transition-colors">Galeri</a>
                <i class="fa-solid fa-circle text-[4px] opacity-40"></i>
                <span class="text-slate-500">Koleksi Foto</span>
            </nav>

            <div class="max-w-4xl mx-auto">
                <h1 class="font-display font-[900] text-4xl md:text-7xl text-white leading-[1.1] tracking-tight mb-8">
                    <?= $parent['nama'] ?>.
                </h1>
                
                <div class="flex flex-wrap items-center justify-center gap-8 md:gap-12">
                    <div class="flex flex-col items-center">
                        <span class="text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-2">Tanggal Publikasi</span>
                        <p class="text-white font-black text-sm"><?= tgl_indo($parent['tgl_upload']) ?></p>
                    </div>
                    <div class="w-px h-10 bg-white/10 hidden md:block"></div>
                    <div class="flex flex-col items-center">
                        <span class="text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-2">Kategori</span>
                        <p class="text-brand-400 font-black text-sm uppercase tracking-wider">Dokumentasi Desa</p>
                    </div>
                    <div class="w-px h-10 bg-white/10 hidden md:block"></div>
                    <div class="flex items-center gap-4">
                        <a href="https://www.facebook.com/sharer/sharer.php?u=<?= rawurlencode(current_url()) ?>" target="_blank" rel="noopener noreferrer" class="w-10 h-10 rounded-xl bg-white/5 border border-white/10 flex items-center justify-center text-white hover:bg-[#1877F2] hover:border-[#1877F2] transition-all" aria-label="Bagikan ke Facebook">
                            <i class="fa-brands fa-facebook-f text-sm"></i>
                        </a>
                        <a href="https://api.whatsapp.com/send?text=<?= rawurlencode('Album ' . $parent['nama'] . ' - ' . current_url()) ?>" target="_blank" rel="noopener noreferrer" class="w-10 h-10 rounded-xl bg-white/5 border border-white/10 flex items-center justify-center text-white hover:bg-[#25D366] hover:border-[#25D366] transition-all" aria-label="Bagikan ke WhatsApp">
                            <i class="fa-brands fa-whatsapp text-lg"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Floating Scroll Down -->
        <div class="absolute bottom-10 left-1/2 -translate-x-1/2 animate-bounce">
            <i class="fa-solid fa-chevron-down text-white/20 text-xl"></i>
        </div>
    </header>

    <main class="min-h-screen bg-white dark:bg-slate-950">
        <!-- Content Section -->
        <section class="py-20 md:py-32">
            <div class="container mx-auto px-4">
                <!-- Inner Grid logic moved to partial but we wrap it for premium feel -->
                <div class="max-w-7xl mx-auto">
                    <div class="gallery-content">
                        <?php $this->load->view("$folder_themes/partials/gallery/gambar.php"); ?>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <!-- Footer -->
    <?php $this->load->view("$folder_themes/commons/copyleft.php"); ?>

    <style>
        .fancybox-bg { background: rgba(15, 23, 42, 0.98) !important; backdrop-filter: blur(20px); }
        .fancybox-caption { font-family: 'Outfit', sans-serif; font-weight: 800; background: transparent !important; text-align: center !important; font-size: 1.2rem !important; }
        .fancybox-container { z-index: 99999 !important; }
        .fancybox-toolbar { background: transparent !important; }
        .fancybox-navigation .fancybox-button { background: rgba(255,255,255,0.1) !important; border-radius: 20px !important; margin: 0 20px !important; }
    </style>

</body>
</html>
