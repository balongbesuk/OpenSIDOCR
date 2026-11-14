@include('admin.layouts.components.datetime_picker')
@include('admin.layouts.components.asset_datatables')
@extends('admin.layouts.index')

@section('title')
    <h1>Optimasi Gambar</h1>
@endsection

@section('breadcrumb')
    <li class="active">Optimasi Gambar</li>
@endsection

@push('css')
<style type="text/css">
    @media (max-width: 767px) {
        .optimasi-tree-depth-0 { padding-left: 8px !important; }
        .optimasi-tree-depth-1 { padding-left: 20px !important; }
        .optimasi-tree-depth-2 { padding-left: 32px !important; }
        .optimasi-tree-depth-3 { padding-left: 44px !important; }
        .optimasi-btn-col { width: 95px !important; min-width: 95px !important; padding: 6px 4px !important; }
        .optimasi-btn-col .btn-social {
            padding-left: 28px !important;
            padding-right: 4px !important;
            font-size: 11.5px !important;
            height: 32px !important;
            line-height: 30px !important;
        }
        .optimasi-btn-col .btn-social > :first-child {
            width: 24px !important;
            line-height: 30px !important;
            font-size: 12px !important;
        }
        .optimasi-table td {
            font-size: 12.5px !important;
        }
    }
    @media (min-width: 768px) {
        .optimasi-tree-depth-0 { padding-left: 14px !important; }
        .optimasi-tree-depth-1 { padding-left: 36px !important; }
        .optimasi-tree-depth-2 { padding-left: 58px !important; }
        .optimasi-tree-depth-3 { padding-left: 80px !important; }
        .optimasi-btn-col { width: 165px !important; min-width: 165px !important; }
    }
</style>
@endpush

@section('content')
    @include('admin.layouts.components.notifikasi')

    <div class="box box-info">
        <div class="box-header with-border">
            <h3 class="box-title"><strong>Ubah Ukuran Gambar</strong></h3>
        </div>
        <div class="box-body">
            <div class="row">
                <div class="col-sm-12 col-md-10 col-lg-9">
                    <div class="table-responsive" style="border: none; margin-bottom: 0;">
                        <table class="table table-bordered table-striped optimasi-table" style="margin-bottom: 0;">
                            <thead>
                                <tr class="bg-gray-light">
                                    <th style="vertical-align: middle;">Direktori / Folder Penyimpanan</th>
                                    <th class="optimasi-btn-col text-center" style="vertical-align: middle;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr style="background-color: #f0fdf4;">
                                    <td class="optimasi-tree-depth-0" style="vertical-align: middle;">
                                        <strong><i class="fa fa-folder-open text-green" style="margin-right: 6px;"></i> desa/upload/</strong>
                                        <span class="badge bg-green" style="margin-left: 6px; font-weight: normal; font-size: 10.5px;">Semua Folder</span>
                                    </td>
                                    <td class="optimasi-btn-col text-center" style="vertical-align: middle;">
                                        @if (can('u'))
                                            <button type="button"
                                                class="btn btn-social btn-flat btn-block btn-success btn-sm resize-all"
                                                title="Resize Seluruh Gambar">
                                                <i class="fa fa-picture-o"></i>
                                                <span class="hidden-xs">Resize Semua</span>
                                                <span class="visible-xs-inline">Semua</span>
                                            </button>
                                        @endif
                                    </td>
                                </tr>
                                @foreach ($folders as $dir)
                                    @php
                                        $depth = is_array($dir) ? $dir['depth'] : 0;
                                        $path  = is_array($dir) ? $dir['path'] : $dir;
                                        $name  = is_array($dir) ? $dir['name'] : $dir;
                                    @endphp
                                    <tr>
                                        <td class="optimasi-tree-depth-{{ min($depth, 3) }}" style="vertical-align: middle;">
                                            @if ($depth > 0)
                                                <span class="text-muted" style="font-family: monospace; font-size: 12px; margin-right: 4px;">└──</span>
                                                <i class="fa fa-folder-open-o text-yellow" style="margin-right: 5px;"></i>
                                                <span class="text-muted hidden-xs">{{ dirname($path) }}/</span><b>{{ $name }}/</b>
                                                <span class="label label-default hidden-xs" style="font-size: 9.5px; margin-left: 6px; font-weight: normal;">Subfolder</span>
                                            @else
                                                <i class="fa fa-folder text-yellow" style="margin-right: 6px;"></i>
                                                <b>{{ $name }}/</b>
                                            @endif
                                        </td>
                                        <td class="optimasi-btn-col text-center" style="vertical-align: middle;">
                                            @if (can('u'))
                                                <button data-dir="{{ $path }}" type="button"
                                                    class="btn btn-social btn-flat btn-block btn-info btn-sm resize"
                                                    title="Resize Gambar: {{ $path }}">
                                                    <i class="fa fa-picture-o"></i>
                                                    <span class="hidden-xs">Resize Gambar</span>
                                                    <span class="visible-xs-inline">Resize</span>
                                                </button>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="callout callout-info" style="margin-top: 15px; margin-bottom: 0;">
                        <p><i class="fa fa-info-circle"></i> Proses <strong>Resize</strong> hanya mengubah ukuran gambar yang melebihi batas resolusi lebar <strong>880px</strong> dan tinggi <strong>880px</strong> secara proporsional.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script type="text/javascript">
        $(function() {
            $('.resize').click(function(event) {
                var dir = $(this).data('dir');
                Swal.fire({
                    title: 'Ubah ukuran gambar di folder ' + dir,
                    showCancelButton: true,
                    confirmButtonText: 'Ok',
                    cancelButtonText: 'Batal',
                }).then((result) => {
                    if (result.isConfirmed) {
                        periksa(dir);
                    }
                })
            });

            $('.resize-all').click(function(event) {
                Swal.fire({
                    title: 'Ubah ukuran gambar di seluruh folder upload',
                    showCancelButton: true,
                    confirmButtonText: 'Ok',
                    cancelButtonText: 'Batal',
                }).then((result) => {
                    if (result.isConfirmed) {
                        periksa('');
                    }
                })
            });

            periksa = function(dir = '') {
                Swal.fire({
                    title: 'Sedang Memeriksa',
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    showConfirmButton: false,
                    didOpen: () => {
                        Swal.showLoading()
                    }
                });

                var url = "{{ route('optimasi_gambar.get_image') }}";
                if (dir) {
                    url += '/' + dir;
                }

                $.ajax({
                        url: url,
                        dataType: 'json',
                    })
                    .done(function(files) {
                        if (files.status == true) {
                            if (!files.data || files.data.length === 0) {
                                Swal.fire('Tidak ada gambar yang perlu diubah ukurannya (> 880px).', '', 'info');
                                return;
                            }
                            Swal.fire({
                                title: 'Sedang mengoptimasi gambar',
                                html: ` `,
                                allowOutsideClick: false,
                                didOpen: () => {
                                    Swal.showLoading();
                                    resize_gambar(files.data);
                                },
                            })
                        }
                    })
                    .fail(function(error) {
                        Swal.fire('Gagal memeriksa gambar.', '', 'warning');
                    });
            }
        });

        resize_gambar = async (files) => {
            var length = files.length;
            for (var i = 1; i < (length + 1); i++) {
                await $.ajax({
                        url: '{{ route('optimasi_gambar.resize') }}',
                        type: 'POST',
                        dataType: 'json',
                        data: {
                            'file': files[i - 1]
                        },
                    })
                    .done(function() {
                        $('#swal2-html-container').html(
                            `<div class="progress-bar" role="progressbar" aria-valuenow="${(i/length)*100}" aria-valuemin="0" aria-valuemax="100" style="width: ${(i/length)*100}%;">${i}/${length}</div>`
                        );
                    })
                    .fail(function(error) {
                        Swal.fire(error.responseText || 'Gagal mengubah ukuran gambar', '', 'warning');
                        return;
                    });
            }
            Swal.fire('Optimasi gambar selesai', '', 'success');
        }
    </script>
@endpush
