<?php if(!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<!-- External Assets for Lapak -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css" />
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<div class="lapak-container pb-20">
    <!-- Header Section -->
    <div class="mb-12">
        <nav class="flex items-center gap-3 text-xs font-bold text-slate-400 uppercase tracking-widest mb-8">
            <a href="<?= site_url() ?>" class="hover:text-brand-600 transition-colors">Beranda</a>
            <i class="fa-solid fa-chevron-right text-[10px] opacity-40"></i>
            <span class="text-slate-600 dark:text-slate-300">Lapak Desa</span>
        </nav>

        <div class="flex flex-col md:flex-row md:items-end justify-between gap-8">
            <div>
                <div class="flex items-center gap-2 mb-4 text-brand-600 font-bold tracking-[0.2em] uppercase text-[10px]">
                    <span class="w-8 h-px bg-brand-600"></span>
                    Local Economy Hub
                </div>
                <h1 class="premium-h1 text-4xl md:text-6xl">
                    Lapak <span class="text-transparent bg-clip-text bg-gradient-to-r from-brand-600 to-emerald-500">Warga</span>.
                </h1>
            </div>

            <!-- Search & Filter Form -->
            <form action="<?= site_url('lapak') ?>" method="GET" class="flex flex-col sm:flex-row gap-4 w-full md:w-auto">
                <div class="relative group flex-1 md:min-w-[200px]">
                    <select name="id_kategori" onchange="this.form.submit()" class="w-full h-14 pl-6 pr-12 rounded-2xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 focus:border-brand-500 focus:ring-4 focus:ring-brand-500/10 transition-all appearance-none font-bold text-xs uppercase tracking-widest text-slate-700 dark:text-slate-300 cursor-pointer">
                        <option value="">Semua Kategori</option>
                        <?php foreach($kategori as $kat): ?>
                            <option value="<?= $kat->id ?>" <?= $id_kategori == $kat->id ? 'selected' : '' ?>><?= $kat->kategori ?></option>
                        <?php endforeach; ?>
                    </select>
                    <i class="fa-solid fa-chevron-down absolute right-5 top-1/2 -translate-y-1/2 text-slate-400 pointer-events-none text-[10px]"></i>
                </div>

                <div class="relative group flex-1 md:min-w-[250px]">
                    <input type="text" name="keyword" value="<?= $keyword ?>" placeholder="Cari produk unggulan..." class="w-full h-14 pl-12 pr-6 rounded-2xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 focus:border-brand-500 focus:ring-4 focus:ring-brand-500/10 transition-all font-medium text-sm text-slate-900 dark:text-white placeholder:text-slate-400">
                    <i class="fa-solid fa-magnifying-glass absolute left-5 top-1/2 -translate-y-1/2 text-slate-400 group-focus-within:text-brand-500 transition-colors"></i>
                </div>

                <button type="submit" class="h-14 px-8 bg-brand-600 text-white rounded-2xl font-black text-xs uppercase tracking-widest hover:bg-brand-900 hover:scale-105 transition-all shadow-xl shadow-brand-600/20 active:scale-95">
                    Filter
                </button>
            </form>
        </div>
    </div>

    <!-- Product Grid -->
    <?php if($produk): ?>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 xl:grid-cols-3 gap-10">
            <?php foreach($produk as $item): ?>
                <?php 
                    $fotos = json_decode($item->foto);
                    $harga_awal = $item->harga;
                    $potongan = $item->potongan;
                    $harga_final = ($item->tipe_potongan == 1) ? $harga_awal - ($harga_awal * $potongan / 100) : $harga_awal - $potongan;
                    $diskon_badge = ($item->tipe_potongan == 1 && $potongan > 0) ? $potongan.'%' : (($item->tipe_potongan == 2 && $potongan > 0) ? 'SALE' : '');
                ?>
                <div class="product-card group relative bg-white dark:bg-slate-900 rounded-[3rem] border border-slate-100 dark:border-slate-800 shadow-2xl shadow-slate-200/40 dark:shadow-none overflow-hidden transition-all duration-700 hover:-translate-y-4 hover:shadow-[0_50px_100px_-20px_rgba(59,130,246,0.2)] flex flex-col">
                    
                    <!-- [PREMIUM IMAGE CAROUSEL] -->
                    <div class="relative overflow-hidden aspect-[4/3] bg-slate-50 dark:bg-slate-950/50">
                        <?php if($diskon_badge): ?>
                            <div class="absolute top-6 left-6 z-20 px-5 py-2 rounded-2xl bg-accent text-white font-black text-[10px] tracking-[0.2em] uppercase shadow-xl shadow-accent/40 ring-4 ring-white/20 dark:ring-black/20">
                                <?= $diskon_badge ?> OFF
                            </div>
                        <?php endif; ?>

                        <div class="product-carousel owl-carousel h-full">
                            <?php if($fotos): ?>
                                <?php foreach($fotos as $f): ?>
                                    <div class="item h-[320px]">
                                        <img src="<?= base_url(LOKASI_PRODUK . $f) ?>" class="w-full h-full object-cover transition-transform duration-1000 group-hover:scale-110" alt="<?= html_escape($item->nama) ?>" onerror="this.src='<?= base_url('assets/images/opensid.png') ?>'">
                                    </div>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <div class="item h-[320px] flex flex-col items-center justify-center bg-slate-100 dark:bg-slate-800/40">
                                    <div class="w-20 h-20 rounded-full bg-white dark:bg-slate-900 shadow-xl flex items-center justify-center text-slate-200 dark:text-slate-700 mb-4">
                                        <i class="fa-solid fa-box-archive text-3xl animate-pulse"></i>
                                    </div>
                                    <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">No Visual Data</span>
                                </div>
                            <?php endif; ?>
                        </div>

                        <!-- Gradient Bottom Fade -->
                        <div class="absolute inset-x-0 bottom-0 h-24 bg-gradient-to-t from-white dark:from-slate-900 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                    </div>

                    <!-- [CARD CONTENT] -->
                    <div class="p-10 flex-1 flex flex-col pt-0 -mt-6 relative z-10">
                        <!-- Category Badge -->
                        <div class="inline-flex mb-4">
                            <span class="premium-badge bg-white dark:bg-slate-800 shadow-lg border border-slate-100 dark:border-slate-700 text-brand-600 dark:text-brand-400">
                                <?= $item->kategori ?>
                            </span>
                        </div>

                        <!-- Title -->
                        <h3 class="font-display font-[900] text-2xl text-slate-900 dark:text-white leading-none tracking-tight group-hover:text-brand-600 transition-colors mb-6">
                            <?= $item->nama ?>
                        </h3>

                        <!-- Pricing Shell -->
                        <div class="bg-slate-50 dark:bg-slate-800/40 rounded-[2rem] p-6 mb-8 border border-slate-100 dark:border-slate-800/60 group-hover:bg-brand-50/50 dark:group-hover:bg-brand-900/10 transition-colors">
                            <div class="flex items-end justify-between gap-4">
                                <div class="flex flex-col">
                                    <?php if($harga_final < $harga_awal): ?>
                                        <span class="text-[10px] text-slate-400 line-through font-bold mb-1 italic"><?= rupiah($harga_awal) ?></span>
                                    <?php endif; ?>
                                    <span class="text-3xl font-display font-black text-slate-900 dark:text-white leading-none"><?= rupiah($harga_final) ?></span>
                                    <span class="text-[9px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest mt-3">Satuan: <?= $item->satuan ?></span>
                                </div>
                                <button type="button" 
                                    class="w-14 h-14 rounded-2xl bg-white dark:bg-slate-800 shadow-xl border border-slate-50 dark:border-slate-700 text-slate-400 hover:text-brand-600 hover:scale-110 hover:-rotate-6 transition-all flex items-center justify-center flex-shrink-0"
                                    onclick="showMapModal('<?= $item->lat ?>', '<?= $item->lng ?>', '<?= addslashes($item->pelapak) ?>', '<?= addslashes($item->nama) ?>')"
                                    title="Peta Lokasi">
                                    <i class="fa-solid fa-map-location-dot text-xl"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Merchant & Action -->
                        <div class="mt-auto space-y-5">
                            <div class="flex items-center gap-4 px-2">
                                <div class="relative">
                                    <div class="w-10 h-10 rounded-2xl bg-gradient-to-br from-brand-600 to-accent flex items-center justify-center text-white text-xs font-black shadow-lg shadow-brand-600/30">
                                        <?= strtoupper(substr(trim($item->pelapak), 0, 1)) ?>
                                    </div>
                                    <div class="absolute -bottom-1 -right-1 w-5 h-5 rounded-full bg-white dark:bg-slate-900 flex items-center justify-center border-2 border-slate-50 dark:border-slate-800">
                                        <i class="fa-solid fa-certificate text-brand-500 text-[10px]"></i>
                                    </div>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-[11px] font-black text-slate-900 dark:text-white truncate uppercase tracking-widest leading-none mb-1">
                                        <?= $item->pelapak ?>
                                    </p>
                                    <span class="text-[9px] font-extrabold text-slate-400 uppercase tracking-widest opacity-60">Authorized Seller</span>
                                </div>
                            </div>

                            <?php 
                                $phone = preg_replace('/[^0-9]/', '', $item->telepon);
                                if (strpos($phone, '0') === 0) $phone = '62' . substr($phone, 1);
                                if (empty($phone)) $phone = '62';
                            ?>
                            <a href="https://api.whatsapp.com/send?phone=<?= $phone ?>&text=Halo%20<?= urlencode($item->pelapak) ?>,%20saya%20tertarik%20dengan%20produk%20<?= urlencode($item->nama) ?>%20di%20Lapak%20Desa." 
                               target="_blank"
                               rel="noopener noreferrer"
                               class="flex items-center justify-center gap-4 w-full py-5 bg-slate-900 dark:bg-white text-white dark:text-slate-900 rounded-3xl font-black text-[11px] uppercase tracking-[0.3em] shadow-2xl shadow-slate-900/10 hover:bg-brand-600 hover:dark:bg-brand-600 hover:text-white hover:scale-[1.03] transition-all active:scale-95 group/wa">
                                <i class="fa-brands fa-whatsapp text-xl group-hover/wa:rotate-[15deg] transition-transform"></i>
                                Pesan Produk
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- Pagination -->
        <div class="mt-24">
            <?php $this->load->view("{$folder_themes}/commons/paging.php", ['paging' => $paging, 'paging_page' => 'lapak']) ?>
        </div>

    <?php else: ?>
        <div class="py-32 text-center bg-white dark:bg-slate-900 rounded-[4rem] border border-slate-100 dark:border-slate-800 shadow-2xl shadow-brand-900/5">
            <div class="w-32 h-32 rounded-full bg-slate-50 dark:bg-slate-800 flex items-center justify-center mx-auto mb-8 text-slate-200 dark:text-slate-700">
                <i class="fa-solid fa-store-slash text-6xl"></i>
            </div>
            <h3 class="font-display font-[800] text-2xl text-slate-900 dark:text-white mb-2 tracking-tight">Belum ada produk.</h3>
            <p class="text-slate-500 font-medium">Maaf, tidak ada produk yang sesuai dengan pencarian Anda saat ini.</p>
        </div>
    <?php endif; ?>
</div>

<!-- Map Modal -->
<div id="modalLokasi" class="fixed inset-0 z-[100] hidden">
    <!-- Backdrop -->
    <div class="absolute inset-0 bg-slate-950/80 backdrop-blur-sm" onclick="closeMapModal()"></div>
    
    <!-- Modal Content -->
    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[90%] md:w-[600px] bg-white dark:bg-slate-900 rounded-[3rem] shadow-2xl overflow-hidden border border-slate-200 dark:border-slate-800">
        <div class="p-8 border-b border-slate-100 dark:border-slate-800 flex items-center justify-between">
            <div>
                <h4 class="font-display font-black text-xl text-slate-900 dark:text-white tracking-tight leading-none" id="modalTitle">Lokasi Penjual</h4>
                <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mt-2" id="modalSubtitle">Pelapak Terverifikasi</p>
            </div>
            <button onclick="closeMapModal()" class="w-10 h-10 rounded-xl bg-slate-50 dark:bg-slate-800 text-slate-400 hover:text-red-500 transition-all">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>
        <div class="p-4">
            <div id="map" class="w-full h-[400px] rounded-[2rem] border-4 border-slate-100 dark:border-slate-800"></div>
        </div>
    </div>
</div>

<script>
    var map;
    var marker;

    $(document).ready(function(){
        $('.product-carousel').owlCarousel({
            items: 1,
            loop: true,
            margin: 0,
            nav: false,
            dots: true,
            autoplay: true,
            autoplayTimeout: 4000,
            smartSpeed: 800,
            animateIn: 'fadeIn',
            animateOut: 'fadeOut'
        });
    });

    function showMapModal(lat, lng, pelapak, produk) {
        if(!lat || !lng || lat == ' ' || lng == ' ') {
            alert('Lokasi pelapak belum ditentukan.');
            return;
        }

        $('#modalTitle').text('Lokasi ' + pelapak);
        $('#modalSubtitle').text('Penjual Produk: ' + produk);
        $('#modalLokasi').removeClass('hidden').addClass('flex');

        setTimeout(function(){
            if (map != undefined) { map.remove(); }
            map = L.map('map').setView([lat, lng], 15);
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map);
            
            var icon = L.divIcon({
                html: '<div class="w-8 h-8 bg-brand-600 rounded-full border-4 border-white shadow-xl flex items-center justify-center text-white"><i class="fa-solid fa-shop"></i></div>',
                className: '',
                iconSize: [32, 32]
            });

            marker = L.marker([lat, lng], {icon: icon}).addTo(map);
            marker.bindPopup('<div class="font-display font-bold text-slate-900">' + pelapak + '</div>').openPopup();
            
            map.invalidateSize();
        }, 100);
    }

    function closeMapModal() {
        $('#modalLokasi').addClass('hidden').removeClass('flex');
    }
</script>

<style>
    .owl-dots {
        position: absolute;
        bottom: 15px;
        width: 100%;
        text-align: center;
        z-index: 30;
    }
    .owl-dot span {
        width: 8px !important;
        height: 8px !important;
        margin: 5px 4px !important;
        background: rgba(255,255,255,0.4) !important;
        transition: all 0.3s ease !important;
    }
    .owl-dot.active span {
        background: #fff !important;
        width: 24px !important;
        border-radius: 4px !important;
    }
    .leaflet-popup-content-wrapper { 
        border-radius: 1rem; 
        padding: 0.5rem;
        font-family: 'Inter', sans-serif;
    }
    .leaflet-popup-tip-container { display: none; }
</style>
