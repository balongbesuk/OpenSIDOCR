<?php

defined('BASEPATH') || exit('No direct script access allowed');

/*
 * File ini:
 *
 * View modul Layanan Mandiri > Pesan > Tulis Pesan
 * Redesigned with Next-Gen UI/UX Pro Max (Tema Desa Balongbesuk)
 *
 * donjo-app/views/fmandiri/tulis_pesan.php
 */
?>

<!-- ========================================================================
     PAGE TITLE & BREADCRUMB CARD
     ======================================================================== -->
<div class="relative bg-white rounded-2xl border border-slate-200/80 p-5 sm:p-6 mb-6 shadow-xs overflow-hidden flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
	
	<!-- Left: Big Orange Icon + Title & Breadcrumb -->
	<div class="flex items-center space-x-4 z-10">
		<div class="w-12 h-12 sm:w-14 sm:h-14 rounded-2xl bg-orange-500 text-white flex items-center justify-center text-xl sm:text-2xl shadow-sm flex-shrink-0">
			<i class="fa-solid fa-pen-to-square"></i>
		</div>
		<div>
			<h2 class="text-2xl sm:text-3xl font-extrabold font-display text-slate-900 leading-tight">
				<?= ($kat == 2) ? 'Balas Pesan' : 'Tulis Pesan Baru'; ?>
			</h2>
			<nav class="flex items-center space-x-2 text-sm text-slate-400 font-medium mt-1">
				<a href="<?= site_url('layanan-mandiri/beranda') ?>" class="hover:text-orange-600 transition-colors text-decoration-none text-slate-400">Beranda</a>
				<span>&rsaquo;</span>
				<a href="<?= site_url("layanan-mandiri/{$tujuan}") ?>" class="hover:text-orange-600 transition-colors text-decoration-none text-slate-400"><?= ucwords(spaceunpenetration($tujuan)); ?></a>
				<span>&rsaquo;</span>
				<span class="text-slate-600 font-semibold"><?= ($kat == 2) ? 'Balas' : 'Tulis Baru'; ?></span>
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
     FORM CARD CONTAINER
     ======================================================================== -->
<div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs p-6 sm:p-8 mb-6 max-w-4xl">

	<?php if (($notif = session('notif')) && ($data = session('notif')['data'])) : ?>
		<div class="mb-6 p-4 rounded-xl bg-rose-50 border border-rose-200 text-rose-700 text-sm flex items-start space-x-3">
			<i class="fa-solid fa-triangle-exclamation text-rose-500 mt-0.5 text-base flex-shrink-0"></i>
			<div>
				<p class="font-bold text-rose-900">Perhatian</p>
				<p class="text-xs sm:text-sm mt-0.5"><?= $notif['pesan']; ?></p>
			</div>
		</div>
	<?php endif; ?>

	<form id="validasi" action="<?= site_url('layanan-mandiri/pesan/kirim'); ?>" method="post" class="space-y-6">
		
		<!-- Subjek Input -->
		<div class="space-y-2">
			<label for="subjek" class="block text-sm sm:text-base font-bold text-slate-700">
				Subjek / Perihal Pesan <span class="text-rose-500">*</span>
			</label>
			<input type="text" id="subjek" class="w-full px-4 py-3.5 rounded-xl border border-slate-300 bg-white text-slate-900 text-sm sm:text-base focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 outline-none transition-all required <?= jecho($cek_anjungan['keyboard'] == 1, true, 'kbvtext'); ?>" name="subjek" placeholder="Contoh: Pertanyaan Status Surat Keterangan Usaha" value="<?= $subjek ?? $data['subjek']; ?>" <?= jecho($kat, 2, 'readonly'); ?>>
			<p class="text-xs text-slate-400">Ringkasan topik permohonan atau pertanyaan yang ingin Anda sampaikan.</p>
		</div>

		<!-- Isi Pesan Textarea -->
		<div class="space-y-2">
			<label for="pesan" class="block text-sm sm:text-base font-bold text-slate-700">
				Isi Pesan <span class="text-rose-500">*</span>
			</label>
			<textarea id="pesan" rows="7" class="w-full p-4 rounded-xl border border-slate-300 bg-white text-slate-900 text-sm sm:text-base focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 outline-none transition-all required leading-relaxed <?= jecho($cek_anjungan['keyboard'] == 1, true, 'kbvtext'); ?>" name="pesan" placeholder="Tuliskan isi pesan, pertanyaan, atau koordinasi Anda secara lengkap dan jelas di sini..."><?= $data['pesan'] ?? '' ?></textarea>
		</div>

		<!-- Form Buttons -->
		<div class="pt-4 border-t border-slate-100 flex flex-col sm:flex-row items-center gap-3">
			<button type="submit" class="w-full sm:w-auto inline-flex items-center justify-center space-x-2 px-7 py-3 rounded-xl bg-orange-500 hover:bg-orange-600 text-white font-bold text-sm sm:text-base shadow-xs transition-all cursor-pointer">
				<i class="fa-solid fa-paper-plane text-xs"></i>
				<span>Kirim Pesan</span>
			</button>

			<a href="<?= site_url("layanan-mandiri/{$tujuan}"); ?>" class="w-full sm:w-auto inline-flex items-center justify-center px-6 py-3 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold text-sm sm:text-base transition-all text-decoration-none">
				Batal
			</a>
		</div>

	</form>

</div>
