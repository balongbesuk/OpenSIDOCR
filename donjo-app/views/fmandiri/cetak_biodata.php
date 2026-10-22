<?php

defined('BASEPATH') || exit('No direct script access allowed');

/*
 * File ini:
 *
 * View Cetak Biodata Terintegrasi Layanan Mandiri
 * donjo-app/views/fmandiri/cetak_biodata.php
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
			<span class="text-slate-600 font-bold">Cetak Biodata</span>
		</div>
		<h1 class="text-xl sm:text-2xl font-black text-slate-800 tracking-tight flex items-center gap-2">
			<i class="fa-solid fa-address-card text-sky-600"></i>
			<span>Cetak Biodata Penduduk</span>
		</h1>
		<p class="text-xs sm:text-sm text-slate-500 mt-0.5">
			Pratinjau lembar biodata kependudukan resmi Anda di dalam aplikasi Layanan Mandiri.
		</p>
	</div>

	<!-- Action Buttons -->
	<div class="flex items-center gap-2.5">
		<a href="<?= site_url('layanan-mandiri/profil') ?>" class="px-4 py-2.5 rounded-xl bg-white hover:bg-slate-100 border border-slate-200 text-slate-700 font-bold text-xs sm:text-sm shadow-2xs transition-all flex items-center space-x-2 text-decoration-none">
			<i class="fa-solid fa-arrow-left text-xs text-slate-400"></i>
			<span>Kembali</span>
		</a>

		<button type="button" onclick="window.print()" class="px-5 py-2.5 rounded-xl bg-sky-600 hover:bg-sky-700 active:bg-sky-800 text-white font-bold text-xs sm:text-sm shadow-md shadow-sky-500/20 transition-all flex items-center space-x-2 cursor-pointer border-none">
			<i class="fa-solid fa-print"></i>
			<span>Cetak Dokumen</span>
		</button>
	</div>
</div>

<!-- ========================================================================
     DOCUMENT SHEET CANVAS (Hanya bagian ini yang tercetak saat print)
     ======================================================================== -->
<div class="print-container">
	<div id="print-area" class="bg-white rounded-2xl sm:rounded-3xl border border-slate-200/90 shadow-xl p-6 sm:p-10 lg:p-12 max-w-4xl mx-auto text-slate-900">

		<!-- Header NIK & No.KK -->
		<table class="w-full text-xs sm:text-sm border-none mb-3 font-semibold text-slate-700">
			<tr>
				<td class="w-20 py-0.5">NIK</td>
				<td class="w-4 py-0.5">:</td>
				<td class="py-0.5 font-bold tracking-wider text-slate-900"><?= get_nik($penduduk['nik']) ?></td>
			</tr>
			<tr>
				<td class="w-20 py-0.5">No. KK</td>
				<td class="w-4 py-0.5">:</td>
				<td class="py-0.5 font-bold tracking-wider text-slate-900"><?= $penduduk['no_kk'] ?: '-' ?></td>
			</tr>
		</table>

		<hr class="border-t-2 border-slate-900 my-2">

		<!-- Kop Surat & Judul Dokumen -->
		<div class="text-center my-4">
			<?php if (!empty($desa['logo'])) : ?>
				<img src="<?= gambar_desa($desa['logo']); ?>" alt="<?= $desa['nama_desa'] ?>" class="h-16 sm:h-20 mx-auto mb-2 object-contain">
			<?php endif; ?>
			<h2 class="text-base sm:text-lg lg:text-xl font-black uppercase tracking-wide text-slate-900 mb-1">
				BIODATA PENDUDUK WARGA NEGARA INDONESIA
			</h2>
			<h3 class="text-xs sm:text-sm font-semibold uppercase text-slate-600">
				<?= ucwords(setting('sebutan_kabupaten_singkat')) ?> <?= $desa['nama_kabupaten'] ?>,
				<?= ucwords(setting('sebutan_kecamatan_singkat')) ?> <?= $desa['nama_kecamatan'] ?>,
				<?= ucwords(setting('sebutan_desa')) ?> <?= $desa['nama_desa'] ?>
			</h3>
		</div>

		<hr class="border-t border-slate-300 my-4">

		<!-- TABEL 1: DATA PERSONAL -->
		<div class="mb-5">
			<div class="bg-slate-100/90 px-3 py-1.5 rounded-lg font-bold text-xs sm:text-sm uppercase tracking-wide text-slate-800 mb-2 border border-slate-200">
				DATA PERSONAL
			</div>

			<div class="flex flex-col md:flex-row gap-6 items-start">
				<table class="flex-1 w-full text-xs sm:text-sm border-collapse">
					<tbody>
						<tr class="border-b border-slate-100">
							<td class="w-44 py-1.5 font-semibold text-slate-600">Nama Lengkap</td>
							<td class="w-4 py-1.5">:</td>
							<td class="py-1.5 font-bold text-slate-900"><?= strtoupper($penduduk['nama']) ?></td>
						</tr>
						<tr class="border-b border-slate-100">
							<td class="py-1.5 font-semibold text-slate-600">Tempat Lahir</td>
							<td class="py-1.5">:</td>
							<td class="py-1.5 text-slate-800"><?= strtoupper($penduduk['tempatlahir'] ?: '-') ?></td>
						</tr>
						<tr class="border-b border-slate-100">
							<td class="py-1.5 font-semibold text-slate-600">Tanggal Lahir</td>
							<td class="py-1.5">:</td>
							<td class="py-1.5 text-slate-800"><?= strtoupper(tgl_indo($penduduk['tanggallahir'])) ?></td>
						</tr>
						<tr class="border-b border-slate-100">
							<td class="py-1.5 font-semibold text-slate-600">Jenis Kelamin</td>
							<td class="py-1.5">:</td>
							<td class="py-1.5 text-slate-800"><?= strtoupper($penduduk['sex'] ?: '-') ?></td>
						</tr>
						<tr class="border-b border-slate-100">
							<td class="py-1.5 font-semibold text-slate-600">Akta Kelahiran</td>
							<td class="py-1.5">:</td>
							<td class="py-1.5 text-slate-800"><?= strtoupper($penduduk['akta_lahir'] ?: '-') ?></td>
						</tr>
						<tr class="border-b border-slate-100">
							<td class="py-1.5 font-semibold text-slate-600">Agama</td>
							<td class="py-1.5">:</td>
							<td class="py-1.5 text-slate-800"><?= strtoupper($penduduk['agama'] ?: '-') ?></td>
						</tr>
						<tr class="border-b border-slate-100">
							<td class="py-1.5 font-semibold text-slate-600">Pendidikan Terakhir</td>
							<td class="py-1.5">:</td>
							<td class="py-1.5 text-slate-800"><?= strtoupper($penduduk['pendidikan_kk'] ?: '-') ?></td>
						</tr>
						<tr class="border-b border-slate-100">
							<td class="py-1.5 font-semibold text-slate-600">Pekerjaan</td>
							<td class="py-1.5">:</td>
							<td class="py-1.5 text-slate-800"><?= strtoupper($penduduk['pekerjaan'] ?: '-') ?></td>
						</tr>
						<tr class="border-b border-slate-100">
							<td class="py-1.5 font-semibold text-slate-600">Golongan Darah</td>
							<td class="py-1.5">:</td>
							<td class="py-1.5 text-slate-800"><?= strtoupper($penduduk['golongan_darah'] ?: '-') ?></td>
						</tr>
						<tr class="border-b border-slate-100">
							<td class="py-1.5 font-semibold text-slate-600">Penyandang Disabilitas</td>
							<td class="py-1.5">:</td>
							<td class="py-1.5 text-slate-800"><?= strtoupper($penduduk['cacat'] ?: '-') ?></td>
						</tr>
						<tr class="border-b border-slate-100">
							<td class="py-1.5 font-semibold text-slate-600">Status Perkawinan</td>
							<td class="py-1.5">:</td>
							<td class="py-1.5 text-slate-800"><?= strtoupper($penduduk['kawin'] ?: '-') ?></td>
						</tr>
						<tr class="border-b border-slate-100">
							<td class="py-1.5 font-semibold text-slate-600">Hubungan Dalam Keluarga</td>
							<td class="py-1.5">:</td>
							<td class="py-1.5 text-slate-800"><?= strtoupper($penduduk['hubungan'] ?: '-') ?></td>
						</tr>
						<tr class="border-b border-slate-100">
							<td class="py-1.5 font-semibold text-slate-600">Kewarganegaraan</td>
							<td class="py-1.5">:</td>
							<td class="py-1.5 text-slate-800"><?= strtoupper($penduduk['warganegara'] ?: '-') ?></td>
						</tr>
						<tr class="border-b border-slate-100">
							<td class="py-1.5 font-semibold text-slate-600">Suku / Etnis</td>
							<td class="py-1.5">:</td>
							<td class="py-1.5 text-slate-800"><?= strtoupper($penduduk['suku'] ?: '-') ?></td>
						</tr>
						<tr class="border-b border-slate-100">
							<td class="py-1.5 font-semibold text-slate-600">NIK & Nama Ayah</td>
							<td class="py-1.5">:</td>
							<td class="py-1.5 text-slate-800"><?= get_nik($penduduk['ayah_nik']) ?> - <?= strtoupper($penduduk['nama_ayah'] ?: '-') ?></td>
						</tr>
						<tr class="border-b border-slate-100">
							<td class="py-1.5 font-semibold text-slate-600">NIK & Nama Ibu</td>
							<td class="py-1.5">:</td>
							<td class="py-1.5 text-slate-800"><?= get_nik($penduduk['ibu_nik']) ?> - <?= strtoupper($penduduk['nama_ibu'] ?: '-') ?></td>
						</tr>
						<tr class="border-b border-slate-100">
							<td class="py-1.5 font-semibold text-slate-600">Status Kependudukan</td>
							<td class="py-1.5">:</td>
							<td class="py-1.5 text-slate-800"><?= strtoupper($penduduk['status'] ?: '-') ?></td>
						</tr>
						<tr class="border-b border-slate-100">
							<td class="py-1.5 font-semibold text-slate-600">No. Telepon / HP</td>
							<td class="py-1.5">:</td>
							<td class="py-1.5 text-slate-800"><?= $penduduk['telepon'] ?: '-' ?></td>
						</tr>
						<tr class="border-b border-slate-100">
							<td class="py-1.5 font-semibold text-slate-600">Alamat Email</td>
							<td class="py-1.5">:</td>
							<td class="py-1.5 text-slate-800"><?= $penduduk['email'] ?: '-' ?></td>
						</tr>
						<tr>
							<td class="py-1.5 font-semibold text-slate-600 align-top">Alamat Lengkap</td>
							<td class="py-1.5 align-top">:</td>
							<td class="py-1.5 text-slate-800">
								<?= strtoupper($penduduk['alamat'] ?: '-') ?><br>
								RT <?= $penduduk['rt'] ?: '0' ?> / RW <?= $penduduk['rw'] ?: '0' ?>
								<?= ucwords(setting('sebutan_dusun')) ?> <?= strtoupper($penduduk['dusun'] ?: '-') ?>
							</td>
						</tr>
					</tbody>
				</table>

				<!-- Pas Foto Box -->
				<div class="flex-shrink-0 text-center w-36 sm:w-40 mx-auto md:mx-0">
					<div class="w-32 h-44 sm:w-36 sm:h-48 rounded-xl border-2 border-slate-400 p-1 bg-white shadow-xs mx-auto flex items-center justify-center overflow-hidden">
						<?php if (!empty($penduduk['foto'])) : ?>
							<img src="<?= AmbilFoto($penduduk['foto'], '', $penduduk['id_sex']) ?>" alt="<?= $penduduk['nama'] ?>" class="w-full h-full object-cover rounded-lg">
						<?php else : ?>
							<div class="text-slate-300 text-center">
								<i class="fa-solid fa-user text-4xl mb-1"></i>
								<p class="text-[10px] text-slate-400 font-bold uppercase">Pas Foto 3x4</p>
							</div>
						<?php endif; ?>
					</div>
					<p class="text-[11px] text-slate-500 font-semibold mt-2">Pas Foto Resmi</p>
				</div>
			</div>
		</div>

		<!-- TABEL 2: KEPEMILIKAN DOKUMEN -->
		<div class="mb-8">
			<div class="bg-slate-100/90 px-3 py-1.5 rounded-lg font-bold text-xs sm:text-sm uppercase tracking-wide text-slate-800 mb-2 border border-slate-200">
				DATA KEPEMILIKAN DOKUMEN
			</div>

			<table class="w-full text-xs sm:text-sm border-collapse">
				<tbody>
					<tr class="border-b border-slate-100">
						<td class="w-44 py-1.5 font-semibold text-slate-600">Nomor Kartu Keluarga</td>
						<td class="w-4 py-1.5">:</td>
						<td class="py-1.5 font-bold text-slate-900"><?= $penduduk['no_kk'] ?: '-' ?></td>
					</tr>
					<tr class="border-b border-slate-100">
						<td class="py-1.5 font-semibold text-slate-600">Dokumen Paspor</td>
						<td class="py-1.5">:</td>
						<td class="py-1.5 text-slate-800"><?= strtoupper($penduduk['dokumen_pasport'] ?: '-') ?></td>
					</tr>
					<tr class="border-b border-slate-100">
						<td class="py-1.5 font-semibold text-slate-600">Dokumen KITAS / KITAP</td>
						<td class="py-1.5">:</td>
						<td class="py-1.5 text-slate-800"><?= strtoupper($penduduk['dokumen_kitas'] ?: '-') ?></td>
					</tr>
					<tr class="border-b border-slate-100">
						<td class="py-1.5 font-semibold text-slate-600">Akta Perkawinan / Buku Nikah</td>
						<td class="py-1.5">:</td>
						<td class="py-1.5 text-slate-800"><?= strtoupper($penduduk['akta_perkawinan'] ?: '-') ?> (<?= $penduduk['tanggalperkawinan'] ? tgl_indo($penduduk['tanggalperkawinan']) : '-' ?>)</td>
					</tr>
					<tr class="border-b border-slate-100">
						<td class="py-1.5 font-semibold text-slate-600">Akta Perceraian</td>
						<td class="py-1.5">:</td>
						<td class="py-1.5 text-slate-800"><?= strtoupper($penduduk['akta_perceraian'] ?: '-') ?> (<?= $penduduk['tanggalperceraian'] ? tgl_indo($penduduk['tanggalperceraian']) : '-' ?>)</td>
					</tr>
					<tr>
						<td class="py-1.5 font-semibold text-slate-600">BPJS Ketenagakerjaan</td>
						<td class="py-1.5">:</td>
						<td class="py-1.5 text-slate-800"><?= strtoupper($penduduk['bpjs_ketenagakerjaan'] ?: '-') ?></td>
					</tr>
				</tbody>
			</table>
		</div>

		<!-- TANDA TANGAN PENGESAHAN -->
		<div class="pt-6 border-t border-slate-200">
			<div class="grid grid-cols-2 text-center text-xs sm:text-sm">
				<div>
					<p class="text-slate-600 font-semibold mb-1">Yang Bersangkutan,</p>
					<div class="h-24 sm:h-28"></div>
					<p class="font-bold uppercase text-slate-900 border-b border-slate-900 inline-block px-4">
						<?= strtoupper($penduduk['nama']) ?>
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
