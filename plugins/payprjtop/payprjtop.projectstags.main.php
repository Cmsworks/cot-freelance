<?php
/**
 * [BEGIN_COT_EXT]
 * Hooks=projectstags.main
 * [END_COT_EXT]
 */

defined('COT_CODE') or die('Wrong URL.');

require_once cot_incfile('payprjtop', 'plug');

if($item_data['item_top'] > $sys['now'])
{
	$temp_array['PAYTOP'] = sprintf($L['payprjtop_buy_prodlit'], date('d.m.Y H:i',$item_data['item_top']), cot_url('plug', 'e=payprjtop&id='.$item_data['item_id']));
	$temp_array['TOP'] = $item_data['item_top'];
	$temp_array['ISTOP'] = 1;
}
else
{
	if($item_data['item_top'] > 0)
	{
		$db->query("UPDATE $db_projects SET item_top=0 WHERE item_id=".$item_data['item_id']);
	}
	
	$temp_array['PAYTOP'] = cot_rc_link(cot_url('plug', 'e=payprjtop&id='.$item_data['item_id']), $L['payprjtop_buy_title']);
	$temp_array['TOP'] = 0;
	$temp_array['ISTOP'] = 0;
}
	
?>