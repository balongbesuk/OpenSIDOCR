<?php
defined('BASEPATH') || exit('No direct script access allowed');
?>

<div class="space-y-8">
    <div>
        <h2 class="font-display text-2xl font-extrabold text-slate-900 mb-2">Pendaftaran Akun</h2>
        <p class="text-slate-500 text-sm font-medium">Lengkapi data diri untuk aktivasi Layanan Mandiri.</p>
    </div>

    <div class="space-y-6">
        <!-- Row 1: Nama & Tgl Lahir -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            <div class="space-y-2">
                <label class="text-xs font-bold text-slate-700 ml-1">Nama Lengkap</label>
                <div class="relative group">
                    <i class="fa-solid fa-user absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 group-focus-within:text-green-600 transition-colors"></i>
                    <input type="text" autocomplete="off" name="daftar_nama" placeholder="Sesuai KTP"
                        class="input-premium w-full h-12 rounded-xl pl-12 pr-4 text-sm font-semibold text-slate-900 required <?= jecho($cek_anjungan['keyboard'] == 1, true, 'kbvnumber'); ?>">
                </div>
            </div>
            
            <div class="space-y-2">
                <label class="text-xs font-bold text-slate-700 ml-1">Tanggal Lahir</label>
                <div class="relative group">
                    <i class="fa-solid fa-calendar absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 group-focus-within:text-green-600 transition-colors"></i>
                    <input type="text" id="daftar_tgl_lahir" name="daftar_tgl_lahir" placeholder="DD-MM-YYYY" autocomplete="off"
                        class="input-premium w-full h-12 rounded-xl pl-12 pr-4 text-sm font-semibold text-slate-900 required <?= jecho($cek_anjungan['keyboard'] == 1, true, 'kbvnumber'); ?>">
                </div>
            </div>
        </div>

        <!-- Row 2: NIK & PIN -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            <div class="space-y-2">
                <label class="text-xs font-bold text-slate-700 ml-1">NIK</label>
                <div class="relative group">
                    <i class="fa-solid fa-id-card absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 group-focus-within:text-green-600 transition-colors"></i>
                    <input type="text" autocomplete="off" name="daftar_nik" placeholder="16 Digit NIK" minlength="16" maxlength="16"
                        class="input-premium w-full h-12 rounded-xl pl-12 pr-4 text-sm font-semibold text-slate-900 required <?= jecho($cek_anjungan['keyboard'] == 1, true, 'kbvnumber'); ?>">
                </div>
            </div>
            
            <div class="space-y-2">
                <label class="text-xs font-bold text-slate-700 ml-1">PIN (6 Digit)</label>
                <div class="relative group">
                    <i class="fa-solid fa-key absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 group-focus-within:text-green-600 transition-colors"></i>
                    <input type="password" name="daftar_pin1" id="daftar_pin1" placeholder="Buat PIN" minlength="6" maxlength="6"
                        class="input-premium w-full h-12 rounded-xl pl-12 pr-12 text-sm font-semibold text-slate-900 required <?= jecho($cek_anjungan['keyboard'] == 1, true, 'kbvnumber'); ?>">
                    <button type="button" onclick="show(this);" class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 hover:text-green-600">
                        <i class="fa fa-eye-slash" id="baru1" aria-hidden="true"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Row 3: KK & Konfirmasi PIN -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            <div class="space-y-2">
                <label class="text-xs font-bold text-slate-700 ml-1">Nomor KK</label>
                <div class="relative group">
                    <i class="fa-solid fa-users absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 group-focus-within:text-green-600 transition-colors"></i>
                    <input type="text" autocomplete="off" name="daftar_kk" placeholder="16 Digit KK" minlength="16" maxlength="16"
                        class="input-premium w-full h-12 rounded-xl pl-12 pr-4 text-sm font-semibold text-slate-900 required <?= jecho($cek_anjungan['keyboard'] == 1, true, 'kbvnumber'); ?>">
                </div>
            </div>
            
            <div class="space-y-2">
                <label class="text-xs font-bold text-slate-700 ml-1">Konfirmasi PIN</label>
                <div class="relative group">
                    <i class="fa-solid fa-lock absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 group-focus-within:text-green-600 transition-colors"></i>
                    <input type="password" name="daftar_pin2" id="daftar_pin2" placeholder="Ulangi PIN" minlength="6" maxlength="6"
                        class="input-premium w-full h-12 rounded-xl pl-12 pr-12 text-sm font-semibold text-slate-900 required <?= jecho($cek_anjungan['keyboard'] == 1, true, 'kbvnumber'); ?>">
                    <button type="button" onclick="show(this);" class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 hover:text-green-600">
                        <i class="fa fa-eye-slash" id="baru2" aria-hidden="true"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Row 4-6: Uploads -->
        <div class="space-y-4 pt-4 border-t border-slate-100">
            <p class="text-[10px] text-slate-400 uppercase tracking-widest font-bold">Dokumen Verifikasi (Max 1MB)</p>
            
            <div class="space-y-3">
                <!-- Scan KTP -->
                <div class="relative group">
                    <input type="text" readonly id="file_path1" placeholder="Unggah Scan KTP / KIA"
                        class="input-premium w-full h-12 rounded-xl pl-12 pr-12 text-xs font-bold text-slate-600 cursor-pointer overflow-hidden text-ellipsis">
                    <i class="fa-solid fa-camera absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 transition-colors"></i>
                    <button type="button" id="file_browser1" class="absolute right-3 top-1/2 -translate-y-1/2 w-8 h-8 bg-slate-100 rounded-lg flex items-center justify-center text-slate-600 hover:bg-green-600 hover:text-white transition-all">
                        <i class="fa fa-search text-xs"></i>
                    </button>
                    <input id="file1" type="file" class="hidden required" name="scan_1">
                </div>

                <!-- Scan KK -->
                <div class="relative group">
                    <input type="text" readonly id="file_path2" placeholder="Unggah Scan KK"
                        class="input-premium w-full h-12 rounded-xl pl-12 pr-12 text-xs font-bold text-slate-600 cursor-pointer overflow-hidden text-ellipsis">
                    <i class="fa-solid fa-file-invoice absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 transition-colors"></i>
                    <button type="button" id="file_browser2" class="absolute right-3 top-1/2 -translate-y-1/2 w-8 h-8 bg-slate-100 rounded-lg flex items-center justify-center text-slate-600 hover:bg-green-600 hover:text-white transition-all">
                        <i class="fa fa-search text-xs"></i>
                    </button>
                    <input id="file2" type="file" class="hidden required" name="scan_2">
                </div>

                <!-- Selfie -->
                <div class="relative group">
                    <input type="text" readonly id="file_path3" placeholder="Foto Selfie Memegang KTP"
                        class="input-premium w-full h-12 rounded-xl pl-12 pr-12 text-xs font-bold text-slate-600 cursor-pointer overflow-hidden text-ellipsis">
                    <i class="fa-solid fa-camera-retro absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 transition-colors"></i>
                    <button type="button" id="file_browser3" class="absolute right-3 top-1/2 -translate-y-1/2 w-8 h-8 bg-slate-100 rounded-lg flex items-center justify-center text-slate-600 hover:bg-green-600 hover:text-white transition-all">
                        <i class="fa fa-search text-xs"></i>
                    </button>
                    <input id="file3" type="file" class="hidden required" name="scan_3">
                </div>
            </div>
            <p class="text-[10px] italic text-red-500 font-medium">* Format: JPG, JPEG, PNG, GIF</p>
        </div>

        <div class="pt-6 space-y-4">
            <button type="submit" class="btn-mandiri w-full h-14 rounded-2xl text-white font-display font-extrabold tracking-wide text-sm flex items-center justify-center space-x-3">
                <span>AKTIVASI AKUN</span>
                <i class="fa-solid fa-user-check text-lg"></i>
            </button>

            <a href="<?= site_url('layanan-mandiri/masuk') ?>" class="w-full h-12 flex items-center justify-center space-x-2 text-slate-400 hover:text-green-700 text-xs font-bold transition-colors">
                <span>SUDAH PUNYA AKUN? MASUK</span>
            </a>
        </div>
    </div>
</div>

<!-- Pesan Dialog Redesigned -->
<?php $info = $this->session->flashdata('info_pendaftaran'); ?>
<div class="modal fade" id="informasi" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="false" data-keyboard="false">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content overflow-hidden" style="border-radius: 2rem; border: none; box-shadow: 0 25px 50px -12px rgba(0,0,0,0.25);">
            <div class="modal-body p-10 text-center">
                <div class="w-20 h-20 bg-green-100 text-green-600 rounded-full flex items-center justify-center mx-auto mb-6">
                    <i class="fa-solid fa-circle-info text-4xl"></i>
                </div>
                <h3 class="font-display text-2xl font-black text-slate-900 mb-4 tracking-tight">Status Pendaftaran</h3>
                <div class="space-y-4 text-slate-600 text-sm font-medium leading-relaxed">
                    <?php if ($info['status'] == 1) : ?>
                        <div class="p-4 bg-slate-50 rounded-2xl border border-slate-100 space-y-2 mb-6">
                            <p>NIK: <span class="font-bold text-slate-900"><?= $info['nik']; ?></span></p>
                            <p>PIN BARU: <span class="font-bold text-green-600 text-lg tracking-widest"><?= $info['pin']; ?></span></p>
                        </div>
                        <p class="mb-8"><?= $info['pesan']; ?></p>
                        <a href="<?= $info['aksi'] ?>" class="btn-mandiri block w-full py-4 rounded-xl text-white font-bold uppercase tracking-widest text-xs">
                            Verifikasi Sekarang
                        </a>
                    <?php elseif ($info['status'] == 0) : ?>
                        <p class="mb-8 font-bold text-red-600"><?= $info['pesan']; ?></p>
                        <a href="<?= $info['aksi'] ?>" class="btn-mandiri block w-full py-4 rounded-xl text-white font-bold uppercase tracking-widest text-xs">
                            Masuk Ke Akun
                        </a>
                    <?php elseif ($info['status'] == -1) : ?>
                        <p class="mb-8 text-red-500 font-bold"><?= $info['pesan']; ?></p>
                        <button type="button" data-dismiss="modal" class="w-full py-4 bg-slate-100 text-slate-600 rounded-xl font-bold text-xs uppercase transition-colors hover:bg-slate-200">
                            Tutup
                        </button>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    ['1', '2', '3'].forEach(id => {
        $(`#file_browser${id}`).click(e => { e.preventDefault(); $(`#file${id}`).click(); });
        $(`#file${id}`).change(function() { 
            const name = $(this).val().split('\\').pop();
            $(`#file_path${id}`).val(name || $(this).val()); 
        });
        $(`#file_path${id}`).click(() => $(`#file_browser${id}`).click());
    });
</script>