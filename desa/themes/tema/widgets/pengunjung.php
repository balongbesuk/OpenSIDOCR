<?php if(!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<div class="mb-10 group/widget" id="visitor-widget-container">
    <div class="premium-card overflow-hidden">
        <!-- Header Section -->
        <div class="p-8 pb-6 border-b border-slate-50 dark:border-slate-800 bg-slate-50/30 dark:bg-slate-800/20 backdrop-blur-md">
            <h3 class="premium-h1 text-[10px] uppercase tracking-[0.3em] flex items-center gap-3">
                <i class="fa-solid fa-chart-pie text-brand-600"></i>
                <?= $judul_widget ?>
            </h3>
        </div>

        <div class="p-8 pt-10">
            <div class="grid grid-cols-1 gap-4">
                
                <!-- Today Statistics -->
                <div class="group/item flex items-center justify-between p-6 rounded-[2rem] bg-brand-50/40 dark:bg-brand-900/10 border border-brand-100/50 dark:border-brand-900/20 transition-all duration-300 hover:scale-[1.02]">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-2xl bg-white dark:bg-slate-800 shadow-lg shadow-brand-600/10 flex items-center justify-center text-brand-600 transition-colors group-hover/item:bg-brand-600 group-hover/item:text-white">
                            <i class="fa-solid fa-users-viewfinder text-lg"></i>
                        </div>
                        <div>
                            <span class="block text-[8px] font-display font-black text-slate-500 dark:text-slate-400 uppercase tracking-widest leading-none mb-1.5">Hari Ini</span>
                            <h4 class="font-display font-black text-xl text-slate-900 dark:text-white leading-none tracking-tighter">
                                <?= number_format($pengunjung['hari_ini'], 0, ',', '.') ?>
                            </h4>
                        </div>
                    </div>
                    <div class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></div>
                </div>

                <!-- Yesterday Statistics -->
                <div class="group/item flex items-center justify-between p-6 rounded-[2rem] bg-slate-50 dark:bg-slate-800/30 border border-slate-100 dark:border-slate-700/50 transition-all duration-300 hover:scale-[1.02]">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-2xl bg-white dark:bg-slate-800 shadow-sm flex items-center justify-center text-slate-400 dark:text-slate-500 transition-colors group-hover/item:text-brand-600">
                            <i class="fa-solid fa-calendar-check text-lg"></i>
                        </div>
                        <div>
                            <span class="block text-[8px] font-display font-black text-slate-500 dark:text-slate-400 uppercase tracking-widest leading-none mb-1.5">Kemarin</span>
                            <h4 class="font-display font-black text-xl text-slate-900 dark:text-white leading-none tracking-tighter">
                                <?= number_format($pengunjung['kemarin'], 0, ',', '.') ?>
                            </h4>
                        </div>
                    </div>
                </div>

                <!-- Total Statistics -->
                <div class="group/item flex items-center justify-between p-6 rounded-[2rem] bg-slate-50 dark:bg-slate-800/30 border border-slate-100 dark:border-slate-700/50 transition-all duration-300 hover:scale-[1.02]">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-2xl bg-white dark:bg-slate-800 shadow-sm flex items-center justify-center text-slate-400 dark:text-slate-500 transition-colors group-hover/item:text-brand-600">
                            <i class="fa-solid fa-globe text-lg"></i>
                        </div>
                        <div>
                            <span class="block text-[8px] font-display font-black text-slate-500 dark:text-slate-400 uppercase tracking-widest leading-none mb-1.5">Total Kunjungan</span>
                            <h4 class="font-display font-black text-xl text-slate-900 dark:text-white leading-none tracking-tighter">
                                <?= number_format($pengunjung['total'], 0, ',', '.') ?>
                            </h4>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Online Indicator -->
            <div class="mt-8 pt-8 border-t border-slate-50 dark:border-slate-800 flex items-center justify-between px-2">
                <div class="flex items-center gap-2">
                    <span class="text-[10px] font-bold text-slate-500 dark:text-slate-400 uppercase tracking-widest">Digital Presence</span>
                </div>
                <div class="flex items-center gap-3">
                    <span class="text-[10px] font-black text-emerald-500 uppercase tracking-[0.2em]">Verified Status</span>
                    <i class="fa-solid fa-circle-check text-emerald-500 text-xs"></i>
                </div>
            </div>
        </div>
    </div>
</div>
