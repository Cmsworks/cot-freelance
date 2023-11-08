<?php

defined('COT_CODE') or die('Wrong URL');


$ver_file_patch = 'datas/verification_image/';
$ver_file_patch_new = 'datas/verification_image/active_user/';
$ver_file_name  = $usr['id'].'-'.$usr['name'].'-';

$conf_dir_new = explode('/',$ver_file_patch_new);
$conf_dir_new = $conf_dir_new[(count($conf_dir_new) - 2)];
