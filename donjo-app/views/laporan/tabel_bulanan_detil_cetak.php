<?php

defined('BASEPATH') || exit('No direct script access allowed');

/*
 * File ini:
 *
 * View Cetak & Unduh Excel Rincian Laporan Bulanan
 *
 * donjo-app/views/laporan/tabel_bulanan_detil_cetak.php
 */

if ($aksi == 'unduh') {
    header('Content-type: application/octet-stream');
    header('Content-Disposition: attachment; filename=rincian_laporan_' . $rincian . '_' . $tipe . '_' . $bulan . '_' . $tahun . '.xls');
    header('Pragma: no-cache');
    header('Expires: 0');
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>Rincian Perkembangan <?= $title; ?></title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<style type="text/css">
		body {
			font-family: Arial, Helvetica, sans-serif;
			font-size: 11px;
			color: #000;
			background: #fff;
			margin: 10px;
		}
		.text-center { text-align: center; }
		.text-right { text-align: right; }
		.text-bold { font-weight: bold; }
		.judul-1 { font-size: 13pt; font-weight: bold; margin: 0; text-align: center; }
		.judul-2 { font-size: 11pt; font-weight: bold; margin: 5px 0 15px 0; text-align: center; }
		table.border {
			width: 100%;
			border-collapse: collapse;
			margin-top: 10px;
		}
		table.border th, table.border td {
			border: 1px solid #333;
			padding: 5px 7px;
		}
		table.border th {
			background-color: #eee;
		}
		.identitas-tabel {
			margin-bottom: 8px;
			font-size: 11px;
		}
		@media print {
			@page { size: landscape; margin: 10mm; }
		}
	</style>
</head>
<body <?= ($aksi == 'cetak') ? 'onload="window.print()"' : ''; ?>>

	<div class="judul-1">PEMERINTAH KABUPATEN/KOTA <?= strtoupper($config['nama_kabupaten'] ?? '')?></div>
	<div class="judul-2">RINCIAN LAPORAN PERKEMBANGAN <?= $title ?></div>

	<table class="identitas-tabel">
		<tr>
			<td style="width: 120px; font-weight: bold;">Desa/Kelurahan</td>
			<td style="width: 10px;">:</td>
			<td><?= $config['nama_desa'] ?? '-'; ?></td>
			<td style="width: 100px; font-weight: bold;">Kecamatan</td>
			<td style="width: 10px;">:</td>
			<td><?= $config['nama_kecamatan'] ?? '-'; ?></td>
		</tr>
		<tr>
			<td style="font-weight: bold;">Periode</td>
			<td>:</td>
			<td><?= strtoupper(getBulan($bulan)) . ' ' . $tahun; ?></td>
			<td style="font-weight: bold;">Total Data</td>
			<td>:</td>
			<td><?= count($main); ?> Jiwa/Keluarga</td>
		</tr>
	</table>

	<table class="border">
		<thead>
			<tr>
				<th class="text-center" style="width: 30px;">No</th>
				<?php if ($is_keluarga): ?>
					<th class="text-center">No. KK</th>
					<th>Nama Kepala Keluarga</th>
					<th class="text-center">NIK Kepala Keluarga</th>
					<th class="text-center">L/P</th>
					<th>Alamat / Wilayah</th>
					<th class="text-center">Jml Anggota</th>
					<?php if (in_array($rincian, ['lahir', 'mati', 'pindah', 'datang'])): ?>
						<th class="text-center">Tgl Peristiwa</th>
					<?php endif; ?>
				<?php elseif ($rincian == 'mati'): ?>
					<th class="text-center">Tgl Meninggal</th>
					<th class="text-center">NIK</th>
					<th>Nama Penduduk</th>
					<th class="text-center">L/P</th>
					<th class="text-center">Umur</th>
					<th>Alamat / Wilayah</th>
					<th>Tempat Meninggal</th>
					<th>Penyebab Kematian</th>
					<th class="text-center">No. Akta Mati</th>
				<?php elseif ($rincian == 'pindah'): ?>
					<th class="text-center">Tgl Pindah</th>
					<th class="text-center">NIK</th>
					<th>Nama Penduduk</th>
					<th class="text-center">L/P</th>
					<th class="text-center">Umur</th>
					<th>Alamat Asal</th>
					<th>Alamat Tujuan Pindah</th>
					<th>Alasan Pindah</th>
				<?php elseif ($rincian == 'datang'): ?>
					<th class="text-center">Tgl Datang</th>
					<th class="text-center">NIK</th>
					<th>Nama Penduduk</th>
					<th class="text-center">L/P</th>
					<th class="text-center">Umur</th>
					<th>Alamat Asal</th>
					<th>Alamat Tujuan di Desa</th>
				<?php elseif ($rincian == 'lahir'): ?>
					<th class="text-center">Tgl Lahir</th>
					<th class="text-center">NIK</th>
					<th>Nama Bayi</th>
					<th class="text-center">L/P</th>
					<th>Tempat Lahir</th>
					<th>Nama Ayah</th>
					<th>Nama Ibu</th>
					<th>Alamat / Wilayah</th>
				<?php else: ?>
					<th class="text-center">NIK</th>
					<th>Nama Penduduk</th>
					<th class="text-center">L/P</th>
					<th>Tempat, Tgl Lahir</th>
					<th class="text-center">Umur</th>
					<th class="text-center">No. KK</th>
					<th>Alamat / Wilayah</th>
					<th>Nama Ayah / Ibu</th>
				<?php endif; ?>
			</tr>
		</thead>
		<tbody>
		<?php if (empty($main)): ?>
			<tr>
				<td colspan="10" class="text-center">Tidak ada data.</td>
			</tr>
		<?php else: ?>
			<?php foreach ($main as $key => $data): ?>
				<tr>
					<td class="text-center"><?= $key + 1; ?></td>

					<?php if ($is_keluarga): ?>
						<td class="text-center" style="mso-number-format:'\@';"><?= $data['no_kk'] ?: '-'; ?></td>
						<td><?= strtoupper($data['nama'] ?? $data['nama_kepala'] ?? '-'); ?></td>
						<td class="text-center" style="mso-number-format:'\@';"><?= $data['nik'] ?? $data['nik_kepala'] ?? '-'; ?></td>
						<td class="text-center"><?= ($data['sex'] == 1) ? 'L' : (($data['sex'] == 2) ? 'P' : '-'); ?></td>
						<td>
							<?= $data['alamat_kk'] ?? $data['alamat'] ?? ''; ?>
							<?= ! empty($data['dusun']) && $data['dusun'] != '-' ? ' Dsn ' . $data['dusun'] : ''; ?>
							<?= ! empty($data['rw']) && $data['rw'] != '-' ? ' RW ' . $data['rw'] : ''; ?>
							<?= ! empty($data['rt']) && $data['rt'] != '-' ? ' RT ' . $data['rt'] : ''; ?>
						</td>
						<td class="text-center"><?= $data['jml_anggota'] ?? 0; ?></td>
						<?php if (in_array($rincian, ['lahir', 'mati', 'pindah', 'datang'])): ?>
							<td class="text-center"><?= ! empty($data['tgl_peristiwa']) ? tgl_indo_out($data['tgl_peristiwa']) : '-'; ?></td>
						<?php endif; ?>

					<?php elseif ($rincian == 'mati'): ?>
						<td class="text-center"><?= ! empty($data['tgl_peristiwa']) ? tgl_indo_out($data['tgl_peristiwa']) : '-'; ?></td>
						<td class="text-center" style="mso-number-format:'\@';"><?= $data['nik']; ?></td>
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
						<td class="text-center" style="mso-number-format:'\@';"><?= $data['akta_mati'] ?: '-'; ?></td>

					<?php elseif ($rincian == 'pindah'): ?>
						<td class="text-center"><?= ! empty($data['tgl_peristiwa']) ? tgl_indo_out($data['tgl_peristiwa']) : '-'; ?></td>
						<td class="text-center" style="mso-number-format:'\@';"><?= $data['nik']; ?></td>
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
						<td class="text-center"><?= ! empty($data['tgl_peristiwa']) ? tgl_indo_out($data['tgl_peristiwa']) : (! empty($data['tgl_lapor']) ? tgl_indo_out($data['tgl_lapor']) : '-'); ?></td>
						<td class="text-center" style="mso-number-format:'\@';"><?= $data['nik']; ?></td>
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
						<td class="text-center"><?= ! empty($data['tanggallahir']) ? tgl_indo_out($data['tanggallahir']) : '-'; ?></td>
						<td class="text-center" style="mso-number-format:'\@';"><?= $data['nik']; ?></td>
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
						<td class="text-center" style="mso-number-format:'\@';"><?= $data['nik']; ?></td>
						<td><?= strtoupper($data['nama']); ?></td>
						<td class="text-center"><?= ($data['sex'] == 1) ? 'L' : (($data['sex'] == 2) ? 'P' : '-'); ?></td>
						<td><?= ($data['tempatlahir'] ?: '-') . ', ' . (! empty($data['tanggallahir']) ? tgl_indo_out($data['tanggallahir']) : '-'); ?></td>
						<td class="text-center"><?= $data['umur'] !== '-' ? $data['umur'] . ' Thn' : '-'; ?></td>
						<td class="text-center" style="mso-number-format:'\@';"><?= $data['no_kk'] ?: '-'; ?></td>
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

	<br/>
	<table style="width: 100%;">
		<tr>
			<td style="width: 70%;"></td>
			<td class="text-center">
				<?= $config['nama_desa'] ?? 'Desa' ?>, <?= tgl_indo_out(date('Y-m-d')); ?><br/>
				Kepala <?= ucwords($this->setting->sebutan_desa) ?> <?= $config['nama_desa'] ?? '' ?><br/><br/><br/><br/>
				<strong><u><?= $config['nama_kepala_desa'] ?? '.........................' ?></u></strong>
			</td>
		</tr>
	</table>

</body>
</html>
