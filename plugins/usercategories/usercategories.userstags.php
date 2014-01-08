<?php

/**
 * [BEGIN_COT_EXT]
 * Hooks=usertags.main
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

global $cot_usercategories, $db_usercategories_users;
$temp_array['URL'] = cot_url('users', 'm=details&id=' . $user_data['user_id'] . '&u=' . $user_data['user_name']);
$temp_array['CATTITLE'] = $cot_usercategories[$user_data['user_cat']]['title'];

$cats = $db->query("SELECT ucat_cat FROM $db_usercategories_users WHERE ucat_userid=" . (int) $user_data['user_id'])->fetchAll();
$cats = (is_array($cats)) ? $cats : array();
$ruc_cattree = array();
foreach ($cats as $key => $cat)
{
	$ruc_cattree[] = $cat['ucat_cat'];
}

$temp_array['CATS'] = cot_usercategories_lighttree($ruc_cattree);
