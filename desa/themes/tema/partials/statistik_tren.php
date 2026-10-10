<?php if(!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<script src="https://code.highcharts.com/highcharts.js"></script>

<section class="py-24 bg-slate-50 dark:bg-slate-900/50 relative overflow-hidden transition-colors duration-500">
    
    <!-- Background Decor -->
    <div class="absolute -left-64 top-0 w-[500px] h-[500px] bg-brand-600/5 rounded-full blur-[100px]"></div>
    
    <div class="container mx-auto px-4 relative z-10">
        
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-8 mb-16">
            <div class="max-w-2xl">
                <div class="flex items-center gap-3 mb-6">
                    <span class="w-12 h-px bg-brand-600"></span>
                    <span class="text-[10px] font-black text-brand-600 uppercase tracking-[0.3em]">Visualisasi Data</span>
                </div>
                <h2 class="font-display font-black text-3xl md:text-5xl text-slate-900 dark:text-white leading-tight">
                    Tren <span class="text-transparent bg-clip-text bg-gradient-to-r from-brand-600 to-accent">Pertumbuhan</span> Desa.
                </h2>
            </div>
            <div class="flex items-center gap-4">
                <a href="<?= site_url('statistik/perkembangan-penduduk') ?>" class="px-8 py-4 bg-white dark:bg-slate-800 rounded-2xl text-sm font-bold text-slate-900 dark:text-white border border-slate-200 dark:border-slate-700 hover:border-brand-600 transition-all shadow-sm flex items-center gap-3 group">
                    Detail Statistik
                    <i class="fa-solid fa-arrow-right text-xs group-hover:translate-x-1 transition-transform"></i>
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <!-- Main Chart Area -->
            <div class="lg:col-span-2">
                <div class="bg-white dark:bg-slate-800 rounded-[3rem] p-8 md:p-12 border border-slate-100 dark:border-slate-700 shadow-xl shadow-slate-200/50 dark:shadow-none">
                    <div id="home-trend-chart" class="w-full h-80"></div>
                </div>
            </div>

            <!-- Stats & Info -->
            <div class="space-y-6">
                
                <!-- Card: Kelahiran -->
                <div class="p-8 rounded-[2.5rem] bg-emerald-500 text-white shadow-xl shadow-emerald-500/20 relative overflow-hidden group">
                    <div class="absolute -right-8 -bottom-8 w-32 h-32 bg-white/10 rounded-full blur-2xl group-hover:scale-150 transition-transform duration-700"></div>
                    <div class="relative z-10">
                        <div class="flex items-center justify-between mb-6">
                            <div class="w-12 h-12 rounded-xl bg-white/20 backdrop-blur-md flex items-center justify-center border border-white/20">
                                <i class="fa-solid fa-baby-carriage text-xl"></i>
                            </div>
                            <span class="text-[9px] font-black uppercase tracking-widest opacity-80">Laporan 2026</span>
                        </div>
                        <div class="text-4xl font-display font-black mb-1" id="home-val-lahir">0</div>
                        <div class="text-xs font-bold uppercase tracking-widest opacity-80">Angka Kelahiran</div>
                    </div>
                </div>

                <!-- Card: Kematian -->
                <div class="p-8 rounded-[2.5rem] bg-slate-900 text-white shadow-xl shadow-slate-900/20 relative overflow-hidden group">
                    <div class="absolute -right-8 -bottom-8 w-32 h-32 bg-brand-500/20 rounded-full blur-2xl group-hover:scale-150 transition-transform duration-700"></div>
                    <div class="relative z-10">
                        <div class="flex items-center justify-between mb-6">
                            <div class="w-12 h-12 rounded-xl bg-white/10 backdrop-blur-md flex items-center justify-center border border-white/10">
                                <i class="fa-solid fa-dove text-xl"></i>
                            </div>
                            <span class="text-[9px] font-black uppercase tracking-widest opacity-60">Laporan 2026</span>
                        </div>
                        <div class="text-4xl font-display font-black mb-1" id="home-val-mati">0</div>
                        <div class="text-xs font-bold uppercase tracking-widest opacity-60">Angka Kematian</div>
                    </div>
                </div>

            </div>

        </div>

    </div>
</section>

<script>
$(document).ready(function() {
    let homeChart;

    function renderHomeChart() {
        const chartContainer = $('#home-trend-chart');
        if (!chartContainer.length) return;

        const isDark = document.documentElement.classList.contains('dark');
        const textColor = isDark ? '#94a3b8' : '#475569';
        const brandColor = '#3b82f6';
        const gridColor = isDark ? 'rgba(255,255,255,0.05)' : 'rgba(0,0,0,0.05)';

        $.ajax({
            url: "<?= site_url('first/grafik_kependudukan') ?>",
            data: { tahun: '5_tahun' },
            dataType: 'json',
            success: function(data) {
                if (!data || data.error || !data.total_penduduk) {
                    chartContainer.html('<div class="flex items-center justify-center h-full text-slate-400 text-xs uppercase tracking-widest">Data Tidak Tersedia</div>');
                    return;
                }

                $('#home-val-lahir').text(data.kelahiran.reduce((a, b) => a + b, 0).toLocaleString('id-ID'));
                $('#home-val-mati').text(data.kematian.reduce((a, b) => a + b, 0).toLocaleString('id-ID'));

                homeChart = Highcharts.chart('home-trend-chart', {
                    chart: {
                        type: 'areaspline',
                        backgroundColor: 'transparent',
                        margin: [30, 20, 30, 20],
                        style: { fontFamily: 'Inter, sans-serif' }
                    },
                    title: { text: null },
                    credits: { enabled: false },
                    xAxis: {
                        categories: data.categories,
                        labels: { style: { color: textColor, fontSize: '10px', fontWeight: 'bold' } },
                        lineWidth: 0,
                        tickWidth: 0
                    },
                    yAxis: {
                        visible: false,
                        min: 0
                    },
                    legend: { enabled: false },
                    tooltip: {
                        backgroundColor: isDark ? '#1e293b' : '#ffffff',
                        borderColor: brandColor,
                        borderRadius: 12,
                        shared: true,
                        style: { color: isDark ? '#f1f5f9' : '#1e293b' }
                    },
                    plotOptions: {
                        areaspline: {
                            fillOpacity: 0.1,
                            lineWidth: 4,
                            color: brandColor,
                            marker: {
                                radius: 6,
                                fillColor: isDark ? '#1e293b' : '#ffffff',
                                lineWidth: 3,
                                lineColor: brandColor
                            }
                        }
                    },
                    series: [{
                        name: 'Penduduk Datang',
                        data: data.pindah_datang,
                        color: brandColor
                    }, {
                        name: 'Penduduk Pergi',
                        data: data.pindah_pergi,
                        color: '#f59e0b'
                    }, {
                        name: 'Kelahiran',
                        data: data.kelahiran,
                        color: '#10b981'
                    }, {
                        name: 'Kematian',
                        data: data.kematian,
                        color: '#f43f5e'
                    }]
                });
            }
        });
    }

    // Theme Observer
    const observer = new MutationObserver((mutations) => {
        mutations.forEach((mutation) => {
            if (mutation.attributeName === 'class') {
                renderHomeChart();
            }
        });
    });

    observer.observe(document.documentElement, { attributes: true });
    
    // Initial Load
    if (typeof Highcharts !== 'undefined') {
        renderHomeChart();
    } else {
        const checkHighcharts = setInterval(() => {
            if (typeof Highcharts !== 'undefined') {
                renderHomeChart();
                clearInterval(checkHighcharts);
            }
        }, 100);
    }
});
</script>
