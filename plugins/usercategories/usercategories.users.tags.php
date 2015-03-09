<?php

/**
 * [BEGIN_COT_EXT]
 * Hooks=users.tags
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

$t->assign(array(
	'SEARCH_CAT' => cot_usercategories_selectcat($cat, 'cat'),
	'USERCATEGORIES_CATALOG' => cot_usercategories_tree($cat),
	'CATTITLE' => (!empty($cat)) ? $structure['usercategories'][$cat]['title'] : '',
	'CATDESC' => (!empty($cat)) ? $structure['usercategories'][$cat]['desc'] : ''
));
