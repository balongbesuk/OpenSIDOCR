<style type="text/css">
	.box-header-pendapat {
		display: flex !important;
		justify-content: space-between !important;
		align-items: center !important;
		flex-wrap: wrap !important;
		gap: 10px !important;
	}
	.box-header-pendapat::before,
	.box-header-pendapat::after {
		display: none !important;
	}
	.box-header-pendapat .box-title {
		margin: 0 !important;
		line-height: 1.4 !important;
		flex: 1 1 240px !important;
		font-size: 17px !important;
	}
	.box-header-pendapat .box-tools {
		position: static !important;
		float: none !important;
		margin: 0 0 0 auto !important;
	}
	.box-header-pendapat .box-tools .btn-group {
		display: inline-block !important;
		width: auto !important;
		margin: 0 !important;
	}
</style>

<div class="content-wrapper">
	<section class="content-header">
		<h1>Pendapat</h1>
		<ol class="breadcrumb">
			<li><a href="<?= site_url('hom_sid') ?>"><i class="fa fa-home"></i> Home</a></li>
			<li class="active">Pendapat</li>
		</ol>
	</section>
	<section class="content" id="maincontent">
		<div class="box box-info">
			<div class="box-header with-border box-header-pendapat">
				<h3 class="box-title"><strong>Tingkat Kepuasan Pengguna Layanan Mandiri</strong></h3>
				<div class="box-tools">
					<div class="btn-group">
						<button type="button" class="btn btn-social btn-primary btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							<i class="fa fa-calendar"></i> Periode <span class="caret"></span>
						</button>
						<ul class="dropdown-menu dropdown-menu-right" role="menu">
							<li class="<?= ($tipe == 1) ? 'active' : '' ?>"><a href="<?= site_url('pendapat/detail/1'); ?>">Hari Ini</a></li>
							<li class="<?= ($tipe == 2) ? 'active' : '' ?>"><a href="<?= site_url('pendapat/detail/2'); ?>">Kemarin</a></li>
							<li class="<?= ($tipe == 3) ? 'active' : '' ?>"><a href="<?= site_url('pendapat/detail/3'); ?>">Minggu Ini</a></li>
							<li class="<?= ($tipe == 4) ? 'active' : '' ?>"><a href="<?= site_url('pendapat/detail/4'); ?>">Bulan Ini</a></li>
							<li class="<?= ($tipe == 5) ? 'active' : '' ?>"><a href="<?= site_url('pendapat/detail/5'); ?>">Tahun Ini</a></li>
							<li class="<?= ($tipe == 6) ? 'active' : '' ?>"><a href="<?= site_url('pendapat/detail/6'); ?>">Semua</a></li>
						</ul>
					</div>
				</div>
			</div>
			<div class="box-body">
				<p class="text-muted" style="margin-bottom: 15px; font-size: 13px;">
					<i class="fa fa-info-circle text-blue"></i> Periode Data: <strong><?= $main['judul']; ?></strong> &bull; Total Responden: <strong><?= $main['total']; ?></strong> orang
				</p>
				<div class="row">
					<div class="col-md-12">
						<div style="display: flex; flex-wrap: wrap; justify-content: center; gap: 15px; margin: 5px 0 20px 0;">
							<?php foreach ($list_pendapat as $key => $value) : ?>
								<?php $key_var = "pilihan_{$key}"; ?>
								<div style="flex: 1 1 130px; max-width: 200px; min-width: 125px; text-align: center; padding: 16px 12px; background: #ffffff; border: 1px solid #e2e8f0; border-radius: 12px; box-shadow: 0 1px 3px rgba(0,0,0,0.06);">
									<!-- Emotikon SVG Layanan Mandiri (Presisi & Tajam) -->
									<div style="width: 56px; height: 56px; margin: 0 auto 10px auto; display: flex; align-items: center; justify-content: center;">
										<?php if ($key == 1) : ?>
											<!-- 1: Sangat Puas (Radiant Beaming Joy) -->
											<svg style="width: 100%; height: 100%;" viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg">
												<defs>
													<radialGradient id="grad-sp" cx="35%" cy="30%" r="65%">
														<stop offset="0%" stop-color="#FEF08A" />
														<stop offset="100%" stop-color="#F59E0B" />
													</radialGradient>
												</defs>
												<circle cx="32" cy="32" r="28" fill="url(#grad-sp)" />
												<ellipse cx="14" cy="37" rx="5" ry="3" fill="#FB7185" fill-opacity="0.6" />
												<ellipse cx="50" cy="37" rx="5" ry="3" fill="#FB7185" fill-opacity="0.6" />
												<path d="M18 27 Q22 20 26 27" stroke="#78350F" stroke-width="3.2" stroke-linecap="round" fill="none" />
												<path d="M38 27 Q42 20 46 27" stroke="#78350F" stroke-width="3.2" stroke-linecap="round" fill="none" />
												<path d="M19 34 C19 46 45 46 45 34 Z" fill="#78350F" />
												<path d="M22 34 C25 38 39 38 42 34 Z" fill="#FFFFFF" />
												<path d="M26 41 C28 45 36 45 38 41 Z" fill="#FB7185" />
											</svg>

										<?php elseif ($key == 2) : ?>
											<!-- 2: Puas (Warm Cheerful Smile) -->
											<svg style="width: 100%; height: 100%;" viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg">
												<defs>
													<radialGradient id="grad-p" cx="35%" cy="30%" r="65%">
														<stop offset="0%" stop-color="#FEF9C3" />
														<stop offset="100%" stop-color="#FBBF24" />
													</radialGradient>
												</defs>
												<circle cx="32" cy="32" r="28" fill="url(#grad-p)" />
												<ellipse cx="15" cy="37" rx="4" ry="2.5" fill="#FB923C" fill-opacity="0.45" />
												<ellipse cx="49" cy="37" rx="4" ry="2.5" fill="#FB923C" fill-opacity="0.45" />
												<ellipse cx="22" cy="27" rx="3.5" ry="4.5" fill="#78350F" />
												<ellipse cx="42" cy="27" rx="3.5" ry="4.5" fill="#78350F" />
												<circle cx="21" cy="25.5" r="1.3" fill="#FFFFFF" />
												<circle cx="41" cy="25.5" r="1.3" fill="#FFFFFF" />
												<path d="M20 35 Q32 46 44 35" stroke="#78350F" stroke-width="3.4" stroke-linecap="round" fill="none" />
											</svg>

										<?php elseif ($key == 3) : ?>
											<!-- 3: Cukup (Calm Neutral Expression) -->
											<svg style="width: 100%; height: 100%;" viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg">
												<defs>
													<radialGradient id="grad-c" cx="35%" cy="30%" r="65%">
														<stop offset="0%" stop-color="#FEF08A" />
														<stop offset="100%" stop-color="#F59E0B" />
													</radialGradient>
												</defs>
												<circle cx="32" cy="32" r="28" fill="url(#grad-c)" />
												<ellipse cx="22" cy="28" rx="3.5" ry="4.5" fill="#78350F" />
												<ellipse cx="42" cy="28" rx="3.5" ry="4.5" fill="#78350F" />
												<circle cx="21" cy="26.5" r="1.2" fill="#FFFFFF" />
												<circle cx="41" cy="26.5" r="1.2" fill="#FFFFFF" />
												<line x1="22" y1="39" x2="42" y2="39" stroke="#78350F" stroke-width="3.5" stroke-linecap="round" />
											</svg>

										<?php else : ?>
											<!-- 4: Buruk (Disappointed / Frown Expression) -->
											<svg style="width: 100%; height: 100%;" viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg">
												<defs>
													<radialGradient id="grad-b" cx="35%" cy="30%" r="65%">
														<stop offset="0%" stop-color="#FECDD3" />
														<stop offset="100%" stop-color="#FB7185" />
													</radialGradient>
												</defs>
												<circle cx="32" cy="32" r="28" fill="url(#grad-b)" />
												<path d="M17 22 L26 25" stroke="#881337" stroke-width="2.6" stroke-linecap="round" />
												<path d="M47 22 L38 25" stroke="#881337" stroke-width="2.6" stroke-linecap="round" />
												<ellipse cx="22" cy="29" rx="3.2" ry="4" fill="#881337" />
												<ellipse cx="42" cy="29" rx="3.2" ry="4" fill="#881337" />
												<path d="M21 42 Q32 34 43 42" stroke="#881337" stroke-width="3.4" stroke-linecap="round" fill="none" />
											</svg>
										<?php endif; ?>
									</div>
									<h4 style="margin: 0 0 4px 0; font-weight: 700; font-size: 18px; color: #1e293b;"><?= !empty($main['total']) ? persen(${$key_var} / $main['total']) : '0%'; ?></h4>
									<span style="display: block; font-size: 13px; font-weight: 600; color: #475569;"><?= $value; ?></span>
									<small class="text-muted" style="font-size: 11px;">(<?= ${$key_var}; ?> suara)</small>
								</div>
							<?php endforeach; ?>
						</div>
					</div>
				</div>

				<h4 class="text-center text-bold" style="margin: 25px 0 15px 0; font-size: 14.5px; letter-spacing: 0.5px; color: #334155; border-top: 1px solid #e2e8f0; padding-top: 18px;">
					<i class="fa fa-bar-chart" style="margin-right: 5px;"></i> GRAFIK &amp; TABEL RINCIAN
				</h4>

				<div class="row">
					<div class="col-md-6" style="margin-bottom: 20px;">
						<div id="chart" style="min-width: 100%; height: 350px;"></div>
					</div>
					<div class="col-md-6">
						<div class="table-responsive">
							<table class="table table-bordered table-striped table-hover tabel-daftar" id="tabel-data">
								<thead class="bg-gray disabled color-palette">
									<tr>
										<th class="padat">No</th>
										<th>Pengguna</th>
										<th class="padat">Tanggal</th>
										<th class="padat">Pendapat</th>
									</tr>
								</thead>
								<tbody>
									<?php if ($detail) : ?>
										<?php
											$badge_color = [
												1 => 'label-success',
												2 => 'label-primary',
												3 => 'label-warning',
												4 => 'label-danger',
											];
										?>
										<?php foreach ($detail as $key => $item) : ?>
											<tr>
												<td class="padat"><?= ($key + 1); ?></td>
												<td>
													<a href="<?= site_url('penduduk/detail/1/0/' . $item['pengguna']) ?>"><strong><?= $item['nama']; ?></strong></a>
												</td>
												<td class="padat"><?= tgl_indo2($item['tanggal']); ?></td>
												<td class="padat">
													<span class="label <?= $badge_color[$item['pilihan']] ?? 'label-info'; ?>" style="font-size: 11px; padding: 3px 8px;">
														<?= $list_pendapat[$item['pilihan']]; ?>
													</span>
												</td>
											</tr>
										<?php endforeach; ?>
									<?php else : ?>
										<tr>
											<td class="text-center" colspan="4">Data Tidak Tersedia</td>
										</tr>
									<?php endif; ?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
</div>

<script src="<?= base_url() ?>assets/js/highcharts/exporting.js"></script>
<script src="<?= base_url() ?>assets/js/highcharts/highcharts-more.js"></script>

<script type="text/javascript">
	var chart;
	$(document).ready(function() {
		chart = new Highcharts.Chart({
			chart: {
				renderTo: 'chart',
				defaultSeriesType: 'column'
			},
			colors: ['#10b981', '#0ea5e9', '#f59e0b', '#f43f5e'],
			title: {
				text: ''
			},
			xAxis: {
				title: {
					text: '<b>Pilihan</b>'
				},
				categories: [
					<?php foreach ($list_pendapat as $key => $value) : ?>['<?= $value; ?>'],
					<?php endforeach; ?>
				]
			},
			yAxis: {
				title: {
					text: 'Pengguna (Orang)'
				}
			},
			legend: {
				layout: 'vertical',
				enabled: false
			},
			plotOptions: {
				series: {
					colorByPoint: true
				},
				column: {
					pointPadding: 0,
					borderWidth: 0
				}
			},
			series: [{
				shadow: 1,
				border: 1,
				data: [
					<?php foreach ($list_pendapat as $key => $value) : ?>
						<?php $jml = "pilihan_{$key}"; ?>['<?= $key; ?>', <?= ${$jml}; ?>],
					<?php endforeach; ?>
				]
			}]
		});

		$('#tabel-data').DataTable({
			'processing': true,
			'pageLength': 10,
			'order': [],
			'columnDefs': [{
					'searchable': false,
					'targets': 0
				},
				{
					'orderable': false,
					'targets': 0
				}
			],
			'language': {
				'url': BASE_URL + '/assets/bootstrap/js/dataTables.indonesian.lang'
			},
		});
	});
</script>
