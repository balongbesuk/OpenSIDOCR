<?php

defined('BASEPATH') or exit('No direct script access allowed');

	// Jika form dibuka baru (GET request), bersihkan session lama agar tidak ada cache dari pengajuan sebelumnya
	if (empty($this->input->post()))
	{
		$this->session->unset_userdata(['id_pria', 'id_wanita', 'post']);
		unset($_SESSION['id_pria'], $_SESSION['id_wanita'], $_SESSION['post']);
		unset($data['pria'], $data['wanita']);

		// Jika form dibuka untuk individu tertentu
		if (!empty($data['individu']))
		{
			if ($data['individu']['sex_id'] == 1 || $data['individu']['sex'] == 'LAKI-LAKI')
			{
				$data['pria'] = $data['individu'];
				$this->session->id_pria = $data['individu']['id'];
			}
			elseif ($data['individu']['sex_id'] == 2 || $data['individu']['sex'] == 'PEREMPUAN')
			{
				$data['wanita'] = $data['individu'];
				$this->session->id_wanita = $data['individu']['id'];
			}
		}

		$_SESSION['post'] = [];
		if (isset($data['surat_terakhir']['no_surat_berikutnya']))
		{
			$_SESSION['post']['nomor'] = $data['surat_terakhir']['no_surat_berikutnya'];
		}
	}
	else
	{
		$this->session->post = $this->input->post();
		if (isset($data['surat_terakhir']['no_surat_berikutnya']))
		{
			$_SESSION['post']['nomor'] = $data['surat_terakhir']['no_surat_berikutnya'];
		}

		if ($this->input->post('calon_pria') == 2) $this->session->unset_userdata('id_pria');
		if ($this->input->post('id_pria') != '' AND $this->input->post('id_pria') != '*')
		{
			$data['pria'] = $this->surat_model->get_penduduk($this->input->post('id_pria'));
			$this->session->id_pria = $this->input->post('id_pria');
		}
		elseif ($this->input->post('id_pria') != '*' AND isset($this->session->id_pria))
		{
			$data['pria'] = $this->surat_model->get_penduduk($this->session->id_pria);
		}
		else
		{
			unset($data['pria']);
			$this->session->unset_userdata('id_pria');
		}

		$data['calon_wanita_berbeda'] = true;
		if ($this->input->post('calon_wanita') == 2) $this->session->unset_userdata('id_wanita');
		if ($this->input->post('id_wanita') != '' AND $this->input->post('id_wanita') != '*'){
			if ($this->input->post('id_wanita') == $this->session->id_wanita)
				$data['calon_wanita_berbeda'] = false;
			$data['wanita'] = $this->surat_model->get_penduduk($this->input->post('id_wanita'));
			$this->session->id_wanita = $this->input->post('id_wanita');
		}
		elseif ($this->input->post('id_wanita') != '*' AND isset($this->session->id_wanita))
		{
			$data['wanita'] = $this->surat_model->get_penduduk($this->session->id_wanita);
		}
		else
		{
			unset($data['wanita']);
			$this->session->unset_userdata('id_wanita');
		}

		if ($this->input->post('id_wanita') == '*')
		{
			$array = [
				'nama_wali',
				'bin_wali',
				'tempatlahir_wali',
				'tanggallahir_wali',
				'wn_wali', 'pek_wali',
				'alamat_wali',
				'hub_wali'
			];

			foreach ($array as $val)
			{
				unset($_SESSION['post'][$val]);
			}
		}
	}

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

	$data['warganegara'] = $this->penduduk_model->list_warganegara();
	$data['agama'] = $this->referensi_model->list_data('tweb_penduduk_agama');
	$data['pekerjaan'] = $this->penduduk_model->list_pekerjaan();
	$data['laki'] = $this->surat_model->list_penduduk_laki();
	$data['nomor'] = $this->input->post('nomor_main');

	if (isset($this->session->id_pria))
	{
		$id = $this->session->id_pria;
		$data['ayah_pria'] = $this->surat_model->get_data_ayah($id);
		$data['ibu_pria'] = $this->surat_model->get_data_ibu($id);
	}

	if (isset($data['pria']))
	{
		$data['pria']['status_kawin_pria'] = $status_kawin_pria[$data['pria']['status_kawin']] ?? $data['pria']['status_kawin'] ?? '';
	}

	if (isset($this->session->id_wanita))
	{
		$id = $this->session->id_wanita;
		$data['ayah_wanita'] = $this->surat_model->get_data_ayah($id);
		$data['ibu_wanita'] = $this->surat_model->get_data_ibu($id);
	}
	if (isset($data['wanita']))
	{
		$data['wanita']['status_kawin_wanita'] = $status_kawin_wanita[$data['wanita']['status_kawin']] ?? $data['wanita']['status_kawin'] ?? '';
	}

	$data['kode']['status_kawin_pria'] = array(
		"Jejaka",
		"Cerai Hidup",
		"Cerai Mati",
		"Beristri"
	);

	$data['kode']['status_kawin_wanita'] = array(
		"Perawan",
		"Cerai Hidup",
		"Cerai Mati",
	);
?>