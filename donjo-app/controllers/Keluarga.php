<?php

/*
 *
 * File ini bagian dari:
 *
 * OpenSID
 *
 * Sistem informasi desa sumber terbuka untuk memajukan desa
 *
 * Aplikasi dan source code ini dirilis berdasarkan lisensi GPL V3
 *
 * Hak Cipta 2009 - 2015 Combine Resource Institution (http://lumbungkomunitas.net/)
 * Hak Cipta 2016 - 2024 Perkumpulan Desa Digital Terbuka (https://opendesa.id)
 *
 * Dengan ini diberikan izin, secara gratis, kepada siapa pun yang mendapatkan salinan
 * dari perangkat lunak ini dan file dokumentasi terkait ("Aplikasi Ini"), untuk diperlakukan
 * tanpa batasan, termasuk hak untuk menggunakan, menyalin, mengubah dan/atau mendistribusikan,
 * asal tunduk pada syarat berikut:
 *
 * Pemberitahuan hak cipta di atas dan pemberitahuan izin ini harus disertakan dalam
 * setiap salinan atau bagian penting Aplikasi Ini. Barang siapa yang menghapus atau menghilangkan
 * pemberitahuan ini melanggar ketentuan lisensi Aplikasi Ini.
 *
 * PERANGKAT LUNAK INI DISEDIAKAN "SEBAGAIMANA ADANYA", TANPA JAMINAN APA PUN, BAIK TERSURAT MAUPUN
 * TERSIRAT. PENULIS ATAU PEMEGANG HAK CIPTA SAMA SEKALI TIDAK BERTANGGUNG JAWAB ATAS KLAIM, KERUSAKAN ATAU
 * KEWAJIBAN APAPUN ATAS PENGGUNAAN ATAU LAINNYA TERKAIT APLIKASI INI.
 *
 * @package   OpenSID
 * @author    Tim Pengembang OpenDesa
 * @copyright Hak Cipta 2009 - 2015 Combine Resource Institution (http://lumbungkomunitas.net/)
 * @copyright Hak Cipta 2016 - 2024 Perkumpulan Desa Digital Terbuka (https://opendesa.id)
 * @license   http://www.gnu.org/licenses/gpl.html GPL V3
 * @link      https://github.com/OpenSID/OpenSID
 *
 */

use App\Enums\JenisKelaminEnum;
use App\Enums\SHDKEnum;
use App\Models\Keluarga as ModelsKeluarga;

defined('BASEPATH') || exit('No direct script access allowed');

class Keluarga extends Admin_Controller
{
    private $_set_page;
    private $_list_session;

    public function __construct()
    {
        parent::__construct();
        $this->load->model(['keluarga_model', 'penduduk_model', 'wilayah_model', 'program_bantuan_model']);
        $this->modul_ini     = 'kependudukan';
        $this->sub_modul_ini = 'keluarga';
        $this->_set_page     = ['20', '50', '100', [0, 'Semua']];
        $this->_list_session = ['jenis_peristiwa', 'status_hanya_tetap', 'status_dasar', 'sex', 'dusun', 'rw', 'rt', 'cari', 'kelas', 'filter', 'id_bos', 'judul_statistik', 'bantuan_keluarga', 'kumpulan_kk'];
    }

    public function clear_session()
    {
        $this->session->unset_userdata($this->_list_session);
        $this->session->per_page     = $this->_set_page[0];
        $this->session->status_dasar = 1; // tampilkan KK aktif saja
    }

    public function clear()
    {
        $this->clear_session();
        redirect($this->controller);
    }

    public function index($p = 1, $o = 1)
    {
        $data['p'] = $p;
        $data['o'] = $o;

        foreach ($this->_list_session as $list) {
            if (in_array($list, ['dusun', 'rw', 'rt'])) {
                ${$list} = $this->session->{$list};
            } else {
                $data[$list] = $this->session->{$list} ?: '';
            }
        }

        if (isset($dusun)) {
            $data['dusun']   = $dusun;
            $data['list_rw'] = $this->wilayah_model->list_rw($dusun);

            if (isset($rw)) {
                $data['rw']      = $rw;
                $data['list_rt'] = $this->wilayah_model->list_rt($dusun, $rw);

                if (isset($rt)) {
                    $data['rt'] = $rt;
                } else {
                    $data['rt'] = '';
                }
            } else {
                $data['rw'] = '';
            }
        } else {
            $data['dusun'] = $data['rw'] = $data['rt'] = '';
        }

        $per_page = $this->input->post('per_page');
        if (isset($per_page)) {
            $this->session->per_page = $per_page;
        }

        $data['func']       = 'index';
        $data['set_page']   = $this->_set_page;
        $list_data          = $this->keluarga_model->list_data($o, $p);
        $data['paging']     = $list_data['paging'];
        $data['main']       = $list_data['main'];
        $data['list_sex']   = $this->referensi_model->list_data('tweb_penduduk_sex');
        $data['list_dusun'] = $this->wilayah_model->list_dusun();

        $this->render('sid/kependudukan/keluarga', $data);
    }

    public function autocomplete()
    {
        return json($this->keluarga_model->autocomplete($this->input->post('cari')));
    }

    public function cetak($page = 1, $o = 0, $aksi = '', $privasi_kk = 0)
    {
        $args = func_get_args();
        if (count($args) == 2 && in_array($args[1], ['cetak', 'unduh'])) {
            $aksi = $args[1];
            $o    = $args[0];
            $page = 1;
        }

        $list         = $this->keluarga_model->list_data($o, 0);
        $data['main'] = isset($list['main']) ? $list['main'] : $list;
        if ($privasi_kk == 1) {
            $data['privasi_kk'] = true;
        }
        $this->load->view("sid/kependudukan/keluarga_{$aksi}", $data);
    }

    public function form_peristiwa($peristiwa = '')
    {
        $this->redirect_hak_akses('u');
        if ($peristiwa != 5) {
            redirect($this->controller);
        }

        $this->session->jenis_peristiwa = $peristiwa;
        $this->form();
    }

    public function form_peristiwa_a($peristiwa = '', $p = 1, $o = 0, $id = 0)
    {
        $this->redirect_hak_akses('u');
        $this->session->jenis_peristiwa = $peristiwa;
        $this->form_a($p, $o, $id);
    }

    public function form($p = 1, $o = 0)
    {
        $this->redirect_hak_akses('u');
        if (empty($_POST) && (! isset($_SESSION['dari_internal']) || ! $_SESSION['dari_internal'])) {
            unset($_SESSION['validation_error']);
        }

        $data['kk_baru'] = true;

        if (isset($_SESSION['validation_error']) && $_SESSION['validation_error']) {
            if ($_SESSION['dari_internal']) {
                $data['penduduk'] = $_SESSION['post'];
            } else {
                $data['penduduk'] = $_POST;
            }
            $data['penduduk']['id_sex'] = $data['penduduk']['sex'];
        } else {
            $data['penduduk'] = null;
        }
        $data['kk']                 = null;
        $data['form_action']        = site_url("{$this->controller}/insert_new");
        $data['penduduk_lepas']     = $this->keluarga_model->list_penduduk_lepas();
        $data['dusun']              = $this->wilayah_model->list_dusun();
        $data['rw']                 = $this->wilayah_model->list_rw($data['penduduk']['dusun']);
        $data['rt']                 = $this->wilayah_model->list_rt($data['penduduk']['dusun'], $data['penduduk']['rw']);
        $data['agama']              = $this->referensi_model->list_data('tweb_penduduk_agama');
        $data['pendidikan_sedang']  = $this->penduduk_model->list_pendidikan_sedang();
        $data['pendidikan_kk']      = $this->penduduk_model->list_pendidikan_kk();
        $data['pekerjaan']          = $this->penduduk_model->list_pekerjaan();
        $data['warganegara']        = $this->penduduk_model->list_warganegara();
        $data['hubungan']           = $this->penduduk_model->list_hubungan();
        $data['kawin']              = $this->penduduk_model->list_status_kawin();
        $data['golongan_darah']     = $this->penduduk_model->list_golongan_darah();
        $data['bahasa']             = $this->referensi_model->list_data('ref_penduduk_bahasa');
        $data['cacat']              = $this->penduduk_model->list_cacat();
        $data['sakit_menahun']      = $this->referensi_model->list_data('tweb_sakit_menahun');
        $data['cara_kb']            = $this->penduduk_model->list_cara_kb($data['penduduk']['id_sex']);
        $data['ktp_el']             = $this->referensi_model->list_ktp_el();
        $data['status_rekam']       = $this->referensi_model->list_status_rekam();
        $data['tempat_dilahirkan']  = $this->referensi_model->list_ref_flip(TEMPAT_DILAHIRKAN);
        $data['jenis_kelahiran']    = $this->referensi_model->list_ref_flip(JENIS_KELAHIRAN);
        $data['penolong_kelahiran'] = $this->referensi_model->list_ref_flip(PENOLONG_KELAHIRAN);
        $data['pilihan_asuransi']   = $this->referensi_model->list_data('tweb_penduduk_asuransi');
        $data['kehamilan']          = $this->referensi_model->list_data('ref_penduduk_hamil');
        $data['suku']               = $this->penduduk_model->get_suku();
        $data['nik_sementara']      = $this->penduduk_model->nik_sementara();
        $data['cek_nik']            = get_nik($data['penduduk']['nik']);
        $data['cek_nokk']           = get_nokk($data['kk']['no_kk']);
        $data['nokk_sementara']     = $this->keluarga_model->nokk_sementara();

        if ($this->session->status_hanya_tetap) {
            $data['status_penduduk'] = $this->referensi_model->list_data('tweb_penduduk_status', $this->session->status_hanya_tetap, 1);
        } else {
            $data['status_penduduk'] = $this->referensi_model->list_data('tweb_penduduk_status', null, 1);
        }
        $data['jenis_peristiwa'] = $this->session->jenis_peristiwa;

        $this->session->unset_userdata(['dari_internal']);

        $this->render('sid/kependudukan/keluarga_form', $data);
    }

    public function form_a($p = 1, $o = 0, $id = 0)
    {
        $this->redirect_hak_akses('u');
        $kepala = $this->keluarga_model->get_kepala_a($id);
        $this->redirect_tidak_valid(empty($kepala['id']) || $kepala['status_dasar'] == 1);

        if (empty($_POST) && ! $_SESSION['dari_internal']) {
            unset($_SESSION['validation_error']);
        } else {
            unset($_SESSION['dari_internal']);
        }

        $data['id_kk']              = $id;
        $data['kk']                 = $this->keluarga_model->get_kepala_a($id);
        $data['form_action']        = site_url("{$this->controller}/insert_a");
        $data['agama']              = $this->referensi_model->list_data('tweb_penduduk_agama');
        $data['pendidikan_kk']      = $this->penduduk_model->list_pendidikan_kk();
        $data['pendidikan_sedang']  = $this->penduduk_model->list_pendidikan_sedang();
        $data['pekerjaan']          = $this->penduduk_model->list_pekerjaan();
        $data['warganegara']        = $this->penduduk_model->list_warganegara();
        $data['hubungan']           = $this->penduduk_model->list_hubungan($data['kk']['status_kawin'], $data['kk']['sex']);
        $data['kawin']              = $this->penduduk_model->list_status_kawin();
        $data['golongan_darah']     = $this->penduduk_model->list_golongan_darah();
        $data['bahasa']             = $this->referensi_model->list_data('ref_penduduk_bahasa');
        $data['cacat']              = $this->penduduk_model->list_cacat();
        $data['sakit_menahun']      = $this->referensi_model->list_data('tweb_sakit_menahun');
        $data['cara_kb']            = $this->penduduk_model->list_cara_kb($data['penduduk']['id_sex']);
        $data['ktp_el']             = $this->referensi_model->list_ktp_el();
        $data['status_rekam']       = $this->referensi_model->list_status_rekam();
        $data['tempat_dilahirkan']  = $this->referensi_model->list_ref_flip(TEMPAT_DILAHIRKAN);
        $data['jenis_kelahiran']    = $this->referensi_model->list_ref_flip(JENIS_KELAHIRAN);
        $data['penolong_kelahiran'] = $this->referensi_model->list_ref_flip(PENOLONG_KELAHIRAN);
        $data['pilihan_asuransi']   = $this->referensi_model->list_data('tweb_penduduk_asuransi');
        $data['kehamilan']          = $this->referensi_model->list_data('ref_penduduk_hamil');
        $data['suku']               = $this->penduduk_model->get_suku();
        $data['nik_sementara']      = $this->penduduk_model->nik_sementara();

        if ($this->session->status_hanya_tetap) {
            $data['status_penduduk'] = $this->referensi_model->list_data('tweb_penduduk_status', $this->session->status_hanya_tetap, 1);
        } else {
            $data['status_penduduk'] = $this->referensi_model->list_data('tweb_penduduk_status', null, 1);
        }
        $data['jenis_peristiwa'] = $this->session->jenis_peristiwa;

        if ($_SESSION['validation_error']) {
            $data['id_kk']    = $_SESSION['id_kk'];
            $data['kk']       = $_SESSION['kk'];
            $data['penduduk'] = $_SESSION['post'];
        }

        $this->render('sid/kependudukan/keluarga_form_a', $data);
    }

    public function edit_nokk($p = 1, $o = 0, $id = 0)
    {
        $this->redirect_hak_akses('u');
        $data['kk']                 = $this->keluarga_model->get_keluarga($id) ?? show_404();
        $data['dusun']              = $this->wilayah_model->list_dusun();
        $data['rw']                 = $this->wilayah_model->list_rw($data['kk']['dusun']);
        $data['rt']                 = $this->wilayah_model->list_rt($data['kk']['dusun'], $data['kk']['rw']);
        $data['program']            = $this->program_bantuan_model->list_program_keluarga($id);
        $data['keluarga_sejahtera'] = $this->referensi_model->list_data('tweb_keluarga_sejahtera');
        $data['cek_nokk']           = get_nokk($data['kk']['no_kk']);
        $data['nokk_sementara']     = $this->keluarga_model->nokk_sementara();
        $data['form_action']        = site_url("{$this->controller}/update_nokk/{$id}");

        $this->load->view('sid/kependudukan/ajax_edit_nokk', $data);
    }

    public function form_old($p = 1, $o = 0, $id = 0)
    {
        $this->redirect_hak_akses('u');
        $data['penduduk']       = $this->keluarga_model->list_penduduk_lepas();
        $data['cek_nokk']       = get_nokk($data['kk']['no_kk']);
        $data['nokk_sementara'] = $this->keluarga_model->nokk_sementara();
        $data['form_action']    = site_url("{$this->controller}/insert/{$id}");
        $this->load->view('sid/kependudukan/ajax_add_keluarga', $data);
    }

    public function filter($filter)
    {
        $value = $this->input->post($filter);
        if ($value != '') {
            $this->session->{$filter} = $value;
        } else {
            $this->session->unset_userdata($filter);
        }

        redirect($this->controller);
    }

    public function dusun()
    {
        $this->session->unset_userdata(['rw', 'rt']);
        $dusun = $this->input->post('dusun');
        if ($dusun != '') {
            $this->session->dusun = $dusun;
        } else {
            $this->session->unset_userdata('dusun');
        }

        redirect($this->controller);
    }

    public function rw()
    {
        $this->session->unset_userdata('rt');
        $rw = $this->input->post('rw');
        if ($rw != '') {
            $this->session->rw = $rw;
        } else {
            $this->session->unset_userdata('rw');
        }

        redirect($this->controller);
    }

    public function rt()
    {
        $rt = $this->input->post('rt');
        if ($rt != '') {
            $this->session->rt = $rt;
        } else {
            $this->session->unset_userdata('rt');
        }

        redirect($this->controller);
    }

    public function insert()
    {
        $this->redirect_hak_akses('u');
        $this->keluarga_model->insert();
        $this->cache->hapus_cache_untuk_semua('_wilayah');

        redirect($this->controller);
    }

    public function insert_a()
    {
        $this->redirect_hak_akses('u');
        $id_kk          = $this->input->post('id_kk');
        $_POST['no_kk'] = $_POST['no_kk_keluarga'];
        $_POST['id']    = $id_kk;
        unset($_POST['no_kk_keluarga']);
        $this->keluarga_model->insert_a();
        $this->cache->hapus_cache_untuk_semua('_wilayah');
        if ($_SESSION['validation_error']) {
            $_SESSION['id_kk']         = $id_kk;
            $_SESSION['kk']            = $this->keluarga_model->get_kepala_a($id_kk);
            $_SESSION['dari_internal'] = true;
            redirect("{$this->controller}/form_a/1/0/{$id_kk}");
        } else {
            redirect("{$this->controller}/anggota/1/0/{$id_kk}");
        }
    }

    public function insert_new()
    {
        $this->redirect_hak_akses('u');
        $this->keluarga_model->insert_new();
        $this->cache->hapus_cache_untuk_semua('_wilayah');
        if ($_SESSION['success'] == -1) {
            $_SESSION['dari_internal'] = true;
            redirect("{$this->controller}/form");
        } else {
            redirect($this->controller);
        }
    }

    public function update_nokk($id = 0)
    {
        $this->redirect_hak_akses('u');
        $this->redirect_tidak_valid($this->keluarga_model->get_kepala_a($id)['status_dasar'] == 1);
        $this->keluarga_model->update_nokk($id);
        $this->cache->hapus_cache_untuk_semua('_wilayah');

        redirect($this->controller);
    }

    public function delete($p = 1, $o = 0, $id = 0)
    {
        $this->redirect_hak_akses('h');
        $this->redirect_tidak_valid($this->keluarga_model->cek_boleh_hapus($id));
        $this->keluarga_model->delete($id);
        $this->cache->hapus_cache_untuk_semua('_wilayah');

        redirect($this->controller);
    }

    public function delete_all()
    {
        $this->redirect_hak_akses('h');
        $this->keluarga_model->delete_all();
        $this->cache->hapus_cache_untuk_semua('_wilayah');

        redirect($this->controller);
    }

    public function anggota($p = 1, $o = 0, $id = 0)
    {
        $data['p']  = $p;
        $data['o']  = $o;
        $data['kk'] = $id;

        $kk            = ModelsKeluarga::with(['anggota'])->find($id) ?? show_404();
        $data['no_kk'] = $kk->no_kk;
        $data['main']  = $kk->anggota->map(static function ($item) {
            $item->hubungan = SHDKEnum::valueOf($item->kk_level);
            $item->sex      = JenisKelaminEnum::valueOf($item->sex);

            return $item;
        })->toArray();
        $data['kepala_kk'] = $kk->anggota->where('kk_level', SHDKEnum::KEPALA_KELUARGA)->first();
        $data['program']   = $this->program_bantuan_model->get_peserta_program(2, $kk->no_kk);

        $this->render('sid/kependudukan/keluarga_anggota', $data);
    }

    public function ajax_add_anggota($p = 1, $o = 0, $id = 0)
    {
        $this->redirect_hak_akses('u');
        $data['p'] = $p;
        $data['o'] = $o;

        $kk = $this->keluarga_model->get_kepala_kk($id);
        if ($kk) {
            $data['kepala_kk'] = $kk;
        } else {
            $data['kepala_kk'] = null;
        }
        $data['hubungan']    = $this->penduduk_model->list_hubungan($data['kepala_kk']['status_kawin_id'], $data['kepala_kk']['sex_id']);
        $data['main']        = $this->keluarga_model->list_anggota($id);
        $data['penduduk']    = $this->keluarga_model->list_penduduk_lepas(true);
        $data['form_action'] = site_url("{$this->controller}/add_anggota/{$p}/{$o}/{$id}");

        $this->load->view('sid/kependudukan/ajax_add_anggota_form', $data);
    }

    public function edit_anggota($p = 1, $o = 0, $id_kk = 0, $id = 0)
    {
        $this->redirect_hak_akses('u');
        $data['p'] = $p;
        $data['o'] = $o;

        $data['hubungan'] = $this->keluarga_model->list_hubungan();
        $data['main']     = $this->keluarga_model->get_anggota($id);

        $kk = $this->keluarga_model->get_kepala_kk($id_kk);
        if ($kk) {
            $data['kepala_kk'] = $kk;
        } else {
            $data['kepala_kk'] = null;
        }

        $data['form_action'] = site_url("{$this->controller}/update_anggota/{$p}/{$o}/{$id_kk}/{$id}");

        $this->load->view('sid/kependudukan/ajax_edit_anggota_form', $data);
    }

    public function kartu_keluarga($p = 1, $o = 0, $id = 0)
    {
        $data['p']     = $p;
        $data['o']     = $o;
        $data['id_kk'] = $id;

        $data['hubungan'] = $this->keluarga_model->list_hubungan();
        $data['main']     = $this->keluarga_model->list_anggota($id);
        $kk               = $this->keluarga_model->get_kepala_kk($id);
        $data['desa']     = $this->header['desa'];

        if ($kk) {
            $data['kepala_kk'] = $kk;
        } else {
            $data['kepala_kk'] = $this->keluarga_model->get_keluarga($id) ?? show_404();
        }

        $data['penduduk']    = $this->keluarga_model->list_penduduk_lepas();
        $data['form_action'] = site_url("{$this->controller}/print");

        $this->render('sid/kependudukan/kartu_keluarga', $data);
    }

    public function cetak_kk($id = 0)
    {
        $data = $this->keluarga_model->get_data_cetak_kk($id);

        $this->load->view('sid/kependudukan/cetak_kk_all', $data);
    }

    public function cetak_kk_all()
    {
        $data = $this->keluarga_model->get_data_cetak_kk_all();

        $this->load->view('sid/kependudukan/cetak_kk_all', $data);
    }

    public function doc_kk($id = 0)
    {
        $this->keluarga_model->unduh_kk($id);
    }

    public function doc_kk_all($id = 0)
    {
        $this->keluarga_model->unduh_kk();
    }

    public function add_anggota($p = 1, $o = 0, $id = 0)
    {
        $this->redirect_hak_akses('u');
        $kepala = $this->keluarga_model->get_kepala_a($id);
        $this->redirect_tidak_valid(empty($kepala['id']) || $kepala['status_dasar'] == 1);
        $this->keluarga_model->add_anggota($id);

        redirect("{$this->controller}/anggota/{$p}/{$o}/{$id}");
    }

    public function update_anggota($p = 1, $o = 0, $id_kk = 0, $id = 0)
    {
        $this->redirect_hak_akses('u');
        $this->redirect_tidak_valid($this->keluarga_model->get_kepala_a($id_kk)['status_dasar'] == 1);
        $this->keluarga_model->update_anggota($id);

        redirect("{$this->controller}/anggota/{$p}/{$o}/{$id_kk}");
    }

    public function delete_anggota($p = 1, $o = 0, $kk = 0, $id = 0)
    {
        $this->redirect_hak_akses('u');
        $this->keluarga_model->rem_anggota($kk, $id);

        redirect("{$this->controller}/anggota/{$p}/{$o}/{$kk}");
    }

    public function keluarkan_anggota($kk, $id = 0)
    {
        $this->redirect_hak_akses('u');
        $this->keluarga_model->rem_anggota(0, $id);

        redirect("{$this->controller}/anggota/1/0/{$kk}");
    }

    public function delete_all_anggota($p = 1, $o = 0, $kk = 0)
    {
        $this->redirect_hak_akses('h');
        $this->keluarga_model->rem_all_anggota($kk);

        redirect("{$this->controller}/anggota/{$p}/{$o}/{$kk}");
    }

    public function statistik($tipe = '0', $nomor = 0, $sex = null)
    {
        $this->clear_session();
        if ($sex == null) {
            if ($nomor != 0) {
                $this->session->sex = $nomor;
            } else {
                $this->session->unset_userdata('sex');
            }
            $this->session->unset_userdata('judul_statistik');
            redirect($this->controller);
        }

        $this->session->unset_userdata('program_bantuan');
        $this->session->sex = ($sex == 0) ? null : $sex;

        switch (true) {
            case $tipe == 'kelas_sosial':
                $session  = 'kelas';
                $kategori = 'KLASIFIKASI SOSIAL : ';
                break;

            case $tipe == 'bantuan_keluarga':
                if (! in_array($nomor, [BELUM_MENGISI, TOTAL])) {
                    $this->session->status_dasar = null;
                }
                $session  = 'bantuan_keluarga';
                $kategori = 'PENERIMA BANTUAN (KELUARGA) : ';
                break;

            case $tipe > 50:
                $program_id                     = preg_replace('/^50/', '', $tipe);
                $this->session->program_bantuan = $program_id;

                $nama = $this->db
                    ->select('nama')
                    ->where('config_id', identitas('id'))
                    ->where('id', $program_id)
                    ->get('program')
                    ->row()
                    ->nama;

                if (! in_array($nomor, [BELUM_MENGISI, TOTAL])) {
                    $this->session->status_dasar = null;
                    $nomor                       = $program_id;
                }
                $kategori = $nama . ' : ';
                $session  = 'bantuan_keluarga';
                $tipe     = 'bantuan_keluarga';
                break;
        }

        if ($nomor != TOTAL) {
            $this->session->{$session} = $nomor;
        }

        $judul = $this->keluarga_model->get_judul_statistik($tipe, $nomor, $sex);

        if ($judul['nama']) {
            $this->session->judul_statistik = $kategori . $judul['nama'];
        } else {
            $this->session->unset_userdata('judul_statistik');
        }

        redirect($this->controller);
    }

    public function cetak_statistik($tipe = 0)
    {
        $data['main'] = $this->keluarga_model->list_data_statistik($tipe);

        $this->load->view('sid/kependudukan/keluarga_print', $data);
    }

    public function search_kumpulan_kk()
    {
        $data['kumpulan_kk'] = $this->session->kumpulan_kk ?: '';
        $data['form_action'] = site_url("{$this->controller}/filter/kumpulan_kk");

        $this->load->view('sid/kependudukan/ajax_search_kumpulan_kk', $data);
    }

    public function ajax_cetak($page = 1, $o = 0, $aksi = '')
    {
        $args = func_get_args();
        if (count($args) == 2 && in_array($args[1], ['cetak', 'unduh'])) {
            $aksi = $args[1];
            $o    = $args[0];
            $page = 1;
        }

        $data['o']                   = $o;
        $data['aksi']                = $aksi;
        $data['form_action']         = site_url("{$this->controller}/cetak/{$page}/{$o}/{$aksi}?id_cb={$this->input->get('id_cb')}");
        $data['form_action_privasi'] = site_url("{$this->controller}/cetak/{$page}/{$o}/{$aksi}/1?id_cb={$this->input->get('id_cb')}");

        $this->load->view('sid/kependudukan/ajax_cetak_bersama', $data);
    }

    public function program_bantuan()
    {
        $this->session->sasaran  = 2;
        $this->session->per_page = 100000;
        $list_bantuan            = $this->program_bantuan_model->get_program(1, false);

        $data = [
            'form_action'     => site_url("{$this->controller}/program_bantuan_proses"),
            'program_bantuan' => $list_bantuan['program'],
            'id_program'      => $this->session->bantuan_keluarga,
        ];

        $this->load->view('sid/kependudukan/pencarian_program_bantuan', $data);
    }

    public function program_bantuan_proses()
    {
        $id_program = $this->input->post('program_bantuan');
        $this->statistik('bantuan_keluarga', $id_program, '0');
    }

    public function nokk_sementara()
    {
        $this->session->nokk_sementara = '0';

        redirect($this->controller);
    }

    public function form_pecah_semua($id = 0)
    {
        $this->redirect_hak_akses('u');
        $data['kk']             = $this->keluarga_model->get_keluarga($id);
        $data['anggota']        = $this->keluarga_model->list_anggota($id, ['dengan_kk' => false]);
        $data['nokk_sementara'] = $this->keluarga_model->nokk_sementara();
        $data['form_action']    = site_url("{$this->controller}/pecah_semua/{$id}");

        $this->load->view('sid/kependudukan/pecah_semua', $data);
    }

    public function pecah_semua($id = 0)
    {
        $this->redirect_hak_akses('u');
        $this->keluarga_model->pecah_semua($id, $this->input->post());

        redirect("{$this->controller}/clear");
    }

    public function dialog_import_pdf()
    {
        $this->redirect_hak_akses('u');
        $this->load->view('sid/kependudukan/ajax_import_pdf_form');
    }

    public function dialog_import_scan_kk()
    {
        $this->redirect_hak_akses('u', '', '', true);
        $data['ocr_available'] = \App\Libraries\KkScanOcrParser::isAvailable();
        $this->load->view('sid/kependudukan/ajax_import_scan_form', $data);
    }

    public function ajax_install_ocr()
    {
        $this->redirect_hak_akses('u', '', '', true);

        if (! function_exists('exec')) {
            echo json_encode([
                'status'  => false,
                'message' => 'Fungsi PHP exec() dinonaktifkan di server hosting.',
            ]);

            return;
        }

        $cmd    = 'python3 -m pip install --user --upgrade opencv-python-headless rapidocr_onnxruntime 2>&1';
        $output = [];
        @exec($cmd, $output, $code);

        if (! \App\Libraries\KkScanOcrParser::isAvailable()) {
            $cmd2 = 'pip3 install --user --upgrade opencv-python-headless rapidocr_onnxruntime 2>&1';
            @exec($cmd2, $output, $code);
        }

        $available = \App\Libraries\KkScanOcrParser::isAvailable();

        if ($available) {
            echo json_encode([
                'status'  => true,
                'message' => 'RapidOCR ONNX Engine berhasil terpasang di server!',
            ]);
        } else {
            echo json_encode([
                'status'  => false,
                'message' => 'Gagal memasang RapidOCR. Pesan: ' . implode(' ', array_slice($output, -2)),
            ]);
        }
    }

    private function find_target_kk_for_import($no_kk_pdf, array $members)
    {
        $kk = $this->db->where('no_kk', $no_kk_pdf)->get('tweb_keluarga')->row_array();
        if ($kk) {
            return [
                'kk'                => $kk,
                'is_nokk_sementara' => false,
                'no_kk_lama'        => null,
            ];
        }

        foreach ($members as $m) {
            $nik = $m['nik'] ?? null;
            $p   = null;

            if (! empty($nik)) {
                $p = $this->db->where('nik', $nik)->get('tweb_penduduk')->row_array();
            }

            if (! $p && ! empty($m['nama'])) {
                $m_nama_clean = strtolower(trim(preg_replace('/[^a-zA-Z ]/', '', $m['nama'])));
                $candidates   = $this->db
                    ->group_start()
                        ->like('nik', '0', 'after')
                        ->or_where('nik IS NULL', null, false)
                    ->group_end()
                    ->where('tanggallahir', $m['tanggallahir'])
                    ->get('tweb_penduduk')
                    ->result_array();

                foreach ($candidates as $cand) {
                    $cand_nama_clean = strtolower(trim(preg_replace('/[^a-zA-Z ]/', '', $cand['nama'])));
                    if ($cand_nama_clean === $m_nama_clean) {
                        $p = $cand;
                        break;
                    }
                }
            }

            if ($p && ! empty($p['id_kk'])) {
                $kk_cand = $this->db->where('id', $p['id_kk'])->get('tweb_keluarga')->row_array();
                if ($kk_cand && (substr($kk_cand['no_kk'], 0, 1) === '0' || $kk_cand['no_kk'] == '0')) {
                    return [
                        'kk'                => $kk_cand,
                        'is_nokk_sementara' => true,
                        'no_kk_lama'        => $kk_cand['no_kk'],
                    ];
                }
            }
        }

        return [
            'kk'                => null,
            'is_nokk_sementara' => false,
            'no_kk_lama'        => null,
        ];
    }

    public function proses_import_scan_kk()
    {
        $this->redirect_hak_akses('u', '', '', true);

        if (empty($_FILES['kk_scan']['tmp_name'])) {
            set_session('error_msg', 'Silakan pilih berkas foto / scan Kartu Keluarga terlebih dahulu.');
            redirect('keluarga');
        }

        $tmpFile = $_FILES['kk_scan']['tmp_name'];
        $ext     = strtolower(pathinfo($_FILES['kk_scan']['name'], PATHINFO_EXTENSION));

        $parsed = \App\Libraries\KkScanOcrParser::parseImage($tmpFile, $_FILES['kk_scan']['name']);

        if (empty($parsed['header']['no_kk']) && empty($parsed['members'])) {
            set_session('error_msg', 'Gagal membaca teks dari hasil scan / foto KK. Pastikan gambar cukup terang, tidak miring, dan tulisan terbaca jelas.');
            redirect('keluarga');
        }

        $target_dir = FCPATH . LOKASI_DOKUMEN;
        if (! is_dir($target_dir)) {
            mkdir($target_dir, 0755, true);
        }
        $no_kk         = ! empty($parsed['header']['no_kk']) ? $parsed['header']['no_kk'] : 'SCAN_' . date('YmdHis');
        $scan_filename = 'KK_SCAN_' . $no_kk . '_' . date('YmdHis') . '.' . ($ext ?: 'jpg');
        @copy($tmpFile, $target_dir . $scan_filename);
        $parsed['pdf_file'] = $scan_filename;

        $target_kk                 = $this->find_target_kk_for_import($parsed['header']['no_kk'], $parsed['members']);
        $kk                        = $target_kk['kk'];
        $data['kk_exists']         = ! empty($kk);
        $data['id_kk']             = $kk ? $kk['id'] : null;
        $data['is_nokk_sementara'] = $target_kk['is_nokk_sementara'];
        $data['no_kk_lama']        = $target_kk['no_kk_lama'];

        $norm       = static fn ($str) => strtolower(preg_replace('/\s+/', '', (string) $str));
        $norm_clean = static fn ($str) => strtoupper(preg_replace('/[^A-Z0-9]/', '', (string) $str));

        $ref_sex       = [1 => 'LAKI-LAKI', 2 => 'PEREMPUAN'];
        $ref_kawin_map = [
            $norm_clean('BELUM KAWIN')          => 1,
            $norm_clean('KAWIN TERCATAT')       => 2,
            $norm_clean('KAWIN BELUM TERCATAT') => 2,
            $norm_clean('KAWIN')                => 2,
            $norm_clean('NIKAH')                => 2,
            $norm_clean('CERAI HIDUP')          => 3,
            $norm_clean('CERAI TERCATAT')       => 3,
            $norm_clean('CERAI BELUM TERCATAT') => 3,
            $norm_clean('CERAI MATI')           => 4,
        ];
        $kawin_rows = $this->db->get('tweb_penduduk_kawin')->result_array();
        $ref_kawin_label = [];
        foreach ($kawin_rows as $row) {
            $ref_kawin_label[$row['id']] = strtoupper(trim($row['nama']));
        }

        if (! empty($parsed['header']['kepala_keluarga'])) {
            $parsed['header']['kepala_keluarga'] = \App\Libraries\KkScanOcrParser::splitConcatenatedName($parsed['header']['kepala_keluarga']);
        }
        if (! empty($parsed['header']['alamat'])) {
            $parsed['header']['alamat'] = \App\Libraries\KkScanOcrParser::splitConcatenatedName($parsed['header']['alamat']);
        }

        foreach ($parsed['members'] as &$m) {
            $nik                    = $m['nik'];
            $p                      = null;
            $is_nik_sementara_match = false;
            $nik_lama               = null;

            if (! empty($nik)) {
                $p = $this->db->where('nik', $nik)->get('tweb_penduduk')->row_array();
            }

            if (! $p && ! empty($m['nama'])) {
                $m_nama_clean = strtolower(trim(preg_replace('/[^a-zA-Z ]/', '', $m['nama'])));
                $candidates   = $this->db
                    ->group_start()
                        ->like('nik', '0', 'after')
                        ->or_where('nik IS NULL', null, false)
                    ->group_end()
                    ->where('tanggallahir', $m['tanggallahir'])
                    ->get('tweb_penduduk')
                    ->result_array();

                foreach ($candidates as $cand) {
                    $cand_nama_clean = strtolower(trim(preg_replace('/[^a-zA-Z ]/', '', $cand['nama'])));
                    if ($cand_nama_clean === $m_nama_clean) {
                        $p                      = $cand;
                        $is_nik_sementara_match = true;
                        $nik_lama               = $cand['nik'];

                        break;
                    }
                }
            }

            if ($p) {
                if (! empty($p['nama']) && $norm_clean($p['nama']) === $norm_clean($m['nama'])) {
                    $m['nama'] = $p['nama'];
                }
                if (! empty($p['nama_ayah']) && (! empty($m['nama_ayah']) && $m['nama_ayah'] !== '-') && $norm_clean($p['nama_ayah']) === $norm_clean($m['nama_ayah'])) {
                    $m['nama_ayah'] = $p['nama_ayah'];
                }
                if (! empty($p['nama_ibu']) && (! empty($m['nama_ibu']) && $m['nama_ibu'] !== '-') && $norm_clean($p['nama_ibu']) === $norm_clean($m['nama_ibu'])) {
                    $m['nama_ibu'] = $p['nama_ibu'];
                }
            } else {
                $m['nama'] = \App\Libraries\KkScanOcrParser::splitConcatenatedName($m['nama']);
                if (! empty($m['nama_ayah'])) {
                    $m['nama_ayah'] = \App\Libraries\KkScanOcrParser::splitConcatenatedName($m['nama_ayah']);
                }
                if (! empty($m['nama_ibu'])) {
                    $m['nama_ibu'] = \App\Libraries\KkScanOcrParser::splitConcatenatedName($m['nama_ibu']);
                }
            }

            $m['db_exists']              = ! empty($p);
            $m['is_nik_sementara_match'] = $is_nik_sementara_match;
            $m['nik_lama']               = $nik_lama;
            $m['status_dasar']           = $p ? $p['status_dasar'] : 1;
            $m['pindah_kk']              = false;
            $m['no_kk_lama']             = null;
            $m['kepala_kk_lama']         = null;
            $m['diff']                   = [];
            if ($p) {
                $m['db_id']             = $p['id'];
                $m['alamat_sebelumnya'] = $p['alamat_sebelumnya'];
            }
        }

        $data['parsed'] = $parsed;

        if ($this->input->is_ajax_request()) {
            $this->load->view('sid/kependudukan/ajax_import_pdf_preview', $data);
        } else {
            $this->render('sid/kependudukan/import_pdf_preview', $data);
        }
    }

    public function proses_import_pdf()
    {
        $this->redirect_hak_akses('u');

        if (empty($_FILES['kk_pdf']['tmp_name'])) {
            set_session('error_msg', 'Silakan pilih file PDF Kartu Keluarga terlebih dahulu.');
            redirect('keluarga');
        }

        $parsed = \App\Libraries\KkPdfParser::parseFile($_FILES['kk_pdf']['tmp_name']);
        if (! $parsed['status'] || empty($parsed['header']['no_kk'])) {
            set_session('error_msg', 'Gagal membaca format Kartu Keluarga PDF. Pastikan file PDF merupakan KK elektronik Dukcapil.');
            redirect('keluarga');
        }

        // Arsipkan file PDF ke folder desa/upload/dokumen/
        $target_dir = FCPATH . LOKASI_DOKUMEN;
        if (! is_dir($target_dir)) {
            mkdir($target_dir, 0755, true);
        }
        $pdf_filename = 'KK_' . $parsed['header']['no_kk'] . '_' . date('YmdHis') . '.pdf';
        @copy($_FILES['kk_pdf']['tmp_name'], $target_dir . $pdf_filename);
        $parsed['pdf_file'] = $pdf_filename;

        $target_kk                 = $this->find_target_kk_for_import($parsed['header']['no_kk'], $parsed['members']);
        $kk                        = $target_kk['kk'];
        $data['kk_exists']         = ! empty($kk);
        $data['id_kk']             = $kk ? $kk['id'] : null;
        $data['is_nokk_sementara'] = $target_kk['is_nokk_sementara'];
        $data['no_kk_lama']        = $target_kk['no_kk_lama'];

        if ($kk && ! empty($kk['tgl_cetak_kk']) && ! empty($parsed['header']['tgl_cetak'])) {
            $tgl_pdf = date('Y-m-d', strtotime($parsed['header']['tgl_cetak']));
            $tgl_db  = date('Y-m-d', strtotime($kk['tgl_cetak_kk']));
            if ($tgl_pdf < $tgl_db) {
                $data['warning_kk_lama'] = 'Tanggal cetak KK PDF (' . tgl_indo($parsed['header']['tgl_cetak']) . ') lebih tua daripada tanggal cetak KK di database (' . tgl_indo($kk['tgl_cetak_kk']) . '). Harap periksa kembali berkas KK yang diunggah.';
            }
        }

        $norm_clean = static fn ($str) => strtoupper(preg_replace('/[^A-Z0-9]/', '', (string) $str));

        $ref_sex   = [1 => 'LAKI-LAKI', 2 => 'PEREMPUAN'];
        $ref_kawin_map = [
            $norm_clean('BELUM KAWIN')          => 1,
            $norm_clean('KAWIN TERCATAT')       => 2,
            $norm_clean('KAWIN BELUM TERCATAT') => 2,
            $norm_clean('KAWIN')                => 2,
            $norm_clean('NIKAH')                => 2,
            $norm_clean('CERAI HIDUP')          => 3,
            $norm_clean('CERAI TERCATAT')       => 3,
            $norm_clean('CERAI BELUM TERCATAT') => 3,
            $norm_clean('CERAI MATI')           => 4,
        ];
        $kawin_rows = $this->db->get('tweb_penduduk_kawin')->result_array();
        $ref_kawin_label = [];
        foreach ($kawin_rows as $row) {
            $ref_kawin_label[$row['id']] = strtoupper(trim($row['nama']));
        }

        $ref_shdk  = [
            1  => 'KEPALA KELUARGA', 2 => 'SUAMI', 3 => 'ISTRI', 4 => 'ANAK', 5 => 'MENANTU',
            6  => 'CUCU', 7 => 'ORANG TUA', 8 => 'MERTUA', 9 => 'FAMILI LAIN', 10 => 'MEMBANTU', 11 => 'LAINNYA',
        ];

        $goldarah_rows = $this->db->get('tweb_golongan_darah')->result_array();
        $ref_goldarah  = [];
        foreach ($goldarah_rows as $row) {
            $ref_goldarah[$row['id']] = strtoupper(trim($row['nama']));
        }

        $agama_rows = $this->db->get('tweb_penduduk_agama')->result_array();
        $ref_agama  = [];
        foreach ($agama_rows as $row) {
            $ref_agama[$row['id']] = strtoupper(trim($row['nama']));
        }

        $pendidikan_rows = $this->db->get('tweb_penduduk_pendidikan_kk')->result_array();
        $ref_pendidikan  = [];
        foreach ($pendidikan_rows as $row) {
            $ref_pendidikan[$row['id']] = strtoupper(trim($row['nama']));
        }

        $pekerjaan_rows = $this->db->get('tweb_penduduk_pekerjaan')->result_array();
        $ref_pekerjaan  = [];
        foreach ($pekerjaan_rows as $row) {
            $ref_pekerjaan[$row['id']] = strtoupper(trim($row['nama']));
        }

        $norm = static fn ($str) => strtolower(preg_replace('/\s+/', '', (string) $str));

        $norm_pend = static function ($str) {
            $clean = strtoupper(trim(preg_replace('/\s+/', ' ', (string) $str)));
            if (preg_match('/^DIPLOMA\s*(I\s*[\/\-]\s*II|1\s*[\/\-]\s*2)/i', $clean) || $clean === 'DIPLOMA I/II' || $clean === 'DIPLOMA I / II') {
                return 'diplomai_ii';
            }
            if (strpos($clean, 'AKADEMI') !== false || strpos($clean, 'DIPLOMA III') !== false || strpos($clean, 'SARJANA MUDA') !== false || strpos($clean, 'S. MUDA') !== false || strpos($clean, 'S.MUDA') !== false) {
                return 'akademidiplomaiiismuda';
            }
            if (preg_match('/STRATA\s*(III|3)\b/i', $clean) || $clean === 'S3') {
                return 'strataiii';
            }
            if (preg_match('/STRATA\s*(II|2)\b/i', $clean) || $clean === 'S2') {
                return 'strataii';
            }
            if (strpos($clean, 'DIPLOMA IV') !== false || preg_match('/STRATA\s*(I|1)\b/i', $clean) || $clean === 'STRATAI' || $clean === 'S1' || $clean === 'D4') {
                return 'diplomaiv_stratai';
            }

            return strtolower(preg_replace('/[^a-z0-9]/i', '', $clean));
        };

        $norm_pek = static function ($str) {
            $clean = strtoupper(trim(preg_replace('/\s+/', ' ', (string) $str)));
            if ($clean === 'PEKERJAAN LAINNYA' || $clean === 'LAINNYA') {
                return 'lainnya';
            }
            if ($clean === 'PEGAWAI NEGERI SIPIL' || $clean === 'PNS' || $clean === 'PEGAWAI NEGERI SIPIL (PNS)') {
                return 'pegawainegerisipilpns';
            }
            if ($clean === 'TENTARA NASIONAL INDONESIA' || $clean === 'TNI' || $clean === 'TENTARA NASIONAL INDONESIA (TNI)') {
                return 'tentaranasionalindonesiatni';
            }
            if ($clean === 'KEPOLISIAN RI' || $clean === 'POLRI' || $clean === 'KEPOLISIAN RI (POLRI)') {
                return 'kepolisianripolri';
            }

            return strtolower(preg_replace('/[^a-z0-9]/i', '', $clean));
        };

        if (! empty($parsed['header']['kepala_keluarga'])) {
            $parsed['header']['kepala_keluarga'] = \App\Libraries\KkScanOcrParser::splitConcatenatedName($parsed['header']['kepala_keluarga']);
        }
        if (! empty($parsed['header']['alamat'])) {
            $parsed['header']['alamat'] = \App\Libraries\KkScanOcrParser::splitConcatenatedName($parsed['header']['alamat']);
        }

        foreach ($parsed['members'] as &$m) {
            $nik                    = $m['nik'];
            $p                      = null;
            $is_nik_sementara_match = false;
            $nik_lama               = null;

            if (! empty($nik)) {
                $p = $this->db->where('nik', $nik)->get('tweb_penduduk')->row_array();
            }

            if (! $p && ! empty($m['nama'])) {
                $m_nama_clean = strtolower(trim(preg_replace('/[^a-zA-Z ]/', '', $m['nama'])));
                $this->db->group_start()
                    ->like('nik', '0', 'after')
                    ->or_where('nik IS NULL', null, false)
                    ->group_end();
                $candidates = $this->db->where('tanggallahir', $m['tanggallahir'])->get('tweb_penduduk')->result_array();
                foreach ($candidates as $cand) {
                    $cand_nama_clean = strtolower(trim(preg_replace('/[^a-zA-Z ]/', '', $cand['nama'])));
                    if ($cand_nama_clean === $m_nama_clean) {
                        $p                      = $cand;
                        $is_nik_sementara_match = true;
                        $nik_lama               = $cand['nik'];

                        break;
                    }
                }
            }

            if ($p) {
                if (! empty($p['nama']) && $norm_clean($p['nama']) === $norm_clean($m['nama'])) {
                    $m['nama'] = $p['nama'];
                }
                if (! empty($p['nama_ayah']) && (! empty($m['nama_ayah']) && $m['nama_ayah'] !== '-') && $norm_clean($p['nama_ayah']) === $norm_clean($m['nama_ayah'])) {
                    $m['nama_ayah'] = $p['nama_ayah'];
                }
                if (! empty($p['nama_ibu']) && (! empty($m['nama_ibu']) && $m['nama_ibu'] !== '-') && $norm_clean($p['nama_ibu']) === $norm_clean($m['nama_ibu'])) {
                    $m['nama_ibu'] = $p['nama_ibu'];
                }
            } else {
                $m['nama'] = \App\Libraries\KkScanOcrParser::splitConcatenatedName($m['nama']);
                if (! empty($m['nama_ayah'])) {
                    $m['nama_ayah'] = \App\Libraries\KkScanOcrParser::splitConcatenatedName($m['nama_ayah']);
                }
                if (! empty($m['nama_ibu'])) {
                    $m['nama_ibu'] = \App\Libraries\KkScanOcrParser::splitConcatenatedName($m['nama_ibu']);
                }
            }

            $m['db_exists']              = ! empty($p);
            $m['is_nik_sementara_match'] = $is_nik_sementara_match;
            $m['nik_lama']               = $nik_lama;
            $m['status_dasar']           = $p ? $p['status_dasar'] : 1;
            $m['pindah_kk']              = false;
            $m['no_kk_lama']             = null;
            $m['kepala_kk_lama']         = null;
            $m['diff']                   = [];

            if ($p) {
                $m['db_id']             = $p['id'];
                $m['alamat_sebelumnya'] = $p['alamat_sebelumnya'];

                if ($p['id_kk'] && $kk && $p['id_kk'] != $kk['id']) {
                    $kk_lama = $this->db->where('id', $p['id_kk'])->get('tweb_keluarga')->row_array();
                    if ($kk_lama && $kk_lama['no_kk'] != $parsed['header']['no_kk']) {
                        $m['pindah_kk']  = true;
                        $m['no_kk_lama'] = $kk_lama['no_kk'];
                        if ($kk_lama['nik_kepala']) {
                            $kepala              = $this->db->where('id', $kk_lama['nik_kepala'])->get('tweb_penduduk')->row_array();
                            $m['kepala_kk_lama'] = $kepala ? $kepala['nama'] : '-';
                        }
                    }
                }

                if ($norm($p['nama']) !== $norm($m['nama'])) {
                    $m['diff']['nama'] = $p['nama'];
                }
                $db_sex = $ref_sex[$p['sex']] ?? '';
                if (! empty($m['sex']) && $norm($db_sex) !== $norm($m['sex'])) {
                    $m['diff']['sex'] = $db_sex;
                }
                if (! empty($m['tempatlahir']) && $norm($p['tempatlahir']) !== $norm($m['tempatlahir'])) {
                    $m['diff']['tempatlahir'] = $p['tempatlahir'];
                }
                if (! empty($m['tanggallahir']) && $p['tanggallahir'] != $m['tanggallahir']) {
                    $m['diff']['tanggallahir'] = $p['tanggallahir'];
                }
                $db_pend = $ref_pendidikan[$p['pendidikan_kk_id']] ?? '';
                if (! empty($m['pendidikan']) && $norm_pend($db_pend) !== $norm_pend($m['pendidikan'])) {
                    $m['diff']['pendidikan'] = $db_pend;
                }
                $db_pek = $ref_pekerjaan[$p['pekerjaan_id']] ?? '';
                if (! empty($m['pekerjaan']) && $norm_pek($db_pek) !== $norm_pek($m['pekerjaan'])) {
                    $m['diff']['pekerjaan'] = $db_pek;
                }
                $db_ag = $ref_agama[$p['agama_id']] ?? '';
                if (! empty($m['agama']) && $norm($db_ag) !== $norm($m['agama'])) {
                    $m['diff']['agama'] = $db_ag;
                }
                $db_shdk = $ref_shdk[$p['kk_level']] ?? '';
                if (! empty($m['hubungan']) && $norm($db_shdk) !== $norm($m['hubungan'])) {
                    $m['diff']['hubungan'] = $db_shdk;
                }
                $db_kawin_id  = $p['status_kawin'];
                $pdf_kawin_id = $ref_kawin_map[$norm_clean($m['status_kawin'])] ?? 1;
                if (! empty($m['status_kawin']) && $db_kawin_id != $pdf_kawin_id) {
                    $m['diff']['status_kawin'] = $ref_kawin_label[$db_kawin_id] ?? 'BELUM KAWIN';
                }
                if (! empty($m['tanggalperkawinan']) && $p['tanggalperkawinan'] != $m['tanggalperkawinan']) {
                    $m['diff']['tanggalperkawinan'] = $p['tanggalperkawinan'];
                }
                $db_goldarah = $ref_goldarah[$p['golongan_darah_id']] ?? '';
                if (! empty($m['golongan_darah']) && $norm($db_goldarah) !== $norm($m['golongan_darah'])) {
                    $m['diff']['golongan_darah'] = $db_goldarah;
                }
            }
        }

        $data['parsed'] = $parsed;

        if ($this->input->is_ajax_request()) {
            $this->load->view('sid/kependudukan/ajax_import_pdf_preview', $data);
        } else {
            $this->render('sid/kependudukan/import_pdf_preview', $data);
        }
    }

    public function simpan_import_pdf()
    {
        $this->redirect_hak_akses('u');
        $parsed_raw = $this->input->post('parsed_data');
        $parsed     = json_decode($parsed_raw, true);

        if (empty($parsed) || empty($parsed['header']['no_kk'])) {
            set_session('error_msg', 'Data Kartu Keluarga tidak valid.');
            redirect('keluarga');
        }

        $header                 = $parsed['header'];
        $members                = $parsed['members'];
        $alamat_sebelumnya_post = $this->input->post('alamat_sebelumnya') ?: [];

        $config_id = identitas('id');

        $cluster    = $this->db->where('rt', $header['rt'])->where('rw', $header['rw'])->get('tweb_wil_clusterdesa')->row_array();
        $id_cluster = $cluster ? $cluster['id'] : 1;

        $norm_clean = static fn ($str) => strtoupper(preg_replace('/[^A-Z0-9]/', '', (string) $str));

        $ref_sex   = [$norm_clean('LAKI-LAKI') => 1, $norm_clean('PEREMPUAN') => 2];
        $ref_kawin = [
            $norm_clean('BELUM KAWIN')          => 1,
            $norm_clean('KAWIN TERCATAT')       => 2,
            $norm_clean('KAWIN BELUM TERCATAT') => 2,
            $norm_clean('KAWIN')                => 2,
            $norm_clean('NIKAH')                => 2,
            $norm_clean('CERAI HIDUP')          => 3,
            $norm_clean('CERAI TERCATAT')       => 3,
            $norm_clean('CERAI BELUM TERCATAT') => 3,
            $norm_clean('CERAI MATI')           => 4,
        ];
        $ref_shdk = [
            $norm_clean('KEPALA KELUARGA') => 1, $norm_clean('SUAMI') => 2, $norm_clean('ISTRI') => 3,
            $norm_clean('ANAK')            => 4, $norm_clean('MENANTU') => 5, $norm_clean('CUCU') => 6,
            $norm_clean('ORANG TUA')       => 7, $norm_clean('ORANGTUA') => 7, $norm_clean('MERTUA') => 8,
            $norm_clean('FAMILI LAIN')     => 9, $norm_clean('PEMBANTU') => 10, $norm_clean('LAINNYA') => 11,
        ];
        $ref_wni = [$norm_clean('WNI') => 1, $norm_clean('WNA') => 2, $norm_clean('DUA KEWARGANEGARAAN') => 3];

        $agama_rows = $this->db->get('tweb_penduduk_agama')->result_array();
        $ref_agama  = [];
        foreach ($agama_rows as $row) {
            $ref_agama[$norm_clean($row['nama'])] = $row['id'];
        }

        $norm_clean_pend = static function ($str) use ($norm_clean) {
            $clean = strtoupper(trim((string) $str));
            if ($clean === 'DIPLOMA I/II' || $clean === 'DIPLOMA I / II' || $clean === 'DIPLOMA I/ II' || $clean === 'DIPLOMA I /II' || preg_match('/^DIPLOMA\s*(I\s*[\/\-]\s*II|1\s*[\/\-]\s*2)/i', $clean)) {
                return 'DIPLOMAI_II';
            }
            if ($clean === 'DIPLOMA III' || $clean === 'DIPLOMA 3' || preg_match('/DIPLOMA\s*(III|3)\b/i', $clean) || strpos($clean, 'AKADEMI') !== false || strpos($clean, 'SARJANA MUDA') !== false || strpos($clean, 'S. MUDA') !== false) {
                return 'DIPLOMAIII';
            }
            if (preg_match('/STRATA\s*(III|3)\b/i', $clean) || $clean === 'S3') {
                return 'STRATAIII';
            }
            if (preg_match('/STRATA\s*(II|2)\b/i', $clean) || $clean === 'S2') {
                return 'STRATAII';
            }
            if (strpos($clean, 'DIPLOMA IV') !== false || preg_match('/STRATA\s*(I|1)\b/i', $clean) || $clean === 'STRATAI' || $clean === 'S1' || $clean === 'D4' || preg_match('/DIPLOMA\s*(IV|4)\s*[\/\-]?\s*STRATA\s*(I|1)\b/i', $clean)) {
                return 'DIPLOMAIV_STRATAI';
            }

            return $norm_clean($clean);
        };

        $pendidikan_rows = $this->db->get('tweb_penduduk_pendidikan_kk')->result_array();
        $ref_pendidikan  = [];
        foreach ($pendidikan_rows as $row) {
            $ref_pendidikan[$norm_clean_pend($row['nama'])] = $row['id'];
            $ref_pendidikan[$norm_clean($row['nama'])]      = $row['id'];

            if ($row['id'] == 6) {
                $ref_pendidikan['DIPLOMAI_II'] = 6;
                $ref_pendidikan[$norm_clean_pend('DIPLOMA I/II')]   = 6;
                $ref_pendidikan[$norm_clean_pend('DIPLOMA I / II')] = 6;
                $ref_pendidikan[$norm_clean('DIPLOMA I/II')]        = 6;
            }
            if ($row['id'] == 7) {
                $ref_pendidikan['DIPLOMAIII'] = 7;
                $ref_pendidikan[$norm_clean_pend('AKADEMI/DIPLOMA III/SARJANA MUDA')]   = 7;
                $ref_pendidikan[$norm_clean_pend('AKADEMI/ DIPLOMA III/ SARJANA MUDA')] = 7;
                $ref_pendidikan[$norm_clean_pend('DIPLOMA III')]                       = 7;
                $ref_pendidikan[$norm_clean_pend('DIPLOMA III/SARJANA MUDA')]           = 7;
                $ref_pendidikan[$norm_clean_pend('AKADEMI/ DIPLOMA III/S. MUDA')]       = 7;
                $ref_pendidikan[$norm_clean_pend('AKADEMI/DIPLOMA III/S.MUDA')]         = 7;
            }
            if ($row['id'] == 8) {
                $ref_pendidikan['DIPLOMAIV_STRATAI'] = 8;
                $ref_pendidikan[$norm_clean_pend('DIPLOMA IV/STRATA I')]   = 8;
                $ref_pendidikan[$norm_clean_pend('DIPLOMA IV/ STRATA I')]  = 8;
                $ref_pendidikan[$norm_clean_pend('DIPLOMA IV / STRATA I')] = 8;
                $ref_pendidikan[$norm_clean('DIPLOMA IV/STRATA I')]        = 8;
                $ref_pendidikan[$norm_clean('DIPLOMA IV/ STRATA I')]       = 8;
                $ref_pendidikan[$norm_clean('DIPLOMA IV / STRATA I')]      = 8;
            }
            if ($row['id'] == 9) {
                $ref_pendidikan['STRATAII'] = 9;
                $ref_pendidikan[$norm_clean('STRATA II')] = 9;
                $ref_pendidikan[$norm_clean('STRATA 2')]  = 9;
                $ref_pendidikan[$norm_clean('S2')]        = 9;
            }
            if ($row['id'] == 10) {
                $ref_pendidikan['STRATAIII'] = 10;
                $ref_pendidikan[$norm_clean('STRATA III')] = 10;
                $ref_pendidikan[$norm_clean('STRATA 3')]   = 10;
                $ref_pendidikan[$norm_clean('S3')]         = 10;
            }
        }

        $pekerjaan_rows = $this->db->get('tweb_penduduk_pekerjaan')->result_array();
        $ref_pekerjaan  = [];
        foreach ($pekerjaan_rows as $row) {
            $key                 = $norm_clean($row['nama']);
            $ref_pekerjaan[$key] = $row['id'];

            if ($row['nama'] === 'LAINNYA') {
                $ref_pekerjaan[$norm_clean('PEKERJAAN LAINNYA')] = $row['id'];
            }
            if (strpos($row['nama'], ' (PNS)') !== false) {
                $ref_pekerjaan[$norm_clean(str_replace(' (PNS)', '', $row['nama']))] = $row['id'];
                $ref_pekerjaan[$norm_clean('PNS')]                                  = $row['id'];
            }
            if (strpos($row['nama'], ' (TNI)') !== false) {
                $ref_pekerjaan[$norm_clean(str_replace(' (TNI)', '', $row['nama']))] = $row['id'];
                $ref_pekerjaan[$norm_clean('TNI')]                                  = $row['id'];
            }
            if (strpos($row['nama'], ' (POLRI)') !== false) {
                $ref_pekerjaan[$norm_clean(str_replace(' (POLRI)', '', $row['nama']))] = $row['id'];
                $ref_pekerjaan[$norm_clean('POLRI')]                                    = $row['id'];
            }
        }

        $goldarah_rows = $this->db->get('tweb_golongan_darah')->result_array();
        $ref_goldarah  = [];
        foreach ($goldarah_rows as $row) {
            $key_raw   = strtoupper(trim($row['nama']));
            $key_clean = strtoupper(preg_replace('/\s+/', '', (string) $row['nama']));
            if (! isset($ref_goldarah[$key_raw])) {
                $ref_goldarah[$key_raw] = $row['id'];
            }
            if (! isset($ref_goldarah[$key_clean])) {
                $ref_goldarah[$key_clean] = $row['id'];
            }
        }

        // 1. Simpan/Update tweb_keluarga
        $kk = $this->db->where('no_kk', $header['no_kk'])->get('tweb_keluarga')->row_array();
        if (! $kk) {
            $target_kk = $this->find_target_kk_for_import($header['no_kk'], $members);
            if ($target_kk['kk']) {
                $kk = $target_kk['kk'];
            }
        }

        if ($kk) {
            $id_kk = $kk['id'];
            $this->db->where('id', $id_kk)->update('tweb_keluarga', [
                'no_kk'        => $header['no_kk'],
                'alamat'       => $header['alamat'] ?: $kk['alamat'],
                'tgl_cetak_kk' => $header['tgl_cetak'] ?: $kk['tgl_cetak_kk'],
                'id_cluster'   => $id_cluster,
                'updated_at'   => date('Y-m-d H:i:s'),
            ]);
        } else {
            $this->db->insert('tweb_keluarga', [
                'config_id'    => $config_id,
                'no_kk'        => $header['no_kk'],
                'alamat'       => $header['alamat'],
                'tgl_cetak_kk' => $header['tgl_cetak'],
                'tgl_daftar'   => date('Y-m-d H:i:s'),
                'id_cluster'   => $id_cluster,
                'updated_at'   => date('Y-m-d H:i:s'),
            ]);
            $id_kk = $this->db->insert_id();
        }

        $kepala_penduduk_id = null;

        // 2. Simpan/Update tweb_penduduk
        foreach ($members as $m) {
            $nik = $m['nik'];
            if (empty($nik)) {
                continue;
            }

            $sex_id          = $ref_sex[$norm_clean($m['sex'])] ?? 1;
            $agama_id        = $ref_agama[$norm_clean($m['agama'])] ?? 1;
            $pendidikan_id   = $ref_pendidikan[$norm_clean_pend($m['pendidikan'])] ?? 1;
            $pekerjaan_id    = $ref_pekerjaan[$norm_clean($m['pekerjaan'])] ?? 1;
            $status_kawin_id = $ref_kawin[$norm_clean($m['status_kawin'])] ?? 1;
            $shdk_id         = $ref_shdk[$norm_clean($m['hubungan'])] ?? 4;
            $wni_id          = $ref_wni[$norm_clean($m['kewarganegaraan'])] ?? 1;
            $clean_goldarah  = strtoupper(trim(preg_replace('/\s+/', '', (string) $m['golongan_darah'])));
            $goldarah_id     = $ref_goldarah[$clean_goldarah] ?? ($ref_goldarah[strtoupper(trim($m['golongan_darah']))] ?? 13);

            $alamat_asal = ! empty($alamat_sebelumnya_post[$nik]) ? trim($alamat_sebelumnya_post[$nik]) : $header['alamat'];

            $p = null;
            if (! empty($m['db_id'])) {
                $p = $this->db->where('id', $m['db_id'])->get('tweb_penduduk')->row_array();
            }
            if (! $p) {
                $p = $this->db->where('nik', $nik)->get('tweb_penduduk')->row_array();
            }

            $is_datang_kembali = $p && $p['status_dasar'] != 1;
            $status_dasar      = 1;

            $data_pend = [
                'config_id'         => $config_id,
                'nama'              => $m['nama'],
                'nik'               => $nik,
                'id_kk'             => $id_kk,
                'kk_level'          => $shdk_id,
                'sex'               => $sex_id,
                'tempatlahir'       => $m['tempatlahir'],
                'tanggallahir'      => $m['tanggallahir'],
                'agama_id'          => $agama_id,
                'pendidikan_kk_id'  => $pendidikan_id,
                'pekerjaan_id'      => $pekerjaan_id,
                'status_kawin'      => $status_kawin_id,
                'tanggalperkawinan' => $m['tanggalperkawinan'] ?: null,
                'warganegara_id'    => $wni_id,
                'nama_ayah'         => $m['nama_ayah'],
                'nama_ibu'          => $m['nama_ibu'],
                'golongan_darah_id' => $goldarah_id,
                'alamat_sekarang'   => $header['alamat'],
                'id_cluster'        => $id_cluster,
                'status'            => 1,
                'status_dasar'      => $status_dasar,
                'updated_at'        => date('Y-m-d H:i:s'),
            ];

            if ($p) {
                $pend_id = $p['id'];
                if ($is_datang_kembali) {
                    $data_pend['alamat_sebelumnya'] = $alamat_asal;
                }
                $this->db->where('id', $pend_id)->update('tweb_penduduk', $data_pend);

                if ($is_datang_kembali) {
                    $tgl_peristiwa_log = ! empty($header['tgl_cetak']) ? date('Y-m-d H:i:s', strtotime($header['tgl_cetak'])) : date('Y-m-d H:i:s');
                    $this->db->insert('log_penduduk', [
                        'config_id'      => $config_id,
                        'id_pend'        => $pend_id,
                        'kode_peristiwa' => 5,
                        'tgl_lapor'      => date('Y-m-d H:i:s'),
                        'tgl_peristiwa'  => $tgl_peristiwa_log,
                        'no_kk'          => $header['no_kk'],
                        'nama_kk'        => $header['kepala_keluarga'],
                        'catatan'        => 'Datang kembali melalui Impor KK PDF',
                        'created_at'     => date('Y-m-d H:i:s'),
                        'created_by'     => $this->session->user ?? 1,
                    ]);
                }
            } else {
                $data_pend['alamat_sebelumnya'] = $alamat_asal;
                $data_pend['created_at']        = date('Y-m-d H:i:s');
                $data_pend['created_by']        = $this->session->user ?? 1;
                $this->db->insert('tweb_penduduk', $data_pend);
                $pend_id = $this->db->insert_id();

                // Catat log_penduduk untuk Penduduk Masuk (kode_peristiwa = 5)
                $tgl_peristiwa_log = ! empty($header['tgl_cetak']) ? date('Y-m-d H:i:s', strtotime($header['tgl_cetak'])) : date('Y-m-d H:i:s');
                $this->db->insert('log_penduduk', [
                    'config_id'      => $config_id,
                    'id_pend'        => $pend_id,
                    'kode_peristiwa' => 5,
                    'tgl_lapor'      => date('Y-m-d H:i:s'),
                    'tgl_peristiwa'  => $tgl_peristiwa_log,
                    'no_kk'          => $header['no_kk'],
                    'nama_kk'        => $header['kepala_keluarga'],
                    'created_at'     => date('Y-m-d H:i:s'),
                    'created_by'     => $this->session->user ?? 1,
                ]);
            }

            if ($shdk_id == 1) {
                $kepala_penduduk_id = $pend_id;
            }
        }

        if ($kepala_penduduk_id) {
            $this->db->where('id', $id_kk)->update('tweb_keluarga', ['nik_kepala' => $kepala_penduduk_id]);

            // Clean up any orphaned temporary KK records for this head of family or members
            $member_ids = array_filter(array_column($members, 'db_id'));
            $this->db
                ->group_start()
                    ->where('nik_kepala', $kepala_penduduk_id);
            if (! empty($member_ids)) {
                $this->db->or_where_in('nik_kepala', $member_ids);
            }
            $orphaned_kks = $this->db
                ->group_end()
                ->where('id !=', $id_kk)
                ->group_start()
                    ->like('no_kk', '0', 'after')
                    ->or_where('no_kk', '0')
                ->group_end()
                ->get('tweb_keluarga')
                ->result_array();

            foreach ($orphaned_kks as $orph_kk) {
                $member_count = $this->db
                    ->where('id_kk', $orph_kk['id'])
                    ->where('status_dasar', 1)
                    ->count_all_results('tweb_penduduk');

                if ($member_count === 0) {
                    $this->db->where('id', $orph_kk['id'])->delete('tweb_keluarga');
                }
            }
        }

        // Arsipkan rekaman dokumen ke tabel `dokumen` OpenSID
        if (! empty($parsed['pdf_file']) && file_exists(FCPATH . LOKASI_DOKUMEN . $parsed['pdf_file'])) {
            $id_pend_dok = $kepala_penduduk_id ?: ($members[0]['db_id'] ?? null);
            if ($id_pend_dok) {
                $this->db->insert('dokumen', [
                    'config_id'  => $config_id,
                    'satuan'     => $parsed['pdf_file'],
                    'nama'       => 'Kartu Keluarga ' . $header['no_kk'],
                    'enabled'    => 1,
                    'tgl_upload' => date('Y-m-d H:i:s'),
                    'id_pend'    => $id_pend_dok,
                    'kategori'   => 1,
                    'dok_warga'  => 1,
                    'tipe'       => 1,
                    'tahun'      => date('Y'),
                    'attr'       => json_encode([]),
                    'created_at' => date('Y-m-d H:i:s'),
                    'created_by' => $this->session->user ?? 1,
                ]);
            }
        }

        $this->cache->hapus_cache_untuk_semua('_wilayah');
        set_session('success', 1);
        set_session('flash_message', 'Data Kartu Keluarga dan Anggota berhasil disimpan/diperbarui. <a href="' . site_url("keluarga/kartu_keluarga/1/0/{$id_kk}") . '" target="_blank" class="btn btn-xs btn-primary" style="margin-left: 10px; color: #fff; text-decoration: none;"><i class="fa fa-external-link"></i> Lihat Kartu Keluarga</a>');

        redirect('keluarga');
    }

    public function dialog_pindah_kk($id_kk = 0)
    {
        $this->redirect_hak_akses('u');

        $data['kk']              = $this->keluarga_model->get_keluarga($id_kk);
        $data['anggota']         = $this->keluarga_model->list_anggota($id_kk);
        $data['list_ref_pindah'] = $this->referensi_model->list_data('ref_pindah');
        $data['form_action']     = site_url("{$this->controller}/proses_pindah_kk/{$id_kk}");

        $this->load->view('sid/kependudukan/ajax_pindah_kk_form', $data);
    }

    public function proses_pindah_kk($id_kk = 0)
    {
        $this->redirect_hak_akses('u');

        $id_pend_pindah    = $this->input->post('id_cb') ?: [];
        $tgl_peristiwa     = rev_tgl($this->input->post('tgl_peristiwa'));
        $tgl_lapor         = rev_tgl($this->input->post('tgl_lapor'));
        $ref_pindah        = $this->input->post('ref_pindah');
        $alamat_tujuan     = strip_tags($this->input->post('alamat_tujuan'));
        $catatan           = alfanumerik_spasi($this->input->post('catatan'));
        $kepala_kk_baru_id = $this->input->post('kepala_kk_baru');

        if (empty($id_pend_pindah)) {
            session_error('Pilih minimal satu anggota keluarga yang akan dipindahkan.');
            redirect("{$this->controller}/anggota/1/0/{$id_kk}");
        }

        $this->db->trans_start();

        $kk_lama       = $this->keluarga_model->get_keluarga($id_kk);
        $semua_anggota = $this->keluarga_model->list_anggota($id_kk);

        // 1. Ubah Status Dasar Pindah (3) untuk anggota yang dicentang
        foreach ($id_pend_pindah as $id_pend) {
            $pend = $this->penduduk_model->get_penduduk($id_pend);

            $this->db->where('id', $id_pend)->update('tweb_penduduk', [
                'status_dasar' => 3,
                'updated_at'   => date('Y-m-d H:i:s'),
                'updated_by'   => $this->session->user,
            ]);

            $log_pend = [
                'config_id'      => identitas('id'),
                'id_pend'        => $id_pend,
                'no_kk'          => $pend['no_kk'],
                'nama_kk'        => $pend['kepala_kk'],
                'tgl_peristiwa'  => $tgl_peristiwa,
                'tgl_lapor'      => $tgl_lapor,
                'kode_peristiwa' => 3,
                'ref_pindah'     => $ref_pindah ?: 1,
                'alamat_tujuan'  => $alamat_tujuan,
                'catatan'        => $catatan,
            ];
            $this->penduduk_model->tulis_log_penduduk_data($log_pend);
        }

        // 2. Evaluasi Sisa Anggota Keluarga
        $sisa_anggota_aktif = array_values(array_filter($semua_anggota, static function ($m) use ($id_pend_pindah) {
            $status_dasar = $m['status_dasar'] ?? $m['status_dasar_id'] ?? 1;
            return ! in_array($m['id'], $id_pend_pindah) && $status_dasar == 1;
        }));

        if (empty($sisa_anggota_aktif)) {
            // SELURUH KK PINDAH -> Log keluarga pindah
            $this->keluarga_model->log_keluarga($id_kk, \App\Models\LogKeluarga::KEPALA_KELUARGA_PINDAH);
        } else {
            // PINDAH SEBAGIAN -> Cek apakah Kepala KK lama ikut pindah
            $kepala_kk_lama_pindah = in_array($kk_lama['nik_kepala'], $id_pend_pindah);

            if ($kepala_kk_lama_pindah) {
                // ATURAN DUKCAPIL: Kepala KK Lama Pindah -> Sisa Anggota Dibuatkan KK Baru (No. KK Sementara)
                usort($sisa_anggota_aktif, static function ($a, $b) {
                    return strtotime($a['tanggallahir']) <=> strtotime($b['tanggallahir']);
                });

                // Pilih kepala KK baru (pilihan operator atau otomatis tertua)
                $kepala_kk_baru = null;
                if (! empty($kepala_kk_baru_id)) {
                    foreach ($sisa_anggota_aktif as $candidate) {
                        if ($candidate['id'] == $kepala_kk_baru_id) {
                            $kepala_kk_baru = $candidate;
                            break;
                        }
                    }
                }
                if (! $kepala_kk_baru) {
                    $kepala_kk_baru = $sisa_anggota_aktif[0];
                }

                $nokk_sementara = $this->keluarga_model->nokk_sementara();

                // Buat KK Baru untuk sisa anggota
                $data_kk_baru = [
                    'config_id'    => identitas('id'),
                    'no_kk'        => $nokk_sementara,
                    'nik_kepala'   => $kepala_kk_baru['id'],
                    'alamat'       => $kk_lama['alamat'],
                    'id_cluster'   => $kk_lama['id_cluster'],
                    'tgl_daftar'   => date('Y-m-d H:i:s'),
                    'updated_at'   => date('Y-m-d H:i:s'),
                    'updated_by'   => $this->session->user,
                ];
                $this->db->insert('tweb_keluarga', $data_kk_baru);
                $id_kk_baru = $this->db->insert_id();

                // Pindahkan sisa anggota ke KK Baru & atur kk_level
                foreach ($sisa_anggota_aktif as $anggota) {
                    $level = ($anggota['id'] == $kepala_kk_baru['id']) ? 1 : $anggota['kk_level'];
                    $this->db->where('id', $anggota['id'])->update('tweb_penduduk', [
                        'id_kk'            => $id_kk_baru,
                        'kk_level'         => $level,
                        'no_kk_sebelumnya' => $kk_lama['no_kk'],
                        'updated_at'       => date('Y-m-d H:i:s'),
                        'updated_by'       => $this->session->user,
                    ]);
                }

                // Catat log keluarga baru
                $this->keluarga_model->log_keluarga($id_kk_baru, \App\Models\LogKeluarga::KELUARGA_BARU);
            }
        }

        $this->db->trans_complete();
        $this->cache->hapus_cache_untuk_semua('_wilayah');

        if ($this->db->trans_status() === false) {
            session_error('Gagal memproses pemindahan penduduk kolektif.');
        } else {
            session_success();
            set_session('flash_message', 'Berhasil memindahkan ' . count($id_pend_pindah) . ' anggota keluarga. Sisa anggota keluarga telah diproses sesuai ketentuan.');
        }

        redirect("{$this->controller}/anggota/1/0/{$id_kk}");
    }
}
