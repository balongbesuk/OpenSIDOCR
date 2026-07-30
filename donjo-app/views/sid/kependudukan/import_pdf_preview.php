<div class="content-wrapper">
	<section class="content-header">
		<h1>Pratinjau Impor Kartu Keluarga (PDF)</h1>
		<ol class="breadcrumb">
			<li><a href="<?= site_url('hom_sid') ?>"><i class="fa fa-home"></i> Home</a></li>
			<li><a href="<?= site_url('keluarga') ?>">Data Keluarga</a></li>
			<li class="active">Pratinjau Impor PDF</li>
		</ol>
	</section>
	<section class="content" id="maincontent">
		<?php if (!empty($warning_kk_lama)): ?>
			<div class="alert alert-warning alert-dismissible">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
				<h4><i class="icon fa fa-warning"></i> Peringatan Tanggal Cetak KK PDF!</h4>
				<?= $warning_kk_lama ?>
			</div>
		<?php endif; ?>

		<form id="form_simpan_pdf" action="<?= site_url('keluarga/simpan_import_pdf') ?>" method="POST" class="form-horizontal">
			<?php if ($this->config->config['csrf_protection']): ?>
				<input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>" />
			<?php endif; ?>
			<input type="hidden" name="parsed_data" value="<?= html_escape(json_encode($parsed)) ?>">

			<div class="box box-info">
				<div class="box-header with-border">
					<h3 class="box-title"><i class="fa fa-id-card"></i> Informasi Kartu Keluarga (Header)</h3>
				</div>
				<div class="box-body">
					<table class="table table-bordered table-striped text-sm">
						<tr>
							<th width="20%">No. Kartu Keluarga</th>
							<td width="30%">
								<strong>
									<?php if (!empty($id_kk)): ?>
										<a href="<?= site_url("keluarga/kartu_keluarga/1/0/{$id_kk}") ?>" target="_blank" title="Buka Detail Kartu Keluarga di Tab Baru" style="color: #3c8dbc; text-decoration: underline;">
											<?= $parsed['header']['no_kk'] ?> <i class="fa fa-external-link text-xs"></i>
										</a>
									<?php else: ?>
										<?= $parsed['header']['no_kk'] ?>
									<?php endif; ?>
								</strong>
							</td>
							<th width="20%">Nama Kepala Keluarga</th>
							<td width="30%"><strong><?= $parsed['header']['kepala_keluarga'] ?></strong></td>
						</tr>
						<tr>
							<th>Alamat</th>
							<td><?= $parsed['header']['alamat'] ?></td>
							<th>RT / RW</th>
							<td>RT <?= $parsed['header']['rt'] ?> / RW <?= $parsed['header']['rw'] ?></td>
						</tr>
						<tr>
							<th>Desa / Kecamatan</th>
							<td><?= $parsed['header']['desa'] ?> / <?= $parsed['header']['kecamatan'] ?></td>
							<th>Kabupaten / Provinsi</th>
							<td><?= $parsed['header']['kabupaten'] ?> / <?= $parsed['header']['provinsi'] ?></td>
						</tr>
						<tr>
							<th>Tanggal Cetak KK</th>
							<td><?= $parsed['header']['tgl_cetak'] ? tgl_indo($parsed['header']['tgl_cetak']) : '-' ?></td>
							<th>Status KK di DB</th>
							<td>
								<?php if ($kk_exists): ?>
									<span class="label label-warning"><i class="fa fa-refresh"></i> Update Data KK</span>
								<?php else: ?>
									<span class="label label-success"><i class="fa fa-plus"></i> KK Baru</span>
								<?php endif; ?>
							</td>
						</tr>
					</table>
				</div>
			</div>

			<div class="box box-primary">
				<div class="box-header with-border">
					<h3 class="box-title"><i class="fa fa-users"></i> Anggota Keluarga (<?= count($parsed['members']) ?> Orang)</h3>
				</div>
				<div class="box-body">
					<div class="table-responsive">
						<table class="table table-bordered table-striped table-hover text-sm">
							<thead class="bg-gray disabled color-palette">
								<tr>
									<th class="text-center">No</th>
									<th class="text-center">Status DB</th>
									<th>NIK</th>
									<th>Nama Lengkap</th>
									<th>Sex</th>
									<th>Tempat, Tgl Lahir</th>
									<th>Agama</th>
									<th>Status Perkawinan</th>
									<th>Gol. Darah</th>
									<th>Pendidikan</th>
									<th>Pekerjaan</th>
									<th>Hubungan</th>
									<th>Ayah / Ibu</th>
									<th>Alamat Asal (Penduduk Masuk)</th>
								</tr>
							</thead>
							<tbody>
								<?php foreach ($parsed['members'] as $idx => $m): ?>
									<tr>
										<td class="text-center"><?= $m['no'] ?></td>
										<td class="text-center">
											<?php if (!empty($m['is_nik_sementara_match'])): ?>
												<span class="label label-info" title="NIK Sementara <?= $m['nik_lama'] ?> akan diperbarui ke NIK Resmi Dukcapil"><i class="fa fa-key"></i> Update NIK Sementara</span>
											<?php elseif (!empty($m['status_dasar']) && $m['status_dasar'] == 2): ?>
												<span class="label label-danger" title="Penduduk Tercatat Meninggal di DB (Status Tetap Dipertahankan)"><i class="fa fa-times-circle"></i> Meninggal</span>
											<?php elseif (!empty($m['status_dasar']) && $m['status_dasar'] == 3): ?>
												<span class="label label-info" title="Penduduk Tercatat Pindah Keluar di DB"><i class="fa fa-arrow-right"></i> Pindah</span>
											<?php elseif (!empty($m['pindah_kk'])): ?>
												<span class="label label-warning" title="Pindah dari KK Lama No: <?= $m['no_kk_lama'] ?> (Kepala: <?= $m['kepala_kk_lama'] ?>)"><i class="fa fa-exchange"></i> Pindah KK</span>
											<?php elseif (!empty($m['db_exists'])): ?>
												<span class="label label-warning" title="NIK Sudah ada, akan diperbarui">Update</span>
											<?php else: ?>
												<span class="label label-success" title="NIK Baru, akan ditambahkan">Baru</span>
											<?php endif; ?>
										</td>
										<td <?= isset($m['diff']['nik']) ? 'style="background-color: #fff3cd;"' : '' ?>>
											<strong><?= $m['nik'] ?></strong>
											<?php if (!empty($m['is_nik_sementara_match'])): ?>
												<br><small class="text-muted"><i class="fa fa-info-circle"></i> NIK Lama: <?= $m['nik_lama'] ?></small>
											<?php endif; ?>
										</td>
										<td <?= isset($m['diff']['nama']) ? 'style="background-color: #fff3cd;"' : '' ?>>
											<?= $m['nama'] ?>
											<?php if (isset($m['diff']['nama'])): ?>
												<br><small class="text-danger"><i>(Lama: <?= $m['diff']['nama'] ?>)</i></small>
											<?php endif; ?>
										</td>
										<td <?= isset($m['diff']['sex']) ? 'style="background-color: #fff3cd;"' : '' ?>>
											<?= $m['sex'] ?>
											<?php if (isset($m['diff']['sex'])): ?>
												<br><small class="text-danger"><i>(Lama: <?= $m['diff']['sex'] ?>)</i></small>
											<?php endif; ?>
										</td>
										<td <?= (isset($m['diff']['tempatlahir']) || isset($m['diff']['tanggallahir'])) ? 'style="background-color: #fff3cd;"' : '' ?>>
											<?= $m['tempatlahir'] ?>, <?= $m['tanggallahir'] ? tgl_indo($m['tanggallahir']) : '-' ?>
											<?php if (isset($m['diff']['tempatlahir']) || isset($m['diff']['tanggallahir'])): ?>
												<br><small class="text-danger"><i>(Lama: <?= $m['diff']['tempatlahir'] ?? '' ?>, <?= isset($m['diff']['tanggallahir']) ? tgl_indo($m['diff']['tanggallahir']) : '' ?>)</i></small>
											<?php endif; ?>
										</td>
										<td <?= isset($m['diff']['agama']) ? 'style="background-color: #fff3cd;"' : '' ?>>
											<?= $m['agama'] ?? '-' ?>
											<?php if (isset($m['diff']['agama'])): ?>
												<br><small class="text-danger"><i>(Lama: <?= $m['diff']['agama'] ?>)</i></small>
											<?php endif; ?>
										</td>
										<td <?= (isset($m['diff']['status_kawin']) || isset($m['diff']['tanggalperkawinan'])) ? 'style="background-color: #fff3cd;"' : '' ?>>
											<?= !empty($m['status_kawin']) ? $m['status_kawin'] : '-' ?>
											<?php if (!empty($m['tanggalperkawinan'])): ?>
												<br><small class="text-muted"><i class="fa fa-calendar"></i> Tgl: <?= tgl_indo($m['tanggalperkawinan']) ?></small>
											<?php endif; ?>
											<?php if (isset($m['diff']['status_kawin']) || isset($m['diff']['tanggalperkawinan'])): ?>
												<br><small class="text-danger"><i>(Lama: <?= $m['diff']['status_kawin'] ?? '' ?><?= !empty($m['diff']['tanggalperkawinan']) ? ' - Tgl: ' . tgl_indo($m['diff']['tanggalperkawinan']) : '' ?>)</i></small>
											<?php endif; ?>
										</td>
										<td <?= isset($m['diff']['golongan_darah']) ? 'style="background-color: #fff3cd;"' : '' ?>>
											<?= $m['golongan_darah'] ?? '-' ?>
											<?php if (isset($m['diff']['golongan_darah'])): ?>
												<br><small class="text-danger"><i>(Lama: <?= $m['diff']['golongan_darah'] ?>)</i></small>
											<?php endif; ?>
										</td>
										<td <?= isset($m['diff']['pendidikan']) ? 'style="background-color: #fff3cd;"' : '' ?>>
											<?= $m['pendidikan'] ?>
											<?php if (isset($m['diff']['pendidikan'])): ?>
												<br><small class="text-danger"><i>(Lama: <?= $m['diff']['pendidikan'] ?>)</i></small>
											<?php endif; ?>
										</td>
										<td <?= isset($m['diff']['pekerjaan']) ? 'style="background-color: #fff3cd;"' : '' ?>>
											<?= $m['pekerjaan'] ?>
											<?php if (isset($m['diff']['pekerjaan'])): ?>
												<br><small class="text-danger"><i>(Lama: <?= $m['diff']['pekerjaan'] ?>)</i></small>
											<?php endif; ?>
										</td>
										<td <?= isset($m['diff']['hubungan']) ? 'style="background-color: #fff3cd;"' : '' ?>>
											<span class="label label-info"><?= $m['hubungan'] ?></span>
											<?php if (isset($m['diff']['hubungan'])): ?>
												<br><small class="text-danger"><i>(Lama: <?= $m['diff']['hubungan'] ?>)</i></small>
											<?php endif; ?>
										</td>
										<td><?= ($m['nama_ayah'] ?: '-') ?> / <?= ($m['nama_ibu'] ?: '-') ?></td>
										<td>
											<?php if (empty($m['db_exists']) || (!empty($m['status_dasar']) && $m['status_dasar'] != 1)): ?>
												<input type="text" name="alamat_sebelumnya[<?= $m['nik'] ?>]" class="form-control input-sm" placeholder="Alamat asal sebelumnya..." value="<?= html_escape(!empty($m['alamat_sebelumnya']) ? $m['alamat_sebelumnya'] : $parsed['header']['alamat']) ?>" style="min-width: 150px;">
											<?php else: ?>
												<span class="text-muted"><i class="fa fa-check"></i> Data DB</span>
											<?php endif; ?>
										</td>
									</tr>
								<?php endforeach; ?>
							</tbody>
						</table>
					</div>
				</div>
				<div class="box-footer">
					<a href="<?= site_url('keluarga') ?>" class="btn btn-default btn-sm"><i class="fa fa-times"></i> Batal</a>
					<button type="submit" class="btn btn-success btn-sm pull-right"><i class="fa fa-save"></i> Simpan ke Database</button>
				</div>
			</div>
		</form>
	</section>
</div>
