<?php if(!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<!-- [GALLERY GRID: MASONRY-INSPIRED] -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8 md:gap-12">
    <?php if (count($gallery) > 0): ?>
        <?php foreach ($gallery as $index => $item): ?>
            <?php if (is_file(LOKASI_GALERI . "sedang_" . $item['gambar'])): ?>
                <!-- Individual Photo Card -->
                <article class="group relative perspective-1000">
                    <div class="relative aspect-[3/4] overflow-hidden rounded-[3rem] bg-slate-100 dark:bg-slate-900 border-[12px] border-white dark:border-slate-800 shadow-xl group-hover:shadow-[0_45px_100px_-20px_rgba(59,130,246,0.25)] transition-all duration-700 group-hover:-translate-y-4">
                        
                        <!-- Main Image -->
                        <img loading="lazy" src="<?= AmbilGaleri($item['gambar'], 'sedang') ?>" alt="<?= html_escape($item['nama']) ?>" class="w-full h-full object-cover transition-transform duration-1000 group-hover:scale-110" />
                        
                        <!-- Premium Glass Overlay -->
                        <a href="<?= AmbilGaleri($item['gambar'], 'sedang') ?>" 
                           class="fancybox absolute inset-0 z-10 bg-gradient-to-t from-brand-900/80 via-brand-900/20 to-transparent opacity-0 group-hover:opacity-100 transition-all duration-500 flex flex-col items-center justify-end p-10 text-center" 
                           rel="<?= $parent['id'] ?>" 
                           title="<?= $item['nama'] ?>">
                            
                            <!-- Floating Zoom Icon -->
                            <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-20 h-20 rounded-full bg-white/20 backdrop-blur-xl border border-white/30 flex items-center justify-center text-white scale-0 group-hover:scale-100 transition-transform duration-700 delay-100">
                                <i class="fa-solid fa-expand text-2xl"></i>
                            </div>

                            <!-- Photo Title/Caption -->
                            <div class="translate-y-10 group-hover:translate-y-0 transition-transform duration-500 delay-200">
                                <span class="block text-[10px] font-black text-brand-300 uppercase tracking-[0.4em] mb-4">Zoom Gallery</span>
                                <h4 class="text-white font-display font-extrabold text-lg leading-tight line-clamp-2 italic">
                                    "<?= $item['nama'] ?>"
                                </h4>
                            </div>
                        </a>

                        <!-- Index Badge -->
                        <div class="absolute top-6 right-6 z-20 w-10 h-10 rounded-full bg-white dark:bg-slate-800 text-slate-900 dark:text-white flex items-center justify-center font-display font-black text-xs shadow-lg opacity-0 group-hover:opacity-100 transition-opacity">
                            <?= str_pad($index + 1, 2, '0', STR_PAD_LEFT) ?>
                        </div>
                    </div>
                </article>
            <?php endif; ?>
        <?php endforeach; ?>
    <?php else: ?>
        <!-- Premium Empty State -->
        <div class="col-span-full py-40 flex flex-col items-center text-center">
            <div class="relative mb-12">
                <div class="absolute inset-0 bg-brand-500/20 blur-[100px] rounded-full"></div>
                <div class="relative w-40 h-40 rounded-[4rem] bg-white dark:bg-slate-900 flex items-center justify-center text-slate-200 dark:text-slate-700 text-7xl shadow-2xl border border-slate-50 dark:border-slate-800">
                    <i class="fa-solid fa-camera-rotate animate-pulse"></i>
                </div>
            </div>
            <h3 class="font-display font-[900] text-3xl text-slate-900 dark:text-white mb-4 tracking-tight">Koleksi Masih Kosong.</h3>
            <p class="text-slate-400 font-medium max-w-sm mx-auto leading-relaxed">Pemerintah desa sedang mengumpulkan dokumentasi terbaik untuk album ini. Mohon kembali lagi nanti.</p>
        </div>
    <?php endif; ?>
</div>

<!-- [REFINED PAGINATION SYSTEM] -->
<?php if ((int)$paging->end_link > 1): ?>
    <div class="mt-32 flex flex-col items-center gap-10">
        <div class="w-24 h-px bg-slate-200 dark:bg-slate-800"></div>
        <nav class="inline-flex p-3 bg-white dark:bg-slate-900 rounded-[2.5rem] border border-slate-100 dark:border-slate-800 shadow-2xl shadow-slate-200/50 dark:shadow-none gap-2">
            <?php if ($paging->start_link): ?>
                <a href="<?= site_url("galeri/$parent[id]/index/$paging->start_link") ?>" class="w-14 h-14 flex items-center justify-center rounded-2xl text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800 hover:text-brand-600 transition-all group">
                    <i class="fa-solid fa-angles-left text-xs group-hover:-translate-x-1 transition-transform"></i>
                </a>
            <?php endif; ?>
            
            <?php if ($paging->prev): ?>
                <a href="<?= site_url("galeri/$parent[id]/index/$paging->prev") ?>" class="w-14 h-14 flex items-center justify-center rounded-2xl text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800 hover:text-brand-600 transition-all group">
                    <i class="fa-solid fa-angle-left text-xs group-hover:-translate-x-1 transition-transform"></i>
                </a>
            <?php endif; ?>

            <?php for ($i = $paging->start_link; $i <= $paging->end_link; $i++): $isActive = ($p == $i); ?>
                <a href="<?= site_url("galeri/$parent[id]/index/$i") ?>" 
                   class="w-14 h-14 flex items-center justify-center rounded-2xl text-sm font-display font-black transition-all duration-500 <?= $isActive ? 'bg-brand-600 text-white shadow-xl shadow-brand-600/40 scale-110 translate-y-[-4px]' : 'text-slate-500 hover:bg-brand-50 dark:hover:bg-brand-800 hover:text-brand-600' ?>">
                    <?= $i ?>
                </a>
            <?php endfor; ?>

            <?php if ($paging->next): ?>
                <a href="<?= site_url("galeri/$parent[id]/index/$paging->next") ?>" class="w-14 h-14 flex items-center justify-center rounded-2xl text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800 hover:text-brand-600 transition-all group">
                    <i class="fa-solid fa-angle-right text-xs group-hover:translate-x-1 transition-transform"></i>
                </a>
            <?php endif; ?>

            <?php if ($paging->end_link): ?>
                <a href="<?= site_url("galeri/$parent[id]/index/$paging->end_link") ?>" class="w-14 h-14 flex items-center justify-center rounded-2xl text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800 hover:text-brand-600 transition-all group">
                    <i class="fa-solid fa-angles-right text-xs group-hover:translate-x-1 transition-transform"></i>
                </a>
            <?php endif; ?>
        </nav>
        <p class="text-[10px] font-black text-slate-300 dark:text-slate-600 uppercase tracking-[0.4em]">Halaman <?= $p ?> dari <?= $paging->end_link ?></p>
    </div>
<?php endif; ?>

<style>
    .perspective-1000 { perspective: 1000px; }
    .line-clamp-2 { display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
</style>
