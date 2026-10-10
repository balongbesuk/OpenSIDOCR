<?php if(!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<div class="mb-10 group/widget">
    <div class="premium-card overflow-hidden">
        <div class="p-8 border-b border-slate-50 dark:border-slate-800 flex items-center justify-between bg-slate-50/30 dark:bg-slate-800/20">
            <h3 class="premium-h1 text-xs uppercase tracking-[0.2em] flex items-center gap-3">
                <div class="w-1.5 h-8 bg-pink-500 rounded-full"></div>
                <?= $judul_widget ?>
            </h3>
        </div>
        <div class="p-8">
            <div class="space-y-6">
                <?php foreach($komentar as $data): ?>
                    <div class="flex flex-col gap-4 p-6 rounded-[2rem] bg-slate-50/50 dark:bg-slate-800/20 border border-slate-100 dark:border-slate-800/60 relative group/item transition-all hover:bg-white dark:hover:bg-slate-800 hover:shadow-xl hover:shadow-pink-500/5">
                        <div class="flex items-center gap-4">
                            <div class="w-10 h-10 rounded-2xl bg-gradient-to-br from-pink-500 to-rose-600 flex items-center justify-center text-white text-sm font-black shadow-lg shadow-pink-500/20">
                                <?= strtoupper(substr($data['owner'], 0, 1)) ?>
                            </div>
                            <div class="leading-none">
                                <p class="text-xs font-black text-slate-900 dark:text-white"><?= $data['owner'] ?></p>
                                <p class="text-[8px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest mt-1.5"><?= tgl_indo($data['tgl_upload']) ?></p>
                            </div>
                        </div>
                        <p class="premium-p text-xs italic line-clamp-3 leading-relaxed">
                            "<?= current(explode("\n", strip_tags($data['komentar']))) ?>..."
                        </p>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>
