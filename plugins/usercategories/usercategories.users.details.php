<?php

/**
 * [BEGIN_COT_EXT]
 * Hooks=users.details.tags
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

// Вледение навыками по категориям
$cats = $db->query("SELECT ucat_cat FROM $db_usercategories_users WHERE ucat_userid=" . (int) $urr['user_id'])->fetchAll();
$cats = (is_array($cats)) ? $cats : array();
$ruc_cattree = array();
foreach ($cats as $key => $cat)
{
	$ruc_cattree[] = $cat['ucat_cat'];
}

$t->assign(array(
	'FREELANCER_CATEGORY_TREE' => cot_usercategories_treecheck($ruc_cattree, 'ruc_cattree', '', false),
	'FREELANCER_CATEGORY_LIST' => cot_usercategories_lighttree($ruc_cattree),
));
