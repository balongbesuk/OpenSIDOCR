<?php

defined('BASEPATH') || exit('No direct script access allowed');

/*
 * File ini:
 *
 * View modul Layanan Mandiri > Dokumen (Arsip Berkas Digital)
 * Redesigned with Next-Gen UI/UX Pro Max (Tema Desa Balongbesuk)
 *
 * donjo-app/views/fmandiri/dokumen/index.php
 */
?>

<!-- ========================================================================
     PAGE TITLE & BREADCRUMB CARD
     ======================================================================== -->
<div class="relative bg-white rounded-2xl border border-slate-200/80 p-5 sm:p-6 mb-6 shadow-xs overflow-hidden flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
	
	<!-- Left: Big Teal/Emerald Icon + Title & Breadcrumb -->
	<div class="flex items-center space-x-4 z-10">
		<div class="w-12 h-12 sm:w-14 sm:h-14 rounded-2xl bg-teal-600 text-white flex items-center justify-center text-xl sm:text-2xl shadow-sm flex-shrink-0">
			<i class="fa-solid fa-folder-open"></i>
		</div>
		<div>
			<h2 class="text-2xl sm:text-3xl font-extrabold font-display text-slate-900 leading-tight">
				Dokumen Kependudukan
			</h2>
			<nav class="flex items-center space-x-2 text-sm text-slate-400 font-medium mt-1">
				<a href="<?= site_url('layanan-mandiri/beranda') ?>" class="hover:text-teal-600 transition-colors text-decoration-none text-slate-400">Beranda</a>
				<span>&rsaquo;</span>
				<span class="text-slate-600 font-semibold">Dokumen</span>
			</nav>
		</div>
	</div>

	<!-- Right: Tambah Dokumen Action Button -->
	<div class="flex items-center space-x-2.5">
		<a href="<?= site_url('layanan-mandiri/dokumen/form'); ?>" class="px-5 py-2.5 rounded-xl bg-teal-600 hover:bg-teal-700 text-white font-bold text-sm sm:text-base shadow-xs transition-colors flex items-center space-x-2 text-decoration-none">
			<i class="fa-solid fa-plus text-sm"></i>
			<span>Unggah Dokumen Baru</span>
		</a>
	</div>

</div>

<!-- ========================================================================
     DATA TABLE CARD CONTAINER
     ======================================================================== -->
<div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs p-5 sm:p-7 mb-6">
	
	<?php $this->load->view('fmandiri/notifikasi') ?>

	<!-- Card Title & Subtitle -->
	<div class="mb-6">
		<h3 class="text-xl sm:text-2xl font-bold font-display text-slate-900 leading-tight">
			Daftar Arsip Dokumen Digital
		</h3>
		<p class="text-sm sm:text-base text-slate-500 mt-1">
			Dokumen yang Anda simpan di sini dapat digunakan langsung saat mengajukan berbagai permohonan surat desa secara online.
		</p>
	</div>

	<!-- Table Content -->
	<div class="table-responsive overflow-x-auto">
		<table class="table table-bordered table-hover w-full" id="loaddata">
			<thead>
				<tr class="bg-slate-50 text-slate-700 text-xs sm:text-sm font-bold uppercase tracking-wider">
					<th class="py-3.5 px-4 text-center" style="width: 50px;">No</th>
					<th class="py-3.5 px-4 text-center" style="width: 140px;">Aksi</th>
					<th class="py-3.5 px-4" style="width: 25%;">Jenis Dokumen</th>
					<th class="py-3.5 px-4">Nama Dokumen</th>
					<th class="py-3.5 px-4 text-center" style="width: 160px;">Tanggal Unggah</th>
				</tr>
			</thead>
			<tbody>
				<?php
				if ($dokumen) :
					foreach ($dokumen as $key => $data) :
				?>
					<tr class="text-sm sm:text-base">
						<td class="text-center font-semibold text-slate-500"></td>
						<td class="text-center whitespace-nowrap">
							<div class="inline-flex items-center gap-1.5 justify-center">
								<a href="<?= site_url("layanan-mandiri/dokumen/form/{$data['id']}"); ?>" title="Ubah Dokumen" class="w-9 h-9 rounded-xl bg-amber-500 text-white hover:bg-amber-600 flex items-center justify-center transition-colors shadow-2xs">
									<i class="fa-solid fa-pen-to-square text-sm"></i>
								</a>
								<a href="<?= site_url("layanan-mandiri/dokumen/hapus/{$data['id']}"); ?>" title="Hapus Dokumen" class="w-9 h-9 rounded-xl bg-rose-600 text-white hover:bg-rose-700 flex items-center justify-center transition-colors shadow-2xs" onclick="return confirm('Apakah Anda yakin ingin menghapus dokumen ini?');">
									<i class="fa-solid fa-trash-can text-sm"></i>
								</a>
								<a href="<?= site_url("layanan-mandiri/dokumen/unduh/{$data['id']}"); ?>" title="Unduh Berkas" class="w-9 h-9 rounded-xl bg-slate-800 text-white hover:bg-slate-900 flex items-center justify-center transition-colors shadow-2xs">
									<i class="fa-solid fa-download text-sm"></i>
								</a>
							</div>
						</td>
						<td>
							<span class="inline-flex items-center px-3 py-1 rounded-lg bg-teal-50 border border-teal-200/70 text-teal-800 text-xs sm:text-sm font-semibold">
								<?= $jenis_syarat_surat[$data['id_syarat']]['ref_syarat_nama']?>
							</span>
						</td>
						<td class="font-bold text-slate-900">
							<?= $data['nama']; ?>
						</td>
						<td class="text-center text-slate-500 font-medium">
							<?= tgl_indo2($data['tgl_upload']); ?>
						</td>
					</tr>
				<?php
					endforeach;
				else :
				?>
					<tr>
						<td class="text-center py-10 text-slate-400 font-medium" colspan="5">
							<div class="w-12 h-12 rounded-2xl bg-slate-100 text-slate-400 flex items-center justify-center text-2xl mx-auto mb-2">
								<i class="fa-solid fa-folder-open"></i>
							</div>
							Belum ada dokumen yang diunggah.
						</td>
					</tr>
				<?php endif; ?>
			</tbody>
		</table>
	</div>

</div>

<script>
	$(document).ready(function () {
		var TabelData = $('#loaddata').DataTable({
			'pageLength': 10,
			'responsive': true,
			'columnDefs': [
				{ "searchable": true, "orderable": false, "targets": [ 0, 1 ] }
			],
			order: [[3, 'asc']],
			'language': {
				'url': BASE_URL + '/assets/bootstrap/js/dataTables.indonesian.lang'
			}
		});

		TabelData.on( 'draw.dt', function () {
			var PageInfo = TabelData.page.info();
			TabelData.column(0, { page: 'current' }).nodes().each(function (cell, i) {
				cell.innerHTML = i + 1 + PageInfo.start;
			});
		});
	});
</script>