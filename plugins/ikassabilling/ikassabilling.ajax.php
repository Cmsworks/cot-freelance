<?php

/**
 * [BEGIN_COT_EXT]
 * Hooks=ajax
 * [END_COT_EXT]
 */
/**
 * Ikassa billing Plugin
 *
 * @package ikassabilling
 * @version 2.0
 * @author CMSWorks Team
 * @copyright Copyright (c) CMSWorks.ru
 * @license BSD
 */
defined('COT_CODE') or die('Wrong URL');

require_once cot_incfile('payments', 'module');

if($_SERVER['REQUEST_METHOD'] == 'POST' && $cfg['plugin']['ikassabilling']['enablepost'])
{
	$status_data = $_POST;
}	
else
{	
	$status_data = $_GET;
}	

$dataSet = array();
foreach ($status_data as $key => $value)
{
	if (!preg_match('/ik_/', $key))
	continue;
	$dataSet[$key] = $value;
}

$ik_sign = $dataSet['ik_sign'];
unset($dataSet['ik_sign']);

if ($dataSet['ik_pw_via'] == 'test_interkassa_test_xts')
{
	$key = $cfg['plugin']['ikassabilling']['test_key'];
}
else
{
	$key = $cfg['plugin']['ikassabilling']['secret_key'];
}

ksort($dataSet, SORT_STRING);
array_push($dataSet, $key);
$signString = implode(':', $dataSet); 
$sign = base64_encode(md5($signString, true)); 

if(!empty($dataSet['ik_pm_no']))
{
	$payinfo = cot_payments_payinfo($dataSet['ik_pm_no']);
}

if ($ik_sign === $sign 
	&& $dataSet['ik_inv_st'] == 'success'	
	&& $dataSet['ik_co_id'] == $cfg['plugin']['ikassabilling']['shop_id'])
{
	if(cot_payments_updatestatus($dataSet['ik_pm_no'], 'paid'))
	{
		header ( 'HTTP/1.1 200' );
	}
	else
	{
		header ( 'HTTP/1.1 302' );
	}
}
else
{
	header ( 'HTTP/1.1 302' );
}
