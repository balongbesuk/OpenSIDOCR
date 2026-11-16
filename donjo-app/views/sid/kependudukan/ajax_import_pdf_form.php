<div class="modal-body">
	<form id="form_import_pdf" action="<?= site_url('keluarga/proses_import_pdf') ?>" method="POST" enctype="multipart/form-data" class="form-horizontal">
		<?php if ($this->config->config['csrf_protection']): ?>
			<input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>" />
		<?php endif; ?>
		<div class="form-group">
			<label for="file_path_pdf" class="col-sm-3 control-label">File PDF Kartu Keluarga</label>
			<div class="col-sm-8">
				<div class="input-group input-group-sm">
					<input type="text" class="form-control" id="file_path_pdf" placeholder="Pilih berkas PDF..." readonly style="background-color: #fff; cursor: pointer;">
					<input type="file" class="hidden" name="kk_pdf" id="kk_pdf" accept=".pdf">
					<span class="input-group-btn">
						<button type="button" class="btn btn-info btn-flat" id="file_browser_pdf"><i class="fa fa-folder-open"></i> Browse</button>
					</span>
				</div>
				<p class="help-block text-muted" style="margin-top: 6px;"><i>Unggah file Kartu Keluarga elektronik (.pdf) terbitan Dukcapil/BSrE.</i></p>
			</div>
		</div>
		<div class="modal-footer">
			<button type="button" class="btn btn-social btn-flat btn-danger btn-sm" data-dismiss="modal"><i class="fa fa-times"></i> Batal</button>
			<button type="submit" class="btn btn-social btn-flat btn-info btn-sm pull-right" id="ok"><i class="fa fa-upload"></i> Unggah & Ekstrak Data</button>
		</div>
	</form>
</div>
<script type="text/javascript">
	$('#file_browser_pdf, #file_path_pdf').on('click', function() {
		$('#kk_pdf').trigger('click');
	});
	$('#kk_pdf').on('change', function() {
		$('#file_path_pdf').val($(this).val().replace(/C:\\fakepath\\/i, ''));
	});
	$('#form_import_pdf').on('submit', function(e) {
		if (!$('#kk_pdf').val()) {
			e.preventDefault();
			alert('Silakan pilih berkas PDF terlebih dahulu.');
			$('#file_browser_pdf').focus();
			return false;
		}
	});
</script>
