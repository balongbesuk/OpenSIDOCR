<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

$tema_config_file = FCPATH . $folder_themes . '/config_desa.php';
$tema_config = is_file($tema_config_file) ? (array) include $tema_config_file : [];
$disqus_shortname = trim((string) ($tema_config['disqus_shortname'] ?? ''));
