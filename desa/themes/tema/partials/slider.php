<?php  if(!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<style>
    @keyframes kenburns {
        0% { transform: scale(1); }
        100% { transform: scale(1.15); }
    }
    .bg-slide img {
        transition: transform 1.5s cubic-bezier(0.4, 0, 0.2, 1);
    }
    .bg-slide.active-slide img {
        animation: kenburns 12s ease-out forwards;
    }
    
    /* Ensure marquee is perfectly seamless */
    .ticker-content {
        display: flex;
        width: max-content;
        animation: ticker-scroll 40s linear infinite !important;
    }
    @keyframes ticker-scroll {
        0% { transform: translateX(0); }
        100% { transform: translateX(-50%); }
    }
</style>

<section class="relative pt-32 pb-16 md:pt-48 md:pb-24 overflow-hidden hero-gradient">
    <!-- Dynamic Background Slider (From Articles) -->
    <div class="absolute inset-0 z-0 overflow-hidden">
        <?php if (count($slider_gambar['gambar']) > 0): ?>
            <?php 
                $gambar_slider = array_slice($slider_gambar['gambar'], 0, 6);
                foreach($gambar_slider as $idx => $item): 
                $img = base_url($slider_gambar['lokasi'] . 'sedang_' . $item['gambar']);
            ?>
                <div class="bg-slide absolute inset-0 transition-opacity duration-1000 <?= $idx === 0 ? 'opacity-100 active-slide' : 'opacity-0' ?>">
                    <img src="<?= $img ?>" 
                         class="w-full h-full object-cover" 
                         alt="Visual Utama Desa" 
                         <?= $idx === 0 ? 'fetchpriority="high" loading="eager"' : 'loading="lazy"' ?>>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="absolute inset-0 bg-slate-100 dark:bg-slate-900"></div>
        <?php endif; ?>
        
        <!-- Overlay for contrast: Reduced opacity & blur for better image visibility -->
        <div class="absolute inset-0 bg-white/40 dark:bg-slate-950/60 backdrop-blur-[1px]"></div>
        <div class="absolute inset-0 bg-gradient-to-b from-white/10 via-transparent to-white/90 dark:from-slate-950/10 dark:to-slate-950/90"></div>
    </div>


    <div class="container mx-auto px-4 relative z-10 flex flex-col items-center">
        <!-- Premium Announcement Ticker Redesign -->
        <?php if (count($teks_berjalan)>0): ?>
            <div class="w-full max-w-3xl bg-white/30 dark:bg-slate-900/30 backdrop-blur-2xl border border-white/50 dark:border-slate-800/50 p-1.5 rounded-full shadow-2xl shadow-slate-200/20 dark:shadow-none mb-12 group overflow-hidden flex items-center animate-premium">
                <!-- Label Pill -->
                <div class="flex-none px-4 py-3 bg-slate-900 dark:bg-brand-600 text-white rounded-full flex items-center justify-center relative overflow-hidden shadow-lg shadow-slate-900/10 active:scale-95 transition-all">
                    <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/10 to-transparent -translate-x-full group-hover:translate-x-full transition-transform duration-1000"></div>
                    <div class="relative flex items-center justify-center">
                        <span class="absolute h-3 w-3 rounded-full bg-amber-400 opacity-20 animate-ping"></span>
                        <i class="fa-solid fa-triangle-exclamation text-amber-400 text-xs relative"></i>
                    </div>
                </div>
                
                <!-- Scroller Area -->
                <div class="flex-1 overflow-hidden relative h-full flex items-center px-6 ticker-container">
                    <div class="ticker-content w-max">
                        <?php for($i=0; $i<2; $i++): // Perfect 1:1 Duplication ?>
                            <?php foreach ($teks_berjalan as $teks): ?>
                                <span class="mr-24 flex items-center gap-4 text-[13px] font-bold text-slate-700 dark:text-slate-300 whitespace-nowrap">
                                    <span class="w-1.5 h-1.5 rounded-full bg-brand-600 dark:bg-brand-400 shadow-[0_0_10px_rgba(37,99,235,0.5)]"></span>
                                    <?= html_escape($teks['teks']) ?>
                                </span>
                            <?php endforeach; ?>
                        <?php endfor; ?>
                    </div>
                </div>

                <!-- Subtle Decorative Gradient -->
                <div class="absolute inset-y-0 right-0 w-24 bg-gradient-to-l from-white/40 dark:from-slate-950/40 to-transparent pointer-events-none"></div>
            </div>
        <?php endif; ?>

        <!-- Headline Content -->
        <div class="text-center max-w-4xl space-y-6">
            <h1 class="font-display font-[800] text-4xl md:text-7xl text-slate-900 leading-[1.1] tracking-tight">
                Portal Informasi & <span class="text-transparent bg-clip-text bg-gradient-to-r from-brand-600 to-accent">Layanan Publik</span> Digital.
            </h1>
            <p class="text-lg md:text-xl text-slate-500 font-medium max-w-2xl mx-auto leading-relaxed">
                Selamat datang di Website Resmi Pemerintah <?= html_escape($this->setting->sebutan_desa) ?> <?= html_escape($desa['nama_desa']) ?>. Platform transparansi dan layanan mandiri berbasis digital.
            </p>
        </div>

        <!-- Dynamic Search Box -->
        <div class="w-full max-w-2xl mt-12 group">
            <form method="get" action="<?= site_url('first') ?>" class="relative flex items-center bg-white/80 dark:bg-slate-900/40 p-1.5 rounded-[2rem] shadow-[0_20px_50px_-15px_rgba(0,0,0,0.1)] border-none outline-none transition-all duration-500 backdrop-blur-xl">
                <div class="absolute left-6 text-brand-500/50 group-focus-within:text-brand-600 transition-colors">
                    <i class="fa-solid fa-magnifying-glass text-xl"></i>
                </div>
                <input type="text" name="cari" value="<?= isset($_GET['cari']) ? html_escape($_GET['cari']) : ''; ?>" placeholder="Cari Artikel dan Berita Desa?" class="w-full pl-16 pr-10 py-5 bg-transparent border-none focus:ring-0 text-slate-800 dark:text-white font-semibold placeholder:text-slate-400 placeholder:font-medium transition-colors outline-none">
                <button type="submit" class="hidden md:block absolute right-2.5 px-8 py-4 bg-slate-900 dark:bg-brand-600 text-white font-display font-black uppercase tracking-widest text-[10px] rounded-[1.5rem] hover:bg-brand-600 dark:hover:bg-brand-500 shadow-lg shadow-slate-900/20 active:scale-95 transition-all outline-none">
                    Temukan
                </button>
            </form>
        </div>


    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const slides = document.querySelectorAll('.bg-slide');
            if (slides.length <= 1) return;

            let currentSlide = 0;
            
            setInterval(() => {
                slides[currentSlide].classList.remove('opacity-100', 'active-slide');
                slides[currentSlide].classList.add('opacity-0');
                
                currentSlide = (currentSlide + 1) % slides.length;
                
                slides[currentSlide].classList.remove('opacity-0');
                slides[currentSlide].classList.add('opacity-100', 'active-slide');
            }, 6000); // Ganti gambar setiap 6 detik
        });
    </script>
</section>
