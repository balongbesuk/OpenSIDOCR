<div class="content-wrapper">
	<section class="content-header">
		<h1>
			Pembangunan
			<small><?= ($main->id ?? false ? 'Ubah' : 'Tambah') ?> Data</small>
		</h1>
		<ol class="breadcrumb">
			<li><a href="<?= site_url('hom_sid') ?>"><i class="fa fa-home"></i> Home</a></li>
			<li><a href="<?= site_url('admin_pembangunan') ?>"> Pembangunan</a></li>
			<li class="active"><?= ($main->id ?? false ? 'Ubah' : 'Tambah') ?> Data</li>
		</ol>
	</section>
	<section class="content" id="maincontent">
		<form action="<?= $form_action; ?>" method="post" id="validasi" enctype="multipart/form-data">
			<div class="row">
				<div class="col-md-9">
					<div class="box box-info">
						<div class="box-header with-border">
							<a href="<?= site_url('admin_pembangunan') ?>" class="btn btn-social btn-flat btn-info btn-sm visible-xs-block visible-sm-inline-block visible-md-inline-block visible-lg-inline-block"><i class="fa fa-arrow-circle-left"></i> Kembali Ke Pembangunan</a>
						</div>
						<div class="box-body">
							<div class="form-group">
								<label class="control-label" style="text-align:left;">Nama Kegiatan</label>
								<input id="judul" name="judul" class="form-control input-sm strip_tags judul required" value="<?= e($main->judul ?? '') ?>" type="text" minlength="5" maxlength="100" placeholder="Nama Kegiatan Pembangunan" />
							</div>
							<div class="form-group">
								<label class="control-label" style="text-align:left;">Volume</label>
								<input maxlength="50" class="form-control input-sm strip_tags required" name="volume" id="volume" value="<?= $main->volume ?? '' ?>" type="text" placeholder="Volume Pembangunan" />
							</div>
							<div class="form-group">
								<label class="control-label" style="text-align:left;">Waktu</label>
								<div class="row">
									<div class="col-xs-7 col-sm-8" style="padding-right: 5px;">
										<input maxlength="50" class="form-control number input-sm required" name="waktu" id="waktu" value="<?= $main->waktu ?? '' ?>" type="text" placeholder="Lamanya pembangunan" />
									</div>
									<div class="col-xs-5 col-sm-4" style="padding-left: 5px;">
										<select class="form-control input-sm select2 required" name="satuan_waktu" style="width:100%;">
											<?php foreach ($satuan_waktu as $key => $value) : ?>
												<option value="<?= $key ?>" <?= selected($key, $main->satuan_waktu ?? null) ?>><?= $value ?></option>
											<?php endforeach; ?>
										</select>
									</div>
								</div>
							</div>
							<div class="form-group">
								<label class="control-label" for="sumber_dana">Sumber Dana</label>
								<select class="form-control input-sm select2" id="sumber_dana" name="sumber_dana" style="width:100%;">
									<?php foreach ($sumber_dana as $value) : ?>
										<option <?= $value === ($main->sumber_dana ?? '') ? 'selected' : '' ?> value="<?= $value ?>"><?= $value ?></option>
									<?php endforeach; ?>
								</select>
							</div>
							<div class="row">
								<div class="col-sm-6">
									<div class="form-group">
										<label class="control-label" for="tahun_anggaran">Tahun Anggaran</label>
										<select class="form-control input-sm select2" id="tahun_anggaran" name="tahun_anggaran" style="width:100%;">
											<?php foreach (tahun(1999) as $value) : ?>
												<option value="<?= $value ?>" <?= selected($value, $main->tahun_anggaran ?? null) ?>><?= $value ?></option>
											<?php endforeach; ?>
										</select>
									</div>
								</div>
								<div class="col-sm-6">
									<div class="form-group">
										<label class="control-label" style="text-align:left;">Anggaran</label>
										<input class="form-control input-sm required bilangan" name="anggaran" id="anggaran" value="<?= $main->anggaran ?? ''; ?>" type="text" placeholder="Anggaran" readonly />
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-sm-6">
									<div class="form-group">
										<label class="control-label" for="sumber_biaya_pemerintah">Sumber Biaya Pemerintah</label>
										<input id="sumber_biaya_pemerintah" name="sumber_biaya_pemerintah" onkeyup="cek()" class="form-control input-sm required bilangan" maxlength="12" type="text" placeholder="Sumber Biaya Pemerintah" value="<?= $main->sumber_biaya_pemerintah ?? ''; ?>" />
									</div>
								</div>
								<div class="col-sm-6">
									<div class="form-group">
										<label class="control-label" for="sumber_biaya_provinsi">Sumber Biaya Provinsi</label>
										<input id="sumber_biaya_provinsi" name="sumber_biaya_provinsi" onkeyup="cek()" class="form-control input-sm required bilangan" maxlength="12" type="text" placeholder="Sumber Biaya Provinsi" value="<?= $main->sumber_biaya_provinsi ?? ''; ?>" />
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-sm-6">
									<div class="form-group">
										<label class="control-label" for="sumber_biaya_kab_kota">Sumber Biaya Kab / Kota</label>
										<input id="sumber_biaya_kab_kota" name="sumber_biaya_kab_kota" class="form-control input-sm required bilangan" maxlength="12" onkeyup="cek()" type="text" placeholder="Sumber Biaya Kab / Kota" value="<?= $main->sumber_biaya_kab_kota ?? ''; ?>" />
									</div>
								</div>
								<div class="col-sm-6">
									<div class="form-group">
										<label class="control-label" for="sumber_biaya_swadaya">Sumber Biaya Swadaya</label>
										<input id="sumber_biaya_swadaya" name="sumber_biaya_swadaya" class="form-control input-sm required bilangan" maxlength="12" type="text" onkeyup="cek()" placeholder="Sumber Biaya Swadaya" value="<?= $main->sumber_biaya_swadaya ?? ''; ?>" />
									</div>
								</div>
							</div>
							<div class="form-group">
								<label class="control-label" style="text-align:left;">Sifat Proyek</label>
								<select class="form-control input-sm select2 required" id="sifat_proyek" name="sifat_proyek" style="width:100%;">
									<option value="">-- Pilih Sifat Proyek --</option>
									<option value="BARU" <?php selected($main->sifat_proyek ?? '', 'BARU') ?>>BARU</option>
									<option value="LANJUTAN" <?php selected($main->sifat_proyek ?? '', 'LANJUTAN') ?>>LANJUTAN</option>
								</select>
							</div>
							<div class="form-group">
								<label class="control-label" style="text-align:left;">Pelaksana Kegiatan</label>
								<input maxlength="50" class="form-control input-sm strip_tags required" name="pelaksana_kegiatan" id="pelaksana_kegiatan" value="<?= $main->pelaksana_kegiatan ?? '' ?>" type="text" placeholder="Pelaksana Kegiatan Pembangunan" />
							</div>
							<div class="form-group">
								<label for="jenis_lokasi" class="control-label">Lokasi Pembangunan</label>
								<div style="margin-bottom: 10px;">
									<div class="btn-group btn-group-justified" data-toggle="buttons">
										<label class="btn btn-info btn-flat btn-sm form-check-label <?= ($main->lokasi ?? false) ? '' : 'active' ?>">
											<input type="radio" name="jenis_lokasi" class="form-check-input" value="1" autocomplete="off" onchange="pilih_lokasi(this.value);"> Pilih Lokasi
										</label>
										<label class="btn btn-info btn-flat btn-sm form-check-label <?= ($main->lokasi ?? false) ? 'active' : '' ?>">
											<input type="radio" name="jenis_lokasi" class="form-check-input" value="2" autocomplete="off" onchange="pilih_lokasi(this.value);"> Tulis Manual
										</label>
									</div>
								</div>
								<div id="pilih">
									<select class="form-control input-sm select2 required" id="id_lokasi" name="id_lokasi" style="width:100%;">
										<option value="">-- Pilih Lokasi Pembangunan --</option>
										<?php foreach ($list_lokasi as $key => $item) : ?>
											<option value="<?= $item['id'] ?>" <?= selected($item['id'], $main->id_lokasi ?? null) ?>><?= strtoupper($item['dusun']) ?> <?= empty($item['rw']) ? '' : " - RW  {$item['rw']}" ?> <?= empty($item['rt']) ? '' : " / RT  {$item['rt']}" ?></option>
										<?php endforeach; ?>
									</select>
								</div>
								<div id="manual">
									<textarea id="lokasi" class="form-control input-sm strip_tags required" placeholder="Lokasi" name="lokasi" rows="3"><?= e($main->lokasi ?? '') ?></textarea>
								</div>
							</div>
							<div class="form-group">
								<label class="control-label" for="manfaat">Manfaat</label>
								<textarea id="manfaat" name="manfaat" class="form-control input-sm strip_tags required" placeholder="Manfaat" rows="3"><?= e($main->manfaat ?? ''); ?></textarea>
							</div>
							<div class="form-group">
								<label class="control-label" for="keterangan">Keterangan</label>
								<textarea id="keterangan" class="form-control input-sm strip_tags required" name="keterangan" placeholder="Keterangan" rows="3"><?= e($main->keterangan ?? '') ?></textarea>
							</div>
						</div>
						<div class="box-footer">
							<button type="reset" class="btn btn-social btn-flat btn-danger btn-sm"><i class="fa fa-times"></i> Batal</button>
							<button type="submit" id="submit" class="btn btn-social btn-flat btn-info btn-sm pull-right"><i class="fa fa-check"></i> Simpan</button>
						</div>
					</div>
				</div>
				<div class="col-md-3">
					<div class="box box-info">
						<div class="box-header with-border">
							<h3 class="box-title">Gambar Utama</h3>
							<div class="box-tools">
								<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
							</div>
						</div>
						<div class="box-body">
							<div class="form-group text-center">
								<?php if (is_file(LOKASI_GALERI . ($main->foto ?? ''))) : ?>
									<img class="img-responsive img-thumbnail" style="margin: 0 auto 12px; max-height: 200px; object-fit: cover;" src="<?= to_base64(LOKASI_GALERI . $main->foto); ?>" alt="Gambar Utama Pembangunan">
								<?php else : ?>
									<img class="img-responsive img-thumbnail" style="margin: 0 auto 12px; max-height: 200px; object-fit: cover;" src="<?= to_base64('assets/images/404-image-not-found.jpg') ?>" alt="Gambar Utama Pembangunan" />
								<?php endif; ?>
								<input type="hidden" name="old_foto" value="<?= $main->foto ?? ''; ?>">
								<div class="input-group input-group-sm">
									<input type="text" class="form-control" id="file_path" placeholder="Pilih berkas gambar...">
									<input type="file" class="hidden" id="file" name="foto" accept=".jpg,.jpeg,.png">
									<span class="input-group-btn">
										<button type="button" class="btn btn-info btn-flat" id="file_browser"><i class="fa fa-search"></i> Browse</button>
									</span>
								</div>
								<?php if (($main->foto ?? false) && is_file(LOKASI_GALERI . $main->foto)) : ?>
									<div class="checkbox text-left" style="margin-top: 10px;">
										<label class="text-danger" style="font-weight: 600;">
											<input type="checkbox" title="Centang Untuk Hapus Gambar" name="hapus_foto" value="hapus"> Centang Untuk Hapus Gambar
										</label>
									</div>
								<?php endif; ?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</form>
	</section>
</div>
<script>
	var sb_pem = document.getElementById('sumber_biaya_pemerintah');
	var sb_prov = document.getElementById('sumber_biaya_provinsi');
	var sb_kab = document.getElementById('sumber_biaya_kab_kota');
	var sb_swad = document.getElementById('sumber_biaya_swadaya');
	var aggaran = document.getElementById('anggaran');

	function getSum(total, num) {
		return total + Math.round(num);
	}

	function cek() {
		const numbers = [sb_pem.value, sb_prov.value, sb_kab.value, sb_swad.value];
		var biaya = numbers.reduce(getSum, 0);
		document.getElementById('anggaran').value = biaya;
		var total_anggaran = aggaran.value;
	};

	$(document).ready(function() {
		$("form").submit(function(e) {
			const numbers = [sb_pem.value, sb_prov.value, sb_kab.value, sb_swad.value];
			var biaya = numbers.reduce(getSum, 0);
			var total_anggaran = aggaran.value;
			if (biaya > total_anggaran) {
				alert('Total rincian sumber biaya tidak boleh melebihi anggaran.');
				e.preventDefault(e);
			}
		});
	});

	function pilih_lokasi(pilih) {
		if (pilih == 1) {
			$('#lokasi').val(null);
			$('#lokasi').removeClass('required');
			$("#manual").hide();
			$("#pilih").show();
			$('#id_lokasi').addClass('required');
		} else {
			$('#id_lokasi').val(null);
			$('#id_lokasi').trigger('change', true);
			$('#id_lokasi').removeClass('required');
			$("#manual").show();
			$('#lokasi').addClass('required');
			$("#pilih").hide();
		}
	}

	$(document).ready(function() {
		pilih_lokasi(<?= (empty($main->id_lokasi) && !empty($main->lokasi)) ? 2 : 1 ?>);
	});
</script>
