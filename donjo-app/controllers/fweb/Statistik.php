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
}
