<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<?php
$daftar_statistik = function_exists('daftar_statistik') ? daftar_statistik() : [];

// Fallback jika belum tersedia daftar_statistik
if (empty($daftar_statistik) && class_exists('App\Enums\Statistik\StatistikEnum')) {
    $daftar_statistik['penduduk'] = \App\Enums\Statistik\StatistikPendudukEnum::$data;
    $daftar_statistik['keluarga'] = \App\Enums\Statistik\StatistikKeluargaEnum::$data;
}

$current_url  = function_exists('current_url') ? current_url() : site_url();
$current_slug = $slug_aktif ?? '';

if ((isset($is_dpt) && $is_dpt) || strpos($current_url, 'daftar-pemilih-tetap') !== false || strpos($current_url, 'dpt') !== false) {
    $current_slug = 'daftar-pemilih-tetap';
} elseif ((isset($is_wilayah) && $is_wilayah) || strpos($current_url, 'data-wilayah') !== false || strpos($current_url, 'wilayah') !== false) {
    $current_slug = 'data-wilayah';
} elseif (strpos($current_url, 'perkembangan-penduduk') !== false) {
    $current_slug = 'perkembangan-penduduk';
} elseif (empty($current_slug)) {
    if (isset($st) && is_numeric($st) && class_exists('App\Enums\Statistik\StatistikEnum')) {
        $current_slug = \App\Enums\Statistik\StatistikEnum::slugFromKey($st) ?: (string) $st;
    } elseif (isset($st)) {
        $current_slug = (string) $st;
    } else {
        $current_slug = $this->uri->segment(2) ?: ($this->uri->segment(1) ?: '');
    }
}
$current_slug = str_replace('_', '-', (string) $current_slug);

$s_links = [
    [
        'target'  => 'statistikPenduduk',
        'label'   => 'Statistik Penduduk',
        'icon'    => 'fa-users',
        'color'   => 'from-blue-500 to-indigo-600',
        'badge'   => 'Kependudukan',
        'submenu' => $daftar_statistik['penduduk'] ?? [],
    ],
    [
        'target'  => 'statistikKeluarga',
        'label'   => 'Statistik Keluarga',
        'icon'    => 'fa-people-roof',
        'color'   => 'from-emerald-500 to-teal-600',
        'badge'   => 'Keluarga / KK',
        'submenu' => $daftar_statistik['keluarga'] ?? [],
    ],
    [
        'target'  => 'statistikBantuan',
        'label'   => 'Statistik Bantuan',
        'icon'    => 'fa-hand-holding-heart',
        'color'   => 'from-amber-500 to-rose-500',
        'badge'   => 'Sosial / Bansos',
        'submenu' => $daftar_statistik['bantuan'] ?? [],
    ],
    [
        'target'  => 'statistikLainnya',
        'label'   => 'Statistik Lainnya',
        'icon'    => 'fa-map-location-dot',
        'color'   => 'from-purple-500 to-pink-600',
        'badge'   => 'Wilayah & DPT',
        'submenu' => $daftar_statistik['lainnya'] ?? [],
    ],
];
?>

<div class="stat-sidebar-card bg-white/95 dark:bg-slate-900/90 backdrop-blur-2xl border border-slate-100 dark:border-slate-800 rounded-[2.5rem] p-5 md:p-6 shadow-2xl shadow-slate-200/50 dark:shadow-none lg:sticky lg:top-28 z-20 flex flex-col max-h-[calc(100vh-8.5rem)]">
    <!-- Header Sidebar -->
    <div class="flex items-center justify-between pb-5 mb-5 border-b border-slate-100 dark:border-slate-800 flex-shrink-0">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-2xl bg-gradient-to-tr from-brand-600 to-emerald-500 flex items-center justify-center text-white shadow-lg shadow-brand-600/30">
                <i class="fa-solid fa-chart-pie text-sm"></i>
            </div>
            <div>
                <h3 class="font-display font-black text-sm uppercase tracking-wider text-slate-900 dark:text-white">
                    Navigasi Data
                </h3>
                <p class="text-[11px] font-medium text-slate-400 dark:text-slate-500">
                    Kategori Statistik Desa
                </p>
            </div>
        </div>
        <span class="px-2.5 py-1 rounded-full bg-brand-50 dark:bg-brand-950/60 text-brand-600 dark:text-brand-400 text-[10px] font-black tracking-wider uppercase border border-brand-200 dark:border-brand-900/50">
            Live
        </span>
    </div>

    <!-- Accordion Kategori Statistik -->
    <div class="space-y-3 overflow-y-auto pr-1 stat-custom-scroll flex-1" id="statAccordion">
        <?php foreach ($s_links as $index => $cat): ?>
            <?php
            // Filter menu yang aktif saja
            $valid_submenus = [];
            foreach ($cat['submenu'] as $sub) {
                $stat_slug = in_array($cat['target'], ['statistikBantuan', 'statistikLainnya'])
                    ? str_replace('first/', '', (string) ($sub['url'] ?? ''))
                    : 'statistik/' . ($sub['key'] ?? '');

                $is_always_shown = ($cat['target'] === 'statistikLainnya') || in_array(($sub['key'] ?? ''), ['data-wilayah', 'perkembangan-penduduk', 'dpt']);

                if (
                    $is_always_shown ||
                    !isset($this->web_menu_model) ||
                    $this->web_menu_model->menu_aktif($stat_slug) ||
                    $this->web_menu_model->menu_aktif($sub['url'] ?? '') ||
                    $this->web_menu_model->menu_aktif('first/' . $stat_slug)
                ) {
                    $valid_submenus[] = $sub;
                }
            }

            if (empty($valid_submenus)) continue;

            // Periksa apakah accordion ini memuat link aktif
            $is_cat_active = false;
            foreach ($valid_submenus as $sub) {
                $sub_slug = str_replace('_', '-', (string) ($sub['slug'] ?? ''));
                $sub_url  = site_url($sub['url'] ?? '');
                $matches  = (!empty($current_slug) && $sub_slug === $current_slug) ||
                            (!empty($current_url) && $sub_url === $current_url);
                if (!$matches && empty($current_slug) && isset($st)) {
                    $matches = ((string)($sub['key'] ?? '') === (string)$st);
                }

                if ($matches) {
                    $is_cat_active = true;
                    break;
                }
            }

            // Fallback: Jika halaman default pertama kali dibuka, buka kategori pertama
            if (!$is_cat_active && $index === 0 && empty($current_slug)) {
                $is_cat_active = true;
            }
            ?>

            <div class="stat-accordion-group rounded-2xl border border-slate-100 dark:border-slate-800/80 bg-slate-50/50 dark:bg-slate-800/30 overflow-hidden transition-all duration-300">
                <!-- Accordion Header Button -->
                <button
                    type="button"
                    class="stat-accordion-btn w-full px-4 py-3.5 flex items-center justify-between text-left transition-colors duration-200 hover:bg-white dark:hover:bg-slate-800/80 <?= $is_cat_active ? 'bg-white dark:bg-slate-800/90 text-brand-600 dark:text-brand-400 font-extrabold shadow-sm' : 'text-slate-700 dark:text-slate-300 font-bold' ?>"
                    data-target="#cat-<?= $cat['target'] ?>"
                    aria-expanded="<?= $is_cat_active ? 'true' : 'false' ?>"
                >
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-xl bg-slate-100 dark:bg-slate-700/60 flex items-center justify-center text-xs <?= $is_cat_active ? 'text-brand-600 dark:text-brand-400 bg-brand-50 dark:bg-brand-900/40' : 'text-slate-500' ?>">
                            <i class="fa-solid <?= $cat['icon'] ?>"></i>
                        </div>
                        <div>
                            <span class="text-xs uppercase tracking-wide block leading-tight">
                                <?= $cat['label'] ?>
                            </span>
                            <span class="text-[10px] text-slate-400 dark:text-slate-500 font-normal">
                                <?= count($valid_submenus) ?> Indikator
                            </span>
                        </div>
                    </div>
                    <i class="fa-solid fa-chevron-down text-[11px] text-slate-400 transition-transform duration-300 <?= $is_cat_active ? 'rotate-180 text-brand-600 dark:text-brand-400' : '' ?>"></i>
                </button>

                <!-- Accordion Body -->
                <div
                    id="cat-<?= $cat['target'] ?>"
                    class="stat-accordion-collapse <?= $is_cat_active ? 'block' : 'hidden' ?> border-t border-slate-100 dark:border-slate-800/60 bg-white/70 dark:bg-slate-900/50 p-2 space-y-1"
                >
                    <ul class="space-y-1 max-h-72 overflow-y-auto pr-1 stat-custom-scroll">
                        <?php foreach ($valid_submenus as $sub): ?>
                            <?php
                            $sub_slug = str_replace('_', '-', (string) ($sub['slug'] ?? ''));
                            $sub_url  = site_url($sub['url'] ?? '');
                            $is_item_active = (!empty($current_slug) && $sub_slug === $current_slug) ||
                                              (!empty($current_url) && $sub_url === $current_url);
                            if (!$is_item_active && empty($current_slug) && isset($st)) {
                                $is_item_active = ((string)($sub['key'] ?? '') === (string)$st);
                            }
                            ?>
                            <li>
                                <a
                                    href="<?= site_url($sub['url']) ?>"
                                    class="group/item flex items-center justify-between px-3.5 py-2 rounded-xl text-xs transition-all duration-200 <?= $is_item_active ? 'bg-gradient-to-r from-brand-600 to-emerald-600 text-white font-extrabold shadow-md shadow-brand-600/30 translate-x-1' : 'text-slate-600 dark:text-slate-400 font-medium hover:bg-slate-100 dark:hover:bg-slate-800 hover:text-brand-600 dark:hover:text-brand-300' ?>"
                                >
                                    <div class="flex items-center gap-2.5 truncate">
                                        <span class="w-1.5 h-1.5 rounded-full <?= $is_item_active ? 'bg-white' : 'bg-slate-300 dark:bg-slate-600 group-hover/item:bg-brand-500' ?> flex-shrink-0 transition-colors"></span>
                                        <span class="truncate"><?= html_escape($sub['label']) ?></span>
                                    </div>
                                    <?php if ($is_item_active): ?>
                                        <i class="fa-solid fa-circle-check text-[11px] text-white/90 ml-2"></i>
                                    <?php else: ?>
                                        <i class="fa-solid fa-arrow-right text-[9px] opacity-0 group-hover/item:opacity-100 -translate-x-1 group-hover/item:translate-x-0 transition-all text-brand-600 dark:text-brand-400"></i>
                                    <?php endif; ?>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<style>
/* Custom Scrollbar for Accordion List */
.stat-custom-scroll::-webkit-scrollbar {
    width: 4px;
}
.stat-custom-scroll::-webkit-scrollbar-track {
    background: transparent;
}
.stat-custom-scroll::-webkit-scrollbar-thumb {
    background: rgba(148, 163, 184, 0.3);
    border-radius: 9999px;
}
.stat-custom-scroll::-webkit-scrollbar-thumb:hover {
    background: rgba(148, 163, 184, 0.6);
}
</style>

<script>
// Script Interaktif Accordion
document.addEventListener('DOMContentLoaded', function() {
    const accordions = document.querySelectorAll('.stat-accordion-btn');
    accordions.forEach(function(btn) {
        btn.addEventListener('click', function() {
            const targetId = this.getAttribute('data-target');
            const targetEl = document.querySelector(targetId);
            const icon = this.querySelector('.fa-chevron-down');
            const isExpanded = this.getAttribute('aria-expanded') === 'true';

            if (isExpanded) {
                targetEl.classList.add('hidden');
                this.setAttribute('aria-expanded', 'false');
                if (icon) icon.classList.remove('rotate-180', 'text-brand-600', 'dark:text-brand-400');
            } else {
                targetEl.classList.remove('hidden');
                this.setAttribute('aria-expanded', 'true');
                if (icon) icon.classList.add('rotate-180', 'text-brand-600', 'dark:text-brand-400');
            }
        });
    });
});
</script>
