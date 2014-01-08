<?php

/**
 * [BEGIN_COT_EXT]
 * Hooks=users.details.first
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

$userstatus = (empty($urr['user_status'])) ? $cot_usercategories[$urr['user_cat']]['title'] : $urr['user_status'];
$out['subtitle'] = (!empty($userstatus)) ? $userstatus . ' - ' . $urr['user_fname'] . " " . $urr['user_sname'] : $urr['user_fname'] . " " . $urr['user_sname'];
$out['subtitle'] .= (!empty($tab)) ? ' - ' . $L['usercategories_tabs'][$tab] : '';
