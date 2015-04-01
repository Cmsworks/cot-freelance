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

if(is_array($user_data)){
	$temp_array['CATS'] = ($user_data['user_cats']) ? explode(',', $user_data['user_cats']) : '';
}