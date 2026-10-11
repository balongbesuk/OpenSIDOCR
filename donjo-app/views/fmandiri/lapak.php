<?php

defined('BASEPATH') || exit('No direct script access allowed');

/*
 * File ini:
 *
 * View modul Layanan Mandiri > Lapak
 * Redesigned with Next-Gen UI/UX Pro Max (Tema Desa Balongbesuk)
 *
 * donjo-app/views/fmandiri/lapak.php
 */
?>

<!-- ========================================================================
     PAGE TITLE & BREADCRUMB CARD
     ======================================================================== -->
<div class="relative bg-white rounded-2xl border border-slate-200/80 p-5 sm:p-6 mb-6 shadow-xs overflow-hidden flex items-center justify-between">
	
	<!-- Left: Big Blue Icon + Title & Breadcrumb -->
	<div class="flex items-center space-x-4 z-10">
		<div class="w-12 h-12 sm:w-14 sm:h-14 rounded-2xl bg-[#0284c7] text-white flex items-center justify-center text-xl sm:text-2xl shadow-sm flex-shrink-0">
			<i class="fa-solid fa-store"></i>
		</div>
		<div>
			<h2 class="text-2xl sm:text-3xl font-extrabold font-display text-slate-900 leading-tight">
				Lapak Warga Desa
			</h2>
			<nav class="flex items-center space-x-2 text-sm text-slate-400 font-medium mt-1">
				<a href="<?= site_url('layanan-mandiri/beranda') ?>" class="hover:text-sky-600 transition-colors text-decoration-none text-slate-400">Beranda</a>
				<span>&rsaquo;</span>
				<span class="text-slate-600 font-semibold">Lapak</span>
			</nav>
		</div>
	</div>

	<!-- Right: Subtle Category Count Badge -->
	<div class="hidden sm:flex items-center space-x-2 bg-sky-50 border border-sky-200/70 text-sky-700 px-4 py-2 rounded-xl text-sm font-semibold">
		<i class="fa-solid fa-tags text-sky-500"></i>
		<span><?= count($kategori) ?> Kategori Produk</span>
	</div>

</div>

<!-- ========================================================================
     MAIN CONTAINER: SEARCH & PRODUCT LIST
     ======================================================================== -->
<div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs p-5 sm:p-7 mb-6">
	
	<!-- Top Filter & Search Controls -->
	<div class="border-b border-slate-200/80 pb-5 mb-6">
		<form method="get" class="flex flex-col sm:flex-row items-stretch sm:items-center justify-between gap-3.5">
			
			<div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3 flex-1">
				<!-- Category Selector -->
				<div class="relative sm:w-64">
					<select class="w-full pl-3.5 pr-8 py-2.5 rounded-xl border border-slate-300 bg-white text-sm sm:text-base font-semibold text-slate-700 focus:outline-none focus:ring-2 focus:ring-sky-500 focus:border-sky-500 transition-all cursor-pointer shadow-xs" id="id_kategori" name="id_kategori">
						<option selected value="">Semua Kategori</option>
						<?php foreach ($kategori as $kategori_item) : ?>
							<option value="<?= $kategori_item->id ?>" <?= selected($id_kategori, $kategori_item->id) ?>><?= $kategori_item->kategori ?></option>
						<?php endforeach; ?>
					</select>
				</div>

				<!-- Search Input -->
				<div class="relative flex-1">
					<i class="fa-solid fa-magnifying-glass absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-sm sm:text-base"></i>
					<input 
						type="text" 
						name="keyword" 
						maxlength="50" 
						class="w-full pl-11 pr-4 py-2.5 rounded-xl border border-slate-300 bg-white text-sm sm:text-base text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-sky-500 focus:border-sky-500 transition-all shadow-xs" 
						value="<?= $keyword; ?>" 
						placeholder="Cari nama produk atau pelapak..."
					>
				</div>
			</div>

			<!-- Action Buttons -->
			<div class="flex items-center space-x-2">
				<button type="submit" class="px-6 py-2.5 rounded-xl bg-sky-600 hover:bg-sky-700 text-white font-bold text-sm sm:text-base shadow-xs transition-colors flex items-center space-x-2">
					<i class="fa-solid fa-magnifying-glass text-xs sm:text-sm"></i>
					<span>Cari</span>
				</button>
				<?php if ($keyword) : ?>
					<a href="<?= site_url('/layanan-mandiri/lapak') ?>" class="px-5 py-2.5 rounded-xl border border-slate-300 text-slate-700 hover:bg-slate-50 font-semibold text-sm sm:text-base transition-colors text-decoration-none">
						Tampilkan Semua
					</a>
				<?php endif ?>
			</div>

		</form>
	</div>

	<!-- Product Cards Grid -->
	<?php if ($produk) : ?>
		<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
			<?php foreach ($produk as $in => $pro) : ?>
				<?php $foto = json_decode($pro->foto); ?>
				<?php $harga_potongan = ($pro->tipe_potongan == 1) ? ($pro->harga * ($pro->potongan / 100)) : $pro->potongan; ?>

				<div class="bg-white rounded-2xl border border-slate-200/90 hover:border-sky-400 overflow-hidden shadow-xs hover:shadow-md transition-all flex flex-col justify-between group">
					
					<!-- Product Image with Carousel or Single Photo -->
					<div class="relative bg-slate-100 aspect-video overflow-hidden">
						<?php if ($pro->foto && !empty($foto[0]) && is_file(LOKASI_PRODUK . $foto[0])) : ?>
							<img src="<?= base_url(LOKASI_PRODUK . $foto[0]); ?>" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300" alt="<?= htmlspecialchars($pro->nama) ?>">
						<?php else : ?>
							<img src="<?= base_url('assets/images/404-image-not-found.jpg') ?>" class="w-full h-full object-cover opacity-80" alt="Foto Produk">
						<?php endif; ?>

						<!-- Category Tag Overlay -->
						<?php if (!empty($pro->kategori)) : ?>
							<span class="absolute top-3 left-3 px-3 py-1 rounded-lg bg-slate-900/80 backdrop-blur-xs text-white text-xs font-semibold shadow-xs">
								<?= $pro->kategori ?>
							</span>
						<?php endif; ?>

						<!-- Discount Badge -->
						<?php if ($pro->potongan != 0) : ?>
							<span class="absolute top-3 right-3 px-2.5 py-1 rounded-lg bg-rose-600 text-white text-xs font-bold shadow-xs">
								Diskon
							</span>
						<?php endif; ?>
					</div>

					<!-- Card Body Details -->
					<div class="p-5 flex-1 flex flex-col justify-between">
						<div>
							<h3 class="text-base sm:text-lg font-bold text-slate-900 group-hover:text-sky-600 transition-colors line-clamp-2 leading-snug font-display">
								<?= $pro->nama; ?>
							</h3>

							<!-- Pricing -->
							<div class="mt-2.5 flex items-baseline space-x-2">
								<span class="text-lg sm:text-xl font-extrabold text-emerald-600 font-display">
									<?= rupiah($pro->harga - $harga_potongan); ?>
								</span>
								<?php if ($pro->potongan != 0) : ?>
									<span class="text-xs sm:text-sm text-slate-400 line-through">
										<?= rupiah($pro->harga); ?>
									</span>
								<?php endif; ?>
							</div>

							<!-- Pelapak info -->
							<div class="mt-2 flex items-center text-xs sm:text-sm text-slate-500 space-x-1.5">
								<i class="fa-solid fa-circle-user text-slate-400"></i>
								<span class="font-medium truncate"><?= $pro->pelapak ?? 'Pemerintah Desa'; ?></span>
							</div>
						</div>

						<!-- Action Buttons Bar -->
						<div class="mt-4 pt-3.5 border-t border-slate-100 flex items-center gap-2 flex-wrap">
							<?php if ($pro->telepon) : ?>
								<?php $pesan = strReplaceArrayRecursive(['[nama_produk]' => $pro->nama, '[link_web]' => base_url('lapak'), '<br />' => '%0A'], nl2br($this->setting->pesan_singkat_wa)); ?>
								<a href="https://api.whatsapp.com/send?phone=<?= format_telpon($pro->telepon); ?>&amp;text=<?= $pesan; ?>" target="_blank" rel="noopener noreferrer" class="flex-1 inline-flex items-center justify-center space-x-1.5 px-3 py-2 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs sm:text-sm shadow-xs transition-colors text-decoration-none">
									<i class="fa-brands fa-whatsapp text-sm"></i>
									<span>Beli via WA</span>
								</a>
							<?php endif; ?>

							<a href="javascript:void(0)" class="lokasi-pelapak px-3 py-2 rounded-xl border border-slate-200 text-slate-700 hover:bg-slate-50 text-xs sm:text-sm font-semibold transition-colors flex items-center space-x-1 text-decoration-none" data-remote="false" data-toggle="modal" data-target="#map-modal" data-lat="<?= $pro->lat ?>" data-lng="<?= $pro->lng ?>" data-zoom="<?= $pro->zoom ?>" data-title="Lokasi Pelapak (<?= $pro->pelapak ?>)">
								<i class="fa-solid fa-map-location-dot text-amber-500"></i>
								<span class="hidden sm:inline">Lokasi</span>
							</a>

							<a href="javascript:void(0)" class="px-3 py-2 rounded-xl border border-slate-200 text-slate-700 hover:bg-slate-50 text-xs sm:text-sm font-semibold transition-colors flex items-center space-x-1 text-decoration-none" data-remote="false" data-toggle="modal" data-target="#descModal<?= ($in); ?>">
								<i class="fa-solid fa-circle-info text-sky-500"></i>
								<span class="hidden sm:inline">Info</span>
							</a>
						</div>

					</div>

				</div>

				<!-- Modal Deskripsi Detail Produk -->
				<div class="modal fade" id="descModal<?= ($in); ?>" tabindex="-1" role="dialog" aria-labelledby="descModalLabel<?= ($in); ?>" aria-hidden="true">
					<div class="modal-dialog modal-dialog-centered">
						<div class="modal-content !rounded-2xl !border-0 !shadow-2xl overflow-hidden">
							<div class="modal-header bg-slate-900 text-white p-5 flex items-center justify-between">
								<h4 class="text-base sm:text-lg font-bold font-display text-white">
									<?= $pro->nama; ?>
								</h4>
								<button type="button" class="close text-white opacity-80 hover:opacity-100" data-dismiss="modal" aria-hidden="true">&times;</button>
							</div>
							<div class="modal-body p-6 space-y-4">
								<div>
									<span class="text-xs font-bold uppercase tracking-wider text-slate-400 block mb-1">Deskripsi Produk</span>
									<div class="text-sm sm:text-base text-slate-700 leading-relaxed bg-slate-50 p-4 rounded-xl border border-slate-200">
										<?= nl2br($pro->deskripsi ?: 'Tidak ada deskripsi rinci untuk produk ini.'); ?>
									</div>
								</div>
								<div class="grid grid-cols-2 gap-4 text-sm bg-sky-50/60 p-4 rounded-xl border border-sky-100">
									<div>
										<span class="text-xs text-slate-500 block">Pelapak:</span>
										<span class="font-bold text-slate-900"><?= $pro->pelapak ?? 'ADMIN'; ?></span>
									</div>
									<div>
										<span class="text-xs text-slate-500 block">Kontak WhatsApp:</span>
										<span class="font-bold text-slate-900"><?= $pro->telepon ?? '-'; ?></span>
									</div>
								</div>
							</div>
							<div class="modal-footer bg-slate-50 p-4 border-t border-slate-100">
								<button type="button" class="px-5 py-2 rounded-xl bg-slate-200 hover:bg-slate-300 text-slate-700 text-sm font-semibold transition-colors" data-dismiss="modal">Tutup</button>
							</div>
						</div>
					</div>
				</div>

			<?php endforeach; ?>
		</div>

		<!-- Pagination Area -->
		<?php if ($paging->num_rows > $paging->per_page) : ?>
			<div class="pt-6 border-t border-slate-200 flex flex-col sm:flex-row items-center justify-between gap-4">
				<div class="text-sm font-semibold text-slate-500">
					Halaman <span class="text-slate-900 font-bold"><?= $paging->page ?></span> dari <span class="text-slate-900 font-bold"><?= $paging->end_link ?></span>
				</div>
				<ul class="flex items-center space-x-1.5 list-none m-0 p-0">
					<?php if ($paging->start_link) : ?>
						<li><a href="<?= site_url("{$paging_page}/{$paging->start_link}" . $paging->suffix); ?>" class="px-3.5 py-2 rounded-xl border border-slate-200 bg-white text-slate-700 hover:bg-slate-50 text-sm font-semibold text-decoration-none"><i class="fa-solid fa-angles-left"></i></a></li>
					<?php endif; ?>
					<?php if ($paging->prev) : ?>
						<li><a href="<?= site_url("{$paging_page}/{$paging->prev}" . $paging->suffix); ?>" class="px-3.5 py-2 rounded-xl border border-slate-200 bg-white text-slate-700 hover:bg-slate-50 text-sm font-semibold text-decoration-none"><i class="fa-solid fa-angle-left"></i></a></li>
					<?php endif; ?>
					<?php for ($i = $paging->start_link; $i <= $paging->end_link; $i++) : ?>
						<li>
							<a href="<?= site_url("{$paging_page}/{$i}" . $paging->suffix); ?>" class="px-3.5 py-2 rounded-xl border text-sm font-bold text-decoration-none <?= ($paging->page == $i) ? 'bg-sky-600 text-white border-sky-600 shadow-2xs' : 'border-slate-200 bg-white text-slate-700 hover:bg-slate-50' ?>">
								<?= $i ?>
							</a>
						</li>
					<?php endfor; ?>
					<?php if ($paging->next) : ?>
						<li><a href="<?= site_url("{$paging_page}/{$paging->next}" . $paging->suffix); ?>" class="px-3.5 py-2 rounded-xl border border-slate-200 bg-white text-slate-700 hover:bg-slate-50 text-sm font-semibold text-decoration-none"><i class="fa-solid fa-angle-right"></i></a></li>
					<?php endif; ?>
					<?php if ($paging->end_link) : ?>
						<li><a href="<?= site_url("{$paging_page}/{$paging->end_link}" . $paging->suffix); ?>" class="px-3.5 py-2 rounded-xl border border-slate-200 bg-white text-slate-700 hover:bg-slate-50 text-sm font-semibold text-decoration-none"><i class="fa-solid fa-angles-right"></i></a></li>
					<?php endif; ?>
				</ul>
			</div>
		<?php endif; ?>

	<?php else : ?>
		<!-- Empty State Modern -->
		<div class="py-16 text-center">
			<div class="w-16 h-16 rounded-2xl bg-sky-50 text-sky-500 flex items-center justify-center text-3xl mx-auto mb-4 border border-sky-100">
				<i class="fa-solid fa-store"></i>
			</div>
			<h3 class="text-lg sm:text-xl font-bold font-display text-slate-800">
				Belum Ada Produk Lapak
			</h3>
			<p class="text-sm sm:text-base text-slate-500 mt-1 max-w-md mx-auto">
				Saat ini belum ada produk warga yang ditawarkan di kategori ini. Silakan coba kembali nanti atau pilih kategori lain.
			</p>
		</div>
	<?php endif; ?>

</div>

<!-- Modal Lokasi Map Leaflet -->
<div class="modal fade" id="map-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-lg">
		<div class="modal-content !rounded-2xl !border-0 !shadow-2xl overflow-hidden">
			<div class="modal-header bg-slate-900 text-white p-5 flex items-center justify-between">
				<h4 class="modal-title text-base sm:text-lg font-bold font-display text-white"></h4>
				<button type="button" class="close text-white opacity-80 hover:opacity-100" data-dismiss="modal" aria-hidden="true">&times;</button>
			</div>
			<div class="modal-body p-0">
			</div>
		</div>
	</div>
</div>

<script src="<?= base_url('assets/js/mapbox-gl.js'); ?>"></script>
<script src="<?= base_url('assets/js/leaflet.js'); ?>"></script>
<script src="<?= base_url('assets/js/leaflet-providers.js'); ?>"></script>
<script src="<?= base_url('assets/js/leaflet-mapbox-gl.js'); ?>"></script>
<script src="<?= asset('js/peta.js')?>"></script>
<script type="text/javascript">
	$(document).ready(function() {
		var MAPBOX_KEY = '<?= setting('mapbox_key') ?>';
		var JENIS_PETA = '<?= setting('jenis_peta') ?>';

        var options = {
            maxZoom: <?= setting('max_zoom_peta') ?>,
            minZoom: <?= setting('min_zoom_peta') ?>,
        };

		$(document).on('shown.bs.modal', '#map-modal', function(event) {
			let link = $(event.relatedTarget);
			let title = link.data('title');
			let modal = $(this);
			modal.find('.modal-title').text(title);
			modal.find('.modal-body').html("<div id='map' style='width: 100%; height:380px;'></div>");

			let posisi = [link.data('lat'), link.data('lng')];
			let zoom = link.data('zoom');
			let logo = L.icon({
				iconUrl: "<?= base_url('assets/images/gis/point/fastfood.png'); ?>",
			});

			$("#lat").val(link.data('lat'));
			$("#lng").val(link.data('lng'));

			pelapak = L.map('map', options).setView(posisi, zoom);
			getBaseLayers(pelapak, MAPBOX_KEY, JENIS_PETA);

			pelapak.addLayer(new L.Marker(posisi, {
				icon: logo
			}));
		});
	});
</script>