<div class="box box-info">
    <div class="box-header with-border">
        <h3 class="box-title">Buku Administrasi Umum</h3>
        <div class="box-tools">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
        </div>
    </div>
    <div class="box-body no-padding">
        <ul class="nav nav-pills nav-stacked">
            <li class="@active($selected_nav == 'peraturan')"><a href="{{ site_url('dokumen_sekretariat/clear/3') }}">Buku Peraturan Di {{ ucwords(setting('sebutan_desa')) }}</a></li>
            <li class="@active($selected_nav == 'keputusan')"><a href="{{ site_url('dokumen_sekretariat/clear/2') }}">Buku Keputusan {{ ucwords(setting('sebutan_kepala_desa')) }}</a></li>
            <li class="@active($selected_nav == 'inventaris')"><a href="{{ site_url('bumindes_inventaris_kekayaan') }}">Buku Inventaris dan Kekayaan {{ ucwords(setting('sebutan_desa')) }}</a></li>
            <li class="@active($selected_nav == 'pengurus' || $selected_nav == 'aparat')"><a href="{{ site_url('pengurus') }}">Buku {{ ucwords(setting('sebutan_pemerintah_desa')) }}</a></li>
            <li class="@active($selected_nav == 'tanah_kas')"><a href="{{ site_url('bumindes_tanah_kas_desa/clear') }}">Buku Tanah Kas {{ ucwords(setting('sebutan_desa')) }}</a></li>
            <li class="@active($selected_nav == 'tanah')"><a href="{{ site_url('bumindes_tanah_desa/clear') }}">Buku Tanah di {{ ucwords(setting('sebutan_desa')) }}</a></li>
            <li class="@active($selected_nav == 'agenda_keluar')"><a href="{{ site_url('surat_keluar') }}">Buku Agenda - Surat Keluar</a></li>
            <li class="@active($selected_nav == 'agenda_masuk')"><a href="{{ site_url('surat_masuk') }}">Buku Agenda - Surat Masuk</a></li>
            <li class="@active($selected_nav == 'ekspedisi')"><a href="{{ site_url('ekspedisi/clear') }}">Buku Ekspedisi</a></li>
            <li class="@active($selected_nav == 'lembaran')"><a href="{{ site_url('buku_umum/lembaran_desa/clear') }}">Buku Lembaran {{ ucwords(setting('sebutan_desa')) }} dan Berita {{ ucwords(setting('sebutan_desa')) }}</a></li>
        </ul>
    </div>
</div>
