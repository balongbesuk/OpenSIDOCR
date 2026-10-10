<?php if(!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<div class="mb-10 group/widget">
    <div class="premium-card overflow-hidden">
        <div class="p-8 border-b border-slate-50 dark:border-slate-800 flex items-center justify-between bg-slate-50/30 dark:bg-slate-800/20">
            <h3 class="premium-h1 text-xs uppercase tracking-[0.2em] flex items-center gap-3">
                <div class="w-1.5 h-8 bg-indigo-500 rounded-full"></div>
                <?= $judul_widget ?>
            </h3>
        </div>
        <div class="p-8">
            <div class="grid grid-cols-2 gap-4">
                <?php foreach($galeri as $data): ?>
                    <a href="<?= site_url("artikel/galeri/$data[id]") ?>" class="aspect-square rounded-[1.5rem] overflow-hidden group/gal relative border-2 border-white dark:border-slate-800 shadow-sm">
                        <img loading="lazy" src="<?= AmbilGaleri($data['gambar'], 'kecil') ?>" alt="<?= html_escape($data['nama']) ?>" class="w-full h-full object-cover transition-transform duration-1000 group-hover/gal:scale-125 group-hover/gal:rotate-6" />
                        <div class="absolute inset-0 bg-brand-900/60 opacity-0 group-hover/gal:opacity-100 transition-opacity flex items-center justify-center backdrop-blur-[2px]">
                            <i class="fa-solid fa-magnifying-glass-plus text-white text-xl translate-y-4 group-hover/gal:translate-y-0 transition-transform"></i>
                        </div>
                    </a>
                <?php endforeach; ?>
            </div>
            
            <a href="<?= site_url('first/gallery') ?>" class="mt-8 group/btn flex items-center justify-center gap-3 w-full py-4 rounded-2xl bg-slate-50 dark:bg-slate-800/50 text-slate-400 dark:text-slate-500 font-display font-black text-[10px] uppercase tracking-[0.2em] hover:bg-brand-600 hover:text-white transition-all shadow-sm">
                Lihat Semua Galeri
                <i class="fa-solid fa-images transition-transform group-hover/btn:scale-110"></i>
            </a>
        </div>
    </div>
</div>
