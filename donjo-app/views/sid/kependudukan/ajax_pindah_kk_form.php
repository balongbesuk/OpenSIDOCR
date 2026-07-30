<?php if ($this->CI->cek_hak_akses('u')): ?>
<?php $this->load->view('global/validasi_form'); ?>
<form action="<?= $form_action ?>" method="post" id="validasi">
	<div class="modal-body">
		<!-- Ringkasan Informasi KK -->
		<div class="box box-info box-solid" style="margin-bottom: 15px;">
			<div class="box-header with-border" style="padding: 8px 12px;">
				<h3 class="box-title" style="font-size: 14px;"><i class="fa fa-id-card"></i> Informasi Kartu Keluarga</h3>
			</div>
			<div class="box-body" style="padding: 10px;">
				<table class="table table-bordered table-striped" style="margin-bottom: 0; font-size: 12px;">
					<tr>
						<td width="25%"><strong>Nomor Kartu Keluarga</strong></td>
						<td width="1%">:</td>
						<td><strong><?= $kk['no_kk'] ?></strong></td>
					</tr>
					<tr>
						<td><strong>Kepala Keluarga</strong></td>
						<td>:</td>
						<td><?= $kk['nama'] ?></td>
					</tr>
					<tr>
						<td><strong>Alamat</strong></td>
						<td>:</td>
						<td><?= $kk['alamat_wilayah'] ?></td>
					</tr>
				</table>
			</div>
		</div>

		<!-- Tabel Pilih Anggota Keluarga -->
		<div class="form-group">
			<label><i class="fa fa-users"></i> Pilih Anggota Keluarga yang Pindah</label>
			<div class="table-responsive">
				<table class="table table-bordered table-striped table-hover tabel-daftar">
					<thead class="bg-gray disabled color-palette">
						<tr>
							<th width="30" class="text-center">
								<input type="checkbox" id="check_all_pindah" checked title="Centang / Hapus Semua">
							</th>
							<th>NIK</th>
							<th>Nama Lengkap</th>
							<th>Jenis Kelamin</th>
							<th>Tanggal Lahir / Umur</th>
							<th>Hubungan Dalam KK</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($anggota as $m): ?>
							<tr>
								<td class="text-center padat">
									<input type="checkbox" name="id_cb[]" value="<?= $m['id'] ?>" class="cb-pindah" checked 
										data-id="<?= $m['id'] ?>" 
										data-kk-level="<?= $m['kk_level'] ?>" 
										data-tgl="<?= $m['tanggallahir'] ?>" 
										data-nama="<?= html_escape($m['nama']) ?>">
								</td>
								<td><strong><?= $m['nik'] ?></strong></td>
								<td><?= $m['nama'] ?></td>
								<td><?= $m['sex'] ?></td>
								<td><?= tgl_indo($m['tanggallahir']) ?> (<?= $m['umur'] ?> Thn)</td>
								<td><span class="label label-default"><?= $m['hubungan'] ?></span></td>
							</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
			</div>
		</div>

		<!-- Section Penunjukan Kepala KK Baru (Permendagri 108/2019) -->
		<div id="section_kepala_kk_baru" class="callout callout-warning" style="display: none; margin-bottom: 15px;">
			<h4><i class="icon fa fa-warning"></i> Ketentuan Permendagri No. 108/2019</h4>
			<p>Kepala KK Lama dicentang untuk <strong>PINDAH</strong>, namun terdapat anggota keluarga yang ditinggalkan (tidak ikut pindah). Sisa anggota keluarga akan <strong>otomatis dibuatkan KK Baru (No. KK Sementara)</strong>.</p>
			<div class="form-group" style="margin-top: 10px; margin-bottom: 0;">
				<label for="kepala_kk_baru">Pilih Kepala KK Baru (Keluarga Sisa):</label>
				<select name="kepala_kk_baru" id="kepala_kk_baru" class="form-control input-sm select2" style="width: 100%;">
					<!-- Populated via Javascript -->
				</select>
				<span class="help-block" style="margin-bottom: 0;"><i class="fa fa-info-circle"></i> Otomatis disarankan anggota tersisa yang tertua (dapat disesuaikan sesuai kesepakatan).</span>
			</div>
		</div>

		<!-- Form Peristiwa Kepindahan -->
		<div class="box box-danger">
			<div class="box-header with-border" style="padding: 8px 12px;">
				<h3 class="box-title" style="font-size: 14px;"><i class="fa fa-pencil-square-o"></i> Data Peristiwa Kepindahan</h3>
			</div>
			<div class="box-body">
				<div class="form-group">
					<label for="ref_pindah">Tujuan Pindah / Klasifikasi *</label>
					<select name="ref_pindah" id="ref_pindah" class="form-control select2 input-sm required" style="width: 100%;">
						<option value="">Pilih Tujuan Pindah</option>
						<?php foreach ($list_ref_pindah as $rp): ?>
							<option value="<?= $rp['id'] ?>" <?= selected($rp['id'], 4) ?>><?= $rp['id'] ?> - <?= $rp['nama'] ?></option>
						<?php endforeach; ?>
					</select>
				</div>

				<div class="form-group">
					<label for="tgl_peristiwa">Tanggal Peristiwa *</label>
					<div class="input-group input-group-sm date">
						<div class="input-group-addon">
							<i class="fa fa-calendar"></i>
						</div>
						<input class="form-control input-sm pull-right tgl_indo required" id="tgl_peristiwa" name="tgl_peristiwa" type="text" value="<?= date('d-m-Y') ?>">
					</div>
				</div>

				<div class="form-group">
					<label for="tgl_lapor">Tanggal Lapor *</label>
					<div class="input-group input-group-sm date">
						<div class="input-group-addon">
							<i class="fa fa-calendar"></i>
						</div>
						<input class="form-control input-sm pull-right tgl_indo required" id="tgl_lapor" name="tgl_lapor" type="text" value="<?= date('d-m-Y') ?>">
					</div>
				</div>

				<div class="form-group">
					<label for="alamat_tujuan">Alamat Tujuan *</label>
					<textarea id="alamat_tujuan" name="alamat_tujuan" class="form-control input-sm required" placeholder="Alamat Tujuan Kepindahan" style="height: 50px;"></textarea>
				</div>

				<div class="form-group">
					<label for="catatan">No. SKPWNI / Catatan Kepindahan</label>
					<textarea id="catatan" name="catatan" class="form-control input-sm" placeholder="No. SKP atau Catatan Tambahan (Opsional)" style="height: 40px;"></textarea>
				</div>
			</div>
		</div>
	</div>

	<div class="modal-footer">
		<button type="reset" class="btn btn-social btn-flat btn-danger btn-sm pull-left" data-dismiss="modal"><i class="fa fa-sign-out"></i> Batal</button>
		<button type="submit" class="btn btn-social btn-flat btn-info btn-sm" id="btn_submit_pindah"><i class="fa fa-check"></i> Simpan</button>
	</div>
</form>

<script>
$(document).ready(function() {
	if ($.fn.select2) {
		$('.select2').select2({ dropdownParent: $('#modalBox') });
	}

	if ($.fn.datetimepicker) {
		$('#tgl_peristiwa, #tgl_lapor, .tgl_indo').datetimepicker({
			format: 'DD-MM-YYYY',
			locale: 'id'
		});
	}

	function evalKekeluargaan() {
		var totalChecked = $('.cb-pindah:checked').length;
		var totalCount = $('.cb-pindah').length;
		var kepalaChecked = false;

		$('.cb-pindah:checked').each(function() {
			if ($(this).data('kk-level') == 1) {
				kepalaChecked = true;
			}
		});

		if (kepalaChecked && totalChecked < totalCount) {
			$('#section_kepala_kk_baru').slideDown();
			populateKepalaBaru();
		} else {
			$('#section_kepala_kk_baru').slideUp();
			$('#kepala_kk_baru').empty();
		}

		if (totalChecked === 0) {
			$('#btn_submit_pindah').prop('disabled', true);
		} else {
			$('#btn_submit_pindah').prop('disabled', false);
		}
	}

	function populateKepalaBaru() {
		var sisa = [];
		$('.cb-pindah:not(:checked)').each(function() {
			sisa.push({
				id: $(this).data('id'),
				nama: $(this).data('nama'),
				tgl: $(this).data('tgl')
			});
		});

		sisa.sort(function(a, b) {
			return (a.tgl > b.tgl) ? 1 : ((a.tgl < b.tgl) ? -1 : 0);
		});

		var $select = $('#kepala_kk_baru');
		$select.empty();
		$.each(sisa, function(idx, item) {
			var isSelected = (idx === 0) ? 'selected' : '';
			$select.append('<option value="' + item.id + '" ' + isSelected + '>' + item.nama + ' (Tertua)</option>');
		});
	}

	$('#check_all_pindah').change(function() {
		$('.cb-pindah').prop('checked', $(this).prop('checked'));
		evalKekeluargaan();
	});

	$('.cb-pindah').change(function() {
		var allChecked = $('.cb-pindah:checked').length === $('.cb-pindah').length;
		$('#check_all_pindah').prop('checked', allChecked);
		evalKekeluargaan();
	});

	$('#validasi').submit(function(e) {
		var totalChecked = $('.cb-pindah:checked').length;
		if (totalChecked === 0) {
			e.preventDefault();
			alert('Silakan pilih minimal 1 anggota keluarga yang akan dipindahkan.');
			return false;
		}
	});

	evalKekeluargaan();
});
</script>
<?php endif; ?>
