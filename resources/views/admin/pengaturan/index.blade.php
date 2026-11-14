@include('admin.layouts.components.asset_validasi')
@include('admin.layouts.components.asset_datatables')

@extends('admin.layouts.index')

@section('title')
<h1>
    {{ $judul }}
</h1>
@endsection

@section('breadcrumb')
<li class="active">{{ $judul }}</li>
@endsection

@section('content')
@include('admin.layouts.components.notifikasi')
<div class="row">

    {!! form_open_multipart(route('setting.new_update'), 'id="validasi" class="form-horizontal"') !!}
    @if ($atur_latar)
    <div class="col-md-3">
        @if (in_array('sistem', $pengaturan_kategori))
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title"><strong>Latar Website</strong></h3>
            </div>
            <div class="box-body box-profile text-center">
                <a href="<?= site_url("setting/ambil_foto?foto={$latar_website[0]}&pengaturan={$latar_website[1]}"); ?>" class="progressive replace">
                    <img class="preview" loading="lazy" src="<?= base_url('assets/images/img-loader.gif') ?>" alt="Latar Website" width="100%" style="border-radius: 6px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); margin-bottom: 8px; border: 1px solid #e2e8f0;" />
                </a>
                <p class="text-muted text-center text-red">(Kosongkan, jika latar website tidak berubah)</p>
                <div class="input-group">
                    <input type="text" class="form-control" id="file_path" name="latar_website" placeholder="Pilih berkas..." readonly style="cursor: pointer; background-color: #ffffff;">
                    <span class="input-group-btn">
                        <button type="button" class="btn btn-info btn-flat" id="file_browser"><i class="fa fa-folder-open"></i> Browse</button>
                    </span>
                </div>
                <input type="file" class="hidden" id="file" name="latar_website" accept=".jpg,.jpeg,.png" />
                <input type="text" class="hidden" name="lokasi" value="{{ $lokasi }}" />
            </div>
        </div>
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title"><strong>Latar Login Admin</strong></h3>
            </div>
            <div class="box-body box-profile text-center">
                <a href="<?= site_url("setting/ambil_foto?foto={$latar_siteman[0]}&pengaturan={$latar_siteman[1]}"); ?>" class="progressive replace">
                    <img class="preview" loading="lazy" src="<?= base_url('assets/images/img-loader.gif') ?>" alt="Latar Login Admin" width="100%" style="border-radius: 6px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); margin-bottom: 8px; border: 1px solid #e2e8f0;" />
                </a>
                <p class="text-muted text-center text-red">(Kosongkan, jika latar login tidak berubah)</p>
                <div class="input-group">
                    <input type="text" class="form-control" id="file_path1" name="latar_login" placeholder="Pilih berkas..." readonly style="cursor: pointer; background-color: #ffffff;" />
                    <span class="input-group-btn">
                        <button type="button" class="btn btn-info btn-flat" id="file_browser1"><i class="fa fa-folder-open"></i> Browse</button>
                    </span>
                </div>
                <input type="file" class="hidden" id="file1" name="latar_login" accept=".jpg,.jpeg,.png" />
            </div>
        </div>
        @endif
        @if (in_array('setting_mandiri', $pengaturan_kategori))
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title"><strong>Latar Login Mandiri</strong></h3>
            </div>
            <div class="box-body box-profile text-center">
                    <a href="<?= site_url("setting/ambil_foto?foto={$latar_mandiri[0]}&pengaturan={$latar_mandiri[1]}"); ?>" class="progressive replace">
                        <img class="preview" loading="lazy" src="<?= base_url('assets/images/img-loader.gif') ?>" alt="Latar Login Mandiri" width="100%" style="border-radius: 6px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); margin-bottom: 8px; border: 1px solid #e2e8f0;" />
                    </a>
                    <p class="text-muted text-center text-red">(Kosongkan, jika latar login tidak berubah)</p>
                    <div class="input-group">
                        <input type="text" class="form-control" id="file_path2" name="latar_login_mandiri" placeholder="Pilih berkas..." readonly style="cursor: pointer; background-color: #ffffff;" />
                        <span class="input-group-btn">
                            <button type="button" class="btn btn-info btn-flat" id="file_browser2"><i class="fa fa-folder-open"></i> Browse</button>
                        </span>
                    </div>
                    <input type="file" class="hidden" id="file2" name="latar_login_mandiri" accept=".jpg,.jpeg,.png" />
            </div>
        </div>
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title"><strong>Pintasan Terkait</strong></h3>
            </div>
            <div class="box-body box-profile">
                <div class="small-box bg-aqua" style="margin-bottom: 12px; border-radius: 6px; overflow: hidden;">
                    <div class="inner" style="padding: 12px 14px;">
                        <h4 style="font-weight: 700; margin: 4px 0 2px 0;">Pengaturan Surat</h4>
                        <p style="font-size: 12px; margin: 0; opacity: 0.9;">Format &amp; template master surat</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-ios-paper"></i>
                    </div>
                    <a href="{{ site_url('surat_master') }}" class="small-box-footer" style="padding: 4px 0; font-size: 12px;">Lihat Pengaturan <i class="fa fa-arrow-circle-right"></i></a>
                </div>
                <div class="small-box bg-blue" style="margin-bottom: 0; border-radius: 6px; overflow: hidden;">
                    <div class="inner" style="padding: 12px 14px;">
                        <h4 style="font-weight: 700; margin: 4px 0 2px 0;">Syarat Surat</h4>
                        <p style="font-size: 12px; margin: 0; opacity: 0.9;">Daftar dokumen persyaratan surat</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-ios-paper"></i>
                    </div>
                    <a href="{{ site_url('surat_mohon') }}" class="small-box-footer" style="padding: 4px 0; font-size: 12px;">Lihat Pengaturan <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
        </div>
        @endif
    </div>
    <div class="col-md-9">
        @else
        <div class="col-md-12">
            @endif
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title"><strong>Pengaturan Dasar</strong></h3>
                </div>
                <div class="box-body">
                    @include('admin.pengaturan.form')
                </div>
                <div class="box-footer">
                    <button type="reset" class="btn btn-social btn-flat btn-danger btn-sm"><i class="fa fa-times"></i>
                        Batal</button>
                    @if ($ci->cek_hak_akses_url('u', $aksi_controller))
                    <button type="submit" class="btn btn-social btn-flat btn-info btn-sm pull-right"><i class="fa fa-check"></i> Simpan</button>
                    @endif
                </div>
            </div>
        </div>
        </form>
    </div>
@endsection

@push('scripts')
<script type="text/javascript">
    function showTampilanAnjungan() {
        var as = $('#tampilan_anjungan').val();
        if (as == 1) {
            $('#form_tampilan_anjungan_slider').show();
            $('#form_tampilan_anjungan_audio').hide();
            $('#form_tampilan_anjungan_video').hide();
            $('#form_tampilan_anjungan_waktu').show();
        } else if (as == 2) {
            $('#form_tampilan_anjungan_slider').hide();
            $('#form_tampilan_anjungan_audio').show();
            $('#form_tampilan_anjungan_video').show();
            $('#form_tampilan_anjungan_waktu').show();
        } else {
            $('#form_tampilan_anjungan_slider').hide();
            $('#form_tampilan_anjungan_audio').hide();
            $('#form_tampilan_anjungan_video').hide();
            $('#form_tampilan_anjungan_waktu').hide();
        }
    }

    if ($('#tampilan_anjungan').length) {
        $('#tampilan_anjungan').on('change', showTampilanAnjungan);
        showTampilanAnjungan();
    }
</script>
@endpush