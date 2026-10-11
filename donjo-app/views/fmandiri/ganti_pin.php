<?php

defined('BASEPATH') || exit('No direct script access allowed');

/*
 * File ini:
 *
 * View modul Layanan Mandiri > Ganti PIN
 * Redesigned with Next-Gen UI/UX Pro Max (Tema Desa Balongbesuk)
 *
 * donjo-app/views/fmandiri/ganti_pin.php
 */
?>

<!-- ========================================================================
     PAGE TITLE & BREADCRUMB CARD
     ======================================================================== -->
<div class="relative bg-white rounded-2xl border border-slate-200/80 p-5 sm:p-6 mb-6 shadow-xs overflow-hidden flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
	
	<!-- Left: Big Amber Icon + Title & Breadcrumb -->
	<div class="flex items-center space-x-4 z-10">
		<div class="w-12 h-12 sm:w-14 sm:h-14 rounded-2xl bg-amber-500 text-white flex items-center justify-center text-xl sm:text-2xl shadow-sm flex-shrink-0">
			<i class="fa-solid fa-key"></i>
		</div>
		<div>
			<h2 class="text-2xl sm:text-3xl font-extrabold font-display text-slate-900 leading-tight">
				Ganti PIN Akun Warga
			</h2>
			<nav class="flex items-center space-x-2 text-sm text-slate-400 font-medium mt-1">
				<a href="<?= site_url('layanan-mandiri/beranda') ?>" class="hover:text-amber-600 transition-colors text-decoration-none text-slate-400">Beranda</a>
				<span>&rsaquo;</span>
				<span class="text-slate-600 font-semibold">Ganti PIN</span>
			</nav>
		</div>
	</div>

	<!-- Right: Security Badge -->
	<div class="hidden sm:flex items-center space-x-2 bg-amber-50 border border-amber-200/70 text-amber-800 px-4 py-2 rounded-xl text-sm font-semibold">
		<i class="fa-solid fa-shield-halved text-amber-600"></i>
		<span>Keamanan Akun</span>
	</div>

</div>

<!-- ========================================================================
     MAIN CONTENT 2-COLUMN GRID (HARMONIZED WITH OTHER MODULES)
     ======================================================================== -->
<div class="grid grid-cols-1 lg:grid-cols-12 gap-6 mb-6">

	<!-- LEFT COLUMN: ACCOUNT SECURITY & GUIDELINES (5 COLS) -->
	<div class="lg:col-span-5 space-y-6">

		<!-- Card 1: Informasi Pemilik Akun -->
		<div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs p-6">
			<div class="flex items-center space-x-3 mb-4 pb-3 border-b border-slate-100">
				<div class="w-10 h-10 rounded-xl bg-amber-50 border border-amber-200/60 flex items-center justify-center text-amber-600 text-base">
					<i class="fa-solid fa-user-shield"></i>
				</div>
				<div>
					<h3 class="text-base font-bold font-display text-slate-900 leading-tight">Akun Pemohon</h3>
					<p class="text-xs text-slate-400">Identitas warga terdaftar</p>
				</div>
			</div>

			<div class="space-y-3 text-sm">
				<div class="flex justify-between items-center py-1 border-b border-slate-50">
					<span class="text-slate-500">Nama Lengkap</span>
					<span class="font-bold text-slate-800 text-right"><?= htmlspecialchars($this->is_login->nama ?? '-'); ?></span>
				</div>
				<div class="flex justify-between items-center py-1 border-b border-slate-50">
					<span class="text-slate-500">NIK</span>
					<span class="font-bold font-mono text-slate-800"><?= htmlspecialchars($this->is_login->nik ?? '-'); ?></span>
				</div>
				<div class="flex justify-between items-center py-1 border-b border-slate-50">
					<span class="text-slate-500">Notifikasi Telegram</span>
					<?php if ($tgl_verifikasi_telegram) : ?>
						<span class="inline-flex items-center text-emerald-700 bg-emerald-50 border border-emerald-200 px-2.5 py-0.5 rounded-full text-xs font-semibold">
							<i class="fa-solid fa-circle-check mr-1 text-emerald-600"></i> Terhubung
						</span>
					<?php else : ?>
						<span class="inline-flex items-center text-slate-500 bg-slate-100 px-2.5 py-0.5 rounded-full text-xs font-semibold">
							Belum Terhubung
						</span>
					<?php endif; ?>
				</div>
				<div class="flex justify-between items-center py-1">
					<span class="text-slate-500">Notifikasi Email</span>
					<?php if ($tgl_verifikasi_email) : ?>
						<span class="inline-flex items-center text-emerald-700 bg-emerald-50 border border-emerald-200 px-2.5 py-0.5 rounded-full text-xs font-semibold">
							<i class="fa-solid fa-circle-check mr-1 text-emerald-600"></i> Terhubung
						</span>
					<?php else : ?>
						<span class="inline-flex items-center text-slate-500 bg-slate-100 px-2.5 py-0.5 rounded-full text-xs font-semibold">
							Belum Terhubung
						</span>
					<?php endif; ?>
				</div>
			</div>

			<?php if (! $tgl_verifikasi_telegram || ! $tgl_verifikasi_email) : ?>
				<div class="mt-4 pt-3 border-t border-slate-100">
					<a href="<?= site_url('layanan-mandiri/verifikasi'); ?>" class="inline-flex items-center text-xs font-bold text-amber-600 hover:text-amber-700 transition-colors text-decoration-none">
						<i class="fa-solid fa-arrow-up-right-from-square mr-1.5"></i>
						<span>Hubungkan Email atau Telegram</span>
					</a>
				</div>
			<?php endif; ?>
		</div>

		<!-- Card 2: Panduan & Tips Keamanan -->
		<div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs p-6">
			<div class="flex items-center space-x-3 mb-4 pb-3 border-b border-slate-100">
				<div class="w-10 h-10 rounded-xl bg-slate-100 flex items-center justify-center text-slate-700 text-base">
					<i class="fa-solid fa-shield-halved text-amber-500"></i>
				</div>
				<div>
					<h3 class="text-base font-bold font-display text-slate-900 leading-tight">Panduan PIN Aman</h3>
					<p class="text-xs text-slate-400">Rekomendasi standar keamanan</p>
				</div>
			</div>

			<ul class="space-y-3 text-xs sm:text-sm text-slate-600">
				<li class="flex items-start space-x-2.5">
					<i class="fa-solid fa-circle-check text-emerald-500 mt-1 flex-shrink-0 text-xs"></i>
					<span>PIN wajib terdiri dari tepat <strong>6 digit angka</strong> (0-9).</span>
				</li>
				<li class="flex items-start space-x-2.5">
					<i class="fa-solid fa-circle-xmark text-rose-500 mt-1 flex-shrink-0 text-xs"></i>
					<span>Hindari urutan berulang seperti <code>123456</code> atau <code>111111</code>.</span>
				</li>
				<li class="flex items-start space-x-2.5">
					<i class="fa-solid fa-circle-xmark text-rose-500 mt-1 flex-shrink-0 text-xs"></i>
					<span>Hindari kombinasi yang mudah ditebak seperti tanggal lahir atau nomor HP.</span>
				</li>
				<li class="flex items-start space-x-2.5">
					<i class="fa-solid fa-lock text-amber-500 mt-1 flex-shrink-0 text-xs"></i>
					<span>Jaga kerahasiaan PIN dan jangan membagikannya kepada siapa pun.</span>
				</li>
			</ul>
		</div>

	</div>

	<!-- RIGHT COLUMN: GANTI PIN FORM (7 COLS) -->
	<div class="lg:col-span-7">
		<div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs p-6 sm:p-8">

			<!-- Form Header -->
			<div class="mb-6 pb-4 border-b border-slate-100">
				<h3 class="text-xl sm:text-2xl font-bold font-display text-slate-900 leading-tight">
					Formulir Perbarui PIN
				</h3>
				<p class="text-sm text-slate-500 mt-1">
					Masukkan PIN lama Anda untuk verifikasi, kemudian tentukan 6 digit PIN baru yang aman.
				</p>
			</div>

			<form action="<?= $form_action; ?>" method="POST" id="validasi" class="space-y-6">

				<!-- Notifikasi Session -->
				<?php $notif = session('notif'); ?>
				<?php if (! empty($notif)) : ?>
					<?php if ($notif['status'] == -1) : ?>
						<div class="p-4 rounded-xl bg-rose-50 border border-rose-200 text-rose-800 text-sm flex items-start space-x-3">
							<i class="fa-solid fa-triangle-exclamation text-rose-600 mt-0.5 text-base flex-shrink-0"></i>
							<div class="font-medium"><?= $notif['pesan']; ?></div>
						</div>
					<?php elseif ($notif['status'] == 1) : ?>
						<div class="p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm flex items-start space-x-3">
							<i class="fa-solid fa-circle-check text-emerald-600 mt-0.5 text-base flex-shrink-0"></i>
							<div class="font-medium"><?= $notif['pesan']; ?></div>
						</div>
					<?php endif; ?>
				<?php endif; ?>

				<!-- 1. PIN Lama -->
				<div>
					<label for="pin_lama" class="block text-sm font-bold uppercase tracking-wider text-slate-800 mb-2">
						PIN Lama Saat Ini <span class="text-rose-600">*</span>
					</label>
					<div class="relative flex items-center rounded-xl border border-slate-300 bg-white shadow-xs focus-within:ring-2 focus-within:ring-amber-500 focus-within:border-amber-500 transition-all overflow-hidden">
						<div class="pl-4 pr-3 text-slate-400 select-none">
							<i class="fa-solid fa-key text-base"></i>
						</div>
						<input 
							type="password" 
							class="w-full !border-0 !shadow-none !rounded-none py-3 pr-12 text-base font-mono tracking-widest text-slate-900 focus:outline-none focus:ring-0 bg-transparent required bilangan pin <?= jecho($cek_anjungan['keyboard'] == 1, true, 'kbvnumber'); ?>" 
							name="pin_lama" 
							id="pin_lama" 
							placeholder="••••••" 
							minlength="6" 
							maxlength="6" 
							inputmode="numeric"
							autocomplete="current-password"
							required
						>
						<button type="button" class="absolute right-0 inset-y-0 px-4 flex items-center text-slate-400 hover:text-slate-600 transition-colors focus:outline-none" onclick="togglePinVisibility('#pin_lama', this);" aria-label="Lihat PIN">
							<i class="fa-solid fa-eye-slash text-base"></i>
						</button>
					</div>
					<p class="text-xs text-slate-400 mt-1.5">Masukkan 6 digit kode PIN yang saat ini aktif digunakan.</p>
				</div>

				<!-- 2. PIN Baru -->
				<div>
					<div class="flex items-center justify-between mb-2">
						<label for="pin_baru1" class="block text-sm font-bold uppercase tracking-wider text-slate-800">
							PIN Baru (6 Digit) <span class="text-rose-600">*</span>
						</label>
						<span id="pin_baru1_counter" class="text-xs font-semibold text-slate-400 font-mono">0 / 6 digit</span>
					</div>
					<div class="relative flex items-center rounded-xl border border-slate-300 bg-white shadow-xs focus-within:ring-2 focus-within:ring-amber-500 focus-within:border-amber-500 transition-all overflow-hidden">
						<div class="pl-4 pr-3 text-slate-400 select-none">
							<i class="fa-solid fa-lock text-base"></i>
						</div>
						<input 
							type="password" 
							class="w-full !border-0 !shadow-none !rounded-none py-3 pr-12 text-base font-mono tracking-widest text-slate-900 focus:outline-none focus:ring-0 bg-transparent required bilangan pin <?= jecho($cek_anjungan['keyboard'] == 1, true, 'kbvnumber'); ?>" 
							name="pin_baru1" 
							id="pin_baru1" 
							placeholder="••••••" 
							minlength="6" 
							maxlength="6" 
							inputmode="numeric"
							autocomplete="new-password"
							required
						>
						<button type="button" class="absolute right-0 inset-y-0 px-4 flex items-center text-slate-400 hover:text-slate-600 transition-colors focus:outline-none" onclick="togglePinVisibility('#pin_baru1', this);" aria-label="Lihat PIN">
							<i class="fa-solid fa-eye-slash text-base"></i>
						</button>
					</div>
				</div>

				<!-- 3. Konfirmasi PIN Baru -->
				<div>
					<div class="flex items-center justify-between mb-2">
						<label for="pin_baru2" class="block text-sm font-bold uppercase tracking-wider text-slate-800">
							Konfirmasi PIN Baru <span class="text-rose-600">*</span>
						</label>
						<span id="pin_match_status" class="text-xs font-semibold hidden"></span>
					</div>
					<div class="relative flex items-center rounded-xl border border-slate-300 bg-white shadow-xs focus-within:ring-2 focus-within:ring-amber-500 focus-within:border-amber-500 transition-all overflow-hidden">
						<div class="pl-4 pr-3 text-slate-400 select-none">
							<i class="fa-solid fa-shield-halved text-base"></i>
						</div>
						<input 
							type="password" 
							class="w-full !border-0 !shadow-none !rounded-none py-3 pr-12 text-base font-mono tracking-widest text-slate-900 focus:outline-none focus:ring-0 bg-transparent required bilangan pin <?= jecho($cek_anjungan['keyboard'] == 1, true, 'kbvnumber'); ?>" 
							name="pin_baru2" 
							id="pin_baru2" 
							placeholder="••••••" 
							minlength="6" 
							maxlength="6" 
							inputmode="numeric"
							autocomplete="new-password"
							required
						>
						<button type="button" class="absolute right-0 inset-y-0 px-4 flex items-center text-slate-400 hover:text-slate-600 transition-colors focus:outline-none" onclick="togglePinVisibility('#pin_baru2', this);" aria-label="Lihat PIN">
							<i class="fa-solid fa-eye-slash text-base"></i>
						</button>
					</div>
				</div>

				<!-- Opsi Kirim Notifikasi PIN (Jika ada Telegram / Email) -->
				<?php if ($tgl_verifikasi_telegram || $tgl_verifikasi_email) : ?>
					<div class="p-5 rounded-2xl bg-slate-50 border border-slate-200/80 space-y-3">
						<span class="block text-xs font-bold uppercase tracking-wider text-slate-700">
							Kirim Bukti PIN Baru Melalui:
						</span>
						<div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
							<?php if ($tgl_verifikasi_email) : ?>
								<label class="flex items-center space-x-3 p-3.5 bg-white rounded-xl border border-slate-200 hover:border-amber-500 cursor-pointer transition-colors shadow-2xs">
									<input type="radio" value="kirim_email" id="kirim_email" name="pilihan_kirim" class="w-4 h-4 text-amber-600 focus:ring-amber-500" checked>
									<span class="text-xs sm:text-sm font-semibold text-slate-800">
										<i class="fa-solid fa-envelope mr-1.5 text-amber-500"></i> Email Terdaftar
									</span>
								</label>
							<?php endif; ?>

							<?php if ($tgl_verifikasi_telegram) : ?>
								<label class="flex items-center space-x-3 p-3.5 bg-white rounded-xl border border-slate-200 hover:border-amber-500 cursor-pointer transition-colors shadow-2xs">
									<input type="radio" value="kirim_telegram" id="kirim_telegram" name="pilihan_kirim" class="w-4 h-4 text-amber-600 focus:ring-amber-500" <?= (! $tgl_verifikasi_email) ? 'checked' : ''; ?>>
									<span class="text-xs sm:text-sm font-semibold text-slate-800">
										<i class="fa-brands fa-telegram mr-1.5 text-sky-500"></i> Telegram Terdaftar
									</span>
								</label>
							<?php endif; ?>
						</div>
					</div>
				<?php endif; ?>

				<!-- Footer Actions -->
				<div class="pt-5 border-t border-slate-100 flex flex-col sm:flex-row items-center justify-between gap-3">
					<button type="reset" id="btn-reset" class="w-full sm:w-auto px-6 py-3 rounded-xl border border-slate-300 hover:bg-slate-50 text-slate-700 text-sm font-bold transition-colors">
						<i class="fa-solid fa-rotate-left mr-1.5 text-xs"></i> Reset
					</button>
					<button type="submit" id="btn-submit" class="w-full sm:w-auto px-8 py-3 rounded-xl bg-amber-500 hover:bg-amber-600 active:bg-amber-700 text-white text-sm font-bold shadow-xs hover:shadow-md transition-all flex items-center justify-center space-x-2">
						<i class="fa-solid fa-check text-xs"></i>
						<span>Simpan PIN Baru</span>
					</button>
				</div>

			</form>

		</div>
	</div>

</div>

<!-- ========================================================================
     CLIENT-SIDE INTERACTIVE VALIDATION SCRIPTS
     ======================================================================== -->
<script>
	// Toggle Show / Hide Password
	function togglePinVisibility(targetSelector, btnElem) {
		var $input = $(targetSelector);
		var $icon = $(btnElem).find('i');
		if ($input.attr('type') === 'password') {
			$input.attr('type', 'text');
			$icon.removeClass('fa-eye-slash').addClass('fa-eye text-amber-500');
		} else {
			$input.attr('type', 'password');
			$icon.removeClass('fa-eye text-amber-500').addClass('fa-eye-slash');
		}
	}

	$(document).ready(function() {
		// Strict numeric input for all 3 fields
		$('#pin_lama, #pin_baru1, #pin_baru2').on('keypress', function(e) {
			var charCode = (e.which) ? e.which : e.keyCode;
			if (charCode > 31 && (charCode < 48 || charCode > 57)) {
				e.preventDefault();
				return false;
			}
			return true;
		});

		$('#pin_lama, #pin_baru1, #pin_baru2').on('input', function() {
			this.value = this.value.replace(/[^0-9]/g, '').slice(0, 6);
			checkPinMatch();
		});

		// Live PIN Match & Counter
		function checkPinMatch() {
			var p1 = $('#pin_baru1').val();
			var p2 = $('#pin_baru2').val();

			// Counter for pin_baru1
			var len = p1.length;
			$('#pin_baru1_counter').text(len + ' / 6 digit');
			if (len === 6) {
				$('#pin_baru1_counter').removeClass('text-slate-400 text-rose-500').addClass('text-emerald-600');
			} else {
				$('#pin_baru1_counter').removeClass('text-emerald-600').addClass('text-slate-400');
			}

			// Matching feedback for pin_baru2
			var $status = $('#pin_match_status');
			if (p2.length === 0) {
				$status.addClass('hidden').text('');
			} else if (p1 === p2 && p1.length === 6) {
				$status.removeClass('hidden text-rose-500').addClass('text-emerald-600').html('<i class="fa-solid fa-circle-check mr-1"></i> PIN Cocok');
			} else {
				$status.removeClass('hidden text-emerald-600').addClass('text-rose-500').html('<i class="fa-solid fa-circle-exclamation mr-1"></i> Belum Sesuai');
			}
		}

		$('#btn-reset').on('click', function() {
			setTimeout(function() {
				$('#pin_baru1_counter').text('0 / 6 digit').removeClass('text-emerald-600 text-rose-500').addClass('text-slate-400');
				$('#pin_match_status').addClass('hidden').text('');
			}, 50);
		});

		// Client side validation on submit
		$('#validasi').on('submit', function(e) {
			var pLama = $('#pin_lama').val();
			var p1 = $('#pin_baru1').val();
			var p2 = $('#pin_baru2').val();

			if (pLama.length !== 6) {
				alert('PIN Lama harus terdiri dari 6 digit angka.');
				$('#pin_lama').focus();
				e.preventDefault();
				return false;
			}
			if (p1.length !== 6) {
				alert('PIN Baru harus terdiri dari 6 digit angka.');
				$('#pin_baru1').focus();
				e.preventDefault();
				return false;
			}
			if (p1 !== p2) {
				alert('Konfirmasi PIN Baru tidak sesuai dengan PIN Baru.');
				$('#pin_baru2').focus();
				e.preventDefault();
				return false;
			}
			if (pLama === p1) {
				alert('PIN Baru tidak boleh sama dengan PIN Lama.');
				$('#pin_baru1').focus();
				e.preventDefault();
				return false;
			}
			return true;
		});
	});
</script>