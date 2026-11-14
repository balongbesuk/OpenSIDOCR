@extends('admin.layouts.index')

@push('css')
    <style>
        .radius {
            border-radius: 5px;
        }

        /* Standarisasi SDGs: Rangkuman Rata-Rata */
        .sdgs-summary-card {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.06);
            padding: 16px 20px;
            text-align: center;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        .sdgs-summary-score {
            font-size: 32px;
            font-weight: 800;
            color: #0f172a;
            line-height: 1.1;
        }

        .sdgs-summary-label {
            font-size: 13px;
            font-weight: 600;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-top: 6px;
        }

        /* Opsi A: Galeri Grid 2 Kolom di Mobile, 3 di Tablet, 4 di Desktop */
        .row-sdgs-grid {
            margin-left: -5px !important;
            margin-right: -5px !important;
            display: flex !important;
            flex-wrap: wrap !important;
        }

        .col-sdgs-item {
            padding-left: 5px !important;
            padding-right: 5px !important;
            margin-bottom: 10px !important;
            display: flex !important;
        }

        .sdgs-card {
            width: 100% !important;
            background: #ffffff !important;
            border: 1px solid #e2e8f0 !important;
            border-radius: 8px !important;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05) !important;
            padding: 10px 8px !important;
            display: flex !important;
            flex-direction: column !important;
            align-items: center !important;
            justify-content: space-between !important;
            text-align: center !important;
            transition: transform 0.15s ease, box-shadow 0.15s ease !important;
        }

        .sdgs-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.08) !important;
        }

        .sdgs-logo-wrap {
            width: 72px !important;
            height: 72px !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            margin-bottom: 6px !important;
        }

        .sdgs-logo-img {
            max-width: 100% !important;
            max-height: 100% !important;
            width: auto !important;
            height: auto !important;
            border-radius: 6px !important;
            object-fit: contain !important;
        }

        .sdgs-card-content {
            width: 100% !important;
        }

        .sdgs-score {
            font-size: 20px !important;
            font-weight: 800 !important;
            color: #0f172a !important;
            line-height: 1.15 !important;
        }

        .sdgs-label {
            font-size: 10.5px !important;
            font-weight: 600 !important;
            color: #64748b !important;
            text-transform: uppercase !important;
            letter-spacing: 0.5px !important;
            margin-top: 2px !important;
        }

        @media (max-width: 767px) {
            .sdgs-summary-card {
                padding: 12px 14px;
            }

            .sdgs-summary-score {
                font-size: 26px;
            }

            .sdgs-summary-label {
                font-size: 11px;
            }

            .sdgs-logo-wrap {
                width: 60px !important;
                height: 60px !important;
                margin-bottom: 4px !important;
            }

            .sdgs-score {
                font-size: 18px !important;
            }

            .sdgs-label {
                font-size: 9.5px !important;
            }

            .sdgs-card {
                padding: 8px 6px !important;
            }
        }
    </style>
@endpush

@section('title')
    <h1>
        Status SDGS Desa
    </h1>
@endsection

@section('breadcrumb')
    <li class="active">Status SDGS Desa</li>
@endsection

@section('content')

    @include('admin.layouts.components.notifikasi')

    @include('admin.status_desa.navigasi')

    <div class="box box-info">
        @if (can('u'))
            <div class="box-header with-border">
                <a class="btn btn-social btn-success btn-sm visible-xs-block visible-sm-inline-block visible-md-inline-block visible-lg-inline-block"
                    {!! !cek_koneksi_internet() ? 'disabled title="Perangkat tidak terhubung dengan jaringan"' : 'id="perbarui"' !!}><i class="fa fa-refresh"></i>Perbarui {{ $header ?? 'SDGs' }}</a>
            </div>
        @endif
        <div class="box-body">
            @if (!empty($sdgs->error_msg))
                <div class="alert alert-danger">
                    {!! $sdgs->error_msg !!}
                </div>
            @else
                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12" style="margin-bottom: 12px;">
                        <div class="sdgs-summary-card">
                            <div class="sdgs-summary-score">{{ $sdgs->average }}</div>
                            <div class="sdgs-summary-label">Skor Rata-Rata SDGs {{ setting('sebutan_desa') }}</div>
                        </div>
                    </div>
                </div>

                <div class="row row-sdgs-grid">
                    @foreach ($sdgs->data as $key => $value)
                        <div class="col-lg-3 col-md-4 col-sm-6 col-xs-6 col-sdgs-item">
                            <div class="sdgs-card">
                                <div class="sdgs-logo-wrap">
                                    <img class="sdgs-logo-img" src="{{ asset("images/sdgs/{$value->image}") }}"
                                        alt="{{ $value->image }}">
                                </div>
                                <div class="sdgs-card-content">
                                    <div class="sdgs-score">{{ $value->score }}</div>
                                    <div class="sdgs-label">Nilai</div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
@endsection

@if (can('u'))
    @push('scripts')
        <script type="text/javascript">
            $(document).ready(function() {
                var server_pantau = "{{ config_item('server_pantau') }}";
                var token_pantau = "{{ config_item('token_pantau') }}";
                var kode_desa = "{{ $kode_desa }}";

                $('#perbarui').click(function(event) {
                    event.preventDefault;
                    Swal.fire({
                        title: 'Sedang Memproses',
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        showConfirmButton: false,
                        didOpen: () => {
                            Swal.showLoading()
                        }
                    });
                    $.ajax({
                            type: 'GET',
                            url: server_pantau + '/index.php/api/wilayah/kodedesa?token=' + token_pantau +
                                '&kode=' + kode_desa,
                            dataType: 'json',
                        })
                        .done(function(response) {
                            $.ajax({
                                    url: '{{ route('status_desa.perbarui_bps') }}',
                                    type: 'Post',
                                    dataType: 'json',
                                    data: {
                                        'kode_bps': response.bps_kemendagri_desa.kode_desa_bps
                                    }
                                })
                                .done(function(value) {
                                    if (value.status) {
                                        location.replace('{{ route('status_desa.perbarui_sdgs') }}')
                                    } else {
                                        Swal.fire({
                                            icon: 'error',
                                            text: value.message,
                                            showCloseButton: false
                                        })
                                    }
                                })
                                .fail(function(e) {
                                    Swal.fire({
                                        icon: 'error',
                                        text: e,
                                        showCloseButton: false
                                    })
                                });
                        })
                        .fail(function(e) {
                            Swal.fire({
                                icon: 'error',
                                text: e,
                                showCloseButton: false
                            })
                        });
                });
            });
        </script>
    @endpush
@endif
