<?php if(!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<div class="list-frame">
    <!-- Info Tanggal Pemilihan -->
    <div class="mb-8 p-6 rounded-3xl bg-amber-50 dark:bg-amber-900/10 border border-amber-100 dark:border-amber-800/50 flex items-center gap-4 text-amber-700 dark:text-amber-400">
        <div class="w-12 h-12 rounded-2xl bg-amber-100 dark:bg-amber-900/30 flex items-center justify-center text-xl">
            <i class="fa-solid fa-calendar-check"></i>
        </div>
        <div>
            <p class="text-[10px] font-black uppercase tracking-widest opacity-100 leading-none mb-1">Jadwal Pemilihan</p>
            <p class="text-sm font-bold"><?= $tanggal_pemilihan ?: '-' ?></p>
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="premium-table">
            <thead>
                <tr>
                    <th width="50">#</th>
                    <th class="text-left">Wilayah / <?= ucwords($this->setting->sebutan_dusun) ?></th>
                    <th class="text-center">RW</th>
                    <th class="text-right">Jiwa</th>
                    <th class="text-right">Laki-laki</th>
                    <th class="text-right">Perempuan</th>
                </tr>
            </thead>
            <tbody>
                <?php if(count($main) > 0) : ?>
                    <?php foreach($main as $data) : ?>
                        <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/30 transition-colors">
                            <td class="text-center"><?= $data['no'] ?></td>
                            <td class="font-bold uppercase tracking-wide"><?= strtoupper($data['dusun']) ?></td>
                            <td class="text-center font-semibold text-slate-600 dark:text-slate-400">RW <?= strtoupper($data['rw']) ?></td>
                            <td class="text-right font-bold"><?= number_format($data['jumlah_warga'], 0, ',', '.') ?></td>
                            <td class="text-right"><?= number_format($data['jumlah_warga_l'], 0, ',', '.') ?></td>
                            <td class="text-right"><?= number_format($data['jumlah_warga_p'], 0, ',', '.') ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="6" class="py-24 text-center">
                            <i class="fa-solid fa-folder-open text-4xl text-slate-200 mb-4 block"></i>
                            <span class="text-slate-400 font-bold uppercase tracking-widest text-xs">Daftar calon pemilih belum tersedia</span>
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
            <?php if(count($main) > 0) : ?>
                <tfoot>
                    <tr class="bg-slate-50 dark:bg-slate-800/50">
                        <th colspan="3" class="text-right py-6 uppercase tracking-widest text-[10px]">Total Keseluruhan</th>
                        <th class="text-right py-6 text-slate-600 dark:text-slate-300"><?= number_format($total['total_warga'], 0, ',', '.') ?></th>
                        <th class="text-right py-6 text-slate-600 dark:text-slate-300"><?= number_format($total['total_warga_l'], 0, ',', '.') ?></th>
                        <th class="text-right py-6 text-slate-600 dark:text-slate-300"><?= number_format($total['total_warga_p'], 0, ',', '.') ?></th>
                    </tr>
                </tfoot>
            <?php endif; ?>
        </table>
    </div>
</div>
