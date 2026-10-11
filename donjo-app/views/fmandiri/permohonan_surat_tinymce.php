<?php

defined('BASEPATH') || exit('No direct script access allowed');

/*
 * File ini:
 *
 * View modul Layanan Mandiri > Surat > Permohonan Surat (TinyMCE)
 * Redesigned with Next-Gen UI/UX Pro Max (Tema Desa Balongbesuk)
 *
 * donjo-app/views/fmandiri/permohonan_surat_tinymce.php
 */

$nama_surat_judul = $surat->nama ?? 'Permohonan Surat';
?>

<!-- ========================================================================
     SUB-NAVIGATION PILLS (MATCHING USER REFERENCE DESIGN)
     ======================================================================== -->
<div class="flex items-center space-x-3 overflow-x-auto no-scrollbar mb-6 pb-1">
	<a href="<?= site_url('layanan-mandiri/permohonan-surat'); ?>" class="inline-flex items-center space-x-2.5 px-6 py-3 rounded-xl text-sm sm:text-base font-semibold transition-all text-decoration-none bg-white text-slate-700 hover:text-emerald-600 hover:bg-slate-50 border border-slate-200">
		<i class="fa-solid fa-file-lines text-sm"></i>
		<span>Permohonan Surat</span>
	</a>

	<a href="<?= site_url('layanan-mandiri/surat/buat'); ?>" class="inline-flex items-center space-x-2.5 px-6 py-3 rounded-xl text-sm sm:text-base font-bold transition-all text-decoration-none bg-[#10b981] text-white shadow-xs">
		<i class="fa-solid fa-pen-to-square text-sm"></i>
		<span>Buat Surat</span>
	</a>

	<a href="<?= site_url('layanan-mandiri/arsip-surat'); ?>" class="inline-flex items-center space-x-2.5 px-6 py-3 rounded-xl text-sm sm:text-base font-semibold transition-all text-decoration-none bg-white text-slate-700 hover:text-emerald-600 hover:bg-slate-50 border border-slate-200">
		<i class="fa-solid fa-box-archive text-sm"></i>
		<span>Arsip Surat</span>
	</a>
</div>

<!-- ========================================================================
     PAGE TITLE & BREADCRUMB CARD
     ======================================================================== -->
<div class="relative bg-white rounded-2xl border border-slate-200/80 p-5 sm:p-6 mb-6 shadow-xs overflow-hidden flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
	<div class="flex items-center space-x-4 z-10">
		<div class="w-12 h-12 sm:w-14 sm:h-14 rounded-2xl bg-emerald-600 text-white flex items-center justify-center text-xl sm:text-2xl shadow-sm flex-shrink-0">
			<i class="fa-solid fa-file-signature"></i>
		</div>
		<div>
			<span class="text-xs font-bold uppercase tracking-wider text-emerald-600 bg-emerald-50 px-2.5 py-1 rounded-md border border-emerald-200/80 mb-1 inline-block">
				Formulir Permohonan
			</span>
			<h2 class="text-xl sm:text-2xl lg:text-3xl font-extrabold font-display text-slate-900 leading-tight">
				<?= $nama_surat_judul; ?>
			</h2>
			<nav class="flex items-center space-x-2 text-xs sm:text-sm text-slate-400 font-medium mt-1">
				<a href="<?= site_url('layanan-mandiri/beranda') ?>" class="hover:text-emerald-600 transition-colors text-decoration-none text-slate-400">Beranda</a>
				<span>&rsaquo;</span>
				<a href="<?= site_url('layanan-mandiri/permohonan-surat') ?>" class="hover:text-emerald-600 transition-colors text-decoration-none text-slate-400">Surat</a>
				<span>&rsaquo;</span>
				<a href="<?= site_url('layanan-mandiri/surat/buat') ?>" class="hover:text-emerald-600 transition-colors text-decoration-none text-slate-400">Buat Surat</a>
				<span>&rsaquo;</span>
				<span class="text-slate-600 font-semibold truncate max-w-[200px]"><?= $nama_surat_judul; ?></span>
			</nav>
		</div>
	</div>

	<!-- Back Button -->
	<div>
		<a href="<?= site_url('layanan-mandiri/surat/buat') ?>" class="inline-flex items-center space-x-2 px-4 py-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-sm font-semibold transition-all text-decoration-none border border-slate-200">
			<i class="fa-solid fa-arrow-left text-xs"></i>
			<span>Pilih Surat Lain</span>
		</a>
	</div>
</div>

<!-- ========================================================================
     STEP PROGRESS BAR (MATCHING BUAT SURAT)
     ======================================================================== -->
<div class="mb-6 p-5 sm:p-6 rounded-2xl bg-white border border-slate-200/90 shadow-xs">
	<div class="flex items-center justify-between max-w-2xl mx-auto">
		<!-- Step 1: Selesai -->
		<div class="flex items-center space-x-3">
			<span class="w-9 h-9 sm:w-10 sm:h-10 rounded-xl bg-emerald-100 text-emerald-700 flex items-center justify-center text-sm font-bold flex-shrink-0">
				<i class="fa-solid fa-check"></i>
			</span>
			<div>
				<span class="text-sm sm:text-base font-bold text-slate-900 block leading-tight font-display">Pilih Surat</span>
				<span class="text-xs text-emerald-600 font-semibold hidden sm:block mt-0.5">Selesai</span>
			</div>
		</div>
		
		<div class="h-0.5 flex-1 mx-3 sm:mx-6 bg-emerald-400"></div>

		<!-- Step 2: Aktif (Formulir) -->
		<div class="flex items-center space-x-3">
			<span class="w-9 h-9 sm:w-10 sm:h-10 rounded-xl flex items-center justify-center text-sm font-bold shadow-md shadow-emerald-500/30 flex-shrink-0" style="background-color: #10b981 !important; color: #ffffff !important;">
				2
			</span>
			<div>
				<span class="text-sm sm:text-base font-bold text-slate-900 block leading-tight font-display">Isian Formulir</span>
				<span class="text-xs text-emerald-600 font-semibold hidden sm:block mt-0.5">Sedang diisi</span>
			</div>
		</div>

		<div class="h-0.5 flex-1 mx-3 sm:mx-6 bg-slate-200"></div>

		<!-- Step 3: Pending -->
		<div class="flex items-center space-x-3">
			<span class="w-9 h-9 sm:w-10 sm:h-10 rounded-xl bg-slate-100 text-slate-500 flex items-center justify-center text-sm font-bold flex-shrink-0">
				3
			</span>
			<div>
				<span class="text-sm sm:text-base font-bold text-slate-600 block leading-tight font-display">Kirim Permohonan</span>
				<span class="text-xs text-slate-400 font-normal hidden sm:block mt-0.5">Langkah akhir</span>
			</div>
		</div>
	</div>
</div>

<!-- ========================================================================
     DATA IDENTITAS PEMOHON (CARD MODERN & ELEGAN)
     ======================================================================== -->
<?php if (!empty($individu)): ?>
<div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs p-6 sm:p-7 mb-6">
	<div class="flex items-center justify-between pb-4 border-b border-slate-100 mb-5">
		<div class="flex items-center space-x-3">
			<div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 border border-emerald-200/60 flex items-center justify-center text-base">
				<i class="fa-solid fa-id-card"></i>
			</div>
			<div>
				<h3 class="text-base sm:text-lg font-bold text-slate-900 leading-tight">Data Identitas Pemohon</h3>
				<p class="text-xs sm:text-sm text-slate-400">Data kependudukan terverifikasi dari arsip pelayanan desa</p>
			</div>
		</div>
		<span class="inline-flex items-center space-x-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">
			<i class="fa-solid fa-circle-check text-[10px]"></i>
			<span>Terverifikasi</span>
		</span>
	</div>

	<!-- Grid Data Pemohon -->
	<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
		<div class="p-4 rounded-xl bg-slate-50 border border-slate-100">
			<span class="text-[11px] font-bold uppercase tracking-wider text-slate-400 block mb-1">NIK & Nama Lengkap</span>
			<p class="text-sm font-extrabold text-slate-900 leading-snug"><?= $individu['nama']; ?></p>
			<p class="text-xs font-mono text-slate-500 mt-0.5"><?= $individu['nik']; ?></p>
		</div>

		<div class="p-4 rounded-xl bg-slate-50 border border-slate-100">
			<span class="text-[11px] font-bold uppercase tracking-wider text-slate-400 block mb-1">Tempat, Tgl Lahir / Usia</span>
			<p class="text-sm font-bold text-slate-800 leading-snug"><?= ucwords(strtolower($individu['tempatlahir'] ?? '')); ?>, <?= !empty($individu['tanggallahir']) ? tgl_indo2($individu['tanggallahir']) : '-'; ?></p>
			<p class="text-xs text-slate-500 mt-0.5"><?= $individu['umur'] ?? '-'; ?> Tahun (<?= ($individu['sex'] == 1) ? 'Laki-Laki' : 'Perempuan'; ?>)</p>
		</div>

		<div class="p-4 rounded-xl bg-slate-50 border border-slate-100">
			<span class="text-[11px] font-bold uppercase tracking-wider text-slate-400 block mb-1">Alamat Domisili</span>
			<p class="text-sm font-bold text-slate-800 leading-snug truncate" title="<?= $individu['alamat_wilayah'] ?? $individu['alamat'] ?? ''; ?>"><?= $individu['alamat_wilayah'] ?? $individu['alamat'] ?? '-'; ?></p>
			<p class="text-xs text-slate-500 mt-0.5">Desa <?= $desa['nama_desa'] ?? ''; ?></p>
		</div>

		<div class="p-4 rounded-xl bg-slate-50 border border-slate-100">
			<span class="text-[11px] font-bold uppercase tracking-wider text-slate-400 block mb-1">Agama & Pekerjaan</span>
			<p class="text-sm font-bold text-slate-800 leading-snug"><?= $individu['pekerjaan'] ?: '-'; ?></p>
			<p class="text-xs text-slate-500 mt-0.5"><?= $individu['agama'] ?? '-'; ?> &bull; <?= $individu['warganegara'] ?? 'WNI'; ?></p>
		</div>
	</div>
</div>
<?php endif; ?>

<!-- ========================================================================
     FORMULIR ISIAN SURAT (CONTAINER UTAMA MODERN)
     ======================================================================== -->
<div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs p-6 sm:p-8 mb-6">
	
	<!-- Header Isian Surat -->
	<div class="flex items-center space-x-3 pb-5 border-b border-slate-100 mb-6">
		<div class="w-10 h-10 rounded-xl bg-sky-50 text-sky-600 border border-sky-200/60 flex items-center justify-center text-base">
			<i class="fa-solid fa-pen-to-square"></i>
		</div>
		<div>
			<h3 class="text-base sm:text-lg font-bold text-slate-900 leading-tight">Kelengkapan Data Surat</h3>
			<p class="text-xs sm:text-sm text-slate-400">Lengkapi kolom isian di bawah ini untuk penerbitan surat</p>
		</div>
	</div>

	<!-- WRAPPER FORM ASLI OPENSID -->
	<div id="wrapper-mandiri">
		<div class="box-body permohonan-surat">
			<form id="validasi" action="<?= $form_action ?>" method="POST" target="_blank" class="form-surat form-horizontal">
				<input type="hidden" id="url_surat" name="url_surat" value="<?= $url ?>">
				<input type="hidden" id="url_remote" name="url_remote" value="<?= site_url('surat/nomor_surat_duplikat') ?>">
				
				<div class="form-group cari_nik">
					<label for="nik" class="col-sm-3 control-label">NIK / Nama <?= $pemohon ?></label>
					<div class="col-sm-6 col-lg-4">
						<select class="form-control input-sm readonly-permohonan readonly-periksa" id="nik" name="nik" style="width:100%;">
							<?php if ($individu): ?>
								<option value="<?= $individu['id'] ?>" selected><?= $individu['nik'] . ' - ' . $individu['tag_id_card'] . ' - ' . $individu['nama'] ?></option>
							<?php endif; ?>
						</select>
					</div>
				</div>

				<?php if ($individu): ?>
					<?php $this->load->view('surat/form/konfirmasi_pemohon.php'); ?>
				<?php endif; ?>

				<div class="row jar_form">
					<label for="nomor" class="col-sm-3"></label>
					<div class="col-sm-8">
						<input class="required" type="hidden" name="nik" value="<?= $individu['id'] ?>">
					</div>
				</div>

				<?php $this->load->view('surat/form/nomor_surat'); ?>
				<?php include FCPATH . config_item('views_blade') . '/admin/surat/kode_isian.blade.php' ?>
				<?php
					$this->load->view('surat/form/tgl_berlaku');
					$this->load->view('surat/form/_pamong');
				?>
			</form>

			<textarea id="isian_form" hidden="hidden"><?= $isian_form; ?></textarea>
		</div>
		<?php $this->load->view('surat/form/tombol_cetak.php'); ?>
	</div>

</div>

<!-- ========================================================================
     STYLING KHUSUS UNTUK MENYELARASKAN FORM OPENSID DENGAN UI/UX PRO MAX
     ======================================================================== -->
<style>
/* 1. RESET CLEARFIX & PSEUDO ELEMENTS BOOTSTRAP */
#wrapper-mandiri .form-group::before,
#wrapper-mandiri .form-group::after,
#wrapper-mandiri .row::before,
#wrapper-mandiri .row::after {
	display: none !important;
	content: none !important;
}

/* 2. SEMBUNYIKAN SEMUA ELEMEN KHUSUS ADMIN DI LAYANAN MANDIRI */
#wrapper-mandiri .tdk-permohonan,
#wrapper-mandiri .tdk-periksa,
#wrapper-mandiri .breadcrumb,
#wrapper-mandiri .content-header,
#wrapper-mandiri .box-header,
#wrapper-mandiri .jar_form,
#wrapper-mandiri .cari_nik,
#wrapper-mandiri .konfirmasi,
#wrapper-mandiri .form-group.konfirmasi,
#wrapper-mandiri .form-group.tdk-permohonan,
#wrapper-mandiri .form-group.tdk-periksa,
#wrapper-mandiri .box-header.admin,
#wrapper-mandiri h1.judul-surat,
#wrapper-mandiri .callout,
#wrapper-mandiri form#main,
#wrapper-mandiri hr,
#wrapper-mandiri input[name="tampil_foto"],
#wrapper-mandiri label[for="tampil_foto"],
#wrapper-mandiri .btn-group[data-toggle="buttons"] {
	display: none !important;
}

/* 3. RESET BOX ADMINLTE AGAR MENYATU DENGAN CARD TAILWIND */
#wrapper-mandiri,
#wrapper-mandiri .box,
#wrapper-mandiri .box-solid,
#wrapper-mandiri .box-info,
#wrapper-mandiri .box-body,
#wrapper-mandiri .content-wrapper,
#wrapper-mandiri .content,
#wrapper-mandiri .row,
#wrapper-mandiri .permohonan-surat {
	background: transparent !important;
	border: none !important;
	box-shadow: none !important;
	padding: 0 !important;
	margin: 0 !important;
	min-height: 0 !important;
}

/* 4. CONTAINER FORM */
#wrapper-mandiri .form-surat,
#wrapper-mandiri form#validasi {
	display: flex !important;
	flex-direction: column !important;
	gap: 1.5rem !important;
	width: 100% !important;
}

/* 5. FORM GROUP: STACKED LAYOUT (LABEL DI ATAS, INPUT DI BAWAH) */
#wrapper-mandiri .form-group {
	display: flex !important;
	flex-direction: column !important;
	gap: 0.5rem !important;
	margin: 0 !important;
	padding: 0 !important;
	width: 100% !important;
	border: none !important;
}

/* 6. LABEL FORM ELEGAN SESUAI GAYA TAMPILAN LAIN */
#wrapper-mandiri label,
#wrapper-mandiri .control-label,
#wrapper-mandiri .form-group > label {
	display: block !important;
	width: 100% !important;
	text-align: left !important;
	font-family: 'Outfit', sans-serif !important;
	font-size: 0.95rem !important;
	font-weight: 700 !important;
	color: #1e293b !important; /* slate-800 */
	padding: 0 !important;
	margin: 0 0 0.25rem 0 !important;
	float: none !important;
	line-height: 1.4 !important;
}

/* 7. RESET KOLOM BOOTSTRAP */
#wrapper-mandiri [class*="col-"] {
	display: block !important;
	width: 100% !important;
	max-width: 100% !important;
	padding: 0 !important;
	margin: 0 !important;
	float: none !important;
}

/* 8. INPUT, SELECT, TEXTAREA MODERN SESUAI MOCKUP & TAMPILAN LAIN */
#wrapper-mandiri #isian_form,
#wrapper-mandiri textarea#isian_form {
	display: none !important;
}

#wrapper-mandiri .form-control,
#wrapper-mandiri input[type="text"]:not(#isian_form),
#wrapper-mandiri input[type="number"],
#wrapper-mandiri input[type="date"],
#wrapper-mandiri select,
#wrapper-mandiri textarea:not(#isian_form) {
	display: block !important;
	width: 100% !important;
	max-width: 100% !important;
	min-height: 48px !important;
	border-radius: 0.75rem !important; /* 12px rounded-xl */
	border: 1.5px solid #cbd5e1 !important; /* slate-300 */
	padding: 0.75rem 1rem !important;
	font-size: 0.95rem !important;
	color: #0f172a !important; /* slate-900 */
	background-color: #ffffff !important;
	transition: all 0.2s ease-in-out !important;
	box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.04) !important;
	font-family: 'Inter', sans-serif !important;
	outline: none !important;
}

#wrapper-mandiri .form-control:focus,
#wrapper-mandiri input:focus,
#wrapper-mandiri select:focus,
#wrapper-mandiri textarea:focus {
	border-color: #10b981 !important; /* emerald-500 */
	box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.15) !important;
}

#wrapper-mandiri textarea:not(#isian_form),
#wrapper-mandiri textarea.form-control:not(#isian_form) {
	min-height: 120px !important;
	line-height: 1.6 !important;
	resize: vertical !important;
}

/* 9. INPUT GROUP / DATEPICKER MODERN INTEGRATED */
#wrapper-mandiri .input-group {
	display: flex !important;
	align-items: stretch !important;
	width: 100% !important;
	max-width: 100% !important;
	border-radius: 0.75rem !important; /* 12px rounded-xl */
	border: 1.5px solid #cbd5e1 !important;
	background-color: #ffffff !important;
	overflow: hidden !important;
	box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.04) !important;
	transition: all 0.2s ease-in-out !important;
}

#wrapper-mandiri .input-group:focus-within {
	border-color: #10b981 !important;
	box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.15) !important;
}

#wrapper-mandiri .input-group > .input-group-addon {
	display: flex !important;
	align-items: center !important;
	justify-content: center !important;
	background-color: #f8fafc !important;
	border: none !important;
	border-right: 1.5px solid #e2e8f0 !important;
	border-radius: 0 !important;
	padding: 0 1rem !important;
	color: #059669 !important;
	font-size: 1rem !important;
	cursor: pointer !important;
	flex-shrink: 0 !important;
	transition: all 0.2s ease !important;
}

#wrapper-mandiri .input-group > .input-group-addon:hover {
	background-color: #ecfdf5 !important;
	color: #047857 !important;
}

#wrapper-mandiri .input-group > .form-control,
#wrapper-mandiri .input-group > input {
	display: block !important;
	border: none !important;
	border-radius: 0 !important;
	box-shadow: none !important;
	padding: 0.75rem 1rem !important;
	width: 100% !important;
	flex: 1 1 auto !important;
	min-height: 48px !important;
	outline: none !important;
	background: transparent !important;
	font-size: 0.95rem !important;
	color: #0f172a !important;
	font-family: 'Inter', sans-serif !important;
}

/* TATA LETAK 2 KOLOM UNTUK RENTANG TANGGAL DARI - SAMPAI */
#wrapper-mandiri .form-group:has(.input-group) {
	display: grid !important;
	grid-template-columns: 1fr !important;
	gap: 1rem !important;
}

@media (min-width: 640px) {
	#wrapper-mandiri .form-group:has(> div:nth-of-type(2)) {
		grid-template-columns: repeat(2, minmax(0, 1fr)) !important;
		align-items: start !important;
		gap: 1.25rem !important;
	}
	#wrapper-mandiri .form-group:has(> div:nth-of-type(2)) > label {
		grid-column: 1 / -1 !important;
		margin-bottom: 0 !important;
	}
}

.sub-label-tgl {
	font-family: 'Outfit', sans-serif;
	font-size: 0.8125rem;
	font-weight: 700;
	color: #475569;
	text-transform: uppercase;
	letter-spacing: 0.05em;
	margin-bottom: 0.35rem;
	display: flex;
	align-items: center;
}

/* POPUP BOOTSTRAP DATETIMEPICKER MODERN */
.bootstrap-datetimepicker-widget {
	border-radius: 1rem !important;
	border: 1px solid #e2e8f0 !important;
	box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 8px 10px -6px rgba(0, 0, 0, 0.1) !important;
	padding: 0.75rem !important;
	font-family: 'Inter', sans-serif !important;
	background: #ffffff !important;
	z-index: 9999 !important;
}

.bootstrap-datetimepicker-widget table td.active,
.bootstrap-datetimepicker-widget table td.active:hover {
	background-color: #10b981 !important;
	color: #ffffff !important;
	border-radius: 0.5rem !important;
	font-weight: bold !important;
}

.bootstrap-datetimepicker-widget table td.today:before {
	border-bottom-color: #10b981 !important;
}

.bootstrap-datetimepicker-widget .timepicker-picker table td a span {
	color: #059669 !important;
}

/* 10. SELECT2 MODERN STYLING */
#wrapper-mandiri .select2-container {
	width: 100% !important;
}

#wrapper-mandiri .select2-container .select2-selection--single {
	height: 48px !important;
	border-radius: 0.75rem !important;
	border: 1.5px solid #cbd5e1 !important;
	display: flex !important;
	align-items: center !important;
	padding: 0.5rem 0.75rem !important;
	box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.04) !important;
}

#wrapper-mandiri .select2-container--default .select2-selection--single .select2-selection__rendered {
	line-height: normal !important;
	padding-left: 0 !important;
	color: #0f172a !important;
	font-size: 0.95rem !important;
}

#wrapper-mandiri .select2-container--default .select2-selection--single .select2-selection__arrow {
	height: 46px !important;
	right: 10px !important;
}

/* 11. FOOTER & BUTTONS */
#wrapper-mandiri .box-footer {
	background: transparent !important;
	border-top: 1px solid #f1f5f9 !important;
	padding: 2rem 0 0 0 !important;
	margin-top: 1rem !important;
	display: flex !important;
	align-items: center !important;
	justify-content: space-between !important;
	gap: 1rem !important;
}

#wrapper-mandiri .box-footer .btn {
	border-radius: 0.75rem !important;
	font-weight: 700 !important;
	font-size: 0.95rem !important;
	padding: 0.75rem 1.75rem !important;
	display: inline-flex !important;
	align-items: center !important;
	gap: 0.5rem !important;
	transition: all 0.2s ease !important;
	cursor: pointer !important;
	text-decoration: none !important;
}

/* TOMBOL BATAL */
#wrapper-mandiri .box-footer .btn-danger,
#wrapper-mandiri .box-footer button[type="reset"] {
	background-color: #ffffff !important;
	color: #475569 !important;
	border: 1.5px solid #cbd5e1 !important;
	box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.04) !important;
	float: none !important;
	margin: 0 !important;
}

#wrapper-mandiri .box-footer .btn-danger:hover,
#wrapper-mandiri .box-footer button[type="reset"]:hover {
	background-color: #f8fafc !important;
	color: #0f172a !important;
	border-color: #94a3b8 !important;
}

/* TOMBOL KIRIM */
#wrapper-mandiri .box-footer #btn_kirim_mandiri,
#wrapper-mandiri .box-footer .btn-success,
#wrapper-mandiri .box-footer button[type="submit"] {
	background-color: #10b981 !important;
	color: #ffffff !important;
	border: 1.5px solid #059669 !important;
	box-shadow: 0 4px 6px -1px rgba(16, 185, 129, 0.2), 0 2px 4px -2px rgba(16, 185, 129, 0.2) !important;
	float: none !important;
	margin: 0 !important;
}

#wrapper-mandiri .box-footer #btn_kirim_mandiri:hover,
#wrapper-mandiri .box-footer .btn-success:hover,
#wrapper-mandiri .box-footer button[type="submit"]:hover {
	background-color: #059669 !important;
	transform: translateY(-1px) !important;
	box-shadow: 0 6px 12px -1px rgba(16, 185, 129, 0.25) !important;
}
</style>

<script type="text/javascript">
	$(document).ready(function() {
		// Sembunyikan elemen admin secara dinamis
		$("#wrapper-mandiri .readonly-permohonan").attr('disabled', true);
		$("#wrapper-mandiri form#validasi").removeAttr('target');
		$("#wrapper-mandiri .tdk-permohonan").hide();
		$("#wrapper-mandiri .tdk-periksa").hide();
		$("#wrapper-mandiri .konfirmasi").hide();
		$("#wrapper-mandiri .cari_nik").hide();
		$("#wrapper-mandiri select[name='pamong_id']").closest('.form-group').hide();
		$("#wrapper-mandiri select[name='pilih_atas_nama']").closest('.form-group').hide();
		$("#wrapper-mandiri input[name='nomor']").closest('.form-group').hide();
		$("#wrapper-mandiri input[name='tampil_foto']").closest('.form-group').hide();
		$("#wrapper-mandiri .tdk-permohonan textarea, #wrapper-mandiri .tdk-permohonan select, #wrapper-mandiri .tdk-permohonan input").removeClass('required');

		// Tambahkan Sub-Label & Placeholder untuk Rentang Tanggal Mulai - Selesai
		if ($('#tgljam_mulai').length) {
			$('#tgljam_mulai').attr('placeholder', 'Pilih Tanggal & Jam Mulai');
			if (!$('#tgljam_mulai').closest('.input-group').prev('.sub-label-tgl').length) {
				$('#tgljam_mulai').closest('.input-group').before('<div class="sub-label-tgl"><i class="fa-solid fa-clock-rotate-left mr-1.5 text-emerald-600"></i> Tanggal & Jam Mulai</div>');
			}
		}
		if ($('#tgljam_akhir').length) {
			$('#tgljam_akhir').attr('placeholder', 'Pilih Tanggal & Jam Selesai');
			if (!$('#tgljam_akhir').closest('.input-group').prev('.sub-label-tgl').length) {
				$('#tgljam_akhir').closest('.input-group').before('<div class="sub-label-tgl"><i class="fa-solid fa-flag-checkered mr-1.5 text-emerald-600"></i> Tanggal & Jam Selesai</div>');
			}
		}
		if ($('#tgl_mulai').length) {
			$('#tgl_mulai').attr('placeholder', 'Pilih Tanggal Mulai');
			if (!$('#tgl_mulai').closest('.input-group').prev('.sub-label-tgl').length) {
				$('#tgl_mulai').closest('.input-group').before('<div class="sub-label-tgl"><i class="fa-solid fa-calendar mr-1.5 text-emerald-600"></i> Tanggal Mulai Berlaku</div>');
			}
		}
		if ($('#tgl_akhir').length) {
			$('#tgl_akhir').attr('placeholder', 'Pilih Tanggal Selesai');
			if (!$('#tgl_akhir').closest('.input-group').prev('.sub-label-tgl').length) {
				$('#tgl_akhir').closest('.input-group').before('<div class="sub-label-tgl"><i class="fa-solid fa-calendar-check mr-1.5 text-emerald-600"></i> Tanggal Selesai Berlaku</div>');
			}
		}

		// Inisialisasi DateTimePicker jika belum aktif
		if (typeof $.fn.datetimepicker === 'function') {
			if ($('#tgljam_mulai').length && !$('#tgljam_mulai').data('DateTimePicker')) {
				$('#tgljam_mulai').datetimepicker({
					locale: 'id',
					format: 'DD-MM-YYYY HH:mm',
					sideBySide: true,
					stepping: 15,
					icons: {
						time: 'fa fa-clock-o',
						date: 'fa fa-calendar',
						up: 'fa fa-chevron-up',
						down: 'fa fa-chevron-down',
						previous: 'fa fa-chevron-left',
						next: 'fa fa-chevron-right',
						today: 'fa fa-crosshairs',
						clear: 'fa fa-trash',
						close: 'fa fa-times'
					}
				});
			}
			if ($('#tgljam_akhir').length && !$('#tgljam_akhir').data('DateTimePicker')) {
				$('#tgljam_akhir').datetimepicker({
					locale: 'id',
					format: 'DD-MM-YYYY HH:mm',
					sideBySide: true,
					stepping: 15,
					useCurrent: false,
					icons: {
						time: 'fa fa-clock-o',
						date: 'fa fa-calendar',
						up: 'fa fa-chevron-up',
						down: 'fa fa-chevron-down',
						previous: 'fa fa-chevron-left',
						next: 'fa fa-chevron-right',
						today: 'fa fa-crosshairs',
						clear: 'fa fa-trash',
						close: 'fa fa-times'
					}
				});
			}
			$('#tgljam_mulai').on('dp.change', function(e) {
				if ($('#tgljam_akhir').data('DateTimePicker') && e.date) {
					$('#tgljam_akhir').data('DateTimePicker').minDate(e.date);
				}
			});
		}

		// Klik pada addon kalender memicu fokus ke input date
		$('#wrapper-mandiri .input-group-addon').on('click', function() {
			$(this).closest('.input-group').find('input').focus();
		});

		// Inisialisasi pengisian form jika ada
		if ($('#isian_form').val()) {
			setTimeout(function() { isi_form(); }, 100);
		}
	});

	function isi_form() {
		var isian_form = JSON.parse($('#isian_form').val(), function(key, value) {
			if (key) {
				var elem = $('*[name=' + key + ']');
				elem.val(value);
				elem.change();
				if (elem.is(":hidden")) {
					var show = $('#' + key + '_show');
					show.val(value);
					show.change();
				}
			}
		});
	}
</script>
