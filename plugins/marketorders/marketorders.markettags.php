<?php

/**
 * [BEGIN_COT_EXT]
 * Hooks=markettags.main
 * [END_COT_EXT]
 */

/**
 * marketorders plugin
 *
 * @package marketorders
 * @version 1.0.0
 * @author CMSWorks Team
 * @copyright Copyright (c) CMSWorks.ru
 * @license BSD
 */

defined('COT_CODE') or die('Wrong URL');

global $db_market_orders;

$key = cot_import('key', 'G', 'TXT');

$marketorder = $db->query("SELECT * FROM $db_market_orders  AS o
	LEFT JOIN $db_market AS m ON m.item_id=o.order_pid
	WHERE order_pid=".$item_data['item_id']." AND order_status!='new' AND order_userid=".$usr['id']." LIMIT 1")->fetch();

if(!empty($key)){
	$hash = sha1($marketorder['order_email'].'&'.$marketorder['order_id']);
}
if ($marketorder && ($usr['id'] > 0 || $usr['id'] == 0 && !empty($key) && $key == $hash)){
	$temp_array['ORDER_ID'] = $marketorder['order_id'];
	$temp_array['ORDER_URL'] = cot_url('marketorders', 'id='.$marketorder['order_id'].'&key='.$key);
	$temp_array['ORDER_COUNT'] = $marketorder['order_count'];
	$temp_array['ORDER_COST'] = $marketorder['order_cost'];
	$temp_array['ORDER_TITLE'] = $marketorder['order_title'];
	$temp_array['ORDER_COMMENT'] = $marketorder['order_text'];
	$temp_array['ORDER_EMAIL'] = $marketorder['order_email'];
	$temp_array['ORDER_PAID'] = $marketorder['order_paid'];
	$temp_array['ORDER_DONE'] = $marketorder['order_done'];
	$temp_array['ORDER_STATUS'] = $marketorder['order_status'];
	$temp_array['ORDER_DOWNLOAD'] = (in_array($marketorder['order_status'], array('paid', 'done')) && !empty($marketorder['item_file']) && file_exists($cfg['plugin']['marketorders']['filepath'].'/'.$marketorder['item_file'])) ? cot_url('plug', 'r=marketorders&m=download&id='.$marketorder['order_id'].'&key='.$key) : '';
	$temp_array['ORDER_LOCALSTATUS'] = $L['marketorders_status_'.$marketorder['order_status']];
	$temp_array['ORDER_WARRANTYDATE'] = $marketorder['order_paid'] + $cfg['plugin']['marketorders']['warranty']*60*60*24;
}