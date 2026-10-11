<?php

defined('BASEPATH') || exit('No direct script access allowed');

/*
 * File ini:
 *
 * View modul Layanan Mandiri > Verifikasi (Telegram & Email)
 * Redesigned with Next-Gen UI/UX Pro Max (Tema Desa Balongbesuk)
 *
 * donjo-app/views/fmandiri/verifikasi.php
 */
?>

<!-- ========================================================================
     PAGE TITLE & BREADCRUMB CARD
     ======================================================================== -->
<div class="relative bg-white rounded-2xl border border-slate-200/80 p-5 sm:p-6 mb-6 shadow-xs overflow-hidden flex items-center justify-between">
	
	<!-- Left: Big Purple Icon + Title & Breadcrumb -->
	<div class="flex items-center space-x-4 z-10">
		<div class="w-12 h-12 sm:w-14 sm:h-14 rounded-2xl bg-purple-600 text-white flex items-center justify-center text-xl sm:text-2xl shadow-sm flex-shrink-0">
			<i class="fa-solid fa-shield-halved"></i>
		</div>
		<div>
			<h2 class="text-2xl sm:text-3xl font-extrabold font-display text-slate-900 leading-tight">
				Verifikasi Akun
			</h2>
			<nav class="flex items-center space-x-2 text-sm text-slate-400 font-medium mt-1">
				<a href="<?= site_url('layanan-mandiri/beranda') ?>" class="hover:text-purple-600 transition-colors text-decoration-none text-slate-400">Beranda</a>
				<span>&rsaquo;</span>
				<span class="text-slate-600 font-semibold">Verifikasi</span>
			</nav>
		</div>
	</div>

	<!-- Right: Subtle Status Indicator -->
	<div class="hidden sm:flex items-center space-x-2 bg-purple-50 border border-purple-200/70 text-purple-800 px-4 py-2 rounded-xl text-sm font-semibold">
		<i class="fa-solid fa-user-shield text-purple-600"></i>
		<span>Otentikasi OTP</span>
	</div>

</div>

<!-- ========================================================================
     SUB-NAVIGATION PILLS (TELEGRAM vs EMAIL)
     ======================================================================== -->
<?php
$tab_aktif = ($this->uri->segment(3) == 'email') ? 'email' : 'telegram';
?>
<div class="flex items-center space-x-3 mb-6">
	<button type="button" id="link-telegram" class="inline-flex items-center space-x-2.5 px-6 py-3 rounded-xl text-sm sm:text-base font-bold transition-all <?= ($tab_aktif === 'telegram') ? 'bg-purple-600 text-white shadow-xs' : 'bg-white text-slate-700 hover:text-purple-600 border border-slate-200' ?>">
		<i class="fa-brands fa-telegram text-base"></i>
		<span>Verifikasi Telegram</span>
		<?php if ($tgl_verifikasi_telegram) : ?>
			<i class="fa-solid fa-circle-check text-xs ml-1 <?= ($tab_aktif === 'telegram') ? 'text-white/90' : 'text-emerald-500' ?>" title="Sudah Terverifikasi"></i>
		<?php endif; ?>
	</button>

	<button type="button" id="link-email" class="inline-flex items-center space-x-2.5 px-6 py-3 rounded-xl text-sm sm:text-base font-bold transition-all <?= ($tab_aktif === 'email') ? 'bg-purple-600 text-white shadow-xs' : 'bg-white text-slate-700 hover:text-purple-600 border border-slate-200' ?>">
		<i class="fa-solid fa-envelope text-base"></i>
		<span>Verifikasi Email</span>
		<?php if ($tgl_verifikasi_email) : ?>
			<i class="fa-solid fa-circle-check text-xs ml-1 <?= ($tab_aktif === 'email') ? 'text-white/90' : 'text-emerald-500' ?>" title="Sudah Terverifikasi"></i>
		<?php endif; ?>
	</button>
</div>

<!-- ========================================================================
     MAIN STATUS / WIZARD CARD CONTAINER
     ======================================================================== -->
<div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs p-6 sm:p-8 mb-6">
	
	<?php if ($notif_verifikasi = $this->session->flashdata('notif_verifikasi')) : ?>
		<div class="mb-6 p-4 rounded-xl <?= ($notif_verifikasi['status'] == 1) ? 'bg-emerald-50 border border-emerald-200 text-emerald-800' : 'bg-rose-50 border border-rose-200 text-rose-800' ?> text-sm sm:text-base flex items-start space-x-3">
			<i class="fa-solid <?= ($notif_verifikasi['status'] == 1) ? 'fa-circle-check text-emerald-600' : 'fa-triangle-exclamation text-rose-600' ?> mt-0.5 text-lg flex-shrink-0"></i>
			<div class="font-medium"><?= $notif_verifikasi['pesan']; ?></div>
		</div>
	<?php endif; ?>

	<?php if (!empty($sudah_verifikasi_semua)) : ?>
		<div class="mb-6 p-5 sm:p-6 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 flex flex-col sm:flex-row items-center text-center sm:text-left space-y-3 sm:space-y-0 sm:space-x-4">
			<div class="w-12 h-12 rounded-xl bg-emerald-600 text-white flex items-center justify-center text-xl flex-shrink-0 shadow-xs">
				<i class="fa-solid fa-check-double"></i>
			</div>
			<div>
				<h4 class="text-base sm:text-lg font-bold font-display text-emerald-950 m-0">Semua Akun Sudah Terverifikasi</h4>
				<p class="text-xs sm:text-sm text-emerald-700 m-0 mt-0.5">Akun Telegram dan Email resmi Anda telah berhasil diverifikasi dalam sistem layanan mandiri desa.</p>
			</div>
		</div>
	<?php endif; ?>

	<div class="tab-content">
		
		<!-- TAB 1: TELEGRAM -->
		<div class="<?= ($tab_aktif === 'telegram') ? 'active' : '' ?> tab-pane" id="telegram">
			<?php if ($tgl_verifikasi_telegram) : ?>
				<!-- Tampilan jika akun Telegram SUDAH terverifikasi (tanpa langkah wizard) -->
				<div class="p-6 sm:p-8 rounded-2xl bg-slate-50/70 border border-slate-200/80">
					<div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 pb-6 border-b border-slate-200/80">
						<div class="flex items-center space-x-4">
							<div class="w-14 h-14 rounded-2xl bg-sky-100 text-sky-600 flex items-center justify-center text-3xl shadow-xs">
								<i class="fa-brands fa-telegram"></i>
							</div>
							<div>
								<div class="flex items-center space-x-2">
									<h3 class="text-lg sm:text-xl font-bold font-display text-slate-900 m-0">Akun Telegram Terverifikasi</h3>
									<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-emerald-100 text-emerald-800 border border-emerald-200">
										<i class="fa-solid fa-circle-check mr-1 text-emerald-600"></i> Aktif
									</span>
								</div>
								<p class="text-xs sm:text-sm text-slate-500 m-0 mt-1">Bot Notifikasi: <a href="https://t.me/opensid_notifikasi_bot" target="_blank" rel="noopener noreferrer" class="font-bold text-sky-600 hover:text-sky-700">@opensid_notifikasi_bot</a></p>
							</div>
						</div>
						<div class="text-xs font-semibold px-3 py-1.5 rounded-xl bg-emerald-50 text-emerald-700 border border-emerald-200 flex items-center space-x-1.5">
							<i class="fa-solid fa-shield-halved text-emerald-600"></i>
							<span>Status Notifikasi Aktif</span>
						</div>
					</div>

					<div class="py-6 space-y-4">
						<div class="p-4 rounded-xl bg-white border border-slate-200 text-sm text-slate-700 leading-relaxed shadow-xs">
							<p class="m-0 font-medium text-emerald-800 flex items-center">
								<i class="fa-solid fa-circle-check text-emerald-600 mr-2 text-base"></i>
								Akun Telegram Anda SUDAH Terverifikasi dalam sistem layanan mandiri desa.
							</p>
							<p class="m-0 text-slate-500 text-xs sm:text-sm mt-1">
								Anda akan menerima notifikasi pesan instan mengenai progres pengajuan surat dan informasi resmi desa langsung melalui bot Telegram.
							</p>
						</div>

						<div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
							<div class="p-4 rounded-xl border border-slate-200 bg-white">
								<span class="text-xs font-bold uppercase tracking-wider text-slate-400 block mb-1">User ID Telegram</span>
								<span class="text-base font-bold font-mono text-slate-800"><?= !empty($akun_penduduk->telegram) ? $akun_penduduk->telegram : '-' ?></span>
							</div>
							<div class="p-4 rounded-xl border border-slate-200 bg-white">
								<span class="text-xs font-bold uppercase tracking-wider text-slate-400 block mb-1">Status Verifikasi</span>
								<span class="text-sm font-semibold text-emerald-700 flex items-center">
									<i class="fa-solid fa-check text-xs mr-1 text-emerald-600"></i>
									<?= !empty($akun_penduduk->telegram_tgl_verifikasi) ? tgl_indo2($akun_penduduk->telegram_tgl_verifikasi) : 'Terverifikasi' ?>
								</span>
							</div>
						</div>
					</div>
				</div>
			<?php else : ?>
				<!-- Wizard Langkah jika Telegram BELUM terverifikasi -->
				<div class="mb-5">
					<h3 class="text-lg sm:text-xl font-bold font-display text-slate-900">
						Langkah Verifikasi Akun Telegram
					</h3>
					<p class="text-sm text-slate-500 mt-0.5">
						Ikuti tahapan di bawah ini dari Langkah 1 hingga 4 untuk menghubungkan notifikasi desa ke akun Telegram Anda.
					</p>
				</div>

				<div id="smartwizard" class="border border-slate-200/80 rounded-2xl p-4 sm:p-6 bg-slate-50/50">
					<ul class="nav">
						<li>
							<a class="nav-link" href="#langkah-1">
								Langkah 1<br />
								<small class="font-semibold text-slate-500">Link Verifikasi</small>
							</a>
						</li>
						<li>
							<a class="nav-link" href="#langkah-2">
								Langkah 2<br />
								<small class="font-semibold text-slate-500">Masukan User ID</small>
							</a>
						</li>
						<li>
							<a class="nav-link" href="#langkah-3">
								Langkah 3<br />
								<small class="font-semibold text-slate-500">OTP Verifikasi</small>
							</a>
						</li>
						<li>
							<a class="nav-link" href="#langkah-4">
								Langkah 4<br />
								<small class="font-semibold text-slate-500">Status</small>
							</a>
						</li>
					</ul>

					<div class="tab-content p-4 sm:p-6 bg-white rounded-xl border border-slate-200 mt-4">
						
						<!-- Step 1 Telegram -->
						<div id="langkah-1" class="tab-pane" role="tabpanel">
							<h3 class="text-lg font-bold font-display text-slate-900 mb-3">Langkah 1: Hubungkan ke Bot Telegram</h3>
							<div class="space-y-3 text-sm sm:text-base text-slate-700 leading-relaxed">
								<p>1. Silakan buka dan klik tautan bot resmi berikut: <a href="https://t.me/opensid_notifikasi_bot" target="_blank" rel="noopener noreferrer" class="font-bold text-sky-600 hover:text-sky-700"><i class="fa-brands fa-telegram mr-1"></i> Bot Notifikasi <?= config_item('nama_aplikasi') ?></a></p>
								<p>2. Tekan tombol <strong>Start</strong> di aplikasi Telegram untuk mendapatkan kode <strong>User ID</strong> akun Anda.</p>
								<p>3. Masukkan kode User ID tersebut di <strong>Langkah 2</strong> dengan cara mengklik tombol <strong>"Selanjutnya"</strong> di bawah.</p>
							</div>
						</div>

						<!-- Step 2 Telegram -->
						<div id="langkah-2" class="tab-pane" role="tabpanel">
							<h3 class="text-lg font-bold font-display text-slate-900 mb-3">Langkah 2: Masukkan User ID Telegram</h3>
							<p class="text-sm sm:text-base text-slate-600 mb-4">
								Ketikkan kode User ID yang telah Anda peroleh dari bot Telegram pada kolom berikut:
							</p>

							<form action="<?= $form_kirim_userid; ?>" method="POST" class="max-w-md space-y-4">
								<div>
									<label for="telegram_userID" class="block text-sm font-bold uppercase tracking-wider text-slate-800 mb-2">User ID Telegram <span class="text-rose-600">*</span></label>
									<div class="relative">
										<input type="password" class="w-full pr-12 rounded-xl border border-slate-300 px-4 py-3 text-base font-mono text-slate-900 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500 shadow-xs pin required <?= jecho($cek_anjungan['keyboard'] == 1, true, 'kbvnumber'); ?>" name="telegram_userID" placeholder="Contoh: 123456789" maxlength="16">
										<button type="button" class="absolute inset-y-0 right-0 pr-4 flex items-center text-slate-400 hover:text-slate-600" onclick="show(this);"><i class="fa-solid fa-eye-slash" id="telegram_userID"></i></button>
									</div>
								</div>
								<button type="submit" class="px-7 py-3 rounded-xl bg-purple-600 hover:bg-purple-700 text-white font-bold text-sm sm:text-base shadow-xs transition-colors flex items-center space-x-2">
									<i class="fa-solid fa-paper-plane text-xs"></i>
									<span>Kirim User ID & Dapatkan OTP</span>
								</button>
							</form>
						</div>

						<!-- Step 3 Telegram -->
						<div id="langkah-3" class="tab-pane" role="tabpanel">
							<h3 class="text-lg font-bold font-display text-slate-900 mb-3">Langkah 3: Masukkan Kode OTP Telegram</h3>
							<p class="text-sm sm:text-base text-slate-600 mb-4">
								Periksa pesan terbaru dari bot Telegram Anda. Masukkan 6 digit kode OTP rahasia yang dikirimkan (berlaku 1 menit).
							</p>

							<form action="<?= $form_kirim_otp; ?>" method="POST" id="validasi" class="max-w-md space-y-4">
								<div>
									<label for="token_telegram" class="block text-sm font-bold uppercase tracking-wider text-slate-800 mb-2">Kode OTP Verifikasi <span class="text-rose-600">*</span></label>
									<div class="relative">
										<input type="password" class="w-full pr-12 rounded-xl border border-slate-300 px-4 py-3 text-base font-mono tracking-widest text-slate-900 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500 shadow-xs pin required <?= jecho($cek_anjungan['keyboard'] == 1, true, 'kbvnumber'); ?>" name="token_telegram" placeholder="6 Digit OTP">
										<button type="button" class="absolute inset-y-0 right-0 pr-4 flex items-center text-slate-400 hover:text-slate-600" onclick="show(this);"><i class="fa-solid fa-eye-slash" id="token_telegram"></i></button>
									</div>
								</div>
								<button type="submit" class="px-7 py-3 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-sm sm:text-base shadow-xs transition-colors flex items-center space-x-2">
									<i class="fa-solid fa-check text-xs"></i>
									<span>Verifikasi OTP Telegram</span>
								</button>
							</form>
						</div>

						<!-- Step 4 Telegram -->
						<div id="langkah-4" class="tab-pane" role="tabpanel">
							<h3 class="text-lg font-bold font-display text-slate-900 mb-3">Langkah 4: Status Verifikasi Telegram</h3>
							<div class="p-5 rounded-xl bg-amber-50 border border-amber-200 text-amber-800 flex items-center space-x-3">
								<i class="fa-solid fa-clock text-amber-600 text-2xl flex-shrink-0"></i>
								<div class="font-bold text-sm sm:text-base">
									Akun Telegram Anda BELUM Terverifikasi.
								</div>
							</div>
						</div>

					</div>
				</div>
			<?php endif; ?>
		</div>

		<!-- TAB 2: EMAIL -->
		<div class="<?= ($tab_aktif === 'email') ? 'active' : '' ?> tab-pane" id="email">
			<?php if ($tgl_verifikasi_email) : ?>
				<!-- Tampilan jika akun Email SUDAH terverifikasi (tanpa langkah wizard) -->
				<div class="p-6 sm:p-8 rounded-2xl bg-slate-50/70 border border-slate-200/80">
					<div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 pb-6 border-b border-slate-200/80">
						<div class="flex items-center space-x-4">
							<div class="w-14 h-14 rounded-2xl bg-purple-100 text-purple-600 flex items-center justify-center text-2xl shadow-xs">
								<i class="fa-solid fa-envelope"></i>
							</div>
							<div>
								<div class="flex items-center space-x-2">
									<h3 class="text-lg sm:text-xl font-bold font-display text-slate-900 m-0">Alamat Email Terverifikasi</h3>
									<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-emerald-100 text-emerald-800 border border-emerald-200">
										<i class="fa-solid fa-circle-check mr-1 text-emerald-600"></i> Aktif
									</span>
								</div>
								<p class="text-xs sm:text-sm text-slate-500 m-0 mt-1">Saluran Pengiriman Tanda Terima & Berkas Digital</p>
							</div>
						</div>
						<div class="text-xs font-semibold px-3 py-1.5 rounded-xl bg-emerald-50 text-emerald-700 border border-emerald-200 flex items-center space-x-1.5">
							<i class="fa-solid fa-shield-halved text-emerald-600"></i>
							<span>Status Layanan Aktif</span>
						</div>
					</div>

					<div class="py-6 space-y-4">
						<div class="p-4 rounded-xl bg-white border border-slate-200 text-sm text-slate-700 leading-relaxed shadow-xs">
							<p class="m-0 font-medium text-emerald-800 flex items-center">
								<i class="fa-solid fa-circle-check text-emerald-600 mr-2 text-base"></i>
								Alamat Email Anda SUDAH Terverifikasi dalam sistem layanan mandiri desa.
							</p>
							<p class="m-0 text-slate-500 text-xs sm:text-sm mt-1">
								Pemberitahuan resmi dan tanda terima digital pengajuan surat akan dikirimkan ke kotak masuk alamat email ini.
							</p>
						</div>

						<div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
							<div class="p-4 rounded-xl border border-slate-200 bg-white">
								<span class="text-xs font-bold uppercase tracking-wider text-slate-400 block mb-1">Alamat Email Terdaftar</span>
								<span class="text-base font-bold font-mono text-slate-800"><?= !empty($akun_penduduk->email) ? $akun_penduduk->email : '-' ?></span>
							</div>
							<div class="p-4 rounded-xl border border-slate-200 bg-white">
								<span class="text-xs font-bold uppercase tracking-wider text-slate-400 block mb-1">Status Verifikasi</span>
								<span class="text-sm font-semibold text-emerald-700 flex items-center">
									<i class="fa-solid fa-check text-xs mr-1 text-emerald-600"></i>
									<?= !empty($akun_penduduk->email_tgl_verifikasi) ? tgl_indo2($akun_penduduk->email_tgl_verifikasi) : 'Terverifikasi' ?>
								</span>
							</div>
						</div>
					</div>
				</div>
			<?php else : ?>
				<!-- Wizard Langkah jika Email BELUM terverifikasi -->
				<div class="mb-5">
					<h3 class="text-lg sm:text-xl font-bold font-display text-slate-900">
						Langkah Verifikasi Alamat Email
					</h3>
					<p class="text-sm text-slate-500 mt-0.5">
						Ikuti tahapan di bawah ini dari Langkah 1 hingga 4 untuk mendaftarkan dan memverifikasi email resmi Anda.
					</p>
				</div>

				<div id="smartwizard-email" class="border border-slate-200/80 rounded-2xl p-4 sm:p-6 bg-slate-50/50">
					<ul class="nav">
						<li>
							<a class="nav-link" href="#langkah-email-1">
								Langkah 1<br />
								<small class="font-semibold text-slate-500">Persiapkan Email</small>
							</a>
						</li>
						<li>
							<a class="nav-link" href="#langkah-email-2">
								Langkah 2<br />
								<small class="font-semibold text-slate-500">Masukan Alamat Email</small>
							</a>
						</li>
						<li>
							<a class="nav-link" href="#langkah-email-3">
								Langkah 3<br />
								<small class="font-semibold text-slate-500">OTP Verifikasi</small>
							</a>
						</li>
						<li>
							<a class="nav-link" href="#langkah-email-4">
								Langkah 4<br />
								<small class="font-semibold text-slate-500">Status</small>
							</a>
						</li>
					</ul>

					<div class="tab-content p-4 sm:p-6 bg-white rounded-xl border border-slate-200 mt-4">
						
						<!-- Step 1 Email -->
						<div id="langkah-email-1" class="tab-pane" role="tabpanel">
							<h3 class="text-lg font-bold font-display text-slate-900 mb-3">Langkah 1: Persiapkan Alamat Email</h3>
							<div class="space-y-3 text-sm sm:text-base text-slate-700 leading-relaxed">
								<p>1. Pastikan Anda dapat mengakses kotak masuk (inbox / spam) dari alamat email yang akan didaftarkan.</p>
								<p>2. Lanjutkan ke <strong>Langkah 2</strong> dengan mengklik tombol <strong>"Selanjutnya"</strong> untuk memasukkan alamat email Anda.</p>
							</div>
						</div>

						<!-- Step 2 Email -->
						<div id="langkah-email-2" class="tab-pane" role="tabpanel">
							<h3 class="text-lg font-bold font-display text-slate-900 mb-3">Langkah 2: Masukkan Alamat Email</h3>
							<p class="text-sm sm:text-base text-slate-600 mb-4">
								Masukkan alamat email Anda yang masih aktif dan dapat menerima pesan:
							</p>

							<form action="<?= $form_kirim_email; ?>" method="POST" class="max-w-md space-y-4">
								<div>
									<label for="alamat_email" class="block text-sm font-bold uppercase tracking-wider text-slate-800 mb-2">Alamat Email <span class="text-rose-600">*</span></label>
									<input type="email" class="w-full rounded-xl border border-slate-300 px-4 py-3 text-base text-slate-900 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500 shadow-xs required email" name="alamat_email" placeholder="nama@email.com">
								</div>
								<button type="submit" class="px-7 py-3 rounded-xl bg-purple-600 hover:bg-purple-700 text-white font-bold text-sm sm:text-base shadow-xs transition-colors flex items-center space-x-2">
									<i class="fa-solid fa-paper-plane text-xs"></i>
									<span>Kirim Email & Dapatkan OTP</span>
								</button>
							</form>
						</div>

						<!-- Step 3 Email -->
						<div id="langkah-email-3" class="tab-pane" role="tabpanel">
							<h3 class="text-lg font-bold font-display text-slate-900 mb-3">Langkah 3: Masukkan Kode OTP Email</h3>
							<p class="text-sm sm:text-base text-slate-600 mb-4">
								Buka email Anda dan periksa pesan verifikasi. Masukkan kode OTP 6 digit yang tercantum di email tersebut (berlaku 1 menit).
							</p>

							<form action="<?= $form_kirim_otp_email; ?>" method="POST" id="validasi-email" class="max-w-md space-y-4">
								<div>
									<label for="token_email" class="block text-sm font-bold uppercase tracking-wider text-slate-800 mb-2">Kode OTP Verifikasi Email <span class="text-rose-600">*</span></label>
									<div class="relative">
										<input type="password" class="w-full pr-12 rounded-xl border border-slate-300 px-4 py-3 text-base font-mono tracking-widest text-slate-900 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500 shadow-xs pin required <?= jecho($cek_anjungan['keyboard'] == 1, true, 'kbvnumber'); ?>" name="token_email" placeholder="6 Digit OTP">
										<button type="button" class="absolute inset-y-0 right-0 pr-4 flex items-center text-slate-400 hover:text-slate-600" onclick="show(this);"><i class="fa-solid fa-eye-slash" id="token_email"></i></button>
									</div>
								</div>
								<button type="submit" class="px-7 py-3 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-sm sm:text-base shadow-xs transition-colors flex items-center space-x-2">
									<i class="fa-solid fa-check text-xs"></i>
									<span>Verifikasi OTP Email</span>
								</button>
							</form>
						</div>

						<!-- Step 4 Email -->
						<div id="langkah-email-4" class="tab-pane" role="tabpanel">
							<h3 class="text-lg font-bold font-display text-slate-900 mb-3">Langkah 4: Status Verifikasi Email</h3>
							<div class="p-5 rounded-xl bg-amber-50 border border-amber-200 text-amber-800 flex items-center space-x-3">
								<i class="fa-solid fa-clock text-amber-600 text-2xl flex-shrink-0"></i>
								<div class="font-bold text-sm sm:text-base">
									Alamat Email Anda BELUM Terverifikasi.
								</div>
							</div>
						</div>

					</div>
				</div>
			<?php endif; ?>
		</div>

	</div>

</div>

<script type="text/javascript">
	function show(elem) {
		var input = $(elem).parent().find('input');
		var icon = $(elem).find('i');
		if (input.attr('type') === 'password') {
			input.attr('type', 'text');
			icon.removeClass('fa-eye-slash').addClass('fa-eye');
		} else {
			input.attr('type', 'password');
			icon.removeClass('fa-eye').addClass('fa-eye-slash');
		}
	}

	$(document).ready(function() {
		// Bersihkan hash dari URL browser agar selalu bersih
		if (window.location.hash) {
			history.replaceState(null, null, window.location.pathname + window.location.search);
		}

		// Link tab Telegram
		$('#link-telegram').click(function(e) {
			e.preventDefault();
			window.location.href = '<?= site_url('layanan-mandiri/verifikasi/telegram')  ?>';
		});

		// Link tab Email
		$('#link-email').click(function(e) {
			e.preventDefault();
			window.location.href = '<?= site_url('layanan-mandiri/verifikasi/email')  ?>';
		});

		// Inisialisasi Smartwizard Telegram (hanya jika wizard ada / belum terverifikasi)
		if ($('#smartwizard').length > 0) {
			$('#smartwizard').smartWizard({
				selected: 0,
				theme: 'arrows',
				justified: true,
				darkMode: false,
				autoAdjustHeight: true,
				cycleSteps: false,
				backButtonSupport: false,
				enableURLhash: false,
				transition: {
					animation: 'fade',
					speed: '400',
					easing: ''
				},
				toolbarSettings: {
					toolbarPosition: 'bottom',
					toolbarButtonPosition: 'right',
					showNextButton: true,
					showPreviousButton: true,
					toolbarExtraButtons: []
				},
				anchorSettings: {
					anchorClickable: true,
					enableAllAnchors: false,
					markDoneStep: true,
					markAllPreviousStepsAsDone: true,
					removeDoneStepOnNavigateBack: false,
					enableAnchorOnDoneStep: true
				},
				keyboardSettings: {
					keyNavigation: true,
					keyLeft: [37],
					keyRight: [39]
				},
				lang: {
					next: 'Selanjutnya',
					previous: 'Sebelumnya'
				},
				disabledSteps: [],
				errorSteps: [],
				hiddenSteps: []
			});

			$('#smartwizard').smartWizard("stepState", [2, 3], "disable");

			<?php if ($this->session->flashdata('kirim-otp-telegram')) : ?>
				$('#smartwizard').smartWizard("stepState", [0, 1], "disable");
				$('#smartwizard').smartWizard("stepState", [2], "enable");
				$('#smartwizard').smartWizard("goToStep", 2);
			<?php endif ?>
		}

		// Inisialisasi Smartwizard Email (hanya jika wizard ada / belum terverifikasi)
		if ($('#smartwizard-email').length > 0) {
			$('#smartwizard-email').smartWizard({
				selected: 0,
				theme: 'arrows',
				justified: true,
				darkMode: false,
				autoAdjustHeight: true,
				cycleSteps: false,
				backButtonSupport: false,
				enableURLhash: false,
				transition: {
					animation: 'fade',
					speed: '400',
					easing: ''
				},
				toolbarSettings: {
					toolbarPosition: 'bottom',
					toolbarButtonPosition: 'right',
					showNextButton: true,
					showPreviousButton: true,
					toolbarExtraButtons: []
				},
				anchorSettings: {
					anchorClickable: true,
					enableAllAnchors: false,
					markDoneStep: true,
					markAllPreviousStepsAsDone: true,
					removeDoneStepOnNavigateBack: false,
					enableAnchorOnDoneStep: true
				},
				keyboardSettings: {
					keyNavigation: true,
					keyLeft: [37],
					keyRight: [39]
				},
				lang: {
					next: 'Selanjutnya',
					previous: 'Sebelumnya'
				},
				disabledSteps: [],
				errorSteps: [],
				hiddenSteps: []
			});

			$('#smartwizard-email').smartWizard("stepState", [2, 3], "disable");

			<?php if ($this->session->flashdata('kirim-otp-email')) : ?>
				$('#smartwizard-email').smartWizard("stepState", [0, 1], "disable");
				$('#smartwizard-email').smartWizard("stepState", [2], "enable");
				$('#smartwizard-email').smartWizard("goToStep", 2);
			<?php endif ?>
		}
	});
</script>
