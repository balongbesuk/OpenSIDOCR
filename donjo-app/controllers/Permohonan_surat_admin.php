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

use App\Libraries\TinyMCE;
use App\Models\FormatSurat;
use App\Models\Penduduk;
use App\Models\PermohonanSurat;

defined('BASEPATH') || exit('No direct script access allowed');

class Permohonan_surat_admin extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model(['permohonan_surat_model', 'penduduk_model', 'surat_model', 'keluarga_model', 'mailbox_model', 'surat_master_model']);
        $this->modul_ini     = 'layanan-surat';
        $this->sub_modul_ini = 'permohonan-surat';
    }

    public function index()
    {
        return view('admin.permohonan_surat.index', [
            'list_status_permohonan' => $this->referensi_model->list_ref_flip(STATUS_PERMOHONAN),
        ]);
    }

    public function datatables()
    {
        if ($this->input->is_ajax_request()) {
            return datatables(PermohonanSurat::query())
                ->addIndexColumn()
                ->addColumn('aksi', static function ($row) {
                    $aksi = '';

                    if (can('u')) {
                        if ($row->status == PermohonanSurat::BELUM_LENGKAP) {
                            $aksi .= '<a class="btn btn-social bg-navy btn-flat btn-sm btn-proses" title="Surat Belum Lengkap" style="width: 170px"><i class="fa fa-info-circle"></i> ' . PermohonanSurat::STATUS_PERMOHONAN[PermohonanSurat::BELUM_LENGKAP] . '</a> ';
                        } elseif ($row->status == PermohonanSurat::SEDANG_DIPERIKSA) {
                            $aksi .= '<a href="' . route('permohonan_surat_admin/periksa', $row->id) . '" class="btn btn-social btn-info btn-flat btn-sm pesan-hover" title="Klik untuk memeriksa" style="width: 170px"><i class="fa fa-spinner"></i>' . PermohonanSurat::STATUS_PERMOHONAN[PermohonanSurat::SEDANG_DIPERIKSA] . '</a> ';
                        } elseif ($row->status == PermohonanSurat::MENUNGGU_TANDA_TANGAN) {
                            if (in_array($row->surat->jenis, FormatSurat::TINYMCE) && (setting('verifikasi_sekdes') || setting('verifikasi_kades'))) {
                                $aksi .= '<a class="btn btn-social bg-purple btn-flat btn-sm btn-proses" title="Surat Menunggu Tandatangan" style="width: 170px"><i class="fa fa-edit"></i>' . PermohonanSurat::STATUS_PERMOHONAN[PermohonanSurat::MENUNGGU_TANDA_TANGAN] . '</a> ';
                            } else {
                                $aksi .= '<a href="#" data-href="' . route("permohonan_surat_admin/proses/{$row->id}/3") . '" class="btn btn-social bg-purple btn-flat btn-sm" title="Surat Menunggu Tandatangan" data-toggle="modal" data-target="#confirm-status" data-body="Apakah Anda yakin ingin memproses status surat ini menjadi Siap Diambil?" style="width: 170px"><i class="fa fa-edit"></i>' . PermohonanSurat::STATUS_PERMOHONAN[PermohonanSurat::MENUNGGU_TANDA_TANGAN] . '</a> ';
                            }
                        } elseif ($row->status == PermohonanSurat::SIAP_DIAMBIL) {
                            $aksi .= '<a href="#" data-href="' . route("permohonan_surat_admin/proses/{$row->id}/4") . '" class="btn btn-social bg-orange btn-flat btn-sm pesan-hover" title="Klik jika telah diambil" data-toggle="modal" data-target="#confirm-status" data-body="Apakah Anda yakin surat ini sudah diambil oleh warga?" style="width: 170px"><i class="fa fa-thumbs-o-up"></i>' . PermohonanSurat::STATUS_PERMOHONAN[PermohonanSurat::SIAP_DIAMBIL] . '</a> ';
                        } elseif ($row->status == PermohonanSurat::SUDAH_DIAMBIL) {
                            $aksi .= '<a class="btn btn-social btn-success btn-flat btn-sm btn-proses" title="Surat Sudah Diambil" style="width: 170px"><i class="fa fa-check"></i>' . PermohonanSurat::STATUS_PERMOHONAN[PermohonanSurat::SUDAH_DIAMBIL] . '</a> ';
                        } else {
                            $aksi .= '<a class="btn btn-social btn-danger btn-flat btn-sm btn-proses" title="Surat Dibatalkan" style="width: 170px"><i class="fa fa-times"></i>' . PermohonanSurat::STATUS_PERMOHONAN[PermohonanSurat::DIBATALKAN] . '</a> ';
                        }
                    }

                    return $aksi;
                })
                ->editColumn('no_antrian', static function ($row) {
                    return get_antrian($row->no_antrian);
                })
                ->editColumn('no_hp_aktif', static function ($row) {
                    $hp = $row->no_hp_aktif;
                    if ($hp) {
                        $clean = preg_replace('/[^0-9]/', '', (string) $hp);
                        $clean = preg_replace('/^(62|0)/', '', $clean);
                        return ! empty($clean) ? ('62' . $clean) : '-';
                    }
                    return '-';
                })
                ->editColumn('created_at', static function ($row) {
                    return tgl_indo2($row->created_at);
                })
                ->rawColumns(['aksi'])
                ->make();
        }

        return show_404();
    }

    public function periksa($id = '')
    {
        // Cek hanya status = 1 (sedang diperiksa) yg boleh di proses
        $periksa = PermohonanSurat::whereStatus(PermohonanSurat::SEDANG_DIPERIKSA)->find($id);

        if (! $id || ! $periksa) {
            show_404();
        }
        $url = $periksa->surat->url_surat;

        $data['periksa']      = $periksa;
        $data['surat']        = $periksa->surat;
        $data['url']          = $url;
        $data['list_dokumen'] = $this->penduduk_model->list_dokumen($periksa->id_pemohon);
        $data['individu']     = $this->surat_model->get_penduduk($periksa->id_pemohon);

        $this->get_data_untuk_form($url, $data);
        $data['isian_form']        = json_encode($this->ambil_isi_form($data['periksa']['isian_form']));
        $data['surat_url']         = rtrim($_SERVER['REQUEST_URI'], '/clear');
        $data['syarat_permohonan'] = $this->permohonan_surat_model->get_syarat_permohonan($id);
        $data['form_action']       = site_url("surat/periksa_doc/{$id}/{$url}");
        $data['form_surat']        = 'surat/form_surat.php';

        $data_form = $this->surat_model->get_data_form($url);
        if (is_file($data_form)) {
            include $data_form;
        }

        if (in_array($data['surat']['jenis'], FormatSurat::TINYMCE)) {
            $data['list_dokumen'] = empty($_POST['nik']) ? null : $this->penduduk_model->list_dokumen($data['individu']['id']);
            $data['form_action']  = route("surat/pratinjau/{$url}/{$id}");
            $data['form_surat']   = 'surat/form_surat_tinymce.php';
        }

        $this->render('mandiri/periksa_surat', $data);
    }

    public function proses($id = '', $status = '')
    {
        $this->redirect_hak_akses('u');
        $this->cek_referer();

        // Status Belum Lengkap (0) dan Dibatalkan (5) wajib melalui alur kirim_pesan dengan alasan
        if (in_array((int) $status, [PermohonanSurat::BELUM_LENGKAP, PermohonanSurat::DIBATALKAN], true) && ! $this->input->post('pesan')) {
            redirect_with('error', 'Perubahan status ini harus melalui form konfirmasi pesan.', 'permohonan_surat_admin');
        }

        $this->permohonan_surat_model->proses($id, $status);

        redirect('permohonan_surat_admin');
    }

    // TODO:: Duplikasi dengan kode yang ada di donjo-app/controllers/Surat.php
    private function get_data_untuk_form($url, &$data)
    {
        // RTF
        if (in_array($data['surat']['jenis'], FormatSurat::RTF)) {
            $data['config']    = $data['lokasi'] = $this->header['desa'];
            $data['perempuan'] = $this->surat_model->list_penduduk_perempuan();
            $data['anggota']   = $this->keluarga_model->list_anggota($data['individu']['id_kk']);
        }

        // Panggil 1 penduduk berdasarkan datanya sendiri
        $data['penduduk'] = [$data['periksa']['penduduk']];

        $data['surat_terakhir']     = $this->surat_model->get_last_nosurat_log($url);
        $data['input']              = $this->input->post();
        $data['input']['nomor']     = $data['surat_terakhir']['no_surat_berikutnya'];
        $data['format_nomor_surat'] = $this->penomoran_surat_model->format_penomoran_surat($data);

        $tinymce           = new TinyMCE();
        $penandatangan     = $tinymce->formPenandatangan();
        $data['pamong']    = $penandatangan['penandatangan'];
        $data['atas_nama'] = $penandatangan['atas_nama'];
    }

    private function ambil_isi_form($isian_form)
    {
        $hapus = ['url_surat', 'url_remote', 'nik', 'id_surat', 'nomor', 'pilih_atas_nama', 'pamong', 'pamong_nip', 'jabatan', 'pamong_id'];

        foreach ($hapus as $kolom) {
            unset($isian_form[$kolom]);
        }

        return $isian_form;
    }

    public function konfirmasi($id_permohonan = 0, $tipe = 0)
    {
        $data['form_action'] = site_url("permohonan_surat_admin/kirim_pesan/{$id_permohonan}/{$tipe}");

        $this->load->view('surat/form/konfirmasi_permohonan', $data);
    }

    public function kirim_pesan($id_permohonan = 0, $tipe = 0)
    {
        $this->redirect_hak_akses('u');
        $this->cek_referer();

        $periksa = $this->permohonan_surat_model->get_permohonan(['id' => $id_permohonan]);
        if (! $periksa) {
            redirect('permohonan_surat_admin');
            return;
        }

        $pemohon      = $this->surat_model->get_penduduk($periksa['id_pemohon']);
        $format_surat = FormatSurat::find($periksa['id_surat']);
        $nama_surat   = $format_surat->nama ?? 'Surat';
        $post         = $this->input->post();
        $judul        = ($tipe == 0) ? 'Perlu Dilengkapi' : 'Dibatalkan';
        $data         = [
            'subjek'     => 'Permohonan Surat ' . $nama_surat . ' - ' . $judul,
            'komentar'   => $post['pesan'],
            'owner'      => 'Pemerintah Desa',
            'email'      => $pemohon['nik'],
            'permohonan' => $id_permohonan,
            'tipe'       => 2,
            'status'     => 2,
        ];

        $this->mailbox_model->insert($data);
        $this->proses($id_permohonan, $tipe);

        redirect('permohonan_surat_admin');
    }

    public function tampilkan($id_dokumen, $id_pend = 0)
    {
        $this->load->model('Web_dokumen_model');
        $berkas = $this->web_dokumen_model->get_nama_berkas($id_dokumen, $id_pend);

        if (! $id_dokumen || ! $id_pend || ! $berkas || ! file_exists(LOKASI_DOKUMEN . $berkas)) {
            $data['link_berkas'] = null;
        } else {
            $data = [
                'link_berkas' => site_url("dokumen/tampilkan_berkas/{$id_dokumen}/{$id_pend}"),
                'tipe'        => get_extension($berkas),
                'link_unduh'  => site_url("dokumen/unduh_berkas/{$id_dokumen}/{$id_pend}"),
            ];
        }
        $this->load->view('global/tampilkan', $data);
    }

    private function cek_referer()
    {
        $referer      = $_SERVER['HTTP_REFERER'] ?? '';
        $referer_host = parse_url($referer, PHP_URL_HOST) ?? '';
        $server_host  = parse_url(site_url(), PHP_URL_HOST) ?: ($_SERVER['HTTP_HOST'] ?? '');

        $referer_host = explode(':', $referer_host)[0];
        $server_host  = explode(':', $server_host)[0];

        if (empty($referer) || strcasecmp($referer_host, $server_host) !== 0) {
            redirect_with('error', 'Akses tidak diizinkan.', 'permohonan_surat_admin');
        }
    }
}
