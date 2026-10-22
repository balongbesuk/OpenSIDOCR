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

use App\Models\FormatSurat;
use App\Models\LogSurat;
use App\Models\Penduduk;
use App\Models\PermohonanSurat;
use App\Models\SyaratSurat;
use Mike42\Escpos\PrintConnectors\NetworkPrintConnector;
use Mike42\Escpos\Printer;

class Surat extends Mandiri_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model(['keluar_model', 'permohonan_surat_model', 'surat_model', 'surat_master_model', 'lapor_model', 'penduduk_model']);
    }

    // Kat 1 = Permohonan
    // Kat 2 = Arsip
    public function index($kat = 1)
    {
        $arsip      = $this->keluar_model->list_data_perorangan($this->is_login->id_pend);
        $permohonan = $this->permohonan_surat_model->list_permohonan_perorangan($this->is_login->id_pend, 1);

        $data = [
            'kat'     => $kat,
            'judul'   => ($kat == 1) ? 'Permohonan Surat' : 'Arsip Surat',
            'main'    => ($kat == 1) ? $permohonan : $arsip,
            'printer' => $this->print_connector(),
        ];

        $this->render('surat', $data);
    }

    public function buat($id = '')
    {
        $id_pend = (int) $this->is_login->id_pend;

        // Cek hanya status = 0 (belum lengkap) yg boleh di ubah
        if ($id) {
            $permohonan = $this->permohonan_surat_model->get_permohonan([
                'id'         => (int) $id,
                'id_pemohon' => $id_pend,
                'status'     => 0,
            ]);

            if (! $permohonan) {
                redirect('layanan-mandiri/surat/buat');
            }

            $form_action = site_url("layanan-mandiri/surat/form/{$permohonan['id']}");
        } else {
            $form_action = site_url('layanan-mandiri/surat/form');
        }

        $data = [
            'menu_surat_mandiri'   => $this->surat_model->list_surat_mandiri(),
            'menu_dokumen_mandiri' => $this->lapor_model->get_surat_ref_all(),
            'list_dokumen'         => $this->penduduk_model->list_dokumen($id_pend),
            'kk'                   => ($this->is_login->kk_level === '1') ? $this->keluarga_model->list_anggota($this->is_login->id_kk) : '', // Ambil data anggota KK, jika Kepala Keluarga
            'permohonan'           => $permohonan,
            'form_action'          => $form_action,
        ];

        $this->render('buat_surat', $data);
    }

    public function cek_syarat()
    {
        $id_permohonan = (int) $this->input->post('id_permohonan');
        $id_surat      = (int) $this->input->post('id_surat');

        if (! $id_surat) {
            return json([
                'recordsTotal'    => 0,
                'recordsFiltered' => 0,
                'data'            => [],
            ]);
        }

        $suratMaster = FormatSurat::select(['syarat_surat'])->find($id_surat);
        if (! $suratMaster || empty($suratMaster->syarat_surat)) {
            return json([
                'recordsTotal'    => 0,
                'recordsFiltered' => 0,
                'data'            => [],
            ]);
        }

        $syarat_ids        = json_decode($suratMaster->syarat_surat, true) ?: [];
        $syarat_permohonan = $id_permohonan ? PermohonanSurat::select(['syarat'])->find($id_permohonan) : null;
        $syaratSurat       = SyaratSurat::get();
        $dokumen           = $this->penduduk_model->list_dokumen($this->is_login->id_pend);

        $data = [];
        $no   = 1;

        if ($syaratSurat) {
            foreach ($syaratSurat as $baris) {
                if (in_array($baris->ref_syarat_id, $syarat_ids)) {
                    $row   = [];
                    $row[] = $no++;
                    $row[] = htmlspecialchars($baris->ref_syarat_nama);
                    // Gunakan view sebagai string untuk mempermudah pembuatan pilihan
                    $pilihan_dokumen = $this->load->view(MANDIRI . '/pilihan_syarat', [
                        'dokumen'           => $dokumen,
                        'syarat_permohonan' => $syarat_permohonan ? json_decode($syarat_permohonan->syarat, true) : null,
                        'syarat_id'         => $baris->ref_syarat_id,
                        'cek_anjungan'      => $this->cek_anjungan,
                    ], true);
                    $row[]           = $pilihan_dokumen;
                    $data[]          = $row;
                }
            }
        }

        return json([
            'recordsTotal'    => count($data),
            'recordsFiltered' => count($data),
            'data'            => $data,
        ]);
    }

    // Proses permohonan surat
    public function form($id = '')
    {
        $id_pend = (int) $this->is_login->id_pend;

        // Ambil data dari buat surat
        $post = $this->input->post();

        if ($post) {
            // Validasi keamanan input form
            $id_surat    = (int) ($post['id_surat'] ?? 0);
            $keterangan  = trim($this->security->xss_clean($post['keterangan'] ?? ''));
            $no_hp_aktif = preg_replace('/[^0-9]/', '', (string) ($post['no_hp_aktif'] ?? ''));
            $no_hp_aktif = preg_replace('/^(62|0)/', '', $no_hp_aktif);

            // 1. Cek apakah jenis surat valid dan aktif untuk layanan mandiri
            $surat_cek = $this->surat_model->cek_surat_mandiri($id_surat);
            if (! $surat_cek) {
                $this->session->set_flashdata('notif', [
                    'status' => 1,
                    'pesan'  => 'Jenis surat tidak valid atau belum diaktifkan untuk Layanan Mandiri.',
                ]);
                redirect('layanan-mandiri/surat/buat' . ($id ? "/{$id}" : ''));
                return;
            }

            // 2. Validasi keterangan surat
            if (empty($keterangan) || mb_strlen($keterangan) < 5) {
                $this->session->set_flashdata('notif', [
                    'status' => 1,
                    'pesan'  => 'Keterangan atau keperluan permohonan surat wajib diisi minimal 5 karakter.',
                ]);
                redirect('layanan-mandiri/surat/buat' . ($id ? "/{$id}" : ''));
                return;
            }

            // Batasi panjang keterangan agar aman dari payload panjang / buffer
            if (mb_strlen($keterangan) > 500) {
                $keterangan = mb_substr($keterangan, 0, 500);
            }

            // 3. Validasi nomor telepon
            if (empty($no_hp_aktif) || strlen($no_hp_aktif) < 9 || strlen($no_hp_aktif) > 15) {
                $this->session->set_flashdata('notif', [
                    'status' => 1,
                    'pesan'  => 'Nomor WhatsApp / HP aktif tidak valid (minimal 9 digit angka).',
                ]);
                redirect('layanan-mandiri/surat/buat' . ($id ? "/{$id}" : ''));
                return;
            }

            // 4. Sanitasi syarat dokumen: hanya izinkan dokumen yang sah milik pemohon
            $syarat_sanitized = [];
            if (! empty($post['syarat']) && is_array($post['syarat'])) {
                $dokumen_user      = $this->penduduk_model->list_dokumen($id_pend);
                $valid_dokumen_ids = [];
                if (! empty($dokumen_user)) {
                    foreach ($dokumen_user as $doc) {
                        $valid_dokumen_ids[] = (int) $doc['id'];
                    }
                }

                foreach ($post['syarat'] as $key => $val) {
                    $val_clean = (int) $val;
                    if (in_array($val_clean, $valid_dokumen_ids, true)) {
                        $syarat_sanitized[(int) $key] = $val_clean;
                    }
                }
            }

            $post['id_surat']    = $id_surat;
            $post['keterangan']  = $keterangan;
            $post['no_hp_aktif'] = '62' . $no_hp_aktif;
            $post['syarat']      = $syarat_sanitized;

            $this->session->data_permohonan = $post;
        } else {
            $post = $this->session->data_permohonan;
        }

        // Cek hanya status = 0 (belum lengkap) yg boleh di ubah
        if ($id) {
            $permohonan = $this->permohonan_surat_model->get_permohonan([
                'id'         => (int) $id,
                'id_pemohon' => $id_pend,
                'status'     => 0,
            ]);

            if (! $permohonan || ! $post) {
                redirect('layanan-mandiri/surat/buat');
                return;
            }

            $data['permohonan'] = $permohonan;
            $data['isian_form'] = json_encode($this->permohonan_surat_model->ambil_isi_form($permohonan['isian_form']));
            $data['id_surat']   = (int) $permohonan['id_surat'];
        } else {
            if (! $post) {
                redirect('layanan-mandiri/surat/buat');
                return;
            }
            $data['permohonan'] = null;
            $data['isian_form'] = null;
            $data['id_surat']   = (int) $post['id_surat'];
        }

        $surat = $this->surat_model->cek_surat_mandiri($data['id_surat']);
        if (! $surat) {
            redirect('layanan-mandiri/surat/buat');
            return;
        }
        $url   = $surat['url_surat'];

        $data['url']      = $url;
        $data['individu'] = $this->surat_model->get_penduduk($id_pend);
        $data['anggota']  = $this->keluarga_model->list_anggota($data['individu']['id_kk']);
        $this->get_data_untuk_form($url, $data);
        $data['surat_url']    = rtrim($_SERVER['REQUEST_URI'], '/clear');
        $data['form_action']  = site_url("surat/cetak/{$url}");
        $data['cek_anjungan'] = $this->cek_anjungan;
        $data['mandiri']      = 1; // Untuk tombol cetak/kirim surat

        if (in_array($data['surat']['jenis'], FormatSurat::TINYMCE)) {
            return $this->render('permohonan_surat_tinymce', $data);
        }

        return $this->render('permohonan_surat', $data);
    }

    public function kirim($id = '')
    {
        $this->load->library('Telegram/telegram');
        $id_pend = (int) $this->is_login->id_pend;

        $data_permohonan = $this->session->data_permohonan;
        if (! $data_permohonan) {
            $this->session->set_flashdata('notif', [
                'status' => 1,
                'pesan'  => 'Sesi permohonan surat telah berakhir. Silakan ulangi pengisian formulir.',
            ]);
            redirect('layanan-mandiri/surat/buat');
            return;
        }

        $post       = $this->input->post();
        $post_clean = $this->security->xss_clean($post);

        $id_surat = (int) ($post_clean['id_surat'] ?? $data_permohonan['id_surat']);

        $no_hp_kirim = preg_replace('/[^0-9]/', '', (string) ($data_permohonan['no_hp_aktif'] ?? ''));
        $no_hp_kirim = preg_replace('/^(62|0)/', '', $no_hp_kirim);
        $no_hp_final = ! empty($no_hp_kirim) ? ('62' . $no_hp_kirim) : '';

        $data = [
            'id_pemohon'  => $id_pend, // Anti-IDOR: selalu gunakan id_pend dari sesi user yang login
            'id_surat'    => $id_surat,
            'isian_form'  => json_encode($post_clean),
            'status'      => 1, // 1 = Selalu diajukan bagi pengguna layanan mandiri
            'keterangan'  => $this->security->xss_clean($data_permohonan['keterangan'] ?? ''),
            'no_hp_aktif' => $no_hp_final,
            'syarat'      => json_encode($data_permohonan['syarat'] ?? []),
        ];

        if ($id) {
            // Anti-IDOR: Pastikan permohonan ada, milik penduduk login, dan status == 0
            $cek = $this->permohonan_surat_model->get_permohonan([
                'id'         => (int) $id,
                'id_pemohon' => $id_pend,
                'status'     => 0,
            ]);

            if (! $cek) {
                $this->session->set_flashdata('notif', [
                    'status' => 1,
                    'pesan'  => 'Permohonan surat tidak ditemukan atau Anda tidak memiliki akses.',
                ]);
                redirect('layanan-mandiri/permohonan-surat');
                return;
            }

            $data['updated_at'] = date('Y-m-d H:i:s');
            $this->permohonan_surat_model->update((int) $id, $data);
        } else {
            $new_id = $this->permohonan_surat_model->insert($data);
            if ($new_id) {
                $this->permohonan_surat_model->notifikasi_status_permohonan($new_id, 1);
            }

            if (! empty($this->setting->telegram_token) && cek_koneksi_internet()) {
                try {
                    $suratObj   = FormatSurat::find($id_surat);
                    $judulSurat = $suratObj ? $suratObj->nama : 'Surat Permohonan';

                    // Data pesan telegram yang akan digantikan
                    $pesanTelegram = [
                        '[nama_penduduk]' => $this->is_login->nama,
                        '[judul_surat]'   => $judulSurat,
                        '[tanggal]'       => tgl_indo2(date('Y-m-d H:i:s')),
                        '[melalui]'       => 'Layanan Mandiri',
                    ];

                    $kirimPesan = setting('notifikasi_pengajuan_surat');
                    $kirimPesan = str_replace(array_keys($pesanTelegram), array_values($pesanTelegram), $kirimPesan);
                    $this->telegram->sendMessage([
                        'text'       => $kirimPesan,
                        'parse_mode' => 'Markdown',
                        'chat_id'    => $this->setting->telegram_user_id,
                    ]);
                } catch (Exception $e) {
                    log_message('error', $e->getMessage());
                }
            }
        }

        $this->session->unset_userdata('data_permohonan');

        redirect('layanan-mandiri/permohonan-surat');
    }

    private function get_data_untuk_form($url, &$data)
    {
        // RTF
        if (in_array($data['surat']['jenis'], FormatSurat::RTF)) {
            $data['config']    = $data['lokasi'] = $this->header;
            $data['perempuan'] = $this->surat_model->list_penduduk_perempuan();
        }

        // Panggil 1 penduduk berdasarkan datanya sendiri
        $data['penduduk'] = [$data['periksa']['penduduk']];

        $data['surat_terakhir']     = $this->surat_model->get_last_nosurat_log($url);
        $data['surat']              = FormatSurat::where('url_surat', $url)->first();
        $data['input']              = $this->input->post();
        $data['input']['nomor']     = $data['surat_terakhir']['no_surat_berikutnya'];
        $data['format_nomor_surat'] = $this->penomoran_surat_model->format_penomoran_surat($data);

        $data_form = $this->surat_model->get_data_form($url);
        if (is_file($data_form)) {
            include $data_form;
        }
    }

    public function proses($id = '')
    {
        $this->permohonan_surat_model->proses($id, 5, $this->is_login->id_pend);

        redirect('layanan-mandiri/permohonan-surat');
    }

    public function cetak_no_antrian(string $no_antrian)
    {
        $printer = null;
        try {
            $connector = new NetworkPrintConnector($this->cek_anjungan['printer_ip'], $this->cek_anjungan['printer_port'], 5);
            $printer   = new Printer($connector);

            $printer->initialize();
            $printer->setJustification(Printer::JUSTIFY_CENTER);
            $printer->setTextSize(2, 2);
            $printer->setEmphasis(true);
            $printer->text('ANJUNGAN MANDIRI');
            $printer->setEmphasis(false);
            $printer->feed(1);

            $printer->setTextSize(1, 1);
            $printer->text("SELAMAT DATANG \n");
            $printer->text('NOMOR ANTREAN ANDA');
            $printer->feed();

            $printer->setTextSize(4, 4);
            $printer->text(get_antrian($no_antrian));
            $printer->feed();

            $printer->setTextSize(1, 1);
            $printer->text("TERIMA KASIH \n");
            $printer->text('ANDA TELAH MENUNGGU');
            $printer->feed();

            $printer->cut();
        } catch (Exception $e) {
            log_message('error', $e->getMessage());

            redirect($_SERVER['HTTP_REFERER']);
        } finally {
            if ($printer) {
                $printer->close();
            }
        }

        redirect($_SERVER['HTTP_REFERER']);
    }

    protected function print_connector()
    {
        if (null === ($anjungan = $this->cek_anjungan)) {
            return;
        }

        try {
            $connector = new NetworkPrintConnector($anjungan['printer_ip'], $anjungan['printer_port'], 5);
        } catch (Exception $e) {
            log_message('error', $e->getMessage());

            return false;
        }

        return $connector;
    }

    public function cetak($id)
    {
        $surat = LogSurat::find($id);

        // Cegah IDOR: Pastikan berkas surat ada dan milik penduduk yang sedang login
        if (! $surat || (int) $surat->id_pend !== (int) $this->is_login->id_pend) {
            show_404();
        }

        // Cek ada file
        if (! empty($surat->nama_surat) && file_exists(FCPATH . LOKASI_ARSIP . $surat->nama_surat)) {
            return ambilBerkas($surat->nama_surat, $this->controller, null, LOKASI_ARSIP, true);
        }
        echo 'Berkas tidak ditemukan';
    }
}
