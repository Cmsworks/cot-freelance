<?php

/**
 * mavatars for Cotonti CMF
 *
 * @version 1.00
 * @author	esclkm
 * @copyright (c) 2013 esclkm
 */
defined('COT_CODE') or die('Wrong URL');

/* @var $db CotDB */
/* @var $cache Cache */
/* @var $t Xtemplate */

$id = cot_import('id', 'G', 'INT');
$h = cot_import('h', 'G', 'INT');
$w = cot_import('w', 'G', 'INT');
$method = cot_import('method', 'G', 'TXT');

cot_block((int)$id > 0);

$h = empty($h) ? (int)$cfg['plugin']['mavatars']['height'] : (int)$h;
$w = empty($w) ? (int)$cfg['plugin']['mavatars']['width'] : (int)$w;
$method = empty($method) ? $cfg['plugin']['mavatars']['method'] : $method;

$h = empty($h) ? 640 : (int)$h;
$w = empty($w) ? 640 : (int)$w;
$method = empty($method) ? 'width' : $method;



$sql = $db->query("SELECT * FROM $db_mavatars WHERE mav_id=".(int)$id." LIMIT 1");


$t = new XTemplate(cot_tplfile(array('mavatars', 'show'), 'plug'));
if ($mav_row = $sql->fetch())
{
	$i++;
	$mavatar = array();
	foreach ($mav_row as $key => $val)
	{
		$keyx = str_replace('mav_', '', $key);
		if ($keyx == 'filepath' || $keyx == 'thumbpath')
		{
			$val .= (substr($val, -1) == '/') ? '' : '/';
		}
		$mavatar[$keyx] = $val;
	}
	$out['subtitle'] = $mavatar['desc'];
	$mavatar['file'] = $mavatar['filepath'].$mavatar['filename'].'.'.$mavatar['fileext'];
	$t->assign(array(
		'IMG' => cot_mav_thumb($mavatar, $w, $h, $method),
		'DESC' => $mavatar['desc'],
		'FILE' => $mavatar['file']
		));
	
	/* === Hook === */
	foreach (cot_getextplugins('mavatars.show.tags') as $pl)
	{
		include $pl;
	}
	/* ===== */
	
}
else
{
	cot_die();
}

