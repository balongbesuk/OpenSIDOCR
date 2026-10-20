@if (is_admin())
@php
    $rilis_info = $rilis ?? cek_pembaruan_aplikasi();
    $ada_update = !empty($rilis_info['update_available']);
    $git_local  = \App\Libraries\GitHubUpdater::getLocalCommit();
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
                            Informasi & Tentang OpenSIDOCR
                        </h4>
                        <div style="margin-top: 4px; display: flex; align-items: center; gap: 6px; flex-wrap: wrap;">
                            <span class="label" style="background: #e2e8f0; color: #475569; font-size: 11px; padding: 2px 7px; border-radius: 4px; font-weight: 600;">
                                Basis OpenSID v<?= AmbilVersi() ?>
                            </span>
                            <span class="label label-primary" id="badge-header-commit" style="font-size: 11px; padding: 2px 7px; border-radius: 4px; font-weight: 600; font-family: monospace;">
                                <i class="fa fa-github"></i> <?= !empty($git_local['short_sha']) ? $git_local['short_sha'] : '11b9c9f' ?>
                            </span>
                            <span id="badge-header-update" class="label label-success" style="font-size: 11px; padding: 2px 7px; border-radius: 4px; font-weight: 600; display: none;">
                                <i class="fa fa-arrow-circle-up"></i> Update Tersedia
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Navigasi Tab Modern --}}
            <div class="modal-tab-nav-wrapper">
                <ul class="nav nav-pills modern-info-tabs" role="tablist">
                    <li role="presentation" class="active">
                        <a href="#tab-pembaruan" aria-controls="tab-pembaruan" role="tab" data-toggle="tab">
                            <i class="fa fa-bullhorn text-green"></i> Pembaruan
                            <span id="badge-tab-update" class="badge bg-green" style="font-size: 9px; padding: 2px 5px; margin-left: 2px; display: none;">Baru</span>
                        </a>
                    </li>
                    <li role="presentation">
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
                    <div role="tabpanel" class="tab-pane active" id="tab-pembaruan">
                        {{-- KARTU PEMBARUAN GITHUB LANGSUNG (PURE PHP - TANPA TERMINAL) --}}
                        <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 8px; padding: 20px; margin-bottom: 20px; box-shadow: 0 2px 8px rgba(0,0,0,0.04);">
                            <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 15px; border-bottom: 1px solid #f1f5f9; padding-bottom: 12px; flex-wrap: wrap; gap: 10px;">
                                <div style="display: flex; align-items: center; gap: 10px;">
                                    <div style="width: 36px; height: 36px; border-radius: 8px; background: #1e293b; color: #fff; display: flex; align-items: center; justify-content: center; font-size: 18px;">
                                        <i class="fa fa-github"></i>
                                    </div>
                                    <div>
                                        <h4 style="margin: 0; font-size: 15px; font-weight: 700; color: #0f172a;">
                                            Pembaruan Otomatis dari GitHub
                                        </h4>
                                        <span style="font-size: 11px; color: #64748b;">
                                            Repositori: <strong>balongbesuk/OpenSIDOCR</strong> (Branch: <code>main</code>)
                                        </span>
                                    </div>
                                </div>
                                <span id="badge-status-update" class="label label-default" style="font-size: 11px; padding: 4px 8px; border-radius: 4px;">
                                    <i class="fa fa-info-circle"></i> Siap Diperiksa
                                </span>
                            </div>

                            <div class="row" style="margin-bottom: 15px;">
                                <div class="col-sm-6" style="margin-bottom: 10px;">
                                    <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 6px; padding: 12px; min-height: 100px;">
                                        <div style="font-size: 11px; font-weight: 600; color: #64748b; margin-bottom: 4px; text-transform: uppercase;"><i class="fa fa-laptop"></i> Versi Server Terpasang</div>
                                        <div style="display: flex; align-items: center; gap: 8px;">
                                            <span class="label label-default" id="label-local-commit" style="font-family: monospace; font-size: 12px;">
                                                <?= !empty($git_local['short_sha']) ? $git_local['short_sha'] : '11b9c9f' ?>
                                            </span>
                                            <span style="font-size: 11px; color: #64748b;" id="label-local-date">
                                                <?= !empty($git_local['date']) ? $git_local['date'] : '-' ?>
                                            </span>
                                        </div>
                                        <div style="font-size: 11px; color: #475569; margin-top: 6px; line-height: 1.4; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;" id="label-local-message">
                                            <?= htmlspecialchars(!empty($git_local['message']) ? $git_local['message'] : 'Versi dasar aplikasi') ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6" style="margin-bottom: 10px;">
                                    <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 6px; padding: 12px; min-height: 100px;">
                                        <div style="font-size: 11px; font-weight: 600; color: #64748b; margin-bottom: 4px; text-transform: uppercase;"><i class="fa fa-cloud"></i> Versi Terkini di GitHub</div>
                                        <div style="display: flex; align-items: center; gap: 8px;">
                                            <span class="label label-default" id="label-remote-commit" style="font-family: monospace; font-size: 12px;">
                                                -
                                            </span>
                                            <span style="font-size: 11px; color: #64748b;" id="label-remote-date">-</span>
                                        </div>
                                        <div style="font-size: 11px; color: #475569; margin-top: 6px; line-height: 1.4; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;" id="label-remote-message">
                                            Klik tombol "Periksa Pembaruan" untuk mengecek rilis terbaru di repositori GitHub.
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 10px; background: #fafafa; border: 1px solid #f1f5f9; border-radius: 6px; padding: 10px 14px;">
                                <div style="font-size: 11px; color: #64748b;">
                                    <i class="fa fa-check-shield text-green"></i> <strong>Aman untuk Hosting cPanel:</strong> Menggunakan Pure PHP tanpa terminal. Berkas konfigurasi & data warga di folder <code>desa/</code> 100% terlindungi.
                                </div>
                                <div style="display: flex; gap: 8px;">
                                    <button type="button" class="btn btn-default btn-sm" id="btn-cek-update-github" style="font-weight: 600;">
                                        <i class="fa fa-refresh"></i> Periksa Pembaruan
                                    </button>
                                    <button type="button" class="btn btn-success btn-sm" id="btn-proses-update-github" style="font-weight: 600; display: none;">
                                        <i class="fa fa-cloud-download"></i> Perbarui Aplikasi Sekarang
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 8px; padding: 16px; margin-bottom: 20px;">
                            <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 10px;">
                                <div>
                                    <h5 style="margin: 0 0 4px 0; font-weight: 700; color: #1e293b; font-size: 14px;">
                                        <i class="fa fa-github text-primary"></i> Repositori Resmi balongbesuk/OpenSIDOCR
                                    </h5>
                                    <p style="margin: 0; font-size: 12px; color: #64748b; line-height: 1.5;">
                                        Pengembangan berkelanjutan berbasis OpenSID versi 2403.0.0 dengan penambahan AI RapidOCR Kartu Keluarga, format surat RTF desa, dan pembaruan aplikasi langsung dari GitHub.
                                    </p>
                                </div>
                                <div style="display: flex; gap: 8px;">
                                    <a href="https://github.com/balongbesuk/OpenSIDOCR" target="_blank" class="btn btn-default btn-sm" style="font-weight: 600;">
                                        <i class="fa fa-github"></i> Kunjungi Repositori
                                    </a>
                                    <a href="https://github.com/balongbesuk/OpenSIDOCR/commits/main" target="_blank" class="btn btn-default btn-sm" style="font-weight: 600;">
                                        <i class="fa fa-history"></i> Riwayat Commit
                                    </a>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="info-card-box">
                                    <h5 class="info-card-title"><i class="fa fa-shield text-primary"></i> Keamanan & Stabilitas</h5>
                                    <p class="info-card-text">Setiap commit berkala memuat peningkatan keamanan basis data penduduk desa dan optimasi performa modul pelayanan.</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info-card-box">
                                    <h5 class="info-card-title"><i class="fa fa-history text-success"></i> Siklus Pembaruan</h5>
                                    <p class="info-card-text">Pembaruan OpenSIDOCR dikelola secara terbuka di GitHub dan dapat diperbarui kapan pun langsung dari tombol periksa pembaruan di atas.</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- TAB 2: TENTANG APLIKASI --}}
                    <div role="tabpanel" class="tab-pane" id="tab-tentang">
                        <div class="info-card-box" style="margin-bottom: 16px; border-left: 4px solid #00a65a;">
                            <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 10px; margin-bottom: 10px;">
                                <h4 style="font-weight: bold; color: #0f172a; margin: 0; font-size: 17px;">
                                    OpenSIDOCR <span class="label label-success" style="font-size: 11px; vertical-align: middle;">v<?= AmbilVersi() ?></span>
                                </h4>
                                <span class="badge" style="background: #1e293b; font-family: monospace; font-size: 11px;">
                                    Commit: <?= !empty($git_local['short_sha']) ? $git_local['short_sha'] : '11b9c9f' ?>
                                </span>
                            </div>
                            <p align="justify" style="color: #334155; line-height: 1.6; margin-bottom: 12px; font-size: 13px;">
                                <strong>OpenSIDOCR</strong> adalah aplikasi Sistem Informasi Desa (SID) hasil pengembangan lanjutan dari <strong>OpenSID versi 2403.0.0 dan seterusnya</strong> yang dikembangkan oleh <strong>Pemerintah Desa Balongbesuk</strong>.
                            </p>
                            <p align="justify" style="color: #475569; line-height: 1.6; margin-bottom: 15px; font-size: 13px;">
                                Aplikasi ini menggabungkan seluruh keandalan sistem administrasi kependudukan OpenSID dengan serangkaian inovasi terkini:
                            </p>
                            <ul style="color: #334155; font-size: 12px; line-height: 1.8; padding-left: 20px; margin-bottom: 15px;">
                                <li><strong>AI RapidOCR Kartu Keluarga (KK):</strong> Ekstraksi data otomatis dari foto, scan, atau PDF Kartu Keluarga ke formulir kependudukan desa secara instan tanpa input manual satu per satu.</li>
                                <li><strong>Reaktivasi & Pembenahan Surat RTF:</strong> Format pembuatan surat berbasis RTF desa kembali didukung penuh, stabil, dan terhindar dari duplikasi nomor maupun arsip ganda.</li>
                                <li><strong>Portal Layanan Mandiri Modern:</strong> Tampilan responsif (mobile & desktop) dengan dashboard beranda terpadu, notifikasi realtime status surat, dan keamanan autentikasi ganda (OTP Telegram & Email).</li>
                                <li><strong>Pembaruan Otomatis dari GitHub:</strong> Pembaruan kode sumber aplikasi langsung dari repositori resmi <code>balongbesuk/OpenSIDOCR</code> menggunakan Pure PHP & ZipArchive yang aman untuk server cPanel shared hosting tanpa terminal.</li>
                            </ul>
                            <div style="display: flex; gap: 8px; flex-wrap: wrap;">
                                <a href="https://github.com/balongbesuk/OpenSIDOCR" target="_blank" class="btn btn-default btn-sm" style="font-weight: 600;">
                                    <i class="fa fa-github"></i> Repositori balongbesuk/OpenSIDOCR
                                </a>
                                <a href="https://opendesa.id" target="_blank" class="btn btn-default btn-sm" style="font-weight: 600;">
                                    <i class="fa fa-globe text-primary"></i> Website OpenDesa
                                </a>
                            </div>
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
                                OpenSIDOCR dibangun di atas lisensi <strong>GNU General Public License Version 3 (GPL v3)</strong> — bersifat sumber terbuka (*Open Source*), bebas digunakan dan disesuaikan untuk kemajuan pelayanan desa di seluruh Indonesia.
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
                                <div style="font-size: 32px; color: #e11d48; line-height: 1; flex-shrink: 0; width: 36px; height: 36px; display: flex; align-items: center; justify-content: center;">
                                    <i class="fa fa-heart"></i>
                                </div>
                                <div style="flex: 1; min-width: 0;">
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
    .modal-tab-nav-wrapper {
        background: #f8fafc;
        border-bottom: 1px solid #e2e8f0;
        padding: 8px 16px;
    }
    .modern-info-tabs {
        display: flex;
        gap: 6px;
        flex-wrap: wrap;
        margin: 0;
        padding: 0;
        list-style: none;
    }
    .modern-info-tabs > li {
        margin: 0;
        float: none;
    }
    .modern-info-tabs > li > a {
        border-radius: 6px !important;
        padding: 7px 12px !important;
        font-weight: 600 !important;
        font-size: 13px !important;
        color: #64748b !important;
        border: 1px solid transparent !important;
        background: transparent !important;
        transition: all 0.2s ease !important;
        display: inline-flex !important;
        align-items: center !important;
        gap: 6px !important;
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
        min-height: 44px;
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
        flex-shrink: 0;
        text-align: center;
    }

    #modal-catatan-rilis {
        z-index: 1060 !important;
    }

    /* ======================================================== */
    /* RESPONSIVE MOBILE OPTIMIZATION (< 768px)               */
    /* ======================================================== */
    @media (max-width: 767px) {
        #modal-informasi {
            padding: 0 !important;
        }
        #modal-informasi .modal-dialog {
            margin: 6px !important;
            width: calc(100% - 12px) !important;
            max-width: 100% !important;
            height: calc(100dvh - 12px) !important;
            height: calc(100vh - 12px) !important;
            display: flex !important;
            flex-direction: column !important;
        }
        #modal-informasi .modal-content {
            height: 100% !important;
            max-height: 100% !important;
            display: flex !important;
            flex-direction: column !important;
            border-radius: 10px !important;
            overflow: hidden !important;
        }
        #modal-informasi .modal-header {
            flex-shrink: 0 !important;
            padding: 12px 14px !important;
            background: #ffffff !important;
        }
        #modal-informasi .modal-header .modal-title {
            font-size: 15px !important;
        }
        #modal-informasi .modal-header .close {
            top: 14px !important;
            right: 14px !important;
            font-size: 26px !important;
            padding: 4px !important;
        }
        #modal-informasi .modal-tab-nav-wrapper {
            flex-shrink: 0 !important;
            padding: 6px 10px !important;
            overflow-x: auto !important;
            overflow-y: hidden !important;
            -webkit-overflow-scrolling: touch !important;
            scrollbar-width: none !important;
            background: #f1f5f9 !important;
        }
        #modal-informasi .modal-tab-nav-wrapper::-webkit-scrollbar {
            display: none !important;
        }
        #modal-informasi .modern-info-tabs {
            display: flex !important;
            flex-wrap: nowrap !important;
            gap: 6px !important;
            width: max-content !important;
            padding: 2px 0 !important;
        }
        #modal-informasi .modern-info-tabs > li {
            flex: 0 0 auto !important;
            float: none !important;
        }
        #modal-informasi .modern-info-tabs > li > a {
            white-space: nowrap !important;
            padding: 6px 12px !important;
            font-size: 12px !important;
        }
        #modal-informasi .modal-body {
            flex: 1 1 auto !important;
            max-height: none !important;
            overflow-y: auto !important;
            -webkit-overflow-scrolling: touch !important;
            padding: 14px 12px !important;
        }
        #modal-informasi .modal-footer {
            flex-shrink: 0 !important;
            padding: 10px 14px !important;
            background: #f8fafc !important;
        }
        #modal-informasi .modal-footer .pull-left {
            display: none !important;
        }
        #modal-informasi .modal-footer .pull-right {
            width: 100% !important;
            text-align: right !important;
        }
        #modal-informasi .modal-footer .btn {
            width: 100% !important;
            padding: 8px 16px !important;
            font-size: 13px !important;
        }
        #modal-informasi .catatan-scroll {
            height: auto !important;
            max-height: none !important;
            overflow: visible !important;
            padding: 12px !important;
        }
        .community-link-btn {
            padding: 8px 10px !important;
            font-size: 11.5px !important;
            gap: 6px !important;
        }
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

<script type="text/javascript">
(function() {
    function initGitHubUpdater() {
        if (typeof jQuery === 'undefined' || typeof $ === 'undefined') {
            setTimeout(initGitHubUpdater, 100);
            return;
        }

        $(function() {
            var updateUrlCek = '<?= site_url("pembaruan_aplikasi/cek") ?>';
            var updateUrlProses = '<?= site_url("pembaruan_aplikasi/proses") ?>';
            var csrfName = typeof csrfParam !== 'undefined' ? csrfParam : '<?= get_instance()->security->get_csrf_token_name() ?>';
            var isChecking = false;

            function getCsrfHash() {
                if (typeof getCsrfToken === 'function') {
                    try {
                        return getCsrfToken();
                    } catch (e) {}
                }
                return '<?= get_instance()->security->get_csrf_hash() ?>';
            }

            function cekUpdateGitHub(showFeedback) {
                if (isChecking) return;
                isChecking = true;
                $('#btn-cek-update-github').prop('disabled', true).html('<i class="fa fa-spin fa-refresh"></i> Memeriksa...');
                $('#badge-status-update').attr('class', 'label label-default').html('<i class="fa fa-circle-o-notch fa-spin"></i> Memeriksa...');
                $('#label-remote-commit').html('<i class="fa fa-spinner fa-spin"></i>');
                $('#label-remote-message').html('Memeriksa commit terbaru di GitHub...');

                $.ajax({
                    url: updateUrlCek,
                    type: 'GET',
                    data: showFeedback ? { force: 1 } : {},
                    dataType: 'json',
                    timeout: 45000,
                    success: function(resp) {
                        isChecking = false;
                        $('#btn-cek-update-github').prop('disabled', false).html('<i class="fa fa-refresh"></i> Periksa Pembaruan');

                        if (resp && resp.status && resp.data) {
                            var d = resp.data;
                            if (d.local && d.local.short_sha) {
                                $('#label-local-commit').text(d.local.short_sha);
                                $('#label-local-date').text(d.local.date || '-');
                                $('#label-local-message').text(d.local.message || '');
                            }
                            if (d.remote && d.remote.short_sha) {
                                $('#label-remote-commit').text(d.remote.short_sha);
                                $('#label-remote-date').text(d.remote.date || '-');
                                $('#label-remote-message').text(d.remote.message || '');
                            }

                            if (d.has_update) {
                                $('#badge-status-update').attr('class', 'label label-success').html('<i class="fa fa-arrow-circle-up"></i> Pembaruan Tersedia');
                                $('#badge-header-update').show();
                                $('#badge-tab-update').show();
                                $('#badge-menu-update').show();
                                $('#badge-icon-update').show();
                                $('#btn-proses-update-github').fadeIn();
                                if (showFeedback && typeof Swal !== 'undefined') {
                                    Swal.fire({
                                        title: 'Pembaruan Tersedia!',
                                        html: 'Ditemukan commit terbaru di GitHub: <code>' + d.remote.short_sha + '</code><br><small>' + (d.remote.message ? d.remote.message.replace(/\n/g, '<br>') : '') + '</small>',
                                        icon: 'info',
                                        confirmButtonText: 'Tutup'
                                    });
                                }
                            } else {
                                $('#badge-status-update').attr('class', 'label label-info').html('<i class="fa fa-check-circle"></i> Versi Terkini');
                                $('#badge-header-update').hide();
                                $('#badge-tab-update').hide();
                                $('#badge-menu-update').hide();
                                $('#badge-icon-update').hide();
                                $('#btn-proses-update-github').hide();
                                if (showFeedback && typeof Swal !== 'undefined') {
                                    Swal.fire({
                                        title: 'Aplikasi Terkini',
                                        text: 'Aplikasi Anda sudah menggunakan commit terbaru (' + (d.local.short_sha || '') + ').',
                                        icon: 'success',
                                        confirmButtonText: 'Tutup'
                                    });
                                }
                            }
                        } else {
                            $('#badge-status-update').attr('class', 'label label-warning').html('<i class="fa fa-exclamation-triangle"></i> Gagal Cek');
                            $('#label-remote-commit').text('-');
                            $('#label-remote-message').text((resp && resp.message) ? resp.message : 'Gagal memperoleh data pembaruan.');
                            $('#badge-header-update').hide();
                            $('#badge-tab-update').hide();
                            $('#badge-menu-update').hide();
                            $('#badge-icon-update').hide();
                        }
                    },
                    error: function(xhr) {
                        isChecking = false;
                        $('#btn-cek-update-github').prop('disabled', false).html('<i class="fa fa-refresh"></i> Periksa Pembaruan');
                        $('#badge-status-update').attr('class', 'label label-warning').html('<i class="fa fa-exclamation-triangle"></i> Gagal Cek');
                        $('#label-remote-commit').text('-');
                        var errMsg = (xhr.responseJSON && xhr.responseJSON.message) ? xhr.responseJSON.message : 'Koneksi ke GitHub API gagal atau batas waktu habis.';
                        $('#label-remote-message').text(errMsg);
                        if (showFeedback && typeof Swal !== 'undefined') {
                            Swal.fire({
                                title: 'Gagal Memeriksa Pembaruan',
                                text: errMsg,
                                icon: 'error'
                            });
                        }
                    }
                });
            }

            $('#modal-informasi').on('shown.bs.modal', function() {
                cekUpdateGitHub(false);
                $('#modal-informasi .modal-body').scrollTop(0);
            });

            // Scroll modal body ke paling atas saat beralih tab
            $('#modal-informasi a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
                $('#modal-informasi .modal-body').scrollTop(0);
                if ($(e.target).attr('href') === '#tab-pembaruan') {
                    cekUpdateGitHub(false);
                }
            });

            $('#btn-cek-update-github').on('click', function(e) {
                e.preventDefault();
                cekUpdateGitHub(true);
            });

            // Jalankan cek jika modal sudah terbuka saat halaman selesai dimuat
            if ($('#modal-informasi').hasClass('in') || $('#modal-informasi').is(':visible')) {
                cekUpdateGitHub(false);
            }

            $('#btn-proses-update-github').on('click', function(e) {
                e.preventDefault();
                var konfirmasiModal = function() {
                    jalankanPembaruan();
                };

                if (typeof Swal !== 'undefined') {
                    Swal.fire({
                        title: 'Perbarui Aplikasi Sekarang?',
                        html: 'Aplikasi akan mengunduh pembaruan terbaru dari repositori GitHub <b>balongbesuk/OpenSIDOCR</b>.<br><br><small class="text-success"><i class="fa fa-shield"></i> Berkas konfigurasi & data warga di folder <code>desa/</code> 100% aman.</small>',
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonColor: '#00a65a',
                        cancelButtonColor: '#94a3b8',
                        confirmButtonText: '<i class="fa fa-cloud-download"></i> Ya, Perbarui Sekarang',
                        cancelButtonText: 'Batal'
                    }).then(function(result) {
                        if (result.isConfirmed) {
                            konfirmasiModal();
                        }
                    });
                } else if (confirm('Perbarui aplikasi sekarang dari balongbesuk/OpenSIDOCR?')) {
                    konfirmasiModal();
                }
            });

            function jalankanPembaruan() {
                if (typeof Swal !== 'undefined') {
                    Swal.fire({
                        title: 'Sedang Memperbarui Aplikasi...',
                        html: '<div style="margin: 15px 0;"><i class="fa fa-cog fa-spin fa-3x text-green"></i></div>Mengunduh paket pembaruan dari GitHub, mengekstrak berkas, dan memigrasi database.<br><br><b>Mohon tidak menutup atau menyegarkan halaman ini.</b>',
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        showConfirmButton: false
                    });
                }

                var postData = {};
                postData[csrfName] = getCsrfHash();

                $.ajax({
                    url: updateUrlProses,
                    type: 'POST',
                    data: postData,
                    dataType: 'json',
                    timeout: 600000,
                    success: function(resp) {
                        if (resp && resp.status) {
                            if (typeof Swal !== 'undefined') {
                                Swal.fire({
                                    title: 'Pembaruan Berhasil!',
                                    text: resp.message || 'Aplikasi berhasil diperbarui ke commit terbaru GitHub.',
                                    icon: 'success',
                                    confirmButtonText: 'Muat Ulang Halaman'
                                }).then(function() {
                                    location.reload();
                                });
                            } else {
                                alert(resp.message || 'Pembaruan berhasil!');
                                location.reload();
                            }
                        } else {
                            var msg = (resp && resp.message) ? resp.message : 'Terjadi kesalahan saat menerapkan pembaruan.';
                            if (typeof Swal !== 'undefined') {
                                Swal.fire({
                                    title: 'Pembaruan Gagal',
                                    text: msg,
                                    icon: 'error'
                                });
                            } else {
                                alert(msg);
                            }
                        }
                    },
                    error: function(xhr) {
                        var errMsg = 'Terjadi kesalahan pada server atau waktu proses habis.';
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            errMsg = xhr.responseJSON.message;
                        }
                        if (typeof Swal !== 'undefined') {
                            Swal.fire({
                                title: 'Pembaruan Gagal',
                                text: errMsg,
                                icon: 'error'
                            });
                        } else {
                            alert(errMsg);
                        }
                    }
                });
            }
        });
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initGitHubUpdater);
    } else {
        initGitHubUpdater();
    }
})();
</script>
@endif

