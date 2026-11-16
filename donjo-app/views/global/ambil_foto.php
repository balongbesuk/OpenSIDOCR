<div class="box box-primary">
	<div class="box-body box-profile">
		<img class="penduduk" id="foto" src="<?= AmbilFoto($foto, '', $id_sex); ?>" alt="Foto Penduduk">
		<input type="file" class="hidden" id="file" name="foto" accept=".jpg,.jpeg,.png">
		<input type="text" class="hidden" id="file_path" name="foto">
		<input type="hidden" name="old_foto" id="old_foto" value="<?= $foto; ?>">
		
		<div class="box-foto-aksi">
			<div class="foto-row-btn">
				<button type="button" class="btn btn-info btn-sm" id="file_browser" title="Unggah Berkas Foto">
					<i class="fa fa-upload"></i> Unggah
				</button>
				<button type="button" class="btn btn-danger btn-sm" onclick="kamera();" id="ambil_kamera" title="Ambil Foto Lewat Kamera/WebCam">
					<i class="fa fa-camera"></i> Kamera
				</button>
			</div>
			<?php if (! empty($penduduk['id'])) : ?>
				<a href="#" data-href="<?= site_url("penduduk/foto_bawaan/{$penduduk['id']}") ?>" class="btn btn-warning btn-sm btn-restore" title="Kembalikan Foto Bawaan / Hapus Foto Kustom" data-toggle="modal" data-target="#confirm-delete">
					<i class="fa fa-undo"></i> Kembalikan
				</a>
			<?php endif ?>
		</div>
	</div>
</div>
<?php $this->load->view('global/confirm_delete'); ?>
