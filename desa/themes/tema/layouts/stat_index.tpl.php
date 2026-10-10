<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <?php $this->load->view("$folder_themes/commons/meta.php"); ?>
</head>
<body class="bg-slate-50/60 dark:bg-slate-950 font-sans text-slate-900 dark:text-slate-100 selection:bg-brand-100 dark:selection:bg-brand-900 selection:text-brand-900 dark:selection:text-brand-100 transition-colors duration-300 [overflow-x:clip]">
    
    <!-- Navbar (Fixed) -->
    <?php $this->load->view("$folder_themes/commons/header.php"); ?>

    <div class="h-24 md:h-32"></div>

    <main class="min-h-screen animate-premium pb-20">
        
        <!-- [HERO & QUICK STATS SECTION] -->
        <section class="relative pt-6 pb-12 md:pb-16 overflow-hidden">
            <!-- Decorative Background Glows -->
            <div class="absolute -top-32 -left-32 w-96 h-96 bg-brand-500/10 dark:bg-brand-500/20 rounded-full blur-[120px] pointer-events-none"></div>
            <div class="absolute top-1/2 -right-32 w-96 h-96 bg-emerald-500/10 dark:bg-emerald-500/20 rounded-full blur-[120px] pointer-events-none"></div>

            <div class="container mx-auto px-4 max-w-7xl relative z-10">
                
                <!-- Breadcrumbs -->
                <nav class="flex flex-wrap items-center gap-2 md:gap-3 text-xs font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest mb-8">
                    <a href="<?= site_url() ?>" class="hover:text-brand-600 transition-colors">Beranda</a>
                    <i class="fa-solid fa-chevron-right text-[10px] opacity-40"></i>
                    <span class="text-brand-600 dark:text-brand-400 font-extrabold">Data Statistik Desa</span>
                </nav>

                <!-- Hero Title & Subtitle -->
                <div class="max-w-3xl mb-12">
                    <div class="inline-flex items-center gap-2.5 px-3.5 py-1.5 rounded-full bg-brand-50 dark:bg-brand-950/60 border border-brand-200 dark:border-brand-900/50 mb-4 shadow-sm">
                        <span class="w-2 h-2 rounded-full bg-brand-600 animate-pulse"></span>
                        <span class="text-brand-700 dark:text-brand-300 font-black tracking-[0.2em] uppercase text-[10px]">Data Visualization Center</span>
                    </div>
                    <h1 class="premium-h1 text-3xl md:text-5xl lg:text-6xl mb-4 font-display font-black leading-tight text-slate-900 dark:text-white">
                        Portal Data Statistik <span class="text-transparent bg-clip-text bg-gradient-to-r from-brand-600 to-emerald-500">Desa <?= html_escape($desa['nama_desa']) ?></span>.
                    </h1>
                    <p class="premium-p text-base md:text-lg text-slate-500 dark:text-slate-400 leading-relaxed">
                        Pusat transparansi dan eksplorasi data kependudukan desa. Jelajahi indikator demografi, profil keluarga, program bantuan sosial, dan wilayah secara akurat dan terbuka.
                    </p>
                </div>

                <!-- [4 QUICK METRIC CARDS] -->
                <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 md:gap-6 mb-12">
                    
                    <!-- Card Total Penduduk -->
                    <div class="p-5 md:p-6 rounded-[2rem] bg-white/95 dark:bg-slate-900/90 backdrop-blur-xl border border-slate-100 dark:border-slate-800 shadow-xl shadow-slate-200/30 dark:shadow-none hover:shadow-2xl transition-all duration-300 group">
                        <div class="flex items-center justify-between mb-4">
                            <div class="w-12 h-12 rounded-2xl bg-gradient-to-tr from-blue-600 to-indigo-600 text-white flex items-center justify-center text-xl shadow-lg shadow-blue-600/30 group-hover:scale-110 transition-transform">
                                <i class="fa-solid fa-users"></i>
                            </div>
                            <span class="text-[10px] font-black uppercase tracking-wider text-blue-600 dark:text-blue-400 bg-blue-50 dark:bg-blue-950/60 px-2.5 py-1 rounded-full border border-blue-200 dark:border-blue-900/50">
                                Populasi
                            </span>
                        </div>
                        <h4 class="text-2xl md:text-3xl font-display font-black text-slate-900 dark:text-white tracking-tight">
                            <?= number_format($quick_stats['penduduk'], 0, ',', '.') ?>
                        </h4>
                        <p class="text-xs font-bold text-slate-400 dark:text-slate-500 mt-1 uppercase tracking-wider">
                            Total Penduduk (Jiwa)
                        </p>
                    </div>

                    <!-- Card Total KK -->
                    <div class="p-5 md:p-6 rounded-[2rem] bg-white/95 dark:bg-slate-900/90 backdrop-blur-xl border border-slate-100 dark:border-slate-800 shadow-xl shadow-slate-200/30 dark:shadow-none hover:shadow-2xl transition-all duration-300 group">
                        <div class="flex items-center justify-between mb-4">
                            <div class="w-12 h-12 rounded-2xl bg-gradient-to-tr from-emerald-600 to-teal-600 text-white flex items-center justify-center text-xl shadow-lg shadow-emerald-600/30 group-hover:scale-110 transition-transform">
                                <i class="fa-solid fa-people-roof"></i>
                            </div>
                            <span class="text-[10px] font-black uppercase tracking-wider text-emerald-600 dark:text-emerald-400 bg-emerald-50 dark:bg-emerald-950/60 px-2.5 py-1 rounded-full border border-emerald-200 dark:border-emerald-900/50">
                                Keluarga
                            </span>
                        </div>
                        <h4 class="text-2xl md:text-3xl font-display font-black text-slate-900 dark:text-white tracking-tight">
                            <?= number_format($quick_stats['keluarga'], 0, ',', '.') ?>
                        </h4>
                        <p class="text-xs font-bold text-slate-400 dark:text-slate-500 mt-1 uppercase tracking-wider">
                            Kepala Keluarga (KK)
                        </p>
                    </div>

                    <!-- Card Total Wilayah Dusun -->
                    <div class="p-5 md:p-6 rounded-[2rem] bg-white/95 dark:bg-slate-900/90 backdrop-blur-xl border border-slate-100 dark:border-slate-800 shadow-xl shadow-slate-200/30 dark:shadow-none hover:shadow-2xl transition-all duration-300 group">
                        <div class="flex items-center justify-between mb-4">
                            <div class="w-12 h-12 rounded-2xl bg-gradient-to-tr from-purple-600 to-pink-600 text-white flex items-center justify-center text-xl shadow-lg shadow-purple-600/30 group-hover:scale-110 transition-transform">
                                <i class="fa-solid fa-map-location-dot"></i>
                            </div>
                            <span class="text-[10px] font-black uppercase tracking-wider text-purple-600 dark:text-purple-400 bg-purple-50 dark:bg-purple-950/60 px-2.5 py-1 rounded-full border border-purple-200 dark:border-purple-900/50">
                                Wilayah
                            </span>
                        </div>
                        <h4 class="text-2xl md:text-3xl font-display font-black text-slate-900 dark:text-white tracking-tight">
                            <?= number_format($quick_stats['dusun'], 0, ',', '.') ?>
                        </h4>
                        <p class="text-xs font-bold text-slate-400 dark:text-slate-500 mt-1 uppercase tracking-wider">
                            Jumlah <?= ucwords($this->setting->sebutan_dusun) ?>
                        </p>
                    </div>

                    <!-- Card DPT / Indikator Aktif -->
                    <div class="p-5 md:p-6 rounded-[2rem] bg-white/95 dark:bg-slate-900/90 backdrop-blur-xl border border-slate-100 dark:border-slate-800 shadow-xl shadow-slate-200/30 dark:shadow-none hover:shadow-2xl transition-all duration-300 group">
                        <div class="flex items-center justify-between mb-4">
                            <div class="w-12 h-12 rounded-2xl bg-gradient-to-tr from-amber-500 to-rose-500 text-white flex items-center justify-center text-xl shadow-lg shadow-amber-500/30 group-hover:scale-110 transition-transform">
                                <i class="<?= !empty($quick_stats['dpt_aktif']) ? 'fa-solid fa-check-to-slot' : 'fa-solid fa-chart-pie' ?>"></i>
                            </div>
                            <span class="text-[10px] font-black uppercase tracking-wider text-amber-600 dark:text-amber-400 bg-amber-50 dark:bg-amber-950/60 px-2.5 py-1 rounded-full border border-amber-200 dark:border-amber-900/50">
                                <?= !empty($quick_stats['dpt_aktif']) ? 'Pemilu' : 'Publik' ?>
                            </span>
                        </div>
                        <h4 class="text-2xl md:text-3xl font-display font-black text-slate-900 dark:text-white tracking-tight">
                            <?= !empty($quick_stats['dpt_aktif']) ? number_format($quick_stats['dpt'], 0, ',', '.') : number_format($total_indikator_aktif, 0, ',', '.') ?>
                        </h4>
                        <p class="text-xs font-bold text-slate-400 dark:text-slate-500 mt-1 uppercase tracking-wider">
                            <?= !empty($quick_stats['dpt_aktif']) ? 'Calon Pemilih (DPT)' : 'Indikator Aktif' ?>
                        </p>
                    </div>

                </div>

                <!-- [SEARCH & FILTER BAR TOOLBAR] -->
                <div class="p-6 md:p-8 rounded-[2.5rem] bg-white/95 dark:bg-slate-900/90 backdrop-blur-2xl border border-slate-100 dark:border-slate-800 shadow-xl shadow-slate-200/30 dark:shadow-none mb-12">
                    <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-6">
                        
                        <!-- Search Box Input -->
                        <div class="relative flex-1 max-w-xl">
                            <i class="fa-solid fa-magnifying-glass absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-sm"></i>
                            <input 
                                type="text" 
                                id="statSearchInput" 
                                placeholder="Cari nama indikator data (contoh: umur, pekerjaan, agama, dpt, bantuan)..."
                                class="w-full h-12 pl-11 pr-10 rounded-2xl bg-slate-50 dark:bg-slate-800/80 border border-slate-200 dark:border-slate-700/80 text-sm font-semibold text-slate-800 dark:text-slate-100 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-brand-500 transition-all"
                            />
                            <button id="statSearchClear" type="button" class="hidden absolute right-3.5 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600 dark:hover:text-white text-xs">
                                <i class="fa-solid fa-xmark"></i>
                            </button>
                        </div>

                        <!-- Category Filter Tabs -->
                        <div class="flex flex-wrap items-center gap-2">
                            <button type="button" data-cat="all" class="cat-pill active px-4 py-2 rounded-xl text-xs font-black uppercase tracking-wider transition-all bg-brand-600 text-white shadow-md shadow-brand-600/30">
                                Semua (<?= $total_indikator_aktif ?>)
                            </button>
                            <?php foreach ($kategori_statistik as $cat_key => $cat): ?>
                                <button type="button" data-cat="<?= $cat_key ?>" class="cat-pill px-4 py-2 rounded-xl text-xs font-bold uppercase tracking-wider transition-all bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300 hover:bg-slate-200 dark:hover:bg-slate-700">
                                    <?= html_escape($cat['badge']) ?> (<?= $cat['total'] ?>)
                                </button>
                            <?php endforeach; ?>
                        </div>

                    </div>
                </div>

                <!-- [KATALOG KATEGORI & INDIKATOR STATISTIK (HANYA YANG AKTIF)] -->
                <div class="space-y-14" id="katalogStatistikContainer">
                    
                    <?php foreach ($kategori_statistik as $cat_key => $cat): ?>
                        <div class="stat-category-block" data-category="<?= $cat_key ?>">
                            
                            <!-- Header Kategori -->
                            <div class="flex flex-col md:flex-row md:items-end justify-between gap-4 pb-4 mb-6 border-b border-slate-200/80 dark:border-slate-800">
                                <div class="flex items-center gap-3.5">
                                    <div class="w-12 h-12 rounded-2xl bg-gradient-to-tr <?= $cat['gradient'] ?> text-white flex items-center justify-center text-lg shadow-md shadow-brand-600/20">
                                        <i class="<?= $cat['icon'] ?>"></i>
                                    </div>
                                    <div>
                                        <div class="flex items-center gap-2.5">
                                            <h2 class="text-xl md:text-2xl font-display font-black text-slate-900 dark:text-white">
                                                <?= html_escape($cat['judul']) ?>
                                            </h2>
                                            <span class="text-[10px] font-black uppercase tracking-wider px-2.5 py-0.5 rounded-full border <?= $cat['badge_color'] ?>">
                                                <?= $cat['total'] ?> Indikator Aktif
                                            </span>
                                        </div>
                                        <p class="text-xs md:text-sm text-slate-400 dark:text-slate-500 font-medium mt-0.5">
                                            <?= html_escape($cat['deskripsi']) ?>
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <!-- Grid Kartu Indikator -->
                            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-5">
                                <?php foreach ($cat['items'] as $item): ?>
                                    <a 
                                        href="<?= site_url($item['url']) ?>" 
                                        class="stat-card block p-6 rounded-[2rem] bg-white dark:bg-slate-900/80 border border-slate-100 dark:border-slate-800 shadow-lg shadow-slate-200/30 dark:shadow-none hover:shadow-2xl hover:border-brand-500/50 hover:-translate-y-1.5 transition-all duration-300 group relative overflow-hidden"
                                        data-title="<?= strtolower(html_escape($item['label'])) ?>"
                                        data-desc="<?= strtolower(html_escape($item['deskripsi'])) ?>"
                                    >
                                        <!-- Subtle Accent Gradient Glow on Hover -->
                                        <div class="absolute -right-16 -top-16 w-32 h-32 bg-brand-500/0 group-hover:bg-brand-500/10 rounded-full blur-2xl transition-all duration-500 pointer-events-none"></div>

                                        <div class="flex items-center justify-between mb-4">
                                            <div class="w-12 h-12 rounded-2xl bg-slate-100 dark:bg-slate-800 text-brand-600 dark:text-brand-400 flex items-center justify-center text-lg group-hover:bg-gradient-to-tr <?= $cat['gradient'] ?> group-hover:text-white transition-all duration-300 shadow-sm">
                                                <i class="<?= html_escape($item['icon_class']) ?>"></i>
                                            </div>
                                            <span class="w-8 h-8 rounded-full bg-slate-50 dark:bg-slate-800/80 text-slate-400 dark:text-slate-500 group-hover:text-brand-600 dark:group-hover:text-brand-400 group-hover:bg-brand-50 dark:group-hover:bg-brand-950/60 flex items-center justify-center text-xs transition-all duration-300 group-hover:translate-x-1">
                                                <i class="fa-solid fa-arrow-right"></i>
                                            </span>
                                        </div>

                                        <h3 class="font-display font-black text-base text-slate-900 dark:text-white group-hover:text-brand-600 dark:group-hover:text-brand-400 transition-colors mb-2 leading-snug">
                                            <?= html_escape($item['label']) ?>
                                        </h3>

                                        <p class="text-xs text-slate-500 dark:text-slate-400 font-medium leading-relaxed line-clamp-2 mb-4">
                                            <?= html_escape($item['deskripsi']) ?>
                                        </p>

                                        <div class="pt-3 border-t border-slate-100 dark:border-slate-800/80 flex items-center justify-between text-[11px] font-bold text-brand-600 dark:text-brand-400 uppercase tracking-wider">
                                            <span>Lihat Visualisasi</span>
                                            <i class="fa-solid fa-chart-column text-xs opacity-70 group-hover:opacity-100"></i>
                                        </div>
                                    </a>
                                <?php endforeach; ?>
                            </div>

                        </div>
                    <?php endforeach; ?>

                    <!-- Empty Search Result State -->
                    <div id="statNoResults" class="hidden py-16 text-center">
                        <div class="w-20 h-20 rounded-3xl bg-slate-100 dark:bg-slate-800 text-slate-400 flex items-center justify-center text-3xl mx-auto mb-4">
                            <i class="fa-solid fa-chart-simple"></i>
                        </div>
                        <h3 class="text-lg font-bold text-slate-800 dark:text-white mb-1">
                            Indikator Tidak Ditemukan
                        </h3>
                        <p class="text-xs text-slate-400 max-w-sm mx-auto">
                            Tidak ditemukan data statistik aktif yang sesuai dengan kata kunci pencarian Anda.
                        </p>
                    </div>

                </div>

                <!-- [INFO KOMITMEN TRANSPARANSI DATA] -->
                <div class="mt-16 p-8 md:p-12 rounded-[3rem] bg-slate-900 text-white relative overflow-hidden flex flex-col md:flex-row items-center justify-between gap-8 group">
                    <div class="absolute right-0 bottom-0 w-96 h-96 bg-brand-600/10 rounded-full blur-[100px] pointer-events-none"></div>
                    
                    <div class="relative z-10 flex flex-col md:flex-row gap-6 items-center text-center md:text-left">
                        <div class="w-16 h-16 rounded-2xl bg-white/10 backdrop-blur-3xl border border-white/20 flex items-center justify-center text-2xl group-hover:rotate-12 transition-all duration-500">
                            <i class="fa-solid fa-database text-brand-400"></i>
                        </div>
                        <div class="max-w-xl">
                            <h3 class="font-display font-black text-xl md:text-2xl mb-1.5 leading-tight">
                                Sistem Data Terintegrasi & Terbuka
                            </h3>
                            <p class="text-slate-300 text-xs md:text-sm font-medium leading-relaxed">
                                Seluruh indikator statistik bersumber dari basis data Sistem Informasi Desa (SID) Pemerintah <?= html_escape($desa['nama_desa']) ?> yang diperbarui secara berkesinambungan untuk mendukung transparansi dan perencanaan pembangunan desa.
                            </p>
                        </div>
                    </div>
                    
                    <div class="relative z-10">
                        <a href="<?= site_url('layanan-mandiri') ?>" class="inline-flex items-center gap-3 px-7 py-3.5 bg-brand-600 text-white font-black rounded-2xl hover:bg-brand-500 hover:-translate-y-0.5 transition-all text-center uppercase tracking-widest text-xs shadow-xl shadow-brand-600/30 whitespace-nowrap">
                            <span>Layanan Mandiri</span>
                            <i class="fa-solid fa-arrow-right"></i>
                        </a>
                    </div>
                </div>

            </div>
        </section>

    </main>

    <!-- Footer -->
    <?php $this->load->view("$folder_themes/commons/copyleft.php"); ?>

    <!-- Back to Top Button -->
    <button id="backToTop" class="fixed bottom-12 right-12 w-16 h-16 bg-brand-600 text-white rounded-[2rem] shadow-2xl shadow-brand-600/40 flex items-center justify-center opacity-0 invisible translate-y-10 transition-all duration-500 hover:bg-brand-900 z-[9999]" aria-label="Kembali ke Atas">
        <i class="fa-solid fa-arrow-up text-xl" aria-hidden="true"></i>
    </button>

    <script>
        $(document).ready(function() {
            var activeCategory = 'all';
            var searchQuery = '';

            function filterCards() {
                var visibleCount = 0;

                $('.stat-category-block').each(function() {
                    var $catBlock = $(this);
                    var catKey = $catBlock.data('category');
                    var isCatMatch = (activeCategory === 'all' || activeCategory === catKey);

                    var catVisibleCards = 0;

                    $catBlock.find('.stat-card').each(function() {
                        var $card = $(this);
                        var title = $card.data('title') || '';
                        var desc = $card.data('desc') || '';

                        var isSearchMatch = (searchQuery === '' || title.indexOf(searchQuery) !== -1 || desc.indexOf(searchQuery) !== -1);

                        if (isCatMatch && isSearchMatch) {
                            $card.show();
                            catVisibleCards++;
                            visibleCount++;
                        } else {
                            $card.hide();
                        }
                    });

                    if (catVisibleCards > 0) {
                        $catBlock.show();
                    } else {
                        $catBlock.hide();
                    }
                });

                if (visibleCount === 0) {
                    $('#statNoResults').removeClass('hidden');
                } else {
                    $('#statNoResults').addClass('hidden');
                }
            }

            // Event Search Input
            $('#statSearchInput').on('input', function() {
                searchQuery = $(this).val().toLowerCase().trim();
                if (searchQuery.length > 0) {
                    $('#statSearchClear').removeClass('hidden');
                } else {
                    $('#statSearchClear').addClass('hidden');
                }
                filterCards();
            });

            // Clear Button
            $('#statSearchClear').on('click', function() {
                $('#statSearchInput').val('').trigger('input');
            });

            // Category Tabs Click
            $('.cat-pill').on('click', function() {
                $('.cat-pill').removeClass('active bg-brand-600 text-white shadow-md shadow-brand-600/30').addClass('bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300');
                $(this).addClass('active bg-brand-600 text-white shadow-md shadow-brand-600/30').removeClass('bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300');
                
                activeCategory = $(this).data('cat');
                filterCards();
            });

            // Back to top
            window.addEventListener('scroll', function() {
                const bt = document.getElementById('backToTop');
                if (window.scrollY > 400) {
                    bt.classList.remove('opacity-0', 'invisible', 'translate-y-10');
                } else {
                    bt.classList.add('opacity-0', 'invisible', 'translate-y-10');
                }
            });
            document.getElementById('backToTop').addEventListener('click', function() {
                window.scrollTo({ top: 0, behavior: 'smooth' });
            });
        });
    </script>

    <script src="<?= base_url($folder_themes . '/assets/js/app.js') ?>"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

</body>
</html>
