<?php

/**
 * mavatars for Cotonti CMF
 *
 * @version 1.00
 * @author	esclkm
 * @copyright (c) 2013 esclkm
 */
defined('COT_CODE') or die('Wrong URL');

$ext = cot_import('ext', 'G', 'TXT');
$cat = cot_import('cat', 'G', 'TXT');
$code = cot_import('code', 'G', 'TXT');

$mavatar = new mavatar($ext, $cat, $code, 'edit');

$array = $mavatar->ajax_upload();

echo(json_encode($array));

// Define a destination