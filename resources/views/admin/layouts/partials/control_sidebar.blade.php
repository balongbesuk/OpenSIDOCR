@php
    $rilis_info = $rilis ?? cek_pembaruan_aplikasi();
    $ada_update = !empty($rilis_info['update_available']);
@endphp

<div id="modal-informasi" class="modal fade" role="dialog" aria-labelledby="modalInformasiLabel" aria-hidden="true" style="color: #333;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" style="border-radius: 8px; overflow: hidden; border: none; box-shadow: 0 10px 30px rgba(0,0,0,0.25);">
            {{-- Modal Header --}}
            <div class="modal-header" style="background: #ffffff; border-bottom: 1px solid #eef2f6; padding: 16px 20px; position: relative;">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="position: absolute; top: 18px; right: 20px; font-size: 26px; line-height: 1; margin: 0; color: #94a3b8; opacity: 1; transition: color 0.2s; cursor: pointer;">
                    <span aria-hidden="true">&times;</span>
                </button>
                <div style="display: flex; align-items: center; gap: 12px; padding-right: 40px;">
                    <div style="width: 38px; height: 38px; border-radius: 8px; background: linear-gradient(135deg, #00a65a, #008d4c); color: #fff; display: flex; align-items: center; justify-content: center; font-size: 18px; flex-shrink: 0; box-shadow: 0 3px 8px rgba(0,166,90,0.3);">
                        <i class="fa fa-info"></i>
                    </div>
                    <div>
                        <h4 class="modal-title" id="modalInformasiLabel" style="font-weight: 700; color: #1e293b; margin: 0; font-size: 17px; line-height: 1.2;">
                            Informasi & Tentang <?= config_item('nama_aplikasi') ?>
                        </h4>
                        <div style="margin-top: 4px; display: flex; align-items: center; gap: 6px; flex-wrap: wrap;">
                            <span class="label" style="background: #e2e8f0; color: #475569; font-size: 11px; padding: 2px 7px; border-radius: 4px; font-weight: 600;">
                                Versi <?= AmbilVersi() ?>
                            </span>
                            @if ($ada_update)
                                <span class="label label-success" style="font-size: 11px; padding: 2px 7px; border-radius: 4px; font-weight: 600;">
                                    <i class="fa fa-arrow-circle-up"></i> Update Tersedia: {{ $rilis_info['latest_version'] }}
                                </span>
                            @else
                                <span class="label label-info" style="font-size: 11px; padding: 2px 7px; border-radius: 4px; font-weight: 600;">
                                    <i class="fa fa-check-circle"></i> Versi Terkini
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            {{-- Navigasi Tab Modern --}}
            <div style="background: #f8fafc; border-bottom: 1px solid #e2e8f0; padding: 8px 16px;">
                <ul class="nav nav-pills modern-info-tabs" role="tablist" style="margin: 0; display: flex; gap: 6px; flex-wrap: wrap;">
                    <li role="presentation" class="<?= $ada_update ? 'active' : '' ?>">
                        <a href="#tab-pembaruan" aria-controls="tab-pembaruan" role="tab" data-toggle="tab">
                            <i class="fa fa-bullhorn text-green"></i> Pembaruan
                            @if ($ada_update)
                                <span class="badge bg-green" style="font-size: 9px; padding: 2px 5px; margin-left: 2px;">Baru</span>
                            @endif
                        </a>
                    </li>
                    <li role="presentation" class="<?= !$ada_update ? 'active' : '' ?>">
                        <a href="#tab-tentang" aria-controls="tab-tentang" role="tab" data-toggle="tab">
                            <i class="fa fa-cube text-aqua"></i> Tentang Aplikasi
                        </a>
                    </li>
                    <li role="presentation">
                        <a href="#tab-catatan" aria-controls="tab-catatan" role="tab" data-toggle="tab">
                            <i class="fa fa-book text-yellow"></i> Catatan Rilis
                        </a>
                    </li>
                    <li role="presentation">
                        <a href="#tab-panduan" aria-controls="tab-panduan" role="tab" data-toggle="tab">
                            <i class="fa fa-shield text-purple"></i> Hak Akses & Tahapan
                        </a>
                    </li>
                    <li role="presentation">
                        <a href="#tab-komunitas" aria-controls="tab-komunitas" role="tab" data-toggle="tab">
                            <i class="fa fa-heart text-red"></i> Bantuan & Donasi
                        </a>
                    </li>
                </ul>
            </div>

            {{-- Konten Tab --}}
            <div class="modal-body" style="max-height: 65vh; overflow-y: auto; padding: 20px; background: #ffffff;">
                <div class="tab-content">
                    {{-- TAB 1: PEMBARUAN --}}
                    <div role="tabpanel" class="tab-pane <?= $ada_update ? 'active' : '' ?>" id="tab-pembaruan">
                        @if ($ada_update)
                            <div style="background: linear-gradient(135deg, #00a65a, #008d4c); border-radius: 8px; padding: 20px; color: #ffffff; box-shadow: 0 4px 15px rgba(0,166,90,0.25); margin-bottom: 20px;">
                                <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 12px;">
                                    <div style="width: 36px; height: 36px; border-radius: 50%; background: rgba(255,255,255,0.2); display: flex; align-items: center; justify-content: center; font-size: 18px; flex-shrink: 0;">
                                        <i class="fa fa-rocket"></i>
                                    </div>
                                    <h4 style="margin: 0; font-weight: bold; font-size: 18px; color: #ffffff;">
                                        Pembaruan Tersedia: {{ $rilis_info['latest_version'] }}
                                    </h4>
                                </div>
                                <p style="margin: 0 0 15px 0; font-size: 13px; line-height: 1.6; opacity: 0.95;" align="justify">
                                    {{ config_item('nama_aplikasi') }} <code>{{ $rilis_info['latest_version'] }}</code> telah tersedia.
                                    Sangat dianjurkan untuk melakukan pembaruan ke versi terkini guna memperoleh fitur terbaru, perbaikan *bug*, serta peningkatan keamanan data desa sejak versi saat ini <code>{{ $rilis_info['current_version'] }}</code>.
                                </p>
                                <div style="display: flex; gap: 10px; flex-wrap: wrap;">
                                    <button class="btn btn-default btn-sm" data-toggle="modal" data-target="#modal-catatan-rilis" style="font-weight: 600; color: #008d4c;">
                                        <i class="fa fa-file-text-o"></i> Catatan Rilis {{ $rilis_info['latest_version'] }}
                                    </button>
                                    <a href="{{ $rilis_info['url_download'] }}" class="btn btn-warning btn-sm" style="font-weight: 600;" target="_blank">
                                        <i class="fa fa-download"></i> Unduh Berkas Rilis
                                    </a>
                                    <a href="https://github.com/{{ config_item('nama_aplikasi') }}/{{ config_item('nama_aplikasi') }}/wiki/Panduan-Update-{{ config_item('nama_aplikasi') }}" class="btn btn-default btn-sm" style="background: rgba(255,255,255,0.2); border: 1px solid rgba(255,255,255,0.4); color: #fff; font-weight: 600;" target="_blank">
                                        <i class="fa fa-book"></i> Panduan Update
                                    </a>
                                </div>
                            </div>
                        @else
                            <div style="background: #f0fdf4; border: 1px solid #bbf7d0; border-radius: 8px; padding: 20px; color: #166534; display: flex; align-items: center; gap: 15px; margin-bottom: 20px;">
                                <div style="width: 44px; height: 44px; border-radius: 50%; background: #dcfce7; display: flex; align-items: center; justify-content: center; font-size: 22px; color: #16a34a; flex-shrink: 0;">
                                    <i class="fa fa-check"></i>
                                </div>
                                <div>
                                    <h4 style="margin: 0 0 4px 0; font-weight: bold; font-size: 16px;">
                                        Aplikasi Anda Menggunakan Versi Terkini
                                    </h4>
                                    <p style="margin: 0; font-size: 13px; color: #15803d;">
                                        Versi saat ini: <strong>v<?= AmbilVersi() ?></strong>. Belum ada pembaruan versi baru yang dirilis.
                                    </p>
                                </div>
                            </div>
                        @endif

                        <div class="row">
                            <div class="col-md-6">
                                <div class="info-card-box">
                                    <h5 class="info-card-title"><i class="fa fa-shield text-primary"></i> Keamanan & Stabilitas</h5>
                                    <p class="info-card-text">Setiap rilis berkala memuat peningkatan keamanan basis data penduduk desa dan optimasi performa modul pelayanan.</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info-card-box">
                                    <h5 class="info-card-title"><i class="fa fa-history text-success"></i> Siklus Pembaruan</h5>
                                    <p class="info-card-text">Pembaruan OpenSID dikelola terbuka di GitHub dan dapat diunduh secara bebas oleh seluruh komunitas SID Indonesia.</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- TAB 2: TENTANG APLIKASI --}}
                    <div role="tabpanel" class="tab-pane <?= !$ada_update ? 'active' : '' ?>" id="tab-tentang">
                        <div class="info-card-box" style="margin-bottom: 16px;">
                            <h4 style="font-weight: bold; color: #0f172a; margin-top: 0; margin-bottom: 10px; font-size: 16px;">
                                <?= config_item('nama_aplikasi') ?> (Sistem Informasi Desa)
                            </h4>
                            <p align="justify" style="color: #475569; line-height: 1.6; margin-bottom: 12px;">
                                <?= config_item('nama_aplikasi') ?> adalah aplikasi Sistem Informasi Desa (SID) yang dikembangkan sejak Mei 2016. Aplikasi ini dirancang dan dikelola supaya terbuka dan dapat dikembangkan bersama-sama oleh komunitas peduli SID.
                            </p>
                            <p style="margin-bottom: 0;">
                                <a href="<?= config_item('github') ?>" target="_blank" class="btn btn-default btn-sm" style="font-weight: 600;">
                                    <i class="fa fa-github"></i> Repositori GitHub
                                </a>
                                <a href="<?= config_item('website') ?>" target="_blank" class="btn btn-default btn-sm" style="font-weight: 600; margin-left: 6px;">
                                    <i class="fa fa-globe text-primary"></i> Website OpenDesa
                                </a>
                            </p>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="info-card-box">
                                    <h5 class="info-card-title"><i class="fa fa-server text-aqua"></i> Mode Offline</h5>
                                    <p class="info-card-text" align="justify">
                                        Dioperasikan pada komputer server lokal kantor desa tanpa internet. Sangat aman untuk operasional administrasi kependudukan harian desa.
                                    </p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info-card-box">
                                    <h5 class="info-card-title"><i class="fa fa-cloud text-green"></i> Mode Online</h5>
                                    <p class="info-card-text" align="justify">
                                        Terhubung ke internet dan berfungsi ganda sebagai website resmi desa dan portal Layanan Mandiri warga secara daring.
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="info-card-box" style="margin-top: 16px;">
                            <h5 class="info-card-title"><i class="fa fa-balance-scale text-yellow"></i> Hak Cipta & Lisensi GPL v3</h5>
                            <p class="info-card-text" align="justify" style="margin-bottom: 0;">
                                <?= config_item('nama_aplikasi') ?> berlisensi <strong>GNU General Public License Version 3 (GPL v3)</strong> — bersifat sumber terbuka (*Open Source*), bebas digunakan dan disesuaikan oleh seluruh desa di Indonesia. Dikelola oleh Perkumpulan Desa Digital Terbuka (OpenDesa).
                            </p>
                        </div>
                    </div>

                    {{-- TAB 3: CATATAN RILIS --}}
                    <div role="tabpanel" class="tab-pane" id="tab-catatan">
                        <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 6px; padding: 12px 16px; margin-bottom: 12px; display: flex; align-items: center; justify-content: space-between;">
                            <div>
                                <h5 style="margin: 0; font-weight: bold; color: #1e293b;">Riwayat Catatan Rilis</h5>
                                <small class="text-muted">Daftar pembaruan fitur, optimasi, dan perbaikan bug</small>
                            </div>
                            <span class="label label-primary">catatan_rilis.md</span>
                        </div>
                        <div class="catatan-scroll" style="height: 380px; overflow-y: auto; background: #ffffff; border: 1px solid #e2e8f0; border-radius: 6px; padding: 18px; font-size: 13px; line-height: 1.6;">
                            <?= parsedown('catatan_rilis.md') ?>
                        </div>
                    </div>

                    {{-- TAB 4: PANDUAN & AKSES --}}
                    <div role="tabpanel" class="tab-pane" id="tab-panduan">
                        <h5 style="font-weight: bold; color: #1e293b; margin-top: 0; margin-bottom: 12px;">
                            <i class="fa fa-users text-primary"></i> Tingkat Hak Akses Pengguna (Role User)
                        </h5>
                        <div class="row" style="margin-bottom: 20px;">
                            <div class="col-sm-6" style="margin-bottom: 10px;">
                                <div style="border-left: 3px solid #dd4b39; background: #fff5f5; padding: 12px 14px; border-radius: 0 6px 6px 0;">
                                    <strong style="color: #c53030; font-size: 14px;">1. Administrator</strong>
                                    <p style="margin: 4px 0 0 0; font-size: 12px; color: #4a5568;" align="justify">
                                        Bertanggung jawab penuh atas entri, edit, dan hapus data dasar kependudukan serta pengaturan sistem aplikasi.
                                    </p>
                                </div>
                            </div>
                            <div class="col-sm-6" style="margin-bottom: 10px;">
                                <div style="border-left: 3px solid #f39c12; background: #fffaf0; padding: 12px 14px; border-radius: 0 6px 6px 0;">
                                    <strong style="color: #dd6b20; font-size: 14px;">2. Operator</strong>
                                    <p style="margin: 4px 0 0 0; font-size: 12px; color: #4a5568;" align="justify">
                                        Membantu administrator dalam entri data kependudukan harian dan pengelolaan informasi desa dengan hak terbatas.
                                    </p>
                                </div>
                            </div>
                            <div class="col-sm-6" style="margin-bottom: 10px;">
                                <div style="border-left: 3px solid #00a65a; background: #f0fdf4; padding: 12px 14px; border-radius: 0 6px 6px 0;">
                                    <strong style="color: #16a34a; font-size: 14px;">3. Redaksi</strong>
                                    <p style="margin: 4px 0 0 0; font-size: 12px; color: #4a5568;" align="justify">
                                        Mengelola artikel berita website desa, menyetujui kiriman tulisan, menentukan berita utama, dan slider website.
                                    </p>
                                </div>
                            </div>
                            <div class="col-sm-6" style="margin-bottom: 10px;">
                                <div style="border-left: 3px solid #00c0ef; background: #f0f9ff; padding: 12px 14px; border-radius: 0 6px 6px 0;">
                                    <strong style="color: #0284c7; font-size: 14px;">4. Kontributor</strong>
                                    <p style="margin: 4px 0 0 0; font-size: 12px; color: #4a5568;" align="justify">
                                        Penulis artikel berita warga. Tulisan yang dibuat memerlukan persetujuan redaksi sebelum tayang ke publik.
                                    </p>
                                </div>
                            </div>
                        </div>

                        <h5 style="font-weight: bold; color: #1e293b; margin-top: 10px; margin-bottom: 12px;">
                            <i class="fa fa-road text-success"></i> Tahapan Membangun SID di Desa
                        </h5>
                        <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 6px; padding: 15px;">
                            <ol style="margin-bottom: 0; padding-left: 20px; line-height: 1.8; color: #334155;">
                                <li>Bentuk tim kerja bersama pemerintah desa.</li>
                                <li>Diskusikan basis data kependudukan dan statistik yang diperlukan warga.</li>
                                <li>Himpun data kependudukan warga dari Kartu Keluarga (KK).</li>
                                <li>Dapatkan dan pasang aplikasi SID di komputer kantor desa.</li>
                                <li>Input data penduduk ke sistem dan mulai manfaatkan untuk layanan surat menyurat.</li>
                                <li>Sebarluaskan informasi desa melalui beragam media publik untuk warga.</li>
                            </ol>
                        </div>
                    </div>

                    {{-- TAB 5: KOMUNITAS & DONASI --}}
                    <div role="tabpanel" class="tab-pane" id="tab-komunitas">
                        <h5 style="font-weight: bold; color: #1e293b; margin-top: 0; margin-bottom: 14px;">
                            <i class="fa fa-comments-o text-aqua"></i> Pusat Bantuan & Komunitas Pengguna
                        </h5>
                        <div class="row" style="margin-bottom: 20px;">
                            <div class="col-sm-4 col-xs-6" style="margin-bottom: 10px;">
                                <a href="<?= config_item('website') ?>" target="_blank" class="community-link-btn">
                                    <i class="fa fa-globe text-primary"></i>
                                    <span>Website OpenDesa</span>
                                </a>
                            </div>
                            <div class="col-sm-4 col-xs-6" style="margin-bottom: 10px;">
                                <a href="<?= config_item('fb_opendesa') ?>" target="_blank" class="community-link-btn">
                                    <i class="fa fa-facebook-square text-blue"></i>
                                    <span>Grup Facebook</span>
                                </a>
                            </div>
                            <div class="col-sm-4 col-xs-6" style="margin-bottom: 10px;">
                                <a href="<?= config_item('youtube') ?>" target="_blank" class="community-link-btn">
                                    <i class="fa fa-youtube-play text-red"></i>
                                    <span>Tutorial YouTube</span>
                                </a>
                            </div>
                            <div class="col-sm-4 col-xs-6" style="margin-bottom: 10px;">
                                <a href="<?= config_item('github') ?>/wiki" target="_blank" class="community-link-btn">
                                    <i class="fa fa-book text-warning"></i>
                                    <span>Panduan Wiki</span>
                                </a>
                            </div>
                            <div class="col-sm-4 col-xs-6" style="margin-bottom: 10px;">
                                <a href="<?= config_item('forum') ?>" target="_blank" class="community-link-btn">
                                    <i class="fa fa-commenting text-purple"></i>
                                    <span>Forum OpenDesa</span>
                                </a>
                            </div>
                            <div class="col-sm-4 col-xs-6" style="margin-bottom: 10px;">
                                <a href="<?= config_item('github') ?>/issues" target="_blank" class="community-link-btn">
                                    <i class="fa fa-bug text-danger"></i>
                                    <span>Lapor Masalah (Issues)</span>
                                </a>
                            </div>
                        </div>

                        {{-- Card Donasi --}}
                        <div style="background: #fff8f8; border: 1px solid #ffd6d6; border-radius: 8px; padding: 18px;">
                            <div style="display: flex; align-items: flex-start; gap: 14px;">
                                <div style="font-size: 32px; color: #e11d48; line-height: 1;">
                                    <i class="fa fa-heart"></i>
                                </div>
                                <div style="flex: 1;">
                                    <h5 style="margin: 0 0 6px 0; font-weight: bold; color: #9f1239; font-size: 15px;">
                                        Dukung Pengembangan OpenSID
                                    </h5>
                                    <p style="margin: 0 0 12px 0; font-size: 12px; color: #4c0519; line-height: 1.6;" align="justify">
                                        OpenSID selalu gratis dan dikembangkan oleh relawan komunitas secara sukarela. Dukungan dan donasi Anda memungkinkan OpenSID dikembangkan terus secara berkesinambungan bagi ribuan desa di seluruh Indonesia.
                                    </p>
                                    <a href="<?= config_item('website') ?>/donasi" target="_blank" class="btn btn-sm" style="background: #e11d48; color: #ffffff; font-weight: 600; border-radius: 4px;">
                                        <i class="fa fa-heart"></i> Donasi Pengembangan
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Modal Footer --}}
            <div class="modal-footer" style="background-color: #f8fafc; border-top: 1px solid #eef2f6; padding: 12px 20px;">
                <div class="pull-left text-muted" style="line-height: 32px; font-size: 12px; margin: 0;">
                    <i class="fa fa-code"></i> Open Source Software (GPL v3)
                </div>
                <div class="pull-right">
                    <button type="button" class="btn btn-default btn-sm" data-dismiss="modal" style="font-weight: 600; padding: 6px 18px; border-radius: 4px;">
                        <i class="fa fa-times"></i> Tutup
                    </button>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Reset pseudo-elements Bootstrap 3 pada header dan footer modal informasi */
    #modal-informasi .modal-header:before,
    #modal-informasi .modal-header:after,
    #modal-informasi .modal-footer:before,
    #modal-informasi .modal-footer:after {
        display: none !important;
    }

    /* Styling Nav Tabs Modern untuk Modal Informasi */
    .modern-info-tabs > li > a {
        border-radius: 6px !important;
        padding: 7px 12px !important;
        font-weight: 600 !important;
        font-size: 13px !important;
        color: #64748b !important;
        border: 1px solid transparent !important;
        background: transparent !important;
        transition: all 0.2s ease !important;
    }
    .modern-info-tabs > li > a:hover {
        background: #f1f5f9 !important;
        color: #1e293b !important;
    }
    .modern-info-tabs > li.active > a,
    .modern-info-tabs > li.active > a:focus,
    .modern-info-tabs > li.active > a:hover {
        background: #ffffff !important;
        color: #0f172a !important;
        border: 1px solid #cbd5e1 !important;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.08) !important;
    }

    /* Info Cards */
    .info-card-box {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 6px;
        padding: 14px 16px;
    }
    .info-card-title {
        font-weight: 700;
        color: #1e293b;
        margin-top: 0;
        margin-bottom: 8px;
        font-size: 14px;
    }
    .info-card-text {
        font-size: 12.5px;
        color: #475569;
        line-height: 1.55;
        margin-bottom: 0;
    }

    /* Community Links Grid */
    .community-link-btn {
        display: flex;
        align-items: center;
        gap: 10px;
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 6px;
        padding: 10px 12px;
        color: #1e293b;
        font-size: 12.5px;
        font-weight: 600;
        text-decoration: none !important;
        transition: all 0.2s ease;
    }
    .community-link-btn:hover {
        background: #f1f5f9;
        border-color: #cbd5e1;
        color: #0284c7;
        transform: translateY(-1px);
        box-shadow: 0 2px 4px rgba(0,0,0,0.04);
    }
    .community-link-btn i {
        font-size: 16px;
        width: 18px;
        text-align: center;
    }

    #modal-catatan-rilis {
        z-index: 1060 !important;
    }
</style>

@if ($ada_update)
    <div id="modal-catatan-rilis" class="modal fade" role="dialog" style="color: #333;">
        <div class="modal-dialog modal-lg">
            <div class="modal-content" style="border-radius: 6px; overflow: hidden;">
                <div class="modal-header" style="background: #f8fafc; border-bottom: 1px solid #e2e8f0;">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title" style="font-weight: 700;">
                        <i class="fa fa-book text-primary"></i>&nbsp;&nbsp;Catatan Rilis
                        {{ config_item('nama_aplikasi') }} <span class="label label-success">{{ $rilis_info['latest_version'] }}</span>
                    </h4>
                </div>
                <div class="modal-body rilis" style="max-height: 480px; overflow-y: auto; padding: 20px; font-size: 13px; line-height: 1.6;">
                    {!! nl2br($rilis_info['release_body']) !!}
                </div>
                <div class="modal-footer" style="background: #f8fafc; border-top: 1px solid #e2e8f0;">
                    <button type="button" class="btn btn-default btn-sm pull-left" data-dismiss="modal">
                        <i class='fa fa-times'></i> Tutup
                    </button>
                    <a href="{{ $rilis_info['url_download'] }}" class="btn btn-warning btn-sm pull-right" target="_blank" style="font-weight: 600;">
                        <i class="fa fa-download"></i> Unduh Berkas Rilis
                    </a>
                </div>
            </div>
        </div>
    </div>
@endif