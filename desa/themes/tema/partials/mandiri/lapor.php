<?php  if(!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<div class="list-frame animate-premium">
    <div class="flex items-center gap-4 mb-8">
        <div class="w-1.5 h-8 bg-brand-600 rounded-full"></div>
        <h2 class="premium-h1 text-2xl uppercase tracking-widest">Laporan Penduduk</h2>
    </div>

    <?php $label = !empty($_SESSION['validation_error']) ? 'bg-red-50 text-red-600 border-red-100' : 'bg-brand-50 text-brand-600 border-brand-100'; ?>
    <?php if ($flash_message): ?>
        <div class="p-6 rounded-[2rem] border <?= $label ?> mb-8 font-bold text-sm uppercase tracking-wide animate-slide-up">
            <?= $flash_message ?>
        </div>
    <?php endif; ?>

    <p class="text-slate-400 font-bold uppercase text-[10px] tracking-[0.2em] mb-10 flex items-center gap-2">
        <i class="fa-solid fa-comments text-brand-600"></i>
        Silahkan laporkan perubahan data kependudukan anda.
    </p>

    <form id="validasi" action="<?= site_url('lapor/insert') ?>" method="POST" onSubmit="return validasi(this);" class="space-y-8">
        <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <div class="space-y-2">
                <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-4">Pengirim</label>
                <input class="w-full h-16 px-8 rounded-2xl bg-slate-50 dark:bg-slate-800/40 border-none focus:ring-4 focus:ring-brand-500/10 font-bold text-sm text-slate-400 cursor-not-allowed uppercase" type="text" readonly="readonly" name="owner" value="<?= $_SESSION['nama'] ?>"/>
            </div>
            <div class="space-y-2">
                <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-4">NIK</label>
                <input class="w-full h-16 px-8 rounded-2xl bg-slate-50 dark:bg-slate-800/40 border-none focus:ring-4 focus:ring-brand-500/10 font-bold text-sm text-slate-400 cursor-not-allowed uppercase" type="text" readonly="readonly" name="email" value="<?= $_SESSION['nik'] ?>"/>
            </div>
        </div>

        <div class="space-y-2">
            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-4">Isi Laporan / Komentar</label>
            <textarea name="komentar" rows="6" class="w-full p-8 rounded-[2.5rem] bg-slate-50 dark:bg-slate-800/40 border-none focus:ring-4 focus:ring-brand-500/10 font-medium text-sm text-slate-600 dark:text-slate-300 leading-relaxed min-h-[150px]" placeholder="Jelaskan detail laporan Anda..."></textarea>
        </div>

        <div class="pt-6 border-t border-slate-100 dark:border-slate-800">
            <button type="submit" class="w-full md:w-auto h-16 px-12 bg-slate-900 dark:bg-brand-600 text-white rounded-[2rem] font-black text-xs uppercase tracking-widest shadow-2xl hover:bg-brand-600 dark:hover:bg-brand-500 hover:scale-105 active:scale-95 transition-all">
                Kirim Laporan
            </button>
        </div>
    </form>
</div>