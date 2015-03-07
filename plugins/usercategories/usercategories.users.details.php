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

$t->assign('USERS_DETAILS_CATS', ($urr['user_cats']) ? cot_usercategories_tree(explode(',', $urr['user_cats']), '', 'list') : '');