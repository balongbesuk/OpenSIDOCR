<?php if(!defined('BASEPATH')) exit('No direct script access allowed'); ?>



<?php $stat_view_mode = isset($stat_view_mode) ? $stat_view_mode : 'full'; ?>

<?php if ($stat_view_mode !== 'table'): ?>
<script>
$(document).ready(function() {
    // Detect Dark Mode

    const isDark = document.documentElement.classList.contains('dark');

    const textColor = isDark ? '#94a3b8' : '#475569';

    const gridColor = isDark ? '#1e293b' : '#f1f5f9';

    

    // Premium Color Palette

    const palette = ['#6366f1', '#10b981', '#f59e0b', '#ec4899', '#8b5cf6', '#06b6d4', '#f43f5e'];



    Highcharts.setOptions({

        colors: palette,

        chart: {

            style: { fontFamily: "'Inter', sans-serif" },

            backgroundColor: 'transparent'

        },

        credits: { enabled: false }

    });



    $('.highcharts-stat-box').each(function() {
        <?php if($tipe == 1) : ?>
        // BAR CHART

        new Highcharts.Chart({

            chart: {

                renderTo: this,

                type: 'column',

                spacingBottom: 30,

                spacingTop: 10

            },

            title: { text: null },

            xAxis: {

                categories: [

                    <?php if(is_array($stat)) : ?>

                        <?php $i=0; foreach($stat as $data) : $i++; ?>

                            <?php if($data['jumlah'] != "-" && !in_array($data['nama'], ["TOTAL", "JUMLAH"])) : ?>

                                '<?= $data['nama'] ?>',

                            <?php endif; ?>

                        <?php endforeach; ?>

                    <?php endif; ?>

                ],

                labels: { style: { color: textColor, fontWeight: '700', fontSize: '10px' } },

                lineColor: gridColor,

                tickColor: gridColor

            },

            yAxis: {

                title: { text: 'Populasi (Jiwa)', style: { color: textColor, fontWeight: '800', textTransform: 'uppercase', letterSpacing: '0.1em', fontSize: '9px' } },

                labels: { style: { color: textColor, fontWeight: '600' } },

                gridLineColor: gridColor

            },

            legend: { enabled: false },

            plotOptions: {

                column: {

                    borderRadius: 8,

                    pointPadding: 0.2,

                    borderWidth: 0,

                    colorByPoint: true,

                    dataLabels: {

                        enabled: true,

                        style: { fontWeight: '800', fontSize: '11px', color: textColor, textOutline: 'none' }

                    }

                }

            },

            series: [{

                name: 'Populasi',

                data: [

                    <?php if(is_array($stat)) : ?>

                        <?php foreach($stat as $data) : ?>

                            <?php if($data['jumlah'] != "-" && !in_array($data['nama'], ["TOTAL", "JUMLAH"])) : ?>

                                <?= $data['jumlah'] ?>,

                            <?php endif; ?>

                        <?php endforeach; ?>

                    <?php endif; ?>

                ]

            }],

            tooltip: {

                backgroundColor: isDark ? '#1e293b' : '#ffffff',

                borderColor: gridColor,

                borderRadius: 12,

                style: { color: textColor },

                shared: true,

                useHTML: true

            }

        });



        <?php elseif($tipe == 2) : ?>
        // LINE CHART
        new Highcharts.Chart({
            chart: {
                renderTo: this,
                type: 'areaspline',
                spacingBottom: 30,
                spacingTop: 10
            },
            title: { text: null },
            xAxis: {
                categories: [
                    <?php if(is_array($stat)) : ?>
                        <?php $i=0; foreach($stat as $data) : $i++; ?>
                            <?php if($data['jumlah'] != "-" && !in_array($data['nama'], ["TOTAL", "JUMLAH"])) : ?>
                                '<?= $data['nama'] ?>',
                            <?php endif; ?>
                        <?php endforeach; ?>
                    <?php endif; ?>
                ],
                labels: { style: { color: textColor, fontWeight: '700', fontSize: '10px' } },
                lineColor: gridColor,
                tickColor: gridColor
            },
            yAxis: {
                title: { text: 'Populasi (Jiwa)', style: { color: textColor, fontWeight: '800', textTransform: 'uppercase', letterSpacing: '0.1em', fontSize: '9px' } },
                labels: { style: { color: textColor, fontWeight: '600' } },
                gridLineColor: gridColor
            },
            legend: { enabled: false },
            plotOptions: {
                areaspline: {
                    fillOpacity: 0.5,
                    dataLabels: {
                        enabled: true,
                        style: { fontWeight: '800', fontSize: '11px', color: textColor, textOutline: 'none' }
                    }
                }
            },
            series: [{
                name: 'Populasi',
                color: palette[0],
                fillColor: {
                    linearGradient: { x1: 0, y1: 0, x2: 0, y2: 1},
                    stops: [
                        [0, Highcharts.color(palette[0]).setOpacity(0.5).get('rgba')],
                        [1, Highcharts.color(palette[0]).setOpacity(0).get('rgba')]
                    ]
                },
                data: [
                    <?php if(is_array($stat)) : ?>
                        <?php foreach($stat as $data) : ?>
                            <?php if($data['jumlah'] != "-" && !in_array($data['nama'], ["TOTAL", "JUMLAH"])) : ?>
                                <?= $data['jumlah'] ?>,
                            <?php endif; ?>
                        <?php endforeach; ?>
                    <?php endif; ?>
                ]
            }],
            tooltip: {
                backgroundColor: isDark ? '#1e293b' : '#ffffff',
                borderColor: gridColor,
                borderRadius: 12,
                style: { color: textColor },
                shared: true,
                useHTML: true
            }
        });

        <?php else : ?>

        // PIE CHART

        new Highcharts.Chart({

            chart: {

                renderTo: this,

                type: 'pie',

                plotBackgroundColor: null,

                plotBorderWidth: null,

                plotShadow: false

            },

            title: { text: null },

            tooltip: {

                pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b> ({point.y} Jiwa)',

                backgroundColor: isDark ? '#1e293b' : '#ffffff',

                borderColor: gridColor,

                borderRadius: 12,

                style: { color: textColor }

            },

            plotOptions: {

                pie: {

                    allowPointSelect: true,

                    cursor: 'pointer',

                    dataLabels: {

                        enabled: true,

                        format: '<span style="font-weight: 800; color: {point.color}">{point.name}</span><br><span style="opacity: 0.6">{point.percentage:.1f}%</span>',

                        style: { fontSize: '10px', textOutline: 'none', color: textColor }

                    },

                    showInLegend: true,

                    innerSize: '50%',
                    borderWidth: 0

                }

            },

            legend: {

                itemStyle: { color: textColor, fontWeight: '700', fontSize: '10px' },

                itemHoverStyle: { color: '#6366f1' }

            },

            series: [{

                name: 'Persentase',

                colorByPoint: true,

                data: [

                    <?php if(is_array($stat)) : ?>

                        <?php foreach($stat as $data): ?>

                            <?php if($data['jumlah'] != "-" && !in_array($data['nama'], ["TOTAL", "JUMLAH"])): ?>

                                { name: '<?= $data['nama'] ?>', y: <?= $data['jumlah'] ?> },

                            <?php endif; ?>

                        <?php endforeach; ?>

                    <?php endif; ?>

                ]

            }]

        });

        <?php endif; ?>

    });

});
</script>

<div class="highcharts-container-wrapper">
    <div id="container" class="highcharts-stat-box"></div>
</div>
<?php endif; ?>

<?php if ($stat_view_mode !== 'chart'): ?>
<div class="list-frame">
    <div class="overflow-x-auto">

        <table class="premium-table">

            <thead>

                <tr>

                    <th rowspan="2">No</th>

                    <th rowspan="2" class="text-left">Kelompok</th>

                    <th colspan="2">Jumlah</th>

                    <th colspan="2">Laki-laki</th>

                    <th colspan="2">Perempuan</th>

                </tr>

                <tr>

                    <th class="text-right">Jiwa</th>

                    <th class="text-right">%</th>

                    <th class="text-right">n</th>

                    <th class="text-right">%</th>

                    <th class="text-right">n</th>

                    <th class="text-right">%</th>

                </tr>

            </thead>

            <tbody>

                <?php 

                if(is_array($stat)) :

                $i=0; $hide=''; $not_hide=0; $jml = count($stat);

                foreach($stat as $data): 

                    $not_hide++;

                    if ($not_hide > 10 && $jml > 11) $hide='tr-lebih hide';

                ?>

                    <tr class="<?= $hide ?>">

                        <td class="text-right"><?= $data['no'] ?></td>

                        <td class="text-left"><?= $data['nama'] ?></td>

                        <td class="text-right"><?= $data['jumlah'] ?></td>

                        <td class="text-right"><?= $data['persen'] ?></td>

                        <td class="text-right"><?= $data['laki'] ?></td>

                        <td class="text-right"><?= $data['persen1'] ?></td>

                        <td class="text-right"><?= $data['perempuan'] ?></td>

                        <td class="text-right"><?= $data['persen2'] ?></td>

                    </tr>

                <?php endforeach; ?>

                <?php endif; ?>

            </tbody>

        </table>



        <?php if (isset($hide) && $hide == "tr-lebih hide"): ?>

            <button id="showData">Tampilkan Semua Data Rincian <i class="fa-solid fa-chevron-down ml-2"></i></button>

        <?php endif; ?>

    </div>
</div>
<?php endif; ?>
