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
                        <span class="text-slate-600 dark:text-slate-300 uppercase tracking-widest">Infrastruktur</span>
                    </nav>

                    <!-- [HEADER] -->
                    <header class="mb-16">
                        <div class="flex items-center gap-2 mb-4 text-brand-600 font-bold tracking-[0.2em] uppercase text-[10px]">
                            <span class="w-8 h-px bg-brand-600"></span>
                            Village Infrastructure
                        </div>
                        <h1 class="font-display font-[800] text-4xl md:text-6xl text-slate-900 dark:text-white leading-[1.1] tracking-tight mb-6">
                            Transparansi <span class="text-transparent bg-clip-text bg-gradient-to-r from-brand-600 to-accent">Pembangunan</span>.
                        </h1>
                        <p class="text-slate-500 dark:text-slate-400 font-medium max-w-2xl leading-relaxed italic">
                            Daftar kegiatan pembangunan fisik dan infrastruktur di <?= ucwords($this->setting->sebutan_desa) . ' ' . $desa['nama_desa'] ?> sebagai wujud keterbukaan informasi publik.
                        </p>
                    </header>

                    <!-- [GRID PEMBANGUNAN] -->
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10">
                        <?php if ($pembangunan): ?>
                            <?php foreach ($pembangunan as $data): ?>
                                <article class="group relative flex flex-col bg-white dark:bg-slate-800 rounded-[2.5rem] border border-slate-100 dark:border-slate-700 overflow-hidden hover:shadow-2xl hover:shadow-slate-200 dark:hover:shadow-slate-950 transition-all duration-500">
                                    <!-- Image Box -->
                                    <div class="relative h-64 overflow-hidden bg-slate-100 dark:bg-slate-900">
                                        <?php if (is_file(LOKASI_GALERI . $data->foto)): ?>
                                            <img <?= ($pembangunan[0] === $data) ? 'fetchpriority="high" loading="eager"' : 'loading="lazy"' ?> src="<?= base_url() . LOKASI_GALERI . $data->foto ?>" alt="<?= html_escape($data->judul) ?>" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110" />
                                        <?php else: ?>
                                            <div class="w-full h-full flex flex-col items-center justify-center text-slate-300 dark:text-slate-700 gap-4">
                                                <i class="fa-solid fa-hard-hat text-5xl"></i>
                                                <span class="text-[10px] font-black uppercase tracking-widest">Foto Belum Tersedia</span>
                                            </div>
                                        <?php endif; ?>
                                        
                                        <!-- Year Badge -->
                                        <div class="absolute top-6 left-6">
                                            <span class="px-5 py-2 rounded-xl bg-brand-600 text-white text-[10px] font-black uppercase tracking-[0.2em] shadow-lg shadow-brand-600/30">
                                                TA <?= $data->tahun_anggaran ?>
                                            </span>
                                        </div>
                                    </div>

                                    <!-- Content Box -->
                                    <div class="p-8 flex-1 flex flex-col">
                                        <h2 class="font-display font-bold text-xl text-slate-900 dark:text-white leading-snug mb-6 group-hover:text-brand-600 transition-colors line-clamp-2">
                                            <?= $data->judul ?>
                                        </h2>
                                        
                                        <div class="space-y-4 mb-8">
                                            <div class="flex items-start gap-3">
                                                <div class="w-8 h-8 rounded-lg bg-slate-50 dark:bg-slate-700/50 flex items-center justify-center text-slate-400 shrink-0">
                                                    <i class="fa-solid fa-location-dot text-xs"></i>
                                                </div>
                                                <p class="text-xs font-semibold text-slate-500 dark:text-slate-400 leading-relaxed line-clamp-2">
                                                    <?= ($data->alamat == "=== Lokasi Tidak Ditemukan ===") ? 'Lokasi Belum Ditentukan' : $data->alamat; ?>
                                                </p>
                                            </div>
                                            <div class="flex items-start gap-3">
                                                <div class="w-8 h-8 rounded-lg bg-slate-50 dark:bg-slate-700/50 flex items-center justify-center text-slate-400 shrink-0">
                                                    <i class="fa-solid fa-align-left text-xs"></i>
                                                </div>
                                                <p class="text-xs font-semibold text-slate-500 dark:text-slate-400 leading-relaxed line-clamp-2">
                                                    <?= potong_teks($data->keterangan, 100) ?>
                                                </p>
                                            </div>
                                        </div>

                                        <div class="mt-auto pt-8 border-t border-slate-100 dark:border-slate-700/50">
                                            <a href="<?= site_url('pembangunan/'.$data->slug) ?>" class="flex items-center justify-between text-[10px] font-black text-slate-900 dark:text-white uppercase tracking-[0.2em] group/btn">
                                                Detail Pekerjaan
                                                <div class="w-10 h-10 rounded-full bg-slate-50 dark:bg-slate-700 flex items-center justify-center group-hover/btn:bg-brand-600 group-hover/btn:text-white transition-all">
                                                    <i class="fa-solid fa-arrow-right"></i>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                </article>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <!-- Empty State -->
                            <div class="col-span-full py-32 flex flex-col items-center text-center">
                                <div class="w-32 h-32 rounded-[3rem] bg-slate-100 dark:bg-slate-800 flex items-center justify-center text-slate-300 dark:text-slate-600 text-5xl mb-8">
                                    <i class="fa-solid fa-helmet-safety"></i>
                                </div>
                                <h3 class="font-display font-extrabold text-2xl text-slate-900 dark:text-white">Belum Ada Program Pembangunan</h3>
                                <p class="text-slate-400 font-medium max-w-sm mt-3">Sistem belum mencatat data pembangunan fisik untuk periode ini.</p>
                            </div>
                        <?php endif; ?>
                    </div>

                    <!-- [PAGINATION] -->
                    <?php if ($pembangunan): ?>
                        <div class="mt-20 flex justify-center">
                            <!-- Sesuai native OpenSID pagination -->
                             <?php $this->load->view("$folder_themes/commons/paging.php"); ?>
                        </div>
                    <?php endif; ?>

                </div>
            </div>
        </section>
    </main>

    <!-- Footer -->
    <?php $this->load->view("$folder_themes/commons/copyleft.php"); ?>

</body>
</html>
