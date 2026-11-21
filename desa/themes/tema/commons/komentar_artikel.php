<?php if(!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<div id="kolom-komentar" class="relative z-10 space-y-8">
    <?php $notif = $this->session->flashdata('notif'); ?>
    <?php if (is_array($notif) && !empty($notif['pesan'])): ?>
        <div role="alert" class="p-4 rounded-2xl border text-sm font-medium <?= ($notif['status'] ?? 0) == 1 ? 'bg-emerald-50 border-emerald-200 text-emerald-800 dark:bg-emerald-950/40 dark:border-emerald-800 dark:text-emerald-200' : 'bg-rose-50 border-rose-200 text-rose-800 dark:bg-rose-950/40 dark:border-rose-800 dark:text-rose-200' ?>">
            <?= $notif['pesan'] ?>
        </div>
    <?php endif; ?>

    <?php if (!empty($komentar)): ?>
        <div class="space-y-4">
            <?php foreach ($komentar as $data): ?>
                <div class="p-5 rounded-2xl bg-slate-50 dark:bg-slate-800/50 border border-slate-100 dark:border-slate-700/60">
                    <div class="flex items-center justify-between gap-3 mb-2">
                        <span class="font-bold text-sm text-slate-900 dark:text-white"><?= htmlspecialchars((string) $data['owner'], ENT_QUOTES, 'UTF-8', false) ?></span>
                        <span class="text-xs text-slate-500 dark:text-slate-400"><?= tgl_indo2($data['tgl_upload']) ?></span>
                    </div>
                    <p class="text-sm text-slate-700 dark:text-slate-300 leading-relaxed"><?= nl2br(htmlspecialchars((string) $data['komentar'], ENT_QUOTES, 'UTF-8', false)) ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <p class="text-sm text-slate-500 dark:text-slate-400">Belum ada komentar. Jadilah yang pertama berkomentar.</p>
    <?php endif; ?>

    <?php if (($single_artikel['boleh_komentar'] ?? 0) == 1): ?>
        <?php $old = is_array($notif['data'] ?? null) ? $notif['data'] : []; ?>
        <form action="<?= site_url("first/add_comment/{$single_artikel['id']}") ?>" method="post" class="space-y-4 pt-6 border-t border-slate-100 dark:border-slate-800">
            <?php if ($this->config->config['csrf_protection']): ?>
                <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>">
            <?php endif; ?>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="space-y-1.5">
                    <label for="komentar-owner" class="block text-xs font-bold text-slate-700 dark:text-slate-300">Nama <span aria-hidden="true">*</span></label>
                    <input id="komentar-owner" name="owner" type="text" maxlength="50" autocomplete="name" required value="<?= html_escape($old['owner'] ?? '') ?>"
                        class="w-full h-11 px-4 rounded-xl bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-sm text-slate-900 dark:text-white focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-brand-600">
                </div>
                <div class="space-y-1.5">
                    <label for="komentar-hp" class="block text-xs font-bold text-slate-700 dark:text-slate-300">No. HP <span aria-hidden="true">*</span></label>
                    <input id="komentar-hp" name="no_hp" type="tel" inputmode="numeric" pattern="[0-9]+" maxlength="15" autocomplete="tel" required value="<?= html_escape($old['no_hp'] ?? '') ?>"
                        oninput="this.value = this.value.replace(/[^0-9]/g, '');"
                        class="w-full h-11 px-4 rounded-xl bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-sm text-slate-900 dark:text-white focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-brand-600">
                </div>
                <div class="space-y-1.5">
                    <label for="komentar-email" class="block text-xs font-bold text-slate-700 dark:text-slate-300">Email</label>
                    <input id="komentar-email" name="email" type="email" maxlength="50" autocomplete="email" value="<?= html_escape($old['email'] ?? '') ?>"
                        class="w-full h-11 px-4 rounded-xl bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-sm text-slate-900 dark:text-white focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-brand-600">
                </div>
            </div>

            <div class="space-y-1.5">
                <label for="komentar-isi" class="block text-xs font-bold text-slate-700 dark:text-slate-300">Komentar (maks. 200 karakter) <span aria-hidden="true">*</span></label>
                <textarea id="komentar-isi" name="komentar" rows="4" maxlength="200" required
                    class="w-full p-4 rounded-xl bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-sm text-slate-900 dark:text-white focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-brand-600"><?= html_escape($old['komentar'] ?? '') ?></textarea>
            </div>

            <div class="flex flex-wrap items-end gap-4">
                <div class="flex items-center gap-2">
                    <img id="komentar-captcha-img" src="<?= site_url('captcha') ?>" width="180" height="50" alt="Kode Captcha" class="rounded-xl border border-slate-200 dark:border-slate-700 bg-white">
                    <button type="button" aria-label="Muat ulang captcha"
                        onclick="document.getElementById('komentar-captcha-img').src='<?= site_url('captcha') ?>?'+Date.now();"
                        class="w-11 h-11 rounded-xl bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-200 hover:bg-slate-200 dark:hover:bg-slate-700 flex items-center justify-center focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-brand-600">
                        <i class="fa-solid fa-rotate-right" aria-hidden="true"></i>
                    </button>
                </div>
                <div class="space-y-1.5 flex-1 min-w-[180px]">
                    <label for="komentar-captcha" class="block text-xs font-bold text-slate-700 dark:text-slate-300">Kode Captcha <span aria-hidden="true">*</span></label>
                    <input id="komentar-captcha" name="captcha_code" type="text" autocomplete="off" required
                        class="w-full h-11 px-4 rounded-xl bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-sm text-slate-900 dark:text-white focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-brand-600">
                </div>
                <button type="submit" class="h-11 px-6 rounded-xl bg-brand-600 hover:bg-brand-700 text-white font-bold text-sm transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-brand-600 focus-visible:ring-offset-2">
                    Kirim Komentar
                </button>
            </div>
        </form>
        <script>
            document.querySelectorAll('#kolom-komentar form [name]').forEach(function(el) {
                el.addEventListener('invalid', function() {
                    if (el.validity.valueMissing) el.setCustomValidity('Kolom ini wajib diisi.');
                    else if (el.validity.typeMismatch && el.type === 'email') el.setCustomValidity('Masukkan alamat email yang valid.');
                    else if (el.validity.patternMismatch) el.setCustomValidity('Masukkan hanya angka.');
                });
                el.addEventListener('input', function() { el.setCustomValidity(''); });
            });
        </script>
    <?php else: ?>
        <p class="text-sm text-slate-500 dark:text-slate-400 pt-2">Komentar dinonaktifkan untuk artikel ini.</p>
    <?php endif; ?>
</div>
