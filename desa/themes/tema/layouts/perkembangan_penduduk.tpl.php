<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <?php $this->load->view("$folder_themes/commons/meta.php"); ?>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&family=Outfit:wght@700;800;900&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --bg-card: rgba(255, 255, 255, 0.8);
            --bg-header: rgba(248, 250, 252, 0.5);
            --text-main: #1e293b;
            --text-muted: #64748b;
            --border-color: rgba(0, 0, 0, 0.05);
            --table-header: rgba(241, 245, 249, 0.5);
        }

        .dark {
            --bg-card: rgba(15, 23, 42, 0.8);
            --bg-header: rgba(30, 41, 59, 0.5);
            --text-main: #f1f5f9;
            --text-muted: #94a3b8;
            --border-color: rgba(255, 255, 255, 0.05);
            --table-header: rgba(51, 65, 85, 0.5);
        }

        .stat-card { background: var(--bg-card); border: 1px solid var(--border-color); color: var(--text-main); }
        .stat-text { color: var(--text-main); }
        .stat-muted { color: var(--text-muted); }
        .stat-border { border-color: var(--border-color); }
        
        .custom-table-container { 
            margin-top: 48px; 
            background: var(--bg-card); 
            border: 1px solid var(--border-color); 
            border-radius: 40px; 
            overflow: hidden; 
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.1);
            backdrop-filter: blur(20px);
        }
        .custom-table-header { border-bottom: 1px solid var(--border-color); background: var(--bg-header); }
        .custom-table thead tr { background: var(--table-header); color: var(--text-muted); }
        .custom-table th, .custom-table td { padding: 20px 32px; border-bottom: 1px solid var(--border-color); }
        .custom-table tbody tr:hover { background: rgba(0,0,0,0.02); }
        .dark .custom-table tbody tr:hover { background: rgba(255,255,255,0.02); }
    </style>
</head>
<body class="bg-white dark:bg-slate-950 transition-colors duration-300">
    
    <?php $this->load->view("$folder_themes/commons/header.php"); ?>

    <!-- [ PUBLIC POPULATION TRENDS DASHBOARD ] -->
    <div class="min-h-screen flex flex-col">
        <div class="flex-1 relative transition-colors duration-500 pt-32 pb-24 [overflow-x:clip]">
            <!-- Animated Background Gradients -->
            <div class="absolute inset-0 overflow-hidden pointer-events-none">
                <div class="absolute top-0 left-0 w-full h-[500px] bg-gradient-to-b from-brand-50/50 to-transparent dark:from-brand-900/10 pointer-events-none"></div>
                <div class="absolute -right-64 top-20 w-[600px] h-[600px] bg-brand-600/5 rounded-full blur-[120px] animate-pulse"></div>
                <div class="absolute -left-64 bottom-0 w-[600px] h-[600px] bg-accent/5 rounded-full blur-[120px]"></div>
            </div>

            <div class="container mx-auto px-4 max-w-7xl relative z-10">
                <div class="flex flex-col lg:flex-row gap-8 lg:gap-10 items-start">
                    <!-- Sidebar Navigasi Kiri -->
                    <aside class="w-full lg:w-80 lg:flex-shrink-0 lg:sticky lg:top-28 lg:self-start z-20">
                        <?php $this->load->view("$folder_themes/partials/statistik/sidenav.php", [
                            'slug_aktif' => 'perkembangan-penduduk',
                        ]); ?>
                    </aside>

                    <!-- Konten Dashboard Kanan -->
                    <div class="flex-1 min-w-0 w-full space-y-12">
        
                        <!-- [NAVIGATION BREADCRUMB] -->
                        <nav class="flex items-center gap-3 text-xs font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest mb-6">
                            <a href="<?= site_url() ?>" class="hover:text-brand-600 transition-colors">Beranda</a>
                            <i class="fa-solid fa-chevron-right text-[10px] opacity-40"></i>
                            <a href="<?= site_url('data-statistik') ?>" class="hover:text-brand-600 transition-colors">Statistik Desa</a>
                            <i class="fa-solid fa-chevron-right text-[10px] opacity-40"></i>
                            <span class="text-brand-600 dark:text-brand-400 font-extrabold">Perkembangan Penduduk</span>
                        </nav>

                        <!-- Header Section -->
                        <div class="flex flex-col md:flex-row md:items-end justify-between gap-8 mb-12">
            <div class="max-w-3xl">
                <div class="flex items-center gap-3 mb-6">
                    <div class="px-4 py-1.5 rounded-full bg-brand-600/10 text-brand-600 dark:text-brand-400 text-[10px] font-black uppercase tracking-[0.2em] border border-brand-600/20">
                        Demografi Desa
                    </div>
                    <div class="h-px w-12 bg-slate-200 dark:bg-slate-800"></div>
                </div>
                <h1 class="font-display font-black text-4xl md:text-6xl text-slate-900 dark:text-white leading-[1.1] tracking-tight mb-6">
                    Statistik <span class="text-transparent bg-clip-text bg-gradient-to-r from-brand-600 to-accent">Perkembangan</span> Penduduk.
                </h1>
                <p class="text-lg text-slate-500 dark:text-slate-400 max-w-xl leading-relaxed">
                    Visualisasi data pertumbuhan, kelahiran, kematian, dan mutasi penduduk desa secara transparan dan akurat.
                </p>
            </div>

            <!-- Modern Filter Tabs -->
            <div class="flex items-center p-1.5 bg-slate-100/50 dark:bg-slate-900/50 backdrop-blur-xl border border-slate-200/60 dark:border-slate-800/60 rounded-2xl shadow-sm">
                <button onclick="changeRange('5_tahun')" id="btn-5_tahun" class="range-btn px-6 py-3 rounded-xl text-[11px] font-black uppercase tracking-widest transition-all active:scale-95 bg-brand-600 text-white shadow-lg shadow-brand-600/20">5 Tahun</button>
                <button onclick="changeRange('7_tahun')" id="btn-7_tahun" class="range-btn px-6 py-3 rounded-xl text-[11px] font-black uppercase tracking-widest transition-all active:scale-95 text-slate-500 hover:text-brand-600">7 Tahun</button>
                <button onclick="changeRange('10_tahun')" id="btn-10_tahun" class="range-btn px-6 py-3 rounded-xl text-[11px] font-black uppercase tracking-widest transition-all active:scale-95 text-slate-500 hover:text-brand-600">10 Tahun</button>
            </div>
        </div>

        <!-- Main Chart Card -->
        <div class="group relative mb-12">
            <div class="absolute -inset-1 bg-gradient-to-r from-brand-600 to-accent rounded-[3rem] opacity-20 blur-2xl group-hover:opacity-30 transition-opacity duration-500"></div>
            
            <div class="relative bg-white/80 dark:bg-slate-900/80 backdrop-blur-3xl border border-slate-200/50 dark:border-slate-800/50 rounded-[3rem] p-8 md:p-12 shadow-2xl overflow-hidden">
                
                <!-- Chart Controls & Title -->
                <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 mb-12">
                    <div class="flex items-center gap-4">
                        <div class="w-14 h-14 rounded-2xl bg-brand-600 flex items-center justify-center text-white shadow-xl shadow-brand-600/20">
                            <i class="fa-solid fa-chart-line text-2xl"></i>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-slate-900 dark:text-white mb-1">Grafik Tren Kependudukan</h3>
                            <p class="text-xs text-slate-500 font-medium uppercase tracking-widest" id="chart-subtitle">Periode 5 Tahun Terakhir</p>
                        </div>
                    </div>
                </div>

                <!-- Highcharts Container -->
                <div id="main-chart" class="w-full h-[450px]">
                    <div class="flex flex-col items-center justify-center h-full gap-4 text-slate-300">
                        <i class="fa-solid fa-circle-notch fa-spin text-4xl text-brand-600"></i>
                        <span class="text-xs font-black uppercase tracking-[0.3em]">Menganalisis Data...</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- KPI Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            
            <!-- KPI: Penduduk Datang -->
            <div class="p-8 rounded-[2rem] bg-[#f8fafc] dark:bg-slate-900 border border-slate-100 dark:border-slate-800/60 hover:shadow-xl transition-all duration-500 group/kpi">
                <div class="flex items-center justify-between mb-6">
                    <div class="w-12 h-12 rounded-xl bg-brand-100 dark:bg-brand-900/30 text-brand-600 flex items-center justify-center text-xl transition-transform group-hover/kpi:rotate-12">
                        <i class="fa-solid fa-truck-moving"></i>
                    </div>
                    <span class="text-[9px] font-black text-slate-400 uppercase tracking-widest">Migrasi</span>
                </div>
                <div class="text-3xl font-display font-black text-slate-900 dark:text-white mb-2" id="kpi-datang">-</div>
                <div class="text-[10px] font-bold text-slate-500 uppercase tracking-wider">Penduduk Datang</div>
            </div>

            <!-- KPI: Kelahiran -->
            <div class="p-8 rounded-[2rem] bg-[#f8fafc] dark:bg-slate-900 border border-slate-100 dark:border-slate-800/60 hover:shadow-xl transition-all duration-500 group/kpi">
                <div class="flex items-center justify-between mb-6">
                    <div class="w-12 h-12 rounded-xl bg-emerald-100 dark:bg-emerald-900/30 text-emerald-600 flex items-center justify-center text-xl transition-transform group-hover/kpi:rotate-12">
                        <i class="fa-solid fa-baby"></i>
                    </div>
                    <span class="text-[9px] font-black text-slate-400 uppercase tracking-widest">Kelahiran</span>
                </div>
                <div class="text-3xl font-display font-black text-slate-900 dark:text-white mb-2" id="kpi-lahir">-</div>
                <div class="text-[10px] font-bold text-slate-500 uppercase tracking-wider">Total Bayi Lahir</div>
            </div>

            <!-- KPI: Kematian -->
            <div class="p-8 rounded-[2rem] bg-[#f8fafc] dark:bg-slate-900 border border-slate-100 dark:border-slate-800/60 hover:shadow-xl transition-all duration-500 group/kpi">
                <div class="flex items-center justify-between mb-6">
                    <div class="w-12 h-12 rounded-xl bg-rose-100 dark:bg-rose-900/30 text-rose-600 flex items-center justify-center text-xl transition-transform group-hover/kpi:rotate-12">
                        <i class="fa-solid fa-heart-pulse"></i>
                    </div>
                    <span class="text-[9px] font-black text-slate-400 uppercase tracking-widest">Kematian</span>
                </div>
                <div class="text-3xl font-display font-black text-slate-900 dark:text-white mb-2" id="kpi-mati">-</div>
                <div class="text-[10px] font-bold text-slate-500 uppercase tracking-wider">Total Meninggal</div>
            </div>

            <!-- KPI: Penduduk Pergi -->
            <div class="p-8 rounded-[2rem] bg-[#f8fafc] dark:bg-slate-900 border border-slate-100 dark:border-slate-800/60 hover:shadow-xl transition-all duration-500 group/kpi">
                <div class="flex items-center justify-between mb-6">
                    <div class="w-12 h-12 rounded-xl bg-amber-100 dark:bg-amber-900/30 text-amber-600 flex items-center justify-center text-xl transition-transform group-hover/kpi:rotate-12">
                        <i class="fa-solid fa-person-walking-arrow-right"></i>
                    </div>
                    <span class="text-[9px] font-black text-slate-400 uppercase tracking-widest">Mutasi</span>
                </div>
                <div class="text-3xl font-display font-black text-slate-900 dark:text-white mb-2" id="kpi-pergi">-</div>
                <div class="text-[10px] font-bold text-slate-500 uppercase tracking-wider">Penduduk Pergi</div>
            </div>

        </div>
        
        <!-- Data Table Section -->
        <div class="custom-table-container">
            <div class="custom-table-header p-10">
                <div class="flex flex-col md:flex-row md:items-center gap-6">
                    <div class="w-16 h-16 rounded-2xl bg-slate-900 dark:bg-brand-600 text-white flex items-center justify-center text-2xl shadow-2xl shadow-slate-900/20 dark:shadow-brand-600/20 shrink-0">
                        <i class="fa-solid fa-list-check"></i>
                    </div>
                    <div class="flex flex-col">
                        <h3 class="font-display font-black text-2xl text-slate-900 dark:text-white tracking-tight leading-none">Data Tabulasi Perkembangan</h3>
                        <p class="text-[10px] font-bold text-slate-500 uppercase tracking-[0.2em] mt-3">Laporan rincian pertumbuhan penduduk per tahun</p>
                    </div>
                </div>
            </div>
            <div style="overflow-x: auto;">
                <table class="custom-table" style="width: 100%; text-align: center; border-collapse: collapse;">
                    <thead>
                        <tr style="font-size: 10px; font-weight: 900; text-transform: uppercase; letter-spacing: 0.2em;">
                            <th style="text-align: center;">Tahun</th>
                            <th style="text-align: center;">Penduduk Datang</th>
                            <th style="text-align: center;">Kelahiran</th>
                            <th style="text-align: center;">Kematian</th>
                            <th style="text-align: center;">Penduduk Pergi</th>
                            <th style="text-align: center;">Total Perubahan</th>
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
        <?php $this->load->view("$folder_themes/commons/copyleft.php"); ?>
    </div>

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
    $('.range-btn').removeClass('bg-brand-600 text-white shadow-lg shadow-brand-600/20').addClass('text-slate-500 hover:text-brand-600');
    $(`#btn-${range}`).addClass('bg-brand-600 text-white shadow-lg shadow-brand-600/20').removeClass('text-slate-500 hover:text-brand-600');
    
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
                const growthColor = growth > 0 ? '#10b981' : (growth < 0 ? '#f43f5e' : 'var(--text-muted)');
                
                tableHtml += `
                    <tr>
                        <td style="font-weight: 800; color: var(--text-main); text-align: center;">${data.categories[i]}</td>
                        <td style="color: var(--text-muted); font-size: 14px; text-align: center;">${data.pindah_datang[i].toLocaleString('id-ID')}</td>
                        <td style="color: var(--text-muted); font-size: 14px; text-align: center;">${data.kelahiran[i].toLocaleString('id-ID')}</td>
                        <td style="color: var(--text-muted); font-size: 14px; text-align: center;">${data.kematian[i].toLocaleString('id-ID')}</td>
                        <td style="color: var(--text-muted); font-size: 14px; text-align: center;">${data.pindah_pergi[i].toLocaleString('id-ID')}</td>
                        <td style="text-align: center; font-weight: 900; color: ${growthColor};">
                            ${growth > 0 ? '+' : ''}${growth.toLocaleString('id-ID')}
                        </td>
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
                exporting: { enabled: false }, // Disable default Highcharts table/menu
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
