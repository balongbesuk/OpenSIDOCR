<?php

defined('BASEPATH') || exit('No direct script access allowed');

/*
 * File ini:
 *
 * View modul Layanan Mandiri > Permohonan Surat
 * Redesigned with Next-Gen UI/UX & Website Theme Harmony
 *
 * donjo-app/views/fmandiri/buat_surat.php
 */

if (!function_exists('get_surat_visual')) {
    function get_surat_visual($nama) {
        $nama_lower = strtolower($nama);
        if (preg_match('/usaha|dagang|bisnis|toko|industri/', $nama_lower)) {
            return [
                'icon' => 'fa-solid fa-store', 
                'category_id' => 'usaha',
                'badge' => 'Usaha & Niaga',
                'bg_color' => 'bg-amber-50 text-amber-700 border-amber-200',
            ];
        }
        if (preg_match('/sktm|tidak mampu|miskin|bantuan/', $nama_lower)) {
            return [
                'icon' => 'fa-solid fa-hand-holding-heart', 
                'category_id' => 'sosial',
                'badge' => 'Sosial & Bantuan',
                'bg_color' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
            ];
        }
        if (preg_match('/skck|kelakuan baik|kepolisian/', $nama_lower)) {
            return [
                'icon' => 'fa-solid fa-shield-halved', 
                'category_id' => 'izin',
                'badge' => 'SKCK / Kepolisian',
                'bg_color' => 'bg-indigo-50 text-indigo-700 border-indigo-200',
            ];
        }
        if (preg_match('/domisili|tempat tinggal/', $nama_lower)) {
            return [
                'icon' => 'fa-solid fa-location-dot', 
                'category_id' => 'kependudukan',
                'badge' => 'Domisili',
                'bg_color' => 'bg-sky-50 text-sky-700 border-sky-200',
            ];
        }
        if (preg_match('/ktp|kk|kartu keluarga|penduduk|biodata/', $nama_lower)) {
            return [
                'icon' => 'fa-solid fa-id-card', 
                'category_id' => 'kependudukan',
                'badge' => 'Kependudukan',
                'bg_color' => 'bg-blue-50 text-blue-700 border-blue-200',
            ];
        }
        if (preg_match('/nikah|kawin|cerai|rujuk/', $nama_lower)) {
            return [
                'icon' => 'fa-solid fa-heart', 
                'category_id' => 'nikah',
                'badge' => 'Pernikahan',
                'bg_color' => 'bg-rose-50 text-rose-700 border-rose-200',
            ];
        }
        if (preg_match('/lahir|kelahiran/', $nama_lower)) {
            return [
                'icon' => 'fa-solid fa-baby', 
                'category_id' => 'kependudukan',
                'badge' => 'Kelahiran',
                'bg_color' => 'bg-cyan-50 text-cyan-700 border-cyan-200',
            ];
        }
        if (preg_match('/mati|kematian/', $nama_lower)) {
            return [
                'icon' => 'fa-solid fa-heart-pulse', 
                'category_id' => 'kependudukan',
                'badge' => 'Kematian',
                'bg_color' => 'bg-purple-50 text-purple-700 border-purple-200',
            ];
        }
        if (preg_match('/pindah|bepergian|jalan/', $nama_lower)) {
            return [
                'icon' => 'fa-solid fa-person-walking-luggage', 
                'category_id' => 'kependudukan',
                'badge' => 'Pindah Penduduk',
                'bg_color' => 'bg-teal-50 text-teal-700 border-teal-200',
            ];
        }
        if (preg_match('/penghasilan|gaji|pekerjaan/', $nama_lower)) {
            return [
                'icon' => 'fa-solid fa-wallet', 
                'category_id' => 'usaha',
                'badge' => 'Penghasilan',
                'bg_color' => 'bg-amber-50 text-amber-700 border-amber-200',
            ];
        }
        return [
            'icon' => 'fa-solid fa-file-signature', 
            'category_id' => 'umum',
            'badge' => 'Administrasi',
            'bg_color' => 'bg-slate-100 text-slate-700 border-slate-200',
        ];
    }
}
?>

<style>
	/* Interactive Modern Service Tile */
	.service-tile {
		display: flex;
		align-items: center;
		min-height: 80px;
		padding: 14px 18px;
		background: #ffffff;
		border: 1.5px solid #e2e8f0;
		border-radius: 18px;
		cursor: pointer;
		position: relative;
		touch-action: manipulation;
		transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
		user-select: none;
	}

	.service-tile:hover {
		border-color: #10b981;
		transform: translateY(-2px);
		box-shadow: 0 8px 20px -3px rgba(16, 185, 129, 0.14);
	}

	.service-tile.is-selected {
		border-color: #10b981 !important;
		background-color: #ecfdf5 !important;
		box-shadow: 0 0 0 3.5px rgba(16, 185, 129, 0.18) !important;
	}

	.service-tile.is-selected .tile-indicator {
		border-color: #10b981 !important;
		background-color: #10b981 !important;
		color: #ffffff !important;
	}

	.tile-indicator {
		width: 24px;
		height: 24px;
		border-radius: 50%;
		border: 2px solid #cbd5e1;
		display: flex;
		align-items: center;
		justify-content: center;
		font-size: 11px;
		color: transparent;
		flex-shrink: 0;
		transition: all 0.15s ease;
	}

	.category-chip {
		display: inline-flex;
		align-items: center;
		padding: 8px 18px;
		border-radius: 12px;
		font-size: 0.925rem;
		font-weight: 600;
		color: #475569;
		background: #ffffff;
		border: 1px solid #cbd5e1;
		cursor: pointer;
		touch-action: manipulation;
		transition: all 0.15s ease;
		white-space: nowrap;
	}

	.category-chip:hover {
		border-color: #94a3b8;
		background-color: #f8fafc;
		color: #0f172a;
	}

	.category-chip.active {
		border-color: #10b981;
		background-color: #10b981;
		color: #ffffff;
		box-shadow: 0 3px 10px rgba(16, 185, 129, 0.28);
	}

	.service-tile.is-disabled {
		opacity: 0.45;
		cursor: not-allowed !important;
		pointer-events: none;
	}

	/* Scrollbar styling */
	.no-scrollbar::-webkit-scrollbar {
		display: none !important;
	}
	.no-scrollbar {
		-ms-overflow-style: none !important;
		scrollbar-width: none !important;
	}
</style>

<!-- ========================================================================
     PAGE TITLE & BREADCRUMB CARD
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
				<a href="<?= site_url('layanan-mandiri/permohonan-surat') ?>" class="hover:text-emerald-600 transition-colors text-decoration-none text-slate-400">Surat</a>
				<span>&rsaquo;</span>
				<span class="text-slate-600 font-semibold">Buat Surat</span>
			</nav>
		</div>
	</div>

	<!-- Right: Soft Decorative Graphic with Leaves & Stacked Papers -->
	<div class="hidden sm:flex items-center pointer-events-none pr-4">
		<svg width="130" height="75" viewBox="0 0 130 75" fill="none" xmlns="http://www.w3.org/2000/svg">
			<rect x="25" y="14" width="46" height="56" rx="6" fill="#F8FAFC" stroke="#E2E8F0" stroke-width="2"/>
			<rect x="42" y="6" width="46" height="58" rx="6" fill="#FFFFFF" stroke="#10B981" stroke-width="2"/>
			<line x1="50" y1="18" x2="72" y2="18" stroke="#10B981" stroke-width="2.5" stroke-linecap="round"/>
			<line x1="50" y1="26" x2="80" y2="26" stroke="#CBD5E1" stroke-width="2" stroke-linecap="round"/>
			<line x1="50" y1="33" x2="74" y2="33" stroke="#CBD5E1" stroke-width="2" stroke-linecap="round"/>
			<line x1="50" y1="40" x2="68" y2="40" stroke="#CBD5E1" stroke-width="2" stroke-linecap="round"/>
			<path d="M96 52C99 42 108 34 118 32C116 46 109 56 96 61Z" fill="#10B981" fill-opacity="0.35"/>
			<path d="M106 58C108 48 116 42 125 40C123 52 117 62 106 66Z" fill="#059669" fill-opacity="0.45"/>
			<circle cx="100" cy="38" r="3" fill="#6EE7B7" fill-opacity="0.5"/>
		</svg>
	</div>

</div>

<!-- ========================================================================
     SUB-NAVIGATION PILLS
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

<!-- HERO GREETING BANNER -->
<div class="mb-6 p-6 sm:p-7 rounded-2xl bg-white text-slate-900 shadow-xs flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 border border-slate-200/80">
	<div>
		<div class="inline-flex items-center space-x-2 text-xs sm:text-sm font-semibold text-emerald-700 bg-emerald-50 px-3 py-1.5 rounded-lg border border-emerald-200 mb-2.5">
			<i class="fa-solid fa-file-circle-plus"></i>
			<span>Layanan Mandiri Digital</span>
		</div>
		<h1 class="text-xl sm:text-2xl lg:text-3xl font-extrabold font-display text-slate-900">
			Buat Permohonan Surat Online
		</h1>
		<p class="text-sm sm:text-base text-slate-500 mt-1">
			Pilih salah satu surat dari daftar di bawah ini untuk memulai pengajuan.
		</p>
	</div>

	<?php if ($permohonan) : ?>
		<div class="px-4 py-2.5 rounded-xl bg-amber-50 border border-amber-300 text-amber-800 text-xs sm:text-sm font-semibold flex items-center space-x-2">
			<i class="fa-solid fa-clock-rotate-left text-amber-600"></i>
			<span>Melengkapi permohonan tanggal <?= $permohonan['updated_at']; ?></span>
		</div>
	<?php endif; ?>
</div>

<!-- STEP PROGRESS BAR -->
<div class="mb-6 p-5 sm:p-6 rounded-2xl bg-white border border-slate-200/90 shadow-xs">
	<div class="flex items-center justify-between max-w-2xl mx-auto">
		<!-- Step 1 -->
		<div class="flex items-center space-x-3">
			<span class="w-9 h-9 sm:w-10 sm:h-10 rounded-xl flex items-center justify-center text-sm font-bold shadow-md shadow-emerald-500/30 flex-shrink-0" style="background-color: #10b981 !important; color: #ffffff !important;">
				1
			</span>
			<div>
				<span class="text-sm sm:text-base font-bold text-slate-900 block leading-tight font-display">Pilih Surat</span>
				<span class="text-xs text-emerald-600 font-semibold hidden sm:block mt-0.5">Sedang aktif</span>
			</div>
		</div>
		
		<div class="h-0.5 flex-1 mx-3 sm:mx-6 bg-slate-200"></div>

		<!-- Step 2 -->
		<div class="flex items-center space-x-3">
			<span class="w-9 h-9 sm:w-10 sm:h-10 rounded-xl bg-slate-100 text-slate-500 flex items-center justify-center text-sm font-bold flex-shrink-0" id="step2_circle">
				2
			</span>
			<div>
				<span class="text-sm sm:text-base font-bold text-slate-600 block leading-tight font-display" id="step2_label">Keperluan & WA</span>
				<span class="text-xs text-slate-400 font-normal hidden sm:block mt-0.5">Kontak aktif</span>
			</div>
		</div>

		<div class="h-0.5 flex-1 mx-3 sm:mx-6 bg-slate-200"></div>

		<!-- Step 3 -->
		<div class="flex items-center space-x-3">
			<span class="w-9 h-9 sm:w-10 sm:h-10 rounded-xl bg-slate-100 text-slate-500 flex items-center justify-center text-sm font-bold flex-shrink-0" id="step3_circle">
				3
			</span>
			<div>
				<span class="text-sm sm:text-base font-bold text-slate-600 block leading-tight font-display" id="step3_label">Syarat Dokumen</span>
				<span class="text-xs text-slate-400 font-normal hidden sm:block mt-0.5">Kelengkapan berkas</span>
			</div>
		</div>
	</div>
</div>

<form id="validasi" action="<?= $form_action ?>" method="POST" class="space-y-6">
	
	<!-- TOKEN CSRF OPENID -->
	<input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>" />

	<!-- INPUT TERSEMBUNYI UNTUK BACKEND OPENSID -->
	<input type="hidden" id="id_permohonan" name="id_permohonan" value="<?= $permohonan['id'] ?>" />

	<!-- Native Select Box disembunyikan agar AJAX mandiri.js tetap berjalan 100% -->
	<select name="id_surat" id="id_surat" class="hidden required" style="display: none !important;">
		<option value=""> -- Pilih Jenis Surat -- </option>
		<?php foreach ($menu_surat_mandiri as $data) : ?>
			<option value="<?= $data['id'] ?>" <?= selected($data['id'], $permohonan['id_surat']) ?>><?= $data['nama'] ?></option>
		<?php endforeach; ?>
	</select>

	<!-- SECTION 1: PILIH JENIS SURAT (GRID TILE MODERN) -->
	<div class="bg-white rounded-2xl border border-slate-200/90 shadow-sm overflow-hidden" id="section_pilih_surat">
		
		<!-- Controls: Search & Category Chips -->
		<div class="p-5 border-b border-slate-200/80 bg-slate-50/70 space-y-3.5">
			
			<div class="flex flex-col sm:flex-row items-stretch sm:items-center justify-between gap-3.5">
				<!-- Search Input -->
				<div class="relative flex-1">
					<div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400">
						<i class="fa-solid fa-magnifying-glass text-base"></i>
					</div>
					<input 
						type="text" 
						id="search_surat" 
						class="w-full pl-12 pr-10 py-3 rounded-xl border border-slate-300 bg-white text-base text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all shadow-xs" 
						placeholder="Ketik nama surat (contoh: SKCK, Domisili, Usaha, Kelahiran)..."
						autocomplete="off"
					>
					<button type="button" id="btn_clear_search" class="hidden absolute inset-y-0 right-0 pr-3.5 flex items-center text-slate-400 hover:text-slate-600">
						<i class="fa-solid fa-xmark text-base"></i>
					</button>
				</div>

				<div class="text-sm font-semibold text-slate-600 self-center whitespace-nowrap">
					Tersedia <span id="count_surat" class="font-extrabold text-slate-900"><?= count($menu_surat_mandiri) ?></span> jenis surat
				</div>
			</div>

			<!-- Category Filter Chips -->
			<div class="flex items-center space-x-2.5 overflow-x-auto pb-1 text-sm no-scrollbar">
				<button type="button" class="category-chip active" data-category="all">
					<i class="fa-solid fa-border-all mr-2 text-sm"></i> Semua Surat
				</button>
				<button type="button" class="category-chip" data-category="kependudukan">
					<i class="fa-solid fa-id-card mr-2 text-sm"></i> Kependudukan
				</button>
				<button type="button" class="category-chip" data-category="usaha">
					<i class="fa-solid fa-store mr-2 text-sm"></i> Usaha & Niaga
				</button>
				<button type="button" class="category-chip" data-category="izin">
					<i class="fa-solid fa-shield-halved mr-2 text-sm"></i> SKCK & Izin
				</button>
				<button type="button" class="category-chip" data-category="sosial">
					<i class="fa-solid fa-hand-holding-heart mr-2 text-sm"></i> Bantuan / SKTM
				</button>
				<button type="button" class="category-chip" data-category="nikah">
					<i class="fa-solid fa-heart mr-2 text-sm"></i> Pernikahan
				</button>
			</div>

		</div>

		<!-- GRID OF LETTER CARDS (HORIZONTAL SMART CARDS) -->
		<div class="p-5 sm:p-6 lg:p-7">
			
			<div id="grid_surat_container" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 xl:grid-cols-3 gap-4">
				<?php foreach ($menu_surat_mandiri as $data) : 
					$meta = get_surat_visual($data['nama']);
					$isSelected = ($data['id'] == $permohonan['id_surat']);
					$isDisabled = (!empty($permohonan['id']) && !$isSelected);
				?>
					<div 
						class="service-tile group <?= $isSelected ? 'is-selected' : '' ?> <?= $isDisabled ? 'is-disabled' : '' ?>" 
						data-id="<?= $data['id'] ?>"
						data-category="<?= $meta['category_id'] ?>"
						data-nama="<?= strtolower(htmlspecialchars($data['nama'])) ?>"
						data-nama-clean="<?= htmlspecialchars($data['nama']) ?>"
						role="radio"
						aria-checked="<?= $isSelected ? 'true' : 'false' ?>"
						tabindex="0"
					>
						<!-- Left: Vibrant Icon Badge -->
						<div class="w-12 h-12 rounded-2xl <?= $meta['bg_color'] ?> border flex items-center justify-center text-xl flex-shrink-0 mr-4 shadow-xs group-hover:scale-105 transition-transform">
							<i class="<?= $meta['icon'] ?>"></i>
						</div>

						<!-- Center: Title & Category -->
						<div class="flex-1 min-w-0 pr-2">
							<h3 class="text-sm sm:text-base font-bold text-slate-800 group-hover:text-blue-600 transition-colors leading-snug line-clamp-2 font-display">
								<?= $data['nama'] ?>
							</h3>
							<span class="text-xs font-bold uppercase tracking-wider text-slate-500 mt-1 inline-block">
								<?= $meta['badge'] ?>
							</span>
						</div>

						<!-- Right: Radio Check Bubble -->
						<div class="tile-indicator flex-shrink-0">
							<i class="fa-solid fa-check"></i>
						</div>

					</div>
				<?php endforeach; ?>
			</div>

			<!-- Empty State -->
			<div id="search_empty_state" class="hidden py-14 text-center">
				<div class="w-16 h-16 rounded-2xl bg-slate-100 text-slate-400 flex items-center justify-center text-3xl mx-auto mb-3">
					<i class="fa-solid fa-magnifying-glass"></i>
				</div>
				<h4 class="text-base font-bold text-slate-800">Jenis Surat Tidak Ditemukan</h4>
				<p class="text-sm text-slate-500 mt-1">
					Coba gunakan kata kunci pencarian yang lebih umum.
				</p>
			</div>

			<!-- Dynamic Floating Banner Surat Terpilih -->
			<div id="selected_surat_banner" class="<?= empty($permohonan['id_surat']) ? 'hidden' : '' ?> mt-6 p-4 sm:p-5 rounded-2xl bg-blue-50 border border-blue-200 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 shadow-xs">
				<div class="flex items-center space-x-3.5">
					<div class="w-10 h-10 rounded-2xl text-white flex items-center justify-center text-base font-bold shadow-sm flex-shrink-0" style="background-color: #2563eb !important; color: #ffffff !important;">
						<i class="fa-solid fa-check"></i>
					</div>
					<div>
						<span class="text-xs font-bold uppercase tracking-wider text-blue-700 block leading-none">Surat yang Dipilih:</span>
						<h4 id="selected_surat_title" class="text-base sm:text-lg font-bold text-slate-900 leading-tight mt-1 font-display">
							<?= $permohonan['nama_surat'] ?? 'Belum ada surat yang dipilih' ?>
						</h4>
					</div>
				</div>
				<button type="button" id="btn_scroll_to_form" class="w-full sm:w-auto px-6 py-3 rounded-xl text-white text-sm sm:text-base font-bold transition-all flex items-center justify-center space-x-2 shadow-sm" style="background-color: #2563eb !important; color: #ffffff !important;">
					<span>Lanjut Isi Formulir</span>
					<i class="fa-solid fa-arrow-down text-sm"></i>
				</button>
			</div>

		</div>

	</div>

	<!-- SECTION 2: DATA PEMOHON & KEPERLUAN -->
	<div id="section_form_keterangan" class="bg-white rounded-2xl border border-slate-200/90 shadow-sm overflow-hidden p-6 sm:p-7 space-y-6">
		
		<div class="border-b border-slate-200 pb-4">
			<div class="inline-flex items-center space-x-2 text-xs sm:text-sm font-bold uppercase tracking-wider text-blue-600 mb-1.5">
				<span class="w-6 h-6 rounded-lg bg-blue-100 text-blue-700 flex items-center justify-center text-xs font-bold">2</span>
				<span>Langkah 2 &bull; Keperluan & Kontak</span>
			</div>
			<h3 class="text-lg sm:text-xl font-bold text-slate-900 font-display">
				Keperluan Surat & Nomor WhatsApp Aktif
			</h3>
			<p class="text-sm sm:text-base text-slate-500 mt-1">
				Jelaskan tujuan permohonan surat dan pastikan nomor kontak dapat dihubungi oleh petugas desa.
			</p>
		</div>

		<div>
			<label for="keterangan" class="block text-sm font-bold uppercase tracking-wider text-slate-800 mb-2">
				Keterangan / Keperluan Surat <span class="text-rose-600">*</span>
			</label>
			<textarea 
				class="form-control w-full rounded-xl border border-slate-300 p-4 text-base focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all shadow-xs <?= jecho($cek_anjungan['keyboard'] == 1, true, 'kbvtext'); ?>" 
				name="keterangan" 
				id="keterangan" 
				rows="3" 
				required
				minlength="5"
				maxlength="500"
				placeholder="Contoh: Diperlukan untuk persyaratan melamar pekerjaan di PT ABC / Pendaftaran beasiswa..."
			><?= htmlspecialchars($permohonan['keterangan'] ?? ''); ?></textarea>
			<div class="flex flex-col sm:flex-row sm:items-center justify-between gap-1 text-xs sm:text-sm text-slate-500 mt-2">
				<p class="m-0">Tuliskan maksud penggunaan surat ini secara singkat, padat, dan jelas (minimal 5 karakter).</p>
				<span id="char_counter" class="font-semibold text-slate-400 self-end sm:self-auto">0 / 500 karakter</span>
			</div>
		</div>

		<div>
			<label for="no_hp_aktif" class="block text-sm font-bold uppercase tracking-wider text-slate-800 mb-2">
				Nomor WhatsApp / HP Aktif <span class="text-rose-600">*</span>
			</label>
			<div class="flex items-center max-w-md rounded-xl border border-slate-300 bg-white shadow-xs focus-within:ring-2 focus-within:ring-emerald-500 focus-within:border-emerald-500 transition-all overflow-hidden">
				<div class="flex items-center px-4 py-3 bg-slate-50 border-r border-slate-200 text-slate-700 font-bold text-sm select-none flex-shrink-0">
					+62
				</div>
				<input 
					class="form-control !border-0 !shadow-none !rounded-none px-3.5 py-3 text-base font-semibold text-slate-900 w-full focus:outline-none focus:ring-0 bg-transparent <?= jecho($cek_anjungan['keyboard'] == 1, true, 'kbvnumber'); ?>" 
					type="tel" 
					inputmode="numeric"
					name="no_hp_aktif" 
					id="no_hp_aktif" 
					placeholder="81234567890" 
					required
					minlength="9"
					maxlength="14"
					pattern="[0-9]{9,14}"
					autocomplete="tel-national"
					value="<?= preg_replace('/^(\+62|62|0)/', '', htmlspecialchars($permohonan['no_hp_aktif'] ?? $this->is_login->telepon ?? '')); ?>"
				/>
			</div>
			<p class="text-xs sm:text-sm text-slate-500 mt-2">
				Petugas desa akan menghubungi nomor ini jika terdapat konfirmasi berkas (hanya angka, 9-14 digit).
			</p>
		</div>

	</div>

	<!-- SECTION 3: SYARAT DOKUMEN -->
	<div class="box box-default ada_syarat !border-0 !shadow-none !mb-0" style="display: none">
		<div class="bg-white rounded-2xl border border-slate-200/90 shadow-sm overflow-hidden p-6 sm:p-7">
			
			<div class="border-b border-slate-200 pb-4 mb-5">
				<div class="inline-flex items-center space-x-2 text-xs sm:text-sm font-bold uppercase tracking-wider text-emerald-600 mb-1.5">
					<span class="w-6 h-6 rounded-lg bg-emerald-100 text-emerald-700 flex items-center justify-center text-xs font-bold">3</span>
					<span>Langkah 3 &bull; Kelengkapan Syarat Dokumen</span>
				</div>
				<h3 class="text-lg sm:text-xl font-bold text-slate-900 font-display">
					Dokumen Persyaratan Surat
				</h3>
				<p class="text-sm sm:text-base text-slate-500 mt-1">
					Pilih dokumen kependudukan yang sudah tersimpan di arsip digital desa Anda untuk setiap syarat yang diwajibkan.
				</p>
			</div>

			<div class="table-responsive">
				<table class="table table-bordered table-hover table-data w-full" id="syarat_surat" style="width: 100%;">
					<thead>
						<tr class="bg-slate-50 text-slate-800 text-xs sm:text-sm font-bold uppercase tracking-wider">
							<th class="py-3.5 px-4 text-center" style="width: 60px;">No</th>
							<th class="py-3.5 px-4">Nama Syarat Dokumen</th>
							<th class="py-3.5 px-4">Pilih Dokumen Pelengkap</th>
						</tr>
					</thead>
				</table>
			</div>

		</div>
	</div>

	<!-- ACTION BUTTONS -->
	<div class="bg-white rounded-2xl border border-slate-200/90 shadow-sm p-5 sm:p-6 flex flex-col sm:flex-row items-center justify-between gap-4">
		<a href="<?= site_url('layanan-mandiri/permohonan-surat') ?>" class="w-full sm:w-auto px-6 py-3.5 rounded-xl border border-slate-300 text-slate-700 hover:bg-slate-50 font-bold text-sm sm:text-base text-center text-decoration-none transition-colors">
			<i class="fa-solid fa-arrow-left mr-2"></i> Batal / Kembali
		</a>

		<button type="button" id="btn_cek_permohonan" class="w-full sm:w-auto px-8 py-3.5 rounded-xl text-white font-bold text-sm sm:text-base shadow-md shadow-emerald-500/25 transition-all flex items-center justify-center space-x-2.5 hover:opacity-95" style="background-color: #10b981 !important; color: #ffffff !important;">
			<i class="fa-solid fa-magnifying-glass-chart text-sm"></i>
			<span>Cek Permohonan & Lanjutkan</span>
			<i class="fa-solid fa-arrow-right text-sm ml-1"></i>
		</button>
	</div>

</form>

<!-- MODAL REVIEW & PENGECEKAN PERMOHONAN SEBELUM KIRIM -->
<div class="modal fade" id="modal_review_permohonan" tabindex="-1" role="dialog" aria-labelledby="modalReviewLabel" aria-hidden="true" data-backdrop="static">
	<div class="modal-dialog modal-dialog-centered modal-lg" style="max-width: 680px;">
		<div class="modal-content !rounded-3xl !border-0 !shadow-2xl overflow-hidden bg-white">
			
			<!-- Modal Header -->
			<div class="p-6 bg-gradient-to-r from-emerald-600 to-teal-700 text-white relative">
				<button type="button" class="close text-white opacity-80 hover:opacity-100 transition-opacity absolute top-5 right-5 text-2xl" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<div class="flex items-center space-x-3.5 pr-8">
					<div class="w-12 h-12 rounded-2xl bg-white/15 backdrop-blur-xs flex items-center justify-center text-2xl text-white flex-shrink-0 border border-white/20">
						<i class="fa-solid fa-clipboard-check"></i>
					</div>
					<div>
						<span class="text-xs font-bold uppercase tracking-wider text-emerald-100 block">Konfirmasi Pengajuan</span>
						<h3 class="text-xl sm:text-2xl font-extrabold text-white leading-tight font-display" id="modalReviewLabel">
							Cek Rincian Permohonan Surat
						</h3>
					</div>
				</div>
				<p class="text-xs sm:text-sm text-emerald-50/90 mt-2.5">
					Silakan teliti kembali ringkasan permohonan surat Anda sebelum diteruskan ke sistem layanan desa.
				</p>
			</div>

			<!-- Modal Body -->
			<div class="p-6 sm:p-7 space-y-5 max-h-[70vh] overflow-y-auto">
				
				<!-- Selected Letter Card in Modal -->
				<div class="p-4 rounded-2xl bg-slate-50 border border-slate-200/90 flex items-center space-x-3.5">
					<div id="modal_surat_icon" class="w-12 h-12 rounded-2xl bg-emerald-100 text-emerald-700 flex items-center justify-center text-xl flex-shrink-0 border border-emerald-200">
						<i class="fa-solid fa-file-signature"></i>
					</div>
					<div class="min-w-0 flex-1">
						<span id="modal_surat_badge" class="text-[11px] font-bold uppercase tracking-wider text-emerald-700 bg-emerald-50 px-2.5 py-0.5 rounded-md border border-emerald-200 inline-block mb-1">
							Administrasi Surat
						</span>
						<h4 id="modal_surat_nama" class="text-base sm:text-lg font-bold text-slate-900 leading-snug font-display">
							Nama Surat
						</h4>
					</div>
				</div>

				<!-- Applicant & Destination Details -->
				<div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5">
					
					<!-- Pemohon -->
					<div class="p-4 rounded-2xl bg-slate-50/70 border border-slate-200/80">
						<span class="text-xs font-bold uppercase tracking-wider text-slate-400 block mb-1">
							<i class="fa-solid fa-user mr-1.5 text-slate-400"></i> Nama Pemohon
						</span>
						<p class="text-sm font-bold text-slate-800 leading-tight">
							<?= htmlspecialchars($this->is_login->nama ?? ''); ?>
						</p>
						<p class="text-xs text-slate-500 mt-1">
							NIK: <span class="font-mono font-medium"><?= htmlspecialchars($this->is_login->nik ?? ''); ?></span>
						</p>
					</div>

					<!-- No WhatsApp Tujuan -->
					<div class="p-4 rounded-2xl bg-slate-50/70 border border-slate-200/80">
						<span class="text-xs font-bold uppercase tracking-wider text-slate-400 block mb-1">
							<i class="fa-brands fa-whatsapp mr-1.5 text-emerald-500"></i> No. WhatsApp Konfirmasi
						</span>
						<p id="modal_review_wa" class="text-sm font-bold text-emerald-700 font-mono leading-tight">
							-
						</p>
						<p class="text-xs text-slate-500 mt-1">
							Notifikasi status surat akan dikirim ke nomor ini.
						</p>
					</div>

				</div>

				<!-- Keperluan / Keterangan -->
				<div class="space-y-1.5">
					<label class="text-xs font-bold uppercase tracking-wider text-slate-600 block">
						<i class="fa-solid fa-pen-nib mr-1 text-slate-400"></i> Keperluan / Keterangan Surat:
					</label>
					<div id="modal_review_keterangan" class="p-4 rounded-2xl bg-slate-50 border border-slate-200/90 text-sm text-slate-800 leading-relaxed font-normal whitespace-pre-wrap">
						-
					</div>
				</div>

				<!-- Persyaratan Dokumen -->
				<div class="space-y-2">
					<label class="text-xs font-bold uppercase tracking-wider text-slate-600 block">
						<i class="fa-solid fa-folder-open mr-1 text-slate-400"></i> Berkas Persyaratan Terlampir:
					</label>
					<div id="modal_review_syarat" class="space-y-2">
						<!-- Dynamic items populated by JS -->
					</div>
				</div>

				<!-- Safety & Truthfulness Statement -->
				<div class="p-4 rounded-2xl bg-amber-50/70 border border-amber-200/80 flex items-start space-x-3">
					<i class="fa-solid fa-circle-info text-amber-600 text-base mt-0.5 flex-shrink-0"></i>
					<p class="text-xs text-amber-800 leading-relaxed m-0">
						Pastikan seluruh informasi keperluan dan berkas yang dipilih sudah benar. Setelah dikirim, petugas kantor desa akan memeriksa dan memvalidasi permohonan surat Anda.
					</p>
				</div>

			</div>

			<!-- Modal Footer -->
			<div class="p-5 sm:p-6 bg-slate-50/80 border-t border-slate-200/80 flex flex-col sm:flex-row items-center justify-between gap-3">
				<button type="button" class="w-full sm:w-auto px-6 py-3 rounded-xl border border-slate-300 text-slate-700 hover:bg-slate-100 font-bold text-sm transition-colors" data-dismiss="modal">
					<i class="fa-solid fa-arrow-left mr-2"></i> Periksa Kembali
				</button>
				
				<button type="button" id="btn_konfirmasi_kirim" class="w-full sm:w-auto px-7 py-3 rounded-xl text-white font-bold text-sm shadow-md shadow-emerald-500/25 transition-all flex items-center justify-center space-x-2" style="background-color: #10b981 !important; color: #ffffff !important;">
					<i class="fa-solid fa-paper-plane text-sm"></i>
					<span>Ya, Lanjutkan Permohonan</span>
				</button>
			</div>

		</div>
	</div>
</div>

<!-- MODAL PERINGATAN VALIDASI -->
<div class="modal fade in" id="dialog" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content !rounded-3xl !border-0 !shadow-2xl overflow-hidden bg-white">
			<div class="modal-header bg-rose-600 text-white p-5 flex items-center justify-between">
				<h4 class="modal-title font-bold text-base flex items-center space-x-2.5 text-white" id="myModalLabel">
					<div class="w-8 h-8 rounded-xl bg-white/20 flex items-center justify-center text-white">
						<i class="fa-solid fa-triangle-exclamation"></i>
					</div>
					<span>Perhatian Pengisian Form</span>
				</h4>
				<button type="button" class="close text-white opacity-80 hover:opacity-100 text-2xl" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body p-6 text-slate-800 text-sm leading-relaxed">
				<p id="kata_peringatan" class="leading-relaxed text-slate-700 m-0"></p>
			</div>
			<div class="modal-footer bg-slate-50 p-4 border-t border-slate-200">
				<button class="px-6 py-2.5 rounded-xl bg-slate-900 text-white text-xs font-bold hover:bg-slate-800 transition-colors" data-dismiss="modal">
					Lengkapi Isian Form
				</button>
			</div>
		</div>
	</div>
</div>

<script type='text/javascript'>
	function cek_perhatian(elem) {
		if ($(elem).val() == '-1') {
			$(elem).next('.perhatian').show();
		} else {
			$(elem).next('.perhatian').hide();
		}
	}

	$(function() {
		// Prevent accidental enter submit
		$(document).on("keydown", ":input:not(textarea):not(:submit)", function(event) {
			if (event.key === "Enter") {
				event.preventDefault();
				return false;
			}
		});

		// Strict numeric-only restriction on WhatsApp input
		$('#no_hp_aktif').on('keypress', function(e) {
			var charCode = (e.which) ? e.which : e.keyCode;
			// Cegah tombol non-angka (hanya izinkan digit 0-9)
			if (charCode > 31 && (charCode < 48 || charCode > 57)) {
				e.preventDefault();
				return false;
			}
			return true;
		});

		$('#no_hp_aktif').on('input', function() {
			var val = this.value.replace(/[^0-9]/g, '');
			// Jika pengguna mengetik atau menempelkan awalan 62 atau 0, bersihkan agar selaras dengan badge +62
			if (val.startsWith('62')) {
				val = val.substring(2);
			} else if (val.startsWith('0')) {
				val = val.substring(1);
			}
			this.value = val;
		});

		$('#no_hp_aktif').on('paste', function() {
			setTimeout(function() {
				var val = $('#no_hp_aktif').val().replace(/[^0-9]/g, '');
				if (val.startsWith('62')) {
					val = val.substring(2);
				} else if (val.startsWith('0')) {
					val = val.substring(1);
				}
				$('#no_hp_aktif').val(val);
			}, 10);
		});

		// Live Character Counter for Keterangan
		function updateCharCounter() {
			var length = $('#keterangan').val().length;
			$('#char_counter').text(length + ' / 500 karakter');
			if (length < 5) {
				$('#char_counter').removeClass('text-emerald-600 text-slate-400').addClass('text-rose-500');
			} else {
				$('#char_counter').removeClass('text-rose-500').addClass('text-emerald-600');
			}
		}
		$('#keterangan').on('input', updateCharCounter);
		updateCharCounter();

		var currentCategory = 'all';

		function filterSurat() {
			var query = $('#search_surat').val().toLowerCase().trim();
			var visibleCount = 0;

			$('.service-tile').each(function() {
				var namaSurat = $(this).data('nama');
				var catSurat = $(this).data('category');

				var matchSearch = (namaSurat.indexOf(query) !== -1);
				var matchCategory = (currentCategory === 'all' || catSurat === currentCategory);

				if (matchSearch && matchCategory) {
					$(this).show();
					visibleCount++;
				} else {
					$(this).hide();
				}
			});

			$('#count_surat').text(visibleCount);

			if (query.length > 0) {
				$('#btn_clear_search').removeClass('hidden');
			} else {
				$('#btn_clear_search').addClass('hidden');
			}

			if (visibleCount === 0) {
				$('#search_empty_state').removeClass('hidden');
			} else {
				$('#search_empty_state').addClass('hidden');
			}
		}

		// Search handler
		$('#search_surat').on('input', filterSurat);

		// Clear search
		$('#btn_clear_search').on('click', function() {
			$('#search_surat').val('').trigger('input').focus();
		});

		// Category chips
		$('.category-chip').on('click', function() {
			$('.category-chip').removeClass('active');
			$(this).addClass('active');
			currentCategory = $(this).data('category');
			filterSurat();
		});

		// Service tile selection
		$('.service-tile').on('click', function() {
			if ($(this).hasClass('is-disabled')) {
				return;
			}

			var suratId = $(this).data('id');
			var suratNama = $(this).data('nama-clean');

			$('.service-tile').removeClass('is-selected').attr('aria-checked', 'false');
			$(this).addClass('is-selected').attr('aria-checked', 'true');

			// Trigger native select change for OpenSID AJAX mandiri.js
			$('#id_surat').val(suratId).trigger('change');

			$('#selected_surat_title').text(suratNama);
			$('#selected_surat_banner').removeClass('hidden');

			// Update step indicators
			$('#step2_circle').css({'background-color': '#10b981', 'color': '#ffffff'}).addClass('shadow-md shadow-emerald-500/30');
			$('#step2_label').removeClass('text-slate-600').addClass('text-slate-900 font-bold');
		});

		// Smooth scroll to form
		$('#btn_scroll_to_form').on('click', function() {
			$('html, body').animate({
				scrollTop: $("#section_form_keterangan").offset().top - 80
			}, 350);
		});

		// Pre-select active surat if editing / existing
		var initialSuratId = $('#id_surat').val();
		if (initialSuratId) {
			var activeTile = $('.service-tile[data-id="' + initialSuratId + '"]');
			if (activeTile.length) {
				activeTile.addClass('is-selected').attr('aria-checked', 'true');
				$('#selected_surat_title').text(activeTile.data('nama-clean'));
				$('#selected_surat_banner').removeClass('hidden');
				$('#step2_circle').css({'background-color': '#10b981', 'color': '#ffffff'}).addClass('shadow-md shadow-emerald-500/30');
				$('#step2_label').removeClass('text-slate-600').addClass('text-slate-900 font-bold');
			}
		}

		// Helper function for alerts
		function tampilkanPeringatan(pesan, targetElem) {
			$('#kata_peringatan').html(pesan);
			$('#dialog').modal('show');
			if (targetElem && $(targetElem).length) {
				$('#dialog').off('hidden.bs.modal').on('hidden.bs.modal', function() {
					$('html, body').animate({
						scrollTop: $(targetElem).offset().top - 100
					}, 300);
					$(targetElem).focus();
				});
			}
		}

		// Tombol "Cek Permohonan & Lanjutkan" - Validasi Pra-Submit & Review
		$('#btn_cek_permohonan').on('click', function(e) {
			e.preventDefault();

			// 1. Validasi Jenis Surat
			var idSurat = $('#id_surat').val();
			if (!idSurat) {
				tampilkanPeringatan('<strong>Jenis Surat belum dipilih!</strong><br>Silakan pilih jenis surat yang ingin Anda ajukan pada Langkah 1 terlebih dahulu.', '#section_pilih_surat');
				return false;
			}

			// 2. Validasi Keterangan / Keperluan Surat
			var keterangan = $('#keterangan').val().trim();
			if (!keterangan || keterangan.length < 5) {
				tampilkanPeringatan('<strong>Keterangan / Keperluan belum lengkap!</strong><br>Mohon jelaskan keperluan permohonan surat minimal 5 karakter agar petugas desa dapat memahami peruntukannya.', '#keterangan');
				return false;
			}

			// 3. Validasi Nomor WhatsApp / HP Aktif
			var noHp = $('#no_hp_aktif').val().replace(/[^0-9]/g, '');
			if (!noHp || noHp.length < 9 || noHp.length > 14) {
				tampilkanPeringatan('<strong>Nomor WhatsApp / HP tidak valid!</strong><br>Masukkan nomor kontak aktif antara 9 sampai 14 digit angka (contoh: 81234567890).', '#no_hp_aktif');
				return false;
			}

			// 4. Validasi Dokumen Persyaratan (jika surat memiliki syarat)
			var syaratListItems = [];
			var syaratBelumLengkap = false;
			var elemSyaratBelum = null;
			var namaSyaratBelum = '';

			if ($('.ada_syarat').is(':visible')) {
				var syaratSelects = $("select[name='syarat[]']");
				
				if (syaratSelects.length > 0) {
					syaratSelects.each(function() {
						var val = $(this).val();
						var row = $(this).closest('tr');
						var namaSyarat = row.find('td:nth-child(2)').text().trim() || 'Syarat Dokumen';
						var namaBerkas = $(this).find('option:selected').text().trim();

						if (!val || val === '-1') {
							syaratBelumLengkap = true;
							elemSyaratBelum = this;
							namaSyaratBelum = namaSyarat;
							return false; // break loop
						} else {
							syaratListItems.push({
								syarat: namaSyarat,
								berkas: namaBerkas
							});
						}
					});

					if (syaratBelumLengkap) {
						tampilkanPeringatan('<strong>Persyaratan belum lengkap!</strong><br>Dokumen untuk <strong>"' + namaSyaratBelum + '"</strong> belum dipilih. Silakan pilih berkas dari arsip digital Anda.', elemSyaratBelum);
						return false;
					}
				}
			}

			// JIKA SEMUA VALID: TAMPILKAN MODAL REVIEW
			var activeTile = $('.service-tile.is-selected');
			var namaSurat = activeTile.data('nama-clean') || $('#selected_surat_title').text();
			var iconHtml = activeTile.find('.w-12').html() || '<i class="fa-solid fa-file-signature"></i>';
			var badgeText = activeTile.find('.uppercase').text().trim() || 'Surat Desa';

			$('#modal_surat_nama').text(namaSurat);
			$('#modal_surat_icon').html(iconHtml);
			$('#modal_surat_badge').text(badgeText);
			$('#modal_review_wa').text('+62 ' + noHp);
			$('#modal_review_keterangan').text(keterangan);

			// Render daftar berkas syarat di modal review
			var syaratHtml = '';
			if (syaratListItems.length > 0) {
				syaratListItems.forEach(function(item, idx) {
					syaratHtml += '<div class="p-3 rounded-xl bg-slate-50 border border-slate-200 flex items-center justify-between text-xs sm:text-sm">' +
						'<div class="flex items-center space-x-2.5 font-medium text-slate-800">' +
							'<i class="fa-solid fa-file-pdf text-emerald-600 text-base"></i>' +
							'<span><strong>' + item.syarat + ':</strong> ' + item.berkas + '</span>' +
						'</div>' +
						'<span class="px-2 py-0.5 rounded-md bg-emerald-100 text-emerald-800 text-[11px] font-bold"><i class="fa-solid fa-check mr-1"></i> Terlampir</span>' +
					'</div>';
				});
			} else {
				syaratHtml = '<div class="p-3.5 rounded-xl bg-slate-50 border border-slate-200/80 text-xs sm:text-sm text-slate-500 flex items-center space-x-2.5">' +
					'<i class="fa-solid fa-circle-check text-emerald-500 text-base"></i>' +
					'<span>Surat ini <strong>tidak memerlukan dokumen persyaratan tambahan</strong>.</span>' +
				'</div>';
			}
			$('#modal_review_syarat').html(syaratHtml);

			// Tampilkan Modal Review
			$('#modal_review_permohonan').modal('show');
		});

		// Tombol Konfirmasi Final di Modal Review
		$('#btn_konfirmasi_kirim').on('click', function() {
			var $btn = $(this);
			$btn.prop('disabled', true).html('<i class="fa-solid fa-spinner fa-spin mr-2"></i> Memproses Permohonan...');
			
			var form = document.getElementById('validasi');
			if (typeof addCsrfField === 'function') {
				addCsrfField(form);
			} else if (typeof getCsrfToken === 'function' && typeof csrfParam !== 'undefined') {
				var csrfInput = form.querySelector('input[name="' + csrfParam + '"]');
				if (!csrfInput) {
					csrfInput = document.createElement('input');
					csrfInput.type = 'hidden';
					csrfInput.name = csrfParam;
					form.appendChild(csrfInput);
				}
				csrfInput.value = getCsrfToken();
			}
			
			// Submit native form ke server
			form.submit();
		});
	});
</script>