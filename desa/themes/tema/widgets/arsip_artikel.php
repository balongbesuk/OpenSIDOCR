<?php if(!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<div class="mb-10 group/widget" id="arsip-widget-container">
    <div class="premium-card overflow-hidden">
        <!-- Header & Tabs -->
        <div class="p-8 pb-0 border-b border-slate-50 dark:border-slate-800 bg-slate-50/30 dark:bg-slate-800/20">
            <h3 class="premium-h1 text-[10px] uppercase tracking-[0.3em] mb-6 flex items-center gap-3">
                <i class="fa-solid fa-archive text-brand-600"></i>
                <?= html_escape($judul_widget) ?>
            </h3>
            
            <div class="flex gap-1 mb-[-1px]">
                <?php foreach (['terkini' => 'Terbaru', 'populer' => 'Populer', 'acak' => 'Acak'] as $id => $label): ?>
                    <button onclick="switchArsipTab('<?= $id ?>')" id="tab-btn-<?= $id ?>" 
                        class="arsip-tab-btn px-6 py-4 text-[10px] font-display font-black uppercase tracking-widest border-b-2 transition-all duration-300 <?= $id === 'terkini' ? 'border-brand-600 text-brand-600 dark:text-brand-400' : 'border-transparent text-slate-500 dark:text-slate-400 hover:text-slate-600 dark:hover:text-slate-200' ?>">
                        <?= html_escape($label) ?>
                    </button>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Tab Content -->
        <div class="p-4">
            <?php foreach (['terkini' => $arsip_terkini, 'populer' => $arsip_populer, 'acak' => $arsip_acak] as $id => $data_arsip): ?>
                <div id="panel-<?= $id ?>" class="arsip-panel space-y-2 <?= $id === 'terkini' ? 'block' : 'hidden' ?> animate-in fade-in slide-in-from-bottom-2 duration-500">
                    <?php if ($data_arsip): ?>
                        <?php foreach ($data_arsip as $arsip): ?>
                            <a href="<?= site_url('artikel/'.buat_slug($arsip)) ?>" class="flex gap-4 p-3 rounded-2xl hover:bg-slate-50 dark:hover:bg-slate-800/40 backdrop-blur-sm border border-transparent hover:border-slate-100 dark:hover:border-slate-700/50 transition-all group/item">
                                <!-- Thumbnail -->
                                <div class="w-16 h-16 rounded-xl overflow-hidden bg-slate-100 dark:bg-slate-800 shrink-0 shadow-sm border border-slate-50 dark:border-slate-700 skeleton">
                                    <?php if ($arsip['gambar'] && is_file(LOKASI_FOTO_ARTIKEL."kecil_".$arsip['gambar'])): ?>
                                        <img loading="lazy" src="<?= AmbilFotoArtikel($arsip['gambar'],'kecil') ?>" alt="<?= html_escape($arsip['judul']) ?>" class="w-full h-full object-cover group-hover/item:scale-110 transition-transform duration-700" />
                                    <?php else: ?>
                                        <div class="w-full h-full flex items-center justify-center text-slate-300 dark:text-slate-600">
                                            <i class="fa-solid fa-newspaper text-xl"></i>
                                        </div>
                                    <?php endif; ?>
                                </div>

                                <!-- Info -->
                                <div class="flex flex-col justify-center min-w-0 flex-1">
                                    <h4 class="text-[11px] font-display font-black text-slate-900 dark:text-slate-200 leading-snug line-clamp-2 group-hover/item:text-brand-600 dark:group-hover/item:text-brand-500 transition-colors">
                                        <?= html_escape($arsip['judul']) ?>
                                    </h4>
                                    <div class="flex items-center gap-3 mt-1.5">
                                        <span class="text-[8px] font-display font-black text-slate-500 dark:text-slate-400 uppercase tracking-widest flex items-center gap-1">
                                            <i class="fa-solid fa-eye text-[7px]"></i>
                                            <?= hit($arsip['hit']) ?>
                                        </span>
                                        <span class="text-[8px] font-display font-black text-slate-500 dark:text-slate-400 uppercase tracking-widest">
                                            <?= tgl_indo($arsip['tgl_upload']) ?>
                                        </span>
                                    </div>
                                </div>
                            </a>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="py-12 text-center">
                            <i class="fa-solid fa-folder-open text-slate-200 dark:text-slate-800 text-4xl mb-3"></i>
                            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Data belum tersedia</p>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
            
            <a href="<?= site_url('arsip') ?>" class="mt-6 group/btn flex items-center justify-center gap-3 w-full py-4 rounded-2xl bg-slate-50 dark:bg-slate-800/50 text-slate-400 dark:text-slate-500 font-display font-black text-[10px] uppercase tracking-[0.2em] text-center hover:bg-brand-600 hover:text-white transition-all">
                Semua Arsip
                <i class="fa-solid fa-arrow-right-long transition-transform group-hover/btn:translate-x-1"></i>
            </a>
        </div>
    </div>
</div>
