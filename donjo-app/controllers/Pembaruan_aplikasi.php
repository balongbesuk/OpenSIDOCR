<?php

use App\Libraries\GitHubUpdater;

defined('BASEPATH') || exit('No direct script access allowed');

class Pembaruan_aplikasi extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();

        // Hanya Administrator yang berhak mengakses fitur pembaruan
        if (! is_admin()) {
            if ($this->input->is_ajax_request()) {
                json(['status' => false, 'message' => 'Akses ditolak. Fitur ini hanya untuk Administrator.'], 403);
            }
            redirect('hom_sid');
        }
    }

    /**
     * Cek status pembaruan ke GitHub
     */
    public function cek()
    {
        try {
            $info = GitHubUpdater::checkUpdate();

            return json([
                'status' => true,
                'data'   => $info,
            ]);
        } catch (\Throwable $e) {
            return json([
                'status'  => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Eksekusi proses pembaruan aplikasi
     */
    public function proses()
    {
        if ($this->input->method() !== 'post') {
            return json(['status' => false, 'message' => 'Metode request tidak diizinkan.'], 405);
        }

        try {
            $result = GitHubUpdater::updateNow();

            return json($result);
        } catch (\Throwable $e) {
            return json([
                'status'  => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}
