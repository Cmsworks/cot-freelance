<?php

/**
 * [BEGIN_COT_EXT]
 * Hooks=projects.list.query
 * [END_COT_EXT]
 */
defined('COT_CODE') or die('Wrong URL.');

require_once cot_incfile('paypro', 'plug');

$forpro = cot_import('forpro', 'G', 'INT');

if(isset($forpro) && $forpro == 1)
{
	$where['forpro'] = 'item_forpro='.$forpro;
}