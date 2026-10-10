<?php if(!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10">
    <?php if (count($gallery) > 0): ?>
        <?php foreach ($gallery as $item): ?>
            <?php if (is_file(LOKASI_GALERI . "sedang_" . $item['gambar'])): ?>
                <?php $sub = site_url("galeri/" . $item['id']); ?>
                <article class="group relative flex flex-col bg-white dark:bg-slate-800 rounded-[2.5rem] border border-slate-100 dark:border-slate-700 overflow-hidden hover:shadow-2xl hover:shadow-slate-200 dark:hover:shadow-slate-950 transition-all duration-500">
                    <!-- Image Box -->
                    <div class="relative h-72 overflow-hidden bg-slate-100 dark:bg-slate-900">
                        <img loading="lazy" src="<?= AmbilGaleri($item['gambar'], 'sedang') ?>" alt="<?= html_escape($item['nama']) ?>" class="w-full h-full object-cover transition-transform duration-1000 group-hover:scale-110" />
                        
                        <!-- Overlay on Hover -->
                        <div class="absolute inset-0 bg-brand-900/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                            <div class="w-16 h-16 rounded-full bg-white/20 backdrop-blur-md border border-white/30 flex items-center justify-center text-white text-2xl scale-50 group-hover:scale-100 transition-transform duration-500">
                                <i class="fa-solid fa-folder-open"></i>
                            </div>
                        </div>

                        <!-- Date Badge -->
                        <div class="absolute top-6 left-6">
                            <span class="px-4 py-2 rounded-xl bg-white/90 dark:bg-slate-900/90 backdrop-blur-md text-[10px] font-black text-brand-600 dark:text-brand-400 uppercase tracking-widest shadow-sm border border-white dark:border-slate-800">
                                <?= tgl_indo($item['tgl_upload']) ?>
                            </span>
                        </div>
                    </div>

                    <!-- Content Box -->
                    <div class="p-8 flex-1 flex flex-col items-center text-center">
                        <h3 class="font-display font-bold text-xl text-slate-900 dark:text-white leading-snug mb-2 group-hover:text-brand-600 transition-colors">
                            <a href="<?= $sub ?>"><?= $item['nama'] ?></a>
                        </h3>
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-[0.2em] mb-8">Koleksi Foto</p>
                        
                        <div class="mt-auto w-full pt-6 border-t border-slate-50 dark:border-slate-700/50">
                            <a href="<?= $sub ?>" class="inline-flex items-center gap-3 px-8 py-3 bg-slate-50 dark:bg-slate-700 text-slate-900 dark:text-white font-black text-[10px] rounded-2xl transition-all hover:bg-brand-600 hover:text-white uppercase tracking-widest">
                                Buka Album
                                <i class="fa-solid fa-arrow-right-long text-xs"></i>
                            </a>
                        </div>
                    </div>
                </article>
            <?php endif; ?>
        <?php endforeach; ?>
    <?php else: ?>
        <!-- Empty State -->
        <div class="col-span-full py-32 flex flex-col items-center text-center">
            <div class="w-32 h-32 rounded-[3rem] bg-slate-100 dark:bg-slate-800 flex items-center justify-center text-slate-300 dark:text-slate-600 text-5xl mb-8 shadow-inner">
                <i class="fa-solid fa-images"></i>
            </div>
            <h3 class="font-display font-extrabold text-2xl text-slate-900 dark:text-white tracking-tight">Belum Ada Album Foto</h3>
            <p class="text-slate-400 font-medium max-w-sm mt-3">Maaf, dokumentasi visual belum diunggah untuk kategori ini.</p>
        </div>
    <?php endif; ?>
</div>

<!-- PAGINATION -->
<?php if ((int)$paging->end_link > 1): ?>
    <div class="mt-20 flex justify-center">
        <nav class="inline-flex p-2 bg-white dark:bg-slate-800 rounded-3xl border border-slate-100 dark:border-slate-700 shadow-sm gap-1">
            <?php if ($paging->start_link): ?>
                <a href="<?= site_url("first/gallery/" . $paging->start_link) ?>" class="w-12 h-12 flex items-center justify-center rounded-2xl text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-700 hover:text-brand-600 transition-all">
                    <i class="fa-solid fa-angles-left text-xs"></i>
                </a>
            <?php endif; ?>
            
            <?php if ($paging->prev): ?>
                <a href="<?= site_url("first/gallery/" . $paging->prev) ?>" class="w-12 h-12 flex items-center justify-center rounded-2xl text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-700 hover:text-brand-600 transition-all">
                    <i class="fa-solid fa-angle-left text-xs"></i>
                </a>
            <?php endif; ?>

            <?php for ($i = $paging->start_link; $i <= $paging->end_link; $i++): $isActive = ($p == $i); ?>
                <a href="<?= site_url("first/gallery/" . $i) ?>" class="w-12 h-12 flex items-center justify-center rounded-2xl text-sm font-display font-black transition-all <?= $isActive ? 'bg-brand-600 text-white shadow-lg shadow-brand-600/30' : 'text-slate-500 hover:bg-brand-50 dark:hover:bg-brand-900/40 hover:text-brand-600' ?>">
                    <?= $i ?>
                </a>
            <?php endfor; ?>

            <?php if ($paging->next): ?>
                <a href="<?= site_url("first/gallery/" . $paging->next) ?>" class="w-12 h-12 flex items-center justify-center rounded-2xl text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-700 hover:text-brand-600 transition-all">
                    <i class="fa-solid fa-angle-right text-xs"></i>
                </a>
            <?php endif; ?>

            <?php if ($paging->end_link): ?>
                <a href="<?= site_url("first/gallery/" . $paging->end_link) ?>" class="w-12 h-12 flex items-center justify-center rounded-2xl text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-700 hover:text-brand-600 transition-all">
                    <i class="fa-solid fa-angles-right text-xs"></i>
                </a>
            <?php endif; ?>
        </nav>
    </div>
<?php endif; ?>
