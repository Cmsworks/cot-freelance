<?php

/**
 * [BEGIN_COT_EXT]
 * Hooks=projects.addofferform.main
 * [END_COT_EXT]
 */
defined('COT_CODE') or die('Wrong URL.');

require_once cot_incfile('paypro', 'plug');

if (!cot_getuserpro() && $item['item_userid'] != $usr['id'] && !$usr['isadmin'])
{
	if ($cfg['plugin']['paypro']['offerslimit'] > 0)
	{
		$countoffersofuser = cot_getcountoffersofuser($usr['id']);
		if ($countoffersofuser >= $cfg['plugin']['paypro']['offerslimit'])
		{
			$addoffer_enabled = false;
			$t_o->parse("MAIN.OFFERSLIMITEMPTY");
		}
	}
	
	if($item['item_forpro'])
	{
		$addoffer_enabled = false;
		$t_o->parse("MAIN.PROJECTFORPRO");
	}
}
