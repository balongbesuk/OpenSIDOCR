<?php

use App\Enums\Statistik\StatistikEnum;

defined('BASEPATH') || exit('No direct script access allowed');

class Statistik extends Web_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model(['laporan_penduduk_model', 'wilayah_model']);
    }

    public function index($slug = null, $tipe = 0)
    {
        // Jika diakses tanpa slug (/data-statistik), tampilkan Portal Hub / Indeks Statistik Desa
        if ($slug === null) {
            return $this->portal_index();
        }

        $key = StatistikEnum::keyFromSlug($slug);

        if ($key === null || ! $this->web_menu_model->menu_aktif('statistik/' . $key)) {
            show_404();
        }

        // Tangkap filter Dusun, RW, RT dari query GET
        $dusun = $this->input->get('dusun', true);
        $rw    = $this->input->get('rw', true);
        $rt    = $this->input->get('rt', true);

        // Normalisasi input filter
        $dusun = ($dusun !== null && $dusun !== '' && $dusun !== '0') ? trim($dusun) : null;
        $rw    = ($rw !== null && $rw !== '' && $rw !== '0') ? trim($rw) : null;
        $rt    = ($rt !== null && $rt !== '' && $rt !== '0') ? trim($rt) : null;

        if ($dusun) {
            $this->session->dusun = $dusun;
            if ($rw) {
                $this->session->rw = $rw;
                if ($rt) {
                    $this->session->rt = $rt;
                } else {
                    $this->session->unset_userdata('rt');
                }
            } else {
                $this->session->unset_userdata(['rw', 'rt']);
            }
        } else {
            $this->session->unset_userdata(['dusun', 'rw', 'rt']);
        }

        $data = $this->includes;

        $data['heading']          = StatistikEnum::labelFromSlug($slug);
        $data['title']            = 'Statistik ' . $data['heading'];
        $data['stat_nama']        = $data['heading'];
        $data['stat']             = $this->laporan_penduduk_model->list_data($key);
        $data['tipe']             = (int) $tipe;
        $data['st']               = $key;
        $data['slug_aktif']       = $slug;
        $data['daftar_statistik'] = StatistikEnum::allStatistik();

        // Data filter wilayah untuk view
        $data['filter_dusun'] = $dusun;
        $data['filter_rw']    = $rw;
        $data['filter_rt']    = $rt;
        $data['daftar_dusun'] = $this->wilayah_model->list_dusun();
        $data['daftar_rw']    = $dusun ? $this->wilayah_model->list_rw($dusun) : [];
        $data['daftar_rt']    = ($dusun && $rw) ? $this->wilayah_model->list_rt($dusun, $rw) : [];

        $this->_get_common_data($data);

        $this->set_template('layouts/stat.tpl.php');
        $this->load->view($this->template, $data);
    }

    public function ajax_rw()
    {
        $dusun = $this->input->get_post('dusun', true);
        $dusun = ($dusun !== null && $dusun !== '' && $dusun !== '0') ? trim($dusun) : null;
        $data  = $dusun ? $this->wilayah_model->list_rw($dusun) : [];

        return $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($data));
    }

    public function ajax_rt()
    {
        $dusun = $this->input->get_post('dusun', true);
        $rw    = $this->input->get_post('rw', true);
        $dusun = ($dusun !== null && $dusun !== '' && $dusun !== '0') ? trim($dusun) : null;
        $rw    = ($rw !== null && $rw !== '' && $rw !== '0') ? trim($rw) : null;
        $data  = ($dusun && $rw) ? $this->wilayah_model->list_rt($dusun, $rw) : [];

        return $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($data));
    }

    protected function portal_index()
    {
        // Ambil struktur seluruh statistik desa
        $daftar = function_exists('daftar_statistik') ? daftar_statistik() : [];
        if (empty($daftar) && class_exists('App\Enums\Statistik\StatistikEnum')) {
            $daftar['penduduk'] = \App\Enums\Statistik\StatistikPendudukEnum::$data;
            $daftar['keluarga'] = \App\Enums\Statistik\StatistikKeluargaEnum::$data;
        }

        // Definisi meta kategori untuk Portal Hub
        $kategori_meta = [
            'penduduk' => [
                'target'      => 'statistikPenduduk',
                'judul'       => 'Statistik Penduduk',
                'deskripsi'   => 'Visualisasi demografi, profil usia, pendidikan, pekerjaan, dan kondisi sosial warga.',
                'badge'       => 'Kependudukan',
                'icon'        => 'fa-solid fa-users',
                'gradient'    => 'from-blue-600 to-indigo-600',
                'badge_color' => 'bg-blue-50 text-blue-700 dark:bg-blue-950/60 dark:text-blue-300 border-blue-200 dark:border-blue-900/50',
                'items'       => $daftar['penduduk'] ?? [],
            ],
            'keluarga' => [
                'target'      => 'statistikKeluarga',
                'judul'       => 'Statistik Keluarga',
                'deskripsi'   => 'Informasi susunan kepala keluarga, hubungan dalam KK, dan klasifikasi rumah tangga.',
                'badge'       => 'Kartu Keluarga',
                'icon'        => 'fa-solid fa-people-roof',
                'gradient'    => 'from-emerald-600 to-teal-600',
                'badge_color' => 'bg-emerald-50 text-emerald-700 dark:bg-emerald-950/60 dark:text-emerald-300 border-emerald-200 dark:border-emerald-900/50',
                'items'       => $daftar['keluarga'] ?? [],
            ],
            'bantuan' => [
                'target'      => 'statistikBantuan',
                'judul'       => 'Program Bantuan Sosial',
                'deskripsi'   => 'Transparansi data penerima jaminan sosial perorangan dan program perlindungan keluarga.',
                'badge'       => 'Bantuan Sosial',
                'icon'        => 'fa-solid fa-hand-holding-heart',
                'gradient'    => 'from-amber-500 to-rose-500',
                'badge_color' => 'bg-amber-50 text-amber-700 dark:bg-amber-950/60 dark:text-amber-300 border-amber-200 dark:border-amber-900/50',
                'items'       => $daftar['bantuan'] ?? [],
            ],
            'lainnya' => [
                'target'      => 'statistikLainnya',
                'judul'       => 'Wilayah, Pemilu & Tren',
                'deskripsi'   => 'Daftar pemilih tetap (DPT), kewilayahan Dusun/RW/RT, dan laju perkembangan penduduk.',
                'badge'       => 'Wilayah & DPT',
                'icon'        => 'fa-solid fa-map-location-dot',
                'gradient'    => 'from-purple-600 to-pink-600',
                'badge_color' => 'bg-purple-50 text-purple-700 dark:bg-purple-950/60 dark:text-purple-300 border-purple-200 dark:border-purple-900/50',
                'items'       => $daftar['lainnya'] ?? [],
            ],
        ];

        // Saring HANYA item statistik yang AKTIF di menu OpenSID sesuai peraturan hak akses pengguna
        $kategori_aktif = [];
        $total_indikator_aktif = 0;

        foreach ($kategori_meta as $key_cat => $meta) {
            $filtered_items = [];
            foreach ($meta['items'] as $item) {
                if ($this->is_stat_aktif($item, $meta['target'])) {
                    $item['icon_class'] = $this->get_stat_icon($item['slug'] ?? $item['key'] ?? '');
                    $item['deskripsi']  = $this->get_stat_desc($item['slug'] ?? $item['key'] ?? '');
                    $filtered_items[]   = $item;
                    $total_indikator_aktif++;
                }
            }

            if (! empty($filtered_items)) {
                $meta['items'] = $filtered_items;
                $meta['total'] = count($filtered_items);
                $kategori_aktif[$key_cat] = $meta;
            }
        }

        // [PERATURAN OPENSID]: Jika seluruh statistik dinonaktifkan oleh pengguna (tidak ada satupun aktif), tampilkan 404
        if ($total_indikator_aktif === 0) {
            show_404();
        }

        // Data agregat demografi (Quick Stats) untuk Hero Card
        $config_id      = identitas('id');
        $total_penduduk = (int) $this->db->where('status_dasar', 1)->where('config_id', $config_id)->count_all_results('tweb_penduduk');
        $total_keluarga = (int) $this->db->where('status_dasar', 1)->where('kk_level', 1)->where('config_id', $config_id)->count_all_results('tweb_penduduk');
        $total_dusun    = (int) count($this->wilayah_model->list_dusun());

        $dpt_aktif = (bool) ($this->web_menu_model->menu_aktif('daftar-pemilih-tetap') || $this->web_menu_model->menu_aktif('dpt') || $this->web_menu_model->menu_aktif('first/dpt'));
        $total_dpt = 0;
        if ($dpt_aktif) {
            $total_dpt = (int) ($this->db->query("SELECT count(*) as jml FROM tweb_penduduk WHERE status_dasar = 1 AND config_id = ? AND (TIMESTAMPDIFF(YEAR, tanggallahir, CURDATE()) >= 17 OR status_kawin > 1)", [$config_id])->row()->jml ?? 0);
        }

        $data = $this->includes;
        $data['title']                 = 'Pusat Data Statistik Desa';
        $data['heading']               = 'Pusat Data Statistik';
        $data['kategori_statistik']   = $kategori_aktif;
        $data['total_indikator_aktif'] = $total_indikator_aktif;
        $data['quick_stats']           = [
            'penduduk'  => $total_penduduk,
            'keluarga'  => $total_keluarga,
            'dusun'     => $total_dusun,
            'dpt'       => $total_dpt,
            'dpt_aktif' => $dpt_aktif,
        ];

        $this->_get_common_data($data);

        // Jika tema desa memiliki template khusus stat_index, gunakan itu
        $theme_path = APPPATH . "../{$this->theme_folder}/{$this->theme}/layouts/stat_index.tpl.php";
        if (file_exists($theme_path)) {
            $this->set_template('layouts/stat_index.tpl.php');
            $this->load->view($this->template, $data);
            return;
        }

        // Fallback: Jika tema belum memiliki stat_index, arahkan ke indikator pertama yang aktif
        foreach ($kategori_aktif as $cat) {
            if (! empty($cat['items'][0]['url'])) {
                redirect($cat['items'][0]['url']);
            }
        }

        show_404();
    }

    protected function is_stat_aktif($item, $target = null)
    {
        if (! isset($this->web_menu_model)) {
            return false;
        }

        $key  = $item['key'] ?? null;
        $slug = $item['slug'] ?? null;
        $url  = $item['url'] ?? '';

        // Kasus khusus untuk kategori Lainnya (Wilayah, DPT, Perkembangan Penduduk)
        if ($target === 'statistikLainnya' || in_array($key, ['dpt', 'data-wilayah', 'perkembangan-penduduk'])) {
            if ($key === 'dpt' || $slug === 'daftar-pemilih-tetap') {
                return (bool) ($this->web_menu_model->menu_aktif('daftar-pemilih-tetap') || $this->web_menu_model->menu_aktif('dpt') || $this->web_menu_model->menu_aktif('first/dpt'));
            }
            if ($key === 'data-wilayah' || $slug === 'data-wilayah') {
                return (bool) $this->web_menu_model->menu_aktif('data-wilayah');
            }
            if ($key === 'perkembangan-penduduk' || $slug === 'perkembangan-penduduk') {
                return (bool) ($this->web_menu_model->menu_aktif('perkembangan-penduduk') || $this->web_menu_model->menu_aktif('first/perkembangan-penduduk'));
            }
        }

        // Pengecekan standar menu OpenSID: statistik/{key}, data-statistik/{slug}, atau URL
        return (bool) (
            $this->web_menu_model->menu_aktif('statistik/' . $key) ||
            $this->web_menu_model->menu_aktif('first/statistik/' . $key) ||
            $this->web_menu_model->menu_aktif('data-statistik/' . $slug) ||
            $this->web_menu_model->menu_aktif($url)
        );
    }

    protected function get_stat_icon($slug)
    {
        $icons = [
            'rentang-umur'               => 'fa-solid fa-chart-simple',
            'kategori-umur'              => 'fa-solid fa-users-line',
            'pendidikan-dalam-kk'        => 'fa-solid fa-graduation-cap',
            'pendidikan-sedang-ditempuh' => 'fa-solid fa-school',
            'pekerjaan'                  => 'fa-solid fa-briefcase',
            'status-perkawinan'          => 'fa-solid fa-ring',
            'agama'                      => 'fa-solid fa-hands-praying',
            'jenis-kelamin'              => 'fa-solid fa-venus-mars',
            'hubungan-dalam-kk'          => 'fa-solid fa-people-roof',
            'warga-negara'               => 'fa-solid fa-passport',
            'status-penduduk'            => 'fa-solid fa-id-card-clip',
            'golongan-darah'             => 'fa-solid fa-droplet',
            'penyandang-cacat'           => 'fa-solid fa-wheelchair',
            'penyakit-menahun'           => 'fa-solid fa-notes-medical',
            'akseptor-kb'                => 'fa-solid fa-hand-holding-medical',
            'akta-kelahiran'             => 'fa-solid fa-file-lines',
            'e-ktp'                      => 'fa-solid fa-address-card',
            'asuransi-kesehatan'         => 'fa-solid fa-heart-pulse',
            'bantuan-penduduk'           => 'fa-solid fa-hand-holding-dollar',
            'bantuan-keluarga'           => 'fa-solid fa-house-chimney-crack',
            'daftar-pemilih-tetap'       => 'fa-solid fa-check-to-slot',
            'data-wilayah'               => 'fa-solid fa-map-location-dot',
            'perkembangan-penduduk'      => 'fa-solid fa-chart-line',
        ];

        return $icons[$slug] ?? 'fa-solid fa-chart-pie';
    }

    protected function get_stat_desc($slug)
    {
        $descs = [
            'rentang-umur'               => 'Distribusi penduduk berdasarkan kelompok rentang umur.',
            'kategori-umur'              => 'Klasifikasi kelompok usia balita, anak, remaja, dewasa & lansia.',
            'pendidikan-dalam-kk'        => 'Tingkat capaian pendidikan formal terakhir dalam Kartu Keluarga.',
            'pendidikan-sedang-ditempuh' => 'Partisipasi jenjang sekolah yang sedang aktif ditempuh warga.',
            'pekerjaan'                  => 'Sebaran profesi dan mata pencaharian pokok penduduk desa.',
            'status-perkawinan'          => 'Persentase status pernikahan sah kependudukan.',
            'agama'                      => 'Keberagaman agama dan kepercayaan masyarakat desa.',
            'jenis-kelamin'              => 'Rasio perbandingan jumlah laki-laki dan perempuan.',
            'hubungan-dalam-kk'          => 'Kedudukan status hubungan anggota keluarga dalam KK.',
            'warga-negara'               => 'Komposisi status kewarganegaraan penduduk (WNI / WNA).',
            'status-penduduk'            => 'Status keaktifan kependudukan (Penduduk Tetap / Pasif).',
            'golongan-darah'             => 'Peta data golongan darah warga untuk kesiapsiagaan donor.',
            'penyandang-cacat'           => 'Pendataan warga difabel / disabilitas fisik dan mental.',
            'penyakit-menahun'           => 'Data penderita penyakit menahun dan kronis.',
            'akseptor-kb'                => 'Keikutsertaan warga dalam program Keluarga Berencana.',
            'akta-kelahiran'             => 'Status kepemilikan dokumen akta kelahiran resmi.',
            'e-ktp'                      => 'Capaian perekaman KTP Elektronik bagi warga wajib KTP.',
            'asuransi-kesehatan'         => 'Kepesertaan jaminan BPJS Kesehatan dan asuransi lainnya.',
            'bantuan-penduduk'           => 'Daftar warga penerima program jaminan sosial perorangan.',
            'bantuan-keluarga'           => 'Daftar keluarga penerima manfaat program bantuan sosial.',
            'daftar-pemilih-tetap'       => 'Daftar warga yang memiliki hak pilih pada pemilihan umum.',
            'data-wilayah'               => 'Rincian demografi per wilayah Dusun, RW, dan RT.',
            'perkembangan-penduduk'      => 'Tren dinamika kelahiran, kematian, dan mutasi penduduk.',
        ];

        return $descs[$slug] ?? 'Analisis visual data statistik desa secara transparan dan akurat.';
    }
}

