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

defined('BASEPATH') || exit('No direct script access allowed');

class Beranda extends Mandiri_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model(['mandiri_model', 'penduduk_model', 'kelompok_model', 'web_dokumen_model', 'pendapat_model', 'mailbox_model', 'permohonan_surat_model']);
        $this->load->helper('download');
        $this->load->library('OTP/OTP_manager', null, 'otp_library');
    }

    public function index()
    {
        $id_pend = (int) $this->is_login->id_pend;
        $nik = $this->is_login->nik;

        $permohonan_list = $this->permohonan_surat_model->list_permohonan_perorangan($id_pend, 1) ?: [];
        $pesan_list = $this->mailbox_model->get_all_pesan($nik, 2) ?: [];
        $penduduk = $this->penduduk_model->get_penduduk($id_pend);

        $tgl_tele = $this->otp_library->driver('telegram')->cek_verifikasi_otp($id_pend);
        $tgl_email = $this->otp_library->driver('email')->cek_verifikasi_otp($id_pend);

        $akun_penduduk = $this->db->select('telegram, email, telegram_tgl_verifikasi, email_tgl_verifikasi')
            ->where('id', $id_pend)
            ->get('tweb_penduduk')
            ->row();

        $data = [
            'permohonan_terkini'      => array_slice($permohonan_list, 0, 5),
            'total_permohonan'        => count($permohonan_list),
            'pesan_terkini'           => array_slice($pesan_list, 0, 3),
            'total_pesan'             => count($pesan_list),
            'penduduk'                => $penduduk,
            'tgl_verifikasi_telegram' => $tgl_tele,
            'tgl_verifikasi_email'    => $tgl_email,
            'akun_penduduk'           => $akun_penduduk,
        ];

        $this->render('beranda', $data);
    }

    public function profil()
    {
        $data = [
            'penduduk' => $this->penduduk_model->get_penduduk($this->is_login->id_pend),
            'kelompok' => $this->penduduk_model->list_kelompok($this->is_login->id_pend),
        ];

        $this->render('profil', $data);
    }

    public function cetak_biodata()
    {
        $data = [
            'desa'     => $this->header,
            'penduduk' => $this->penduduk_model->get_penduduk($this->is_login->id_pend),
        ];

        $this->load->view('sid/kependudukan/cetak_biodata', $data);
    }

    public function cetak_kk()
    {
        if ($this->is_login->id_kk == 0) {
            // Jika diakses melalui URL
            $respon = [
                'status' => 1,
                'pesan'  => 'Anda tidak terdaftar dalam sebuah keluarga',
            ];
            $this->session->set_flashdata('notif', $respon);

            redirect('layanan-mandiri/beranda');
        }

        $data = $this->keluarga_model->get_data_cetak_kk($this->is_login->id_kk);

        $this->load->view('sid/kependudukan/cetak_kk_all', $data);
    }

    public function ganti_pin()
    {
        $data = [
            'tgl_verifikasi_telegram' => $this->otp_library->driver('telegram')->cek_verifikasi_otp($this->is_login->id_pend),
            'tgl_verifikasi_email'    => $this->otp_library->driver('email')->cek_verifikasi_otp($this->is_login->id_pend),
            'cek_anjungan'            => $this->cek_anjungan,
            'form_action'             => site_url('layanan-mandiri/proses-ganti-pin'),
        ];

        $this->render('ganti_pin', $data);
    }

    public function proses_ganti_pin()
    {
        $this->mandiri_model->ganti_pin();
        redirect('layanan-mandiri/ganti-pin');
    }

    public function keluar()
    {
        $this->mandiri_model->logout();
        redirect('layanan-mandiri/masuk');
    }

    // TODO: Pindahkan ke model
    public function pendapat(int $pilihan = 1)
    {
        $data = [
            'config_id' => identitas('id'),
            'pengguna'  => $this->is_login->id_pend,
            'pilihan'   => $pilihan,
        ];

        $this->pendapat_model->insert($data);
        redirect('layanan-mandiri/keluar');
    }
}
