<?php

defined('BASEPATH') || exit('No direct script access allowed');

/*
 * File ini:
 *
 * View Log Bulanan Detail untuk modul Statistik > Log Bulanan
 *
 * donjo-app/views/laporan/tabel_bulanan_detil.php
 */
?>

<div class="content-wrapper">
	<section class="content-header">
		<h1>Rincian Kependudukan Bulanan</h1>
		<ol class="breadcrumb">
			<li><a href="<?= site_url('hom_sid')?>"><i class="fa fa-home"></i> Home</a></li>
			<li><a href="<?= site_url('laporan/clear')?>"> Laporan Kependudukan Bulanan</a></li>
			<li class="active">Rincian Kependudukan Bulanan</li>
		</ol>
	</section>
	<section class="content" id="maincontent">
		<div class="row">
			<div class="col-md-12">
				<div class="box box-info">
					<div class="box-header with-border">
						<div class="row">
							<div class="col-sm-12">
								<a href="<?= site_url('laporan')?>" class="btn btn-social btn-flat bg-maroon btn-sm"><i class="fa fa-arrow-circle-left"></i> Kembali Ke Laporan Bulanan</a>
								<a href="<?= site_url("laporan/cetak_detail_penduduk/{$rincian}/{$tipe}")?>" target="_blank" class="btn btn-social btn-flat bg-purple btn-sm"><i class="fa fa-print"></i> Cetak</a>
								<a href="<?= site_url("laporan/unduh_detail_penduduk/{$rincian}/{$tipe}")?>" class="btn btn-social btn-flat bg-navy btn-sm"><i class="fa fa-download"></i> Unduh Excel</a>
							</div>
						</div>
					</div>
					<div class="box-body">
						<div class="row">
							<div class="col-sm-12">
								<h4 class="text-center" style="margin-top: 5px; margin-bottom: 5px;"><strong>PEMERINTAH KABUPATEN/KOTA <?= strtoupper($config['nama_kabupaten'] ?? '')?></strong></h4>
								<h5 class="text-center" style="margin-top: 0px; margin-bottom: 20px;"><strong>RINCIAN LAPORAN PERKEMBANGAN <?= $title ?></strong></h5>

								<div class="callout callout-info" style="padding: 8px 15px; margin-bottom: 15px;">
									<strong>Periode:</strong> <?= strtoupper(getBulan($bulan)) . ' ' . $tahun ?> &nbsp;|&nbsp;
									<strong>Total Data:</strong> <span class="badge bg-green"><?= count($main); ?> Baris</span>
								</div>

								<div class="table-responsive">
									<table class="table table-bordered table-striped table-hover dataTable" id="tabel-rincian">
										<thead class="bg-gray disabled color-palette">
											<tr>
												<th class="text-center" style="width: 40px;">No</th>
												<?php if ($is_keluarga): ?>
													<th class="text-center">No. KK</th>
													<th>Nama Kepala Keluarga</th>
													<th>NIK Kepala Keluarga</th>
													<th class="text-center">L/P</th>
													<th>Alamat / Dusun / RT / RW</th>
													<th class="text-center">Jml Anggota</th>
													<?php if (in_array($rincian, ['lahir', 'mati', 'pindah', 'datang'])): ?>
														<th class="text-center">Tgl Peristiwa</th>
													<?php endif; ?>
												<?php elseif ($rincian == 'mati'): ?>
													<th class="text-center">Tgl Meninggal</th>
													<th>NIK</th>
													<th>Nama Penduduk</th>
													<th class="text-center">L/P</th>
													<th class="text-center">Umur</th>
													<th>Alamat / Dusun / RT / RW</th>
													<th>Tempat Meninggal</th>
													<th>Penyebab Kematian</th>
													<th>No. Akta Mati</th>
												<?php elseif ($rincian == 'pindah'): ?>
													<th class="text-center">Tgl Pindah</th>
													<th>NIK</th>
													<th>Nama Penduduk</th>
													<th class="text-center">L/P</th>
													<th class="text-center">Umur</th>
													<th>Alamat Asal</th>
													<th>Alamat Tujuan Pindah</th>
													<th>Alasan Pindah</th>
												<?php elseif ($rincian == 'datang'): ?>
													<th class="text-center">Tgl Datang</th>
													<th>NIK</th>
													<th>Nama Penduduk</th>
													<th class="text-center">L/P</th>
													<th class="text-center">Umur</th>
													<th>Alamat Asal</th>
													<th>Alamat / Dusun / RT / RW Tujuan</th>
												<?php elseif ($rincian == 'lahir'): ?>
													<th class="text-center">Tgl Lahir</th>
													<th>NIK</th>
													<th>Nama Bayi</th>
													<th class="text-center">L/P</th>
													<th>Tempat Lahir</th>
													<th>Nama Ayah</th>
													<th>Nama Ibu</th>
													<th>Alamat / Dusun / RT / RW</th>
												<?php else: ?>
													<th>NIK</th>
													<th>Nama Penduduk</th>
													<th class="text-center">L/P</th>
													<th>Tempat, Tgl Lahir</th>
													<th class="text-center">Umur</th>
													<th>No. KK</th>
													<th>Alamat / Dusun / RT / RW</th>
													<th>Nama Ayah / Ibu</th>
												<?php endif; ?>
											</tr>
										</thead>
										<tbody>
										<?php if (empty($main)): ?>
											<tr>
												<td colspan="10" class="text-center text-muted">Tidak ada data untuk rincian periode ini.</td>
											</tr>
										<?php else: ?>
											<?php foreach ($main as $key => $data): ?>
												<tr>
													<td class="text-center"><?= $key + 1; ?></td>

													<?php if ($is_keluarga): ?>
														<td class="text-center">
															<?php if (! empty($data['id_kk'])): ?>
																<a href="<?= site_url('keluarga/kartu_keluarga/1/0/' . $data['id_kk']); ?>" target="_blank" title="Lihat Kartu Keluarga">
																	<strong><?= $data['no_kk'] ?: '-'; ?></strong> <i class="fa fa-external-link text-xs"></i>
																</a>
															<?php else: ?>
																<?= $data['no_kk'] ?: '-'; ?>
															<?php endif; ?>
														</td>
														<td>
															<?php if (! empty($data['id_pend']) || ! empty($data['id'])): ?>
																<a href="<?= site_url('penduduk/detail/1/0/' . ($data['id_pend'] ?? $data['id'])); ?>" target="_blank" title="Lihat Detail Penduduk">
																	<?= strtoupper($data['nama'] ?? $data['nama_kepala'] ?? '-'); ?>
																</a>
															<?php else: ?>
																<?= strtoupper($data['nama'] ?? $data['nama_kepala'] ?? '-'); ?>
															<?php endif; ?>
														</td>
														<td><?= $data['nik'] ?? $data['nik_kepala'] ?? '-'; ?></td>
														<td class="text-center"><?= ($data['sex'] == 1) ? 'L' : (($data['sex'] == 2) ? 'P' : '-'); ?></td>
														<td>
															<?= $data['alamat_kk'] ?? $data['alamat'] ?? ''; ?>
															<?= ! empty($data['dusun']) && $data['dusun'] != '-' ? ' Dusun ' . $data['dusun'] : ''; ?>
															<?= ! empty($data['rw']) && $data['rw'] != '-' ? ' RW ' . $data['rw'] : ''; ?>
															<?= ! empty($data['rt']) && $data['rt'] != '-' ? ' RT ' . $data['rt'] : ''; ?>
														</td>
														<td class="text-center"><span class="badge bg-blue"><?= $data['jml_anggota'] ?? 0; ?> Jiwa</span></td>
														<?php if (in_array($rincian, ['lahir', 'mati', 'pindah', 'datang'])): ?>
															<td class="text-center"><?= ! empty($data['tgl_peristiwa']) ? tgl_indo_out($data['tgl_peristiwa']) : '-'; ?></td>
														<?php endif; ?>

													<?php elseif ($rincian == 'mati'): ?>
														<td class="text-center"><strong><?= ! empty($data['tgl_peristiwa']) ? tgl_indo_out($data['tgl_peristiwa']) : '-'; ?></strong></td>
														<td>
															<a href="<?= site_url('penduduk/detail/1/0/' . $data['id']); ?>" target="_blank">
																<?= $data['nik']; ?> <i class="fa fa-external-link text-xs"></i>
															</a>
														</td>
														<td><?= strtoupper($data['nama']); ?></td>
														<td class="text-center"><?= ($data['sex'] == 1) ? 'L' : (($data['sex'] == 2) ? 'P' : '-'); ?></td>
														<td class="text-center"><?= $data['umur'] !== '-' ? $data['umur'] . ' Thn' : '-'; ?></td>
														<td>
															<?= $data['alamat_sekarang'] ?? ''; ?>
															<?= ! empty($data['dusun']) && $data['dusun'] != '-' ? ' Dsn ' . $data['dusun'] : ''; ?>
															<?= ! empty($data['rw']) && $data['rw'] != '-' ? ' RW ' . $data['rw'] : ''; ?>
															<?= ! empty($data['rt']) && $data['rt'] != '-' ? ' RT ' . $data['rt'] : ''; ?>
														</td>
														<td><?= $data['meninggal_di'] ?: '-'; ?></td>
														<td><?= $data['sebab_nama'] ?? $data['sebab'] ?? '-'; ?></td>
														<td><?= $data['akta_mati'] ?: '-'; ?></td>

													<?php elseif ($rincian == 'pindah'): ?>
														<td class="text-center"><strong><?= ! empty($data['tgl_peristiwa']) ? tgl_indo_out($data['tgl_peristiwa']) : '-'; ?></strong></td>
														<td>
															<a href="<?= site_url('penduduk/detail/1/0/' . $data['id']); ?>" target="_blank">
																<?= $data['nik']; ?> <i class="fa fa-external-link text-xs"></i>
															</a>
														</td>
														<td><?= strtoupper($data['nama']); ?></td>
														<td class="text-center"><?= ($data['sex'] == 1) ? 'L' : (($data['sex'] == 2) ? 'P' : '-'); ?></td>
														<td class="text-center"><?= $data['umur'] !== '-' ? $data['umur'] . ' Thn' : '-'; ?></td>
														<td>
															<?= ! empty($data['dusun']) && $data['dusun'] != '-' ? 'Dsn ' . $data['dusun'] : ''; ?>
															<?= ! empty($data['rw']) && $data['rw'] != '-' ? ' RW ' . $data['rw'] : ''; ?>
															<?= ! empty($data['rt']) && $data['rt'] != '-' ? ' RT ' . $data['rt'] : ''; ?>
														</td>
														<td><?= $data['alamat_tujuan'] ?: ($data['catatan_log'] ?: '-'); ?></td>
														<td><?= $data['alasan_pindah'] ?: '-'; ?></td>

													<?php elseif ($rincian == 'datang'): ?>
														<td class="text-center"><strong><?= ! empty($data['tgl_peristiwa']) ? tgl_indo_out($data['tgl_peristiwa']) : (! empty($data['tgl_lapor']) ? tgl_indo_out($data['tgl_lapor']) : '-'); ?></strong></td>
														<td>
															<a href="<?= site_url('penduduk/detail/1/0/' . $data['id']); ?>" target="_blank">
																<?= $data['nik']; ?> <i class="fa fa-external-link text-xs"></i>
															</a>
														</td>
														<td><?= strtoupper($data['nama']); ?></td>
														<td class="text-center"><?= ($data['sex'] == 1) ? 'L' : (($data['sex'] == 2) ? 'P' : '-'); ?></td>
														<td class="text-center"><?= $data['umur'] !== '-' ? $data['umur'] . ' Thn' : '-'; ?></td>
														<td><?= $data['catatan_log'] ?: '-'; ?></td>
														<td>
															<?= $data['alamat_sekarang'] ?? ''; ?>
															<?= ! empty($data['dusun']) && $data['dusun'] != '-' ? ' Dsn ' . $data['dusun'] : ''; ?>
															<?= ! empty($data['rw']) && $data['rw'] != '-' ? ' RW ' . $data['rw'] : ''; ?>
															<?= ! empty($data['rt']) && $data['rt'] != '-' ? ' RT ' . $data['rt'] : ''; ?>
														</td>

													<?php elseif ($rincian == 'lahir'): ?>
														<td class="text-center"><strong><?= ! empty($data['tanggallahir']) ? tgl_indo_out($data['tanggallahir']) : '-'; ?></strong></td>
														<td>
															<a href="<?= site_url('penduduk/detail/1/0/' . $data['id']); ?>" target="_blank">
																<?= $data['nik']; ?> <i class="fa fa-external-link text-xs"></i>
															</a>
														</td>
														<td><?= strtoupper($data['nama']); ?></td>
														<td class="text-center"><?= ($data['sex'] == 1) ? 'L' : (($data['sex'] == 2) ? 'P' : '-'); ?></td>
														<td><?= $data['tempatlahir'] ?: '-'; ?></td>
														<td><?= strtoupper($data['nama_ayah'] ?: '-'); ?></td>
														<td><?= strtoupper($data['nama_ibu'] ?: '-'); ?></td>
														<td>
															<?= ! empty($data['dusun']) && $data['dusun'] != '-' ? 'Dsn ' . $data['dusun'] : ''; ?>
															<?= ! empty($data['rw']) && $data['rw'] != '-' ? ' RW ' . $data['rw'] : ''; ?>
															<?= ! empty($data['rt']) && $data['rt'] != '-' ? ' RT ' . $data['rt'] : ''; ?>
														</td>

													<?php else: ?>
														<td>
															<a href="<?= site_url('penduduk/detail/1/0/' . $data['id']); ?>" target="_blank">
																<?= $data['nik']; ?> <i class="fa fa-external-link text-xs"></i>
															</a>
														</td>
														<td><?= strtoupper($data['nama']); ?></td>
														<td class="text-center"><?= ($data['sex'] == 1) ? 'L' : (($data['sex'] == 2) ? 'P' : '-'); ?></td>
														<td><?= ($data['tempatlahir'] ?: '-') . ', ' . (! empty($data['tanggallahir']) ? tgl_indo_out($data['tanggallahir']) : '-'); ?></td>
														<td class="text-center"><?= $data['umur'] !== '-' ? $data['umur'] . ' Thn' : '-'; ?></td>
														<td class="text-center">
															<?php if (! empty($data['id_kk'])): ?>
																<a href="<?= site_url('keluarga/kartu_keluarga/1/0/' . $data['id_kk']); ?>" target="_blank">
																	<?= $data['no_kk'] ?: '-'; ?>
																</a>
															<?php else: ?>
																<?= $data['no_kk'] ?: '-'; ?>
															<?php endif; ?>
														</td>
														<td>
															<?= ! empty($data['dusun']) && $data['dusun'] != '-' ? 'Dsn ' . $data['dusun'] : ''; ?>
															<?= ! empty($data['rw']) && $data['rw'] != '-' ? ' RW ' . $data['rw'] : ''; ?>
															<?= ! empty($data['rt']) && $data['rt'] != '-' ? ' RT ' . $data['rt'] : ''; ?>
														</td>
														<td><?= ($data['nama_ayah'] ?: '-') . ' / ' . ($data['nama_ibu'] ?: '-'); ?></td>
													<?php endif; ?>
												</tr>
											<?php endforeach; ?>
										<?php endif; ?>
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
</div>
