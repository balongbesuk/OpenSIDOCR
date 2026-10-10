<?php if(!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<script>
$(document).ready(function() {
    const isDark = document.documentElement.classList.contains('dark');
    const textColor = isDark ? '#f8fafc' : '#0f172a';
    const subTextColor = isDark ? '#94a3b8' : '#64748b';
    const gridColor = isDark ? 'rgba(255,255,255,0.05)' : 'rgba(0,0,0,0.05)';
    const brandColor = '#3b82f6';
    const accentColor = '#10b981';
    
    // Custom Palette for Chart
    const palette = ['#3b82f6', '#10b981', '#f59e0b', '#8b5cf6', '#ec4899', '#06b6d4'];

    Highcharts.setOptions({
        colors: palette,
        chart: {
            style: { fontFamily: "'Outfit', sans-serif" },
            backgroundColor: 'transparent'
        },
        credits: { enabled: false }
    });

    $('.highcharts-stat-box').each(function() {
        const $thisContainer = $(this);
        // Skip if hidden (to avoid double init on table-only box)
        if ($thisContainer.closest('#table-only').length) return;

        new Highcharts.Chart({
            chart: {
                renderTo: this,
                type: 'column',
                spacingTop: 40,
                spacingBottom: 40,
                borderRadius: 24,
            },
            title: { text: null },
            xAxis: {
                categories: [
                    <?php foreach($main as $data) : ?>
                        '<?= $data['nama'] ?>',
                    <?php endforeach; ?>
                ],
                labels: { 
                    style: { 
                        color: subTextColor, 
                        fontWeight: '800', 
                        fontSize: '10px',
                        textTransform: 'uppercase',
                        letterSpacing: '0.1em'
                    } 
                },
                lineColor: gridColor,
                tickColor: gridColor,
                gridLineWidth: 0
            },
            yAxis: {
                title: { 
                    text: 'Populasi (Jiwa)', 
                    style: { color: subTextColor, fontWeight: '900', textTransform: 'uppercase', fontSize: '9px', letterSpacing: '0.2em' } 
                },
                labels: { style: { color: subTextColor, fontWeight: '700' } },
                gridLineColor: gridColor,
                gridLineDashStyle: 'Dash'
            },
            legend: { enabled: false },
            plotOptions: {
                column: {
                    borderRadius: 12,
                    borderWidth: 0,
                    maxPointWidth: 60,
                    colorByPoint: true,
                    dataLabels: {
                        enabled: true,
                        style: { 
                            fontWeight: '900', 
                            color: textColor, 
                            textOutline: 'none',
                            fontSize: '14px'
                        }
                    },
                    states: {
                        hover: {
                            brightness: 0.1,
                            shadow: true
                        }
                    }
                }
            },
            series: [{
                name: 'Populasi',
                data: [
                    <?php foreach($main as $data) : ?>
                        <?= $data['jumlah'] ?>,
                    <?php endforeach; ?>
                ]
            }],
            tooltip: {
                backgroundColor: isDark ? 'rgba(15, 23, 42, 0.9)' : 'rgba(255, 255, 255, 0.9)',
                backdropFilter: 'blur(12px)',
                borderColor: gridColor,
                borderRadius: 20,
                borderWidth: 1,
                shadow: true,
                style: { color: textColor, fontWeight: '700' },
                padding: 15,
                headerFormat: '<span style="font-size: 10px; font-weight: 900; text-transform: uppercase; color: #64748b">{point.key}</span><br/>',
                pointFormat: '<span style="color:{point.color}">\u25CF</span> <span style="font-size: 16px; font-weight: 900">{point.y}</span> Jiwa'
            }
        });
    });
});
</script>

<div class="space-y-10">
    <!-- Chart Card -->
    <div class="bg-white dark:bg-slate-900 rounded-[2.5rem] border border-slate-100 dark:border-slate-800 p-8 md:p-12 shadow-sm shadow-slate-200/50 dark:shadow-slate-950/50">
        <div class="flex items-center gap-4 mb-10 border-b border-slate-50 dark:border-slate-800 pb-8">
            <div class="w-12 h-12 rounded-2xl bg-brand-600/10 text-brand-600 flex items-center justify-center">
                <i class="fa-solid fa-chart-simple-stacked text-xl"></i>
            </div>
            <div>
                <h3 class="font-display font-black text-2xl text-slate-900 dark:text-white tracking-tighter leading-none">Grafik Visualisasi</h3>
                <p class="text-slate-500 dark:text-slate-400 text-sm font-medium mt-1">Distribusi penduduk berdasarkan kelas sosial</p>
            </div>
        </div>
        
        <!-- Highcharts Target -->
        <div class="highcharts-container-wrapper">
            <div id="container" class="highcharts-stat-box w-full min-h-[400px]"></div>
        </div>
    </div>

    <!-- Table Details -->
    <div class="bg-white dark:bg-slate-900 rounded-[2.5rem] border border-slate-100 dark:border-slate-800 shadow-sm shadow-slate-200/50 dark:shadow-slate-950/50 overflow-hidden">
        <div class="p-8 md:p-12 border-b border-slate-50 dark:border-slate-800">
             <h3 class="font-display font-black text-2xl text-slate-900 dark:text-white tracking-tighter leading-none">Rincian Data</h3>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full border-collapse">
                <thead>
                    <tr class="bg-slate-50/50 dark:bg-slate-800/30">
                        <th class="px-8 py-6 text-left text-[10px] font-display font-black text-slate-400 dark:text-slate-500 uppercase tracking-[0.2em] border-b border-slate-50 dark:border-slate-800">#</th>
                        <th class="px-8 py-6 text-left text-[10px] font-display font-black text-slate-400 dark:text-slate-500 uppercase tracking-[0.2em] border-b border-slate-50 dark:border-slate-800">Kelompok / Kelas Sosial</th>
                        <th class="px-8 py-6 text-right text-[10px] font-display font-black text-slate-400 dark:text-slate-500 uppercase tracking-[0.2em] border-b border-slate-50 dark:border-slate-800">Jumlah (Jiwa)</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50 dark:divide-slate-800">
                    <?php $i=0; foreach($main as $data) : ?>
                        <tr class="group transition-colors hover:bg-slate-50/50 dark:hover:bg-slate-800/20">
                            <td class="px-8 py-6 text-sm font-black text-slate-400 group-hover:text-brand-600 transition-colors"><?= $data['id'] ?></td>
                            <td class="px-8 py-6">
                                <span class="text-sm font-bold text-slate-700 dark:text-slate-300 group-hover:text-slate-900 dark:group-hover:text-white transition-colors capitalize"><?= strtolower($data['nama']) ?></span>
                            </td>
                            <td class="px-8 py-6 text-right">
                                <span class="font-display font-black text-base text-brand-600 dark:text-brand-400"><?= number_format($data['jumlah'], 0, ',', '.') ?></span>
                            </td>
                        </tr>
                        <?php $i += $data['jumlah']; ?>
                    <?php endforeach; ?>
                </tbody>
                <tfoot>
                    <tr class="bg-slate-900 dark:bg-slate-950">
                        <td colspan="2" class="px-8 py-8 text-right text-[10px] font-display font-black text-slate-400 uppercase tracking-[0.3em]">
                            Total Populasi Terdata
                        </td>
                        <td class="px-8 py-8 text-right">
                            <div class="inline-flex flex-col items-end">
                                <span class="font-display font-black text-3xl text-white tracking-tighter leading-none"><?= number_format($i, 0, ',', '.') ?></span>
                                <span class="text-[9px] font-bold text-brand-500 uppercase tracking-widest mt-1">Jiwa Penduduk</span>
                            </div>
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
