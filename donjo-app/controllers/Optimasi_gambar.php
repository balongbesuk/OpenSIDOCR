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

class Optimasi_gambar extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->modul_ini          = 'pengaturan';
        $this->sub_modul_ini      = 'optimasi-gambar';
        $this->header['kategori'] = 'Optimasi';
    }

    public function index()
    {
        $judul   = 'Optimasi Gambar';
        $folders = $this->get_folders(LOKASI_UPLOAD);

        return view('admin.optimasi_gambar.index', compact('folders'));
    }

    public function get_image(...$dirs)
    {
        $dir    = ! empty($dirs) ? implode('/', $dirs) : null;
        $base   = rtrim(LOKASI_UPLOAD, '/\\') . DIRECTORY_SEPARATOR;
        $target = $dir ? $base . str_replace(['/', '\\'], DIRECTORY_SEPARATOR, $dir) : $base;

        $files = collect();
        if (is_dir($target)) {
            $iterator = new RecursiveIteratorIterator(
                new RecursiveDirectoryIterator($target, RecursiveDirectoryIterator::SKIP_DOTS),
                RecursiveIteratorIterator::SELF_FIRST
            );

            foreach ($iterator as $item) {
                if ($item->isFile()) {
                    $file_path  = str_replace('\\', '/', $item->getPathname());
                    $image_size = @getimagesize($file_path);
                    if ($image_size !== false && ($image_size[0] > 880 || $image_size[1] > 880)) {
                        $files->push($file_path);
                    }
                }
            }
        }

        return json([
            'status' => true,
            'data'   => $files,
        ]);
    }

    public function get_folders($path, $relative = '', $depth = 0)
    {
        $folders = collect();
        $base    = rtrim($path, '/\\') . DIRECTORY_SEPARATOR;
        $current = $relative ? $base . str_replace(['/', '\\'], DIRECTORY_SEPARATOR, $relative) : $base;

        if (! is_dir($current)) {
            return $folders;
        }

        $items = array_diff(scandir($current), ['.', '..']);
        natcasesort($items);

        foreach ($items as $item) {
            $item_path = $current . DIRECTORY_SEPARATOR . $item;
            if (is_dir($item_path)) {
                $sub_relative = $relative ? $relative . '/' . $item : $item;
                $folders->push([
                    'path'   => $sub_relative,
                    'name'   => $item,
                    'depth'  => $depth,
                    'parent' => $relative,
                ]);
                $folders = $folders->merge($this->get_folders($path, $sub_relative, $depth + 1));
            }
        }

        return $folders;
    }

    public function resize()
    {
        try {
            $request = $this->input->post();
            ResizeGambar($request['file'], $request['file'], ['width' => 880, 'height' => 880]);
        } catch (Exception $e) {
            return json([
                'status'  => false,
                'message' => $e->getMessage(),
            ]);
        }

        return json([
            'status'  => true,
            'message' => 'berhasil',
        ]);
    }
}

// End of file Optimasi_gambar.php
// Location: .//D/kerjoan/web/opendesa/premium/donjo-app/controllers/Optimasi_gambar.php
