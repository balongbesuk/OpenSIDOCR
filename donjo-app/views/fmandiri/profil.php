<?php

defined('BASEPATH') || exit('No direct script access allowed');

/*
 * File ini:
 *
 * View modul Layanan Mandiri > Profil
 * Redesigned with Next-Gen UI/UX Pro Max (Tema Desa Balongbesuk)
 *
 * donjo-app/views/fmandiri/profil.php
 */
?>

<!-- ========================================================================
     PAGE TITLE & BREADCRUMB CARD
     ======================================================================== -->
<div class="relative bg-white rounded-2xl border border-slate-200/80 p-5 sm:p-6 mb-6 shadow-xs overflow-hidden flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
	
	<!-- Left: Icon + Title & Breadcrumb -->
	<div class="flex items-center space-x-4 z-10">
		<div class="w-12 h-12 sm:w-14 sm:h-14 rounded-2xl bg-indigo-600 text-white flex items-center justify-center text-xl sm:text-2xl shadow-sm flex-shrink-0">
			<i class="fa-solid fa-id-card-clip"></i>
		</div>
		<div>
			<h2 class="text-2xl sm:text-3xl font-extrabold font-display text-slate-900 leading-tight">
				Profil & Biodata Warga
			</h2>
			<nav class="flex items-center space-x-2 text-sm text-slate-400 font-medium mt-1">
				<a href="<?= site_url('layanan-mandiri/beranda') ?>" class="hover:text-indigo-600 transition-colors text-decoration-none text-slate-400">Beranda</a>
				<span>&rsaquo;</span>
				<span class="text-slate-600 font-semibold">Profil</span>
			</nav>
		</div>
	</div>

	<!-- Right: Cetak Biodata Action Button -->
	<div class="flex items-center space-x-2.5">
		<a href="<?= site_url('layanan-mandiri/cetak-biodata') ?>" target="_blank" rel="noopener noreferrer" class="px-5 py-2.5 rounded-xl bg-slate-900 hover:bg-slate-800 text-white font-bold text-sm sm:text-base shadow-xs transition-colors flex items-center space-x-2 text-decoration-none">
			<i class="fa-solid fa-print text-sm"></i>
			<span>Cetak Biodata</span>
		</a>
	</div>

</div>

<!-- ========================================================================
     TOP CITIZEN PROFILE OVERVIEW CARD
     ======================================================================== -->
<div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs p-6 sm:p-7 mb-6">
	<div class="flex flex-col sm:flex-row items-center sm:items-start gap-6">
		
		<!-- Avatar Foto -->
		<div class="relative">
			<img class="w-24 h-24 sm:w-28 sm:h-28 rounded-2xl object-cover border-2 border-slate-200 shadow-sm" src="<?= AmbilFoto($penduduk['foto'], '', $penduduk['id_sex']) ?>" alt="<?= $penduduk['nama'] ?>">
			<span class="absolute -bottom-2 -right-2 px-2.5 py-1 rounded-lg bg-emerald-600 text-white text-xs font-bold shadow-xs">
				<?= strtoupper($penduduk['status']); ?>
			</span>
		</div>

		<!-- Identity Info -->
		<div class="flex-1 text-center sm:text-left space-y-2">
			<div class="inline-flex items-center space-x-2 px-3 py-1 rounded-lg bg-indigo-50 border border-indigo-200/60 text-indigo-700 text-xs sm:text-sm font-semibold">
				<i class="fa-solid fa-fingerprint"></i>
				<span>NIK: <?= $penduduk['nik']; ?></span>
			</div>
			
			<h3 class="text-xl sm:text-2xl font-extrabold font-display text-slate-900 leading-tight">
				<?= strtoupper($penduduk['nama']); ?>
			</h3>

			<p class="text-sm sm:text-base text-slate-500 font-medium">
				No. Kartu Keluarga: <span class="font-bold text-slate-800 font-mono"><?= $penduduk['no_kk']; ?></span> &bull; Hubungan: <span class="font-bold text-slate-800"><?= $penduduk['hubungan']; ?></span>
			</p>
			
			<div class="flex items-center justify-center sm:justify-start gap-3 pt-1 text-xs sm:text-sm text-slate-600 flex-wrap">
				<span class="inline-flex items-center gap-1.5"><i class="fa-solid fa-venus-mars text-indigo-500"></i> <?= strtoupper($penduduk['sex']); ?></span>
				<span>&bull;</span>
				<span class="inline-flex items-center gap-1.5"><i class="fa-solid fa-cake-candles text-amber-500"></i> <?= strtoupper($penduduk['tempatlahir']); ?>, <?= strtoupper($penduduk['tanggallahir']); ?></span>
				<span>&bull;</span>
				<span class="inline-flex items-center gap-1.5"><i class="fa-solid fa-mosque text-emerald-500"></i> <?= strtoupper($penduduk['agama']); ?></span>
			</div>
		</div>

	</div>
</div>

<!-- ========================================================================
     DETAILED SECTIONS ACCORDION / MODERN CARDS
     ======================================================================== -->
<div class="space-y-6">

	<!-- 1. DATA DASAR & KELAHIRAN -->
	<div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden">
		<div class="px-6 py-4 bg-slate-50/80 border-b border-slate-200 flex items-center space-x-2.5">
			<i class="fa-solid fa-user-check text-indigo-600 text-base"></i>
			<h4 class="text-base sm:text-lg font-bold font-display text-slate-900">1. Data Dasar & Kelahiran</h4>
		</div>
		<div class="p-6">
			<div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-4 text-sm sm:text-base">
				<div class="flex justify-between py-2 border-b border-slate-100">
					<span class="text-slate-500 font-semibold">Status Rekam KTP</span>
					<span class="font-bold text-slate-900 text-right"><?= strtoupper($penduduk['status_rekam'] ?: '-'); ?></span>
				</div>
				<div class="flex justify-between py-2 border-b border-slate-100">
					<span class="text-slate-500 font-semibold">Tag ID Card</span>
					<span class="font-bold text-slate-900 text-right"><?= $penduduk['tag_id_card'] ?: '-'; ?></span>
				</div>
				<div class="flex justify-between py-2 border-b border-slate-100">
					<span class="text-slate-500 font-semibold">Akta Kelahiran</span>
					<span class="font-bold text-slate-900 text-right"><?= strtoupper($penduduk['akta_lahir'] ?: '-'); ?></span>
				</div>
				<div class="flex justify-between py-2 border-b border-slate-100">
					<span class="text-slate-500 font-semibold">Tempat Dilahirkan</span>
					<span class="font-bold text-slate-900 text-right"><?= $penduduk['tempat_dilahirkan_nama'] ?: '-'; ?></span>
				</div>
				<div class="flex justify-between py-2 border-b border-slate-100">
					<span class="text-slate-500 font-semibold">Jenis Kelahiran</span>
					<span class="font-bold text-slate-900 text-right"><?= $penduduk['jenis_kelahiran_nama'] ?: '-'; ?></span>
				</div>
				<div class="flex justify-between py-2 border-b border-slate-100">
					<span class="text-slate-500 font-semibold">Kelahiran Anak Ke</span>
					<span class="font-bold text-slate-900 text-right"><?= $penduduk['kelahiran_anak_ke'] ?: '-'; ?></span>
				</div>
				<div class="flex justify-between py-2 border-b border-slate-100">
					<span class="text-slate-500 font-semibold">Berat & Panjang Lahir</span>
					<span class="font-bold text-slate-900 text-right"><?= $penduduk['berat_lahir']; ?> Gram / <?= $penduduk['panjang_lahir']; ?> cm</span>
				</div>
				<div class="flex justify-between py-2 border-b border-slate-100">
					<span class="text-slate-500 font-semibold">Penolong Kelahiran</span>
					<span class="font-bold text-slate-900 text-right"><?= $penduduk['penolong_kelahiran_nama'] ?: '-'; ?></span>
				</div>
			</div>
		</div>
	</div>

	<!-- 2. PENDIDIKAN, PEKERJAAN & KEWARGANEGARAAN -->
	<div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden">
		<div class="px-6 py-4 bg-slate-50/80 border-b border-slate-200 flex items-center space-x-2.5">
			<i class="fa-solid fa-graduation-cap text-indigo-600 text-base"></i>
			<h4 class="text-base sm:text-lg font-bold font-display text-slate-900">2. Pendidikan, Pekerjaan & Kewarganegaraan</h4>
		</div>
		<div class="p-6">
			<div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-4 text-sm sm:text-base">
				<div class="flex justify-between py-2 border-b border-slate-100">
					<span class="text-slate-500 font-semibold">Pendidikan dalam KK</span>
					<span class="font-bold text-slate-900 text-right"><?= strtoupper($penduduk['pendidikan_kk'] ?: '-'); ?></span>
				</div>
				<div class="flex justify-between py-2 border-b border-slate-100">
					<span class="text-slate-500 font-semibold">Pendidikan Sedang Ditempuh</span>
					<span class="font-bold text-slate-900 text-right"><?= strtoupper($penduduk['pendidikan_sedang'] ?: '-'); ?></span>
				</div>
				<div class="flex justify-between py-2 border-b border-slate-100">
					<span class="text-slate-500 font-semibold">Pekerjaan</span>
					<span class="font-bold text-slate-900 text-right"><?= strtoupper($penduduk['pekerjaan'] ?: '-'); ?></span>
				</div>
				<div class="flex justify-between py-2 border-b border-slate-100">
					<span class="text-slate-500 font-semibold">Warganegara</span>
					<span class="font-bold text-slate-900 text-right"><?= strtoupper($penduduk['warganegara'] ?: '-'); ?></span>
				</div>
				<div class="flex justify-between py-2 border-b border-slate-100">
					<span class="text-slate-500 font-semibold">Nomor Paspor</span>
					<span class="font-bold text-slate-900 text-right"><?= strtoupper($penduduk['dokumen_pasport'] ?: '-'); ?></span>
				</div>
				<div class="flex justify-between py-2 border-b border-slate-100">
					<span class="text-slate-500 font-semibold">Nomor KITAS/KITAP</span>
					<span class="font-bold text-slate-900 text-right"><?= strtoupper($penduduk['dokumen_kitas'] ?: '-'); ?></span>
				</div>
			</div>
		</div>
	</div>

	<!-- 3. DATA ORANG TUA & ALAMAT -->
	<div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden">
		<div class="px-6 py-4 bg-slate-50/80 border-b border-slate-200 flex items-center space-x-2.5">
			<i class="fa-solid fa-users text-indigo-600 text-base"></i>
			<h4 class="text-base sm:text-lg font-bold font-display text-slate-900">3. Data Orang Tua & Alamat</h4>
		</div>
		<div class="p-6">
			<div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-4 text-sm sm:text-base">
				<div class="flex justify-between py-2 border-b border-slate-100">
					<span class="text-slate-500 font-semibold">NIK & Nama Ayah</span>
					<span class="font-bold text-slate-900 text-right"><?= strtoupper($penduduk['nama_ayah'] ?: '-'); ?> (<?= $penduduk['ayah_nik'] ?: '-'; ?>)</span>
				</div>
				<div class="flex justify-between py-2 border-b border-slate-100">
					<span class="text-slate-500 font-semibold">NIK & Nama Ibu</span>
					<span class="font-bold text-slate-900 text-right"><?= strtoupper($penduduk['nama_ibu'] ?: '-'); ?> (<?= $penduduk['ibu_nik'] ?: '-'; ?>)</span>
				</div>
				<div class="flex justify-between py-2 border-b border-slate-100">
					<span class="text-slate-500 font-semibold">Nomor Telepon</span>
					<span class="font-bold text-slate-900 text-right"><?= $penduduk['telepon'] ?: '-'; ?></span>
				</div>
				<div class="flex justify-between py-2 border-b border-slate-100">
					<span class="text-slate-500 font-semibold">Alamat Email</span>
					<span class="font-bold text-slate-900 text-right"><?= $penduduk['email'] ?: '-'; ?></span>
				</div>
				<div class="flex justify-between py-2 border-b border-slate-100">
					<span class="text-slate-500 font-semibold">Alamat Lengkap</span>
					<span class="font-bold text-slate-900 text-right"><?= strtoupper($penduduk['alamat'] ?: '-'); ?></span>
				</div>
				<div class="flex justify-between py-2 border-b border-slate-100">
					<span class="text-slate-500 font-semibold">Dusun / RT / RW</span>
					<span class="font-bold text-slate-900 text-right"><?= strtoupper($penduduk['dusun'] ?: '-'); ?> (RT <?= $penduduk['rt']; ?> / RW <?= $penduduk['rw']; ?>)</span>
				</div>
			</div>
		</div>
	</div>

	<!-- 4. PERKAWINAN & KESEHATAN -->
	<div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden">
		<div class="px-6 py-4 bg-slate-50/80 border-b border-slate-200 flex items-center space-x-2.5">
			<i class="fa-solid fa-heart-pulse text-indigo-600 text-base"></i>
			<h4 class="text-base sm:text-lg font-bold font-display text-slate-900">4. Perkawinan & Kesehatan</h4>
		</div>
		<div class="p-6">
			<div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-4 text-sm sm:text-base">
				<div class="flex justify-between py-2 border-b border-slate-100">
					<span class="text-slate-500 font-semibold">Status Kawin</span>
					<span class="font-bold text-slate-900 text-right"><?= strtoupper($penduduk['kawin'] ?: '-'); ?></span>
				</div>
				<div class="flex justify-between py-2 border-b border-slate-100">
					<span class="text-slate-500 font-semibold">Golongan Darah</span>
					<span class="font-bold text-slate-900 text-right"><?= $penduduk['golongan_darah'] ?: '-'; ?></span>
				</div>
				<div class="flex justify-between py-2 border-b border-slate-100">
					<span class="text-slate-500 font-semibold">Cacat Fisik/Mental</span>
					<span class="font-bold text-slate-900 text-right"><?= strtoupper($penduduk['cacat'] ?: '-'); ?></span>
				</div>
				<div class="flex justify-between py-2 border-b border-slate-100">
					<span class="text-slate-500 font-semibold">Sakit Menahun</span>
					<span class="font-bold text-slate-900 text-right"><?= strtoupper($penduduk['sakit_menahun'] ?: '-'); ?></span>
				</div>
				<div class="flex justify-between py-2 border-b border-slate-100">
					<span class="text-slate-500 font-semibold">Nama Asuransi</span>
					<span class="font-bold text-slate-900 text-right"><?= $penduduk['asuransi'] ?: '-'; ?></span>
				</div>
				<?php if (! empty($penduduk['id_asuransi']) && $penduduk['id_asuransi'] != '1') : ?>
					<div class="flex justify-between py-2 border-b border-slate-100">
						<span class="text-slate-500 font-semibold">Nomor Asuransi</span>
						<span class="font-bold text-slate-900 text-right"><?= strtoupper($penduduk['no_asuransi']); ?></span>
					</div>
				<?php endif; ?>
			</div>
		</div>
	</div>

	<!-- 5. KEANGGOTAAN KELOMPOK -->
	<div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden">
		<div class="px-6 py-4 bg-slate-50/80 border-b border-slate-200 flex items-center space-x-2.5">
			<i class="fa-solid fa-people-group text-indigo-600 text-base"></i>
			<h4 class="text-base sm:text-lg font-bold font-display text-slate-900">5. Keanggotaan Kelompok Masyarakat</h4>
		</div>
		<div class="p-6">
			<div class="table-responsive">
				<table class="table table-bordered table-hover w-full">
					<thead>
						<tr class="bg-slate-50 text-slate-700 text-xs sm:text-sm font-bold uppercase tracking-wider">
							<th class="py-3 px-4 text-center" style="width: 60px;">No</th>
							<th class="py-3 px-4">Nama Kelompok</th>
							<th class="py-3 px-4">Kategori Kelompok</th>
						</tr>
					</thead>
					<tbody>
						<?php if ($kelompok) :
							foreach ($kelompok as $key => $data) : ?>
								<tr class="text-sm sm:text-base">
									<td class="text-center font-semibold text-slate-500"><?= ($key + 1); ?></td>
									<td class="font-bold text-slate-900"><?= $data['nama']; ?></td>
									<td class="text-slate-600 font-medium"><?= $data['kategori']; ?></td>
								</tr>
							<?php endforeach;
						else : ?>
							<tr>
								<td class="text-center py-8 text-slate-400 font-medium" colspan="3">
									Belum terdaftar dalam keanggotaan kelompok kemasyarakatan.
								</td>
							</tr>
						<?php endif; ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>

</div>
