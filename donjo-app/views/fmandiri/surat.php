<?php

defined('BASEPATH') || exit('No direct script access allowed');

/*
 * File ini:
 *
 * View modul Layanan Mandiri > Surat
 * Rombak Total Sesuai Mockup UI/UX Pro Max (Tema Desa Balongbesuk)
 *
 * donjo-app/views/fmandiri/surat.php
 */
?>

<!-- ========================================================================
     PAGE TITLE & BREADCRUMB CARD (MATCHING USER REFERENCE DESIGN)
     ======================================================================== -->
<div class="relative bg-white rounded-2xl border border-slate-200/80 p-5 sm:p-6 mb-5 shadow-xs overflow-hidden flex items-center justify-between">
	
	<!-- Left: Big Green Icon + Title & Breadcrumb -->
	<div class="flex items-center space-x-4 z-10">
		<div class="w-12 h-12 sm:w-14 sm:h-14 rounded-2xl bg-[#10b981] text-white flex items-center justify-center text-xl sm:text-2xl shadow-sm flex-shrink-0">
			<i class="fa-solid fa-file-lines"></i>
		</div>
		<div>
			<h2 class="text-2xl sm:text-3xl font-extrabold font-display text-slate-900 leading-tight">
				Surat
			</h2>
			<nav class="flex items-center space-x-2 text-sm text-slate-400 font-medium mt-1">
				<a href="<?= site_url('layanan-mandiri/beranda') ?>" class="hover:text-emerald-600 transition-colors text-decoration-none text-slate-400">Beranda</a>
				<span>&rsaquo;</span>
				<span class="text-slate-600 font-semibold">Surat</span>
			</nav>
		</div>
	</div>

	<!-- Right: Soft Decorative Graphic with Leaves & Stacked Papers -->
	<div class="hidden sm:flex items-center pointer-events-none pr-4">
		<svg width="130" height="75" viewBox="0 0 130 75" fill="none" xmlns="http://www.w3.org/2000/svg">
			<!-- Background Shadow Document -->
			<rect x="25" y="14" width="46" height="56" rx="6" fill="#F8FAFC" stroke="#E2E8F0" stroke-width="2"/>
			<!-- Foreground White Document -->
			<rect x="42" y="6" width="46" height="58" rx="6" fill="#FFFFFF" stroke="#10B981" stroke-width="2"/>
			<line x1="50" y1="18" x2="72" y2="18" stroke="#10B981" stroke-width="2.5" stroke-linecap="round"/>
			<line x1="50" y1="26" x2="80" y2="26" stroke="#CBD5E1" stroke-width="2" stroke-linecap="round"/>
			<line x1="50" y1="33" x2="74" y2="33" stroke="#CBD5E1" stroke-width="2" stroke-linecap="round"/>
			<line x1="50" y1="40" x2="68" y2="40" stroke="#CBD5E1" stroke-width="2" stroke-linecap="round"/>
			<!-- Decorative Green Leaves -->
			<path d="M96 52C99 42 108 34 118 32C116 46 109 56 96 61Z" fill="#10B981" fill-opacity="0.35"/>
			<path d="M106 58C108 48 116 42 125 40C123 52 117 62 106 66Z" fill="#059669" fill-opacity="0.45"/>
			<circle cx="100" cy="38" r="3" fill="#6EE7B7" fill-opacity="0.5"/>
		</svg>
	</div>

</div>

<!-- ========================================================================
     SUB-NAVIGATION PILLS (MATCHING USER REFERENCE DESIGN)
     ======================================================================== -->
<div class="flex items-center space-x-3 overflow-x-auto no-scrollbar mb-6 pb-1">
	<a href="<?= site_url('layanan-mandiri/permohonan-surat'); ?>" class="inline-flex items-center space-x-2.5 px-6 py-3 rounded-xl text-sm sm:text-base font-bold transition-all text-decoration-none <?= ($kat == 1) ? 'bg-[#10b981] text-white shadow-xs' : 'bg-white text-slate-700 hover:text-emerald-600 border border-slate-200' ?>">
		<i class="fa-solid fa-file-lines text-sm"></i>
		<span>Permohonan Surat</span>
	</a>

	<a href="<?= site_url('layanan-mandiri/surat/buat'); ?>" class="inline-flex items-center space-x-2.5 px-6 py-3 rounded-xl text-sm sm:text-base font-semibold transition-all text-decoration-none bg-white text-slate-700 hover:text-emerald-600 hover:bg-slate-50 border border-slate-200">
		<i class="fa-solid fa-pen-to-square text-sm"></i>
		<span>Buat Surat</span>
	</a>

	<a href="<?= site_url('layanan-mandiri/arsip-surat'); ?>" class="inline-flex items-center space-x-2.5 px-6 py-3 rounded-xl text-sm sm:text-base font-bold transition-all text-decoration-none <?= ($kat == 2) ? 'bg-[#10b981] text-white shadow-xs' : 'bg-white text-slate-700 hover:text-emerald-600 border border-slate-200' ?>">
		<i class="fa-solid fa-box-archive text-sm"></i>
		<span>Arsip Surat</span>
	</a>
</div>

<!-- ========================================================================
     DATA TABLE CARD CONTAINER (MATCHING USER REFERENCE DESIGN)
     ======================================================================== -->
<div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs p-6 sm:p-7 mb-6">
	
	<!-- Card Title & Subtitle -->
	<div class="mb-6">
		<h3 class="text-xl sm:text-2xl font-bold font-display text-slate-900 leading-tight">
			<?= ($kat == 1) ? 'Daftar Permohonan Surat' : 'Daftar Arsip Surat Selesai'; ?>
		</h3>
		<p class="text-sm sm:text-base text-slate-500 mt-1">
			<?= ($kat == 1) ? 'Berikut adalah daftar permohonan surat yang Anda ajukan.' : 'Berikut adalah arsip dokumen surat yang telah selesai diterbitkan pemerintah desa.'; ?>
		</p>
	</div>

	<!-- Controls Bar: Show Entries + Search Box -->
	<div class="flex flex-col sm:flex-row items-stretch sm:items-center justify-between gap-4 mb-5">
		<div class="flex items-center space-x-2.5 text-sm sm:text-base text-slate-600">
			<span>Tampilkan</span>
			<select id="tabel-length-select" class="px-3.5 py-2 rounded-xl border border-slate-200 bg-white text-slate-700 text-sm sm:text-base font-semibold focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 outline-none cursor-pointer">
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
			<input type="text" id="tabel-filter-input" placeholder="<?= ($kat == 1) ? 'Cari nomor antrean, jenis surat...' : 'Cari nomor surat, jenis surat...'; ?>" class="w-full sm:w-80 pl-11 pr-4 py-2.5 rounded-xl border border-slate-200 text-sm sm:text-base text-slate-700 placeholder-slate-400 focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 outline-none">
		</div>
	</div>

	<!-- Table Content -->
	<?php if (empty($main)) : ?><div class="overflow-x-auto w-full"><?php endif; ?>
		<?php if ($kat == 1) : ?>
			<table class="table table-bordered table-hover w-full" id="tabeldata">
				<thead>
					<tr class="bg-slate-50 text-slate-700 text-xs sm:text-sm font-bold uppercase tracking-wider">
						<th class="py-3.5 px-3 text-center" style="width: 50px;">NO</th>
						<th class="py-3.5 px-3 text-center" style="width: 140px;">AKSI</th>
						<th class="py-3.5 px-4 text-center" style="width: 150px;">NO ANTREAN</th>
						<th class="py-3.5 px-4">JENIS SURAT</th>
						<th class="py-3.5 px-4 text-center" style="width: 180px;">TANGGAL KIRIM</th>
					</tr>
				</thead>
				<tbody>
					<?php if (!empty($main)) : ?>
						<?php foreach ($main as $key => $data) : ?>
							<tr class="text-sm sm:text-base <?= ($data['status_id'] == 0) ? 'bg-amber-50/40' : ''; ?>">
								<td class="text-center font-semibold text-slate-500"><?= ($key + 1); ?></td>
								<td class="text-center whitespace-nowrap">
									<div class="inline-flex items-center gap-1.5 flex-wrap justify-center">
										<?php if ($data['status_id'] == 0) : ?>
											<a href="<?= site_url("layanan-mandiri/surat/buat/{$data['id']}"); ?>" class="inline-flex items-center px-3 py-1.5 rounded-lg bg-amber-600 text-white text-xs sm:text-sm font-bold hover:bg-amber-700 shadow-2xs transition-colors" title="Lengkapi data surat">
												<i class="fa-solid fa-circle-exclamation mr-1 text-xs"></i> Lengkapi
											</a>
										<?php elseif ($data['status_id'] == 1) : ?>
											<span class="inline-flex items-center px-3 py-1.5 rounded-lg bg-sky-100 text-sky-800 text-xs sm:text-sm font-semibold border border-sky-200">
												<i class="fa-solid fa-spinner fa-spin mr-1 text-xs"></i> <?= $data['status']; ?>
											</span>
										<?php elseif ($data['status_id'] == 2) : ?>
											<span class="inline-flex items-center px-3 py-1.5 rounded-lg bg-purple-100 text-purple-800 text-xs sm:text-sm font-semibold border border-purple-200">
												<i class="fa-solid fa-pen-nib mr-1 text-xs"></i> <?= $data['status']; ?>
											</span>
										<?php elseif ($data['status_id'] == 3) : ?>
											<span class="inline-flex items-center px-3 py-1.5 rounded-lg bg-emerald-100 text-emerald-800 text-xs sm:text-sm font-semibold border border-emerald-200">
												<i class="fa-solid fa-circle-check mr-1 text-xs"></i> <?= $data['status']; ?>
											</span>
										<?php elseif ($data['status_id'] == 4) : ?>
											<span class="inline-flex items-center px-3 py-1.5 rounded-lg bg-teal-100 text-teal-800 text-xs sm:text-sm font-semibold border border-teal-200">
												<i class="fa-solid fa-check-double mr-1 text-xs"></i> <?= $data['status']; ?>
											</span>
										<?php else : ?>
											<span class="inline-flex items-center px-3 py-1.5 rounded-lg bg-rose-100 text-rose-800 text-xs sm:text-sm font-semibold border border-rose-200">
												<i class="fa-solid fa-ban mr-1 text-xs"></i> <?= $data['status']; ?>
											</span>
										<?php endif; ?>

										<?php if (in_array($data['status_id'], ['0', '1'])) : ?>
											<a href="<?= site_url("layanan-mandiri/surat/hapus/{$data['id']}"); ?>" class="p-2 rounded-lg bg-rose-50 text-rose-600 hover:bg-rose-100 text-sm transition-colors aksi-hapus" title="Batalkan permohonan">
												<i class="fa-solid fa-trash-can"></i>
											</a>
										<?php endif; ?>
									</div>
								</td>
								<td class="text-center font-mono font-bold text-slate-800"><?= $data['no_antrean'] ?? '-'; ?></td>
								<td class="font-semibold text-slate-800"><?= $data['jenis_surat'] ?? $data['nama_surat'] ?? $data['format_surat'] ?? '-'; ?></td>
								<td class="text-center text-xs sm:text-sm text-slate-500 whitespace-nowrap"><?= tgl_indo2($data['created_at']); ?></td>
							</tr>
						<?php endforeach; ?>
					<?php else : ?>
						<!-- EMPTY STATE (MATCHING USER REFERENCE DESIGN) -->
						<tr>
							<td class="text-center py-16 px-4" colspan="5">
								<div class="max-w-md mx-auto flex flex-col items-center justify-center">
									<!-- Floating Tray with Document Illustration -->
									<div class="w-24 h-24 mb-3 flex items-center justify-center relative">
										<svg width="90" height="90" viewBox="0 0 90 90" fill="none" xmlns="http://www.w3.org/2000/svg">
											<!-- Soft ground shadow -->
											<ellipse cx="45" cy="76" rx="38" ry="7" fill="#E2E8F0" fill-opacity="0.7"/>
											<!-- Floating Document Paper -->
											<path d="M33 16C33 13.7909 34.7909 12 37 12H53L61 20V46C61 48.2091 59.2091 50 57 50H37C34.7909 50 33 48.2091 33 46V16Z" fill="#FFFFFF" stroke="#94A3B8" stroke-width="2"/>
											<path d="M53 12V20H61" stroke="#94A3B8" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
											<line x1="40" y1="26" x2="52" y2="26" stroke="#94A3B8" stroke-width="2" stroke-linecap="round"/>
											<line x1="40" y1="33" x2="55" y2="33" stroke="#CBD5E1" stroke-width="2" stroke-linecap="round"/>
											<line x1="40" y1="40" x2="49" y2="40" stroke="#CBD5E1" stroke-width="2" stroke-linecap="round"/>
											<!-- Inbox Container -->
											<path d="M18 50L26 72H64L72 50H58L54 58H36L32 50H18Z" fill="#818CF8" fill-opacity="0.3" stroke="#6366F1" stroke-width="2.5" stroke-linejoin="round"/>
											<!-- Pastel Dots -->
											<circle cx="20" cy="30" r="3" fill="#6EE7B7" fill-opacity="0.8"/>
											<circle cx="72" cy="34" r="2.5" fill="#FDE047" fill-opacity="0.9"/>
											<circle cx="28" cy="42" r="2" fill="#F472B6" fill-opacity="0.7"/>
										</svg>
									</div>

									<h4 class="text-lg font-bold text-slate-800 mb-1 font-display">
										Belum ada data permohonan surat
									</h4>
									<p class="text-sm text-slate-500 text-center leading-relaxed">
										Data akan muncul setelah Anda mengajukan permohonan surat.
									</p>
								</div>
							</td>
						</tr>
					<?php endif; ?>
				</tbody>
			</table>
		<?php else : ?>
			<!-- ARSIP SURAT SELESAI -->
			<table class="table table-bordered table-hover w-full" id="tabeldata">
				<thead>
					<tr class="bg-slate-50 text-slate-700 text-xs sm:text-sm font-bold uppercase tracking-wider">
						<th class="py-3.5 px-3 text-center" style="width: 50px;">NO</th>
						<th class="py-3.5 px-3 text-center" style="width: 140px;">AKSI</th>
						<th class="py-3.5 px-4 text-center" style="width: 160px;">NOMOR SURAT</th>
						<th class="py-3.5 px-4">JENIS SURAT</th>
						<th class="py-3.5 px-4 text-center" style="width: 180px;">TANGGAL KIRIM</th>
					</tr>
				</thead>
				<tbody>
					<?php if (!empty($main)) : ?>
						<?php foreach ($main as $key => $data) : ?>
							<tr class="text-sm sm:text-base">
								<td class="text-center font-semibold text-slate-500"><?= ($key + 1); ?></td>
								<td class="text-center whitespace-nowrap">
									<a href="<?= site_url("layanan-mandiri/surat/cetak/{$data['id']}"); ?>" target="_blank" class="inline-flex items-center px-3.5 py-1.5 rounded-lg bg-emerald-600 hover:bg-emerald-700 text-white text-xs sm:text-sm font-bold shadow-2xs transition-colors" title="Unduh / Cetak surat">
										<i class="fa-solid fa-download mr-1.5 text-xs"></i> Unduh
									</a>
								</td>
								<td class="text-center font-mono font-bold text-slate-800"><?= $data['no_surat'] ?? '-'; ?></td>
								<td class="font-semibold text-slate-800"><?= $data['format'] ?? $data['nama_surat'] ?? '-'; ?></td>
								<td class="text-center text-xs sm:text-sm text-slate-500 whitespace-nowrap"><?= tgl_indo2($data['tanggal']); ?></td>
							</tr>
						<?php endforeach; ?>
					<?php else : ?>
						<!-- EMPTY STATE ARSIP -->
						<tr>
							<td class="text-center py-16 px-4" colspan="5">
								<div class="max-w-md mx-auto flex flex-col items-center justify-center">
									<div class="w-16 h-16 rounded-2xl bg-slate-100 flex items-center justify-center text-slate-400 mb-3 text-2xl">
										<i class="fa-solid fa-box-open"></i>
									</div>
									<h4 class="text-lg font-bold text-slate-800 mb-1 font-display">
										Belum ada arsip surat selesai
									</h4>
									<p class="text-sm text-slate-500 text-center leading-relaxed">
										Surat yang telah ditandatangani dan diterbitkan akan tersimpan otomatis di sini.
									</p>
								</div>
							</td>
						</tr>
					<?php endif; ?>
				</tbody>
			</table>
		<?php endif; ?>
	<?php if (empty($main)) : ?></div><?php endif; ?>

	<?php if (empty($main)) : ?>
		<!-- Static empty footer -->
		<div class="flex flex-col sm:flex-row items-center justify-between gap-3 pt-4 border-t border-slate-100 text-sm text-slate-500">
			<div>Menampilkan 0 sampai 0 dari 0 entri</div>
		</div>
	<?php endif; ?>

</div>

<style>
	/* Mobile-First DataTables Footer & Pagination */
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
		background: #0284c7 !important;
		border-color: #0284c7 !important;
		color: #ffffff !important;
		box-shadow: 0 1px 3px 0 rgba(2, 132, 199, 0.3) !important;
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
		<?php if (!empty($main)) : ?>
		var tabelSurat = $('#tabeldata').DataTable({
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
			tabelSurat.page.len(len).draw();
		});

		// Custom Search Box
		$('#tabel-filter-input').on('keyup input', function() {
			tabelSurat.search(this.value).draw();
		});

		// Update numbering column dynamically on page/search/order
		tabelSurat.on('draw.dt', function() {
			var pageInfo = tabelSurat.page.info();
			tabelSurat.column(0, { page: 'current' }).nodes().each(function(cell, i) {
				cell.innerHTML = i + 1 + pageInfo.start;
			});
		});
		<?php else : ?>
		$('#tabel-length-select').prop('disabled', true);
		$('#tabel-filter-input').prop('disabled', true);
		<?php endif; ?>
	});
</script>
