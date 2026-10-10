<?php if(!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <?php $this->load->view("$folder_themes/commons/meta.php"); ?>
</head>
<body class="bg-white dark:bg-slate-950 font-sans text-slate-900 dark:text-slate-100 selection:bg-brand-100 dark:selection:bg-brand-900 selection:text-brand-900 dark:selection:text-brand-100 transition-colors duration-300 overflow-x-hidden">
    
    <!-- Navbar (Fixed) -->
    <?php $this->load->view("$folder_themes/commons/header.php"); ?>

    <div class="h-24 md:h-32"></div>

    <main class="min-h-screen">
        <section class="py-12 md:py-20 bg-slate-50/50 dark:bg-slate-900/40">
            <div class="container mx-auto px-4">
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-16">
                    
                    <!-- [LEFT SIDE: GALLERY CONTENT] -->
                    <div class="lg:col-span-8">
                        
                        <!-- [NAVIGATION BREADCRUMB] -->
                        <nav class="flex items-center gap-3 text-xs font-bold text-slate-400 uppercase tracking-widest mb-10">
                            <a href="<?= site_url() ?>" class="hover:text-brand-600 transition-colors">Beranda</a>
                            <i class="fa-solid fa-chevron-right text-[10px] opacity-40"></i>
                            <?php if (isset($parent)): ?>
                                <a href="<?= site_url('galeri') ?>" class="hover:text-brand-600 transition-colors">Galeri</a>
                                <i class="fa-solid fa-chevron-right text-[10px] opacity-40"></i>
                                <span class="text-slate-600 dark:text-slate-300 uppercase tracking-widest truncate"><?= $parent['nama'] ?></span>
                            <?php else: ?>
                                <span class="text-slate-600 dark:text-slate-300 uppercase tracking-widest">Galeri Desa</span>
                            <?php endif; ?>
                        </nav>

                        <!-- [HEADER] -->
                        <header class="mb-16">
                            <div class="flex items-center gap-2 mb-4 text-brand-600 font-bold tracking-[0.2em] uppercase text-[10px]">
                                <span class="w-8 h-px bg-brand-600"></span>
                                Visual Village Journal
                            </div>
                            <h1 class="font-display font-[800] text-4xl md:text-5xl text-slate-900 dark:text-white leading-[1.1] tracking-tight mb-6">
                                <?php if (isset($parent)): ?>
                                    Album <span class="text-transparent bg-clip-text bg-gradient-to-r from-brand-600 to-accent"><?= $parent['nama'] ?></span>.
                                <?php else: ?>
                                    Galeri <span class="text-transparent bg-clip-text bg-gradient-to-r from-brand-600 to-accent">Kegiatan</span> Desa.
                                <?php endif; ?>
                            </h1>
                            <p class="text-slate-500 dark:text-slate-400 font-medium max-w-2xl leading-relaxed italic">
                                Dokumentasi visual berbagai kegiatan, pembangunan, dan momen penting di <?= ucwords($this->setting->sebutan_desa) . ' ' . $desa['nama_desa'] ?>.
                            </p>
                        </header>

                        <!-- [DYNAMIC CONTENT: ALBUM OR PHOTOS] -->
                        <div class="gallery-content mb-20">
                            <?php 
                                if (isset($parent)) {
                                    $this->load->view("$folder_themes/partials/gallery/gambar.php");
                                } else {
                                    $this->load->view("$folder_themes/partials/gallery/album.php");
                                }
                            ?>
                        </div>

                    </div>

                    <!-- [RIGHT SIDE: SIDEBAR] -->
                    <aside class="lg:col-span-4">
                        <?php $this->load->view("$folder_themes/commons/right_menu.php"); ?>
                    </aside>

                </div>
            </div>
        </section>
    </main>

    <!-- Footer -->
    <?php $this->load->view("$folder_themes/commons/copyleft.php"); ?>

    <style>
        .fancybox-bg { background: rgba(15, 23, 42, 0.95) !important; backdrop-filter: blur(10px); }
        .fancybox-caption { font-family: 'Outfit', sans-serif; font-weight: 700; background: transparent !important; text-align: center !important; }
        .fancybox-container { z-index: 99999 !important; }
    </style>

</body>
</html>
