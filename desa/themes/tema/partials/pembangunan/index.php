<div class="pembangunan-container pb-20">
    <!-- Header Section -->
    <div class="mb-12">
        <nav class="flex items-center gap-3 text-xs font-bold text-slate-400 uppercase tracking-widest mb-8">
            <a href="<?= site_url() ?>" class="hover:text-brand-600 transition-colors font-black">Beranda</a>
            <i class="fa-solid fa-chevron-right text-[10px] opacity-40"></i>
            <span class="text-slate-600 dark:text-slate-300 font-black">Pembangunan</span>
        </nav>

        <div class="flex flex-col md:flex-row md:items-end justify-between gap-8">
            <div>
                <div class="flex items-center gap-2 mb-4 text-brand-600 font-bold tracking-[0.2em] uppercase text-[10px]">
                    <span class="w-8 h-px bg-brand-600"></span>
                    Village Infrastructure
                </div>
                <h1 class="font-display font-[900] text-4xl md:text-5xl text-slate-900 dark:text-white leading-none tracking-tight">
                    Program <span class="text-transparent bg-clip-text bg-gradient-to-r from-brand-600 to-accent">Pembangunan</span>.
                </h1>
                <p class="mt-4 text-slate-500 dark:text-slate-400 font-medium max-w-2xl leading-relaxed">
                    Transparansi realisasi program pembangunan infrastruktur dan pemberdayaan masyarakat Desa <?= $desa['nama_desa'] ?>.
                </p>
            </div>
        </div>
    </div>

    <!-- Pembangunan Grid -->
    <?php if ($pembangunan): ?>
        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-10">
            <?php foreach ($pembangunan as $data): ?>
                <div class="group relative bg-white dark:bg-slate-900 rounded-[3rem] border border-slate-100 dark:border-slate-800 shadow-2xl shadow-slate-200/40 dark:shadow-none overflow-hidden transition-all duration-700 hover:-translate-y-4 hover:shadow-[0_50px_100px_-20px_rgba(59,130,246,0.2)] flex flex-col">
                    
                    <!-- [IMAGE AREA] -->
                    <div class="relative overflow-hidden aspect-[16/10] bg-slate-50 dark:bg-slate-950/50">
                        <!-- Year Badge -->
                        <div class="absolute top-6 left-6 z-20 px-4 py-2 rounded-2xl bg-white/90 dark:bg-slate-900/90 backdrop-blur-md text-slate-900 dark:text-white font-black text-[10px] tracking-[0.2em] uppercase shadow-xl">
                            TA <?= $data->tahun_anggaran ?>
                        </div>

                        <?php if (is_file(LOKASI_GALERI . $data->foto)): ?>
                            <img src="<?= base_url(LOKASI_GALERI . $data->foto) ?>" class="w-full h-full object-cover transition-transform duration-1000 group-hover:scale-110" alt="<?= html_escape($data->judul) ?>" onerror="this.src='<?= base_url('assets/images/404-image-not-found.jpg') ?>'">
                        <?php else: ?>
                            <div class="w-full h-full flex flex-col items-center justify-center bg-slate-100 dark:bg-slate-800/40">
                                <i class="fa-solid fa-mountain-city text-5xl text-slate-200 dark:text-slate-700 animate-pulse"></i>
                            </div>
                        <?php endif; ?>

                        <!-- Gradient Bottom Fade -->
                        <div class="absolute inset-x-0 bottom-0 h-24 bg-gradient-to-t from-white dark:from-slate-900 to-transparent"></div>
                    </div>

                    <!-- [CARD CONTENT] -->
                    <div class="p-10 flex-1 flex flex-col pt-0 -mt-6 relative z-10">
                        <!-- Status Badge (Mock as it usually depends on details) -->
                        <div class="inline-flex mb-4">
                            <span class="px-4 py-1.5 rounded-xl bg-brand-600 text-white font-black text-[9px] uppercase tracking-[0.2em] shadow-lg shadow-brand-600/30">
                                <i class="fa-solid fa-check-double mr-1.5"></i> Terlaksana
                            </span>
                        </div>

                        <h3 class="font-display font-[900] text-2xl text-slate-900 dark:text-white leading-tight tracking-tight group-hover:text-brand-600 transition-colors mb-6 line-clamp-2 min-h-[3.5rem]">
                            <?= $data->judul ?>
                        </h3>

                        <!-- Info Grid -->
                        <div class="grid grid-cols-1 gap-4 mb-8">
                            <div class="flex items-center gap-4 p-4 rounded-2xl bg-slate-50 dark:bg-slate-800/40 border border-slate-100 dark:border-slate-800/60 transition-colors group-hover:bg-brand-50/50 dark:group-hover:bg-brand-900/10">
                                <div class="w-10 h-10 rounded-xl bg-white dark:bg-slate-800 shadow-sm flex items-center justify-center text-brand-600 dark:text-brand-400">
                                    <i class="fa-solid fa-location-dot"></i>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-0.5">Lokasi Pengerjaan</p>
                                    <p class="text-[11px] font-bold text-slate-900 dark:text-white truncate">
                                        <?= ($data->alamat == "=== Lokasi Tidak Ditemukan ===") ? 'Lokasi tidak diketahui' : $data->alamat; ?>
                                    </p>
                                </div>
                            </div>
                            
                            <!-- Small Progress Mockup -->
                            <div class="px-2">
                                <div class="flex items-center justify-between mb-2">
                                    <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Progress Fisik</span>
                                    <span class="text-[10px] font-black text-brand-600">100%</span>
                                </div>
                                <div class="h-1.5 w-full bg-slate-100 dark:bg-slate-800 rounded-full overflow-hidden">
                                    <div class="h-full bg-brand-600 rounded-full w-full shadow-[0_0_10px_rgba(59,130,246,0.5)]"></div>
                                </div>
                            </div>
                        </div>

                        <!-- Action Button -->
                        <div class="mt-auto">
                            <a href="<?= site_url('pembangunan/'.$data->slug) ?>" 
                               class="flex items-center justify-center gap-3 w-full py-5 bg-slate-900 dark:bg-white text-white dark:text-slate-900 rounded-3xl font-black text-[11px] uppercase tracking-[0.3em] shadow-2xl shadow-slate-900/10 hover:bg-brand-600 hover:dark:bg-brand-600 hover:text-white hover:scale-[1.03] transition-all active:scale-95 group/btn">
                                <span>Detail Pembangunan</span>
                                <i class="fa-solid fa-arrow-right group-hover/btn:translate-x-2 transition-transform"></i>
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- Nomor Halaman -->
        <div class="mt-20">
            <?php if (isset($paging)): ?>
                <?php $this->load->view("{$folder_themes}/commons/paging.php", ['paging' => $paging, 'paging_page' => 'pembangunan']) ?>
            <?php endif; ?>
        </div>

    <?php else: ?>
        <div class="py-32 text-center bg-white dark:bg-slate-900 rounded-[4rem] border border-slate-100 dark:border-slate-800 shadow-2xl shadow-brand-900/5 mt-10">
            <div class="w-32 h-32 rounded-full bg-slate-50 dark:bg-slate-800 flex items-center justify-center mx-auto mb-8 text-slate-200 dark:text-slate-700">
                <i class="fa-solid fa-helmet-safety text-6xl"></i>
            </div>
            <h3 class="font-display font-[800] text-2xl text-slate-900 dark:text-white mb-2 tracking-tight">Belum ada data pembangunan.</h3>
            <p class="text-slate-500 font-medium">Data pembangunan infrastruktur desa akan segera diperbaharui.</p>
        </div>
    <?php endif; ?>
</div>

<div class='clearfix mb-8'></div>
