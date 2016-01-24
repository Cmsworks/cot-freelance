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
$id = cot_import('id', 'G', 'INT');
$width = cot_import('width', 'G', 'INT');
$height = cot_import('height', 'G', 'INT');
$resize = cot_import('resize', 'G', 'TXT');
$filter = cot_import('filter', 'G', 'TXT');
$quality = cot_import('quality', 'G', 'INT');



if(empty($quality))
{
	$quality = 85;
}
if(empty($resize))
{
	$resize = 'crop';
}
$mavatar = new mavatar($ext, $cat, $code, '', $id);
$mavatars_tags = $mavatar->tags();


$image = $mavatar->thumb($mavatars_tags[1], $width, $height, $resize, $filter, $quality);

header('Content-Type: image/jpeg');

readfile($image);
exit();