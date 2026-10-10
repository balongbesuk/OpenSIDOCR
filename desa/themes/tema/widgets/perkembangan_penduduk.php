<?php if(!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<!-- Highcharts Dependencies (Loaded only if not already present) -->
<script>
    if (typeof Highcharts === 'undefined') {
        const hcScript = document.createElement('script');
        hcScript.src = "<?= base_url($folder_themes . '/assets/js/highcharts.js') ?>";
        document.head.appendChild(hcScript);
        
        const hcmScript = document.createElement('script');
        hcmScript.src = "<?= base_url($folder_themes . '/assets/js/highcharts-more.js') ?>";
        document.head.appendChild(hcmScript);
    }
</script>

<div class="mb-10 group/widget overflow-hidden">
    <div class="bg-white dark:bg-slate-900 rounded-[2.5rem] border border-slate-100 dark:border-slate-800 shadow-xl shadow-slate-200/40 dark:shadow-slate-950/50 transition-all duration-500 hover:shadow-2xl relative overflow-hidden">
        
        <!-- Header -->
        <div class="p-8 border-b border-slate-50 dark:border-slate-800 flex items-center justify-between bg-slate-50/30 dark:bg-slate-800/20">
            <h3 class="premium-h1 text-[11px] uppercase tracking-[0.2em] flex items-center gap-4">
                <div class="w-1.5 h-8 bg-brand-600 rounded-full"></div>
                Tren Penduduk 5 Tahun
            </h3>
            <div class="flex gap-2">
                <div class="w-2 h-2 rounded-full bg-brand-500 animate-pulse"></div>
            </div>
        </div>

        <!-- Chart Body -->
        <div class="p-6 relative z-10">
            <div id="chart-widget-penduduk" class="w-full h-64">
                <div class="flex items-center justify-center h-full">
                    <div class="flex flex-col items-center gap-4 text-slate-300">
                        <i class="fa-solid fa-circle-notch fa-spin text-2xl text-brand-600"></i>
                        <span class="text-[10px] font-black uppercase tracking-widest">Memuat Data...</span>
                    </div>
                </div>
            </div>
            
            <!-- Quick Summary -->
            <div id="summary-widget-penduduk" class="mt-4 pt-6 border-t border-slate-50 dark:border-slate-800 grid grid-cols-2 gap-4 hidden">
                <div class="flex flex-col">
                    <span class="text-[9px] font-bold text-slate-400 uppercase tracking-widest mb-1">Tahun Lalu</span>
                    <span id="prev-year-val" class="font-display font-black text-lg text-slate-900 dark:text-white">-</span>
                </div>
                <div class="flex flex-col items-end">
                    <span class="text-[9px] font-bold text-slate-400 uppercase tracking-widest mb-1">Tahun Ini</span>
                    <span id="curr-year-val" class="font-display font-black text-lg text-brand-600">-</span>
                </div>
            </div>
        </div>

        <!-- Decor -->
        <div class="absolute -right-12 -top-12 w-48 h-48 bg-brand-600/5 rounded-full blur-3xl pointer-events-none"></div>
    </div>
</div>

<script>
$(document).ready(function() {
    function initWidgetChart() {
        if (typeof Highcharts === 'undefined') {
            setTimeout(initWidgetChart, 300);
            return;
        }

        const isDark = document.documentElement.classList.contains('dark');
        const textColor = isDark ? '#94a3b8' : '#475569';
        const brandColor = '#3b82f6';

        $.ajax({
            url: "<?= site_url('first/grafik_kependudukan') ?>",
            data: { tahun: '5_tahun' },
            dataType: 'json',
            success: function(data) {
                if (data.error) return;

                $('#summary-widget-penduduk').removeClass('hidden');
                $('#prev-year-val').text(data.total_penduduk[data.total_penduduk.length - 2].toLocaleString('id-ID'));
                $('#curr-year-val').text(data.total_penduduk[data.total_penduduk.length - 1].toLocaleString('id-ID'));

                Highcharts.chart('chart-widget-penduduk', {
                    chart: {
                        type: 'areaspline',
                        backgroundColor: 'transparent',
                        margin: [10, 0, 30, 0],
                        spacing: [0, 0, 0, 0]
                    },
                    title: { text: null },
                    credits: { enabled: false },
                    xAxis: {
                        categories: data.categories,
                        labels: { 
                            style: { color: textColor, fontSize: '9px', fontWeight: 'bold' },
                            y: 20
                        },
                        lineWidth: 0,
                        tickWidth: 0
                    },
                    yAxis: {
                        visible: false,
                        min: Math.min(...data.total_penduduk) * 0.99
                    },
                    legend: { enabled: false },
                    tooltip: {
                        backgroundColor: isDark ? '#1e293b' : '#ffffff',
                        borderColor: brandColor,
                        borderRadius: 12,
                        style: { color: textColor, fontSize: '10px' },
                        headerFormat: '<span style="font-size: 9px; font-weight: 800">{point.key}</span><br/>',
                        pointFormat: '<b>{point.y}</b> Jiwa'
                    },
                    plotOptions: {
                        areaspline: {
                            fillOpacity: 0.1,
                            lineWidth: 3,
                            color: brandColor,
                            marker: {
                                radius: 4,
                                fillColor: '#ffffff',
                                lineWidth: 2,
                                lineColor: brandColor
                            }
                        }
                    },
                    series: [{
                        name: 'Penduduk',
                        data: data.total_penduduk,
                        fillColor: {
                            linearGradient: { x1: 0, y1: 0, x2: 0, y2: 1 },
                            stops: [
                                [0, Highcharts.color(brandColor).setOpacity(0.2).get('rgba')],
                                [1, Highcharts.color(brandColor).setOpacity(0).get('rgba')]
                            ]
                        }
                    }]
                });
            }
        });
    }

    initWidgetChart();
});
</script>
