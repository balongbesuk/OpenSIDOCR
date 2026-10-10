<?php
$info      = $ocr_info ?? ['is_available' => $ocr_available, 'has_new' => false, 'has_old' => $ocr_available, 'has_opencv' => false, 'is_latest' => false];
$is_latest = ! empty($info['is_latest']);
?>
<div class="modal-body">
	<div id="ocr_status_alert" class="alert alert-<?= $ocr_available ? ($is_latest ? 'success' : 'info') : 'warning' ?>" style="margin-bottom: 15px;">
		<div class="row">
			<div class="col-sm-8">
				<i class="fa fa-<?= $ocr_available ? 'check-circle' : 'exclamation-triangle' ?>"></i> 
				<strong>Status Engine OCR:</strong> 
				<?php if (! $ocr_available): ?>
					Engine Belum Terpasang di Server ⚠️
				<?php elseif ($is_latest): ?>
					Ready (RapidOCR PP-OCRv4 + OpenCV Preprocessing ✅)
				<?php else: ?>
					Ready (RapidOCR ONNX Versi Lama Aktif ⚠️)
				<?php endif; ?>
			</div>
			<div class="col-sm-4 text-right">
				<?php if ($ocr_available && ! $is_latest): ?>
					<button type="button" id="btn_upgrade_ocr" class="btn btn-xs btn-warning" onclick="doInstallOcr(true)" title="Upgrade ke model PP-OCRv4 terbaru dan aktifkan pelurus foto otomatis (OpenCV)">
						<i class="fa fa-arrow-circle-up"></i> Upgrade ke PP-OCRv4 & OpenCV
					</button>
				<?php elseif ($ocr_available && $is_latest): ?>
					<button type="button" class="btn btn-xs btn-link text-success" onclick="doInstallOcr(false)" style="padding:0; text-decoration:none;" title="Perbarui paket jika ada versi baru">
						<small><i class="fa fa-refresh"></i> Cek Update</small>
					</button>
				<?php endif; ?>
			</div>
		</div>
		<?php if ($ocr_available && ! $is_latest): ?>
			<div style="margin-top: 8px; font-size: 12px; border-top: 1px dashed #bce8f1; padding-top: 6px;">
				<i class="fa fa-info-circle"></i> <em>Sistem mendeteksi engine versi lama. Anda tetap bisa langsung scan foto KK sekarang, atau klik tombol <strong>Upgrade</strong> di atas untuk mengaktifkan koreksi foto miring & akurasi PP-OCRv4 terbaru (1-Click).</em>
			</div>
		<?php endif; ?>
	</div>

	<?php if (! $ocr_available): ?>
		<div id="install_section" class="text-center" style="padding: 15px 10px; background: #fff8e1; border: 1px dashed #ffe082; border-radius: 5px; margin-bottom: 15px;">
			<p style="font-size: 14px; color: #5d4037;">Engine pembaca teks <strong>RapidOCR ONNX</strong> belum terdeteksi di server ini.</p>
			<p class="text-muted"><small>Karena fungsi PHP <code>exec()</code> aktif, Anda dapat memasang engine secara otomatis dengan 1-Klik di bawah ini:</small></p>
			<button type="button" id="btn_install_ocr" class="btn btn-primary btn-md" onclick="doInstallOcr(false)">
				<i class="fa fa-download"></i> Install Engine RapidOCR Sekarang (1-Click)
			</button>
		</div>
	<?php endif; ?>

	<div id="install_loading" style="display:none; margin-bottom: 15px; padding: 15px; background: #f0f7fd; border: 1px solid #d0e4f7; border-radius: 5px; text-align: center;">
		<i class="fa fa-spinner fa-spin fa-2x text-primary"></i>
		<p style="margin-top:8px; font-weight: 500; color: #1e3a8a;">
			<span id="loading_text">Sedang mengunduh & memperbarui RapidOCR PP-OCRv4 dan OpenCV Preprocessing di server...</span><br>
			<small class="text-muted">Proses ini memakan waktu sekitar 15-40 detik melalui jaringan internet server. Mohon jangan tutup jendela ini.</small>
		</p>
	</div>

	<script>
	function doInstallOcr(isUpgrade) {
		var confirmMsg = isUpgrade 
			? 'Apakah Anda ingin meng-upgrade RapidOCR ke PP-OCRv4 dan memasang OpenCV Preprocessing di server sekarang?' 
			: 'Apakah Anda ingin meng-install RapidOCR ONNX Engine di server sekarang?';
		if (!confirm(confirmMsg)) return;

		$('#btn_install_ocr, #btn_upgrade_ocr').prop('disabled', true).hide();
		if (isUpgrade) {
			$('#loading_text').text('Sedang meng-upgrade RapidOCR ke PP-OCRv4 & modul OpenCV Preprocessing di server...');
		}
		$('#install_loading').show();

		$.ajax({
			url: '<?= site_url('keluarga/ajax_install_ocr') ?>',
			type: 'POST',
			dataType: 'json',
			success: function(res) {
				alert(res.message);
				if (res.status) {
					$('#modalBox').load('<?= site_url('keluarga/dialog_import_scan_kk') ?>');
				} else {
					$('#btn_install_ocr, #btn_upgrade_ocr').prop('disabled', false).show();
					$('#install_loading').hide();
				}
			},
			error: function(xhr, status, error) {
				alert('Terjadi kesalahan koneksi server: ' + error);
				$('#btn_install_ocr, #btn_upgrade_ocr').prop('disabled', false).show();
				$('#install_loading').hide();
			}
		});
	}
	</script>

	<form id="form_import_scan" action="<?= site_url('keluarga/proses_import_scan_kk') ?>" method="POST" enctype="multipart/form-data" class="form-horizontal" <?= ! $ocr_available ? 'style="display:none;"' : '' ?>>
		<?php if ($this->config->config['csrf_protection']): ?>
			<input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>" />
		<?php endif; ?>
		<div class="form-group">
			<label for="kk_scan" class="col-sm-3 control-label">File Foto / Scan KK</label>
			<div class="col-sm-8">
				<input type="file" name="kk_scan" id="kk_scan" class="form-control input-sm" accept=".jpg,.jpeg,.png,.pdf" required>
				<p class="help-block"><i>Unggah hasil scan / foto fotokopi Kartu Keluarga (.jpg, .jpeg, .png, .pdf). Sistem akan membaca teks dokumen menggunakan RapidOCR ONNX Engine.</i></p>
			</div>
		</div>
		<div class="modal-footer">
			<button type="button" class="btn btn-default btn-sm" data-dismiss="modal"><i class="fa fa-times"></i> Batal</button>
			<button type="submit" class="btn btn-success btn-sm"><i class="fa fa-magic"></i> Unggah & Scan OCR</button>
		</div>
	</form>
</div>
