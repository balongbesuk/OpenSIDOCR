<div class="modal-body">
	<form id="form_import_scan" action="<?= site_url('keluarga/proses_import_scan_kk') ?>" method="POST" enctype="multipart/form-data" class="form-horizontal">
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
