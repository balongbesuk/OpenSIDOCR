@include('admin.layouts.components.asset_validasi')
@include('admin.layouts.components.asset_datatables')

@extends('admin.layouts.index')

@section('title')
    <h1>
        Daftar Surat
        <small>{{ $action }} Format Surat RTF</small>
    </h1>
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('surat_master') }}">Daftar Surat</a></li>
    <li class="active">{{ $action }} Format Surat RTF</li>
@endsection

@section('content')
    @include('admin.layouts.components.notifikasi')

    {!! form_open($formAction, 'id="validasi" enctype="multipart/form-data"') !!}
    <div class="box box-info">
        <div class="box-header with-border">
            <a href="{{ route('surat_master') }}"
                class="btn btn-social btn-info btn-sm visible-xs-block visible-sm-inline-block visible-md-inline-block visible-lg-inline-block">
                <i class="fa fa-arrow-circle-left"></i>Kembali ke Daftar Surat
            </a>
        </div>
        <div class="box-body form-horizontal">
            <div class="form-group">
                <label class="col-sm-3 control-label" for="kode_surat">Kode/Klasifikasi Surat</label>
                <div class="col-sm-7">
                    <select class="form-control input-sm required" id="kode_surat" name="kode_surat"
                        data-placeholder="-- Pilih Kode/Klasifikasi Surat --">
                        @if ($klasifikasiSurat)
                            <option value="{{ $klasifikasiSurat->kode }}">
                                {{ $klasifikasiSurat->kode . ' - ' . $klasifikasiSurat->nama }}</option>
                        @endif
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-3 control-label">Nama Layanan</label>
                <div class="col-sm-7">
                    <div class="input-group">
                        <span class="input-group-addon input-sm">Surat</span>
                        <input type="text" class="form-control input-sm nama_terbatas required" id="nama"
                            name="nama" placeholder="Nama Layanan (contoh: Keterangan Domisili Usaha)" value="{{ $suratMaster->nama }}" />
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-3 control-label" for="pemohon_surat">Pemohon Surat</label>
                <div class="col-sm-3">
                    <select class="form-control input-sm" id="pemohon_surat" name="pemohon_surat">
                        <option value="warga" selected>Warga</option>
                        <option value="non_warga">Bukan Warga</option>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-3 control-label" for="masa_berlaku">Masa Berlaku Default</label>
                <div class="col-sm-6">
                    <div class="row">
                        <div class="col-sm-3">
                            <input type="number" class="form-control input-sm" id="masa_berlaku" name="masa_berlaku"
                                value="{{ $suratMaster->masa_berlaku ?? 1 }}" min="0" max="31">
                        </div>
                        <div class="col-sm-4">
                            <select class="form-control input-sm" id="satuan_masa_berlaku" name="satuan_masa_berlaku">
                                @foreach ($masaBerlaku as $kode_masa => $judul_masa)
                                    <option value="{{ $kode_masa }}" @selected(($suratMaster->satuan_masa_berlaku ?? 'M') === $kode_masa)>
                                        {{ $judul_masa }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <label class="text-muted text-red">Isi 0 jika tidak digunakan dan maksimal 31.</label>
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-3 control-label" for="surat">Unggah Template RTF (Opsional)</label>
                <div class="col-sm-7">
                    <div class="input-group input-group-sm">
                        <input type="text" class="form-control" id="file_path" readonly placeholder="Pilih berkas .rtf jika ada">
                        <input type="file" class="hidden" id="file" name="surat" accept=".rtf">
                        <span class="input-group-btn">
                            <button type="button" class="btn btn-info" id="file_browser"><i class="fa fa-search"></i>&nbsp;Browse</button>
                        </span>
                    </div>
                    <p class="help-block"><small class="text-muted">Jika dikosongkan, OpenSID akan otomatis menggunakan template RTF standar di folder <code>desa/template-surat/</code>.</small></p>
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-3 control-label" for="mandiri">Sediakan di Layanan Mandiri</label>
                <div class="btn-group col-xs-12 col-sm-8" data-toggle="buttons">
                    <label id="m1"
                        class="tipe btn btn-info btn-sm col-xs-12 col-sm-6 col-lg-2 form-check-label @active($suratMaster->mandiri)">
                        <input id="g1" type="radio" name="mandiri" class="form-check-input" type="radio"
                            value="1" @checked($suratMaster->mandiri) autocomplete="off">Ya
                    </label>
                    <label id="m2"
                        class="tipe btn btn-info btn-sm col-xs-12 col-sm-6 col-lg-2 form-check-label @active(!$suratMaster->mandiri)">
                        <input id="g2" type="radio" name="mandiri" class="form-check-input" type="radio"
                            value="0" @checked(!$suratMaster->mandiri) autocomplete="off">Tidak
                    </label>
                </div>
            </div>

            <div class="form-group" id="syarat" {{ jecho($suratMaster->mandiri, false, 'style="display:none;"') }}>
                <label class="col-sm-3 control-label">Syarat Surat</label>
                <div class="col-sm-7">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover" id="tabeldata" style="width: 100%;">
                            <thead>
                                <tr>
                                    <th><input type="checkbox" id="checkall" /></th>
                                    <th>NO</th>
                                    <th>NAMA DOKUMEN</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="box-footer">
            <a href="{{ route('surat_master') }}" class="btn btn-social btn-danger btn-sm">
                <i class="fa fa-times"></i> Batal
            </a>
            <button type="submit" class="btn btn-social bg-purple btn-sm pull-right">
                <i class="fa fa-check"></i> Simpan Format RTF
            </button>
        </div>
    </div>
    </form>
@endsection

@push('scripts')
    <script>
        function syarat(mandiri) {
            if (mandiri == 1) {
                $('#syarat').show();
            } else {
                $('#syarat').hide();
            }
        }

        $(document).ready(function() {
            syarat($('input[name=mandiri]:checked').val());
            $('input[name="mandiri"]').change(function() {
                syarat($(this).val());
            });

            $('#file_browser').click(function(e) {
                e.preventDefault();
                $('#file').click();
            });

            $('#file').change(function() {
                $('#file_path').val($(this).val().replace(/C:\\fakepath\\/i, ''));
            });

            $('#checkall').click(function() {
                $('.checkall').prop('checked', this.checked);
            });
        });

        $('#kode_surat').select2({
            tags: true,
            ajax: {
                url: SITE_URL + 'surat_master/apisurat',
                dataType: 'json',
                data: function(params) {
                    return {
                        q: params.term || '',
                        page: params.page || 1,
                    };
                },
                cache: true
            },
            placeholder: function() {
                return $(this).data('placeholder');
            },
            minimumInputLength: 1,
            allowClear: true,
            escapeMarkup: function(markup) {
                return markup;
            },
            createTag: function(params) {
                var term = params.term.substring(0, 10);
                return {
                    id: term,
                    text: term,
                    newOption: true
                };
            },
            templateResult: function(data) {
                var $result = $("<span></span>").text(data.text);
                if (data.newOption) {
                    $result.append(" <em>(Buat Baru, maksimal 10 karakter)</em>");
                }
                return $result;
            },
            insertTag: function(data, tag) {
                data.push(tag);
            }
        });

        var TableData = $('#tabeldata').DataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            bPaginate: false,
            ajax: "{{ route('surat_master.syaratsuratdatatables') }}",
            columns: [{
                    data: 'ceklist',
                    class: 'padat',
                    searchable: false,
                    orderable: false
                },
                {
                    data: 'DT_RowIndex',
                    class: 'padat',
                    searchable: false,
                    orderable: false
                },
                {
                    data: 'ref_syarat_nama',
                    name: 'ref_syarat_nama',
                    searchable: true,
                    orderable: true
                },
            ],
            order: [
                [2, 'asc']
            ]
        });
    </script>
@endpush