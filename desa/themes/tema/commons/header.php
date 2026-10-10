<?php  if(!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<!-- Reading Progress Bar -->
<div id="reading-progress"></div>

<!-- [ STANDARD PROFESSIONAL NAVIGATION ] -->
<header class="fixed top-0 inset-x-0 z-[1000000] bg-white dark:bg-slate-900 border-b border-slate-200 dark:border-slate-800 shadow-sm transition-all duration-300">
    <div class="max-w-7xl mx-auto px-4 md:px-6">
        <div class="flex justify-between items-center h-20 md:h-24">
            
            <!-- Brand -->
            <div class="flex items-center">
                <a href="<?= site_url(); ?>" class="flex items-center gap-4">
                    <img src="<?= gambar_desa($desa['logo']) ?>" alt="Logo" width="48" height="48" class="w-10 h-10 md:w-12 md:h-12 object-contain" loading="eager" />
                    <div class="flex flex-col">
                        <span class="premium-h1 text-lg md:text-xl leading-none">
                            <?= html_escape($desa['nama_desa']) ?>
                        </span>
                        <span class="premium-p text-[9px] uppercase tracking-widest mt-1 text-slate-600 dark:text-slate-300">
                             Portal Resmi Pemerintah Desa
                        </span>
                    </div>
                </a>
            </div>

            <!-- Desktop Nav -->
            <div class="hidden lg:flex items-center h-full">
                <div class="flex items-center gap-1 h-full">
                    <?php foreach($menu_atas as $data): ?>
                        <?php $has_sub = (isset($data['submenu']) && is_array($data['submenu']) && count($data['submenu']) > 0); ?>
                        <div class="relative h-full flex items-center menu-node-group">
                            <a href="<?= html_escape($data['link']) ?>" class="px-4 py-2 rounded-lg text-[13px] font-bold text-slate-700 dark:text-slate-200 hover:text-brand-600 dark:hover:text-white transition-all flex items-center gap-2 uppercase tracking-wide">
                                <?= html_escape($data['nama']) ?>
                                <?php if($has_sub): ?>
                                    <i class="fa-solid fa-chevron-down text-[10px] opacity-50"></i>
                                <?php endif; ?>
                            </a>

                            <?php if($has_sub): ?>
                                <!-- Robust Dropdown Panel -->
                                <div class="dropdown-panel-container absolute top-full left-0 pt-2 w-64 z-[1000001] hidden overflow-visible">
                                    <div class="glass-submenu rounded-xl py-2 overflow-hidden">
                                        <?php foreach($data['submenu'] as $submenu): ?>
                                            <a href="<?= html_escape($submenu['link']) ?>" class="block px-6 py-3 text-[12px] font-semibold text-slate-700 dark:text-slate-300 hover:bg-white/10 dark:hover:bg-white/5 hover:text-brand-600 dark:hover:text-white transition-colors uppercase tracking-wider">
                                                <?= html_escape($submenu['nama']) ?>
                                            </a>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
                
                <!-- Theme Toggle -->
                <div class="flex items-center ml-4 pl-4 border-l border-slate-200 dark:border-slate-800 h-8">
                    <button onclick="toggleDarkMode()" class="w-10 h-10 rounded-lg bg-slate-50 dark:bg-slate-800 flex items-center justify-center text-slate-600 dark:text-slate-400 hover:bg-brand-600 hover:text-white transition-all" aria-label="Ganti Tema">
                        <i class="fa-solid fa-moon dark:hidden" aria-hidden="true"></i>
                        <i class="fa-solid fa-sun hidden dark:block" aria-hidden="true"></i>
                    </button>
                </div>
            </div>

            <!-- Mobile Trigger -->
            <button onclick="toggleMobileMenu()" class="lg:hidden p-2 text-slate-600 dark:text-white" aria-label="Buka Menu">
                <i class="fa-solid fa-bars text-2xl" aria-hidden="true"></i>
            </button>
        </div>
    </div>
</header>

<style>
    /* CSS-based Hover for Maximum Reliability */
    .menu-node-group:hover .dropdown-panel-container {
        display: block !important;
    }
    
    .menu-node-group:hover > a {
        color: #2563eb !important;
    }
    
    .dark .menu-node-group:hover > a {
        color: #ffffff !important;
    }
</style>

<!-- Mobile Menu (Standard Sidebar Model) -->
<div id="mobileMenu" class="fixed inset-0 z-[2000000] translate-x-full transition-transform duration-500 flex flex-col">
    <!-- Header Sidebar -->
    <div class="p-6 flex justify-between items-center border-b dark:border-slate-800/60 bg-white/80 dark:bg-slate-900/80 backdrop-blur-xl sticky top-0 z-20">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-2xl bg-gradient-to-br from-brand-500 to-brand-700 flex items-center justify-center text-white shadow-lg shadow-brand-500/20">
                 <i class="fa-solid fa-compass text-lg"></i>
            </div>
            <div class="flex flex-col">
                <span class="font-black text-slate-900 dark:text-white uppercase tracking-tighter text-lg leading-none">Navigasi</span>
                <span class="text-[9px] text-slate-500 dark:text-slate-400 font-bold uppercase tracking-[0.2em] mt-1">Menu Utama Portal</span>
            </div>
        </div>
        <button onclick="toggleMobileMenu()" class="w-12 h-12 rounded-2xl bg-white dark:bg-slate-800 border border-slate-200/50 dark:border-slate-700/50 flex items-center justify-center text-slate-600 dark:text-white active:scale-90 transition-all shadow-sm" aria-label="Tutup Menu">
            <i class="fa-solid fa-xmark text-xl" aria-hidden="true"></i>
        </button>
    </div>

    <!-- Navigation List: Elegant Minimalist -->
    <div class="flex-1 overflow-y-auto px-6 py-8 space-y-8 custom-scrollbar">
        
        <!-- Category Label -->
        <div class="space-y-4">
            <span class="text-[10px] font-black uppercase tracking-[0.3em] text-slate-500 dark:text-slate-400 ml-2">Main Directory</span>
            
            <nav class="flex flex-col">
                <?php foreach($menu_atas as $data): ?>
                    <?php $has_sub = !empty($data['submenu']); ?>
                    <div class="group/mobile-nav relative">
                        <div class="flex items-center">
                            <a href="<?= html_escape($data['link']) ?>" class="flex-1 py-4 flex items-center justify-between group-hover/mobile-nav:translate-x-1 transition-transform duration-300">
                                <div class="flex items-center gap-5">
                                    <div class="w-1.5 h-6 rounded-full bg-slate-200 dark:bg-slate-800 group-hover/mobile-nav:bg-brand-600 transition-colors"></div>
                                    <span class="text-xl font-bold text-slate-900 dark:text-white tracking-tight group-hover/mobile-nav:text-brand-600 transition-colors"><?= html_escape($data['nama']) ?></span>
                                </div>
                            </a>
                            
                            <?php if($has_sub): ?>
                                <button onclick="toggleSubMenu(this)" class="w-12 h-12 flex items-center justify-center text-slate-300 dark:text-slate-600 hover:text-brand-600 active:scale-75 transition-all" aria-label="Buka Submenu">
                                    <i class="fa-solid fa-plus text-sm transition-transform duration-500" aria-hidden="true"></i>
                                </button>
                            <?php else: ?>
                                <div class="w-12 h-12 flex items-center justify-center opacity-0 group-hover/mobile-nav:opacity-100 transition-opacity">
                                    <i class="fa-solid fa-arrow-right-long text-brand-600 text-xs text-slate-400"></i>
                                </div>
                            <?php endif; ?>
                        </div>

                        <?php if($has_sub): ?>
                            <!-- Minimalist Submenu Expansion -->
                            <div class="max-h-0 overflow-hidden ml-6 mobile-submenu transition-all duration-500 ease-[cubic-bezier(0.16,1,0.3,1)] opacity-0">
                                <div class="py-2 flex flex-col gap-1 border-l-2 border-slate-100 dark:border-slate-800/50 ml-0.5 pl-6">
                                    <?php foreach($data['submenu'] as $submenu): ?>
                                        <a href="<?= html_escape($submenu['link']) ?>" class="py-3 text-[13px] font-bold text-slate-600 dark:text-slate-300 uppercase tracking-widest hover:text-brand-600 dark:hover:text-white flex items-center gap-3 group">
                                            <span class="w-1 h-1 rounded-full bg-slate-300 dark:bg-slate-700 group-hover:scale-150 group-hover:bg-brand-500 transition-all"></span>
                                            <?= html_escape($submenu['nama']) ?>
                                        </a>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        <?php endif; ?>
                        
                        <!-- Thin Divider -->
                        <div class="h-[1px] w-full bg-slate-100 dark:bg-slate-800/40"></div>
                    </div>
                <?php endforeach; ?>
            </nav>
        </div>

        <!-- System Actions: Integrated Glass Cards -->
        <div class="space-y-4 pt-4">
            <span class="text-[10px] font-black uppercase tracking-[0.3em] text-slate-500 dark:text-slate-400 ml-2">Quick Access</span>
            <div class="grid grid-cols-1 gap-3">
                <a href="<?= site_url('layanan-mandiri') ?>" class="group flex items-center justify-between p-4 rounded-2xl bg-white dark:bg-slate-900 border border-slate-200/50 dark:border-slate-800/50 shadow-sm hover:border-brand-600/30 transition-all">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-xl bg-brand-50 dark:bg-brand-900/20 text-brand-600 flex items-center justify-center">
                            <i class="fa-solid fa-fingerprint text-xl"></i>
                        </div>
                        <div class="flex flex-col">
                            <span class="text-sm font-black text-slate-900 dark:text-white uppercase tracking-tight">Layanan Mandiri</span>
                            <span class="text-[9px] font-bold text-slate-500 uppercase tracking-wider">Akses Warga Desa</span>
                        </div>
                    </div>
                    <div class="w-8 h-8 rounded-full bg-slate-50 dark:bg-slate-800 flex items-center justify-center text-slate-300 group-hover:text-brand-600 transition-colors">
                        <i class="fa-solid fa-arrow-right text-[10px]"></i>
                    </div>
                </a>

                <a href="<?= site_url('peta') ?>" class="group flex items-center justify-between p-4 rounded-2xl bg-white dark:bg-slate-900 border border-slate-200/50 dark:border-slate-800/50 shadow-sm hover:border-accent/30 transition-all">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-xl bg-accent/10 text-accent flex items-center justify-center">
                            <i class="fa-solid fa-map-marked-alt text-xl"></i>
                        </div>
                        <div class="flex flex-col">
                            <span class="text-sm font-black text-slate-900 dark:text-white uppercase tracking-tight">E-GIS Kawasan</span>
                            <span class="text-[9px] font-bold text-slate-500 uppercase tracking-wider">Peta Digital Desa</span>
                        </div>
                    </div>
                    <div class="w-8 h-8 rounded-full bg-slate-50 dark:bg-slate-800 flex items-center justify-center text-slate-300 group-hover:text-accent transition-colors">
                        <i class="fa-solid fa-arrow-right text-[10px]"></i>
                    </div>
                </a>
            </div>
        </div>
    </div>

    <!-- Footer Sidebar: Theme Toggle -->
    <div class="p-6 pb-12 border-t dark:border-slate-800/60 bg-white/30 dark:bg-slate-950/30 backdrop-blur-sm">
        <button onclick="toggleDarkMode()" class="w-full h-16 bg-white dark:bg-slate-800/40 border border-slate-200/80 dark:border-slate-700/50 rounded-2xl font-bold text-slate-900 dark:text-white flex items-center justify-between px-6 transition-all active:scale-[0.98] shadow-xl shadow-slate-200/50 dark:shadow-none group overflow-hidden relative">
            <!-- Animated Background Glow -->
            <div class="absolute inset-0 bg-gradient-to-r from-brand-600/5 to-transparent dark:from-sky-900/10 opacity-0 group-hover:opacity-100 transition-opacity"></div>
            
            <div class="flex items-center gap-4 relative z-10">
                <div class="w-11 h-11 rounded-xl bg-slate-50 dark:bg-slate-700 shadow-inner flex items-center justify-center text-brand-600 dark:text-amber-400 border border-slate-100 dark:border-slate-600 transition-all group-hover:rotate-[360deg] duration-700">
                    <i class="fa-solid fa-moon dark:hidden text-lg"></i>
                    <i class="fa-solid fa-sun hidden dark:block text-lg"></i>
                </div>
                <div class="flex flex-col items-start leading-none">
                    <span class="text-sm font-black uppercase tracking-tight">Ganti Tema</span>
                    <span class="text-[9px] font-medium text-slate-500 dark:text-slate-400 uppercase tracking-widest mt-1">Dark / Light Mode</span>
                </div>
            </div>
            
            <div class="w-12 h-6 bg-slate-200 dark:bg-brand-600/30 rounded-full relative transition-colors duration-300">
                <div class="w-4 h-4 bg-white dark:bg-brand-400 rounded-full absolute top-1 left-1 transition-transform duration-300 dark:translate-x-6 shadow-sm"></div>
            </div>
        </button>
    </div>
</div>
