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
        <section class="py-12 md:py-24 bg-slate-50/50 dark:bg-slate-900/40">
            <div class="container mx-auto px-4">
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-16">
                    
                    <!-- [LEFT SIDE: MAIN CONTENT] -->
                    <div class="lg:col-span-8">
                        
                        <!-- [NAVIGATION BREADCRUMB] -->
                        <nav class="flex items-center gap-3 text-xs font-bold text-slate-400 uppercase tracking-widest mb-10">
                            <a href="<?= site_url() ?>" class="hover:text-brand-600 transition-colors">Beranda</a>
                            <i class="fa-solid fa-chevron-right text-[10px] opacity-40"></i>
                            <span class="text-slate-600 dark:text-slate-300">Data Analisis</span>
                        </nav>

                        <!-- [HEADER] -->
                        <header class="mb-16">
                            <div class="flex items-center gap-2 mb-4 text-brand-600 font-bold tracking-[0.2em] uppercase text-[10px]">
                                <span class="w-8 h-px bg-brand-600"></span>
                                Strategic Insight
                            </div>
                            <h1 class="font-display font-[800] text-4xl md:text-6xl text-slate-900 dark:text-white leading-[1.1] tracking-tight mb-6">
                                Hasil <span class="text-transparent bg-clip-text bg-gradient-to-r from-brand-600 to-accent">Analisis</span> Desa.
                            </h1>
                            <p class="text-slate-500 dark:text-slate-400 font-medium max-w-2xl leading-relaxed italic">
                                Transparansi data melalui pemetaan indikator strategis untuk perencanaan pembangunan yang lebih terukur.
                            </p>
                        </header>

                        <!-- [ANALYSIS DYNAMIC AREA] -->
                        <div class="space-y-12">
                            
                            <?php if ($list_indikator): ?>
                                <!-- [1. INDIKATOR LIST VIEW] -->
                                <div class="bg-white dark:bg-slate-900 rounded-[3rem] border border-slate-100 dark:border-slate-800 shadow-2xl shadow-brand-900/5 overflow-hidden">
                                    <div class="p-8 md:p-12 border-b border-slate-50 dark:border-slate-800 bg-slate-50/50 dark:bg-slate-800/30">
                                        <h3 class="font-display font-black text-2xl text-slate-900 dark:text-white flex items-center gap-4">
                                            <i class="fa-solid fa-chart-line text-brand-500"></i>
                                            Daftar Indikator
                                        </h3>
                                    </div>
                                    <div class="p-4 md:p-8">
                                        <div class="overflow-x-auto">
                                            <table class="w-full text-sm">
                                                <thead>
                                                    <tr class="text-left py-6 border-b border-slate-100 dark:border-slate-800 text-slate-400 uppercase tracking-widest text-[10px] font-black">
                                                        <th class="px-6 py-6 w-16">No</th>
                                                        <th class="px-6 py-6">Indikator</th>
                                                        <th class="px-6 py-6 text-right">Aksi</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="divide-y divide-slate-50 dark:divide-slate-800/50">
                                                    <?php foreach ($list_indikator as $key => $data): ?>
                                                        <tr class="group hover:bg-slate-50 dark:hover:bg-slate-800/40 transition-colors">
                                                            <td class="px-6 py-6 font-display font-black text-slate-300 dark:text-slate-700"><?= $key + 1 ?></td>
                                                            <td class="px-6 py-6">
                                                                <span class="text-slate-700 dark:text-slate-200 font-bold leading-relaxed block group-hover:text-brand-600 transition-colors">
                                                                    <?= $data['pertanyaan'] ?>
                                                                </span>
                                                                <span class="text-[9px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest mt-1 block">ID: ANALISIS-<?= $data['id'] ?></span>
                                                            </td>
                                                            <td class="px-6 py-6 text-right">
                                                                <a href="<?= site_url("jawaban_analisis/{$data['id']}/{$data['id_pilihan']}/{$data['id_periode']}") ?>" class="inline-flex items-center gap-2 px-6 py-3 rounded-xl bg-brand-600 text-white font-bold text-[10px] uppercase tracking-widest hover:bg-brand-900 hover:scale-105 transition-all shadow-lg shadow-brand-600/20">
                                                                    Lihat Grafik
                                                                </a>
                                                            </td>
                                                        </tr>
                                                    <?php endforeach; ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                            <?php elseif ($list_jawab): ?>
                                <!-- [2. CHART & DETAILS VIEW] -->
                                <div class="space-y-8">
                                    <!-- Back Button -->
                                    <a href="<?= site_url('data_analisis') ?>" class="inline-flex items-center gap-3 text-xs font-black text-slate-500 hover:text-brand-600 transition-colors uppercase tracking-widest">
                                        <i class="fa-solid fa-arrow-left"></i>
                                        Kembali ke Daftar
                                    </a>

                                    <!-- Chart Container -->
                                    <div class="bg-white dark:bg-slate-900 rounded-[3rem] p-8 md:p-12 border border-slate-100 dark:border-slate-800 shadow-2xl shadow-brand-900/5 overflow-hidden relative">
                                        <div class="relative z-10">
                                            <div class="flex items-center gap-2 mb-4 text-brand-600 font-bold tracking-[0.2em] uppercase text-[10px]">
                                                Data Visualisasi
                                            </div>
                                            <h3 class="font-display font-black text-3xl text-slate-900 dark:text-white tracking-tight mb-12 italic">
                                                "<?= $indikator['pertanyaan'] ?>"
                                            </h3>

                                            <div id="chart-container" class="w-full h-[450px]"></div>
                                        </div>
                                    </div>

                                    <!-- Data Table Detail -->
                                    <div class="bg-white dark:bg-slate-900 rounded-[3rem] border border-slate-100 dark:border-slate-800 shadow-2xl shadow-brand-900/5 overflow-hidden">
                                        <div class="p-8 md:p-12 border-b border-slate-50 dark:border-slate-800 bg-slate-50/50 dark:bg-slate-800/30">
                                            <h3 class="font-display font-black text-2xl text-slate-900 dark:text-white flex items-center gap-4">
                                                <i class="fa-solid fa-table-list text-brand-500"></i>
                                                Rincian Jawaban
                                            </h3>
                                        </div>
                                        <div class="p-4 md:p-8">
                                            <div class="overflow-x-auto">
                                                <table class="w-full text-sm">
                                                    <thead>
                                                        <tr class="text-left py-6 border-b border-slate-100 dark:border-slate-800 text-slate-400 uppercase tracking-widest text-[10px] font-black">
                                                            <th class="px-6 py-6">Jawaban</th>
                                                            <th class="px-6 py-6 text-center w-32">Jumlah</th>
                                                            <th class="px-6 py-6 text-right w-32">Persentase</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="divide-y divide-slate-50 dark:divide-slate-800/50">
                                                        <?php foreach ($list_jawab as $data): ?>
                                                            <tr class="group hover:bg-slate-50 dark:hover:bg-slate-800/40 transition-colors">
                                                                <td class="px-6 py-6">
                                                                    <div class="flex items-center gap-4">
                                                                        <div class="w-2 h-2 rounded-full bg-brand-500"></div>
                                                                        <span class="text-slate-700 dark:text-slate-200 font-bold"><?= $data['jawaban'] ?></span>
                                                                    </div>
                                                                </td>
                                                                <td class="px-6 py-6 text-center font-display font-black text-slate-900 dark:text-white"><?= $data['nilai'] ?></td>
                                                                <td class="px-6 py-6 text-right">
                                                                    <span class="px-4 py-2 rounded-xl bg-brand-50 dark:bg-brand-900/30 text-brand-600 dark:text-brand-400 font-black text-xs">
                                                                        <?= $data['persen'] ?>%
                                                                    </span>
                                                                </td>
                                                            </tr>
                                                        <?php endforeach; ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Chart Scripts (Localized) -->
                                <script src="<?= base_url($folder_themes . '/assets/js/highcharts.js') ?>"></script>
                                <script src="<?= base_url($folder_themes . '/assets/js/exporting.js') ?>"></script>
                                <script src="<?= base_url($folder_themes . '/assets/js/accessibility.js') ?>"></script>
                                <script>
                                    document.addEventListener('DOMContentLoaded', function() {
                                        const isDark = document.documentElement.classList.contains('dark');
                                        
                                        Highcharts.chart('chart-container', {
                                            chart: {
                                                type: 'column',
                                                backgroundColor: 'transparent',
                                                style: { fontFamily: 'Outfit, sans-serif' }
                                            },
                                            title: { text: null },
                                            accessibility: { enabled: false },
                                            xAxis: {
                                                categories: [<?php foreach ($list_jawab as $data): ?>'<?= $data['jawaban'] ?>',<?php endforeach; ?>],
                                                labels: { style: { color: isDark ? '#94a3b8' : '#64748b', fontWeight: 'bold' } },
                                                lineColor: isDark ? '#1e293b' : '#f1f5f9'
                                            },
                                            yAxis: {
                                                title: { text: 'Jumlah (Jiwa)', style: { color: isDark ? '#475569' : '#94a3b8' } },
                                                gridLineColor: isDark ? '#1e293b' : '#f1f5f9',
                                                labels: { style: { color: isDark ? '#94a3b8' : '#64748b' } }
                                            },
                                            plotOptions: {
                                                column: {
                                                    borderRadius: 12,
                                                    color: '#3b82f6',
                                                    dataLabels: {
                                                        enabled: true,
                                                        color: isDark ? '#fff' : '#000',
                                                        style: { fontWeight: '900', textOutline: 'none' }
                                                    }
                                                }
                                            },
                                            series: [{
                                                name: 'Jumlah',
                                                data: [<?php foreach ($list_jawab as $data): ?><?= $data['nilai'] ?>,<?php endforeach; ?>],
                                                showInLegend: false
                                            }],
                                            credits: { enabled: false }
                                        });
                                    });
                                </script>

                            <?php else: ?>
                                <!-- [3. EMPTY / DEFAULT SELECTION VIEW] -->
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                                    <?php foreach ($master_indikator as $master): ?>
                                        <a href="<?= site_url("data_analisis?master={$master['id']}") ?>" class="group p-10 rounded-[3.5rem] bg-white dark:bg-slate-900 border border-slate-100 dark:border-slate-800 shadow-xl hover:shadow-2xl hover:shadow-brand-600/10 hover:-translate-y-2 transition-all duration-500 overflow-hidden relative">
                                            <div class="absolute top-0 right-0 w-40 h-40 bg-brand-500/5 rounded-full -mr-20 -mt-20 group-hover:scale-150 transition-transform duration-700"></div>
                                            
                                            <div class="w-20 h-20 rounded-[2rem] bg-brand-50 dark:bg-brand-900/40 text-brand-600 flex items-center justify-center text-4xl mb-8 group-hover:rotate-12 transition-transform">
                                                <i class="fa-solid fa-layer-group"></i>
                                            </div>
                                            
                                            <h4 class="font-display font-[900] text-2xl text-slate-900 dark:text-white leading-tight mb-4 group-hover:text-brand-600 transition-colors">
                                                <?= $master['nama'] ?>
                                            </h4>
                                            
                                            <div class="flex items-center gap-3 text-[10px] font-black text-slate-400 uppercase tracking-widest">
                                                <span>Lihat Analisis</span>
                                                <i class="fa-solid fa-arrow-right-long group-hover:translate-x-2 transition-transform"></i>
                                            </div>
                                        </a>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>

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

    <script src="<?= base_url($folder_themes . '/assets/js/app.js') ?>"></script>

    <!-- AOS (Animate On Scroll) Logic -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

</body>
</html>
