<?php

/**
 * [BEGIN_COT_EXT]
 * Hooks=global
 * [END_COT_EXT]
 */
/**
 * User Categories plugin
 *
 * @package usercategories
 * @version 2.5.0
 * @author CMSWorks Team
 * @copyright Copyright (c) CMSWorks.ru, littledev.ru
 * @license BSD
 */
defined('COT_CODE') or die('Wrong URL.');

require_once cot_incfile('usercategories', 'plug');

if (!$cot_usercategories)
{
	$cot_usercategories = cot_usercategories_load();
	$cache && $cache->db->store('cot_fcat', $cot_usercategories, COT_DEFAULT_REALM, 3600);
}
