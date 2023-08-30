<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['default_controller'] = 'auth';
$route['login'] = 'auth';
$route['logout'] = 'auth/logout';
$route['home'] = 'dashboard/home';
$route['simpan-data'] = 'dashboard/save_akumulatif';
$route['pengangguran'] = 'dashboard/data_pengangguran';
$route['pendidikan'] = 'dashboard/data_pendidikan';
$route['masyarakat'] = 'dashboard/data_masyarakat';
$route['perbandingan'] = 'dashboard/data_perbandingan';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
