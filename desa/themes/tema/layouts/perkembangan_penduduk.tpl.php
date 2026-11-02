<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <?php $this->load->view("$folder_themes/commons/meta.php"); ?>
    
    <style>
        .stat-table-box table th {
            padding: 16px 20px;
            font-size: 11px;
            font-weight: 900;
            text-transform: uppercase;
            letter-spacing: 0.15em;
            color: #64748b;
            border-bottom: 1px solid rgba(0, 0, 0, 0.06);
            background: rgba(248, 250, 252, 0.5);
            text-align: center;
        }
        .dark .stat-table-box table th {
            color: #94a3b8;
            border-bottom: 1px solid rgba(255, 255, 255, 0.06);
            background: rgba(30, 41, 59, 0.5);
        }
        .stat-table-box table td {
            padding: 18px 20px;
            border-bottom: 1px solid rgba(0, 0, 0, 0.04);
            text-align: center;
        }
        .dark .stat-table-box table td {
            border-bottom: 1px solid rgba(255, 255, 255, 0.04);
        }
        .stat-table-box table tbody tr:hover {
            background: rgba(0, 0, 0, 0.015);
        }
        .dark .stat-table-box table tbody tr:hover {
            background: rgba(255, 255, 255, 0.02);
        }
    </style>
</head>
<body class="bg-white dark:bg-slate-950 font-sans text-slate-900 dark:text-slate-100 selection:bg-brand-100 dark:selection:bg-brand-900 selection:text-brand-900 dark:selection:text-brand-100 transition-colors duration-300 overflow-x-hidden">
    
    <!-- Navbar (Fixed) -->
    <?php $this->load->view("$folder_themes/commons/header.php"); ?>

    <div class="h-24 md:h-32"></div>

    <main class="min-h-screen animate-premium">
        <section class="py-8 md:py-16 bg-slate-50/50 dark:bg-slate-950">
            <div class="container mx-auto px-4 max-w-7xl">
                
                <!-- [TWO COLUMN GRID: SIDEBAR KIRI + KONTEN KANAN] -->
                <div class="flex flex-col-reverse lg:flex-row gap-8 lg:gap-10 items-start">
                    
                    <!-- [SIDEBAR KIRI: DAFTAR STATISTIK] -->
                    <aside class="w-full lg:w-80 lg:flex-shrink-0 lg:sticky lg:top-28 lg:self-start z-20 print:hidden">
                        <?php $this->load->view("$folder_themes/partials/statistik/sidenav.php", [
                            'slug_aktif' => 'perkembangan-penduduk',
                        ]); ?>
                    </aside>

                    <!-- [KONTEN UTAMA KANAN: GRAFIK & TABEL] -->
                    <div class="flex-1 min-w-0 w-full space-y-12">
        
                        <!-- [NAVIGATION BREADCRUMB] -->
                        <nav class="flex flex-wrap items-center gap-2 md:gap-3 text-xs font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest mb-6">
                            <a href="<?= site_url() ?>" class="hover:text-brand-600 transition-colors">Beranda</a>
                            <i class="fa-solid fa-chevron-right text-[10px] opacity-40"></i>
                            <a href="<?= site_url('data-statistik') ?>" class="hover:text-brand-600 transition-colors">Statistik Desa</a>
                            <i class="fa-solid fa-chevron-right text-[10px] opacity-40"></i>
                            <span class="text-brand-600 dark:text-brand-400 font-extrabold">Perkembangan Penduduk</span>
                        </nav>

                        <!-- Header Section -->
                        <header class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-8">
                            <div class="max-w-3xl">
                                <div class="flex items-center gap-3 mb-3">
                                    <span class="w-10 h-1 bg-brand-600 rounded-full"></span>
                                    <span class="text-brand-700 dark:text-brand-400 font-black tracking-[0.25em] uppercase text-xs">Demografi Desa</span>
                                </div>
                                <h1 class="premium-h1 text-3xl md:text-5xl mb-3">
                                    Statistik <span class="text-transparent bg-clip-text bg-gradient-to-r from-brand-600 to-emerald-500">Perkembangan</span> Penduduk.
                                </h1>
                                <p class="premium-p text-base md:text-lg text-slate-500 dark:text-slate-400 max-w-xl leading-relaxed">
                                    Visualisasi data pertumbuhan, kelahiran, kematian, dan mutasi penduduk desa secara transparan dan akurat.
                                </p>
                            </div>

                            <!-- Modern Filter Tabs -->
                            <div class="flex items-center p-1.5 bg-white dark:bg-slate-900 border border-slate-200/80 dark:border-slate-800 rounded-2xl shadow-sm self-start md:self-end">
                                <button onclick="changeRange('5_tahun')" id="btn-5_tahun" class="range-btn px-5 py-2.5 rounded-xl text-xs font-black uppercase tracking-wider transition-all active:scale-95 bg-brand-600 text-white shadow-md shadow-brand-600/20">5 Tahun</button>
                                <button onclick="changeRange('7_tahun')" id="btn-7_tahun" class="range-btn px-5 py-2.5 rounded-xl text-xs font-black uppercase tracking-wider transition-all active:scale-95 text-slate-500 hover:text-brand-600">7 Tahun</button>
                                <button onclick="changeRange('10_tahun')" id="btn-10_tahun" class="range-btn px-5 py-2.5 rounded-xl text-xs font-black uppercase tracking-wider transition-all active:scale-95 text-slate-500 hover:text-brand-600">10 Tahun</button>
                            </div>
                        </header>

                        <!-- [CHART CONTAINER] -->
                        <div>
                            <div class="p-6 md:p-12 rounded-[3.5rem] bg-white dark:bg-slate-800/50 border border-slate-100 dark:border-slate-800 shadow-2xl shadow-slate-200/40 dark:shadow-none relative overflow-hidden group">
                                <div class="absolute -right-32 -top-32 w-80 h-80 bg-brand-600/5 dark:bg-brand-600/10 rounded-full blur-[100px] pointer-events-none"></div>
                                
                                <div class="flex items-center gap-4 mb-8 relative z-10">
                                    <div class="w-12 h-12 rounded-2xl bg-brand-600 flex items-center justify-center text-white shadow-lg shadow-brand-600/20">
                                        <i class="fa-solid fa-chart-line text-xl"></i>
                                    </div>
                                    <div>
                                        <h3 class="text-lg font-bold text-slate-900 dark:text-white leading-tight">Grafik Tren Kependudukan</h3>
                                        <p class="text-xs text-slate-500 font-medium uppercase tracking-widest mt-1" id="chart-subtitle">Periode 5 Tahun Terakhir</p>
                                    </div>
                                </div>

                                <!-- Highcharts Container -->
                                <div id="main-chart" class="w-full h-[450px] relative z-10">
                                    <div class="flex flex-col items-center justify-center h-full gap-4 text-slate-300">
                                        <i class="fa-solid fa-circle-notch fa-spin text-4xl text-brand-600"></i>
                                        <span class="text-xs font-black uppercase tracking-[0.3em]">Menganalisis Data...</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- [KPI GRID] -->
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                            
                            <!-- KPI: Penduduk Datang -->
                            <div class="p-6 md:p-8 rounded-[2.5rem] bg-white dark:bg-slate-900 border border-slate-100 dark:border-slate-800 shadow-xl shadow-slate-200/40 dark:shadow-none transition-all duration-300 group/kpi">
                                <div class="flex items-center justify-between mb-4">
                                    <div class="w-12 h-12 rounded-xl bg-brand-100 dark:bg-brand-900/30 text-brand-600 flex items-center justify-center text-xl transition-transform group-hover/kpi:rotate-12">
                                        <i class="fa-solid fa-truck-moving"></i>
                                    </div>
                                    <span class="text-[11px] font-black text-slate-400 uppercase tracking-widest">Migrasi</span>
                                </div>
                                <div class="text-3xl font-display font-black text-slate-900 dark:text-white mb-1" id="kpi-datang">-</div>
                                <div class="text-xs font-bold text-slate-500 uppercase tracking-wider">Penduduk Datang</div>
                            </div>

                            <!-- KPI: Kelahiran -->
                            <div class="p-6 md:p-8 rounded-[2.5rem] bg-white dark:bg-slate-900 border border-slate-100 dark:border-slate-800 shadow-xl shadow-slate-200/40 dark:shadow-none transition-all duration-300 group/kpi">
                                <div class="flex items-center justify-between mb-4">
                                    <div class="w-12 h-12 rounded-xl bg-emerald-100 dark:bg-emerald-900/30 text-emerald-600 flex items-center justify-center text-xl transition-transform group-hover/kpi:rotate-12">
                                        <i class="fa-solid fa-baby"></i>
                                    </div>
                                    <span class="text-[11px] font-black text-slate-400 uppercase tracking-widest">Kelahiran</span>
                                </div>
                                <div class="text-3xl font-display font-black text-slate-900 dark:text-white mb-1" id="kpi-lahir">-</div>
                                <div class="text-xs font-bold text-slate-500 uppercase tracking-wider">Total Bayi Lahir</div>
                            </div>

                            <!-- KPI: Kematian -->
                            <div class="p-6 md:p-8 rounded-[2.5rem] bg-white dark:bg-slate-900 border border-slate-100 dark:border-slate-800 shadow-xl shadow-slate-200/40 dark:shadow-none transition-all duration-300 group/kpi">
                                <div class="flex items-center justify-between mb-4">
                                    <div class="w-12 h-12 rounded-xl bg-rose-100 dark:bg-rose-900/30 text-rose-600 flex items-center justify-center text-xl transition-transform group-hover/kpi:rotate-12">
                                        <i class="fa-solid fa-heart-pulse"></i>
                                    </div>
                                    <span class="text-[11px] font-black text-slate-400 uppercase tracking-widest">Kematian</span>
                                </div>
                                <div class="text-3xl font-display font-black text-slate-900 dark:text-white mb-1" id="kpi-mati">-</div>
                                <div class="text-xs font-bold text-slate-500 uppercase tracking-wider">Total Meninggal</div>
                            </div>

                            <!-- KPI: Penduduk Pergi -->
                            <div class="p-6 md:p-8 rounded-[2.5rem] bg-white dark:bg-slate-900 border border-slate-100 dark:border-slate-800 shadow-xl shadow-slate-200/40 dark:shadow-none transition-all duration-300 group/kpi">
                                <div class="flex items-center justify-between mb-4">
                                    <div class="w-12 h-12 rounded-xl bg-amber-100 dark:bg-amber-900/30 text-amber-600 flex items-center justify-center text-xl transition-transform group-hover/kpi:rotate-12">
                                        <i class="fa-solid fa-person-walking-arrow-right"></i>
                                    </div>
                                    <span class="text-[11px] font-black text-slate-400 uppercase tracking-widest">Mutasi</span>
                                </div>
                                <div class="text-3xl font-display font-black text-slate-900 dark:text-white mb-1" id="kpi-pergi">-</div>
                                <div class="text-xs font-bold text-slate-500 uppercase tracking-wider">Penduduk Pergi</div>
                            </div>

                        </div>
                        
                        <!-- [TABEL DATA: DATA TABULASI PERKEMBANGAN] -->
                        <div class="space-y-6">
                            <div class="flex items-center gap-6 px-2">
                                <h2 class="font-display font-black text-2xl md:text-3xl text-slate-900 dark:text-white flex items-center gap-3">
                                    Data Tabulasi <span class="text-brand-600 italic">Perkembangan</span>.
                                </h2>
                                <div class="flex-1 h-px bg-slate-200/80 dark:bg-slate-800"></div>
                            </div>

                            <div class="p-4 md:p-8 rounded-[3.5rem] bg-white dark:bg-slate-900/40 backdrop-blur-md border border-slate-100 dark:border-slate-800 shadow-2xl shadow-slate-200/40 dark:shadow-none relative overflow-hidden">
                                <div id="table-only" class="stat-rendered stat-table-box relative z-10 w-full overflow-x-auto">
                                    <table class="table-auto w-full text-center border-collapse">
                                        <thead>
                                            <tr>
                                                <th>Tahun</th>
                                                <th>Penduduk Datang</th>
                                                <th>Penduduk Pergi</th>
                                                <th>Kelahiran</th>
                                                <th>Kematian</th>
                                                <th>Total Perubahan</th>
                                                <th>Total Penduduk</th>
                                            </tr>
                                        </thead>
                                        <tbody id="table-body">
                                            <!-- Data will be injected via JS -->
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </section>
    </main>

    <!-- Footer -->
    <?php $this->load->view("$folder_themes/commons/copyleft.php"); ?>

    <!-- Back to Top Button -->
    <button id="backToTop" class="fixed bottom-5 right-5 md:bottom-8 md:right-8 w-12 h-12 md:w-14 md:h-14 bg-brand-600 text-white rounded-2xl shadow-2xl shadow-brand-600/40 flex items-center justify-center opacity-0 invisible translate-y-10 transition-all duration-500 hover:bg-brand-900 z-50" aria-label="Kembali ke Atas">
        <i class="fa-solid fa-arrow-up" aria-hidden="true"></i>
    </button>

<script src="<?= base_url($folder_themes . '/assets/js/app.js') ?>"></script>
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>

<script>
let currentRange = '5_tahun';

function changeRange(range) {
    currentRange = range;
    
    // UI Update
    $('.range-btn').removeClass('bg-brand-600 text-white shadow-md shadow-brand-600/20').addClass('text-slate-500 hover:text-brand-600');
    $(`#btn-${range}`).addClass('bg-brand-600 text-white shadow-md shadow-brand-600/20').removeClass('text-slate-500 hover:text-brand-600');
    
    const years = range.split('_')[0];
    $('#chart-subtitle').text(`Periode ${years} Tahun Terakhir`);
    
    loadData(range);
}

function loadData(range) {
    const isDark = document.documentElement.classList.contains('dark');
    const gridColor = isDark ? 'rgba(255,255,255,0.05)' : 'rgba(0,0,0,0.05)';
    const textColor = isDark ? '#94a3b8' : '#64748b';

    $.ajax({
        url: "<?= site_url('first/grafik_kependudukan') ?>",
        data: { tahun: range },
        dataType: 'json',
        success: function(data) {
            if (!data || data.error || !data.total_penduduk) {
                $('#main-chart').html('<div class="flex flex-col items-center justify-center h-full gap-4 text-slate-400"><i class="fa-solid fa-circle-exclamation text-4xl"></i><span class="text-xs font-black uppercase tracking-[0.3em]">Data Tidak Tersedia</span></div>');
                return;
            }

            // Update KPIs
            $('#kpi-datang').text(data.pindah_datang.reduce((a, b) => a + b, 0).toLocaleString('id-ID'));
            $('#kpi-lahir').text(data.kelahiran.reduce((a, b) => a + b, 0).toLocaleString('id-ID'));
            $('#kpi-mati').text(data.kematian.reduce((a, b) => a + b, 0).toLocaleString('id-ID'));
            $('#kpi-pergi').text(data.pindah_pergi.reduce((a, b) => a + b, 0).toLocaleString('id-ID'));

            // Update Table
            let tableHtml = '';
            for (let i = data.categories.length - 1; i >= 0; i--) {
                const growth = (data.pindah_datang[i] + data.kelahiran[i]) - (data.pindah_pergi[i] + data.kematian[i]);
                const growthColor = growth > 0 ? '#10b981' : (growth < 0 ? '#f43f5e' : '#64748b');
                const totalPenduduk = (data.total_penduduk && data.total_penduduk[i] !== undefined)
                    ? Number(data.total_penduduk[i]).toLocaleString('id-ID')
                    : '-';
                
                tableHtml += `
                    <tr>
                        <td style="font-weight: 800; font-size: 14px;">${data.categories[i]}</td>
                        <td style="font-size: 14px;">${data.pindah_datang[i].toLocaleString('id-ID')}</td>
                        <td style="font-size: 14px;">${data.pindah_pergi[i].toLocaleString('id-ID')}</td>
                        <td style="font-size: 14px;">${data.kelahiran[i].toLocaleString('id-ID')}</td>
                        <td style="font-size: 14px;">${data.kematian[i].toLocaleString('id-ID')}</td>
                        <td style="font-weight: 900; color: ${growthColor}; font-size: 14px;">
                            ${growth > 0 ? '+' : ''}${growth.toLocaleString('id-ID')}
                        </td>
                        <td style="font-weight: 800; font-size: 14px;">${totalPenduduk}</td>
                    </tr>
                `;
            }
            $('#table-body').html(tableHtml);

            Highcharts.chart('main-chart', {
                chart: {
                    type: 'areaspline',
                    backgroundColor: 'transparent',
                    style: { fontFamily: 'Inter, sans-serif' }
                },
                title: { text: null },
                exporting: { enabled: false },
                xAxis: {
                    categories: data.categories,
                    gridLineWidth: 0,
                    lineColor: gridColor,
                    labels: { style: { color: textColor, fontWeight: 'bold' } }
                },
                yAxis: {
                    title: { text: null },
                    gridLineColor: gridColor,
                    labels: { style: { color: textColor } }
                },
                legend: {
                    itemStyle: { color: textColor, fontWeight: 'bold', fontSize: '11px' },
                    verticalAlign: 'top',
                    align: 'right'
                },
                tooltip: {
                    shared: true,
                    backgroundColor: isDark ? '#1e293b' : '#ffffff',
                    borderColor: '#3b82f6',
                    borderRadius: 16,
                    style: { color: isDark ? '#f1f5f9' : '#1e293b' }
                },
                plotOptions: {
                    areaspline: {
                        fillOpacity: 0.1,
                        lineWidth: 3,
                        marker: {
                            radius: 5,
                            symbol: 'circle',
                            lineWidth: 2,
                            lineColor: '#fff'
                        }
                    }
                },
                series: [{
                    name: 'Penduduk Datang',
                    data: data.pindah_datang,
                    color: '#3b82f6'
                }, {
                    name: 'Kelahiran',
                    data: data.kelahiran,
                    color: '#10b981'
                }, {
                    name: 'Kematian',
                    data: data.kematian,
                    color: '#f43f5e'
                }, {
                    name: 'Penduduk Pergi',
                    data: data.pindah_pergi,
                    color: '#f59e0b'
                }]
            });
        },
        error: function() {
            $('#main-chart').html('<div class="flex flex-col items-center justify-center h-full gap-4 text-rose-400"><i class="fa-solid fa-triangle-exclamation text-4xl"></i><span class="text-xs font-black uppercase tracking-[0.3em]">Gagal Menghubungkan Server</span></div>');
        }
    });
}

$(document).ready(function() {
    loadData('5_tahun');
});
</script>

</body>
</html>
