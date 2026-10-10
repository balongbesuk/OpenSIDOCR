<?php if(!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<div class="mb-10 group/widget">
    <div class="premium-card overflow-hidden">
        <div class="p-8 border-b border-slate-50 dark:border-slate-800 flex items-center justify-between bg-slate-50/30 dark:bg-slate-800/20">
            <h3 class="premium-h1 text-xs uppercase tracking-[0.2em] flex items-center gap-3">
                <div class="w-1.5 h-8 bg-brand-600 rounded-full"></div>
                <?= $judul_widget ?>
            </h3>
        </div>
        <div class="p-8">
            <div class="space-y-6">
                <?php foreach ($stat_widget as $data): ?>
                    <div class="relative group/item">
                        <div class="flex justify-between items-center mb-2 px-1">
                            <span class="text-[10px] font-black text-slate-500 dark:text-slate-400 uppercase tracking-widest"><?= $data['nama'] ?></span>
                            <span class="text-sm font-black text-slate-900 dark:text-white"><?= $data['jumlah'] ?></span>
                        </div>
                        <div class="h-2.5 w-full bg-slate-50 dark:bg-slate-800/50 rounded-full overflow-hidden border border-slate-100 dark:border-slate-800 shadow-inner">
                            <div class="h-full bg-gradient-to-r from-brand-500 to-brand-700 rounded-full transition-all duration-[1.5s] group-hover/item:scale-x-105 origin-left" style="width: <?= $data['persen'] ?>%"></div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <a href="<?= site_url('data-statistik/pekerjaan') ?>" class="mt-10 group/btn flex items-center justify-center gap-3 w-full py-5 rounded-2xl bg-slate-900 text-white font-display font-black text-[10px] uppercase tracking-[0.2em] shadow-xl shadow-slate-900/20 hover:bg-brand-600 hover:shadow-brand-600/30 transition-all">
                Detail Statistik
                <i class="fa-solid fa-arrow-right-long transition-transform group-hover/btn:translate-x-2"></i>
            </a>
        </div>
    </div>
</div>
