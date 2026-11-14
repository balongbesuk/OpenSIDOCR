@extends('admin.layouts.index')

@push('css')
    <style>
        .row-idm-cards {
            margin-left: -5px !important;
            margin-right: -5px !important;
            display: flex !important;
            flex-wrap: wrap !important;
        }

        .col-idm-card {
            padding-left: 5px !important;
            padding-right: 5px !important;
            margin-bottom: 10px !important;
            display: flex !important;
        }

        .idm-card {
            width: 100% !important;
            border-radius: 8px !important;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.08) !important;
            margin-bottom: 0 !important;
            position: relative !important;
            overflow: hidden !important;
            display: flex !important;
            flex-direction: column !important;
            justify-content: center !important;
            text-align: center !important;
            min-height: 80px !important;
        }

        .idm-card .inner {
            padding: 12px 8px !important;
            position: relative !important;
            z-index: 2 !important;
        }

        .idm-card .idm-val {
            font-size: 22px !important;
            font-weight: 700 !important;
            line-height: 1.15 !important;
            color: #ffffff !important;
            white-space: nowrap !important;
        }

        .idm-card .idm-status-text {
            font-size: 16px !important;
            letter-spacing: 0.5px !important;
            font-weight: 800 !important;
        }

        .idm-card .idm-lbl {
            font-size: 11px !important;
            font-weight: 600 !important;
            text-transform: uppercase !important;
            letter-spacing: 0.5px !important;
            color: rgba(255, 255, 255, 0.92) !important;
            margin-top: 4px !important;
            line-height: 1.25 !important;
        }

        .idm-card .icon {
            position: absolute !important;
            right: 8px !important;
            top: 8px !important;
            font-size: 38px !important;
            color: rgba(0, 0, 0, 0.15) !important;
            z-index: 1 !important;
            pointer-events: none !important;
        }

        @media (max-width: 767px) {
            .idm-card .idm-val {
                font-size: 19px !important;
            }
            .idm-card .idm-status-text {
                font-size: 15px !important;
            }
            .idm-card .idm-lbl {
                font-size: 10px !important;
            }
            .idm-card {
                min-height: 72px !important;
            }
            .idm-card .inner {
                padding: 10px 6px !important;
            }
        }
    </style>
@endpush

@section('title')
    <h1>
        Status IDM Desa
    </h1>
@endsection

@section('breadcrumb')
    <li class="active">Status IDM Desa</li>
@endsection

@section('content')

    @include('admin.layouts.components.notifikasi')

    @include('admin.status_desa.navigasi')

    <div class="box box-info">
        <div class="box-header with-border">
            {!! form_open(route('status_desa'), 'class="form-inline" id="mainform" name="mainform"') !!}
            <label for="tahun">IDM Tahun </label>
            <select class="form-control input-sm" name="tahun" onchange="$('#mainform').submit()">
                <option value="" disabled>Pilih Tahun</option>
                @foreach (tahun(2020) as $thn)
                    <option value="{{ $thn }}" @selected($tahun === $thn)>{{ $thn }}</option>
                @endforeach
            </select>
            @if (can('u'))
                <a class="btn btn-social btn-success btn-sm visible-xs-block visible-sm-inline-block visible-md-inline-block visible-lg-inline-block"
                    {!! cek_koneksi_internet() == false || !empty($idm->error_msg)
                        ? 'disabled title="Perangkat tidak terhubung dengan jaringan"'
                        : 'href="' . route('status_desa.perbarui_idm', $tahun) . '"' !!}><i class="fa fa-refresh"></i>Perbarui</a>
                @if (empty($idm->error_msg))
                    <a class="btn btn-social btn-info btn-sm visible-xs-block visible-sm-inline-block visible-md-inline-block visible-lg-inline-block"
                        href="{{ route('status_desa.simpan', $tahun) }}"><i class="fa fa-check-circle"></i>Simpan</a>
                @endif
            @endif
            </form>
        </div>
        <div class="box-body">
            @if (!empty($idm->error_msg))
                <div class="alert alert-danger">
                    {!! $idm->error_msg !!}
                </div>
            @else
                <div class="row">
                    <div class="col-lg-6 col-xs-12">
                        <div class="row row-idm-cards">
                            <div class="col-lg-6 col-sm-6 col-xs-6 col-idm-card">
                                <div class="small-box bg-blue idm-card">
                                    <div class="inner">
                                        <div class="idm-val">{{ number_format($idm->SUMMARIES->SKOR_SAAT_INI, 4) }}</div>
                                        <div class="idm-lbl">SKOR IDM SAAT INI</div>
                                    </div>
                                    <div class="icon">
                                        <i class="fa fa-line-chart"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-6 col-xs-6 col-idm-card">
                                <div class="small-box bg-yellow idm-card">
                                    <div class="inner">
                                        <div class="idm-val idm-status-text">{{ $idm->SUMMARIES->STATUS }}</div>
                                        <div class="idm-lbl">STATUS IDM</div>
                                    </div>
                                    <div class="icon">
                                        <i class="fa fa-trophy"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-6 col-xs-6 col-idm-card">
                                <div class="small-box bg-red idm-card">
                                    <div class="inner">
                                        <div class="idm-val">{{ number_format($idm->SUMMARIES->SKOR_MINIMAL, 4) }}</div>
                                        <div class="idm-lbl">SKOR IDM MINIMAL</div>
                                    </div>
                                    <div class="icon">
                                        <i class="fa fa-pie-chart"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-6 col-xs-6 col-idm-card">
                                <div class="small-box bg-green idm-card">
                                    <div class="inner">
                                        <div class="idm-val idm-status-text">{{ $idm->SUMMARIES->TARGET_STATUS }}</div>
                                        <div class="idm-lbl">TARGET STATUS</div>
                                    </div>
                                    <div class="icon">
                                        <i class="fa fa-bullseye"></i>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-12 col-xs-12" style="padding-left: 5px; padding-right: 5px; margin-top: 5px;">
                                <div class="table-responsive" style="border-radius: 6px; border: 1px solid #e2e8f0; box-shadow: 0 1px 3px rgba(0,0,0,0.05);">
                                    <table class="table table-bordered table-striped dataTable table-hover" style="margin-bottom: 0;">
                                        <tbody>
                                            <tr>
                                                <td width="35%" style="font-weight: 600; color: #475569; font-size: 12.5px; padding: 9px 12px;">PROVINSI</td>
                                                <td width="1" style="padding: 9px 4px;">:</td>
                                                <td style="font-weight: 600; color: #1e293b; font-size: 13px; padding: 9px 12px;">{{ $idm->IDENTITAS[0]->nama_provinsi }}</td>
                                            </tr>
                                            <tr>
                                                <td style="font-weight: 600; color: #475569; font-size: 12.5px; padding: 9px 12px;">KABUPATEN</td>
                                                <td style="padding: 9px 4px;">:</td>
                                                <td style="font-weight: 600; color: #1e293b; font-size: 13px; padding: 9px 12px;">{{ $idm->IDENTITAS[0]->nama_kab_kota }}</td>
                                            </tr>
                                            <tr>
                                                <td style="font-weight: 600; color: #475569; font-size: 12.5px; padding: 9px 12px;">{{ strtoupper($setting->sebutan_kecamatan) }}</td>
                                                <td style="padding: 9px 4px;">:</td>
                                                <td style="font-weight: 600; color: #1e293b; font-size: 13px; padding: 9px 12px;">{{ $idm->IDENTITAS[0]->nama_kecamatan }}</td>
                                            </tr>
                                            <tr>
                                                <td style="font-weight: 600; color: #475569; font-size: 12.5px; padding: 9px 12px;">{{ strtoupper($setting->sebutan_desa) }}</td>
                                                <td style="padding: 9px 4px;">:</td>
                                                <td style="font-weight: 600; color: #1e293b; font-size: 13px; padding: 9px 12px;">{{ $idm->IDENTITAS[0]->nama_desa }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6 col-xs-12">
                        <figure class="highcharts-figure">
                            <div id="container"></div>
                        </figure>
                    </div>
                </div>

                <div class="row">
                    <hr>
                </div>

                <div class="row">
                    <div class="col-sm-12">
                        <div class="table-responsive">
                            <table class="table table-bordered dataTable table-striped table-hover tabel-daftar">
                                <thead class="bg-gray color-palette">
                                    <tr>
                                        <th rowspan="2" class="padat">NO</th>
                                        <th rowspan="2">INDIKATOR IDM</th>
                                        <th rowspan="2">SKOR</th>
                                        <th rowspan="2">KETERANGAN</th>
                                        <th rowspan="2" nowrap>KEGIATAN YANG DAPAT DILAKUKAN</th>
                                        <th rowspan="2">+NILAI</th>
                                        <th colspan="6" class="text-center">YANG DAPAT MELAKSANAKAN KEGIATAN</th>
                                    </tr>
                                    <tr>
                                        <th>PUSAT</th>
                                        <th>PROVINSI</th>
                                        <th>KABUPATEN</th>
                                        <th>DESA</th>
                                        <th>CSR</th>
                                        <th>LAINNYA</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($idm->ROW as $data)
                                        <tr class="{{ empty($data->NO) ? 'judul' : '' }}">
                                            <td class="text-center">{{ $data->NO }}</td>
                                            <td style="min-width: 150px;">{{ $data->INDIKATOR }}</td>
                                            <td class="padat">{{ $data->SKOR }}</td>
                                            <td style="min-width: 250px;">{{ $data->KETERANGAN }}</td>
                                            <td>{{ $data->KEGIATAN }}</td>
                                            <td class="padat">{{ $data->NILAI }}</td>
                                            <td>{{ $data->PUSAT }}</td>
                                            <td>{{ $data->PROV }}</td>
                                            <td>{{ $data->KAB }}</td>
                                            <td>{{ $data->DESA }}</td>
                                            <td>{{ $data->CSR }}</td>
                                            <td>{{ $data->LAINNYA }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

@endsection

@if (empty($idm->error_msg))
    @push('scripts')
        @include('admin.layouts.components.asset_highcharts')
        <script>
            $(document).ready(function() {

                var tahun = {{ $tahun ?? date('Y') }};
                var iks = {{ $idm->ROW[35]->SKOR ?? 0 }};
                var ike = {{ $idm->ROW[48]->SKOR ?? 0 }};
                var ikl = {{ $idm->ROW[52]->SKOR ?? 0 }};

                Highcharts.chart('container', {
                    chart: {
                        type: 'pie',
                        options3d: {
                            enabled: true,
                            alpha: 45
                        }
                    },
                    title: {
                        text: 'Indeks Desa Membangun (IDM) ' + tahun
                    },
                    subtitle: {
                        text: 'SKOR : IKS, IKE, IKL'
                    },

                    plotOptions: {
                        series: {
                            colorByPoint: true
                        },
                        pie: {
                            allowPointSelect: true,
                            cursor: 'pointer',
                            showInLegend: true,
                            depth: 45,
                            innerSize: 70,
                            dataLabels: {
                                enabled: true,
                                format: '<b>{point.name}</b>: {point.y:,.2f} / {point.percentage:.1f} %'
                            }
                        }
                    },
                    series: [{
                        name: 'SKOR',
                        shadow: 1,
                        border: 1,
                        data: [
                            ['IKS', iks],
                            ['IKE', ike],
                            ['IKL', ikl]
                        ]
                    }]
                });
            });
        </script>
    @endpush
@endif
