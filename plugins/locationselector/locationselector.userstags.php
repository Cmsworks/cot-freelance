<?php

/**
 * [BEGIN_COT_EXT]
 * Hooks=usertags.main
 * [END_COT_EXT]
 */
/**
 * Location Selector for Cotonti
 *
 * @package locationselector
 * @version 2.0.0
 * @author CMSWorks Team
 * @copyright Copyright (c) CMSWorks.ru, littledev.ru
 * @license BSD
 */
defined('COT_CODE') or die('Wrong URL.');

if(is_array($user_data)){
	if (function_exists('cot_getlocation'))
	{
		$location_info = cot_getlocation($user_data['user_country'], $user_data['user_region'], $user_data['user_city']);
		$temp_array['COUNTRY'] = $location_info['country'];
		$temp_array['REGION'] = $location_info['region'];
		$temp_array['CITY'] = $location_info['city'];
	}
	$temp_array['LOCATION_URL'] = cot_url('users', 'gm=' . $user_data['user_maingrp'] . '&country=' . $user_data['user_country'] . '&region=' . $user_data['user_region'] . '&city=' . $user_data['user_location']);
}