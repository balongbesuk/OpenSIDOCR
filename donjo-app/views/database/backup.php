                <div class="tab-pane <?= jecho($act_tab, 1, 'active') ?>">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="box-header with-border">
                                <h3 class="box-title"><strong>Backup SID</strong></h3>
                            </div>
                            <div class="box-body">
                                <div class="row">
                                    <div class="col-sm-12 col-md-10 col-lg-9">
                                        <?php if ($inkremental != null && $inkremental->status == '1'): ?>
                                        <p class="text-muted text-blue well well-sm no-shadow" style="margin-top: 10px;">
                                            <small>
                                                <?php if ($inkremental->ukuran == '0 Bytes'): ?>
                                                    <strong class="text-red"><i class="fa fa-info-circle text-red"></i> Tidak ada file terbaru untuk dibackup.</strong>
                                                <?php else : ?>
                                                    <strong><i class="fa fa-info-circle text-blue"></i> Backup inkremental sudah selesai dan siap untuk didownload</strong>
                                                <?php endif ?>
                                            </small>
                                        </p>
                                        <?php elseif ($inkremental->status == '-1') : ?>
                                            <p class="text-muted text-blue well well-sm no-shadow" style="margin-top: 10px;">
                                                <small>
                                                    <strong class="text-red"><i class="fa fa-info-circle text-red"></i> Backup Gagal,  Informasi gagal ada di log Error</strong>
                                                </small>
                                            </p>
                                        <?php endif ?>
                                        <form class="form-horizontal">
                                            <table class="table table-bordered">
                                                <tbody>
                                                    <?php if (! setting('multi_desa')): ?>
                                                        <tr>
                                                            <td style="vertical-align: middle;"><b>Backup Seluruh Database SID (.sql)</b></td>
                                                            <td style="width: 260px; vertical-align: middle;">
                                                                <a href="<?= site_url('database/exec_backup')?>" class="btn btn-social btn-flat btn-block btn-info btn-sm <?= $memory_limit ? '' : 'disabled' ?>" title="Perkiraan ukuran file backup sql berdasarkan jumlah tabel dan baris data adalah <?= $size_sql ?>"><i class="fa fa-download"></i> Unduh Database <b><code><?= $size_sql ?></code></b></a>
                                                            </td>
                                                        </tr>
                                                    <?php endif ?>
                                                    <tr>
                                                        <td style="vertical-align: middle;"><b>Backup Seluruh Folder Desa SID (.zip)</b> </td>
                                                        <td style="width: 260px; vertical-align: middle;">
                                                            <a href="<?= site_url('database/desa_backup'); ?>" class="btn btn-social btn-flat btn-block btn-info btn-sm" title="Perkiraan ukuran folder desa sebelum di compress adalah <?= $size_folder ?>"><i class="fa fa-download"></i> Unduh Folder Desa <b><code><?= $size_folder ?></code></b></a>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td style="vertical-align: middle;"><b>Backup Inkremental Folder Desa SID (.zip)</b> </td>
                                                        <td style="width: 260px; vertical-align: middle;">
                                                            <div class="btn-group btn-block" style="display: flex;">
                                                                <button type="button" class="btn btn-social btn-flat <?= $inkremental->status == '0' ? 'btn-warning' : 'btn-info'  ?> btn-sm" id="Inkremental" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="flex: 1; min-width: 0; text-align: left; margin: 0 !important; border-top-right-radius: 0 !important; border-bottom-right-radius: 0 !important;"><i class="fa fa-download"></i> <?= $inkremental->status == '0' ? 'Backup Sedang Dalam Proses' : 'Backup Inkremental'  ?></button>
                                                                <button type="button" class="btn btn-flat btn-sm dropdown-toggle <?= $inkremental->status == '0' ? 'btn-warning' : 'btn-info'  ?>" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="width: 32px; min-width: 32px; padding: 0; margin: 0 !important; display: inline-flex; align-items: center; justify-content: center; border-top-left-radius: 0 !important; border-bottom-left-radius: 0 !important; border-left: 1px solid rgba(0, 0, 0, 0.15) !important;">
                                                                    <span class="caret"></span>
                                                                    <span class="sr-only">Toggle Dropdown</span>
                                                                </button>
                                                                <ul class="dropdown-menu dropdown-menu-right">
                                                                    <?php if ($inkremental == null || $inkremental->status == '2' || $inkremental->status == '-1'): ?>
                                                                        <li><a href="#" id="buat-job">Buat Backup Inkremental</a></li>
                                                                    <?php endif ?>
                                                                    <?php if ($inkremental != null && $inkremental->status == '1' && $inkremental->ukuran != '0 Bytes'): ?>
                                                                        <li><a href="<?= site_url('database/inkremental_download'); ?>">Download Backup Inkremental</a></li>
                                                                    <?php endif ?>
                                                                    <li><a href="<?= site_url('database/desa_inkremental'); ?>">Lihat Riwayat</a></li>
                                                                    <?php if ($inkremental->status == '0'): ?>
                                                                        <li><a href="<?= site_url('database/batal_backup'); ?>">Batalkan Proses Backup</a></li>
                                                                    <?php endif ?>
                                                                </ul>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </form>
                                        <p>Proses Unduh akan mengunduh keseluruhan database SID anda.</p>
                                        <div class="row">
                                            <ul>
                                                <li> Usahakan untuk melakukan backup secara rutin dan terjadwal. </li>
                                                <li> Backup yang dihasilkan sebaiknya disimpan di komputer terpisah dari server SID. </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php if (can('u') && ! config_item('demo_mode')): ?>

                            <?php if (! setting('multi_desa')): ?>
                            <div class="col-md-12">
                                <div class="box-header with-border">
                                    <h3 class="box-title"><strong>Restore Database SID</strong></h3>
                                </div>
                                <div class="box-body">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <p>Backup yang dibuat dapat dipergunakan untuk mengembalikan database SID anda apabila ada masalah. Klik tombol Restore di bawah untuk menggantikan keseluruhan database SID dengan data hasil backup terdahulu.</p>
                                            <form action="<?= $form_action?>" method="post" enctype="multipart/form-data" class="form-horizontal">
                                                <p>Batas maksimal pengunggahan berkas <strong><?= max_upload() ?> MB.</strong></p>
                                                <p>Proses ini akan membutuhkan waktu beberapa menit, menyesuaikan dengan spesifikasi komputer server SID dan sambungan internet yang tersedia.</p>
                                                <p></p>
                                                <table class="table table-bordered">
                                                    <tbody>
                                                        <tr>
                                                            <td style="padding: 15px 20px;">
                                                                <div class="form-group" style="margin-bottom: 0;">
                                                                    <label for="file" class="col-sm-3 col-md-2 control-label" style="text-align: left; padding-top: 7px;">Pilih File .Sql:</label>
                                                                    <div class="col-sm-9 col-md-8 col-lg-7">
                                                                        <div style="display: flex; align-items: center; gap: 10px; flex-wrap: wrap;">
                                                                            <div class="input-group" style="flex: 1; min-width: 260px;">
                                                                                <input type="text" class="form-control" id="file_path" name="userfile">
                                                                                <input type="file" class="hidden" id="file" name="userfile" data-submit="restore" accept=".sql">
                                                                                <span class="input-group-btn">
                                                                                    <button type="button" class="btn btn-info btn-flat" id="file_browser" style="height: 34px;"><i class="fa fa-search"></i> Browse</button>
                                                                                </span>
                                                                            </div>
                                                                            <button type="submit" id="restore" class="btn btn-success btn-flat" disabled="disabled" style="height: 34px; padding: 0 16px; display: inline-flex; align-items: center; justify-content: center; border-radius: 4px; gap: 6px; white-space: nowrap;">
                                                                                <i class="fa fa-refresh"></i> Restore
                                                                            </button>
                                                                        </div>
                                                                        <div style="margin-top: 8px;">
                                                                            <label for="hapus_token" style="font-weight: normal; cursor: pointer; margin-bottom: 0;">
                                                                                <input type="checkbox" id="hapus_token" name="hapus_token" value="N" style="vertical-align: middle; margin: 0 6px 0 0;">
                                                                                Amankan Token Layanan Saat Ini
                                                                            </label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php endif ?>

                            <div class="col-md-12">
                                <div class="box-header with-border">
                                    <h3 class="box-title"><strong>Restore Folder Desa </strong></h3>
                                </div>
                                <div class="box-body">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <p>Backup yang dibuat dapat dipergunakan untuk mengembalikan folder desa anda apabila ada masalah. Klik tombol Restore di bawah untuk menggantikan folder desa dengan data hasil backup terdahulu.</p>
                                            <p>Batas maksimal pengunggahan berkas <strong><?= max_upload() ?> MB.</strong></p>
                                            <p>Proses ini akan membutuhkan waktu beberapa menit, menyesuaikan dengan spesifikasi komputer server SID dan sambungan internet yang tersedia.</p>
                                            <p></p>
                                            <table class="table table-bordered">
                                                    <tbody>
                                                        <tr>
                                                            <td style="padding: 15px 20px;">
                                                                <div class="form-group" style="margin-bottom: 0;">
                                                                    <label for="file1" class="col-sm-3 col-md-2 control-label" style="text-align: left; padding-top: 7px;">Pilih File .zip:</label>
                                                                    <div class="col-sm-9 col-md-8 col-lg-7">
                                                                        <div style="display: flex; align-items: center; gap: 10px; flex-wrap: wrap;">
                                                                            <div class="input-group" style="flex: 1; min-width: 260px;">
                                                                                <input type="text" class="form-control" id="file_path1" name="folder_desa">
                                                                                <input type="file" class="hidden" id="file1" name="folder_desa" data-submit="restore-desa" accept="zip,application/zip,application/x-zip,application/x-zip-compressed">
                                                                                <span class="input-group-btn">
                                                                                    <button type="button" class="btn btn-info btn-flat" id="file_browser1" style="height: 34px;"><i class="fa fa-search"></i> Browse</button>
                                                                                </span>
                                                                            </div>
                                                                            <button type="button" id="restore-desa" class="btn btn-success btn-flat <?= jecho($restore, true, 'hidden') ?>" disabled="disabled" style="height: 34px; padding: 0 16px; display: inline-flex; align-items: center; justify-content: center; border-radius: 4px; gap: 6px; white-space: nowrap;">
                                                                                <i class="fa fa-refresh"></i> Restore
                                                                            </button>
                                                                            <a class="btn btn-warning btn-flat <?= jecho($restore, false, 'hidden') ?>" href="<?= site_url('database/batal_restore'); ?>" style="height: 34px; padding: 0 16px; display: inline-flex; align-items: center; justify-content: center; border-radius: 4px; gap: 6px; white-space: nowrap;">
                                                                                <i class="fa fa-times"></i> Batalkan proses restore
                                                                            </a>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<link rel="stylesheet" href="<?= asset('js/sweetalert2/sweetalert2.min.css') ?>">
<script src="<?= asset('js/sweetalert2/sweetalert2.all.min.js') ?>"></script>
<script src="<?= asset('js/backup.min.js') ?>"></script>

<?php if (! $memory_limit) : ?>
    <script>
        $("#maincontent").prepend(
            `
            <div class="callout callout-warning">
                <h4><i class="fa fa-warning"></i>&nbsp;&nbsp;Informasi</h4>
                <p>Backup tidak dapat dilakukan karena keterbatasan memori belum sesuai, silahkan periksa <a href="<?= base_url('info_sistem#ekstensi') ?>">disini.</a></p>
            </div>
            `
        );
    </script>
<?php endif ?>

