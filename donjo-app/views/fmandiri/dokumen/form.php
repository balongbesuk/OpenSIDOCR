<?php

defined('BASEPATH') || exit('No direct script access allowed');

/*
 * File ini:
 *
 * View modul Layanan Mandiri > Form Dokumen (Upload / Ubah Berkas)
 * Redesigned with Next-Gen UI/UX Pro Max & Full Security Hardening (Tema Desa Balongbesuk)
 *
 * donjo-app/views/fmandiri/dokumen/form.php
 */
?>

<!-- ========================================================================
     PAGE TITLE & BREADCRUMB CARD
     ======================================================================== -->
<div class="relative bg-white rounded-2xl border border-slate-200/80 p-5 sm:p-6 mb-6 shadow-xs overflow-hidden flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
	
	<!-- Left: Big Teal Icon + Title & Breadcrumb -->
	<div class="flex items-center space-x-4 z-10">
		<div class="w-12 h-12 sm:w-14 sm:h-14 rounded-2xl bg-teal-600 text-white flex items-center justify-center text-xl sm:text-2xl shadow-sm flex-shrink-0">
			<i class="fa-solid fa-file-arrow-up"></i>
		</div>
		<div>
			<h2 class="text-2xl sm:text-3xl font-extrabold font-display text-slate-900 leading-tight">
				<?= $aksi ?> Dokumen
			</h2>
			<nav class="flex items-center space-x-2 text-sm text-slate-400 font-medium mt-1">
				<a href="<?= site_url('layanan-mandiri/beranda') ?>" class="hover:text-teal-600 transition-colors text-decoration-none text-slate-400">Beranda</a>
				<span>&rsaquo;</span>
				<a href="<?= site_url('layanan-mandiri/dokumen') ?>" class="hover:text-teal-600 transition-colors text-decoration-none text-slate-400">Dokumen</a>
				<span>&rsaquo;</span>
				<span class="text-slate-600 font-semibold"><?= $aksi ?></span>
			</nav>
		</div>
	</div>

	<!-- Right: Kembali Action Button -->
	<div class="flex items-center space-x-2.5">
		<a href="<?= site_url('layanan-mandiri/dokumen'); ?>" class="px-5 py-2.5 rounded-xl border border-slate-300 text-slate-700 hover:bg-slate-50 font-semibold text-sm sm:text-base shadow-xs transition-colors flex items-center space-x-2 text-decoration-none">
			<i class="fa-solid fa-arrow-left text-sm"></i>
			<span>Kembali ke Daftar</span>
		</a>
	</div>

</div>

<!-- ========================================================================
     FORM CARD CONTAINER
     ======================================================================== -->
<div class="max-w-3xl bg-white rounded-2xl border border-slate-200/80 shadow-xs p-6 sm:p-8 mb-6">
	
	<?php $this->load->view('fmandiri/notifikasi') ?>

	<!-- Alert Peringatan Form Client-side -->
	<div id="alert_form_error" class="hidden mb-6 p-4 rounded-xl bg-rose-50 border border-rose-200 text-rose-800 text-sm sm:text-base flex items-start space-x-3">
		<i class="fa-solid fa-circle-exclamation text-rose-600 mt-0.5 text-lg flex-shrink-0"></i>
		<div id="alert_form_error_msg" class="font-medium">Mohon lengkapi isian form yang wajib diisi.</div>
	</div>

	<form id="form_dokumen" action="<?= $form_action ?>" method="POST" enctype="multipart/form-data" class="space-y-6" novalidate>
		<!-- CSRF Token -->
		<input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
		<input type="hidden" name="id_pend" value="<?= $this->is_login->id_pend ?>" />
		<input type="hidden" name="old_file" value="<?= $dokumen['satuan'] ?? '' ?>" />
		
		<!-- 1. Nama Dokumen -->
		<div class="space-y-1.5">
			<label for="nama_dokumen" class="block text-sm sm:text-base font-bold text-slate-800">
				Nama Dokumen <span class="text-rose-600">*</span>
			</label>
			<input 
				id="nama_dokumen" 
				name="nama" 
				class="w-full rounded-xl border border-slate-300 px-4 py-3.5 text-base text-slate-900 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition-all shadow-xs <?= jecho($cek_anjungan['keyboard'] == 1, true, 'kbvtext'); ?>" 
				type="text" 
				placeholder="Contoh: KTP Elektronik Asli / Kartu Keluarga / Akta Kelahiran" 
				value="<?= htmlspecialchars($dokumen['nama'] ?? '') ?>" 
				required
			/>
			<p id="err_nama" class="hidden text-xs sm:text-sm text-rose-600 font-semibold mt-1">Nama dokumen wajib diisi (minimal 3 karakter).</p>
			<p class="text-xs text-slate-400">Tuliskan nama dokumen secara jelas untuk mempermudah identifikasi berkas.</p>
		</div>

		<!-- 2. Jenis Dokumen -->
		<div class="space-y-1.5">
			<label for="id_syarat" class="block text-sm sm:text-base font-bold text-slate-800">
				Jenis Dokumen <span class="text-rose-600">*</span>
			</label>
			<select class="w-full rounded-xl border border-slate-300 px-4 py-3.5 text-base text-slate-900 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition-all shadow-xs bg-white" name="id_syarat" id="id_syarat" required>
				<option value=""> -- Pilih Jenis Dokumen -- </option>
				<?php foreach ($jenis_syarat_surat as $data) : ?>
					<option value="<?= $data['ref_syarat_id'] ?>" <?= selected($data['ref_syarat_id'], $dokumen['id_syarat'] ?? '') ?>><?= $data['ref_syarat_nama']; ?></option>
				<?php endforeach; ?>
			</select>
			<p id="err_syarat" class="hidden text-xs sm:text-sm text-rose-600 font-semibold mt-1">Silakan pilih jenis dokumen persyaratan.</p>
		</div>

		<!-- 3. Berkas File Dokumen -->
		<div class="space-y-2">
			<label class="block text-sm sm:text-base font-bold text-slate-800">
				Berkas File Dokumen <?= empty($dokumen['id']) ? '<span class="text-rose-600">*</span>' : '' ?>
			</label>
			
			<!-- Input File Tersembunyi -->
			<input type="file" class="hidden" id="file" name="satuan" accept=".jpg,.jpeg,.png,.pdf,image/jpeg,image/png,application/pdf" />

			<!-- Kotak Pratinjau / Input Baris Berkas -->
			<div id="drop_area_berkas" class="border-2 border-dashed border-slate-300 hover:border-teal-500 rounded-2xl p-5 bg-slate-50/70 hover:bg-teal-50/20 transition-all cursor-pointer">
				
				<!-- State 1: Belum Ada File / Mode Edit File Lama -->
				<div id="file_empty_state" class="flex flex-col sm:flex-row items-center justify-between gap-4 <?= !empty($dokumen['satuan']) ? 'hidden' : '' ?>">
					<div class="flex items-center space-x-3.5 text-center sm:text-left">
						<div class="w-12 h-12 rounded-xl bg-teal-100 text-teal-700 flex items-center justify-center text-xl flex-shrink-0">
							<i class="fa-solid fa-cloud-arrow-up"></i>
						</div>
						<div>
							<h4 class="text-sm sm:text-base font-bold text-slate-800">Klik untuk Memilih Berkas</h4>
							<p class="text-xs text-slate-400 mt-0.5">Mendukung format JPG, PNG, atau PDF (Maks. <?= max_upload() ?> MB)</p>
						</div>
					</div>

					<div class="flex items-center space-x-2">
						<button type="button" class="btn_trigger_modal px-4 py-2.5 rounded-xl bg-slate-800 hover:bg-slate-900 text-white font-bold text-sm flex items-center space-x-2 shadow-xs transition-colors">
							<i class="fa-solid fa-folder-open text-xs"></i>
							<span>Pilih Berkas</span>
						</button>
						<button type="button" class="px-3.5 py-2.5 rounded-xl bg-rose-600 hover:bg-rose-700 text-white font-bold text-sm flex items-center space-x-1.5 shadow-xs transition-colors" onclick="kamera();" title="Ambil Foto dengan Kamera">
							<i class="fa-solid fa-camera text-xs"></i>
							<span class="hidden sm:inline">Kamera</span>
						</button>
					</div>
				</div>

				<!-- State 2: Berkas Telah Dipilih / Berkas Eksisting -->
				<div id="file_selected_state" class="<?= empty($dokumen['satuan']) ? 'hidden' : '' ?> flex items-center justify-between gap-4">
					<div class="flex items-center space-x-3.5 overflow-hidden">
						<div id="file_icon_badge" class="w-12 h-12 rounded-xl bg-emerald-100 text-emerald-700 flex items-center justify-center text-xl flex-shrink-0">
							<i class="fa-solid fa-file-circle-check"></i>
						</div>
						<div class="overflow-hidden">
							<h4 id="file_name_display" class="text-sm sm:text-base font-bold text-slate-900 truncate">
								<?= htmlspecialchars($dokumen['satuan'] ?? 'Berkas Terpilih') ?>
							</h4>
							<div class="flex items-center space-x-2 text-xs text-slate-500 mt-0.5">
								<span id="file_size_display" class="font-medium text-emerald-600"><?= !empty($dokumen['satuan']) ? 'Berkas Tersimpan' : '' ?></span>
								<span>&bull;</span>
								<span class="text-emerald-700 font-semibold bg-emerald-50 px-2 py-0.5 rounded-md">Siap Diunggah</span>
							</div>
						</div>
					</div>

					<div class="flex items-center space-x-2 flex-shrink-0">
						<button type="button" class="btn_trigger_modal px-3.5 py-2 rounded-xl border border-slate-300 hover:bg-white text-slate-700 font-bold text-xs sm:text-sm transition-colors">
							Ganti
						</button>
						<button type="button" id="btn_hapus_pilihan" class="px-3 py-2 rounded-xl bg-rose-50 hover:bg-rose-100 text-rose-600 font-bold text-xs sm:text-sm transition-colors" title="Batal Pilih Berkas">
							<i class="fa-solid fa-trash-can"></i>
						</button>
					</div>
				</div>

			</div>

			<!-- Input text display untuk kompatibilitas kamera -->
			<input type="hidden" id="file_path" name="satuan_kamera" value="" />

			<p id="err_berkas" class="hidden text-xs sm:text-sm text-rose-600 font-semibold mt-1">Berkas dokumen wajib diunggah.</p>
			
			<p class="text-xs sm:text-sm text-slate-400 mt-2">
				<?= !empty($dokumen['id']) ? 'Biarkan kosong jika Anda tidak ingin mengganti berkas yang sudah ada sebelumnya.' : 'Pastikan berkas dokumen jelas, terbaca, dan tidak buram.' ?>
			</p>
		</div>

		<!-- 4. Anggota Keluarga yang berlaku sama -->
		<?php if (! empty($kk)) : ?>
			<div class="p-5 bg-slate-50 rounded-2xl border border-slate-200 space-y-3">
				<span class="block text-sm font-bold text-slate-800">
					Dokumen Berlaku untuk Anggota Keluarga:
				</span>
				<p class="text-xs sm:text-sm text-slate-500">
					Centang anggota keluarga yang memiliki berkas dokumen yang sama (misal: Kartu Keluarga).
				</p>
				<div class="space-y-2 pt-1">
					<?php foreach ($kk as $item) : ?>
						<?php if ($item['nik'] != $this->is_login->nik) : ?>
							<label class="flex items-center space-x-3 p-3 bg-white rounded-xl border border-slate-200 hover:border-teal-500 cursor-pointer transition-colors">
								<input type="checkbox" name="anggota_kk[]" value="<?= $item['id'] ?>" class="w-4 h-4 text-teal-600 rounded focus:ring-teal-500" <?= jecho(in_array($item['id'], $anggota ?? []), true, 'checked') ?>>
								<span class="text-sm sm:text-base text-slate-800 font-medium">
									<strong class="font-bold"><?= $item['nama'] ?></strong> (NIK: <?= $item['nik'] ?>)
								</span>
							</label>
						<?php endif; ?>
					<?php endforeach; ?>
				</div>
			</div>
		<?php endif ?>

		<!-- Form Submit Actions -->
		<div class="pt-4 border-t border-slate-200 flex items-center justify-between gap-4">
			<a href="<?= site_url('layanan-mandiri/dokumen'); ?>" class="px-6 py-3.5 rounded-xl border border-slate-300 text-slate-700 hover:bg-slate-50 font-bold text-sm sm:text-base transition-colors text-decoration-none">
				Batal
			</a>
			
			<button type="submit" id="btn_submit_dokumen" class="px-8 py-3.5 rounded-xl bg-teal-600 hover:bg-teal-700 text-white font-bold text-sm sm:text-base shadow-md shadow-teal-600/20 transition-all flex items-center space-x-2 cursor-pointer">
				<i class="fa-solid fa-check text-sm"></i>
				<span>Simpan Dokumen</span>
			</button>
		</div>

	</form>

</div>

<!-- ========================================================================
     MODAL PILIH SUMBER BERKAS (POP-UP UPLOAD DIALOG)
     ======================================================================== -->
<div class="modal fade" id="modal-pilih-berkas" tabindex="-1" role="dialog" aria-labelledby="modalPilihBerkasLabel">
	<div class="modal-dialog modal-dialog-centered" style="max-width: 480px;">
		<div class="modal-content rounded-3xl border-0 shadow-2xl overflow-hidden">
			
			<!-- Modal Header -->
			<div class="p-5 sm:p-6 bg-slate-900 text-white flex items-center justify-between">
				<div class="flex items-center space-x-3">
					<div class="w-10 h-10 rounded-xl bg-teal-500/20 text-teal-400 flex items-center justify-center text-lg">
						<i class="fa-solid fa-folder-open"></i>
					</div>
					<div>
						<h4 class="modal-title font-bold text-base sm:text-lg text-white" id="modalPilihBerkasLabel">
							Pilih Berkas Dokumen
						</h4>
						<p class="text-xs text-slate-400">Pilih metode pengambilan berkas</p>
					</div>
				</div>
				<button type="button" class="text-slate-400 hover:text-white transition-colors text-2xl font-bold p-1" data-dismiss="modal" aria-label="Tutup">
					&times;
				</button>
			</div>

			<!-- Modal Body (Pilihan Sumber) -->
			<div class="p-6 space-y-3 bg-white">
				
				<!-- Opsi 1: Dari Perangkat -->
				<button type="button" id="btn_modal_pilih_file" class="w-full p-4 rounded-2xl border-2 border-slate-200 hover:border-teal-500 hover:bg-teal-50/30 flex items-center space-x-4 text-left transition-all group">
					<div class="w-12 h-12 rounded-xl bg-teal-100 text-teal-600 flex items-center justify-center text-xl flex-shrink-0 group-hover:scale-105 transition-transform">
						<i class="fa-solid fa-laptop-file"></i>
					</div>
					<div class="flex-1">
						<h5 class="text-sm sm:text-base font-bold text-slate-800 group-hover:text-teal-700">Pilih dari Penyimpanan Perangkat</h5>
						<p class="text-xs text-slate-400 mt-0.5">Unggah berkas format PDF, JPG, atau PNG</p>
					</div>
					<i class="fa-solid fa-chevron-right text-slate-300 group-hover:text-teal-500 transition-colors"></i>
				</button>

				<!-- Opsi 2: Dari Kamera -->
				<button type="button" id="btn_modal_buka_kamera" class="w-full p-4 rounded-2xl border-2 border-slate-200 hover:border-rose-500 hover:bg-rose-50/30 flex items-center space-x-4 text-left transition-all group">
					<div class="w-12 h-12 rounded-xl bg-rose-100 text-rose-600 flex items-center justify-center text-xl flex-shrink-0 group-hover:scale-105 transition-transform">
						<i class="fa-solid fa-camera"></i>
					</div>
					<div class="flex-1">
						<h5 class="text-sm sm:text-base font-bold text-slate-800 group-hover:text-rose-700">Ambil Foto dengan Kamera</h5>
						<p class="text-xs text-slate-400 mt-0.5">Nyalakan kamera/webcam untuk memotret fisik dokumen</p>
					</div>
					<i class="fa-solid fa-chevron-right text-slate-300 group-hover:text-rose-500 transition-colors"></i>
				</button>

			</div>

			<!-- Modal Footer -->
			<div class="p-4 bg-slate-50 border-t border-slate-100 flex justify-end">
				<button type="button" class="px-5 py-2 rounded-xl bg-slate-200 hover:bg-slate-300 text-slate-700 font-semibold text-xs sm:text-sm transition-colors" data-dismiss="modal">
					Tutup
				</button>
			</div>

		</div>
	</div>
</div>

<!-- Modal Kamera bawaan OpenSID -->
<?php $this->load->view('global/capture') ?>

<!-- ========================================================================
     JAVASCRIPT LOGIC: FILE UPLOAD, MODAL PICKER & CLIENT VERIFICATION
     ======================================================================== -->
<script>
$(document).ready(function() {
	const maxUploadMb = <?= (int) max_upload() ?>;
	const isEditMode = <?= !empty($dokumen['id']) ? 'true' : 'false' ?>;

	// 1. Tampilkan Modal Saat Tombol Pilih Berkas atau Area Dropzone Diklik
	$('.btn_trigger_modal').on('click', function(e) {
		e.preventDefault();
		e.stopPropagation();
		$('#modal-pilih-berkas').modal('show');
	});

	$('#drop_area_berkas').on('click', function(e) {
		// Jangan picu jika sedang mengklik tombol hapus
		if ($(e.target).closest('#btn_hapus_pilihan').length) return;
		$('#modal-pilih-berkas').modal('show');
	});

	// 2. Klik Dari Modal -> Trigger File Dialog Native
	$('#btn_modal_pilih_file').on('click', function(e) {
		e.preventDefault();
		$('#modal-pilih-berkas').modal('hide');
		setTimeout(function() {
			$('#file').trigger('click');
		}, 300);
	});

	// 3. Klik Dari Modal -> Trigger Kamera
	$('#btn_modal_buka_kamera').on('click', function(e) {
		e.preventDefault();
		$('#modal-pilih-berkas').modal('hide');
		setTimeout(function() {
			kamera();
		}, 300);
	});

	// 4. Ketika Berkas Dipilih dari Dialog File
	$('#file').on('change', function() {
		if (this.files && this.files[0]) {
			const file = this.files[0];
			const fileName = file.name;
			const fileSize = file.size;
			const fileExt = fileName.split('.').pop().toLowerCase();
			const allowedExts = ['jpg', 'jpeg', 'png', 'pdf'];

			// Validasi Ekstensi
			if ($.inArray(fileExt, allowedExts) === -1) {
				showFormError('Format berkas tidak didukung! Hanya file JPG, PNG, dan PDF yang diperbolehkan.');
				resetFileInput();
				return;
			}

			// Validasi Ukuran (MB)
			if (fileSize > (maxUploadMb * 1024 * 1024)) {
				showFormError('Ukuran berkas terlalu besar! Maksimal ' + maxUploadMb + ' MB.');
				resetFileInput();
				return;
			}

			// Format Tampilan Ukuran File
			let sizeFormatted = (fileSize / 1024).toFixed(1) + ' KB';
			if (fileSize > 1024 * 1024) {
				sizeFormatted = (fileSize / (1024 * 1024)).toFixed(2) + ' MB';
			}

			// Update UI Preview
			$('#file_name_display').text(fileName);
			$('#file_size_display').text(sizeFormatted);
			
			// Icon berdasarkan ekstensi
			if (fileExt === 'pdf') {
				$('#file_icon_badge').html('<i class="fa-solid fa-file-pdf text-rose-600"></i>').removeClass('bg-emerald-100').addClass('bg-rose-100');
			} else {
				$('#file_icon_badge').html('<i class="fa-solid fa-file-image text-emerald-600"></i>').removeClass('bg-rose-100').addClass('bg-emerald-100');
			}

			$('#file_empty_state').addClass('hidden');
			$('#file_selected_state').removeClass('hidden');
			$('#err_berkas').addClass('hidden');
			$('#alert_form_error').addClass('hidden');
			$('#file_path').val(''); // Reset kamera base64 jika memilih file
		}
	});

	// 5. Tombol Hapus Pilihan Berkas
	$('#btn_hapus_pilihan').on('click', function(e) {
		e.preventDefault();
		e.stopPropagation();
		resetFileInput();
	});

	function resetFileInput() {
		$('#file').val('');
		$('#file_path').val('');
		$('#file_name_display').text('');
		$('#file_size_display').text('');
		$('#file_selected_state').addClass('hidden');
		$('#file_empty_state').removeClass('hidden');
	}

	// 6. Integrasi dengan Hasil Crop Kamera
	$(document).on('click', '#simpan-gambar', function() {
		// Ketika kamera menyimpan gambar, nilai base64 ada di #file_path
		setTimeout(function() {
			const cameraData = $('#file_path').val();
			if (cameraData && cameraData.startsWith('data:image')) {
				$('#file_name_display').text('Foto Kamera (Webcam-Capture.jpg)');
				$('#file_size_display').text('Gambar Kamera');
				$('#file_icon_badge').html('<i class="fa-solid fa-camera text-teal-600"></i>').removeClass('bg-rose-100').addClass('bg-teal-100');
				$('#file_empty_state').addClass('hidden');
				$('#file_selected_state').removeClass('hidden');
				$('#err_berkas').addClass('hidden');
				$('#file').val(''); // Bersihkan input file fisik
			}
		}, 300);
	});

	// 7. Verifikasi Form Sebelum Submit (Client-Side Defense)
	$('#form_dokumen').on('submit', function(e) {
		let isValid = true;
		let firstErrorEl = null;

		// Sembunyikan alert error lama
		$('#alert_form_error').addClass('hidden');
		$('#err_nama').addClass('hidden');
		$('#err_syarat').addClass('hidden');
		$('#err_berkas').addClass('hidden');
		$('#nama_dokumen').removeClass('border-rose-500 ring-2 ring-rose-500/20');
		$('#id_syarat').removeClass('border-rose-500 ring-2 ring-rose-500/20');
		$('#drop_area_berkas').removeClass('border-rose-500 bg-rose-50/30');

		// A. Validasi Nama Dokumen
		const namaVal = $.trim($('#nama_dokumen').val());
		if (!namaVal || namaVal.length < 3) {
			$('#nama_dokumen').addClass('border-rose-500 ring-2 ring-rose-500/20');
			$('#err_nama').removeClass('hidden');
			isValid = false;
			if (!firstErrorEl) firstErrorEl = $('#nama_dokumen');
		}

		// B. Validasi Jenis Dokumen
		const syaratVal = $('#id_syarat').val();
		if (!syaratVal) {
			$('#id_syarat').addClass('border-rose-500 ring-2 ring-rose-500/20');
			$('#err_syarat').removeClass('hidden');
			isValid = false;
			if (!firstErrorEl) firstErrorEl = $('#id_syarat');
		}

		// C. Validasi Berkas (Wajib jika mode Tambah)
		const hasFile = $('#file')[0].files && $('#file')[0].files.length > 0;
		const hasCamera = $('#file_path').val() && $('#file_path').val().startsWith('data:image');
		const hasOldFile = $('input[name="old_file"]').val();

		if (!isEditMode && !hasFile && !hasCamera) {
			$('#drop_area_berkas').addClass('border-rose-500 bg-rose-50/30');
			$('#err_berkas').removeClass('hidden');
			isValid = false;
			if (!firstErrorEl) firstErrorEl = $('#drop_area_berkas');
		}

		// Jika Tidak Valid, Cegah Simpan & Berikan Peringatan
		if (!isValid) {
			e.preventDefault();
			showFormError('Mohon periksa kembali form Anda. Pastikan nama dokumen diisi, jenis dokumen dipilih, dan berkas telah diunggah.');
			if (firstErrorEl) {
				$('html, body').animate({
					scrollTop: firstErrorEl.offset().top - 120
				}, 400);
				if (firstErrorEl.is('input, select')) {
					firstErrorEl.focus();
				}
			}
			return false;
		}

		// Disable tombol submit untuk mencegah double submit
		$('#btn_submit_dokumen').prop('disabled', true).html('<i class="fa-solid fa-spinner fa-spin text-sm"></i> <span>Menyimpan...</span>');
	});

	function showFormError(msg) {
		$('#alert_form_error_msg').text(msg);
		$('#alert_form_error').removeClass('hidden');
	}
});
</script>