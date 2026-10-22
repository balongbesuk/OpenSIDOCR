<?php

defined('BASEPATH') || exit('No direct script access allowed');

/*
 * File ini:
 *
 * View Template Layanan Mandiri
 * Rombak Total Sesuai Mockup UI/UX Pro Max (Tema Desa Balongbesuk)
 *
 * donjo-app/views/fmandiri/template.php
 */

$id_pend_login = $this->is_login->id_pend ?? null;
$nik_login     = $this->is_login->nik ?? null;

// Hitung pesan masuk belum dibaca
$unread_pesan_count = 0;
if ($nik_login) {
    $unread_pesan_count = (int) $this->db
        ->where('email', $nik_login)
        ->where('tipe', 2)
        ->where('status', 2)
        ->where('id_artikel', 775)
        ->count_all_results('komentar');
}

// Ambil notifikasi status permohonan surat terkini untuk warga
$notif_permohonan = [];
$active_permohonan_count = 0;
if ($id_pend_login) {
    $notif_permohonan = $this->db
        ->select('u.id, u.id_surat, u.status, u.no_antrian, u.created_at, u.updated_at, s.nama as nama_surat')
        ->from('permohonan_surat u')
        ->join('tweb_surat_format s', 'u.id_surat = s.id', 'left')
        ->where('u.id_pemohon', $id_pend_login)
        ->order_by('u.updated_at', 'DESC')
        ->limit(6)
        ->get()
        ->result_array();

    $active_permohonan_count = (int) $this->db
        ->from('permohonan_surat')
        ->where('id_pemohon', $id_pend_login)
        ->where_in('status', [
            \App\Models\PermohonanSurat::BELUM_LENGKAP,
            \App\Models\PermohonanSurat::SEDANG_DIPERIKSA,
            \App\Models\PermohonanSurat::MENUNGGU_TANDA_TANGAN,
            \App\Models\PermohonanSurat::SIAP_DIAMBIL
        ])
        ->count_all_results();
}
?>
<!DOCTYPE html>
<html lang="id" class="h-full bg-[#f0f2f5]">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title><?= $this->setting->admin_title . ' ' . ucwords($this->setting->sebutan_desa) . ' ' . $desa['nama_desa']; ?></title>
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
	<meta name="robots" content="noindex">

	<!-- Favicon -->
	<link rel="shortcut icon" href="<?= favico_desa() ?>" />
	<link rel="icon" type="image/png" sizes="32x32" href="<?= is_file(FCPATH . 'desa/logo/favicon-32x32.png') ? base_url('desa/logo/favicon-32x32.png?v=' . md5_file(FCPATH . 'desa/logo/favicon-32x32.png')) : favico_desa() ?>">
	<link rel="icon" type="image/png" sizes="16x16" href="<?= is_file(FCPATH . 'desa/logo/favicon-16x16.png') ? base_url('desa/logo/favicon-16x16.png?v=' . md5_file(FCPATH . 'desa/logo/favicon-16x16.png')) : favico_desa() ?>">

	<!-- Google Fonts: Inter & Outfit -->
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Outfit:wght@500;600;700;800&display=swap" rel="stylesheet">

	<!-- Font Awesome 6 Vector Icons -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

	<!-- Core Data & UI Plugins -->
	<link rel="stylesheet" href="<?= asset('bootstrap/css/bootstrap.min.css') ?>">
	<link rel="stylesheet" href="<?= asset('bootstrap/css/dataTables.bootstrap.min.css') ?>">
	<link rel="stylesheet" href="<?= asset('bootstrap/css/select2.min.css') ?>">
	<link rel="stylesheet" href="<?= asset('bootstrap/css/bootstrap-datetimepicker.min.css') ?>">
	<link rel="stylesheet" href="<?= asset('bootstrap/css/bootstrap-datepicker.min.css') ?>">
	<link rel="stylesheet" href="<?= asset('front/css/jquery-confirm.min.css') ?>">
	<link rel="stylesheet" href="<?= asset('bootstrap/css/jquery-ui.min.css') ?>">

	<?php if (cek_koneksi_internet()): ?>
		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/smartwizard@5/dist/css/smart_wizard_all.min.css">
	<?php endif ?>

	<?php if ($this->controller == 'lapak') : ?>
		<link rel="stylesheet" href="<?= base_url('assets/css/leaflet.css') ?>">
		<link rel="stylesheet" href="<?= base_url('assets/css/mapbox-gl.css') ?>">
		<link rel="stylesheet" href="<?= base_url('assets/css/peta.css') ?>">
	<?php endif; ?>

	<?php if ($cek_anjungan) : ?>
		<link rel="stylesheet" href="<?= base_url('assets/css/keyboard.min.css') ?>">
		<link rel="stylesheet" href="<?= base_url('assets/front/css/mandiri-keyboard.css') ?>">
	<?php endif; ?>

	<!-- Tailwind CSS CDN Engine -->
	<script src="https://cdn.tailwindcss.com"></script>
	<script>
		tailwind.config = {
			theme: {
				extend: {
					fontFamily: {
						sans: ['Inter', '-apple-system', 'BlinkMacSystemFont', 'Segoe UI', 'Roboto', 'sans-serif'],
						display: ['Outfit', '-apple-system', 'BlinkMacSystemFont', 'sans-serif'],
					},
					colors: {
						pageBg: '#f0f2f5',
						brand: {
							50: '#f0f9ff',
							100: '#e0f2fe',
							200: '#bae6fd',
							300: '#7dd3fc',
							400: '#38bdf8',
							500: '#0ea5e9',
							600: '#0284c7',
							700: '#0369a1',
							800: '#075985',
							900: '#0c4a6e',
						}
					}
				}
			}
		}
	</script>

	<!-- Precision Styling -->
	<style>
		html {
			font-size: 16px;
		}
		body {
			font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
			background-color: #f0f2f5 !important;
			color: #1e293b;
			-webkit-font-smoothing: antialiased;
		}
		@media (min-width: 1024px) {
			body {
				font-size: 15.5px !important;
				line-height: 1.6 !important;
			}
		}

		/* Bootstrap Overrides */
		a,
		a:hover,
		a:focus,
		a:active,
		a:visited {
			text-decoration: none !important;
		}
		@media (max-width: 767.98px) {
			.hide-on-mobile {
				display: none !important;
			}
		}
		.table-responsive {
			border: none !important;
		}
		.table-bordered {
			border: 1px solid #e2e8f0 !important;
			border-radius: 14px !important;
			overflow: hidden !important;
		}
		.table-bordered > thead > tr > th,
		.table-bordered > tbody > tr > td {
			border: 1px solid #f1f5f9 !important;
		}
		/* Typography & Table Sizing for Modern Desktop Readability */
		.table > thead > tr > th {
			background-color: #f8fafc !important;
			color: #475569 !important;
			font-weight: 700 !important;
			font-size: 0.875rem !important;
			text-transform: uppercase !important;
			letter-spacing: 0.05em !important;
			padding: 16px 18px !important;
			vertical-align: middle !important;
		}
		.table > tbody > tr > td {
			padding: 16px 18px !important;
			color: #1e293b !important;
			vertical-align: middle !important;
			font-size: 0.975rem !important;
			line-height: 1.6 !important;
		}
		.table-hover > tbody > tr:hover {
			background-color: #f8fafc !important;
		}

		/* DataTables styling clean up */
		.dataTables_wrapper .dataTables_paginate {
			margin-top: 0.5rem;
			display: flex;
			justify-content: center;
			flex-wrap: wrap;
			gap: 4px;
		}
		@media (min-width: 640px) {
			.dataTables_wrapper .dataTables_paginate {
				justify-content: flex-end;
			}
		}
		.dataTables_wrapper .dataTables_paginate .paginate_button {
			padding: 0.35rem 0.65rem !important;
			border-radius: 0.5rem !important;
			border: 1px solid #e2e8f0 !important;
			background: #ffffff !important;
			color: #475569 !important;
			font-size: 0.8125rem !important;
			font-weight: 600 !important;
			min-width: 32px;
			text-align: center;
		}
		@media (min-width: 640px) {
			.dataTables_wrapper .dataTables_paginate .paginate_button {
				padding: 0.5rem 0.875rem !important;
				font-size: 0.875rem !important;
				border-radius: 0.6rem !important;
				min-width: 36px;
			}
		}
		.dataTables_wrapper .dataTables_paginate .paginate_button.current,
		.dataTables_wrapper .dataTables_paginate .paginate_button.active > a {
			background: #0284c7 !important;
			color: #ffffff !important;
			border-color: #0284c7 !important;
		}
		.dataTables_filter input {
			border: 1px solid #cbd5e1 !important;
			border-radius: 0.75rem !important;
			padding: 9px 16px !important;
			font-size: 0.925rem !important;
			outline: none !important;
		}

		/* Custom Scrollbar */
		.no-scrollbar::-webkit-scrollbar {
			display: none !important;
		}
		.no-scrollbar {
			-ms-overflow-style: none !important;
			scrollbar-width: none !important;
		}

		/* Sidebar Links - Roomy, Premium & Legible */
		.nav-item-btn {
			display: flex;
			align-items: center;
			padding: 11px 18px;
			border-radius: 14px;
			font-size: 0.975rem;
			font-weight: 600;
			color: #475569;
			transition: all 0.15s ease;
			text-decoration: none !important;
			margin-bottom: 3px;
		}
		.nav-item-btn:hover {
			background-color: #f8fafc;
			color: #0284c7;
		}
		.nav-item-btn i {
			width: 24px;
			font-size: 1.15rem;
			margin-right: 14px;
			color: #64748b;
			text-align: center;
		}
		.nav-item-btn:hover i {
			color: #0284c7;
		}
		.nav-item-btn.active {
			background-color: #f0f9ff !important;
			color: #0284c7 !important;
			font-weight: 700 !important;
		}
		.nav-item-btn.active i {
			color: #0284c7 !important;
		}

		/* Top Beranda Pill */
		.nav-beranda-pill {
			display: flex;
			align-items: center;
			padding: 13px 20px;
			border-radius: 14px;
			font-size: 1.025rem;
			font-weight: 700;
			color: #ffffff;
			background-color: #0284c7;
			box-shadow: 0 4px 14px rgba(2, 132, 199, 0.32);
			text-decoration: none !important;
			transition: all 0.15s ease;
		}
		.nav-beranda-pill:hover {
			background-color: #0369a1;
			color: #ffffff;
		}
		.nav-beranda-pill i {
			margin-right: 14px;
			font-size: 1.15rem;
		}

		/* Search bar desktop controller */
		.app-search-bar {
			display: none;
		}
		@media (min-width: 640px) {
			.app-search-bar {
				display: block !important;
			}
		}

		/* Bottom Mobile Bar */
		.mobile-bottom-dock {
			position: fixed;
			bottom: 0;
			left: 0;
			right: 0;
			z-index: 1040;
			background: rgba(255, 255, 255, 0.96);
			backdrop-filter: blur(16px);
			-webkit-backdrop-filter: blur(16px);
			border-top: 1px solid rgba(226, 232, 240, 0.8);
			box-shadow: 0 -4px 20px rgba(15, 23, 42, 0.06);
			padding: 6px 12px calc(8px + env(safe-area-inset-bottom, 0px)) 12px;
		}
		.dock-item {
			display: flex;
			flex-direction: column;
			align-items: center;
			justify-content: center;
			flex: 1;
			color: #64748b;
			font-size: 0.65rem;
			font-weight: 600;
			text-decoration: none !important;
			padding: 4px 0;
			transition: color 0.15s ease;
		}
		.dock-item i {
			font-size: 1.15rem;
			margin-bottom: 2px;
		}
		.dock-item.active {
			color: #0284c7 !important;
			font-weight: 700 !important;
		}
		.dock-fab {
			position: relative;
			top: -18px;
			width: 52px;
			height: 52px;
			border-radius: 50%;
			background: linear-gradient(135deg, #0ea5e9, #0284c7);
			color: #ffffff !important;
			display: flex;
			align-items: center;
			justify-content: center;
			box-shadow: 0 6px 16px rgba(2, 132, 199, 0.38);
			font-size: 1.35rem;
			border: 4px solid #ffffff;
			text-decoration: none !important;
			transition: transform 0.2s cubic-bezier(0.34, 1.56, 0.64, 1);
		}
		.dock-fab:active {
			transform: scale(0.92);
		}
		@media print {
			header, nav, aside, footer, .no-print, .mobile-bottom-dock, #sidebar-backdrop, #main-sidebar {
				display: none !important;
			}
			body {
				background: #ffffff !important;
			}
			.lg\:pl-\[295px\] {
				padding-left: 0 !important;
			}
			main {
				padding: 0 !important;
				margin: 0 !important;
				width: 100% !important;
			}
		}
	</style>

	<script src="<?= asset('bootstrap/js/jquery.min.js') ?>"></script>
	<script src="<?= asset('bootstrap/js/jquery.validate.min.js') ?>"></script>
	<script src="<?= asset('bootstrap/js/localization/messages_id.js') ?>"></script>
	<script type="text/javascript">
		const BASE_URL = "<?= base_url() ?>";
		const SITE_URL = "<?= site_url() ?>";
	</script>

	<?php $this->load->view('head_tags') ?>
</head>

<body class="bg-[#f0f2f5] text-slate-800 min-h-screen flex flex-col font-sans selection:bg-sky-100 selection:text-sky-900">

	<div class="flex min-h-screen w-full">

		<!-- ========================================================================
		     LEFT SIDEBAR: EXACT REPLICA OF USER REFERENCE MOCKUP
		     ======================================================================== -->
		<div id="sidebar-backdrop" class="fixed inset-0 bg-slate-900/50 backdrop-blur-xs z-40 hidden lg:hidden transition-opacity" onclick="toggleSidebar(false)"></div>

		<aside id="main-sidebar" class="fixed inset-y-0 left-0 z-50 w-72 lg:w-[295px] bg-white border-r border-slate-200/80 flex flex-col justify-between transform -translate-x-full lg:translate-x-0 transition-transform duration-300 ease-in-out shadow-xs">
			
			<!-- Top Section: Brand & Navigation List -->
			<div class="flex-1 overflow-y-auto no-scrollbar p-5">
				
				<!-- Header Brand: Logo, Village Name, District/Regency -->
				<div class="flex items-center space-x-3.5 pb-4 border-b border-slate-100 mb-5">
					<img src="<?= gambar_desa($desa['logo']) ?>" class="w-12 h-12 object-contain rounded-2xl p-1 bg-white border border-slate-200 shadow-2xs" alt="<?= $desa['nama_desa'] ?>" />
					<div>
						<h2 class="text-lg font-extrabold font-display text-slate-900 leading-tight">
							<?= ucwords($this->setting->sebutan_desa . ' ' . $desa['nama_desa']) ?>
						</h2>
						<p class="text-xs sm:text-sm font-medium text-slate-400 mt-0.5">
							Kec. <?= $desa['nama_kecamatan'] ?> • Kab. <?= $desa['nama_kabupaten'] ?>
						</p>
					</div>
				</div>

				<!-- Navigation Items -->
				<nav class="space-y-4">
					
					<!-- Top Beranda Pill Button -->
					<div>
						<a href="<?= site_url('layanan-mandiri/beranda') ?>" class="<?= ($this->uri->segment(2) == 'beranda' || $this->uri->segment(2) == '') ? 'nav-beranda-pill' : 'nav-item-btn' ?>">
							<i class="fa-solid fa-house"></i>
							<span>Beranda</span>
						</a>
					</div>

					<!-- Group 1: LAYANAN UTAMA -->
					<div>
						<p class="text-xs font-bold uppercase tracking-wider text-slate-400 px-3.5 mb-2">
							LAYANAN UTAMA
						</p>
						<a href="<?= site_url('layanan-mandiri/permohonan-surat') ?>" class="nav-item-btn <?= in_array($this->uri->segment(2), ['permohonan-surat', 'arsip-surat', 'surat']) ? 'active' : '' ?>">
							<i class="fa-solid fa-file-lines"></i>
							<span>Surat</span>
							<?php if ($active_permohonan_count > 0): ?>
								<span class="ml-auto px-2 py-0.5 rounded-full text-[11px] font-bold bg-emerald-100 text-emerald-800">
									<?= $active_permohonan_count ?>
								</span>
							<?php endif; ?>
						</a>
						<a href="<?= site_url('layanan-mandiri/pesan-masuk') ?>" class="nav-item-btn <?= in_array($this->uri->segment(2), ['pesan-masuk', 'pesan-keluar', 'pesan']) ? 'active' : '' ?>">
							<i class="fa-solid fa-envelope"></i>
							<span>Pesan</span>
							<?php if ($unread_pesan_count > 0): ?>
								<span class="ml-auto px-2 py-0.5 rounded-full text-[11px] font-bold bg-orange-100 text-orange-800">
									<?= $unread_pesan_count ?>
								</span>
							<?php endif; ?>
						</a>
						<a href="<?= site_url('layanan-mandiri/lapak') ?>" class="nav-item-btn <?= ($this->uri->segment(2) == 'lapak') ? 'active' : '' ?>">
							<i class="fa-solid fa-store"></i>
							<span>Lapak</span>
						</a>
					</div>

					<!-- Group 2: LAYANAN LAIN -->
					<div>
						<p class="text-xs font-bold uppercase tracking-wider text-slate-400 px-3.5 mb-2">
							LAYANAN LAIN
						</p>
						<a href="<?= site_url('layanan-mandiri/profil') ?>" class="nav-item-btn <?= ($this->uri->segment(2) == 'profil') ? 'active' : '' ?>">
							<i class="fa-solid fa-user"></i>
							<span>Profil</span>
						</a>
						<a href="<?= site_url('layanan-mandiri/cetak-biodata') ?>" class="nav-item-btn <?= ($this->uri->segment(2) == 'cetak-biodata') ? 'active' : '' ?>">
							<i class="fa-solid fa-print"></i>
							<span>Cetak Biodata</span>
						</a>
						<?php if ($this->is_login->id_kk != 0) : ?>
							<a href="<?= site_url('layanan-mandiri/cetak-kk') ?>" class="nav-item-btn <?= ($this->uri->segment(2) == 'cetak-kk') ? 'active' : '' ?>">
								<i class="fa-solid fa-file-contract"></i>
								<span>Cetak Salinan KK</span>
							</a>
						<?php endif; ?>
						<a href="<?= site_url('layanan-mandiri/dokumen') ?>" class="nav-item-btn <?= ($this->uri->segment(2) == 'dokumen') ? 'active' : '' ?>">
							<i class="fa-solid fa-folder-open"></i>
							<span>Dokumen</span>
						</a>
						<a href="<?= site_url('layanan-mandiri/bantuan') ?>" class="nav-item-btn <?= ($this->uri->segment(2) == 'bantuan') ? 'active' : '' ?>">
							<i class="fa-solid fa-life-ring"></i>
							<span>Bantuan</span>
						</a>
					</div>

					<!-- Group 3: PENGATURAN -->
					<div>
						<p class="text-xs font-bold uppercase tracking-wider text-slate-400 px-3.5 mb-2">
							PENGATURAN
						</p>
						<a href="<?= site_url('layanan-mandiri/ganti-pin') ?>" class="nav-item-btn <?= ($this->uri->segment(2) == 'ganti-pin') ? 'active' : '' ?>">
							<i class="fa-solid fa-key"></i>
							<span>Ganti PIN</span>
						</a>
						<a href="<?= site_url('layanan-mandiri/verifikasi') ?>" class="nav-item-btn <?= ($this->uri->segment(2) == 'verifikasi') ? 'active' : '' ?>">
							<i class="fa-solid fa-shield-halved"></i>
							<span>Verifikasi</span>
						</a>
					</div>

					<!-- Bottom Red Pill: Keluar -->
					<div class="pt-2">
						<button type="button" class="w-full flex items-center px-4 py-3 rounded-xl bg-rose-50 hover:bg-rose-100 text-rose-600 font-bold text-sm sm:text-base transition-colors border border-rose-200/50" data-toggle="modal" data-target="#pendapat">
							<i class="fa-solid fa-arrow-right-from-bracket mr-3 text-rose-500"></i>
							<span>Keluar</span>
						</button>
					</div>

				</nav>
			</div>

			<!-- Bottom Card in Sidebar: Pelayanan Desa untuk Warga Balongbesuk -->
			<div class="p-4 border-t border-slate-100 bg-slate-50/50">
				<div class="relative bg-white rounded-2xl border border-slate-200/80 p-3.5 shadow-2xs flex items-center justify-between overflow-hidden group">
					<div class="flex items-center space-x-3 pr-2">
						<div class="w-1.5 h-10 bg-sky-500 rounded-full flex-shrink-0"></div>
						<h4 class="text-xs sm:text-sm font-bold text-slate-900 leading-snug">
							Pelayanan Desa untuk Warga <?= $desa['nama_desa'] ?>
						</h4>
					</div>
					<div class="w-16 h-12 rounded-xl overflow-hidden flex-shrink-0 border border-slate-200 shadow-2xs">
						<img src="<?= base_url('assets/front/images/balai_desa.jpg') ?>" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300" alt="Balai Desa">
					</div>
				</div>
			</div>

		</aside>

		<!-- ========================================================================
		     MAIN CONTENT SHELL: HEADER + HERO BANNER + METRIC CARDS + CONTENT VIEW
		     ======================================================================== -->
		<div class="flex-1 flex flex-col lg:pl-[295px] min-w-0 min-h-screen">
			
			<!-- TOP NAVBAR -->
			<header class="sticky top-0 z-30 bg-white/95 backdrop-blur-md border-b border-slate-200/80 px-5 sm:px-8 lg:px-10 py-3.5 sm:py-4 flex items-center justify-between gap-6 shadow-2xs">
				
				<!-- Left: Mobile Menu Toggle -->
				<div class="flex items-center space-x-4">
					<button type="button" class="p-2.5 rounded-xl text-slate-600 hover:text-slate-900 hover:bg-slate-100 transition-colors lg:hidden" onclick="toggleSidebar(true)" aria-label="Buka Menu">
						<i class="fa-solid fa-bars text-xl"></i>
					</button>
				</div>

				<!-- Right: Notification Bell, Envelope, User Capsule -->
				<div class="flex items-center space-x-3 sm:space-x-4">
					
					<!-- Notifications Bell Dropdown (Progres Permohonan Surat) -->
					<div class="relative">
						<button type="button" class="relative p-2.5 sm:p-3 rounded-2xl text-slate-600 hover:text-emerald-600 hover:bg-slate-100 transition-colors focus:outline-none" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" title="Pusat Notifikasi Progres Surat">
							<i class="fa-regular fa-bell text-xl"></i>
							<?php if ($active_permohonan_count > 0): ?>
								<span class="absolute top-1.5 right-1.5 min-w-[18px] h-[18px] px-1 rounded-full bg-rose-500 text-white text-[10px] font-bold flex items-center justify-center ring-2 ring-white shadow-xs animate-pulse">
									<?= $active_permohonan_count > 9 ? '9+' : $active_permohonan_count ?>
								</span>
							<?php endif; ?>
						</button>

						<!-- Notification Dropdown Menu -->
						<div class="dropdown-menu dropdown-menu-right !p-0 !rounded-2xl !shadow-2xl !border-slate-200 !fixed sm:!absolute !top-[68px] sm:!top-full !left-3 !right-3 sm:!left-auto sm:!right-0 sm:!w-[390px] !max-w-[420px] mx-auto sm:mx-0 overflow-hidden z-50">
							
							<!-- Header -->
							<div class="px-4 py-3 bg-slate-50/90 border-b border-slate-100 flex items-center justify-between">
								<div class="flex items-center space-x-2">
									<div class="w-7 h-7 rounded-lg bg-emerald-100 text-emerald-600 flex items-center justify-center text-xs">
										<i class="fa-solid fa-bell"></i>
									</div>
									<h4 class="text-sm font-bold text-slate-900 m-0">Progres Permohonan Surat</h4>
								</div>
								<span class="text-[11px] font-bold px-2.5 py-0.5 rounded-full <?= $active_permohonan_count > 0 ? 'bg-emerald-100 text-emerald-800' : 'bg-slate-100 text-slate-600' ?>">
									<?= $active_permohonan_count ?> Aktif
								</span>
							</div>

							<!-- Items List -->
							<div class="max-h-[350px] overflow-y-auto divide-y divide-slate-100">
								<?php if (!empty($notif_permohonan)): ?>
									<?php foreach ($notif_permohonan as $notif): ?>
										<?php
											$st_id = (int) $notif['status'];
											$st_badge = [
												0 => ['bg' => 'bg-amber-100 text-amber-800 border-amber-200', 'icon' => 'fa-circle-exclamation', 'label' => 'Perlu Dilengkapi', 'icon_box' => 'bg-amber-50 text-amber-600'],
												1 => ['bg' => 'bg-sky-100 text-sky-800 border-sky-200', 'icon' => 'fa-spinner fa-spin', 'label' => 'Sedang Diperiksa', 'icon_box' => 'bg-sky-50 text-sky-600'],
												2 => ['bg' => 'bg-purple-100 text-purple-800 border-purple-200', 'icon' => 'fa-pen-nib', 'label' => 'Menunggu TTD', 'icon_box' => 'bg-purple-50 text-purple-600'],
												3 => ['bg' => 'bg-emerald-100 text-emerald-800 border-emerald-200', 'icon' => 'fa-circle-check', 'label' => 'Siap Diambil', 'icon_box' => 'bg-emerald-50 text-emerald-600'],
												4 => ['bg' => 'bg-teal-100 text-teal-800 border-teal-200', 'icon' => 'fa-check-double', 'label' => 'Selesai', 'icon_box' => 'bg-teal-50 text-teal-600'],
												5 => ['bg' => 'bg-rose-100 text-rose-800 border-rose-200', 'icon' => 'fa-ban', 'label' => 'Dibatalkan', 'icon_box' => 'bg-rose-50 text-rose-600'],
											][$st_id] ?? ['bg' => 'bg-slate-100 text-slate-700 border-slate-200', 'icon' => 'fa-clock', 'label' => 'Menunggu', 'icon_box' => 'bg-slate-50 text-slate-600'];

											$target_url = ($st_id === 0) 
												? site_url("layanan-mandiri/surat/buat/{$notif['id']}")
												: site_url('layanan-mandiri/permohonan-surat');
										?>
										<a href="<?= $target_url ?>" class="flex items-start space-x-3 p-3.5 hover:bg-slate-50/80 transition-colors text-decoration-none group">
											<div class="w-9 h-9 rounded-xl <?= $st_badge['icon_box'] ?> flex items-center justify-center flex-shrink-0 text-sm shadow-2xs mt-0.5">
												<i class="fa-solid <?= $st_badge['icon'] ?>"></i>
											</div>
											<div class="flex-1 min-w-0">
												<div class="flex items-center justify-between gap-2 mb-1">
													<p class="text-xs sm:text-sm font-bold text-slate-900 truncate group-hover:text-emerald-600 transition-colors">
														<?= $notif['nama_surat'] ?: 'Surat Permohonan'; ?>
													</p>
													<span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold border flex-shrink-0 <?= $st_badge['bg'] ?>">
														<?= $st_badge['label']; ?>
													</span>
												</div>
												<div class="flex items-center space-x-2 text-[11px] text-slate-400">
													<?php if (!empty($notif['no_antrian'])): ?>
														<span>Antrean: <strong class="text-slate-600 font-mono"><?= get_antrian($notif['no_antrian']); ?></strong></span>
														<span>&bull;</span>
													<?php endif; ?>
													<span><?= tgl_indo2($notif['updated_at'] ?: $notif['created_at']); ?></span>
												</div>
											</div>
										</a>
									<?php endforeach; ?>
								<?php else: ?>
									<div class="py-8 px-4 text-center">
										<div class="w-12 h-12 rounded-2xl bg-slate-100 text-slate-400 flex items-center justify-center text-lg mx-auto mb-2">
											<i class="fa-regular fa-bell-slash"></i>
										</div>
										<p class="text-xs font-bold text-slate-700">Belum Ada Permohonan Surat</p>
										<p class="text-[11px] text-slate-400 mt-0.5">Surat yang Anda ajukan akan muncul status progresnya di sini.</p>
									</div>
								<?php endif; ?>
							</div>

							<!-- Footer -->
							<div class="p-2.5 bg-slate-50/90 border-t border-slate-100 text-center">
								<a href="<?= site_url('layanan-mandiri/permohonan-surat') ?>" class="text-xs font-bold text-emerald-600 hover:text-emerald-700 inline-flex items-center space-x-1.5 transition-colors text-decoration-none">
									<span>Lihat Semua Permohonan Surat</span>
									<i class="fa-solid fa-arrow-right text-[10px]"></i>
								</a>
							</div>

						</div>
					</div>

					<!-- Mailbox Icon (Kotak Pesan) -->
					<a href="<?= site_url('layanan-mandiri/pesan-masuk') ?>" class="relative p-2.5 sm:p-3 rounded-2xl text-slate-600 hover:text-orange-600 hover:bg-slate-100 transition-colors" title="Kotak Pesan Masuk">
						<i class="fa-regular fa-envelope text-xl"></i>
						<?php if ($unread_pesan_count > 0): ?>
							<span class="absolute top-1.5 right-1.5 min-w-[18px] h-[18px] px-1 rounded-full bg-orange-500 text-white text-[10px] font-bold flex items-center justify-center ring-2 ring-white shadow-xs">
								<?= $unread_pesan_count > 9 ? '9+' : $unread_pesan_count ?>
							</span>
						<?php endif; ?>
					</a>

					<!-- Citizen Profile Capsule Dropdown -->
					<div class="relative group">
						<button type="button" class="flex items-center space-x-3.5 p-1.5 sm:px-4 sm:py-2 rounded-2xl border border-slate-200 hover:border-slate-300 bg-white shadow-2xs transition-all" data-toggle="dropdown">
							<img class="w-10 h-10 sm:w-11 sm:h-11 rounded-full object-cover border border-slate-200" src="<?= AmbilFoto($this->is_login->foto, '', $this->is_login->sex) ?>" alt="Foto Penduduk">
							<div class="text-left hidden md:block">
								<p class="text-sm sm:text-base font-bold text-slate-900 leading-tight truncate max-w-[180px]">
									<?= strtoupper($this->is_login->nama); ?>
								</p>
								<p class="text-xs sm:text-sm text-slate-400 font-medium leading-none mt-1">
									Perangkat Desa
								</p>
							</div>
							<i class="fa-solid fa-chevron-down text-xs text-slate-400 ml-1"></i>
						</button>

						<div class="dropdown-menu dropdown-menu-right !p-2 !rounded-2xl !shadow-xl !border-slate-200 !min-w-[240px]">
							<div class="px-3.5 py-2.5 border-b border-slate-100 mb-2">
								<p class="text-base font-bold text-slate-900"><?= $this->is_login->nama; ?></p>
								<p class="text-xs text-slate-500 font-mono mt-0.5">NIK: <?= $this->is_login->nik; ?></p>
							</div>
							<a href="<?= site_url('layanan-mandiri/profil') ?>" class="flex items-center px-3.5 py-2.5 rounded-xl text-sm font-semibold text-slate-700 hover:bg-slate-50 hover:text-sky-600 text-decoration-none">
								<i class="fa-solid fa-user mr-2.5 text-slate-400"></i> Profil Lengkap
							</a>
							<a href="<?= site_url('layanan-mandiri/ganti-pin') ?>" class="flex items-center px-3.5 py-2.5 rounded-xl text-sm font-semibold text-slate-700 hover:bg-slate-50 hover:text-sky-600 text-decoration-none">
								<i class="fa-solid fa-key mr-2.5 text-slate-400"></i> Ganti PIN
							</a>
							<div class="my-1 border-t border-slate-100"></div>
							<button type="button" class="w-full flex items-center px-3.5 py-2.5 rounded-xl text-sm font-bold text-rose-700 hover:bg-rose-50 transition-colors" data-toggle="modal" data-target="#pendapat">
								<i class="fa-solid fa-arrow-right-from-bracket mr-2.5"></i> Keluar Akun
							</button>
						</div>
					</div>

				</div>
			</header>

			<!-- MAIN CONTAINER -->
			<main class="flex-1 px-5 sm:px-8 lg:px-10 py-6 pb-12 sm:pb-16">
				
				<?php if (!in_array($this->uri->segment(2), ['cetak-biodata', 'cetak-kk'])) : ?>
				<!-- ====================================================================
				     HERO WELCOME BANNER (BRIGHT, VIBRANT, LUXURIOUS)
				     ==================================================================== -->
				<div class="no-print relative rounded-2xl sm:rounded-3xl overflow-hidden mb-5 shadow-sm min-h-0 sm:min-h-[200px] flex items-center p-4 sm:p-8" style="background: linear-gradient(90deg, rgba(15, 23, 42, 0.62) 0%, rgba(15, 23, 42, 0.35) 45%, rgba(15, 23, 42, 0.1) 100%), url('<?= base_url('assets/front/images/desa_banner.jpg') ?>') center/cover no-repeat;">
					
					<div class="w-full flex flex-col md:flex-row items-start md:items-center justify-between gap-4 md:gap-6 z-10">
						
						<!-- Left Greetings -->
						<div class="max-w-xl text-white">
							<p class="text-xs sm:text-base font-medium text-white/90 drop-shadow-sm m-0">
								Selamat Datang,
							</p>
							<h1 class="text-xl sm:text-3xl lg:text-4xl font-extrabold font-display text-white tracking-tight mt-0.5 drop-shadow-md m-0">
								<?= strtoupper($this->is_login->nama); ?>
							</h1>
							<p class="hide-on-mobile text-sm sm:text-base text-white/95 mt-1 leading-relaxed drop-shadow-sm m-0">
								Mari bersama membangun Desa <?= $desa['nama_desa'] ?> yang lebih maju, transparan dan melayani.
							</p>
						</div>

						<!-- Right Weather & Date Frosted Card Widget (Desktop & Tablet only) -->
						<div class="hide-on-mobile backdrop-blur-md bg-white/20 border border-white/35 text-white rounded-2xl p-4 shadow-lg min-w-[220px]">
							<p class="text-xs sm:text-sm font-medium text-white/95 drop-shadow-xs m-0">
								<?= ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'][date('w')] . ', ' . tgl_indo2(date('Y-m-d')); ?>
							</p>
							<div class="flex items-center space-x-2 my-0.5">
								<span id="live-time-display" class="text-3xl sm:text-4xl font-extrabold font-display tracking-tight drop-shadow-xs">
									<?= date('H:i'); ?>
								</span>
								<span class="text-2xl">☀️</span>
							</div>
							<p class="text-xs text-white/90 font-medium leading-tight drop-shadow-xs m-0">
								<?= $desa['nama_desa'] ?>, <?= $desa['nama_kecamatan'] ?><br>Kab. <?= $desa['nama_kabupaten'] ?>
							</p>
						</div>

					</div>
				</div>

				<!-- ====================================================================
				     4 QUICK ACTION METRIC CARDS (RICH GRADIENT + PROPORTIONED PADDING)
				     ==================================================================== -->
				<div class="grid grid-cols-2 lg:grid-cols-4 gap-3.5 sm:gap-6 mb-6">
					
					<!-- Card 1: Surat (Green Gradient) -->
					<a href="<?= site_url('layanan-mandiri/permohonan-surat') ?>" class="group relative rounded-2xl p-4 sm:p-6 text-white overflow-hidden shadow-sm hover:shadow-md transition-all text-decoration-none min-h-0 sm:min-h-[160px] flex flex-col justify-between" style="background: linear-gradient(135deg, #22c55e 0%, #16a34a 100%);">
						<div class="relative z-10">
							<div class="w-10 h-10 sm:w-12 sm:h-12 rounded-xl sm:rounded-2xl bg-white/25 backdrop-blur-xs flex items-center justify-center text-white text-lg sm:text-xl mb-2 sm:mb-3.5 shadow-xs">
								<i class="fa-solid fa-file-lines"></i>
							</div>
							<h3 class="text-base sm:text-xl font-bold font-display text-white m-0">Surat</h3>
							<p class="hide-on-mobile text-xs sm:text-sm lg:text-[15px] text-white/95 mt-1 line-clamp-2 leading-relaxed">
								Buat, kelola dan ajukan permohonan surat
							</p>
						</div>
						<div class="mt-2.5 sm:mt-4 flex justify-end">
							<div class="w-7 h-7 sm:w-9 sm:h-9 rounded-full bg-white text-green-600 flex items-center justify-center text-xs sm:text-sm shadow-md group-hover:translate-x-1.5 transition-transform">
								<i class="fa-solid fa-arrow-right"></i>
							</div>
						</div>
						<i class="fa-solid fa-file-lines absolute -bottom-3 -right-3 sm:-bottom-5 sm:-right-5 text-[85px] sm:text-[115px] text-white/15 pointer-events-none transform -rotate-[20deg]" style="transform: rotate(-20deg);"></i>
					</a>

					<!-- Card 2: Pesan (Orange Gradient) -->
					<a href="<?= site_url('layanan-mandiri/pesan-masuk') ?>" class="group relative rounded-2xl p-4 sm:p-6 text-white overflow-hidden shadow-sm hover:shadow-md transition-all text-decoration-none min-h-0 sm:min-h-[160px] flex flex-col justify-between" style="background: linear-gradient(135deg, #f97316 0%, #ea580c 100%);">
						<div class="relative z-10">
							<div class="w-10 h-10 sm:w-12 sm:h-12 rounded-xl sm:rounded-2xl bg-white/25 backdrop-blur-xs flex items-center justify-center text-white text-lg sm:text-xl mb-2 sm:mb-3.5 shadow-xs">
								<i class="fa-solid fa-envelope"></i>
							</div>
							<h3 class="text-base sm:text-xl font-bold font-display text-white m-0">Pesan</h3>
							<p class="hide-on-mobile text-xs sm:text-sm lg:text-[15px] text-white/95 mt-1 line-clamp-2 leading-relaxed">
								Kirim dan terima pesan layanan desa
							</p>
						</div>
						<div class="mt-2.5 sm:mt-4 flex justify-end">
							<div class="w-7 h-7 sm:w-9 sm:h-9 rounded-full bg-white text-orange-600 flex items-center justify-center text-xs sm:text-sm shadow-md group-hover:translate-x-1.5 transition-transform">
								<i class="fa-solid fa-arrow-right"></i>
							</div>
						</div>
						<i class="fa-solid fa-envelope absolute -bottom-3 -right-3 sm:-bottom-5 sm:-right-5 text-[85px] sm:text-[115px] text-white/15 pointer-events-none transform -rotate-[20deg]" style="transform: rotate(-20deg);"></i>
					</a>

					<!-- Card 3: Lapak (Sky Blue Gradient) -->
					<a href="<?= site_url('layanan-mandiri/lapak') ?>" class="group relative rounded-2xl p-4 sm:p-6 text-white overflow-hidden shadow-sm hover:shadow-md transition-all text-decoration-none min-h-0 sm:min-h-[160px] flex flex-col justify-between" style="background: linear-gradient(135deg, #0ea5e9 0%, #0284c7 100%);">
						<div class="relative z-10">
							<div class="w-10 h-10 sm:w-12 sm:h-12 rounded-xl sm:rounded-2xl bg-white/25 backdrop-blur-xs flex items-center justify-center text-white text-lg sm:text-xl mb-2 sm:mb-3.5 shadow-xs">
								<i class="fa-solid fa-store"></i>
							</div>
							<h3 class="text-base sm:text-xl font-bold font-display text-white m-0">Lapak</h3>
							<p class="hide-on-mobile text-xs sm:text-sm lg:text-[15px] text-white/95 mt-1 line-clamp-2 leading-relaxed">
								Informasi produk & layanan desa
							</p>
						</div>
						<div class="mt-2.5 sm:mt-4 flex justify-end">
							<div class="w-7 h-7 sm:w-9 sm:h-9 rounded-full bg-white text-sky-600 flex items-center justify-center text-xs sm:text-sm shadow-md group-hover:translate-x-1.5 transition-transform">
								<i class="fa-solid fa-arrow-right"></i>
							</div>
						</div>
						<i class="fa-solid fa-store absolute -bottom-3 -right-3 sm:-bottom-5 sm:-right-5 text-[85px] sm:text-[115px] text-white/15 pointer-events-none transform -rotate-[20deg]" style="transform: rotate(-20deg);"></i>
					</a>

					<!-- Card 4: Dokumen (Red Gradient) -->
					<a href="<?= site_url('layanan-mandiri/dokumen') ?>" class="group relative rounded-2xl p-4 sm:p-6 text-white overflow-hidden shadow-sm hover:shadow-md transition-all text-decoration-none min-h-0 sm:min-h-[160px] flex flex-col justify-between" style="background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);">
						<div class="relative z-10">
							<div class="w-10 h-10 sm:w-12 sm:h-12 rounded-xl sm:rounded-2xl bg-white/25 backdrop-blur-xs flex items-center justify-center text-white text-lg sm:text-xl mb-2 sm:mb-3.5 shadow-xs">
								<i class="fa-solid fa-folder-open"></i>
							</div>
							<h3 class="text-base sm:text-xl font-bold font-display text-white m-0">Dokumen</h3>
							<p class="hide-on-mobile text-xs sm:text-sm lg:text-[15px] text-white/95 mt-1 line-clamp-2 leading-relaxed">
								Kelola dokumen kependudukan
							</p>
						</div>
						<div class="mt-2.5 sm:mt-4 flex justify-end">
							<div class="w-7 h-7 sm:w-9 sm:h-9 rounded-full bg-white text-rose-600 flex items-center justify-center text-xs sm:text-sm shadow-md group-hover:translate-x-1.5 transition-transform">
								<i class="fa-solid fa-arrow-right"></i>
							</div>
						</div>
						<i class="fa-solid fa-folder-open absolute -bottom-3 -right-3 sm:-bottom-5 sm:-right-5 text-[85px] sm:text-[115px] text-white/15 pointer-events-none transform -rotate-[20deg]" style="transform: rotate(-20deg);"></i>
					</a>

				</div>
				<?php endif; ?>

				<!-- ====================================================================
				     DYNAMIC VIEW CONTENT: LOADED FROM CONTROLLER
				     ==================================================================== -->
				<div class="w-full">
					<?php
					$this->load->view(MANDIRI . '/' . $konten);

					if ($this->is_login->ganti_pin === '1' && $this->uri->segment(2) != 'ganti-pin') :
						$data = [
							'pesan' => 'Selamat datang pengguna layanan mandiri <b> ' . ucwords($this->setting->sebutan_desa . ' ' . $desa['nama_desa']) . ' </b>, <br>Untuk keamanan akun anda, silahkan ganti <b>PIN</b> anda terlebih dahulu sebelum melanjutkan menggunakan layanan mandiri.',
							'aksi'  => site_url('layanan-mandiri/ganti-pin'),
						];
						$this->load->view(MANDIRI . '/notif', $data);
					endif;

					$data = $this->session->flashdata('notif');
					if ($data['status'] == 1) :
						$this->load->view(MANDIRI . '/notif', $data);
					endif;
					?>
				</div>

			</main>

			<!-- ========================================================================
			     FOOTER BAR (MINIMALIST & CLEAN - INTEGRATED WITH BACKGROUND)
			     ======================================================================== -->
			<footer class="mt-auto px-5 sm:px-8 lg:px-10 py-3.5 pb-24 lg:pb-3.5 border-t border-slate-200/70 text-xs sm:text-[13px] text-slate-400 flex flex-col sm:flex-row items-center justify-between gap-2">
				<div class="flex items-center space-x-2">
					<i class="fa-solid fa-cubes text-slate-400 text-xs"></i>
					<span>Aplikasi <strong>OpenSID</strong>, dikembangkan oleh <a href="https://opendesa.id" target="_blank" rel="noopener noreferrer" class="text-slate-500 hover:text-sky-600 font-semibold transition-colors">Komunitas OpenDesa</a>.</span>
				</div>
				<div class="text-slate-400 font-medium">
					Versi <span class="text-slate-500 font-semibold"><?= AmbilVersi() ?></span>
				</div>
			</footer>

		</div>

	</div>

	<!-- ========================================================================
	     MOBILE BOTTOM DOCK (ALWAYS ACCESSIBLE ON MOBILE)
	     ======================================================================== -->
	<nav class="lg:hidden mobile-bottom-dock flex items-center justify-around">
		<a href="<?= site_url('layanan-mandiri/beranda') ?>" class="dock-item <?= ($this->uri->segment(2) == 'beranda' || $this->uri->segment(2) == '') ? 'active' : '' ?>">
			<i class="fa-solid fa-house"></i>
			<span>Beranda</span>
		</a>

		<a href="<?= site_url('layanan-mandiri/permohonan-surat') ?>" class="dock-item <?= in_array($this->uri->segment(2), ['permohonan-surat', 'arsip-surat']) ? 'active' : '' ?>">
			<i class="fa-solid fa-clock-rotate-left"></i>
			<span>Status</span>
		</a>

		<!-- CENTER ELEVATED FAB (+) FOR BUAT SURAT -->
		<a href="<?= site_url('layanan-mandiri/surat/buat') ?>" class="dock-fab" title="Buat Permohonan Surat">
			<i class="fa-solid fa-plus"></i>
		</a>

		<a href="<?= site_url('layanan-mandiri/pesan-masuk') ?>" class="dock-item <?= in_array($this->uri->segment(2), ['pesan-masuk', 'pesan-keluar', 'pesan']) ? 'active' : '' ?>">
			<i class="fa-solid fa-comments"></i>
			<span>Pesan</span>
		</a>

		<a href="<?= site_url('layanan-mandiri/profil') ?>" class="dock-item <?= ($this->uri->segment(2) == 'profil') ? 'active' : '' ?>">
			<i class="fa-solid fa-user"></i>
			<span>Profil</span>
		</a>
	</nav>

	<!-- MODAL PENDAPAT (SURVEY / KELUAR) -->
	<?php $this->load->view(MANDIRI . '/pendapat') ?>

	<!-- Core JavaScript Plugins -->
	<script src="<?= asset('bootstrap/js/bootstrap.min.js') ?>"></script>
	<script src="<?= asset('bootstrap/js/select2.full.min.js') ?>"></script>
	<script src="<?= asset('bootstrap/js/moment.min.js') ?>"></script>
	<script src="<?= asset('bootstrap/js/bootstrap-datetimepicker.min.js') ?>"></script>
	<script src="<?= asset('bootstrap/js/bootstrap-datepicker.min.js') ?>"></script>
	<script src="<?= asset('bootstrap/js/bootstrap-datepicker.id.min.js') ?>"></script>
	<script src="<?= asset('js/custom-datetimepicker.js') ?>"></script>
	<script src="<?= asset('front/js/jquery-confirm.min.js') ?>"></script>
	<script src="<?= asset('bootstrap/js/jquery.dataTables.min.js') ?>"></script>
	<script src="<?= asset('bootstrap/js/dataTables.bootstrap.min.js') ?>"></script>
	<script src="<?= asset('bootstrap/js/jquery.validate.min.js') ?>"></script>
	<script src="<?= asset('bootstrap/js/localization/messages_id.js') ?>"></script>

	<?php if (cek_koneksi_internet()): ?>
		<script src="https://cdn.jsdelivr.net/npm/smartwizard@5/dist/js/jquery.smartWizard.min.js"></script>
	<?php endif ?>

	<?php if ($this->controller == 'lapak') : ?>
		<script src="<?= base_url('assets/js/leaflet.js') ?>"></script>
		<script src="<?= base_url('assets/js/mapbox-gl.js') ?>"></script>
		<script src="<?= base_url('assets/js/leaflet-mapbox-gl.js') ?>"></script>
		<script src="<?= base_url('assets/js/peta.js') ?>"></script>
	<?php endif; ?>

	<?php if ($cek_anjungan) : ?>
		<script src="<?= base_url('assets/js/jquery.keyboard.min.js') ?>"></script>
		<script src="<?= base_url('assets/front/js/mandiri-keyboard.js') ?>"></script>
	<?php endif; ?>

	<script src="<?= asset('front/js/mandiri.js') ?>"></script>

	<script>
		// Mobile Sidebar Drawer Toggle
		function toggleSidebar(open) {
			const sidebar = document.getElementById('main-sidebar');
			const backdrop = document.getElementById('sidebar-backdrop');
			if (open) {
				sidebar.classList.remove('-translate-x-full');
				backdrop.classList.remove('hidden');
			} else {
				sidebar.classList.add('-translate-x-full');
				backdrop.classList.add('hidden');
			}
		}

		// Live Clock updater
		function updateLiveClock() {
			const now = new Date();
			const hours = String(now.getHours()).padStart(2, '0');
			const minutes = String(now.getMinutes()).padStart(2, '0');
			const clockEl = document.getElementById('live-time-display');
			if (clockEl) {
				clockEl.innerText = hours + ':' + minutes;
			}
		}
		setInterval(updateLiveClock, 1000);
	</script>

</body>

</html>