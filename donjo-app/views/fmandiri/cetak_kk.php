<?php

defined('BASEPATH') || exit('No direct script access allowed');

/*
 * File ini:
 *
 * View Cetak Salinan Kartu Keluarga Terintegrasi Layanan Mandiri
 * donjo-app/views/fmandiri/cetak_kk.php
 */
?>

<!-- ========================================================================
     TOP ACTION TOOLBAR (Disembunyikan saat cetak)
     ======================================================================== -->
<div class="no-print flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6">
	<div>
		<div class="flex items-center space-x-2 text-xs font-semibold text-slate-400 mb-1">
			<a href="<?= site_url('layanan-mandiri/beranda') ?>" class="hover:text-indigo-600 transition-colors text-decoration-none text-slate-400">Beranda</a>
			<span>&rsaquo;</span>
			<a href="<?= site_url('layanan-mandiri/profil') ?>" class="hover:text-indigo-600 transition-colors text-decoration-none text-slate-400">Profil</a>
			<span>&rsaquo;</span>
			<span class="text-slate-600 font-bold">Cetak Salinan KK</span>
		</div>
		<h1 class="text-xl sm:text-2xl font-black text-slate-800 tracking-tight flex items-center gap-2">
			<i class="fa-solid fa-file-contract text-emerald-600"></i>
			<span>Salinan Kartu Keluarga</span>
		</h1>
		<p class="text-xs sm:text-sm text-slate-500 mt-0.5">
			Pratinjau lembar salinan resmi Kartu Keluarga (KK) di dalam aplikasi Layanan Mandiri.
		</p>
	</div>

	<!-- Action Buttons -->
	<div class="flex items-center gap-2.5">
		<a href="<?= site_url('layanan-mandiri/profil') ?>" class="px-4 py-2.5 rounded-xl bg-white hover:bg-slate-100 border border-slate-200 text-slate-700 font-bold text-xs sm:text-sm shadow-2xs transition-all flex items-center space-x-2 text-decoration-none">
			<i class="fa-solid fa-arrow-left text-xs text-slate-400"></i>
			<span>Kembali</span>
		</a>

		<button type="button" onclick="window.print()" class="px-5 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 active:bg-emerald-800 text-white font-bold text-xs sm:text-sm shadow-md shadow-emerald-500/20 transition-all flex items-center space-x-2 cursor-pointer border-none">
			<i class="fa-solid fa-print"></i>
			<span>Cetak Salinan KK</span>
		</button>
	</div>
</div>

<!-- ========================================================================
     DOCUMENT SHEET CANVAS (Hanya bagian ini yang tercetak saat print)
     ======================================================================== -->
<div class="print-container">
	<div id="print-area" class="bg-white rounded-2xl sm:rounded-3xl border border-slate-200/90 shadow-xl p-6 sm:p-8 lg:p-10 max-w-5xl mx-auto text-slate-900 overflow-x-auto">

		<!-- Header Salinan KK Resmi -->
		<div class="text-center mb-6">
			<h2 class="text-lg sm:text-2xl font-black tracking-wider text-slate-900 mb-0.5">
				KARTU KELUARGA
			</h2>
			<h3 class="text-xs sm:text-sm font-bold uppercase tracking-widest text-slate-600 mb-1">
				SALINAN DESA
			</h3>
			<p class="text-xs sm:text-base font-black tracking-widest text-slate-900">
				No. <?= get_nokk($kepala_kk['no_kk']) ?>
			</p>
		</div>

		<!-- Tabel Informasi Wilayah & Kepala Keluarga -->
		<div class="mb-5 text-xs sm:text-sm">
			<table class="w-full border-none">
				<tbody>
					<tr>
						<td class="w-36 sm:w-44 font-semibold text-slate-600 py-0.5">Nama Kepala Keluarga</td>
						<td class="w-4 py-0.5">:</td>
						<td class="font-bold text-slate-900 py-0.5"><?= strtoupper($kepala_kk['nama']) ?></td>
						<td class="w-36 sm:w-44 font-semibold text-slate-600 py-0.5"><?= ucwords(setting('sebutan_desa')) ?></td>
						<td class="w-4 py-0.5">:</td>
						<td class="font-bold text-slate-900 py-0.5"><?= strtoupper($desa['nama_desa']) ?></td>
					</tr>
					<tr>
						<td class="font-semibold text-slate-600 py-0.5">Alamat</td>
						<td class="py-0.5">:</td>
						<td class="text-slate-800 py-0.5"><?= strtoupper($kepala_kk['alamat_plus_dusun']) ?></td>
						<td class="font-semibold text-slate-600 py-0.5"><?= ucwords(setting('sebutan_kecamatan')) ?></td>
						<td class="py-0.5">:</td>
						<td class="text-slate-800 py-0.5"><?= strtoupper($desa['nama_kecamatan']) ?></td>
					</tr>
					<tr>
						<td class="font-semibold text-slate-600 py-0.5">RT / RW</td>
						<td class="py-0.5">:</td>
						<td class="text-slate-800 py-0.5"><?= $kepala_kk['rt'] ?> / <?= $kepala_kk['rw'] ?></td>
						<td class="font-semibold text-slate-600 py-0.5"><?= ucwords(setting('sebutan_kabupaten_singkat')) ?></td>
						<td class="py-0.5">:</td>
						<td class="text-slate-800 py-0.5"><?= strtoupper($desa['nama_kabupaten']) ?></td>
					</tr>
					<tr>
						<td class="font-semibold text-slate-600 py-0.5">Kode Pos</td>
						<td class="py-0.5">:</td>
						<td class="text-slate-800 py-0.5"><?= strtoupper($desa['kode_pos'] ?: '-') ?></td>
						<td class="font-semibold text-slate-600 py-0.5">Provinsi</td>
						<td class="py-0.5">:</td>
						<td class="text-slate-800 py-0.5"><?= strtoupper($desa['nama_propinsi']) ?></td>
					</tr>
				</tbody>
			</table>
		</div>

		<!-- TABEL 1: DATA PERSONAL ANGGOTA KELUARGA -->
		<div class="mb-5 overflow-x-auto">
			<table class="w-full text-[11px] sm:text-xs border-collapse border border-slate-400 text-center">
				<thead class="bg-slate-100 font-bold text-slate-800">
					<tr class="border-b border-slate-400">
						<th class="border-r border-slate-400 py-2 px-1 w-8">No</th>
						<th class="border-r border-slate-400 py-2 px-2 text-left">Nama Lengkap</th>
						<th class="border-r border-slate-400 py-2 px-2">NIK</th>
						<th class="border-r border-slate-400 py-2 px-1">Jenis Kelamin</th>
						<th class="border-r border-slate-400 py-2 px-2">Tempat Lahir</th>
						<th class="border-r border-slate-400 py-2 px-2">Tanggal Lahir</th>
						<th class="border-r border-slate-400 py-2 px-1">Agama</th>
						<th class="border-r border-slate-400 py-2 px-2">Pendidikan</th>
						<th class="border-r border-slate-400 py-2 px-2">Jenis Pekerjaan</th>
						<th class="py-2 px-1 w-12">Gol. Darah</th>
					</tr>
				</thead>
				<tbody class="divide-y divide-slate-300">
					<?php foreach ($main as $key => $data) : ?>
						<tr class="hover:bg-slate-50/70">
							<td class="border-r border-slate-300 py-1.5 px-1 font-semibold"><?= $key + 1 ?></td>
							<td class="border-r border-slate-300 py-1.5 px-2 text-left font-bold text-slate-900"><?= strtoupper($data['nama']) ?></td>
							<td class="border-r border-slate-300 py-1.5 px-2 font-mono"><?= $data['nik'] ?></td>
							<td class="border-r border-slate-300 py-1.5 px-1"><?= $data['sex'] ?></td>
							<td class="border-r border-slate-300 py-1.5 px-2"><?= strtoupper($data['tempatlahir']) ?></td>
							<td class="border-r border-slate-300 py-1.5 px-2"><?= tgl_indo_out($data['tanggallahir']) ?></td>
							<td class="border-r border-slate-300 py-1.5 px-1"><?= $data['agama'] ?></td>
							<td class="border-r border-slate-300 py-1.5 px-2"><?= $data['pendidikan'] ?></td>
							<td class="border-r border-slate-300 py-1.5 px-2"><?= $data['pekerjaan'] ?></td>
							<td class="py-1.5 px-1 font-bold"><?= $data['golongan_darah'] ?: '-' ?></td>
						</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
		</div>

		<!-- TABEL 2: STATUS & HUBUNGAN KELUARGA -->
		<div class="mb-8 overflow-x-auto">
			<table class="w-full text-[11px] sm:text-xs border-collapse border border-slate-400 text-center">
				<thead class="bg-slate-100 font-bold text-slate-800">
					<tr class="border-b border-slate-400">
						<th class="border-r border-slate-400 py-2 px-1 w-8">No</th>
						<th class="border-r border-slate-400 py-2 px-2">Status Perkawinan</th>
						<th class="border-r border-slate-400 py-2 px-2">Tgl. Perkawinan</th>
						<th class="border-r border-slate-400 py-2 px-2">Hubungan Keluarga</th>
						<th class="border-r border-slate-400 py-2 px-1">Kewarganegaraan</th>
						<th class="border-r border-slate-400 py-2 px-2">No. Paspor</th>
						<th class="border-r border-slate-400 py-2 px-2">No. KITAS / KITAP</th>
						<th class="border-r border-slate-400 py-2 px-2 text-left">Nama Ayah</th>
						<th class="py-2 px-2 text-left">Nama Ibu</th>
					</tr>
				</thead>
				<tbody class="divide-y divide-slate-300">
					<?php foreach ($main as $key => $data) : ?>
						<tr class="hover:bg-slate-50/70">
							<td class="border-r border-slate-300 py-1.5 px-1 font-semibold"><?= $key + 1 ?></td>
							<td class="border-r border-slate-300 py-1.5 px-2"><?= $data['status_kawin'] ?></td>
							<td class="border-r border-slate-300 py-1.5 px-2"><?= tgl_indo_out($data['tanggalperkawinan']) ?: '-' ?></td>
							<td class="border-r border-slate-300 py-1.5 px-2 font-semibold text-slate-900"><?= $data['hubungan'] ?></td>
							<td class="border-r border-slate-300 py-1.5 px-1"><?= $data['warganegara'] ?></td>
							<td class="border-r border-slate-300 py-1.5 px-2 font-mono"><?= $data['dokumen_pasport'] ?: '-' ?></td>
							<td class="border-r border-slate-300 py-1.5 px-2 font-mono"><?= $data['dokumen_kitas'] ?: '-' ?></td>
							<td class="border-r border-slate-300 py-1.5 px-2 text-left"><?= strtoupper($data['nama_ayah'] ?: '-') ?></td>
							<td class="py-1.5 px-2 text-left"><?= strtoupper($data['nama_ibu'] ?: '-') ?></td>
						</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
		</div>

		<!-- TANDA TANGAN PENGESAHAN -->
		<div class="pt-6 border-t border-slate-300">
			<div class="grid grid-cols-2 text-center text-xs sm:text-sm">
				<div>
					<p class="text-slate-600 font-semibold mb-1">Kepala Keluarga,</p>
					<div class="h-24 sm:h-28"></div>
					<p class="font-bold uppercase text-slate-900 border-b border-slate-900 inline-block px-4">
						<?= strtoupper($kepala_kk['nama']) ?>
					</p>
				</div>

				<div>
					<p class="text-slate-600 font-semibold mb-1">
						<?= ucwords(setting('sebutan_desa') . ' ' . $desa['nama_desa']) ?>, <?= tgl_indo(date('Y-m-d')) ?>
					</p>
					<p class="text-slate-700 font-semibold">
						<?= ucwords(setting('sebutan_kepala_desa') . ' ' . $desa['nama_desa']) ?>
					</p>
					<div class="h-20 sm:h-24"></div>
					<p class="font-bold uppercase text-slate-900 border-b border-slate-900 inline-block px-4">
						<?= strtoupper($desa['nama_kepala_desa'] ?: 'KEPALA DESA') ?>
					</p>
				</div>
			</div>
		</div>

	</div>
</div>

<!-- ========================================================================
     SCOPED PRINT CSS STYLES
     ======================================================================== -->
<style>
@media print {
	/* Sembunyikan elemen navigasi aplikasi Layanan Mandiri */
	header, nav, aside, footer, .no-print, .mobile-dock, #navbar, #sidebar {
		display: none !important;
	}
	body {
		background: #ffffff !important;
		margin: 0 !important;
		padding: 0 !important;
	}
	main {
		padding: 0 !important;
		margin: 0 !important;
		overflow: visible !important;
	}
	.print-container {
		width: 100% !important;
		margin: 0 !important;
		padding: 0 !important;
	}
	#print-area {
		border: none !important;
		box-shadow: none !important;
		border-radius: 0 !important;
		padding: 0 !important;
		margin: 0 !important;
		max-width: 100% !important;
		width: 100% !important;
	}
}
</style>
