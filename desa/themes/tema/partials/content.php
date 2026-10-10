<?php if (!defined('BASEPATH'))
    exit('No direct script access allowed'); ?>

<div class="py-12 bg-slate-50/50 dark:bg-slate-900/50">
    <div class="container mx-auto px-4">

        <?php
        // [1. TOP NEWS / HEADLINE SECTION]
        if ((empty($_GET['cari'])) && ($headline)):
            $url = site_url('artikel/' . buat_slug($headline));
            ?>
            <article data-aos="fade-up"
                class="premium-card relative group mb-20 overflow-hidden flex flex-col lg:flex-row min-h-[500px]">
                <!-- Image Box -->
                <div class="lg:w-7/12 relative overflow-hidden bg-slate-200 skeleton">
                    <?php if (($headline['gambar'] != '') && (is_file(LOKASI_FOTO_ARTIKEL . "sedang_" . $headline['gambar']))): ?>
                        <img src="<?= AmbilFotoArtikel($headline['gambar'], 'sedang') ?>" alt="<?= $headline['judul'] ?>"
                            width="800" height="500"
                            class="absolute inset-0 w-full h-full object-cover transition-all duration-1000 group-hover:scale-110 group-hover:rotate-1 group-hover:saturate-[1.2]"
                            loading="eager" fetchpriority="high" />
                    <?php else: ?>
                        <div class="absolute inset-0 flex items-center justify-center bg-slate-100 text-slate-300">
                            <i class="fa-solid fa-newspaper text-8xl"></i>
                        </div>
                    <?php endif; ?>

                    <!-- Floating Badge -->
                    <?php if (trim($headline['kategori']) != ''): ?>
                        <div class="absolute top-8 left-8">
                            <span
                                class="px-5 py-2.5 rounded-2xl bg-brand-600/90 backdrop-blur-md text-white text-xs font-black uppercase tracking-[0.2em] shadow-lg shadow-brand-600/30">
                                <?= html_escape($headline['kategori']) ?>
                            </span>
                        </div>
                    <?php endif; ?>

                    <div class="absolute inset-x-0 bottom-0 h-32 bg-gradient-to-t from-black/20 to-transparent lg:hidden">
                    </div>
                </div>

                <!-- Content Box -->
                <div class="lg:w-5/12 p-10 md:p-16 flex flex-col justify-center bg-white dark:bg-slate-800 relative">
                    <div
                        class="flex items-center gap-3 text-slate-500 dark:text-slate-400 font-bold text-[10px] uppercase tracking-widest mb-6">
                        <i class="fa-solid fa-calendar-day text-brand-500"></i>
                        <?= tgl_indo($headline['tgl_upload']) ?>
                        <span class="w-1 h-1 rounded-full bg-slate-300"></span>
                        <i class="fa-solid fa-eye text-brand-500"></i>
                        <?= $headline['hit'] ?> Views
                    </div>

                    <h2
                        class="font-display font-black text-3xl md:text-5xl text-slate-900 leading-tight mb-8 hover:text-brand-600 transition-colors">
                        <a href="<?= $url ?>"><?= html_escape($headline['judul']) ?></a>
                    </h2>

                    <p class="text-slate-500 text-lg leading-relaxed line-clamp-3 mb-10">
                        <?= potong_teks($headline['isi'], 250) ?>
                    </p>

                    <div class="flex items-center gap-6">
                        <a href="<?= $url ?>"
                            class="group/btn flex items-center gap-3 px-8 py-4 bg-slate-900 text-white font-black text-sm rounded-2xl shadow-xl shadow-slate-900/20 hover:bg-brand-600 hover:shadow-brand-600/30 transition-all">
                            Baca Berita Utama
                            <i class="fa-solid fa-arrow-right transition-transform group-hover/btn:translate-x-2"></i>
                        </a>
                    </div>
                </div>
            </article>
        <?php endif; ?>

        <!-- [2. HEADER SECTION: SEARCH OR CATEGORY] -->
        <div class="mb-16 relative">
            <?php
            $is_search = !empty($_GET['cari']);
            $search_query = $is_search ? htmlspecialchars($_GET['cari']) : '';

            $title_main = "Kabar Desa";
            $title_sub = $desa['nama_desa'];

            if (!empty($judul_kategori)) {
                $title_main = (is_array($judul_kategori) ? end($judul_kategori) : $judul_kategori);
                $title_sub = "Kategori Berita";
            }

            if ($is_search) {
                $title_main = $search_query;
                $title_sub = "Hasil Pencarian";
            }
            ?>

            <div class="flex flex-col md:flex-row md:items-center justify-between gap-8">
                <div class="max-w-2xl animate-premium">
                    <div class="flex items-center gap-3 mb-4">
                        <span class="w-10 h-1 bg-brand-800 rounded-full"></span>
                        <span
                            class="text-brand-800 dark:text-brand-300 font-black tracking-[0.3em] uppercase text-[10px]"><?= html_escape($title_sub) ?></span>
                    </div>

                    <h3
                        class="font-display font-black text-4xl md:text-6xl text-slate-900 dark:text-white tracking-tight leading-none mb-4">
                        <?php if ($is_search): ?>
                            Menampilkan <span
                                class="text-transparent bg-clip-text bg-gradient-to-r from-brand-600 to-emerald-500">"<?= $title_main ?>"</span>
                        <?php else: ?>
                            <?= html_escape($title_main) ?>.
                        <?php endif; ?>
                    </h3>

                    <p class="text-slate-500 dark:text-slate-400 font-medium text-lg italic">
                        <?= $is_search ? "Ditemukan beberapa informasi yang sesuai dengan kata kunci pencarian Anda." : "Menyajikan informasi terpercaya dan transparansi langsung dari balai desa." ?>
                    </p>
                </div>

                <?php if ($is_search): ?>
                    <div
                        class="p-6 bg-white dark:bg-slate-800 rounded-[2.5rem] border border-slate-100 dark:border-slate-700 shadow-xl shadow-slate-200/40 dark:shadow-none flex flex-col items-center justify-center text-center px-12">
                        <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Total
                            Temuan</span>
                        <span class="text-4xl font-display font-black text-brand-600"><?= $paging->num_rows ?></span>
                        <span class="text-[9px] font-bold text-slate-500 uppercase mt-2">Artikel Berita</span>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10">
            <?php if ($artikel): ?>
                <?php foreach ($artikel as $data):
                    $url = site_url('artikel/' . buat_slug($data)); ?>
                    <article data-aos="fade-up"
                        class="premium-card group relative flex flex-col overflow-hidden transition-all duration-500 active:scale-[0.98] cursor-pointer">
                        <!-- Thumbnail -->
                        <div class="relative h-64 overflow-hidden bg-slate-100 dark:bg-slate-800 skeleton">
                            <?php if (($data['gambar'] != '') && (is_file(LOKASI_FOTO_ARTIKEL . "sedang_" . $data['gambar']))): ?>
                                <?php $is_first = ($index === 0 && empty($headline)); ?>
                                <img <?= $is_first ? 'loading="eager" fetchpriority="high"' : 'loading="lazy"' ?>
                                    src="<?= AmbilFotoArtikel($data['gambar'], 'sedang') ?>" alt="<?= html_escape($data['judul']) ?>"
                                    class="w-full h-full object-cover transition-transform duration-[2s] group-hover:scale-110" />
                            <?php else: ?>
                                <div class="w-full h-full flex items-center justify-center text-slate-300">
                                    <i class="fa-solid fa-image text-5xl"></i>
                                </div>
                            <?php endif; ?>

                            <!-- Category Badge -->
                            <div class="absolute bottom-4 left-4">
                                <span
                                    class="px-4 py-1.5 rounded-xl bg-white/90 dark:bg-slate-900/95 backdrop-blur-md text-[10px] font-display font-black text-brand-800 dark:text-brand-300 uppercase tracking-[0.15em] border border-white dark:border-slate-800 shadow-sm">
                                    <?= html_escape($data['kategori']) ?>
                                </span>
                            </div>
                        </div>

                        <!-- Card Body -->
                        <div class="p-8 flex-1 flex flex-col">
                            <div
                                class="flex items-center gap-3 text-[10px] font-bold text-slate-600 dark:text-slate-300 uppercase tracking-[0.15em] mb-4">
                                <i class="fa-solid fa-clock text-accent"></i>
                                <?= tgl_indo($data['tgl_upload']) ?>
                            </div>

                            <h4
                                class="font-display font-bold text-xl text-slate-900 leading-snug mb-4 group-hover:text-brand-600 transition-colors">
                                <a href="<?= $url ?>"><?= html_escape($data['judul']) ?></a>
                            </h4>

                            <p class="text-slate-600 dark:text-slate-400 text-sm leading-relaxed line-clamp-3 mb-6">
                                <?= potong_teks($data['isi'], 150) ?>
                            </p>

                            <div class="mt-auto pt-6 border-t border-slate-50 dark:border-slate-700/50">
                                <a href="<?= $url ?>"
                                    class="flex items-center justify-between text-[10px] font-display font-black text-slate-900 dark:text-slate-200 uppercase tracking-[0.2em] group/link"
                                    aria-label="Lanjutkan baca: <?= html_escape($data['judul']) ?>">
                                    <span>Lanjutkan Baca</span>
                                    <div
                                        class="w-10 h-10 rounded-full bg-slate-50 dark:bg-slate-700/50 flex items-center justify-center group-hover/link:bg-brand-600 group-hover/link:text-white transition-all duration-300">
                                        <i class="fa-solid fa-arrow-right-long" aria-hidden="true"></i>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </article>
                <?php endforeach; ?>
            <?php else: ?>
                <!-- Empty State: Premium Redesign -->
                <div class="col-span-full py-32 flex flex-col items-center text-center animate-premium">
                    <div class="relative group mb-10">
                        <!-- Decorative Glow -->
                        <div
                            class="absolute -inset-6 bg-brand-600/10 dark:bg-brand-600/20 rounded-full blur-2xl group-hover:scale-125 transition-transform duration-700">
                        </div>

                        <div
                            class="relative w-40 h-40 rounded-[3rem] bg-white dark:bg-slate-800 border border-slate-100 dark:border-slate-700 shadow-2xl flex items-center justify-center text-slate-200 dark:text-slate-700 overflow-hidden">
                            <i
                                class="fa-solid fa-box-open text-6xl group-hover:scale-110 transition-transform duration-500"></i>

                            <!-- Floating Particles -->
                            <div class="absolute top-4 right-4 w-2 h-2 rounded-full bg-brand-400 opacity-40 animate-pulse">
                            </div>
                            <div
                                class="absolute bottom-6 left-8 w-3 h-3 rounded-full bg-emerald-400 opacity-20 animate-pulse">
                            </div>
                        </div>
                    </div>

                    <div class="max-w-md">
                        <h3 class="font-display font-black text-3xl text-slate-900 dark:text-white mb-4 tracking-tight">
                            <?= $is_search ? 'Pencarian Tidak Ditemukan' : 'Belum Ada Konten' ?>
                        </h3>
                        <p class="text-slate-500 dark:text-slate-400 font-medium leading-relaxed mb-10">
                            <?= $is_search
                                ? "Mohon maaf, kami tidak menemukan artikel yang sesuai dengan kata kunci <span class='text-brand-600 font-bold italic'>\"$title_main\"</span>. Silakan coba kata kunci lain."
                                : "Saat ini belum ada dokumen atau artikel yang diterbitkan untuk kategori ini. Kami akan segera memperbarui informasi untuk Anda." ?>
                        </p>

                        <div class="flex flex-wrap justify-center gap-4">
                            <a href="<?= site_url() ?>"
                                class="px-8 py-4 bg-slate-900 dark:bg-brand-600 text-white font-black text-xs uppercase tracking-widest rounded-2xl shadow-xl shadow-slate-900/20 hover:bg-brand-600 transition-all active:scale-95">
                                Kembali ke Beranda
                            </a>
                            <?php if ($is_search): ?>
                                <button onclick="window.history.back()"
                                    class="px-8 py-4 bg-white dark:bg-slate-800 text-slate-600 dark:text-slate-300 font-black text-xs uppercase tracking-widest rounded-2xl border border-slate-100 dark:border-slate-700 shadow-sm hover:bg-slate-50 transition-all">
                                    Coba Lagi
                                </button>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>

        <!-- [3. PAGINATION SYSTEM] -->
        <?php if ($artikel): ?>
            <div class="mt-20 flex justify-center">
                <nav
                    class="inline-flex p-2 bg-white dark:bg-slate-800 rounded-3xl border border-slate-100 dark:border-slate-700 shadow-sm gap-1">
                    <?php if ($paging->start_link): ?>
                        <a href="<?= site_url($paging_page . "/$paging->start_link" . $paging->suffix) ?>"
                            class="w-12 h-12 flex items-center justify-center rounded-2xl text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-700 hover:text-brand-600 transition-all"
                            aria-label="Halaman Pertama">
                            <i class="fa-solid fa-angles-left text-xs" aria-hidden="true"></i>
                        </a>
                    <?php endif; ?>

                    <?php
                    $paging_range = 2;
                    $start_paging = max($paging->start_link, $p - $paging_range);
                    $end_paging = min($paging->end_link, $p + $paging_range);

                    for ($i = $start_paging; $i <= $end_paging; $i++):
                        $isActive = ($p == $i); ?>
                        <a href="<?= site_url($paging_page . "/$i" . $paging->suffix) ?>"
                            class="w-12 h-12 flex items-center justify-center rounded-2xl text-sm font-display font-black transition-all <?= $isActive ? 'bg-brand-600 text-white' : 'text-slate-500 hover:bg-brand-50 dark:hover:bg-brand-900/40 hover:text-brand-600' ?>"
                            aria-label="Halaman <?= $i ?>">
                            <?= $i ?>
                        </a>
                    <?php endfor; ?>

                    <?php if ($paging->end_link): ?>
                        <a href="<?= site_url($paging_page . "/$paging->end_link" . $paging->suffix) ?>"
                            class="w-12 h-12 flex items-center justify-center rounded-2xl text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-700 hover:text-brand-600 transition-all"
                            aria-label="Halaman Terakhir">
                            <i class="fa-solid fa-angles-right text-xs" aria-hidden="true"></i>
                        </a>
                    <?php endif; ?>
                </nav>
            </div>
        <?php endif; ?>

    </div>
</div>