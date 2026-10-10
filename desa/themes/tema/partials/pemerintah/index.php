<?php if(!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<div class="pemerintah-container pb-32 relative overflow-hidden">
    <!-- Fluid background elements -->
    <div class="absolute -top-24 -left-24 w-96 h-96 bg-brand-600/10 rounded-full blur-[100px] animate-pulse"></div>
    <div class="absolute top-1/2 -right-48 w-[600px] h-[600px] bg-accent/5 rounded-full blur-[120px]"></div>

    <!-- Hero Header: Modern Minimalism -->
    <div class="relative z-10 pt-10 mb-24">
        <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-12">
            <div class="space-y-6 max-w-2xl">
                <nav class="flex items-center gap-4 text-[10px] font-black text-slate-400 uppercase tracking-[0.4em]">
                    <a href="<?= site_url() ?>" class="hover:text-brand-600 transition-colors">Portal</a>
                    <span class="w-1 h-1 bg-slate-300 rounded-full"></span>
                    <span class="text-slate-900 dark:text-white"><?= ucwords($this->setting->sebutan_pemerintah_desa) ?></span>
                </nav>
                
                <h1 class="premium-h1 text-6xl md:text-8xl tracking-tighter leading-[0.85]">
                    Pilar <br/>
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-brand-600 to-brand-400">Pelayanan.</span>
                </h1>
                
                <p class="premium-p text-lg max-w-xl">
                    Sinergi dedikasi dan profesionalisme jajaran <?= $this->setting->sebutan_pemerintah_desa ?> dalam melayani masyarakat dengan integritas tinggi.
                </p>
            </div>

            <div class="shrink-0 lg:text-right">
                <div class="inline-flex flex-col items-center lg:items-end">
                    <span class="text-5xl font-display font-black text-brand-600/20 dark:text-brand-600/10"><?= count($pemerintah) ?></span>
                    <span class="text-[10px] font-black text-slate-400 uppercase tracking-[0.3em]">Total Personel Terdaftar</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Personel List: Pillar Layout -->
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 2xl:grid-cols-4 gap-x-10 gap-y-20" id="pemerintah-list">
        <?php if ($pemerintah): ?>
            <?php foreach ($pemerintah as $data): ?>
                <?php 
                    $foto = base_url('assets/images/pengguna/kuser.png');
                    if (!empty($data['foto'])) {
                        if (strpos($data['foto'], 'http') === 0) {
                            $foto = $data['foto'];
                        } elseif (file_exists(FCPATH . LOKASI_USER_PICT . $data['foto'])) {
                            $foto = base_url(LOKASI_USER_PICT . $data['foto']);
                        } elseif (file_exists(FCPATH . LOKASI_USER_PICT . 'kecil_' . $data['foto'])) {
                            $foto = base_url(LOKASI_USER_PICT . 'kecil_' . $data['foto']);
                        }
                    }
                    
                    $social_platforms = json_decode($this->setting->media_sosial_pemerintah_desa, true) ?: [];
                    $official_links = json_decode($data['media_sosial'], true) ?: [];
                ?>
                <div class="group relative flex flex-col h-full">
                    <!-- The Pillar -->
                    <div class="relative flex-1 rounded-[3.5rem] bg-white dark:bg-slate-900/50 p-4 border border-slate-100 dark:border-slate-800 shadow-2xl shadow-slate-200/50 dark:shadow-none transition-all duration-700 hover:shadow-brand-600/20 group-hover:-translate-y-6 group-hover:bg-white dark:group-hover:bg-slate-900">
                        
                        <!-- Image Pillar -->
                        <div class="relative aspect-[4/5] rounded-[3rem] overflow-hidden bg-slate-50 dark:bg-slate-800 mb-8">
                            <img
                                loading="lazy"
                                class="w-full h-full object-cover grayscale group-hover:grayscale-0 transition-all duration-1000 scale-105 group-hover:scale-110"
                                src="<?= $foto ?>"
                                alt="Foto <?= $data['nama'] ?>"
                            />
                            
                            <!-- Internal Floating Badge -->
                            <?php if (isset($data['kehadiran']) && $data['kehadiran'] == 1): ?>
                                <div class="absolute top-4 left-4 z-20">
                                    <div class="flex items-center gap-2 bg-slate-900/80 backdrop-blur-md px-3 py-1.5 rounded-2xl border border-white/20">
                                        <div class="w-2 h-2 rounded-full <?= $data['status_kehadiran'] == 'hadir' ? 'bg-emerald-400 shadow-[0_0_10px_#10b981]' : 'bg-red-400' ?> animate-pulse"></div>
                                        <span class="text-[8px] font-black text-white uppercase tracking-widest"><?= $data['status_kehadiran'] == 'hadir' ? 'Active' : 'Away' ?></span>
                                    </div>
                                </div>
                            <?php endif; ?>
                            
                            <!-- Bottom Overlay: Position -->
                            <div class="absolute inset-x-0 bottom-0 p-6 bg-gradient-to-t from-slate-950/80 to-transparent">
                                <span class="inline-block px-4 py-1.5 rounded-full bg-brand-600 text-white font-black text-[9px] uppercase tracking-widest shadow-xl">
                                    <?= $data['jabatan'] ?>
                                </span>
                            </div>
                        </div>

                        <!-- Content Pillar -->
                        <div class="px-6 pb-6 text-center lg:text-left">
                            <h3 class="font-display font-black text-2xl text-slate-900 dark:text-white leading-tight tracking-tight mb-2 group-hover:text-brand-600 transition-colors">
                                <?= $data['nama'] ?>
                            </h3>
                            
                            <?php if (!empty($data['pamong_niap'])): ?>
                                <div class="flex items-center justify-center lg:justify-start gap-2 mb-6">
                                    <span class="text-[8px] font-black text-slate-300 dark:text-slate-600 uppercase tracking-[0.2em]"><?= $this->setting->sebutan_nip_desa ?></span>
                                    <span class="text-[10px] font-bold text-slate-400"><?= $data['pamong_niap'] ?></span>
                                </div>
                            <?php endif; ?>

                            <!-- Social Direct Actions -->
                            <div class="flex items-center justify-center lg:justify-start gap-2 opacity-0 group-hover:opacity-100 transition-all duration-500 translate-y-4 group-hover:translate-y-0">
                                <?php foreach ($social_platforms as $platform): ?>
                                    <?php if ($link = ($official_links[$platform] ?? '')): ?>
                                        <a href="<?= html_escape($link) ?>" target="_blank" rel="noopener noreferrer" class="w-8 h-8 rounded-xl bg-slate-100 dark:bg-slate-800 flex items-center justify-center text-slate-400 hover:bg-brand-600 hover:text-white transition-all shadow-sm">
                                            <i class="fa-brands fa-<?= $platform ?> text-xs"></i>
                                        </a>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Vertical label behind for large screens (Decorative) -->
                    <div class="absolute -right-4 top-1/2 -translate-y-1/2 opacity-0 group-hover:opacity-5 transition-opacity duration-700 pointer-events-none hidden xl:block">
                        <span class="text-8xl font-display font-black text-brand-600 uppercase tracking-tighter rotate-90 block">OFFICIAL</span>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="col-span-full py-40 text-center">
                <div class="relative w-32 h-32 mx-auto mb-10">
                    <div class="absolute inset-0 bg-brand-600/20 rounded-full animate-ping"></div>
                    <div class="relative w-full h-full rounded-full bg-slate-100 dark:bg-slate-800 flex items-center justify-center text-slate-300">
                        <i class="fa-solid fa-user-secret text-5xl"></i>
                    </div>
                </div>
                <h3 class="font-display font-black text-4xl text-slate-900 dark:text-white mb-4 tracking-tighter">Personel Not Found</h3>
                <p class="text-slate-500 max-w-sm mx-auto font-medium">Data struktur organisasi sedang dalam tahap sinkronisasi dengan kependudukan desa.</p>
            </div>
        <?php endif; ?>
    </div>
</div>

<style>
.grayscale { filter: grayscale(100%); transition: filter 0.8s cubic-bezier(0.4, 0, 0.2, 1); }
.group:hover .grayscale { filter: grayscale(0%); }

.pemerintah-container {
    background-image: radial-gradient(circle at 20% 20%, rgba(var(--brand-rgb), 0.02) 0%, transparent 40%);
}

@keyframes pulse-glow {
    0% { transform: scale(1); opacity: 1; }
    100% { transform: scale(2.5); opacity: 0; }
}
.shadow-\[0_0_10px_\#10b981\]::after {
    content: '';
    position: absolute;
    width: 100%; height: 100%;
    background: inherit;
    border-radius: inherit;
    animation: pulse-glow 2s infinite;
}
</style>
