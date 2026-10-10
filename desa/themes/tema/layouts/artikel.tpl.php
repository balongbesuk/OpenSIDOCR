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
        <section class="py-12 md:py-20 bg-slate-50/50 dark:bg-slate-950/50">
            <div class="container mx-auto px-4">
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-16">
                    
                    <!-- [LEFT SIDE: ARTICLE CONTENT] -->
                    <div class="lg:col-span-8">
                    
                    <?php if ($single_artikel["id"]): ?>
                        <!-- [NAVIGATION BREADCRUMB] -->
                        <nav class="flex items-center gap-3 text-xs font-bold text-slate-400 uppercase tracking-widest mb-10">
                            <a href="<?= site_url() ?>" class="hover:text-brand-600 transition-colors">Beranda</a>
                            <i class="fa-solid fa-chevron-right text-[10px] opacity-40"></i>
                            <?php if (trim($single_artikel['kategori']) != ''): ?>
                                <a href="<?= site_url("artikel/kategori/$single_artikel[kat_slug]") ?>" class="hover:text-brand-600 transition-colors tracking-[0.2em]"><?= html_escape($single_artikel['kategori']) ?></a>
                                <i class="fa-solid fa-chevron-right text-[10px] opacity-40"></i>
                            <?php endif; ?>
                            <span class="text-slate-600 dark:text-slate-300 truncate hidden md:block">Baca Artikel</span>
                        </nav>

                        <!-- [ARTICLE HEADER] -->
                        <header class="mb-12">
                            <h1 class="premium-h1 text-4xl md:text-6xl mb-8">
                                <?= html_escape($single_artikel['judul']) ?>
                            </h1>
                            
                            <div class="flex flex-wrap items-center gap-8 py-8 border-y border-slate-200/60 dark:border-slate-800/60">
                                <div class="flex items-center gap-4">
                                    <div class="w-12 h-12 rounded-2xl bg-brand-50 dark:bg-brand-900/40 text-brand-600 dark:text-brand-400 flex items-center justify-center text-xl shadow-sm border border-brand-100 dark:border-brand-900/20">
                                        <i class="fa-solid fa-calendar-day"></i>
                                    </div>
                                    <div class="leading-none">
                                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1.5">Dipublikasi</p>
                                        <p class="text-sm font-black text-slate-900 dark:text-slate-200"><?= tgl_indo($single_artikel['tgl_upload']) ?></p>
                                    </div>
                                </div>



                                <div class="flex items-center gap-3 ml-auto">
                                    <div class="flex items-center gap-2 px-5 py-2.5 rounded-2xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-slate-600 dark:text-slate-400 text-[10px] font-black uppercase tracking-widest shadow-sm">
                                        <i class="fa-solid fa-eye text-brand-500"></i>
                                        <?= number_format($single_artikel['hit'],0,',','.') ?> Dilihat
                                    </div>
                                </div>
                            </div>
                        </header>

                        <!-- [ARTICLE IMAGE] -->
                        <?php if ($single_artikel['gambar'] && is_file(LOKASI_FOTO_ARTIKEL."sedang_".$single_artikel['gambar'])): ?>
                            <figure class="mb-16 relative group overflow-hidden rounded-[3rem] shadow-2xl shadow-brand-900/5 border-8 border-white">
                                <a href="<?= AmbilFotoArtikel($single_artikel['gambar'],'sedang') ?>" onclick="openLightbox(this.href); return false;" class="block overflow-hidden rounded-[2.5rem] relative">
                                    <img src="<?= AmbilFotoArtikel($single_artikel['gambar'],'sedang') ?>" alt="<?= html_escape($single_artikel['judul']) ?>" class="w-full h-auto transition-transform duration-[1.5s] group-hover:scale-110" loading="eager" fetchpriority="high" />
                                    <div class="absolute inset-0 bg-gradient-to-t from-black/40 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity flex items-end p-8">
                                        <p class="text-white text-xs font-bold uppercase tracking-widest bg-brand-600/80 backdrop-blur-md px-4 py-2 rounded-xl">Klik untuk memperbesar gambar</p>
                                    </div>
                                </a>
                            </figure>
                        <?php endif; ?>

                        <!-- [ARTICLE CONTENT] -->
                        <article class="prose prose-slate prose-lg lg:prose-xl max-w-none premium-p transition-colors duration-500 leading-relaxed font-sans">

                            <div id="article-body">
                                <?php
                                    // Keep article HTML usable while removing the riskiest inline script/event vectors.
                                    $content = (string) $single_artikel['isi'];

                                    // Filter link spam eksternal secara dinamis untuk pencegahan sementara di frontend
                                    $content = preg_replace_callback('/<a\s[^>]*href=["\']([^"\']+)["\'][^>]*>(.*?)<\/a>/is', function($matches) {
                                        $url = $matches[1];
                                        $text = $matches[2];
                                        // Jika link mengarah ke domain desa sendiri, mailto, tel, path internal, atau anchor, biarkan tetap aktif.
                                        if (strpos($url, 'balongbesuk.desa.id') !== false || strpos($url, 'mailto:') !== false || strpos($url, 'tel:') !== false || (isset($url[0]) && ($url[0] == '/' || $url[0] == '#'))) {
                                            return $matches[0];
                                        }
                                        // Selain itu, kembalikan hanya teksnya saja tanpa link aktif (menghapus tag <a>)
                                        return $text;
                                    }, $content);

                                    $content = preg_replace('#<script\b[^>]*>.*?</script>#is', '', $content);
                                    $content = preg_replace('/\son\w+=(["\']).*?\1/is', '', $content);
                                    $content = preg_replace('/\s(href|src)=(["\'])\s*javascript:.*?\2/is', ' $1="#"', $content);
                                    $content = preg_replace('/<table\b([^>]*)>/i', '<div class="table-responsive"><table$1>', $content);
                                    $content = preg_replace('/<\/table>/i', '</table></div>', $content);
                                    echo $content;
                                ?>
                                
                                <?php if ($single_artikel['dokumen'] && is_file(LOKASI_DOKUMEN.$single_artikel['dokumen'])): ?>
                                    <div class="mt-16 p-10 rounded-[3rem] bg-brand-900 shadow-2xl shadow-brand-900/20 flex flex-col md:flex-row items-center justify-between gap-8 group">
                                        <div class="flex items-center gap-6">
                                            <div class="w-16 h-16 rounded-3xl bg-white/10 text-white flex items-center justify-center text-3xl border border-white/10 group-hover:scale-110 transition-transform">
                                                <i class="fa-solid fa-file-circle-check"></i>
                                            </div>
                                            <div>
                                                <p class="text-white font-display font-black text-xl leading-none mb-2">Dokumen Digital</p>
                                                <p class="text-brand-400 text-xs font-bold uppercase tracking-[0.2em]"><?= html_escape($single_artikel['link_dokumen']) ?></p>
                                            </div>
                                        </div>
                                        <a href="<?= base_url().LOKASI_DOKUMEN.$single_artikel['dokumen'] ?>" target="_blank" rel="noopener noreferrer" class="px-10 py-5 bg-white text-brand-900 font-black text-sm rounded-2xl shadow-lg hover:bg-brand-50 transition-all uppercase tracking-widest">
                                            Unduh Lampiran
                                        </a>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </article>

                        <!-- [GALLERY TAMBAHAN] -->
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mt-24">
                            <?php for($i=1; $i<=3; $i++): $img_key = "gambar".$i; ?>
                                <?php if($single_artikel[$img_key] && is_file(LOKASI_FOTO_ARTIKEL."sedang_".$single_artikel[$img_key])): ?>
                                    <div class="group relative aspect-[4/3] rounded-[2.5rem] overflow-hidden shadow-xl border-4 border-white bg-slate-100">
                                        <img src="<?= AmbilFotoArtikel($single_artikel[$img_key],'sedang') ?>" alt="Gallery <?= $i ?>" class="w-full h-full object-cover transition-transform duration-1000 group-hover:scale-110" />
                                        <a href="<?= AmbilFotoArtikel($single_artikel[$img_key],'sedang') ?>" onclick="openLightbox(this.href); return false;" class="absolute inset-0 bg-brand-900/60 opacity-0 group-hover:opacity-100 transition-opacity flex flex-col items-center justify-center text-white text-center p-6">
                                            <i class="fa-solid fa-magnifying-glass-plus text-3xl mb-3"></i>
                                            <span class="text-[10px] font-black uppercase tracking-[0.2em]">Zoom Image</span>
                                        </a>
                                    </div>
                                <?php endif; ?>
                            <?php endfor; ?>
                        </div>

                        <!-- [SHARE & INTERACTION] -->
                        <div class="mt-24 pt-12 border-t border-slate-200/60 dark:border-slate-800/60 flex flex-col md:flex-row items-center justify-between gap-10">
                            <div class="text-center md:text-left">
                                <p class="text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-[0.3em] mb-3">Interaksi Sosial</p>
                                <h2 class="font-display font-black text-2xl text-slate-900 dark:text-white">Bagikan Informasi Ini.</h2>
                            </div>
                            <div class="flex items-center gap-5">
                                <a href="https://www.facebook.com/sharer/sharer.php?u=<?= rawurlencode(current_url()) ?>" target="_blank" rel="noopener noreferrer" class="w-16 h-16 rounded-[1.5rem] bg-[#1877F2] text-white flex items-center justify-center hover:scale-110 hover:-translate-y-2 active:scale-95 transition-all shadow-2xl shadow-blue-500/30" aria-label="Bagikan ke Facebook">
                                    <i class="fa-brands fa-facebook-f text-2xl"></i>
                                </a>
                                <a href="https://api.whatsapp.com/send?text=<?= rawurlencode($single_artikel['judul'] . ' - ' . current_url()) ?>" target="_blank" rel="noopener noreferrer" class="w-16 h-16 rounded-[1.5rem] bg-[#25D366] text-white flex items-center justify-center hover:scale-110 hover:-translate-y-2 active:scale-95 transition-all shadow-2xl shadow-green-500/30" aria-label="Bagikan ke WhatsApp">
                                    <i class="fa-brands fa-whatsapp text-3xl"></i>
                                </a>
                                <button onclick="window.print()" class="w-16 h-16 rounded-[1.5rem] bg-slate-900 dark:bg-slate-800 text-white flex items-center justify-center hover:scale-110 hover:-translate-y-2 active:scale-95 transition-all shadow-2xl shadow-slate-900/30 dark:shadow-slate-950/50" aria-label="Cetak Halaman">
                                    <i class="fa-solid fa-print text-2xl"></i>
                                </button>
                            </div>
                        </div>

                        <!-- [DISCUSSION SECTION] -->
                        <div class="mt-32">
                            <div class="flex items-center gap-6 mb-16">
                                <div class="w-16 h-16 rounded-3xl bg-brand-50 dark:bg-brand-900/40 text-brand-500 flex items-center justify-center text-4xl shadow-sm border border-brand-100 dark:border-brand-900/20 transition-transform hover:rotate-12">
                                    <i class="fa-solid fa-comments"></i>
                                </div>
                                <div>
                                    <h3 class="font-display font-[800] text-3xl md:text-4xl text-slate-900 dark:text-white tracking-tight leading-none">Diskusi Publik.</h3>
                                    <p class="text-slate-400 dark:text-slate-500 font-bold uppercase tracking-widest text-[10px] mt-2">Sampaikan aspirasi atau pertanyaan Anda di bawah ini.</p>
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
                                        Diskusi publik belum diaktifkan untuk halaman ini.
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>

                    <?php else: ?>
                        <!-- Not Found State -->
                        <div class="py-32 text-center flex flex-col items-center">
                            <div class="w-40 h-40 rounded-[4rem] bg-slate-100 flex items-center justify-center text-slate-300 text-6xl mb-10 shadow-inner">
                                <i class="fa-solid fa-box-open"></i>
                            </div>
                            <h2 class="font-display font-black text-4xl text-slate-900 mb-6">Laman Tidak Ditemukan</h2>
                            <p class="text-slate-500 mb-12 max-w-sm mx-auto font-medium text-lg leading-relaxed">Konten yang Anda akses mungkin telah dihapus atau tautan yang Anda gunakan tidak valid.</p>
                            <a href="<?= site_url() ?>" class="px-10 py-5 bg-brand-600 text-white font-black rounded-2xl shadow-2xl shadow-brand-600/40 hover:bg-brand-900 transition-all uppercase tracking-widest text-sm">
                                Kembali ke Beranda Utama
                            </a>
                        </div>
                    <?php endif; ?>
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
    <button id="backToTop" class="fixed bottom-8 right-8 w-14 h-14 bg-brand-600 text-white rounded-2xl shadow-2xl shadow-brand-600/40 flex items-center justify-center opacity-0 invisible translate-y-10 transition-all duration-500 hover:bg-brand-900 z-50" aria-label="Kembali ke Atas">
        <i class="fa-solid fa-arrow-up" aria-hidden="true"></i>
    </button>

    <script src="<?= base_url($folder_themes . '/assets/js/app.js') ?>"></script>

    <!-- AOS (Animate On Scroll) Logic -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

</body>
</html>
