<?php

/**
 * [BEGIN_COT_EXT]
 * Hooks=users.main
 * [END_COT_EXT]
 */
defined('COT_CODE') or die('Wrong URL.');

if (!empty($cfg['usercategories']['cat_' . $cat]['keywords']))
{
	$out['keywords'] = $cfg['usercategories']['cat_' . $cat]['keywords'];
}
if (!empty($cfg['usercategories']['cat_' . $cat]['metadesc']))
{
	$out['desc'] = $cfg['usercategories']['cat_' . $cat]['metadesc'];
}
if (!empty($cfg['usercategories']['cat_' . $cat]['metatitle']))
{
	$out['subtitle'] = $cfg['usercategories']['cat_' . $cat]['metatitle'];
}