<?php defined('BASEPATH') || exit('No direct script access allowed'); ?>

<!-- External Assets -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<?php if($pembangunan) : ?>
    <div class="pembangunan-detail-wrapper pb-24">
        
        <!-- [1] CINEMATIC HERO SECTION -->
        <div class="relative h-[60vh] md:h-[70vh] w-full rounded-[4rem] overflow-hidden shadow-2xl border-b-8 border-white dark:border-slate-800 group">
            <?php if (is_file(LOKASI_GALERI . $pembangunan->foto)): ?>
                <img src="<?= base_url(LOKASI_GALERI . $pembangunan->foto); ?>" class="w-full h-full object-cover transition-transform duration-[3s] group-hover:scale-110" alt="<?= html_escape($pembangunan->judul) ?>"/>
            <?php else: ?>
                <div class="w-full h-full bg-gradient-to-br from-brand-900 to-slate-900 flex items-center justify-center">
                    <i class="fa-solid fa-helmet-safety text-9xl text-white/10 animate-pulse"></i>
                </div>
            <?php endif; ?>
            
            <!-- Glass Navigation Overlay -->
            <div class="absolute top-10 left-10 z-30">
                <a href="<?= site_url('pembangunan'); ?>" class="flex items-center gap-3 px-6 py-4 bg-white/10 backdrop-blur-2xl rounded-3xl border border-white/20 text-white font-black text-xs uppercase tracking-widest hover:bg-white hover:text-brand-600 transition-all group/back">
                    <i class="fa-solid fa-arrow-left group-hover/back:-translate-x-2 transition-transform"></i>
                    Kembali Ke Daftar
                </a>
            </div>

            <!-- Title & Basic Info Overlay -->
            <div class="absolute inset-0 bg-gradient-to-t from-slate-950 via-slate-950/20 to-transparent flex flex-col justify-end p-8 md:p-24">
                <div class="max-w-5xl">
                    <div class="flex items-center gap-4 mb-8">
                        <span class="px-5 py-2 rounded-2xl bg-brand-600 text-white font-black text-[10px] uppercase tracking-[0.2em] shadow-xl shadow-brand-600/30">
                            TA <?= $pembangunan->tahun_anggaran ?>
                        </span>
                        <span class="w-12 h-px bg-white/30"></span>
                        <span class="text-white/70 font-bold text-xs uppercase tracking-[0.3em]">Infrastructure Project Report</span>
                    </div>
                    <h1 class="font-display font-[900] text-5xl md:text-8xl text-white leading-[0.95] tracking-tighter mb-8 drop-shadow-2xl">
                        <?= $pembangunan->judul ?>
                    </h1>
                </div>
            </div>
        </div>

        <!-- [2] FLOATING KEY METRICS BAR -->
        <div class="container mx-auto px-6 -mt-16 relative z-40">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Budget Card -->
                <div class="bg-white dark:bg-slate-900 p-8 rounded-[3rem] shadow-2xl border border-slate-100 dark:border-slate-800 flex flex-col items-center justify-center hover:-translate-y-2 transition-transform group">
                    <div class="w-14 h-14 rounded-2xl bg-brand-600/10 text-brand-600 flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                        <i class="fa-solid fa-wallet text-xl"></i>
                    </div>
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Total Anggaran</p>
                    <p class="text-2xl font-display font-black text-brand-600">Rp <?= number_format($pembangunan->anggaran, 0, ',', '.') ?></p>
                </div>
                <!-- Location Card -->
                <div class="bg-white dark:bg-slate-900 p-8 rounded-[3rem] shadow-2xl border border-slate-100 dark:border-slate-800 flex flex-col items-center justify-center hover:-translate-y-2 transition-transform group">
                    <div class="w-14 h-14 rounded-2xl bg-brand-600/10 text-brand-600 flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                        <i class="fa-solid fa-location-dot text-xl"></i>
                    </div>
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Lokasi Kerja</p>
                    <p class="text-sm font-bold text-slate-900 dark:text-white text-center line-clamp-1"><?= $pembangunan->alamat ?></p>
                </div>
                <!-- Volume Card -->
                <div class="bg-white dark:bg-slate-900 p-8 rounded-[3rem] shadow-2xl border border-slate-100 dark:border-slate-800 flex flex-col items-center justify-center hover:-translate-y-2 transition-transform group">
                    <div class="w-14 h-14 rounded-2xl bg-brand-600/10 text-brand-600 flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                        <i class="fa-solid fa-expand text-xl"></i>
                    </div>
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Volume Kerja</p>
                    <p class="text-sm font-bold text-slate-900 dark:text-white"><?= $pembangunan->volume ?></p>
                </div>
                <!-- Status Card -->
                <div class="bg-brand-600 p-8 rounded-[3rem] shadow-2xl shadow-brand-600/30 flex flex-col items-center justify-center hover:-translate-y-2 transition-transform group">
                    <div class="w-14 h-14 rounded-2xl bg-white/20 text-white flex items-center justify-center mb-4 group-hover:rotate-12 transition-transform">
                        <i class="fa-solid fa-check-double text-xl"></i>
                    </div>
                    <p class="text-[10px] font-black text-white/60 uppercase tracking-widest mb-1">Status Report</p>
                    <p class="text-sm font-bold text-white uppercase tracking-widest">Terlaksana 100%</p>
                </div>
            </div>
        </div>

        <!-- [3] MAIN CONTENT AREA (Split Layout) -->
        <div class="container mx-auto px-6 mt-20">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-16 items-start">
                
                <!-- Left Column: Storytelling & Timeline -->
                <div class="lg:col-span-8 space-y-20">
                    
                    <!-- Description Block -->
                    <div class="relative">
                        <div class="flex items-center gap-4 mb-10">
                            <div class="h-12 w-2 bg-brand-600 rounded-full"></div>
                            <h2 class="font-display font-black text-3xl text-slate-900 dark:text-white tracking-tight">Eksplorasi Detail Kegiatan</h2>
                        </div>
                        <div class="p-12 bg-white dark:bg-slate-900 rounded-[4rem] border border-slate-100 dark:border-slate-800 shadow-xl prose prose-slate dark:prose-invert prose-lg max-w-none font-medium leading-[2] text-slate-600 dark:text-slate-400 italic">
                            "<?= nl2br($pembangunan->keterangan) ?>"
                        </div>
                    </div>

                    <!-- Progress Documentation Gallery -->
                    <div>
                        <div class="flex items-end justify-between mb-12">
                            <div>
                                <h3 class="font-display font-black text-2xl text-slate-900 dark:text-white">Dokumentasi Visual</h3>
                                <p class="text-slate-400 text-xs font-bold uppercase tracking-widest mt-2">Update progres pembangunan di lapangan</p>
                            </div>
                            <span class="hidden md:block h-px flex-1 bg-slate-100 dark:bg-slate-800 mx-10"></span>
                            <div class="flex gap-2">
                                <div class="w-10 h-10 rounded-xl bg-slate-50 dark:bg-slate-800 border border-slate-100 dark:border-slate-800 flex items-center justify-center text-slate-400">
                                    <i class="fa-solid fa-camera"></i>
                                </div>
                            </div>
                        </div>

                        <?php if ($dokumentasi): ?>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-10">
                                <?php foreach ($dokumentasi as $value): ?>
                                    <div class="group relative rounded-[4rem] overflow-hidden border-8 border-white dark:border-slate-800 shadow-2xl transition-all hover:-translate-y-4 hover:rotate-1">
                                        <div class="aspect-[4/5] w-full">
                                            <?php if (is_file(LOKASI_GALERI . $value->gambar)): ?>
                                                <img src="<?= base_url(LOKASI_GALERI . $value->gambar); ?>" class="w-full h-full object-cover transition-transform duration-1000 group-hover:scale-110" alt="Progres <?= $value->persentase ?>"/>
                                            <?php else: ?>
                                                <div class="w-full h-full bg-slate-100 dark:bg-slate-800 flex items-center justify-center">
                                                    <i class="fa-solid fa-image text-slate-200 text-5xl"></i>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                        <!-- Overlay Info -->
                                        <div class="absolute inset-0 bg-gradient-to-t from-slate-950 via-transparent to-transparent flex flex-col justify-end p-10 opacity-0 group-hover:opacity-100 transition-opacity duration-500">
                                            <div class="bg-white/10 backdrop-blur-xl p-6 rounded-[2.5rem] border border-white/20">
                                                <div class="flex items-center justify-between mb-2">
                                                    <p class="text-white font-black text-2xl"><?= $value->persentase ?></p>
                                                    <i class="fa-solid fa-circle-check text-accent"></i>
                                                </div>
                                                <p class="text-white/60 text-[10px] font-black uppercase tracking-[0.2em]">Kondisi Pengerjaan Fisik</p>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php else: ?>
                            <div class="p-24 text-center bg-slate-50 dark:bg-slate-900 rounded-[4rem] border-4 border-dashed border-slate-100 dark:border-slate-800">
                                <i class="fa-solid fa-cloud-moon text-6xl text-slate-200 mb-6 block"></i>
                                <h4 class="font-display font-black text-slate-400 uppercase text-xs tracking-widest">Dokumentasi belum diperbarui oleh tim lapangan.</h4>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Right Column: Interactive Sidebar -->
                <div class="lg:col-span-4 space-y-12">
                    
                    <!-- Advanced Map Widget -->
                    <div class="bg-white dark:bg-slate-900 p-8 rounded-[4rem] shadow-2xl border border-slate-100 dark:border-slate-800 overflow-hidden relative group">
                        <div class="flex items-center gap-4 mb-8">
                            <div class="w-10 h-10 rounded-xl bg-brand-600/10 text-brand-600 flex items-center justify-center">
                                <i class="fa-solid fa-satellite"></i>
                            </div>
                            <h3 class="font-display font-black text-xl text-slate-900 dark:text-white">Mapping Point</h3>
                        </div>
                        <!-- Map Container -->
                        <div id="map" class="w-full h-[400px] rounded-[3rem] border border-slate-100 dark:border-slate-800 mb-8 relative z-10"></div>
                        
                        <div class="p-6 bg-slate-50 dark:bg-slate-800/40 rounded-[2.5rem] border border-slate-100 dark:border-slate-800">
                            <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1">Sumber Pendanaan</p>
                            <div class="flex items-center gap-3">
                                <div class="w-2 h-2 rounded-full bg-accent animate-pulse"></div>
                                <p class="text-sm font-bold text-slate-900 dark:text-white"><?= $pembangunan->sumber_dana ?></p>
                            </div>
                        </div>
                    </div>

                    <!-- Stakeholder Info -->
                    <div class="bg-slate-900 dark:bg-white p-10 rounded-[4rem] shadow-2xl relative overflow-hidden group">
                        <div class="absolute -bottom-10 -right-10 w-40 h-40 bg-brand-600/20 rounded-full blur-3xl transition-transform group-hover:scale-150"></div>
                        <h4 class="font-display font-black text-xs uppercase tracking-[0.4em] text-slate-500 dark:text-slate-400 mb-10">Stakeholders</h4>
                        <div class="flex items-center gap-6">
                            <div class="w-20 h-20 rounded-[2rem] bg-slate-800 dark:bg-slate-100 flex items-center justify-center text-brand-500">
                                <i class="fa-solid fa-hard-hat text-3xl"></i>
                            </div>
                            <div>
                                <p class="text-[10px] font-black text-slate-500 uppercase tracking-widest mb-1">Pelaksana Teknis</p>
                                <p class="text-lg font-display font-black text-white dark:text-slate-900 leading-tight"><?= $pembangunan->pelaksana_kegiatan ?></p>
                            </div>
                        </div>
                    </div>

                    <!-- Side Menu Load -->
                    <div class="pt-8">
                        <?php $this->load->view("$folder_themes/commons/right_menu.php"); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Enhanced Mapping Logic -->
    <script type="text/javascript">
        $(document).ready(function() {
            const lat = parseFloat("<?= $pembangunan->lat ?? $desa['lat'] ?>");
            const lng = parseFloat("<?= $pembangunan->lng ?? $desa['lng'] ?>");
            const zoom = parseInt("<?= $desa['zoom'] ?? 15 ?>");
            const mapContainer = document.getElementById('map');

            if (mapContainer && typeof L !== 'undefined') {
                const map = L.map('map', {
                    scrollWheelZoom: false,
                    zoomControl: false,
                    attributionControl: false
                }).setView([lat, lng], zoom);

                L.tileLayer('https://{s}.tile.osm.org/{z}/{x}/{y}.png').addTo(map);

                const customIcon = L.divIcon({
                    html: `
                        <div class="relative flex items-center justify-center">
                            <div class="absolute w-20 h-20 bg-brand-600/30 rounded-full animate-ping"></div>
                            <div class="relative w-16 h-16 bg-brand-600 rounded-full border-4 border-white shadow-2xl flex items-center justify-center text-white">
                                <i class="fa-solid fa-helmet-safety text-xl"></i>
                            </div>
                        </div>
                    `,
                    className: '',
                    iconSize: [80, 80],
                    iconAnchor: [40, 40]
                });

                L.marker([lat, lng], {icon: customIcon}).addTo(map)
                    .bindPopup(`
                        <div class="p-6 min-w-[220px] rounded-3xl bg-white">
                            <h5 class="font-display font-black text-slate-900 text-lg mb-2 leading-tight"><?= addslashes($pembangunan->judul) ?></h5>
                            <p class="text-slate-500 text-[10px] font-black uppercase tracking-widest mb-6 italic"><?= addslashes($pembangunan->alamat) ?></p>
                            <a href="https://www.google.com/maps/dir/?api=1&destination=${lat},${lng}" target="_blank" rel="noopener noreferrer" class="flex items-center justify-center gap-2 w-full py-4 bg-slate-900 text-white rounded-2xl font-black text-[10px] uppercase tracking-widest hover:bg-brand-600 hover:scale-105 transition-all shadow-xl">
                                <i class="fa-solid fa-diamond-turn-right"></i> Navigasi Maps
                            </a>
                        </div>
                    `, { className: 'premium-popup' });

                L.control.zoom({ position: 'bottomright' }).addTo(map);
                setTimeout(() => { map.invalidateSize(); }, 800);
            }
        });
    </script>

    <style>
        .premium-popup .leaflet-popup-content-wrapper { border-radius: 3rem; border: none; box-shadow: 0 40px 80px -20px rgba(0, 0, 0, 0.35); overflow: hidden; }
        .premium-popup .leaflet-popup-content { margin: 0; }
        .premium-popup .leaflet-popup-tip { background: white; }
        
        .pembangunan-detail-wrapper {
            background-image: radial-gradient(circle at top right, rgba(59, 130, 246, 0.05), transparent),
                              radial-gradient(circle at bottom left, rgba(16, 185, 129, 0.05), transparent);
        }
    </style>

<?php else: ?>
    <?php $this->load->view("$folder_themes/commons/404"); ?>
<?php endif; ?>
