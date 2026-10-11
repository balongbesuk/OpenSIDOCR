<?php

defined('BASEPATH') || exit('No direct script access allowed');

/*
 * File ini:
 *
 * View modul Layanan Mandiri > Beranda (Dashboard Terpadu Warga)
 * Redesigned with Next-Gen UI/UX Pro Max (Tema Desa Balongbesuk)
 *
 * donjo-app/views/fmandiri/beranda.php
 */
?>

<!-- ========================================================================
     DASHBOARD GRID CONTAINER
     ======================================================================== -->
<div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">

	<!-- ====================================================================
	     LEFT COLUMN (SURAT TERKINI & PESAN DESA)
	     ==================================================================== -->
	<div class="lg:col-span-7 xl:col-span-8 space-y-6">

		<!-- ----------------------------------------------------------------
		     WIDGET 1: PERMOHONAN SURAT TERKINI
		     ---------------------------------------------------------------- -->
		<div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden">
			
			<!-- Header -->
			<div class="p-5 sm:p-6 border-b border-slate-100 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
				<div class="flex items-center space-x-3.5">
					<div class="w-11 h-11 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-lg flex-shrink-0 shadow-2xs">
						<i class="fa-solid fa-file-signature"></i>
					</div>
					<div>
						<h2 class="text-lg sm:text-xl font-bold font-display text-slate-900 m-0">
							Permohonan Surat Terkini
						</h2>
						<p class="text-xs sm:text-sm text-slate-400 font-medium m-0 mt-0.5">
							Pantau status progres dan pengajuan surat administrasi Anda
						</p>
					</div>
				</div>

				<div class="flex items-center space-x-2.5 w-full sm:w-auto justify-between sm:justify-end">
					<a href="<?= site_url('layanan-mandiri/surat/buat') ?>" class="px-4 py-2 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs sm:text-sm shadow-xs transition-colors flex items-center space-x-2 text-decoration-none">
						<i class="fa-solid fa-plus text-xs"></i>
						<span>Buat Surat</span>
					</a>
				</div>
			</div>

			<!-- Body: Items List -->
			<div class="p-4 sm:p-6">
				<?php if (!empty($permohonan_terkini)): ?>
					<div class="space-y-3.5">
						<?php foreach ($permohonan_terkini as $item): ?>
							<?php
								$st_id = isset($item['status_id']) ? (int) $item['status_id'] : (int) $item['status'];
								$nama_surat = !empty($item['jenis_surat']) ? $item['jenis_surat'] : (!empty($item['nama_surat']) ? $item['nama_surat'] : 'Surat Permohonan');
								$no_antrian_str = !empty($item['no_antrian']) ? get_antrian($item['no_antrian']) : ('#' . $item['id']);

								$st_badge = [
									0 => ['bg' => 'bg-amber-100 text-amber-800 border-amber-200', 'icon' => 'fa-circle-exclamation', 'label' => 'Perlu Dilengkapi', 'icon_box' => 'bg-amber-50 text-amber-600'],
									1 => ['bg' => 'bg-sky-100 text-sky-800 border-sky-200', 'icon' => 'fa-spinner fa-spin', 'label' => 'Sedang Diperiksa', 'icon_box' => 'bg-sky-50 text-sky-600'],
									2 => ['bg' => 'bg-purple-100 text-purple-800 border-purple-200', 'icon' => 'fa-pen-nib', 'label' => 'Menunggu TTD', 'icon_box' => 'bg-purple-50 text-purple-600'],
									3 => ['bg' => 'bg-emerald-100 text-emerald-800 border-emerald-200', 'icon' => 'fa-circle-check', 'label' => 'Siap Diambil', 'icon_box' => 'bg-emerald-50 text-emerald-600'],
									4 => ['bg' => 'bg-teal-100 text-teal-800 border-teal-200', 'icon' => 'fa-check-double', 'label' => 'Selesai', 'icon_box' => 'bg-teal-50 text-teal-600'],
									5 => ['bg' => 'bg-rose-100 text-rose-800 border-rose-200', 'icon' => 'fa-ban', 'label' => 'Dibatalkan', 'icon_box' => 'bg-rose-50 text-rose-600'],
								][$st_id] ?? ['bg' => 'bg-slate-100 text-slate-700 border-slate-200', 'icon' => 'fa-clock', 'label' => (!empty($item['status']) && is_string($item['status']) ? $item['status'] : 'Menunggu'), 'icon_box' => 'bg-slate-50 text-slate-600'];

								$action_url = ($st_id === 0) 
									? site_url("layanan-mandiri/surat/buat/{$item['id']}")
									: site_url('layanan-mandiri/permohonan-surat');
							?>
							<div class="p-4 sm:p-5 rounded-2xl border border-slate-200/80 hover:border-slate-300 hover:bg-slate-50/50 transition-all flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
								
								<!-- Left: Icon + Information -->
								<div class="flex items-start space-x-3.5 flex-1 min-w-0 w-full">
									<div class="w-10 h-10 sm:w-11 sm:h-11 rounded-xl <?= $st_badge['icon_box'] ?> flex items-center justify-center flex-shrink-0 text-base shadow-2xs mt-0.5">
										<i class="fa-solid <?= $st_badge['icon'] ?>"></i>
									</div>
									<div class="flex-1 min-w-0">
										<!-- Title & Status Badge with Icon -->
										<div class="flex items-center flex-wrap gap-2 mb-1.5">
											<h3 class="text-sm sm:text-base font-bold text-slate-900 leading-snug m-0">
												<?= $nama_surat; ?>
											</h3>
											<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold border flex-shrink-0 <?= $st_badge['bg'] ?>">
												<i class="fa-solid <?= $st_badge['icon'] ?> mr-1 text-[10px]"></i>
												<?= $st_badge['label']; ?>
											</span>
										</div>

										<!-- Meta: Antrean & Tanggal -->
										<div class="flex items-center space-x-2 text-xs text-slate-400 mt-1 flex-wrap gap-y-1">
											<span class="inline-flex items-center space-x-1 font-mono font-bold text-slate-600 bg-slate-100 px-2 py-0.5 rounded-md text-[11px] sm:text-xs flex-shrink-0">
												<i class="fa-solid fa-ticket text-[10px] text-slate-400"></i>
												<span>Antrean: <?= $no_antrian_str; ?></span>
											</span>
											<span class="text-slate-300">&bull;</span>
											<span class="text-[11px] sm:text-xs">
												Diajukan: <strong class="text-slate-600"><?= tgl_indo2($item['created_at']); ?></strong>
											</span>
											<?php if (!empty($item['updated_at']) && $item['updated_at'] !== $item['created_at']): ?>
												<span class="text-slate-300">&bull;</span>
												<span class="text-[11px] sm:text-xs">Diperbarui: <?= tgl_indo2($item['updated_at']); ?></span>
											<?php endif; ?>
										</div>
									</div>
								</div>

								<!-- Right: Action Button -->
								<div class="w-full sm:w-auto flex-shrink-0">
									<a href="<?= $action_url ?>" class="w-full sm:w-auto px-4 py-2 sm:py-2 rounded-xl text-xs sm:text-sm font-bold border border-slate-200 bg-white hover:bg-slate-50 text-slate-700 transition-colors flex items-center justify-center space-x-1.5 text-decoration-none shadow-2xs">
										<span><?= $st_id === 0 ? 'Lengkapi Persyaratan' : 'Lihat Detail' ?></span>
										<i class="fa-solid fa-chevron-right text-[10px]"></i>
									</a>
								</div>

							</div>
						<?php endforeach; ?>
					</div>
				<?php else: ?>
					<!-- Empty State -->
					<div class="py-10 px-4 text-center">
						<div class="w-16 h-16 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-2xl mx-auto mb-3 shadow-2xs">
							<i class="fa-regular fa-folder-open"></i>
						</div>
						<h3 class="text-base font-bold text-slate-800 m-0">Belum Ada Permohonan Surat Aktif</h3>
						<p class="text-xs sm:text-sm text-slate-400 max-w-sm mx-auto mt-1 leading-relaxed">
							Anda belum mengajukan permohonan surat administrasi. Ajukan surat pengantar atau keterangan dengan mudah secara mandiri.
						</p>
						<a href="<?= site_url('layanan-mandiri/surat/buat') ?>" class="mt-4 inline-flex items-center space-x-2 px-4 py-2 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs sm:text-sm transition-colors text-decoration-none shadow-xs">
							<i class="fa-solid fa-plus text-xs"></i>
							<span>Mulai Ajukan Surat</span>
						</a>
					</div>
				<?php endif; ?>
			</div>

			<!-- Footer -->
			<div class="p-4 bg-slate-50/80 border-t border-slate-100 flex items-center justify-between">
				<span class="text-xs font-semibold text-slate-500">
					Total Permohonan: <strong class="text-slate-800"><?= $total_permohonan ?> berkas</strong>
				</span>
				<a href="<?= site_url('layanan-mandiri/permohonan-surat') ?>" class="text-xs font-bold text-emerald-600 hover:text-emerald-700 inline-flex items-center space-x-1.5 transition-colors text-decoration-none">
					<span>Buka Semua Surat & Arsip</span>
					<i class="fa-solid fa-arrow-right text-[10px]"></i>
				</a>
			</div>

		</div>

		<!-- ----------------------------------------------------------------
		     WIDGET 2: PESAN MASUK TERBARU (KOTAK PESAN DESA)
		     ---------------------------------------------------------------- -->
		<div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden">
			
			<!-- Header -->
			<div class="p-5 sm:p-6 border-b border-slate-100 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
				<div class="flex items-center space-x-3.5">
					<div class="w-11 h-11 rounded-2xl bg-orange-50 text-orange-600 flex items-center justify-center text-lg flex-shrink-0 shadow-2xs">
						<i class="fa-solid fa-comments"></i>
					</div>
					<div>
						<h2 class="text-lg sm:text-xl font-bold font-display text-slate-900 m-0">
							Pesan dari Kantor Desa
						</h2>
						<p class="text-xs sm:text-sm text-slate-400 font-medium m-0 mt-0.5">
							Komunikasi resmi dan tanggapan layanan dari perangkat desa
						</p>
					</div>
				</div>

				<div class="flex items-center space-x-2.5 w-full sm:w-auto justify-between sm:justify-end">
					<a href="<?= site_url('layanan-mandiri/pesan/tulis') ?>" class="px-4 py-2 rounded-xl bg-orange-500 hover:bg-orange-600 text-white font-bold text-xs sm:text-sm shadow-xs transition-colors flex items-center space-x-2 text-decoration-none">
						<i class="fa-solid fa-pen text-xs"></i>
						<span>Kirim Pesan</span>
					</a>
				</div>
			</div>

			<!-- Body: Items List -->
			<div class="p-4 sm:p-6">
				<?php if (!empty($pesan_terkini)): ?>
					<div class="space-y-3">
						<?php foreach ($pesan_terkini as $msg): ?>
							<a href="<?= site_url('layanan-mandiri/pesan-masuk') ?>" class="block p-4 rounded-xl border border-slate-200/80 hover:border-slate-300 hover:bg-slate-50/60 transition-all text-decoration-none group">
								<div class="flex items-start justify-between gap-3">
									<div class="flex items-center space-x-2.5">
										<div class="w-8 h-8 rounded-full bg-orange-100 text-orange-600 flex items-center justify-center text-xs font-bold flex-shrink-0">
											<i class="fa-solid fa-user-tie"></i>
										</div>
										<div>
											<p class="text-xs sm:text-sm font-bold text-slate-900 group-hover:text-orange-600 transition-colors m-0">
												<?= !empty($msg['owner']) ? $msg['owner'] : 'Operator Desa Balongbesuk'; ?>
											</p>
											<p class="text-[11px] text-slate-400 m-0">
												<?= tgl_indo2($msg['tgl_upload']); ?>
											</p>
										</div>
									</div>
									<span class="text-[11px] font-bold text-slate-500 bg-slate-100 px-2 py-0.5 rounded-full flex-shrink-0">
										Kotak Masuk
									</span>
								</div>
								<p class="text-xs sm:text-sm text-slate-600 mt-2.5 line-clamp-2 leading-relaxed m-0">
									<?= strip_tags($msg['komentar']); ?>
								</p>
							</a>
						<?php endforeach; ?>
					</div>
				<?php else: ?>
					<!-- Empty State -->
					<div class="py-10 px-4 text-center">
						<div class="w-16 h-16 rounded-2xl bg-orange-50 text-orange-600 flex items-center justify-center text-2xl mx-auto mb-3 shadow-2xs">
							<i class="fa-regular fa-envelope-open"></i>
						</div>
						<h3 class="text-base font-bold text-slate-800 m-0">Kotak Pesan Masuk Kosong</h3>
						<p class="text-xs sm:text-sm text-slate-400 max-w-sm mx-auto mt-1 leading-relaxed">
							Belum ada pesan atau pertanyaan baru dari kantor desa. Butuh bantuan? Silakan kirim pesan ke operator desa.
						</p>
						<a href="<?= site_url('layanan-mandiri/pesan/tulis') ?>" class="mt-4 inline-flex items-center space-x-2 px-4 py-2 rounded-xl bg-orange-500 hover:bg-orange-600 text-white font-bold text-xs sm:text-sm transition-colors text-decoration-none shadow-xs">
							<i class="fa-solid fa-pen text-xs"></i>
							<span>Tulis Pesan ke Desa</span>
						</a>
					</div>
				<?php endif; ?>
			</div>

			<!-- Footer -->
			<div class="p-4 bg-slate-50/80 border-t border-slate-100 flex items-center justify-between">
				<span class="text-xs font-semibold text-slate-500">
					Total Pesan Masuk: <strong class="text-slate-800"><?= $total_pesan ?> pesan</strong>
				</span>
				<a href="<?= site_url('layanan-mandiri/pesan-masuk') ?>" class="text-xs font-bold text-orange-600 hover:text-orange-700 inline-flex items-center space-x-1.5 transition-colors text-decoration-none">
					<span>Buka Kotak Pesan</span>
					<i class="fa-solid fa-arrow-right text-[10px]"></i>
				</a>
			</div>

		</div>

	</div>

	<!-- ====================================================================
	     RIGHT COLUMN (DATA WARGA, KEAMANAN, JAM LAYANAN)
	     ==================================================================== -->
	<div class="lg:col-span-5 xl:col-span-4 space-y-6">

		<!-- ----------------------------------------------------------------
		     WIDGET 3: RINGKASAN DATA KEPENDUDUKAN
		     ---------------------------------------------------------------- -->
		<div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden">
			
			<!-- Header -->
			<div class="p-5 border-b border-slate-100 flex items-center justify-between">
				<div class="flex items-center space-x-3">
					<div class="w-10 h-10 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center text-base shadow-2xs">
						<i class="fa-solid fa-address-card"></i>
					</div>
					<div>
						<h3 class="text-base font-bold font-display text-slate-900 m-0">Data Kependudukan</h3>
						<p class="text-xs text-slate-400 font-medium m-0">Profil resmi terdaftar</p>
					</div>
				</div>
				<a href="<?= site_url('layanan-mandiri/profil') ?>" class="text-xs font-bold text-indigo-600 hover:text-indigo-700 text-decoration-none">
					Selengkapnya
				</a>
			</div>

			<!-- Profile Snapshot -->
			<div class="p-5">
				<div class="flex items-center space-x-4 pb-4 border-b border-slate-100">
					<img class="w-14 h-14 rounded-2xl object-cover border-2 border-slate-200 shadow-2xs flex-shrink-0" src="<?= AmbilFoto($this->is_login->foto, '', $this->is_login->sex) ?>" alt="<?= $this->is_login->nama ?>">
					<div class="min-w-0 flex-1">
						<h4 class="text-base font-bold text-slate-900 truncate m-0">
							<?= strtoupper($this->is_login->nama); ?>
						</h4>
						<p class="text-xs font-mono font-medium text-slate-500 mt-0.5 truncate m-0">
							NIK: <?= $this->is_login->nik; ?>
						</p>
						<span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-800 mt-1">
							Status: <?= strtoupper($penduduk['status'] ?? 'AKTIF') ?>
						</span>
					</div>
				</div>

				<div class="py-3.5 space-y-2.5 text-xs text-slate-600">
					<div class="flex items-center justify-between py-1 border-b border-slate-50">
						<span class="text-slate-400">No. Kartu Keluarga</span>
						<strong class="font-mono text-slate-800"><?= $penduduk['no_kk'] ?: '-' ?></strong>
					</div>
					<div class="flex items-center justify-between py-1 border-b border-slate-50">
						<span class="text-slate-400">Wilayah / Dusun</span>
						<strong class="text-slate-800 text-right truncate max-w-[180px]"><?= $penduduk['dusun'] ?: 'Balongbesuk' ?></strong>
					</div>
					<div class="flex items-center justify-between py-1 border-b border-slate-50">
						<span class="text-slate-400">RT / RW</span>
						<strong class="text-slate-800">RT <?= $penduduk['rt'] ?: '-' ?> / RW <?= $penduduk['rw'] ?: '-' ?></strong>
					</div>
					<div class="flex items-center justify-between py-1 border-b border-slate-50">
						<span class="text-slate-400">Hubungan Keluarga</span>
						<strong class="text-slate-800"><?= $penduduk['hubungan'] ?: '-' ?></strong>
					</div>
				</div>

				<!-- Action Buttons -->
				<div class="pt-2 flex items-center space-x-2">
					<a href="<?= site_url('layanan-mandiri/profil') ?>" class="flex-1 py-2 px-3 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs text-center transition-colors text-decoration-none">
						<i class="fa-solid fa-user mr-1 text-slate-400"></i> Detail Profil
					</a>
					<a href="<?= site_url('layanan-mandiri/cetak-biodata') ?>" target="_blank" rel="noopener noreferrer" class="flex-1 py-2 px-3 rounded-xl bg-indigo-50 hover:bg-indigo-100 text-indigo-700 font-bold text-xs text-center transition-colors text-decoration-none">
						<i class="fa-solid fa-print mr-1 text-indigo-500"></i> Cetak Biodata
					</a>
				</div>
			</div>

		</div>

		<!-- ----------------------------------------------------------------
		     WIDGET 4: STATUS KEAMANAN & VERIFIKASI AKUN
		     ---------------------------------------------------------------- -->
		<div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden">
			
			<!-- Header -->
			<div class="p-5 border-b border-slate-100 flex items-center justify-between">
				<div class="flex items-center space-x-3">
					<div class="w-10 h-10 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center text-base shadow-2xs">
						<i class="fa-solid fa-shield-halved"></i>
					</div>
					<div>
						<h3 class="text-base font-bold font-display text-slate-900 m-0">Keamanan & Verifikasi</h3>
						<p class="text-xs text-slate-400 font-medium m-0">Jalur notifikasi & akses akun</p>
					</div>
				</div>
				<a href="<?= site_url('layanan-mandiri/verifikasi') ?>" class="text-xs font-bold text-purple-600 hover:text-purple-700 text-decoration-none">
					Kelola
				</a>
			</div>

			<!-- Status List -->
			<div class="p-5 space-y-3.5">
				
				<!-- Telegram Verification Status -->
				<div class="p-3.5 rounded-xl border <?= $tgl_verifikasi_telegram ? 'border-emerald-200 bg-emerald-50/40' : 'border-amber-200 bg-amber-50/40' ?> flex items-center justify-between gap-3">
					<div class="flex items-center space-x-3 flex-1 min-w-0">
						<div class="w-8 h-8 rounded-lg <?= $tgl_verifikasi_telegram ? 'bg-emerald-100 text-emerald-600' : 'bg-amber-100 text-amber-600' ?> flex items-center justify-center text-sm flex-shrink-0">
							<i class="fa-brands fa-telegram"></i>
						</div>
						<div class="flex-1 min-w-0">
							<div class="flex items-center space-x-2">
								<p class="text-xs sm:text-sm font-bold text-slate-900 m-0 truncate">Akun Telegram</p>
								<span class="inline-flex items-center px-1.5 py-0.5 rounded-full text-[10px] font-bold flex-shrink-0 <?= $tgl_verifikasi_telegram ? 'bg-emerald-100 text-emerald-800' : 'bg-amber-100 text-amber-800' ?>">
									<?= $tgl_verifikasi_telegram ? 'Terhubung' : 'Belum Terhubung' ?>
								</span>
							</div>
							<p class="text-[11px] text-slate-500 m-0 mt-0.5 truncate">
								<?= $tgl_verifikasi_telegram ? 'ID / Username: ' . (!empty($akun_penduduk->telegram) ? '@' . $akun_penduduk->telegram : 'Terdaftar') : 'Hubungkan untuk notifikasi bot otomatis' ?>
							</p>
						</div>
					</div>
					<div class="flex-shrink-0">
						<a href="<?= site_url('layanan-mandiri/verifikasi/telegram') ?>" class="whitespace-nowrap px-2.5 py-1 rounded-lg text-xs font-bold <?= $tgl_verifikasi_telegram ? 'bg-white border border-slate-200 text-slate-700 hover:bg-slate-50 shadow-2xs' : 'bg-amber-600 text-white hover:bg-amber-700' ?> transition-colors text-decoration-none">
							<?= $tgl_verifikasi_telegram ? 'Cek' : 'Hubungkan' ?>
						</a>
					</div>
				</div>

				<!-- Email Verification Status -->
				<div class="p-3.5 rounded-xl border <?= $tgl_verifikasi_email ? 'border-emerald-200 bg-emerald-50/40' : 'border-amber-200 bg-amber-50/40' ?> flex items-center justify-between gap-3">
					<div class="flex items-center space-x-3 flex-1 min-w-0">
						<div class="w-8 h-8 rounded-lg <?= $tgl_verifikasi_email ? 'bg-emerald-100 text-emerald-600' : 'bg-amber-100 text-amber-600' ?> flex items-center justify-center text-sm flex-shrink-0">
							<i class="fa-solid fa-at"></i>
						</div>
						<div class="flex-1 min-w-0">
							<div class="flex items-center space-x-2">
								<p class="text-xs sm:text-sm font-bold text-slate-900 m-0 truncate">Alamat Email</p>
								<span class="inline-flex items-center px-1.5 py-0.5 rounded-full text-[10px] font-bold flex-shrink-0 <?= $tgl_verifikasi_email ? 'bg-emerald-100 text-emerald-800' : 'bg-amber-100 text-amber-800' ?>">
									<?= $tgl_verifikasi_email ? 'Terverifikasi' : 'Belum Diverifikasi' ?>
								</span>
							</div>
							<p class="text-[11px] text-slate-500 m-0 mt-0.5 truncate">
								<?= $tgl_verifikasi_email ? (!empty($akun_penduduk->email) ? $akun_penduduk->email : 'Terverifikasi') : 'Verifikasi email untuk keamanan ekstra' ?>
							</p>
						</div>
					</div>
					<div class="flex-shrink-0">
						<a href="<?= site_url('layanan-mandiri/verifikasi/email') ?>" class="whitespace-nowrap px-2.5 py-1 rounded-lg text-xs font-bold <?= $tgl_verifikasi_email ? 'bg-white border border-slate-200 text-slate-700 hover:bg-slate-50 shadow-2xs' : 'bg-amber-600 text-white hover:bg-amber-700' ?> transition-colors text-decoration-none">
							<?= $tgl_verifikasi_email ? 'Cek' : 'Verifikasi' ?>
						</a>
					</div>
				</div>

				<!-- PIN Status -->
				<div class="p-3.5 rounded-xl border border-slate-200/80 bg-slate-50/50 flex items-center justify-between gap-3">
					<div class="flex items-center space-x-3 flex-1 min-w-0">
						<div class="w-8 h-8 rounded-lg bg-slate-200 text-slate-600 flex items-center justify-center text-sm flex-shrink-0">
							<i class="fa-solid fa-key"></i>
						</div>
						<div class="flex-1 min-w-0">
							<div class="flex items-center space-x-2">
								<p class="text-xs sm:text-sm font-bold text-slate-900 m-0 truncate">PIN Mandiri</p>
								<span class="inline-flex items-center px-1.5 py-0.5 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-800 flex-shrink-0">
									Aktif
								</span>
							</div>
							<p class="text-[11px] text-slate-500 m-0 mt-0.5 truncate">Keamanan akses akun</p>
						</div>
					</div>
					<div class="flex-shrink-0">
						<a href="<?= site_url('layanan-mandiri/ganti-pin') ?>" class="whitespace-nowrap px-2.5 py-1 rounded-lg text-xs font-bold bg-white border border-slate-200 text-slate-700 hover:bg-slate-50 shadow-2xs transition-colors text-decoration-none">
							Ganti PIN
						</a>
					</div>
				</div>

			</div>

		</div>

		<!-- ----------------------------------------------------------------
		     WIDGET 5: PUSAT INFORMASI & BANTUAN DESA
		     ---------------------------------------------------------------- -->
		<div class="bg-gradient-to-br from-slate-900 to-slate-800 text-white rounded-2xl p-5 sm:p-6 shadow-sm relative overflow-hidden">
			
			<div class="relative z-10">
				<div class="w-10 h-10 rounded-xl bg-white/10 backdrop-blur-xs text-white flex items-center justify-center text-base mb-3 shadow-2xs">
					<i class="fa-solid fa-clock"></i>
				</div>
				<h3 class="text-base sm:text-lg font-bold font-display text-white m-0">
					Jam Layanan Kantor Desa
				</h3>
				<p class="text-xs text-slate-300 mt-1 leading-relaxed">
					Kantor Balai Desa Balongbesuk siap melayani keperluan administrasi warga pada:
				</p>

				<div class="my-4 space-y-1.5 text-xs text-slate-200 border-y border-white/10 py-3">
					<div class="flex items-center justify-between">
						<span>Senin – Kamis</span>
						<strong class="font-mono text-emerald-400">08:00 – 15:00 WIB</strong>
					</div>
					<div class="flex items-center justify-between">
						<span>Jumat</span>
						<strong class="font-mono text-emerald-400">08:00 – 14:00 WIB</strong>
					</div>
					<div class="flex items-center justify-between text-slate-400">
						<span>Sabtu – Minggu / Libur</span>
						<span class="italic">Pelayanan Tatap Muka Tutup</span>
					</div>
				</div>

				<p class="text-[11px] text-slate-400 leading-normal mb-3">
					*Layanan Mandiri Online ini dapat diakses mandiri 24 jam setiap hari.
				</p>

				<a href="<?= site_url('layanan-mandiri/pesan/tulis') ?>" class="w-full py-2.5 px-4 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs flex items-center justify-center space-x-2 transition-colors text-decoration-none shadow-sm">
					<i class="fa-solid fa-headset text-sm"></i>
					<span>Hubungi Kantor Desa</span>
				</a>
			</div>

			<i class="fa-solid fa-landmark absolute -bottom-5 -right-5 text-[120px] text-white/5 pointer-events-none transform -rotate-12"></i>
		</div>

	</div>

</div>
