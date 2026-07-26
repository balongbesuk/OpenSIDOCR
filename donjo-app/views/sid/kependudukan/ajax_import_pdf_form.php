<div class="modal-body">
	<form id="form_import_pdf" action="<?= site_url('keluarga/proses_import_pdf') ?>" method="POST" enctype="multipart/form-data" class="form-horizontal">
		<?php if ($this->config->config['csrf_protection']): ?>
			<input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>" />
		<?php endif; ?>
		<div class="form-group">
			<label for="kk_pdf" class="col-sm-3 control-label">File PDF Kartu Keluarga</label>
			<div class="col-sm-8">
				<input type="file" name="kk_pdf" id="kk_pdf" class="form-control input-sm" accept=".pdf" required>
				<p class="help-block"><i>Unggah file Kartu Keluarga elektronik (.pdf) terbitan Dukcapil/BSrE.</i></p>
			</div>
		</div>
		<div class="modal-footer">
			<button type="button" class="btn btn-default btn-sm" data-dismiss="modal"><i class="fa fa-times"></i> Batal</button>
			<button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-upload"></i> Unggah & Ekstrak Data</button>
		</div>
	</form>
</div>
