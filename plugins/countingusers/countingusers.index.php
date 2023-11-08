<?php
/* ====================
[BEGIN_COT_EXT]
Hooks=index.tags
Tags=index.tpl:{INDEX_COUNTER_TAG}
[END_COT_EXT]
==================== */
/**
 * countinguser
 *
 * @package countinguser
 * @version 0.4
 * @author CrazyFreeMan
 * @copyright Copyright (c) CrazyFreeMan 2014
 * @license BSD
 */
defined('COT_CODE') or die('Wrong URL');

if (cot_plugin_active('countingusers')) {

require_once cot_incfile('countingusers', 'plug');

$result = get_count_of();

$t1 = new XTemplate(cot_tplfile('countingusers.index', 'plug'));

$arr = array();
foreach($result as $counter =>$next_lvl_arr)
{
	foreach ($next_lvl_arr as $key => $value) {
		$arr["INDEX_COUNT_".$counter."_".$key] = $value;			
	}	
}
$t1->assign($arr);
$t1->parse('MAIN');
$t->assign('INDEX_COUNTER_TAG', $t1->text('MAIN'));
}