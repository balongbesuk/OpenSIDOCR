<?php if ($this->CI->cek_hak_akses('u')) : ?>
	<?php $this->load->view('global/validasi_form'); ?>
	<?php
    if ($log_status_dasar['tgl_peristiwa'] != '') :
        $sekarang = $log_status_dasar['tgl_peristiwa'];
    else :
        $sekarang = date('d-m-Y');
    endif;
?>
	<form action="<?= $form_action ?>" method="post" id="validasi" class="tgl_lapor_peristiwa">
		<div class='modal-body'>
			<div class="box box-danger">
				<div class="box-body">
					<?php if (!empty($nik['kk_level']) && $nik['kk_level'] == 1 && !empty($jumlah_sisa_anggota)): ?>
						<div class="alert alert-info" style="font-size: 12px; margin-bottom: 15px; padding: 10px;">
							<i class="fa fa-info-circle"></i> <strong>Pemberitahuan Kepala Keluarga (SOP Dukcapil):</strong><br>
							Warga ini tercatat sebagai <strong>Kepala Keluarga</strong>. Jika status diubah menjadi <strong>Mati</strong> atau <strong>Pindah</strong>, sisa <strong><?= $jumlah_sisa_anggota ?> anggota keluarga</strong> yang masih hidup akan <strong>otomatis dibuatkan No. KK Sementara</strong> dengan Kepala Keluarga baru.
						</div>
					<?php endif; ?>
					<div class="form-group">
						<label for="status_dasar">Status Dasar Baru</label>
						<select id="status_dasar" name="status_dasar" class="form-control select2 input-sm required">
							<option value="">Pilih Status Dasar</option>
							<?php foreach ($list_status_dasar as $data) : ?>
								<option value="<?= $data['id'] ?>" <?= selected($data['id'], $nik['status_dasar_id']) ?>><?= $data['nama'] ?></option>
							<?php endforeach; ?>
						</select>
					</div>
					<div class="form-group mati">
						<label for="meninggal_di">Tempat Meninggal</label>
						<input name="meninggal_di" class="form-control input-sm" type="text" maxlength="50" placeholder="Tempat Meninggal"></input>
					</div>
					<div class="form-group mati">
						<label for="jam_mati">Jam Kematian</label>
						<div class="input-group input-group-sm ">
							<div class="input-group-addon">
								<i class="fa fa-clock-o"></i>
							</div>
							<input name="jam_mati" id="jammenit_1" class="form-control input-sm" type="text" maxlength="50" placeholder="Jam Kematian"></input>
						</div>
					</div>
					<div class="form-group mati">
						<label for="sebab">Penyebab Kematian</label>
						<select id="sebab" name="sebab" class="form-control select2 input-sm required">
							<option value="">Pilih Penyebab Kematian</option>
							<?php foreach ($sebab as $key => $value) : ?>
								<option value="<?= $key ?>"><?= $value ?></option>
							<?php endforeach ?>
						</select>
					</div>
					<div class="form-group mati">
						<label for="penolong_mati">Yang Menerangkan Kematian</label>
						<select id="penolong_mati" name="penolong_mati" class="form-control select2 input-sm required">
							<option value="">Pilih Yang Menerangkan Kematian</option>
							<?php foreach ($penolong_mati as $key => $value) : ?>
								<option value="<?= $key ?>"><?= $value ?></option>
							<?php endforeach ?>
						</select>
					</div>
					<div class="form-group mati">
						<label for="anak_ke">Anak Ke-</label>
						<input name="anak_ke" class="form-control input-sm" type="number" min="1" placeholder="Anak Ke" value="<?= $nik['kelahiran_anak_ke'] ?>"></input>
					</div>
					<div class="form-group mati">
						<label for="akta_mati">Nomor Akta Kematian</label>
						<input name="akta_mati" class="form-control input-sm" type="text" maxlength="50" placeholder="Nomor Akta Kematian"></input>
					</div>
					<div class="form-group pindah">
						<div class="form-group">
							<label for="ref_pindah">Tujuan Pindah</label>
							<select name="ref_pindah" class="form-control select2 input-sm required">
								<option value="">Pilih Tujuan Pindah</option>
								<?php foreach ($list_ref_pindah as $data) : ?>
									<option value="<?= $data['id'] ?>" <?= selected($data['id'], $nik['ref_pindah']) ?>><?= $data['nama'] ?></option>
								<?php endforeach; ?>
							</select>
						</div>
						<div class="form-group">
							<label for="alamat_tujuan">Alamat Tujuan</label>
							<textarea id="alamat_tujuan" name="alamat_tujuan" class="form-control input-sm" placeholder="Alamat Tujuan" style="height: 50px;"></textarea>
						</div>
					</div>
					<div class="form-group">
						<label for="tgl_peristiwa">Tanggal Peristiwa</label>
						<div class="input-group input-group-sm date">
							<div class="input-group-addon">
								<i class="fa fa-calendar"></i>
							</div>
							<input class="form-control input-sm pull-right required tgl_minimal" id="tgl_1" name="tgl_peristiwa" type="text" data-tgl-lebih-besar="#tgl_lapor" value="<?= $sekarang; ?>">
						</div>
					</div>
					<div class="form-group">
						<label for="tgl_lapor">Tanggal Lapor</label>
						<div class="input-group input-group-sm date">
							<div class="input-group-addon">
								<i class="fa fa-calendar"></i>
							</div>
							<input class="form-control input-sm pull-right tgl_indo required" id="tgl_lapor" name="tgl_lapor" type="text" value="<?= $sekarang; ?>">
						</div>
					</div>
					<div class="form-group">
						<label for="catatan">Catatan Peristiwa</label>
						<textarea id="catatan" name="catatan" class="form-control input-sm" placeholder="Catatan" rows="5"></textarea>
						<p class="help-block">*mati/hilang terangkan penyebabnya, pindah tuliskan alamat pindah</p>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="reset" class="btn btn-social btn-flat btn-danger btn-sm" data-dismiss="modal"><i class='fa fa-sign-out'></i> Tutup</button>
				<button type="submit" class="btn btn-social btn-flat btn-info btn-sm" id="ok"><i class='fa fa-check'></i> Simpan</button>
			</div>
		</div>
	</form>
	<script>
		$('#tgl_1').datetimepicker({
			format: 'DD-MM-YYYY',
			locale: 'id'
		});

		$('#tgl_lapor').datetimepicker({
			format: 'DD-MM-YYYY',
			locale: 'id'
		});

		$('document').ready(function() {
			$('#status_dasar').change(function() {
				if ($(this).val() == '3' || $(this).val() == '2') {
					if ($(this).val() == '3') {
						$('.pindah').show();
						$("select[name='ref_pindah']").addClass('required');
						$("textarea[name='alamat_tujuan']").addClass('required');
						$('.mati').hide();
						$("input[name='meninggal_di']").removeClass('required');
						$("input[name='jam_mati']").removeClass('required');
						$("select[name='sebab']").removeClass('required');
						$("select[name='penolong_mati']").removeClass('required');
						$("input[name='anak_ke']").removeClass('required').removeAttr("min");;
					} else {
						$('.mati').show();
						$("input[name='meninggal_di']").addClass('required');
						$('.pindah').hide();
						$("select[name='ref_pindah']").removeClass('required');
						$("textarea[name='alamat_tujuan']").removeClass('required');
						$("input[name='jam_mati']").show().addClass('required');
						$("select[name='sebab']").addClass('required');
						$("select[name='penolong_mati']").addClass('required');
						$("input[name='anak_ke']").addClass('required').attr("min", 1);
					}
				} else {
					$('.pindah').hide();
					$("select[name='ref_pindah']").removeClass('required');
					$("textarea[name='alamat_tujuan']").removeClass('required');
					$('.mati').hide();
					$("input[name='meninggal_di']").removeClass('required');
					$("input[name='jam_mati']").removeClass('required');
					$("select[name='sebab']").removeClass('required');
					$("select[name='penolong_mati']").removeClass('required');
					$("input[name='anak_ke']").removeClass('required').removeAttr("min");;
				}
			});
			$('#status_dasar').trigger('change');

			setTimeout(function() {
				$("#tgl_lapor").rules('add', {
					tgl_lebih_besar: "input[name='tgl_peristiwa']",
					messages: {
						tgl_lebih_besar: "Tanggal lapor harus sama atau lebih besar dari tanggal peristiwa."
					}
				})
			}, 500);

			$('#validasi').submit(function(e) {
				var status = $('#status_dasar').val();
				var isKepala = <?= (!empty($nik['kk_level']) && $nik['kk_level'] == 1 && !empty($jumlah_sisa_anggota)) ? 'true' : 'false' ?>;
				var sisaAnggota = <?= (int) ($jumlah_sisa_anggota ?? 0) ?>;

				if (isKepala && (status == '2' || status == '3') && sisaAnggota > 0) {
					if (!$(this).data('confirmed')) {
						e.preventDefault();
						var form = this;
						var statusText = (status == '2') ? 'Meninggal Dunia' : 'Pindah Keluar';
						var htmlContent = '<div style="text-align: left; font-size: 13px; line-height: 1.6; color: #333;">' +
							'<p>Warga ini tercatat sebagai <strong>Kepala Keluarga</strong> dan memiliki <strong>' + sisaAnggota + ' anggota keluarga</strong> yang masih hidup.</p>' +
							'<div class="callout callout-warning" style="margin-bottom: 10px; padding: 10px; text-align: left; background-color: #fcf8e3 !important; border-color: #8a6d3b !important; color: #8a6d3b !important;">' +
							'<strong>Tindakan Otomatis Sistem:</strong>' +
							'<ul style="padding-left: 18px; margin-bottom: 0;">' +
							'<li>Sisa <strong>' + sisaAnggota + ' anggota</strong> akan otomatis dibuatkan <strong>No. KK Sementara</strong>.</li>' +
							'<li>Kolom <strong>No. KK Sebelumnya</strong> akan otomatis terisi dengan No. KK lama.</li>' +
							(status == '2' ? '<li>Status perkawinan pasangan akan otomatis diubah menjadi <strong>Cerai Mati</strong>.</li>' : '') +
							'</ul>' +
							'</div>' +
							'<p style="margin-bottom: 0;">Apakah Anda yakin ingin memproses perubahan status <strong>' + statusText + '</strong> ini?</p>' +
							'</div>';

						if (typeof Swal !== 'undefined') {
							Swal.fire({
								title: '<span style="font-size: 18px; font-weight: bold; color: #d9534f;"><i class="fa fa-warning"></i> Konfirmasi Perubahan Status</span>',
								html: htmlContent,
								icon: 'warning',
								showCancelButton: true,
								confirmButtonColor: '#3085d6',
								cancelButtonColor: '#d33',
								confirmButtonText: '<i class="fa fa-check"></i> Ya, Proses',
								cancelButtonText: '<i class="fa fa-times"></i> Batal',
								reverseButtons: true,
								focusConfirm: false
							}).then(function(result) {
								if (result.isConfirmed || result.value) {
									$(form).data('confirmed', true);
									form.submit();
								}
							});
						} else {
							var plainMsg = "PERHATIAN SOP DUKCAPIL:\n\n" +
								"Warga ini tercatat sebagai Kepala Keluarga dan memiliki " + sisaAnggota + " anggota keluarga yang masih hidup.\n\n" +
								"- Sisa " + sisaAnggota + " anggota keluarga akan OTOMATIS dibuatkan No. KK Sementara.\n" +
								"- Kolom 'No. KK Sebelumnya' pada sisa anggota akan otomatis diisi dengan No. KK lama.\n" +
								(status == '2' ? "- Status perkawinan pasangan akan otomatis diperbarui menjadi 'Cerai Mati'.\n\n" : "\n") +
								"Lanjutkan penyimpanan?";
							if (confirm(plainMsg)) {
								$(form).data('confirmed', true);
								form.submit();
							}
						}
						return false;
					}
				}
			});
		});
	</script>
<?php endif; ?>