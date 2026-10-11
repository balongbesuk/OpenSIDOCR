<?php

defined('BASEPATH') or exit('No direct script access allowed');

	$status_kawin_pria = array(
		"BELUM KAWIN" => "Jejaka",
		"KAWIN" => "Beristri",
		"CERAI HIDUP" => "Duda",
		"CERAI MATI" => "Duda"
	);

	$status_kawin_wanita = array(
		"BELUM KAWIN" => "Perawan",
		"KAWIN" => "Bersuami",
		"CERAI HIDUP" => "Janda",
		"CERAI MATI" => "Janda"
	);

	// Data pasangan pria =====================
	$id_pria = (!empty($input['id_pria']) && $input['id_pria'] != '*') ? $input['id_pria'] : null;
	if ($id_pria)
	{
		$pria = $this->get_data_surat($id_pria);
		$ibu_pria = $this->get_data_ibu($id_pria);
		$ayah_pria = $this->get_data_ayah($id_pria);

		$status_pria_val = $input['status_kawin_pria'] ?? $status_kawin_pria[$pria['status_kawin']] ?? $pria['status_kawin_pria'] ?? $pria['status_kawin'] ?? '';
		$pendidikan_pria_val = $pria['pendidikan'] ?? $input['pendidikan_pria'] ?? $input['form_pendidikan_pria'] ?? '';

		$array_replace = array(
			"[agama_pria]"                => $pria['agama'],
			"[form_agama_pria]"           => $pria['agama'],
			"[alamat_pria]"               => $pria['alamat'] .  " RT " . $pria['rt'] .  " RW " . $pria['rw'] . " $alamat_desa",
			"[form_alamat_pria]"          => $pria['alamat'] .  " RT " . $pria['rt'] .  " RW " . $pria['rw'] . " $alamat_desa",
			"[nama_pria]"                 => $pria['nama'],
			"[form_nama_pria]"            => $pria['nama'],
			"[no_ktp_pria]"               => $pria['nik'],
			"[form_no_ktp_pria]"          => $pria['nik'],
			"[no_kk_pria]"                => $pria['no_kk'],
			"[form_no_kk_pria]"           => $pria['no_kk'],
			"[pekerjaan_pria]"            => $pria['pekerjaan'],
			"[form_pekerjaan_pria]"       => $pria['pekerjaan'],
			"[sex_pria]"                  => $pria['sex'],
			"[form_sex_pria]"             => $pria['sex'],
			"[status_pria]"               => $status_pria_val,
			"[form_status_pria]"          => $status_pria_val,
			"[status_kawin_pria]"         => $status_pria_val,
			"[form_status_kawin_pria]"    => $status_pria_val,
			"[pendidikan_pria]"           => $pendidikan_pria_val,
			"[form_pendidikan_pria]"      => $pendidikan_pria_val,
			"[tempatlahir_pria]"          => $pria['tempatlahir'],
			"[form_tempatlahir_pria]"     => $pria['tempatlahir'],
			"[tanggallahir_pria]"         => tgl_indo_dari_str($pria['tanggallahir']),
			"[form_tanggallahir_pria]"    => tgl_indo_dari_str($pria['tanggallahir']),
			"[usia_pria]"                 => $pria['umur'] . ' Tahun',
			"[form_usia_pria]"            => $pria['umur'] . ' Tahun',
			"[wn_pria]"                   => $pria['warganegara'],
			"[form_wn_pria]"              => $pria['warganegara'],
		);
		if (!isset($input['jumlah_istri'])) $array_replace["[form_jumlah_istri]"] = "";
		$buffer = str_replace(array_keys($array_replace), array_values($array_replace), $buffer);
	}
	else
	{
		$status_pria_val = $input['status_kawin_pria'] ?? '';
		$pendidikan_pria_val = $input['pendidikan_pria'] ?? $input['form_pendidikan_pria'] ?? '';
		$array_replace = array(
			"[status_pria]"               => $status_pria_val,
			"[form_status_pria]"          => $status_pria_val,
			"[status_kawin_pria]"         => $status_pria_val,
			"[form_status_kawin_pria]"    => $status_pria_val,
			"[pendidikan_pria]"           => $pendidikan_pria_val,
			"[form_pendidikan_pria]"      => $pendidikan_pria_val,
		);
		$buffer = str_replace(array_keys($array_replace), array_values($array_replace), $buffer);
	}

	# Data orang tua apabila warga desa
	if (!empty($ayah_pria['id']))
	{
		$array_replace = array(
			"[form_nama_ayah_pria]"         => $ayah_pria['nama'],
			"[form_noktp_ayah_pria]"        => $ayah_pria['nik'],
			"[form_bin_ayah_pria]"          => $ayah_pria['nama_ayah'],
			"[form_tempatlahir_ayah_pria]"  => set_ucwords($ayah_pria['tempatlahir']),
			"[form_tanggallahir_ayah_pria]" => tgl_indo_dari_str($ayah_pria['tanggallahir']),
			"[form_wn_ayah_pria]"           => $ayah_pria['wn'],
			"[form_agama_ayah_pria]"        => set_ucwords($ayah_pria['agama']),
			"[form_pekerjaan_ayah_pria]"    => set_ucwords($ayah_pria['pek']),
			"[form_alamat_ayah_pria]"       => $ayah_pria['alamat'] .  " RT " . $ayah_pria['rt'] .  " RW " . $ayah_pria['rw'] . " $alamat_desa",
		);
		$buffer = str_replace(array_keys($array_replace), array_values($array_replace), $buffer);
	}

	if (!empty($ibu_pria['id']))
	{
		$array_replace = array(
			"[form_nama_ibu_pria]"         => $ibu_pria['nama'],
			"[form_noktp_ibu_pria]"        => $ibu_pria['nik'],
			"[form_binti_ibu_pria]"        => $ibu_pria['nama_ayah'],
			"[form_tempatlahir_ibu_pria]"  => set_ucwords($ibu_pria['tempatlahir']),
			"[form_tanggallahir_ibu_pria]" => tgl_indo_dari_str($ibu_pria['tanggallahir']),
			"[form_wn_ibu_pria]"           => $ibu_pria['wn'],
			"[form_agama_ibu_pria]"        => set_ucwords($ibu_pria['agama']),
			"[form_pekerjaan_ibu_pria]"    => set_ucwords($ibu_pria['pek']),
			"[form_alamat_ibu_pria]"       => $ibu_pria['alamat'] .  " RT " . $ibu_pria['rt'] .  " RW " . $ibu_pria['rw'] . " $alamat_desa",
		);
		$buffer = str_replace(array_keys($array_replace), array_values($array_replace), $buffer);
	}

	// Kode isian yang mungkin tidak terisi
	$buffer = str_replace("[form_istri_dulu]", $input['istri_dulu'] ?? '', $buffer);

	// Data pasangan wanita =====================
	$id_wanita = (!empty($input['id_wanita']) && $input['id_wanita'] != '*') ? $input['id_wanita'] : null;
	if ($id_wanita)
	{
		$wanita = $this->get_data_surat($id_wanita);
		$ibu_wanita = $this->get_data_ibu($id_wanita);
		$ayah_wanita = $this->get_data_ayah($id_wanita);

		$status_wanita_val = $input['status_kawin_wanita'] ?? $status_kawin_wanita[$wanita['status_kawin']] ?? $wanita['status_kawin_wanita'] ?? $wanita['status_kawin'] ?? '';
		$pendidikan_wanita_val = $wanita['pendidikan'] ?? $input['pendidikan_wanita'] ?? $input['form_pendidikan_wanita'] ?? '';

		$array_replace = array(
			"[agama_wanita]"                 => $wanita['agama'],
			"[form_agama_wanita]"            => $wanita['agama'],
			"[alamat_wanita]"                => $wanita['alamat'] .  " RT " . $wanita['rt'] .  " RW " . $wanita['rw'] . " $alamat_desa",
			"[form_alamat_wanita]"           => $wanita['alamat'] .  " RT " . $wanita['rt'] .  " RW " . $wanita['rw'] . " $alamat_desa",
			"[nama_wanita]"                  => $wanita['nama'],
			"[form_nama_wanita]"             => $wanita['nama'],
			"[no_ktp_wanita]"                => $wanita['nik'],
			"[form_no_ktp_wanita]"           => $wanita['nik'],
			"[sex_wanita]"                   => $wanita['sex'],
			"[form_sex_wanita]"              => $wanita['sex'],
			"[status_wanita]"                => $status_wanita_val,
			"[form_status_wanita]"           => $status_wanita_val,
			"[status_kawin_wanita]"          => $status_wanita_val,
			"[form_status_kawin_wanita]"     => $status_wanita_val,
			"[pendidikan_wanita]"            => $pendidikan_wanita_val,
			"[form_pendidikan_wanita]"       => $pendidikan_wanita_val,
			"[pekerjaan_wanita]"             => $wanita['pekerjaan'],
			"[form_pekerjaan_wanita]"        => $wanita['pekerjaan'],
			"[tempatlahir_wanita]"           => $wanita['tempatlahir'],
			"[form_tempatlahir_wanita]"      => $wanita['tempatlahir'],
			"[tanggallahir_wanita]"          => tgl_indo_dari_str($wanita['tanggallahir']),
			"[form_tanggallahir_wanita]"     => tgl_indo_dari_str($wanita['tanggallahir']),
			"[wn_wanita]"                    => $wanita['warganegara'],
			"[form_wn_wanita]"               => $wanita['warganegara'],
		);
		$buffer = str_replace(array_keys($array_replace), array_values($array_replace), $buffer);
	}
	else
	{
		$status_wanita_val = $input['status_kawin_wanita'] ?? '';
		$pendidikan_wanita_val = $input['pendidikan_wanita'] ?? $input['form_pendidikan_wanita'] ?? '';
		$array_replace = array(
			"[status_wanita]"                => $status_wanita_val,
			"[form_status_wanita]"           => $status_wanita_val,
			"[status_kawin_wanita]"          => $status_wanita_val,
			"[form_status_kawin_wanita]"     => $status_wanita_val,
			"[pendidikan_wanita]"            => $pendidikan_wanita_val,
			"[form_pendidikan_wanita]"       => $pendidikan_wanita_val,
		);
		$buffer = str_replace(array_keys($array_replace), array_values($array_replace), $buffer);
	}

	# Data orang tua apabila warga desa
	if (!empty($ayah_wanita['id']))
	{
		$array_replace = array(
			"[form_nama_ayah_wanita]"         => $ayah_wanita['nama'],
			"[form_noktp_ayah_wanita]"        => $ayah_wanita['nik'],
			"[form_bin_ayah_wanita]"          => $ayah_wanita['nama_ayah'],
			"[form_tempatlahir_ayah_wanita]"  => set_ucwords($ayah_wanita['tempatlahir']),
			"[form_tanggallahir_ayah_wanita]" => tgl_indo_dari_str($ayah_wanita['tanggallahir']),
			"[form_wn_ayah_wanita]"           => $ayah_wanita['wn'],
			"[form_agama_ayah_wanita]"        => set_ucwords($ayah_wanita['agama']),
			"[form_pekerjaan_ayah_wanita]"    => set_ucwords($ayah_wanita['pek']),
			"[form_alamat_ayah_wanita]"       => $ayah_wanita['alamat'] .  " RT " . $ayah_wanita['rt'] .  " RW " . $ayah_wanita['rw'] . " $alamat_desa",
		);
		$buffer = str_replace(array_keys($array_replace), array_values($array_replace), $buffer);
	}

	if (!empty($ibu_wanita['id']))
	{
		$array_replace = array(
			"[form_nama_ibu_wanita]"         => $ibu_wanita['nama'],
			"[form_noktp_ibu_wanita]"        => $ibu_wanita['nik'],
			"[form_binti_ibu_wanita]"        => $ibu_wanita['nama_ayah'],
			"[form_tempatlahir_ibu_wanita]"  => set_ucwords($ibu_wanita['tempatlahir']),
			"[form_tanggallahir_ibu_wanita]" => tgl_indo_dari_str($ibu_wanita['tanggallahir']),
			"[form_wn_ibu_wanita]"           => $ibu_wanita['wn'],
			"[form_agama_ibu_wanita]"        => set_ucwords($ibu_wanita['agama']),
			"[form_pekerjaan_ibu_wanita]"    => set_ucwords($ibu_wanita['pek']),
			"[form_alamat_ibu_wanita]"       => $ibu_wanita['alamat'] .  " RT " . $ibu_wanita['rt'] .  " RW " . $ibu_wanita['rw'] . " $alamat_desa",
		);
		$buffer = str_replace(array_keys($array_replace), array_values($array_replace), $buffer);
	}

	// Kode isian yang mungkin tidak terisi
	$buffer = str_replace("[form_suami_dulu]", $input['nama_suami_dulu'] ?? '', $buffer);

	// Bersihkan data session / cache setelah surat berhasil dicetak agar form bersih untuk pengajuan berikutnya
	$this->session->unset_userdata(['id_pria', 'id_wanita', 'post']);
	unset($_SESSION['id_pria'], $_SESSION['id_wanita'], $_SESSION['post']);
