<?php

/**
 * Location Selector for Cotonti
 *
 * @package locationselector
 * @version 2.0.0
 * @author CMSWorks Team
 * @copyright Copyright (c) CMSWorks.ru, littledev.ru
 * @license BSD
 */

defined('COT_CODE') or die('Wrong URL');

$t = new XTemplate(cot_tplfile('locationselector.country', 'plug'));

$jj = 0;

foreach ($cot_countries as $code => $name)
{
	$jj++;
	
	$flag = (!file_exists('images/flags/'.$code.'.png')) ? '00' : $code;
	$t->assign(array(
		"COUNTRY_ROW_CODE" => $code,
		"COUNTRY_ROW_NAME" => $name,
		"COUNTRY_ROW_URL" => cot_url('admin', 'm=other&p=locationselector&n=region&country=' . $code),
		"COUNTRY_ROW_FLAG" => cot_rc('icon_flag', array('code' => $flag, 'alt' => '')),
		"COUNTRY_ROW_NUM" => $jj,
		"COUNTRY_ROW_ODDEVEN" => cot_build_oddeven($jj)
	));

	$t->parse("MAIN.ROWS");
}
if($jj == 0)
{
	$t->parse("MAIN.NOROWS");
}
$t->parse("MAIN");
$plugin_body .= $t->text("MAIN");

?>