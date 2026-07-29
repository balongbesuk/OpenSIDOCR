<div class="modal-body">
	<div id="ocr_status_alert" class="alert alert-<?= $ocr_available ? 'success' : 'warning' ?>" style="margin-bottom: 15px;">
		<i class="fa fa-<?= $ocr_available ? 'check-circle' : 'exclamation-triangle' ?>"></i> 
		<strong>Status Engine OCR:</strong> <?= $ocr_available ? 'Ready (RapidOCR ONNX Engine Terpasang ✅)' : 'Engine Belum Terpasang di Server ⚠️' ?>
	</div>

	<?php if (! $ocr_available): ?>
		<div id="install_section" class="text-center" style="padding: 15px 10px; background: #fff8e1; border: 1px dashed #ffe082; border-radius: 5px; margin-bottom: 15px;">
			<p style="font-size: 14px; color: #5d4037;">Engine pembaca teks <strong>RapidOCR ONNX</strong> belum terdeteksi di server ini.</p>
			<p class="text-muted"><small>Karena fungsi PHP <code>exec()</code> aktif, Anda dapat memasang engine secara otomatis dengan 1-Klik di bawah ini:</small></p>
			<button type="button" id="btn_install_ocr" class="btn btn-primary btn-md" onclick="doInstallOcr()">
				<i class="fa fa-download"></i> Install Engine RapidOCR Sekarang (1-Click)
			</button>
			<div id="install_loading" style="display:none; margin-top: 15px;">
				<i class="fa fa-spinner fa-spin fa-2x text-primary"></i>
				<p style="margin-top:8px; font-weight: 500;">Sedang mengunduh & meng-install RapidOCR ONNX Engine di server...<br><small class="text-muted">Proses ini memakan waktu sekitar 10-30 detik. Mohon jangan tutup jendela ini.</small></p>
			</div>
		</div>

		<script>
		function doInstallOcr() {
			if (!confirm('Apakah Anda ingin meng-install RapidOCR ONNX Engine di server sekarang?')) return;
			$('#btn_install_ocr').prop('disabled', true).hide();
			$('#install_loading').show();
			$.ajax({
				url: '<?= site_url('keluarga/ajax_install_ocr') ?>',
				type: 'POST',
				dataType: 'json',
				success: function(res) {
					if (res.status) {
						alert(res.message);
						$('#modalBox').load('<?= site_url('keluarga/dialog_import_scan_kk') ?>');
					} else {
						alert(res.message);
						$('#btn_install_ocr').prop('disabled', false).show();
						$('#install_loading').hide();
					}
				},
				error: function(xhr, status, error) {
					alert('Terjadi kesalahan koneksi server: ' + error);
					$('#btn_install_ocr').prop('disabled', false).show();
					$('#install_loading').hide();
				}
			});
		}
		</script>
	<?php endif; ?>

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
