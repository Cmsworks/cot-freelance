<?php

/**
 * [BEGIN_COT_EXT]
 * Hooks=usertags.main
 * [END_COT_EXT]
 */
/**
 * UserPoints plugin
 *
 * @package userpoints
 * @version 2.0.0
 * @author CMSWorks Team
 * @copyright Copyright (c) CMSWorks.ru, littledev.ru
 * @license BSD
 */
defined('COT_CODE') or die('Wrong URL.');

if(is_array($user_data)){
	$temp_array['USERPOINTS'] = number_format($user_data['user_userpoints'], '1', '.', ' ');
}