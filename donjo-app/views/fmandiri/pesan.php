<?php

defined('BASEPATH') || exit('No direct script access allowed');

/*
 * File ini:
 *
 * View modul Layanan Mandiri > Pesan > Pesan Masuk / Keluar
 * Redesigned with Next-Gen UI/UX Pro Max (Tema Desa Balongbesuk)
 *
 * donjo-app/views/fmandiri/pesan.php
 */
?>

<!-- ========================================================================
     PAGE TITLE & BREADCRUMB CARD
     ======================================================================== -->
<div class="relative bg-white rounded-2xl border border-slate-200/80 p-5 sm:p-6 mb-6 shadow-xs overflow-hidden flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
	
	<!-- Left: Big Orange Icon + Title & Breadcrumb -->
	<div class="flex items-center space-x-4 z-10">
		<div class="w-12 h-12 sm:w-14 sm:h-14 rounded-2xl bg-orange-500 text-white flex items-center justify-center text-xl sm:text-2xl shadow-sm flex-shrink-0">
			<i class="fa-solid fa-envelope"></i>
		</div>
		<div>
			<h2 class="text-2xl sm:text-3xl font-extrabold font-display text-slate-900 leading-tight">
				Pesan <?= ucfirst($judul); ?>
			</h2>
			<nav class="flex items-center space-x-2 text-sm text-slate-400 font-medium mt-1">
				<a href="<?= site_url('layanan-mandiri/beranda') ?>" class="hover:text-orange-600 transition-colors text-decoration-none text-slate-400">Beranda</a>
				<span>&rsaquo;</span>
				<span class="text-slate-600 font-semibold">Pesan <?= ucfirst($judul); ?></span>
			</nav>
		</div>
	</div>

	<!-- Right: Action Button -->
	<div class="flex items-center space-x-3 w-full sm:w-auto">
		<a href="<?= site_url('layanan-mandiri/pesan/tulis'); ?>" class="w-full sm:w-auto inline-flex items-center justify-center space-x-2 px-5 py-2.5 rounded-xl bg-orange-500 hover:bg-orange-600 text-white text-sm font-bold shadow-xs transition-all text-decoration-none">
			<i class="fa-solid fa-pen-to-square text-xs"></i>
			<span>Tulis Pesan Baru</span>
		</a>
	</div>

</div>

<!-- ========================================================================
     SUB-NAVIGATION PILLS (MATCHING OTHER MODULES)
     ======================================================================== -->
<div class="flex items-center space-x-3 overflow-x-auto no-scrollbar mb-6 pb-1">
	<a href="<?= site_url('layanan-mandiri/pesan-masuk'); ?>" class="inline-flex items-center space-x-2.5 px-6 py-3 rounded-xl text-sm sm:text-base font-bold transition-all text-decoration-none <?= ($kat == 2 || $judul == 'Masuk') ? 'bg-orange-500 text-white shadow-xs' : 'bg-white text-slate-700 hover:text-orange-600 border border-slate-200' ?>">
		<i class="fa-solid fa-inbox text-sm"></i>
		<span>Pesan Masuk</span>
	</a>

	<a href="<?= site_url('layanan-mandiri/pesan-keluar'); ?>" class="inline-flex items-center space-x-2.5 px-6 py-3 rounded-xl text-sm sm:text-base font-bold transition-all text-decoration-none <?= ($kat == 1 || $judul == 'Keluar') ? 'bg-orange-500 text-white shadow-xs' : 'bg-white text-slate-700 hover:text-orange-600 border border-slate-200' ?>">
		<i class="fa-solid fa-paper-plane text-sm"></i>
		<span>Pesan Keluar</span>
	</a>
</div>

<!-- ========================================================================
     DATA TABLE CARD CONTAINER
     ======================================================================== -->
<div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs p-6 sm:p-7 mb-6">

	<!-- Header Description -->
	<div class="mb-5 pb-4 border-b border-slate-100 flex items-center justify-between">
		<div>
			<h3 class="text-lg sm:text-xl font-bold font-display text-slate-900">
				Daftar Pesan <?= ucfirst($judul); ?>
			</h3>
			<p class="text-sm text-slate-500 mt-0.5">
				<?= ($kat == 2 || $judul == 'Masuk') ? 'Berikut adalah daftar pesan masuk dan balasan koordinasi dari pihak pemerintah desa.' : 'Berikut adalah riwayat pesan atau pertanyaan yang telah Anda kirimkan kepada pihak desa.'; ?>
			</p>
		</div>
	</div>

	<!-- Controls Bar: Show Entries + Search Box -->
	<div class="flex flex-col sm:flex-row items-stretch sm:items-center justify-between gap-4 mb-5">
		<div class="flex items-center space-x-2.5 text-sm sm:text-base text-slate-600">
			<span>Tampilkan</span>
			<select id="tabel-length-select" class="px-3.5 py-2 rounded-xl border border-slate-200 bg-white text-slate-700 text-sm sm:text-base font-semibold focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 outline-none cursor-pointer">
				<option value="10">10</option>
				<option value="25">25</option>
				<option value="50">50</option>
				<option value="100">100</option>
				<option value="-1">Semua</option>
			</select>
			<span>entri</span>
		</div>

		<div class="relative">
			<i class="fa-solid fa-magnifying-glass absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-base"></i>
			<input type="text" id="tabel-filter-input" placeholder="Cari subjek, pesan..." class="w-full sm:w-80 pl-11 pr-4 py-2.5 rounded-xl border border-slate-200 text-sm sm:text-base text-slate-700 placeholder-slate-400 focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 outline-none">
		</div>
	</div>

	<!-- Table Area -->
	<?php if (empty($pesan)) : ?><div class="overflow-x-auto w-full"><?php endif; ?>
		<table class="table table-bordered table-hover w-full" id="tabeldata">
			<thead>
				<tr class="bg-slate-50 text-slate-700 text-xs sm:text-sm font-bold uppercase tracking-wider">
					<th class="py-3.5 px-3 text-center" style="width: 50px;">NO</th>
					<th class="py-3.5 px-3 text-center" style="width: 100px;">AKSI</th>
					<th class="py-3.5 px-4">SUBJEK PESAN</th>
					<th class="py-3.5 px-4 text-center" style="width: 160px;">STATUS</th>
					<th class="py-3.5 px-4 text-center" style="width: 200px;">DIKIRIMKAN PADA</th>
				</tr>
			</thead>
			<tbody class="divide-y divide-slate-100">
			<?php if (!empty($pesan)): ?>
				<?php foreach ($pesan as $key => $data): ?>
					<tr class="text-sm sm:text-base transition-colors hover:bg-slate-50/70 <?= ($data['status'] == 2) ? 'bg-amber-50/40 font-semibold' : ''; ?>">
						<td class="text-center text-slate-500 font-semibold py-3.5 px-3"><?= ($key + 1); ?></td>
						<td class="text-center whitespace-nowrap py-3.5 px-3">
							<a href="<?= site_url("layanan-mandiri/pesan/baca/{$kat}/{$data['id']}"); ?>" class="inline-flex items-center space-x-1.5 px-3.5 py-1.5 rounded-xl bg-orange-500 hover:bg-orange-600 text-white text-xs sm:text-sm font-bold shadow-2xs transition-all text-decoration-none" title="Baca pesan">
								<i class="fa-solid fa-eye text-xs"></i>
								<span>Baca</span>
							</a>
						</td>
						<td class="py-3.5 px-4 text-slate-800">
							<div class="flex items-center space-x-2.5">
								<?php if ($data['status'] == 2): ?>
									<span class="w-2.5 h-2.5 rounded-full bg-amber-500 flex-shrink-0 animate-pulse" title="Belum dibaca"></span>
								<?php endif; ?>
								<span class="font-medium text-slate-900"><?= $data['subjek']; ?></span>
							</div>
						</td>
						<td class="text-center py-3.5 px-4">
							<?php if ($data['status'] == 1): ?>
								<span class="inline-flex items-center space-x-1 px-3 py-1 rounded-full text-xs font-semibold bg-slate-100 text-slate-600 border border-slate-200">
									<i class="fa-solid fa-check-double text-slate-400"></i>
									<span>Sudah Dibaca</span>
								</span>
							<?php else: ?>
								<span class="inline-flex items-center space-x-1 px-3 py-1 rounded-full text-xs font-semibold bg-amber-50 text-amber-700 border border-amber-200">
									<i class="fa-solid fa-envelope text-amber-500"></i>
									<span>Belum Dibaca</span>
								</span>
							<?php endif; ?>
						</td>
						<td class="text-center text-xs sm:text-sm text-slate-500 whitespace-nowrap py-3.5 px-4">
							<?= tgl_indo2($data['tgl_upload']); ?>
						</td>
					</tr>
				<?php endforeach; ?>
			<?php else: ?>
				<tr>
					<td class="text-center py-14 px-4 text-slate-500" colspan="5">
						<div class="max-w-sm mx-auto flex flex-col items-center justify-center space-y-3">
							<div class="w-16 h-16 rounded-2xl bg-orange-50 border border-orange-100 flex items-center justify-center text-orange-500 text-2xl shadow-xs">
								<i class="fa-solid fa-envelope-open-text"></i>
							</div>
							<div class="space-y-1">
								<h4 class="text-base sm:text-lg font-bold text-slate-800">Belum Ada Pesan <?= ucfirst($judul); ?></h4>
								<p class="text-xs sm:text-sm text-slate-400">
									Saat ini kotak pesan <?= strtolower($judul); ?> Anda masih kosong. Anda dapat mengirimkan pertanyaan atau koordinasi langsung kepada aparatur desa.
								</p>
							</div>
							<a href="<?= site_url('layanan-mandiri/pesan/tulis'); ?>" class="inline-flex items-center space-x-2 px-5 py-2.5 rounded-xl bg-orange-500 hover:bg-orange-600 text-white text-xs sm:text-sm font-bold shadow-xs transition-all text-decoration-none mt-2">
								<i class="fa-solid fa-pen-to-square text-xs"></i>
								<span>Tulis Pesan Baru</span>
							</a>
						</div>
					</td>
				</tr>
			<?php endif; ?>
			</tbody>
		</table>
	<?php if (empty($pesan)) : ?></div><?php endif; ?>

	<?php if (empty($pesan)) : ?>
		<!-- Static empty footer -->
		<div class="flex flex-col sm:flex-row items-center justify-between gap-3 pt-4 border-t border-slate-100 text-sm text-slate-500">
			<div>Menampilkan 0 sampai 0 dari 0 entri</div>
		</div>
	<?php endif; ?>

</div>

<style>
	/* Mobile-First DataTables Footer & Pagination (Harmonized with Menu Surat) */
	.dataTables-footer {
		display: flex !important;
		flex-direction: column !important;
		align-items: center !important;
		justify-content: space-between !important;
		gap: 0.75rem !important;
		padding-top: 1rem !important;
		border-top: 1px solid #f1f5f9 !important;
		width: 100% !important;
	}
	@media (min-width: 640px) {
		.dataTables-footer {
			flex-direction: row !important;
			gap: 1rem !important;
		}
	}
	#tabeldata_wrapper .dataTables_info {
		padding: 0 !important;
		margin: 0 !important;
		font-size: 0.8125rem !important;
		color: #64748b !important;
		text-align: center !important;
		width: 100% !important;
		line-height: 1.5 !important;
	}
	@media (min-width: 640px) {
		#tabeldata_wrapper .dataTables_info {
			font-size: 0.875rem !important;
			text-align: left !important;
			width: auto !important;
		}
	}
	#tabeldata_wrapper .dataTables_paginate {
		margin: 0 !important;
		padding: 0 !important;
		width: 100% !important;
		display: flex !important;
		justify-content: center !important;
	}
	@media (min-width: 640px) {
		#tabeldata_wrapper .dataTables_paginate {
			width: auto !important;
			justify-content: flex-end !important;
		}
	}
	#tabeldata_wrapper .dataTables_paginate ul.pagination {
		margin: 0 !important;
		padding: 0 !important;
		display: inline-flex !important;
		align-items: center !important;
		justify-content: center !important;
		flex-wrap: wrap !important;
		gap: 4px !important;
		list-style: none !important;
		border: none !important;
	}
	#tabeldata_wrapper .dataTables_paginate ul.pagination > li {
		display: inline-flex !important;
		margin: 0 !important;
		padding: 0 !important;
	}
	#tabeldata_wrapper .dataTables_paginate ul.pagination > li > a,
	#tabeldata_wrapper .dataTables_paginate ul.pagination > li > span {
		display: inline-flex !important;
		align-items: center !important;
		justify-content: center !important;
		min-width: 32px !important;
		height: 32px !important;
		padding: 0 8px !important;
		border-radius: 8px !important;
		font-size: 0.8125rem !important;
		font-weight: 600 !important;
		border: 1px solid #e2e8f0 !important;
		color: #475569 !important;
		background: #ffffff !important;
		float: none !important;
		margin: 0 !important;
		transition: all 0.15s ease-in-out !important;
		text-decoration: none !important;
		box-sizing: border-box !important;
		line-height: 1 !important;
	}
	@media (min-width: 640px) {
		#tabeldata_wrapper .dataTables_paginate ul.pagination > li > a,
		#tabeldata_wrapper .dataTables_paginate ul.pagination > li > span {
			min-width: 38px !important;
			height: 38px !important;
			padding: 0 12px !important;
			border-radius: 10px !important;
			font-size: 0.875rem !important;
		}
	}
	#tabeldata_wrapper .dataTables_paginate ul.pagination > li > a:hover {
		background: #f1f5f9 !important;
		border-color: #cbd5e1 !important;
		color: #0f172a !important;
	}
	#tabeldata_wrapper .dataTables_paginate ul.pagination > .active > a,
	#tabeldata_wrapper .dataTables_paginate ul.pagination > .active > span {
		background: #f97316 !important;
		border-color: #f97316 !important;
		color: #ffffff !important;
		box-shadow: 0 1px 3px 0 rgba(249, 115, 22, 0.3) !important;
	}
	#tabeldata_wrapper .dataTables_paginate ul.pagination > .disabled > a,
	#tabeldata_wrapper .dataTables_paginate ul.pagination > .disabled > span {
		color: #cbd5e1 !important;
		background: #f8fafc !important;
		border-color: #f1f5f9 !important;
		cursor: not-allowed !important;
		opacity: 0.6 !important;
	}
</style>

<script>
	$(document).ready(function() {
		<?php if (!empty($pesan)) : ?>
		var tabelPesan = $('#tabeldata').DataTable({
			pageLength: 10,
			responsive: true,
			order: [],
			dom: 'r<"overflow-x-auto w-full mb-2"t><"dataTables-footer"ip>',
			columnDefs: [
				{ targets: [0, 1], orderable: false, searchable: false }
			],
			language: {
				emptyTable: "Tidak ada data yang tersedia pada tabel ini",
				info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ entri",
				infoEmpty: "Menampilkan 0 sampai 0 dari 0 entri",
				infoFiltered: "(disaring dari _MAX_ entri)",
				lengthMenu: "Tampilkan _MENU_ entri",
				loadingRecords: "Sedang memuat...",
				processing: "Sedang memproses...",
				search: "Cari:",
				zeroRecords: "Tidak ditemukan data yang sesuai",
				paginate: {
					first: '<i class="fa-solid fa-angles-left text-xs"></i>',
					last: '<i class="fa-solid fa-angles-right text-xs"></i>',
					previous: '<i class="fa-solid fa-chevron-left text-xs"></i><span class="hidden sm:inline sm:ml-1.5">Sebelumnya</span>',
					next: '<span class="hidden sm:inline sm:mr-1.5">Selanjutnya</span><i class="fa-solid fa-chevron-right text-xs"></i>'
				}
			}
		});

		// Custom Show Entries Selector
		$('#tabel-length-select').on('change', function() {
			var len = parseInt(this.value, 10);
			tabelPesan.page.len(len).draw();
		});

		// Custom Search Box
		$('#tabel-filter-input').on('keyup input', function() {
			tabelPesan.search(this.value).draw();
		});

		// Update numbering column dynamically on page/search/order
		tabelPesan.on('draw.dt', function() {
			var pageInfo = tabelPesan.page.info();
			tabelPesan.column(0, { page: 'current' }).nodes().each(function(cell, i) {
				cell.innerHTML = i + 1 + pageInfo.start;
			});
		});
		<?php else : ?>
		$('#tabel-length-select').prop('disabled', true);
		$('#tabel-filter-input').prop('disabled', true);
		<?php endif; ?>
	});
</script>
