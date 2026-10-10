<?php if(!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<div class="list-frame">
    <div class="overflow-x-auto">
        <?php if(count($daftar_dusun) > 0) : ?>
            <table class="premium-table border-collapse w-full">
                <thead>
                    <tr class="bg-slate-50 dark:bg-slate-800/50">
                        <th colspan="3" width="120" class="text-center">No</th>
                        <th class="text-left">Wilayah / Ketua</th>
                        <th class="text-right" width="100">KK</th>
                        <th class="text-right" width="100">L+P</th>
                        <th class="text-right" width="100">L</th>
                        <th class="text-right" width="100">P</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($daftar_dusun as $key_dusun => $data_dusun): ?>
                        <tr class="bg-slate-50/30 dark:bg-slate-800/10">
                            <td class="text-center font-bold" width="40"><?= $key_dusun + 1; ?></td>
                            <td class="text-center" width="40"></td>
                            <td class="text-center" width="40"></td>
                            <td class="font-bold uppercase tracking-tight py-4">
                                <?= $this->setting->sebutan_dusun ?> <?= strtoupper($data_dusun['dusun']); ?><?= $data_dusun['nama_kadus'] ? ' , Ketua ' . strtoupper(html_escape($data_dusun['nama_kadus'])) : ''; ?>
                            </td>
                            <td class="text-right font-medium"><?= number_format($data_dusun['jumlah_kk'], 0, ',', '.'); ?></td>
                            <td class="text-right font-bold text-slate-900 dark:text-white"><?= number_format($data_dusun['jumlah_warga'], 0, ',', '.'); ?></td>
                            <td class="text-right"><?= number_format($data_dusun['jumlah_warga_l'], 0, ',', '.'); ?></td>
                            <td class="text-right"><?= number_format($data_dusun['jumlah_warga_p'], 0, ',', '.'); ?></td>
                        </tr>

                        <?php $no_rw = 1; foreach ($data_dusun['daftar_rw'] as $data_rw): ?>
                            <?php if ($data_rw['rw'] != '-'): ?>
                                <tr>
                                    <td class="text-center"></td>
                                    <td class="text-center font-bold text-slate-500"><?= $no_rw++; ?></td>
                                    <td class="text-center"></td>
                                    <td class="text-left font-semibold text-slate-700 dark:text-slate-300 py-3">
                                        RW <?= strtoupper($data_rw['rw']); ?><?= $data_rw['nama_ketua'] ? ' , Ketua ' . strtoupper(html_escape($data_rw['nama_ketua'])) : ''; ?>
                                    </td>
                                    <td class="text-right text-slate-600"><?= number_format($data_rw['jumlah_kk'], 0, ',', '.'); ?></td>
                                    <td class="text-right font-semibold text-slate-800 dark:text-slate-200"><?= number_format($data_rw['jumlah_warga'], 0, ',', '.'); ?></td>
                                    <td class="text-right text-slate-600"><?= number_format($data_rw['jumlah_warga_l'], 0, ',', '.'); ?></td>
                                    <td class="text-right text-slate-600"><?= number_format($data_rw['jumlah_warga_p'], 0, ',', '.'); ?></td>
                                </tr>

                                <?php $no_rt = 1; foreach ($data_rw['daftar_rt'] as $data_rt): ?>
                                    <?php if ($data_rt['rt'] != '-'): ?>
                                        <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/30 transition-colors">
                                            <td class="text-center"></td>
                                            <td class="text-center"></td>
                                            <td class="text-center text-slate-400"><?= $no_rt++; ?></td>
                                            <td class="text-left text-slate-500 dark:text-slate-400 pl-4 py-2">
                                                RT <?= strtoupper($data_rt['rt']); ?><?= $data_rt['nama_ketua'] ? ' , Ketua ' . strtoupper(html_escape($data_rt['nama_ketua'])) : ''; ?>
                                            </td>
                                            <td class="text-right text-slate-500"><?= number_format($data_rt['jumlah_kk'], 0, ',', '.'); ?></td>
                                            <td class="text-right text-slate-500"><?= number_format($data_rt['jumlah_warga'], 0, ',', '.'); ?></td>
                                            <td class="text-right text-slate-500"><?= number_format($data_rt['jumlah_warga_l'], 0, ',', '.'); ?></td>
                                            <td class="text-right text-slate-500"><?= number_format($data_rt['jumlah_warga_p'], 0, ',', '.'); ?></td>
                                        </tr>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    <?php endforeach; ?>
                </tbody>
                <tfoot>
                    <tr class="bg-slate-50 dark:bg-slate-800/50">
                        <th colspan="4" class="text-right py-6 uppercase tracking-widest text-[10px] px-6">Total Keseluruhan</th>
                        <th class="text-right py-6 text-slate-600 dark:text-slate-300"><?= number_format($total['total_kk'], 0, ',', '.'); ?></th>
                        <th class="text-right py-6 text-slate-600 dark:text-slate-300"><?= number_format($total['total_warga'], 0, ',', '.'); ?></th>
                        <th class="text-right py-6 text-slate-600 dark:text-slate-300"><?= number_format($total['total_warga_l'], 0, ',', '.'); ?></th>
                        <th class="text-right py-6 text-slate-600 dark:text-slate-300"><?= number_format($total['total_warga_p'], 0, ',', '.'); ?></th>
                    </tr>
                </tfoot>
            </table>
        <?php else : ?>
            <div class="py-24 text-center">
                <i class="fa-solid fa-folder-open text-4xl text-slate-200 mb-4 block"></i>
                <span class="text-slate-400 font-bold uppercase tracking-widest text-xs">Data wilayah belum tersedia</span>
            </div>
        <?php endif; ?>
    </div>
</div>



