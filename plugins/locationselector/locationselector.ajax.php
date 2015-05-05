<?php

/**
 * [BEGIN_COT_EXT]
 * Hooks=ajax
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


$country = cot_import('country', 'R', 'TXT');
$region = cot_import('region', 'R', 'INT');

cot_sendheaders();
if(isset($_REQUEST['country']))
{
	$regions = (!empty($country)) ? cot_getregions($country) : array();
	$regions = array(0 => $L['select_region']) + $regions;
	$disabled = (empty($country) || count($regions) < 2) ? 'disabled="disabled" ' : '';
	$region_selectbox = cot_selectbox($regions, 'region', array_keys($regions), array_values($regions), 
		false, $disabled . 'class="locselectregion form-control" id="locselectregion"');

	echo $region_selectbox;
}
else
{
	$cities = (!empty($region)) ? cot_getcities($region) : array();
	$cities = array(0 => $L['select_city']) + $cities;
	$disabled = (empty($region) || count($cities) < 2) ? 'disabled="disabled" ' : '';
	$city_selectbox = cot_selectbox($regions, 'city', array_keys($cities), array_values($cities), 
		false, $disabled . 'class="locselectcity form-control" id="locselectcity"');	
	
	echo $city_selectbox;
}
