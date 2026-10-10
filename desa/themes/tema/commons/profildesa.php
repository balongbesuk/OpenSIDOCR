<?php  if(!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<?php 
// Engine Data Profil - Optimized with CI Caching
$this->load->driver('cache', array('adapter' => 'file'));
if ( ! $data_penduduk = $this->cache->get('populasi_summary')) {
    $data_penduduk = $this->db
        ->select("COUNT(*) as total")
        ->select("SUM(CASE WHEN sex = 1 THEN 1 ELSE 0 END) as laki")
        ->select("SUM(CASE WHEN sex = 2 THEN 1 ELSE 0 END) as perempuan")
        ->where('status_dasar', 1)
        ->get('tweb_penduduk')
        ->row();
    
    // Simpan di cache selama 1 jam (3600 detik)
    $this->cache->save('populasi_summary', $data_penduduk, 3600);
}

$penduduk = $data_penduduk->total ?? 0;
$laki     = $data_penduduk->laki ?? 0;
$perm     = $data_penduduk->perempuan ?? 0;

// Proteksi pembagian nol untuk persentase
$persen_laki = ($penduduk > 0) ? round(($laki / $penduduk) * 100, 1) : 0;
$persen_perm = ($penduduk > 0) ? round(($perm / $penduduk) * 100, 1) : 0;
?>

<section class="hidden md:block py-16 md:py-24 bg-white dark:bg-slate-950 relative transition-colors duration-500 overflow-hidden">
    <!-- Floating Background Decor -->
    <div class="absolute -right-20 top-40 w-64 h-64 bg-brand-50 rounded-full blur-3xl opacity-60"></div>

    <div class="container mx-auto px-4 relative z-10">
        
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-12 md:mb-16">
            <div class="max-w-2xl">
                <div class="flex items-center gap-2 mb-4 text-brand-800 dark:text-brand-300 font-bold tracking-widest uppercase text-xs">
                    <span class="w-8 h-px bg-brand-800 dark:bg-brand-300"></span>
                    Statistik & Transparansi
                </div>
                <h2 class="font-display font-extrabold text-3xl md:text-5xl text-slate-900 dark:text-white leading-tight">
                    Data Desa Secara <span class="text-transparent bg-clip-text bg-gradient-to-r from-brand-600 to-accent">Real-Time.</span>
                </h2>
            </div>
            <a href="<?= site_url('data-wilayah') ?>" class="inline-flex items-center gap-2 text-brand-800 dark:text-brand-300 font-bold text-sm hover:gap-3 transition-all group underline decoration-brand-800/20 underline-offset-4 decoration-2">
                Lihat Laporan Lengkap 
                <i class="fa-solid fa-arrow-right-long text-xs transition-transform group-hover:translate-x-1" aria-hidden="true"></i>
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            
            <!-- Card 1: Penduduk -->
            <div data-aos="fade-up" data-aos-delay="100" class="group p-8 rounded-[2.5rem] bg-[#f8fafc] dark:bg-slate-800 border border-slate-100 dark:border-slate-700/50 hover:bg-white dark:hover:bg-slate-700 hover:shadow-2xl hover:shadow-brand-600/10 hover:-translate-y-2 active:scale-[0.98] cursor-pointer transition-all duration-500">
                <div class="flex items-center gap-3 mb-8">
                    <div class="w-10 h-10 rounded-xl bg-brand-100 dark:bg-brand-900/40 text-brand-600 dark:text-brand-400 flex items-center justify-center text-xl transition-transform group-hover:rotate-12">
                        <i class="fa-solid fa-users-viewfinder transition-transform group-hover:scale-110"></i>
                    </div>
                    <span class="text-[10px] font-black text-slate-500 dark:text-slate-400 uppercase tracking-widest">Populasi Penduduk</span>
                </div>
                
                <div class="space-y-1 mb-8">
                    <span class="text-6xl font-display font-black text-slate-900 dark:text-white leading-none tracking-tighter group-hover:text-brand-600 transition-colors"><?= number_format($penduduk,0,',','.') ?></span>
                </div>
                
                <div class="space-y-5 pt-6 border-t border-slate-200/60 dark:border-slate-700/50">
                    <div class="space-y-2">
                        <div class="flex justify-between text-xs font-bold">
                            <span class="text-slate-800 dark:text-slate-300">Laki-Laki</span>
                            <span class="text-brand-600 dark:text-brand-400"><?= $persen_laki ?>%</span>
                        </div>
                        <div class="h-1.5 w-full bg-slate-200 dark:bg-slate-800 rounded-full overflow-hidden">
                            <div class="h-full bg-brand-600 rounded-full transition-all duration-1000 group-hover:saturate-150" style="width: <?= $persen_laki ?>%"></div>
                        </div>
                    </div>
                    <div class="space-y-2">
                        <div class="flex justify-between text-xs font-bold">
                            <span class="text-slate-800 dark:text-slate-300">Perempuan</span>
                            <span class="text-brand-600 dark:text-brand-400"><?= $persen_perm ?>%</span>
                        </div>
                        <div class="h-1.5 w-full bg-slate-200 dark:bg-slate-800 rounded-full overflow-hidden">
                            <div class="h-full bg-accent rounded-full transition-all duration-1000 group-hover:saturate-150" style="width: <?= $persen_perm ?>%"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card 2: Wilayah -->
            <div data-aos="fade-up" data-aos-delay="200" class="group p-8 rounded-[2.5rem] bg-[#f8fafc] dark:bg-slate-800 border border-slate-100 dark:border-slate-700/50 hover:bg-white dark:hover:bg-slate-700 hover:shadow-2xl hover:shadow-amber-600/10 hover:-translate-y-2 active:scale-[0.98] cursor-pointer transition-all duration-500">
                <div class="flex items-center gap-3 mb-8">
                    <div class="w-10 h-10 rounded-xl bg-amber-100 dark:bg-amber-900/40 text-amber-600 dark:text-amber-400 flex items-center justify-center text-xl transition-transform group-hover:rotate-12">
                        <i class="fa-solid fa-map-location-dot transition-transform group-hover:scale-110"></i>
                    </div>
                    <span class="text-[10px] font-black text-slate-500 dark:text-slate-400 uppercase tracking-widest">Luas Wilayah (Ha)</span>
                </div>
                
                <div class="space-y-1 mb-8">
                    <span class="text-6xl font-display font-black text-slate-900 dark:text-white leading-none tracking-tighter group-hover:text-amber-600 transition-colors">217</span>
                </div>
                
                <div class="space-y-5 pt-6 border-t border-slate-200/60 dark:border-slate-700/50">
                    <!-- Progress Stats -->
                    <div class="space-y-2">
                        <div class="flex justify-between text-[10px] font-bold uppercase tracking-wider">
                            <span class="text-slate-600 dark:text-slate-300">Pemukiman</span>
                            <span class="text-slate-900 dark:text-white">42%</span>
                        </div>
                        <div class="h-1.5 w-full bg-slate-200 dark:bg-slate-700 rounded-full overflow-hidden">
                            <div class="h-full bg-emerald-500 rounded-full transition-all duration-1000" style="width: 42%"></div>
                        </div>
                    </div>
                    <div class="space-y-2">
                        <div class="flex justify-between text-[10px] font-bold uppercase tracking-wider">
                            <span class="text-slate-600 dark:text-slate-300">Sawah</span>
                            <span class="text-slate-900 dark:text-white">53%</span>
                        </div>
                        <div class="h-1.5 w-full bg-slate-200 dark:bg-slate-700 rounded-full overflow-hidden">
                            <div class="h-full bg-emerald-500 rounded-full transition-all duration-1000" style="width: 53%"></div>
                        </div>
                    </div>
                </div>

                <a href="<?= site_url('peta') ?>" class="mt-8 bg-slate-900 dark:bg-brand-900 text-white p-4 rounded-2xl flex items-center justify-between shadow-lg shadow-slate-900/20 transition-all hover:bg-brand-600 group-hover:scale-[1.02] cursor-pointer">
                    <span class="text-[10px] font-bold uppercase tracking-widest opacity-80">Orbitasi Wilayah</span>
                    <i class="fa-solid fa-circle-nodes text-brand-400 group-hover:text-white transition-colors"></i>
                </a>
            </div>

            <!-- Card 3: APBDes Transparan -->
            <div data-aos="fade-up" data-aos-delay="300" class="group p-8 rounded-[2.5rem] bg-brand-900 dark:bg-slate-800 border border-transparent dark:border-slate-700/50 backdrop-blur-2xl hover:shadow-2xl hover:shadow-emerald-600/20 hover:-translate-y-2 active:scale-[0.98] cursor-pointer transition-all duration-500 relative overflow-hidden shadow-2xl">
                <!-- Inner Light Effect -->
                <div class="absolute -right-20 -bottom-20 w-40 h-40 bg-brand-500/20 rounded-full blur-3xl opacity-50 dark:opacity-20"></div>
                
                <div class="flex items-center gap-3 mb-8 relative z-10">
                    <div class="w-10 h-10 rounded-xl bg-white/10 backdrop-blur-md text-white flex items-center justify-center text-xl border border-white/10">
                        <i class="fa-solid fa-sack-dollar transition-transform group-hover:scale-110"></i>
                    </div>
                    <span class="text-[10px] font-black text-white/70 uppercase tracking-widest">APBDes 2026 (Juta)</span>
                </div>

                <div class="space-y-1 mb-8 relative z-10">
                    <span class="text-6xl font-display font-black text-white leading-none tracking-tighter">1559</span>
                </div>
                
                <div class="space-y-5 relative z-10 pt-6 border-t border-white/10 dark:border-slate-700/50">
                    <!-- Progress Stats -->
                    <div class="space-y-2">
                        <div class="flex items-center justify-between text-[10px] font-bold text-white/70 uppercase tracking-wider">
                            <span>Belanja Pemerintahan</span>
                            <span class="text-white">54%</span>
                        </div>
                        <div class="w-full h-1.5 bg-white/10 rounded-full overflow-hidden">
                            <div class="h-full bg-emerald-400 w-[54%]"></div>
                        </div>
                    </div>
                    <div class="space-y-2">
                        <div class="flex items-center justify-between text-[10px] font-bold text-white/70 uppercase tracking-wider">
                            <span>Pembangunan Desa</span>
                            <span class="text-white">20%</span>
                        </div>
                        <div class="w-full h-1.5 bg-white/10 rounded-full overflow-hidden">
                            <div class="h-full bg-emerald-400 w-[20%]"></div>
                        </div>
                    </div>
                    <div class="space-y-2">
                        <div class="flex items-center justify-between text-[10px] font-bold text-white/70 uppercase tracking-wider">
                            <span>Pemberdayaan Masyarakat</span>
                            <span class="text-white">24%</span>
                        </div>
                        <div class="w-full h-1.5 bg-white/10 rounded-full overflow-hidden">
                            <div class="h-full bg-emerald-400 w-[24%]"></div>
                        </div>
                    </div>
                    <div class="space-y-2">
                        <div class="flex items-center justify-between text-[10px] font-bold text-white/70 uppercase tracking-wider">
                            <span>Penanggulangan Bencana</span>
                            <span class="text-white">02%</span>
                        </div>
                        <div class="w-full h-1.5 bg-white/10 rounded-full overflow-hidden">
                            <div class="h-full bg-emerald-400 w-[2%]"></div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>
</section>
