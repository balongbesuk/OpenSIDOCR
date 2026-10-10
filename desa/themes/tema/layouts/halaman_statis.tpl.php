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
                    
                    <!-- [LEFT SIDE: CONTENT AREA] -->
                    <div class="lg:col-span-8">
                        
                        <!-- [NAVIGATION BREADCRUMB] -->
                        <nav class="flex items-center gap-3 text-xs font-bold text-slate-400 uppercase tracking-widest mb-10">
                            <a href="<?= site_url() ?>" class="hover:text-brand-600 transition-colors">Beranda</a>
                            <i class="fa-solid fa-chevron-right text-[10px] opacity-40"></i>
                            <span class="text-slate-600 dark:text-slate-300 uppercase tracking-widest"><?= $heading ?></span>
                        </nav>

                        <!-- [CONTENT HEADER] -->
                        <header class="mb-12 border-b border-slate-200/60 dark:border-slate-800/60 pb-12">
                            <div class="flex items-center gap-2 mb-4 text-brand-600 font-bold tracking-[0.2em] uppercase text-[10px]">
                                <span class="w-8 h-px bg-brand-600"></span>
                                Informasi Layanan & Publik
                            </div>
                            <h1 class="font-display font-[800] text-4xl md:text-6xl text-slate-900 dark:text-white leading-[1.1] tracking-tight">
                                <?= $heading ?>.
                            </h1>
                        </header>

                        <!-- [DYNAMIC STATIC CONTENT] -->
                        <div class="prose prose-slate prose-lg lg:prose-xl max-w-none text-slate-700 dark:text-slate-300 transition-colors duration-500 leading-relaxed font-sans mb-24">
                            <?php $this->load->view($halaman_statis); ?>
                        </div>

                        <!-- [DISCUSSION SECTION] -->
                        <div class="mt-32">
                            <div class="flex items-center gap-6 mb-16">
                                <div class="w-16 h-16 rounded-3xl bg-brand-50 dark:bg-brand-900/40 text-brand-500 flex items-center justify-center text-4xl shadow-sm border border-brand-100 dark:border-brand-900/20 transition-transform hover:rotate-12">
                                    <i class="fa-solid fa-comments"></i>
                                </div>
                                <div>
                                    <h3 class="font-display font-[800] text-3xl md:text-4xl text-slate-900 dark:text-white tracking-tight leading-none">Diskusi.</h3>
                                    <p class="text-slate-400 dark:text-slate-500 font-bold uppercase tracking-widest text-[10px] mt-2">Sampaikan tanggapan Anda mengenai halaman ini.</p>
                                </div>
                            </div>
                            
                            <div class="p-8 md:p-16 rounded-[4rem] bg-white dark:bg-slate-900 border border-slate-100 dark:border-slate-800 shadow-2xl shadow-brand-900/5 relative overflow-hidden transition-colors duration-500">
                                <div class="absolute top-0 right-0 w-64 h-64 bg-brand-50 dark:bg-brand-900/20 rounded-full blur-3xl opacity-50 -mr-20 -mt-20"></div>
                                
                                <?php
                                    $disqus_shortname = 'balongbesuk';
                                    $disqus_config_file = FCPATH . $folder_themes . '/commons/disqus.php';
                                    if (is_file($disqus_config_file)) {
                                        include $disqus_config_file;
                                    }
                                    $disqus_shortname = trim((string) $disqus_shortname);
                                ?>
                                <?php if ($disqus_shortname !== ''): ?>
                                    <div id='disqus_thread' class="min-h-[300px] relative z-10 dark:invert-[0.05]"></div>
                                    <script>
                                        (function() {
                                            var d = document, s = d.createElement('script');
                                            s.src = 'https://<?= $disqus_shortname ?>.disqus.com/embed.js';
                                            s.setAttribute('data-timestamp', +new Date());
                                            (d.head || d.body).appendChild(s);
                                        })();
                                    </script>
                                    <noscript>Mohon aktifkan JavaScript untuk melihat <a href='https://disqus.com/?ref_noscript' target="_blank" rel="noopener noreferrer">komentar yang didukung oleh Disqus.</a></noscript>
                                <?php else: ?>
                                    <div class="relative z-10 rounded-[2rem] border border-dashed border-slate-200 dark:border-slate-700 px-6 py-10 text-center text-sm text-slate-500 dark:text-slate-400">
                                        Diskusi belum diaktifkan untuk halaman ini.
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>

                    </div>

                    <!-- [RIGHT SIDE: SIDEBAR WIDGETS] -->
                    <aside class="lg:col-span-4">
                        <?php $this->load->view("$folder_themes/commons/right_menu.php"); ?>
                    </aside>

                </div>
            </div>
        </section>
    </main>

    <!-- Footer -->
    <?php $this->load->view("$folder_themes/commons/copyleft.php"); ?>

    <!-- Back to Top Button Logic -->
    <button id="backToTop" class="fixed bottom-8 right-8 w-14 h-14 bg-brand-600 text-white rounded-2xl shadow-2xl shadow-brand-600/40 flex items-center justify-center opacity-0 invisible translate-y-10 transition-all duration-500 hover:bg-brand-900 z-50">
        <i class="fa-solid fa-arrow-up"></i>
    </button>

    <script>
        window.addEventListener('scroll', function() {
            const bt = document.getElementById('backToTop');
            if (window.scrollY > 500) {
                bt.classList.remove('opacity-0', 'invisible', 'translate-y-10');
            } else {
                bt.classList.add('opacity-0', 'invisible', 'translate-y-10');
            }
        });
        document.getElementById('backToTop').addEventListener('click', function() {
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });
    </script>

    <script src="<?= base_url($folder_themes . '/assets/js/app.js') ?>"></script>

    <!-- AOS (Animate On Scroll) Logic -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

</body>
</html>
