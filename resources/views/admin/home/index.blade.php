@extends('admin.layouts.index')



@push('css')

    <style>

        .catatan-scroll {

            height: 400px;

            overflow-y: scroll;

        }



        @media (max-width: 576px) {

            .komunikasi-opendk {

                display: none !important;

            }

        }

    </style>

@endpush



@section('title')

    <h1>

        Tentang <?= config_item('nama_aplikasi') ?>

    </h1>

@endsection



@section('breadcrumb')

    <li class="active">Tentang <?= config_item('nama_aplikasi') ?></li>

@endsection



@section('content')

    @include('admin.layouts.components.notifikasi')



    @include('admin.home.saas')



    @include('admin.home.premium')



    @include('admin.home.rilis')



    @include('admin.home.bantuan')



    <div class="row">

        @if (can('b', 'wilayah'))

            <div class="col-lg-3 col-sm-6 col-xs-6">

                <div class="small-box bg-purple">

                    <div class="inner">

                        <h3>{{ $dusun }}</h3>

                        <p>{{ SebutanDesa('Wilayah [Desa]') }}</p>

                    </div>

                    <div class="icon">

                        <i class="ion ion-location"></i>

                    </div>

                    <a href="{{ route('wilayah') }}" class="small-box-footer">Lihat Detail <i

                            class="fa fa-arrow-circle-right"></i></a>

                </div>

            </div>

        @endif



        @if (can('b', 'penduduk'))

            <div class="col-lg-3 col-sm-6 col-xs-6">

                <div class="small-box bg-aqua">

                    <div class="inner">

                        <h3>{{ $penduduk }}</h3>

                        <p>Penduduk

                            @if (isset($trend_penduduk) && $trend_penduduk != 0)

                                <span style="font-size: 12px; margin-left: 5px; background: rgba(0,0,0,0.2); padding: 2px 6px; border-radius: 4px;" title="Perubahan bulan ini">

                                    <i class="fa {{ $trend_penduduk > 0 ? 'fa-arrow-up' : 'fa-arrow-down' }}"></i> {{ abs($trend_penduduk) }} bulan ini

                                </span>

                            @endif

                        </p>

                    </div>

                    <div class="icon">

                        <i class="ion ion-person"></i>

                    </div>

                    <a href="{{ route('penduduk.clear') }}" class="small-box-footer">Lihat Detail <i

                            class="fa fa-arrow-circle-right"></i></a>

                </div>

            </div>

        @endif



        @if (can('b', 'keluarga'))

            <div class="col-lg-3 col-sm-6 col-xs-6">

                <div class="small-box bg-green">

                    <div class="inner">

                        <h3>{{ $keluarga }}</h3>

                        <p>Keluarga

                            @if (isset($trend_keluarga) && $trend_keluarga != 0)

                                <span style="font-size: 12px; margin-left: 5px; background: rgba(0,0,0,0.2); padding: 2px 6px; border-radius: 4px;" title="Perubahan bulan ini">

                                    <i class="fa {{ $trend_keluarga > 0 ? 'fa-arrow-up' : 'fa-arrow-down' }}"></i> {{ abs($trend_keluarga) }} bulan ini

                                </span>

                            @endif

                        </p>

                    </div>

                    <div class="icon">

                        <i class="ion ion-ios-people"></i>

                    </div>

                    <a href="{{ route('keluarga.clear') }}" class="small-box-footer">Lihat Detail <i

                            class="fa fa-arrow-circle-right"></i></a>

                </div>

            </div>

        @endif



        @if (can('b', 'keluar'))

            <div class="col-lg-3 col-sm-6 col-xs-6">

                <div class="small-box bg-blue">

                    <div class="inner">

                        <h3>{{ $surat }}</h3>

                        <p>Surat Tercetak</p>

                    </div>

                    <div class="icon">

                        <i class="ion-ios-paper"></i>

                    </div>

                    <a href="{{ route('keluar.clear') }}" class="small-box-footer">Lihat Detail <i

                            class="fa fa-arrow-circle-right"></i></a>

                </div>

            </div>

        @endif



        @if (can('b', 'kelompok'))

            <div class="col-lg-3 col-sm-6 col-xs-6">

                <div class="small-box bg-red">

                    <div class="inner">

                        <h3>{{ $kelompok }}</h3>

                        <p>Kelompok</p>

                    </div>

                    <div class="icon">

                        <i class="ion ion-android-people"></i>

                    </div>

                    <a href="{{ route('kelompok.clear') }}" class="small-box-footer">Lihat Detail <i

                            class="fa fa-arrow-circle-right"></i></a>

                </div>

            </div>

        @endif



        @if (can('b', 'rtm'))

            <div class="col-lg-3 col-sm-6 col-xs-6">

                <div class="small-box bg-gray">

                    <div class="inner">

                        <h3>{{ $rtm }}</h3>

                        <p>Rumah Tangga</p>

                    </div>

                    <div class="icon">

                        <i class="ion ion-ios-home"></i>

                    </div>

                    <a href="{{ route('rtm.clear') }}" class="small-box-footer">Lihat Detail <i

                            class="fa fa-arrow-circle-right"></i></a>

                </div>

            </div>

        @endif



        @if (can('b', 'program_bantuan'))

            <div class="col-lg-3 col-sm-6 col-xs-6">

                <div class="small-box bg-yellow">

                    <div class="inner">

                        <h3>{{ $bantuan['jumlah'] }}</h3>

                        <p>{{ $bantuan['nama'] }}</p>

                    </div>

                    <div class="icon">

                        <i class="ion ion-ios-pie"></i>

                    </div>

                    <div class="small-box-footer">

                        <a href="#" class="inner text-white rilis_pengaturan" data-remote="false" data-toggle="modal"

                            data-target="#pengaturan-bantuan"><i class="fa fa-gear"></i></a>

                        <a href="{{ route($bantuan['link_detail']) }}" class="inner text-white">Lihat Detail <i

                                class="fa fa-arrow-circle-right"></i></a>

                    </div>

                </div>

            </div>

        @endif



        @if (can('b', 'mandiri'))

            <div class="col-lg-3 col-sm-6 col-xs-6">

                <div class="small-box" style="background-color: #39CCCC;">

                    <div class="inner">

                        <h3>{{ $pendaftaran }}</h3>

                        <p>Verifikasi Layanan Mandiri</p>

                    </div>

                    <div class="icon">

                        <i class="ion ion-person"></i>

                    </div>

                    <a href="{{ route('mandiri') }}" class="small-box-footer">Lihat Detail <i

                            class="fa fa-arrow-circle-right"></i></a>

                </div>

            </div>

        @endif

    </div>



    <div class="row">

        <div class="col-md-12">

            <div class="box box-info">

                <div class="box-header with-border">

                    <h3 class="box-title">Statistik Kependudukan</h3>

                    <div class="box-tools pull-right">

                        <form class="form-inline" id="form-filter-tahun">

                            <div class="form-group">

                                <label for="filter_tahun">Tahun: </label>

                                <select class="form-control input-sm" id="filter_tahun" name="tahun">

                                    <option value="5_tahun">5 Tahun Terakhir</option>
                                    <option value="7_tahun">7 Tahun Terakhir</option>
                                    <option value="10_tahun">10 Tahun Terakhir</option>

                                    @for ($i = date('Y'); $i >= date('Y') - 10; $i--)

                                        <option value="{{ $i }}">{{ $i }}</option>

                                    @endfor

                                </select>

                            </div>

                        </form>

                    </div>

                </div>

                <div class="box-body">

                    <div class="row">

                        <div class="col-md-6">

                            <figure class="highcharts-figure">

                                <div id="container-grafik-total-penduduk"></div>

                            </figure>

                        </div>

                        <div class="col-md-6">

                            <figure class="highcharts-figure">

                                <div id="container-grafik-total-keluarga"></div>

                            </figure>

                        </div>

                    </div>

                    <div class="row">

                        <div class="col-md-6">

                            <figure class="highcharts-figure">

                                <div id="container-grafik-lahir-mati"></div>

                            </figure>

                            <div id="table-lahir-mati" style="margin-top: 10px; display: none;"></div>

                        </div>

                        <div class="col-md-6">

                            <figure class="highcharts-figure">

                                <div id="container-grafik-pindah"></div>

                            </figure>

                            <div id="table-pindah" style="margin-top: 10px; display: none;"></div>

                        </div>

                    </div>

                    </div>

                </div>

                <div class="overlay" style="display: none;" id="loading-statistik">

                    <i class="fa fa-refresh fa-spin"></i>

                </div>

            </div>

        </div>

    </div>

@endsection



@push('scripts')

    @include('admin.layouts.components.asset_highcharts')

    <script src="{{ asset('js/highcharts/export-data.js') }}"></script>

    <style>

        .custom-data-table table {

            border-collapse: collapse;

            border: 1px solid #EBEBEB;

            margin: 10px auto;

            text-align: center;

            width: 100%;

            background: white;

        }

        .custom-data-table th {

            font-weight: 600;

            padding: 0.5em;

            background: #f8f8f8;

            border: 1px solid #EBEBEB;

            text-align: center;

            vertical-align: middle;

        }

        .custom-data-table td {

            padding: 0.5em;

            border: 1px solid #EBEBEB;

            text-align: center;

            vertical-align: middle;

        }

        .custom-data-table tr:hover {

            background: #f1f7ff;

        }

        .custom-data-table a {

            font-weight: bold;

            color: #3c8dbc;

            cursor: pointer;

            display: block;

            width: 100%;

            height: 100%;

        }

        .custom-data-table a:hover {

            text-decoration: underline;

            color: #23527c;

        }

    </style>

    <script>

        $(document).ready(function() {

            Highcharts.setOptions({

                lang: {

                    viewData: 'Tampilkan Tabel Data',

                    hideData: 'Sembunyikan Tabel Data',

                    printChart: 'Cetak Grafik',

                    downloadPNG: 'Unduh PNG',

                    downloadJPEG: 'Unduh JPEG',

                    downloadPDF: 'Unduh PDF',

                    downloadSVG: 'Unduh SVG',

                    contextButtonTitle: 'Menu Ekspor'

                },

                exporting: {

                    menuItemDefinitions: {

                        viewData: {

                            textKey: 'viewData',

                            onclick: function () {

                                var chart = this;

                                var containerId = chart.renderTo.id;

                                var tableId = '';

                                

                                if (containerId === 'container-grafik-lahir-mati') tableId = 'table-lahir-mati';

                                else if (containerId === 'container-grafik-pindah') tableId = 'table-pindah';

                                

                                if (tableId) {

                                    $('#' + tableId).fadeToggle();

                                }

                            }

                        }

                    },

                    buttons: {

                        contextButton: {

                            menuItems: [

                                "viewFullscreen",

                                "printChart",

                                "separator",

                                "downloadPNG",

                                "downloadJPEG",

                                "downloadPDF",

                                "downloadSVG"

                            ]

                        }

                    }

                }

            });



            var chartTotalPenduduk;

            var chartTotalKeluarga;

            var chartLahirMati;

            var chartPindah;



            function renderTable(containerId, title, categories, seriesData, filterTahun) {

                var isRange = $('#filter_tahun').val().endsWith('_tahun');

                var html = '<div class="custom-data-table">';

                html += '<table class="table table-bordered table-hover">';

                html += '<caption style="text-align: center; padding: 10px; font-weight: bold; color: #333; caption-side: top;">' + title + '</caption>';

                html += '<thead><tr><th>' + (isRange ? 'Tahun' : 'Bulan') + '</th>';

                

                seriesData.forEach(function(s) {

                    html += '<th>' + s.name + '</th>';

                });

                html += '</tr></thead><tbody>';



                categories.forEach(function(cat, i) {

                    html += '<tr><td>' + cat + '</td>';

                    seriesData.forEach(function(s) {

                        var val = s.data[i] || 0;

                        var link = '#';

                        

                        if (val > 0) {

                            var params = [];

                            if (isRange) {

                                params.push('tahun=' + cat);

                            } else {

                                params.push('tahun=' + filterTahun);

                                params.push('bulan=' + (i + 1));

                            }

                            

                            if (s.code) params.push('peristiwa=' + s.code);

                            link = '{{ site_url('hom_sid/filter_log') }}?' + params.join('&');

                            html += '<td><a href="' + link + '">' + val + '</a></td>';

                        } else {

                            html += '<td>' + val + '</td>';

                        }

                    });

                    html += '</tr>';

                });



                html += '</tbody></table></div>';

                $('#' + containerId).html(html);

            }



            function loadGrafik(tahun) {

                $.ajax({

                    url: '{{ site_url('hom_sid/grafik_kependudukan') }}',

                    type: 'GET',

                    data: { tahun: tahun },

                    dataType: 'json',

                    beforeSend: function() {

                        $('#loading-statistik').show();

                    },

                    success: function(data) {

                        if (chartTotalPenduduk) chartTotalPenduduk.destroy();

                        if (chartTotalKeluarga) chartTotalKeluarga.destroy();

                        if (chartLahirMati) chartLahirMati.destroy();

                        if (chartPindah) chartPindah.destroy();

                        

                        var titleSuffix = tahun.endsWith('_tahun') ? tahun.replace('_tahun', ' Tahun Terakhir') : 'Tahun ' + tahun;

                        

                        chartTotalPenduduk = Highcharts.chart('container-grafik-total-penduduk', {

                            chart: { type: 'areaspline' },

                            title: { text: 'Perkembangan Jumlah Penduduk ' + titleSuffix },

                            xAxis: { categories: data.categories },

                            yAxis: { title: { text: 'Jumlah Penduduk' } },

                            plotOptions: {

                                areaspline: {

                                    dataLabels: { enabled: true },

                                    fillOpacity: 0.5,

                                    threshold: null

                                }

                            },

                            series: [{

                                name: 'Total Penduduk',

                                data: data.total_penduduk,

                                color: '#00c0ef'

                            }]

                        });



                        chartTotalKeluarga = Highcharts.chart('container-grafik-total-keluarga', {

                            chart: { type: 'areaspline' },

                            title: { text: 'Perkembangan Jumlah Keluarga ' + titleSuffix },

                            xAxis: { categories: data.categories },

                            yAxis: { title: { text: 'Jumlah Keluarga' } },

                            plotOptions: {

                                areaspline: {

                                    dataLabels: { enabled: true },

                                    fillOpacity: 0.5,

                                    threshold: null

                                }

                            },

                            series: [{

                                name: 'Total Keluarga',

                                data: data.total_keluarga,

                                color: '#00a65a'

                            }]

                        });



                        chartLahirMati = Highcharts.chart('container-grafik-lahir-mati', {

                            chart: { type: 'areaspline' },

                            title: { text: 'Statistik Kelahiran dan Kematian ' + titleSuffix },

                            xAxis: { categories: data.categories },

                            yAxis: { title: { text: 'Jumlah Peristiwa' } },

                            exporting: {

                                buttons: {

                                    contextButton: {

                                        menuItems: [

                                            "viewFullscreen", "printChart", "separator", "downloadPNG", "downloadJPEG", "downloadPDF", "downloadSVG", "separator", "viewData"

                                        ]

                                    }

                                }

                            },

                            plotOptions: {

                                areaspline: {

                                    dataLabels: { enabled: true },

                                    fillOpacity: 0.5,

                                    point: {

                                        events: {

                                            click: function() {

                                                var isRange = $('#filter_tahun').val().endsWith('_tahun');

                                                var filterTahun = isRange ? this.category : tahun;

                                                var filterBulan = isRange ? 0 : this.x + 1;

                                                var code = this.series.index === 0 ? 1 : 2; // index 0 is Kelahiran, 1 is Kematian

                                                var url = '{{ site_url('hom_sid/filter_log') }}?tahun=' + filterTahun + '&peristiwa=' + code;

                                                if (filterBulan > 0) url += '&bulan=' + filterBulan;

                                                window.location.href = url;

                                            }

                                        }

                                    }

                                }

                            },

                            series: [{

                                name: 'Kelahiran',

                                data: data.kelahiran,

                                color: '#39CCCC'

                            }, {

                                name: 'Kematian',

                                data: data.kematian,

                                color: '#f56954'

                            }]

                        });



                        chartPindah = Highcharts.chart('container-grafik-pindah', {

                            chart: { type: 'areaspline' },

                            title: { text: 'Statistik Pindah Datang dan Pindah Pergi ' + titleSuffix },

                            xAxis: { categories: data.categories },

                            yAxis: { title: { text: 'Jumlah Peristiwa' } },

                            exporting: {

                                buttons: {

                                    contextButton: {

                                        menuItems: [

                                            "viewFullscreen", "printChart", "separator", "downloadPNG", "downloadJPEG", "downloadPDF", "downloadSVG", "separator", "viewData"

                                        ]

                                    }

                                }

                            },

                            plotOptions: {

                                areaspline: {

                                    dataLabels: { enabled: true },

                                    fillOpacity: 0.5,

                                    point: {

                                        events: {

                                            click: function() {

                                                var isRange = $('#filter_tahun').val().endsWith('_tahun');

                                                var filterTahun = isRange ? this.category : tahun;

                                                var filterBulan = isRange ? 0 : this.x + 1;

                                                var code = this.series.index === 0 ? 5 : 3; // index 0 is Datang, 1 is Pergi

                                                var url = '{{ site_url('hom_sid/filter_log') }}?tahun=' + filterTahun + '&peristiwa=' + code;

                                                if (filterBulan > 0) url += '&bulan=' + filterBulan;

                                                window.location.href = url;

                                            }

                                        }

                                    }

                                }

                            },

                            series: [{

                                name: 'Pindah Datang',

                                data: data.pindah_datang,

                                color: '#00a65a'

                            }, {

                                name: 'Pindah Pergi',

                                data: data.pindah_pergi,

                                color: '#f39c12'

                            }]

                        });



                        // Render custom clickable tables

                        renderTable('table-lahir-mati', 'Statistik Kelahiran dan Kematian', data.categories, [

                            { name: 'Kelahiran', data: data.kelahiran, code: 1 },

                            { name: 'Kematian', data: data.kematian, code: 2 }

                        ], tahun);



                        renderTable('table-pindah', 'Statistik Pindah Datang dan Pindah Pergi', data.categories, [

                            { name: 'Pindah Datang', data: data.pindah_datang, code: 5 },

                            { name: 'Pindah Pergi', data: data.pindah_pergi, code: 3 }

                        ], tahun);

                    },

                    complete: function() {

                        $('#loading-statistik').hide();

                    }

                });

            }



            loadGrafik($('#filter_tahun').val());

            $('#filter_tahun').change(function() {

                loadGrafik($(this).val());

            });

        });

    </script>

@endpush

