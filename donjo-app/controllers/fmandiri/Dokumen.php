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

class Dokumen extends Mandiri_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model(['penduduk_model', 'web_dokumen_model', 'keluarga_model', 'referensi_model']);
        $this->controller = 'layanan-mandiri/dokumen';
    }

    public function index()
    {
        $this->render('dokumen/index', [
            'dokumen'            => $this->penduduk_model->list_dokumen($this->is_login->id_pend),
            'jenis_syarat_surat' => $this->referensi_model->list_by_id('ref_syarat_surat', 'ref_syarat_id'),
        ]);
    }

    public function form($id = '')
    {
        if ($this->is_login->kk_level == '1') { //Jika Kepala Keluarga
            $data['kk'] = $this->keluarga_model->list_anggota($this->is_login->id_kk);
        }

        if ($id) {
            $data['dokumen']     = $this->web_dokumen_model->get_dokumen($id, $this->is_login->id_pend) ?? show_404();
            $data['anggota']     = array_column($this->web_dokumen_model->get_dokumen_di_anggota_lain($id), 'id_pend');
            $data['aksi']        = 'Ubah';
            $data['form_action'] = site_url("{$this->controller}/ubah/{$id}");
        } else {
            $data['dokumen']     = null;
            $data['anggota']     = null;
            $data['aksi']        = 'Tambah';
            $data['form_action'] = site_url("{$this->controller}/tambah");
        }

        $data['jenis_syarat_surat'] = $this->referensi_model->list_by_id('ref_syarat_surat', 'ref_syarat_id');

        $this->render('dokumen/form', $data);
    }

    public function tambah()
    {
        // Paksa id_pend selalu dari session login (Cegah IDOR / Manipulasi ID)
        $_POST['id_pend'] = $this->is_login->id_pend;

        // Validasi Form & Keamanan Berkas Server-Side
        $this->validasi_form(false);

        if ($this->web_dokumen_model->insert(true)) {
            redirect_with('success', 'Berhasil menambahkan dokumen baru.', $this->controller);
        } else {
            redirect_with('error', 'Gagal menambahkan dokumen: ' . ($this->session->error_msg ?? 'Terjadi kesalahan sistem.'), $this->controller . '/form');
        }
    }

    public function ubah($id = '')
    {
        // Cegah IDOR: Pastikan dokumen ada dan milik penduduk yang login
        $this->web_dokumen_model->get_dokumen($id, $this->is_login->id_pend) ?? show_404();

        // Paksa id_pend selalu dari session login
        $_POST['id_pend'] = $this->is_login->id_pend;

        // Validasi Form & Keamanan Berkas Server-Side
        $this->validasi_form(true, $id);

        if ($this->web_dokumen_model->update($id, $this->is_login->id_pend, true)) {
            redirect_with('success', 'Berhasil memperbarui dokumen.', $this->controller);
        } else {
            redirect_with('error', 'Gagal memperbarui dokumen: ' . ($this->session->error_msg ?? 'Terjadi kesalahan sistem.'), $this->controller . "/form/{$id}");
        }
    }

    public function hapus($id = '')
    {
        // Cegah IDOR: Pastikan dokumen milik penduduk yang sedang login
        $this->web_dokumen_model->get_dokumen($id, $this->is_login->id_pend) ?? show_404();

        if ($this->web_dokumen_model->delete($id)) {
            redirect_with('success', 'Berhasil menghapus dokumen.', $this->controller);
        } else {
            redirect_with('error', 'Gagal menghapus dokumen.', $this->controller);
        }
    }

    public function unduh($id = '')
    {
        // Cegah IDOR: Pastikan dokumen milik penduduk yang login
        if ($berkas = $this->web_dokumen_model->get_nama_berkas($id, $this->is_login->id_pend)) {
            // Cegah Directory Traversal pada nama berkas
            $berkas = basename($berkas);
            ambilBerkas($berkas, null, null, LOKASI_DOKUMEN);
        } else {
            redirect_with('error', 'Berkas dokumen tidak ditemukan atau Anda tidak memiliki akses.', $this->controller);
        }
    }

    /**
     * Validasi Form & Keamanan Berkas Dokumen (Anti-Hacking & Anti-Bypass)
     */
    private function validasi_form($is_ubah = false, $id = '')
    {
        $redirect_target = $is_ubah ? "{$this->controller}/form/{$id}" : "{$this->controller}/form";

        $nama      = trim($this->input->post('nama', true));
        $id_syarat = (int) $this->input->post('id_syarat', true);

        // 1. Cek Isian Wajib: Nama Dokumen
        if (empty($nama)) {
            redirect_with('error', 'Nama dokumen wajib diisi.', $redirect_target);
        }
        if (strlen($nama) < 3) {
            redirect_with('error', 'Nama dokumen terlalu pendek (minimal 3 karakter).', $redirect_target);
        }
        if (strlen($nama) > 150) {
            redirect_with('error', 'Nama dokumen terlalu panjang (maksimal 150 karakter).', $redirect_target);
        }

        // 2. Cek Isian Wajib: Jenis Dokumen
        if (empty($id_syarat)) {
            redirect_with('error', 'Silakan pilih Jenis Dokumen terlebih dahulu.', $redirect_target);
        }

        // Sanitasi nama dokumen (Cegah XSS & Injeksi Karakter Berbahaya)
        $_POST['nama'] = strip_tags($nama);

        // 3. Cek Berkas Dokumen
        $file_terunggah = !empty($_FILES['satuan']['name']) && $_FILES['satuan']['error'] === UPLOAD_ERR_OK;

        // Pada mode tambah, berkas file WAJIB ada
        if (!$is_ubah && !$file_terunggah) {
            // Cek apakah ada berkas dari kamera (base64) di input POST satuan
            $post_satuan = $this->input->post('satuan', true);
            if (empty($post_satuan) || !preg_match('/^data:image\/(jpeg|png);base64,/', $post_satuan)) {
                redirect_with('error', 'Berkas dokumen wajib diunggah atau diambil menggunakan kamera.', $redirect_target);
            }
        }

        // 4. Jika ada berkas fisik diunggah, lakukan Security Hardening Ketat
        if ($file_terunggah) {
            $this->security_check_file($_FILES['satuan'], $redirect_target);
        }
    }

    /**
     * Security Hardening Berkas: Cegah RCE, Webshell, Double Extension, Mime Spoofing, Malware
     */
    private function security_check_file($file, $redirect_target)
    {
        $filename   = strtolower($file['name']);
        $file_size  = (int) $file['size'];
        $tmp_name   = $file['tmp_name'];

        // A. Cek upload via HTTP POST
        if (!is_uploaded_file($tmp_name)) {
            redirect_with('error', 'Peringatan Keamanan: Berkas tidak valid.', $redirect_target);
        }

        // B. Cek Double Extension & Blacklist Ekstensi Berbahaya
        $dangerous_patterns = '/\.(php|phtml|php3|php4|php5|phps|phar|inc|pl|py|cgi|asp|aspx|jsp|exe|sh|bash|bat|cmd|js|vbs|htaccess|config)[\.\s]/i';
        if (preg_match($dangerous_patterns, $filename)) {
            redirect_with('error', 'Peringatan Keamanan: Format nama berkas berpotensi membahayakan sistem.', $redirect_target);
        }

        // C. Whitelist Ekstensi File
        $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
        $allowed_exts = ['jpg', 'jpeg', 'png', 'pdf'];
        if (!in_array($ext, $allowed_exts)) {
            redirect_with('error', 'Format berkas tidak diizinkan. Hanya mendukung file JPG, PNG, dan PDF.', $redirect_target);
        }

        // D. Whitelist MIME Type Asli (Cek Magic Bytes Menggunakan finfo)
        if (function_exists('finfo_open')) {
            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            $mime  = strtolower(finfo_file($finfo, $tmp_name));
            finfo_close($finfo);

            $allowed_mimes = [
                'jpg'  => ['image/jpeg', 'image/pjpeg'],
                'jpeg' => ['image/jpeg', 'image/pjpeg'],
                'png'  => ['image/png', 'image/x-png'],
                'pdf'  => ['application/pdf', 'application/x-pdf', 'application/acrobat', 'applications/vnd.pdf', 'text/pdf'],
            ];

            if (!isset($allowed_mimes[$ext]) || !in_array($mime, $allowed_mimes[$ext])) {
                redirect_with('error', 'Peringatan Keamanan: Tipe konten berkas (' . htmlspecialchars($mime) . ') tidak sesuai dengan format asli.', $redirect_target);
            }
        }

        // E. Cek Ukuran File Maksimal
        $max_size_bytes = (int) max_upload() * 1024 * 1024;
        if ($file_size > $max_size_bytes) {
            redirect_with('error', 'Ukuran berkas melebihi batas maksimal yang diperbolehkan (' . max_upload() . ' MB).', $redirect_target);
        }

        // F. Cek Polyglot Webshell (Pemeriksaan Script Embedded di dalam Berkas)
        $sample_content = file_get_contents($tmp_name, false, null, 0, 2048);
        if ($sample_content !== false) {
            if (preg_match('/(<\?php|<\?=|<script\b|eval\s*\(|base64_decode\s*\(|system\s*\(|shell_exec\s*\()/i', $sample_content)) {
                redirect_with('error', 'Peringatan Keamanan: Konten berkas terdeteksi mengandung skrip yang tidak diizinkan.', $redirect_target);
            }
        }
    }
}
