<?php if(!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<?php if ((int)$paging->end_link > 1): ?>
    <div class="flex flex-col items-center gap-10">
        <div class="w-24 h-px bg-slate-200 dark:bg-slate-800"></div>
        <nav class="inline-flex p-3 bg-white dark:bg-slate-900 rounded-[2.5rem] border border-slate-100 dark:border-slate-800 shadow-2xl shadow-slate-200/50 dark:shadow-none gap-2">
            
            <?php if ($paging->start_link): ?>
                <a href="<?= site_url($paging_page."/index/".$paging->start_link) ?>" class="w-14 h-14 flex items-center justify-center rounded-2xl text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800 hover:text-brand-600 transition-all group" aria-label="Halaman Pertama">
                    <i class="fa-solid fa-angles-left text-xs group-hover:-translate-x-1 transition-transform" aria-hidden="true"></i>
                </a>
            <?php endif; ?>
            
            <?php if ($paging->prev): ?>
                <a href="<?= site_url($paging_page."/index/".$paging->prev) ?>" class="w-14 h-14 flex items-center justify-center rounded-2xl text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800 hover:text-brand-600 transition-all group" aria-label="Halaman Sebelumnya">
                    <i class="fa-solid fa-angle-left text-xs group-hover:-translate-x-1 transition-transform" aria-hidden="true"></i>
                </a>
            <?php endif; ?>

            <?php for ($i = $paging->start_link; $i <= $paging->end_link; $i++): $isActive = ($p == $i); ?>
                <a href="<?= site_url($paging_page."/index/".$i) ?>" 
                   class="w-14 h-14 flex items-center justify-center rounded-2xl text-sm font-display font-black transition-all duration-500 <?= $isActive ? 'bg-brand-600 text-white shadow-xl shadow-brand-600/40 scale-110 translate-y-[-4px]' : 'text-slate-500 hover:bg-brand-50 dark:hover:bg-brand-800 hover:text-brand-600' ?>" 
                   aria-label="Halaman <?= $i ?>" <?= $isActive ? 'aria-current="page"' : '' ?>>
                    <?= $i ?>
                </a>
            <?php endfor; ?>

            <?php if ($paging->next): ?>
                <a href="<?= site_url($paging_page."/index/".$paging->next) ?>" class="w-14 h-14 flex items-center justify-center rounded-2xl text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800 hover:text-brand-600 transition-all group" aria-label="Halaman Berikutnya">
                    <i class="fa-solid fa-angle-right text-xs group-hover:translate-x-1 transition-transform" aria-hidden="true"></i>
                </a>
            <?php endif; ?>

            <?php if ($paging->end_link): ?>
                <a href="<?= site_url($paging_page."/index/".$paging->end_link) ?>" class="w-14 h-14 flex items-center justify-center rounded-2xl text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800 hover:text-brand-600 transition-all group" aria-label="Halaman Terakhir">
                    <i class="fa-solid fa-angles-right text-xs group-hover:translate-x-1 transition-transform" aria-hidden="true"></i>
                </a>
            <?php endif; ?>
            
        </nav>
        <p class="text-[10px] font-black text-slate-300 dark:text-slate-600 uppercase tracking-[0.4em]">Halaman <?= $p ?> dari <?= $paging->end_link ?></p>
    </div>
<?php endif; ?>
