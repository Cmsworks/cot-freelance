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
		
	$regions = array();
        if ($country != '0'){
            $regions = cot_getregions($country);
        }
		
	$region_selectbox = array(
            'regions' => array(0 => $L['select_region']) + $regions,
            'disabled' => (empty($country) || count($regions) == 0) ? 1 : 0,
        );
	echo json_encode($region_selectbox);
        exit;
}
else
{	
	$cities = (!empty($region)) ? cot_getcities($region) : array();
        $city_selectbox = array(
            'cities' => array(0 => $L['select_city']) + $cities,
            'disabled' => (!$region || count($cities) == 0) ? 1 : 0,
        );
		
	echo json_encode($city_selectbox);
        exit;
}
