<?php if(!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <?php $this->load->view("$folder_themes/commons/meta.php"); ?>
    
    <!-- Assets Peta Leaflet & Plugins -->
    <link rel="preconnect" href="https://a.tile.openstreetmap.org">
    <link rel="preconnect" href="https://b.tile.openstreetmap.org">
    <link rel="preconnect" href="https://c.tile.openstreetmap.org">
    <link rel="dns-prefetch" href="https://a.tile.openstreetmap.org">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.7.1/leaflet.css" fetchpriority="high">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet.markercluster/1.4.1/MarkerCluster.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet.markercluster/1.4.1/MarkerCluster.Default.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet.fullscreen/1.6.0/Control.FullScreen.css">
    
    <!-- Assets Peta Leaflet & Plugins -->
    
    <style>
        #map { 
            width: 100% !important; 
            height: 700px !important; 
            border-radius: 2.5rem !important;
            z-index: 0;
            background: #f8fafc;
        }
        .leaflet-container {
            font-family: 'Inter', sans-serif !important;
        }
        .leaflet-popup-content-wrapper {
            border-radius: 2rem !important;
            padding: 0.75rem !important;
            box-shadow: 0 25px 50px -12px rgb(0 0 0 / 0.1) !important;
            border: 1px solid #f1f5f9;
        }
        .dark .leaflet-popup-content-wrapper {
            background: #0f172a;
            color: white;
            border-color: #1e293b;
        }
        .leaflet-popup-tip {
            border-top-color: white !important;
        }
        .dark .leaflet-popup-tip {
            background: #0f172a !important;
        }
        .leaflet-bar {
            border-radius: 1rem !important;
            border: none !important;
            box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1) !important;
            overflow: hidden;
        }
        .leaflet-bar a {
            background-color: white !important;
            color: #475569 !important;
            border: 1px solid #f1f5f9 !important;
        }
        .dark .leaflet-bar a {
            background-color: #1e293b !important;
            color: #f1f5f9 !important;
            border-color: #334155 !important;
        }
        .leaflet-control-layers {
            border-radius: 1.5rem !important;
            padding: 0 !important;
            border: 1px solid rgba(241, 245, 249, 0.8) !important;
            box-shadow: 0 10px 15px -3px rgb(0 0 0 / 0.1) !important;
            backdrop-filter: blur(12px);
            background: rgba(255, 255, 255, 0.9) !important;
            margin: 1.5rem !important;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            overflow: hidden;
        }
        /* Collapsed State (The Icon) */
        .leaflet-control-layers:not(.leaflet-control-layers-expanded) {
            width: 48px !important;
            height: 48px !important;
            border-radius: 1.25rem !important;
        }
        .leaflet-control-layers-toggle {
            width: 48px !important;
            height: 48px !important;
            background-size: 20px 20px !important;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        /* Expanded State */
        .leaflet-control-layers-expanded {
            padding: 1.25rem !important;
            width: 260px !important;
        }
        @media (max-width: 768px) {
            .leaflet-control-layers { margin: 1rem !important; }
            .leaflet-control-layers-expanded {
                width: auto !important;
                min-width: 220px;
                max-width: calc(100vw - 4rem);
            }
        }
        .dark .leaflet-control-layers {
            background: rgba(15, 23, 42, 0.9) !important;
            color: white !important;
            border-color: rgba(51, 65, 85, 0.8) !important;
        }
        .leaflet-control-layers-overlays::before {
            content: 'LAPISAN DATA';
            display: block;
            font-size: 10px;
            font-weight: 900;
            color: #2563eb;
            margin-bottom: 0.75rem;
            letter-spacing: 0.15em;
            padding-bottom: 0.5rem;
            border-bottom: 1px solid #e2e8f0;
        }
        .dark .leaflet-control-layers-overlays::before {
            color: #3b82f6;
            border-bottom-color: #334155;
        }
        .leaflet-control-layers-base::before {
            content: 'GAYA PETA';
            display: block;
            font-size: 10px;
            font-weight: 900;
            color: #64748b;
            margin-bottom: 0.75rem;
            letter-spacing: 0.15em;
            margin-top: 0.5rem;
        }
        .leaflet-control-layers-selector {
            margin-right: 10px !important;
            accent-color: #2563eb;
        }
        .leaflet-control-layers label {
            display: flex !important;
            align-items: center;
            padding: 0.25rem 0;
            cursor: pointer;
            font-size: 12px;
            font-weight: 600;
            color: #475569;
            transition: color 0.2s;
        }
        .leaflet-control-layers label:hover {
            color: #2563eb;
        }
        .dark .leaflet-control-layers label {
            color: #cbd5e1;
        }
        .dark label:hover {
            color: #60a5fa;
        }
        /* Custom Button for Statistics in Popup */
        .btn-stat-map {
            display: block;
            width: 100%;
            padding: 0.5rem 1rem;
            margin-bottom: 0.25rem;
            background: #f1f5f9;
            color: #475569;
            border-radius: 0.75rem;
            font-size: 11px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            transition: all 0.3s;
        }
        .btn-stat-map:hover {
            background: #2563eb;
            color: white;
        }
        .dark .btn-stat-map:hover {
            background: #3b82f6;
            color: white;
        }
        .leaflet-popup-content {
            margin: 10px !important;
            width: auto !important;
        }
        @keyframes spinner-grow {
            0% { transform: scale(0); opacity: 0; }
            50% { opacity: 1; }
            100% { transform: scale(1); opacity: 0; }
        }
        .map-loader {
            animation: spinner-grow 0.75s linear infinite;
        }
        /* Premium Modal Table Styling */
        #modalContent table {
            width: 100% !important;
            border-collapse: separate !important;
            border-spacing: 0 !important;
            font-family: 'Inter', sans-serif !important;
            border: 1px solid #e2e8f0 !important;
            border-radius: 1.5rem !important;
            overflow: hidden !important;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05) !important;
        }
        .dark #modalContent table {
            border-color: #334155 !important;
            box-shadow: none !important;
        }
        #modalContent th {
            background: #f8fafc !important;
            color: #1e293b !important;
            font-weight: 800 !important;
            text-transform: uppercase !important;
            letter-spacing: 0.1em !important;
            padding: 1.25rem 1rem !important;
            border-bottom: 2px solid #e2e8f0 !important;
            font-size: 11px !important;
        }
        .dark #modalContent th {
            background: #1e293b !important;
            color: #f1f5f9 !important;
            border-bottom-color: #334155 !important;
        }
        #modalContent td {
            padding: 1rem !important;
            border-bottom: 1px solid #f1f5f9 !important;
            color: #475569 !important;
            font-weight: 500 !important;
            font-size: 13px !important;
        }
        .dark #modalContent td {
            border-bottom-color: #1e293b !important;
            color: #cbd5e1 !important;
        }
        #modalContent tr:last-child td {
            border-bottom: none !important;
        }
        #modalContent tr:hover td {
            background: #f8fafc !important;
        }
        .dark #modalContent tr:hover td {
            background: #1e293b/50 !important;
        }
        /* Keep numeric cells consistent with the rest of the table */
        #modalContent td:nth-child(n+3) {
            font-family: inherit !important;
            font-weight: 500 !important;
            color: #475569 !important;
        }
        .dark #modalContent td:nth-child(n+3) {
            color: #cbd5e1 !important;
        }
        /* Keep map controls below overlays, but allow modal statistics to sit above navbar */
        header {
            z-index: 1000 !important;
        }
        
        /* Hide Chart and its buttons as per user request */
        #chart, #modalContent center { display: none !important; }
    </style>
</head>
<body class="bg-white dark:bg-slate-950 font-sans text-slate-900 dark:text-slate-100 selection:bg-brand-100 selection:text-brand-900 overflow-x-hidden transition-colors duration-500">
    
    <!-- Navbar -->
    <?php $this->load->view("$folder_themes/commons/header.php"); ?>

    <div class="h-24 md:h-32"></div>

    <main class="min-h-screen animate-premium">
        <section class="py-12 md:py-20 bg-slate-50/50 dark:bg-slate-900/10">
            <div class="container mx-auto px-4">
                <div class="max-w-7xl mx-auto">
                    
                    <!-- Breadcrumb -->
                    <nav class="flex items-center gap-3 text-xs font-bold text-slate-600 dark:text-slate-400 uppercase tracking-widest mb-10">
                        <a href="<?= site_url() ?>" class="hover:text-brand-600 transition-colors">Beranda</a>
                        <i class="fa-solid fa-chevron-right text-[10px] opacity-40"></i>
                        <span class="text-slate-600 dark:text-slate-400">Peta Geospasial</span>
                    </nav>

                    <!-- Header Section -->
                    <div class="mb-14 flex flex-col md:flex-row md:items-end justify-between gap-8 relative">
                        <div class="max-w-3xl">
                            <div class="flex items-center gap-3 mb-5">
                                <span class="w-12 h-1 bg-brand-600 rounded-full"></span>
                                <span class="text-brand-600 font-black tracking-[0.3em] uppercase text-[10px]">Digital Mapping System</span>
                            </div>
                            <h1 class="premium-h1 text-4xl md:text-6xl mb-4">
                                Peta <span class="text-transparent bg-clip-text bg-gradient-to-r from-brand-600 to-emerald-500">Kearifan Lokal</span>.
                            </h1>
                            <p class="premium-p text-lg max-w-xl">Sistem geospasial terintegrasi untuk visualisasi pembangunan dan demografi wilayah.</p>
                        </div>
                        <div class="hidden md:flex flex-col items-end text-right px-10 py-8 rounded-[2.5rem] bg-white dark:bg-slate-800 shadow-xl shadow-slate-200/40 dark:shadow-none border border-slate-100 dark:border-slate-700 group transition-all hover:bg-slate-50 dark:hover:bg-slate-700/50">
                            <span class="text-[10px] font-black text-brand-600 dark:text-brand-400 uppercase tracking-[0.3em] mb-2">Unit Administrasi</span>
                            <span class="text-3xl font-display font-black text-slate-900 dark:text-white"><?= $desa['nama_desa'] ?></span>
                        </div>
                    </div>

                    <!-- Map Container Area -->
                    <div class="relative group">
                        <!-- Shadow Decor -->
                        <div class="absolute -inset-4 bg-gradient-to-r from-brand-600/10 to-emerald-500/10 blur-3xl opacity-50 group-hover:opacity-100 transition-opacity duration-700"></div>
                        
                        <div class="bg-white dark:bg-slate-800 p-2 md:p-4 rounded-[4rem] shadow-2xl shadow-slate-200/40 dark:shadow-none border border-slate-50 dark:border-slate-700 relative z-10">
                            
                            <!-- Leaflet Map Container -->
                            <div id="map" class="relative overflow-hidden group/map shadow-inner">
                                <!-- Main Loader -->
                                <div id="map-loader" class="absolute inset-x-0 bottom-0 top-0 bg-slate-50 dark:bg-slate-900 z-[1000] flex flex-col items-center justify-center transition-all duration-700">
                                    <div class="w-16 h-16 rounded-full bg-brand-500 map-loader"></div>
                                    <p class="mt-4 text-[10px] font-black text-slate-400 uppercase tracking-[0.3em]">Menginisialisasi Peta...</p>
                                </div>
                                
                                <!-- Invisible Popup Templates -->
                                <!-- Invisible Popup Templates -->
                                <div id="isi_popup" style="display: none;"></div>
                                <div id="isi_popup_dusun" style="display: none;"></div>
                                <div id="isi_popup_rw" style="display: none;"></div>
                                <div id="isi_popup_rt" style="display: none;"></div>
                            </div>
                        </div>
                    </div>

                    <!-- Features Grid -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mt-20">
                        <?php 
                        $features = [
                            ['icon' => 'fa-satellite-dish', 'title' => 'Geospasial Akurat', 'desc' => 'Sistem informasi geografis yang terintegrasi langsung dengan database kependudukan desa.', 'color' => 'brand'],
                            ['icon' => 'fa-layer-group', 'title' => 'Layer Interaktif', 'desc' => 'Pilih berbagai jenis tampilan peta mulai dari topografi, jalan, hingga citra satelit terbaru.', 'color' => 'emerald'],
                            ['icon' => 'fa-magnifying-glass-location', 'title' => 'Titik Lokasi', 'desc' => 'Temukan lokasi fasilitas publik, kantor pelayanan, dan batas wilayah RW/RT dengan mudah.', 'color' => 'slate']
                        ];
                        foreach($features as $f): ?>
                        <div class="bg-white dark:bg-slate-800/40 p-12 rounded-[3.5rem] border border-slate-100 dark:border-slate-800 shadow-xl shadow-slate-200/50 dark:shadow-none flex flex-col items-start transition-all duration-500 hover:shadow-2xl hover:-translate-y-2 group">
                            <div class="w-16 h-16 rounded-2xl bg-<?= $f['color'] ?>-50 dark:bg-<?= $f['color'] ?>-900/30 text-<?= $f['color'] ?>-600 dark:text-<?= $f['color'] ?>-400 flex items-center justify-center text-2xl mb-8 group-hover:bg-<?= $f['color'] ?>-600 group-hover:text-white transition-all">
                                <i class="fa-solid <?= $f['icon'] ?>"></i>
                            </div>
                            <h2 class="font-display font-black text-xl text-slate-900 dark:text-white mb-3 tracking-tight"><?= $f['title'] ?></h2>
                            <p class="text-slate-600 dark:text-slate-400 text-sm font-medium leading-relaxed"><?= $f['desc'] ?></p>
                        </div>
                        <?php endforeach; ?>
                    </div>

                    <!-- Support Banner -->
                    <div class="mt-20 p-12 md:p-16 rounded-[4.5rem] bg-slate-900 dark:bg-slate-800 text-white relative overflow-hidden flex flex-col md:flex-row items-center justify-between gap-10 group shadow-2xl">
                        <div class="absolute right-0 bottom-0 w-[500px] h-[500px] bg-brand-600/10 rounded-full blur-[120px] transition-transform duration-1000 group-hover:scale-110"></div>
                        <div class="relative z-10">
                            <h2 class="font-display font-black text-3xl mb-4 leading-none text-white">Butuh Bantuan Navigasi?</h2>
                            <p class="text-slate-200 font-medium max-w-lg">
                                Jika Anda mengalami kendala saat memuat peta, pastikan koneksi internet stabil dan browser Anda mendukung fitur JavaScript.
                            </p>
                        </div>
                        <div class="flex gap-4 relative z-10 w-full md:w-auto">
                            <a href="<?= site_url() ?>" class="flex-1 md:flex-none px-10 py-5 bg-white text-slate-900 font-black rounded-3xl hover:bg-brand-50 transition-all uppercase tracking-widest text-[10px] shadow-xl text-center">
                                Hubungi Admin
                            </a>
                        </div>
                    </div>

                </div>
            </div>
        </section>
    </main>

    <!-- Modal Area for Charts (Moved to root for layout stability) -->
    <div id="modalSedang" class="fixed inset-0 z-[2000001] hidden overflow-hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="fixed inset-0 bg-slate-900/60 transition-opacity" aria-hidden="true" onclick="closeModal()"></div>
            
            <div class="relative bg-white dark:bg-slate-800 rounded-[2.5rem] text-left overflow-hidden shadow-2xl transform transition-all w-full max-w-4xl border border-slate-100 dark:border-slate-700 flex flex-col max-h-[90vh]">
                <div class="px-8 py-6 border-b border-slate-100 dark:border-slate-700 flex justify-between items-center bg-white dark:bg-slate-800 z-10">
                    <h3 class="premium-h1 text-xl" id="modalTitle">Statistik Wilayah</h3>
                    <button onclick="closeModal()" class="w-12 h-12 flex items-center justify-center rounded-2xl bg-slate-50 dark:bg-slate-700 text-slate-400 hover:text-rose-500 hover:rotate-90 transition-all duration-300">
                        <i class="fa-solid fa-xmark text-lg"></i>
                    </button>
                </div>
                <div class="flex-1 overflow-y-auto custom-scrollbar p-10 bg-slate-50/50 dark:bg-slate-950/20">
                    <div id="modalContent" class="fetched-data min-h-[400px]">
                        <!-- Content loaded via AJAX -->
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts Area -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.7.1/leaflet.js" fetchpriority="high"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet.markercluster/1.4.1/leaflet.markercluster.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet.fullscreen/1.6.0/Control.FullScreen.js"></script>
    <script>
        // Data dari Controller OpenSID
        const configMap = {
            center: [<?= $desa['lat'] ?? '-1.054' ?>, <?= $desa['lng'] ?? '116.71' ?>],
            zoom: <?= $desa['zoom'] ?? 10 ?>,
            apiUrl: '<?= site_url("internal_api/peta") ?>',
            base_url: '<?= base_url() ?>',
            sebutan_desa: '<?= ucwords($this->setting->sebutan_desa) ?>',
            nama_desa: '<?= $desa["nama_desa"] ?>'
        };

        (function() {
            window.onload = function() {
                // Sembunyikan spinner setelah memuat peta
                const hideLoader = () => {
                    const loader = document.getElementById('map-loader');
                    if(loader) {
                        loader.classList.add('opacity-0', 'pointer-events-none');
                        setTimeout(() => loader.remove(), 700);
                    }
                };

                // Inisialisasi Peta
                const map = L.map('map', {
                    fullscreenControl: true,
                    scrollWheelZoom: false
                }).setView(configMap.center, configMap.zoom);

                // Inisialisasi Layer Groups untuk Overlay Menu
                const layerGroups = {
                    wilayahDesa: L.layerGroup(),
                    wilayahDusun: L.layerGroup(),
                    wilayahRW: L.layerGroup(),
                    wilayahRT: L.layerGroup(),
                    lokasiFasilitas: L.layerGroup(),
                    pembangunanDesa: L.layerGroup(),
                    garisInfrastruktur: L.layerGroup(),
                    areaSpesial: L.layerGroup(),
                    letterCDesa: L.layerGroup()
                };

                // Base Layers
                const OSM = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '&copy; OpenStreetMap'
                }).addTo(map);

                const GoogleSatellite = L.tileLayer('https://{s}.google.com/vt/lyrs=s&x={x}&y={y}&z={z}', {
                    maxZoom: 20,
                    subdomains:['mt0','mt1','mt2','mt3'],
                    attribution: 'Google Satellite'
                });

                // Inisialisasi Peta
                const mapLayers = {
                    "Peta Standar (OSM)": OSM,
                    "Citra Satelit": GoogleSatellite
                };

                const mapOverlays = {
                    "Wilayah Desa": layerGroups.wilayahDesa,
                    "Wilayah Dusun": layerGroups.wilayahDusun,
                    "Wilayah RW": layerGroups.wilayahRW,
                    "Wilayah RT": layerGroups.wilayahRT,
                    "Pembangunan (Titik)": layerGroups.pembangunanDesa,
                    "Fasilitas (Titik)": layerGroups.lokasiFasilitas,
                    "Infrastruktur (Garis)": layerGroups.garisInfrastruktur,
                    "Area Desa (Polygon)": layerGroups.areaSpesial,
                    "Letter C-Desa (Persil)": layerGroups.letterCDesa
                };

                L.control.layers(mapLayers, mapOverlays, {
                    collapsed: true,
                    position: 'topright'
                }).addTo(map);

                // Data yang dipasok langsung dari Controller (Inject data sebagai pengganti Internal API)
                const response = {
                    data: [{
                        attributes: {
                            get_desa: { path: <?= json_encode($desa['path'] ?? null) ?> },
                            dusun_gis: <?= json_encode($dusun_gis ?? []) ?>,
                            rw_gis: <?= json_encode($rw_gis ?? []) ?>,
                            rt_gis: <?= json_encode($rt_gis ?? []) ?>,
                            list_ref: <?= json_encode($list_ref ?? []) ?>,
                            list_bantuan: <?= json_encode($list_bantuan ?? []) ?>,
                            lokasi: <?= json_encode($lokasi ?? []) ?>,
                            garis: <?= json_encode($garis ?? []) ?>,
                            area: <?= json_encode($area ?? []) ?>,
                            pembangunan: <?= json_encode($lokasi_pembangunan ?? []) ?>,
                            persil: <?= json_encode($persil ?? []) ?>
                        }
                    }]
                };

                // Helper Functions for Popup
                const encodeLabel = (str) => str.replace(/\s+/g, '_');
                
                window.openChartModal = function(url, title) {
                    const modal = document.getElementById('modalSedang');
                    const modalTitle = document.getElementById('modalTitle');
                    const modalContent = document.getElementById('modalContent');
                    
                    // Tutup popup leaflet agar tidak menghalangi
                    map.closePopup();
                    
                    modalTitle.innerText = title;
                    modalContent.innerHTML = '<div class="flex items-center justify-center p-20 flex-col gap-4 text-slate-300"><div class="w-12 h-12 border-4 border-slate-100 border-t-brand-600 rounded-full animate-spin"></div><span class="text-[10px] font-black uppercase tracking-[0.2em]">Mengunduh Data...</span></div>';
                    modal.classList.remove('hidden');
                    document.body.style.overflow = 'hidden';
                    
                    $.get(url, function(html) {
                        const parser = new DOMParser();
                        const doc = parser.parseFromString(html, 'text/html');

                        // Buang elemen yang bisa mengubah layout global halaman peta.
                        doc.querySelectorAll('script, style, link, meta, base, noscript').forEach((node) => node.remove());

                        // Ambil isi yang paling relevan dari halaman statistik.
                        const preferredContent = doc.querySelector('.stat-table-box, .list-frame, table, .table-responsive, body');
                        const contentSource = preferredContent ? preferredContent.cloneNode(true) : doc.body.cloneNode(true);

                        // Hilangkan elemen yang tidak dibutuhkan di modal.
                        contentSource.querySelectorAll('script, style, link, meta, base, noscript, center').forEach((node) => node.remove());

                        // Jadikan teks untuk anchor statistik, agar modal tidak memicu navigasi/aksi ganda.
                        contentSource.querySelectorAll('a').forEach((anchor) => {
                            const replacement = document.createElement('span');
                            replacement.innerHTML = anchor.innerHTML;
                            replacement.className = anchor.className;
                            anchor.replaceWith(replacement);
                        });

                        modalContent.innerHTML = '';

                        const contentWrapper = document.createElement('div');
                        contentWrapper.className = 'overflow-x-auto custom-scrollbar';
                        contentWrapper.appendChild(contentSource);
                        modalContent.appendChild(contentWrapper);
                    }).fail(function() {
                        modalContent.innerHTML = '<div class="flex items-center justify-center p-20 flex-col gap-4 text-rose-400"><i class="fa-solid fa-circle-exclamation text-3xl"></i><span class="text-[10px] font-black uppercase tracking-[0.2em]">Gagal memuat data statistik</span></div>';
                    });
                };

                window.closeModal = function() {
                    const modal = document.getElementById('modalSedang');
                    if (modal) modal.classList.add('hidden');
                    document.body.style.overflow = '';
                };

                // Proses data yang sudah di-inject
                if(response.data && response.data.length > 0) {
                    const attributes = response.data[0].attributes;
                    
                    // Handler Polygon Wilayah Desa
                    if(attributes.get_desa && attributes.get_desa.path) {
                        try {
                            const pathDesa = JSON.parse(attributes.get_desa.path);
                            const polyDesa = L.polygon(pathDesa, {
                                color: '#2563eb', weight: 4, fillOpacity: 0.1, dashArray: '8, 12'
                            }).addTo(layerGroups.wilayahDesa);
                            
                            let popupDesa = `
                                <div class="p-3 min-w-[260px]">
                                    <h6 class="font-black text-slate-900 dark:text-white mb-4 uppercase tracking-wider border-b border-slate-100 dark:border-slate-800 pb-3 text-center">Wilayah ${configMap.nama_desa}</h6>
                                    <div class="space-y-3">
                                        <div>
                                            <button onclick="this.nextElementSibling.classList.toggle('hidden')" class="w-full flex items-center justify-between px-5 py-3 bg-slate-50 dark:bg-slate-800 rounded-2xl text-[11px] font-black text-slate-700 dark:text-slate-200 hover:bg-brand-50 hover:text-brand-600 transition-all group">
                                                <span>STATISTIK PENDUDUK</span>
                                                <i class="fa-solid fa-chevron-down opacity-30 group-hover:opacity-100 transition-opacity"></i>
                                            </button>
                                            <div class="hidden mt-2 grid grid-cols-1 gap-1 p-2 bg-white dark:bg-slate-900 rounded-2xl border border-slate-100 dark:border-slate-800 shadow-sm max-h-48 overflow-y-auto custom-scrollbar">
                                                ${Object.keys(attributes.list_ref).map(key => `
                                                    <a href="javascript:void(0)" onclick="openChartModal('<?= site_url('statistik_web/chart_gis_desa') ?>/${key}/${encodeLabel(configMap.nama_desa)}', 'Statistik ${attributes.list_ref[key].replace(/'/g, "\\'")}')" class="text-[10px] py-2 px-4 hover:bg-brand-50 hover:text-brand-600 rounded-xl transition-all font-bold text-slate-500 dark:text-slate-400 border-l-2 border-transparent hover:border-brand-600">${attributes.list_ref[key]}</a>
                                                `).join('')}
                                            </div>
                                        </div>

                                        <div>
                                            <button onclick="this.nextElementSibling.classList.toggle('hidden')" class="w-full flex items-center justify-between px-5 py-3 bg-slate-50 dark:bg-slate-800 rounded-2xl text-[11px] font-black text-slate-700 dark:text-slate-200 hover:bg-brand-50 hover:text-brand-600 transition-all group">
                                                <span>STATISTIK BANTUAN</span>
                                                <i class="fa-solid fa-chevron-down opacity-30 group-hover:opacity-100 transition-opacity"></i>
                                            </button>
                                            <div class="hidden mt-2 grid grid-cols-1 gap-1 p-2 bg-white dark:bg-slate-900 rounded-2xl border border-slate-100 dark:border-slate-800 shadow-sm max-h-48 overflow-y-auto custom-scrollbar">
                                                ${Object.keys(attributes.list_bantuan).map(key => `
                                                    <a href="javascript:void(0)" onclick="openChartModal('<?= site_url('statistik_web/chart_gis_desa') ?>/${key}/${encodeLabel(configMap.nama_desa)}', 'Statistik ${attributes.list_bantuan[key].replace(/'/g, "\\'")}')" class="text-[10px] py-2 px-4 hover:bg-brand-50 hover:text-brand-600 rounded-xl transition-all font-bold text-slate-500 dark:text-slate-400 border-l-2 border-transparent hover:border-brand-600">${attributes.list_bantuan[key]}</a>
                                                `).join('')}
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            `;
                            polyDesa.bindPopup(popupDesa);
                            map.fitBounds(polyDesa.getBounds());
                        } catch(e) { console.error("Error path desa:", e); }
                    }

                    // Dusun Loop dengan Statistik
                    if(attributes.dusun_gis) {
                        attributes.dusun_gis.forEach(dusun => {
                            if(dusun.path) {
                                try {
                                    const poly = L.polygon(JSON.parse(dusun.path), {
                                        color: '#10b981', weight: 2, fillOpacity: 0.15
                                    }).addTo(layerGroups.wilayahDusun);
                                    
                                    let popupContent = `
                                        <div class="p-3 min-w-[260px]">
                                            <h6 class="font-black text-slate-900 dark:text-white mb-4 uppercase tracking-wider border-b border-slate-100 dark:border-slate-800 pb-3 text-center">Dusun ${dusun.dusun}</h6>
                                            <div class="space-y-3">
                                                <div>
                                                    <button onclick="this.nextElementSibling.classList.toggle('hidden')" class="w-full flex items-center justify-between px-5 py-3 bg-slate-50 dark:bg-slate-800 rounded-2xl text-[11px] font-black text-slate-700 dark:text-slate-200 hover:bg-brand-50 hover:text-brand-600 transition-all group">
                                                        <span>STATISTIK PENDUDUK</span>
                                                        <i class="fa-solid fa-chevron-down opacity-30 group-hover:opacity-100 transition-opacity"></i>
                                                    </button>
                                                    <div class="hidden mt-2 grid grid-cols-1 gap-1 p-2 bg-white dark:bg-slate-900 rounded-2xl border border-slate-100 dark:border-slate-800 shadow-sm max-h-48 overflow-y-auto custom-scrollbar">
                                                        ${Object.keys(attributes.list_ref).map(key => `
                                                            <a href="javascript:void(0)" onclick="openChartModal('<?= site_url('statistik_web/chart_gis_dusun') ?>/${key}/${encodeLabel(dusun.dusun)}', 'Statistik ${attributes.list_ref[key].replace(/'/g, "\\'")} - ${dusun.dusun}')" class="text-[10px] py-2 px-4 hover:bg-brand-50 hover:text-brand-600 rounded-xl transition-all font-bold text-slate-500 dark:text-slate-400 border-l-2 border-transparent hover:border-brand-600">${attributes.list_ref[key]}</a>
                                                        `).join('')}
                                                    </div>
                                                </div>

                                                <div>
                                                    <button onclick="this.nextElementSibling.classList.toggle('hidden')" class="w-full flex items-center justify-between px-5 py-3 bg-slate-50 dark:bg-slate-800 rounded-2xl text-[11px] font-black text-slate-700 dark:text-slate-200 hover:bg-brand-50 hover:text-brand-600 transition-all group">
                                                        <span>STATISTIK BANTUAN</span>
                                                        <i class="fa-solid fa-chevron-down opacity-30 group-hover:opacity-100 transition-opacity"></i>
                                                    </button>
                                                    <div class="hidden mt-2 grid grid-cols-1 gap-1 p-2 bg-white dark:bg-slate-900 rounded-2xl border border-slate-100 dark:border-slate-800 shadow-sm max-h-48 overflow-y-auto custom-scrollbar">
                                                        ${Object.keys(attributes.list_bantuan).map(key => `
                                                            <a href="javascript:void(0)" onclick="openChartModal('<?= site_url('statistik_web/chart_gis_dusun') ?>/${key}/${encodeLabel(dusun.dusun)}', 'Statistik ${attributes.list_bantuan[key].replace(/'/g, "\\'")} - ${dusun.dusun}')" class="text-[10px] py-2 px-4 hover:bg-brand-50 hover:text-brand-600 rounded-xl transition-all font-bold text-slate-500 dark:text-slate-400 border-l-2 border-transparent hover:border-brand-600">${attributes.list_bantuan[key]}</a>
                                                        `).join('')}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    `;
                                    poly.bindPopup(popupContent);
                                } catch(e) { console.error("Error path dusun:", e); }
                            }
                        });
                    }

                    // RW Loop
                    if(attributes.rw_gis) {
                        attributes.rw_gis.forEach(rw => {
                            if(rw.path) {
                                try {
                                    let popupRW = `
                                        <div class="p-3 min-w-[260px]">
                                            <h6 class="font-black text-slate-900 dark:text-white mb-4 uppercase tracking-wider border-b border-slate-100 dark:border-slate-800 pb-3 text-center">Wilayah RW ${rw.rw} <span class="text-[10px] text-slate-400 block mt-1">Dusun ${rw.dusun}</span></h6>
                                            <div class="space-y-3">
                                                <div>
                                                    <button onclick="this.nextElementSibling.classList.toggle('hidden')" class="w-full flex items-center justify-between px-5 py-3 bg-slate-50 dark:bg-slate-800 rounded-2xl text-[11px] font-black text-slate-700 dark:text-slate-200 hover:bg-brand-50 hover:text-brand-600 transition-all group">
                                                        <span>STATISTIK PENDUDUK</span>
                                                        <i class="fa-solid fa-chevron-down opacity-30 group-hover:opacity-100 transition-opacity"></i>
                                                    </button>
                                                    <div class="hidden mt-2 grid grid-cols-1 gap-1 p-2 bg-white dark:bg-slate-900 rounded-2xl border border-slate-100 dark:border-slate-800 shadow-sm max-h-48 overflow-y-auto custom-scrollbar">
                                                        ${Object.keys(attributes.list_ref).map(key => `
                                                            <a href="javascript:void(0)" onclick="openChartModal('<?= site_url('statistik_web/chart_gis_rw') ?>/${key}/${encodeLabel(rw.dusun)}/${rw.rw}', 'Statistik ${attributes.list_ref[key].replace(/'/g, "\\'")} - RW ${rw.rw}')" class="text-[10px] py-2 px-4 hover:bg-brand-50 hover:text-brand-600 rounded-xl transition-all font-bold text-slate-500 dark:text-slate-400 border-l-2 border-transparent hover:border-brand-600">${attributes.list_ref[key]}</a>
                                                        `).join('')}
                                                    </div>
                                                </div>

                                                <div>
                                                    <button onclick="this.nextElementSibling.classList.toggle('hidden')" class="w-full flex items-center justify-between px-5 py-3 bg-slate-50 dark:bg-slate-800 rounded-2xl text-[11px] font-black text-slate-700 dark:text-slate-200 hover:bg-brand-50 hover:text-brand-600 transition-all group">
                                                        <span>STATISTIK BANTUAN</span>
                                                        <i class="fa-solid fa-chevron-down opacity-30 group-hover:opacity-100 transition-opacity"></i>
                                                    </button>
                                                    <div class="hidden mt-2 grid grid-cols-1 gap-1 p-2 bg-white dark:bg-slate-900 rounded-2xl border border-slate-100 dark:border-slate-800 shadow-sm max-h-48 overflow-y-auto custom-scrollbar">
                                                        ${Object.keys(attributes.list_bantuan).map(key => `
                                                            <a href="javascript:void(0)" onclick="openChartModal('<?= site_url('statistik_web/chart_gis_rw') ?>/${key}/${encodeLabel(rw.dusun)}/${rw.rw}', 'Statistik ${attributes.list_bantuan[key].replace(/'/g, "\\'")} - RW ${rw.rw}')" class="text-[10px] py-2 px-4 hover:bg-brand-50 hover:text-brand-600 rounded-xl transition-all font-bold text-slate-500 dark:text-slate-400 border-l-2 border-transparent hover:border-brand-600">${attributes.list_bantuan[key]}</a>
                                                        `).join('')}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    `;
                                    L.polygon(JSON.parse(rw.path), { color: '#8b5cf6', weight: 1.5, fillOpacity: 0.1, dashArray: '4, 4' })
                                     .addTo(layerGroups.wilayahRW)
                                     .bindPopup(popupRW);
                                } catch(e) {}
                            }
                        });
                    }

                    // RT Loop
                    if(attributes.rt_gis) {
                        attributes.rt_gis.forEach(rt => {
                            if(rt.path) {
                                try {
                                    let popupRT = `
                                        <div class="p-3 min-w-[260px]">
                                            <h6 class="font-black text-slate-900 dark:text-white mb-4 uppercase tracking-wider border-b border-slate-100 dark:border-slate-800 pb-3 text-center">Wilayah RT ${rt.rt} <span class="text-[10px] text-slate-400 block mt-1">RW ${rt.rw} - Dusun ${rt.dusun}</span></h6>
                                            <div class="space-y-3">
                                                <div>
                                                    <button onclick="this.nextElementSibling.classList.toggle('hidden')" class="w-full flex items-center justify-between px-5 py-3 bg-slate-50 dark:bg-slate-800 rounded-2xl text-[11px] font-black text-slate-700 dark:text-slate-200 hover:bg-brand-50 hover:text-brand-600 transition-all group">
                                                        <span>STATISTIK PENDUDUK</span>
                                                        <i class="fa-solid fa-chevron-down opacity-30 group-hover:opacity-100 transition-opacity"></i>
                                                    </button>
                                                    <div class="hidden mt-2 grid grid-cols-1 gap-1 p-2 bg-white dark:bg-slate-900 rounded-2xl border border-slate-100 dark:border-slate-800 shadow-sm max-h-48 overflow-y-auto custom-scrollbar">
                                                        ${Object.keys(attributes.list_ref).map(key => `
                                                            <a href="javascript:void(0)" onclick="openChartModal('<?= site_url('statistik_web/chart_gis_rt') ?>/${key}/${encodeLabel(rt.dusun)}/${rt.rw}/${rt.rt}', 'Statistik ${attributes.list_ref[key].replace(/'/g, "\\'")} - RT ${rt.rt}')" class="text-[10px] py-2 px-4 hover:bg-brand-50 hover:text-brand-600 rounded-xl transition-all font-bold text-slate-500 dark:text-slate-400 border-l-2 border-transparent hover:border-brand-600">${attributes.list_ref[key]}</a>
                                                        `).join('')}
                                                    </div>
                                                </div>

                                                <div>
                                                    <button onclick="this.nextElementSibling.classList.toggle('hidden')" class="w-full flex items-center justify-between px-5 py-3 bg-slate-50 dark:bg-slate-800 rounded-2xl text-[11px] font-black text-slate-700 dark:text-slate-200 hover:bg-brand-50 hover:text-brand-600 transition-all group">
                                                        <span>STATISTIK BANTUAN</span>
                                                        <i class="fa-solid fa-chevron-down opacity-30 group-hover:opacity-100 transition-opacity"></i>
                                                    </button>
                                                    <div class="hidden mt-2 grid grid-cols-1 gap-1 p-2 bg-white dark:bg-slate-900 rounded-2xl border border-slate-100 dark:border-slate-800 shadow-sm max-h-48 overflow-y-auto custom-scrollbar">
                                                        ${Object.keys(attributes.list_bantuan).map(key => `
                                                            <a href="javascript:void(0)" onclick="openChartModal('<?= site_url('statistik_web/chart_gis_rt') ?>/${key}/${encodeLabel(rt.dusun)}/${rt.rw}/${rt.rt}', 'Statistik ${attributes.list_bantuan[key].replace(/'/g, "\\'")} - RT ${rt.rt}')" class="text-[10px] py-2 px-4 hover:bg-brand-50 hover:text-brand-600 rounded-xl transition-all font-bold text-slate-500 dark:text-slate-400 border-l-2 border-transparent hover:border-brand-600">${attributes.list_bantuan[key]}</a>
                                                        `).join('')}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    `;
                                    L.polygon(JSON.parse(rt.path), { color: '#ec4899', weight: 1, fillOpacity: 0.05, dashArray: '2, 2' })
                                     .addTo(layerGroups.wilayahRT)
                                     .bindPopup(popupRT);
                                } catch(e) {}
                            }
                        });
                    }

                    // Lokasi Pembangunan (Infrastruktur Titik)
                    if(attributes.pembangunan && attributes.pembangunan.length > 0) {
                        const markersInfrastruktur = L.markerClusterGroup();
                        attributes.pembangunan.forEach(item => {
                            if(item.lat && item.lng) {
                                const marker = L.marker([item.lat, item.lng], {
                                    icon: L.divIcon({
                                        className: 'custom-div-icon',
                                        html: `<div style="background-color:#6366f1; width:24px; height:24px; border-radius:50%; border:3px solid white; box-shadow:0 4px 6px rgba(0,0,0,0.1); display:flex; align-items:center; justify-content:center; color:white; font-size:10px;"><i class="fa-solid fa-hard-hat"></i></div>`,
                                        iconSize: [24, 24],
                                        iconAnchor: [12, 12]
                                    })
                                }).bindPopup(`
                                    <div class="p-2">
                                        <div class="flex items-center gap-2 mb-2">
                                            <span class="px-2 py-0.5 bg-brand-100 text-brand-600 text-[8px] font-black uppercase rounded-full">Infrastruktur</span>
                                        </div>
                                        <h6 class="font-bold text-sm text-slate-900 mb-1">${item.judul}</h6>
                                        <p class="text-[10px] text-slate-500 line-clamp-2 mb-3">${item.lokasi || ''}</p>
                                        <a href="<?= site_url('pembangunan') ?>" class="btn-stat-map text-center">Detail Pembangunan</a>
                                    </div>
                                `);
                                markersInfrastruktur.addLayer(marker);
                            }
                        });
                        layerGroups.pembangunanDesa.addLayer(markersInfrastruktur);
                    }

                    // Lokasi/Point Cluster (Fasilitas)
                    if(attributes.lokasi && attributes.lokasi.length > 0) {
                        const markers = L.markerClusterGroup();
                        attributes.lokasi.forEach(lok => {
                            if(lok.lat && lok.lng) {
                                const marker = L.marker([lok.lat, lok.lng])
                                    .bindPopup(`
                                        <div class="p-2">
                                            <h6 class="font-bold text-slate-900 mb-1">${lok.nama}</h6>
                                            <p class="text-[10px] text-slate-500 mb-2">${lok.deskripsi || ''}</p>
                                            <span class="text-[9px] font-bold text-slate-400 uppercase">Fasilitas Publik</span>
                                        </div>
                                    `);
                                markers.addLayer(marker);
                            }
                        });
                        layerGroups.lokasiFasilitas.addLayer(markers);
                    }

                    // Garis Loop (Infrastruktur Garis)
                    if(attributes.garis) {
                        attributes.garis.forEach(garis => {
                            if(garis.path) {
                                try {
                                    const polyline = L.polyline(JSON.parse(garis.path), {
                                        color: '#f59e0b', weight: 4, opacity: 0.8
                                    }).addTo(layerGroups.garisInfrastruktur);
                                    polyline.bindPopup(`
                                        <div class="p-2">
                                            <h6 class="font-bold text-slate-900 mb-1">${garis.nama}</h6>
                                            <span class="text-[8px] font-bold text-amber-600 uppercase">Infrastruktur Jalan/Saluran</span>
                                        </div>
                                    `);
                                } catch(e) { console.error("Error path garis:", e); }
                            }
                        });
                    }

                    // Area Loop (Polygon Area)
                    if(attributes.area) {
                        attributes.area.forEach(area => {
                            if(area.path) {
                                try {
                                    const poly = L.polygon(JSON.parse(area.path), {
                                        color: '#ec4899', weight: 2, fillOpacity: 0.2
                                    }).addTo(layerGroups.areaSpesial);
                                    poly.bindPopup(`
                                        <div class="p-2">
                                            <h6 class="font-bold text-slate-900 mb-1">${area.nama}</h6>
                                            <p class="text-[10px] text-slate-500">${area.deskripsi || ''}</p>
                                            <span class="text-[8px] font-bold text-pink-600 uppercase">Area Khusus</span>
                                        </div>
                                    `);
                                } catch(e) { console.error("Error path area:", e); }
                            }
                        });
                    }

                    // Letter C-Desa (Persil)
                    if(attributes.persil) {
                        attributes.persil.forEach(p => {
                            if(p.path) {
                                try {
                                    const poly = L.polygon(JSON.parse(p.path), {
                                        color: '#64748b', weight: 1, fillOpacity: 0.1, dashArray: '3, 3'
                                    }).addTo(layerGroups.letterCDesa);
                                    poly.bindPopup(`
                                        <div class="p-2 min-w-[180px]">
                                            <h6 class="font-black text-slate-900 mb-2 uppercase tracking-tight border-b pb-1">Letter C-Desa</h6>
                                            <div class="space-y-1 text-[10px]">
                                                <div class="flex justify-between"><span class="text-slate-400">Pemilik:</span> <span class="font-bold">${p.nama_pemilik || '-'}</span></div>
                                                <div class="flex justify-between"><span class="text-slate-400">No. Persil:</span> <span class="font-bold">${p.nomor_persil || '-'}</span></div>
                                                <div class="flex justify-between"><span class="text-slate-400">Luas:</span> <span class="text-brand-600 font-bold">${p.luas || 0} m²</span></div>
                                            </div>
                                        </div>
                                    `);
                                } catch(e) { console.error("Error path persil:", e); }
                            }
                        });
                    }
                }
                
                // Sembunyikan loader karena data sudah siap
                hideLoader();

            };
        })();
    </script>

    <script src="<?= base_url($folder_themes . '/assets/js/app.js') ?>"></script>

    <!-- Footer -->
    <?php $this->load->view("$folder_themes/commons/copyleft.php"); ?>

    <noscript>Mohon aktifkan JavaScript untuk menggunakan fitur peta interaktif ini.</noscript>

</body>
</html>
