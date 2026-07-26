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

use App\Libraries\Release;
use App\Models\Bantuan;
use App\Models\Kelompok;
use App\Models\Keluarga;
use App\Models\LogSurat;
use App\Models\Penduduk;
use App\Models\PendudukMandiri;
use App\Models\RefJabatan;
use App\Models\Rtm;
use App\Models\Wilayah;

defined('BASEPATH') || exit('No direct script access allowed');

class Hom_sid extends Admin_Controller
{
    public $isAdmin;

    public function __construct()
    {
        parent::__construct();

        $this->isAdmin = $this->session->isAdmin->pamong;
    }

    public function index()
    {
        get_pesan_opendk(); //ambil pesan baru di opendk

        $this->modul_ini = 'home';

        $this->load->library('saas');

        $bulan_ini = date('m');
        $tahun_ini = date('Y');
        
        $mutasi_penduduk_bulan_ini = $this->db
            ->select('kode_peristiwa, count(*) as jumlah')
            ->from('log_penduduk')
            ->where('MONTH(tgl_lapor)', $bulan_ini)
            ->where('YEAR(tgl_lapor)', $tahun_ini)
            ->where_in('kode_peristiwa', [1, 2, 3, 4, 5])
            ->group_by('kode_peristiwa')
            ->get()->result_array();
            
        $trend_penduduk = 0;
        foreach ($mutasi_penduduk_bulan_ini as $row) {
            if (in_array($row['kode_peristiwa'], [1, 5])) $trend_penduduk += $row['jumlah'];
            if (in_array($row['kode_peristiwa'], [2, 3, 4])) $trend_penduduk -= $row['jumlah'];
        }

        $mutasi_keluarga_bulan_ini = $this->db
            ->select('id_peristiwa, count(*) as jumlah')
            ->from('log_keluarga')
            ->where('MONTH(tgl_peristiwa)', $bulan_ini)
            ->where('YEAR(tgl_peristiwa)', $tahun_ini)
            ->where_in('id_peristiwa', [1, 2, 3, 4])
            ->group_by('id_peristiwa')
            ->get()->result_array();
            
        $trend_keluarga = 0;
        foreach ($mutasi_keluarga_bulan_ini as $row) {
            if ($row['id_peristiwa'] == 1) $trend_keluarga += $row['jumlah'];
            else $trend_keluarga -= $row['jumlah'];
        }

        $data = [
            'rilis'           => $this->getUpdate(),
            'bantuan'         => $this->bantuan(),
            'penduduk'        => Penduduk::status()->count(),
            'keluarga'        => Keluarga::status()->count(),
            'rtm'             => Rtm::status()->count(),
            'kelompok'        => Kelompok::status()->tipe()->count(),
            'dusun'           => Wilayah::dusun()->count(),
            'pendaftaran'     => PendudukMandiri::status()->count(),
            'surat'           => $this->logSurat(),
            'saas'            => $this->saas->peringatan(),
            'notif_langganan' => $this->pelanggan_model->status_langganan(),
            'trend_penduduk'  => $trend_penduduk,
            'trend_keluarga'  => $trend_keluarga,
        ];

        return view('admin.home.index', $data);
    }

    private function getUpdate()
    {
        $info = ['update_available' => false];
        if (cek_koneksi_internet() && ! config_item('demo_mode')) {
            $url_rilis = config_item('rilis_umum');

            $release = new Release();
            $release->setApiUrl($url_rilis)->setCurrentVersion();

            if ($release->isAvailable()) {
                $info['update_available'] = $release->isAvailable();
                $info['current_version']  = 'v' . AmbilVersi();
                $info['latest_version']   = $release->getLatestVersion() . (PREMIUM ? '-premium' : '');
                $info['release_name']     = $release->getReleaseName();
                $info['release_body']     = $release->getReleaseBody();
                $info['url_download']     = $release->getReleaseDownload();
            }
        }

        return $info;
    }

    private function bantuan()
    {
        $program                = Bantuan::with('peserta')->whereId($this->setting->dashboard_program_bantuan)->first();
        $bantuan['jumlah']      = $program ? $program->peserta->count() : Bantuan::status()->count();
        $bantuan['nama']        = $program ? $program->nama : 'Bantuan';
        $bantuan['link_detail'] = $program ? ('statistik/clear/50' . $this->setting->dashboard_program_bantuan) : 'program_bantuan';
        $bantuan['program']     = Bantuan::status()->pluck('nama', 'id');

        return $bantuan;
    }

    protected function logSurat()
    {
        return LogSurat::whereNull('deleted_at')
            ->when($this->isAdmin->jabatan_id == kades()->id, static function ($q) {
                return $q->when(setting('tte') == 1, static function ($tte) {
                    return $tte->where('tte', '=', 1);
                })
                    ->when(setting('tte') == 0, static function ($tte) {
                        return $tte->where('verifikasi_kades', '=', '1');
                    })
                    ->orWhere(static function ($verifikasi) {
                        $verifikasi->whereNull('verifikasi_operator');
                    });
            })
            ->when($this->isAdmin->jabatan_id == sekdes()->id, static function ($q) {
                return $q->where('verifikasi_sekdes', '=', '1')->orWhereNull('verifikasi_operator');
            })
            ->when($this->isAdmin == null || ! in_array($this->isAdmin->jabatan_id, RefJabatan::getKadesSekdes()), static function ($q) {
                return $q->where('verifikasi_operator', '=', '1')->orWhereNull('verifikasi_operator');
            })->count();
    }

    public function grafik_kependudukan()
    {
        $tahun_filter = $this->input->get('tahun') ?: date('Y');
        
        $total_penduduk_sekarang = Penduduk::status()->count();
        $total_keluarga_sekarang = Keluarga::status()->count();

        if (preg_match('/^(\d+)_tahun$/', $tahun_filter, $matches)) {
            $tahun_range = (int) $matches[1] - 1;
            $tahun_mulai = date('Y') - $tahun_range;
            $tahun_akhir = date('Y');

            $mutasi_penduduk = $this->db
                ->select('YEAR(tgl_lapor) as tahun, kode_peristiwa, count(*) as jumlah')
                ->from('log_penduduk')
                ->where('YEAR(tgl_lapor) >=', $tahun_mulai)
                ->where_in('kode_peristiwa', [1, 2, 3, 4, 5])
                ->group_by('YEAR(tgl_lapor), kode_peristiwa')
                ->get()->result_array();

            $mutasi_keluarga = $this->db
                ->select('YEAR(tgl_peristiwa) as tahun, id_peristiwa, count(*) as jumlah')
                ->from('log_keluarga')
                ->where('YEAR(tgl_peristiwa) >=', $tahun_mulai)
                ->where_in('id_peristiwa', [1, 2, 3, 4])
                ->group_by('YEAR(tgl_peristiwa), id_peristiwa')
                ->get()->result_array();

            $total_penduduk_awal_tahun = $total_penduduk_sekarang;
            $total_keluarga_awal_tahun = $total_keluarga_sekarang;

            foreach ($mutasi_penduduk as $row) {
                $jumlah = (int) $row['jumlah'];
                if (in_array($row['kode_peristiwa'], [1, 5])) $total_penduduk_awal_tahun -= $jumlah;
                else if (in_array($row['kode_peristiwa'], [2, 3, 4])) $total_penduduk_awal_tahun += $jumlah;
            }

            foreach ($mutasi_keluarga as $row) {
                $jumlah = (int) $row['jumlah'];
                if ($row['id_peristiwa'] == 1) $total_keluarga_awal_tahun -= $jumlah;
                else $total_keluarga_awal_tahun += $jumlah;
            }

            $categories = [];
            $data = [
                'kelahiran' => [],
                'kematian' => [],
                'pindah_datang' => [],
                'pindah_pergi' => [],
                'total_penduduk' => [],
                'total_keluarga' => [],
            ];

            $running_penduduk = $total_penduduk_awal_tahun;
            $running_keluarga = $total_keluarga_awal_tahun;

            for ($y = $tahun_mulai; $y <= $tahun_akhir; $y++) {
                $categories[] = (string) $y;

                $lahir = 0; $mati = 0; $dtg = 0; $prg = 0;
                $plus_penduduk = 0; $minus_penduduk = 0;
                foreach ($mutasi_penduduk as $row) {
                    if ($row['tahun'] == $y) {
                        $jumlah = (int) $row['jumlah'];
                        if ($row['kode_peristiwa'] == 1) { $lahir += $jumlah; $plus_penduduk += $jumlah; }
                        if ($row['kode_peristiwa'] == 2) { $mati += $jumlah; $minus_penduduk += $jumlah; }
                        if ($row['kode_peristiwa'] == 3) { $prg += $jumlah; $minus_penduduk += $jumlah; }
                        if ($row['kode_peristiwa'] == 4) { $minus_penduduk += $jumlah; }
                        if ($row['kode_peristiwa'] == 5) { $dtg += $jumlah; $plus_penduduk += $jumlah; }
                    }
                }
                $running_penduduk += ($plus_penduduk - $minus_penduduk);

                $plus_keluarga = 0; $minus_keluarga = 0;
                foreach ($mutasi_keluarga as $row) {
                    if ($row['tahun'] == $y) {
                        $jumlah = (int) $row['jumlah'];
                        if ($row['id_peristiwa'] == 1) { $plus_keluarga += $jumlah; }
                        else { $minus_keluarga += $jumlah; }
                    }
                }
                $running_keluarga += ($plus_keluarga - $minus_keluarga);

                $data['kelahiran'][] = $lahir;
                $data['kematian'][] = $mati;
                $data['pindah_datang'][] = $dtg;
                $data['pindah_pergi'][] = $prg;
                $data['total_penduduk'][] = $running_penduduk;
                $data['total_keluarga'][] = $running_keluarga;
            }

            $result = array_merge(['categories' => $categories], $data);
            return $this->output->set_content_type('application/json')->set_output(json_encode($result));
        }

        $tahun = (int) $tahun_filter;
        
        $mutasi_penduduk = $this->db
            ->select('YEAR(tgl_lapor) as tahun, MONTH(tgl_lapor) as bulan, kode_peristiwa, count(*) as jumlah')
            ->from('log_penduduk')
            ->where('YEAR(tgl_lapor) >=', $tahun)
            ->where_in('kode_peristiwa', [1, 2, 3, 4, 5])
            ->group_by('YEAR(tgl_lapor), MONTH(tgl_lapor), kode_peristiwa')
            ->get()->result_array();

        $mutasi_keluarga = $this->db
            ->select('YEAR(tgl_peristiwa) as tahun, MONTH(tgl_peristiwa) as bulan, id_peristiwa, count(*) as jumlah')
            ->from('log_keluarga')
            ->where('YEAR(tgl_peristiwa) >=', $tahun)
            ->where_in('id_peristiwa', [1, 2, 3, 4])
            ->group_by('YEAR(tgl_peristiwa), MONTH(tgl_peristiwa), id_peristiwa')
            ->get()->result_array();

        $total_penduduk_awal_tahun = $total_penduduk_sekarang;
        $total_keluarga_awal_tahun = $total_keluarga_sekarang;

        foreach ($mutasi_penduduk as $row) {
            $jumlah = (int) $row['jumlah'];
            if (in_array($row['kode_peristiwa'], [1, 5])) {
                $total_penduduk_awal_tahun -= $jumlah;
            } else if (in_array($row['kode_peristiwa'], [2, 3, 4])) {
                $total_penduduk_awal_tahun += $jumlah;
            }
        }

        foreach ($mutasi_keluarga as $row) {
            $jumlah = (int) $row['jumlah'];
            if ($row['id_peristiwa'] == 1) {
                $total_keluarga_awal_tahun -= $jumlah;
            } else {
                $total_keluarga_awal_tahun += $jumlah;
            }
        }

        $data = [
            'kelahiran' => array_fill(1, 12, 0),
            'kematian' => array_fill(1, 12, 0),
            'pindah_datang' => array_fill(1, 12, 0),
            'pindah_pergi' => array_fill(1, 12, 0),
            'total_penduduk' => array_fill(1, 12, 0),
            'total_keluarga' => array_fill(1, 12, 0),
        ];

        foreach ($mutasi_penduduk as $row) {
            if ($row['tahun'] == $tahun) {
                $bulan = (int) $row['bulan'];
                if (!$bulan) continue;
                $jumlah = (int) $row['jumlah'];
                if ($row['kode_peristiwa'] == 1) $data['kelahiran'][$bulan] += $jumlah;
                if ($row['kode_peristiwa'] == 2) $data['kematian'][$bulan] += $jumlah;
                if ($row['kode_peristiwa'] == 3) $data['pindah_pergi'][$bulan] += $jumlah;
                if ($row['kode_peristiwa'] == 5) $data['pindah_datang'][$bulan] += $jumlah;
            }
        }

        $running_penduduk = $total_penduduk_awal_tahun;
        $running_keluarga = $total_keluarga_awal_tahun;

        for ($i = 1; $i <= 12; $i++) {
            if ($tahun > date('Y') || ($tahun == date('Y') && $i > date('n'))) {
                $data['total_penduduk'][$i] = null;
                $data['total_keluarga'][$i] = null;
                $data['kelahiran'][$i] = null;
                $data['kematian'][$i] = null;
                $data['pindah_datang'][$i] = null;
                $data['pindah_pergi'][$i] = null;
                continue;
            }

            $plus_penduduk = 0;
            $minus_penduduk = 0;
            foreach ($mutasi_penduduk as $row) {
                if ($row['tahun'] == $tahun && $row['bulan'] == $i) {
                    if (in_array($row['kode_peristiwa'], [1, 5])) $plus_penduduk += $row['jumlah'];
                    if (in_array($row['kode_peristiwa'], [2, 3, 4])) $minus_penduduk += $row['jumlah'];
                }
            }
            $running_penduduk += ($plus_penduduk - $minus_penduduk);
            $data['total_penduduk'][$i] = $running_penduduk;

            $plus_keluarga = 0;
            $minus_keluarga = 0;
            foreach ($mutasi_keluarga as $row) {
                if ($row['tahun'] == $tahun && $row['bulan'] == $i) {
                    if ($row['id_peristiwa'] == 1) $plus_keluarga += $row['jumlah'];
                    else $minus_keluarga += $row['jumlah'];
                }
            }
            $running_keluarga += ($plus_keluarga - $minus_keluarga);
            $data['total_keluarga'][$i] = $running_keluarga;
        }

        $result = [
            'categories' => ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
            'kelahiran' => array_values($data['kelahiran']),
            'kematian' => array_values($data['kematian']),
            'pindah_datang' => array_values($data['pindah_datang']),
            'pindah_pergi' => array_values($data['pindah_pergi']),
            'total_penduduk' => array_values($data['total_penduduk']),
            'total_keluarga' => array_values($data['total_keluarga']),
        ];

        return $this->output->set_content_type('application/json')->set_output(json_encode($result));
    }

    public function filter_log()
    {
        $tahun = $this->input->get('tahun');
        $bulan = $this->input->get('bulan');
        $peristiwa = $this->input->get('peristiwa');

        if ($tahun) $this->session->filter_tahun = $tahun;
        if ($bulan) $this->session->filter_bulan = $bulan;
        if ($peristiwa) $this->session->kode_peristiwa = $peristiwa;

        redirect('penduduk_log');
    }
}
