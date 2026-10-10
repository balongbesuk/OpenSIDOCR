<?php if(!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <?php $this->load->view("$folder_themes/commons/meta.php"); ?>
    
    <!-- Highcharts (Localized) -->
    <script src="<?= base_url($folder_themes . '/assets/js/highcharts.js') ?>"></script>
    <script src="<?= base_url($folder_themes . '/assets/js/highcharts-more.js') ?>"></script>
    <script src="<?= base_url($folder_themes . '/assets/js/exporting.js') ?>"></script>
    <script src="<?= base_url($folder_themes . '/assets/js/accessibility.js') ?>"></script>

    <!-- [STYLE KHUSUS CETAK & RESPONSIVE ACTION TOOLBAR] -->
    <style>
        @media print {
            @page {
                size: A4 portrait;
                margin: 12mm 15mm 15mm 15mm;
            }
            body {
                background: #ffffff !important;
                color: #000000 !important;
                font-family: Arial, Helvetica, sans-serif !important;
                font-size: 10pt !important;
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }
            header, nav, aside, footer, #backToTop,
            .print\:hidden, [class*="glass-nav-island"] {
                display: none !important;
            }
            .hidden.print\:block {
                display: block !important;
            }
            .h-24, .md\:h-32 {
                display: none !important;
            }
            main, section, .container {
                padding: 0 !important;
                margin: 0 !important;
                max-width: 100% !important;
                width: 100% !important;
                background: transparent !important;
                border: none !important;
                box-shadow: none !important;
            }
            .space-y-12 > :not([hidden]) ~ :not([hidden]) {
                margin-top: 1.25rem !important;
            }
            .p-6, .md\:p-8, .md\:p-12, .rounded-\[2\.5rem\], .rounded-\[3\.5rem\] {
                padding: 0 !important;
                border-radius: 0 !important;
                border: none !important;
                background: transparent !important;
                box-shadow: none !important;
            }
            #chart-only {
                page-break-inside: avoid;
                margin-bottom: 20px !important;
            }
            .highcharts-container, .highcharts-container svg {
                max-width: 100% !important;
                width: 100% !important;
            }
            .tr-lebih.hide, tr.hide {
                display: table-row !important;
            }
            #showData {
                display: none !important;
            }
            .stat-rendered table, table.premium-table {
                width: 100% !important;
                border-collapse: collapse !important;
                font-size: 9pt !important;
                color: #000 !important;
                margin-top: 8px !important;
            }
            .stat-rendered th, .stat-rendered td,
            table.premium-table th, table.premium-table td {
                border: 1px solid #333 !important;
                padding: 5px 7px !important;
                color: #000 !important;
                background: transparent !important;
            }
            .stat-rendered th, table.premium-table thead th {
                background-color: #f1f5f9 !important;
                font-weight: bold !important;
                text-transform: uppercase !important;
            }
            table.premium-table tfoot th {
                background-color: #f1f5f9 !important;
                font-weight: bold !important;
            }
            tr {
                page-break-inside: avoid;
            }
        }
    </style>
</head>
<body class="bg-white dark:bg-slate-950 font-sans text-slate-900 dark:text-slate-100 selection:bg-brand-100 dark:selection:bg-brand-900 selection:text-brand-900 dark:selection:text-brand-100 transition-colors duration-300 [overflow-x:clip]">
    
    <!-- Navbar (Fixed) -->
    <?php $this->load->view("$folder_themes/commons/header.php"); ?>

    <div class="h-24 md:h-32"></div>

    <?php 
    // Detect page types via variables or URL
    $is_dpt = (isset($st) && $st == 'dpt') || (isset($tipe) && $tipe == 4) || (strpos(current_url(), 'daftar-pemilih-tetap') !== false) || (strpos(current_url(), 'dpt') !== false) || (!empty($slug_aktif) && in_array($slug_aktif, ['dpt', 'daftar-pemilih-tetap']));
    $is_wilayah = (isset($stat) && $stat == 0) || (isset($tipe) && $tipe == 3) || (strpos(current_url(), 'data-wilayah') !== false) || (strpos(current_url(), 'data_wilayah') !== false) || (!empty($slug_aktif) && $slug_aktif === 'data-wilayah');
    
    $chart_content = '';
    $table_content = '';

    if ($is_dpt) {
        ob_start();
        $this->load->view("$folder_themes/partials/statistik/dpt.php");
        $table_content = ob_get_clean();
    } elseif ($is_wilayah) {
        ob_start();
        $this->load->view("$folder_themes/partials/statistik/wilayah.php");
        $table_content = ob_get_clean();
    } else {
        ob_start();
        $stat_view_mode = 'chart';
        $this->load->view("$folder_themes/partials/statistik/statistik.php", compact('stat_view_mode'));
        $chart_content = ob_get_clean();

        ob_start();
        $stat_view_mode = 'table';
        $this->load->view("$folder_themes/partials/statistik/statistik.php", compact('stat_view_mode'));
        $table_content = ob_get_clean();
    }

    // Fallback for Title
    if (empty($stat_nama)) {
        if (!empty($heading)) $stat_nama = $heading;
        elseif ($is_dpt) $stat_nama = "Calon Pemilih";
        elseif ($is_wilayah) $stat_nama = "Wilayah Administratif";
        else $stat_nama = "Statistik Penduduk";
    }

    $stat_url_prefix = !empty($slug_aktif) ? "data-statistik/{$slug_aktif}" : "first/statistik/" . urlencode((string)$st);

    // Siapkan query string untuk filter wilayah
    $filter_params = [];
    if (!empty($filter_dusun)) $filter_params['dusun'] = $filter_dusun;
    if (!empty($filter_rw))    $filter_params['rw']    = $filter_rw;
    if (!empty($filter_rt))    $filter_params['rt']    = $filter_rt;
    $filter_query_str = !empty($filter_params) ? '?' . http_build_query($filter_params) : '';
    ?>

    <main class="min-h-screen animate-premium">
        <section class="py-8 md:py-16 bg-slate-50/50 dark:bg-slate-950">
            <div class="container mx-auto px-4 max-w-7xl">
                
                <!-- [NAVIGATION BREADCRUMB] -->
                <nav class="flex flex-wrap items-center gap-2 md:gap-3 text-xs font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest mb-8 print:hidden">
                    <a href="<?= site_url() ?>" class="hover:text-brand-600 transition-colors">Beranda</a>
                    <i class="fa-solid fa-chevron-right text-[10px] opacity-40"></i>
                    <a href="<?= site_url('data-statistik') ?>" class="hover:text-brand-600 transition-colors">Statistik Desa</a>
                    <i class="fa-solid fa-chevron-right text-[10px] opacity-40"></i>
                    <span class="text-brand-600 dark:text-brand-400 font-extrabold"><?= html_escape($stat_nama) ?></span>
                </nav>

                <!-- [TWO COLUMN GRID: SIDEBAR KIRI + KONTEN KANAN] -->
                <div class="flex flex-col lg:flex-row gap-8 lg:gap-10 items-start">
                    
                    <!-- [SIDEBAR KIRI: DAFTAR STATISTIK] -->
                    <aside class="w-full lg:w-80 lg:flex-shrink-0 lg:sticky lg:top-28 lg:self-start z-20 print:hidden">
                        <?php $this->load->view("$folder_themes/partials/statistik/sidenav.php", [
                            'slug_aktif' => $slug_aktif ?? '',
                            'st'         => $st ?? null,
                            'is_dpt'     => $is_dpt,
                            'is_wilayah' => $is_wilayah
                        ]); ?>
                    </aside>

                    <!-- [KONTEN UTAMA KANAN: GRAFIK & TABEL] -->
                    <div class="flex-1 min-w-0 w-full space-y-12">
                        
                        <!-- [DOKUMEN CETAK RESMI: KOP SURAT DESA (HANYA MUNCUL SAAT CETAK)] -->
                        <div class="hidden print:block mb-6 pb-3 border-b-4 border-double border-black text-center print-kop-container">
                            <div class="flex items-center justify-center gap-5 mb-2">
                                <?php if (!empty($desa['logo'])): ?>
                                    <img src="<?= gambar_desa($desa['logo']) ?>" alt="Logo Desa" class="w-16 h-16 object-contain" />
                                <?php endif; ?>
                                <div class="text-center">
                                    <h3 class="text-xs font-bold uppercase tracking-wider text-black leading-tight">
                                        PEMERINTAH KABUPATEN <?= html_escape($desa['nama_kabupaten']) ?>
                                    </h3>
                                    <h3 class="text-xs font-bold uppercase tracking-wider text-black leading-tight">
                                        KECAMATAN <?= html_escape($desa['nama_kecamatan']) ?>
                                    </h3>
                                    <h2 class="text-base font-black uppercase tracking-widest text-black leading-tight">
                                        DESA <?= html_escape($desa['nama_desa']) ?>
                                    </h2>
                                    <p class="text-[10px] text-gray-700 mt-0.5">
                                        <?= html_escape($desa['alamat_kantor']) ?>
                                    </p>
                                </div>
                            </div>
                            <div class="mt-2 pt-1.5 border-t border-black">
                                <h1 class="text-sm font-black uppercase tracking-wider text-black">
                                    LAPORAN STATISTIK: <?= html_escape($stat_nama) ?>
                                </h1>
                                <p class="text-[11px] text-gray-800 font-semibold">
                                    <?php if (!empty($filter_dusun)): ?>
                                        Wilayah: Dusun <?= html_escape($filter_dusun) ?> <?= !empty($filter_rw) ? '• RW ' . html_escape($filter_rw) : '' ?> <?= !empty($filter_rt) ? '• RT ' . html_escape($filter_rt) : '' ?>
                                    <?php else: ?>
                                        Cakupan: Seluruh Wilayah Desa
                                    <?php endif; ?>
                                    • Tanggal: <?= tgl_indo(date('Y-m-d')) ?>
                                </p>
                            </div>
                        </div>

                        <!-- [HEADER STATISTIK WEB] -->
                        <header class="flex flex-col lg:flex-row lg:items-end justify-between gap-6 relative print:hidden">
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center gap-3 mb-3">
                                    <span class="w-10 h-1 bg-brand-600 rounded-full"></span>
                                    <span class="text-brand-700 dark:text-brand-400 font-black tracking-[0.25em] uppercase text-[10px]">Data Visualization Center</span>
                                </div>
                                <h1 class="premium-h1 text-3xl md:text-5xl mb-3">
                                    <?= ($is_dpt) ? 'Daftar <span class="text-transparent bg-clip-text bg-gradient-to-r from-brand-600 to-emerald-500">Calon Pemilih</span>' : 'Statistik <span class="text-transparent bg-clip-text bg-gradient-to-r from-brand-600 to-emerald-500">' . html_escape($stat_nama) . '</span>' ?>.
                                </h1>
                                <p class="premium-p text-base md:text-lg max-w-xl text-slate-500 dark:text-slate-400">
                                    <?= ($is_dpt) ? 'Daftar warga yang memiliki hak pilih pada pemilihan umum mendatang berdasarkan data kependudukan terbaru.' : 'Analisis demografi wilayah berdasarkan pengelompokan ' . strtolower(html_escape($stat_nama)) . ' secara akurat.' ?>
                                </p>
                            </div>

                            <!-- [TOOLBAR AKSI: TOGGLE GRAFIK & CETAK (SEJAJAR TANPA WRAP)] -->
                            <div class="flex items-center gap-2.5 sm:gap-3 flex-shrink-0 relative z-10 self-start lg:self-end">
                                <!-- Toggle Graph Type (Hanya tampil jika bukan DPT atau Wilayah) -->
                                <?php if (!$is_dpt && !$is_wilayah): ?>
                                <div class="inline-flex p-1 bg-white dark:bg-slate-800 rounded-2xl shadow-lg shadow-slate-200/40 dark:shadow-none border border-slate-200/80 dark:border-slate-700/80 gap-1 items-center">
                                    <a href="<?= site_url("{$stat_url_prefix}/1" . $filter_query_str) ?>" title="Grafik Batang" class="w-9 h-9 sm:w-10 sm:h-10 rounded-xl flex items-center justify-center transition-all <?= ($tipe==1) ? 'bg-brand-600 text-white shadow-md shadow-brand-600/30' : 'text-slate-400 dark:text-slate-500 hover:bg-slate-50 dark:hover:bg-slate-700 hover:text-brand-600' ?>" aria-label="Tampilkan sebagai Grafik Batang">
                                        <i class="fa-solid fa-chart-column text-sm"></i>
                                    </a>
                                    <a href="<?= site_url("{$stat_url_prefix}/0" . $filter_query_str) ?>" title="Grafik Lingkaran" class="w-9 h-9 sm:w-10 sm:h-10 rounded-xl flex items-center justify-center transition-all <?= ($tipe==0) ? 'bg-brand-600 text-white shadow-md shadow-brand-600/30' : 'text-slate-400 dark:text-slate-500 hover:bg-slate-50 dark:hover:bg-slate-700 hover:text-brand-600' ?>" aria-label="Tampilkan sebagai Grafik Lingkaran">
                                        <i class="fa-solid fa-chart-pie text-sm"></i>
                                    </a>
                                    <a href="<?= site_url("{$stat_url_prefix}/2" . $filter_query_str) ?>" title="Grafik Garis" class="w-9 h-9 sm:w-10 sm:h-10 rounded-xl flex items-center justify-center transition-all <?= ($tipe==2) ? 'bg-brand-600 text-white shadow-md shadow-brand-600/30' : 'text-slate-400 dark:text-slate-500 hover:bg-slate-50 dark:hover:bg-slate-700 hover:text-brand-600' ?>" aria-label="Tampilkan sebagai Grafik Garis">
                                        <i class="fa-solid fa-chart-line text-sm"></i>
                                    </a>
                                </div>
                                <?php endif; ?>

                                <!-- Tombol Cetak -->
                                <button type="button" onclick="cetakStatistik()" title="Cetak Laporan Statistik" class="h-11 sm:h-12 px-5 sm:px-6 rounded-2xl bg-slate-900 dark:bg-brand-600 hover:bg-brand-600 dark:hover:bg-brand-500 text-white flex items-center justify-center gap-2.5 transition-all shadow-xl shadow-slate-900/10 active:scale-95 text-xs font-black uppercase tracking-wider whitespace-nowrap cursor-pointer">
                                    <i class="fa-solid fa-print text-sm"></i>
                                    <span>Cetak</span>
                                </button>
                            </div>
                        </header>

                        <!-- [FILTER WILAYAH: DUSUN, RW, RT] -->
                        <?php if (!$is_dpt && !$is_wilayah && !empty($daftar_dusun)): ?>
                        <div class="p-6 md:p-8 rounded-[2.5rem] bg-white/95 dark:bg-slate-900/90 backdrop-blur-2xl border border-slate-100 dark:border-slate-800 shadow-xl shadow-slate-200/40 dark:shadow-none print:hidden">
                            <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-6">
                                
                                <!-- Header Filter -->
                                <div class="flex items-center gap-3.5">
                                    <div class="w-10 h-10 rounded-2xl bg-gradient-to-tr from-brand-600 to-emerald-500 text-white flex items-center justify-center text-sm shadow-md shadow-brand-600/20">
                                        <i class="fa-solid fa-filter"></i>
                                    </div>
                                    <div>
                                        <h2 class="text-sm font-black text-slate-900 dark:text-white uppercase tracking-wider">Filter Wilayah</h2>
                                        <p class="text-[11px] font-medium text-slate-400 dark:text-slate-500">Saring demografi berdasarkan Dusun, RW, dan RT</p>
                                    </div>
                                </div>

                                <!-- Filter Form -->
                                <form method="get" action="<?= site_url($stat_url_prefix . ($tipe !== null && $tipe !== '' ? "/{$tipe}" : '')) ?>" id="formFilterWilayah" class="flex flex-wrap items-center gap-3 flex-1 lg:justify-end">
                                    
                                    <!-- Select Dusun -->
                                    <div class="relative min-w-[140px] flex-1 sm:flex-initial">
                                        <select name="dusun" id="selectDusun" class="w-full h-11 pl-4 pr-9 rounded-2xl bg-slate-50 dark:bg-slate-800/80 border border-slate-200 dark:border-slate-700/80 text-xs font-bold text-slate-700 dark:text-slate-200 focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-brand-500 appearance-none transition-all cursor-pointer">
                                            <option value="">Semua Dusun</option>
                                            <?php foreach ($daftar_dusun as $d): ?>
                                                <option value="<?= html_escape($d['dusun']) ?>" <?= ($filter_dusun === $d['dusun']) ? 'selected' : '' ?>>
                                                    <?= html_escape($d['dusun']) ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                        <i class="fa-solid fa-chevron-down absolute right-3.5 top-1/2 -translate-y-1/2 text-[10px] text-slate-400 pointer-events-none"></i>
                                    </div>

                                    <!-- Select RW -->
                                    <div class="relative min-w-[110px] flex-1 sm:flex-initial">
                                        <select name="rw" id="selectRw" class="w-full h-11 pl-4 pr-9 rounded-2xl bg-slate-50 dark:bg-slate-800/80 border border-slate-200 dark:border-slate-700/80 text-xs font-bold text-slate-700 dark:text-slate-200 focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-brand-500 appearance-none transition-all cursor-pointer disabled:opacity-50 disabled:cursor-not-allowed" <?= empty($filter_dusun) ? 'disabled' : '' ?>>
                                            <option value="">Semua RW</option>
                                            <?php if (!empty($daftar_rw)): ?>
                                                <?php foreach ($daftar_rw as $r): ?>
                                                    <option value="<?= html_escape($r['rw']) ?>" <?= ($filter_rw === $r['rw']) ? 'selected' : '' ?>>
                                                        RW <?= html_escape($r['rw']) ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                        </select>
                                        <i class="fa-solid fa-chevron-down absolute right-3.5 top-1/2 -translate-y-1/2 text-[10px] text-slate-400 pointer-events-none"></i>
                                    </div>

                                    <!-- Select RT -->
                                    <div class="relative min-w-[110px] flex-1 sm:flex-initial">
                                        <select name="rt" id="selectRt" class="w-full h-11 pl-4 pr-9 rounded-2xl bg-slate-50 dark:bg-slate-800/80 border border-slate-200 dark:border-slate-700/80 text-xs font-bold text-slate-700 dark:text-slate-200 focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-brand-500 appearance-none transition-all cursor-pointer disabled:opacity-50 disabled:cursor-not-allowed" <?= (empty($filter_dusun) || empty($filter_rw)) ? 'disabled' : '' ?>>
                                            <option value="">Semua RT</option>
                                            <?php if (!empty($daftar_rt)): ?>
                                                <?php foreach ($daftar_rt as $t): ?>
                                                    <option value="<?= html_escape($t['rt']) ?>" <?= ($filter_rt === $t['rt']) ? 'selected' : '' ?>>
                                                        RT <?= html_escape($t['rt']) ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                        </select>
                                        <i class="fa-solid fa-chevron-down absolute right-3.5 top-1/2 -translate-y-1/2 text-[10px] text-slate-400 pointer-events-none"></i>
                                    </div>

                                    <!-- Tombol Terapkan & Reset -->
                                    <div class="flex items-center gap-2">
                                        <button type="submit" class="h-11 px-5 rounded-2xl bg-brand-600 hover:bg-brand-500 text-white font-black text-xs uppercase tracking-wider flex items-center gap-2 transition-all shadow-md shadow-brand-600/30 active:scale-95">
                                            <i class="fa-solid fa-check text-xs"></i>
                                            <span>Filter</span>
                                        </button>
                                        <?php if (!empty($filter_dusun) || !empty($filter_rw) || !empty($filter_rt)): ?>
                                            <a href="<?= site_url($stat_url_prefix . ($tipe !== null && $tipe !== '' ? "/{$tipe}" : '')) ?>" class="h-11 px-4 rounded-2xl bg-rose-50 dark:bg-rose-950/40 hover:bg-rose-100 text-rose-600 dark:text-rose-400 font-bold text-xs uppercase tracking-wider flex items-center gap-1.5 transition-all border border-rose-200 dark:border-rose-900/50" title="Reset Filter Wilayah">
                                                <i class="fa-solid fa-rotate-left text-xs"></i>
                                                <span>Reset</span>
                                            </a>
                                        <?php endif; ?>
                                    </div>

                                </form>

                            </div>

                            <!-- Active Filter Badges -->
                            <?php if (!empty($filter_dusun)): ?>
                            <div class="flex flex-wrap items-center gap-2 pt-4 mt-4 border-t border-slate-100 dark:border-slate-800 text-[11px]">
                                <span class="font-bold text-slate-400 uppercase tracking-widest text-[10px]">Filter Aktif:</span>
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-brand-50 dark:bg-brand-950/60 text-brand-700 dark:text-brand-300 font-bold border border-brand-200 dark:border-brand-900/50">
                                    <i class="fa-solid fa-map-pin text-[10px] text-brand-500"></i>
                                    Dusun <?= html_escape($filter_dusun) ?>
                                </span>
                                <?php if (!empty($filter_rw)): ?>
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-indigo-50 dark:bg-indigo-950/60 text-indigo-700 dark:text-indigo-300 font-bold border border-indigo-200 dark:border-indigo-900/50">
                                    RW <?= html_escape($filter_rw) ?>
                                </span>
                                <?php endif; ?>
                                <?php if (!empty($filter_rt)): ?>
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-emerald-50 dark:bg-emerald-950/60 text-emerald-700 dark:text-emerald-300 font-bold border border-emerald-200 dark:border-emerald-900/50">
                                    RT <?= html_escape($filter_rt) ?>
                                </span>
                                <?php endif; ?>
                            </div>
                            <?php endif; ?>
                        </div>
                        <?php endif; ?>

                        <!-- [CHART CONTAINER] -->
                        <?php if (!$is_dpt && !$is_wilayah): ?>
                        <div>
                            <div class="p-6 md:p-12 rounded-[3.5rem] bg-white dark:bg-slate-800/50 border border-slate-100 dark:border-slate-800 shadow-2xl shadow-slate-200/40 dark:shadow-none relative overflow-hidden group">
                                <div class="absolute -right-32 -top-32 w-80 h-80 bg-brand-600/5 dark:bg-brand-600/10 rounded-full blur-[100px] pointer-events-none"></div>
                                
                                <div id="chart-only" class="stat-rendered relative z-10 transition-all duration-700">
                                    <?= $chart_content ?>
                                </div>
                            </div>
                        </div>
                        <?php endif; ?>

                        <!-- [TABEL DATA] -->
                        <div class="space-y-6">
                            <div class="flex items-center gap-6 px-2">
                                <h2 class="font-display font-black text-2xl md:text-3xl text-slate-900 dark:text-white flex items-center gap-3">
                                    Rincian Data <span class="text-brand-600 italic">Tabel</span>.
                                </h2>
                                <div class="flex-1 h-px bg-slate-200/80 dark:bg-slate-800"></div>
                            </div>

                            <div class="p-4 md:p-8 rounded-[3.5rem] bg-white dark:bg-slate-900/40 backdrop-blur-md border border-slate-100 dark:border-slate-800 shadow-2xl shadow-slate-200/40 dark:shadow-none relative overflow-hidden">
                                <div id="table-only" class="stat-rendered stat-table-box relative z-10 w-full overflow-x-auto">
                                    <?= $table_content ?>
                                </div>
                            </div>
                        </div>

                        <!-- [LEMBAR PENGESAHAN CETAK RESMI (HANYA MUNCUL SAAT CETAK)] -->
                        <div class="hidden print:block mt-8 pt-6 text-xs text-black border-t border-dashed border-gray-400">
                            <div class="flex justify-between items-start">
                                <div class="text-[10px] text-gray-600 max-w-xs">
                                    <p class="font-semibold">Catatan:</p>
                                    <p>Dokumen statistik ini dicetak secara otomatis dari Sistem Informasi Desa (SID) <?= html_escape($desa['nama_desa']) ?>.</p>
                                </div>
                                <div class="text-center min-w-[220px]">
                                    <p><?= html_escape($desa['nama_desa']) ?>, <?= tgl_indo(date('Y-m-d')) ?></p>
                                    <p class="font-bold mt-1"><?= setting('sebutan_kepala_desa') ?: 'Kepala Desa' ?> <?= html_escape($desa['nama_desa']) ?></p>
                                    <div class="h-20"></div>
                                    <p class="font-bold underline uppercase">( <?= html_escape($desa['nama_kepala_desa'] ?? $nama_kepala_desa ?? '..................................') ?> )</p>
                                    <?php if (!empty($desa['nip_kepala_desa']) || !empty($desa['pamong_nip'])): ?>
                                        <p class="text-[10px] text-gray-700">NIP: <?= html_escape($desa['nip_kepala_desa'] ?? $desa['pamong_nip']) ?></p>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>

                        <!-- [INFO FOOTER] -->
                        <div class="p-8 md:p-14 rounded-[3.5rem] bg-slate-900 text-white relative overflow-hidden flex flex-col md:flex-row items-center justify-between gap-8 group print:hidden">
                            <div class="absolute right-0 bottom-0 w-96 h-96 bg-brand-600/10 rounded-full blur-[100px]"></div>
                            
                            <div class="relative z-10 flex flex-col md:flex-row gap-6 items-center text-center md:text-left">
                                <div class="w-20 h-20 rounded-2xl bg-white/10 backdrop-blur-3xl border border-white/20 flex items-center justify-center text-3xl group-hover:rotate-12 transition-all duration-500">
                                    <i class="fa-solid fa-shield-halved text-brand-400"></i>
                                </div>
                                <div class="max-w-md">
                                    <h3 class="font-display font-black text-2xl mb-2 leading-none tracking-tight">Data Terverifikasi & Akurat</h3>
                                    <p class="text-slate-300 text-sm font-medium leading-relaxed">
                                        Pemerintah <?= html_escape($desa['nama_desa']) ?> menyajikan data secara transparan berdasarkan basis data Sistem Informasi Desa (SID) yang diperbarui secara *real-time*.
                                    </p>
                                </div>
                            </div>
                            
                            <div class="relative z-10">
                                <a href="<?= site_url('layanan-mandiri') ?>" class="inline-flex items-center gap-3 px-8 py-4 bg-brand-600 text-white font-black rounded-2xl hover:bg-brand-500 hover:-translate-y-1 transition-all text-center uppercase tracking-widest text-xs shadow-2xl shadow-brand-600/40">
                                    Layanan Mandiri
                                    <i class="fa-solid fa-arrow-right-long"></i>
                                </a>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </section>
    </main>

    <!-- Footer -->
    <div class="print:hidden">
        <?php $this->load->view("$folder_themes/commons/copyleft.php"); ?>
    </div>

    <!-- Back to Top Button -->
    <button id="backToTop" class="fixed bottom-12 right-12 w-16 h-16 bg-brand-600 text-white rounded-[2rem] shadow-2xl shadow-brand-600/40 flex items-center justify-center opacity-0 invisible translate-y-10 transition-all duration-500 hover:bg-brand-900 z-[9999] print:hidden" aria-label="Kembali ke Atas">
        <i class="fa-solid fa-arrow-up text-xl" aria-hidden="true"></i>
    </button>

    <script>
        // Fungsi Penanganan Cetak Statistik
        function cetakStatistik() {
            $('.tr-lebih').removeClass('hide');
            $('#showData').hide();
            setTimeout(function() {
                window.print();
            }, 100);
        }

        $(document).ready(function() {
            // Global Script for Show More Data
            $(document).on('click', '#showData', function(e) {
                e.preventDefault();
                $('.tr-lebih').removeClass('hide');
                $(this).fadeOut(300);
            });

            // Cascading Filter Wilayah: Dusun -> RW -> RT
            var ajaxRwUrl = "<?= site_url('data-statistik/ajax-rw') ?>";
            var ajaxRtUrl = "<?= site_url('data-statistik/ajax-rt') ?>";

            $('#selectDusun').on('change', function() {
                var dusun = $(this).val();
                var $rw = $('#selectRw');
                var $rt = $('#selectRt');

                $rw.html('<option value="">Semua RW</option>').prop('disabled', true);
                $rt.html('<option value="">Semua RT</option>').prop('disabled', true);

                if (dusun) {
                    $.getJSON(ajaxRwUrl, { dusun: dusun }, function(data) {
                        if (data && data.length > 0) {
                            $.each(data, function(i, item) {
                                $rw.append($('<option>', {
                                    value: item.rw,
                                    text: 'RW ' + item.rw
                                }));
                            });
                            $rw.prop('disabled', false);
                        }
                    });
                }
            });

            $('#selectRw').on('change', function() {
                var dusun = $('#selectDusun').val();
                var rw = $(this).val();
                var $rt = $('#selectRt');

                $rt.html('<option value="">Semua RT</option>').prop('disabled', true);

                if (dusun && rw) {
                    $.getJSON(ajaxRtUrl, { dusun: dusun, rw: rw }, function(data) {
                        if (data && data.length > 0) {
                            $.each(data, function(i, item) {
                                $rt.append($('<option>', {
                                    value: item.rt,
                                    text: 'RT ' + item.rt
                                }));
                            });
                            $rt.prop('disabled', false);
                        }
                    });
                }
            });
        });

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
