<?php if(!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<div class="mb-10 group/widget">
    <div class="premium-card overflow-hidden">
        <div class="p-8 border-b border-slate-50 dark:border-slate-800 flex items-center justify-between bg-slate-50/30 dark:bg-slate-800/20">
            <h3 class="premium-h1 text-xs uppercase tracking-[0.2em] flex items-center gap-3">
                <div class="w-1.5 h-8 bg-emerald-500 rounded-full"></div>
                Sinergitas Program
            </h3>
        </div>
        <div class="p-8">
            <div class="space-y-6">
                <?php foreach($sinergitas_program as $data): ?>
                    <a href="<?= html_escape($data['link']) ?>" target="_blank" rel="noopener noreferrer" class="block group/program relative overflow-hidden rounded-[2rem] border-4 border-white dark:border-slate-800 shadow-xl shadow-slate-200/40 dark:shadow-none hover:-translate-y-2 hover:shadow-2xl hover:shadow-brand-600/10 transition-all duration-500">
                        <img loading="lazy" src="<?= base_url(LOKASI_GAMBAR_WIDGET.$data['gambar']) ?>" 
                             alt="<?= html_escape($data['judul']) ?>" 
                             class="w-full h-auto grayscale-[0.5] group-hover/program:grayscale-0 transition-all duration-700" />
                        <div class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent"></div>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>
