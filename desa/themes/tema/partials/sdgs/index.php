<?php if(!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<div class="sdgs-container">
    <!-- Header Section -->
    <div class="mb-16 text-center">
        <div class="flex items-center justify-center gap-2 mb-4 text-brand-600 font-bold tracking-[0.2em] uppercase text-[10px]">
            <span class="w-8 h-px bg-brand-600"></span>
            Sustainable Development Goals
            <span class="w-8 h-px bg-brand-600"></span>
        </div>
        <h2 class="premium-h1 text-3xl md:text-5xl mb-4">
            Capaian SDGs <?= ucwords($this->setting->sebutan_desa) ?>.
        </h2>
        <p class="premium-p max-w-2xl mx-auto italic">
            Monitoring tujuan pembangunan berkelanjutan berskala desa untuk menjamin kualitas hidup yang lebih baik bagi seluruh masyarakat.
        </p>
    </div>

    <!-- Error State -->
    <div id="errorMsg" style="display: none;" class="mb-12">
        <div class="p-8 rounded-[2rem] bg-red-50 dark:bg-red-900/20 border border-red-100 dark:border-red-900/30 text-center">
            <i class="fa-solid fa-triangle-exclamation text-red-500 text-3xl mb-4"></i>
            <p class="text-red-700 dark:text-red-400 font-bold" id="errorText"></p>
        </div>
    </div>

    <!-- Average Score / Global Meter -->
    <div id="sdgs_desa" style="display: none;" class="mb-20">
        <div class="max-w-md mx-auto p-12 rounded-[4rem] bg-white dark:bg-slate-900 border border-brand-100 dark:border-brand-900/30 shadow-2xl shadow-brand-900/5 text-center relative overflow-hidden group">
            <div class="absolute top-0 right-0 w-32 h-32 bg-brand-500/5 rounded-full blur-3xl -mr-16 -mt-16 group-hover:scale-150 transition-transform duration-700"></div>
            
            <span class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.3em] mb-4">Skor Rata-Rata</span>
            <h1 class="font-display font-[900] text-7xl md:text-8xl text-transparent bg-clip-text bg-gradient-to-r from-brand-600 to-accent leading-none mb-2" id="average">0.00</h1>
            <p class="text-slate-900 dark:text-white font-black uppercase tracking-widest text-xs">Skor Total SDGs Desa</p>
        </div>
    </div>

    <!-- Data Grid -->
    <div id="sdgsData" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8 md:gap-10">
        <!-- Skeleton Loading (Initial) -->
        <?php for($i=0; $i<8; $i++): ?>
            <div class="sdgs-skeleton animate-pulse">
                <div class="aspect-square rounded-[2.5rem] bg-slate-100 dark:bg-slate-800 mb-4"></div>
                <div class="h-4 w-2/3 bg-slate-100 dark:bg-slate-800 rounded-full mx-auto"></div>
            </div>
        <?php endfor; ?>
    </div>
</div>

<script type="text/javascript">
    $(function() {
        // Fetch data from OpenSID API
        $.get("<?= site_url('api_informasi_publik/sdgs') ?>", function(res) {
            // Remove skeleton
            $('#sdgsData').empty();

            if (res['error_msg'] || !res['data']) {
                $('#errorMsg').show();
                $('#sdgs_desa').hide();
                $('#errorText').html(res['error_msg'] || 'Gagal memuat data SDGs. Pastikan konfigurasi API sudah benar.');
                return;
            }

            $('#sdgs_desa').show();
            
            // Checking structure based on user example
            var attributes = res['data'][0]['attributes'] || res['data'][0];
            var dataList = attributes.data;
            var average = attributes.average;
            var path = "<?= base_url('assets/images/sdgs/') ?>";

            $('#average').text(average);

            dataList.forEach((item, index) => {
                var image = path + item.image;
                var score = parseFloat(item.score).toFixed(2);
                
                $('#sdgsData').append(`
                    <div class="group relative flex flex-col bg-white dark:bg-slate-900 rounded-[3rem] border border-slate-100 dark:border-slate-800 p-6 hover:shadow-2xl hover:shadow-brand-600/10 hover:-translate-y-2 transition-all duration-500 overflow-hidden">
                        <!-- BG Glow -->
                        <div class="absolute inset-0 bg-gradient-to-br from-brand-500/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
                        
                        <!-- Image Area -->
                        <div class="relative mb-8 rounded-[2rem] overflow-hidden shadow-lg border-4 border-white dark:border-slate-800">
                            <img class="w-full aspect-square object-cover transition-transform duration-1000 group-hover:scale-110" src="${image}" alt="${item.image}" />
                            <div class="absolute inset-0 bg-brand-900/10 mix-blend-overlay"></div>
                        </div>

                        <!-- Info Area -->
                        <div class="space-y-4 text-center relative z-10 p-2">
                             <div class="flex flex-col items-center">
                                <span class="text-[9px] font-black text-slate-400 uppercase tracking-[0.3em] mb-2 leading-none">Indeks Capaian</span>
                                <div class="text-3xl font-display font-black text-slate-900 dark:text-white group-hover:text-brand-600 transition-colors leading-none">
                                    ${score}
                                </div>
                             </div>

                             <div class="w-12 h-1 bg-slate-100 dark:bg-slate-800 rounded-full mx-auto group-hover:w-20 group-hover:bg-brand-500 transition-all duration-500"></div>
                             
                             <p class="text-[10px] font-bold text-slate-500 dark:text-slate-400 uppercase tracking-widest leading-relaxed">
                                Skor Tujuan Ke-${index + 1}
                             </p>
                        </div>
                    </div>
                `);
            });
        }).fail(function() {
            $('#sdgsData').empty();
            $('#errorMsg').show();
            $('#errorText').html('Gagal terhubung ke server untuk mengambil data SDGs.');
        });
    });
</script>

<style>
    .sdgs-container {
        font-family: 'Inter', sans-serif;
    }
    .font-display {
        font-family: 'Outfit', sans-serif;
    }
</style>
