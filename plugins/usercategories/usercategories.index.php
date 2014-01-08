<?php

/**
 * [BEGIN_COT_EXT]
 * Hooks=index.tags
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
	'USERCATEGORIES_CATALOG' => cot_usercategories_tree()
));
