<?php if(!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<div class="mb-10 group/widget">
    <div class="premium-card overflow-hidden">
        <!-- Header -->
        <div class="p-8 border-b border-slate-50 dark:border-slate-800 flex items-center justify-between bg-slate-50/30 dark:bg-slate-800/20">
            <h3 class="premium-h1 text-xs uppercase tracking-[0.2em] flex items-center gap-3">
                <div class="w-1.5 h-8 bg-brand-600 rounded-full"></div>
                <?= html_escape($judul_widget) ?>
            </h3>
        </div>

        <!-- Body / Single Card Carousel -->
        <div class="p-6">
            <?php if ($aparatur_desa['daftar_perangkat']): ?>
                <div class="relative">
                    <div id="aparatur-slider" class="flex overflow-x-auto snap-x snap-mandatory no-scrollbar scroll-smooth">
                        <?php foreach($aparatur_desa['daftar_perangkat'] as $index => $data): ?>
                            <div class="snap-center shrink-0 w-full p-2" id="slide-<?= $index ?>">
                                <?php $is_lcp = ($index === 0); ?>
                                <!-- Card Identity (Full Frame) -->
                                <div class="relative rounded-[3rem] overflow-hidden border border-slate-100 dark:border-slate-700 shadow-sm transition-all duration-500 hover:shadow-xl hover:shadow-brand-600/10 aspect-[3/4] group/card bg-slate-100 dark:bg-slate-800">
                                    
                                    <!-- Photo Section -->
                                    <img src="<?= $data['foto'] ?>" 
                                         alt="<?= html_escape($data['nama']) ?>" 
                                         class="w-full h-full object-cover transition-transform duration-[1.5s] group-hover/card:scale-110" 
                                         <?= $is_lcp ? 'loading="eager" fetchpriority="high"' : 'loading="lazy"' ?>
                                         onerror="this.src='<?= base_url("assets/images/pengguna/k_penduduk.png") ?>'"/>
                                    
                                    <!-- Presence Badge -->
                                    <div class="absolute top-6 left-6 z-20">
                                        <?php if ($tampilkan_status_kehadiran): ?>
                                            <?php if ($data['kehadiran'] == 1): ?>
                                                <?php if ($data['status_kehadiran'] == 'hadir'): ?>
                                                    <span class="px-4 py-2 bg-emerald-500/90 backdrop-blur-md rounded-2xl text-[8px] font-black text-white uppercase tracking-widest shadow-lg flex items-center gap-2">
                                                        <span class="w-2 h-2 rounded-full bg-white animate-pulse"></span>
                                                        AKTIF
                                                    </span>
                                                <?php else: ?>
                                                    <span class="px-4 py-2 bg-rose-500/90 backdrop-blur-md rounded-2xl text-[8px] font-black text-white uppercase tracking-widest shadow-lg">
                                                        <?= strtoupper($data['status_kehadiran']) ?>
                                                    </span>
                                                <?php endif; ?>
                                            <?php endif; ?>
                                        <?php else: ?>
                                            <span class="px-4 py-2 bg-slate-900/40 backdrop-blur-sm rounded-2xl text-[8px] font-black text-white uppercase tracking-widest">
                                                LIBUR
                                            </span>
                                        <?php endif; ?>
                                    </div>

                                    <!-- Floating Info Overlay (Bottom) -->
                                    <div class="absolute inset-x-0 bottom-0 pt-24 pb-8 px-6 bg-gradient-to-t from-slate-950 via-slate-950/60 to-transparent flex flex-col items-center justify-end text-center z-10">
                                        
                                        <!-- Role/Jabatan Badge -->
                                        <div class="mb-3 px-4 py-1.5 rounded-full bg-brand-500/20 backdrop-blur-md border border-brand-500/30 shadow-inner">
                                            <p class="text-[9px] font-bold text-brand-300 uppercase tracking-[0.2em] leading-none">
                                                <?= html_escape($data['jabatan']) ?>
                                            </p>
                                        </div>

                                        <!-- Name -->
                                        <h4 class="font-display font-black text-white text-base md:text-lg leading-snug drop-shadow-md truncate w-full">
                                            <?= html_escape($data['nama']) ?>
                                        </h4>

                                        <!-- NIAP -->
                                        <?php if ($data['pamong_niap']): ?>
                                            <p class="mt-2 text-[8px] font-bold text-slate-400 uppercase tracking-widest drop-shadow">
                                                NIAP. <?= $data['pamong_niap'] ?>
                                            </p>
                                        <?php endif; ?>
                                        
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <!-- Manual Navigation Overlay -->
                    <div class="absolute inset-y-0 -left-2 -right-2 flex items-center justify-between pointer-events-none px-4">
                        <button onclick="scrollAparatur('prev')" class="w-10 h-10 rounded-full bg-white/80 dark:bg-slate-800/80 backdrop-blur-md shadow-lg border border-slate-100 dark:border-slate-700 flex items-center justify-center text-slate-400 hover:text-brand-600 hover:scale-110 pointer-events-auto transition-all transition-transform active:scale-95" aria-label="Aparatur Sebelumnya">
                            <i class="fa-solid fa-chevron-left"></i>
                        </button>
                        <button onclick="scrollAparatur('next')" class="w-10 h-10 rounded-full bg-white/80 dark:bg-slate-800/80 backdrop-blur-md shadow-lg border border-slate-100 dark:border-slate-700 flex items-center justify-center text-slate-400 hover:text-brand-600 hover:scale-110 pointer-events-auto transition-all transition-transform active:scale-95" aria-label="Aparatur Selanjutnya">
                            <i class="fa-solid fa-chevron-right"></i>
                        </button>
                    </div>
                </div>

                <!-- Pagination Dots -->
                <div class="flex justify-center gap-2 mt-6">
                    <?php foreach($aparatur_desa['daftar_perangkat'] as $index => $data): ?>
                        <div id="dot-<?= $index ?>" class="aparatur-dot w-2 h-2 rounded-full bg-slate-200 dark:bg-slate-800 transition-all duration-300"></div>
                    <?php endforeach; ?>
                </div>

                <script>
                    const slider = document.getElementById('aparatur-slider');
                    const dots = document.querySelectorAll('.aparatur-dot');
                    let autoSlide;

                    function updateDots() {
                        const index = Math.round(slider.scrollLeft / slider.clientWidth);
                        dots.forEach((dot, i) => {
                            if (i === index) {
                                dot.classList.add('bg-brand-600', 'w-6');
                                dot.classList.remove('bg-slate-200', 'dark:bg-slate-800');
                            } else {
                                dot.classList.remove('bg-brand-600', 'w-6');
                                dot.classList.add('bg-slate-200', 'dark:bg-slate-800');
                            }
                        });
                    }

                    function scrollAparatur(dir) {
                        const step = slider.clientWidth;
                        if (dir === 'next') {
                            if (slider.scrollLeft >= (slider.scrollWidth - slider.clientWidth - 10)) {
                                slider.scrollTo({ left: 0, behavior: 'smooth' });
                            } else {
                                slider.scrollBy({ left: step, behavior: 'smooth' });
                            }
                        } else {
                            if (slider.scrollLeft <= 10) {
                                slider.scrollTo({ left: slider.scrollWidth, behavior: 'smooth' });
                            } else {
                                slider.scrollBy({ left: -step, behavior: 'smooth' });
                            }
                        }
                    }

                    slider.addEventListener('scroll', updateDots);
                    
                    function startAuto() {
                        autoSlide = setInterval(() => scrollAparatur('next'), 5000);
                    }
                    
                    function stopAuto() {
                        clearInterval(autoSlide);
                    }

                    slider.addEventListener('mouseenter', stopAuto);
                    slider.addEventListener('mouseleave', startAuto);
                    
                    startAuto();
                    updateDots();
                </script>

            <?php else: ?>
                <div class="py-16 text-center">
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">Informasi Aparatur Tidak Tersedia</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<style>
    .no-scrollbar::-webkit-scrollbar { display: none; }
    .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
</style>
