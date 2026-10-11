<?php

defined('BASEPATH') || exit('No direct script access allowed');

/*
 * File ini:
 *
 * View modul Layanan Mandiri > Bantuan
 * Redesigned with Next-Gen UI/UX Pro Max (Tema Desa Balongbesuk)
 *
 * donjo-app/views/fmandiri/bantuan.php
 */
?>

<link rel="stylesheet" href="<?= asset('bootstrap/css/jquery-ui.min.css') ?>">
<script src="<?= asset('bootstrap/js/jquery-ui.min.js') ?>"></script>
<script>
	function show_kartu_peserta(elem) {
		var id = elem.attr('target');
		var title = elem.attr('title');
		var url = elem.attr('href');
		$('#'+id+'').remove();

		$('body').append('<div id="'+id+'" title="'+title+'" style="display:none;position:relative;overflow:scroll;"></div>');

		$('#'+id+'').dialog({
			resizable: true,
			draggable: true,
			width: 500,
			height: 'auto',
			open: function(event, ui) {
				$('#'+id+'').load(url);
			}
		});
		$('#'+id+'').dialog('open');
	}
</script>

<!-- ========================================================================
     PAGE TITLE & BREADCRUMB CARD
     ======================================================================== -->
<div class="relative bg-white rounded-2xl border border-slate-200/80 p-5 sm:p-6 mb-6 shadow-xs overflow-hidden flex items-center justify-between">
	
	<!-- Left: Big Emerald Icon + Title & Breadcrumb -->
	<div class="flex items-center space-x-4 z-10">
		<div class="w-12 h-12 sm:w-14 sm:h-14 rounded-2xl bg-emerald-600 text-white flex items-center justify-center text-xl sm:text-2xl shadow-sm flex-shrink-0">
			<i class="fa-solid fa-hand-holding-heart"></i>
		</div>
		<div>
			<h2 class="text-2xl sm:text-3xl font-extrabold font-display text-slate-900 leading-tight">
				Program Bantuan
			</h2>
			<nav class="flex items-center space-x-2 text-sm text-slate-400 font-medium mt-1">
				<a href="<?= site_url('layanan-mandiri/beranda') ?>" class="hover:text-emerald-600 transition-colors text-decoration-none text-slate-400">Beranda</a>
				<span>&rsaquo;</span>
				<span class="text-slate-600 font-semibold">Bantuan</span>
			</nav>
		</div>
	</div>

	<!-- Right: Subtle Status Indicator -->
	<div class="hidden sm:flex items-center space-x-2 bg-emerald-50 border border-emerald-200/70 text-emerald-800 px-4 py-2 rounded-xl text-sm font-semibold">
		<i class="fa-solid fa-shield-heart text-emerald-600"></i>
		<span>Jaminan Sosial Desa</span>
	</div>

</div>

<!-- ========================================================================
     DATA TABLE CARD CONTAINER
     ======================================================================== -->
<div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs p-5 sm:p-7 mb-6">
	
	<!-- Card Title & Subtitle -->
	<div class="mb-6">
		<h3 class="text-xl sm:text-2xl font-bold font-display text-slate-900 leading-tight">
			Daftar Bantuan Sosial Penduduk
		</h3>
		<p class="text-sm sm:text-base text-slate-500 mt-1">
			Berikut adalah daftar program bantuan pemerintah dan desa yang tercatat atas nama Anda atau keluarga.
		</p>
	</div>

	<!-- Table Content -->
	<div class="table-responsive overflow-x-auto">
		<table class="table table-bordered table-hover w-full datatable-polos">
			<thead>
				<tr class="bg-slate-50 text-slate-700 text-xs sm:text-sm font-bold uppercase tracking-wider">
					<th class="py-3.5 px-4 text-center" style="width: 50px;">No</th>
					<th class="py-3.5 px-4 text-center" style="width: 120px;">Aksi</th>
					<th class="py-3.5 px-4" style="width: 20%;">Waktu / Masa Berlaku</th>
					<th class="py-3.5 px-4" style="width: 25%;">Nama Program</th>
					<th class="py-3.5 px-4">Keterangan</th>
				</tr>
			</thead>
			<tbody>
				<?php if ($bantuan_penduduk):
					foreach ($bantuan_penduduk as $key => $item): ?>
						<tr class="text-sm sm:text-base">
							<td class="text-center font-semibold text-slate-500"><?= ($key + 1); ?></td>
							<td class="text-center whitespace-nowrap">
								<?php if ($item['no_id_kartu']) : ?>
									<div class="inline-flex items-center gap-1.5 justify-center">
										<button type="button" target="data_peserta" title="Data Peserta" href="<?= site_url(MANDIRI . "/bantuan/kartu_peserta/tampil/{$item['id']}")?>" onclick="show_kartu_peserta($(this));" class="w-9 h-9 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white flex items-center justify-center transition-colors shadow-2xs" title="Lihat Kartu Peserta">
											<i class="fa-solid fa-eye text-sm"></i>
										</button>
										<a href="<?= site_url(MANDIRI . "/bantuan/kartu_peserta/unduh/{$item['id']}")?>" class="w-9 h-9 rounded-xl bg-slate-800 hover:bg-slate-900 text-white flex items-center justify-center transition-colors shadow-2xs <?= empty($item['kartu_peserta']) ? 'opacity-50 pointer-events-none' : '' ?>" title="Unduh Kartu Peserta">
											<i class="fa-solid fa-download text-sm"></i>
										</a>
									</div>
								<?php else : ?>
									<span class="text-slate-400 text-xs">-</span>
								<?php endif; ?>
							</td>
							<td class="font-medium text-slate-700">
								<?= fTampilTgl($item['sdate'], $item['edate']); ?>
							</td>
							<td>
								<span class="font-bold text-slate-900 block"><?= $item['nama']; ?></span>
								<?php if ($item['no_id_kartu']) : ?>
									<span class="text-xs text-slate-500 font-mono">No ID: <?= $item['no_id_kartu']; ?></span>
								<?php endif; ?>
							</td>
							<td class="text-slate-600 leading-relaxed">
								<?= nl2br($item['ndesc'] ?: '-'); ?>
							</td>
						</tr>
					<?php endforeach;
				else: ?>
					<tr>
						<td class="text-center py-10 text-slate-400 font-medium" colspan="5">
							<div class="w-12 h-12 rounded-2xl bg-slate-100 text-slate-400 flex items-center justify-center text-2xl mx-auto mb-2">
								<i class="fa-solid fa-hand-holding-heart"></i>
							</div>
							Tidak ada data program bantuan yang terdaftar.
						</td>
					</tr>
				<?php endif; ?>
			</tbody>
		</table>
	</div>

</div>
