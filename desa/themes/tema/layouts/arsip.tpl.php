<?php if(!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <?php $this->load->view("$folder_themes/commons/meta.php"); ?>
</head>
<body class="bg-white dark:bg-slate-950 font-sans text-slate-900 dark:text-slate-100 selection:bg-brand-100 dark:selection:bg-brand-900 selection:text-brand-900 dark:selection:text-brand-100 transition-colors duration-300 overflow-x-hidden">
    
    <!-- Navbar (Fixed) -->
    <?php $this->load->view("$folder_themes/commons/header.php"); ?>

    <div class="h-24 md:h-32"></div>

    <main class="min-h-screen">
        <section class="py-12 md:py-20 bg-slate-50/50 dark:bg-slate-900/40">
            <div class="container mx-auto px-4">
                <div class="max-w-6xl mx-auto">
                    
                    <!-- [NAVIGATION BREADCRUMB] -->
                    <nav class="flex items-center gap-3 text-xs font-bold text-slate-400 uppercase tracking-widest mb-10">
                        <a href="<?= site_url() ?>" class="hover:text-brand-600 transition-colors">Beranda</a>
                        <i class="fa-solid fa-chevron-right text-[10px] opacity-40"></i>
                        <span class="text-slate-600 dark:text-slate-300 uppercase tracking-widest">Arsip Publik</span>
                    </nav>

                    <!-- [HEADER] -->
                    <header class="mb-16">
                        <div class="flex items-center gap-2 mb-4 text-brand-600 font-bold tracking-[0.2em] uppercase text-[10px]">
                            <span class="w-8 h-px bg-brand-600"></span>
                            News Archive
                        </div>
                        <h1 class="font-display font-[800] text-4xl md:text-6xl text-slate-900 dark:text-white leading-[1.1] tracking-tight mb-6">
                            Penelusuran <span class="text-transparent bg-clip-text bg-gradient-to-r from-brand-600 to-accent">Arsip Berita</span>.
                        </h1>
                    </header>

                    <!-- [ARSIP TABLE] -->
                    <div class="bg-white dark:bg-slate-800 rounded-[3.5rem] border border-slate-100 dark:border-slate-700 shadow-2xl shadow-slate-200/40 dark:shadow-slate-950/50 overflow-hidden relative group">
                        <div class="absolute -right-24 -top-24 w-80 h-80 bg-brand-50/50 dark:bg-brand-900/10 rounded-full blur-3xl opacity-40 group-hover:scale-110 transition-transform duration-1000"></div>
                        
                        <div class="relative z-10 p-4 md:p-10">
                            <div class="table-responsive w-full overflow-x-auto">
                                <table class="w-full border-separate border-spacing-0">
                                    <thead>
                                        <tr class="bg-slate-50 dark:bg-slate-900/50">
                                            <th class="px-8 py-6 text-left text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-[0.2em] border-b border-slate-100 dark:border-slate-700 first:rounded-tl-[2rem]">No</th>
                                            <th class="px-8 py-6 text-left text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-[0.2em] border-b border-slate-100 dark:border-slate-700">Tanggal</th>
                                            <th class="px-8 py-6 text-left text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-[0.2em] border-b border-slate-100 dark:border-slate-700">Judul Artikel</th>
                                            <th class="px-8 py-6 text-left text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-[0.2em] border-b border-slate-100 dark:border-slate-700">Kategori</th>
                                            <th class="px-8 py-6 text-center text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-[0.2em] border-b border-slate-100 dark:border-slate-700 last:rounded-tr-[2rem]">Hits</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-slate-50 dark:divide-slate-700/50">
                                        <?php if(count($farsip)>0): ?>
                                            <?php foreach($farsip AS $data): $url = site_url('artikel/'.buat_slug($data)); ?>
                                                <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-700/30 transition-colors">
                                                    <td class="px-8 py-6 text-sm font-bold text-slate-400 dark:text-slate-500"><?= $data['no'] ?></td>
                                                    <td class="px-8 py-6 text-sm font-bold text-slate-600 dark:text-slate-400 whitespace-nowrap"><?= tgl_indo($data['tgl_upload']) ?></td>
                                                    <td class="px-8 py-6">
                                                        <a href="<?= $url ?>" class="text-sm font-bold text-slate-900 dark:text-slate-100 hover:text-brand-600 dark:hover:text-brand-400 transition-colors line-clamp-1">
                                                            <?= $data['judul'] ?>
                                                        </a>
                                                    </td>
                                                    <td class="px-8 py-6">
                                                        <span class="inline-block px-4 py-1.5 rounded-xl bg-brand-50 dark:bg-brand-900/30 text-[10px] font-black text-brand-600 dark:text-brand-400 uppercase tracking-widest border border-brand-100 dark:border-brand-900/50">
                                                            <?= $data['kategori'] ?>
                                                        </span>
                                                    </td>
                                                    <td class="px-8 py-6 text-center">
                                                        <div class="inline-flex items-center gap-2 text-xs font-bold text-slate-400 dark:text-slate-500">
                                                            <i class="fa-solid fa-eye text-[10px]"></i>
                                                            <?= number_format($data['hit'], 0, ',', '.') ?>
                                                        </div>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <tr>
                                                <td colspan="5" class="px-8 py-20 text-center">
                                                    <div class="flex flex-col items-center">
                                                        <div class="w-20 h-20 rounded-[1.5rem] bg-slate-50 dark:bg-slate-900/50 flex items-center justify-center text-slate-200 dark:text-slate-700 text-4xl mb-6">
                                                            <i class="fa-solid fa-folder-open"></i>
                                                        </div>
                                                        <p class="font-display font-black text-xl text-slate-400 dark:text-slate-600">Arsip Masih Kosong</p>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- [PAGINATION] -->
                    <?php if (count($farsip)>0): ?>
                        <div class="mt-20 flex justify-center">
                            <nav class="inline-flex p-2 bg-white dark:bg-slate-800 rounded-3xl shadow-xl shadow-slate-200 dark:shadow-slate-950 border border-slate-100 dark:border-slate-700 gap-1">
                                <?php if($paging->start_link): ?>
                                    <a href="<?= site_url("arsip/$paging->start_link") ?>" class="w-12 h-12 flex items-center justify-center rounded-2xl text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-700 hover:text-brand-600 transition-all" aria-label="Halaman Pertama">
                                        <i class="fa-solid fa-angles-left" aria-hidden="true"></i>
                                    </a>
                                <?php endif; ?>
                                
                                <?php 
                                $paging_range = 2;
                                $start_paging = max($paging->start_link, $p - $paging_range);
                                $end_paging = min($paging->end_link, $p + $paging_range);
                                
                                for($i=$start_paging; $i<=$end_paging; $i++): $isActive = ($p == $i); ?>
                                    <a href="<?= site_url("arsip/$i" . $paging->suffix) ?>" class="w-12 h-12 flex items-center justify-center rounded-2xl text-sm font-black transition-all <?= $isActive ? 'bg-brand-600 text-white shadow-lg shadow-brand-600/30' : 'text-slate-500 hover:bg-brand-50 dark:hover:bg-brand-700 hover:text-brand-600 dark:text-slate-400' ?>" aria-label="Halaman <?= $i ?>">
                                        <?= $i ?>
                                    </a>
                                <?php endfor; ?>
                                
                                <?php if($paging->end_link): ?>
                                    <a href="<?= site_url("arsip/$paging->end_link") ?>" class="w-12 h-12 flex items-center justify-center rounded-2xl text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-700 hover:text-brand-600 transition-all" aria-label="Halaman Terakhir">
                                        <i class="fa-solid fa-angles-right" aria-hidden="true"></i>
                                    </a>
                                <?php endif; ?>
                            </nav>
                        </div>
                    <?php endif; ?>

                </div>
            </div>
        </section>
    </main>

    <!-- Footer -->
    <?php $this->load->view("$folder_themes/commons/copyleft.php"); ?>

    <script src="<?= base_url($folder_themes . '/assets/js/app.js') ?>"></script>

    <!-- AOS (Animate On Scroll) Logic -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

</body>
</html>
