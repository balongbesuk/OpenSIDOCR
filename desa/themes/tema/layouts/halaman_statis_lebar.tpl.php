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

    <main class="min-h-screen animate-premium">
        <section class="py-12 md:py-24 bg-slate-50/50 dark:bg-slate-900/40">
            <div class="container mx-auto px-4">
                    <?php 
                        $is_app_module = in_array($halaman_statis, ['lapak/index', 'sdgs/index', 'analisis', 'pengaduan/index', 'pemerintah/index']) || strpos($halaman_statis, 'pembangunan') !== false;
                        $container_class = $is_app_module ? 'max-w-7xl' : 'max-w-5xl';
                        $wrapper_class = $is_app_module ? 'relative' : 'bg-white dark:bg-slate-900 p-8 md:p-20 rounded-[4rem] border border-slate-100 dark:border-slate-800 shadow-2xl shadow-brand-900/5 relative overflow-hidden';
                    ?>

                    <div class="<?= $container_class ?> mx-auto">
                        
                        <!-- [NAVIGATION BREADCRUMB - Optional] -->
                        <?php if (!empty($heading) && !$is_app_module): ?>
                        <nav class="flex items-center gap-3 text-xs font-bold text-slate-400 uppercase tracking-widest mb-10">
                            <a href="<?= site_url() ?>" class="hover:text-brand-600 transition-colors">Beranda</a>
                            <i class="fa-solid fa-chevron-right text-[10px] opacity-40"></i>
                            <span class="text-slate-600 dark:text-slate-300 uppercase tracking-widest"><?= $heading ?></span>
                        </nav>

                        <!-- [CONTENT HEADER - Optional] -->
                        <header class="mb-16 border-b border-slate-200/60 dark:border-slate-800/60 pb-16 text-center">
                            <div class="flex items-center justify-center gap-3 mb-6 text-brand-600 font-bold tracking-[0.4em] uppercase text-[10px]">
                                <span class="w-12 h-px bg-brand-600"></span>
                                Informasi Publik
                                <span class="w-12 h-px bg-brand-600"></span>
                            </div>
                            <h1 class="font-display font-[900] text-4xl md:text-7xl text-slate-900 dark:text-white leading-[1.1] tracking-tight">
                                <?= $heading ?>.
                            </h1>
                        </header>
                        <?php endif; ?>

                        <!-- [DYNAMIC STATIC CONTENT - LEBAR / FULL WIDTH AREA] -->
                        <?php if($is_app_module): ?>
                            <div class="relative z-10">
                                <?php
                                    if (preg_match("/halaman_statis/i", $halaman_statis)) {
                                        $this->load->view($halaman_statis);
                                    } else {
                                        $this->load->view("{$folder_themes}/partials/{$halaman_statis}");
                                    }
                                ?>
                            </div>
                        <?php else: ?>
                            <div class="prose prose-slate prose-lg lg:prose-xl max-w-none text-slate-700 dark:text-slate-300 transition-all duration-500 leading-relaxed font-sans mb-24">
                                <div class="<?= $wrapper_class ?>">
                                    <!-- Subtle Abstract Decor -->
                                    <div class="absolute top-0 right-0 w-64 h-64 bg-brand-500/5 rounded-full blur-3xl -mr-32 -mt-32"></div>
                                    
                                    <div class="relative z-10">
                                        <?php
                                            if (preg_match("/halaman_statis/i", $halaman_statis)) {
                                                $this->load->view($halaman_statis);
                                            } else {
                                                $this->load->view("{$folder_themes}/partials/{$halaman_statis}");
                                            }
                                        ?>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>

                        <!-- [ACTION FOOTER] -->
                        <div class="flex flex-col md:flex-row items-center justify-between gap-10 pt-16 border-t border-slate-200/60 dark:border-slate-800/60">
                        <div class="flex flex-col items-center md:items-start gap-4">
                            <h4 class="font-display font-black text-xl text-slate-900 dark:text-white leading-none">Bagikan Halaman Ini</h4>
                            <div class="flex items-center gap-4">
                                <a href="https://www.facebook.com/sharer/sharer.php?u=<?= rawurlencode(current_url()) ?>" target="_blank" rel="noopener noreferrer" class="w-12 h-12 rounded-2xl bg-[#1877F2]/10 text-[#1877F2] flex items-center justify-center hover:bg-[#1877F2] hover:text-white transition-all shadow-lg shadow-blue-500/5" aria-label="Bagikan ke Facebook">
                                    <i class="fa-brands fa-facebook-f text-lg"></i>
                                </a>
                                <a href="https://api.whatsapp.com/send?text=<?= rawurlencode(current_url()) ?>" target="_blank" rel="noopener noreferrer" class="w-12 h-12 rounded-2xl bg-[#25D366]/10 text-[#25D366] flex items-center justify-center hover:bg-[#25D366] hover:text-white transition-all shadow-lg shadow-green-500/5" aria-label="Bagikan ke WhatsApp">
                                    <i class="fa-brands fa-whatsapp text-xl"></i>
                                </a>
                            </div>
                        </div>
                        
                        <button onclick="window.print()" class="group px-10 py-5 bg-slate-900 dark:bg-brand-600 text-white rounded-3xl font-display font-black text-xs uppercase tracking-widest hover:bg-brand-900 transition-all shadow-2xl shadow-brand-600/20 flex items-center gap-4">
                            <i class="fa-solid fa-print group-hover:rotate-12 transition-transform"></i>
                            Cetak Dokumen Resmi
                        </button>
                    </div>

                </div>
            </div>
        </section>
    </main>

    <!-- Footer -->
    <?php $this->load->view("$folder_themes/commons/copyleft.php"); ?>

    <!-- Back to Top Button -->
    <button id="backToTop" class="fixed bottom-10 right-10 w-16 h-16 bg-brand-600 text-white rounded-3xl shadow-2xl shadow-brand-600/40 flex items-center justify-center opacity-0 invisible translate-y-10 transition-all duration-500 hover:-rotate-12 hover:scale-110 z-50" aria-label="Kembali ke Atas">
        <i class="fa-solid fa-arrow-up text-xl"></i>
    </button>

    <script>
        window.addEventListener('scroll', function() {
            const bt = document.getElementById('backToTop');
            if (window.scrollY > 600) {
                bt.classList.remove('opacity-0', 'invisible', 'translate-y-10');
            } else {
                bt.classList.add('opacity-0', 'invisible', 'translate-y-10');
            }
        });
        document.getElementById('backToTop').addEventListener('click', function() {
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });
    </script>

</body>
</html>
