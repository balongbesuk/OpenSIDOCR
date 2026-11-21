<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

$tema_config_file = dirname(__DIR__) . '/config_desa.php';
$tema_config = is_file($tema_config_file) ? include $tema_config_file : [];
$disqus_shortname = is_array($tema_config) ? trim((string) ($tema_config['disqus_shortname'] ?? '')) : '';
