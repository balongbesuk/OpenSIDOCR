<!DOCTYPE html>
<html lang="id">
<head>
    <?php $this->load->view("$folder_themes/commons/meta.php"); ?>
    <title>404 - Halaman Tidak Ditemukan</title>
</head>

<body class="bg-white dark:bg-slate-950 font-sans text-slate-800 dark:text-slate-400 overflow-hidden transition-colors duration-500">
    <div class="relative min-h-screen flex items-center justify-center p-6 hero-gradient">
        
        <!-- Animated Background Decor -->
        <div class="absolute top-1/4 left-1/4 w-[500px] h-[500px] bg-brand-600/10 rounded-full blur-[120px] animate-pulse"></div>
        <div class="absolute bottom-1/4 right-1/4 w-[400px] h-[400px] bg-emerald-500/10 rounded-full blur-[120px] animate-pulse" style="animation-delay: 2s"></div>

        <div class="relative z-10 max-w-2xl w-full text-center space-y-12">
            
            <!-- Icon Error -->
            <div class="flex justify-center">
                <div class="w-32 h-32 md:w-40 md:h-40 bg-white dark:bg-slate-900 rounded-[3.5rem] shadow-2xl flex items-center justify-center border border-slate-100 dark:border-slate-800 relative group transition-all duration-700 hover:rotate-12 hover:scale-110">
                    <i class="fa-solid fa-map-location-dot text-6xl text-brand-600 group-hover:scale-110 transition-transform"></i>
                    <!-- Notif Badge -->
                    <div class="absolute -top-2 -right-2 w-12 h-12 bg-red-500 rounded-2xl flex items-center justify-center text-white font-black text-xl shadow-lg border-4 border-white dark:border-slate-900 group-hover:animate-bounce">
                        !
                    </div>
                </div>
            </div>

            <!-- Big 404 -->
            <div class="space-y-4">
                <h1 class="font-display font-black text-9xl md:text-[14rem] leading-none tracking-tighter text-transparent bg-clip-text bg-gradient-to-b from-slate-900 to-slate-200 dark:from-white dark:to-slate-900 opacity-20">
                    404
                </h1>
                <div class="relative -mt-16 md:-mt-28">
                    <h2 class="premium-h1 text-4xl md:text-7xl">
                        Waduh, <span class="text-brand-600 italic">Tersesat?</span>
                    </h2>
                    <p class="premium-p text-lg md:text-xl max-w-md mx-auto mt-8">
                        Mohon maaf, halaman yang Anda cari tidak ditemukan atau telah dipindahkan ke alamat baru.
                    </p>
                </div>
            </div>

            <!-- Actions -->
            <div class="flex flex-col sm:flex-row items-center justify-center gap-6 pt-10">
                <a href="<?= site_url() ?>" class="w-full sm:w-auto px-12 py-5 bg-slate-900 dark:bg-brand-600 text-white font-display font-black uppercase tracking-[0.2em] text-[10px] rounded-2xl shadow-2xl shadow-slate-900/20 dark:shadow-brand-900/40 hover:scale-110 hover:-translate-y-1 active:scale-95 transition-all flex items-center justify-center gap-3 group">
                    <i class="fa-solid fa-house-chimney group-hover:-translate-y-1 transition-transform"></i>
                    Kembali Ke Beranda
                </a>
                <a href="javascript:history.back()" class="w-full sm:w-auto px-12 py-5 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-600 dark:text-slate-300 font-display font-black uppercase tracking-[0.2em] text-[10px] rounded-2xl hover:bg-slate-50 dark:hover:bg-slate-700 active:scale-95 transition-all text-center">
                    Halaman Sebelumnya
                </a>
            </div>

            <!-- Brand Badge -->
            <div class="pt-24 flex flex-col items-center gap-4">
                <div class="flex items-center gap-4 opacity-30 dark:opacity-50">
                    <span class="text-[9px] font-black uppercase tracking-[0.4em]">Digital Excellence. Village Portal</span>
                </div>
                <div class="w-12 h-1 bg-slate-200 dark:bg-slate-800 rounded-full"></div>
            </div>
        </div>
    </div>
</body>
</html>

