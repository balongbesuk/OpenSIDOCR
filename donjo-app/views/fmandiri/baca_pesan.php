<?php

defined('BASEPATH') || exit('No direct script access allowed');

/*
 * File ini:
 *
 * View modul Layanan Mandiri > Pesan > Baca Pesan
 * Redesigned with Next-Gen UI/UX Pro Max (Tema Desa Balongbesuk)
 *
 * donjo-app/views/fmandiri/baca_pesan.php
 */
?>

<!-- ========================================================================
     PAGE TITLE & BREADCRUMB CARD
     ======================================================================== -->
<div class="relative bg-white rounded-2xl border border-slate-200/80 p-5 sm:p-6 mb-6 shadow-xs overflow-hidden flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
	
	<!-- Left: Big Orange Icon + Title & Breadcrumb -->
	<div class="flex items-center space-x-4 z-10">
		<div class="w-12 h-12 sm:w-14 sm:h-14 rounded-2xl bg-orange-500 text-white flex items-center justify-center text-xl sm:text-2xl shadow-sm flex-shrink-0">
			<i class="fa-solid fa-envelope-open-text"></i>
		</div>
		<div>
			<h2 class="text-2xl sm:text-3xl font-extrabold font-display text-slate-900 leading-tight">
				Detail Pesan
			</h2>
			<nav class="flex items-center space-x-2 text-sm text-slate-400 font-medium mt-1">
				<a href="<?= site_url('layanan-mandiri/beranda') ?>" class="hover:text-orange-600 transition-colors text-decoration-none text-slate-400">Beranda</a>
				<span>&rsaquo;</span>
				<a href="<?= site_url("layanan-mandiri/{$tujuan}") ?>" class="hover:text-orange-600 transition-colors text-decoration-none text-slate-400"><?= ucwords(spaceunpenetration($tujuan)); ?></a>
				<span>&rsaquo;</span>
				<span class="text-slate-600 font-semibold truncate max-w-[200px] sm:max-w-xs"><?= $pesan['subjek']; ?></span>
			</nav>
		</div>
	</div>

	<!-- Right: Back Button -->
	<div class="flex items-center space-x-3 w-full sm:w-auto">
		<a href="<?= site_url("layanan-mandiri/{$tujuan}"); ?>" class="w-full sm:w-auto inline-flex items-center justify-center space-x-2 px-4 py-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-sm font-semibold transition-all text-decoration-none border border-slate-200/80">
			<i class="fa-solid fa-arrow-left text-xs"></i>
			<span>Kembali</span>
		</a>
	</div>

</div>

<!-- ========================================================================
     MESSAGE VIEW CARD CONTAINER
     ======================================================================== -->
<div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs p-6 sm:p-8 mb-6 max-w-4xl">

	<form id="validasi" action="<?= site_url('layanan-mandiri/pesan/balas'); ?>" method="post">
		
		<!-- Message Card Body -->
		<div class="rounded-2xl bg-slate-50/80 border border-slate-200/80 overflow-hidden">
			
			<!-- Sender & Timestamp Header -->
			<div class="p-4 sm:p-5 bg-white border-b border-slate-100 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3">
				<div class="flex items-center space-x-3.5">
					<div class="w-11 h-11 rounded-full bg-orange-100 text-orange-600 flex items-center justify-center font-bold text-base shadow-2xs">
						<i class="fa-solid fa-user"></i>
					</div>
					<div>
						<h4 class="font-bold text-slate-900 text-base leading-tight"><?= $pesan['owner']; ?></h4>
						<span class="text-xs sm:text-sm text-slate-400 font-medium"><?= $owner; ?></span>
					</div>
				</div>

				<div class="inline-flex items-center space-x-1.5 px-3 py-1 rounded-full bg-slate-100 text-slate-500 text-xs font-semibold">
					<i class="fa-regular fa-clock text-slate-400"></i>
					<span><?= tgl_indo2($pesan['tgl_upload']); ?></span>
				</div>
			</div>

			<!-- Subject & Text Content -->
			<div class="p-5 sm:p-7 space-y-4">
				<div class="border-b border-slate-200/60 pb-3">
					<span class="text-xs font-bold uppercase tracking-wider text-slate-400 block mb-1">Subjek</span>
					<h3 class="text-lg sm:text-xl font-extrabold font-display text-slate-900"><?= $pesan['subjek']; ?></h3>
				</div>

				<div class="text-sm sm:text-base text-slate-800 leading-relaxed whitespace-pre-wrap py-2 font-normal">
					<?= nl2br(htmlspecialchars($pesan['komentar'])); ?>
				</div>

				<?php if (!empty($pesan['permohonan']) && !empty($permohonan)): ?>
					<?php 
						$status_permohonan_text = \App\Models\PermohonanSurat::STATUS_PERMOHONAN[$permohonan['status']] ?? 'Menunggu';
						$format_surat_info = \App\Models\FormatSurat::find($permohonan['id_surat']);
					?>
					<div class="mt-4 p-4 rounded-xl bg-slate-100 border border-slate-200/80 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3">
						<div class="flex items-center space-x-3">
							<div class="w-10 h-10 rounded-xl bg-emerald-100 text-emerald-700 flex items-center justify-center text-lg flex-shrink-0">
								<i class="fa-solid fa-file-lines"></i>
							</div>
							<div>
								<p class="text-[11px] text-slate-400 font-bold uppercase tracking-wider">Terkait Surat</p>
								<p class="text-sm font-bold text-slate-900"><?= $format_surat_info->nama ?? 'Surat Permohonan'; ?></p>
								<p class="text-xs text-slate-500 font-mono">Antrean: <?= get_antrian($permohonan['no_antrian']) ?: ('#' . $permohonan['id']); ?></p>
							</div>
						</div>
						<div class="flex items-center space-x-2">
							<span class="px-3 py-1 rounded-full text-xs font-bold bg-white text-slate-700 border border-slate-200">
								Status: <strong><?= $status_permohonan_text; ?></strong>
							</span>
							<a href="<?= site_url('layanan-mandiri/permohonan-surat'); ?>" class="px-3 py-1.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold text-decoration-none transition-colors">
								Lihat Status &rarr;
							</a>
						</div>
					</div>
				<?php endif; ?>

			</div>

		</div>

		<input type="hidden" name="subjek" value="<?= $pesan['subjek']; ?>">

		<!-- Reply Action Footer -->
		<?php if ($kat == 2): ?>
			<div class="mt-6 pt-5 border-t border-slate-100 flex flex-wrap items-center gap-3">
				<button type="submit" class="inline-flex items-center space-x-2 px-6 py-3 rounded-xl bg-orange-500 hover:bg-orange-600 text-white text-sm sm:text-base font-bold shadow-xs transition-all cursor-pointer">
					<i class="fa-solid fa-reply text-xs"></i>
					<span>Balas Pesan Ini</span>
				</button>

				<?php if ($pesan['permohonan'] && $permohonan['status'] == 0): ?>
					<a href="<?= site_url("layanan-mandiri/surat/buat/{$pesan['permohonan']}"); ?>" class="inline-flex items-center space-x-2 px-6 py-3 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-sm sm:text-base font-bold shadow-xs transition-all text-decoration-none">
						<i class="fa-solid fa-file-circle-check text-xs"></i>
						<span>Lengkapi Permohonan Surat</span>
					</a>
				<?php endif; ?>
			</div>
		<?php endif; ?>

	</form>

</div>
