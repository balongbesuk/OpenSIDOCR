<style type="text/css">

	table.disdukcapil {
		font-size: 9pt;
		width: 100%;
	}

	table.disdukcapil td {
		padding: 1px 1px 1px 3px;
	}

	table.disdukcapil td.satu {
		width: 10px;
		text-align: center;
	}

	table.disdukcapil td.padat {
		padding: 0px;
		margin: 0px;
		font-size: 9pt;
	}

	table.disdukcapil td.kotak {
		border: solid 1px #000000;
	}

	table.disdukcapil td.kanan {
		text-align: right;
	}

	table.disdukcapil td.tengah {
		text-align: center;
	}

	table.pengikut {
		margin-left: 28px;
		font-size: 9pt;
		border-collapse: collapse;
		border: solid 1px black;
		width: 96%;
	}

	table.pengikut td,
	th {
		border: solid 1px black;
		padding: 1px 1px 1px 3px;
	}

	table.pengikut th.border-kolom {
		border-top: solid 1px white;
		border-bottom: solid 1px white;
		background-color: white;
	}

	table.pengikut td.border-kolom {
		border-top: solid 1px white;
		border-bottom: solid 1px white;
	}

	table.pengikut th {
		text-align: center;
		vertical-align: middle;
	}

	table.pengikut td.tengah {
		text-align: center;
	}

	table.kode_format {
		font-size: 12pt;
		padding: 5px 20px;
		border: solid 1px black;
	}

	table.ttd {
		font-size: 8.5pt;
		margin-top: 5px;
		width: 100%;
		border-collapse: collapse;
		padding: 0px;
	}

	table.ttd td {
		text-align: center;
	}
</style>

<page orientation="landscape" format="210x330" style="font-size: 10pt">
	<table class="kode_format" align="right">
		<tr>
			<td><strong>F-1.03</strong></td>
		</tr>
	</table>
	<p style="text-align: center; margin-top: -20px">
		<strong style="font-size: 12pt;">FORMULIR PENDAFTARAN PERPINDAHAN PENDUDUK</strong>
	</p>

	<table class="disdukcapil">
		<col style="width: 3%;">
		<col style="width: 20%;">
		<col span="22" style="width: 3.3%">
		<tr>
			<td colspan=2><strong>Perhatian</strong></td>
			<td colspan=22>&nbsp;</td>
		</tr>
		<tr>
			<td colspan=12>Harap diisi dengan huruf cetak dan menggunakan tinta hitam</td>
		</tr>
		<tr>
			<td class="kotak satu">1.</td>
			<td class="kotak">Nomor Kartu Keluarga</td><td class="satu">:</td>
			<?php for ($i = 0; $i < 16; $i++) : ?>
				<td class="kotak satu">
					<?php if (isset($individu['no_kk'][$i])) : ?>
						<?= $individu['no_kk'][$i]; ?>
					<?php else : ?>
						&nbsp;
					<?php endif; ?>
				</td>
			<?php endfor; ?>
			<td colspan=6>&nbsp;</td>
		</tr>
		<tr>
			<td class="kotak satu">2.</td>
			<td class="kotak">Nama Lengkap Pemohon</td><td class="satu">:</td>
			<td colspan=22 class="kotak"><?= $individu['nama']; ?></td>
		</tr>
		<tr>
			<td class="kotak satu">3.</td>
			<td class="kotak">NIK</td><td class="satu">:</td>
			<?php for ($i = 0; $i < 16; $i++) : ?>
				<td class="kotak satu">
					<?php if (isset($individu['nik'][$i])) : ?>
						<?= $individu['nik'][$i]; ?>
					<?php else : ?>
						&nbsp;
					<?php endif; ?>
				</td>
			<?php endfor; ?>
			<td colspan=6>&nbsp;</td>
		</tr>
       <tr>
			<td class="kotak satu" >4.</td>
			<td class="kotak" >Jenis Permohonan</td><td class="satu">:</td>

         	<td colspan=1 class="kotak"></td>
			<td colspan=11 class="padat">Surat Keterangan Kependudukan</td>
		</tr>
        <tr>
        	<td>&nbsp;</td>
			<td>&nbsp;</td><td class="satu"></td>
        	<td colspan=1 class="kotak satu">V</td>
			<td colspan=11 class="padat">Surat Keterangan Pindah</td>
		</tr>
		<tr>
            <td>&nbsp;</td>
			<td>&nbsp;</td><td class="satu"></td>
        	<td colspan=1 class="kotak"></td>
			<td colspan=11 class="padat">Surat Keterangan Pindah Luar Negeri (SKPLN)</td>
		</tr>
         <tr>
            <td>&nbsp;</td>
			<td>&nbsp;</td><td class="satu"></td>
         	<td colspan=1 class="kotak"></td>
			<td colspan=11 class="padat">Surat Keterangan Tempat Tinggal (SKTT)</td>
		</tr>
        <tr>
            <td>&nbsp;</td>
			<td>&nbsp;</td><td class="satu"></td>
        	<td colspan=1 class="kotak"></td>
			<td colspan=11 class="padat">Bagi Orang Asing Tinggal Terbatas</td>
		</tr>
		<tr>
			<td class="kotak satu">5.</td>
			<td class="kotak">Alamat Asal</td><td class="satu">:</td>
			<td colspan=11 class="kotak"><?= $individu['alamat']; ?></td>
			<td colspan=2 style="text-align: center;">&nbsp;&nbsp;&nbsp;&nbsp;RT</td>
			<?php for ($i = 0; $i < 3; $i++) : ?>
				<td class="kotak satu">
					<?php if (isset($individu['rt'][$i])) : ?>
						<?= $individu['rt'][$i]; ?>
					<?php else : ?>
						&nbsp;
					<?php endif; ?>
				</td>
			<?php endfor; ?>
			<td colspan=1>&nbsp;</td>
			<td colspan=1 style="text-align: center;">RW</td>
			<?php for ($i = 0; $i < 3; $i++) : ?>
				<td class="kotak satu">
					<?php if (isset($individu['rw'][$i])) : ?>
						<?= $individu['rw'][$i]; ?>
					<?php else : ?>
						&nbsp;
					<?php endif; ?>
				</td>
			<?php endfor; ?>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
            <td>&nbsp;</td>
			<td colspan=4>a. Desa/Kelurahan</td>
			<td colspan=7 class="kotak"><?= $config['nama_desa']; ?></td>
			<td colspan=4>b. Kecamatan</td>
			<td colspan=8 class="kotak"><?= $config['nama_kecamatan']; ?></td>
		</tr>

		<tr>
			<td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
			<td colspan=4>b. Kab/Kota</td>
			<td colspan=7 class="kotak"><?= $config['nama_kabupaten']; ?></td>
			<td colspan=4>d. Provinsi</td>
			<td colspan=8 class="kotak"><?= $config['nama_propinsi']; ?></td>
		</tr>

		<tr>
			<td colspan=2>&nbsp;</td>
            <td>&nbsp;</td>
			<td colspan=5>Kode Pos</td>
			<?php for ($i = 0; $i < 5; $i++) : ?>
				<td class="kotak satu">
					<?php if (isset($config['kode_pos'][$i])) : ?>
						<?= $config['kode_pos'][$i]; ?>
					<?php else : ?>
						&nbsp;
					<?php endif; ?>
				</td>
			<?php endfor; ?>
		</tr>
       <tr>
			<td class="kotak satu">6.</td>
			<td class="kotak">Klasifikasi Kepindahan</td><td class="satu">:</td>
         	<td colspan=1 class="kotak satu"><?= isset($input['klasifikasi_pindah_id']) ? ($input['klasifikasi_pindah_id'] == 1 ? 'V' : '') : '' ?></td>
			<td colspan=23 class="padat">Dalam satu desa/ Kelurahan atau yang disebut dengan nama lain</td>
		</tr>
        <tr>
        	<td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        	<td colspan=1 class="kotak satu"><?= isset($input['klasifikasi_pindah_id']) ? ($input['klasifikasi_pindah_id'] == 2 ? 'V' : '') : '' ?></td>
			<td colspan=23 class="padat">Antar desa/kelurahan atau yang disebut dengan nama lain dalam satu kecamatan</td>
		</tr>
		<tr>
        	<td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        	<td colspan=1 class="kotak satu"><?= isset($input['klasifikasi_pindah_id']) ? ($input['klasifikasi_pindah_id'] == 3 ? 'V' : '') : '' ?></td>
			<td colspan=23 class="padat">Antar kecamatan atau yang disebut dengan nama lain dalam satu kabupaten/kota</td>
		</tr>
         <tr>
         	<td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
         	<td colspan=1 class="kotak satu"><?= isset($input['klasifikasi_pindah_id']) ? ($input['klasifikasi_pindah_id'] == 4 ? 'V' : '') : '' ?></td>
			<td colspan=23 class="padat">Antar kabupaten/kota dalam satu provinsi</td>
		</tr>
        <tr>
        	<td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        	<td colspan=1 class="kotak satu"><?= isset($input['klasifikasi_pindah_id']) ? ($input['klasifikasi_pindah_id'] == 5 ? 'V' : '') : '' ?></td>
			<td colspan=23 class="padat">Antar provinsi</td>
		</tr>
		<tr>
			<td class="kotak satu">7.</td>
			<td class="kotak">Alamat Pindah</td><td class="satu">:</td>
			<td colspan=11 class="kotak"><?= $input['alamat_tujuan']; ?></td>
			<td colspan=2 style="text-align: center;">&nbsp;&nbsp;&nbsp;&nbsp;RT</td>
			<?php for ($i = 0; $i < 3; $i++) : ?>
				<td class="kotak satu">
					<?php if (isset($input['rt_tujuan'][$i])) : ?>
						<?= $input['rt_tujuan'][$i]; ?>
					<?php else : ?>
						&nbsp;
					<?php endif; ?>
				</td>
			<?php endfor; ?>
			<td colspan=2 style="text-align: center;">&nbsp;&nbsp;&nbsp;&nbsp;RW</td>
			<?php for ($i = 0; $i < 3; $i++) : ?>
				<td class="kotak satu">
					<?php if (isset($input['rw_tujuan'][$i])) : ?>
						<?= $input['rw_tujuan'][$i]; ?>
					<?php else : ?>
						&nbsp;
					<?php endif; ?>
				</td>
			<?php endfor; ?>
		</tr>

		<tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
            <td>&nbsp;</td>
			<td colspan=4>a. Desa/Kelurahan</td>
			<td colspan=7 class="kotak"><?= $input['desa_tujuan']; ?></td>
			<td colspan=4>b. Kecamatan</td>
			<td colspan=8 class="kotak"><?= $input['kecamatan_tujuan']; ?></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
            <td>&nbsp;</td>
			<td colspan=4>c. Kab/Kota</td>
			<td colspan=7 class="kotak"><?= $input['kabupaten_tujuan']; ?></td>
			<td colspan=4>d. Provinsi</td>
			<td colspan=10 class="kotak"><?= $input['provinsi_tujuan']; ?></td>
		</tr>

		<tr>
			<td colspan=2>&nbsp;</td>
            <td>&nbsp;</td>
			<td colspan=5>Kode Pos</td>
			<?php for ($i = 0; $i < 5; $i++) : ?>
				<td class="kotak satu">
					<?php if (isset($input['kode_pos_tujuan'][$i])) : ?>
						<?= $input['kode_pos_tujuan'][$i]; ?>
					<?php else : ?>
						&nbsp;
					<?php endif; ?>
				</td>
			<?php endfor; ?>
		</tr>

		<tr>
			<td class="kotak satu">8.</td>
			<td class="kotak">Alasan Pindah</td><td class="satu">:</td>
			<td colspan=1 class="kotak satu"><?= isset($input['alasan_pindah_id']) ? ($input['alasan_pindah_id'] == 1 ? 'V' : '') : '' ?></td>
			<td colspan=4 class="padat">Pekerjaan</td>
			<td colspan=1 class="kotak satu"><?= isset($input['alasan_pindah_id']) ? ($input['alasan_pindah_id'] == 3 ? 'V' : '') : '' ?></td>
			<td colspan=4 class="padat">Keamanan</td>
			<td colspan=1 class="kotak satu"><?= isset($input['alasan_pindah_id']) ? ($input['alasan_pindah_id'] == 5 ? 'V' : '') : '' ?></td>
			<td colspan=4 class="padat">Perumahan</td>
			<td colspan=1 class="kotak satu"><?= isset($input['alasan_pindah_id']) ? ($input['alasan_pindah_id'] == 7 ? 'V' : '') : '' ?></td>
			<td colspan=8 class="padat">Lainnya (sebutkan)</td>
		</tr>

		<tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        	<td colspan=1 class="kotak satu"><?= isset($input['alasan_pindah_id']) ? ($input['alasan_pindah_id'] == 2 ? 'V' : '') : '' ?></td>
			<td colspan=4 class="padat">Pendidikan</td>
			<td colspan=1 class="kotak satu"><?= isset($input['alasan_pindah_id']) ? ($input['alasan_pindah_id'] == 4 ? 'V' : '') : '' ?></td>
			<td colspan=4 class="padat">Kesehatan</td>
			<td colspan=1 class="kotak satu"><?= isset($input['alasan_pindah_id']) ? ($input['alasan_pindah_id'] == 6 ? 'V' : '') : '' ?></td>
			<td colspan=4 class="padat">Keluarga</td>
			<td colspan=1 class="kotak satu"></td>
			<td colspan=8 class="padat">
				<?php if ($input['sebut_alasan']) : ?>
					<span style='text-decoration: none; border-bottom: 1px dotted black;'><?= $input['sebut_alasan']; ?></span>
				<?php else : ?>
					..............................
				<?php endif; ?>
			</td>
		</tr>

		<tr>
			<td class="kotak satu">9.</td>
			<td class="kotak">Jenis Kepindahan</td><td class="satu">:</td>
			<td colspan=1 class="kotak satu"><?= isset($input['jenis_kepindahan_id']) ? ($input['jenis_kepindahan_id'] == 1 ? 'V' : '') : '' ?></td>
			<td colspan=9 class="padat">Kep. Keluarga</td>
			<td colspan=1 class="kotak satu"><?= isset($input['jenis_kepindahan_id']) ? ($input['jenis_kepindahan_id'] == 3 ? 'V' : '') : '' ?></td>
			<td colspan=10 class="padat">Kep. Keluarga dan Sbg. Angg. Keluarga</td>
		</tr>
		<tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
		    <td colspan=1 class="kotak satu"><?= isset($input['jenis_kepindahan_id']) ? ($input['jenis_kepindahan_id'] == 2 ? 'V' : '') : '' ?></td>
			<td colspan=9 class="padat">Kep. Keluarga dan Seluruh Angg. Keluarga</td>
			<td colspan=1 class="kotak satu"><?= isset($input['jenis_kepindahan_id']) ? ($input['jenis_kepindahan_id'] == 4 ? 'V' : '') : '' ?></td>
			<td colspan=10 class="padat">Angg. Keluarga</td>
		</tr>

		<tr>
			<td class="kotak satu">10.</td>
			<td class="kotak">Anggota Keluarga Yang Tidak Pindah</td><td class="satu">:</td>
			<td colspan=1 class="kotak satu"><?= isset($input['status_kk_tidak_pindah_id']) ? ($input['status_kk_tidak_pindah_id'] == 1 ? 'V' : '') : '' ?></td>
			<td colspan=4 class="padat">Numpang KK</td>
			<td colspan=1 class="kotak satu"><?= isset($input['status_kk_tidak_pindah_id']) ? ($input['status_kk_tidak_pindah_id'] == 2 ? 'V' : '') : '' ?></td>
			<td colspan=8 class="padat">Membuat KK Baru</td>
		</tr>

		<tr>
			<td class="kotak satu">11.</td>
			<td class="kotak">Anggota Keluarga Yang Pindah</td><td class="satu">:</td>
			<td colspan=1 class="kotak satu"><?= isset($input['status_kk_pindah_id']) ? ($input['status_kk_pindah_id'] == 1 ? 'V' : '') : '' ?></td>
			<td colspan=4 class="padat">Numpang KK</td>
			<td colspan=1 class="kotak satu"><?= isset($input['status_kk_pindah_id']) ? ($input['status_kk_pindah_id'] == 2 ? 'V' : '') : '' ?></td>
			<td colspan=8 class="padat">Membuat KK Baru</td>
		</tr>
		<tr>
			<td class="kotak satu">12.</td>
			<td class="kotak">Daftar Anggota Keluarga Yang Pindah</td><td class="satu">:</td>
			<td colspan=22>&nbsp;</td>
		</tr>
	</table>

	<table class="pengikut">
		<tr bgcolor="#C2C2C2">
			<th colspan=2 style="width: 10%">NO.</th>
			<th colspan=1 class="border-kolom">&nbsp;&nbsp;</th>
			<th style="width: 45%" colspan=16>NIK</th>
			<th colspan=1 class="border-kolom">&nbsp;&nbsp;</th>
			<th style="width: 30%">NAMA LENGKAP</th>
			<th colspan=1 class="border-kolom">&nbsp;&nbsp;</th>
			<th colspan=2 style="width: 10%">SHDK</th>
		</tr>

		<?php
		for ($i = 0; $i < MAX_PINDAH; $i++) :
			$nomor = $i + 1;
			if ($i < count($input['id_cb'])) :
				$id = trim($input['id_cb'][$i], "'");
				$penduduk = $this->penduduk_model->get_penduduk($id, TRUE); ?>
				<tr>
					<?php $nourut = str_pad($nomor, 2, "0", STR_PAD_LEFT); ?>
					<?php for ($j = 0; $j < 2; $j++) : ?>
						<td class="tengah">
							<?= $nourut[$j]; ?>
						</td>
					<?php endfor; ?>
					<td colspan=1 class="border-kolom">&nbsp;&nbsp;</td>
					<?php for ($j = 0; $j < 16; $j++) : ?>
						<td class="tengah">
							<?php if (isset($penduduk['nik'][$j])) : ?>
								<?= $penduduk['nik'][$j]; ?>
							<?php else : ?>
								&nbsp;
							<?php endif; ?>
						</td>
					<?php endfor; ?>
					<td colspan=1 class="border-kolom">&nbsp;&nbsp;</td>
					<td><?= $penduduk['nama']; ?></td>
					<td colspan=1 class="border-kolom">&nbsp;&nbsp;</td>
					<?php $shdk = str_pad($penduduk['kk_level'], 2, "0", STR_PAD_LEFT); ?>
					<?php for ($j = 0; $j < 2; $j++) : ?>
						<td class="tengah">
							<?= $shdk[$j]; ?>
						</td>
					<?php endfor; ?>
				</tr>

			<?php else : ?>
				<tr>
					<td>&nbsp;&nbsp;</td>
					<td>&nbsp;&nbsp;</td>
					<td colspan=1 class="border-kolom">&nbsp;&nbsp;</td>
					<?php for ($k = 0; $k < 16; $k++) : ?>
						<td>&nbsp;&nbsp;</td>
					<?php endfor; ?>
					<td colspan=1 class="border-kolom">&nbsp;&nbsp;</td>
					<td>&nbsp;&nbsp;</td>
					<td colspan=1 class="border-kolom">&nbsp;&nbsp;</td>
					<td>&nbsp;&nbsp;</td>
					<td>&nbsp;&nbsp;</td>
				</tr>
			<?php endif; ?>
		<?php endfor; ?>

	</table>

	<table class="disdukcapil">
		<col style="width: 3%;">
		<col style="width: 20%;">
		<col span="22" style="width: 3.5%">

		<tr>
			<td colspan=22>&nbsp;</td>
		</tr>
		<tr>
			<td colspan=22><strong>Diisi oleh Penduduk (Orang Asing) Pemegang ITAS yang mengajukan SKTT dan OA Pemegang ITAP yang Mengajukan Surat Keterangan Kependudukan Lainnya</strong></td>
		</tr>

		<tr>
			<td class="kotak satu">13.</td>
			<td class="kotak">Nama Sponsor</td><td class="satu">:</td>
			<td colspan=18 class="kotak"><?= $input['nama_sponsor']; ?></td>
		</tr>

		<tr>
			<td class="kotak satu">14.</td>
			<td class="kotak">Tipe Sponsor</td><td class="satu">:</td>
			<td colspan=1 class="kotak"></td>
			<td colspan=8 class="padat">Organisasi Internasional</td>
			<td colspan=1 class="kotak"></td>
			<td colspan=5 class="padat">Pemerintah</td>
			<td colspan=1 class="kotak"></td>
			<td colspan=5 class="padat">Perusahaan</td>
		</tr>
		<tr>
        	<td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
		    <td colspan=1 class="kotak"></td>
			<td colspan=8 class="padat">Perorangan</td>
			<td colspan=1 class="kotak"></td>
			<td colspan=5 class="padat">Tanpa Sponsor</td>
			<td colspan=5 class="padat">&nbsp;</td>
		</tr>

		<tr>
			<td class="kotak satu">15.</td>
			<td class="kotak">Alamat Sponsor</td><td class="satu">:</td>
			<td colspan=18 class="kotak"><?= $input['alamat_sponsor']; ?></td>
		</tr>

		<tr>
			<td class="kotak satu">16.</td>
			<td class="kotak">Nomor dan tanggal KITAS & KITAP</td><td class="satu">:</td>

				<td class="kotak satu"></td>
				<td class="kotak satu"></td>
				<td class="kotak satu"></td>
				<td class="kotak satu"></td>
				<td class="kotak satu"></td>
				<td class="kotak satu"></td>
				<td class="kotak satu"></td>
				<td class="kotak satu"></td>
				<td class="kotak satu"></td>
				<td class="kotak satu"></td>
			    <td>&nbsp;</td>
				<td class="kotak satu"></td>
				<td class="kotak satu"></td>
				<td class="kotak satu"></td>
				<td class="kotak satu"></td>
				<td class="kotak satu"></td>
				<td class="kotak satu"></td>
				<td class="kotak satu"></td>
		</tr>
		<tr>
			<td colspan=6>&nbsp;</td>
			<td colspan=2>Nomor</td>
			<td colspan=8>&nbsp;</td>
			<td colspan=8>Tanggal Masa Berlaku</td>
		</tr>

		<tr>
			<td colspan=22>&nbsp;</td>
		</tr>
		<tr>
			<td colspan=22><strong>Diisi oleh Penduduk yang Mengajukan Surat Keterangan Pindah Luar Negeri</strong></td>
		</tr>

		<tr>
			<td class="kotak satu">17.</td>
			<td class="kotak">Negara Tujuan</td><td class="satu">:</td>
			<td colspan=14 class="kotak"><?= $input['negara_tujuan']; ?></td>
			<td colspan=1>&nbsp;</td>
			<?php for ($i = 0; $i < 3; $i++) : ?>
				<td class="kotak satu">
					<?php if (isset($input['kode_negara'][$i])) : ?>
						<?= $input['kode_negara'][$i]; ?>
					<?php else : ?>
						&nbsp;
					<?php endif; ?>
				</td>
			<?php endfor; ?>
		</tr>

		<tr>
			<td colspan=19>&nbsp;</td>
			<td colspan=4>Kode Negara</td>
		</tr>

		<tr>
			<td class="kotak satu">18.</td>
			<td class="kotak">Alamat Tujuan</td><td class="satu">:</td>
			<td colspan=18 class="kotak"><?= $input['alamat_tujuan_luar_negeri']; ?></td>
		</tr>

		<tr>
			<td class="kotak satu">19.</td>
			<td class="kotak">Penanggung Jawab</td><td class="satu">:</td>
			<td colspan=18 class="kotak"><?= $input['penanggungjawab']; ?></td>
		</tr>

		<tr>
			<td class="kotak satu">20.</td>
			<td class="kotak">Rencana Pindah Tanggal</td><td class="satu">:</td>
			<?php $tgl = date('dd', strtotime($input['tanggal_pindah']));
			$bln = date('mm', strtotime($input['tanggal_pindah']));
			$thn = date('Y', strtotime($input['tanggal_pindah']));
			?>
			<td>Tgl</td>
			<?php for ($j = 0; $j < 2; $j++) : ?>
				<td class="kotak tengah">
					<?php if (isset($tgl[$j])) : ?>
						<?= $tgl[$j]; ?>
					<?php else : ?>
						&nbsp;
					<?php endif; ?>
				</td>
			<?php endfor; ?>
			<td>&nbsp;</td>
			<td>Bln</td>
			<?php for ($j = 0; $j < 2; $j++) : ?>
				<td class="kotak tengah">
					<?php if (isset($bln[$j])) : ?>
						<?= $bln[$j]; ?>
					<?php else : ?>
						&nbsp;
					<?php endif; ?>
				</td>
			<?php endfor; ?>
			<td>&nbsp;</td>
			<td>Thn</td>
			<?php for ($j = 0; $j < 4; $j++) : ?>
				<td class="kotak tengah">
					<?php if (isset($thn[$j])) : ?>
						<?= $thn[$j]; ?>
					<?php else : ?>
						&nbsp;
					<?php endif; ?>
				</td>
			<?php endfor; ?>
			<td colspan="12">&nbsp;</td>
		</tr>
		<tr>
			<td colspan=22>&nbsp;</td>
			<td colspan=22>&nbsp;</td>
		</tr>
	</table>

	<table class="ttd">
		<col style="width:50%; text-align: center; padding-left: 60px;">
		<col style="width:50%; text-align: center;">
		<tr class="pendek">
			<td>Mengetahui,</td>
			<td>&nbsp;</td>
		</tr>
		<tr class="pendek">
			<td>Kepala Dinas/ Suku Dinas/ UPT Dinas</td>
			<td>&nbsp;</td>
		</tr>
		<tr class="pendek">
			<td>Kependudukan dan Pencatatan Sipil</td>
			<td>.................,&nbsp;................. &nbsp;20...................</td>
		</tr>
		<tr class="pendek">
			<td>Kabupaten <?= $config['nama_kabupaten']; ?></td>
			<td>Pemohon</td>
		</tr>
		<tr style="font-size: 8mm; line-height: normal;">
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		</tr>
		<tr style="font-size: 8mm; line-height: normal;">
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td>(.........................................................)</td>
			<td><strong>(<?= padded_string_center(strtoupper($individu['nama']), 30) ?>)</strong></td>
		</tr>
	</table>

</page>