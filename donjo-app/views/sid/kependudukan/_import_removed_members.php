<?php if (! empty($removed_members)): ?>
	<div class="box box-solid box-danger">
		<div class="box-header with-border">
			<h4 class="box-title">
				<i class="fa fa-exclamation-triangle"></i>
				<strong>PERINGATAN PENGURANGAN ANGGOTA KELUARGA (<?= count($removed_members) ?> Orang)</strong>
			</h4>
		</div>
		<div class="box-body">
			<div class="alert alert-danger" style="margin-bottom: 12px;">
				<i class="fa fa-info-circle"></i>
				Anggota keluarga berikut masih tercatat <strong>aktif di KK ini pada database</strong>, tetapi <strong>tidak tercantum</strong> pada KK terbaru yang diunggah.
				Menyimpan impor ini tidak otomatis mengeluarkan mereka dari KK — silakan periksa dan proses pindah/status dasar secara manual jika memang sudah tidak satu KK.
			</div>
			<div class="table-responsive">
				<table class="table table-bordered table-striped table-hover text-sm" style="margin-bottom: 0;">
					<thead class="bg-danger">
						<tr>
							<th class="text-center" width="40">No</th>
							<th>NIK</th>
							<th>Nama Lengkap</th>
							<th>Sex</th>
							<th>Tempat, Tgl Lahir</th>
							<th>Hubungan (DB)</th>
							<th class="text-center" width="130">Aksi</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($removed_members as $ridx => $rm): ?>
							<tr style="background-color: #fdf2f2;">
								<td class="text-center"><?= $ridx + 1 ?></td>
								<td><strong><?= html_escape($rm['nik']) ?></strong></td>
								<td><?= html_escape($rm['nama']) ?></td>
								<td><?= html_escape($rm['sex_label'] ?? '-') ?></td>
								<td><?= html_escape($rm['tempatlahir'] ?: '-') ?>, <?= ! empty($rm['tanggallahir']) ? tgl_indo($rm['tanggallahir']) : '-' ?></td>
								<td><span class="label label-danger"><?= html_escape($rm['hubungan_label'] ?? '-') ?></span></td>
								<td class="text-center">
									<a href="<?= site_url("penduduk/detail/1/0/{$rm['id']}") ?>" target="_blank" rel="noopener noreferrer" class="btn btn-xs btn-danger" title="Buka Detail Penduduk di Tab Baru">
										<i class="fa fa-external-link"></i> Cek Penduduk
									</a>
								</td>
							</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
<?php endif; ?>
